<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormatoContrato extends Model
{
    protected $table    = 'formato_contrato';
    protected $fillable = ["tipo_contrato", "encabezado", "cuerpo_contrato"];
}
