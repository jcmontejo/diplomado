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
            'email' => 'required|email',
            // 'profession' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'last_name.required' => 'El campo apellido paterno es obligatorio.',
            'mother_last_name.required' => 'El campo apellido materno es obligatorio.',
            'birthdate.required' => 'El campo fecha de nacimiento es obligatorio.',
            'sex.required' => 'El campo genero es obligatorio.',
            'phone.required' => 'El campo teléfono es obligatorio.',
            'address.required' => 'El campo dirección es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'digits' => 'El teléfono debe ser de 10 digitos.'
        ];
    }
}
