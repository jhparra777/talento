<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargaScanner extends Model
{
      protected $table    = 'carga_scanner';
       protected $fillable = [
        "id",
        "user_carga",
        "user_gestion",
        "identificacion",
        "primer_nombre",
        "segundo_nombre",
        "primer_apellido",
        "segundo_apellido",
        "genero",
        "fecha_nacimiento",
        "rh",
        "asistencia",
        "fuente_recl",
        "entidad_eps",
        "num_emergencia",
    ];

}
