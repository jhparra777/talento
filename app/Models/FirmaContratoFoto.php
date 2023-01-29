<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirmaContratoFoto extends Model
{
    protected $table      = 'firma_contratos_fotos';
    protected $fillable   = [
    	'contrato_id',
    	'user_id',
    	'req_id',
    	'descripcion',
		'estado'
    ];
}
