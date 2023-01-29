<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionPsicologo extends Model
{
   protected $table    = 'asignacion_psicologo';
    protected $fillable = ['id', "psicologo_id", "req_id"];
}