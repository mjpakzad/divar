<?php

namespace App\Http\Requests;

use App\Rules\ValidRule;
use Illuminate\Foundation\Http\FormRequest;

class FieldRequest extends FormRequest
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
            'name'          => 'required|string|max:191',
            'type'          => 'required|in:text,select,checkbox',
            'label'         => 'nullable|string|max:191',
            'placeholder'   => 'nullable|string|max:191',
            'rules.*'       => [
                new ValidRule,
            ],
            'values.*'      => 'required_with:rules.*',
            'options.*'     => 'nullable',
            'is_price'      => 'nullable|in:0,1',
            'is_tag'        => 'nullable|in:0,1',
            'buying'        => 'nullable|in:0,1,2',
            'sort_order'    => 'nullable|numeric|min:0',
        ];
    }
}
