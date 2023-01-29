<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaInsight extends Model
{
    protected $table = 'prueba_competencias_insights';
    protected $fillable = [
    	'id',
    	'directa_1',
    	'directa_2',
    	'd1_d2_1_8',
    	'd1_d2_1_4',
    	'd1_d2_1',
    	'd1_d2_0_6',
    	'd1_d2_min_0_6'
    ];
}
