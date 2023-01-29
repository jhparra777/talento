<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudEstado extends Model
{
    protected $table    = 'solicitud_estado';
    protected $fillable = [
    	'descripcion',
    	'estado',
    	'orden',
    ];
}
