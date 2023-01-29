<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaExcelRespuestaIntermedio extends Model
{
    protected $table    = 'prueba_excel_respuestas_intermedio';
    protected $fillable = [
        'user_id',
        'pregunta_id',
        'respuesta_user_id',
        'opcion_id'
    ];

    public function pregunta() {
        return $this->belongsTo('App\Models\PruebaExcelPreguntas', 'pregunta_id', 'id');
    }

    public function preguntaOpciones() {
    	return PruebaExcelPreguntas::join('prueba_excel_opciones', 'prueba_excel_opciones.pregunta.id_pregunta', '=', 'prueba_excel_preguntas.id')->where('prueba_excel_preguntas.id', $this->pregunta_id)->first();
    }

    public function opciones() {
    	return $this->hasMany('App\Models\PruebaExcelOpciones', 'id_pregunta', 'pregunta_id');
    }
}
