<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultadoGeneralAplica extends Model
{
    protected $table = 'resultados_generales_aplica';
    protected $fillable = [
    	'id',
    	'req_id',
    	'cargo_id',
    	'user_id',
    	'total_global'
    ];
}
