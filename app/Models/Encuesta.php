<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table      = 'encuestas';

    protected $fillable   = [
        "id",
        "user_id",
        "nombre_admin",
        "satisfecho",
        "ideas",
        "recomienda",
        "nombre_recomendado",
        "telefono_recomendado"
    ];
}
