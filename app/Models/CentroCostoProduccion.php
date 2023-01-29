<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CentroCostoProduccion extends Model
{
    protected $table    = "centros_costos_produccion";
    protected $fillable = [
        'id',
        'cod_division',
        'cod_depto_negocio',
        'codigo',
        'descripcion',
        'estado'
    ];
}
