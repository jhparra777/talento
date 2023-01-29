<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaLogo extends Model
{
    //
    protected $table    = 'empresa_logos';
    protected $fillable = [
    	"nombre_empresa",
    	"nit",
    	"direccion",
    	"ciudad",
    	"telefono",
    	"logo"
    ];
}
