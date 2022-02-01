<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use App\BusinessLogicLayer\User\UserManager;
use App\BusinessLogicLayer\UserRole\UserRoleManager;
use App\BusinessLogicLayer\ViewModelProviders\AdministrationVMProvider;
use App\Models\User;
use App\ViewModels\RegistrationFormVM;
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
    public UserManager $userManager;


    public function __construct(UserRoleManager $userRoleManager, UserManager $userManager)
    {
        $this->userRoleManager = $userRoleManager;
        $this->userManager = $userManager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function login(): View
    {
        return view("auth.login-shapes");
    }

    public function register(): View
    {
        $registrationFormVM = new RegistrationFormVM($this->userRoleManager);
        return view('auth.register-shapes')->with(['viewModel' => $registrationFormVM]);
    }

    public function request_create_user(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|integer|gt:1'
        ]);
        try{
            $this->userManager->createShapes($request);
            session()->flash('flash_message_success', "Shapes user successfully registered");

        } catch(\Exception $e){
            session()->flash('flash_message_failure', $e->getMessage());
        } finally {
            return back();
        }
    }


    public function request_login_token(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        try{
            $this->userManager->loginShapes($request);
            session()->flash('flash_message_success', "Shapes user successfully logged-in");

        } catch(\Exception $e){
            session()->flash('flash_message_failure', $e->getMessage());
        } finally {
            return back();
        }
    }

}
