<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequerimientoRequest extends FormRequest
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
            "tipo_proceso_id"       => "required",
            "ciudad_id"             => "required",
            "solicitado_por_txt"    => "required",
            "cargo_especifico_id"   => "required",
            "ctra_x_clt_codigo"     => "required",
            "tipo_jornadas_id"      => "required",
            "tipo_liquidacion"      => "required",
            "tipo_salario"          => "required",
            "tipo_nomina"           => "required",
            "concepto_pago_id"      => "required",
            "salario"               => "required",
            "tipo_contrato_id"      => "required",
            "motivo_requerimiento_id" => "required",
            "funciones"               => "required",
            "fecha_ingreso"           => "required",
            "fecha_retiro"            => "required",
            "nivel_estudio"           => "required",
            "tipo_experiencia_id"     => "required",
            "edad_minima"             => "required",
            "edad_maxima"             => "required",
            "genero_id"               => "required",
            "estado_civil"            => "required",
            "fecha_recepcion"         => "required",
            "contenido_email_soporte" => "required" 
        ];
    }

    public function messages()
    {
        return [
            'tipo_proceso_id.required' => 'El campo tipo solicitud es obligatorio',
            'ciudad_id.required'  => 'El campo ciudad de trabajo es obligatorio',
            'solicitado_por_txt.required'  => 'El campo nombre solicitante es obligatorio',
            'cargo_especifico_id.required' => 'El campo cargo cliente es obligatorio',
            'ctra_x_clt_codigo.required' => 'El campo clase de riesgo es obligatorio',
            'tipo_jornadas_id.required' => 'El campo jornada laboral es obligatorio',
            'tipo_liquidacion.required' => 'El campo tipo liquidación es obligatorio',
            'tipo_nomina.required' => 'El campo tipo nómina es obligatorio',
            'concepto_pago_id.required' => 'El campo concepto pago es obligatorio',
            'tipo_contrato_id.required' => 'El campo tipo contrato es obligatorio',
            'motivo_requerimiento_id.required' => 'El campo motivo requerimiento es obligatorio',
            'funciones.required' => 'El campo funciones a realizar es obligatorio',
            'fecha_ingreso.required' => 'El campo fecha tentativa de ingreso es obligatorio',
            'tipo_experiencia_id.required' => 'El campo tiempo experiencia es obligatorio',
            'genero_id.required' => 'El campo género es obligatorio',
            'fecha_recepcion.required' => 'El campo fecha recepción es obligatorio',
        ];
    }
}
