<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidatoReclutamientoExterno extends Model
{

    protected $table    = 'candidatos_reclutamiento_externo';
    protected $fillable = [
        'req_id',
        'candidato_id',
        'usuario_carga'
     
    ];

   

}



