<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClausulaValorCargo extends Model
{
    //
    protected $table    = 'clausulas_valor_cargo';
    protected $fillable = [
    	'cargo_id',
    	'adicional_id',
    	'valor'
    ];
}
