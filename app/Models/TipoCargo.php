<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCargo extends Model
{

    protected $table    = 'tipos_cargos';
    protected $fillable = ['id', "descripcion", "active"];
    public function cargosActivos()
    {
        return $this->hasMany("App\Models\CargoGenerico", "tipo_cargo_id", "id")->where("cargos_genericos.estado", 1)->get();
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
