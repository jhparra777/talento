<?php

namespace App\Http\Controllers;

use Storage;

use Carbon\Carbon;
use triPostmaster;
use App\Models\User;
use App\Models\Sitio;
use GuzzleHttp\Client;
use App\Models\Clientes;
use App\Models\TruoraKey;
use App\Models\Documentos;
use App\Models\OrdenMedica;
use App\Models\SitioModulo;
use App\Models\DatosBasicos;
use App\Models\GrupoFamilia;
use App\Models\ReqCandidato;
use Illuminate\Http\Request;
use App\Models\GestionPrueba;
use App\Models\Requerimiento;
use App\Models\TipoDocumento;
use App\Models\AgenciaUsuario;
use App\Models\EstadosOrdenes;
use App\Models\FirmaContratos;
use App\Jobs\FuncionesGlobales;
use App\Models\DocumentosCargo;
use App\Models\ExamenesMedicos;
use App\Models\ObservacionesHv;
use App\Models\RegistroProceso;
use App\Models\ConsultaSeguridad;
use App\Models\ContratoCancelado;
use App\Models\DataEmailEnviados;
use App\Models\DocumentoFamiliar;
use Illuminate\Support\Facades\DB;
use App\Models\CarpetaContratacion;
use App\Models\PruebaBrigResultado;
use App\Http\Controllers\Controller;
use App\Models\EntrevistaCandidatos;
use Illuminate\Support\Facades\Mail;
use App\Models\EstadosRequerimientos;
use App\Models\PreguntasPruebaIdioma;
use Illuminate\Support\Facades\Route;
use App\Models\PruebaValoresRespuestas;
use App\Models\PruebaExcelRespuestaUser;
use App\Models\PruebaDigitacionResultado;
use Illuminate\Support\Facades\Validator;
use App\Models\EvaluacionSstConfiguracion;
use App\Models\PruebaCompetenciaResultado;

use App\Models\SocioDemograficoConfiguracion;
use App\Models\SocioDemograficoPreguntas;
use App\Models\SocioDemograficoRespuestasUser;

use App\Models\ConfirmacionPreguntaContrato;

use App\Models\DocumentoCarpetaContratacion;

use App\Models\MotivosCancelacionContratacion;
//Helper
use App\Models\RequerimientoContratoCandidato;
use App\Models\PoliticasPrivacidad;
//Integrations
use App\Models\ConfirmacionDocumentosAdicionales;
use App\Http\Controllers\Integrations\TruoraIntegrationController;
use App\Models\ConsultaListaVinculante;
use App\Http\Controllers\ContratacionVirtualController;
use App\Models\TipoPolitica;
use App\Models\PoliticaPrivacidadCandidato;
use App\Models\MotivoAnulacion;

class ContratacionController extends Controller
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

        if($sitio->precontrata == 1){
            $procesos = ['ENVIO_CONTRATACION', 'PRE_CONTRATAR'];
        }else{
            $procesos = ['ENVIO_CONTRATACION'];
        }

        $id_user = DatosBasicos::where("numero_id", $data->get("cedula"))->first();

        $estado = [1];
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


        $requerimientos = \Cache::remember('requerimientos','60', function(){

           return Requerimiento::join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
        ->whereRaw('estados_requerimiento.id = (select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id = requerimientos.id)')
        ->whereNotIn("estados_requerimiento.estado",[
            config('conf_aplicacion.C_TERMINADO'),
            config('conf_aplicacion.C_CLIENTE'),
            config('conf_aplicacion.C_ELIMINADO'),
            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
            3
        ])
        ->select(
            "requerimientos.fecha_ingreso",
            DB::raw('(select count(*) from firma_contratos INNER JOIN requerimiento_cantidato ON requerimiento_cantidato.candidato_id = firma_contratos.user_id where fecha_firma is null and (terminado IS NULL or terminado = 3) and estado not in(0) and req_id=requerimientos.id and requerimiento_cantidato.requerimiento_id = requerimientos.id and requerimiento_cantidato.estado_candidato NOT IN (24)) as firmas_pendientes'),
            DB::raw('(select count(*) from firma_contratos where (fecha_firma is not null or (terminado is not null and terminado != 3)) and req_id=requerimientos.id) as firmas_completas'),
            //DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id) as contratados'),
            DB::raw('(select count(DISTINCT(procesos_candidato_req.candidato_id)) from procesos_candidato_req INNER JOIN requerimiento_cantidato ON requerimiento_cantidato.id=procesos_candidato_req.requerimiento_candidato_id where proceso in(\'PRE_CONTRATAR\') and procesos_candidato_req.requerimiento_id=requerimientos.id and requerimiento_cantidato.estado_candidato=11) as precontratados_contratados'),
            DB::raw('(select count(DISTINCT(procesos_candidato_req.candidato_id)) from procesos_candidato_req INNER JOIN requerimiento_cantidato ON requerimiento_cantidato.id=procesos_candidato_req.requerimiento_candidato_id where proceso in(\'PRE_CONTRATAR\') and procesos_candidato_req.requerimiento_id=requerimientos.id and requerimiento_cantidato.estado_candidato != 14) as precontratados')
        )
        ->get();

        });

        $firmas_pendientes = $requerimientos->sum("firmas_pendientes");

        $contrataciones_pendientes = $requerimientos->sum("precontratados") - ($requerimientos->sum("precontratados_contratados") + $requerimientos->sum("firmas_completas"));

        if($contrataciones_pendientes < 0)
            $contrataciones_pendientes = 0;

        /*$firmas_pendientes=FirmaContratos::join("requerimientos","requerimientos.id","=","firma_contratos.req_id")
        ->join("estados_requerimiento","estados_requerimiento.req_id","=","requerimientos.id")
        ->whereNull('fecha_firma')
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
        ->whereNotIn("estados_requerimiento.estado",[
                        config('conf_aplicacion.C_TERMINADO'),
                        config('conf_aplicacion.C_CLIENTE'),
                        config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL')
                    ])

        ->select("requerimientos.fecha_ingreso")
        ->get();*/

        $requerimientos_vencidos = $requerimientos->filter(function ($value) use($fecha_hoy) {
            if($value->fecha_ingreso <= $fecha_hoy) {
                return 1;
            } else {
                return 0;
            }
        });

        $contrataciones_vencidas = $requerimientos_vencidos->sum("precontratados") - $requerimientos_vencidos->sum("firmas_completas");
        
        if($contrataciones_vencidas < 0)
            $contrataciones_vencidas = 0;

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
        ->leftjoin('empresa_logos', 'empresa_logos.id', '=', 'requerimientos.empresa_contrata')
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
        //->whereNull("procesos_candidato_req.apto")
        //->Orwhere("procesos_candidato_req.apto", 1)
        ->whereIn("clientes.id", $this->clientes_user)
        ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
        //->whereBetween(DB::raw('DATE_FORMAT(procesos_candidato_req.created_at, \'%Y-%m-%d\')'), [date("Y-m-d", strtotime(date("Y-m-d")."- 3 month")), date("Y-m-d")])
        ->whereBetween('procesos_candidato_req.created_at', ['2020-03-31', date("Y-m-d", strtotime(date("Y-m-d")."+ 1 days"))])
        ->whereRaw('requerimiento_cantidato.id=(select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.requerimiento_id=requerimientos.id and requerimiento_cantidato.candidato_id=users.id)')
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
        ->whereIn("procesos_candidato_req.proceso", $procesos)
        ->whereIn("requerimiento_cantidato.estado_contratacion", $estado)
        ->whereNotIn('requerimiento_cantidato.estado_candidato', [config('conf_aplicacion.C_QUITAR')])
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
            "procesos_candidato_req.created_at as fecha_contrato",
            "tipo_proceso.descripcion as tipo_proceso",
            "tipo_proceso.contratacion_directa",
            "procesos_candidato_req.fecha_ingreso_contra as fecha_inicio",
            "requerimientos.fecha_ingreso as fecha_ingreso",
            "procesos_candidato_req.observaciones as observacion",
            "procesos_candidato_req.id as proceso_candidato_req",
            DB::raw('(SELECT MAX(requerimiento_cantidato.id) FROM requerimiento_cantidato WHERE requerimiento_cantidato.candidato_id = users.id) as requerimiento_candidato'),
            "procesos_candidato_req.asistira as asistira",
            "procesos_candidato_req.id as proceso",
            "procesos_candidato_req.proceso as nombre_proceso",
            "cargos_especificos.firma_digital as firma_digital",
            "cargos_especificos.id as cargo_id",
            "requerimiento_cantidato.id",
            "requerimiento_cantidato.estado_candidato",
            DB::raw('(select name from users where users.id=procesos_candidato_req.usuario_envio) as user_envio'),
            DB::raw('(select id from orden_medica where req_can_id=requerimiento_cantidato.id limit 1 ) as enviado_examen'),
            DB::raw('(select id from orden_estudio_seguridad where req_can_id=requerimiento_cantidato.id limit 1 ) as enviado_estudio'),
            "empresa_logos.nombre_empresa as nombre_empresa_contrata"
        )
        ->with("procesos")
        ->groupBy("requerimiento_cantidato.id")
        ->orderBy("requerimientos.fecha_ingreso", $ordenamiento)
        ->paginate(12);


        $estados = ["" => "Seleccione",  0 => "Contratados", 1 => "En proceso contratación"];

        $clientes = ["" => "Seleccionar"] + Clientes::orderBy(DB::raw("UPPER(clientes.nombre)"),"ASC")->pluck("clientes.nombre", "clientes.id")->toArray();

        $motivos_anulacion = ["" => "Seleccionar"] + MotivoAnulacion::pluck("descripcion", "id")->toArray();

        session(["url_previa" => url($_SERVER['REQUEST_URI'])]);

        return view("admin.contratacion.index-new", compact(
            "user_sesion",
            "candidatos",
            "clientes",
            "usuarios",
            "estados",
            "sitio",
            "firmas_pendientes",
            "contrataciones_vencidas",
            "contrataciones_pendientes",
            "motivos_anulacion"
        ));
    }

    public function gestionar_candidato($candidato,$req)
    {
        $datos_candidato = DatosBasicos::where('user_id', $candidato)->first();

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
            ->select('requerimiento_cantidato.id as id',"requerimiento_cantidato.bloqueo_carpeta")
        ->first();

        $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
            ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
            ->where("tipos_documentos.estado", 1)
            ->whereNotIn('categoria', [3, 5])    //No traer los documentos confidenciales (3) ni los de beneficiarios (5)
            ->select(
                "tipos_documentos.id as id",
                "tipos_documentos.descripcion as descripcion",
                "tipos_documentos.categoria as categoria",
                DB::raw("CASE WHEN(tipos_documentos.categoria=3) THEN (select documentos.nombre_archivo from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id and documentos.active = 1 desc limit 1) ELSE (select documentos.nombre_archivo from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.active = 1 order by documentos.id desc limit 1) END as nombre")
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
                DB::raw("(select documentos.nombre_archivo from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id and documentos.active = 1 desc limit 1) as nombre")
            )
            ->orderBy("tipos_documentos.id")
            ->groupBy("tipos_documentos.id")
        ->get();

        $docs = Documentos::select('nombre_archivo as nombre','nombre_archivo_real as nombre_real', 'id as id_documento','tipo_documento_id')->where('user_id', $candidato)->where('requerimiento', $req)->where("active",1)->latest('id')->groupBy('tipo_documento_id')->get();

        $documento_contratacion_cargados = $docs->whereIn('tipo_documento_id', $tipo_documento->where('categoria', 2)->pluck('id'))->unique('tipo_documento_id');

        $documento_post_cargados = $docs->whereIn('tipo_documento_id', $tipo_documento->where('categoria', 4)->pluck('id'))->unique('tipo_documento_id');

        $documento_seleccion = $tipo_documento->filter(function ($value) {
            return $value->categoria == 1;
        });

        $check_seleccion = $documento_seleccion->filter(function ($value) {
            return $value->nombre != "";
        })->count();

        if($documento_seleccion->count() != 0){
            $porcentaje_seleccion = round($check_seleccion*100/$documento_seleccion->count(), 2);
        }else{
            $porcentaje_seleccion = 0;
        }

        $cantidad_doc_contratacion = $tipo_documento->where('categoria', 2)->count();

        if(count($documento_contratacion_cargados) > 0){
            $porcentaje_contratacion = round($documento_contratacion_cargados->count()*100/$cantidad_doc_contratacion, 2);
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

        $cantidad_doc_post = $tipo_documento->where('categoria', 4)->count();
 
        if(count($documento_post_cargados) > 0){
            $porcentaje_post = round($documento_post_cargados*100/$cantidad_doc_post, 2);
        }else{
            $porcentaje_post = 0;
        }

        return view("admin.contratacion.gestion-new", compact(
            "porcentaje_seleccion",
            "porcentaje_contratacion",
            "porcentaje_confidencial",
            "porcentaje_post",
            "candidato",
            "req",
            "datos_candidato",
            "requerimiento",
            "candi_req"
        ));
    }

    /*
    *  Carga de archivos y firma de contraro del candidato
    */
    public function carga_documentos(Request $request)
    {
        if(empty($this->user->id)){
            return redirect()->route('login', ['email' => 'true']);
        }

        $sitio = Sitio::first();

        $menu = DB::table("menu_candidato")->where("estado", 1)->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();

        $requerimiento_candidato = ReqCandidato::where('candidato_id', $this->user->id)
        ->orderBy('created_at', 'DESC')
        ->first();

        if($requerimiento_candidato == null || $requerimiento_candidato == null){
            $candidatos = null;

            return view("admin.contratacion.candidato.carga_archivos", compact(
                "candidatos","menu"
            ));
        }

        //Validar requerimiento, si existe
        $requerimiento_existe = Requerimiento::where('id', $requerimiento_candidato->requerimiento_id)
        ->first();

        if($requerimiento_existe != null || $requerimiento_existe != '' || !empty($requerimiento_existe)) {
            $req_id = $requerimiento_candidato->requerimiento_id;

            $candidatos = Requerimiento::join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_id", "=", "requerimientos.id")
            ->where("requerimientos.id", $req_id)
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_CONTRATACION", "FIN_CONTRATACION_VIRTUAL", "FIRMA_VIRTUAL_SIN_VIDEOS"])
            ->whereIn("procesos_candidato_req.estado", [11, 12, 24])
            ->where("procesos_candidato_req.candidato_id", $this->user->id)
            ->select(
                "requerimientos.id as req_id",
                "cargos_especificos.descripcion as cargo",
                "cargos_especificos.id as cargo_id",
                "cargos_especificos.firma_digital as firma_digital",
                "procesos_candidato_req.asistira as asistira",
                "procesos_candidato_req.id as proceso",
                "procesos_candidato_req.candidato_id as user_id"
            )
            ->orderBy("procesos_candidato_req.created_at", "DESC")
            ->first();
        }else{
            $candidatos = null;

            return view("admin.contratacion.candidato.carga_archivos", compact(
                "candidatos","menu"
            ));
        }

        $user = $this->user->id;
        $tipo_documento = [];

        if ($candidatos != null) {
            $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
            ->where("tipos_documentos.categoria", 1)
            ->where("tipos_documentos.carga_candidato", 1)
            ->where("cargo_documento.cargo_especifico_id", $candidatos->cargo_id)
            ->select(
                "tipos_documentos.id as id",
                "tipos_documentos.descripcion as descripcion",
                DB::raw("(select documentos.nombre_archivo from documentos where user_id = $user and documentos.tipo_documento_id = tipos_documentos.id and documentos.active=1 order by documentos.id desc limit 1) as nombre"))
            ->orderBy("tipos_documentos.id")
            ->groupBy("tipos_documentos.id")
            ->get();

            if($tipo_documento == '' || $tipo_documento == null || empty($tipo_documento)){
                $tipo_documento = [];
            }
        }

        $cantidad_documentos = count($tipo_documento);

        if($cantidad_documentos == 0){
            $cantidad_documentos = 1;
        }

        $porcentaje = 0;
        $check = 0;

        if($candidatos != null && $tipo_documento != '') {
            foreach($tipo_documento as $documento) {
                if($documento->nombre != "") {
                    $check = $check + 1;
                }
            }

            $porcentaje = round($check * 100 / $cantidad_documentos);
        }

        $getFirma = FirmaContratos::where('user_id', $this->user->id)
        ->where('req_id', $req_id)
        ->orderBy('created_at', 'DESC')
        ->first();

        if($getFirma == null || $getFirma == ''){
            $getFirma = null;
        }

        $sitioModulo = SitioModulo::first();

        $posee_datos_sociodemografico = false;
        $posee_datos_sociodemografico_anterior = false;
        $datos_sociodemografico = null;
        $sociodemografica_config = null;
        $sociodemografico_questions = null;

        if ($sitioModulo->encuesta_sociodemografica == 'enabled') {
            $posee_datos_sociodemografico = true;
            $sociodemografico_questions = SocioDemograficoPreguntas::where('active', 1)->orderBy('id')->get();

            $sociodemografica_config = SocioDemograficoConfiguracion::first();

            $datos_sociodemografico = SocioDemograficoRespuestasUser::where('requerimiento_candidato_id', $requerimiento_candidato->id)
            ->first();

            if (is_null($datos_sociodemografico)) {
                $posee_datos_sociodemografico = false;
                //Sino tiene datos para el requerimiento, se busca si tiene datos en requerimientos anteriores
                $datos_anteriores = SocioDemograficoRespuestasUser::where('candidato_id', $this->user->id)
                    ->orderBy('id', 'desc')
                ->first();

                $datos_sociodemografico = new SocioDemograficoRespuestasUser();
                if (!is_null($datos_anteriores)) {
                    //Si tiene datos sociodemograficos en requerimientos anteriores se asignan para mostrarlos precargados
                    $posee_datos_sociodemografico_anterior = true;
                    $datos_sociodemografico->fill([
                        'candidato_id'                  => $datos_anteriores->candidato_id,
                        'requerimiento_id'              => $datos_anteriores->requerimiento_id,
                        'respuestas'                    => $datos_anteriores->respuestas
                    ]);
                }
            }
        }

        return view("admin.contratacion.candidato.carga_archivos", compact(
            "tipo_documento",
            "porcentaje",
            "candidatos",
            'menu',
            "validar_docs",
            "getFirma",
            "sitio",
            "requerimiento_candidato",
            "sitioModulo",
            "posee_datos_sociodemografico",
            "posee_datos_sociodemografico_anterior",
            "datos_sociodemografico",
            "sociodemografica_config",
            "sociodemografico_questions"
        ));
    }

    public function cargar_documento(Request $request)
    {
        $requerimiento = Requerimiento::find($request->get("req_id"));

        $tipo_documento = ["" => "Seleccionar"] + TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
        //->leftjoin("datos_basicos","datos_basicos.numero_id","=","documentos.numero_id")
        ->leftjoin("users", "users.id", "=", "documentos.user_id")
        ->where("categoria", 1)
        ->where("tipos_documentos.carga_candidato", 1)
        ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
        ->orderBy("tipos_documentos.descripcion")
        ->pluck("tipos_documentos.descripcion", "tipos_documentos.id")
        ->toArray();
        
        return view("admin.contratacion.candidato.modal.nuevo_documento", compact("tipo_documento"));
    }

    public function guardar_encuesta_sociodemografica(Request $request, \App\Http\Requests\EncuestaSocioDemograficaRequest $valida) {

        if (!empty($request->id_datos_sociodemografico)) {
            $datos_sociodemografico = SocioDemograficoRespuestasUser::find($request->id_datos_sociodemografico);
        } else {
            $datos_sociodemografico = new SocioDemograficoRespuestasUser();
        }

        $preg_resp = $request->except('_token', 'id_datos_sociodemografico', 'requerimiento_id', 'req_cand_id');

        $preguntasActivas = SocioDemograficoPreguntas::where('active', 1)->orderBy('id')->get();

        foreach ($preg_resp as $preg_id_text => &$opcion) {
            $pregunta_id = str_replace('preg_id_', '', $preg_id_text);

            $pregunta = $preguntasActivas->find($pregunta_id);
            if ($pregunta->tipo == 'archivo') {
                $archivo        = $request->file("$preg_id_text");
                $extension      = $archivo->getClientOriginalExtension();
                $name_documento = "documento_sociodemografico_" . $request->req_cand_id . "_" . $preg_id_text . "." . $extension;
                $archivo->move("recursos_encuesta_sociodemografica", $name_documento);

                //Se guardara en las respuestas el nombre del documento
                $opcion = $name_documento;
            }
        }

        $datos_sociodemografico->fill([
            'candidato_id'      => $this->user->id,
            'req_id'            => $request->requerimiento_id,
            'respuestas'        => json_encode($preg_resp),
            'fecha_respuesta'   => date('Y-m-d'),
            'requerimiento_candidato_id'    => $request->req_cand_id
        ]);

        $datos_sociodemografico->save();

        return response()->json(["success" => true]);
    }

    public function guardar_documento(\App\Http\Requests\DocumentoNuevoContratacion $data)
    {
        try {
            if($data->hasFile('archivo_documento')) {
                $datos_basicos=DatosBasicos::where("user_id",$this->user->id)->first();
                $documentos = new Documentos();
                $documentos->fill($data->all() + ["user_id" => $this->user->id,"numero_id",$datos_basicos->numero_id]);
                $documentos->save();
    
                $imagen         = $data->file("archivo_documento");
                $extencion      = $imagen->getClientOriginalExtension();
                $name_documento = "documento_contratacion" . $documentos->id . "." . $extencion;
                $imagen->move("recursos_documentos_verificados", $name_documento);
                copy("recursos_documentos_verificados/".$name_documento, "recursos_documentos/".$name_documento);
                $documentos->nombre_archivo = $name_documento;
                $documentos->nombre_archivo_real = $imagen->getClientOriginalName();
                $documentos->gestiono = $this->user->id;
                $documentos->save();
            }
    
            return response()->json(["success" => true]);
        } catch (\Exception $e) {
			logger('Excepción capturada ContratacionController@guardar_documento: '.  $e->getMessage(). "\n");
			return response()->json(['success' => false, 'mensaje' => 'Ha ocurrido un error procesando la información']);
		}

    }

    /*
    *   Lista de documentos de selección
    */
    public function documentos_seleccion($candidato, $req, $req_can)
    {
        $req_candidato = ReqCandidato::find($req_can);
        $candidato_id = $candidato;

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
              DB::raw("(select d.fecha_vencimiento from documentos as d where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id order by d.id desc limit 1) as fecha_vencimiento"),
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

        /*$politicas_datos = TipoPolitica::join('politicas_privacidad', 'politicas_privacidad.tipo_politica_id', '=', 'tipos_politicas.id')
            ->join('politicas_privacidad_candidatos', 'politicas_privacidad_candidatos.politica_privacidad_id', '=', 'politicas_privacidad.id')
            ->where('politicas_privacidad_candidatos.candidato_id', $candidato_id)
            //->whereRaw('politicas_privacidad_candidatos.id = (SELECT MAX(ppc.id) FROM politicas_privacidad_candidatos AS ppc WHERE ppc.candidato_id = ?)', [$candidato_id])
            //->whereRaw('politicas_privacidad.id = (SELECT MAX(pp.id) FROM politicas_privacidad AS pp WHERE pp.tipo_politica_id = tipos_politicas.id)')
            ->where('tipos_politicas.active', 1)
            ->orderBy('politicas_privacidad_candidatos.id', 'DESC')
            ->groupBy('tipos_politicas.id')
            ->get();
            */
        $tipos_politicas_privacidad = TipoPolitica::where('active', 1)->get();

        $politicas_aceptadas = collect([]);

        foreach( $tipos_politicas_privacidad as $tipo_politica  ){
                
            $acepto_politica = PoliticaPrivacidadCandidato::join("politicas_privacidad", "politicas_privacidad.id", "=", "politicas_privacidad_candidatos.politica_privacidad_id")
            ->join("tipos_politicas", "tipos_politicas.id", "=", "politicas_privacidad.tipo_politica_id")
            ->where("politicas_privacidad_candidatos.candidato_id", $candidato_id)
            ->where("politicas_privacidad.tipo_politica_id", $tipo_politica->id)
            ->select("politicas_privacidad_candidatos.*", "tipos_politicas.titulo_boton_carpeta_seleccion")
            ->orderBy("politicas_privacidad_candidatos.id", "DESC")
            ->first();

            if( $acepto_politica != null ){
                $politicas_aceptadas->push($acepto_politica);
            }

        }

        //dd($politicas_aceptadas);

        return view('admin.contratacion.documentos_seleccion_new', compact(
            'tipo_documento',
            'candidato_id',
            'req_can',
            'req',
            'datos_candidato',
            'requerimiento',
            'pruebas',
            'enlaces_pruebas',
            'req_candidato',
            'politicas_aceptadas'
        ));
    }

    public function documentos_seleccion_cliente($candidato, $req, $req_can)
    {
        $req_candidato = ReqCandidato::find($req_can);
        $candidato_id = $candidato;

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
              DB::raw("(select d.fecha_vencimiento from documentos as d where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id order by d.id desc limit 1) as fecha_vencimiento"),
              DB::raw("(select u.name from documentos d left join users u on d.gestiono=u.id where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id order by d.id desc limit 1) as usuario_gestiono")
            )
            ->orderBy("tipos_documentos.id")
            ->groupBy("tipos_documentos.id")
            ->get();

            $docs = Documentos::select('nombre_archivo as nombre','nombre_archivo_real as nombre_real', 'id as id_documento', 'fecha_vencimiento as fecha_vencimiento','tipo_documento_id')->where('user_id', $candidato_id)->get();

            

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

        return view('req.contratacion.documentos_seleccion_new', compact(
            'tipo_documento',
            'candidato_id',
            'req_can',
            'req',
            'datos_candidato',
            'requerimiento',
            'pruebas',
            'enlaces_pruebas',
            'req_candidato'
        ));
    }
    /*
    *   Lista de documentos de contratación
    */
    public function documentos_contratacion($candidato, $req)
    {
        $candidato_id = $candidato;
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
        
        return view('admin.contratacion.documentos_contratacion_new',compact(
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
            "contrato_manual"
        ));
    }

    public function documentos_contratacion_cliente($candidato, $req)
    {
        $candidato_id = $candidato;
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

        /*foreach ($tipo_documento as $key => &$tipo_doc) {
            $tipo_doc->documentos = Documentos::select('nombre_archivo as nombre', 'id as id_documento')->where('user_id', $candidato_id)->where('tipo_documento_id', $tipo_doc->id)->where('requerimiento', $req)->latest('id')->limit(5)->get();
        }*/

        $docs = Documentos::select('nombre_archivo as nombre','nombre_archivo_real as nombre_real', 'id as id_documento','tipo_documento_id')->where('user_id', $candidato_id)->where('requerimiento', $req)->latest('id')->get();

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
        
        return view('req.contratacion.documentos_contratacion_new',compact(
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
            "contrato_manual"
        ));
    }

    /*
    *   Lista de documentos confidenciales
    */
    public function documentos_confidenciales($candidato, $req)
    {
        $datos_candidato = DatosBasicos::where('user_id', $candidato)->first();

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
            $tipo_doc->documentos = $docs->filter(function ($value) use ($tipo_doc){
                return $value->tipo_documento_id==$tipo_doc->id;

            });

            $tipo_doc->documentos= $tipo_doc->documentos->take(5);

        }
        unset($tipo_doc);

        // dd($tipo_documento);
        /*$tipo_documento_aparte = TipoDocumento::leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("users", "users.id", "=", "documentos.user_id")
        ->where("tipos_documentos.estado", 1)
        ->where("tipos_documentos.id", 5)
        ->select(
            "tipos_documentos.id as id",
            "tipos_documentos.descripcion as descripcion",
            DB::raw("(select documentos.nombre_archivo from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id desc limit 1) as nombre")
        )
        ->orderBy("id", "DESC")
        ->groupBy("id")
        ->first();*/

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

        $consulta_seguridad_proceso = RegistroProceso::where('candidato_id', $candidato_id)
        ->where('requerimiento_id', $req)
        ->where('proceso', 'CONSULTA_SEGURIDAD')
        ->first();

        //Consulta seguridad
        $consultaListaVinculante = ConsultaListaVinculante::where('user_id', $candidato_id)->orderBy('id', 'DESC')->first();

        $listas_vinculantes_proceso = RegistroProceso::where('candidato_id', $candidato_id)
        ->where('requerimiento_id', $req)
        ->where('proceso', 'LISTAS_VINCULANTES')
        ->first();

        //Tusdatos
        $tusdatosData = FuncionesGlobales::getTusDatos($req, $candidato_id);

        return view('admin.contratacion.documentos_confidenciales_new', compact(
            "tipo_documento",
            //"tipo_documento_aparte",
            "getChecked",
            "datos_candidato",
            "requerimiento",
            "candidato_id",
            "req",
            "consultaSeguridad",
            "tusdatosData",
            "consultaListaVinculante",
            "consulta_seguridad_proceso",
            "listas_vinculantes_proceso"
        ));
    }

    public function documentos_post($candidato, $req)
    {
        $candidato_id = $candidato;

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
              DB::raw("(select documentos.observacion from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id desc limit 1) as observacion"),
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
        }
        else{
            $porcentaje = 0;
        }
        /*$getChecked = TruoraKey::where('cand_id', $candidato)
        ->where('req_id', $req)
        ->first();*/
        $datos_candidato = DatosBasicos::where('user_id', $candidato)->first();
        
        return view('admin.contratacion.documentos_post_new', compact(
            "tipo_documento",
            "getChecked",
            "datos_candidato",
            "requerimiento",
            "candidato_id",
            "req"
        ));
    }

    public function documentos_beneficiarios($candidato, $req) {

        $datos_candidato = DatosBasicos::where('user_id', $candidato)->first();

        $candidato_id = $candidato;

        $documentosFamiliares = DocumentoFamiliar::leftjoin("grupos_familiares", "grupos_familiares.id", "=", "documentos_familiares.grupo_familiar_id")
            ->leftjoin("tipos_documentos", "tipos_documentos.id", "=", "documentos_familiares.tipo_documento_id")// 1 q es cedula
            ->leftjoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")//1 Esposa
            ->leftjoin("users", "users.id", "=", "documentos_familiares.usuario_gestiono")
            ->select("documentos_familiares.id",
                     "documentos_familiares.nombre",
                     "documentos_familiares.created_at",
                     "documentos_familiares.descripcion as descripcion",
                     "users.name as usuario_cargo",
                     "grupos_familiares.nombres as grupo_familiar",
                     "tipos_documentos.descripcion as tipo_documento",
                     "parentescos.descripcion as parentesco")
            ->where("grupos_familiares.user_id", $candidato)//2
            ->where("documentos_familiares.active",1)
            ->orderBy("documentos_familiares.id")
            ->get();

        //dd($documentosFamiliares);

        $requerimiento = Requerimiento::join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->where("requerimientos.id", $req)
        ->select(
            "requerimientos.*",
            "tipo_proceso.descripcion as tipo_proceso"
        )
        ->first();

        return view('admin.contratacion.documentos_beneficiarios_new', compact("datos_candidato", "candidato_id", "req", "documentosFamiliares", "requerimiento"));
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
        $rules=[];
        //$input = array('archivo', \Input::file('archivo_documento'));
        $nbr = count(\Input::file('archivo_documento')) - 1;
        
            foreach(range(0, $nbr) as $index) {
                $rules['archivo_documento.' . $index] = 'max:5120';
        }
        $validator = Validator::make($data->all(),$rules);

        if($validator->fails()){
           $mensaje = "Peso máximo del documento: 5MB";
            $success = false;
        }
        
        if($data->hasFile('archivo_documento') && !$validator->fails()){
            $cant_archivos = 0;
            $cant_no_procesados = 0;
            $validas   = array("pdf", "png", "docx", "doc", "jpg", "jpeg");
            $datosU = DatosBasicos::where('user_id', $data->cand_id)->first();
            $desc = TipoDocumento::where("id", $data->tipo_documento_id)->pluck('descripcion');

            foreach ($data->file('archivo_documento') as $key => $imagen) {
                $extension = $imagen->getClientOriginalExtension();

                if(in_array($extension,$validas)) {

                    $documento = new Documentos();
                    $documento->fill($data->except('fecha_vencimiento') + ["numero_id" => $datosU->numero_id, "user_id" => $datosU->user_id, "descripcion_archivo" => $desc,"gestiono"=>$this->user->id]);
                    if ($data->fecha_vencimiento != null) {
                        $documento->fecha_vencimiento = $data->fecha_vencimiento;
                    }
                    $documento->save();
                    
                    $name_documento = "documento_seleccion_" . $documento->id . "." . $extension;

                    $imagen->move("recursos_documentos_verificados", $name_documento);
                    copy("recursos_documentos_verificados/".$name_documento, "recursos_documentos/".$name_documento);

                    $documento->nombre_archivo = $name_documento;
                    $documento->nombre_archivo_real = $imagen->getClientOriginalName();
                    $documento->save();

                    //GUARDAR_ RELACION DOCUMENTO REQUERIMIENTO
                    //$this->procesoRequerimiento($verificar_documento->id, $data->ref_id, "MODULO_DOCUMENTO", '', $data->resultado, $data->observacion);
                
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

    public function cargar_documento_admin_beneficiario(Request $request)
    {
        //$requerimiento = Requerimiento::find($request->get("req_id"));

        $tipos_documentos = ["" => "Seleccionar"] + TipoDocumento::where("active", "1")->where('categoria', FuncionesGlobales::CATEGORIA_DOCUMENTOS_BENEFICIARIOS)->orderBy(DB::raw("UPPER(descripcion)"))->pluck("descripcion", "id")->toArray();

        $gruposFamiliares = GrupoFamilia::leftjoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
        ->select("grupos_familiares.id",
                 "grupos_familiares.nombres",
                 "grupos_familiares.primer_apellido",
                 "grupos_familiares.segundo_apellido",
                 "parentescos.descripcion as parentesco")
            ->where('grupos_familiares.user_id', $request->user_id)->get();
        
        $cand_id = $request->user_id;

        return view("admin.contratacion.candidato.modal.nuevo_documento_beneficiario_asistente", compact("tipos_documentos", "gruposFamiliares", "cand_id"));
    }

    public function guardar_documento_asistente_post(Request $data)
    {
        $mensaje = "No se cargo ningún documento";
        $success = false;

        //$input = array('archivo', \Input::file('archivo_documento'));
        $rules=[];
        //$input = array('archivo', \Input::file('archivo_documento'));
        $nbr = count(\Input::file('archivo_documento')) - 1;
        
        foreach(range(0, $nbr) as $index) {
                $rules['archivo_documento.' . $index] = 'max:5120';
        }
        $validator = Validator::make($data->all(),$rules);
       

        if($validator->fails()){
           $mensaje = "Peso máximo del documento: 5MB";
            $success = false;
        }
        
        if($data->hasFile('archivo_documento') /*&& !$validator->fails()*/){
            $cant_archivos = 0;
            $cant_no_procesados = 0;
            $validas   = array("pdf", "png", "docx", "doc", "jpg", "jpeg");
            $datosU = DatosBasicos::where('user_id', $data->cand_id)->first();
            $desc = TipoDocumento::where("id", $data->tipo_documento_id)->pluck('descripcion');
            $tip_doc= TipoDocumento::find($data->tipo_documento_id);
            $req_can=ReqCandidato::where("candidato_id",$data->cand_id)->where("requerimiento_id",$data->req_id)->first();

            foreach ($data->file('archivo_documento') as $key => $imagen) {
                $extension = strtolower($imagen->getClientOriginalExtension());

                if(in_array($extension,$validas)) {
                    if($tip_doc->terminacion_contrato){
                        $req_can->contratado_retirado=1;
                        $req_can->fecha_terminacion_contrato=$data->get("fecha_finalizacion");
                        $req_can->save();
                    }

                    $documento = new Documentos();
                    $documento->fill($data->all() + ["numero_id" => $datosU->numero_id, "user_id" => $datosU->user_id, "descripcion_archivo" => $desc,"gestiono"=>$this->user->id]);
                    $documento->save();
                    
                    $name_documento = "documento_postcontratacion_" . $documento->id . "." . $extension;

                    $imagen->move("recursos_documentos_verificados", $name_documento);

                    $documento->nombre_archivo = $name_documento;
                    $documento->nombre_archivo_real = $imagen->getClientOriginalName();
                    $documento->requerimiento = $data->req_id;
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

    public function cargar_documento_admin_post(Request $request)
    {
        $req_id = $request->req_id;
        $requerimiento = Requerimiento::find($req_id);

        $tipo_documento = ["" => "Seleccionar"] + TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("users", "users.id", "=", "documentos.user_id")
        ->where("categoria", 4)
        ->where("tipos_documentos.estado", 1)
        ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
        ->orderBy("tipos_documentos.descripcion")
        ->pluck("tipos_documentos.descripcion", "tipos_documentos.id")
        ->toArray();
        
        $cand_id = $request->user_id;

        return view("admin.contratacion.candidato.modal.nuevo_documento_post_asistente", compact("tipo_documento", "cand_id", "req_id"));
    }

    public function verifyDocument(Request $request){


        $document=TipoDocumento::find($request->get("id_document"));
        if($document->terminacion_contrato)
            return response()->json(["success"=>true]);
        else
            return response()->json(["success"=>false]);
    }
    
    public function cargar_documento_admin_confidencial(Request $request)
    {
        $requerimiento = Requerimiento::find($request->req);

        $tipo_documento = ["" => "Seleccionar"] + TipoDocumento::leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("users", "users.id", "=", "documentos.user_id")
        ->where("categoria", 3)
        ->where("tipos_documentos.estado", 1)
        ->select("tipos_documentos.id as id", "tipos_documentos.descripcion as descripcion")
        ->orderBy("tipos_documentos.descripcion")
        ->groupBy("id")
        ->pluck("descripcion", "id")
        ->toArray();
        
        $cand_id = $request->user_id;
        $req_id = $request->req;

        return view("admin.contratacion.candidato.modal.nuevo_documento_confidencial_asistente", compact("tipo_documento", "cand_id", "req_id"));
    }

    public function guardar_documento_asistente_confidencial(Request $data)
    {
        $mensaje = "No se cargo ningún documento";
        $success = false;
        if($data->hasFile('archivo_documento')){
            $validas   = array("pdf", "png", "docx", "doc", "jpg", "jpeg");
            $datosU = DatosBasicos::where('user_id', $data->cand_id)->first();
            $desc = TipoDocumento::where("id", $data->tipo_documento_id)->pluck('descripcion');

            $imagen = $data->file('archivo_documento');
            $extension = strtolower($imagen->getClientOriginalExtension());

            if(in_array($extension,$validas)) {
                $fecha_afiliacion = ($data->fecha_afiliacion != null && $data->fecha_afiliacion != '' ? $data->fecha_afiliacion : null);
                $documento = new Documentos();
                $documento->fill([
                    "tipo_documento_id" => $data->tipo_documento_id,
                    "fecha_afiliacion" => $fecha_afiliacion,
                    "numero_id" => $datosU->numero_id,
                    "user_id" => $datosU->user_id,
                    "descripcion_archivo" => $desc,
                    "gestiono"=>$this->user->id
                ]);
                $documento->save();
                
                $name_documento = "documento_confidencial_" . $documento->id . "." . $extension;

                $imagen->move("recursos_documentos_verificados", $name_documento);

                $documento->nombre_archivo = $name_documento;
                $documento->nombre_archivo_real = $imagen->getClientOriginalName();;
                $documento->requerimiento = $data->req_id;
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

    public function cargar_documento_admin_contratacion(Request $request)
    {
        $requerimiento = Requerimiento::find($request->req);

        $firmaContrato = FirmaContratos::where('user_id', $request->user_id)
            ->where('req_id', $request->req)
            ->orderBy('created_at', 'DESC')
        ->first();

        $proceso_contratacion = RegistroProceso::where('proceso', 'ENVIO_CONTRATACION')
            ->where('requerimiento_id', $request->req)
            ->where('candidato_id', $request->user_id)
        ->first();

        $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("users", "users.id", "=", "documentos.user_id")
        ->where("categoria", 2)
        ->where("tipos_documentos.estado", 1)
        ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
        ->where(function($query) use ($firmaContrato, $proceso_contratacion) {
            if(!is_null($firmaContrato)) {
               if ($firmaContrato->estado == 1 and in_array($firmaContrato->terminado, [1,2,3])) {
                    $query->where('tipos_documentos.cod_tipo_doc', '!=', 'C');
                    $query->orWhereNull('tipos_documentos.cod_tipo_doc');
               }
            }

            if (is_null($proceso_contratacion)) {
                $query->where('tipos_documentos.cod_tipo_doc', '!=', 'C');
                $query->orWhereNull('tipos_documentos.cod_tipo_doc');
            }
        })
        ->select("tipos_documentos.id as id", "tipos_documentos.descripcion as descripcion")
        ->orderBy("tipos_documentos.descripcion")
        ->groupBy("id")
        ->pluck("descripcion", "id")
        ->toArray();

        $sitioModulo = SitioModulo::first();

        if($sitioModulo->evaluacion_sst === 'enabled') {
            $configuracion_sst = EvaluacionSstConfiguracion::first();

            $tipo_documento += ["evaluacion_sst" => $configuracion_sst->titulo_cargar_documento];
            asort($tipo_documento);
        }

        $tipo_documento = ["" => "Seleccionar"] + $tipo_documento;
        
        $cand_id = $request->user_id;
        $req_id = $request->req;

        return view("admin.contratacion.candidato.modal.nuevo_documento_contratacion_asistente", compact("tipo_documento", "cand_id", "req_id"));
    }

    public function guardar_documento_asistente_contratacion(Request $data)
    {
        $mensaje = "No se cargo ningún documento";
        $success = false;

        $rules=[];
        //$input = array('archivo', \Input::file('archivo_documento'));
        $nbr = count(\Input::file('archivo_documento')) - 1;
        
        foreach(range(0, $nbr) as $index) {
                $rules['archivo_documento.' . $index] = 'max:5120';
        }
        $validator = Validator::make($data->all(),$rules);

        if($validator->fails()){
           $mensaje = "Peso máximo del documento: 5MB";
            $success = false;
        }

        if($data->hasFile('archivo_documento') && !$validator->fails()){
            $cant_archivos = 0;
            $cant_no_procesados = 0;
            $validas   = array("pdf", "png", "docx", "doc", "jpg", "jpeg");
            $datosU = DatosBasicos::where('user_id', $data->cand_id)->first();
            $desc = TipoDocumento::where("id", $data->tipo_documento_id)->pluck('descripcion')->first();
            $sitio = Sitio::first();
            $sitioModulo = SitioModulo::first();

            foreach ($data->file('archivo_documento') as $key => $imagen) {
                $extension = strtolower($imagen->getClientOriginalExtension());

                if(in_array($extension,$validas)) {
                    if ($data->tipo_documento_id === 'evaluacion_sst') {
                        $ref_id = RegistroProceso::where('requerimiento_id', $data->req_id)
                            ->where('candidato_id', $data->cand_id)
                            ->where('proceso',"ENVIO_SST")
                            ->orderBy('id',"DESC")
                        ->first();
                        
                        $ref_id->apto = 1;
                        $ref_id->fecha_fin = date('Y-m-d');
                        $ref_id->usuario_terminacion = $this->user->id;
                        $ref_id->save();

                        $nombre_documento = 'evaluacion_sst_'.$data->cand_id.'_'.$data->req_id.'.'.$extension;

                        if(!Storage::disk('public')->exists('recursos_evaluacion_sst')) {
                            Storage::disk('public')->makeDirectory('evaluaciones_sst', 0775, true);
                        }

                        $imagen->move("recursos_evaluacion_sst", $nombre_documento);

                        $cant_archivos++;
                        continue;
                    }

                    $fecha_afiliacion = ($data->fecha_afiliacion != null && $data->fecha_afiliacion != '' ? $data->fecha_afiliacion : null);
                    $documento = new Documentos();
                    $documento->fill([
                        "tipo_documento_id" => $data->tipo_documento_id,
                        "fecha_afiliacion" => $fecha_afiliacion,
                        "numero_id" => $datosU->numero_id,
                        "user_id" => $datosU->user_id,
                        "descripcion_archivo" => $desc,
                        "gestiono"=>$this->user->id
                    ]);
                    $documento->save();

                    $name_documento = "documento_contratacion_" . $documento->id . "." . $extension;
                    $imagen->move("recursos_documentos_verificados", $name_documento);

                    $documento->nombre_archivo = $name_documento;
                    $documento->nombre_archivo_real = $imagen->getClientOriginalName();
                    $documento->requerimiento = $data->req_id;
                    $documento->save();

                    //Si el documento cargado es el contrato, lo toma como CONTRATACIÓN MANUAL y crea los procesos
                    if ($desc === 'CONTRATO' || $desc === 'Contrato Firmado' || $desc === mb_strtoupper('Contrato Firmado')) {
                        $firmaContrato = FirmaContratos::where('user_id', $data->cand_id)
                        ->where('req_id', $data->req_id)
                        ->orderBy('created_at', 'DESC')
                        ->first();

                        $nuevo_estado = ReqCandidato::where("requerimiento_id", $data->req_id)
                        ->where("candidato_id", $data->cand_id)
                        ->orderBy("id","DESC")
                        ->first();

                        $requerimiento_contrato_candidato = RequerimientoContratoCandidato::where('requerimiento_candidato_id', $nuevo_estado->id)
                            ->orderBy("id","DESC")
                            ->select('id')
                        ->first();

                        if ($firmaContrato != null && $firmaContrato != '') {
                            if ($firmaContrato->terminado != 1 || $firmaContrato->terminado == null) {
                                $firmaContrato->terminado = 2;
                                $firmaContrato->gestion = $this->user->id;
                                $firmaContrato->fecha_firma = date("Y-m-d H:i:s");
                                $firmaContrato->req_contrato_cand_id = $requerimiento_contrato_candidato->id;
                                $firmaContrato->ip = $data->ip();
                                $firmaContrato->save();
                            }
                        }else {
                            $firma = new FirmaContratos();

                            $firma->user_id = $data->cand_id;
                            $firma->req_id = $data->req_id;
                            $firma->req_contrato_cand_id = $requerimiento_contrato_candidato->id;
                            $firma->estado = 1;
                            $firma->terminado = 2;
                            $firma->ip = $data->ip();
                            $firma->gestion = $this->user->id;
                            $firma->fecha_firma = date("Y-m-d H:i:s");
                            $firma->save();
                        }

                        //Cambia estado del proceso del candidato
                        $aptoProceso = RegistroProceso::where('requerimiento_id', $data->req_id)
                        ->where('candidato_id', $data->cand_id)
                        ->where('proceso', 'ENVIO_CONTRATACION')
                        ->orderby('created_at', 'DESC')
                        ->first();

                        $aptoProceso->apto = 1;
                        $aptoProceso->save();

                        $nuevo_estado->estado_candidato = 12;
                        $nuevo_estado->estado_contratacion = 0;
                        $nuevo_estado->save();

                        $nuevo_proceso = new RegistroProceso();
                        $nuevo_proceso->fill([
                            'requerimiento_candidato_id' => $nuevo_estado->id,
                            'estado'                     => config('conf_aplicacion.C_CONTRATADO'),
                            'fecha_inicio'               => date("Y-m-d H:i:s"),
                            'usuario_envio'              => $this->user->id,
                            'requerimiento_id'           => $data->req_id,
                            'candidato_id'               => $data->cand_id,
                            'observaciones'              => "Contrato cargado manualmente.",
                            'proceso'                    => "FIN_CONTRATACION_MANUAL",
                            'apto'                       => 1
                        ]);
                        $nuevo_proceso->save();

                        //Termina requerimiento si se completan las vacantes
                        $requerimiento = Requerimiento::find($data->req_id);
                        $numero_vacantes = $requerimiento->num_vacantes;
                        
                        $cuenta_contratos_firmados = FirmaContratos::where('req_id', $data->req_id)
                        ->whereIn('terminado', [1, 2])
                        ->whereNotIn("estado", [0])
                        ->count();

                        if ($cuenta_contratos_firmados != null || $cuenta_contratos_firmados != '') {
                            if($cuenta_contratos_firmados >= $numero_vacantes){
                                $buscar_estado_req = EstadosRequerimientos::where('req_id', $data->req_id)
                                ->where('estado', 16)
                                ->first();

                                //Valida si ya esta cerrado el req
                                if($buscar_estado_req == null || $buscar_estado_req == ''){
                                    $terminar_req = new EstadosRequerimientos();
                                    $terminar_req->fill([
                                        "estado"        => config('conf_aplicacion.C_TERMINADO'),
                                        "user_gestion"  => $this->user->id,
                                        "observaciones" => "Se ha cumplido con todos los candidatos solicitados.",
                                        "req_id"        => $data->req_id,
                                    ]);
                                    $terminar_req->save();

                                    //Se cambia el estado público del requerimiento
                                    $req = Requerimiento::find($data->req_id);
                                    $req->estado_publico = 0;
                                    $req->save();

                                    $candidatos_no_contratados = [];

                                    //Consultar candidatos enviados
                                    $no_seleccionados = User::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
                                    ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                                    ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
                                    ->where("requerimiento_cantidato.requerimiento_id", $data->req_id)
                                    ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
                                    ->select(
                                        "datos_basicos.*",
                                        "estados.id as estado_id",
                                        "estados.descripcion as estado_candidatos",
                                        "requerimiento_cantidato.id as req_candidato_id"
                                    )
                                    ->get();

                                    foreach ($no_seleccionados as $key => $candidato) {
                                        //Valida la contratación cancelada
                                        if($candidato->estado_id != 24){
                                            if ($candidato->estado_id == config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')) {
                                            }else{
                                                array_push($candidatos_no_contratados, $candidato->user_id);
                                            }
                                        }
                                    }

                                    //ACTIVAR CANDIDATOS NO SELECCIONADOS
                                    foreach ($candidatos_no_contratados as $key => $user) {
                                        $update_user = DatosBasicos::where("user_id", $user)->first();
                                        $update_user->fill(["estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')]);
                                        $update_user->save();
                                    }
                                }
                            }
                        }

                        /*
                        Ocultando correo que se envia cuando se carga el contrato desde el asistente

                        $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                        ->where("requerimientos.id", $data->req_id)
                        ->select(
                            "clientes.nombre as nombre_cliente",
                            "clientes.direccion as direccion_cliente",
                            "clientes.contacto as contacto_cliente",
                            "clientes.correo as correo",
                            "clientes.id as cliente_id",
                            "cargos_especificos.descripcion as cargo",
                            "requerimientos.sitio_trabajo"
                        )
                        ->first();

                        if($requerimiento->correo != "" && $requerimiento->correo != null){
                            Mail::send('admin.email_contrato_candidato', [
                                "candidato" => $datosU,
                                "requerimiento" => $requerimiento
                            ], function ($message) use($requerimiento){
                                $message->to(
                                    $requerimiento->correo
                                ,"T3RS")->subject("Contrato candidato")
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                            });
                        }
                        */

                        //para enviar notificacion a rol afiliaciones
                        $candidato = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
                            ->where('user_id', $data->cand_id)
                            ->select(
                                "datos_basicos.*",
                                "tipo_identificacion.descripcion as dec_tipo_doc"
                                )
                            ->first();

                        if ( $sitioModulo->afiliaciones == 'enabled' ) {
                            $es_cliente_prueba = false;

                            if ($sitio->filtro_cliente == 'enabled' && $sitio->clientes_prueba_id != null && $sitio->clientes_prueba_id != '') {
                                $ids_clientes_prueba = explode(",", $sitio->clientes_prueba_id);

                                if (in_array($requerimiento->cliente_id, $ids_clientes_prueba)) {
                                    $es_cliente_prueba = true;
                                }
                            }

                            if (!$es_cliente_prueba) {
                                //Sino es cliente de prueba se envia la notificacion de Afiliaciones
                                $controll= new ContratacionVirtualController();

                                $controll->notificaContratacionRolAfiliaciones(
                                    $data->req_id,
                                    $candidato,
                                    $nuevo_estado->id,
                                    $requerimiento->cargo,
                                    $requerimiento->nombre_cliente,
                                    $requerimiento->sitio_trabajo,
                                    $firmaContrato->fecha_firma
                                );
                            }
                        }


                    } elseif ($data->tipo_documento_id == 13 || $data->tipo_documento_id == 14 || $data->tipo_documento_id == 12 || $data->tipo_documento_id == 17){
                        //Es una afiliacion
                        $req_can = ReqCandidato::where("requerimiento_id", $data->req_id)
                        ->where("candidato_id", $data->cand_id)
                        ->first();

                        if($req_can->contratacionCompleta()){
                            $req_can->estado_contratacion = 0;
                            $req_can->save();
                        }
                    }
                
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

    public function info_orden()
    {
        return view("admin.contratacion.modal.info_orden");
    }

    public function salud_ocupacional(Request $data)
    {
        $candidatos = OrdenMedica::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "orden_medica.req_can_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->join("ordenes_estados", "ordenes_estados.orden_id", "=", "orden_medica.id")
        ->whereRaw('ordenes_estados.id = (select max(ordenes_estados.id) from ordenes_estados where ordenes_estados.orden_id = orden_medica.id)')
        ->where("ordenes_estados.estado_id", 2)
        ->whereNull("orden_medica.especificacion")
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
        ->select(
            "orden_medica.*",
            "orden_medica.id as orden",
            "cargos_especificos.descripcion as cargo",
            "datos_basicos.nombres as candidato",
            "datos_basicos.primer_apellido",
            "datos_basicos.segundo_apellido",
            "requerimiento_cantidato.requerimiento_id as requerimiento",
            "datos_basicos.numero_id as numero_id"
        )
        ->orderBy("orden_medica.id", "DESC")
        ->get();

        return view("admin.contratacion.lista_salud_ocupacional-new", compact("candidatos"));
    }

    public function gestion_salud_ocupacional($orden)
    {
        $candidatos = OrdenMedica::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "orden_medica.req_can_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->join("proveedor", "proveedor.id", "=", "orden_medica.proveedor_id")
        ->where("orden_medica.id", $orden)
        ->select(
            "orden_medica.*",
            "orden_medica.id as orden",
            "cargos_especificos.descripcion as cargo",
            "datos_basicos.nombres as candidato",
            "requerimiento_cantidato.requerimiento_id as requerimiento",
            "datos_basicos.numero_id as numero_id",
            "proveedor.nombre as proveedor",
            "requerimiento_cantidato.id as req_can",
            "orden_medica.documento as documento"
        )
        ->orderBy("orden_medica.created_at", "DESC")
        ->first();

        $examenes = ExamenesMedicos::join('examen_medico', "examen_medico.id", "=", "examenes_medicos.examen")
        ->join("orden_medica", "orden_medica.id", "=", "examenes_medicos.orden_id")
        ->where("orden_medica.id", $orden)
        ->select(
            "orden_medica.id as orden",
            "examen_medico.nombre as nombre"
        )
        ->get();

        return view("admin.contratacion.gestion_salud_ocupacional", compact("candidatos","examenes"));
    }

    //Estudio de Seguridad
    public function cambiar_estado_salud(Request $request)
    {
        if($request->accion == 1){
            $orden = OrdenMedica::find($request->orden);
            //$orden->resultado = 1;
            $orden->especificacion = $request->especificaciones;
            $orden->save();

            $aptoproceso = RegistroProceso::where('requerimiento_candidato_id', $orden->req_can_id)
            ->where('proceso', 'ENVIO_EXAMENES')
            ->orderBy('created_at', 'DESC')
            ->first();

            $aptoproceso->apto = 1;
            $aptoproceso->observaciones = "Apto examenes médicos con recomendaciones";
            $aptoproceso->usuario_terminacion = $this->user->id;
            $aptoproceso->save();

            $estado = new EstadosOrdenes();
            $estado->fill([
                "orden_id" => $orden->id,
                "estado_id" => 3
            ]);
            $estado->save();

            $mensaje = "El candidato Continua";
        }
        else{
            $mensaje = "Se ha inhabilitado el candidato";
            $orden = OrdenMedica::find($request->orden);
            $orden->status = 0;
            $orden->save();

            $req_can = ReqCandidato::find($orden->req_can_id);

            $proceso = RegistroProceso::where('requerimiento_candidato_id', $orden->req_can_id)
            ->where('proceso', 'ENVIO_EXAMENES')
            ->orderBy('created_at', 'DESC')
            ->first();

            $proceso->apto = 2;
            $proceso->observaciones = "No apto examenes médicos. $request->especificaciones";
            $proceso->usuario_terminacion = $this->user->id;
            $proceso->save();
        }

        return response()->json(["success" => true, "mensaje" => $mensaje]);
    }

    public function ver_orden_contratacion(Request $request)
    {
        $fecha_hoy = date('j \d\e F \d\e Y');
    
        $req_can = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("centros_costos_produccion", "centros_costos_produccion.id", "=", "requerimientos.centro_costo_produccion")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
        ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->join("centros_trabajo", "centros_trabajo.id", "=", "requerimientos.ctra_x_clt_codigo")
        ->join('ciudad', function ($join) {
            $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
            ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
            ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
        })
        ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
        ->where("requerimiento_cantidato.id", $request->req_can)
        ->whereIn("procesos_candidato_req.proceso", ['ENVIO_CONTRATACION', 'ENVIO_CONTRATACION_CLIENTE'])
        ->select(
            "clientes.nit as cliente_nit",
            "clientes.nombre as cliente",
            "datos_basicos.nombres as nombres_candidato",
            "datos_basicos.primer_apellido as primer_apellido",
            "cargos_especificos.descripcion as cargo",
            "datos_basicos.numero_id as cedula",
            "requerimientos.salario as salario",
            "ciudad.nombre as ciudad",
            "procesos_candidato_req.fecha_inicio as fecha_inicio",
            "procesos_candidato_req.centro_costos as centro_costos_contratacion",
            "datos_basicos.telefono_movil as movil",
            "centros_costos_produccion.descripcion as centro_costo",
            "requerimientos.observaciones as observaciones",
            "procesos_candidato_req.created_at as fecha_envio_contratacion",
            "centros_trabajo.nombre_ctra as factor",
            "procesos_candidato_req.lugar_inicio as lugar_inicio",
            "procesos_candidato_req.lugar_contacto as lugar_contacto",
            "procesos_candidato_req.hora_entrada as hora_entrada",
            "procesos_candidato_req.otros_devengos as otros_devengos",
            "procesos_candidato_req.observaciones as observaciones",
            "procesos_candidato_req.fecha_ingreso_contra as fecha_ingreso_contra",
            DB::raw("(select nombres from datos_basicos where user_id=procesos_candidato_req.user_autorizacion) as user_autorizacion")
        )
        ->first();

        return view("admin.contratacion.modal.info_orden", compact("req_can", "fecha_hoy"));
    }

    public function ver_status_contratacion(Request $request)
    {
        $user_sesion = $this->user;

        $reqCandidato = RegistroProceso::leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
        ->where("procesos_candidato_req.requerimiento_candidato_id", $request->get("req_can"))
        ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
        ->leftjoin('entrevista_virtual', 'entrevista_virtual.req_id', '=', 'requerimientos.id')
        ->leftjoin('preguntas_entre', 'preguntas_entre.entre_vir_id', '=', 'entrevista_virtual.id')
        ->leftjoin('respuestas_entre', 'respuestas_entre.preg_entre_id', '=', 'preguntas_entre.id')
        ->leftjoin('motivos_anulacion', 'motivos_anulacion.id', '=', 'procesos_candidato_req.motivo_rechazo_id')
        ->select(
            "respuestas_entre.puntuacion as puntuacion",
            "motivos_rechazos.descripcion as des_motivo_rechazo",
            "motivos_anulacion.descripcion as motivo_anulacion",
            'procesos_candidato_req.requerimiento_candidato_id',
            'procesos_candidato_req.estado',
            'procesos_candidato_req.proceso',
            'procesos_candidato_req.fecha_inicio',
            'procesos_candidato_req.fecha_fin',
            'procesos_candidato_req.usuario_envio',
            'procesos_candidato_req.requerimiento_id',
            'procesos_candidato_req.candidato_id',
            'procesos_candidato_req.usuario_terminacion',
            'procesos_candidato_req.apto',
            'procesos_candidato_req.numero_contrato',
            'procesos_candidato_req.fecha_contrato',
            'procesos_candidato_req.fecha_inicio_contrato',
            'procesos_candidato_req.fecha_fin_contrato',
            'procesos_candidato_req.updated_at',
            'procesos_candidato_req.usuario_terminacion',
            'procesos_candidato_req.observaciones',
            'procesos_candidato_req.motivo_rechazo_id',
            'procesos_candidato_req.user_autorizacion'
        )
        ->orderBy("procesos_candidato_req.id", "asc")
        ->groupBy("procesos_candidato_req.id")
        ->get();        

        $documento_aprobacion = null;

        if (count($reqCandidato) > 0) {
            $documento_aprobacion = Documentos::where('user_id', $reqCandidato[0]->candidato_id)
                ->where('requerimiento', $reqCandidato[0]->requerimiento_id)
                ->where('tipo_documento_id', config('conf_aplicacion.C_SOPORTE_APROBACION_CLIENTE'))
                ->orderBy('id', 'desc')
            ->first();
        }

        $estadoCandidato = RegistroProceso::join("estados", "estados.id", "=", "procesos_candidato_req.estado")
        ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
        ->leftjoin('entrevistas_candidatos', 'entrevistas_candidatos.req_id', '=', 'requerimientos.id')
        ->select('procesos_candidato_req.proceso as nombre_proceso', 'entrevistas_candidatos.asistio as asis', "procesos_candidato_req.created_at", "procesos_candidato_req.usuario_envio", "estados.descripcion as estado_desc")
        ->where("procesos_candidato_req.requerimiento_candidato_id", $request->get("req_can"))
        ->where("procesos_candidato_req.proceso",'<>',"")
        ->groupBy("estados.descripcion", "procesos_candidato_req.created_at", "procesos_candidato_req.usuario_envio")
        ->orderBy("procesos_candidato_req.created_at", "desc")
        ->get();

        $asistencia = EntrevistaCandidatos::join('requerimientos', 'requerimientos.id', '=', 'entrevistas_candidatos.req_id')
        ->select('entrevistas_candidatos.asistio as asis')
        ->where("entrevistas_candidatos.candidato_id", $request->get("user_id"))
        ->where("entrevistas_candidatos.req_id", $request->get("requerimiento"))
        ->get();
        
        $factor = null;

        //Promedio de respuesta para prueba idioma
        $selectRespuestas =  PreguntasPruebaIdioma::join('pruebas_idiomas', 'pruebas_idiomas.id', '=', 'preguntas_pruebas_idiomas.prueba_idio_id')
        ->join('respuestas_pruebas_idiomas', 'respuestas_pruebas_idiomas.preg_prueba_id', '=', 'preguntas_pruebas_idiomas.id')
        ->where('candidato_id', $request->get("user_id"))
        ->select('respuestas_pruebas_idiomas.puntuacion')
        ->get();
        
        $cantidad = count($selectRespuestas);

        $promedioIdio = null;
        $sumaPoints = null;
        if($cantidad >= 1){
            foreach ($selectRespuestas as $key => $value) {
                $sumaPoints = $sumaPoints + $value->puntuacion;
            }
            $promedioIdio = $sumaPoints / $cantidad;
        }

        //Módulo
        $sitioModulo = SitioModulo::first();

        if($sitioModulo->consulta_seguridad === 'enabled') {
            $factor = ConsultaSeguridad::where('user_id', $request->get("user_id"))
            ->where('req_id', $request->get("requerimiento"))
            ->first();
        }

        //Busca contrato
        $firma_contrato = FirmaContratos::where('user_id', $request->get("user_id"))
        ->where('req_id', $request->get("requerimiento"))
        ->orderBy('created_at', 'DESC')
        ->first();

        $datos_status_candidato = null;
        $datos_status_gestion = null;
        if ($firma_contrato != null) {
            $datos_status_candidato = DatosBasicos::where('user_id', $request->get("user_id"))->first();
            $datos_status_gestion = DatosBasicos::where('user_id', $firma_contrato->gestion)->first();
        }

        $observacion_hv = ObservacionesHv::join('users', 'users.id', '=', 'observaciones_hoja_vida.user_gestion')
        ->select('observaciones_hoja_vida.*', 'users.name as nombre')
        ->where('candidato_id', $request->get("user_id"))
        ->orderBy("observaciones_hoja_vida.id", "DESC")
        ->take(3)
        ->get();

        //Token de acceso a la firma
        $token_firma = RegistroProceso::where('requerimiento_id', $request->get("requerimiento"))
        ->where('candidato_id', $request->get("user_id"))
        ->whereNotNull('codigo_validacion')
        ->select('codigo_validacion')
        ->orderBy('created_at', 'DESC')
        ->first();

        $candidato_id = $request->get("user_id");
        $req_id = $request->get("requerimiento");

        if (route("home") == "https://vym.t3rsc.co" || route("home") == "https://listos.t3rsc.co") {
            //Buscar detalle de la consulta en truora
            $checkTruoraDetail = TruoraIntegrationController::getCheckDetails($request->get("user_id"), $request->get("requerimiento"));

            if (!empty($checkTruoraDetail)) {
                $generated_check = $checkTruoraDetail['check']['check_id'];
                $generated_puntaje = $checkTruoraDetail['check']['score'];
                $generated_status = $checkTruoraDetail['check']['status'];
                $generated_score = $generated_puntaje * 100;

                return view("admin.contratacion.modal.status_contratacion", compact(
                    "factor",
                    "user_sesion",
                    "reqCandidato",
                    "estadoCandidato",
                    "asistencia",
                    "promedioIdio",
                    "generated_check",
                    "generated_score",
                    "generated_status",
                    "firma_contrato",
                    "datos_status_candidato",
                    "datos_status_gestion",
                    "documento_aprobacion",
                    "token_firma",
                    "candidato_id",
                    "req_id",
                    "sitioModulo"
                ));
            }
        }

        //return view("admin.contratacion.modal.status_contratacion", compact(
        return view("admin.reclutamiento.modal._modal_seguimiento_candidato", compact(
            "factor",
            "user_sesion",
            "reqCandidato",
            "estadoCandidato",
            "asistencia",
            "promedioIdio",
            "firma_contrato",
            "datos_status_candidato",
            "datos_status_gestion",
            "documento_aprobacion",
            "token_firma",
            "candidato_id",
            "req_id",
            "sitioModulo",
            "observacion_hv"
        ));
    }

    public function confirmar_contratacion(Request $data)
    {
        $req_cand = $data->candidato_req;
        $req_candidato = ReqCandidato::find( $req_cand);
        $candidato = $req_candidato->candidato_id;
        $req = $req_candidato->requerimiento_id;

        $requerimiento = Requerimiento::find($data->req);

        $datos_basicos = DatosBasicos::leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
                    ->where("user_id", $candidato)
                    ->select(
                        "datos_basicos.numero_id",
                        "datos_basicos.nombres",
                        "datos_basicos.primer_apellido",
                        "datos_basicos.segundo_apellido",
                        "tipo_identificacion.cod_tipo")
                    ->first();

        //dividir documentos en dos
        $tipo_documento = TipoDocumento::leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("users", "users.id", "=", "documentos.user_id")
        ->where("categoria", 2)
        //->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
        ->where('documentos.requerimiento', $req_candidato->requerimiento_id)
        ->where('documentos.user_id', $req_candidato->candidato_id)
        ->select(
           "tipos_documentos.id as id",
           "tipos_documentos.descripcion as descripcion",
           DB::raw("(select documentos.nombre_archivo from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id desc limit 1) as nombre")
        )
        ->orderBy("id")
        ->groupBy("id")
        ->get(); // de contratacion

        $documentos_cargo = DocumentosCargo::where('cargo_especifico_id', '=', $requerimiento->cargo_especifico_id)->get();

         //de seleccion
        $documento_seleccion = TipoDocumento::leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("users", "users.id", "=", "documentos.user_id")
        ->where("categoria", 1)
        //->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
        //->where('documentos.requerimiento', $req_candidato->requerimiento_id)
        ->where('documentos.user_id', $req_candidato->candidato_id)
        ->select(
           "tipos_documentos.id as id",
           "tipos_documentos.descripcion as descripcion",
           DB::raw("(select documentos.nombre_archivo from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req order by documentos.id desc limit 1) as nombre")
        )
        ->orderBy("id")
        ->groupBy("id")
        ->get(); // de seleccion

        //falta seleccion
        //Busca contrato
        $firmaContrato = FirmaContratos::where('user_id', $data->user_id)
        ->where('req_id', $requerimiento->id)
        ->where('estado', 1)
        ->orderBy('created_at', 'DESC')
        ->first();

        $user_id = $data->user_id;

        return view("admin.contratacion.modal.confirmacion_contratacion", compact("tipo_documento", "req_cand", "firmaContrato","documento_seleccion", "user_id", "documentos_cargo", "datos_basicos"));
    }
    
    public function envio_documentos_contratacion(Request $data)
    {
        $cand_req = $data->cand_req;
        $observacion = $data->observacion_envio_contratacion;
        $candidato_email = '';

        $candidato_req = ReqCandidato::find($cand_req);
        $user = User::find($candidato_req->candidato_id);
        $candidato = $candidato_req->candidato_id;
        $req = $candidato_req->requerimiento_id;

        $archivos_generador = [];
        $archivos = collect([]);
        $archivos_seleccion = null;
        $archivos_contratacion = null;

        if ($data->documentos != null) {
            //Buscar los documentos cargados por el usuario
            $archivos_totales = TipoDocumento::leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
            ->whereIn('documentos.tipo_documento_id', $data->documentos)
            ->whereNotIn('documentos.tipo_documento_id', [16])
            ->where('documentos.user_id', $user->id)
            ->select(
               "tipos_documentos.id as id",
               "tipos_documentos.descripcion as descripcion",
               "tipos_documentos.categoria",
               "documentos.nombre_archivo as nombre",
               "documentos.requerimiento",
               "documentos.created_at"
            )
            ->orderBy("created_at", "desc")
            ->groupBy("created_at")
            ->get(); // de contratacion

            $archivos_seleccion = $archivos_totales->where('categoria', 1);

            $archivos_contratacion = $archivos_totales->where('categoria', 2)->where('requerimiento', $req);

            $docs_cat2 = Documentos::select('nombre_archivo as nombre', 'id as id_documento','tipo_documento_id')->where('user_id', $candidato)->where('requerimiento', $req)->latest('id')->get();

            foreach ($archivos_contratacion as $key => &$tipo_doc) {
                $tipo_doc->documentos = $docs_cat2->filter(function ($value) use ($tipo_doc){
                    return $value->tipo_documento_id==$tipo_doc->id;
                });
            }
            unset($tipo_doc);

            /*foreach ($data->documentos as $id) {
                $archivos->push($archivos_totales->where('id', $id)->first());
            }*/
            //$archivos = archivos_totales;
        }

        //buscando el tipo de documento del contrato
        $archivo_documento_contratacion = null;

        if ( $data->documentos != null && in_array(16, $data->documentos) ) {

            $archivo_documento_contratacion = TipoDocumento::leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
            ->where('documentos.tipo_documento_id', 16)
            ->where('documentos.user_id', $user->id)
            ->where('documentos.requerimiento', $req)
            ->select(
               "tipos_documentos.id as id",
               "tipos_documentos.descripcion as descripcion",
               "tipos_documentos.categoria",
               "documentos.nombre_archivo as nombre",
               "documentos.requerimiento",
               "documentos.created_at"
            )
            ->orderBy("created_at", "desc")
            ->groupBy("created_at")
            ->first();

        }

        $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes",  "clientes.id", "=", "negocio.cliente_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->where("requerimientos.id", $candidato_req->requerimiento_id)
        ->select(
            "clientes.nombre as nombre_cliente",
            "clientes.direccion as direccion_cliente",
            "clientes.contacto as contacto_cliente",
            "clientes.correo as correo",
            "cargos_especificos.descripcion as cargo",
            "requerimientos.id as requerimiento",
            "requerimientos.salario",
            "requerimientos.ctra_x_clt_codigo",
            //"requerimientos.solicitado_por as solicitado_por",
            "requerimientos.empresa_contrata"
        )
        ->orderBy('requerimientos.created_at', 'DESC')
        ->first();

        $datos_basicos = RequerimientoContratoCandidato::join("users", "users.id", "=", "requerimiento_contrato_candidato.candidato_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
        ->leftJoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
        ->leftJoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
        ->leftJoin("fondo_cesantias", "fondo_cesantias.id", "=", "requerimiento_contrato_candidato.fondo_cesantia_id")
        ->leftJoin("caja_compensacion", "caja_compensacion.id", "=", "requerimiento_contrato_candidato.caja_compensacion_id")
        ->leftJoin("bancos", "bancos.id", "=", "requerimiento_contrato_candidato.nombre_banco")
        ->where("requerimiento_contrato_candidato.requerimiento_id", $req)
        ->where("requerimiento_contrato_candidato.candidato_id", $user->id)
        //->whereRaw('requerimiento_contrato_candidato.id=(select max(requerimiento_contrato_candidato.id) from requerimiento_contrato_candidato where requerimiento_contrato_candidato.candidato_id=users.id)')
        //->whereIn('procesos_candidato_req.proceso',['ENVIO_CONTRATACION'])
        ->select(
            "datos_basicos.*",
            "tipo_identificacion.descripcion as dec_tipo_doc",
            "entidades_afp.descripcion as entidades_afp_des",
            "entidades_eps.descripcion as entidades_eps_des",
            "fondo_cesantias.descripcion as fondo_cesantia_des",
            "caja_compensacion.descripcion as caja_compensacion_des",
            "bancos.nombre_banco as nombre_banco_des",
            "requerimiento_contrato_candidato.fecha_ingreso as fecha_inicio_contrato",
            "requerimiento_contrato_candidato.fecha_ultimo_contrato",
            "requerimiento_contrato_candidato.hora_ingreso as hora_entrada",
            "requerimiento_contrato_candidato.fecha_ingreso as fecha_ingreso_contra",
            "requerimiento_contrato_candidato.fecha_fin_contrato",
            'requerimiento_contrato_candidato.auxilio_transporte',
            'requerimiento_contrato_candidato.tipo_ingreso',
            'requerimiento_contrato_candidato.user_gestiono_id'
        )
        ->orderBy("requerimiento_contrato_candidato.id", "desc")
        ->groupBy('users.id')
        ->first();

        //$solicitado_por = User::find($requerimiento->solicitado_por);
        $quien_confirma = User::find($this->user->id);
        $quien_envio_contratar = DatosBasicos::select('email')->where('user_id', $datos_basicos->user_gestiono_id)->first();

        $firmaContrato = FirmaContratos::find($data->contrato);

        $tipo_correo = 'cliente';
        $pdf = null;

        $destinatarios = '';
        $enviado_cliente = 0;
        $enviado_candidato = 0;
        $emails_clientes = [];

        //Preparar carnet del candidato
        if ($data->carnet != null) {
            $candidato_carnet = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->join("users","users.id","=","datos_basicos.user_id")
                ->join('procesos_candidato_req','procesos_candidato_req.requerimiento_candidato_id','=','requerimiento_cantidato.id')
                ->where("datos_basicos.user_id", $user->id)
                ->where('procesos_candidato_req.proceso','ENVIO_CONTRATACION')
                ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato","requerimiento_cantidato.requerimiento_id as req","users.foto_perfil","users.avatar","procesos_candidato_req.fecha_inicio_contrato")
                ->orderBy("requerimiento_cantidato.id","DESC")
                ->first();
        
            $contrato_carnet = "";
              
            $req_carnet = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
                ->leftjoin("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
                ->select(
                    "cargos_especificos.descripcion as cargo",
                    "requerimientos.id",
                    "tipo_proceso.descripcion as tipo_proceso_desc",
                    "negocio.num_negocio",
                    "requerimientos.cargo_especifico_id",
                    "requerimientos.empresa_contrata",
                    "clientes.nit",
                    "clientes.nombre as nombre_cliente",
                    "requerimientos.id as req_id")
                ->groupBy('requerimientos.id')->find($candidato_carnet->req);

                //empresa contrata aqui
            $empresa_carnet = '';

            if($req_carnet->empresa_contrata){

                $empresa_carnet = DB::table("empresa_logos")->where('id', $req_carnet->empresa_contrata)->first();
            }
              //  $motivos = ["" => "Seleccionar"] + MotivosRechazos::pluck("descripcion", "id")->toArray();
            /* para codigo QR */
            $qrcode = base64_encode(\QrCode::format('png')->size(200)->errorCorrection('H')->generate(route('informacionTrabajador', ['id' => $id])));
              
            $pdf =  app('dompdf.wrapper');
            $pdf->loadHTML(view("home.carnet_candidato", [
                'candidato' => $candidato_carnet,
                'req' => $req_carnet,
                'contrato' => $contrato_carnet,
                'empresa' => $empresa_carnet,
                'qrcode'  => $qrcode
            ]));
        }
        //Fin de preparacion del candidato

        //Se envia a otros destinatarios
        if($data->otro_destinatario != null || $data->otro_destinatario != ''){
            $destinatarios = str_replace(' ', '', $data->otro_destinatario);
            $otro_destino =  explode(",",$destinatarios);
            //agregar tambien el cliente
            Mail::send('admin.contratacion.mail.email-documentos-contratacion-cliente', [
                "requerimiento"  => $requerimiento,
                "archivos_generados" => $archivos_generador,
                "archivos_seleccion" => $archivos_seleccion,
                "archivos_contratacion" => $archivos_contratacion,
                "archivos"       => $archivos_totales,
                "archivo_documento_contratacion" => $archivo_documento_contratacion,
                "candidato"      => $datos_basicos,
                "user"           => $user,
                "tipo_correo"    => $tipo_correo,
                "observacion"    => $observacion,
                "quien_confirma" => $quien_confirma,
                "contrato"       => $firmaContrato,
                "cand_req"       => $cand_req
            ], function ($message) use($otro_destino, $requerimiento, $pdf){
                if ($pdf != null) {
                    $message->attachData($pdf->output(),'carnet.pdf');
                }
                $message->to($otro_destino,"T3RS")->subject("Confirmación documentos contratación REQ #$requerimiento->requerimiento")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }

        //Siempre se enviara al usuario que solicito contratar al candidato
        if($quien_envio_contratar->email != "" && $quien_envio_contratar->email != null){
            Mail::send('admin.contratacion.mail.email-documentos-contratacion-cliente', [
                "requerimiento"  => $requerimiento,
                "archivos_generados" => $archivos_generador,
                "archivos_seleccion" => $archivos_seleccion,
                "archivos_contratacion" => $archivos_contratacion,
                "archivos"       => $archivos_totales,
                "archivo_documento_contratacion" => $archivo_documento_contratacion,
                "candidato"      => $datos_basicos,
                "user"           => $user,
                "tipo_correo"    => $tipo_correo,
                "observacion"    => $observacion,
                "quien_confirma" => $quien_confirma,
                "contrato"       => $firmaContrato,
                "cand_req"       => $cand_req
            ], function ($message) use($quien_envio_contratar, $requerimiento, $pdf){
                if ($pdf != null) {
                    $message->attachData($pdf->output(),'carnet.pdf');
                }
                $message->to($quien_envio_contratar->email,"T3RS")->subject("Confirmación documentos contratación REQ #$requerimiento->requerimiento")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }

        //Si esta seleccionado el check de Cliente, se envia al o los clientes.
        if(isset($data->cliente) && $data->cliente == 'true') {
            $enviado_cliente = 1;
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->where("requerimiento_cantidato.id", $cand_req)
                ->select( "datos_basicos.*","requerimiento_cantidato.id as req_candidato",
                "clientes.id as cliente")
                ->first();

            $usuarios_clientes = User::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
                ->join("role_users", "role_users.user_id", "=", "users.id")
                ->where("role_users.role_id",3)
                ->where("users.estado",1)
                ->where("users_x_clientes.cliente_id", $candidato->cliente)
                ->select("users.name", "users.email")
                ->get();

            if($usuarios_clientes != "" ){
             
                foreach ($usuarios_clientes  as $clientes) {
                    $emails_clientes[] = $clientes->email;

                    Mail::send('admin.contratacion.mail.email-documentos-contratacion-cliente', [
                        "requerimiento"  => $requerimiento,
                        "archivos_generados" => $archivos_generador,
                        "archivos_seleccion" => $archivos_seleccion,
                        "archivos_contratacion" => $archivos_contratacion,
                        "archivos"       => $archivos_totales,
                        "archivo_documento_contratacion" => $archivo_documento_contratacion,
                        "candidato"      => $datos_basicos,
                        "user"           => $user,
                        "tipo_correo"    => $tipo_correo,
                        "observacion"    => $observacion,
                        "quien_confirma" => $quien_confirma,
                        "contrato"       => $firmaContrato,
                        "cand_req"       => $cand_req
                    ], function ($message) use($clientes, $requerimiento){
                        $message->to($clientes->email,"T3RS")->subject("Confirmación documentos contratación REQ #$requerimiento->requerimiento")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                }
            }
        }

        //Si esta seleccionado el check de Candidato, se envia al candidato.
        if(isset($data->candidato) && $data->candidato == 'true' && isset($user->email)) {
            $tipo_correo = 'candidato';
            $enviado_candidato = 1;
            $empresa = '';
            if($requerimiento->empresa_contrata != null){
                $empresa = DB::table("empresa_logos")->where('id', $requerimiento->empresa_contrata)->first();
            }

            Mail::send('admin.contratacion.mail.email-documentos-contratacion-cliente', [
                "requerimiento"  => $requerimiento,
                "archivos_generados" => $archivos_generador,
                "archivos_seleccion" => $archivos_seleccion,
                "archivos_contratacion" => $archivos_contratacion,
                "archivos"       => $archivos_totales,
                "archivo_documento_contratacion" => $archivo_documento_contratacion,
                "candidato"      => $datos_basicos,
                "user"           => $user,
                "tipo_correo"    => $tipo_correo,
                "observacion"    => $observacion,
                "quien_confirma" => $quien_confirma,
                "contrato"       => $firmaContrato,
                "cand_req"       => $cand_req,
                "empresa"        => $empresa
            ], function ($message) use($user, $requerimiento, $pdf){
                if ($pdf != null) {
                    $message->attachData($pdf->output(),'carnet.pdf');
                }
                $message->to($user->email,"T3RS")->subject("🎉 $user->name, bienvenida/o a nuestra Familia 👏")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
            $candidato_email = $user->email;
        }

        $emails_clientes_string = implode(',', $emails_clientes);

        $this->guardar_datos_envio_emails($enviado_cliente, $enviado_candidato, $user->id, $req, $this->user->id, $data->cand_req, $candidato_email, $emails_clientes_string, $destinatarios);

        return response()->json(["success" => true,"correos"=>$usuarios_clientes,"otros"=>$data->otro_destinatario,"candidato_email"=>$candidato_email]);
    }

    protected function guardar_datos_envio_emails($enviado_cliente, $enviado_candidato, $candidato_id, $req_id, $quien_confirma_id, $cand_req_id, $email_candidato, $emails_clientes, $otros_emails) {

        $data_email_enviados = new DataEmailEnviados();
        $data_email_enviados->fill([
            'enviado_cliente' => $enviado_cliente,
            'enviado_candidato' => $enviado_candidato,
            'requerimiento_id' => $req_id,
            'candidato_id' => $candidato_id,
            'email_candidato' => $email_candidato,
            'emails_clientes' => $emails_clientes,
            'quien_confirma_id' => $quien_confirma_id,
            'candidato_requerimiento_id' => $cand_req_id,
            'otros_emails' => $otros_emails,
        ]);

        $data_email_enviados->save();
    }

    public function finalizar_contratacion(Request $data)
    {
        $req_cand = ReqCandidato::find($data->dato);
        $req_cand->estado_contratacion = 0;
        $req_cand->estado_candidato = 23;
        $req_cand->save();

        return response()->json(["success" => true]);
    }

    public function confirmacion_asisntecia_contratacion(Request $data)
    {
        $proceso = RegistroProceso::find($data->proceso);

        if($data->respuesta == "si"){
            $proceso->asistira = "1";
        }else{
            $proceso->asistira = "0";
        }

        $proceso->save();

        return response()->json(["success" => true]);
    }

    public function cambiar_estado_asistencia(Request $data)
    {
        $proceso = $data->proceso;
        $respuesta = $data->respuesta;

        return view("admin.contratacion.modal.cambio_estado_asistencia", compact("proceso", "respuesta"));
    }

    public function confirmar_cambio_estado_asistencia(Request $data)
    {
        $proceso = RegistroProceso::find($data->proceso);
        $proceso->asistira = 1;
        $proceso->save();

        return response()->json(["success" => true]);
    }

    public function cancelar_contratacion(Request $data)
    {
        $req_id = $data->req;
        $req_can = ReqCandidato::find($data->dato);
        $candidato = DatosBasicos::where("user_id", $req_can->candidato_id)->first();

        $motivos = ["" => "Seleccione"] + MotivosCancelacionContratacion::pluck("descripcion", "id")->toArray();
        
        return view("admin.contratacion.modal.cancelar_contratacion", compact("candidato", "req_can", "motivos", "req_id"));
    }

    public function confirmar_cancelar_contratacion(Request $data)
    {
        $req_can = ReqCandidato::find($data->req_can);
        $motivo_desc = MotivosCancelacionContratacion::where('id', $data->motivo)->first();

        //Actualiza firma de contrato
        $firma_contrato = FirmaContratos::where('user_id', $req_can->candidato_id)
        ->where('req_id', $data->req_id)
        ->orderBy('created_at', 'DESC')
        ->first();

        $firma_contrato->terminado = 0; //Cancelado
        $firma_contrato->gestion = $this->user->id;
        $firma_contrato->save();

        //Crear registro de cancelación
        $contrato_cancelado = new ContratoCancelado();
        $contrato_cancelado->fill([
            'user_id' => $req_can->candidato_id,
            'req_id' => $data->req_id,
            'contrato_id' => $firma_contrato->id,
            'observacion' => "$motivo_desc->descripcion - Cancelado desde (Módulo admin)",
            'ip' => $data->ip(),
        ]);
        $contrato_cancelado->save();

        //Cambia estado del proceso del candidato
        $aptoProceso = RegistroProceso::where('requerimiento_id', $data->req_id)
        ->where('candidato_id', $req_can->candidato_id)
        ->where('proceso', 'ENVIO_CONTRATACION')
        ->orderby('created_at', 'DESC')
        ->first();

        $aptoProceso->apto = 0;
        $aptoProceso->save();

        //Crea nuevo estado
        $nuevo_estado = ReqCandidato::where("requerimiento_id", $data->req_id)
        ->where("candidato_id", $req_can->candidato_id)
        ->orderBy("id", "DESC")
        ->first();

        $nuevo_estado->estado_candidato = 24;
        $nuevo_estado->save();

        //Crea nuevo proceso
        $nuevo_proceso = new RegistroProceso();
        $nuevo_proceso->fill([
            'requerimiento_candidato_id' => $nuevo_estado->id,
            'estado'                     => config('conf_aplicacion.C_CONTRATACION_CANCELADA'),
            'fecha_inicio'               => date("Y-m-d H:i:s"),
            'usuario_envio'              => $this->user->id,
            'requerimiento_id'           => $data->req_id,
            'candidato_id'               => $req_can->candidato_id,
            'observaciones'              => "$motivo_desc->descripcion - Cancelado desde (Módulo admin)",
            'proceso'                    => "CANCELA_CONTRATACION",
            'apto'                       => 1
        ]);
        $nuevo_proceso->save();

        return response()->json(["success" => true]);
    }

    public function descargar_archivo($folder, $file)
    {
        
        $ext = pathinfo($file, PATHINFO_EXTENSION);

        header("Content-disposition: attachment; filename=$file");
        header("Content-type: application/$ext");
        $folder=str_replace("|","/",$folder);
        readfile($folder .'/'. $file);
    }

    public function cerrar_carpetas(Request $request)
    {
        $req_can = ReqCandidato::find($request->get("req_can"));
        $req_can->cerrar_carpetas_asistente();
        $requerimiento = Requerimiento::find($req_can->requerimiento_id);

        $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
        ->leftjoin("users", "users.id", "=", "documentos.user_id")
        ->where("categoria", 1)
        ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
        ->select(
            "tipos_documentos.id as id",
            "tipos_documentos.descripcion as descripcion",
            DB::raw("(select documentos.nombre_archivo from documentos where user_id=$req_can->candidato_id and documentos.tipo_documento_id=tipos_documentos.id order by documentos.id desc limit 1) as nombre")
        )
        ->orderBy("id")
        ->groupBy("id")
        ->get();

        //crear carpeta contratacion
        $carpeta_seleccion=new CarpetaContratacion();
        $carpeta_seleccion->categoria_id=1;
        $carpeta_seleccion->user_gestion=$this->user->id;
        $carpeta_seleccion->req_can_id=$req_can->id;
        $carpeta_seleccion->save();

        //Guardar documentos en carpeta
        foreach($tipo_documento as $tipo){
            $documento = new DocumentoCarpetaContratacion();
            $documento->tipo_documento_id = $tipo->id;
            $documento->carpeta_id = $carpeta_seleccion->id;
            $documento->nombre_documento = $tipo->nombre;
            $documento->save();
        }

        return response()->json(["success"=>true]);
    }

    /*Enviar a pre-contratar modal*/
    public function pre_contratar_view(Request $data)
    {
        $candi_no_cumplen = collect([]);
        $candidatos = collect([]);

        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $data->candidato_req)
            ->select(
                "datos_basicos.*",
                "requerimiento_cantidato.id as req_candidato",
                "requerimiento_cantidato.requerimiento_id as req"
            )
        ->first();

        if ($candidato->tipo_id == null || $candidato->direccion == null || $candidato->entidad_eps == null || $candidato->entidad_afp == null ||
            $candidato->fecha_expedicion == null || $candidato->fecha_nacimiento == null || $candidato->ciudad_expedicion_id == null) {
            $candidato->observacion_no_cumple = ['tipo' => 1, 'descripcion' => 'Faltan datos.'];
            $candi_no_cumplen->push($candidato);
            $candidato = null;
        } else {
            $proceso_precontrato = RegistroProceso::where("requerimiento_candidato_id", $data->candidato_req)
                ->whereIn("proceso", ["PRE_CONTRATAR", "ENVIO_CONTRATACION"])
            ->first();

            if ($proceso_precontrato != null) {
                $candidato->observacion_no_cumple = ['tipo' => 2, 'descripcion' => 'Se encuentra en proceso de contratación.'];
                $candi_no_cumplen->push($candidato);
                $candidato = null;
            } else {

                // ---- Si se puede enviar a Pre-contratar ----
                /*Se buscan los documentos cargados por el candidato, segun el cargo en especifico; para verificar
                si cargo 100% de los documentos solicitados por el cargo.*/
                $columnas_datos = DB::select('SELECT tipos_documentos.id as id, tipos_documentos.descripcion as descripcion FROM requerimientos LEFT JOIN cargo_documento on cargo_documento.cargo_especifico_id = requerimientos.cargo_especifico_id INNER JOIN tipos_documentos on tipos_documentos.estado = 1 and tipos_documentos.categoria = 1 and tipos_documentos.id = cargo_documento.tipo_documento_id WHERE requerimientos.id = ? ORDER BY tipos_documentos.id ASC', [$candidato->req]);
                $total_documentos = count($columnas_datos);
                $cant_doc_cargados = 0;

                $doc_candidato = Documentos::where('user_id', $candidato->user_id)
                ->where(function($query) use ($candidato)
                    {
                        $query->where('requerimiento', $candidato->req)
                              ->orWhereNull('requerimiento');
                    })
                ->select("nombre_archivo", "tipo_documento_id")
                ->orderBy('created_at', 'desc')
                ->get();

                $candidato["porcentaje"] = 0;
                foreach ($columnas_datos as $tipo_doc) {
                    $documentos = [
                        'id' => $tipo_doc->id,
                        'descripcion' => $tipo_doc->descripcion,
                        'documentos' => $doc_candidato->where('tipo_documento_id', $tipo_doc->id)->take(1)
                    ];
                    if (count($documentos['documentos']) > 0) {
                        $cant_doc_cargados++;
                    }
                }
                if($cant_doc_cargados == $total_documentos) {
                    $candidato["porcentaje"] = 100;
                } else {
                    if ($total_documentos > 0) {
                        $candidato["porcentaje"] = round($cant_doc_cargados * 100 / $total_documentos, 2);
                    }
                }

            }
        }

        return response()->json([
            "success" => true,
            "view"   => view("admin.reclutamiento.modal.envio_pre_contratar", compact('candidato', 'candi_no_cumplen'))->render()
        ]);
    }

    /*Confirmar pre-contratación*/
    public function pre_contratar(Request $data)
    {
        $req_candi_id = $data->candidato_req;
        
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $req_candi_id)
            ->select(
                "datos_basicos.email",
                "datos_basicos.nombres",
                "datos_basicos.user_id",
                "datos_basicos.numero_id",
                "datos_basicos.primer_apellido",
                "datos_basicos.segundo_apellido",
                "requerimiento_cantidato.id as req_candidato",
                "requerimiento_cantidato.requerimiento_id as req_id"
            )
        ->first();

        $requerimiento = Requerimiento::join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->where("requerimientos.id", $candidato->req_id)
            ->select(
                "requerimientos.num_vacantes",
                "clientes.id as cliente",
                "cargos_especificos.descripcion as cargo"
            )
        ->first();

        $nuevo_proceso = new RegistroProceso();
        $nuevo_proceso->fill([
            'requerimiento_candidato_id' => $req_candi_id,
            'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            'usuario_envio'              => $this->user->id,
            'requerimiento_id'           => $candidato->req_id,
            'candidato_id'               => $candidato->user_id,
            'observaciones'              => "Envío a pre-contratar",
            'proceso'                    => "PRE_CONTRATAR"
        ]);
        $nuevo_proceso->save();

        $emails = emails_rol_cliente_agencia($candidato->req_id, [19]);

        $UserEnvio = DatosBasicos::select('email')->where('user_id', $this->user->id)->first();

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Notificación de pre - contratación en Req No. $candidato->req_id"; //Titulo o tema del correo

        $ruta = route('admin.asistente_contratacion');

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = 'Hola, <br/><br/>
                    Te informamos que el candidato '.$candidato->nombres.' '.$candidato->primer_apellido.' '.$candidato->segundo_apellido.' con número de identificación '.$candidato->numero_id.', ha sido enviado a pre contratar en el requerimiento '.$candidato->req_id.' para el cargo '.$requerimiento->cargo.', puedes consultar en el asistente de contratación a través del siguiente botón.';

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'Asistente de contratación', 'buttonRoute' => $ruta];

        $mailUser = $candidato->user_id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);
        
        $existe = false;
        foreach($emails as $key => $value){
            if ($value->email == $UserEnvio->email) {
                $existe = true;
            }
            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($value, $requerimiento, $candidato) {

                    $message->to([
                        $value->email
                    ], "T3RS")
                    ->subject("Pre - contratación (# $candidato->req_id - $requerimiento->cargo)")
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

        }

        if ($existe == false) {
            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($UserEnvio, $requerimiento, $candidato) {

                $message->to($UserEnvio->email)
                ->subject("Pre - contratación (No. $candidato->req_id - $requerimiento->cargo)")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }


        return response()->json([
            "success" => true
        ]);
    }

    /*Enviar a pre-contratar modal masivo*/
    public function pre_contratar_masivo_view(Request $data)
    {
        $req_can_id = [];
        $candi_no_cumplen = collect([]);
        $candidatos = collect([]);

        foreach($data->req_candidato as $key => $req_candi_id) {
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->where("requerimiento_cantidato.id", $req_candi_id)
                ->select(
                    "datos_basicos.*",
                    "requerimiento_cantidato.id as req_candidato",
                    "requerimiento_cantidato.requerimiento_id as req"
                )
            ->first();

            if ($candidato->tipo_id == null || $candidato->direccion == null || $candidato->entidad_eps == null || $candidato->entidad_afp == null ||
                $candidato->fecha_expedicion == null || $candidato->fecha_nacimiento == null || $candidato->ciudad_expedicion_id == null) {
                $candi_no_cumplen->push($candidato);
            } else {
                array_push($req_can_id, $candidato->req_candidato);
                $candidatos->push($candidato);
            }
        }
        $req_can_id_j = json_encode($req_can_id);

        return response()->json([
            "success" => true,
            "view"   => view("admin.reclutamiento.modal.envio_pre_contratar_masivo", compact('candidatos', 'candi_no_cumplen', 'req_can_id_j'))->render()
        ]);
    }

    /*Confirmar pre-contratación masiva*/
    public function pre_contratar_masivo(Request $data)
    {
        $candidatos_no_precontratados = [];
        foreach(json_decode($data->candidato_req) as $key => $req_candi_id) {
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->where("requerimiento_cantidato.id", $req_candi_id)
                ->select(
                    "datos_basicos.email",
                    "datos_basicos.nombres",
                    "datos_basicos.user_id",
                    "datos_basicos.numero_id",
                    "datos_basicos.primer_apellido",
                    "datos_basicos.segundo_apellido",
                    "requerimiento_cantidato.id as req_candidato",
                    "requerimiento_cantidato.requerimiento_id as req_id"
                )
            ->first();

            $proceso_precontrato = RegistroProceso::where("requerimiento_candidato_id", $req_candi_id)
                ->whereIn("proceso", ["PRE_CONTRATAR", "ENVIO_CONTRATACION"])
            ->first();

            if ($proceso_precontrato != null) {
                array_push($candidatos_no_precontratados, "$candidato->numero_id $candidato->nombres");
            } else {
                $requerimiento = Requerimiento::join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                    ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                    ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                    ->where("requerimientos.id", $candidato->req_id)
                    ->select(
                        "requerimientos.num_vacantes",
                        "clientes.id as cliente",
                        "cargos_especificos.descripcion as cargo"
                    )
                ->first();

                $nuevo_proceso = new RegistroProceso();
                $nuevo_proceso->fill([
                    'requerimiento_candidato_id' => $req_candi_id,
                    'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                    'usuario_envio'              => $this->user->id,
                    'requerimiento_id'           => $candidato->req_id,
                    'candidato_id'               => $candidato->user_id,
                    'observaciones'              => "Envío a pre-contratar",
                    'proceso'                    => "PRE_CONTRATAR"
                ]);
                $nuevo_proceso->save();

                $emails = emails_rol_cliente_agencia($candidato->req_id, [19]);

                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                $mailTitle = "Notificación de pre - contratación en Req No. $candidato->req_id"; //Titulo o tema del correo

                $ruta = route('admin.asistente_contratacion');

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = 'Hola, <br/><br/>
                            Te informamos que el candidato '.$candidato->nombres.' '.$candidato->primer_apellido.' '.$candidato->segundo_apellido.' con número de identificación '.$candidato->numero_id.', ha sido enviado a pre contratar en el requerimiento '.$candidato->req_id.' para el cargo '.$requerimiento->cargo.', puedes consultar en el asistente de contratación a través del siguiente botón.';

                //Arreglo para el botón
                $mailButton = ['buttonText' => 'Asistente de contratación', 'buttonRoute' => $ruta];

                $mailUser = $candidato->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                foreach($emails as $key => $value){

                    Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($value, $requerimiento, $candidato) {

                        $message->to($value->email)
                        ->subject("Pre - contratación (No. $candidato->req_id - $requerimiento->cargo)")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });

                }

                $UserEnvio = DatosBasicos::select('email')->where('user_id', $this->user->id)->first();

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($UserEnvio, $requerimiento, $candidato) {

                    $message->to($UserEnvio->email)
                    ->subject("Pre - contratación (# $candidato->req_id - $requerimiento->cargo)")
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

            }
        }

        return response()->json([
            "success" => true, "candidatos_no_precontratados" => $candidatos_no_precontratados
        ]);
    }

    /*Enviar a contratar modal masivo*/
    public function contratar_masivo_view(Request $data)
    {
        $req_can_id = [];
        $candi_no_cumplen = collect([]);
        $candidatos = collect([]);

        foreach($data->req_candidato as $key => $req_candi_id) {
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->where("requerimiento_cantidato.id", $req_candi_id)
                ->select(
                    "datos_basicos.*",
                    "requerimiento_cantidato.id as req_candidato",
                    "requerimiento_cantidato.requerimiento_id as req"
                )
            ->first();

            if ($candidato->tipo_id == null || $candidato->direccion == null || $candidato->entidad_eps == null || $candidato->entidad_afp == null ||
                $candidato->fecha_expedicion == null || $candidato->fecha_nacimiento == null || $candidato->ciudad_expedicion_id == null) {
                $candidato->observacion_no_cumple = "El candidato debe completar los datos Tipo de documento, Dirección, Eps, Afp, Fecha de expedición documento, Fecha de nacimiento, Lugar de residencia, Teléfono, Lugar expedición";
                $candi_no_cumplen->push($candidato);
            } else {
                $procesoInconclusos = RegistroProceso::where("requerimiento_candidato_id", $req_candi_id)
                    ->whereIn("proceso", [
                        "ENVIO_DOCUMENTOS",
                        "ENVIO_ENTREVISTA",
                        "ENVIO_REFERENCIACION",
                        "ENVIO_VALIDACION",
                        //"ENVIO_EXAMENES",
                        "ENVIO_PRUEBAS",
                        "ENVIO_DOCUMENTOS_PENDIENTE",
                        "ENVIO_ENTREVISTA_PENDIENTE",
                        "ENVIO_EXAMENES_PENDIENTE",
                        "ENVIO_PRUEBAS_PENDIENTE",
                    ])
                    ->whereRaw("( apto IS NULL OR apto = 2 )")
                    ->orWhereRaw("(requerimiento_candidato_id = $req_candi_id and proceso = 'ENVIO_EXAMENES' and apto is NULL )")
                ->get();

                if ($procesoInconclusos->count() > 0) {
                    $candidato->observacion_no_cumple = "El candidato tiene procesos activos inconclusos.";
                    $candi_no_cumplen->push($candidato);
                } else {
                    $contratacion_previa = RegistroProceso::select('procesos_candidato_req.*')
                    ->where('procesos_candidato_req.proceso', 'ENVIO_CONTRATACION')
                    ->where('procesos_candidato_req.requerimiento_candidato_id', $req_candi_id)
                    ->first();

                    $proceso_anulacion = RegistroProceso::where('procesos_candidato_req.proceso', 'CONTRATO_ANULADO')
                    ->where('procesos_candidato_req.requerimiento_candidato_id', $req_candi_id)
                    ->first();        

                    //Validar si la contratación ha sido anulada, entonces deja volver a contratar
                    if (count($proceso_anulacion) > 0) {
                        $contratacion_previa = [];
                    }

                    //Validar si la contratación ha sido cancelada, entonces deja volver a contratar
                    if (count($contratacion_previa) > 0) {
                        if($contratacion_previa->apto == 0) {
                            $contratacion_previa = [];
                        }
                    }

                    if (count($contratacion_previa) > 0) {
                        $candidato->observacion_no_cumple = "El candidato ya ha sido contratado para este requerimiento.";
                        $candi_no_cumplen->push($candidato);
                    } else {
                        //VERIFICAR SI SE HA ENVIADO A APROBAR POR EL CLIENTE Y SI YA SE APROBO
                        $proceso  = RegistroProceso::where("requerimiento_candidato_id", $req_candi_id)
                        ->where("proceso", "ENVIO_APROBAR_CLIENTE")
                        ->first();

                        $mensaje = '';
                        if($proceso != null) {
                            if($proceso->apto == ""){
                                $mensaje = "Este candidato esta a la espera de recibir la aprobación por parte del cliente para poder ser enviado a contratar.";
                            }
                            if($proceso->apto == 2){
                                $mensaje = "Este candidato NO ha sido aprobado por el cliente.";
                            }
                        }

                        $proceso2 = RegistroProceso::where("requerimiento_candidato_id", $req_candi_id)
                            ->where("proceso", "ENVIO_CONTRATACION")
                        ->first();
                        if($proceso2 != null) {
                            $ultimo_proceso = DB::table("procesos_candidato_req")->where("requerimiento_candidato_id", $req_candi_id)
                                ->orderBy("procesos_candidato_req.id", "desc")
                                ->groupBy("procesos_candidato_req.id")
                                ->first();
                            if($ultimo_proceso->proceso == 'ENVIO_CONTRATACION') {
                                $mensaje = "Este candidato ya ha sido enviado a contratar anteriormente.";
                            }
                        }
                        if ($mensaje != '') {
                            $candidato->observacion_no_cumple = $mensaje;
                            $candi_no_cumplen->push($candidato);
                        } else {
                            //Luego de todas las validaciones se puede contratar
                            array_push($req_can_id, $candidato->req_candidato);
                            $candidatos->push($candidato);
                        }
                    }
                }
            }
        }
        $req_can_id_j = json_encode($req_can_id);

        $fecha_hoy = Carbon::now();
        $fecha_hoy = $fecha_hoy->format('Y/m/d');

        $newEndingDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($fecha_hoy)) . " + 365 day"));

        return response()->json([
            "success" => true,
            "view" => view("admin.reclutamiento.modal.enviar_contratacion_masivo", compact(
                "fecha_hoy",
                "candidatos",
                "candi_no_cumplen",
                "newEndingDate",
                "req_can_id_j"
            ))->render()
        ]);
    }

    public function contratar_masivo(Request $data)
    {
        try {
            $sitio = Sitio::first();
            $rules = [
                "fecha_inicio_contrato" => "required",
            ];

        
            $validar = Validator::make($data->all(), $rules);
            if($validar->fails()) {
                return response()->json(["success" => false, "view" => 'Llenas los campos obligatorios']);
            }

            $no_contratados_masivo = [];
            foreach(json_decode($data->candidato_req) as $key => $req_candi_id) {
                $se_puede_contratar = 'si';
                $observacion_no_contratado = '';
                //VERIFICAR EL ESTADO DEL REQUERIMIENTO
                $requerimiento_cand = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->where("requerimiento_cantidato.id", $req_candi_id)
                ->select(
                    "requerimientos.num_vacantes",
                    "requerimientos.pais_id",
                    "requerimientos.departamento_id",
                    "requerimientos.ciudad_id",
                    "requerimientos.centro_costo_id",
                    "requerimiento_cantidato.requerimiento_id",
                    "requerimiento_cantidato.candidato_id as candidato",
                    "requerimiento_cantidato.id as id",
                    "clientes.firma_digital",
                    "cargos_especificos.firma_digital as firma_digital_cargo",
                    "cargos_especificos.videos_contratacion as video_cargo",
                    "cargos_especificos.descripcion as cargo"
                )
                ->first();

                //Validar si el requerimiento esta cerrado
                $estadoReq = EstadosRequerimientos::where("req_id", $requerimiento_cand->requerimiento_id)
                //->where("estado", config('conf_aplicacion.C_TERMINADO'))
                ->orderBy('created_at', 'DESC')
                ->first();

                if($estadoReq != null || $estadoReq != ''){
                    if($estadoReq->estado == config('conf_aplicacion.C_TERMINADO') || $estadoReq->estado === config('conf_aplicacion.C_TERMINADO')){
                        $se_puede_contratar = 'no';
                        $observacion_no_contratado = 'El requerimiento esta terminado.';
                    }
                }

                if($se_puede_contratar == 'si') {
                    //NUMERO DE CANDIDATOS SOLICITADOS POR EL REQUERIMIENTO
                    $num_candidatos            = $requerimiento_cand->num_vacantes;
                    $candidatos_contratados    = [];
                    $candidatos_no_contratados = [];

                    //CONSULTAR CANDIDATOS ENVIADOS
                    $candidatos_req = User::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
                    ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                    ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
                    ->where("requerimiento_cantidato.requerimiento_id", $requerimiento_cand->requerimiento_id)
                    ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
                    ->whereRaw(" requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
                    ->select(
                        "datos_basicos.*",
                        "estados.id as estado_id",
                        "estados.descripcion as estado_candidatos",
                        "requerimiento_cantidato.id as req_candidato_id"
                    )
                    ->get();

                    /*logger(json_encode(User::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
                    ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                    ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
                    ->where("requerimiento_cantidato.requerimiento_id", $requerimiento_cand->requerimiento_id)
                    ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
                    ->whereRaw(" requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
                    ->select(
                        "datos_basicos.*",
                        "estados.id as estado_id",
                        "estados.descripcion as estado_candidatos",
                        "requerimiento_cantidato.id as req_candidato_id"
                    )->toSql()));*/

                    foreach ($candidatos_req as $key => $value) {
                        //Valida la contratación cancelada
                        if($value->estado_id != 24){
                            if ($value->estado_id == config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') || $value->estado_id == config('conf_aplicacion.C_CONTRATADO')) {
                                array_push($candidatos_contratados, $value->user_id);
                            } else {
                                array_push($candidatos_no_contratados, $value->user_id);
                            }
                        }
                    }

                    //TERMINAR REQUERIMIENTO SI LA CANTIDAD DE CANDIDATOS CONTRATADOS  SON LAS VACANTES DEL REQUERIMIENTO
                    if (count($candidatos_contratados) == $num_candidatos) {
                        //logger('candidatos maximos');
                        $se_puede_contratar = 'no';
                        $observacion_no_contratado = 'Se alcanzó el limite de vacantes para el requerimiento.';

                        if($requerimiento_cand->firma_digital_cargo == 0){
                            //TERMINAR REQUERIMIENTO
                            $terminar_req = new EstadosRequerimientos();
                            $terminar_req->fill([
                                "estado"        => config('conf_aplicacion.C_TERMINADO'),
                                "user_gestion"  => $this->user->id,
                                "observaciones" => "Se ha cumplido con todos los candidatos solicitados.",
                                "req_id"        => $requerimiento_cand->requerimiento_id,
                            ]);
                            $terminar_req->save();

                            // Se cambia el estado público del requerimiento
                            $req = Requerimiento::find($requerimiento_cand->requerimiento_id);
                            $req->estado_publico = 0;
                            $req->save();

                            foreach ($candidatos_no_contratados as $key => $user_id) {
                                //ACTIVAR CANDIDATOS NO SELECCIONADOS
                                $update_user = DatosBasicos::where("user_id", $user_id)->first();
                                $update_user->fill(["estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')]);
                                $update_user->save();
                            
                                    
                                //ENVIAR MAIL A CANDIDATOS NO CONTRATADOS
                                $datos_basicos = DatosBasicos::where('datos_basicos.user_id', $user_id)
                                    ->select('datos_basicos.nombres as nombres','datos_basicos.email as email',
                                        'datos_basicos.user_id')
                                ->first();
                
                                $user_sesion = $this->user;
                                
                                $nombres = $datos_basicos->nombres;
                                $asunto = "Notificación de proceso de selección";
                                $emails = $datos_basicos->email;

                                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                                $mailConfiguration = 1; //Id de la configuración
                                $mailTitle = ""; //Titulo o tema del correo

                                //Cuerpo con html y comillas dobles para las variables
                                $mailBody = "Buen día ".$nombres.",
                                se ha finalizado el proceso de selección donde estabas. Gracias por haber participado, si deseas más información sobre otras ofertas puedes acceder a nuestra página.";

                                //Arreglo para el botón
                                $mailButton = ['buttonText' => 'Acceder', 'buttonRoute' => route('login')];

                                $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

                                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);
                                
                                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($emails, $asunto) {

                                    $message->to($emails);
                                    $message->subject($asunto)
                                    ->getHeaders()
                                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                                });
                                
                                /*
                                Para GPC enviar este correo
                                    $mensaje = "Buen día ".$nombres.",
                                    Para GREAT PEOPLE CONSULTING, ha sido una grata experiencia contar con tu participación en este proceso. 

                                    Agradecemos tu colaboración y destacamos tu profesionalismo, experiencia y entusiasmo demostrado, lo que permitió que seas integrante de las actividades del proceso de preselección y/o evaluación.

                                    Tu desempeño durante fue muy satisfactorio. En esta oportunidad, nuestro Cliente ha tomado la decisión por otra alternativa del grupo evaluado.
                                
                                    Esperamos que esta experiencia haya sido satisfactoria para ti, agradecemos tu valioso tiempo, apertura y el interés evidenciado durante este proceso.

                                    Esperamos contar contigo en una próxima oportunidad y poder servirte en cualquier inquietud o requerimiento. 

                                    Muchos éxitos!!. 

                                    Great People Consulting";
                                
                        
                                Para Komatsu enviar este correo
                                    $fecha = date('d \d\e M  \d\e Y');
                                    
                                    Mail::send('admin.email-agradecimientos', [
                                        'requerimiento' => $requerimiento_cand,
                                        'fecha'=>$fecha,
                                        'nombres'=>$nombres
                                    ], function ($message) use ($emails,$asunto) {
                                        $message->to($emails)
                                        ->subject($asunto);
                                    });
                                
                                Para listos enviar este correo
                                    Mail::send('admin.enviar_email_candidatos_recha', ["mensaje" => $mensaje], function($message) use ($emails, $asunto) {
                                        $message->to([$emails,"liliana.marin@listos.com.co"]);
                                        $message->subject($asunto);
                                    });
                                */
                            }
                        
                            /*
                            //EMAIL PARA CANDIDATOS QUE APLICARON
                            Solo GPC
                                $aplicados = OfertaUser::join("users","users.id", "=", "ofertas_users.user_id")
                                ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                                ->where("ofertas_users.requerimiento_id", 1)
                                ->where("ofertas_users.estado", 1)
                                ->pluck("datos_basicos.email")
                                ->toArray();

                                $asunto = "Notificación de proceso de selección";
                                
                                $mensaje = "Buen día.,
                                    se ha finalizado el proceso de selección donde estabas. Gracias por haber participado, si desea más información sobre otras ofertas puede acceder a nuestra página. ";

                                if(!empty($aplicados)){
                                    foreach($aplicados as $aplicado){
                                        Mail::send('admin.enviar_email_candidatos_recha', ["mensaje" => $mensaje], function($message) use ($aplicado, $asunto) {
                                            $message->to([$aplicado,"javier.chiquito@t3rsc.co"], 'T3RS')->subject($asunto);
                                        });
                                    }
                                }
                            */

                            /*
                            Solo Komatsu
                                //ENVIAR FORMULARIO DE SATISFACCION AL SOLICITANTE KOMATSU
                                $reque = Requerimiento::find($requerimiento_cand->requerimiento_id);
                                Mail::send('admin.email-satisfaccion', [
                                    'requerimiento' => $reque,
                                ], function ($message) use ($reque) {
                                    $message->to([$reque->solicitud->user()->email,"javier.chiquito@t3rsc.co"], 'T3RS')
                                    ->subject("Encuesta de satisfacción Solicitud #".$reque->solicitud->id);
                                });
                            */
                        }
                    }
                }
                
                if ($se_puede_contratar == 'si') {
                    $historialContratacion = new RequerimientoContratoCandidato();

                    $historialContratacion->requerimiento_candidato_id = $req_candi_id;
                    $historialContratacion->requerimiento_id = $requerimiento_cand->requerimiento_id;
                    $historialContratacion->candidato_id = $requerimiento_cand->candidato;
                    $historialContratacion->centro_costo_id = $requerimiento_cand->centro_costo_id;
                    $historialContratacion->user_gestiono_id = $this->user->id;
                    $historialContratacion->fecha_fin_contrato = $data->fecha_fin_contrato;
                    $historialContratacion->fecha_ingreso = $data->fecha_inicio_contrato;
                    $historialContratacion->observaciones = $data->observacion_cont_masivo;
                    $historialContratacion->hora_ingreso = $data->hora_ingreso;
                    //$historialContratacion->auxilio_transporte = $data->auxilio_transporte;  //Listos y VyM
                    $historialContratacion->tipo_ingreso=$data->tipo_ingreso;
                    $historialContratacion->arl_id = $data->arl;

                    $historialContratacion->save();

                    //falta
                    /*
                    $historialContratacion->eps_id = $data->entidad_eps;
                    $historialContratacion->fondo_pensiones_id = $data->entidad_afp;
                    $historialContratacion->caja_compensacion_id = $data->caja_compensacion;
                    $historialContratacion->fondo_cesantia_id = $data->fondo_cesantias;
                    */

                    //VERIFICAR SI TIENE APROBACION POR CLIENTE
                    $valida_cliente = RegistroProceso::where("requerimiento_candidato_id", $req_candi_id)->first();

                    if($valida_cliente != null) {
                        //CAMBIA ESTADO REGISTRO APTO ENVIO_APROBAR_CLIENTE enviar_entrevista_view
                        $valida_cliente->fill([
                            "apto"                => 1,
                            "usuario_terminacion" => $this->user->id,
                        ]);

                        $valida_cliente->save();
                    }

                    $campos = [
                        'requerimiento_candidato_id' => $req_candi_id,
                        'usuario_envio'              => $this->user->id,
                        "fecha_inicio"               => date("Y-m-d H:i:s"),
                        "fecha_inicio_contrato"      => $fecha_ingreso_contra,
                        "observaciones"              => $data->observacion_cont_masivo,
                        "centro_costos"              => $requerimiento_cand->centro_costo_id,
                        "user_autorizacion"          => $this->user->id,
                        "usuario_terminacion"        => $this->user->id,
                        "hora_entrada"               => $data->hora_ingreso,
                        'proceso'                    => "ENVIO_CONTRATACION",
                        'requerimiento_id'           => $requerimiento_cand->requerimiento_id,
                        'candidato_id'               => $requerimiento_cand->candidato,
                        'estado'                     => config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')
                    ];

                    //$this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'), $data->get("candidato_req"));
                    //$estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'))->first();

                    //ACTUALIZA REGISTRO A ESTADO SEGUN EL PROCESO
                    ReqCandidato::where('id', $req_candi_id)->update(['estado_candidato' => config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')]);


                    //REGISTRA PROCESO
                    $nuevo_proceso = new RegistroProceso();
                    $nuevo_proceso->fill($campos);

                    $requerimiento_obj = Requerimiento::find($requerimiento_cand->requerimiento_id);

                    $num_verificacion = RegistroProceso::where("requerimiento_candidato_id", $req_candi_id)
                        ->where("proceso", "ENVIO_APROBAR_CLIENTE")
                        ->where("cand_presentado_puntual", 1)
                        ->where("requerimiento_id", $requerimiento_cand->requerimiento_id)
                        ->select("cand_presentado_puntual", "proceso")
                    ->get();

                    if ($num_verificacion->count() > 0) {
                        $nuevo_proceso->cand_presentado_puntual = 1;
                    }

                    $fecha_contratacion_candidato = Carbon::now('America/Bogota');
                    $fecha_tentativa_cierre_req   = Carbon::parse($requerimiento_obj->fecha_tentativa_cierre_req);

                    if ($fecha_contratacion_candidato->lte($fecha_tentativa_cierre_req)) {

                        $cand_contratados_puntual                    = $requerimiento_obj->cand_contratados_puntual + 1;
                        $requerimiento_obj->cand_contratados_puntual = $cand_contratados_puntual;
                        $nuevo_proceso->cand_contratado           = 1;
                    }
                    if ($fecha_contratacion_candidato->gt($fecha_tentativa_cierre_req)) {

                        $cand_contratados_no_puntual                    = $requerimiento_obj->cand_contratados_no_puntual + 1;
                        $requerimiento_obj->cand_contratados_no_puntual = $cand_contratados_no_puntual;
                        $nuevo_proceso->cand_contratado              = 1;

                    }
                    $requerimiento_obj->fecha_contratacion_candidato = $fecha_contratacion_candidato;
                    $requerimiento_obj->save();
                    $nuevo_proceso->save();

                    if($sitio->precontrata == 1) {
                        //Cambiar estado PRE_CONTRATAR a 1
                        RegistroProceso::where('requerimiento_candidato_id', $req_candi_id)->where('proceso', "PRE_CONTRATAR")->update(['apto' => 1]);
                    }

                    /*
                    //ENVIAR CORREO INFORMATIVO A YAIR (KOMATSU)
                    if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
                        $reque = Requerimiento::find($requerimiento_cand->requerimiento_id);
                        Mail::send('admin.email-satisfaccion', [
                            'requerimiento' => $reque,
                        ], function ($message) use ($reque) {
                            $message->to([$reque->solicitud->user()->email, "javier.chiquito@t3rsc.co"], 'T3RS')
                            ->subject("Encuesta de satisfacción Solicitud # $reque->solicitud->id");
                        });
                    }        

                    if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co"){
                        //enviar correo de la contratacion
                        $candidato_envio = User::find($requerimiento_cand->candidato);

                        Mail::send('admin.correo_aprobacion_candidato', [
                            "requerimiento" => $requerimiento,
                            "candidato" => $candidato_envio
                        ], function ($message) use ($requerimiento) {
                            $message->to(["yair.gutierrez@komatsu.com.co", "javier.chiquito@t3rsc.co"], "T3RS")
                            ->subject("Contracion Candidato");
                        });
                    }
                    */

                    //$estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'))->first();
            

                    //Validación de contratación virtual
                    if($requerimiento_cand->firma_digital_cargo == 1 && $sitio->asistente_contratacion == 1){

                        $datos_correo_archivos = DatosBasicos::where('user_id', $requerimiento_cand->candidato)->first();

                        //Crea registro de firma de contrato
                        $firma = new FirmaContratos();

                        $firma->fill([
                            'user_id' => $requerimiento_cand->candidato,
                            'req_id'  => $requerimiento_cand->requerimiento_id,
                            'estado'  => 1,
                            'gestion' => $this->user->id,
                            'req_contrato_cand_id' => $historialContratacion->id
                        ]);
                        $firma->save();

                        //$email_doc_contrato = User::find($requerimiento_cand->candidato);
                        
                        //Realiza envío de correo para carga de archivos y firma de contrato al candidato
                        if(!empty($datos_correo_archivos->email)){
                            
                            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                            $mailConfiguration = 1; //Id de la configuración
                            $mailTitle = ""; //Titulo o tema del correo

                            //Cuerpo con html y comillas dobles para las variables
                            $mailBody = "
                                Felicitaciones  $datos_correo_archivos->nombres $datos_correo_archivos->primer_apellido, te hemos pre-seleccionado en el requerimiento $requerimiento_cand->requerimiento_id correspondiente al cargo $requerimiento_cand->cargo.
                                <br/>
                                Te invitamos a cargar los documentos solicitados en la plataforma y proceder con la firma de tu contrato de forma virtual. 
                                <br/><br/>

                                Por favor haz clic en el siguiente botón y sigue las instrucciones que te brindará la plataforma.
                                ";

                            //Arreglo para el botón
                            $mailButton = ['buttonText' => 'CARGAR DOCUMENTOS Y FIRMAR CONTRATO', 'buttonRoute' => route('admin.carga_archivos_contratacion')];

                            $mailUser = $datos_correo_archivos->user_id; //Id del usuario al que se le envía el correo

                            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_correo_archivos, $requerimiento_cand) {

                                    $message->to($datos_correo_archivos->email, $datos_correo_archivos->nombres)
                                            ->subject("Pre - selección para contratación virtual - $requerimiento_cand->cargo")
                                            ->getHeaders()
                                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                            });

                        }

                        /*
                        if(route("home") == "https://listos.t3rsc.co" || route("home") == "https://pruebaslistos.t3rsc.co"){
                            $usuario_envio = RegistroProceso::join('datos_basicos', 'datos_basicos.user_id', '=', 'procesos_candidato_req.usuario_envio')
                                ->where("requerimiento_candidato_id", $req_can_id)
                                ->where("proceso", "ENVIO_CONTRATACION")
                                ->select('datos_basicos.email')
                            ->first();

                            //$usuario_envio = DatosBasicos::where('user_id', $valida_cliente->usuario_envio)
                            //->first();

                            //Envío de correo a quien envío a contratar
                            Mail::send('admin.email-documentos-contratacion', [
                                "url" => route("admin.carga_archivos_contratacion"),
                                "datos_user" => $datos_correo_archivos,
                                "req_id" => $requerimiento_cand->requerimiento_id,
                                "cargo" => $requerimiento_cand->cargo
                            ], function ($message) use($usuario_envio, $requerimiento_cand){
                                $message->to([
                                    $usuario_envio->email
                                ], "T3RS")
                                ->subject("Pre - selección para contratación virtual (# $requerimiento_cand->requerimiento_id - $requerimiento_cand->cargo)");
                            });
                            
                            if(route("home") == "https://listos.t3rsc.co"){
                                //Envío de correo a personas de Listos
                                Mail::send('admin.email-documentos-contratacion', [
                                    "url" => route("admin.carga_archivos_contratacion"),
                                    "datos_user" => $datos_correo_archivos,
                                    "req_id" => $requerimiento_cand->requerimiento_id,
                                    "cargo" => $requerimiento_cand->cargo
                                ], function ($message) use($requerimiento_cand){
                                    $message->to([
                                        "sandra.lozano@visionymarketing.com.co",
                                        "ingrid.diaz@listos.com.co",
                                        "juanmanuel.munoz@listos.com.co",
                                        "liliana.marin@listos.com.co",
                                        "brayan.quintero@listos.com.co",
                                        "lida.peraza@listos.com.co"
                                    ], "T3RS")
                                    ->subject("Pre - selección para contratación virtual (# $requerimiento_cand->requerimiento_id - $requerimiento_cand->cargo)");
                                });
                            }

                            //Envío de correo a usuarios relacionados con agencia y con rol reclutamiento
                            $role_contratacion = Requerimiento::join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                            ->join("departamentos", function ($join) {
                                $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                                ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                            })->join("ciudad", function ($join2) {
                                $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                                ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                            })
                            ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
                            ->leftjoin('agencia_usuario', 'agencia_usuario.id_agencia', '=', 'agencias.id')
                            ->join('users', 'users.id', '=', 'agencia_usuario.id_usuario')
                            ->join('role_users', 'role_users.user_id', '=', 'users.id')
                            ->select(            
                                "requerimientos.cargo_especifico_id as cargo_req",
                                "requerimientos.pais_id as cod_pais",
                                "requerimientos.departamento_id as cod_departamento",
                                "requerimientos.ciudad_id as cod_ciudad",
                                "requerimientos.num_vacantes as numero_vacantes",
                                "agencias.descripcion as agencia",
                                "agencias.direccion as agencia_direccion",
                                "agencias.id as agencia_id",
                                "users.email"
                            )
                            ->where("requerimientos.id", $requerimiento_cand->requerimiento_id)
                            ->whereIn("role_users.role_id", [19, 20])
                            ->get();

                            if($role_contratacion != null || $role_contratacion != ''){
                                foreach ($role_contratacion as $usuario) {
                                    Mail::send('admin.email-documentos-contratacion', [
                                        "url" => route("admin.carga_archivos_contratacion"),
                                        "datos_user" => $datos_correo_archivos,
                                        "req_id" => $requerimiento_cand->requerimiento_id,
                                        "cargo" => $requerimiento_cand->cargo
                                    ], function ($message) use($requerimiento_cand, $usuario){
                                        $message->to([
                                            $usuario->email
                                        ], "T3RS")
                                        ->subject("Pre - selección para contratación virtual (# $requerimiento_cand->requerimiento_id - $requerimiento_cand->cargo)");
                                    });
                                }
                            }
                        }
                        */
                    }

                    /*
                    //Email de orden de contratacion
                    if(route("home") == "https://listos.t3rsc.co"){
                        $agenciaCiudad = Ciudad::where('cod_pais', $requerimiento_cand->pais_id)
                        ->where('cod_departamento', $requerimiento_cand->departamento_id)
                        ->where('cod_ciudad', $requerimiento_cand->ciudad_id)
                        ->first(['agencia']);

                        if($agenciaCiudad->agencia == "6"){
                            //consulta candidato y el requerimiento
                            $candreq = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                            ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                            ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
                            ->select(
                                "clientes.nombre as nombre_cliente",
                                "requerimiento_cantidato.requerimiento_id as req_id",
                                "datos_basicos.nombres",
                                "datos_basicos.primer_apellido",
                                "datos_basicos.numero_id"
                            )
                            ->first();

                            $user_envio = User::find($this->user->id);

                            $mails = array(1=>"brayan.quintero@listos.com.co",2=>"karol.henao@listos.com.co",3=>"sandra.lozano@visionymarketing.com.co"); //arreglo de correos

                            $mail2 = array(1=>"lina.aponza@listos.com.co",2=>"ingrid.diaz@listos.com.co",3=>"juanmanuel.munoz@listos.com.co");//segundo arreglo de correos
                        
                            $rand = range(1,3);
                            shuffle($rand);
                            $n = reset($rand);

                            //Enviar email de orden de contrato los que estan en agencia cali
                            Mail::send('emails.gestion_requerimiento.orden_contrato',[
                                'candreq' => $candreq,
                                'req_cand' => $data->get("candidato_req"),
                                'user_envio' => $user_envio->name
                            ],function($m)use($mails,$mail2,$n){
                                $m->subject('Orden contrato de requisicion No.');
                                $m->to($mails[$n],$mail2[$n],"Orden-T3RS");
                            });
                        }
                    }
                    */
                //Fin si se contrata
                } else {
                    //logger('no se envia a contratar');
                    $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                        ->where("requerimiento_cantidato.id", $req_candi_id)
                        ->select(
                            "datos_basicos.nombres",
                            "datos_basicos.user_id",
                            "datos_basicos.numero_id",
                            "datos_basicos.primer_apellido",
                            "datos_basicos.segundo_apellido",
                            "requerimiento_cantidato.id as req_candidato",
                            "requerimiento_cantidato.requerimiento_id as req_id"
                        )
                    ->first();
                    array_push($no_contratados_masivo, ["numero_id" => "$candidato->numero_id", "nombres" => "$candidato->nombres", "observacion" => $observacion_no_contratado]);
                }
            }

            return response()->json([
                "success" => true, "no_contratados_masivo" => $no_contratados_masivo
            ]);

        } catch (\Exception $e) {
            logger('Excepción capturada: '.  $e->getMessage(). "\n");
        }
    }

    public function aceptacionPoliticaTratamientoDatos(Request $request)
    {   
        $politica = PoliticasPrivacidad::findOrFail($request->politica_id);

        $candidato = DatosBasicos::join("users", "users.id", "=", "datos_basicos.user_id")
                                    ->join("politicas_privacidad_candidatos", "politicas_privacidad_candidatos.candidato_id", "=", "datos_basicos.user_id")
                                    ->leftjoin("politicas_privacidad", "politicas_privacidad.id", "=", "politicas_privacidad_candidatos.politica_privacidad_id")
                                    ->where('user_id', $request->user_id)
                                    ->where('politica_privacidad_id', $request->politica_id)
                                    ->select(
                                    'datos_basicos.nombres', 
                                    'datos_basicos.primer_apellido', 
                                    'datos_basicos.segundo_apellido', 
                                    'politicas_privacidad_candidatos.fecha_acepto_politica', 
                                    'politicas_privacidad_candidatos.hora_acepto_politica', 
                                    'politicas_privacidad_candidatos.ip_acepto_politica',
                                    'politicas_privacidad.titulo as politica_titulo',
                                    'politicas_privacidad.texto as politica_texto',
                                    'users.created_at as fecha_registro',
                                    'users.ip_registro')
                                    ->orderBy("politicas_privacidad_candidatos.id", "DESC")
                                    ->first();


        $view = \View::make('cv.pdf_tratamiento_datos_personales', compact('politica', 'candidato'))->render();

        $pdf  = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        if($request->has("download")){
            return $pdf->output();
        }
        else{
            return $pdf->stream('aceptacion_politica_de_tratamientos_de_datos_personales.pdf');
        }

        
    }
}
