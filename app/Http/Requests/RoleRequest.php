<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'display_name'  => 'required|string|max:191',
            'description'   => 'required|string|max:191',
        ];
        switch ($this->method()) {
            case 'POST':
                $rules['name']  =  'required|max:191|string|unique:roles';
                break;
            case 'PATCH':
            case 'PUT':
                $rules['name']  = 'required|max:191|string|unique:roles,id,' . $this->id;
                break;
        }
        return $rules;
    }
}
