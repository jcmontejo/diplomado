<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountType extends FormRequest
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
            'account_type' => 'required',
            'account_code' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'account_type.required' => 'El campo tipo de cuota es obligatorio.',
            'account_code.required' => 'El campo código de cuota es obligatorio.',
        ];
    }
}
