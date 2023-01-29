<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recepcion extends Model
{

    protected $table    = 'recepcion';
    protected $fillable =
        [
        'id',
        "turno",
        "estado",
        "candidato_id",
        "user_terminacion",
        "proceso",
        "USER_ENVIO",
        "motivo",
        "numero_ficha",
        "documento_deja",
        "pais_trabajo",
        "departamento_trabajo",
        "ciudad_trabajo",
        "unidad",
        "user_seleccion",
    ];

}
