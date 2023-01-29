<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoAspectoRelevanteEstudioVirtualSeguridad extends Model
{
	protected $table    = 'evs_tipos_aspectos_relevantes';
	protected $fillable = [
		'descripcion',
		'active'
	];
}
