<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmnisaludCiudadesAtencion extends Model
{
    //
    protected $table = 'omnisalud_ciudades_atencion';

    protected $fillable = [
        'id',
        'descripcion',
        'codigo',
        'active'
    ];
}
