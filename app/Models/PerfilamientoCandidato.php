<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilamientoCandidato extends Model
{

    protected $table    = 'perfilamiento_candidato';
    protected $fillable = ['id', "reclutador_id", "candidato_id", "tipo", "tabla", "tabla_id"];

}
