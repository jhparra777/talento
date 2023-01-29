<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoCarpetaContratacion extends Model
{
    //
    protected $table    = 'documentos_carpetas_contratacion';
    protected $fillable = ["carpeta_id","tipo_documento_id","nombre_documento"];

    /*public function ciudades(){
        return $this->hasMany('App\Models\Ciudad',"agencia","id");
    }*/

}
