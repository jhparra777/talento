<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AtributoSelect extends Model
{
    protected $table    = 'atributos_valores_selects';
    protected $fillable = [
        'id',
        'opciones_label',
        'opciones_valores',
        'cod_atributos',
    ];
}
