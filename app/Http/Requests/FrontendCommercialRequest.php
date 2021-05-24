<?php

namespace App\Http\Requests;

use App\Models\Field;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FrontendCommercialRequest extends FormRequest
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
            'title'     => 'required|string|max:191',
            'content'   => 'required',
            'district'  => 'nullable|exists:districts,id',
            'latitude'  => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'price'     => 'nullable|numeric',
            'images.*'  => 'nullable|image|mimes:jpg,png,jpeg',
        ];
        $fields     = array_keys(request('fields') ?? []);
        $hasValue   = ['min', 'max', 'digits_between', 'starts_with', 'regex'];
        foreach ($fields as $id) {
            $field = Field::find($id);
            $ruleValue  = array_combine($field->rules, $field->values);
            $rule = [];
            if($field->type == 'select') {
                foreach ($field->options as $option) {
                    $optionList[] = $option;
                }
                $rule[] = Rule::in($optionList);
            }
            foreach ($ruleValue as $r => $value) {
                $rule[] = $r . (in_array($r, $hasValue) ? ':' . $value : '');
            }
            $rules['fields.' . $id] = $rule;
        }
        return $rules;
    }
}
