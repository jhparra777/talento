<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoExperiencia extends Model
{

    protected $table    = 'tipos_experiencias';
    protected $fillable = ['id', 'descripcion', 'active'];

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
