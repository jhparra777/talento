<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaValoresNormasNacionales extends Model
{
    protected $table    = 'prueba_valores_1_normas_nacionales';
    protected $fillable = [
        'promedio_amor_',
        'promedio_no_violencia_',
        'promedio_paz_',
        'promedio_rectitud_',
        'promedio_verdad_',
        'desviacion_amor',
        'desviacion_no_violencia',
        'desviacion_paz',
        'desviacion_rectitud',
        'desviacion_verdad'
    ];
}
