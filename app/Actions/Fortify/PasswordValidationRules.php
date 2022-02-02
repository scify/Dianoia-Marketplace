<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;
use Illuminate\Contracts\Validation\Rule;
trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        return ['required', 'string', (new Password)->requireUppercase()
            ->length(8)
            ->requireNumeric()
            ->requireSpecialCharacter() , 'confirmed'
        ];
    }
}
