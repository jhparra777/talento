<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaBrigFactor extends Model
{
    protected $table      = 'prueba_brig_factores';
    protected $fillable   = [
        'nombre',
        'descripcion',
        'cuadrante'
    ];
}
