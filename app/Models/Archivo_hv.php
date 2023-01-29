<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivo_hv extends Model
{
    //Tabla para cargar hojas de vida (pdf) al modulo HV.
    protected $table    = "archivo_hv";
    protected $fillable = ["id", "archivo", "user_id"];

}
