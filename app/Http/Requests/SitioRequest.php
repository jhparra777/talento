<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SitioRequest extends Request
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
            "audio" => "mimes:wav"
        ];
    }

    public function messages()
    {
        return [
            //"favicon.dimensions" => "La dimensiones de la imagen debe ser de 32px x 32px.",
        ];
    }
}
