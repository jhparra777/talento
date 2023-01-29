<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaValoresPreguntas extends Model
{
    protected $table    = 'prueba_valores_1_preguntas';
    protected $fillable = [
        'descripcion',
        'premisa_1',
        'tipo_premisa_1',
        'premisa_2',
        'tipo_premisa_2',
        'active'
    ];
}
