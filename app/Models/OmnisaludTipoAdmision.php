<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmnisaludTipoAdmision extends Model
{
    //
    protected $table = 'omnisalud_tipo_admision';
    protected $fillable = [
    	'descripcion',
    	'codigo',
    	'active'
    ];
}
