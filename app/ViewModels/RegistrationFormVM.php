<?php

namespace App\ViewModels;

use App\BusinessLogicLayer\UserRole\UserRoleManager;

class RegistrationFormVM {
    public $roles;

    public function __construct(UserRoleManager $userRoleManager) {
        $this->roles = $userRoleManager->getAllUserRoles();
    }
}
