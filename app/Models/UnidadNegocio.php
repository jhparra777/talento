<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadNegocio extends Model
{
    protected $table    = 'unidades_negocios';
    protected $fillable = ["id", "codigo", "nombre"];
}
