<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtributoValores extends Model
{
    protected $table    = "atributos_valores";
    protected $fillable = [
        "id",
        "cod_atributo",
        "valor_atributo",
        "req_id",
    ];
}
