<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/*Facades*/
use Illuminate\Support\Facades\DB;

/*Models*/
use App\Models\Clientes;
use App\Models\DatosBasicos;
use App\Models\ReqCandidato;
use App\Models\UserClientes;
use App\Models\Requerimiento;
use App\Models\TipoDocumento;
use App\Models\FirmaContratos;
use App\Models\ConfirmacionPreguntaContrato;
use App\Models\ContratoCancelado;
use App\Models\Sitio;
use App\Models\GestionPrueba;
use App\Models\RegistroProceso;
use App\Models\PruebaBrigResultado;    
use App\Models\PruebaDigitacionResultado;
use App\Models\PruebaValoresRespuestas;
use App\Models\PruebaCompetenciaResultado;
use App\Models\PruebaExcelRespuestaUser;
use App\Models\Documentos;
use App\Models\ConfirmacionDocumentosAdicionales;
use App\Models\EvaluacionSstConfiguracion;
use Carbon\Carbon;

class ClienteContratadosController extends Controller
{
    public function index(Request $data)
    {
        $user_sesion = $this->user;

        $cliente_relacionado = UserClientes::where("user_id", $user_sesion->id)->select("cliente_id")->get();

        $procesos = ['ENVIO_CONTRATACION', 'ENVIO_CONTRATACION_CLIENTE'];

        $id_user = DatosBasicos::where("numero_id", $data->get("cedula"))->first();
        $estado = [1];

        $estados_requerimiento = [
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            16
        ];
        
        $sitio = Sitio::first();

        $candidatos = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join('users', 'users.id', '=', 'datos_basicos.user_id')
        ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        //->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
        ->leftjoin("ciudad", function ($join) {
            $join->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
        //->whereNull("procesos_candidato_req.apto")
        //->Orwhere("procesos_candidato_req.apto", 1)
        ->whereIn("clientes.id", $this->clientes_user)
        ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
        //->whereBetween(DB::raw('DATE_FORMAT(procesos_candidato_req.created_at, \'%Y-%m-%d\')'), [date("Y-m-d", strtotime(date("Y-m-d")."- 3 month")), date("Y-m-d")])
        //->whereBetween('procesos_candidato_req.created_at', ['2020-03-31', date("Y-m-d", strtotime(date("Y-m-d")."+ 1 days"))])
        //->whereRaw('requerimiento_cantidato.id=(select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.requerimiento_id=requerimientos.id and requerimiento_cantidato.candidato_id=users.id)')
        ->where(function ($sql) use ($data, &$procesos, &$perro, &$estado, &$estados_requerimiento, &$ordenamiento, $sitio) {
            if ($data->has("num_req") && $data->get("num_req") != "") {
                $sql->where("requerimiento_cantidato.requerimiento_id", $data->get("num_req"));
                $estado = [0, 1];
                 $estados_requerimiento = [
                        config('conf_aplicacion.C_TERMINADO'),
                        config('conf_aplicacion.C_RECLUTAMIENTO'),
                        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                        config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                        config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                        config('conf_aplicacion.C_CLIENTE'),
                        2,
                        3
                    ];
            }

            if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                $sql->where("clientes.id", $data->get("cliente_id"));
            }

            if ($data->has("estado") && $data->get("estado") != "") {
                //$sql->where("requerimiento_cantidato.estado_contratacion", $data->get("estado"));
                $estado = [$data->get("estado")];

                if ($data->get("estado") == 0) {
                    $estados_requerimiento = [
                        config('conf_aplicacion.C_TERMINADO'),
                        config('conf_aplicacion.C_RECLUTAMIENTO'),
                        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                        config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                        config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                        config('conf_aplicacion.C_CLIENTE'),
                        2,
                        3
                    ];
                    $ordenamiento = "DESC";
                }
            }

            if ($data->has("cedula") && $data->get("cedula") != "") {
                $sql->where("datos_basicos.numero_id", $data->get("cedula"));

                //$procesos = $procesos + ['FIRMA_VIRTUAL_SIN_VIDEOS', 'FIN_CONTRATACION_VIRTUAL','"FIRMA_CONF_MAN'];
                $estado = [0, 1];

                $estados_requerimiento = [
                    config('conf_aplicacion.C_TERMINADO'),
                    config('conf_aplicacion.C_RECLUTAMIENTO'),
                    config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                    config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                    config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                    config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                    config('conf_aplicacion.C_CLIENTE'),
                    2,
                    3
                ];
            }

            if($sitio->agencias){
                $sql->whereIn("ciudad.agencia", $this->user->agencias());
            }
        })
        ->where("cargos_especificos.firma_digital", 1)
        //->whereIn("procesos_candidato_req.proceso", $procesos)
        //->whereIn("requerimiento_cantidato.estado_contratacion", $estado)
        //->whereNotIn('requerimiento_cantidato.estado_candidato', [config('conf_aplicacion.C_QUITAR')])
        ->whereIn('requerimiento_cantidato.estado_candidato', [11,12])
        ->whereIn("estados_requerimiento.estado", $estados_requerimiento)
        ->select(
            "requerimiento_cantidato.id as req_can_id",
            "cargos_especificos.descripcion as cargo",
            "cargos_especificos.videos_contratacion as videos_cargo",
            "requerimiento_cantidato.candidato_id as candidato_id",
            "requerimiento_cantidato.requerimiento_id as req_id",
            "datos_basicos.*",
            "datos_basicos.id as datos_basicos_id",
            "datos_basicos.user_id as user_id",
            "clientes.nombre as cliente",
            "clientes.id as cliente_id",
            "ciudad.nombre as nombre_ciudad",
            //"procesos_candidato_req.created_at as fecha_contrato",
            "tipo_proceso.descripcion as tipo_proceso",
            "tipo_proceso.contratacion_directa",
            //"procesos_candidato_req.fecha_ingreso_contra as fecha_inicio",
            "requerimientos.fecha_ingreso as fecha_ingreso",
            //"procesos_candidato_req.observaciones as observacion",
            //"procesos_candidato_req.id as proceso_candidato_req",
            DB::raw('(SELECT MAX(requerimiento_cantidato.id) FROM requerimiento_cantidato WHERE requerimiento_cantidato.candidato_id = users.id) as requerimiento_candidato'),
            //"procesos_candidato_req.asistira as asistira",
            //"procesos_candidato_req.id as proceso",
            //"procesos_candidato_req.proceso as nombre_proceso",
            "cargos_especificos.firma_digital as firma_digital",
            "cargos_especificos.id as cargo_id",
            "requerimiento_cantidato.id",
            "requerimiento_cantidato.estado_candidato",
            //DB::raw('(select name from users where users.id=procesos_candidato_req.usuario_envio) as user_envio'),
            DB::raw('(select id from orden_medica where req_can_id=requerimiento_cantidato.id limit 1 ) as enviado_examen'),
            DB::raw('(select id from orden_estudio_seguridad where req_can_id=requerimiento_cantidato.id limit 1 ) as enviado_estudio')
        )
        ->with("procesos","contratos")
        //->groupBy("requerimiento_cantidato.id")
        ->orderBy("requerimientos.fecha_ingreso", "DESC")
        ->take(100)
        ->paginate(12);

        $estados = ["" => "Seleccione", 0 => "Contratados", 1 => "En proceso contratacion"];

        $clientes = ["" => "Seleccionar"] + Clientes::orderBy("clientes.nombre", "ASC")->pluck("clientes.nombre", "clientes.id")->toArray();

        return view("req.mis_contratados_new", compact(
            "user_sesion",
            "candidatos",
            "clientes",
            "usuarios",
            "estados",
            "sitio"
        ));

    }

    public function gestionar_candidato_req($candidato, $req)
    {
        $datos_candidato = DatosBasicos::where('user_id', $candidato)->first();

        $requerimiento = Requerimiento::join("negocio","negocio_id", "=", "requerimientos.negocio_id")
        ->join("clientes",  "clientes.id", "=", "negocio.cliente_id")
        ->where("requerimientos.id", $req)
        ->select("requerimientos.*", "clientes.id as cliente")
        ->first();

        $candi_req = ReqCandidato::where("candidato_id",$candidato)
        ->where("requerimiento_id", $req)
        ->select('requerimiento_cantidato.id as id')
        ->first();

        $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
        //->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
        //->leftjoin("users", "users.id", "=", "documentos.user_id")
        ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
        ->where("tipos_documentos.estado", 1)
        ->select(
            "tipos_documentos.id as id",
            "tipos_documentos.descripcion as descripcion",
            "tipos_documentos.categoria as categoria",
            DB::raw("(select documentos.nombre_archivo from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.active = 1 order by documentos.id desc limit 1) as nombre")
        )
        ->orderBy("id")
        ->get();

        $docs = Documentos::select('nombre_archivo as nombre','nombre_archivo_real as nombre_real', 'id as id_documento','tipo_documento_id')->where('user_id', $candidato)->where('requerimiento', $req)->where("active",1)->latest('id')->groupBy('tipo_documento_id')->get();

        $documento_contratacion_cargados = $docs->whereIn('tipo_documento_id', $tipo_documento->where('categoria', 2)->pluck('id'))->unique('tipo_documento_id');

        $documento_seleccion = $tipo_documento->filter(function ($value) {
            return $value->categoria == 1;
        });

        $documento_contratacion = $tipo_documento->filter(function ($value) {
            return $value->categoria == 2;
        });

        $documento_confidenciales = $tipo_documento->filter(function ($value) {
            return $value->categoria == 3;
        });

        $check_seleccion = $documento_seleccion->filter(function ($value) {
            return $value->nombre != "";
        })->count();

        if($documento_seleccion->count() != 0){
            $porcentaje_seleccion = round($check_seleccion*100/$documento_seleccion->count(),2);
        }else{
            $porcentaje_seleccion = 0;
        }

        $cantidad_doc_contratacion = $tipo_documento->where('categoria', 2)->count();

        if(count($documento_contratacion_cargados) > 0){
            $porcentaje_contratacion = round($documento_contratacion_cargados->count()*100/$cantidad_doc_contratacion, 2);
        }else{
            $porcentaje_contratacion = 0;
        }

        $check_confidencial = $documento_confidenciales->filter(function ($value) {
            return $value->nombre != "";
        })->count();

        if($documento_confidenciales->count() != 0){
            $porcentaje_confidencial = round($check_confidencial*100/$documento_confidenciales->count(),2);
        }else{
            $porcentaje_confidencial = 0;
        }

        return view("req.contratacion.gestion_new",compact(
            "porcentaje_seleccion",
            "porcentaje_contratacion",
            "porcentaje_confidencial",
            "candidato",
            "req",
            "datos_candidato",
            "requerimiento",
            "candi_req"
        ));
    }

    public function documentos_seleccion($candidato, $req, $req_can)
    {
        $candidato_id = $candidato;
        $requerimiento = Requerimiento::join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->where("requerimientos.id", $req)
        ->select(
            "requerimientos.*",
            "tipo_proceso.descripcion as tipo_proceso"
        )
        ->first();

        $datos_candidato = DatosBasicos::where('user_id', $candidato)->first();

        $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
            ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
            ->where("categoria", 1)
            ->where("tipos_documentos.estado", 1)
            ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
            ->select(
              "tipos_documentos.id as id",
              "tipos_documentos.descripcion as descripcion",
              DB::raw("(select d.created_at from documentos as d where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id order by d.id desc limit 1) as fecha_carga"),
              DB::raw("(select d.fecha_vencimiento from documentos as d where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id order by d.id desc limit 1) as fecha_vencimiento"),
              DB::raw("(select u.name from documentos d left join users u on d.gestiono=u.id where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id order by d.id desc limit 1) as usuario_gestiono")
            )
            ->orderBy("id")
            ->groupBy("id")
        ->get();

        $docs = Documentos::select(
                'nombre_archivo as nombre',
                'nombre_archivo_real as nombre_real',
                'id as id_documento',
                'fecha_vencimiento as fecha_vencimiento',
                'tipo_documento_id',
                'created_at as fecha_carga',
                'gestiono'
            )
            ->where('user_id', $candidato_id)
            ->where("active",1)
        ->get();


        foreach ($tipo_documento as $key => &$tipo_doc) {
            $filter = $docs->filter(function ($value) use ($tipo_doc){
                return $value->tipo_documento_id==$tipo_doc->id;
            });
            $tipo_doc->documentos= $filter->take(5);
        }
        unset($tipo_doc);

        //Pruebas realizadas
        $pruebas = GestionPrueba::join("users", "users.id", "=", "gestion_pruebas.candidato_id")
        ->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "gestion_pruebas.id")
        ->leftjoin("tipos_pruebas", "tipos_pruebas.id", "=", "gestion_pruebas.tipo_prueba_id")
        ->where("gestion_pruebas.candidato_id", $candidato_id)
        ->where("gestion_pruebas.activo", "1")
        ->where("proceso_requerimiento.tipo_entidad", "MODULO_PRUEBAS")
        ->where("proceso_requerimiento.requerimiento_id", $req)
        ->select(
            "gestion_pruebas.*",
            "tipos_pruebas.descripcion as prueba_desc",
            "users.name"
        )
        ->get();

        $pruebas_internas = RegistroProceso::where('requerimiento_candidato_id', $req_can)
        ->whereIn('proceso', ['ENVIO_PRUEBA_BRYG', 'ENVIO_PRUEBA_DIGITACION', 'ENVIO_PRUEBA_ETHICAL_VALUES', 'ENVIO_PRUEBA_COMPETENCIA', 'ENVIO_EXCEL_INTERMEDIO', 'ENVIO_EXCEL_BASICO'])
        ->whereNotNull('apto')
        ->select('id', 'requerimiento_candidato_id', 'proceso', 'requerimiento_id', 'candidato_id')
        ->get();

        $enlaces_pruebas = [];

        foreach ($pruebas_internas as $prueba) {
            switch ($prueba->proceso) {
                case 'ENVIO_PRUEBA_BRYG':
                    $consulta = PruebaBrigResultado::where('user_id', $prueba->candidato_id)->where('req_id', $prueba->requerimiento_id)->where('estado', 1)->orderBy('id', 'desc')->select('id')->first();
                    if ($consulta != null) {
                        $enlaces_pruebas[] = (object)['nombre' => 'BRYG', 'enlace' => route('admin.prueba_bryg_informe', [$consulta->id])];
                    }
                    break;

                case 'ENVIO_PRUEBA_DIGITACION':
                    $consulta = PruebaDigitacionResultado::where('user_id', $prueba->candidato_id)->where('req_id', $prueba->requerimiento_id)->where('estado', 1)->orderBy('id', 'desc')->select('id')->first();
                    if ($consulta != null) {
                        $enlaces_pruebas[] = (object)['nombre' => 'Digitación', 'enlace' => route('admin.prueba_digitacion_informe', [$consulta->id])];
                    }
                    break;

                case 'ENVIO_PRUEBA_ETHICAL_VALUES':
                    $consulta = PruebaValoresRespuestas::where('user_id', $prueba->candidato_id)->where('req_id', $prueba->requerimiento_id)->orderBy('id', 'desc')->select('id')->first();
                    if ($consulta != null) {
                        $enlaces_pruebas[] = (object)['nombre' => 'Ethical Values', 'enlace' => route('admin.pdf_prueba_valores', [$consulta->id])];
                    }
                    break;

                case 'ENVIO_PRUEBA_COMPETENCIA':
                    $consulta = PruebaCompetenciaResultado::where('user_id', $prueba->candidato_id)->where('req_id', $prueba->requerimiento_id)->where('estado', 1)->orderBy('id', 'desc')->select('id')->first();
                    if ($consulta != null) {
                        $enlaces_pruebas[] = (object)['nombre' => 'Personal Skills', 'enlace' => route('admin.prueba_competencias_informe', [$consulta->id])];
                    }
                    break;

                default:
                    if ($prueba->proceso === 'ENVIO_EXCEL_BASICO') {
                        $tipo = 'basico';
                        $nombre = 'Excel Básico';
                    } else {
                        $tipo = 'intermedio';
                        $nombre = 'Excel Intermedio';
                    }
                    $consulta = PruebaExcelRespuestaUser::where('user_id', $prueba->candidato_id)->where('req_id', $prueba->requerimiento_id)->where('tipo', $tipo)->orderBy('id', 'desc')->select('id')->first();
                    if ($consulta != null) {
                        $enlaces_pruebas[] = (object)['nombre' => $nombre, 'enlace' => route('admin.pdf_prueba_excel', [$consulta->id])];
                    }
                    break;
            }
        }

        return view('req.contratacion.documentos_seleccion_new',compact(
            'tipo_documento',
            'req',
            'candidato_id',
            'req_can',
            'requerimiento',
            'datos_candidato',
            'pruebas',
            'enlaces_pruebas'
        ));
    }

    public function documentos_contratacion($candidato, $req)
    {
        $candidato_id = $candidato;
        $requerimiento = Requerimiento::join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->where("requerimientos.id", $req)
        ->select(
            "requerimientos.*",
            "tipo_proceso.descripcion as tipo_proceso"
        )
        ->first();

        $datos_candidato = DatosBasicos::where('user_id', $candidato_id)->first();

        /*$tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("users", "users.id", "=", "documentos.user_id")
        ->where("categoria", 2)
        ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
        ->select(
            "tipos_documentos.id as id",
            "tipos_documentos.descripcion as descripcion",
            DB::raw("(select documentos.nombre_archivo from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id desc limit 1) as nombre")
        )
        ->orderBy("id")
        ->groupBy("id")
        ->get();*/


        $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
            ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
            ->where("categoria", 2)
            ->where("tipos_documentos.estado", 1)
            ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
            ->select(
              "tipos_documentos.id as id",
              "tipos_documentos.descripcion as descripcion"
            )
            ->orderBy("id")
            ->groupBy("id")
        ->get();

        // foreach ($tipo_documento as $key => &$tipo_doc) {
        //     $tipo_doc->documentos = DB::table('documentos')->select('nombre_archivo as nombre')->where('user_id', $candidato_id)->where('tipo_documento_id', $tipo_doc->id)->where('requerimiento', $req)->latest()->limit(5)->get();
        // }

        $docs = Documentos::select(
                'nombre_archivo as nombre',
                'nombre_archivo_real as nombre_real',
                'id as id_documento',
                'fecha_vencimiento as fecha_vencimiento',
                'tipo_documento_id',
                'created_at as fecha_carga',
                'gestiono'
            )
            ->where('user_id', $candidato_id)
            ->where('requerimiento', $req)
            ->where("active",1)
            ->latest('id')
        ->get();

        foreach ($tipo_documento as $key => &$tipo_doc) {
            $tipo_doc->documentos = $docs->filter(function ($value) use ($tipo_doc){
                return $value->tipo_documento_id==$tipo_doc->id;

            });

            $tipo_doc->documentos= $tipo_doc->documentos->take(5);

        }
        unset($tipo_doc);

        //Si es contrato cargado manual
        $contrato_manual = Documentos::where('user_id', $candidato)
        ->where('descripcion_archivo', 'CONTRATO')
        ->orderBy('created_at', 'DESC')
        ->first();

        //Check contrato
        $firmaContrato = FirmaContratos::where('user_id', $candidato)
        ->where('req_id', $req)
        ->where('estado', 1)
        ->orderBy('created_at', 'DESC')
        ->first();

        //Check contrato anulado
        $anuladoContrato = ContratoCancelado::where('user_id', $candidato)
        ->where('req_id', $req)
        ->orderBy('created_at', 'DESC')
        ->first();

        $getVideoQuestion = ConfirmacionPreguntaContrato::join('preguntas_contrato', 'preguntas_contrato.id', '=', 'confirmacion_preguntas_contrato.pregunta_id')
        ->join('firma_contratos', 'firma_contratos.id', '=', 'confirmacion_preguntas_contrato.contrato_id')
        ->where('confirmacion_preguntas_contrato.user_id', $candidato)
        ->where('confirmacion_preguntas_contrato.req_id', $req)
        ->where('firma_contratos.estado', 1)
        ->select('confirmacion_preguntas_contrato.*', 'preguntas_contrato.archivo as desc_pregunta')
        ->get();

        $clausulasContrato = null;
        if ($firmaContrato != null || $firmaContrato != '') {
            $clausulasContrato = ConfirmacionDocumentosAdicionales::where('user_id', $candidato)
            ->where('contrato_id', $firmaContrato->id)
            ->where('estado', 1)
            ->get();
        }

        $req_cand = ReqCandidato::where('requerimiento_id',$req)
        ->where('candidato_id', $candidato)
        //->where('estado_candidato', 11)
        ->orderBy('created_at', 'DESC')
        ->first();

        $configuracion_sst = EvaluacionSstConfiguracion::first();

        return view('req.contratacion.documentos_contratacion_new', compact(
            "tipo_documento",
            "candidato_id",
            "req",
            "firmaContrato",
            "getVideoQuestion",
            "requerimiento",
            "datos_candidato",
            "anuladoContrato",
            "contrato_manual",
            "clausulasContrato",
            "configuracion_sst"
        ));
    }

    public function cargar_documento_req_seleccion(Request $request)
    {
        $tipo_documento = ["" => "Seleccionar"] + TipoDocumento::where('categoria', 1)->pluck("descripcion", "id")->toArray();
        
        $cand_id = $request->user_id;

        return view("req.contratacion.modal.documentos_seleccion_new", compact("tipo_documento", "cand_id"));
    }
}
