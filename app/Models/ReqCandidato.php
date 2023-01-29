<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use App\Models\Estados;
use DB;

class ReqCandidato extends Model
{
    protected $table    = 'requerimiento_cantidato';
    protected $fillable = [
        'requerimiento_id',
        'candidato_id',
        'estado_candidato',
        'otra_fuente',
        'transferido_a_req',
        'auxilio_transporte',
        'tipo_ingreso',
        'estado_contratacion'
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User',"candidato_id");
    }

    public function procesos(){
        return $this->hasMany('App\Models\RegistroProceso',"requerimiento_candidato_id","id");
    }

    public function contratos(){
        return $this->hasMany('App\Models\RequerimientoContratoCandidato',"requerimiento_candidato_id","id");
    }

    public function getProcesos()
    {
        $procesos = DB::table("procesos_candidato_req")->where("requerimiento_candidato_id", $this->req_candidato_id)
        ->orderBy("procesos_candidato_req.id", "asc")
        ->groupBy("procesos_candidato_req.id")
        ->get();

        if ($procesos == null) {
            $procesos=array();
            return $procesos;
        }

        return $procesos;
    }

    public function getProcesosAsistente($req_cand)
    {
        $procesos = DB::table("procesos_candidato_req")->where("requerimiento_candidato_id", $req_cand)
        ->orderBy("procesos_candidato_req.id", "asc")
        ->groupBy("procesos_candidato_req.id")
        ->get();

        if ($procesos == null) {
            return "";
        }

        return $procesos;
    }

    public function getOrdenesMedicas()
    {
        $ordenes = DB::table("orden_medica")->where("req_can_id", $this->req_candidato_id)
        ->orderBy("orden_medica.id", "asc")
        ->groupBy("orden_medica.id")
        ->get();

        if ($ordenes == null) {
            return [];
        }

        return $ordenes;
    }


    public function CandidatoCitado()
    {
        $citaciones = ReqCandidato::join('citaciones', 'citaciones.req_candi_id', '=', 'requerimiento_cantidato.id')
        ->where('requerimiento_cantidato.id', $this->req_cann_id)
        ->first();

        if ($citaciones ==null) {
            return $res = "NO";
        }else{

            return $res = "SI";
        }
    }

    public function getObservaciones()
    {
        $observaciones = DB::table("observaciones_candidato")
        ->where("req_can_id", $this->req_candidato_id)
        ->orderBy("observaciones_candidato.id", "asc")
        ->get();

        if ($observaciones == null) {
            return "";
        }

        return $observaciones;
    }

    public function getObservacionesNoLeidas()
    {
        $observaciones = DB::table("observaciones_candidato")
        ->where("req_can_id", $this->id)
        ->where("visto",0)
        ->count();
        
        return $observaciones;
    }

    public function estadoRequerimiento_req()
    {
        $estado = Estados::where('id', $this->estado_candidato)
        ->select('descripcion as estado_nombre')
        ->first();

        if ($estado == null) {
            return $estado = "";
        }else{
           return $estado->estado_nombre;
        }
    }

    public function contratacionCompleta()
    {
        $user = User::find($this->candidato_id);

        $tipo_documento = Documentos::join("tipos_documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
        ->where("documentos.numero_id", $user->numero_id)
        ->where("tipos_documentos.categoria", 2)
        ->where("documentos.requerimiento", $this->requerimiento_id)
        ->whereIn("tipos_documentos.id", [13, 14, 16, 17])
        ->select("tipos_documentos.id as id")
        ->orderBy("id")
        ->groupBy("id")
        ->get();

        if($tipo_documento->count()==4){
            return true;
        }else{
            return false;
        }
    }
    public function cerrar_carpetas_asistente($folder=1){
       
       switch ($folder) {
           case '1':
               if($this->bloqueo_carpeta){
                    $this->bloqueo_carpeta=0;
                    $this->save();
                }
                else{
                     $this->bloqueo_carpeta=1;
                     $this->save();
                }
               break;
            case '2':
                if($this->bloqueo_carpeta_contratacion){
                    $this->bloqueo_carpeta_contratacion=0;
                    $this->save();
                }
                else{
                     $this->bloqueo_carpeta_contratacion=1;
                     $this->save();
                }
                break;
           default:
               # code...
               break;
       }
        
    }

    public function verificarProceso($nombre_proceso) {
        $busqueda = ReqCandidato::join('procesos_candidato_req', 'procesos_candidato_req.requerimiento_candidato_id', '=', 'requerimiento_cantidato.id')->where('procesos_candidato_req.proceso', $nombre_proceso)->where('requerimiento_cantidato.id', $this->req_candidato)->first();

        if ($busqueda != null) {
            return true;
        }

        return false;
    }

    public function candidatosAprobar($user_id, $req_id)
    {
        $estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_CONTRATADO'),
            //config('conf_aplicacion.C_APROBADO_CLIENTE'),
            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
            config('conf_aplicacion.C_TERMINADO')
        ];

        $candidato_req = $this->whereNotIn("estado_candidato", $estados_no_muestra)
        ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
        ->where("procesos_candidato_req.candidato_id", $user_id)
        ->where("procesos_candidato_req.requerimiento_id", $req_id)
        ->where("procesos_candidato_req.proceso", "ENVIO_APROBAR_CLIENTE")
        //->where("procesos_candidato_req.apto", null)
        ->select('procesos_candidato_req.*')
        ->orderBy('procesos_candidato_req.id', 'DESC')
        ->first();

        return $candidato_req;
    }

    public function encriptar($parametro) {
        return Crypt::encrypt($parametro);
    }
}
