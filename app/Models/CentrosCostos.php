<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentrosCostos extends Model
{
    //
    protected $table    = "centros_costos";
    protected $fillable = [
        'cliente_id',
        'negocio_id',
        'codigo',
        'descripcion',
        'active',
    ];
}
