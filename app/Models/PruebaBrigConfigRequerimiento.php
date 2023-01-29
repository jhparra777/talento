<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaBrigConfigRequerimiento extends Model
{
    protected $table      = 'prueba_brig_configuracion_requerimiento';
    protected $fillable   = [
        'req_id',
        'radical',
        'genuino',
        'garante',
        'basico',
        'perfil'
    ];
}
