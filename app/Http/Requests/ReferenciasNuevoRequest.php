<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\TipoRelacion;

class ReferenciasNuevoRequest extends Request
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
        if(route('home') == "https://gpc.t3rsc.co"){
            return [
                "nombres"               => "required",
                "primer_apellido"       => "required",
                // "segundo_apellido"   => "required",
                "tipo_relacion_id"      => "required",
                "telefono_movil"        => "required|numeric",
                //"telefono_fijo"       => "numeric",
                "ciudad_autocomplete"   => "required",
                "empresa"               => "required",
                //"correo"                => "required",
                //"ocupacion"             => "required"
            ];
        }

        return [
            "nombres"          => "required",
            "primer_apellido"  => "required",
            // "segundo_apellido" => "required",
            "tipo_relacion_id" => "required",
            "telefono_movil"   => "required|numeric",
            //"telefono_fijo" => "numeric",
            "ciudad_autocomplete"    => "required",
            //"codigo_ciudad"    => "required",
            "ocupacion"        => "required",
        ];
    }

    public function messages()
    {
        return [

            "tipo_relacion_id.required" => "Debe seleccionar un tipo de relacion.",
            "codigo_ciudad.required"    => "Debe seleccionar una ciudad.",
            "ciudad_autocomplete.required"    => "Este campo es obligatorio",

        ];
    }

    

}
