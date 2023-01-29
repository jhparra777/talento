<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\DatosBasicos;
use App\Models\Requerimiento;
use App\Models\PruebaIdioma;
use App\Models\PreguntasPruebaIdioma;
use App\Models\RespuestaPruebaIdioma;
use App\Models\PreguntaPrecargada;
use \DB;

class PruebasIdiomasController extends Controller
{

    public function index(Request $data)
    {

        if (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") {
            
            $pruebas_idiomas = Requerimiento::join('pruebas_idiomas','pruebas_idiomas.req_id','=','requerimientos.id')
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
            ->whereIn("estados_requerimiento.estado",[ 
                config('conf_aplicacion.C_RECLUTAMIENTO'),
                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                config('conf_aplicacion.C_RECLUTAMIENTO'),
                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            ])
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
           ->select(
            'solicitud_sedes.descripcion as sede',
            'estados.descripcion as estado',
            'requerimientos.fecha_ingreso as fecha_ing',
            'requerimientos.fecha_terminacion as fecha_term',
            'requerimientos.id as req_id',            
            'cargos_especificos.descripcion as cargo_especifico')->orderBy('requerimientos.id','desc')->get();

            return view("admin.reclutamiento.pruebas_idiomas", compact("pruebas_idiomas","req_id", "negocio"));

        }else{

            $pruebas_idiomas = Requerimiento::join('pruebas_idiomas','pruebas_idiomas.req_id','=','requerimientos.id')
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
           ->select('estados.descripcion as estado','requerimientos.fecha_ingreso as fecha_ingreso','requerimientos.fecha_terminacion as fecha_terminacion','requerimientos.id as req_id','ciudad.nombre as ciudad','cargos_especificos.descripcion as cargo_especifico')
            ->orderBy('requerimientos.id','desc')
           ->get();

           return view("admin.reclutamiento.pruebas_idiomas", compact("pruebas_idiomas","req_id", "cliente", "negocio"));
        }

    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function gestionar_prueba($req_id)
    {
        $user_sesion = $this->user;
        $req_id = $req_id;

        $prueba_idioma = PruebaIdioma::join('requerimientos','requerimientos.id','=','pruebas_idiomas.req_id')
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
        ->join('users','users.id','=','pruebas_idiomas.user_gestion')
        ->where('pruebas_idiomas.req_id',$req_id)
        ->whereIn("requerimientos_estados.max_estado", [
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
        ])
       ->select(DB::raw('DATE_FORMAT(pruebas_idiomas.created_at, \'%Y-%m-%d\') as fecha_creacion'),
        'pruebas_idiomas.*','users.name as user_gestion','estados.descripcion as estado','requerimientos.fecha_ingreso as fecha_ingreso','requerimientos.fecha_terminacion as fecha_terminacion','requerimientos.id as req_id','ciudad.nombre as ciudad','cargos_especificos.descripcion as cargo_especifico')
       ->first();

        $preguntas_prueba = PreguntasPruebaIdioma::join('pruebas_idiomas','pruebas_idiomas.id','=','preguntas_pruebas_idiomas.prueba_idio_id')        
        ->where('preguntas_pruebas_idiomas.prueba_idio_id',$prueba_idioma->id)
        ->select('preguntas_pruebas_idiomas.*')
        ->get();

        return view("admin.reclutamiento.gestionar_prueba_idioma", compact("req_id","prueba_idioma","preguntas_prueba"));
    }

    public function gestionar_respuesta($req_id,$pregu_id,Request $data)
    {
        $pregu_id = $pregu_id;
        
        $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
        ->join('respuestas_pruebas_idiomas','respuestas_pruebas_idiomas.candidato_id','=','datos_basicos.user_id')
        ->join('preguntas_pruebas_idiomas','preguntas_pruebas_idiomas.id','=','respuestas_pruebas_idiomas.preg_prueba_id')
        ->join('pruebas_idiomas','pruebas_idiomas.id','=','preguntas_pruebas_idiomas.prueba_idio_id')
        
        ->where("procesos_candidato_req.estado", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
        ->where("preguntas_pruebas_idiomas.id", $pregu_id)
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

        ->whereIn("procesos_candidato_req.proceso", ["ENVIO_PRUEBA_IDIOMA", "ENVIO_PRUEBA_PENDIENTE"])
        ->select(DB::raw('DATE_FORMAT(respuestas_pruebas_idiomas.created_at, \'%Y-%m-%d\') as fecha_respuesta'),"procesos_candidato_req.apto as apto","preguntas_pruebas_idiomas.*","respuestas_pruebas_idiomas.respuesta as respuesta","respuestas_pruebas_idiomas.id as respu_id","procesos_candidato_req.proceso", "procesos_candidato_req.id as ref_id", "datos_basicos.*",
            'pruebas_idiomas.req_id as requerimiento_id',
            'respuestas_pruebas_idiomas.candidato_id'
        )
        ->paginate(8);

        return view("admin.reclutamiento.gestionar_respuesta_prueba_idioma", compact("pregu_id","candidatos"));
    }

    public function nueva_prueba(Request $data)
    {
        $req_id = $data->req_id;

        $preguntasPre = PreguntaPrecargada::where('activo', 1)->get();

        $preguntaRand1 = rand(0, count($preguntasPre) - 1);

        $preguntaRand2 = rand(0, count($preguntasPre) - 1);

        if($preguntaRand1 == $preguntaRand2){
            $preguntaRand1 = rand(0, count($preguntasPre) - 1);
        }

        if($preguntaRand2 == $preguntaRand1){
            $preguntaRand2 = rand(0, count($preguntasPre) - 1);
        }

        return view("admin.reclutamiento.modal.nueva_prueba_idioma", compact("tipo_pregunta","req_id", "cliente", "negocio",  "preguntasPre", "preguntaRand1", "preguntaRand2"));
    }

    public function guardar_prueba(Request $data)
    {
        $nueva_prueba_idioma = new PruebaIdioma();
        $nueva_prueba_idioma->fill([
            "user_gestion"       =>$this->user->id,
            "activo"             => 1,
            "req_id"             => $data->req_id,
        ]);
        $nueva_prueba_idioma->save();

        for ($i = 0; $i < count($data->descripcion); $i++) {
            
            $nueva_pregunta = new PreguntasPruebaIdioma();

            $nueva_pregunta->fill([
                "descripcion"       => $data->descripcion[$i],
                "tiempo"            => $data->tiempo[$i],
                "prueba_idio_id"    => $nueva_prueba_idioma->id,
            ]);

            $nueva_pregunta->save();

        }

        return response()->json(["success" => true]);
    }

    //----------
    public function pregunta_activa(Request $data)
    {
        $ae = PreguntasPruebaIdioma::find($data->pregunta_id);
        $ae->activo = 0;
        $ae->save();
    }

    public function pregunta_inactiva(Request $data)
    {
        $ae = PreguntasPruebaIdioma::find($data->pregunta_id);
        $ae->activo = 1;
        $ae->save();
    }

    public function video_respuesta_candidato(Request $data)
    {
        $respuesta = RespuestaPruebaIdioma::where('respuestas_pruebas_idiomas.candidato_id', $data->candidato_id)
        ->where('respuestas_pruebas_idiomas.preg_prueba_id', $data->pregunta_id)
        ->first();
  
        return view("admin.reclutamiento.modal.respuesta_candidato_video_idioma", compact("respuesta"));
    }

    //-----------
    public function crear_pregunta(Request $data)
    {
        $entre_id = $data->entrevista_id;

        return view("admin.reclutamiento.modal.nueva_pregunta_prueba_idioma", compact("entre_id"));
    }

    public function guardar_pregunta(Request $data)
    {
        $entre_id = $data->entre_id;

        $nueva_pregunta = new PreguntasPruebaIdioma();
        $nueva_pregunta->fill([
            "descripcion"    => $data->descripcion,
            "prueba_idio_id" => $entre_id,
            "activo"         => 1,
            "tiempo"         => $data->tiempo,
        ]);

        $nueva_pregunta->save();

        return response()->json(["success" => true]);
    }

    public function editar_pregunta(Request $data)
    {
        $pregunta_prueba = PreguntasPruebaIdioma::where('preguntas_pruebas_idiomas.id',$data->pregunta_id)
        ->select('preguntas_pruebas_idiomas.*')
        ->first();

        return view("admin.reclutamiento.modal.editar_pregunta_idioma", compact("pregunta_prueba"));
    }

    public function actualizar_pregunta(Request $data)
    {
        $pregunta_actualizada = PreguntasPruebaIdioma::find($data->pregu_id);
        
        $pregunta_actualizada->descripcion = $data->descripcion;
        $pregunta_actualizada->tiempo = $data->tiempo;
        $pregunta_actualizada->save();

        return response()->json(["success" => true]);
    }

    //--------
    public function responder_idioma_pregu(Request $data){        
        
        $pregu_id = $data->pregu_id;
        $pregunta_prueba = PreguntasPruebaIdioma::where('id',$pregu_id)->first();

        $user_id = $data->user_id;

        return view("cv.modal.responder_pregu_idioma",compact('user_id','pregunta_prueba','pregu_id','preguntas_entre'));

    }

    public function guardar_respu_idioma(Request $data){

        $respuesta_pregu = RespuestaPruebaIdioma::where('respuestas_pruebas_idiomas.candidato_id',$data->user_id)
        ->where('respuestas_pruebas_idiomas.preg_prueba_id',$data->preg_entre_id)
        ->first();
        
        if ($respuesta_pregu == null) {
            $respuesta_pregu = new RespuestaPruebaIdioma();
        }

        $respuesta_pregu->preg_prueba_id = $data->preg_entre_id;
        $respuesta_pregu->candidato_id = $data->user_id;

        $respuesta_pregu->save();

        //GUARDANDO VIDEO
        $archivo   = $data->file('video-blob');
        $extencion = $archivo->getClientOriginalExtension();
        $fileName  = "VideoRespuestaIdioma_"."$respuesta_pregu->candidato_id". $respuesta_pregu->preg_prueba_id  . ".$extencion";
        
        //ELIMINAR FOTO PERFIL
        if ($respuesta_pregu->respuesta != "" && file_exists("recursos_VideoIdioma/" . $respuesta_pregu->respuesta)) {
            unlink("recursos_VideoIdioma/" . $respuesta_pregu->respuesta);
        }
        
        $respuesta_pregu->respuesta = $fileName;
        $respuesta_pregu->save();
        $data->file('video-blob')->move("recursos_VideoIdioma", $fileName);
        
        return response()->json(["success" => true]);
    }

}
