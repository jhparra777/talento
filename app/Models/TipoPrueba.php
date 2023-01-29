<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPrueba extends Model
{

    protected $table    = 'tipos_pruebas';
    protected $fillable = ['id',"descripcion","vigencia","created_at","updated_at","estado"];

    /**
   	 * Descripción del estado de las pruebas
   	 **/
	public function fullEstado()
    {
        $estado = "";
        switch ($this->estado) {
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
