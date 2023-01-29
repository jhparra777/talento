<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoFuentes extends Model
{

    protected $table    = 'tipo_fuente';
    protected $fillable = ["descripcion"];
    public $timestamps  = false;

}
