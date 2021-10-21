<?php


namespace App\Repository;
use App\Models\DifficultiesLkp;

class DifficultiesLkpRepository extends Repository {

    /**
     * @inheritDoc
     */
    function getModelClassName() {
        return DifficultiesLkp::class;
    }
}
