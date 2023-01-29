<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaConcepto extends Model
{
    protected $table = 'prueba_competencias_conceptos';
    protected $fillable = [
    	'prueba_id',
    	'gestion_id',
    	'concepto'
    ];

    public function gestionConceptoNombre()
    {
    	return $this->hasOne('App\Models\DatosBasicos', 'user_id', 'gestion_id');
    }
}
