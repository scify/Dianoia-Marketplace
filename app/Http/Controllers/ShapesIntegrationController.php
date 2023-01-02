<?php

namespace App\Http\Controllers;

use App\BusinessLogicLayer\Shapes\ShapesIntegrationManager;
use App\BusinessLogicLayer\UserRole\UserRoleManager;
use App\Repository\Resource\ResourceTypeLkpRepository;
use App\Repository\User\UserRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShapesIntegrationController extends Controller {
    public ShapesIntegrationManager $shapesIntegrationManager;
    public UserRoleManager $userRoleManager;
    public UserRepository $userRepository;
    public ResourceTypeLkpRepository $resourceTypeLkpRepository;

    public function __construct(UserRoleManager           $userRoleManager,
                                ShapesIntegrationManager  $shapesIntegrationManager,
                                UserRepository            $userRepository,
                                ResourceTypeLkpRepository $resourceTypeLkpRepository) {
        $this->userRoleManager = $userRoleManager;
        $this->shapesIntegrationManager = $shapesIntegrationManager;
        $this->userRepository = $userRepository;
        $this->resourceTypeLkpRepository = $resourceTypeLkpRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function login(): View {
        return view('auth.login-shapes');
    }

    public function register(): View {
        return view('auth.register-shapes');
    }

    public function request_create_user(Request $request): RedirectResponse {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);
        try {
            $user = $this->shapesIntegrationManager->createShapes($request);
            $this->request_login_token($request);
            Auth::login($user);
            session()->flash('flash_message_success', 'Shapes user successfully registered');

            return redirect()->route('home');
        } catch (\Exception $e) {
            session()->flash('flash_message_failure', $e->getMessage());

            return back();
        }
    }

    public function request_login_token(Request $request): RedirectResponse {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        try {
            $response = $this->shapesIntegrationManager->loginShapes($request);
            try {
                $user = $this->shapesIntegrationManager->findUserByEmail($request['email']);
            } catch (\Exception $e) {
                $user = $this->shapesIntegrationManager->storeShapesUserLocally($request);
            }
            $data = $response['items'][0];
            $token = $data['token'];
            $this->shapesIntegrationManager->storeUserToken($user->id, $token);
            $user = $this->userRepository->find($user->id);
            if ($user->shapes_auth_token && ShapesIntegrationManager::isEnabled()) {
                try {
                    $this->shapesIntegrationManager->sendUsageDataToDatalakeAPI($user, 'user_login', $user->email);
                } catch (\Exception $e) {
                    Log::error($e);
                }
            }
            session()->flash('flash_message_success', 'Shapes user successfully logged-in');
            Auth::login($user);

            return redirect()->route('home');
        } catch (\Exception $e) {
            session()->flash('flash_message_failure', $e->getMessage());

            return back();
        }
    }
}
