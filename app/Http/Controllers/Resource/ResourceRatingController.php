<?php

namespace App\Http\Controllers\Resource;

use App\BusinessLogicLayer\Resource\ResourcesRatingManager;
use App\BusinessLogicLayer\Resource\ResourceManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ResourceRatingController extends Controller
{

    protected ResourcesRatingManager $resourcesRatingManager;
    protected ResourceManager $resourceManager;

    public function __construct(ResourcesRatingManager $resourcesRatingManager, ResourceManager $resourceManager)
    {
        $this->resourcesRatingManager = $resourcesRatingManager;
        $this->resourceManager = $resourceManager;
    }

    public function getUserRatingForResource(Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required|integer',
            'resources_id' => 'required|integer'
        ]);
        return $this->resourcesRatingManager->getUserRatingForResource(
            $request->user_id,
            $request->resources_id
        );
    }

    public function storeOrUpdateRating(Request $request)
    {

        $this->validate($request, [
            'user_id' => 'required|integer',
            'resources_id' => 'required|integer|exists:resources,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        if (!Auth::check())
            abort(Response::HTTP_UNAUTHORIZED);

        return $this->resourcesRatingManager->storeOrUpdateRating(
            $request->user_id,
            $request->resources_id,
            $request->rating
        );
    }
    public function updateAverageResourceRating(Request $request){
        $this->validate($request, [
            'resources_id' => 'required|integer|exists:resources,id',
            'avg_rating' => 'required|integer|min:0|max:5',
        ]);

        if (!Auth::check())
            abort(Response::HTTP_UNAUTHORIZED);

        $this->resourceManager->storeOrUpdateAverageResourceRating(
            $request->resources_id,
            $request->avg_rating
        );
    }

    public function getContentRatings(){
        return $this->resourcesRatingManager->getRatings();
    }
}
