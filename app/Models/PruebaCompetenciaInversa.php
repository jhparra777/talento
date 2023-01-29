<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaInversa extends Model
{
    protected $table = 'prueba_competencias_preguntas_inversas';
    protected $fillable = [
    	'id',
    	'directa_id',
		'descripcion',
		'codigo',
		'inversa',
		'active'
    ];
}
