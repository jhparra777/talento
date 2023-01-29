<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaValoresConfigRequerimiento extends Model
{
    protected $table    = 'prueba_valores_1_config_req';
    protected $fillable = [
        'req_id',
        'prueba_valores_1',
        'valor_verdad',
        'valor_amor',
        'valor_rectitud',
        'valor_paz',
        'valor_no_violencia',
        'tiempo_maximo',
        'gestiono'
    ];

    public function requerimiento() {
        return $this->belongsTo('App\Models\Requerimiento', 'req_id', 'id');
    }
}
