<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RespuestaPruebaIdioma extends Model
{
    protected $table    = 'respuestas_pruebas_idiomas';
    protected $fillable = [
        'id',
        'puntuacion',
        'preg_prueba_id',
        'candidato_id',
        'respuesta',
        'created_at',
        'updated_at',
    ];
}
