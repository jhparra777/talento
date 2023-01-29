<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitaHoraDia extends Model
{
    protected $table    = 'cita_hora_dia';
    protected $fillable = [
        'id',
        'dia_id',
        'hora',
        'estado',
    ];

}
