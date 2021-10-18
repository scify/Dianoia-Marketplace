<?php


namespace Database\Seeders;


use App\Repository\ContentLanguageLkpRepository;
use Illuminate\Database\Seeder;

class ContentLanguageLkpSeeder extends Seeder {

    protected ContentLanguageLkpRepository $contentLanguageLkpRepository;

    public function __construct(ContentLanguageLkpRepository $contentLanguageLkpRepository) {
        $this->contentLanguageLkpRepository = $contentLanguageLkpRepository;
    }


    public function run() {
        echo "\nRunning Content Language lkp Seeder...\n";

        $data = [
            ['id' => 1, 'name' => 'Ελληνικά', 'code' => 'el', 'img_path' => '/img/lang/el.png'],
            ['id' => 2, 'name' => 'English', 'code' => 'en', 'img_path' => '/img/lang/en.png'],
            ['id' => 3, 'name' => 'Spanish', 'code' => 'sp', 'img_path' => '/img/lang/sp.png'],
            ['id' => 3, 'name' => 'Italian', 'code' => 'it', 'img_path' => '/img/lang/sp.png']
        ];

        foreach ($data as $datum) {
            $lang = $this->contentLanguageLkpRepository->updateOrCreate(['id' => $datum['id']], $datum);
            echo "\nAdded Content Language: " . $lang->name . "\n";
        }
    }
}
