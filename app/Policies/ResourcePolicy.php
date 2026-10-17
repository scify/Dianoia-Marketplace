<?php

namespace App\Policies;

use App\BusinessLogicLayer\UserRole\UserRoleManager;
use App\Models\Resource\Resource;
use App\Models\User;

class ResourcePolicy {
    public function __construct(private UserRoleManager $userRoleManager) {}

    /**
     * Edit, update or delete: the creator of the resource, or an administrator.
     */
    public function manage(User $user, Resource $resource): bool {
        return $resource->creator_user_id === $user->id || $this->userRoleManager->userHasAdminRole($user);
    }
}
