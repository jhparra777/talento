<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultadoCandidatoAplica extends Model
{
    protected $table = 'resultados_candidato_aplica';
    protected $fillable = [
    	'id',
    	'req_id',
    	'cargo_id',
    	'preg_id',
    	'user_id',
    	'total_resultado_pregunta'
    ];
}