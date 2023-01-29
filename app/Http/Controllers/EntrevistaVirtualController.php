<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\DatosBasicos;
use App\Http\Controllers\Controller;
use App\Models\EntrevistaVirtual;
use App\Models\Requerimiento;
use App\Models\PreguntasEntre;
use App\Models\RespuestasEntre;
use \DB;

class EntrevistaVirtualController extends Controller
{
    public function index(Request $data)
    {
        if (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") {
            $entrevistas_virtuales = Requerimiento::join('entrevista_virtual','entrevista_virtual.req_id','=','requerimientos.id')
            ->join('ciudad', function ($join) {
                    $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                        ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                        ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
                })
                ->join('departamentos', function ($join2) {
                    $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                        ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
                })
            ->join('paises', 'requerimientos.pais_id', '=', 'paises.cod_pais')
            ->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
            ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
            ->join('estados', 'estados.id', '=', 'requerimientos_estados.max_estado')
            ->leftjoin('solicitudes', 'solicitudes.id', '=', 'requerimientos.solicitud_id')
            ->leftjoin('solicitud_sedes', 'solicitud_sedes.id', '=', 'solicitudes.ciudad_id')
            ->where(function ($sql) use ($data) {
                //Filtro por codigo requerimiento
                if ($data->codigo != "") {
                    $sql->where("requerimientos.id", $data->codigo);
                }

            })
            ->whereIn("estados_requerimiento.estado", [
                config('conf_aplicacion.C_RECLUTAMIENTO'),
                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                config('conf_aplicacion.C_RECLUTAMIENTO'),
                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            ])
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            //->whereIn("requerimientos_estados.max_estado", [
            //          config('conf_aplicacion.C_RECLUTAMIENTO'),
            //        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            //      config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            //    config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            ->select(
                'solicitud_sedes.descripcion as sede',
                'estados.descripcion as estado',
                'requerimientos.fecha_ingreso as fecha_ing',
                'requerimientos.fecha_terminacion as fecha_term',
                'requerimientos.id as req_id',            
                'cargos_especificos.descripcion as cargo_especifico'
            )
            ->orderBy('requerimientos.id','desc')
            ->get();

            return view("admin.reclutamiento.entrevistas_virtuales", compact("entrevistas_virtuales", "req_id", "negocio"));
        }else{
            $entrevistas_virtuales = Requerimiento::join('entrevista_virtual','entrevista_virtual.req_id','=','requerimientos.id')
            ->join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                    ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
                })
            ->join('departamentos', function ($join2) {
                $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
                })
            ->join('paises', 'requerimientos.pais_id', '=', 'paises.cod_pais')
            ->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
            ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
            ->join('estados', 'estados.id', '=', 'requerimientos_estados.max_estado')
            ->where(function ($sql) use ($data) {
                //Filtro por codigo requerimiento
                if ($data->codigo != "") {
                    $sql->where("requerimientos.id", $data->codigo);
                }
            })
            ->whereIn("requerimientos_estados.max_estado", [
                config('conf_aplicacion.C_RECLUTAMIENTO'),
                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            ])
           ->select(
                'estados.descripcion as estado',
                'requerimientos.fecha_ingreso as fecha_ingreso',
                'requerimientos.fecha_terminacion as fecha_terminacion',
                'requerimientos.id as req_id',
                'ciudad.nombre as ciudad',
                'cargos_especificos.descripcion as cargo_especifico'
            )
            ->orderBy('requerimientos.id','desc')
            ->get();

            return view("admin.reclutamiento.entrevistas_virtuales", compact("entrevistas_virtuales", "req_id", "cliente", "negocio"));
        }
    }
   
    public function pregunta_activa(Request $data)
    {
        //dd($data->all());
       

         $ae = PreguntasEntre::find($data->pregunta_id);
         //dd($ae);
       $ae->activo = 0;

        $ae->save();

        
    }

    public function pregunta_inactiva(Request $data)
    {
        //dd($data->all());
       

         $ae = PreguntasEntre::find($data->pregunta_id);
         //dd($ae);
       $ae->activo = 1;

        $ae->save();

        
    }

   public function gestionar_entrevista($req_id)
    {
        
        $user_sesion = $this->user;
        $req_id = $req_id;


        $entrevista_virtual = EntrevistaVirtual::
        join('requerimientos','requerimientos.id','=','entrevista_virtual.req_id')
        ->join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                    ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->join('departamentos', function ($join2) {
                $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
            })
        ->join('paises', 'requerimientos.pais_id', '=', 'paises.cod_pais')
        ->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
        ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
        ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
        ->join('estados', 'estados.id', '=', 'requerimientos_estados.max_estado')
        ->join('users','users.id','=','entrevista_virtual.user_gestion')
        ->where('entrevista_virtual.req_id',$req_id)
        ->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),

                        ])
       ->select(DB::raw('DATE_FORMAT(entrevista_virtual.created_at, \'%Y-%m-%d\') as fecha_creacion'),
        'entrevista_virtual.*','users.name as user_gestion','estados.descripcion as estado','requerimientos.fecha_ingreso as fecha_ingreso','requerimientos.fecha_terminacion as fecha_terminacion','requerimientos.id as req_id','ciudad.nombre as ciudad','cargos_especificos.descripcion as cargo_especifico')
       ->first();
        
        $preguntas_entre = PreguntasEntre::
        join('entrevista_virtual','entrevista_virtual.id','=','preguntas_entre.entre_vir_id')
        //->leftJoin('respuestas_entre','respuestas_entre.preg_entre_id','=','preguntas_entre.id')
        ->where('preguntas_entre.entre_vir_id',$entrevista_virtual->id)
        ->select('preguntas_entre.*')
        ->get();
        //dd($preguntas_entre);


        return view("admin.reclutamiento.gestionar_entrevista_virtual", compact("req_id","entrevista_virtual","preguntas_entre"));
    }


    public function gestionar_respuesta($req_id, $pregu_id, Request $data)
    {
        $pregu_id = $pregu_id;
        
        $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
        ->join('respuestas_entre', 'respuestas_entre.candidato_id', '=', 'datos_basicos.user_id')
        ->join('preguntas_entre', 'preguntas_entre.id', '=', 'respuestas_entre.preg_entre_id')
        ->join('entrevista_virtual', 'entrevista_virtual.id', '=', 'preguntas_entre.entre_vir_id')
        /*->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")*/
        //->whereRaw(" (procesos_candidato_req.apto is null )  ")
        /*  ->where("requerimiento_cantidato.estado_candidato", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))*/
        ->where("procesos_candidato_req.estado", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
        ->where("preguntas_entre.id", $pregu_id)
        ->where("procesos_candidato_req.requerimiento_id", $req_id)
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
        ->whereIn("procesos_candidato_req.proceso", ["ENVIO_ENTREVISTA_VIRTUAL"])
        ->select(
            DB::raw('DATE_FORMAT(respuestas_entre.created_at, \'%Y-%m-%d\') as fecha_respuesta'),
            "procesos_candidato_req.apto as apto",
            "preguntas_entre.*",
            "respuestas_entre.respuesta as respuesta",
            "respuestas_entre.id as respu_id",
            "procesos_candidato_req.proceso",
            "procesos_candidato_req.id as ref_id",
            "datos_basicos.*",
            'entrevista_virtual.req_id as requerimiento_id',
            'respuestas_entre.candidato_id'
        )
        //->groupBy('respuestas_entre.candidato_id')
        ->paginate(8);

        return view("admin.reclutamiento.gestionar_respuesta_virtual", compact("pregu_id","candidatos","entrevista_virtual","preguntas_entre"));
    }


    public function video_respuesta_candidato(Request $data)
    {
        $respuesta = RespuestasEntre::where('respuestas_entre.candidato_id',$data->candidato_id)
        ->where('respuestas_entre.preg_entre_id',$data->pregunta_id)
        ->first();

        return view("admin.reclutamiento.modal.respuesta_candidato_video", compact("respuesta","entrevista_virtual","preguntas_entre"));
    }

    public function eliminar_video_respuesta_candidato(Request $data)
    {
        $respuesta = RespuestasEntre::where('respuestas_entre.candidato_id',$data->candidato_id)
        ->where('respuestas_entre.preg_entre_id',$data->pregunta_id)
        ->first();

        if ($respuesta->respuesta != "" && file_exists("recursos_videoRespuesta/" . $respuesta->respuesta)) {
            unlink("recursos_videoRespuesta/" . $respuesta->respuesta);
        }

        $respuesta->delete();

        return response()->json(["success" => true]);
    }


     public function crear_pregunta(Request $data)
     {
        
          $entre_id = $data->entrevista_id;

       


         return view("admin.reclutamiento.modal.nueva_pregunta_entrevista_virtual", compact("entre_id"));
     }


     public function guardar_pregunta(Request $data)
     {
        
          $entre_id = $data->entre_id;

          $nueva_pregunta = new PreguntasEntre();
          $nueva_pregunta->fill([
           
                  "descripcion"  => $data->descripcion,
                  "entre_vir_id" => $entre_id,
                  "activo"       => 1,
 
          ]);

          $nueva_pregunta->save();


         return response()->json(["success" => true]);
     }
  
    public function nueva_entrevista(Request $data)
    {
        $req_id = $data->req_id;


        return view("admin.reclutamiento.modal.nueva_entrevista_virtual", compact("tipo_pregunta","req_id", "cliente", "negocio"));
    }


    public function editar_pregunta(Request $data)
    {
        
         $pregunta_entre = PreguntasEntre::where('preguntas_entre.id',$data->pregunta_id)
         ->select('preguntas_entre.*')
         ->first();
         //dd($pregunta_entre);
         


        return view("admin.reclutamiento.modal.editar_pregunta", compact("pregunta_entre"));
    }


    public function actualizar_pregunta(Request $data)
    {
         $pregunta_actualizada = PreguntasEntre::find($data->pregu_id);
         //->first();
          //dd($pregunta_actualizada);
         $pregunta_actualizada->descripcion = $data->descripcion;
         $pregunta_actualizada->save();

        return response()->json(["success" => true]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function guardar_entrevista(Request $data)
    {

         $nueva_entrevista = new EntrevistaVirtual();
           $nueva_entrevista->fill([
            "user_gestion"       =>$this->user->id,
            "activo"             => 1,
            "req_id"             => $data->req_id,
        ]);
          
        $nueva_entrevista->save();

        foreach ($data->descripcion as $key => $desc) { 
             
             if ($desc != "") {
                   $nueva_pregunta = new PreguntasEntre();
                          $nueva_pregunta->fill([
                                "descripcion"           => $desc,
                                "entre_vir_id"          => $nueva_entrevista->id,
                                
                                ]);
                          $nueva_pregunta->save();
             }

        }

        return response()->json(["success" => true]);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

  



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



}
