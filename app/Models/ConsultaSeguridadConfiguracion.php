<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaSeguridadConfiguracion extends Model
{
    //
    protected $table    = 'consulta_seguridad_configuracion';
    protected $fillable = [
        'id',
        'factor_bajo',
        'factor_alto'
    ];
}
