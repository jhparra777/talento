<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoJornada extends Model
{

    protected $table    = 'tipos_jornadas';
    protected $fillable = ['id', "descripcion", "codigo", "active", "hora_inicio", "hora_fin", "procentaje_horas"];
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
