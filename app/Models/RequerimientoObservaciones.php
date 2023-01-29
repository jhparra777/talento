<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class RequerimientoObservaciones extends Model
{
    protected $table    = 'requerimiento_observaciones';
    
    protected $fillable = ['observacion',"req_id","user_gestion", "tipo_observacion_id"];

   public function requerimiento(){
        return $this->belongsTo('App\Models\Requerimiento',"req_id");
    }

   public function user(){
        return $this->belongsTo('App\Models\User',"user_gestion");
    }

    public function tipo_observacion(){
        return $this->belongsTo('App\Models\TipoObservacionReq',"tipo_observacion_id","id");
    }

}
