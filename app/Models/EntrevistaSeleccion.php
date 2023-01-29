<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntrevistaSeleccion extends Model
{

    protected $table    = 'entrevista_seleccion';
    protected $fillable = [
        "id", "candidato_id", "usuario_id", "requerimiento_id", "turno_id", "entrevista_id",

    ];

}
