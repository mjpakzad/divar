<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RegisterMobileValid implements Rule
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
        $user = auth()->user();
        if ($user->twoFactorCode()->code == $value && $user->twoFactorCode()->isValid())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'کد وارد شده معتبر نیست.';
    }
}
