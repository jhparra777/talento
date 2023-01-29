<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoNegocio extends Model
{
    protected $table    = "tipo_negocios";
    protected $fillable = ["id", "codigo", "nombre"];
}
