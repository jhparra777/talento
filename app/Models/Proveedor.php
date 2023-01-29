<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    //
    protected $table    = 'proveedor';
    protected $fillable = ["nombre","direccion","telefono","email"];
}
