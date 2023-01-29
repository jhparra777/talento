<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudSubArea extends Model
{
    protected $table    = 'solicitud_sub_area';
    protected $fillable = [
    	'area_funciones_id',
    	'descripcion',
    	'orden',
    	'estado'
    ];

     /**
     * Nombre de la Sub Area
     **/
    public static function nombreSubArea($areaSubArea)
    {
    	$subArea = Self::where('id', $areaSubArea)->first();

    	if($subArea !== null)
    	{
    		return $subArea->descripcion;
    	}else{
    		return "";
    	}
    }
    public function solicitudes(){
        return $this->hasMany('App\Models\Solicitudes');
    }
}
