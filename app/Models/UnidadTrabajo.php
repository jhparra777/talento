<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadTrabajo extends Model
{
    protected $table    = 'unidad_trabajo';
    protected $fillable = [
        'id',
        'descripcion',
        'estado',
    ];
}
