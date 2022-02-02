<?php

namespace App\Http\Controllers;
use App\BusinessLogicLayer\Shapes\ShapesIntegrationManager;
use App\BusinessLogicLayer\UserRole\UserRoleManager;
use App\ViewModels\RegistrationFormVM;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class ShapesIntegrationController extends Controller
{

    public ShapesIntegrationManager $shapesIntegrationManager;
    public UserRoleManager  $userRoleManager;

    public function __construct(UserRoleManager $userRoleManager,ShapesIntegrationManager $shapesIntegrationManager)
    {
        $this->userRoleManager = $userRoleManager;
        $this->shapesIntegrationManager = $shapesIntegrationManager;
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
            $this->shapesIntegrationManager->createShapes($request);
            $this->request_login_token($request);
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
            $user = $this->shapesIntegrationManager->findUserByEmail($request['email']);
            $response = $this->shapesIntegrationManager->loginShapes($request);
            $data =  $response['items'][0];
            $token = $data['token'];
            $this->shapesIntegrationManager->storeUserToken($user->id, $token);
            session()->flash('flash_message_success', "Shapes user successfully logged-in");

        } catch(\Exception $e){
            session()->flash('flash_message_failure', $e->getMessage());
        } finally {
            return back();
        }
    }
}
