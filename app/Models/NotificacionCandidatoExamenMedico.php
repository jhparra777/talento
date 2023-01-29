<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacionCandidatoExamenMedico extends Model
{
	protected $table = 'notificacion_candidato_examen_medico';
	protected $fillable = [
		'proceso_id',
		'observacion',
		'req_cand_id',
		'user_gestion_id',
	];
}
