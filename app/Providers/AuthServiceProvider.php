<?php

namespace App\Providers;

use App\BusinessLogicLayer\UserRole\UserRoleManager;
use App\Models\Resource\Resource;
use App\Policies\ResourcePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;

class AuthServiceProvider extends ServiceProvider {
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Resource::class => ResourcePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        $userRoleManager = App::make(UserRoleManager::class);
        $userRoleManager->registerUserPolicies();
    }
}
