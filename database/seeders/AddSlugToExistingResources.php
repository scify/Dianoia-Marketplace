<?php

namespace Database\Seeders;

use App\Repository\Resource\ResourceRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AddSlugToExistingResources extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected ResourceRepository $resourceRepository;

    public function __construct(ResourceRepository $resourceRepository) {
        $this->resourceRepository = $resourceRepository;
    }

    public function run() {
        $resources = $this->resourceRepository->getResources();
        foreach ($resources as $resource) {
            $this->resourceRepository->update([
                'slug' =>  Str::slug($resource->name, '_') . '_' . $resource->id,
            ], $resource->id);
        }
    }
}
