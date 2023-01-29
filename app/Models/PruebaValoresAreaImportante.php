<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaValoresAreaImportante extends Model
{
    protected $table    = 'prueba_valores_1_area_importante';
    protected $fillable = [
        'amor_mayor',
        'no_violencia_mayor',
        'paz_mayor',
        'rectitud_mayor',
        'verdad_mayor',
        'amor_menor',
        'no_violencia_menor',
        'paz_menor',
        'rectitud_menor',
        'verdad_menor',
        'active'
    ];
}
