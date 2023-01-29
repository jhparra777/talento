<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstudioSeguridadList extends Model
{
    //
    protected $table    = 'estudios_seguridad_list';
    protected $fillable = [
    	'nombre',
    	'descripcion',
    	'status',
    ];
}
