<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoVisita extends Model
{
    //
    protected $table    = 'tipos_visitas';
    protected $fillable = ["descripcion","active"];

    

}
