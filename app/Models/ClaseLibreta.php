<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaseLibreta extends Model
{
    protected $table    = 'clases_libretas';
    protected $fillable = ['id', "descripcion", "active"];
    public $timestamps  = false;

    public static function getTipo($id){

        $tipo = ClaseLibreta::find($id);

        if( count($tipo) <= 0 ){
            return "";
        }else{
            return $tipo->descripcion;
        }

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
