<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConceptoPago extends Model
{
    //
    protected $table    = 'conceptos_pagos';
    protected $fillable = [
        'id',
        'descripcion',
    ];
}
