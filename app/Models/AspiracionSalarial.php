<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AspiracionSalarial extends Model
{

    protected $table    = 'aspiracion_salarial';
    protected $fillable = ['id', "descripcion", "active"];
    public $timestamps  = false;

    public static function getAspiracion($id){

        $salario = AspiracionSalarial::find($id);

        if(count($salario) <= 0){
            return '';
        }else{
            return $salario->descripcion;
        }

    }

    public function fullEstado()
    {
        $estado = "";
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
