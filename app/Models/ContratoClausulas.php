<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratoClausulas extends Model
{
    //
    protected $table    = 'clausula_contrato';
    protected $fillable = ['tipo_contrato_id','id_clausulas'];
}
