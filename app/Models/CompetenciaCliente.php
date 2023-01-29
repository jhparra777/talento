<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetenciaCliente extends Model
{

    protected $table    = 'competencias_cliente';
    protected $fillable = ['id', "competencia_entrevista_id", "cliente_id"];

}
