<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\DB;

class ExperienciaRequest extends Request
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
    public function rules() {
        if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co" ){
            return [
                "nombre_empresa" => "required|max:50",
                "ciudad_id" => "required",
                //"nombres_jefe" => "required|min:7|max:100",
                "cargo_desempenado" => "required",
                //"cargo_jefe" => "required",
                "autoriza_solicitar_referencias" => "required",
                //"fijo_jefe" => "numeric",
                "telefono_temporal" => "numeric",
                "fecha_inicio" => "required|date",
                "salario_devengado" => "required|numeric",
                "funciones_logros" => "required|min:15|max:2048",
                "fecha_final" => "required_unless:empleo_actual,1",
                "cargo_especifico"=>"required",
                //"movil_jefe" => "required|min:10|max:10",
                
            ];
        }

        if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co" ){
            return [
                "fecha_inicio" => "required_unless:tiene_experiencia,0|date_format:m-Y",
                //"fecha_final" => "required_unless:tiene_experiencia,1|date_format:m-Y",
                "salario_devengado" => "required_unless:tiene_experiencia,0|numeric",
                //"fecha_final" => "required_unless:empleo_actual,1_unless:empleo_actual,1|date_format:m-Y|after:fecha_inicio",
                //"nombre_empresa" => "required|max:5null",
                //"ciudad_id" => "required",           
                //"autoriza_solicitar_referencias" => "required",
                //"fecha_inicio" => "required|date",
                //"salario_devengado" => "required|numeric",
                //"fecha_final" => "required_unless:empleo_actual,1|date|after:fecha_inicio",
                "cargo_especifico"=>"required"
            ];
        }

        if(route('home') == "https://gpc.t3rsc.co" || route('home') == "http://localhost:8000"){
            return [
                "nombre_empresa" => "required|max:50",
                /*"ciudad_id" => "required",*/
                "nombres_jefe" => "required|min:7|max:100",
                "cargo_desempenado" => "required",
                "cargo_jefe" => "required",
                "autoriza_solicitar_referencias" => "required",
                "fijo_jefe" => "numeric",
                "telefono_temporal" => "numeric",
                "fecha_inicio" => "required|date",
                /*"salario_devengado" => "required|numeric",*/
                "funciones_logros" => "required|min:15|max:2048",
                "fecha_final" => "required_unless:empleo_actual,1"
            ];
        }

        return [
            "nombre_empresa" => "required|max:50",
            "ciudad_id" => "required",
            "nombres_jefe" => "required|min:7|max:100",
            "cargo_desempenado" => "required",
            "cargo_jefe" => "required",
            "autoriza_solicitar_referencias" => "required",
            "fijo_jefe" => "numeric",
            "telefono_temporal" => "numeric",
            "fecha_inicio" => "required|date",
            "salario_devengado" => "required|numeric",
            "funciones_logros" => "required|min:15|max:2048",
            "fecha_final" => "required_unless:empleo_actual,1"
            /*"cargo_especifico"=>"required",*/
            /*"movil_jefe" => "required|min:10|max:10",*/
            
        ];
    }

    public function messages() {
        return [
            "autoriza_solicitar_referencias.required" => "Debe autorizar la referencia.",
            "fecha_final.required_unless" => "Debe seleccionar una fecha de terminación donde trabajo"
        ];
    }

}
