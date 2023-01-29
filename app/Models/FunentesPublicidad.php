<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FuentesPublicidad extends Model
{

    protected $table    = 'fuentes_publicidad';
    protected $fillable = ['id', "descripcion", "active"];

}
