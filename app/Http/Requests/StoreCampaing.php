<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaing extends FormRequest
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
            'subject' => 'required|max:50',
            'name' => 'required|max:50',
            'send_date' => 'required|date',
            'message' => 'required',
            'type' => 'required'
        ];

    }

    public function messages()
    {
        return [
            'subject.required' => 'El campo asunto es obligatorio.',
            'name.required' => 'El campo nombre de campaña es obligatorio.',
            'send_date.required' => 'El campo fecha programada de envío es obligatorio.',
            'message.required' => 'El campo mensaje es obligatorio.',
            'type.required' => 'El campo tipo de campaña es obligatorio.'
        ];

    }
}
