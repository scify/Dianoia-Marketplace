<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\User\UserManager;
use App\BusinessLogicLayer\UserRole\UserRoleManager;
use App\BusinessLogicLayer\ViewModelProviders\AdministrationVMProvider;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Cookie;

class ShapesIntegrationController extends Controller
{

    public UserRoleManager $userRoleManager;

    public function __construct(UserRoleManager $userRoleManager) {
        $this->userRoleManager = $userRoleManager;
    }


    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function login(): View {
        return view("auth.login-shapes");
    }

}
