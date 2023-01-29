<?php

namespace App\Models;
use App\Models\Estados;

use Illuminate\Database\Eloquent\Model;

class EstadosRequerimientos extends Model
{
    protected $table    = 'estados_requerimiento';
    protected $fillable = ['id', "estado", "user_gestion", "req_id", "observaciones", "motivo"];

    public function estadoRequerimiento_req()
    {
        $estado = Estados::where('id',$this->estado)->select('descripcion as estado_nombre')->first();

        if ($estado == null) {
            $estado = "";
        }

        return $estado['estado_nombre'];
    }

    public function requerimiento(){
        return $this->belongsTo('App\Models\Requerimiento',"req_id");
    }

    public function estado_tipo(){
        return $this->belongsTo('App\Models\Estados',"estado");
    }

}
