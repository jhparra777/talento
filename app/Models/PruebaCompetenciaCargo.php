<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaCargo extends Model
{
    protected $table = 'prueba_competencias_cargo';
    protected $fillable = [
    	'cargo_id',
    	'competencia_id',
    	'nivel_cargo',
    	'nivel_esperado',
    	'margen_acertividad'
    ];
}
