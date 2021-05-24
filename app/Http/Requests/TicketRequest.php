<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            'message'   => 'required|min:10|max:1000',
        ];
        switch ($this->method()) {
            case 'POST':
                $rules['title']         = 'required';
                $rules['priority']      = 'required';
                $rules['attachment.*']  = 'mimes:doc,pdf,docx,zip,jpg,png,jpeg';
                break;
            case 'PATCH':
            case 'PUT':
                break;
        }
        return $rules;
    }
}
