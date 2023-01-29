<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CitaDiaSemana extends Model
{
    protected $table    = 'cita_dia_semana';
    protected $fillable = [
        'id',
        'dia_semana',
        'estado',
    ];

}
