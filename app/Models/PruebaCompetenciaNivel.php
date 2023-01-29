<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaCompetenciaNivel extends Model
{
    protected $table = 'prueba_competencias_niveles';
    protected $fillable = [
    	'descripcion',
    	'nivel_codigo',
    	'active'
    ];
}
