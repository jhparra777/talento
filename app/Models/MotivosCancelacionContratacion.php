<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotivosCancelacionContratacion extends Model
{
    protected $table    = "motivos_cancelacion_contratacion";
    protected $fillable = [
        "descripcion"
    ];
}