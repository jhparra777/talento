<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudCentroBeneficio extends Model
{
    protected $table    = 'solicitud_centro_beneficios';
   	protected $fillable = [
   		'sub_area_id',
    	'descripcion',
    	'orden',
    	'estado'
    ];

    public function solicitudes(){
    	return $this->hasMany('App\Models\Solicitudes');
    }
}
