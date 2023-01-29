<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clausulas extends Model
{
    //
    protected $table    = 'clausulas';
    protected $fillable = ['tipo_contrato','descripcion'];

}
