<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosTemporales extends Model
{
    protected $table    = 'datos_temporales';
    protected $fillable = ['id', 'correo', 'nombres', 'celular', 'mensaje', 'modulo','numero_id','video_entrevista_prueba'];
}
