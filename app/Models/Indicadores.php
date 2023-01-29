<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicadores extends Model
{
    //
    protected $table = "indicadores";

    protected $fillable = ['requerimientos_abiertos','vacantes_solicitadas',
    'vacantes_vencidas','candidatos_contratar','fecha','cliente'];
}
