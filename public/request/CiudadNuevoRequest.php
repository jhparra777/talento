<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CiudadNuevoRequest extends Request
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
        'nombre' => 'required',
        'cod_pais' => 'required',
        'cod_departamento' => 'required',
        'cod_ciudad' => 'required',
        'homologa_id' => 'required'

        ];
    }

    public function messages()
    {
        return [

            "homologa_id.required" => "El campo código es obligatorio"
        ];
    }
}
