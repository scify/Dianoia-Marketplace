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

class ResourceRepository extends Repository {

    protected array $defaultRelationships = ['creator'];//, 'ratings']

    /**
     * @inheritDoc
     */
    function getModelClassName() {
        return Resource::class;
    }

    function getLastId(){
        return $this->getModelClassName()::latest()->first()->id;
    }

    public function getResources(
        int $user_id = null,
        int $lang_id = null,
        array $status_ids = [ResourceStatusesLkp::APPROVED]
    )
    {
        $whereArray = [];
        if ($lang_id)
            $whereArray['lang_id'] = $lang_id;
        if ($user_id)
            $whereArray['creator_user_id'] = $user_id;
        return Resource
            ::where($whereArray)
            ->whereIn('status_id', $status_ids)
            ->with($this->defaultRelationships)
            ->get();
    }
}



