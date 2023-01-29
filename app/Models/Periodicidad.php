<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Periodicidad extends Model
{
    protected $table    = 'periodicidad';
    protected $fillable = ["descripcion"];


    public static function getPeriodicidad($id){

    	$periodicidad = Periodicidad::find($id);

    	if( count($periodicidad) <= 0 ){
    		return "";
    	}else{
    		return $periodicidad->descripcion;
    	}
    }
}
