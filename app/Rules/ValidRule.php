<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidRule implements Rule
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
    public function passes($attribute, $rule)
    {
        $validRules = [
            'required',
            'min',
            'max',
            'accepted',
            'url',
            'iran_phone',
            'iran_mobile',
            'address',
            'iran_postal_code',
            'card_number',
            'melli_code',
            'sheba',
            'email',
            'numeric',
            'digits_between',
            'starts_with',
            'alpha',
            'persian_alpha',
            'regex'
        ];
        if(in_array($rule, $validRules)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'قانون انتخاب شده مجاز نیست.';
    }
}
