<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
class EstudiosNuevoRequest extends Request {

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

        if(route('home') == "https://gpc.t3rsc.co"){

            return [
                "nivel_estudio_id"              => "required",
                "titulo_obtenido"               => "required|max:50",
                "universidades_autocomplete"    => "required|max:50",
                "fecha_finalizacion"            => "required_unless:estudio_actual,1",
                //"ciudad_estudio"              => "required",
                "ciudad_autocomplete"           => "required",
                "estatus_academico"             => "required"
            ];

        }else{

            return [
                "nivel_estudio_id"     => "required_without_all:tiene_estudio",
                "titulo_obtenido"      => "required_without_all:tiene_estudio|max:50",
                "institucion"          => "required_without_all:tiene_estudio|max:50",
                "fecha_inicio"         => "required_without_all:tiene_estudio",
                "fecha_finalizacion"   => "required_unless:estudio_actual,1|date|after:fecha_inicio",
                //"fecha_finalizacion"   => "required_unless:estudio_actual,1",
                //"ciudad_estudio"       => "required",
                "ciudad_autocomplete"       => "required_without_all:tiene_estudio"
            ];
      
        }
    }

    public function messages() {
        return [
            "nivel_estudio_id.required_without_all" => "Debe seleccionar un nivel de estudios.",
            "titulo_obtenido.required_without_all" => "Debes llenar este campo.",
            "institucion.required_without_all" => "Debes llenar este campo.",
            //"fecha_finalizacion.required_unless"=>"Debe seleccionar una fecha de terminación.",
            "fecha_finalizacion.required_without_all"=>"Debe seleccionar una fecha de terminación.",
            "ciudad_autocomplete.required_without_all"=>"Debe seleccionar una ciudad",
            "fecha_finalizacion.after" => "Debe seleccionar fecha mayor a fecha de inicio",
        ];
    }

    protected function getValidatorInstance(){
        $validator = parent::getValidatorInstance();
        
        $validator->sometimes('fecha_finalizacion', 'required_without_all:tiene_estudio', function($input) {
            return $input->estudio_actual != 1;
        });

        return $validator;
    }

}
