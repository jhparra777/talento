<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citacion extends Model
{
   protected $table    = 'citaciones';
    protected $fillable = [
        'id',
        'psicologo_id',
        'fecha_cita',
        'motivo_id',
        'updated_at',
        'created_at',
        'req_candi_id',
        'observaciones',
        'estado',
    ];
}
