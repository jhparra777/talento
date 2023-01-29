<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargosExamenes extends Model
{
    //
      protected $table    = 'cargos_examenes';
    protected $fillable = ["cargo_id",'examen_id'];
}
