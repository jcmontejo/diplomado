<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppoinment extends FormRequest
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
            'date' => 'required|date',
            'start' => 'required',
            'end' => 'required',
            'patient' => 'required',
            'doctor_id' => 'required',
            'room_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => 'El campo fecha es obligatorio.',
            'start.required' => 'El campo hora de inicio es obligatorio.',
            'end.required' => 'El campo hora de fin es obligatorio.',
            'patient' => 'El campo paciente es obligatorio.',
            'doctor_id.required' => 'El campo terapeuta es obligatorio.',
            'room_id.required' => 'El campo consultorio es obligatorio.'
        ];
    }
}
