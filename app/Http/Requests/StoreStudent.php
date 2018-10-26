<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudent extends FormRequest
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
            'name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'mother_last_name' => 'required|max:50',
            'birthdate' => 'required|date',
            'sex' => 'required',
            'phone' => 'required|digits:10',
            'address' => 'required',
            'email' => 'required|email'
        ];

    }
}
