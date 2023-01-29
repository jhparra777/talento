<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoLiquidacion extends Model
{
    protected $table    = 'tipos_liquidaciones';
    protected $fillable = [
        'id',
        'descripcion',
        'cod_tipo_liquidacion',
    ];
}
