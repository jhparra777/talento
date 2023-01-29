<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\ReqCandidato;

class CitacionCargaBd extends Model
{

    protected $table    = 'citacion_carga_db';

    protected $fillable = [
        'id',
        'lote',
        'user_carga',
        'identificacion',
        'nombres',
        'primer_apellido',
        'segundo_apellido',
        'telefono_fijo',
        'telefono_movil',
        'email',
        'estado',
        'motivo',
        'observaciones',
        'remitido_call',
        'nombre_carga',
        'user_id',
        'req_id',
        'tipo_fuente',
        'palabras_clave',
        'cargo_id',
        'archivo_carga'
    ];

//Sacar el codigo USER_ID para saber que el candidato ya esta registrado
    public function getCitacionGestionar()
    {
        $candidato = DB::table("datos_basicos")->where("numero_id", $this->identificacion)
            ->first();

        if ($candidato == null) {
            return "";
        }
        return $candidato->user_id;
    }

//Sacar el nombre del quien realizo el envio a citación
    public function getCitacionEnvio()
    {
        $candidato = DB::table("datos_basicos")->where("user_id", $this->user_carga)
            ->first();

        if ($candidato == null) {
            return "";
        }
        $nombre = $candidato->nombres . " " . $candidato->primer_apellido . "" . $candidato->segundo_apellido;
        return $nombre;
    }

//Sacar el nombre del motivo por el que se guardo para citacion
    public function getCitacionMotivo()
    {
        $motivo = DB::table("motivo_recepcion")->where("id", $this->motivo)
            ->first();

        if ($motivo == null) {
            return "";
        }
        return $motivo->descripcion;
    }

    public function getCandidatoReq()
    {
       // dd($this->id);
      //para saber si el candidato fue asignado a algun req
      $citaciones = CitacionCargaBd::join('datos_basicos','datos_basicos.numero_id','=','citacion_carga_db.identificacion')->join('users','users.id','=','datos_basicos.user_id')
        ->join('requerimiento_cantidato','requerimiento_cantidato.candidato_id','=','users.id')
        ->where('users.id','=',$this->user_id)
        ->select(DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimiento_cantidato.requerimiento_id limit 1 ) as estado_req'),'requerimiento_cantidato.requerimiento_id as req_id')
          ->orderBy("requerimiento_cantidato.id", "desc")
          ->first();
      //dd($citaciones);
      return $citaciones;
    }

}
