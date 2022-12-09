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

    public function storeRating(int $resources_id, int $rating, bool $update, int $previousRating) {
        $resource = $this->resourcesRatingRepository->find($resources_id);
        $data = [
            'resources_id' => $resources_id,
            'resources_slug' => $resource->slug,
            'rating' => $rating,
        ];
        if ($update) {
            $resourceRating = $this->resourcesRatingRepository->where(['resources_id' => $resource->id, 'rating' => $previousRating, 'voter_user_id' => null]);
            $resourceRating->rating = $rating;

            return $resourceRating->save();
        }

        return $this->resourcesRatingRepository->create($data);
    }

    public function storeRatingBySlug(string $resources_slug, int $rating, bool $update, int $previousRating) {
        $data = [
            'resources_slug' => $resources_slug,
            'rating' => $rating,
        ];
        if ($update) {
            $resourceRating = $this->resourcesRatingRepository->where(['resources_slug' => $resources_slug, 'rating' => $previousRating, 'voter_user_id' => null]);
            $resourceRating->rating = $rating;

            return $resourceRating->save();
        }

        return $this->resourcesRatingRepository->create($data);
    }

    public function getUserRatingForResource(int $user_id, int $resources_id) {
        return $this->resourcesRatingRepository->where([
            'voter_user_id' => $user_id,
            'resources_id' => $resources_id,
        ]);
    }

    public function getRatings() {
        return $this->resourcesRatingRepository->all();
    }

    public function getAverageRatingForResource(string $resources_slug): array {
        $allRatings = $this->resourcesRatingRepository->allWhere(['resources_slug' => $resources_slug]);

        return [
            'num_of_ratings' => $allRatings->count(),
            'avg_rating' => $allRatings->pluck('rating')->avg() ?? 0,
        ];
    }
}
