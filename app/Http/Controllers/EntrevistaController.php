<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CalificaCompetencia;
use App\Models\CompetenciaCliente;
use App\Models\DatosBasicos;
use App\Models\Requerimiento;
use App\Models\AsignacionPsicologo;
use App\Models\EntrevistaSemi;
use App\Jobs\FuncionesGlobales;
use App\Models\EntrevistaCandidatos;
use App\Models\ProcesoRequerimiento;
use App\Models\RegistroProceso;
use App\Models\TipoFuentes;
use App\Models\RespuestasEntre;
use App\Models\PreguntasEntre;
use App\Models\EntrevistaVirtual;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use triPostmaster;

class EntrevistaController extends Controller
{
    public function index(Request $data)
    {
        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") {
            if($this->user->inRole("SUPER ADMINISTRADOR") || $this->user->inRole("ANALISTA")){
                $entrevistas = array('ENVIO_ENTREVISTA_TECNICA', 'ENVIO_ENTREVISTA', 'ENVIO_ENTREVISTA_PENDIENTE');
            }else{
                $entrevistas = array('ENVIO_ENTREVISTA_TECNICA', 'ENVIO_ENTREVISTA_PENDIENTE');
            }

            $user = $this->user->id;

            $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
            ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')       
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')         
            ->leftjoin('solicitudes', 'solicitudes.id', '=', 'requerimientos.solicitud_id')
            ->leftjoin('solicitud_sedes', 'solicitud_sedes.id', '=', 'solicitudes.ciudad_id')
            ->whereRaw(" (procesos_candidato_req.apto is null )  ")
            ->where('users_x_clientes.user_id', $user)
            //->where('requerimientos.solicitado_por',$user)
            //->where('solicitudes.user_id',$user)
            ->whereIn("requerimiento_cantidato.estado_candidato", [7, 8])
            ->whereIn("procesos_candidato_req.estado", [7, 8])
            ->whereIn("estados_requerimiento.estado", [
                config('conf_aplicacion.C_RECLUTAMIENTO'),
                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            ])
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where(function ($sql) use ($data,$user) {

                if($data['id_ent'] != ""){

                 $sql->where("procesos_candidato_req.id", $data['id_ent']);

                }
                //Filtro por codigo requerimiento
                if($data->codigo != "") {
                 $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                }
                //Filtro por cedula de candidato
                if($data->cedula != "") {
                  $sql->where("datos_basicos.numero_id", $data->cedula);
                }

                if($user != 33720 && $user != 33703){

                  $sql->where('solicitudes.user_id',$user);

                }

            })
            ->whereIn("procesos_candidato_req.proceso", $entrevistas)
            ->orderBy('requerimiento_cantidato.requerimiento_id', 'desc')
            ->groupBy('procesos_candidato_req.id')
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente',
                'requerimiento_cantidato.id as req_cand_id',
                'solicitud_sedes.descripcion'
            )->paginate(8);

            return view("admin.reclutamiento.entrevistas", compact("candidatos"));

            /*
                if($this->user->inRole("ANALISTA")){
                //entrevistas asignadas a ese psicologo
                if($this->user->id==33758){
                    $entrevistas=array('ENVIO_ENTREVISTA_TECNICA','ENVIO_ENTREVISTA','ENVIO_ENTREVISTA_PENDIENTE');
                }
                else{
                     $entrevistas=array('ENVIO_ENTREVISTA','ENVIO_ENTREVISTA_PENDIENTE');
                }

                $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
                ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
                ->join('asignacion_psicologo','asignacion_psicologo.req_id','=','requerimientos.id')
                ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')            
                ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
                ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
                ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")            
                ->leftjoin('solicitudes', 'solicitudes.id', '=', 'requerimientos.solicitud_id')
                ->leftjoin('solicitud_sedes', 'solicitud_sedes.id', '=', 'solicitudes.ciudad_id')
                ->whereRaw(" (procesos_candidato_req.apto is null )  ")
                ->where('asignacion_psicologo.psicologo_id',$this->user->id)
                ->where('users_x_clientes.user_id',$this->user->id)
                ->whereIn("requerimiento_cantidato.estado_candidato", [7, 8])
                ->whereIn("procesos_candidato_req.estado", [7, 8])
                ->where(function ($sql) use ($data) {
                    //Filtro por codigo requerimiento
                    if ($data->codigo != "") {
                        $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                    }

                    //Filtro por cedula de candidato
                    if ($data->cedula != "") {
                        $sql->where("datos_basicos.numero_id", $data->cedula);
                    }
                })
                ->whereIn("procesos_candidato_req.proceso", $entrevistas)
                ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
                ->select("procesos_candidato_req.proceso", "procesos_candidato_req.id as ref_id", "datos_basicos.*",
                    'requerimiento_cantidato.requerimiento_id',
                    'requerimiento_cantidato.candidato_id',
                    'requerimiento_cantidato.estado_candidato',
                    'requerimiento_cantidato.otra_fuente',
                    'solicitud_sedes.descripcion'
                )->paginate(8);

                //dd($candidatos);
                return view("admin.reclutamiento.entrevistas", compact("candidatos"));

                }elseif($this->user->inRole("SUPER ADMINISTRADOR")){
                    $entrevistas=array('ENVIO_ENTREVISTA_TECNICA','ENVIO_ENTREVISTA','ENVIO_ENTREVISTA_PENDIENTE');
                }
                else{
                   $entrevistas=array('ENVIO_ENTREVISTA_TECNICA','ENVIO_ENTREVISTA_PENDIENTE');
                }

                $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
                ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
                ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')            
                ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
                ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
                ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")            
                ->leftjoin('solicitudes', 'solicitudes.id', '=', 'requerimientos.solicitud_id')
                ->leftjoin('solicitud_sedes', 'solicitud_sedes.id', '=', 'solicitudes.ciudad_id')
                ->whereRaw(" (procesos_candidato_req.apto is null )  ")
                ->where('users_x_clientes.user_id',$this->user->id)
                ->whereIn("requerimiento_cantidato.estado_candidato", [7, 8])
                ->whereIn("procesos_candidato_req.estado", [7, 8])
                ->where(function ($sql) use ($data) {
                    //Filtro por codigo requerimiento
                    if ($data->codigo != "") {
                        $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                    }

                    //Filtro por cedula de candidato
                    if ($data->cedula != "") {
                        $sql->where("datos_basicos.numero_id", $data->cedula);
                    }
                })
                ->whereIn("procesos_candidato_req.proceso", $entrevistas)
                ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
                ->select("procesos_candidato_req.proceso", "procesos_candidato_req.id as ref_id", "datos_basicos.*",
                    'requerimiento_cantidato.requerimiento_id',
                    'requerimiento_cantidato.candidato_id',
                    'requerimiento_cantidato.estado_candidato',
                    'requerimiento_cantidato.otra_fuente',
                    'solicitud_sedes.descripcion'
                )->paginate(8);
                
                //dd($candidatos);
                return view("admin.reclutamiento.entrevistas", compact("candidatos"));
            */
        }else{
            $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
            ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id","=","procesos_candidato_req.requerimiento_candidato_id")
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->whereRaw(" (procesos_candidato_req.apto is null )  ")
            ->where('users_x_clientes.user_id',$this->user->id)
            ->whereIn("requerimiento_cantidato.estado_candidato", [7, 8])
            ->whereIn("procesos_candidato_req.estado", [7, 8])
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->whereIn("estados_requerimiento.estado", [
                config('conf_aplicacion.C_RECLUTAMIENTO'),
                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                //config('conf_aplicacion.C_NO_EFECTIVO')
                //config('conf_aplicacion.C_CLIENTE')
            ])
            ->where(function ($sql) use ($data) {
                //Filtro por codigo requerimiento
                if($data->codigo != "") {
                    $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                }

                //Filtro por cedula de candidato
                if($data->cedula != "") {
                    $sql->where("datos_basicos.numero_id", $data->cedula);
                }
            })
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_ENTREVISTA", "ENVIO_ENTREVISTA_PENDIENTE"])
            ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.id as req_cand_id',
                'requerimiento_cantidato.otra_fuente')
            ->paginate(8);

            return view("admin.reclutamiento.entrevistas", compact("candidatos"));
        }
    }

    public function gestionar_entrevista($id)
    {
        $user_sesion = $this->user;
        
        $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
        ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
        ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = '' or procesos_candidato_req.apto = 3 )")
        ->where("procesos_candidato_req.id", $id)
        ->select("procesos_candidato_req.requerimiento_candidato_id", "procesos_candidato_req.id as ref_id", "datos_basicos.*", 'requerimiento_cantidato.requerimiento_id',
            'requerimiento_cantidato.candidato_id',
            'requerimiento_cantidato.id as req_cand_id',
            'requerimiento_cantidato.estado_candidato',
            'requerimiento_cantidato.otra_fuente')
        ->first();

        $estados_procesos_referenciacion = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
        ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
        ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
        ->whereIn("proceso", ["ENVIO_ENTREVISTA", "ENVIO_ENTREVISTA_PENDIENTE"])
        ->get();

        $entrevistas = EntrevistaCandidatos::join("users", "users.id", "=", "entrevistas_candidatos.user_gestion_id")
        ->join("tipo_fuente", "tipo_fuente.id", "=", "entrevistas_candidatos.fuentes_publicidad_id")
        ->where("entrevistas_candidatos.candidato_id", $candidato->user_id)
        ->select("entrevistas_candidatos.*", "users.name", "tipo_fuente.descripcion as desc_fuente")
        ->orderBy("entrevistas_candidatos.created_at", "desc")
        ->get();

        $entrevistas_semi = EntrevistaSemi::join("users", "users.id", "=", "entrevista_semi.user_gestion_id")
        ->where("entrevista_semi.candidato_id", $candidato->user_id)
        ->select("entrevista_semi.*", "users.name")
        ->orderBy("entrevista_semi.created_at", "desc")
        ->get();

        $entrevistas_semi = EntrevistaSemi::join("users", "users.id", "=", "entrevista_semi.user_gestion_id")
        ->where("entrevista_semi.candidato_id", $candidato->user_id)
        ->select("entrevista_semi.*", "users.name")
        ->orderBy("entrevista_semi.created_at", "desc")
        ->get();

        $req_prueba_gestionado = [];
        
        $req_gestion = EntrevistaCandidatos::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "entrevistas_candidatos.id")
        ->select("entrevistas_candidatos.id")
        ->where("proceso_requerimiento.requerimiento_id", $candidato->requerimiento_id)
        ->where("proceso_requerimiento.tipo_entidad", "MODULO_ENTREVISTA")
        ->get();

        foreach ($req_gestion as $key => $value) {
          array_push($req_prueba_gestionado, $value->id);
        }

        return view("admin.reclutamiento.gestionar_entrevista", compact(
            "candidato",
            "entrevistas",
            "estados_procesos_referenciacion",
            "req_prueba_gestionado","user_sesion",
            "entrevistas_semi"
        ));
    }

    public function nueva_entrevista(Request $data)
    {

        $proceso_can_req=$data->get("ref_id");
      
        $fuentes = ["" => "Seleccionar"] + TipoFuentes::pluck("descripcion", "id")->toArray();
        $proceso = RegistroProceso::
            join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))->first();

        /*$competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")->
            where("competencias_cliente.cliente_id", $proceso->cliente_id)->get();
       */
        return view("admin.reclutamiento.modal.nueva_entrevista", compact("fuentes","proceso_can_req"));
    }

    public function actualizar_entrevista(Request $data)
    {
          
        //AE -> Actualizar Entrevista Candidato
        //dd($data->all());
        $ae = EntrevistaCandidatos::find($data->get("id"));
        $ae->fill($data->all());
        $ae->save();
        //dd($ae);
        $proceso=RegistroProceso::find($data->get("proceso"));
       
        $final=0;
        if($data->definitiva!=null){

           $final=1;
            $apto=$data->get("apto");

            if($apto==null){
               
                $apto=0;
            }

            $proceso->fill([
                "apto"                => $apto,
                "usuario_terminacion" => $this->user->id,
                "observaciones"       => $data->get("concepto_general"),
                ]);
            $proceso->save();

            //SI SELECCIONAN EL ESTADO PENDIENTE SE CREA UN NUEVO REGISTRO
           

            //SI EL ESTADO ES NO APTO SE RECHAZA EL CANDIDATO
            
    }

    return response()->json(["success" => true,"final"=>$final]);

        // Actualizar Competencias Candidato
        /* if ($data->has("competencia")) {
            $descripciones = $data->get("descripcion");
            foreach ($data->get("competencia") as $key => $value) {
                $ac = CalificaCompetencia::where("entidad_id", $data->get("id"))
                    ->where("competencia_entrevista_id", $key)
                    ->first();
                $ac->fill([
                    "competencia_entrevista_id" => $key,
                    "valor"                     => $value,
                    "descripcion"               => $descripciones[$key],
                ]);
                $ac->save();
            }
        }
return back()->withInput();
      */  
    }

    public function guardar_entrevista(Request $data)
    {

        if(route("home") != "https://gpc.t3rsc.co"){

          $this->validate($data, [
            'fuentes_publicidad_id' => 'required',
            //'aspecto_familiar' => 'required',
            //'aspecto_academico' => 'required',
            //'aspectos_experiencia' => 'required',
            //'aspectos_personalidad' => 'required',
            //'fortalezas_cargo' => 'required',
            //'oportunidad_cargo' => 'required',
            'concepto_general' => 'required',
            //'fortalezas_cargo' => 'required',
          ]);
        }
        
        $proceso = RegistroProceso::where("procesos_candidato_req.id", $data->get("ref_id"))->first();

        $nueva_entrevista = new EntrevistaCandidatos();
        $nueva_entrevista->fill($data->all() + ["req_id"=>$proceso->requerimiento_id,"candidato_id" => $proceso->candidato_id, "user_gestion_id" => $this->user->id]);

        if(route("home") == "https://gpc.t3rsc.co") {

         $nueva_entrevista->aspecto_salarial = $data->aspecto_salarial;
        }

        $nueva_entrevista->save();

        $final=0;

        if($data->definitiva!=null){

         $final=1;
         
          $apto=$data->get("apto");

            if($apto==null){
               
                $apto=0;
            }

            $proceso->fill([
                "apto"                => $apto,
                "usuario_terminacion" => $this->user->id,
                "observaciones"       => $data->get("concepto_general"),
                ]);
            $proceso->save();

            //SI SELECCIONAN EL ESTADO PENDIENTE SE CREA UN NUEVO REGISTRO
            //SI EL ESTADO ES NO APTO SE RECHAZA EL CANDIDATO
            
    }

        //GUARDAR VALORES D CALIFICACION DE COMPETENCIAS
       /* if ($data->has("competencia")) {
            $descripciones = $data->get("descripcion");
            foreach ($data->get("competencia") as $key => $value) {
                $calificacion = new CalificaCompetencia();
                $calificacion->fill([
                    "entidad_id"                => $nueva_entrevista->id,
                   // "competencia_entrevista_id" => $key,
                    "valor"                     => $value,
                    "descripcion"               => $descripciones[$key],
                    "tipo_entidad"              => "MODULO_ENTREVISTA",
                ]);
                $calificacion->save();
            }
       
        }
     */
         //GUARDAR_ RELACION PRUEBA REQUERIMIENTO
        $this->procesoRequerimiento($nueva_entrevista->id, $data->get("ref_id"), "MODULO_ENTREVISTA");

        return response()->json(["success" => true,"final"=>$final]);
    }

   /* public function registra_proceso_entidad(Request $data)
    {
        //dd($data->prueba_id);
        $ae = EntrevistaCandidatos::find($data->prueba_id);
        $ae->activo = 0;

        $ae->save();
         //dd($ae);
    }

    public function registra_proceso_entidad2(Request $data)
    {
        //dd($data->all());
         $ae = EntrevistaCandidatos::find($data->prueba_id);
         //dd($ae);
       $ae->activo = 1;
       $ae->save();
    }*/
    public function registra_proceso_entidad(Request $data)
    {
       
          
       //$ae = GestionPrueba::find($data->prueba_id);
        //$ae->activo = 0;
        $proceso_req=ProcesoRequerimiento::where("entidad_id",$data->get("entrevista_id"))
            ->where("tipo_entidad","MODULO_ENTREVISTA")
            ->where("requerimiento_id",$data->get("req_id"))
            ->first();
        if(count($proceso_req)>0){
             $proceso_req->activo=0;
             $proceso_req->save();
        }

        
        //$this->procesoRequerimiento($pruebas->id, $data->get("ref_id"), "MODULO_PRUEBAS");

        //$ae->save();
    }

    public function registra_proceso_entidad2(Request $data)
    {
        $proceso_req=ProcesoRequerimiento::where("entidad_id",$data->get("entrevista_id"))
            ->where("tipo_entidad","MODULO_ENTREVISTA")
            ->where("requerimiento_id",$data->get("req_id"))
            ->first();

        if(count($proceso_req)>0){
             $proceso_req->activo=1;
             $proceso_req->save();
        }
        else{
             $relacionProceso = new ProcesoRequerimiento();
             $relacionProceso->fill([
                "tipo_entidad" => "MODULO_ENTREVISTA",
                "entidad_id" => $data->get("entrevista_id"),
                "requerimiento_id" => $data->get("req_id"),
                "user_id" => $this->user->id
            ]);
            $relacionProceso->save();
        }
        //$ae = GestionPrueba::find($data->prueba_id);
        //$ae->activo = 1;

        //$ae->save();
       
    }

    public function detalle_entrevista_modal(Request $data)
    {
        $entrevista = EntrevistaCandidatos::find($data->get("entrevista_id"));

        /*$competenciasEvaluadas = CalificaCompetencia::where("entidad_id", $entrevista->id)->where("tipo_entidad", "MODULO_ENTREVISTA")->get();
        $arrayValores          = [];
        $arrayDescripcion      = [];
        foreach ($competenciasEvaluadas as $key => $value) {
            $arrayValores[$value->competencia_entrevista_id]     = $value->valor;
            $arrayDescripcion[$value->competencia_entrevista_id] = $value->descripcion;
        }
        $entrevista->competencia = $arrayValores;
        $entrevista->descripcion = $arrayDescripcion;
        */
        $fuentes    = ["" => "Seleccionar"] + TipoFuentes::pluck("descripcion", "id")->toArray();

        $proce=$data->get("ref_id");
        /*$proceso                 = RegistroProceso::
            join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->select("procesos_candidato_req.id as id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))->first();*/
       /* $competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")->
            where("competencias_cliente.cliente_id", $proceso->cliente_id)->get();*/
        return view("admin.reclutamiento.modal.detalle_entrevista", compact("entrevista", "fuentes", "competencias", "proceso","proce"));
    }

    /**
     * Se muestra la entrevista al usuario que se envio a video entrevista
     **/
    public function video_entrevista_candidato($req_id,Request $data){

        $preguntas_entre = PreguntasEntre::
        join('entrevista_virtual','entrevista_virtual.id','=','preguntas_entre.entre_vir_id')
        ->join('requerimientos','requerimientos.id','=','entrevista_virtual.req_id')
        ->where('entrevista_virtual.req_id',$req_id)
        ->where('preguntas_entre.activo',1)
        ->select('preguntas_entre.id as id','preguntas_entre.descripcion as descripcion')
        ->get();

        $respuesta_pregu = RespuestasEntre::where('respuestas_entre.candidato_id',$this->user->id)
                                ->where('respuestas_entre.preg_entre_id',$data->preg_entre_id)
                                ->get();

        return view("cv.video_entrevista",compact('preguntas_entre'));
    }

    public function responder_entre_pregu(Request $data){
        $pregu_id = $data->pregu_id;

        $pregunta_entre = PreguntasEntre::where('id', $pregu_id)->first();

        $user_id = $data->user_id;

        return view("cv.modal.responder_pregu_entre",compact('user_id','pregunta_entre','pregu_id','preguntas_entre'));
    }


    public function guardar_respu_pregu(Request $data){
        //$data->entrevista_virtual_id

        $respuesta_pregu = RespuestasEntre::where('respuestas_entre.candidato_id', $data->user_id)
        ->where('respuestas_entre.preg_entre_id', $data->preg_entre_id)
        ->first();

        if ($respuesta_pregu == null) {
            $respuesta_pregu = new RespuestasEntre();
        }

        $respuesta_pregu->preg_entre_id = $data->preg_entre_id;
        $respuesta_pregu->candidato_id = $data->user_id;

        $respuesta_pregu->save();

        $archivo   = $data->file('video-blob');
        $extencion = $archivo->getClientOriginalExtension();
        $fileName  = "VideoRespuesta_"."$respuesta_pregu->candidato_id". $respuesta_pregu->preg_entre_id  . ".$extencion";
        
        if ($respuesta_pregu->respuesta != "" && file_exists("recursos_videoRespuesta/" . $respuesta_pregu->respuesta)) {
            unlink("recursos_videoRespuesta/" . $respuesta_pregu->respuesta);
        }
        $respuesta_pregu->respuesta = $fileName;

        $respuesta_pregu->save();

        $data->file('video-blob')->move("recursos_videoRespuesta", $fileName);

        $UsuarioGestion = EntrevistaVirtual::join('datos_basicos', 'entrevista_virtual.user_gestion', '=', 'datos_basicos.user_id')
        ->select('datos_basicos.email as email_gestion', 'datos_basicos.user_id', 'entrevista_virtual.req_id as requerimiento')
        ->where('entrevista_virtual.id', $data->entrevista_virtual_id)
        ->first();

        $UsuarioEntrevista = DatosBasicos::where('user_id', $data->user_id)
        ->select('nombres', 'primer_apellido', 'numero_id')
        ->first();

        if (route('home') == 'https://gpc.t3rsc.co') {
            $mensaje = 'el candidato '.$UsuarioEntrevista->nombres.' '.$UsuarioEntrevista->primer_apellido.' identificado con número de ci '.$UsuarioEntrevista->numero_id.' y vinculado al requerimiento '.$UsuarioGestion->requerimiento.'. <i>Ya ha completado la entrevista virtual a la que fue enviado/a.</i>';
        }else{
            $mensaje = 'el candidato '.$UsuarioEntrevista->nombres.' '.$UsuarioEntrevista->primer_apellido.' identificado con número de cédula '.$UsuarioEntrevista->numero_id.' y vinculado al requerimiento '.$UsuarioGestion->requerimiento.'. <i>Ya ha completado la entrevista virtual a la que fue enviado/a.</i>';
        }

        $count_entrevista_preguntas = EntrevistaVirtual::join('preguntas_entre', 'preguntas_entre.entre_vir_id', '=', 'entrevista_virtual.id')
        ->where('entrevista_virtual.id', $data->entrevista_virtual_id)
        ->count();

        $count_entrevista_respuestas = EntrevistaVirtual::join('preguntas_entre', 'preguntas_entre.entre_vir_id', '=', 'entrevista_virtual.id')
        ->join('respuestas_entre', 'respuestas_entre.preg_entre_id', '=', 'preguntas_entre.id')
        ->where('entrevista_virtual.id', $data->entrevista_virtual_id)
        ->count();

        if($count_entrevista_preguntas == $count_entrevista_respuestas){
            RegistroProceso::where('candidato_id', $data->user_id)
                ->where('requerimiento_id', $UsuarioGestion->requerimiento)
                ->where('proceso', 'ENVIO_ENTREVISTA_VIRTUAL')
            ->update(['apto' => 3]);

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Notificación Entrevista Virtual"; //Titulo o tema del correo

            //Cuerpo con html y comillas dobles para las variables
            $mailBody = "
                Buen día,
                <br/><br/>
                Te informamos que, el candidato {$UsuarioEntrevista->nombres} {$UsuarioEntrevista->primer_apellido} identificado con número de cédula {$UsuarioEntrevista->numero_id} y vinculado al requerimiento {$UsuarioGestion->requerimiento}. <i>Ya ha completado la entrevista virtual a la que fue enviado/a.</i>
            ";

            //Arreglo para el botón
            $mailButton = ['buttonText' => 'VER RESULTADOS', 'buttonRoute' => route('admin.entrevistas_virtuales')];

            $mailUser = $UsuarioGestion->user_id; //Id del usuario al que se le envía el correo

            //$mailAditionalTemplate = ['nameTemplate' => 'prueba_idioma', 'dataTemplate' => []];

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            //Envio de email
            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($UsuarioGestion) {

                        $message->to([$UsuarioGestion->email_gestion])
                                ->subject('Notificación Finalización Entrevista Virtual - REQ '.$UsuarioGestion->requerimiento)
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

        }

        return response()->json(["success" => true]);
    }

}
