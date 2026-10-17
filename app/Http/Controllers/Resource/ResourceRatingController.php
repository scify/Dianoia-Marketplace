<?php

namespace App\Http\Controllers\Resource;

use App\BusinessLogicLayer\Resource\ResourceManager;
use App\BusinessLogicLayer\Resource\ResourcesRatingManager;
use App\Http\Controllers\Controller;
use App\Repository\Resource\ResourceStatusesLkp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ResourceRatingController extends Controller {
    protected ResourcesRatingManager $resourcesRatingManager;

    protected ResourceManager $resourceManager;

    public function __construct(ResourcesRatingManager $resourcesRatingManager, ResourceManager $resourceManager) {
        $this->resourcesRatingManager = $resourcesRatingManager;
        $this->resourceManager = $resourceManager;
    }

    public function getUserRatingForResource(Request $request) {
        $this->validate($request, [
            'resources_id' => 'required|integer',
        ]);

        return $this->resourcesRatingManager->getUserRatingForResource(
            Auth::id(),
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
            'resources_id' => 'required|integer|exists:resources,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        return $this->resourcesRatingManager->storeOrUpdateRating(
            Auth::id(),
            $request->resources_id,
            $request->rating
        );
    }

    public function storeOrUpdateMobileRating(Request $request): array {
        // Only approved exercises are public, so only they can be rated.
        $approvedResource = fn (string $column) => Rule::exists('resources', $column)
            ->where('status_id', ResourceStatusesLkp::APPROVED)
            ->whereNull('deleted_at');

        $this->validate($request, [
            'resources_id' => ['required_without:resources_slug', 'integer', $approvedResource('id')],
            'resources_slug' => ['required_without:resources_id', 'string', $approvedResource('slug')],
            'rating' => 'required|integer|min:1|max:5',
            'update' => 'required|boolean',
            'previous_rating' => 'integer|min:1|max:5',
        ]);

        $data = $request->all();
        $resource = isset($data['resources_id'])
            ? $this->resourceManager->getResource($data['resources_id'])
            : $this->resourceManager->getResourceBySlug($data['resources_slug']);
        $previousRating = $data['update'] && isset($data['previous_rating']) ? $data['previous_rating'] : 0;

        if (isset($data['resources_id'])) {
            $this->resourcesRatingManager->storeRating($resource->id, $data['rating'], $data['update'], $previousRating);
        } else {
            $this->resourcesRatingManager->storeRatingBySlug($resource->slug, $data['rating'], $data['update'], $previousRating);
        }

        $currentAvg = $this->resourcesRatingManager->getAverageRatingForResource($resource->slug);
        $this->resourceManager->storeOrUpdateAverageResourceRating($resource->id, $currentAvg['avg_rating']);

        return $currentAvg;
    }

    public function getContentRatings() {
        return $this->resourcesRatingManager->getRatings();
    }
}
