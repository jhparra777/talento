<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfirmacionPreguntaContrato extends Model
{
    //
    protected $table    = 'confirmacion_preguntas_contrato';
    protected $fillable = [
    	'user_id',
    	'req_id',
    	'contrato_id',
    	'pregunta_id',
    	'video',
    	'estado'
    ];
}
