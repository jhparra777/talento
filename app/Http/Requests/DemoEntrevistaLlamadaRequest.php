<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DemoEntrevistaLlamadaRequest extends Request
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
            'correo'            => 'required|email|max:255|unique:datos_temporales,correo',
            'numero_id'   => 'required|numeric|unique:datos_temporales,numero_id',
        ];
    }

    public function messages()
    {
        return [
            //"favicon.dimensions" => "La dimensiones de la imagen debe ser de 32px x 32px.",
        ];
    }
}
