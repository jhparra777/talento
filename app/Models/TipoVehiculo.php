<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoVehiculo extends Model
{

    protected $table    = 'tipos_vehiculos';
    protected $fillable = ['id', "descripcion", "active"];
    public $timestamps  = false;
    
    public static function getVehiculo($id){

        $vehiculo = TipoVehiculo::find($id);

        if( count($vehiculo) <= 0 ){
            return "";
        }else{
            return $vehiculo->descripcion;
        }

    }

    public function fullEstado()
    {
        $estado = "";
        //dd($this->active);
        switch ($this->active) {
            case 1:
                $estado = "Activo";
                break;
            case 0:
                $estado = "Inactivo";
                break;
        }
        return $estado;
    }

}
