<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'                          => 'required|max:191',
            'description'                   => 'required|string',
            'meta_keywords'                 => 'nullable|string',
            'meta_description'              => 'nullable|string',
            'manufacturer_id'               => 'required|exists:manufacturers,id',
            'model'                         => 'required|string|max:191',
            'code'                          => 'required|string|max:191',
            'sort_order'                    => 'nullable|numeric|min:0,max:255',
            'stock'                         => 'nullable|integer',
            'price'                         => 'required|integer',
            'special'                       => 'nullable|integer',
            'status'                        => 'required|in:0,1',
            'category_id.*'                 => 'exists:shop_categories,id',
            //'image'                         => 'required|image|mimes:jpg,png,jpeg,gif',
            'images.*'                      => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'images_sort_order.*'           => 'nullable|numeric|min:0,max:255',
            'filter_id.*'                   => 'exists:filters,id',
            'attribute_id.*'                => 'exists:attributes,id',
            'attribute_value.*'             => 'nullable',
        ];
        switch ($this->method()) {
            case 'POST':
                $rules['slug']  = 'required|max:191|alpha_dash|unique:products';
                break;
            case 'PATCH':
            case 'PUT':
                $rules['slug']  = 'required|max:191|alpha_dash|unique:products,id,' . $this->id;
                break;
        }
        return $rules;
    }
}
