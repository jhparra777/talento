<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaCompetencia extends Model
{
    protected $table = 'prueba_competencias_competencia';
    protected $fillable = [
    	'descripcion',
    	'definicion',
    	'competencia_codigo',
    	'active'
    ];
}
