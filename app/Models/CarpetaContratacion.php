<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarpetaContratacion extends Model
{
    //
    protected $table    = 'carpetas_contratacion';
    protected $fillable = ["categoria_id","user_gestion","req_can_id"];

    public function ciudades(){
        return $this->hasMany('App\Models\Ciudad',"agencia","id");
    }

     public function documentosCarpeta()
    {
        return $this->hasMany("App\Models\DocumentoCarpetaContratacion","carpeta_id","id");
    }

}
