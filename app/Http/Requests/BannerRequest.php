<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
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
            'name'          => 'required|max:100',
            'status'        => 'in:0,1',
            'position'      => 'nullable',
            'width'         => 'nullable|integer',
            'height'        => 'nullable|integer',
            'title.*'       => 'max:191|nullable',
            'url.*'         => 'nullable|url|nullable',
            'image.*'       => 'image|mimes:jpg,png,jpeg,gif,svg|nullable',
            'content.*'     => 'nullable|nullable',
            'sort_order.*'  => 'nullable|numeric|min:0,max:255',
        ];
    }
}
