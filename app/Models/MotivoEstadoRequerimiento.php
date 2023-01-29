<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotivoEstadoRequerimiento extends Model
{
    protected $table    = 'motivo_estado_requerimiento';
    protected $fillable = [
        'descripcion'

    ];

}