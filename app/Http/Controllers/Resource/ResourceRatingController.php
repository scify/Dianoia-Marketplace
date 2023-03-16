<?php

namespace App\Http\Controllers\Resource;

use App\BusinessLogicLayer\Resource\ResourceManager;
use App\BusinessLogicLayer\Resource\ResourcesRatingManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResourceRatingController extends Controller {
    protected ResourcesRatingManager $resourcesRatingManager;

    protected ResourceManager $resourceManager;

    public function __construct(ResourcesRatingManager $resourcesRatingManager, ResourceManager $resourceManager) {
        $this->resourcesRatingManager = $resourcesRatingManager;
        $this->resourceManager = $resourceManager;
    }

    public function getUserRatingForResource(Request $request) {
        $this->validate($request, [
            'user_id' => 'required|integer',
            'resources_id' => 'required|integer',
        ]);

        return $this->resourcesRatingManager->getUserRatingForResource(
            $request->user_id,
            $request->resources_id
        );
    }

    public function getAverageRatingForResource(Request $request) {
        $this->validate($request, [
            'resources_slug' => 'required',
        ]);

        return $this->resourcesRatingManager->getAverageRatingForResource($request->resources_slug);
    }

    public function storeOrUpdateRating(Request $request) {
        $this->validate($request, [
            'user_id' => 'required|integer',
            'resources_id' => 'required|integer|exists:resources,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        return $this->resourcesRatingManager->storeOrUpdateRating(
            $request->user_id,
            $request->resources_id,
            $request->rating
        );
    }

    public function storeOrUpdateMobileRating(Request $request): array {
        $this->validate($request, [
            'resources_id' => 'required_without:resources_slug|integer|exists:resources,id',
            'resources_slug' => 'required_without:resources_id|string',
            'rating' => 'required|integer|min:1|max:5',
            'update' => 'required|boolean',
            'previous_rating' => 'integer|min:1|max:5',
        ]);

        $data = $request->all();
        $previousRating = $data['update'] && isset($data['previous_rating']) ? $data['previous_rating'] : 0;
        if (isset($data['resources_id']) && $data['resources_id']) {
            $this->resourcesRatingManager->storeRating($data['resources_id'], $data['rating'], $data['update'], $previousRating);
        } else {
            $this->resourcesRatingManager->storeRatingBySlug($data['resources_slug'], $data['rating'], $data['update'], $previousRating);
        }
        $currentAvg = $this->resourcesRatingManager->getAverageRatingForResource($data['resources_slug']);
        $resource = $this->resourceManager->getResourceBySlug($data['resources_slug']);
        if ($resource) {
            $this->resourceManager->storeOrUpdateAverageResourceRating(
                $resource->id,
                $currentAvg['avg_rating']
            );
        }

        return $currentAvg;
    }

    public function storeOrUpdateAverageResourceRating(Request $request) {
        $this->validate($request, [
            'id' => 'sometimes|required|integer|exists:resources,id',
            'avg_rating' => 'required|numeric|min:1|max:5',
        ]);
        $data = $request->all();

        return $this->resourceManager->storeOrUpdateAverageResourceRating(
            $data['id'],
            $data['avg_rating']
        );
    }

    public function getContentRatings() {
        return $this->resourcesRatingManager->getRatings();
    }
}
