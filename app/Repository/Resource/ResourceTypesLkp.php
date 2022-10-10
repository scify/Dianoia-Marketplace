<?php

namespace App\Repository\Resource;


abstract class ResourceTypesLkp {
    //ATTENTION: these values match with the db values defined in database\seeds\ResourceTypeLkpTableSeeder.php
    const ATTENTION = 1;
    const MEMORY = 2;
    const REASON = 3;
    const EXECUTIVE = 4;
    const CARER = 5;
    const STORIES = 6;
}
