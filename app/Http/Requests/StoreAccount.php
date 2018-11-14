<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccount extends FormRequest
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
            'account_name' => 'required',
            'opening_balance' => 'required' 
        ];
    }

    public function messages()
    {
        return [
            'account_name.required' => 'El campo nombre de cuenta es obligatorio.',
            'opening_balance.required' => 'El campo saldo de apertura es obligatorio.'
        ];
    }
}
