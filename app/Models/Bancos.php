<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bancos extends Model
{
    //
    protected $table    = 'bancos';
    protected $fillable = ["nombre_banco"];


/**
 * It returns the name of a bank based on the id of the bank.
 * 
 * @param id The id of the record you want to retrieve.
 * 
 * @return The name of the bank.
 */
    public static function getBanco($id){

    	$banco = Bancos::find($id);

    	if( count($banco) <= 0 ){
    		return "";
    	}else{
    		return $banco->nombre_banco;
    	}
    }
}