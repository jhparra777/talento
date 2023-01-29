<?php

namespace App\Http\Controllers;

use \Cache;
use Carbon\Carbon;
use Storage;
use triPostmaster;
use App\Models\Pais;
use App\Models\User;
use App\Models\Ficha;
use App\Models\Sitio;
use App\Http\Requests;
use App\Models\Bancos;
use App\Models\Ciudad;
use App\Models\Genero;
use GuzzleHttp\Client;
use App\Models\Estados;
use App\Models\Negocio;
use App\Models\ReqPreg;
use App\Models\Citacion;
use App\Models\Clientes;
use App\Models\Estudios;
use App\Models\Auditoria;
use App\Models\Proveedor;
use App\Models\Recepcion;
use App\Models\TruoraKey;
use Bitly;               
use App\Models\Archivo_hv;
use App\Models\Documentos;
use App\Models\ListaNegra;
use App\Models\NegocioANS;
use App\Models\OfertaUser;
use App\Models\Parentesco;
use App\Models\EmpresaLogo;
use App\Models\Escolaridad;
use App\Models\EstadoCivil;
use App\Models\OrdenMedica;
use App\Models\PregReqResp;
use App\Models\Profesiones;
use App\Models\SitioModulo;
use App\Models\Solicitudes;
use App\Models\TipoFuentes;
use App\Models\VisitaAdmin;
use App\Models\CargaScanner;
use App\Models\DatosBasicos;
use App\Models\EntidadesAfp;
use App\Models\EntidadesEps;
use App\Models\Experiencias;
use App\Models\GrupoFamilia;
use App\Models\MotivoRetiro;
use App\Models\PruebaIdioma;
use App\Models\ReqCandidato;
use App\Models\UserClientes;
use Illuminate\Http\Request;
use App\Models\AsistenteCita;
use App\Models\Autoentrevist;
use App\Models\AuxiliarFicha;
use App\Models\CargoGenerico;
use App\Models\FranjaHoraria;
use App\Models\GestionPrueba;
use App\Models\IdiomaUsuario;
use App\Models\NivelEstudios;
use App\Models\Preperfilados;
use App\Models\Requerimiento;
use App\Facade\QueryAuditoria;
use App\Models\CargosExamenes;
use App\Models\EntrevistaSemi;
use App\Models\EstadosOrdenes;
use App\Models\FirmaContratos;
use App\Models\FondoCesantias;
use App\Models\LlamadaMensaje;
use App\Models\PreguntasEntre;
use App\Jobs\FuncionesGlobales;
use App\Models\CargoEspecifico;
use App\Models\CitacionCargaBd;
use App\Models\DocumentosCargo;
use App\Models\ExamenesMedicos;
use App\Models\NotificacionCandidatoExamenMedico;
use App\Models\MotivosRechazos;
use App\Models\ObservacionesHv;
use App\Models\RecepcionMotivo;
use App\Models\RegistroProceso;
use App\Models\RespuestasEntre;
use App\Models\VisitaCandidato;
use App\Models\CajaCompensacion;
use App\Events\PorcentajeHvEvent;
use App\Models\CandidatosFuentes;
use App\Models\CargaReclutadores;
use App\Models\ConsultaSeguridad;
use App\Models\EntrevistaVirtual;
use App\Models\EstudiosSeguridad;
use App\Models\EstudioVerificado;
use App\Jobs\SendEmailOrderMedica;
use App\Models\CompetenciaCliente;
use App\Models\EntrevistaMultiple;
use App\Models\TipoIdentificacion;
use App\Models\TipoObservacionReq;
use Illuminate\Support\Facades\DB;
use App\Models\AsignacionPsicologo;
use App\Models\CalificaCompetencia;
use App\Models\EmailAprobarCliente;
use App\Models\ReferenciaEstudio;
use App\Models\EntrevistaSeleccion;
use App\Models\PruebaBrigResultado;
use App\Models\PruebaDigitacionReq;
use App\Http\Controllers\Controller;
use App\Models\ControlFuncionalidad;
use App\Models\EntrevistaCandidatos;
use App\Models\ProcesoRequerimiento;
use App\Models\PruebaCompetenciaReq;
use App\Models\User as EloquentUser;
use App\Models\VinculacionCandidato;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\CentroCostoProduccion;
use App\Models\DocumentosVerificados;
use App\Models\EstadosRequerimientos;
use App\Models\ExperienciaVerificada;
use App\Models\OrdenEstudioSeguridad;
use App\Models\PreguntasPruebaIdioma;
use App\Models\PruebaBrigConfigCargo;
use App\Models\PruebaDigitacionCargo;
use App\Models\ReferenciasPersonales;
use App\Models\RespuestaPruebaIdioma;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Event;
use App\Models\CitacionTipificaciones;
use App\Models\ClausulaValorCandidato;
use App\Models\ObservacionesCandidato;
use App\Models\PerfilamientoCandidato;
use App\Models\ProveedorTipoProveedor;
use App\Models\PruebaCompetenciaCargo;
use App\Models\PruebaCompetenciaTotal;
use Illuminate\Support\Facades\Route; 
use App\Models\CargoDocumentoAdicional;
use App\Models\CargosEstudiosSeguridad;
use App\Models\MotivoDescarteCandidato;
use App\Models\PruebaValoresRespuestas;
use App\Models\PruebaExcelConfiguracion;
use App\Models\PruebaExcelRespuestaUser;
use App\Models\RequerimientoCompetencia;
use App\Models\MotivoEstadoRequerimiento;
use App\Models\PruebaCompetenciaConcepto;
use App\Models\PruebaDigitacionResultado;
use App\Models\TipoFuncionalidadAvanzada;
use App\Models\TrazabilidadFuncionalidad;
use Illuminate\Support\Facades\Validator;
use App\Models\EntrevistaMultipleDetalles;
use App\Models\EvaluacionSstConfiguracion;
use App\Models\PruebaCompetenciaResultado;
use App\Models\RequerimientoObservaciones;
use App\Models\PruebaValoresAreaImportante;
use App\Models\PruebaValoresInterpretacion;
use App\Models\CargoEspecificoConfigPruebas;
use App\Models\ReferenciaPersonalVerificada;
use App\Models\CandidatoReclutamientoExterno;
use App\Models\PruebaBrigConfigRequerimiento;
use App\Models\PruebaValoresNormasNacionales;
use App\Models\RequerimientoContratoCandidato;
use App\Models\ExamenMedico;
//use Event;
use App\Models\PreliminarTranversalesCandidato;

//Integrations
use App\Models\PruebaValoresConfigRequerimiento;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

//Helper
use App\Models\AsistenteCitaAgendamientoCandidato;
use App\Http\Controllers\PruebaPerfilBrygController;
use App\Http\Controllers\Integrations\TruoraIntegrationController;
use App\Http\Controllers\ContratacionController;
use App\Http\Controllers\Integrations\OmnisaludIntegrationController;
use App\Models\ConsultaListaVinculante;
use App\Models\OmnisaludTipoAdmision;
use App\Models\OmnisaludExamenesMedicos;
use App\Models\MotivoAnulacion;
use App\Models\PoliticaPrivacidadCandidato;
use App\Models\TipoPolitica;

class ReclutamientoController extends Controller
{
    protected $meses = [];
    protected $estados_no_muestra = [];
    public $tipoDocumento         = ["" => "Seleccionar"];
    public $escolaridad           = ["" => "Seleccionar"];
    public $parentesco            = ["" => "Seleccionar"];
    public $genero                = ["" => "Seleccionar"];
    public $profesion             = ["" => "Seleccionar"];

    public function __construct()
    {
        parent::__construct();

        //SON LOS ESTADOS PARA NO MOSTRAR EL CANDIDATO EN EL  REQUERIMIENTO
        $this->estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
            config('conf_aplicacion.C_TRANSFERIDO'),
        ];

        $this->meses = [
            1 => "Enero",
            2 => "Febrero",
            3 => "Marzo",
            4 => "Abril",
            5 => "Mayo",
            6 => "Junio",
            7 => "Julio",
            8 => "Agosto",
            9 => "Septiembre",
            10 => "Octubre",
            11 => "Noviembre",
            12 => "Diciembre"
        ];

        $this->tipoDocumento += TipoIdentificacion::where("active", 1)
        ->pluck("descripcion", "id")
        ->toArray();

        $this->escolaridad += Escolaridad::where("active", 1)
        ->pluck("descripcion", "id")
        ->toArray();

        $this->parentesco += Parentesco::where("active", 1)
        ->pluck("descripcion", "id")
        ->toArray();

        $this->genero += Genero::where("active", 1)
        ->pluck("descripcion", "id")
        ->toArray();

        $this->profesion += Profesiones::where("active", 1)
        ->pluck("descripcion", "id")
        ->toArray();
    }

    public function gestion_req($req_id, Request $data)
    {
        $user_sesion = $this->user;
        $solicitud = "";

        $sitio = Sitio::first();
        $sitioModulo = SitioModulo::first();

        $requermiento = Requerimiento::join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
        ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
        ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
        ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->join("users", "users.id", "=", "requerimientos.solicitado_por")
        ->leftjoin("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->select("clientes.id as cliente_id","clientes.nombre as nombre_cliente","requerimientos.*", "requerimientos.ciudad_id as ciudad",
            "users.name as solicitante",
            "requerimientos.pais_id as pais",
            "requerimientos.departamento_id as departamento",
            "requerimientos.adicionales_salariales",
            "motivo_requerimiento.descripcion as motivo_req",
            "cargos_genericos.descripcion as nombre_cargo",
            "cargos_especificos.descripcion as nombre_cargo_especifico",
            "cargos_especificos.archivo_perfil as archivo_perfil",
            "cargos_especificos.firma_digital as firma_digital",
            "cargos_especificos.id as cargo_id"
        )
        ->findOrFail($req_id);

        $boton = false;

        if(!empty($requermiento->estadoRequerimiento()) ){
            $boton = FuncionesGlobales::estado_boton($requermiento->estadoRequerimiento()->estado_id); 
        }

        if($requermiento->estadoRequerimiento()->estado_id == 16){
            $cerrado = true;
        }else{
            $cerrado = false;
        }

        //Si hay respuestas y aplicaciones de candidatos para ver sus resultados
        $preguntas_req = PregReqResp::join('ofertas_users', 'ofertas_users.user_id', '=', 'preg_req_resp.user_id')
        ->where('preg_req_resp.req_id', $req_id)
        //->where('ofertas_users.aplica', 1)
        ->count();

        $contra_cliente = RegistroProceso::select('procesos_candidato_req.*')
        ->where('procesos_candidato_req.proceso', 'ENVIO_CONTRATACION_CLIENTE')
        ->where('procesos_candidato_req.requerimiento_id', $req_id)
        ->orderBy('procesos_candidato_req.id', 'desc')
        ->count();

        //Datos de la ficha [Validar botones de requerimientos]
        $ficha = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->where("requerimientos.id", $req_id)
        ->select("*")
        ->first();

        $datos_ficha = Ficha::where("cargo_cliente", $ficha->cargo_especifico_id)
        ->where("cliente_id", $ficha->cliente_id)
        ->select("*")
        ->first();

        if($datos_ficha !== null){
            //Busca las opciones de auxiliar de fichas para validar botones
            $valida_botones = AuxiliarFicha::where("ficha_id", $datos_ficha->id) ->select("*")->get();
        }else{
            $valida_botones = null;
        }

        if ($datos_ficha !== null) {
            //Cuando la ficha esta creada se buscar los datos de la ficha
            $genero = $datos_ficha->genero;

            if ($genero == 1) {
                $genero = ['1'];
            } elseif ($genero == 2) {
                $genero = ['2'];
            } else {
                $genero = ['1', '2'];
            }
        }

        $candidatos_cargo_general = "";

        $negocio = Negocio::find($requermiento->negocio_id);

        $centro_costo = CentroCostoProduccion::where('cod_division', $negocio->depto_division_codigo)
        ->where('cod_depto_negocio', $negocio->depto_codigo)
        ->where('estado', '=', 'ACT')
        ->select(DB::raw('upper(descripcion) as descripcion'))
        ->first();

        $cliente = Clientes::find($negocio->cliente_id);

        $req_candidato = DB::table("requerimiento_cantidato")
        ->where("requerimiento_id", $req_id)
        ->whereRaw(" estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
        ->pluck("candidato_id", "candidato_id");

        //Candidatos del requerimiento
        $paginate = 5;
        
        //Candidatos vinculados
        $candidatos_req = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join('requerimientos', 'requerimientos.id', '=', 'requerimiento_cantidato.requerimiento_id')
        ->join('users', 'users.id', '=', 'datos_basicos.user_id')
        /*->leftjoin('entrevistas_candidatos', function ($sql){
            $sql->on('datos_basicos.user_id', '=', 'entrevistas_candidatos.candidato_id')
            ->on('entrevistas_candidatos.req_id', '=', 'requerimiento_cantidato.requerimiento_id');
        })*/
        ->leftjoin('llamada_mensaje', function ($sql){
            $sql->on('datos_basicos.numero_id', '=', 'llamada_mensaje.numero_id')
            ->on('llamada_mensaje.req_id', '=', 'requerimiento_cantidato.requerimiento_id');
        })
        ->leftjoin('asistencia', 'asistencia.llamada_id', '=', 'llamada_mensaje.id')
        ->join("estados",  "estados.id",  "=",  "requerimiento_cantidato.estado_candidato")
        ->where("requerimiento_cantidato.requerimiento_id", $req_id)
        ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
        ->where(function ($sql) use ($data) {
            if ($data->get("cedula") != "") {
                $sql->where("datos_basicos.numero_id", $data->get("cedula"));
            }
        })
        ->whereNotIn('requerimiento_cantidato.estado_candidato', [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO')
        ])
        ->whereRaw('requerimiento_cantidato.id=(select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.requerimiento_id=requerimientos.id and requerimiento_cantidato.candidato_id=datos_basicos.user_id)')
        ->select(
            //"entrevistas_candidatos.asistio as asistio",
            "llamada_mensaje.id as llamada_id",
            "asistencia.asistencia as asis",
            "users.video_perfil as video",
            "requerimiento_cantidato.candidato_id as candidato_id",
            "requerimiento_cantidato.requerimiento_id as req_id",
            "datos_basicos.*",
            "datos_basicos.id as datos_basicos_id",
            "estados.descripcion as estado_candidatos",
            "estados.id as estado_candidato_id",
            "requerimiento_cantidato.id as req_candidato_id",
            "datos_basicos.trabaja as trabaja",
            "requerimiento_cantidato.id",
            "requerimiento_cantidato.transferido_a_req as transferido",
            "llamada_mensaje.modulo as modulo_llamada",
            DB::raw('(select count(documentos.id) from documentos inner join tipos_documentos on documentos.tipo_documento_id=tipos_documentos.id where tipos_documentos.categoria=1 and documentos.user_id=datos_basicos.user_id) documentos_count'),
            DB::raw('(select count(idioma_usuario.id) from idioma_usuario where  idioma_usuario.id_usuario=datos_basicos.user_id) idiomas_count'),
            DB::raw('(select apto from procesos_candidato_req where procesos_candidato_req.requerimiento_id = requerimiento_cantidato.requerimiento_id AND procesos_candidato_req.requerimiento_candidato_id = requerimiento_cantidato.id AND procesos_candidato_req.proceso = \'ENVIO_APROBAR_CLIENTE\' ORDER BY procesos_candidato_req.id DESC LIMIT 1) apto')
        )
        ->orderBy("requerimiento_cantidato.id")
        ->groupBy('datos_basicos.numero_id')
        ->with('procesos')
        ->get();

        $n = 0;
        
        // SE ORDENAN LOS CANDIDATOS PARA COLOCAR AL INICIO DE LA LISTA LOS QUE ESTAB POR APROBAR
        if(count($candidatos_req) > 0){
            $contrato_cliente = false;
            $contrato = false;
            
            foreach($candidatos_req as $key =>$value){
                
                if($value->documentos_count>0){
                    $value->documentos_count=100;
                }
                 if($value->idiomas_count>0){
                    $value->idiomas_count=100;
                }
                $value["porcentaje_hv"]=($value->datos_basicos_count * 0.3) + ($value->perfilamiento_count * 0.08) + ($value->experiencias_count*0.15)  + ($value->estudios_count*0.1)  + ($value->grupo_familiar_count * 0.13)+($value->idiomas_count*0.07) + ($value->documentos_count*0.17);

                foreach ($value->getProcesos() as $clave => $proc) {
                    if($proc->proceso == "ENVIO_CONTRATACION_CLIENTE"){
                        $contrato_cliente = true;
                        $n += 1; 
                    }
                    
                    if($proc->proceso == "ENVIO_CONTRATACION"){
                        $contrato = true;
                        $n += 1;
                    }
                }

                if($contrato_cliente && !$contrato){
                    $value["important"] = 1;
                }else{
                   $value["important"] = 0;
                   $item = $candidatos_req->pull($key);
                   $candidatos_req->push($item);
                }

                $contrato_cliente = false;
                $contrato = false;
            }
        }

        $candidatos_reclutamiento_externo = CandidatoReclutamientoExterno::join("datos_basicos", "datos_basicos.user_id", "=", "candidatos_reclutamiento_externo.candidato_id")
        ->where("candidatos_reclutamiento_externo.req_id",$req_id)
        ->select(
            "datos_basicos.nombres",
            "datos_basicos.numero_id",
            "datos_basicos.telefono_movil",
            "datos_basicos.email",
            "datos_basicos.user_id"

        )
        ->groupBy('candidatos_reclutamiento_externo.candidato_id')
        ->paginate(5, ["*"], "reclutados");

        $numero_llamadas = LlamadaMensaje::join('requerimientos', 'requerimientos.id', '=', 'llamada_mensaje.req_id')
        ->where('llamada_mensaje.req_id', $req_id)
        ->where('llamada_mensaje.user_llamada', $this->user->id)
        ->get()
        ->count();

        $llamadas_hechas = LlamadaMensaje::get()->count();

        $llamadas_totales = Sitio::select(DB::raw(' SUM(sitio.numero_llamadas) as num_llamadas'))
        ->first();

        $llamadas_restantes =  $llamadas_totales->num_llamadas - $llamadas_hechas ; 

        $candidatos_postulados = CandidatosFuentes::where(
        'requerimiento_id', $req_id)
        ->select('*')
        ->get();

        $entrevista_virtual = EntrevistaVirtual::where('req_id',$req_id)->count();

        $candidatos_fuentes = CandidatosFuentes::where("requerimiento_id", $req_id)
        ->paginate(5,["*"],"fuentes");

        $estado_req = EstadosRequerimientos::join("estados", "estados.id", "=", "estados_requerimiento.estado")->where("req_id", $req_id)
        ->select("estados.descripcion as estado_nombre", "estados.id as estados_req")
        ->orderBy("estados_requerimiento.id", "desc")
        ->first();

        $candidatos_contratados = [];

        //CONSULTAR CANDIDATOS ENVIADOS
        foreach ($candidatos_req as $key => $value) {
            if(!in_array($value->estado_id, $this->estados_no_muestra)) {
                if ($value->estado_id == config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')) {
                    array_push($candidatos_contratados, $value->user_id);
                }
            }
        }

        $grafica = PreliminarTranversalesCandidato::join("preliminar_transversales", "preliminar_transversales.id", "=", "preliminar_transversales_candidato.transversal_id")
        ->join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "preliminar_transversales_candidato.candidato_id")
        ->join("criterios_competencias", "criterios_competencias.valor", "=", "preliminar_transversales_candidato.puntuacion")
        ->where("requerimiento_cantidato.requerimiento_id", $req_id)
        ->where("preliminar_transversales_candidato.req_id", $req_id)
        ->whereNotIn("requerimiento_cantidato.estado_candidato", [config('conf_aplicacion.C_QUITAR'), config('conf_aplicacion.C_INACTIVO')])
        ->select(
            "preliminar_transversales_candidato.candidato_id",
            "preliminar_transversales.descripcion",
            "preliminar_transversales_candidato.puntuacion",
            "preliminar_transversales_candidato.id",
            "criterios_competencias.descripcion as criterio"
        )
        ->get();

        $usuarios = PreliminarTranversalesCandidato::join("preliminar_transversales", "preliminar_transversales.id", "=", "preliminar_transversales_candidato.transversal_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "preliminar_transversales_candidato.candidato_id")
        ->join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "preliminar_transversales_candidato.candidato_id")
        ->where("preliminar_transversales_candidato.req_id", $req_id)
        ->where("requerimiento_cantidato.requerimiento_id", $req_id)
        ->whereNotIn("requerimiento_cantidato.estado_candidato", [config('conf_aplicacion.C_QUITAR'), config('conf_aplicacion.C_INACTIVO')])
        ->select(
            "datos_basicos.nombres",
            "preliminar_transversales_candidato.candidato_id",
            "preliminar_transversales.descripcion",
            "preliminar_transversales_candidato.puntuacion",
            "preliminar_transversales_candidato.id"
        )
        ->groupBy("preliminar_transversales_candidato.candidato_id")
        ->get();

        $valores = [];

        foreach($grafica as $value){
            $valores[$value->descripcion][$value->candidato_id] = $value->criterio;
        }
        
        $ideal_req = RequerimientoCompetencia::join("preliminar_transversales","preliminar_transversales.id","=","requerimiento_competencia.competencia_id")
        ->where("req_id",$req_id)
        ->select(
            "preliminar_transversales.descripcion",
            "requerimiento_competencia.ideal"
        )
        ->get();

        if($ideal_req != null){
            foreach($ideal_req as $value){
                $valores[$value->descripcion]["0000000"] = $value->ideal;
            }
        }

        //Diagrama de curva de ajuste al perfil
        $ajuste_perfil = \Lava::DataTable();
        $ajuste_perfil->addStringColumn('Reasons');

        //$ajuste_perfil->addNumberColumn('Ideal');
        foreach($usuarios as $value){
            $nombre = "";
            $nombre = ucwords(mb_strtolower($value->nombres));
            $ajuste_perfil->addNumberColumn($nombre);
        }

        if($ideal_req != null){
            $ajuste_perfil->addNumberColumn("Ideal");
        }

        foreach ($valores as $key => $value) {
            $array = [];
            array_push($array, $key);

            foreach ($value as $val) {
                array_push($array, $val);
            }

            $ajuste_perfil->addRow($array);
        }


        \Lava::LineChart('Temps', $ajuste_perfil, [
            'title'  => 'CURVA DE AJUSTE AL PERFIL',
            'events' => [
                'ready' => "getpreliminar",
            ],
        ]);
        
        $prueba_idioma = PruebaIdioma::where('req_id',$req_id)->count();

        $empresa_logo = ["" => "Selecciona"];
        
        if(route("home") == "https://desarrollo.t3rsc.co" || route("home") == "https://pruebaslistos.t3rsc.co" ||
            route("home") == "https://listos.t3rsc.co" || route("home") == "https://vym.t3rsc.co"){
            $empresa_logo = ["" => "Seleccion"] + EmpresaLogo::pluck("nombre_empresa", "id")->toArray();
        }

        $motivos_anulacion = ["" => "Seleccionar"] + MotivoAnulacion::pluck("descripcion", "id")->toArray();

        /**
        * Lista vinculante acceso
        */

        $lista_vinculante_acceso = FuncionesGlobales::getListaVinculanteAcceso($cliente->id);

        return view("admin.reclutamiento.gestion-new", compact(
            "solicitud",
            // "reqCandidato",
            "llamadas_restantes",
            "numero_llamadas",
            "entrevista_virtual",
            "preguntas_req",
            // "entre",
            // "asistencia",
            "sitio",
            "sitioModulo",
            "user_sesion",
            "candidatos_contratados",
            "requermiento",
            "negocio",
            "cliente",
            "candidatos_req",
            "candidatos_cargo_general",
            "candidatos_fuentes",
            "estado_req",
            "centro_costo",
            "candidatos_postulados",
            "datos_ficha",
            "valida_botones",
            // "valor",
            "grafica",
            "contra_cliente",
            "prueba_idioma",
            "boton",
            "cerrado",
            "empresa_logo",
            "candidatos_reclutamiento_externo",
            "n",
            "motivos_anulacion",
            "lista_vinculante_acceso"
        ));
    }

    public function filtro_preperfilados(Request $request)
    {
        $user_sesion = $this->user;
        $solicitud="";
        $filtro = $request->filtro;
        $req_id = $request->req_id;
        $sitio = Sitio::first();

        $requermiento = Requerimiento::find($req_id);

        $candidatos_cargo_general = DatosBasicos::join("candidatos_preperfilados", "candidatos_preperfilados.candidato_id", "=", "datos_basicos.user_id")
        ->leftjoin("estudios", "estudios.user_id", "=", "datos_basicos.user_id")
        ->leftjoin('experiencias','datos_basicos.numero_id','=','experiencias.numero_id')
        ->join('users','users.id','=','datos_basicos.user_id')
        ->where("candidatos_preperfilados.req_id", $req_id)
        ->whereNotIn('datos_basicos.estado_reclutamiento', [config('conf_aplicacion.C_INACTIVO'), config('conf_aplicacion.C_BAJA_VOLUNTARIA'), config('conf_aplicacion.PROBLEMA_SEGURIDAD')])
        ->where(function ($where) use ($filtro) {
            if($filtro != ""){
                $where->whereRaw("( LOWER(experiencias.cargo_especifico) like '%" . $filtro . "%'or LOWER(experiencias.funciones_logros) like '%" . $filtro . "%'or LOWER(datos_basicos.descrip_profesional) like '%" . $filtro . "%') ");
            }
        })
        ->select(
            'datos_basicos.*',
            'candidatos_preperfilados.id as id_preperfil',
            'candidatos_preperfilados.ajuste as ajuste_perfil'
        )
        ->orderBy("candidatos_preperfilados.ajuste","DESC")
        ->groupBy("datos_basicos.user_id")
        ->get();

        $estado_req = EstadosRequerimientos::join("estados", "estados.id", "=", "estados_requerimiento.estado")
        ->where("req_id", $req_id)
        ->select(
            "estados.descripcion as estado_nombre",
            "estados.id as estados_req"
        )
        ->orderBy("estados_requerimiento.id", "desc")
        ->first();

        return response()->json([
            "success" => true,
            "view" => view("admin.reclutamiento.gestion_preperfilados", compact(
                "requermiento",
                "user_sesion",
                "candidatos_cargo_general",
                "sitio",
                "estado_req"
            ))
            ->render()
        ]);
    }

    public function filtro_aplicaron(Request $request)
    {
        $user_sesion = $this->user;
        $solicitud="";
        $filtro = $request->filtro;
        $req_id = $request->req_id;
        $sitio = Sitio::first();

        $candidatos_cargo_general = DatosBasicos::join("ofertas_users", "ofertas_users.user_id", "=", "datos_basicos.user_id")
        ->leftjoin("estudios", "estudios.user_id", "=", "datos_basicos.user_id")
        ->leftjoin('experiencias','datos_basicos.numero_id','=','experiencias.numero_id')
        ->join('users','users.id','=','datos_basicos.user_id')
        ->where("ofertas_users.requerimiento_id", $req_id)
        ->whereNotIn("datos_basicos.estado_reclutamiento", [config('conf_aplicacion.C_INACTIVO'), config('conf_aplicacion.C_BAJA_VOLUNTARIA'), config('conf_aplicacion.PROBLEMA_SEGURIDAD')])
        ->where("ofertas_users.estado", 1)
        ->where(function ($where) use ($filtro) {
            if($filtro != ""){
                $where->whereRaw("( LOWER(experiencias.cargo_especifico) like '%" . $filtro . "%'or datos_basicos.numero_id like '" . $filtro . "%' or LOWER(experiencias.funciones_logros) like '%" . $filtro . "%'or LOWER(datos_basicos.descrip_profesional) like '%" . $filtro . "%') ");
            }
        })
        ->select(
            'datos_basicos.*',
            'ofertas_users.id as id_aplicaron',
            'ofertas_users.created_at as fecha_aplicacion'
        )
        ->groupBy("datos_basicos.user_id")
        ->get();

        return response()->json([
            "success" => true,
            "view" => view("admin.reclutamiento.gestion_aplicaron", compact(
                "user_sesion",
                "candidatos_cargo_general",
                "sitio"
            ))
            ->render()
        ]);
    }

    public function mostrar_datos(Request $data)
    {
        $ae = DatosBasicos::find($data->datos_basicos_id);
        $ae->datos_basicos_activo = 1;
        $ae->save();

        return response()->json(["success" => true]);  
    }

    public function no_mostrar_datos(Request $data)
    {
        $ae = DatosBasicos::find($data->datos_basicos_id);
        $ae->datos_basicos_activo = 0;
        $ae->save();

        return response()->json(["success" => true]);
    }

    public function detalle_requerimiento(Request $data)
    {
        $requerimiento = Requerimiento::join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
        ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->join("cargos_especificos", "cargos_genericos.id", "=", "cargos_especificos.cargo_generico_id")
        ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->join("tipos_contratos", "tipos_contratos.id", "=", "requerimientos.tipo_contrato_id")
        ->join("tipos_experiencias", "tipos_experiencias.id", "=", "requerimientos.tipo_experiencia_id")
        ->join("generos", "generos.id", "=", "requerimientos.genero_id")
        ->join("tipos_jornadas", "tipos_jornadas.id", "=", "requerimientos.tipo_jornadas_id")
        ->join("users", "users.id", "=", "requerimientos.solicitado_por")
        ->select(
            "cargos_especificos.descripcion as cargo_especifico",
            "requerimientos.*",
            "motivo_requerimiento.descripcion as motivo_req",
            "cargos_genericos.descripcion as nombre_cargo",
            "tipo_proceso.descripcion as tipo_desc",
            "tipos_contratos.descripcion as tipo_contrato",
            "tipos_experiencias.descripcion as tipo_experiencia",
            "generos.descripcion as genero_desc",
            "tipos_jornadas.descripcion as tipo_jornadas_desc",
            "users.name as nombre_solicitado"
        )
        ->where("requerimientos.id", $data->get("id"))
        ->first();

        $negocio = Negocio::find($requerimiento->negocio_id);
        $cliente = Clientes::find($negocio->cliente_id);

        $candidatos = "";

        return view("admin.reclutamiento.modal.detalle_req", compact(
            "requerimiento",
            "negocio",
            "cliente"
        ));
    }

    // Envio prueba idioma
    public function enviar_prueba_idioma(Request $data)
    {
        $campos = [
            'requerimiento_candidato_id' => $data->get("candidato_req"),
            'usuario_envio'              => $this->user->id,
            "fecha_inicio"               => date("Y-m-d H:i:s"),
            'proceso'                    => "ENVIO_PRUEBA_IDIOMA",
        ];

        $userEnvio = DatosBasicos::where('user_id', $this->user->id)->first();

        $usuario = $userEnvio->nombres." ".$userEnvio->primer_apellido;

       $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));
       
        $req_id = $data->req_id;
        $user_id = $data->user_id;

        $datos_basicos = DatosBasicos::where("user_id", $data->get("user_id"))->first();
        $cliente = Clientes::where('clientes.id',$data->cliente_id)->first();
        
        $sitio = Sitio::first();

        if (isset($sitio->nombre)) {
            if ($sitio->nombre != "") {
                
                $nombre = $sitio->nombre;

            }else {

                $nombre = "Desarrollo";

            }
        }

        $urls = route('home.prueba-idioma-virtual',['user_id'=>$user_id,'req_id'=>$req_id]);
        $url = str_replace("http://", "https://", $urls);

        $nombre_cliente = $cliente->nombre;
        $nombres = $datos_basicos->nombres;

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Video Prueba Idioma"; //Titulo o tema del correo

        $asunto = "Invitación a prueba de idioma de oferta de empleo $nombre_cliente";

        $emails = $datos_basicos->email;

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "
                Bienvenid@ ".$nombres.", en ".$nombre." estamos felices de que participes en nuestros procesos de selección, hemos revisado tu perfil y nos gustaría conocerte un poco más. Te invitamos a que realices la siguiente prueba de idioma la cual presentarás a través de la grabación de 3 videos respondiendo a las preguntas que el analista de selección ha preparado para ti. 
                    <br/><br/>
                    A continuación te daremos unos tips que te ayudarán a tener un mejor desempeño en la prueba de idioma.
                    <br/><br/>

                    <ol>
                        <li>
                            Prepara el espacio a tu alrededor, recomendable que no tengas elementos que distraigan al entrevistador. 
                        </li>

                        <li>
                            Minimiza posibles interrupciones, pon tu celular en silencio y evita elementos que puedan distraerte.
                        </li>

                        <li>
                            Comprueba la funcionalidad de tu equipo y los permisos de acceso a tu cámara y micrófono.
                        </li>

                        <li> 
                            Mira a la cámara, como si se tratara de tu interlocutor. Así mostrarás seguridad en ti mismo.
                        </li>
                                 
                        <li>
                            Sé tu mismo y actúa con naturalidad. 
                        </li>
                    </ol>
            ";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'REALIZAR PRUEBA IDIOMA', 'buttonRoute' => $url];

        $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

        //$mailAditionalTemplate = ['nameTemplate' => 'prueba_idioma', 'dataTemplate' => []];

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        //Envio de email
        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $asunto, $nombre, $sitio) {

                    $message->to($datos_basicos->email, $datos_basicos->nombres)
                            ->bcc($sitio->email_replica)
                            ->subject($asunto)
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

        return response()->json(["success" => true]);
    }

    public function video_entrevista(Request $data)
    {
        $campos = [
            'requerimiento_candidato_id' => $data->get("candidato_req"),
            'usuario_envio'              => $this->user->id,
            "fecha_inicio"               => date("Y-m-d H:i:s"),
            'proceso'                    => "ENVIO_ENTREVISTA_VIRTUAL",
        ];

        $userEnvio = DatosBasicos::where('user_id', $this->user->id)->first();

        $usuario = $userEnvio->nombres." ".$userEnvio->primer_apellido;

        $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));
       
        $req_id = $data->req_id;
        $user_id = $data->user_id;

        $datos_basicos = DatosBasicos::where("user_id", $data->get("user_id"))->first();
        $cliente = Clientes::where('clientes.id',$data->cliente_id)->first();

        $funcionesGlobales = new FuncionesGlobales();

        if (isset($funcionesGlobales->sitio()->nombre)) {
            if ($funcionesGlobales->sitio()->nombre != "") {
                $nombre = $funcionesGlobales->sitio()->nombre;
            } else {
                $nombre = "Desarrollo";
            }
        }

        $urls = route('home.video_entrevista_virtual',['user_id'=>$user_id,'req_id'=>$req_id]);

        $url = str_replace("http://", "https://", $urls);

        $nombre_cliente = $cliente->nombre; 
        $nombres = $datos_basicos->nombres;
        $asunto = "Invitación a video entrevista de oferta de empleo $nombre_cliente";
        $emails = $datos_basicos->email;

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Video Entrevista Virtual"; //Titulo o tema del correo
        
        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "Bienvenid@ ".$nombres.", en ".$nombre." estamos felices de que participes en nuestros procesos de selección, hemos revisado tu perfil y nos gustaría conocerte un poco más. Te invitamos a que realices la siguiente video entrevista la cual presentarás a través de la grabación de 3 videos respondiendo a las preguntas que el analista de selección ha preparado para ti. 
            <br/><br/>
            A continuación te daremos unos tips que te ayudarán a tener un mejor desempeño en la video entrevista.
            <br/><br/>

            <ol>
                <li>
                    Prepara el espacio a tu alrededor, recomendable que no tengas elementos que distraigan al entrevistador. 
                </li>

                <li>
                    Minimiza posibles interrupciones, pon tu celular en silencio y evita elementos que puedan distraerte.
                </li>

                <li>
                    Comprueba la funcionalidad de tu equipo y los permisos de acceso a tu cámara y micrófono.
                </li>

                <li> 
                    Mira a la cámara, como si se tratara de tu interlocutor. Así mostrarás seguridad en ti mismo.
                </li>
                         
                <li>
                    Sé tu mismo y actúa con naturalidad. 
                </li>
            </ol>";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'REALIZAR VIDEO ENTREVISTA', 'buttonRoute' => $url];

        $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

        //$mailAditionalTemplate = ['nameTemplate' => 'video_entrevista', 'dataTemplate' => []];

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);
        
        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($data, $emails, $asunto) {
                $message->to($emails, "$nombre - T3RS")
                ->subject($asunto)
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    
             });

        return response()->json(["success" => true]);
    }

    public function agregar_candidato_preperfilados(Request $data)
    {
        $errores_array     = [];
        $success           = true;
        $guardar           = true;
        $errores_array_req = [];

        if (is_array($data->get("aplicar_candidatos_preperfilado")) && $data->get("aplicar_candidatos_preperfilado") != "") {

            foreach($data->get("aplicar_candidatos_preperfilado") as $key => $value){

                $datos = DB::table("requerimiento_cantidato")
                    ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                    ->whereRaw(" requerimiento_cantidato.estado_candidato not in ( " . implode(",", $this->estados_no_muestra) . " )  ")
                    ->where("requerimiento_cantidato.candidato_id", $value)
                    ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_ACTIVO'));

                if($datos->count() > 0) {
                  
                    $req = $datos->select("requerimiento_cantidato.requerimiento_id", "requerimiento_cantidato.id as candidato_req", "datos_basicos.*")->first();
                    //BUSCAR QUIEN LO INGRESO
                    $usuario_regitro = RegistroProceso::
                        where("requerimiento_candidato_id", $req->candidato_req)
                    //->where("estado", config('conf_aplicacion.C_RECLUTAMIENTO'))
                        ->first();

                    $datos_basicos = DatosBasicos::where("user_id", $value)->first();

                   array_push($errores_array_req, "<li>  <input type='hidden' name='req_" . $req->candidato_req . "' value='" . $req->requerimiento_id . "'> <input type='checkbox' name='candidato_req[]' value='" . $req->candidato_req . "'>   EL candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> actualmente se encuentra asignado al requerimiento <strong>" . $req->requerimiento_id . "</strong> el cual fue asociado por <strong>" . $usuario_regitro->usuarioRegistro()->name . "</strong> el pasado " . $usuario_regitro->created_at . " .</li>");

                    $success = false;

                }else{
                    $guardar = true;

                    //VERIFICAR SI TIENE EL 100% DE LA HV
                    $datos_basicos = DatosBasicos::where("user_id", $value)->select("*")->first();

                    if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD')) {
                        $lista_negra = ListaNegra::leftjoin('tipos_restricciones', 'tipos_restricciones.id', '=', 'lista_negra.restriccion_id')
                            ->select('tipos_restricciones.descripcion as restriccion')
                            ->where('cedula', $datos_basicos->numero_id)
                            ->orderBy('lista_negra.id', 'desc')
                        ->first();

                        if($lista_negra != null && $lista_negra->restriccion != null) {
                            $mensaje_error = '<li>El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> no se puede asociar al requerimiento porque presenta problemas de seguridad.<br>Se encuentra '. $lista_negra->restriccion .'</li><br><div style="background-color: red; height: 50px"></div>';
                        } else {
                            $mensaje_error = '<li>El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> no se puede asociar al requerimiento porque presenta problemas de seguridad.</li><br><div style="background-color: red; height: 50px"></div>';
                        }
                        $guardar = false;
                        array_push($errores_array_req, $mensaje_error);
                    } else if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_BAJA_VOLUNTARIA') || $datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO')) {
                        //Si esta inactivo
                        if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO')) {
                            $auditoria = Auditoria::where('tabla', 'datos_basicos')
                                ->where('tabla_id', $datos_basicos->id)
                                ->whereIn('tipo', ['ACTUALIZAR', 'RECHAZAR_CANDIDATO_INACTIVAR'])
                                ->orderBy('id', 'desc')
                            ->first();

                            if (is_null($auditoria)) {
                                $auditoria = collect(['observaciones' => '']);
                            } else {
                                if ($auditoria->tipo == 'RECHAZAR_CANDIDATO_INACTIVAR') {
                                    //Si se rechazo el candidato desde un Requerimiento, se busca la observacion
                                    $proceso = RegistroProceso::where('candidato_id', $datos_basicos->user_id)
                                        ->where('proceso', 'RECHAZAR_CANDIDATO')
                                        ->orderBy('id', 'desc')
                                    ->first();

                                    if (!is_null($proceso)) {
                                        $auditoria->observaciones = $proceso->observaciones;
                                    }
                                }
                            }

                            array_push($errores_array_req, "<li>EL candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> NO se puede agregar porque tiene un estado inactivo.<br>Observación: $auditoria->observaciones</li>");
                        } else {
                            array_push($errores_array_req, "<li>EL candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> NO se puede agregar porque solicitó baja voluntaria en la plataforma.</li>");
                        }
                        $guardar = false;
                    }

                    if($guardar){

                        $req   = $datos_basicos;

                        //CAMBIA ESTADO AL CANDIDATO
                        $candidato = DatosBasicos::where("user_id", $value)->first();
                        $candidato->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                        $candidato->save();

                        //ASOCIO EL CANDIDATO AL REQUERIMIENTO
                        $nuevo_candidato_req = new ReqCandidato();
                        $nuevo_candidato_req->fill(["estado_candidato" => config('conf_aplicacion.C_EN_PROCESO_SELECCION'), 'requerimiento_id' => $data->get("requerimiento_id"), 'candidato_id' => $value]);
                        $nuevo_candidato_req->save();

                        //CREO EL ESTADO DE INGRESO A REQUERIMIENTO
                        $nuevo_proceso = new RegistroProceso();

                        $nuevo_proceso->fill(
                            [
                                'requerimiento_candidato_id' => $nuevo_candidato_req->id,
                                'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                                'fecha_inicio'               => date("Y-m-d H:i:s"),
                                'usuario_envio'              => $this->user->id,
                                'requerimiento_id'           => $data->get("requerimiento_id"),
                                'candidato_id'               => $value,
                                'observaciones'              => "Ingreso al requerimiento",
                                'proceso'                    => "ASIGNADO_REQUERIMIENTO",
                            ]
                        );
                        $nuevo_proceso->save();

                        $sitio = Sitio::first();
                        if ($sitio->esProcesoEnSitio($data->get("requerimiento_id"))) {
                            $campos = [
                                'requerimiento_candidato_id'    => $nuevo_candidato_req->id,
                                'usuario_envio'                 => $this->user->id,
                                "fecha_inicio"                  => date("Y-m-d H:i:s"),
                                'proceso'                       => "ENVIO_APROBAR_CLIENTE",
                                'observaciones'                 => "Se ha enviado a aprobar por el cliente desde preperfilados"
                            ];

                            //Se crea el proceso evaluacion del cliente
                            $this->RegistroProceso($campos, config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), $nuevo_candidato_req->id);
                        }

                        //BUSCAR EN CANDIDATOS DE OTRAS FUENTES PARA ELIMINARLO
                        if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co"){
                            //Solo para komatsu que no lo elimine, sino que cambie su status
                            $datos_ot = CandidatosFuentes::where("cedula", $candidato->numero_id)
                            ->where("requerimiento_id", $data->get("requerimiento_id"))->get();
                            $datos_ot->status=0;
                            $datos_ot->save();
                        }
                        else{
                            //se elmina de la tabla 
                            $datos_ot = CandidatosFuentes::where("cedula", $candidato->numero_id)
                                ->where("requerimiento_id", $data->get("requerimiento_id"))
                            ->delete();
                        }

                        //EVENTO CAMBIA ESTADO REQUERIMIENTO
                        $obj                   = new \stdClass();
                        $obj->requerimiento_id = $data->get("requerimiento_id");
                        $obj->user_id          = $this->user->id;
                        $obj->estado           = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                        Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));

                        if (!in_array("<li>Se han agregado los candidatos con éxito.</li>", $errores_array)) {
                            array_push($errores_array, "<li>Se han agregado los candidatos con éxito.</li>");
                        }

                        //Se cambia el estado del requerimiento al enlazarlo con un candidato
                        $obj                   = new \stdClass();
                        $obj->requerimiento_id = $data->get("requerimiento_id");
                        $obj->user_id          = $this->user->id;
                        $obj->estado           = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                        Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));

                        $user_sesion = $this->user;

                        if($user_sesion->hasAccess("email_candidato_req")){

                            $nombre = "Desarrollo";
                            if(isset($sitio->nombre)) {
                                if($sitio->nombre != "") {
                                    $nombre = $sitio->nombre;
                                }
                            }
                                    
                            $home =  route('home');

                            $urls = route('home.detalle_oferta', ['oferta_id' => $data->get("requerimiento_id")]);
                          
                            $req_can_id = $nuevo_candidato_req->id;
                                                //dd($req_can_id);    
                            $nombres = $candidato->nombres;
                            
                            $asunto = "Notificación de proceso de selección";
                            
                            $emails = $candidato->email;
                            $email_sin_espacio = trim($emails);

                            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                            $mailConfiguration = 1; //Id de la configuración
                            $mailTitle = ""; //Titulo o tema del correo

                            //Cuerpo con html y comillas dobles para las variables
                            $mailBody = "Buen día ".$nombres.", has sido elegido para realizar un proceso de selección con nosotros, por favor haz clic en siguiente botón, ahí podrás ver la información de la vacante. 
                                <br/><br/>
                                ¡ÉXITOS!";

                            //Arreglo para el botón
                            $mailButton = ['buttonText' => 'Oferta Laboral', 'buttonRoute' => $urls];

                            $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

                            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($data, $emails, $asunto, $nombre) {

                                $message->to($emails, "$nombre - T3RS")->subject($asunto)
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                            });
                        }
                    
                    }//fin de esto
                }
            }//foreach

        }else{
          
          $errores_array = ["<li>No se seleccionaron candidatos.</li>"];
        }

      return redirect()->route("admin.gestion_requerimiento", ["req_id" => $data->get("requerimiento_id")])->with("success", $success)->with("errores_array", $errores_array)->with("errores_array_req", $errores_array_req);

    }

    /*
        Transferir candidatos a el requerimiento
    */
    public function agregar_candidato(Request $data)
    {
        $errores_array     = [];
        $success           = true;
        $errores_array_req = [];
        $cargo_documentos = "";

        if(is_array($data->get("aplicar_candidatos")) && $data->get("aplicar_candidatos") != ""){
            foreach($data->get("aplicar_candidatos") as $key => $value){
                $datos = DB::table("requerimiento_cantidato")
                ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->join("requerimientos", "requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
                ->join("cargos_especificos", "cargos_especificos.id","=","requerimientos.cargo_especifico_id")
                ->whereRaw(" requerimiento_cantidato.estado_candidato not in ( " . implode(",", $this->estados_no_muestra) . " )  ")
                ->where("requerimiento_cantidato.candidato_id", $value)
                ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_ACTIVO'))
                ->select(
                    "requerimiento_cantidato.requerimiento_id",
                    "requerimiento_cantidato.id as candidato_req",
                    "datos_basicos.*",
                    "cargos_especificos.id as cargo",
                    "cargos_especificos.firma_digital as firma"
                )
                ->orderBy("requerimiento_cantidato.id","DESC")
                ->first();

                if( $datos != null ){
                    $req = $datos;

                    //BUSCAR QUIEN LO INGRESO
                    $usuario_regitro = RegistroProceso::where("requerimiento_candidato_id",$req->candidato_req)->first();
                    
                    // $req_anterior = $req->requerimiento_id;// guardar el req anterior
                    $datos_basicos = DatosBasicos::where("user_id", $value)->first();

                    if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
                        array_push($errores_array_req, "<li>  <input type='hidden' name='req_" . $req->candidato_req . "' value='" . $req->requerimiento_id . "'> <input type='checkbox' name='candidato_req[]' value='" . $req->candidato_req . "' checked>  EL candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> actualmente se encuentra asignado al requerimiento <strong>" . $req->requerimiento_id." ( ". $req->cargo . " ) " ."</strong> el cual fue asociado por <strong>" . $usuario_regitro->usuarioRegistro()->name . "</strong> el pasado " . $usuario_regitro->created_at . " .</li>");
                    }else{
                        array_push($errores_array_req, "<li>  <input type='hidden' name='req_" . $req->candidato_req . "' value='" . $req->requerimiento_id . "'> <input type='checkbox' name='candidato_req[]' value='" . $req->candidato_req . "' checked>  El candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> actualmente se encuentra asignado al requerimiento <strong>" . $req->requerimiento_id."</strong> el cual fue asociado por <strong>" . $usuario_regitro->usuarioRegistro()->name . "</strong> el pasado " . $usuario_regitro->created_at . " .</li>");
                    }

                    $success = false;
                }else{
                    //VERIFICAR SI TIENE EL 100% DE LA HV
                    $datos = DatosBasicos::where("user_id", $value)->select("*")->first();

                    $req = $datos;

                    //CAMBIA ESTADO AL CANDIDATO
                    $candidato = DatosBasicos::where("user_id", $value)->first();

                    $candidato->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                    $candidato->save();

                    //CAMBIAR ESTADO EN LA TABLA OFERTA_USERS
                    $oferta_user = OfertaUser::where("user_id",$value)
                    ->where("requerimiento_id",$data->get("requerimiento_id"))
                    ->first();

                    if(!is_null($oferta_user)){
                        $oferta_user->estado = 0;
                        $oferta_user->save();
                    }

                    //ASOCIA EL CANDIDATO AL REQUERIMIENTO
                    $nuevo_candidato_req = new ReqCandidato();

                    $nuevo_candidato_req->fill([
                        "estado_candidato" => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        "otra_fuente" => 1,
                        'requerimiento_id' => $data->get("requerimiento_id"),
                        'candidato_id' => $candidato->user_id
                    ]);
                        
                    $nuevo_candidato_req->save();

                    //CREA EL ESTADO DE INGRESO A REQUERIMIENTO
                    $nuevo_proceso = new RegistroProceso();

                    $nuevo_proceso->fill([
                        'requerimiento_candidato_id' => $nuevo_candidato_req->id,
                        'estado'                  => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        'fecha_inicio'            => date("Y-m-d H:i:s"),
                        'usuario_envio'           => $this->user->id,
                        'requerimiento_id'        => $data->get("requerimiento_id"),
                        'candidato_id'            => $value,
                        'observaciones'           => "Ingreso al requerimiento",
                        'proceso'                 => "ASIGNADO_REQUERIMIENTO",
                    ]);

                    $nuevo_proceso->save();

                    $sitio = Sitio::first();
                    if ($sitio->esProcesoEnSitio($data->get("requerimiento_id"))) {
                        $campos = [
                            'requerimiento_candidato_id'    => $nuevo_candidato_req->id,
                            'usuario_envio'                 => $this->user->id,
                            "fecha_inicio"                  => date("Y-m-d H:i:s"),
                            'proceso'                       => "ENVIO_APROBAR_CLIENTE",
                            'observaciones'                 => "Se ha enviado a aprobar por el cliente aplicaron"
                        ];

                        //Se crea el proceso evaluacion del cliente
                        $this->RegistroProceso($campos, config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), $nuevo_candidato_req->id);
                    }

                    //documentos del cargo para el cargo

                    $req = DB::table("requerimiento_cantidato")
                      ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                      ->join("requerimientos", "requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
                      ->join("cargos_especificos", "cargos_especificos.id","=","requerimientos.cargo_especifico_id")
                      ->whereRaw(" requerimiento_cantidato.estado_candidato not in ( " . implode(",", $this->estados_no_muestra) . " )  ")
                      ->where("requerimiento_cantidato.id", $nuevo_candidato_req->id)
                      ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_ACTIVO'))->select("requerimiento_cantidato.requerimiento_id", "requerimiento_cantidato.id as candidato_req", "datos_basicos.*" , "cargos_especificos.id as cargo","cargos_especificos.firma_digital as firma")->first();
                       
                       if($req->firma == 1){
                         $cargo_documentos = DocumentosCargo::join('tipos_documentos','tipos_documentos.id','=','cargo_documento.tipo_documento_id')->where('cargo_documento.cargo_especifico_id',$req->cargo)->where('tipos_documentos.categoria',1)->select('tipos_documentos.id','tipos_documentos.descripcion')->get();
                       }
                    
                    $req_anterior = $data["req_anterior"];

                    if($data->has('transferido') && $data->transferido == 1 ){
                        //replicar trazabilidad al nuevo requerimiento
                        //obtener los procesos viejos del candidato

                        $traer_taza = RegistroProceso::where('requerimiento_id', $req_anterior["$value"])
                        ->where('candidato_id', $value)
                        ->whereIn('proceso',[
                            'ENVIO_REFERENCIACION',
                            'ENVIO_ENTREVISTA',
                            'ENVIO_PRUEBAS',
                            'ENVIO_REFERENCIA_ESTUDIOS',
                            'ENVIO_DOCUMENTOS'

                        ])
                        /*->whereNotIn('proceso', [
                            'ENVIO_APROBAR_CLIENTE',
                            'ENVIO_CONTRATACION_CLIENTE',
                            'ENVIO_CONTRATACION',
                            'FIRMA_VIRTUAL_SIN_VIDEOS',
                            'FIN_CONTRATACION_VIRTUAL',
                            'PRE_CONTRATAR',
                            'ENVIO_ENTREVISTA_VIRTUAL',
                            'ASIGNADO_REQUERIMIENTO',
                            'FIRMA_CONF_MAN',
                            'ENVIO_EXAMENES',
                            'ENVIO_DOCUMENTOS',
                        ])*/
                        ->whereNotNull('apto')
                        ->get();

                        if(count($traer_taza) > 0){
                            foreach($traer_taza as $item){

                                if($item->proceso=="ENVIO_PRUEBAS"){
                                    $pruebas = GestionPrueba::join("users", "users.id", "=", "gestion_pruebas.user_id")
                                    ->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "gestion_pruebas.id")
                                    ->leftjoin("tipos_pruebas", "tipos_pruebas.id", "=", "gestion_pruebas.tipo_prueba_id")
                                    ->where("gestion_pruebas.candidato_id",$value)
                                    ->where("proceso_requerimiento.requerimiento_id", $req_anterior["$value"])
                                    ->where("proceso_requerimiento.activo", "1")
                                    ->select("proceso_requerimiento.*")
                                    ->get();

                                    foreach($pruebas as $prueba){
                                        $n_p_r= new ProcesoRequerimiento();
                                        $n_p_r->tipo_entidad=$prueba->tipo_entidad;
                                        $n_p_r->entidad_id=$prueba->entidad_id;
                                        $n_p_r->requerimiento_id= $data->get("requerimiento_id");
                                        $n_p_r->user_id=$prueba->user_id;
                                        $n_p_r->save();
                                    }
                                }
                                elseif($item->proceso=="ENVIO_ENTREVISTA"){

                                     $entrevistas = EntrevistaCandidatos::join("users", "users.id", "=", "entrevistas_candidatos.user_gestion_id")
                                        ->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "entrevistas_candidatos.id")
                                        ->join("tipo_fuente", "tipo_fuente.id", "=", "entrevistas_candidatos.fuentes_publicidad_id")
                                        ->where("entrevistas_candidatos.candidato_id",$value)
                                         ->where("proceso_requerimiento.requerimiento_id",$req_anterior["$value"])
                                        ->where("proceso_requerimiento.activo", "1")
                                        ->select("proceso_requerimiento.*")
                                        ->get();

                                         foreach( $entrevistas as $entrevista){
                                            $n_p_r= new ProcesoRequerimiento();
                                            $n_p_r->tipo_entidad=$entrevista->tipo_entidad;
                                            $n_p_r->entidad_id=$entrevista->entidad_id;
                                            $n_p_r->requerimiento_id= $data->get("requerimiento_id");
                                            $n_p_r->user_id=$entrevista->user_id;
                                            $n_p_r->save();
                                        }

                                }elseif($item->proceso == "ENVIO_REFERENCIACION") {
                                    //EXPERIENCIAS VERIFICADAS
                                    $experiencias_verificadas = ExperienciaVerificada::join("experiencias", "experiencias.id", "=", "experiencia_verificada.experiencia_id")
                                    ->leftjoin("motivos_retiros", "motivos_retiros.id", "=", "experiencia_verificada.motivo_retiro_id")
                                    ->join("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
                                    ->where("experiencias.user_id", $value)
                                    ->where("experiencia_verificada.req_id", $req_anterior["$value"])
                                    ->select(
                                        "experiencias.*",
                                        "motivos_retiros.*",
                                        "cargos_genericos.*",
                                        "experiencia_verificada.*",
                                        "experiencia_verificada.meses_laborados as meses",
                                        "experiencia_verificada.anios_laborados as años",
                                        "cargos_genericos.descripcion as name_cargo",
                                        "motivos_retiros.descripcion as name_motivo",
                                        "experiencias.fecha_inicio as exp_fecha_inicio",
                                        "experiencias.fecha_final as exp_fechafin")
                                    ->get()->toArray();

                                    foreach($experiencias_verificadas as $exp){
                                        $n_exp_ver = new ExperienciaVerificada();
                                        $n_exp_ver->fill($exp);
                                        $n_exp_ver->req_id= $data->get("requerimiento_id");
                                        $n_exp_ver->save();
                                    }

                                    //REFERENCIAS PERSONALES VERIFICADAS
                                    $ref_per_ver = ReferenciaPersonalVerificada::join("referencias_personales", "referencias_personales.id", "=", "ref_personales_verificada.referencia_personal_id")
                                    ->where("ref_personales_verificada.candidato_id", $value)
                                    ->where("ref_personales_verificada.req_id", $req_anterior["$value"])
                                    ->get()->toArray();

                                    foreach($ref_per_ver as $ref_per){
                                        $n_ref_per = new ReferenciaPersonalVerificada();
                                        $n_ref_per->fill($ref_per);
                                        $n_ref_per->req_id= $data->get("requerimiento_id");
                                        $n_ref_per->save();
                                    }
                                }elseif($item->proceso == 'ENVIO_REFERENCIA_ESTUDIOS'){
                                    //En este caso no se requiere mas nada especial
                                }elseif($item->proceso == 'ENVIO_DOCUMENTOS'){
                                    //VALIDA SI EL DOCUMENTOS YA FUE VERIFICADO EN ESTE REQUERIMIENTO
                                    $req_gestion = DocumentosVerificados::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "documentos_verificados.id")
                                        ->select("proceso_requerimiento.*")
                                        ->where("proceso_requerimiento.candidato_id", $value)
                                        ->where("proceso_requerimiento.requerimiento_id", $req_anterior["$value"])
                                        ->where("proceso_requerimiento.tipo_entidad", "MODULO_DOCUMENTO")
                                    ->get();

                                    if (count($req_gestion) > 0) {
                                        foreach ($req_gestion as $doc) {
                                            $relacionProceso = new ProcesoRequerimiento();
                                            $relacionProceso->fill([
                                                "tipo_entidad"      => "MODULO_DOCUMENTO",
                                                "entidad_id"        => $doc->entidad_id,
                                                "requerimiento_id"  => $data->requerimiento_id,
                                                "user_id"           => $doc->user_id,
                                                "resultado"         => $doc->resultado,
                                                "observacion"       => $doc->observacion
                                            ]);
                                            $relacionProceso->save();
                                        }
                                    }
                                }

                                $nuevo_proceso = new RegistroProceso();

                                $nuevo_proceso->fill([
                                    'requerimiento_candidato_id' => $nuevo_candidato_req->id,
                                    'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                                    'fecha_inicio'               => date("Y-m-d H:i:s"),
                                    'usuario_envio'              => $this->user->id,
                                    'requerimiento_id'           => $data->get("requerimiento_id"),
                                    'candidato_id'               => $item->candidato_id,
                                    'observaciones'              => $item->observaciones,
                                    'proceso'                    => $item->proceso,
                                    'apto'                       => $item->apto
                                ]);

                                $nuevo_proceso->save();
                            }
                            //aca se deben pasar los procesos reales
                        }
                    }

                    //BUSCAR EN CANDIDATOS DE OTRAS FUENTES PARA ELIMINARLO
                    $datos_ot = CandidatosFuentes::where("cedula", $candidato->numero_id)
                    ->where("requerimiento_id", $data->get("requerimiento_id"))
                    ->delete();

                    //EVENTO CAMBIA ESTADO REQUERIMIENTO
                    $obj                   = new \stdClass();
                    $obj->requerimiento_id = $data->get("requerimiento_id");
                    $obj->user_id      = $this->user->id;
                    $obj->estado  =  config('conf_aplicacion.C_EN_PROCESO_SELECCION');

                    Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));

                    if (!in_array("<li>Se han agregado los candidatos con éxito.</li>", $errores_array)) {
                        array_push($errores_array, "<li>Se han agregado los candidatos con éxito.</li>");
                    }

                    //Se cambia el estado del requerimiento al enlazarlo con un candidato
                    $obj                   = new \stdClass();
                    $obj->requerimiento_id = $data->get("requerimiento_id");
                    $obj->user_id          = $this->user->id;
                    $obj->estado           = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                    
                    Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));

                    //EMAIL A LOS CANDIDATOS ENLAZADOS AL REQUERIMIENTO
                    $user_sesion = $this->user;
                                           
                    if ($user_sesion->hasAccess("email_candidato_req")) {
                        $funcionesGlobales = new FuncionesGlobales();
                            
                        if (isset($funcionesGlobales->sitio()->nombre)) {
                            if ($funcionesGlobales->sitio()->nombre != "") {
                                $nombre_empresa = $funcionesGlobales->sitio()->nombre;
                            }else{
                                $nombre_empresa = "Desarrollo";
                            }
                        }

                    //**************correo de asocian candidato a requerimiento***********************
                        $home =  route('home');
                        $urls = route('home.detalle_oferta', ['oferta_id' => $data->get("requerimiento_id")]);
                        $req_can_id = $nuevo_candidato_req->id;
                        $nombres = $candidato->nombres;
                        $nombre = ucwords(strtolower($nombres));
                                            
                        $asunto = "Notificación de proceso de selección";
                        
                        $emails = $candidato->email;

                        $mensaje = "Es un gusto para nosotros que seas parte de este proceso de selección, haz clic en el siguiente botón, donde podrás encontrar la información de la vacante.";
                        
                        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                        $mailConfiguration = 1; //Id de la configuración
                        $mailTitle = "Notificación de Proceso de Selección"; //Titulo o tema del correo
                        
                        //Cuerpo con html y comillas dobles para las variables
                        $mailBody = '¡Hola, '.$nombre.'!
                            <br/><br/>
                            Es un gusto para nosotros que seas parte de este proceso de selección, haz clic en el siguiente botón, donde podrás encontrar la información de la vacante.
                            <br/><br/>
                            <b>¡Éxitos!</b>';

                        //Arreglo para el botón
                        $mailButton = ['buttonText' => 'OFERTA LABORAL', 'buttonRoute' => $urls];

                        $mailUser = $candidato->user_id; //Id del usuario al que se le envía el correo

                        if ( $cargo_documentos == "" ) {

                            $mailAditionalTemplate = [];
                            
                        }else{

                            $mailAditionalTemplate = ['nameTemplate' => 'proceso_seleccion', 'dataTemplate' => ["cargo_documentos" => $cargo_documentos]];
                        }

                        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser, $mailAditionalTemplate);

                                        /* return view("admin.enviar_email_candidato_gestion_req", compact("url","nombres", "asunto", "mensaje"));*/
                        if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'http://localhost:8000') {
                            Mail::send('admin.enviar_email_candidatos_otras_fuentes_listos', [
                                "home" => $home,
                                "cargo_documentos" => $cargo_documentos,
                                "url" => $urls,
                                "req_can_id" => $req_can_id,
                                "nombre" => $nombre
                            ], function($message) use ($data, $emails, $asunto) {
                                $message->to($emails, '$nombre - T3RS');
                                $message->subject($asunto)
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                            });
                        }else{
                            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($emails, $asunto, $nombre_empresa) {

                                    $message->to($emails, "$nombre_empresa - T3RS");
                                    $message->subject($asunto)
                                    ->getHeaders()
                                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                                });

                        }
                    }
                }// fin del if 
            }// fin del foreach de candidatos a agregar
        } else {
            $errores_array = ["<li>No se seleccionaron candidatos.</li>"];
        }

        if($data->ajax()){
            return $success;
        }

        return redirect()->route("admin.gestion_requerimiento", [
            "req_id" => $data->get("requerimiento_id")
        ])
        ->with("success", $success)
        ->with("errores_array", $errores_array)
        ->with("errores_array_req", $errores_array_req);
    }

    public function agregar_candidato_fuentes(Request $data)
    {
        $errores_array     = [];
        $success           = false;
        $guardar           = true;
        $errores_array_req = [];
        $nuevo_registro    = false;

        //agregar al req desde otras fuentes
        
        if($data->has("cedula")){
            //NUEVO (CREAR USUARIO)
            $datos = $data->all();
            $usuario_cargo = $this->user->id;

            //  $validator = $this->validate($data->all(),[
            //  "tipo_fuente_id" => "required",
            //  "nombres" => "required",
            //  "primer_apellido" => "required",
            //  "celular" => "required",
            //  "email" => "required"
            //  ]);

            $fuentes = ["" => "Seleccionar"] + TipoFuentes::pluck("descripcion", "id")->toArray();

            // $valida  = Validator::make($data->all(), $rules);
            // if($validator->fails()) {
            //  return response()->json(["success" => false,"view" => view("admin.reclutamiento.modal.nuevo_candidato", compact("fuentes", "datos"))->withInput($data->all())->withErrors($valida)->render()]);
            // }
            
            $datos_basicos = DatosBasicos::where('numero_id', $data->get("cedula"))->first();

            if(is_null($datos_basicos)){
                $existe_registro_email = DatosBasicos::where('email',$data->get("email"))->first();

                if(count($existe_registro_email) > 0){
                    //Este correo ya esta registrado
                    return response()->json([
                        "success" => false,
                        "mensaje" => "Este correo ya se encuentra registrado"
                    ]);
                }

                //Creamos el usuario
                $campos_usuario = [
                    'name' => $data->get("primer_nombre").' '.$data->get("segundo_nombre")." ".$data->get("primer_apellido").' '.$data->get("segundo_apellido"),
                    'email'     => $data->get("email"),
                    'password'  => $data->get("cedula"),
                    'numero_id' => $data->get("cedula"),
                    'cedula'    => $data->get("cedula"),
                    'metodo_carga' =>3,
                    'usuario_carga' =>$this->user->id,
                    'tipo_fuente_id' => $data->get("tipo_fuente_id")
                ];
                
                $validar_email = json_decode($this->verificar_email($data->get("email")));

                if($validar_email->status == 200 && !$validar_email->valid) {
                    return response()->json([
                        "success" => false,
                        "mensaje" => $validar_email->mensaje
                    ]);
                }

                $user = Sentinel::registerAndActivate($campos_usuario);

                $usuario_id = $user->id;

                //Creamos sus datos basicos
                $datos_basicos = new DatosBasicos();

                $datos_basicos->fill([
                    'numero_id'       => $data->get("cedula"),
                    'user_id'         => $usuario_id,
                    'nombres'         => $data->get("primer_nombre").' '.$data->get("segundo_nombre"),
                    'primer_nombre'   => $data->get("primer_nombre"),
                    'segundo_nombre'   => $data->get("segundo_nombre"),
                    'primer_apellido' => $data->get("primer_apellido"),
                    'segundo_apellido'=> $data->get("segundo_apellido"),
                    'telefono_movil'  => $data->get("celular"),
                    'estado_reclutamiento' => config('conf_aplicacion.C_ACTIVO'),
                    'email'             => $data->get("email")
                ]);

                //Se verifica si a la persona que se registra esta en la lista negra, se coloca en estado_reclutamiento, que tiene problema de seguridad
                $cand_lista_negra = ListaNegra::where('cedula', $datos_basicos->numero_id)->first();
                if ($cand_lista_negra != null) {
                    $datos_basicos->estado_reclutamiento = config('conf_aplicacion.PROBLEMA_SEGURIDAD');

                    $datos_basicos->save();

                    if ($cand_lista_negra->restriccion_id != '' && $cand_lista_negra->restriccion_id != null) {
                        $restriccion = DB::table('tipos_restricciones')->select('descripcion', 'id')->find($cand_lista_negra->restriccion_id);
                    } else {
                        $restriccion = collect(['descripcion' => 'no hay una restricción guardada.']);
                    }

                    if ($cand_lista_negra->gestiono != '' && $cand_lista_negra->gestiono != null) {
                        $gestiono = $cand_lista_negra->gestiono;
                    } else {
                        $gestiono = $this->user->id;
                    }

                    //ACTIVAR USUARIO Evento
                    $auditoria                = new Auditoria();
                    $auditoria->observaciones = 'Se registro por agregar a otras fuentes y se encuentra en listado especial con la restricción ' . $restriccion->descripcion;
                    $auditoria->valor_antes   = json_encode(["estado" => config('conf_aplicacion.C_ACTIVO')]);
                    $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.PROBLEMA_SEGURIDAD')]);
                    $auditoria->user_id       = $gestiono;
                    $auditoria->tabla         = "datos_basicos";
                    $auditoria->tabla_id      = $datos_basicos->id;
                    $auditoria->tipo          = 'ACTUALIZAR';
                    event(new \App\Events\AuditoriaEvent($auditoria));
                }

                $datos_basicos->save();

                $nuevo_registro = true;

                Event::dispatch(new PorcentajeHvEvent($datos_basicos));
                
                //Creamos el rol
                $role = Sentinel::findRoleBySlug('hv');
                $role->users()->attach($user);

                $sitio = Sitio::first();

                if(isset($sitio->nombre)) {
                    if($sitio->nombre != "") {
                        $nombre = $sitio->nombre;
                    }else {
                        $nombre = "Desarrollo";
                    }
                }

                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                $mailTitle = "Bienvenido a {$nombre} - T3RS"; //Titulo o tema del correo

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "
                    ¡Hola $datos_basicos->nombres $datos_basicos->primer_apellido $datos_basicos->segundo_apellido!<br>
                    Se ha creado exitosamente tu cuenta en T3RS, te invitamos a ingresar usando tu número de documento como usuario y contraseña para completar tu hoja de vida y cargar tus documentos.
                    ";
                //Arreglo para el botón
                $mailButton = ['buttonText' => '¡COMPLETA TU HOJA DE VIDA!', 'buttonRoute' => route('login')];

                $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $nombre, $sitio) {
                    $message->to($datos_basicos->email, $datos_basicos->nombres)
                    ->subject("Bienvenido a $nombre - T3RS")
                    ->bcc($sitio->email_replica)
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

                //si no esxite el usuario crearlo
            }else {
                $datos_basicos->fill([
                    // 'numero_id'       => $data->get("cedula"),
                    // 'user_id'         => $usuario_id,
                    'nombres'         => $data->get("primer_nombre").' '.$data->get("segundo_nombre"),
                    'primer_nombre'   => $data->get("primer_nombre"),
                    'segundo_nombre'  => $data->get("segundo_nombre"),
                    'primer_apellido' => $data->get("primer_apellido"),
                    'segundo_apellido'=> $data->get("segundo_apellido"),
                    'telefono_movil'  => $data->get("celular"),
                    // 'estado_reclutamiento' => config('conf_aplicacion.C_ACTIVO'),
                    // 'datos_basicos_count'  => "100",
                    // 'email'             => $data->get("email")
                ]);

                $datos_basicos->save();
            }   //AGREGAR A OTRAS FUENTES

            $candidato_fuente = CandidatosFuentes::where("requerimiento_id", $data->get("requerimiento_id"))->where("cedula", $data->get("cedula"))->get();

            if($candidato_fuente->count() > 0){
                array_push($errores_array, "<li>El candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> Ya se encuentra asociado al req.</li>");
                //return view("admin.reclutamiento.modal.nuevo_candidato", compact("fuentes", "datos"))->withErrors(["cedula" => "Este candidato ya fue ingresado a este requerimiento"])->render();
            }


            if($data->ajax()){
                if ($datos_basicos->estado_reclutamiento != config('conf_aplicacion.PROBLEMA_SEGURIDAD') && $datos_basicos->estado_reclutamiento != config('conf_aplicacion.C_BAJA_VOLUNTARIA')) {
                    //INGRESAR CANDIDATO
                    $candidato = new CandidatosFuentes();
                    $candidato->fill($data->all());
                    $candidato->nombres =$data->get("primer_nombre").' '.$data->get("segundo_nombre");
                    $candidato->save();
                    //FIN AGREGAR OTRAS FUENTES
                } else {
                    $mensaje = "<li>El candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> no se puede agregar porque solicitó baja voluntaria en la plataforma.</li>";

                    if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD')) {
                        $lista_negra = ListaNegra::leftjoin('tipos_restricciones', 'tipos_restricciones.id', '=', 'lista_negra.restriccion_id')
                                ->select('tipos_restricciones.descripcion as restriccion')
                                ->where('cedula', $datos_basicos->numero_id)
                                ->orderBy('lista_negra.id', 'desc')
                            ->first();

                        $mensaje = '<li>El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> no se puede asociar al requerimiento porque presenta problemas de seguridad.</li></br><div style="background-color: red; height: 50px"></div>';

                        if($lista_negra != null && $lista_negra->restriccion != null) {
                            $mensaje = '<li>El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> no se puede asociar al requerimiento porque presenta problemas de seguridad.<br>Se encuentra '. $lista_negra->restriccion .'</li><br><div style="background-color: red; height: 50px"></div>';

                            if ($nuevo_registro) {
                                $mensaje = '<li>Se ha creado con éxito la cuenta. El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> no se puede asociar al requerimiento porque presenta problemas de seguridad.<br>Se encuentra '. $lista_negra->restriccion .'</li></br><div style="background-color: red; height: 50px"></div>';
                            }
                        } else {
                            if ($nuevo_registro) {
                                $mensaje = '<li>Se ha creado con éxito la cuenta. El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> no se puede asociar al requerimiento porque presenta problemas de seguridad.</li></br><div style="background-color: red; height: 50px"></div>';
                            }
                        }
                    }
                    
                    return response()->json([
                        "success" => false,
                        "es_success" => true,
                        "mensaje" => $mensaje
                    ]);
                }

            }
            //FIN DE LO NUEVO
        }

        //Valida si viene un dato
        if (is_array($data->get("aplicar_candidatos_fuentes")) && $data->get("aplicar_candidatos_fuentes") != "") {
            foreach($data->get("aplicar_candidatos_fuentes") as $key => $value){
                $datos_basicos = DatosBasicos::where("numero_id", $value)->first();

                if ($datos_basicos != null) {
                    //Si tiene problemas de seguridad
                    if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD')) {
                        $lista_negra = ListaNegra::leftjoin('tipos_restricciones', 'tipos_restricciones.id', '=', 'lista_negra.restriccion_id')
                            ->select('tipos_restricciones.descripcion as restriccion')
                            ->where('cedula', $datos_basicos->numero_id)
                            ->orderBy('lista_negra.id', 'desc')
                        ->first();

                        if($lista_negra != null && $lista_negra->restriccion != null) {
                            $mensaje_error = '<li>El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> no se puede asociar al requerimiento porque presenta problemas de seguridad.<br>Se encuentra '. $lista_negra->restriccion .'</li><br><div style="background-color: red; height: 50px"></div>';
                        } else {
                            $mensaje_error = '<li>El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> no se puede asociar al requerimiento porque presenta problemas de seguridad.</li><br><div style="background-color: red; height: 50px"></div>';
                        }

                        array_push($errores_array, $mensaje_error);
                    } else {
                        if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO') || $datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_BAJA_VOLUNTARIA')){
                            //Si esta inactivo
                            if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO')) {
                                $auditoria = Auditoria::where('tabla', 'datos_basicos')
                                    ->where('tabla_id', $datos_basicos->id)
                                    ->whereIn('tipo', ['ACTUALIZAR', 'RECHAZAR_CANDIDATO_INACTIVAR'])
                                    ->orderBy('id', 'desc')
                                ->first();

                                if (is_null($auditoria)) {
                                    $auditoria = collect(['observaciones' => '']);
                                } else {
                                    if ($auditoria->tipo == 'RECHAZAR_CANDIDATO_INACTIVAR') {
                                        //Si se rechazo el candidato desde un Requerimiento, se busca la observacion
                                        $proceso = RegistroProceso::where('candidato_id', $datos_basicos->user_id)
                                            ->where('proceso', 'RECHAZAR_CANDIDATO')
                                            ->orderBy('id', 'desc')
                                        ->first();

                                        if (!is_null($proceso)) {
                                            $auditoria->observaciones = $proceso->observaciones;
                                        }
                                    }
                                }

                                array_push($errores_array, "<li>EL candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> NO se puede agregar porque tiene un estado inactivo.<br>Observación: $auditoria->observaciones</li>");
                            } else {
                                array_push($errores_array, "<li>EL candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> NO se puede agregar porque solicitó baja voluntaria en la plataforma.</li>");
                            }
                        } else {
                            if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_ACTIVO')) {
                                /*Si el estado de reclutamiento del candidato esta:
                                * 5-Activo
                                * No es transferencia y se puede asociar directamente
                                */
                                $this->completar_asociacion_candidato($data, $datos_basicos, $errores_array);
                            }else{
                                $asociacion_completa = false;
                                $proceso_req_cand = RegistroProceso::where("candidato_id", $datos_basicos->user_id)->orderBy('id', 'desc')->first();
                                if ($proceso_req_cand != null) {
                                    if ($proceso_req_cand->estado == config('conf_aplicacion.C_CONTRATADO') || $proceso_req_cand->estado == config('conf_aplicacion.C_QUITAR')) {
                                        /*Si el estado del candidato en el requerimiento anterior esta:
                                        * 12-Contratado
                                        * 14-Quitado
                                        * No es transferencia y se puede asociar directamente
                                        */
                                        $asociacion_completa = $this->completar_asociacion_candidato($data, $datos_basicos, $errores_array);
                                    } else {
                                        $estado_req = EstadosRequerimientos::where('req_id', $proceso_req_cand->requerimiento_id)->orderBy('id', 'desc')->first();
                                        if ($estado_req->estado == 1 || $estado_req->estado == 2 || $estado_req->estado == 3 || $estado_req->estado == 16) {
                                            /*Si en el ultimo requerimiento donde esta asociado el candidato esta:
                                            * 1-Cancelado por cliente
                                            * 2-Cancelado por Seleccion
                                            * 3-Cerrado por cumplimiento Parcial
                                            * 16-Terminado
                                            * No es transferencia y se puede asociar directamente
                                            */
                                            $asociacion_completa = $this->completar_asociacion_candidato($data, $datos_basicos, $errores_array);
                                        }
                                    }
                                }

                                if (!$asociacion_completa) {
                                    $datos = DB::table("requerimiento_cantidato")
                                    ->whereRaw(" estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
                                    ->where("candidato_id", $datos_basicos->user_id);

                                    if($datos->count() > 0){
                                        $req = $datos->select("requerimiento_cantidato.requerimiento_id", "requerimiento_cantidato.id as candidato_req")->first();

                                        //BUSCAR QUIEN LO INGRESO
                                        $usuario_regitro = RegistroProceso::where("requerimiento_candidato_id", $req->candidato_req)->where("estado", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->orderBy("procesos_candidato_req.id","DESC")->first();

                                        if($usuario_regitro !== null) {
                                            array_push($errores_array_req, "<li>  <input type='hidden' name='req_" . $req->candidato_req . "' value='" . $req->requerimiento_id . "'> <input type='checkbox' name='candidato_req[]' value='" . $req->candidato_req . "' checked>   El candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> actualmente se encuentra asignado al requerimiento <strong>" . $req->requerimiento_id . "</strong> el cual fue asociado por <strong>" . $usuario_regitro->usuarioRegistro()->name . "</strong> el pasado " . $usuario_regitro->created_at . " .</li>");
                                        }else{
                                            array_push($errores_array_req, "<li>  <input type='hidden' name='req_" . $req->candidato_req . "' value='" . $req->requerimiento_id . "'> <input type='checkbox' name='candidato_req[]' value='" . $req->candidato_req . "' checked>   EL candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> actualmente se encuentra asignado al requerimiento <strong>" . $req->requerimiento_id . "</strong> </strong> </li>");
                                        }
                                    } else {
                                        $this->completar_asociacion_candidato($data, $datos_basicos, $errores_array);
                                    }
                                }
                            }
                        }
                    }

                } else {
                    array_push($errores_array, '<li>No se agrego el candidato. No tiene actualizada la hoja de vida</li>');
                }
            }
        } else {
            $errores_array = ["<li>No se seleccionaron candidatos.</li>"];
        }

        if($data->ajax()){
            return response()->json(["success" => true]);
        }

        return redirect()->route("admin.gestion_requerimiento", [
            "req_id" => $data->get("requerimiento_id")
        ])
        ->with("success", $success)
        ->with("errores_array", $errores_array)
        ->with("errores_array_req", $errores_array_req);
    }

    protected function completar_asociacion_candidato(Request $data, $datos_basicos, &$errores_array) {
        //VERIFICAR SI TIENE EL 100% DE LA HV
        $datos_basicos->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_SELECCION');

        $datos_basicos->save();

        //ASOCIO EL CANDIDATO AL REQUERIMIENTO
        $nuevo_candidato_req = new ReqCandidato();
        
        $nuevo_candidato_req->fill([
            "estado_candidato" => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            //"otra_fuente" => $candidato_otra->tipo_fuente_id,
            'requerimiento_id' => $data->get("requerimiento_id"),
            'candidato_id' => $datos_basicos->user_id
        ]);

        $nuevo_candidato_req->save();
        
        //CREO EL ESTADO DE INGRESO A REQUERIMIENTO
        $nuevo_proceso = new RegistroProceso();

        $nuevo_proceso->fill([
            'proceso'                    => 'ASIGNADO_REQUERIMIENTO',
            'requerimiento_candidato_id' => $nuevo_candidato_req->id,
            'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            'fecha_inicio'               => date("Y-m-d H:i:s"),
            'usuario_envio'              => $this->user->id,
            'requerimiento_id'           => $data->get("requerimiento_id"),
            'candidato_id'               => $datos_basicos->user_id,
            'observaciones'              => "Ingreso al requerimiento",
        ]);

        $nuevo_proceso->save();

        //Se cambia el estado del requerimiento
        $datos = CandidatosFuentes::where("cedula", $datos_basicos->numero_id)
        ->where("requerimiento_id", $data->get("requerimiento_id"))
        ->delete();

        if(!in_array("<li>Se han agregado los candidatos con éxito.</li>", $errores_array)){
            array_push($errores_array, "<li>Se han agregado los candidatos con éxito.</li>");
        }

        //Se cambia el estado del requerimiento al enlazarlo con un candidato
        $req_vacantes=Requerimiento::find($data->get("requerimiento_id"));
        $cuenta_candidatos=ReqCandidato::where("requerimiento_id",$data->get("requerimiento_id"))
        ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")->count();

        if($req_vacantes->num_vacantes == $cuenta_candidatos){
            //Cambiar el estado cuando ya se asocian tantos candidatos como vacantes se solicitan
            $nuevoEstado = new EstadosRequerimientos();

            $nuevoEstado->req_id = $req_vacantes->id;
          
            $nuevoEstado->user_gestion = $this->user->id;
           
            $nuevoEstado->estado = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
        
            $nuevoEstado->save();
            
            /* $obj                   = new \stdClass();
            $obj->requerimiento_id = $data->get("requerimiento_id");
            $obj->user_id          = $this->user->id;
            $obj->estado           = config('conf_aplicacion.C_EN_PROCESO_SELECCION');

            Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));*/
        }

        $user_sesion = $this->user;
        $sitio = Sitio::first();

        if ($sitio->esProcesoEnSitio($data->get("requerimiento_id"))) {
            $campos = [
                'requerimiento_candidato_id'    => $nuevo_candidato_req->id,
                'usuario_envio'                 => $this->user->id,
                "fecha_inicio"                  => date("Y-m-d H:i:s"),
                'proceso'                       => "ENVIO_APROBAR_CLIENTE",
                'observaciones'                 => "Se ha enviado a aprobar por el cliente desde otras fuentes"
            ];

            //Se crea el proceso evaluacion del cliente
            $this->RegistroProceso($campos, config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), $nuevo_candidato_req->id);
        }
             
        if($user_sesion->hasAccess("email_candidato_req")){

            if(isset($sitio->nombre)){
                if($sitio->nombre != "") {
                    $nombre_empresa = $sitio->nombre;
                }else{
                    $nombre_empresa = "Desarrollo";
                }
            }


            $home = route('home');

            $urls = route('home.detalle_oferta', ['oferta_id' => $data->get("requerimiento_id")]);

            $req_can_id = $nuevo_candidato_req->id;

            $nombres = $datos_basicos->nombres;

            $nombre = ucwords(strtolower($nombres));
            
            $asunto = "Notificación de proceso de selección";

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Notificación de Proceso de Selección"; //Titulo o tema del correo

            $mailBody = "
                        ¡Hola $nombre!
                        <br/><br/>
                        Es un gusto para nosotros que seas parte de este proceso de selección, haz clic en el siguiente botón, donde podrás encontrar la información de la vacante. 
                        <br/><br/>
                        <b>¡Éxitos!</b>
                        ";

            //Arreglo para el botón
            $mailButton = ['buttonText' => 'OFERTA LABORAL', 'buttonRoute' => route('home.detalle_oferta', ['oferta_id' => $data->get("requerimiento_id")])];

            $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            if($datos_basicos->email){
                $emails = $datos_basicos->email;
            }else{
                $emails = false;
            }

            $mensaje = "Es un gusto para nosotros que seas parte de este proceso de selección, haz clic en el siguiente botón, donde podrás encontrar la información de la vacante.";
            

            if($emails){

                if (route('home') == 'https://listos.t3rsc.co') {
                    Mail::send('admin.enviar_email_candidatos_otras_fuentes_listos', [
                        "home" => $home,
                        "url" => $urls,
                        "req_can_id" => $req_can_id,
                        "nombre" => $nombre
                    ], function($message) use ($data, $emails, $asunto, $nombre_empresa) {
                        $message->to($emails, "$nombre_empresa - T3RS");
                        $message->subject($asunto)
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                }else{
                    $saludo = 'Hola '.$nombre;
                
                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($emails, $asunto, $nombre_empresa) {

                        $message->to($emails, "$nombre_empresa - T3RS");
                        $message->subject($asunto)
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

                }
            }
        }

        return true;
    }

    public function agregar_candidato_ee(Request $data)
    {
        $errores_array     = [];
        $success           = true;
        $errores_array_req = [];

        if(is_array($data->get("apply_candidates_ee")) && $data->get("apply_candidates_ee") != ""){

            foreach($data->get("apply_candidates_ee") as $key => $value){
                
                $datos = DB::table("requerimiento_cantidato")
                ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->join("requerimientos", "requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
                ->join("cargos_especificos", "cargos_especificos.id","=","requerimientos.cargo_especifico_id")
                ->whereRaw(" requerimiento_cantidato.estado_candidato not in ( " . implode(",", $this->estados_no_muestra) . " )  ")
                ->where("requerimiento_cantidato.candidato_id", $value)
                ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_ACTIVO'));

                if($datos->count() > 0){
                    if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
                        $req = $datos->select("requerimiento_cantidato.requerimiento_id", "requerimiento_cantidato.id as candidato_req", "datos_basicos.*", "cargos_especificos.descripcion as cargo")
                        ->first();
                    }else{
                        $req = $datos->select("requerimiento_cantidato.requerimiento_id", "requerimiento_cantidato.id as candidato_req", "datos_basicos.*")->first();
                    }

                    //BUSCAR QUIEN LO INGRESO
                    $usuario_regitro = RegistroProceso::where("requerimiento_candidato_id", $req->candidato_req)->first();
                    
                    // $req_anterior = $req->requerimiento_id;// guardar el req anterior
                    $datos_basicos = DatosBasicos::where("user_id", $value)->first();

                    if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
                        array_push($errores_array_req, "<li>  <input type='hidden' name='req_" . $req->candidato_req . "' value='" . $req->requerimiento_id . "'> <input type='checkbox' name='candidato_req[]' value='" . $req->candidato_req . "' checked>  EL candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> actualmente se encuentra asignado al requerimiento <strong>" . $req->requerimiento_id." ( ". $req->cargo . " ) " ."</strong> el cual fue asociado por <strong>" . $usuario_regitro->usuarioRegistro()->name . "</strong> el pasado " . $usuario_regitro->created_at . " .</li>");
                    }else{
                        array_push($errores_array_req, "<li>  <input type='hidden' name='req_" . $req->candidato_req . "' value='" . $req->requerimiento_id . "'> <input type='checkbox' name='candidato_req[]' value='" . $req->candidato_req . "' checked>  EL candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> actualmente se encuentra asignado al requerimiento <strong>" . $req->requerimiento_id."</strong> el cual fue asociado por <strong>" . $usuario_regitro->usuarioRegistro()->name . "</strong> el pasado " . $usuario_regitro->created_at . " .</li>");
                    }

                    $success = false;
                }else{
                    //VERIFICAR SI TIENE EL 100% DE LA HV
                    $datos = DatosBasicos::where("user_id", $value)->select("*")->first();

                    $req = $datos;

                    //CAMBIA ESTADO AL CANDIDATO
                    $candidato = DatosBasicos::where("user_id", $value)->first();

                    $candidato->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                    $candidato->save();

                    //CAMBIAR ESTADO EN LA TABLA OFERTA_USERS
                    /*$oferta_user = OfertaUser::where("user_id",$value)
                    ->where("requerimiento_id",$data->get("requerimiento_id"))
                    ->first();

                    if(!is_null($oferta_user)){
                        $oferta_user->estado = 0;
                        $oferta_user->save();
                    }*/

                    //ASOCIO EL CANDIDATO AL REQUERIMIENTO
                    $nuevo_candidato_req = new ReqCandidato();

                    $nuevo_candidato_req->fill([
                        "estado_candidato" => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        "otra_fuente" => 1,
                        'requerimiento_id' => $data->get("requerimiento_id"),
                        'candidato_id' => $candidato->user_id
                    ]);
                        
                    $nuevo_candidato_req->save();

                    //CREO EL ESTADO DE INGRESO A REQUERIMIENTO
                    $nuevo_proceso = new RegistroProceso();

                    $nuevo_proceso->fill([
                        'requerimiento_candidato_id' => $nuevo_candidato_req->id,
                        'estado'                  => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        'fecha_inicio'            => date("Y-m-d H:i:s"),
                        'usuario_envio'           => $this->user->id,
                        'requerimiento_id'        => $data->get("requerimiento_id"),
                        'candidato_id'            => $value,
                        'observaciones'           => "Ingreso al requerimiento",
                        'proceso'                 => "ASIGNADO_REQUERIMIENTO",
                    ]);

                    $nuevo_proceso->save();

                    $sitio = Sitio::first();
                    if ($sitio->esProcesoEnSitio($data->get("requerimiento_id"))) {
                        $campos = [
                            'requerimiento_candidato_id'    => $nuevo_candidato_req->id,
                            'usuario_envio'                 => $this->user->id,
                            "fecha_inicio"                  => date("Y-m-d H:i:s"),
                            'proceso'                       => "ENVIO_APROBAR_CLIENTE",
                            'observaciones'                 => "Se ha enviado a aprobar por el cliente desde otras fuentes"
                        ];

                        //Se crea el proceso evaluacion del cliente
                        $this->RegistroProceso($campos, config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), $nuevo_candidato_req->id);
                    }

                    $req_anterior = $data["req_anterior"];

                    if($data->has('transferido') && $data->transferido == 1 ){
                        //replicar trazabilidad al nuevo requerimiento
                        //obtener los procesos viejos del candidato
                        //foreach($data['aplicar_candidatos'] as $key => $value){

                        $traer_taza = RegistroProceso::where('requerimiento_id',$req_anterior["$value"])
                        ->where('candidato_id',$value)
                        ->whereNotIn('proceso',['ENVIO_APROBAR_CLIENTE','ENVIO_CONTRATACION_CLIENTE','ENVIO_CONTRATACION'])
                        ->whereNotNull('apto')
                        ->get();

                        if(count($traer_taza) > 0){
                            foreach($traer_taza as $item){
                                $nuevo_proceso = new RegistroProceso();
                                $nuevo_proceso->fill([
                                    'requerimiento_candidato_id' => $nuevo_candidato_req->id,
                                    'estado' => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                                    'fecha_inicio'  => date("Y-m-d H:i:s"),
                                    'usuario_envio' => $this->user->id,
                                    'requerimiento_id' => $data->get("requerimiento_id"),
                                    'candidato_id' => $item->candidato_id,
                                    'observaciones' => $item->observaciones,
                                    'proceso' => $item->proceso,
                                    'apto' => $item->apto
                                ]);
                                
                                $nuevo_proceso->save();
                            }
                        }
                    }

                    //BUSCAR EN CANDIDATOS DE OTRAS FUENTES PARA ELIMINARLO
                    $datos_ot = CandidatosFuentes::where("cedula", $candidato->numero_id)
                    ->where("requerimiento_id", $data->get("requerimiento_id"))
                    ->delete();

                    //EVENTO CAMBIA ESTADO REQUERIMIENTO
                    $obj                   = new \stdClass();
                    $obj->requerimiento_id = $data->get("requerimiento_id");
                    $obj->user_id      = $this->user->id;
                    $obj->estado  =  config('conf_aplicacion.C_EN_PROCESO_SELECCION');

                    Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));

                    if (!in_array("<li>Se han agregado los candidatos con éxito.</li>", $errores_array)) {
                        array_push($errores_array, "<li>Se han agregado los candidatos con éxito.</li>");
                    }

                    //Se cambia el estado del requerimiento al enlazarlo con un candidato
                    $obj                   = new \stdClass();
                    $obj->requerimiento_id = $data->get("requerimiento_id");
                    $obj->user_id          = $this->user->id;
                    $obj->estado           = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                    Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));

                    //EMAIL A LOS CANDIDATOS ENLAZADOS AL REQUERIMIENTO
                    $user_sesion = $this->user;

                    if ($user_sesion->hasAccess("email_candidato_req")) {
                        /*
                        $funcionesGlobales = new FuncionesGlobales();
                            
                        if (isset($funcionesGlobales->sitio()->nombre)) {
                            if ($funcionesGlobales->sitio()->nombre != "") {
                                $nombre = $funcionesGlobales->sitio()->nombre;
                            }else{
                                $nombre = "Desarrollo";
                            }
                        }

                        $home =  route('home');

                        $urls = route('home.detalle_oferta', ['oferta_id' => $data->get("requerimiento_id")]);
                        $req_can_id = $nuevo_candidato_req->id;
                        $nombres = $candidato->nombres;
                        $nombre = ucwords(strtolower($nombres));
                                            
                        $asunto = "Notificación de proceso de selección";
                        
                        $emails = $candidato->email;

                        if(route('home') == "http://localhost/desarrollo-T3RS/public"){
                            $mensaje = 'has sido elegido para realizar un proceso de selección con nosotros! Para consultar la información de la vacante por favor haz clic en el botón "oferta laboral" o si deseas consultar tu formato de condiciones laborales haz clic';
                        }else{
                            $mensaje = "Es un gusto para nosotros que seas parte de este proceso de selección, haz clic en el siguiente botón, donde podrás encontrar la información de la vacante.";
                        }
                            
                        //return view("admin.enviar_email_candidato_gestion_req", compact("url","nombres", "asunto", "mensaje"));
                        if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'http://localhost:8000') {
                            Mail::send('admin.enviar_email_candidatos_otras_fuentes_listos', [
                                "home" => $home,
                                "url" => $urls,
                                "req_can_id" => $req_can_id,
                                "nombre" => $nombre
                            ], function($message) use ($data, $emails, $asunto) {
                                $message->to($emails, '$nombre - T3RS');
                                $message->subject($asunto);
                            });
                        }else{
                            $saludo = "Hola, ".$nombre;

                            Mail::send('admin.new_email_candidatos_otras_fuentes', [
                                "home" => $home,
                                "url" => $urls,
                                "req_can_id" => $req_can_id,
                                "mensaje" => $mensaje,
                                "saludo" => $saludo
                            ],
                            function($message) use ($data, $emails, $asunto) {
                                $message->to($emails, '$nombre - T3RS')->subject($asunto);
                            });
                        }
                        */
                    }
                }
            }
        } else {
            $errores_array = ["<li>No se seleccionaron candidatos.</li>"];
        }

        if($data->ajax()){
            return $success;
        }

        return redirect()->route("admin.gestion_requerimiento", [
            "req_id" => $data->get("requerimiento_id")
        ])->with("success", $success)->with("errores_array", $errores_array)->with("errores_array_req", $errores_array_req);
    }

    public function editar_candidato_fuentes($id)
    {
        $datos = CandidatosFuentes::findOrFail($id);
        $fuentes = ["" => "Seleccionar"] + TipoFuentes::pluck("descripcion", "id")->toArray();

        return response()->json([
            "success" => true,
            "view" => view("admin.reclutamiento.modal._modal_nuevo_candidato", compact("fuentes", "datos"))->render()
        ]);
    }

    public function eliminar_candidato_fuente($id)
    {
        $candidato_fuente = CandidatosFuentes::findOrFail($id);
        $candidato_fuente->delete();

        return response()->json(["success" => true, "id"=>$id]);
    }

    public function eliminar_candidato_preperfilado($id)
    {
        $candidato_fuente = Preperfilados::findOrFail($id);
        $candidato_fuente->delete();

        return response()->json(["success" => true,"id"=>$id]);
    }

    public function eliminar_candidato_postulado($id)
    {
        $candidato_fuente = OfertaUser::findOrFail($id);
        $candidato_fuente->delete();

        return response()->json(["success" => true,"id"=>$id]);
    }

    public function eliminar_candidato_gestion_view(Request $request)
    {
        $modulo = $request->modulo;
        switch ($modulo) {
            case 'postulado':
                $candidato_fuente = OfertaUser::select(
                    'requerimiento_id',
                    'user_id as candidato_id',
                    'user_id',
                    'id as id_registro'
                    )
                ->find($request->id_buscar);
                break;
            case 'preperfilado':
                $candidato_fuente = Preperfilados::select(
                    'req_id as requerimiento_id',
                    'candidato_id',
                    'candidato_id as user_id',
                    'id as id_registro'
                    )
                ->find($request->id_buscar);
                break;
            case 'otras fuentes':
                $candidato_fuente = CandidatosFuentes::select(
                    'requerimiento_id',
                    'cedula',
                    'nombres',
                    'id as id_registro'
                    )
                ->find($request->id_buscar);

                $datos_basicos_of = DatosBasicos::where("numero_id", $candidato_fuente->cedula)->first();
                if ($datos_basicos_of != null) {
                    $candidato_fuente->user_id = $datos_basicos_of->user_id;
                    $candidato_fuente->candidato_id = $datos_basicos_of->user_id;
                } else {
                    $candidato_fuente->user_id = -1;
                    $candidato_fuente->candidato_id = -1;
                }
                break;
            default:
                break;
        }

        $motivos_descarte = ["" => "Seleccionar"] + MotivoDescarteCandidato::where('active', 1)->pluck("descripcion", "id")->toArray();

        return response()->json([
            "success" => true, 
            "view" => view("admin.reclutamiento.modal.eliminar_candidato_gestion_view", compact("candidato_fuente", "modulo", 'motivos_descarte'))->render() 
        ]);
    }

    public function confirmar_eliminar_candidato_gestion(Request $data) {
        $rules = [
            "observacion"           => "required",
            "motivo_descarte_id"    => "required"
        ];

        $validar = Validator::make($data->all(), $rules);

        $fecha_hoy = Carbon::now();
        $fecha_hoy = $fecha_hoy->format('Y-m-d');

        $obs_hv = new ObservacionesHv();
        $obs_hv->observacion        = $data->observacion;
        $obs_hv->user_gestion       = $this->user->id;
        $obs_hv->candidato_id       = $data->candidato_id;
        $obs_hv->req_id             = $data->req_id;
        $obs_hv->modulo             = $data->modulo;
        $obs_hv->motivo_descarte_id = $data->motivo_descarte_id;
        $obs_hv->save();

        $id_registro = $data->id_registro;

        $modulo = $data->modulo;
        switch ($modulo) {
            case 'postulado':
                $candidato_fuente = OfertaUser::find($id_registro);

                //ENVIAR MAIL A CANDIDATO NO CONTRATADO
                $datos_basicos = DatosBasicos::where("user_id", $data->candidato_id)->first();

                $nombres = "{$datos_basicos->nombres} {$datos_basicos->primer_apellido} {$datos_basicos->segundo_apellido}";
                $asunto = "¡Gracias por tu aplicación a la vacante!";
                $email = $datos_basicos->email;
                
                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                            
                $mailTitle = "¡Gracias por tu aplicación a la vacante!"; //Titulo o tema del correo

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "Estimado(a) $nombres.<br><br>

                            Te informamos que después del análisis de tu hoja de vida, hemos decidido dar por culminado tu proceso de selección para esta propuesta laboral.<br><br>

                            Te agradecemos haber dispuesto del tiempo que requerimos, tu compromiso e interés constante. Toda tu información quedará registrada en nuestra base de datos, bajo las directrices de completa confidencialidad. <br><br>

                            Cordialmente, <br><br>

                            <i>Equipo de Selección</i>";

                //Arreglo para el botón
                $mailButton = ['buttonText' => 'ACCEDER', 'buttonRoute' => route('login')];

                $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $asunto) {
                            $message->to([$email]);
                            $message->subject($asunto)
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
                
                break;
            case 'preperfilado':
                $candidato_fuente = Preperfilados::find($id_registro);
                break;
            case 'otras fuentes':
                $candidato_fuente = CandidatosFuentes::find($id_registro);
                break;
            default:
                break;
        }

        $candidato_fuente->delete();

        return response()->json(["success" => true, 'id' => $id_registro]);
    }

    public function mostrar_observaciones_hv(Request $data)
    {
        $candidato_id = $data->candidato_id;
        $candidato = DatosBasicos::where('user_id', $candidato_id)->first();
        $observaciones = ObservacionesHv::join('users','users.id','=','observaciones_hoja_vida.user_gestion')
            ->select(
                'observaciones_hoja_vida.*',
                'users.name as nombre'
            )
            ->where('candidato_id', $candidato_id)
        ->get();

        return response()->json([
            "success" => true, 
            "view" => view("admin.reclutamiento.modal.observaciones_candidato_gestion_view", compact("observaciones","candidato"))->render() 
        ]);
    }
    
    public function actualizar_candidato_fuente(Request $request)
    {
        $datos = $request->all();

        $rules = [
            "tipo_fuente_id" => "required",
        ];

        $fuentes = ["" => "Seleccionar"] + TipoFuentes::pluck("descripcion", "id")->toArray();

        $valida  = Validator::make($request->all(), $rules);

        if ($valida->fails()) {
            return response()->json([
                "success" => false,
                "view" => view("admin.reclutamiento.modal.nuevo_candidato", compact("fuentes", "datos"))->withInput($datos)->withErrors($valida)->render()
            ]);
        }

        $candidato_fuente = CandidatosFuentes::findOrFail($request['cand_otra_id']);

        unset($datos['cand_otra_id']);

        $candidato_fuente->fill($datos);
        $candidato_fuente->save();

        $estado_req = EstadosRequerimientos::join("estados", "estados.id", "=", "estados_requerimiento.estado")->where("req_id", $request["requerimiento_id"])
        ->select("estados.descripcion as estado_nombre", "estados.id as estados_req")
        ->orderBy("estados_requerimiento.id", "desc")
        ->first();

        if(!in_array($estado_req->estados_req,[config("conf_aplicacion.C_VENTA_PERDIDA"),config("conf_aplicacion.C_ELIMINADO"),config("
            conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL"),config("conf_aplicacion.C_TERMINADO")])){
            $estado_again = true;
        }else{
            $estado_again = false;
        }

        $hv = DatosBasicos::where("numero_id", $candidato_fuente->cedula)->first();

        if($hv == null){
            $hvView = 0;
        }else{
            $hvView = 1;

            $segundo_nombre = $request->get("segundo_nombre");
            $nombres = $request->get("primer_nombre") . ($segundo_nombre != '' ? " $segundo_nombre" : '');

            $hv->fill([
                'nombres'         => $nombres,
                'primer_nombre'   => $request->get("primer_nombre"),
                'segundo_nombre'  => $request->get("segundo_nombre"),
                'primer_apellido' => $request->get("primer_apellido"),
                'segundo_apellido'=> $request->get("segundo_apellido"),
                'telefono_movil'  => $request->get("celular")
            ]);

            $hv->save();
        }

        $emptyName = ucwords(mb_strtolower($candidato_fuente->nombreIdentificacion()));

        return response()->json([
            "success" => true,
            "candidatos" => $candidato_fuente,
            'estado_req' => $estado_again,
            'hvView' => $hvView,
            'emptyName' => $emptyName,
            'editar' => true
        ]);
    }

    // candidato otras fuentes view modal
    public function agregar_candidato_nuevo(Request $data)
    {
        $fuentes = ["" => "Seleccionar"] + TipoFuentes::pluck("descripcion", "id")->toArray();
        $datos   = $data->all();

        return response()->json([
            "success" => true,
            "view" => view("admin.reclutamiento.modal._modal_nuevo_candidato", compact("fuentes", "datos"))->render()
        ]);
    }

    public function guardar_candidato_fuente(Request $data)
    {
        $nuevo_registro = false;
        $datos = $data->all();
        $usuario_cargo = $this->user->id;
        
        $validator = Validator::make($datos,[
            "tipo_fuente_id" => "required",
            "primer_nombre" => "required",
            "primer_apellido" => "required",
            "celular" => "required",
            "email" => "required"
        ]);

        $fuentes = ["" => "Seleccionar"] + TipoFuentes::pluck("descripcion", "id")->toArray();
        // $valida  = Validator::make($data->all(), $rules);

        if($validator->fails()) {
            return response()->json([
                "success" => false,
                "view" => view("admin.reclutamiento.modal.nuevo_candidato", compact("fuentes", "datos"))->withInput($data->all())->withErrors($validator)->render()
            ]);
        }

        //NUEVO (CREAR USUARIO)
        $datos_basicos = DatosBasicos::where('numero_id',$data->get("cedula"))->first();

        if(is_null($datos_basicos)){

            $existe_registro_email = DatosBasicos::where('email',$data->get("email"))->first();
            if(count($existe_registro_email) > 0){
                //Este correo ya esta registrado
                return response()->json([
                    "success" => false,
                    "mensaje" => "Este correo ya se encuentra registrado"
                ]);
            }
            $nombres = $data->get("primer_nombre") . ($data->get("segundo_nombre") != '' ? " $data->get('segundo_nombre')" : '');
            //Creamos el usuario
            $campos_usuario = [
                'name' => $nombres.' '.$data->get("primer_apellido").' '.$data->get("segundo_apellido"),
                'email'  => $data->get("email"),
                'password' => $data->get("cedula"),
                'numero_id' => $data->get("cedula"),
                'cedula'     => $data->get("cedula"),
                'metodo_carga' =>3,
                'usuario_carga' =>$this->user->id,
                'tipo_fuente_id' => $data->get("tipo_fuente_id")
            ];

                $validar_email=json_decode($this->verificar_email($data->get("email")));

                if($validar_email->status==200 && !$validar_email->valid){
                     
                    //$error_email="Correo ".$data->get("email")." no válido. Verifique que exista la cuenta o el  proveedor de correos.";
                    return response()->json([
                    "success" => false,
                    "mensaje"=>$validar_email->mensaje,
                    "view" => view("admin.reclutamiento.modal.nuevo_candidato", compact("fuentes","datos"))->withInput($data->all())->render()
            ]);
                    
                }
                
            $user = Sentinel::registerAndActivate($campos_usuario);  
            $usuario_id = $user->id;
            
            //Creamos sus datos basicos
            $datos_basicos = new DatosBasicos();     
            $datos_basicos->fill([
                'numero_id'       => $data->get("cedula"),
                'user_id'         => $usuario_id,
                'nombres'         => $nombres,
                'primer_nombre'   => $data->get("primer_nombre"),
                'segundo_nombre'  => $data->get("segundo_nombre"),
                'primer_apellido' => $data->get("primer_apellido"),
                'segundo_apellido'=> $data->get("segundo_apellido"),
                'telefono_movil'  => $data->get("celular"),
                'estado_reclutamiento' => config('conf_aplicacion.C_ACTIVO'),
                'email'             => $data->get("email")
            ]);

            $datos_basicos->usuario_cargo = $usuario_cargo;
            $datos_basicos->save();

            $nuevo_registro = true;
                    
            //Creamos el rol
            $role = Sentinel::findRoleBySlug('hv');
            $role->users()->attach($user);
            //si no esxite el usuario crearlo
            
            $sitio = Sitio::first();

            if(isset($sitio->nombre)){
              
              if($sitio->nombre != "") {
                $nombre = $sitio->nombre;
              }else{
                $nombre = "Desarrollo";
              }
            }
        
            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Bienvenido a {$nombre} - T3RS"; //Titulo o tema del correo

            //Cuerpo con html y comillas dobles para las variables
            $mailBody = "
                ¡Hola $datos_basicos->nombres $datos_basicos->primer_apellido $datos_basicos->segundo_apellido!<br>
                Se ha creado exitosamente tu cuenta en T3RS, te invitamos a ingresar usando tu número de documento como usuario y contraseña para completar tu hoja de vida y cargar tus documentos.
                ";
            //Arreglo para el botón
            $mailButton = ['buttonText' => '¡COMPLETA TU HOJA DE VIDA!', 'buttonRoute' => route('login')];

            $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $nombre, $sitio) {

                    $message->to($datos_basicos->email, $datos_basicos->nombres)
                            ->subject("Bienvenido a $nombre - T3RS")
                            ->bcc($sitio->email_replica)
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        } else {
            $segundo_nombre = $data->get("segundo_nombre");
            $nombres = $data->get("primer_nombre") . ($segundo_nombre != '' ? " $segundo_nombre" : '');

            $datos_basicos->fill([
                'nombres'         => $nombres,
                'primer_nombre'   => $data->get("primer_nombre"),
                'segundo_nombre'  => $data->get("segundo_nombre"),
                'primer_apellido' => $data->get("primer_apellido"),
                'segundo_apellido'=> $data->get("segundo_apellido"),
                'telefono_movil'  => $data->get("celular")
            ]);

            $datos_basicos->save();
        }
        //FIN DE LO NUEVO

        //Se verifica si a la persona que se registra esta en la lista negra, se coloca en estado_reclutamiento, que tiene problema de seguridad
        $cand_lista_negra = ListaNegra::where('cedula', $datos_basicos->numero_id)->first();
        if ($cand_lista_negra != null) {
            $datos_basicos->estado_reclutamiento = config('conf_aplicacion.PROBLEMA_SEGURIDAD');
            $datos_basicos->save();

            if ($cand_lista_negra->restriccion_id != '' && $cand_lista_negra->restriccion_id != null) {
                $restriccion = DB::table('tipos_restricciones')->select('descripcion', 'id')->find($cand_lista_negra->restriccion_id);
            } else {
                $restriccion = collect(['descripcion' => 'no hay una restricción guardada.']);
            }

            if ($cand_lista_negra->gestiono != '' && $cand_lista_negra->gestiono != null) {
                $gestiono = $cand_lista_negra->gestiono;
            } else {
                $gestiono = $this->user->id;
            }

            //ACTIVAR USUARIO Evento
            $auditoria                = new Auditoria();
            $auditoria->observaciones = 'Se registro otras fuentes y se encuentra en listado especial con la restricción ' . $restriccion->descripcion;
            $auditoria->valor_antes   = json_encode(["estado" => config('conf_aplicacion.C_ACTIVO')]);
            $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.PROBLEMA_SEGURIDAD')]);
            $auditoria->user_id       = $gestiono;
            $auditoria->tabla         = "datos_basicos";
            $auditoria->tabla_id      = $datos_basicos->id;
            $auditoria->tipo          = 'ACTUALIZAR';
            event(new \App\Events\AuditoriaEvent($auditoria));

            $mensaje = '<li>El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> no se puede asociar al requerimiento porque presenta problemas de seguridad.</li></br><div style="background-color: red; height: 50px"></div>';

            if ($nuevo_registro) {
                $mensaje = '<li>Se ha creado con éxito la cuenta. El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> no se puede asociar al requerimiento porque presenta problemas de seguridad.</li></br><div style="background-color: red; height: 50px"></div>';
            }

            return response()->json([
                "success"   => false,
                "mensaje"   => $mensaje,
                "view"      => view("admin.reclutamiento.modal.nuevo_candidato", compact("fuentes","datos"))->withInput($data->all())->render()
            ]);
        }

        $candidato_fuente = CandidatosFuentes::where("requerimiento_id", $data->get("requerimiento_id"))
        ->where("cedula", $data->get("cedula"))->get();

        if($candidato_fuente->count() > 0){
            return response()->json([
                "success" => false,
                "view" => view("admin.reclutamiento.modal.nuevo_candidato", compact("fuentes", "datos"))->withErrors(["error" => "Este candidato ya fue ingresado a este requerimiento"])->render()
            ]);
        }

        //INGRESAR CANDIDATO
        $candidato = new CandidatosFuentes();
        $candidato->fill($data->all());
        $candidato->save();

        $candidatosOtrasFuentes = CandidatosFuentes::where('id', $candidato->id)
        ->where('requerimiento_id', $candidato->requerimiento_id)
        ->first();

        $emptyName = ucwords(mb_strtolower($candidatosOtrasFuentes->nombreIdentificacion()));

        $estado_req = EstadosRequerimientos::join("estados", "estados.id", "=", "estados_requerimiento.estado")->where("req_id", $data->get("requerimiento_id"))
        ->select("estados.descripcion as estado_nombre", "estados.id as estados_req")
        ->orderBy("estados_requerimiento.id", "desc")
        ->first();

        if(!in_array($estado_req->estados_req,[config("conf_aplicacion.C_VENTA_PERDIDA"),config("conf_aplicacion.C_ELIMINADO"),config("
            conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL"),config("conf_aplicacion.C_TERMINADO")])){
            $estado_again = true;
        }else{
            $estado_again = false;
        }

        $hv = DatosBasicos::where("numero_id", $candidato->cedula)->first();
        
        if($hv == null){
            $hvView = 0;
        }else{
            $hvView = 1;
        }

        return response()->json([
            "success" => true,
            "candidatos" => $candidatosOtrasFuentes,
            'estado_req' => $estado_again,
            'hvView' => $hvView,
            'emptyName' => $emptyName
        ]);
    }

    public function quitar_candidato_view(Request $data)
    {

        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->select("requerimiento_cantidato.id as candidato_req", "datos_basicos.*")
        ->first();

        $motivos = ["" => "Seleccionar"] + MotivosRechazos::pluck("descripcion", "id")->toArray();

        return response()->json(["view" => view("admin.reclutamiento.modal.quitar_candidato", compact("candidato", "motivos"))->render()]);
    }

    public function RegistroProceso($campos = array(), $estado, $candidato_req)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $candidato_req)
        ->select("requerimiento_cantidato.*","datos_basicos.email")
        ->first();

        $campos_data = $campos + [
            'requerimiento_id' => $candidato->requerimiento_id,
            'candidato_id'     => $candidato->candidato_id,
            'estado'           => $estado,
            'fecha_inicio'     => date("Y-m-d H:i:s")
        ];

        //ACTUALIZA REGISTRO A ESTADO SEGUN EL PROCESO
        $reqCandidato = ReqCandidato::where('id', $candidato->id)->update(['estado_candidato' => $estado]);

        //REGISTRA PROCESO
        $nuevo_proceso = new RegistroProceso();
        $nuevo_proceso->fill($campos_data);
        $nuevo_proceso->save();

        //validar aqui si es envio a pruebas valpru
        if(route('home') == "https://demo.t3rsc.co" || route('home') == "https://pruebaslistos.t3rsc.co" || route('home') == "https://listos.t3rsc.co"){

            if(!empty($campos['proceso']) && $campos['proceso'] == 'ENVIO_PRUEBAS'){ //si fue enviado a pruebas
                $email = $candidato->email;
           
                $requerimiento = Requerimiento::select('cargo_especifico_id')->where('id', $candidato->requerimiento_id)->first(); //buscar el nivel del cargo

                $cargo = CargoEspecifico::find($requerimiento->cargo_especifico_id);//nivel de cargo

                $archivo = "";
            
                $nivel = $cargo->nivel_cargo ;

                switch($nivel){
                    case 1:
                        // si es 1 es un cargo estrategico
                        $archivo = "cargos_estrategicos.pdf";
                    break;

                    case 2:
                        // si es 2 es un cargo operativo
                        $archivo = "cargos_operativos.pdf";
                    break;

                    case 3:
                        // si es 3 es un cargo tactico
                        $archivo = "cargos_tacticos.pdf";
                    break;

                    default:
                        $archivo = "";
                    break;
                }

                if($email && $archivo != ""){
                    //$saludo='Buen día'.$nombre;
                    Mail::send('admin.email_cargos',[], function($message) use ($email,$archivo){
                        $message->to($email, 'Candidato - T3RS');
                        $message->subject('Envio a Pruebas');
                        $message->attach(public_path($archivo))
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                }
            }
        }

        // aqui quitar
        if($estado == config('conf_aplicacion.C_QUITAR')){

            $candi=ReqCandidato::where("requerimiento_id", $candidato->requerimiento_id)
            ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
            ->count();

            $est_req = Requerimiento::find($candidato->requerimiento_id);

            if($candi == 0 && ($est_req->ultimoEstadoRequerimiento()->id == config('C_RECLUTAMIENTO') || $est_req->ultimoEstadoRequerimiento()->id == config('C_EN_PROCESO_SELECCION') || $est_req->ultimoEstadoRequerimiento()->id == config('C_EVALUACION_DEL_CLIENTE') || $est_req->ultimoEstadoRequerimiento()->id == config('C_EN_PROCESO_CONTRATACION'))){

                $nuevoEstado=new EstadosRequerimientos();

                $nuevoEstado->req_id = $candidato->requerimiento_id;
                $nuevoEstado->user_gestion  = $this->user->id;
                $nuevoEstado->estado  = config('conf_aplicacion.C_RECLUTAMIENTO');
                $nuevoEstado->save();

                // Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));
            }

            if( isset($campos["esTransferido"]) && $campos["esTransferido"] === false){

                $datos_basicos = DatosBasicos::where("user_id", $candidato->candidato_id)->first();

                $nombres = "{$datos_basicos->nombres} {$datos_basicos->primer_apellido} {$datos_basicos->segundo_apellido}";
                $asunto = "¡Gracias por tu aplicación a la vacante!";
                $email = $datos_basicos->email;
                
                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                            
                $mailTitle = "¡Gracias por tu aplicación a la vacante!"; //Titulo o tema del correo

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "Estimado(a) $nombres.<br><br>

                            Te informamos que después del análisis de tu hoja de vida, hemos decidido dar por culminado tu proceso de selección para esta propuesta laboral.<br><br>

                            Te agradecemos haber dispuesto del tiempo que requerimos, tu compromiso e interés constante. Toda tu información quedará registrada en nuestra base de datos, bajo las directrices de completa confidencialidad. <br><br>

                            Cordialmente, <br><br>

                            <i>Equipo de Selección</i>";

                //Arreglo para el botón
                $mailButton = ['buttonText' => 'ACCEDER', 'buttonRoute' => route('login')];

                $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $asunto) {
                        $message->to([$email]);
                        $message->subject($asunto)
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

            }
        }

        //CAMBIAR ESTADO DATOS BASICOS
        $datos_basicos = DatosBasicos::where("user_id", $candidato->candidato_id)->first();
        $estado_antes  = $datos_basicos->estado_reclutamiento;

        if($estado == config('conf_aplicacion.C_INACTIVO')){
            $datos_basicos->fill(["estado_reclutamiento" => $estado]);
            $datos_basicos->save();
        }

        //EVENTO CAMBIA ESTADO REQUERIMIENTO
        if ($estado != config('conf_aplicacion.C_INACTIVO')){
            if(in_array($estado, [config('conf_aplicacion.C_RECLUTAMIENTO'), config('conf_aplicacion.ENVIO_APROBAR_CLIENTE'), config('conf_aplicacion.C_EN_PROCESO_SELECCION'), config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'), /*config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),*/ config('conf_aplicacion.C_TERMINADO'), config('conf_aplicacion.C_CLIENTE'), config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL')])) {

                $obj                   = new \stdClass();
                $obj->requerimiento_id = $candidato->requerimiento_id;
                $obj->user_id          = $this->user->id;
                $obj->estado           = $estado;

                Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));
            }
        }

        //Ajustar los campos en el requerimiento para el ajuste de los indicadores
        // Traemos el requerimiento actual
        $requerimiento_obj = Requerimiento::find($candidato->requerimiento_id);
        $registro_proceso  = RegistroProceso::find($nuevo_proceso->id);

        // Miramos si están enviando a aprobación al cliente al candidato
        if ($estado == config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE')) {

            $fecha_presentacion_candidatos = Carbon::now('America/Bogota');
            $fecha_presentacion_oport_cand = Carbon::parse($requerimiento_obj->fecha_presentacion_oport_cand);

            if ($fecha_presentacion_candidatos->lte($fecha_presentacion_oport_cand)) {
                // entonces es oportuna la presentacion del candidato
                $cand_presentados_puntual                    = $requerimiento_obj->cand_presentados_puntual + 1;
                $requerimiento_obj->cand_presentados_puntual = $cand_presentados_puntual;
                $registro_proceso->cand_presentado_puntual   = 1;
            }

            if ($fecha_presentacion_candidatos->gt($fecha_presentacion_oport_cand)) {

                $cand_presentados_no_puntual                    = $requerimiento_obj->cand_presentados_no_puntual + 1;
                $requerimiento_obj->cand_presentados_no_puntual = $cand_presentados_no_puntual;
            }

            //Actualizamos el requerimiento
            $requerimiento_obj->fecha_presentacion_candidatos = $fecha_presentacion_candidatos;
            $requerimiento_obj->save();
            $registro_proceso->save();
            $cant_enviar = 0;

            $cuentas = NegocioANS::where("negocio_id",$requerimiento_obj->negocio_id)->where('cargo_especifico_id',$requerimiento_obj->cargo_especifico_id)->get();

            //cuentas
            $cant_enviar = $requerimiento_obj->num_vacantes * 1;
            
            if(!is_null($cuentas)){
                foreach($cuentas as $value){
                    if($value->num_cand_presentar_vac){
                        //$regla =  explode('A',$value->regla);
                        $cant_enviar = $requerimiento_obj->num_vacantes*$value->num_cand_presentar_vac;
                    }else{
                        if($requerimiento_obj->num_vacantes >= 1 && $requerimiento_obj->num_vacantes <= 3){
                            $cant_enviar = $requerimiento_obj->num_vacantes * 2;
                        }else{
                            $cant_enviar = $requerimiento_obj->num_vacantes * 1;
                        }
                    }
                }
            }else{   
                if($requerimiento_obj->num_vacantes >= 1 && $requerimiento_obj->num_vacantes <= 3){
                    $cant_enviar = $requerimiento_obj->num_vacantes * 2;
                }else{
                    $cant_enviar = $requerimiento_obj->num_vacantes * 1;
                }
            }

            $enviados_al_cliente=RegistroProceso::join("requerimiento_cantidato","requerimiento_cantidato.id","=","procesos_candidato_req.requerimiento_candidato_id")
            ->where("procesos_candidato_req.requerimiento_id", $requerimiento_obj->id)
            ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
            ->where("proceso","ENVIO_APROBAR_CLIENTE")
            ->count();

            if($enviados_al_cliente >= $cant_enviar){
                if($requerimiento_obj->UltimoEstadoRequerimiento()->id!=config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE') && $requerimiento_obj->UltimoEstadoRequerimiento()->id!=config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')){
                    $nuevoEstado = new EstadosRequerimientos();

                    $nuevoEstado->req_id=$requerimiento_obj->id;
                    $nuevoEstado->user_gestion = $this->user->id;
                                        
                    $nuevoEstado->estado  = config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE');
                    $nuevoEstado->save();
                }        
            }
        }

        //Lo envian a contratar
        if ($estado == config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')) {

            $num_verificacion = RegistroProceso::where("requerimiento_candidato_id", $candidato_req)
                ->where("proceso", "ENVIO_APROBAR_CLIENTE")
                ->where("cand_presentado_puntual", 1)
                ->where("requerimiento_id", $candidato->requerimiento_id)
                ->select("cand_presentado_puntual", "proceso")
                ->get();

            if ($num_verificacion->count() > 0) {
                $registro_proceso->cand_presentado_puntual = 1;
            }

            $fecha_contratacion_candidato = Carbon::now('America/Bogota');
            $fecha_tentativa_cierre_req   = Carbon::parse($requerimiento_obj->fecha_tentativa_cierre_req);

            if ($fecha_contratacion_candidato->lte($fecha_tentativa_cierre_req)) {

                $cand_contratados_puntual                    = $requerimiento_obj->cand_contratados_puntual + 1;
                $requerimiento_obj->cand_contratados_puntual = $cand_contratados_puntual;
                $registro_proceso->cand_contratado           = 1;
            }
            if ($fecha_contratacion_candidato->gt($fecha_tentativa_cierre_req)) {

                $cand_contratados_no_puntual                    = $requerimiento_obj->cand_contratados_no_puntual + 1;
                $requerimiento_obj->cand_contratados_no_puntual = $cand_contratados_no_puntual;
                $registro_proceso->cand_contratado              = 1;

            }
            $requerimiento_obj->fecha_contratacion_candidato = $fecha_contratacion_candidato;
            $requerimiento_obj->save();
            $registro_proceso->save();

            //Enviar Email -----------------------------------------
            $funcionesGlobales = new FuncionesGlobales();
            if (isset($funcionesGlobales->sitio()->nombre)) {
                if ($funcionesGlobales->sitio()->nombre != "") {
                    $nombre = $funcionesGlobales->sitio()->nombre;
                } else {
                    $nombre = "Desarrollo";
                }
            }

            $datos_basicos = DatosBasicos::
                where('user_id', $candidato->candidato_id)
                ->first();

            $urls = route('home.firma-contrato-laboral',['user_id'=>$candidato->candidato_id,'req_id'=>$candidato->requerimiento_id]);

            $url = str_replace("http://", "https://", $urls);

            //$nombre_cliente = $cliente->nombre; 
            $nombres = $datos_basicos->nombres ." ".$datos_basicos->primer_apellido;
            $asunto = "Informe de contratación laboral";
            $emails = $datos_basicos->email;
            $mensaje = "Felicitaciones $nombres,
                        has sido la persona seleccionada para desempeñar el cargo de Asistente comercial para SUPERPOLO! A continuación podras consultar el contrato y firmarlo digitalmente, Bienvenido!
                        ";
            $pdf = route('home') . "/contratos/contrato_jorge.pdf";

        }

        //EVENTO CAMBIA ESTADO REQUERIMIENTO
        if (in_array($estado, [
                config('conf_aplicacion.C_RECLUTAMIENTO'),
                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                config('conf_aplicacion.C_TERMINADO'),
                config('conf_aplicacion.C_CLIENTE'),
                config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL')])) {
            $obj                   = new \stdClass();
            $obj->requerimiento_id = $candidato->requerimiento_id;
            $obj->user_id          = $this->user->id;
            $obj->estado           = $estado;
            Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));
        }

        //ADUDITORIA SI SE RECHAZA EL CANDIDATO
        if ($estado == config('conf_aplicacion.C_INACTIVO')) {
            $auditoria                = new Auditoria();
            $auditoria->observaciones = "Se inactivo al gestionar el requerimiento. ".$nuevo_proceso->observaciones;
            $auditoria->valor_antes   = json_encode(["requerimiento_id" => $candidato->requerimiento_id, "estado" => $estado_antes]);
            $auditoria->valor_despues = json_encode(["requerimiento_id" => $candidato->requerimiento_id, "estado" => config('conf_aplicacion.C_INACTIVO'), "motivo_rechazo_id" => $campos_data["motivo_rechazo_id"]]);
            $auditoria->user_id       = $this->user->id;
            $auditoria->tabla         = "datos_basicos";
            $auditoria->tabla_id      = $datos_basicos->id;
            $auditoria->tipo          = $campos["proceso"] . "_INACTIVAR";
            $auditoria->motivo_rechazo_id = $campos_data["motivo_rechazo_id"];
            event(new \App\Events\AuditoriaEvent($auditoria));
        }

        return $nuevo_proceso->id;
    }

    public function quitar_candidato(Request $data)
    {    
        $campos = [
            'requerimiento_candidato_id' => $data->get("candidato_req"),
            'motivo_rechazo_id'          => $data->get("motivo_descarte_id"),
            'usuario_envio'              => $this->user->id,
            'proceso'                    => "QUITAR",
            'observaciones'              => $data->get("observaciones"),
            'esTransferido'              => $data->has("esTransferido")
        ];

        //Validar si en el requerimiento hay más usuario para dejar el requerimiento en el mismo estado

        $this->RegistroProceso($campos, config('conf_aplicacion.C_QUITAR'), $data->get("candidato_req"));

        return response()->json(["success" => true]);
    }

    public function enviar_examenes_view(Request $data)
    {
        $sitio_modulo = SitioModulo::first();

        if($sitio_modulo->omnisalud == 'enabled') {
            $omnisalud = new OmnisaludIntegrationController();

            // Tipos de admisiones para los exámenes
            $omnisalud_tipo_admision = $omnisalud::tipoAdmision();

            // Exámenes de omnisalud
            $omnisalud_examenes_medicos = $omnisalud::examenesMedicos();

            // Ciudades
            $omnisalud_ciudades = $omnisalud::ciudadesAtencion();
        }

        if($sitio_modulo->usa_ordenes_medicas == 'si') {
            // Mostrar todos los campos
            $lleva_ordenes = 'si';

            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->select(
                "datos_basicos.*",
                "tipo_identificacion.cod_tipo",
                "requerimiento_cantidato.id as req_candidato",
                "requerimiento_cantidato.requerimiento_id as req"
            )
            ->first();

            $requerimiento = Requerimiento::find($candidato->req);
            $cargo_especifico = CargoEspecifico::with("examenes")->find($requerimiento->cargo_especifico_id);

            $proveedores = ["" => "Seleccion"] + ProveedorTipoProveedor::join('proveedor',"proveedor.id","=","proveedor_tipo_proveedor.proveedor")
            ->where("proveedor_tipo_proveedor.tipo", 1)
            ->where("proveedor.estado", 1)
            ->orderBy("proveedor.nombre", "ASC")
            ->pluck("proveedor.nombre", "proveedor.id")
            ->toArray();

            $examenes= ExamenMedico::where("examen_medico.status", 1)
            ->orderBy("examen_medico.nombre", "ASC")
            ->get();

            return response()->json([
                "success" => true,
                "view" => view("admin.reclutamiento.modal.envio_examenes_new", compact(
                    "candidato",
                    "proveedores",
                    "examenes",
                    "cargo_especifico",
                    "lleva_ordenes",
                    "sitio_modulo",
                    "omnisalud_tipo_admision",
                    "omnisalud_examenes_medicos",
                    "omnisalud_ciudades"
                ))->render()
            ]);
        }else {
            //Para Listos y VyM lleva_ordenes siempre debe ser = 'no'
            $lleva_ordenes = 'no';

            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->select(
                "datos_basicos.*",
                "requerimiento_cantidato.id as req_candidato",
                "requerimiento_cantidato.requerimiento_id as req"
            )
            ->first();

            return response()->json([
                "success" => true,
                "view" => view("admin.reclutamiento.modal.envio_examenes_new", compact(
                    "candidato",
                    "lleva_ordenes",
                    "sitio_modulo",
                    "omnisalud_tipo_admision",
                    "omnisalud_examenes_medicos",
                    "omnisalud_ciudades"
                ))->render()
            ]);
        }
    }

    public function enviar_estudio_seg_view(Request $data)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->select(
            "datos_basicos.*",
            "requerimiento_cantidato.id as req_candidato",
            "requerimiento_cantidato.requerimiento_id as req"
        )
        ->first();

        return response()->json(["success" => true, "view" => view("admin.reclutamiento.modal.envio_estudio_seguridad", compact("candidato"))->render()]);
    }

    //Actualización desde Salud Ocupacional
    public function enviar_examenes_again_view(Request $data)
    {
        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato","requerimiento_cantidato.requerimiento_id as req")
            ->first();

            return response()->json(["success" => true, "view" => view("admin.reclutamiento.modal.envio_examenes", compact("candidato"))->render()]);
        }else{
            $orden_id = $data->orden_id;

            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato","requerimiento_cantidato.requerimiento_id as req")
            ->first();

            $requerimiento = Requerimiento::find($candidato->req);
            $cargo_especifico = $requerimiento->cargo_especifico_id;

            $proveedores = ["" => "Seleccion"] + ProveedorTipoProveedor::join('proveedor',"proveedor.id","=","proveedor_tipo_proveedor.proveedor")
            ->where("proveedor_tipo_proveedor.tipo",1)
            ->pluck("proveedor.nombre", "proveedor.id")->toArray();

            $examenes = CargosExamenes::rightJoin("examen_medico","examen_medico.id","=","cargos_examenes.examen_id")
            ->select("examen_medico.nombre as nombre","examen_medico.id as id","cargos_examenes.cargo_id as cargo ")
            ->orderBy("examen_medico.nombre","ASC")
            ->get();

            return response()->json(["success" => true, "view" => view("admin.reclutamiento.modal.envio_examenes_again", compact("candidato", "proveedores","examenes","cargo_especifico","orden_id"))->render()]);
        }       
    }

    public function enviar_examenes_salud_ocup(Request $data)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
        ->first();

        $usuarios_cliente = ["" => "Seleccion"] + EloquentUser::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
        ->where("users_x_clientes.cliente_id", $data->cliente_id)
        ->pluck("users.name", "users.id")
        ->toArray();

        if(route("home") != "http://komatsu.t3rsc.co" && route("home") != "http://komatsu.t3rsc.co"){

            $campos = [
                'requerimiento_candidato_id' => $data->get("candidato_req"),
                'usuario_envio'              => $this->user->id,
                'proceso'                    => "ENVIO_EXAMENES",
            ];

            $orden = new OrdenMedica();
            $orden->fill([
                "proveedor_id" => $data->get("proveedor"),
                "req_can_id"   => $data->get("candidato_req")
            ]);
            $orden->save();

            $estado = new EstadosOrdenes();
            $estado->fill([
                "orden_id"=>$orden->id,
                "estado_id"=>1
            ]);
            $estado->save();

            foreach($data->examen as $examen){

                $nuevo_examen = new ExamenesMedicos();
                $nuevo_examen->fill([
                    "orden_id"=>$orden->id,
                    "examen"=>$examen,            
                ]);
                $nuevo_examen->save();

            }

            $orden_id = $data->get("orden_id");
            $ordenActual = EstadosOrdenes::where('orden_id', $orden_id)->where('estado_id', 2)->first();
            $ordenActual->estado_id = 4;
            $ordenActual->save();

            $estado = config('conf_aplicacion.C_EN_PROCESO_CONTRATACION');

            $DataExamenes = ExamenesMedicos::join('examen_medico', 'examen_medico.id','=','examenes_medicos.examen')
            ->where('orden_id', $orden->id)
            ->select('examen_medico.nombre as examen_medico')
            ->get();

            $DataOrder = OrdenMedica::join('proveedor', 'proveedor.id', '=', 'orden_medica.proveedor_id')
            ->where('orden_medica.id', $orden->id)
            ->select('orden_medica.*', 'orden_medica.observacion as otros', 'proveedor.nombre as centro_medico', 'proveedor.email as email')
            ->first();

            $emails = $DataOrder->email;

            //return view("admin.email_orden_examen_medico", compact('DataExamenes','DataCandidato','DataOrder'));

            $asunto = "Orden examenes medicos # $orden->id";

            Mail::send('admin.email_orden_examen_medico', ["DataExamenes" => $DataExamenes, "candidato" => $candidato, "DataOrder" => $DataOrder],function($message) use ($emails, $asunto) {
                $message->to($emails)->subject($asunto)
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

        }else{
            $campos = [
                'requerimiento_candidato_id' => $data->get("candidato_req"),
                'usuario_envio'              => $this->user->id,
                'proceso'                    => "ENVIO_EXAMENES"
            ];

            $estado = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
        }

        $this->RegistroProceso($campos, $estado, $data->get("candidato_req"));

        return response()->json(["success" => true]);
    }

    //Estudio seguridad
    public function enviar_estudio_seguridad_view(Request $data)
    {
        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato","requerimiento_cantidato.requerimiento_id as req")
            ->first();

            return response()->json(["success" => true, "view" => view("admin.reclutamiento.modal.envio_estudio_seguridad", compact("candidato"))->render()]);
        }else{
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato","requerimiento_cantidato.requerimiento_id as req")
            ->first();

            $requerimiento=Requerimiento::find($candidato->req);
            $cargo_especifico=$requerimiento->cargo_especifico_id;

            $proveedores = ["" => "Seleccion"] + ProveedorTipoProveedor::join('proveedor',"proveedor.id","=","proveedor_tipo_proveedor.proveedor")
            ->where("proveedor_tipo_proveedor.tipo",2)
            ->pluck("proveedor.nombre", "proveedor.id")->toArray();

            $examenes = CargosEstudiosSeguridad::rightJoin("estudios_seguridad_list","estudios_seguridad_list.id", "=" ,"cargos_estudios_seguridad.estudio_seg_id")
            ->select("estudios_seguridad_list.nombre as nombre","estudios_seguridad_list.id as id","cargos_estudios_seguridad.cargo_id as cargo ")
            ->orderBy("estudios_seguridad_list.nombre","ASC")
            ->get();

            return response()->json(["success" => true, "view" => view("admin.reclutamiento.modal.envio_estudio_seguridad", compact("candidato", "proveedores","examenes","cargo_especifico"))->render()]);
        }       
    }

    public function enviar_examenes(Request $data)
    {
        //Datos para creación del proceso
        $campos = [
            'requerimiento_candidato_id' => $data->get("candidato_req"),
            'usuario_envio'              => $this->user->id,
            'proceso'                    => "ENVIO_EXAMENES",
        ];

        if ($data->has('omnnisalud_opcion')) {
            $omnisalud = new OmnisaludIntegrationController();

            $resultado = $omnisalud->omnisalud($data);

            if ($resultado['error']) {
                return response()->json(['success' => false, 'omnisalud' => true, 'message' => $resultado['message']]);
            }
        }

        if($data->lleva_ordenes == 'si' && !$data->has('omnisalud_opcion')) {
            $orden = new OrdenMedica();

            $orden->fill([
                "proveedor_id"  => $data->get("proveedor"),
                "req_can_id"    => $data->get("candidato_req"),
                "user_envio"    => $this->user->id,
                "observacion"   => $data->get("observacion")
            ]);
            $orden->save();

            $estado = new EstadosOrdenes();

            $estado->fill([
               "orden_id"  => $orden->id,
               "estado_id" => 1
            ]);
            $estado->save();

            foreach($data->examen as $examen){
                $nuevo_examen = new ExamenesMedicos();

                $nuevo_examen->fill([
                    "orden_id" => $orden->id,
                    "examen"   => $examen,            
                ]);
                $nuevo_examen->save();
            }

            //Datos para correo
            $DataExamenes = ExamenesMedicos::join('examen_medico', 'examen_medico.id', '=', 'examenes_medicos.examen')
                ->where('orden_id', $orden->id)
                ->select('examen_medico.nombre as examen_medico')
                ->get();

            $DataOrder = OrdenMedica::join('proveedor', 'proveedor.id', '=', 'orden_medica.proveedor_id')
                ->join("requerimiento_cantidato","requerimiento_cantidato.id","=","orden_medica.req_can_id")
                ->where('orden_medica.id', $orden->id)
                ->select(
                    'orden_medica.*',
                    'orden_medica.observacion as otros',
                    'proveedor.nombre as centro_medico',
                    'proveedor.email as email',
                    'requerimiento_cantidato.requerimiento_id as req'
                )
                ->first();

            $emails = isset($DataOrder->email) ? explode(",", $DataOrder->email) : [];

            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                ->join("departamentos", function ($join) {
                    $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                    ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                    ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                })
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
                ->select(
                    "datos_basicos.*",
                    "requerimiento_cantidato.id as req_candidato",
                    "requerimientos.*",
                    "requerimientos.id as id_req",
                    "clientes.nombre as cliente",
                    "cargos_especificos.descripcion as cargo",
                    "ciudad.nombre as ciudad"
                )
            ->first();

            $asunto = "Orden examenes medicos $candidato->cliente # $orden->id";

            try {
                Mail::send('admin.email_orden_examen_medico', [
                    "DataExamenes" => $DataExamenes,
                    "candidato" => $candidato,
                    "DataOrder" => $DataOrder
                ],function($message) use ($emails, $asunto) {
                    $message->to($emails)->subject($asunto)
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            } catch (\Exception $e) {
                logger('Excepción capturada en ReclutamientoController envio de correo admin.email_orden_examen_medico: '.  $e->getMessage(). "\n");
            }
        }

        $estado = config('conf_aplicacion.C_EN_EXAMENES_MEDICOS');

        $id_proceso = $this->RegistroProceso($campos, $estado, $data->get("candidato_req"));

        if (!empty($data->observacion_candidato)) {
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
                ->select(
                    "datos_basicos.*",
                    "cargos_especificos.descripcion as cargo"
                )
            ->first();

            if (!is_null($candidato)) {
                try {
                    //notificacion al candidato
                    $sitio = Sitio::first();

                    $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                    $mailConfiguration = 1; //Id de la configuración
                    $mailTitle = "Notificación exámenes médicos"; //Titulo o tema del correo

                    $mailBody = "
                            Hola {$candidato->nombres} {$candidato->primer_apellido} {$candidato->segundo_apellido}, te informamos que el analista de selección que está llevando tu proceso de selección te ha solicitado que te realices los exámenes médicos para el cargo de {$candidato->cargo},
                            a continuación, te indicamos la información adicional al respecto: 

                            <br/><br/>

                            {$data->observacion_candidato}
                        ";

                    //Arreglo para el botón
                    $mailButton = [];

                    $mailUser = $candidato->user_id; //Id del usuario al que se le envía el correo

                    $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                    Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($candidato, $sitio) {
                        $message->to($candidato->email, "T3RS")
                            ->subject("Notificación exámenes médicos")
                            ->bcc($sitio->email_replica)
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });

                    //guardar que se realizo una notificacion al candidato
                    $noti_cand = new NotificacionCandidatoExamenMedico();
                    $noti_cand->fill([
                        'proceso_id'        => $id_proceso,
                        'observacion'       => $data->observacion_candidato,
                        'req_cand_id'       => $data->get("candidato_req"),
                        'user_gestion_id'   => $this->user->id
                    ]);
                    $noti_cand->save();
                } catch (\Exception $e) {
                    logger('Excepción capturada en ReclutamientoController envio de correo de notificación al candidato al enviarlo a exámenes médicos: '.  $e->getMessage(). "\n");
                }
            }
        }

        return response()->json(["success" => true, 'id_proceso' => $id_proceso]);
    }

    public function enviar_estudio_seguridad(Request $data)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->join("ciudad", "ciudad.id", "=", "requerimientos.ciudad_id")
        ->leftjoin("clientes", "clientes.id", "=", "requerimientos.negocio_id")
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->select(
            "datos_basicos.*",
            "requerimiento_cantidato.id as req_candidato",
            "requerimientos.*",
            "clientes.nombre as cliente",
            "cargos_especificos.descripcion as cargo",
            "ciudad.nombre as ciudad"
        )
        ->first();

        if(1==2){

            $campos = [
                'requerimiento_candidato_id' => $data->get("candidato_req"),
                'usuario_envio'              => $this->user->id,
                'proceso'                    => "ENVIO_ESTUDIO_SEGURIDAD",
            ];

            $orden = new OrdenEstudioSeguridad();
            $orden->fill(["proveedor_id" => $data->get("proveedor"), "req_can_id" => $data->get("candidato_req")]);
            $orden->save();

            foreach($data->estudio_seg as $estudioSeg){
                $nuevo_estudio = new EstudiosSeguridad();

                $nuevo_estudio->fill([
                    "orden_seg_id"   => $orden->id,
                    "estudio_seg_id" => $estudioSeg,            
                ]);

                $nuevo_estudio->save();
            }

            $estado = config('conf_aplicacion.C_EN_PROCESO_CONTRATACION');

            //Datos para correo
            $DataExamenes = EstudiosSeguridad::join('estudios_seguridad_list', 'estudios_seguridad_list.id','=','estudio_seguridad.estudio_seg_id')
            ->where('orden_seg_id', $orden->id)
            ->select('estudios_seguridad_list.nombre as examen_medico')
            ->get();

            $DataOrder = OrdenEstudioSeguridad::join('proveedor', 'proveedor.id', '=', 'orden_estudio_seguridad.proveedor_id')
            ->where('orden_estudio_seguridad.id', $orden->id)
            ->select('orden_estudio_seguridad.*', 'orden_estudio_seguridad.observacion as otros', 'proveedor.nombre as centro_medico', 'proveedor.email as email')
            ->first();

            $emails = $DataOrder->email;

            //return view("admin.email_orden_examen_medico", compact('DataExamenes','DataCandidato','DataOrder'));

            $asunto = "Orden estudio seguridad # $orden->id";

            Mail::send('admin.email_orden_examen_medico', ["EstudioSeguridad" => true, "DataExamenes" => $DataExamenes, "candidato" => $candidato, "DataOrder" => $DataOrder],function($message) use ($emails, $asunto) {
                $message->to($emails)->subject($asunto)
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

            //$id_proceso = $this->RegistroProceso($campos, $estado, $data->get("candidato_req"));
        }else{
            $campos = [
                'requerimiento_candidato_id' => $data->get("candidato_req"),
                'usuario_envio'      => $this->user->id,
                'proceso'            => "ENVIO_ESTUDIO_SEGURIDAD"
            ];

            $estado = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
        }
        $id_proceso = $this->RegistroProceso($campos, $estado, $data->get("candidato_req"));

        //envio de correo estudio de seguridad datos del candidato
        $req_can = ReqCandidato::find($data->get("candidato_req"));

        $requerimiento = Requerimiento::find($req_can->requerimiento_id);
            
        $candidato = User::find($req_can->candidato_id);

        if(route("home") == "https://listos.t3rsc.co" && route("home") == "https://pruebaslistos.t3rsc.co"){
            Mail::send('admin.email-envio-estudioseg', [
                'candidato' => $candidato,
                'req'       => $requerimiento,
                'req_can'   => $req_can
            ],function ($message) use ($requerimiento) {
                $message->to(['lorena.rodriguez@visionymarketing.com.co'], "T3RS")
                    //$message->to(['juli.gzulu@gmail.com','javier5chiquito@gmail.com'], "T3RS")
                    ->subject("Notificacion Estudio Seguridad # $requerimiento->id")
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }
        
        //datos del candidato
        return response()->json(["success" => true, 'id_proceso' => $id_proceso]);
    }

    public function enviar_pruebas_view(Request $data)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato", "requerimiento_cantidato.requerimiento_id as req_id")
        ->first();

        $cargo = Requerimiento::find($candidato->req_id);

        $sitio = Sitio::first();
        $sitioModulo = SitioModulo::first();

        $configuracionExcel = PruebaExcelConfiguracion::where('req_id', $candidato->req_id)->first();
        if (empty($configuracionExcel)) {
            //Se verifica si el sitio configura la prueba de Excel Basico y/o Intermedio
            if ($sitio->prueba_excel_basico || $sitio->prueba_excel_intermedio) {
                $cargo_especifico = CargoEspecifico::where('id', $cargo->cargo_especifico_id)->first();

                if ($cargo_especifico->excel_basico || $cargo_especifico->excel_intermedio) {
                    $configuracionExcel = new PruebaExcelConfiguracion();

                    $configuracionExcel->gestiono     = $this->user->id;
                    $configuracionExcel->req_id       = $candidato->req_id;
                    $configuracionExcel->excel_basico                 = $cargo_especifico->excel_basico;
                    $configuracionExcel->excel_intermedio             = $cargo_especifico->excel_intermedio;
                    $configuracionExcel->tiempo_excel_basico          = $cargo_especifico->tiempo_excel_basico;
                    $configuracionExcel->tiempo_excel_intermedio      = $cargo_especifico->tiempo_excel_intermedio;
                    $configuracionExcel->aprobacion_excel_basico      = $cargo_especifico->aprobacion_excel_basico;
                    $configuracionExcel->aprobacion_excel_intermedio  = $cargo_especifico->aprobacion_excel_intermedio;

                    $configuracionExcel->save();
                }
            }
        }

        $configuracionPruebaValores1 = PruebaValoresConfigRequerimiento::where('req_id', $candidato->req_id)->first();
        if (empty($configuracionPruebaValores1)) {
            //Se verifica si el sitio configura la prueba de valores 1
            if ($sitioModulo->prueba_valores1 == 'enabled') {
                $cargoConfigPruebas = CargoEspecificoConfigPruebas::where('cargo_especifico_id', $cargo->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();

                //Si el cargo tiene configurada la prueba de valores, se agrega la configuracion al requerimiento
                if ($cargoConfigPruebas != null) {
                    $configuracionPruebaValores1 = new PruebaValoresConfigRequerimiento();
                    $configuracionPruebaValores1->gestiono            = $this->user->id;
                    $configuracionPruebaValores1->req_id              = $candidato->req_id;
                    $configuracionPruebaValores1->prueba_valores_1    = 'enabled';
                    $configuracionPruebaValores1->valor_verdad        = $cargoConfigPruebas->valor_verdad;
                    $configuracionPruebaValores1->valor_rectitud      = $cargoConfigPruebas->valor_rectitud;
                    $configuracionPruebaValores1->valor_paz           = $cargoConfigPruebas->valor_paz;
                    $configuracionPruebaValores1->valor_amor          = $cargoConfigPruebas->valor_amor;
                    $configuracionPruebaValores1->valor_no_violencia  = $cargoConfigPruebas->valor_no_violencia;

                    $configuracionPruebaValores1->save();
                }
            }
        }

        //Validar si hay configuración en cargo o req
        $configuracionCompetencias = PruebaCompetenciaReq::where('req_id', $candidato->req_id)->orderBy('created_at', 'DESC')->first();

        if (empty($configuracionCompetencias)) {
            $configuracionCompetencias = PruebaCompetenciaCargo::where('cargo_id', $cargo->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();
        }

        //
        $configuracionDigitacion = PruebaDigitacionReq::where('req_id', $candidato->req_id)->orderBy('created_at', 'DESC')->first();

        if (empty($configuracionDigitacion)) {
            $configuracionDigitacion = PruebaDigitacionCargo::where('cargo_id', $cargo->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();
        }

        //
        $configuracionBryg = PruebaBrigConfigRequerimiento::where('req_id', $candidato->req_id)->orderBy('created_at', 'DESC')->first();

        if (empty($configuracionBryg)) {
            $configuracionBryg = PruebaBrigConfigCargo::where('cargo_id', $cargo->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();
        }

        return view("admin.reclutamiento.modal.enviar_pruebas", compact(
            "candidato",
            "sitio",
            "sitioModulo",
            "configuracionExcel",
            "configuracionCompetencias",
            "configuracionPruebaValores1",
            "configuracionDigitacion",
            "configuracionBryg",
            "configuracionBryg"
        ));
    }

    public function confirmar_prueba(Request $data)
    {
        $pruebas = $data->pruebas;
        $sitio = Sitio::first();

        $datos_candidato = ReqCandidato::join('datos_basicos', 'datos_basicos.user_id', '=', 'requerimiento_cantidato.candidato_id')
        ->where('requerimiento_cantidato.id', $data->get("candidato_req"))
        ->select(
            'requerimiento_cantidato.requerimiento_id as req_id',
            'datos_basicos.telefono_movil',
            'datos_basicos.email as email',
            'datos_basicos.user_id as user_id',
            DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',IF(datos_basicos.segundo_apellido is not NULL,datos_basicos.segundo_apellido, '')) AS nombre_completo")
        )
        ->first();

        for ($i = 0; $i < count($pruebas); $i++) { 
            //Externa (Normal)
            if($pruebas[$i] == 1){
                $campos = [
                    'requerimiento_candidato_id' => $data->get("candidato_req"),
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    'proceso'                    => "ENVIO_PRUEBAS",
                ];

                $id_proceso = $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));
            }

            //Excel o Prueba de valores
            if($pruebas[$i] == 3 || $pruebas[$i] == 4 || $pruebas[$i] == 6){
                if($pruebas[$i] == 3) {
                    $proceso = "ENVIO_EXCEL_BASICO";
                    $titulo  = "Prueba Excel Básico";
                    $ruta    = "cv.prueba_excel_basico";
                    $ruta_boton_whatsapp = "prueba-excel-basico";
                } else if($pruebas[$i] == 4) {
                    $proceso = "ENVIO_EXCEL_INTERMEDIO";
                    $titulo  = "Prueba Excel Intermedio";
                    $ruta    = "cv.prueba_excel_intermedio";
                    $ruta_boton_whatsapp = "prueba-excel-intermedio";
                } else if($pruebas[$i] == 6) {
                    $proceso = "ENVIO_PRUEBA_ETHICAL_VALUES";
                    $titulo  = "Prueba Ethical Values";
                    $ruta    = "cv.prueba_valores_1";
                    $ruta_boton_whatsapp = "prueba-ethical-values";
                }

                $campos = [
                    'requerimiento_candidato_id' => $data->get("candidato_req"),
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    'proceso'                    => "$proceso",
                ];

                $id_proceso = $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));

                /*$mensaje_wpp = $sitio->mensajePruebasWhatsapp($datos_candidato->nombre_completo, $titulo, route($ruta, ['req_id' => $datos_candidato->req_id]));

                event(new \App\Events\NotificationWhatsappEvent("message",[
                    "phone"=>"57".$datos_candidato->telefono_movil,
                    "body"=> $mensaje_wpp
                ]));
                */
                $url = "cv+".$ruta_boton_whatsapp."+".$datos_candidato->req_id;

                event(new \App\Events\NotificationWhatsappEvent(
                    "whatsapp", 
                    $datos_candidato->telefono_movil,
                    "template", 
                    "proceso_pruebas_botones", 
                    [$datos_candidato->nombre_completo, $titulo, $url]
                ));
                /**
                 *
                 * Usar administrador de correos
                 *
                */
                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                $mailTitle = "$titulo"; //Titulo o tema del correo

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "
                    Hola $datos_candidato->nombre_completo, has sido enviado/a en tu proceso de selección a realizar nuestra $titulo. <br>
                    Por favor haz clic en botón <b>Realizar prueba</b> y sigue las instrucciones que te brindará la plataforma. <br><br>
                    <i>¡Muchos éxitos!</i>
                ";

                //Arreglo para el botón
                $mailButton = ['buttonText' => 'Realizar prueba', 'buttonRoute' => route($ruta, ['req_id' => $datos_candidato->req_id])];

                $mailUser = $datos_candidato->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                //Enviar correo generado
                Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($datos_candidato, $sitio, $titulo) {
                    $message->to([$datos_candidato->email], 'T3RS')
                    ->bcc($sitio->email_replica)
                    ->subject("$titulo")
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
                /**
                 * Fin administrador correos
                */
            }

            //Competencias
            if($pruebas[$i] == 5){
                //Crea registro para guardar los resultados
                $result_test = new PruebaCompetenciaResultado();
                $result_test->fill([
                    'req_id'         => $datos_candidato->req_id,
                    'user_id'        => $datos_candidato->user_id,
                    'gestion_id'     => $this->user->id
                ]);
                $result_test->save();

                $campos = [
                    'requerimiento_candidato_id' => $data->get("candidato_req"),
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    'proceso'                    => "ENVIO_PRUEBA_COMPETENCIA",
                ];

                $id_proceso = $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));

                /*$mensaje_wpp = $sitio->mensajePruebasWhatsapp($datos_candidato->nombre_completo, 'prueba de competencias', route('cv.competencias_inicio'));

                event(new \App\Events\NotificationWhatsappEvent("message",[
                    "phone"=>"57".$datos_candidato->telefono_movil,
                    "body"=> $mensaje_wpp
                ]));
                */
                $url = "cv+competencias-inicio";
                $titulo = 'prueba de competencias';

                event(new \App\Events\NotificationWhatsappEvent(
                    "whatsapp", 
                    $datos_candidato->telefono_movil,
                    "template", 
                    "proceso_pruebas_botones", 
                    [$datos_candidato->nombre_completo, $titulo, $url]
                ));
                /**
                 *
                 * Usar administrador de correos
                 *
                */
                    $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                    $mailConfiguration = 1; //Id de la configuración
                    $mailTitle = "Prueba Competencias"; //Titulo o tema del correo

                    //Cuerpo con html y comillas dobles para las variables
                    $mailBody = "
                        Hola $datos_candidato->nombre_completo, has sido enviad@ en tu proceso de selección a realizar nuestra prueba de competencias. <br>
                        Por favor haz clic en botón <b>Realizar prueba</b> y sigue las instrucciones que te brindará la plataforma. <br><br>
                        <i>¡Muchos éxitos!</i>
                    ";

                    //Arreglo para el botón
                    $mailButton = ['buttonText' => 'Realizar prueba', 'buttonRoute' => route('cv.competencias_inicio')];

                    $mailUser = $datos_candidato->user_id; //Id del usuario al que se le envía el correo

                    $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                    //Enviar correo generado
                    Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($datos_candidato, $sitio) {
                        $message->to([$datos_candidato->email], 'T3RS')
                        ->bcc($sitio->email_replica)
                        ->subject("Prueba Competencias")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                /**
                 * Fin administrador correos
                */
            }

            if ($pruebas[$i] == 7) {
                //Crea registro para guardar los resultados
                $result_test = new PruebaDigitacionResultado();
                $result_test->fill([
                    'req_id'         => $datos_candidato->req_id,
                    'user_id'        => $datos_candidato->user_id,
                    'gestion_id'     => $this->user->id
                ]);
                $result_test->save();

                //Datos para el proceso
                $procesoInformacion = [
                    'requerimiento_candidato_id' => $data->get("candidato_req"),
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    'proceso'                    => "ENVIO_PRUEBA_DIGITACION",
                ];

                $id_proceso = $this->RegistroProceso($procesoInformacion, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));

                /*$mensaje_wpp = $sitio->mensajePruebasWhatsapp($datos_candidato->nombre_completo, 'prueba de digitación', route('cv.digitacion_inicio'));

                event(new \App\Events\NotificationWhatsappEvent("message",[
                    "phone"=>"57".$datos_candidato->telefono_movil,
                    "body"=> $mensaje_wpp
                ]));
                */
                $url = "cv+digitacion-inicio";
                $titulo = 'prueba de digitación';

                event(new \App\Events\NotificationWhatsappEvent(
                    "whatsapp", 
                    $datos_candidato->telefono_movil,
                    "template", 
                    "proceso_pruebas_botones", 
                    [$datos_candidato->nombre_completo, $titulo, $url]
                ));
                /**
                 *
                 * Usar administrador de correos
                 *
                */
                    $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                    $mailConfiguration = 1; //Id de la configuración
                    $mailTitle = "Prueba Digitación"; //Titulo o tema del correo

                    //Cuerpo con html y comillas dobles para las variables
                    $mailBody = "
                        Hola $datos_candidato->nombre_completo, has sido enviad@ en tu proceso de selección a realizar nuestra prueba de digitación. <br>
                        Por favor haz clic en botón <b>Realizar prueba</b> y sigue las instrucciones que te brindará la plataforma. <br><br>
                        <i>¡Muchos éxitos!</i>
                    ";

                    //Arreglo para el botón
                    $mailButton = ['buttonText' => 'Realizar prueba', 'buttonRoute' => route('cv.digitacion_inicio')];

                    $mailUser = $datos_candidato->user_id; //Id del usuario al que se le envía el correo

                    $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                    //Enviar correo generado
                    Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($datos_candidato, $sitio) {
                        $message->to([$datos_candidato->email], 'T3RS')
                        ->bcc($sitio->email_replica)
                        ->subject("Prueba Digitación")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                /**
                 * Fin administrador correos
                */
            }

            //Bryg
            if($pruebas[$i] == 2){
                //Validar si hay configuración en cargo o req
                /*$configuracion = PruebaBrigConfigRequerimiento::where('req_id', $datos_candidato->req_id)->orderBy('created_at', 'DESC')->first();

                if (empty($configuracion)) {
                    $cargo = Requerimiento::find($datos_candidato->req_id);
                    $configuracion = PruebaBrigConfigCargo::where('cargo_id', $cargo->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();

                    if (empty($configuracion)) {
                        return response()->json(['configuracion' => true]);
                    }
                }*/

                $pruebaBrygCandidato = PruebaBrigResultado::where('user_id', $datos_candidato->user_id)
                ->where('estado', 1)
                ->orderBy('created_at', 'DESC')
                ->first();

                if (!empty($pruebaBrygCandidato)) {
                    return response()->json(['reusar' => true]);
                }

                //Crea registro para guardar los resultados
                $result_test = new PruebaBrigResultado();
                $result_test->fill([
                    'req_id'         => $datos_candidato->req_id,
                    'user_id'        => $datos_candidato->user_id,
                    'gestion_id'     => $this->user->id
                ]);
                $result_test->save();

                $campos = [
                    'requerimiento_candidato_id' => $data->get("candidato_req"),
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    'proceso'                    => "ENVIO_PRUEBA_BRYG",
                ];

                $id_proceso = $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));

                /*$mensaje_wpp = $sitio->mensajePruebasWhatsapp($datos_candidato->nombre_completo, 'prueba BRYG-A', route('cv.prueba_inicio'));

                event(new \App\Events\NotificationWhatsappEvent("message",[
                    "phone"=>"57".$datos_candidato->telefono_movil,
                    "body"=> $mensaje_wpp
                ]));
                */
                $url = "cv+prueba-inicio";
                $titulo = 'prueba BRYG-A';

                event(new \App\Events\NotificationWhatsappEvent(
                    "whatsapp", 
                    $datos_candidato->telefono_movil,
                    "template", 
                    "proceso_pruebas_botones", 
                    [$datos_candidato->nombre_completo, $titulo, $url]
                ));
                /**
                 *
                 * Usar administrador de correos
                 *
                */
                    $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                    $mailConfiguration = 1; //Id de la configuración
                    $mailTitle = "Prueba BRYG-A"; //Titulo o tema del correo

                    //Cuerpo con html y comillas dobles para las variables
                    $mailBody = "
                        Hola $datos_candidato->nombre_completo, has sido enviad@ en tu proceso de selección a realizar nuestra prueba BRYG-A. <br>
                        Por favor haz clic en botón <b>Realizar prueba</b> y sigue las instrucciones que te brindará la plataforma. <br><br>
                        <i>¡Muchos éxitos!</i>
                    ";

                    //Arreglo para el botón
                    $mailButton = ['buttonText' => 'Realizar prueba', 'buttonRoute' => route('cv.prueba_inicio')];

                    $mailUser = $datos_candidato->user_id; //Id del usuario al que se le envía el correo

                    $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                    //Enviar correo generado
                    Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($datos_candidato, $sitio) {
                        $message->to([$datos_candidato->email], 'T3RS')
                        ->bcc($sitio->email_replica)
                        ->subject("Prueba BRYG-A")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                /**
                 * Fin administrador correos
                */
            }
        }

        $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();
        
        return response()->json([
            "success" => true,
            "text_estado" => $estado->descripcion,
            "candidato_req" => $data->get("candidato_req"),
            "id_proceso" => $id_proceso
        ]);
    }

    public function reusar_prueba_bryg(Request $data)
    {
        $datos_candidato = ReqCandidato::join('datos_basicos', 'datos_basicos.user_id', '=', 'requerimiento_cantidato.candidato_id')
        ->where('requerimiento_cantidato.id', $data->get("candidato_req"))
        ->select(
            'requerimiento_cantidato.requerimiento_id as req_id',
            'datos_basicos.email as email',
            'datos_basicos.user_id as user_id',
            'datos_basicos.telefono_movil',
            DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',IF(datos_basicos.segundo_apellido is not NULL, datos_basicos.segundo_apellido, '')) AS nombre_completo")
        )
        ->first();

        if ($data->reusar == 'si' || $data->reusar === 'si') {
            //Reusar prueba
            $pruebaBrygCandidato = PruebaBrigResultado::where('user_id', $datos_candidato->user_id)
            ->where('estado', 1)
            ->orderBy('created_at', 'DESC')
            ->first();

            //Crea registro para guardar los resultados
            $result_test = new PruebaBrigResultado();
            $result_test->fill([
                'req_id'         => $datos_candidato->req_id,
                'user_id'        => $datos_candidato->user_id,
                'gestion_id'     => $this->user->id,
                'estilo_radical' => $pruebaBrygCandidato->estilo_radical,
                'estilo_genuino' => $pruebaBrygCandidato->estilo_genuino,
                'estilo_garante' => $pruebaBrygCandidato->estilo_garante,
                'estilo_basico' => $pruebaBrygCandidato->estilo_basico,
                'aumented_a' => $pruebaBrygCandidato->aumented_a,
                'aumented_p' => $pruebaBrygCandidato->aumented_p,
                'aumented_d' => $pruebaBrygCandidato->aumented_d,
                'aumented_r' => $pruebaBrygCandidato->aumented_r,
                'ajuste_perfil' => $pruebaBrygCandidato->ajuste_perfil,
                'estado' => 1,
                'fecha_realizacion' => $pruebaBrygCandidato->fecha_realizacion
            ]);
            $result_test->save();

            $campos = [
                'requerimiento_candidato_id' => $data->get("candidato_req"),
                'usuario_envio'              => $this->user->id,
                "fecha_inicio"               => date("Y-m-d H:i:s"),
                'proceso'                    => "ENVIO_PRUEBA_BRYG",
                'observaciones'              => "Prueba BRYG-A reusada de una anteriormente realizada por el candidato."
            ];
        }else {
            //Crea registro para guardar los resultados
            $result_test = new PruebaBrigResultado();
            $result_test->fill([
                'req_id'         => $datos_candidato->req_id,
                'user_id'        => $datos_candidato->user_id,
                'gestion_id'     => $this->user->id
            ]);
            $result_test->save();

            $campos = [
                'requerimiento_candidato_id' => $data->get("candidato_req"),
                'usuario_envio'              => $this->user->id,
                "fecha_inicio"               => date("Y-m-d H:i:s"),
                'proceso'                    => "ENVIO_PRUEBA_BRYG",
            ];

            $url = "cv+prueba-inicio";
            $titulo = 'prueba BRYG-A';

            event(new \App\Events\NotificationWhatsappEvent(
                "whatsapp", 
                $datos_candidato->telefono_movil,
                "template", 
                "proceso_pruebas_botones", 
                [$datos_candidato->nombre_completo, $titulo, $url]
            ));

            /**
             *
             * Usar administrador de correos
             *
            */
                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                $mailTitle = "Prueba BRYG-A"; //Titulo o tema del correo

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "
                    Hola $datos_candidato->nombre_completo, has sido enviad@ en tu proceso de selección a realizar nuestra prueba BRYG-A. <br>
                    Por favor haz clic en botón <b>Realizar prueba</b> y sigue las instrucciones que te brindará la plataforma. <br><br>
                    <i>¡Muchos éxitos!</i>
                ";

                //Arreglo para el botón
                $mailButton = ['buttonText' => 'Realizar prueba', 'buttonRoute' => route('cv.prueba_inicio')];

                $mailUser = $datos_candidato->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                //Enviar correo generado
                Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($datos_candidato) {
                    $message->to([$datos_candidato->email], 'T3RS')
                    ->subject("Prueba BRYG-A")
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            /**
             * Fin administrador correos
            */
        }

        $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));

        return response()->json(['success' => true]);
    }

    //dotacion de candidatos
    public function dotacion_view(Request $data)
    {
       $req = Requerimiento::find($data->req);
       $dotacion = $req->detalle_dotacion;

      return view("admin.reclutamiento.modal.detalle_dotacion", compact('dotacion'));
    }

    public function confirmar_dotacion(Request $data)
    {
        $campos = ['detalle_dotacion' => $data->get("detalle_dotacion"), 'req' => $data->get("req")];

        $req = Requerimiento::find($campos["req"]);
        $req->detalle_dotacion = $campos['detalle_dotacion'];
        $req->save();

        return response()->json(["success" => true]);
    }

    public function kactus_view(Request $data)
    {
        $req = Requerimiento::find($data->req);
        $kactus = $req->id_kactus;

        return view("admin.reclutamiento.modal.detalle_kactus", compact('kactus'));
    }

    public function confirmar_kactus(Request $data)
    {
        $campos = ['id_kactus' => $data->get("id_kactus"), 'req' => $data->get("req")];

        $req = Requerimiento::find($campos["req"]);
        $req->id_kactus = $campos['id_kactus'];
        $req->save();

        return response()->json(["success" => true]);
    }

    public function enviar_referenciacion_view(Request $data)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
        ->first();

        return view("admin.reclutamiento.modal.enviar_referenciacion", compact("candidato"));
    }

    public function confirmar_referenciacion(Request $data)
    {
        /*$valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_REFERENCIACION", $data->get("candidato_req"));

        if ($valida_proceso["success"]) {
            return response()->json(["success" => false, "view" => $valida_proceso["view"]]);
        }*/

        //Usuarios a quienes se envian el correo
        /*$emails = User::join("role_users", "role_users.user_id", "=", "users.id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->whereIn("role_users.role_id", [
                config('conf_aplicacion.REFERENCIACION'),
            ])
            ->pluck("datos_basicos.email")
            ->toArray();*/
        //dd($emails);

        //Variables de notificación---------------------------------------------------------------
        //Datos del usuario
        /* $datos_usuario = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->first();
        //dd($datos_usuario);

        $funcionesGlobales = new FuncionesGlobales();
        if (isset($funcionesGlobales->sitio()->nombre)) {
            if ($funcionesGlobales->sitio()->nombre != "") {
                $nombre = $funcionesGlobales->sitio()->nombre;
            } else {
                $nombre = "Desarrollo";
            }
        }*/

        //Email Notificacion para los
        /* Mail::send('emails.interna.referenciar', ["datos_usuario" => $datos_usuario], function ($message) use ($data, $emails) {
            $message->to('apolorubiano@gmail.com', '$nombre -T3RS')->cc($emails)->subject('Notificación (Envió a Referenciar)!');
        });*/

        $campos = [
           'requerimiento_candidato_id' => $data->get("candidato_req"),
           'usuario_envio'              => $this->user->id,
           "fecha_inicio"               => date("Y-m-d H:i:s"),
           'proceso'                    => "ENVIO_REFERENCIACION",
        ];

        $id_proceso = $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));

        $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();

        return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $data->get("candidato_req"),'id_proceso' => $id_proceso]);
    }

    public function enviar_referencia_estudios_view(Request $data)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
        ->first();
        
        $es_referencia_estudios = true;

        return view("admin.reclutamiento.modal.enviar_referenciacion", compact("candidato", "es_referencia_estudios"));
    }

    public function confirmar_referencia_estudios(Request $data)
    {
        
        $campos = [
           'requerimiento_candidato_id' => $data->get("candidato_req"),
           'usuario_envio'              => $this->user->id,
           "fecha_inicio"               => date("Y-m-d H:i:s"),
           'proceso'                    => "ENVIO_REFERENCIA_ESTUDIOS",
        ];

        $id_proceso = $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));

        $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();

        return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $data->get("candidato_req"),'id_proceso' => $id_proceso]);
    }

    public function enviar_entrevista_view(Request $data)
    {
        $tipo_entrevista = array();

        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
        ->first();

        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
            $tipo_entrevista = array(0 => "RRHH", 1 => "TECNICA");
        }
       
        return view("admin.reclutamiento.modal.enviar_entrevista", compact("candidato", "tipo_entrevista"));
    }

    public function enviar_entrevista_asistencia(Request $data)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->leftjoin('entrevistas_candidatos', 'entrevistas_candidatos.req_id', '=', 'requerimiento_cantidato.requerimiento_id')
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->select(
            'entrevistas_candidatos.id as entre_id',
            "requerimiento_cantidato.requerimiento_id as req_id",
            "requerimiento_cantidato.candidato_id as candidato_id",
            "datos_basicos.*", "requerimiento_cantidato.id as req_candidato"
        )
        ->first();

        return view("admin.reclutamiento.modal.asistencia_entrevista", compact("candidato"));
    }

    public function confirmar_asistencia(Request $data)
    {
        $entrevista = EntrevistaCandidatos::join('users', 'users.id', '=', 'entrevistas_candidatos.candidato_id')
        ->join('requerimiento_cantidato', 'requerimiento_cantidato.candidato_id', '=', 'users.id')
        ->where("entrevistas_candidatos.req_id", $data->get("req_id"))
        ->where('entrevistas_candidatos.candidato_id', $data->get('candidato_id'))
        ->select('entrevistas_candidatos.id as entre_id', 'entrevistas_candidatos.candidato_id as candidato_id')
        ->groupBy('entrevistas_candidatos.candidato_id')
        ->get();

        if ($entrevista->count() === 0) {
            $mensaje = "No se le ha hecho la entrevista al candidato.";
            return response()->json(["success" => false, "mensaje_error" => $mensaje, 'candidato_req' => $data->get("candidato_req")]);
        }

        foreach ($entrevista as $key => $entre) {
            $ae = EntrevistaCandidatos::find($entre->entre_id);
            $ae->fill(['asistio' => 1]);
            $ae->save();
        }

        return response()->json(["success" => true, 'candidato_req' => $data->get("candidato_req")]);
    }

    public function enviar_asistencia_view_masivo(Request $data)
    {
        $datos_basicos = [];
        $req_can_id = [];
        $req_id = $data->req_id;

        foreach($data->req_candidato as $key => $req_candi_id) {        
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id",$req_candi_id)
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
            ->first();
            
            array_push($datos_basicos, $candidato->nombres);
            array_push($req_can_id, $candidato->req_candidato);
        }

        $req_can_id_j = json_encode($req_can_id);

        return view("admin.reclutamiento.modal.enviar_asistencia_masivo", compact("req_id", "datos_basicos", "req_can_id_j"));
    }

    // Enviar Pruebas Masivo
    public function enviar_pruebas_view_masivo(Request $data)
    {
        $datos_basicos =[];
        $req_can_id = [];
        $req_id = $data->req_id;

        foreach ($data->req_candidato as $key => $req_candi_id) {
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id",$req_candi_id)
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
            ->first();
            
            array_push($datos_basicos, $candidato->nombres);
            array_push($req_can_id, $candidato->req_candidato);
        }
        
        $req_can_id_j = json_encode($req_can_id);

        $cargo = Requerimiento::find($req_id);

        $sitio = Sitio::first();
        $sitioModulo = SitioModulo::first();

        $configuracionExcel = PruebaExcelConfiguracion::where('req_id', $req_id)->first();

        $configuracionPruebaValores1 = PruebaValoresConfigRequerimiento::where('req_id', $req_id)->first();

        //Validar si hay configuración en cargo o req
        $configuracionCompetencias = PruebaCompetenciaReq::where('req_id', $req_id)->orderBy('created_at', 'DESC')->first();

        if (empty($configuracionCompetencias)) {
            $configuracionCompetencias = PruebaCompetenciaCargo::where('cargo_id', $cargo->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();
        }

        $configuracionDigitacion = PruebaDigitacionReq::where('req_id', $req_id)->orderBy('created_at', 'DESC')->first();

        if (empty($configuracionDigitacion)) {
            $configuracionDigitacion = PruebaDigitacionCargo::where('cargo_id', $cargo->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();
        }

        $configuracionBryg = PruebaBrigConfigRequerimiento::where('req_id', $req_id)->orderBy('created_at', 'DESC')->first();

        if (empty($configuracionBryg)) {
            $configuracionBryg = PruebaBrigConfigCargo::where('cargo_id', $cargo->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();
        }

        return view("admin.reclutamiento.modal.enviar_pruebas_masivo", 
            compact(
                "datos_basicos",
                "req_can_id_j",
                "req_id",
                "sitio",
                "sitioModulo",
                "configuracionBryg",
                "configuracionExcel",
                "configuracionDigitacion",
                "configuracionCompetencias",
                "configuracionPruebaValores1"
            )
        );
    }

    public function contratar_masivo_cliente(Request $data)
    {
        $req_candidato_id =[];
        $contratos_clientes = [];
        $user_id = $this->user->id;
      
        foreach ($data->req_candidato_id as $key => $req_can_id) {
            $contra_clientes = RegistroProceso::select('procesos_candidato_req.*')
            ->where('procesos_candidato_req.requerimiento_candidato_id', $req_can_id)
            ->where('procesos_candidato_req.proceso', 'ENVIO_CONTRATACION_CLIENTE')
            ->orderBy('procesos_candidato_req.id', 'desc')
            ->first();

            if ($contra_clientes != null) {
                array_push($contratos_clientes, $contra_clientes->id);
            }

            array_push($req_candidato_id, $req_can_id);
        }

        $usuarios_clientes = ["" => "Seleccion"] + EloquentUser::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
        ->where("users_x_clientes.cliente_id", $data->cliente_id)->pluck("users.name", "users.id")->toArray();

        return view("admin.reclutamiento.modal.enviar_contratacion_cliente_masivo_new", compact("req_candidato_id", "usuarios_clientes", "user_id"));
    }

    public function contratar_masivo_cliente_admin(Request $data)
    {
        $req_candidato_id =[];
        $contratos_clientes= [];
        $user_id = $this->user->id;
        $req_id = $data->req_id;

        foreach($data->req_candidato as $key => $req_can_id) {            
            $contra_clientes = RegistroProceso::select('procesos_candidato_req.*')
            ->where('procesos_candidato_req.requerimiento_candidato_id', $req_can_id)
            ->where('procesos_candidato_req.proceso', 'ENVIO_CONTRATACION_CLIENTE')
            ->orderBy('procesos_candidato_req.id', 'desc')
            ->first();

            array_push($req_candidato_id, $req_can_id);
        }

        $usuarios_clientes = ["" => "Seleccion"] + EloquentUser::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
        ->where("users_x_clientes.cliente_id", $data->cliente_id)->pluck("users.name", "users.id")
        ->toArray();

        return view("admin.reclutamiento.modal.enviar_contratacion_cliente_masivo_admin", compact("req_candidato_id", "contra_clientes", "usuarios_clientes", "user_id", "req_id"));
    }

    //examenes medicos
    public function enviar_examenes_masivo(Request $data)
    {
        $datos_basicos =[];
        $req_can_id = [];

        foreach($data->req_candidato as $key => $req_candi_id) {
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $req_candi_id)
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
            ->first();

            array_push($datos_basicos, $candidato->nombres);
            array_push($req_can_id, $candidato->req_candidato);
        }
        
        $req_can_id_j = json_encode($req_can_id);

        //Nuevo
        $sitio_modulo = SitioModulo::first();

        if($sitio_modulo->usa_ordenes_medicas == 'si'){
            //Para listos y VyM debe salir el otro modal

            $lleva_ordenes = 'si';   //Lleva ordenes modal grande

            $cargo_especifico = '-1';

            if ( $data->has('req_id') ) {
                
                $requerimiento = Requerimiento::find($data->req_id);
                $cargo_especifico = CargoEspecifico::with("examenes")->find($requerimiento->cargo_especifico_id);
            }

            $proveedores = ["" => "Seleccion"] + ProveedorTipoProveedor::join('proveedor',"proveedor.id","=","proveedor_tipo_proveedor.proveedor")
            ->where("proveedor_tipo_proveedor.tipo", 1)
            ->where("proveedor.estado", 1)
            ->orderBy("proveedor.nombre", "ASC")
            ->pluck("proveedor.nombre", "proveedor.id")->toArray();

            $examenes= ExamenMedico::where("examen_medico.status", 1)
            ->orderBy("examen_medico.nombre", "ASC")
            ->get();
        }else{
            //Para Listos y VyM lleva_ordenes siempre debe ser = 'no'
            $lleva_ordenes = 'no';
            $cargo_especifico = '';
            $proveedores = '';
            $examenes = '';
        }

         
        return view("admin.reclutamiento.modal.enviar_examenes_masivo", compact("datos_basicos", "req_can_id_j", "cargo_especifico", "proveedores", "examenes", "lleva_ordenes"));
    }

    public function guardar_examenes_masivo(Request $data)
    {
        $requerimientos_cand_id = json_decode($data->req_can_id);
        $candidatoNoEnviado = [];

        if($data->lleva_ordenes == 'si') {
            foreach ($requerimientos_cand_id as $key => $id_req_cand) {
                //Datos para creación del proceso
                $existeOrden = OrdenMedica::where("req_can_id", $id_req_cand)->first();
                if ($existeOrden != null) {
                    $cand = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                        ->where("requerimiento_cantidato.id", $id_req_cand)
                        ->select(
                            "datos_basicos.nombres",
                            "datos_basicos.numero_id"
                        )
                    ->first();
                    array_push($candidatoNoEnviado, "$cand->numero_id $cand->nombres");
                } else {
                    $campos = [
                        'requerimiento_candidato_id' => $id_req_cand,
                        'usuario_envio'              => $this->user->id,
                        'proceso'                    => "ENVIO_EXAMENES"
                    ];

                    $orden = new OrdenMedica();
                    $orden->fill([
                        "proveedor_id"  => $data->get("proveedor"),
                        "req_can_id"    => $id_req_cand,
                        "user_envio"    => $this->user->id,
                        "observacion"   => $data->get("observacion")
                    ]);
                    $orden->save();

                    $estado = new EstadosOrdenes();
                    $estado->fill([
                       "orden_id"  => $orden->id,
                       "estado_id" => 1
                    ]);
                    $estado->save();

                    foreach($data->examen as $examen){
                        $nuevo_examen = new ExamenesMedicos();

                        $nuevo_examen->fill([
                            "orden_id" => $orden->id,
                            "examen"   => $examen,            
                        ]);

                        $nuevo_examen->save();
                    }

                    $DataOrder = OrdenMedica::join('proveedor', 'proveedor.id', '=', 'orden_medica.proveedor_id')
                        ->join("requerimiento_cantidato","requerimiento_cantidato.id","=","orden_medica.req_can_id")
                        ->where('orden_medica.req_can_id', $id_req_cand)
                        ->select(
                            'orden_medica.*',
                            'orden_medica.observacion as otros',
                            'proveedor.nombre as centro_medico',
                            'proveedor.email as email',
                            'requerimiento_cantidato.requerimiento_id as req'
                        )
                        ->orderBy('orden_medica.id', 'desc')
                        ->first();

                    $DataExamenes = ExamenesMedicos::join('examen_medico', 'examen_medico.id', '=', 'examenes_medicos.examen')
                        ->where('orden_id', $DataOrder->id)
                        ->select('examen_medico.nombre as examen_medico')
                        ->get();

                    $emails = isset($DataOrder->email) ? explode(",", $DataOrder->email) : [];

                    $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                        ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                        ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                        ->join("departamentos", function ($join) {
                            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                            ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                        })->join("ciudad", function ($join2) {
                            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                        })
                        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                        ->where("requerimiento_cantidato.id", $id_req_cand)
                        ->select(
                            "datos_basicos.*",
                            "requerimiento_cantidato.id as req_candidato",
                            "requerimientos.*",
                            "requerimientos.id as id_req",
                            "clientes.nombre as cliente",
                            "cargos_especificos.descripcion as cargo",
                            "ciudad.nombre as ciudad"
                        )
                        ->first();

                    $asunto = "Orden exámenes médicos $candidato->cliente # $orden->id";

                    $empresa = '';
                    if($candidato->empresa_contrata != null) {
                        $empresa = DB::table("empresa_logos")->where('id', $candidato->empresa_contrata)->first();
                    }

                    Mail::send('admin.email_orden_examen_medico', [
                        "DataExamenes" => $DataExamenes,
                        "candidato" => $candidato,
                        "DataOrder" => $DataOrder,
                        "empresa" => $empresa
                    ],function($message) use ($emails, $asunto) {
                        $message->to($emails)->subject($asunto)
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });

                    $estado = config('conf_aplicacion.C_EN_EXAMENES_MEDICOS');
                    $this->RegistroProceso($campos, $estado, $id_req_cand);
                }
            }//fin foreach
        } else {
            foreach ($requerimientos_can_id as $key => $id_req_cand) {
                $campos = [
                    'requerimiento_candidato_id' => $id_req_cand,
                    'usuario_envio'              => $this->user->id,
                    'proceso'                    => "ENVIO_EXAMENES"
                ];

                $estado = config('conf_aplicacion.C_EN_EXAMENES_MEDICOS');
                $this->RegistroProceso($campos, $estado, $id_req_cand);
            }
        }

        return response()->json(["success" => true, "candidatos_no_enviados" => $candidatoNoEnviado]);
    }

    public function enviar_entrevista_virtual_view_masivo(Request $data)
    {
        $datos_basicos =[];
        $req_can_id = [];
        $cliente_id = $data->cliente_id;
        $req_id = $data->req_id;

        foreach ($data->req_candidato as $key => $req_candi_id) {
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id",$req_candi_id)
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
            ->first();
            
            array_push($datos_basicos, $candidato->nombres);
            array_push($req_can_id, $candidato->req_candidato);
        }

        $req_can_id_j = json_encode($req_can_id);

        return view("admin.reclutamiento.modal.enviar_entrevista_virtual_masivo", compact("cliente_id","req_id","datos_basicos","req_can_id_j"));
    }

    public function enviar_prueba_idioma_view_masivo(Request $data)
    {
        $datos_basicos =[];
        $req_can_id = [];
        $cliente_id = $data->cliente_id;
        $req_id = $data->req_id;

        foreach($data->req_candidato as $key => $req_candi_id){
        
         $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id",$req_candi_id)
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
            ->first();
            
            array_push($datos_basicos, $candidato->nombres);
            array_push($req_can_id, $candidato->req_candidato);
        }
           $req_can_id_j = json_encode($req_can_id);
                //dd($req_can_id);

       return view("admin.reclutamiento.modal.enviar_prueba_idioma_masivo", compact("cliente_id","req_id","datos_basicos","req_can_id_j"));
    }

    public function enviar_referenciacion_view_masivo(Request $data)
    {
        $datos_basicos =[];
        $req_can_id = [];

        foreach ($data->req_candidato as $key => $req_candi_id) {
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id",$req_candi_id)
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
            ->first();
                
            array_push($datos_basicos, $candidato->nombres);
            array_push($req_can_id, $candidato->req_candidato);
        }

        $req_can_id_j = json_encode($req_can_id);

        return view("admin.reclutamiento.modal.enviar_referenciacion_masivo", compact("datos_basicos","req_can_id_j"));
    }

    //Enviar entrevista masivo
    public function enviar_entrevista_view_masivo(Request $data)
    {
        $datos_basicos =[];
        $req_can_id = [];

        $tipo_entrevista=array();
        foreach ($data->req_candidato as $key => $req_candi_id) {
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id",$req_candi_id)
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
            ->first();
            
            array_push($datos_basicos, $candidato->nombres);
            array_push($req_can_id, $candidato->req_candidato);
        }
        
        $req_can_id_j = json_encode($req_can_id);

        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
            $tipo_entrevista = array(0 => "RRHH", 1 => "TECNICA");
        }

        return view("admin.reclutamiento.modal.enviar_entrevista_masivo", compact("datos_basicos", "req_can_id_j", "tipo_entrevista"));
    }

    //Validación documental masivo
    public function enviar_documento_view_masivo(Request $data)
    {   
        $datos_basicos =[];
        $req_can_id = [];

        foreach ($data->req_candidato as $key => $req_candi_id) {
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $req_candi_id)
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
            ->first();
            
            array_push($datos_basicos, $candidato->nombres);
            array_push($req_can_id, $candidato->req_candidato);
        }
        
        $req_can_id_j = json_encode($req_can_id);

        return view("admin.reclutamiento.modal.enviar_documento_masivo", compact("datos_basicos", "req_can_id_j"));
    }

    public function enviar_aprobar_cliente_view_masivo(Request $data)
    {
        $datos_basicos = [];
        $req_can_id = [];

        if ($data->req_candidato == null || $data->req_candidato == '') {
            return response()->json(["empty" => true]);
        }

        $req_id = ReqCandidato::where('requerimiento_cantidato.id', $data->req_candidato[0])
        ->join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->select('requerimiento_cantidato.requerimiento_id', "clientes.id as cliente")
        ->first();

        foreach ($data->req_candidato as $key => $req_candi_id) {
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $req_candi_id)
            ->select(
                "datos_basicos.*",
                "requerimiento_cantidato.id as req_candidato"
            )
            ->first();

            array_push($datos_basicos, $candidato->nombres.' '.$candidato->primer_apellido);
            array_push($req_can_id, $candidato->req_candidato);
        }

        $req_can_id_j = json_encode($req_can_id);

        $usuarios_clientes = ["" => "Selección"] + EloquentUser::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
        ->join("role_users", "role_users.user_id", "=", "users.id")
        ->where("role_users.role_id",3)
        ->where("users.estado",1)
        ->where("users_x_clientes.cliente_id", $req_id->cliente)
        ->pluck("users.name", "users.email")
        ->toArray();

        return view("admin.reclutamiento.modal.enviar_aprobar_cliente_masivo", compact("datos_basicos", "req_can_id_j", "req_id", "usuarios_clientes"));
    }

    public function aprobar_candidatos_admin_view_masivo(Request $data)
    {
        $req_id = $data->req_id;

        return view("admin.reclutamiento.modal.aprobar_candidatos_masivo", compact("req_id"));
    }

    public function confirmar_aprobar_candidato_masivo(Request $data) {
        $req_id = $data->req_id;
        $registros_modificados = 0;
        $errores_global = [];
        $index_errores = [];

        $reader = Excel::selectSheetsByIndex(0)->load($data->file("archivo"))->get();

        foreach ($reader as $key => $value) {

            $datos   = [
                "identificacion"   => $value->identificacion,
                "nombres"          => $value->nombres,
                "apto"             => $value->apto,
                "no_apto"          => $value->no_apto,
                "user_carga"       => $this->user->id
            ];

            $validator= Validator::make($datos,[
                "identificacion"    => "required"
            ]);

            if($validator->fails()){
                $errores_global[$key] = ["errores"=>$validator->errors()->all(),"tipo"=>"error"];
                $index_errores[] = $key;
                continue;
            }

            if (!is_null($value->apto) && !is_null($value->no_apto)) {
                //Si marca ambas columnas no se hace nada y se agrega como error
                $errores_global[$key] = ["errores"=> ['Ha marcado las casillas de apto y no apto'],"tipo"=>"error"];
                $index_errores[] = $key;
                continue;
            } else if(is_null($value->apto) && is_null($value->no_apto)) {
                //Si no marca ninguna opcion tampoco se hace nada y agrega el error
                $errores_global[$key] = ["errores"=> ['No ha marcado ninguna de las casillas de apto o no apto'],"tipo"=>"error"];
                $index_errores[] = $key;
                continue;
            }

            $proceso_cand_req = RegistroProceso::join('datos_basicos', 'datos_basicos.user_id', '=', 'procesos_candidato_req.candidato_id')
                ->where('procesos_candidato_req.proceso', 'ENVIO_APROBAR_CLIENTE')
                ->where('procesos_candidato_req.requerimiento_id', $req_id)
                ->where('datos_basicos.numero_id', $value->identificacion)
                ->select('procesos_candidato_req.*')
                ->orderBy('procesos_candidato_req.id', 'DESC')
            ->first();

            $apto = null;

            if (!is_null($value->apto)) {
                $apto = 1;  //apto
            } else if (!is_null($value->no_apto)) {
                $apto = 2;  //no_apto
            }

            if ($proceso_cand_req != null) {
                $proceso_cand_req->apto = $apto;
                $proceso_cand_req->usuario_terminacion = $this->user->id;
                $proceso_cand_req->fecha_fin = date("Y-m-d");
                $proceso_cand_req->save();

                if ($apto === 1) {
                    //SE ENVIA A EVALUACION SST
                    $nuevo_proceso_sst = new RegistroProceso();

                    $nuevo_proceso_sst->fill(
                        [
                            'requerimiento_candidato_id' => $proceso_cand_req->requerimiento_candidato_id,
                            'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            'fecha_inicio'               => date("Y-m-d H:i:s"),
                            'usuario_envio'              => $this->user->id,
                            'requerimiento_id'           => $req_id,
                            'candidato_id'               => $proceso_cand_req->candidato_id,
                            'proceso'                    => 'ENVIO_SST',
                            'observaciones'              => "Se envia a SST al ser apto el envio de aprobar cliente",
                        ]
                    );
                    $nuevo_proceso_sst->save();

                    //SE ENVIA A EXAMENES MEDICOS
                    $nuevo_proceso_examenes_medicos = new RegistroProceso();

                    $nuevo_proceso_examenes_medicos->fill(
                        [
                            'requerimiento_candidato_id' => $proceso_cand_req->requerimiento_candidato_id,
                            'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            'fecha_inicio'               => date("Y-m-d H:i:s"),
                            'usuario_envio'              => $this->user->id,
                            'requerimiento_id'           => $req_id,
                            'candidato_id'               => $proceso_cand_req->candidato_id,
                            'proceso'                    => 'ENVIO_EXAMENES',
                            'observaciones'              => "Se envia a examenes al ser apto el envio de aprobar cliente",
                        ]
                    );
                    $nuevo_proceso_examenes_medicos->save();
                }

                $registros_modificados++;
            } else {
                $errores_global[$key] = ["errores"=> ["Candidato con identificación <b>$value->identificacion</b>, no ha sido enviado a aprobar por cliente en este requerimiento."],"tipo"=>"error"];
                $index_errores[] = $key;
            }
        }

        return response()->json([
                "success" => true,
                "registros_modificados" => $registros_modificados,
                "mensaje_success" => "Se ha actualizado la información de <b>$registros_modificados</b> candidato(s) con éxito.<br>",
                "index_errores" => $index_errores,
                "errores_global"  => $errores_global
            ]);
    }

    public function excelCandidatosAprobarClienteMasivo(Request $request) {
        $req_id = $request->req;

        $sitio = Sitio::first();

        $nombre = "Desarrollo";
        if ( isset($sitio->nombre) ) {
            if ($sitio->nombre != "") {
                $nombre = $sitio->nombre;
            }
        }

        $headers = [
            'identificacion',
            'nombre',
            'apto',
            'no_apto',
        ];

        $data = RegistroProceso::join("datos_basicos", "datos_basicos.user_id", "=", "procesos_candidato_req.candidato_id")
            ->join("requerimiento_cantidato",  "requerimiento_cantidato.id",  "=",  "procesos_candidato_req.requerimiento_candidato_id")
            ->where("procesos_candidato_req.requerimiento_id", $req_id)
            ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
            ->whereNotIn('requerimiento_cantidato.estado_candidato', [
                config('conf_aplicacion.C_QUITAR'),
                config('conf_aplicacion.C_INACTIVO')
            ])
            ->where('procesos_candidato_req.proceso', 'ENVIO_APROBAR_CLIENTE')
            ->whereNull('procesos_candidato_req.apto')
            ->select(
                "requerimiento_cantidato.candidato_id as candidato_id",
                "requerimiento_cantidato.requerimiento_id as req_id",
                "datos_basicos.*",
                "datos_basicos.id as datos_basicos_id",
                "requerimiento_cantidato.id as req_candidato_id",
                "requerimiento_cantidato.id"
            )
            ->orderBy("datos_basicos.numero_id")
            ->groupBy('procesos_candidato_req.candidato_id')
        ->get();

        Excel::create("candidatos-aprobar-cliente-$req_id", function ($excel) use ($data, $headers) {
            $excel->setTitle('Candidatos Aprobar al Req');
            $excel->setCreator("$nombre")
                ->setCompany("$nombre");
            $excel->setDescription('Candidatos Aprobar al Requerimiento');
            $excel->sheet('Candidatos Aprobar al Req', function ($sheet) use ($data, $headers) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reclutamiento.includes.grilla_candidatos_aprobar_masivo_excel', [
                    'data'    => $data,
                    'headers' => $headers
                ]);
            });
        })->export('xlsx');
    }

    public function confirmar_entrevista_virtual_masivo(Request $data)
    {
        $req_can_id =   json_decode($data->req_can_id);
        $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_ENTREVISTA_VIRTUAL", $req_can_id);

        if ($valida_proceso["success"]) {
            return response()->json(["success" => false, "view" => $valida_proceso["view"]]);
        }

        $req_id = $data->req_id;

        $cliente = Clientes::where('clientes.id', $data->cliente_id)->first();

        $userEnvio = DatosBasicos::where('user_id', $this->user->id)->first();

        $usuario = $userEnvio->nombres." ".$userEnvio->primer_apellido;

        $candidatesNumber = [];

        foreach ($req_can_id as $key => $value) {
            $campos                 = [
                'requerimiento_candidato_id' => $value,
                'usuario_envio'              => $this->user->id,
                "fecha_inicio"               => date("Y-m-d H:i:s"),
                'proceso'                    => "ENVIO_ENTREVISTA_VIRTUAL",
            ];

            $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $value);
            $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();

            $datos_basicos = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $value)
            ->select("datos_basicos.user_id","datos_basicos.email","datos_basicos.telefono_movil","requerimiento_cantidato.id","datos_basicos.nombres","datos_basicos.primer_apellido")
            ->first();

            $user_id = $datos_basicos->user_id; //Id de candidato
            array_push($candidatesNumber, "57" . $datos_basicos->telefono_movil);
            $destino = "57" . $datos_basicos->telefono_movil; //número movil de candidato

            $funcionesGlobales = new FuncionesGlobales();

            if (isset($funcionesGlobales->sitio()->nombre)) {
                if ($funcionesGlobales->sitio()->nombre != "") {
                    $nombre = $funcionesGlobales->sitio()->nombre;
                } else {
                    $nombre = "Desarrollo";
                }
            }

            $urls = route('home.video_entrevista_virtual',['user_id'=>$user_id,'req_id'=>$req_id]);

            $url = str_replace("http://", "https://", $urls);

            $nombre_cliente = $cliente->nombre; 
            $nombres = $datos_basicos->nombres;
            $asunto = "Invitación a video entrevista de oferta de empleo $nombre_cliente";
            $emails = $datos_basicos->email;

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Video Entrevista Virtual"; //Titulo o tema del correo
        
            //Cuerpo con html y comillas dobles para las variables
            $mailBody = "Bienvenid@ ".$nombres.", en ".$nombre_cliente." estamos felices de que participes en nuestros procesos de selección, hemos revisado tu perfil y nos gustaría conocerte un poco más. Te invitamos a que realices la siguiente video entrevista la cual presentarás a través de la grabación de 3 videos respondiendo a las preguntas que el analista de selección ha preparado para ti. 
                <br/><br/>
                A continuación te daremos unos tips que te ayudarán a tener un mejor desempeño en la video entrevista.

                <ol>
                    <li>
                    Prepara el espacio a tu alrededor, recomendable que no tengas elementos que distraigan al entrevistador. 
                    </li>

                    <li>
                    Minimiza posibles interrupciones, pon tu celular en silencio y evita elementos que puedan distraerte.
                    </li>
                    <li>
                        Comprueba la funcionalidad de tu equipo y los permisos de acceso a tu cámara y micrófono.
                    </li>
                    <li> 
                        Mira a la cámara, como si se tratara de tu interlocutor. Así mostrarás seguridad en ti mismo.
                    </li>
                         
                    <li>
                        Sé tu mismo y actúa con naturalidad. 
                    </li>
                </ol>
                        ";

            //Arreglo para el botón
            $mailButton = ['buttonText' => 'REALIZAR VIDEO ENTREVISTA', 'buttonRoute' => $url];

            $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

            //$mailAditionalTemplate = ['nameTemplate' => 'video_entrevista', 'dataTemplate' => []];

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);
        

            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($data, $emails, $asunto) {
                $message->to($emails, "$nombre - T3RS")
                ->subject($asunto)
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    
             });

            //Envio de mensaje
            /*$urlapi = 'https://go4clients.com/TelintelSms/api/sms/send';

            $url_oferta = Bitly::getUrl($url);

            $data = array(
                'to'      => $destino,
                'message' => "Buen dia " . $nombres . ",  soy ". $usuario ." de ".$nombre.", " . $url_oferta ,
            );

            $options = array(
                'http' => array(
                    'method'  => 'POST',
                    'content' => json_encode($data),
                    'header'  => array("Host: go4clients.com", "Content-Type: application/json", "Apikey: ca16b4d3626346f39c5fd33f69cb46dc", "Apisecret: 25184841718344"),
                ),
            );

            $lol      = json_encode($data);
            $context  = stream_context_create($options);
            $result   = file_get_contents($urlapi, false, $context);
            $response = json_decode($result);*/
        }

        //Envio de llamada
        /*$url_audio            = route('home') . "/llamada_virtual/audio.wav";
        $quitar_seguridad_url = str_replace("https://", "http://", $url_audio);
        $urlapicall = 'https://go4clients.com:8443/TelintelSms/api/voice/outcall';
        $mensaje = "Prueba";

        $data = array(
            "from"      => "573016626961",
            "toList"    => $candidatesNumber,
            "callSteps" => array(
                [
                    "type"       => "PLAY",
                    "sourceType" => "URL",
                    "source"     => $quitar_seguridad_url,
                ],
                [
                    "type"    => "DETECT",
                    "options" => array(
                        [
                            "type"        => "OPTION",
                            "dtfmCommand" => "1",
                            "optionId"    => "aceptacion",
                            "steps"       => array(
                                [
                                    "type"         => "SAY",
                                    "text"         => "<Speed=80/> hola. " . $mensaje . " enviaremos la información de la vacante a través de un mensaje de texto. Gracias!  <Speed=END_80/><Speed=80/> hola. " . $mensaje . " enviaremos la información de la vacante a través de un mensaje de texto. Gracias!  <Speed=END_80/>",
                                    "convertVoice" => "CLAUDIA",
                                    "sourceType"   => "STANDARD",
                                ],
                                [
                                    "destination" => "1",
                                    "type"        => "DIAL",
                                ],
                            ),
                        ],

                        [
                            "type"        => "OPTION",
                            "dtfmCommand" => "2",
                            "optionId"    => "rechazo",
                            "steps"       => array(
                                [
                                    "type"         => "SAY",
                                    "text"         => "Muchas gracias por haber atendido nuestra llamada, que pase un buen dia.",
                                    "convertVoice" => "CLAUDIA",
                                    "sourceType"   => "STANDARD",
                                ],
                                [
                                    "destination" => "1",
                                    "type"        => "DIAL",
                                ],
                            ),
                        ],
                    ),
                ],
            ),
        );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data),
                'header'  => array("Host: go4clients.com", "Content-Type: application/json", "Apikey: ca16b4d3626346f39c5fd33f69cb46dc", "Apisecret: 25184841718344"),
            ),
        );

        $context  = stream_context_create($options);
        $result   = file_get_contents($urlapicall, false, $context, 0, 40000);
        $response = json_decode($result);*/
        
        return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $value]);
    }

    public function confirmar_prueba_idioma_masivo(Request $data)
    {
        $req_can_id =   json_decode($data->req_can_id);
        $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_PRUEBA_IDIOMA", $req_can_id);

        if ($valida_proceso["success"]) {
            return response()->json(["success" => false, "view" => $valida_proceso["view"]]);
        }

        $req_id = $data->req_id;

        $cliente = Clientes::where('clientes.id', $data->cliente_id)->first();

        $userEnvio = DatosBasicos::where('user_id', $this->user->id)->first();

        $usuario = $userEnvio->nombres." ".$userEnvio->primer_apellido;

        $candidatesNumber = [];

        foreach ($req_can_id as $key => $value) {
            $campos                 = [
                'requerimiento_candidato_id' => $value,
                'usuario_envio'              => $this->user->id,
                "fecha_inicio"               => date("Y-m-d H:i:s"),
                'proceso'                    => "ENVIO_PRUEBA_IDIOMA",
            ];

            $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $value);
            $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();


            $datos_basicos = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->where("requerimiento_cantidato.id", $value)
                ->select("datos_basicos.user_id","datos_basicos.email","datos_basicos.telefono_movil","requerimiento_cantidato.id","datos_basicos.nombres","datos_basicos.primer_apellido")
                ->first();

            $user_id = $datos_basicos->user_id; //Id de candidato
            array_push($candidatesNumber, "57" . $datos_basicos->telefono_movil);
            $destino = "57" . $datos_basicos->telefono_movil; //número movil de candidato

            $sitio = Sitio::first();

            if ( isset($sitio->nombre) ) {
                if ($sitio->nombre != "") {
                    $nombre = $sitio->nombre;
                } else {
                    $nombre = "Desarrollo";
                }
            }

            $urls = route('home.prueba-idioma-virtual',['user_id'=>$user_id,'req_id'=>$req_id]);
            $url = str_replace("http://", "https://", $urls);

            $nombre_cliente = $cliente->nombre; 
            $nombres = $datos_basicos->nombres;

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Video Prueba Idioma"; //Titulo o tema del correo

            $asunto = "Invitación a prueba de idioma de oferta de empleo $nombre_cliente";

            $emails = $datos_basicos->email;

            //Cuerpo con html y comillas dobles para las variables
            $mailBody = "
                    Bienvenid@ ".$nombres.", en ".$nombre." estamos felices de que participes en nuestros procesos de selección, hemos revisado tu perfil y nos gustaría conocerte un poco más. Te invitamos a que realices la siguiente prueba de idioma la cual presentarás a través de la grabación de 3 videos respondiendo a las preguntas que el analista de selección ha preparado para ti. 
                    <br/><br/>
                    A continuación te daremos unos tips que te ayudarán a tener un mejor desempeño en la prueba de idioma.
                    <br/><br/>

                    <ol>
                        <li>
                            Prepara el espacio a tu alrededor, recomendable que no tengas elementos que distraigan al entrevistador. 
                        </li>

                        <li>
                            Minimiza posibles interrupciones, pon tu celular en silencio y evita elementos que puedan distraerte.
                        </li>

                        <li>
                            Comprueba la funcionalidad de tu equipo y los permisos de acceso a tu cámara y micrófono.
                        </li>

                        <li> 
                            Mira a la cámara, como si se tratara de tu interlocutor. Así mostrarás seguridad en ti mismo.
                        </li>
                                 
                        <li>
                            Sé tu mismo y actúa con naturalidad. 
                        </li>
                    </ol>";

            //Arreglo para el botón
            $mailButton = ['buttonText' => 'REALIZAR PRUEBA IDIOMA', 'buttonRoute' => $url];

            $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

            //$mailAditionalTemplate = ['nameTemplate' => 'prueba_idioma', 'dataTemplate' => []];

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            //Envio de email
            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $asunto, $nombre, $sitio) {

                    $message->to($datos_basicos->email, $datos_basicos->nombres)
                            ->bcc($sitio->email_replica)
                            ->subject($asunto)
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
            /*Mail::send('home.email-prueba-idioma-virtual', ["url"=>$url,"mensaje" => $mensaje], function($message) use ($data, $emails, $asunto) {
                $message->to($emails, '$nombre - T3RS')->subject($asunto);
            });*/

            //Envio de mensaje
            /*$urlapi = 'https://go4clients.com/TelintelSms/api/sms/send';

            $url_oferta = Bitly::getUrl($url);

            $data = array(
                'to'      => $destino,
                'message' => "Buen dia " . $nombres . ",  soy ". $usuario ." de ".$nombre.", " . $url_oferta ,
            );

            $options = array(
                'http' => array(
                    'method'  => 'POST',
                    'content' => json_encode($data),
                    'header'  => array("Host: go4clients.com", "Content-Type: application/json", "Apikey: ca16b4d3626346f39c5fd33f69cb46dc", "Apisecret: 25184841718344"),
                ),
            );

            $lol      = json_encode($data);
            $context  = stream_context_create($options);
            $result   = file_get_contents($urlapi, false, $context);
            $response = json_decode($result);*/
        }

        //Envio de llamada
        /*$url_audio            = route('home') . "/llamada_virtual/audio.wav";
        $quitar_seguridad_url = str_replace("https://", "http://", $url_audio);
        $urlapicall = 'https://go4clients.com:8443/TelintelSms/api/voice/outcall';
        $mensaje = "Prueba";

        $data = array(
            "from"      => "573016626961",
            "toList"    => $candidatesNumber,
            "callSteps" => array(
                [
                    "type"       => "PLAY",
                    "sourceType" => "URL",
                    "source"     => $quitar_seguridad_url,
                ],
                [
                    "type"    => "DETECT",
                    "options" => array(
                        [
                            "type"        => "OPTION",
                            "dtfmCommand" => "1",
                            "optionId"    => "aceptacion",
                            "steps"       => array(
                                [
                                    "type"         => "SAY",
                                    "text"         => "<Speed=80/> hola. " . $mensaje . " enviaremos la información de la vacante a través de un mensaje de texto. Gracias!  <Speed=END_80/><Speed=80/> hola. " . $mensaje . " enviaremos la información de la vacante a través de un mensaje de texto. Gracias!  <Speed=END_80/>",
                                    "convertVoice" => "CLAUDIA",
                                    "sourceType"   => "STANDARD",
                                ],
                                [
                                    "destination" => "1",
                                    "type"        => "DIAL",
                                ],
                            ),
                        ],

                        [
                            "type"        => "OPTION",
                            "dtfmCommand" => "2",
                            "optionId"    => "rechazo",
                            "steps"       => array(
                                [
                                    "type"         => "SAY",
                                    "text"         => "Muchas gracias por haber atendido nuestra llamada, que pase un buen dia.",
                                    "convertVoice" => "CLAUDIA",
                                    "sourceType"   => "STANDARD",
                                ],
                                [
                                    "destination" => "1",
                                    "type"        => "DIAL",
                                ],
                            ),
                        ],
                    ),
                ],
            ),
        );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data),
                'header'  => array("Host: go4clients.com", "Content-Type: application/json", "Apikey: ca16b4d3626346f39c5fd33f69cb46dc", "Apisecret: 25184841718344"),
            ),
        );

        $context  = stream_context_create($options);
        $result   = file_get_contents($urlapicall, false, $context, 0, 40000);
        $response = json_decode($result);*/
        
        return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $value]);
    }

    public function confirmar_asistencia_masivo(Request $data)
    {
        $req_id = $data->req_id;
        $req_can_id =   json_decode($data->req_can_id);
        
        $valida_proceso = $this->validaAsistenciaCandidato($req_id,$req_can_id);

        if ($valida_proceso["success"]) {
            return response()->json(["success" => false, "view" => $valida_proceso["view"]]);
        }
          
        $id_null = [];
        $nombres = [];
        
        foreach ($req_can_id as $key => $value) {
            $entrevista = EntrevistaCandidatos::join('users', 'users.id', '=', 'entrevistas_candidatos.candidato_id')
            ->join('requerimiento_cantidato', 'requerimiento_cantidato.candidato_id', '=', 'users.id')
            ->where("entrevistas_candidatos.req_id", $req_id)
            ->where('requerimiento_cantidato.id', $value)
            ->select('entrevistas_candidatos.id as entre_id', 'entrevistas_candidatos.candidato_id as candidato_id')
            ->groupBy('entrevistas_candidatos.candidato_id')
            ->first();

            if (count($entrevista) === 0) {
                array_push($id_null, $value);
            }else{
                $ae = EntrevistaCandidatos::find($entrevista->entre_id);
                $ae->fill(['asistio' => 1]);
                $ae->save();
            }
        }
        
        foreach ($id_null as $key => $value) {
            $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $value)
            ->select("requerimiento_cantidato.id","datos_basicos.nombres","datos_basicos.primer_apellido")
            ->first();
            
            if ($candidato!= null) { 
                array_push($nombres,$candidato->nombres);
            }
        }

        if (count($nombres) > 0) {
            return array("error"=>true,"view"=>view("admin.reclutamiento.modal.sin_entrevista",  compact("","nombres"))->render());
        }

        /* if (count($entrevista) === 0) {
            $mensaje = "No se le ha hecho la entrevista al candidato.";
            return response()->json(["error" => true, "candidato" => $entrevista_no]);
        }*/
        
        $ae = EntrevistaCandidatos::find($entrevista->entre_id);
        $ae->fill(['asistio' => 1]);
        $ae->save();

        $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();
        
        return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $value]);
    }

    //Validación documental
    public function confirmar_documento_masivo(Request $data)
    {
        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){

            $req_can_id =   json_decode($data->req_can_id);
            $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_DOCUMENTOS", $req_can_id);
            
            if ($valida_proceso["success"]) {
                return response()->json(["success" => false, "view" => $valida_proceso["view"]]);
            }

            foreach ($req_can_id as $key => $value) {

                $campos = [
                    'requerimiento_candidato_id' => $value,
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    'proceso'                    => "ENVIO_DOCUMENTOS",
                ];

                $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $value);

                $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();
            }
            
            return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $value]);

        }else{

            $datos_basicos =[];
            $req_can_id = [];

           $requerimiento_candidato=ReqCandidato::find($data->req_candidato[0]);
            if(isset($data->seleccionar_todos_candidatos_vinculados)){
           
                $candidatos = DB::table("requerimiento_cantidato")
                    ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                    ->select('datos_basicos.*',"requerimiento_cantidato.id as req_candidato")
                    ->where("requerimiento_cantidato.requerimiento_id",$requerimiento_candidato->requerimiento_id)
                    ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
                    ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
                    ->get();

                foreach($candidatos as $candidato){
                      array_push($datos_basicos, $candidato->nombres);
                    array_push($req_can_id, $candidato->req_candidato);
                }

           
             }
             else{
        //ACA VA EL FOREACH NORMAL
                 foreach ($data->req_candidato as $key => $req_candi_id) {
                    
                        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                        ->where("requerimiento_cantidato.id", $req_candi_id)
                        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
                        ->first();
                        
                        array_push($datos_basicos, $candidato->nombres);
                        array_push($req_can_id, $candidato->req_candidato);

                    }

            }
            
            $req_can_id_j = json_encode($req_can_id);
            $req_can_id =   json_decode($req_can_id_j);

            $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_DOCUMENTOS", $req_can_id);
            
            if ($valida_proceso["success"]) {
                return response()->json(["success" => false, "view" => $valida_proceso["view"]]);
            }

            foreach ($req_can_id as $key => $value) {

                $campos = [
                    'requerimiento_candidato_id' => $value,
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    'proceso'                    => "ENVIO_DOCUMENTOS",
                ];

                $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $value);

                $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();
            }
            
            return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $value]);

        }
    }

    public function confirmar_aprobar_cliente_masivo(Request $data)
    {
        $req_can_id = json_decode($data->req_can_id);
        $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_APROBAR_CLIENTE", $req_can_id);

        if ($valida_proceso["success"]) {
            return response()->json(["success" => false, "view" => $valida_proceso["view"]]);
        }

        $observacion= (!$data->observaciones) ? '' : $data->observaciones;

        //validamos los correos registrados para otros destinatarios
        $destinatarios = "";
        if( $data->has('otros_destinatarios') && $data->otros_destinatarios != '' ){
            
            $destinatarios = explode(",", $data->otros_destinatarios);

            foreach($destinatarios as $destinatario){
                $validador = Validator::make(["destinatario" => $destinatario], [
                    "destinatario"   => "email"
                ]);

                if ($validador->fails()) {
                    break;
                }
            }

            if ($validador->fails()) {
                return response()->json([
                    "success" => false,
                    "mensaje" => "Por favor ingrese correos correctos en otros destinatarios."
                ]);
            }

        }

        foreach ($req_can_id as $key => $value) {
            $campos = [
                'requerimiento_candidato_id' => $value,
                'usuario_envio'              => $this->user->id,
                "fecha_inicio"               => date("Y-m-d H:i:s"),
                'proceso'                    => "ENVIO_APROBAR_CLIENTE",
                'observaciones'              => $observacion
            ];

            $this->RegistroProceso($campos, config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), $value);

            $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();
        }

        $req_id = $data->req_id;
        $requerimiento = Requerimiento::join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
        ->select('requerimientos.*', 'cargos_especificos.descripcion as cargo_especifico')
        ->find($req_id);

        $user_envio = User::find($requerimiento->solicitado_por);

        if ($data->usuario_cliente!="") {
            $usuarios=[$user_envio->email,$data->usuario_cliente];
        }else{
            $usuarios = [$user_envio->email];
        }

        if(is_array($destinatarios)){
            $usuarios = array_merge($usuarios,$destinatarios);
        }

        if (route("home") == "https://gpc.t3rsc.co") {
            $asunto = "Solicitud Aprobación de Candidatos - GPC";
        } else {
            $asunto = "Solicitud Aprobación de candidatos REQ #$requerimiento->id";
        }

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Aprobación de candidatos"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "Hola {$user_envio->name}, te informamos que el analista de selección que está llevando a cabo el proceso en el requerimiento No. {$requerimiento->id} para el cargo {$requerimiento->cargo_especifico} te ha enviado candidatos para aprobación. Por favor ingresa por el siguiente botón para realizar la gestión.";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'Ir a gestionar', 'buttonRoute' => route('req.mis_requerimiento')];

        $mailUser = $candidato->id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($usuarios, $asunto) {

            $message->to($usuarios, "T3RS")
                ->subject($asunto)
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        $guardar_emails_enviados = new EmailAprobarCliente();

        $guardar_emails_enviados->fill([
            'requerimiento_id'              => $requerimiento->id,
            'quien_envia'                   => $this->user->id,
            'email_solicito_req'            => $user_envio->email,
            'email_cliente'                 => ( ($data->usuario_cliente!="") ? $data->usuario_cliente : null),
            'otros_emails'                  => (is_array($destinatarios) ? implode(",", $destinatarios) : null),
            'registro_masivo'               => 1

        ]);

        $guardar_emails_enviados->save();

        return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $value]);
    }

    public function confirmar_pruebas_masivo(Request $data)
    {
        $pruebas_seleccionadas = $data->pruebas;
        $pruebas = [];
        $candi_no_enviados = [];

        foreach ($pruebas_seleccionadas as $prueba) {
            switch ($prueba) {
                case '1':
                    $pruebas[] = 'ENVIO_PRUEBAS';
                    break;
                case '2':
                    $pruebas[] = 'ENVIO_PRUEBA_BRYG';
                    break;
                case '3':
                    $pruebas[] = 'ENVIO_EXCEL_BASICO';
                    break;
                case '4':
                    $pruebas[] = 'ENVIO_EXCEL_INTERMEDIO';
                    break;
                case '5':
                    $pruebas[] = 'ENVIO_PRUEBA_COMPETENCIA';
                    break;
                case '6':
                    $pruebas[] = 'ENVIO_PRUEBA_ETHICAL_VALUES';
                    break;
                case '7':
                    $pruebas[] = 'ENVIO_PRUEBA_DIGITACION';
                    break;
            }
        }

        $datos_basicos =[];
        $req_can_id = [];
        $candi_no_enviados = collect([]);
        $sitio = Sitio::first();

        $req_can_ids = json_decode($data->req_can_id);

        foreach ($req_can_ids as $req_can_id) {
            $datos_candidato = ReqCandidato::join('datos_basicos', 'datos_basicos.user_id', '=', 'requerimiento_cantidato.candidato_id')
            ->where('requerimiento_cantidato.id', $req_can_id)
            ->select(
                'requerimiento_cantidato.requerimiento_id as req_id',
                'datos_basicos.email as email',
                'datos_basicos.user_id as user_id',
                'datos_basicos.nombres',
                'datos_basicos.primer_apellido',
                'datos_basicos.segundo_apellido'
            )
            ->first();

            $datos_candidato->nombre_completo = "$datos_candidato->nombres $datos_candidato->primer_apellido $datos_candidato->segundo_apellido";

            $procesos_candidato = RegistroProceso::where('requerimiento_candidato_id', $req_can_id)
                ->whereIn('proceso', $pruebas)
            ->get();
            $procesos_ya_enviados = [];

            foreach ($pruebas as $proceso) {
                $busqueda = $procesos_candidato->where('proceso', $proceso)->first();

                if ($busqueda != null) {
                    //$procesos_ya_enviados[] = $proceso;
                    switch ($proceso) {
                        case 'ENVIO_PRUEBAS':
                            $procesos_ya_enviados[] = 'EXTERNA';
                            break;
                        case 'ENVIO_PRUEBA_BRYG':
                            $procesos_ya_enviados[] = 'BRYG-A';
                            break;
                        case 'ENVIO_EXCEL_BASICO':
                            $procesos_ya_enviados[] = 'EXCEL BASICO';
                            break;
                        case 'ENVIO_EXCEL_INTERMEDIO':
                            $procesos_ya_enviados[] = 'EXCEL INTERMEDIO';
                            break;
                        case 'ENVIO_PRUEBA_COMPETENCIA':
                            $procesos_ya_enviados[] = 'PERSONAL SKILLS';
                            break;
                        case 'ENVIO_PRUEBA_ETHICAL_VALUES':
                            $procesos_ya_enviados[] = 'ETHICAL VALUES';
                            break;
                        case 'ENVIO_PRUEBA_DIGITACION':
                            $procesos_ya_enviados[] = 'DIGITACION';
                            break;
                    }
                } else {
                    $campos = [
                        'requerimiento_candidato_id' => $req_can_id,
                        'usuario_envio'              => $this->user->id,
                        'fecha_inicio'               => date("Y-m-d H:i:s"),
                        'proceso'                    => "$proceso"
                    ];
                    switch ($proceso) {
                        case 'ENVIO_PRUEBAS':
                            # code...
                            break;

                        case 'ENVIO_PRUEBA_BRYG':
                            $titulo  = "Prueba BRYG-A";
                            $ruta    = route('cv.prueba_inicio');

                            //Crea registro para guardar los resultados
                            $result_test = new PruebaBrigResultado();
                            $result_test->fill([
                                'req_id'         => $datos_candidato->req_id,
                                'user_id'        => $datos_candidato->user_id,
                                'gestion_id'     => $this->user->id
                            ]);
                            $result_test->save();
                            break;

                        case 'ENVIO_EXCEL_BASICO':
                            $titulo  = "Prueba Excel Básico";
                            $ruta    = route('cv.prueba_excel_basico', ['req_id' => $datos_candidato->req_id]);
                            break;

                        case 'ENVIO_EXCEL_INTERMEDIO':
                            $titulo  = "Prueba Excel Intermedio";
                            $ruta    = route('cv.prueba_excel_intermedio', ['req_id' => $datos_candidato->req_id]);
                            break;

                        case 'ENVIO_PRUEBA_COMPETENCIA':
                            $titulo  = "Prueba Personal Skills";
                            $ruta    = route('cv.competencias_inicio');

                            //Crea registro para guardar los resultados
                            $result_test = new PruebaCompetenciaResultado();
                            $result_test->fill([
                                'req_id'         => $datos_candidato->req_id,
                                'user_id'        => $datos_candidato->user_id,
                                'gestion_id'     => $this->user->id
                            ]);
                            $result_test->save();
                            break;

                        case 'ENVIO_PRUEBA_ETHICAL_VALUES':
                            $titulo  = "Prueba Ethical Values";
                            $ruta    = route('cv.prueba_valores_1', ['req_id' => $datos_candidato->req_id]);
                            break;

                        case 'ENVIO_PRUEBA_DIGITACION':
                            $titulo  = "Prueba Digitación";
                            $ruta    = route('cv.digitacion_inicio');

                            //Crea registro para guardar los resultados
                            $result_test = new PruebaDigitacionResultado();
                            $result_test->fill([
                                'req_id'         => $datos_candidato->req_id,
                                'user_id'        => $datos_candidato->user_id,
                                'gestion_id'     => $this->user->id
                            ]);
                            $result_test->save();
                            break;
                    }
                    $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $req_can_id);

                    if ($proceso != 'ENVIO_PRUEBAS') {
                        /**
                         * Usar administrador de correos
                        */
                        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                        $mailConfiguration = 1; //Id de la configuración
                        $mailTitle = "$titulo"; //Titulo o tema del correo

                        //Cuerpo con html y comillas dobles para las variables
                        $mailBody = "
                            Hola $datos_candidato->nombre_completo, has sido enviado/a en tu proceso de selección a realizar nuestra $titulo. <br>
                            Por favor haz clic en botón <b>Realizar prueba</b> y sigue las instrucciones que te brindará la plataforma. <br><br>
                            <i>¡Muchos éxitos!</i>
                        ";

                        //Arreglo para el botón
                        $mailButton = ['buttonText' => 'Realizar prueba', 'buttonRoute' => $ruta];

                        $mailUser = $datos_candidato->user_id; //Id del usuario al que se le envía el correo

                        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                        //Enviar correo generado
                        Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($datos_candidato, $sitio, $titulo) {
                            $message->to([$datos_candidato->email], 'T3RS')
                            ->bcc($sitio->email_replica)
                            ->subject("$titulo")
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                        });
                        /**
                         * Fin administrador correos
                        */
                    }
                }
            }

            if (count($procesos_ya_enviados) > 0) {
                $datos_candidato->observaciones = implode(", ", $procesos_ya_enviados);
                $candi_no_enviados->push($datos_candidato);
            }
        }

        return response()->json(["success" => true, "candi_no_enviados" => $candi_no_enviados]);
    }

    // Confirma entrevista masivo
    public function confirmar_entrevista_masivo(Request $data)
    {
        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){

            $req_can_id =   json_decode($data->req_can_id);

            if(isset($data->tipo_entrevista)){

                if($data->tipo_entrevista == 0){

                    $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_ENTREVISTA", $req_can_id);

                }
                else{

                    $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_ENTREVISTA_TECNICA", $req_can_id);

                }

            }
            else{

                $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_ENTREVISTA", $req_can_id);

            }
                      
            if ($valida_proceso["success"]) {

                return response()->json(["success" => false, "view" => $valida_proceso["view"]]);

            }

            foreach ($req_can_id as $key => $value) {
             
                $proceso="ENVIO_ENTREVISTA";
                
                if(isset($data->tipo_entrevista)){
                    if($data->tipo_entrevista == 1){
                        $proceso = "ENVIO_ENTREVISTA_TECNICA";
                    }
                }
            
                $campos = [
                    'requerimiento_candidato_id' => $value,
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    'proceso'                    => $proceso,
                ];
            
                $req_candidato = $value;

                $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $value);

                $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();

            }

            if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){

                $req_can=ReqCandidato::find($req_candidato);

                $requerimiento=Requerimiento::find($req_can->requerimiento_id);

                $candidato=User::find($req_can->candidato_id);

                $user_envio=User::find($requerimiento->solicitud->user_id);

                $proceso_candidato=RegistroProceso::where('requerimiento_candidato_id',$req_can->id)
                        ->where('requerimiento_id',$requerimiento->id)
                        ->where('candidato_id',$candidato->id)
                        ->first();

                if($proceso == "ENVIO_ENTREVISTA_TECNICA"){

                    Mail::send('admin.email_envio_entrevista', [
                        'candidato'      => $candidato,
                        'req'      => $requerimiento,
                        'id_ent'   => $proceso_candidato->id
                        
                    ], function ($message) use ($user_envio, $requerimiento){

                      $message->to([$user_envio->email,'javier.chiquito@t3rsc.co'], "T3RS")->subject("Entrevista Req # $requerimiento->id")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                
                }
                //si cruex envia a entrevista rrhh  que le llegue la notificacion a danny
                if(($proceso == "ENVIO_ENTREVISTA") && ($user_envio->id == 33758)){

                    Mail::send('admin.email_envio_entrevista', [
                        'candidato'      => $candidato,
                        'req'      => $requerimiento,
                        'id_ent'   => $proceso_candidato->id
                        
                    ], function ($message) use ($user_envio, $requerimiento) {

                      $message->to(['danny.miranda@komatsu.com.co','javier.chiquito@t3rsc.co'], "T3RS")
                            ->subject("Entrevista Req # $requerimiento->id")
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });

                }//fin de si es entrevista enviar a danny

            }
            
            return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $value]);

        }else{

            $datos_basicos = [];
            $req_can_id = [];
            $requerimiento_candidato=ReqCandidato::find($data->req_candidato[0]);
            if(isset($data->seleccionar_todos_candidatos_vinculados)){
           
                $candidatos = DB::table("requerimiento_cantidato")
                    ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                    ->select('datos_basicos.*',"requerimiento_cantidato.id as req_candidato")
                    ->where("requerimiento_cantidato.requerimiento_id",$requerimiento_candidato->requerimiento_id)
                    ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
                    ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
                    ->get();

                foreach($candidatos as $candidato){
                      array_push($datos_basicos, $candidato->nombres);
                    array_push($req_can_id, $candidato->req_candidato);
                }

           
             }
             else{
               
                 foreach ($data->req_candidato as $key => $req_candi_id) {
                    
                        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                        ->where("requerimiento_cantidato.id", $req_candi_id)
                        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
                        ->first();
                        
                        array_push($datos_basicos, $candidato->nombres);
                        array_push($req_can_id, $candidato->req_candidato);

                    }

            }
            
            $req_can_id_j = json_encode($req_can_id);
            $req_can_id =   json_decode($req_can_id_j);

            if(isset($data->tipo_entrevista)){

                if($data->tipo_entrevista == 0){

                    $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_ENTREVISTA", $req_can_id);

                }
                else{

                    $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_ENTREVISTA_TECNICA", $req_can_id);

                }

            }
            else{

                $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_ENTREVISTA", $req_can_id);

            }
                      
            if ($valida_proceso["success"]) {

                return response()->json(["success" => false, "view" => $valida_proceso["view"]]);

            }

            foreach ($req_can_id as $key => $value) {
             
                $proceso="ENVIO_ENTREVISTA";
                
                if(isset($data->tipo_entrevista)){
                    if($data->tipo_entrevista == 1){
                        $proceso = "ENVIO_ENTREVISTA_TECNICA";
                    }
                }
            
                $campos = [
                    'requerimiento_candidato_id' => $value,
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    'proceso'                    => $proceso,
                ];
            
                $req_candidato = $value;

                $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $value);

                $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();

            }

            if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){

                if($proceso == "ENVIO_ENTREVISTA_TECNICA"){

                    $req_can=ReqCandidato::find($req_candidato);

                    $requerimiento=Requerimiento::find($req_can->requerimiento_id);

                    $candidato=User::find($req_can->candidato_id);

                    $user_envio=User::find($requerimiento->solicitud->user_id);

                    Mail::send('admin.email_envio_entrevista', [
                        'candidato'      => $candidato,
                        'req'      => $requerimiento
                        
                    ], function ($message) use ($user_envio, $requerimiento) {
                        $message->to([$user_envio->email,'javier.chiquito@t3rsc.co'], "T3RS")
                        ->subject("Entrevista Req # $requerimiento->id")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                
                }

            }
            
            return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $value]);
        
        }

    }

    // Confirmar Referenciación masivos
    public function confirmar_referenciacion_masivo(Request $data)
    {
        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){

           $req_can_id =   json_decode($data->req_can_id);
           $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_REFERENCIACION", $req_can_id);

            if($valida_proceso["success"]) {
             return response()->json(["success" => false, "view" => $valida_proceso["view"]]);
            }

            foreach($req_can_id as $key => $value) {
                $campos = [
                  'requerimiento_candidato_id' => $value,
                  'usuario_envio'              => $this->user->id,
                  "fecha_inicio"               => date("Y-m-d H:i:s"),
                  'proceso'                    => "ENVIO_REFERENCIACION",
                ];

                $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $value);
                $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();
            }
            
            return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $value]);

        }
        else{

            $datos_basicos =[];
            $req_can_id = [];
             $requerimiento_candidato=ReqCandidato::find($data->req_candidato[0]);
            if(isset($data->seleccionar_todos_candidatos_vinculados)){
           
                $candidatos = DB::table("requerimiento_cantidato")
                    ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                    ->select('datos_basicos.*',"requerimiento_cantidato.id as req_candidato")
                    ->where("requerimiento_cantidato.requerimiento_id",$requerimiento_candidato->requerimiento_id)
                    ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
                    ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
                    ->get();

                foreach($candidatos as $candidato){
                      array_push($datos_basicos, $candidato->nombres);
                    array_push($req_can_id, $candidato->req_candidato);
                }

           
             }
             else{
        //ACA VA EL FOREACH NORMAL
                 foreach ($data->req_candidato as $key => $req_candi_id) {
                    
                        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                        ->where("requerimiento_cantidato.id", $req_candi_id)
                        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
                        ->first();
                        
                        array_push($datos_basicos, $candidato->nombres);
                        array_push($req_can_id, $candidato->req_candidato);

                    }

            }

            $req_can_id_j = json_encode($req_can_id);
            $req_can_id =   json_decode($req_can_id_j);

            $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_REFERENCIACION", $req_can_id);

            if ($valida_proceso["success"]) {
                return response()->json(["success" => false, "view" => $valida_proceso["view"]]);
            }

            foreach ($req_can_id as $key => $value) {

                $campos = [
                    'requerimiento_candidato_id' => $value,
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    'proceso'                    => "ENVIO_REFERENCIACION",
                ];

                $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $value);
                $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();

            }
            
            return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $value]);
        
        }
    }

    // Confirmar Referencia estudios masivos
    public function confirmar_referencia_estudios_masivo(Request $data)
    {
            $datos_basicos =[];
            $req_can_id = [];
             $requerimiento_candidato=ReqCandidato::find($data->req_candidato[0]);
            if(isset($data->seleccionar_todos_candidatos_vinculados)){
           
                $candidatos = DB::table("requerimiento_cantidato")
                    ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                    ->select('datos_basicos.*',"requerimiento_cantidato.id as req_candidato")
                    ->where("requerimiento_cantidato.requerimiento_id",$requerimiento_candidato->requerimiento_id)
                    ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
                    ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
                    ->get();

                foreach($candidatos as $candidato){
                      array_push($datos_basicos, $candidato->nombres);
                    array_push($req_can_id, $candidato->req_candidato);
                }

           
             }
             else{
        //ACA VA EL FOREACH NORMAL
                 foreach ($data->req_candidato as $key => $req_candi_id) {
                    
                        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                        ->where("requerimiento_cantidato.id", $req_candi_id)
                        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
                        ->first();
                        
                        array_push($datos_basicos, $candidato->nombres);
                        array_push($req_can_id, $candidato->req_candidato);

                }

            }

            $req_can_id_j = json_encode($req_can_id);
            $req_can_id =   json_decode($req_can_id_j);

            $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_REFERENCIA_ESTUDIOS", $req_can_id);

            if ($valida_proceso["success"]) {
                return response()->json(["success" => false, "view" => $valida_proceso["view"]]);
            }

            foreach ($req_can_id as $key => $value) {

                $campos = [
                    'requerimiento_candidato_id' => $value,
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    'proceso'                    => "ENVIO_REFERENCIA_ESTUDIOS",
                ];

                $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $value);
                $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();

            }
            
            return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $value]);
    }

    public function confirmar_entrevista(Request $data)
    {
        /*$valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_ENTREVISTA", $data->get("candidato_req"));*/
        /*if ($valida_proceso["success"]) {
            return response()->json(["success" => false, "view" => $valida_proceso["view"]]);

        }*/

        $proceso = "ENVIO_ENTREVISTA";

        if(isset($data->tipo_entrevista)){
            if($data->tipo_entrevista == 1){
                $proceso = "ENVIO_ENTREVISTA_TECNICA";
            }
        }

        $campos = [
            'requerimiento_candidato_id' => $data->get("candidato_req"),
            'usuario_envio'              => $this->user->id,
            "fecha_inicio"               => date("Y-m-d H:i:s"),
            'proceso'                    => $proceso,
        ];

        $id_proceso = $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));
        
        /* //Se cambia el estado del requerimiento al enlazarlo con un candidato
        $obj                   = new \stdClass();
        $obj->requerimiento_id = $data->get("requerimiento_id");
        $obj->user_id          = $this->user->id;
        $obj->estado           = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
        Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));*/

        $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();

        //Se le envia correo al usuario que solicitó el requerimiento(KOMATSU)
        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
            $req_can = ReqCandidato::find($data->get("candidato_req"));
            $requerimiento = Requerimiento::find($req_can->requerimiento_id);
            $candidato = User::find($req_can->candidato_id);
            $user_envio = User::find($requerimiento->solicitud->user_id);

            $proceso_candidato = RegistroProceso::where('requerimiento_candidato_id', $req_can->id)
            ->where('requerimiento_id', $requerimiento->id)
            ->where('candidato_id', $candidato->id)
            ->first();

            if($proceso == "ENVIO_ENTREVISTA_TECNICA"){
                if($user_envio->id != 33758){
                    Mail::send('admin.email_envio_entrevista', [
                        'candidato' => $candidato,
                        'req'       => $requerimiento,
                        'id_ent'    => $proceso_candidato->id,
                    ], function ($message) use ($user_envio, $requerimiento) {
                        $message->to([$user_envio->email, 'javier.chiquito@t3rsc.co'], "T3RS")
                        ->subject("Entrevista Req # $requerimiento->id")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                }
            }//si cruex envia a entrevista rrhh  que le llegue la notificacion a danny

            if(($proceso == "ENVIO_ENTREVISTA") && ($user_envio->id == 33758)) {
                Mail::send('admin.email_envio_entrevista', [
                    'candidato' => $candidato,
                    'req'       => $requerimiento,
                    'id_ent'    => $proceso_candidato->id,
                ], function ($message) use ($user_envio, $requerimiento) {
                    $message->to(['danny.miranda@komatsu.com.co', 'javier.chiquito@t3rsc.co'], "T3RS")
                    ->subject("Entrevista Req # $requerimiento->id")
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            }//fin de si es entrevista enviar a danny
        }// fin de si es komatsu enviar entrevista

        return response()->json([
            "success" => true,
            "text_estado" => $estado->descripcion,
            'candidato_req' => $data->get("candidato_req"),
            'id_proceso' => $id_proceso
        ]);
    }

    public function enviar_aprobar_cliente_view(Request $data)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->select(
            "datos_basicos.*",
            "requerimiento_cantidato.id as req_candidato",
            "clientes.id as cliente"
        )
        ->first();

        $usuarios_clientes = ["" => "Selección"] + EloquentUser::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
        ->join("role_users", "role_users.user_id", "=", "users.id")
        ->where("role_users.role_id",3)
        ->where("users.estado",1)
        ->where("users_x_clientes.cliente_id", $candidato->cliente)
        ->pluck("users.name", "users.email")
        ->toArray();

        return view("admin.reclutamiento.modal.enviar_aprobar_cliente", compact("candidato",  "usuarios_clientes"));
    }

    public function confirmar_aprobar_cliente(Request $data)
    {
        $observacion= (!$data->observaciones) ? '' : $data->observaciones;

        //validamos los correos registrados para otros destinatarios
        $destinatarios = "";
        if( $data->has('otros_destinatarios') && $data->otros_destinatarios != '' ){
            
            $destinatarios = explode(",", $data->otros_destinatarios);

            foreach($destinatarios as $destinatario){
                $validador = Validator::make(["destinatario" => $destinatario], [
                    "destinatario"   => "email"
                ]);

                if ($validador->fails()) {
                    break;
                }
            }

            if ($validador->fails()) {
                return response()->json([
                    "success" => false,
                    "mensaje" => "Por favor ingrese correos correctos en otros destinatarios."
                ]);
            }

        }

        $campos = [
            'requerimiento_candidato_id' => $data->get("candidato_req"),
            'usuario_envio'      => $this->user->id,
            "fecha_inicio"       => date("Y-m-d H:i:s"),
            'proceso'            => "ENVIO_APROBAR_CLIENTE",
            'observaciones'      => $observacion,
        ];

        $this->RegistroProceso($campos, config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), $data->get("candidato_req"));

        $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();

        
        $req_can = ReqCandidato::find($data->get("candidato_req"));

        $requerimiento = Requerimiento::join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
            ->select('requerimientos.*', 'cargos_especificos.descripcion as cargo_especifico')
            ->find($req_can->requerimiento_id);

        $candidato = User::find($req_can->candidato_id);
        $user_envio = User::find($this->user->id);

        if ($data->usuarios_clientes!="") {
            $usuarios=[$user_envio->email,$data->usuarios_clientes];
        }else{
            $usuarios = [$user_envio->email];
        }

        if(is_array($destinatarios)){
            $usuarios = array_merge($usuarios,$destinatarios);
        }

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Aprobación de candidatos"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "Hola {$user_envio->name}, te informamos que el analista de selección que está llevando a cabo el proceso en el requerimiento No. {$requerimiento->id} para el cargo {$requerimiento->cargo_especifico} te ha enviado al candidato {$candidato->name} para aprobación. Por favor ingresa por el siguiente botón para realizar la gestión.";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'Ir a gestionar', 'buttonRoute' => route('req.mis_requerimiento').'?numero_req='.$req_can->requerimiento_id];

        $mailUser = $candidato->id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($requerimiento,$usuarios) {

            $message->to($usuarios, "T3RS")
                ->subject("Solicitud de aprobación de candidato Req No. $requerimiento->id")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        $guardar_emails_enviados = new EmailAprobarCliente();

        $guardar_emails_enviados->fill([
            'candidato_id'                  => $req_can->candidato_id,
            'requerimiento_id'              => $req_can->requerimiento_id,
            'candidato_requerimiento_id'    => $req_can->id,
            'quien_envia'                   => $this->user->id,
            'email_solicito_req'            => $user_envio->email,
            'email_cliente'                 => ( ($data->usuarios_clientes!="") ? $data->usuarios_clientes : null),
            'otros_emails'                  => (is_array($destinatarios) ? implode(",", $destinatarios) : null)

        ]);

        $guardar_emails_enviados->save();
        

        return response()->json([
            "success" => true,
            "text_estado" => $estado->descripcion,
            'candidato_req' => $data->get("candidato_req")
        ]);
    }

    public function pdf_paquete_contratacion($id, Request $data)
    {
        error_reporting(E_ALL ^ E_DEPRECATED);
        if(route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" ||
            route("home") == "http://localhost:8000" || route("home")=="https://pruebaslistos.t3rsc.co" ||
            route("home") == "https://listos.t3rsc.co" || route("home") == "https://vym.t3rsc.co"){
            
            $proceso_candidato_contra = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", '=', "requerimiento_candidato_id")
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            //->where("requerimiento_cantidato.requerimiento_id", $req)
            //->where('procesos_candidato_req.proceso','ENVIO_CONTRATACION')
            ->where('procesos_candidato_req.requerimiento_candidato_id', $id)
            ->orderBy('procesos_candidato_req.created_at', 'DESC')
            ->first();

            $requerimiento = Requerimiento::join("requerimiento_cantidato", "requerimiento_cantidato.requerimiento_id", "=", "requerimientos.id")
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->leftjoin('centros_costos_produccion','centros_costos_produccion.id','=','requerimientos.centro_costo_id')
            ->where("requerimiento_cantidato.id", $id)
            ->select(
                'requerimientos.*',
                'centros_costos_produccion.descripcion as centro_costos',
                'centros_costos_produccion.codigo as codigo',
                'negocio.num_negocio',
                'clientes.nombre',
                'requerimientos.id as id_requerimiento'
            )
            ->first();

            $empresa_logo = DB::table("empresa_logos")->where('id', $requerimiento->empresa_contrata)->first();

            $logo = (isset($empresa_logo->logo))?$empresa_logo->logo:'';
            $solicitud = "";        

            $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->select(
                "requerimientos.sitio_trabajo as sitio_trabajo",
                "requerimiento_cantidato.candidato_id",
                "users.name as nombre_user",
                "datos_basicos.numero_id",
                "requerimiento_cantidato.created_at",
                "requerimiento_cantidato.requerimiento_id",
                "requerimiento_cantidato.id as requerimiento_cantidato_id",
                "clientes.nombre as cliente_nombre"
            )
            ->where("requerimiento_cantidato.id", $id)
            ->first();

            $datos_basico = DatosBasicos::join("requerimiento_cantidato","datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
            // ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            //->join("requerimiento_cantidato", "requerimiento_cantidato.id", '=', "requerimiento_candidato_id")
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            //->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
            //->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
            //->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->leftJoin("bancos", "bancos.id", "=", "datos_basicos.nombre_banco")
            ->leftJoin("caja_compensacion", "caja_compensacion.id", "=", "datos_basicos.caja_compensaciones")
            ->leftJoin("fondo_cesantias", "fondo_cesantias.id", "=", "datos_basicos.fondo_cesantias")
            ->where("requerimiento_cantidato.requerimiento_id", $requerimiento->id_requerimiento)
            ->where("datos_basicos.user_id", $reqcandidato->candidato_id)
            //->where("procesos_candidato_req.requerimiento_id", $requerimiento->id)
            //->whereIn('procesos_candidato_req.proceso',['ENVIO_CONTRATACION_CLIENTE','ENVIO_CONTRATACION'])
            ->groupBy('procesos_candidato_req.candidato_id')
            ->orderBy('requerimiento_cantidato.id')
            ->select(
                "datos_basicos.*",
                "entidades_afp.descripcion as entidades_afp_des",
                "entidades_eps.descripcion as entidades_eps_des",
                "fondo_cesantias.descripcion as fondo_cesantia_des",
                "caja_compensacion.descripcion as caja_compensacion_des",
                "bancos.nombre_banco as nombre_banco_des",
                "procesos_candidato_req.fecha_inicio_contrato",
                "procesos_candidato_req.hora_entrada",
                "procesos_candidato_req.fecha_fin_contrato",
                "procesos_candidato_req.fecha_ultimo_contrato",
                'requerimiento_cantidato.auxilio_transporte',
                'requerimiento_cantidato.tipo_ingreso'
            )
            ->first();
            
            $lugarnacimiento = null;
            $lugarexpedicion = null;
            $lugarresidencia = null;

            $remitido = $this->user->name;
        }else{
            $remitido = $this->user->name;

            $contra_clientes = RegistroProceso::select('procesos_candidato_req.*')
            ->where('procesos_candidato_req.requerimiento_candidato_id', $id)
            ->where('procesos_candidato_req.proceso', 'ENVIO_CONTRATACION_CLIENTE')
            ->orderBy('procesos_candidato_req.id', 'desc')
            ->first();
        
            $proceso_candidato_contra = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", '=', "requerimiento_candidato_id")
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->where("requerimiento_cantidato.id", $id)
            ->orderBy('procesos_candidato_req.id','desc')
            ->first();

            $requerimiento = Requerimiento::join("requerimiento_cantidato", "requerimiento_cantidato.requerimiento_id", "=", "requerimientos.id")
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->leftjoin('centros_costos_produccion','centros_costos_produccion.id','=','requerimientos.centro_costo_produccion')
            ->where("requerimiento_cantidato.id", $id)
            ->first();

            $solicitud = "";
            
            if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
                $solicitud = Solicitudes::find($requerimiento->solicitud_id);
            }

            $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->select(
                "requerimientos.sitio_trabajo as sitio_trabajo",
                "requerimiento_cantidato.candidato_id",
                "users.name as nombre_user",
                "datos_basicos.numero_id",
                "requerimiento_cantidato.created_at",
                "requerimiento_cantidato.requerimiento_id",
                "requerimiento_cantidato.id as requerimiento_cantidato_id",
                "clientes.nombre as cliente_nombre"
            )
            ->where("requerimiento_cantidato.id", $id)
            ->first();

            //DOCUMENTOS VERIFICADOS PARA EL USUARIO
            //VALIDA SI EL DOCUMENTOS YA FUE VERIFICADO EN ESTE REQUERIMIENTO
            $doc_aprobados          = [];
            $doc_aprobados_archivos = [];
            
            $documentos_verificados = DocumentosVerificados::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "documentos_verificados.id")
            ->join("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")
            ->select(
                "documentos_verificados.nombre_archivo",
                "documentos_verificados.id",
                "tipos_documentos.id as documento_id",
                "documentos_verificados.descripcion_archivo"
            )
            ->where("proceso_requerimiento.requerimiento_id",$reqcandidato->requerimiento_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_DOCUMENTO")
            ->where("documentos_verificados.candidato_id",$reqcandidato->candidato_id)
            ->get();

            $extensionesValidas = ["png", "jpg", "jpeg", "gif"];
            $document_med_est_seguridad = array();

            foreach ($documentos_verificados as $key => $value) {
                if($value->descripcion_archivo=="EXAMEN MEDICOS"){
                    $document_med_est_seguridad["examenes"]=$value;
                }elseif($value->descripcion_archivo=="ESTUDIO SEGURIDAD"){
                    $document_med_est_seguridad["estudio"]=$value;
                }
            }
        
            foreach($documentos_verificados as $key => $value) {
                if (!in_array($value->documento_id, $doc_aprobados)) {
                    array_push($doc_aprobados, $value->documento_id);

                    $extencion = (explode(".", $value->nombre_archivo));
                    $extencion = end($extencion);

                    if(in_array($extencion, $extensionesValidas)) {
                        if(isset($doc_aprobados_archivos[$value->id])) {
                            array_push($doc_aprobados_archivos[$value->documento_id], $value->nombre_archivo);
                        }else{
                            $doc_aprobados_archivos[$value->documento_id] = [$value->nombre_archivo];
                        }
                    }
                }
            }
       
            //REFERENCIAS PERSONALES y LABORALES
            $estados_procesos_referenciacion = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $reqcandidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_REFERENCIACION", "ENVIO_REFERENCIACION_PENDIENTE"])
            ->get();

            //ENVIO A PRUEBAS
            $estados_pruebas = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $reqcandidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_PRUEBAS", "ENVIO_PRUEBAS_PENDIENTE"])
            ->get();
            
            //DATOS HOJA DE VIDA
            $datos_basicos = DatosBasicos::leftJoin("tipos_documentos", "tipos_documentos.id", "=", "datos_basicos.tipo_id")
            ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
            ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
            ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
            ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
            ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->where("user_id", $reqcandidato->candidato_id)
            ->select(
                "datos_basicos.*",
                "tipos_documentos.descripcion as dec_tipo_doc",
                "generos.descripcion as genero_desc",
                "estados_civiles.descripcion as estado_civil_des",
                "aspiracion_salarial.descripcion as aspiracion_salarial_des",
                "clases_libretas.descripcion as clases_libretas_des",
                "tipos_vehiculos.descripcion as tipos_vehiculos_des",
                "categorias_licencias.descripcion as categorias_licencias_des",
                "entidades_afp.descripcion as entidades_afp_des",
                "entidades_eps.descripcion as entidades_eps_des"
            )
            ->first();
            
            $lugarnacimiento = null;
            $lugarexpedicion = null;
            $lugarresidencia = null;

            if($datos_basicos != null) {
                $lugarnacimiento = Pais::join("departamentos", function ($join) {
                    $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                })
                ->select(DB::raw("CONCAT(paises.nombre,' / ',departamentos.nombre,' / ',ciudad.nombre) AS value"))
                ->where("ciudad.cod_pais", $datos_basicos->pais_nacimiento)
                ->where("ciudad.cod_departamento", $datos_basicos->departamento_nacimiento)
                ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_nacimiento)
                ->first();

                $lugarexpedicion = Pais::join("departamentos", function ($join) {
                    $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                })
                ->select(DB::raw("CONCAT(paises.nombre,' / ',departamentos.nombre,' / ',ciudad.nombre) AS value"))
                ->where("ciudad.cod_pais", $datos_basicos->pais_id)
                ->where("ciudad.cod_departamento", $datos_basicos->departamento_id)
                ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_id)
                ->first();

                $lugarresidencia = Pais::join("departamentos", function ($join) {
                    $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                })
                ->select(DB::raw("CONCAT(paises.nombre,' / ',departamentos.nombre,' / ',ciudad.nombre) AS value"))
                ->where("ciudad.cod_pais", $datos_basicos->pais_residencia)
                ->where("ciudad.cod_departamento", $datos_basicos->departamento_residencia)
                ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_residencia)
                ->first();
            }

            $experiencias = Experiencias::join("paises", "paises.cod_pais", "=", "experiencias.pais_id")
            ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
            ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
                    ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
                ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
            })->where("experiencias.user_id", $reqcandidato->candidato_id)
            ->select(
                "aspiracion_salarial.descripcion as salario",
                "cargos_genericos.descripcion as desc_cargo",
                "motivos_retiros.descripcion as desc_motivo",
                DB::raw("CONCAT(paises.nombre,' / ',departamentos.nombre,' / ',ciudad.nombre) AS ciudades"), "experiencias.*")
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->get();

            $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.*", "niveles_estudios.descripcion as desc_nivel")
            ->where("estudios.user_id", $reqcandidato->candidato_id)
            ->get();

            $referencias = ReferenciasPersonales::join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->leftJoin("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
            ->where("referencias_personales.user_id", $reqcandidato->candidato_id)
            ->select(
                DB::raw("CONCAT(paises.nombre,' / ',departamentos.nombre,' / ',ciudad.nombre) AS ciudades"), "tipo_relaciones.descripcion as desc_tipo",
                "referencias_personales.*"
            )
            ->get();

            $familiares = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select(
                "grupos_familiares.*",
                "tipos_documentos.descripcion as tipo_documento",
                "escolaridades.descripcion as escolaridad",
                "parentescos.descripcion as parentesco",
                "generos.descripcion as genero"
            )
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->get();

            //PRUEBAS GESTION
            $req_gestion = GestionPrueba::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "gestion_pruebas.id")
            ->join("tipos_pruebas", "tipos_pruebas.id", "=", "gestion_pruebas.tipo_prueba_id")
            ->join("users as user1", "user1.id", "=", "gestion_pruebas.user_id")
            ->join("users as user2", "user2.id", "=", "gestion_pruebas.candidato_id")
            ->select(
                "tipos_pruebas.descripcion as text_prueba",
                "gestion_pruebas.*",
                "user1.name as usuario_gestion",
                "user2.name as nombre_candidato"
            )
            ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
            ->where("gestion_pruebas.candidato_id", $reqcandidato->candidato_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_PRUEBAS")
            ->get();

            //PRUEBAS ENTREVISTA
            $req_entrevista = EntrevistaCandidatos::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "entrevistas_candidatos.id")
            ->join("users as user1", "user1.id", "=", "entrevistas_candidatos.user_gestion_id")
            ->join("users as user2", "user2.id", "=", "entrevistas_candidatos.candidato_id")
            ->select("entrevistas_candidatos.*", "user1.name as usuario_gestion", "user2.name as nombre_candidato")
            ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
            ->where("entrevistas_candidatos.candidato_id", $reqcandidato->candidato_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_ENTREVISTA")
            ->get();

            //REFERENCIAS PERSONALES VERIFICADAS
            $req_personales_verificadas = ReferenciaPersonalVerificada::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "ref_personales_verificada.id")
            ->join("users as user1", "user1.id", "=", "ref_personales_verificada.usuario_gestion")
            ->join("users as user2", "user2.id", "=", "ref_personales_verificada.candidato_id")
            ->select("ref_personales_verificada.*", "user1.name as usuario_gestion", "user2.name as nombre_candidato")
            ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
            ->where("ref_personales_verificada.candidato_id", $reqcandidato->candidato_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_REFERENCIACION")
            ->where("proceso_requerimiento.proceso_adicional", "REFERENCIA_PERSONAL")
            ->get();

            //EXPERIENCIAS LABORALES
            $req_expiencia = ExperienciaVerificada::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "experiencia_verificada.id")
            ->join("experiencias as ex", "ex.id", "=", "experiencia_verificada.experiencia_id")
            ->join("users as user1", "user1.id", "=", "experiencia_verificada.usuario_gestion")
            ->join("users as user2", "user2.id", "=", "experiencia_verificada.candidato_id")
            ->select("ex.nombre_empresa", "experiencia_verificada.*", "user1.name as usuario_gestion", "user2.name as nombre_candidato")
            ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
            ->where("experiencia_verificada.candidato_id", $reqcandidato->candidato_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_REFERENCIACION")
            ->where("proceso_requerimiento.proceso_adicional", "EXPERIENCIA_LABORAL")
            ->get();

            //DASHBOARD
            $seg_candidato = RegistroProceso::leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("procesos_candidato_req.candidato_id", $id)
            ->select("motivos_rechazos.descripcion as des_motivo_rechazo", "procesos_candidato_req.*")
            ->orderBy("procesos_candidato_req.created_at")
            ->get();

            //Entrevistas
            $entrevistas = EntrevistaCandidatos::join("users", "users.id", "=", "entrevistas_candidatos.user_gestion_id")
            ->join("tipo_fuente", "tipo_fuente.id", "=", "entrevistas_candidatos.fuentes_publicidad_id")
            ->where("entrevistas_candidatos.candidato_id", $datos_basicos->user_id)
            ->select("entrevistas_candidatos.*", "users.name", "tipo_fuente.descripcion as desc_fuente")
            ->orderBy("entrevistas_candidatos.created_at", "desc")
            ->get();

            //REFERENCIAS PERSONALES
            $referencias = ReferenciasPersonales::join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
            ->where("referencias_personales.user_id", $datos_basicos->user_id)
            ->select(
                DB::raw("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS ciudades"),
                "tipo_relaciones.descripcion as desc_tipo",
                "referencias_personales.*"
            )
            ->get();

            //EXPERIENCIAS LABORALES VERIFICADAS
            $experiencias_verificadas = ExperienciaVerificada::join("experiencias", "experiencias.id", "=", "experiencia_verificada.experiencia_id")
            ->join("motivos_retiros", "motivos_retiros.id", "=", "experiencia_verificada.motivo_retiro_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
            ->where("experiencias.user_id", $datos_basicos->user_id)
            ->select(
                "experiencias.*",
                "motivos_retiros.*",
                "cargos_genericos.*",
                "experiencia_verificada.*",
                "cargos_genericos.descripcion as name_cargo",
                "motivos_retiros.descripcion as name_motivo"
            )
            ->get();

            //REFERENCIAS PERSONALES VERIFICADAS
            $rpvs = ReferenciaPersonalVerificada::join("referencias_personales", "referencias_personales.id", "=", "ref_personales_verificada.referencia_personal_id")
            ->where("ref_personales_verificada.candidato_id", $datos_basicos->user_id)
            ->get();
        }

        if(route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" ||
            route("home") == "http://localhost:8000" || route("home") == "https://pruebaslistos.t3rsc.co" ||
            route("home") == "https://listos.t3rsc.co" || route("home") == "https://vym.t3rsc.co"){
            $view = \SnappyPDF::loadView('admin.orden_contratacion_pdf', compact(
                'contra_clientes',
                'proceso_candidato_contra',
                'requerimiento',
                'reqcandidato',
                'doc_aprobados',
                'estados_procesos_referenciacion',
                "estados_pruebas",
                'datos_basico',
                'user',"req_gestion",
                "id",
                "remitido",
                "logo",
                "empresa_logo"
            ));
        }else{
            $view = \SnappyPDF::loadView('admin.paquete_contratacion_pdf', compact(
                'solicitud',
                'contra_clientes',
                'proceso_candidato_contra',
                'requerimiento',
                'reqcandidato',
                'doc_aprobados',
                'estados_procesos_referenciacion',
                "estados_pruebas",
                'datos_basicos',
                //'user',
                "lugarresidencia",
                'lugarnacimiento',
                "lugarexpedicion",
                "experiencias",
                "estudios",
                "referencias",
                "familiares",
                "req_gestion",
                "req_entrevista",
                "req_personales_verificadas",
                "req_expiencia",
                "seg_candidato",
                "doc_aprobados_archivos",
                "entrevistas",
                "referencias",
                "referencias",
                "experiencias_verificadas",
                "remitido",
                "rpvs",
                "document_med_est_seguridad",
                "id"
            ));
        }

        //$pdf = app('dompdf.wrapper');
        //$pdf->loadHTML($view);

        if(route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" ||
            route("home") == "http://localhost:8000" || route("home") == "https://pruebaslistos.t3rsc.co" ||
            route("home") == "https://listos.t3rsc.co" || route("home") == "https://vym.t3rsc.co"){
            //$pdf->setPaper('A4','landscape');
        }

        return $view->stream('paquete_contratacion.pdf');
    }

    public function pdf_orden_contratacion($req)
    {
        error_reporting(E_ALL ^ E_DEPRECATED);

        $contra_clientes = RegistroProceso::select('procesos_candidato_req.*')
        ->where('procesos_candidato_req.requerimiento_id', $req)
        // ->whereIn('procesos_candidato_req.proceso',['ENVIO_CONTRATACION_CLIENTE','ENVIO_CONTRATACION'])
        ->orderBy('procesos_candidato_req.id', 'desc')
        ->get();

        $datos_basicos = RequerimientoContratoCandidato::join("users", "users.id", "=", "requerimiento_contrato_candidato.candidato_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->leftJoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
        ->leftJoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
        ->leftJoin("fondo_cesantias", "fondo_cesantias.id", "=", "requerimiento_contrato_candidato.fondo_cesantia_id")
        ->leftJoin("caja_compensacion", "caja_compensacion.id", "=", "requerimiento_contrato_candidato.caja_compensacion_id")
        ->leftJoin("bancos", "bancos.id", "=", "requerimiento_contrato_candidato.nombre_banco")
        ->where("requerimiento_contrato_candidato.requerimiento_id", $req)
        ->whereRaw('requerimiento_contrato_candidato.id=(select max(requerimiento_contrato_candidato.id) from requerimiento_contrato_candidato where requerimiento_contrato_candidato.candidato_id=users.id)')
        //->whereIn('procesos_candidato_req.proceso',['ENVIO_CONTRATACION'])
        ->select(
            "datos_basicos.*",
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
            'requerimiento_contrato_candidato.tipo_ingreso'
        )
        ->orderBy("requerimiento_contrato_candidato.id", "desc")
        ->groupBy('users.id')
        ->get();

        if($datos_basicos->count() == 0){
            $datos_basicos = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", '=', "requerimiento_candidato_id")
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->leftJoin("fondo_cesantias", "fondo_cesantias.id", "=", "datos_basicos.fondo_cesantias")
            ->leftJoin("caja_compensacion", "caja_compensacion.id", "=", "datos_basicos.caja_compensaciones")
            ->leftJoin("bancos", "bancos.id", "=", "datos_basicos.nombre_banco")
            ->where("requerimiento_cantidato.requerimiento_id", $req)
            ->whereIn('procesos_candidato_req.proceso', ['ENVIO_CONTRATACION'])
            ->select(
                "datos_basicos.*",
                "entidades_afp.descripcion as entidades_afp_des",
                "entidades_eps.descripcion as entidades_eps_des",
                "fondo_cesantias.descripcion as fondo_cesantia_des",
                "caja_compensacion.descripcion as caja_compensacion_des",
                "bancos.nombre_banco as nombre_banco_des",
                "procesos_candidato_req.fecha_inicio_contrato",
                "procesos_candidato_req.fecha_ultimo_contrato",
                "procesos_candidato_req.hora_entrada",
                "procesos_candidato_req.fecha_ingreso_contra",
                "procesos_candidato_req.fecha_fin_contrato",
                'requerimiento_cantidato.auxilio_transporte',
                'requerimiento_cantidato.tipo_ingreso'
            )
            ->orderBy('procesos_candidato_req.id','desc')
            ->groupBy('procesos_candidato_req.requerimiento_candidato_id')
            ->get();
        }

        $requerimiento = Requerimiento::join("requerimiento_cantidato", "requerimiento_cantidato.requerimiento_id", "=", "requerimientos.id")
        ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->leftjoin('requerimiento_contrato_candidato', 'requerimiento_contrato_candidato.requerimiento_id', '=', 'requerimientos.id')
        ->leftjoin('centros_costos_produccion','centros_costos_produccion.id','=','requerimiento_contrato_candidato.centro_costo_id')
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->where("requerimiento_cantidato.requerimiento_id", $req)
        ->select(
            'requerimientos.*',
            'centros_costos_produccion.descripcion as centro_costos',
            'centros_costos_produccion.codigo as codigo',
            'negocio.num_negocio',
            'clientes.nombre',
            'requerimientos.id as id_requerimiento'
        )
        ->first();

        $solicitud = "";

        $logo = "";

        $empresa_logo = DB::table("empresa_logos")->where('id',$requerimiento->empresa_contrata)->first();

        $logo = (isset($empresa_logo->logo)) ? $empresa_logo->logo : '';

        $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->select(
            "requerimientos.sitio_trabajo as sitio_trabajo",
            "requerimiento_cantidato.candidato_id",
            "users.name as nombre_user",
            "datos_basicos.numero_id",
            "requerimiento_cantidato.created_at",
            "requerimiento_cantidato.requerimiento_id",
            "requerimiento_cantidato.id as requerimiento_cantidato_id",
            "clientes.nombre as cliente_nombre"
        )
        ->where("requerimiento_cantidato.requerimiento_id", $req)
        ->get();

        $proceso_candidato_contra = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", '=', "requerimiento_candidato_id")
        ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->where('procesos_candidato_req.proceso','ENVIO_CONTRATACION')
        ->where('procesos_candidato_req.requerimiento_id', $req)
        ->orderBy('procesos_candidato_req.created_at', 'DESC')
        ->first();

        /*
            $documentos_verificados = DocumentosVerificados::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "documentos_verificados.id")
            ->join("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")
            ->select("documentos_verificados.nombre_archivo", "documentos_verificados.id", "tipos_documentos.id as documento_id","documentos_verificados.descripcion_archivo")
            ->where("proceso_requerimiento.requerimiento_id",$reqcandidato->requerimiento_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_DOCUMENTO")
            ->where("documentos_verificados.candidato_id",$reqcandidato->candidato_id)
            ->get();
        */

        /*
            $extensionesValidas = ["png", "jpg", "jpeg", "gif"];
            $document_med_est_seguridad=array();

            foreach ($documentos_verificados as $key => $value) {
                if($value->descripcion_archivo=="EXAMEN MEDICOS"){
                    $document_med_est_seguridad["examenes"]=$value;
                }
                elseif($value->descripcion_archivo=="ESTUDIO SEGURIDAD"){
                    $document_med_est_seguridad["estudio"]=$value;
                }
            }
            
            foreach($documentos_verificados as $key => $value) {
                if (!in_array($value->documento_id, $doc_aprobados)) {
                    array_push($doc_aprobados, $value->documento_id);

                    $extencion = (explode(".", $value->nombre_archivo));
                    $extencion = end($extencion);

                    if (in_array($extencion, $extensionesValidas)) {
                        if (isset($doc_aprobados_archivos[$value->id])) {
                            array_push($doc_aprobados_archivos[$value->documento_id], $value->nombre_archivo);
                        } else {
                            $doc_aprobados_archivos[$value->documento_id] = [$value->nombre_archivo];
                        }
                    }
                }
            }
        */

        //REFERENCIAS PERSONALES y LABORALES
        /*
            $estados_procesos_referenciacion = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $reqcandidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_REFERENCIACION", "ENVIO_REFERENCIACION_PENDIENTE"])->get();

            //ENVIO A PRUEBAS
            $estados_pruebas = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $reqcandidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_PRUEBAS", "ENVIO_PRUEBAS_PENDIENTE"])->get();
            //$data =$this->getData();
        */
        
        //DATOS HOJA DE VIDA
        $lugarnacimiento = null;
        $lugarexpedicion = null;
        $lugarresidencia = null;

        /*
            if ($datos_basicos != null) {
            $lugarnacimiento = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
                ->select(DB::raw("CONCAT(paises.nombre,' / ',departamentos.nombre,' / ',ciudad.nombre) AS value"))
                ->where("ciudad.cod_pais", $datos_basicos->pais_nacimiento)
                ->where("ciudad.cod_departamento", $datos_basicos->departamento_nacimiento)
                ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_nacimiento)->first();

            $lugarexpedicion = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
                ->select(DB::raw("CONCAT(paises.nombre,' / ',departamentos.nombre,' / ',ciudad.nombre) AS value"))
                ->where("ciudad.cod_pais", $datos_basicos->pais_id)
                ->where("ciudad.cod_departamento", $datos_basicos->departamento_id)
                ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_id)->first();

            $lugarresidencia = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
                ->select(DB::raw("CONCAT(paises.nombre,' / ',departamentos.nombre,' / ',ciudad.nombre) AS value"))
                ->where("ciudad.cod_pais", $datos_basicos->pais_residencia)
                ->where("ciudad.cod_departamento", $datos_basicos->departamento_residencia)
                ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_residencia)->first();
            }

            $experiencias = Experiencias::join("paises", "paises.cod_pais", "=", "experiencias.pais_id")
                ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
                ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
                ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
                ->join("departamentos", function ($join) {
                    $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
                        ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
                })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
                    ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
            })->where("experiencias.user_id", $reqcandidato->candidato_id)
                ->select("aspiracion_salarial.descripcion as salario", "cargos_genericos.descripcion as desc_cargo", "motivos_retiros.descripcion as desc_motivo", DB::raw("CONCAT(paises.nombre,' / ',departamentos.nombre,' / ',ciudad.nombre) AS ciudades"), "experiencias.*")
                ->orderBy("experiencias.fecha_inicio", "desc")
                ->get();

            $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
                ->select("estudios.*", "niveles_estudios.descripcion as desc_nivel")
                ->where("estudios.user_id", $reqcandidato->candidato_id)->get();

            $referencias = ReferenciasPersonales::join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
                ->join("departamentos", function ($join) {
                    $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                        ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
                })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                    ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->leftJoin("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
                ->where("referencias_personales.user_id", $reqcandidato->candidato_id)
                ->select(DB::raw("CONCAT(paises.nombre,' / ',departamentos.nombre,' / ',ciudad.nombre) AS ciudades"), "tipo_relaciones.descripcion as desc_tipo", "referencias_personales.*")
                ->get();

            $familiares = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
                ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
                ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
                ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
                ->select("grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero")
                ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
                ->get();
        */

        //PRUEBAS GESTION
        /* $req_gestion = GestionPrueba::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "gestion_pruebas.id")
            ->join("tipos_pruebas", "tipos_pruebas.id", "=", "gestion_pruebas.tipo_prueba_id")
            ->join("users as user1", "user1.id", "=", "gestion_pruebas.user_id")
            ->join("users as user2", "user2.id", "=", "gestion_pruebas.candidato_id")
            ->select("tipos_pruebas.descripcion as text_prueba", "gestion_pruebas.*", "user1.name as usuario_gestion", "user2.name as nombre_candidato")
            ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
            ->where("gestion_pruebas.candidato_id", $reqcandidato->candidato_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_PRUEBAS")->get();
        //PRUEBAS ENTREVISTA
        //dd($reqcandidato->candidato_id);
        $req_entrevista = EntrevistaCandidatos::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "entrevistas_candidatos.id")
            ->join("users as user1", "user1.id", "=", "entrevistas_candidatos.user_gestion_id")
            ->join("users as user2", "user2.id", "=", "entrevistas_candidatos.candidato_id")
            ->select("entrevistas_candidatos.*", "user1.name as usuario_gestion", "user2.name as nombre_candidato")
            ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
            ->where("entrevistas_candidatos.c    andidato_id", $reqcandidato->candidato_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_ENTREVISTA")->get();

        //REFERENCIAS PERSONALES VERIFICADAS
        $req_personales_verificadas = ReferenciaPersonalVerificada::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "ref_personales_verificada.id")
            ->join("users as user1", "user1.id", "=", "ref_personales_verificada.usuario_gestion")
            ->join("users as user2", "user2.id", "=", "ref_personales_verificada.candidato_id")
            ->select("ref_personales_verificada.*", "user1.name as usuario_gestion", "user2.name as nombre_candidato")
            ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
            ->where("ref_personales_verificada.candidato_id", $reqcandidato->candidato_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_REFERENCIACION")
            ->where("proceso_requerimiento.proceso_adicional", "REFERENCIA_PERSONAL")
            ->get();
        //EXPERIENCIAS LABORALES
        $req_expiencia = ExperienciaVerificada::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "experiencia_verificada.id")
            ->join("experiencias as ex", "ex.id", "=", "experiencia_verificada.experiencia_id")
            ->join("users as user1", "user1.id", "=", "experiencia_verificada.usuario_gestion")
            ->join("users as user2", "user2.id", "=", "experiencia_verificada.candidato_id")
            ->select("ex.nombre_empresa", "experiencia_verificada.*", "user1.name as usuario_gestion", "user2.name as nombre_candidato")
            ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
            ->where("experiencia_verificada.candidato_id", $reqcandidato->candidato_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_REFERENCIACION")
            ->where("proceso_requerimiento.proceso_adicional", "EXPERIENCIA_LABORAL")
            ->get();

        //DASHBOARD

        $seg_candidato = RegistroProceso::leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("procesos_candidato_req.candidato_id", $id)
            ->select("motivos_rechazos.descripcion as des_motivo_rechazo", "procesos_candidato_req.*")
            ->orderBy("procesos_candidato_req.created_at")
            ->get();
        //dd($req_entrevista);

        //::::::::::___NEW___::::::::::::

        //Entrevistas
        $entrevistas = EntrevistaCandidatos::join("users", "users.id", "=", "entrevistas_candidatos.user_gestion_id")
            ->join("tipo_fuente", "tipo_fuente.id", "=", "entrevistas_candidatos.fuentes_publicidad_id")
            ->where("entrevistas_candidatos.candidato_id", $datos_basicos->user_id)
            ->select("entrevistas_candidatos.*", "users.name", "tipo_fuente.descripcion as desc_fuente")
            ->orderBy("entrevistas_candidatos.created_at", "desc")
            ->get();
        //dd($entrevistas);

        //REFERENCIAS PERSONALES
        $referencias = ReferenciasPersonales::join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
            ->where("referencias_personales.user_id", $datos_basicos->user_id)
            ->select(DB::raw("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS ciudades"), "tipo_relaciones.descripcion as desc_tipo", "referencias_personales.*")
            ->get();

        //EXPERIENCIAS LABORALES VERIFICADAS
        $experiencias_verificadas = ExperienciaVerificada::join("experiencias", "experiencias.id", "=", "experiencia_verificada.experiencia_id")
            ->join("motivos_retiros", "motivos_retiros.id", "=", "experiencia_verificada.motivo_retiro_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
            ->where("experiencias.user_id", $datos_basicos->user_id)
            ->select("experiencias.*", "motivos_retiros.*", "cargos_genericos.*", "experiencia_verificada.*", "cargos_genericos.descripcion as name_cargo", "motivos_retiros.descripcion as name_motivo")
            ->get();

        //dd($experiencias_verificadas);

        //REFERENCIAS PERSONALES VERIFICADAS
        $rpvs = ReferenciaPersonalVerificada::join("referencias_personales", "referencias_personales.id", "=", "ref_personales_verificada.referencia_personal_id")
            ->where("ref_personales_verificada.candidato_id", $datos_basicos->user_id)
            ->get();
        //dd($rpvs);*/
        
        $remitido = $this->user->name;

        $view = view('admin.orden_contratacion_pdf', compact(
            'contra_clientes',
            'requerimiento',
            'reqcandidato',
            //'doc_aprobados',
            'estados_procesos_referenciacion',
            "estados_pruebas",
            'datos_basicos',
            'user',
            "req_gestion",
            "remitido",
            "id",
            "logo",
            "empresa_logo",
            "proceso_candidato_contra"
        ))->render();

        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper('A4','landscape');

        return $pdf->stream('invoice');
    }

    public function pdf_hv($user_id, Request $data)
    {
        $user = User::findOrFail($user_id);
        
        //para mostrar hoja de vida en el pdf
        $req = (isset($data->req))?$data->req:"";
        $logo = "";

        $documentos = Documentos::where("numero_id",$user->numero_id)
        ->orderBy("id","desc")->groupBy("tipo_documento_id")
        ->get();

            if($req != ""){
                $requerimiento = Requerimiento::find($req);
                $empresa_logo = DB::table("empresa_logos")->where('id',$requerimiento->empresa_contrata)->first();

                $logo = (isset($empresa_logo->logo)) ? $empresa_logo->logo : '';

                $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->leftjoin("cargos_especificos", "requerimientos.cargo_especifico_id", "=", "cargos_especificos.id")
                ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
                ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->leftjoin("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->select(
                    "cargos_especificos.descripcion",
                    "requerimiento_cantidato.candidato_id",
                    "requerimientos.sitio_trabajo as sitio_trabajo",
                    "requerimiento_cantidato.candidato_id",
                    "users.name as nombre_user",
                    "datos_basicos.numero_id",
                    "requerimiento_cantidato.created_at",
                    "requerimiento_cantidato.requerimiento_id",
                    "requerimiento_cantidato.id as requerimiento_cantidato_id",
                    "clientes.nombre as cliente_nombre"
                )
                ->where("requerimiento_cantidato.candidato_id", $user->id)
                ->where("requerimiento_cantidato.requerimiento_id", $requerimiento->id)
                ->orderBy("requerimiento_cantidato.requerimiento_id", "asc")
                ->first();
            }
        

        $archivo = Documentos::select('nombre_archivo')->where("user_id", $user->id)->where("descripcion_archivo", 'HOJA DE VIDA')->orderBy('created_at','DESC')->first();

        $datos_basicos = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
        ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
        ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
        ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
        ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
        ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
        ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
        ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
        ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
        ->where("user_id", $user_id)
        ->select(
            "datos_basicos.*",
            "tipo_identificacion.descripcion as dec_tipo_doc",
            "generos.descripcion as genero_desc",
            "estados_civiles.descripcion as estado_civil_des",
            "aspiracion_salarial.descripcion as aspiracion_salarial_des",
            "clases_libretas.descripcion as clases_libretas_des",
            "tipos_vehiculos.descripcion as tipos_vehiculos_des",
            "categorias_licencias.descripcion as categorias_licencias_des",
            "entidades_afp.descripcion as entidades_afp_des",
            "entidades_eps.descripcion as entidades_eps_des"
        )
        ->first();

        //Calcular edad de candidatos.
        $edad = ($datos_basicos->fecha_nacimiento != 0 && $datos_basicos->fecha_nacimiento != "") ? Carbon::parse($datos_basicos->fecha_nacimiento)->age : "";

        $lugarnacimiento = null;
        $lugarexpedicion = null;
        $lugarresidencia = null;

        if($datos_basicos != null) {
            $lugarnacimiento = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
                ->where("ciudad.cod_pais", $datos_basicos->pais_nacimiento)
                ->where("ciudad.cod_departamento", $datos_basicos->departamento_nacimiento)
                ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_nacimiento)->first();

            $lugarexpedicion = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais", $datos_basicos->pais_id)
                ->where("ciudad.cod_departamento", $datos_basicos->departamento_id)
                ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_id)->first();

            $lugarresidencia = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select(\DB::raw("CONCAT(ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_residencia)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_residencia)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_residencia)
            ->first();
        }

        $experiencias = Experiencias::leftjoin("paises", "paises.cod_pais", "=", "experiencias.pais_id")
        ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
        ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
        ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
        ->leftjoin("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
            ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
        })->leftjoin("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
            ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
        })
        ->where("experiencias.user_id", $user_id)
        ->select("aspiracion_salarial.descripcion as salario", "cargos_genericos.descripcion as desc_cargo", "motivos_retiros.descripcion as desc_motivo", \DB::raw("CONCAT(ciudad.nombre) AS ciudades"), "experiencias.*")
        ->orderBy("experiencias.fecha_inicio", "desc")
        ->get();

        $estudios = Estudios::leftjoin("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        ->select("estudios.*", "niveles_estudios.descripcion as desc_nivel")
        ->where("estudios.user_id", $user_id)->get();

        $referencias = ReferenciasPersonales::leftjoin("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
        ->leftjoin("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
            ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->leftjoin("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
            ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
            ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
        ->where("referencias_personales.user_id", $user_id)
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudades"), "tipo_relaciones.descripcion as desc_tipo", "referencias_personales.*")
        ->get();

        $familiares = GrupoFamilia::leftjoin("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
        ->leftjoin("escolaridades", "escolaridades.id","=","grupos_familiares.escolaridad_id")
        ->join("parentescos", "parentescos.id","=","grupos_familiares.parentesco_id")
        ->leftjoin("generos","generos.id","=","grupos_familiares.genero")
        ->select("grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", \DB::raw("CONCAT(grupos_familiares.nombres,' ',grupos_familiares.primer_apellido,' ',grupos_familiares.segundo_apellido) AS nombres_familiar"))
        ->where("grupos_familiares.user_id", $user_id)
        ->orderBy("parentescos.id", "ASC")
        ->get();

        $experienciaMayorDuracion = Experiencias::leftjoin('aspiracion_salarial', 'aspiracion_salarial.id', '=', 'experiencias.salario_devengado')
        ->select(\DB::raw("*,(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) AS dias,(user_id) AS usuario"),"aspiracion_salarial.descripcion AS salario","experiencias.empleo_actual")
        ->selectRaw("experiencias.salario_devengado")
        ->where("user_id", $user_id)
        //->max('dias')
        ->havingRaw("dias >= (SELECT MAX(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) FROM experiencias as e WHERE e.user_id = experiencias.user_id)")
        ->first();

        $experienciaActual = Experiencias::leftjoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
        ->where("experiencias.user_id", $user_id)
        ->select("aspiracion_salarial.descripcion as salario", "experiencias.*")
        ->orderBy("experiencias.fecha_inicio", "DESC")
        ->first();

        $idiomas = IdiomaUsuario::where("id_usuario", $user_id)->get();

        $autoentrevista = '';

        $hv=Archivo_hv::where("user_id",$user_id)->orderBy("archivo_hv.id","desc")->first();

        if(route("home") == "https://gpc.t3rsc.co" || route("home")=="http://localhost:8000"){
            $autoentrevista = Autoentrevist::where('id_usuario',$user->id)->first();
            $anios = ($datos_basicos->fecha_nacimiento != 0 && $datos_basicos->fecha_nacimiento != "") ? Carbon::parse($datos_basicos->fecha_nacimiento)->age : "";
        }

        if($data->has("download")){
            $pdf = \SnappyPDF::loadView('cv.pdf_hv_new',[
                'experienciaMayorDuracion'=>$experienciaMayorDuracion,
                'idiomas'=>$idiomas,
                'hv'=>$hv,
                'reqcandidato'=>$reqcandidato,
                'experienciaActual'=>$experienciaActual,
                'datos_basicos'=>$datos_basicos,
                'edad'=>$edad,
                'user'=>$user,
                "lugarresidencia"=>$lugarresidencia,
                'lugarnacimiento'=>$lugarnacimiento,
                "lugarexpedicion"=>$lugarexpedicion,
                "experiencias"=>$experiencias,
                "estudios"=>$estudios,
                "referencias"=>$referencias,
                "familiares"=>$familiares,
                "archivo"=>$archivo,
                "logo"=>$logo,
                'autoentrevista'=>$autoentrevista,
                'documentos'=>$documentos
            ]);

            $output = $pdf->output();
            return $output;
        }

        return view('cv.pdf_hv_new', compact(
            'idiomas',
            'hv',
            'reqcandidato',
            'experienciaActual',
            'experienciaMayorDuracion',
            'datos_basicos',
            'edad',
            'user',
            "lugarresidencia",
            'lugarnacimiento',
            "lugarexpedicion",
            "experiencias",
            "estudios",
            "referencias",
            "familiares",
            "logo",
            "documentos"
        ));
    }

    public function pdf_hoja_vida($user_id, Request $data)
    {
        $user = User::findOrFail($user_id);

        //para mostrar hoja de vida en el pdf
        $req = (isset($data->req))?$data->req:"";
        
        $sitio = Sitio::first();
        $logo = $sitio->logo;

        $archivo = Documentos::select('nombre_archivo')->where("user_id", $user->id)->where("descripcion_archivo", 'HOJA DE VIDA')->orderBy('created_at','DESC')->first();

        $datos_basicos = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
        ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
        ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
        ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
        ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
        ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
        ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
        ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
        ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
        ->where("user_id", $user_id)
        ->select("datos_basicos.*", "tipo_identificacion.descripcion as dec_tipo_doc", "generos.descripcion as genero_desc"
            , "estados_civiles.descripcion as estado_civil_des"
            , "aspiracion_salarial.descripcion as aspiracion_salarial_des"
            , "clases_libretas.descripcion as clases_libretas_des"
            , "tipos_vehiculos.descripcion as tipos_vehiculos_des"
            , "categorias_licencias.descripcion as categorias_licencias_des"
            , "entidades_afp.descripcion as entidades_afp_des"
            , "entidades_eps.descripcion as entidades_eps_des"
        )
        ->first();

        if($req != ""){
            $requerimiento = Requerimiento::find($req);

            $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            ->leftjoin("cargos_especificos", "requerimientos.cargo_especifico_id", "=", "cargos_especificos.id")
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->leftjoin("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->select(
                "cargos_especificos.descripcion",
                "requerimiento_cantidato.candidato_id",
                "requerimientos.sitio_trabajo as sitio_trabajo",
                "requerimiento_cantidato.candidato_id",
                "users.name as nombre_user",
                "datos_basicos.numero_id",
                "requerimiento_cantidato.created_at",
                "requerimiento_cantidato.requerimiento_id",
                "requerimiento_cantidato.id as requerimiento_cantidato_id",
                "clientes.nombre as cliente_nombre"
            )
            ->where("requerimiento_cantidato.candidato_id", $user->id)
            ->where("requerimiento_cantidato.requerimiento_id", $requerimiento->id)
            ->orderBy("requerimiento_cantidato.requerimiento_id", "asc")
            ->first();
        }

        //Calcular edad de candidatos.
        $anios = ($datos_basicos->fecha_nacimiento != 0 && $datos_basicos->fecha_nacimiento != "") ? Carbon::parse($datos_basicos->fecha_nacimiento)->age : "";

        $lugarnacimiento = null;
        $lugarexpedicion = null;
        $lugarresidencia = null;

        if($datos_basicos != null) {
            $lugarnacimiento = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_nacimiento)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_nacimiento)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_nacimiento)
            ->first();

            $lugarexpedicion = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais", $datos_basicos->pais_id)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_id)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_id)
            ->first();

            $lugarresidencia = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select(\DB::raw("CONCAT(ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_residencia)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_residencia)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_residencia)
            ->first();
        }

        $experiencias = Experiencias::leftjoin("paises", "paises.cod_pais", "=", "experiencias.pais_id")
        ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
        ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
        ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
        ->leftjoin("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
            ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
        })->leftjoin("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
            ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
        })->where("experiencias.user_id", $user_id)
        ->select("aspiracion_salarial.descripcion as salario", "cargos_genericos.descripcion as desc_cargo", "motivos_retiros.descripcion as desc_motivo", \DB::raw("CONCAT(ciudad.nombre) AS ciudades"), "experiencias.*")
        ->orderBy("experiencias.fecha_inicio", "desc")
        ->get();

        $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        ->leftjoin("departamentos", function ($join){
            $join->on("departamentos.cod_pais", "=", "estudios.pais_estudio")
            ->on("departamentos.cod_departamento", "=", "estudios.departamento_estudio");
        })->leftjoin("ciudad", function($join2){
            $join2->on("ciudad.cod_pais", "=", "estudios.pais_estudio")
            ->on("ciudad.cod_ciudad", "=", "estudios.ciudad_estudio")
            ->on("ciudad.cod_departamento", "=", "estudios.departamento_estudio");
        })
        ->select("estudios.*","niveles_estudios.descripcion as desc_nivel")
        ->where("estudios.user_id", $user_id)
        ->get();

        $referencias = ReferenciasPersonales::leftjoin("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->leftjoin("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->leftjoin("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->leftjoin("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
            ->where("referencias_personales.user_id", $user_id)
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudades"), "tipo_relaciones.descripcion as desc_tipo", "referencias_personales.*")
            ->get();

        $familiares = GrupoFamilia::leftjoin("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftjoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->join("tipo_relaciones", "tipo_relaciones.id", "=", "grupos_familiares.parentesco_id")
            ->leftjoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select("grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "tipo_relaciones.descripcion as parentesco", "generos.descripcion as genero", \DB::raw("CONCAT(grupos_familiares.nombres,' ',grupos_familiares.primer_apellido,' ',grupos_familiares.segundo_apellido) AS nombres_familiar"))
            ->where("grupos_familiares.user_id", $user_id)
            ->orderBy("tipo_relaciones.id", "ASC")
            ->get();

        $experienciaMayorDuracion = Experiencias::leftjoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")->
            select(\DB::raw(" *, (TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) AS dias, (user_id) AS usuario"),'fecha_final','fecha_inicio',"aspiracion_salarial.descripcion AS salario",'salario_devengado')
            ->where("user_id", $user_id)
            ->havingRaw("dias >= (SELECT MAX(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) FROM experiencias as e WHERE e.user_id = experiencias.user_id)")
            ->first();

        $experienciaActual = Experiencias::leftjoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            ->where("experiencias.user_id", $user_id)
            ->select("aspiracion_salarial.descripcion as salario", "experiencias.*")
            ->orderBy("experiencias.fecha_inicio", "DESC")
            ->first();

        $conyuge = GrupoFamilia::join("tipo_relaciones", "tipo_relaciones.id", "=", "grupos_familiares.parentesco_id")
            ->select("grupos_familiares.*","tipo_relaciones.descripcion as parentesco",\DB::raw("CONCAT(grupos_familiares.nombres,' ',grupos_familiares.primer_apellido,' ',grupos_familiares.segundo_apellido) AS nombres_familiar"))
            ->where("grupos_familiares.user_id", $user_id)
            ->where("grupos_familiares.parentesco_id",1)
            ->first();

        $padres = GrupoFamilia::join("tipo_relaciones", "tipo_relaciones.id", "=", "grupos_familiares.parentesco_id")
            ->select("grupos_familiares.*","tipo_relaciones.descripcion as parentesco",\DB::raw("CONCAT(grupos_familiares.nombres,' ',grupos_familiares.primer_apellido,' ',grupos_familiares.segundo_apellido) AS nombres_familiar"))
            ->where("grupos_familiares.user_id", $user_id)
            ->whereIn("grupos_familiares.parentesco_id",[3,4])
            ->groupBy("grupos_familiares.parentesco_id")
            ->orderBy("tipo_relaciones.id", "ASC")
            ->get();

        $idiomas = IdiomaUsuario::where("id_usuario",$user_id)->get();

        $autoentrevista = '';

        if(route("home") == "https://gpc.t3rsc.co") {
            $autoentrevista = Autoentrevist::where('id_usuario',$user->id)->first();

            $experiencias_gpc = Experiencias::leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
            ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            ->where("experiencias.user_id", $user_id)
            ->select(
                "aspiracion_salarial.descripcion as salario",
                "cargos_genericos.descripcion as desc_cargo", 
                "motivos_retiros.descripcion as desc_motivo",
                "experiencias.*"
            )
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->orderBy("experiencias.empleo_actual", "asc")
            ->get();

            $view = \View::make('admin.hoja_vida_pdf', compact(
                'idiomas',
                'datos_basicos',
                'anios',
                'user',
                "lugarresidencia",
                'lugarnacimiento',
                "lugarexpedicion",
                "experiencias_gpc",
                "estudios",
                "referencias",
                "familiares",
                "archivo",
                "conyuge",
                "padres",
                "logo",
                'autoentrevista',
                'reqcandidato'
            ))->render();

            $pdf  = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);

            return $pdf->stream('hoja_de_vida.pdf');
        }else{
            $view = \View::make('admin.hoja_vida_pdf', compact('idiomas','datos_basicos','anios','user',"lugarresidencia",'lugarnacimiento',"lugarexpedicion","experiencias","estudios","referencias","familiares","archivo","conyuge","padres","logo",'autoentrevista','reqcandidato'))->render();

            $pdf  = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);

            return $pdf->stream('hoja_de_vida.pdf');
        }
    }
    
    public function hv_longlist(Request $data)
    {
        $user = $data->req_candidato;

        $dato_basicos = DatosBasicos::join("requerimiento_cantidato","requerimiento_cantidato.candidato_id","=","datos_basicos.user_id")
        ->join("users","users.id","=","datos_basicos.user_id")
        ->leftJoin("generos","generos.id","=","datos_basicos.genero")
        ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
        ->leftJoin("autoentrevista_cand", "autoentrevista_cand.id_usuario", "=", "datos_basicos.user_id")
        //->leftJoin("experiencias", "experiencias.user_id", "=", "datos_basicos.user_id")
        //->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
        //->leftJoin("estudios","estudios.user_id", "=","datos_basicos.user_id")
        //->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
        ->whereIn("requerimiento_cantidato.id",$user)
        ->select("datos_basicos.*", "generos.descripcion as genero_desc",  "estados_civiles.descripcion as estado_civil_des", "users.foto_perfil", "users.avatar", 'autoentrevista_cand.*')
        ->groupBy('datos_basicos.user_id')->get();
        //->get();
        //->split(4)->toArray();
        //->get();

        $requerimiento = Requerimiento::find($data->req_id);

        $view = \View::make('admin.hoja_vida_longlist', compact('dato_basicos','requerimiento'))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->setPaper('A3','landscape');
        $pdf->loadHTML($view);
       
        return $pdf->stream('cuadrodepreseleccion.pdf');
    }

    public function longlist_excel(Request $data)
    {
        $user = $data->req_candidato;

        $dato_basicos = DatosBasicos::join("requerimiento_cantidato","requerimiento_cantidato.candidato_id","=","datos_basicos.user_id")
        ->join("users","users.id","=","datos_basicos.user_id")
        ->leftJoin("generos","generos.id","=","datos_basicos.genero")
        ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
        ->leftJoin("autoentrevista_cand", "autoentrevista_cand.id_usuario", "=", "datos_basicos.user_id")
        //->leftJoin("experiencias", "experiencias.user_id", "=", "datos_basicos.user_id")
        //->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
        //->leftJoin("estudios","estudios.user_id", "=","datos_basicos.user_id")
        //->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
        ->whereIn("requerimiento_cantidato.id",$user)
        ->select("datos_basicos.*","generos.descripcion as genero_desc", "estados_civiles.descripcion as estado_civil_des","users.foto_perfil","users.avatar",'autoentrevista_cand.*')
        ->groupBy('datos_basicos.user_id')->get();
        //->get();
        //->split(4)->toArray();
        //->get();

        $requerimiento = Requerimiento::find($data->req_id);
        
        /*
            Excel::create('hoja_vida_longlist', function ($excel) use ($datos_basicos,$requerimiento){
            $excel->setTitle('Hoja de Vida Longlist');
            $excel->setCreator('hoja')
                  ->setCompany('hoja');
            $excel->setDescription('Hoja de Vida Longlist');
            $excel->sheet('Hoja de Vida Longlist', function ($sheet) use ($datos_basicos,$requerimiento){
              $sheet->setOrientation("landscape");
              $sheet->loadView('admin.hoja_vida_longlist', compact('datos_basicos','requerimiento'));
            });
            })->export('xls');
        */

        //long list en formato excell funciona
        Excel::create('hoja_vida_longlist', function ($excel) use ($dato_basicos,$requerimiento){
            // for($i = 0; $i < (int)$hojas; $i++){
            $i = 0;

            foreach($dato_basicos->chunk(4) as $datos_basicos){
                $i++;
                $excel->sheet('Hoja'.$i, function($sheet) use ($datos_basicos, $requerimiento, $i){
                    $sheet->setOrientation("landscape");
                    $sheet->setTitle('pagina'.$i);
                    
                    // Font family
                    $sheet->setFontFamily('Times New Roman');
                    $sheet->setFontSize(8);
                    $sheet->getStyle('B')->getAlignment()->setWrapText(true);
                    $sheet->setWidth('A',20);
                    $sheet->freezeFirstColumn();
                    //$sheet->setHeight(array(7,8,9,10,11,12,13,14,15,16,17,18,19,20),40);
                    
                    // Font size
                    // $sheet->setAllBorders('thin');
                    //$sheet->setSize('A1:A25',15,25);
                    
                    #Borders
                    //$sheet->getRowDimension(1)->setRowHeight(10);
                    //$sheet->setSize('A',[25,18]);
                    //$sheet->setHeight('A',5);
                    //$datos_basicos = $dato_basicos;
                    $sheet->loadView('admin.excel_longlist', compact('datos_basicos','requerimiento'));
                });
            }
        })
        ->export('xls');

        //  $view = \View::make('admin.hoja_vida_longlist', compact('dato_basicos','requerimiento'))->render();
        //$pdf = \App::make('dompdf.wrapper');
        // $pdf->setPaper('A3','landscape');
        // $pdf->loadHTML($view);
       
        // return $pdf->stream('Informe_Longlist.pdf');
    }

    public function validaProcesoCompletos($candidato_req)
    {
        $procesoInconclusos = RegistroProceso::where("requerimiento_candidato_id", $candidato_req)
        ->whereIn("proceso", [
            "ENVIO_DOCUMENTOS",
            "ENVIO_ENTREVISTA",
            "ENVIO_REFERENCIACION",
            "ENVIO_VALIDACION",
            "ENVIO_SST",
            //"ENVIO_EXAMENES",
            "ENVIO_PRUEBAS",
            "ENVIO_DOCUMENTOS_PENDIENTE",
            "ENVIO_ENTREVISTA_PENDIENTE",
            "ENVIO_REFERENCIACION_PENDIENTE",
            "ENVIO_EXAMENES_PENDIENTE",
            "ENVIO_PRUEBAS_PENDIENTE",
        ])
        ->whereRaw("( apto IS NULL OR apto = 2 )")
        ->get();

        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $candidato_req)
        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
        ->first();

        if ($procesoInconclusos->count() > 0) {
            return ["success" => true, "view" => view("admin.reclutamiento.modal.proceso_no_concluido", compact("candidato", "procesoInconclusos"))];
        }

        return ["success" => false];
    }

    public function enviar_contratar2_req(Request $data)
    {
        $validarProcesos = $this->validaProcesoCompletos($data->get("candidato_req"));

        if($validarProcesos["success"]) {
            return $validarProcesos["view"];
        }

        $contra_clientes = RegistroProceso::select('procesos_candidato_req.*')
        ->where('procesos_candidato_req.id', $data->contra_cliente)
        ->first();

        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->join('requerimientos', 'requerimientos.id', "=", 'requerimiento_cantidato.requerimiento_id')
        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato", "requerimiento_cantidato.requerimiento_id")
        ->first();

        //VERIFICAR SI SE HA ENVIADO A APROBAR POR EL CLIENTE Y SI YA SE APROBO
        $proceso  = RegistroProceso::where("requerimiento_candidato_id", $data->GET("candidato_req"))->where("proceso", "ENVIO_APROBAR_CLIENTE")->first();
        $proceso2 = RegistroProceso::where("requerimiento_candidato_id", $data->GET("candidato_req"))->where("proceso", "ENVIO_CONTRATACION")->first();
        $mensaje  = 'Desea enviar a contratacion a este candidato?';
        $btn      = true;

        if ($proceso != null && $proceso->apto == "") {
            $mensaje = "Este candidato esta a la espera de recibir la aprobación por parte del cliente para poder ser enviado a contratar.";
            $btn     = false;
        }

        if ($proceso != null && $proceso->apto == 2) {
            $mensaje = "Este candidato NO ha sido aprobado por el cliente..";
            $btn     = false;
        }

        if ($proceso2 != null && $proceso->apto == 1) {
            $mensaje = "Este candidato ya ha sido enviado a contratar.";
            $btn     = false;
        }

        //USUARIOS CLIENTES
        $usuarios_clientes = ["" => "Seleccion"] + EloquentUser::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
        ->where("users_x_clientes.cliente_id", $data->cliente_id)->pluck("users.name", "users.id")
        ->toArray();

        return view("admin.reclutamiento.modal.enviar_contratacion", compact("contra_clientes", "candidato", "mensaje", "proceso", "proceso2", "btn", "usuarios_clientes"));
    }

    //Modal de envío a contratar 2
    public function enviar_contratar2(Request $data)
    {
        $req_can_id = [];
        $candi_no_cumplen = null;
        $req_candi_id = $data->candidato_req;
        $fecha_hoy = Carbon::now();
        $newEndingDate = "";

        $caja_compensaciones = [];
        $fondo_cesantias = [];
        $bancos = [];
        $dato_contrato = null;
        $requerimiento = null;
        $contra_clientes = null;
        $sitio = Sitio::first();
        $sitioModulo = SitioModulo::first();

        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            ->where("requerimiento_cantidato.id", $req_candi_id)
            ->select(
                "datos_basicos.*",
                "tipo_identificacion.cod_tipo as cod_tipo_identificacion",
                "requerimiento_cantidato.id as req_candidato",
                "requerimiento_cantidato.requerimiento_id as req"
            )
        ->first();

        //Validar si el requerimiento esta cerrado
        $estadoReq = EstadosRequerimientos::where("req_id", $candidato->req)
        //->where("estado", config('conf_aplicacion.C_TERMINADO'))
        ->orderBy('created_at', 'DESC')
        ->first();

        if($estadoReq != null || $estadoReq != ''){
            if($estadoReq->estado == config('conf_aplicacion.C_TERMINADO') || $estadoReq->estado === config('conf_aplicacion.C_TERMINADO')){
                $candidato->observacion_no_cumple = 'El requerimiento esta terminado.';
                $candi_no_cumplen = $candidato;
                $candidato = null;
            }
        }

        if ($candidato != null) {
            $num_candidatos = Requerimiento::select('num_vacantes')->find($candidato->req);
            //$num_candidatos            = $candidado->num_vacantes;
            $candidatos_contratados    = 0;

            //CONSULTAR CANDIDATOS ENVIADOS
            $candidatos_req = User::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
            ->where("requerimiento_cantidato.requerimiento_id", $candidato->req)
            ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
            ->whereRaw(" requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
            ->select(
                "datos_basicos.id",
                "estados.id as estado_id",
                "estados.descripcion as estado_candidatos",
                "requerimiento_cantidato.id as req_candidato_id"
            )
            ->get();

            foreach ($candidatos_req as $key => $value) {
                //Valida la contratación cancelada
                if($value->estado_id != 24){
                    if ($value->estado_id == config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') || $value->estado_id == config('conf_aplicacion.C_CONTRATADO')) {
                        $candidatos_contratados++;
                    }
                }
            }

            //VERIFICAR SI EL REQUERIMIENTO ALCANZO EL LIMITE DE CANDIDATOS CONTRATADOS
            if ($candidatos_contratados == $num_candidatos->num_vacantes) {
                //logger('candidatos maximos');
                $candidato->observacion_no_cumple = 'Se alcanzó el limite de vacantes para el requerimiento.';
                $candi_no_cumplen = $candidato;
                $candidato = null;
            }
        }

        if ($candidato != null && $sitio->asistente_contratacion == 1) {
            if ($candidato->tipo_id == null || $candidato->direccion == null || $candidato->entidad_eps == null || $candidato->entidad_afp == null || $candidato->fecha_expedicion == null || $candidato->fecha_nacimiento == null || $candidato->ciudad_expedicion_id == null) {
                $candidato->observacion_no_cumple = "El candidato debe completar los datos Tipo de documento, Dirección, Eps, Afp, Fecha de expedición documento, Fecha de nacimiento, Lugar de residencia, Teléfono, Lugar expedición";
                $candi_no_cumplen = $candidato;
                $candidato = null;
            }
        }

        if ($candidato != null) {
            $requerimiento = Requerimiento::leftjoin('centros_costos_produccion', 'centros_costos_produccion.id', '=', 'requerimientos.centro_costo_id')
                ->where('requerimientos.id', $candidato->req)
                ->select(
                    'requerimientos.*',
                    'centros_costos_produccion.descripcion as centro_costos'
                )
            ->first();

            if ($requerimiento->tipo_proceso_id != $sitio->id_proceso_sitio) {
                $procesoInconclusos = RegistroProceso::where("requerimiento_candidato_id", $req_candi_id)
                    ->whereIn("proceso", [
                        "ENVIO_DOCUMENTOS",
                        "ENVIO_ENTREVISTA",
                        "ENVIO_REFERENCIACION",
                        "ENVIO_VALIDACION",
                        "ENVIO_SST",
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
                        "ENVIO_REFERENCIACION_PENDIENTE",
                        "ENVIO_PRUEBAS_PENDIENTE",
                    ])
                    ->whereRaw("( apto IS NULL OR apto = 2 )")
                ->get();
            }

            if ($procesoInconclusos->count() > 0) {
                $candi_no_cumplen = $candidato;
                $candi_no_cumplen->observacion_no_cumple = "El candidato tiene procesos activos inconclusos.";
                $candi_no_cumplen->procesos_inconclusos = $procesoInconclusos;
                $candidato = null;
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
                    $candi_no_cumplen = $candidato;
                    $candidato = null;
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
                        $candi_no_cumplen = $candidato;
                        $candidato = null;
                    }
                }
            }
        }
        if ($candidato != null) {
            $examenes_no_apto = RegistroProceso::where("requerimiento_candidato_id", $req_candi_id)
                ->whereIn("proceso", [
                    "ENVIO_EXAMENES"
                ])
                ->whereRaw("( apto=0 OR apto = 2 )")
                ->orderby("id","DESC")
            ->first();

            if (count($examenes_no_apto) > 0) {
                $candi_no_cumplen = $candidato;
                $candi_no_cumplen->observacion_no_cumple = "Candidato no apto en examenes médicos.";
                //$candi_no_cumplen->procesos_inconclusos = $procesoInconclusos;
                $candidato = null;
            }

        }
        
        if ($candidato != null) {
            //si hay candidato para enviar al modal para contratar;
            if($sitio->precontrata && $requerimiento->contratacion_directa){
                $contra_clientes = RegistroProceso::select('procesos_candidato_req.*')
                ->where('procesos_candidato_req.candidato_id', $data->user_id)
                ->where('procesos_candidato_req.proceso', 'PRE_CONTRATAR')
                ->where('procesos_candidato_req.requerimiento_id', $data->req_id)
                ->orderBy('procesos_candidato_req.id', 'desc')
                ->first();
            }
            else{
                $contra_clientes = RegistroProceso::select('procesos_candidato_req.*')
                ->where('procesos_candidato_req.candidato_id', $data->user_id)
                ->where('procesos_candidato_req.proceso', 'ENVIO_CONTRATACION_CLIENTE')
                ->where('procesos_candidato_req.requerimiento_id', $data->req_id)
                ->orderBy('procesos_candidato_req.id', 'desc')
                ->first();
            }
            /*$requerimiento = Requerimiento::leftjoin('centros_costos_produccion', 'centros_costos_produccion.id', '=', 'requerimientos.centro_costo_id')
                ->where('requerimientos.id', $candidato->req)
                ->select(
                    'requerimientos.*',
                    'centros_costos_produccion.descripcion as centro_costos'
                )
            ->first();*/

            $centro_costo = CentroCostoProduccion::join('requerimientos','requerimientos.centro_costo_id','=','centros_costos_produccion.id')
                ->select('centros_costos_produccion.descripcion as centro_costo')
                ->where('requerimientos.id',$candidato->req)
            ->first();

            $centros_costos = ["" => "Seleccionar"] + CentroCostoProduccion::where("cod_division", $data->cliente_id)->orderBy('descripcion')->pluck("descripcion", "id")->toArray();

            $usuarios_clientes = ["" => "Seleccion"] + EloquentUser::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
                ->where("users_x_clientes.cliente_id", $data->cliente_id)
                ->orderBy('users.name')->pluck("users.name", "users.id")
            ->toArray();

            $eps = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->orderBy('descripcion')->pluck("descripcion", "id")->toArray();

            $afp = ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->orderBy('descripcion')->pluck("descripcion", "id")->toArray();

            $caja_compensaciones = ["" => "Seleccionar"] + CajaCompensacion::orderBy('descripcion')->pluck("descripcion", "id")->toArray();

            $fondo_cesantias = ["" => "Seleccionar"] + FondoCesantias::orderBy('descripcion')->pluck("descripcion", "id")->toArray();
         
            $bancos = ["" => "Seleccionar"] + Bancos::orderBy('nombre_banco')->pluck("nombre_banco", "id")->toArray();

            $dato_contrato = DatosBasicos::join("requerimiento_cantidato","datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
            ->join("users", "users.id","=","requerimiento_cantidato.candidato_id")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->leftJoin("bancos", "bancos.id", "=", "datos_basicos.nombre_banco")
            ->leftJoin("caja_compensacion", "caja_compensacion.id", "=", "datos_basicos.caja_compensaciones")
            ->leftJoin("fondo_cesantias", "fondo_cesantias.id", "=", "datos_basicos.fondo_cesantias")
            ->where("requerimiento_cantidato.requerimiento_id", $candidato->req)
            ->where("datos_basicos.user_id", $candidato->user_id)
            ->where('procesos_candidato_req.proceso','ENVIO_CONTRATACION_CLIENTE')
            ->groupBy('procesos_candidato_req.candidato_id')
            ->orderBy('requerimiento_cantidato.id')
            ->select(
                "datos_basicos.*",

                "entidades_afp.descripcion as entidades_afp_des",
                "entidades_eps.descripcion as entidades_eps_des",

                "fondo_cesantias.descripcion as fondo_cesantia_des",

                "caja_compensacion.descripcion as caja_compensacion_des",

                "bancos.nombre_banco as nombre_banco_des",

                "procesos_candidato_req.observaciones",
                "procesos_candidato_req.fecha_ingreso_contra",
                "procesos_candidato_req.fecha_inicio_contrato",
                "procesos_candidato_req.hora_entrada",
                "procesos_candidato_req.fecha_fin_contrato",
                "procesos_candidato_req.centro_costos",
                "procesos_candidato_req.fecha_ultimo_contrato",
                "procesos_candidato_req.user_autorizacion",

                'requerimiento_cantidato.auxilio_transporte',
                'requerimiento_cantidato.tipo_ingreso'
            )
            ->first();

            $fecha_hoy = Carbon::now();
            $fecha_hoy = $fecha_hoy->format('Y/m/d');

            $newEndingDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($requerimiento->fecha_ingreso)) . " + 365 day"));

            //Adicionales
            $adicionales = [];
            if ($sitioModulo->generador_variable == 'enabled') {
                if($sitio->asistente_contratacion == 1) {
                    $adicionales = CargoDocumentoAdicional::where('cargo_id', $requerimiento->cargo_especifico_id)
                    ->where('active', 1)
                    ->get();
                }
            }
        }
    
        return view("admin.reclutamiento.modal.enviar_contratacion_new", compact(
            "fecha_hoy",
            "candidato",
            "usuarios_clientes",
            "contra_clientes",
            "requerimiento",
            "eps",
            "afp",
            "caja_compensaciones",
            "fondo_cesantias",
            "bancos",
            "dato_contrato",
            "newEndingDate",
            "centros_costos",
            "candi_no_cumplen",
            "adicionales"
        ));
    }

    public function crear_observacion(Request $data)
    {    
        $user_id = $this->user->id;
        $candidato_req = $data->candidato_req;

        $observacion = ObservacionesCandidato::join('users','users.id','=','observaciones_candidato.user_gestion')
        ->select('observaciones_candidato.*','users.name as nombre')
        ->where('req_can_id',$data->candidato_req)
        ->get();

        if(!is_null($observacion)) {
            if(!$data->has("modulo")) {
                 foreach($observacion as $obs) {
                    $obs->visto = 1;
                    $obs->save();
                }
            }
        }

        //USUARIOS CLIENTES
        return view("req.crear_observacion", compact("observacion", "contra_clientes", "candidato_req"));
    }

    public function crear_cita_cliente(Request $data)
    {
        //$user_id = $this->user->id;
        $candidato_req = $data->get('candidato_req');
        $req_id = $data->get('req_id');
        $user_id = $data->get('user_id');

        $citas = Citacion::where('req_candi_id', $candidato_req)->where('motivo_id', 13)->get();

        /*$userData = ReqCandidato::join('datos_basicos', 'datos_basicos.user_id', '=', 'requerimiento_cantidato.candidato_id')
        ->where('requerimiento_cantidato.id', $citas->req_candi_id)
        ->select('datos_basicos.telefono_movil', 'requerimiento_cantidato.requerimiento_id')
        ->first();*/

        return view("req.citar_cliente_view", compact("candidato_req", "req_id", "user_id", "citas"));
    }

    public function guardar_cita_cliente(Request $data)
    {
        $req_cand = $data->get('candidato_req');

        $req_id = $data->get('req_id');
        $user_id = $data->get('user_id');

        $nueva_cita = new Citacion();

        $nueva_cita->req_candi_id     = $req_cand;
        $nueva_cita->motivo_id        = 13;
        $nueva_cita->observaciones    = $data->get('observacion_cita');
        $nueva_cita->fecha_cita       = $data->get('fecha_cita');
        $nueva_cita->estado           = 0;
        $nueva_cita->save();
        
        $nuevoProceso = new RegistroProceso();

        $nuevoProceso->requerimiento_candidato_id = $req_cand;
        $nuevoProceso->estado                     = 8;
        $nuevoProceso->proceso                    = 'ENVIO_CITA_POR_CLIENTE';
        $nuevoProceso->usuario_envio              = $this->user->id;
        $nuevoProceso->requerimiento_id           = $data->get('req_id');
        $nuevoProceso->candidato_id               = $data->get('user_id');
        $nuevoProceso->save();

        $psicologoEmail = RegistroProceso::join('users', 'users.id', '=', 'procesos_candidato_req.usuario_envio')
        ->select('users.email', 'users.id')
        ->where('procesos_candidato_req.candidato_id', $user_id)->where('procesos_candidato_req.proceso', 'ENVIO_APROBAR_CLIENTE')
        ->orderBy('procesos_candidato_req.created_at', 'desc')
        ->first();

        $cliente = User::where('id', $this->user->id)->pluck('name');

        $nameCand = User::where('id', $user_id)->pluck('name');

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Notificación de Cita"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "
                    Tu cliente <b>{$cliente}</b> ha programado una cita para el candidato <b>{$nameCand}</b> en el requerimiento $req_id.  
                    <br/><br/>
                    Debes ingresar a los procesos del candidato para notificarlo a través del asistente virtual.";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'GESTIONAR CITA', 'buttonRoute' => route('admin.gestion_requerimiento',['id' => $req_id])];

        $mailUser = $psicologoEmail->id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($psicologoEmail, $req_id) {

                    $message->to([$psicologoEmail->email], "T3RS");
                    $message->subject("Candidato citado por cliente Req No. $req_id")
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

        return response()->json(["success" => true, "email" => $psicologoEmail->email]);
    }

    public function ver_observacion(Request $data)
    {
        $observacion = ObservacionesCandidato::join('users', 'users.id', '=', 'observaciones_candidato.user_gestion')
        ->select('observaciones_candidato.*','users.name as nombre')
        ->where('req_can_id',$data->req_can_id)
        ->orderBy('observaciones_candidato.created_at','desc')
        ->get();

        //Ultimo en ver observación
        if(route("home") == "http://desarrollo.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co" ||
            route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co"){
            foreach ($observacion as $value) {
                $value->ultima_vista = $this->user->id;
                $value->save();  //guarda el ultimo q la consulto
            }
        }
        
        foreach($observacion as $value) {
            $value->visto = 1;
            $value->save();  //guarda el ultimo q la consulto
        }

        //USUARIOS CLIENTES
        return view("admin.reclutamiento.modal.ver_observacion", compact("observacion", "contra_clientes", "candidato_req"));
    }

    public function enviar_contratar_req(Request $data)
    {
        $user_id = $this->user->id;
       
        $contra_clientes = RegistroProceso::select('procesos_candidato_req.*')
        ->where('procesos_candidato_req.candidato_id', $data->user_id)
        ->where('procesos_candidato_req.proceso', 'ENVIO_CONTRATACION_CLIENTE')
        ->where('procesos_candidato_req.requerimiento_id', $data->req_id)
        ->orderBy('procesos_candidato_req.id', 'desc')
        ->first();

        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join('requerimientos', 'requerimientos.id', "=", 'requerimiento_cantidato.requerimiento_id')
        ->join('tipo_identificacion', 'tipo_identificacion.id', '=', 'datos_basicos.tipo_id')
        ->where("requerimiento_cantidato.candidato_id", $data->user_id)
        ->where("requerimiento_cantidato.id", $data->candidato_req)
        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato", "requerimiento_cantidato.requerimiento_id","tipo_identificacion.cod_tipo as tipo_id_desc")
        ->first();

        //VERIFICAR SI SE HA ENVIADO A APROBAR POR EL CLIENTE Y SI YA SE APROBO
        $proceso  = RegistroProceso::where("requerimiento_candidato_id", $data->GET("candidato_req"))->where("proceso", "ENVIO_APROBAR_CLIENTE")->first();

        $proceso2 = RegistroProceso::where("requerimiento_candidato_id", $data->GET("candidato_req"))->where("proceso", "ENVIO_CONTRATACION")->first();

        $requerimiento = Requerimiento::find($candidato->requerimiento_id);

        $mensaje  = 'Desea enviar a contratacion a este candidato?';

        //USUARIOS CLIENTES

        $usuarios_clientes = ["" => "Seleccion"] + EloquentUser::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
        ->where("users_x_clientes.cliente_id", $data->cliente_id)
        ->pluck("users.name", "users.id")
        ->toArray();

        $caja_compensaciones = [];
        $fondo_cesantias = [];
        $bancos = [];
        $dato_contrato = "";

        $eps = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->pluck("descripcion", "id")->toArray();

        $afp = ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->pluck("descripcion", "id")->toArray();

        $centros_costos = ["" => "Seleccionar"] + CentroCostoProduccion::where("cod_division", $data->cliente_id)->pluck("descripcion", "id")->toArray();

        if(route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" ||
            route("home") == "http://localhost:8000" || route("home") == "http://desarrollo.t3rsc.co" ||
            route("home") == "https://desarrollo.t3rsc.co" || route("home") == "https://pruebaslistos.t3rsc.co" ||
            route("home") == "https://listos.t3rsc.co" || route("home") == "https://vym.t3rsc.co"){

            $caja_compensaciones = ["" => "Seleccionar"] + CajaCompensacion::pluck("descripcion", "id")->toArray();

            $fondo_cesantias = ["" => "Seleccionar"] + FondoCesantias::pluck("descripcion", "id")->toArray();
         
            $bancos = ["" => "Seleccionar"] + Bancos::pluck("nombre_banco", "id")->toArray();

            $dato_contrato = DatosBasicos::join("requerimiento_cantidato","datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
            ->join("users", "users.id","=","requerimiento_cantidato.candidato_id")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->leftJoin("bancos", "bancos.id", "=", "datos_basicos.nombre_banco")
            ->leftJoin("caja_compensacion", "caja_compensacion.id", "=", "datos_basicos.caja_compensaciones")
            ->leftJoin("fondo_cesantias", "fondo_cesantias.id", "=", "datos_basicos.fondo_cesantias")
            ->where("requerimiento_cantidato.requerimiento_id",$candidato->requerimiento)
            ->where("datos_basicos.user_id",$candidato->user_id)
            ->whereIn('procesos_candidato_req.proceso',['ENVIO_CONTRATACION_CLIENTE','ENVIO_CONTRATACION'])
            ->groupBy('procesos_candidato_req.candidato_id')
            ->orderBy('requerimiento_cantidato.id')
            ->select(
                "datos_basicos.*",
                "entidades_afp.descripcion as entidades_afp_des",
                "entidades_eps.descripcion as entidades_eps_des",
                "fondo_cesantias.descripcion as fondo_cesantia_des",
                "caja_compensacion.descripcion as caja_compensacion_des",
                "bancos.nombre_banco as nombre_banco_des",
                "procesos_candidato_req.fecha_inicio_contrato",
                "procesos_candidato_req.hora_entrada",
                "procesos_candidato_req.fecha_fin_contrato",
                "procesos_candidato_req.fecha_ultimo_contrato",
                'requerimiento_cantidato.auxilio_transporte',
                'requerimiento_cantidato.tipo_ingreso'
            )
            ->first();
        }

        return view("req.enviar_contratacion_req_new", compact(
            "user_id",
            "contra_clientes",
            "candidato",
            "mensaje",
            "proceso",
            "proceso2",
            "btn",
            "usuarios_clientes",
            "requerimiento",
            "caja_compensaciones",
            "fondo_cesantias",
            "bancos",
            "dato_contrato",
            "eps",
            "afp",
            "dato_contrato",
            "centros_costos"
        ));
    }

    public function enviar_a_contratar_cliente(Request $data)
    {
        $rules = [];
        $rules += [
            "fecha_inicio_contrato" => "required|date",
            // "fecha_fin_contrato"    => "required|date",
            // "observaciones"         => "required",
            "user_autorizacion"     => "required",
        ];

        $validar = Validator::make($data->all(), $rules);

        if ($validar->fails()) {
            return response()->json(["success" => false, "view" => $this->enviar_contratar2($data)->withErrors($validar)->render()]);
        }

        $req = \App\Models\RegistroProceso::where("proceso", "ENVIO_APROBAR_CLIENTE")
        ->where("requerimiento_candidato_id", $data->candidato_req)
        ->first();

        $req->apto                  = 1;
        $req->save();
        
        $usuario_envio = User::find($req->usuario_envio);
        $candidato = User::find($req->candidato_id);

        $fecha_hoy = Carbon::now();
        $fecha_hoy = $fecha_hoy->format('Y-m-d');

        $estado = new \App\Models\RegistroProceso();
        $estado->requerimiento_candidato_id = $req->requerimiento_candidato_id;
        $estado->requerimiento_id      = $req->requerimiento_id;
        $estado->apto                  = 1;
        $estado->estado                = 8;
        $estado->observaciones         = $data->get("observaciones");
        $estado->fecha_inicio_contrato = $data->get("fecha_inicio_contrato");
        $estado->fecha_inicio          = $fecha_hoy;
        
        // $estado->fecha_fin_contrato    = $data->get("fecha_fin_contrato");

        $estado->centro_costos        = $data->get("centro_costos");
        $estado->candidato_id         = $req->candidato_id;
        $estado->user_autorizacion    = $data->get("user_autorizacion");
        $estado->proceso              = "ENVIO_CONTRATACION_CLIENTE";
        $estado->usuario_terminacion  = $this->user->id;
        $estado->save();

        $requerimiento = Requerimiento::join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
            ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->leftjoin("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->select('requerimientos.*', 'cargos_especificos.descripcion as cargo_especifico', 'clientes.nombre as nombre_cliente')
            ->find($req->requerimiento_id);

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Aprobación"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "
                    Hola {$usuario_envio->name} te informamos que el cliente {$requerimiento->nombre_cliente} ha aprobado al candidato {$candidato->name}, enviado en el requerimiento {$requerimiento->id}. Haz clic en el siguiente botón para gestionar.";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'Ir a gestionar', 'buttonRoute' => route('admin.gestion_requerimiento', ["req_id" => $requerimiento->id])];

        $mailUser = $candidato->id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($usuario_envio,$req) {

                $message->to($usuario_envio->email, "T3RS")
                        ->subject("Candidato aprobado Req No. $req->requerimiento_id")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

        if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co" || route('home') == "http://localhost:8000"){
            $req_can = ReqCandidato::find($data->candidato_req);
            $requerimiento = Requerimiento::find($req_can->requerimiento_id);
            $AsignacionPsicologo = AsignacionPsicologo::where("req_id",$req_can->requerimiento_id)
            ->orderBy("asignacion_psicologo.id","DESC")
            ->first();

            $psicologo = User::find($AsignacionPsicologo->psicologo_id);
            $user_envio = User::find($requerimiento->solicitud->user_id);

            Mail::send('admin.email-info-aprobacion-2', [
                'candidato'      => $candidato,
                'req'      => $req
            ], function ($message) use ($user_envio, $requerimiento,$psicologo) {
                $message->to([$user_envio->email,'javier.chiquito@t3rsc.co',$psicologo->email], "T3RS")
                //$message->to([$user_envio->email,'juli.gzulu@gmail.com','javier5chiquito@gmail.com'], "T3RS")
                ->subject("Candidato aprobado Req # $requerimiento->id")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

        }

        return response()->json(["success" => true, 'candidato_req' => $data->get("candidato_req")]);
    }

    //PARA RECHAZAR
    public function rechazar_candidato_cliente(Request $data)
    {
        $rules = [];
        $rules += [
            "motivo_rechazo" => "required",
            // "fecha_fin_contrato"    => "required|date",
            //"observaciones"         => "required"
        ];

        $validar = Validator::make($data->all(), $rules);

        if($validar->fails()) {
            //return response()->json(["success" => false, "view" => $this->enviar_contratar($data)->withErrors($validar)->render()]);
        }

        $req = \App\Models\RegistroProceso::where("proceso", "ENVIO_APROBAR_CLIENTE")
        ->where("requerimiento_candidato_id", $data->candidato_req)
        ->orderBy("procesos_candidato_req.id","DESC")
        ->first();
      
        $req->apto                  = 0;
        $req->motivo_rechazo_id     =$data->motivo_rechazo;
        $req->usuario_terminacion  = $this->user->id;
        $req->observaciones=$data->observaciones;
        $req->save();


        if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co"){
            $req_can = ReqCandidato::find($data->candidato_req);
            $requerimiento = Requerimiento::find($req_can->requerimiento_id);
                
            $AsignacionPsicologo=AsignacionPsicologo::where("req_id", $req_can->requerimiento_id)
            ->orderBy("asignacion_psicologo.id", "DESC")
            ->first();

            $candidato = user::find($req_can->candidato_id);
            $psicologo = User::find($AsignacionPsicologo->psicologo_id);
            $user_envio = User::find($requerimiento->solicitud->user_id);

            Mail::send('admin.email-info-aprobacion-2', [
                'candidato'      => $candidato,
                'req'      => $req
            ], function ($message) use ($user_envio, $requerimiento,$psicologo) {
                $message->to([$user_envio->email,$psicologo->email], "T3RS")
                ->subject("Candidato aprobado Req # $requerimiento->id")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }

        return response()->json(["success" => true, 'candidato_req' => $data->get("candidato_req")]);
    }

    public function enviar_a_contratar_cliente_req_masivo(Request $data)
    {
        $rules = [];
        $rules += [
            "fecha_inicio_contrato" => "required|date",
            //"fecha_fin_contrato"    => "required|date",
            ///"observaciones"         => "required",
            "user_autorizacion"     => "required",
        ];

        $validar = Validator::make($data->all(), $rules);

        if($validar->fails()) {
          return response()->json(["success" => false, "view" => $this->enviar_contratar_req($data)->withErrors($validar)->render()]);
        }

        foreach ($data->req_candi_id as $key => $req_ca_id) {
            $req = \App\Models\RegistroProceso::where("proceso", "ENVIO_APROBAR_CLIENTE")
            ->where("requerimiento_candidato_id", $req_ca_id)
            ->first();
         
            $req->apto = 1;
            $req->save();
        
            $fecha_hoy = Carbon::now();
            $fecha_hoy = $fecha_hoy->format('Y-m-d');

            $estado = new \App\Models\RegistroProceso();
            $estado->requerimiento_candidato_id = $req_ca_id;
            $estado->requerimiento_id      = $req->requerimiento_id;
            $estado->apto                  = 1;
            $estado->estado                  = 8;
            $estado->observaciones         = $data->get("observaciones");
            $estado->fecha_inicio_contrato = $data->get("fecha_inicio_contrato");
            $estado->fecha_inicio          = $fecha_hoy;

            // $estado->fecha_fin_contrato    = $data->get("fecha_fin_contrato");

            $estado->centro_costos         = $data->get("centro_costos");
            $estado->candidato_id          = $req->candidato_id;
            $estado->user_autorizacion     = $data->get("user_autorizacion");
            $estado->proceso               = "ENVIO_CONTRATACION_CLIENTE";
            $estado->usuario_terminacion   = $this->user->id;
            $estado->save();
        }

        return response()->json(["success" => true, 'candidato_req' => $data->get("candidato_req")]);
    }

    public function guardar_observacion(Request $data)
    {
        $rules = [];
        $rules += [ "observacion" => "required",];

        $validar = Validator::make($data->all(), $rules);

        $fecha_hoy = Carbon::now();
        $fecha_hoy = $fecha_hoy->format('Y-m-d');

        $estado = new ObservacionesCandidato();
        $estado->observacion           = $data->observacion;
        $estado->user_gestion          =$this->user->id;
        $estado->req_can_id            = $data->candidato_req;
        $estado->save();

        $proceso = RegistroProceso::join("users","users.id","=","procesos_candidato_req.usuario_envio")
        ->where("requerimiento_candidato_id", $data->candidato_req)
        ->where("proceso","ENVIO_APROBAR_CLIENTE")
        ->select("users.email as email_envio","requerimiento_id as req_id","candidato_id as candidato_id")
        ->first();

        $candidato = User::find($proceso->candidato_id);

        $cliente = User::find($this->user->id);

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Observación por parte del cliente"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "
                    Tu cliente {$cliente->name} ha realizado una observación sobre el candidato {$candidato->name} en el requerimiento {$proceso->req_id}.
                    <br/><br/>
                    Observación: <b>{$data->observacion}</b>";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'Ver observación', 'buttonRoute' => route('admin.gestion_requerimiento',['id' => $proceso->req_id])];

        $mailUser = $candidato->id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($proceso) {

                    $message->to([$proceso->email_envio], "T3RS");
                    $message->subject("Observación sobre candidato Req No. {$proceso->req_id}")
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

        return response()->json(["success" => true, 'candidato_req' => $data->get("candidato_req")]);
    }

    public function guardar_observacion_admin(Request $data)
    {
        $rules = [];
        $rules += [ "observacion" => "required",];

        $validar = Validator::make($data->all(), $rules);

        $cliente = ObservacionesCandidato::where("req_can_id", $data->candidato_req)->orderBy("id", "desc")->first();

        $user_sender = User::find($this->user->id);

        $req_can = ReqCandidato::where("id", $data->candidato_req)->first();
        $candidato = User::where("id", $req_can->candidato_id)->first();

        $requerimiento = Requerimiento::join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes","clientes.id", "=", "negocio.cliente_id")
                ->select(
                    'requerimientos.*', 
                    'cargos_especificos.descripcion as cargo_especifico',
                    'clientes.id as cliente_id')
                ->find($req_can->requerimiento_id);

        $usuarios = User::join('users_x_clientes','users_x_clientes.user_id','=','users.id')
                    ->join("role_users", "users.id", "=", "role_users.user_id")
                    ->join('clientes','clientes.id','=','users_x_clientes.cliente_id')
                    ->join('datos_basicos', 'datos_basicos.user_id', '=', "users.id")
                    ->whereIn("role_users.role_id", [3])
                    ->where("clientes.id", $requerimiento->cliente_id)
                    ->select("datos_basicos.nombres as nombres","users.email as email")
                    ->groupBy("users.id")
                    ->get();
       
        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Observación por parte del equipo de selección"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "
                    El analista de selección que está llevando a cabo el proceso del requerimiento {$req_can->requerimiento_id} para el cargo {$requerimiento->cargo_especifico} ha realizado una observación sobre el candidato {$candidato->name}.
                    <br/><br/>
                    Observación: <b>{$data->observacion}</b>
                    <br/><br/>
                    Realizada por: <b>{$user_sender->name}</b>";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'Ver observación', 'buttonRoute' => route('req.mis_requerimiento')];

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton);

        foreach ($usuarios as $usuario) {
            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($usuario,$req_can) {

                        $message->to([$usuario->email], "T3RS");
                        $message->subject("Observación sobre candidato Req No. {$req_can->requerimiento_id}")
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
        }
        

        $observaciones = ObservacionesCandidato::where("req_can_id", $data->candidato_req)->where("visto", 0)->get();

        if(!is_null($observaciones)){
            foreach($observaciones as $obs){
                $obs->visto = 1;
                $obs->save();
            }
        }

        $fecha_hoy = Carbon::now();
        $fecha_hoy = $fecha_hoy->format('Y-m-d');

        $estado = new ObservacionesCandidato();
        $estado->observacion           = $data->observacion;
        $estado->user_gestion          = $this->user->id;
        $estado->req_can_id            = $data->candidato_req;
        $estado->save();

        /*
            $proceso=RegistroProceso::join("users","users.id","=","procesos_candidato_req.usuario_envio")
            ->where("requerimiento_candidato_id",$data->candidato_req)
            ->where("proceso","ENVIO_APROBAR_CLIENTE")
            ->select("users.email as email_envio","requerimiento_id as req_id","candidato_id as candidato_id")
            ->first();

            $candidato=User::find($proceso->candidato_id);

            Mail::send('admin.email_observacion_candidato', [
                    'candidato' => $candidato,
                    'req'      => $proceso->req_id,
                    'observacion' => $data->observacion
                ], function ($message) use ($proceso) {
                    $message->to([$proceso->email_envio,'javier.chiquito@t3rsc.co'], "T3RS")
                    //$message->to(['juli.gzulu@gmail.com','javier5chiquito@gmail.com'], "T3RS")
                    ->subject("Observación sobre candidato Req# $proceso->req_id");
                });
        */

        return response()->json(["success" => true, 'candidato_req' => $data->get("candidato_req")]);
    }

    public function enviar_a_contratar_cliente_req(Request $data)
    {
        $rules = [];

        $rules += [
            "fecha_inicio_contrato" => "required|date",
            //"fecha_fin_contrato"  => "required|date",
            //"observaciones"       => "required",
            "user_autorizacion"     => "required",
        ];

        $validar = Validator::make($data->all(), $rules);

        if($validar->fails()){
            return response()->json(["success" => false, "view" => $this->enviar_contratar_req($data)->withErrors($validar)->render()]);
        }

        $req = \App\Models\RegistroProceso::where("proceso", "ENVIO_APROBAR_CLIENTE")
        ->where("requerimiento_candidato_id",$data->candidato_req)
        ->first();
         
        $req->apto = 1;
        $req->save();
         
        $usuario_envio = User::find($req->usuario_envio);
        $candidato = User::find($req->candidato_id);

        $fecha_hoy = Carbon::now();
        $fecha_hoy = $fecha_hoy->format('Y-m-d');

        $estado = new \App\Models\RegistroProceso();
        $estado->requerimiento_candidato_id = $data->candidato_req;
        $estado->requerimiento_id      = $req->requerimiento_id;
        $estado->apto                  = 1;
        $estado->estado                = 8;
        $estado->observaciones         = $data->get("observaciones");
        $estado->fecha_inicio_contrato = $data->get("fecha_inicio_contrato");
        $estado->fecha_inicio          = $fecha_hoy;
        // $estado->fecha_fin_contrato    = $data->get("fecha_fin_contrato");
        $estado->candidato_id          = $req->candidato_id;
        $estado->centro_costos         = $data->get("centro_costos");
        $estado->user_autorizacion     = $data->get("user_autorizacion");
        $estado->proceso               = "ENVIO_CONTRATACION_CLIENTE";
        $estado->usuario_terminacion   = $this->user->id;

        if(route("home") == "http://temporizar.t3rsc.co" || route("home") == "https://temporizar.t3rsc.co" ||
            route("home") == "http://desarrollo.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co"){
            $estado->lugar_contacto =  $data->get("lugar_contacto");
            $estado->hora_entrada   =  $data->get("hora_ingreso");
            $estado->otros_devengos =  $data->get("otros_devengos");
        }

        //guardar esto el req contratar contreq
        if(route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" ||
            route("home") == "http://localhost:8000" || route("home") == "http://desarrollo.t3rsc.co" ||
            route("home") == "https://desarrollo.t3rsc.co" || route("home") == "https://pruebaslistos.t3rsc.co" ||
            route("home") == "https://listos.t3rsc.co" || route("home") == "https://vym.t3rsc.co"){
            //datos para la orden de contratacion
            $candidato =DatosBasicos::where('user_id',$req->candidato_id)->first();

            $candidato->caja_compensaciones =$data->caja_compensacion;
            $candidato->fondo_cesantias = $data->fondo_cesantias;
            $candidato->nombre_banco = $data->nombre_banco;
            $candidato->tipo_cuenta = $data->tipo_cuenta;
            $candidato->numero_cuenta = $data->numero_cuenta;
            $candidato->entidad_eps = $data->entidad_eps;
            $candidato->entidad_afp = $data->entidad_afp;
            $candidato->save();

            $req_c = ReqCandidato::find($data->candidato_req);
            $req_c->tipo_ingreso = $data->tipo_ingreso;
            $req_c->auxilio_transporte = $data->auxilio_transporte;
            $req_c->save();

            $estado->fecha_inicio_contrato = $data->fecha_inicio_contrato;
            $estado->fecha_fin_contrato = $data->fecha_fin_contrato;
            $estado->fecha_ultimo_contrato = $data->fecha_fin_ultimo;
            $estado->hora_entrada = $data->hora_ingreso;
            $estado->save();
        }

        $estado->save();

        $requerimiento = Requerimiento::join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
            ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->leftjoin("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->select('requerimientos.*', 'cargos_especificos.descripcion as cargo_especifico', 'clientes.nombre as nombre_cliente')
            ->find($req->requerimiento_id);

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Aprobación"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "
                    Hola {$usuario_envio->name} te informamos que el cliente {$requerimiento->nombre_cliente} ha aprobado al candidato {$candidato->name}, enviado en el requerimiento {$requerimiento->id}. Haz clic en el siguiente botón para gestionar.";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'Ir a gestionar', 'buttonRoute' => route('admin.gestion_requerimiento', ["req_id" => $requerimiento->id])];

        $mailUser = $candidato->id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($usuario_envio,$req) {

                $message->to($usuario_envio->email, "T3RS")
                        ->subject("Candidato aprobado Req No. $req->requerimiento_id")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

        if(route('home')=="http://komatsu.t3rsc.co" || route('home')=="https://komatsu.t3rsc.co"){
            $req_can = ReqCandidato::find($data->candidato_req);
             
            $requerimiento=Requerimiento::find($req_can->requerimiento_id);

            $user_envio = User::find($requerimiento->solicitud->user_id);

            Mail::send('admin.email-info-aprobacion-2', [
                'candidato'      => $candidato,
                'req'      => $req
                
            ], function ($message) use ($user_envio, $requerimiento) {
                $message->to([$user_envio->email,'javier.chiquito@t3rsc.co'], "T3RS")
                ->subject("Candidato aprobado Req # $requerimiento->id")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }

        return response()->json(["success" => true, 'candidato_req' => $data->get("candidato_req")]);
    }

    public function asignar_psicologo(Request $data)
    {
        $req_id = $data->req_id;
        $cliente_id = $data->cliente_id;

        $psicologos = ["" => "Seleccionar"] + User::join('role_users','role_users.user_id','=','users.id')
        ->where('role_users.role_id',23)
        ->pluck('users.name','users.id')
        ->toArray();

        return view("admin.reclutamiento.modal.asignar_psicologo", compact("cliente_id", "psicologos", "req_id"));
    }

    public function asignar_psicologo_guardar(Request $data)
    {
        $delete = AsignacionPsicologo::where('req_id',$data->req_id)->delete();

        $consulta = AsignacionPsicologo::where('psicologo_id',$data->psicologo_id)->where('req_id',$data->req_id)->first();

        if($consulta){
            $consulta->delete();
        }
         
        $psicologo = new AsignacionPsicologo();
        $psicologo->fill(["psicologo_id" => $data->psicologo_id, "req_id" => $data->req_id,]);

        $psicologo->save();
        $psico=User::find($data->psicologo_id);

        $req = Requerimiento::find($data->req_id);

        //SE ACTUALIZA EL RESPONSABLE DE LA SOLICITUD
        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
            $solicitud=Solicitudes::find($req->solicitud_id);
            $solicitud->responsable_hr=$psico->name;
            $solicitud->save();
        }

        //FIN
        Mail::send('admin.email-asignacion-psicologo', [
            'psico'      => $psico,
            'requerimiento' => $req,
        ], function ($message) use ($psico, $req) {
            $message->to([$psico->email,"javier.chiquito@t3rsc.co"],"T3RS")
            ->subject("Asignación requerimiento #  $req->id")
            ->getHeaders()
            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        return response()->json(["success" => true, 'candidato_req' => $data->get("candidato_req")]);
    }

    public function enviar_a_contratar_cliente_req_masivo_admin(Request $data)
    {
        $rules = [];
        $rules += [
            "fecha_inicio_contrato" => "required|date",
            //"fecha_fin_contrato"    => "required|date",
            //"observaciones"         => "required",
            "user_autorizacion"     => "required",
        ];
            
        $validar = Validator::make($data->all(), $rules);
        if ($validar->fails()) {
            return response()->json(["success" => false, "view" => $this->enviar_contratar2($data)->withErrors($validar)->render()]);
        }
       
        //VERIFICAR NUMERO DE CANDIDATOS ENVIADOS A CONTRATAR CON NUMERO DE VACANTES
        $req = Requerimiento::find($data->req_id);

        $n_vac = $req->num_vacantes;
        
        if(count($data->req_candi_id) > $n_vac) {
          return response()->json(["success" => false, "view" => "El número de candidatos enviados a contratación es mayor al número de vacantes del requerimiento , el número de vacantes es  ".$n_vac."."]);
        }

        foreach($data->req_candi_id as $key => $req_ca_id){
            $valida_cliente = RegistroProceso::where("requerimiento_candidato_id",$req_ca_id)->where("proceso", "ENVIO_APROBAR_CLIENTE")->first();
            $valida_cliente2 = RegistroProceso::where("requerimiento_candidato_id",$req_ca_id)->where("proceso", "ENVIO_CONTRATACION")->first();

            if($valida_cliente2 != null){
                $candi=User::find($valida_cliente2->candidato_id);
                return response()->json([
                    "success" => false,
                    "view" => "El candidato ".$candi->name." ya ha sido enviado a contratar para este requerimiento. Verifíque los candidatos y realíce nuevamente la contratación masiva"
                ]);
            }

            $rules = [];
            
            if($valida_cliente != null){
                if($valida_cliente->apto != "1"){
                    // $rules = ["usuario_terminacion" => "required"];
                }
            }

            $req = \App\Models\RegistroProceso::where("proceso", "ASIGNADO_REQUERIMIENTO")
            ->where("requerimiento_candidato_id",$req_ca_id)
            ->first();

            //VERIFICAR EL ESTADO DEL REQUERIMIENTO
            /*  
                $estadoReq = EstadosRequerimientos::where("req_id", $req->id)->where("estado", config('conf_aplicacion.C_TERMINADO'))->get();
                if ($estadoReq->count() > 0) {
                    return response()->json(["success" => false, "view" => "El requerimiento ya se encuentra cerrado "]);
                }
            */
            
            if($valida_cliente != null) {
                //CAMBIA ESTADO REGISTRO APTO ENVIO_APROBAR_CLIENTE
                $valida_cliente->fill([
                    "apto"                => 1,
                    "usuario_terminacion" => $this->user->id,
                ]);
                
                $valida_cliente->save();
            }
        
            $campos = [
                'requerimiento_candidato_id' => $req_ca_id,
                'usuario_envio'              => $this->user->id,
                "fecha_inicio"               => date("Y-m-d H:i:s"),
                "fecha_inicio_contrato"      => $data->get("fecha_inicio_contrato"),
                //"fecha_fin_contrato"         => $data->get("fecha_fin_contrato"),
                "observaciones"              => $data->get("observaciones"),
                "centro_costos"              => $data->get("centro_costos"),
                "user_autorizacion"          => $data->get("user_autorizacion"),
                "usuario_terminacion"        => $this->user->id,
                'proceso'                    => "ENVIO_CONTRATACION",
            ];

            $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'), $req_ca_id);
        
            $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'))->first();

            //VERIFICAR SI EL REQUERIMIENTO YA TIENE TODOS LOS CANDIDATOS
            $requerimiento = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            ->where("requerimiento_cantidato.id", $req_ca_id)
            ->select("requerimientos.num_vacantes", "requerimiento_cantidato.requerimiento_id")
            ->first();

            //NUMERO DE CANDIDATOS SOLICISTADOS POR EL REQUERIMIENTO
            $num_candidatos            = $requerimiento->num_vacantes;
            $candidatos_contratados    = [];
            $candidatos_no_contratados = [];

            //CONSULTAR CANDIDATOS ENVIADOS
            $candidatos_req = EloquentUser::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
            ->where("requerimiento_cantidato.requerimiento_id", $requerimiento->requerimiento_id)
            ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
            ->whereRaw(" requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
            ->select("datos_basicos.*", "estados.id as estado_id", "estados.descripcion as estado_candidatos", "requerimiento_cantidato.id as req_candidato_id")
            ->get();

            foreach($candidatos_req as $key => $value){
                if(!in_array($value->estado_id, $this->estados_no_muestra)){
                    if ($value->estado_id == config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')) {
                        array_push($candidatos_contratados, $value->user_id);
                    } else {
                        array_push($candidatos_no_contratados, $value->user_id);
                    }
                    
                    //echo $value->estado_id . "<br>";
                }
            }
      
            if (count($candidatos_contratados) == $num_candidatos) {
                //TERMINAR REQUERIMIENTO
                $terminar_req = new EstadosRequerimientos();
                $terminar_req->fill([
                    "estado"        => config('conf_aplicacion.C_TERMINADO'),
                    "user_gestion"  => $this->user->id,
                    "observaciones" => "Se ha cumplido con todos los candidatos solicitados.",
                    "req_id"        => $requerimiento->requerimiento_id,
                ]);
                $terminar_req->save();

                // Se cambia el estado publico del requerimiento
                $req                 = Requerimiento::find($requerimiento->requerimiento_id);
                $req->estado_publico = 0;
                $req->save();
                //ya no aparece publico

                //ACTIVAR CANDIDATOS NO SELECCIONADOS
                foreach ($candidatos_no_contratados as $key => $value) {
                    $update_user = DatosBasicos::where("user_id", $value)->first();
                    $update_user->fill(["estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')]);
                    $update_user->save();
                }
            }
        }

        return response()->json(["success" => true, 'candidato_req' => $data->get("candidato_req")]);
    }

    /*
    *   Enviar a contratar candidatos (CONTRATAR)
    */
    public function enviar_a_contratar(Request $data)
    {
        try {
            $sitio = Sitio::first();
            $rules = [
                "fecha_ingreso_contra" => "required",
                "user_autorizacion"     => "required",
            ];

        
            $validar = Validator::make($data->all(), $rules);
            if($validar->fails()) {
                return response()->json(["success" => false, "view" => 'Llenas los campos obligatorios']);
            }
            $req_candi_id = $data->candidato_req;

            $no_contratados_masivo = [];
            

            $se_puede_contratar = 'si';
            $observacion_no_contratado = '';
            //VERIFICAR EL ESTADO DEL REQUERIMIENTO
            $requerimiento_cand = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("datos_basicos","datos_basicos.user_id","=","requerimiento_cantidato.candidato_id")
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
                "cargos_especificos.descripcion as cargo",
                "datos_basicos.numero_id as cedula"
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
                //sumamos 1 que es el candidato que se esta enviando a contratar actualmente
                $contratados = count($candidatos_contratados) + 1;
                
                if ($contratados == $num_candidatos) {
                    //logger('candidatos maximos');
                    //$se_puede_contratar = 'no';
                    //$observacion_no_contratado = 'Se alcanzó el limite de vacantes para el requerimiento.';

                    if($sitio->asistente_contratacion == 0 || $requerimiento_cand->firma_digital_cargo == 0){
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
                                ->select('datos_basicos.nombres as nombres','datos_basicos.email as email', 'datos_basicos.user_id')
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
                            
                        }
                             
                    }
                }
            }
            
            if ($se_puede_contratar == 'si') {
                $historialContratacion = new RequerimientoContratoCandidato();


                $historialContratacion->requerimiento_id = $requerimiento_cand->requerimiento_id;
                $historialContratacion->candidato_id = $requerimiento_cand->candidato;
                $historialContratacion->requerimiento_candidato_id = $req_candi_id;
                
                $historialContratacion->user_gestiono_id = $this->user->id;
                $historialContratacion->fecha_ingreso = $data->fecha_ingreso_contra;
                $historialContratacion->observaciones = $data->observaciones;

                if($sitio->asistente_contratacion == 1){

                    $historialContratacion->centro_costo_id = $data->centro_costos;
                    $historialContratacion->fecha_fin_contrato = $data->fecha_fin_contrato;
                    $historialContratacion->hora_ingreso = $data->hora_ingreso;
                    $historialContratacion->auxilio_transporte = $data->auxilio_transporte;
                    $historialContratacion->tipo_ingreso=$data->tipo_ingreso;
                    $historialContratacion->arl_id = $data->arl;
                    $historialContratacion->eps_id = $data->entidad_eps;
                    $historialContratacion->fondo_pensiones_id = $data->entidad_afp;
                    $historialContratacion->caja_compensacion_id = $data->caja_compensacion;
                    $historialContratacion->fondo_cesantia_id = $data->fondo_cesantias;
                    $historialContratacion->nombre_banco = $data->nombre_banco;
                    $historialContratacion->tipo_cuenta = $data->tipo_cuenta;
                    $historialContratacion->numero_cuenta = $data->numero_cuenta;

                    //tipo_ingreso = 1 Nuevo y 2 = Recontrato
                    if ($data->tipo_ingreso == 2) {
                        //Si se esta recontratando se guarda la fecha de fin del ultimo contrado
                        if($data->has('fecha_fin_ultimo') && $data->fecha_fin_ultimo != "" || $data->fecha_fin_ultimo != null) {
                            $historialContratacion->fecha_ultimo_contrato  = $data->fecha_fin_ultimo;
                        }
                    }

                }
                //Solo para Listos
                //$historialContratacion->atte_carta_presentacion = $data->atte_carta_presentacion;
                //$historialContratacion->direccion_carta_presentacion = $data->direccion_carta_presentacion;
                //Fin solo para listos

                $historialContratacion->save();

                /** ------ HumanNet ------
                $historialContratacion = new RequerimientoContratoCandidato();

                $historialContratacion->requerimiento_id = $reque->id;
                $historialContratacion->candidato_id = $requerimiento->candidato;
                $historialContratacion->user_gestiono_id = $this->user->id;
                $historialContratacion->nombre_banco = $data->nombre_banco;
                $historialContratacion->tipo_cuenta = $data->tipo_cuenta;
                $historialContratacion->numero_cuenta = $data->numero_cuenta;
                $historialContratacion->trabajo_dia = $data->trabajo_dia;
                $historialContratacion->trabajo_noche = $data->trabajo_noche;
                $historialContratacion->tabajo_fin = $data->tabajo_fin;
                $historialContratacion->part_time = $data->part_time;
                $historialContratacion->comentarios = $data->comentarios;
                $historialContratacion->save();
                */


                //VERIFICAR SI TIENE APROBACION POR CLIENTE
                $valida_cliente = RegistroProceso::where("requerimiento_candidato_id", $req_candi_id)->where("proceso", "ENVIO_APROBAR_CLIENTE")->first();

                if($valida_cliente != null) {
                    //CAMBIA ESTADO REGISTRO APTO ENVIO_APROBAR_CLIENTE
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
                    "observaciones"              => $data->observaciones,
                    "centro_costos"              => $data->centro_costos,
                    "user_autorizacion"          => $data->user_autorizacion,
                    "usuario_terminacion"        => $this->user->id,
                    "hora_entrada"               => $data->hora_ingreso,
                    'proceso'                    => "ENVIO_CONTRATACION",
                    'requerimiento_id'           => $requerimiento_cand->requerimiento_id,
                    'candidato_id'               => $requerimiento_cand->candidato,
                    'estado'                     => config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')
                    //GPC 'salario'                    => $data->salario
                ];

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

                if($requerimiento_obj->ultimoEstadoRequerimiento()->id != config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') && $requerimiento_obj->ultimoEstadoRequerimiento()->id != config('conf_aplicacion.C_TERMINADO')){
                    //Si el ultimo estado del Requerimiento es diferente a "En Proceso de Contratacion" y no esta terminado; entonces se agrega un nuevo estado del requerimiento a "En Proceso de Contratacion"
                    $nuevoEstado = new EstadosRequerimientos();

                    $nuevoEstado->req_id        =$requerimiento_obj->id;
                    $nuevoEstado->user_gestion  = $this->user->id;
                                        
                    $nuevoEstado->estado        = config('conf_aplicacion.C_EN_PROCESO_CONTRATACION');
                    $nuevoEstado->save();
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
                            Te invitamos a cargar los documentos solicitados en la plataforma y proceder con la firma de tu contrato de forma virtual. <br><br>

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

                    //Comienzo guardar adicionales
                        if($data->has("clausulas") && is_array($data->get("clausulas"))) {
                            foreach($data->get("clausulas") as $key => $clausula) {
                                //Si hay un valor adicional configurado se crea la asociación en la tabla
                                if($data->has("valor_adicional") && is_array($data->get("valor_adicional"))) {
                                    //if ($data->get("valor_adicional")[$key] != 0) {
                                        $documento_adicional_valor = new ClausulaValorCandidato();

                                        $documento_adicional_valor->fill([
                                            'user_id' => $requerimiento_cand->candidato,
                                            'req_id' => $requerimiento_cand->requerimiento_id,
                                            'adicional_id' => $clausula,
                                            'valor' => $data->get("valor_adicional")[$key],
                                        ]);
                                        $documento_adicional_valor->save();
                                    //}
                                }
                            }
                        }
                    //Fin guardar adicionales

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

                //GENERACION DE DOCUMENTOS

                //INFORME DE SELECCIÓN
                $request2 = new Request(["download"=>1]);

                //$informe = $this->pdf_informe_seleccion($requerimiento_cand->id,$request2);
                //Storage::disk('public')->put('documentos_candidatos/'.$requerimiento_cand->cedula.'/'.$requerimiento_cand->requerimiento_id.'/seleccion/informe_seleccion.pdf',$informe);

                //HV
                $request3 = new Request(["download"=>1,"req"=>$$requerimiento_cand->requerimiento_id]);

                $hv=$this->pdf_hv($requerimiento_cand->candidato,$request2);
                Storage::disk('public')->put('documentos_candidatos/'.$requerimiento_cand->cedula.'/'.$requerimiento_cand->requerimiento_id.'/seleccion/hv.pdf',$hv);

                //POLITICAS DE ACEPTACION
                $tipos_politicas_privacidad = TipoPolitica::where('active', 1)->get();

                foreach( $tipos_politicas_privacidad as $tipo_politica  ){
                        
                    $acepto_politica = PoliticaPrivacidadCandidato::join("politicas_privacidad", "politicas_privacidad.id", "=", "politicas_privacidad_candidatos.politica_privacidad_id")
                    ->join("tipos_politicas", "tipos_politicas.id", "=", "politicas_privacidad.tipo_politica_id")
                    ->where("politicas_privacidad_candidatos.candidato_id", $requerimiento_cand->candidato)
                    ->where("politicas_privacidad.tipo_politica_id", $tipo_politica->id)
                    ->select("politicas_privacidad_candidatos.*", "tipos_politicas.titulo_boton_carpeta_seleccion", "tipos_politicas.id as tipo_politica")
                    ->orderBy("politicas_privacidad_candidatos.id", "DESC")
                    ->first();

                    if( $acepto_politica != null ){
                        $request4 = new Request(["politica_id" => $acepto_politica->politica_privacidad_id,"user_id"=>$requerimiento_cand->candidato,"download"=>1]); 

                        $controll = new ContratacionController();
                        $aceptacion = $controll->aceptacionPoliticaTratamientoDatos($request4);
                        
                        Storage::disk('public')->put('documentos_candidatos/'.$requerimiento_cand->cedula.'/'.$requerimiento_cand->requerimiento_id.'/seleccion/aceptacion_politicas_datos_'.$acepto_politica->tipo_politica.'.pdf',$aceptacion);
                    }

                }
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

            return response()->json([
                "success" => true, "no_contratados_masivo" => $no_contratados_masivo
            ]);

        } catch (\Exception $e) {
            logger('Excepción capturada en ReclutamientoController: '.  $e->getMessage(). "\n");
        }
    }

    public function rechazar_candidato_view(Request $data)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
        ->first();

        $motivos = ["" => "Seleccionar"] + MotivosRechazos::pluck("descripcion", "id")->toArray();
      
        return view("admin.reclutamiento.modal.motivo_rechazo", compact("motivos", "candidato"));
    }

    public function rechazar_candidato(Request $data)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato", "datos_basicos.id as datos_basicos_id")
            ->first();
        $motivos = ["" => "Seleccionar"] + MotivosRechazos::pluck("descripcion", "id")->toArray();
        //VALIDAR
        $rules = [
            "motivo_rechazo_id" => "required",
            "observaciones"     => "required",
        ];

        $validar = Validator::make($data->all(), $rules);
        
        if($validar->fails()) {
          return response()->json(["success" => false, "view" => view("admin.reclutamiento.modal.motivo_rechazo", compact("motivos", "candidato"))->withErrors($validar)->render()]);
        }

        $estado_reclutamiento = $candidato->estado_reclutamiento;

        $campos = [
            'requerimiento_candidato_id' => $data->get("candidato_req"),
            'usuario_envio'              => $this->user->id,
            "fecha_inicio"               => date("Y-m-d H:i:s"),
            "motivo_rechazo_id"          => $data->get("motivo_rechazo_id"),
            "observaciones"              => $data->get("observaciones"),
            "proceso"                    => "RECHAZAR_CANDIDATO",
        ];

        $this->RegistroProceso($campos, config('conf_aplicacion.C_INACTIVO'), $data->get("candidato_req"));

        $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_INACTIVO'))->first();

        return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $data->get("candidato_req")]);
    }

    public function referenciacion(Request $data)
    {
        //corregir ciudad
        $ciudad = explode('~',$data->get("ciudad_trabajo"));

        $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
        ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
        ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
        //->join("recepcion","recepcion.candidato_id","=","datos_basicos.user_id")
        ->whereRaw(" (procesos_candidato_req.apto is null or  procesos_candidato_req.apto = '')  ")
        ->whereIn("requerimiento_cantidato.estado_candidato", [7,8,25])
        ->whereIn("procesos_candidato_req.estado", [7,8,25])
        //->where("recepcion.created_at", date("Y-m-d",time()))
        ->where(function ($sql) use ($data,$ciudad) {
            //Filtro por codigo requerimiento
            if ($data->codigo != "") {
                $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
            }
            //Filtro por cedula de candidato
            if ($data->cedula != "") {
                $sql->where("datos_basicos.numero_id", $data->cedula);
            }
            //Ciudad Trabajo
            if ($data->get("ciudad_trabajo") != "") {
                $sql->where("requerimientos.pais_id", $ciudad[0]);
                $sql->where("requerimientos.departamento_id", $ciudad[1]);
                $sql->where("requerimientos.ciudad_id", $ciudad[2]);
            }
        })
        ->whereIn("procesos_candidato_req.proceso", ["ENVIO_REFERENCIACION", "ENVIO_REFERENCIACION_PENDIENTE"])
        ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
        ->select("procesos_candidato_req.proceso", "procesos_candidato_req.id as ref_id", "datos_basicos.*", "requerimiento_cantidato.*")
        ->paginate(5);

        //SELECT DE CIUDAD DE SEDES
        $ciudad_trabajo = ["" => "Seleccionar"] + config('conf_aplicacion.SEDES_MUNICIPIO');

        return view("admin.reclutamiento.referenciacion", compact("candidatos", "ciudad_trabajo"));
    }

    public function gestionar_referencia($id, $id_evs = '')
    {
        $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
        ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
        ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = '' or procesos_candidato_req.apto = 3 )")
        ->where("procesos_candidato_req.id", $id)
        ->select(
            "procesos_candidato_req.requerimiento_candidato_id",
            "procesos_candidato_req.id as ref_id",
            "procesos_candidato_req.proceso",
            "datos_basicos.*",
            "requerimiento_cantidato.requerimiento_id",
            "requerimiento_cantidato.candidato_id"
        )
        ->first();

        $redireccion = route('admin.gestion_requerimiento', ['ref_id' => $candidato->requerimiento_id]);
        if ($candidato->proceso == 'REFERENCIACION_LABORAL_EVS') {
            $proc = ['REFERENCIACION_LABORAL_EVS'];
            if ($id_evs != '') {
                $redireccion = route('admin.gestionar_estudio_virtual_seguridad', ['id_evs' => $id_evs]);
            } else {
                $redireccion = route('admin.lista_referenciacion_laboral_evs');
            }
        } else {
            $proc = ["ENVIO_REFERENCIACION", "ENVIO_REFERENCIACION_PENDIENTE"];
        }

        $experiencias_laborales = Experiencias::leftjoin("paises", "paises.cod_pais", "=", "experiencias.pais_id")
        ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
        ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
        ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
        ->leftjoin("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
            ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
        })->leftjoin("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
            ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
        })->select(
            "aspiracion_salarial.descripcion as salario",
            "cargos_genericos.descripcion as desc_cargo",
            "motivos_retiros.descripcion as desc_motivo",
            \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudades"), "experiencias.*"
        )
        ->orderBy("experiencias.fecha_inicio", "desc")
        ->where("experiencias.user_id", $candidato->user_id)
        ->get();

        $estados_procesos_referenciacion = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
        ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
        ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
        ->whereIn("proceso", $proc)
        ->get();

        $req_referencia_gestionado = [];
        $req_gestion = ExperienciaVerificada::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "experiencia_verificada.id")
        ->select("experiencia_verificada.experiencia_id")
        ->where("proceso_requerimiento.requerimiento_id", $candidato->requerimiento_id)
        ->where("proceso_requerimiento.tipo_entidad", "MODULO_REFERENCIACION")
        ->where("proceso_requerimiento.proceso_adicional", "EXPERIENCIA_LABORAL")
        ->orderBy("experiencia_verificada.created_at", "desc")
        ->get();

        foreach ($req_gestion as $key => $value) {
            array_push($req_referencia_gestionado, $value->experiencia_id);
        }

        //REFERENCIAS PERSONALES
        $referencias_personales = ReferenciasPersonales::join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
        ->leftjoin("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
        ->leftjoin("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
            ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->leftjoin("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
            ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
            ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->select(
            "referencias_personales.id",
            'referencias_personales.numero_id',
            'referencias_personales.user_id',
            'referencias_personales.nombres',
            'referencias_personales.primer_apellido',
            'referencias_personales.segundo_apellido',
            'referencias_personales.tipo_relacion_id',
            'referencias_personales.telefono_movil',
            'referencias_personales.telefono_fijo',
            'referencias_personales.codigo_pais',
            'referencias_personales.codigo_departamento',
            'referencias_personales.codigo_ciudad',
            'referencias_personales.ocupacion',
            'referencias_personales.active',
            "tipo_relaciones.descripcion as relacion",
            \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada")
        )
        ->where("referencias_personales.user_id", $candidato->user_id)
        ->get();

        $req_referencia_personal_gestionado = [];
        $req_gestion_personal = ReferenciaPersonalVerificada::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "ref_personales_verificada.id")
        ->select("ref_personales_verificada.referencia_personal_id")
        ->where("proceso_requerimiento.requerimiento_id", $candidato->requerimiento_id)
        ->where("proceso_requerimiento.tipo_entidad", "MODULO_REFERENCIACION")
        ->where("proceso_requerimiento.proceso_adicional", "REFERENCIA_PERSONAL")
        ->orderBy("ref_personales_verificada.created_at","desc")
        ->get();

        foreach ($req_gestion_personal as $key => $value) {
            array_push($req_referencia_personal_gestionado, $value->referencia_personal_id);
        }

        //ESTUDIOS
        $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        ->where("estudios.user_id", $candidato->user_id)
        ->select("estudios.*", "niveles_estudios.descripcion as nivel_estudio")
        ->get();

        return view("admin.reclutamiento.gestionar_referencia", compact(
            "candidato",
            "experiencias_laborales",
            "estados_procesos_referenciacion",
            "req_referencia_gestionado",
            "referencias_personales",
            "req_referencia_personal_gestionado",
            "redireccion",
            "estudios"
        ));
    }

    public function referenciacion_academica(Request $data)
    {
        //corregir ciudad
        $ciudad = explode('~',$data->get("ciudad_trabajo"));

        $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
        ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
        ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
        //->join("recepcion","recepcion.candidato_id","=","datos_basicos.user_id")
        ->whereRaw(" (procesos_candidato_req.apto is null or  procesos_candidato_req.apto = '')  ")
        ->whereIn("requerimiento_cantidato.estado_candidato", [7,8,25])
        ->whereIn("procesos_candidato_req.estado", [7,8,25])
        //->where("recepcion.created_at", date("Y-m-d",time()))
        ->where(function ($sql) use ($data,$ciudad) {
            //Filtro por codigo requerimiento
            if ($data->codigo != "") {
                $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
            }
            //Filtro por cedula de candidato
            if ($data->cedula != "") {
                $sql->where("datos_basicos.numero_id", $data->cedula);
            }
            //Ciudad Trabajo
            if ($data->get("ciudad_trabajo") != "") {
                $sql->where("requerimientos.pais_id", $ciudad[0]);
                $sql->where("requerimientos.departamento_id", $ciudad[1]);
                $sql->where("requerimientos.ciudad_id", $ciudad[2]);
            }
        })
        ->whereIn("procesos_candidato_req.proceso", ["ENVIO_REFERENCIA_ESTUDIOS"])
        ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
        ->select("procesos_candidato_req.proceso", "procesos_candidato_req.id as ref_id", "datos_basicos.*", "requerimiento_cantidato.*")
        ->paginate(5);

        //SELECT DE CIUDAD DE SEDES
        $ciudad_trabajo = ["" => "Seleccionar"] + config('conf_aplicacion.SEDES_MUNICIPIO');

        return view("admin.reclutamiento.referenciacion_academica", compact("candidatos", "ciudad_trabajo"));
    }

    public function gestionar_referencia_estudios($id, $id_evs = '')
    {
        $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
        ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
        ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = '' or procesos_candidato_req.apto = 3 )")
        ->where("procesos_candidato_req.id", $id)
        ->select(
            "procesos_candidato_req.requerimiento_candidato_id",
            "procesos_candidato_req.id as ref_id",
            "procesos_candidato_req.proceso",
            "datos_basicos.*",
            "requerimiento_cantidato.requerimiento_id",
            "requerimiento_cantidato.candidato_id"
        )
        ->first();

        $redireccion = route('admin.gestion_requerimiento', ['ref_id' => $candidato->requerimiento_id]);
        if ($candidato->proceso == 'REFERENCIACION_ACADEMICA_EVS') {
            $proc = ['REFERENCIACION_ACADEMICA_EVS'];
            if ($id_evs != '') {
                $redireccion = route('admin.gestionar_estudio_virtual_seguridad', ['id_evs' => $id_evs]);
            } else {
                $redireccion = route('admin.lista_referenciacion_academica_evs');
            }
        } else {
            $proc = ["ENVIO_REFERENCIA_ESTUDIOS", "ENVIO_REFERENCIA_ESTUDIOS_PENDIENTE"];
        }

        $estados_procesos_referenciacion = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
        ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
        ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
        ->whereIn("proceso", $proc)
        ->get();

        //ESTUDIOS
        $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        ->where("estudios.user_id", $candidato->user_id)
        ->select("estudios.*", "niveles_estudios.descripcion as nivel_estudio")
        ->get();

        $estudios_verificados = ReferenciaEstudio::join("estudios","estudios.id","=","referencias_estudios.estudio_id")
            ->join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->leftjoin("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "estudios.pais_estudio")
                ->on("ciudad.cod_ciudad", "=", "estudios.ciudad_estudio")
                ->on("ciudad.cod_departamento", "=", "estudios.departamento_estudio");
            })
            ->select("estudios.*","referencias_estudios.*","niveles_estudios.descripcion as desc_nivel","ciudad.nombre as ciudad")
            ->where("estudios.user_id", $candidato->user_id)
            ->get();

        return view("admin.reclutamiento.gestionar_referencia_estudios", compact(
            "candidato",
            "redireccion",
            "estados_procesos_referenciacion",
            "estudios",
            "estudios_verificados"
        ));
    }
    //----------------- PRUEBA IDIOMAS
    public function cambiar_estado_view_prueba_idioma(Request $data)
    {
        $motivos = ["" => "Seleccionar"] + MotivosRechazos::pluck("descripcion", "id")->toArray();
        $datos   = $data;
        $respuestas = 0;

        if ($datos->pregunta_id) {
            $respuesta = RespuestaPruebaIdioma::where('respuestas_pruebas_idiomas.candidato_id',$datos->candidato_id)
            ->where('respuestas_pruebas_idiomas.preg_prueba_id',$datos->pregunta_id)
            ->first();

            $respuestas = $respuesta->count();
            $pregunta = PreguntasPruebaIdioma::where('preguntas_pruebas_idiomas.id',$datos->pregunta_id);

            return view("admin.reclutamiento.modal.cambiar_estado_idioma", compact("respuestas","respuesta","pregunta","motivos", "datos"));
        }

        return view("admin.reclutamiento.modal.cambiar_estado_idioma", compact("respuestas","motivos", "datos"));
    }

    public function guardar_cambio_estado_prueba_idioma(Request $data, Requests\ValidaCambioEstadoRequest $validate)
    {
        if ($data->respuesta_id) {

            $respuesta = RespuestaPruebaIdioma::find($data->respuesta_id);
            $respuesta->puntuacion = $data->puntaje;
            $respuesta->save();

            $user_sesion = $this->user;
      
            $ref_id = RegistroProceso::find($data->get("ref_id"));

            $ref_id->fill([
                "apto"                => $data->get("estado_ref"),
                "usuario_terminacion" => $this->user->id,
                "motivo_rechazo_id"   => $data->get("motivo_rechazo_id"),
                "observaciones"       => $data->get("observaciones"),
            ]);
            $ref_id->save();
            

            //SI SELECCIONAN EL ESTADO PENDIENTE SE CREA UN NUEVO REGISTRO
            if ($data->get("estado_ref") == 3) {
                $campos = [
                    "usuario_envio"              => $this->user->id,
                    "proceso"                    => $ref_id->proceso . "_PENDIENTE",
                    "requerimiento_candidato_id" => $ref_id->requerimiento_candidato_id,
                ];
                $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $ref_id->requerimiento_candidato_id);
            }

            if ($data->get("estado_ref") == 2) {
                $campos = [
                    'requerimiento_candidato_id' => $ref_id->requerimiento_candidato_id,
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    "motivo_rechazo_id"          => $data->get("motivo_rechazo_id"),
                    "proceso"                    => $ref_id->proceso,
                    "observaciones"              => $data->get("observaciones"),
                ];

                if ($data->get("modulo") != "pruebas") {
                    $this->RegistroProceso($campos, config('conf_aplicacion.C_INACTIVO'), $ref_id->requerimiento_candidato_id);
                }
            }
            
            return response()->json(["success" => true]);
        }
        else{
            $user_sesion = $this->user;
            
            //FUNCION ACTIVA DE MENSAJE A CANDIDATOS APTO                                      
            if ($user_sesion->hasAccess("mensaje_candidato_apto")) {

                $datos_candidato = DatosBasicos::join('requerimiento_cantidato','requerimiento_cantidato.candidato_id','=','datos_basicos.user_id')
                ->join('procesos_candidato_req','procesos_candidato_req.requerimiento_candidato_id','=','requerimiento_cantidato.id')
                ->select('requerimiento_cantidato.requerimiento_id as req_id','datos_basicos.nombres as nombres','datos_basicos.telefono_movil as destino')
                ->where('procesos_candidato_req.id',$data->get("ref_id"))
                ->first();

                $mensaje = "Has pasado uno de los procesos de selección en el cuál se te esta evaluando, éxitos! ";

                $this->ValidarSMSApto($datos_candidato->destino, $mensaje,$datos_candidato->req_id,$datos_candidato->nombres);

                $ref_id = RegistroProceso::find($data->get("ref_id"));

                $ref_id->fill([
                    "apto"                => $data->get("estado_ref"),
                    "usuario_terminacion" => $this->user->id,
                    "motivo_rechazo_id"   => $data->get("motivo_rechazo_id"),
                    "observaciones"       => $data->get("observaciones"),
                ]);
                $ref_id->save();

            }

            $ref_id = RegistroProceso::find($data->get("ref_id"));

            $ref_id->fill([
                "apto"                => $data->get("estado_ref"),
                "usuario_terminacion" => $this->user->id,
                "motivo_rechazo_id"   => $data->get("motivo_rechazo_id"),
                "observaciones"       => $data->get("observaciones"),
            ]);
            $ref_id->save();

            //SI SELECCIONAN EL ESTADO PENDIENTE SE CREA UN NUEVO REGISTRO
            if ($data->get("estado_ref") == 3) {
                $campos = [
                    "usuario_envio"              => $this->user->id,
                    "proceso"                    => $ref_id->proceso . "_PENDIENTE",
                    "requerimiento_candidato_id" => $ref_id->requerimiento_candidato_id,
                ];
                $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $ref_id->requerimiento_candidato_id);
            }

            //SI EL ESTADO ES NO APTO SE RECHAZA EL CANDIDATO
            if ($data->get("estado_ref") == 2) {
                $campos = [
                    'requerimiento_candidato_id' => $ref_id->requerimiento_candidato_id,
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    "motivo_rechazo_id"          => $data->get("motivo_rechazo_id"),
                    "proceso"                    => $ref_id->proceso,
                    "observaciones"              => $data->get("observaciones"),
                ];

                if ($data->get("modulo") != "pruebas") {
                    $this->RegistroProceso($campos, config('conf_aplicacion.C_INACTIVO'), $ref_id->requerimiento_candidato_id);
                }
            }
            
            return response()->json(["success" => true]);
        }
    }
    
    //-------------
    public function cambiar_estado_view(Request $data)
    {
        $motivos = ["" => "Seleccionar"] + MotivosRechazos::pluck("descripcion", "id")->toArray();
        $datos  = $data;
        $respuestas = 0;
        $id_visita=$data->get("id_visita");

        if($datos->pregunta_id) {
            $respuesta = RespuestasEntre::where('respuestas_entre.candidato_id', $datos->candidato_id)
            ->where('respuestas_entre.preg_entre_id', $datos->pregunta_id)
            ->first();

            $respuestas = $respuesta->count();

            $pregunta = PreguntasEntre::where('preguntas_entre.id',$datos->pregunta_id);
          
            return view("admin.reclutamiento.modal.cambiar_estado", compact("respuestas","respuesta","pregunta","motivos", "datos"));
        }


        return view("admin.reclutamiento.modal.cambiar_estado", compact("respuestas","motivos", "datos","id_visita"));
    }

    public function guardar_cambio_estado(Request $data, Requests\ValidaCambioEstadoRequest $validate){
        if ($data->respuesta_id) {
            $respuesta = RespuestasEntre::find($data->respuesta_id);
            $respuesta->puntuacion = $data->puntaje;
            $respuesta->save();

            $user_sesion = $this->user;

            $ref_id = RegistroProceso::find($data->get("ref_id"));

            $ref_id->fill([
                "apto"                => $data->get("estado_ref"),
                "usuario_terminacion" => $this->user->id,
                "motivo_rechazo_id"   => $data->get("motivo_rechazo_id"),
                "observaciones"       => $data->get("observaciones"),
            ]);
            $ref_id->save();

            //SI SELECCIONAN EL ESTADO PENDIENTE SE CREA UN NUEVO REGISTRO
            if ($data->get("estado_ref") == 3) {
                $campos = [
                    "usuario_envio"              => $this->user->id,
                    "proceso"                    => $ref_id->proceso . "_PENDIENTE",
                    "requerimiento_candidato_id" => $ref_id->requerimiento_candidato_id,
                ];
                
                $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $ref_id->requerimiento_candidato_id);
            }

            if ($data->get("estado_ref") == 2) {
                $campos = [
                    'requerimiento_candidato_id' => $ref_id->requerimiento_candidato_id,
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    "motivo_rechazo_id"          => $data->get("motivo_rechazo_id"),
                    "proceso"                    => $ref_id->proceso,
                    "observaciones"              => $data->get("observaciones"),
                ];

                if ($data->get("modulo") != "pruebas") {
                    $this->RegistroProceso($campos, config('conf_aplicacion.C_INACTIVO'), $ref_id->requerimiento_candidato_id);
                }
            }
        
            $id = $ref_id->requerimiento_id;

            return response()->json(["success" => true,"req"=>$id]);
        }
        elseif($data->has("id_visita")){
            //CAMBIAR EL ESTADO EN EL PROCESO DE ENVIO A VISITA DOMICILIARIA
                $ref_id = RegistroProceso::find($data->get("ref_id"));

                $ref_id->fill([
                "apto"                => $data->get("estado_ref"),
                "usuario_terminacion" => $this->user->id,
                "motivo_rechazo_id"   => $data->get("motivo_rechazo_id"),
                "observaciones"       => $data->get("observaciones"),
                ]);
                $ref_id->save();

                return response()->json(["success" => true,"req"=>$id]);
        } 
        else {
            $user_sesion = $this->user;

            //FUNCION ACTIVA DE MENSAJE A CANDIDATOS APTO                                      
            if ($user_sesion->hasAccess("mensaje_candidato_apto")) {
                $datos_candidato = DatosBasicos::join('requerimiento_cantidato','requerimiento_cantidato.candidato_id','=','datos_basicos.user_id')
                ->join('procesos_candidato_req','procesos_candidato_req.requerimiento_candidato_id','=','requerimiento_cantidato.id')
                ->select(
                    'requerimiento_cantidato.requerimiento_id as req_id',
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.telefono_movil as destino'
                )
                ->where('procesos_candidato_req.id', $data->get("ref_id"))
                ->first();

                $mensaje = "Has pasado uno de los procesos de selección en el cuál se te esta evaluando, éxitos! ";
                //$this->ValidarSMSApto($datos_candidato->destino, $mensaje,$datos_candidato->req_id,$datos_candidato->nombres);

                $ref_id = RegistroProceso::find($data->get("ref_id"));

                $ref_id->fill([
                    "apto"                => $data->get("estado_ref"),
                    "usuario_terminacion" => $this->user->id,
                    "motivo_rechazo_id"   => $data->get("motivo_rechazo_id"),
                    "observaciones"       => $data->get("observaciones"),
                ]);
                $ref_id->save();
            }

            $ref_id = RegistroProceso::find($data->get("ref_id"));

            $ref_id->fill([
                "apto"                => $data->get("estado_ref"),
                "usuario_terminacion" => $this->user->id,
                "motivo_rechazo_id"   => $data->get("motivo_rechazo_id"),
                "observaciones"       => $data->get("observaciones"),
            ]);
            $ref_id->save();

            //SI SELECCIONAN EL ESTADO PENDIENTE SE CREA UN NUEVO REGISTRO
            if ($data->get("estado_ref") == 3) {
                $campos = [
                    "usuario_envio"              => $this->user->id,
                    "proceso"                    => $ref_id->proceso . "_PENDIENTE",
                    "requerimiento_candidato_id" => $ref_id->requerimiento_candidato_id,
                ];
                $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $ref_id->requerimiento_candidato_id);
            }

            //SI EL ESTADO ES NO APTO SE RECHAZA EL CANDIDATO
            if ($data->get("estado_ref") == 2) {
                $campos = [
                    'requerimiento_candidato_id' => $ref_id->requerimiento_candidato_id,
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    "motivo_rechazo_id"          => $data->get("motivo_rechazo_id"),
                    "proceso"                    => $ref_id->proceso,
                    "observaciones"              => $data->get("observaciones"),
                ];

                if ($data->get("modulo") != "pruebas") {
                    //$this->RegistroProceso($campos, config('conf_aplicacion.C_INACTIVO'), $ref_id->requerimiento_candidato_id);
                }
            }

            return response()->json(["success" => true]);
        }
    }

    public function guardar_apto_pruebas(Request $data, Requests\ValidaCambioEstadoRequest $validate)
    {
        $ref_id = RegistroProceso::find($data->get("ref_id"));

        $ref_id->fill([
            "apto"                => $data->get("estado_ref"),
            "usuario_terminacion" => $this->user->id,
            "motivo_rechazo_id"   => $data->get("motivo_rechazo_id"),
            "observaciones"       => $data->get("observaciones"),
        ]);

        $ref_id->save();
        //SI SELECCIONAN EL ESTADO PENDIENTE SE CREA UN NUEVO REGISTRO
        if ($data->get("estado_ref") == 3) {

            $campos = [
                "usuario_envio"              => $this->user->id,
                "proceso"                    => "ENVIO_REFERENCIACION_PENDIENTE",
                "requerimiento_candidato_id" => $ref_id->requerimiento_candidato_id,
            ];
            $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $ref_id->requerimiento_candidato_id);
        }

        return response()->json(["success" => true]);
    }

    public function lista_pruebas(Request $data)
    {
        if (route("home") == "https://komatsu.t3rsc.co") {
            $candidatos = "";

            $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
            ->leftjoin('solicitudes', 'solicitudes.id', '=', 'requerimientos.solicitud_id')
            ->leftjoin('solicitud_sedes', 'solicitud_sedes.id', '=', 'solicitudes.ciudad_id')
            ->whereRaw(" (procesos_candidato_req.apto is null or  procesos_candidato_req.apto = '')  ")
            ->whereIn("requerimiento_cantidato.estado_candidato", [7,8,25])
            ->whereIn("procesos_candidato_req.estado", [7,8,25])
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
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_PRUEBAS", "ENVIO_PRUEBAS_PENDIENTE"])
            ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                "requerimiento_cantidato.*",
                'solicitud_sedes.descripcion'
            )
            ->paginate(5);

            /*if($this->user->inRole("ANALISTA")){

             $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
            
            ->leftjoin('solicitudes', 'solicitudes.id', '=', 'requerimientos.solicitud_id')
            ->leftjoin('solicitud_sedes', 'solicitud_sedes.id', '=', 'solicitudes.ciudad_id')
            ->join('asignacion_psicologo','asignacion_psicologo.req_id','=','requerimientos.id')
            ->whereRaw(" (procesos_candidato_req.apto is null or  procesos_candidato_req.apto = '')  ")
            ->where('asignacion_psicologo.psicologo_id',$this->user->id)
            ->where("requerimiento_cantidato.estado_candidato", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
            ->where("procesos_candidato_req.estado", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
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
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_PRUEBAS", "ENVIO_PRUEBAS_PENDIENTE"])
             ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                "requerimiento_cantidato.*",
                'solicitud_sedes.descripcion'
            )
           
            ->paginate(5);

                //dd($candidatos);
             //return view("admin.reclutamiento.pruebas", compact("candidatos"));

            }elseif($this->user->inRole("SUPER ADMINISTRADOR")){

             $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
            ->leftjoin('solicitudes', 'solicitudes.id', '=', 'requerimientos.solicitud_id')
            ->leftjoin('solicitud_sedes', 'solicitud_sedes.id', '=', 'solicitudes.ciudad_id')
            ->whereRaw(" (procesos_candidato_req.apto is null or  procesos_candidato_req.apto = '')  ")
            ->where("requerimiento_cantidato.estado_candidato", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
            ->where("procesos_candidato_req.estado", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
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
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_PRUEBAS", "ENVIO_PRUEBAS_PENDIENTE"])
            ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                "requerimiento_cantidato.*",
                'solicitud_sedes.descripcion'
            )
            ->paginate(5);
            
            }*/
        }else{
            $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->whereRaw("(procesos_candidato_req.apto is null or  procesos_candidato_req.apto = '')")
            ->whereIn("requerimiento_cantidato.estado_candidato",[7, 8, 25])
            ->whereIn("procesos_candidato_req.estado", [7, 8, 25])
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
                //Filtro por código requerimiento
                if ($data->codigo != "") {
                    $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                }

                //Filtro por cédula de candidato
                if ($data->cedula != "") {
                    $sql->where("datos_basicos.numero_id", $data->cedula);
                }
            })
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_PRUEBAS", "ENVIO_PRUEBAS_PENDIENTE"])
            ->orderBy('requerimiento_cantidato.requerimiento_id', 'desc')
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                "requerimiento_cantidato.*"
            )
            ->paginate(5);
        }

        return view("admin.reclutamiento.pruebas", compact("candidatos"));
    }

    public function gestionar_referencia_candidato(Request $data)
    {
        $visita=null;
        if($data->has("id_visita"))
            $visita=$data->get("id_visita");

         $experiencia = Experiencias::leftjoin("paises", "paises.cod_pais", "=", "experiencias.pais_id")
            ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
            ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            ->leftjoin("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
                    ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
            })->leftjoin("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
                ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
            })
            ->select("aspiracion_salarial.descripcion as salario", "cargos_genericos.descripcion as desc_cargo", "motivos_retiros.descripcion as desc_motivo", \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudades"), "experiencias.*")
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->where("experiencias.id", $data->get("referencia_id"))
            ->first();
        
         $motivo_retiro = ["" => "Seleccionar"] + MotivoRetiro::pluck("descripcion", "id")->toArray();
        
         $proceso     = RegistroProceso::
            join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))->first();

         $competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")->
            where("competencias_cliente.cliente_id", $proceso->cliente_id)->get();

        return view("admin.reclutamiento.modal.gestionar_referencia_ref", compact("experiencia", "motivo_retiro", "competencias","visita"));
    }

    public function gestionar_referencia_estudio(Request $data)
    {
        $estudio=Estudios::where("estudios.id",$data->get("estudio_id"))
        ->leftjoin("niveles_estudios","niveles_estudios.id","=","estudios.nivel_estudio_id")
        ->leftjoin("periodicidad", "periodicidad.id", "=", "estudios.periodicidad")
        ->leftjoin("ciudad", function ($join) {
                $join->on("ciudad.cod_pais", "=", "estudios.pais_estudio")
                ->on("ciudad.cod_departamento", "=", "estudios.departamento_estudio")
                ->on("ciudad.cod_ciudad", "=", "estudios.ciudad_estudio");
            })
        ->select("estudios.*","niveles_estudios.descripcion as nivel","ciudad.nombre as ciudad", "periodicidad.descripcion as periodo")
        ->first();

        $nivelEstudios = ["" => "Seleccionar"] + NivelEstudios::pluck("descripcion", "id")->toArray();
        
        return view("admin.reclutamiento.modal.gestionar_referencia_estudio_ref", compact("estudio", "nivelEstudios"));
    }

    public function editar_referencia_estudio(Request $data)
    {   
        $referencia_estudio = ReferenciaEstudio::find($data->referencia_estudio_id);

        $estudio=Estudios::where("estudios.id",$referencia_estudio->estudio_id)
        ->leftjoin("niveles_estudios","niveles_estudios.id","=","estudios.nivel_estudio_id")
        ->leftjoin("periodicidad", "periodicidad.id", "=", "estudios.periodicidad")
        ->leftjoin("ciudad", function ($join) {
                $join->on("ciudad.cod_pais", "=", "estudios.pais_estudio")
                ->on("ciudad.cod_departamento", "=", "estudios.departamento_estudio")
                ->on("ciudad.cod_ciudad", "=", "estudios.ciudad_estudio");
            })
        ->select(
            "estudios.*",
            "niveles_estudios.descripcion as nivel",
            "ciudad.nombre as ciudad", 
            "periodicidad.descripcion as periodo"
            )
        ->first();

        $nivelEstudios = ["" => "Seleccionar"] + NivelEstudios::pluck("descripcion", "id")->toArray();
        
        return view("admin.reclutamiento.modal.gestionar_referencia_estudio_ref", compact("estudio", "nivelEstudios", "referencia_estudio"));
    }

     public function gestionar_estudio_candidato(Request $data)
    {
        $visita=null;
        if($data->has("id_visita"))
            $visita=$data->get("id_visita");

        

        $estudio=Estudios::where("estudios.id",$data->get("estudio_id"))
        ->leftjoin("niveles_estudios","niveles_estudios.id","=","estudios.nivel_estudio_id")
        ->leftjoin("ciudad", function ($join) {
                $join->on("ciudad.cod_pais", "=", "estudios.pais_estudio")
                ->on("ciudad.cod_departamento", "=", "estudios.departamento_estudio")
                ->on("ciudad.cod_ciudad", "=", "estudios.ciudad_estudio");
            })
        ->select("estudios.*","niveles_estudios.descripcion as nivel","ciudad.nombre as ciudad")
        ->first();

         /*$experiencia = Experiencias::leftjoin("paises", "paises.cod_pais", "=", "experiencias.pais_id")
            ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
            ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            ->leftjoin("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
                    ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
            })->leftjoin("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
                ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
            })
            ->select("aspiracion_salarial.descripcion as salario", "cargos_genericos.descripcion as desc_cargo", "motivos_retiros.descripcion as desc_motivo", \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudades"), "experiencias.*")
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->where("experiencias.id", $data->get("referencia_id"))
            ->first();*/

        
        return view("admin.reclutamiento.modal.gestionar_estudio_ref", compact("estudio","visita"));
    }

    public function editar_referencia_candidato(Request $data)
    {
         $experiencia = Experiencias::leftjoin("paises", "paises.cod_pais", "=", "experiencias.pais_id")
            ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
            ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            ->leftjoin("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
                    ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
            })->leftjoin("ciudad", function ($join2) {
              $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
                ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
            })
            ->select("aspiracion_salarial.descripcion as salario", "cargos_genericos.descripcion as desc_cargo", "motivos_retiros.descripcion as desc_motivo", \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudades"), "experiencias.*")
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->where("experiencias.id", $data->get("referencia_id"))
            ->first();

         $motivo_retiro = ["" => "Seleccionar"] + MotivoRetiro::pluck("descripcion", "id")->toArray();
        
         $proceso  = RegistroProceso::
            join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))->first();

         $competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")->
            where("competencias_cliente.cliente_id", $proceso->cliente_id)->get();
        
        $verificada = ExperienciaVerificada::where('experiencia_id',$experiencia->id)->first();

       return view("admin.reclutamiento.modal.gestionar_referencia_ref", compact("experiencia", "motivo_retiro", "competencias","verificada","proceso"));
    }

    public function gestionar_referencia_personal_candidato(Request $data)
    {
        $referencias_personales = ReferenciasPersonales::join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
            ->join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->select("referencias_personales.*", "tipo_relaciones.descripcion as relacion", DB::raw("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS ciudad_seleccionada"))
            ->where("referencias_personales.id", $data->get("referencia_id"))
            ->first();

        $motivo_retiro = ["" => "Seleccionar"] + MotivoRetiro::pluck("descripcion", "id")->toArray();
        $proceso       = RegistroProceso::
            join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))->first();
        $competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")->
            where("competencias_cliente.cliente_id", $proceso->cliente_id)->get();

        return view("admin.reclutamiento.modal.gestionar_ref_personal", compact("referencias_personales", "motivo_retiro", "competencias"));
    }

    public function editar_referencia_personal_candidato(Request $data)
    {
        $referencias_personales = ReferenciasPersonales::join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
            ->join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->select("referencias_personales.*", "tipo_relaciones.descripcion as relacion", DB::raw("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS ciudad_seleccionada"))
            ->where("referencias_personales.id", $data->get("referencia_id"))
            ->first();

        $motivo_retiro = ["" => "Seleccionar"] + MotivoRetiro::pluck("descripcion", "id")->toArray();
        
        $proceso   = RegistroProceso::
            join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))->first();
        
        $competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")->where("competencias_cliente.cliente_id", $proceso->cliente_id)->get();
        
        $verificada = ReferenciaPersonalVerificada::where('referencia_personal_id',$referencias_personales->id)->first();

        return view("admin.reclutamiento.modal.gestionar_ref_personal", compact("referencias_personales", "motivo_retiro", "competencias","verificada"));
    }

    public function guardar_referencia_verificada(Request $data)
    {
        $verificada = (isset($data->verificada_id))?$data->verificada_id:''; //validar si se va a editar o se va a crear una nueva
        //$this->validate($data, ['motivo_retiro_id' => 'required']);
        $proceso = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))
            ->first();
        
        $adecuado = $data->has("adecuado") ? "adecuado" : "no adecuado";
        if($verificada){
          $referencia = ExperienciaVerificada::find($verificada); //buscar la referencia existente
          $referencia->fill($data->except(["vinculo_familiar_cual", 
                                            "fecha_retiro", 
                                            "motivo_retiro_id", 
                                            "observaciones",
                                            "cuales_anotacion",
                                            "cuantas_personas"])+[
                "req_id" => $proceso->requerimiento_id, 
                "usuario_gestion" => $this->user->id, 
                "adecuado" => $adecuado,
                "vinculo_familiar"      => ($data->has('vinculo_familiar')?$data->vinculo_familiar:NULL),
                "vinculo_familiar_cual" => ($data->has('vinculo_familiar')?$data->vinculo_familiar_cual:NULL),
                "empleo_actual"         => ($data->has('empleo_actual')?$data->empleo_actual:NULL),
                "fecha_retiro"          => ($data->has('empleo_actual')?NULL:$data->fecha_retiro),
                "motivo_retiro_id"      => ($data->has('empleo_actual')?0:$data->motivo_retiro_id),
                "observaciones"         => ($data->has('empleo_actual')?NULL:$data->observaciones),
                "anotacion_hv"          => ($data->has('anotacion_hv')?$data->anotacion_hv:NULL),
                "cuales_anotacion"      => ($data->has('anotacion_hv')?$data->cuales_anotacion:NULL),
                "personas_cargo"        => ($data->has('personas_cargo')?$data->personas_cargo:NULL),
                "cuantas_personas"      => ($data->has('personas_cargo')?$data->cuantas_personas:0),
                "volver_contratarlo"    => ($data->has('volver_contratarlo')?$data->volver_contratarlo:NULL)
            ]);
        }else{
          $referencia = new ExperienciaVerificada();
          $referencia->fill($data->all()+["candidato_id" => $proceso->candidato_id, "req_id" => $proceso->requerimiento_id, "usuario_gestion" => $this->user->id, "adecuado" => $adecuado]);
        }       

        if(route("home") == "https://gpc.t3rsc.co"){

         $referencia->relacion_laboral = $data->relacion_laboral;
         $referencia->tiempo_juntos = $data->tiempo_juntos;
         $referencia->desempenio_candidato = $data->desempenio_candidato;
         $referencia->reforzar_desempenio = $data->reforzar_desempenio;
         $referencia->mayores_logros = $data->mayores_logros;
         $referencia->relacion_companieros = $data->relacion_companieros;
        }

        $referencia->save();

        //CALIFICANDO COMPETENCIAS
        if($data->has("competencia")) {
         foreach ($data->get("competencia") as $key => $value) {
                $nueva_calificacion = new CalificaCompetencia();
                $nueva_calificacion->fill([
                    "entidad_id"                => $referencia->id,
                    "competencia_entrevista_id" => $key,
                    "valor"                     => $value,
                    "tipo_entidad"              => "MODULO_REFERENCIACION",
                ]);
                $nueva_calificacion->save();
            }
        }

         $this->procesoRequerimiento($referencia->id, $data->get("ref_id"), "MODULO_REFERENCIACION", "EXPERIENCIA_LABORAL");
        return response()->json(["success" => true]);
    }

    public function guardar_referencia_estudio_verificada(Request $data)
    {   
        $verificada = (isset($data->verificada_id))?$data->verificada_id:false;

        $proceso = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))
            ->first();
        //dd($data->all());
        if($verificada){
            $referencia_estudio = ReferenciaEstudio::find($verificada);
        }else{
            $referencia_estudio = new ReferenciaEstudio();
        }
        
        $referencia_estudio->fill([
            "estudio_id"           => $data->estudios_id,
            "usuario_gestion"       => $this->user->id,
            "req_id"                => $proceso->requerimiento_id,
            "correos_institucion"   => $data->correos_institucion,
            "estudio_actual"        => $data->has("estudio_Actual")?1:0,
            "fecha_inicio"          => $data->fecha_inicio,
            "fecha_finalizacion"    => $data->has("estudio_Actual")?NULL:$data->fecha_finalizacion,
            "nivel_estudio_id"      => $data->nivel_estudio_id,
            "programa"              => $data->programa,
            "numero_acta"           => $data->numero_acta,
            "numero_folio"          => $data->numero_folio,
            "verificado"            => 0
        ]);

        $referencia_estudio->save();

        //para enviar correo a instituciones para que acepten o rechacen referencias
        if( $data->has("solicitar_referencia") ){
            
            $ruta = route('admin.gestionar_solicitud_referencia_academica', ["id"=> encrypt($referencia_estudio->id)]);
            
            $candidato = DatosBasicos::where("user_id", $proceso->candidato_id)->first();

            $sitio = Sitio::first();

            $requerimiento = Requerimiento::join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                    ->where("requerimientos.id", $proceso->requerimiento_id)
                    ->select(
                        "requerimientos.*",
                        "cargos_especificos.descripcion as cargo"
                    )
                    ->first();
                    
            $estudio = Estudios::find($data->estudios_id);

            $emails = $data->has('correos_institucion') ?  explode(",", $data->correos_institucion) : [];

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Solicitud de verificación de referencia académica"; //Titulo o tema del correo

            //Cuerpo con html y comillas dobles para las variables
            $mailBody = "Buen día, te informamos que el analista de selección de {$sitio->nombre} que está llevando a cabo el 
            proceso del candidato {$candidato->nombres} {$candidato->primer_apellido} {$candidato->segundo_apellido} para el cargo 
            {$requerimiento->cargo} te ha solicitado realizar la validación académica en el programa {$data->programa}. Por favor 
            ingresa por el siguiente botón para realizar la gestión.";

            //Arreglo para el botón
            $mailButton = ['buttonText' => 'GESTIONAR', 'buttonRoute' => $ruta];

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton);

            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($emails) {
    
                        $message->to($emails)
                        ->subject("Solicitud de verificación de referencia académica")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
        }else{

            //por si no envia referencia entonces la responde el mismo psicologo
            $referencia_estudio->verificado = $data->has("ratifica_informacion")?1:2;
            $referencia_estudio->observaciones_referenciante = $data->observaciones;
            $referencia_estudio->save();
        }

        return response()->json(["success" => true]);
    }

    public function gestionar_solicitud_referencia_estudio($id)
    {
        $idReferenciaEstudio = decrypt($id);
    
        $referencia = ReferenciaEstudio::join("estudios", "estudios.id", "=", "referencias_estudios.estudio_id")
                ->leftjoin("niveles_estudios","niveles_estudios.id","=","referencias_estudios.nivel_estudio_id")
                ->leftjoin("ciudad", function ($join) {
                    $join->on("ciudad.cod_pais", "=", "estudios.pais_estudio")
                    ->on("ciudad.cod_departamento", "=", "estudios.departamento_estudio")
                    ->on("ciudad.cod_ciudad", "=", "estudios.ciudad_estudio");
                })
                ->join("datos_basicos", "datos_basicos.user_id", "=", "estudios.user_id")
                ->leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
                ->where("referencias_estudios.id", $idReferenciaEstudio)
                ->select(
                    "datos_basicos.user_id",
                    "datos_basicos.nombres",
                    "datos_basicos.primer_apellido",
                    "datos_basicos.segundo_apellido",
                    "datos_basicos.numero_id",
                    "tipo_identificacion.descripcion as tipo_doc",
                    "estudios.institucion",
                    "estudios.titulo_obtenido",
                    "estudios.id as estudio_id",
                    "niveles_estudios.descripcion as nivel_estudio",
                    "ciudad.nombre as ciudad",
                    "referencias_estudios.id",
                    "referencias_estudios.fecha_inicio",
                    "referencias_estudios.fecha_finalizacion",
                    "referencias_estudios.programa",
                    "referencias_estudios.numero_acta",
                    "referencias_estudios.numero_folio",
                    "referencias_estudios.verificado"
                )
                ->first();

        $estudio = Estudios::find($referencia->estudio_id);
        
        $certificados = $estudio->certificados;

        return view("home.aceptacion_solicitud_referencia_academica", compact("referencia", "certificados"));
    }

    public function guardar_verificacion_referencia_estudio(Request $data)
    {   
        $validador = Validator::make($data->all(),
            [
              "nombres"         => "required",
              "cargo"           => "required"
            ]);

        if ($validador->fails()) {
            $mensaje = "Información no guardada, Error. Campos con asterisco(*) son obligatorios.";
            
            return back()->with(['mensaje_error' => $mensaje, "errors" => $validador->messages()]);
        }

        $referencia_estudio = ReferenciaEstudio::find($data->id);
        $referencia_estudio->fill([
                "nombre_referenciante"        => $data->nombres,
                "cargo_referenciante"         => $data->cargo,
                "observaciones_referenciante" => $data->observaciones
        ]);
            
        if( $data->aprobo == 'si' ){

            $referencia_estudio->verificado = 1;
            $proceso = RegistroProceso::where("candidato_id", $referencia_estudio->estudio->user_id)
                ->where("requerimiento_id", $referencia_estudio->req_id)
                ->where("proceso", "ENVIO_REFERENCIA_ESTUDIOS")
                ->orderBy("id", "DESC")
                ->first();

            $proceso->apto = 3;
            $proceso->save();

        }else if( $data->aprobo == 'no' ){
            $referencia_estudio->verificado = 2;
        }

        $referencia_estudio->save();

        $psicologo = User::find($referencia_estudio->usuario_gestion);

        $candidato = DatosBasicos::where('user_id', $referencia_estudio->estudio->user_id)->first();

        $requerimiento = Requerimiento::join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                    ->where("requerimientos.id", $referencia_estudio->req_id)
                    ->select(
                        "requerimientos.id",
                        "cargos_especificos.descripcion as cargo"
                    )
                    ->first();

        //espacio para email
        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Notificación de referencia académica verificada"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "Buen día, {$psicologo->name} te informamos que se ha realizado la verificación de 
            la referencia académica del candidato {$candidato->nombres} {$candidato->primer_apellido} {$candidato->segundo_apellido} 
            para el requerimiento No. {$requerimiento->id} para el cargo {$requerimiento->cargo}";

        //Arreglo para el botón
        $mailButton = [];

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($psicologo) {
    
            $message->to($psicologo->email)
                ->subject("Notificación de referencia académica verificada")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        return redirect()->route('admin.gestionar_solicitud_referencia_academica', ["id"=> encrypt($data->id)])->with(['mensaje_success' => "¡La referencia fue verificada exitosamente!"]);
    }

    public function guardar_estudio_verificado(Request $data)
    {
     
          $estudio = new EstudioVerificado();
          $estudio->fill($data->all()+["usuario_gestion" => $this->user->id]);

            
          $estudio->save();
        
        return response()->json(["success" => true]);
    }

    public function guardar_referencia_personal_verificada(Request $data)
    {
        $verificada = (isset($data->verificada_id))?$data->verificada_id:''; //validar si se va a editar o se va a crear una nueva

        $proceso = RegistroProceso::
            join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))->first();

        if($verificada){

          $referencia = ReferenciaPersonalVerificada::find($verificada);
          $referencia->fill($data->all() + ["req_id" => $proceso->requerimiento_id, "usuario_gestion" => $this->user->id]);

        }else{

          $referencia = new ReferenciaPersonalVerificada();
          $referencia->fill($data->all() + ["candidato_id" => $proceso->candidato_id, "req_id" => $proceso->requerimiento_id, "usuario_gestion" => $this->user->id]);
        }

        $referencia->save();

        $this->procesoRequerimiento($referencia->id, $data->get("ref_id"), "MODULO_REFERENCIACION", "REFERENCIA_PERSONAL");
        return response()->json(["success" => true]);
    }

    public function verificar_referencia_candidato(Request $data)
    {
        $experiencia = Experiencias::join("paises", "paises.cod_pais", "=", "experiencias.pais_id")
            ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
            ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
                    ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
                ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
        })
            ->select("aspiracion_salarial.descripcion as salario", "cargos_genericos.descripcion as desc_cargo", "motivos_retiros.descripcion as desc_motivo", \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudades"), "experiencias.*")
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->where("experiencias.id", $data->get("referencia_id"))
            ->first();

        $motivo_retiro = ["" => "Seleccionar"] + MotivoRetiro::pluck("descripcion", "id")->toArray();
        $proceso       = RegistroProceso::
            join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))->first();
        $competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")->
            where("competencias_cliente.cliente_id", $proceso->cliente_id)->get();

        //CARGAR REQUERIMIENTO SELECCIONADO
        $req = ExperienciaVerificada::where("id", $data->get("req_id"))->first();
        if ($req != null) {

            $competenciasEvaluadas = CalificaCompetencia::where("entidad_id", $req->id)->where("tipo_entidad", "MODULO_REFERENCIACION")->get();
            $arrayValores          = [];
            foreach ($competenciasEvaluadas as $key => $value) {
                $arrayValores[$value->competencia_entrevista_id] = $value->valor;
            }
            $req->competencia = $arrayValores;

            $req->ref_verificada = $req->id;
            $req->ref_id         = $data->get("ref_id");
        } else {
            $req = $data->all();
        }

        return view("admin.reclutamiento.modal.verificar_referencia_ref", compact("experiencia", "motivo_retiro", "competencias", "req"));
    }

    public function verificar_referencia_personal_candidato(Request $data)
    {
        $referencias_personales = ReferenciasPersonales::join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
            ->join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->select("referencias_personales.*", "tipo_relaciones.descripcion as relacion", DB::raw("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS ciudad_seleccionada"))
            ->where("referencias_personales.id", $data->get("referencia_id"))
            ->first();

        $motivo_retiro = ["" => "Seleccionar"] + MotivoRetiro::pluck("descripcion", "id")->toArray();

        $proceso       = RegistroProceso::
            join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))->first();

        $competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")->
            where("competencias_cliente.cliente_id", $proceso->cliente_id)->get();

        $referencia = ReferenciaPersonalVerificada::where("id", $data->get("req_id"))->first();
        
        if ($referencia != null) {
            $referencia->ref_id         = $data->get("ref_id");
            $referencia->ref_verificada = $referencia->id;
        } else {
            $referencia = $data->all();
        }

        return view("admin.reclutamiento.modal.verificar_ref_personal", compact("referencias_personales", "motivo_retiro", "competencias", "referencia"));
    }

    public function video_perfil_modal(Request $data)
    {
        //dd($data->all());
       $user = User::where('id',$data->user_id)
       ->first();
        //dd($user);
       return view("cv.modal.video_perfil_modal",compact('user'));
    }

    public function seguimiento_candidato(Request $data)
    {
        $user_sesion = $this->user;

        $cita = Citacion::where('req_candi_id', $data->get('candidato_req'))
        // ->where('estado', 0)->where('motivo_id', 13)
        ->first();

        $reqCandidato = RegistroProceso::leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
        ->where("procesos_candidato_req.requerimiento_candidato_id", $data->get("candidato_req"))
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
            'procesos_candidato_req.user_autorizacion',
            DB::raw('(select respuestas_entre.puntuacion from respuestas_entre inner join preguntas_entre on respuestas_entre.preg_entre_id=preguntas_entre.id inner join entrevista_virtual on preguntas_entre.entre_vir_id=entrevista_virtual.id where respuestas_entre.puntuacion is not null and respuestas_entre.candidato_id=procesos_candidato_req.candidato_id and entrevista_virtual.req_id=procesos_candidato_req.requerimiento_id order by respuestas_entre.id DESC limit 1) as puntuacion')
        )
        ->orderBy("procesos_candidato_req.id", "asc")
        ->groupBy("procesos_candidato_req.id")->get();

        $documento_aprobacion = Documentos::where('user_id', $data->candidato_id)
            ->where('requerimiento', $data->req_id)
            ->where('tipo_documento_id', config('conf_aplicacion.C_SOPORTE_APROBACION_CLIENTE'))
            ->orderBy('id', 'desc')
        ->first();

        $estadoCandidato = RegistroProceso::join("estados", "estados.id", "=", "procesos_candidato_req.estado")
        ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
        ->leftjoin('entrevistas_candidatos', 'entrevistas_candidatos.req_id', '=', 'requerimientos.id')
        ->select(
            'procesos_candidato_req.proceso as nombre_proceso',
            'entrevistas_candidatos.asistio as asis',
            "procesos_candidato_req.created_at",
            "procesos_candidato_req.usuario_envio",
            "estados.descripcion as estado_desc"
        )
        ->where("procesos_candidato_req.requerimiento_candidato_id", $data->get("candidato_req"))
        ->where("procesos_candidato_req.proceso",'<>',"")
        //->where("entrevistas_candidatos.candidato_id", $data->get("candidato_id"))
        ->groupBy("estados.descripcion", "procesos_candidato_req.created_at", "procesos_candidato_req.usuario_envio")
        ->orderBy("procesos_candidato_req.created_at", "desc")
        ->get();


        $asistencia = EntrevistaCandidatos::join('requerimientos', 'requerimientos.id', '=', 'entrevistas_candidatos.req_id')
        ->select('entrevistas_candidatos.asistio as asis')
        ->where("entrevistas_candidatos.candidato_id", $data->get("candidato_id"))
        ->where("entrevistas_candidatos.req_id", $data->get("req_id"))
        ->get();
        
        $factor = null;

        //Promedio de respuesta para prueba idioma
        $selectRespuestas =  PreguntasPruebaIdioma::join('pruebas_idiomas', 'pruebas_idiomas.id', '=', 'preguntas_pruebas_idiomas.prueba_idio_id')
        ->join('respuestas_pruebas_idiomas', 'respuestas_pruebas_idiomas.preg_prueba_id', '=', 'preguntas_pruebas_idiomas.id')
        ->where('candidato_id', $data->get("candidato_id"))
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

        if($sitioModulo->consulta_seguridad === 'enabled'){
            $factor = ConsultaSeguridad::where('user_id', $data->get("candidato_id"))
            ->where('req_id', $data->get("req_id"))
            ->first();

            $consulta_seguridad_proceso = RegistroProceso::where('candidato_id', $data->get("candidato_id"))
            ->where('requerimiento_id', $data->get("req_id"))
            ->where('proceso', 'CONSULTA_SEGURIDAD')
            ->first();
        }

        if($sitioModulo->listas_vinculantes === 'enabled'){
            $factor_listas_vinculantes = ConsultaListaVinculante::where('user_id', $data->get("candidato_id"))
            ->where('req_id', $data->get("req_id"))
            ->first();

            $listas_vinculantes_proceso = RegistroProceso::where('candidato_id', $data->get("candidato_id"))
            ->where('requerimiento_id', $data->get("req_id"))
            ->where('proceso', 'LISTAS_VINCULANTES')
            ->first();
        }

        //Busca contrato
        $firma_contrato = FirmaContratos::where('user_id', $data->get("candidato_id"))
        ->where('req_id', $data->get("req_id"))
        ->orderBy('created_at', 'DESC')
        ->first();

        $datos_status_candidato = null;
        $datos_status_gestion = null;

        if ($firma_contrato != null) {
            $datos_status_candidato = DatosBasicos::where('user_id', $data->get("candidato_id"))->first();
            $datos_status_gestion = DatosBasicos::where('user_id', $firma_contrato->gestion)->first();
        }

        $observacion_hv = ObservacionesHv::join('users', 'users.id', '=', 'observaciones_hoja_vida.user_gestion')
        ->select('observaciones_hoja_vida.*', 'users.name as nombre')
        ->where('candidato_id', $data->get("candidato_id"))
        ->orderBy("observaciones_hoja_vida.id", "DESC")
        ->take(3)
        ->get();

        //Token de acceso a la firma
        $token_firma = RegistroProceso::where('requerimiento_id', $data->get("req_id"))
        ->where('candidato_id', $data->get("candidato_id"))
        ->whereNotNull('codigo_validacion')
        ->select('codigo_validacion')
        ->orderBy('created_at', 'DESC')
        ->first();

        $candidato_id = $data->get("candidato_id");
        $req_id = $data->get("req_id");

        if(route("home") == "https://vym.t3rsc.co" || route("home") == "https://listos.t3rsc.co") {
            //Buscar detalle de la consulta en truora
            $checkTruoraDetail = TruoraIntegrationController::getCheckDetails($data->get("candidato_id"), $data->get("req_id"));

            if (!empty($checkTruoraDetail)) {
                $generated_check = $checkTruoraDetail['check']['check_id'];
                $generated_puntaje = $checkTruoraDetail['check']['score'];
                $generated_status = $checkTruoraDetail['check']['status'];
                $generated_score = $generated_puntaje * 100;

                return view("admin.reclutamiento.modal._modal_seguimiento_candidato", compact(
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
                    "observacion_hv",
                    "cita",
                    "documento_aprobacion",
                    "token_firma",
                    "candidato_id",
                    "req_id",
                    "sitioModulo",
                    "factor_listas_vinculantes",
                    "consulta_seguridad_proceso",
                    "listas_vinculantes_proceso"
                ));
            }
        }

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
            "cita",
            "documento_aprobacion",
            "observacion_hv",
            "token_firma",
            "candidato_id",
            "req_id",
            "sitioModulo",
            "factor_listas_vinculantes",
            "consulta_seguridad_proceso",
            "listas_vinculantes_proceso"
        ));
    }

    public function estados_requerimiento(Request $data)
    {
        $req_id = $data->get("req_id");

        $sitio = Sitio::first();

        if ( $sitio->asistente_contratacion==1 ) {
            $req_contra = FirmaContratos::whereIn("terminado", [1,2])->whereNotIn("estado", [0])->where("req_id", $data->get("req_id"))->first();
        }else{
            $req_contra = RegistroProceso::where('requerimiento_id',$data->req_id)
            ->where('proceso','ENVIO_CONTRATACION')
            ->first();
        }

        $requerimiento = Requerimiento::find($data->req_id);
        $estados_mostrar = [];

        if ($req_contra == null) {
            
            if ( in_array($requerimiento->tipo_proceso_id, [1, 4]) ) {
                $estados_mostrar+=[config('conf_aplicacion.C_TERMINADO')];
            }

            $estados_mostrar+=[1,2,3,17];

            $estado = ["" => "Seleccionar"] + Estados::whereIn("id", $estados_mostrar)
                ->pluck("descripcion", "id")
                ->toArray();
        }else{
            $estados_mostrar+=[3];
            $estado =  ["" => "Seleccionar"] + Estados::whereIn("id", $estados_mostrar)
            ->pluck("descripcion", "id")
            ->toArray();
        }

        $motivos=["" => "Seleccionar"] +MotivoEstadoRequerimiento::pluck("descripcion", "id")->toArray();
    
        return view("admin.reclutamiento.modal.estados_requerimiento", compact("estado","req_id","motivos"));
    }

    public function terminar_requerimiento(Request $campos)
    {
        $estado_req = $campos->get("estado_requerimiento");
        
        $validator = Validator::make($campos->all(),[
           "estado_requerimiento"      => "required",
           "observaciones_terminacion" => "required",
           "motivo_cancelacion"        => "required"
        ],
        [
            "motivo_cancelacion.required" => "El campo motivo es obligatorio",
            "observaciones_terminacion.required" => "El campo observaciones es obligatorio"
        ]);

        $req_id = $campos->get("req_id");


        $sitio = Sitio::first();

        if ( $sitio->asistente_contratacion==1 ) {
            $req_contra = FirmaContratos::whereIn("terminado", [1,2])->whereNotIn("estado", [0])->where("req_id",$campos->req_id)->first();
        }else{
            $req_contra = RegistroProceso::where('requerimiento_id',$campos->req_id)
            ->where('proceso','ENVIO_CONTRATACION')
            ->first();
        }

        $requerimiento = Requerimiento::find($data->req_id);
        $estados_mostrar = [];

        if ($req_contra == null) {
            
            if ( in_array($requerimiento->tipo_proceso_id, [1, 4]) ) {
                $estados_mostrar+=[config('conf_aplicacion.C_TERMINADO')];
            }

            $estados_mostrar+=[1,2,3,17];

            $estado = ["" => "Seleccionar"] + Estados::whereIn("id", $estados_mostrar)
                ->pluck("descripcion", "id")
                ->toArray();
        }else{
            $estados_mostrar+=[3];
            $estado =  ["" => "Seleccionar"] + Estados::whereIn("id", $estados_mostrar)
            ->pluck("descripcion", "id")
            ->toArray();
        }

        $motivos=["" => "Seleccionar"] +MotivoEstadoRequerimiento::pluck("descripcion", "id")->toArray();

        if($validator->fails()) {
            return response()->json(["success" => false, "view" => view("admin.reclutamiento.modal.estados_requerimiento", compact("estado","req_id","motivos"))->withErrors($validator)->render()]);
        }

        /* 
            $req_contra = RegistroProceso::where('requerimiento_id',$campos->req_id)
            ->where('proceso','ENVIO_CONTRATACION')
            ->first();

            if ($req_contra) {
                $mensaje = "Este requerimiento esta en proceso de contratación";
                return response()->json(["success" => false, "mensaje_error" => $mensaje, 'req_id' => $campos->get("req_id")]);
            }
        */

        if(route('home') =="http://komatsu.t3rsc.co" || route('home') =="https://komatsu.t3rsc.co"){
            if($campos->get("estado_requerimiento") == 24){
                $estado =  16;
           }
        }

        $requerimiento = new EstadosRequerimientos();

        $requerimiento->fill([
            "req_id"        => $campos->get("req_id"),
            "observaciones" => $campos->get("observaciones_terminacion"),
            "user_gestion"  => $this->user->id,
            "estado"        => $estado_req,
            "motivo"        => $campos->get("motivo_cancelacion")
        ]);
        
        $requerimiento->save();

        // Se cambia el estado publico del requerimiento
        $req                 = Requerimiento::find($campos->get("req_id"));
        $req->estado_publico = 0;
        $req->save();
        //HABILITAR CANDIDATOS
        $candidatos_req = EloquentUser::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
        ->where("requerimiento_cantidato.requerimiento_id", $campos->get("req_id"))
        ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
        ->whereRaw(" requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
        ->select("datos_basicos.*", "requerimiento_cantidato.estado_candidato", "estados.descripcion as estado_candidatos", "requerimiento_cantidato.id as req_candidato_id")
        ->get();

        foreach ($candidatos_req as $key => $value) {
            if (!in_array($value->estado_candidato, [config('conf_aplicacion.C_CONTRATADO')])) {
                $datosbasicos                       = DatosBasicos::find($value->id);
                $datosbasicos->estado_reclutamiento = config("conf_aplicacion.C_ACTIVO");
                $datosbasicos->save();

                if( in_array($estado_req, [1, 2, 3]) ) {
                    //ENVIAR MAIL A CANDIDATOS NO CONTRATADOS

                    $nombres = $datosbasicos->nombres .' '. $datosbasicos->primer_apellido;
                    $asunto = "¡Gracias por tu aplicación a la vacante!";
                    $emails = $datosbasicos->email;

                    $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                    $mailConfiguration = 1; //Id de la configuración
                
                    $mailTitle = "¡Gracias por tu aplicación a la vacante!"; //Titulo o tema del correo

                    //Cuerpo con html y comillas dobles para las variables
                    $mailBody = "Estimado(a) $nombres.<br><br>

                        Te informamos que después del análisis de tu hoja de vida, hemos decidido dar por culminado tu proceso de selección para esta propuesta laboral.<br><br>

                        Te agradecemos haber dispuesto del tiempo que requerimos, tu compromiso e interés constante. Toda tu información quedará registrada en nuestra base de datos, bajo las directrices de completa confidencialidad. <br><br>

                        Cordialmente, <br><br>

                        <i>Equipo de Selección</i>";

                    //Arreglo para el botón
                    $mailButton = ['buttonText' => 'ACCEDER', 'buttonRoute' => route('login')];

                    $mailUser = $datosbasicos->user_id; //Id del usuario al que se le envía el correo

                    $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                    Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($emails, $asunto) {
                        $message->to([$emails]);
                        $message->subject($asunto)
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                }
            }
        }

        try {
            //Despublicar en TCN Oferta
            if (route("home") == "http://talentum.t3rsc.co" || route("home") == "https://talentum.t3rsc.co" ||
                route("home") == "http://pta.t3rsc.co" || route("home") == "https://pta.t3rsc.co" ||
                route("home") == "http://temporizar.t3rsc.co" || route("home") == "https://temporizar.t3rsc.co" ||
                route("home") == "http://soluciones.t3rsc.co" || route("home") == "https://soluciones.t3rsc.co" ||
                route("home") == "http://nases.t3rsc.co" || route("home") == "https://nases.t3rsc.co" ||
                route("home") == "http://listos.t3rsc.co" || route("home") == "https://listos.t3rsc.co" ||
                route("home") == "http://vym.t3rsc.co" || route("home") == "https://vym.t3rsc.co" ||
                route("home") == "http://gigha.t3rsc.co" || route("home") == "https://gigha.t3rsc.co") {
                //Login en TCN
                $tcn = new Client([
                    'base_uri' => "https://www.trabajaconnosotros.com.co/api/login_empresas",
                    'headers' => [
                        'Accept'        => 'application/json'
                    ],
                    'form_params' => [
                        'email'    => env('EMAIL_TCN'),
                        'password' => env('PASS_TCN')
                    ]
                ]);

                $companyLogged = $tcn->request('POST');
                $convert =  json_decode( $companyLogged->getBody()->getContents() );

                $tokenTcn = $convert->token;

                //Despublicar
                $tcnUnpublish = new Client([
                    'base_uri' => "https://www.trabajaconnosotros.com.co/api/despublicar_oferta_desde_instancias",
                    'headers' => [
                        'Authorization' => 'Bearer '.$tokenTcn,
                        'Accept'        => 'application/json'
                    ],
                    'form_params' => [
                        'oferta_id_instancia' => $campos->get("req_id"),
                    ]
                ]);

                $companyUnpublished = $tcnUnpublish->request('POST');
                $responseOffer =  json_decode( $companyUnpublished->getBody()->getContents() );
            }
        } catch (\Throwable $t) {
            return response()->json(["success" => true]);
        }

        return response()->json(["success" => true]);
    }

    public function guardar_carga_scanner(Request $data)
    {
        $rules = [
            'identificacion'   => 'required',
            'primer_nombre'    => 'required',
            'primer_apellido'  => 'required',
            'genero'           => 'required|not_in:0|',
            'rh'               => 'required',
            'fecha_nacimiento' => 'required',
        ];

        $valida = Validator::make($data->all(), $rules);
        
        if ($valida->fails()) {
            return redirect()->back()->withErrors($valida)->withInput();
        }

        $cedula = DatosBasicos::where("numero_id", $data->get('identificacion'))->first();

        $candidato_req = User::where("numero_id", $data->get('identificacion'))
            ->leftjoin('requerimiento_cantidato','requerimiento_cantidato.candidato_id','=','users.id')
            ->select('requerimiento_cantidato.requerimiento_id')
            ->first();

        //dd($candidato_req);

        if($cedula != null){

            /*if($data->get('rh') == "O+"){

                $cedula = User::where("numero_id", $data->get('identificacion'))->first();

                $usuario = DatosBasicos::where("user_id", $cedula->id)->first();

                $rh = "O+";

                $usuario->grupo_sanguineo = $rh;
                $usuario->nombres = $data->get('primer_nombre') . " " . $data->get('segundo_nombre');
                $usuario->primer_apellido = $data->get('primer_apellido');
                $usuario->datos_basicos_count = "100";

                $usuario->save();

                $u_id = $usuario->user_id;
                  
                if ($candidato_req->requerimiento_id == true) {
                    
                    $cargaScanner = new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        "asistencia"       => 1,
                    ]);

                    $cargaScanner->save();

                }else{

                    $cargaScanner =  new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        
                    ]);

                    $cargaScanner->save();

                }

                return redirect()->route("admin.lista_carga_scanner")->with("mensaje_success", "El usuario ya existe en el sistema");
            }

            if($data->get('rh') == "O-"){

                $cedula = User::where("numero_id", $data->get('identificacion'))->first();

                $usuario = DatosBasicos::where("user_id", $cedula->id)->first();

                $rh = "O-";

                $usuario->grupo_sanguineo = $rh;
                $usuario->nombres = $data->get('primer_nombre') . " " . $data->get('segundo_nombre');
                $usuario->primer_apellido = $data->get('primer_apellido');
                $usuario->datos_basicos_count = "100";

                $usuario->save();

                $u_id = $usuario->user_id;
                  
                if ($candidato_req->requerimiento_id == true) {
                    
                    $cargaScanner = new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        "asistencia"       => 1,
                    ]);

                    $cargaScanner->save();

                }else{

                    $cargaScanner =  new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        
                    ]);

                    $cargaScanner->save();

                }

                return redirect()->route("admin.lista_carga_scanner")->with("mensaje_success", "El usuario ya existe en el sistema");
            }

            if($data->get('rh') == "A+"){

                $cedula = User::where("numero_id", $data->get('identificacion'))->first();

                $usuario = DatosBasicos::where("user_id", $cedula->id)->first();

                $rh = "A+";

                $usuario->grupo_sanguineo = $rh;
                $usuario->nombres = $data->get('primer_nombre') . " " . $data->get('segundo_nombre');
                $usuario->primer_apellido = $data->get('primer_apellido');
                $usuario->datos_basicos_count = "100";

                $usuario->save();

                $u_id = $usuario->user_id;
                  
                if ($candidato_req->requerimiento_id == true) {
                    
                    $cargaScanner = new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        "asistencia"       => 1,
                    ]);

                    $cargaScanner->save();

                }else{

                    $cargaScanner =  new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        
                    ]);

                    $cargaScanner->save();

                }

                return redirect()->route("admin.lista_carga_scanner")->with("mensaje_success", "El usuario ya existe en el sistema");
            }

            if($data->get('rh') == "A-"){

                $cedula = User::where("numero_id", $data->get('identificacion'))->first();

                $usuario = DatosBasicos::where("user_id", $cedula->id)->first();

                $rh = "A-";

                $usuario->grupo_sanguineo = $rh;
                $usuario->nombres = $data->get('primer_nombre') . " " . $data->get('segundo_nombre');
                $usuario->primer_apellido = $data->get('primer_apellido');
                $usuario->datos_basicos_count = "100";

                $usuario->save();

                $u_id = $usuario->user_id;
                  
                if ($candidato_req->requerimiento_id == true) {
                    
                    $cargaScanner = new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        "asistencia"       => 1,
                    ]);

                    $cargaScanner->save();

                }else{

                    $cargaScanner =  new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        
                    ]);

                    $cargaScanner->save();

                }

                return redirect()->route("admin.lista_carga_scanner")->with("mensaje_success", "El usuario ya existe en el sistema");
            }

            if($data->get('rh') == "B+"){

                $cedula = User::where("numero_id", $data->get('identificacion'))->first();

                $usuario = DatosBasicos::where("user_id", $cedula->id)->first();

                $rh = "B+";

                $usuario->grupo_sanguineo = $rh;
                $usuario->nombres = $data->get('primer_nombre') . " " . $data->get('segundo_nombre');
                $usuario->primer_apellido = $data->get('primer_apellido');
                $usuario->datos_basicos_count = "100";

                $usuario->save();

                $u_id = $usuario->user_id;
                  
                if ($candidato_req->requerimiento_id == true) {
                    
                    $cargaScanner = new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        "asistencia"       => 1,
                    ]);

                    $cargaScanner->save();

                }else{

                    $cargaScanner =  new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        
                    ]);

                    $cargaScanner->save();

                }

                return redirect()->route("admin.lista_carga_scanner")->with("mensaje_success", "El usuario ya existe en el sistema");
            }

            if($data->get('rh') == "B-"){

                $cedula = User::where("numero_id", $data->get('identificacion'))->first();

                $usuario = DatosBasicos::where("user_id", $cedula->id)->first();

                $rh = "B-";

                $usuario->grupo_sanguineo = $rh;
                $usuario->nombres = $data->get('primer_nombre') . " " . $data->get('segundo_nombre');
                $usuario->primer_apellido = $data->get('primer_apellido');
                $usuario->datos_basicos_count = "100";

                $usuario->save();

                $u_id = $usuario->user_id;
                  
                if ($candidato_req->requerimiento_id == true) {
                    
                    $cargaScanner = new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        "asistencia"       => 1,
                    ]);

                    $cargaScanner->save();

                }else{

                    $cargaScanner =  new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        
                    ]);

                    $cargaScanner->save();

                }

                return redirect()->route("admin.lista_carga_scanner")->with("mensaje_success", "El usuario ya existe en el sistema");
            }

            if($data->get('rh') == "AB+"){

                $cedula = User::where("numero_id", $data->get('identificacion'))->first();

                $usuario = DatosBasicos::where("user_id", $cedula->id)->first();

                $rh = "AB+";

                $usuario->grupo_sanguineo = $rh;
                $usuario->nombres = $data->get('primer_nombre') . " " . $data->get('segundo_nombre');
                $usuario->primer_apellido = $data->get('primer_apellido');
                $usuario->datos_basicos_count = "100";

                $usuario->save();

                $u_id = $usuario->user_id;
                  
                if ($candidato_req->requerimiento_id == true) {
                    
                    $cargaScanner = new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        "asistencia"       => 1,
                    ]);

                    $cargaScanner->save();

                }else{

                    $cargaScanner =  new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        
                    ]);

                    $cargaScanner->save();

                }

                return redirect()->route("admin.lista_carga_scanner")->with("mensaje_success", "El usuario ya existe en el sistema");
            }

            if($data->get('rh') == "AB-"){

                $cedula = User::where("numero_id", $data->get('identificacion'))->first();

                $usuario = DatosBasicos::where("user_id", $cedula->id)->first();

                $rh = "AB-";

                $usuario->grupo_sanguineo = $rh;
                $usuario->nombres = $data->get('primer_nombre') . " " . $data->get('segundo_nombre');
                $usuario->primer_apellido = $data->get('primer_apellido');
                $usuario->datos_basicos_count = "100";

                $usuario->save();

                $u_id = $usuario->user_id;
                  
                if ($candidato_req->requerimiento_id == true) {
                    
                    $cargaScanner = new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        "asistencia"       => 1,
                    ]);

                    $cargaScanner->save();

                }else{

                    $cargaScanner =  new CargaScanner();
                    
                    $cargaScanner->fill(
                    [
                        "identificacion"   => $data->get('identificacion'),
                        "primer_nombre"    => $data->get('primer_nombre'),
                        "segundo_nombre"   => $data->get('segundo_nombre'),
                        "primer_apellido"  => $data->get('primer_apellido'),
                        "segundo_apellido" => $data->get('segundo_apellido'),
                        "genero"           => $data->get('genero'),
                        "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                        "rh"               => $rh,
                        "user_carga"       => $u_id,
                        "user_gestion"     => $this->user->id,
                        
                    ]);

                    $cargaScanner->save();

                }

                return redirect()->route("admin.lista_carga_scanner")->with("mensaje_success", "El usuario ya existe en el sistema");
            }*/

            $cedula = User::where("numero_id", $data->get('identificacion'))->first();

            $usuario = DatosBasicos::where('numero_id', $cedula->numero_id)->first();


            $usuario->grupo_sanguineo = $data->get('rh');
            $usuario->nombres = $data->get('primer_nombre') . " " . $data->get('segundo_nombre');
            $usuario->primer_apellido = $data->get('primer_apellido');
            

            $usuario->save();

            $u_id = $usuario->user_id;

            if ($candidato_req->requerimiento_id == true) {
                    
                $cargaScanner = new CargaScanner();
                

                $cargaScanner->identificacion = $data->get('identificacion');
                $cargaScanner->primer_nombre = $data->get('primer_nombre');
                $cargaScanner->segundo_nombre = $data->get('segundo_nombre');
                $cargaScanner->primer_apellido = $data->get('primer_apellido');
                $cargaScanner->segundo_apellido = $data->get('segundo_apellido');
                $cargaScanner->genero = $data->get('genero');
                $cargaScanner->fecha_nacimiento = $data->get('fecha_nacimiento');
                $cargaScanner->rh = $data->get('rh');
                $cargaScanner->user_carga = $u_id;
                $cargaScanner->user_gestion = $this->user->id;
                $cargaScanner->asistencia = 1;

                /*$cargaScanner->fill(
                [
                    "identificacion"   => $data->get('identificacion'),
                    "primer_nombre"    => $data->get('primer_nombre'),
                    "segundo_nombre"   => $data->get('segundo_nombre'),
                    "primer_apellido"  => $data->get('primer_apellido'),
                    "segundo_apellido" => $data->get('segundo_apellido'),
                    "genero"           => $data->get('genero'),
                    "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                    "rh"               => $rh,
                    "user_carga"       => $u_id,
                    "user_gestion"     => $this->user->id,
                    "asistencia"       => 1,
                ]);*/

                $cargaScanner->update();

            }else{

                $cargaScanner =  new CargaScanner();
                
                $cargaScanner->identificacion = $data->get('identificacion');
                $cargaScanner->primer_nombre = $data->get('primer_nombre');
                $cargaScanner->segundo_nombre = $data->get('segundo_nombre');
                $cargaScanner->primer_apellido = $data->get('primer_apellido');
                $cargaScanner->segundo_apellido = $data->get('segundo_apellido');
                $cargaScanner->genero = $data->get('genero');
                $cargaScanner->fecha_nacimiento = $data->get('fecha_nacimiento');
                $cargaScanner->rh = $data->get('rh');
                $cargaScanner->user_carga = $u_id;
                $cargaScanner->user_gestion = $this->user->id;

                /*$cargaScanner->fill(
                [
                    "identificacion"   => $data->get('identificacion'),
                    "primer_nombre"    => $data->get('primer_nombre'),
                    "segundo_nombre"   => $data->get('segundo_nombre'),
                    "primer_apellido"  => $data->get('primer_apellido'),
                    "segundo_apellido" => $data->get('segundo_apellido'),
                    "genero"           => $data->get('genero'),
                    "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                    "rh"               => $rh,
                    "user_carga"       => $u_id,
                    "user_gestion"     => $this->user->id,
                ]);*/

                $cargaScanner->update();

            }

            return redirect()->route("admin.lista_carga_scanner")->with("mensaje_success", "El usuario ya existe en el sistema");

        }

        //Usuario no existentes los crea en las dos tablas
        $sitio = Sitio::first();

        $req_id = $data->req_id;

        $fecha            = Carbon::parse($data->get('fecha_nacimiento'));
        $fecha_nacimiento = $fecha->toDateString();
        //dd($data->get('identificacion'));
        $identificacion = trim($data->get('identificacion'));

        $cc = (string)$identificacion;

        if($cc[0] == 0 && $cc[1] == 0){ $cc = str_replace("00","",$cc); }

        //dd($cc);
        $segundo_nombre = ($data->get('segundo_nombre') != '' && $data->get('segundo_nombre') != null ? " " . $data->get('segundo_nombre') : '');

        $campos_usuario = [
            'name'      => $data->get('primer_nombre') . $segundo_nombre . " " . $data->get('primer_apellido') . " " . $data->get('segundo_apellido'),
            'password'  => $cc,
            'numero_id' => $identificacion,
            'email'     => $sitio->email_replica,
            'metodo_carga' => 4,
            'usuario_carga' =>$this->user->id
        ];
        $user       = Sentinel::registerAndActivate($campos_usuario);
        $role = Sentinel::findRoleBySlug('hv');
        $role->users()->attach($user);
        $usuario_id = $user->id;        

        if ($data->get('genero') == "M") {
            
            $genero = 1;

        }elseif ($data->get('genero') == "F") {
            
            $genero = 2;

        }

        $datos_basicos = new DatosBasicos();
        $datos_basicos->fill([
            'genero'               => $genero,
            'numero_id'            => $identificacion,
            'user_id'              => $usuario_id,
            'nombres'              => $data->get('primer_nombre') . $segundo_nombre,
            "primer_nombre"        => $data->get('primer_nombre'),
            "segundo_nombre"       => $data->get('segundo_nombre'),
            'email'                => $sitio->email_replica,
            'fecha_nacimiento'     => $fecha_nacimiento,
            'primer_apellido'      => $data->get('primer_apellido'),
            'segundo_apellido'     => $data->get('segundo_apellido'),
            'estado_reclutamiento' => config('conf_aplicacion.C_ACTIVO')

        ]);

        $mensaje_success = "La persona se ha guardado con éxito.";

        //Se verifica si a la persona que se registra esta en la lista negra, se coloca en estado_reclutamiento, que tiene problema de seguridad
        $cand_lista_negra = ListaNegra::where('cedula', $datos_basicos->numero_id)->first();
        if ($cand_lista_negra != null) {
            $datos_basicos->estado_reclutamiento = config('conf_aplicacion.PROBLEMA_SEGURIDAD');
            $mensaje_success .= " Pero presenta problemas de seguridad.";

            $datos_basicos->save();

            if ($cand_lista_negra->restriccion_id != '' && $cand_lista_negra->restriccion_id != null) {
                $restriccion = DB::table('tipos_restricciones')->select('descripcion', 'id')->find($cand_lista_negra->restriccion_id);
            } else {
                $restriccion = collect(['descripcion' => 'no hay una restricción guardada.']);
            }

            if ($cand_lista_negra->gestiono != '' && $cand_lista_negra->gestiono != null) {
                $gestiono = $cand_lista_negra->gestiono;
            } else {
                $gestiono = $this->user->id;
            }

            //ACTIVAR USUARIO Evento
            $auditoria                = new Auditoria();
            $auditoria->observaciones = 'Se registro por carga scanner y se encuentra en listado especial con la restricción ' . $restriccion->descripcion;
            $auditoria->valor_antes   = json_encode(["estado" => config('conf_aplicacion.C_ACTIVO')]);
            $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.PROBLEMA_SEGURIDAD')]);
            $auditoria->user_id       = $gestiono;
            $auditoria->tabla         = "datos_basicos";
            $auditoria->tabla_id      = $datos_basicos->id;
            $auditoria->tipo          = 'ACTUALIZAR';
            event(new \App\Events\AuditoriaEvent($auditoria));
        }

        $datos_basicos->save();

        $cargaScanner = new CargaScanner();
        $cargaScanner->fill([
            "identificacion"   => $identificacion,
            "primer_nombre"    => $data->get('primer_nombre'),
            "segundo_nombre"   => $data->get('segundo_nombre'),
            "primer_apellido"  => $data->get('primer_apellido'),
            "segundo_apellido" => $data->get('segundo_apellido'),
            "genero"           => $data->get('genero'),
            "fecha_nacimiento" => $data->get('fecha_nacimiento'),
            "rh"               => $data->get('rh'),
            "user_carga"       => $usuario_id,
            "user_gestion"     => $this->user->id,
        ]);
        $cargaScanner->save();

        if ($datos_basicos->estado_reclutamiento != config('conf_aplicacion.PROBLEMA_SEGURIDAD') && !is_null($req_id)) {
            $requerimiento = Requerimiento::where('id', $req_id)->select('id', 'tipo_proceso_id')->first();
            if ($requerimiento != null && $requerimiento->tipo_proceso_id == $sitio->id_proceso_sitio) {
                $req_candi = new ReqCandidato();

                $req_candi->fill([
                    'requerimiento_id' => $req_id,
                    'candidato_id'     => $usuario_id,
                    'estado_candidato' => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                    'otra_fuente' => 11
                ]);
 
                $req_candi->save();

                //Se cambia el estado de reclutamiento del candidato
                $datos_basicos->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                $datos_basicos->save();

                //Se guarda que el candidato asistio
                $cargaScanner->asistencia = 1;
                $cargaScanner->save();

                $req_can_id = $req_candi->id;

                $nuevo_proceso = new RegistroProceso();

                $nuevo_proceso->fill(
                    [
                        'requerimiento_candidato_id' => $req_can_id,
                        'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        'fecha_inicio'               => date("Y-m-d H:i:s"),
                        'usuario_envio'              => $this->user->id,
                        'requerimiento_id'           => $req_id,
                        'candidato_id'               => $usuario_id,
                        'observaciones'              => "Ingreso al requerimiento por scanner",
                    ]
                );
                $nuevo_proceso->save();

                $campos = [
                    'requerimiento_candidato_id' => $req_can_id,
                    'usuario_envio'      => $this->user->id,
                    "fecha_inicio"       => date("Y-m-d H:i:s"),
                    'proceso'            => "ENVIO_APROBAR_CLIENTE",
                    'observaciones'      => "Se ha enviado a aprobar por el cliente desde scanner"
                ];

                //Se crea el proceso evaluacion del cliente
                $this->RegistroProceso($campos, config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), $req_can_id);

                $mensaje_success .= " La persona se ha asociado al requerimiento #$req_id.";
                return redirect()->route("admin.lista_carga_scanner", ['req_id' => $req_id])->with("mensaje_success", $mensaje_success);
            }
        }

        return redirect()->route("admin.lista_carga_scanner")->with("mensaje_success", $mensaje_success);
    }

    public function enviar_requerimiento_scanner(Request $data)
    {

        $rules = [
            'req_id'     => 'required',
            'user_carga' => 'required',
        ];

        $valida = Validator::make($data->all(), $rules);
        if ($valida->fails()) {
            return redirect()->back()->withErrors($valida)->withInput();
        }

        $requerimiento = $data->get('req_id');
        $users_id      = $data->get('user_carga');
        //dd($users_id);

        $errores_global      = [];
        $registrosInsertados = 0;

        foreach ($users_id as $key => $user_id) {

            $errores = [];

            $guardar = true;

            $datos_basicos = DatosBasicos::where("user_id", $user_id)->first();

            if ($datos_basicos != null) {
                if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD')) {
                    $guardar = false;
                    array_push($errores, "El usuario no se puede asociar al requerimiento porque presenta problemas de seguridad.");
                    $errores_global[$key] = $errores;
                    continue;
                } elseif ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_BAJA_VOLUNTARIA')) {
                    $guardar = false;
                    array_push($errores, "El usuario no se puede asociar al requerimiento porque solicitó baja voluntaria en la plataforma.");
                    $errores_global[$key] = $errores;
                    continue;
                } elseif ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO')) {
                    $guardar = false;
                    array_push($errores, "El usuario no se puede asociar al requerimiento porque se encuentra inactivo.");
                    $errores_global[$key] = $errores;
                    continue;
                }
            }

            $candidato = ReqCandidato::where("candidato_id", $user_id)
                ->whereIn("estado_candidato", [
                    config('conf_aplicacion.C_CONTRATADO'),
                    config('conf_aplicacion.PROBLEMA_SEGURIDAD'),
                    config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                    config('conf_aplicacion.C_EN_EXAMENES_MEDICOS'),

                ])
                ->where('requerimiento_id', $requerimiento)
                ->first();

            if ($candidato !== null) {
                $guardar = false;
                array_push($errores, "El usuario se encuentra en ese requerimiento.");

            }

            $cedula = ReqCandidato::where("candidato_id", $user_id)
                ->whereIn("estado_candidato", [
                    config('conf_aplicacion.C_CONTRATADO'),
                    config('conf_aplicacion.PROBLEMA_SEGURIDAD'),
                    config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                    config('conf_aplicacion.C_EN_EXAMENES_MEDICOS'),

                ])
                ->first();

            if ($cedula !== null) {
                $guardar = false;
                array_push($errores, "El usuario se encuentra activo en un requerimiento.");

            }

            if ($guardar) {
                $req_candi = new ReqCandidato();

                $req_candi->fill([
                    'requerimiento_id' => $requerimiento,
                    'candidato_id'     => $user_id,
                    'estado_candidato' => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                    'otra_fuente' => 11,

                ]);
 
                $req_candi->save();

                $candidato = DatosBasicos::where("user_id", $user_id)
                    ->select('datos_basicos.numero_id as cedula')
                    ->first();
                $candidato->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                $candidato->save();

                 //SE COLOCA EL ASISTIO EN AL TABLA CARGA_ESCANNER
                 //
                 $candidato_escanner = CargaScanner::where("identificacion",$candidato->cedula)
                 ->first();
                  
                  $candidato_escanner->fill([
                       'asistencia' => 1,
                  ]);
                 $candidato_escanner->save();

                $req_can_id = $req_candi->id;

                $nuevo_proceso = new RegistroProceso();

                $nuevo_proceso->fill(
                    [
                        'requerimiento_candidato_id' => $req_can_id,
                        'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        'fecha_inicio'               => date("Y-m-d H:i:s"),
                        'usuario_envio'              => $this->user->id,
                        'requerimiento_id'           => $req_candi->requerimiento_id,
                        'candidato_id'               => $user_id,
                        'observaciones'              => "Ingreso al requerimiento por scanner",
                    ]
                );
                $nuevo_proceso->save();

                $sitio = Sitio::first();

                $requerimiento = Requerimiento::where('id', $requerimiento)->select('id', 'tipo_proceso_id')->first();
                if ($requerimiento != null && $requerimiento->tipo_proceso_id != $sitio->id_proceso_sitio) {
                    //Sino es Proceso en Sitio se envia a pruebas y a entrevista
                    //SE ENVIA A PRUEBAS//
                    
                    $nuevo_proceso_pruebas = new RegistroProceso();
                    $nuevo_proceso_pruebas->fill(
                        [
                            'requerimiento_candidato_id' => $req_can_id,
                            'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            'fecha_inicio'               => date("Y-m-d H:i:s"),
                            'usuario_envio'              => $this->user->id,
                            'requerimiento_id'           => $req_candi->requerimiento_id,
                            'candidato_id'               => $user_id,
                            'proceso'                    => 'ENVIO_PRUEBAS',
                            'observaciones'              => "Se envia a pruebas por scanner",
                        ]
                    );
                    $nuevo_proceso_pruebas->save();

                    //SE ENVIA A ENTREVISTA//
                    $nuevo_proceso_entrevista = new RegistroProceso();

                    $nuevo_proceso_entrevista->fill(
                        [
                            'requerimiento_candidato_id' => $req_can_id,
                            'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            'fecha_inicio'               => date("Y-m-d H:i:s"),
                            'usuario_envio'              => $this->user->id,
                            'requerimiento_id'           => $req_candi->requerimiento_id,
                            'candidato_id'               => $user_id,
                            'proceso'                    => 'ENVIO_ENTREVISTA',
                            'observaciones'              => "Se envia a entrevista por scanner",
                        ]
                    );
                    $nuevo_proceso_entrevista->save();

                    $obj                   = new \stdClass();
                    $obj->requerimiento_id = $req_candi->requerimiento_id;
                    $obj->user_id          = $this->user->id;
                    $obj->estado           = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                    Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));
                } else {
                    $campos = [
                        'requerimiento_candidato_id' => $req_can_id,
                        'usuario_envio'      => $this->user->id,
                        "fecha_inicio"       => date("Y-m-d H:i:s"),
                        'proceso'            => "ENVIO_APROBAR_CLIENTE",
                        'observaciones'      => "Se ha enviado a aprobar por el cliente desde enviar al requerimiento de la lista de candidatos en scanner"
                    ];

                    //Se crea el proceso evaluacion del cliente
                    $this->RegistroProceso($campos, config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), $req_can_id);
                }
                $registrosInsertados++;
            } else {
                $errores_global[$key] = $errores;
            }

        }

        return redirect()->route("admin.lista_carga_scanner_l")->with("mensaje_success", "Se han enviado los candidatos al requerimiento $requerimiento->id, Se han cargado $registrosInsertados con éxito. ")->with("errores_global", $errores_global);

    }

    public function lista_carga_scanner_l(Request $data)
    {

        $requerimientos = ["" => "seleccionar"] + Requerimiento::
        join('cargos_especificos','cargos_especificos.id','=','requerimientos.cargo_especifico_id')
        ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
        ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
        ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado in( 
                   " . config('conf_aplicacion.C_TERMINADO') . "," 
                   . config('conf_aplicacion.C_CLIENTE') . ","
                     . config('conf_aplicacion.C_SOLUCIONES') . "," 
                     . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . 
                     "))"))
       ->select("requerimientos.id", \DB::raw("CONCAT(requerimientos.id,' ',clientes.nombre,' ',cargos_especificos.descripcion) AS value"))
        ->pluck("value", "id")
        ->toArray();

        //dd($requerimientos);

        $personas_scanner = CargaScanner::join('users', 'users.id', '=', 'carga_scanner.user_carga')
            

            ->where(function ($sql) use ($data) {

                if ($data->get('identificacion') != "") {
                    $sql->where("carga_scanner.identificacion", $data->get('identificacion'));
                }

                if ($data->get('genero') != "") {
                    $sql->where("carga_scanner.genero", $data->get('genero'));
                }

                if ($data->get('fecha_actualizacion_ini') != "" && $data->get('fecha_actualizacion_fin') != "") {
                    $sql->whereBetween(DB::raw('DATE_FORMAT(carga_scanner.created_at, \'%Y-%m-%d\')'), [$data->get('fecha_actualizacion_ini'), $data->get('fecha_actualizacion_fin')]);
                }

                if ($data->get('edad_inicial') != "" && $data->get('edad_final') != "") {
                    $sql->whereBetween(DB::raw('round(datediff(now(),carga_scanner.fecha_nacimiento)/365)'), [$data->get('edad_inicial'), $data->get('edad_final')]);
                }

                if ($data->get('cedu') != "") {
                    $sql->where("datos_basicos.numero_id", $data->get('cedu'));
                }

            })

            ->select(
                'carga_scanner.*',
               DB::raw('(select r.requerimiento_id from datos_basicos d left join requerimiento_cantidato r on d.user_id=r.candidato_id where    
                    d.user_id=user_carga and r.estado_candidato <> 14 limit 1) as req_id'),
                DB::raw('date_format(carga_scanner.fecha_nacimiento,"%Y/%m/%d")as fecha'),
                DB::raw('round(datediff(now(),carga_scanner.fecha_nacimiento)/365) as edad'))
            ->groupBy('carga_scanner.identificacion')
            ->orderBy('carga_scanner.created_at', 'desc')
            ->paginate(10);
            //dd($personas_scanner);

        return view("admin.reclutamiento.lista_carga_scanner_l", compact("personas_scanner", "requerimientos"));
    }

    public function lista_carga_scanner(Request $data)
    {
        $req_id = $data->req_id;
        //dd($req_id);

        $requerimientos = ["" => "seleccionar"] + Requerimiento::whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado in( " . config('conf_aplicacion.C_TERMINADO') . "," . config('conf_aplicacion.C_SOLUCIONES') . "," . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . "))"))->pluck("id", "id")->toArray();

        $personas_scanner = CargaScanner::join('users', 'users.id', '=', 'carga_scanner.user_carga')
            ->join('datos_basicos', 'datos_basicos.user_id', '=', 'users.id')

            ->select(
                'carga_scanner.*',
                DB::raw('date_format(carga_scanner.fecha_nacimiento,"%Y/%m/%d")as fecha'),
                DB::raw('round(datediff(now(),carga_scanner.fecha_nacimiento)/365) as edad'))
            ->orderBy('carga_scanner.created_at', 'desc')
            ->paginate(6);

        return view("admin.reclutamiento.lista_carga_scanner", compact("personas_scanner", "requerimientos", "req_id"));
    }

    public function reclutadores(Request $data)
    {

        $candidato = null;
        if ($data->get("numero_id") != "") {
            $candidato = DatosBasicos::where("numero_id", $data->get("numero_id"))->first();
        }
        if ($candidato == null) {
            $candidato                       = new \stdClass();
            $candidato->numero_id            = $data->get("cedula");
            $candidato->user_id              = null;
            $candidato->numero_id            = $data->get("numero_id");
            $candidato->db_carga_id          = $data->get("db_carga_id");
            $candidato->nombres              = $data->get("nombres");
            $candidato->telefono_fijo        = $data->get("telefono_fijo");
            $candidato->telefono_movil       = $data->get("telefono_movil");
            $candidato->primer_apellido      = $data->get("primer_apellido");
            $candidato->estado_reclutamiento = null;
        }
        //dd($candidato);

        $cargos = ["" => "Seleccionar"] + CargoGenerico::orderBy("descripcion", "ASC")->pluck("descripcion", "id")->toArray();

        $tipos_motivos = ["" => "Seleccionar"] + RecepcionMotivo::where("active", 1)->pluck("descripcion", "id")->toArray();

        $tipificacion = ["" => "Seleccionar"] + CitacionTipificaciones::where("estado", 1)->pluck("descripcion", "tipificacion")->toArray();

        $cargos_seleccionados = PerfilamientoCandidato::where("candidato_id", $candidato->user_id)->where("tipo", "CARGO_GENERICO")->get();

        $requerimientos_seleccionados = PerfilamientoCandidato::where("candidato_id", $candidato->user_id)->where("tipo", "REQUERIMIENTO")->get();

        $requerimientos_seleccionados_a = [];
        $cargos_seleccionados_a         = [];
        foreach ($requerimientos_seleccionados as $key => $value) {
            array_push($requerimientos_seleccionados_a, $value->tabla_id);
        }
        foreach ($cargos_seleccionados as $key => $value) {
            array_push($cargos_seleccionados_a, $value->tabla_id);
        }

        $requerimientos = Requerimiento::whereIn("cargo_generico_id", $cargos_seleccionados_a)
            ->whereNotIn("id", $requerimientos_seleccionados_a)->paginate(10);

        $user = $this->user;
        //BASES DE DATOS CARGADAS
        $datos_cargados = CargaReclutadores::where("reclutador_id", $this->user->id)->whereRaw("gestionado is null")->get();
        //Citación

        $datos_cargados = CitacionCargaBd::where("user_carga", $this->user->id)
            ->where("estado", 0)
            ->where("motivo", 8)
            ->where("remitido_call", null)
            ->orderBy('created_at', 'ASC')
            ->take(100)
            ->get();

        //Franja Hora de cita
        $franja_hora = ["" => "Seleccionar"] + FranjaHoraria::where("estado", 1)->pluck("descripcion", "id")->toArray();

        $requerimientos_priorizados = Requerimiento::where("req_prioritario", 1)->get();

        return view("admin.proceso_reclutadores.index", compact("candidato", "cargos", "cargos_seleccionados", "requerimientos_seleccionados", "requerimientos", "user", "datos_cargados", "tipos_motivos", "tipificacion", "franja_hora", "requerimientos_priorizados"));
    }

    public function guardar_proceso_reclutadores(Request $data, Requests\ValidaProcesoReclutador $valida)
    {
        //dd($data->all());
        if ($data->get("user_id") == "") {
            $valida = Validator::make($data->all(), ['email' => 'required|email|max:255|unique:users,email']);
            if ($valida->fails()) {
                return redirect()->back()->withErrors($valida);
            }

            //CREAR USUARIO
            $campos_usuario = [
                "name"     => $data->get("nombres") . " " . $data->get("primer_apellido") . " " . $data->get("segundo_apellido"),
                "email"    => $data->get("email"),
                "password" => $data->get("numero_id"),
            ];

            $usuario = Sentinel::registerAndActivate($campos_usuario);

            //CREA HV

            $datos_basicos = new DatosBasicos();
            $datos_basicos->fill($data->all() + ["user_id" => $usuario->id, "datos_basicos_count" => "20", "estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')]);
            $datos_basicos->user_id = $usuario->id;
            $datos_basicos->save();
            //
            //        //AGREGAR ROL USUARIO
            $role = Sentinel::findRoleBySlug('hv');
            $role->users()->attach($usuario);
        }

        //perfilando candidato
        $datos_user = DatosBasicos::where("numero_id", $data->get("numero_id"))->first();

        $cargos_genericos = $data->get("cargos_genericos");

        $cargos_insertados = [];
        if (is_array($cargos_genericos)) {
            foreach ($cargos_genericos as $key => $value) {
                //BUSCA SI EL CARGO YA FUE REGISTRADO
                $cargo = PerfilamientoCandidato::where("CANDIDATO_ID", $datos_user->user_id)->where("TABLA", "CARGOS_GENERICOS")->where("TABLA_ID", $value)->first();
                if ($cargo == null) {
                    if ($value != "") {
                        //CONSULTAR SI YA existe EL PERFIL
                        if (!in_array($value, $cargos_insertados)) {

                            QueryAuditoria::guardar(new PerfilamientoCandidato(), [
                                "RECLUTADOR_ID" => $this->user->id,
                                "CANDIDATO_ID"  => $datos_user->user_id,
                                "TIPO"          => "CARGO_GENERICO",
                                "TABLA"         => "CARGOS_GENERICOS",
                                "TABLA_ID"      => $value,
                            ]);
                        }
                    }
                }
            }
        }

        $requerimientos = $data->get("requerimientos_sugeridos");
        if (is_array($requerimientos)) {

            foreach ($requerimientos as $key => $value) {
                $cargo = PerfilamientoCandidato::where("CANDIDATO_ID", $datos_user->user_id)->where("TABLA", "REQUERIMIENTOS")->where("TABLA_ID", $value)->first();
                if ($cargo == null) {
                    QueryAuditoria::guardar(new PerfilamientoCandidato(), [
                        "RECLUTADOR_ID" => $this->user->id,
                        "CANDIDATO_ID"  => $datos_user->user_id,
                        "TIPO"          => "REQUERIMIENTO",
                        "TABLA"         => "REQUERIMIENTOS",
                        "TABLA_ID"      => $value,
                    ]);
                }
            }
        }

        //ACTUALIZAR EL REGISTRO DE CARGA BD DEL RECLUTADOR
        if ($data->get("db_carga_id") != "") {
            $carga             = CargaReclutadores::find($data->get("db_carga_id"));
            $carga->gestionado = 'si';
            $carga->save();
        }
        return redirect()->route("admin.proceso_reclutadores")->with("mensaje_success", "El candidato se ha perfilado.");
    }

    public function cargar_bd(Request $data)
    {
        //dd($data->all());
        $rules = [
            "cedula"  => "unique:carga_reclutadores,cedula",
            "celular" => "numeric",
            "",
        ];
        $errores_global      = [];
        $registrosInsertados = 0;

        $reader = Excel::load($data->file("archivo"))->get();

        foreach ($reader as $key => $value) {
            //dd($value);
            //Consultar como leer la primera hoja del excel
            $errores = [];
            $datos   = [
                "cedula"        => $value->cedula,
                "nombre"        => $value->nombres,
                "apellidos"     => $value->apellidos,
                "celular"       => $value->telefono_movil,
                "tel_fijo"      => $value->telefono_fijo,
                "reclutador_id" => $this->user->id,
            ];
            //VALIDA LOS CAMPOS
            $guardar = true;
            $cedula  = Validator::make($datos, ["cedula" => "required"]);
            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "El campo cedula es obligatorio");
            }
            $cedula = Validator::make($datos, ["cedula" => "unique:carga_reclutadores,cedula"]);
            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "Este numero de cedula ya ha sido cargado");
            }
            $cedula = Validator::make($datos, ["cedula" => "numeric"]);
            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "La cedula no tiene el formato correcto");
            }
            $movil = Validator::make($datos, ["celular" => "numeric"]);
            if ($movil->fails()) {
                $guardar = false;
                array_push($errores, "El telefono movil no tiene el formato correcto");
            }
            $fijo = Validator::make($datos, ["tel_fijo" => "numeric"]);
            if ($fijo->fails()) {
                $guardar = false;
                array_push($errores, "El telefono movil no tiene el formato correcto");
            }

            if ($guardar) {
                $cargaReclutadores = new CargaReclutadores();
                $cargaReclutadores->fill($datos);
                $cargaReclutadores->save();
                $registrosInsertados++;
            } else {
                $errores_global[$key] = $errores;
            }
        }
        //dd($errores_global);

        return redirect()->route("admin.proceso_reclutadores")->with("mensaje_success", "Se han cargado <b>$registrosInsertados</b> con éxito.")->with("errores_global", $errores_global);
    }

    public function reclutamiento_elimina_cargo(Request $data)
    {
        QueryAuditoria::delete(PerfilamientoCandidato::find($data->get("id")), $data->get("id"));
    }

    public function reclutamiento_elimina_req(Request $data)
    {
        QueryAuditoria::delete(PerfilamientoCandidato::find($data->get("id")), $data->get("id"));
    }

    public function digiturnoDemonio()
    {

        //BUCAR CANDIDATOS QUE  NO TENGAN TURNO
        $con_turno         = Recepcion::where("proceso", "TURNO")->groupBy("candidato_id")->pluck("candidato_id");
        $sin_turno         = Recepcion::join("datos_basicos", "datos_basicos.user_id", "=", "recepcion.candidato_id")->whereNotIn("recepcion.candidato_id", $con_turno)->groupBy("datos_basicos.numero_id", "recepcion.candidato_id")->pluck("recepcion.candidato_id", "datos_basicos.numero_id")->toArray();
        $sin_turno_cedulas = array_keys($sin_turno);

        //TODO : sacar las pruebas desde la tabla de pruebas
        /*$response = Curl::to(config("conf_aplicacion.URL_PRUEBAS_CURL"))
        ->withData(array("cedulas" => $sin_turno_cedulas, "tipo" => 1))
        ->post();
        $responseCrul = json_decode($response, true);*/

        foreach ($sin_turno as $key => $value) {

            $v_perfilamiento = PerfilamientoCandidato::where("candidato_id", $value)->first();
            $v_pruebas       = 1;

            if ($v_pruebas == 1 && $v_perfilamiento != null) {
                //ACTUALIZAR DATOS

                $v_perfilamiento         = Recepcion::where("PROCESO", "PERFILAMIENTO")->where("candidato_id", $value)->first();
                $v_perfilamiento->estado = 1;
                $v_perfilamiento->save();
                $v_pruebas         = Recepcion::where("PROCESO", "PRUEBAS")->where("candidato_id", $value)->first();
                $v_pruebas->estado = 1;
                $v_pruebas->save();

                //REGISTRAR PROCESO DE PERFILAMIENTO
                $ultimoTurno = Recepcion::max('turno');

                $ultimoTurno = $ultimoTurno + 1;

                $nuevoProceso = new Recepcion();
                $nuevoProceso->fill([
                    "candidato_id" => $value,
                    "turno"        => $ultimoTurno,
                    "estado"       => 0,
                    "proceso"      => "TURNO",
                    "USER_ENVIO"   => 0,
                ]);
                $nuevoProceso->save();
            }
        }
    }

    public function liberar_turnos()
    {
        $turnosNoGestionados = EntrevistaSeleccion::rightJoin("recepcion  re", "re.id", "=", "entrevista_seleccion.turno_id")
            ->whereRaw("re.proceso = 'TURNO'  and entrevista_seleccion.turno_id IS NULL ")
            ->select("re.id")
            ->pluck("re.id");
        foreach ($turnosNoGestionados as $key => $value) {
            $recepcion                   = Recepcion::find($value);
            $recepcion->user_terminacion = null;
            $recepcion->estado           = 0;
            $recepcion->save();
        }
    }

    public function editar_hv(Request $data, $hv_id)
    {
        $datos_basicos = DatosBasicos::where("id", $hv_id)->first();
        $user_id       = $datos_basicos->user_id;

        return view("admin.hv.editar_hv", compact("user_id"));
    }

    public function transferir_candidato(Request $request)
    { 
      //funcion para transferir candidatos d eun req a otro.. aqui pasa cuando se debe transferir
        $user_sesion = $this->user;
        $req_anterior = array();
        
        foreach($request["candidato_req"] as $key => $value) {
            $this->quitar_candidato(request()->create("", "", [
                "esTransferido" => true,
                "candidato_req" => $value,
                "observaciones" => "El candidato fue retirado del requerimiento " . $request["req_$value"] . " y transferido al requerimiento " . $request["req_id"] . "."
            ]));

            $req_can = ReqCandidato::find($value);
            $req_can->estado_candidato = config('conf_aplicacion.C_TRANSFERIDO');
            $req_can->transferido_a_req = $request["req_id"];
            $req_can->save();

            $req_anterior["$req_can->candidato_id"] = $request["req_$value"];
        }

        $req_vacantes = Requerimiento::find($request["req_id"]);

        $cuenta_candidatos = ReqCandidato::where("requerimiento_id", $request["req_id"])
        ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
        ->count();

        if($req_vacantes->num_vacantes == $cuenta_candidatos){
            //Se cambia el estado del requerimiento al enlazarlo con un candidato
            $obj                   = new \stdClass();
            $obj->requerimiento_id = $request["requerimiento_id"];
            $obj->user_id          = $this->user->id;
            $obj->estado           = config('conf_aplicacion.C_EN_PROCESO_SELECCION');

            Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));
        }
           
        $urls = route('home.detalle_oferta', ['oferta_id' => $request["req_id"]]);
               
        $candidatos = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->whereIn("requerimiento_cantidato.id", $request["candidato_req"])
        ->select("datos_basicos.nombres as nomb","datos_basicos.email as email","datos_basicos.user_id")
        ->pluck("user_id")->toArray();
          
        //Transferir candidato
        if($request->ajax()){
            //transferir desde mineria
            $success = $this->agregar_candidato(request()->create("", "", [
                "requerimiento_id" => $request["req_id"],
                "aplicar_candidatos" => $candidatos
            ]));
         
            return response()->json(["success" =>"success"]);
        }

        return $this->agregar_candidato(request()->create("", "", [
            "requerimiento_id" => $request["req_id"],
            "aplicar_candidatos" => $candidatos,
            "transferido" => $request["trazabilidad"],
            "req_anterior"=> $req_anterior
        ]));
    }
     
    //PDF in
    public function pdf_informe_seleccion_req($user_id, Request $data){

        //dd($user_id);
       $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            ->join("cargos_especificos", "requerimientos.cargo_especifico_id", "=", "cargos_especificos.id")
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->select("cargos_especificos.descripcion", "requerimiento_cantidato.candidato_id", "requerimientos.sitio_trabajo as sitio_trabajo", "requerimiento_cantidato.candidato_id", "users.name as nombre_user", "datos_basicos.numero_id", "requerimiento_cantidato.created_at", "requerimiento_cantidato.requerimiento_id", "requerimiento_cantidato.id as requerimiento_cantidato_id", "clientes.nombre as cliente_nombre"
            )
            ->where("requerimiento_cantidato.id", $user_id)
            ->orderBy("requerimiento_cantidato.requerimiento_id", "asc")
            ->first();
        //dd($reqcandidato);
         $user = User::where("id", $reqcandidato->candidato_id)->select("*")->first();

         $datos_basicos = DatosBasicos::
            join("users","users.id","=","datos_basicos.user_id")
            ->leftJoin("tipos_documentos", "tipos_documentos.id", "=", "datos_basicos.tipo_id")
            ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
            ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
            ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
            ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
            ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->where("datos_basicos.user_id", $reqcandidato->candidato_id)
            ->select("datos_basicos.datos_basicos_activo as datos_contacto","datos_basicos.*", "tipos_documentos.descripcion as dec_tipo_doc", "generos.descripcion as genero_desc"
                , "estados_civiles.descripcion as estado_civil_des"
                , "aspiracion_salarial.descripcion as aspiracion_salarial_des"
                , "clases_libretas.descripcion as clases_libretas_des"
                , "tipos_vehiculos.descripcion as tipos_vehiculos_des"
                , "categorias_licencias.descripcion as categorias_licencias_des"
                , "entidades_afp.descripcion as entidades_afp_des"
                , "entidades_eps.descripcion as entidades_eps_des"
            )->first();
        // dd($datos_basicos);
        $documentos_candidato=Documentos::where("numero_id",$datos_basicos->numero_id)->orderBy("id","desc")->groupBy("tipo_documento_id")->get();

         $edad = ($datos_basicos->fecha_nacimiento != 0 && $datos_basicos->fecha_nacimiento != "")?Carbon::parse($datos_basicos->fecha_nacimiento)->age:"";


        $lugarnacimiento = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_nacimiento)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_nacimiento)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_nacimiento)->first();
        //dd($lugarnacimiento);
        $lugarexpedicion = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_id)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_expedicion_id)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_expedicion_id)->first();
        //dd($lugarexpedicion);
        $lugarresidencia = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_residencia)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_residencia)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_residencia)->first();

        $txtLugarNacimiento = "";
        $txtLugarExpedicion = "";
        $txtLugarResidencia = "";

        if ($lugarnacimiento != null) {
            $txtLugarNacimiento = $lugarnacimiento->value;
        }
        if ($lugarexpedicion != null) {
            $txtLugarExpedicion = $lugarexpedicion->value;
        }
        if ($lugarresidencia != null) {
            $txtLugarResidencia = $lugarresidencia->value;
        }

        $experiencias = Experiencias::join("paises", "paises.cod_pais", "=", "experiencias.pais_id")
        //->join()
            ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
            ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
                    ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
                ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
        })->where("experiencias.user_id", $reqcandidato->candidato_id)
        //->where("experiencias.activo", "1")
            ->select("aspiracion_salarial.descripcion as salario",
                "experiencias.fecha_inicio as fecha_inicio",
                "experiencias.fecha_final as fecha_final",
                "experiencias.salario_devengado",
                "experiencias.cargo_especifico as desc_cargo",
                "motivos_retiros.descripcion as desc_motivo",
                DB::raw(" (select UPPER(CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre))) AS ciudad"),
                "experiencias.*")

            ->orderBy("experiencias.fecha_inicio", "desc")
            ->get();
        //dd($experiencias);
        $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.*", "niveles_estudios.descripcion as desc_nivel")
            ->where("estudios.user_id", $reqcandidato->candidato_id)
            ->get();

        $referencias = ReferenciasPersonales::join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
            ->where("referencias_personales.user_id", $reqcandidato->candidato_id)
            ->select(DB::raw("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS ciudades"), "tipo_relaciones.descripcion as desc_tipo", "referencias_personales.*")
            ->get();

        $familiares = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select("grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "grupos_familiares.profesion_id as profesion")
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->get();

            /*$familiares_espo = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("estados_civiles.descripcion as estado_civile","grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "profesiones.descripcion as profesion")
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->where('parentescos.id','11')
            ->get();
            $hijos = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.*",
             "tipos_documentos.descripcion as tipo_documento", 
             "escolaridades.descripcion as escolaridad", 
             "parentescos.descripcion as parentesco",
              "generos.descripcion as genero",
              DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'), 
              "profesiones.descripcion as profesion")
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->where('parentescos.id','10')
            ->get();*/

            $hijos = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select(
                "grupos_familiares.*",
                "tipos_documentos.descripcion as tipo_documento", 
                "escolaridades.descripcion as escolaridad", 
                "parentescos.descripcion as parentesco",
                "generos.descripcion as genero",
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'), 
                "profesiones.descripcion as profesion"
            )
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->where('parentescos.id','2')
            ->get();

        //Entrevistas
        $entrevistas = EntrevistaCandidatos::join("users", "users.id", "=", "entrevistas_candidatos.user_gestion_id")
        ->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "entrevistas_candidatos.id")
        ->join("tipo_fuente", "tipo_fuente.id", "=", "entrevistas_candidatos.fuentes_publicidad_id")
        ->where("entrevistas_candidatos.candidato_id", $reqcandidato->candidato_id)
         ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
        ->where("proceso_requerimiento.activo", "1")
        ->select("entrevistas_candidatos.*", "users.name", "tipo_fuente.descripcion as desc_fuente")
        ->orderBy("entrevistas_candidatos.created_at", "desc")
        ->get();

        //Entrevistas Semi
        $entrevistas_semi = EntrevistaSemi::join("users", "users.id", "=", "entrevista_semi.user_gestion_id")
            ->where("entrevista_semi.candidato_id", $reqcandidato->candidato_id)
            ->where("entrevista_semi.activo", "1")
            ->select("entrevista_semi.*", "users.name")
            ->orderBy("entrevista_semi.created_at", "desc")
            ->get();

        //Entrevista virtual
        $entrevistas_virtuales = EntrevistaVirtual::join("preguntas_entre", "preguntas_entre.entre_vir_id", "=", "entrevista_virtual.id")
        ->join("respuestas_entre", "respuestas_entre.preg_entre_id", "=", "preguntas_entre.id")
        ->where("entrevista_virtual.req_id", $reqcandidato->requerimiento_id)
        ->where("respuestas_entre.candidato_id", $reqcandidato->candidato_id)
        ->select("respuestas_entre.*", "preguntas_entre.descripcion as pregunta")
        ->get();

        $pruebas_idiomas = PruebaIdioma::join("preguntas_pruebas_idiomas", "preguntas_pruebas_idiomas.prueba_idio_id", "=", "pruebas_idiomas.id")
        ->join("respuestas_pruebas_idiomas","respuestas_pruebas_idiomas.preg_prueba_id","=","preguntas_pruebas_idiomas.id")
        ->where("pruebas_idiomas.req_id", $reqcandidato->requerimiento_id)
        ->where("respuestas_pruebas_idiomas.candidato_id", $reqcandidato->candidato_id)
        ->select("respuestas_pruebas_idiomas.*", "preguntas_pruebas_idiomas.descripcion as pregunta")
        ->get();

        //Pruebas realizadas
        $pruebas = GestionPrueba::join("users", "users.id", "=", "gestion_pruebas.user_id")
        ->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "gestion_pruebas.id")
        ->leftjoin("tipos_pruebas", "tipos_pruebas.id", "=", "gestion_pruebas.tipo_prueba_id")
        ->where("gestion_pruebas.candidato_id", $reqcandidato->candidato_id)
        ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
        ->where("proceso_requerimiento.activo", "1")
        ->select("gestion_pruebas.*", "tipos_pruebas.descripcion as prueba_desc", "users.name")
        ->get();
        //dd($pruebas);

        //EXPERIENCIAS VERIFICADAS
        $experiencias_verificadas = ExperienciaVerificada::
            join("experiencias", "experiencias.id", "=", "experiencia_verificada.experiencia_id")
            ->leftjoin("motivos_retiros", "motivos_retiros.id", "=", "experiencia_verificada.motivo_retiro_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
        //->where("experiencias.activo", "1")
            ->where("experiencias.user_id", $reqcandidato->candidato_id)
            ->select("experiencias.*", "motivos_retiros.*", "cargos_genericos.*", "experiencia_verificada.*",
                "experiencia_verificada.meses_laborados as meses",
                "experiencia_verificada.anios_laborados as años",
                "cargos_genericos.descripcion as name_cargo",
                "motivos_retiros.descripcion as name_motivo",
                "experiencias.fecha_inicio as exp_fecha_inicio",
                "experiencias.fecha_final as exp_fechafin")
            ->get();
            //dd($experiencias_verificadas);
        $fecha = Carbon::now();
        //dd($fecha);
        //dd($experiencias_verificadas);
        $experienciaMayorDuracion = Experiencias::
        leftjoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            ->select(\DB::raw(" *,(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) AS dias,(user_id) AS usuario","aspiracion_salarial.descripcion as salario","experiencias.salario_devengado"))
            ->where("user_id", $reqcandidato->candidato_id)
            ->havingRaw("dias >= (SELECT MAX(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) FROM experiencias as e WHERE e.user_id = experiencias.user_id)")
            ->first();

        $experienciaActual = Experiencias::
            leftjoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            ->where("experiencias.user_id", $reqcandidato->candidato_id)
            ->select("aspiracion_salarial.descripcion as salario", "experiencias.*")
            ->orderBy("experiencias.fecha_inicio", "DESC")
            ->first();

             //consulta documentos
        $consulta= DocumentosVerificados::join("users", "users.id", "=", "documentos_verificados.user_id")->where("candidato_id", $reqcandidato->candidato_id)->whereNotNull('nombre_archivo');

        $examenes_medicos = $consulta->where("tipo_documento_id",9)
                                    ->select('users.name','documentos_verificados.*')
                                    ->get();

        $estudio_seguridad = DocumentosVerificados::join("users", "users.id", "=", "documentos_verificados.user_id")->where("candidato_id", $reqcandidato->candidato_id)->whereNotNull('nombre_archivo')->where("tipo_documento_id",8)
            ->select('users.name','documentos_verificados.*')
            ->get();

         $archivo = Archivo_hv::select('archivo')->where("user_id", $user->id)->orderBy('created_at','DESC')->first();

         //consulta documentos
        $documentos= DocumentosVerificados::join("users", "users.id", "=", "documentos_verificados.user_id")->join("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")->where("candidato_id", $reqcandidato->candidato_id)->whereNotNull('nombre_archivo')->whereNotIn('documentos_verificados.tipo_documento_id',[8,9])
            ->select('documentos_verificados.nombre_archivo', 'documentos_verificados.descripcion_archivo as descripcion')->get();

        $validacion_documental = DocumentosVerificados::leftjoin("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")
            ->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "documentos_verificados.id")
            ->where("documentos_verificados.candidato_id", $reqcandidato->candidato_id)
            ->where("tipos_documentos.categoria", 1)
            ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_DOCUMENTO")
            ->select(
                "documentos_verificados.*",
                "tipos_documentos.descripcion as tipo_doc",
                "proceso_requerimiento.requerimiento_id as req_id",
                "proceso_requerimiento.resultado",
                "proceso_requerimiento.observacion"
            )
            ->orderBy("documentos_verificados.created_at","desc")
        ->get();

        //Entrevista multiple
        $entrevista_multiple = EntrevistaMultipleDetalles::where('candidato_id', $reqcandidato->candidato_id)
            ->where('req_id', $reqcandidato->requerimiento_id)
            ->whereNotNull('apto')
            ->orderBy('id', 'desc')
        ->first();

        //REFERENCIAS PERSONALES VERIFICADA

        $rpv = ReferenciaPersonalVerificada::join("referencias_personales", "referencias_personales.id", "=", "ref_personales_verificada.referencia_personal_id")
            ->where("ref_personales_verificada.candidato_id", $reqcandidato->candidato_id)
            ->get();
                   //REFERENCIAS PERSONALES VERIFICADAS
        $rpv = ReferenciaPersonalVerificada::join("referencias_personales", "referencias_personales.id", "=", "ref_personales_verificada.referencia_personal_id")
            ->where("ref_personales_verificada.candidato_id", $reqcandidato->candidato_id)
            ->where("ref_personales_verificada.req_id", $reqcandidato->requerimiento_id)
            ->first();
        //dd($rpv);
        $sitio=Sitio::first();
        $logo=$sitio->logo;

        $generated_check = null;
        $generated_status = null;

        $consulta_seg = null;

        if (route("home") === "http://desarrollo.t3rsc.co" || route("home") === "https://desarrollo.t3rsc.co" || route("home") === "http://soluciones.t3rsc.co" || route("home") === "https://soluciones.t3rsc.co" || route("home") === "http://proservis.t3rsc.co" || route("home") === "https://proservis.t3rsc.co" || route("home") === "http://tiempos.t3rsc.co" || route("home") === "https://tiempos.t3rsc.co" || route("home") === "http://localhost:8000" || route("home") === "https://asuservicio.t3rsc.co") {

          $consulta_seg = ConsultaSeguridad::where('user_id', $reqcandidato->candidato_id)->where('req_id', $reqcandidato->requerimiento_id)->first();
        }

        $preliminar=PreliminarTranversalesCandidato::where("req_id",$reqcandidato->requerimiento_id)
        ->where("candidato_id",$reqcandidato->candidato_id)
        ->get();

        $hv=Archivo_hv::where("user_id",$reqcandidato->candidato_id)->orderBy("archivo_hv.id","desc")->first();

        return view("admin.hv.informe_seleccion_pdf_new", compact(
            'hijos',
            'familiares_espo',
            "validacion_documental",
            "entrevista_multiple",
            'datos_basicos',
            'reqcandidato',
            'user',
            "txtLugarResidencia",
            "txtLugarNacimiento",
            "txtLugarExpedicion",
            "experiencias",
            "estudios",
            "referencias",
            "experienciaMayorDuracion",
            "familiares",
            "entrevistas_semi",
            "entrevistas",
            "pruebas",
            "experiencias_verificadas",
            "rpv",
            "edad",
            "experienciaActual",
            "logo",
            "consulta",
            "examenes_medicos",
            "estudio_seguridad",
            "archivo",
            "documentos",
            "generated_check",
            "consulta_seg",
            "entrevistas_virtuales",
            "pruebas_idiomas",
            "generated_status",
            "preliminar",
            "hv",
            "documentos_candidato"
        ));

        /*
        $view = \View::make('admin.hv.informe_seleccion_pdf', compact('hijos','familiares_espo','datos_basicos', 'reqcandidato', 'user', "txtLugarResidencia", "txtLugarNacimiento", "txtLugarExpedicion", "experiencias", "estudios", "referencias", "experienciaMayorDuracion", "familiares", "entrevistas_semi", "entrevistas", "pruebas", "experiencias_verificadas", "rpv", "edad", "experienciaActual","logo","consulta","examenes_medicos","estudio_seguridad","archivo","documentos", "generated_check", "consulta_seg","entrevistas_virtuales","pruebas_idiomas","generated_status","preliminar","hv","documentos_candidato"))->render();
        $pdf  = \App::make('dompdf.wrapper');
        
        $pdf->loadHTML($view);

        return $pdf->stream('informe_seleccion_pdf.pdf');
        */
    }

    public function pdf_informe_seleccion($user_id, Request $data)
    {

        $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->leftjoin("cargos_especificos", "requerimientos.cargo_especifico_id", "=", "cargos_especificos.id")
        ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->leftjoin("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->leftjoin("empresa_logos","empresa_logos.id","=","requerimientos.empresa_contrata")
        ->select(
            "cargos_especificos.descripcion",
            "requerimiento_cantidato.candidato_id",
            "requerimientos.sitio_trabajo as sitio_trabajo",
            "requerimiento_cantidato.candidato_id",
            "users.name as nombre_user",
            "datos_basicos.numero_id",
            "requerimiento_cantidato.created_at",
            "requerimiento_cantidato.requerimiento_id",
            "requerimiento_cantidato.id as requerimiento_cantidato_id",
            "clientes.nombre as cliente_nombre",
            "empresa_logos.logo as logo_empresa"
        )
        ->where("requerimiento_cantidato.id", $user_id)
        ->orderBy("requerimiento_cantidato.requerimiento_id", "asc")
        ->first();

        $user = User::where("id", $reqcandidato->candidato_id)->select("*")->first();

        $datos_basicos = DatosBasicos::join("users", "users.id", "=", "datos_basicos.user_id")
        ->leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
        ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
        ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
        ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
        ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
        ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
        ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
        ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
        ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
        ->where("datos_basicos.user_id", $reqcandidato->candidato_id)
        ->select(
            "datos_basicos.datos_basicos_activo as datos_contacto",
            "datos_basicos.*",
            "tipo_identificacion.descripcion as dec_tipo_doc",
            "generos.descripcion as genero_desc",
            "estados_civiles.descripcion as estado_civil_des",
            "aspiracion_salarial.descripcion as aspiracion_salarial_des",
            "clases_libretas.descripcion as clases_libretas_des",
            "tipos_vehiculos.descripcion as tipos_vehiculos_des",
            "categorias_licencias.descripcion as categorias_licencias_des",
            "entidades_afp.descripcion as entidades_afp_des",
            "entidades_eps.descripcion as entidades_eps_des"
        )
        ->first();

        $documentos_candidato=Documentos::where("numero_id", $datos_basicos->numero_id)->orderBy("id", "desc")->groupBy("tipo_documento_id")->get();

        $archivo = Documentos::select('nombre_archivo')
        ->where("user_id", $user->id)
        ->where("descripcion_archivo", 'HOJA DE VIDA')
        ->orderBy('created_at','DESC')
        ->first();

        $edad = ($datos_basicos->fecha_nacimiento != 0 && $datos_basicos->fecha_nacimiento != "") ? Carbon::parse($datos_basicos->fecha_nacimiento)->age : "";

        $lugarnacimiento = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
          $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $datos_basicos->pais_nacimiento)
        ->where("ciudad.cod_departamento", $datos_basicos->departamento_nacimiento)
        ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_nacimiento)
        ->first();

        $lugarexpedicion = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $datos_basicos->pais_id)
        ->where("ciudad.cod_departamento", $datos_basicos->departamento_expedicion_id)
        ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_expedicion_id)
        ->first();

        $lugarresidencia = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $datos_basicos->pais_residencia)
        ->where("ciudad.cod_departamento", $datos_basicos->departamento_residencia)
        ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_residencia)
        ->first();

        $txtLugarNacimiento = "";
        $txtLugarExpedicion = "";
        $txtLugarResidencia = "";

        if ($lugarnacimiento != null) {
            $txtLugarNacimiento = $lugarnacimiento->value;
        }

        if ($lugarexpedicion != null) {
            $txtLugarExpedicion = $lugarexpedicion->value;
        }

        if ($lugarresidencia != null) {
            $txtLugarResidencia = $lugarresidencia->value;
        }

        if (route('home') == "http://localhost:8000") {
            $experiencias = Experiencias::join('aspiracion_salarial', 'aspiracion_salarial.id', '=', 'experiencias.salario_devengado')
            ->join('motivos_retiros', 'motivos_retiros.id', '=', 'experiencias.motivo_retiro')
            ->where("experiencias.user_id", $reqcandidato->candidato_id)
            ->select(
                'experiencias.*',
                'aspiracion_salarial.descripcion as salario_cand',
                'motivos_retiros.descripcion as motivo_retiro_cand'
            )
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->get();
        }else {
            $experiencias = Experiencias::leftjoin("paises", "paises.cod_pais", "=", "experiencias.pais_id")
            ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
            ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            ->leftjoin("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
                    ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
            })->leftjoin("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
                ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
            })
            ->where("experiencias.user_id", $reqcandidato->candidato_id)
            ->select(
                "aspiracion_salarial.descripcion as salario",
                "experiencias.fecha_inicio as fecha_inicio",
                "experiencias.fecha_final as fecha_final",
                "experiencias.cargo_especifico as desc_cargo",
                "motivos_retiros.descripcion as desc_motivo",
                DB::raw(" (select UPPER(CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre))) AS ciudad"),
                "experiencias.*"
            )
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->get();
        }

        $estudios = Estudios::leftjoin("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        ->select("estudios.*", "niveles_estudios.descripcion as desc_nivel")
        ->where("estudios.user_id", $reqcandidato->candidato_id)
        ->get();

        //Ultimo
        $estudioReciente = Estudios::leftjoin("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        ->select(
            "estudios.titulo_obtenido",
            "estudios.fecha_finalizacion",
            "niveles_estudios.descripcion as desc_nivel"
        )
        ->orderBy("estudios.fecha_finalizacion", "desc")
        ->where("estudios.user_id", $reqcandidato->candidato_id)
        ->first();

        $referencias = ReferenciasPersonales::leftjoin("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
        ->leftjoin("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->leftjoin("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
            ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
            ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->leftjoin("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
        ->where("referencias_personales.user_id", $reqcandidato->candidato_id)
        ->select(
            DB::raw("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS ciudades"),
            "tipo_relaciones.descripcion as desc_tipo",
            "referencias_personales.*"
        )
        ->get();

        if (route('home') == "http://localhost:8000") {
            $familiares = GrupoFamilia::leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select(
                "grupos_familiares.*",
                "escolaridades.descripcion as escolaridad",
                "parentescos.descripcion as parentesco",
                "generos.descripcion as genero",
                "grupos_familiares.profesion_id as profesion"
            )
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->get();
        }else {
            $familiares = GrupoFamilia::leftjoin("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select(
                "grupos_familiares.*",
                "tipos_documentos.descripcion as tipo_documento",
                "escolaridades.descripcion as escolaridad",
                "parentescos.descripcion as parentesco",
                "generos.descripcion as genero",
                "grupos_familiares.profesion_id as profesion"
            )
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->get();
        }

        //Entrevistas
        $entrevistas = EntrevistaCandidatos::join("users", "users.id", "=", "entrevistas_candidatos.user_gestion_id")
        ->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "entrevistas_candidatos.id")
        ->join("tipo_fuente", "tipo_fuente.id", "=", "entrevistas_candidatos.fuentes_publicidad_id")
        ->where("entrevistas_candidatos.candidato_id", $reqcandidato->candidato_id)
         ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
        ->where("proceso_requerimiento.activo", "1")
        ->select("entrevistas_candidatos.*", "users.name", "tipo_fuente.descripcion as desc_fuente")
        ->orderBy("entrevistas_candidatos.created_at", "desc")
        ->get();

        $familiares_espo = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
        ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
        ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
        ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
        ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
        ->select(
            "grupos_familiares.*",
            "tipos_documentos.descripcion as tipo_documento",
            "escolaridades.descripcion as escolaridad",
            "parentescos.descripcion as parentesco",
            "generos.descripcion as genero",
            "profesiones.descripcion as profesion"
        )
        ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
        ->where('parentescos.id','1')
        ->get();
            
        $hijos = GrupoFamilia::leftjoin("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
        ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
        ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
        ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
        ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
        ->select(
            "grupos_familiares.*",
            "tipos_documentos.descripcion as tipo_documento", 
            "escolaridades.descripcion as escolaridad", 
            "parentescos.descripcion as parentesco",
            "generos.descripcion as genero",
            DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'), 
            "profesiones.descripcion as profesion"
        )
        ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
        ->where('parentescos.id','2')
        ->get();

        //Entrevistas Semi
        $entrevistas_semi = EntrevistaSemi::join("users", "users.id", "=", "entrevista_semi.user_gestion_id")
        ->where("entrevista_semi.candidato_id", $reqcandidato->candidato_id)
        ->where("entrevista_semi.activo", 1)
        ->select("entrevista_semi.*", "users.name")
        ->orderBy("entrevista_semi.created_at", "desc")
        ->get();

        //Entrevista virtual
        $entrevistas_virtuales = EntrevistaVirtual::join("preguntas_entre", "preguntas_entre.entre_vir_id", "=", "entrevista_virtual.id")
        ->join("respuestas_entre", "respuestas_entre.preg_entre_id", "=", "preguntas_entre.id")
        ->where("entrevista_virtual.req_id", $reqcandidato->requerimiento_id)
        ->where("respuestas_entre.candidato_id", $reqcandidato->candidato_id)
        ->select("respuestas_entre.*", "preguntas_entre.descripcion as pregunta")
        ->get();

        $pruebas_idiomas = PruebaIdioma::join("preguntas_pruebas_idiomas", "preguntas_pruebas_idiomas.prueba_idio_id", "=", "pruebas_idiomas.id")
        ->join("respuestas_pruebas_idiomas","respuestas_pruebas_idiomas.preg_prueba_id","=","preguntas_pruebas_idiomas.id")
        ->where("pruebas_idiomas.req_id", $reqcandidato->requerimiento_id)
        ->where("respuestas_pruebas_idiomas.candidato_id", $reqcandidato->candidato_id)
        ->select("respuestas_pruebas_idiomas.*", "preguntas_pruebas_idiomas.descripcion as pregunta")
        ->get();

        //Pruebas realizadas
        $pruebas = GestionPrueba::join("users", "users.id", "=", "gestion_pruebas.user_id")
        ->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "gestion_pruebas.id")
        ->leftjoin("tipos_pruebas", "tipos_pruebas.id", "=", "gestion_pruebas.tipo_prueba_id")
        ->where("gestion_pruebas.candidato_id", $reqcandidato->candidato_id)
        ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
        ->where("proceso_requerimiento.activo", "1")
        ->select("gestion_pruebas.*", "tipos_pruebas.descripcion as prueba_desc", "users.name")
        ->get();

        //EXPERIENCIAS VERIFICADAS
        $experiencias_verificadas = ExperienciaVerificada::join("experiencias", "experiencias.id", "=", "experiencia_verificada.experiencia_id")
        ->leftjoin("motivos_retiros", "motivos_retiros.id", "=", "experiencia_verificada.motivo_retiro_id")
        ->join("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
        //->where("experiencias.activo", "1")
        ->where("experiencias.user_id", $reqcandidato->candidato_id)
        ->where("experiencia_verificada.req_id", $reqcandidato->requerimiento_id)
        ->select(
            "experiencias.*",
            "motivos_retiros.*",
            "cargos_genericos.*",
            "experiencia_verificada.*",
            "experiencia_verificada.meses_laborados as meses",
            "experiencia_verificada.anios_laborados as años",
            "cargos_genericos.descripcion as name_cargo",
            "motivos_retiros.descripcion as name_motivo",
            "experiencias.fecha_inicio as exp_fecha_inicio",
            "experiencias.fecha_final as exp_fechafin")
        ->get();
        
        $fecha = Carbon::now();

        $experienciaMayorDuracion = Experiencias::leftjoin('aspiracion_salarial', 'aspiracion_salarial.id', '=', 'experiencias.salario_devengado')
        ->select(\DB::raw("*,(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) AS dias,(user_id) AS usuario"),"aspiracion_salarial.descripcion AS salario","experiencias.empleo_actual")
        ->selectRaw("experiencias.salario_devengado")
        ->where("user_id", $reqcandidato->candidato_id)
        ->havingRaw("dias >= (SELECT MAX(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) FROM experiencias as e WHERE e.user_id = experiencias.user_id)")
        ->first();

        $experienciaActual = Experiencias::leftjoin('aspiracion_salarial', 'aspiracion_salarial.id', '=', 'experiencias.salario_devengado')
        ->where("experiencias.user_id", $reqcandidato->candidato_id)
        ->selectRaw("experiencias.salario_devengado")
        ->select("aspiracion_salarial.descripcion as salario", "experiencias.*")
        ->orderBy("experiencias.fecha_inicio", "DESC")
        ->first();

        //REFERENCIAS PERSONALES VERIFICADAS
        $rpv = ReferenciaPersonalVerificada::join("referencias_personales", "referencias_personales.id", "=", "ref_personales_verificada.referencia_personal_id")
        ->where("ref_personales_verificada.candidato_id", $reqcandidato->candidato_id)
        ->where("ref_personales_verificada.req_id", $reqcandidato->requerimiento_id)
        ->first();

        //consulta documentos
        $consulta = DocumentosVerificados::join("users", "users.id", "=", "documentos_verificados.user_id")
        ->where("candidato_id", $reqcandidato->candidato_id)
        ->whereNotNull('nombre_archivo');

        //Examenes medicos
        $examenes_medicos = $consulta->where("tipo_documento_id", 9)
        ->select('users.name','documentos_verificados.*')
        ->get();

        $estudio_seguridad = DocumentosVerificados::join("users", "users.id", "=", "documentos_verificados.user_id")
        ->where("candidato_id", $reqcandidato->candidato_id)
        ->whereNotNull('nombre_archivo')->where("tipo_documento_id",8)
        ->select('users.name','documentos_verificados.*')
        ->get();

        //consulta documentos
        $documentos = DocumentosVerificados::join("users", "users.id", "=", "documentos_verificados.user_id")
        ->join("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")
        ->where("candidato_id", $reqcandidato->candidato_id)
        ->whereNotNull('nombre_archivo')
        ->whereNotIn('documentos_verificados.tipo_documento_id', [8,9])
        ->select('documentos_verificados.nombre_archivo', 'documentos_verificados.descripcion_archivo as descripcion')
        ->get();

        $validacion_documental = DocumentosVerificados::leftjoin("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")
            ->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "documentos_verificados.id")
            ->where("documentos_verificados.candidato_id", $reqcandidato->candidato_id)
            ->where("tipos_documentos.categoria", 1)
            ->where("proceso_requerimiento.requerimiento_id", $reqcandidato->requerimiento_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_DOCUMENTO")
            ->select(
                "documentos_verificados.*",
                "tipos_documentos.descripcion as tipo_doc",
                "proceso_requerimiento.requerimiento_id as req_id",
                "proceso_requerimiento.resultado",
                "proceso_requerimiento.observacion"
            )
            ->orderBy("documentos_verificados.created_at","desc")
        ->get();

        //Entrevista multiple
        $entrevista_multiple = EntrevistaMultipleDetalles::where('candidato_id', $reqcandidato->candidato_id)
            ->where('req_id', $reqcandidato->requerimiento_id)
            ->whereNotNull('apto')
            ->orderBy('id', 'desc')
        ->first();

        $referencias_estudios_verificados = ReferenciaEstudio::join("estudios", "estudios.id", "=", "referencias_estudios.estudio_id")
            ->leftJoin("niveles_estudios", "niveles_estudios.id", "=", "referencias_estudios.nivel_estudio_id")
            ->where("estudios.user_id", $reqcandidato->candidato_id)
            ->select(
                "referencias_estudios.*", 
                "estudios.user_id", 
                "estudios.institucion",
                "estudios.titulo_obtenido",
                "niveles_estudios.descripcion as nivel"
                )
            ->get();
        //$pruebas_c = GestionPrueba::where("candidato_id",$reqcandidato->candidato_id)->orderBy('id','DESC')->first();

        $sitio = Sitio::first();
        $sitioModulo = SitioModulo::first();
        $logo = $sitio->logo;

        $resp_user_excel_basico = null;
        $resp_user_excel_intermedio = null;
        $resp_ethical_values = null;
        $resp_personal_skills = null;

        //Prueba Excel Basico
        if($sitio->prueba_excel_basico) {
            $resp_user_excel_basico = PruebaExcelRespuestaUser::where('user_id', $reqcandidato->candidato_id)
                ->where('req_id', $reqcandidato->requerimiento_id)
                ->where('tipo', 'basico')
            ->first();
        }

        //Prueba Excel Intermedio
        if($sitio->prueba_excel_intermedio) {
            $resp_user_excel_intermedio = PruebaExcelRespuestaUser::where('user_id', $reqcandidato->candidato_id)
                ->where('req_id', $reqcandidato->requerimiento_id)
                ->where('tipo', 'intermedio')
            ->first();
        }

        $valores_ideal_grafico = [];
        $porcentaje_valores_obtenidos = [];
        $grafico_radar_valores = [];
        $textos_cuantitativos = [];
        $area_mayor = [];
        $area_menor = [];

        //Prueba Ethical Values
        if($sitioModulo->prueba_valores1 == 'enabled') {
            $resp_ethical_values = PruebaValoresRespuestas::where('user_id', $reqcandidato->candidato_id)
                ->where('req_id', $reqcandidato->requerimiento_id)
            ->first();

            if($resp_ethical_values != null) {
                $resp_ethical_values->nombre_completo = $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ($datos_basicos->segundo_apellido != null && $datos_basicos->segundo_apellido != '' ? " $datos_basicos->segundo_apellido" : '');

                $configuracion = PruebaValoresConfigRequerimiento::where('req_id', $reqcandidato->requerimiento_id)->orderBy('id', 'desc')->first();

                $valores_ideal_grafico = [
                    "amor"          => intval($configuracion->valor_amor),
                    "no_violencia"  => intval($configuracion->valor_no_violencia),
                    "paz"           => intval($configuracion->valor_paz),
                    "rectitud"      => intval($configuracion->valor_rectitud),
                    "verdad"        => intval($configuracion->valor_verdad)
                ];

                $normas_nacionales = PruebaValoresNormasNacionales::first();

                $valores_obtenidos_normalizados = [
                    "amor"          => $this->normalizacionDatosEV($resp_ethical_values->valor_amor, $normas_nacionales->promedio_amor, $normas_nacionales->desviacion_amor, 2),
                    "no_violencia"  => $this->normalizacionDatosEV($resp_ethical_values->valor_no_violencia, $normas_nacionales->promedio_no_violencia, $normas_nacionales->desviacion_no_violencia, 2),
                    "paz"           => $this->normalizacionDatosEV($resp_ethical_values->valor_paz, $normas_nacionales->promedio_paz, $normas_nacionales->desviacion_paz, 2),
                    "rectitud"      => $this->normalizacionDatosEV($resp_ethical_values->valor_rectitud, $normas_nacionales->promedio_rectitud, $normas_nacionales->desviacion_rectitud, 2),
                    "verdad"        => $this->normalizacionDatosEV($resp_ethical_values->valor_verdad, $normas_nacionales->promedio_verdad, $normas_nacionales->desviacion_verdad, 2)
                ];

                $maximos_normalizados = [
                    "amor"          => $this->normalizacionDatosEV($resp_ethical_values->item_amor * 3, $normas_nacionales->promedio_amor, $normas_nacionales->desviacion_amor),
                    "no_violencia"  => $this->normalizacionDatosEV($resp_ethical_values->item_no_violencia * 3, $normas_nacionales->promedio_no_violencia, $normas_nacionales->desviacion_no_violencia),
                    "paz"           => $this->normalizacionDatosEV($resp_ethical_values->item_paz * 3, $normas_nacionales->promedio_paz, $normas_nacionales->desviacion_paz),
                    "rectitud"      => $this->normalizacionDatosEV($resp_ethical_values->item_rectitud * 3, $normas_nacionales->promedio_rectitud, $normas_nacionales->desviacion_rectitud),
                    "verdad"        => $this->normalizacionDatosEV($resp_ethical_values->item_verdad * 3, $normas_nacionales->promedio_verdad, $normas_nacionales->desviacion_verdad)
                ];

                $porcentaje_valores_obtenidos = [
                    "amor"          => $this->obtenerPorcentajeEV($maximos_normalizados['amor'], $valores_obtenidos_normalizados['amor']),
                    "no_violencia"  => $this->obtenerPorcentajeEV($maximos_normalizados['no_violencia'], $valores_obtenidos_normalizados['no_violencia']),
                    "paz"           => $this->obtenerPorcentajeEV($maximos_normalizados['paz'], $valores_obtenidos_normalizados['paz']),
                    "rectitud"      => $this->obtenerPorcentajeEV($maximos_normalizados['rectitud'], $valores_obtenidos_normalizados['rectitud']),
                    "verdad"        => $this->obtenerPorcentajeEV($maximos_normalizados['verdad'], $valores_obtenidos_normalizados['verdad'])
                ];

                $grafico_radar_valores = [
                    'type' => 'radar',
                    'data' => [
                        'labels' => ['AMOR', 'NO VIOLENCIA', 'PAZ', 'RECTITUD', 'VERDAD'],
                        'datasets' => [
                            [
                                'backgroundColor' => [
                                    'rgb(58, 181, 74)'
                                ],
                                'label' => 'Perfil Ideal',
                                'borderColor' => [
                                    "rgb(58, 181, 74)"
                                ],
                                'data' => [
                                    $valores_ideal_grafico['amor'],
                                    $valores_ideal_grafico['no_violencia'],
                                    $valores_ideal_grafico['paz'],
                                    $valores_ideal_grafico['rectitud'],
                                    $valores_ideal_grafico['verdad']
                                ],
                                'borderWidth' => 2,
                                'fill' => false
                            ],
                            [
                                'backgroundColor' => [
                                    'rgb(114, 46, 135)'
                                ],
                                'label' => 'Perfil del Candidato',
                                'borderColor' => [
                                    "rgb(114, 46, 135)"
                                ],
                                'data' => [
                                    $porcentaje_valores_obtenidos['amor'],
                                    $porcentaje_valores_obtenidos['no_violencia'],
                                    $porcentaje_valores_obtenidos['paz'],
                                    $porcentaje_valores_obtenidos['rectitud'],
                                    $porcentaje_valores_obtenidos['verdad']
                                ],
                                'borderWidth' => 2,
                                'fill' => false
                            ]
                        ]
                    ],
                    'options' => [
                        //'legend' => ['display' => false],
                        'title' => [
                            'display' => true,
                            'text' => 'Comparativa Perfil Ideal vs. Perfil del Candidato'
                        ],
                        'scale' => [
                            'ticks' => [
                                'suggestedMin' => 30,
                                'suggestedMax' => 100
                            ]
                        ]
                    ]
                ];

                //(Buscar el valor más alto)
                $valores_mayor = array_keys($valores_obtenidos_normalizados, max($valores_obtenidos_normalizados));

                $valores_menor = array_keys($valores_obtenidos_normalizados, min($valores_obtenidos_normalizados));

                $area = PruebaValoresAreaImportante::first();

                $columna_mayor = $valores_mayor[0].'_mayor';
                $columna_menor = $valores_menor[0].'_menor';

                $area_mayor = $area->$columna_mayor;
                $area_menor = $area->$columna_menor;

                $area_mayor = str_replace('$nombre_candidato', $resp_ethical_values->nombre_completo, $area_mayor);
                $area_menor = str_replace('$nombre_candidato', $resp_ethical_values->nombre_completo, $area_menor);

                $interpretacion = PruebaValoresInterpretacion::get();

                $textos_cuantitativos = [
                    'amor'          => $this->obtenerInterpretacionEV($interpretacion, $valores_obtenidos_normalizados['amor']),
                    'no_violencia'  => $this->obtenerInterpretacionEV($interpretacion, $valores_obtenidos_normalizados['no_violencia']),
                    'paz'           => $this->obtenerInterpretacionEV($interpretacion, $valores_obtenidos_normalizados['paz']),
                    'rectitud'      => $this->obtenerInterpretacionEV($interpretacion, $valores_obtenidos_normalizados['rectitud']),
                    'verdad'        => $this->obtenerInterpretacionEV($interpretacion, $valores_obtenidos_normalizados['verdad'])
                ];
            }
        }

        //Prueba Personal Skills
        if ($sitioModulo->prueba_competencias == 'enabled') {
            $resp_personal_skills = PruebaCompetenciaResultado::where('prueba_competencias_resultados.user_id', $reqcandidato->candidato_id)
                ->where('prueba_competencias_resultados.req_id', $reqcandidato->requerimiento_id)
                ->where('estado', 1)
                ->select(
                    'prueba_competencias_resultados.*'
                )
            ->first();

            $totales_personal_skills = PruebaCompetenciaTotal::join('prueba_competencias_competencia', 'prueba_competencias_competencia.id', '=', 'prueba_competencias_totales.competencia_id')
                ->where('prueba_id', $resp_personal_skills->id)
                ->where('user_id', $resp_personal_skills->user_id)
                ->orderBy('prueba_competencias_totales.competencia_id', 'ASC')
            ->get();

            $concepto_personal_skills = PruebaCompetenciaConcepto::where('prueba_id', $resp_personal_skills->id)->first();
        }

        $resp_bryg = null;
        $aumented_definitive = null;
        $bryg_definitive_first = null;
        $bryg_definitive_second = null;
        $grafico_radar_bryg = null;
        $grafico_radar_aumented = null;

        //Prueba Bryg / Brig
        if ($sitio->prueba_bryg) {
            $resp_bryg = PruebaPerfilBrygController::brygCandidato($reqcandidato->candidato_id, $reqcandidato->requerimiento_id);

            if ($resp_bryg != null) {
                $aumented_array = [
                    "analizador" => $resp_bryg->aumented_a,
                    "prospectivo" => $resp_bryg->aumented_p,
                    "defensivo" => $resp_bryg->aumented_d,
                    "reactivo" => $resp_bryg->aumented_r
                ];

                $bryg_array = [
                    "radical" => $resp_bryg->estilo_radical,
                    "genuino" => $resp_bryg->estilo_genuino,
                    "garante" => $resp_bryg->estilo_garante,
                    "basico" => $resp_bryg->estilo_basico
                ];

                //Valor definitivo para aumented (Buscar el valor más alto)
                $aumented_definitive = array_keys($aumented_array, max($aumented_array));

                //Primer valor definitivo para bryg
                $bryg_definitive_first = array_keys($bryg_array, max($bryg_array));
                unset($bryg_array[$bryg_definitive_first[0]]); //Quita del arreglo primer item encontrado

                //Segundo valor definitivo para bryg
                $bryg_definitive_second = array_keys($bryg_array, max($bryg_array));
                unset($bryg_array[$bryg_definitive_second[0]]); //Quita del arreglo el segundo item encontrado

                /**
                 * @todo la validación de los cuadrantes más altos deberían ser funciones independientes
                 */

                //Validar cuadrante más alto BRYG para asignar color
                $radarBrygColor = '0, 169, 84';
                switch ($bryg_definitive_first[0]) {
                    case 'radical':
                        $radarBrygColor = '46, 45, 102';
                        break;
                    case 'genuino':
                        $radarBrygColor = '217, 36, 40';
                        break;
                    case 'garante':
                        $radarBrygColor = '228, 228, 42';
                        break;
                    case 'basico':
                        $radarBrygColor = '0, 169, 84';
                        break;
                    default:
                        $radarBrygColor = '0, 169, 84';
                        break;
                }

                //Validar cuadrante más alto AUMENTED para asignar color
                $radarAumentedColor = '0, 169, 84';
                switch ($aumented_definitive[0]) {
                    case 'analizador':
                        $radarAumentedColor = '2, 136, 209';
                        break;
                    case 'prospectivo':
                        $radarAumentedColor = '253, 216, 53';
                        break;
                    case 'defensivo':
                        $radarAumentedColor = '244, 67, 54';
                        break;
                    case 'reactivo':
                        $radarAumentedColor = '124, 179, 66';
                        break;
                    default:
                        $radarAumentedColor = '124, 179, 66';
                        break;
                }

                //Generar gráfico radar BRYG
                $grafico_radar_bryg = $this->generarGraficoRadarBryg(
                    ['RADICAL', 'GENUINO', 'GARANTE', 'BÁSICO'],
                    [$resp_bryg->estilo_radical, $resp_bryg->estilo_genuino, $resp_bryg->estilo_garante, $resp_bryg->estilo_basico],
                    ['background' => "rgba($radarBrygColor, 0.7)", 'border' => "rgba($radarBrygColor, 1)"],
                    'BRYG Gráfico de radar'
                );

                //Generar gráfico radar AUMENTED
                $grafico_radar_aumented = $this->generarGraficoRadarBryg(
                    ['ANALIZADOR', 'PROSPECTIVO', 'DEFENSIVO', 'REACTIVO'],
                    [$resp_bryg->aumented_a, $resp_bryg->aumented_p, $resp_bryg->aumented_d, $resp_bryg->aumented_r],
                    ['background' => "rgba($radarAumentedColor, 0.7)", 'border' => "rgba($radarAumentedColor, 1)"],
                    'BRYG-A Gráfico de radar'
                );
            }
        }

        if(route("home") == "https://desarrollo.t3rsc.co" || route("home") == "https://listos.t3rsc.co") {
            $requerimiento = Requerimiento::find($reqcandidato->requerimiento_id);
            $empresa_logo = DB::table("empresa_logos")->where('id',$requerimiento->empresa_contrata)->first();
            $logo = (isset($empresa_logo->logo))?$empresa_logo->logo:'';
        }

        $generated_check = null;
        $generated_status = null;

        //Pdf Truora VYM - Listos
        if (route("home") == "https://vym.t3rsc.co" || route("home") == "https://listos.t3rsc.co") {
            //Buscar detalle de la consulta en truora
            $checkTruoraDetail = TruoraIntegrationController::getCheckDetails($reqcandidato->candidato_id, $reqcandidato->requerimiento_id);

            if (!empty($checkTruoraDetail)) {
                $generated_check = $checkTruoraDetail['check']['check_id'];
                $generated_status = $checkTruoraDetail['check']['status'];
            }
        }

        $consulta_seg = null;

        if ($sitioModulo->consulta_seguridad == 'enabled') {
            $consulta_seg = ConsultaSeguridad::where('user_id', $reqcandidato->candidato_id)
            ->where('req_id', $reqcandidato->requerimiento_id)
            ->first();
        }

        $consulta_lista_vinculante = null;

        if ($sitioModulo->listas_vinculantes == 'enabled') {
            $consulta_lista_vinculante = ConsultaListaVinculante::where('user_id', $reqcandidato->candidato_id)
            ->where('req_id', $reqcandidato->requerimiento_id)
            ->first();
        }

        $autoentrevista = '';

        if(route("home") == "https://gpc.t3rsc.co") {
            $autoentrevista = Autoentrevist::where('id_usuario',$user->id)->first();
        }

        $preliminar = PreliminarTranversalesCandidato::where("req_id", $reqcandidato->requerimiento_id)
        ->where("candidato_id", $reqcandidato->candidato_id)
        ->get();

        $hv = Archivo_hv::where("user_id", $reqcandidato->candidato_id)
        ->orderBy("archivo_hv.id","desc")
        ->first();

        //Tusdatos
        $tusdatosData = FuncionesGlobales::getTusDatos($reqcandidato->requerimiento_id, $reqcandidato->candidato_id);

        $consulta_seguridad_proceso = RegistroProceso::where('candidato_id', $reqcandidato->candidato_id)
        ->where('requerimiento_id', $reqcandidato->requerimiento_id)
        ->where('proceso', 'CONSULTA_SEGURIDAD')
        ->first();

        $listas_vinculantes_proceso = RegistroProceso::where('candidato_id', $reqcandidato->candidato_id)
        ->where('requerimiento_id', $reqcandidato->requerimiento_id)
        ->where('proceso', 'LISTAS_VINCULANTES')
        ->first();

        //$pdf = \App::make('snappy.pdf.wrapper');
        //$pdf->loadHTML($view);

        if($data->has("download")) {
            $pdf = \SnappyPDF::loadView('admin.hv.informe_seleccion_pdf_new',[
                'examenes_medicos'=>$examenes_medicos,
                'estudio_seguridad'=>$estudio_seguridad,
                'validacion_documental'=>$validacion_documental,
                'hijos'=>$hijos,
                'familiares_espo'=>$familiares_espo,
                'datos_basicos'=>$datos_basicos,
                'reqcandidato'=>$reqcandidato,
                'user'=>$user,
                'resp_user_excel_basico'=>$resp_user_excel_basico,
                'resp_user_excel_intermedio'=>$resp_user_excel_intermedio,
                'resp_ethical_values'=>$resp_ethical_values,
                'valores_ideal_grafico'=>$valores_ideal_grafico,
                'porcentaje_valores_obtenidos'=>$porcentaje_valores_obtenidos,
                'grafico_radar_valores'=>$grafico_radar_valores,
                'textos_cuantitativos'=>$textos_cuantitativos,
                'area_mayor'=>$area_mayor,
                'area_menor'=>$area_menor,
                'resp_personal_skills'=>$resp_personal_skills,
                'totales_personal_skills'=>$totales_personal_skills,
                'concepto_personal_skills'=>$concepto_personal_skills,
                'resp_bryg'=>$resp_bryg,
                'aumented_definitive'=>$aumented_definitive,
                'bryg_definitive_first'=>$bryg_definitive_first,
                'bryg_definitive_second'=>$bryg_definitive_second,
                'grafico_radar_bryg'=>$grafico_radar_bryg,
                'grafico_radar_aumented'=>$grafico_radar_aumented,
                "txtLugarResidencia"=>$txtLugarResidencia,
                "txtLugarNacimiento"=>$txtLugarNacimiento,
                "txtLugarExpedicion"=>$txtLugarExpedicion,
                "experiencias"=>$experiencias,
                "estudios"=>$estudios,
                "referencias"=>$referencias,
                "experienciaMayorDuracion"=>$experienciaMayorDuracion,
                "familiares"=>$familiares,
                "entrevistas_semi"=>$entrevistas_semi,
                "entrevistas"=>$entrevistas,
                "entrevista_multiple"=>$entrevista_multiple,
                "pruebas"=>$pruebas,
                "experiencias_verificadas"=>$experiencias_verificadas,
                "referencias_estudios_verificados"=>$referencias_estudios_verificados,
                "rpv"=>$rpv,
                "edad"=>$edad,
                "archivo"=>$archivo,
                "experienciaActual"=>$experienciaActual,
                "logo"=>$logo,
                "estudioReciente"=>$estudioReciente,
                "documentos"=>$documentos,
                "generated_check"=>$generated_check,
                "entrevistas_virtuales"=>$entrevistas_virtuales,
                "pruebas_idiomas"=>$pruebas_idiomas,
                "consulta_seg"=>$consulta_seg,
                "generated_status"=>$generated_status,
                'autoentrevista'=>$autoentrevista,
                "preliminar"=>$preliminar,
                "hv"=>$hv,
                "documentos_candidato"=>$documentos_candidato,
                "sitioModulo"=>$sitioModulo,
                "tusdatosData"=>$tusdatosData,
                "consulta_lista_vinculante" => $consulta_lista_vinculante,
                "consulta_seguridad_proceso" => $consulta_seguridad_proceso,
                "listas_vinculantes_proceso" => $listas_vinculantes_proceso,
            ]);

            $output = $pdf->output();
            return $output;
        }
        else{
            return view("admin.hv.informe_seleccion_pdf_new", compact(
                'examenes_medicos',
                'estudio_seguridad',
                'validacion_documental',
                'hijos',
                'familiares_espo',
                'datos_basicos',
                'reqcandidato',
                'user',
                'resp_user_excel_basico',
                'resp_user_excel_intermedio',
                'resp_ethical_values',
                'valores_ideal_grafico',
                'porcentaje_valores_obtenidos',
                'grafico_radar_valores',
                'textos_cuantitativos',
                'area_mayor',
                'area_menor',
                'resp_personal_skills',
                'totales_personal_skills',
                'concepto_personal_skills',
                'resp_bryg',
                'aumented_definitive',
                'bryg_definitive_first',
                'bryg_definitive_second',
                'grafico_radar_bryg',
                'grafico_radar_aumented',
                "txtLugarResidencia",
                "txtLugarNacimiento",
                "txtLugarExpedicion",
                "experiencias",
                "estudios",
                "referencias",
                "experienciaMayorDuracion",
                "familiares",
                "entrevistas_semi",
                "entrevistas",
                "entrevista_multiple",
                "pruebas",
                "experiencias_verificadas",
                "referencias_estudios_verificados",
                "rpv",
                "edad",
                "archivo",
                "experienciaActual",
                "logo",
                "estudioReciente",
                "documentos",
                "generated_check",
                "entrevistas_virtuales",
                "pruebas_idiomas",
                "consulta_seg",
                "generated_status",
                'autoentrevista',
                "preliminar",
                "hv",
                "documentos_candidato",
                "sitioModulo",
                "tusdatosData",
                "consulta_lista_vinculante",
                "consulta_seguridad_proceso",
                "listas_vinculantes_proceso"
            ));
        }

    }

    protected function normalizacionDatosEV($obtenido, $promedio, $desviacion, $division = 1) {
        $total = 0;
        if ($desviacion != 0 && $division != 0) {
            //Se divide entre 2 porque la formula esta en base de 3 puntos y nosotros en 6 estrellas
            $total = round((50 + (((($obtenido / $division) - $promedio) / $desviacion) * 10)), 0);
        }
        return $total;
    }

    protected function obtenerInterpretacionEV($interpretaciones, $valor) {
        $interpretacionValor = null;
        foreach ($interpretaciones as $key => $interpretacion) {
            $interpretacionValor = $interpretacion->where('rango_inferior', '<=', $valor)->where('rango_superior', '>', $valor)->first();
            if ($interpretacionValor != null) {
                return $interpretacionValor;
            }
        }
        return '';
    }

    protected function obtenerPorcentajeEV($maximo, $buscar, $base = 100) {
        $porc = 0;
        if ($maximo != 0) {
            $porc = round($buscar * $base / $maximo);
        }
        return $porc;
    }

    //Crear arreglo para generar gráfico de radar (BRYG - AUMENTED)
    protected function generarGraficoRadarBryg(array $arrayLabels, array $arrayData, array $arrayColors, string $titleText):array
    {
        //Arreglo para generar gráfico
        $grafico_radar = [
            'type' => 'radar',
            'data' => [
                'labels' => [$arrayLabels[0], $arrayLabels[1], $arrayLabels[2], $arrayLabels[3]],
                'datasets' => [
                    [
                        'label' => 'Resultados',
                        'backgroundColor' => [
                            $arrayColors['background']
                        ],
                        'borderColor' => [
                            $arrayColors['border']
                        ],
                        'data' => [
                            $arrayData[0],
                            $arrayData[1],
                            $arrayData[2],
                            $arrayData[3]
                        ],
                        'borderWidth' => 1
                    ]
                ]
            ],
            'options' => [
                'legend' => ['display' => false],
                'title' => [
                    'display' => true,
                    'text' => $titleText
                ]
            ]
        ];

        return $grafico_radar;
    }

    //ficha de candidatos humannet
    public function ficha_candidato_pdf($user_id, Request $data)
    {
        $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            ->leftjoin("cargos_especificos", "requerimientos.cargo_especifico_id", "=", "cargos_especificos.id")
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->leftjoin("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->select("cargos_especificos.descripcion", "requerimiento_cantidato.candidato_id", "requerimientos.sitio_trabajo as sitio_trabajo", "requerimiento_cantidato.candidato_id", "users.name as nombre_user", "datos_basicos.numero_id", "requerimiento_cantidato.created_at", "requerimiento_cantidato.requerimiento_id", "requerimiento_cantidato.id as requerimiento_cantidato_id", "clientes.nombre as cliente_nombre"
            )
            ->where("requerimiento_cantidato.id", $user_id)
            ->orderBy("requerimiento_cantidato.requerimiento_id", "asc")
            ->first();

          $user = User::where("id", $reqcandidato->candidato_id)->select("*")->first();
          //buscar datos para la ficha en tabla requerimiento contrato
          $datos_basicos= RequerimientoContratoCandidato::join("users", "users.id", "=", "requerimiento_contrato_candidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->leftJoin("caja_compensacion", "caja_compensacion.id", "=", "datos_basicos.caja_compensaciones")
            ->leftJoin("fondo_cesantias", "fondo_cesantias.id", "=", "datos_basicos.fondo_cesantias")
            ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
            ->leftJoin("nivel_academico", "nivel_academico.id", "=", "datos_basicos.nivel_estudio")
            //->leftJoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
            //->leftJoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
            //->leftJoin("fondo_cesantias", "fondo_cesantias.id", "=", "requerimiento_contrato_candidato.fondo_cesantia_id")
            //->leftJoin("caja_compensacion", "caja_compensacion.id", "=", "requerimiento_contrato_candidato.caja_compensacion_id")
            ->leftJoin("bancos", "bancos.id", "=", "requerimiento_contrato_candidato.nombre_banco")
            ->where("requerimiento_contrato_candidato.requerimiento_id",$reqcandidato->requerimiento_id)
            ->where("requerimiento_contrato_candidato.candidato_id",$reqcandidato->candidato_id)
            //->whereIn('procesos_candidato_req.proceso',['ENVIO_CONTRATACION'])
            ->select("datos_basicos.*","entidades_afp.descripcion as entidades_afp_des"
                , "entidades_eps.descripcion as entidades_eps_des"
                , "fondo_cesantias.descripcion as fondo_cesantia_des"
                , "estados_civiles.descripcion as estado_civil_des"
                , "caja_compensacion.descripcion as caja_compensacion_des"
                , "requerimiento_contrato_candidato.nombre_banco as nombre_banco_des"
                , "requerimiento_contrato_candidato.fecha_ingreso as fecha_inicio_contrato"
                , "requerimiento_contrato_candidato.fecha_ingreso as fecha_ingreso_contra"
                , "requerimiento_contrato_candidato.trabajo_dia"
                , "requerimiento_contrato_candidato.trabajo_noche"
                , "requerimiento_contrato_candidato.tabajo_fin"
                , "requerimiento_contrato_candidato.part_time"
                , "requerimiento_contrato_candidato.comentarios"
                , "requerimiento_contrato_candidato.numero_cuenta"
                , "requerimiento_contrato_candidato.tipo_cuenta"
                , "requerimiento_contrato_candidato.created_at as fecha_contrato"
                , "nivel_academico.descripcion as nivel_estudiado"
            )
            ->orderBy("requerimiento_contrato_candidato.id","desc")
            ->groupBy('users.id')
            ->first();

            $documentos_candidato = Documentos::where("numero_id",$datos_basicos->numero_id)
                                             ->orderBy("id","desc")->groupBy("tipo_documento_id")
                                             ->get();

            $archivo = Documentos::select('nombre_archivo')->where("user_id", $user->id)
                                 ->where("descripcion_archivo", 'HOJA DE VIDA')
                                 ->orderBy('created_at','DESC')->first();

        //$edad = ($datos_basicos->fecha_nacimiento != 0 && $datos_basicos->fecha_nacimiento != "")?Carbon::parse($datos_basicos->fecha_nacimiento)->age:"";
        $lugarnacimiento = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
          $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $datos_basicos->pais_nacimiento)
        ->where("ciudad.cod_departamento", $datos_basicos->departamento_nacimiento)
        ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_nacimiento)
        ->first();

        $lugarexpedicion = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
          ->where("ciudad.cod_pais", $datos_basicos->pais_id)
          ->where("ciudad.cod_departamento", $datos_basicos->departamento_expedicion_id)
          ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_expedicion_id)->first();

        $lugarresidencia = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $datos_basicos->pais_residencia)
        ->where("ciudad.cod_departamento", $datos_basicos->departamento_residencia)
        ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_residencia)->first();

        $ciudad = Ciudad::select('nombre')->where('cod_pais',$datos_basicos->pais_residencia)
                        ->where('cod_ciudad',$datos_basicos->ciudad_residencia)
                        ->where('cod_departamento',$datos_basicos->departamento_residencia)
                        ->first();

        $txtLugarNacimiento = "";
        $txtLugarExpedicion = "";
        $txtLugarResidencia = "";

        if($lugarnacimiento != null) {
          $txtLugarNacimiento = $lugarnacimiento->value;
        }
        if($lugarexpedicion != null) {
          $txtLugarExpedicion = $lugarexpedicion->value;
        }
        if($lugarresidencia != null) {
          $txtLugarResidencia = $ciudad;
        }

        if (route('home') == "https://nases.t3rsc.co" || route('home') == "http://nases.t3rsc.co" || route('home') == "https://demo.t3rsc.co" || route('home') == "http://demo.t3rsc.co" || route('home') == "http://localhost:8000"){

            $familiares = GrupoFamilia::leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select("grupos_familiares.*", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "grupos_familiares.profesion_id as profesion")
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->get();

        }else{
        
            $familiares = GrupoFamilia::leftjoin("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select("grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "grupos_familiares.profesion_id as profesion")
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->get();
        }
            
        $hijos = GrupoFamilia::leftjoin("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.*",
                "tipos_documentos.descripcion as tipo_documento", 
                "escolaridades.descripcion as escolaridad", 
                "parentescos.descripcion as parentesco",
                "generos.descripcion as genero",
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'), 
                "profesiones.descripcion as profesion")
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->where('parentescos.id','2')
            ->groupBy('grupos_familiares.documento_identidad')
            ->take(4)
            ->get();

        //consulta documentos
        $consulta= DocumentosVerificados::join("users", "users.id", "=", "documentos_verificados.user_id")->where("candidato_id", $reqcandidato->candidato_id)->whereNotNull('nombre_archivo');

        //Examenes medicos
        $examenes_medicos = $consulta->where("tipo_documento_id",9)
            ->select('users.name','documentos_verificados.*')
            ->get();

        $estudio_seguridad = DocumentosVerificados::join("users", "users.id", "=", "documentos_verificados.user_id")->where("candidato_id", $reqcandidato->candidato_id)
            ->whereNotNull('nombre_archivo')->where("tipo_documento_id",8)
            ->select('users.name','documentos_verificados.*')
            ->get();

         //consulta documentos
        $documentos= DocumentosVerificados::join("users", "users.id", "=", "documentos_verificados.user_id")->join("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")->where("candidato_id", $reqcandidato->candidato_id)             ->whereNotNull('nombre_archivo')->whereNotIn('documentos_verificados.tipo_documento_id',[8,9])
           ->select('documentos_verificados.nombre_archivo', 'documentos_verificados.descripcion_archivo as descripcion')->get();
        //$pruebas_c = GestionPrueba::where("candidato_id",$reqcandidato->candidato_id)->orderBy('id','DESC')->first();
        $sitio = Sitio::first();
        $logo = $sitio->logo;

         $requerimiento=Requerimiento::join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->where("requerimientos.id",$reqcandidato->requerimiento_id)
        ->select("clientes.nombre as cliente","cargos_especificos.descripcion as cargo")
        ->first();

        if(route("home") == "http://desarrollo.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co" || route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" || route("home") == "https://pruebaslistos.t3rsc.co" || route("home") == "https://listos.t3rsc.co"){

          //$requerimiento = Requerimiento::find($reqcandidato->requerimiento_id);
          $empresa_logo = DB::table("empresa_logos")->where('id',$requerimiento->empresa_contrata)->first();
          $logo=(isset($empresa_logo->logo))?$empresa_logo->logo:'';
        }

        $hv=Archivo_hv::where("user_id",$reqcandidato->candidato_id)->orderBy("archivo_hv.id","desc")->first();

        $view = \View::make('admin.ficha_candidato_pdf', compact('requerimiento','hijos','datos_basicos', 'reqcandidato', 'user', "txtLugarResidencia", "txtLugarNacimiento", "txtLugarExpedicion", "familiares", "entrevistas_semi", "edad","archivo","logo","documentos","documentos_candidato"))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

       return $pdf->stream('ficha_postulacion.pdf');
    }

    public function pdf_informe_individual($user_id,$req_id,Request $data){

        $mes=$this->meses[date("n")];
        $fecha=date("d")." de ".$mes.",".date("Y");

         $datos_basicos=DatosBasicos::join("users","users.id","=","datos_basicos.user_id")
         ->leftjoin("estados_civiles","estados_civiles.id","=","datos_basicos.estado_civil")
         ->where("datos_basicos.user_id",$user_id)
         ->select("users.foto_perfil as foto","datos_basicos.*","estados_civiles.descripcion as estado_civil")
         ->first();

        $requerimiento=Requerimiento::join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->where("requerimientos.id",$req_id)
        ->select("clientes.nombre as cliente","cargos_especificos.descripcion as cargo")
        ->first();

         $requerimientoCompetencias = RequerimientoCompetencia::join("preliminar_transversales","preliminar_transversales.id","=","requerimiento_competencia.competencia_id")
        ->leftjoin("preliminar_transversales_candidato","preliminar_transversales_candidato.transversal_id","=","requerimiento_competencia.competencia_id")
        ->select("preliminar_transversales.descripcion as competencia","requerimiento_competencia.ideal as ideal","preliminar_transversales.id as id_competencia","preliminar_transversales_candidato.entrevista_bei as entrevista_bei","preliminar_transversales_candidato.evaluacion_psico","preliminar_transversales_candidato.assessment_center","preliminar_transversales_candidato.referencias","preliminar_transversales_candidato.observaciones")
        ->groupBy("preliminar_transversales.id")

        ->where("requerimiento_competencia.req_id",$req_id)
        ->where("preliminar_transversales_candidato.candidato_id",$user_id)
        ->get();
        $entrevista_bei = PreliminarTranversalesCandidato::join("preliminar_transversales","preliminar_transversales.id","=","preliminar_transversales_candidato.transversal_id")
        ->join("requerimiento_competencia","requerimiento_competencia.competencia_id","=","preliminar_transversales.id")
        ->where("preliminar_transversales_candidato.req_id",$req_id)
        ->where("preliminar_transversales_candidato.candidato_id",$user_id)
        ->select("preliminar_transversales.descripcion as competencia","preliminar_transversales_candidato.puntuacion as puntuacion","requerimiento_competencia.ideal as ideal")
        ->get();

         $edad = ($datos_basicos->fecha_nacimiento != 0 && $datos_basicos->fecha_nacimiento != "")?Carbon::parse($datos_basicos->fecha_nacimiento)->age:"";

         $evaluacion=0;
         $assessment=0;
         $referencias=0;

        foreach($requerimientoCompetencias as $req){

           $evaluacion+=$req->evaluacion_psico;
           $assessment+=$req->assessment_center;
           $referencias+=$req->referencias;
        }
       

        $view = \View::make('admin.hv.informe_individual_pdf', compact("requerimientoCompetencias","assessment","datos_basicos","edad","evaluacion","assessment","referencias","entrevista_bei","requerimiento","fecha"))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

       return $pdf->stream('informe_individual_pdf.pdf');

    }
    
    public function pdf_informe_seleccion_gpc($user_id, Request $data)
    {

        $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            ->join("cargos_especificos", "requerimientos.cargo_especifico_id", "=", "cargos_especificos.id")
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->select("cargos_especificos.descripcion", "requerimiento_cantidato.candidato_id", "requerimientos.sitio_trabajo as sitio_trabajo", "requerimiento_cantidato.candidato_id", "users.name as nombre_user", "datos_basicos.numero_id", "requerimiento_cantidato.created_at", "requerimiento_cantidato.requerimiento_id", "requerimiento_cantidato.id as requerimiento_cantidato_id", "clientes.nombre as cliente_nombre"
            )
            ->where("requerimiento_cantidato.id", $user_id)
            ->orderBy("requerimiento_cantidato.requerimiento_id", "asc")
            ->first();

         $user = User::where("id", $reqcandidato->candidato_id)->select("*")->first();

         $datos_basicos = DatosBasicos::join("users","users.id","=","datos_basicos.user_id")
            ->leftJoin("tipos_documentos", "tipos_documentos.id", "=", "datos_basicos.tipo_id")
            ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
            ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
            ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
            ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
            ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->where("datos_basicos.user_id", $reqcandidato->candidato_id)
            ->select("datos_basicos.datos_basicos_activo as datos_contacto","datos_basicos.*", "tipos_documentos.descripcion as dec_tipo_doc", "generos.descripcion as genero_desc"
                , "estados_civiles.descripcion as estado_civil_des"
                , "aspiracion_salarial.descripcion as aspiracion_salarial_des"
                , "clases_libretas.descripcion as clases_libretas_des"
                , "tipos_vehiculos.descripcion as tipos_vehiculos_des"
                , "categorias_licencias.descripcion as categorias_licencias_des"
                , "entidades_afp.descripcion as entidades_afp_des"
                , "entidades_eps.descripcion as entidades_eps_des"
            )
            ->first();

        $archivo = Documentos::select('nombre_archivo')->where("user_id", $user->id)->where("descripcion_archivo", 'HOJA DE VIDA')->orderBy('created_at','DESC')->first();

        $edad = ($datos_basicos->fecha_nacimiento != 0 && $datos_basicos->fecha_nacimiento != "")?Carbon::parse($datos_basicos->fecha_nacimiento)->age:"";

        $lugarnacimiento = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
          $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
          ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
          ->where("ciudad.cod_pais", $datos_basicos->pais_nacimiento)
          ->where("ciudad.cod_departamento", $datos_basicos->departamento_nacimiento)
          ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_nacimiento)
          ->first();

        $lugarexpedicion = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_id)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_expedicion_id)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_expedicion_id)->first();

        $lugarresidencia = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_residencia)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_residencia)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_residencia)->first();

        $txtLugarNacimiento = "";
        $txtLugarExpedicion = "";
        $txtLugarResidencia = "";

        if ($lugarnacimiento != null) {
            $txtLugarNacimiento = $lugarnacimiento->value;
        }
        if ($lugarexpedicion != null) {
            $txtLugarExpedicion = $lugarexpedicion->value;
        }
        if ($lugarresidencia != null) {
            $txtLugarResidencia = $lugarresidencia->value;
        }

        if (route('home') == "https://nases.t3rsc.co" || route('home') == "http://nases.t3rsc.co" ||
            route('home') == "https://demo.t3rsc.co" || route('home') == "http://demo.t3rsc.co" || 
            route('home') == "http://localhost:8000") {

            $experiencias = Experiencias::join('aspiracion_salarial', 'aspiracion_salarial.id', '=', 'experiencias.salario_devengado')
            ->join('motivos_retiros', 'motivos_retiros.id', '=', 'experiencias.motivo_retiro')
            ->where("experiencias.user_id", $reqcandidato->candidato_id)
            ->select('experiencias.*','aspiracion_salarial.descripcion as salario_cand','motivos_retiros.descripcion as motivo_retiro_cand')
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->get();

        }else{

            $experiencias = Experiencias::join("paises", "paises.cod_pais", "=", "experiencias.pais_id")
                ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
                ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
                ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
                ->join("departamentos", function ($join) {
                    $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
                        ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
                })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
                    ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
            })->where("experiencias.user_id", $reqcandidato->candidato_id)
            ->select(
                "aspiracion_salarial.descripcion as salario",
                "experiencias.fecha_inicio as fecha_inicio",
                "experiencias.fecha_final as fecha_final",
                "experiencias.cargo_especifico as desc_cargo",
                "motivos_retiros.descripcion as desc_motivo",
                DB::raw(" (select UPPER(CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre))) AS ciudad"),
                "experiencias.*"
            )
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->get();
        }

        $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        ->select("estudios.*", "niveles_estudios.descripcion as desc_nivel")
        ->where("estudios.user_id", $reqcandidato->candidato_id)
        ->get();

        //Ultimo
        $estudioReciente = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        ->select(
            "estudios.titulo_obtenido",
            "estudios.fecha_finalizacion",
            "niveles_estudios.descripcion as desc_nivel"
        )
        ->orderBy("estudios.fecha_finalizacion", "desc")
        ->where("estudios.user_id", $reqcandidato->candidato_id)
        ->first();

        $referencias = ReferenciasPersonales::join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
        ->where("referencias_personales.user_id", $reqcandidato->candidato_id)
        ->select(DB::raw("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS ciudades"), "tipo_relaciones.descripcion as desc_tipo", "referencias_personales.*")
        ->get();

        if (route('home') == "https://nases.t3rsc.co" || route('home') == "http://nases.t3rsc.co" ||
            route('home') == "https://demo.t3rsc.co" || route('home') == "http://demo.t3rsc.co" || 
            route('home') == "http://localhost:8000"){

            $familiares = GrupoFamilia::leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select("grupos_familiares.*", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "grupos_familiares.profesion_id as profesion")
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->get();

        }else{

            $familiares = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select("grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "grupos_familiares.profesion_id as profesion")
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->get();
        }

        //Entrevistas
        $entrevistas = EntrevistaCandidatos::join("users", "users.id", "=", "entrevistas_candidatos.user_gestion_id")
            ->join("tipo_fuente", "tipo_fuente.id", "=", "entrevistas_candidatos.fuentes_publicidad_id")
            ->where("entrevistas_candidatos.candidato_id", $reqcandidato->candidato_id)
            ->where("entrevistas_candidatos.activo", "1")

            ->select("entrevistas_candidatos.*", "users.name", "tipo_fuente.descripcion as desc_fuente")
            ->orderBy("entrevistas_candidatos.created_at", "desc")
            ->get();

        $familiares_espo = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select(
                "grupos_familiares.*",
                "tipos_documentos.descripcion as tipo_documento",
                "escolaridades.descripcion as escolaridad",
                "parentescos.descripcion as parentesco",
                "generos.descripcion as genero",
                "profesiones.descripcion as profesion"
            )
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->where('parentescos.id','1')
            ->get();
            
        $hijos = GrupoFamilia::leftjoin("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select(
                "grupos_familiares.*",
                "tipos_documentos.descripcion as tipo_documento", 
                "escolaridades.descripcion as escolaridad", 
                "parentescos.descripcion as parentesco",
                "generos.descripcion as genero",
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'), 
                "profesiones.descripcion as profesion"
            )
            ->where("grupos_familiares.user_id", $reqcandidato->candidato_id)
            ->where('parentescos.id','2')
            ->get();

        //Entrevistas Semi
        $entrevistas_semi = EntrevistaSemi::join("users", "users.id", "=", "entrevista_semi.user_gestion_id")
            ->where("entrevista_semi.candidato_id", $reqcandidato->candidato_id)
            ->where("entrevista_semi.activo", 1)
            ->select("entrevista_semi.*", "users.name")
            ->orderBy("entrevista_semi.created_at", "desc")
            ->get();

        //Entrevista virtual
        $entrevistas_virtuales = EntrevistaVirtual::join("preguntas_entre", "preguntas_entre.entre_vir_id", "=", "entrevista_virtual.id")
        ->join("respuestas_entre", "respuestas_entre.preg_entre_id", "=", "preguntas_entre.id")
        ->where("entrevista_virtual.req_id", $reqcandidato->requerimiento_id)
        ->where("respuestas_entre.candidato_id", $reqcandidato->candidato_id)
        ->select("respuestas_entre.*", "preguntas_entre.descripcion as pregunta")
        ->get();

        //Pruebas realizadas
        $pruebas = GestionPrueba::join("users", "users.id", "=", "gestion_pruebas.user_id")
            ->join("tipos_pruebas", "tipos_pruebas.id", "=", "gestion_pruebas.tipo_prueba_id")
            ->where("gestion_pruebas.candidato_id", $reqcandidato->candidato_id)
            ->where("gestion_pruebas.activo", "1")
            ->select("gestion_pruebas.*", "tipos_pruebas.descripcion as prueba_desc", "users.name")
            ->get();

        //EXPERIENCIAS VERIFICADAS
        $experiencias_verificadas = ExperienciaVerificada::join("experiencias", "experiencias.id", "=", "experiencia_verificada.experiencia_id")
            ->join("motivos_retiros", "motivos_retiros.id", "=", "experiencia_verificada.motivo_retiro_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
            //->where("experiencias.activo", "1")
            ->where("experiencias.user_id", $reqcandidato->candidato_id)
            ->select("experiencias.*", "motivos_retiros.*", "cargos_genericos.*", "experiencia_verificada.*",
                "experiencia_verificada.meses_laborados as meses",
                "experiencia_verificada.anios_laborados as años",
                "cargos_genericos.descripcion as name_cargo",
                "motivos_retiros.descripcion as name_motivo",
                "experiencias.fecha_inicio as exp_fecha_inicio",
                "experiencias.fecha_final as exp_fechafin")
            ->get();

        $fecha = Carbon::now();

        $experienciaMayorDuracion = Experiencias::leftjoin('aspiracion_salarial', 'aspiracion_salarial.id', '=', 'experiencias.salario_devengado')->select(\DB::raw("*,(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) AS dias,(user_id) AS usuario"),"aspiracion_salarial.descripcion AS salario")
            ->selectRaw("experiencias.salario_devengado")
            ->where("user_id", $reqcandidato->candidato_id)
            ->havingRaw("dias >= (SELECT MAX(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) FROM experiencias as e WHERE e.user_id = experiencias.user_id)")
            ->first();

        $experienciaActual = Experiencias::leftjoin('aspiracion_salarial', 'aspiracion_salarial.id', '=', 'experiencias.salario_devengado')
            ->where("experiencias.user_id", $reqcandidato->candidato_id)
            ->selectRaw("experiencias.salario_devengado")
            ->select("aspiracion_salarial.descripcion as salario", "experiencias.*")
            ->orderBy("experiencias.fecha_inicio", "DESC")
            ->first();

        //REFERENCIAS PERSONALES VERIFICADAS
        $rpv = ReferenciaPersonalVerificada::join("referencias_personales", "referencias_personales.id", "=", "ref_personales_verificada.referencia_personal_id")
            ->where("ref_personales_verificada.candidato_id", $reqcandidato->candidato_id)
            ->where("ref_personales_verificada.req_id", $reqcandidato->requerimiento_id)
            ->first();

        //consulta documentos
        $consulta= DocumentosVerificados::join("users", "users.id", "=", "documentos_verificados.user_id")->where("candidato_id", $reqcandidato->candidato_id)->whereNotNull('nombre_archivo');

        //Examenes medicos
        $examenes_medicos = $consulta->where("tipo_documento_id",9)
            ->select('users.name','documentos_verificados.*')
            ->get();

        $estudio_seguridad = DocumentosVerificados::join("users", "users.id", "=", "documentos_verificados.user_id")->where("candidato_id", $reqcandidato->candidato_id)
            ->whereNotNull('nombre_archivo')->where("tipo_documento_id",8)
            ->select('users.name','documentos_verificados.*')
            ->get();

         //consulta documentos
        $documentos= DocumentosVerificados::join("users", "users.id", "=", "documentos_verificados.user_id")->join("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")->where("candidato_id", $reqcandidato->candidato_id)->whereNotNull('nombre_archivo')->whereNotIn('documentos_verificados.tipo_documento_id',[8,9])
            ->select('documentos_verificados.nombre_archivo', 'documentos_verificados.descripcion_archivo as descripcion')->get();

        //$pruebas_c = GestionPrueba::where("candidato_id",$reqcandidato->candidato_id)->orderBy('id','DESC')->first();

        $sitio = Sitio::first();
        $logo = $sitio->logo;

        if(route("home") == "http://desarrollo.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co" ||
            route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" || route("home") == "https://pruebaslistos.t3rsc.co" || route("home") == "https://listos.t3rsc.co"){

          $requerimiento = Requerimiento::find($reqcandidato->requerimiento_id);

          $empresa_logo = DB::table("empresa_logos")->where('id',$requerimiento->empresa_contrata)->first();

            $logo=(isset($empresa_logo->logo))?$empresa_logo->logo:'';
        }

        $consulta_seg = null;

        $idiomas = IdiomaUsuario::where("id_usuario",$datos_basicos->user_id)->get();

        $autoentrevista = '';

        if(route("home") == "https://gpc.t3rsc.co") {
            $autoentrevista = Autoentrevist::where('id_usuario',$user->id)->first();
        }

        /*return view("admin.hv.informe_seleccion_pdf", compact('examenes_medicos','estudio_seguridad','hijos','familiares_espo','datos_basicos', 'reqcandidato', 'user', "txtLugarResidencia", "txtLugarNacimiento", "txtLugarExpedicion", "experiencias", "estudios", "referencias", "experienciaMayorDuracion", "familiares", "entrevistas_semi", "entrevistas", "pruebas", "experiencias_verificadas", "rpv", "edad","archivo", "experienciaActual","logo","estudioReciente","documentos","generated_check","entrevistas_virtuales","consulta_seg","generated_status"));*/

        $view = \View::make('admin.hv.informe_contratacion_pdf', compact('examenes_medicos','estudio_seguridad','hijos','familiares_espo','datos_basicos', 'reqcandidato', 'user',"lugarnacimiento","lugarexpedicion", "lugarresidencia", "txtLugarResidencia","lugarnacimiento", "txtLugarNacimiento", "txtLugarExpedicion", "experiencias", "estudios", "referencias", "experienciaMayorDuracion", "familiares", "entrevistas_semi", "entrevistas", "pruebas", "experiencias_verificadas", "rpv", "edad","archivo", "experienciaActual","logo","estudioReciente","documentos","entrevistas_virtuales","consulta_seg","idiomas",'autoentrevista'))->render();

        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($view);

        return $pdf->stream('informe_seleccion_pdf.pdf');
    }

    public function pdf_habeas($req_can_id, Request $data){

       $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
         ->leftjoin('ciudad', function ($join) {
            $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
            ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
            ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->leftjoin('departamentos', function ($join2) {
                $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
            })
            ->leftjoin('paises', 'requerimientos.pais_id', '=', 'paises.cod_pais')
            ->leftjoin("tipos_jornadas","tipos_jornadas.id","=","requerimientos.tipo_jornadas_id")
            ->leftjoin("cargos_especificos", "requerimientos.cargo_especifico_id", "=", "cargos_especificos.id")
            ->leftjoin("users", "users.id", "=", "requerimientos.solicitado_por")
            ->leftjoin("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->leftjoin("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->select("ciudad.nombre as ciudad_req","users.numero_id as cedula_psico","users.name as nombre_psicologo","requerimiento_cantidato.candidato_id as candidato_id","requerimientos.funciones as funcion_laboral","requerimientos.salario as salario","tipos_jornadas.descripcion as horario","clientes.nombre as cliente_nombre","cargos_especificos.descripcion as cargo_req")
            ->where("requerimiento_cantidato.id",$req_can_id)
            ->orderBy("requerimiento_cantidato.requerimiento_id", "asc")
            ->first();
            //dd($reqcandidato);

            $datos_basicos = DatosBasicos::
            join('ciudad', function ($join) {
                $join->on('datos_basicos.ciudad_expedicion_id', '=', 'ciudad.cod_ciudad')
                    ->on('datos_basicos.departamento_expedicion_id', '=', 'ciudad.cod_departamento')
                    ->on('datos_basicos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->join('departamentos', function ($join2) {
                $join2->on('datos_basicos.departamento_expedicion_id', '=', 'departamentos.cod_departamento')
                    ->on('datos_basicos.pais_residencia', '=', 'departamentos.cod_pais');
            })
            ->join('paises', 'datos_basicos.pais_id', '=', 'paises.cod_pais')
            
            ->leftJoin("tipos_documentos", "tipos_documentos.id", "=", "datos_basicos.tipo_id")
            ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
            ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
            ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
            ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
            ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->where("datos_basicos.user_id", $reqcandidato->candidato_id)
            ->select("ciudad.nombre as ciudad_expedicion","datos_basicos.datos_basicos_activo as datos_contacto","datos_basicos.*", "tipos_documentos.descripcion as dec_tipo_doc", "generos.descripcion as genero_desc"
                , "estados_civiles.descripcion as estado_civil_des"
                , "aspiracion_salarial.descripcion as aspiracion_salarial_des"
                , "clases_libretas.descripcion as clases_libretas_des"
                , "tipos_vehiculos.descripcion as tipos_vehiculos_des"
                , "categorias_licencias.descripcion as categorias_licencias_des"
                , "entidades_afp.descripcion as entidades_afp_des"
                , "entidades_eps.descripcion as entidades_eps_des"
            )
            ->first();
       //dd($datos_basicos);

        $view = \View::make('admin.hv.habeas_pdf', compact('datos_basicos', 'reqcandidato', 'user', "txtLugarResidencia", "txtLugarNacimiento", "txtLugarExpedicion", "experiencias", "estudios", "referencias", "experienciaMayorDuracion", "familiares", "entrevistas_semi", "entrevistas", "pruebas", "experiencias_verificadas", "rpv", "edad", "experienciaActual"))->render();
        $pdf  = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('hoja_de_vida.pdf');
    }

    public function orden_envio_pdf(Request $data, $user_id, $valida)
    {
        //Traer los datos para el reporte
        $requerimiento = Requerimiento::join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->join("niveles_estudios", "niveles_estudios.id", "=", "requerimientos.nivel_estudio")
            ->join("generos", "generos.id", "=", "requerimientos.genero_id")
            ->join("tipos_jornadas", "tipos_jornadas.id", "=", "requerimientos.tipo_jornadas_id")
            ->join("tipos_nominas", "tipos_nominas.id", "=", "requerimientos.tipo_nomina")
            ->join("tipos_salarios", "tipos_salarios.id", "=", "requerimientos.tipo_salario")
            ->join("tipos_contratos", "tipos_contratos.id", "=", "requerimientos.tipo_contrato_id")
            ->join("clientes", "clientes.id", "=", "requerimientos.negocio_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimientos.solicitado_por")
        //->join("estados","estados.id","=","estados_requerimiento.estado")
            ->where("requerimientos.id", $user_id)
            ->select("requerimientos.negocio_id", "clientes.nombre", "requerimientos.solicitado_por", "requerimientos.id", "requerimientos.created_at as fecha_requerimiento", "requerimientos.fecha_ingreso", "requerimientos.num_vacantes", "requerimientos.salario", "cargos_especificos.descripcion as descrip_cargo", "niveles_estudios.descripcion as descrip_estudio", "generos.descripcion as descrip_genero", "tipos_jornadas.descripcion as descrip_jornada", "tipos_jornadas.hora_inicio", "tipos_jornadas.hora_fin", "tipos_nominas.descripcion as descrip_nomina", "tipos_salarios.descripcion as descrip_salario", "requerimientos.centro_costo_produccion", "requerimientos.fecha_terminacion", "tipos_contratos.descripcion as descrip_contrato", "datos_basicos.nombres", "datos_basicos.primer_apellido", "datos_basicos.segundo_apellido",
                //"estados.descripcion as estado_req",
                DB::raw("(select estado from  (select estado from estados_requerimiento where req_id=" . $user_id . " order by id desc) where rownum <= 1) as estado"))
            ->first();
        //dd($requerimiento);

        //Candidatos con el estado de Examenes para el caso de Examenes medicos O contrato para los candidatos enviados a contratar
        if($valida == 1){

            $examenes = RegistroProceso::join("datos_basicos", "datos_basicos.user_id", "=", "procesos_candidato_req.candidato_id")
                ->join("generos", "generos.id", "=", "datos_basicos.genero")
                ->join("tipos_documentos", "tipos_documentos.id", "=", "datos_basicos.tipo_id")
                ->where("proceso", "ENVIO_EXAMENES")
                ->where("REQUERIMIENTO_ID", $user_id)
                ->select("tipos_documentos.descripcion as tipo_documento", "datos_basicos.numero_id", "datos_basicos.nombres", "datos_basicos.primer_apellido", "datos_basicos.segundo_apellido", "generos.descripcion as genero", "procesos_candidato_req.fecha_inicio")
                ->get();

        }else{

           $examenes = RegistroProceso::join("datos_basicos", "datos_basicos.user_id", "=", "procesos_candidato_req.candidato_id")
                ->join("generos", "generos.id", "=", "datos_basicos.genero")
                ->join("tipos_documentos", "tipos_documentos.id", "=", "datos_basicos.tipo_id")
                ->where("proceso", "ENVIO_CONTRATACION")
                ->where("REQUERIMIENTO_ID", $user_id)
                ->select("tipos_documentos.descripcion as tipo_documento", "datos_basicos.numero_id", "datos_basicos.nombres", "datos_basicos.primer_apellido", "datos_basicos.segundo_apellido", "generos.descripcion as genero", "procesos_candidato_req.fecha_inicio")
                ->get();
        }

        //dd($examenes);

        $view = \View::make('admin.reportes.orden.reporte_orden_pdf', compact("requerimiento", "examenes", "valida"))->render();
        $pdf  = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper("A4", "landscape");
        return $pdf->stream('hoja_de_vida.pdf');
    }

    public function vincular(Request $data)
    {

        //dd($data->all());
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
            ->first();

        return view("admin.reclutamiento.modal.enviar_vinculacion", compact("candidato"));
    }

    public function confirmar_enviar_validacion(Request $data)
    {

        $valida_proceso = $this->validaEstadoProcesoCandidato("ENVIO_VALIDACION", $data->get("candidato_req"));
        if ($valida_proceso["success"]) {
            return response()->json(["success" => false, "view" => $valida_proceso["view"]]);
        }

        //Usuarios a quienes se envian el correo
        $emails = User::join("role_users", "role_users.user_id", "=", "users.id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->whereIn("role_users.role_id", [
                config('conf_aplicacion.VINCULACION'),
            ])
            ->pluck("datos_basicos.email")
            ->toArray();
        //dd($emails);

        //Variables de notificación---------------------------------------------------------------
        //Datos del usuario
        $datos_usuario = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->first();
        //dd($datos_usuario);

        $funcionesGlobales = new FuncionesGlobales();
        if (isset($funcionesGlobales->sitio()->nombre)) {
            if ($funcionesGlobales->sitio()->nombre != "") {
                $nombre = $funcionesGlobales->sitio()->nombre;
            } else {
                $nombre = "Desarrollo";
            }
        }

        //Email Notificacion para los
        Mail::send('emails.interna.vincular', ["datos_usuario" => $datos_usuario], function ($message) use ($data, $emails) {
            $message->to('javier.chiquito@t3rsc.co', '$nombre - T3RS')->cc($emails)->subject('Notificación (Envió de Candidato a Vincular)!')
            ->getHeaders()
            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        $campos = [
            'requerimiento_candidato_id' => $data->get("candidato_req"),
            'usuario_envio'              => $this->user->id,
            "fecha_inicio"               => date("Y-m-d H:i:s"),
            'proceso'                    => "ENVIO_VALIDACION",
        ];

        $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));

        $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();

        return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $data->get("candidato_req")]);
    }

    public function vinculacion_lista(Request $data)
    {

        //dd($data->codigo);
        $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->whereRaw(" (procesos_candidato_req.apto is null or  procesos_candidato_req.apto = '')  ")
            ->where("requerimiento_cantidato.estado_candidato", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
            ->where("procesos_candidato_req.estado", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
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
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_VALIDACION"])
            ->select("procesos_candidato_req.proceso", "procesos_candidato_req.id as ref_id", "datos_basicos.*", "requerimiento_cantidato.*")
            ->get();

        return view("admin.reclutamiento.vinculacion", compact("candidatos"));
    }

    public function gestionar_vinculacion($id)
    {

        $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = '' )")
            ->where("procesos_candidato_req.id", $id)
            ->select("procesos_candidato_req.requerimiento_candidato_id", "procesos_candidato_req.id as ref_id", "datos_basicos.*", 'requerimiento_cantidato.requerimiento_id', 'requerimiento_cantidato.candidato_id', 'requerimiento_cantidato.estado_candidato', 'requerimiento_cantidato.otra_fuente')
            ->first();

        $estados_procesos_referenciacion = RegistroProceso::
            join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_VALIDACION"])->get();

        //dd($candidato->requerimiento_id);
        //Consulta para buscar el ID  de la ficha
        $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->where("requerimientos.id", $candidato->requerimiento_id)
            ->select("negocio.cliente_id", "requerimientos.cargo_especifico_id")
            ->first();
        //dd($requerimiento);

        //Del resultado de la contulta $requerimiento salen las variables para hallar la ficha
        $ficha_requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("ficha", function ($join) {
                $join->on("negocio.cliente_id", "=", "ficha.cliente_id")
                    ->on("requerimientos.cargo_especifico_id", "=", "ficha.cargo_cliente");
            })
            ->where("ficha.cliente_id", $requerimiento->cliente_id)
            ->where("ficha.cargo_cliente", $requerimiento->cargo_especifico_id)
            ->where("requerimientos.id", $candidato->requerimiento_id)
            ->select("ficha.id")
            ->first();
        //dd($ficha_requerimiento->id);

        $validacion = AuxiliarFicha::join("tipos_documentos", "tipos_documentos.id", "=", "auxiliar_ficha.valor")
            ->where("auxiliar_ficha.identificador_entidad", "DOCUMENTOS_VALIDAR")
            ->where("auxiliar_ficha.ficha_id", $ficha_requerimiento->id)
            ->get();

        $ficha = $ficha_requerimiento->id;

        return view("admin.reclutamiento.gestionar_vinculacion", compact("candidato", "estados_procesos_referenciacion", "validacion", "ficha"));
    }

    public function validar_vinculacion(Request $data)
    {
        if ($data->get("req_id") != "" && $data->get("user_id") != "" && $data->get("ficha_id") != "" && $data->get("documento_id") != "") {
            //Guardar la validacion de los documentos
            $vinculacion = new VinculacionCandidato();
            
            $vinculacion->fill([
                "user_id"      => $data->get("user_id"),
                "req_id"       => $data->get("req_id"),
                "ficha_id"     => $data->get("ficha_id"),
                "id_documento" => $data->get("documento_id"),
                "estado"       => 1
            ]);
            $vinculacion->save();

            return response()->json(["success" => true]);
        } else {
            return response()->json(["success" => false]);
        }
    }

    public function ValidarLlamadaContratacion($destino, $mensaje)

    {
        $url_audio  = route('home') . "/configuracion_sitio/audio_contratacion.wav";
        //$quitar_seguridad_url = str_replace("https://", "http://", $url_audio);

        $url = 'https://cloud.go4clients.com:8580/api/campaigns/voice/v1.0/'.env('GO4CLIENTS_LLAMADA', '5c939f6ecd51a70007786dad');

        $data=array(
            "destinationsList" => explode(",", $destino),
            "stepList" => array(
                [
                    "id" => "1",
                    "rootStep" => true,
                    "nextStepId" => "2",
                    "stepType" => "CALL"
                ],
                [
                    "id" => "2",
                    "rootStep" => false,
                    "stepType" => "PLAY_AUDIO_URL_WITH_DTMF",
                    "useUrl" => true,
                    "url" => $url_audio,
                    "retryStepId" => "2",
                    "maxNumberOfRetry" => "3",
                    "numberOfDigits" => 1,
                     "digitTimeoutInSeconds" => 8,
                    "dtmfOption" => array(
                        [
                            "option" => "1",
                            "value" => "3"
                        ],
                        [
                            "option" => "2",
                            "value" => "4"
                        ]
                    )
                ],
                [
                    "id" => "3",
                    "rootStep" => false,
                    "nextStepId" => "5",
                    "text" => "hola.< Velocidad = 70 />   ".$mensaje . "< Velocidad = FIN_70 />< Velocidad = 80 /> enviaremos la información de la contratacion a través de un mensaje de texto. Gracias!.< Velocidad = FIN_80 />     hola.   < Velocidad = 70 />" . $mensaje . "   < Velocidad = FIN_70 />< Velocidad = FIN_80 />enviaremos la información de la contratación a través de un mensaje de texto. Gracias!< Velocidad = FIN_80 />",
                    "voice" => "CLAUDIA",
                    "speed" => 80,
                    "stepType" => "SAY"
                ],
                [
                    "id" => "4",
                    "rootStep" => false,
                    "nextStepId" => "5",
                    "text" => "Muchas gracias por haber atendido nuestra llamada, que pase un buen dia.",
                    "voice" => "CLAUDIA",
                    "speed" => 80,
                    "stepType" => "SAY"
                ],
                [
                    "id" => "5",
                    "rootStep" => false,
                    "stepType" => "HANGUP"
                ]
            )
        );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data),
                'header'  => array("Content-Type: application/json", "apiKey: fbfc74edc94c4377a6be329924b65e20", "apiSecret: 5331739984726387"),
            ),
        );

        $context  = stream_context_create($options);
        $result   = file_get_contents($url, false, $context);
        $response = json_decode($result);
    }

    public function ValidarLlamada($destino, $mensaje)
    {
        $url_audio  = route('home') . "/configuracion_sitio/audio.wav";

        //$quitar_seguridad_url = str_replace("https://", "http://", $url_audio);

        $url = 'https://cloud.go4clients.com:8580/api/campaigns/voice/v1.0/'.config('conf_aplicacion.VARIABLES_ENTORNO.GO4CLIENTS.llamadas');

        if(route("home") == "https://gpc.t3rsc.co") {
            $url_audio2  = route('home') . "/configuracion_sitio/audio2.wav";

            $data = array(
                "destinationsList" => explode(",", $destino),
                "stepList" => array(
                    [
                        "id" => "1",
                        "rootStep" => true,
                        "nextStepId" => "2",
                        "stepType" => "CALL"
                    ],
                    [
                        "id" => "2",
                        "rootStep" => false,
                        "stepType" => "PLAY_AUDIO_URL_WITH_DTMF",
                        "useUrl" => true,
                        "url" => $url_audio,
                        "retryStepId" => "2",
                        "maxNumberOfRetry" => "3",
                        "numberOfDigits" => 1,
                        "digitTimeoutInSeconds" => 8,
                        "dtmfOption" => array(
                            [
                                "option" => "1",
                                "value" => "3"
                            ],
                            [
                                "option" => "2",
                                "value" => "4"
                            ]
                        )
                    ],
                    [
                        "id" => "3",
                        "rootStep" => false,
                        "nextStepId" => "5",
                        "text" => "hola.< Velocidad = 70 />   ".$mensaje . "< Velocidad = FIN_70 />< Velocidad = 80 />.Enviaremos la información de la vacante a través de un mensaje de texto. Gracias!.< Velocidad = FIN_80 />     hola.   < Velocidad = 70 />" . $mensaje . "   < Velocidad = FIN_70 />< Velocidad = FIN_80 />enviaremos la información de la vacante a través de un mensaje de texto. Gracias!< Velocidad = FIN_80 />",
                        "voice" => "CLAUDIA",
                        "speed" => 80,
                        "stepType" => "SAY_WITH_DTMF",
                        "dtmfOption" => array([
                            "option"=>"2",
                            "value"=>"4"
                        ])
                    ],
                    [
                        "id" => "4",
                        "rootStep" => false,
                        "nextStepId" => "5",
                        "stepType" => "PLAY_AUDIO_URL",
                        "useUrl" => true,
                        "url" => $url_audio2
                    ],
                    [
                        "id" => "5",
                        "rootStep" => false,
                        "stepType" => "HANGUP"
                    ]
                )
            );
        }elseif(route("home")=="https://listos.t3rsc.co") {
            $data = array(
                "destinationsList" => explode(",", $destino),
                "stepList" => array(
                    [
                        "id" => "1",
                        "rootStep" => true,
                        "nextStepId" => "2",
                        "stepType" => "CALL"
                    ],
                    [
                        "id" => "2",
                        "rootStep" => false,
                        "stepType" => "PLAY_AUDIO_URL",
                        "useUrl" => true,
                        "nextStepId" => "3",
                        "url"=> $url_audio,
                        "digitTimeoutInSeconds" => 8
                    ],
                    [
                        "id" => "3",
                        "rootStep" => false,
                        "nextStepId" => "5",
                        "text" => "hola.< Velocidad = 70 />   ".$mensaje . "< Velocidad = FIN_70 />< Velocidad = 80 /> enviaremos la información de la vacante a través de un mensaje de texto. Gracias!.< Velocidad = FIN_80 />     hola.   < Velocidad = 70 />" . $mensaje . "   < Velocidad = FIN_70 />< Velocidad = FIN_80 />enviaremos la información de la vacante a través de un mensaje de texto. Gracias!< Velocidad = FIN_80 />",
                        "voice" => "CLAUDIA",
                        "speed" => 80,
                        "stepType" => "SAY"
                    ],
                    [
                        "id" => "4",
                        "rootStep" => false,
                        "nextStepId" => "5",
                        "text" => "Muchas gracias por haber atendido nuestra llamada, que pase un buen dia.",
                        "voice" => "CLAUDIA",
                        "speed" => 80,
                        "stepType" => "SAY"
                    ],
                    [
                        "id" => "5",
                        "rootStep" => false,
                        "stepType" => "HANGUP"
                    ]
                )
            );
        }else {
            $data = array(
                "destinationsList" => explode(",", $destino),
                "stepList" => array(
                    [
                        "id" => "1",
                        "rootStep" => true,
                        "nextStepId" => "2",
                        "stepType" => "CALL"
                    ],
                    [
                        "id" => "2",
                        "rootStep" => false,
                        "stepType" => "PLAY_AUDIO_URL_WITH_DTMF",
                        "useUrl" => true,
                        "url"=> $url_audio,
                        "retryStepId" => "2",
                        "maxNumberOfRetry" => "3",
                        "numberOfDigits" => 1,
                         "digitTimeoutInSeconds" => 8,
                        "dtmfOption" => array(
                            [
                                "option" => "1",
                                "value" => "3"
                            ],
                            [
                                "option" => "2",
                                "value" => "4"
                            ]
                        )
                    ],
                    [
                        "id" => "3",
                        "rootStep" => false,
                        "nextStepId" => "5",
                        "text" => "hola.< Velocidad = 70 />   ".$mensaje . "< Velocidad = FIN_70 />< Velocidad = 80 />. Enviaremos la información de la vacante a través de un mensaje de texto. Gracias!.< Velocidad = FIN_80 />     hola.   < Velocidad = 70 />" . $mensaje . "   < Velocidad = FIN_70 />< Velocidad = FIN_80 />. Enviaremos la información de la vacante a través de un mensaje de texto. Gracias!.< Velocidad = FIN_80 />",
                        "voice" => "CLAUDIA",
                        "speed" => 80,
                        "stepType" => "SAY"
                    ],
                    [
                        "id" => "4",
                        "rootStep" => false,
                        "nextStepId" => "5",
                        "text" => "Muchas gracias por haber atendido nuestra llamada, que pase un buen dia.",
                        "voice" => "CLAUDIA",
                        "speed" => 80,
                        "stepType" => "SAY"
                    ],
                    [
                        "id" => "5",
                        "rootStep" => false,
                        "stepType" => "HANGUP"
                    ]
                )
            );
        }



        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data,JSON_UNESCAPED_SLASHES),
                'header'  => array("Content-Type: application/json", "apiKey:". config('conf_aplicacion.VARIABLES_ENTORNO.GO4CLIENTS.apiKey'), "apiSecret:". config('conf_aplicacion.VARIABLES_ENTORNO.GO4CLIENTS.apiKey')),
            ),
        );

        $context  = stream_context_create($options);
        $result   = file_get_contents($url, false, $context);
        $response = json_decode($result);
    }

    //Asistente virtual
    public function llamada_virtual(Request $data)
    {
        $this->validate($data, [
            'candidatos_llamar' => 'required',
        ]);

        $modulo = $data->get("modulo");

        $req_cand = $data->get("candidatos_llamar");
        $req_id = $data->get("req_id");

        $explo = explode(' ', $this->user->name);
        $name = $explo[0];

        //para tiempos
        $gestiona  = str_replace(array("á","é","í","ó","ú","ñ"), array("a","e","i","o","u","n"), $name);

        $nombres = [];
        $numeros = [];
        $req_ids = [];

        $todos = "";

        if(isset($data->seleccionar_todos_candidatos_vinculados)) {
            $nombres_candidatos = DB::table("requerimiento_cantidato")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.requerimiento_id", $req_id)
            ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
            ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
            ->select('datos_basicos.nombres', 'datos_basicos.telefono_movil')
            ->get();

            foreach($nombres_candidatos as $candidato) {
                array_push($nombres, $candidato->nombres);
                array_push($numeros, env("INDICATIVO", "57").$candidato->telefono_movil);
            }
        }else {
            foreach ($req_cand as $key => $value) {
                //$num                = substr($value, 2);
                $nombres_candidatos = DB::table("requerimiento_cantidato")
                ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->where("requerimiento_cantidato.id", $value)
                ->select('datos_basicos.nombres', 'datos_basicos.telefono_movil', 'requerimiento_cantidato.requerimiento_id')
                ->first();

                $index = env("INDICATIVO","57").$nombres_candidatos->telefono_movil;
                $req_ids["$index"] = $nombres_candidatos->requerimiento_id;
                array_push($nombres, $nombres_candidatos->nombres);
                array_push($numeros, env("INDICATIVO","57").$nombres_candidatos->telefono_movil);
            }
        }

        //para tiempos
        $cliente = Requerimiento::join("negocio","negocio_id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->where("requerimientos.id", $req_id)
        ->select(
            "clientes.nombre as nombre_cliente",
            "clientes.direccion as direccion_cliente",
            "clientes.contacto as contacto_cliente"
        )
        ->first();

        $nombres = implode(",", $nombres);
        $numeros = implode(",", $numeros);
        $req_ids = json_encode($req_ids);

        $cliente->contacto_cliente = str_replace(array("á", "é", "í", "ó", "ú", "ñ"), array("a", "e", "i", "o", "u", "n"), $cliente->contacto_cliente);

        $valor = null;

        if($modulo == "contratacion"){
            $valor = "Buen día. Bienvenid@ a nuestro proceso de contratación. Para dar inicio solicitamos se presente en la dirección y horario especificado:";
        }

        /**
         * Revisar si hay citas
         */

        $asistente_cita = AsistenteCita::where('gestion_id', $this->user->id)->orderBy('id', 'DESC')->first();
        $horario_ocupado = [];

        if(!empty($asistente_cita)) {
            $estado_req = EstadosRequerimientos::where('req_id', $asistente_cita->req_id)->orderBy('id', 'DESC')->first();

            $estados_terminados = array(3, 16, 19);

            // Validar si el req anterior esta terminado para no validar las horas
            if (!in_array($estado_req->estado, $estados_terminados)) {
                $hora_inicio = explode(":", $asistente_cita->hora_inicio);
                $hora_fin = explode(":", $asistente_cita->hora_fin);

                for ($i= $hora_inicio[0]; $i <= $hora_fin[0]; $i++) { 
                    array_push($horario_ocupado, (int) $i);
                }
            }
        }

        return view("admin.reclutamiento.llamada_virtual", compact(
            'numeros',
            'req_id',
            'nombres',
            'cliente',
            'req_ids',
            'gestiona',
            "modulo",
            "valor",
            "horario_ocupado"
        ))->with("mensaje_success", "Se ha enviado la llamada con éxito.");
    }

    //Realizar llamada
    public function post_llamada_virtual(Request $data)
    {
        $sitio = Sitio::first();

        //Para el agendamiento
        $tipo_cita = $data->tipo_cita;

        //Validar tipo cita
        if ($tipo_cita == 'with') {
            $this->validate($data, [
                'asunto_cita' => 'required',
                'fecha_cita' => 'required',
                'hora_inicio' => 'required',
                'hora_fin' => 'required',
                'duracion_cita' => 'required',
                'mensaje' => 'required|max:1024',
                'numeros' => 'required',
            ]);
        }else {
            $this->validate($data, [
                'mensaje' => 'required|max:1024',
                'numeros' => 'required',
            ]);
        }

        $modulo = $data->get("modulo");

        if($modulo == "seleccion") {
            $modulo_id = 1;
        }else {
            $modulo_id = 2;
        }

        if(!$data->has("solo_correo")) {
            //La funcionalidad es Llamada mensaje - Obtiene el tipo de funcionalidad y su limite.
            $ControlLimite = ControlFuncionalidad::join('tipo_funcionalidad_avanzada', 'tipo_funcionalidad_avanzada.id', '=', 'control_funcionalidad.tipo_funcionalidad')
            ->where('control_funcionalidad.tipo_funcionalidad', 4)
            ->select(
                'control_funcionalidad.*',
                'control_funcionalidad.id as id_control',
                'tipo_funcionalidad_avanzada.*'
            )
            ->first();

            //Obtiene el mes actual.
            $mes = date("n");

            //Obtiene el número de registros de acuerdo a la funcionalidad y el mes.
            $TrazabilidadConteo = TrazabilidadFuncionalidad::join('control_funcionalidad', 'control_funcionalidad.id', '=', 'trazabilidad_funcionalidades.control_id')
            ->where('control_funcionalidad.tipo_funcionalidad', 4)
            ->whereMonth('trazabilidad_funcionalidades.created_at', '=', $mes)
            ->count();

            if($TrazabilidadConteo == $ControlLimite->limite){
                return redirect()->back()->with('mensaje_limite', 'HAS LLEGADO A TU LIMITE MENSUAL DE ESTA FUNCIONALIDAD.');
            }elseif($TrazabilidadConteo >= $ControlLimite->limite){
                return redirect()->back()->with('mensaje_limite', 'HAS LLEGADO A TU LIMITE MENSUAL DE ESTA FUNCIONALIDAD.');
            }else{
                $destino = $data->get('numeros');
                $req_id  = $data->get('req_id');
                $mensaje = $data->get('mensaje');
                $req_ids = json_decode($data->req_ids, true);

                if($modulo == "contratacion") {
                    $this->ValidarLlamadaContratacion($destino, $mensaje);
                }else {
                    $this->ValidarLlamada($destino, $mensaje);
                }

                $destino = explode(",", $destino);

                //Valida el tipo de cita
                switch($tipo_cita) {
                    case 'with':
                        if (isset($data->req_id) && $data->req_id != '') {
                            //Crea el registro de cita
                            $nuevo_asistente_cita = new AsistenteCita();

                            $nuevo_asistente_cita->fill([
                                'req_id'        => $data->req_id,
                                'gestion_id'    => $this->user->id,
                                'asunto_cita'   => $data->asunto_cita,
                                'fecha_cita'    => $data->fecha_cita,
                                'hora_inicio'   => $data->hora_inicio,
                                'hora_fin'      => $data->hora_fin,
                                'duracion_cita' => $data->duracion_cita
                            ]);
                            $nuevo_asistente_cita->save();
                        } elseif (count($req_ids) > 0) {
                            $req_agregado = [];
                            foreach ($req_ids as $id_req) {
                                if (in_array($id_req, $req_agregado)) {
                                    $req_agregado[] = $id_req;
                                    //Crea el registro de cita
                                    $nuevo_asistente_cita = new AsistenteCita();

                                    $nuevo_asistente_cita->fill([
                                        'req_id'        => $id_req,
                                        'gestion_id'    => $this->user->id,
                                        'asunto_cita'   => $data->asunto_cita,
                                        'fecha_cita'    => $data->fecha_cita,
                                        'hora_inicio'   => $data->hora_inicio,
                                        'hora_fin'      => $data->hora_fin,
                                        'duracion_cita' => $data->duracion_cita
                                    ]);
                                    $nuevo_asistente_cita->save();
                                }
                            }
                        }
                        break;
                    default:
                        // nothing
                        break;
                }

                //Recorrer los números de celular para gestionar proceso
                foreach($destino as $des) {
                    if($modulo != "seleccion") {
                        $req_id = $req_ids[$des];
                    }

                    if(env("INDICATIVO") != null) {
                        $num = substr($des, strlen(env("INDICATIVO")));
                    }else {
                        $num = substr($des, 2);
                    }

                    $nombres_candidatos = DB::table("requerimiento_cantidato")
                    ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                    ->select(
                        'datos_basicos.user_id as user_id',
                        'datos_basicos.telefono_movil',
                        'datos_basicos.nombres',
                        'datos_basicos.numero_id',
                        'datos_basicos.email as email_candidato',
                        'datos_basicos.primer_apellido as primer_apellido',
                        'datos_basicos.segundo_apellido as segundo_apellido'
                    )
                    ->where("datos_basicos.telefono_movil", $num)
                    ->first();

                    //Guarda mensajes
                    for ($i = 0; $i < $data->get('mensaje_enviar'); $i++) {
                        TrazabilidadFuncionalidad::create([
                            'control_id'         => $ControlLimite->id_control,
                            'tipo_funcionalidad' => 4,
                            'user_gestion'       => Sentinel::getUser()->id,
                            'req_id'             => $req_id,
                            'empresa'            => '',
                            'descripcion'        => 'LLAMADA Y MENSAJE VIRTUAL',
                        ]);
                    }

                    //Guarda las llamadas
                    $nueva_llamada_mensaje                   = new LlamadaMensaje();

                    $nueva_llamada_mensaje->req_id           = $req_id;
                    $nueva_llamada_mensaje->nombre_candidato = $nombres_candidatos->nombres;
                    $nueva_llamada_mensaje->telefono_movil   = $nombres_candidatos->telefono_movil;
                    $nueva_llamada_mensaje->numero_id        = $nombres_candidatos->numero_id;
                    $nueva_llamada_mensaje->num_msg          = $data->get('mensaje_enviar');
                    $nueva_llamada_mensaje->content_msg      = $mensaje;
                    $nueva_llamada_mensaje->user_llamada     = $this->user->id;
                    $nueva_llamada_mensaje->modulo           = $modulo_id;
                    $nueva_llamada_mensaje->save();

                    //Valida el tipo de cita
                    switch ($tipo_cita) {
                        case 'with':
                            //Crea el agendamiento de candidato
                            $nuevo_agendamiento_candidato = new AsistenteCitaAgendamientoCandidato();

                            $nuevo_agendamiento_candidato->fill([
                                'req_id'            => $req_id,
                                'cita_id'           => $nuevo_asistente_cita->id,
                                'user_id'           => $nombres_candidatos->user_id
                            ]);
                            $nuevo_agendamiento_candidato->save();

                            //Crea proceso de entrevista
                            $proceso = "ENVIO_ENTREVISTA";

                            $candidato_req = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                            ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                            ->where("requerimiento_cantidato.requerimiento_id", $req_id)
                            ->where("requerimiento_cantidato.candidato_id", $nombres_candidatos->user_id)
                            ->whereNotIn('requerimiento_cantidato.estado_candidato', [
                                config('conf_aplicacion.C_QUITAR'),
                                config('conf_aplicacion.C_INACTIVO')
                            ])
                            ->whereRaw('requerimiento_cantidato.id=(select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.requerimiento_id=requerimientos.id and requerimiento_cantidato.candidato_id=datos_basicos.user_id)')
                            ->select(
                                "requerimiento_cantidato.id as req_candidato_id"
                            )
                            ->orderBy("requerimiento_cantidato.id")
                            ->groupBy('datos_basicos.numero_id')
                            ->first();

                            $campos_proceso = [
                                'requerimiento_candidato_id' => $candidato_req->req_candidato_id,
                                'usuario_envio'              => $this->user->id,
                                "fecha_inicio"               => date("Y-m-d H:i:s"),
                                'proceso'                    => $proceso,
                            ];

                            $this->RegistroProceso(
                                $campos_proceso,
                                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                                $candidato_req->req_candidato_id
                            );
                            break;
                        default:
                            // nothing
                            break;
                    }

                    //$url_email = route('home.detalle_oferta', ['oferta_id' => $req_id]);

                    $url_email = route('home.detalle_oferta_mensaje', [
                        'oferta_id' => $req_id, 'numero_id' => $nombres_candidatos->numero_id, 'llamada_id' => $nueva_llamada_mensaje->id
                    ]);

                    $analista = User::find($this->user->id);

                    // Usar administrador de correos

                        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                        $mailConfiguration = 1; //Id de la configuración
                        $mailTitle = "Asistente virtual"; //Titulo o tema del correo
                        
                        //Cuerpo con html y comillas dobles
                        $mailBody = "
                            Hola $nombres_candidatos->nombres, te informamos que nuestro analista de selección <b>$analista->name</b> te ha enviado un mensaje: <br>
                            <i>$mensaje</i>
                        ";

                        //Validar el tipo de cita para asignar bóton
                        switch ($tipo_cita) {
                            case 'with':
                                $mailButton = ['buttonText' => 'Aceptar y reservar horario', 'buttonRoute' => route('login', ['scheduling' => 'true']) ];
                                break;
                            case 'without';
                                $mailButton = ['buttonText' => 'Detalle oferta', 'buttonRoute' => $url_email];
                                break;
                            default:
                                $mailButton = ['buttonText' => 'Detalle oferta', 'buttonRoute' => $url_email];
                                break;
                        }

                        $mailUser = $nombres_candidatos->user_id; //Id del usuario al que se le envía el correo

                        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                        //Enviar correo generado
                        Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($nombres_candidatos, $sitio) {
                            $message->to([$nombres_candidatos->email_candidato], 'T3RS')
                            ->bcc($sitio->email_replica)
                            ->subject("Citación virtual")
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                            //->getHeaders();
                            //->addTextHeader('requerimiento',$req_id);
                        });
                    // Fin administrador correos

                    //Recortar nombre
                    $nombre = explode(" ", $nombres_candidatos->nombres);

                    //Llama función envío de mensaje
                    $this->ValidarSMS(
                        $des,
                        $mensaje,
                        $req_id,
                        $nombre[0],
                        $nombres_candidatos->numero_id,
                        $nueva_llamada_mensaje->id,
                        $modulo,
                        $tipo_cita
                    );
                }

                if($modulo == "seleccion") {
                    $ruta = "admin/gestion-requerimiento/".$req_id;
                }else {
                    $ruta = "admin/asistente-contratacion";
                }

                //redirige a la gestion de ese requerimiento
                return redirect($ruta)->with("mensaje_success", "Se ha enviado la llamada con éxito.");
            }
        }else {

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Asistente virtual"; //Titulo o tema del correo

            $destino = $data->get('numeros');
            $req_id  = $data->get('req_id');
            $mensaje = $data->get('mensaje');

            $destino = explode(",", $destino);

            //Para el agendamiento
            $tipo_cita = $data->tipo_cita;

            foreach($destino as $des) {
                if(env("INDICATIVO") != null) {
                    $num = substr($des, strlen(env("INDICATIVO")));
                }else {
                    $num = substr($des, 2);
                }

                $nombres_candidatos = DB::table("requerimiento_cantidato")
                ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->select(
                    'datos_basicos.user_id as user_id',
                    'datos_basicos.telefono_movil',
                    'datos_basicos.nombres',
                    'datos_basicos.numero_id',
                    'datos_basicos.email as email_candidato',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido'
                )
                ->where("datos_basicos.telefono_movil", $num)
                ->first();

                $url_email = route('home.detalle_oferta', ['oferta_id' => $req_id]);

                $analista = User::find($this->user->id);

                // Usar administrador de correos

                    $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                    $mailConfiguration = 1; //Id de la configuración
                    $mailTitle = "Asistente virtual"; //Titulo o tema del correo
                    
                    //Cuerpo con html y comillas dobles
                    $mailBody = "
                        Hola $nombres_candidatos->nombres, te informamos que nuestro analista de selección <b>$analista->name</b> te ha enviado un mensaje: <br>
                        <i>$mensaje</i>
                    ";

                    //Validar el tipo de cita para asignar bóton
                    switch ($tipo_cita) {
                        case 'with':
                            $mailButton = ['buttonText' => 'Aceptar y reservar horario', 'buttonRoute' => route('login', ['scheduling' => 'true']) ];
                            break;
                        case 'without';
                            $mailButton = ['buttonText' => 'Detalle oferta', 'buttonRoute' => $url_email];
                            break;
                        default:
                            $mailButton = ['buttonText' => 'Detalle oferta', 'buttonRoute' => $url_email];
                            break;
                    }

                    $mailUser = $nombres_candidatos->user_id; //Id del usuario al que se le envía el correo

                    $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                    //Enviar correo generado
                    Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($nombres_candidatos) {
                        $message->to([$nombres_candidatos->email_candidato], 'T3RS')
                        ->subject("Citación virtual")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                        //->getHeaders()
                        //->addTextHeader('requerimiento',$req_id);
                    });
                // Fin administrador correos
            }

            if($modulo == "seleccion") {
                $ruta = "admin/gestion-requerimiento/".$req_id;
            }else {
                $ruta = "admin/asistente-contratacion";
            }

            //redirige a la gestion de ese requerimiento
            return redirect($ruta)->with("mensaje_success", "Se ha enviado el correo con éxito");
        }
    }

    public function enviar_sms(Request $data)
    {
        return view("admin.reclutamiento.enviar_sms");
    }

    //Enviar SMS a tráves de la API
    public function ValidarSMS($destino, $mensaje, $req_id, $nombres, $numero_id, $llamada_id, $modulo = "seleccion", string $tipoCita = 'without')
    {
        if($modulo == "contratacion"){
            $urls = route('admin.carga_archivos_contratacion');
        }else{
            //Valida el tipo de cita
            switch ($tipoCita) {
                case 'with':
                    //Con agendamiento
                    //$urls = route('mis_ofertas');
                    $urls = route('login', ['scheduling' => 'true']);
                    //$urls = 'https://desarrollo.t3rsc.co/cv/login?scheduling=true';
                    break;
                case 'without':
                    //Sin agendamiento
                    $urls = route('home.detalle_oferta_mensaje', ['oferta_id' => $req_id, 'numero_id' => $numero_id, 'llamada_id' => $llamada_id]);
                    break;
                default:
                    $urls = route('home.detalle_oferta_mensaje', ['oferta_id' => $req_id, 'numero_id' => $numero_id, 'llamada_id' => $llamada_id]);
                    break;
            }
        }
        
        $url = 'https://cloud.go4clients.com:8580/api/campaigns/sms/v1.0/'.config('conf_aplicacion.VARIABLES_ENTORNO.GO4CLIENTS.sms');
        
        //Acortar URL
        $url_oferta = Bitly::getUrl($urls);


        $data = array(
            'destinationsList' => [$destino],
            "priority" => "HIGH",
            'message' => "Hola " . $nombres . ", " . $mensaje . " " . $url_oferta,
        );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data),
                'header'  => array("Content-Type: application/json", "apiKey:".config('conf_aplicacion.VARIABLES_ENTORNO.GO4CLIENTS.apiKey'), "apiSecret:".config('conf_aplicacion.VARIABLES_ENTORNO.GO4CLIENTS.apiSecret')),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        $response = json_decode($result);

        //Envío de whatsapp
        event(new \App\Events\NotificationWhatsappEvent("message",[
            "phone"=>$destino,
            "body"=> $data["message"]
        ]));
    }

    public function ValidarSMSContratacion($destino, $mensaje, $req_id, $nombres,$numero_id,$llamada_id)
    {

        $url = 'https://cloud.go4clients.com:8580/api/campaigns/sms/v1.0/'.config('conf_aplicacion.VARIABLES_ENTORNO.GO4CLIENTS.sms');
        $urls = route('home.detalle_oferta_mensaje', ['oferta_id' => $req_id,'numero_id'=>$numero_id,'llamada_id'=>$llamada_id]);

        $url_oferta = Bitly::getUrl($urls);

        $data = array(
            'destinationsList'=>[$destino],
            "priority"=>"HIGH",
            'message' => "Hola " . $nombres . ", " . $mensaje . " " . $url_oferta,
        );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data),
                'header'  => array("Content-Type: application/json", "apiKey:".config('conf_aplicacion.VARIABLES_ENTORNO.GO4CLIENTS.apiKey'), "apiSecret:".config('conf_aplicacion.VARIABLES_ENTORNO.GO4CLIENTS.apiSecret')),
            ),
        );
       
        $context  = stream_context_create($options);
        $result   = file_get_contents($url, false, $context);

        $response = json_decode($result);

        event(new \App\Events\NotificationWhatsappEvent("message",[
            "phone"=>$destino,
            "body"=> $data["message"]
        ]));
    }

    public function ValidarSMSApto($destino,$mensaje,$req_id,$nombres)
    {
        $url =  'https://cloud.go4clients.com:8580/api/campaigns/sms/v1.0/'.env('GO4CLIENTS_TEXTO', '5d72b724d9fc690007777d19');

        $urls = route('home.detalle_oferta', ['oferta_id' => $req_id]);
        //dd($urls);

        $url_oferta = Bitly::getUrl($urls);

        $data = array(
            'destinationsList'=>["57".$destino],
            "priority"=>"HIGH",

            'message' => "Hola " . $nombres . ", " . $mensaje . " " . $url_oferta ,
        );

         $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data),
                'header'  => array("Content-Type: application/json", "apiKey: fbfc74edc94c4377a6be329924b65e20", "apiSecret: 5331739984726387"),
            ),
        );
       
        $context  = stream_context_create($options);
        $result   = file_get_contents($url, false, $context);

        $response = json_decode($result);
    }

    public function post_enviar_sms(Request $data)
    {
        $this->validate($data, [
            'mensaje' => 'required|max:255',
            'numero'  => 'required|numeric',
        ]);

        $destino = $data->get('numero');
        $mensaje = $data->get('mensaje');

        $this->ValidarSMS($destino, $mensaje);

        return redirect()->route("admin.reclutamiento")->with("mensaje_success", "Se ha enviado el mensaje con éxito");

    }

    /**
     * Construir el email a enviar con los datos del candidado seleccionado
     **/
    public function construir_email_candidato_vinculado(Request $data){
        $id_candidato = $data->id_candidato;
        //Consultar datos del candidato con el ID
        $datos = DatosBasicos::where("numero_id", $id_candidato)->first();

        return response()->json(["success" => true, "view" => view("admin.reclutamiento.modal.enviar_email_candidato_vinculado", compact("datos"))->render()]);
    }

    /**
     * Enviar email con los datos del candidato seleccionado y los datos ingresados
     **/
    public function enviar_email_candidato_vinculado(Request $data){
        $emails = $data->email;
        $asunto = $data->asunto;
        $mensaje = $data->mensaje;

        $funcionesGlobales = new FuncionesGlobales();
        if (isset($funcionesGlobales->sitio()->nombre)) {
            if ($funcionesGlobales->sitio()->nombre != "") {
                $nombre = $funcionesGlobales->sitio()->nombre;
            } else {
                $nombre = "Desarrollo";
            }
        }else{
            $nombre = "Desarrollo";
        }

        $candidato = DatosBasicos::where('user_id', $data->user_id)->first();

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = ""; //Titulo o tema del correo

        $mailBody = "
            Hola {$candidato->nombres} {$candidato->primer_apellido} {$candidato->segundo_apellido}, 
            <br/><br/>
            Te informamos que el analista quien está llevando a cabo tu proceso de selección tiene un mensaje para ti: 
            <br/><br/>
             {$mensaje}
                    ";

        //Arreglo para el botón
        $mailButton = [];

        $mailUser = $candidato->user_id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($asunto, $emails, $nombre) {

                    $message->to($emails, "$nombre - T3RS")
                    ->subject($asunto)
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

        return response()->json(["success" => true]);
    }

    //
    //Nuevos metodos para la nueva vista
    //
    public function lista_carga_scanner_fr(Request $data){

        $requerimientos = ["" => "seleccionar"] + Requerimiento::whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado in( " . config('conf_aplicacion.C_TERMINADO') . "," . config('conf_aplicacion.C_SOLUCIONES') . "," . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . "))"))->pluck("id", "id")->toArray();

        $fuentesRec = ["" => "Seleccionar"] + TipoFuentes::pluck("descripcion", "id")->toArray();

        $epsSelect = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->pluck("descripcion", "id")->toArray();

        $personas_scanner = CargaScanner::join('users', 'users.id', '=', 'carga_scanner.user_carga')
            ->join('datos_basicos', 'datos_basicos.user_id', '=', 'users.id')
            ->leftjoin('tipo_fuente', 'tipo_fuente.id','=','carga_scanner.fuente_recl')
            ->leftjoin('entidades_eps', 'entidades_eps.id','=','carga_scanner.entidad_eps')
            ->select(
                'tipo_fuente.descripcion as fuente_desc',
                'entidades_eps.descripcion as eps_desc',
                'carga_scanner.*',
                DB::raw('date_format(carga_scanner.fecha_nacimiento,"%Y/%m/%d")as fecha'),
                DB::raw('round(datediff(now(),carga_scanner.fecha_nacimiento)/365) as edad')
            )
            ->orderBy('carga_scanner.created_at', 'desc')
            ->paginate(6);

            //dd($personas_scanner);

        return view("admin.reclutamiento.lista_carga_scanner_fr", compact("personas_scanner", "requerimientos", "fuentesRec", "epsSelect"));

    }

    public function guardar_carga_scanner_fr(Request $data){

        $rules = [
            'identificacion'   => 'required',
            'primer_nombre'    => 'required',
            'primer_apellido'  => 'required',
            'genero'           => 'required',
            'rh'               => 'required',
            'fecha_nacimiento' => 'required',
            'fuente_recl'      => 'required',
            'eps_select'       => 'required',
            'num_emergencia'   => 'required',
            'email'            => 'required',
            'telefono'         => 'required',
        ];

        $valida = Validator::make($data->all(), $rules);
        
        if ($valida->fails()) {
            return redirect()->back()->withErrors($valida)->withInput();
        }

        $identificacion = trim($data->get('identificacion'));

        $cc = (string) $identificacion;

        if($cc[0] == 0 && $cc[1] == 0){ $cc = str_replace("00","",$cc); }

        $cedula = DatosBasicos::where("numero_id", $cc)->first();
        
        $candidato_req = User::where("numero_id", $cc)
        ->leftjoin('requerimiento_cantidato','requerimiento_cantidato.candidato_id','=','users.id')
        ->select('requerimiento_cantidato.requerimiento_id')
        ->first();

        if($cedula != ""){

            $cedula = User::where("numero_id", $cc)->first();

            $usuario = DatosBasicos::where('numero_id', $cedula->numero_id)->first();

            $usuario->grupo_sanguineo = $data->get('rh');
            $usuario->nombres = $data->get('primer_nombre') . " " . $data->get('segundo_nombre');
            $usuario->primer_apellido = $data->get('primer_apellido');
    

            $usuario->save();

            $u_id = $usuario->user_id;

            if ($candidato_req->requerimiento_id == true) {

                $buscaCarga = CargaScanner::where('identificacion', $cedula->numero_id)->first();

                if($buscaCarga != ""){
                    
                    $buscaCarga->identificacion = $cc;
                    $buscaCarga->primer_nombre = $data->get('primer_nombre');
                    $buscaCarga->segundo_nombre = $data->get('segundo_nombre');
                    $buscaCarga->primer_apellido = $data->get('primer_apellido');
                    $buscaCarga->segundo_apellido = $data->get('segundo_apellido');
                    $buscaCarga->genero = $data->get('genero');
                    $buscaCarga->fecha_nacimiento = $data->get('fecha_nacimiento');
                    $buscaCarga->fuente_recl = $data->get('fuente_recl');
                    $buscaCarga->entidad_eps = $data->get('eps_select');
                    $buscaCarga->num_emergencia = $data->get('num_emergencia');
                    $buscaCarga->rh = $data->get('rh');
                    $buscaCarga->user_carga = $u_id;
                    $buscaCarga->user_gestion = $this->user->id;
                  
                    $buscaCarga->asistencia = 1;

                    $buscaCarga->update();
                }else{
                    $cargaScanner = new CargaScanner();
                    
                    $cargaScanner->fill(
                        [
                            "identificacion"   => $cc,
                            "primer_nombre"    => $data->get('primer_nombre'),
                            "segundo_nombre"   => $data->get('segundo_nombre'),
                            "primer_apellido"  => $data->get('primer_apellido'),
                            "segundo_apellido" => $data->get('segundo_apellido'),
                            "genero"           => $data->get('genero'),
                            "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                            "fuente_recl"      => $data->get('fuente_recl'),
                            "entidad_eps"      => $data->get('eps_select'),
                            "num_emergencia"   => $data->get('num_emergencia'),
                            "rh"               => $data->get('rh'),
                            "user_carga"       => $u_id,
                            "user_gestion"     => $this->user->id,
                        ]);
                    $cargaScanner->save();
                }

            }else{
                $buscaCarga = CargaScanner::where('identificacion', $cedula->numero_id)->first();

                if($buscaCarga != ""){

                    $buscaCarga->identificacion = $cc;
                    $buscaCarga->primer_nombre = $data->get('primer_nombre');
                    $buscaCarga->segundo_nombre = $data->get('segundo_nombre');
                    $buscaCarga->primer_apellido = $data->get('primer_apellido');
                    $buscaCarga->segundo_apellido = $data->get('segundo_apellido');
                    $buscaCarga->genero = $data->get('genero');
                    $buscaCarga->fecha_nacimiento = $data->get('fecha_nacimiento');
                    $buscaCarga->fuente_recl = $data->get('fuente_recl');
                    $buscaCarga->entidad_eps = $data->get('eps_select');
                    $buscaCarga->num_emergencia = $data->get('num_emergencia');
                    $buscaCarga->rh = $data->get('rh');
                    $buscaCarga->user_carga = $u_id;

                    $buscaCarga->user_gestion = $this->user->id;

                    $buscaCarga->update();
                }else{
                    $cargaScanner = new CargaScanner();
                    
                    $cargaScanner->fill(
                        [
                            "identificacion"   => $cc,
                            "primer_nombre"    => $data->get('primer_nombre'),
                            "segundo_nombre"   => $data->get('segundo_nombre'),
                            "primer_apellido"  => $data->get('primer_apellido'),
                            "segundo_apellido" => $data->get('segundo_apellido'),
                            "genero"           => $data->get('genero'),
                            "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                            "fuente_recl"      => $data->get('fuente_recl'),
                            "entidad_eps"      => $data->get('eps_select'),
                            "num_emergencia"   => $data->get('num_emergencia'),
                            "rh"               => $data->get('rh'),
                            "user_carga"       => $u_id,
                            "user_gestion"     => $this->user->id,
                        ]);
                    $cargaScanner->save();
                }

            }

            return redirect()->route("admin.lista_carga_scanner_fr")->with("mensaje_success", "El usuario ya existe en el sistema");

        }

        //Usuario no existentes los crea en las dos tablas
        $fecha            = Carbon::parse($data->get('fecha_nacimiento'));
        $fecha_nacimiento = $fecha->toDateString();

        $campos_usuario = [
            'name'      => $data->get('primer_nombre') . " " . $data->get('segundo_nombre') . " " . $data->get('primer_apellido') . " " . $data->get('segundo_apellido'),
            'password'  => $cc,
            'numero_id' => $cc,
            'email'     => $data->get('email')
        ];

        $user       = Sentinel::registerAndActivate($campos_usuario);
        $role       = Sentinel::findRoleBySlug('hv');
        $role->users()->attach($user);
        $usuario_id = $user->id;

        if ($data->get('genero') == "M") {
            
            $genero = 1;

        }elseif ($data->get('genero') == "F") {
            
            $genero = 2;

        }

        $datos_basicos = new DatosBasicos();
        $datos_basicos->fill([
            'genero'               => $genero,
            'numero_id'            => $cc,
            'user_id'              => $usuario_id,
            'nombres'              => $data->get('primer_nombre') . " " . $data->get('segundo_nombre'),
            'fecha_nacimiento'     => $fecha_nacimiento,
            'primer_apellido'      => $data->get('primer_apellido'),
            'segundo_apellido'     => $data->get('segundo_apellido'),
            'estado_reclutamiento' => config('conf_aplicacion.C_ACTIVO'),
            'email'                => $data->get('email'),
            'telefono_movil'       =>$data->get('telefono')
          
        ]);
        $datos_basicos->save();


        $cargaScanner = new CargaScanner();
        $cargaScanner->fill(
            [
                "identificacion"   => $cc,
                "primer_nombre"    => $data->get('primer_nombre'),
                "segundo_nombre"   => $data->get('segundo_nombre'),
                "primer_apellido"  => $data->get('primer_apellido'),
                "segundo_apellido" => $data->get('segundo_apellido'),
                "genero"           => $data->get('genero'),
                "fecha_nacimiento" => $data->get('fecha_nacimiento'),
                "fuente_recl"      => $data->get('fuente_recl'),
                "entidad_eps"      => $data->get('eps_select'),
                "num_emergencia"   => $data->get('num_emergencia'),
                "rh"               => $data->get('rh'),
                "user_carga"       => $usuario_id,
                "user_gestion"     => $this->user->id,
            ]);
        $cargaScanner->save();

        return redirect()->route("admin.lista_carga_scanner_fr")->with("mensaje_success", "La persona se ha guardado con éxito");

    }

    private function req_can_x_requerimiento($req){

        $nombres_candidatos = DB::table("requerimiento_cantidato")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->select('datos_basicos.nombres','datos_basicos.telefono_movil')
        ->where("requerimiento_cantidato.requerimiento_id",$req)
        ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
        ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
        ->get();

        return $nombres_candidatos;
    
    }

    public function search_cand_vinculado(Request $data){

        $user_sesion = $this->user;
        $sitio = Sitio::first();

        $search             = $data->get('search');
        $req_id             = $data->get('req_id');
        $cliente_id         = $data->get('cliente_id');
        $boton              = $data->get('boton');
        //$valida_botones     = $data->get('valida_botones');
        //$entrevista_virtual = $data->get('entrevista_virtual');
        //$prueba_idioma      = $data->get('prueba_idioma');
        //$contra_cliente     = $data->get('contra_cliente');

        $contra_cliente = RegistroProceso::select('procesos_candidato_req.*')
        ->where('procesos_candidato_req.proceso', 'ENVIO_CONTRATACION_CLIENTE')
        ->where('procesos_candidato_req.requerimiento_id', $req_id)
        ->orderBy('procesos_candidato_req.id', 'desc')
        ->get();

        $entrevista_virtual = EntrevistaVirtual::where('req_id',$req_id)->get();
        $prueba_idioma = PruebaIdioma::where('req_id',$req_id)->get();

        //Datos de la ficha [Validar botones de requerimientos]
        $ficha = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->where("requerimientos.id", $req_id)
        //->select("requerimientos.cargo_especifico_id", "negocio.cliente_id")
        ->select("*")
        ->first();

        $datos_ficha = Ficha::where("cargo_cliente", $ficha->cargo_especifico_id)
        ->where("cliente_id", $ficha->cliente_id)
        ->select("*")
        ->first();

        if ($datos_ficha !== null) {
            //Busca las opciones de auxiliar de fichas para validar botones
          $valida_botones = AuxiliarFicha::where("ficha_id", $datos_ficha->id)
                                        ->select("*")->get();

        }else{  
          $valida_botones = null;
        }

        $candidatos_req = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join('users','users.id','=','datos_basicos.user_id')
        ->leftjoin('entrevistas_candidatos',function ($sql)
        {
            $sql->on('datos_basicos.user_id','=','entrevistas_candidatos.candidato_id')
            ->on('entrevistas_candidatos.req_id','=','requerimiento_cantidato.requerimiento_id');
        })
        ->leftjoin('llamada_mensaje',function ($sql)
        {
            $sql->on('datos_basicos.numero_id','=','llamada_mensaje.numero_id')
            ->on('llamada_mensaje.req_id','=','requerimiento_cantidato.requerimiento_id');
        })
        ->leftjoin('asistencia','asistencia.llamada_id','=','llamada_mensaje.id')
        ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
        ->where("requerimiento_cantidato.requerimiento_id", $data->get('req_id'))
        ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
        ->where(function ($sql) use ($data) {
            if ($data->get("search") != "") {
                $sql->where("datos_basicos.numero_id", "LIKE", $data->get("search")."%");
            }
        })
        ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
        ->select("entrevistas_candidatos.asistio as asistio","llamada_mensaje.id as llamada_id","asistencia.asistencia as asis","users.video_perfil as video","requerimiento_cantidato.candidato_id as candidato_id", "requerimiento_cantidato.requerimiento_id as req_id", "datos_basicos.*","datos_basicos.id as datos_basicos_id", "estados.descripcion as estado_candidatos", "requerimiento_cantidato.id as req_candidato_id","datos_basicos.trabaja as trabaja","requerimiento_cantidato.id")
        ->groupBy('datos_basicos.numero_id')
        ->orderBy("requerimiento_cantidato.id","DESC")
        ->get();

        if(count($candidatos_req) == 0){

            $output = '<tr> <td colspan="6"> No hay candidatos asociados a este requerimiento con la cc ingresada </td> </tr>';

            return response()->json(["success" => true, "view" => $output]);

        }else{

            return response()->json(["success" => true, "view" => view("admin.reclutamiento.candidato_buscado", compact("candidatos_req", "user_sesion", "search", "req_id", "cliente_id", "boton", "valida_botones", "entrevista_virtual", "prueba_idioma", "contra_cliente", "sitio"))->render()]);

        }

    }

    public function verifica_cita_cliente(Request $data)
    {
        $cita = Citacion::where('req_candi_id', $data->get('candidato_req'))
        ->where('estado', 0)->where('motivo_id', 13)
        ->first();

        if(count($cita) > 0){
            $userData = ReqCandidato::join('datos_basicos', 'datos_basicos.user_id', '=', 'requerimiento_cantidato.candidato_id')
            ->where('requerimiento_cantidato.id', $cita->req_candi_id)
            ->select('datos_basicos.telefono_movil', 'requerimiento_cantidato.requerimiento_id')
            ->first();

            return view("admin.reclutamiento.modal.citar_para_cliente_view", compact('cita', 'userData'));
        }else{
            return view("admin.reclutamiento.modal.citar_para_cliente_view", compact('cita'));
        }
    }

    public function modifica_cita_cliente(Request $data)
    {
        $reqId = $data->get('requirimiento_id');

        $telefono = $data->get('telefono_movil');

        $telInd = '57'.$telefono;

        $idCita = $data->get('id_cita');

        $fechaCita = $data->get('fecha_cita');

        $fecha = str_replace("/", "-", $fechaCita);
        $fecha = substr($fecha, 0, 10);
        $hora = substr($fechaCita, 11, 19);
        $hora = strtotime($hora);
        $hora = date("h:i a", $hora);

        $numeroDia = date('d', strtotime($fecha));
        $dia = date('l', strtotime($fecha));
        $mes = date('F', strtotime($fecha));
        $anio = date('Y', strtotime($fecha));
        $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
        $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        $nombredia = str_replace($dias_EN, $dias_ES, $dia);
        $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        $nombreMes = str_replace($meses_EN, $meses_ES, $mes);

        $txtFecha = $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio." a las ".$hora;

        $Observacion = $data->get('observaciones');

        $datos = "Buen día, a continuación recibirá las indicaciones de su cita programada, ".$Observacion." ".$txtFecha." Para entrevista con el cliente.";

        $modificaCita = Citacion::where('id', $idCita)->first();

        $modificaCita->psicologo_id = $this->user->id;
        $modificaCita->estado = 1;

        $modificaCita->save();

        $proceso = RegistroProceso::where('requerimiento_candidato_id', $modificaCita->req_candi_id)
        ->whereRaw(" (apto is null or  procesos_candidato_req.apto = '')  ")
        ->whereIn("proceso", ["ENVIO_CITA_POR_CLIENTE"])
        ->orderby('created_at','DESC')
        ->first();

        $proceso->apto = 1;
        $proceso->usuario_terminacion = $this->user->id;
        $proceso->save();

        return view("admin.reclutamiento.modal.citar_para_cliente_llamada_view", compact('reqId', 'telInd', 'datos'));
    }

    public function observaciones_gestion(Request $data){
        $req = Requerimiento::find($data->req_id);
        $modulo = $data->modulo;
        $tipo_observaciones = ["" => "Seleccionar"] + TipoObservacionReq::where("active", 1)->pluck("descripcion", "id")->toArray();
        return view("admin.reclutamiento.modal.observaciones", compact("req", "modulo", "tipo_observaciones"));
    }

    public function guardar_observaciones_gestion(Request $data){
        
        DB::beginTransaction();
 
        try {

            $req = Requerimiento::join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->where("requerimientos.id", $data->req_id)
            ->select("requerimientos.*", 
                     "cargos_especificos.descripcion as cargo",
                     "clientes.id as cliente_id",
                     "clientes.nombre as nombre_cliente")
            ->first();

            $observacion = new RequerimientoObservaciones();

            $observacion->fill([
                "req_id" => $data->get("req_id"),
                "observacion" => $data->get("observacion"),
                "user_gestion" => $this->user->id,
                "tipo_observacion_id" => $data->get("tipo_observacion_id")
            ]);

            $observacion->save();

            $tipo_observacion = ($observacion->tipo_observacion != NULL) ? $observacion->tipo_observacion->descripcion : "";

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Observación sobre requerimiento"; //Titulo o tema del correo
            //Arreglo para el botón
            $mailButton = [];

            if ( $data->has('modulo') && $data->modulo == "admin" ) {

                $usuario = User::join('datos_basicos', 'datos_basicos.user_id', '=', "users.id")
                    ->select('users.*', 'datos_basicos.nombres')->find($req->solicitado_por);

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "
                    Hola {$usuario->nombres}, te informamos que el analista de selección que está llevando a cabo el proceso en el requerimiento No. {$req->id} para el cargo {$req->cargo} ha realizado una observación sobre el proceso. 
                    <br/><br/>
                    Tipo de observación: {$tipo_observacion}
                    <br/><br/>
                    Observación: {$data->observacion}.";

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton);

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($req, $usuario) {

                    $message->to($usuario->email, "T3RS")
                            ->subject("Observación sobre requerimiento No. {$req->id}")
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

            }else if($data->has('modulo') && $data->modulo == "req"){

                $usuario = User::join('datos_basicos', 'datos_basicos.user_id', '=', "users.id")
                    ->select('users.*', 'datos_basicos.nombres')->find($req->solicitado_por);

                //validamos si esxiste el usuario y que no sea el mismo que esta creando la observacion
                if ( $usuario != null && $usuario->id != $this->user->id) {
                    
                    //Cuerpo con html y comillas dobles para las variables
                    $mailBody = "
                        Hola {$usuario->nombres}, te informamos que {$this->user->name} de tu cliente {$req->nombre_cliente} ha realizado una observación sobre el requerimiento No. {$req->id}.
                        <br/><br/>
                        Tipo de observación: {$tipo_observacion}
                        <br/><br/>
                        Observación: {$data->observacion}.";

                    $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton);

                    Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($req, $usuario) {

                        $message->to($usuario->email, "T3RS")
                                ->subject("Observación sobre requerimiento No. {$req->id}")
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }
    
    public function buscar_candidato(Request $data)
    {
        $asociado_req_actual =false;
        $p_contratacion = false;

        $fuentes = ["" => "Seleccionar"] + TipoFuentes::pluck("descripcion", "id")->toArray();

        $candidato = DatosBasicos::join('users', 'users.id', '=', 'datos_basicos.user_id')->select('datos_basicos.*', 'users.tipo_fuente_id as tipo_fuentes_id')->where("datos_basicos.numero_id", $data->cedula)->first();
        $estado_civil = ["" => "Seleccionar"] + EstadoCivil::pluck("descripcion","id")->toArray();

        if($candidato != null) {
            $asociacion = DB::table("requerimiento_cantidato")
            ->whereRaw(" estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
            ->where("candidato_id", $candidato->user_id)
            ->where("requerimiento_id", $data->get("req_id"))
            ->orderBy("id", "DESC")
            ->first();

            if($asociacion != null) {
                $asociado_req_actual = true;
            }

            //se verifica si esta en proceso de contratación
            $contratado = ReqCandidato::where("estado_candidato", "=", 11)
            ->where("candidato_id", $candidato->user_id)
            ->orderBy("id", "DESC")
            ->first();

            if($contratado != null) {
                $p_contratacion = true;
            }
        }

        $tiene_visita = false;

        if($candidato == null) {
            $candidato_id = "";
            $find = false;
            $atributo = " ";
        }else {
            $find = true;
            $atributo = "readonly";
            $candidato_id = $candidato->numero_id;

            if($data->has("visita")) {
                $visita = VisitaCandidato::where("estado",1)
                ->where("candidato_id", $candidato->user_id)
                ->where("visitas_candidatos.gestionado_admin", 0)
                ->first();

                if(count($visita) > 0) {
                    $tiene_visita=true;
                }
            }
        }

        return response()->json([
            "success" => true,
            "find" => $find,
            "req_contratado"=> $contratado->requerimiento_id,
            "candidato" => $candidato_id,
            "asociado"  =>$asociado_req_actual,
            "p_contratacion"=> $p_contratacion,
            "tiene_visita"=>$tiene_visita,
            "view" => view("admin.reclutamiento.includes.gestion-requerimiento._form_ingresar_candidato_modal", compact("candidato", "candidato_id", "fuentes", "atributo", "estado_civil"))->render()
        ]);
    }

    public function buscarCandidatoPorCedula(Request $request){

        $candidato = DatosBasicos::where("numero_id",$request->cedula)->first();

        if($candidato == null){
            $find = false;
        } else {
            $find = true;
            //Se validan estado de reclutamiento del candidato y estado del requerimiento
            $se_puede_postular = false;

            if ($candidato->estado_reclutamiento == config('conf_aplicacion.C_ACTIVO')) {
                /*Si el estado de reclutamiento del candidato esta:
                * 5-Activo
                * Se puede postular al candidato
                */
                $se_puede_postular = true;
            }else{
                $proceso_req_cand = RegistroProceso::where("candidato_id", $candidato->user_id)->orderBy('id', 'desc')->first();
                if ($proceso_req_cand != null) {
                    if ($proceso_req_cand->estado == config('conf_aplicacion.C_CONTRATADO') || $proceso_req_cand->estado == config('conf_aplicacion.C_QUITAR')) {
                        /*Si el estado del candidato en el requerimiento anterior esta:
                        * 12-Contratado
                        * 14-Quitado
                        * Se puede postular al candidato
                        */
                        $se_puede_postular = true;
                    } else {
                        $estado_req = EstadosRequerimientos::where('req_id', $proceso_req_cand->requerimiento_id)->orderBy('id', 'desc')->first();
                        if ($estado_req->estado == 1 || $estado_req->estado == 2 || $estado_req->estado == 3 || $estado_req->estado == 16) {
                            /*Si en el ultimo requerimiento donde esta asociado el candidato esta:
                            * 1-Cancelado por cliente
                            * 2-Cancelado por Seleccion
                            * 3-Cerrado por cumplimiento Parcial
                            * 16-Terminado
                            * Se puede postular al candidato
                            */
                            $se_puede_postular = true;
                        } else {
                            $req_candidato = ReqCandidato::where('requerimiento_id', $proceso_req_cand->requerimiento_id)->where("candidato_id", $candidato->user_id)->orderBy('id', 'desc')->first();
                            if ($req_candidato != null && $req_candidato->estado_candidato == 24) {
                                /*Si el estado del candidato en el requerimiento anterior esta:
                                * 24-Contratacion cancelada
                                * Se puede postular al candidato
                                */
                                $se_puede_postular = true;
                            }
                        }
                    }
                }
            }
        }
       
        return response()->json([
            "success" => true,
            "find" => $find,
            "se_puede_postular" => $se_puede_postular,
            "candidato" => $candidato
        ]);
    }

    public function guardar_notas(Request $data){
        $requerimiento = Requerimiento::find($data->req);
        $requerimiento->notas_adicionales = $data->notas;
        $requerimiento->enterprise = $data->enterprise;
        $requerimiento->save();

        return response()->json(["success" => true,"mensaje"=>'Se guardo las notas adicionales']);   
    }

    public function reabrir_req(request $data)
    {
        $estados = EstadosRequerimientos::where("req_id",$data->req)->get();
      
        foreach($estados as $estado){
            if($estado->estado == 16){
                $estado->estado=7;
                $estado->observaciones="Se reabrió el requerimiento";
                $estado->save();
            }//fin del si esteado 16
        }//fin del foreach

        return response()->json(["success" => true]);
    }

    public function eliminar_proceso(Request $data){
        $candidato = $data->candidato;
        $proceso = $data->proceso;
        $proceso_id = $data->proceso_id;

        return view("admin.reclutamiento.modal.eliminar_proceso_view", compact("candidato", "proceso", "proceso_id"));
    }

    public function confirmar_eliminar_proceso(Request $data){
        $proceso = RegistroProceso::find($data->proceso_id);
        $proceso->delete();

        return response()->json(["success" => true]);
    }

    public function reabrir_proceso(Request $data){
        $candidato = $data->candidato;
        $proceso = $data->proceso;
        $proceso_id = $data->proceso_id;

        return view("admin.reclutamiento.modal.reabrir_proceso_view", compact("candidato", "proceso", "proceso_id"));
    }

    public function confirmar_reabrir_proceso(Request $data){
        $proceso = RegistroProceso::find($data->proceso_id);
        $proceso->apto = null;
        $proceso->save();

        if ($proceso->proceso = "ENTREVISTA_MULTIPLE") {
            $entrevista_detalles = EntrevistaMultipleDetalles::where('req_candi_id', $proceso->requerimiento_candidato_id)->first();
            if ($entrevista_detalles != null) {
                $entrevista_detalles->apto = null;
                $entrevista_detalles->save();
            }
        }

        return response()->json(["success" => true]);
    }

    public function  detalle_otras_fuentes(Request $data)
    {
        $candidato=CandidatosFuentes::join("datos_basicos","datos_basicos.numero_id", "=", "candidatos_otras_fuentes.cedula")
        ->leftjoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
        ->where("cedula", $data->cedula)
        ->select(
            "candidatos_otras_fuentes.*",
            "datos_basicos.*",
            "estados_civiles.descripcion as estado_civil"
        )
        ->where("requerimiento_id", $data->req_id)
        ->first();

        return view('admin.reclutamiento.modal.detalle-otras-fuentes', compact("candidato"));
    }

    public function excelOtrasFuentes(Request $request)
    {
        $headers = $this->getHeaderOtrasFuentes();
        $data    = CandidatosFuentes::join("datos_basicos", "datos_basicos.numero_id", "=", "candidatos_otras_fuentes.cedula")
                    ->leftjoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
                    ->where("requerimiento_id", $request->req)
                    ->select("candidatos_otras_fuentes.*", "estados_civiles.descripcion as estado_civil")
                    ->get();
        
        $funcionesGlobales = new FuncionesGlobales();

        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-otras-fuentes', function ($excel) use ($data, $headers) {
            $excel->setTitle('Candidatos otras fuentes');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Candidatos otras fuentes');
            $excel->sheet('Candidatos otras fuentes', function ($sheet) use ($data, $headers) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reclutamiento.includes.grilla_otras_fuentes_excel', [
                    'data'    => $data,
                    'headers' => $headers
                ]);
            });
        })->export('xlsx');
    }

    private function getHeaderOtrasFuentes()
    {   
        $headers = [
            'Observaciones',
            'NOMBRE',
            'TELÉFONO',
            'CORREO ',
            'EMPRESA',
            'CARGO',
            'MOTIVACÓN CAMBIO ',
            'TRAYECTORIA',
            'LE REPORTA',
            'LE REPORTAN',
            'SALARIO',
            'BENEFICIOS',
            'ASPIRACIÓN',
            'FECHA NACIMIENTO',
            'ESTADO CIVIL',
            'ESTUDIOS',
            'IDIOMAS',
        ];

        return $headers;
    }
 
    public function reenviar_correo(Request $request)
    {
        $email_doc_contrato = User::find($request->user_id);
        $req_id = $request->req_id;
        $datos_correo_archivos = DatosBasicos::where('user_id',$request->user_id)->first();

        $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->where("requerimientos.id", $req_id)
        ->select(
            "requerimientos.num_vacantes",
            "requerimientos.id as requerimiento_id",
            "clientes.firma_digital",
            "cargos_especificos.firma_digital as firma_digital_cargo",
            "cargos_especificos.videos_contratacion as video_cargo",
            "cargos_especificos.descripcion as cargo"
        )
        ->first();

        if(!empty($email_doc_contrato->email)){

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = ""; //Titulo o tema del correo

            //Cuerpo con html y comillas dobles para las variables
            $mailBody = "
                Felicitaciones  $datos_correo_archivos->nombres $datos_correo_archivos->primer_apellido, te hemos pre-seleccionado en el requerimiento $req_id correspondiente al cargo  $requerimiento->cargo.
                <br/>
                Te invitamos a cargar los documentos solicitados en la plataforma y proceder con la firma de tu contrato de forma virtual. 
                <br/><br/>

                Por favor haz clic en el siguiente botón y sigue las instrucciones que te brindará la plataforma.
                ";

            //Arreglo para el botón
            $mailButton = ['buttonText' => 'CARGAR DOCUMENTOS Y FIRMAR CONTRATO', 'buttonRoute' => route('admin.carga_archivos_contratacion')];

            $mailUser = $datos_correo_archivos->user_id; //Id del usuario al que se le envía el correo

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_correo_archivos, $requerimiento, $req_id) {

                $message->to($datos_correo_archivos->email, $datos_correo_archivos->nombres)
                        ->subject("Pre - selección para contratación virtual - $requerimiento->cargo")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });


            return response()->json([
                'success' => true,
                'email' => $email_doc_contrato->email
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }

    public function reenviar_correo_video_confirmacion(Request $request)
    {
        $email_doc_contrato = User::find($request->user_id);

        //Hash data
        $CandidatoId = Crypt::encrypt($request->user_id);
        $RequerimientoId = Crypt::encrypt($request->req_id);

        if(!empty($email_doc_contrato->email)){
            Mail::send('admin.email-documentos-video-confirma', [
                "url" => route("home.confirmar-contratacion-video", [$CandidatoId, $RequerimientoId])
            ], function ($message) use($email_doc_contrato){
                $message->to([
                    $email_doc_contrato->email,
                    "javier.chiquito@t3rsc.co"
                ], "T3RS")
                ->subject("Confirmar video contratación")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

            return response()->json([
                'success' => true,
                'email' => $email_doc_contrato->email
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }

    public function pausar_firma(Request $request)
    {
        //Validar si el contrato ya está firmado.
        $proceso = RegistroProceso::where("requerimiento_candidato_id", $request->cand_req)
        ->whereIn("proceso", ["FIRMA_VIRTUAL_SIN_VIDEOS", "FIN_CONTRATACION_VIRTUAL"])
        ->where("apto",1)
        ->get();

        if ($proceso->count() > 0) {
            return response()->json([
                "firmado" => true
            ]);
        }

        $firma = FirmaContratos::where('user_id', $request->user_id)
        ->where('req_id', $request->req_id)
        ->orderBy('created_at', 'DESC')
        ->first();

        $stand_by = null;

        if($firma->stand_by == 0){
            $firma->stand_by = 1;
            $firma->save();

            $stand_by = 1;
        }elseif($firma->stand_by == 1){
            //$firma->stand_by = 0;
            //$firma->save();

            $stand_by = 0;
        }

        return response()->json([
            'success' => true,
            'stand_by' => $stand_by
        ]);
    }

    public function editar_informacion_contratacion(Request $data)
    {
        $caja_compensaciones = [];
        $fondo_cesantias = [];
        $bancos = [];
        $dato_contrato = null;

        $user_id = $data->user_id;
        $req_id = $data->req_id;

        $sitio = Sitio::first();
        $sitioModulo = SitioModulo::first();

        $contra_clientes = RegistroProceso::select('procesos_candidato_req.*')
        ->where('procesos_candidato_req.proceso', 'ENVIO_CONTRATACION')
        ->where('procesos_candidato_req.requerimiento_candidato_id', $data->get("candidato_req"))
        ->first();

        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
        ->join('requerimientos', 'requerimientos.id', "=", 'requerimiento_cantidato.requerimiento_id')
        ->where("requerimiento_cantidato.id", $data->candidato_req)
        ->select(
            "datos_basicos.*",
            "tipo_identificacion.cod_tipo as cod_tipo_identificacion",
            "requerimiento_cantidato.id as req_candidato",
            "requerimiento_cantidato.requerimiento_id as requerimiento"
        )
        ->first();

        $requerimiento = Requerimiento::leftjoin('centros_costos_produccion','centros_costos_produccion.id', '=', 'requerimientos.centro_costo_id')
        ->where('requerimientos.id', $candidato->requerimiento)
        ->select('requerimientos.*', 'centros_costos_produccion.descripcion as centro_costos')
        ->first();

        $requerimiento_contrato_cc = RequerimientoContratoCandidato::select('requerimiento_contrato_candidato.centro_costo_id')
        ->where('requerimiento_contrato_candidato.requerimiento_id', $data->req_id)
        ->where('requerimiento_contrato_candidato.candidato_id', $data->user_id)
        ->first();

        $contratacion_cliente  = RegistroProceso::where("requerimiento_candidato_id", $data->get("candidato_req"))
        ->where("proceso", "ENVIO_CONTRATACION_CLIENTE")
        ->first();

        $observacion_cliente = null;

        if($contratacion_cliente != null){
            $observacion_cliente = $observacion_cliente->observaciones;
        }

        $fecha_hoy = Carbon::now();
        $fecha_hoy = $fecha_hoy->format('Y/m/d');
        
        //Buscar el centro de costo que esta en el requerimiento
        $centro_costo = CentroCostoProduccion::join('requerimientos', 'requerimientos.centro_costo_id', '=', 'centros_costos_produccion.id')
        ->where('requerimientos.id', $candidato->requerimiento)
        ->select('centros_costos_produccion.id as centro_costo')
        ->first();

        $usuarios_clientes = ["" => "Seleccion"] + EloquentUser::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
        ->where("users_x_clientes.cliente_id", $data->cliente)
        ->pluck("users.name", "users.id")
        ->toArray();

        $eps = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->pluck("descripcion", "id")->toArray();
        $afp = ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->pluck("descripcion", "id")->toArray();

        //Listar los centros de costos del requerimiento
        $centros_costos = ["" => "Seleccionar"] + CentroCostoProduccion::where("cod_division", $data->cliente)
        ->pluck("descripcion", "id")
        ->toArray();

        $caja_compensaciones = ["" => "Seleccionar"] + CajaCompensacion::pluck("descripcion", "id")->toArray();

        $fondo_cesantias = ["" => "Seleccionar"] + FondoCesantias::pluck("descripcion", "id")->toArray();
     
        $bancos = ["" => "Seleccionar"] + Bancos::pluck("nombre_banco", "id")->toArray();

        $dato_contrato = DatosBasicos::join("requerimiento_cantidato", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
        ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
        ->join("requerimiento_contrato_candidato", "requerimiento_contrato_candidato.candidato_id", "=", "datos_basicos.user_id")
        ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
        ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
        ->leftJoin("bancos", "bancos.id", "=", "datos_basicos.nombre_banco")
        ->leftJoin("caja_compensacion", "caja_compensacion.id", "=", "datos_basicos.caja_compensaciones")
        ->leftJoin("fondo_cesantias", "fondo_cesantias.id", "=", "datos_basicos.fondo_cesantias")
        ->where("requerimiento_cantidato.requerimiento_id", $data->req_id)
        ->where("requerimiento_contrato_candidato.requerimiento_id", $data->req_id)
        ->where("datos_basicos.user_id", $data->user_id)
        ->select(
            "datos_basicos.*",

            "entidades_afp.descripcion as entidades_afp_des",
            "entidades_eps.descripcion as entidades_eps_des",

            "fondo_cesantias.descripcion as fondo_cesantia_des",

            "caja_compensacion.descripcion as caja_compensacion_des",

            "bancos.nombre_banco as nombre_banco_des",

            "requerimiento_contrato_candidato.observaciones",
            "requerimiento_contrato_candidato.fecha_ingreso",
            "requerimiento_contrato_candidato.fecha_fin_contrato",
            "requerimiento_contrato_candidato.hora_ingreso",
            "requerimiento_contrato_candidato.tipo_ingreso",
            "requerimiento_contrato_candidato.fecha_ultimo_contrato",

            "requerimiento_cantidato.auxilio_transporte",
            "requerimiento_cantidato.tipo_ingreso"
        )
        ->groupBy('procesos_candidato_req.candidato_id')
        ->orderBy('requerimiento_cantidato.id', 'DESC')
        ->first();

        //Adicionales
        $adicionales = [];
        if ($sitioModulo->generador_variable == 'enabled') {
            if($sitio->asistente_contratacion == 1) {
                $adicionales = ClausulaValorCandidato::where('user_id', $data->user_id)
                ->where('req_id', $data->req_id)
                ->get();
            }
        }

        return view("admin.reclutamiento.modal.editar_informacion_contratacion_new", compact(
            "centro_costo",
            "fecha_hoy",
            "contra_clientes",
            "candidato",
            "mensaje",
            "proceso",
            "proceso2",
            "btn",
            "usuarios_clientes",
            "requerimiento",
            "eps",
            "afp",
            "caja_compensaciones",
            "fondo_cesantias",
            "bancos",
            "dato_contrato",
            "observacion_cliente",
            "user_id",
            "req_id",
            "centros_costos",
            "requerimiento_contrato_cc",
            "adicionales"
        ));
    }

    //Guardar datos editados al pausar
    public function guardar_informacion_contratacion(Request $data)
    {
        $rules = [];
        $rules += ["fecha_ingreso_contra" => "required"];

        $validar = Validator::make($data->all(), $rules);

        $candidato = $data;

        if($validar->fails()) {
            return response()->json(["success" => false, "view" => 'Completa los campos obligatorios']);
        }

        //Actualizar datos en el contrato
        $actualizar_contrato = RequerimientoContratoCandidato::where('requerimiento_id', $data->req_id)
        ->where('candidato_id', $data->user_id)
        ->orderBy('created_at', 'DESC')
        ->first();

        $actualizar_contrato->centro_costo_id       = $data->centro_costos;
        $actualizar_contrato->arl_id                = $data->arl;
        $actualizar_contrato->eps_id                = $data->entidad_eps;
        $actualizar_contrato->fondo_pensiones_id    = $data->entidad_afp;
        $actualizar_contrato->caja_compensacion_id  = $data->caja_compensacion;
        $actualizar_contrato->fondo_cesantia_id     = $data->fondo_cesantias;
        $actualizar_contrato->fecha_ingreso         = $data->fecha_ingreso_contra;
        $actualizar_contrato->observaciones         = $data->observaciones;
        $actualizar_contrato->hora_ingreso          = $data->hora_ingreso;
        $actualizar_contrato->auxilio_transporte    = $data->auxilio_transporte;
        $actualizar_contrato->nombre_banco          = $data->nombre_banco;
        $actualizar_contrato->tipo_cuenta           = $data->tipo_cuenta;
        $actualizar_contrato->numero_cuenta         = $data->numero_cuenta;
        $actualizar_contrato->fecha_fin_contrato    = $data->fecha_fin_contrato;

        //tipo_ingreso = 1 Nuevo y 2 = Recontrato
        if ($data->tipo_ingreso == 2) {
            //Si se esta recontratando se guarda la fecha de fin del ultimo contrato
            if($data->has('fecha_fin_ultimo') && $data->fecha_fin_ultimo != "" || $data->fecha_fin_ultimo != null) {
                $actualizar_contrato->fecha_ultimo_contrato = $data->fecha_fin_ultimo;
            }
        }
        $actualizar_contrato->tipo_ingreso = $data->tipo_ingreso;
        $actualizar_contrato->save();
        
        if(route("home") == "https://humannet.t3rsc.co"){
            $actualizar_contrato->nombre_banco  = $data->nombre_banco;
            $actualizar_contrato->tipo_cuenta   = $data->tipo_cuenta;
            $actualizar_contrato->numero_cuenta = $data->numero_cuenta;
            $actualizar_contrato->trabajo_dia   = $data->trabajo_dia;
            $actualizar_contrato->trabajo_noche = $data->trabajo_noche;
            $actualizar_contrato->tabajo_fin    = $data->tabajo_fin;
            $actualizar_contrato->part_time     = $data->part_time;
            $actualizar_contrato->comentarios   = $data->comentarios;

            $actualizar_contrato->save();
        }

        //Actualizar datos en el registro del proceso ENVIO_CONTRATACION
        $valida_cliente = RegistroProceso::where("requerimiento_candidato_id", $data->get("candidato_req"))
        ->where("proceso", "ENVIO_CONTRATACION")
        ->orderBy('created_at', 'DESC')
        ->first();

        $valida_cliente->centro_costos = $data->centro_costos;
        $valida_cliente->observaciones = $data->observaciones;
        $valida_cliente->fecha_inicio_contrato = $data->fecha_ingreso_contra;
        $valida_cliente->fecha_fin_contrato    = $data->fecha_fin_contrato;

        //tipo_ingreso = 1 Nuevo y 2 = Recontrato
        if ($data->tipo_ingreso == 2) {
            //Si se esta recontratando se guarda la fecha de fin del ultimo contrado
            if($data->has('fecha_fin_ultimo') && $data->fecha_fin_ultimo != "" || $data->fecha_fin_ultimo != null) {
                $valida_cliente->fecha_ultimo_contrato  = $data->fecha_fin_ultimo;
            }
        }

        $valida_cliente->user_autorizacion = $data->user_autorizacion;
        $valida_cliente->hora_entrada = $data->hora_ingreso;
        $valida_cliente->save();

        //Datos para la orden de contratación - Actualiza datos básicos
        $candidato = DatosBasicos::where('user_id', $valida_cliente->candidato_id)->first();

        $candidato->caja_compensaciones = $data->caja_compensacion;
        $candidato->fondo_cesantias     = $data->fondo_cesantias;
        $candidato->nombre_banco        = $data->nombre_banco;
        $candidato->tipo_cuenta         = $data->tipo_cuenta;
        $candidato->numero_cuenta       = $data->numero_cuenta;
        $candidato->entidad_eps         = $data->entidad_eps;
        $candidato->entidad_afp         = $data->entidad_afp;
        $candidato->save();

        $req = ReqCandidato::find($data->get("candidato_req"));

        $req->tipo_ingreso       = $data->tipo_ingreso;
        $req->auxilio_transporte = $data->auxilio_transporte;
        $req->save();

        //Comienzo guardar adicionales
            if($data->has("clausulas") && is_array($data->get("clausulas"))) {
                foreach($data->get("clausulas") as $key => $clausula) {
                    //Si hay un valor adicional configurado se crea la asociación en la tabla
                    if($data->has("valor_adicional") && is_array($data->get("valor_adicional"))) {
                        //if ($data->get("valor_adicional")[$key] != 0) {
                            $documento_adicional_valor = ClausulaValorCandidato::where('user_id', $data->user_id)
                            ->where('req_id', $data->req_id)
                            ->where('adicional_id', $clausula)
                            ->first();

                            $documento_adicional_valor->valor = $data->get("valor_adicional")[$key];
                            $documento_adicional_valor->save();
                        //}
                    }
                }
            }
        //Fin guardar adicionales

        //Iniciar contrato
        $firma = FirmaContratos::where('user_id', $data->user_id)
        ->where('req_id', $data->req_id)
        ->orderBy('created_at', 'DESC')
        ->first();

        $firma->stand_by = 0;
        $firma->save();

        return response()->json([
            "success" => true
        ]);
    }

    //Reenvío a contratar después de anumar
    public function reenviar_a_contratar(Request $data)
    {
        $caja_compensaciones = [];
        $fondo_cesantias     = [];
        $bancos = [];
        $dato_contrato = null;

        $contra_clientes = RegistroProceso::select('procesos_candidato_req.*')
        ->where('procesos_candidato_req.id', $data->contra_cliente)
        ->first();

        $contratacion_previa = RegistroProceso::select('procesos_candidato_req.*')
        ->where('procesos_candidato_req.proceso', 'ENVIO_CONTRATACION')
        ->where('procesos_candidato_req.requerimiento_candidato_id', $data->get("candidato_req"))
        ->first();

        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join('requerimientos', 'requerimientos.id', "=", 'requerimiento_cantidato.requerimiento_id')
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->select(
            "datos_basicos.*",
            "requerimiento_cantidato.id as req_candidato",
            "requerimiento_cantidato.requerimiento_id as requerimiento"
        )
        ->first();

        $requerimiento = Requerimiento::leftjoin('centros_costos_produccion', 'centros_costos_produccion.id', '=', 'requerimientos.centro_costo_id')
        ->where('requerimientos.id', $candidato->requerimiento)
        ->select('requerimientos.*', 'centros_costos_produccion.descripcion as centro_costos')
        ->first();

        //VERIFICAR SI SE HA ENVIADO A APROBAR POR EL CLIENTE Y SI YA SE APROBO
        $proceso  = RegistroProceso::where("requerimiento_candidato_id", $data->get("candidato_req"))->where("proceso", "ENVIO_APROBAR_CLIENTE")->first();
        $proceso2 = RegistroProceso::where("requerimiento_candidato_id", $data->get("candidato_req"))->where("proceso", "ENVIO_CONTRATACION")->first();

        $mensaje = '¿Desea enviar a contratacion a el/la candidat@?';
        $btn     = true;

        if($proceso != null) {
            if($proceso->apto == ""){
                $mensaje = "Este candidato esta a la espera de recibir la aprobación por parte del cliente para poder ser enviado a contratar.";
                $btn = false;
            }
        }

        if($proceso != null) {
            if($proceso->apto == 2){
                 $mensaje = "Este candidato NO ha sido aprobado por el cliente.";
                $btn = false;
            }
        }

        $contratacion_cliente  = RegistroProceso::where("requerimiento_candidato_id", $data->get("candidato_req"))
        ->where("proceso", "ENVIO_CONTRATACION_CLIENTE")
        ->first();

        $observacion_cliente = null;

        if($contratacion_cliente != null){
            $observacion_cliente = $contratacion_cliente->observaciones;
        }

        $fecha_hoy = Carbon::now();
        $fecha_hoy = $fecha_hoy->format('Y/m/d');

        $centro_costo = CentroCostoProduccion::join('requerimientos', 'requerimientos.centro_costo_id', '=', 'centros_costos_produccion.id')
        ->select('centros_costos_produccion.descripcion as centro_costo')
        ->where('requerimientos.id', $candidato->requerimiento)
        ->first();

        $usuarios_clientes = ["" => "Seleccion"] + EloquentUser::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
        ->where("users_x_clientes.cliente_id", $data->cliente_id)
        ->pluck("users.name", "users.id")
        ->toArray();

        $eps = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->pluck("descripcion", "id")->toArray();
        $afp = ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->pluck("descripcion", "id")->toArray();

        //Listar los centros de costos del requerimiento
        $centros_costos_list = ["" => "Seleccionar"] + CentroCostoProduccion::where("cod_division", $data->cliente_id)
        ->pluck("descripcion", "id")
        ->toArray();

        if(route("home") == "http://localhost:8000" || route("home") == "https://desarrollo.t3rsc.co" ||
            route("home") == "https://pruebaslistos.t3rsc.co" || route("home") == "https://listos.t3rsc.co" ||
            route("home") == "https://vym.t3rsc.co") {

            $caja_compensaciones = ["" => "Seleccionar"] + CajaCompensacion::pluck("descripcion", "id")->toArray();
            $fondo_cesantias = ["" => "Seleccionar"] + FondoCesantias::pluck("descripcion", "id")->toArray();
            $bancos = ["" => "Seleccionar"] + Bancos::pluck("nombre_banco", "id")->toArray();

            $dato_contrato = DatosBasicos::join("requerimiento_cantidato", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
            ->join("users", "users.id","=","requerimiento_cantidato.candidato_id")
            ->join("requerimiento_contrato_candidato", "requerimiento_contrato_candidato.candidato_id", "=", "datos_basicos.user_id")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->leftJoin("bancos", "bancos.id", "=", "datos_basicos.nombre_banco")
            ->leftJoin("caja_compensacion", "caja_compensacion.id", "=", "datos_basicos.caja_compensaciones")
            ->leftJoin("fondo_cesantias", "fondo_cesantias.id", "=", "datos_basicos.fondo_cesantias")
            ->where("requerimiento_cantidato.requerimiento_id", $candidato->requerimiento)
            ->where("datos_basicos.user_id", $candidato->user_id)
            ->whereIn('procesos_candidato_req.proceso', ['ENVIO_CONTRATACION_CLIENTE', 'ENVIO_CONTRATACION'])
            ->groupBy('procesos_candidato_req.candidato_id')
            ->orderBy('requerimiento_cantidato.id')
            ->select(
                "datos_basicos.*",

                "entidades_afp.descripcion as entidades_afp_des",
                "entidades_eps.descripcion as entidades_eps_des",

                "fondo_cesantias.descripcion as fondo_cesantia_des",

                "caja_compensacion.descripcion as caja_compensacion_des",

                "bancos.nombre_banco as nombre_banco_des",

                "procesos_candidato_req.fecha_ingreso_contra",
                "procesos_candidato_req.fecha_inicio_contrato",
                "procesos_candidato_req.fecha_inicio",
                "procesos_candidato_req.hora_entrada",
                "procesos_candidato_req.centro_costos",
                "procesos_candidato_req.user_autorizacion",

                "requerimiento_contrato_candidato.observaciones",
                "requerimiento_contrato_candidato.fecha_ingreso",
                "requerimiento_contrato_candidato.fecha_fin_contrato",
                "requerimiento_contrato_candidato.hora_ingreso",
                "requerimiento_contrato_candidato.tipo_ingreso",
                "requerimiento_contrato_candidato.fecha_ultimo_contrato",
                
                'requerimiento_cantidato.auxilio_transporte',
                'requerimiento_cantidato.tipo_ingreso'
            )
            ->groupBy('procesos_candidato_req.candidato_id')
            ->orderBy('requerimiento_cantidato.id', 'DESC')
            ->first();
        }

        $newEndingDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($requerimiento->fecha_ingreso)) . " + 365 day"));

        return view("admin.reclutamiento.modal.reenviar_a_contratacion", compact(
            "centro_costo",
            "centros_costos_list",
            "fecha_hoy",
            "contra_clientes",
            "candidato",
            "mensaje",
            "proceso",
            "proceso2",
            "btn",
            "usuarios_clientes",
            "requerimiento",
            "eps",
            "afp",
            "caja_compensaciones",
            "fondo_cesantias",
            "bancos",
            "dato_contrato",
            "observacion_cliente",
            "newEndingDate",
            "contratacion_previa"
        ));
    }

    /*
    *   Enviar a contratar candidatos (CONTRATAR)
    */
    public function reenviar_a_contratar_proceso(Request $data)
    {
        $rules = [];
        $sitio = Sitio::first();

        if(route('home') == "https://vym.t3rsc.co" || route('home') == "https://listos.t3rsc.co"){
            $rules += [
                "fecha_ingreso_contra" => "required",
                "user_autorizacion"     => "required",
            ];
        }else{
            $rules += [
                "fecha_inicio_contrato" => "required",
                "user_autorizacion"     => "required",
            ];
        }

        $validar = Validator::make($data->all(), $rules);

        $candidato = $data;

        if(route('home') == "https://vym.t3rsc.co" || route('home') == "https://listos.t3rsc.co"){
            if($validar->fails()) {
                return response()->json(["success" => false, "view" => $this->enviar_contratar2($candidato)->withErrors($validar)->render()]);
            }
        }else{
            if($validar->fails()) {
                return response()->json(["success" => false, "view" => 'Llenas los campos obligatorios']);
            }
        }
        
        //VERIFICAR EL ESTADO DEL REQUERIMIENTO
        $requerimiento_a = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->select(
            "requerimientos.num_vacantes",
            "requerimiento_cantidato.requerimiento_id",
            "requerimiento_cantidato.candidato_id as candidato",
            "requerimiento_cantidato.id as id","clientes.firma_digital as firma_digital"
        )
        ->first();

        $reque = Requerimiento::find($requerimiento_a->requerimiento_id);

        $nuevo_estado = ReqCandidato::where("requerimiento_id", $reque->id)
        ->where("candidato_id", $requerimiento_a->candidato)
        ->orderBy("id", "DESC")
        ->first();

        $nuevo_estado->estado_candidato = 11;
        $nuevo_estado->estado_contratacion = 1;
        $nuevo_estado->save();

        $requerimiento = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->where("requerimiento_cantidato.id", $nuevo_estado->id)
        ->select(
            "requerimientos.num_vacantes",
            "requerimiento_cantidato.requerimiento_id",
            "requerimiento_cantidato.candidato_id as candidato",
            "requerimiento_cantidato.id as id","clientes.firma_digital as firma_digital"
        )
        ->first();

        if(route("home") == "https://vym.t3rsc.co" ||
            route("home") == "https://listos.t3rsc.co" || route("home") == "https://soluciones.t3rsc.co" ||
            route("home") == "https://desarrollo.t3rsc.co"){
            $historialContratacion                       = new RequerimientoContratoCandidato();

            $historialContratacion->requerimiento_id     = $reque->id;
            $historialContratacion->candidato_id         = $requerimiento->candidato;
            $historialContratacion->centro_costo_id      = $data->centro_costos;
            $historialContratacion->arl_id               = $data->arl;
            $historialContratacion->eps_id               = $data->entidad_eps;
            $historialContratacion->fondo_pensiones_id   = $data->entidad_afp;
            $historialContratacion->caja_compensacion_id = $data->caja_compensacion;
            $historialContratacion->fondo_cesantia_id    = $data->fondo_cesantias;
            $historialContratacion->user_gestiono_id     = $this->user->id;
            
            if($data->has("fecha_fin_ultimo")){
                $historialContratacion->fecha_ultimo_contrato = $data->fecha_fin_ultimo;
            }
         
            $historialContratacion->fecha_ingreso       = $data->fecha_ingreso_contra;
            $historialContratacion->observaciones       = $data->observaciones;
            $historialContratacion->hora_ingreso        = $data->hora_ingreso;
            $historialContratacion->auxilio_transporte  = $data->auxilio_transporte;
            $historialContratacion->nombre_banco        = $data->nombre_banco;
            $historialContratacion->tipo_cuenta         = $data->tipo_cuenta;
            $historialContratacion->numero_cuenta       = $data->numero_cuenta;
            $historialContratacion->fecha_fin_contrato  = $data->fecha_fin_contrato;
            $historialContratacion->tipo_ingreso        = $data->tipo_ingreso;
            
            $historialContratacion->save();
        }
        
        if(route("home") == "https://humannet.t3rsc.co"){
            $historialContratacion                    = new RequerimientoContratoCandidato();

            $historialContratacion->requerimiento_id  = $reque->id;
            $historialContratacion->candidato_id      = $requerimiento->candidato;
            $historialContratacion->user_gestiono_id  = $this->user->id;
            $historialContratacion->nombre_banco      = $data->nombre_banco;
            $historialContratacion->tipo_cuenta       = $data->tipo_cuenta;
            $historialContratacion->numero_cuenta     = $data->numero_cuenta;
            $historialContratacion->trabajo_dia       = $data->trabajo_dia;
            $historialContratacion->trabajo_noche     = $data->trabajo_noche;
            $historialContratacion->tabajo_fin        = $data->tabajo_fin;
            $historialContratacion->part_time         = $data->part_time;
            $historialContratacion->comentarios       = $data->comentarios;
            
            $historialContratacion->save();
        }
        
        $agenciaCiudad = Ciudad::where('cod_pais', $reque->pais_id)
        ->where('cod_departamento', $reque->departamento_id)
        ->where('cod_ciudad', $reque->ciudad_id)
        ->first(['agencia']);

        //Actualizar el campo de observaciones del requerimiento
        if(route("home") == "http://localhost:8000"){
            if($data->otros_devengos != null){
                $reque->observaciones = $data->get("otros_devengos");
                $reque->save();
            }
        }

        if(route("home") == "https://desarrollo.t3rsc.co"){
            $campos = [
                'requerimiento_candidato_id' => $nuevo_estado->id,
                'usuario_envio'              => $this->user->id,
                "fecha_inicio"               => date("Y-m-d H:i:s"),
                "fecha_inicio_contrato"      => $data->get("fecha_inicio_contrato"),
                "observaciones"              => $data->get("observaciones"),
                "centro_costos"              => $data->get("centro_costos"),
                "user_autorizacion"          => $data->get("user_autorizacion"),
                "usuario_terminacion"        => $this->user->id,
                "lugar_contacto"             => $data->get("lugar_contacto"),
                "hora_entrada"               => $data->get("hora_ingreso"),
                'proceso'                    => "ENVIO_CONTRATACION",
            ];
        }elseif(route("home") == "https://gpc.t3rsc.co"){
            $campos = [
                'requerimiento_candidato_id' => $nuevo_estado->id,
                'usuario_envio'              => $this->user->id,
                "fecha_inicio"               => date("Y-m-d H:i:s"),
                "fecha_inicio_contrato"      => $data->get("fecha_inicio_contrato"),
                "observaciones"              => $data->get("observaciones"),
                "centro_costos"              => $data->get("centro_costos"),
                "user_autorizacion"          => $data->get("user_autorizacion"),
                "usuario_terminacion"        => $this->user->id,
                'proceso'                    => "ENVIO_CONTRATACION",
                'salario'                    => $data->get("salario")
            ];
        }elseif(route("home") == "https://listos.t3rsc.co" || route("home") == "https://vym.t3rsc.co"){
            $campos = [
                'requerimiento_candidato_id' => $nuevo_estado->id,
                'usuario_envio'              => $this->user->id,
                "fecha_inicio"               => date("Y-m-d H:i:s"),
                "fecha_inicio_contrato"      => $data->get("fecha_inicio_contrato"),
                "observaciones"              => $data->get("observaciones"),
                "centro_costos"              => $data->get("centro_costos"),
                "user_autorizacion"          => $data->get("user_autorizacion"),
                "fecha_ingreso_contra"       => $data->get("fecha_ingreso_contra"),
                "fecha_ultimo_contrato"      => $data->get("fecha_ultimo_contrato"),
                "usuario_terminacion"        => $this->user->id,
                'proceso'                    => "ENVIO_CONTRATACION",
            ];
        }else{
            $campos = [
                'requerimiento_candidato_id' => $nuevo_estado->id,
                'usuario_envio'              => $this->user->id,
                "fecha_inicio"               => date("Y-m-d H:i:s"),
                "fecha_inicio_contrato"      => $data->get("fecha_inicio_contrato"),
                "observaciones"              => $data->get("observaciones"),
                "centro_costos"              => $data->get("centro_costos"),
                "user_autorizacion"          => $data->get("user_autorizacion"),
                "usuario_terminacion"        => $this->user->id,
                'proceso'                    => "ENVIO_CONTRATACION",
            ];
        }

        $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'), $nuevo_estado->id);

        if(route("home") == "http://localhost:8000" || route("home") == "https://desarrollo.t3rsc.co" ||
            route("home") == "https://listos.t3rsc.co" || route("home") == "https://vym.t3rsc.co"){

            $valida_cliente = RegistroProceso::where("requerimiento_candidato_id", $nuevo_estado->id)
            ->where("proceso", "ENVIO_CONTRATACION")
            ->first();

            $valida_cliente->fecha_inicio_contrato  = $data->fecha_inicio_contrato;
            $valida_cliente->fecha_fin_contrato     = $data->fecha_fin_contrato;
            $valida_cliente->fecha_ultimo_contrato  = $data->fecha_fin_ultimo;
            $valida_cliente->hora_entrada           = $data->hora_ingreso;
            $valida_cliente->save();

            //datos para la orden de contratacion
            $candidato = DatosBasicos::where('user_id', $valida_cliente->candidato_id)->first();

            $candidato->caja_compensaciones = $data->caja_compensacion;
            $candidato->fondo_cesantias     = $data->fondo_cesantias;
            $candidato->nombre_banco        = $data->nombre_banco;
            $candidato->tipo_cuenta         = $data->tipo_cuenta;
            $candidato->numero_cuenta       = $data->numero_cuenta;
            $candidato->entidad_eps         = $data->entidad_eps;
            $candidato->entidad_afp         = $data->entidad_afp;
            $candidato->save();

            $req = ReqCandidato::find($nuevo_estado->id);

            $req->tipo_ingreso       = $data->tipo_ingreso;
            $req->auxilio_transporte = $data->auxilio_transporte;
            $req->save();
        }

        $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'))->first();
        
        //VERIFICAR SI EL REQUERIMIENTO YA TIENE TODOS LOS CANDIDATOS
        $requerimiento = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->where("requerimiento_cantidato.id", $nuevo_estado->id)
        ->select(
            "requerimientos.num_vacantes",
            "requerimiento_cantidato.requerimiento_id",
            "clientes.firma_digital",
            "cargos_especificos.firma_digital as firma_digital_cargo",
            "cargos_especificos.videos_contratacion as video_cargo",
            "cargos_especificos.descripcion as cargo"
        )
        ->first();

        $r = ReqCandidato::find($nuevo_estado->id);
        
        $email_doc_contrato = User::find($r->candidato_id);

        $datos_correo_archivos = DatosBasicos::where('user_id', $r->candidato_id)->first();

        //Validación de contratación virtual
        if($requerimiento->firma_digital_cargo == 1 && $sitio->asistente_contratacion == 1){

            //Crea registro de firma de contrato
            $firma = new FirmaContratos();

            $firma->fill([
                'user_id' => $r->candidato_id,
                'req_id'  => $reque->id,
                'estado'  => 1,
                'gestion' => $this->user->id,
                'req_contrato_cand_id' => $historialContratacion->id
            ]);
            $firma->save();

            //Realiza envío de correo para carga de archivos y firma de contrato al candidato
            if(!empty($email_doc_contrato->email)){

                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                $mailTitle = ""; //Titulo o tema del correo

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "
                    Felicitaciones  $datos_correo_archivos->nombres $datos_correo_archivos->primer_apellido, te hemos pre-seleccionado en el requerimiento $requerimiento->requerimiento_id correspondiente al cargo $requerimiento->cargo.
                    <br/>
                    Te invitamos a cargar los documentos solicitados en la plataforma y proceder con la firma de tu contrato de forma virtual. 
                    <br/><br/>

                    Por favor haz clic en el siguiente botón y sigue las instrucciones que te brindará la plataforma.
                                ";

                //Arreglo para el botón
                $mailButton = ['buttonText' => 'CARGAR DOCUMENTOS Y FIRMAR CONTRATO', 'buttonRoute' => route('admin.carga_archivos_contratacion')];

                $mailUser = $datos_correo_archivos->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_correo_archivos, $requerimiento) {

                    $message->to($datos_correo_archivos->email, $datos_correo_archivos->nombres)
                        ->subject("Pre - selección para contratación virtual - $requerimiento->cargo")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

            }

            if(route("home") == "https://listos.t3rsc.co"){
                $usuario_envio = DatosBasicos::where('user_id', $valida_cliente->usuario_envio)
                ->first();

                //Envío de correo a quien envío a contratar
                Mail::send('admin.email-documentos-contratacion', [
                    "url"        => route("admin.carga_archivos_contratacion"),
                    "datos_user" => $datos_correo_archivos,
                    "req_id"     => $requerimiento->requerimiento_id,
                    "cargo"      => $requerimiento->cargo
                ], function ($message) use($usuario_envio, $requerimiento){
                    $message->to([
                        $usuario_envio->email
                    ], "T3RS")
                    ->subject("Pre - selección para contratación virtual (# $requerimiento->requerimiento_id - $requerimiento->cargo)")
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

                //Envío de correo a personas de Listos
                Mail::send('admin.email-documentos-contratacion', [
                    "url"        => route("admin.carga_archivos_contratacion"),
                    "datos_user" => $datos_correo_archivos,
                    "req_id"     => $requerimiento->requerimiento_id,
                    "cargo"      => $requerimiento->cargo
                ], function ($message) use($requerimiento){
                    $message->to([
                        "sandra.lozano@visionymarketing.com.co",
                        "ingrid.diaz@listos.com.co",
                        "juanmanuel.munoz@listos.com.co",
                        "liliana.marin@listos.com.co",
                        "brayan.quintero@listos.com.co",
                        "lida.peraza@listos.com.co"
                    ], "T3RS")
                    ->subject("Pre - selección para contratación virtual (# $requerimiento->requerimiento_id - $requerimiento->cargo)")
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            }
        }

        //NUMERO DE CANDIDATOS SOLICISTADOS POR EL REQUERIMIENTO
        $num_candidatos            = $requerimiento->num_vacantes;
        $candidatos_contratados    = [];
        $candidatos_no_contratados = [];

        //CONSULTAR CANDIDATOS ENVIADOS
        $candidatos_req = EloquentUser::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
        ->where("requerimiento_cantidato.requerimiento_id", $requerimiento->requerimiento_id)
        ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
        ->whereRaw(" requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
        ->select(
            "datos_basicos.*",
            "estados.id as estado_id",
            "estados.descripcion as estado_candidatos",
            "requerimiento_cantidato.id as req_candidato_id"
        )
        ->get();

        foreach ($candidatos_req as $key => $value) {
            if (!in_array($value->estado_id, $this->estados_no_muestra)) {
                //Valida la contratación cancelada
                if($value->estado_id != 24){
                    if ($value->estado_id == config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')) {
                        array_push($candidatos_contratados, $value->user_id);
                    } else {
                        array_push($candidatos_no_contratados, $value->user_id);
                    }
                    //echo $value->estado_id . "<br>";
                }
            }
        }

        //TERMINAR REQUERIMIENTO SI LA CANTIDAD DE CANDIDATOS CONTRATADOS  SON LAS VACANTES DEL REQUERIMIENTO
        if (count($candidatos_contratados) == $num_candidatos) {
            //TERMINAR REQUERIMIENTO
            if($requerimiento->firma_digital_cargo == null || $requerimiento->firma_digital_cargo == 0){
                $terminar_req = new EstadosRequerimientos();
                $terminar_req->fill([
                    "estado"        => config('conf_aplicacion.C_TERMINADO'),
                    "user_gestion"  => $this->user->id,
                    "observaciones" => "Se ha cumplido con todos los candidatos solicitados.",
                    "req_id"        => $requerimiento->requerimiento_id,
                ]);
                $terminar_req->save();

                // Se cambia el estado público del requerimiento
                $req  = Requerimiento::find($requerimiento->requerimiento_id);
                $req->estado_publico = 0;
                $req->save();

                //ACTIVAR CANDIDATOS NO SELECCIONADOS
                foreach ($candidatos_no_contratados as $key => $value) {
                    $update_user = DatosBasicos::where("user_id", $value)->first();
                    $update_user->fill(["estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')]);
                    $update_user->save();
                }
            }
        }

        return response()->json([
            "success" => true,
            "text_estado" => $estado->descripcion,
            'candidato_req' => $nuevo_estado->id
        ]);
    }

    public function enviar_evaluacion_sst(Request $data) {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
        ->first();

        $configuracion_sst = EvaluacionSstConfiguracion::first();

        return view("home.evaluacion_sst.modal.envio_evaluacion_sst_view",compact('candidato', 'configuracion_sst'));
    }

    public function confirmar_envio_evaluacion_sst(Request $data)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato","requerimiento_cantidato.requerimiento_id")
        ->first();

        $configuracion_sst = EvaluacionSstConfiguracion::first();

        $sitio = Sitio::first();
        
        $campos = [
            'requerimiento_candidato_id' => $data->get("candidato_req"),
            'usuario_envio'              => $this->user->id,
            "fecha_inicio"               => date("Y-m-d H:i:s"),
            'proceso'                    => "ENVIO_SST",
        ];//se guarda la evaluacion ssst

        $id_proceso = $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));

        $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();

        //se le envia correo a candidato con el folleto a leer
        //correo con enlace
        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "$configuracion_sst->titulo_prueba"; //Titulo o tema del correo
        $asunto = "$configuracion_sst->titulo_prueba";

        if ($candidato->primer_nombre != null && $candidato->primer_nombre != '') {
            $segundo_nombre = ($candidato->segundo_nombre != null && $candidato->segundo_nombre != '' ? "$candidato->segundo_nombre " : '');
            $nombre_completo = $candidato->primer_nombre.' '. $segundo_nombre . $candidato->primer_apellido.' '.$candidato->segundo_apellido;
        } else {
            $nombre_completo = $candidato->nombres.' '. $candidato->primer_apellido.' '.$candidato->segundo_apellido;
        }

        /*$message_wp = $sitio->mensajePruebasWhatsapp($nombre_completo, $configuracion_sst->titulo_prueba, route('realizar_evaluacion_induccion_sst', ['req_id' => $candidato->requerimiento_id]));

        event(new \App\Events\NotificationWhatsappEvent("message",[
            "phone"=>'57'.$candidato->telefono_movil,
            "body"=> $message_wp
        ]));
        */
        $url = "realizar-evaluacion-sst+".$candidato->requerimiento_id;
        $titulo = $configuracion_sst->titulo_prueba;

        event(new \App\Events\NotificationWhatsappEvent(
            "whatsapp", 
            $candidato->telefono_movil,
            "template", 
            "proceso_pruebas_botones", 
            [$nombre_completo, $titulo, $url]
        ));

        $material_consulta = DB::table("evaluacion_sst_material_consulta")->where('active', 1)->get();
        $texto_material = '<ul>';
        foreach($material_consulta as $mat) {
            $texto_material .= "<li><a href='$mat->enlace' target='_blank' title='$mat->descripcion'>$mat->titulo</a></li>";
        }
        $texto_material .= '</ul>';

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = '
            Buen dia,
            <br/>

            Hola '.$nombre_completo.', te informamos que el analista que está llevando a cabo tu proceso de selección te ha solicitado realizar tu '.$configuracion_sst->titulo_boton_envio_proceso.', por lo tanto te invitamos a que sigas los pasos a continuación para realizar tu proceso de manera exitosa:
            <br/><br/>
                <b style="color:red;">PASO 1:</b> Ver material de estudio para poder realizar la evaluación correspondiente.<br>'.$texto_material
                    
            .'<br/><br/>
                <b style="color:red;">PASO 2:</b> Una vez leída y comprendida la información estarás listo para ingresar a nuestra plataforma y responder la <b>EVALUACIÓN</b>.
            <br/><br/>
               <b style="color:red;">ANTES DE INGRESAR A LA PLATAFORMA DEBES TENER EN CUENTA:</b>
            <br/><br/>
                <ul style="color:#555555;">
                    <li>
                        Recuerda que debes iniciar sesión dando clic en <b>“REALIZAR EVALUACIÓN”</b> ingresando tu documento de identidad como usuario y contraseña (Favor escribe tu número de identificación sin puntos ni comas) Ejemplo: USUARIO: 1044421101 CONTRASEÑA: 1044421101
                    </li>

                    <li>
                        Una vez que hayas logrado tu <b>felicitación</b> harás clic en <b>FIRMAR</b>.
                    </li>

                    <li>
                        Si firmaste tu inducción has finalizado la misma, ahora favor dar click en <b>CONTINUAR</b>.
                    </li>
                </ul>
            ';

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'Realizar Evaluación', 'buttonRoute' => route('realizar_evaluacion_induccion_sst', ['req_id' => $candidato->requerimiento_id])];

        $mailUser = $candidato->user_id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($candidato, $asunto) {
            $message->to([$candidato->email])
            ->subject($asunto)
            ->getHeaders()
            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        return response()->json([
            "success" => true,
            "text_estado" => $estado->descripcion,
            'candidato_req' => $data->get("candidato_req"),
            "id_proceso" => $id_proceso,
            "view" => 'Enviado...'
        ]);
    }

    public function enviar_evaluacion_sst_masivo_view(Request $data) {
        $candidatos = collect([]);
        $req_can_ids = [];

        $configuracion_sst = EvaluacionSstConfiguracion::first();

        foreach($data->req_candidato as $key => $req_candi_id) {
            $req_can_ids[] = $req_candi_id;
        }

        $candidatos = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->whereIn("requerimiento_cantidato.id", $req_can_ids)
            ->select(
                "datos_basicos.*",
                "requerimiento_cantidato.id as req_candidato",
                "requerimiento_cantidato.requerimiento_id as req"
            )
        ->get();

        $req_can_ids = json_encode($req_can_ids);

        return response()->json([
            "success" => true,
            "view"   => view("admin.reclutamiento.modal.envio_evaluacion_sst_masivo", compact('candidatos', 'req_can_ids', 'configuracion_sst'))->render()
        ]);
    }

    public function confirmar_envio_evaluacion_sst_masivo(Request $data)
     {
         try {
            $nueva_entrevista = null;
            $candidatos_no_enviados = [];
            $configuracion_sst = EvaluacionSstConfiguracion::first();

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

                $proceso_sst = RegistroProceso::where("requerimiento_candidato_id", $req_candi_id)
                    ->whereIn("proceso", ["ENVIO_SST"])
                ->first();

                if ($proceso_sst != null) {
                    array_push($candidatos_no_enviados, "$candidato->numero_id $candidato->nombres");
                } else {
                    $nuevo_proceso = new RegistroProceso();

                    $nuevo_proceso->fill([
                        'requerimiento_candidato_id' => $req_candi_id,
                        'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        'usuario_envio'              => $this->user->id,
                        'requerimiento_id'           => $candidato->req_id,
                        'candidato_id'               => $candidato->user_id,
                        'proceso'                    => "ENVIO_SST",
                        'fecha_inicio'               => date("Y-m-d H:i:s")
                    ]);
                    $nuevo_proceso->save();

                    //se le envia correo a candidato con el folleto a leer
                    //correo con enlace
                    $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                    $mailConfiguration = 1; //Id de la configuración
                    $mailTitle = ""; //Titulo o tema del correo

                    $nombre_completo = $candidato->nombres.' '. $candidato->primer_apellido.' '.$candidato->segundo_apellido;

                    //Cuerpo con html y comillas dobles para las variables
                    $mailBody = '
                        Buen dia,
                        <br/>

                        Hola '.$nombre_completo.' te informamos que nuestro <b>Administrador de Riesgo</b> de <b>AYUDA TEMPORAL DEL CARIBE S.A</b> te invita a que leas detalladamente los documentos adjuntos y las instrucciones que te entregaremos a continuación para realizar tu inducción de SST de manera exitosa así:
                        <br/><br/>
                            <b style="color:red;">PASO 1:</b> Ver video de inducción para poder realizar la evaluación correspondiente. <a href="'.asset("VIDEO_IDUCCION.mp4").'" target="_blank" style="color:red;"> Video de Inducción</a>
                        <br/><br/>
                            <b style="color:red;">PASO 2:</b> Leer detenidamente el material informativo adjunto a éste correo, el cual será de gran apoyo para realizar su evaluación, y especialmente para identificar y prevenir los riesgos labores durante el desarrollo de sus futuras actividades.
                        <br/><br/>
                            <b style="color:red;">PASO 3:</b> Una vez leída y comprendida la información estarás listo para ingresar a nuestra plataforma y responder la <b>EVALUACIÓN</b>.
                        <br/><br/>
                           <b style="color:red;">ANTES DE INGRESAR A LA PLATAFORMA DEBES TENER EN CUENTA:</b>
                        <br/><br/>
                            <ul style="color:#555555;">
                                <li>Existen preguntas que tienen más de una opción de respuesta, selecciona la respuesta según lo estudiado en video y adjuntos.
                                </li>

                                <li>Para aprobar ésta evaluación debes lograr un porcentaje igual o superior al '. $configuracion_sst->minimo_aprobacion .'%, al  finalizar la misma encontraras un botón  que te indica  <b>GUARDAR</b>,  posterior recibirás una <b>Felicitación</b> con el puntaje de aprobación.
                                </li>

                                <li>
                                    En caso de no aprobar la evaluación tendrás 2 nuevos intentos en el mismo día.
                                </li>

                                <li>
                                    Una vez que hallas logrado tu <b>felicitación</b> harás click en <b>FIRMAR</b>
                                </li>

                                <li>
                                    Si firmaste tu inducción has finalizado la misma, ahora favor dar click en CONTINUAR.
                                </li>
                            </ul>
                        <p style="color:#555555;">
                        <b style="color:red;">PASO 4:</b> Después de comprender las instrucciones te damos la Bienvenida a la plataforma:
                        </p>
                            <ul style="color:#555555;">
                                <li>
                                    Iniciar sesión dando un click en <b>“REALIZAR EVALUACIÓN”</b> ingresando tu documento de identidad  como usuario y a su vez  como contraseña (Favor escribe tu número de identificación sin puntos ni comas) Ejemplo:  USUARIO: 1044421101  CONTRASEÑA: 1044421101
                                </li>
                            </ul>
                        ';

                    //Arreglo para el botón
                    $mailButton = ['buttonText' => 'Realizar Evaluación Inducción', 'buttonRoute' => route('realizar_evaluacion_induccion_sst', ['req_id' => $candidato->req_id])];

                    $mailUser = $candidato->user_id; //Id del usuario al que se le envía el correo

                    $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                    Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($candidato) {
                        $message->to([$candidato->email], "Ayudatemporal")
                        ->subject("INDUCCIÓN DE SST")
                        //->attach(public_path('FOLLETO_SST.pdf'))
                        //->attach(public_path('INFOGRAFIA_EPP.pdf'))
                        //->attach(public_path('LAVADO_MANOS.pdf'))
                        //->attach(public_path('DISTANCIAMIENTO_2MTS.png'))
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                }
            }

            return response()->json([
                "success" => true, "candidatos_no_enviados" => $candidatos_no_enviados
            ]);
        } catch (\Exception $e) {
            logger('Excepción capturada en ReclutamientoController @confirmar_evaluacion_sst_masivo: '.  $e->getMessage(). "\n");

            return response()->json([
                "success" => false, "view" => "Ha ocurrido un error. Recargue la página e intente nuevamente, si el problema persiste contacte a soporte."
            ]);
        }
     }

    public function generar_carnet_general($id,$download=0)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join("users", "users.id", "=", "datos_basicos.user_id")
        ->where("datos_basicos.user_id", $id)
        ->select(
            "datos_basicos.*",
            "requerimiento_cantidato.id as req_candidato",
            "requerimiento_cantidato.requerimiento_id as req",
            "users.foto_perfil",
            "users.avatar"
        )
        ->orderBy("requerimiento_cantidato.id", "DESC")
        ->first();

        $contrato = "";

        $req = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
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
            "requerimientos.id as req_id"
        )
        ->groupBy('requerimientos.id')
        ->find($candidato->req);
        
        //empresa contrata aqui
        if($req->empresa_contrata){
            $empresa = DB::table("empresa_logos")->where('id', $req->empresa_contrata)->first();
        }


        $qrcode = base64_encode(\QrCode::format('png')->size(200)->errorCorrection('H')->generate(route('informacionTrabajador', ['id' => $id])));


        //  $motivos = ["" => "Seleccionar"] + MotivosRechazos::pluck("descripcion", "id")->toArray();
        $view = \SnappyPDF::loadView('home.carnet_candidato_general', ['candidato'=>$candidato, 'req'=>$req, 'contrato'=>$contrato, 'empresa'=>$empresa, 'qrcode'=>$qrcode]);;
        //$pdf =  app('dompdf.wrapper');
        //$pdf->loadHTML($view);

        if($download){

            
            return $view->output();

        }
        else{
            return $view->stream('prueba.pdf');
        }

        
    }

    public function enviar_entrevista_multiple_view(Request $data)
    {
        $candidatos = collect([]);
        $req_can_ids = [];

        foreach($data->req_candidato as $key => $req_candi_id) {
            $req_can_ids[] = $req_candi_id;
        }

        $candidatos = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->whereIn("requerimiento_cantidato.id", $req_can_ids)
            ->select(
                "datos_basicos.*",
                "requerimiento_cantidato.id as req_candidato",
                "requerimiento_cantidato.requerimiento_id as req"
            )
        ->get();

        $req_can_ids = json_encode($req_can_ids);

        return response()->json([
            "success" => true,
            "view"   => view("admin.reclutamiento.modal.envio_entrevista_multiple", compact('candidatos', 'req_can_ids'))->render()
        ]);
    }

    public function confirmar_entrevista_multiple(Request $data)
    {
        try {
            $nueva_entrevista = null;
            $candidatos_no_enviados = [];
            $entrevista_creada = false;
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

                $proceso_ent_multiple = RegistroProceso::where("requerimiento_candidato_id", $req_candi_id)
                    ->whereIn("proceso", ["ENTREVISTA_MULTIPLE"])
                ->first();

                if ($proceso_ent_multiple != null) {
                    array_push($candidatos_no_enviados, "$candidato->numero_id $candidato->nombres");
                } else {
                    if (!$entrevista_creada) {
                        //Se crea una unica Entrevista Multiple
                        $nueva_entrevista = new EntrevistaMultiple();
                        $nueva_entrevista->fill([
                            'titulo'            => $data->titulo,
                            'descripcion'       => $data->descripcion,
                            'req_id'            => $candidato->req_id,
                            'usuario_envio'     => $this->user->id
                        ]);
                        $nueva_entrevista->save();
                        $entrevista_creada = true;
                    }

                    if ($entrevista_creada) {
                        $nuevo_proceso = new RegistroProceso();

                        $nuevo_proceso->fill([
                            'requerimiento_candidato_id' => $req_candi_id,
                            'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            'usuario_envio'              => $this->user->id,
                            'requerimiento_id'           => $candidato->req_id,
                            'candidato_id'               => $candidato->user_id,
                            'observaciones'              => "Envío a entrevista múltiple",
                            'proceso'                    => "ENTREVISTA_MULTIPLE",
                            'fecha_inicio'               => date("Y-m-d H:i:s")
                        ]);
                        $nuevo_proceso->save();

                        //Se crean N Detalles de la Entrevista Multiple
                        $ent_multiple_detalles = new EntrevistaMultipleDetalles();
                        $ent_multiple_detalles->fill([
                            'entrevista_multiple_id'    => $nueva_entrevista->id,
                            'req_candi_id'              => $req_candi_id,
                            'req_id'                    => $candidato->req_id,
                            'candidato_id'              => $candidato->user_id
                        ]);
                        $ent_multiple_detalles->save();
                    }
                }
            }

            return response()->json([
                "success" => true, "candidatos_no_enviados" => $candidatos_no_enviados
            ]);
        } catch (\Exception $e) {
            logger('Excepción capturada en ReclutamientoController @confirmar_entrevista_multiple: '.  $e->getMessage(). "\n");

            return response()->json([
                "success" => false, "view" => "Ha ocurrido un error. Recargue la página e intente nuevamente, si el problema persiste contacte a soporte."
            ]);
        }
    }

    public function aprobar_cliente_admin(Request $request) {
        $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->whereRaw(" (procesos_candidato_req.apto is null )  ")
            ->whereIn("requerimiento_cantidato.estado_candidato", [7,8,11,25])
            ->whereIn("procesos_candidato_req.estado", [7,8,11,25])
            ->where(function ($sql) use ($request) {
                //Filtro por codigo requerimiento
                if ($request->codigo != "") {
                    $sql->where("requerimiento_cantidato.requerimiento_id", $request->codigo);
                }

                //Filtro por cedula de candidato
                if ($request->cedula != "") {
                    $sql->where("datos_basicos.numero_id", $request->cedula);
                }
            })
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_APROBAR_CLIENTE"])
            ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente'
            )
            ->paginate(10);

        return view("admin.reclutamiento.aprobar_cliente_admin", compact("candidatos"));
    }

    public function gestionar_aprobar_cliente_admin($id) {
        $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = '' )")
            ->where("procesos_candidato_req.id", $id)
            ->select("procesos_candidato_req.requerimiento_candidato_id",
                "procesos_candidato_req.id as ref_id", "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente')
            ->first();

        if ($candidato == null) {
            return redirect()->route("admin.aprobar_cliente_admin");
        }

        $soporte_aprobacion = Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
            ->where("documentos.user_id", $candidato->candidato_id)
            ->where("documentos.requerimiento", $candidato->requerimiento_id)
            ->where("tipos_documentos.id", config('conf_aplicacion.C_SOPORTE_APROBACION_CLIENTE'))
            ->select("documentos.*", 
                "tipos_documentos.descripcion as tipo_doc")
            ->orderBy("documentos.created_at","desc")
        ->get();

        $estados_procesos_referenciacion = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_APROBAR_CLIENTE"])->get();

        return view("admin.reclutamiento.gestionar_aprobar_cliente_admin", compact("candidato", "estados_procesos_referenciacion", "soporte_aprobacion"));
    }

    public function nuevo_soporte_aprobacion(Request $request)
    {
        $tipo = config('conf_aplicacion.C_SOPORTE_APROBACION_CLIENTE');

        $orden = $request->ref_id;

        return view("admin.reclutamiento.modal.nuevo_soporte_aprobacion", compact("tipo","orden"));
    }

    public function guardar_soporte_aprobacion(Request $data, Requests\AdminNuevoSoporteAprobacionRequest $valida)
    {
        $proceso = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "procesos_candidato_req.candidato_id")
        ->select("procesos_candidato_req.*", "datos_basicos.numero_id")
        ->where("procesos_candidato_req.id", $data->ref_id)
        ->first();

        $documentos = new Documentos();
        $documentos->fill($data->all() + [
            "user_id" => $proceso->candidato_id,
            "gestiono" => $this->user->id,
            "requerimiento" => $proceso->requerimiento_id,
            "tipo_documento_id" => config('conf_aplicacion.C_SOPORTE_APROBACION_CLIENTE'),
            "numero_id" => $proceso->numero_id
        ]);
        $documentos->save();

        if ($data->hasFile('archivo_soporte')) {
            $archivo        = $data->file("archivo_soporte");
            $extension      = $archivo->getClientOriginalExtension();
            $name_documento = "documento_soporte_aprobacion_" . $documentos->id . "." . $extension;

            $archivo->move("recursos_documentos_verificados", $name_documento);
            $documentos->nombre_archivo = $name_documento;
            $documentos->descripcion_archivo = 'Soporte de aprobación del cliente.';
        }
        $documentos->save();

        //GUARDAR_ RELACION DOCUMENTO REQUERIMIENTO
        $this->procesoRequerimiento($documentos->id, $data->ref_id, "MODULO_DOCUMENTO");

        return response()->json(["success" => true]);
    }

    public function enviarVisitaDomiciliariaView(Request $data)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $data->get("candidato_req"))
        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
        ->first();

        $tipo_visita=[""=>"Seleccionar"]+DB::table("clase_visita")->pluck("descripcion","id")->toArray();

        return view("admin.reclutamiento.modal.enviar_visita_domiciliaria_view", compact("candidato","tipo_visita"));
    }
    public function confirmarVisitaDomiciliaria(Request $data){
        $proceso = "VISITA_DOMICILIARIA";


        $campos = [
            'requerimiento_candidato_id' => $data->get("candidato_req"),
            'usuario_envio'              => $this->user->id,
            "fecha_inicio"               => date("Y-m-d H:i:s"),
            "clase_visita"               => $data->get("clase_visita"),
            'proceso'                    => $proceso,
        ];

        $candidato_req=reqCandidato::join("datos_basicos","datos_basicos.user_id","=","requerimiento_cantidato.candidato_id")
        ->join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
        ->where("requerimiento_cantidato.id",$data->get("candidato_req"))
        ->select("datos_basicos.nombres","datos_basicos.primer_apellido","datos_basicos.email","requerimiento_cantidato.requerimiento_id","requerimiento_cantidato.candidato_id as candidato","requerimientos.tipo_visita_id")
        ->first();

        $id_proceso = $this->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));


            $nueva_visita= new VisitaCandidato();
            $nueva_visita->candidato_id=$candidato_req->candidato;
            $nueva_visita->requerimiento_id=$candidato_req->requerimiento_id;
            $nueva_visita->tipo_visita_id=$candidato_req->tipo_visita_id;
            $nueva_visita->clase_visita_id=$data->get("clase_visita");
            $nueva_visita->save();

            $nueva_visita_admin= new VisitaAdmin();
            $nueva_visita_admin->visita_candidato_id=$nueva_visita->id;
            $nueva_visita_admin->requerimiento_id=$candidato_req->requerimiento_id;
            $nueva_visita_admin->candidato_id=$candidato_req->candidato;
            $nueva_visita_admin->tipo_visita_id=$candidato_req->tipo_visita_id;
            $nueva_visita_admin->clase_visita_id=$data->get("clase_visita");
            $nueva_visita_admin->save();

            $proceso=RegistroProceso::find($id_proceso);
            $proceso->visita_candidato_id=$nueva_visita->id;
            $proceso->save();

        //ENVIAR CORREO
        $asunto = "Notificación de visita domiciliaria";
                        
                        $emails = $candidato_req->email;
                        $email_sin_espacio = trim($emails);
                        $urls=route("realizar_form_visita_domiciliaria",["visita_id"=>$nueva_visita->id]);

                        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                        $mailConfiguration = 1; //Id de la configuración
                        $mailTitle = ""; //Titulo o tema del correo

                        //Cuerpo con html y comillas dobles para las variables
                        $mailBody = "Buen día ".$candidato_req->nombres." ".$candidato_req->primer_apellido.", le informamos que se ha programado una visita domiciliaria a realizarse en los próximos días. Debe ingresar haciendo clic en el siguiente botón para gestionar un formulario con algunas preguntas previas a la visita. 
                            <br/><br/>";

                        //Arreglo para el botón
                        $mailButton = ['buttonText' => 'Formulario', 'buttonRoute' => $urls];

                        $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

                        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($data, $emails, $asunto, $nombre) {

                                $message->to($emails, "$nombre - T3RS")->subject($asunto)
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                            });

        return response()->json([
            "success" => true,
            'candidato_req' => $data->get("candidato_req"),
            'id_proceso' => $id_proceso
        ]);

    }
}