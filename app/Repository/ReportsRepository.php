<?php


namespace App\Repository;
use App\Models\Reports;
use App\Repository\Repository;
use App\Repository\User\UserRole\UserRolesLkp;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ReportsRepository extends Repository {

    function getModelClassName() {
        return Reports::class;
    }
}
