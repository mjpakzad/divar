<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
            'title'         => 'required|max:191|string',
            'keywords'      => 'nullable|string|max:191',
            'description'   => 'nullable|string|max:191',
        ];
        switch ($this->method()) {
            case 'POST':
                $rules['name']  =  'required|max:191|unique:cities';
                $rules['slug']  =  'required|max:191|unique:cities';
                break;
            case 'PATCH':
            case 'PUT':
                $rules['name']  = 'required|max:191|unique:cities,id,' . $this->id;
                $rules['slug']  = 'required|max:191|unique:cities,id,' . $this->id;
                break;
        }
        return $rules;
    }
}
