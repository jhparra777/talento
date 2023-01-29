<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClausulaValorCandidato extends Model
{
    //
    protected $table    = 'clausulas_valor_candidatos';
    protected $fillable = [
    	'user_id',
    	'req_id',
    	'adicional_id',
    	'valor'
    ];

    public function adicional()
    {
        return $this->belongsTo('App\Models\DocumentoAdicional', 'adicional_id', 'id');
    }
}
