<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NuevoNegocioRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            "cliente_id" => "required",
            "num_negocio" => "required|unique:negocio,num_negocio",
            "tipo_contrato_id" => "required",
            "tipo_proceso_id" => "required",
            "tipo_jornada_id" => "required",
            "ciudad_id" => "required",
             //"regla" =>"regex:/^[a-z0-9]{2,16}$/",
        ];
    }

}