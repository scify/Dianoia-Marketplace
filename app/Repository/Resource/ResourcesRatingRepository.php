<?php

namespace App\Repository\Resource;

use App\Models\Resource\ResourcesRating;
use App\Repository\Repository;

class ResourcesRatingRepository extends Repository {

    /**
     * @inheritDoc
     */
    function getModelClassName() {
        return ResourcesRating::class;
    }
}
