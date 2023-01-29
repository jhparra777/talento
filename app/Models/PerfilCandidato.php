<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerfilCandidato extends Model
{
     protected $table    = 'perfilacion_candidato';
    protected $fillable = ['id', "perfil_id","user_id","user_gestion_id"];
}
