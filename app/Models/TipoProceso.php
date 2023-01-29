<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoProceso extends Model
{

    protected $table    = 'tipo_proceso';
    protected $fillable = ['id', 'descripcion', 'active'];
    public $timestamps  = false;

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

    public function requerimientos(){
        return $this->hasMany('App\Models\Requerimiento');
    }

}
