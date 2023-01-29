<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocioDemograficoRespuestasUser extends Model
{
    protected $table    = 'sociodemografico_respuestas_user';
    protected $fillable = [
        'requerimiento_candidato_id',
        'req_id',
        'candidato_id',
        'fecha_respuesta',
        'respuestas'
    ];

    public function requerimiento() {
        return $this->belongsTo('App\Models\Requerimiento', 'req_id', 'id');
    }
}
