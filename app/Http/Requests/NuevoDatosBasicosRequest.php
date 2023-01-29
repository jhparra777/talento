<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NuevoDatosBasicosRequest extends Request
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
            "tipo_id"             => "required",
            "numero_id"           => "required|numeric",
            "fecha_expedicion_id" => "required|date",
            "nombres"             => "required",
            "primer_apellido"     => "required",
            // "segundo_apellido"=>"required",
            "fecha_nacimiento"    => "required|date",
            "ciudad_nacimiento"   => "required",
            "genero"              => "required",
            "estado_civil"        => "required",
            // "telefono_fijo"=>"required|numeric",
            "telefono_movil"      => "numeric",
            "aspiracion_salarial" => "required",
            "ciudad_id"           => "required",
            "telefono_movil"      => "numeric",
            "tipo_vehiculo"       => "required_if:tiene_vehiculo,1",
            "numero_licencia"     => "required_if:tiene_vehiculo,1",
            "categoria_licencia"  => "required_if:tiene_vehiculo,1",
            "ciudad_residencia"   => "required",
            "email"               => "required|email",
        ];
    }

    public function messages()
    {
        return [

            "fecha_expedicion.required"      => "Debe seleccionar una fecha de expedicion",
            "nombre.required"                => "Debe digitar el nombre",
            "primer_apellido.required"       => "Debe digitar el primer apellido",
            // "segundo_apellido.required"=>"Debe digitar el segundo apellido",
            "fecha_nacimiento.required"      => "Debe seleccionar una fecha de nacimiento",
            "ciudad_nacimiento.required"     => "Debe seleccionar un lugar de nacimiento",
            "genero.required"                => "Debe seleccionar un genero",
            "estado_civil.required"          => "Debe seleccionar un estado civil",
            //"telefono_fijo.required"=>"Debe digitar un teléfono",
            "aspiracion_salarial.required"   => "Debe seleccionar una aspiracion salarial",
            "ciudad_id.required"             => "Debe seleccionar la ciudad de expedicion de la cédula",
            "ciudad_residencia.required"     => "Debe seleccionar la ciudad de residencia",
            "tipo_vehiculo.required_if"      => "Debe seleccionar tipo de vehiculo",
            "numero_licencia.required_if"    => "Campo obligatorio.",
            "categoria_licencia.required_if" => "Debe seleccionar una categoria.",
        ];
    }
}
