<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoRelacion extends Model
{

    protected $table    = 'tipo_relaciones';
    protected $fillable = ['id', "descripcion", "active"];

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
