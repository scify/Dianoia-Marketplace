<?php

namespace App\Repository;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class PlatformStatisticsRepository {
    public function getPlatformStatistics(): Collection {
        return collect(DB::select('
            with users_stats as (
                select count(users.id) as "Total number of users"
                from users
                where
                users.deleted_at is null
            ),
            res_stats as (
                select count(res.id) as "Total number of resources"
                from resources as res
                where
                res.deleted_at is null
            ),
            published_res_stats as (
                select count(res.id) as "Total number of published resources"
                from resources as res
                where
                res.deleted_at is null and
                res.status_id = 2
            ),
            reports_stats as (
                select count(rep.id) as "Total number of reports"
                from reports as rep
                where
                rep.deleted_at is null
            ),
            ratings_stats as (
                select count(rat.id) as  "Total number of ratings"
                from resources_ratings as rat
            )
            select * from users_stats, res_stats, published_res_stats, reports_stats, ratings_stats;
        '));
    }

    public function getResourcesPerTypeStatistics(): Collection {
        return collect(DB::select('
            select count(resources.id) as num, rstl.name from resources
            inner join resource_types_lkp rstl on rstl.id = resources.type_id

            where resources.deleted_at is null
            group by type_id
        '))->flatten();
    }

    public function getNumOfResourcesPerUser(): Collection {
        return collect(DB::select('
            select concat(users.name, " (", users.email, ")" ) as user_name, count(res.id) as resources_num
            from users
            inner join resources res on res.creator_user_id = users.id

            where users.deleted_at is null
            and res.deleted_at is null

            group by users.id, users.name
            order by resources_num desc
            limit 10
        '));
    }
}
