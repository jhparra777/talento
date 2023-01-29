<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facturacion extends Model
{
    protected $table    = 'facturacion';
    protected $fillable = [
    	'id',
        'req_id',
        'user_id',
        'factura_entrega_terna',
        'recaudo_centrega_terna',
        'factura_cierre_proceso',
        'recaudo_cierre_proceso',
        'estado',
        'observaciones'
    ];


    public function candidatosContratar()
    {
        $estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
        ];
        
        $candidatos_req = $this->hasMany("App\Models\Requerimiento", "id", "requerimiento_id")
            ->join('requerimiento_cantidato','requerimiento_cantidato.requerimiento_id','=','requerimientos.id')
            ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
            ->groupBy('procesos_candidato_req.candidato_id')
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
             ->where("procesos_candidato_req.proceso", "ENVIO_CONTRATACION")
            ->select(
                'users.name as nombre',
                'procesos_candidato_req.created_at as fecha_contratacion'
            )->get();

        return $candidatos_req;
    }

public function candidatosEnviadosCliente()
    {
        $estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
        ];
        
        $candidatos_req = $this->hasMany("App\Models\Requerimiento", "id", "requerimiento_id")
            ->join('requerimiento_cantidato','requerimiento_cantidato.requerimiento_id','=','requerimientos.id')
            ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
            ->groupBy('procesos_candidato_req.candidato_id')
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
             ->where("procesos_candidato_req.proceso", "ENVIO_APROBAR_CLIENTE")
            ->select(
                'users.name as nombre',
                'procesos_candidato_req.created_at as fecha_contratacion'
            )
            ->orderBy('procesos_candidato_req.created_at','desc')
            ->get();

        return $candidatos_req;
    }

    public static function estadoFacturacion($req_id = null){

        $estado = Facturacion::
            where("req_id", $req_id)
            ->select("estado")
            ->first();

        if($estado == null){
            $result = "Facturar";
        }else{
            $result = $estado->estado;
        }

        return $result;
    }
    
}
