<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VinculacionCandidato extends Model
{

    protected $table    = 'vinculacion_candidato';
    protected $fillable = [
        'id', 'user_id', 'req_id', 'ficha_id', 'id_documento', 'estado',
    ];
}
