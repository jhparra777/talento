<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequerimientoCompetencia extends Model
{
    //
    protected $table    = 'requerimiento_competencia';
    protected $fillable = ["req_id","competencia_id"];

    

}
