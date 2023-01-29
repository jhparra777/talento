<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaValoresInterpretacion extends Model
{
    protected $table    = 'prueba_valores_1_interpretacion';
    protected $fillable = [
        'rango_inferior',
        'rango_superior',
        'interpretacion_texto',
        'interpretacion_estrellas',
        'amor',
        'no_violencia',
        'paz',
        'rectitud',
        'verdad'
    ];
}
