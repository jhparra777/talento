<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaDirecta extends Model
{
    protected $table = 'prueba_competencias_preguntas_directas';
    protected $fillable = [
    	'id',
		'descripcion',
		'codigo',
		'nivel_cargo',
		'competencia_id',
		'active'
    ];
}
