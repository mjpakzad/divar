<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommercialRequest extends FormRequest
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
            'title'             => 'required|string|max:191',
            'city'              => 'required|exists:cities,id',
            'district'          => 'nullable|exists:districts,id',
            'content'           => 'nullable',
            'images.*'          => 'nullable|image|mimes:jpg,png,jpeg,gif|max:8000',
            'fields.*'          => 'nullable',
            'status'            => 'required|in:0,1,2',
            'latitude'          => 'nullable',
            'longitude'         => 'nullable',
            'meta_keywords'     => 'nullable',
            'meta_description'  => 'nullable',
            'ladder'            => 'nullable|in:0,1',
            'feature'           => 'nullable|in:0,1',
            'buy'               => 'nullable|in:0,1',
            'whatsapp'          => 'nullable',
            'category'          => 'required|exists:categories,id',
        ];
        switch ($this->method()) {
            case 'POST':
                $rules['user_id']   = 'nullable|exists:users,id';
                break;
            case 'PATCH':
            case 'PUT':
                break;
        }
        return $rules;
    }
}
