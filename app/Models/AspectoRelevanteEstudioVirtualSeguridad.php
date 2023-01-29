<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AspectoRelevanteEstudioVirtualSeguridad extends Model
{
	protected $table = 'evs_aspecto_relevante_solicitud';
	protected $fillable = [
		'evs_solicitd_id',
		'tipo_aspecto_relevante_id',
		'resultado'
	];

	public function tipo_aspecto_relevante() {
		return $this->belongsTo('App\Models\TipoAspectoRelevanteEstudioVirtualSeguridad', 'tipo_aspecto_relevante_id', 'id');
	}
}
