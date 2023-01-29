<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table    = 'localidades';
    protected $fillable = ["id", "codigo", "nombre"];

}
