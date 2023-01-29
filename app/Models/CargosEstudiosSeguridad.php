<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargosEstudiosSeguridad extends Model
{
    //
    protected $table    = 'cargos_estudios_seguridad';
    protected $fillable = [
    	'cargo_id',
    	'estudio_seg_id',
    ];
}
