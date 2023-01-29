<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmnisaludRegistro extends Model
{
    //
    protected $table = 'omnisalud_registros';
    protected $fillable = [
    	'req_id',
    	'gestion_id',
    	'user_id',
    	'omnisalud_asignacion_id'
    ];
}
