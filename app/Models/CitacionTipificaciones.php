<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitacionTipificaciones extends Model
{
    protected $table    = 'citacion_tipificacion';
    protected $fillable = [
        'id',
        'tipificacion',
        'descripcion',
        'estado',
    ];

}
