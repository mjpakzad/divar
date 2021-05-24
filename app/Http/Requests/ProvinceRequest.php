<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProvinceRequest extends FormRequest
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
            'name'      => 'required|max:191|string|unique:provinces,name',
            'code'      => 'required|max:191|string|unique:provinces,code',
            'latitude'  => 'nullable|required_with:longitude',
            'longitude' => 'nullable|required_with:latitude',
        ];
        switch ($this->method()) {
            case 'POST':
                break;
            case 'PATCH':
            case 'PUT':
                break;
        }
        return $rules;
    }
}
