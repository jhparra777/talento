<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\AspiracionSalarial;

class ExperienciaNuevoRequest extends Request {
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

        if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co" || route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co" ){
             
            return [
                "nombre_empresa" => "required|max:50",
                "ciudad_id" => "required",
                "autoriza_solicitar_referencias" => "required",
                "telefono_temporal" => "numeric",
                "fecha_inicio" => "required|date",
                "salario_devengado" => "required|numeric",
                "funciones_logros" => "required|min:15|max:2048",
                "fecha_final" => "required_unless:empleo_actual,1|date|after:fecha_inicio",
                "cargo_especifico"=>"required",
                "movil_jefe" => "required"
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
                "cargo_especifico"=>"required_unless:tiene_experiencia,0",
                "movil_jefe" => "required"
            ];
        }

        if(route('home') == "https://gpc.t3rsc.co"){
            if (Request::get('empleo_actual') == '1') {
                return [
                    "fecha_inicio"      => "required|date",
                    "nombre_empresa"    => "required|max:50",
                    "cargo_desempenado" => "required",
                    "funciones_logros"  => "required",
                    "logros"            => "required",
                    "cargo_especifico"  => "required",
                    "sueldo_fijo_bruto" => "required",
                    "cargo_jefe"        => "required"
                ];
            }else{
                return [
                    "fecha_inicio"      => "required|date",
                    "fecha_final"       => "required|date",
                    "nombre_empresa"    => "required|max:50",
                    "cargo_desempenado" => "required",
                    "funciones_logros"  => "required",
                    "logros"            => "required",
                    "motivo_retiro"     => "required",
                    "cargo_especifico"  => "required",
                    "cargo_jefe"        => "required",
                    "salario_devengado" => "required"
                ];
            }
        }

        return [
            "nombre_empresa" => "required_without_all:tiene_experiencia|max:50",
            "ciudad_id" => "required_without_all:tiene_experiencia",
            "nombres_jefe" => "required_without_all:tiene_experiencia|min:7|max:100",
            "cargo_desempenado" => "required_without_all:tiene_experiencia",
            "cargo_jefe" => "required_without_all:tiene_experiencia",
            "autoriza_solicitar_referencias" => "required_without_all:tiene_experiencia",
            "fijo_jefe" => "numeric",
            "telefono_temporal" => "numeric",
            "fecha_inicio" => "required_without_all:tiene_experiencia|date",
            "salario_devengado" => "required_without_all:tiene_experiencia|numeric",
            "funciones_logros" => "required_without_all:tiene_experiencia|min:15|max:2048",
            "fecha_final" => "required_if:empleo_actual,2|date|after:fecha_inicio",
            "cargo_especifico"=>"required_without_all:tiene_experiencia",     
            "movil_jefe" => "required"
        ];
    }

    public function messages() {
        return [
            "nombre_empresa.required_without_all" => "El campo nombre empresa es obligatorio.",
            "ciudad_id.required_without_all" => "El campo ciudad es obligatorio.",
            "nombres_jefe.required_without_all" => "El campo nombres jefe es obligatorio.",
            "cargo_desempenado.required_without_all" => "El campo cargo desempeñado es obligatorio.",
            "cargo_jefe.required_without_all" => "El campo cargo jefe es obligatorio.",
            "autoriza_solicitar_referencias.required_without_all" => "Debe autorizar la referencia.",
            "fecha_inicio.required_without_all" => "El campo fecha inicio es obligatorio.",
            "funciones_logros.required_without_all" => "El campo funciones y logros es obligatorio.",
            "fecha_final.required_unless" => "Debe seleccionar una fecha de terminación donde trabajo",
            "fecha_final.after" => "Debe seleccionar fecha mayor a fecha de inicio",
            "salario_devengado.required_without_all" => "Debes llenar este campo",
            "fecha_inicio.required_without_all" => "Debes llenar este campo",
            "cargo_especifico.required_without_all"=> "Debes llenar este campo"
        ];
    }

}
