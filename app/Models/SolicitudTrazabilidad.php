<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudTrazabilidad extends Model
{
    public $table    = 'solicitudes_trazabilidad';
    public $fillable = [
        'solicitud_id',
        'user_id',
        'accion',
        'observacion',
    ];

    /**
     * Validar si la solicitudes que se muestran el ususario autenticado puede hacer algo con ella
     **/
    public static function validaEstado($solicitudId = null, $userId = null)
    {
        $estado = self::
            where('solicitud_id', $solicitudId)
            ->where('user_id', $userId->id)
            ->whereNull('accion')
            ->first();

        if ($estado == null) {
            return 1; //Ya lo gestiono y tiene que ocultar botones
        } else {
            return 0; //No lo gestiono y muestra accion
        }
    }
}
