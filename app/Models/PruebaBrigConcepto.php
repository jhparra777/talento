<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaBrigConcepto extends Model
{
    protected $table      = 'prueba_brig_candidato_concepto';
    protected $fillable   = [
        'bryg_id',
        'gestion_id',
        'concepto'
    ];

    public function gestionConceptoNombre()
    {
    	return $this->hasOne('App\Models\DatosBasicos', 'user_id', 'gestion_id');
    }
}
