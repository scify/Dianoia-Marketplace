<?php


namespace Database\Seeders;


use App\Repository\ContentLanguageLkpRepository;
use App\Repository\DifficultiesLkpRepository;
use Illuminate\Database\Seeder;

class DifficultiesLkpSeeder extends Seeder {

    protected DifficultiesLkpRepository $difficultiesLkpRepository;

    public function __construct(DifficultiesLkpRepository $difficultiesLkpRepository) {
        $this->difficultiesLkpRepository = $difficultiesLkpRepository;
    }


    public function run() {
        echo "\nRunning Difficulties lkp Seeder...\n";

        $data = [
            ['id' => 1, 'name' => 'Εύκολης Δυσκολίας', 'code' => 'EASY'],
            ['id' => 2, 'name' => 'Μέτριας Δυσκολίας', 'code'=>'MEDIUM'],
            ['id' => 3, 'name' => 'Μεγάλης Δυσκολίας', 'code'=>'HARD']
        ];

        foreach ($data as $datum) {
            $lang = $this->difficultiesLkpRepository->updateOrCreate(['id' => $datum['id']], $datum);
            echo "\nAdded Difficulty: " . $lang->name . "\n";
        }
    }
}
