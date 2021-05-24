<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopCategoryRequest extends FormRequest
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
            'image'             => 'image|mimes:jpg,png,jpeg,gif',
            'content'           => 'Nullable',
            'meta_keywords'     => 'Nullable',
            'meta_description'  => 'Nullable',
            'parent_id'         => 'Nullable|exists:categories,id',
            'sort_order'        => 'Nullable|Numeric|Min:0,Max:255',
            'featured'          => 'in:0,1',
            'status'            => 'nullable|in:0,1',
            'filter_id.*'       => 'exists:filter_groups,id',
        ];
        switch ($this->method()) {
            case 'POST':
                $rules['slug']          =  'required|max:191|unique:shop_categories';
                break;
            case 'PATCH':
            case 'PUT':
                $rules['slug']          = 'required|max:191|unique:shop_categories,id,' . $this->id;
                $rules['remove_image']  = 'Nullable|in:0,1,on';
                break;
        }
        return $rules;
    }
}
