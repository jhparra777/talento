<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaResultado extends Model
{
    protected $table = 'prueba_competencias_resultados';
    protected $fillable = [
    	'req_id',
		'user_id',
		'gestion_id',
        'ajuste_global',
        'factor_desfase_global',
		'estado',
		'fecha_realizacion'
    ];

    public function solicitadaPor()
    {
        return DatosBasicos::where('user_id', $this->gestion_id)->select('nombres', 'primer_apellido', 'segundo_apellido')->first();
    }
}
