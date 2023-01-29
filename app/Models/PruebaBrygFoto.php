<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaBrygFoto extends Model
{
    protected $table = 'prueba_brig_candidatos_fotos';
    protected $fillable = [
    	'prueba_id',
    	'user_id',
    	'req_id',
    	'descripcion'
    ];
}
