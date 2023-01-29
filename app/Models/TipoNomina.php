<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoNomina extends Model
{
    //
    protected $table    = 'tipos_nominas';
    protected $fillable = [
        'id',
        'descripcion',
        'cod_concepto_pago',
    ];
}
