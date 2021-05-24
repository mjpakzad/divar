<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromoteRequest extends FormRequest
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
            'ladder'    => 'in:0,1|required_without_all:featured,renewal,reportage',
            'featured'  => 'in:0,1|required_without_all:ladder,renewal,reportage',
            'renewal'   => 'in:0,1|required_without_all:featured,ladder,reportage',
            'reportage' => 'in:0,1|required_without_all:featured,renewal,ladder',
        ];
    }
}
