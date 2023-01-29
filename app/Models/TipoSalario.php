<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSalario extends Model
{
    //
    protected $table    = 'tipos_salarios';
    protected $fillable = [
        'id',
        'descripcion',
    ];
}
