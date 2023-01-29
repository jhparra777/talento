<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntasContrato extends Model
{
    //
    protected $table    = 'preguntas_contrato';
    protected $fillable = [
    	'archivo',
    	'audio',
    	'orden'
    ];
}
