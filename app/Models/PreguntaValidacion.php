<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntaValidacion extends Model
{
    //
    protected $table    = 'preguntas_validacion';
    protected $fillable = [
        'id',
        "user_id",
        "respuesta_1",
        "respuesta_2",
        "respuesta_3",
        "respuesta_4"
    ];
}
