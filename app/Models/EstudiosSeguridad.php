<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstudiosSeguridad extends Model
{
    //
    protected $table    = 'estudio_seguridad';
    protected $fillable = [
    	'orden_seg_id',
    	'estudio_seg_id'
    ];
}
