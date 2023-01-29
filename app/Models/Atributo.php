<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atributo extends Model
{
    protected $table    = 'atributos';
    protected $fillable = [
        'id',
        'cod_atributo',
        'nombre_atributo',
        'nombre_tag_atributo',
        'tipo_atributo',
        'atributo_atributos',
        'estado',
    ];

}
