<?php


namespace App\BusinessLogicLayer\Resource;


use App\Models\Resource\Resource;
use App\Repository\ContentLanguageLkpRepository;
use App\Repository\DifficultiesLkpRepository;
use App\Repository\Resource\ResourceRepository;
use App\Repository\Resource\ResourceStatusesLkp;
use App\Repository\Resource\ResourceTypeLkpRepository;
use App\Repository\Resource\ResourceTypesLkp;
use App\ViewModels\CreateEditResourceVM;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceManager {

    protected ResourceRepository $resourceRepository;
    protected ContentLanguageLkpRepository $contentLanguageLkpRepository;
    protected DifficultiesLkpRepository $difficultiesLkpRepository;
    protected ResourceTypesLkp $resourceTypesLkp;
    protected ResourceTypeLkpRepository $resourceTypeLkpRepository;

    public function __construct(ResourceRepository $resourceRepository,
                                ContentLanguageLkpRepository  $contentLanguageLkpRepository,
                                DifficultiesLkpRepository $difficultiesLkpRepository,
                                ResourceTypeLkpRepository $resourceTypeLkpRepository
    ) {
        $this->resourceRepository = $resourceRepository;
        $this->contentLanguageLkpRepository = $contentLanguageLkpRepository;
        $this->difficultiesLkpRepository = $difficultiesLkpRepository;
        $this->resourceTypeLkpRepository = $resourceTypeLkpRepository;
    }


    public function getCreateResourcesViewModel(array $resource_params = []): CreateEditResourceVM {
        $contentLanguages = $this->getContentLanguagesForResources();
        $difficulties = $this->getDifficultiesForResources();
        $types = $this->getResourceTypes();
        return new CreateEditResourceVM(
            $contentLanguages, $difficulties, $types, new  Resource($resource_params), -1
        );
    }

    public function getResourceTypes()
    {
        return $this->resourceTypeLkpRepository->all();
    }


    public function getDifficultiesForResources()
    {
        return $this->difficultiesLkpRepository->all();
    }


    public function getContentLanguagesForResources()
    {
        return $this->contentLanguageLkpRepository->all();
    }



    public function getResource($id){
        return $this->resourceRepository->find($id);
    }


    /**
     * @throws FileNotFoundException
     */
    public function storeResource(Request $request)
    {
        $storeArr = [
            'name' => $request['name'],
            'lang_id' =>  $request['lang'],
            'img_path' => null,
            'pdf_path' => null,
            'type_id' => $request['type_id'],
            'difficulty_id' => $request['difficulty_id'],
            'status_id' =>   ResourceStatusesLkp::CREATED_PENDING_APPROVAL,
            'creator_user_id' => Auth::id(),
            'admin_user_id' => null
        ];

        $resource = $this->resourceRepository->create($storeArr);
        $resourceFileManager = new ResourceFileManager();
        $img_path = $resourceFileManager->saveImage($resource->id, $request);
        try{
            $pdf_path = $resourceFileManager->savePdf($resource->id, $request);
        }
        catch(FileNotFoundException $e){
            $pdf_path = null;
        }


        return $this->resourceRepository->update([
            'img_path' => $img_path,
            'pdf_path' => $pdf_path],
            $resource->id);

    }


    public function updateResource($request, $id)
    {
        $storeArr = [
            "name" => $request['name'],
//            "lang_id" => $request['lang'],
            "img_path" => null,
            "audio_path" => null,
//            'type_id' => ResourceTypesLkp::COMMUNICATION,
//            'status_id' => ResourceStatusesLkp::CREATED_PENDING_APPROVAL,
//            'resource_parent_id' => $request->parentId ? intval($request->parentId) : null,
            'creator_user_id' => Auth::id(),
            'admin_user_id' => null
        ];
        $old_resource = $this->resourceRepository->find($id);
        $storeArr['img_path'] = $old_resource['img_path'];
        $storeArr['audio_path'] = $old_resource['audio_path'];
        $resource = $this->resourceRepository->update($storeArr, $id);
        $resourceFileManager = new ResourceFileManager();
        if (isset($request['image'])) {
            $resourceFileManager->deleteResourceImage($old_resource);
            $img_path = $resourceFileManager->saveImage($resource->id, $request);
            $resource = $this->resourceRepository->update([
                'img_path' => $img_path],
                $resource->id);
        }
        if (isset($request['sound'])) {
            $resourceFileManager->deleteResourceAudio($old_resource);
            $audio_path = $resourceFileManager->saveAudio($resource->id, $request);
            $resource = $this->resourceRepository->update([
                'audio_path' => $audio_path],
                $resource->id);
        }

        return $resource;


    }


    public function destroyResource($id)
    {
        $resource = $this->resourceRepository->find($id);
        $resourceFileManager = new ResourceFileManager();
        $resourceFileManager->deleteResourceAudio($resource);
        $resourceFileManager->deleteResourceImage($resource);
        $this->resourceRepository->delete($id);
    }

    public function cloneResource($id, $newParentId){
        $resource = $this->resourceRepository->find($id);
        $fileManager = new ResourceFileManager();
        $storeArr = [
            "name" =>  $resource->name,
            "img_path" => $fileManager->cloneResourceToDirectory(basename($resource->img_path), "image"),
            "audio_path" => $resource->audio_path ? $fileManager->cloneResourceToDirectory(basename($resource->audio_path), "audio") : null,
            'resource_parent_id' => $newParentId ?: null,
            'creator_user_id' => Auth::id(),
            'admin_user_id' => null,
        ];
        return $this->resourceRepository->create($storeArr);
    }

}
