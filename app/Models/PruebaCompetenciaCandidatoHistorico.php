<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaCandidatoHistorico extends Model
{
    protected $table = 'prueba_competencias_candidatos_historicos';
    protected $fillable = [
    	'user_id',
    	'req_id',
    	'prueba_id',
		'codigo_pregunta',
		'pregunta',
		'opcion'
    ];
}
