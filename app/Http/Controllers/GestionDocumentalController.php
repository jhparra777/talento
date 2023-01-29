<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Jobs\FuncionesGlobales;
use App\Models\AgenciaUsuario;
use App\Models\Clientes;
use App\Models\DatosBasicos;
use App\Models\Requerimiento;
use App\Models\GrupoFamilia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Models\RequerimientoContratoCandidato;
use App\Models\ReqCandidato;
use App\Models\User;
use App\Models\TipoDocumento;
use App\Models\Documentos;
use App\Models\DocumentosCargo;
use App\Models\DataEmailEnviados;
use App\Models\OrdenMedica;
use App\Models\ExamenesMedicos;
use App\Models\EstadosOrdenes;
use App\Models\EvaluacionSstConfiguracion;
use App\Models\RegistroProceso;
use App\Models\MotivosCancelacionContratacion;
use App\Models\FirmaContratos;
use App\Models\ConfirmacionPreguntaContrato;
use App\Models\EntrevistaCandidatos;
use App\Models\PreguntasPruebaIdioma;
use App\Models\ConsultaSeguridad;
use App\Models\ContratoCancelado;
use App\Models\GestionPrueba;
use App\Models\Sitio;
use App\Models\TruoraKey;
use App\Models\PruebaBrigResultado;
use App\Models\PruebaCompetenciaResultado;
use App\Models\PruebaDigitacionResultado;
use App\Models\PruebaExcelRespuestaUser;
use App\Models\PruebaValoresRespuestas;
use App\Models\CarpetaContratacion;
use App\Models\DocumentoCarpetaContratacion;
use App\Models\ConfirmacionDocumentosAdicionales;
use App\Models\EstadosRequerimientos;
use App\Models\DocumentoFamiliar;
use App\Models\SitioModulo;
use App\Models\Agencia;
use App\Models\CategoriaDocumentoCliente;
use App\Models\TipoDocumentoCliente;
use App\Models\DocumentoCliente;
use ZipArchive;
use Illuminate\Support\Facades\Event;
use App\Models\Auditoria;
use App\Http\Controllers\ReclutamientoController;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;

use Storage;

use GuzzleHttp\Client;
//Helper
use triPostmaster;

//Integrations
use App\Http\Controllers\Integrations\TruoraIntegrationController;

class GestionDocumentalController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        //SON LOS ESTADOS PARA NO MOSTRAR EL CANDIDATO EN EL  REQUERIMIENTO
        $this->estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
            config('conf_aplicacion.C_TRANSFERIDO')
        ];
    }

    /*
     *  Vista principal del asistente de contratación 
    */
    public function index(Request $data)
    {
        $user_sesion = $this->user;

        $sitio = Sitio::first();
        $rango_fecha = $data->rango_fecha;
        if ($rango_fecha != "") {

              $rango = explode(" | ", $rango_fecha);
              $fecha_inicio = $rango[0];
              $fecha_final  = $rango[1];
            } else {
              $fecha_inicio = '';
              $fecha_final  = '';
        }

        if($sitio->precontrata == 1){
            $procesos = ['ENVIO_CONTRATACION', 'PRE_CONTRATAR'];
        }else{
            $procesos = ['ENVIO_CONTRATACION'];
        }

        $id_user = DatosBasicos::where("numero_id", $data->get("cedula"))->first();

        $estado = [0];
        $estados_requerimiento = [
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
        ];

        $ordenamiento = "ASC";

        //indicadores
        $fecha_hoy = Carbon::now();
        $fecha_hoy = $fecha_hoy->format('Y-m-d');

        
        $candidatos = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join('users', 'users.id', '=', 'datos_basicos.user_id')
        ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
        ->leftjoin("ciudad", function ($join) {
            $join->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
        ->leftjoin('agencias','agencias.id','=','ciudad.agencia')
        //->whereNull("procesos_candidato_req.apto")
        //->Orwhere("procesos_candidato_req.apto", 1)
        ->whereIn("clientes.id", $this->clientes_user)
        ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
        //->whereBetween(DB::raw('DATE_FORMAT(procesos_candidato_req.created_at, \'%Y-%m-%d\')'), [date("Y-m-d", strtotime(date("Y-m-d")."- 3 month")), date("Y-m-d")])
        ->whereBetween('procesos_candidato_req.created_at', ['2020-03-31', date("Y-m-d", strtotime(date("Y-m-d")."+ 1 days"))])
        ->whereRaw('requerimiento_cantidato.id=(select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.requerimiento_id=requerimientos.id and requerimiento_cantidato.candidato_id=users.id)')
        ->where(function ($sql) use ($data, &$procesos, &$perro, &$estado, &$estados_requerimiento, &$ordenamiento, $sitio,$fecha_inicio,$fecha_final) {
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

            if($data->get("agencia") != ""){
                $sql->where("agencias.id", $data->get("agencia"));
            }

            if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("requerimiento_cantidato.fecha_terminacion_contrato", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
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
        ->whereIn("procesos_candidato_req.proceso", $procesos)
        ->whereIn("requerimiento_cantidato.contratado_retirado", $estado)
        ->whereNotIn('requerimiento_cantidato.estado_candidato', [config('conf_aplicacion.C_QUITAR')])
        ->whereIn("estados_requerimiento.estado", $estados_requerimiento)
        ->select(
            "cargos_especificos.descripcion as cargo",
            "requerimiento_cantidato.candidato_id as candidato_id",
            "requerimiento_cantidato.requerimiento_id as req_id",
            "requerimiento_cantidato.contratado_retirado",
            "datos_basicos.*",
            "datos_basicos.id as datos_basicos_id",
            "datos_basicos.user_id as user_id",
            "clientes.nombre as cliente",
            "clientes.id as cliente_id",
            "ciudad.nombre as nombre_ciudad",
            "procesos_candidato_req.created_at as fecha_contrato",
            "tipo_proceso.descripcion as tipo_proceso",
            "tipo_proceso.contratacion_directa",
            "procesos_candidato_req.fecha_ingreso_contra as fecha_inicio",
            "requerimientos.fecha_ingreso as fecha_ingreso",
            "procesos_candidato_req.observaciones as observacion",
            "procesos_candidato_req.id as proceso_candidato_req",
            "requerimiento_cantidato.fecha_terminacion_contrato",
            DB::raw('(SELECT MAX(requerimiento_cantidato.id) FROM requerimiento_cantidato WHERE requerimiento_cantidato.candidato_id = users.id) as requerimiento_candidato'),
            "procesos_candidato_req.asistira as asistira",
            "procesos_candidato_req.id as proceso",
            "procesos_candidato_req.proceso as nombre_proceso",
            "cargos_especificos.firma_digital as firma_digital",
            "cargos_especificos.id as cargo_id",
            DB::raw('(select name from users where users.id=procesos_candidato_req.usuario_envio) as user_envio'),
            DB::raw('(select id from orden_medica where req_can_id=requerimiento_cantidato.id limit 1 ) as enviado_examen'),
            DB::raw('(select id from orden_estudio_seguridad where req_can_id=requerimiento_cantidato.id limit 1 ) as enviado_estudio'),
            "requerimiento_cantidato.id",
            "requerimiento_cantidato.id as req_can_id"
        )
        
        ->groupBy("requerimiento_cantidato.id")
        ->orderBy("requerimientos.fecha_ingreso", $ordenamiento)
        ->with('procesos')
        ->paginate(12);


        $estados = ["" => "Seleccione", 1 => "Contratado retirado", 0 => "Contratado"];

        $clientes = ["" => "Seleccionar"] + Clientes::orderBy("clientes.nombre", "ASC")->pluck("clientes.nombre", "clientes.id")->toArray();

        $agencias = ["" =>"-Seleccionar -"]+Agencia::pluck("agencias.descripcion","agencias.id")->toArray();

        session(["url_previa" => url($_SERVER['REQUEST_URI'])]);

        return view("admin.mod_gestion_documental.index", compact(
            "user_sesion",
            "candidatos",
            "clientes",
            "usuarios",
            "estados",
            "sitio",
            "firmas_pendientes",
            "contrataciones_vencidas",
            "contrataciones_pendientes",
            "agencias"
        ));
    }

     public function gestionar_candidato($candidato,$req)
    {
        $datos_candidato = DatosBasicos::where('user_id', $candidato)->first();
        $current_user=$this->user;

        $requerimiento = Requerimiento::join("negocio","negocio_id","=","requerimientos.negocio_id")
        ->join("clientes", "clientes.id","=","negocio.cliente_id")
        ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->where("requerimientos.id", $req)
        ->select(
            "requerimientos.*",
            "clientes.id as cliente",
            "tipo_proceso.descripcion as tipo_proceso"
        )
        ->first();

        $candi_req = ReqCandidato::where("candidato_id", $candidato)
            ->where("requerimiento_id", $req)
            ->select('requerimiento_cantidato.*')
        ->first();

        $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
            ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
            ->where("tipos_documentos.estado", 1)
            ->whereNotIn('categoria', [3, 5])    //No traer los documentos confidenciales (3) ni los de beneficiarios (5)
            ->select(
                "tipos_documentos.id as id",
                "tipos_documentos.descripcion as descripcion",
                "tipos_documentos.categoria as categoria",
                DB::raw("CASE WHEN(tipos_documentos.categoria=3) THEN (select documentos.nombre_archivo from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id desc limit 1) ELSE (select documentos.nombre_archivo from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id order by documentos.id desc limit 1) END as nombre")
                /*DB::raw("(select documentos.nombre_archivo from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id order by documentos.id desc limit 1) as nombre"),
                 DB::raw("(select documentos.requerimiento from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id desc limit 1) as req")*/
            )
            ->orderBy("tipos_documentos.id")
            ->groupBy("tipos_documentos.id")
        ->get();

         $tipo_documento_confidencial = TipoDocumento::where("categoria", 3)
            ->where("tipos_documentos.estado", 1)
            ->select(
                "tipos_documentos.id as id",
                "tipos_documentos.descripcion as descripcion",
                DB::raw("(select documentos.nombre_archivo from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id desc limit 1) as nombre")
            )
            ->orderBy("tipos_documentos.id")
            ->groupBy("tipos_documentos.id")
        ->get();

        $documento_seleccion = $tipo_documento->filter(function ($value) {
            return $value->categoria == 1;
        });

        $documento_contratacion = $tipo_documento->filter(function ($value) {
            return $value->categoria == 2;
        });

        $documento_post = $tipo_documento->filter(function ($value) {
            return $value->categoria == 4;
        });

        $check_seleccion = $documento_seleccion->filter(function ($value) {
            return $value->nombre != "";
        })->count();

        if($documento_seleccion->count() != 0){
            $porcentaje_seleccion = round($check_seleccion*100/$documento_seleccion->count(), 2);
        }else{
            $porcentaje_seleccion = 0;
        }

        $check_contratacion = $documento_contratacion->filter(function ($value) {
            return $value->nombre != "";
        })->count();

        if($documento_contratacion->count() != 0){
            $porcentaje_contratacion = round($check_contratacion*100/$documento_contratacion->count(), 2);
        }else{
            $porcentaje_contratacion = 0;
        }

        $check_confidencial = $tipo_documento_confidencial->filter(function ($value) {
            return $value->nombre != "";
        })->count();

        /*$check_confidencial = $tipo_documento->filter(function ($value) {

            return $value->nombre != "";
        })->count();*/


        if($tipo_documento_confidencial->count() != 0){
            $porcentaje_confidencial = round($check_confidencial*100/$tipo_documento_confidencial->count(), 2);
        }else{
            $porcentaje_confidencial = 0;
        }

        /*if($documento_confidenciales->count() != 0){
            $porcentaje_confidencial = round($check_confidencial*100/$documento_confidenciales->count(), 2);
        }else{
            $porcentaje_confidencial = 0;
        }*/

        $check_post = $documento_post->filter(function ($value) {
            return $value->nombre != "";
        })->count();

        if($documento_post->count() != 0){
            $porcentaje_post = round($check_post*100/$documento_post->count(), 2);
        }else{
            $porcentaje_post = 0;
        }

        return view("admin.mod_gestion_documental.gestion", compact(
            "porcentaje_seleccion",
            "porcentaje_contratacion",
            "porcentaje_confidencial",
            "porcentaje_post",
            "candidato",
            "req",
            "datos_candidato",
            "requerimiento",
            "candi_req",
            "current_user"
        ));
    }

    public function closeFolderGestion(Request $request){

        $req_can=ReqCandidato::find($request->get("req_can_id"));

        Event::dispatch(new \App\Events\CloseSelectionFolderEvent($req_can,$request->get("folder")));



        return response()->json(["success"=>true]);

    }

     public function documentos_seleccion($candidato, $req, $req_can)
    {
        $req_candidato = ReqCandidato::find($req_can);
        $candidato_id = $candidato;
        $current_user=$this->user;

        $requerimiento = Requerimiento::join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->where("requerimientos.id", $req)
        ->select(
            "requerimientos.*",
            "tipo_proceso.descripcion as tipo_proceso"
        )
        ->first();

        $datos_candidato = DatosBasicos::where('user_id', $candidato_id)->first();

        if($req_candidato->bloqueo_carpeta){
            $tipo_documento = DocumentoCarpetaContratacion::join("carpetas_contratacion", "carpetas_contratacion.id", "=", "documentos_carpetas_contratacion.carpeta_id")
            ->join("tipos_documentos", "tipos_documentos.id", "=", "documentos_carpetas_contratacion.tipo_documento_id")
            ->where("carpetas_contratacion.req_can_id", $req_candidato->id)
            ->where("carpetas_contratacion.categoria_id", 1)
            ->select(
                "tipos_documentos.id as id",
                "tipos_documentos.descripcion as descripcion",
                "documentos_carpetas_contratacion.nombre_documento as nombre"
            )
            ->groupBy("documentos_carpetas_contratacion.tipo_documento_id")
            ->get();
        }else{
            $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
            ->where("categoria", 1)
            ->where("tipos_documentos.estado", 1)
            ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
            ->select(
              "tipos_documentos.id as id",
              "tipos_documentos.descripcion as descripcion",
              DB::raw("(select d.created_at from documentos as d where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id order by d.id desc limit 1) as fecha_carga"),
              DB::raw("(select u.name from documentos d left join users u on d.gestiono=u.id where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id order by d.id desc limit 1) as usuario_gestiono")
            )
            ->orderBy("tipos_documentos.id")
            ->groupBy("tipos_documentos.id")
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
                ->latest('id')
            ->get();

            foreach ($tipo_documento as $key => &$tipo_doc) {
                
                //$tipo_doc->documentos = DB::table('documentos')->select('nombre_archivo as nombre', 'id as id_documento', 'fecha_vencimiento as fecha_vencimiento')->where('user_id', $candidato_id)->where('tipo_documento_id', $tipo_doc->id)->latest('id')->limit(5)->get();
                $filter = $docs->filter(function ($value) use ($tipo_doc){

                    return $value->tipo_documento_id==$tipo_doc->id;
                });


                $tipo_doc->documentos= $filter->take(5);
            }

            unset($tipo_doc);

        }

        //Pruebas realizadas
        $pruebas = GestionPrueba::join("users", "users.id", "=", "gestion_pruebas.candidato_id")
        ->leftjoin("tipos_pruebas", "tipos_pruebas.id", "=", "gestion_pruebas.tipo_prueba_id")
        ->where("gestion_pruebas.candidato_id", $candidato_id)
        ->where("gestion_pruebas.activo", "1")
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

        $title_type="de Selección";

        return view('admin.mod_gestion_documental.documentos_seleccion', compact(
            'tipo_documento',
            'candidato_id',
            'req_can',
            'req',
            'datos_candidato',
            'requerimiento',
            'pruebas',
            'req_candidato',
            'title_type',
            'current_user',
            'enlaces_pruebas'
        ));
    }

    public function clientes(Request $data){
        
        $user_sesion = $this->user;

 
        $lista_clientes=Clientes::where(function ($sql) use ($data) { 
            if($data->get("cliente_id")!="" && $data->get("cliente_id")!=null ){
                $sql->where("clientes.id",$data->get("cliente_id"));
            }

            if($data->get("nit")!="" && $data->get("nit")!=null){
                $sql->where("clientes.nit","like",$data->get("nit")."%");
            }
        })
        ->get();
   

        $clientes = ["" => "Seleccionar"] + Clientes::orderBy("clientes.nombre", "ASC")->pluck("clientes.nombre", "clientes.id")->toArray();


        return view("admin.mod_gestion_documental.clientes", compact(
            "user_sesion",
            "clientes",
            "lista_clientes"
        ));
    
    }

    public function gestionarCliente($cliente_id){

        $cliente=Clientes::find($cliente_id);
        $categorias=CategoriaDocumentoCliente::all();
        return view("admin.mod_gestion_documental.gestionar_cliente", compact("categorias","cliente"));
    }

    public function listadoDocumentosClientes($categoria,$cliente){
        $current_user=$this->user;
        $tipo_documento=TipoDocumentoCliente::where("categoria",$categoria)
        ->where("active",1)
        ->select("tipos_documentos_clientes.*",
            DB::raw("(select CONCAT(documentos_clientes.nombre_archivo,'|',created_at) from documentos_clientes where cliente_id=$cliente and documentos_clientes.tipo_documento_id=tipos_documentos_clientes.id order by documentos_clientes.id desc limit 1) as nombre"),
            // DB::raw("(select documentos_clientes.nombre_archivo_real from documentos_clientes where cliente_id=$cliente and documentos_clientes.tipo_documento_id=tipos_documentos_clientes.id order by documentos_clientes.id desc limit 1) as nombre_real"),
            DB::raw("(select d.created_at from documentos_clientes as d where d.cliente_id=$cliente and d.tipo_documento_id=tipos_documentos_clientes.id order by d.id desc limit 1) as fecha_carga"),
            DB::raw("(select u.name from documentos_clientes d left join users u on d.gestiono=u.id where d.cliente_id=$cliente and d.tipo_documento_id=tipos_documentos_clientes.id order by d.id desc limit 1) as usuario_gestiono")
        )
        ->get();


        $cliente=Clientes::find($cliente);
        $categoria=CategoriaDocumentoCliente::find($categoria);

        foreach ($tipo_documento as $key => &$tipo_doc) {
            $tipo_doc->documentos = DB::table('documentos_clientes')->select('nombre_archivo as nombre','nombre_archivo_real as nombre_real', 'id as id_documento')->where('cliente_id', $cliente->id)->where('tipo_documento_id', $tipo_doc->id)->latest('id')->limit(5)->get();
        }
         unset($tipo_doc);

        return view("admin.mod_gestion_documental.listado_documentos_clientes", compact("tipo_documento","current_user","cliente","categoria"));
    }
    public function cargarDocumentoCliente(Request $request){


        $tipo_documento = [""=>"Seleccionar"]+TipoDocumentoCliente::where("categoria",$request->categoria)->where("active",1)->pluck("descripcion","id")->toArray();

        $cliente_id=$request->get("cliente");
        return view("admin.mod_gestion_documental.modal.nuevo_documento_cliente", compact("tipo_documento","cliente_id"));
    }

    public function guardarDocumentoCliente(Request $data){
        $mensaje = "No se cargo ningún documento";
        $success = false;
        $validator = Validator::make($data->all(), [
            'archivo_documento' => 'max:5120',
        ]);

        if($validator->fails()){
           $mensaje = "Peso máximo del documento: 5MB";
            $success = false;
        }

        if($data->hasFile('archivo_documento') && !$validator->fails()){
            $validas   = array("pdf", "png", "docx", "doc", "jpg", "jpeg");
            $tipo_documento = TipoDocumentoCliente::find($data->get("tipo_documento_id"));
            $imagen = $data->file('archivo_documento');
            $extension = strtolower($imagen->getClientOriginalExtension());

            if(in_array($extension,$validas)) {
            
                
                $name_documento = str_replace(" ","_",$tipo_documento->descripcion)."_".date('d-m-Y_G:i:s').".". $extension;
                $documento = new DocumentoCliente();
                $documento->fill([
                    "tipo_documento_id" => $data->get("tipo_documento_id"),
                    "cliente_id" => $data->get("cliente_id"),
                    "nombre_archivo" => $name_documento,
                    "gestiono"=>$this->user->id
                ]);
                $documento->save();
                
                

                Storage::disk('public')->put('documentos_clientes/'.$data->get("cliente_id").'/'.$tipo_documento->tipo_categoria->descripcion."/".$name_documento,\File::get($imagen));

                $documento->nombre_archivo = $name_documento;
                $documento->nombre_archivo_real = $imagen->getClientOriginalName();
                $documento->save();
                
                $mensaje = "Su documento ha sido guardado exitosamente";
                $success = true;

            } else {
                //No se proceso ningún archivo
                $mensaje = "Documento no soportado";
            }
        }
        return response()->json([
            "mensaje" => $mensaje,
            "success" => $success
        ]);
    }

   
   public function reportesValidacionDocumental(Request $request)
    {
        $columnas_datos = [];
        $headersr  = $this->getHeaderValidacionDocumental($request, $columnas_datos);
        $data      = $this->getDataValidacionDocumental($request, $columnas_datos);
        $clientes  = ["" => "Seleccionar"] + Clientes::whereIn("clientes.id", $this->user->clientes_users())->orderBy('nombre')->pluck("clientes.nombre", "clientes.id")->toArray();

        $agencias = ["" =>"-Seleccionar -"]+Agencia::pluck("agencias.descripcion","agencias.id")->toArray();
        
        return view('admin.mod_gestion_documental.reporte_gestion_documental')->with([
            'data'       => $data,
            'headersr'   => $headersr,
            'clientes'   => $clientes,
            'agencias'   => $agencias
        ]);
    }

    public function reportesValidacionDocumentalExcel(Request $request){
;
        $columnas_datos = [];
        $headersr  = $this->getHeaderValidacionDocumental($request, $columnas_datos);
        $data      = $this->getDataValidacionDocumental($request, $columnas_datos);
        $formato = $request->formato;

        if ($data == 'vacio') {
            $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();
            return view('admin.gestion_documental.indicadores')->with([
                'data'       => $data,
                'headersr'   => $headersr,
                'clientes'   => $clientes
            ]);
        }

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-gestion-documental', function ($excel) use ($data, $headersr, $formato) {
            $excel->setTitle('Reporte Gestión Documental');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Gestión Documental');
            $excel->sheet('Reporte Validacion Documental', function ($sheet) use ($data, $headersr, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.mod_gestion_documental.includes._grilla_detalle_reporte_documentos', [
                    'data'    => $data,
                    'headersr' => $headersr,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    
    }

     private function getHeaderValidacionDocumental($request, &$columnas_datos)
    {
        $headersr = [];
        $columnas_datos = TipoDocumento::where('estado', 1)
        ->join("categoria_documentos","categoria_documentos.id","=","tipos_documentos.categoria")
        ->select('tipos_documentos.id', 'tipos_documentos.descripcion',"tipos_documentos.categoria", 'categoria',"categoria_documentos.descripcion as categoria_desc")
        ->orderBy('categoria', 'desc')
        ->get();

        $headersr[] = 'NOMBRES';
        $headersr[] = 'APELLIDOS';
        $headersr[] = 'NRO. IDENTIFICACIÓN';
        $headersr[] = 'NRO REQ';
        $headersr[] = 'CARGO';
        $headersr[] = 'CLIENTE';
        $headersr[] = 'ESTADO';
        foreach ($columnas_datos as $columna) {
            $headersr[] = $columna->descripcion."_".$columna->categoria_desc[0];
        }
        $headersr[] = 'CARNET';
        $headersr[] = 'CARTA PRESENTACIÓN';
        $headersr[] = 'SST';
        $headersr[] = 'POLÍTICA DATOS';
        $headersr[] = 'INFORME_SELECCIÓN';
        $headersr[] = 'HV';
        $headersr[] = 'CARPETA DESCARGADA';
        return $headersr;
    }

    protected function sinClientesPruebas(&$ids_clientes_prueba) {
        $sitio = Sitio::first();
        if ($sitio->filtro_cliente == 'enabled' && $sitio->clientes_prueba_id != null && $sitio->clientes_prueba_id != '') {
            $ids_clientes_prueba = explode(",", $sitio->clientes_prueba_id);
            return true;
        }
        return false;
    }

    private function getDataValidacionDocumental($request, $columnas_datos)
    {
        
        $numero_id = $request['numero_id'];
        $rango_fecha = $request->rango_fecha;
        $fecha_retiro = $request->fecha_retiro;
        $cliente = $request->cliente_id;
        $generar_datos = $request['generar_datos'];
        $auditados = $request->auditados;
        $agencia=$request->agencia;

        $formato      = ($request->has('formato')) ? $request->formato : 'html';

        $data = "vacio";

        if(($numero_id != '' || $rango_fecha != "" || $cliente != "" || $auditados != "" || $fecha_retiro!="" || $agencia!="") && count($columnas_datos) > 0){
            if($rango_fecha != ""){
              $rango = explode(" | ", $rango_fecha);
              $fecha_inicio = $rango[0];
              $fecha_final  = $rango[1];
            }

            if($fecha_retiro != ""){
               
              $rango2 = explode(" | ", $fecha_retiro);
              $fecha_inicio_retiro = $rango2[0];
              $fecha_final_retiro  = $rango2[1];
            }

            $data = DatosBasicos::leftjoin("firma_contratos", "firma_contratos.user_id", "=", "datos_basicos.user_id")
                ->join("requerimientos", "requerimientos.id", "=", "firma_contratos.req_id")
                ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
                ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
                ->leftjoin("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->leftjoin("requerimiento_cantidato", function ($join2) {
                $join2->on("requerimiento_cantidato.requerimiento_id", "=", "requerimientos.id")
                ->on("requerimiento_cantidato.candidato_id", "=", "datos_basicos.user_id");
                 })
                ->leftjoin("ciudad", function ($join) {
                     $join->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                    ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                     ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                })
                ->leftjoin('agencias','agencias.id','=','ciudad.agencia')
                
                ->whereIn("clientes.id", $this->user->clientes_users())
                ->where(function($sql) use ($agencia,$fecha_inicio, $fecha_final,$fecha_inicio_retiro,$fecha_final_retiro, $numero_id, $cliente, $auditados)
                {
                    if ($fecha_inicio != "" && $fecha_final != "") {
                        $sql->whereBetween("firma_contratos.updated_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                    }
                    if ($numero_id != "") {
                        $sql->where("datos_basicos.numero_id", $numero_id);
                    }
                    if ($cliente != "") {
                        $sql->where("clientes.id", $cliente);
                    }

                    if ($auditados != "") {
                        $sql->where("firma_contratos.auditado", $auditados);
                    }

                    if ($fecha_inicio_retiro != "" && $fecha_final_retiro != "") {
                        
                        $sql->whereBetween("requerimiento_cantidato.fecha_terminacion_contrato", [$fecha_inicio_retiro . ' 00:00:00', $fecha_final_retiro . ' 23:59:59']);
                    }

                    if($agencia != ""){
                        $sql->where("agencias.id", $agencia);
                    }
                })
                ->whereRaw('requerimiento_cantidato.id = (select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.requerimiento_id = requerimientos.id and requerimiento_cantidato.candidato_id=datos_basicos.user_id)')
                ->whereNotNull("firma_contratos.terminado")
                ->where("firma_contratos.estado", 1)
                ->where(function ($query) use ($cliente) {
                    if($cliente == '' || $cliente == null) {
                        $ids_clientes_prueba = [];
                        if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                            //$query->whereNotIn("clientes.id", $ids_clientes_prueba);
                        }
                    }
                })
                ->select(
                    "datos_basicos.user_id",
                    "datos_basicos.nombres",
                    "datos_basicos.primer_apellido",
                    "datos_basicos.segundo_apellido",
                    "datos_basicos.numero_id",
                    "datos_basicos.telefono_movil",
                    "requerimientos.id as req",
                    "clientes.nombre as cliente",
                    "cargos_especificos.id as cargo_id",
                    "cargos_especificos.descripcion as cargo",
                    "requerimiento_cantidato.id as req_can",
                    "requerimiento_cantidato.contratado_retirado",
                    DB::raw('(SELECT carpeta_descargada FROM requerimiento_cantidato WHERE requerimiento_cantidato.candidato_id = datos_basicos.user_id and requerimiento_cantidato.requerimiento_id=requerimientos.id limit 1) as carpeta_descargada'),
                    DB::raw('(select GROUP_CONCAT(created_at," ",(select name from users where users.id=auditoria.user_id limit 1) SEPARATOR ",") from auditoria where auditoria.tipo="DESCARGAR" and auditoria.tabla_id=requerimiento_cantidato.id order by created_at DESC) as descargas')
                )
                ->orderBy("firma_contratos.updated_at", "desc");
                //->groupBy("firma_contratos.req_id");
        } else if (count($columnas_datos) === 0 && isset($generar_datos) && ($numero_id != '' || $fecha_inicio != "" && $fecha_final != "")) {
            session()->flash('mensaje_warning', 'El cargo de este requerimiento no tiene documentos asociados.');
        } else if (isset($generar_datos)) {
            session()->flash('mensaje_warning', 'Debe ingresar algún filtro');
        }

        if($data != "vacio"){
            //dd(array_pluck($data->get()->unique('cargo_id'), 'cargo_id'));
            if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
                $data = $data->get();
            }else{
                $data = $data->paginate(6);
            }

            $tipos_doc_ids = array_pluck($columnas_datos, 'id');
            foreach ($data as &$candidato) {
                $cant_doc_cargados = 0;
                $doc_candidato = Documentos::where('user_id', $candidato->user_id)
                    ->whereIn('tipo_documento_id', $tipos_doc_ids)
                    ->select("nombre_archivo", "tipo_documento_id", "descripcion_archivo","requerimiento")
                    ->orderBy('created_at', 'desc')
                    ->get();
                $candidato["documentos"] = collect([]);
                $candidato["porcentaje"] = 0;
                foreach ($columnas_datos as $tipo_doc) {
                    if($tipo_doc->id==16){
                        $dc=$doc_candidato->where('tipo_documento_id', $tipo_doc->id)->where("requerimiento",$candidato->req)->take(3);
                    }
                    else if($tipo_doc->id==8){
                         $dc=$doc_candidato->where('tipo_documento_id', $tipo_doc->id)->where("requerimiento",$candidato->req)->take(1);
                    }
                    else{
                        $dc=$doc_candidato->where('tipo_documento_id', $tipo_doc->id)->take(3);
                    }
                    $documentos = [
                        'id' => $tipo_doc->id,
                        'descripcion' => $tipo_doc->descripcion,
                        'documentos' => $dc
                    ];
                    $candidato["documentos"]->push($documentos);
                    if (count($documentos['documentos']) > 0) {
                        $cant_doc_cargados++;
                    }
                }
                /*if($cant_doc_cargados == $total_documentos) {
                    $candidato["porcentaje"] = 100;
                } else {
                    if ($total_documentos > 0) {
                        $candidato["porcentaje"] = round($cant_doc_cargados * 100 / $total_documentos, 2);
                    }
                }*/
                //AGREGAR DOCUMENTOS SUELTOS
                
                if (file_exists('documentos_candidatos/'.$candidato->numero_id.'/'.$candidato->req.'/contratacion/CARNET_CONTRATADO.pdf')) {
                    $candidato["carnet"]=asset('documentos_candidatos/'.$candidato->numero_id.'/'.$candidato->req.'/contratacion/CARNET_CONTRATADO.pdf');

                }

                if (file_exists('recursos_carta_presentacion/carta_presentacion_'.$candidato->req.'_'.$candidato->user_id.'.pdf')) {
                    $candidato["carta"]=asset('recursos_carta_presentacion/carta_presentacion_'.$candidato->req.'_'.$candidato->user_id.'.pdf');

                }

                if (file_exists('recursos_evaluacion_sst/evaluacion_sst_'.$candidato->user_id.'_'.$candidato->req.'.pdf')) {

                    $candidato["sst"]=asset('recursos_evaluacion_sst/evaluacion_sst_'.$candidato->user_id.'_'.$candidato->req.'.pdf');
                }

                if (file_exists('recursos_evaluacion_sst/evaluacion_sst_'.$candidato->user_id.'_'.$candidato->req.'.pdf')) {

                    $candidato["sst"]=asset('recursos_evaluacion_sst/evaluacion_sst_'.$candidato->user_id.'_'.$candidato->req.'.pdf');
                }
            }
            unset($candidato);
        }


        return $data;
    }

    /*
    *   Lista de documentos de contratación
    */
    public function downloadCarpeta(Request $request,$folder="all"){


        $req_can_array=$request->req_can;


        $folders=["1"=>"seleccion","2"=>"contratacion","3"=>"confidenciales","4"=>"post-contratacion"];
        
        $zip = new ZipArchive();
        
    foreach($req_can_array as $req_can){


        

  
        $req_candidato = ReqCandidato::join("datos_basicos","datos_basicos.user_id","=","requerimiento_cantidato.candidato_id")
            ->select("requerimiento_cantidato.*","datos_basicos.numero_id")
            ->find($req_can);
        $requerimiento=Requerimiento::find($req_candidato->requerimiento_id);



        if($folder!="all"){

            $nombre_carpeta=$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'_'.$folders[$folder];
        }
        else{
            if(count($req_can_array)>1){
                $nombre_carpeta="Documentos candidatos";
            }
            else{
                $nombre_carpeta=$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id;
            }
            
        }

        
        $zip->open($nombre_carpeta.".zip",ZipArchive::CREATE);

        if($folder=="all"){
            if(count($req_can_array)>1){
                $sub_folder=$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id;
                $zip->addEmptyDir($sub_folder);
            }
            else{
                $sub_folder="documentos";
                $zip->addEmptyDir($sub_folder);
            }
           
        }
        
            

            foreach($folders as $clave=>$valor){

                
                switch ($clave) {
                    case '1':
                            if($folder!="all"){
                                
                                if($folder!=$clave){
                                     $sub_folder=$folders[$folder];
                                    //$sub_folder=$valor;
                                    break;
                                }

                            }
                          
                           
                            if($folder!="all"){
                                $zip->addEmptyDir($sub_folder);
                            }
                            
                            

                            if($req_candidato->bloqueo_carpeta){
                                $tipo_documento = DocumentoCarpetaContratacion::join("carpetas_contratacion", "carpetas_contratacion.id", "=", "documentos_carpetas_contratacion.carpeta_id")
                                ->join("tipos_documentos", "tipos_documentos.id", "=", "documentos_carpetas_contratacion.tipo_documento_id")
                                ->where("carpetas_contratacion.req_can_id", $req_candidato->id)
                                ->where("carpetas_contratacion.categoria_id", 1)
                                ->select(
                                    "tipos_documentos.id as id",
                                    "tipos_documentos.descripcion as descripcion",
                                    "documentos_carpetas_contratacion.nombre_documento as nombre"
                                )
                                //->groupBy("documentos_carpetas_contratacion.tipo_documento_id")
                                ->get();
                            }else{
                                $candidato = $req_candidato->candidato_id;
                                $requerimiento = Requerimiento::join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
                                ->where("requerimientos.id", $req_candidato->requerimiento_id)
                                ->select( "requerimientos.*", "tipo_proceso.descripcion as tipo_proceso" )
                                ->first();
                                $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
                                ->where("categoria", 1)
                                ->where("tipos_documentos.estado", 1)
                                ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
                                ->select(
                                  "tipos_documentos.id as id",
                                  "tipos_documentos.descripcion as descripcion",
                                  DB::raw("(select d.created_at from documentos as d where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id order by d.id desc limit 1) as fecha_carga"),
                                  DB::raw("(select u.name from documentos d left join users u on d.gestiono=u.id where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id order by d.id desc limit 1) as usuario_gestiono")
                                )
                                ->orderBy("tipos_documentos.id")
                                ->groupBy("tipos_documentos.id")
                                ->get();

                                foreach ($tipo_documento as $key => &$tipo_doc) {
                                    $tipo_doc->documentos = DB::table('documentos')->select('nombre_archivo as nombre', 'id as id_documento',DB::raw('DATE_FORMAT(created_at, \'%Y-%m-%d\') as fecha_carga'))->where('user_id', $candidato)->where('tipo_documento_id', $tipo_doc->id)->latest('id')->limit(5)->get();
                                }
                                unset($tipo_doc);
                                
                                
                            
                            }

                            //agregar documentos al zip

                            foreach($tipo_documento as $tipo){
                                $cantidad=count($tipo->documentos);
                                $iter=0;
                                if($cantidad>0){
                                    if($cantidad>1){
                                        $iter=1;
                                    }

                                    foreach($tipo->documentos as $doc){

                                        if(!$iter){

                                            if(!is_null($doc->nombre) && file_exists(public_path('recursos_documentos/'.$doc->nombre))){
                                            $name_extention = explode(".",$doc->nombre);

                                            $zip->addFile(public_path('recursos_documentos/'.$doc->nombre),$sub_folder.'/'.$tipo->descripcion."_".$req_candidato->numero_id."_".$req_candidato->requerimiento_id."_".$doc->fecha_carga.".".$name_extention[1]);
                                            }

                                        }
                                        else{
                                            if(!is_null($doc->nombre) && file_exists(public_path('recursos_documentos/'.$doc->nombre))){
                                            $name_extention = explode(".",$doc->nombre);

                                            $zip->addFile(public_path('recursos_documentos/'.$doc->nombre),$sub_folder.'/'.$tipo->descripcion."_".$req_candidato->numero_id."_".$req_candidato->requerimiento_id."_".$doc->fecha_carga."_$iter".".".$name_extention[1]);
                                        }
                                        $iter++;
                                    }
                                    
                                        
                                    }
                                }
                                else{
                                    if(!is_null($tipo->nombre) && file_exists(public_path('recursos_documentos/'.$tipo->nombre))){
                                        $name_extention = explode(".",$tipo->nombre);
                                        $zip->addFile(public_path('recursos_documentos/'.$tipo->nombre),$sub_folder.'/'.$tipo->descripcion."_".$req_candidato->numero_id."_".$req_candidato->requerimiento_id.".".$name_extention[1]);
                                    }
                                
                                }
                                $iter=0;
                            }

                            //INFORME SELECCIÓN
                            if (file_exists('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/informe_seleccion.pdf')) {
                                
                                 $zip->addFile(public_path('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/informe_seleccion.pdf'),$sub_folder.'/INFORME_SELECCION_'.date('Y-m-d',Storage::disk('public')->lastModified('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/informe_seleccion.pdf')).'.pdf');
                            }
                            //HV
                            if (file_exists('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/hv.pdf')) {
                                
                                 $zip->addFile(public_path('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/hv.pdf'),$sub_folder.'/HV_'.date('Y-m-d',Storage::disk('public')->lastModified('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/hv.pdf')).'.pdf');
                            }

                            //ACEPTACION POLITICAS

                            if (file_exists('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/aceptacion_politicas_datos.pdf')) {
                                
                                 $zip->addFile(public_path('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/aceptacion_politicas_datos.pdf'),$sub_folder.'/ACEPTACION_POLITICAS_DATOS_'.date('Y-m-d',Storage::disk('public')->lastModified('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/aceptacion_politicas_datos.pdf')).'.pdf');
                            }

                            //PRUEBAS EXTERNAS

                           $pruebas_externas = GestionPrueba::join("users", "users.id", "=", "gestion_pruebas.candidato_id")
                            ->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "gestion_pruebas.id")
                            ->leftjoin("tipos_pruebas", "tipos_pruebas.id", "=", "gestion_pruebas.tipo_prueba_id")
                            ->where("gestion_pruebas.candidato_id", $req_candidato->candidato_id)
                            ->where("gestion_pruebas.activo", "1")
                            ->where("proceso_requerimiento.tipo_entidad", "MODULO_PRUEBAS")
                            ->where("proceso_requerimiento.requerimiento_id", $req_candidato->requerimiento_id)
                            ->select(
                                "gestion_pruebas.*",
                                "tipos_pruebas.descripcion as prueba_desc",
                                "users.name"
                            )
                            ->get();

                            foreach ($pruebas_externas as $prueba){
                                if (file_exists("recursos_pruebas/".$prueba->nombre_archivo)) {
                                    $zip->addFile(public_path("recursos_pruebas/".$prueba->nombre_archivo),$sub_folder.'/'.$prueba->nombre_archivo);
                                }
                                
                            }

                            //PRUEBAS INTERNAS

                            //ETHICAL
                            if(file_exists('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_valores_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf')){

                                $zip->addFile(public_path('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_valores_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf'),$sub_folder.'/prueba_valores_'.date('Y-m-d',Storage::disk('public')->lastModified('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_valores_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf')).'.pdf');

                            }
                            //COMPETENCIAS
                            if(file_exists('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_competencias_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf')){

                                $zip->addFile(public_path('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_competencias_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf'),$sub_folder.'/prueba_competencias_'.date('Y-m-d',Storage::disk('public')->lastModified('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_competencias_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf')).'.pdf');

                            }

                            //EXCEL

                            if(file_exists('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_excel_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf')){

                                $zip->addFile(public_path('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_excel_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf'),$sub_folder.'/prueba_excel_'.date('Y-m-d',Storage::disk('public')->lastModified('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_excel_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf')).'.pdf');

                            }
                            if(file_exists('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_excel_intermedio_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf')){

                                $zip->addFile(public_path('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_excel_intermedio_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf'),$sub_folder.'/prueba_excel_intermedio_'.date('Y-m-d',Storage::disk('public')->lastModified('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_excel_intermedio_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf')).'.pdf');

                            }
                            //DIGITACIÓN
                            if(file_exists('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_digitacion_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf')){

                                $zip->addFile(public_path('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_digitacion_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf'),$sub_folder.'/prueba_digitacion_'.date('Y-m-d',Storage::disk('public')->lastModified('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_digitacion_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf')).'.pdf');

                            }
                             //BRYG
                            if(file_exists('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_bryg_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf')){

                                $zip->addFile(public_path('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_bryg_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf'),$sub_folder.'/prueba_bryg_'.date('Y-m-d',Storage::disk('public')->lastModified('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/seleccion/prueba_bryg_'.$req_candidato->numero_id.'_'.$req_candidato->requerimiento_id.'.pdf')).'.pdf');

                            }   
                            
    

                         
                           

                        break;
                    case '2':

                             if($folder!="all"){
                                if($folder!=$clave){
                                    $sub_folder=$folders[$folder];
                                    break;
                                }

                            }
                          
                            if($folder!="all"){
                                $zip->addEmptyDir($sub_folder);
                            }
                            

                            if($req_candidato->bloqueo_carpeta_contratacion){
                                $tipo_documento = DocumentoCarpetaContratacion::join("carpetas_contratacion", "carpetas_contratacion.id", "=", "documentos_carpetas_contratacion.carpeta_id")
                                ->join("tipos_documentos", "tipos_documentos.id", "=", "documentos_carpetas_contratacion.tipo_documento_id")
                                ->where("carpetas_contratacion.req_can_id", $req_candidato->id)
                                ->where("carpetas_contratacion.categoria_id", 2)
                                ->select(
                                    "tipos_documentos.id as id",
                                    "tipos_documentos.descripcion as descripcion",
                                    "documentos_carpetas_contratacion.nombre_documento as nombre"
                                )
                                //->groupBy("documentos_carpetas_contratacion.tipo_documento_id")
                                ->get();
                            }
                            else{
                                $candidato = $req_candidato->candidato_id;
                                $requerimiento = Requerimiento::join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
                                ->where("requerimientos.id", $req_candidato->requerimiento_id)
                                ->select( "requerimientos.*", "tipo_proceso.descripcion as tipo_proceso" )
                                ->first();

                                $datos_candidato = DatosBasicos::where('user_id', $candidato_id)->first();

                                $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
                                    ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
                                    ->where("categoria", 2)
                                    ->where("tipos_documentos.estado", 1)
                                    ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
                                    ->select(
                                      "tipos_documentos.id as id",
                                      "tipos_documentos.descripcion as descripcion",
                                      DB::raw("(select documentos.gestiono from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req_candidato->requerimiento_id order by documentos.id desc limit 1) as gestiono"),
                                      DB::raw("(select d.created_at from documentos as d where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req_candidato->requerimiento_id order by d.id desc limit 1) as fecha_carga"),
                                      DB::raw("(select u.name from documentos d left join users u on d.gestiono=u.id where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req_candidato->requerimiento_id order by d.id desc limit 1) as usuario_gestiono")
                                    )
                                    ->orderBy("id")
                                    ->groupBy("id")
                                ->get();

                                foreach ($tipo_documento as $key => &$tipo_doc) {
                                    $tipo_doc->documentos = DB::table('documentos')->select('nombre_archivo as nombre', 'id as id_documento',DB::raw('DATE_FORMAT(created_at, \'%Y-%m-%d\') as fecha_carga'))->where('user_id', $candidato)->where('tipo_documento_id', $tipo_doc->id)->where('requerimiento', $req_candidato->requerimiento_id)->latest('id')->limit(5)->get();
                                }
                                unset($tipo_doc);
                            }
                            
                            //agregar archivos al zip

                            foreach($tipo_documento as $tipo){
                                if(!$req_candidato->bloqueo_carpeta_contratacion){
                                    $cantidad=count($tipo->documentos);
                                    $iter=0;
                                
                                    if($cantidad>0){
                                        if($cantidad>1){
                                            $iter=1;
                                        }

                                        foreach($tipo->documentos as $doc){
                                            if(!$iter){
                                                if(!is_null($doc->nombre) && file_exists(public_path('recursos_documentos_verificados/'.$doc->nombre))){
                                                $name_extention = explode(".",$doc->nombre);
                                                $zip->addFile(public_path('recursos_documentos_verificados/'.$doc->nombre),$sub_folder.'/'.$tipo->descripcion."_".$req_candidato->numero_id."_".$req_candidato->requerimiento_id."_".$doc->fecha_carga.".".$name_extention[1]);
                                                }
                                            }
                                            else{
                                                if(!is_null($doc->nombre) && file_exists(public_path('recursos_documentos_verificados/'.$doc->nombre))){
                                                $name_extention = explode(".",$doc->nombre);
                                                $zip->addFile(public_path('recursos_documentos_verificados/'.$doc->nombre),$sub_folder.'/'.$tipo->descripcion."_".$req_candidato->numero_id."_".$req_candidato->requerimiento_id."_".$doc->fecha_carga."_$iter".".".$name_extention[1]);
                                                }
                                                $iter++;
                                            }
                                            
                                        }
                                    }
                                }
                                else{
                                    if(!is_null($tipo->nombre) && file_exists(public_path('recursos_documentos_verificados/'.$tipo->nombre))){
                                        $name_extention = explode(".",$tipo->nombre);
                                        $zip->addFile(public_path('recursos_documentos_verificados/'.$tipo->nombre),$sub_folder.'/'.$tipo->descripcion."_".$req_candidato->numero_id."_".$req_candidato->requerimiento_id.".".$name_extention[1]);
                                    }
                                }
                                $iter=0;
                            }
                            //Contrato

                            $firmaContrato = FirmaContratos::where('user_id', $req_candidato->candidato_id)
                                ->where('req_id', $req_candidato->requerimiento_id)
                                ->where('estado', 1)
                                ->orderBy('created_at', 'DESC')
                                ->first();

                           
                            if($firmaContrato!=null){

                                $zip->addFile(public_path('contratos/'.$firmaContrato->contrato),$sub_folder.'/CONTRATO_'.date('Y-m-d',Storage::disk('public')->lastModified('contratos/'.$firmaContrato->contrato)).'.pdf');

                                //Videos contrato
                                $getVideoQuestion = ConfirmacionPreguntaContrato::join('preguntas_contrato', 'preguntas_contrato.id', '=', 'confirmacion_preguntas_contrato.pregunta_id')
                                ->join('firma_contratos', 'firma_contratos.id', '=', 'confirmacion_preguntas_contrato.contrato_id')
                                ->where('confirmacion_preguntas_contrato.user_id', $req_candidato->candidato_id)
                                ->where('confirmacion_preguntas_contrato.req_id', $req_candidato->requerimiento_id)
                                ->where('confirmacion_preguntas_contrato.estado',1)
                                ->where('firma_contratos.estado', 1)
                                ->select('confirmacion_preguntas_contrato.*', 'preguntas_contrato.archivo as desc_pregunta')
                                ->get();

                                if(count($getVideoQuestion)>0){
                                    $cont=1;
                                    foreach ($getVideoQuestion as $question) {
                                        $zip->addFile(public_path('video_contratos/'.$question->video),$sub_folder.'/PREGUNTA_CONTRATO_'.$cont.'_'.date('Y-m-d',Storage::disk('public')->lastModified('video_contratos/'.$question->video)).'.webm');

                                        $cont++;
                                    }
                                }


                            }

                             //SST
                            if (file_exists('recursos_evaluacion_sst/evaluacion_sst_'.$req_candidato->candidato_id.'_'.$req_candidato->requerimiento_id.'.pdf')) {
                                
                                 $zip->addFile(public_path('recursos_evaluacion_sst/evaluacion_sst_'.$req_candidato->candidato_id.'_'.$req_candidato->requerimiento_id.'.pdf'),$sub_folder.'/EVALUACION_SST_'.date('Y-m-d',Storage::disk('public')->lastModified('recursos_evaluacion_sst/evaluacion_sst_'.$req_candidato->candidato_id.'_'.$req_candidato->requerimiento_id.'.pdf')).'.pdf');
                            }
                            //CARNET

                            if (file_exists('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/contratacion/CARNET_CONTRATADO.pdf')) {
                                
                                 $zip->addFile(public_path('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/contratacion/CARNET_CONTRATADO.pdf'),$sub_folder.'/CARNET_CONTRATADO_'.date('Y-m-d',Storage::disk('public')->lastModified('documentos_candidatos/'.$req_candidato->numero_id.'/'.$req_candidato->requerimiento_id.'/contratacion/CARNET_CONTRATADO.pdf')).'.pdf');
                            }

                            //CARTA PRESENTACIÖN
                            if (file_exists('recursos_carta_presentacion/carta_presentacion_'.$req_candidato->requerimiento_id.'_'.$req_candidato->candidato_id.'.pdf')) {
                                
                                 $zip->addFile(public_path('recursos_carta_presentacion/carta_presentacion_'.$req_candidato->requerimiento_id.'_'.$req_candidato->candidato_id.'.pdf'),$sub_folder.'/CARTA_PRESENTACION_'.date('Y-m-d',Storage::disk('public')->lastModified('recursos_carta_presentacion/carta_presentacion_'.$req_candidato->requerimiento_id.'_'.$req_candidato->candidato_id.'.pdf')).'.pdf');
                            }
                            
                            

                            

                       
                        break;
                     case '3':

                            if($folder!="all"){
                                if($folder!=$clave){
                                     $sub_folder=$folders[$folder];
                                    //$sub_folder=$valor;
                                    break;
                                }

                            }
                          
                            if($folder!="all"){
                                $zip->addEmptyDir($sub_folder);
                            }

                            $candidato_id = $req_candidato->candidato_id;
                            $requerimiento = Requerimiento::join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
                                ->where("requerimientos.id", $req_candidato->requerimiento_id)
                                ->select( "requerimientos.*", "tipo_proceso.descripcion as tipo_proceso" )
                                ->first();


                            $tipo_documento = TipoDocumento::leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
                            ->where("categoria", 3)
                            ->where("tipos_documentos.estado", 1)
                            ->select(
                              "tipos_documentos.id as id",
                              "tipos_documentos.descripcion as descripcion",
                              DB::raw("(select documentos.nombre_archivo from documentos where user_id=$candidato_id and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req_candidato->requerimiento_id order by documentos.id desc limit 1) as nombre"),
                              DB::raw("(select documentos.gestiono from documentos where user_id=$candidato_id and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req_candidato->requerimiento_id order by documentos.id desc limit 1) as gestiono"),
                              DB::raw("(select DATE_FORMAT(d.created_at,'%Y-%m-%d') from documentos as d where d.user_id=$candidato_id and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req_candidato->requerimiento_id order by d.id desc limit 1) as fecha_carga"),
                              DB::raw("(select u.name from documentos d left join users u on d.gestiono=u.id where d.user_id=$candidato_id and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req_candidato->requerimiento_id order by d.id desc limit 1) as usuario_gestiono")
                            )
                            ->orderBy("id")
                            ->groupBy("id")
                            ->get();

                             foreach($tipo_documento as $tipo){
                                    
                                    if(!is_null($tipo->nombre)){
                                        $name_extention = explode(".",$tipo->nombre);
                                        $zip->addFile(public_path('recursos_documentos_verificados/'.$tipo->nombre),$sub_folder.'/'.$tipo->descripcion."_".$req_candidato->numero_id."_".$req_candidato->requerimiento_id."_".$tipo->fecha_carga.".".$name_extention[1]);
                                    }
                                
                            }

                            
                        
                        break;
                    case '4':
                            if($folder!="all"){
                                if($folder!=$clave){
                                    $sub_folder=$valor;
                                    break;
                                }

                            }
                          
                            if($folder!="all"){
                                $zip->addEmptyDir($sub_folder);
                            }

                            if($req_candidato->bloqueo_carpeta_post){
                                $tipo_documento = DocumentoCarpetaContratacion::join("carpetas_contratacion", "carpetas_contratacion.id", "=", "documentos_carpetas_contratacion.carpeta_id")
                                ->join("tipos_documentos", "tipos_documentos.id", "=", "documentos_carpetas_contratacion.tipo_documento_id")
                                ->where("carpetas_contratacion.req_can_id", $req_candidato->id)
                                ->where("carpetas_contratacion.categoria_id", 4)
                                ->select(
                                    "tipos_documentos.id as id",
                                    "tipos_documentos.descripcion as descripcion",
                                    "documentos_carpetas_contratacion.nombre_documento as nombre"
                                )
                                //->groupBy("documentos_carpetas_contratacion.tipo_documento_id")
                                ->get();
                            }
                            else{
                                $candidato = $req_candidato->candidato_id;
                                $requerimiento = Requerimiento::join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
                                ->where("requerimientos.id", $req_candidato->requerimiento_id)
                                ->select( "requerimientos.*", "tipo_proceso.descripcion as tipo_proceso" )
                                ->first();

                                $datos_candidato = DatosBasicos::where('user_id', $candidato_id)->first();

                                $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
                                    ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
                                    ->where("categoria", 4)
                                    ->where("tipos_documentos.estado", 1)
                                    ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
                                    ->select(
                                      "tipos_documentos.id as id",
                                      "tipos_documentos.descripcion as descripcion",
                                      DB::raw("(select documentos.gestiono from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req_candidato->requerimiento_id order by documentos.id desc limit 1) as gestiono"),
                                      DB::raw("(select d.created_at from documentos as d where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req_candidato->requerimiento_id order by d.id desc limit 1) as fecha_carga"),
                                      DB::raw("(select u.name from documentos d left join users u on d.gestiono=u.id where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req_candidato->requerimiento_id order by d.id desc limit 1) as usuario_gestiono")
                                    )
                                    ->orderBy("id")
                                    ->groupBy("id")
                                ->get();

                                foreach ($tipo_documento as $key => &$tipo_doc) {
                                    $tipo_doc->documentos = DB::table('documentos')->select('nombre_archivo as nombre', 'id as id_documento',DB::raw('DATE_FORMAT(created_at, \'%Y-%m-%d\') as fecha_carga'))->where('user_id', $candidato)->where('tipo_documento_id', $tipo_doc->id)->where('requerimiento', $req_candidato->requerimiento_id)->latest('id')->limit(5)->get();
                                }
                                unset($tipo_doc);
                            }

                            //agregar archivos al zip

                            foreach($tipo_documento as $tipo){
                                $cantidad=count($tipo->documentos);
                                $iter=0;
                                        
                                if($cantidad>0){
                                    if($cantidad>1){
                                        $iter=1;
                                    }
                                    foreach($tipo->documentos as $doc){
                                        if(!$iter){
                                            if(!is_null($doc->nombre) && file_exists(public_path('recursos_documentos_verificados/'.$doc->nombre))){
                                            $name_extention = explode(".",$doc->nombre);
                                            $zip->addFile(public_path('recursos_documentos_verificados/'.$doc->nombre),$sub_folder.'/'.$tipo->descripcion."_".$req_candidato->numero_id."_".$req_candidato->requerimiento_id."_".$doc->fecha_carga.".".$name_extention[1]);
                                            }
                                        }
                                        else{
                                            if(!is_null($doc->nombre) && file_exists(public_path('recursos_documentos_verificados/'.$doc->nombre))){
                                            $name_extention = explode(".",$doc->nombre);
                                            $zip->addFile(public_path('recursos_documentos_verificados/'.$doc->nombre),$sub_folder.'/'.$tipo->descripcion."_".$req_candidato->numero_id."_".$req_candidato->requerimiento_id."_".$doc->fecha_carga.'_$iter'.".".$name_extention[1]);
                                            }
                                            $iter++;
                                        }
                                        
                                    }
                                }
                                else{
                                    if(!is_null($tipo->nombre) && file_exists(public_path('recursos_documentos_verificados/'.$tipo->nombre))){
                                    $name_extention = explode(".",$tipo->nombre);
                                    $zip->addFile(public_path('recursos_documentos_verificados/'.$tipo->nombre),$sub_folder.'/'.$tipo->descripcion."_".$req_candidato->numero_id."_".$req_candidato->requerimiento_id.".".$name_extention[1]);
                                    }
                                }
                                
                            }
                       
                        break;  
                    default:
                        # code...
                        break;
                }
            }
        
      
        
            //Auditoria

            $auditoria = new Auditoria();
            $auditoria->observaciones = "Descarga Carpeta Contrato";
            
            $auditoria->user_id       = $this->user->id;
            $auditoria->tabla         = "requerimiento_cantidato";
            $auditoria->tabla_id      = $req_candidato->id;
            $auditoria->tipo          = "DESCARGAR";

            event(new \App\Events\AuditoriaEvent($auditoria));

            $req_candidato->carpeta_descargada=1;
            $req_candidato->save();

        

    }

        $zip->close();// cerrar el archivo zip
        header("Content-type: application/octet-stream");
        header("Content-disposition: attachment; filename=$nombre_carpeta.zip");
        readfile($nombre_carpeta.".zip"); // leemos el archivo creado
        unlink($nombre_carpeta.".zip");//Destruye el archivo temporal


        
    }
    public function documentos_contratacion($candidato, $req)
    {
        $candidato_id = $candidato;
        $current_user=$this->user;
        $requerimiento = Requerimiento::join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->where("requerimientos.id", $req)
        ->select( "requerimientos.*", "tipo_proceso.descripcion as tipo_proceso" )
        ->first();

        $datos_candidato = DatosBasicos::where('user_id', $candidato_id)->first();

        $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
            ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
            ->where("categoria", 2)
            ->where("tipos_documentos.estado", 1)
            ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
            ->select(
              "tipos_documentos.id as id",
              "tipos_documentos.descripcion as descripcion",
              DB::raw("(select documentos.gestiono from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id desc limit 1) as gestiono"),
              DB::raw("(select d.created_at from documentos as d where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req order by d.id desc limit 1) as fecha_carga"),
              DB::raw("(select u.name from documentos d left join users u on d.gestiono=u.id where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req order by d.id desc limit 1) as usuario_gestiono")
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
            ->where('requerimiento', $req)
            ->where("active",1)
            ->latest('id')
        ->get();

        foreach ($tipo_documento as $key => &$tipo_doc) {
            //$tipo_doc->documentos = DB::table('documentos')->select('nombre_archivo as nombre', 'id as id_documento', 'fecha_vencimiento as fecha_vencimiento')->where('user_id', $candidato_id)->where('tipo_documento_id', $tipo_doc->id)->latest('id')->limit(5)->get();
            $tipo_doc->documentos = $docs->filter(function ($value) use ($tipo_doc){
                return $value->tipo_documento_id==$tipo_doc->id;
              
            });

            $tipo_doc->documentos= $tipo_doc->documentos->take(5);

        }

        unset($tipo_doc);

        //dd($tipo_documento);

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
        ->where('confirmacion_preguntas_contrato.estado',1)
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

        $title_type="de Contratación";

        return view('admin.mod_gestion_documental.documentos_contratacion',compact(

            "tipo_documento",
            "candidato_id",
            "req",
            "configuracion_sst",
            "firmaContrato",
            "getVideoQuestion",
            "requerimiento",
            "datos_candidato",
            "anuladoContrato",
            "req_cand",
            "clausulasContrato",
            "contrato_manual",
            "title_type",
            "current_user"

        ));
    }

    /*
    *   Lista de documentos confidenciales
    */
    public function documentos_confidenciales($candidato, $req)
    {

        $datos_candidato = DatosBasicos::where('user_id', $candidato)->first();
        $current_user=$this->user;

        $candidato_id = $candidato;

        $tipo_documento = TipoDocumento::leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
        ->where("categoria", 3)
        ->where("tipos_documentos.estado", 1)
        ->select(
          "tipos_documentos.id as id",
          "tipos_documentos.descripcion as descripcion",
          DB::raw("(select documentos.nombre_archivo from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id desc limit 1) as nombre"),
          DB::raw("(select documentos.nombre_archivo_real from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id desc limit 1) as nombre_real"),
          DB::raw("(select documentos.gestiono from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id desc limit 1) as gestiono"),
          DB::raw("(select d.created_at from documentos as d where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req order by d.id desc limit 1) as fecha_carga"),
          DB::raw("(select u.name from documentos d left join users u on d.gestiono=u.id where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req order by d.id desc limit 1) as usuario_gestiono")
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
            ->where('requerimiento', $req)
            ->where("active",1)
            ->latest('id')
        ->get();

        foreach ($tipo_documento as $key => &$tipo_doc) {
            $tipo_doc->documentos = $docs->filter(function ($value)use ($tipo_doc){
                return $value->tipo_documento_id==$tipo_doc->id;
               
            });

            $tipo_doc->documentos= $tipo_doc->documentos->take(5);
        }
        unset($tipo_doc);

        $check = $tipo_documento->filter(function ($value) {
            return $value->nombre != "";
        })->count();
        
        if($tipo_documento->count() != 0){
            $porcentaje = round($check*100/$tipo_documento->count(), 2);
        }else{
            $porcentaje = 0;
        }

        $getChecked = TruoraKey::where('cand_id', $candidato)
        ->where('req_id', $req)
        ->first();

        $requerimiento = Requerimiento::join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->where("requerimientos.id", $req)
        ->select(
            "requerimientos.*",
            "tipo_proceso.descripcion as tipo_proceso"
        )
        ->first();
        
        //Consulta seguridad
        $consultaSeguridad = ConsultaSeguridad::where('user_id', $candidato_id)->orderBy('updated_at', 'DESC')->first();

        //Tusdatos
        $tusdatosData = FuncionesGlobales::getTusDatos($req, $candidato_id);

        $title_type="Confidenciales";


        return view('admin.mod_gestion_documental.documentos_confidenciales', compact(
            "tipo_documento",
            //"tipo_documento_aparte",
            "getChecked",
            "datos_candidato",
            "requerimiento",
            "candidato_id",
            "req",
            "consultaSeguridad",
            "tusdatosData",
            "title_type",
            "current_user"

        ));
    }

    public function documentos_post($candidato, $req)
    {
        $candidato_id = $candidato;
        $current_user=$this->user;

        $requerimiento = Requerimiento::join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->where("requerimientos.id", $req)
        ->select( "requerimientos.*", "tipo_proceso.descripcion as tipo_proceso")
        ->first();
        

        $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
            ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
            ->where("categoria", 4)
            ->where("tipos_documentos.estado", 1)
            ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
            ->select(
              "tipos_documentos.id as id",
              "tipos_documentos.descripcion as descripcion",
              DB::raw("(select documentos.gestiono from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id desc limit 1) as gestiono"),
              DB::raw("(select d.created_at from documentos as d where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req order by d.id desc limit 1) as fecha_carga"),
              DB::raw("(select u.name from documentos d left join users u on d.gestiono=u.id where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req order by d.id desc limit 1) as usuario_gestiono")
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
            ->where('requerimiento', $req)
            ->where("active",1)
            ->latest('id')
        ->get();

        foreach ($tipo_documento as $key => &$tipo_doc) {
            //$tipo_doc->documentos = DB::table('documentos')->select('nombre_archivo as nombre', 'id as id_documento', 'fecha_vencimiento as fecha_vencimiento')->where('user_id', $candidato_id)->where('tipo_documento_id', $tipo_doc->id)->latest('id')->limit(5)->get();
            $tipo_doc->documentos = $docs->filter(function ($value)use ($tipo_doc){
                return $value->tipo_documento_id==$tipo_doc->id;
               
            });

            $tipo_doc->documentos= $tipo_doc->documentos->take(5);

        }

        unset($tipo_doc);

        $check = $tipo_documento->filter(function ($value) {
            return $value->nombre != "";
        })->count();
        
        if($tipo_documento->count() != 0){
            $porcentaje = round($check*100/$tipo_documento->count(), 2);
        }
        else{
            $porcentaje = 0;
        }
        /*$getChecked = TruoraKey::where('cand_id', $candidato)
        ->where('req_id', $req)
        ->first();*/
        $datos_candidato = DatosBasicos::where('user_id', $candidato)->first();

         $title_type="de Post-Contratación";
        
        return view('admin.mod_gestion_documental.documentos_post', compact(

            "tipo_documento",
            "getChecked",
            "datos_candidato",
            "requerimiento",
            "candidato_id",
            "req",
            "title_type",
            "current_user"

        ));
    }

    

    public function cargar_documento_admin_seleccion(Request $request)
    {
        $requerimiento = Requerimiento::find($request->get("req_id"));

        $tipo_documento = ["" => "Seleccionar"] + TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("users", "users.id", "=", "documentos.user_id")
        ->where("categoria", 1)
        ->where("tipos_documentos.estado", 1)
        ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
        ->orderBy("tipos_documentos.descripcion")
        ->pluck("tipos_documentos.descripcion", "tipos_documentos.id")
        ->toArray();
        
        $cand_id = $request->user_id;

        return view("admin.contratacion.candidato.modal.nuevo_documento_seleccion_asistente", compact("tipo_documento", "cand_id"));
    }

    public function guardar_documento_asistente_seleccion(Request $data)
    {
        $mensaje = "No se cargo ningún documento";
        $success = false;
        if($data->hasFile('archivo_documento')){
            $cant_archivos = 0;
            $cant_no_procesados = 0;
            $validas   = array("pdf", "png", "docx", "doc", "jpg", "jpeg");
            $datosU = DatosBasicos::where('user_id', $data->cand_id)->first();
            $desc = TipoDocumento::where("id", $data->tipo_documento_id)->pluck('descripcion');

            foreach ($data->file('archivo_documento') as $key => $imagen) {
                $extension = $imagen->getClientOriginalExtension();

                if(in_array($extension,$validas)) {

                    $documento = new Documentos();
                    $documento->fill($data->all() + ["numero_id" => $datosU->numero_id, "user_id" => $datosU->user_id, "descripcion_archivo" => $desc,"gestiono"=>$this->user->id]);
                    $documento->save();
                    
                    $name_documento = "documento_seleccion_" . $documento->id . "." . $extension;

                    $imagen->move("recursos_documentos_verificados", $name_documento);
                    copy("recursos_documentos_verificados/".$name_documento, "recursos_documentos/".$name_documento);

                    $documento->nombre_archivo = $name_documento;
                    $documento->save();
                
                } else {
                    $cant_no_procesados++;
                }
                $cant_archivos++;
            }//fin foreach

            if ($cant_no_procesados == $cant_archivos) {
                //No se proceso ningún archivo
                $mensaje = "Documentos no soportados";
            } elseif ($cant_no_procesados > 0) {
                //Se procesaron algunos archivos
                $mensaje = "Se guardaron $cant_archivos documentos exitosamente y $cant_no_procesados documentos no soportados";
                $success = true;
            } else {
                //Se procesaron todos los archivos
                $mensaje = "Sus documentos fueron guardados exitosamente";
                $success = true;
            }
        }
        return response()->json([
            "mensaje" => $mensaje,
            "success" => $success
        ]);
    }

    
    public function closeFolderSchedule(){

        $req_can=ReqCandidato::where("estado_candidato",config('conf_aplicacion.C_CONTRATADO'))
        ->join("datos_basicos","datos_basicos.user_id","=","requerimiento_cantidato.candidato_id")
        ->where("bloqueo_carpeta_contratacion",0)
        ->whereBetween("fecha_tentativa_cierre_contratacion",[date('Y-m-d'),date("Y-m-d",strtotime($hoy."- 15 days"))])
        ->select("requerimiento_cantidato.*","datos_basicos.primer_nombre","datos_basicos.segundo_nombre","datos_basicos.numero_id")
        ->get();

        
        $candidatos_proximos=array();
        foreach($req_can as $req){
            if($req->fecha_tentativa_cierre_contratacion==date('Y-m-d')){

                Event::dispatch(new \App\Events\CloseSelectionFolderEvent($req,2));
                Event::dispatch(new \App\Events\CloseSelectionFolderEvent($req));
            }
            else{
                $current      = Carbon::parse(date('Y-m-d'));
                $future       = Carbon::parse($req->fecha_tentativa_cierre_contratacion);
                $dias_restantes = $current->diffInDays($future);
                if($dias_restantes==5 || $dias_restantes==10){
                    if($dias_restantes==10){

                        //Event::dispatch(new \App\Events\CloseSelectionFolderEvent($req));

                    }
                    array_push($candidatos_proximos, $req);
                }
                
                
                

            }
            
        }

        if(count($candidatos_proximos)>0){
            $gestores_documentales = ["" => "Seleccionar"] + User::join('role_users','role_users.user_id','=','users.id')
                ->where('role_users.role_id',24)
                ->get();

                foreach($gestores_documentales as $gestor){
                    $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                        $mailConfiguration = 1; //Id de la configuración
                        $mailTitle = ""; //Titulo o tema del correo

                        //Cuerpo con html y comillas dobles para las variables
                        $mailBody = "
                            Le informamos que las carpetas de contratacion de los colaboradores listados a continuación, están próximas a cerrarse automáticamente. Lo invitamos a que gestione todos los documentos de dicha carpeta antes de su cierre.
                            <br>
                            <strong>Listado:</strong>
                            <br/>";
                        
                        foreach($candidatos_proximos as $candidato){
                            $mailBody=$mailBody."<p> Cedula:".$candidato->numero_id."| #Requerimiento:".$candidato->requerimiento_id." |Fecha cierre:".$candidato->fecha_tentativa_cierre_contratacion."</p>";
                        }   

                        //Arreglo para el botón
                        $mailButton = [];

                        $mailUser = $gestor->id; //Id del usuario al que se le envía el correo

                        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($gestor) {

                                    $message->to($gestor->email)
                                            ->subject("Recordatorio de carpetas de contratación proximas a cerrar")
                                            ->getHeaders()
                                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                        });
                }
        }

        



    }
   



}
