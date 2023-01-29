<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaFamilia extends Model
{
    protected $table = 'prueba_competencias_familias';
    protected $fillable = [
    	'generico_id',
    	'familia_codigo',
    	'active'
    ];
}
