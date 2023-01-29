<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autoentrevist extends Model
{
    //
    protected $table    = 'autoentrevista_cand';
    protected $fillable = ['id_usuario','motivo_cambio','areas_interes','ambiente_laboral','hobbies','membresias','tiempo_experiencia','conoc_tecnico','herr_tecnologicas','fortalezas_cargo','areas_reforzar'];


}
