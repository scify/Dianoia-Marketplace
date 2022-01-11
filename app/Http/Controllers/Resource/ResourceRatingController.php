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
        return $this->resourcesRatingManager->storeOrUpdateRating(
            $request->user_id,
            $request->resources_id,
            $request->rating
        );
    }
    public function storeOrUpdateAverageResourceRating(Request $request){
        $data = $request->all();
        try{
            $this->resourceManager->storeOrUpdateAverageResourceRating(
                $data['id'],
                $data['avg_rating']
            );
            return redirect()->back()->with('flash_message_success', __('messages.exercise-update-success'));
        } catch (\Exception $e) {
            return redirect()->back()->with('flash_message_failure', __('messages.exercise-update-failure'));
        }
    }

    public function getContentRatings(){
        return $this->resourcesRatingManager->getRatings();
    }
}
