<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudCentroCosto extends Model
{
    protected $table    = 'solicitud_centro_costo';
    protected $fillable = [
   		'centro_beneficios_id',
    	'descripcion',
    	'orden',
    	'estado'
    ];

    public function solicitudes(){
    	return $this->hasMany('App\Models\Solicitudes');
    }

   // public function getFullNameAttribute(){
       // $id = $this->id;
     //   return $id.'-'.$this->attributes['descripcion'];
    //}
}
