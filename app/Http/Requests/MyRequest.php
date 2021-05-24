<?php

namespace App\Http\Requests;

use App\Rules\Mobile;
use Illuminate\Foundation\Http\FormRequest;

class MyRequest extends FormRequest
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
            'name'      => 'required|string|max:191',
            'mobile'    => [
                'required',
                'numeric',
                'unique:users,id,' . $this->id,
                new Mobile,
            ],
            'password'              => 'required_with:password_confirmation|string|min:6|confirmed',
            'password_confirmation' => 'required_with:password',
        ];
    }
}
