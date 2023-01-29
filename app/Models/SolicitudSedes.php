<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudSedes extends Model
{
    protected $table    = 'solicitud_sedes';
    protected $fillable = [
    	'descripcion',
    	'orden',
    	'estado'
    ];

    /**
     * Nombre de la sede
     **/
    public static function nombreSede($sedeId)
    {
    	$sede = Self::where('id', $sedeId)->first();

    	if($sede !== null)
    	{
    		return $sede->descripcion;
    	}else{
    		return "";
    	}
    }
    public function solicidutes(){
        return $this->hasMany('App\Models\Solicitudes');
    }
}
