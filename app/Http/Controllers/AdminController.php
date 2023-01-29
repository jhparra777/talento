<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\DatosBasicos;
use App\Models\Menu;
use App\Models\Requerimiento;
use App\Models\User as EloquentUser;
use App\Models\UserClientes;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Facade\QueryAuditoria;
use App\Http\Requests\NuevoRequerimientoRequest;
use App\Jobs\FuncionesGlobales;
use App\Jobs\SendPostCreateReqEmail;
use App\Models\Atributo;
use App\Models\AtributoSelect;
use App\Models\Auditoria;
use App\Models\CandidatosFuentes;
use App\Models\CargoEspecifico;
use App\Models\CargoGenerico;
use App\Models\CentroCostoProduccion;
use App\Models\CentroTrabajo;
use App\Models\Ciudad;
use App\Models\ConceptoPago;
use App\Models\EstadoCivil;
use App\Models\Estados;
use App\Models\EstadosRequerimientos;
use App\Models\Ficha;
use App\Models\Indicadores;
use App\Models\Genero;
use App\Models\LineaServicio;
use App\Models\Localidad;
use App\Models\MotivoRequerimiento;
use App\Models\Negocio;
use App\Models\NivelEstudios;
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
use App\Models\ReqCandidato;
use App\Models\RegistroProceso;
use App\Models\User;
use Carbon\Carbon;
use App\Models\NegocioANS;
use App\Models\Facturacion;
use App\Models\AsignacionPsicologo;
use App\Models\SolicitudAreaFuncional;
use App\Models\SolicitudSedes;
use App\Models\SolicitudUserPasos;


use App\Models\Agencia;
use App\Models\Sitio;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{

    protected $estados_no_muestra = [];

    public function __construct()
    {
        parent::__construct();

        //SON LOS ESTADOS PARA NO MOSTRAR EL CANDIDATO EN EL  REQUERIMIENTO
        $this->estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
        ];
    }

    public function index(Request $data)
    {
        $colores = ["#00c0ef", "#00a65a", "#f39c12", "#d9534f", "#8e44ad", "#dd4b39"];
            
        if(route("home") == "https://komatsu.t3rsc.co") {
            $user = $this->user->id;
        }else {
            $user = "";
        }

        $requerimientos = Requerimiento::distinct('requerimientos.id')->count();

        //CONTADORES RECLUTAMIENTO, SELECCION Y CONTRATACION TOTALES
        if(route("home") == "https://temporizar.t3rsc.co") {
            $requerimientos_abiertos_r_t =  Requerimiento::where('tipo_proceso_id',2)
            ->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'), [date("Y-m-d", strtotime(date("Y-m-d")."- 6 month")), date("Y-m-d")])
            ->select(
                'requerimientos.id',
                'requerimientos.id as requerimiento_id',
                'requerimientos.num_vacantes as vacantes_solicitadas',
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as numero_vac_ven ')
            )
            ->with("estados")
            ->orderBy("requerimientos.id")
            ->get();

            $requerimientos_abiertos_r_t = $requerimientos_abiertos_r_t->filter(function ($value) {
                if($value->estados->count()>0) {
                    return in_array($value->estados->last()->estado,[
                        config('conf_aplicacion.C_TERMINADO'),
                        config('conf_aplicacion.C_RECLUTAMIENTO'),
                        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                        config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                        config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                    ]);
                }
                else{
                    return false;
                }
            });
        
            $num_req_a_r_t = $requerimientos_abiertos_r_t->count();

            $numero_vacantes_r_t = $requerimientos_abiertos_r_t->sum("vacantes_solicitadas");

            $fecha_hoy = Carbon::now();
            $fecha_hoy = $fecha_hoy->format('Y-m-d');
        
            $vacantes_ven_r_t = $requerimientos_abiertos_r_t->filter(function ($value){
                if($value->estados->count()>0) {
                    if($value->estados->last()->estado !=config('conf_aplicacion.C_TERMINADO')) {
                        return 1;
                    }else {
                        return 0;
                    }
                }
                else {
                    return 0;
                }
            });

            $numero_vac_r_t=$vacantes_ven_r_t->sum("numero_vac_ven");
            $numero_contratar=$vacantes_ven_r_t->sum("cant_enviados_contratacion");

            $num_can_con_r_t = $numero_contratar;

            //CONTADORES RECLUTAMIENTO , SELECCION Y CONTRATACION//
            $requerimientos_abiertos_r = $requerimientos_abiertos_r_t->filter(function ($value) {
                if($value->estados->count() > 0) {
                    if($value->estados->last()->estado == config('conf_aplicacion.C_TERMINADO') || $value->estados->last()->estado == config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL')) {
                        return 0;
                    }else {
                        return 1;
                    }
                }else {
                    return 0;
                }
            });

            $num_req_a_r = $requerimientos_abiertos_r->count();

            $numero_vacantes_r = $requerimientos_abiertos_r->sum("vacantes_solicitadas");

            $numero_vac_r = 0;

            $numero_vac_r = $requerimientos_abiertos_r->sum("numero_vac_ven");

            $numero_contratar = 0;

            $numero_contratar = $requerimientos_abiertos_r->sum("cant_enviados_contratacion");

            $fecha_hoy = Carbon::now();
            $fecha_hoy = $fecha_hoy->format('Y-m-d');

            $num_can_con_r = $numero_contratar;

            $requerimientos_abiertos_s= Requerimiento::join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            ->where('tipo_proceso.id',6)
            ->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'), [date("Y-m-d", strtotime(date("Y-m-d")."- 6 month")), date("Y-m-d")])
            ->whereIn('estados_requerimiento.estado',[ 
                config('conf_aplicacion.C_RECLUTAMIENTO'),
                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            ])
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->select(
                "requerimientos.num_vacantes as numero_vacantes",
                DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as numero_vac '),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion')
            )
            ->get();

            $num_req_a_s = $requerimientos_abiertos_s->count();

            $numero_vacantes_s=$requerimientos_abiertos_s->sum("numero_vacantes");

            $numero_vac_s=$requerimientos_abiertos_s->sum("numero_vac");

            $numero_contratar=$requerimientos_abiertos_s->sum("cant_enviados_contratacion");

            $num_can_con_s = $numero_contratar;

            $fecha_hoy = Carbon::now();
            $fecha_hoy = $fecha_hoy->format('Y-m-d');
        }
        
        //$menu = Menu::where("modulo", "req")->where("tipo", "view")->where("padre_id", 0)->get();

        /*INDICADORES NORMALES*/
        if(route("home") != "https://temporizar.t3rsc.co") {
            if(route("home") != "https://vym.t3rsc.co" && route("home")!="https://listos.t3rsc.co") {
                $requerimientos_abiertos = Requerimiento::join('users', 'requerimientos.solicitado_por', '=', 'users.id')
                ->where(function ($sql) use ($user) {
                    if(route("home") != "https://komatsu.t3rsc.co" && route("home") != "http://localhost:8000") {
                        $sql->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[date("Y-m-d",strtotime(date("Y-m-d")."- 6 month")),date("Y-m-d")]);
                    }
                })
                ->select(
                    "requerimientos.id","num_vacantes",
                    "requerimientos.fecha_ingreso as fecha_ingreso",
                    DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                    DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as numero_vac '),
                    DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as numero_vac ')
                )
                ->with("estados")
                ->get();

                $requerimientos_abiertos = $requerimientos_abiertos->filter(function ($value) {
                    if($value->estados->count() > 0) {
                        return in_array($value->estados->last()->estado,[ config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE')]);
                        }
                    else {
                        return false;
                    }
                });

                $fecha_hoy = Carbon::now();
                $fecha_hoy = $fecha_hoy->format('Y-m-d');
                $num_req_a = $requerimientos_abiertos->count();
                $numero_vacantes = $requerimientos_abiertos->sum("num_vacantes");
                $num_can_con = $requerimientos_abiertos->sum("cant_enviados_contratacion");
                    
                $numero_vac = $requerimientos_abiertos->filter(function ($value) use($fecha_hoy) {
                    if($value->fecha_ingreso <= $fecha_hoy) {
                        return 0;
                    }else{
                        return 1;
                    }
                })->count();
            }else {
                $requerimientos_abiertos = Requerimiento::join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
                ->join('ciudad', function ($join) {
                    $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                    ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
                })
                ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
                ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
                ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
                ->whereIn("clientes.id", $this->clientes_user)
                ->whereIn("ciudad.agencia", $this->user->agencias())
                ->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[date("Y-m-d",strtotime(date("Y-m-d")."- 6 month")),date("Y-m-d")])
                ->whereIn('estados_requerimiento.estado',[
                    config('conf_aplicacion.C_RECLUTAMIENTO'),
                    config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                    config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                    config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                ])
                ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
                ->select(
                    "num_vacantes",
                    "requerimientos.fecha_ingreso as fecha_ingreso",
                    DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                    DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as numero_vac '),
                    DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as numero_vac ')
                )
                ->get();

                $fecha_hoy = Carbon::now();
                $fecha_hoy = $fecha_hoy->format('Y-m-d');
                $num_req_a = $requerimientos_abiertos->count();
                $numero_vacantes=$requerimientos_abiertos->sum("num_vacantes");
                $num_can_con=$requerimientos_abiertos->sum("cant_enviados_contratacion");
                
                $numero_vac = $requerimientos_abiertos->filter(function ($value) use($fecha_hoy) {
                    if($value->fecha_ingreso <= $fecha_hoy) {
                        return 0;
                    }else {
                        return 1;
                    }
                })->count();
            }
        }

        $report_name4 = null;
        
        $ano_actual = date("Y");
        $menu = Menu::where("modulo", "admin")->where("tipo", "view")->where("padre_id", 0)->get();

        $numero_vacantes_contra = Requerimiento::join('users', 'requerimientos.solicitado_por', '=', 'users.id')
        ->whereRaw('(DATE_FORMAT(requerimientos.created_at, \'%Y\')='.$ano_actual.')')
        ->select(
            DB::raw('DATE_FORMAT(requerimientos.created_at, \'%m\') as mes_creacion'),
            'requerimientos.num_vacantes as vacantes_solicitadas',
            DB::raw('(select count(*) as cantidad from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion')
        )
        ->get();

        $candidatos_contratados_ene = 0;
        $candidatos_contratados_feb = 0;
        $candidatos_contratados_mar = 0;
        $candidatos_contratados_abr = 0;
        $candidatos_contratados_may = 0;
        $candidatos_contratados_jun = 0;
        $candidatos_contratados_jul = 0;
        $candidatos_contratados_agos = 0;
        $candidatos_contratados_sep = 0;
        $candidatos_contratados_oct = 0;
        $candidatos_contratados_nov = 0;
        $candidatos_contratados_dic = 0;
        $candidatos_solicitados_ene = 0;
        $candidatos_solicitados_feb = 0;
        $candidatos_solicitados_mar = 0;
        $candidatos_solicitados_abr = 0;
        $candidatos_solicitados_may = 0;
        $candidatos_solicitados_jun = 0;
        $candidatos_solicitados_jul = 0;
        $candidatos_solicitados_agos = 0;
        $candidatos_solicitados_sep = 0;
        $candidatos_solicitados_oct = 0;
        $candidatos_solicitados_nov = 0;
        $candidatos_solicitados_dic = 0;

        foreach ($numero_vacantes_contra as $key => $value) {
            if ($value->mes_creacion == "01") {
                $candidatos_contratados_ene = $candidatos_contratados_ene + $value->cant_enviados_contratacion;
                $candidatos_solicitados_ene = $candidatos_solicitados_ene + $value->vacantes_solicitadas;

            }elseif ($value->mes_creacion == "02") {
               $candidatos_contratados_feb = $candidatos_contratados_feb + $value->cant_enviados_contratacion;
                $candidatos_solicitados_feb = $candidatos_solicitados_feb + $value->vacantes_solicitadas;
            }elseif ($value->mes_creacion == "03") {
                $candidatos_contratados_mar = $candidatos_contratados_mar + $value->cant_enviados_contratacion;
                $candidatos_solicitados_mar = $candidatos_solicitados_mar + $value->vacantes_solicitadas;
            }elseif ($value->mes_creacion == "04") {
                $candidatos_contratados_abr = $candidatos_contratados_abr + $value->cant_enviados_contratacion;
                $candidatos_solicitados_abr = $candidatos_solicitados_abr + $value->vacantes_solicitadas;
            }elseif ($value->mes_creacion == "05") {
                $candidatos_contratados_may = $candidatos_contratados_may + $value->cant_enviados_contratacion;
                $candidatos_solicitados_may = $candidatos_solicitados_may + $value->vacantes_solicitadas;
            }elseif ($value->mes_creacion == "06") {
                $candidatos_contratados_jun = $candidatos_contratados_jun + $value->cant_enviados_contratacion;
                $candidatos_solicitados_jun = $candidatos_solicitados_jun + $value->vacantes_solicitadas;
            }elseif ($value->mes_creacion == "07") {
                $candidatos_contratados_jul = $candidatos_contratados_jul + $value->cant_enviados_contratacion;
                $candidatos_solicitados_jul = $candidatos_solicitados_jul + $value->vacantes_solicitadas;
            }elseif ($value->mes_creacion == "08") {
                $candidatos_contratados_agos = $candidatos_contratados_agos + $value->cant_enviados_contratacion;
                $candidatos_solicitados_agos = $candidatos_solicitados_agos + $value->vacantes_solicitadas;
            }elseif ($value->mes_creacion == "09") {
                $candidatos_contratados_sep = $candidatos_contratados_sep + $value->cant_enviados_contratacion;
                $candidatos_solicitados_sep = $candidatos_solicitados_sep + $value->vacantes_solicitadas;
            }elseif ($value->mes_creacion == "10") {
                $candidatos_contratados_oct = $candidatos_contratados_oct + $value->cant_enviados_contratacion;
                $candidatos_solicitados_oct = $candidatos_solicitados_oct + $value->vacantes_solicitadas;
            }elseif ($value->mes_creacion == "11") {
                $candidatos_contratados_nov = $candidatos_contratados_nov + $value->cant_enviados_contratacion;
                $candidatos_solicitados_nov = $candidatos_solicitados_nov + $value->vacantes_solicitadas;
            }elseif ($value->mes_creacion == "12") {
                $candidatos_contratados_dic = $candidatos_contratados_dic + $value->cant_enviados_contratacion;
                $candidatos_solicitados_dic = $candidatos_solicitados_dic + $value->vacantes_solicitadas;
            }
        }

        $report_name4 = 'reporte_indicadores_oportunidad4';

        $indi4 = \Lava::DataTable();
        $columna2 = "Contratadas";

        if(route("home") == "https://gpc.t3rsc.co") {
            $columna2 = "Aprobadas";
        }

        $indi4
        ->addDateColumn('Year')
        ->addNumberColumn('Solicitadas')
        ->addNumberColumn($columna2)
        ->addRow([$ano_actual.'-1-1', $candidatos_solicitados_ene,$candidatos_contratados_ene])
        ->addRow([$ano_actual.'-2-1', $candidatos_solicitados_feb,$candidatos_contratados_feb])
        ->addRow([$ano_actual.'-3-1', $candidatos_solicitados_mar,$candidatos_contratados_mar])
        ->addRow([$ano_actual.'-4-1', $candidatos_solicitados_abr,$candidatos_contratados_abr])
        ->addRow([$ano_actual.'-5-1', $candidatos_solicitados_may,$candidatos_contratados_may])
        ->addRow([$ano_actual.'-6-1', $candidatos_solicitados_jun,$candidatos_contratados_jun])
        ->addRow([$ano_actual.'-7-1', $candidatos_solicitados_jul,$candidatos_contratados_jul])
        ->addRow([$ano_actual.'-8-1', $candidatos_solicitados_agos,$candidatos_contratados_agos])
        ->addRow([$ano_actual.'-9-1', $candidatos_solicitados_sep,$candidatos_contratados_sep])
        ->addRow([$ano_actual.'-10-1',$candidatos_solicitados_oct,$candidatos_contratados_oct])
        ->addRow([$ano_actual.'-11-1',$candidatos_solicitados_nov,$candidatos_contratados_nov])
        ->addRow([$ano_actual.'-12-1',$candidatos_solicitados_dic,$candidatos_contratados_dic]);

        \Lava::ComboChart($report_name4, $indi4, [
            'title' => 'Indicador de efectividad',
            'is3D'   => true,
            'chartArea' => [
                'left' => 60,
                'top' => 100,
                'height' => '70%',
                'width' => '100%'
            ],
            'height' => '460',
            'width' => '1000',
            //BackgroundColor Options
            'titleTextStyle' => [
                'color'    => 'rgb(123, 65, 89)',
                'fontSize' => 16
            ],
            'legend' => [
                'position' => 'in'
            ]
        ]);

        //Datos para el gráfico JS
            $candidatosSolicitados = [
                'candidatosEnero' => $candidatos_solicitados_ene,
                'candidatosFebrero' => $candidatos_solicitados_feb,
                'candidatosMarzo' => $candidatos_solicitados_mar,
                'candidatosAbril' => $candidatos_solicitados_abr,
                'candidatosMayo' => $candidatos_solicitados_may,
                'candidatosJunio' => $candidatos_solicitados_jun,
                'candidatosJulio' => $candidatos_solicitados_jul,
                'candidatosAgosto' => $candidatos_solicitados_agos,
                'candidatosSeptiembre' => $candidatos_solicitados_sep,
                'candidatosOctubre' => $candidatos_solicitados_oct,
                'candidatosNoviembre' => $candidatos_solicitados_nov,
                'candidatosDiciembre' => $candidatos_solicitados_dic
            ];

            $candidatosContratados = [
                'candidatosEnero' => $candidatos_contratados_ene,
                'candidatosFebrero' => $candidatos_contratados_feb,
                'candidatosMarzo' => $candidatos_contratados_mar,
                'candidatosAbril' => $candidatos_contratados_abr,
                'candidatosMayo' => $candidatos_contratados_may,
                'candidatosJunio' => $candidatos_contratados_jun,
                'candidatosJulio' => $candidatos_contratados_jul,
                'candidatosAgosto' => $candidatos_contratados_agos,
                'candidatosSeptiembre' => $candidatos_contratados_sep,
                'candidatosOctubre' => $candidatos_contratados_oct,
                'candidatosNoviembre' => $candidatos_contratados_nov,
                'candidatosDiciembre' => $candidatos_contratados_dic
        ];
        //
    
        return view("admin.index-new", compact(
            "numero_vac_s",
            "numero_vacantes_s",
            "num_req_a_s",
            "num_can_con_s",
            "num_can_con_r",
            "num_req_a_r",
            "numero_vacantes_r",
            "numero_vac_r",
            "num_can_con_r_t",
            "num_req_a_r_t",
            "numero_vacantes_r_t",
            "numero_vac_r_t",
            "report_name4",
            "menu",
            "colores",
            "conteos",
            "num_req_a",
            "numero_vacantes",
            "numero_vac",
            "num_can_con",
            "candidatosSolicitados",
            "candidatosContratados"
        ));
    }

    public function lista_reclutamiento(Request $data)
    {
        $user_sesion = $this->user;
        $sitio = Sitio::first();
        $agencias=[];

        $id_user = DatosBasicos::where("numero_id", $data->get("cedula"))->first();

        $estados = [
            config('conf_aplicacion.C_TERMINADO'),
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
            2,
            3,
            1
        ];

        $estados_requerimiento = ["" => "Seleccionar"] + Estados::whereIn("id", $estados)
        ->pluck("estados.descripcion", "estados.id")
        ->toArray();

        if($data->get('estado_id') != ""){
            $estados = array();
            $estados[] = $data->get('estado_id');
        }

        if(route('home') == "https://komatsu.t3rsc.co") {
            ///aqui asigna el psicologo
            $user_psico = User::join('role_users', 'role_users.user_id', '=', 'users.id')
            ->where('role_users.user_id', $user_sesion->id)
            ->where('role_users.role_id', 17)
            ->first();

            if($user_psico) {
                $clientes = ["" => "Seleccionar"] + Clientes::orderBy("clientes.nombre", "ASC")
                ->pluck("clientes.nombre", "clientes.id")
                ->toArray();

                $listaProcesos = ["" => "Seleccionar"] + TipoProceso::where('active', 1)
                ->pluck('tipo_proceso.descripcion', 'tipo_proceso.id')
                ->toArray();

                $listaCargos = ["" => "Seleccionar"] + CargoEspecifico::pluck('cargos_especificos.descripcion', 'cargos_especificos.id')
                ->toArray();

                $usuarios = ["" => "Seleccionar"] + EloquentUser::pluck("name", "id")->toArray();

                $solicitante = ["" => "Seleccionar"] + SolicitudUserPasos::join("users","users.id","=","solicitud_user_paso.user_solicitante")
                ->pluck("users.name", "solicitud_user_paso.user_solicitante")
                ->toArray();

                $sede = ["" => "Seleccionar"] + SolicitudSedes::where("estado", 1)->pluck("descripcion", "id")->toArray();

                $areas = ["" => "Seleccionar"] + SolicitudAreaFuncional::where("estado", 1)->pluck("descripcion", "id")->toArray();

                $requerimientos = Requerimiento::join('ciudad', function ($join) {
                    $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                    ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
                })
                ->join('asignacion_psicologo', 'asignacion_psicologo.req_id', '=', 'requerimientos.id')
                ->join('paises', 'requerimientos.pais_id', '=', 'paises.cod_pais')
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->join('users_x_clientes','users_x_clientes.cliente_id','=','clientes.id')
                ->join("users", "users.id", "=", "users_x_clientes.user_id")
                ->join('solicitudes', 'requerimientos.solicitud_id', '=', 'solicitudes.id')
                ->where('users_x_clientes.user_id', $this->user->id)
                ->leftJoin("requerimiento_cantidato", "requerimiento_cantidato.requerimiento_id", "=", "requerimientos.id")
                ->where(function ($sql) use ($data, $id_user) {
                    if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                        $sql->where("clientes.id", $data->get("cliente_id"));
                    }

                    if($data->has("solicitante") && $data->get("solicitante") != "") {
                        $sql->where("requerimientos.solicitado_por", $data->get("solicitante"));
                    }

                    if($data->has("cargo_id") && $data->get("cargo_id") != "") {
                        $sql->where("requerimientos.cargo_especifico_id", $data->get("cargo_id"));
                    }
                    
                    if ($data->has("num_req") && $data->get("num_req") != "") {
                        $sql->where("requerimientos.id", $data->get("num_req"));
                    }

                    if($data->has("area_id") && $data->get("area_id") != ""){
                        $sql->where("solicitudes.area_id", $data->get("area_id"));
                    }

                    if($data->has("tipo_proceso_id") && $data->get("tipo_proceso_id") != ""){
                        $sql->where("tipo_proceso.id", $data->get("tipo_proceso_id"));
                    }

                    if ($data->has("cedula") && $data->get("cedula") != "") {
                        if ($id_user != null) {
                            $sql->where("requerimiento_cantidato.candidato_id", $id_user->user_id);
                        }else {
                            $sql->where("requerimiento_cantidato.candidato_id", $data->cedula);
                        }

                        $sql->whereIn("requerimiento_cantidato.estado_candidato", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION')
                        ]);
                    }
                })
                ->select(
                    'requerimientos.solicitud_id',
                    'clientes.id as cliente_id',
                    'negocio.nombre_negocio',
                    'requerimientos.id',
                    'asignacion_psicologo.psicologo_id',
                    "cargos_especificos.descripcion as cargo",
                    "requerimientos.num_vacantes",
                    "requerimientos.created_at",
                    "requerimientos.fecha_ingreso",
                    "requerimientos.dias_gestion",
                    DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                    "requerimientos.id",
                    "tipo_proceso.descripcion as tipo_proceso_desc",
                    "negocio.num_negocio",
                    "clientes.nombre as nombre_cliente",
                    "users.name as nombre_usuario",
                    "requerimientos.id as req_id"
                )
                ->groupBy(
                    "requerimientos.id",
                    "tipo_proceso.descripcion",
                    "negocio.num_negocio",
                    "clientes.nombre",
                    "users.name",
                    "requerimientos.num_vacantes",
                    "requerimientos.created_at",
                    "requerimientos.fecha_ingreso",
                    "requerimientos.dias_gestion"
                )
                ->orderBy("requerimientos.id", "desc")
                ->paginate(5);

                return view("admin.reclutamiento.requerimientos_analistas", compact(
                    "user_sesion",
                    "requerimientos",
                    "clientes",
                    "usuarios",
                    "listaProcesos",
                    "estados_requerimiento",
                    "areas",
                    "sede",
                    "listaCargos",
                    "solicitante"
                ));
            }else {
                $clientes = ["" => "Seleccionar"] + Clientes::orderBy("clientes.nombre", "ASC")->pluck("clientes.nombre", "clientes.id")
                ->toArray();

                $listaProcesos = ["" => "Seleccionar"] + TipoProceso::where('active', 1)->pluck('tipo_proceso.descripcion', 'tipo_proceso.id')
                ->toArray();

                $usuarios = ["" => "Seleccionar"] + EloquentUser::pluck("name", "id")->toArray();

                $listaCargos = ["" => "Seleccionar"] + CargoEspecifico::pluck('cargos_especificos.descripcion', 'cargos_especificos.id')
                ->toArray();

                $areas = ["" => "Seleccionar"] + SolicitudAreaFuncional::where("estado", 1)->pluck("descripcion", "id")->toArray();

                $solicitante = ["" => "Seleccionar"] + SolicitudUserPasos::join("users", "users.id", "=", "solicitud_user_paso.user_solicitante")
                ->pluck("users.name", "solicitud_user_paso.user_solicitante")
                ->toArray();

                $sede = ["" => "Seleccionar"] + SolicitudSedes::where("estado", 1)->pluck("descripcion", "id")->toArray();

                $requerimientos = Requerimiento::leftjoin('asignacion_psicologo','asignacion_psicologo.req_id','=','requerimientos.id')
                ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->join("users", "users.id", "=", "requerimientos.solicitado_por")
                ->join('solicitudes', 'requerimientos.solicitud_id', '=', 'solicitudes.id')
                ->leftJoin("requerimiento_cantidato", "requerimiento_cantidato.requerimiento_id", "=", "requerimientos.id")
                ->where(function ($sql) use ($data, $id_user) {
                    if ($data->has("num_req") && $data->get("num_req") != "") {
                        $sql->where("requerimientos.id", $data->get("num_req"));
                    }

                    if ($data->has("cargo_id") && $data->get("cargo_id") != "") {
                        $sql->where("requerimientos.cargo_especifico_id", $data->get("cargo_id"));
                    }
                    
                    if ($data->has("solicitante") && $data->get("solicitante") != "") {
                        $sql->where("requerimientos.solicitado_por", $data->get("solicitante"));
                    }

                    if($data->has("tipo_proceso_id") && $data->get("tipo_proceso_id") != ""){
                        $sql->where("tipo_proceso.id", $data->get("tipo_proceso_id"));
                    }

                    if($data->has("area_id") && $data->get("area_id") != ""){
                        $sql->where("solicitudes.area_id", $data->get("area_id"));
                    }

                    if ($data->has("cedula") && $data->get("cedula") != "") {
                        if ($id_user != null) {
                            $sql->where("requerimiento_cantidato.candidato_id", $id_user->user_id);
                        }else {
                            $sql->where("requerimiento_cantidato.candidato_id", $data->cedula);
                        }

                        $sql->whereIn("requerimiento_cantidato.estado_candidato", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_EXAMENES_MEDICOS'),
                        ]);
                    }
                });
                
                $role = User::join('role_users', 'role_users.user_id', '=', 'users.id')
                ->where('users.id', $this->user->id)
                ->whereIn('role_users.role_id', ['19', '4'])
                ->select('role_users.*')
                ->get();

                if($role->count() == 0) {
                    $requerimientos = $requerimientos->where('asignacion_psicologo.psicologo_id', $this->user->id);
                }

                $requerimientos = $requerimientos->select(
                    'requerimientos.solicitud_id',
                    'asignacion_psicologo.id as asigna',
                    'requerimientos.id',
                    'asignacion_psicologo.psicologo_id',
                    "cargos_especificos.descripcion as cargo","requerimientos.num_vacantes", "requerimientos.created_at",
                    "requerimientos.fecha_ingreso",
                    "requerimientos.fecha_plazo_req",
                    "requerimientos.dias_gestion",
                    "requerimientos.id",
                    "tipo_proceso.descripcion as tipo_proceso_desc",
                    "users.name as nombre_usuario",
                    "requerimientos.id as req_id"
                )
                ->groupBy(
                    "requerimientos.id",
                    "tipo_proceso.descripcion",
                    "users.name",
                    "requerimientos.num_vacantes",
                    "requerimientos.created_at",
                    "requerimientos.fecha_ingreso",
                    "requerimientos.dias_gestion"
                )
                ->orderBy("requerimientos.id", "desc")
                ->paginate(5);

                return view("admin.reclutamiento.requerimiento-new", compact(
                    "user_sesion",
                    "requerimientos",
                    "clientes",
                    "usuarios",
                    "listaProcesos",
                    "estados_requerimiento",
                    "areas",
                    "sede",
                    "listaCargos",
                    "solicitante"
                ));
            }
        }elseif(route('home') == "https://soluciones.t3rsc.co") {
            //solo para soluciones
            $date = Carbon::now();
            $mes = $date->subDay(15);

            $requerimientos = Requerimiento::leftJoin("requerimiento_cantidato", "requerimiento_cantidato.requerimiento_id", "=", "requerimientos.id")
            ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->whereIn("estados_requerimiento.estado", $estados)
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")         
            ->where(function ($sql) use ($data, $id_user,$mes) {
                if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }

                if ($data->has("cargo_id") && $data->get("cargo_id") != "") {
                    $sql->where("requerimientos.cargo_especifico_id", $data->get("cargo_id"));
                }

                if ($data->has("num_req") && $data->get("num_req") != "") {
                    $sql->where("requerimientos.id", $data->get("num_req"));
                }

                if($data->has("tipo_proceso_id") && $data->get("tipo_proceso_id") != ""){
                    $sql->where("tipo_proceso.id", $data->get("tipo_proceso_id"));
                }

                if ($data->has("cedula") && $data->get("cedula") != "") {
                    if ($id_user != null) {
                        $sql->where("requerimiento_cantidato.candidato_id", $id_user->user_id);
                    }else{
                        $sql->where("requerimiento_cantidato.candidato_id", $data->cedula);
                    }

                    $sql->whereIn("requerimiento_cantidato.estado_candidato", [
                        config('conf_aplicacion.C_RECLUTAMIENTO'),
                        config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                        config('conf_aplicacion.C_CONTRATADO'),
                        config('conf_aplicacion.C_CONTRATACION_CANCELADA'),
                        config('conf_aplicacion.C_EN_EXAMENES_MEDICOS'),
                    ]);
                }

                if ($data->get("cedula") == "" && $data->get("num_req") == "" && $data->get("cliente_id") == "") {
                    $sql->whereDate('requerimientos.created_at','>',$mes);
                 }
            })
            ->select(
                'requerimientos.*',
                'requerimiento_cantidato.id as req_c_id',
                "cargos_especificos.firma_digital as firma_cargo",
                DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales'),
                DB::raw('requerimientos.num_vacantes - (select count(*) from firma_contratos where terminado in(1,2) and estado not in(0) and req_id=requerimientos.id ) as vacantes_reales_asistente')
            )
            ->with("estados")
            ->groupBy(
                "requerimientos.id",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_ingreso",
                "requerimientos.dias_gestion"
            )
            ->orderBy('requerimientos.id', 'desc')
            ->take(30)->get();

            $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();

            $currentPageItems = $requerimientos->slice(($currentPage - 1) * 5, 5);
            $requerimientos = new \Illuminate\Pagination\LengthAwarePaginator($currentPageItems, count($requerimientos), 5,'', ['path'=>route("admin.reclutamiento")]);

            $clientes = ["" => "Seleccionar"] + Clientes::orderBy("clientes.nombre", "ASC")
            ->pluck("clientes.nombre", "clientes.id")
            ->toArray();

            $listaProcesos = ["" => "Seleccionar"] + TipoProceso::where('active', 1)->pluck('tipo_proceso.descripcion', 'tipo_proceso.id')
            ->toArray();

            return view("admin.reclutamiento.requerimiento-new", compact(
                "user_sesion",
                "requerimientos",
                "clientes",
                "usuarios",
                "listaProcesos",
                "estados_requerimiento",
                "sitio"
            ));
        }elseif(route("home") == "https://vym.t3rsc.co" || route("home") == "https://listos.t3rsc.co") {
            $requerimientos = Requerimiento::join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->join('paises', 'requerimientos.pais_id', '=', 'paises.cod_pais')
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->join("users", "users.id", "=", "requerimientos.solicitado_por")
            ->whereIn("clientes.id", $this->clientes_user)
            ->whereIn("ciudad.agencia", $this->user->agencias())
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->whereIn("estados_requerimiento.estado", $estados)
            ->where("ciudad.cod_pais", 170)
            ->where(function ($sql) use ($data, $id_user) {
                if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }

                if ($data->has("cargo_id") && $data->get("cargo_id") != "") {
                    $sql->where("requerimientos.cargo_especifico_id", $data->get("cargo_id"));
                }

                if ($data->has("num_req") && $data->get("num_req") != "") {
                    $sql->where("requerimientos.id", $data->get("num_req"));
                }

                if($data->has("tipo_proceso_id") && $data->get("tipo_proceso_id") != ""){
                    $sql->where("tipo_proceso.id", $data->get("tipo_proceso_id"));
                }
                
                if($data->has("agencia") && $data->get("agencia") != ""){
                    $sql->where("ciudad.agencia", $data->get("agencia"));
                }
            })
            ->select(
                'clientes.id as cliente_id',
                'negocio.nombre_negocio',
                'requerimientos.id',
                'ciudad.nombre as ciudad',
                "cargos_especificos.descripcion as cargo",
                "cargos_especificos.firma_digital as firma_cargo",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_ingreso",
                "requerimientos.fecha_tentativa_cierre_req",
                "requerimientos.dias_gestion",
                DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and proceso not in(\'CANCELA_CONTRATACION\') and requerimiento_id = requerimientos.id ) as vacantes_reales'),
                DB::raw('requerimientos.num_vacantes - (select count(*) from firma_contratos where terminado in(1,2) and estado not in(0) and req_id=requerimientos.id ) as vacantes_reales_asistente'),
                "requerimientos.id",
                "tipo_proceso.descripcion as tipo_proceso_desc",
                "negocio.num_negocio",
                "clientes.nombre as nombre_cliente",
                "users.name as nombre_usuario",
                "requerimientos.id as req_id"
            )
            ->with("estados")
            ->groupBy(
                "requerimientos.id",
                "tipo_proceso.descripcion",
                "negocio.num_negocio",
                "clientes.nombre",
                "users.name",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_ingreso",
                "requerimientos.dias_gestion"
            )
            ->orderBy("requerimientos.id", "desc");
            //->take(50)->get();
            //->paginate(5);

            if($data->has("cedula") && $data->get("cedula") != ""){
                $requerimientos = $requerimientos->join("requerimiento_cantidato",function($join) use($data,$id_user) {
                    if($id_user != null){
                        $join->on("requerimiento_cantidato.requerimiento_id", "=", "requerimientos.id")
                        ->where("requerimiento_cantidato.candidato_id","=",$id_user->user_id)
                        ->whereIn("requerimiento_cantidato.estado_candidato", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_CONTRATADO'),
                            config('conf_aplicacion.C_CONTRATACION_CANCELADA'),
                            config('conf_aplicacion.C_EN_EXAMENES_MEDICOS'),
                        ]);
                    }else {
                        $join->on("requerimiento_cantidato.requerimiento_id", "=", "requerimientos.id")
                        ->where("requerimiento_cantidato.candidato_id", "=", $data->get("cedula"));
                    }
                })
                ->take(30)
                ->get();
            }else {
                $requerimientos=$requerimientos->take(30)->get();
            }

            $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $requerimientos->slice(($currentPage - 1) * 5, 5);
            $requerimientos = new \Illuminate\Pagination\LengthAwarePaginator($currentPageItems, count($requerimientos), 5,'', ['path'=>route("admin.reclutamiento")]);

            $clientes = ["" => "Seleccionar"] + Clientes::orderBy("clientes.nombre", "ASC")
            ->pluck("clientes.nombre", "clientes.id")
            ->toArray();

            $listaProcesos = ["" => "Seleccionar"] + TipoProceso::where('active', 1)->pluck('tipo_proceso.descripcion', 'tipo_proceso.id')
            ->toArray();

            $agencias = ["" => "Seleccionar"] + Agencia::pluck("agencias.descripcion","agencias.id")->toArray();

            return view("admin.reclutamiento.requerimiento-new", compact(
                "user_sesion",
                "requerimientos",
                "clientes",
                "usuarios",
                "listaProcesos",
                "agencias",
                "estados_requerimiento",
                "sitio"
            ));
        }else {
            $requerimientos = Requerimiento::join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->join('paises', 'requerimientos.pais_id', '=', 'paises.cod_pais')
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->join("users", "users.id", "=", "requerimientos.solicitado_por")
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->whereIn("clientes.id", $this->clientes_user)
            ->whereIn("estados_requerimiento.estado", $estados)
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where(function ($sql) use ($data, $id_user,$sitio) {
                if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }

                if ($data->has("cargo_id") && $data->get("cargo_id") != "") {
                    $sql->where("requerimientos.cargo_especifico_id", $data->get("cargo_id"));
                }

                if ($data->has("num_req") && $data->get("num_req") != "") {
                    $sql->where("requerimientos.id", $data->get("num_req"));
                }

                if($data->has("tipo_proceso_id") && $data->get("tipo_proceso_id") != ""){
                    $sql->where("tipo_proceso.id", $data->get("tipo_proceso_id"));
                }

                 if($sitio->agencias){
                    $sql->whereIn("ciudad.agencia", $this->user->agencias());
                }
            })
            ->select(
                'clientes.id as cliente_id',
                'negocio.nombre_negocio',
                'requerimientos.id',
                'ciudad.nombre as ciudad',
                "cargos_especificos.descripcion as cargo",
                "cargos_especificos.firma_digital as firma_cargo",
                "requerimientos.num_vacantes",
                "requerimientos.created_at", "requerimientos.fecha_ingreso", "requerimientos.dias_gestion","requerimientos.fecha_tentativa_cierre_req",
                DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and proceso in(\'CANCELA_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales'),
                DB::raw('requerimientos.num_vacantes - (select count(*) from firma_contratos where terminado in(1,2) and estado not in(0) and req_id=requerimientos.id ) as vacantes_reales_asistente'),
                "requerimientos.id",
                "tipo_proceso.descripcion as tipo_proceso_desc",
                "negocio.num_negocio",
                "clientes.nombre as nombre_cliente",
                "users.name as nombre_usuario",
                "requerimientos.id as req_id"
            )
            ->with("estados")
            ->groupBy(
                "requerimientos.id",
                "tipo_proceso.descripcion",
                "negocio.num_negocio",
                "clientes.nombre",
                "users.name",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_ingreso",
                "requerimientos.dias_gestion"
            )
            ->orderBy("requerimientos.id", "desc");
            //->take(30)->get();
            //->paginate(5);

            if($data->has("cedula") && $data->get("cedula") != "") {
                 $requerimientos=$requerimientos->join("requerimiento_cantidato",function($join) use($data,$id_user) {
                    if($id_user != null){
                        $join->on("requerimiento_cantidato.requerimiento_id", "=", "requerimientos.id")
                        ->where("requerimiento_cantidato.candidato_id", "=", $id_user->user_id)
                        ->whereIn("requerimiento_cantidato.estado_candidato", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_CONTRATADO'),
                            config('conf_aplicacion.C_CONTRATACION_CANCELADA'),
                            config('conf_aplicacion.C_EN_EXAMENES_MEDICOS'),
                        ]);
                    }else {
                        $join->on("requerimiento_cantidato.requerimiento_id", "=", "requerimientos.id")
                        ->where("requerimiento_cantidato.candidato_id", "=", $data->get("cedula"));
                    }
                })
                ->take(30)
                ->get();
            }else {
                $requerimientos = $requerimientos->take(30)->get();
            }

            $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $requerimientos->slice(($currentPage - 1) * 5, 5);
            $requerimientos = new \Illuminate\Pagination\LengthAwarePaginator($currentPageItems, count($requerimientos), 5,'', ['path'=>route("admin.reclutamiento")]);

            $clientes = ["" => "Seleccionar"] + Clientes::orderBy(DB::raw("UPPER(clientes.nombre)"), "ASC")
            ->pluck("clientes.nombre", "clientes.id")->toArray();

            $listaProcesos = \Cache::remember('listaProcesos','100', function(){
            return ["" => "Seleccionar"]+TipoProceso::
            where("active", 1)
            ->orderBy("tipo_proceso.descripcion", "ASC")->pluck('tipo_proceso.descripcion', 'tipo_proceso.id')
            ->toArray();
        });
           /*$listaProcesos = ["" => "Seleccionar"] + TipoProceso::where('active', 1)->orderBy("tipo_proceso.descripcion", "ASC")->pluck('tipo_proceso.descripcion', 'tipo_proceso.id')
            ->toArray();*/

            if($sitio->agencias){
                $agencias = ["" => "Seleccionar"] + Agencia::pluck("agencias.descripcion","agencias.id")->toArray();
            }
           
            return view("admin.reclutamiento.requerimiento-new", compact(
                "user_sesion",
                "requerimientos",
                "clientes",
                "usuarios",
                "listaProcesos",
                "estados_requerimiento","sitio",
                "agencias"
            ));
        }
    }

    public function getView()
    {
        $tablas   = DB::select('show tables');
        $tablasAP = ['tipos_vehiculos'];
        
        foreach($tablas as $key => $value){

           if(in_array($value->Tables_in_t3rs, $tablasAP)) {
                $tabla      = "$value->Tables_in_t3rs";
                $parseTabla = str_replace("_", " ", $tabla);
                $parseTabla = ucwords($parseTabla);
                $titulo     = ucwords($parseTabla);
                $parseTabla = str_replace(" ", "", $parseTabla);

                $tr = DB::select("DESC $tabla");

                $ruta_nuevo      = "admin.$tabla.nuevo";
                $ruta_guardar    = "admin.$tabla.guardar";
                $ruta_actualizar = "admin.$tabla.actualizar";
                $ruta_lista      = "admin.$tabla.index";
                $ruta_editar     = "admin.$tabla.editar";

                $html_campos     = "";
                $html_campos2    = "";
                $where           = "";
                $viewCampos      = file_get_contents("plantillas/campos.php");
                $viewCampos2     = file_get_contents("plantillas/campos2.php");
                $viewWhere       = file_get_contents("plantillas/where.php");
                $rules           = "";
                $rulesN          = "";
                $camposTabla     = "";
                $camposTabla2    = "";
                $numero_columnas = 0;
                foreach ($tr as $key => $value) {
                    if ($value->Field != "created_at" && $value->Field != "updated_at" && $value->Field != "id") {
                        $html_campos .= str_replace("{{name_campo}}", $value->Field, $viewCampos);
                        $html_campos2 .= str_replace("{{name_campo}}", $value->Field, $viewCampos2);
                        $where .= str_replace("{{campo}}", $value->Field, $viewWhere);

                        $rules .= "'$value->Field' => 'required',\n";
                        if ($value->Field != "id") {
                            $rulesN .= "'$value->Field' => 'required',\n";
                        }

                        $camposTabla .= "<th>" . $value->Field . "</th>";
                        $camposTabla2 .= '<td>{{$lista->' . $value->Field . '}}</td>';
                        $numero_columnas++;
                    }
                }

                mkdir("repo/$tabla", 0777, true);
                chmod("repo/$tabla", 0777);

                //VISTA LISTA
                $viewLista = file_get_contents("plantillas/index.blade.php");
                $viewLista = str_replace("{{route_index}}", $ruta_lista, $viewLista);
                $viewLista = str_replace("{{route_nuevo}}", $ruta_nuevo, $viewLista);
                $viewLista = str_replace("{{ruta_editar}}", $ruta_editar, $viewLista);
                $viewLista = str_replace("{{numero_columnas}}", $numero_columnas, $viewLista);
                $viewLista = str_replace("{{campos_tabla}}", $camposTabla, $viewLista);
                $viewLista = str_replace("{{titulo}}", $titulo, $viewLista);
                $viewLista = str_replace("{{campos_tabla2}}", $camposTabla2, $viewLista);

                $viewLista = str_replace("{{campos}}", $html_campos2, $viewLista);
                $myfile1   = fopen("repo/$tabla/index.blade.php", "a") or die("Unable to open file!");
                chmod("repo/$tabla/index.blade.php", 0777);
                fwrite($myfile1, $viewLista);
                //VISTA CREAR
                $viewNuevo = file_get_contents("plantillas/nuevo.blade.php");
                $viewNuevo = str_replace("{{campos}}", $html_campos2, $viewNuevo);
                $viewNuevo = str_replace("{{nom_tabla}}", "fr_$tabla", $viewNuevo);
                $viewNuevo = str_replace("{{ruta_guardar}}", "$ruta_guardar", $viewNuevo);
                $viewNuevo = str_replace("{{titulo}}", "$titulo", $viewNuevo);
                $myfile2   = fopen("repo/$tabla/nuevo.blade.php", "a") or die("Unable to open file!");
                chmod("repo/$tabla/nuevo.blade.php", 0777);
                fwrite($myfile2, $viewNuevo);
                //VISTA EDITAR
                $viewEditar = file_get_contents("plantillas/editar.blade.php");
                $viewEditar = str_replace("{{campos}}", $html_campos2, $viewEditar);
                $viewEditar = str_replace("{{nom_tabla}}", "fr_$tabla", $viewEditar);
                $viewEditar = str_replace("{{titulo}}", $titulo, $viewEditar);
                $viewEditar = str_replace("{{ruta_actualizar}}", "$ruta_actualizar", $viewEditar);
                $myfile3    = fopen("repo/$tabla/editar.blade.php", "a") or die("Unable to open file!");
                chmod("repo/$tabla/editar.blade.php", 0777);
                fwrite($myfile3, $viewEditar);
                //CONTROLLER
                $viewController = file_get_contents("plantillas/controller.php");
                $viewController = str_replace("{{nombre_controller}}", $parseTabla, $viewController);
                $viewController = str_replace("{{tabla}}", $tabla, $viewController);
                $viewController = str_replace("{{where}}", $where, $viewController);
                $viewController = str_replace("{{requet_nuevo}}", $parseTabla . "Nuevo", $viewController);
                $viewController = str_replace("{{requet_editar}}", $parseTabla . "Editar", $viewController);

                $myfile4 = fopen("controller/" . $parseTabla . "Controller.php", "a") or die("Unable to open file!");
                chmod("controller/" . $parseTabla . "Controller.php", 0777);
                fwrite($myfile4, $viewController);

                //Request nuevo
                $viewController = file_get_contents("plantillas/request_nuevo.php");
                $viewController = str_replace("{{nombre_request}}", $parseTabla . "Nuevo", $viewController);
                $viewController = str_replace("{{reglas}}", $rulesN, $viewController);

                $myfile4 = fopen("request/" . $parseTabla . "NuevoRequest.php", "a") or die("Unable to open file!");
                chmod("request/" . $parseTabla . "NuevoRequest.php", 0777);
                fwrite($myfile4, $viewController);

                //Request nuevo
                $viewController = file_get_contents("plantillas/request_nuevo.php");
                $viewController = str_replace("{{nombre_request}}", $parseTabla . "Editar", $viewController);
                $viewController = str_replace("{{reglas}}", $rules, $viewController);

                $myfile4 = fopen("request/" . $parseTabla . "EditarRequest.php", "a") or die("Unable to open file!");
                chmod("request/" . $parseTabla . "EditarRequest.php", 0777);
                fwrite($myfile4, $viewController);

                //GENERANDO RUTAS
                $rutas = fopen("plantillas/routes.php", "a");

                fwrite($rutas, '// RUTAS TABLA ' . $titulo . PHP_EOL);
                fwrite($rutas, ' Route::get("lista_' . $tabla . '",["as"=>"admin.' . $tabla . '.index","uses"=>"' . $parseTabla . 'Controller@index"]);' . PHP_EOL);
                fwrite($rutas, 'Route::get("editar_' . $tabla . '/{id}",["as"=>"admin.' . $tabla . '.editar","uses"=>"' . $parseTabla . 'Controller@editar"]);' . PHP_EOL);
                fwrite($rutas, 'Route::get("nuevo_' . $tabla . '",["as"=>"admin.' . $tabla . '.nuevo","uses"=>"' . $parseTabla . 'Controller@nuevo"]);' . PHP_EOL);
                fwrite($rutas, 'Route::post("actualizar_' . $tabla . '",["as"=>"admin.' . $tabla . '.actualizar","uses"=>"' . $parseTabla . 'Controller@actualizar"]);' . PHP_EOL);
                fwrite($rutas, 'Route::post("guardar_' . $tabla . '",["as"=>"admin.' . $tabla . '.guardar","uses"=>"' . $parseTabla . 'Controller@guardar"]);' . PHP_EOL);

                $menu_lista = new Menu();
                $menu_lista->fill([
                    "modulo"      => "admin",
                    "tipo"        => "view",
                    "padre_id"    => "24",
                    "boton"       => "1",
                    "tipo_boton"  => "submit",
                    "nombre_menu" => " $titulo",
                    "descripcion" => " $titulo",
                    "submenu"     => "1",
                    "slug"        => "admin.$tabla.index",
                    "icono"       => '<i class="fa fa-tasks  fa-2x"></i><br>',
                ]);
                $menu_lista->save();

                $menu_nuevo = new Menu();
                $menu_nuevo->fill([
                    "modulo"      => "admin",
                    "tipo"        => "view",
                    "padre_id"    => $menu_lista->id,
                    "boton"       => "1",
                    "tipo_boton"  => "submit",
                    "nombre_menu" => "Nuevo $titulo",
                    "descripcion" => "Nuevo $titulo",
                    "submenu"     => "0",
                    "slug"        => "admin.$tabla.nuevo",
                    "icono"       => '<i class="fa fa-tasks  fa-2x"></i><br>',
                ]);
                $menu_nuevo->save();
                $menu_nuevo_save = new Menu();
                $menu_nuevo_save->fill([
                    "modulo"      => "admin",
                    "tipo"        => "proceso",
                    "padre_id"    => $menu_nuevo->id,
                    "boton"       => "1",
                    "tipo_boton"  => "submit",
                    "nombre_menu" => "Guardar $titulo",
                    "descripcion" => "Guardar $titulo",
                    "submenu"     => "0",
                    "slug"        => "admin.$tabla.guardar",
                    "icono"       => '<i class="fa fa-tasks  fa-2x"></i><br>',
                ]);
                $menu_nuevo_save->save();

                $menu_nuevo_edit = new Menu();
                $menu_nuevo_edit->fill([
                    "modulo"      => "admin",
                    "tipo"        => "view",
                    "padre_id"    => $menu_lista->id,
                    "boton"       => "1",
                    "tipo_boton"  => "submit",
                    "nombre_menu" => "Editar $titulo",
                    "descripcion" => "Editar $titulo",
                    "submenu"     => "0",
                    "slug"        => "admin.$tabla.editar",
                    "icono"       => '<i class="fa fa-tasks  fa-2x"></i><br>',
                ]);
                $menu_nuevo_edit->save();

                $menu_nuevo = new Menu();
                $menu_nuevo->fill([
                    "modulo"      => "admin",
                    "tipo"        => "proceso",
                    "padre_id"    => $menu_nuevo_edit->id,
                    "boton"       => "1",
                    "tipo_boton"  => "submit",
                    "nombre_menu" => "Actualizar $titulo",
                    "descripcion" => "Actualizar $titulo",
                    "submenu"     => "0",
                    "slug"        => "admin.$tabla.actualizar",
                    "icono"       => '<i class="fa fa-tasks  fa-2x"></i><br>',
                ]);
                $menu_nuevo->save();
            }
        }

        //
        //
        dd($rutas);
    }

    public function permiso_negado()
    {
        return view("admin.permiso_negado");
    }

    public function logout()
    {
        Sentinel::logout();
        return redirect()->route("admin.login");
    }

    public function crear_user_clientes_masivo()
    {

        $clientes = [
            72153546  => 'regionalfd@yahoo.com',
            800033135 => 'nomina@coloroffset.com.co',
            900135931 => 'crpatiosdelaflora@gmail.com',
            860055794 => 'cecilia.lopez@alfa.com.co',
            860007336 => 'victor.ramos@colsubsio.com',
            830050619 => 'gerenciagestionhumana@city-parking.com',
            800163260 => 'ghumana@colchonesfantasia.com',
            800034353 => 'administracion@projabones.com.co',
            900859827 => 'sweetmama@hotmail.es',
            890917032 => 'janettm@tenimos.com.co',
            890404029 => 'rh.herreraduranltda@hotmail.com',
            890406707 => 'erangel.galosmotos@fanalca11.fanalca.com.co',
        ];

        foreach ($clientes as $key => $value) {
            //GUARDAR CLIENTE
            $nuevo_cliente = Clientes::where("nit", $key)->first();
            //GUARDAR USUARIO
            $campos_usuario["password"] = "soluciones2016*";
            $campos_usuario["name"]     = $nuevo_cliente->nombre;
            $campos_usuario["email"]    = $value;
            $campos_usuario["estado"]   = 1;
            $usuario                    = Sentinel::registerAndActivate($campos_usuario);
            $usuario->save();

            //AGREGANDO USUARIO AL CLIENTE

            $cliente             = new UserClientes();
            $cliente->user_id    = $usuario->id;
            $cliente->cliente_id = $nuevo_cliente->id;
            $cliente->save();

            //AGREGA ROL REQ PARA INGRESAR AL MODULO DE REQUERMIENTO

            $rol = Sentinel::findRoleBySlug('req');
            $rol->users()->attach($usuario);
            $menuArray = [
                "req.usuarios"                        => false,
                "req.nuevo_user"                      => false,
                "req.guardar_user"                    => false,
                "req.editar_user"                     => false,
                "req.actualizar_usuario"              => false,
                "req.requerimiento"                   => true,
                "req.consultar_negocio"               => true,
                "req.mis_requerimiento"               => true,
                "req.reporte_contratados_cliente"     => true,
                "req.nuevo_requerimiento"             => true,
                "req.guardar_requerimiento"           => true,
                "req.candidatos_aprobar_cliente_view" => true,
                "req.reporte"                         => true,
                "req.mostrar_clientes"                => true,
                "req.datos.empresa"                   => true,
                "req.actualizar_datos"                => true,
            ];

            $usuario->permissions = $menuArray;
            $usuario->save();
        }
    }

    public function autocompletar_cargo_generico(Request $data)
    {
        $campo          = $data->get("query");
        $cargo_generico = \App\Models\CargoGenerico::where("descripcion", "like", "%" . $campo . "%")
            ->select("descripcion as value", "id")->take(5)->get()->toArray();

        return response()->json(["suggestions" => $cargo_generico]);
    }

    public function consulta()
    {
        $campo = DatosBasicos::join('experiencias', function ($join) {
            $join->on("experiencias.user_id", "=", "datos_basicos.user_id");
            })
         #join('experiencias', function ($join) {
          #  $join->on("experiencias.user_id", "=", "datos_basicos.user_id");
           # })
            ->join("paises","paises.cod_pais","=","datos_basicos.pais_residencia")
            ->join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->where('datos_basicos.datos_basicos_count',100)
            ->whereNotNull('datos_basicos.descrip_profesional')
            ->select('datos_basicos.numero_id',DB::raw("CONCAT(datos_basicos.descrip_profesional,CONCAT_WS(' ',paises.nombre,departamentos.nombre,ciudad.nombre)) AS texto"),DB::raw("CONCAT('experiencias.cargo_desempenado','experiencias.funciones_logros') AS experiencias"))
            #->select('datos_basicos.numero_id',DB::raw("CONCAT(datos_basicos.descrip_profesional,CONCAT(experiencias.funciones_logros,experiencias.cargo_especifico),CONCAT_WS(' ',paises.nombre,departamentos.nombre,ciudad.nombre)) AS texto"))
           // ->select('datos_basicos.numero_id',DB::raw("CONCAT(datos_basicos.descrip_profesional,experiencias.funciones_logros,experiencias.cargo_especifico,' ',paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS texto"))
            ->groupBy('datos_basicos.numero_id')
            ->get();

      #  select `datos_basicos`.`numero_id`, CONCAT(`datos_basicos`.`descrip_profesional`, `experiencias`.`funciones_logros`, `experiencias`.`cargo_especifico`) from `datos_basicos` inner join `experiencias` on `experiencias`.`user_id` = `datos_basicos`.`user_id` WHERE `datos_basicos`.`datos_basicos_count` = 100 and `datos_basicos`.`descrip_profesional` IS NOT null GROUP BY `datos_basicos`.`numero_id` LIMIT 50

        return view('consulta',compact('campo'));
    }

    public function indicadoresAdmin()
    {
           /*INDICADORES NORMALES*/

        $requerimientos_abiertos= Requerimiento::
            join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->join('tipos_contratos', 'requerimientos.tipo_contrato_id', '=', 'tipos_contratos.id')
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
            ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
            ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
            ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
        //->where("users.id", $this->user->id)
            ->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[date("Y-m-d",strtotime(date("Y-m-d")."- 1 month")),date("Y-m-d")])
            ->whereIn('estados_requerimiento.estado',
                [ config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),])
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->select("num_vacantes","requerimientos.fecha_ingreso as fecha_ingreso",DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as numero_vac '),DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as numero_vac '))->get()
        ;
        //dd($requerimientos_abiertos);
        $num_req_a = $requerimientos_abiertos->count();

        $fecha_hoy = Carbon::now();
        $fecha_hoy = $fecha_hoy->format('Y-m-d');
        
        $numero_vacantes= $requerimientos_abiertos->sum("num_vacantes");
        
        $num_can_con = $requerimientos_abiertos->sum("cant_enviados_contratacion");
        
        $numero_vac= $requerimientos_abiertos->filter(function ($value) use($fecha_hoy){
                return $value->fecha_ingreso < $fecha_hoy;
            })->sum("numero_vac");

        //guardar datos en la tabla::
        $indicadores = new Indicadores();
        $indicadores->fecha = date('Y-m-d');
        $indicadores->cliente = 0;
        $indicadores->requerimientos_abiertos = $num_req_a;
        $indicadores->vacantes_solicitadas = $numero_vacantes;
        $indicadores->vacantes_vencidas = $numero_vac;
        $indicadores->candidatos_contratar = $num_can_con;
        $indicadores->save(); //guardado de indicadores
        //para el grafico
        //return 'cambios';
    }

    public function periodo_prueba()
    {
      
      /*$requerimientos = Requerimiento::join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
          //->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
          ->where('estados_requerimiento.estado',16)
          ->select("requerimientos.id as requerimiento_id")
          ->groupBy('estados_requerimiento.req_id')->orderBy('estados_requerimiento.estado')->get();//consulta de los requerimientos que ya fueron cerrados por q contrataron*/

        $requerimiento = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            ->join("solicitudes", "solicitudes.id", "=", "requerimientos.solicitud_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
           ->where('estados_requerimiento.estado',16)
           ->where("requerimiento_cantidato.estado_candidato", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'))
           ->select("datos_basicos.*","solicitudes.email_jefe_inmediato as email_jefe","requerimiento_cantidato.requerimiento_id")->get();
        //tomar fecha de inicio contrato
        //consulta de candidatos que fueron contratadoos
        //dd($requerimiento);

        foreach ($requerimiento as $value) {

         $proceso = RegistroProceso::where('candidato_id',$value->user_id)
                  ->where('requerimiento_id',$value->requerimiento_id)
                  ->where('proceso','ENVIO_CONTRATACION')
                  ->first();

         if(!is_null($proceso)){

          $fecha_inicio = $proceso->fecha_inicio_contrato;
          $fecha_inicio = date('Y-m-d',strtotime($fecha_inicio));

          $g= Carbon::parse($fecha_inicio)->diffInWeeks(Carbon::now());

          if($g == 6){

            Mail::send('admin.email_periodo_prueba', [
                 'candidato'=>$value->nombres.' '.$value->primer_apellido.' '.$value->segundo_apellido,
                 'candidato_id'=>$value->numero_id,
                 'req' => $value->requerimiento_id
                ], function ($m) use($value) {
                    $m->subject('Formato Evaluacion Periodo Prueba');
                    $m->to([$value->email_jefe,'jorge.ortiz@t3rsc.co','javier.chiquito@t3rsc.co'],'komatsu-T3RS');
                    $m->attach(public_path('FORMATO_PERIODO_DE_PRUEBA.xlsx'));
                    $m->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
          }//fin de envio mail al cumplir el mes y medio
        }
       }

    }

    public function backups(){
        return view('admin.backups');
    }

}