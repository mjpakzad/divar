<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttributeRequest extends FormRequest
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
            'group_name'        => 'required|string|max:191',
            'group_sort_order'  => 'integer|nullable',
            'name.*'            => 'nullable|string|max:191',
            'sort_order.*'      => 'nullable',
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
