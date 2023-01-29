<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaFoto extends Model
{
    protected $table = 'prueba_competencias_candidatos_fotos';
    protected $fillable = [
    	'prueba_id',
    	'user_id',
    	'req_id',
    	'descripcion'
    ];
}
