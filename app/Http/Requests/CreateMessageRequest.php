<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMessageRequest extends FormRequest
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
            'message' => 'required|max:140',
            'image' => 'required|image'
        ];
    }

    /**
     * Añadir mensajes custom de validacion
     */

    public function messages(){
        return[
            'message.max' => 'El mensaje no debe superar los 140 caracteres',
            'message.required' => 'Por favor, ingresa un mensaje',
        ];
    }
}
