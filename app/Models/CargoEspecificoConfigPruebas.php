<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoEspecificoConfigPruebas extends Model
{
    protected $table   = 'cargo_especifico_config_pruebas';

    protected $fillable = [
    	'cargo_especifico_id',
    	'prueba_valores_1',
    	'valor_verdad',
    	'valor_rectitud',
    	'valor_paz',
    	'valor_amor',
    	'valor_no_violencia',
    	'gestiono'
    ];

    public function cargo() {
        return $this->belongsTo('App\Models\CargoEspecifico', 'cargo_especifico_id', 'id');
    }
}
