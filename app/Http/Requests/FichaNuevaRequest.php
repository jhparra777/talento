<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class FichaNuevaRequest extends Request
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
            'cliente_id'=>'required',
            'cargo_cliente'=>'required',
            'cantidad_candidatos_vac'=>'required',
            'tiempo_respuesta.t15'=>'integer',
            'tiempo_respuesta.t610'=>'integer|greater_than:tiempo_respuesta.t15',
            'tiempo_respuesta.tmas10'=>'integer|greater_than:tiempo_respuesta.t610',
            'edad_minima'=>'integer|required',
            'edad_maxima'=>'integer|required|greater_than:edad_minima',
            'genero'=>'required',
            'escolaridad'=>'required',
            'experiencia'=>'required',
            'horario'=>'required',
            'rango_salarial'=>'required',
            'tipo_contrato'=>'required',
            'estatura_minima'=>'integer',
            'estatura_maxima'=>'integer|greater_than:estatura_minima'
        ];
           
    }
    
}
