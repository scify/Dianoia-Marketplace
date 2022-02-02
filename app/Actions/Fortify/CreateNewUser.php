<?php

namespace App\Actions\Fortify;

use App\BusinessLogicLayer\User\UserManager;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    protected UserManager $userManager;

    public function __construct(UserManager $userManager) {
        $this->userManager = $userManager;
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return User
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(array $input): User {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'role' => 'required|integer|gt:1'
        ])->validate();

        return $this->userManager->create([
            'name' => trim($input['name']),
            'email' => trim($input['email']),
            'password' => trim($input['password']),
            'role' => intval($input['role'])
        ]);
    }
}
