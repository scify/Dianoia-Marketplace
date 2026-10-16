<?php

namespace App\Repository\Resource;

use App\Models\Resource\Resource;
use App\Repository\Repository;

class ResourceRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return Resource::class;
    }

    public function getResources(
        ?int $user_id = null,
        ?int $lang_id = null,
        ?array $status_ids = null,
        ?array $difficulties = null,
        ?array $type_ids = null,
        ?array $ratings = null,
        $paginate = null,
        $api = false
    ) {
        $whereArray = [];
        if ($lang_id) {
            $whereArray['lang_id'] = $lang_id;
        }
        if ($user_id) {
            $whereArray['creator_user_id'] = $user_id;
        }


        if ($status_ids) {
            $resourcesBuilder = Resource::where($whereArray)->whereIn('status_id', $status_ids)->with($this->publicListRelationships());
        } else {
            $resourcesBuilder = Resource::where($whereArray)->with($this->publicListRelationships());
        }


        if ($type_ids) {
            $resourcesBuilder->whereIn('type_id', $type_ids); // maybe $resourcesBuilder = ...
        }

        if ($api) {
            $resourcesBuilder->where('display_in_api', true); // maybe $resourcesBuilder = ...
        }


        $sortByDifficulties = false;
        if ($difficulties && count($difficulties) > 1) {
            $sortByDifficulties = true;
            if (intval($difficulties[0]) > intval($difficulties[1])) {
                $resourcesBuilder->orderBy('difficulty_id', 'desc');
            } else {
                $resourcesBuilder->orderBy('difficulty_id', 'asc');
            }
        } else {
            $resourcesBuilder->orderBy('avg_rating', 'desc');
        }


        if ($paginate) {
            $ret = $resourcesBuilder->simplePaginate($paginate);
        } else {
            $ret = $resourcesBuilder->get();
        }


        $i = count($ret);
        if (!$sortByDifficulties && $ratings && count($ratings) > 1) {
            $sorted = $ret->sortBy(function ($model) use ($i, $ratings) {
                $ret = array_search(intval($model->id), $ratings);
                if ($ret === false) {
                    $i++;

                    return $i - 1;
                }
            });

            return $sorted->values();
        }

        return $ret;
    }

    /**
     * The resources list is public, so expose only the creator's id and name.
     */
    private function publicListRelationships(): array {
        return [
            'creator' => fn ($query) => $query->select('id', 'name')->without('roles'),
            'ratings',
        ];
    }
}
