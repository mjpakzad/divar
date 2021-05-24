<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManufacturerRequest extends FormRequest
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
            'name'          => 'required|max:191',
            'logo'          => 'image|mimes:jpg,png,jpeg,gif',
            'sort_order'    => 'nullable|numeric|min:0,max:255',
            'description'   => 'string|nullable',
        ];
        switch ($this->method()) {
            case 'POST':
                $rules['slug']          =  'required|max:191|unique:manufacturers';
                break;
            case 'PATCH':
            case 'PUT':
                $rules['slug']          = 'required|max:191|alpha_dash|unique:manufacturers,id,' . $this->id;
                break;
        }
        return $rules;
    }
}
