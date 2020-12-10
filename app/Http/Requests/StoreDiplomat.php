<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiplomat extends FormRequest
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
            'name' => 'required|max:250',
            'key' => 'required|max:30',
            //'cost' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del diplomado es obligatorio',
            'key.required' => 'La clave del diplomado es obligatorio',
            //'cost.required' => 'El costo del diplomado es obligatorio',
        ];
    }
}
