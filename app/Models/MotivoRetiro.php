<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotivoRetiro extends Model
{

    protected $table    = 'motivos_retiros';
    protected $fillable = ['id', "descripcion", "active"];
    public $timestamps  = false;

    public function fullEstado()
    {
        $estado = "";
        switch ($this->active) {
            case 1:
                $estado = "Activo";
                break;
            case 0:
                $estado = "Inactivo";
                break;
        }
        return $estado;
    }

/**
 * It returns the description of a MotivoRetiro object, given its id.
 * 
 * @param id The id of the record you want to retrieve
 * 
 * @return The return is a string.
 */
    public static function getMotivo($id){

    	$motivo = MotivoRetiro::find($id);

    	if( count($motivo) <= 0 ){
    		return "";
    	}else{
    		return $motivo->descripcion;
    	}
    }

}
