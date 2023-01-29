<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudRecursos extends Model
{
    //
    protected $table = 'solicitud_recurso';
    
    protected $fillable = ['id_solicitud','recurso_necesario'];
}
