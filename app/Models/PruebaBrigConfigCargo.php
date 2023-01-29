<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaBrigConfigCargo extends Model
{
    protected $table      = 'prueba_brig_configuracion_cargo';
    protected $fillable   = [
        'cargo_id',
        'radical',
        'genuino',
        'garante',
        'basico',
        'perfil'
    ];
}
