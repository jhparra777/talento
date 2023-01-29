<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoIdentificacion extends Model
{

    protected $table    = 'tipo_identificacion';
    protected $fillable = ['id', "descripcion", "active", "cod_tipo"];
    public $timestamps  = false;

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
