<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OmnisaludCliente extends Model
{
    //
    protected $table = 'omnisalud_clientes';
    protected $fillable = [
    	'descripcion',
    	'empresa_logo_id',
    	'active'
    ];
}
