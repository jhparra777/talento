<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ValidaRegistroHVRequest extends Request
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
            'primer_nombre'      => 'required|max:25',
            //'captcha'          => 'required|captcha',
            'primer_apellido'  => 'required|max:25',
            //'telefono_fijo' => 'required|numeric',
            'telefono_movil'   => 'required|numeric',
            'email'            => 'required|email|max:255|unique:users,email',
            'password'         => 'required|confirmed|min:6|',
            'identificacion'   => 'required|numeric|unique:datos_basicos,numero_id|unique:users,numero_id',
            'acepto_politicas_privacidad' => 'required',
            //'archivo_documento' => 'mimes:jpg,jpeg,png,pdf,doc,docx'
        ];
    }

    

}
