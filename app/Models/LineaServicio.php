<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineaServicio extends Model
{
    protected $table    = "linea_servicio";
    protected $fillable = ["id", "codigo", "nombre"];
}
