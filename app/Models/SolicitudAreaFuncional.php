<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudAreaFuncional extends Model
{
    protected $table    = 'solicitud_area_funciones';
    protected $fillable = [
    	'descripcion',
    	'orden',
    	'estado'
    ];

     /**
     * Nombre de la sede
     **/
    public static function nombreAreaFunciones($areaFuncionesId)
    {
    	$areaFunciones = Self::where('id', $areaFuncionesId)->first();

    	if($areaFunciones !== null)
    	{
    		return $areaFunciones->descripcion;
    	}else{
    		return "";
    	}
    }

    public function solicitudes(){
        return $this->hasMany('App\Models\Solicitudes');
    }
}
