<?php

namespace App\BusinessLogicLayer\Resource;

use App\Models\Resource\Resource;
use App\Repository\Resource\ResourceRepository;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ResourceFileManager {
    private $IMG_FOLDER;

    private $AUDIO_FOLDER;

    private $PDF_FOLDER;

    private $RESOURCE_PREFIX_FOLDER;

    private array $SUPPORTED_FILE_TYPES = ['audio', 'image', 'pdf'];

    protected ResourceRepository $resourceRepository;

    public function __construct() {
        $this->IMG_FOLDER = getenv('IMG_FOLDER ') ?: 'img/';
        $this->AUDIO_FOLDER = getenv('AUDIO_FOLDER ') ?: 'audio/';
        $this->PDF_FOLDER = getenv('PDF_FOLDER ') ?: 'pdf/';
        $this->RESOURCE_PREFIX_FOLDER = getenv('RESOURCE_PREFIX_FOLDER') ?: 'resources/';
    }

    public function deleteResourceImage(Resource $resource) {
        Storage::disk('public')->delete($resource->img_path);
    }

    public function deleteResourcePdf(Resource $resource) {
        Storage::disk('public')->delete($resource->pdf_path);
    }

    public function deleteResourceAudio(Resource $resource) {
        echo $resource->audio_path;
        Storage::disk('public')->delete($resource->audio_path);
    }

    public function keepLatinCharactersAndNumbersString($string) {
        $newString = preg_replace("/[^A-Za-z0-9.!?\-()]/", '', $string);

        return $newString;
    }

    public function getResourceFileWithoutExtension($string) {
        return pathinfo($string)['filename'];
    }

    public function getNormalizedResourceName($resource, $id) {
        $resourceFullName = $resource->getClientOriginalName();
        $resourceNameWithoutExtension = $this->getResourceFileWithoutExtension($resourceFullName);
        $resourceNameCleaned = $this->keepLatinCharactersAndNumbersString($resourceNameWithoutExtension);

        return $id . '_' . $resourceNameCleaned . '_' . date('Y-m-d_h_i_s', time()) . '.' . $resource->getClientOriginalExtension();
    }

    /**
     * @throws FileNotFoundException
     */
    public function saveAudio($id, Request $request): ?string {
        $contentAudio = $request->file('sound');
        if (!$contentAudio) {
            throw(new FileNotFoundException('Audio missing'));
        }
        $audioFolder = $this->getResourceFileFolder('audio');
        $normalizedAudioName = $this->getNormalizedResourceName($contentAudio, $id);
        $contentAudio->storeAs($audioFolder, $normalizedAudioName, ['disk' => 'public']);

        return $this->getResourceFullPath($normalizedAudioName, 'audio');
    }

    /**
     * @throws FileNotFoundException
     */
    public function saveImage($id, Request $request): ?string {
        $contentImage = $request->file('image');
        if (!$contentImage) {
            throw(new FileNotFoundException('Image missing'));
        }
        $imageFolder = $this->getResourceFileFolder('image');
        $normalizedImageName = $this->getNormalizedResourceName($contentImage, $id);
        $contentImage->storeAs($imageFolder, $normalizedImageName, ['disk' => 'public']);

        return $this->getResourceFullPath($normalizedImageName, 'image');
    }

    /**
     * @throws FileNotFoundException
     */
    public function savePdf($id, Request $request): ?string {
        $contentPdf = $request->file('pdf');
        if (!$contentPdf) {
            throw(new FileNotFoundException('Pdf missing'));
        }
        $pdfFolder = $this->getResourceFileFolder('pdf');
        $normalizedPdfName = $this->getNormalizedResourceName($contentPdf, $id);
        $contentPdf->storeAs($pdfFolder, $normalizedPdfName, ['disk' => 'public']);

        return $this->getResourceFullPath($normalizedPdfName, 'pdf');
    }

    public function getResourceFullPath($name, $type): ?string {
        assert(in_array($type, $this->SUPPORTED_FILE_TYPES));
        if ($type == 'audio') {
            return $this->getResourceFileAudioPath($name);
        } elseif ($type == 'image') {
            return $this->getResourceFileImagePath($name);
        } elseif ($type == 'pdf') {
            return $this->getResourceFilePdfPath($name);
        }
    }

    public function getResourceFileFolder($type): ?string {
        assert(in_array($type, $this->SUPPORTED_FILE_TYPES));
        if ($type == 'audio') {
            return $this->getResourceAudioFolder();
        } elseif ($type == 'image') {
            return $this->getResourceImageFolder();
        } elseif ($type == 'pdf') {
            return $this->getResourcePdfFolder();
        }
    }

    public function getResourceFileAudioPath($name): string {
        return $this->getResourceAudioFolder() . $name;
    }

    public function getResourceFileImagePath($name): string {
        return $this->getResourceImageFolder() . $name;
    }

    public function getResourceFilePdfPath($name): string {
        return $this->getResourcePdfFolder() . $name;
    }

    public function getResourceImageFolder(): string {
        return $this->RESOURCE_PREFIX_FOLDER . $this->IMG_FOLDER;
    }

    public function getResourceAudioFolder(): string {
        return $this->RESOURCE_PREFIX_FOLDER . $this->AUDIO_FOLDER;
    }

    public function getResourcePdfFolder(): string {
        return $this->RESOURCE_PREFIX_FOLDER . $this->PDF_FOLDER;
    }

    public function copyResourceToDirectory($directory, $name, $type) {
        copy(storage_path('app/public') . '/' . $this->getResourceFullPath($name, $type), $directory . '/' . $name);
    }

    public function getExtension($path) {
        return pathinfo($path)['extension'];
    }

    public function getCloneUniqueName($name): string {
        $extension = $this->getExtension($name);
        $nameNoExtension = $this->getResourceFileWithoutExtension($name);
        $pieces = explode('_', $nameNoExtension);
        array_splice($pieces, 2, count($pieces));
        $newName = implode('_', $pieces);
        $newName = $newName . '_' . date('Y-m-d_h_i_s', time()) . '.' . $extension;

        return $newName;
    }

    public function cloneResourceToDirectory($name, $type): string {
        $dir = $this->getResourceFileFolder($type);
        $source = storage_path('app/public') . '/' . $this->getResourceFullPath($name, $type);
        $newResourcePath = $dir . $this->getCloneUniqueName($name);
        $target = storage_path('app/public') . '/' . $newResourcePath;
        copy($source, $target);

        return $newResourcePath;
    }

    public function addDir($zip, $path) {
        $zip->addEmptyDir(basename($path));
        $nodes = glob($path . '/*');
        foreach ($nodes as $node) {
            //print $node . '<br>';
            if (is_dir($node)) {
                $zip = $this->addDir($zip, $node);
            } elseif (is_file($node)) {
                $zip->addFile($node, basename($path) . '/' . basename($node));
            }
        }

        return $zip;
    }

    public function getCreateZip($directory): ZipArchive {
        $zip = new ZipArchive;
        $zipPath = $directory . '.zip';
        if ($zip->open($zipPath, ZipArchive::CREATE) === true) {
            $zip = $this->addDir($zip, $directory);
            $zip->close();
        }

        return $zip;
    }
}
