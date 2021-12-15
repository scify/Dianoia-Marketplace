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
        if($status_ids)
            $resourcesBuilder = Resource::where($whereArray)->whereIn('status_id', $status_ids)->with($this->defaultRelationships);
        else
            $resourcesBuilder = Resource::where($whereArray)->with($this->defaultRelationships);



        if ($type_ids) {
            $resourcesBuilder->whereIn('type_id', $type_ids);//maybe $resourcesBuilder = ...
        }
        $sortByDifficulties = false;
        if($difficulties && count($difficulties) > 1){
            $sortByDifficulties = true;
            if(intval($difficulties[0]) > intval($difficulties[1])){
                $resourcesBuilder->orderBy('difficulty_id', 'desc');
            }
            else{
                $resourcesBuilder->orderBy('difficulty_id', 'asc');
            }
        }

        $ret =  $resourcesBuilder->get();

        $i = count($ret);
        if(!$sortByDifficulties && $ratings  && count($ratings) > 1){
                $sorted = $ret->sortBy(function($model) use ($i, $ratings){
                    $ret =  array_search(intval($model->id), $ratings);
                    if($ret === false){
                        $i++;
                        return $i-1;
                    }
                });
                return $sorted->values();

         }
        return $ret;
    }
}




