<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaSeguridadRegistro extends Model
{
    //
    protected $table    = 'consulta_seguridad_registros';
    protected $fillable = [
    	'id',
    	'user_id',
    	'req_id',
    	'gestion_id',
        'json'
    ];
}
