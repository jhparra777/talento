<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmnisaludExamenesMedicos extends Model
{
    //
    protected $table = 'omnisalud_examenes_medicos';
    protected $fillable = [
    	'descripcion',
    	'codigo',
    	'active'
    ];
}
