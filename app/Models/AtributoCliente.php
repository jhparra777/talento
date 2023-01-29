<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtributoCliente extends Model
{
    protected $table    = "atributos_clientes";
    protected $fillable = [
        "id",
        "cod_atributo",
        "cliente_id",
    ];
}
