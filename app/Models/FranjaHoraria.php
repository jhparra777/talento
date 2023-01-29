<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FranjaHoraria extends Model
{
    protected $table    = 'franja_horaria';
    protected $fillable = ['id', 'descripcion', 'estado'];
}
