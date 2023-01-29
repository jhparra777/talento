<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultadoPreguntaCandidatoAplica extends Model
{
    protected $table = 'resultados_preguntas_candidato_aplica';
    protected $fillable = [
    	'id',
    	'req_id',
    	'cargo_id',
    	'preg_id',
    	'user_id',
    	'total_resultado',
    ];
}