<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecepcionMotivo extends Model
{
    protected $table    = 'motivo_recepcion';
    protected $fillable = ['id', 'descripcion'];
}
