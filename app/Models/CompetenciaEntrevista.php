<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetenciaEntrevista extends Model
{

    protected $table    = 'competencias_entrevistas';
    protected $fillable = ['id', "nombre"];

}
