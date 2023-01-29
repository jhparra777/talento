<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agencia extends Model
{
    //
    protected $table    = 'agencias';
    protected $fillable = ['id', "descripcion"];

    public function ciudades(){
        return $this->hasMany('App\Models\Ciudad',"agencia","id");
    }

    public function usuarios(){
       return $this->belongsToMany('App\Models\User', 'agencia_usuario','id_agencia','id_usuario');
    }

}
