<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstadoCivil extends Model
{

    protected $table    = 'estados_civiles';
    protected $fillable = ['id', "descripcion", "codigo", "active"];

    public static function getEstado($id){

    	$estado = EstadoCivil::find($id);

    	if( count($estado) <= 0 ){
    		return "";
    	}else{
    		return $estado->descripcion;
    	}

    }

}
