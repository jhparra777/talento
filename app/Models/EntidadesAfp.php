<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntidadesAfp extends Model
{

    protected $table    = 'entidades_afp';
    protected $fillable = ['id', "descripcion", "active", "codigo"];

    public static function getNameAfp($id){

    	$afp = EntidadesAfp::find($id);

    	if(count($afp) <= 0){
    		return '';
    	}else{
    		return $afp->descripcion;
    	}

    }

}
