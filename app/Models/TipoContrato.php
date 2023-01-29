<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoContrato extends Model
{
    protected $table    = 'tipos_contratos';
    protected $fillable = ['id', "descripcion", "codigo", "active"];
 
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
