<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\PasswordValidationRules;
use App\BusinessLogicLayer\User\UserManager;
use App\BusinessLogicLayer\ViewModelProviders\AdministrationVMProvider;
use App\Models\User;
use App\Repository\User\UserRole\UserRolesLkp;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\Rule;

class UserController extends Controller {
    protected AdministrationVMProvider $administrationVMProvider;

    protected UserManager $userManager;

    use PasswordValidationRules;

    public function __construct(AdministrationVMProvider $administrationVMProvider,
        UserManager $userManager) {
        $this->administrationVMProvider = $administrationVMProvider;
        $this->userManager = $userManager;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View {
        $viewModel = $this->administrationVMProvider->getUsersManagementVM();

        return view('admin.user-management', compact(['viewModel']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            // 'email' => 'required|email:rfc,dns|unique:users,email',
            'password' => $this->passwordRules(),
            'role' => ['required', 'integer', Rule::in(UserRolesLkp::REGISTERED_USER_TYPES)],
        ]);
        try {
            $this->userManager->create($request->all());
            session()->flash('flash_message_success', 'User created');
        } catch (\Exception $e) {
            session()->flash('flash_message_failure', $e->getMessage());
        } finally {
            return back();
        }
    }

    /**
     * The logged-in user updates their own profile. Roles other than the
     * registered user type are managed only by administrators.
     */
    public function updateProfile(Request $request, User $user): RedirectResponse {
        abort_unless($user->is(Auth::user()), 403);

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => $request['password'] ? $this->passwordRules() : 'nullable',
            'type_id' => ['nullable', 'integer', Rule::in(UserRolesLkp::REGISTERED_USER_TYPES)],
        ]);

        $this->userManager->updateProfile($user, $request->only(['name', 'email', 'password', 'type_id']));
        session()->flash('flash_message_success', 'User successfuly updated');

        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse {
        if ($request['password']) {
            $request->validate([
                'password' => $this->passwordRules(),
            ]);
        }
        $request->validate([
            'name' => 'required',
            'email' => 'unique:users,email,' . $user->id,
            // 'email' => 'unique:users,email:rfc, dns,' . $user->id
        ]);
        try {
            $this->userManager->update($user->id, $request->all());
            session()->flash('flash_message_success', 'User successfuly updated');
        } catch (\Exception $e) {
            session()->flash('flash_message_failure', $e->getMessage());
        } finally {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse {
        try {
            $this->userManager->delete($user->id);
            session()->flash('flash_message_success', 'User deleted');
        } catch (\Exception $e) {
            session()->flash('flash_message_failure', $e->getMessage());
        } finally {
            return back();
        }
    }

    public function setLangLocaleCookie(Request $request): RedirectResponse {
        if (!in_array($request->lang, ['en', 'el', 'it', 'sp'])) {
            session()->flash('flash_message_failure', 'Wrong language.');

            return back();
        }
        Cookie::queue(Cookie::forever('lang', $request->lang));
        App::setLocale($request->lang);

        return redirect()->back();
    }

    public function getRoles() {
        return $this->userManager->getUserRoles();
    }

    public function getRolesMapping() {
        return $this->userManager->getUserRolesMapping();
    }
}
