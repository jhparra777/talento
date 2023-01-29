<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaBrigOpcion extends Model
{
    protected $table      = 'prueba_brig_opciones';
    protected $fillable   = [
        'brig_preg_id',
        'descripcion',
        'active'
    ];
}
