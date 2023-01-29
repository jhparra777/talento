<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenEstudioSeguridad extends Model
{
    //
    protected $table    = 'orden_estudio_seguridad';
    protected $fillable = [
    	'req_can_id',
    	'proveedor_id',
    	'resultado',
    	'observacion',
    	'documento',
    ];

    public function estados(){
    	return $this->hasMany('App\Models\EstadosOrdenes','orden_id');
    }
}
