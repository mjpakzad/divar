<?php

namespace App\Http\Requests;

use App\Rules\Mobile;
use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mobile' => [
                'required',
                'numeric',
                new Mobile,
                'exists:users',
            ],
        ];
    }

    public function messages()
    {
        return [
            'mobile.exists' => 'کاربری با این شماره در سیستم وجود ندارد!'
        ];
    }
}
