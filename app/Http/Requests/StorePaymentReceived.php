<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentReceived extends FormRequest
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
            'diplomat_id' => 'required',
            'generation_id' => 'required',
            'student_id' => 'required',
            'date_payment' => 'required',
            'payment_method' => 'required',
            'destination_account' => 'required',
            'account_type' => 'required',
            'amount' => 'required',
            'discount' => 'required',
            'total' => 'required'
        ];
    }
}
