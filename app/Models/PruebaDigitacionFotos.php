<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaDigitacionFotos extends Model
{
    protected $table = 'prueba_digitacion_candidatos_fotos';
    protected $fillable = [
    	'digitacion_id',
    	'user_id',
    	'req_id',
    	'descripcion'
    ];
}
