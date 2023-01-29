<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vetting extends Model
{
    //
    protected $table    = 'vetting';
    protected $fillable = ["visita_candidato_id","grado_confiabilidad","concepto"];

   

}
