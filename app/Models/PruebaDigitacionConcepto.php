<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaDigitacionConcepto extends Model
{
    protected $table = 'prueba_digitacion_conceptos';
    protected $fillable = [
    	'digitacion_id',
    	'gestion_id',
    	'concepto'
    ];

    public function gestionConceptoNombre()
    {
    	return $this->hasOne('App\Models\DatosBasicos', 'user_id', 'gestion_id');
    }
}
