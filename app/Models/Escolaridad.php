<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Escolaridad extends Model
{

    protected $table    = 'escolaridades';
    protected $fillable = ['id', "descripcion", "active"];

}
