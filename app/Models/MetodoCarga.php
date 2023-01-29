<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetodoCarga extends Model
{
    //
    protected $table    = 'metodo_carga';
    protected $fillable = ['id', "descripcion"];

    public function users(){
    	return $this->hasMany("App\Models\User","metodo_carga");
    }
}
