<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotivoRechazoCandidato extends Model
{

    protected $table    = 'motivo_rechazo_candidato';
    protected $fillable = ["descripcion", "updated_at", "created_at",
    ];

}
