<?php

namespace Database\Seeders;

use App\Repository\Resource\ResourceTypeLkpRepository;
use Illuminate\Database\Seeder;

class ResourceTypeLkpTableSeeder extends Seeder {
    protected ResourceTypeLkpRepository $repository;

    public function __construct(ResourceTypeLkpRepository $repository) {
        $this->repository = $repository;
    }


    public function run() {
        echo "\nRunning Resource status lkp Seeder...\n";

        $data = [
            ['id' => 1, 'name' => 'Attention', 'description' => 'Ασκήσεις Προσοχής'],
            ['id' => 2, 'name' => 'Memory', 'description' => 'Ασκήσεις Μνήμης'],
            ['id' => 3, 'name' => 'Reason', 'description' => 'Ασκήσεις Σκέψης & Λόγου'],
            ['id' => 4, 'name' => 'Executive', 'description' => 'Εκτελεστικές λειτουργίες'],
            ['id' => 5, 'name' => 'Carer', 'description' => 'Ασκήσεις για Φροντιστές'],
            ['id' => 6, 'name' => 'Stories', 'description' => 'Ιστορίες']

        ];

        foreach ($data as $datum) {
            $type = $this->repository->updateOrCreate(['id' => $datum['id']], $datum);
            echo "\nAdded Resource Type: " . $type->name . "\n";
        }
    }
}
