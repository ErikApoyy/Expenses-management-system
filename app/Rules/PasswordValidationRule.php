<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordValidationRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check if there are at least 2 uppercase letters
        if (preg_match_all('/[A-Z]/', $value) < 2) {
            return false;
        }

        // Check if there is at least 1 number
        if (!preg_match('/[0-9]/', $value)) {
            return false;
        }

        // Check if there is at least 1 special character (you can define your own list of special characters)
        if (!preg_match('/[@#$%^&+=!*_()\-[\]{};:"<>,.?~\\/]/', $value)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The password must be 5-10 characters long and contain at least 2 uppercase letters, 1 number, and 1 special character.';
    }
}
