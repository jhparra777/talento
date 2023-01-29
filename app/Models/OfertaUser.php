<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfertaUser extends Model
{
    protected $table    = 'ofertas_users';
    protected $fillable = [
        'user_id',
        "requerimiento_id",
        "fecha_aplicacion",
        "cedula",
        "referer",
        "estado",
        "aplica"
    ];

    public function datos_basicos() {
        return $this->belongsTo('App\Models\DatosBasicos', 'user_id', 'user_id');
    }
}
