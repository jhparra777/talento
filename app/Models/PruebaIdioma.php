<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaIdioma extends Model
{
    protected $table = 'pruebas_idiomas';
    protected $fillable = [
    	'id',
		'user_gestion',
		'activo',
		'req_id',
    ];

}
