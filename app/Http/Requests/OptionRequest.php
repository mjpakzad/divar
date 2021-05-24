<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OptionRequest extends FormRequest
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
            'option_name'       => 'required',
            'option_sort_order' => 'integer|nullable',
            'name.*'            => 'required',
            'sort_order.*'      => 'integer|nullable',
            'image.*'           => 'nullable|image|mimes:jpg,png,jpeg,gif',
        ];
        switch ($this->method()) {
            case 'POST':
                break;
            case 'PATCH':
            case 'PUT':
                $rules['keep_options.*'] = 'nullable|exists:option_values,id';
                break;
        }
        return $rules;
    }
}
