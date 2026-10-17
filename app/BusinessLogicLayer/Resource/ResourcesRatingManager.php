<?php

namespace App\BusinessLogicLayer\Resource;

use App\Repository\Resource\ResourceRepository;
use App\Repository\Resource\ResourcesRatingRepository;

class ResourcesRatingManager {
    protected ResourcesRatingRepository $resourcesRatingRepository;

    protected ResourceRepository $resourceRepository;

    public function __construct(ResourcesRatingRepository $resourcesRatingRepository, ResourceRepository $resourceRepository) {
        $this->resourcesRatingRepository = $resourcesRatingRepository;
        $this->resourceRepository = $resourceRepository;
    }

    public function storeOrUpdateRating(int $user_id, int $resources_id, int $rating) {
        $data = [
            'voter_user_id' => $user_id,
            'resources_id' => $resources_id,
        ];

        $resourceRating = $this->resourcesRatingRepository->updateOrCreate(
            $data,
            array_merge($data, ['rating' => $rating])
        );

        $this->updateAverageRating($resources_id);

        return $resourceRating;
    }

    private function updateAverageRating(int $resources_id): void {
        $ratings = $this->resourcesRatingRepository->allWhere(['resources_id' => $resources_id])->pluck('rating');

        $this->resourceRepository->update(
            ['avg_rating' => (int) round($ratings->avg() ?? 0)],
            $resources_id
        );
    }

    public function storeRating(int $resources_id, int $rating, bool $update, int $previousRating) {
        $resource = $this->resourceRepository->find($resources_id);
        $data = [
            'resources_id' => $resources_id,
            'resources_slug' => $resource->slug,
            'rating' => $rating,
        ];
        // An update without a matching previous rating stores a new rating.
        $resourceRating = $update ? $this->resourcesRatingRepository->where(['resources_id' => $resource->id, 'rating' => $previousRating, 'voter_user_id' => null]) : null;
        if ($resourceRating) {
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
        // An update without a matching previous rating stores a new rating.
        $resourceRating = $update ? $this->resourcesRatingRepository->where(['resources_slug' => $resources_slug, 'rating' => $previousRating, 'voter_user_id' => null]) : null;
        if ($resourceRating) {
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
