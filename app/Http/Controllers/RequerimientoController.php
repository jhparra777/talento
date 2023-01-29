<?php

namespace App\Http\Controllers;

use DateTime;
use SoapClient;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User as EloquentUser;
use Illuminate\Support\Facades\Mail;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Event;
use App\Facade\QueryAuditoria;
use App\Jobs\FuncionesGlobales;

use App\Http\Requests\NuevoRequerimientoRequest;
use App\Http\Requests\RequerimientoRequest;
use App\Jobs\SendPostCreateReqEmail;
use App\Models\PruebaExcelConfiguracion;
use App\Models\Atributo;
use App\Models\AtributoSelect;
use App\Models\Agencia;
use App\Models\AgenciaUsuario;
use App\Models\Auditoria;
use App\Models\CandidatosFuentes;
use App\Models\CargoEspecifico;
use App\Models\CargoGenerico;
use App\Models\CentroCostoProduccion;
use App\Models\CentroTrabajo;
use App\Models\Ciudad;
use App\Models\Clientes;
use App\Models\ConceptoPago;
use App\Models\EstadoCivil;
use App\Models\Estados;
use App\Models\Respuesta;
use App\Models\EstadosRequerimientos;
use App\Models\Ficha;
use App\Models\Genero;
use App\Models\LineaServicio;
use App\Models\Localidad;
use App\Models\Menu;
use App\Models\MotivoRequerimiento;
use App\Models\Negocio;
use App\Models\NivelEstudios;
use App\Models\Requerimiento;
use App\Models\Sociedad;
use App\Models\TipoContrato;
use App\Models\TipoExperiencia;
use App\Models\TipoJornada;
use App\Models\TipoLiquidacion;
use App\Models\TipoNegocio;
use App\Models\TipoNomina;
use App\Models\TipoProceso;
use App\Models\TipoSalario;
use App\Models\UnidadNegocio;
use App\Models\Preperfilados;
use App\Models\ReqPreg;
use App\Models\ReqCandidato;
use App\Models\UserClientes;
use App\Models\User;
use App\Models\SolicitudSedes;
use App\Models\SolicitudAreaFuncional;
use App\Models\SolicitudSubArea;
use App\Models\SolicitudCentroBeneficio;
use App\Models\SolicitudCentroCosto;
use App\Models\Solicitudes;
use App\Models\SolicitudRecursos;
use App\Models\CentrosCostos;
use App\Models\NegocioANS;
use App\Models\Facturacion;
use App\Models\MotivosRechazos;
use App\Models\DatosBasicos;
use App\Models\MotivoRechazoCandidato;
use App\Models\RegistroProceso;
use App\Models\EmpresaLogo;
use App\Models\NivelIdioma;
use App\Models\Sitio;
use App\Models\SitioModulo;
use App\Models\CargoEspecificoConfigPruebas;
use App\Models\PruebaValoresConfigRequerimiento;
use App\Models\DocumentoAdicional;
use App\Models\ClausulaValorRequerimiento;
use App\Models\TipoVisita;
use App\Models\TipoEstudioVirtualSeguridad;

use Illuminate\Support\Facades\Validator;
use App\Models\ListaNegra;
use triPostmaster;

class RequerimientoController extends Controller
{
    protected $estados_no_muestra = [];

    public function __construct()
    {
        parent::__construct();

        $this->estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
        ]; //SON LOS ESTADOS PARA NO MOSTRAR EL CANDIDATO EN EL  REQUERIMIENTO
    }

    public function index()
    {
        $colores = ["#0d6efd", "#198754", "#f39c12", "#dc3545", "#8e44ad", "#c0392b"];

        $idsHijos      = new FuncionesGlobales();
        $usuariosHijos = $idsHijos->usuariosHijos($this->user->id);
        
        $usuarios      = User::whereIn("users.id", $usuariosHijos)
        //->select("users.*", "users.estado as estado_session")
        ->count();
        
        $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes","clientes.id", "=", "negocio.cliente_id")
        ->join("users_x_clientes","users_x_clientes.cliente_id", "=", "clientes.id")
        ->join("estados_requerimiento","estados_requerimiento.req_id","=","requerimientos.id")
        ->whereIn("estados_requerimiento.estado",[
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
        ])
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
        ->where("users_x_clientes.user_id", $this->user->id)
        ->select(
            "requerimientos.num_vacantes as numero_vacantes",
            "requerimientos.fecha_ingreso as fecha_ingreso",
            DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion')
        )
        ->get();

        $fecha_hoy = Carbon::now();

        $fecha_hoy = $fecha_hoy->format('Y-m-d');
       
        $num_req_a = $requerimientos->count();
        $numero_vacantes = $requerimientos->sum("numero_vacantes");

        $num_vac_ven = $requerimientos->filter(function ($value) use ($fecha_hoy) {
            return $value->fecha_ingreso < $fecha_hoy;
        })->sum("numero_vacantes");

        $num_can_con = $requerimientos->sum("cant_enviados_contratacion");

        $clientes = Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
        ->where("users_x_clientes.user_id", $this->user->id)
        ->count();

        $conteos = ["req.usuarios" => $usuarios, "req.mis_requerimiento" => $num_req_a, "req.mostrar_clientes" => $clientes];

        $menu = Menu::where("modulo", "req")->where("tipo", "view")->where("padre_id", 0)->where('active', 1)->get();
        $cerroMatozo = 0;
        $usuario = Sentinel::getUser();

        return view("req.index", compact(
            "menu",
            "colores",
            "conteos",
            "num_req_a",
            "numero_vacantes",
            "num_vac_ven",
            "num_can_con",
            "cerroMatozo",
            "usuario"
        ));
    }

    public function usuarios(Request $data)
    {
        $idsHijos = new FuncionesGlobales();

        $usuarios = User::where(function ($sql) use ($data) {
            if ($data->has("nombre") && $data->get("nombre") != "") {
                $sql->where("users.name", "like", "%" . $data->get("nombre") . "%");
            }

            if ($data->has("email") && $data->get("email") != "") {
                $sql->where("users.email", "like", "%" . $data->get("email") . "%");
            }
        })->whereIn("users.id", $idsHijos->usuariosHijos($this->user->id))
        ->select("users.*", "users.estado as estado_session")
        ->get();

        $cerroMatozo=0;
        if(route("home")=="https://listos.t3rsc.co"){
             $cerroMatozo = User::
            join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->where('users.id', $this->user->id)
            ->where('users_x_clientes.cliente_id',168)
            ->count();
        }

      return view("req.usuarios", compact("usuarios","cerroMatozo"));
    }

    public function requerimientos(Request $data)
    {
        return view("req.requerimiento");
    }

    public function reporte(Request $data)
    {
        return view("req.reporte");
    }

    public function permiso_negado()
    {
        return view("req.permiso_negado");
    }

    public function consultar_negocio_admin(Request $data)
    {
        $clientes = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
            ->where("users_x_clientes.user_id", $this->user->id)
            ->orderBy("clientes.nombre", "ASC")
            ->pluck("clientes.nombre", "clientes.id")
            ->toArray();

        $sociedades = ["" => "Seleccionar"] + Sociedad::where("division_geren_codigo", config("conf_aplicacion.division_geren_codigo"))
            ->orderBy("division_nombre", "ASC")
            ->pluck("division_nombre", "division_codigo")
            ->toArray();

        $localidades = ["" => "Seleccionar"] + Localidad::pluck("nombre", "codigo")
            ->toArray();

        $tipos_negocios = ["" => "Seleccionar"] + TipoNegocio::pluck("nombre", "codigo")
            ->toArray();

        $linea_servicios = ["" => "Seleccionar"] + LineaServicio::select("id", DB::raw("upper(nombre) as nombre"), "codigo")
            ->pluck("nombre", "id")
            ->toArray();

        $unidad_negocios = ["" => "Seleccionar"] + UnidadNegocio::select(DB::raw("upper(nombre) as nombre"), "codigo")
            ->pluck("nombre", "codigo")
            ->toArray();

        $negocios = Negocio::join("sociedades", "negocio.sociedad", "=", "sociedades.division_codigo")
        ->join("localidades", "negocio.localidad", "=", "localidades.codigo")
        ->join("tipo_negocios", "negocio.tipo_negocio", "=", "tipo_negocios.codigo")
        ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "negocio.cliente_id")
        ->where("users_x_clientes.user_id", $this->user->id)
        //->where("sociedades.division_geren_codigo", config("conf_aplicacion.DIVISION_GEREN_CODIGO"))
        ->where("negocio.estado",1)
        ->select("sociedades.division_nombre", "negocio.tipo_jornada_id", "negocio.nombre_negocio", "localidades.nombre as localidad", "tipo_negocios.nombre as tipo_negocio", "negocio.num_negocio", "negocio.cliente_id", "negocio.id", "negocio.sociedad")
        ->where(function ($query) use ($data) {
            if($data->has("cliente_id") && $data->get("cliente_id")){
                $query->where("negocio.cliente_id", $data->get("cliente_id"));
            }
            if($data->has("num_negocio") && $data->get("num_negocio")){
                $query->where("negocio.num_negocio", $data->get("num_negocio"));
            }
            if($data->has("sociedad_id") && $data->get("sociedad_id")){
                $query->where("negocio.sociedad", $data->get("sociedad_id"));
            }
            if ($data->has("agencia_id") && $data->get("agencia_id")){
                $query->where("negocio.localidad", $data->get("agencia_id"));
            }
            if($data->has("linea_servicio_id") && $data->get("linea_servicio_id")){
                $query->where("negocio.linea_servicio", $data->get("linea_servicio_id"));
            }
            if($data->has("tipo_negocio_id") && $data->get("tipo_negocio_id")){
                $query->where("negocio.tipo_negocio", $data->get("tipo_negocio_id"));
            }
            if($data->has("unidad_negocio_id") && $data->get("unidad_negocio_id")){
                $query->where("negocio.unidad_negocio", $data->get("unidad_negocio_id"));
            }
        })
        ->take(10)
        ->orderBy("negocio.cliente_id", "DESC")
        ->groupBy("negocio.id")
        ->get();

        return view("admin.consultar-negocio-new", compact(
            "clientes",
            "negocios",
            "sociedades",
            "localidades",
            "tipos_negocios",
            "linea_servicios",
            "unidad_negocios"
        ));
    }

    public function consultar_negocio(Request $data)
    {
        $clientes = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
            ->where("users_x_clientes.user_id", $this->user->id)
            ->orderBy("clientes.nombre", "ASC")
            ->pluck("clientes.nombre", "clientes.id")
            ->toArray();

        $sociedades = ["" => "Seleccionar"] + Sociedad::where("division_geren_codigo", config("conf_aplicacion.division_geren_codigo"))
            ->orderBy("division_nombre", "ASC")
            ->pluck("division_nombre", "division_codigo")
            ->toArray();

        $localidades = ["" => "Seleccionar"] + Localidad::pluck("nombre", "codigo")
            ->toArray();

        $tipos_negocios = ["" => "Seleccionar"] + TipoNegocio::pluck("nombre", "codigo")
            ->toArray();

        $linea_servicios = ["" => "Seleccionar"] + LineaServicio::select("id", DB::raw("upper(nombre) as nombre"), "codigo")
            ->pluck("nombre", "id")
            ->toArray();

        $unidad_negocios = ["" => "Seleccionar"] + UnidadNegocio::select(DB::raw("upper(nombre) as nombre"), "codigo")
            ->pluck("nombre", "codigo")
            ->toArray();

        $negocios = Negocio::join("sociedades", "negocio.sociedad", "=", "sociedades.division_codigo")
        ->join("localidades", "negocio.localidad", "=", "localidades.codigo")
        ->join("tipo_negocios", "negocio.tipo_negocio", "=", "tipo_negocios.codigo")
        ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "negocio.cliente_id")
        ->where("users_x_clientes.user_id", $this->user->id)
        ->where("negocio.estado",1)

        //->where("sociedades.division_geren_codigo", config("conf_aplicacion.DIVISION_GEREN_CODIGO"))
        ->select("sociedades.division_nombre", "negocio.tipo_jornada_id", "negocio.nombre_negocio", "localidades.nombre as localidad", "tipo_negocios.nombre as tipo_negocio", "negocio.num_negocio", "negocio.cliente_id", "negocio.id", "negocio.sociedad")
        ->where(function ($query) use ($data) {
            if ($data->has("cliente_id") && $data->get("cliente_id")) {
                $query->where("negocio.cliente_id", $data->get("cliente_id"));
            }
            if ($data->has("num_negocio") && $data->get("num_negocio")) {
                $query->where("negocio.num_negocio", $data->get("num_negocio"));
            }
            if ($data->has("sociedad_id") && $data->get("sociedad_id")) {
                $query->where("negocio.sociedad", $data->get("sociedad_id"));
            }
            if ($data->has("agencia_id") && $data->get("agencia_id")) {
                $query->where("negocio.localidad", $data->get("agencia_id"));
            }
            if ($data->has("linea_servicio_id") && $data->get("linea_servicio_id")) {
                $query->where("negocio.linea_servicio", $data->get("linea_servicio_id"));
            }
            if ($data->has("tipo_negocio_id") && $data->get("tipo_negocio_id")) {
                $query->where("negocio.tipo_negocio", $data->get("tipo_negocio_id"));
            }
            if ($data->has("unidad_negocio_id") && $data->get("unidad_negocio_id")) {
                $query->where("negocio.unidad_negocio", $data->get("unidad_negocio_id"));
            }
        })
        ->take(10)
        ->get();


        $cerroMatozo = 0;
        if(route("home") == "https://listos.t3rsc.co"){
            $cerroMatozo = User::
            join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->where('users.id', $this->user->id)
            ->where('users_x_clientes.cliente_id',168)
            ->count();
        }

        return view("req.consultar_negocio", compact(
            "clientes",
            "negocios",
            "sociedades",
            "localidades",
            "tipos_negocios",
            "linea_servicios",
            "unidad_negocios",
            "cerroMatozo"
        ));
    }
    
    //Lado admin
    public function mis_requerimientos_admin(Request $data)
    {
        $funcionesGlobales = new FuncionesGlobales();

        $rango_fecha = $data->rango_fecha;
        if ($rango_fecha != "") {

              $rango = explode(" | ", $rango_fecha);
              $fecha_inicio = $rango[0];
              $fecha_final  = $rango[1];
        } else {
              $fecha_inicio = '';
              $fecha_final  = '';
        }

        $usuariosHijos = $funcionesGlobales->usuariosHijos($this->user->id);

        $clientes = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
        ->whereIn("users_x_clientes.user_id", $usuariosHijos)
        ->pluck("clientes.nombre", "clientes.id")
        ->toArray();

        $tipoProcesos = \Cache::remember('tipoProcesos','100', function(){
            return ["" => "Seleccionar"] + TipoProceso::where('active', 1)
            ->pluck("descripcion", "id")
            ->toArray();
            });

        $usuarios = ["" => "Seleccionar"] + User::whereIn("id", $usuariosHijos)->pluck("name", "id")->toArray();

        $estados = [
            //config('conf_aplicacion.C_TERMINADO'),
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            // config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
        ];

        if(route('home') != "https://soluciones.t3rsc.co"){
            $estados += [
                config('conf_aplicacion.C_TERMINADO'),
                config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL')
            ];
        }

        $estados_requerimiento = ["" => "Seleccionar"] + Estados::whereIn("id",$estados)
        ->pluck("estados.descripcion","estados.id")
        ->toArray();

        if($data->get('estado_id') != ""){
            $estados = array();
            $estados[] = $data->get('estado_id');
        }
        
        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
            if($this->user->inRole("SUPER ADMINISTRADOR")){
                $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
                ->join("users", "users.id", "=", "requerimientos.solicitado_por")
                ->join("solicitudes","solicitudes.id","=","requerimientos.solicitud_id")
                //->whereIn("users.id", $usuariosHijos)
                //verificar si está en el flujo de aprobación
                ->tipoProceso($data)
                ->where(function ($sql) use ($data) {
                    if($data->has("cliente_id") && $data->get("cliente_id") != "") {
                      $sql->where("clientes.id", $data->get("cliente_id"));
                    }

                    if($data->has("numero_req") && $data->get("numero_req") != "") {
                     $sql->where("requerimientos.id", $data->get("numero_req"));
                    }

                    if ($data->get("fecha_inicio") != "" && $data->get("fecha_fin") != "") {
                        $sql->whereBetween("requerimientos.created_at", [$data->get("fecha_inicio") . ' 00:00:00',  $data->get("fecha_fin") . ' 23:59:59']);
                    }

                    /*if ($data->has("fecha_inicio") && $data->get("fecha_inicio") != "") {
                        $sql->whereRaw("to_date(to_char(requerimientos.created_at,'dd/mm/yyyy')) = '" . $data->get("fecha_inicio") . "'");
                    }

                    if ($data->has("fecha_fin") && $data->get("fecha_fin") != "") {
                        $sql->whereRaw("to_date(to_char(requerimientos.fecha_ingreso,'dd/mm/yyyy')) ='" . $data->get("fecha_fin") . "'");
                    }*/
                })
                ->select(
                    "cargos_especificos.descripcion as cargo",
                    "requerimientos.id", "requerimientos.num_vacantes",
                    "requerimientos.created_at",
                    "requerimientos.fecha_terminacion",
                    "requerimientos.fecha_ingreso",
                    "requerimientos.dias_gestion",
                    "tipo_proceso.descripcion as tipo_proceso_desc",
                    DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales'),
                    "negocio.num_negocio",
                    "clientes.nombre as nombre_cliente",
                    "users.name as nombre_usuario",
                    "requerimientos.id as req_id",
                    "requerimientos.solicitud_id")
                ->groupBy('requerimientos.id')
                ->orderBy("requerimientos.id", "desc")
                ->paginate(10);
            }
            elseif($this->user->inRole("ANALISTA")){
                $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
                ->join("users", "users.id", "=", "requerimientos.solicitado_por")
                ->join("solicitudes","solicitudes.id","=","requerimientos.solicitud_id")
                ->join("asignacion_psicologo","asignacion_psicologo.req_id","=","requerimientos.id")
                //->whereIn("users.id", $usuariosHijos)

                //verificar si está en el flujo de aprobación
                ->where("asignacion_psicologo.psicologo_id",$this->user->id)
                ->tipoProceso($data)
                ->where(function ($sql) use ($data) {
                    if($data->has("cliente_id") && $data->get("cliente_id") != "") {
                        $sql->where("clientes.id", $data->get("cliente_id"));
                    }

                    if($data->has("numero_req") && $data->get("numero_req") != "") {
                        $sql->where("requerimientos.id", $data->get("numero_req"));
                    }

                    if($data->get("fecha_inicio") != "" && $data->get("fecha_fin") != "") {
                    $sql->whereBetween("requerimientos.created_at", [$data->get("fecha_inicio") . ' 00:00:00',  $data->get("fecha_fin") . ' 23:59:59']);
                    }

                    /*if ($data->has("fecha_inicio") && $data->get("fecha_inicio") != "") {
                        $sql->whereRaw("to_date(to_char(requerimientos.created_at,'dd/mm/yyyy')) = '" . $data->get("fecha_inicio") . "'");
                    }

                    if ($data->has("fecha_fin") && $data->get("fecha_fin") != "") {
                        $sql->whereRaw("to_date(to_char(requerimientos.fecha_ingreso,'dd/mm/yyyy')) ='" . $data->get("fecha_fin") . "'");
                    }*/
                })
                ->select(
                    "cargos_especificos.descripcion as cargo",
                    "requerimientos.id",
                    "requerimientos.num_vacantes",
                    "requerimientos.created_at",
                    "requerimientos.fecha_terminacion",
                    "requerimientos.fecha_ingreso",
                    "requerimientos.dias_gestion",
                    "tipo_proceso.descripcion as tipo_proceso_desc",
                    "negocio.num_negocio",
                    "clientes.nombre as nombre_cliente",
                    "users.name as nombre_usuario",
                    DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales'),
                    "requerimientos.id as req_id",
                    "requerimientos.solicitud_id")
                ->groupBy('requerimientos.id')
                ->orderBy("requerimientos.id", "desc")
                ->paginate(10);
            }else{
                $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
                ->join("users", "users.id", "=", "requerimientos.solicitado_por")
                ->join("solicitudes","solicitudes.id","=","requerimientos.solicitud_id")
                ->join("solicitud_user_paso","solicitud_user_paso.user_solicitante","=","solicitudes.user_id")
                //->whereIn("users.id", $usuariosHijos)
                //verificar si está en el flujo de aprobación
                ->where("solicitud_user_paso.user_solicitante","=",$this->user->id)
                ->orWhere("solicitud_user_paso.user_valora","=",$this->user->id)
                ->orWhere("solicitud_user_paso.user_jefe_solicitante","=",$this->user->id)
                ->orWhere("solicitud_user_paso.user_gerente_area","=",$this->user->id)
                ->orWhere("solicitud_user_paso.user_rhh","=",$this->user->id)
                ->orWhere("solicitud_user_paso.user_gg","=",$this->user->id)
                ->tipoProceso($data)
                ->where(function ($sql) use ($data) {
                    if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                        $sql->where("clientes.id", $data->get("cliente_id"));
                    }

                    if ($data->has("numero_req") && $data->get("numero_req") != "") {
                        $sql->where("requerimientos.id", $data->get("numero_req"));
                    }

                    if ($data->get("fecha_inicio") != "" && $data->get("fecha_fin") != "") {
                        $sql->whereBetween("requerimientos.created_at", [$data->get("fecha_inicio") . ' 00:00:00',  $data->get("fecha_fin") . ' 23:59:59']);
                    }

                    /*if ($data->has("fecha_inicio") && $data->get("fecha_inicio") != "") {
                        $sql->whereRaw("to_date(to_char(requerimientos.created_at,'dd/mm/yyyy')) = '" . $data->get("fecha_inicio") . "'");
                    }

                    if ($data->has("fecha_fin") && $data->get("fecha_fin") != "") {
                        $sql->whereRaw("to_date(to_char(requerimientos.fecha_ingreso,'dd/mm/yyyy')) ='" . $data->get("fecha_fin") . "'");
                    }*/

                })
                ->select(
                    "cargos_especificos.descripcion as cargo",
                    "requerimientos.id",
                    "requerimientos.num_vacantes",
                    "requerimientos.created_at",
                    "requerimientos.fecha_terminacion",
                    "requerimientos.fecha_ingreso",
                    "requerimientos.dias_gestion",
                    "tipo_proceso.descripcion as tipo_proceso_desc",
                    "negocio.num_negocio",
                    "clientes.nombre as nombre_cliente",
                    "users.name as nombre_usuario",
                    "requerimientos.id as req_id",
                    DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales'),
                    "requerimientos.solicitud_id")
                ->groupBy('requerimientos.id')
                ->orderBy("requerimientos.id", "desc")
                ->paginate(10);
            }
        }
        elseif(route("home") == "http://vym.t3rsc.co" || route("home") == "https://vym.t3rsc.co" ||
            route("home") == "https://tiempos.t3rsc.co" || route("home") == "http://tiempos.t3rsc.co" ||
            route("home") == "http://listos.t3rsc.co" || route("home") == "https://listos.t3rsc.co" ||
            route("home") == "https://pruebaslistos.t3rsc.co"){
           
            $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->leftjoin("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            ->join("users", "users.id", "=", "requerimientos.solicitado_por")
            //->whereIn("users.id", $usuariosHijos)
            ->join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->join('departamentos', function ($join2) {
                $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
            })
            ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
            ->whereIn("ciudad.agencia", $this->user->agencias())
            ->where("users_x_clientes.user_id", $this->user->id)
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->tipoProceso($data)
            ->where(function ($sql) use ($data,&$estados) {
                if($data->has("cliente_id") && $data->get("cliente_id") != "") {

                   $sql->where("clientes.id", $data->get("cliente_id"));
                }

                if($data->has("numero_req") && $data->get("numero_req") != "") {
                    $estados[]=config('conf_aplicacion.C_TERMINADO');

                    $sql->where("requerimientos.id", $data->get("numero_req"));
                }

                if($data->get("fecha_inicio") != "" && $data->get("fecha_fin") != "") {
                  
                  $sql->whereBetween("requerimientos.created_at", [$data->get("fecha_inicio") . ' 00:00:00',  $data->get("fecha_fin") . ' 23:59:59']);
                }

                if($data["ciudad_id"] != ""){

                  $sql->where('requerimientos.ciudad_id',$data->get("ciudad_id"));

                }
                    
                if($data["departamento_id"] != ""){

                  $sql->where('requerimientos.departamento_id',$data->get("departamento_id"));

                }

                /*if ($data->has("fecha_inicio") && $data->get("fecha_inicio") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.created_at,'dd/mm/yyyy')) = '" . $data->get("fecha_inicio") . "'");
                }

                if ($data->has("fecha_fin") && $data->get("fecha_fin") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.fecha_ingreso,'dd/mm/yyyy')) ='" . $data->get("fecha_fin") . "'");
                }*/
            })
            ->whereIn("estados_requerimiento.estado", $estados)
            ->select(
                "cargos_especificos.descripcion as cargo",
                "requerimientos.id",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_terminacion",
                "requerimientos.fecha_ingreso",
                "requerimientos.dias_gestion",
                "tipo_proceso.descripcion as tipo_proceso_desc",
                "negocio.num_negocio",
                "clientes.nombre as nombre_cliente",
                "users.name as nombre_usuario",
                DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales'),
                "requerimientos.id as req_id",
                "ciudad.nombre as ciudad")
            ->groupBy('requerimientos.id')
            ->orderBy("requerimientos.id", "desc")
            ->paginate(10);
        }
        else{
            $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->leftjoin("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            ->join("users", "users.id", "=", "requerimientos.solicitado_por")
            ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
            ->join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            /*->join('departamentos', function ($join2) {
                $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
            })*/
            ->where("users_x_clientes.user_id", $this->user->id)
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            //->whereIn("users.id", $usuariosHijos)
            ->tipoProceso($data)
            ->where(function ($sql) use ($data,&$estados, $fecha_inicio, $fecha_final) {
                if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }

                if ($data->has("numero_req") && $data->get("numero_req") != "") {
                    $estados[]=config('conf_aplicacion.C_TERMINADO');

                    $sql->where("requerimientos.id", $data->get("numero_req"));
                }

                if ($fecha_inicio != "" && $fecha_final != "") {
                   
                    $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00',  $fecha_final . ' 23:59:59']);
                }

                if($data["ciudad_id"] != ""){

                  $sql->where('requerimientos.ciudad_id',$data->get("ciudad_id"));
                  $sql->where('requerimientos.departamento_id',$data->get("departamento_id"));
                  $sql->where('requerimientos.pais_id',$data->get("pais_id"));
                }
                    
                /*if($data["departamento_id"] != ""){

                  $sql->where('requerimientos.departamento_id',$data->get("departamento_id"));

                }*/

                /*if ($data->has("fecha_inicio") && $data->get("fecha_inicio") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.created_at,'dd/mm/yyyy')) = '" . $data->get("fecha_inicio") . "'");
                }

                if ($data->has("fecha_fin") && $data->get("fecha_fin") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.fecha_ingreso,'dd/mm/yyyy')) ='" . $data->get("fecha_fin") . "'");
                }*/
            })

            ->whereIn("estados_requerimiento.estado", $estados)
            ->select(
                "cargos_especificos.descripcion as cargo",
                "cargos_especificos.firma_digital as firma_cargo",
                "requerimientos.id",
                "requerimientos.id as req_id",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_terminacion",
                "requerimientos.fecha_ingreso",
                "requerimientos.dias_gestion",
                "tipo_proceso.descripcion as tipo_proceso_desc",
                "negocio.num_negocio",
                "clientes.nombre as nombre_cliente",
                "users.name as nombre_usuario",
                DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and proceso in(\'CANCELA_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales'),
                DB::raw('requerimientos.num_vacantes - (select count(*) from firma_contratos where terminado in(1,2) and estado not in(0) and req_id=requerimientos.id ) as vacantes_reales_asistente'),
                "ciudad.nombre as ciudad")
            ->groupBy('requerimientos.id')
            ->orderBy("requerimientos.id", "desc")
            ->paginate(10);
        }

       return view("admin.mis_requerimientos_new", compact("requerimientos", "clientes", "usuarios","estados_requerimiento", "tipoProcesos"));
    }
    
    //Lado cliente
    public function mis_requerimientos(Request $data)
    {
        $sitio = Sitio::first();
        $funcionesGlobales = new FuncionesGlobales();

        $rango_fecha = $data->rango_fecha;
        if ($rango_fecha != "") {

              $rango = explode(" | ", $rango_fecha);
              $fecha_inicio = $rango[0];
              $fecha_final  = $rango[1];
        } else {
              $fecha_inicio = '';
              $fecha_final  = '';
        }

        $usuariosHijos = $funcionesGlobales->usuariosHijos($this->user->id);

        $clientes = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
        ->whereIn("users_x_clientes.user_id", $usuariosHijos)
        ->orderBy(DB::raw("UPPER(clientes.nombre)"),"ASC")
        ->pluck("clientes.nombre", "clientes.id")
        ->toArray();

        $tipoProcesos = ["" => "Seleccionar"] + TipoProceso::where('active', 1)
        ->pluck("descripcion", "id")
        ->toArray();

        $usuarios = ["" => "Seleccionar"] + User::whereIn("id", $usuariosHijos)->pluck("name", "id")->toArray();

        $estados = [
            config('conf_aplicacion.C_TERMINADO'),
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
        ];
        
        $estados_requerimiento = ["" => "Seleccionar"] + Estados::whereIn("id",$estados)
        ->orderBy(DB::raw("UPPER(estados.descripcion)"),"ASC")
        ->pluck("estados.descripcion","estados.id")->toArray();

        if($data->get('estado_id') != ""){
            $estados=array();
            $estados[]=$data->get('estado_id');
        }
        
        if(route('home') == "http://temporizar.t3rsc.co") {
            $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->leftjoin("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->whereIn("estados_requerimiento.estado", $estados)
            ->where("users_x_clientes.user_id", $this->user->id)
            ->where(function ($sql) use ($data) {
                if($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }

                if ($data->has("numero_req") && $data->get("numero_req") != "") {
                    $sql->where("requerimientos.id", $data->get("numero_req"));
                }

                if($data->get("fecha_inicio") != "" && $data->get("fecha_fin") != "") {
                    $sql->whereBetween("requerimientos.created_at", [$data->get("fecha_inicio") . ' 00:00:00',  $data->get("fecha_fin") . ' 23:59:59']);
                }

                if($data["ciudad_id"] != "") {
                    $sql->where('requerimientos.ciudad_id',$data->get("ciudad_id"));
                }
                    
                if($data["departamento_id"] != "") {
                  $sql->where('requerimientos.departamento_id',$data->get("departamento_id"));
                }
            })
            ->select(
                "cargos_especificos.descripcion as cargo",
                "requerimientos.id",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_terminacion",
                "requerimientos.fecha_ingreso",
                "requerimientos.dias_gestion",
                "tipo_proceso.descripcion as tipo_proceso_desc",
                "negocio.num_negocio",
                "clientes.nombre as nombre_cliente",
                "requerimientos.id as req_id",
                DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales'),
                "ciudad.nombre as ciudad")
            ->groupBy('requerimientos.id')
            ->orderBy("requerimientos.id", "desc")
            ->paginate(10);
        }elseif(route('home') == "https://komatsu.t3rsc.co") {
            $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->where("users_x_clientes.user_id", $this->user->id)
            ->where(function ($sql) use ($data) {
                if($data["id_req"] != "") {
                    $sql->where("requerimientos.id",$data["id_req"]);
                }

                if($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }

                if($data->has("numero_req") && $data->get("numero_req") != "") {
                    $sql->where("requerimientos.id", $data->get("numero_req"));
                }

                if ($data->get("fecha_inicio") != "" && $data->get("fecha_fin") != "") {
                    $sql->whereBetween("requerimientos.created_at", [$data->get("fecha_inicio") . ' 00:00:00',  $data->get("fecha_fin") . ' 23:59:59']);
                }

                /*if ($data->has("fecha_inicio") && $data->get("fecha_inicio") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.created_at,'dd/mm/yyyy')) = '" . $data->get("fecha_inicio") . "'");
                }

                if ($data->has("fecha_fin") && $data->get("fecha_fin") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.fecha_ingreso,'dd/mm/yyyy')) ='" . $data->get("fecha_fin") . "'");
                }*/
            })
            ->select(
                "cargos_especificos.descripcion as cargo",
                "requerimientos.id",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_terminacion",
                "requerimientos.fecha_ingreso",
                "requerimientos.dias_gestion",
                "tipo_proceso.descripcion as tipo_proceso_desc",
                "negocio.num_negocio",
                "clientes.nombre as nombre_cliente",
                "requerimientos.id as req_id",
                "requerimientos.solicitud_id",
                 DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales'),
                "ciudad.nombre as ciudad")
            ->groupBy('requerimientos.id')
            ->orderBy("requerimientos.id", "desc")
            ->paginate(10);
        }elseif(route('home') == "https://vym.t3rsc.co" || route("home") == "https://listos.t3rsc.co") {
            $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
            ->join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->join('departamentos', function ($join2) {
                $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
            })
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->whereIn("ciudad.agencia", $this->user->agencias())
            ->where("users_x_clientes.user_id", $this->user->id)
            //->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->whereIn("estados_requerimiento.estado", $estados)
            ->where(function ($sql) use ($data) {
                if($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }

                if($data->has("numero_req") && $data->get("numero_req") != "") {
                    $sql->where("requerimientos.id", $data->get("numero_req"));
                }

                if($data->get("fecha_inicio") != "" && $data->get("fecha_fin") != "") {
                    $sql->whereBetween("requerimientos.created_at", [$data->get("fecha_inicio") . ' 00:00:00',  $data->get("fecha_fin") . ' 23:59:59']);
                }

                if($data["ciudad_id"] != "") {
                    $sql->where('requerimientos.ciudad_id',$data->get("ciudad_id"));
                }
                    
                if($data["departamento_id"] != "") {
                    $sql->where('requerimientos.departamento_id',$data->get("departamento_id"));
                }

                /* if ($data->has("fecha_inicio") && $data->get("fecha_inicio") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.created_at,'dd/mm/yyyy')) = '" . $data->get("fecha_inicio") . "'");
                }

                if ($data->has("fecha_fin") && $data->get("fecha_fin") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.fecha_ingreso,'dd/mm/yyyy')) ='" . $data->get("fecha_fin") . "'");
                }*/
            })
            ->select(
                "cargos_especificos.descripcion as cargo",
                "requerimientos.id",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_terminacion",
                "requerimientos.fecha_ingreso",
                "requerimientos.dias_gestion",
                "tipo_proceso.descripcion as tipo_proceso_desc",
                "negocio.num_negocio",
                "clientes.nombre as nombre_cliente",
                "requerimientos.id as req_id",
                 DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales'),
                "ciudad.nombre as ciudad")
            ->groupBy('requerimientos.id')
            ->orderBy("requerimientos.id", "desc")
            ->paginate(10);
        }else {
            $requerimientos = Requerimiento::join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            /*->join('departamentos', function ($join2) {
                $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
            })*/
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->leftjoin('users','requerimientos.solicitado_por',"=",'users.id')
            //->whereIn("ciudad.agencia", $this->user->agencias())
            ->where("users_x_clientes.user_id", $this->user->id)
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->whereIn("estados_requerimiento.estado", $estados)
            ->tipoProceso($data)
            ->where(function ($sql) use ($data,&$estados) {
                if($data->has("cliente_id") && $data->get("cliente_id") != "") {

                   $sql->where("clientes.id", $data->get("cliente_id"));
                }

                if($data->has("numero_req") && $data->get("numero_req") != "") {
                    $estados[]=config('conf_aplicacion.C_TERMINADO');

                    $sql->where("requerimientos.id", $data->get("numero_req"));
                }

                if($data->get("fecha_inicio") != "" && $data->get("fecha_fin") != "") {
                  
                  $sql->whereBetween("requerimientos.created_at", [$data->get("fecha_inicio") . ' 00:00:00',  $data->get("fecha_fin") . ' 23:59:59']);
                }

                if($data["ciudad_id"] != ""){

                  $sql->where('requerimientos.ciudad_id',$data->get("ciudad_id"));
                  $sql->where('requerimientos.departamento_id',$data->get("departamento_id"));
                  $sql->where('requerimientos.pais_id',$data->get("pais_id"));
                }
                    
                /*if($data["departamento_id"] != ""){

                  $sql->where('requerimientos.departamento_id',$data->get("departamento_id"));

                }*/

                /*if ($data->has("fecha_inicio") && $data->get("fecha_inicio") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.created_at,'dd/mm/yyyy')) = '" . $data->get("fecha_inicio") . "'");
                }

                if ($data->has("fecha_fin") && $data->get("fecha_fin") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.fecha_ingreso,'dd/mm/yyyy')) ='" . $data->get("fecha_fin") . "'");
                }*/
            })
            ->select(
                "cargos_especificos.descripcion as cargo",
                "requerimientos.id",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_terminacion",
                "requerimientos.fecha_ingreso",
                "requerimientos.dias_gestion",
                "tipo_proceso.descripcion as tipo_proceso_desc",
                "negocio.num_negocio",
                "clientes.nombre as nombre_cliente",
                "requerimientos.id as req_id",
                "users.name as solicito",
                DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales'),
                "ciudad.nombre as ciudad")
            ->groupBy('requerimientos.id')
            ->orderBy("requerimientos.id", "desc")
            ->paginate(10);
        }

        $cerroMatozo = 0;
        if(route("home") == "https://listos.t3rsc.co") {
            $cerroMatozo = User::join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->where('users.id', $this->user->id)
            ->where('users_x_clientes.cliente_id',168)
            ->count();
        }

        return view("req.mis_requerimientos", compact("requerimientos", "clientes", "usuarios", "estados_requerimiento", "cerroMatozo","tipoProcesos"));
    }

    public function getCargoEspecificoDependientes(Request $data)
    {
        
        //Datos de la ficha tecnica segun el cargo
        $user_sesion = $this->user;
        /*$dato_ficha = Ficha::where('cliente_id', $data->cliente_id)
        ->where('cargo_cliente', $data->cargo_especifico_id)
        ->select('*')
        ->first();

        if ($dato_ficha != null) {
            
            $ficha_jornada_laboral    = $dato_ficha->horario;
            $ficha_tipo_contrato      = $dato_ficha->tipo_contrato;
            $ficha_numero_vacante     = $dato_ficha->cantidad_candidatos_vac;
            $ficha_nivel_estudio      = $dato_ficha->escolaridad;
            $ficha_funciones_realizar = $dato_ficha->funciones_realizar;
            $ficha_edad_minima        = $dato_ficha->edad_minima;
            $ficha_edad_maxima        = $dato_ficha->edad_maxima;
            $ficha_genero             = $dato_ficha->genero;

        }else {
        }
        */

        $cargo_especifico_id = $data->cargo_especifico_id;
        $negocio_id          = $data->negocio_id;

        $cargo_especifico    = CargoEspecifico::find($cargo_especifico_id);

        $archivo = ($cargo_especifico->archivo_perfil != "" && file_exists("recursos_Perfiles/".$cargo_especifico->archivo_perfil))?$cargo_especifico->archivo_perfil : '';

        $ficha_tipo_contrato      = $cargo_especifico->prfl_tipo_contrato;
        $ficha_numero_vacante     = 1;
        $ficha_nivel_estudio      = $cargo_especifico->prfl_nivel_estudio;
        $ficha_funciones_realizar = ($cargo_especifico->prfl_funciones != '' ? $cargo_especifico->prfl_funciones : "Labores relacionadas con el cargo solicitado en esta requisición, las anexas que se consideren convenientes ejecutar y las solicitadas específicamente por el representante de la supervisión patronal.");
        $ficha_edad_minima        = ($cargo_especifico->prfl_edad_minima > 0 ? $cargo_especifico->prfl_edad_minima : 18);
        $ficha_edad_maxima        = ($cargo_especifico->prfl_edad_maxima > 0 ? $cargo_especifico->prfl_edad_maxima : 35);
        $ficha_genero             = ($cargo_especifico->prfl_genero > 0 ? $cargo_especifico->prfl_genero : 3);
        $ctra_x_clt_codigo = $cargo_especifico->prfl_clase_riesgo;
        $cargo_generico_id = $cargo_especifico->cargo_generico_id;

        //Get depto Negocio
        $negocio = Negocio::find($negocio_id);

        $ficha_jornada_laboral = ($cargo_especifico->prfl_jornada_laboral != '' ? $cargo_especifico->prfl_jornada_laboral : $negocio->tipo_jornada_id);

        $tipo_liquidacion_id = ($cargo_especifico->prfl_tipo_liquidacion != '' ? $cargo_especifico->prfl_tipo_liquidacion : $negocio->tipo_liquidacion_id);

        $tipo_salario_id = ($cargo_especifico->prfl_tipo_salario != '' ? $cargo_especifico->prfl_tipo_salario : $negocio->tipo_salario_id);

        $tipo_nomina_id = $cargo_especifico->prfl_tipo_nomina;

        $concepto_pago_id = $cargo_especifico->prfl_concepto_pago;

        $salario = ($cargo_especifico->prfl_salario != '' ? $cargo_especifico->prfl_salario : $data->salario);

        //Get centros de costos de produccion
        $centro_costos = CentroCostoProduccion::where('cod_division', $cargo_especifico->clt_codigo)
        ->where('cod_depto_negocio', $negocio->depto_codigo)
        ->where('estado', '=', 'ACT')
        ->pluck('descripcion', 'codigo')
        ->toArray();

        //$centro_costo  = $data->centro_costo_produccion;
        //$salario       = $data->salario;
        $salario_min   = $cargo_especifico->cxclt_sueldo_minimo;
        $salario_max   = $cargo_especifico->cxclt_sueldo_maximo;
        
        if(route('home') == "http://komatsu.t3rsc.co"){
        
            $tipo_contrato =  TipoContrato::pluck("descripcion", "id")->toArray();

            $tipo_liquidacion =  TipoLiquidacion::first();

            $tipo_jornada =  TipoJornada::where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();

            $centro_trabajo =  CentroTrabajo::first();

            $tipo_nomina    =  TipoNomina::first();

            $concepto_pago  =  ConceptoPago::first();

            $tipo_salario   =   TipoSalario:: first();

        }else{
            $tipo_contrato      =  ["" => "Seleccione"] + TipoContrato::where('active', 1)->pluck("descripcion", "id")->toArray();

            $tipo_liquidacion   =  ["" => "Seleccione"] + TipoLiquidacion::pluck("descripcion", "id")->toArray();

            $tipo_jornada       =  ["" => "Seleccione"] + TipoJornada::where("active", 1)->pluck("descripcion", "id")->toArray();

            $centro_trabajo     =  CentroTrabajo::pluck("nombre_ctra", "id")->toArray();

            $tipo_nomina        =  TipoNomina::pluck("descripcion", "id")->toArray();

            $concepto_pago      =  ConceptoPago::pluck("descripcion", "id")->toArray();

            $tipo_salario       =  ["" => "Seleccione"] + TipoSalario::pluck("descripcion", "id")->toArray();
        }

        $motivo_requerimiento = [""=>"Seleccione"]+MotivoRequerimiento::where('active',1)
            ->orderBy('descripcion', 'asc')
            ->pluck("descripcion", "id")
            ->toArray();

        $motivo_requerimiento_id = $data->motivo_requerimiento_id;
        $observaciones           = $cargo_especifico->prfl_perfil_oculto;
        $funciones               = $cargo_especifico->prfl_funciones;

        $edad_minima_selected = $cargo_especifico->cxclt_edad_min;

        $edad_maxima_selected = $cargo_especifico->cxclt_edad_max;


        $generos              = ["" => "Seleccione"] + Genero::orderBy('id', 'desc')->pluck("descripcion", "id")->toArray();

        $genero_selected      = $cargo_especifico->prfl_genero;

        $estados_civiles      = EstadoCivil::orderBy('codigo', 'asc')
        ->select(DB::raw("upper(descripcion) as descripcion"), 'codigo')
        ->pluck('descripcion', "codigo")
        ->toArray();

        $nivel_estudio           =  NivelEstudios::orderBy('descripcion', 'asc')
        ->select(DB::raw("upper(descripcion) as descripcion"), 'id')
        ->pluck("descripcion", "id")
        ->toArray();

        $nivel_estudio_id = $cargo_especifico->prfl_nivel_estudio;

        $tipo_experiencia = TipoExperiencia::where("active", 1)
        ->pluck('descripcion', "id")
        ->toArray();

        $tipo_experiencia_id = $cargo_especifico->prfl_tiempo_experiencia;

        $tco_codigo = $cargo_especifico->tco_codigo;
        $estado_civil_selected = $cargo_especifico->prfl_estado_civil;

        $adicionales_salariales = $cargo_especifico->prfl_adicionales_salariales;
        
        $niveles = ["" => "Seleccionar"] + NivelIdioma::pluck("descripcion", "id")->toArray();

        /*$preguntas_cargo = ReqPreg::where('req_preguntas.cargo_especifico_id',$data->cargo_especifico_id)
        ->select('req_preguntas.*')
        ->get();*/

        if( $data->has('modulo') ){

            if(strlen($archivo)>0){
                $archivo_perfil = route("view_document_url", encrypt("recursos_Perfiles/"."|".$archivo));
            }else{
                $archivo_perfil = false;
            }

            return response()->json([
                    'cargo_generico_id' => ($cargo_generico_id == 0 ? "" : $cargo_generico_id),
                    'ctra_x_clt_codigo' => (1),
                    'archivo'           => $archivo_perfil,
                    'ficha_jornada_laboral' => ($ficha_jornada_laboral == 0 ? "" : $ficha_jornada_laboral),
                    'tipo_liquidacion_id' => (1),
                    'tipo_salario_id'  => ($tipo_salario_id == 0 ? "" : $tipo_salario_id),
                    'tipo_nomina_id'   => ($tipo_nomina_id == 0 ? "" : $tipo_nomina_id),
                    'concepto_pago_id' => ($concepto_pago_id == 0 ? "" : $concepto_pago_id),
                    'salario'  => $salario,
                    'ficha_tipo_contrato' => ($ficha_tipo_contrato == 0 ? "" : $ficha_tipo_contrato),
                    'adicionales_salariales' => $adicionales_salariales,
                    'motivo_requerimiento_id' => ($motivo_requerimiento_id == 0 ? "" : $motivo_requerimiento_id),
                    'ficha_numero_vacante'  => $ficha_numero_vacante,
                    'observaciones'  => $observaciones,
                    'ficha_funciones_realizar'  => $ficha_funciones_realizar,
                    'ficha_nivel_estudio' => ($ficha_nivel_estudio == 0 ? "" : $ficha_nivel_estudio),
                    'tipo_experiencia_id' => ($tipo_experiencia_id == 0 ? "" : $tipo_experiencia_id),
                    'ficha_edad_minima' => $ficha_edad_minima,
                    'ficha_edad_maxima' => $ficha_edad_maxima,
                    'ficha_genero' => ($ficha_genero == 0 ? "" : $ficha_genero),
                    'estado_civil_selected' => ($estado_civil_selected == 0 ? "" : $estado_civil_selected)

                ]);
        }else{
            return response()->json([
                'cargo_generico_id' => ($cargo_generico_id == 0 ? "" : $cargo_generico_id),
                'ctra_x_clt_codigo' => ($ctra_x_clt_codigo == 0 ? "" : $ctra_x_clt_codigo),
                'archivo'           => $archivo_perfil,
                'ficha_jornada_laboral' => ($ficha_jornada_laboral == 0 ? "" : $ficha_jornada_laboral),
                'tipo_liquidacion_id' => ($tipo_liquidacion_id == 0 ? "" : $tipo_liquidacion_id),
                'tipo_salario_id'  => ($tipo_salario_id == 0 ? "" : $tipo_salario_id),
                'tipo_nomina_id'   => ($tipo_nomina_id == 0 ? "" : $tipo_nomina_id),
                'concepto_pago_id' => ($concepto_pago_id == 0 ? "" : $concepto_pago_id),
                'salario'  => $salario,
                'ficha_tipo_contrato' => ($ficha_tipo_contrato == 0 ? "" : $ficha_tipo_contrato),
                'adicionales_salariales' => $adicionales_salariales,
                'motivo_requerimiento_id' => ($motivo_requerimiento_id == 0 ? "" : $motivo_requerimiento_id),
                'ficha_numero_vacante'  => $ficha_numero_vacante,
                'observaciones'  => $observaciones,
                'ficha_funciones_realizar'  => $ficha_funciones_realizar,
                'ficha_nivel_estudio' => ($ficha_nivel_estudio == 0 ? "" : $ficha_nivel_estudio),
                'tipo_experiencia_id' => ($tipo_experiencia_id == 0 ? "" : $tipo_experiencia_id),
                'ficha_edad_minima' => $ficha_edad_minima,
                'ficha_edad_maxima' => $ficha_edad_maxima,
                'ficha_genero' => ($ficha_genero == 0 ? "" : $ficha_genero),
                'estado_civil_selected' => ($estado_civil_selected == 0 ? "" : $estado_civil_selected)

            ]);
            // return view('req.nuevo_requerimiento_dependientes_cargos_especificos', compact(
            //     'cargo_generico_id',
            //     'archivo',
            //     //'preguntas_cargo',
            //     'centro_trabajo',
            //     'ctra_x_clt_codigo',
            //     'user_sesion',
            //     'centro_costos',
            //     'centro_costo',
            //     'negocio',
            //     //'jornada_laboral',
            //     'tipo_liquidacion',
            //     'tipo_salario',
            //     'tipo_nomina',
            //     'concepto_pago',
            //     'salario',
            //     'salario_min',
            //     'salario_max',
            //     'tipo_contrato',
            //     'tco_codigo',
            //     'motivo_requerimiento',
            //     'motivo_requerimiento_id',
            //     //'num_vacantes',
            //     'observaciones',
            //     'nivel_estudio',
            //     'nivel_estudio_id',
            //     'funciones',
            //     'edad_minima_selected',
            //     'edad_maxima_selected',
            //     'generos',
            //     'genero_selected',
            //     'estados_civiles',
            //     'estado_civil_selected',
            //     //'dato_ficha',
            //     'tipo_jornada',
            //     'ficha_jornada_laboral',
            //     'ficha_tipo_contrato',
            //     'ficha_numero_vacante',
            //     'ficha_nivel_estudio',
            //     'ficha_funciones_realizar',
            //     'ficha_edad_minima',
            //     'ficha_edad_maxima',
            //     'ficha_genero',
            //     'tipo_experiencia',
            //     'tipo_experiencia_id',
            //     'niveles',
            //     'tipo_liquidacion_id',
            //     'concepto_pago_id',
            //     'tipo_nomina_id',
            //     'tipo_salario_id',
            //     'adicionales_salariales'
            // ));
        }
    }

    public function nuevo_requerimiento_admin($cliente_id, $negocio_id, Request $data)
    {
        $cliente = Clientes::find($cliente_id);

        $usuarios_clientes = "";

        $tipos_visitas=[""=>"Seleccione"]+TipoVisita::where("active",1)->pluck("descripcion","id")->toArray();

        $tipos_evs = ["" => "Seleccione", "0" => "No aplica"] + TipoEstudioVirtualSeguridad::where("active",1)->pluck("descripcion","id")->toArray();
        
        $psicologos = ["" => "Seleccionar"] + User::join('role_users','role_users.user_id','=','users.id')
        ->where('role_users.role_id',17)
        ->pluck('users.name','users.id')
        ->toArray();

        $dato_ficha = "";

        $cargos = ["" => "- Seleccionar -"] + CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();

        $cargo_especifico = ["" => "Seleccionar"] + CargoEspecifico::select(DB::raw('CONCAT(descripcion," - ",codigo_1) as descripcion'),'id')->where('clt_codigo',$cliente_id)
        ->where('active', 1)
        ->orderBy('descripcion', 'asc')
        ->pluck('descripcion', 'id')
        ->toArray();

        $centro_costos = ["" => "Seleccionar"] + CentrosCostos::where("active",1)->where('cliente_id', $cliente_id)->orderBy("descripcion")->pluck("descripcion", "id")->toArray();

        $negocio = Negocio::where("negocio.depto_empresa_codigo", config("conf_aplicacion.EMP_DIVISION_GERENCIA"))
        ->where("negocio.id", $negocio_id)
        ->first();
        
        $centro_costo = ["" => "Seleccionar"] + CentroCostoProduccion::where("active",1)->where('cod_division', $cliente_id)->where("estado","ACT")->pluck("descripcion", "id")->toArray();

        if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co"){
        
          $tipoProceso = ["" => "Seleccionar"] + TipoProceso::where("active", 1)->orderBy("descripcion", "asc")->pluck("descripcion", "id")->toArray();
            //cuando es tiempos no mostrar la 8

        }else{

            $tipoProceso = ["" => "Seleccionar"] + TipoProceso::where("active", 1)->where('id','!=',8)->orderBy("descripcion", "asc")->pluck("descripcion", "id")->toArray();
        }

        $usuarios_clientes = ["" => "Seleccion"] + EloquentUser::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
        ->where("users_x_clientes.cliente_id", $cliente_id)->pluck("users.name", "users.id")->toArray();

        if(route('home') == "http://temporizar.t3rsc.co" || route('home') == "https://temporizar.t3rsc.co"){

            if($this->user->inRole('super administrador')){
                $tipoProceso["7"]="PROCESO BACKUP";
            }

        }

        $tipo_contrato = ["" => "Seleccionar"] + TipoContrato::where("active", 1)->orderBy("descripcion")->pluck("descripcion", "id")->toArray();

        $tipoExperiencia = ["" => "Seleccionar"] + TipoExperiencia::where("active", 1)->orderBy("descripcion")->pluck("descripcion", "id")->toArray();

        $tipoGenero = ["" => "Seleccionar"] + Genero::where("active", 1)->orderBy("descripcion")->pluck("descripcion", "id")->toArray();

        $motivoRequerimiento = ["" => "Seleccionar"] + MotivoRequerimiento::where("active", 1)->orderBy("descripcion")->pluck("descripcion", "id")->toArray();

        $tipo_liquidacion   =  ["" => "Seleccionar"] + TipoLiquidacion::where("active",1)->get()->pluck("descripcion", "id")->toArray();

        $tipo_jornada       =  ["" => "Seleccionar"] + TipoJornada::where("active", 1)->get()->pluck("descripcion", "id")->toArray();

        $centro_trabajo     =  ["" => "Seleccionar"] + CentroTrabajo::where("active",1)->get()->pluck("nombre_ctra", "id")->toArray();

        $tipo_nomina        =  ["" => "Seleccionar"] + TipoNomina::where("active",1)->get()->pluck("descripcion", "id")->toArray();

        $concepto_pago      =  ["" => "Seleccionar"] + ConceptoPago::where("active",1)->get()->pluck("descripcion", "id")->toArray();

        $tipo_salario       =  ["" => "Seleccionar"] + TipoSalario::where("active",1)->get()->pluck("descripcion", "id")->toArray();

        $motivo_requerimiento = [""=>"Seleccionar"]+MotivoRequerimiento::where('active',1)
            ->orderBy('descripcion', 'asc')
            ->pluck("descripcion", "id")
            ->toArray();

        $generos  = ["" => "Seleccionar"] + Genero::where("active",1)->orderBy('id', 'desc')->pluck("descripcion", "id")->toArray();

        $estados_civiles  = ["" => "Seleccionar"] + EstadoCivil::where("active",1)->orderBy('codigo', 'asc')
        ->select(DB::raw("upper(descripcion) as descripcion"), 'id')
        ->pluck('descripcion', "id")
        ->toArray();

        $nivel_estudio =  ["" => "Seleccionar"] +  NivelEstudios::where("active",1)->orderBy('descripcion', 'asc')
        ->select(DB::raw("upper(descripcion) as descripcion"), 'id')
        ->pluck("descripcion", "id")
        ->toArray();

        $tipo_experiencia = ["" => "Seleccionar"] + TipoExperiencia::where("active", 1)
        ->pluck('descripcion', "id")
        ->toArray();

        $user = $this->user;

        //Atributos : implementacion de los atributos
        $atributos = Atributo::join('atributos_clientes', 'atributos.cod_atributo', '=', 'atributos_clientes.cod_atributo')
        ->where('atributos_clientes.cliente_id', '=', $cliente_id)
        ->where('atributos.estado', '=', 1)
        ->select('atributos.*')
        ->orderBy("atributos.nombre_atributo", "ASC")
        ->get();

        // Parceamos el resultado de la consulta para acomodarla si hay atributos tipos select
        $estructura_attr = [];

        foreach ($atributos as $atributo) {

            if (trim($atributo->tipo_atributo) == "select") {
                $select_values     = AtributoSelect::where("cod_atributo", "=", $atributo->cod_atributo)->pluck("opciones_label", "opciones_valores")->toArray();
                $estructura_attr[] = [
                    'cod_atributo'        => $atributo->cod_atributo,
                    'nombre_atributo'     => $atributo->nombre_atributo,
                    'nombre_tag_atributo' => $atributo->nombre_tag_atributo,
                    'tipo_atributo'       => $atributo->tipo_atributo,
                    'select'              => $select_values,
                ];
            } elseif (trim($atributo->tipo_atributo) == "textbox") {
                $estructura_attr[] = [
                    'cod_atributo'        => $atributo->cod_atributo,
                    'nombre_atributo'     => $atributo->nombre_atributo,
                    'nombre_tag_atributo' => $atributo->nombre_tag_atributo,
                    'tipo_atributo'       => $atributo->tipo_atributo,
                ];
            }

        }

        $hay_atributos = false;

        if(count($estructura_attr) > 0){
            $hay_atributos = true;
        }

        if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
            //cambiar a tiempos**********

            $ans = NegocioANS::where("negocio_id", $negocio->id)->first();
         
            $date = Carbon::now();
            //dd($date);
         
            if(!empty($ans->dias_presentar_candidatos_antes)){
                $diasans = $ans->dias_presentar_candidatos_antes;
            }else{
                $diasans = 3;
            }

            //fecha de presentacion = hoy+ans
            $fecha_pre_c = $date->addWeekdays($diasans)->toDateString();
         
            //calculo de fechas dia de hoy mas ans mas 2 dias
            $addDays = $diasans + 2;

            $fecha_tentativa = $date->addWeekdays($addDays)->toDateString(); //fecha de inicio tentativa__
            
            //Fecha tentativa + 8 días habiles
            $fecha_hoy       = $date->toDateString();
            
            //$fecha_tentativa = $date->addWeekdays(8)->toDateString();*/
            $fecha_r_tentativa = "";

        }elseif(route("home") == "https://asuservicio.t3rsc.co"){

            //Fecha tentativa + 3 días habiles para asuservicio
            $date            = Carbon::now();
            $fecha_hoy       = $date->toDateString();
            $fecha_tentativa = $date->addWeekdays(3)->toDateString();
        
            //Fecha tentativa retiro + 11 meses
            $date_r            = Carbon::now();
            $fecha_r_tentativa = $date_r->addMonths(11)->toDateString();

            $fecha_pre_c ="";
        }else{

            //Fecha tentativa + 8 días habiles
            $date            = Carbon::now();
            $fecha_hoy       = $date->toDateString();
            $fecha_tentativa = $date->addWeekdays(8)->toDateString();
        
            //Fecha tentativa retiro + 11 meses
            $date_r            = Carbon::now();
            $fecha_r_tentativa = $date_r->addMonths(11)->toDateString();

            $fecha_pre_c ="";
        }

        $contenido_email_soporte = "Solicitud recibida telefonicamente";

        if(route("home") == "https://asuservicio.t3rsc.co"){
            $ciudadesSelect = ["" => "Seleccionar"] + Ciudad::where("cod_pais", 47)->orderBy("nombre", "asc")->pluck("nombre", "id")->toArray();
        }elseif(route("home") == "https://humannet.t3rsc.co"){
            $ciudadesSelect = ["" => "Seleccionar"] + Ciudad::where("cod_pais", 43)->orderBy("nombre", "asc")->pluck("nombre", "id")->toArray();
        }elseif(route("home") == "https://gpc.t3rsc.co"){
            $ciudadesSelect = ["" => "Seleccionar"] + Ciudad::where("cod_pais", 63)->orderBy("nombre", "asc")->pluck("nombre", "id")->toArray();
        }else{
            $ciudadesSelect = ["" => "Seleccionar"] + Ciudad::where("cod_pais", 170)->orderBy("nombre", "asc")->pluck("nombre", "id")->toArray();
        }

        $empresa_logo = ["" => "Seleccion"] + EmpresaLogo::pluck("nombre_empresa", "id")->toArray();
        

        $user_sesion = $this->user;

        return view("admin.nuevo_requerimiento_new", compact("user_sesion",
            "psicologos",
            "centro_costo",
            "hay_atributos",
            "estructura_attr",
            "cliente",
            "cargos",
            "tipoProceso",
            "tipoContrato",
            "tipoExperiencia",
            "tipoGenero",
            "motivoRequerimiento",
            "tipoJornadas",
            "user",
            "negocio",
            "cargo_especifico",
            "atributos",
            "dato_ficha",
            "fecha_tentativa",
            "fecha_r_tentativa",
            "fecha_pre_c",
            "fecha_hoy",
            "contenido_email_soporte",
            "centro_costos",
            "ciudadesSelect",
            "usuarios_clientes",
            "empresa_logo",
            "tipos_visitas",
            "tipos_evs",
            "tipo_contrato",
            "tipo_liquidacion",
            "tipo_jornada",
            "centro_trabajo",
            "tipo_nomina",
            "concepto_pago",
            "tipo_salario",
            "motivo_requerimiento",
            "generos",
            "estados_civiles",
            "nivel_estudio",
            "tipo_experiencia"
        ));
    }

    public function nuevo_requerimiento($cliente_id, $negocio_id, Request $data)
    {
        
        //aqui requeimientos clientes
        $cliente = Clientes::find($cliente_id);

        $empresa_logo = ["" => "Seleccion"];
        $tipos_visitas=[""=>"Seleccione"]+TipoVisita::where("active",1)->pluck("descripcion","id")->toArray();

        $tipos_evs = ["" => "Seleccione", "0" => "No aplica"] + TipoEstudioVirtualSeguridad::where("active",1)->pluck("descripcion","id")->toArray();
        
        $empresa_logo = ["" => "Seleccione"] + EmpresaLogo::pluck("nombre_empresa", "id")->toArray();
        
        $tipo_contrato = ["" => "Seleccionar"] + TipoContrato::where("active", 1)->orderBy("descripcion")->pluck("descripcion", "id")->toArray();

        $tipo_liquidacion   =  ["" => "Seleccionar"] + TipoLiquidacion::where("active",1)->get()->pluck("descripcion", "id")->toArray();

        $tipo_jornada       =  ["" => "Seleccionar"] + TipoJornada::where("active", 1)->get()->pluck("descripcion", "id")->toArray();

        $centro_trabajo     =  ["" => "Seleccionar"] + CentroTrabajo::where("active", 1)->get()->pluck("nombre_ctra", "id")->toArray();

        $tipo_nomina        =  ["" => "Seleccionar"] + TipoNomina::where("active", 1)->get()->pluck("descripcion", "id")->toArray();

        $concepto_pago      =  ["" => "Seleccionar"] + ConceptoPago::where("active", 1)->get()->pluck("descripcion", "id")->toArray();

        $tipo_salario       =  ["" => "Seleccionar"] + TipoSalario::where("active", 1)->get()->pluck("descripcion", "id")->toArray();

        $motivo_requerimiento = [""=>"Seleccionar"]+MotivoRequerimiento::where('active',1)
            ->orderBy('descripcion', 'asc')
            ->pluck("descripcion", "id")
            ->toArray(); 

        $generos  = ["" => "Seleccionar"] + Genero::where("active", 1)->orderBy('id', 'desc')->pluck("descripcion", "id")->toArray();

        $estados_civiles  = ["" => "Seleccionar"] + EstadoCivil::where("active", 1)->orderBy('codigo', 'asc')
        ->select(DB::raw("upper(descripcion) as descripcion"), 'id')
        ->pluck('descripcion', "id")
        ->toArray(); 

        $nivel_estudio =  ["" => "Seleccionar"] +  NivelEstudios::where("active", 1)->orderBy('descripcion', 'asc')
        ->select(DB::raw("upper(descripcion) as descripcion"), 'id')
        ->pluck("descripcion", "id")
        ->toArray(); 

        $tipo_experiencia = ["" => "Seleccionar"] + TipoExperiencia::where("active", 1)
        ->pluck('descripcion', "id")
        ->toArray(); 

        $usuarios_clientes = "";

        $usuarios_clientes = ["" => "Seleccion"] + EloquentUser::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
        ->where("users_x_clientes.cliente_id", $cliente_id)->pluck("users.name", "users.id")->toArray();

        $dato_ficha = "";

        $cargos = ["" => "- Seleccionar -"] + CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();

        $cargo_especifico = ["" => "Seleccionar"] + CargoEspecifico::select(DB::raw('CONCAT(descripcion," - ",codigo_1) as descripcion'),'id')
        ->where('active', 1)
        ->where('clt_codigo',$cliente_id)
        ->orderBy('descripcion', 'asc')
        ->pluck('descripcion', 'id')
        ->toArray();

        $centro_costos = ["" => "Seleccionar"] + CentrosCostos::where('active', 1)->where('cliente_id', $cliente_id)->orderBy("descripcion")->pluck("descripcion", "id")->toArray();

        $negocio = Negocio::where("negocio.depto_empresa_codigo", config("conf_aplicacion.EMP_DIVISION_GERENCIA"))
        ->where("negocio.id", $negocio_id)
        ->first();

        $centro_costo = ["" => "Seleccionar"] + CentroCostoProduccion::where('active', 1)->where('cod_division',$cliente_id)->pluck("descripcion", "id")->toArray();

        if(route("home")=="https://soluciones.t3rsc.co"){
            $tipoProceso = ["" => "Seleccionar"] + TipoProceso::where("active", 1)->orderBy("descripcion", "asc")->pluck("descripcion", "id")->toArray();
        }
        else{
            $tipoProceso = ["" => "Seleccionar"] + TipoProceso::where("active", 1)->where('id','!=',8)->orderBy("descripcion", "asc")->pluck("descripcion", "id")->toArray();

        }
       
        // $tipoExperiencia = ["" => "Seleccionar"] + TipoExperiencia::where("active", 1)->pluck("descripcion", "id")->toArray();

        // $tipoGenero = ["" => "Seleccionar"] + Genero::where("active", 1)->pluck("descripcion", "id")->toArray();        

        // $motivoRequerimiento = ["" => "Seleccionar"] + MotivoRequerimiento::where("active", 1)->pluck("descripcion", "id")->toArray();

        // $tipoJornadas = ["" => "Seleccionar"] + TipoJornada::where("active", 1)->pluck("descripcion", "id")->toArray();

        $user = $this->user;

        //Atributos : implementacion de los atributos
        $atributos = Atributo::join('atributos_clientes', 'atributos.cod_atributo', '=', 'atributos_clientes.cod_atributo')
        ->where('atributos_clientes.cliente_id', '=', $cliente->cliente_id)
        ->where('atributos.estado', '=', 1)
        ->select('atributos.*')
        ->orderBy("atributos.nombre_atributo", "ASC")
        ->get();

        // Parceamos el resultado de la consulta para acomodarla si hay atributos tipos select
        $estructura_attr = [];

        foreach($atributos as $atributo){
            if (trim($atributo->tipo_atributo) == "select") {

                $select_values     = AtributoSelect::where("cod_atributo", "=", $atributo->cod_atributo)->pluck("opciones_label", "opciones_valores")->toArray();
                $estructura_attr[] = [
                    'cod_atributo'        => $atributo->cod_atributo,
                    'nombre_atributo'     => $atributo->nombre_atributo,
                    'nombre_tag_atributo' => $atributo->nombre_tag_atributo,
                    'tipo_atributo'       => $atributo->tipo_atributo,
                    'select'              => $select_values,
                ];

            }elseif (trim($atributo->tipo_atributo) == "textbox") {
                
                $estructura_attr[] = [
                    'cod_atributo'        => $atributo->cod_atributo,
                    'nombre_atributo'     => $atributo->nombre_atributo,
                    'nombre_tag_atributo' => $atributo->nombre_tag_atributo,
                    'tipo_atributo'       => $atributo->tipo_atributo,
                ];

            }
        }

        $hay_atributos = false;

        if (count($estructura_attr) > 0) {
            $hay_atributos = true;
        }

        if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co" || route("home") == "http://localhost:8000"){
         //cambiar a tiempos**********
            $ans = NegocioANS::where("negocio_id", $negocio->id)->first();
         
            $date = Carbon::now();
         
            if(!empty($ans->dias_presentar_candidatos_antes)){
                $diasans = $ans->dias_presentar_candidatos_antes;
            }else{
                $diasans = 0;
            }
            //fecha de presentacion = hoy+ans
            $fecha_pre_c = $date->addWeekdays($diasans)->toDateString();
         
            //calculo de fechas dia de hoy mas ans mas 2 dias
            $addDays = $diasans + 2;

            $fecha_tentativa = $date->addWeekdays($addDays)->toDateString(); //fecha de inicio tentativa__
        
            //Fecha tentativa + 8 días habiles
            $fecha_hoy       = $date->toDateString();
            //$fecha_tentativa = $date->addWeekdays(8)->toDateString();*/

            $fecha_r_tentativa = "";

        }elseif(route("home") == "https://asuservicio.t3rsc.co"){

            //Fecha tentativa + 3 días habiles para asuservicio
            $date            = Carbon::now();
            $fecha_hoy       = $date->toDateString();
            $fecha_tentativa = $date->addWeekdays(3)->toDateString();
        
            //Fecha tentativa retiro + 11 meses
            $date_r            = Carbon::now();
            $fecha_r_tentativa = $date_r->addMonths(11)->toDateString();

            $fecha_pre_c ="";
        }else{ //colocar asuservi

            //Fecha tentativa + 8 días habiles
            $date            = Carbon::now();
            $fecha_hoy       = $date->toDateString();
            $fecha_tentativa = $date->addWeekdays(8)->toDateString();
        
            //Fecha tentativa retiro + 11 meses
            $date_r            = Carbon::now();
            $fecha_r_tentativa = $date_r->addMonths(11)->toDateString();

            $fecha_pre_c ="";
        }

        $contenido_email_soporte = "Solicitud recibida telefonicamente";

        if(route("home") == "https://asuservicio.t3rsc.co"){
            $ciudadesSelect = ["" => "Seleccionar"] + Ciudad::where("cod_pais", 47)->orderBy("nombre", "asc")->pluck("nombre", "id")->toArray();
        }elseif(route("home") == "https://humannet.t3rsc.co"){
            $ciudadesSelect = ["" => "Seleccionar"] + Ciudad::where("cod_pais", 43)->orderBy("nombre", "asc")->pluck("nombre", "id")->toArray();
        }elseif(route("home") == "https://gpc.t3rsc.co"){
            $ciudadesSelect = ["" => "Seleccionar"] + Ciudad::where("cod_pais", 63)->orderBy("nombre", "asc")->pluck("nombre", "id")->toArray();
        }else{
            $ciudadesSelect = ["" => "Seleccionar"] + Ciudad::where("cod_pais", 170)->orderBy("nombre", "asc")->pluck("nombre", "id")->toArray();
        }

        $cerroMatozo = 0;
        if(route("home") == "https://listos.t3rsc.co") {
           $cerroMatozo = User::join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->where('users.id', $this->user->id)
            ->where('users_x_clientes.cliente_id',168)
            ->count();
        }

        return view("req.nuevo_requerimiento_new", compact(
            "hay_atributos",
            "centro_costo",
            "estructura_attr",
            "cliente",
            "cargos",
            "tipoProceso",
            // "tipo_contrato",
            // "tipoExperiencia",
            // "tipoGenero",
            // "motivoRequerimiento",
            // "tipoJornadas",
            "user",
            "negocio",
            "cargo_especifico",
            "atributos",
            "dato_ficha",
            "fecha_tentativa",
            "fecha_pre_c",
            "fecha_r_tentativa",
            "fecha_hoy",
            "contenido_email_soporte",
            "centro_costos",
            "ciudadesSelect",
            "usuarios_clientes",
            "empresa_logo",
            "cerroMatozo",
            'tipos_visitas',
            "tipos_evs",
            "tipo_contrato",
            "tipo_liquidacion",
            "tipo_jornada",
            "centro_trabajo",
            "tipo_nomina",
            "concepto_pago",
            "tipo_salario",
            "motivo_requerimiento",
            "generos",
            "estados_civiles",
            "nivel_estudio",
            "tipo_experiencia"
        ));
    }

    //funcion que cambia la empresa que gestiona el req
    public function cambio_empresa(Request $data)
    {
        $req_actualizacion = Requerimiento::find($data->req);
        $req_actualizacion->empresa_contrata = $data->empresa;
        $req_actualizacion->save();

       return response()->json(["success" => true]);
    }
     
    public function detalle_requerimiento_admin($requerimiento_id, Request $data)
    {
        $user          = $this->user;
        $requerimiento = Requerimiento::find($requerimiento_id);
        $negocio       = Negocio::find($requerimiento->negocio_id);

        /* centro costo */
        $centro_costo = CentroCostoProduccion::join('requerimientos','requerimientos.centro_costo_id','=','centros_costos_produccion.id')
        ->select('centros_costos_produccion.descripcion as centro_costo')
        ->where('requerimientos.id',$requerimiento_id)
        ->first();

        $cliente = Clientes::find($negocio->cliente_id);

        $atributos_textbox = Atributo::select(
            DB::raw("atributos.nombre_atributo"),
            "atributos_valores.valor_atributo",
            "atributos.tipo_atributo"
        )->join("atributos_valores", "atributos.cod_atributo", "=", "atributos_valores.cod_atributo")
            ->where("atributos_valores.req_id", $requerimiento_id)
            ->where("atributos.estado", 1)
        //->where("atributos.TIPO_ATRIBUTO","=","textbox")
        ->get();

        //Consultar las personas postuladas segun el requerimiento.
        $candidatos_postulados = CandidatosFuentes::where('requerimiento_id', $requerimiento_id)
        ->select('*')
        ->get();

        $cargos = ["" => "Seleccionar"] + CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();
        $tipoProceso      = ["" => "Seleccionar"] + TipoProceso::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoContrato     = ["" => "Seleccionar"] + TipoContrato::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoExperiencia  = ["" => "Seleccionar"] + TipoExperiencia::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoGenero       = ["" => "Seleccionar"] + Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
        $motivoRequerimiento = MotivoRequerimiento::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoJornadas    = ["" => "Seleccionar"] + TipoJornada::where("active", 1)->pluck("descripcion", "id")->toArray();

        $funcionesGlobales = new FuncionesGlobales();

        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

       return view("admin.detalle_requerimiento_new", compact(
            "atributos_textbox",
            "candidatos_postulados",
            "cliente",
            "user",
            "negocio",
            "requerimiento",
            "centro_costo",
            "nombre"
        ));
    }

    public function detalle_requerimiento($requerimiento_id, Request $data)
    {
        $user          = $this->user;
        $requerimiento = Requerimiento::find($requerimiento_id);
        $negocio       = Negocio::find($requerimiento->negocio_id);
        
        /* centro costo */
        //$centro_costo = CentroCostoProduccion::where('cod_division', $negocio->depto_division_codigo)
           // ->where('cod_depto_negocio', $negocio->depto_codigo)
           // ->where('estado', '=', 'ACT')
           // ->select(DB::raw('upper(descripcion) as descripcion'))
           // ->first();

        $centro_costo = CentroCostoProduccion::join('requerimientos','requerimientos.centro_costo_id','=','centros_costos_produccion.id')
        ->select('centros_costos_produccion.descripcion as centro_costo')
        ->where('requerimientos.id',$requerimiento_id)
        ->first();

        $cliente = Clientes::find($negocio->cliente_id);

        $atributos_textbox = Atributo::select(
            DB::raw("atributos.nombre_atributo"),
            "atributos_valores.valor_atributo",
            "atributos.tipo_atributo"
        )->join("atributos_valores", "atributos.cod_atributo", "=", "atributos_valores.cod_atributo")
            ->where("atributos_valores.req_id", $requerimiento_id)
            ->where("atributos.estado", 1)
        //->where("atributos.TIPO_ATRIBUTO","=","textbox")
        ->get();

        //Consultar las personas postuladas segun el requerimiento.
        $candidatos_postulados = CandidatosFuentes::where('requerimiento_id', $requerimiento_id)
        ->select('*')
        ->get();

        $cargos = ["" => "Seleccionar"] + CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();
        $tipoProceso         = ["" => "Seleccionar"] + TipoProceso::where("active", 1)->pluck("descripcion", "id")->toArray();

        $tipoContrato        = ["" => "Seleccionar"] + TipoContrato::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoExperiencia     = ["" => "Seleccionar"] + TipoExperiencia::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoGenero          = ["" => "Seleccionar"] + Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
        $motivoRequerimiento = ["" => "Seleccionar"] + MotivoRequerimiento::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoJornadas        = ["" => "Seleccionar"] + TipoJornada::where("active", 1)->pluck("descripcion", "id")->toArray();

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        $cerroMatozo=0;
        if(route("home")=="https://listos.t3rsc.co"){
             $cerroMatozo = User::
            join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->where('users.id', $this->user->id)
            ->where('users_x_clientes.cliente_id',168)
            ->count();
        }

        return view("req.detalle_requerimiento_new", compact("atributos_textbox", "candidatos_postulados", "cliente", "user", "negocio", "requerimiento", "centro_costo", "nombre","cerroMatozo"));
    }
    
    // Admin side
    public function guardar_requerimiento_admin(RequerimientoRequest $data)
    {   
        $cargo_especifico = CargoEspecifico::find($data->get("cargo_especifico_id"));
        //$ciudadReq = Ciudad::find($data->get('ciudad_trabajo'));
        $pais_id = $data->pais_id;
        $departamento_id = $data->departamento_id;
        $ciudad_id = $data->ciudad_id;

        if(route('home') != "https://komatsu.t3rsc.co"){

            $nuevoRequerimiento = new Requerimiento();

            $nuevoRequerimiento->fill($data->all());
            $nuevoRequerimiento->observaciones = $data->get('observaciones');
            $nuevoRequerimiento->confidencial = $data->get('confidencial');
            $nuevoRequerimiento->tipo_liquidacion = $data->get('tipo_liquidacion');

            if(route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" ||
                route("home") == "http://localhost:8000" || route("home") == "http://desarrollo.t3rsc.co" ||
                route("home") == "https://desarrollo.t3rsc.co" || route("home") == "https://pruebaslistos.t3rsc.co" ||
                route("home") == "https://listos.t3rsc.co") {

                $nuevoRequerimiento->empresa_contrata = $data->empresa_contrata;

                if((route("home") == "https://listos.t3rsc.co" || route("home") == "http://localhost:8000") && $data->cliente_id == 168){
                    $nuevoRequerimiento->centro_costo_cliente = $data->centro_costo_cliente;
                    $nuevoRequerimiento->unidad_negocio = $data->unidad_negocio;
                    $nuevoRequerimiento->tipo_turno = $data->tipo_turno;
                }
            }
            
            //Cambiar
            if(route('home') == "http://tiempos.t3rsc.co"){
                $nuevoRequerimiento->salario = str_replace('.', '',$data->salario);
            }

            if(route('home') == "https://gpc.t3rsc.co"){
                $nuevoRequerimiento->conocimientos_especificos = $data->conocimientos_especificos;
                $nuevoRequerimiento->id_idioma                 = $data->id_idioma;
                $nuevoRequerimiento->nivel_idioma              = $data->nivel_idioma;
                $nuevoRequerimiento->salario_max               = $data->salario_max;
                $nuevoRequerimiento->salario_variable          = $data->salario_variable;
                $nuevoRequerimiento->cargo_generico_id        = $cargo_especifico->cargo_generico_id;
            }

            $nombre = $nuevoRequerimiento->nombre_cliente_req();
            //$nombre = Clientes::find($data->get('cliente_id'))->pluck('nombre');

            if(route('home') != "https://temporizar.t3rsc.co"){
                $mensaje_default = nl2br("En esta oferta de empleo buscamos personas que se perfilen en el cargo de $cargo_especifico->descripcion, nos gustaría acompañarte en tu camino laboral, por lo cual te invitamos a que:\r\n
                - Completes tu hoja de vida.\n
                - Grabes un video perfil para que mejores las probabilidades de ser seleccionado en el cargo.\n
                -  Apliques a las vacantes y contestes las preguntas de preselección que nuestro equipo de selección ha preparado para ti !\n
                Éxitos en tu aplicación y esperamos que este cargo aporte en tus objetivos laborales y de vida!");
            }else{
                $mensaje_default = nl2br("En Temporizar estamos buscando personas como tú! Con Actitud, soñadoras, con ganas de trabajar y sobre todo con muchas ganas de hacer realidad sus proyectos!. 
                
                En esta oferta de empleo buscamos personas que se perfilen en el cargo de $cargo_especifico->descripcion. 
                
                Nos gustaría acompañarte en tu camino laboral, por lo cual te invitamos a que:\r\n
                - Completes tu hoja de vida.\n
                - Grabes un video perfil para que mejores las probabilidades de ser seleccionado en el cargo.\n
                -  Apliques a las vacantes y contestes las preguntas de preselección que nuestro equipo de selección ha preparado para ti !\n
                Éxitos en tu aplicación y esperamos que este cargo aporte en tus objetivos laborales y de vida!");
            }

            $nuevoRequerimiento->descripcion_oferta = $mensaje_default;

            $nuevoRequerimiento->sitio_trabajo = $data->sitio_trabajo;

            $nuevoRequerimiento->pais_id = $pais_id;
            $nuevoRequerimiento->departamento_id = $departamento_id;
            $nuevoRequerimiento->ciudad_id = $ciudad_id;
            $tip_pro = TipoProceso::find($data->get("tipo_proceso_id"));

            if($tip_pro->publicacion_automatica) {
                if($data->get('confidencial') == 1) {
                    $p = 0; 
                }else {
                    $p = 1;
                }
            }else {
                $p = 0;
            }

            $nuevoRequerimiento->estado_publico = $p;
            $nuevoRequerimiento->cargo_codigo = $cargo_especifico->cargo_codigo;
            $nuevoRequerimiento->grado_codigo = $cargo_especifico->grado_codigo;
            $nuevoRequerimiento->save();

            if($data->hasFile('perfil')) {
                $imagen     = $data->file("perfil");
                $extencion  = $imagen->getClientOriginalExtension();
                $name_documento = "documento_" .$nuevoRequerimiento->id. "." . $extencion;
                $imagen->move("documentos_solicitud", $name_documento);
                $nuevoRequerimiento->documento = $name_documento;
                $nuevoRequerimiento->save();
            }
        }else {
            $nuevoRequerimiento = new Requerimiento(); 
            $mensaje_koma = "Hola, Queremos contar contigo, Komatsu multinacional necesita alguien como tú, si cumples con el perfil aplica a nuestra oferta y has parte de nuestro equipo en Colombia!";
            $nuevoRequerimiento->fill($data->all());
            $nuevoRequerimiento->observaciones = $data->get('observaciones');
            $nuevoRequerimiento->sitio_trabajo =$data->sitio_trabajo;

            $nuevoRequerimiento->pais_id = $pais_id;
            $nuevoRequerimiento->departamento_id = $departamento_id;
            $nuevoRequerimiento->ciudad_id = $ciudad_id;

            $nuevoRequerimiento->descripcion_oferta = $mensaje_koma;
            $nuevoRequerimiento->estado_publico = 1;
            $nuevoRequerimiento->cargo_codigo = $cargo_especifico->cargo_codigo;
            $nuevoRequerimiento->grado_codigo = $cargo_especifico->grado_codigo;
            //$nuevoRequerimiento->observaciones = $data["observaciones"];
            $nuevoRequerimiento->save();
        }

        $num_vacantes = $data->get("num_vacantes");

        //Ajuste ANS OCT 30
        $ans = NegocioANS::where("negocio_id", $data->get("negocio_id"))->get();

        if($ans->count() > 0) {
            $inicio_rango = 0;
            $fin_rango    = 0;
            $hay_ans      = false;
            $current = Carbon::parse($nuevoRequerimiento->created_at);
            $future = Carbon::parse($nuevoRequerimiento->fecha_ingreso);
            $dias_gestion = $current->diffInWeekdays($future);
            
            foreach($ans as $key => $value) {
                list($inicio_rango, $fin_rango) = explode("A",strtoupper($value->regla));

                if(($num_vacantes >= $inicio_rango) && ($num_vacantes <= $fin_rango) && !$hay_ans ) {
                   //$dias_gestion                  = $value->cantidad_dias;
                   $cuantos_candidatos_presentar  = $value->num_cand_presentar_vac * $num_vacantes;
                   $cuantos_dias_presentar_antes  = $value->dias_presentar_candidatos_antes;
                   $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
                   $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)->subWeekdays($cuantos_dias_presentar_antes);
                   $hay_ans=true;
                }
            }

            //si no hay ans traemos los valores por defecto
            if(!$hay_ans) {
                $dias_gestion   = config('conf_aplicacion.DIAS_DEFECTO_REQUERIMIENTO');
                $cuantos_candidatos_presentar  = config('conf_aplicacion.CANTIDAD_DE_CAND_A_PRESENTAR_VACANTE') * $num_vacantes;
                $cuantos_dias_presentar_antes  = config('conf_aplicacion.DIAS_PRESENTACION_CAND_DEFECTO');
                $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
                $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)->subWeekdays($cuantos_dias_presentar_antes);
            }
        }else{
            $current  = Carbon::parse($nuevoRequerimiento->created_at);
            $current1 = $current->format('Y-m-d');
            $current2 = Carbon::parse($current1);
            
            $future  = Carbon::parse($nuevoRequerimiento->fecha_ingreso);
            $future1 = $future->format('Y-m-d');
            $future2 = Carbon::parse($future1);

            $dias_gestion = $future2->diffInWeekdays($current2);

            $cuantos_candidatos_presentar  = config('conf_aplicacion.CANTIDAD_DE_CAND_A_PRESENTAR_VACANTE') * $num_vacantes;
            $cuantos_dias_presentar_antes  = config('conf_aplicacion.DIAS_PRESENTACION_CAND_DEFECTO');
            $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
            $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)->subWeekdays($cuantos_dias_presentar_antes);
        }

        $req_actualizacion = Requerimiento::find($nuevoRequerimiento->id);

        
        /* if(route('home') == "http://vym.t3rsc.co" || route('home') == "http://tiempos.t3rsc.co" ||
            route('home') == "https://vym.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co" ||
            route('home') == "test.poderhumano.t3rsc.co" || route('home') == "http://localhost:8000"){*/

            $date_r       = Carbon::now();
                                    
            $fecha_mañana = $date_r->addWeekdays(1)->toDateString();
            $fecha_mañana .= ' 00:00:00';

            $hora_req = Carbon::parse($nuevoRequerimiento->created_at);
                
            //if($hora_req->hour >= 11){
             $req_actualizacion->created_at = $fecha_mañana;
            //}
        // }
        
        $req_actualizacion->dias_gestion           = $dias_gestion;
        $req_actualizacion->cuantos_candidatos_presentar  = $cuantos_candidatos_presentar;
        $req_actualizacion->cuantos_dias_presentar_antes  = $cuantos_dias_presentar_antes;
        $req_actualizacion->fecha_presentacion_oport_cand = $fecha_presentacion_oport_cand;
        $req_actualizacion->fecha_tentativa_cierre_req    = $fecha_tentativa_cierre_req;
        $req_actualizacion->fecha_terminacion = $fecha_tentativa_cierre_req;
        // $req_actualizacion->observaciones   = $data->get('observaciones');

        $req_actualizacion->save();

        $terminar_req = new EstadosRequerimientos();

        $terminar_req->fill([
            "estado"   => config('conf_aplicacion.C_RECLUTAMIENTO'),
            "user_gestion" => $this->user->id,
            "req_id"    => $nuevoRequerimiento->id,
        ]);

        $terminar_req->save();

        $solicitado_por = Requerimiento::leftjoin('datos_basicos','datos_basicos.user_id','=','requerimientos.solicitado_por')
        ->where('requerimientos.id',$nuevoRequerimiento->id)
        ->select('datos_basicos.nombres as nombre_user_soli')
        ->first();

        if(($solicitado_por->nombre_user_soli != "") && (!is_null($solicitado_por->nombre_user_soli))){
            $solicitado = $solicitado_por->nombre_user_soli;  
        }else{
            $solicitado = $this->user->name;
        }

        $dataView = [
            'solicitado_por'  => $solicitado,
            'sitio_trabajo'   => $data->get('sitio_trabajo'),
            'num_vacantes'    => $data->get('num_vacantes'),
            'pais_id'         => $data->get('pais_id'),
            'departamento_id' => $data->get('departamento_id'),
            'ciudad_id'       => $data->get('ciudad_id'),
        ];

        if(route("home") == "http://vym.t3rsc.co" || route("home") == "https://vym.t3rsc.co" ||
            route("home") == "http://listos.t3rsc.co" || route("home") == "https://listos.t3rsc.co" ||
            route("home") == "http://soluciones.t3rsc.co" || route("home") == "https://soluciones.t3rsc.co"){            
            
            $agencia = User::join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->join('role_users','role_users.user_id','=','users.id')
            ->join('clientes','clientes.id','=','users_x_clientes.cliente_id')
            ->join('negocio','negocio.cliente_id','=','clientes.id')
            ->join('requerimientos','requerimientos.negocio_id','=','negocio.id')
            //->join('ciudad','ciudad.id','=','requerimientos.ciudad_id')
            ->join("ciudad", function($sql){
                $sql->on("ciudad.cod_ciudad","=", "requerimientos.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id")
                ->on("ciudad.cod_pais","=","requerimientos.pais_id");
            })
            ->where('requerimientos.id',$nuevoRequerimiento->id)
            ->select("ciudad.agencia as agencia")
            //->groupBy("users.id","agencias.id")
            ->first();
            
            $emails = AgenciaUsuario::select("users.name as nombres","users.email as email")
            ->join("users", "users.id", "=", "agencia_usuario.id_usuario")
            ->join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->join("role_users", "users.id", "=", "role_users.user_id")
            ->join('clientes','clientes.id','=','users_x_clientes.cliente_id')
            ->join('negocio','negocio.cliente_id','=','clientes.id')
            ->where("agencia_usuario.id_agencia", $agencia->agencia)
            ->where("users.notificacion_requisicion", 1)
            ->whereIn("role_users.role_id", [17, 5])
            ->where("clientes.id",$nuevoRequerimiento->cliente())
            ->groupBy("users.id")
            ->get();
        }else {
            $emails = User::leftjoin('datos_basicos','datos_basicos.user_id','=','users.id')
            ->join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->join('role_users','role_users.user_id','=','users.id')
            ->join('clientes','clientes.id','=','users_x_clientes.cliente_id')
            ->join('negocio','negocio.cliente_id','=','clientes.id')
            ->join('requerimientos','requerimientos.negocio_id','=','negocio.id')
            ->where("users.notificacion_requisicion",1)
            ->where('requerimientos.id',$nuevoRequerimiento->id)
            ->whereIn('role_users.role_id',[17,5])
            ->select("users.name as nombres","users.email as email", "datos_basicos.user_id")
            ->groupBy("users.id")
            ->get();
        }

        $sitio = Sitio::first();

        if(isset($sitio->nombre)) {
            if($sitio->nombre != "") {
                $nombre = $sitio->nombre;
            }else {
                $nombre = "Desarrollo";
            }
        }

        //Se verifica si el sitio configura la prueba de Excel Basico y/o Intermedio
        if ($sitio->prueba_excel_basico || $sitio->prueba_excel_intermedio) {
            //Se verifica si el cargo tiene configurada alguna prueba de Excel
            if ($cargo_especifico->excel_basico || $cargo_especifico->excel_intermedio) {
                $config_excel_req = new PruebaExcelConfiguracion();

                $config_excel_req->gestiono     = $this->user->id;
                $config_excel_req->req_id       = $nuevoRequerimiento->id;
                $config_excel_req->excel_basico                 = $cargo_especifico->excel_basico;
                $config_excel_req->excel_intermedio             = $cargo_especifico->excel_intermedio;
                $config_excel_req->tiempo_excel_basico          = $cargo_especifico->tiempo_excel_basico;
                $config_excel_req->tiempo_excel_intermedio      = $cargo_especifico->tiempo_excel_intermedio;
                $config_excel_req->aprobacion_excel_basico      = $cargo_especifico->aprobacion_excel_basico;
                $config_excel_req->aprobacion_excel_intermedio  = $cargo_especifico->aprobacion_excel_intermedio;

                $config_excel_req->save();
            }
        }

        $sitioModulo = SitioModulo::first();

        //Se verifica si el sitio configura la prueba de valores 1
        if ($sitioModulo->prueba_valores1 == 'enabled') {
            $cargoConfigPruebas = CargoEspecificoConfigPruebas::where('cargo_especifico_id', $data->get("cargo_especifico_id"))->orderBy('created_at', 'DESC')->first();

            //Si el cargo tiene configurada la prueba de valores, se agrega la configuracion al requerimiento
            if ($cargoConfigPruebas != null) {
                $newPruebaValoresConfigReq = new PruebaValoresConfigRequerimiento();
                $newPruebaValoresConfigReq->gestiono            = $this->user->id;
                $newPruebaValoresConfigReq->req_id              = $nuevoRequerimiento->id;
                $newPruebaValoresConfigReq->prueba_valores_1    = 'enabled';
                $newPruebaValoresConfigReq->valor_verdad        = $cargoConfigPruebas->valor_verdad;
                $newPruebaValoresConfigReq->valor_rectitud      = $cargoConfigPruebas->valor_rectitud;
                $newPruebaValoresConfigReq->valor_paz           = $cargoConfigPruebas->valor_paz;
                $newPruebaValoresConfigReq->valor_amor          = $cargoConfigPruebas->valor_amor;
                $newPruebaValoresConfigReq->valor_no_violencia  = $cargoConfigPruebas->valor_no_violencia;

                $newPruebaValoresConfigReq->save();
            }
        }

        //Comienzo guardar adicionales
            if($data->has("clausulas") && is_array($data->get("clausulas"))) {
                foreach($data->get("clausulas") as $key => $clausula) {
                    //Si hay un valor adicional configurado se crea la asociación en la tabla
                    if($data->has("valor_adicional") && is_array($data->get("valor_adicional"))) {
                        //if ($data->get("valor_adicional")[$key] != 0) {
                            $documento_adicional_valor = new ClausulaValorRequerimiento();

                            $documento_adicional_valor->fill([
                                'req_id' => $nuevoRequerimiento->id,
                                'adicional_id' => $clausula,
                                'valor' => $data->get("valor_adicional")[$key],
                            ]);
                            $documento_adicional_valor->save();
                        //}
                    }
                }
            }
        //Fin guardar adicionales

        $requerimiento_id = $req_actualizacion;
        
        //Candidatos enviados por el cliente -----------------------
        $tipo_fuente_id = config('conf_aplicacion.COD_TIPO_FUENTE_CANDIDATOS_ENVIADOS_CLIENTE');
        
        $can_nombres    = $data->get('can_nombres');
        $can_apellido   = $data->get('can_apellido');
        $can_cedulas    = $data->get('can_cedula');
        $can_moviles    = $data->get('can_movil');
        $can_emails     = $data->get('can_email');
        $fecha_ultimo_contrato     = $data->get('fecha_ultimo_contrato');
        $candidatos_no_postulados = [];

        //Verifica campos de candidato ingresado por cliente
        for($i = 0; $i < count($can_nombres); $i++) {       //inicia ciclo de candidatos cargados
          
            if( strlen($can_cedulas[$i]) == 0 && strlen($can_nombres[$i]) == 0 && strlen($can_apellido[$i]) == 0 && strlen($can_moviles[$i]) == 0 &&  strlen($can_emails[$i]) == 0){
                break;
            }

            if ( strlen($can_cedulas[$i]) == 0 ) {
                /*viene algun campo lleno pero no la cedula
                entonces lo sacamos tambien por ahora mientras resolvemos esto*/

                break;
            }

            $nombre_candidato = strlen($can_nombres[$i]) > 1 ? $can_nombres[$i] : "Nombre no ingresado";

            $cedula_candidato = strlen($can_cedulas[$i]) > 1 ? $can_cedulas[$i] : "Cedula no Ingresada";

            $apellido_candidato = strlen($can_apellido[$i]) > 1 ? $can_apellido[$i] : "Apellido no ingresado";

            $movil_candidato = strlen($can_moviles[$i]) > 1 ? $can_moviles[$i] : "Movil no ingresado";

            $email_candidato = strlen($can_emails[$i]) > 1 ? $can_emails[$i] : "Email no ingresado";

            $tipo_proceso_req=TipoProceso::find($nuevoRequerimiento->tipo_proceso_id);

            $datos_basicos = DatosBasicos::where('numero_id',$can_cedulas[$i])->first();

            if(is_null($datos_basicos)){
                $se_puede_postular = 'SI';
                //Creamos el usuario
                $campos_usuario = [
                    'name'      => $can_nombres[$i].' '.$can_apellido[$i],
                    'email'     => $can_emails[$i],
                    'password'  => $can_cedulas[$i],
                    'numero_id' => $can_cedulas[$i],
                    'cedula'    => $can_cedulas[$i]
                ];
        
                $user = Sentinel::registerAndActivate($campos_usuario);
            
                $usuario_id = $user->id;
                
                $apellidos = explode(" ", $can_apellido[$i], 2);
                $nombres_sep=explode(" ", $can_nombres[$i], 2);

                $primer_nombre=$nombres_sep ? $nombres_sep[0] : NULL;

                $segundo_nombre=$nombres_sep ? $nombres_sep[1] : NULL;

                $primer_apellido = $apellidos ? $apellidos[0] : NULL;

                $segundo_apellido = $apellidos ? $apellidos[1] : NULL;
                //Creamos sus datos basicos
                $datos_basicos = new DatosBasicos();
                $datos_basicos->fill([
                    'numero_id'             => $can_cedulas[$i],
                    'user_id'               => $usuario_id,
                    'nombres'               => $can_nombres[$i],
                    'primer_nombre'         => $primer_nombre,
                    'segundo_nombre'        => $segundo_nombre,
                    'primer_apellido'       => $primer_apellido,
                    'segundo_apellido'      => $segundo_apellido,
                    'telefono_movil'        => $can_moviles[$i],
                    'estado_reclutamiento'  => config('conf_aplicacion.C_ACTIVO'),
                    'datos_basicos_count'   => "20",
                    'email'                 => $can_emails[$i]
                ]);

                //Se verifica si a la persona que se registra esta en la lista negra, se coloca en estado_reclutamiento, que tiene problema de seguridad
                $cand_lista_negra = ListaNegra::where('cedula', $datos_basicos->numero_id)->first();
                if ($cand_lista_negra != null) {
                    $datos_basicos->estado_reclutamiento = config('conf_aplicacion.PROBLEMA_SEGURIDAD');
                    $se_puede_postular = 'NO';

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
                    $auditoria->observaciones = 'Se registro en la creación de un nuevo requerimiento modulo Admin y se encuentra en listado especial con la restricción ' . $restriccion->descripcion;
                    $auditoria->valor_antes   = json_encode(["estado" => config('conf_aplicacion.C_ACTIVO')]);
                    $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.PROBLEMA_SEGURIDAD')]);
                    $auditoria->user_id       = $gestiono;
                    $auditoria->tabla         = "datos_basicos";
                    $auditoria->tabla_id      = $datos_basicos->id;
                    $auditoria->tipo          = 'ACTUALIZAR';
                    event(new \App\Events\AuditoriaEvent($auditoria));
                }

                $datos_basicos->save();

                Event::dispatch(new \App\Events\PorcentajeHvEvent($datos_basicos));

                //Creamos el rol
                $role = Sentinel::findRoleBySlug('hv');
                $role->users()->attach($user);

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

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $nombre) {

                        $message->to($datos_basicos->email, $datos_basicos->nombres)
                                ->subject("Bienvenido a $nombre - T3RS")
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            } else {
                //Se validan estado de reclutamiento del candidato y estado del requerimiento
                $se_puede_postular = 'NO';

                if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_ACTIVO')) {
                    /*Si el estado de reclutamiento del candidato esta:
                    * 5-Activo
                    * Se puede postular al candidato
                    */
                    $se_puede_postular = 'SI';
                }else{
                    $proceso_req_cand = RegistroProceso::where("candidato_id", $datos_basicos->user_id)->orderBy('id', 'desc')->first();
                    if ($proceso_req_cand != null) {
                        if ($proceso_req_cand->estado == config('conf_aplicacion.C_CONTRATADO') || $proceso_req_cand->estado == config('conf_aplicacion.C_QUITAR')) {
                            /*Si el estado del candidato en el requerimiento anterior esta:
                            * 12-Contratado
                            * 14-Quitado
                            * Se puede postular al candidato
                            */
                            $se_puede_postular = 'SI';
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
                                $se_puede_postular = 'SI';
                            } else {
                                $req_candidato = ReqCandidato::where('requerimiento_id', $proceso_req_cand->requerimiento_id)->where("candidato_id", $datos_basicos->user_id)->orderBy('id', 'desc')->first();
                                if ($req_candidato != null && $req_candidato->estado_candidato == 24) {
                                    /*Si el estado del candidato en el requerimiento anterior esta:
                                    * 24-Contratacion cancelada
                                    * Se puede postular al candidato
                                    */
                                    $se_puede_postular = 'SI';
                                }
                            }
                        }
                    }
                }
            }
                    
            if ($se_puede_postular === 'SI') {
                if ($tipo_proceso_req->contratacion_directa) {
                    $req_can = new ReqCandidato();
                    $sitio2 = Sitio::first();

                    if ($sitio2->precontrata) {
                        $estadoProceso = "PRE_CONTRATAR";
                    } else {
                        $estadoProceso = "ENVIO_CONTRATACION_CLIENTE";
                    }
                    $req_can->fill([
                        'requerimiento_id'     => $nuevoRequerimiento->id,
                        'candidato_id'         => $datos_basicos->user_id,
                        'auxilio_transporte'   => $data->get('auxilio_transporte'),
                        'tipo_ingreso'         => $data->get('tipo_ingreso'),
                        'estado_candidato'     => config('conf_aplicacion.C_APROBADO_CLIENTE')
                    ]);
                    $estado = config('conf_aplicacion.C_APROBADO_CLIENTE');

                    $req_can->save();

                    //cambiar el estado del candidato
                    $candidato = $datos_basicos;

                    $candidato->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_CONTRATACION');

                    $candidato->save();

                    $req_can_id = $req_can->id;

                    //afiliar *************************
                    $nuevo_proceso = new RegistroProceso();
                    $nuevo_proceso->fill([
                        'requerimiento_candidato_id' => $req_can_id,
                        'estado'                     => $estado,
                        'fecha_inicio'               => date("Y-m-d H:i:s"),
                        'usuario_envio'              => $this->user->id,
                        'proceso'                    => $estadoProceso,
                        'requerimiento_id'           => $nuevoRequerimiento->id,
                        "centro_costos"              => $data["centro_costos"],
                        'candidato_id'               => $datos_basicos->user_id,
                        'observaciones'              => $data['observacionesContra'],
                        'user_autorizacion'          => $data['user_autorizacion'],
                        "usuario_terminacion"        => $this->user->id,
                        'fecha_solicitud_ingreso'    => $data['fecha_solicitud_ingreso'],
                        'fecha_real_ingreso'         => $data['fecha_real_ingreso'],
                        'fecha_inicio_contrato'      => $data['fecha_ingreso_contra'],
                        'fecha_ingreso_contra'       => $data['fecha_ingreso_contra'],
                        'hora_entrada'               => $data['hora_ingreso'],
                        'lugar_contacto'             => $data['lugar_contacto'],
                        'otros_devengos'             => $data['otros_devengos'],
                        'fecha_fin_contrato'         => $data['fecha_fin_contrato'],
                        'fecha_ultimo_contrato'      => $data['fecha_ultimo_contrato']
                    ]);

                    if (route("home")=="https://vym.t3rsc.co") {
                        $nuevo_proceso->fecha_ultimo_contrato = $fecha_ultimo_contrato[$i];
                    }

                    $nuevo_proceso->save();

                    $obj                    = new \stdClass();
                    $obj->requerimiento_id  = $nuevoRequerimiento->id;
                    $obj->user_id           = $this->user->id;
                    $obj->estado            = config('conf_aplicacion.C_EN_PROCESO_CONTRATACION');

                    Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));
                } else {
                    $candidatos_fuentes = CandidatosFuentes::create([
                        "nombres"          => $nombre_candidato,
                        "cedula"           => $cedula_candidato,
                        "celular"          => $movil_candidato,
                        "email"            => $email_candidato,
                        "tipo_fuente_id"   => $tipo_fuente_id,
                        "requerimiento_id" => $nuevoRequerimiento->id,
                    ]);
                }
            } else {
                $candidatos_no_postulados[] = "$cedula_candidato - $nombre_candidato $apellido_candidato";
            }
        } //fin ciclo candidatos cargados

        if (count($candidatos_no_postulados) > 0) {
            $mensaje_no_postulados = "No se postularon los siguientes candidatos porque estan asociados en otro requerimiento o se encuentran inactivos: <br>";
            $mensaje_no_postulados .= implode("<br>", $candidatos_no_postulados);
        } else {
            $mensaje_no_postulados = null;
        }

        if(route("home")=="https://gpc.t3rsc.co"){
            $usuario_req_email=User::find($this->user->id);
            Mail::send('req.emails.new_notificacion_req',[
                    'nombre_usuario' => $usuario_req_email->name,
                    'req'  => $requerimiento_id,
                    'data' => $dataView,
                    "cargo_especifico" => $cargo_especifico
                ],function ($m) use($usuario_req_email, $requerimiento_id) {  
                    $m->subject('Nueva requisición No. '.$requerimiento_id->id );
                    $m->to([$usuario_req_email->email,'cristina.delgado@gpc.com.ec'],'$nombre -T3RS')
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }
        else{

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Notificación Nuevo Requerimiento"; //Titulo o tema del correo
            //Arreglo para el botón
            $mailButton = ['buttonText' => 'GESTIONAR', 'buttonRoute' => route("admin.gestion_requerimiento", [$requerimiento_id->id])];


            foreach($emails as $key => $value){

                $url = route('admin.index');
                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "
                    Hola $value->nombres: <br/><br/>
                    Te informamos que {$dataView['solicitado_por']} a cargo de tu cliente {$requerimiento_id->empresa()->nombre}, ha creado un nuevo requerimiento:
                    <br/><br/>

                    <ul>
                        <li>Requerimiento: <b>{$requerimiento_id->id}</b></li>
                        <li>Cargo: <b>{$cargo_especifico->descripcion}</b></li>
                        <li>Ciudad: <b>{$requerimiento_id->getNombreCiudad()->ciudad}</b></li>
                        <li>Tipo Solicitud:
                            <b>{$requerimiento_id->getDescripcionTipoProceso()}</b>
                        </li>
                    </ul>

                    Para visualizar el requerimiento haz clic en el botón “Gestionar”, o si lo prefieres ingresa al módulo de <a href='$url'>administración</a> y consulta tus requerimientos en el menú <b>“Procesos de selección” / “Core”</b>
                ";
            
                $mailUser = $value->user_id; //Id del usuario al que se le envía el correo

                $triEmailNewReq = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                Mail::send($triEmailNewReq->view, ['data' => $triEmailNewReq->data], function($message) use($value, $requerimiento_id, $nombre) {

                        $message->to($value->email,"$nombre - T3RS")
                            ->subject('Nueva requisición No. '.$requerimiento_id->id )
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
            }
        }
         
        //dd($fecha_mañana);
        
         
        //correo de creacion de requerimientos
        if(route("home")=="https://temporizar.t3rsc.co"){
            if($data->tipo_proceso_id==6 || $data->tipo_proceso_id==4){
                 Mail::send('req.emails.new_notificacion_req',[
                'nombre_usuario' => "Contratación",
                'req'  => $requerimiento_id,
                'data' => $dataView,
                "cargo_especifico" => $cargo_especifico
            ],function ($m) use($requerimiento_id) {  
                $m->subject('Nueva requisicion No. '.$requerimiento_id->id );
                $m->to(['logistica@temporizar.com','nomina@temporizar@temporizar.com','contratacion@temporizar.com'],'$nombre -T3RS')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
            }
        }

        //preperfilar candidatos al req
        $req_id = $nuevoRequerimiento->id;

        //Datos de la ficha [Validar botones de requerimientos]
        $ficha = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->where("requerimientos.id", $req_id)
        ->select("*")
        ->first();

        $datos_ficha = Ficha::where("cargo_cliente", $ficha->cargo_especifico_id)
        ->where("cliente_id", $ficha->cliente_id)
        ->select("*")
        ->first();

        if($datos_ficha !== null) {
            //Busca las opciones de auxiliar de fichas para validar botones
            $valida_botones = AuxiliarFicha::where("ficha_id", $datos_ficha->id)->select("*")->get();
        }else{
            $valida_botones = null;
        }

        //Proceso para preperfilar candidatos
        event(new \App\Events\PreperfiladosEvent($nuevoRequerimiento));


        $ids_requerimientos = [$nuevoRequerimiento->id];


        //Crea requerimientos multiciudad
        if($data->get('select_multi_reque') != '' && $data->get('select_multi_reque') == 1){
            $ciudadRequeMulti   = $data->get('ciudad_trabajo_multi');
            $salarioRequeMulti  = $data->get('salario_multi');
            $vacantesRequeMulti = $data->get('num_vacantes_multi');


            for ($i = 0; $i < count($ciudadRequeMulti); $i++) {
                $ciudadReq = Ciudad::find($ciudadRequeMulti[$i]);

                $pais_id_multi = $ciudadReq->cod_pais;
                $departamento_id_multi = $ciudadReq->cod_departamento;
                $ciudad_id_multi = $ciudadReq->cod_ciudad;

                if (route('home') != "http://komatsu.t3rsc.co") {

                    $nuevoRequerimiento = new Requerimiento();
                    $nuevoRequerimiento->fill($data->all());
                
                    //cambiar
                    if(route('home')=="http://tiempos.t3rsc.co") {
                        $nuevoRequerimiento->salario =str_replace('.', '',$data->salarioReqs[$i]);
                    }
                    //*****

                    $nombre = $nuevoRequerimiento->nombre_cliente_req();

                    //$nombre = Clientes::find($data->get('cliente_id'))->pluck('nombre');
                    $mensaje_default = nl2br("Estamos buscando personas con mucha actitud y ganas de trabajar para desempeñarse en el cargo de $cargo_especifico->descripcion, queremos que hagas parte de la familia $nombre, por lo cual te invitamos a que:\r\n

                    - Completes tu hoja de vida.\n
                    - Grabes un video perfil para que mejores las probabilidades de ser seleccionado en el cargo.\n
                    -  Apliques a las vacantes y contestes las preguntas de preselección que nuestro equipo de selección ha preparado para ti !\n

                    Éxitos en tu aplicación y esperamos que este cargo aporte en tus objetivos laborales y de vida!");

                    $nuevoRequerimiento->descripcion_oferta    = $mensaje_default;

                    $nuevoRequerimiento->sitio_trabajo         = $ciudadReq->getSitioTrabajo($pais_id_multi,$departamento_id_multi,$ciudad_id_multi);

                    $nuevoRequerimiento->num_vacantes          = $vacantesRequeMulti[$i];
                    $nuevoRequerimiento->salario               = $salarioRequeMulti[$i];

                    $nuevoRequerimiento->pais_id               = $pais_id_multi;
                    $nuevoRequerimiento->departamento_id       = $departamento_id_multi;
                    $nuevoRequerimiento->ciudad_id             = $ciudad_id_multi;

                    $nuevoRequerimiento->estado_publico        = 1;

                    $nuevoRequerimiento->cargo_codigo          = $cargo_especifico->cargo_codigo;
                    $nuevoRequerimiento->created_at          = $fecha_mañana;
                    $nuevoRequerimiento->grado_codigo          = $cargo_especifico->grado_codigo;

                    $nuevoRequerimiento->save();

                    array_push($ids_requerimientos, $nuevoRequerimiento->id);

                    if($data->hasFile("perfil")){
                        $archivo   = $data->file('perfil');
                        $extension = $archivo->getClientOriginalExtension();
                        $name_documento_multi  = "documento_" . $nuevoRequerimiento->id . ".$extension";

                        \File::copy("documentos_solicitud/$name_documento", "documentos_solicitud/$name_documento_multi");

                        $nuevoRequerimiento->documento = $name_documento_multi;
                        $nuevoRequerimiento->save();
                    }

                }else{

                    $nuevoRequerimiento = new Requerimiento();
                 
                    $mensaje_koma = "Hola, Queremos contar contigo, Komatsu multinacional necesita alguien como tú, si cumples con el perfil aplica a nuestra oferta y has parte de nuestro equipo en Colombia!";

                    $nuevoRequerimiento->fill($data->all());

                    $nuevoRequerimiento->sitio_trabajo         = $ciudadReq->getSitioTrabajo($pais_id_multi,$departamento_id_multi,$ciudad_id_multi);

                    $nuevoRequerimiento->num_vacantes          = $vacantesRequeMulti[$i];
                    $nuevoRequerimiento->salario               = $salarioRequeMulti[$i];

                    $nuevoRequerimiento->pais_id               = $pais_id_multi;
                    $nuevoRequerimiento->departamento_id       = $departamento_id_multi;
                    $nuevoRequerimiento->ciudad_id             = $ciudad_id_multi;

                    $nuevoRequerimiento->descripcion_oferta    = $mensaje_koma;
                    $nuevoRequerimiento->estado_publico        = 1;
                    
                    $nuevoRequerimiento->cargo_codigo          = $cargo_especifico->cargo_codigo;
                    $nuevoRequerimiento->created_at            = $fecha_mañana;
                    $nuevoRequerimiento->grado_codigo          = $cargo_especifico->grado_codigo;

                    $nuevoRequerimiento->save();

                    array_push($ids_requerimientos, $nuevoRequerimiento->id);
                }

                $num_vacantes = $vacantesRequeMulti[$i];

                //Ajuste ANS OCT 30
                $ans = NegocioANS::where("negocio_id", $data->get("negocio_id"))->get();

                if($ans->count() > 0){

                    $inicio_rango = 0;
                    $fin_rango    = 0;
                    $hay_ans      = false;
                    $current      = Carbon::parse($nuevoRequerimiento->created_at);
                    $future       = Carbon::parse($nuevoRequerimiento->fecha_ingreso);
                    $dias_gestion = $current->diffInDays($future);
                    
                    foreach ($ans as $key => $value) {
                        
                       list($inicio_rango, $fin_rango) = explode("A",strtoupper($value->regla));

                        if(($num_vacantes>=$inicio_rango) && ($num_vacantes<=$fin_rango) && !$hay_ans ){
                           
                           //$dias_gestion                  = $value->cantidad_dias;
                          $cuantos_candidatos_presentar  = $value->num_cand_presentar_vac * $num_vacantes;
                           $cuantos_dias_presentar_antes  = $value->dias_presentar_candidatos_antes;
                           $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
                           $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)
                                ->subWeekdays($cuantos_dias_presentar_antes);

                           $hay_ans=true;

                        }
                    }

                    //si no hay ans traemos los valores por defecto
                    if( !$hay_ans ){

                        $dias_gestion                  = config('conf_aplicacion.DIAS_DEFECTO_REQUERIMIENTO');
                        $cuantos_candidatos_presentar  = config('conf_aplicacion.CANTIDAD_DE_CAND_A_PRESENTAR_VACANTE') * config('conf_aplicacion.VACANTES_DEFECTO') ;
                        $cuantos_dias_presentar_antes  = config('conf_aplicacion.DIAS_PRESENTACION_CAND_DEFECTO');
                        $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
                        $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)->subWeekdays($cuantos_dias_presentar_antes);
                    }

                }else{

                    $current = Carbon::parse($nuevoRequerimiento->created_at);
                    $current1 = $current->format('Y-m-d');
                    $current2 = Carbon::parse($current1);
                    
                    $future = Carbon::parse($nuevoRequerimiento->fecha_ingreso);
                    $future1 = $future->format('Y-m-d');
                    $future2 = Carbon::parse($future1);

                   $dias_gestion = $future2->diffInDays($current2);

                    $cuantos_candidatos_presentar  = config('conf_aplicacion.CANTIDAD_DE_CAND_A_PRESENTAR_VACANTE') * config('conf_aplicacion.VACANTES_DEFECTO') ;
                    $cuantos_dias_presentar_antes  = config('conf_aplicacion.DIAS_PRESENTACION_CAND_DEFECTO');
                    $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
                    $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)->subWeekdays($cuantos_dias_presentar_antes);
                }

                //preperfilar candidatos al req

                $req_actualizacion = Requerimiento::find($nuevoRequerimiento->id);

                if (route('home') == "http://vym.t3rsc.co" || route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://vym.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co") {

                    $date_r       = Carbon::now();
                   
                    $fecha_mañana = $date_r->addDays(1)->toDateString();

                    $hora_req= Carbon::parse($nuevoRequerimiento->created_at);
                    $fecha_mañana .= ' 00:00:00';
                    
                    //if($hora_req->hour >= 12){
                      $req_actualizacion->created_at = $fecha_mañana;
                    //}
                }

                //Se verifica si el sitio configura la prueba de Excel Basico y/o Intermedio
                if ($sitio->prueba_excel_basico || $sitio->prueba_excel_intermedio) {
                    //Se verifica si el cargo tiene configurada alguna prueba de Excel
                    if ($cargo_especifico->excel_basico || $cargo_especifico->excel_intermedio) {
                        $config_excel_req = new PruebaExcelConfiguracion();

                        $config_excel_req->gestiono     = $this->user->id;
                        $config_excel_req->req_id       = $nuevoRequerimiento->id;
                        $config_excel_req->excel_basico                 = $cargo_especifico->excel_basico;
                        $config_excel_req->excel_intermedio             = $cargo_especifico->excel_intermedio;
                        $config_excel_req->tiempo_excel_basico          = $cargo_especifico->tiempo_excel_basico;
                        $config_excel_req->tiempo_excel_intermedio      = $cargo_especifico->tiempo_excel_intermedio;
                        $config_excel_req->aprobacion_excel_basico      = $cargo_especifico->aprobacion_excel_basico;
                        $config_excel_req->aprobacion_excel_intermedio  = $cargo_especifico->aprobacion_excel_intermedio;

                        $config_excel_req->save();
                    }
                }

                //Se verifica si el sitio configura la prueba de valores 1
                if ($sitioModulo->prueba_valores_1 == 'enabled') {
                    $cargoConfigPruebas = CargoEspecificoConfigPruebas::where('cargo_especifico_id', $data->get("cargo_especifico_id"))->orderBy('created_at', 'DESC')->first();

                    //Si el cargo tiene configurada la prueba de valores, se agrega la configuracion al requerimiento
                    if ($cargoConfigPruebas != null) {
                        $newPruebaValoresConfigReq = new PruebaValoresConfigRequerimiento();
                        $newPruebaValoresConfigReq->gestiono            = $this->user->id;
                        $newPruebaValoresConfigReq->req_id              = $nuevoRequerimiento->id;
                        $newPruebaValoresConfigReq->prueba_valores_1    = 'enabled';
                        $newPruebaValoresConfigReq->valor_verdad        = $cargoConfigPruebas->valor_verdad;
                        $newPruebaValoresConfigReq->valor_rectitud      = $cargoConfigPruebas->valor_rectitud;
                        $newPruebaValoresConfigReq->valor_paz           = $cargoConfigPruebas->valor_paz;
                        $newPruebaValoresConfigReq->valor_amor          = $cargoConfigPruebas->valor_amor;
                        $newPruebaValoresConfigReq->valor_no_violencia  = $cargoConfigPruebas->valor_no_violencia;

                        $newPruebaValoresConfigReq->save();
                    }
                }

                //Comienzo guardar adicionales
                    if($data->has("clausulas") && is_array($data->get("clausulas"))) {
                        foreach($data->get("clausulas") as $key => $clausula) {
                            //Si hay un valor adicional configurado se crea la asociación en la tabla
                            if($data->has("valor_adicional") && is_array($data->get("valor_adicional"))) {
                                //if ($data->get("valor_adicional")[$key] != 0) {
                                    $documento_adicional_valor = new ClausulaValorRequerimiento();

                                    $documento_adicional_valor->fill([
                                        'req_id' => $nuevoRequerimiento->id,
                                        'adicional_id' => $clausula,
                                        'valor' => $data->get("valor_adicional")[$key],
                                    ]);
                                    $documento_adicional_valor->save();
                                //}
                            }
                        }
                    }
                //Fin guardar adicionales

                $req_actualizacion->dias_gestion                  = $dias_gestion;
                $req_actualizacion->cuantos_candidatos_presentar  = $cuantos_candidatos_presentar;
                $req_actualizacion->cuantos_dias_presentar_antes  = $cuantos_dias_presentar_antes;
                $req_actualizacion->fecha_presentacion_oport_cand = $fecha_presentacion_oport_cand;
                $req_actualizacion->fecha_tentativa_cierre_req    = $fecha_tentativa_cierre_req;
                $req_actualizacion->fecha_terminacion             = $fecha_tentativa_cierre_req;

                $req_actualizacion->save();

                $terminar_req = new EstadosRequerimientos();

                $terminar_req->fill([
                    "estado"       => config('conf_aplicacion.C_RECLUTAMIENTO'),
                    "user_gestion" => $this->user->id,
                    "req_id"       => $nuevoRequerimiento->id,
                ]);

                $terminar_req->save();

                $solicitado_por = Requerimiento::leftjoin('datos_basicos','datos_basicos.user_id','=','requerimientos.solicitado_por')
                ->where('requerimientos.id',$nuevoRequerimiento->id)
                ->select('datos_basicos.nombres as nombre_user_soli')
                ->first();

                if(($solicitado_por->nombre_user_soli != "") && (!is_null($solicitado_por->nombre_user_soli))){ 
                    $solicitado = $solicitado_por->nombre_user_soli;
                }else{
                    $solicitado = $this->user->name;
                }

                $dataView = [
                    'solicitado_por'   => $solicitado,
                    'sitio_trabajo'   => $data->get('sitio_trabajo'),
                    'num_vacantes'    => $data->get('num_vacantes'),
                    'pais_id'         => $data->get('pais_id'),
                    'departamento_id' => $data->get('departamento_id'),
                    'ciudad_id'     => $data->get('ciudad_id'),
                ];
            
                $emails = User::join('datos_basicos','datos_basicos.user_id','=','users.id')
                ->join('users_x_clientes','users_x_clientes.user_id','=','users.id')
                ->join('role_users','role_users.user_id','=','users.id')
                ->join('clientes','clientes.id','=','users_x_clientes.cliente_id')
                ->join('negocio','negocio.cliente_id','=','clientes.id')
                ->join('requerimientos','requerimientos.negocio_id','=','negocio.id')
                ->where("users.notificacion_requisicion",1)
                ->where('requerimientos.id',$nuevoRequerimiento->id)
                ->where('role_users.role_id',17)
                ->groupBy("users.id")
                ->get();

                $funcionesGlobales = new FuncionesGlobales();

                if(isset($funcionesGlobales->sitio()->nombre)) {
                    if($funcionesGlobales->sitio()->nombre != "") {
                        $nombre = $funcionesGlobales->sitio()->nombre;
                    }else{
                        $nombre = "Desarrollo";
                    }
                }

                $dataView = [
                    'solicitado_por'  => $solicitado,
                    'sitio_trabajo'   => $data->get('sitio_trabajo'),
                    'num_vacantes'    => $data->get('num_vacantes'),
                    'pais_id'         => $data->get('pais_id'),
                    'departamento_id' => $data->get('departamento_id'),
                    'ciudad_id'       => $data->get('ciudad_id'),
                ];
            
                $requerimiento_id = $req_actualizacion;

                if(route("home")!="http://vym.t3rsc.co" && route("home")!="https://vym.t3rsc.co"){
                    foreach ($emails as $key => $value) { 
                        Mail::send('req.emails.notificacion_req', ['nombre_usuario'=>$value->nombres,'req' => $requerimiento_id,'data'=>$dataView, "cargo_especifico" => $cargo_especifico], function ($m) use($value, $requerimiento_id) {
                            $m->subject('Nueva requisicion No. '.$requerimiento_id->id );
                            $m->to($value->email,'$nombre -T3RS')
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                        });
                    }
                }
            }

            $ids = implode(", ", $ids_requerimientos);

            return redirect()->route("admin.ofertas")->with(["mensaje_success" => "Se crearon los requerimientos con ID ".$ids, "mensaje_no_postulados" => $mensaje_no_postulados]);
            //return redirect()->with("mensaje_success", "Se ha actualizado la oferta");
        }else{
            if ($data->get('tipo_proceso_id') != 7) {
                /*** Creación de oferta en ElEmpleo ***/
                if (route("home") == "http://listos.t3rsc.co" || route("home") == "https://listos.t3rsc.co" ||
                    route("home") == "http://vym.t3rsc.co" || route("home") == "https://vym.t3rsc.co") {
                    $response = null;
                    try {
                        $client = new SoapClient("https://www.elempleo.com/colombia/WebServices/JobOfferServices.asmx?WSDL");

                        # Sandbox ElEmpleo
                        // https://uat.elempleo.com/colombia/WebServices/CompanyServices.asmx?WSDL
                        // https://uat.elempleo.com/colombia/WebServices/JobOfferServices.asmx?WSDL

                        # Productivo ElEmpleo
                        // https://www.elempleo.com/colombia/WebServices/JobOfferServices.asmx?WSDL

                        #Credenciales Test
                        // listospruebaws1@listos.com
                        // Listows123*

                        #Credenciales Productivo
                        // liliana.marin@listos.com.co
                        // Dima8911

                        //Objeto token
                        $params = array(
                            "token" => array(
                                "UserName" => "liliana.marin@listos.com.co",
                                "Password" => "Dima8911"
                            )
                        );

                        //Obteniendo datos para oferta
                        #Cargo datos
                        $cargoEspecificoEE = CargoEspecifico::find($data->get("cargo_especifico_id"));

                        $tituloOfertaEE = $cargoEspecificoEE->descripcion;
                        $cargoIdEE = $cargoEspecificoEE->cargo_generico_id;

                        $salarioDesc = $data->get('salario');

                        //Define descripción
                        if ($data->get("tipo_experiencia_id") == 1) {
                            $offerDescription = "Importante empresa requiere para su equipo de trabajo, profesional en $tituloOfertaEE o carreras afines, no necesita experiencia realizando tareas y actividades acordes al perfil. Salario $salarioDesc.";
                        }else if($data->get("tipo_experiencia_id") == 2 || $data->get("tipo_experiencia_id") == 3){
                            $offerDescription = "Importante empresa requiere para su equipo de trabajo, profesional en $tituloOfertaEE o carreras afines, con experiencia de menos de un año realizando tareas y actividades acordes al perfil. Salario $salarioDesc.";
                        }else{
                            $experienciaDesc = FuncionesGlobales::getExperienceDescriptionEE($data->get("tipo_experiencia_id"));

                            $offerDescription = "Importante empresa requiere para su equipo de trabajo, profesional en $tituloOfertaEE o carreras afines, con experiencia de $experienciaDesc realizando tareas y actividades acordes al perfil. Salario $salarioDesc.";
                        }

                        //Datos que requiere la creación
                        $params_offer = array(
                            "jobOfferToken" => array(
                                #Titulo de la oferta
                                'Title'                => $tituloOfertaEE,
                                #Descripción de la oferta
                                'Description'          => $offerDescription,
                                #Requerimientos de la oferta
                                'Requirements'         => '.',
                                #Mostrar nombre de la empresa
                                'PublishCompanyName'   => true,
                                #Publicar en el sitio de la empresa
                                'PublishInCompanySite' => false,
                                #Oferta interna de la empresa
                                'InternalCall'         => false,
                                #Oferta compartida
                                'IsShared'             => false,
                                #Nivel de cargo
                                'PositionSubLevelId'   => 9,
                                #Salario
                                'SalaryId'             => FuncionesGlobales::getSalaryIdEE($data->get("salario")),
                                #Cantidad de vacantes
                                'VacancyQuantity'      => (int) $num_vacantes,
                                #Tiempo expiración oferta
                                'ExpirationTimeId'     => 5,
                                #Tipo de contrato
                                'ContractTypeId'       => FuncionesGlobales::getContractIdEE($data->get("tipo_contrato_id")),
                                #Horario de trabajo
                                'WorkingPeriodId'      => 3,
                                #Experiencia requerida
                                'RequiredExperienceId' => FuncionesGlobales::getExperienceIdEE($data->get("tipo_experiencia_id")),
                                #Nivel educativo
                                'EducationStatus'      => 'Graduate',
                                #Profesión solicitada
                                'ProfessionIds'        => [101235134],
                                #Posicion de la profesión
                                'PositionIds'          => [99],
                                #Ciudad de la oferta
                                'CitiesIds'            => [34],
                                #Sectores de trabajo
                                'SectorIds'            => [1195],
                                #Áreas de trabajo
                                'WorkAreaIds'          => [25, 51],
                                #Género que busca la oferta
                                'Gender'               => FuncionesGlobales::getGenderIdEE($data->get("genero_id")),
                                #Idioma en que se publica
                                'LanguageId'           => 2,
                                #Nivel del idioma elegido
                                'KnowledgeLevelId'     => 8,
                                #Usuario que publica
                                'UserName'             => 'liliana.marin@listos.com.co',
                                'Password'             => 'Dima8911',

                                'ReturnUrl'            => 'https://listos.t3rsc.co',
                                #Mostrar salario
                                'PublishSalary'        => true,
                                #Edad minima
                                'Lower'                => $data->get("edad_minima"),
                                #Edad máxima
                                'Upper'                => $data->get("edad_maxima")
                            )
                        );

                        # Obtiene las funciones que se pueden usar
                        //$response = $client->__getFunctions();
                        //$response = $client->__getTypes();

                        # Verificar el WS
                        //$response = $client->TestWs();

                        # Autenticar Empresa
                        //$response = $client->AutenticarUsuarioEmpresas($params);

                        # Obtener ultima oferta registrada
                        //$response = $client->GetLastPublishes($params);

                        # Ver usuarios registrados
                        //$response = $client->GetEmployeeResumees($params);

                        # Ver procesos de selección
                        //$response = $client->GetSelectionProcesses($params);

                        # Crear ofera y retorna ID de oferta
                        $response = $client->InsertJobOfferReturnId($params_offer);
                        //$response = $client->InsertJobOffer($params_offer);

                        //$response = $client->GetLastPublishes($params);

                        //$response = $client->GetSelectionProcesses($params);

                        $req_actualizacion->IdJobOfferEE = $response->InsertJobOfferReturnIdResult->IdJobOffer;
                        $req_actualizacion->save();
                    } catch (\Throwable $t) {
                        Mail::send('req.emails.notificacion_elempleo', [
                            'response' => $t,
                            'req_id'   => $req_id
                        ], function ($m) use($req_id) {
                            $m->subject('ElEmpleo ERROR ADMIN'.$req_id);
                            $m->to(['sebastianb.t3rs@gmail.com'], 'Sebastian -T3RS')
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                        });
                    }
                }
            }

            //Atributos TODO
            return redirect()->route("admin.ofertas")->with(["mensaje_success" => "Se creó el requerimiento ID " . $nuevoRequerimiento->id, "mensaje_no_postulados" => $mensaje_no_postulados]);
        }

        return redirect()->route("admin.ofertas")->with(["mensaje_success" => "Se creó el requerimiento ID " . $nuevoRequerimiento->id, "mensaje_no_postulados" => $mensaje_no_postulados]);
    }

    // Client side
    public function guardar_requerimiento(Request $data)
    {
        $date_r       = Carbon::now();
        $fecha_mañana = $date_r->addWeekdays(1)->toDateString();
        $fecha_mañana .= ' 00:00:00';
 
        $cargo_especifico = CargoEspecifico::find($data->get("cargo_especifico_id"));
        
        //$ciudadReq = Ciudad::find($data->get('ciudad_trabajo'));
        $pais_id = $data->pais_id;
        $departamento_id = $data->departamento_id;
        $ciudad_id = $data->ciudad_id;

        $nuevoRequerimiento = new Requerimiento();

        $nuevoRequerimiento->fill($data->all());
        $nuevoRequerimiento->observaciones = $data->get('observaciones');       
        $nuevoRequerimiento->sitio_trabajo = $data->sitio_trabajo;
        $nuevoRequerimiento->confidencial = $data->get('confidencial');
        $nuevoRequerimiento->tipo_liquidacion = $data->tipo_liquidacion;

        if(route('home') != "https://temporizar.t3rsc.co") {

            $mensaje_default = nl2br("En esta oferta de empleo buscamos personas que se perfilen en el cargo de $cargo_especifico->descripcion, nos gustaría acompañarte en tu camino laboral, por lo cual te invitamos a que:\r\n
                - Completes tu hoja de vida.\n
                - Grabes un video perfil para que mejores las probabilidades de ser seleccionado en el cargo.\n
                -  Apliques a las vacantes y contestes las preguntas de preselección que nuestro equipo de selección ha preparado para ti !\n
                Éxitos en tu aplicación y esperamos que este cargo aporte en tus objetivos laborales y de vida!");
        }else {

            $mensaje_default = nl2br("En Temporizar estamos buscando personas como tú! Con Actitud, soñadoras, con ganas de trabajar y sobre todo con muchas ganas de hacer realidad sus proyectos!. 
                
                En esta oferta de empleo buscamos personas que se perfilen en el cargo de $cargo_especifico->descripcion. 
                
                Nos gustaría acompañarte en tu camino laboral, por lo cual te invitamos a que:\r\n
                - Completes tu hoja de vida.\n
                - Grabes un video perfil para que mejores las probabilidades de ser seleccionado en el cargo.\n
                -  Apliques a las vacantes y contestes las preguntas de preselección que nuestro equipo de selección ha preparado para ti !\n
                Éxitos en tu aplicación y esperamos que este cargo aporte en tus objetivos laborales y de vida!");
        }

        $nuevoRequerimiento->descripcion_oferta = $mensaje_default;

        $nuevoRequerimiento->pais_id = $pais_id;
        $nuevoRequerimiento->created_at = $fecha_mañana;
        $nuevoRequerimiento->departamento_id = $departamento_id;
        $nuevoRequerimiento->ciudad_id = $ciudad_id;
        if($data->get('confidencial') == 1){ $p = 0; }else{ $p=1;}
        $nuevoRequerimiento->estado_publico = $p;
        $nuevoRequerimiento->cargo_codigo = $cargo_especifico->cargo_codigo;
        $nuevoRequerimiento->grado_codigo = $cargo_especifico->grado_codigo;

        if(route("home") == "https://desarrollo.t3rsc.co" || route("home") == "https://listos.t3rsc.co" || route("home") == "https://vym.t3rsc.co" || route("home") == "http://localhost:8000"){
            $nuevoRequerimiento->empresa_contrata = $data->empresa_contrata;
            $nuevoRequerimiento->centro_costo_id = $data->centro_costo_id;

            if((route("home") == "https://listos.t3rsc.co" || route("home") == "http://localhost:8000") && $data->cliente_id == 168) {
                $nuevoRequerimiento->centro_costo_cliente = $data->centro_costo_cliente;
                $nuevoRequerimiento->unidad_negocio = $data->unidad_negocio;
                $nuevoRequerimiento->tipo_turno = $data->tipo_turno;
            }
        }

        if(route('home') == "https://gpc.t3rsc.co") {
            $nuevoRequerimiento->conocimientos_especificos = $data->conocimientos_especificos;
            $nuevoRequerimiento->id_idioma                 = $data->id_idioma;
            $nuevoRequerimiento->nivel_idioma              = $data->nivel_idioma;
            $nuevoRequerimiento->cargo_generico_id         = $cargo_especifico->cargo_generico_id;
            $nuevoRequerimiento->salario_max               = $data->salario_max;
            $nuevoRequerimiento->salario_variable          = $data->salario_variable;
        }

        $nuevoRequerimiento->save();
         
        if($data->hasFile('perfil')) {
            $imagen     = $data->file("perfil");
            $extension  = $imagen->getClientOriginalExtension();
            $name_documento = "documento_" . $nuevoRequerimiento->id . "." . $extension;
            $imagen->move("documentos_solicitud", $name_documento);

            $nuevoRequerimiento->documento = $name_documento;        
            $nuevoRequerimiento->save();
        }

        $num_vacantes = $data->get("num_vacantes");

        //Ajuste ANS OCT 30
        $ans = NegocioANS::where("negocio_id", $data->get("negocio_id"))->get();

        if($ans->count() > 0) {
            $inicio_rango = 0;
            $fin_rango    = 0;
            $hay_ans      = false;
            $current      = Carbon::parse($nuevoRequerimiento->created_at);
            $future       = Carbon::parse($nuevoRequerimiento->fecha_ingreso);
            $dias_gestion = $current->diffInDays($future);

            foreach ($ans as $key => $value) {
                list($inicio_rango, $fin_rango) = explode("A",strtoupper($value->regla));

                if(($num_vacantes >= $inicio_rango) && ($num_vacantes <= $fin_rango) && !$hay_ans ) {
                    //$dias_gestion                  = $value->cantidad_dias;
                    $cuantos_candidatos_presentar  = $value->num_cand_presentar_vac * $num_vacantes;
                    $cuantos_dias_presentar_antes  = $value->dias_presentar_candidatos_antes;
                    $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
                    $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)->subWeekdays($cuantos_dias_presentar_antes);

                    $hay_ans = true;
                }
            }

            //si no hay ans traemos los valores por defecto
            if(!$hay_ans ) {
                $dias_gestion                  = config('conf_aplicacion.DIAS_DEFECTO_REQUERIMIENTO');
                $cuantos_candidatos_presentar  = config('conf_aplicacion.CANTIDAD_DE_CAND_A_PRESENTAR_VACANTE') * config('conf_aplicacion.VACANTES_DEFECTO') ;
                $cuantos_dias_presentar_antes  = config('conf_aplicacion.DIAS_PRESENTACION_CAND_DEFECTO');
                $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
                $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)->subWeekdays($cuantos_dias_presentar_antes);
            }
        }else {
            $dias_gestion                  = config('conf_aplicacion.DIAS_DEFECTO_REQUERIMIENTO');
            $cuantos_candidatos_presentar  = config('conf_aplicacion.CANTIDAD_DE_CAND_A_PRESENTAR_VACANTE') * config('conf_aplicacion.VACANTES_DEFECTO') ;
            $cuantos_dias_presentar_antes  = config('conf_aplicacion.DIAS_PRESENTACION_CAND_DEFECTO');
            $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
            $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)->subWeekdays($cuantos_dias_presentar_antes);
        }

        $req_actualizacion = Requerimiento::find($nuevoRequerimiento->id);

        if (route('home') == "http://vym.t3rsc.co" || route('home') == "http://tiempos.t3rsc.co" ||
            route('home') == "https://vym.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co"){
            $date_r       = Carbon::now();
           
            $fecha_mañana = $date_r->addWeekdays(1)->toDateString();
            $fecha_mañana .= ' 00:00:00';

            $hora_req= Carbon::parse($nuevoRequerimiento->created_at);

            //if($hora_req->hour >= 11){
              $req_actualizacion->created_at = $fecha_mañana;
            //}
        }

        $req_actualizacion->dias_gestion                  = $dias_gestion;
        $req_actualizacion->cuantos_candidatos_presentar  = $cuantos_candidatos_presentar;
        $req_actualizacion->cuantos_dias_presentar_antes  = $cuantos_dias_presentar_antes;
        $req_actualizacion->fecha_presentacion_oport_cand = $fecha_presentacion_oport_cand;
        $req_actualizacion->fecha_tentativa_cierre_req    = $fecha_tentativa_cierre_req;
        $req_actualizacion->fecha_terminacion             = $fecha_tentativa_cierre_req;

        $req_actualizacion->save();

        $terminar_req = new EstadosRequerimientos();

        $terminar_req->fill([
            "estado"       => config('conf_aplicacion.C_RECLUTAMIENTO'),
            "user_gestion" => $this->user->id,
            "req_id"       => $nuevoRequerimiento->id,
        ]);

        $terminar_req->save();

        //$cargo_generico = CargoGenerico::find($data->get("cargo_generico_id"));
        $dataView = [
            'solicitado_por'  => $data->get('solicitado_por_txt'),
            'sitio_trabajo'   => $data->get('sitio_trabajo'),
            'num_vacantes'    => $data->get('num_vacantes'),
            'pais_id'         => $data->get('pais_id'),
            'departamento_id' => $data->get('departamento_id'),
            'ciudad_id'       => $data->get('ciudad_id'),
        ];

        $sitio = Sitio::first();

        if(isset($sitio->nombre)){
          
          if($sitio->nombre != "") {
            $nombre = $sitio->nombre;
          }else{
            $nombre = "Desarrollo";
          }
        }

        //Se verifica si el sitio configura la prueba de Excel Basico y/o Intermedio
        if ($sitio->prueba_excel_basico || $sitio->prueba_excel_intermedio) {
            //Se verifica si el cargo tiene configurada alguna prueba de Excel
            if ($cargo_especifico->excel_basico || $cargo_especifico->excel_intermedio) {
                $config_excel_req = new PruebaExcelConfiguracion();

                $config_excel_req->gestiono     = $this->user->id;
                $config_excel_req->req_id       = $nuevoRequerimiento->id;
                $config_excel_req->excel_basico                 = $cargo_especifico->excel_basico;
                $config_excel_req->excel_intermedio             = $cargo_especifico->excel_intermedio;
                $config_excel_req->tiempo_excel_basico          = $cargo_especifico->tiempo_excel_basico;
                $config_excel_req->tiempo_excel_intermedio      = $cargo_especifico->tiempo_excel_intermedio;
                $config_excel_req->aprobacion_excel_basico      = $cargo_especifico->aprobacion_excel_basico;
                $config_excel_req->aprobacion_excel_intermedio  = $cargo_especifico->aprobacion_excel_intermedio;

                $config_excel_req->save();
            }
        }

        $sitioModulo = SitioModulo::first();

        //Se verifica si el sitio configura la prueba de valores 1
        if ($sitioModulo->prueba_valores_1 == 'enabled') {
            $cargoConfigPruebas = CargoEspecificoConfigPruebas::where('cargo_especifico_id', $data->get("cargo_especifico_id"))->orderBy('created_at', 'DESC')->first();

            //Si el cargo tiene configurada la prueba de valores, se agrega la configuracion al requerimiento
            if ($cargoConfigPruebas != null) {
                $newPruebaValoresConfigReq = new PruebaValoresConfigRequerimiento();
                $newPruebaValoresConfigReq->gestiono            = $this->user->id;
                $newPruebaValoresConfigReq->req_id              = $nuevoRequerimiento->id;
                $newPruebaValoresConfigReq->prueba_valores_1    = 'enabled';
                $newPruebaValoresConfigReq->valor_verdad        = $cargoConfigPruebas->valor_verdad;
                $newPruebaValoresConfigReq->valor_rectitud      = $cargoConfigPruebas->valor_rectitud;
                $newPruebaValoresConfigReq->valor_paz           = $cargoConfigPruebas->valor_paz;
                $newPruebaValoresConfigReq->valor_amor          = $cargoConfigPruebas->valor_amor;
                $newPruebaValoresConfigReq->valor_no_violencia  = $cargoConfigPruebas->valor_no_violencia;

                $newPruebaValoresConfigReq->save();
            }
        }

        //Comienzo guardar adicionales
            if($data->has("clausulas") && is_array($data->get("clausulas"))) {
                foreach($data->get("clausulas") as $key => $clausula) {
                    //Si hay un valor adicional configurado se crea la asociación en la tabla
                    if($data->has("valor_adicional") && is_array($data->get("valor_adicional"))) {
                        //if ($data->get("valor_adicional")[$key] != 0) {
                            $documento_adicional_valor = new ClausulaValorRequerimiento();

                            $documento_adicional_valor->fill([
                                'req_id' => $nuevoRequerimiento->id,
                                'adicional_id' => $clausula,
                                'valor' => $data->get("valor_adicional")[$key],
                            ]);
                            $documento_adicional_valor->save();
                        //}
                    }
                }
            }
        //Fin guardar adicionales

        //Candidatos enviados por el cliente
        $tipo_fuente_id = config('conf_aplicacion.COD_TIPO_FUENTE_CANDIDATOS_ENVIADOS_CLIENTE');

        $can_nombres    = $data->get('can_nombres');
        $can_apellido   = $data->get('can_apellido');
        $can_cedulas    = $data->get('can_cedula');
        $can_moviles    = $data->get('can_movil');
        $can_emails     = $data->get('can_email');

        $candidatos_no_postulados = [];
        //Verificación campos de postulados
        for($i = 0; $i < count($can_nombres); $i++) {
          
            if( strlen($can_cedulas[$i]) == 0 && strlen($can_nombres[$i]) == 0 && strlen($can_apellido[$i]) == 0 && strlen($can_moviles[$i]) == 0 &&  strlen($can_emails[$i]) == 0){
                break;
            }

            if ( strlen($can_cedulas[$i]) == 0 ) {
                /*viene algun campo lleno pero no la cedula
                entonces lo sacamos tambien por ahora mientras resolvemos esto*/

                break;
            }

            $nombre_candidato = strlen($can_nombres[$i]) > 1 ? $can_nombres[$i] : "Nombre no ingresado";

            $cedula_candidato = strlen($can_cedulas[$i]) > 1 ? $can_cedulas[$i] : "Cedula no Ingresada";

            $apellido_candidato = strlen($can_apellido[$i]) > 1 ? $can_apellido[$i] : "Apellido no ingresado";

            $movil_candidato = strlen($can_moviles[$i]) > 1 ? $can_moviles[$i] : "Movil no ingresado";

            $email_candidato = strlen($can_emails[$i]) > 1 ? $can_emails[$i] : "Email no ingresado";

            $tipo_proceso_req=TipoProceso::find($nuevoRequerimiento->tipo_proceso_id);

            $datos_basicos = DatosBasicos::where('numero_id',$can_cedulas[$i])->first();

            if(is_null($datos_basicos)){
                $se_puede_postular = 'SI';
                //Creamos el usuario
                $campos_usuario = [
                    'name'      => $can_nombres[$i].' '.$can_apellido[$i],
                    'email'     => $can_emails[$i],
                    'password'  => $can_cedulas[$i],
                    'numero_id' => $can_cedulas[$i],
                    'cedula'    => $can_cedulas[$i]
                ];
        
                $user = Sentinel::registerAndActivate($campos_usuario);
            
                $usuario_id = $user->id;
               
               $apellidos = explode(" ", $can_apellido[$i], 2);

                $primer_apellido = $apellidos ? $apellidos[0] : NULL;

                $segundo_apellido = $apellidos ? $apellidos[1] : NULL;

                //Creamos sus datos basicos
                $datos_basicos = new DatosBasicos();
                $datos_basicos->fill([
                    'numero_id'             => $can_cedulas[$i],
                    'user_id'               => $usuario_id,
                    'nombres'               => $can_nombres[$i],
                    'primer_apellido'       => $primer_apellido,
                    'segundo_apellido'      => $segundo_apellido,
                    'telefono_movil'        => $can_moviles[$i],
                    'estado_reclutamiento'  => config('conf_aplicacion.C_ACTIVO'),
                    'datos_basicos_count'   => "100",
                    'email'                 => $can_emails[$i]
                ]);

                $datos_basicos->save();
                
                //Creamos el rol
                $role = Sentinel::findRoleBySlug('hv');
                $role->users()->attach($user);
                //si no esxite el usuario crearlo

                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                $mailTitle = "Bienvenido a $nombre - T3RS"; //Titulo o tema del correo

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "
                    ¡Hola $datos_basicos->nombres $datos_basicos->primer_apellido $datos_basicos->segundo_apellido!<br>
                    Se ha creado exitosamente tu cuenta en T3RS, te invitamos a ingresar usando tu número de documento como usuario y contraseña para completar tu hoja de vida y cargar tus documentos.
                    ";
                //Arreglo para el botón
                $mailButton = ['buttonText' => '¡COMPLETA TU HOJA DE VIDA!', 'buttonRoute' => route('login')];

                $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $nombre) {

                    $message->to($datos_basicos->email, $datos_basicos->nombres)
                        ->subject("Bienvenido a $nombre - T3RS")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            } else {
                //Se validan estado de reclutamiento del candidato y estado del requerimiento
                $se_puede_postular = 'NO';

                if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_ACTIVO')) {
                    /*Si el estado de reclutamiento del candidato esta:
                    * 5-Activo
                    * Se puede postular al candidato
                    */
                    $se_puede_postular = 'SI';
                }else{
                    $proceso_req_cand = RegistroProceso::where("candidato_id", $datos_basicos->user_id)->orderBy('id', 'desc')->first();
                    if ($proceso_req_cand != null) {
                        if ($proceso_req_cand->estado == config('conf_aplicacion.C_CONTRATADO') || $proceso_req_cand->estado == config('conf_aplicacion.C_QUITAR')) {
                            /*Si el estado del candidato en el requerimiento anterior esta:
                            * 12-Contratado
                            * 14-Quitado
                            * Se puede postular al candidato
                            */
                            $se_puede_postular = 'SI';
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
                                $se_puede_postular = 'SI';
                            } else {
                                $req_candidato = ReqCandidato::where('requerimiento_id', $proceso_req_cand->requerimiento_id)->where("candidato_id", $datos_basicos->user_id)->orderBy('id', 'desc')->first();
                                if ($req_candidato != null && $req_candidato->estado_candidato == 24) {
                                    /*Si el estado del candidato en el requerimiento anterior esta:
                                    * 24-Contratacion cancelada
                                    * Se puede postular al candidato
                                    */
                                    $se_puede_postular = 'SI';
                                }
                            }
                        }
                        
                    }
                }
            }
                    
            if ($se_puede_postular === 'SI') {
                if ($tipo_proceso_req->contratacion_directa) {
                    $req_can = new ReqCandidato();
                    $sitio2 = Sitio::first();

                    if ($sitio2->precontrata) {
                        $estadoProceso = "PRE_CONTRATAR";
                    } else {
                        $estadoProceso = "ENVIO_CONTRATACION_CLIENTE";
                    }
                    $req_can->fill([
                        'requerimiento_id'     => $nuevoRequerimiento->id,
                        'candidato_id'         => $datos_basicos->user_id,
                        'auxilio_transporte'   => $data->get('auxilio_transporte'),
                        'tipo_ingreso'         => $data->get('tipo_ingreso'),
                        'estado_candidato'     => config('conf_aplicacion.C_APROBADO_CLIENTE')
                    ]);
                    $estado = config('conf_aplicacion.C_APROBADO_CLIENTE');

                    $req_can->save();

                    //cambiar el estado del candidato
                    $candidato  = $datos_basicos;

                    $candidato->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_CONTRATACION');

                    $candidato->save();

                    $req_can_id = $req_can->id;

                    //afiliar *************************
                    $nuevo_proceso = new RegistroProceso();
                    $nuevo_proceso->fill([
                        'requerimiento_candidato_id' => $req_can_id,
                        'estado'                     => $estado,
                        'fecha_inicio'               => date("Y-m-d H:i:s"),
                        'usuario_envio'              => $this->user->id,
                        'proceso'                    => $estadoProceso,
                        'requerimiento_id'           => $nuevoRequerimiento->id,
                        "centro_costos"              => $data["centro_costos"],
                        'candidato_id'               => $datos_basicos->user_id,
                        'observaciones'              => $data['observacionesContra'],
                        'user_autorizacion'          => $data['user_autorizacion'],
                        "usuario_terminacion"        => $this->user->id,
                        'fecha_solicitud_ingreso'    => $data['fecha_solicitud_ingreso'],
                        'fecha_real_ingreso'         => $data['fecha_real_ingreso'],
                        'fecha_inicio_contrato'      => $data['fecha_ingreso_contra'],
                        'fecha_ingreso_contra'       => $data['fecha_ingreso_contra'],
                        'hora_entrada'               => $data['hora_ingreso'],
                        'lugar_contacto'             => $data['lugar_contacto'],
                        'otros_devengos'             => $data['otros_devengos'],
                        'fecha_fin_contrato'         => $data['fecha_fin_contrato'],
                        'fecha_ultimo_contrato'      => $data['fecha_ultimo_contrato']
                    ]);

                    $nuevo_proceso->save();

                    $obj                    = new \stdClass();
                    $obj->requerimiento_id  = $nuevoRequerimiento->id;
                    $obj->user_id           = $this->user->id;
                    $obj->estado            = config('conf_aplicacion.C_EN_PROCESO_CONTRATACION');
                        
                    
                    /*Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $nombre, $sitio) {

                                $message->to($datos_basicos->email, $datos_basicos->nombres)
                                        ->subject("Bienvenido a $nombre - T3RS")
                                        ->bcc($sitio->email_replica)
                                        ->getHeaders()
                                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                        });
                    }*/

                    Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));
                } else {
                    $candidatos_fuentes = CandidatosFuentes::create([
                        "nombres"          => $nombre_candidato,
                        "cedula"           => $cedula_candidato,
                        "celular"          => $movil_candidato,
                        "email"            => $email_candidato,
                        "tipo_fuente_id"   => $tipo_fuente_id,
                        "requerimiento_id" => $nuevoRequerimiento->id,
                    ]);
                }
            } else {
                $candidatos_no_postulados[] = "$cedula_candidato - $nombre_candidato $apellido_candidato";
            }
        }
        
        if (count($candidatos_no_postulados) > 0) {
            $mensaje_no_postulados = "No se postularon los siguientes candidatos porque estan asociados en otro requerimiento o se encuentran inactivos: <br>";
            $mensaje_no_postulados .= implode("<br>", $candidatos_no_postulados);
        } else {
            $mensaje_no_postulados = null;
        }

        $req_id = $nuevoRequerimiento->id;

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
            $valida_botones = AuxiliarFicha::where("ficha_id", $datos_ficha->id)->select("*")->get();
        }else{
            $valida_botones = null;
        }

        if ($datos_ficha !== null){
            //Cuando la ficha esta creada se buscar los datos de la ficha
            $genero = $datos_ficha->genero;

            if ($genero == 1) {
                $genero = ['1'];
            } elseif ($genero == 2) {
                $genero = ['2'];
            } else {
                $genero = ['1', '2'];
            }

            // Candidatos preperfilados
            $candidatos_cargo_general = DatosBasicos::join("perfilamiento", "perfilamiento.user_id", "=", "datos_basicos.user_id")
            ->join("requerimientos", "requerimientos.cargo_generico_id", "=", "perfilamiento.cargo_generico_id")
            ->join("estudios", "estudios.user_id", "=", "datos_basicos.user_id")
            ->join('users','users.id','=','datos_basicos.user_id')
            ->where("requerimientos.id", $req_id)
            ->where("datos_basicos.aspiracion_salarial", $datos_ficha->rango_salarial)
            ->where("estudios.nivel_estudio_id", $datos_ficha->escolaridad)
            ->where("datos_basicos.pais_residencia", $nuevoRequerimiento->pais_id)
            ->where("datos_basicos.departamento_residencia", $nuevoRequerimiento->departamento_id)
            ->where("datos_basicos.ciudad_residencia", $nuevoRequerimiento->ciudad_id)
            ->whereIn("datos_basicos.genero", $genero)
            ->whereIn("datos_basicos.estado_reclutamiento", [config('conf_aplicacion.C_ACTIVO'), config('conf_aplicacion.C_QUITAR')])
            ->whereRaw("datos_basicos.user_id not in (select candidato_id from requerimiento_cantidato where requerimiento_id=" . $req_id . " and estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")) and TIMESTAMPDIFF(DAY, fecha_nacimiento, CURDATE())/(365.25) between " . $datos_ficha->edad_minima . " and " . $datos_ficha->edad_maxima . " ")
            ->groupBy("datos_basicos.user_id","users.video_perfil")->take(10)
            ->get();
        }
        else{
            //Cuando no hay fichas creadar al cargo generico se traen los datos del requerimiento
            $genero = $ficha->genero_id;

            if ($genero == 1) {
                $genero = ['1'];
            } elseif ($genero == 2) {
                $genero = ['2'];
            } else {
                $genero = ['1', '2'];
            }
 
            $candidatos_cargo_general = DatosBasicos::join("perfilamiento", "perfilamiento.user_id", "=", "datos_basicos.user_id")
            ->join("requerimientos", "requerimientos.cargo_generico_id", "=", "perfilamiento.cargo_generico_id")
            ->join('users','users.id','=','datos_basicos.user_id')
            ->join("estudios", "estudios.user_id", "=", "datos_basicos.user_id")
            ->where("requerimientos.id", $req_id)
            ->where("estudios.nivel_estudio_id", $ficha->nivel_estudio)
            ->where("datos_basicos.pais_residencia", $nuevoRequerimiento->pais_id)
            ->where("datos_basicos.departamento_residencia", $nuevoRequerimiento->departamento_id)
            ->where("datos_basicos.ciudad_residencia", $nuevoRequerimiento->ciudad_id)
            ->whereIn("datos_basicos.genero", $genero)
            ->whereIn("datos_basicos.estado_reclutamiento", [config('conf_aplicacion.C_ACTIVO'), config('conf_aplicacion.C_QUITAR')])
            ->whereRaw("datos_basicos.user_id not in (select candidato_id from requerimiento_cantidato where requerimiento_id=" . $req_id . " and estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")) and TIMESTAMPDIFF(DAY, fecha_nacimiento, CURDATE())/(365.25) between " . $ficha->edad_minima . " and " . $ficha->edad_maxima . "  ")
            ->select('datos_basicos.user_id','users.video_perfil as video')
            ->take(30);
        }

        if($nuevoRequerimiento->preperfilados==null){
            $nuevoRequerimiento->preperfilados= $candidatos_cargo_general->count();
            $nuevoRequerimiento->save();
        }

        foreach ($candidatos_cargo_general as $key => $candidato_req) {
            $candidato_pre = new Preperfilados();
            $candidato_pre->req_id = $req_id;
            $candidato_pre->candidato_id = $candidatos_cargo_general->user_id;
            $candidato_pre->save();
        }

        $requerimiento_id = $req_actualizacion;

        if(route("home")=="https://temporizar.t3rsc.co"){
            if($data->tipo_proceso_id==6 || $data->tipo_proceso_id==4){
                 Mail::send('req.emails.new_notificacion_req', ['nombre_usuario'=>$value->nombres,'req' => $requerimiento_id,'data'=>$dataView, "cargo_especifico" => $cargo_especifico], function ($m) use($requerimiento_id) {
                $m->subject('Nueva requisicion No. '.$requerimiento_id->id );
                $m->to(['nomina@temporizar.com','logistica@temporizar.com','contratacion@temporizar.com'],'$nombre -T3RS')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
            }
        }

        $emails = [];

        if($sitio->agencias){
            $agencia = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("ciudad", function($sql){
                    $sql->on("ciudad.cod_ciudad","=", "requerimientos.ciudad_id")
                        ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id")
                        ->on("ciudad.cod_pais","=","requerimientos.pais_id");
                })
                ->where("requerimientos.id", $req_id)
                ->select(
                    "ciudad.agencia as agencia",
                    "negocio.cliente_id"
                )
            ->first();

            $emails = User::join("agencia_usuario", "agencia_usuario.id_usuario", "=", "users.id")
                ->join('users_x_clientes','users_x_clientes.user_id','=','users.id')
                ->join("role_users", "role_users.user_id", "=", "users.id")
                ->whereIn("role_users.role_id", [3, 5, 17])
                ->where("users_x_clientes.cliente_id", $agencia->cliente_id)
                ->where("agencia_usuario.id_agencia", $agencia->agencia)
                ->where("users.notificacion_requisicion", 1)
                ->select(
                    "role_users.role_id as rol_id",
                    "users.email as email",
                    "users.name as nombres",
                    "users.id as user_id"
                )
                ->groupBy("users.id")
            ->get();
        } else {
            $cliente = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->where("requerimientos.id", $req_id)
                ->select("negocio.cliente_id")
            ->first();

            $emails = User::join('users_x_clientes','users_x_clientes.user_id','=','users.id')
                ->join("role_users", "role_users.user_id", "=", "users.id")
                ->whereIn("role_users.role_id", [3, 5, 17])
                ->where("users_x_clientes.cliente_id", $cliente->cliente_id)
                ->where("users.notificacion_requisicion", 1)
                ->select(
                    "role_users.role_id as rol_id",
                    "users.email as email",
                    "users.name as nombres",
                    "users.id as user_id"
                )
                ->groupBy("users.id")
            ->get();
        }

        $nombre = "Desarrollo";
        if (isset($sitio->nombre) && $sitio->nombre != "") {
            $nombre = $sitio->nombre;
        }

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Notificación Nuevo Requerimiento"; //Titulo o tema del correo

        $ciudad = $requerimiento_id->getNombreCiudad()->ciudad;
        $empresa_solicitud = $requerimiento_id->empresa()->nombre;
        $tipo_solicitud = $requerimiento_id->getDescripcionTipoProceso();

        foreach ($emails as $key => $value) {
            try{
                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "
                    Hola $value->nombres: <br/><br/>
                    Te informamos que {$dataView['solicitado_por']} a cargo de tu cliente {$empresa_solicitud}, ha creado un nuevo requerimiento:
                    <br/><br/>

                    <ul>
                        <li>Requerimiento: <b>{$req_id}</b></li>
                        <li>Cargo: <b>{$cargo_especifico->descripcion}</b></li>
                        <li>Ciudad: <b>{$ciudad}</b></li>
                        <li>Tipo Solicitud: <b>{$tipo_solicitud}</b></li>
                    </ul>

                    Para visualizar los detalles del requerimiento haz clic en el botón " . ($value->rol_id == 3 ? "“Detalle”" : "“Gestionar”");

                //Arreglo para el botón
                if ($value->rol_id == 3) {
                    $mailButton = ['buttonText' => 'DETALLE', 'buttonRoute' => route("req.detalle_requerimiento", ['req_id' => $req_id])];
                } else {
                    $mailButton = ['buttonText' => 'GESTIONAR', 'buttonRoute' => route("admin.gestion_requerimiento", ['req_id' => $req_id])];
                }

                $mailUser = $value->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($value, $req_id, $nombre) {

                    $message->to($value->email,"$nombre - T3RS")
                        ->subject('Nueva requisición No. '.$req_id )
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            } catch (\Exception $e) {
                logger('Excepción capturada en RequerimientoController al enviar correo de creacion de Requerimiento: '.  $e->getMessage(). "\n");
            }
        }

        /*
        //enviar mail roles 3, 5, 17
        $roles_id = [3, 5, 17];
        $job = (new SendPostCreateReqEmail($cargo_especifico, $nuevoRequerimiento, $dataView, $roles_id));

        $this->dispatch($job);
        */

        //Creación de requerimiento multiciudad
        //Crea requerimientos multiciudad

        $ids_requerimientos = [$nuevoRequerimiento->id];

        if($data->get('select_multi_reque') != '' && $data->get('select_multi_reque') == 1 && $data->get('num_vacantes_multi') != ''){

            $ciudadRequeMulti   = $data->get('ciudad_trabajo_multi');
            $salarioRequeMulti  = $data->get('salario_multi');
            $vacantesRequeMulti = $data->get('num_vacantes_multi');

            for($i = 0; $i < count($ciudadRequeMulti); $i++) {
              
                $ciudadReq = Ciudad::find($ciudadRequeMulti[$i]);

                $pais_id_multi = $ciudadReq->cod_pais;
                $departamento_id_multi = $ciudadReq->cod_departamento;
                $ciudad_id_multi = $ciudadReq->cod_ciudad;

                if (route('home') != "http://komatsu.t3rsc.co") {

                    $nuevoRequerimiento = new Requerimiento();
                    $nuevoRequerimiento->fill($data->all());
                
                    //cambiar
                    if(route('home')=="http://tiempos.t3rsc.co") {
                      $nuevoRequerimiento->salario =str_replace('.', '',$data->salarioReqs[$i]);
                    }
                    //*****

                    $nombre = $nuevoRequerimiento->nombre_cliente_req();

                    //$nombre = Clientes::find($data->get('cliente_id'))->pluck('nombre');
                    $mensaje_default = nl2br("Estamos buscando personas con mucha actitud y ganas de trabajar para desempeñarse en el cargo de $cargo_especifico->descripcion, queremos que hagas parte de la familia $nombre, por lo cual te invitamos a que:\r\n

                    - Completes tu hoja de vida.\n
                    - Grabes un video perfil para que mejores las probabilidades de ser seleccionado en el cargo.\n
                    -  Apliques a las vacantes y contestes las preguntas de preselección que nuestro equipo de selección ha preparado para ti !\n

                    Éxitos en tu aplicación y esperamos que este cargo aporte en tus objetivos laborales y de vida!");

                    $nuevoRequerimiento->descripcion_oferta    = $mensaje_default;

                    $nuevoRequerimiento->sitio_trabajo         = $ciudadReq->getSitioTrabajo($pais_id_multi,$departamento_id_multi,$ciudad_id_multi);

                    $nuevoRequerimiento->num_vacantes          = $vacantesRequeMulti[$i];
                    $nuevoRequerimiento->salario               = $salarioRequeMulti[$i];

                    $nuevoRequerimiento->pais_id               = $pais_id_multi;
                    $nuevoRequerimiento->departamento_id       = $departamento_id_multi;
                    $nuevoRequerimiento->ciudad_id             = $ciudad_id_multi;

                    $nuevoRequerimiento->estado_publico        = 1;

                    $nuevoRequerimiento->cargo_codigo          = $cargo_especifico->cargo_codigo;
                    $nuevoRequerimiento->grado_codigo          = $cargo_especifico->grado_codigo;
                    $nuevoRequerimiento->created_at            = $fecha_mañana;

                    $nuevoRequerimiento->save();

                    array_push($ids_requerimientos, $nuevoRequerimiento->id);

                }else{

                    $nuevoRequerimiento = new Requerimiento();
                 
                    $mensaje_koma = "Hola, Queremos contar contigo, Komatsu multinacional necesita alguien como tú, si cumples con el perfil aplica a nuestra oferta y has parte de nuestro equipo en Colombia!";

                    $nuevoRequerimiento->fill($data->all());

                    $nuevoRequerimiento->sitio_trabajo         = $ciudadReq->getSitioTrabajo($pais_id_multi,$departamento_id_multi,$ciudad_id_multi);

                    $nuevoRequerimiento->num_vacantes          = $vacantesRequeMulti[$i];
                    $nuevoRequerimiento->salario               = $salarioRequeMulti[$i];

                    $nuevoRequerimiento->pais_id               = $pais_id_multi;
                    $nuevoRequerimiento->departamento_id       = $departamento_id_multi;
                    $nuevoRequerimiento->ciudad_id             = $ciudad_id_multi;

                    $nuevoRequerimiento->descripcion_oferta    = $mensaje_koma;
                    $nuevoRequerimiento->estado_publico        = 1;
                    
                    $nuevoRequerimiento->cargo_codigo          = $cargo_especifico->cargo_codigo;
                    $nuevoRequerimiento->grado_codigo          = $cargo_especifico->grado_codigo;
                    $nuevoRequerimiento->created_at            = $fecha_mañana;

                    $nuevoRequerimiento->save();
                    
                    array_push($ids_requerimientos, $nuevoRequerimiento->id);

                }

                if($data->hasFile("perfil")){
                    $archivo   = $data->file('perfil');
                    $extension = $archivo->getClientOriginalExtension();
                    $name_documento_multi  = "documento_" . $nuevoRequerimiento->id . ".$extension";

                    \File::copy("documentos_solicitud/$name_documento", "documentos_solicitud/$name_documento_multi");

                    $nuevoRequerimiento->documento = $name_documento_multi;
                    $nuevoRequerimiento->save();
                }

                //Se verifica si el sitio configura la prueba de Excel Basico y/o Intermedio
                if ($sitio->prueba_excel_basico || $sitio->prueba_excel_intermedio) {
                    //Se verifica si el cargo tiene configurada alguna prueba de Excel
                    if ($cargo_especifico->excel_basico || $cargo_especifico->excel_intermedio) {
                        $config_excel_req = new PruebaExcelConfiguracion();

                        $config_excel_req->gestiono     = $this->user->id;
                        $config_excel_req->req_id       = $nuevoRequerimiento->id;
                        $config_excel_req->excel_basico                 = $cargo_especifico->excel_basico;
                        $config_excel_req->excel_intermedio             = $cargo_especifico->excel_intermedio;
                        $config_excel_req->tiempo_excel_basico          = $cargo_especifico->tiempo_excel_basico;
                        $config_excel_req->tiempo_excel_intermedio      = $cargo_especifico->tiempo_excel_intermedio;
                        $config_excel_req->aprobacion_excel_basico      = $cargo_especifico->aprobacion_excel_basico;
                        $config_excel_req->aprobacion_excel_intermedio  = $cargo_especifico->aprobacion_excel_intermedio;

                        $config_excel_req->save();
                    }
                }

                //Se verifica si el sitio configura la prueba de valores 1
                if ($sitioModulo->prueba_valores_1 == 'enabled') {
                    $cargoConfigPruebas = CargoEspecificoConfigPruebas::where('cargo_especifico_id', $data->get("cargo_especifico_id"))->orderBy('created_at', 'DESC')->first();

                    //Si el cargo tiene configurada la prueba de valores, se agrega la configuracion al requerimiento
                    if ($cargoConfigPruebas != null) {
                        $newPruebaValoresConfigReq = new PruebaValoresConfigRequerimiento();
                        $newPruebaValoresConfigReq->gestiono            = $this->user->id;
                        $newPruebaValoresConfigReq->req_id              = $nuevoRequerimiento->id;
                        $newPruebaValoresConfigReq->prueba_valores_1    = 'enabled';
                        $newPruebaValoresConfigReq->valor_verdad        = $cargoConfigPruebas->valor_verdad;
                        $newPruebaValoresConfigReq->valor_rectitud      = $cargoConfigPruebas->valor_rectitud;
                        $newPruebaValoresConfigReq->valor_paz           = $cargoConfigPruebas->valor_paz;
                        $newPruebaValoresConfigReq->valor_amor          = $cargoConfigPruebas->valor_amor;
                        $newPruebaValoresConfigReq->valor_no_violencia  = $cargoConfigPruebas->valor_no_violencia;

                        $newPruebaValoresConfigReq->save();
                    }
                }

                //Comienzo guardar adicionales
                    if($data->has("clausulas") && is_array($data->get("clausulas"))) {
                        foreach($data->get("clausulas") as $key => $clausula) {
                            //Si hay un valor adicional configurado se crea la asociación en la tabla
                            if($data->has("valor_adicional") && is_array($data->get("valor_adicional"))) {
                                //if ($data->get("valor_adicional")[$key] != 0) {
                                    $documento_adicional_valor = new ClausulaValorRequerimiento();

                                    $documento_adicional_valor->fill([
                                        'req_id' => $nuevoRequerimiento->id,
                                        'adicional_id' => $clausula,
                                        'valor' => $data->get("valor_adicional")[$key],
                                    ]);
                                    $documento_adicional_valor->save();
                                //}
                            }
                        }
                    }
                //Fin guardar adicionales

                $num_vacantes = $vacantesRequeMulti[$i];

                //Ajuste ANS OCT 30
                $ans = NegocioANS::where("negocio_id", $data->get("negocio_id"))->get();

                if($ans->count() > 0){

                    $inicio_rango = 0;
                    $fin_rango    = 0;
                    $hay_ans      = false;
                    $current      = Carbon::parse($nuevoRequerimiento->created_at);
                    $future       = Carbon::parse($nuevoRequerimiento->fecha_ingreso);
                    $dias_gestion = $current->diffInDays($future);
                    
                    foreach ($ans as $key => $value) {
                        
                       list($inicio_rango, $fin_rango) = explode("A",strtoupper($value->regla));

                        if(($num_vacantes>=$inicio_rango) && ($num_vacantes<=$fin_rango) && !$hay_ans ){
                           
                           //$dias_gestion                  = $value->cantidad_dias;
                          $cuantos_candidatos_presentar  = $value->num_cand_presentar_vac * $num_vacantes;
                           $cuantos_dias_presentar_antes  = $value->dias_presentar_candidatos_antes;
                           $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
                           $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)
                                ->subWeekdays($cuantos_dias_presentar_antes);

                           $hay_ans=true;

                        }
                    }

                    //si no hay ans traemos los valores por defecto
                    if( !$hay_ans ){

                        $dias_gestion                  = config('conf_aplicacion.DIAS_DEFECTO_REQUERIMIENTO');
                        $cuantos_candidatos_presentar  = config('conf_aplicacion.CANTIDAD_DE_CAND_A_PRESENTAR_VACANTE') * config('conf_aplicacion.VACANTES_DEFECTO') ;
                        $cuantos_dias_presentar_antes  = config('conf_aplicacion.DIAS_PRESENTACION_CAND_DEFECTO');
                        $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
                        $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)->subWeekdays($cuantos_dias_presentar_antes);
                    }

                }else{

                    $current = Carbon::parse($nuevoRequerimiento->created_at);
                    $current1 = $current->format('Y-m-d');
                    $current2 = Carbon::parse($current1);
                    
                    $future = Carbon::parse($nuevoRequerimiento->fecha_ingreso);
                    $future1 = $future->format('Y-m-d');
                    $future2 = Carbon::parse($future1);

                   $dias_gestion = $future2->diffInDays($current2);

                    $cuantos_candidatos_presentar  = config('conf_aplicacion.CANTIDAD_DE_CAND_A_PRESENTAR_VACANTE') * config('conf_aplicacion.VACANTES_DEFECTO') ;
                    $cuantos_dias_presentar_antes  = config('conf_aplicacion.DIAS_PRESENTACION_CAND_DEFECTO');
                    $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
                    $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)->subWeekdays($cuantos_dias_presentar_antes);
                }

                //preperfilar candidatos al req

                $req_actualizacion = Requerimiento::find($nuevoRequerimiento->id);

                if(route('home') == "http://vym.t3rsc.co" || route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://vym.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co"){

                  $date_r       = Carbon::now();
                  
                  $fecha_mañana = $date_r->addDays(1)->toDateString();
                  $fecha_mañana .= ' 00:00:00';

                    $hora_req= Carbon::parse($nuevoRequerimiento->created_at);
                    
                    //if($hora_req->hour >= 12){
                     $req_actualizacion->created_at = $fecha_mañana;
                    //}
                }
            
                $req_actualizacion->dias_gestion                  = $dias_gestion;
                $req_actualizacion->cuantos_candidatos_presentar  = $cuantos_candidatos_presentar;
                $req_actualizacion->cuantos_dias_presentar_antes  = $cuantos_dias_presentar_antes;
                $req_actualizacion->fecha_presentacion_oport_cand = $fecha_presentacion_oport_cand;
                $req_actualizacion->fecha_tentativa_cierre_req    = $fecha_tentativa_cierre_req;
                $req_actualizacion->fecha_terminacion             = $fecha_tentativa_cierre_req;

                $req_actualizacion->save();

                $terminar_req = new EstadosRequerimientos();

                $terminar_req->fill([
                    "estado"       => config('conf_aplicacion.C_RECLUTAMIENTO'),
                    "user_gestion" => $this->user->id,
                    "req_id"       => $nuevoRequerimiento->id,
                ]);

                $terminar_req->save();

                $solicitado_por = Requerimiento::leftjoin('datos_basicos','datos_basicos.user_id','=','requerimientos.solicitado_por')
                ->where('requerimientos.id',$nuevoRequerimiento->id)
                ->select('datos_basicos.nombres as nombre_user_soli')
                ->first();

                if(($solicitado_por->nombre_user_soli != "") && (!is_null($solicitado_por->nombre_user_soli))){ 
                    $solicitado = $solicitado_por->nombre_user_soli;
                }else{
                    $solicitado = $this->user->name;
                }

                $dataView = [
                    'solicitado_por'  => $solicitado,
                    'sitio_trabajo'   => $nuevoRequerimiento->sitio_trabajo,
                    'num_vacantes'    => $num_vacantes,
                    'pais_id'         => $pais_id_multi,
                    'departamento_id' => $departamento_id_multi,
                    'ciudad_id'       => $ciudad_id_multi,
                ];

                $requerimiento_id = $req_actualizacion;

                $nombre = "Desarrollo";
                if (isset($sitio->nombre) && $sitio->nombre != "") {
                    $nombre = $sitio->nombre;
                }

                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                $mailTitle = "Notificación Nuevo Requerimiento"; //Titulo o tema del correo

                $ciudad = $requerimiento_id->getNombreCiudad()->ciudad;
                $empresa_solicitud = $requerimiento_id->empresa()->nombre;
                $tipo_solicitud = $requerimiento_id->getDescripcionTipoProceso();

                foreach ($emails as $key => $value) {
                    try{
                        //Cuerpo con html y comillas dobles para las variables
                        $mailBody = "
                            Hola $value->nombres: <br/><br/>
                            Te informamos que {$dataView['solicitado_por']} a cargo de tu cliente {$empresa_solicitud}, ha creado un nuevo requerimiento:
                            <br/><br/>

                            <ul>
                                <li>Requerimiento: <b>{$requerimiento_id->id}</b></li>
                                <li>Cargo: <b>{$cargo_especifico->descripcion}</b></li>
                                <li>Ciudad: <b>{$ciudad}</b></li>
                                <li>Tipo Solicitud: <b>{$tipo_solicitud}</b></li>
                            </ul>

                            Para visualizar los detalles del requerimiento haz clic en el botón " . ($value->rol_id == 3 ? "“Detalle”" : "“Gestionar”");

                        //Arreglo para el botón
                        if ($value->rol_id == 3) {
                            $mailButton = ['buttonText' => 'DETALLE', 'buttonRoute' => route("req.detalle_requerimiento", ['req_id' => $req_id])];
                        } else {
                            $mailButton = ['buttonText' => 'GESTIONAR', 'buttonRoute' => route("admin.gestion_requerimiento", ['req_id' => $req_id])];
                        }

                        $mailUser = $value->user_id; //Id del usuario al que se le envía el correo

                        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($value, $requerimiento_id, $nombre) {

                            $message->to($value->email,"$nombre - T3RS")
                                ->subject('Nueva requisición No. '.$requerimiento_id->id )
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                        });
                    } catch (\Exception $e) {
                        logger('Excepción capturada en RequerimientoController al enviar correo de creacion de Requerimiento multiciudad: '.  $e->getMessage(). "\n");
                    }
                }

                /*
                $roles_id = [3, 5, 17];
                $job = (new SendPostCreateReqEmail($cargo_especifico, $nuevoRequerimiento, $dataView, $roles_id));

                $this->dispatch($job);
                */
            }

            $ids = implode(", ", $ids_requerimientos);

            return redirect()->route("req.mis_requerimiento")->with(["mensaje_success" => "Se crearon los requerimientos con ID ".$ids, "mensaje_no_postulados" => $mensaje_no_postulados]);
            //return redirect()->with("mensaje_success", "Se ha actualizado la oferta");
        }else{
            /* Creación de oferta en Trabaja con Nosotros */
            if ($data->get('tipo_proceso_id') != 7) {

                /*** Creación de oferta en ElEmpleo ***/
                if(route("home") == "http://listos.t3rsc.co" || route("home") == "https://listos.t3rsc.co" ||
                    route("home") == "http://vym.t3rsc.co" || route("home") == "https://vym.t3rsc.co") {
                    $response = null;

                    try {
                        $client = new SoapClient("https://www.elempleo.com/colombia/WebServices/JobOfferServices.asmx?WSDL");

                        # Sandbox ElEmpleo
                        // https://uat.elempleo.com/colombia/WebServices/CompanyServices.asmx?WSDL
                        // https://uat.elempleo.com/colombia/WebServices/JobOfferServices.asmx?WSDL

                        # Productivo ElEmpleo
                        // https://www.elempleo.com/colombia/WebServices/JobOfferServices.asmx?WSDL

                        #Credenciales Test
                        // listospruebaws1@listos.com
                        // Listows123*

                        #Credenciales Productivo
                        // liliana.marin@listos.com.co
                        // Dima8911

                        //Objeto token
                        $params = array(
                            "token" => array(
                                "UserName" => "liliana.marin@listos.com.co",
                                "Password" => "Dima8911"
                            )
                        );

                        //Obteniendo datos para oferta
                        #Cargo datos
                        $cargoEspecificoEE = CargoEspecifico::find($data->get("cargo_especifico_id"));

                        $tituloOfertaEE = $cargoEspecificoEE->descripcion;
                        $cargoIdEE = $cargoEspecificoEE->cargo_generico_id;

                        $salarioDesc = $data->get('salario');

                        //Define descripción
                        if ($data->get("tipo_experiencia_id") == 1) {
                            $offerDescription = "Importante empresa requiere para su equipo de trabajo, profesional en $tituloOfertaEE o carreras afines, no necesita experiencia realizando tareas y actividades acordes al perfil. Salario $salarioDesc.";
                        }else if($data->get("tipo_experiencia_id") == 2 || $data->get("tipo_experiencia_id") == 3){
                            $offerDescription = "Importante empresa requiere para su equipo de trabajo, profesional en $tituloOfertaEE o carreras afines, con experiencia de menos de un año realizando tareas y actividades acordes al perfil. Salario $salarioDesc.";
                        }else{
                            $experienciaDesc = FuncionesGlobales::getExperienceDescriptionEE($data->get("tipo_experiencia_id"));

                            $offerDescription = "Importante empresa requiere para su equipo de trabajo, profesional en $tituloOfertaEE o carreras afines, con experiencia de $experienciaDesc realizando tareas y actividades acordes al perfil. Salario $salarioDesc.";
                        }

                        //Datos que requiere la creación
                        $params_offer = array(
                            "jobOfferToken" => array(
                                #Titulo de la oferta
                                'Title'                => $tituloOfertaEE,
                                #Descripción de la oferta
                                'Description'          => $offerDescription,
                                #Requerimientos de la oferta
                                'Requirements'         => '.',
                                #Mostrar nombre de la empresa
                                'PublishCompanyName'   => true,
                                #Publicar en el sitio de la empresa
                                'PublishInCompanySite' => false,
                                #Oferta interna de la empresa
                                'InternalCall'         => false,
                                #Oferta compartida
                                'IsShared'             => false,
                                #Nivel de cargo
                                'PositionSubLevelId'   => 9,
                                #Salario
                                'SalaryId'             => FuncionesGlobales::getSalaryIdEE($data->get("salario")),
                                #Cantidad de vacantes
                                'VacancyQuantity'      => (int) $num_vacantes,
                                #Tiempo expiración oferta
                                'ExpirationTimeId'     => 5,
                                #Tipo de contrato
                                'ContractTypeId'       => FuncionesGlobales::getContractIdEE($data->get("tipo_contrato_id")),
                                #Horario de trabajo
                                'WorkingPeriodId'      => 3,
                                #Experiencia requerida
                                'RequiredExperienceId' => FuncionesGlobales::getExperienceIdEE($data->get("tipo_experiencia_id")),
                                #Nivel educativo
                                'EducationStatus'      => 'Graduate',
                                #Profesión solicitada
                                'ProfessionIds'        => [101235134],
                                #Posicion de la profesión
                                'PositionIds'          => [99],
                                #Ciudad de la oferta
                                'CitiesIds'            => [34],
                                #Sectores de trabajo
                                'SectorIds'            => [1195],
                                #Áreas de trabajo
                                'WorkAreaIds'          => [25, 51],
                                #Género que busca la oferta
                                'Gender'               => FuncionesGlobales::getGenderIdEE($data->get("genero_id")),
                                #Idioma en que se publica
                                'LanguageId'           => 2,
                                #Nivel del idioma elegido
                                'KnowledgeLevelId'     => 8,
                                #Usuario que publica
                                'UserName'             => 'liliana.marin@listos.com.co',
                                'Password'             => 'Dima8911',

                                'ReturnUrl'            => 'https://listos.t3rsc.co',
                                #Mostrar salario
                                'PublishSalary'        => true,
                                #Edad minima
                                'Lower'                => $data->get("edad_minima"),
                                #Edad máxima
                                'Upper'                => $data->get("edad_maxima")
                            )
                        );

                        # Obtiene las funciones que se pueden usar
                        //$response = $client->__getFunctions();
                        //$response = $client->__getTypes();

                        # Verificar el WS
                        //$response = $client->TestWs();

                        # Autenticar Empresa
                        //$response = $client->AutenticarUsuarioEmpresas($params);

                        # Obtener ultima oferta registrada
                        //$response = $client->GetLastPublishes($params);

                        # Ver usuarios registrados
                        //$response = $client->GetEmployeeResumees($params);

                        # Ver procesos de selección
                        //$response = $client->GetSelectionProcesses($params);

                        # Crear ofera y retorna ID de oferta
                        $response = $client->InsertJobOfferReturnId($params_offer);
                        //$response = $client->InsertJobOffer($params_offer);
                        //$response = $client->GetLastPublishes($params);

                        //$response = $client->GetSelectionProcesses($params);

                        //Guardar Id oferta EE
                        $req_actualizacion->IdJobOfferEE = $response->InsertJobOfferReturnIdResult->IdJobOffer;
                        $req_actualizacion->save();
                    } catch (\Throwable $t) {
                        Mail::send('req.emails.notificacion_elempleo', [
                            'response' => $t,
                            'req_id'   => $req_id
                        ], function ($m) use($req_id) {
                            $m->subject('ElEmpleo ERROR REQ'.$req_id);
                            $m->to(['sebastianb.t3rs@gmail.co'], 'Sebastian -T3RS')
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                        });
                    }
                }
            }
            //Atributos TODO
          return redirect()->route("req.mis_requerimiento")->with(["mensaje_success" => "Se creó el requerimiento ID " . $nuevoRequerimiento->id, "mensaje_no_postulados" => $mensaje_no_postulados]);
        }
        return redirect()->route("req.mis_requerimiento")->with(["mensaje_success" => "Se creó el requerimiento ID " . $nuevoRequerimiento->id, "mensaje_no_postulados" => $mensaje_no_postulados]);
    }

    public function cargo_especifico_ajax(Request $data)
    {
       $cargoEspecifico = CargoEspecifico::where("cargo_generico_id", $data->get("cargo_id"))->get();
        $html            = "<option value=''>Seleccionar</option>";
        foreach ($cargoEspecifico as $key => $value) {
            $html .= "<option value='" . $value->id . "'>" . $value->descripcion . "</option>";
        }
        return $html;
    }

    public function candidatos_aprobar_cliente_view(Request $data)
    { 
        $req = Requerimiento::find($data->get("req_id"));
        $candidato_req = EloquentUser::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
            ->where("requerimiento_cantidato.requerimiento_id", $req->id)
            ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
        //->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_ACTIVO'))
            ->where(function ($sql) use ($data) {
                if ($data->get("cedula") != "") {
                    $sql->where("datos_basicos.numero_id", $data->get("cedula"));
                }
            })
            ->whereRaw(" requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
            ->select("datos_basicos.*", "estados.descripcion as estado_candidatos", "requerimiento_cantidato.id as req_candidato_id")
            ->first();

            $negocio = Negocio::find($req->negocio_id);
            $cliente = Clientes::find($negocio->cliente_id);


            $cerroMatozo=0;
            if(route("home")=="https://listos.t3rsc.co"){
                $cerroMatozo = User::
                join('users_x_clientes','users_x_clientes.user_id','=','users.id')
                ->where('users.id', $this->user->id)
                ->where('users_x_clientes.cliente_id',168)
                ->count();
            }
            
        return view("req.aprobar_clientes_view", compact("req","candidato_req","cliente","cerroMatozo"));
    }

    public function candidatos_no_aprobar_cliente_view(Request $data)
    {

        $motivos_rechazo=["" => "Seleccionar"] +MotivoRechazoCandidato::pluck("descripcion","id")->toArray();

        $req_can=ReqCandidato::find($data->req_id);

        $candidato = DatosBasicos::join('tipo_identificacion', 'tipo_identificacion.id', '=', 'datos_basicos.tipo_id')
            ->where("user_id", $req_can->candidato_id)
            ->select(
                'datos_basicos.*',
                'tipo_identificacion.cod_tipo as tipo_id_desc'
            )
        ->first();

        /*$req = Requerimiento::find($data->get("req_id"));
        $candidato_req = EloquentUser::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
            ->where("requerimiento_cantidato.requerimiento_id", $req->id)
            ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
        //->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_ACTIVO'))
            ->where(function ($sql) use ($data) {
                if ($data->get("cedula") != "") {
                    $sql->where("datos_basicos.numero_id", $data->get("cedula"));
                }
            })
            ->whereRaw(" requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
            ->select("datos_basicos.*", "estados.descripcion as estado_candidatos", "requerimiento_cantidato.id as req_candidato_id")
            ->first();

            $negocio = Negocio::find($req->negocio_id);
            $cliente = Clientes::find($negocio->cliente_id);*/
        return view("admin.reclutamiento.modal.no_aprobar_cliente_new",compact("motivos_rechazo","candidato","req_can"));
    }

    public function candidatos_aprobar_cliente_view_req(Request $data)
    {
        $req = Requerimiento::find($data->get("req_id"));

        $candidato_req = EloquentUser::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
        ->where("requerimiento_cantidato.requerimiento_id", $req->id)
        ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
        //->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_ACTIVO'))
        ->where(function ($sql) use ($data) {
            if ($data->get("cedula") != "") {
                $sql->where("datos_basicos.numero_id", $data->get("cedula"));
            }
        })
        ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")")
        ->select(
            "datos_basicos.*",
            "estados.descripcion as estado_candidatos",
            "requerimiento_cantidato.id as req_candidato_id"
        )
        ->first();

        $negocio = Negocio::find($req->negocio_id);
        $cliente = Clientes::find($negocio->cliente_id);
        
        return view("req.aprobar_clientes_view_requi", compact("req", "candidato_req", "cliente"));
    }

    public function cambia_estado_aprobacion_cliente(Request $data)
    {
        $estado = \App\Models\RegistroProceso::
            where("proceso", "ENVIO_APROBAR_CLIENTE")->where("requerimiento_candidato_id", $data->get("req"))->where("candidato_id", $data->get("candidato"))
            ->first();

        $estado->apto                = $data->get("estado");
        $estado->observaciones       = $data->get("observaciones");
        $estado->usuario_terminacion = $this->user->id;

        $estado->save();
    }

    public function lista_requerimientos(Request $data)
    {
        $user_sesion    = $this->user;
        $sitio = Sitio::first();

        if (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") {
            $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->join("users", "users.id", "=", "requerimientos.solicitado_por")
            //->whereIn("users.id", $usuariosHijos)
            ->where(function ($sql) use ($data) {
                if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }
                if ($data->has("num_req") && $data->get("num_req") != "") {
                    $sql->where("requerimientos.id", $data->get("num_req"));
                }
                if ($data->has("fecha_inicio") && $data->get("fecha_inicio") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.created_at,'dd/mm/yyyy')) = '" . $data->get("fecha_inicio") . "'");
                }
                if ($data->has("fecha_fin") && $data->get("fecha_fin") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.fecha_ingreso,'dd/mm/yyyy')) ='" . $data->get("fecha_fin") . "'");
                }
            })
            ->select(
                "cargos_especificos.descripcion as cargo",
                "requerimientos.id",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_terminacion",
                "requerimientos.fecha_ingreso",
                "requerimientos.dias_gestion",
                "tipo_proceso.descripcion as tipo_proceso_desc",
                "negocio.num_negocio",
                "clientes.nombre as nombre_cliente",
                "users.name as nombre_usuario",
                "requerimientos.id as req_id",
                "requerimientos.solicitud_id"
            )
            ->groupBy('requerimientos.id')
            ->orderBy("requerimientos.id", "desc")
            ->paginate(10);
        } elseif(route("home") == "http://soluciones.t3rsc.co" || route("home") == "https://soluciones.t3rsc.co") {
            $date = Carbon::now();
            $mes =  $date->subDay(15);

            $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->whereIn("clientes.id", $this->clientes_user)
            ->where(function ($sql) use ($data, $mes) {
                if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }
                if ($data->has("num_req") && $data->get("num_req") != "") {
                    $sql->where("requerimientos.id", $data->get("num_req"));
                }

                if ($data->get("num_req") == "" && $data->get("cliente_id") == "") {
                
                    $sql->whereDate('requerimientos.created_at','>',$mes);
                }
            })
            ->select("requerimientos.*", "requerimientos.id as req_id")
            ->groupBy('requerimientos.id')
            ->orderBy("requerimientos.id", "desc")
            ->paginate(10);
        } else {
            $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->join("users", "users.id", "=", "requerimientos.solicitado_por")
            ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            ->leftjoin('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->leftjoin("agencias", "ciudad.agencia", "=", "agencias.id")
            //->first>leftJoin("requerimiento_cantidato","requerimiento_cantidato.requerimiento_id","=","requerimientos.id")
            ->whereIn("clientes.id", $this->clientes_user)
            ->tipoProceso($data)
            //->whereIn("ciudad.agencia", $this->user->agencias())
            ->where(function ($sql) use ($data, $sitio) {
                if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }
                if ($data->has("num_req") && $data->get("num_req") != "") {
                    $sql->where("requerimientos.id", $data->get("num_req"));
                }
                if ($data->has("cargo_id") && $data->get("cargo_id") != "") {
                    $sql->where("requerimientos.cargo_especifico_id", $data->get("cargo_id"));
                }

                if ( $sitio->agencias && $data->has('agencia') && $data->agencia != "" ) {
                    
                    $sql->where('ciudad.agencia', $data->agencia);
                }
            })
            ->select(
                "cargos_especificos.descripcion as cargo",
                "requerimientos.id",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_terminacion",
                "requerimientos.fecha_ingreso",
                "requerimientos.dias_gestion",
                "tipo_proceso.descripcion as tipo_proceso_desc",
                "negocio.num_negocio",
                "clientes.nombre as nombre_cliente",
                "users.name as nombre_usuario",
                "requerimientos.id as req_id",
                "agencias.descripcion as nombre_agencia"
            )
            ->groupBy('requerimientos.id')
            ->orderBy("requerimientos.id", "desc")
            ->paginate(10);
        }

        $clientes = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "clientes.id", "=", "users_x_clientes.cliente_id")
        ->where("users_x_clientes.user_id", $user_sesion->id)
        ->orderBy(DB::raw("UPPER(clientes.nombre)"))
        ->pluck("clientes.nombre", "clientes.id")
        ->toArray();

        $tipoProcesos = ["" => "Seleccionar"] + TipoProceso::where('active', 1)
        ->orderBy("descripcion")
        ->pluck("descripcion", "id")
        ->toArray();

        $usuarios = ["" => "Seleccionar"] + User::pluck("name", "id")->toArray();

        /*
            $estado_req = EstadosRequerimientos::join("estados", "estados.id", "=", "estados_requerimiento.estado")
            ->where(function($sql) use ($data){
            if($data->get('num_req')!=""){
            $sql->where("req_id", $data->get("num_req"));
            }
            })
            ->select("estados.descripcion as estado_nombre", "estados.id as estados_req")
            ->orderBy("estados_requerimiento.estado", "desc")->first();
        */

         $agencias = [];

        if( $sitio->agencias ){
            $agencias = ["" => "Seleccionar"] + Agencia::pluck("agencias.descripcion", "agencias.id")->toArray();
        }

        return view("admin.requerimientos.lista_requerimientos_new", compact(
            "requerimientos",
            "clientes",
            "usuarios",
            "user_sesion",
            "agencias",
            "tipoProcesos"
        ));
    }

    public function lista_requerimientos_cliente(Request $data)
    {
        $user_sesion = $this->user;
        $sitio = Sitio::first();

        $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->join("users", "users.id", "=", "requerimientos.solicitado_por")
            ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            ->join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->whereIn("clientes.id", $this->clientes_user)
            ->tipoProceso($data)
            ->where(function ($sql) use ($data, $sitio) {
                if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }
                if ($data->has("num_req") && $data->get("num_req") != "") {
                    $sql->where("requerimientos.id", $data->get("num_req"));
                }
                if ($data->has("cargo_id") && $data->get("cargo_id") != "") {
                    $sql->where("requerimientos.cargo_especifico_id", $data->get("cargo_id"));
                }

                if( $sitio->agencias ){
                    $sql->whereIn("ciudad.agencia", $this->user->agencias());
                }
            })
            ->select(
                "cargos_especificos.descripcion as cargo",
                "requerimientos.id",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_terminacion",
                "requerimientos.fecha_ingreso",
                "requerimientos.dias_gestion",
                "tipo_proceso.descripcion as tipo_proceso_desc",
                "negocio.num_negocio",
                "clientes.nombre as nombre_cliente",
                "users.name as nombre_usuario",
                "requerimientos.id as req_id"
            )
            ->groupBy('requerimientos.id')
            ->orderBy("requerimientos.id", "desc")
            ->paginate(10);

        $clientes = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "clientes.id", "=", "users_x_clientes.cliente_id")
        ->where("users_x_clientes.user_id", $user_sesion->id)
        ->orderBy(DB::raw("UPPER(clientes.nombre)"),"ASC")
        ->pluck("clientes.nombre", "clientes.id")
        ->toArray();

        $tipoProcesos = ["" => Seleccionar] + TipoProceso::where('active', 1)
        ->orderBy(DB::raw("UPPER(descripcion)"),"ASC")
        ->pluck("descripcion", "id")
        ->toArray();

        $usuarios = ["" => "Seleccionar"] + User::pluck("name", "id")->toArray();

        $agencias = Ciudad::select(DB::raw("trim(agencia) agencia"))
        ->distinct()
        ->orderBy("agencia", "asc")
        ->pluck("agencia", "agencia")
        ->toArray();

        return view("req.requerimientos.lista_requerimientos", compact(
            "requerimientos",
            "clientes",
            "usuarios",
            "user_sesion",
            "agencias",
            "tipoProcesos"
        ));
    }

    public function editar_requerimiento($requerimiento_id, Request $data)
    {
        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){

            $vector="";

            $requermiento = Requerimiento::findOrFail($requerimiento_id);

            $sede = ["" => "Seleccionar"] + SolicitudSedes::where("estado", 1)->pluck("descripcion", "id")->toArray();
            $areaFunciones = ["" => "Seleccionar"] + SolicitudAreaFuncional::where("estado", 1)->pluck("descripcion", "id")->toArray();
            $subArea       = ["" => "Seleccionar"]+ SolicitudSubArea::where("estado", 1)->pluck("descripcion", "id")->toArray();

            $centro_beneficio = ["" => "Seleccionar"]+ SolicitudCentroBeneficio::where("estado", 1)->pluck("descripcion", "id")->toArray();

            $centro_costo = ["" => "Seleccionar"]+SolicitudCentroCosto::where("estado", 1)->pluck("descripcion", "id")->toArray();
            
            $motivoRequerimiento =  MotivoRequerimiento::where("active", 1)->pluck("descripcion", "id")->toArray();

            $user = $this->user;

            $cargo_especifico =  CargoEspecifico::where('cxclt_estado', 'act')
            ->where('active', 1)
            ->orderBy('descripcion', 'asc')
            ->pluck('descripcion', 'id')
            ->toArray();

            $tipoContrato = TipoContrato::
            where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();

            $soliId = $requermiento->solicitud_id;

            $info_soli = Solicitudes::where('id', $soliId)->first();

            $recursos_solicitud = SolicitudRecursos::where('id_solicitud',$soliId)
            ->orderBy('recurso_necesario', 'asc')
            ->pluck("recurso_necesario", "id")
            ->toArray(); //array de recursos necesarios para la solicitud

            $recursos = array('Computador de mesa','Computador portatil','Celular','Licencia SAP','Modem','Puesto de Trabajo'); //arrays de recursos que estan

            //comparando arrays 
            foreach($recursos_solicitud as $value1) {
                $encontrado = false;
                foreach($recursos as $value2) {
                    //comparacion
                    if($value1 == $value2){
                        $encontrado = true;
                    }
                }

                if($encontrado == false){
                    $vector= $value1; //agregando si hay uno que sea nuevo
                }
            }

            $tipos_evs = ["" => "Seleccione", "0" => "No aplica"] + TipoEstudioVirtualSeguridad::where("active",1)->pluck("descripcion","id")->toArray();

            return view("admin.requerimientos.editar_requerimiento",compact(
                "requermiento",
                "sede",
                "motivoRequerimiento",
                "areaFunciones",
                "subArea",
                "user",
                "centro_beneficio",
                "centro_costo",
                "cargo_especifico",
                "info_soli",
                "vector",
                "tipos_evs",
                /*"info_soli.jefe_inmediato as jefe_inmediato",
                "info_soli.email_jefe_inmediato",
                "info_soli.numero_vacante",
                "info_soli.funciones_realizar",
                "info_soli.observaciones",
                "info_soli.recursos"*/
                "tipoContrato"
            ));
        }else{
            $requermiento = Requerimiento::findOrFail($requerimiento_id);
            $negocio      = Negocio::find($requermiento->negocio_id);
            $cliente      = Clientes::find($negocio->cliente_id);

            $cargos = CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();

            $cargo_especifico =  CargoEspecifico::where('cxclt_estado', 'act')
            ->where('active', 1)
            ->where('clt_codigo', $cliente->cliente_id)
            ->orderBy('descripcion', 'asc')
            ->pluck('descripcion', 'id')
            ->toArray();

            $centro_costo = ["" => "Seleccionar"]+CentroCostoProduccion::where("estado", 'ACT')->pluck("descripcion", "id")->toArray();
            
            $concepto_pago    = ["" => "Seleccione"] + ConceptoPago::pluck("descripcion", "id")->toArray();
            $tipoProceso         = ["" => "Seleccione"] + TipoProceso::where("active", 1)->pluck("descripcion", "id")->toArray();
            $tipo_nomina         = ["" => "Seleccione"] + TipoNomina::pluck("descripcion", "id")->toArray();
            $tipo_contrato        = ["" => "Seleccione"] + TipoContrato::where("active", 1)->pluck("descripcion", "id")->toArray();
            $tipoExperiencia     = ["" => "Seleccione"] + TipoExperiencia::where("active", 1)->pluck("descripcion", "id")->toArray();
            $generos          = ["" => "Seleccione"] + Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
            $motivo_requerimiento = ["" => "Seleccione"] + MotivoRequerimiento::where("active", 1)->pluck("descripcion", "id")->toArray();
            $tipo_jornada        = ["" => "Seleccione"] + TipoJornada::where("active", 1)->pluck("descripcion", "id")->toArray();

            $centro_trabajo      =   CentroTrabajo::pluck("nombre_ctra", "id")->toArray();

            $tipo_salario         =  TipoSalario::pluck("descripcion", "id")->toArray();
            
            $user                = User::find($requermiento->solicitado_por);

            $user_sesion    = $this->user;

            //Consultar las personas postuladas segun el requerimiento.
            $candidatos_postulados = CandidatosFuentes::where('requerimiento_id', $requerimiento_id)->get();
            
            $tipo_liquidacion =  TipoLiquidacion::pluck("descripcion", "id")->toArray();

            $tipo_experiencia = [""=>"Seleccione"]+TipoExperiencia::where("active", 1)
            ->pluck('descripcion', "id")
            ->toArray();

            $niveles = ["" => "Seleccionar"] + NivelIdioma::pluck("descripcion", "id")->toArray();

            $generos              = [""=>"Seleccione"]+Genero::orderBy('id', 'desc')->pluck("descripcion", "id")->toArray();

            $estados_civiles      = [""=>"Seleccione"]+EstadoCivil::orderBy('codigo', 'asc')
            ->select(DB::raw("upper(descripcion) as descripcion"), 'id')
            ->pluck('descripcion', "id")
            ->toArray();

            $nivel_estudio           =  [""=>"Seleccione"]+NivelEstudios::orderBy('descripcion', 'asc')
            ->select(DB::raw("upper(descripcion) as descripcion"), 'id')
            ->pluck("descripcion", "id")
            ->toArray();

            $tipo_experiencia = [""=>"Seleccione"]+TipoExperiencia::where("active", 1)
            ->pluck('descripcion', "id")
            ->toArray();

            $empresa_logo = ["" => "Seleccione"] + EmpresaLogo::pluck("nombre_empresa", "id")->toArray();

            $modulo = 'admin';

            $tipos_evs = ["" => "Seleccione", "0" => "No aplica"] + TipoEstudioVirtualSeguridad::where("active",1)->pluck("descripcion","id")->toArray();

            return view("admin.requerimientos.editar_requerimiento_new", compact(
                'concepto_pago',
                'tipo_nomina',
                "cliente",
                'admin',
                'tipo_salario',
                'tipo_liquidacion',
                'centro_trabajo',
                "cargos",
                'centro_costo',
                "tipoProceso",
                "tipo_contrato",
                "tipoExperiencia",
                "tipoGenero",
                "tipos_evs",
                "motivo_requerimiento",
                "tipo_jornada",
                "user",
                "user_sesion",
                "negocio",
                "requermiento",
                "candidatos_postulados",
                "cargo_especifico",
                "tipo_experiencia",
                "niveles",
                "generos",
                "estados_civiles",
                "nivel_estudio",
                "empresa_logo",
                "modulo"
            ));
        }
    }

    public function editar_requerimiento_cliente($requerimiento_id, Request $data)
    {
        $requermiento = Requerimiento::findOrFail($requerimiento_id);
        $negocio      = Negocio::find($requermiento->negocio_id);
        $cliente      = Clientes::find($negocio->cliente_id);

        $cargos = CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();

        $cargo_especifico =  CargoEspecifico::where('cxclt_estado', 'act')
            ->where('active', 1)
            ->where('clt_codigo', $cliente->cliente_id)
            ->orderBy('descripcion', 'asc')
            ->pluck('descripcion', 'id')
            ->toArray();

        $centro_costo = ["" => "Seleccionar"]+CentroCostoProduccion::where("estado", 'ACT')->pluck("descripcion", "id")->toArray();
            
        $concepto_pago_id    = ConceptoPago::pluck("descripcion", "id")->toArray();
        $tipoProceso         = TipoProceso::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipo_nomina         = TipoNomina::pluck("descripcion", "id")->toArray();
        $tipoContrato        = TipoContrato::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoExperiencia     = TipoExperiencia::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoGenero          = Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
        $motivoRequerimiento = ["" => "Seleccione"] + MotivoRequerimiento::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoJornadas        = TipoJornada::where("active", 1)->pluck("descripcion", "id")->toArray();

        $centro_trabajo      =   CentroTrabajo::pluck("nombre_ctra", "id")->toArray();
        $tipo_salario         =  TipoSalario::pluck("descripcion", "id")->toArray();
        $tipoContrato        =  TipoContrato::where("active", 1)->pluck("descripcion", "id")->toArray();
            
        $user                = User::find($requermiento->solicitado_por);

        $user_sesion    = $this->user;

        //Consultar las personas postuladas segun el requerimiento.
        $candidatos_postulados = CandidatosFuentes::where('requerimiento_id', $requerimiento_id)->get();
            
        $tipo_liquidacion =  TipoLiquidacion::pluck("descripcion", "id")->toArray();

        $tipo_experiencia = [""=>"Seleccione"]+TipoExperiencia::where("active", 1)
            ->pluck('descripcion', "id")
            ->toArray();

        $niveles = ["" => "Seleccionar"] + NivelIdioma::pluck("descripcion", "id")->toArray();

        $generos = [""=>"Seleccione"]+Genero::orderBy('id', 'desc')->pluck("descripcion", "id")->toArray();

        $estados_civiles = [""=>"Seleccione"]+EstadoCivil::orderBy('codigo', 'asc')
            ->select(DB::raw("upper(descripcion) as descripcion"), 'codigo')
            ->pluck('descripcion', "codigo")
            ->toArray();

        $nivel_estudio  =  [""=>"Seleccione"]+NivelEstudios::orderBy('descripcion', 'asc')
            ->select(DB::raw("upper(descripcion) as descripcion"), 'id')
            ->pluck("descripcion", "id")
            ->toArray();

        $tipo_experiencia = [""=>"Seleccione"]+TipoExperiencia::where("active", 1)
            ->pluck('descripcion', "id")
            ->toArray();

            return view("req.requerimientos.editar_requerimiento", compact(
                'concepto_pago_id',
                'tipo_nomina',
                "cliente",
                'tipo_salario',
                'tipo_liquidacion',
                'centro_trabajo',
                "cargos",
                'centro_costo',
                "tipoProceso",
                "tipoContrato",
                "tipoExperiencia",
                "tipoGenero",
                "motivoRequerimiento",
                "tipoJornadas",
                "user",
                "user_sesion",
                "negocio",
                "requermiento",
                "candidatos_postulados",
                "cargo_especifico",
                "tipo_experiencia",
                "niveles",
                "generos",
                "estados_civiles",
                "nivel_estudio"
            ));
        
    }

    public function actualizar_requerimiento(Request $data)
    {
                $requerimiento                  = Requerimiento::find($data->get("id"));
                $registro_antiguo               = $requerimiento->toArray();
                $requerimiento->tipo_proceso_id = (int) $data->get("tipo_proceso_id");
                $requerimiento->pais_id         = $data->get('pais_id');
                $requerimiento->ciudad_id       = $data->get('ciudad_id');
                $requerimiento->departamento_id = $data->get('departamento_id');
                $requerimiento->sitio_trabajo   = $data->get('sitio_trabajo');
                $requerimiento->confidencial    = $data->confidencial;
                $requerimiento->cargo_especifico_id = $data->get('cargo_especifico_id');
                $requerimiento->ctra_x_clt_codigo = $data->ctra_x_clt_codigo;
                $requerimiento->tipo_jornadas_id = $data->tipo_jornadas_id;
                $requerimiento->tipo_liquidacion = $data->get('tipo_liquidacion');
                $requerimiento->tipo_salario     = $data->tipo_salario;
                $requerimiento->tipo_nomina      = $data->tipo_nomina;
                $requerimiento->tipo_evs_id      = $data->tipo_evs_id;
                $requerimiento->edad_minima   = $data->get('edad_minima');
                $requerimiento->edad_maxima   = $data->get('edad_maxima');
                 $requerimiento->nivel_estudio   = $data->get('nivel_estudio');
                 $requerimiento->funciones   = $data->get('funciones');
                $requerimiento->concepto_pago_id = $data->concepto_pago_id;
                if(route('home')!="http://komatsu.t3rsc.co") {
                 $requerimiento->salario =str_replace('.', '',$data->salario);
                }
                //cambiar
                $requerimiento->salario         = (int) $data->get('salario');
                $requerimiento->adicionales_salariales = $data->get('adicionales_salariales');
                //*************************************************************************
                $requerimiento->tipo_contrato_id = $data->tipo_contrato_id;
                $requerimiento->tipo_experiencia_id = $data->get('tipo_experiencia_id');
                $requerimiento->motivo_requerimiento_id = $data->get('motivo_requerimiento_id');
                $requerimiento->num_vacantes    = (int) $data->get("num_vacantes");
                $requerimiento->fecha_ingreso   = $data->get('fecha_ingreso');
                $requerimiento->fecha_recepcion   = $data->get('fecha_recepcion');
                $requerimiento->fecha_retiro    = $data->get('fecha_retiro');
                $requerimiento->centro_costo_id = $data->get('centro_costo_id');
                $requerimiento->esquemas        = $data->get('esquemas');
                $requerimiento->genero_id       = $data->get('genero_id');
                $requerimiento->estado_civil       = $data->get('estado_civil');
                $requerimiento->observaciones   = $data->get('observaciones');
                $requerimiento->save();


                if($data->hasFile('perfil')) {
                 $imagen     = $data->file("perfil");
                 $extencion  = $imagen->getClientOriginalExtension();
                 $name_documento = "documento_" .$requerimiento->id. "." . $extencion;
                 $imagen->move("documentos_solicitud", $name_documento);
                 $requerimiento->documento = $name_documento;
                 $requerimiento->save();
                }

                $auditoria                = new Auditoria();
                $auditoria->observaciones = "Editar requerimiento";
                $auditoria->valor_antes   = json_encode($registro_antiguo);
                $auditoria->valor_despues = json_encode($requerimiento);
                $auditoria->user_id       = $this->user->id;
                $auditoria->tabla         = "requerimientos";
                $auditoria->tabla_id      = $requerimiento->id;
                $auditoria->tipo          = "ACTUALIZAR";
                event(new \App\Events\AuditoriaEvent($auditoria));
            
        
        //Verificar preperfilamiento debido a modificaciones realizadas en el req
         event(new \App\Events\PreperfiladosEvent($requerimiento));
        
        if( $data->modulo == 'admin' ){
            $ruta = "admin.lista_requerimientos";
        }else{
            $ruta = "req.lista_requerimientos";
        }
        return redirect()->route($ruta)->with("mensaje_success", "Se ha actualizado el requerimiento con éxito.");
    }

    public function requerimientos_prioritarios(Request $data)
    {
        // 1 => si , 0 => no
        //REQUERIMIENTOS GUARDADOS Y ACTIVOS EN LA TABLA SEGUN LOS REQUERIMIENTOS CONSULTADOS(paginate)
        $bloqueReq = Requerimiento::whereIn("id", $data->get("req_ids"))->where("req_prioritario", 1)->pluck("id")->toArray();

        $req_eliminar = array_diff($bloqueReq, $data->get("id", []));
        //ACTUALIZAR A "NO PRIORITARIOS " A LOS REQUERIMEINTOS
        foreach ($req_eliminar as $key => $value) {
            //  dd($value);
            QueryAuditoria::observaciones("INACTIVA LOS REQUERIMIENTOS PARA NO SER PRIORITARIOS")->guardar(Requerimiento::find($value), ["req_prioritario" => 0], $value);
        }

        $req_activar = Requerimiento::whereIn("id", $data->get("id", []))->get();
        foreach ($req_activar as $key => $value) {
            //  dd($value);
            QueryAuditoria::observaciones("ACTIVA LOS REQUERIMIENTOS PARA  SER PRIORITARIOS")->guardar($value, ["req_prioritario" => 1], $value->id);
        }
        //ACTIVAR REQUERIMIENTOS
        //Requerimiento::whereIn("id",$data->get("id"))->update(["req_prioritario"=>1]);
        return redirect()->route("admin.lista_requerimientos")->with("mensaje_success", "Se han agregado los requerimientos como prioritarios.");
    }

    public function calculo_ans(Request $request)
    {
        //============cuentas del ans ==========================//
      $num_vacantes = $request->num_vacantes;

      $date = Carbon::parse(Carbon::now());
      
      $diasans = 0;
        //buscar las reglas de ese cargo
        //$rango = "11:00:00";
         $rango1= strtotime('1:00:00');
         $rango2= strtotime('11:00:00');
         $hora_actual = date('H:i:s');

        if(($hora_actual >= $rango1) && ($hora_actual <= $rango2)){

         $date = Carbon::now(); //por ahora igual a dia de hoy

        }else{
            //return false;
          $diasans = $diasans + 1; //sumo un dia
        }

       $negocio = Negocio::find($request->negocio_id);
      
       $default = 3;

       $ans = NegocioANS::where("negocio_id", $negocio->id)->where("cargo_especifico_id", $request->cargo_especifico_id)->get();
         //buscar los ans de negocio y cargo especifico
        if (count($ans)>0) {
            # code...
         foreach($ans as $key) {

          $regla = explode('A', $key->regla);

           if($num_vacantes >= $regla[0] && $num_vacantes <= $regla[1]){
            // si se ajusta a una de las reglas entonces aplicar la regla
            if(!empty($key->dias_presentar_candidatos_antes)){
             
             $default = $key->dias_presentar_candidatos_antes;
            }
           }

         }

        }//fin de si xiste ans
         
        $diasans = $diasans + $default;

         //fecha de presentacion candidatos es igual al dia de creacion antes de las 11 o el dia despues si es mas de las 11 mas el ans
         $fecha_pre_c = $date->addWeekdays($diasans)->toDateString();

         //fecha tentativa de contratacion es igual al ans mas 2 dias
         //$addDays = $diasans + 2;

         $fecha_tentativa = $date->addWeekdays(4)->toDateString(); //fecha de inicio tentativa__
         //dd($diasans.'//'.$fecha_tentativa)
         $fecha_hoy = Carbon::parse(Carbon::now());
         $fecha_hoy->toDateString();

        $datos =array('fecha_contratacion'=>$fecha_tentativa,'fecha_presentacion_cand'=>$fecha_pre_c, 'fecha_recepcion'=>$fecha_hoy);

       return response()->json($datos);
    }

    //Modal clonar req
    public function clonar_requerimiento_view(Request $data)
    {

        $user          = $this->user;
        $requerimiento = Requerimiento::find($data->get("req_id"));
        $negocio       = Negocio::find($requerimiento->negocio_id);

        /* centro costo */
        $centro_costo = CentroCostoProduccion::join('requerimientos','requerimientos.centro_costo_id','=','centros_costos_produccion.id')
        ->select('centros_costos_produccion.descripcion as centro_costo')
        ->where('requerimientos.id',$data->get("req_id"))
        ->first();

        $cliente = Clientes::find($negocio->cliente_id);

        $atributos_textbox = Atributo::select(
            DB::raw("atributos.nombre_atributo"),
            "atributos_valores.valor_atributo",
            "atributos.tipo_atributo"
        )->join("atributos_valores", "atributos.cod_atributo", "=", "atributos_valores.cod_atributo")
            ->where("atributos_valores.req_id", $data->get("req_id"))
            ->where("atributos.estado", 1)
        ->get();

        //Consultar las personas postuladas segun el requerimiento.
        $candidatos_postulados = CandidatosFuentes::where('requerimiento_id', $data->get("req_id"))
        ->select('*')
        ->get();

        $cargos              = ["" => "Seleccionar"] + CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();
        $tipoProceso         = ["" => "Seleccionar"] + TipoProceso::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoContrato        = ["" => "Seleccionar"] + TipoContrato::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoExperiencia     = ["" => "Seleccionar"] + TipoExperiencia::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoGenero          = ["" => "Seleccionar"] + Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
        $motivoRequerimiento = MotivoRequerimiento::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoJornadas        = ["" => "Seleccionar"] + TipoJornada::where("active", 1)->pluck("descripcion", "id")->toArray();

        $funcionesGlobales = new FuncionesGlobales();
        
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }        

        if(route("home") == "https://asuservicio.t3rsc.co"){
         $ciudadesSelect = ["" => "Seleccionar"] + Ciudad::where("cod_pais", 47)->orderBy("nombre", "asc")->pluck("nombre", "id")->toArray();
        }if(route("home") == "https://gpc.t3rsc.co"){
         $ciudadesSelect = ["" => "Seleccionar"] + Ciudad::where("cod_pais", 63)->orderBy("nombre", "asc")->pluck("nombre", "id")->toArray();
        }else{
          $ciudadesSelect = ["" => "Seleccionar"] + Ciudad::where("cod_pais", 170)->orderBy("nombre", "asc")->pluck("nombre", "id")->toArray();
        }

        if(route("home")=="http://tiempos.t3rsc.co" || route("home")=="https://tiempos.t3rsc.co" ){
            
            //cambiar a tiempos**********
            $ans = NegocioANS::where("negocio_id", $negocio->id)->first();
         
            $date = Carbon::now();
         
            if(!empty($ans->dias_presentar_candidatos_antes)){
                $diasans = $ans->dias_presentar_candidatos_antes;
            }else{
                $diasans = 3;
            }

            //fecha de presentacion = hoy+ans
            $fecha_pre_c = $date->addWeekdays($diasans)->toDateString();
         
            //calculo de fechas dia de hoy mas ans mas 2 dias
            $addDays = $diasans + 2;

            $fecha_tentativa = $date->addWeekdays($addDays)->toDateString(); //fecha de inicio tentativa__
            
            //Fecha tentativa + 8 días habiles
            $fecha_hoy       = $date->toDateString();
            
            //$fecha_tentativa = $date->addWeekdays(8)->toDateString();*/
            $fecha_r_tentativa = "";

        }else{

            //Fecha tentativa + 8 días habiles
            $date            = Carbon::now();
            $fecha_hoy       = $date->toDateString();
            $fecha_tentativa = $date->addWeekdays(8)->toDateString();
        
            //Fecha tentativa retiro + 11 meses
            $date_r            = Carbon::now();
            $fecha_r_tentativa = $date_r->addMonths(11)->toDateString();

            $fecha_pre_c ="";
        }

        return view("admin.requerimientos.modal_clonar_requerimiento_new", compact("atributos_textbox", "candidatos_postulados", "cliente", "user", "negocio", "requerimiento", "centro_costo","nombre","ciudadesSelect","fecha_tentativa","fecha_r_tentativa","fecha_hoy"));
    }

    public function guardar_requerimiento_copia(Request $data){

        $copia = Requerimiento::find($data->get('req_id'));
        
       
        $ciudadReqs   = $data->get('ciudad_trabajo');
        $salarioReqs  = $data->get('salario');
        $vacantesReqs = $data->get('num_vacantes');
      

        $fecha_ingresoReqs = $data->get('fecha_ingreso');
        $fecha_retiroReqs = $data->get('fecha_retiro');
        $fecha_recepcionReqs = $data->get('fecha_recepcion');

        for ($i = 0; $i < count($ciudadReqs); $i++) {

            $ciudadMulti = Ciudad::find($ciudadReqs[$i]);

            $pais_id = $ciudadMulti->cod_pais;
            $departamento_id = $ciudadMulti->cod_departamento;
            $ciudad_id = $ciudadMulti->cod_ciudad;
            $fecha_mañana = $ciudadMulti->created_at;
            //dd($fecha_mañana);

            $cargo_especifico = CargoEspecifico::find($copia->cargo_especifico_id);

            if (route('home') != "http://komatsu.t3rsc.co") {

                $nuevoRequerimiento = new Requerimiento();
                
                if(route('home') == "http://tiempos.t3rsc.co") {
                    $nuevoRequerimiento->salario =str_replace('.', '',$salarioReqs[$i]);
                }

                $nombre = $nuevoRequerimiento->nombre_cliente_req();
                $mensaje_default = nl2br("Estamos buscando personas con mucha actitud y ganas de trabajar para desempeñarse en el cargo de $cargo_especifico->descripcion, queremos que hagas parte de la familia $nombre, por lo cual te invitamos a que:\r\n

                - Completes tu hoja de vida.\n
                - Grabes un video perfil para que mejores las probabilidades de ser seleccionado en el cargo.\n
                -  Apliques a las vacantes y contestes las preguntas de preselección que nuestro equipo de selección ha preparado para ti !\n

                Éxitos en tu aplicación y esperamos que este cargo aporte en tus objetivos laborales y de vida!");

                $nuevoRequerimiento->negocio_id                    = $copia->negocio_id;
                $nuevoRequerimiento->num_vacantes                  = $vacantesReqs[$i];
                $nuevoRequerimiento->tipo_proceso_id               = $copia->tipo_proceso_id;
                $nuevoRequerimiento->tipo_contrato_id              = $copia->tipo_contrato_id;
                $nuevoRequerimiento->genero_id                     = $copia->genero_id;
                $nuevoRequerimiento->motivo_requerimiento_id       = $copia->motivo_requerimiento_id;
                $nuevoRequerimiento->tipo_jornadas_id              = $copia->tipo_jornadas_id;
                $nuevoRequerimiento->salario                       = $salarioReqs[$i];
                $nuevoRequerimiento->sitio_trabajo                 = $ciudadMulti->getSitioTrabajo($pais_id,$departamento_id,$ciudad_id);
                $nuevoRequerimiento->funciones                     = $copia->funciones;
                $nuevoRequerimiento->formacion_academica           = $copia->formacion_academica;
                $nuevoRequerimiento->experiencia_laboral           = $copia->experiencia_laboral;
                $nuevoRequerimiento->conocimientos_especificos     = $copia->conocimientos_especificos;
                $nuevoRequerimiento->observaciones                 = $copia->observaciones;
                $nuevoRequerimiento->solicitado_por                = $this->user->id;
                $nuevoRequerimiento->cargo_especifico_id           = $copia->cargo_especifico_id;

                $nuevoRequerimiento->pais_id                       = $pais_id;
                $nuevoRequerimiento->ciudad_id                     = $ciudad_id;
                $nuevoRequerimiento->departamento_id               = $departamento_id;
                $nuevoRequerimiento->descripcion_oferta            = $mensaje_default;
                $nuevoRequerimiento->estado_publico                = 1;

                $nuevoRequerimiento->edad_minima                   = $copia->edad_minima;
                $nuevoRequerimiento->edad_maxima                   = $copia->edad_maxima;

                $nuevoRequerimiento->telefono_solicitante          = $copia->telefono_solicitante;
                $nuevoRequerimiento->ctra_x_clt_codigo             = $copia->ctra_x_clt_codigo;
                $nuevoRequerimiento->centro_costo_contables        = $copia->centro_costo_contables;
                $nuevoRequerimiento->centro_costo_produccion       = $copia->centro_costo_produccion;

                $nuevoRequerimiento->tipo_liquidacion              = $copia->tipo_liquidacion;
                $nuevoRequerimiento->tipo_salario                  = $copia->tipo_salario;
                $nuevoRequerimiento->tipo_nomina                   = $copia->tipo_nomina;
                $nuevoRequerimiento->concepto_pago_id              = $copia->concepto_pago_id;
                $nuevoRequerimiento->nivel_estudio                 = $copia->nivel_estudio;
                $nuevoRequerimiento->estado_civil                  = $copia->estado_civil;

                $nuevoRequerimiento->fecha_ingreso                 = $fecha_ingresoReqs[$i];
                $nuevoRequerimiento->fecha_retiro                  = $fecha_retiroReqs[$i];
                $nuevoRequerimiento->fecha_recepcion               = $fecha_recepcionReqs[$i];

                $nuevoRequerimiento->contenido_email_soporte       = $copia->contenido_email_soporte;
                $nuevoRequerimiento->cargo_codigo                  = $copia->cargo_codigo;
                $nuevoRequerimiento->grado_codigo                  = $copia->grado_codigo;
                $nuevoRequerimiento->cargo_generico_id             = $copia->cargo_generico_id;


                $nuevoRequerimiento->tipo_experiencia_id           = $copia->tipo_experiencia_id;
                $nuevoRequerimiento->num_req_cliente               = $copia->num_req_cliente;
                $nuevoRequerimiento->req_prioritario               = $copia->req_prioritario;

                $nuevoRequerimiento->fecha_presentacion_candidatos = $copia->fecha_presentacion_candidatos;

                $nuevoRequerimiento->cand_presentados_puntual      = $copia->cand_presentados_puntual;
                $nuevoRequerimiento->cand_presentados_no_puntual   = $copia->cand_presentados_no_puntual;

                $nuevoRequerimiento->fecha_contratacion_candidato  = $copia->fecha_contratacion_candidato;

                $nuevoRequerimiento->esquemas                      = $copia->esquemas;
                $nuevoRequerimiento->informe_preliminar_id         = $copia->informe_preliminar_id;
                $nuevoRequerimiento->centro_costo_id               = $copia->centro_costo_id;
                $nuevoRequerimiento->justificacion                 = $copia->justificacion;
                $nuevoRequerimiento->preperfilados                 = $copia->preperfilados;
                $nuevoRequerimiento->solicitud_id                  = $copia->solicitud_id;
                $nuevoRequerimiento->created_at                    = $copia->created_at;
                $nuevoRequerimiento->tipo_evs_id                   = $copia->tipo_evs_id;

                $nuevoRequerimiento->save();

            }else{

                $nuevoRequerimiento = new Requerimiento();
             
                $mensaje_koma = "Hola, Queremos contar contigo, Komatsu multinacional necesita alguien como tú, si cumples con el perfil aplica a nuestra oferta y has parte de nuestro equipo en Colombia!";

                $nuevoRequerimiento->negocio_id                    = $copia->negocio_id;
                $nuevoRequerimiento->num_vacantes                  = $vacantesReqs[$i];
                $nuevoRequerimiento->tipo_proceso_id               = $copia->tipo_proceso_id;
                $nuevoRequerimiento->tipo_contrato_id              = $copia->tipo_contrato_id;
                $nuevoRequerimiento->genero_id                     = $copia->genero_id;
                $nuevoRequerimiento->motivo_requerimiento_id       = $copia->motivo_requerimiento_id;
                $nuevoRequerimiento->tipo_jornadas_id              = $copia->tipo_jornadas_id;
                $nuevoRequerimiento->salario                       = $salarioReqs[$i];
                $nuevoRequerimiento->sitio_trabajo                 = $ciudadMulti->getSitioTrabajo($pais_id,$departamento_id,$ciudad_id);
                $nuevoRequerimiento->funciones                     = $copia->funciones;
                $nuevoRequerimiento->formacion_academica           = $copia->formacion_academica;
                $nuevoRequerimiento->experiencia_laboral           = $copia->experiencia_laboral;
                $nuevoRequerimiento->conocimientos_especificos     = $copia->conocimientos_especificos;
                $nuevoRequerimiento->observaciones                 = $copia->observaciones;
                $nuevoRequerimiento->solicitado_por                = $this->user->id;
                $nuevoRequerimiento->cargo_especifico_id           = $copia->cargo_especifico_id;

                $nuevoRequerimiento->pais_id                       = $pais_id;
                $nuevoRequerimiento->ciudad_id                     = $ciudad_id;
                $nuevoRequerimiento->departamento_id               = $departamento_id;
                $nuevoRequerimiento->descripcion_oferta            = $mensaje_default;
                $nuevoRequerimiento->estado_publico                = 1;

                $nuevoRequerimiento->edad_minima                   = $copia->edad_minima;
                $nuevoRequerimiento->edad_maxima                   = $copia->edad_maxima;

                $nuevoRequerimiento->telefono_solicitante          = $copia->telefono_solicitante;
                $nuevoRequerimiento->ctra_x_clt_codigo             = $copia->ctra_x_clt_codigo;
                $nuevoRequerimiento->centro_costo_contables        = $copia->centro_costo_contables;
                $nuevoRequerimiento->centro_costo_produccion       = $copia->centro_costo_produccion;

                $nuevoRequerimiento->tipo_liquidacion              = $copia->tipo_liquidacion;
                $nuevoRequerimiento->tipo_salario                  = $copia->tipo_salario;
                $nuevoRequerimiento->tipo_nomina                   = $copia->tipo_nomina;
                $nuevoRequerimiento->concepto_pago_id              = $copia->concepto_pago_id;
                $nuevoRequerimiento->nivel_estudio                 = $copia->nivel_estudio;
                $nuevoRequerimiento->estado_civil                  = $copia->estado_civil;

                $nuevoRequerimiento->fecha_ingreso                 = $fecha_ingresoReqs[$i];
                $nuevoRequerimiento->fecha_retiro                  = $fecha_retiroReqs[$i];
                $nuevoRequerimiento->fecha_recepcion               = $fecha_recepcionReqs[$i];

                $nuevoRequerimiento->contenido_email_soporte       = $copia->contenido_email_soporte;
                $nuevoRequerimiento->cargo_codigo                  = $copia->cargo_codigo;
                $nuevoRequerimiento->grado_codigo                  = $copia->grado_codigo;
                $nuevoRequerimiento->cargo_generico_id             = $copia->cargo_generico_id;


                $nuevoRequerimiento->tipo_experiencia_id           = $copia->tipo_experiencia_id;
                $nuevoRequerimiento->num_req_cliente               = $copia->num_req_cliente;
                $nuevoRequerimiento->req_prioritario               = $copia->req_prioritario;

                $nuevoRequerimiento->fecha_presentacion_candidatos = $copia->fecha_presentacion_candidatos;

                $nuevoRequerimiento->cand_presentados_puntual      = $copia->cand_presentados_puntual;
                $nuevoRequerimiento->cand_presentados_no_puntual   = $copia->cand_presentados_no_puntual;

                $nuevoRequerimiento->fecha_contratacion_candidato  = $copia->fecha_contratacion_candidato;

                $nuevoRequerimiento->esquemas                      = $copia->esquemas;
                $nuevoRequerimiento->informe_preliminar_id         = $copia->informe_preliminar_id;
                $nuevoRequerimiento->centro_costo_id               = $copia->centro_costo_id;
                $nuevoRequerimiento->justificacion                 = $copia->justificacion;
                $nuevoRequerimiento->preperfilados                 = $copia->preperfilados;
                $nuevoRequerimiento->solicitud_id                  = $copia->solicitud_id;
                $nuevoRequerimiento->created_at                    = $copia->created_at;
                $nuevoRequerimiento->tipo_evs_id                   = $copia->tipo_evs_id;
                
                $nuevoRequerimiento->save();

            }
            
            $num_vacantes = $vacantesReqs[$i];

            //Ajuste ANS OCT 30
            $ans = NegocioANS::where("negocio_id", $copia->negocio_id)->get();

            if($ans->count() > 0){

                $inicio_rango = 0;
                $fin_rango    = 0;
                $hay_ans      = false;
                $current      = Carbon::parse($nuevoRequerimiento->created_at);
                $future       = Carbon::parse($nuevoRequerimiento->fecha_ingreso);
                $dias_gestion = $current->diffInDays($future);
                
                foreach ($ans as $key => $value) {
                    
                    list($inicio_rango, $fin_rango) = explode("A", strtoupper($value->regla));

                    if( ($num_vacantes >= $inicio_rango) && ($num_vacantes <= $fin_rango) && !$hay_ans ){
                       
                       //$dias_gestion                  = $value->cantidad_dias;
                       $cuantos_candidatos_presentar  = $value->num_cand_presentar_vac * $num_vacantes;
                       $cuantos_dias_presentar_antes  = $value->dias_presentar_candidatos_antes;
                       $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
                       $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)
                                                       ->subWeekdays($cuantos_dias_presentar_antes);

                       $hay_ans=true;

                    }

                }

                //si no hay ans traemos los valores por defecto
                if( !$hay_ans ){

                    $dias_gestion                  = config('conf_aplicacion.DIAS_DEFECTO_REQUERIMIENTO');
                    $cuantos_candidatos_presentar  = config('conf_aplicacion.CANTIDAD_DE_CAND_A_PRESENTAR_VACANTE') * config('conf_aplicacion.VACANTES_DEFECTO') ;
                    $cuantos_dias_presentar_antes  = config('conf_aplicacion.DIAS_PRESENTACION_CAND_DEFECTO');
                    $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
                    $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)
                                                    ->subWeekdays($cuantos_dias_presentar_antes);
                }

            }else{

                $current  = Carbon::parse($nuevoRequerimiento->created_at);
                $current1 = $current->format('Y-m-d');
                $current2 = Carbon::parse($current1);
                
                $future  = Carbon::parse($nuevoRequerimiento->fecha_ingreso);
                $future1 = $future->format('Y-m-d');
                $future2 = Carbon::parse($future1);

                $dias_gestion = $future2->diffInDays($current2);

                $cuantos_candidatos_presentar  = config('conf_aplicacion.CANTIDAD_DE_CAND_A_PRESENTAR_VACANTE') * config('conf_aplicacion.VACANTES_DEFECTO') ;
                $cuantos_dias_presentar_antes  = config('conf_aplicacion.DIAS_PRESENTACION_CAND_DEFECTO');
                $fecha_tentativa_cierre_req    = Carbon::parse(Carbon::now())->addWeekdays($dias_gestion);
                $fecha_presentacion_oport_cand = Carbon::parse($fecha_tentativa_cierre_req)->subWeekdays($cuantos_dias_presentar_antes);

            }

            $req_actualizacion = Requerimiento::find($nuevoRequerimiento->id);

            if (route('home') == "http://vym.t3rsc.co" || route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://vym.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co") {
                  
                $date_r       = Carbon::now();
                
                $fecha_mañana = $date_r->addWeekdays(1)->toDateString();
                $fecha_mañana .= ' 00:00:00';

                $hora_req= Carbon::parse($nuevoRequerimiento->created_at);

               // if($hora_req->hour >= 12){
                    $req_actualizacion->created_at = $fecha_mañana;
               // }

            }
            
            $req_actualizacion->dias_gestion                  = $dias_gestion;
            $req_actualizacion->cuantos_candidatos_presentar  = $cuantos_candidatos_presentar;
            $req_actualizacion->cuantos_dias_presentar_antes  = $cuantos_dias_presentar_antes;
            $req_actualizacion->fecha_presentacion_oport_cand = $fecha_presentacion_oport_cand;
            $req_actualizacion->fecha_tentativa_cierre_req    = $fecha_tentativa_cierre_req;
            $req_actualizacion->fecha_terminacion             = $fecha_tentativa_cierre_req;

            $req_actualizacion->save();

            $terminar_req = new EstadosRequerimientos();

            $terminar_req->fill([
                "estado"       => config('conf_aplicacion.C_RECLUTAMIENTO'),
                "user_gestion" => $this->user->id,
                "req_id"       => $nuevoRequerimiento->id,
            ]);

            $terminar_req->save();

            $solicitado_por = Requerimiento::leftjoin('datos_basicos','datos_basicos.user_id','=','requerimientos.solicitado_por')
            ->where('requerimientos.id',$nuevoRequerimiento->id)
            ->select('datos_basicos.nombres as nombre_user_soli')
            ->first();

            if(($solicitado_por->nombre_user_soli != "") && (!is_null($solicitado_por->nombre_user_soli))){ 

                $solicitado = $solicitado_por->nombre_user_soli;  

            }else{

                $solicitado = $this->user->name;

            }

            $dataView = [
                'solicitado_por'  => $solicitado,
                'sitio_trabajo'   => $ciudadMulti->getSitioTrabajo($pais_id,$departamento_id,$ciudad_id),
                'num_vacantes'    => $num_vacantes,
                'pais_id'         => $pais_id,
                'departamento_id' => $departamento_id,
                'ciudad_id'       => $ciudad_id,
            ];
            //aqui pegar

         if(route("home") == "http://vym.t3rsc.co" || route("home") == "https://vym.t3rsc.co" ||
            route("home") == "http://listos.t3rsc.co" || route("home") == "https://listos.t3rsc.co" ||
            route("home") == "http://soluciones.t3rsc.co" ||  route("home") == "https://soluciones.t3rsc.co"){
            
            $agencia = User::join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->join('role_users','role_users.user_id','=','users.id')
            ->join('clientes','clientes.id','=','users_x_clientes.cliente_id')
            ->join('negocio','negocio.cliente_id','=','clientes.id')
            ->join('requerimientos','requerimientos.negocio_id','=','negocio.id')
            //->join('ciudad','ciudad.id','=','requerimientos.ciudad_id')
            ->join("ciudad", function($sql){
                $sql->on("ciudad.cod_ciudad","=", "requerimientos.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id")
                    ->on("ciudad.cod_pais","=","requerimientos.pais_id");
                })
            ->where('requerimientos.id',$nuevoRequerimiento->id)
            ->select("ciudad.agencia as agencia")
            //->groupBy("users.id","agencias.id")
            ->first();
            
            $emails = AgenciaUsuario::select("users.name as nombres","users.email as email")
            ->join("users", "users.id", "=", "agencia_usuario.id_usuario")
            ->join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->join("role_users", "users.id", "=", "role_users.user_id")
            ->join('clientes','clientes.id','=','users_x_clientes.cliente_id')
            //->join('negocio','negocio.cliente_id','=','clientes.id')
            ->where("agencia_usuario.id_agencia", $agencia->agencia)
            ->where("users.notificacion_requisicion", 1)
            ->whereIn("role_users.role_id", [17, 5])
            ->where("clientes.id",$nuevoRequerimiento->cliente())
            ->groupBy("users.id")
            ->get();

        }else{
            
            $emails = User::join('datos_basicos','datos_basicos.user_id','=','users.id')
            ->join('users_x_clientes','users_x_clientes.user_id','=','users.id')
            ->join('role_users','role_users.user_id','=','users.id')
            ->join('clientes','clientes.id','=','users_x_clientes.cliente_id')
            ->join('negocio','negocio.cliente_id','=','clientes.id')
            ->join('requerimientos','requerimientos.negocio_id','=','negocio.id')
            ->where("users.notificacion_requisicion",1)
            ->where('requerimientos.id',$nuevoRequerimiento->id)
            ->where('role_users.role_id',17)
            ->groupBy("users.id")
            ->get();
        }

            $funcionesGlobales = new FuncionesGlobales();

            if (isset($funcionesGlobales->sitio()->nombre)) {

                if ($funcionesGlobales->sitio()->nombre != "") {

                    $nombre = $funcionesGlobales->sitio()->nombre;

                } else {

                    $nombre = "Desarrollo";

                }
            }

            $requerimiento_id = $req_actualizacion;

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Notificación Nuevo Requerimiento"; //Titulo o tema del correo
            //Arreglo para el botón
            $mailButton = ['buttonText' => 'GESTIONAR', 'buttonRoute' => route("admin.gestion_requerimiento", [$requerimiento_id->id])];

            
            foreach ($emails as $key => $value) { 

                $url = route('admin.index');
                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "
                    Hola $value->nombres: <br/><br/>
                    Te informamos que {$dataView['solicitado_por']} a cargo de tu cliente {$requerimiento_id->empresa()->nombre}, ha creado un nuevo requerimiento:
                    <br/><br/>

                    <ul>
                        <li>Requerimiento: <b>{$requerimiento_id->id}</b></li>
                        <li>Cargo: <b>{$cargo_especifico->descripcion}</b></li>
                        <li>Ciudad: <b>{$requerimiento_id->getNombreCiudad()->ciudad}</b></li>
                        <li>Tipo Solicitud:
                            <b>{$requerimiento_id->getDescripcionTipoProceso()}</b>
                        </li>
                    </ul>

                    Para visualizar el requerimiento haz clic en el botón “Gestionar”, o si lo prefieres ingresa al módulo de <a href='$url'>administración</a> y consulta tus requerimientos en el menú <b>“Procesos de selección” / “Core”</b>
                ";
            
                $mailUser = $value->user_id; //Id del usuario al que se le envía el correo

                $triEmailNewReq = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                Mail::send($triEmailNewReq->view, ['data' => $triEmailNewReq->data], function($message) use($value, $requerimiento_id, $nombre) {

                    $message->to($value->email,"$nombre - T3RS")
                        ->subject('Nueva requisición No. '.$requerimiento_id->id )
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
                
            }

        }

        // . $nuevoRequerimiento->id
        return redirect()->route("admin.mis_requerimiento")->with("mensaje_success", "Se creó el requerimiento/s ");

    }

    public function trazabilidad_cliente(Request $data){
        //Candidatos vinculados
        $candidatosReq = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join('requerimientos', 'requerimientos.id', '=', 'requerimiento_cantidato.requerimiento_id')
        ->join('users', 'users.id', '=', 'datos_basicos.user_id')
        ->leftjoin('entrevistas_candidatos', function ($sql) {
            $sql->on('datos_basicos.user_id', '=', 'entrevistas_candidatos.candidato_id')
            ->on('entrevistas_candidatos.req_id', '=', 'requerimiento_cantidato.requerimiento_id');
        })
        ->leftjoin('llamada_mensaje',function ($sql) {
            $sql->on('datos_basicos.numero_id', '=', 'llamada_mensaje.numero_id')
            ->on('llamada_mensaje.req_id', '=', 'requerimiento_cantidato.requerimiento_id');
        })
        ->leftjoin('asistencia', 'asistencia.llamada_id', '=', 'llamada_mensaje.id')
        ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
        ->where("requerimiento_cantidato.requerimiento_id", $data->req_id)
        ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
        //->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_ACTIVO'))
        ->whereNotIn('requerimiento_cantidato.estado_candidato',[config('conf_aplicacion.C_QUITAR'),
        config('conf_aplicacion.C_INACTIVO')])
        ->whereRaw('requerimiento_cantidato.id=(select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.requerimiento_id=requerimientos.id and requerimiento_cantidato.candidato_id=datos_basicos.user_id)')
        ->select(
            "entrevistas_candidatos.asistio as asistio",
            "llamada_mensaje.id as llamada_id",
            "asistencia.asistencia as asis",
            "users.video_perfil as video",
            "requerimiento_cantidato.candidato_id as candidato_id",
            "requerimiento_cantidato.requerimiento_id as req_id",
            "datos_basicos.*",
            "datos_basicos.id as datos_basicos_id",
            "estados.descripcion as estado_candidatos",
            "requerimiento_cantidato.id as req_candidato_id",
            "datos_basicos.trabaja as trabaja",
            "requerimiento_cantidato.id"
        )
        ->with("procesos")
        ->groupBy('datos_basicos.numero_id')
        ->orderBy("requerimiento_cantidato.id","DESC")
        ->get();

        $requerimiento = Requerimiento::find($data->req_id);
        $negocio = Negocio::find($requerimiento->negocio_id);
        $cliente = Clientes::find($negocio->cliente_id);

        return view("req.modals.trazabilidad_candidato_cliente_new", compact("candidatosReq", "requerimiento", "cliente"));
    }

    public function  calculo_ans_segun_cargo(Request $data){
        $hoy = Carbon::now();
        $agencias = Agencia::pluck("descripcion")->toArray();

        $ciudad = Ciudad::where("cod_ciudad",$data->ciudad_id)->where("cod_departamento",$data->departamento_id)
        ->where("cod_pais",170)
        ->select("ciudad.nombre")
        ->first();

        $cargo = CargoEspecifico::find($data->cargo_especifico_id);

        //Si son las 11am el requerimiento suma un
        $hora_req = Carbon::parse($hoy);
        if($hora_req->hour >= 11){
            $hoy = $hoy->addWeekdays(1);
        }

        if($data->motivo == 1){
            if($data->vacantes <= 5){
                $hoy = $hoy->addWeekdays($cargo->menor5);
            }
            elseif($data->vacantes<=10){
                $hoy = $hoy->addWeekdays($cargo->menor10);
            }
            elseif($data->vacantes<=20){
                $hoy = $hoy->addWeekdays($cargo->menor20);
            }
            elseif($data->vacantes<=30){
                $hoy = $hoy->addWeekdays($cargo->menor30);
            }
            elseif($data->vacantes<=40){
                $hoy = $hoy->addWeekdays($cargo->menor40);
            }
            elseif($data->vacantes<=50){
                $hoy = $hoy->addWeekdays($cargo->menor50);
            }
            elseif($data->vacantes<=80){
                $hoy = $hoy->addWeekdays($cargo->menor80);
            }

            if(!in_array($ciudad->nombre, $agencias)){
                $hoy = $hoy->addWeekdays(5);
            }

            $hoy = $hoy->addWeekdays(($cargo->examenMedicoDias > 0) ? $cargo->examenMedicoDias  :  0); 
            $hoy = $hoy->addWeekdays(($cargo->estudioSeguridadDias > 0) ? $cargo->estudioSeguridadDias  :  0); 

            $hoy = $hoy->addWeekdays(2);
        }else{
            $hoy = $hoy->addWeekdays(3);

            if(!in_array($ciudad->nombre, $agencias)){
                $hoy = $hoy->addWeekdays(3);
            }
        }


        return response()->json($hoy->toDateString());
    }
}