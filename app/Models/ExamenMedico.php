<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class ExamenMedico extends Model
{
    //
    protected $table    = 'examen_medico';
    protected $fillable = ["nombre",'descripcion',"status"];

    public function cargos(){
       return $this->belongsToMany('App\Models\CargoEspecifico', 'cargos_examenes','examen_id','cargo_id');
    }

    public function hasCargo($cargo){

      $existe = DB::table("cargos_examenes")->where("cargo_id",$cargo)
        ->where("examen_id",$this->id)
        ->first();

        if ($existe == null) {
            return false;
        }
        else{
            return true;
        }
    }
}
