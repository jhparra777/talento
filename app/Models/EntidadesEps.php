<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntidadesEps extends Model
{

    protected $table    = 'entidades_eps';
    protected $fillable = ['id', "descripcion", "active", "codigo","agencias_si"];

    public static function getNameEps($id){

    	$eps = EntidadesEps::find($id);

    	if(count($eps) <= 0){
    		return '';
    	}else{
    		return $eps->descripcion;
    	}

    }

}
