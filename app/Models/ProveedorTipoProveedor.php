<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProveedorTipoProveedor extends Model
{
    //
      protected $table    = 'proveedor_tipo_proveedor';
    protected $fillable = ["proveedor",'tipo'];
}
