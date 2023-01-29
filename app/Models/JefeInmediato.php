<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JefeInmediato extends Model
{
    public $table    = 'jefe_inmediato';
    protected $fillable=["nombre","email"];

    /**
     * Validar si la solicitudes que se muestran el ususario autenticado puede hacer algo con ella
     **/
    
}
