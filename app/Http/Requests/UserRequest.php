<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Mobile;

class UserRequest extends FormRequest
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
        $rules = [
            'first_name'    => 'nullable|max:191|string',
            'last_name'     => 'nullable|max:191|string',
            'role'          => 'required|exists:roles,id',
            'city'          => 'nullable|exists:cities,id',
            'phone'         => 'nullable|size:11',
            'occupation'    => 'nullable|string|max:191',
            'password'      => 'nullable|string|min:6',
        ];
        switch ($this->method()) {
            case 'POST':
                $rules['mobile']        = [
                    'required',
                    'numeric',
                    'unique:users',
                    new Mobile,
                ];
                $rules['email']         = 'nullable|email|max:191|unique:users';
                break;
            case 'PATCH':
            case 'PUT':
                $rules['mobile']        = [
                    '
                    required',
                    'numeric',
                    'unique:users,id,' . $this->id,
                    new Mobile,
                ];
                $rules['email']         = 'nullable|email|max:191|unique:users,id,' . $this->id;
                break;
        }
        return $rules;
    }
}
