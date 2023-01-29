<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaReq extends Model
{
    protected $table = 'prueba_competencias_requerimiento';
    protected $fillable = [
    	'req_id',
    	'competencia_id',
    	'nivel_cargo',
    	'nivel_esperado',
    	'margen_acertividad'
    ];
}
