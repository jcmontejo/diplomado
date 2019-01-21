<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGeneration extends FormRequest
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
            'name_diplomat' => 'required',
            'number_generation' => 'required',
            'commision' => 'required',
            'full_price' => 'required',
            'start_date' => 'required',
            'status' => 'required',
            'docent_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name_diplomat.required' => 'El campo nombre de diplomado es obligatorio.',
            'number_generation.required' => 'El campo número de generación es obligatorio.',
            'commision.required' => 'El campo importe de comisión es obligatorio.',
            'full_price.required' => 'El campo importe de FULL PRICE es obligatorio.',
            'status' => 'required',
            'docent_id' => 'required',
            'start_date.required' => 'El campo fecha de inicio es obligatorio.',
        ];
    }
}
