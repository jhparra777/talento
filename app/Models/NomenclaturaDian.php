<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NomenclaturaDian extends Model
{
    protected $table      = 'nomenclatura_dian';

    protected $fillable   = [
    	'codigo',
    	'descripcion',
		'categoria'
    ];
}
