<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsistenteCita extends Model
{
    protected $table = 'asistente_citas';
    
    protected $fillable = [
        'req_id',
        'gestion_id',
        'asunto_cita',
        'fecha_cita',
        'hora_inicio',
        'hora_fin',
        'duracion_cita',
        'estado_cita'
    ];

    public function candidatosCita()
    {
        return $this->hasMany('App\Models\AsistenteCitaAgendamientoCandidato', 'cita_id', 'id')->where('agendada', 1)->orderBy('hora_inicio_cita');
    }
}