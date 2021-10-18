<?php


namespace App\Repository;


use App\Models\CarerCategoriesLkp;

class CarerCategoriesLkpRepository extends Repository {

    /**
     * @inheritDoc
     */
    function getModelClassName(): string
    {
        return CarerCategoriesLkp::class;
    }
}
