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
            'curp' => 'required',
            'last_name' => 'required|max:50',
            'mother_last_name' => 'required|max:50',
            'birthdate' => 'required|date',
            'sex' => 'required',
            'phone' => 'required|digits:10',
            'state' => 'required',
            'city' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'facebook' => 'required',
            //'interested' => 'required',
            //'status' => 'required',
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
            'state.required' => 'El campo estado de residencia es obligatorio.',
            'city.required' => 'El campo ciudad de residencia es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'digits' => 'El teléfono debe ser de 10 digitos.',
            'interested.required' => 'Por favor introduce el o los diplomados en el que este interesado.',
            'status.required' => 'Selecciona un porcentaje del SEMAFORO',
        ];
    }
}
