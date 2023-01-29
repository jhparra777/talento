<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControlFuncionalidad extends Model
{
    //
    protected $table    = 'control_funcionalidad';
    protected $fillable = [
    	'id',
    	'tipo_funcionalidad',
    	'limite',
    	'empresa'
    ];
}
