<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntaPrecargada extends Model
{
    //
    protected $table    = 'preguntas_precargadas';
    protected $fillable = [
    	'descripcion',
    	'activo',
    	'tipo',
    ];
}
