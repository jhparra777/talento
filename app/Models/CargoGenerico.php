<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoGenerico extends Model
{
    public $timestamps  = false;
    protected $table    = 'cargos_genericos';
    protected $fillable = ['id', "descripcion", "codigo_1", "codigo_2", "estado", "tipo_cargo_id"];

    public function fullEstado()
    {
        $estado = "";
        //dd($this->active);
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

    public function tipoCargo()
    {
        return $this->belongsTo('App\Models\TipoCargo')->first();

    }

    public function cliente()
    {
        return $this ->hasMany('App\Models\Clientes');
    }

}
