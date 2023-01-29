<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NivelEstudios extends Model
{

    protected $table    = 'niveles_estudios';
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
 * It returns the description of a level of study, given its id.
 * 
 * @param id The id of the record you want to retrieve.
 */
    public static function getNivelEstudio($id){

    	$nivel = NivelEstudios::find($id);

    	if( count($nivel) <= 0 ){
    		return "";
    	}else{
    		return $nivel->descripcion;
    	}
    }

}
