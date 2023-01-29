<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferenciaPersonalVerificada extends Model
{

    protected $table    = 'ref_personales_verificada';
    protected $fillable = [
        'candidato_id',
        'usuario_gestion',
        'req_id',
        'encuestado',
        'dificultades',
        'cualidades',
        'desacuerdo',
        'debe_mejorar',
        'relaciones_interpersonales',
        'created_at',
        'updated_at',
        'observaciones',
        'ref_verificada',
        'referencia_personal_id',
    ];

}
