<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            'title'             => 'required|max:191',
            'image'             => 'image|mimes:jpg,png,jpeg,gif',
            'content'           => 'Nullable',
            'meta_keywords'     => 'Nullable',
            'meta_description'  => 'Nullable',
            'status'            => 'required|in:0,1',
        ];
        switch ($this->method()) {
            case 'POST':
                $rules['slug']          =  'required|max:191|alpha_dash|unique:pages';
                break;
            case 'PATCH':
            case 'PUT':
                $rules['slug']          = 'required|max:191|alpha_dash|unique:pages,id,' . $this->id;
                $rules['remove_image']  = 'Nullable|in:0,1,on';
                break;
        }
        return $rules;
    }
}
