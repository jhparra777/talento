<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadosOrdenes extends Model
{
    //
      protected $table    = 'ordenes_estados';
    protected $fillable = ['orden_id','estado_id'];


     public function orden(){
        return $this->belongsTo('App\Models\OrdenMedica',"orden_id","id");
    }
    public function estado(){
        return $this->belongsTo('App\Models\EstadoOrden',"estado_id","id");
    }
}
