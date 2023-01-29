<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocioDemograficoConfiguracion extends Model
{
    protected $table    = 'sociodemografico_configuracion';
    protected $fillable = [
        'encuesta_obligatoria',
        'titulo_encuesta'
    ];
}
