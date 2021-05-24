<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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
            'name'              => 'required|max:191',
            'meta_keywords'     => 'Nullable',
            'meta_description'  => 'Nullable',
            'parent_id'         => 'Nullable|exists:categories,id',
            'status'            => 'required|in:0,1',
        ];
        switch ($this->method()) {
            case 'POST':
                $rules['slug']          =  'required|max:191|alpha_dash|unique:groups';
                break;
            case 'PATCH':
            case 'PUT':
                $rules['slug']          = 'required|max:191|alpha_dash|unique:groups,id,' . $this->id;
                break;
        }
        return $rules;
    }
}
