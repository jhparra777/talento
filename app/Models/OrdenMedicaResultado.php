<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenMedicaResultado extends Model
{
    //
    protected $table    = 'orden_medica_resultados';
    protected $fillable = ['orden_id','resultado','fecha_realizacion','observacion','user_gestion'];

    

}
