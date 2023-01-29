<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parentesco extends Model
{

    protected $table    = 'parentescos';
    protected $fillable = ["descripcion", "active"];
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
 * It returns the description of a relationship if it exists, otherwise it returns an empty string
 * 
 * @param id The id of the parentesco you want to get the description of.
 * 
 * @return The return value is a string.
 */
    public static function getParentesco($id){

    	$parentesco = Parentesco::find($id);

    	if( count($parentesco) <= 0 ){
    		return "";
    	}else{
    		return $parentesco->descripcion;
    	}
    }

}
