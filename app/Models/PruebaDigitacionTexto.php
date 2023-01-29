<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaDigitacionTexto extends Model
{
    protected $table = 'prueba_digitacion_textos';
    protected $fillable = [
    	'contenido',
    	'idioma',
    	'estado'
    ];
}
