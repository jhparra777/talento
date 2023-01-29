<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoOrden extends Model
{
    //
      protected $table    = 'estado_orden';
    protected $fillable = ['nombre'];

    public function estados(){
    	return $this->hasMany('App\Models\EstadosOrdenes','estado_id');
    }
}
