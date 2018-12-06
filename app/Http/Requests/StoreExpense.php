<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpense extends FormRequest
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
            'concept' => 'required',
            'amount' => 'required',
            'user_id' => 'required',
            'account_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'concept.required' => 'El campo concepto es obligatorio.',
            'amount.required' => 'El campo monto es obligatorio.',
            'user_id.required' => 'El campo usuario es obligatorio.',
            'account_id.required' => 'El campo cuenta es obligatorio.'
        ];
    }
}
