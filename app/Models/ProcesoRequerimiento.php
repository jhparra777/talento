<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcesoRequerimiento extends Model
{

    protected $table    = 'proceso_requerimiento';
    protected $fillable = ['id',
        'tipo_entidad',
        'entidad_id',
        'requerimiento_id',
        'proceso_adicional',
        'resultado',
        'observacion',
        'created_at',
        'updated_at',
        'user_id'];

}
