<?php

namespace App\Http\Controllers\Resource;

use App\BusinessLogicLayer\Resource\ResourcesRatingManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ResourceRatingController extends Controller {

    protected ResourcesRatingManager $resourcesRatingManager;

    public function __construct(ResourcesRatingManager $resourcesRatingManager) {
        $this->resourcesRatingManager = $resourcesRatingManager;
    }

    public function getUserRatingForResource(Request $request) {

        $this->validate($request, [
            'user_id' => 'required|integer',
            'resources_id' => 'required|integer'
        ]);
        return $this->resourcesRatingManager->getUserRatingForResource(
            $request->user_id,
            $request->resources_id
        );
    }

    public function storeOrUpdateRating(Request $request) {

        $this->validate($request, [
            'user_id' => 'required|integer',
            'resources_id' => 'required|integer|exists:resources_package,id',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        if(!Auth::check())
            abort(Response::HTTP_UNAUTHORIZED);

        return $this->resourcesRatingManager->storeOrUpdateRating(
            $request->user_id,
            $request->resources_id,
            $request->rating
        );
    }

}
