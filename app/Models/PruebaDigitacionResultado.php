<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaDigitacionResultado extends Model
{
    protected $table = 'prueba_digitacion_candidato_resultados';
    protected $fillable = [
    	'req_id',
    	'user_id',
    	'gestion_id',
    	'ppm',
        'pulsaciones',
    	'precision_user',
    	'correctas',
    	'incorrectas',
    	'estado',
    	'fecha_realizacion'
    ];

    public function solicitadaPor()
    {
        return DatosBasicos::where('user_id', $this->gestion_id)->select('nombres', 'primer_apellido', 'segundo_apellido')->first();
    }
}
