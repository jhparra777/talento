<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreliminarTranversales extends Model
{
    protected $table    = 'preliminar_transversales';
    protected $fillable = [
    	'id', 'descripcion', 'puntuacion', 'estado',
    ];
}
