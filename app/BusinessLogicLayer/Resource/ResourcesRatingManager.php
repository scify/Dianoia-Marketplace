<?php

namespace App\BusinessLogicLayer\Resource;

use App\Repository\Resource\ResourcesRatingRepository;

class ResourcesRatingManager {

    protected ResourcesRatingRepository $resourcesRatingRepository;

    public function __construct(ResourcesRatingRepository $resourcesRatingRepository) {
        $this->resourcesRatingRepository = $resourcesRatingRepository;
    }

    public function storeOrUpdateRating(int $user_id, int $resources_id, int $rating) {
        $data = [
            'voter_user_id' => $user_id,
            'resources_id' => $resources_id,
        ];
        return $this->resourcesRatingRepository->updateOrCreate(
            $data,
            array_merge($data, ['rating' => $rating])
        );
    }

    public function storeRating(int $resources_id, int $rating) {
        return $this->resourcesRatingRepository->create([
            'resources_id' => $resources_id,
            'rating' => $rating
        ]);
    }

    public function storeRatingBySlug(string $resources_slug, int $rating) {
        return $this->resourcesRatingRepository->create([
            'resources_slug' => $resources_slug,
            'rating' => $rating
        ]);
    }

    public function getUserRatingForResource(int $user_id, int $resources_id) {

        return $this->resourcesRatingRepository->where([
            'voter_user_id' => $user_id,
            'resources_id' => $resources_id
        ]);
    }

    public function getRatings() {
        return $this->resourcesRatingRepository->all();
    }

}
