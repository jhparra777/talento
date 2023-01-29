<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespuestasEntre extends Model
{

    protected $table    = 'respuestas_entre';
    protected $fillable = [
    	"id",
    	"puntuacion",
    	"preg_entre_id",
    	"candidato_id",
    	"respuesta",
    	"created_at",
    	"updated_at",
    ];
}
