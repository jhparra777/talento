<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaLicencias extends Model
{

    protected $table    = 'categorias_licencias';
    protected $fillable = ['id', "descripcion", "active", "codigo"];
    public $timestamps  = false;

    public static function getCategoria($id){
        
        $categoria = CategoriaLicencias::find($id);
        
        if(count($categoria) <= 0){
            return '';
        }else{
            return $categoria->codigo;
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
