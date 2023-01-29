<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsistenteCitaAgendamientoCandidato extends Model
{
    protected $table = 'asistente_citas_agendamiento_candidato';
    
    protected $fillable = [
        'req_id',
        'cita_id',
        'user_id',
        'hora_inicio_cita',
        'hora_fin_cita',
        'agendada',
        'asistio'
    ];

    public function candidatoInformacion()
    {
        return $this->hasOne('App\Models\DatosBasicos', 'user_id', 'user_id')->first();
    }
}