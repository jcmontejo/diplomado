<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctor extends FormRequest
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
            'lastname' => 'required|max:50',
            'phone' => 'required|digits:10',
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'lastname.required' => 'El campo apellidos es obligatorio.',
            'phone.required' => 'El campo teléfono es obligatorio.',
            'digits' => 'El teléfono debe ser de 10 digitos.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
        ];
    }
}
