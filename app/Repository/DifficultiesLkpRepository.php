<?php

namespace App\Repository;

use App\Models\DifficultiesLkp;

class DifficultiesLkpRepository extends Repository {
    /**
     * {@inheritDoc}
     */
    public function getModelClassName() {
        return DifficultiesLkp::class;
    }
}
