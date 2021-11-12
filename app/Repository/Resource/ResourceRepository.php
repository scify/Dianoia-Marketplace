<?php


namespace App\Repository\Resource;


use App\Models\Resource\Resource;
use App\Models\Resource\ResourcesPackage;
use App\Models\Resource\ResourcesPackageRating;
use App\Models\User;
use App\Repository\Repository;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

class ResourceRepository extends Repository
{

    protected array $defaultRelationships = ['creator', 'ratings'];

    /**
     * @inheritDoc
     */
    function getModelClassName()
    {
        return Resource::class;
    }

    function getLastId()
    {
        return $this->getModelClassName()::latest()->first()->id;
    }

    public function getResources(
        int $user_id = null,
        int $lang_id = null,
        array $status_ids = null,
        array $difficulties = null,
        array $type_ids = null,
        array $ratings = null
    )
    {
        $whereArray = [];
        if ($lang_id)
            $whereArray['lang_id'] = $lang_id;
        if ($user_id)
            $whereArray['creator_user_id'] = $user_id;

        $resourcesBuilder = Resource::where($whereArray)->whereIn('status_id', $status_ids)->with($this->defaultRelationships);
        if ($type_ids) {
            $resourcesBuilder->whereIn('type_id', $type_ids);//maybe $resourcesBuilder = ...
        }
        $resourcesBuilder->orderBy('difficulty_id', 'desc');
        return $resourcesBuilder->get();
    }
}



//        $resources = Collection::empty();
//        if($difficulties != [""]){ //sort by difficulty
////            foreach ($difficulties as $difficulty){
////                $whereArray['difficulty_id'] = intval($difficulty);
////                if($type_ids){
////                    $part =   Resource::where($whereArray)
////                        ->whereIn('status_id', $status_ids)
////                        ->whereIn('type_id',$type_ids)->with($this->defaultRelationships)
////                        ->get();
////                }
////                else{
////                    $part =   Resource::where($whereArray)
////                        ->whereIn('status_id', $status_ids)->with($this->defaultRelationships)
////                        ->get();
////                }
////
////                $resources = $resources->merge($part);
////            }
//            if($type_ids) {
//                $resources = Resource::where($whereArray)
//                    ->whereIn('status_id', $status_ids)->whereIn('type_id',$type_ids)->with($this->defaultRelationships)
//                    ->orderBy('difficulty_id','desc')
//                    ->get();
//            }else{
//                $resources =  Resource::where($whereArray)
//                    ->whereIn('status_id', $status_ids)->with($this->defaultRelationships)
//                    ->orderBy('difficulty_id','desc')
//                    ->get();
//            }
////
//        }
//        else{
//            if($type_ids) {
//                $resources = Resource::where($whereArray)
//                    ->whereIn('status_id', $status_ids)->whereIn('type_id',$type_ids)->with($this->defaultRelationships)
//                    ->get();
//            }else{
//                $resources =  Resource::where($whereArray)
//                    ->whereIn('status_id', $status_ids)->with($this->defaultRelationships)
//                    ->get();
//            }
//        }
//        return $resources;
//    }



