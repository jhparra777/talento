<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaDigitacionCargo extends Model
{
    //
    protected $table = 'prueba_digitacion_configs_cargos';
    protected $fillable = [
    	'cargo_id',
    	'ppm_esperada',
    	'precision_esperada'
    ];
}
