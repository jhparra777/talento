<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaNivelCompetencia extends Model
{
    protected $table = 'prueba_competencias_nivel_competencia';
    protected $fillable = [
    	'nivel_id',
    	'competencia_id'
    ];

    public function nivel()
    {
    	return $this->belongsTo('App\Models\PruebaCompetenciaNivel', 'nivel_id');
    }

    public function competencia()
    {
    	return $this->belongsTo('App\Models\PruebaCompetenciaCompetencia', 'competencia_id');
    }
}
