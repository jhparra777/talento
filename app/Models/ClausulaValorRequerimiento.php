<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClausulaValorRequerimiento extends Model
{
    //
    protected $table    = 'clausulas_valor_requerimiento';
    protected $fillable = [
    	'req_id',
    	'adicional_id',
    	'valor'
    ];
}
