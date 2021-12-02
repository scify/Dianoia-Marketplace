<?php


namespace App\Repository\Resource;


use App\Models\Resource\Resource;
use App\Models\Resource\ResourcesRating;
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
        if($difficulties !== [""]){
            if($difficulties[0] !== '1'){
                $resourcesBuilder->orderBy('difficulty_id', 'desc');
            }
            else{
                $resourcesBuilder->orderBy('difficulty_id', 'asc');
            }
        }

        $ret =  $resourcesBuilder->get();

        if($ratings  !== [""]){

                $sorted = $ret->sortBy(function($model) use ($ratings){
                    return array_search(intval($model->id), $ratings);
                });
                return $sorted->values();

         }
        return $ret;
    }
}




