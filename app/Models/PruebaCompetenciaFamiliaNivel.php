<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaFamiliaNivel extends Model
{
    protected $table = 'prueba_competencias_familia_nivel';
    protected $fillable = [
    	'familia_id',
    	'nivel_id'
    ];

    public function familia()
    {
    	return $this->belongsTo('App\Models\PruebaCompetenciaFamilia', 'familia_id');
    }

    public function nivel()
    {
    	return $this->belongsTo('App\Models\PruebaCompetenciaNivel', 'nivel_id');
    }
}
