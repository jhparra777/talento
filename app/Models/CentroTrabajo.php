<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentroTrabajo extends Model
{
    //
    protected $table    = 'centros_trabajo';
    protected $fillable = [
        'id',
        'nombre_ctra',
    ];
}
