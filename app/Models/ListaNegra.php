<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListaNegra extends Model
{
    protected $table      = 'lista_negra';
    protected $fillable   = [
        'cedula',
        'restriccion_id',
        'gestiono'
    ];
}
