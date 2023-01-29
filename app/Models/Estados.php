<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{

    protected $table    = 'estados';
    protected $fillable = ['id', "descripcion", "tipo", "cod_estado", "observaciones"];


    public function estados_requerimientos(){
        return $this->hasMany('App\Models\EstadosRequerimientos',"estado","id");
    }

}
