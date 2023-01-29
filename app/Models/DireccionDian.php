<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DireccionDian extends Model
{
    protected $table      = 'direccion_dian';

    protected $fillable   = [
    	'user_id',
    	'datos_basicos_id',
		'clase_via_principal',
		'nro_via_principal',
		'letra_via_principal',
		'sufijo_via_principal',
		'letra_complementaria',
		'sector',
		'nro_via_generadora',
		'letra_via_generadora',
		'nro_predio',
		'sector_predio',
		'direccion_complementaria'
    ];
}
