<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $table    = "respuestas";

    protected $fillable = [
    	"id",
        "preg_id",
    	"descripcion_resp",
    	"puntuacion",
        "minimo",
        "created_at",
        "updated_at"
    ];
}








