<?php

namespace App\Repository\User\UserRole;

abstract class UserRolesLkp {
    //ATTENTION: these values match with the db values defined in database\seeders\UsersRoleLkpTableSeeder.php
    const ADMIN = 1;
    const PRIVATE_CARER = 2;
    const PROFESSIONAL_CARER = 3;
    const ORGANIZATION = 4;
    const SHAPES_USER = 5;
}
