<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFuncionalidadAvanzada extends Model
{
    //
    protected $table    = 'tipo_funcionalidad_avanzada';
    protected $fillable = [
    	'id',
    	'descripcion'
    ];
}
