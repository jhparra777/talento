<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\VisitaCandidato;

class EstudioVirtualSeguridadSolicitudes extends Model
{
	protected $table = 'evs_solicitudes';
	protected $fillable = [
		'req_cand_id',
		'candidato_id',
		'requerimiento_id',
		'tipo_evs_id',
		'user_envio_id',
		'user_gestion_id',
		'apto',
		'concepto',
		'aspecto_rel_analisis_financiero',
		'aspecto_rel_consulta_antecedentes',
		'aspecto_rel_referencia_academica',
		'aspecto_rel_referencia_laboral',
		'aspecto_rel_visita_domiciliaria'
	];

	public function tipo_evs() {
		return $this->belongsTo('App\Models\TipoEstudioVirtualSeguridad', 'tipo_evs_id', 'id');
	}

	public function aspectos_relevantes() {
		return $this->hasMany('App\Models\AspectoRelevanteEstudioVirtualSeguridad', 'evs_solicitud_id', 'id');
	}

	public function obtenerIdVisitaDomiciliaria() {
		$visita = VisitaCandidato::where('candidato_id', $this->candidato_id)
			->where('requerimiento_id', $this->requerimiento_id)
			->orderBy('id', 'desc')
		->first();

		if (!is_null($visita)) {
			return $visita->id;
		}
		return null;
	}
}
