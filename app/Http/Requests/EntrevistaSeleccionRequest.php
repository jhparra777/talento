<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EntrevistaSeleccionRequest extends Request {

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
            "req_id" => "required",
            "fuentes_publicidad_id" => "required",
            "aspecto_familiar" => "required",
            "aspecto_academico" => "required",
            "aspectos_experiencia" => "required",
            "aspecto_familiar" => "required",
            "fortalezas_cargo" => "required",
            "oportunidad_cargo" => "required",
            "concepto_general" => "required",
        ];
    }

    public function messages() {
        return[
            "req_id.required" => "Debe selecionar un requerimiento."
        ];
    }

}
