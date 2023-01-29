<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenMedica extends Model
{
    //
    protected $table    = 'orden_medica';
    protected $fillable = ['req_can_id','proveedor_id',"observacion","resultado","user_envio"];


    public function estados(){
    	return $this->hasMany('App\Models\EstadosOrdenes','orden_id');
    }


     public function examenes_medicos(){
    	return $this->hasMany("App\Models\ExamenesMedicos", "orden_id");
	}
}
