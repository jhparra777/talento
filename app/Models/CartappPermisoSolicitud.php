<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartappPermisoSolicitud extends Model
{
    protected $table      = 'cartapp_permiso_solicitud';
    protected $fillable   = [
        'numero_id',
        'motivo_termino_id',
        'gestiono',
        'permiso_solicitud',
        'fecha_fin_contrato',
        'otro_motivo'
    ];

    public function datos_basicos() {
        return $this->belongsTo('App\Models\DatosBasicos', 'numero_id', 'numero_id');
    }
}
