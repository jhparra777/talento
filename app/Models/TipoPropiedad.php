<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPropiedad extends Model
{
    protected $table    = 'tipo_propiedad';
    protected $fillable = ["descripcion", "active"];


/**
 * It returns the description of a property type, given its id
 * 
 * @param id The id of the record you want to retrieve.
 */
    public static function getPropiedad($id){

    	$propiedad = TipoPropiedad::find($id);

    	if( count($propiedad) <= 0 ){
    		return "";
    	}else{
    		return $propiedad->descripcion;
    	}
    }
}
