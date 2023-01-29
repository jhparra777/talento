<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\CargoEspecifico;
use App\Models\EstadosRequerimientos;
use App\Models\MotivoRequerimiento;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Sitio;
use App\Models\TipoFuentes;
use App\Models\TipoDocumento;
use App\Models\Documentos;
use App\Models\FirmaContratos;

use Maatwebsite\Excel\Facades\Excel;
use \DB;
use Carbon\Carbon;
use App\Models\Requerimiento;
use App\Models\ReqCandidato;
use App\Models\RegistroProceso;
use App\Models\User;
use App\Models\Experiencias;
use App\Models\AspiracionSalarial;
use App\Models\TipoProceso;
use App\Models\Estados;
use App\Models\Ciudad;
use App\Models\DatosBasicos;
use App\Models\Estudios;
use App\Models\Genero;
use App\Models\LlamadaMensaje;
use App\Models\EntrevistaCandidatos;
use App\Models\Perfilamiento;
use App\Models\CargoGenerico;
use Validator;
use App\Models\SolicitudAreaFuncional;
use App\Models\ReferenciasPersonales;
use App\Jobs\FuncionesGlobales;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use \Cache;
use DateTime;
use DateInterval;
use App\Models\Agencia;
use App\Models\MotivoEstadoRequerimiento;
use App\Models\OrdenMedica;
use App\Models\ExamenMedico;
use App\Models\MetodoCarga;
use Illuminate\Support\Facades\Mail;
//Helper
use triPostmaster;

class ReportesController extends Controller
{
    protected $estados_no_muestra = [];
    
    public function __construct()
    {
        $this->estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
        ]; //SON LOS ESTADOS PARA NO MOSTRAR EL CANDIDATO EN EL  REQUERIMIENTO

        parent::__construct();
    }

    protected function sinClientesPruebas(&$ids_clientes_prueba) {
        $sitio = Sitio::first();
        if ($sitio->filtro_cliente == 'enabled' && $sitio->clientes_prueba_id != null && $sitio->clientes_prueba_id != '') {
            $ids_clientes_prueba = explode(",", $sitio->clientes_prueba_id);
            return true;
        }
        return false;
    }

    public function indicador_cancelados(Request $request){

      $user_sesion = $this->user;
      
      if(isset($request->proceso_id)){

        if(route("home")=="https://gpc.t3rsc.co"){
             $usuarios_gestionan=["" => "- Seleccionar -"]+User::pluck("users.name", "users.id")->toArray();

              $tipo_solicitud =  ["" => "Seleccionar"] + TipoProceso::pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();

            }
            else{
                $usuarios_gestionan = ["" => "Seleccionar"] + User::join('estados_requerimiento','estados_requerimiento.user_gestion','=','users.id')
            ->pluck("users.name", "users.id")->toArray();


            $tipo_solicitud =  ["" => "Seleccionar"] + TipoProceso::join('requerimientos','requerimientos.tipo_proceso_id','=','tipo_proceso.id')
            ->pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();

            }

       
         

            
            $reporte_candelados = DB::table('requerimientos')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            
            ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
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
            ->where(function ($where) use ($request) {

                  //dd($request->get('cliente_id'));
                if ( $request->get('proceso_id') != "") {
                    $where->where("requerimientos.tipo_proceso_id",$request->get('proceso_id'));
                }
                    
                if ($request->get('user_id') != "") {

                     $where->whereRaw('
                    (select p.id  
                    from role_users o 
                    left join users p on o.user_id=p.id 
                    left join users_x_clientes ux on p.id=ux.user_id
                    left join clientes cli on ux.cliente_id=cli.id
                    left join negocio neg on cli.id=neg.cliente_id
                    left join requerimientos req on neg.id=req.negocio_id

                    where req.id=requerimientos.id and
                    o.role_id = 17  
                    order by o.created_at desc limit 1)= '.$request->get("user_id"));
                }
                     
                  
                if ($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                }

                 if ($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$request->get('fecha_tenta_ini'),$request->get('fecha_tenta_fin')]);
                    }
                 })
            
            ->select(
                'requerimientos.id',
                    DB::raw('(select sum(requerimientos.num_vacantes) as cantidad from requerimientos where requerimientos_estados.max_estado = 2 and requerimientos_estados.req_id=requerimientos.id ) as cant_cancelados_temporizar'),
                     DB::raw('(select sum(requerimientos.num_vacantes) as cantidad from requerimientos where requerimientos_estados.max_estado = 1 and requerimientos_estados.req_id=requerimientos.id ) as cant_cancelados_cliente'),
                     //***************************** req3 ******
                      DB::raw('(select sum(requerimientos.num_vacantes) as cantidad from requerimientos where requerimientos_estados.max_estado = 22 and requerimientos_estados.req_id=requerimientos.id ) as cant_cancelados_no_efectiva') 
                )
            ->groupBy('requerimientos.id')
            ->get();

          $cancelados = [];

             $numero_cancelados_cliente = 0;
             $numero_cancelados_temporizar = 0;
             $numero_cancelados_no_efectiva = 0;
             $numero_req = count($reporte_candelados);
             
                           
            foreach ($reporte_candelados  as $key => $cance) {  
              $numero_cancelados_cliente +=(int)$cance->cant_cancelados_cliente;
              $numero_cancelados_temporizar +=(int)$cance->cant_cancelados_temporizar;
              $numero_cancelados_no_efectiva +=(int)$cance->cant_cancelados_no_efectiva;
            }
           
           if ($numero_req ==0) {
               $numero_req = 1;
           }
          $avg_cancelados_cliente  =    round(($numero_cancelados_cliente/$numero_req)*100);
          $avg_cancelados_temporizar  = round(($numero_cancelados_temporizar/$numero_req)*100);
          $avg_cancelados_no_efectiva  = round(($numero_cancelados_no_efectiva/$numero_req)*100);

          //dd($avg_cancelados_no_efectiva);
        $avg_restante = 100-($avg_cancelados_cliente+$avg_cancelados_temporizar+$avg_cancelados_no_efectiva);

          $cancelados=[
            "avg_cancelados_cliente"=>$avg_cancelados_cliente,
            "avg_cancelados_temporizar"=>$avg_cancelados_temporizar,
            "avg_cancelados_no_efectiva"=>$avg_cancelados_no_efectiva,
            "numero_cancelados_cliente"=>$numero_cancelados_cliente,
            "numero_cancelados_temporizar"=>$numero_cancelados_temporizar,
            "numero_cancelados_no_efectiva"=>$numero_cancelados_no_efectiva,
            "otros_estados"=>$numero_req
        ];

        // Reporte cancelados
        $report_cance = 'reporte_cancelaciones';
        $indi5 = \Lava::DataTable();
        $indi5->addStringColumn('Cancelados')
                ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
        $indi5->addRow(["Cancelados por el cliente", (int)$avg_cancelados_cliente]);
        $indi5->addRow(["Cancelados por temporizar", (int)$avg_cancelados_temporizar]);
        $indi5->addRow(["Cancelados no efectivas", (int)$avg_cancelados_no_efectiva]);
        \Lava::PieChart($report_cance, $indi5, [
            'title' => 'Indicadores Requerimientos Cancelados',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 60,
                'width' => '110%'
            ],
            'width' => '500',
            'height' => '300'
        ]);

        return view("admin.reportes.indicadores_cancelados")->with([
                    'report_cance' => $report_cance,
                    'tipo_solicitud' =>    $tipo_solicitud,
                    'usuarios_gestionan' => $usuarios_gestionan,
                    'tipo_chart'  => 'PieChart',
                    'cancelados'   => $cancelados ]);
    }
    else{
        if(route("home")=="https://gpc.t3rsc.co"){
             $usuarios_gestionan=["" => "- Seleccionar -"]+User::pluck("users.name", "users.id")->toArray();

              $tipo_solicitud =  ["" => "Seleccionar"] + TipoProceso::pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();

            }
            else{
                $usuarios_gestionan = ["" => "Seleccionar"] + User::join('estados_requerimiento','estados_requerimiento.user_gestion','=','users.id')
            ->pluck("users.name", "users.id")->toArray();

                
            $tipo_solicitud =  ["" => "Seleccionar"] + TipoProceso::join('requerimientos','requerimientos.tipo_proceso_id','=','tipo_proceso.id')
            ->pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();

            }
        return view("admin.reportes.indicadores_cancelados")->with([
                   
                    'tipo_solicitud' =>    $tipo_solicitud,
                    'usuarios_gestionan' => $usuarios_gestionan,
                    
                    
        ]);

    }

    }


    public function indicador_eficacia_llamada(Request $request){

      $user_sesion = $this->user;
      if(isset($request->proceso_id)){

             if(route("home")=="https://gpc.t3rsc.co"){
             $usuarios_gestionan=["" => "Seleccionar"] + User::join('estados_requerimiento','estados_requerimiento.user_gestion','=','users.id')
            ->pluck("users.name", "users.id")->toArray();

              $tipo_solicitud =  ["" => "Seleccionar"] + TipoProceso::where("active",1)
              ->pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();

            }
            else{
               $usuarios_gestionan = ["" => "Seleccionar"] + User::
             whereIn("id",[33700,33707,33695,33698,34126])
            ->pluck("users.name", "users.id")->toArray();

                
            $tipo_solicitud =  ["" => "Seleccionar"] + TipoProceso::join('requerimientos','requerimientos.tipo_proceso_id','=','tipo_proceso.id')
            ->pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();

            }


         

            
    

            $eficacia = DB::table('requerimientos')
            ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
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
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            //->whereRaw('requerimientos.id not in (select req_id  from requerimientos_estados where max_estado in (2,1,16)) ')
            ->where(function ($where) use ($request) {

                  //dd($request->get('cliente_id'));
               if ( $request->get('proceso_id') != "") {
                    $where->where("requerimientos.tipo_proceso_id",$request->get('proceso_id'));
                }

                if ( $request->get('user_id') != "") {
                    $where->where("estados_requerimiento.user_gestion",$request->get('user_id'));
                }
                     
                  
                if ($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                }

                 if ($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$request->get('fecha_tenta_ini'),$request->get('fecha_tenta_fin')]);
                    }
                 })
            //->where('estados_requerimiento.user_gestion',$user_sesion->id)
            
            ->select(
                'requerimientos.id',
                DB::raw('(select count(c.id) as cantidad from carga_scanner c 
                    left join datos_basicos r on c.user_carga=r.user_id
                    left join requerimiento_cantidato re on r.user_id=re.candidato_id
                    where    
                    re.requerimiento_id=requerimientos.id and re.estado_candidato <> 14  ) as cant_asistieron'),
                 
                 DB::raw('(select count(*) as cantidad from procesos_candidato_req rec 
                            inner join requerimientos req on rec.requerimiento_id=req.id
                            inner join negocio n on req.negocio_id=n.id
                            inner join clientes cli on n.cliente_id=cli.id 
                            where rec.requerimiento_id = requerimientos.id
                            and 
                            proceso in("ENVIO_APROBAR_CLIENTE","ENVIO_CONTRATACION") 

                             and
                             rec.estado in(8,11)
                             and cli.id in (129,140)
                             )as cantidad_mon'),
                   
                    DB::raw('(select count(*) as cantidad from requerimiento_cantidato where requerimiento_id=requerimientos.id) as cant_reclu'))
            ->groupBy('requerimientos.id')
            ->get();
            //dd($eficacia);
      $eficacia_llamada = [];

             $numero_asistieron = 0;
             $numero_reclu = 0;
                           
                  foreach ($eficacia  as $key => $efi) {
                    
                    $numero_asistieron +=(int)$efi->cant_asistieron;
                    $numero_asistieron +=(int)$efi->cantidad_mon;
                    $numero_reclu +=(int)$efi->cant_reclu;
                 }

              if($numero_reclu <= 0){
            $numero_reclu = 1;
        }
          
          $avg_eficacia  = round((($numero_asistieron/$numero_reclu))*100); 
          //dd($avg_eficacia);
          $avg_eficacia_no = 100-$avg_eficacia;
          $eficacia1=[
            "total_asistieron"=>$numero_asistieron,
            "total_reclu"=>$numero_reclu,
            "avg_eficacia"=>$avg_eficacia
            
        ];

        // Reporte eficacia
        $report_efi = 'reporte_eficacia';
        $indi5 = \Lava::DataTable();
        $indi5->addStringColumn('Eficacia')
                ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
        $indi5->addRow(["Eficacia", (int)$avg_eficacia]);
        $indi5->addRow(["Ineficacia", (int)($avg_eficacia_no)]);
        \Lava::PieChart($report_efi, $indi5, [
            'title' => 'Indicadores Eficacia Llamadas',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '100%'
            ],
            'height' => '350'
        ]);

        return view("admin.reportes.indicadores_eficacia_llamada")->with([
                    'report_efi' => $report_efi,
                    'tipo_solicitud' =>    $tipo_solicitud,
                    'usuarios_gestionan' => $usuarios_gestionan,
                    'tipo_chart'  => 'PieChart',
                    'eficacia1'   => $eficacia1,
                    
        ]);
    }
    else{

           if(route("home")=="https://gpc.t3rsc.co"){
              $usuarios_gestionan=["" => "Seleccionar"] + User::join('estados_requerimiento','estados_requerimiento.user_gestion','=','users.id')
            ->pluck("users.name", "users.id")->toArray();

              $tipo_solicitud =  ["" => "Seleccionar"] + TipoProceso::where("active",1)
              ->pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();
            }
            else{
               $usuarios_gestionan = ["" => "Seleccionar"] + User::
             whereIn("id",[33700,33707,33695,33698,34126])
            ->pluck("users.name", "users.id")->toArray();

                
            $tipo_solicitud =  ["" => "Seleccionar"] + TipoProceso::join('requerimientos','requerimientos.tipo_proceso_id','=','tipo_proceso.id')
            ->pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();

            }
            
         return view("admin.reportes.indicadores_eficacia_llamada")->with([
                   
                    'tipo_solicitud' =>    $tipo_solicitud,
                    'usuarios_gestionan' => $usuarios_gestionan,
                   
                    
        ]);
    }

    }

    public function indicador_eficacia_reclu(Request $request){

      $user_sesion = $this->user;


         if(route("home")=="https://gpc.t3rsc.co"){
             $usuarios_gestionan=["" => "Seleccionar"] + User::join('estados_requerimiento','estados_requerimiento.user_gestion','=','users.id')
            ->pluck("users.name", "users.id")->toArray();


              $tipo_solicitud =  ["" => "Seleccionar"] + TipoProceso::where("active",1)
              ->pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();

            }
            else{
               $usuarios_gestionan = ["" => "Seleccionar"] + User::
             whereIn("id",[33700,33707,33695,33698,34126])
            ->pluck("users.name", "users.id")->toArray();

                
            $tipo_solicitud =  ["" => "Seleccionar"] + TipoProceso::join('requerimientos','requerimientos.tipo_proceso_id','=','tipo_proceso.id')
            ->pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();

            }



          

           

            $eficacia = DB::table('requerimientos')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
           ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
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
            ->where(function ($where) use ($request) {

                  //dd($request->get('cliente_id'));
               if($request->get('proceso_id') != "") {
                    $where->where("requerimientos.tipo_proceso_id",$request->get('proceso_id'));
                }

                if($request->get('user_id') != "") {
                    $where->where("estados_requerimiento.user_gestion",$request->get('user_id'));
                }
                     
                  
                if($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                }

                if ($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$request->get('fecha_tenta_ini'),$request->get('fecha_tenta_fin')]);
                    }
                 })
            //->where('estados_requerimiento.user_gestion',$user_sesion->id)
            
            ->select(
                'requerimientos.id',
                DB::raw('(select count(*) as cantidad from procesos_candidato_req where  requerimiento_id=requerimientos.id  and  proceso in(\'ENVIO_ENTREVISTA\')) as cant_asistieron'),
                    DB::raw('(select count(*) as cantidad from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA\') and requerimiento_id=requerimientos.id and apto = 1) as cant_entre_aptos'))
            ->groupBy('requerimientos.id')
            ->get();
            //dd($eficacia);
            $eficacia_reclu = [];

             $numero_asistieron = 0;
             $numero_aptos = 0;
                           
             foreach ($eficacia  as $key => $efi) {
               
               $numero_asistieron +=(int)$efi->cant_asistieron;
               $numero_aptos +=(int)$efi->cant_entre_aptos;
             }

            if($numero_asistieron <= 0){
             $numero_asistieron = 1;
            }
          
          $avg_eficacia  = round((($numero_aptos/$numero_asistieron))*100); 
         // dd($avg_eficacia);
          $avg_eficacia_no = 100-$avg_eficacia;
          $eficacia1=[
            "total_asistieron"=>$numero_asistieron,
            "total_aptos"=>$numero_aptos,
            "avg_eficacia"=>$avg_eficacia
            
        ];

        // Reporte eficacia
        $report_efi = 'reporte_eficacia';
        $indi5 = \Lava::DataTable();
        $indi5->addStringColumn('Eficacia')
                ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
        $indi5->addRow(["Eficacia", (int)$avg_eficacia]);
        $indi5->addRow(["Ineficacia", (int)($avg_eficacia_no)]);
        \Lava::PieChart($report_efi, $indi5, [
            'title' => 'Indicadores Eficacia Reclutadores',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '100%'
            ],
            'height' => '350'
        ]);

        return view("admin.reportes.indicadores_eficacia_reclu")->with([
                    'report_efi' => $report_efi,
                    'tipo_solicitud' =>    $tipo_solicitud,
                    'usuarios_gestionan' => $usuarios_gestionan,
                    'tipo_chart'  => 'PieChart',
                    'eficacia1'   => $eficacia1,
                    
        ]);

    }

    public function indicador_tiempos(Request $request){

      $user_sesion = $this->user;


            if(route("home")=="https://gpc.t3rsc.co"){
             $usuarios_gestionan=["" => "- Seleccionar -"]+User::pluck("users.name", "users.id")->toArray();
             $tipo_solicitud =  ["" => "Seleccionar"] + TipoProceso::pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();

            }
            else{
                $usuarios_gestionan = ["" => "Seleccionar"] + User::
             whereIn("id",[33695,33698,34126])
            ->pluck("users.name", "users.id")->toArray();
            $tipo_solicitud =  ["" => "Seleccionar"] + TipoProceso::join('requerimientos','requerimientos.tipo_proceso_id','=','tipo_proceso.id')
            ->pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();

            }






          

           


            $eficacia = DB::table('procesos_candidato_req')
            ->join('users','users.id','=','procesos_candidato_req.candidato_id')
            ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
            ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            /*->whereRaw('requerimientos.id not in (select req_id  from estados_requerimiento where estado in (2,1,16)) ')*/
            //->whereRaw('procesos_candidato_req.candidato_id not in (select candidato_id  from requerimiento_cantidato where estado_candidato = 14 and requerimiento_id = procesos_candidato_req.requerimiento_id) ')

            ->where('procesos_candidato_req.proceso','ENVIO_APROBAR_CLIENTE')
            ->where(function ($where) use ($request) {

                  //dd($request->get('cliente_id'));
               if ( $request->get('proceso_id') != "") {
                    $where->where("requerimientos.tipo_proceso_id",$request->get('proceso_id'));
                }

                if ( $request->get('user_id') != "") {
                    $where->where("procesos_candidato_req.usuario_envio",$request->get('user_id'));
                }
                     
                  
                if ($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                }

                 if ($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$request->get('fecha_tenta_ini'),$request->get('fecha_tenta_fin')]);
                    }
                 })
            //->where('estados_requerimiento.user_gestion',$user_sesion->id)
            
            ->select(
                'requerimientos.id',
                'requerimientos.tipo_contrato_id as contrato',
                'procesos_candidato_req.candidato_id',
                'requerimientos.centro_costo_produccion as numero_req',
                DB::raw('(DATE_FORMAT(procesos_candidato_req.fecha_inicio, \'%Y-%m-%d\')) as fecha_respuesta'),
                
               DB::raw('(DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')) as fecha_creacion'),
               DB::raw('(DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')) as fecha_tentativa'),
               DB::raw('(select (datediff(fecha_respuesta,fecha_creacion)))as diferencia'),
                DB::raw('(select (datediff(fecha_respuesta,fecha_tentativa)))as diferencia_demora'))
            //->whereRaw('estados_requerimiento = '.$request->get("mes_creacion"));
            //->havingRaw('(select (datediff(fecha_respuesta,fecha_creacion))) > 0')
            ->groupBy('procesos_candidato_req.candidato_id')
            ->get();

            
      $eficacia1 = [];

             $numero_diferencia = 0;
             $numero_diferencia_demora = 0;
             $numero_diferencia_oportuno = 0;
             $numero_reclu = 0;
             $numero_req =0;
             $numero_req_demora =0;
             $numero_req_oportuno =0;

        foreach ($eficacia  as $key => $efi) {

           $numero_diferencia +=(int)$efi->diferencia;
            $numero_req += $efi->numero_req;
          
          if($efi->diferencia_demora>0){
            $numero_diferencia_demora+=$efi->diferencia_demora;
            $numero_req_demora += $efi->numero_req;
          }else{
            
            $numero_diferencia_oportuno+=$efi->diferencia;
            $numero_req_oportuno += $efi->numero_req;
                               }
                           }
            if ($numero_req==0) {
                $numero_req =1;
            }

             if ($numero_diferencia==0) {
                $numero_diferencia =1;
            }
             if ($numero_req_demora==0) {
                $numero_req_demora =1;
            }
            if ($numero_req_oportuno==0) {
                $numero_req_oportuno =1;
            }

             if ($numero_diferencia_demora==0) {
                $numero_diferencia_demora =1;
            }
            if ($numero_diferencia_oportuno==0) {
                $numero_diferencia_oportuno =1;
            }

            $oportuna= abs($numero_req- $numero_req_demora);
              
          $avg_tiempo  = (($numero_diferencia/$numero_req));
          $avg_eficacia  = round(((7/$avg_tiempo))*100); 

           $avg_tiempo_demora  = (($numero_diferencia_demora/$numero_req_demora));
          $avg_eficacia_demora  = round(((7/$avg_tiempo_demora))*100); 

          $avg_tiempo_oportuno  = (($numero_diferencia_oportuno/$numero_req_oportuno));
          $avg_eficacia_oportuno  = round(((7/$avg_tiempo_oportuno))*100); 

          //dd($avg_eficacia);
          
          $avg_eficacia_no = 100-$avg_eficacia;
          $eficacia1=[
            "promedio_dias"=>round($avg_tiempo),
            "promedio_dias_demora"=>round($avg_tiempo_demora),
            "promedio_dias_oportuno"=>round($avg_tiempo_oportuno),
            "total_req"=>$numero_req,
            "avg_eficacia"=>$avg_eficacia,
            "avg_eficacia_demora"=>$avg_eficacia_demora,
            "contratos_oportunos"=> $numero_req_oportuno,
            "contratos_destiempo"=> $numero_req_demora
            
        ];

        // Reporte eficacia
        $report_efi = 'reporte_eficacia';
        $indi5 = \Lava::DataTable();
        $indi5->addStringColumn('Eficacia')
                ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
        $indi5->addRow(["Eficacia", (int)$avg_eficacia]);
        $indi5->addRow(["Ineficacia", (int)($avg_eficacia_no)]);
        \Lava::PieChart($report_efi, $indi5, [
            'title' => 'Indicadores Tiempos de entrega',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '100%'
            ],
            'height' => '350'
        ]);

        return view("admin.reportes.indicadores_eficacia_tiempos")->with([
                    'report_efi' => $report_efi,
                    'tipo_solicitud' =>    $tipo_solicitud,
                    'usuarios_gestionan' => $usuarios_gestionan,
                    'tipo_chart'  => 'PieChart',
                    'eficacia1'   => $eficacia1,
                    
        ]);

    }

   public function indicador_eficacia_cliente(Request $request){

    //    $numero_vacantes_contra = DB::table('requerimientos')
    //         ->join('tipo_proceso', 'tipo_proceso.id', '=', 'requerimientos.tipo_proceso_id')
    //         ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
    //         ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
    //         //->whereIn('tipo_proceso.id', array(1,2,8))
    //         ->whereNotIn('requerimientos_estados.max_estado', [2])
            
    //         ->select(
    //             DB::raw('DATE_FORMAT(requerimientos.fecha_terminacion, \'%m\') as mes_creacion'),
    //             'requerimientos.num_vacantes as vacantes_solicitadas',
    //                 DB::raw('(select count(*) as cantidad from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'))
    //         //->groupBy('fecha_creacion')
    //         ->get();
             //dd($numero_vacantes_contra);
        $ano_actual = date("Y");
        // $user = Sentinel::getUser(); 
        $numero_vacantes_contra = Requerimiento::join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            ->whereRaw('(DATE_FORMAT(requerimientos.created_at, \'%Y\')='.$ano_actual.')')
            // ->where('users.id',$user->id)
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

            $ano_actual=date("Y");
            

            foreach ($numero_vacantes_contra as $key => $value) {
               //dd($value);
               
                if ($value->mes_creacion == "01") {

                    $candidatos_contratados_ene = $candidatos_contratados_ene + $value->cant_enviados_contratacion;
                    $candidatos_solicitados_ene = $candidatos_solicitados_ene + $value->vacantes_solicitadas;
                }
                
                elseif($value->mes_creacion == "02") {
                   $candidatos_contratados_feb = $candidatos_contratados_feb + $value->cant_enviados_contratacion;
                    $candidatos_solicitados_feb = $candidatos_solicitados_feb + $value->vacantes_solicitadas;
                }
                
                elseif($value->mes_creacion == "03") {
                    $candidatos_contratados_mar = $candidatos_contratados_mar + $value->cant_enviados_contratacion;
                    $candidatos_solicitados_mar = $candidatos_solicitados_mar + $value->vacantes_solicitadas;
                }
                
                elseif($value->mes_creacion == "04") {
                    $candidatos_contratados_abr = $candidatos_contratados_abr + $value->cant_enviados_contratacion;
                    $candidatos_solicitados_abr = $candidatos_solicitados_abr + $value->vacantes_solicitadas;
                }
                
                elseif($value->mes_creacion == "05") {
                    $candidatos_contratados_may = $candidatos_contratados_may + $value->cant_enviados_contratacion;
                    $candidatos_solicitados_may = $candidatos_solicitados_may + $value->vacantes_solicitadas;
                }
                
                elseif($value->mes_creacion == "06") {
                    $candidatos_contratados_jun = $candidatos_contratados_jun + $value->cant_enviados_contratacion;
                    $candidatos_solicitados_jun = $candidatos_solicitados_jun + $value->vacantes_solicitadas;
                }
                
                elseif($value->mes_creacion == "07") {
                    $candidatos_contratados_jul = $candidatos_contratados_jul + $value->cant_enviados_contratacion;
                    $candidatos_solicitados_jul = $candidatos_solicitados_jul + $value->vacantes_solicitadas;
                }
                
                elseif($value->mes_creacion == "08") {
                    $candidatos_contratados_agos = $candidatos_contratados_agos + $value->cant_enviados_contratacion;
                    $candidatos_solicitados_agos = $candidatos_solicitados_agos + $value->vacantes_solicitadas;
                }
                
                elseif ($value->mes_creacion == "09") {
                    $candidatos_contratados_sep = $candidatos_contratados_sep + $value->cant_enviados_contratacion;
                    $candidatos_solicitados_sep = $candidatos_solicitados_sep + $value->vacantes_solicitadas;
                }
                
                elseif ($value->mes_creacion == "10") {
                    $candidatos_contratados_oct = $candidatos_contratados_oct + $value->cant_enviados_contratacion;
                    $candidatos_solicitados_oct = $candidatos_solicitados_oct + $value->vacantes_solicitadas;
                }
                
                elseif ($value->mes_creacion == "11") {
                    $candidatos_contratados_nov = $candidatos_contratados_nov + $value->cant_enviados_contratacion;
                    $candidatos_solicitados_nov = $candidatos_solicitados_nov + $value->vacantes_solicitadas;
                }
                
                elseif ($value->mes_creacion == "12") {
                    $candidatos_contratados_dic = $candidatos_contratados_dic + $value->cant_enviados_contratacion;
                    $candidatos_solicitados_dic = $candidatos_solicitados_dic + $value->vacantes_solicitadas;
                }
            }

        $report_name4 = 'reporte_indicadores_oportunidad4';
        
        $indi4 = \Lava::DataTable();
        
        $indi4  
         ->addDateColumn('Year')
         ->addNumberColumn('Solicitadas')
         ->addNumberColumn('Contratadas')
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
         ->addRow([$ano_actual.'-12-1',$candidatos_solicitados_dic,$candidatos_contratados_dic])
         ;
       
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
        // \Lava::ComboChart($report_name4, $indi4, [
        //     'title' => 'Indicador de efectividad',
        //     'is3D'   => true,
            
        //      'chartArea' => [
        //         'left' => 60,
        //         'top' => 100,
        //         'height' => '70%',
        //         'width' => '100%'
        //     ],
        //     'height' => '460',
        //     'width' => '1000',
        //         //BackgroundColor Options  
            
        //     'titleTextStyle' => [
        //                             'color'    => 'rgb(123, 65, 89)',
        //                             'fontSize' => 16
        //                          ],
                                 
        //      'legend' => [
        //                     'position' => 'in'
        //                 ]

            
        // ]);

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
    // dd($candidatosContratados);
        return view("req.indicador_eficacia_cliente", compact(
            "num_vac_ven_s","numero_vacantes_s",
            "num_req_a_s",
            "num_can_con_s",
            "num_can_con_r",
            "num_req_a_r",
            "numero_vacantes_r",
            "num_vac_ven_r",
            "report_name4",
            "menu", 
            "colores", 
            "conteos",
            "num_req_a",
            "numero_vacantes",
            "num_vac_ven",
            "num_can_con",
            "candidatosSolicitados",
            "candidatosContratados"
        ));
    }

    public function indicador_cierre(Request $request){

         $datos=true;
         $mostrar=false;

         if($request->fecha_carga_ini!="" || $request->fecha_carga_fin!=""){
             $mostrar=true;
         }

         //deben ser las vacantes creadas

         /*$requerimientos_abiertos_r=  DB::table('requerimientos')
            ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
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
             //->where('tipo_proceso.id',2)
            ->where(function ($where) use ($request) {

                  //dd($request->get('cliente_id'));
                if($request->get('proceso_id') != "") {
                    $where->where("requerimientos.tipo_proceso_id",$request->get('proceso_id'));
                }

                if($request->get('user_id') != "") {
                    $where->whereRaw('(select upper(p.id)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id  order by o.created_at desc limit 1)= '.$request->get("user_id"));
                }
                     
                  
                if ($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                }

                if ($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {

                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$request->get('fecha_tenta_ini'),$request->get('fecha_tenta_fin')]);
                }

            })
             //->whereIn('estados_requerimiento.estado',
           // [
                //            config('conf_aplicacion.C_RECLUTAMIENTO'),
                  //          config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                   //         config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                     //       config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),])
         //    ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
             ->select(
                'requerimientos.id as requerimiento_id',
                'requerimientos.tipo_contrato_id as contrato'

            )->groupBy('requerimientos.id')
             ->get();*/

        $requerimientos_abiertos_r=  DB::table('solicitudes')
            /*->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
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
            ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')*/
             //->where('tipo_proceso.id',2)
            ->where(function ($where) use ($request){

                  //dd($request->get('cliente_id'));
                if($request->get('proceso_id') != "") {
                  
                  $where->where("requerimientos.tipo_proceso_id",$request->get('proceso_id'));
                }

                if($request->get('user_id') != "") {
                  
                  $where->whereRaw('(select upper(p.id)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id  order by o.created_at desc limit 1)= '.$request->get("user_id"));
                }
                     
                  
                if($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                    
                    $where->whereBetween(DB::raw('DATE_FORMAT(solicitudes.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                }

                if($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {

                   $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$request->get('fecha_tenta_ini'),$request->get('fecha_tenta_fin')]);
                }

            })
             //->whereIn('estados_requerimiento.estado',
           // [
                //            config('conf_aplicacion.C_RECLUTAMIENTO'),
                  //          config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                   //         config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                     //       config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),])
         //    ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->select(
                'solicitudes.id as requerimiento_id',
                'solicitudes.tipo_contrato_id as contrato',
                /*DB::raw(' solicitudes.numero_vacante - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),*/
                'solicitudes.numero_vacante as vacantes_solicitadas'
            )->groupBy('solicitudes.id')
             ->get();
            
        $req_abiertos=array();
        //$req_abiertos["total"] = $requerimientos_abiertos_r->count();
        $req_abiertos["temp"]=0;
        $req_abiertos["fijo"]=0;
        $req_abiertos["total"]=0;
        //necesito contar y sumar son las vacantes
          foreach($requerimientos_abiertos_r as $req){

                if($req->contrato==7){

                  $req_abiertos["temp"]+= $req->vacantes_solicitadas;
                }else{
                 
                  $req_abiertos["fijo"]+= $req->vacantes_solicitadas;
                }

                  $req_abiertos["total"]+= $req->vacantes_solicitadas;
          }

        $requerimientos_enproceso =  DB::table('requerimientos')
            ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->join('tipos_contratos', 'requerimientos.tipo_contrato_id', '=', 'tipos_contratos.id')
            ->join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                    ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                    ->on('requerimientos.pais_id','=', 'ciudad.cod_pais');
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
            // ->where('tipo_proceso.id',2)
            ->where(function ($where) use ($request) {

                  //dd($request->get('cliente_id'));
                 if($request->get('proceso_id') != "") {
                    $where->where("requerimientos.tipo_proceso_id",$request->get('proceso_id'));
                 }

                 if($request->get('user_id') != "") {
                    $where->whereRaw('(select upper(p.id)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id  order by o.created_at desc limit 1)= '.$request->get("user_id"));
                 }
                     
                 if ($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                        $where->where(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),'<=',$request->get('fecha_carga_fin'));
                 }

                 if ($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {

                        $where->where(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),'<=',$request->get('fecha_tenta_fin'));
                    }
            })
                ->whereIn('estados_requerimiento.estado',
                  [config('conf_aplicacion.C_RECLUTAMIENTO'),
                   config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                   config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                   config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                   config('conf_aplicacion.C_TERMINADO'),1])
             
             ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->select(
                'requerimientos.id as requerimiento_id',
                'requerimientos.tipo_contrato_id as contrato',
                DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                'requerimientos.num_vacantes as vacantes_solicitadas'
            )->groupBy('requerimientos.id')
             ->get();

        $req_enproceso=array();
        //$req_abiertos["total"] = $requerimientos_abiertos_r->count();
        $req_enproceso["temp"]=0;
        $req_enproceso["fijo"]=0;
        $req_enproceso["total"]=0;

         foreach($requerimientos_enproceso as $req){
          
            if($req->contrato==7){
             
             $req_enproceso["temp"]+= $req->vacantes_solicitadas;

            }else{
              
             $req_enproceso["fijo"]+= $req->vacantes_solicitadas;
            }
            
            $req_enproceso["total"]+= $req->vacantes_solicitadas;
         }

        $requerimientos_cerrados_r = DB::table('requerimientos')
            ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
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
            ->where('tipo_proceso.id',2)
            ->where(function ($where) use ($request){
                  //dd($request->get('cliente_id'));
                if($request->get('proceso_id') != ""){
                    $where->where("requerimientos.tipo_proceso_id",$request->get('proceso_id'));
                }

                if($request->get('user_id') != ""){
                    $where->whereRaw('(select upper(p.id)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id  order by o.created_at desc limit 1)= '.$request->get("user_id"));
                }
                  
                if($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != ""){
                     
                     $where->whereBetween(DB::raw('DATE_FORMAT(estados_requerimiento.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                }

                })
            ->whereIn('estados_requerimiento.estado',
                [
                config('conf_aplicacion.C_TERMINADO'),
                config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                ])
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->select(
                'requerimientos.id as requerimiento_id',
                'requerimientos.tipo_contrato_id as contrato',
                DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                'requerimientos.num_vacantes as vacantes_solicitadas'
            )->groupBy('requerimientos.id')
             ->get();

        //reporte de cerrados vs en proceso

        
        $req_cerrados=array();
        //$req_cerrados["total"]= $requerimientos_cerrados_r->count();
       
        $req_cerrados["temp"]=0;
        $req_cerrados["fijo"]=0;
        $req_cerrados["total"]=0;
        
         foreach($requerimientos_cerrados_r as $req2){

            if($req2->contrato==7){
             
             $req_cerrados["temp"]+= $req2->vacantes_solicitadas;
            }
            else{
             $req_cerrados["fijo"]+= $req2->vacantes_solicitadas;
            }
                 $req_cerrados["total"]+= $req2->vacantes_solicitadas;
          }
        //REQUERIMIENTOS CANCELADOS

            $requerimientos_cancelados_r =  DB::table('requerimientos')
            ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->join('tipos_contratos', 'requerimientos.tipo_contrato_id', '=', 'tipos_contratos.id')
            ->join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                    ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->join('departamentos', function($join2){
                $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
            })
            ->join('paises', 'requerimientos.pais_id', '=', 'paises.cod_pais')
            ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
            ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
            ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            ->where('tipo_proceso.id',2)
            ->where(function ($where) use ($request) {

                  //dd($request->get('cliente_id'));
                if($request->get('proceso_id') != "") {
                    $where->where("requerimientos.tipo_proceso_id",$request->get('proceso_id'));
                }

                if($request->get('user_id') != ""){
                    $where->whereRaw('(select upper(p.id)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id  order by o.created_at desc limit 1)= '.$request->get("user_id"));
                }
                  
                if ($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                     
                     $where->whereBetween(DB::raw('DATE_FORMAT(estados_requerimiento.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                }

            })
            ->where('estados_requerimiento.estado',1)
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->select(
                'requerimientos.id as requerimiento_id',
                'requerimientos.tipo_contrato_id as contrato',
                DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                'requerimientos.num_vacantes as vacantes_solicitadas'
            )->groupBy('requerimientos.id')
             ->get();

        $req_cancelados=array();
        //$req_cerrados["total"]= $requerimientos_cerrados_r->count();
        $req_cancelados["temp"]=0;
        $req_cancelados["fijo"]=0;
        $req_cancelados["total"]=0;

            foreach($requerimientos_cancelados_r as $req3){
                if($req3->contrato==7){
                    $req_cancelados["temp"]+= $req3->vacantes_solicitadas;
                }else{
                    $req_cancelados["fijo"]+= $req3->vacantes_solicitadas;
                }
                
             $req_cancelados["total"]+= $req3->vacantes_solicitadas;
            }
    //FIN DE CANCELADOS
        
        //$requerimientos_totales=$req_cerrados["total"]+$req_enproceso["total"];
    //calculo de grafica temporales
            // son los temporales en proceso menos los temporales cerrados por 100 entre temporales en proceso
          //TEMPORALES******************////
            
        $requerimientos_totales_temp = $req_enproceso["temp"] - $req_cerrados["temp"];

        if($requerimientos_totales_temp > 0){
            //$avg_abiertos  = round(($req_enproceso["total"]*100)/$requerimientos_totales);
            $avg_abiertos_temp  = round(($requerimientos_totales_temp*100)/$req_enproceso["temp"]);
            
            $avg_cerrados_temp=100-$avg_abiertos_temp;
        }
        else{
            
            $avg_abiertos_temp = 100;
            $avg_cerrados_temp = 0;
        }

    //calculo de grafica directos
            // son los directos en proceso menos los directos cerrados por 100 entre temporales en proceso
          //Directos******************////

        $requerimientos_totales_fijos= $req_enproceso["fijo"] - $req_cerrados["fijo"];

        if($requerimientos_totales_fijos>0){
            
           $avg_abiertos_fijos=round(($requerimientos_totales_fijos*100)/$req_enproceso["fijo"]);

            $avg_cerrados_fijos=100-$avg_abiertos_fijos;
        }
        else{
             $avg_abiertos_fijos=100;
             $avg_cerrados_fijos=0;
        }

        //total de todos total proceso menos total cerrados por 100 entre total proceso

         $requerimientos_totales = $req_enproceso["total"] - $req_cerrados["total"];

        if($requerimientos_totales>0){

          $avg_abiertos=round(($requerimientos_totales*100)/$req_enproceso["total"]);
          $avg_cerrados=100-$avg_abiertos;
        }
        else{
         
         $avg_abiertos=100;
         $avg_cerrados=0;
        }

        //los cancelados son los cancelados entre temporales y fijo

        // $requerimientos_totales_cancelados = $req_cancelados["temp"];

     //grafico uno vacantes temporales 

        $report_cierre_temp = 'reporte_cierre_temp';
        $indi8 = \Lava::DataTable();
        $indi8->addStringColumn('Total')
              ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
        $indi8->addRow(["Abiertos", (int)$avg_abiertos_temp]);
        $indi8->addRow(["Cerrados", (int)$avg_cerrados_temp]);

        \Lava::PieChart($report_cierre_temp, $indi8, [
            'title' => 'Estado Proceso Temporales',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '80%'
            ],
            'height' => '170'
        ]);
//indicador de totales

        $report_cierre_fijos = 'reporte_cierre_directos';
        $indi5 = \Lava::DataTable();
        $indi5->addStringColumn('Cierre')
              ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
        $indi5->addRow(["Abiertos", (int)$avg_abiertos_fijos]);
        $indi5->addRow(["Cerrados", (int)$avg_cerrados_fijos]);

        \Lava::PieChart($report_cierre_fijos, $indi5, [
            'title' => 'Estado Proceso Directos',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 60,
                'top' => 40,
                'width' => '90%'
            ],
            'height' => '170'
        ]);

        $report_cierre_totales = 'reporte_cierre_totales';
        $indi6 = \Lava::DataTable();
        $indi6->addStringColumn('Cierre')
              ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
        $indi6->addRow(["Abiertos", (int)$avg_abiertos]);
        $indi6->addRow(["Cerrados", (int)$avg_cerrados]);

        \Lava::PieChart($report_cierre_totales, $indi6, [
            'title' => 'Estado procesos Totales',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 60,
                'top' => 40,
                'width' => '90%'
            ],
            'height' => '170'
        ]);

        $report_cierre_cancelados = 'report_cierre_cancelados';
        $indi7 = \Lava::DataTable();
        $indi7->addStringColumn('Cierre')
              ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];

        if($req_cancelados["temp"] == 0 && $req_cancelados["fijo"] == 0 ){

           $req_cancelados["temp"] = 0;
           $req_cancelados["fijo"] = 0;

        }else{
        
         $indi7->addRow(["Temporales", (int)$req_cancelados["temp"]]);
         $indi7->addRow(["Directos", (int)$req_cancelados["fijo"]]);
        }

        \Lava::PieChart($report_cierre_cancelados, $indi7, [
            'title' => 'Estado procesos Cancelados',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 60,
                'top' => 40,
                'width' => '90%'
            ],
            'height' => '170'
        ]);

        //cancelados vs en proceso

        $report_total_cancel_proces = 'total_cancelados_vs_proceso';
        $indi9 = \Lava::DataTable();
        $indi9->addStringColumn('Total')
              ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
        $total=0;
        $totalc=0;
        //calculo de cancelados vs en proceso

        if($req_enproceso["total"]>0){

          $total = round(($req_enproceso["total"])*100/($req_enproceso["total"]+$req_cancelados["total"]));
         
         if($req_cancelados["total"]){

          $totalc = round(($req_cancelados["total"])*100/($req_enproceso["total"]+$req_cancelados["total"]));
         }

        }

      //  dd($totalc+$total);
        
        $indi9->addRow(["En Proceso", (int)$total]);
        $indi9->addRow(["Cancelados", (int)$totalc]);

        \Lava::PieChart($report_total_cancel_proces, $indi9, [
            'title' => 'Total Cancelados Vs En Proceso',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '80%'
            ],
            'height' => '170'
        ]);

//comienza temp cancelados-----temp en proceso
    // cancelados vs en proceso

        $report_cancel_proces = 'cancelados_vs_proceso';
        $indi10 = \Lava::DataTable();
        $indi10->addStringColumn('Total')
              ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
        $total_vs_temp=0;
        $total_vs_fijos=0;
        //calculo de cancelados vs en proceso
        //cancelados y en proceso temporales

        if($req_cancelados["temp"]>0){

          $total_vs_temp = round(($req_enproceso["temp"])*100/($req_enproceso["temp"]+$req_cancelados["temp"]));
        }
        
        if($req_cancelados["fijo"]){

          $total_vs_fijos = round(($req_cancelados["fijo"])*100/($req_enproceso["fijo"]+$req_cancelados["fijo"]));
        }

      //  dd($totalc+$total);
        
        $indi10->addRow(["Cancelados Directos", $total_vs_fijos]);
        $indi10->addRow(["Cancelados Temporales", $total_vs_temp]);

        \Lava::PieChart($report_cancel_proces, $indi10, [

            'title' => 'Cancelados Vs En Proceso',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '80%'
            ],
            'height' => '170'
        ]);

        //dd($avg_cerrados_temp);
 
        return view("admin.reportes.indicador_cierre")->with([
            'report_cierre_totales' => $report_cierre_totales,
            'report_cierre_fijos' => $report_cierre_fijos,
            'report_cierre_temp' => $report_cierre_temp,
            'report_cierre_cancelados' => $report_cierre_cancelados,
            'req_abiertos' => $req_abiertos,
            'req_cerrados' => $req_cerrados,
            'req_enproceso' => $req_enproceso,
            'req_cancelados'=>$req_cancelados,
            'report_total_cancel_proces'=>$report_total_cancel_proces,
            'report_cancel_proces'=>$report_cancel_proces,
            'tipo_chart' => 'PieChart',
            'datos' => $datos,
            'mostrar' => $mostrar ]);
    }

    public function reporte(Request $request)
    {

        $data = $this->dataIndicadores($request);

        $report_name = 'reporte';

        $indi = \Lava::DataTable();
        $indi->addStringColumn('Estados')
            ->addNumberColumn('Cantidad')
            ->addRow(['Req. Abiertas', $data['abiertas']])
            ->addRow(['Req. Cerradas a Tiempo', $data['cerradas']])
            ->addRow(['Req. Contrataciones', $data['contratadas']])
            ->addRow(['Req. Enviados Aprobaci贸n', $data['enviadas_aprobacion']]);

        \Lava::PieChart($report_name, $indi, [
            'title'  => 'Indicadores Requisiciones',
            'is3D'   => true,
            'slices' => [
                ['offset' => 0.2],
                ['offset' => 0.25],
                ['offset' => 0.3],
                ['offset' => 0.1],
            ],
        ]);

        $clientes = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        return view('admin.reportes.reporte')->with
            ([
            'report_name' => $report_name,
            'data'        => $data,
            'clientes'    => $clientes,
            'tipo_chart'  => 'PieChart',
        ]);
    }
    public function reporteExcelIndicadores(Request $request)
    {
        $data    = $this->dataIndicadores($request);
        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-indicadores', function ($excel) use ($data, $formato) {
            $excel->setTitle('Reporte Indicadores');
            $excel->setCreator('$nombre')
                ->setCompany('$noombre');
            $excel->setDescription('Reporte Indicadores');
            $excel->sheet('Reportes Indicadores', function ($sheet) use ($data) {
                $sheet->loadView('admin.reportes.includes.grilla')->with('data', $data);
            });
        })->export($formato);
    }
    private function dataIndicadores(Request $request)
    {

        $fecha_inicio = $request->fecha_inicio;
        $fecha_final  = $request->fecha_final;
        $cliente_id   = $request->cliente_id;

        $result_req = EstadosRequerimientos::join("estados", "estados_requerimiento.estado", "=", "estados.id")
            ->join("requerimientos", "estados_requerimiento.req_id", "=", "requerimientos.id")
            ->join("negocio", "requerimientos.negocio_id", "=", "negocio.id")
            ->select(DB::raw("count(*) as num_req"), "estados_requerimiento.estado", "estados.descripcion")
            ->where(function ($query) use ($fecha_inicio, $fecha_final, $cliente_id) {
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $query->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $query->where("negocio.cliente_id", $cliente_id);
                }
            })
            ->groupBy("estados_requerimiento.estado", "estados.descripcion")
            ->get();
        //dd($result_req[0]->num_req_abiertos);
        $num_reclutamiento = 1;
        $num_terminadas    = 1;
        $num_canceladas    = 1;
        $num_inactivas     = 1;
        $num_eliminadas    = 1;
        $data              = array();
        foreach ($result_req as $result) {
            if ($result->estado == config('conf_aplicacion.C_RECLUTAMIENTO')) {
                $num_reclutamiento = $result->num_req;
            }
            if ($result->estado == config('conf_aplicacion.C_TERMINADO')) {
                $num_terminadas = $result->num_req;
            }
            if ($result->estado == config('conf_aplicacion.C_INACTIVO')) {
                $num_inactivas = $result->num_req;
            }
            if ($result->estado == config('conf_aplicacion.C_VENTA_PERDIDA')) {
                $num_canceladas = $result->num_req;
            }
            if ($result->estado == config('conf_aplicacion.C_ELIMINADO')) {
                $num_eliminadas = $result->num_req;
            }

        }
        $data['abiertas']            = $num_reclutamiento - ($num_terminadas + $num_canceladas + $num_inactivas + $num_eliminadas);
        $data['contratadas']         = $num_terminadas;
        $data['cerradas']            = 18;
        $data['enviadas_aprobacion'] = 8;

        return $data;
    }

    public function index()
    {
        return view("admin.index");
    }
    
    //Reporte bd cargos
    public function reporte_bd_cargos(Request $request)
    {

        $ciudad_req = DB::table('reporte_cargos')
            ->select("ciudad")
            ->distinct()
            ->orderBy("ciudad", "asc")
            ->get();
        $generos = DB::table('reporte_cargos')
            ->select("t_genero")
            ->distinct()
            ->get();
        $edad_minima = [];
        for ($i = 18; $i <= 50; $i++) {
            $edad_minima[$i] = $i;
        }
        $edad_maxima = [];
        for ($j = 18; $j <= 50; $j++) {
            $edad_maxima[$j] = $j;
        }
        $tiene_experiencia = ["si" => "Si"] + ["no" => "No"];

        $headers = [
            "NUMERO_ID",
            "FECHA_REGISTRO",
            "NOMBRES",
            "PRIMER_APELLIDO",
            "SEGUNDO_APELLIDO",
            "EMAIL",
            "TELEFONO_FIJO",
            "TELEFONO_MOVIL",
            "CIUDAD",
            "TIENE_EXPERIENCIA",
            "T_GENERO",
            "FECHA_NACIMIENTO",
            "EDAD",
            "ULTIMO_ACCESO",
            "CARGO_DESEMPENADO",
        ];
        $campos = [
            "numero_id",
            "fecha_registro",
            "nombres",
            "primer_apellido",
            "segundo_apellido",
            "email",
            "telefono_fijo",
            "telefono_movil",
            "ciudad",
            "tiene_experiencia",
            "t_genero",
            "fecha_nacimiento",
            "edad",
            "ultimo_acceso",
            "cargo_desempenado",
        ];
        $data = DB::table('reporte_cargos')
            ->where(function ($sql) use ($request) {
                if ($request->get('fecha_a_inicio_req') != "" && $request->get('fecha_a_fin_req') != "") {
                    $sql->whereBetween("fecha_registro", [$request->get('fecha_a_inicio_req'), $request->get('fecha_a_fin_req')]);
                }
                if ($request->get('ciudad') != "") {
                    $sql->where("ciudad", $request->get('ciudad'));
                }
                if ($request->get('genero') != "") {
                    $sql->where("t_genero", $request->get('genero'));
                }
                if ($request->get('edad_min') != "" && $request->get('edad_max') != "") {
                    $sql->whereBetween("edad", [$request->get('edad_min'), $request->get('edad_max')]);
                }
                if ($request->get('cargo_desempenado') != "") {
                    $sql->where("cargo_desempenado", "like", "'.$request->get('cargo_desempenado').'");
                }
                if ($request->get('tiene_exp') != "") {
                    $sql->where("tiene_experiencia", ">", 0);
                }
            })
            ->select('*')
            ->paginate(10);
        return view('admin.reportes.reporte_cargos', compact(
            "data",
            "headers",
            "campos",
            "ciudad_req",
            "generos",
            "edad_minima",
            "edad_maxima",
            "tiene_experiencia"
        ));
    }
    // reporte bd cargos excel
    public function reporte_bd_cargos_excel(Request $request)
    {
        $headers = [
            "NUMERO_ID",
            "FECHA_REGISTRO",
            "NOMBRES",
            "PRIMER_APELLIDO",
            "SEGUNDO_APELLIDO",
            "EMAIL",
            "TELEFONO_FIJO",
            "TELEFONO_MOVIL",
            "CIUDAD",
            "TIENE_EXPERIENCIA",
            "T_GENERO",
            "FECHA_NACIMIENTO",
            "EDAD",
            "ULTIMO_ACCESO",
            "CARGO_DESEMPENADO",
        ];
        $campos = [
            "numero_id",
            "fecha_registro",
            "nombres",
            "primer_apellido",
            "segundo_apellido",
            "email",
            "telefono_fijo",
            "telefono_movil",
            "ciudad",
            "tiene_experiencia",
            "t_genero",
            "fecha_nacimiento",
            "edad",
            "ultimo_acceso",
            "cargo_desempenado",
        ];

        $data = DB::table('reporte_cargos')
            ->where(function ($sql) use ($request) {
                if ($request->get('fecha_a_inicio_req') != "" && $request->get('fecha_a_fin_req') != "") {
                    $sql->whereBetween("fecha_registro", [$request->get('fecha_a_inicio_req'), $request->get('fecha_a_fin_req')]);
                }
                if ($request->get('ciudad') != "") {
                    $sql->where("ciudad", $request->get('ciudad'));
                }
                if ($request->get('genero') != "") {
                    $sql->where("t_genero", $request->get('genero'));
                }
                if ($request->get('edad_min') != "" && $request->get('edad_max') != "") {
                    $sql->whereBetween("edad", [$request->get('edad_min'), $request->get('edad_max')]);
                }
                if ($request->get('cargo_desempenado') != "") {
                    $sql->where("cargo_desempenado", "like", "'.$request->get('cargo_desempenado').'");
                }
                if ($request->get('tiene_exp') != "") {
                    $sql->where("tiene_experiencia", ">", 0);
                }
            })
            ->select('*')
            ->get();
        Excel::create('reporte-excel-cargos_candidatos', function ($excel) use ($data, $headers, $campos) {
            $excel->setTitle('Reporte Candidatos Cargos');
            $excel->setCreator('T3RS')
                ->setCompany('T3RS');
            $excel->setDescription('Reporte Candidatos Cargos');
            $excel->sheet('ReporteCandidatosCargos', function ($sheet) use ($data, $headers, $campos) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_general', [
                    'data'    => $data,
                    'headers' => $headers,
                    'campos'  => $campos,
                ]);
            });
        })->export(config('conf_aplicacion.FORMATO_REPORTE'));

    }
    //Reporte gestion
    public function reporte_gestion(Request $request)
    {
        //filtros
        $clientes = DB::table('reporte_gestion')
            ->select("cliente_id", "t_cliente")
            ->distinct()
            ->get();
        $tipo_req = DB::table('reporte_gestion')
            ->select("tipo_requerimiento", "tipo_proceso")
            ->distinct()
            ->get();
        $ciudad_req = DB::table('reporte_gestion')
            ->select("t_ciudad_requerimiento")
            ->distinct()
            ->orderBy("t_ciudad_requerimiento", "asc")
            ->get();
        $estado_req = DB::table('reporte_gestion')
            ->select("estado_requerimiento_id", "estado_requerimiento")
            ->distinct()
            ->get();

        $data = DB::table('reporte_gestion')
            ->select('*')
            ->where(function ($sql) use ($request) {
                if ($request->get('cliente') != "") {
                    $sql->where("cliente_id", $request->get('cliente'));
                }
                if ($request->get('tipo_requerimiento') != "") {
                    $sql->where("tipo_requerimiento", $request->get('tipo_requerimiento'));
                }
                if ($request->get('ciudad_requerimiento') != "") {
                    $sql->where("t_ciudad_requerimiento", $request->get('ciudad_requerimiento'));
                }
                if ($request->get('estado_requerimiento') != "") {
                    $sql->where("estado_requerimiento_id", $request->get('estado_requerimiento'));
                }
                if ($request->get('fecha_a_inicio_req') != "" && $request->get('fecha_a_fin_req')) {
                    $sql->whereBetween("fecha_requerimiento", [$request->get('fecha_a_inicio_req'), $request->get('fecha_a_fin_req')]);
                }
                if ($request->get('fecha_c_inicio_req') != "" && $request->get('fecha_c_fin_req')) {
                    $sql->whereBetween("fecha_inicio_vacante", [$request->get('fecha_c_inicio_req'), $request->get('fecha_c_fin_req')]);
                }

            })
            ->paginate(10);
        $headers = [
            "REQUERIMIENTO_ID",
            "FECHA_REQUERIMIENTO",
            "TIPO_PROCESO",
            "T_CIUDAD_REQUERIMIENTO",
            "T_CLIENTE",
            "CARGO_GENERICO",
            "CARGO_ESPECIFICO",
            "NUM_VACANTES",
            "NUM_P_CONTRATADAS",
            "VACANTES_PENDIENTES",
            "FECHA_INICIO_VACANTE",
            "FECHA_TENTATIVA",
            "TIPO_VACANTE",
            "DIAS_MAX_GESTION",
            "DIAS_HAB_VENCIDA_REQ",
            "ESTADO_REQUERIMIENTO",
            "EDAD_VACANTE_HAB",
            "TEXTO_EDAD_VACANTE",
            "NUM_ENVIADOS_CONTRATAR",
            "VACANTES_PENDIENTES_REAL",
            "NUM_ENVIADOS_EXAMENES",
            "NUM_CONTRATOS_ANULADOS",
            "FECHA_CIERRE",
            "CONTRATADOS_DENTRO_LIMITE",
            "CONTRATADOS_FUERA_LIMITE",
            "NUM_NEGOCIO",
            "NUM_DIAS_GESTION",
            "SALARIO",
            "NUM_CANDIDATOS_ASOCIADOS",
            "AGENCIA",
        ];
        $campos = [
            "requerimiento_id",
            "fecha_requerimiento",
            "tipo_proceso",
            "t_ciudad_requerimiento",
            "t_cliente",
            "cargo_generico",
            "cargo_especifico",
            "num_vacantes",
            "num_p_contratadas",
            "vacantes_pendientes",
            "fecha_inicio_vacante",
            "fecha_tentativa",
            "tipo_vacante",
            "dias_max_gestion",
            "dias_hab_vencida_req",
            "estado_requerimiento",
            "edad_vacante_hab",
            "texto_edad_vacante",
            "num_enviados_contratar",
            "vacantes_pendientes_real",
            "num_enviados_examenes",
            "num_contratos_anulados",
            "fecha_cierre",
            "contratados_dentro_limite",
            "contratados_fuera_limite",
            "num_negocio",
            "num_dias_gestion",
            "salario",
            "num_candidatos_asociados",
            "agencia",
        ];

        return view('admin.reportes.reporte_gestion', compact(
            "data",
            "clientes",
            "tipo_req",
            "ciudad_req",
            "estado_req",
            "headers",
            "campos"
        ));
    }
    public function reporte_gestion_excel(Request $request)
    {

        $headers = [
            "REQUERIMIENTO_ID",
            "FECHA_REQUERIMIENTO",
            "TIPO_PROCESO",
            "T_CIUDAD_REQUERIMIENTO",
            "T_CLIENTE",
            "CARGO_GENERICO",
            "CARGO_ESPECIFICO",
            "NUM_VACANTES",
            "NUM_P_CONTRATADAS",
            "VACANTES_PENDIENTES",
            "FECHA_INICIO_VACANTE",
            "FECHA_TENTATIVA",
            "TIPO_VACANTE",
            "DIAS_MAX_GESTION",
            "DIAS_HAB_VENCIDA_REQ",
            "ESTADO_REQUERIMIENTO",
            "EDAD_VACANTE_HAB",
            "TEXTO_EDAD_VACANTE",
            "NUM_ENVIADOS_CONTRATAR",
            "VACANTES_PENDIENTES_REAL",
            "NUM_ENVIADOS_EXAMENES",
            "NUM_CONTRATOS_ANULADOS",
            "FECHA_CIERRE",
            "CONTRATADOS_DENTRO_LIMITE",
            "CONTRATADOS_FUERA_LIMITE",
            "NUM_NEGOCIO",
            "NUM_DIAS_GESTION",
            "SALARIO",
            "NUM_CANDIDATOS_ASOCIADOS",
            "AGENCIA",
        ];
        $campos = [
            "requerimiento_id",
            "fecha_requerimiento",
            "tipo_proceso",
            "t_ciudad_requerimiento",
            "t_cliente",
            "cargo_generico",
            "cargo_especifico",
            "num_vacantes",
            "num_p_contratadas",
            "vacantes_pendientes",
            "fecha_inicio_vacante",
            "fecha_tentativa",
            "tipo_vacante",
            "dias_max_gestion",
            "dias_hab_vencida_req",
            "estado_requerimiento",
            "edad_vacante_hab",
            "texto_edad_vacante",
            "num_enviados_contratar",
            "vacantes_pendientes_real",
            "num_enviados_examenes",
            "num_contratos_anulados",
            "fecha_cierre",
            "contratados_dentro_limite",
            "contratados_fuera_limite",
            "num_negocio",
            "num_dias_gestion",
            "salario",
            "num_candidatos_asociados",
            "agencia",
        ];
        $data = DB::table('reporte_gestion')
            ->select('*')
            ->where(function ($sql) use ($request) {
                if ($request->get('cliente') != "") {
                    $sql->where("cliente_id", $request->get('cliente'));
                }
                if ($request->get('tipo_requerimiento') != "") {
                    $sql->where("tipo_requerimiento", $request->get('tipo_requerimiento'));
                }
                if ($request->get('ciudad_requerimiento') != "") {
                    $sql->where("t_ciudad_requerimiento", $request->get('ciudad_requerimiento'));
                }
                if ($request->get('estado_requerimiento') != "") {
                    $sql->where("estado_requerimiento_id", $request->get('estado_requerimiento'));
                }
                if ($request->get('fecha_a_inicio_req') != "" && $request->get('fecha_a_fin_req')) {
                    $sql->whereBetween("fecha_requerimiento", [$request->get('fecha_a_inicio_req'), $request->get('fecha_a_fin_req')]);
                }
                if ($request->get('fecha_c_inicio_req') != "" && $request->get('fecha_c_fin_req')) {
                    $sql->whereBetween("fecha_inicio_vacante", [$request->get('fecha_c_inicio_req'), $request->get('fecha_c_fin_req')]);
                }

            })
            ->get();
        Excel::create('reporte-excel-candidatos', function ($excel) use ($data, $headers, $campos) {
            $excel->setTitle('Reporte Candidatos');
            $excel->setCreator('T3RS')
                ->setCompany('T3RS');
            $excel->setDescription('Reporte Candidatos');
            $excel->sheet('ReporteCandidatos', function ($sheet) use ($data, $headers, $campos) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_general', [
                    'data'    => $data,
                    'headers' => $headers,
                    'campos'  => $campos,
                ]);
            });
        })->export(config('conf_aplicacion.FORMATO_REPORTE'));

/*
return view('admin.reportes.includes.grilla_general',compact(
"data",
"headers",
"campos"
)); */
    }
    //View de reporte de candidatos
    public function reporte_candidato(Request $data)
    {

        $empresas = DB::table('reporte_candidatos')
            ->join("sociedades", "reporte_candidatos.sociedad", "=", "sociedades.division_codigo")
            ->select("reporte_candidatos.sociedad as sociedad", "sociedades.division_nombre as nombre")
            ->distinct()
            ->get();

        /* $clientes = ["" => "Seleccionar"] + Clientes::orderBy("nombre","asc")
        ->pluck("nombre", "id")
        ->toArray(); */
        //dd($clientes);
        $clientes = DB::table('reporte_candidatos')
            ->select("cliente_id", "nombre_cliente")
            ->distinct()
            ->get();

        $motivo_req = ["" => "Seleccionar"] + MotivoRequerimiento::orderBy("descripcion", "asc")
            ->pluck("descripcion", "id")
            ->toArray();

        $motivo_req = DB::table('reporte_candidatos')
            ->join("motivo_requerimiento", "reporte_candidatos.motivo_requerimiento_id", "=", "motivo_requerimiento.id")
            ->select("reporte_candidatos.motivo_requerimiento as nombre", "motivo_requerimiento.id as id")
            ->distinct()
            ->get();
        //dd($motivo_req);

        $ciudad_req = DB::table('reporte_candidatos')->select("ciudad_requerimiento")
            ->distinct()
            ->get();

        /* $estado_req = ["" => "Seleccionar"] + Estados::orderBy("descripcion","asc")
        ->pluck("descripcion", "id")
        ->toArray(); */

        $estado_req = DB::table('reporte_candidatos')
            ->join("estados", "reporte_candidatos.num_estado_requerimiento", "=", "estados.id")
            ->select("reporte_candidatos.estado_requerimiento as estado", "estados.id as estado_id")
            ->distinct()
            ->get();
        //dd($estado_req);

        $gestiono = DB::table('reporte_candidatos')
            ->join("users", "reporte_candidatos.usuario_gestion", "=", "users.id")
            ->select("users.name as nombre", "users.id as id")
            ->distinct()
            ->get();

        $data = DB::table('reporte_candidatos')
            ->where(function ($sql) use ($data) {
                if ($data->get('empresa') != "") {
                    $sql->where("reporte_candidatos.sociedad", $data->get('empresa'));
                }
                if ($data->get('cliente') != "") {
                    $sql->where("reporte_candidatos.cliente_id", $data->get('cliente'));
                }
                if ($data->get('fecha_inicio_req') != "" && $data->get('fecha_fin_req') != "") {
                    $sql->whereBetween("reporte_candidatos.fecha_requerimiento", [$data->get('fecha_inicio_req'), $data->get('fecha_fin_req')]);
                }
                if ($data->get('motivo_requerimiento') != "") {
                    $sql->where("reporte_candidatos.motivo_requerimiento_id", $data->get('motivo_requerimiento'));
                }
                if ($data->get('ciudad_requerimiento') != "") {
                    $sql->where("reporte_candidatos.ciudad_requerimiento", $data->get('ciudad_requerimiento'));
                }
                if ($data->get('estado_requerimiento') != "") {
                    $sql->where("reporte_candidatos.num_estado_requerimiento", $data->get('estado_requerimiento'));
                }
                if ($data->get('fecha_i_cierre_req') != "" && $data->get('fecha_f_cierre_req') != "") {
                    $sql->whereBetween("reporte_candidatos.fecha_cierre", [$data->get('fecha_i_cierre_req'), $data->get('fecha_f_cierre_req')]);
                }
                if ($data->get('gestiono') != "") {
                    $sql->where("reporte_candidatos.usuario_gestion", $data->get('gestiono'));
                }
            })
            ->select('*')
            ->paginate(20);
        //dd($data);
        $headers = [
            "NUM_REQUERIMIENTO",
            "NUM_REQ_CLIENTE",
            "FECHA_REQUERIMIENTO",
            "HORA_REQUERIMIENTO",
            "NOMBRE_CLIENTE",
            "CIUDAD_REQUERIMIENTO",
            "CENTRO_COSTO_PRODUCCION",
            "NOMBRE_SOLICITANTE",
            "MOTIVO_REQUERIMIENTO",
            "NUM_VACANTES",
            "CARGO_GENERICO",
            "CARGO_CLIENTE",
            "ESTADO_REQUERIMIENTO",
            "NUM_ASOCIADOS",
            "NUM_ENVIADOS_CLIENTE",
            "NUM_ENVIADOS_CONTRATAR",
            "NUM_P_CONTRATADAS",
            "VACANTES_PENDIENTES",
            "NUM_DIAS_ABIERTA",
            "TIEMPO_RESPUESTA_DIAS",
        ];
        $campos = [
            "num_requerimiento",
            "num_req_cliente",
            "fecha_requerimiento",
            "hora_requerimiento",
            "nombre_cliente",
            "ciudad_requerimiento",
            "centro_costo_produccion",
            "nombre_solicitante",
            "motivo_requerimiento",
            "num_vacantes",
            "cargo_generico",
            "cargo_cliente",
            "estado_requerimiento",
            "num_asociados",
            "num_enviados_cliente",
            "num_enviados_contratar",
            "num_p_contratadas",
            "vacantes_pendientes",
            "num_dias_abierta",
            "tiempo_respuesta_dias",
        ];

        return view("admin.reportes.reporte_candidato", compact(
            "data",
            "headers",
            "campos",
            "clientes",
            "motivo_req",
            "estado_req",
            "empresas",
            "ciudad_req",
            "gestiono"
        ));
    }

    public function reporte_candidato_excel(Request $request)
    {
        //dd($data->get('empresa'));
        $headers = [
            "NUM_REQUERIMIENTO",
            "NUM_REQ_CLIENTE",
            "FECHA_REQUERIMIENTO",
            "HORA_REQUERIMIENTO",
            "NOMBRE_CLIENTE",
            "CIUDAD_REQUERIMIENTO",
            "CENTRO_COSTO_PRODUCCION",
            "NOMBRE_SOLICITANTE",
            "MOTIVO_REQUERIMIENTO",
            "NUM_VACANTES",
            "CARGO_GENERICO",
            "CARGO_CLIENTE",
            "ESTADO_REQUERIMIENTO",
            "NUM_ASOCIADOS",
            "NUM_ENVIADOS_CLIENTE",
            "NUM_ENVIADOS_CONTRATAR",
            "NUM_P_CONTRATADAS",
            "VACANTES_PENDIENTES",
            "NUM_DIAS_ABIERTA",
            "TIEMPO_RESPUESTA_DIAS",
        ];
        $campos = [
            "num_requerimiento",
            "num_req_cliente",
            "fecha_requerimiento",
            "hora_requerimiento",
            "nombre_cliente",
            "ciudad_requerimiento",
            "centro_costo_produccion",
            "nombre_solicitante",
            "motivo_requerimiento",
            "num_vacantes",
            "cargo_generico",
            "cargo_cliente",
            "estado_requerimiento",
            "num_asociados",
            "num_enviados_cliente",
            "num_enviados_contratar",
            "num_p_contratadas",
            "vacantes_pendientes",
            "num_dias_abierta",
            "tiempo_respuesta_dias",
        ];
        $data = DB::table('reporte_candidatos')
            ->where(function ($sql) use ($request) {
                if ($request->get('empresa') != "") {
                    $sql->where("reporte_candidatos.sociedad", $request->get('empresa'));
                }
                if ($request->get('cliente') != "") {
                    $sql->where("reporte_candidatos.cliente_id", $request->get('cliente'));
                }
                if ($request->get('fecha_inicio_req') != "" && $request->get('fecha_fin_req') != "") {
                    $sql->whereBetween("reporte_candidatos.fecha_requerimiento", [$request->get('fecha_inicio_req'), $request->get('fecha_fin_req')]);
                }
                if ($request->get('motivo_requerimiento') != "") {
                    $sql->where("reporte_candidatos.motivo_requerimiento_id", $request->get('motivo_requerimiento'));
                }
                if ($request->get('ciudad_requerimiento') != "") {
                    $sql->where("reporte_candidatos.ciudad_requerimiento", $request->get('ciudad_requerimiento'));
                }
                if ($request->get('estado_requerimiento') != "") {
                    $sql->where("reporte_candidatos.num_estado_requerimiento", $request->get('estado_requerimiento'));
                }
                if ($request->get('fecha_i_cierre_req') != "" && $request->get('fecha_f_cierre_req') != "") {
                    $sql->whereBetween("reporte_candidatos.fecha_cierre", [$request->get('fecha_i_cierre_req'), $request->get('fecha_f_cierre_req')]);
                }
                if ($request->get('gestiono') != "") {
                    $sql->where("reporte_candidatos.usuario_gestion", $request->get('gestiono'));
                }
            })
            ->select('*')
            ->get();
        Excel::create('reporte-excel-gestion', function ($excel) use ($data, $headers, $campos) {
            $excel->setTitle('Reporte Gestion');
            $excel->setCreator('T3RS')
                ->setCompany('T3RS');
            $excel->setDescription('Reporte Gestion');
            $excel->sheet('ReporteGestion', function ($sheet) use ($data, $headers, $campos) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_general', [
                    'data'    => $data,
                    'headers' => $headers,
                    'campos'  => $campos,
                ]);
            });
        })->export(config('conf_aplicacion.FORMATO_REPORTE'));
    }

    //Reporte Contratado
    public function reporte_contratado(Request $request)
    {
        $ciudad_req = DB::table('reporte_contratados')->select("ciudad_req")
            ->distinct()
            ->get();
        $clientes = DB::table('reporte_contratados')
            ->select("cliente_id", "cliente")
            ->distinct()
            ->get();
        $estado_req = DB::table('reporte_contratados')
            ->select('estado_requerimiento')
            ->distinct()
            ->get();
        $headers = [
            "REQUERIMIENTO_ID",
            "NOMBRES",
            "PRIMER_APELLIDO",
            "SEGUNDO_APELLIDO",
            "NUMERO_CONTRATO",
            "FECHA_CONTRATO",
            "ESTADO_CONTRATO",
            "CLIENTE",
            "CIUDAD_REQ",
            "CARGO_GENERICO",
            "CARGO_CLIENTE",
            "ESTADO_REQUERIMIENTO",
            "FECHA_INICIO_VACANTE",
            "FECHA_TENTATIVA_REQ",
            "FECHA_CIERRE",
            "PS_ENVIO_CONTRATAR",
            "FECHA_REQUERIMIENTO",
        ];
        $campos = [
            "requerimiento_id",
            "nombres",
            "primer_apellido",
            "segundo_apellido",
            "numero_contrato",
            "fecha_contrato",
            "estado_contrato",
            "cliente",
            "ciudad_req",
            "cargo_generico",
            "cargo_cliente",
            "estado_requerimiento",
            "fecha_inicio_vacante",
            "fecha_tentativa_req",
            "fecha_cierre",
            "ps_envio_contratar",
            "fecha_requerimiento",
        ];

        $data = DB::table('reporte_contratados')
            ->where(function ($sql) use ($request) {
                if ($request->get('fecha_inicio_con') != "" && $request->get('fecha_fin_con') != "") {
                    $sql->whereBetween("fecha_contrato", [$request->get('fecha_inicio_con'), $request->get('fecha_fin_con')]);
                }
                if ($request->get('ciudad_requerimiento') != "") {
                    $sql->where("ciudad_req", $request->get('ciudad_requerimiento'));
                }
                if ($request->get('cliente') != "") {
                    $sql->where("cliente_id", $request->get('cliente'));
                }
                if ($request->get('estado_requerimiento') != "") {
                    $sql->where("estado_requerimiento", $request->get('estado_requerimiento'));
                }
            })->select('*')->paginate(10);

        return view("admin.reportes.reporte_contratado", compact(
            "data",
            "headers",
            "campos",
            "ciudad_req",
            "clientes",
            "estado_req"
        ));
    }
    public function reporte_contratado_excel(Request $request)
    {
        $headers = [
            "REQUERIMIENTO_ID",
            "NOMBRES",
            "PRIMER_APELLIDO",
            "SEGUNDO_APELLIDO",
            "NUMERO_CONTRATO",
            "FECHA_CONTRATO",
            "ESTADO_CONTRATO",
            "CLIENTE",
            "CIUDAD_REQ",
            "CARGO_GENERICO",
            "CARGO_CLIENTE",
            "ESTADO_REQUERIMIENTO",
            "FECHA_INICIO_VACANTE",
            "FECHA_TENTATIVA_REQ",
            "FECHA_CIERRE",
            "PS_ENVIO_CONTRATAR",
            "FECHA_REQUERIMIENTO",
        ];
        $campos = [
            "requerimiento_id",
            "nombres",
            "primer_apellido",
            "segundo_apellido",
            "numero_contrato",
            "fecha_contrato",
            "estado_contrato",
            "cliente",
            "ciudad_req",
            "cargo_generico",
            "cargo_cliente",
            "estado_requerimiento",
            "fecha_inicio_vacante",
            "fecha_tentativa_req",
            "fecha_cierre",
            "ps_envio_contratar",
            "fecha_requerimiento",
        ];
        $data = DB::table('reporte_contratados')
            ->where(function ($sql) use ($request) {
                if ($request->get('fecha_inicio_con') != "" && $request->get('fecha_fin_con') != "") {
                    $sql->whereBetween("fecha_contrato", [$request->get('fecha_inicio_con'), $request->get('fecha_fin_con')]);
                }
                if ($request->get('ciudad_requerimiento') != "") {
                    $sql->where("ciudad_req", $request->get('ciudad_requerimiento'));
                }
                if ($request->get('cliente') != "") {
                    $sql->where("cliente_id", $request->get('cliente'));
                }
                if ($request->get('estado_requerimiento') != "") {
                    $sql->where("estado_requerimiento", $request->get('estado_requerimiento'));
                }
            })->select('*')->get();
        Excel::create('reporte-excel-contratados', function ($excel) use ($data, $headers, $campos) {
            $excel->setTitle('Reporte Contratados');
            $excel->setCreator('T3RS')
                ->setCompany('T3RS');
            $excel->setDescription('Reporte Contratados');
            $excel->sheet('ReporteContratados', function ($sheet) use ($data, $headers, $campos) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_general', [
                    'data'    => $data,
                    'headers' => $headers,
                    'campos'  => $campos,
                ]);
            });
        })->export(config('conf_aplicacion.FORMATO_REPORTE'));
    }
    //Reporte Aplicaci贸n de Ofertas
    public function reporte_aplica_oferta(Request $request)
    {
        $estado_req = DB::table('reporte_aplicacion_ofertas')
            ->select('estado_requerimiento')
            ->distinct()
            ->get();
        $headers = [
            "FECHA_APLICACION",
            "REQUERIMIENTO_ID",
            "CLIENTE",
            "ESTADO_REQUERIMIENTO",
            "CARGO_CLIENTE",
            "CEDULA",
            "NOMBRES",
            "PRIMER_APELLIDO",
            "SEGUNDO_APELLIDO",
            "EMAIL",
            "TELEFONO_FIJO",
            "TELEFONO_MOVIL",
            "DIRECCION",
            "T_CIUDAD_RESIDENCIA",
        ];
        $campos = [
            "fecha_aplicacion",
            "requerimiento_id",
            "cliente",
            "estado_requerimiento",
            "cargo_cliente",
            "cedula",
            "nombres",
            "primer_apellido",
            "segundo_apellido",
            "email",
            "telefono_fijo",
            "telefono_movil",
            "direccion",
            "t_ciudad_residencia",
        ];

        $data = DB::table('reporte_aplicacion_ofertas')
            ->where(function ($sql) use ($request) {
                if ($request->get('estado_requerimiento') != "") {
                    $sql->where("estado_requerimiento", $request->get('estado_requerimiento'));
                }
                if ($request->get('fecha_inicio_req') != "" && $request->get('fecha_fin_req') != "") {
                    $sql->whereBetween("fecha_aplicacion", [$request->get('fecha_inicio_req'), $request->get('fecha_fin_req')]);
                }
            })
            ->select('*')
            ->paginate(10);

        return view("admin.reportes.reporte_aplicaron_oferta", compact(
            "data",
            "headers",
            "campos",
            "estado_req"
        ));
    }
    public function reporte_aplica_oferta_excel(Request $request)
    {

        $headers = [
            "FECHA_APLICACION",
            "REQUERIMIENTO_ID",
            "CLIENTE",
            "ESTADO_REQUERIMIENTO",
            "CARGO_CLIENTE",
            "CEDULA",
            "NOMBRES",
            "PRIMER_APELLIDO",
            "SEGUNDO_APELLIDO",
            "EMAIL",
            "TELEFONO_FIJO",
            "TELEFONO_MOVIL",
            "DIRECCION",
            "T_CIUDAD_RESIDENCIA",
        ];
        $campos = [
            "fecha_aplicacion",
            "requerimiento_id",
            "cliente",
            "estado_requerimiento",
            "cargo_cliente",
            "cedula",
            "nombres",
            "primer_apellido",
            "segundo_apellido",
            "email",
            "telefono_fijo",
            "telefono_movil",
            "direccion",
            "t_ciudad_residencia",
        ];

        $data = DB::table('reporte_aplicacion_ofertas')
            ->where(function ($sql) use ($request) {
                if ($request->get('estado_requerimiento') != "") {
                    $sql->where("estado_requerimiento", $request->get('estado_requerimiento'));
                }
                if ($request->get('fecha_inicio_req') != "" && $request->get('fecha_fin_req') != "") {
                    $sql->whereBetween("fecha_aplicacion", [$request->get('fecha_inicio_req'), $request->get('fecha_fin_req')]);
                }
            })
            ->select('*')
            ->get();
        Excel::create('reporte-excel-aplicaron', function ($excel) use ($data, $headers, $campos) {
            $excel->setTitle('Reporte Aplicaron');
            $excel->setCreator('T3RS')
                ->setCompany('T3RS');
            $excel->setDescription('Reporte Aplicaron');
            $excel->sheet('ReporteAplicaron', function ($sheet) use ($data, $headers, $campos) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_general', [
                    'data'    => $data,
                    'headers' => $headers,
                    'campos'  => $campos,
                ]);
            });
        })->export(config('conf_aplicacion.FORMATO_REPORTE'));
    }

      

    public function reportesDetallesTempo(Request $request)
    {
         
        $clientes  = ["" => "Seleccionar"] + Clientes::join('negocio', 'negocio.cliente_id', '=', 'clientes.id')
            ->join('requerimientos','negocio.id','=','requerimientos.negocio_id')
            ->where('requerimientos.solicitado_por', $this->user->id)
            ->orderBy('clientes.nombre')
            ->pluck("clientes.nombre", "clientes.id")
            ->toArray();

           $Año_req =["" => "Seleccionar"] + Requerimiento::
            join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            ->where('requerimientos.solicitado_por',$this->user->id)
            ->select(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y\') as fecha_creacion'))
            ->pluck("fecha_creacion", "fecha_creacion")
            ->toArray();

           $Año_tenta_req =["" => "Seleccionar"] + Requerimiento::
            join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            ->where('requerimientos.solicitado_por',$this->user->id)
            ->select(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req , \'%Y\') as fecha_tentativa'))
            ->pluck("fecha_tentativa", "fecha_tentativa")
            ->toArray();

            if(route("home")=="https://gpc.t3rsc.co"){
             $usuarios=["" => "- Seleccionar -"]+User::pluck("users.name", "users.id")->toArray();

            }
            else{
            $usuarios=["" => "- Seleccionar -"]+User::join("role_users","users.id","=","role_users.user_id")
                    ->whereIn("role_users.role_id",[4,7])
                    ->pluck("users.name", "users.id")->toArray();

            }

       
       
        $numero_req_estado_tempo = DB::table('requerimientos')
        ->join('requerimientos_estados','requerimientos.id','=','requerimientos_estados.req_id')
         ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            //->where('requerimientos.solicitado_por',$this->user->id)
        ->where('requerimientos_estados.max_estado',2)
        ->select('requerimientos.id')
          ->where(function ($where) use ($request) {
              if ( $request->get('cliente_id') != "") {
                    $where->where("requerimientos_estados.cliente_id",$request->get('cliente_id'));
                }
                     
                    if ($request->get("mes_creacion") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.created_at, \'%m\') = '.$request->get("mes_creacion"));
                    }
                     if ($request->get("mes_tentativo") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%m\') = '.$request->get("mes_tentativo"));
                    }

                    if ($request->get("Año_req") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.created_at, \'%Y\') = '.$request->get("Año_req"));
                    }

                    if ($request->get("Año_tenta_req") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y\') = '.$request->get("Año_tenta_req"));
                    }
                     if ($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                    }

                    if ($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$request->get('fecha_tenta_ini'),$request->get('fecha_tenta_fin')]);
                    }
                 })
        ->count();

        $numero_vacantes_contra = DB::table('requerimientos')
        ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
         ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
           // ->where('requerimientos.solicitado_por',$this->user->id)
       ->select( "requerimientos.id as req_id",DB::raw('(select count(*) as cantidad from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'))
              ->where(function ($where) use ($request) {

                 if ( $request->get('cliente_id') != "") {
                    $where->where("requerimientos_estados.cliente_id",$request->get('cliente_id'));
                }
                     
                    if ($request->get("mes_creacion") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.created_at, \'%m\') = '.$request->get("mes_creacion"));
                    }
                     if ($request->get("mes_tentativo") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%m\') = '.$request->get("mes_tentativo"));
                    }

                    if ($request->get("Año_req") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.created_at, \'%Y\') = '.$request->get("Año_req"));
                    }

                    if ($request->get("Año_tenta_req") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y\') = '.$request->get("Año_tenta_req"));
                    }
                     if ($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                    }

                    if ($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$request->get('fecha_tenta_ini'),$request->get('fecha_tenta_fin')]);
                    }
                 })
            ->get();

            $candidatos_contratados = 0;
            foreach ($numero_vacantes_contra as $key => $value) {
                $candidatos_contratados = $candidatos_contratados + $value->cant_enviados_contratacion;
            }

            $numero_vacantes = Requerimiento::
                join("requerimientos_estados","requerimientos_estados.req_id","=","requerimientos.id")
                ->whereIn("requerimientos_estados.max_estado", [
                           
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_CLIENTE'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),

                        ])
               ->where(function ($where) use ($request) {
               if ( $request->get('cliente_id') != "") {
                    $where->where("requerimientos_estados.cliente_id",$request->get('cliente_id'));
                }  
                    if ($request->get("mes_creacion") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.created_at, \'%m\') = '.$request->get("mes_creacion"));
                    }
                     if ($request->get("mes_tentativo") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%m\') = '.$request->get("mes_tentativo"));
                    }

                    if ($request->get("Año_req") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.created_at, \'%Y\') = '.$request->get("Año_req"));
                    }

                    if ($request->get("Año_tenta_req") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y\') = '.$request->get("Año_tenta_req"));
                    }
                     if ($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                    }

                    if ($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$request->get('fecha_tenta_ini'),$request->get('fecha_tenta_fin')]);
                    }
                 })
                ->select(\DB::raw("SUM(requerimientos.num_vacantes) as numero_vac "))
                ->first();

        $numero_req_estado_cliente = DB::table('requerimientos')
        ->join('requerimientos_estados','requerimientos.id','=','requerimientos_estados.req_id')
         ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            //->where('requerimientos.solicitado_por',$this->user->id)
        ->where('requerimientos_estados.max_estado',1)
        ->select('requerimientos.id')
          ->where(function ($where) use ($request) {
             if ( $request->get('cliente_id') != "") {
                    $where->where("requerimientos_estados.cliente_id",$request->get('cliente_id'));
                }
                     
                    if ($request->get("mes_creacion") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.created_at, \'%m\') = '.$request->get("mes_creacion"));
                    }
                     if ($request->get("mes_tentativo") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%m\') = '.$request->get("mes_tentativo"));
                    }

                    if ($request->get("Año_req") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.created_at, \'%Y\') = '.$request->get("Año_req"));
                    }

                    if ($request->get("Año_tenta_req") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y\') = '.$request->get("Año_tenta_req"));
                    }
                     if ($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                    }

                    if ($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$request->get('fecha_tenta_ini'),$request->get('fecha_tenta_fin')]);
                    }
                 })
        ->count();
        
         
        $headerss  = $this->getHeaderDetalleTempo();
        $data      = $this->getDataDetalleTempo($request);
        //$hv_count = $this->getDataDetalleMine($request);

        return view('admin.reportes.reporte_tempo')->with([
            'data'       => $data,
            'clientes'   => $clientes,
            'Año_req'    => $Año_req,
            'Año_tenta_req' => $Año_tenta_req,
            'candidatos_contratados' => $candidatos_contratados,
            'numero_vacantes_contra' => $numero_vacantes_contra,
            'numero_vacantes'        => $numero_vacantes,
            'numero_req_estado_tempo' => $numero_req_estado_tempo,
            'numero_req_estado_cliente' => $numero_req_estado_cliente,
            'headerss'   => $headerss,
            'usuarios'   => $usuarios,
        ]);
    }

    public function reportesDetallesTempoExcel(Request $request)
    {
        $headerss = $this->getHeaderDetalleTempo();
        $data    = $this->getDataDetalleTempo($request);
       // $hv_count = $this->getDataDetalleMine($request);

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        $formato = $request->formato;
        Excel::create('reporte-excel-tempo', function ($excel) use ($data, $headerss, $formato) {
            $excel->setTitle('Reporte Detalle Tempo');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Tempo');
            $excel->sheet('Reporte Tempo', function ($sheet) use ($data, $headerss, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_tempo', [
                    'data'    => $data,
                    'headerss' => $headerss,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

     private function getHeaderDetalleTempo()
    {

        $headerss = [
            'N° de requerimiento',
            'Estado Requerimiento',
            'Fecha creación',
            'Fecha tentativa',
            'Vacantes contratadas',
            'Vacantes solicitadas',
            'Tiempo de entrega de terna efectiva',
            'N° personas enviadas a entrevistas',
            'N° personas presentadas en entrevista',
            'N° personas aprobadas en entrevistas',
            'N° personas que no fueron a entrevistas',
            'Tiempo respuesta del cliente',
            "-",
            
        ];
        return $headerss;
    }

    private function getDataDetalleTempo($request)
    {

        $fecha_inicio = $request->fecha_inicio;
        $fecha_final  = $request->fecha_final;
        $cliente_id   = $request->cliente_id;
        $criterio     = $request->criterio;
        $usuario_gestion = $request->usuario_gestion;
        $formato      = ($request->has('formato')) ? $request->formato : 'html';
        //dd($formato);
        // Data

    $user_sesion = $this->user;
    
    if ($user_sesion->hasAccess("admin.reporte_rendimiento_admin")) {
        
        $data = Requerimiento::join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
            //->where('requerimientos.solicitado_por',$this->user->id)
            ->select(
                'requerimientos.id as requerimiento_id',
                'requerimientos.num_vacantes as vacantes_solicitadas',
                 DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req , \'%Y-%m-%d\') as fecha_tentativa'),
                 DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_creacion'),
                 DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                  DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion')
            )->where(function ($where) use ($request) {

                  //dd($request->get('cliente_id'));
                if( $request->get('cliente_id') != "") {
                    $where->where("requerimientos_estados.cliente_id",$request->get('cliente_id'));
                }
                    if ($request->get("mes_creacion") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.created_at, \'%m\') = '.$request->get("mes_creacion"));
                    }
                     if ($request->get("mes_tentativo") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%m\') = '.$request->get("mes_tentativo"));
                    }

                    if($request->get("Año_req") != "") {
                      //dd($request->get("Año_req"));
                     $where->whereRaw('DATE_FORMAT(requerimientos.created_at, \'%Y\') = '.$request->get("Año_req"));
                    }
                    
                    if($request->get("usuario_gestion") != "") {
                      //dd($request->get("Año_req"));
                     $where->where("estados_requerimiento.user_gestion",$request->get("usuario_gestion"));
                    }

                    if($request->get("Año_tenta_req") != "") {
                      
                      $where->whereRaw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y\') = '.$request->get("Año_tenta_req"));
                    }

                    if($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != ""){

                      $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                    }

                    if($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {
                      
                      $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$request->get('fecha_tenta_ini'),$request->get('fecha_tenta_fin')]);
                    }
                 })
                ->where(function ($query) use ($request) {
                    if($request->cliente_id == '' || $request->cliente_id == null) {
                        $ids_clientes_prueba = [];
                        if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                            $query->whereNotIn("requerimientos_estados.cliente_id", $ids_clientes_prueba);
                        }
                    }
                })
             ->groupBy('requerimientos.id')
            ->orderBy('requerimientos.id','desc') ;

           // dd($data);
    //dd($data->toSql());
        if ($request->has('formato') and ($formato == "xlsx" || $formato == "pdf")) {
          
          $data = $data->get();

        }else{

          $data = $data->paginate(5);
        }

        return $data;

    }else{

         $data = Requerimiento::join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
         ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            ->where('requerimientos.solicitado_por',$this->user->id)
            ->select(
                'requerimientos.id as requerimiento_id',
                'requerimientos.num_vacantes as vacantes_solicitadas',         
                 DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req , \'%Y-%m-%d\') as fecha_tentativa'),
                 DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_creacion'),
                 DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                  DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion')
                 
            )
              ->where(function ($where) use ($request) {

                  //dd($request->get('cliente_id'));
               if ( $request->get('cliente_id') != "") {
                    $where->where("requerimientos_estados.cliente_id",$request->get('cliente_id'));
                }
                     
                    if ($request->get("mes_creacion") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.created_at, \'%m\') = '.$request->get("mes_creacion"));
                    }
                     if ($request->get("mes_tentativo") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%m\') = '.$request->get("mes_tentativo"));
                    }

                    if ($request->get("Año_req") != "") {
                      //dd($request->get("Año_req"));
                        $where->whereRaw('DATE_FORMAT(requerimientos.created_at, \'%Y\') = '.$request->get("Año_req"));
                    }

                    if ($request->get("Año_tenta_req") != "") {
                      
                        $where->whereRaw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y\') = '.$request->get("Año_tenta_req"));
                    }
                     if ($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                    }

                    if ($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$request->get('fecha_tenta_ini'),$request->get('fecha_tenta_fin')]);
                    }
                 })
             ->groupBy('requerimientos.id')
            ->orderBy('requerimientos.id','desc');
          
           // dd($data);
    //dd($data->toSql());
        if ($request->has('formato') and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
        } else {
            $data = $data->paginate(5);
        }

        return $data;

    }
  
}

    public function reportesLlamadas(Request $request)
    {
        $generos = ["" => "Seleccionar"] + Genero::pluck("generos.descripcion", "generos.id")->toArray();

        $requerimientos = ["" => "seleccionar"] + Requerimiento::join('cargos_especificos','cargos_especificos.id','=','requerimientos.cargo_especifico_id')
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

        $sitio = Sitio::first();

        if(route("home") == "https://gpc.t3rsc.co"){
            $usuarios = ["" => "Seleccionar"] + User::join('estados_requerimiento','estados_requerimiento.user_gestion','=','users.id')
            ->pluck("users.name", "users.id")
            ->toArray();
        }
        else{
            $usuarios = ["" => "- Seleccionar -"] + User::join("role_users","users.id","=","role_users.user_id")
            ->whereIn("role_users.role_id",[4,7])
            ->pluck("users.name", "users.id")
            ->toArray();
        }
        
        $headerss  = $this->getHeaderDetalleLlamada();
        $data      = $this->getDetalleLlamada($request);

        return view('admin.reportes.reporte_llamada')->with([
            'requerimientos' => $requerimientos,
            'data'           => $data,
            'generos'        => $generos,
            'sitio'          => $sitio,
            'headerss'       => $headerss,
            'usuarios'       => $usuarios,
        ]);
    }

    public function reportesLlamadaExcel(Request $request)
    {
        $request->formato = 'xlsx';

        $headerss = $this->getHeaderDetalleLlamada();
        $data    = $this->getDetalleLlamada($request);

        $funcionesGlobales = new FuncionesGlobales();

        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        //$formato = $request->formato;
        $formato = 'xlsx';

        $sitio = Sitio::first();

        Excel::create('reporte-excel-llamadas', function ($excel) use ($sitio,$data, $headerss, $formato) {
            $excel->setTitle('Reporte Detalle Llamadas');
            $excel->setCreator('$nombre')
            ->setCompany('$nombre');

            $excel->setDescription('Reporte Detalles Llamadas');

            $excel->sheet('Reporte Llamadas', function ($sheet) use ($sitio,$data, $headerss, $formato) {
                $sheet->setOrientation("landscape");

                $sheet->loadView('admin.reportes.includes.grilla_detalle_llamada', [
                    'data'     => $data,
                    'sitio'    => $sitio,
                    'headerss' => $headerss,
                    'formato'  => $formato,
                ]);
            });
        })->export($formato);
    }

    private function getHeaderDetalleLlamada()
    {

        $headerss = [
            'Requerimiento',
            'Nombre Cliente',
            'Cargo Requerimiento',
            'Estado Requerimiento',
            'Fecha y hora de llamada',
            'N° de cédula',
            'Nombre y apellido del Candidato',
            'Teléfono Móvil',
            'Email',
            'Ciudad de Residencia',
            'Estado candidato',
            'Usuario quien realizó la llamada',
             '-',
             '-',
             '-',
            
        ];
        return $headerss;
    }

    private function getDetalleLlamada(Request $request)
    {
        $formato = ($request->has('formato')) ? $request->formato : 'html';
        
        if ($request->get('req_id')!= '' || $request->get('estado_candidato')!= '' || $request->get("ciudad_id") != '' ||
            $request->get("departamento_id") != ''|| $request->get("estado_requerimiento") != '' || $request["usuario_gestion"] != ''){
           
            $data = LlamadaMensaje::join('datos_basicos','datos_basicos.numero_id','=','llamada_mensaje.numero_id')
            ->leftjoin('ciudad', function ($join) {
                $join->on('datos_basicos.ciudad_residencia', '=', 'ciudad.cod_ciudad')
                    ->on('datos_basicos.departamento_residencia', '=', 'ciudad.cod_departamento')
                    ->on('datos_basicos.pais_residencia', '=', 'ciudad.cod_pais');
            })
            ->leftjoin('departamentos', function ($join2) {
                $join2->on('datos_basicos.departamento_residencia', '=', 'departamentos.cod_departamento')
                ->on('datos_basicos.pais_residencia', '=', 'departamentos.cod_pais');
            })
            ->leftjoin('paises', 'datos_basicos.pais_residencia', '=', 'paises.cod_pais')
            ->join('requerimientos','requerimientos.id','=','llamada_mensaje.req_id')
            ->join('estados_requerimiento','estados_requerimiento.req_id','=','requerimientos.id')
            ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
            ->join('estados','datos_basicos.estado_reclutamiento','=','estados.id')
            ->select(
                'llamada_mensaje.created_at as fecha_llamada',
                'llamada_mensaje.tipo_mensaje',
                "cargos_especificos.descripcion as cargo",
                "clientes.nombre as nombre_cliente",
                'requerimientos.id as req_id',
                'datos_basicos.user_id as user_asistencia_id',
                'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                'datos_basicos.numero_id as cedula',
                'datos_basicos.nombres as nombres',
                'datos_basicos.primer_apellido as primer_apellido',
                'datos_basicos.segundo_apellido as segundo_apellido',
                'ciudad.nombre as ciudad',
                'datos_basicos.telefono_movil as celular',
                'datos_basicos.email as email',
                'estados.descripcion as estado_candidato',
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                DB::raw('upper(users.name) as usuario_cargo_req'
            ))
            ->groupBy("llamada_mensaje.id")
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where(function ($where) use ($request) {
                if($request->get('req_id')!=""){
                    $where->where("llamada_mensaje.req_id" , $request->get('req_id'));
                }

                if($request->get('estado_candidato')!=""){
                    $where->where("estados.descripcion" , $request->get('estado_candidato'));
                }

                if($request->get('estado_requerimiento')!=""){
                    $where->whereRaw(DB::raw("(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 )  = '".$request->get('estado_requerimiento')."'"));
                }
                     
                if($request->get("ciudad_id") != "") {
                    $where->where("datos_basicos.ciudad_residencia", $request->get("ciudad_id"));
                }

                if($request->get("departamento_id") != "") {
                    $where->where("datos_basicos.departamento_residencia", $request->get("departamento_id"));
                }

                if($request["usuario_gestion"] != "") {
                    $where->where("estados_requerimiento.user_gestion",$request->get("usuario_gestion"));
                }
            })
            ->where(function ($query){
                $ids_clientes_prueba = [];
                if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                    $query->whereNotIn("clientes.id", $ids_clientes_prueba);
                }
            });

            if ($request->has('formato') and ($formato == "xlsx" || $formato == "pdf")) {
                $data = $data->get();
            } else {
                $data = $data->paginate(5);
            }

            return $data;
        }
    }

    //Vista asistencias
    public function reportesAsistencias(Request $request)
    {
        $req_id = $request->req_id;
        
        $generos = ["" => "Seleccionar"] + Genero::pluck("generos.descripcion", "generos.id")->toArray();
        
        $usuarios = ["" => "- Seleccionar -"] + User::join("role_users","users.id","=","role_users.user_id")
            ->whereIn("role_users.role_id",[4,7])
            ->pluck("users.name", "users.id")->toArray();


        $sitio = Sitio::first();
         $agencias = [];

         if( $sitio->agencias ){
            $agencias= ["" => "Seleccionar"] + Agencia::pluck("agencias.descripcion", "agencias.id")->toArray();
         }

        $headerss  = $this->getHeaderDetalleAsistencia();
        $data      = $this->getDataDetalleAsistencia($request);

        return view('admin.reportes.reporte_asistencia')->with([
            'data'       => $data,
            'generos'    => $generos,
            'req_id'     => $req_id,
            'sitio'      => $sitio,
            'headerss'   => $headerss,
            'usuarios'   => $usuarios,
            'agencias'   => $agencias
        ]);
    }

    //Exporta a excel asistencia
    public function reportesAsistenciaExcel(Request $request)
    {
        $headerss = $this->getHeaderDetalleAsistencia();
        $data    = $this->getDataDetalleAsistencia($request);

        $funcionesGlobales = new FuncionesGlobales();

        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        $formato = $request->formato;

        $sitio = Sitio::first();

        Excel::create('reporte-excel-asistencia', function ($excel) use ($sitio, $data, $headerss, $formato) {
            $excel->setTitle('Reporte Detalle Asistencia');
            
            $excel->setCreator('$nombre')->setCompany('$nombre');

            $excel->setDescription('Reporte Detalles Asistencia');

            $excel->sheet('Reporte asistencia', function ($sheet) use ($sitio, $data, $headerss, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_asistencia', [
                    'data'    => $data,
                    'sitio'   => $sitio,
                    'headerss' => $headerss,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    private function getHeaderDetalleAsistencia()
    {
        if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
            $headerss = [
               'Requerimiento',
               'Nombre Cliente',
               'Cargo Requerimiento',
               'Estado Requerimiento',
               'Tipo Mensaje Enviado',
               'Fecha y hora de llamada',
               'Fecha y hora de respuesta',
               '¿Asistirá?',
               'N° de cédula',
               'Nombre y apellido del Candidato',
               'Teléfono Móvil',
               'Email',
               'Ciudad de Residencia',
               'Estado candidato',
               'Usuario quien realizó la llamada',
               'Acciones',
               '-',
               '-',
               '-',
            ];
        }else{
            $headerss = [
                'Requerimiento',
                'Nombre Cliente',
                'Cargo Requerimiento',
                'Estado Requerimiento',
                'Fecha y hora de llamada',
                'Fecha y hora de respuesta',
                '¿Asistirá?',
                'N° de cédula',
                'Nombre y apellido del Candidato',
                'Teléfono Móvil',
                'Email',
                'Ciudad de Residencia',
                'Estado candidato',
                'Usuario quien realizó la llamada',
                'Contenido',
                'Acciones',
                '-',
                '-',
                '-',
            ];
        }

        return $headerss;
    }

    private function getDataDetalleAsistencia(Request $request)
    {        
        $formato = ($request['formato']) ? $request['formato'] : 'html';
        
        $fecha_inicio = '';
        $fecha_final = '';

        $rango = "";
        if($request['rango_fecha'] != ""){
            $rango = explode(" | ", $request['rango_fecha']);
            $fecha_inicio = $rango[0];
            $fecha_final  = $rango[1];
        }

        if ($request['req_id'] != '' || $request['estado_candidato'] != '' || $request["ciudad_id"] != '' ||
            $request["departamento_id"] != '' || $request["estado_requerimiento"] != '' || $request["usuario_gestion"] != '' || 
            $fecha_inicio != '' || $fecha_final != '' || $request['agencia']){
           
            $data = LlamadaMensaje::join('datos_basicos','datos_basicos.numero_id','=','llamada_mensaje.numero_id')
            ->join('requerimientos','requerimientos.id','=','llamada_mensaje.req_id')
            ->leftjoin('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
            ->leftjoin('asistencia','asistencia.llamada_id','=','llamada_mensaje.id')
            ->join('estados','datos_basicos.estado_reclutamiento','=','estados.id')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->select(
                'asistencia.asistencia',
                'asistencia.created_at as fecha_hora_asistencia',
                'llamada_mensaje.created_at as fecha_llamada',
                'llamada_mensaje.content_msg as contenido_sms',
                "cargos_especificos.descripcion as cargo",
                "clientes.nombre as nombre_cliente",
                'requerimientos.id as req_id',
                'datos_basicos.user_id as user_asistencia_id',
                'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                'datos_basicos.numero_id as cedula',
                'datos_basicos.nombres as nombres',
                'datos_basicos.primer_apellido as primer_apellido',
                'datos_basicos.segundo_apellido as segundo_apellido',
                DB::raw('(SELECT ciudad.nombre FROM ciudad WHERE ciudad.cod_pais = datos_basicos.pais_residencia 
                AND ciudad.cod_departamento = datos_basicos.departamento_residencia AND ciudad.cod_ciudad = datos_basicos.ciudad_residencia LIMIT 1) as ciudad'),
                'datos_basicos.telefono_movil as celular',
                'datos_basicos.email as email',
                'estados.descripcion as estado_candidato',
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                DB::raw('upper(users.name) as usuario_cargo_req'
            ))
            ->groupBy("llamada_mensaje.id")
            ->where(function ($where) use ($request, $fecha_inicio, $fecha_final) {

                if ($fecha_inicio != "" && $fecha_final != "") {
                    $where->whereBetween("llamada_mensaje.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }

                if($request['req_id'] !=""){
                    $where->where("llamada_mensaje.req_id" , $request['req_id']);
                }
                
                if($request['estado_candidato'] != "") {
                    $where->where("estados.descripcion" , $request['estado_candidato']);
                }

                if($request['estado_requerimiento'] != ""){
                    $where->whereRaw(DB::raw("(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 )  = '".$request['estado_requerimiento']."'"));
                }
                 
                if($request["ciudad_id"] != "") {
                    $where->where("datos_basicos.ciudad_residencia", $request["ciudad_id"]);
                }

                if($request["departamento_id"] != "") {
                  
                  $where->where("datos_basicos.departamento_residencia", $request["departamento_id"]);
                }

                if($request["usuario_gestion"] != ""){
                  
                  $where->where("estados_requerimiento.user_gestion",$request["usuario_gestion"]);
                }

                if( $request["agencia"] != "" ) {
                    $where->where("ciudad.agencia", $request["agencia"]);
                }

            })
            ->where(function ($query) {
                $ids_clientes_prueba = [];
                if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                    $query->whereNotIn("clientes.id", $ids_clientes_prueba);
                }
            });

            if ($formato == "xlsx" || $formato == "pdf") {
                $data = $data->get();
            } else {
                $data = $data->orderBy('req_id', 'desc')->paginate(5);
            }
                
            return $data;
        }
    }


    public function reportesDetallesCandi(Request $request)
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
            
        $user_sesion = $this->user;
        $sitio = Sitio::first();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $usuarios=["" => "Seleccionar"] + User::join('estados_requerimiento','estados_requerimiento.user_gestion','=','users.id')
            ->pluck("users.name", "users.id")->toArray();

        }else{
        
        $usuarios=["" => "- Seleccionar -"]+User::join("role_users","users.id","=","role_users.user_id")
        ->whereIn("role_users.role_id",[4,7])
        ->pluck("users.name", "users.id")->toArray();

        }
       
        //dd($this->user->id);
        $user_sesion = $this->user;
         
        $headerss  = $this->getHeaderDetalleCandi();
        $data      = $this->getDataDetalleCandi($request);

        return view('admin.reportes.reporte_candi')->with([
            'user_sesion' => $user_sesion,
            'data'        => $data,
            'requerimientos' => $requerimientos,
            'sitio'      => $sitio,
            'headerss'   => $headerss,
            'usuarios'   => $usuarios,
        ]);
    }

    public function reportesDetallesCandiExcel(Request $request)
    {
        
       $user_sesion = $this->user;
        $headerss = $this->getHeaderDetalleCandi();
        $data    = $this->getDataDetalleCandi($request);

        $formato = $request->formato;
      $sitio = Sitio::first();
        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-fdf-detalle-candidatos', function ($excel) use ($sitio,$user_sesion,$data, $headerss, $formato) {
            $excel->setTitle('Reporte Detalle Candidatos');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Candidatos');
            $excel->sheet('Reporte Detalle Candidatos', function ($sheet) use ($sitio,$user_sesion,$data, $headerss, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_candi', [
                    'sitio' =>$sitio,
                     'user_sesion'         =>$user_sesion,
                    'data'    => $data,
                    'headerss' => $headerss,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    private function getHeaderDetalleCandi()
    {

      if( route("home") != "https://gpc.t3rsc.co"){

        $headerss = [
            'N° de cédula',
            'Nombre Completo',
            '%HV',
            'Sexo',
            'Edad',
            'Nivel Estudio',
            'Estado Civil',
            'Telefóno Movil',
            'Correo',
            'Dirección',
            'Ciudad de Residencia',
            'EPS',
            'AFP',
            'Estado candidato',
            'Método Carga',
            'Acción'           
        ];

      }else{

        $headerss = [
            'N° de cédula',
            'Nombre Completo',
            '%HV',
            'Sexo',
            'Edad',
            'Nivel Estudio',
            'Estado Civil',
            'Telefóno Movil',
            'Correo',
            'Ciudad de Residencia',
            'Método Carga',
            'Acción'   
        ];
       }

        return $headerss;
    }

    private function getDataDetalleCandi($request)
    {
        $formato  = ($request->has('formato')) ? $request->formato : 'html';

        $sitio = Sitio::first();
        
        if($request->req_id != '' || $request->usuario_gestion != ''  ){
           
            $data = DB::table('users')
            ->join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
            ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimiento_cantidato.requerimiento_id")
            ->join('datos_basicos','datos_basicos.user_id','=','users.id')
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->leftjoin("estudios","estudios.user_id","=","users.id")
            ->leftjoin("paises","paises.cod_pais","=","datos_basicos.pais_residencia")
            ->leftjoin("estados","estados.id","=","requerimiento_cantidato.estado_candidato")
            ->leftjoin("departamentos", function ($join) {
              $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
              $join->on("departamentos.cod_departamento", "=", "datos_basicos.departamento_residencia");
             })->leftjoin("ciudad", function ($join2) {
              $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
              $join2->on("ciudad.cod_ciudad", "=", "datos_basicos.ciudad_residencia")->on("ciudad.cod_departamento", "=", "datos_basicos.departamento_residencia");
             })
                ->leftjoin('metodo_carga','metodo_carga.id','=','users.metodo_carga')
                ->leftjoin('entrevistas_candidatos','entrevistas_candidatos.candidato_id','=','datos_basicos.user_id')
                ->leftjoin('generos','datos_basicos.genero','=','generos.id')
                ->leftjoin('estados_civiles','estados_civiles.id','=','datos_basicos.estado_civil')
                ->whereRaw(" requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
                ->select(
                    'estados.descripcion as estado_cand',
                    'users.id as usersss_id',
                    'metodo_carga.descripcion as cargado',
                    'entrevistas_candidatos.created_at as fecha_entrevista',
                    'datos_basicos.numero_id as cedula', 
                    'datos_basicos.talla_zapatos as zapatos', 
                    'datos_basicos.talla_pantalon as pantalon', 
                    'datos_basicos.talla_camisa as camisa', 
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.barrio', 
                    'datos_basicos.email',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.datos_basicos_count',
                    'datos_basicos.perfilamiento_count',
                    'datos_basicos.experiencias_count',
                    'datos_basicos.estudios_count',
                    'datos_basicos.referencias_count',
                    'datos_basicos.grupo_familiar_count',
                    'generos.descripcion as genero',
                    'datos_basicos.direccion',
                     DB::raw('DATE_FORMAT(entrevistas_candidatos.created_at,\'%Y-%m-%d\') as fecha_entrevista'),
                    'ciudad.nombre as ciudad',
                    'estados_civiles.descripcion as estado_civil',
                    "entidades_afp.descripcion as entidades_afp_des",
                    "entidades_eps.descripcion as entidades_eps_des",
                    'datos_basicos.telefono_movil as celular',
                    'requerimiento_cantidato.requerimiento_id as requerimiento_id',
                    //DB::raw('(select upper(n.descripcion) from estudios e 
                      //  left join niveles_estudios n on e.nivel_estudio_id=n.id
                      //  where e.user_id = usersss_id 
                      //  order by e.nivel_estudio_id desc limit 1) as escolaridad'),
                     DB::raw('(select upper(n.descripcion) from estudios e 
                         left join niveles_estudios n on e.nivel_estudio_id=n.id
                         where e.user_id = usersss_id 
                         order by e.fecha_finalizacion desc limit 1) as escolaridad'),
                    DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'))
                ->where(function ($where) use ($request) {

                  if($request->usuario_gestion != ""){  
                    $where->where("estados_requerimiento.user_gestion",$request->usuario_gestion);
                  } 

                  if($request->get('req_id')!=""){

                    $where->where("requerimiento_cantidato.requerimiento_id" , $request->get('req_id'));
                  }
                  
                })->groupBy('datos_basicos.numero_id');
                
               //dd($data->get());
            if ($request->has('formato') and ($formato == "xlsx" || $formato == "pdf")) {
                $data = $data->get();
            } else {
                $data = $data->paginate(5);
            }

            return $data;
        }

    }

    //*******************volver a enviar correo de contratacion **********

    public function correo_asignacion(Request $request)
    {
        $user_sesion = $this->user;
           
          if($user_sesion->hasAccess("email_candidato_req")){
            
            $funcionesGlobales = new FuncionesGlobales();

              if(isset($funcionesGlobales->sitio()->nombre)){

               if($funcionesGlobales->sitio()->nombre != "") {
                  $nombre_empresa = $funcionesGlobales->sitio()->nombre;
               }else{
                 $nombre_empresa = "Desarrollo";
               }
              }

            $data = DB::table('users')
             ->join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
             ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimiento_cantidato.requerimiento_id")
             ->join('datos_basicos','datos_basicos.user_id','=','users.id')
             ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
             ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
             ->leftjoin("departamentos", function ($join) {
              //$join->on("paises.cod_pais", "=", "departamentos.cod_pais");
              $join->on("departamentos.cod_departamento", "=", "datos_basicos.departamento_residencia");
             })->leftjoin("ciudad", function ($join2) {
              $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
              $join2->on("ciudad.cod_ciudad", "=", "datos_basicos.ciudad_residencia")->on("ciudad.cod_departamento", "=", "datos_basicos.departamento_residencia");
             })
                ->leftjoin('tipo_fuente','tipo_fuente.id','=','requerimiento_cantidato.otra_fuente')
                ->leftjoin('entrevistas_candidatos','entrevistas_candidatos.candidato_id','=','datos_basicos.user_id')
                ->leftjoin('generos','datos_basicos.genero','=','generos.id')
                ->leftjoin('estados_civiles','estados_civiles.id','=','datos_basicos.estado_civil')
                ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
                ->where("requerimiento_cantidato.requerimiento_id",$request->get("requerimiento_id"))
                ->where("requerimiento_cantidato.candidato_id",$request->get("usuario"))
                ->select(
                    'users.id as usersss_id',
                    'users.usuario_carga as cargado',
                    'entrevistas_candidatos.created_at as fecha_entrevista',
                    'datos_basicos.numero_id as cedula', 
                    'tipo_fuente.descripcion as fuente_reclu', 
                    'datos_basicos.talla_zapatos as zapatos', 
                    'datos_basicos.talla_pantalon as pantalon', 
                    'datos_basicos.talla_camisa as camisa', 
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.barrio', 
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.email',
                    'datos_basicos.datos_basicos_count',
                    'datos_basicos.perfilamiento_count',
                    'datos_basicos.experiencias_count',
                    'datos_basicos.estudios_count',
                    'datos_basicos.referencias_count',
                    'datos_basicos.grupo_familiar_count',
                    'generos.descripcion as genero',
                     DB::raw('DATE_FORMAT(entrevistas_candidatos.created_at,\'%Y-%m-%d\') as fecha_entrevista'),
                    //'ciudad.nombre as ciudad',
                    'estados_civiles.descripcion as estado_civil',
                    "entidades_afp.descripcion as entidades_afp_des",
                    "entidades_eps.descripcion as entidades_eps_des",
                    'datos_basicos.telefono_movil as celular',
                    'requerimiento_cantidato.requerimiento_id as requerimiento_id',
                    //DB::raw('(select upper(n.descripcion) from estudios e 
                    //    left join niveles_estudios n on e.nivel_estudio_id=n.id
                    //    where e.user_id = usersss_id 
                    //    order by e.nivel_estudio_id desc limit 1) as escolaridad'),
                    DB::raw('(select upper(niveles_estudios.descripcion) from estudios e 
                        left join niveles_estudios on e.nivel_estudio_id = niveles_estudios.id
                        where e.user_id = usersss_id order by e.fecha_finalizacion desc limit 1) as escolaridad'),
                    DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'))
                    ->first();
                                             
                                                                    $home = route('home');

                                                                    $urls = route('home.detalle_oferta', ['oferta_id' => $request->get("requerimiento_id")]);

                                                                    $req_can_id = $data->requerimiento_id;

                                                                    $nombres = $data->nombres;

                                                                    $nombre = ucwords(strtolower($nombres));
                                            
                                                                    $asunto = "Notificación de proceso de selección";

                                                                    if($data->email){
                                                                        $emails = $data->email;
                                                                    }else{
                                                                        $emails = false;
                                                                    }

                                                                    $mensaje = "Buen día ".$nombre.",
                                                                        has sido elegido para realizar un proceso de selección con nosotros! por favor haz clic en siguiente botón, ahí podrás ver la información de la vacante. 
                                                                        <br/><br/>
                                                                        ¡ÉXITOS!";
                                                                    

                                                                    $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                                                                    $mailConfiguration = 1; //Id de la configuración
                                                                    $mailTitle = "Notificación de Proceso de Selección"; //Titulo o tema del correo
                        
                                                                    //Cuerpo con html y comillas dobles para las variables
                                                                    $mailBody = "Buen día ".$nombre.",
                                                                        <br/>
                                                                        has sido elegido para realizar un proceso de selección con nosotros! por favor haz clic en siguiente botón, ahí podrás ver la información de la vacante. 
                                                                        <br/><br/>
                                                                        ¡ÉXITOS!";

                                                                        //Arreglo para el botón
                                                                    $mailButton = ['buttonText' => 'OFERTA LABORAL', 'buttonRoute' => $urls];

                                                                    $mailUser = $data->usersss_id; //Id del usuario al que se le envía el correo

                                                                    $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                                                                    if($emails){
                                                                        $saludo = 'Buen día '.$nombre;
                                                                        
                                                                        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($emails, $asunto, $nombre_empresa
                                                                        ) {

                                                                              $message->to($emails, "$nombre_empresa - T3RS");
                                                                              $message->subject($asunto)
                                                                              ->getHeaders()
                                                                              ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                                                                          });
                                                                           
                                                                    }
                                                                }

                     return redirect()->back()->with('mensaje','El correo fue enviado Correctamente');
    }
    
    public function reportesContratadoCliente(Request $request)
    {
         //reportescontratados
       //$clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

    $usuarios_envio=["" => "- Seleccionar -"]+User::whereRaw('users.id in(select distinct(usuario_envio) from procesos_candidato_req)')
    ->orderBy(DB::raw("UPPER(users.name)"),"ASC")->pluck("users.name", "users.id")->toArray();
    $usuarios_aprueba=["" => "- Seleccionar -"]+User::whereRaw('users.id in(select distinct(user_autorizacion) from procesos_candidato_req)')
    ->orderBy(DB::raw("UPPER(users.name)"),"ASC")->pluck("users.name", "users.id")->toArray();

        $headersr   = $this->getHeaderReporteContratados();
        $data      = $this->getDataDetalleReporteContratadosCliente($request);

          
        return view('admin.reportes.reporte_contratados_cliente')->with([
            'usuarios_envio'=>$usuarios_envio,
            'usuarios_aprueba'=>$usuarios_aprueba,
            'data'      => $data,
            'headersr'   => $headersr,
        ]);
    }

    public function reportesDetallesContraExcel(Request $request)
    {

        $headers = $this->getHeaderReporteContratados();
        $data    = $this->getDataDetalleReporteContratadosCliente($request);

        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }
//dd($data);
        Excel::create('reporte-excel-fdf-detalle-contratados', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Contratados');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Contratados');
            $excel->sheet('Reporte Contratados', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_reportes_contratados', [
                    'data'    => $data,
                    'headersr' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
        
      /* $user_sesion = $this->user;
        $headerss = $this->getHeaderDetalleContra();
        $data    = $this->getDataDetalleContra($request);
        //dd($data);
        $formato = $request->formato;
      $sitio = Sitio::first();
        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-contratados', function ($excel) use ($sitio,$user_sesion,$data, $headerss, $formato) {
            $excel->setTitle('Reporte Contratados');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Contratados');
            $excel->sheet('Reporte Contratados', function ($sheet) use ($sitio,$user_sesion,$data, $headerss, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_contratados', [
                    'sitio' =>$sitio,
                     'user_sesion'         =>$user_sesion,
                    'data'    => $data,
                    'headerss' => $headerss,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);*/
    }

    private function getHeaderDetalleContra()
    {

        $headerss = [
            'N° de requerimiento',
            'N° de cédula',
            'Nombre Completo',
            'Edad',
            'Ciudad de Residencia',
            'Teléfono Móvil',
            'Email',
            'Estado actual',
             'Fecha de nacimiento',
            'Fuente de Reclutamiento',
            'Descripción profesional',
            '',
           
            
            
        ];
        return $headerss;
    }

    private function getDataDetalleContra($request)
    {
        //reportecontratados
      $formato = ($request->formato)? $request->formato : 'html';
       
       if($request->palabra_clave != '' || $request->ciudad_id != '' || $request->edad_inicial != '' || $request->edad_final != '' || $request->tipo_fuente_id != '' || $request->genero_id != '' || $request->estado != '' || $request->fecha_actualizacion_ini != '' || $request->fecha_actualizacion_fin != '' ){
           
            $data = DB::table('datos_basicos')
               ->join("departamentos", function ($join) {
                    $join
                 ->on("departamentos.cod_departamento", "=", "datos_basicos.departamento_residencia");
                })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_ciudad", "=", "datos_basicos.ciudad_residencia")
                 ->on("ciudad.cod_departamento", "=", "datos_basicos.departamento_residencia")
                 ->on('ciudad.cod_pais', '=', 'datos_basicos.pais_residencia');
                })
            ->join('requerimiento_cantidato','requerimiento_cantidato.candidato_id','=','datos_basicos.user_id')
            ->join('requerimientos','requerimientos.id','=','requerimiento_cantidato.requerimiento_id')  
            ->join('negocio','requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes','negocio.cliente_id', '=', 'clientes.id')
            ->join("users_x_clientes","users_x_clientes.cliente_id", "=", "clientes.id")
            ->join('tipo_fuente','tipo_fuente.id','=','requerimiento_cantidato.otra_fuente')
            ->join('generos','datos_basicos.genero','=','generos.id')
            ->join('estados','datos_basicos.estado_reclutamiento','=','estados.id')
            ->where('requerimiento_cantidato.estado_candidato',11)
            ->where('users_x_clientes.user_id',$this->user->id)
            ->select(
                'requerimientos.id as req_id',
                'tipo_fuente.descripcion as fuente_reclu',
                'datos_basicos.user_id as user_id',
                'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                'datos_basicos.numero_id as cedula', 
                'datos_basicos.nombres as nombres',
                'datos_basicos.primer_apellido as primer_apellido',
                'datos_basicos.segundo_apellido as segundo_apellido',
                'ciudad.nombre as ciudad',
                'datos_basicos.telefono_movil as celular',
                'datos_basicos.descrip_profesional as descripcion',
                'datos_basicos.email as email',
                'estados.descripcion as estado_candidato',
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                DB::raw('DATE_FORMAT(datos_basicos.updated_at, \'%Y-%m-%d\') as fecha_actualizacion')
                )
                ->where(function($where) use ($request){
                     
                    if($request->tipo_fuente_id !=""){

                      $where->where("requerimiento_cantidato.otra_fuente" , $request->tipo_fuente_id);
                    }

                    if($request->edad_inicial != "" && $request->edad_final != "") {
                      
                      $where->whereBetween(DB::raw('round(datediff(now(),fecha_nacimiento)/365)'),[$request->edad_inicial,$request->edad_final]);
                    }
                    
                    if($request->fecha_actualizacion_ini != "" && $request->fecha_actualizacion_fin != "") {
                      
                      $where->whereBetween('datos_basicos.created_at',[$request->fecha_actualizacion_ini.' 00:00:00',$request->fecha_actualizacion_fin.' 23:59:59']);
                    }
                   
                    if($request->genero_id !=""){

                      $where->where("generos.id", $request->genero_id);
                    }   
                     
                    if($request->ciudad_id != ""){
                       
                      $where->where("datos_basicos.ciudad_residencia", $request->ciudad_id);
                    }

                    if($request->departamento_id != ""){
                     
                     $where->where("datos_basicos.departamento_residencia", $request->departamento_id);
                    }
                 })
                ->where('datos_basicos.estado_reclutamiento',11)
                ->groupBy('datos_basicos.user_id');
                
            if(($request->formato) and ($formato == "xlsx" || $formato == "pdf")){
              
              $data = $data->get();
            }else{
              
              $data = $data->paginate(5);
            }

          return $data;
        }
    }

    /*
    *   Minería de hojas de vida
    */
    public function reportesDetallesMine(Request $request)
    {

        $perfiles = ["" => "Seleccionar"] + CargoGenerico::groupBy('descripcion')
        ->orderBy('descripcion','asc')
        ->pluck("descripcion", "id")->toArray();

        $generos = ["" => "Seleccionar"] + Genero::pluck("generos.descripcion", "generos.id")->toArray();

        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();
            
        $user_sesion = $this->user;
        $sitio = Sitio::first();

        $agencias = ["" =>"-Seleccionar -"]+Agencia::pluck("agencias.descripcion","agencias.id")->toArray();

        $requerimientos = ["" => "seleccionar"] + Requerimiento::whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado in( " . config('conf_aplicacion.C_TERMINADO') . ",".config('conf_aplicacion.C_SOLUCIONES') .  ",".config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').  ",".config('conf_aplicacion.C_INACTIVO'). ",".config('conf_aplicacion.C_QUITAR'). ",".config('conf_aplicacion.C_ELIMINADO').  "))"))
        ->orderBy('id','DESC')
        ->pluck("id","id")
        ->toArray();
       
        $user_sesion = $this->user;
         
        $headerss  = $this->getHeaderDetalleMine();
        $data      = $this->getDataDetalleMine($request);

        return view('admin.reportes.reporte_mine')->with([
            'user_sesion' => $user_sesion,
            'data'       => $data,
            'generos'    => $generos,
            'sitio'      => $sitio,
            'headerss'   => $headerss,
            'requerimientos' => $requerimientos,
            'aspiracionSalarial' => $aspiracionSalarial,
            'agencias'   =>$agencias,
            'perfiles'   =>$perfiles
        ]);
    }

    public function reportesDetallesMineExcel(Request $request)
    {
        
        $user_sesion = $this->user;

        $headerss = $this->getHeaderDetalleMine();
        $data    = $this->getDataDetalleMine($request);
        
        $formato = $request->formato;
        
        $sitio = Sitio::first();
        
        $funcionesGlobales = new FuncionesGlobales();

        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-mineria', function ($excel) use ($sitio,$user_sesion,$data, $headerss, $formato) {
            $excel->setTitle('Reporte minería de datos');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte minería de datos');
            $excel->sheet('Reporte minería de datos', function ($sheet) use ($sitio,$user_sesion,$data, $headerss, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_mine', [
                    'sitio' =>$sitio,
                    'user_sesion' =>$user_sesion,
                    'data'    => $data,
                    'headerss' => $headerss,
                    'formato' => $formato,

                ]);
            });
        })->export($formato);
    }

    private function getHeaderDetalleMine()
    {

        if (route("home") == "http://nases.t3rsc.co" || route("home") == "https://nases.t3rsc.co" ||
            route("home") == "http://localhost:8000") {
            $headerss = [
                'N° de cédula',
                'Nombre Completo',
                'Edad',
                'Fecha ultima actualización',
                'Ciudad de Residencia',
                'Teléfono Móvil',
                'Teléfono Fijo',
                'EPS',
                'Email',
                'Fuente Reclutamiento',
                '% HV',
                'Estado actual',
                'Fecha de nacimiento',
                'Cargo',
                'HV',
                'Descripción profesional',
                '',
            ];
        }else{
            $headerss = [
                'N° de cédula',
                'Nombre Completo',
                'Edad',
                'Fecha ultima actualización',
               
                //'Apellido',
                'Ciudad de Residencia',
                'Teléfono Móvil',
                'Email',
                '% HV',
                'Estado actual',
                 'Fecha de nacimiento',
                'Cargo',
                'HV',
                'Descripción profesional',
                '',
                
            ];
        }

        return $headerss;
    }

    /*
    *   Obtiene resultados de la busqueda
    */
    private function getDataDetalleMine($request)
    {
        $formato = ($request['formato'])? $request['formato'] : 'html';

        if($request['palabra_clave'] != '' || $request['ciudad_id'] != '' || $request['edad_inicial'] != '' || $request['edad_final'] != '' ||
            $request['genero_id'] != '' || $request['estado'] != '' || $request['fecha_actualizacion_ini'] != '' || $request['fecha_actualizacion_fin'] != '' ||
            $request['aspiracion_salarial'] != '' || $request['agencia']!='' || $request['linea_negocio'] !='' || $request['perfil']!='' || $request['habeas_data']!=''){

            $fecha_min = Carbon::now();
            $fecha_min->subMonths(2)->toDateString();

            $fecha_max = Carbon::now();
            $fecha_max->subMonths(5)->toDateString();
           
            $data = DB::table('datos_basicos')->leftjoin('paises', 'datos_basicos.pais_residencia', '=', 'paises.cod_pais')    
                ->leftjoin('ciudad',function($join){
                   $join->on('datos_basicos.ciudad_residencia', '=', 'ciudad.cod_ciudad')
                        ->on('datos_basicos.departamento_residencia', '=', 'ciudad.cod_departamento')
                        ->on('datos_basicos.pais_residencia', '=', 'ciudad.cod_pais');
                })
                ->leftjoin('departamentos', function ($join2){
                    $join2->on('datos_basicos.departamento_residencia', '=', 'departamentos.cod_departamento')
                        ->on('datos_basicos.pais_residencia', '=', 'departamentos.cod_pais'); 
                })
                ->leftjoin('generos','datos_basicos.genero','=','generos.id')
                ->leftjoin('entidades_eps','datos_basicos.entidad_eps','=','entidades_eps.id')
                ->leftjoin('aspiracion_salarial','datos_basicos.aspiracion_salarial','=','aspiracion_salarial.id')
                ->leftjoin('experiencias','datos_basicos.numero_id','=','experiencias.numero_id')
                ->leftjoin('estados','datos_basicos.estado_reclutamiento','=','estados.id')
                ->leftjoin('perfilacion_candidato','perfilacion_candidato.user_id','=','datos_basicos.user_id')
                ->leftjoin('perfilamiento','perfilamiento.user_id','=','datos_basicos.user_id')
                ->leftjoin('citacion_carga_db','citacion_carga_db.user_id',"=",'datos_basicos.user_id')
                //->leftjoin('ciudad','ciudad.cod_ciudad','=','datos_basicos.ciudad_residencia')
                ->leftjoin('agencias','agencias.id','=','ciudad.agencia')
                //->where("departamentos.cod_pais",170)
                ->where(function ($where) use ($request, $fecha_min) {
                    if($request['palabra_clave'] != "") {
                      $palabra_clave = $request["palabra_clave"];
                      $where->whereRaw("( 
                        LOWER(experiencias.cargo_especifico) like '%" . $palabra_clave . "%' or
                        LOWER(experiencias.funciones_logros) like '%" . $palabra_clave . "%' or
                        LOWER(datos_basicos.descrip_profesional) like '%" . strtolower($palabra_clave). "%' or
                        LOWER(citacion_carga_db.palabras_clave) like '%" . strtolower($palabra_clave) . "%' or
                        LOWER(citacion_carga_db.nombre_carga) like '%" . strtolower($palabra_clave) . "%'
                      )");
                    }

                    if($request['edad_inicial'] != "" && $request['edad_final'] != ""){
                        $where->whereBetween(DB::raw('round(datediff(now(),fecha_nacimiento)/365)'),[$request['edad_inicial'],$request['edad_final']]);
                    }

                    if ($request['fecha_actualizacion_ini'] != "" && $request['fecha_actualizacion_fin'] != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(datos_basicos.created_at, \'%Y-%m-%d\')'),[$request['fecha_actualizacion_ini'],$request['fecha_actualizacion_fin']]);
                    }

                    if($request['estado'] != ""){
                        $where->where("estados.descripcion" , $request['estado']);
                    }

                    if($request['perfil'] != ""){
                        $where->where("perfilamiento.cargo_generico_id" , $request['perfil']);
                    }

                    if($request['genero_id']!= ""){
                        $where->where("generos.id" , $request['genero_id']);
                    }
                     
                    if($request["ciudad_id"] != ""){
                        $where->where("datos_basicos.ciudad_residencia", $request["ciudad_id"]);
                    }
                    
                    if($request["departamento_id"] != ""){
                        $where->where("datos_basicos.departamento_residencia", $request["departamento_id"]);
                    }

                    if($request["agencia"] != ""){
                        $where->where("agencias.id", $request["agencia"]);
                    }

                    //Habeas data
                    if($request["habeas_data"] != ""){
                        $where->where("datos_basicos.acepto_politicas_privacidad", $request["habeas_data"]);
                    }
                })
                //->where("datos_basicos.updated_at",'>',$fecha_min)
                //->where("ciudad.cod_pais",170)
                //->where('datos_basicos.created_at','>=',$fecha_max)
                ->select(
                    'ciudad.nombre as ciudad',
                    'datos_basicos.user_id as user_id',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.numero_id as cedula', 
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido',
                    'experiencias.cargo_especifico as cargo',
                    'experiencias.funciones_logros as funciones',
                    'datos_basicos.telefono_movil as celular',
                    'datos_basicos.telefono_fijo as fijo',
                    'datos_basicos.descrip_profesional as descripcion',
                    'datos_basicos.email as email',
                    'datos_basicos.contacto_externo as fuente_reclu',
                    'entidades_eps.descripcion as eps_cand',
                    'estados.descripcion as estado_candidato',
                    DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                    DB::raw('( count(experiencias.numero_id)) as experiencias'),
                    DB::raw('(select count(estudios.numero_id)
                        from estudios
                        where estudios.numero_id = datos_basicos.numero_id       
                    )    as estudios'),
                    DB::raw('(select count(grupos_familiares.user_id)
                        from grupos_familiares
                        where grupos_familiares.numero_id = datos_basicos.numero_id       
                    )    as grupos_familiares'),
                    DB::raw('(select count(referencias_personales.numero_id)
                        from referencias_personales
                        where referencias_personales.numero_id = datos_basicos.numero_id      
                    )    as referencias_personales'),
                    DB::raw('(select (datos_basicos.datos_basicos_count *0.3)+(datos_basicos.perfilamiento_count * 0.1)) as hv_count'),
                    DB::raw('DATE_FORMAT(datos_basicos.updated_at, \'%Y-%m-%d\') as fecha_actualizacion')
                )
                ->groupBy('datos_basicos.user_id');

            if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")) {
                $data = $data->get();
            }else{
                $data = $data->paginate(15);
            }

            return $data;
        }
    }

    //Reporte detalle reclutamiento
    public function reportesDetallesReclu(Request $request)
    {
        $metodos=["" => "Seleccionar"] + MetodoCarga::pluck("descripcion", "id")->toArray();

        $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        if(route("home") == "https://gpc.t3rsc.co"){
            $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];
        }else{
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];
        }

        $headersr  = $this->getHeaderDetalleReclu();
        $data      = $this->getDataDetalleReclu($request);

        $agencias=["" => "Seleccionar"] + Agencia::pluck("agencias.descripcion", "agencias.id")->toArray();

        $usuarios=["" => "Seleccionar"] + User::whereRaw('users.id in(select usuario_carga from users where usuario_carga is not null)')
        ->pluck("users.name", "users.id")
        ->toArray();
          
        return view('admin.reportes.reporte_reclutamiento')->with([
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headersr'   => $headersr,
            'usuarios'   => $usuarios,
            'agencias'   => $agencias,
            'metodos'   => $metodos
        ]);
    }

    //Reporte de Entidades
    public function reportesEntidades(Request $request)
    {
        $headersr  = $this->getHeaderDetalleEntidades();
        $data      = $this->getDataDetalleEntidades($request);
          
        return view('admin.reportes.reporte_entidades')->with([
            'data'      => $data,
            'headersr'   => $headersr
        ]);
    }

    public function reportesEntidadesExcel(Request $request)
    {
        $headersr  = $this->getHeaderDetalleEntidades();
        $data      = $this->getDataDetalleEntidades($request);
        $formato = $request->formato;

        if ($data == 'vacio') {
            return view('admin.reportes.reporte_entidades')->with([
                'data'      => $data,
                'headersr'   => $headersr
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

        Excel::create('reporte-excel-entidades', function ($excel) use ($data, $headersr, $formato) {
            $excel->setTitle('Reporte Entidades');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Entidades');
            $excel->sheet('Reporte Entidades', function ($sheet) use ($data, $headersr, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_entidades', [
                    'data'    => $data,
                    'headersr' => $headersr,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    //Reporte de ARL SURA
    public function reportesARL(Request $request)
    {
        $headersr  = $this->getHeaderDetalleARL();
        $data      = $this->getDataDetalleARL($request);
            
        return view('admin.reportes.reporte_ARL')->with([
            'data'      => $data,
            'headersr'   => $headersr
        ]);
    }

    public function reportesARLExcel(Request $request)
    {
        $headersr  = $this->getHeaderDetalleARL();
        $data      = $this->getDataDetalleARL($request);
        $formato = $request->formato;

        if ($data == 'vacio') {
            return view('admin.reportes.reporte_ARL')->with([
                'data'      => $data,
                'headersr'   => $headersr
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

        Excel::create('reporte-excel-ARL', function ($excel) use ($data, $headersr, $formato) {
            $excel->setTitle('Reporte ARL SURA');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte ARL');
            $excel->sheet('Reporte ARL', function ($sheet) use ($data, $headersr, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_ARL', [
                    'data'    => $data,
                    'headersr' => $headersr,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    public function reporteMinisterio(Request $request)
    { 
      $clientes  = ["" => "Seleccionar"] + Clientes::orderBy('nombre')->pluck("clientes.nombre", "clientes.id")->toArray();

      $ciudad = ["" => "- Seleccionar -"] + Ciudad::pluck("nombre", "id")->toArray();

      $headersr  = $this->getHeaderDetalleMinisterio();
      $data      = $this->getDataDetalleMinisterio($request);
          
        return view('admin.reportes.reporte_ministerio')->with([
            'data'      => $data,
            'headersr'  => $headersr,
            'clientes'  => $clientes,
            'ciudad'    => $ciudad
        ]);
    }

    public function reporteMinisterioExcel(Request $request)
    {
      $headersr  = $this->getHeaderDetalleMinisterio();
      $data      = $this->getDataDetalleMinisterio($request);
      $formato = $request->formato;

        if ($data == 'vacio') {
            return view('admin.reportes.reporte_ministerio')->with([
                'data'      => $data,
                'headersr'   => $headersr
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

        Excel::create('reporte-excel-ministerio', function ($excel) use ($data, $headersr, $formato) {
            $excel->setTitle('Reporte Ministerio');
            $excel->setCreator("$nombre")
                ->setCompany("$nombre");
            $excel->setDescription('Reporte Ministerio');
            $excel->sheet('Reporte Ministerio', function ($sheet) use ($data, $headersr, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_ministerio', [
                    'data'    => $data,
                    'headersr' => $headersr,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    //Reporte de Constructora Bolivar
    public function reportesConstructoraBol(Request $request)
    {
        $headersr  = $this->getHeaderDetalleConstructoraBol();
        $data      = $this->getDataDetalleConstructoraBol($request);
        //dd($data);
          
        return view('admin.reportes.reporte_constructora_bolivar')->with([
            'data'      => $data,
            'headersr'   => $headersr
        ]);
    }

    public function reportesConstructoraBolExcel(Request $request)
    {
        $headersr  = $this->getHeaderDetalleConstructoraBol();
        $data      = $this->getDataDetalleConstructoraBol($request);
        $formato = $request->formato;

        if ($data == '') {
            return view('admin.reportes.reporte_constructora_bolivar')->with([
                'data'      => $data,
                'headersr'   => $headersr
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

        Excel::create('reporte-excel-constructora-bolivar', function ($excel) use ($data, $headersr, $formato) {
            $excel->setTitle('Reporte Constructora Bolivar');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Constructora Bolivar');
            $excel->sheet('Reporte Constructora Bolivar', function ($sheet) use ($data, $headersr, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_constructora_bol', [
                    'data'    => $data,
                    'headersr' => $headersr,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    public function reportesDocumentosCandidato(Request $request)
    {
        $columnas_datos = [];
        $headersr  = $this->getHeaderDocumentosCandidatos($request, $columnas_datos);
        $data      = $this->getDataDocumentosCandidatos($request, $columnas_datos);
        
        return view('admin.reportes.reporte_documentos_candidatos')->with([
            'data'      => $data,
            'headersr'   => $headersr
        ]);
    }

    public function reportesDocumentosCandidatoExcel(Request $request)
    {
        $columnas_datos = [];
        $headersr  = $this->getHeaderDocumentosCandidatos($request, $columnas_datos);
        $data      = $this->getDataDocumentosCandidatos($request, $columnas_datos);
        $formato = $request->formato;

        if ($data == '') {
            return view('admin.reportes.reporte_documentos_candidatos')->with([
                'data'      => $data,
                'headersr'   => $headersr
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

        Excel::create('reporte-excel-documentos-candidatos', function ($excel) use ($data, $headersr, $formato) {
            $excel->setTitle('Reporte Documentos Candidatos');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Documentos Candidatos');
            $excel->sheet('Reporte Documentos Candidatos', function ($sheet) use ($data, $headersr, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_doc_cand', [
                    'data'    => $data,
                    'headersr' => $headersr,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    public function reportesEnviadosExamMedicos(Request $request)
    {
        $columnas_datos = [];
        $headersr  = $this->getHeaderEnviadosExamMedicos();
        $data      = $this->getDataEnviadosExamMedicos($request);
        
        return view('admin.reportes.reporte_candidatos_exam_medicos')->with([
            'data'      => $data,
            'headersr'   => $headersr
        ]);
    }

    public function reportesEnviadosExamMedicosExcel(Request $request)
    {
        $columnas_datos = [];
        $headersr  = $this->getHeaderEnviadosExamMedicos();
        $data      = $this->getDataEnviadosExamMedicos($request);
        $formato = $request->formato;

        if ($data == 'vacio') {
            return view('admin.reportes.reporte_candidatos_exam_medicos')->with([
                'data'      => $data,
                'headersr'   => $headersr
            ]);
        }

        $nombre = "Desarrollo";
        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }
        }

        Excel::create('reporte-excel-candidatos-examenes-medicos', function ($excel) use ($data, $headersr, $formato) {
            $excel->setTitle('Candidatos a Exámenes Médicos');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte de Candidatos Enviados a Exámenes Médicos');
            $excel->sheet('Candidatos a Exámenes Médicos', function ($sheet) use ($data, $headersr, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_cand_exam_med', [
                    'data'    => $data,
                    'headersr' => $headersr,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    public function reportesValidacionDocumental(Request $request)
    {
        $columnas_datos = [];
        $headersr  = $this->getHeaderValidacionDocumental($request, $columnas_datos);
        $data      = $this->getDataValidacionDocumental($request, $columnas_datos);
        $clientes  = ["" => "Seleccionar"] + Clientes::orderBy('nombre')->pluck("clientes.nombre", "clientes.id")->toArray();
        
        return view('admin.reportes.reporte_validacion_documental_new')->with([
            'data'       => $data,
            'headersr'   => $headersr,
            'clientes'   => $clientes
        ]);
    }

    public function reportesValidacionDocumentalExcel(Request $request)
    {
        $columnas_datos = [];
        $headersr  = $this->getHeaderValidacionDocumental($request, $columnas_datos);
        $data      = $this->getDataValidacionDocumental($request, $columnas_datos);
        $formato = $request->formato;

        if ($data == 'vacio') {
            $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();
            return view('admin.reportes.reporte_validacion_documental_new')->with([
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

        Excel::create('reporte-excel-validacion-documental', function ($excel) use ($data, $headersr, $formato) {
            $excel->setTitle('Reporte Validacion Documental');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Validacion Documental');
            $excel->sheet('Reporte Validacion Documental', function ($sheet) use ($data, $headersr, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_validacion_documental', [
                    'data'    => $data,
                    'headersr' => $headersr,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    public function reportesDetallesContratacion(Request $request)
    {

        $clientes  = ["" => "Seleccionar"] + Clientes::orderBy('nombre')->pluck("clientes.nombre", "clientes.id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }
        
        $headersr  = $this->getHeaderDetalleContratacion();
        
        $data      = $this->getDataDetalleContratacion($request);
        $agencias=["" => "- Seleccionar -"]+Agencia::pluck("agencias.descripcion", "agencias.id")->toArray();

        $usuarios=["" => "- Seleccionar -"]+User::join("role_users","users.id","=","role_users.user_id")
           ->whereIn("role_users.role_id",[4,7])
           ->pluck("users.name", "users.id")->toArray();
          
        return view('admin.reportes.reporte_contratacion')->with([
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headersr'   => $headersr,
            'usuarios'   => $usuarios,
            'agencias'   => $agencias
        ]);
    }


    public function reportesInformeCrecimiento(Request $request)
    {

        $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }
        
        $headersr  = $this->getHeaderInformeCrecimiento();
        
        $data      = $this->getDataInformeCrecimiento($request);
       
        $agencias=["" => "- Seleccionar -"]+Agencia::pluck("agencias.descripcion", "agencias.id")->toArray();

        $usuarios=["" => "- Seleccionar -"]+User::join("role_users","users.id","=","role_users.user_id")
           ->whereIn("role_users.role_id",[4,7])
           ->pluck("users.name", "users.id")->toArray();
          
        return view('admin.reportes.reporte_informe_crecimiento')->with([
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headersr'   => $headersr,
            'usuarios'   => $usuarios,
            'agencias'   => $agencias
        ]);
    }

    public function reportesDemanda(Request $request)
    {
        $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }
        
        $usuarios=["" => "- Seleccionar -"]+User::join("role_users","users.id","=","role_users.user_id")
             ->whereIn("role_users.role_id",[4,7])
             ->pluck("users.name", "users.id")->toArray();

        $headersr   = $this->getHeaderDemanda();
        $data      = $this->getDataDetalleDemanda($request);
          
        return view('admin.reportes.reporte_demanda')->with([
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headersr'  => $headersr,
            'usuarios'  => $usuarios,
        ]);
    }

    public function reportesOferta(Request $request)
    {
        $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }
        
        $usuarios = ["" => "- Seleccionar -"]+User::join("role_users","users.id","=","role_users.user_id")
           ->whereIn("role_users.role_id",[4,7])
           ->pluck("users.name", "users.id")->toArray();

        $headersr  = $this->getHeaderOferta();
        $data      = $this->getDataDetalleOferta($request);

        return view('admin.reportes.reporte_oferta')->with([
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headersr'   => $headersr,
            'usuarios'   => $usuarios,
        ]);
    }
    
    public function reportesCarga(Request $request)
    {

        $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }

        $usuarios=["" => "- Seleccionar -"]+User::join("role_users","users.id","=","role_users.user_id")
        ->whereIn("role_users.role_id",[4,7])
        ->pluck("users.name", "users.id")->toArray();

        $headersr   = $this->getHeaderCarga();
        $data      = $this->getDataDetalleCarga($request);

          
        return view('admin.reportes.reporte_carga')->with([
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headersr'   => $headersr,
            'usuarios'   => $usuarios,
        ]);
    }
  public function reportesDescargaContratacion(Request $request){
    $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }

        $headersr   = $this->getHeaderDescargaContratacion();
        $data      = $this->getDataDetalleDescargaContratacion($request);

          
        return view('admin.reportes.reporte_descarga_contratacion')->with([
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headersr'   => $headersr,
        ]);
    }

    public function reportesContratados(Request $request){
    $clientes  = ["" => "Seleccionar"] + Clientes::orderBy('nombre')->pluck("clientes.nombre", "clientes.id")->toArray();

    $usuarios_envio=["" => "- Seleccionar -"]+User::whereRaw('users.id in(select distinct(usuario_envio) from procesos_candidato_req)')
           ->pluck("users.name", "users.id")->toArray();
    $usuarios_aprueba=["" => "- Seleccionar -"]+User::whereRaw('users.id in(select distinct(user_autorizacion) from procesos_candidato_req)')
    ->pluck("users.name", "users.id")->toArray();

        $headersr   = $this->getHeaderReporteContratados();
        $data      = $this->getDataDetalleReporteContratados($request);

          
        return view('admin.reportes.reportes_contratados')->with([
            'clientes'  => $clientes,
            'usuarios_envio'=>$usuarios_envio,
            'usuarios_aprueba'=>$usuarios_aprueba,
            'data'      => $data,
            'headersr'   => $headersr,
        ]);
    }

    public function reportesEnviadosPruebas(Request $request)
    {
        $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        $busqueda=false;
        if($request->req_id!=""){
            $busqueda=true;
        }
        
        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }

        $usuarios=["" => "- Seleccionar -"]+User::join("role_users","users.id","=","role_users.user_id")
        ->whereIn("role_users.role_id",[4,7])
        ->pluck("users.name", "users.id")->toArray();

        $headersr   = $this->getHeaderEnviadosPruebas();
        $data      = $this->getDataDetalleEnviadosPruebas($request);

        return view('admin.reportes.reporte_enviados_pruebas')->with([
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headersr'  => $headersr,
            'busqueda'  => $busqueda,
            'usuarios'  => $usuarios,
        ]);
    }

    public function reportesDetallesRecluExcel(Request $request)
    {
        $headersr = $this->getHeaderDetalleReclu();
        $data    = $this->getDataDetalleReclu($request);
        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-fdf-detalle-reclutamiento', function ($excel) use ($data, $headersr, $formato) {
            $excel->setTitle('Reporte Detalle Reclutamiento');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Reclutamiento');
            $excel->sheet('Reporte Detalle Reclutamiento', function ($sheet) use ($data, $headersr, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_reclu', [
                    'data'    => $data,
                    'headersr' => $headersr,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    public function reportesDetallesContratacionExcel(Request $request)
    {
       
        $headersr = $this->getHeaderDetalleContratacion();
        $data    = $this->getDataDetalleContratacion($request);

        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-fdf-detalle-contratacion', function ($excel) use ($data, $headersr, $formato) {
            $excel->setTitle('Reporte Detalle Contratacion');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Contratacion');
            $excel->sheet('Reporte Detalle Contratacion', function ($sheet) use ($data, $headersr, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_contratacion', [
                    'data'    => $data,
                    'headersr' => $headersr,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    public function reportesInformeCrecimientoExcel(Request $request)
    {
       
        $headersr = $this->getHeaderInformeCrecimiento();
        $data    = $this->getDataInformeCrecimiento($request);

        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-fdf-informe-crecimiento', function ($excel) use ($data, $headersr, $formato) {
            $excel->setTitle('Reporte Informe Crecimiento');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Informe Crecimiento');
            $excel->sheet('Reporte Detalle Crecimiento', function ($sheet) use ($data, $headersr, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_informe_crecimiento', [
                    'data'    => $data,
                    'headersr' => $headersr,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    private function getHeaderDetalleReclu()
    {

        $headersr = [
            'Método de carga',
            'Fuente de reclutamiento',
            'N° de cédula',
            'Nombres',
            'Apellidos',
            'Ciudad de residencia',
            'N° Requerimiento',
            'Fecha de carga',
            'Usuario que cargó',
            '%HV',
            'Estado del candidato',
            'Acciones'
           
            
        ];
        return $headersr;
    }

    private function getHeaderDetalleEntidades()
    {
        $headersr = [
            'Nro. Req.',
            'NIT Empresa',
            'Tipo documento Trabajador (1-CC, 2-TI,  3-NI, 4-CE , 5-RC, 6-PA)',
            'Nro. de Identificación',
            'Primer Apellido',
            'Segundo Apellido',
            'Nombres',
            'Fecha de Nacimiento',
            'Estado civil (1-SOLTERO, 2-CASADO, 3-VIUDO,4-UNION LIBRE,5-SEPARADO,6-DIVORCIADO)',
            'Sexo',
            'Departamento',
            'Ciudad',
            'Dirección de residencia',
            'Barrio',
            'Teléfono fijo',
            'Teléfono móvil',
            'Correo electrónico',
            'Tipo de contrato (1-INDEFINIDO,2-TERMINO FIJO)',// (1-INDEFINIDO,2-TERMINO FIJO)
            'Cargo',
            'Sueldo básico',
            'Fecha de Ingreso',
            'Fecha de Retiro',
            'EPS afiliado',
            'AFP afiliado'
        ];
        return $headersr;
    }

    /*
    *   Contenido de tabla o archivo excel 
    */
    private function getDataDetalleEntidades($request)
    {
        if(isset($request->req_id)){
           $num_req = $request['req_id'];
        }
        $generar_datos = $request['generar_datos'];
        $formato      = ($request->has('formato')) ? $request->formato : 'html';
        $rango_fecha = $request->rango_fecha;

        $dt = Carbon::now();

        $data = "vacio";

        if($num_req != '' || $rango_fecha != ''){
            if ($rango_fecha != "") {
              $rango = explode(" | ", $rango_fecha);
              $fecha_inicio = $rango[0];
              $fecha_final  = $rango[1];
            } else {
              $fecha_inicio = '';
              $fecha_final  = '';
            }
            $estado_firma = 1;

            $data = FirmaContratos::leftjoin("requerimiento_cantidato", function ($join) {
                $join->on('firma_contratos.req_id', '=', 'requerimiento_cantidato.requerimiento_id')
                    ->on('firma_contratos.user_id', '=', 'requerimiento_cantidato.candidato_id');
                })
            ->leftjoin("requerimientos", "requerimientos.id", "=", "firma_contratos.req_id")
            ->leftjoin("datos_basicos", "datos_basicos.user_id", "=", "firma_contratos.user_id")
            ->leftjoin("requerimiento_contrato_candidato", function ($join) {
                $join->on('firma_contratos.req_id', '=', 'requerimiento_contrato_candidato.requerimiento_id')
                    ->on('firma_contratos.user_id', '=', 'requerimiento_contrato_candidato.candidato_id');
                })
            ->leftjoin('ciudad', function ($join) {
                $join->on('datos_basicos.ciudad_residencia', '=', 'ciudad.cod_ciudad')
                    ->on('datos_basicos.departamento_residencia', '=', 'ciudad.cod_departamento')
                    ->on('datos_basicos.pais_residencia', '=', 'ciudad.cod_pais');
            })
            ->leftjoin('departamentos', function ($join2) {
                $join2->on('datos_basicos.departamento_residencia', '=', 'departamentos.cod_departamento')
                    ->on('datos_basicos.pais_residencia', '=', 'departamentos.cod_pais');
            })
            ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            //->leftjoin("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->leftjoin("empresa_logos", "empresa_logos.id", "=", "requerimientos.empresa_contrata")
            ->leftjoin("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            //->leftjoin("firma_contratos", "firma_contratos.req_id", "=", "requerimientos.id")
            //->leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            //->leftjoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
            ->leftjoin("generos", "generos.id", "=", "datos_basicos.genero")
            ->leftjoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
            ->leftjoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
            ->where(function ($sql) use ($fecha_inicio, $fecha_final){
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("firma_contratos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
            })
            ->where(function ($sql) use ($num_req) {
                if ($num_req!= "") {
                    $sql->where("requerimientos.id", $num_req);
                }
            })
            ->where("firma_contratos.estado", 1)
            ->whereRaw('requerimiento_contrato_candidato.id=(select max(requerimiento_contrato_candidato.id) from requerimiento_contrato_candidato where requerimiento_contrato_candidato.candidato_id=firma_contratos.user_id AND requerimiento_contrato_candidato.requerimiento_id=firma_contratos.req_id)')
            ->whereRaw('firma_contratos.id=(select max(firma_contratos.id) from firma_contratos where requerimiento_contrato_candidato.candidato_id=firma_contratos.user_id)')
            //->where("requerimiento_cantidato.requerimiento_id", $num_req)
            ->where(function ($query) {
                $ids_clientes_prueba = [];
                if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                    $query->whereNotIn("negocio.cliente_id", $ids_clientes_prueba);
                }
            })
            ->select(
                "datos_basicos.*",
                //"clientes.nit",
                "departamentos.nombre as departamento_resi",
                "ciudad.nombre as ciudad_resi",
                "empresa_logos.nit",
                "requerimientos.id as id_requerimiento",
                "requerimientos.salario as salario",
                "requerimientos.tipo_contrato_id",
                "requerimiento_contrato_candidato.fecha_ingreso as fecha_ingreso_req",
                "requerimiento_contrato_candidato.fecha_ultimo_contrato",
                "cargos_especificos.descripcion as descripcion_cargo",
                //"tipo_identificacion.descripcion as tipo_identificacion",
                //"estados_civiles.descripcion as descripcion_estado_civil",
                "generos.descripcion as sexo",
                "entidades_eps.descripcion as eps",
                "entidades_afp.descripcion as afp"
            )
            ->orderBy("firma_contratos.id", "desc")
            //->orderBy("firma_contratos.user_id")
            ->groupBy("firma_contratos.user_id");

        } else if (isset($generar_datos)) {
            session()->flash('mensaje_warning', 'Debe ingresar el requerimiento o seleccionar un rango de fecha de la firma de contrato');
        }

        if($data != "vacio"){
            if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
                $data = $data->get();
            }else{
                $data = $data->paginate(6);
            }
        }
        //dd($data);
        return $data;
    }

    /*
    *   Header de tabla o archivo excel 
    */
    private function getHeaderDetalleARL()
    {
        $headersr = [
            'Tipo de identificación',
            'Identificación empleado',
            'Primer Nombre',
            'Segundo Nombre',
            'Primer Apellido',
            'Segundo Apellido',
            'Fecha de Nacimiento',
            'Género',
            'Estado Civil',
            'Fecha de Ingreso',
            'Cargo',
            'Código Ocupación',
            'Tipo de Salario',
            'Valor Salario',
            'EPS afiliado',
            'AFP afiliado',
            'Departamento',
            'Ciudad',
            'Tipo afiliado',
            'NIT de empresa en misión',
            'Código de sucursal',
            'Código de centro de trabajo',
            'Dirección de residencia',
            'Teléfono',
            'Celular',
            'Correo electrónico',
            'Información adicional'            
        ];
        return $headersr;
    }

    /*
    *   Body de tabla o archivo excel 
    */
    private function getDataDetalleARL($request)
    {
        if(isset($request->req_id)){
            $num_req = $request['req_id'];
         }
         $generar_datos = $request['generar_datos'];
         $formato      = ($request->has('formato')) ? $request->formato : 'html';
         $rango_fecha = $request->rango_fecha;
 
         $dt = Carbon::now();
 
         $data = "vacio";
 
         if($num_req != '' || $rango_fecha != ''){
             if ($rango_fecha != "") {
               $rango = explode(" | ", $rango_fecha);
               $fecha_inicio = $rango[0];
               $fecha_final  = $rango[1];
             } else {
               $fecha_inicio = '';
               $fecha_final  = '';
             }
             $estado_firma = 1;
 
             $data = FirmaContratos::leftjoin("requerimiento_cantidato", function ($join) {
                 $join->on('firma_contratos.req_id', '=', 'requerimiento_cantidato.requerimiento_id')
                     ->on('firma_contratos.user_id', '=', 'requerimiento_cantidato.candidato_id');
                 })
             ->leftjoin("requerimientos", "requerimientos.id", "=", "firma_contratos.req_id")
             ->leftjoin("datos_basicos", "datos_basicos.user_id", "=", "firma_contratos.user_id")
             ->leftjoin("requerimiento_contrato_candidato", function ($join) {
                 $join->on('firma_contratos.req_id', '=', 'requerimiento_contrato_candidato.requerimiento_id')
                     ->on('firma_contratos.user_id', '=', 'requerimiento_contrato_candidato.candidato_id');
                 })
             ->leftjoin('ciudad', function ($join) {
                 $join->on('datos_basicos.ciudad_residencia', '=', 'ciudad.cod_ciudad')
                     ->on('datos_basicos.departamento_residencia', '=', 'ciudad.cod_departamento')
                     ->on('datos_basicos.pais_residencia', '=', 'ciudad.cod_pais');
             })
             ->leftjoin('departamentos', function ($join2) {
                 $join2->on('datos_basicos.departamento_residencia', '=', 'departamentos.cod_departamento')
                     ->on('datos_basicos.pais_residencia', '=', 'departamentos.cod_pais');
             })
             ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
             //->leftjoin("clientes", "clientes.id", "=", "negocio.cliente_id")
             ->leftjoin("empresa_logos", "empresa_logos.id", "=", "requerimientos.empresa_contrata")
             ->leftjoin("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
             //->leftjoin("firma_contratos", "firma_contratos.req_id", "=", "requerimientos.id")
             ->leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
             ->leftjoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
             ->leftjoin('centros_trabajo', 'centros_trabajo.id', '=', 'requerimientos.ctra_x_clt_codigo')
             ->leftjoin("generos", "generos.id", "=", "datos_basicos.genero")
             ->leftjoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
             ->leftjoin("tipos_nominas", "tipos_nominas.id", "=", "requerimientos.tipo_nomina")
             ->leftjoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
             ->where(function ($sql) use ($fecha_inicio, $fecha_final){
                 if ($fecha_inicio != "" && $fecha_final != "") {
                     $sql->whereBetween("firma_contratos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                 }
             })
             ->where(function ($sql) use ($num_req) {
                 if ($num_req!= "") {
                     $sql->where("requerimientos.id", $num_req);
                 }
             })
             ->where("firma_contratos.estado", 1)
             ->whereRaw('requerimiento_contrato_candidato.id=(select max(requerimiento_contrato_candidato.id) from requerimiento_contrato_candidato where requerimiento_contrato_candidato.candidato_id=firma_contratos.user_id AND requerimiento_contrato_candidato.requerimiento_id=firma_contratos.req_id)')
             ->whereRaw('firma_contratos.id=(select max(firma_contratos.id) from firma_contratos where requerimiento_contrato_candidato.candidato_id=firma_contratos.user_id)')
             //->where("requerimiento_cantidato.requerimiento_id", $num_req)
             ->where(function ($query) {
                 $ids_clientes_prueba = [];
                 if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                     $query->whereNotIn("negocio.cliente_id", $ids_clientes_prueba);
                 }
             })
             ->select(
                 "datos_basicos.*",
                 //"clientes.nit",
                 "departamentos.nombre as departamento_resi",
                 "ciudad.nombre as ciudad_resi",
                 "empresa_logos.nit",
                 "requerimientos.id as id_requerimiento",
                 "requerimientos.salario as salario",
                 "requerimientos.tipo_contrato_id",
                 "requerimiento_contrato_candidato.fecha_ingreso as fecha_ingreso_req",
                 "requerimiento_contrato_candidato.fecha_ultimo_contrato",
                 "cargos_especificos.descripcion as descripcion_cargo",
                 "tipo_identificacion.descripcion as tipo_identificacion",
                 "estados_civiles.descripcion as descripcion_estado_civil",
                 "generos.descripcion as genero",
                 "entidades_eps.descripcion as eps",
                 "entidades_afp.descripcion as afp",
                 "tipos_nominas.descripcion as tipo_salario",
                 "centros_trabajo.nombre_ctra as clase_riesgo"
             )
             ->orderBy("firma_contratos.id", "desc")
             //->orderBy("firma_contratos.user_id")
             ->groupBy("firma_contratos.user_id");
 
         } else if (isset($generar_datos)) {
             session()->flash('mensaje_warning', 'Debe ingresar el requerimiento o seleccionar un rango de fecha de la firma de contrato');
         }
 
         if($data != "vacio"){
             if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
                 $data = $data->get();
             }else{
                 $data = $data->paginate(6);
             }
         }
         //dd($data);
         return $data;
    }

    //header de ministerio

    private function getHeaderDetalleMinisterio()
    {
        $headersr = [
            'Nombre vacante',
            'Experiencia (años)',
            'Nivel de estudio',
            'Profesión',
            'Remuneración mensual',
            'Perfil',
            'Funciones',
            'Fecha de vencimiento',
            'Número vacantes',
            'Observaciones',
            'Cliente',
            'Área o departamento que busca la vacante',
            'Solicitud de publicación',
            'Tipo de contrato',
            'Ciudad',
            'Jornada laboral'
        ];
        return $headersr;
    }

    private function getDataDetalleMinisterio($request)
    {
      //dd($request->all());
        if ( isset($request->cliente_id) ){
          $cliente = $request->cliente_id;
        }

        if ( isset($request->ciudad_id) ){
          $ciudad = $request->ciudad_id;
        }

        if ( isset($request->pais_id) ){
          $pais = $request->pais_id;
        }

        $rango = "";
        if($request->rango_fecha != ""){
            $rango = explode(" | ", $request->rango_fecha);
            $fecha_inicio = $rango[0];
            $fecha_final  = $rango[1];
        }

        $formato  = ($request['formato']) ? $request['formato'] : 'html';

        $data="vacio";

      if ($cliente != "" || $ciudad != "" || $pais != "" || $rango != "") {

        $data = Requerimiento::leftjoin('niveles_estudios', 'niveles_estudios.id', '=', 'requerimientos.nivel_estudio')
                    ->leftjoin('tipos_experiencias', 'tipos_experiencias.id', '=', 'requerimientos.tipo_experiencia_id')
                    ->leftjoin('tipos_contratos', 'requerimientos.tipo_contrato_id', '=', 'tipos_contratos.id')
                    ->leftjoin("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                        ->join("departamentos", function ($join) {
                          $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                          ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                        })
                      ->leftjoin("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                        ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                        ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                        })
                      ->leftjoin('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
                      ->leftjoin('clientes', 'negocio.cliente_id', '=', 'clientes.id')
                      ->leftjoin('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
                      ->leftjoin('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
                      ->leftjoin("tipos_jornadas", "tipos_jornadas.id", "=", "requerimientos.tipo_jornadas_id")
                      ->where(function ($sql) use ($rango, $fecha_inicio, $fecha_final, $cliente, $ciudad, $pais, $request) {

                            if ($rango != "") {
                               
                               $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                            }

                            if ($cliente != "") {
                                $sql->where("clientes.id", $cliente);
                            }

                            if ($ciudad != "") {
                                $sql->where("requerimientos.ciudad_id", $ciudad);
                            }

                            if ($pais != "") {
                                $sql->where("requerimientos.pais_id", $pais);
                            }

                          })
                        ->where(function ($query) use ($cliente) {
                            if($cliente == '' || $cliente == null) {
                                $ids_clientes_prueba = [];
                                if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                                    $query->whereNotIn("clientes.id", $ids_clientes_prueba);
                                }
                            }
                        })
                      ->select(
                        'requerimientos.*',
                        'cargos_especificos.descripcion as nombre_vacante',
                        'niveles_estudios.descripcion as nivel_de_estudio',
                        'tipos_experiencias.descripcion as tipo_experiencia',
                        'cargos_genericos.descripcion as cargo_generico',
                        'clientes.nombre as cliente',
                        'tipos_contratos.descripcion as tipo_contrato',
                        'ciudad.nombre as nombre_ciudad',
                        'tipos_jornadas.descripcion as tipo_jornada'
                      );

      }else if (isset($generar_datos)) {
            session()->flash('mensaje_warning', 'Debe seleccionar uno de los filtros.');
      }

      if($data != "vacio" && $data != null){
        if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
          $data = $data->get();
        }else{
          $data = $data->paginate(10);
        }
        }

        return $data;
    }

    private function getHeaderDetalleConstructoraBol()
    {
        $headersr = [
            'Número Identificación',
            'Tipo De Sangre',
            'Fecha De Examen Medico Curso De Altura',
            'Nombre De Acudiente',
            'Celular/Teléfono Acudiente',
            'Parentesco',
            'Tipo De Vivienda',
            'Servicios Públicos',
            'Tiempo Libre',
            'Fecha Examen De Ingreso',
            'Número De Personas Que Viven Con Usted En Su Hogar',
            'Cantidad De Personas Que Aportan En El Hogar',
            'Productos Financieros a los que ha Tenido Acceso',
            'Destina Algún Monto De Sus Ingresos Para Ahorro',
            'Cómo Realiza El Ahorro'
        ];
        return $headersr;
    }

    private function getDataDetalleConstructoraBol($request)
    {
        $generar_datos = $request['generar_datos'];
        $formato      = ($request->has('formato')) ? $request->formato : 'html';

        $data = "vacio";

        if($request->rango_fecha != ""){
            $rango = explode(" | ", $request->rango_fecha);
            $fecha_inicio = $rango[0];
            $fecha_final  = $rango[1];
            //dd($fecha_inicio, $fecha_final);

            $data = DatosBasicos::leftjoin("firma_contratos", "firma_contratos.user_id", "=", "datos_basicos.user_id")
                ->leftjoin("datos_adicionales", "datos_adicionales.datos_basicos_id", "=", "datos_basicos.id")
                ->where(function($sql) use ($fecha_inicio, $fecha_final)
                {
                    if ($fecha_inicio != "" && $fecha_final != "") {
                        $sql->whereBetween("firma_contratos.updated_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                    }
                })
                ->whereNotNull("firma_contratos.terminado")
                ->where("firma_contratos.estado", 1)
                ->select(
                    "datos_basicos.user_id",
                    "datos_basicos.nombres",
                    "datos_basicos.primer_apellido",
                    "datos_basicos.segundo_apellido",
                    "datos_basicos.numero_id",
                    "datos_basicos.telefono_movil",
                    "datos_basicos.nombre_acudiente",
                    "datos_basicos.telefono_acudiente",
                    "datos_basicos.parentesco_acudiente",
                    "datos_basicos.rh",
                    "datos_basicos.grupo_sanguineo",
                    "datos_adicionales.*",
                    "firma_contratos.req_id"
                )
                ->orderBy("firma_contratos.updated_at", "desc")
                ->groupBy("firma_contratos.req_id");
        } else if (isset($generar_datos)) {
            session()->flash('mensaje_warning', 'Debe seleccionar un rango de fechas');
        }

        if($data != "vacio"){
            //dd($data->toSql());
            if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
                $data = $data->get();
            }else{
                $data = $data->paginate(6);
            }
        }

        //dd($data);

        foreach ($data as &$candidato) {
            $cant_doc_cargados = 0;
            $doc_candidato = Documentos::where('user_id', $candidato->user_id)
                ->whereIn('tipo_documento_id', ["31", "8"])
                ->where('requerimiento', $candidato->req_id)
                ->select("fecha_realizacion", "tipo_documento_id")
                ->orderBy('created_at', 'desc')
                ->get();

            $candidato["fecha_altura"] = '';
            $candidato["fecha_examen_med"] = '';

            foreach ($doc_candidato as $tipo_doc) {
                if ($tipo_doc->tipo_documento_id == 31) {
                    $candidato["fecha_altura"] = $tipo_doc->fecha_realizacion;
                } else {
                    $candidato["fecha_examen_med"] = $tipo_doc->fecha_realizacion;
                }
            }
        }
        unset($candidato);

        return $data;
    }

    private function getHeaderDocumentosCandidatos($request, &$columnas_datos)
    {
        $headersr = [];
        $req_id = $request->req_id;
        if ($req_id != null && $req_id != '') {
            /* -- Tambien funciona esta consulta --
            $columnas_datos = Requerimiento::leftjoin("cargo_documento", "cargo_documento.cargo_especifico_id", "=", "requerimientos.cargo_especifico_id")
                ->leftjoin("tipos_documentos", "tipos_documentos.id", "=", "cargo_documento.tipo_documento_id")
                ->where("requerimientos.id", $req_id)
                ->where("tipos_documentos.categoria", 1)
                ->where("tipos_documentos.estado", 1)
                ->select(
                    "tipos_documentos.id as id",
                    "tipos_documentos.descripcion as descripcion",
                    "requerimientos.cargo_especifico_id"//,
                    //"documentos.created_at as fecha_carga"
                )
            ->orderBy("tipos_documentos.id")
            ->get();
            */

            $columnas_datos = DB::select('SELECT tipos_documentos.id as id, tipos_documentos.descripcion as descripcion FROM requerimientos LEFT JOIN cargo_documento on cargo_documento.cargo_especifico_id = requerimientos.cargo_especifico_id INNER JOIN tipos_documentos on tipos_documentos.estado = 1 and tipos_documentos.categoria = 1 and tipos_documentos.id = cargo_documento.tipo_documento_id WHERE requerimientos.id = ? ORDER BY tipos_documentos.id ASC', [$req_id]);

            $headersr[] = 'NOMBRES';
            $headersr[] = 'APELLIDOS';
            $headersr[] = 'NRO. IDENTIFICACIÓN';
            foreach ($columnas_datos as $columna) {
                $headersr[] = $columna->descripcion;
            }
            $headersr[] = 'PORCENTAJE DOC. CARGADOS';
            $headersr[] = 'ACCIÓN';
        }
        return $headersr;
    }

    /*
    *   Contenido de tabla o archivo excel
    */
    private function getDataDocumentosCandidatos($request, $columnas_datos)
    {
        if(isset($request->req_id)){
           $num_req = $request['req_id'];
        }
        $generar_datos = $request['generar_datos'];
        $formato      = ($request->has('formato')) ? $request->formato : 'html';

        $data = "";

        if($num_req != '' && count($columnas_datos) > 0){

            //$tipos_doc_ids[] = implode(',', array_column($columnas_datos, 'id'));

            $data = DatosBasicos::leftjoin("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "datos_basicos.user_id")
                ->leftjoin("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->where("requerimientos.id", $num_req)
                ->select(
                    "datos_basicos.user_id",
                    "datos_basicos.nombres",
                    "datos_basicos.primer_apellido",
                    "datos_basicos.segundo_apellido",
                    "datos_basicos.numero_id",
                    "datos_basicos.telefono_movil"
                )
            ->orderBy("datos_basicos.user_id")
            ->groupBy("datos_basicos.user_id");

        } else if (count($columnas_datos) === 0 && isset($generar_datos) && $num_req != '') {
            session()->flash('mensaje_warning', 'El cargo de este requerimiento no tiene documentos asociados.');
        } else if (isset($generar_datos)) {
            session()->flash('mensaje_warning', 'Debe ingresar el requerimiento');
        }

        if($data != ""){
            if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
                $data = $data->get();
            }else{
                $data = $data->paginate(6);
            }
        }

        $total_documentos = count($columnas_datos);
        foreach ($data as &$candidato) {
            $cant_doc_cargados = 0;
            $doc_candidato = Documentos::where('user_id', $candidato->user_id)
            //->whereIn('tipo_documento_id', $tipos_doc_ids)
            ->where(function($query) use ($num_req)
                {
                    $query->where('requerimiento', $num_req)
                          ->orWhereNull('requerimiento');
                })
            ->select("nombre_archivo", "tipo_documento_id")
            ->orderBy('created_at', 'desc')
            ->get();
            $candidato["documentos"] = collect([]);
            $candidato["porcentaje"] = 0;
            foreach ($columnas_datos as $tipo_doc) {
                $documentos = [
                    'id' => $tipo_doc->id,
                    'descripcion' => $tipo_doc->descripcion,
                    'documentos' => $doc_candidato->where('tipo_documento_id', $tipo_doc->id)->take(3)
                ];
                $candidato["documentos"]->push($documentos);
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
        unset($candidato);

        return $data;
    }

    private function getHeaderEnviadosExamMedicos()
    {
        $headersr = [
            '#Identificación',
            'Nombres y Apellidos',
            '#Req.',
            'Cliente',
            'NIT Cliente',
            'Centro de Costos',
            'Fecha Realización Examen',
            'Resultado',
            'Usuario envió'
        ];
        return $headersr;
    }

    private function getDataEnviadosExamMedicos($request)
    {
      $rango_fecha = $request->rango_fecha;
      $candidatos_con_examenes = $request->candidatos_archivos;
      $generar_datos = $request['generar_datos'];
      $formato      = ($request->has('formato')) ? $request->formato : 'html';

      $data = "vacio";
      if ($candidatos_con_examenes != null && $candidatos_con_examenes != "" && $rango_fecha != "") {
        $rango = explode(" | ", $rango_fecha);
        $fecha_inicio = $rango[0];
        $fecha_final  = $rango[1];
        $descripcion_archivo = "EXAMENES MÉDICOS";

        $data = RegistroProceso::join("datos_basicos", "datos_basicos.user_id", "=", "procesos_candidato_req.candidato_id")
          ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
          ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
          ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
          ->leftjoin("centros_costos_produccion", "centros_costos_produccion.id", "=", "requerimientos.centro_costo_id")
          ->join("documentos", function ($join) {
                $join->on('documentos.requerimiento', '=', 'procesos_candidato_req.requerimiento_id')
                    ->on('documentos.user_id', '=', 'procesos_candidato_req.candidato_id');
          })
          ->whereBetween("procesos_candidato_req.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59'])
          ->where('documentos.descripcion_archivo', 'EXAMENES MÉDICOS')
          ->where("procesos_candidato_req.proceso", "ENVIO_EXAMENES")
            ->where(function ($query) {
                $ids_clientes_prueba = [];
                if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                    $query->whereNotIn("clientes.id", $ids_clientes_prueba);
                }
            })
          ->select(
              "centros_costos_produccion.descripcion as centro_costo",
              "clientes.nit",
              "clientes.nombre as cliente",
              "datos_basicos.user_id",
              "datos_basicos.nombres",
              "datos_basicos.primer_apellido",
              "datos_basicos.segundo_apellido",
              "datos_basicos.numero_id",
              "requerimientos.id as requerimiento",
              DB::raw("(select CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido) from datos_basicos where procesos_candidato_req.usuario_envio = datos_basicos.user_id AND procesos_candidato_req.requerimiento_id = requerimientos.id LIMIT 1) as usuario_envio")
          )
        ->orderBy("procesos_candidato_req.created_at", "desc");
      } elseif($rango_fecha != "") {
        $rango = explode(" | ", $rango_fecha);
        $fecha_inicio = $rango[0];
        $fecha_final  = $rango[1];
        $descripcion_archivo = "EXAMENES MÉDICOS";

        $data = RegistroProceso::join("datos_basicos", "datos_basicos.user_id", "=", "procesos_candidato_req.candidato_id")
          ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
          ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
          ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
          ->leftjoin("centros_costos_produccion", "centros_costos_produccion.id", "=", "requerimientos.centro_costo_id")
          ->where(function($sql) use ($fecha_inicio, $fecha_final)
          {
              if ($fecha_inicio != "" && $fecha_final != "") {
                  $sql->whereBetween("procesos_candidato_req.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
              }
          })
          ->where("procesos_candidato_req.proceso", "ENVIO_EXAMENES")
            ->where(function ($query) {
                $ids_clientes_prueba = [];
                if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                    $query->whereNotIn("clientes.id", $ids_clientes_prueba);
                }
            })
          ->select(
              "centros_costos_produccion.descripcion as centro_costo",
              "clientes.nit",
              "clientes.nombre as cliente",
              "datos_basicos.user_id",
              "datos_basicos.nombres",
              "datos_basicos.primer_apellido",
              "datos_basicos.segundo_apellido",
              "datos_basicos.numero_id",
              "requerimientos.id as requerimiento",
              DB::raw("(select CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido) from datos_basicos where procesos_candidato_req.usuario_envio = datos_basicos.user_id AND procesos_candidato_req.requerimiento_id = requerimientos.id LIMIT 1) as usuario_envio")
          )
        ->orderBy("procesos_candidato_req.created_at", "desc");
      } else if (isset($generar_datos)) {
        session()->flash('mensaje_warning', 'Debe seleccionar un rango de fecha');
      }

      if($data != "vacio"){
        if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
            $data = $data->get();
        }else{
            $data = $data->paginate(6);
        }

        foreach ($data as &$candidato) {
            $cant_doc_cargados = 0;
            $doc_candidato = Documentos::where('user_id', $candidato->user_id)
              ->where('requerimiento', $candidato->requerimiento)
              ->where('descripcion_archivo', 'EXAMENES MÉDICOS')
              ->select("fecha_realizacion", "resultado")
              ->orderBy('created_at', 'desc')
            ->get();
            $candidato["examenes_medicos"] = collect([]);

            foreach ($doc_candidato as $doc) {
              $exam_med = [
                  'fecha_realizacion' => $doc->fecha_realizacion,
                  'resultado' => $doc->resultado
              ];
              $candidato['examenes_medicos']->push($exam_med);
            }
        }
        unset($candidato);

      }
      //dd($data);
      return $data;
    }
    // acuerdate de la rama
    private function getHeaderValidacionDocumental($request, &$columnas_datos)
    {
        $headersr = [];
        $columnas_datos = TipoDocumento::where('estado', 1)->whereIn('categoria', [1, 2, 4])->select('id', 'descripcion', 'categoria')->orderBy('categoria', 'desc')->get();

        $headersr[] = 'NOMBRES';
        $headersr[] = 'APELLIDOS';
        $headersr[] = 'NRO. IDENTIFICACIÓN';
        $headersr[] = 'REQUERIMIENTOS';
        $headersr[] = 'CARGO';
        $headersr[] = 'CLIENTE';
        foreach ($columnas_datos as $columna) {
            $headersr[] = $columna->descripcion;
        }
        $headersr[] = 'ACCIÓN';
        return $headersr;
    }

    /*
    *   Contenido de tabla o archivo excel
    */
    private function getDataValidacionDocumental($request, $columnas_datos)
    {
        $numero_id = $request['numero_id'];
        $rango_fecha = $request->rango_fecha;
        $cliente = $request->cliente_id;
        $generar_datos = $request['generar_datos'];
        $formato      = ($request->has('formato')) ? $request->formato : 'html';

        $data = "vacio";

        if(($numero_id != '' || $rango_fecha != "" || $cliente != "") && count($columnas_datos) > 0){
            if($rango_fecha != ""){
              $rango = explode(" | ", $rango_fecha);
              $fecha_inicio = $rango[0];
              $fecha_final  = $rango[1];
            }

            $data = DatosBasicos::leftjoin("firma_contratos", "firma_contratos.user_id", "=", "datos_basicos.user_id")
                ->join("requerimientos", "requerimientos.id", "=", "firma_contratos.req_id")
                ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
                ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
                ->leftjoin("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->where(function($sql) use ($fecha_inicio, $fecha_final, $numero_id, $cliente)
                {
                    if ($fecha_inicio != "" && $fecha_final != "") {
                        $sql->whereBetween("firma_contratos.fecha_firma", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                    }
                    if ($numero_id != "") {
                        $sql->where("datos_basicos.numero_id", $numero_id);
                    }
                    if ($cliente != "") {
                        $sql->where("clientes.id", $cliente);
                    }
                })
                ->whereIn("firma_contratos.terminado", [1, 2, 3])
                ->where("firma_contratos.estado", 1)
                ->where(function ($query) use ($cliente) {
                    if($cliente == '' || $cliente == null) {
                        $ids_clientes_prueba = [];
                        if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                            $query->whereNotIn("clientes.id", $ids_clientes_prueba);
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
                    "clientes.nombre as cliente",
                    "cargos_especificos.id as cargo_id",
                    "cargos_especificos.descripcion as cargo",
                    "firma_contratos.req_id"
                )
                ->orderBy("firma_contratos.fecha_firma", "desc");
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
                    ->where('documentos.active',1)
                    ->select("nombre_archivo", "tipo_documento_id", "descripcion_archivo", "requerimiento")
                    ->orderBy('created_at', 'desc')
                    ->get();
                $candidato["documentos"] = collect([]);
                $candidato["porcentaje"] = 0;
                foreach ($columnas_datos as $tipo_doc) {
                    if ($tipo_doc->categoria == 1) {
                        $documentos = [
                            'id' => $tipo_doc->id,
                            'descripcion' => $tipo_doc->descripcion,
                            'documentos' => $doc_candidato->where('tipo_documento_id', $tipo_doc->id)->take(3)
                        ];
                    } else {
                        $documentos = [
                            'id' => $tipo_doc->id,
                            'descripcion' => $tipo_doc->descripcion,
                            'documentos' => $doc_candidato->where('tipo_documento_id', $tipo_doc->id)->where('requerimiento', $candidato->req_id)->take(3)
                        ];
                    }
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
            }
            unset($candidato);
        }


        return $data;
    }

    private function getHeaderDetalleContratacion()
    {

        $headersr = [
            'N° de cédula',
            'Nombres',
            'Apellido',
            'N° Requerimiento',
            'Fecha requerimiento',
            'Cliente',
            'Cargo',
            'Fecha de asociación',
            'Fecha envio contratación',
            'Usuario envio',
            'Usuario que asoció',
            'Fuente de Reclutamiento',
            'Estado del candidato en el Requerimiento',
            'Estado del Requerimiento',
            'Fecha recepcion'
            

            
        ];
        return $headersr;
    }
    private function getHeaderInformeCrecimiento()
    {

        $headersr = [
            '#Req',
            'Cargo',
            'Cliente',
            'Ciudad req',
            'Agencia req',
            'Usuario req',
            'Fecha requerimiento',
            'Estado del Requerimiento',
            '#Vacantes',
            '#Candidatos asociados',
            'Cédula',
            'Nombres',
            'Apellidos',
            'Email',
            'Fecha nacimiento',
            'Ciudad residencia',
            'Género',
            'Fecha registro',
            'Fecha actualización',
            'Fuente reclutamiento',
            'usuario cargó'

            

            
        ];
        return $headersr;
    }

    private function getDataDetalleReclu($request)
    {
        $fecha_inicio = $request->fecha_inicio;
        $fecha_final  = $request->fecha_final;
        $cliente_id   = $request->cliente_id;
        $criterio     = $request->criterio;
        $usuario      = $request->usuario_gestion;
        $formato      = ($request->has('formato')) ? $request->formato : 'html';
        $agencia      = $request->agencia;
        $metodo       = $request->metodo;
        $ciudad_id    = $request->ciudad_id;
        $dpto_id    = $request->departamento_id;
        $pais_id    = $request->pais_id;
        $data = "vacio";
        
        // Data
        if($fecha_inicio != "" || $fecha_final != "" ||  $cliente_id != "" || $criterio != "" ||
            $usuario != "" || $agencia != "" || $metodo != "" || $ciudad_id != null){
            
            $data = DB::table('users')->join('datos_basicos', 'datos_basicos.user_id', '=', 'users.id')
            //->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->leftjoin('ciudad', function ($join) {
                $join->on('datos_basicos.ciudad_residencia', '=', 'ciudad.cod_ciudad')
                    ->on('datos_basicos.departamento_residencia', '=', 'ciudad.cod_departamento')
                    ->on('datos_basicos.pais_residencia', '=', 'ciudad.cod_pais');
            })
            ->leftjoin('departamentos', function ($join2) {
                $join2->on('datos_basicos.departamento_residencia', '=', 'departamentos.cod_departamento')
                    ->on('datos_basicos.pais_residencia', '=', 'departamentos.cod_pais');
            })
            ->leftjoin('paises', 'datos_basicos.pais_residencia', '=', 'paises.cod_pais')
            ->leftjoin("metodo_carga","metodo_carga.id","=","users.metodo_carga")
            ->leftjoin("tipo_fuente","tipo_fuente.id","=","users.tipo_fuente_id")

            //->leftjoin('requerimiento_cantidato','users.id','=','requerimiento_cantidato.candidato_id')
            //-Seleccionar->leftjoin("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")

            //->leftjoin("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
            //->whereRaw('requerimiento_cantidato.id=(select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.candidato_id=users.id)')
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio, $usuario, $agencia, $metodo,$ciudad_id, $dpto_id, $pais_id){
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("users.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }

                if ((int) $metodo > 0 && $metodo!= "") {
                    $sql->where("metodo_carga.id", $metodo);
                }

                if ((int) $agencia > 0 && $agencia != "") {
                    $sql->where("ciudad.agencia", $agencia);
                }

                if ($usuario != "") {
                    $sql->where("users.usuario_carga", $usuario);
                }

                if ($ciudad_id != null) {
                    $sql->where("ciudad.cod_ciudad", $ciudad_id)
                    ->where("ciudad.cod_departamento", $dpto_id)
                    ->where("ciudad.cod_pais", $pais_id);
                }
            })
            //->join('users','users.id','=','requerimiento_cantidato.candidato_id')
            //->join('datos_basicos','datos_basicos.user_id','=','users.id') 
            //->where("requerimiento_cantidato.estado_candidato", "!=", config('conf_aplicacion.C_INACTIVO'))
            //->where("requerimiento_cantidato.estado_candidato", "!=", config('conf_aplicacion.C_QUITAR'))
            /*->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$usuario,$agencia) {
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("users.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                }
                if ((int) $agencia > 0 && $agencia != "") {
                    $sql->where("ciudad.agencia", $agencia);
                }
                 if ($usuario != "") {
                    $sql->where("estados_requerimiento.user_gestion", $usuario);
                }
                switch ($criterio) {
                    case 1: //Req abiertas
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                        ]);
                        break;
                    case 2: //CERRADAS OPORTUNAMENTE
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->whereRaw("requerimientos_estados.fecha_ultimo_estado<=requerimientos.fecha_terminacion");
                        break;
                    case 3: //requi contratadas
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        break;
                    default:
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                        ]);
                }
            })*/
            ->select(
                //'requerimientos.id as numero_requerimiento',
                'datos_basicos.*',
                //'datos_basicos.nombres',
                //'datos_basicos.primer_apellido',
                //'datos_basicos.segundo_apellido',
                //'estados.descripcion as estado_candidato',
                //'datos_basicos.user_id',
                //'datos_basicos.telefono_movil',
                'ciudad.nombre as ciudad_residencia',
                //'requerimiento_cantidato.requerimiento_id',
                'users.created_at as fecha_carga',
                'tipo_fuente.descripcion as descripcion_fuente',
                'metodo_carga.id as metodo_carga_id',
                'metodo_carga.descripcion as metodo_carga',
                DB::raw("(select CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido) from datos_basicos where user_id=users.usuario_carga) as usuario_carga"),
                DB::raw('(select upper(x.descripcion) as estado from requerimiento_cantidato y inner join estados x on y.estado_candidato=x.id where y.id=(select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.candidato_id=users.id)) as estado_candidato'),
                DB::raw('(select requerimiento_cantidato.requerimiento_id as requerimiento from requerimiento_cantidato where requerimiento_cantidato.id=(select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.candidato_id=users.id)) as requerimiento'),
                DB::raw('(select upper(x.descripcion) as estado from datos_basicos y inner join estados x on y.estado_reclutamiento=x.id where y.user_id=users.id) as estado_reclutamiento')
                /*DB::raw('DATE_FORMAT(requerimiento_cantidato.created_at, \'%Y-%m-%d\') as fecha_asociacion'),
                DB::raw('(select upper(p.name)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id and o.estado = ' . config('conf_aplicacion.C_EN_PROCESO_SELECCION') . ' order by o.created_at desc limit 1) as usuario_gestiono_req'),
                DB::raw('(select upper(x.descripcion) as estado from requerimiento_cantidato y inner join tipo_fuente x on y.otra_fuente=x.id where y.requerimiento_id=requerimientos.id limit 1 ) as fuentes'),                
                DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req')*/
            )
            ->orderBy('users.created_at','desc')
            ->groupBy("users.numero_id") ;

            if ($request->has('formato') and ($formato == "xlsx" || $formato == "pdf")) {
                $data = $data->get();
            } else {
                $data = $data->paginate(5);
            }
        }

        return $data;

        /*$data = DB::table('requerimientos')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
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
            
            ->join('requerimiento_cantidato','requerimientos.id','=','requerimiento_cantidato.requerimiento_id')
            ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
            ->join('users','users.id','=','requerimiento_cantidato.candidato_id')
            ->join('datos_basicos','datos_basicos.user_id','=','users.id') 
            ->where("requerimiento_cantidato.estado_candidato", "!=", config('conf_aplicacion.C_INACTIVO'))
            ->where("requerimiento_cantidato.estado_candidato", "!=", config('conf_aplicacion.C_QUITAR'))
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$usuario,$agencia) {
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("requerimientos_estados.fecha_creacion_req", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                }
                if ((int) $agencia > 0 && $agencia != "") {
                    $sql->where("ciudad.agencia", $agencia);
                }
                 if ($usuario != "") {
                    $sql->where("estados_requerimiento.user_gestion", $usuario);
                }
                switch ($criterio) {
                    case 1: //Req abiertas
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                        ]);
                        break;
                    case 2: //CERRADAS OPORTUNAMENTE
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->whereRaw("requerimientos_estados.fecha_ultimo_estado<=requerimientos.fecha_terminacion");
                        break;
                    case 3: //requi contratadas
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        break;
                    default:
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                        ]);
                }
            })
            ->select(
                'requerimientos.id as numero_requerimiento',
                'datos_basicos.numero_id',
                 'datos_basicos.nombres',
                 'datos_basicos.primer_apellido',
                 'estados.descripcion as estado_candidato',

                DB::raw('DATE_FORMAT(requerimiento_cantidato.created_at, \'%Y-%m-%d\') as fecha_asociacion'),
                
                DB::raw('(select upper(p.name)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id and o.estado = ' . config('conf_aplicacion.C_EN_PROCESO_SELECCION') . ' order by o.created_at desc limit 1) as usuario_gestiono_req'),
                
                
                DB::raw('(select upper(x.descripcion) as estado from requerimiento_cantidato y inner join tipo_fuente x on y.otra_fuente=x.id where y.requerimiento_id=requerimientos.id limit 1 ) as fuentes'),
                
                DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req')

            )->orderBy('requerimientos.id') ;

            if ($request->has('formato') and ($formato == "xlsx" || $formato == "pdf")) {
                $data = $data->get();
            } else {
                $data = $data->paginate(5);
            }
        }
        return $data;*/
    }


      private function getDataDetalleContratacion($request)
    {

        $fecha_inicio = $request->fecha_inicio;
        $fecha_final  = $request->fecha_final;
        $cliente_id   = $request->cliente_id;
        $criterio     = $request->criterio;
        $req_id       =$request->req_id;
        $usuario      = $request->usuario_gestion;
        $formato      = ($request->has('formato')) ? $request->formato : 'html';
        $agencia      =$request->agencia;
        //dd($formato);
        // Data
        $data = DB::table('requerimientos')->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
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
            
            ->join('requerimiento_cantidato','requerimientos.id','=','requerimiento_cantidato.requerimiento_id')
            ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
            ->join('users','users.id','=','requerimiento_cantidato.candidato_id')
            ->join('datos_basicos','datos_basicos.user_id','=','users.id') 
            ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
        ->where("requerimiento_cantidato.estado_candidato", "!=", config('conf_aplicacion.C_INACTIVO'))
            ->where("requerimiento_cantidato.estado_candidato", "!=", config('conf_aplicacion.C_QUITAR'))
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$usuario,$agencia,$req_id) {
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
              
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("clientes.id", $cliente_id);
                }
                if ((int) $agencia > 0 && $agencia != "") {
                    $sql->where("ciudad.agencia", $agencia);
                }
                 if ($usuario != "") {
                    $sql->where("estados_requerimiento.user_gestion", $usuario);
                }

                if ($req_id != "") {
                    $sql->where("requerimientos.id", $req_id);
                }
               
            })
            ->where(function ($query) use ($cliente_id) {
                if($cliente_id == '' || $cliente_id == null) {
                    $ids_clientes_prueba = [];
                    if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                        $query->whereNotIn("clientes.id", $ids_clientes_prueba);
                    }
                }
            })
            ->select(
                'requerimientos.id as numero_requerimiento',
                
                'datos_basicos.numero_id',
                 'datos_basicos.nombres',
                 'datos_basicos.primer_apellido',
                 'estados.descripcion as estado_candidato',
                 'clientes.nombre as cliente',
                 'cargos_especificos.descripcion as cargo',
                 'requerimientos.fecha_recepcion as fecha_recepcion',


                 DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id order by procesos_candidato_req.id DESC limit 1) as fecha_contratacion '),

                  DB::raw('(select usuario_envio from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id order by procesos_candidato_req.id DESC limit 1) as usuario_envio_contratacion'),
                 
                 DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_requerimiento'),

                DB::raw('DATE_FORMAT(requerimiento_cantidato.created_at, \'%Y-%m-%d\') as fecha_asociacion'),
                DB::raw('(select estados.descripcion from estados where estados.id=estados_requerimiento.estado) as estado_req'),
                
                DB::raw('(select upper(p.name)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id and o.estado = ' . config('conf_aplicacion.C_EN_PROCESO_SELECCION') . ' order by o.created_at desc limit 1) as usuario_gestiono_req'),
                
                
                DB::raw('(select upper(x.descripcion) as estado from requerimiento_cantidato y inner join tipo_fuente x on y.otra_fuente=x.id where y.requerimiento_id=requerimientos.id limit 1 ) as fuentes')
              
            )
            ->groupBy('datos_basicos.numero_id','requerimientos.id')
            ->orderBy('requerimientos.id') ;

           // dd($data);
//dd($data->toSql());
        if ($request->has('formato') and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
        } else {
            $data = $data->paginate(5);
        }

        return $data;

    }

     private function getDataInformeCrecimiento($request)
    {

        $fecha_inicio = $request->fecha_inicio;
        $fecha_final  = $request->fecha_final;
        $cliente_id   = $request->cliente_id;
        $criterio     = $request->criterio;
        $req_id       =$request->req_id;
        $usuario      = $request->usuario_gestion;
        $formato      = ($request->has('formato')) ? $request->formato : 'html';
        $agencia      =$request->agencia;
        //dd($formato);
        // Data

         if ( $fecha_inicio!='' ||  $fecha_final != '' ||  $cliente_id != '' || $criterio != '' || $usuario != '' || $agencia  != ''  || $req_id != ''){
        $data = DB::table('datos_basicos')
        ->join('users','users.id','=','datos_basicos.user_id')
        ->leftjoin('requerimiento_cantidato','users.id','=','requerimiento_cantidato.candidato_id')
        ->leftjoin("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
        //->leftjoin('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
        ->leftjoin("tipo_fuente","requerimiento_cantidato.otra_fuente","=","tipo_fuente.id")
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
            
            
            //->leftjoin("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
            
            
            ->leftjoin('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->leftjoin('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->leftjoin('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
            ->leftjoin('generos', 'generos.id', '=', 'datos_basicos.genero')
            ->leftjoin("agencias","agencias.id","=","ciudad.agencia")
        //->where("requerimiento_cantidato.estado_candidato", "!=", config('conf_aplicacion.C_INACTIVO'))
            //->where("requerimiento_cantidato.estado_candidato", "!=", config('conf_aplicacion.C_QUITAR'))
        //->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$usuario,$agencia,$req_id) {
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("datos_basicos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
              
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("clientes.id", $cliente_id);
                }
                if ((int) $agencia > 0 && $agencia != "") {
                    $sql->where("ciudad.agencia", $agencia);
                }
                 if ($usuario != "") {
                    $sql->where("estados_requerimiento.user_gestion", $usuario);
                }

                if ($req_id != "") {
                    $sql->where("requerimientos.id", $req_id);
                }
               
            })
            ->select(
                'requerimientos.id as numero_requerimiento',
                'tipo_fuente.descripcion as fuentes',
                'datos_basicos.numero_id',
                 'datos_basicos.nombres',
                 'datos_basicos.primer_apellido',
                 //'estados.descripcion as estado_candidato',
                 'clientes.nombre as cliente',
                 'cargos_especificos.descripcion as cargo',
                 'requerimientos.fecha_recepcion as fecha_recepcion',
                 'requerimientos.num_vacantes as vacantes',
                 'datos_basicos.email as email',
                 'requerimientos.solicitado_por as usuario_req',
                 'datos_basicos.fecha_nacimiento',
                 'generos.descripcion as genero',
                 'datos_basicos.created_at as fecha_registro',
                 'datos_basicos.updated_at as fecha_actualizacion',
                 'ciudad.nombre as ciudad_req',
                 'agencias.descripcion as agencia',
                 'datos_basicos.usuario_cargo',


                 DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id order by procesos_candidato_req.id DESC limit 1) as fecha_contratacion '),

                 DB::raw('(select estados.descripcion from estados, estados_requerimiento where estados_requerimiento.estado=estados.id and estados_requerimiento.req_id=requerimientos.id and estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)) as estado_req '),

                DB::raw('(select count(*) from requerimiento_cantidato where requerimiento_id=requerimientos.id and estado_candidato not in(14,22)) as candidatos_asociados'),

                  DB::raw('(select usuario_envio from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id order by procesos_candidato_req.id DESC limit 1) as usuario_envio_contratacion'),
                 
                 DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_requerimiento'),

                DB::raw('DATE_FORMAT(requerimiento_cantidato.created_at, \'%Y-%m-%d\') as fecha_asociacion'),
                //DB::raw('(select estados.descripcion from estados where estados.id=estados_requerimiento.estado) as estado_req'),
                
                DB::raw('(select upper(p.name)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id and o.estado = ' . config('conf_aplicacion.C_EN_PROCESO_SELECCION') . ' order by o.created_at desc limit 1) as usuario_gestiono_req')
                
                
                //DB::raw('(select upper(x.descripcion) as estado from requerimiento_cantidato y inner join tipo_fuente x on y.otra_fuente=x.id where y.requerimiento_id=requerimientos.id limit 1 ) as fuentes')
              
            )
            ->groupBy('datos_basicos.user_id')
            ->orderBy('datos_basicos.created_at',"DESC") ;



           // dd($data);
//dd($data->toSql());
        if ($request->has('formato') and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
        } else {
            $data = $data->paginate(5);
        }

        return $data;

         }
    }



    private function getDataDetalleDemanda($request)
    {

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_final  = $request['fecha_final'];
        $cliente_id   = $request['cliente_id'];
        $criterio   = $request['criterio'];
        $usuario_gestion = $request['usuario_gestion'];

        $formato      = ($request['formato']) ? $request['formato'] : 'html';

        // Data
        $data = DB::table('requerimientos')->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
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
            
        ->join('requerimiento_cantidato','requerimientos.id','=','requerimiento_cantidato.requerimiento_id')
        ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
        ->join('users','users.id','=','requerimiento_cantidato.candidato_id')
        ->join('datos_basicos','datos_basicos.user_id','=','users.id')
        ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
        ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
        ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
        ->join('generos', 'requerimientos.genero_id', '=', 'generos.id')
        ->join('niveles_estudios', 'requerimientos.nivel_estudio', '=', 'niveles_estudios.id')
        ->where("requerimiento_cantidato.estado_candidato", "!=", config('conf_aplicacion.C_INACTIVO'))
        ->where("requerimiento_cantidato.estado_candidato", "!=", config('conf_aplicacion.C_QUITAR'))
        ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id,$criterio,$usuario_gestion) {
            
            if($fecha_inicio != "" && $fecha_final != "") {
             
             $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
            }
            
            if((int) $cliente_id > 0 && $cliente_id != "") {
             $sql->where("negocio.cliente_id", $cliente_id);
            }

            if($usuario_gestion != "") {
             
             $sql->where("estados_requerimiento.user_gestion",$usuario_gestion);
            }

            switch ($criterio) {
                case 1: //Req abiertas
                    $sql->whereIn("requerimientos_estados.max_estado", [
                        config('conf_aplicacion.C_TERMINADO'),
                        config('conf_aplicacion.C_RECLUTAMIENTO'),
                        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                        config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                        config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                    ]);
                    break;
                case 2: //CERRADAS OPORTUNAMENTE
                    $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                    $sql->whereRaw("requerimientos_estados.fecha_ultimo_estado<=requerimientos.fecha_terminacion");
                    break;
                case 3: //requi contratadas
                    $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                    break;
                default:
                    $sql->whereIn("requerimientos_estados.max_estado", [
                        config('conf_aplicacion.C_TERMINADO'),
                        config('conf_aplicacion.C_RECLUTAMIENTO'),
                        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                        config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                        config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                    ]);
            }
        })
        ->select(
            'requerimientos.id as numero_requerimiento',
            'datos_basicos.numero_id',
            'datos_basicos.nombres',
            'datos_basicos.primer_apellido',
            'estados.descripcion as estado_candidato',
            'clientes.nit as nit',
            'requerimientos.created_at as fecha_requerimiento',
            'cargos_especificos.descripcion as cargo',
            'requerimientos.num_vacantes as vacantes',
            'requerimientos.salario as salario',
            'generos.descripcion as genero',
            'departamentos.nombre as departamento',
            'niveles_estudios.descripcion as nivel_estudio',
            DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion')
        )
        ->groupBy("requerimientos.id")
        ->orderBy('requerimientos.id');

        if (isset($request['formato']) and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
        } else {
            $data = $data->paginate(5);
        }

        return $data;
    }

    private function getDataDetalleOferta($request)
    {
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_final  = $request['fecha_final'];
        $cliente_id   = $request['cliente_id'];
        $usuario_gestion   = $request['usuario_gestion'];

        $criterio     =$request['criterio'];
        $formato      = ($request['formato']) ? $request['formato'] : 'html';
        
        // Data
        $data = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", '=', "requerimiento_candidato_id")
        ->join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
        ->join("estados_requerimiento","estados_requerimiento.req_id","=","requerimiento_cantidato.requerimiento_id")
        ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
        ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
        ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join('generos','datos_basicos.genero','=','generos.id')
        ->join('aspiracion_salarial','datos_basicos.aspiracion_salarial','=','aspiracion_salarial.id')
        ->join('cargos_especificos','requerimientos.cargo_especifico_id','=','cargos_especificos.id')
        ->join('motivo_requerimiento','requerimientos.motivo_requerimiento_id','=','motivo_requerimiento.id')
        ->where("proceso","ENVIO_CONTRATACION")
        ->where(function ($where) use ($fecha_inicio,$fecha_final,$cliente_id,$criterio,$usuario_gestion) {
                     
            if ($fecha_inicio != "" && $fecha_final != "") {
                $where->whereBetween("requerimientos.created_at",[$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
            }

            if($cliente_id != "" && $cliente_id != "") {
              $where->where("negocio.cliente_id", $cliente_id);
            }

            if($usuario_gestion != "") {
              $where->where("estados_requerimiento.user_gestion",$usuario_gestion);
            }
        
        })
        ->select(
            'datos_basicos.user_id as user_id',
            'datos_basicos.fecha_nacimiento as fecha_nacimiento',
            'datos_basicos.numero_id as cedula', 
            'datos_basicos.nombres as nombres',
            'datos_basicos.fecha_nacimiento as fecha_nacimiento',
            'generos.descripcion as genero',
            'datos_basicos.primer_apellido as primer_apellido',
            'datos_basicos.segundo_apellido as segundo_apellido',
            'cargos_especificos.descripcion as cargo',
            'requerimientos.salario as salario',
            'clientes.nit as nit_cliente',
            'procesos_candidato_req.fecha_inicio_contrato as frecha_inicio',
            'requerimientos.fecha_terminacion as frecha_fin',
            'procesos_candidato_req.estado_contrato as estado_contrato',
            'motivo_requerimiento.descripcion as motivo'
        )
        ->groupBy('procesos_candidato_req.id');

        /*
            $data2 = DB::table('datos_basicos')
                 ->join("departamentos", function ($join) {
                    $join
                        ->on("departamentos.cod_departamento", "=", "datos_basicos.departamento_residencia");
                })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_ciudad", "=", "datos_basicos.ciudad_residencia")
                    ->on("ciudad.cod_departamento", "=", "datos_basicos.departamento_residencia")
                    ->on('ciudad.cod_pais', '=', 'datos_basicos.pais_residencia');
                })

                ->join('generos','datos_basicos.genero','=','generos.id')
                ->join('aspiracion_salarial','datos_basicos.aspiracion_salarial','=','aspiracion_salarial.id')
                ->leftjoin('experiencias','datos_basicos.numero_id','=','experiencias.numero_id')
                ->join('estados','datos_basicos.estado_reclutamiento','=','estados.id')
               
                //->where("estados.id",11)
                //->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_RECLUTAMIENTO'))
                ->select(
                    'datos_basicos.user_id as user_id',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.numero_id as cedula', 
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'generos.descripcion as genero',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido',
                    'ciudad.nombre as ciudad',
                    'experiencias.cargo_especifico as cargo',
                    'experiencias.funciones_logros as funciones',
                    'datos_basicos.telefono_movil as celular',
                    'datos_basicos.descrip_profesional as descripcion',
                     'datos_basicos.email as email',
                     'estados.descripcion as estado_candidato',

                     DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                    
                    DB::raw('( count(experiencias.numero_id)) as experiencias'),
                      DB::raw('(select count(estudios.numero_id)
                                from estudios
                                 where estudios.numero_id = datos_basicos.numero_id       
                                      )    as estudios'),
                     DB::raw('(select count(grupos_familiares.user_id)
                                from grupos_familiares
                                 where grupos_familiares.numero_id = datos_basicos.numero_id       
                                      )    as grupos_familiares'),
                       DB::raw('(select count(referencias_personales.numero_id)
                                from referencias_personales
                                 where referencias_personales.numero_id = datos_basicos.numero_id      
                                      )    as referencias_personales'),
                     DB::raw('(select (datos_basicos.datos_basicos_count *0.3)+(datos_basicos.perfilamiento_count * 0.1)) as hv_count'),
                     
                     
                     DB::raw('DATE_FORMAT(datos_basicos.updated_at, \'%Y-%m-%d\') as fecha_actualizacion')
                )
                ->where(function ($where) use ($request) {
                     
                    if($request->get('palabra_clave')!="")
                    {

                        $where->whereRaw("( LOWER(experiencias.cargo_especifico) like '%" . $request->get("palabra_clave") . "%'or LOWER(experiencias.funciones_logros) like '%" . $request->get("palabra_clave") . "%'or LOWER(datos_basicos.descrip_profesional) like '%" . $request->get("palabra_clave") . "%') ");
       
                    }

                    if ($request->get('edad_inicial') != "" && $request->get('edad_final') != "") {
                        $where->whereBetween(DB::raw('round(datediff(now(),fecha_nacimiento)/365)'),[$request->get('edad_inicial'),$request->get('edad_final')]);
                    }

                    if ($request->get('fecha_actualizacion_ini') != "" && $request->get('fecha_actualizacion_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(datos_basicos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_actualizacion_ini'),$request->get('fecha_actualizacion_fin')]);
                    }

                
               

                    if($request->get('estado')!="")
                    {

                      $where->where("estados.descripcion" , $request->get('estado'));
                    }

                    if($request->get('genero_id')!="")
                    {

                        $where->where("generos.id" , $request->get('genero_id'));
                    }
                     
                    if ($request->get("ciudad_id") != "") {
                        $where->where("datos_basicos.ciudad_residencia", $request->get("ciudad_id"));
                    }
                    
                    if ($request->get("departamento_id") != "") {
                        $where->where("datos_basicos.departamento_residencia", $request->get("departamento_id"));
                    }
                 })->groupBy('datos_basicos.user_id');
        */

        if (isset($request['formato']) and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
        } else {
            $data = $data->paginate(5);
        }

        foreach($data as $value){
           
            if($value->nombres != null){
                $nombres=$array = explode(" ", $value->nombres);

                if(count($nombres) == 2){
                    $value["primer_nombre"]=$nombres[0];
                    $value["segundo_nombre"]=$nombres[1];
                }else{
                    $value["primer_nombre"]=$nombres[0];
                    $value["segundo_nombre"]="";
                }
               
            }else{
                $value["primer_nombre"]="";
                $value["segundo_nombre"]="";
            }

        }

        return $data;
    }

     private function getDataDetalleDescargaContratacion($request)
    {
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_final  = $request['fecha_final'];
        $cliente_id   = $request['cliente_id'];

        $criterio     =$request['criterio'];
       $formato      = ($request['formato']) ? $request['formato'] : 'html';
        //dd($formato);
        // Data


        $data= RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", '=', "requerimiento_candidato_id")
            ->join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
             ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            
            ->join('aspiracion_salarial','datos_basicos.aspiracion_salarial','=','aspiracion_salarial.id')
             ->join('cargos_especificos','requerimientos.cargo_especifico_id','=','cargos_especificos.id')
            ->join('motivo_requerimiento','requerimientos.motivo_requerimiento_id','=','motivo_requerimiento.id')
            ->where("proceso","ENVIO_CONTRATACION")
            ->where(function ($where) use ($fecha_inicio,$fecha_final,$cliente_id,$criterio) {
                     
                            if ($fecha_inicio != "" && $fecha_final != "") {
                                $where->whereBetween("procesos_candidato_req.created_at",[$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                            }

                            if ($cliente_id != "" && $cliente_id != "") {
                                $where->where("negocio.cliente_id", $cliente_id);
                            }
                   
                   
                   
                 })
            ->select(
                    'datos_basicos.user_id as user_id',
                    'datos_basicos.departamento_expedicion_id as dpto_exp',
                     'datos_basicos.numero_libreta as libreta',
                      'datos_basicos.clase_libreta as clase_libreta',
                      'datos_basicos.distrito_militar as distrito_militar',
                    'datos_basicos.ciudad_expedicion_id as ciudad_exp',
                     'datos_basicos.barrio as barrio',
                     'datos_basicos.estado_civil as estado_civil',
                      'datos_basicos.telefono_fijo as telefono_fijo',
                    'datos_basicos.direccion as direccion',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.numero_id as cedula', 
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.genero as genero',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido',
                    'cargos_especificos.descripcion as cargo',
                    'datos_basicos.pais_nacimiento as pais',
                    'datos_basicos.departamento_nacimiento as departamento',
                    'datos_basicos.departamento_residencia as departamento_resi',
                    'datos_basicos.ciudad_nacimiento as ciudad',
                    'datos_basicos.ciudad_residencia as ciudad_resi',
                    'datos_basicos.user_id as user_id',
                    'requerimientos.salario as salario',
                    'clientes.nit as nit_cliente',
                     'clientes.id as cliente_id',
                    'procesos_candidato_req.fecha_inicio_contrato as frecha_inicio',
                    'requerimientos.fecha_terminacion as frecha_fin',
                    'procesos_candidato_req.estado_contrato as estado_contrato',
                    'motivo_requerimiento.descripcion as motivo'
            )
            ->groupBy('procesos_candidato_req.id');

            



        /*$data2 = DB::table('datos_basicos')
                 ->join("departamentos", function ($join) {
                    $join
                        ->on("departamentos.cod_departamento", "=", "datos_basicos.departamento_residencia");
                })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_ciudad", "=", "datos_basicos.ciudad_residencia")
                    ->on("ciudad.cod_departamento", "=", "datos_basicos.departamento_residencia")
                    ->on('ciudad.cod_pais', '=', 'datos_basicos.pais_residencia');
                })

                ->join('generos','datos_basicos.genero','=','generos.id')
                ->join('aspiracion_salarial','datos_basicos.aspiracion_salarial','=','aspiracion_salarial.id')
                ->leftjoin('experiencias','datos_basicos.numero_id','=','experiencias.numero_id')
                ->join('estados','datos_basicos.estado_reclutamiento','=','estados.id')
               
                //->where("estados.id",11)
                //->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_RECLUTAMIENTO'))
                ->select(
                    'datos_basicos.user_id as user_id',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.numero_id as cedula', 
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'generos.descripcion as genero',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido',
                    'ciudad.nombre as ciudad',
                    'experiencias.cargo_especifico as cargo',
                    'experiencias.funciones_logros as funciones',
                    'datos_basicos.telefono_movil as celular',
                    'datos_basicos.descrip_profesional as descripcion',
                     'datos_basicos.email as email',
                     'estados.descripcion as estado_candidato',

                     DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                    
                    DB::raw('( count(experiencias.numero_id)) as experiencias'),
                      DB::raw('(select count(estudios.numero_id)
                                from estudios
                                 where estudios.numero_id = datos_basicos.numero_id       
                                      )    as estudios'),
                     DB::raw('(select count(grupos_familiares.user_id)
                                from grupos_familiares
                                 where grupos_familiares.numero_id = datos_basicos.numero_id       
                                      )    as grupos_familiares'),
                       DB::raw('(select count(referencias_personales.numero_id)
                                from referencias_personales
                                 where referencias_personales.numero_id = datos_basicos.numero_id      
                                      )    as referencias_personales'),
                     DB::raw('(select (datos_basicos.datos_basicos_count *0.3)+(datos_basicos.perfilamiento_count * 0.1)) as hv_count'),
                     
                     
                     DB::raw('DATE_FORMAT(datos_basicos.updated_at, \'%Y-%m-%d\') as fecha_actualizacion')
                )
                ->where(function ($where) use ($request) {
                     
                    if($request->get('palabra_clave')!="")
                    {

                        $where->whereRaw("( LOWER(experiencias.cargo_especifico) like '%" . $request->get("palabra_clave") . "%'or LOWER(experiencias.funciones_logros) like '%" . $request->get("palabra_clave") . "%'or LOWER(datos_basicos.descrip_profesional) like '%" . $request->get("palabra_clave") . "%') ");
       
                    }

                    if ($request->get('edad_inicial') != "" && $request->get('edad_final') != "") {
                        $where->whereBetween(DB::raw('round(datediff(now(),fecha_nacimiento)/365)'),[$request->get('edad_inicial'),$request->get('edad_final')]);
                    }

                    if ($request->get('fecha_actualizacion_ini') != "" && $request->get('fecha_actualizacion_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(datos_basicos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_actualizacion_ini'),$request->get('fecha_actualizacion_fin')]);
                    }

                
               

                    if($request->get('estado')!="")
                    {

                      $where->where("estados.descripcion" , $request->get('estado'));
                    }

                    if($request->get('genero_id')!="")
                    {

                        $where->where("generos.id" , $request->get('genero_id'));
                    }
                     
                    if ($request->get("ciudad_id") != "") {
                        $where->where("datos_basicos.ciudad_residencia", $request->get("ciudad_id"));
                    }
                    
                    if ($request->get("departamento_id") != "") {
                        $where->where("datos_basicos.departamento_residencia", $request->get("departamento_id"));
                    }
                 })->groupBy('datos_basicos.user_id');*/

           // dd($data);
//dd($data->toSql());
        if (isset($request['formato']) and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
            
        } else {

            $data = $data->paginate(5);
        }

        foreach($data as $value){
           
            if($value->nombres!=null){

                $nombres=$array = explode(" ", $value->nombres);
                if(count($nombres)==2){
                     $value["primer_nombre"]=$nombres[0];
                $value["segundo_nombre"]=$nombres[1];
                }
                else{
                    $value["primer_nombre"]=$nombres[0];
                $value["segundo_nombre"]="";
                }
               
            }else{
                 $value["primer_nombre"]="";
                $value["segundo_nombre"]="";
            }
        }
        return $data;

    }

    private function getDataDetalleReporteContratados($request)
    {
        $cliente_id   = $request['cliente_id'];
        $req_id   = $request['req_id'];
        $usuario_envio   = $request['usuario_envio'];
        $usuario_aprueba   = $request['usuario_aprueba'];

        $fecha_inicio = "";
        $fecha_final  = "";

        if($request['rango_fecha'] != ""){
            $rango = explode(" | ", $request['rango_fecha']);
            $fecha_inicio = $rango[0];
            $fecha_final  = $rango[1];
        }

        $fecha_inicio_firma = "";
        $fecha_final_firma  = "";

        if($request['rango_fecha_firma'] != ""){
            $rango_firma = explode(" | ", $request['rango_fecha_firma']);
            $fecha_inicio_firma = $rango_firma[0];
            $fecha_final_firma  = $rango_firma[1];
        }

        //$criterio     =$request['criterio'];
       $formato      = ($request['formato']) ? $request['formato'] : 'html';
       $data="vacio";
        //dd($formato);
        // Data
        if($fecha_inicio!="" || $fecha_final!="" || $fecha_inicio_firma!="" || $fecha_final_firma!="" ||  $cliente_id!="" || $usuario_envio!="" || $usuario_aprueba!="" ||  $req_id!=""){

        $data= RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", '=', "requerimiento_candidato_id")
            ->join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
             ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->leftjoin("empresa_logos", "empresa_logos.id", "=", "requerimientos.empresa_contrata")
            ->leftjoin("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->leftjoin("ciudad", function ($join) {
                $join->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
            })
            ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            ->leftjoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
            ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
            ->leftjoin("metodo_carga", "metodo_carga.id", "=", "users.metodo_carga")
             ->join('cargos_especificos','requerimientos.cargo_especifico_id','=','cargos_especificos.id')
             ->leftjoin("cargos_genericos", "cargos_genericos.id", "=", "cargos_especificos.cargo_generico_id")
             ->leftjoin('tipos_salarios', 'tipos_salarios.id', '=', 'requerimientos.tipo_salario')
             ->leftjoin('requerimiento_contrato_candidato', function($join){
                    $join->on('requerimiento_contrato_candidato.requerimiento_id', '=', 'requerimientos.id')
                    ->on('requerimiento_contrato_candidato.candidato_id', '=', 'datos_basicos.user_id');
             })
             ->leftjoin('centros_costos_produccion', 'centros_costos_produccion.id', '=', 'requerimiento_contrato_candidato.centro_costo_id')
             ->leftjoin('firma_contratos', function($join){
                    $join->on('firma_contratos.req_id', '=', 'requerimientos.id')
                        ->on('firma_contratos.user_id', '=', 'datos_basicos.user_id');
             })
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
            ->leftjoin("fondo_cesantias", "fondo_cesantias.id", "=", "requerimiento_contrato_candidato.fondo_cesantia_id")
            ->leftjoin("caja_compensacion", "caja_compensacion.id", "=", "requerimiento_contrato_candidato.caja_compensacion_id")
            ->leftjoin("bancos", "bancos.id", "=", "requerimiento_contrato_candidato.nombre_banco")
            ->leftjoin('estados_requerimiento', 'estados_requerimiento.req_id', '=', 'requerimientos.id')
            ->leftjoin('estados', 'estados.id', '=', 'estados_requerimiento.estado')
            ->leftjoin('centros_trabajo', 'centros_trabajo.id', '=', 'requerimientos.ctra_x_clt_codigo')
            ->where("proceso","ENVIO_CONTRATACION")
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where(function ($where) use ($fecha_inicio,$fecha_final, $fecha_inicio_firma,$fecha_final_firma, $cliente_id,$req_id,$usuario_envio,$usuario_aprueba) {
                     
                            if ($fecha_inicio != "" && $fecha_final != "") {
                                $where->whereBetween("procesos_candidato_req.created_at",[$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                            }

                            if( $fecha_inicio_firma != "" && $fecha_final_firma != "" ){
                                $where->whereBetween("firma_contratos.fecha_firma",[$fecha_inicio_firma. ' 00:00:00', $fecha_final_firma. ' 23:59:59']);
                            }

                            if ($cliente_id != "" && $cliente_id != "") {
                                $where->where("negocio.cliente_id", $cliente_id);
                            }
                             if ($req_id !=null && $req_id != "") {
                                $where->where("requerimientos.id", $req_id);
                            }
                            if ($usuario_envio !=null && $usuario_envio != "") {
                                $where->where("procesos_candidato_req.usuario_envio",$usuario_envio);
                            }
                            if ($usuario_aprueba !=null && $usuario_aprueba != "") {
                                $where->where("procesos_candidato_req.user_autorizacion",$usuario_aprueba);
                            }
                   
                   
                 })
            ->where(function ($query) use ($cliente_id) {
                if($cliente_id == '' || $cliente_id == null) {
                    $ids_clientes_prueba = [];
                    if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                        $query->whereNotIn("negocio.cliente_id", $ids_clientes_prueba);
                    }
                }
            })
            ->select(
                    'datos_basicos.user_id as user_id',
                    'datos_basicos.departamento_expedicion_id as dpto_exp',
                    'datos_basicos.numero_libreta as libreta',
                    'datos_basicos.clase_libreta as clase_libreta',
                    'datos_basicos.distrito_militar as distrito_militar',
                    'estados_civiles.descripcion as estado_civil_desc',
                    'datos_basicos.telefono_movil as telefono_movil',
                    'datos_basicos.direccion as direccion',
                    'datos_basicos.barrio as barrio',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.numero_id as cedula', 
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.fecha_nacimiento',
                    'datos_basicos.fecha_expedicion',
                    'datos_basicos.genero as genero',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido',
                    'datos_basicos.email as correo',
                    'datos_basicos.grupo_sanguineo',
                    'datos_basicos.rh',
                    'datos_basicos.talla_pantalon',
                    'datos_basicos.talla_camisa',
                    'datos_basicos.talla_zapatos',
                    'cargos_especificos.descripcion as cargo',
                    'cargos_genericos.descripcion as cargo_generico',
                    'datos_basicos.user_id as user_id',
                    'tipo_identificacion.descripcion as dec_tipo_doc',
                    'requerimientos.salario as salario',
                    'clientes.nit as nit_cliente',
                    'clientes.id as cliente_id',
                    'clientes.nombre as cliente_nombre',
                    'procesos_candidato_req.fecha_inicio_contrato as fecha_inicio',
                    'procesos_candidato_req.created_at as fecha_envio_contratacion',
                    'procesos_candidato_req.observaciones as observaciones',
                    'requerimientos.fecha_terminacion as frecha_fin',
                    'requerimientos.id as req_id',
                    'requerimientos.created_at as fecha_req',
                    'requerimientos.adicionales_salariales',
                    'metodo_carga.descripcion as metodo_carga',
                     DB::raw('(select upper(name)  from users where users.id=procesos_candidato_req.usuario_envio) as usuario_envio'),
                      DB::raw('(select upper(name)  from users where users.id=procesos_candidato_req.user_autorizacion) as usuario_autorizacion'),
                    'empresa_logos.nombre_empresa as empresa_contratante',
                    'empresa_logos.nit as nit_empresa_contratante',
                    'tipo_proceso.descripcion as tipo_proceso_desc',
                    'agencias.descripcion as agencia',
                    'ciudad.nombre as nombre_ciudad',
                    'tipos_salarios.descripcion as tipo_salario_desc',
                    'centros_costos_produccion.descripcion as centro_costo',
                    'requerimiento_contrato_candidato.auxilio_transporte',
                    DB::raw('(SELECT ciudad.nombre FROM ciudad WHERE ciudad.cod_pais = datos_basicos.pais_residencia AND ciudad.cod_departamento = datos_basicos.departamento_residencia AND ciudad.cod_ciudad = datos_basicos.ciudad_residencia LIMIT 1) as ciudad_residencia'),
                    DB::raw('(SELECT ciudad.nombre FROM ciudad WHERE ciudad.cod_pais = datos_basicos.pais_nacimiento AND ciudad.cod_departamento = datos_basicos.departamento_nacimiento AND ciudad.cod_ciudad = datos_basicos.ciudad_nacimiento LIMIT 1) as ciudad_nacimiento'),
                    'generos.descripcion as genero_desc',
                    'requerimiento_contrato_candidato.fecha_ingreso',
                    'entidades_afp.descripcion as entidad_afp',
                    'entidades_eps.descripcion as entidad_eps',
                    'fondo_cesantias.descripcion as fondo_cesantia',
                    'caja_compensacion.descripcion as caja_compensacion_desc',
                    'bancos.nombre_banco as banco',
                    'requerimiento_contrato_candidato.tipo_cuenta',
                    'requerimiento_contrato_candidato.numero_cuenta',
                    'firma_contratos.fecha_firma as fecha_firma_contrato',
                    'firma_contratos.terminado as estado_contrato',
                    'firma_contratos.estado as estado_global',
                    'estados.descripcion as estado_requerimiento',
                    'centros_trabajo.nombre_ctra as nivel_riesgo',
                    DB::raw('(SELECT niveles_estudios.descripcion FROM estudios INNER JOIN niveles_estudios ON niveles_estudios.id = estudios.nivel_estudio_id WHERE estudios.user_id = datos_basicos.user_id ORDER BY niveles_estudios.jerarquia DESC LIMIT 1) as nivel_educativo'),
                    DB::raw('(SELECT COUNT(*) FROM grupos_familiares 
                        WHERE grupos_familiares.user_id = datos_basicos.user_id
                        AND grupos_familiares.parentesco_id = 2) as numero_hijos')
                    
            )
            ->groupBy('procesos_candidato_req.id');

            


        if (isset($request['formato']) and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
            
        } else {

            $data = $data->paginate(5);
        }

        foreach($data as $value){
           
            if($value->nombres!=null){

                $nombres=$array = explode(" ", $value->nombres);
                if(count($nombres)==2){
                     $value["primer_nombre"]=$nombres[0];
                $value["segundo_nombre"]=$nombres[1];
                }
                else{
                    $value["primer_nombre"]=$nombres[0];
                $value["segundo_nombre"]="";
                }
               
            }else{
                 $value["primer_nombre"]="";
                $value["segundo_nombre"]="";
            }
        }
    }
        return $data;

    }

    private function getDataDetalleReporteContratadosCliente($request)
    {
        $rango_fecha = $request->rango_fecha;
        if ($rango_fecha != "") {

              $rango = explode(" | ", $rango_fecha);
              $fecha_inicio = $rango[0];
              $fecha_final  = $rango[1];
        } else {
              $fecha_inicio = '';
              $fecha_final  = '';
        }

        // $fecha_inicio = $request['fecha_inicio'];
        // $fecha_final  = $request['fecha_final'];
//        $cliente_id   = $request['cliente_id'];
        $req_id   = $request['req_id'];
        $usuario_envio   = $request['usuario_envio'];
        $usuario_aprueba   = $request['usuario_aprueba'];

        //$criterio     =$request['criterio'];
       $formato      = ($request['formato']) ? $request['formato'] : 'html';
       $data="vacio";
        //dd($formato);
        // Data


        if($fecha_inicio!="" || $fecha_final!="" ||  $usuario_envio!="" || $usuario_aprueba!="" ||  $req_id!=""){

        $data= RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", '=', "requerimiento_candidato_id")
            ->join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
             ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->leftjoin("metodo_carga", "metodo_carga.id", "=", "users.metodo_carga")
        
             ->join('cargos_especificos','requerimientos.cargo_especifico_id','=','cargos_especificos.id')
            ->whereIn("clientes.id",$this->clientes_user)
            ->where("proceso","ENVIO_CONTRATACION")
            ->where(function ($where) use ($fecha_inicio,$fecha_final,$req_id,$usuario_envio,$usuario_aprueba) {
                     
                            if ($fecha_inicio != "" && $fecha_final != "") {
                                $where->whereBetween("procesos_candidato_req.created_at",[$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                            }

                             if ($req_id !=null && $req_id != "") {
                                $where->where("requerimientos.id", $req_id);
                            }
                            if ($usuario_envio !=null && $usuario_envio != "") {
                                $where->where("procesos_candidato_req.usuario_envio",$usuario_envio);
                            }
                            if ($usuario_aprueba !=null && $usuario_aprueba != "") {
                                $where->where("procesos_candidato_req.user_autorizacion",$usuario_aprueba);
                            }
                   
                   
                 })
            ->select(
                    'datos_basicos.user_id as user_id',
                    'datos_basicos.departamento_expedicion_id as dpto_exp',
                     'datos_basicos.numero_libreta as libreta',
                      'datos_basicos.clase_libreta as clase_libreta',
                      'datos_basicos.distrito_militar as distrito_militar',
                    'datos_basicos.ciudad_expedicion_id as ciudad_exp',
                     'datos_basicos.barrio as barrio',
                     'datos_basicos.estado_civil as estado_civil',
                      'datos_basicos.telefono_fijo as telefono_fijo',
                    'datos_basicos.direccion as direccion',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.numero_id as cedula', 
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.genero as genero',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido',
                    'cargos_especificos.descripcion as cargo',
                    'datos_basicos.pais_nacimiento as pais',
                    'datos_basicos.departamento_nacimiento as departamento',
                    'datos_basicos.departamento_residencia as departamento_resi',
                    'datos_basicos.ciudad_nacimiento as ciudad',
                    'datos_basicos.ciudad_residencia as ciudad_resi',
                    'datos_basicos.user_id as user_id',
                    'requerimientos.salario as salario',
                    'clientes.nit as nit_cliente',
                     'clientes.id as cliente_id',
                     'clientes.nombre as cliente_nombre',
                    'procesos_candidato_req.fecha_inicio_contrato as fecha_inicio',
                    'procesos_candidato_req.created_at as fecha_envio_contratacion',
                    'procesos_candidato_req.observaciones as observaciones',
                    'requerimientos.fecha_terminacion as frecha_fin',
                    'requerimientos.id as req_id',
                    'requerimientos.id as fecha_req',
                    'metodo_carga.descripcion as metodo_carga',
                     DB::raw('(select upper(name)  from users where users.id=procesos_candidato_req.usuario_envio) as usuario_envio'),
                      DB::raw('(select upper(name)  from users where users.id=procesos_candidato_req.user_autorizacion) as usuario_autorizacion')
                    
            )
            ->groupBy('procesos_candidato_req.id');

            


        if (isset($request['formato']) and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
            
        } else {

            $data = $data->paginate(5);
        }

        foreach($data as $value){
           
            if($value->nombres!=null){

                $nombres=$array = explode(" ", $value->nombres);
                if(count($nombres)==2){
                     $value["primer_nombre"]=$nombres[0];
                $value["segundo_nombre"]=$nombres[1];
                }
                else{
                    $value["primer_nombre"]=$nombres[0];
                $value["segundo_nombre"]="";
                }
               
            }else{
                 $value["primer_nombre"]="";
                $value["segundo_nombre"]="";
            }
        }
    }
        return $data;

    }

    private function getDataDetalleEnviadosPruebas($request)
    {
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_final  = $request['fecha_final'];
        $cliente_id   = $request['cliente_id'];
        $req          = $request['req_id'];
        $criterio     = $request['criterio'];
        $usuario_gestion = $request['usuario_gestion'];
        $formato       = ($request['formato']) ? $request['formato'] : 'html';
        //dd($formato);
        // Data
        $busqueda=false;
        
        $data= RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", '=', "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
            ->join("estados_requerimiento","estados_requerimiento.req_id","=","requerimiento_cantidato.requerimiento_id")
             ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->join('generos','datos_basicos.genero','=','generos.id')
            ->join('aspiracion_salarial','datos_basicos.aspiracion_salarial','=','aspiracion_salarial.id')
             ->join('cargos_especificos','requerimientos.cargo_especifico_id','=','cargos_especificos.id')
            //->join('motivo_requerimiento','requerimientos.motivo_requerimiento_id','=','motivo_requerimiento.id')
            ->where("procesos_candidato_req.proceso","ENVIO_PRUEBAS")
            ->where(function ($where) use ($fecha_inicio,$fecha_final,$cliente_id,$criterio,$req,$usuario_gestion) {
                  
                  if($req != "") {
                    $busqueda=true;
                   $where->where("requerimientos.id", $req);
                  }

                  if($usuario_gestion != "") {
                     $busqueda=true;
                    
                    $where->where("estados_requerimiento.user_gestion",$usuario_gestion);
                  }

                })
                ->select(
                    'datos_basicos.user_id as user_id',
                    'datos_basicos.email as email',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.numero_id as cedula', 
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.telefono_movil as telefono_movil',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'generos.descripcion as genero',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido',
                    'cargos_especificos.descripcion as cargo',
                    'requerimientos.salario as salario',                   
                    'requerimientos.fecha_terminacion as frecha_fin'
                    
              )     
            ->groupBy('procesos_candidato_req.id');

        /*$data2 = DB::table('datos_basicos')
                 ->join("departamentos", function ($join) {
                    $join
                        ->on("departamentos.cod_departamento", "=", "datos_basicos.departamento_residencia");
                })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_ciudad", "=", "datos_basicos.ciudad_residencia")
                    ->on("ciudad.cod_departamento", "=", "datos_basicos.departamento_residencia")
                    ->on('ciudad.cod_pais', '=', 'datos_basicos.pais_residencia');
                })

                ->join('generos','datos_basicos.genero','=','generos.id')
                ->join('aspiracion_salarial','datos_basicos.aspiracion_salarial','=','aspiracion_salarial.id')
                ->leftjoin('experiencias','datos_basicos.numero_id','=','experiencias.numero_id')
                ->join('estados','datos_basicos.estado_reclutamiento','=','estados.id')
               
                //->where("estados.id",11)
                //->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_RECLUTAMIENTO'))
                ->select(
                    'datos_basicos.user_id as user_id',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.numero_id as cedula', 
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'generos.descripcion as genero',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido',
                    'ciudad.nombre as ciudad',
                    'experiencias.cargo_especifico as cargo',
                    'experiencias.funciones_logros as funciones',
                    'datos_basicos.telefono_movil as celular',
                    'datos_basicos.descrip_profesional as descripcion',
                     'datos_basicos.email as email',
                     'estados.descripcion as estado_candidato',

                     DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                    
                    DB::raw('( count(experiencias.numero_id)) as experiencias'),
                      DB::raw('(select count(estudios.numero_id)
                                from estudios
                                 where estudios.numero_id = datos_basicos.numero_id       
                                      )    as estudios'),
                     DB::raw('(select count(grupos_familiares.user_id)
                                from grupos_familiares
                                 where grupos_familiares.numero_id = datos_basicos.numero_id       
                                      )    as grupos_familiares'),
                       DB::raw('(select count(referencias_personales.numero_id)
                                from referencias_personales
                                 where referencias_personales.numero_id = datos_basicos.numero_id      
                                      )    as referencias_personales'),
                     DB::raw('(select (datos_basicos.datos_basicos_count *0.3)+(datos_basicos.perfilamiento_count * 0.1)) as hv_count'),
                     
                     
                     DB::raw('DATE_FORMAT(datos_basicos.updated_at, \'%Y-%m-%d\') as fecha_actualizacion')
                )
                ->where(function ($where) use ($request) {
                     
                    if($request->get('palabra_clave')!="")
                    {

                        $where->whereRaw("( LOWER(experiencias.cargo_especifico) like '%" . $request->get("palabra_clave") . "%'or LOWER(experiencias.funciones_logros) like '%" . $request->get("palabra_clave") . "%'or LOWER(datos_basicos.descrip_profesional) like '%" . $request->get("palabra_clave") . "%') ");
       
                    }

                    if ($request->get('edad_inicial') != "" && $request->get('edad_final') != "") {
                        $where->whereBetween(DB::raw('round(datediff(now(),fecha_nacimiento)/365)'),[$request->get('edad_inicial'),$request->get('edad_final')]);
                    }

                    if ($request->get('fecha_actualizacion_ini') != "" && $request->get('fecha_actualizacion_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(datos_basicos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_actualizacion_ini'),$request->get('fecha_actualizacion_fin')]);
                    }

                
               

                    if($request->get('estado')!="")
                    {

                      $where->where("estados.descripcion" , $request->get('estado'));
                    }

                    if($request->get('genero_id')!="")
                    {

                        $where->where("generos.id" , $request->get('genero_id'));
                    }
                     
                    if ($request->get("ciudad_id") != "") {
                        $where->where("datos_basicos.ciudad_residencia", $request->get("ciudad_id"));
                    }
                    
                    if ($request->get("departamento_id") != "") {
                        $where->where("datos_basicos.departamento_residencia", $request->get("departamento_id"));
                    }
                 })->groupBy('datos_basicos.user_id');*/

           // dd($data);
//dd($data->toSql());
        if (isset($request['formato']) and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
            
        } else {

            $data = $data->paginate(5);
        }

        foreach($data as $value){
           
            if($value->nombres!=null){

                $nombres=$array = explode(" ", $value->nombres);
                if(count($nombres)==2){
                     $value["primer_nombre"]=$nombres[0];
                $value["segundo_nombre"]=$nombres[1];
                }
                else{
                    $value["primer_nombre"]=$nombres[0];
                $value["segundo_nombre"]="";
                }
               
            }else{
                 $value["primer_nombre"]="";
                $value["segundo_nombre"]="";
            }
        }
        return $data;

    }

    private function getDataDetalleCarga($request)
    {
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_final  = $request['fecha_final'];
        $cliente_id   = $request['cliente_id'];
        $criterio     = $request['criterio'];
        $user_gestion = $request['user_gestion'];
        $formato      = ($request['formato']) ? $request['formato'] : 'html';
        //dd($formato);
        // Data
        $data= RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", '=', "requerimiento_candidato_id")
            ->join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
             ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->join('generos','datos_basicos.genero','=','generos.id')
            ->join('aspiracion_salarial','datos_basicos.aspiracion_salarial','=','aspiracion_salarial.id')
             ->join('cargos_especificos','requerimientos.cargo_especifico_id','=','cargos_especificos.id')
            ->join('motivo_requerimiento','requerimientos.motivo_requerimiento_id','=','motivo_requerimiento.id')
            ->where("proceso","ENVIO_CONTRATACION")
            ->where(function ($where) use ($fecha_inicio,$fecha_final,$cliente_id,$criterio,$user_gestion) {
                     
                  if($fecha_inicio != "" && $fecha_final != "") {
                    $where->whereBetween("procesos_candidato_req.created_at",[$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                   }
  
                    if($cliente_id != "" && $cliente_id != "") {
                     $where->where("negocio.cliente_id", $cliente_id);
                    }

                    if($user_gestion != "") {
                     $where->where("estados_requerimiento.user_gestion",$user_gestion);
                    }
                   
                 })
            ->select(
                    'datos_basicos.user_id as user_id',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.numero_id as cedula', 
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'generos.descripcion as genero',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido',
                    'datos_basicos.ciudad_expedicion_id as ciudad_exp',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.*',
                    'cargos_especificos.descripcion as cargo',
                    'requerimientos.salario as salario',
                    'clientes.nit as nit_cliente',
                    'procesos_candidato_req.fecha_inicio_contrato as frecha_inicio',
                    'requerimientos.fecha_terminacion as frecha_fin',
                    'procesos_candidato_req.estado_contrato as estado_contrato',
                    'motivo_requerimiento.descripcion as motivo'
            )
            ->groupBy('procesos_candidato_req.id');

            



        /*$data2 = DB::table('datos_basicos')
                 ->join("departamentos", function ($join) {
                    $join
                        ->on("departamentos.cod_departamento", "=", "datos_basicos.departamento_residencia");
                })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_ciudad", "=", "datos_basicos.ciudad_residencia")
                    ->on("ciudad.cod_departamento", "=", "datos_basicos.departamento_residencia")
                    ->on('ciudad.cod_pais', '=', 'datos_basicos.pais_residencia');
                })

                ->join('generos','datos_basicos.genero','=','generos.id')
                ->join('aspiracion_salarial','datos_basicos.aspiracion_salarial','=','aspiracion_salarial.id')
                ->leftjoin('experiencias','datos_basicos.numero_id','=','experiencias.numero_id')
                ->join('estados','datos_basicos.estado_reclutamiento','=','estados.id')
               
                //->where("estados.id",11)
                //->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_RECLUTAMIENTO'))
                ->select(
                    'datos_basicos.user_id as user_id',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.numero_id as cedula', 
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'generos.descripcion as genero',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido',
                    'ciudad.nombre as ciudad',
                    'experiencias.cargo_especifico as cargo',
                    'experiencias.funciones_logros as funciones',
                    'datos_basicos.telefono_movil as celular',
                    'datos_basicos.descrip_profesional as descripcion',
                     'datos_basicos.email as email',
                     'estados.descripcion as estado_candidato',

                     DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                    
                    DB::raw('( count(experiencias.numero_id)) as experiencias'),
                      DB::raw('(select count(estudios.numero_id)
                                from estudios
                                 where estudios.numero_id = datos_basicos.numero_id       
                                      )    as estudios'),
                     DB::raw('(select count(grupos_familiares.user_id)
                                from grupos_familiares
                                 where grupos_familiares.numero_id = datos_basicos.numero_id       
                                      )    as grupos_familiares'),
                       DB::raw('(select count(referencias_personales.numero_id)
                                from referencias_personales
                                 where referencias_personales.numero_id = datos_basicos.numero_id      
                                      )    as referencias_personales'),
                     DB::raw('(select (datos_basicos.datos_basicos_count *0.3)+(datos_basicos.perfilamiento_count * 0.1)) as hv_count'),
                     
                     
                     DB::raw('DATE_FORMAT(datos_basicos.updated_at, \'%Y-%m-%d\') as fecha_actualizacion')
                )
                ->where(function ($where) use ($request) {
                     
                    if($request->get('palabra_clave')!="")
                    {

                        $where->whereRaw("( LOWER(experiencias.cargo_especifico) like '%" . $request->get("palabra_clave") . "%'or LOWER(experiencias.funciones_logros) like '%" . $request->get("palabra_clave") . "%'or LOWER(datos_basicos.descrip_profesional) like '%" . $request->get("palabra_clave") . "%') ");
       
                    }

                    if ($request->get('edad_inicial') != "" && $request->get('edad_final') != "") {
                        $where->whereBetween(DB::raw('round(datediff(now(),fecha_nacimiento)/365)'),[$request->get('edad_inicial'),$request->get('edad_final')]);
                    }

                    if ($request->get('fecha_actualizacion_ini') != "" && $request->get('fecha_actualizacion_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(datos_basicos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_actualizacion_ini'),$request->get('fecha_actualizacion_fin')]);
                    }

                
               

                    if($request->get('estado')!="")
                    {

                      $where->where("estados.descripcion" , $request->get('estado'));
                    }

                    if($request->get('genero_id')!="")
                    {

                        $where->where("generos.id" , $request->get('genero_id'));
                    }
                     
                    if ($request->get("ciudad_id") != "") {
                        $where->where("datos_basicos.ciudad_residencia", $request->get("ciudad_id"));
                    }
                    
                    if ($request->get("departamento_id") != "") {
                        $where->where("datos_basicos.departamento_residencia", $request->get("departamento_id"));
                    }
                 })->groupBy('datos_basicos.user_id');*/

           // dd($data);
//dd($data->toSql());
        if (isset($request['formato']) and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
            
        } else {

            $data = $data->paginate(5);
        }

        
        return $data;

    }

    //Reporte detlle reqquerimientos modulo req

    public function reportesDetallesReq(Request $request)
    {

        $clientes  = ["" => "Seleccionar"] + Clientes::join('negocio', 'negocio.cliente_id', '=', 'clientes.id')
            ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
         ->join('requerimientos','negocio.id','=','requerimientos.negocio_id')
            ->where("users_x_clientes.user_id", $this->user->id)
        ->orderBy(DB::raw("UPPER(clientes.nombre)"),"ASC")
        ->pluck("clientes.nombre", "clientes.id")
        ->toArray();
        
        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["1" => "REQUISICIONES ABIERTAS"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }

        $headers   = $this->getHeaderDetalleReq();
        $data      = $this->getDataDetalleReq($request);

        return view('req.reporte')->with([
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headers'   => $headers,
        ]);
    }

    public function reportesDetallesExcelReq(Request $request)
    {
        
        $headers = $this->getHeaderDetalleReq();
        $data    = $this->getDataDetalleReq($request);
        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-requerimientos', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Detalle Requerimientos');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Requerimientos');
            $excel->sheet('Reporte Detalle Requerimientos', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('req.grilla', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    private function getHeaderDetalleReq()
    {

      if(route("home")=="http://tiempos.t3rsc.co" || route("home")=="https://tiempos.t3rsc.co"){

        $headers = [
            'Requerimiento',
            'Tipo Requerimiento',
            'Agencia',
            'Ciudad',
            'Departamento',
            'País',
            'Cliente',
            'Cargo Genérico',
            'Cargo Cliente',
            'Vacantes Solicitadas',
            'Cant Enviados Examenes',
            'Cand en Proceso de Contratacion',
            'Cant Contratados',
            'Fecha inicio vacante',
            'Fecha tentativa cumplimiento',
            'Dias vencidos',
            'Estado Req',
            'Dias max gestion',
            'Fecha cierre req',
            'Usuario cargo req',
            'Usuario gestiono req',
            'Vacantes Reales',
            //'fecha_max_presentacion_cand',
            //'num_cand_presentados_oport',
            //'num_cand_presentados_extem',
            //'num_contratados_oport',
            //'num_contratados_extem',
            'ind_cumplimiento_ANS',
            //'ind_contratacion_oportuna',
            'ind_calidad_proceso',
        ];
       }else{

        $headers = [
            'Requerimiento',
            'Tipo Requerimiento',
            'Agencia',
            'Ciudad',
            'Departamento',
            'País',
            'Cliente',
            'Cargo Genérico',
            'Cargo Cliente',
            'Vacantes Solicitadas',
            'Cant Enviados Examenes',
            'Cand en Proceso de Contratacion',
            'Cant Contratados',
            'Fecha inicio vacante',
            'Fecha tentativa cumplimiento',
            'Dias vencidos',
            'Estado Req',
            'Dias max gestion',
            'Fecha cierre req',
            'Usuario cargo req',
            'Usuario gestiono req',
            'Vacantes Reales',
            //'fecha_max_presentacion_cand',
            //'num_cand_presentados_oport',
            //'num_cand_presentados_extem',
            //'num_contratados_oport',
            //'num_contratados_extem',
            'ind_oport_presentacion',
            'ind_oport_contratacion',
            'ind_calidad_presentacion',
        ];
     }

        return $headers;
    }
     

    private function getDataDetalleReq($request)
    {
        $rango_fecha = $request->rango_fecha;
        if ($rango_fecha != "") {

              $rango = explode(" | ", $rango_fecha);
              $fecha_inicio = $rango[0];
              $fecha_final  = $rango[1];
        } else {
              $fecha_inicio = '';
              $fecha_final  = '';
        }
        
        $cliente_id   = $request->cliente_id;
        $criterio     = $request->criterio;
        $formato      = ($request->has('formato')) ? $request->formato : 'html';
        //dd($formato);
        // Data
        if ($fecha_inicio != '' || $fecha_final != '' || $cliente_id != '' || $criterio!= ''){

            if (route('home') == "http://temporizar.t3rsc.co") {
            
            $data = DB::table('requerimientos')
                ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
                ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
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
                ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")

                ->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
                ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
                ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
                //->where('requerimientos.solicitado_por',$this->user->id)
                ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio) {
                    if ($fecha_inicio != "" && $fecha_final != "") {
                        $sql->whereBetween("requerimientos_estados.fecha_creacion_req", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                    }
                    if ((int) $cliente_id > 0 && $cliente_id != "") {
                        $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                    }
                    switch ($criterio) {
                        case 1: //Req abiertas
                            $sql->whereIn("requerimientos_estados.max_estado", [
                                config('conf_aplicacion.C_RECLUTAMIENTO'),
                                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                                config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),

                            ]);
                            break;
                        case 2: //CERRADAS OPORTUNAMENTE
                            $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                            $sql->whereRaw("requerimientos_estados.fecha_ultimo_estado<=requerimientos.fecha_terminacion");
                            break;
                        case 3: //requi contratadas
                            $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                            break;
                        case 4: //requi canceladas
                           $sql->whereIn("requerimientos_estados.max_estado",[2,1,19,22]);
                        break ;   
                        default:
                            $sql->whereIn("requerimientos_estados.max_estado", [
                                22,
                                config('conf_aplicacion.C_TERMINADO'),
                                config('conf_aplicacion.C_RECLUTAMIENTO'),
                                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                                config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                                config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                                config('conf_aplicacion.C_CLIENTE'),
                                2,
                            ]);
                    }
                })
                ->select(
                    'requerimientos.id as requerimiento_id',
                    DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                    'ciudad.agencia as agencia ',
                    'ciudad.nombre as ciudad_req',
                    'departamentos.nombre as departamento',
                    'paises.nombre as pais',
                    'clientes.nombre as cliente',
                    'cargos_genericos.descripcion as cargo_generico',
                    'cargos_especificos.descripcion as cargo_cliente',
                    'requerimientos.num_vacantes as vacantes_solicitadas',
                    DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
                    DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                    DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                    DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                    DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),

                    //metodo para dias_vencidos
                    DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_SOLUCIONES').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                        order by created_at desc limit 1) IS NULL
                           THEN datediff(now(),requerimientos.fecha_ingreso)
                            ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_SOLUCIONES').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                        order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
    //-------------------------------------------------------------------------------------
                    DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                    DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                    DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                    DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_SOLUCIONES').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). '  )
                     order by created_at desc limit 1) as fecha_cierre_req'),

                    DB::raw('upper(users.name) as usuario_cargo_req'),
                    DB::raw('(select upper(p.name)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id  order by o.created_at desc limit 1) as usuario_gestiono_req'),
                    DB::raw('case requerimientos_estados.max_estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),
                    DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                    'requerimientos.fecha_presentacion_oport_cand',
                    'requerimientos.cand_presentados_puntual',
                    'requerimientos.cand_presentados_no_puntual',
                    'requerimientos.cand_contratados_puntual',
                    'requerimientos.cand_contratados_no_puntual',
                    DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                    DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                    DB::raw(' round(((select count(*) from procesos_candidato_req
    where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
    group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')

                )
    ->whereIn('requerimientos.id',array(500,512,353))
    ->where("users_x_clientes.user_id", $this->user->id)
    ->groupBy('requerimientos.id')
    ->orderBy('requerimiento_id','desc');

}else{

      $data = DB::table('requerimientos')
            ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
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
            ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")

            ->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
            ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
            ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            //->where('requerimientos.solicitado_por',$this->user->id)
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio) {
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("requerimientos_estados.fecha_creacion_req", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                }
                switch ($criterio) {
                    case 1: //Req abiertas
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),

                        ]);
                        break;
                    case 2: //CERRADAS OPORTUNAMENTE
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->whereRaw("requerimientos_estados.fecha_ultimo_estado<=requerimientos.fecha_terminacion");
                        break;
                    case 3: //requi contratadas
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        break;
                    case 4: //requi canceladas
                       $sql->whereIn("requerimientos_estados.max_estado",[2,1,19,22]);
                    break ;   
                    default:
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            22,
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                            config('conf_aplicacion.C_CLIENTE'),
                            2,
                        ]);
                }
            })
            ->select(
                'requerimientos.id as requerimiento_id',
                DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                'ciudad.agencia as agencia ',
                'ciudad.nombre as ciudad_req',
                'departamentos.nombre as departamento',
                'paises.nombre as pais',
                'clientes.nombre as cliente',
                'cargos_genericos.descripcion as cargo_generico',
                'cargos_especificos.descripcion as cargo_cliente',
                'requerimientos.num_vacantes as vacantes_solicitadas',
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),

                //metodo para dias_vencidos
                DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_SOLUCIONES').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1) IS NULL
                       THEN datediff(now(),requerimientos.fecha_ingreso)
                        ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_SOLUCIONES').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
//-----------------------------------------------------------------------------
                DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_SOLUCIONES').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). '  )
                 order by created_at desc limit 1) as fecha_cierre_req'),

                DB::raw('upper(users.name) as usuario_cargo_req'),
                DB::raw('(select upper(p.name)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id  order by o.created_at desc limit 1) as usuario_gestiono_req'),
                DB::raw('case requerimientos_estados.max_estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),
                DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                'requerimientos.fecha_presentacion_oport_cand',
                'requerimientos.cand_presentados_puntual',
                'requerimientos.cand_presentados_no_puntual',
                'requerimientos.cand_contratados_puntual',
                'requerimientos.cand_contratados_no_puntual',
                DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                DB::raw(' round(((select count(*) from procesos_candidato_req
where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')

            )
->where("users_x_clientes.user_id", $this->user->id)
->groupBy('requerimientos.id')

->orderBy('requerimiento_id','desc');

}
//dd($data->toSql());
        if ($request->has('formato') and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
        } else {
            $data = $data->paginate(5);
        }

        return $data/*->orderBy('requerimientos.id', 'desc')*/;
}
    }

    //Reporte detalle requerimientos abiertos

    /* public function reportesDetallesExcelAbi(Request $request)
    {
        $headers = $this->getHeaderDetalleReqAbi();
        $data    = $this->getDataDetalleReqAbi($request);
        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-requerimientos', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Detalle Requerimientos');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Requerimientos');
            $excel->sheet('Reporte Detalle Requerimientos', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }


    private function getHeaderDetalleReqAbi()
    {

        $headers = [
            'Requerimiento',
            'Tipo Requerimiento',
            'Agencia',
            'Ciudad',
            'Departamento',
            'País',
            'Cliente',
            'Cargo Genérico',
            'Cargo Cliente',
            'Vacantes Solicitadas',
            'Cant Enviados Examenes',
            'Cand en Proceso de Contratacion',
            'Cant Contratados',
            'Fecha inicio vacante',
            'Fecha tentativa cumplimiento',
            'Dias vencidos',
            'Estado Req',
            'Dias max gestion',
            'Fecha cierre req',
            'Usuario cargo req',
            'Usuario gestiono req',
            'Vacantes Reales',
            //'fecha_max_presentacion_cand',
            //'num_cand_presentados_oport',
            //'num_cand_presentados_extem',
            //'num_contratados_oport',
            //'num_contratados_extem',
            'ind_oport_presentacion',
            'ind_oport_contratacion',
            'ind_calidad_presentacion',
        ];
        return $headers;
    }

    private function getDataDetalleReqAbi($request)
    {

       
        $formato      = ($request->has('formato')) ? $request->formato : 'html';
        //dd($formato);
        // Data

       
        $data = DB::table('requerimientos')
            ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
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
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio) {
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                }
                switch ($criterio) {
                    default: //Req abiertas
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),

                        ]);
                        break;
                   
                       
                }
            })
            ->select(
                'requerimientos.id as requerimiento_id',
                DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                'ciudad.agencia as agencia ',
                'ciudad.nombre as ciudad_req',
                'departamentos.nombre as departamento',
                'paises.nombre as pais',
                'clientes.nombre as cliente',
                'cargos_genericos.descripcion as cargo_generico',
                'cargos_especificos.descripcion as cargo_cliente',
                'requerimientos.num_vacantes as vacantes_solicitadas',
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),

                //metodo para dias_vencidos
                DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_SOLUCIONES').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1) IS NULL
                       THEN datediff(now(),requerimientos.fecha_ingreso)
                        ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_SOLUCIONES').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
//-------------------------------------------------------------------------------------
                DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_SOLUCIONES').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). '  )
                 order by created_at desc limit 1) as fecha_cierre_req'),

                DB::raw('upper(users.name) as usuario_cargo_req'),
                DB::raw('(select upper(p.name)  
                    from role_users o 
                    left join users p on o.user_id=p.id 
                    left join users_x_clientes ux on p.id=ux.user_id
                    left join clientes cli on ux.cliente_id=cli.id
                    left join negocio neg on cli.id=neg.cliente_id
                    left join requerimientos req on neg.id=req.negocio_id

                    where req.id=requerimiento_id and
                    o.role_id = 17  
                    order by o.created_at desc limit 1) as usuario_gestiono_req'),
                DB::raw('case requerimientos_estados.max_estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),
                DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                'requerimientos.fecha_presentacion_oport_cand',
                'requerimientos.cand_presentados_puntual',
                'requerimientos.cand_presentados_no_puntual',
                'requerimientos.cand_contratados_puntual',
                'requerimientos.cand_contratados_no_puntual',
                DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                DB::raw(' round(((select count(*) from procesos_candidato_req
where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')

            )
->groupBy('requerimientos.id')
->orderBy('requerimiento_id','desc');

//dd($data->toSql());
        if ($request->has('formato') and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
        } else {
            $data = $data->paginate(5);
        }

        return $data;

     

    }*/



    //Reporte ordenes examenes medicos

    public function reportesExamenesMedicos(Request $request)
    {
        $areas=array();

        $examenes=ExamenMedico::where("status",1)->orderBy("id")->get();

        $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();
         
        $cargos = ["" => "- Seleccionar -"] + CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();

        $ciudad = ["" => "- Seleccionar -"] + Ciudad::pluck("nombre", "id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }

        $usuarios=["" => "- Seleccionar -"]+User::join("role_users","users.id","=","role_users.user_id")
        ->whereIn("role_users.role_id",[4,7])
        ->pluck("users.name", "users.id")->toArray();

        $agencias=["" => "- Seleccionar -"] + Agencia::pluck("agencias.descripcion", "agencias.id")->toArray();



        if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co"){
            
           $areas=["" => "Seleccionar"] + SolicitudAreaFuncional::where("estado", 1)->pluck("descripcion", "id")->toArray();
        }
    
        $headers   = $this->getHeaderExamenesMedicos();
        $data      = $this->getDataExamenesMedicos($request);

          //reportesaquiiii de requerimientos
        return view('admin.reportes.reporteExamenesMedicos')->with([
            'areas'     => $areas,
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headers'   => $headers,
            'ciudad'   => $ciudad,
            'cargos'   => $cargos,
            'usuarios' =>$usuarios,
            'agencias' =>$agencias,
            'examenes' =>$examenes
         ]);
    }

    //Fin reporte examenes medicos
    
    //Reporte detalle requerimientos
    public function reportesDetalles(Request $request)
    {
        $areas=array();
        $sitio = Sitio::first();

        $clientes  = ["" => "Seleccionar"] + Clientes::orderBy('nombre')->pluck("clientes.nombre", "clientes.id")->toArray();
         
        $cargos = ["" => "- Seleccionar -"] + CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();

        $ciudad = ["" => "- Seleccionar -"] + Ciudad::pluck("nombre", "id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

           $usuarios=["" => "Seleccionar"] + User::join('estados_requerimiento','estados_requerimiento.user_gestion','=','users.id')
            ->pluck("users.name", "users.id")->toArray();

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

            $usuarios=["" => "- Seleccionar -"]+User::join("role_users","users.id","=","role_users.user_id")
        ->whereIn("role_users.role_id",[4,7])
        ->pluck("users.name", "users.id")->toArray();

        }

        $agencias=["" => "- Seleccionar -"] + Agencia::pluck("agencias.descripcion", "agencias.id")->toArray();

        if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co"){   
         $areas=["" => "Seleccionar"] + SolicitudAreaFuncional::where("estado", 1)->pluck("descripcion", "id")->toArray();
        }
    
        $headers   = $this->getHeaderDetalle();
        $data      = $this->getDataDetalle($request);

          //reportesaquiiii de requerimientos
        return view('admin.reportes.reportedetalles')->with([
            'areas'     => $areas,
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headers'   => $headers,
            'ciudad'   => $ciudad,
            'cargos'   => $cargos,
            'usuarios' =>$usuarios,
            'agencias' =>$agencias,
            'sitio'   =>$sitio
        ]);
    }

    public function reportesReporteIndicador(Request $request)
    {
        $areas=array();

        $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();
         
        $cargos = ["" => "- Seleccionar -"] + CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();

        $ciudad = ["" => "- Seleccionar -"] + Ciudad::pluck("nombre", "id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }

        $usuarios=["" => "- Seleccionar -"]+User::join("role_users","users.id","=","role_users.user_id")
        ->whereIn("role_users.role_id",[4,7])
        ->pluck("users.name", "users.id")->toArray();

        $agencias=["" => "- Seleccionar -"] + Agencia::pluck("agencias.descripcion", "agencias.id")->toArray();

        if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co"){
            
           $areas=["" => "Seleccionar"] + SolicitudAreaFuncional::where("estado", 1)->pluck("descripcion", "id")->toArray();
        }
    
        $headers   = $this->getHeaderReporteIndicador();
        $data      = $this->getDataReporteIndicador($request);

        //reportesaquiiii de requerimientos
        return view('admin.reportes.reporteReporteIndicador')->with([
            'areas'     => $areas,
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headers'   => $headers,
            'ciudad'   => $ciudad,
            'cargos'   => $cargos,
            'usuarios' =>$usuarios,
            'agencias' =>$agencias
        ]);
    }

    public function reportesReporteIndicadorExcel(Request $request)
    {
        $headers = $this->getHeaderReporteIndicador();
        $data    = $this->getDataReporteIndicador($request);
        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }
//dd($data);
        Excel::create('reporte-excel-fdf-detalle-reporte-indicador', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Indicador');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Indicadores');
            $excel->sheet('Reporte Detalle Indicadores', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_reporte_indicador', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    public function reportesDiario(Request $request){

        $areas=array();
        $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }

        if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co"){
           $areas=["" => "Seleccionar"] + SolicitudAreaFuncional::where("estado", 1)->pluck("descripcion", "id")->toArray();
        }
    
        $headers   = $this->getHeaderDiario();
        $data      = $this->getDataDetalleDiario($request);

          
        return view('admin.reportes.reportediario')->with([
            'areas'     => $areas,
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headers'   => $headers,
        ]);
    
    }

    public function reportesAnalistas(Request $request){

        $areas=array();
        $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }

        if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co"){
           $areas=["" => "Seleccionar"] + SolicitudAreaFuncional::where("estado", 1)->pluck("descripcion", "id")->toArray();
        }
    
        $headers   = $this->getHeaderAnalistas();
        $data      = $this->getDataDetalleAnalistas($request);

          
        return view('admin.reportes.reporteAnalistas')->with([
            'areas'     => $areas,
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headers'   => $headers,
        ]);
    
    }
   

    //Generar el reporte en excel / PDF
    public function reportesDetallesExcel(Request $request)
    {
        $headers = $this->getHeaderDetalle();
        $data    = $this->getDataDetalle($request->all());
        $formato = $request->formato;
         $sitio = Sitio::first();

        $funcionesGlobales = new FuncionesGlobales();

        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-fdf-detalle-indicadores', function ($excel) use ($data, $headers, $formato,$sitio) {
            $excel->setTitle('Reporte Detalle Indicadores');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Indicadores');
            $excel->sheet('Reporte Detalle Indicadores', function ($sheet) use ($data, $headers, $formato,$sitio) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_excell', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                    'sitio'   => $sitio
                ]);
            });
        })->export($formato);
    }

    public function reportesExamenesMedicosExcel(Request $request)
    {
        $headers = $this->getHeaderExamenesMedicos();
        $data    = $this->getDataExamenesMedicos($request->all());
        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-fdf-detalle-examenes-medicos', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte exámenes médicos');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte exámenes médicos');
            $excel->sheet('Reporte exámenes médicos', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_examenes_medicos', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    public function reportesSeguimientoExcel(Request $request)
    {
      
        
        $sitio     = Sitio::first();
        $headers   = $this->getHeaderSeguimiento($sitio);
        $data      = $this->getDataSeguimiento($request);
        
        $formato   = $request['formato'];

        $nombre = "Desarrollo";
        if(isset($sitio->nombre)) {
            if($sitio->nombre != "") {
                $nombre = $sitio->nombre;
            }
        }
        //dd($data);

        Excel::create('reporte-excel-pdf-seguimiento-indicadores', function ($excel) use ($data, $headers, $formato, $sitio) {
            $excel->setTitle('Reporte Detalle Indicadores');
            $excel->setCreator("$nombre")
                ->setCompany("$nombre");
            $excel->setDescription('Reporte Seguimiento Indicadores');
            $excel->sheet('Reporte Seguimiento Indicadores', function ($sheet) use ($data, $headers, $formato, $sitio) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_seguimiento', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                    'sitio'   => $sitio
                ]);
            });
        })->export($formato);
    }
    public function reportesDiarioExcel(Request $request)
    {

        $headers = $this->getHeaderDetalle();
        $data    = $this->getDataDetalle($request);
        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-fdf-diario', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Detalle Indicadores');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Indicadores');
            $excel->sheet('Reporte Detalle Indicadores', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }
     public function reportesAnalistasExcel(Request $request)
    {

        $headers = $this->getHeaderAnalistas();
        $data    = $this->getDataDetalleAnalistas($request);
        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-fdf-analistas', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Detalle Indicadores Analistas');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Indicadores');
            $excel->sheet('Reporte Detalle Indicadores', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_analistas', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    private function getHeaderDetalle()
    {
       
        if (route('home')!= "http://komatsu.t3rsc.co" && route('home')!= "https://komatsu.t3rsc.co") {
         
        if(route("home")=="http://tiempos.t3rsc.co" || route("home")=="https://tiempos.t3rsc.co"){

         $headers = [
            'Requerimiento',
            'Tipo Requerimiento',
            'Agencia',
            'Ciudad',
            'Departamento',
            'País',
            'Cliente',
            'Cargo Genérico',
            'Cargo Cliente',
            'Vacantes Solicitadas',
            'Cant Enviados Examenes',
            'Cand en Proceso de Contratacion',
            'Cant Contratados',
            'Fecha inicio vacante',
            'Fecha tentativa cumplimiento',
            'Dias vencidos',
            'Estado Req',
            'Dias max gestion',
            'Fecha cierre req',
            'Usuario cargo req',
            'Usuario gestiono req',
            'Vacantes Reales',
            //'fecha_max_presentacion_cand',
            //'num_cand_presentados_oport',
            //'num_cand_presentados_extem',
            //'num_contratados_oport',
            //'num_contratados_extem',
            'ind_cumplimiento_ANS',
            //'ind_contratacion_oportuna',
            'ind_calidad_proceso',
         ];

       }
   elseif(route("home")=="https://gpc.t3rsc.co"){
            $headers = [
            'Requerimiento',
            'Tipo Requerimiento',
            //'Agencia',

            'Ciudad',
            'Departamento',
            'País',
            'Cliente',
            'Cargo Genérico',
            'Cargo Cliente',
            'Vacantes Solicitadas',
            //'Cant Enviados Examenes',
            //'Cand en Proceso de Contratacion',
            'Cant Contratados',
            'Fecha inicio vacante',
            'Fecha tentativa cumplimiento',
            'Dias vencidos',
            'Estado Req',
            'Dias max gestion',
            'Fecha cierre req',
            'Usuario cargo req',
            'Usuario gestiono req',
            'Vacantes Reales',
            //'fecha_max_presentacion_cand',
            //'num_cand_presentados_oport',
            //'num_cand_presentados_extem',
            //'num_contratados_oport',
            //'num_contratados_extem',
            
        ];

   }
       else{    
            $headers = [
            'Requerimiento',
            'Tipo Requerimiento',
            'Agencia',

            'Ciudad',
            'Departamento',
            'País',
            'Cliente',
            'Cargo Genérico',
            'Cargo Cliente',
            'Vacantes Solicitadas',
            'Cant Enviados Examenes',
            'Cand en Proceso de Contratacion',
            'Cant Contratados',
            'Fecha inicio vacante',
            'Fecha tentativa cumplimiento',
            'Dias vencidos',
            'Estado Req',
            'Dias max gestion',
            'Fecha cierre req',
            'Usuario cargo req',
            'Usuario gestiono req',
            'Vacantes Reales',
            //'fecha_max_presentacion_cand',
            //'num_cand_presentados_oport',
            //'num_cand_presentados_extem',
            //'num_contratados_oport',
            //'num_contratados_extem',
            'ind_oport_presentacion',
            'ind_oport_contratacion',
            'ind_calidad_presentacion',
        ];
        }
            }else{
            $headers = [
            'ID',
            'Responsable HR',
            'Cargo',
            'Tipo contrato',
            'Justificación',
            'Cantidad vacantes',
            'Estado',
            'Tipo cargo',
            'Sede',
            'Solicitante',
            'Area',
            'Gerente del Area',
           // 'Estado',
            '#en entrevista RRHH',
            '#en entrevista ténica',
            '#Candidatos en pruebas',
            '#Candidatos examen medico',
            '#Candidatos estudio seguridad',
            'Vacantes Cerradas',
            'Vacantes Pendientes',
            'ANS',
            'Fecha de Solicitud',
            'Dias solicitud-valoracion',
            'Fecha OK Valoración',
            'Dias valoracion jefe area',
            'Fecha OK Jefe Area',
            'Dias jefe area-gte area',
            'Fecha OK Gte.Area',
            'Dias gte area-gte-rrhh',
            'Fecha OK Gte.RRHH',
            'Dias gte rrhh-gte general',
            'Fecha OK Gte.General',
            'Fecha liberacion',
            'Dias Trans liberación',
            '#Postulantes internos',
            '#Postulantes externos',
            '#Postulantes en proceso internos',
            '#Postulantes en proceso externos',
            'Fecha entrevista selección(HR)',
            'Dias envio entrevista-finalizacion',
            'Fecha final entrevista hr',
            'Fecha entrevista técnica',
            'dias envio entrevista-finalizacion',
            'Fecha final entrevista técnica',
            'Fecha de pruebas',
            'Dias envio pruebas-recibo informe',
            'Fecha recibo informe de pruebas',
            'Fecha inicio envio aprobar',
            'Dias envio aprobar-aprobacion',
            'Fecha aprobacion',
            'Fecha solicitud examenes médicos',
            'Dias solicitud examenes-entrega examenes',
            'Fecha entrega examenes médicos',
            'Fecha solicitud estudio seguridad',
            'Dias solicitud est. seguridad-entrega est. seguridad',
            'Fecha entrega estudio seguridad',
            //'Comentarios',
            'Fecha cierre requerimiento',
            'Total dias Proceso',            
            //'Tipo de novedad',
            'Nombre del seleccionado',
            'Fecha de contratación',
            'Fecha de cancelación de proceso'
        ];

            }
       
        return $headers;
    }

    private function getHeaderExamenesMedicos()
    {
       
        
         $headers = [
            'CONSEC.',
            'FECHA',
            'CEDULA',
            'NOMBRE ',
            'EMPRESA USUARIA',
            'CARGO',
            'CIUDAD ',
            'CENTRO MÉDICO',
            'MES FACTURACION',
            'MES COSTO',
            'OBSERVACIONES',

         ];

         $examenes=ExamenMedico::where("status",1)->orderBy("id")->pluck('nombre')->toArray();
        $headers=array_merge($headers,$examenes);
        

            
       
        return $headers;
    }

    private function getHeaderReporteIndicador()
    {
       
        if (route('home')!= "http://komatsu.t3rsc.co" && route('home')!= "https://komatsu.t3rsc.co") {
         
        if(route("home")=="http://tiempos.t3rsc.co" || route("home")=="https://tiempos.t3rsc.co"){

         $headers = [
            'Requerimiento',
            'Tipo Requerimiento',
            'Agencia',
            'Ciudad',
            'Departamento',
            'País',
            'Cliente',
            'Cargo Genérico',
            'Cargo Cliente',
            'Mes de solicitud',
            'Vacantes Solicitadas',
            'Cant Enviados Examenes',
            'Cand en Proceso de Contratacion',
            'Cant Contratados',
            'Fecha del requerimiento',
            'Fecha tentativa cumplimiento',
            'Dias vencidos',
            'Estado Req',
            'Dias max gestion',
            'Fecha cierre req',
            'Usuario cargo req',
            'Usuario gestiono req',
            'Vacantes Reales',
            //'fecha_max_presentacion_cand',
            //'num_cand_presentados_oport',
            //'num_cand_presentados_extem',
            //'num_contratados_oport',
            //'num_contratados_extem',
            'ind_cumplimiento_ANS',
            //'ind_contratacion_oportuna',
            'ind_calidad_proceso',
         ];

       }else{    
            $headers = [
            '#Req',
            'Proceso',
            'Agencia',

            'Ciudad',
            /*'Departamento',
            'País',*/
            'Cliente',
            'Cargo Genérico',
            'Cargo Cliente',
            'Estado',
            'Mes de solicitud',
            'Vacantes Solicitadas',
            /*'Cant Enviados Examenes',
            'Cand en Proceso de Contratacion',
            'Cant Contratados',*/
            'Fecha del requerimiento',
            'Fecha primer envio',
            //'Fecha tentativa cumplimiento',
            'Dias de entrega',
           
            '% Oportunidad en tiempo',
            'Nro. De personas requeridas ',
        
            'Total de Hojas de Vida',
            'Nro. Hojas de Vida Aprobadas',
            'Total Hojas  Vida NO Aprobadas',
            '% de efectividad'
            
        ];
        }
            }else{
            $headers = [
            'ID',
            'Responsable HR',
            'Cargo',
            'Tipo contrato',
            'Justificación',
            'Cantidad vacantes',
            'Estado',
            'Tipo cargo',
            'Sede',
            'Solicitante',
            'Area',
            'Gerente del Area',
           // 'Estado',
            '#en entrevista RRHH',
            '#en entrevista ténica',
            '#Candidatos en pruebas',
            '#Candidatos examen medico',
            '#Candidatos estudio seguridad',
            'Vacantes Cerradas',
            'Vacantes Pendientes',
            'ANS',
            'Fecha de Solicitud',
            'Dias solicitud-valoracion',
            'Fecha OK Valoración',
            'Dias valoracion jefe area',
            'Fecha OK Jefe Area',
            'Dias jefe area-gte area',
            'Fecha OK Gte.Area',
            'Dias gte area-gte-rrhh',
            'Fecha OK Gte.RRHH',
            'Dias gte rrhh-gte general',
            'Fecha OK Gte.General',
            'Fecha liberacion',
            'Dias Trans liberación',
            '#Postulantes internos',
            '#Postulantes externos',
            '#Postulantes en proceso internos',
            '#Postulantes en proceso externos',
            'Fecha entrevista selección(HR)',
            'Dias envio entrevista-finalizacion',
            'Fecha final entrevista hr',
            'Fecha entrevista técnica',
            'dias envio entrevista-finalizacion',
            'Fecha final entrevista técnica',
            'Fecha de pruebas',
            'Dias envio pruebas-recibo informe',
            'Fecha recibo informe de pruebas',
            'Fecha inicio envio aprobar',
            'Dias envio aprobar-aprobacion',
            'Fecha aprobacion',
            'Fecha solicitud examenes médicos',
            'Dias solicitud examenes-entrega examenes',
            'Fecha entrega examenes médicos',
            'Fecha solicitud estudio seguridad',
            'Dias solicitud est. seguridad-entrega est. seguridad',
            'Fecha entrega estudio seguridad',
            //'Comentarios',
            'Fecha cierre requerimiento',
            'Total dias Proceso',            
            //'Tipo de novedad',
            'Nombre del seleccionado',
            'Fecha de contratación',
            'Fecha de cancelación de proceso'
        ];

            }
       
        return $headers;
    }
    private function getHeaderSeguimiento($sitio)
    {

         if(route("home")=="https://nases.t3rsc.co"){
            $headers = [
            'Requerimiento',
           
            'Tipo Requerimiento',
            'Agencia',
            'Ciudad',
            'Departamento',
            'País',
            'Cliente',
            'Cargo Genérico',
            'Cargo Cliente',
            'Vacantes Solicitadas',
            '# Preperfilados',
            '# Aplicados',
            '# Asociados',
            '# Citados',
           
            '# Enviados a pruebas',
            '# Enviados a referenciación',
            '# Consultas de seguridad',
            '# Enviados Entre. Virtual',
            '# Enviados Entre. Presencial',
            '# Enviados al cliente',
            '# Enviados a Exa. Médicos',
            '# Enviados Est. Seguridad',
            '# Enviados a contratar',

            '# Contratados',
            'Fecha inicio vacante',
            'Fecha tentativa cumplimiento',
            'Dias vencidos',
            'Estado Req',
            'Dias max gestion',
            'Fecha cierre req',
            'Usuario cargo req',
            'Usuario gestiono req',
            'Vacantes Reales',
            
            //'fecha_max_presentacion_cand',
            //'num_cand_presentados_oport',
            //'num_cand_presentados_extem',
            //'num_contratados_oport',
            //'num_contratados_extem',
            'ind_cumplimiento_ANS',
            //'ind_contratacion_oportuna',
            'ind_calidad_proceso',
            'Observaciones',
            'fecha_recepcion'

            

        ];

            }
        elseif(route("home")=="https://gpc.t3rsc.co"){
            $headers = [
            'Requerimiento',
           
            'Tipo Requerimiento',
            //'Agencia',
            'Ciudad',
            'Departamento',
            'País',
            'Cliente',
            //'Cargo Genérico',
            'Cargo Cliente',
            'Vacantes Solicitadas',
            '# Preperfilados',
            '# Aplicados',
            '# Asociados',
            '# Citados',
           
            '# Enviados a pruebas',
            '# Enviados a referenciación',
            //'# Consultas de seguridad',
            '# Enviados Entre. Virtual',
            '# Enviados Entre. Presencial',
            '# Enviados al cliente',
            //'# Enviados a Exa. Médicos',
            //'# Enviados Est. Seguridad',
            '# Enviados a contratar',

            //'# Contratados',
            'Fecha inicio vacante',
            'Fecha tentativa cumplimiento',
            'Dias vencidos',
            'Estado Req',
            'Dias max gestion',
            'Fecha cierre req',
            'Usuario cargo req',
            'Usuario gestiono req',
            'Vacantes Reales',
            
            //'fecha_max_presentacion_cand',
            //'num_cand_presentados_oport',
            //'num_cand_presentados_extem',
            //'num_contratados_oport',
            //'num_contratados_extem',
            //'ind_cumplimiento_ANS',
            //'ind_contratacion_oportuna',
            //'ind_calidad_proceso',
            'Observaciones',

            

        ];
        }
        else{
            if ($sitio->multiple_empresa_contrato && $sitio->agencias) {
                $headers = [
                    'Requerimiento',
                    'Tipo Requerimiento',
                    'Motivo Requerimiento',
                    'Agencia',
                    'Empresa',
                    'Ciudad',
                    'Salario',
                    'Departamento',
                    'País',
                    'Cliente',
                    'Cargo Genérico',
                    'Cargo Cliente',
                    'Vacantes Solicitadas',
                    '# Preperfilados',
                    '# Aplicados',
                    '# Asociados',
                    '# Citados',
                    '# Enviados a pruebas',
                    '# Enviados a referenciación',
                    '# Consultas de seguridad',
                    '# Enviados Entre. Virtual',
                    '# Enviados Entre. Presencial',
                    '# Enviados al cliente',
                    '# Enviados a Exa. Médicos',
                    '# Enviados Est. Seguridad',
                    '# Enviados a contratar',
                    '# Contratados',
                    '# Enviados a Pruebas excel básico',
                    '# Enviados a Pruebas excel intermedio',
                    '# Enviados a Pruebas ethical values',
                    '# Enviados a Pruebas personal skills',
                    '# Enviados a Pruebas digitación',
                    '# Enviados a Prueba Bryg',
                    'Fecha inicio vacante',
                    'Fecha tentativa cumplimiento',
                    'Dias vencidos',
                    'Estado Req',
                    'Dias max gestion',
                    'Fecha cierre req',
                    'Usuario cargo req',
                    'Usuario gestiono req',
                    'Vacantes Reales',
                    'ind_cumplimiento_ANS',
                    'ind_calidad_proceso',
                    'Observaciones'
                ];
            } elseif($sitio->agencias) {
                $headers = [
                    'Requerimiento',
                   
                    'Tipo Requerimiento',
                    'Motivo Requerimiento',
                    'Agencia',
                    'Ciudad',
                    'Salario',
                    'Departamento',
                    'País',
                    'Cliente',
                    'Cargo Genérico',
                    'Cargo Cliente',
                    'Vacantes Solicitadas',
                    '# Preperfilados',
                    '# Aplicados',
                    '# Asociados',
                    '# Citados',
                   
                    '# Enviados a pruebas',
                    '# Enviados a referenciación',
                    '# Consultas de seguridad',
                    '# Enviados Entre. Virtual',
                    '# Enviados Entre. Presencial',
                    '# Enviados al cliente',
                    '# Enviados a Exa. Médicos',
                    '# Enviados Est. Seguridad',
                    '# Enviados a contratar',
                    '# Contratados',
                    '# Enviados a Pruebas excel básico',
                    '# Enviados a Pruebas excel intermedio',
                    '# Enviados a Pruebas ethical values',
                    '# Enviados a Pruebas personal skills',
                    '# Enviados a Pruebas digitación',
                    '# Enviados a Prueba Bryg',
                    'Fecha inicio vacante',
                    'Fecha tentativa cumplimiento',
                    'Dias vencidos',
                    'Estado Req',
                    'Dias max gestion',
                    'Fecha cierre req',
                    'Usuario cargo req',
                    'Usuario gestiono req',
                    'Vacantes Reales',
                    
                    //'fecha_max_presentacion_cand',
                    //'num_cand_presentados_oport',
                    //'num_cand_presentados_extem',
                    //'num_contratados_oport',
                    //'num_contratados_extem',
                    'ind_cumplimiento_ANS',
                    //'ind_contratacion_oportuna',
                    'ind_calidad_proceso',
                    'Observaciones',
                ];
            } elseif ($sitio->multiple_empresa_contrato) {
                $headers = [
                    'Requerimiento',
                    'Tipo Requerimiento',
                    'Motivo Requerimiento',
                    'Empresa',
                    'Ciudad',
                    'Salario',
                    'Departamento',
                    'País',
                    'Cliente',
                    'Cargo Genérico',
                    'Cargo Cliente',
                    'Vacantes Solicitadas',
                    '# Preperfilados',
                    '# Aplicados',
                    '# Asociados',
                    '# Citados',
                    '# Enviados a pruebas',
                    '# Enviados a referenciación',
                    '# Consultas de seguridad',
                    '# Enviados Entre. Virtual',
                    '# Enviados Entre. Presencial',
                    '# Enviados al cliente',
                    '# Enviados a Exa. Médicos',
                    '# Enviados Est. Seguridad',
                    '# Enviados a contratar',
                    '# Contratados',
                    '# Enviados a Pruebas excel básico',
                    '# Enviados a Pruebas excel intermedio',
                    '# Enviados a Pruebas ethical values',
                    '# Enviados a Pruebas personal skills',
                    '# Enviados a Pruebas digitación',
                    '# Enviados a Prueba Bryg',
                    'Fecha inicio vacante',
                    'Fecha tentativa cumplimiento',
                    'Dias vencidos',
                    'Estado Req',
                    'Dias max gestion',
                    'Fecha cierre req',
                    'Usuario cargo req',
                    'Usuario gestiono req',
                    'Vacantes Reales',
                    'ind_cumplimiento_ANS',
                    'ind_calidad_proceso',
                    'Observaciones'
                ];
            } else {
                $headers = [
                    'Requerimiento',
                    'Tipo Requerimiento',
                    'Motivo Requerimiento',
                    'Ciudad',
                    'Salario',
                    'Departamento',
                    'País',
                    'Cliente',
                    'Cargo Genérico',
                    'Cargo Cliente',
                    'Vacantes Solicitadas',
                    '# Preperfilados',
                    '# Aplicados',
                    '# Asociados',
                    '# Citados',
                    '# Enviados a pruebas',
                    '# Enviados a referenciación',
                    '# Consultas de seguridad',
                    '# Enviados Entre. Virtual',
                    '# Enviados Entre. Presencial',
                    '# Enviados al cliente',
                    '# Enviados a Exa. Médicos',
                    '# Enviados Est. Seguridad',
                    '# Enviados a contratar',
                    '# Contratados',
                    '# Enviados a Pruebas excel básico',
                    '# Enviados a Pruebas excel intermedio',
                    '# Enviados a Pruebas ethical values',
                    '# Enviados a Pruebas personal skills',
                    '# Enviados a Pruebas digitación',
                    '# Enviados a Prueba Bryg',
                    'Fecha inicio vacante',
                    'Fecha tentativa cumplimiento',
                    'Dias vencidos',
                    'Estado Req',
                    'Dias max gestion',
                    'Fecha cierre req',
                    'Usuario cargo req',
                    'Usuario gestiono req',
                    'Vacantes Reales',
                    'ind_cumplimiento_ANS',
                    'ind_calidad_proceso',
                    'Observaciones'
                ];
            }

        }

        
      
        
        
        return $headers;
    }
    private function getHeaderDiario()
    {
       
        if (route('home')!= "http://komatsu.t3rsc.co" && route('home')!= "https://komatsu.t3rsc.co" && route('home')!= "http://localhost:8000") {
                 
            $headers = [
            'Requerimiento',
            'Tipo Requerimiento',
            'Agencia',

            'Ciudad',
            'Departamento',
            'País',
            'Cliente',
            'Cargo Genérico',
            'Cargo Cliente',
            'Vacantes Solicitadas',
            'Cant Enviados Examenes',
            'Cand en Proceso de Contratacion',
            'Cant Contratados',
            'Fecha inicio vacante',
            'Fecha tentativa cumplimiento',
            'Dias vencidos',
            'Estado Req',
            'Dias max gestion',
            'Fecha cierre req',
            'Usuario cargo req',
            'Usuario gestiono req',
            'Vacantes Reales',
            //'fecha_max_presentacion_cand',
            //'num_cand_presentados_oport',
            //'num_cand_presentados_extem',
            //'num_contratados_oport',
            //'num_contratados_extem',
            'ind_oport_presentacion',
            'ind_oport_contratacion',
            'ind_calidad_presentacion',
        ];
            }else{
                //reporte diarioooo
            $headers = [
            'ID',
            'Responsable HR',
            'Cargo',
            'Tipo contrato',
            'Justificación',
            'Cantidad vacantes',
            'Estado',
            'Tipo cargo',
            'Sede',
            'Solicitante',
            'Area',
            'Gerente del Area',
           // 'Estado',
            '#en entrevista RRHH',
            '#en entrevista ténica',
            '#Candidatos en pruebas',
            '#Candidatos examen medico',
            '#Candidatos estudio seguridad',
            'Vacantes Cerradas',
            'Vacantes Pendientes',
            'ANS',
            'Fecha de Solicitud',
            'Dias solicitud-valoracion',
            'Fecha OK Valoración',
            'Dias valoracion jefe area',
            'Fecha OK Jefe Area',
            'Dias jefe area-gte area',
            'Fecha OK Gte.Area',
            'Dias gte area-gte-rrhh',
            'Fecha OK Gte.RRHH',
            'Dias gte rrhh-gte general',
            'Fecha OK Gte.General',
            'Fecha liberacion',
            'Dias Trans liberación',
            '#Postulantes internos',
            '#Postulantes externos',
            '#Postulantes en proceso internos',
            '#Postulantes en proceso externos',
            'Fecha entrevista selección(HR)',
            'Dias envio entrevista-finalizacion',
            'Fecha final entrevista hr',
            'Fecha entrevista técnica',
            'dias envio entrevista-finalizacion',
            'Fecha final entrevista técnica',
            'Fecha de pruebas',
            'Dias envio pruebas-recibo informe',
            'Fecha recibo informe de pruebas',
            'Fecha inicio envio aprobar',
            'Fecha solicitud examenes médicos',
            'Dias solicitud examenes-entrega examenes',
            'Fecha entrega examenes médicos',
            'Fecha solicitud estudio seguridad',
            'Dias solicitud est. seguridad-entrega est. seguridad',
            'Fecha entrega estudio seguridad',
            //'Comentarios',
            'Fecha cierre requerimiento',
            'Total dias Proceso',            
            //'Tipo de novedad',
            'Nombre del seleccionado',
            'Fecha de contratación',
            'Fecha de cancelación de proceso'
        ];

            }


       
        return $headers;
    }
     private function getHeaderAnalistas()
    {
       
        if (route('home')!= "http://komatsu.t3rsc.co" && route('home')!= "https://komatsu.t3rsc.co") {
                 
                 $headers = [
            'Requerimiento',
            'Tipo Requerimiento',
            'Agencia',

            'Ciudad',
            'Departamento',
            'País',
            'Cliente',
            'Cargo Genérico',
            'Cargo Cliente',
            'Vacantes Solicitadas',
            'Cant Enviados Examenes',
            'Cand en Proceso de Contratacion',
            'Cant Contratados',
            'Fecha inicio vacante',
            'Fecha tentativa cumplimiento',
            'Dias vencidos',
            'Estado Req',
            'Dias max gestion',
            'Fecha cierre req',
            'Usuario cargo req',
            'Usuario gestiono req',
            'Vacantes Reales',
            //'fecha_max_presentacion_cand',
            //'num_cand_presentados_oport',
            //'num_cand_presentados_extem',
            //'num_contratados_oport',
            //'num_contratados_extem',
            'ind_oport_presentacion',
            'ind_oport_contratacion',
            'ind_calidad_presentacion',
        ];
            }else{
            $headers = [
            'ID',
            'Responsable HR',
            'Cargo',
            'Tipo contrato',
            //'Nivel',
            'Justificación',
            'Cantidad vacantes',
             'Sede',
            'Solicitante',
            'Area',
            'Candidato',
            //'Estado',
            'Entrevista RRHH',
            'Entrevista ténica',
            'Pruebas',
            'Examen medico',
            'Estudio seguridad'
        /*'Vacantes Cerradas',
            'Vacantes Pendientes',
            'ANS',
            'Fecha de Solicitud',
            'Fecha OK Valoración',
            'Fecha OK Jefe Area',
            'Fecha OK Gte.Area',
            'Fecha OK Gte.RRHH',
            'Fecha lanzamiento convocatoria',
            '#Postulantes internos',
            '#Postulantes externos',
            '#Postulantes en proceso internos',
            '#Postulantes en proceso externos',
            'Fecha entrevista selección(HR)',
            'Fecha entrevista técnica',
            'Fecha de pruebas',
            'Fecha recibo informe de pruebas',
            'Fecha inicio envio aprobar',
            'Fecha solicitud examenes médicos',
            'Fecha entrega examenes médicos',
            'Fecha solicitud estudio seguridad',
            'Fecha entrega estudio seguridad',
            'Comentarios',
            'Fecha cierre requerimiento',
            'Tipo de novedad',
            'Nombre del seleccionado',
            'Fecha de contratación',
            'Fecha de cancelación de proceso'*/

            
        ];

            }
       
        return $headers;
    }

    private function getDataDetalle($request)
    {

     // dd($request);
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_final  = $request['fecha_final'];
        $cliente_id   = $request['cliente_id'];
        $criterio     = $request['criterio'];
        $usuario      = $request['usuario_gestion'];
        
        if (route('home') == 'https://gpc.t3rsc.co') {
            $agencia      = null;
        }else{
            $agencia      = $request['agencia'];
        }

        if (!isset($request['ciudad_id'])){
          $ciudad = "";
        }else{
         $ciudad = $request['ciudad_id']; //para tiempos
        }

        if (!isset($request['pais_id'])){
          $pais = "";
        }else{
         $pais = $request['pais_id']; //para tiempos
        }

        if (!isset($request['departamento_id'])){
          $departamento = "";
        }else{
         $departamento = $request['departamento_id']; //para tiempos
        }

       // dd($request->ciudad_id);
        if (!isset($request['cargo_id'])) {
          $cargo = "";
        }else{
          $cargo = $request['cargo_id']; //para tiempos
        }

        $num_req      = '';
        $negocio_id    = '';
        $formato      = ($request['formato']) ? $request['formato'] : 'html';
        $area1='';

        if(isset($request['area_id'])){
            $area1=$request['area_id'];
        }
        if(isset($request->num_req)){
           $num_req=$request['num_req'];
        }

        if(isset($request['negocio_id'])){
            $negocio_id=$request['negocio_id'];
        }

        $data="";
        //dd($formato);
        // Data
        if($fecha_inicio != '' || $fecha_final != '' || $cliente_id != '' || $criterio!= '' || $area1!='' || $num_req!='' || $ciudad !=''|| $cargo !='' || $negocio_id !='' || $usuario!='' || $agencia!=''){ //si no estan vacios
        //$data = DB::table('requerimientos')

         if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co"){
             //dd($request->ciudad_id);
            $data = Requerimiento::join(
                    'tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
                    ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
                    ->join('estados', 'estados.id', '=', 'estados_requerimiento.estado')
                    ->join('tipos_contratos', 'requerimientos.tipo_contrato_id', '=', 'tipos_contratos.id')
                    ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                        ->join("departamentos", function ($join) {
                          $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                          ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                        })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                        ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                        ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                        })
                        ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
                        ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
                        ->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
                        ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
                        ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
                        ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
                        ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$ciudad,$pais,$departamento,$num_req,$negocio_id,$area1,$cargo,$usuario,$agencia,$request) {

                            if ($fecha_inicio != "" && $fecha_final != "") {
                               
                               $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                            }

                            if ($cliente_id != "" && $cliente_id != "") {
                                $sql->where("clientes.id", $cliente_id);
                            }

                            if ($usuario != "") {
                                $sql->where("estados_requerimiento.user_gestion",$usuario);
                            }
                            if ($agencia != "") {
                                $sql->where("agencias.id",$agencia);
                            }


                            if ($ciudad != "") {
                                $sql->where("requerimientos.ciudad_id", $ciudad);
                            }

                            if ($pais != "") {
                                $sql->where("requerimientos.pais_id", $pais);
                            }
                            
                            if ($departamento != "") {
                                //dd($request->departamento_id);
                               $sql->where("requerimientos.departamento_id", $departamento);
                            }

                            if($negocio_id != "") {
                             $sql->where("negocio.num_negocio", $negocio_id);
                            }

                            if(!is_null($cargo) && $cargo != "") {
                               $sql->where("requerimientos.cargo_generico_id", $cargo);
                            }

                            switch ($criterio) {

                                case 1: //Req abiertas
                                    $sql->whereIn("estados_requerimiento.estado", [
                                        config('conf_aplicacion.C_RECLUTAMIENTO'),
                                        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                                        config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                                        config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),

                                    ]);
                                    break;
                                case 2: //CERRADAS OPORTUNAMENTE
                                    $sql->where("estados_requerimiento.estado", "=", config('conf_aplicacion.C_TERMINADO'));
                                    $sql->whereRaw("estados_requerimiento.created_at<=requerimientos.fecha_terminacion");
                                    break;
                                case 3: //requi contratadas
                                    $sql->where("estados_requerimiento.estado", "=", config('conf_aplicacion.C_TERMINADO'));
                                    $sql->Orwhere("estados_requerimiento.estado", "=", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'));
                                    break;
                                case 4: //requi canceladas
                                   $sql->whereIn("requerimientos_estados.max_estado",[2,1,19,22]);
                                break ;   
                                default:
                                    $sql->whereIn("estados_requerimiento.estado", [
                                        22,
                                        3,
                                        config('conf_aplicacion.C_TERMINADO'),
                                        config('conf_aplicacion.C_RECLUTAMIENTO'),
                                        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                                        config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                                        config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                                        config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                                        config('conf_aplicacion.C_CLIENTE'),
                                        2,
                                    ]);
                            }
                        })
                        ->where(function ($query) use ($cliente_id) {
                            if($cliente_id == '' || $cliente_id == null) {
                                $ids_clientes_prueba = [];
                                if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                                    $query->whereNotIn("clientes.id", $ids_clientes_prueba);
                                }
                            }
                        })
                        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
                        ->select('requerimientos.negocio_id',
                            'agencias.descripcion as nombre_agencia',
                            'requerimientos.id',
                            'cargos_especificos.firma_digital as firma_cargo',
                            'requerimientos.id as requerimiento_id',
                            'estados.descripcion as estado_req',
                            'users.name as usuario_cargo_req',
                            DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                            'ciudad.agencia as agencia ',
                            'ciudad.nombre as ciudad_req',
                            'departamentos.nombre as departamento',
                            'paises.nombre as pais',
                            'clientes.nombre as cliente',
                            'clientes.id as cliente_id',
                            'tipos_contratos.descripcion as tipo_contrato',
                            'cargos_genericos.descripcion as cargo_generico',
                            'cargos_especificos.descripcion as cargo_cliente',
                            'requerimientos.num_vacantes as vacantes_solicitadas',
                            DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
                            DB::raw('(select count(DISTINCT(candidato_id)) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id and apto is null) as cant_enviados_contratacion'),
                            DB::raw('(select count(*) from firma_contratos where terminado in(1,2) and estado not in(0) and req_id=requerimientos.id ) as cant_contratados'),
                            DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                            DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),

                            //metodo para dias_vencidos
                            DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                                order by created_at desc limit 1) IS NULL
                                   THEN datediff(now(),requerimientos.fecha_ingreso)
                                    ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                                order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
            //-------------------------------------------------------------------------------------
                            DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                            //DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                            //DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                   /*DB::raw('(select upper(p.name)  
                    from role_users o 
                    left join users p on o.user_id=p.id 
                    left join users_x_clientes ux on p.id=ux.user_id
                    left join clientes cli on ux.cliente_id=cli.id
                    left join negocio neg on cli.id=neg.cliente_id
                    left join requerimientos req on neg.id=req.negocio_id 
                    left join estados_requerimiento er on er.req_id=req.id

                    where req.id=requerimiento_id and 
                    er.user_gestion=p.id
                    order by o.created_at desc limit 1) as usuario_gestiono_req'),*/
                    DB::raw('(select upper(name) from users where users.id=estados_requerimiento.user_gestion) as usuario_gestiono_req'),
                            DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). '  )
                             order by created_at desc limit 1) as fecha_cierre_req'),
                            DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                            DB::raw('requerimientos.num_vacantes - (select count(*) from firma_contratos where terminado in(1,2) and estado not in(0) and req_id=requerimientos.id ) as vacantes_reales_asistente'),
                            DB::raw(' round(((select count(*) from procesos_candidato_req
                        where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
                        group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion'),
                            DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                            DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion ')
                        )
                ->groupBy('requerimientos.id')
                ->orderBy('requerimiento_id','desc');

        }/*elseif(route('home') == "http://soluciones.t3rsc.co" || route('home') == "https://soluciones.t3rsc.co" ){

          // $area=$request['area_id'];
          // $num_req=$request['num_req'];
           $date = Carbon::now();
           $mes =  $date->subMonth(1);
          
            $data=Requerimiento::join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
             ->join('estados', 'estados.id', '=', 'estados_requerimiento.estado')
                /*->join('ciudad', function ($join) {
                    $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                       ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                      ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
                })
                ->join('tipos_contratos', 'requerimientos.tipo_contrato_id', '=', 'tipos_contratos.id')
                //->join('departamentos', function ($join2) {
                  //  $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                    //    ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
                //})
                //->join('paises', 'requerimientos.pais_id', '=', 'paises.cod_pais')
                ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
                ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')

                //->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
                ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
                ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
                ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
                ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$mes){
                    
                    if($fecha_inicio != "" && $fecha_final != "") {
                        $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                    }else{
                        
                        $sql->whereDate("requerimientos.created_at",'>',$mes);
                    }

                    if ((int) $cliente_id > 0 && $cliente_id != "") {
                        $sql->where("clientes.id", $cliente_id);
                    }


                })->select(
                    'requerimientos.id as requerimiento_id',
                    'requerimientos.tipo_proceso_id',
                    'requerimientos.ciudad_id',
                    'requerimientos.pais_id',
                    'requerimientos.departamento_id',
                    'requerimientos.cargo_especifico_id',
                        'requerimientos.cargo_generico_id',
                        'requerimientos.negocio_id',
                        //'ciudad.agencia as agencia ',
                        'estados.descripcion as estado_req',
                    //DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                    //'clientes.nombre as cliente',
                    'tipos_contratos.descripcion as tipo_contrato',
                    ////'cargos_genericos.descripcion as cargo_generico',
                    'cargos_especificos.descripcion as cargo_cliente',
                    //'requerimientos.num_vacantes as vacantes_solicitadas',
                    //DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
                    //DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                    //DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                    DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                    DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),
                    //metodo para dias_vencidos
                    DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                        order by created_at desc limit 1) IS NULL
                           THEN datediff(now(),requerimientos.fecha_ingreso)
                            ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                        order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
                     //-------------------------------------------------------------------------------------
                    DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                    //DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                    //DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                    DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,3,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). '  )
                     order by created_at desc limit 1) as fecha_cierre_req'),
                    'requerimientos.cand_presentados_puntual',
                    'requerimientos.cuantos_candidatos_presentar',
                    'requerimientos.cand_contratados_puntual',
                    'requerimientos.num_vacantes',
                    DB::raw('upper(users.name) as usuario_cargo_req'),
                    DB::raw('(select upper(name) from users where users.id=estados_requerimiento.user_gestion) as usuario_gestiono_req'),
                    /*DB::raw('((select upper(p.name)  
                        from role_users o 
                        left join users p on o.user_id=p.id 
                        left join users_x_clientes ux on p.id=ux.user_id
                        left join clientes cli on ux.cliente_id=cli.id
                        left join negocio neg on cli.id=neg.cliente_id
                        left join requerimientos req on neg.id=req.negocio_id
                        left join estados_requerimiento er on er.req_id=req.id
                        where req.id=requerimiento_id and

                        er.user_gestion=p.id and
                        er.estado=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)
                        order by o.created_at desc limit 1)) as usuario_gestiono_req'),*/
                    /*DB::raw('case estados_requerimiento.estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),*/
                    //DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales ')
                    //'requerimientos.fecha_presentacion_oport_cand',
                    //'requerimientos.cand_presentados_puntual',
                    //'requerimientos.cand_presentados_no_puntual',
                    //'requerimientos.cand_contratados_puntual',
                    //'requerimientos.cand_contratados_no_puntual',
                    //DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                    //DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                    //DB::raw(' round(((select count(*) from procesos_candidato_req
                    //where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
                    //group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')
                //)->groupBy('requerimientos.id')->orderBy('requerimiento_id','desc');
            //}
            else{
       //para komatsu
         $area=$request['area_id'];
         $num_req=$request['num_req'];

        $data=Requerimiento::join(
            'tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
             ->join('estados', 'estados.id', '=', 'estados_requerimiento.estado')
            ->join('solicitudes', 'requerimientos.solicitud_id', '=', 'solicitudes.id')
            ->join('solicitud_sedes', 'solicitudes.ciudad_id', '=', 'solicitud_sedes.id')
            ->join('solicitud_area_funciones', 'solicitudes.area_id', '=', 'solicitud_area_funciones.id')
            ->join('solicitud_sub_area', 'solicitudes.subarea_id', '=', 'solicitud_sub_area.id')
            ->join('solicitud_user_paso', 'solicitudes.user_id', '=', 'solicitud_user_paso.user_solicitante')

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
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$area,$num_req) {
                 if ($num_req!= "") {
                            $sql->where("requerimientos.id", $num_req);
                    }
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("solicitudes.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
                if ($area!= "") {
                   $sql->where("solicitudes.area_id", $area);
               }
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                }
                switch ($criterio) {
                    
                    case 1: //Req abiertas
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),

                        ]);
                    break;
                    
                    case 2: //CERRADAS OPORTUNAMENTE
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->whereRaw("requerimientos_estados.fecha_ultimo_estado<=requerimientos.fecha_terminacion");
                    break;
                    case 3: //requi contratadas
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->Orwhere("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'));
                    break;
                    
                    case 4: //requi canceladas
                       $sql->whereIn("requerimientos_estados.max_estado",[2,1,19,22]);
                    break ;   
                    
                    default:
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            22,
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                            config('conf_aplicacion.C_CLIENTE'),
                            2,
                        ]);
                }
            })
            ->where(function ($query) use ($cliente_id) {
                if($cliente_id == '' || $cliente_id == null) {
                    $ids_clientes_prueba = [];
                    if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                        $query->whereNotIn("clientes.id", $ids_clientes_prueba);
                    }
                }
            })
            ->select(
                'requerimientos.id as requerimiento_id',
                'requerimientos.fecha_tentativa_cierre_req as fecha_cierre',
                'estados.descripcion as estado_req',
                DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                'solicitud_sedes.descripcion as sede',
                'solicitud_area_funciones.descripcion as area',
                'solicitud_sub_area.descripcion as subarea',
                'solicitudes.created_at as fecha_solicitud',
                'solicitudes.responsable_hr as responsable',
                'ciudad.agencia as agencia ',
                'ciudad.nombre as ciudad_req',
                'departamentos.nombre as departamento',
                'paises.nombre as pais',
                 'solicitudes.funciones_realizar as justificacion',
                'clientes.nombre as cliente',
                'tipos_contratos.descripcion as tipo_contrato',
                'cargos_genericos.descripcion as cargo_generico',
                'cargos_especificos.descripcion as cargo_cliente',
                'cargos_especificos.plazo_req as ans',
                'requerimientos.num_vacantes as vacantes_solicitadas',
                'requerimientos.tipo_contrato_id as contrato',
                DB::raw('(select name from users where id=solicitudes.user_id) as solicitante'),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Valorado') as fecha_valoracion"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Aprobacion 1') as fecha_jefe_ok"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Aprobacion 2') as fecha_gte_ok"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Aprobacion 3') as fecha_rrhh_ok"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Liberado') as fecha_liberacion"),
                DB::raw("(select user_id from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Liberado') as user_libero"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Valorado') as fecha_valoracion"),
                 DB::raw('(select name from users y inner join solicitud_user_paso x on y.id=x.user_gerente_area where x.user_solicitante=solicitudes.user_id) as gerente_area'),
                 DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado='.config('conf_aplicacion.C_TERMINADO').') as fecha_terminacion'),
                 DB::raw('(select count(*) from requerimiento_cantidato,datos_basicos where requerimiento_cantidato.candidato_id=datos_basicos.user_id and requerimiento_cantidato.requerimiento_id=requerimientos.id and datos_basicos.trabaja=1) as postulantes_proceso_internos'),
                 DB::raw('(select count(*) from candidatos_otras_fuentes,datos_basicos where candidatos_otras_fuentes.cedula=datos_basicos.numero_id and candidatos_otras_fuentes.requerimiento_id=requerimientos.id and candidatos_otras_fuentes.status=1 and datos_basicos.trabaja=1) as postulantes_internos'),
                 DB::raw('(select count(*) from candidatos_otras_fuentes,datos_basicos where candidatos_otras_fuentes.cedula=datos_basicos.numero_id and candidatos_otras_fuentes.requerimiento_id=requerimientos.id and
                    candidatos_otras_fuentes.status=1 and datos_basicos.trabaja=0) as postulantes_externos'),
                 DB::raw('(select count(*) from requerimiento_cantidato,datos_basicos where requerimiento_cantidato.candidato_id=datos_basicos.user_id and requerimiento_cantidato.requerimiento_id=requerimientos.id and datos_basicos.trabaja=0) as postulantes_proceso_externos'),
                 DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id limit 1) as fecha_primero_pruebas'),
                  DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id and apto=1 order by id DESC limit 1) as fecha_ultimo_entrega_pruebas'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
               
                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id limit 1) as fecha_primero_examenes'),
                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id and apto=1 order by id DESC limit 1) as fecha_ultimo_entrega_examenes'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA\') and requerimiento_id=requerimientos.id ) as cant_enviados_entrevista'),
                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA\') and requerimiento_id=requerimientos.id limit 1) as fecha_entrevista'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA_TECNICA\') and requerimiento_id=requerimientos.id ) as cant_enviados_entrevista_tecnica'),

                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA_TECNICA\') and requerimiento_id=requerimientos.id limit 1) as fecha_entrevista_tecnica'),

                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_APROBAR_CLIENTE\') and requerimiento_id=requerimientos.id limit 1) as fecha_envio_aprobar'),

                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION_CLIENTE\') and requerimiento_id=requerimientos.id limit 1) as fecha_aprobado_candidato'),

                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id ) as cant_enviados_estudioSeg'),

                 DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id limit 1) as fecha_primero_estudio'),
                  DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id and apto=1 order by id DESC limit 1) as fecha_ultimo_entrega_estudio'),
                 DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id ) as cant_enviados_pruebas'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                 
                 DB::raw('(select fecha_inicio_contrato from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ORDER BY procesos_candidato_req.id DESC limit 1) as fecha_ultima_contratacion'),

                 DB::raw('(select nombres from datos_basicos,procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and procesos_candidato_req.candidato_id=datos_basicos.user_id and procesos_candidato_req.requerimiento_id=requerimientos.id order by procesos_candidato_req.id DESC limit 1) as ultimo_contratado'),

                 DB::raw('(select entrevistas_candidatos.created_at from entrevistas_candidatos,procesos_candidato_req where entrevistas_candidatos.candidato_id = procesos_candidato_req.candidato_id and entrevistas_candidatos.req_id=requerimientos.id and procesos_candidato_req.requerimiento_id= requerimientos.id order by entrevistas_candidatos.id DESC limit 1) as fecha_fin_entrevista'),
                
                DB::raw('(select role_users.role_id from entrevistas_candidatos,procesos_candidato_req,role_users where role_users.user_id = entrevistas_candidatos.user_gestion_id and entrevistas_candidatos.candidato_id = procesos_candidato_req.candidato_id and entrevistas_candidatos.req_id=requerimientos.id and procesos_candidato_req.requerimiento_id= requerimientos.id order by role_users.role_id DESC limit 1) as usuario_entrevisto'),

                 DB::raw('(select trabaja from datos_basicos,procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and procesos_candidato_req.candidato_id=datos_basicos.user_id and procesos_candidato_req.requerimiento_id=requerimientos.id order by procesos_candidato_req.id DESC limit 1) as novedad'),

                DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),

                //metodo para dias_vencidos
                DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1) IS NULL
                       THEN datediff(now(),requerimientos.fecha_ingreso)
                        ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
//-------------------------------------------------------------------------------------
                DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
             //   DB::raw('(select upper(estados.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
              //  DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').')
                 order by created_at desc limit 1) as fecha_cierre_req'),

                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in (2,22,'.config('conf_aplicacion.C_CLIENTE'). ')
                 order by created_at desc limit 1) as fecha_cancelacion_req'),

                DB::raw('upper(users.name) as usuario_cargo_req'),
                DB::raw('(select upper(p.name)  
                    from role_users o 
                    left join users p on o.user_id=p.id 
                    left join users_x_clientes ux on p.id=ux.user_id
                    left join clientes cli on ux.cliente_id=cli.id
                    left join negocio neg on cli.id=neg.cliente_id
                    left join requerimientos req on neg.id=req.negocio_id where req.id=requerimiento_id and
                    o.role_id = 17  
                    order by o.created_at desc limit 1) as usuario_gestiono_req'),
                DB::raw('case requerimientos_estados.max_estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),
                DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales ')
                //'requerimientos.fecha_presentacion_oport_cand',
                //'requerimientos.cand_presentados_puntual',
                //'requerimientos.cand_presentados_no_puntual',
                //'requerimientos.cand_contratados_puntual',
                //'requerimientos.cand_contratados_no_puntual',
                //DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                //DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                //DB::raw(' round(((select count(*) from procesos_candidato_req
    //where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')
                )
        ->groupBy('requerimientos.id')
        ->orderBy('requerimiento_id','desc');
        }
       
    //*********
    }//fin else
     //dd($data->toSql());
    if($data != ""){
       
     if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
       $data = $data->get();
     
     }else{
       $data = $data->paginate(5);
     }

    }
   //dd($data);
   return $data;

}

private function getDataExamenesMedicos($request)
    {

     // dd($request);
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_final  = $request['fecha_final'];
        $req_id   = $request['req_id'];
        $orden_id   = $request['orden_id'];
       

        if (!isset($request['req_id'])){
          $req_id = "";
        }
         if (!isset($request['orden_id'])){
          $orden_id = "";
        }

       // dd($request->ciudad_id);
       

        $num_req      = '';
        $negocio_id    = '';
        $formato      = ($request['formato']) ? $request['formato'] : 'html';
        $area1='';


        $data="";
    
        //dd($formato);
        // Data

        if($fecha_inicio != '' || $fecha_final != '' || $req_id !='' || $orden_id!=''){ //si no estan vacios
        //$data = DB::table('requerimientos')

        
             //dd($request->ciudad_id);

            
            $data = OrdenMedica::join(
                    'requerimiento_cantidato','requerimiento_cantidato.id','=','orden_medica.req_can_id')
                    ->join('requerimientos', 'requerimientos.id', '=', 'requerimiento_cantidato.requerimiento_id')
                    
                    ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                        ->join("departamentos", function ($join) {
                          $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                          ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                        })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                        ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                        ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                        })
                        ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
                        ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
                        ->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
                        ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
                        ->join('datos_basicos','datos_basicos.user_id','=','requerimiento_cantidato.candidato_id')
                        ->join('proveedor','proveedor.id','=','orden_medica.proveedor_id')
                        
                        ->where(function ($sql) use ($fecha_inicio, $fecha_final,$orden_id,$req_id,$request) {

                            if ($fecha_inicio != "" && $fecha_final != "") {
                               
                               $sql->whereBetween("orden_medica.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                            }

                            if ($req_id != "") {
                                $sql->where("requerimientos.id", $req_id);
                            }

                            if ($orden_id != "") {
                                $sql->where("orden_medica.id",$orden_id);
                            }
                        })
                        ->where(function ($query) {
                            $ids_clientes_prueba = [];
                            if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                                //$query->whereNotIn("clientes.id", $ids_clientes_prueba);
                            }
                        })
                       
                        ->select('orden_medica.id as orden','orden_medica.id','orden_medica.created_at as fecha_orden',"datos_basicos.numero_id as cedula","datos_basicos.nombres as nombres","datos_basicos.primer_apellido as primer_apellido","clientes.nombre as cliente","cargos_especificos.descripcion as cargo","ciudad.nombre as ciudad","proveedor.nombre as proveedor",'orden_medica.observacion as observacion'
                           

                        )
                ->with("examenes_medicos")
                  
                ->groupBy('orden_medica.id')
                ->orderBy('orden_medica.id','desc');

      
       
    //*********
    }//fin else
//dd($data->toSql());

    if($data != ""){
       
     if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
       $data = $data->get();


     
     }else{

       $data = $data->paginate(5);
       
     }

    }
   //dd($data);
   return $data;

}

 private function getDataReporteIndicador($request)
    {

     // dd($request);
        $fecha_inicio = $request['fecha_inicio'];
        $fecha_final  = $request['fecha_final'];
        $cliente_id   = $request['cliente_id'];
        $criterio     = $request['criterio'];
        $usuario      = $request['usuario_gestion'];
        $agencia      = $request['agencia'];

        if (!isset($request['ciudad_id'])){
          $ciudad = "";
        }else{
         $ciudad = $request['ciudad_id']; //para tiempos
        }

        if (!isset($request['pais_id'])){
          $pais = "";
        }else{
         $pais = $request['pais_id']; //para tiempos
        }

        if (!isset($request['departamento_id'])){
          $departamento = "";
        }else{
         $departamento = $request['departamento_id']; //para tiempos
        }

       // dd($request->ciudad_id);
        if (!isset($request['cargo_id'])) {
          $cargo = "";
        }else{
          $cargo = $request['cargo_id']; //para tiempos
        }

        $num_req      = '';
        $negocio_id    = '';
        $formato      = ($request['formato']) ? $request['formato'] : 'html';
        $area1='';

        if(isset($request['area_id'])){
            $area1=$request['area_id'];
        }
        if(isset($request->num_req)){
           $num_req=$request['num_req'];
        }

        if(isset($request['negocio_id'])){
            $negocio_id=$request['negocio_id'];
        }

        $data="";
        //dd($formato);
        // Data
        if($fecha_inicio != '' || $fecha_final != '' || $cliente_id != '' || $criterio!= '' || $area1!='' || $num_req!='' || $ciudad !=''|| $cargo !='' || $negocio_id !='' || $usuario!='' || $agencia!=''){ //si no estan vacios
        //$data = DB::table('requerimientos')
          // $area=$request['area_id'];
          // $num_req=$request['num_req'];
           $date = Carbon::now();
           $mes =  $date->subMonth(1);
          
             $data=Requerimiento::join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
             ->join('estados', 'estados.id', '=', 'estados_requerimiento.estado')
                /*->join('ciudad', function ($join) {
                    $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                       ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                      ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
                })*/
                ->join('tipos_contratos', 'requerimientos.tipo_contrato_id', '=', 'tipos_contratos.id')
                //->join('departamentos', function ($join2) {
                  //  $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                    //    ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
                //})
                //->join('paises', 'requerimientos.pais_id', '=', 'paises.cod_pais')
                ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
                ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')

                //->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
                ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
                ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
                ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
                ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$mes) {
                    
                    if ($fecha_inicio != "" && $fecha_final != "") {
                        $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                    }else{
                        
                        $sql->whereDate("requerimientos.created_at",'>',$mes);
                    }

                    if ((int) $cliente_id > 0 && $cliente_id != "") {
                        $sql->where("clientes.id", $cliente_id);
                    }


                })->select(
                    'requerimientos.id as requerimiento_id',
                    'requerimientos.tipo_proceso_id',
                    'requerimientos.ciudad_id',
                    'requerimientos.pais_id',
                    'requerimientos.departamento_id',
                    'requerimientos.cargo_especifico_id',
                        'requerimientos.cargo_generico_id',
                        'requerimientos.negocio_id',
                        //'ciudad.agencia as agencia ',
                        'estados.descripcion as estado_req',
                    //DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                    //'clientes.nombre as cliente',
                    'tipos_contratos.descripcion as tipo_contrato',
                    ////'cargos_genericos.descripcion as cargo_generico',
                    'cargos_especificos.descripcion as cargo_cliente',
                    //'requerimientos.num_vacantes as vacantes_solicitadas',
                    //DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
                    //DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                    //DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                     DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_APROBAR_CLIENTE\') and requerimiento_id=requerimientos.id order by id ASC limit 1) as fecha_primer_envio'),
                     DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_APROBAR_CLIENTE\') and requerimiento_id=requerimientos.id) as cantidad_enviados'),
                     DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_APROBAR_CLIENTE\') and requerimiento_id=requerimientos.id and (apto=1 or apto is null)) as cantidad_enviados_aprobados'),
                     DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_APROBAR_CLIENTE\') and requerimiento_id=requerimientos.id and apto=0) as cantidad_enviados_no_aprobados'),
                    DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                    DB::raw('MONTHNAME(requerimientos.created_at) as mes_creacion'),
                    DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),
                    //metodo para dias_vencidos
                    DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                        order by created_at desc limit 1) IS NULL
                           THEN datediff(now(),requerimientos.fecha_ingreso)
                            ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                        order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
                     //-------------------------------------------------------------------------------------
                    DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                   
                    //DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                    //DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                    DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). '  )
                     order by created_at desc limit 1) as fecha_cierre_req'),
                    'requerimientos.cand_presentados_puntual',
                    'requerimientos.cuantos_candidatos_presentar',
                    'requerimientos.cand_contratados_puntual',
                    'requerimientos.num_vacantes',
                    DB::raw('upper(users.name) as usuario_cargo_req'),
                    DB::raw('((select upper(p.name)  
                        from role_users o 
                        left join users p on o.user_id=p.id 
                        left join users_x_clientes ux on p.id=ux.user_id
                        left join clientes cli on ux.cliente_id=cli.id
                        left join negocio neg on cli.id=neg.cliente_id
                        left join requerimientos req on neg.id=req.negocio_id
                        left join estados_requerimiento er on er.req_id=req.id
                        where req.id=requerimiento_id and

                        o.role_id=17 and
                        er.user_gestion=p.id and
                        er.estado=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)
                        order by o.created_at desc limit 1)) as usuario_gestiono_req'),
                    /*DB::raw('case estados_requerimiento.estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),*/
                    DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales ')
                    //'requerimientos.fecha_presentacion_oport_cand',
                    //'requerimientos.cand_presentados_puntual',
                    //'requerimientos.cand_presentados_no_puntual',
                    //'requerimientos.cand_contratados_puntual',
                    //'requerimientos.cand_contratados_no_puntual',
                    //DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                    //DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                    //DB::raw(' round(((select count(*) from procesos_candidato_req
                    //where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
                    //group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')
                )->groupBy('requerimientos.id')->orderBy('requerimiento_id','desc');

        
       }
    //*********
    //fin else
//dd($data->toSql());
    if($data != ""){
       
     if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
       $data = $data->get();
     
     }else{
       $data = $data->paginate(5);
     }

    }
   //dd($data);
   return $data;

}

    private function getDataSeguimiento(Request $request){

       // dd($request->all());
        //dd($request->agencia);
        //este es el reporte 1 a 1
        $cliente_id   = $request['cliente_id'];
        //$salario = $request['salario'];
        $criterio     = $request['criterio'];
        $num_req      = '';
        $formato      = ($request['formato'])?$request->formato:'html';
        $area1='';
        $agencia='';
        $usuario  = $request['usuario_gestion'];
        $empresa_contrata = $request['empresa_contrata'];

        $rango = "";
        if($request['rango_fecha'] != ""){
            $rango = explode(" | ", $request['rango_fecha']);
            $fecha_inicio = $rango[0];
            $fecha_final  = $rango[1];
        }

        if(isset($request['agencia'])){
            $agencia=$request['agencia'];
        }
        if(isset($request['area_id'])){
            $area1=$request['area_id'];
        }
        if(isset($request['num_req'])){
            $num_req=$request['num_req'];
        }
        $data="";
        //dd($agencia);
        // Data

        if ($fecha_inicio != '' || $fecha_final != '' || $cliente_id != '' || $criterio!= '' || $area1!='' || $num_req!='' || $agencia!='' || $usuario!='' || $empresa_contrata!=''){
          
        //$data = DB::table('requerimientos')
            if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co"){
            $data=Requerimiento::join(
            'tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->leftjoin('empresa_logos', 'empresa_logos.id', '=', 'requerimientos.empresa_contrata')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->join('estados','estados.id',"=","estados_requerimiento.estado")
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
            ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
            ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            ->join('motivo_requerimiento','motivo_requerimiento.id',"=","requerimientos.motivo_requerimiento_id")
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$agencia,$usuario, $empresa_contrata, $salario) {
                if ($fecha_inicio != "" && $fecha_final != "") {
                  
                    $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }

                if($salario!= "") {  

                  $sql->where("requerimientos.salario",$salario);                    
                }

                if ($cliente_id != "") {

                     if($cliente_id[0]!="null"){
                        
                         $sql->whereIn("clientes.id", $cliente_id);
                        }
                }

                if ($empresa_contrata != "" && $empresa_contrata[0]!="null") {

                    $sql->whereIn("requerimientos.empresa_contrata", $empresa_contrata);
                }
                
                if($agencia!= "") {                    
                  $sql->whereIn("ciudad.agencia",$agencia);                    
                }

                if ($usuario != "") {
                    if($usuario[0]!="null"){
                        $sql->whereIn("estados_requerimiento.user_gestion",$usuario);
                    }
                }
                switch ($criterio) {
                    case 1: //Req abiertas
                        $sql->whereIn("estados_requerimiento.estado", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),

                        ]);
                        break;
                    case 2: //CERRADAS OPORTUNAMENTE

                        $sql->whereIn("estados_requerimiento.estado", [3, config('conf_aplicacion.C_TERMINADO')]);
                        $sql->whereRaw("estados_requerimiento.created_at<=requerimientos.fecha_tentativa_cierre_req");

                        break;
                    case 3: //requi contratadas
                        $sql->where("estados_requerimiento.estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->Orwhere("estados_requerimiento.estado", "=", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'));
                        break;
                    case 4: //requi canceladas
                       $sql->whereIn("estados_requerimiento.estado",[2,1,19,22]);
                    break ;   
                    default:
                        $sql->whereIn("estados_requerimiento.estado", [
                            22,
                            3,
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                            config('conf_aplicacion.C_CLIENTE'),
                            2,
                        ]);
                }
            })
            ->where(function ($query) use ($cliente_id) {
                if($cliente_id == '' || $cliente_id == null) {
                    $ids_clientes_prueba = [];
                    if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                        $query->whereNotIn("clientes.id", $ids_clientes_prueba);
                    }
                }
            })
            ->select(
                'requerimientos.id as requerimiento_id',
                'requerimientos.id',
                'motivo_requerimiento.descripcion as motivo_requerimiento',
                'cargos_especificos.firma_digital as firma_cargo',
                'estados.descripcion as estado_req',
                'empresa_logos.nombre_empresa',
                DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                'agencias.descripcion as nombre_agencia',
                'ciudad.agencia as agencia ',
                'ciudad.nombre as ciudad_req',
                'departamentos.nombre as departamento',
                'paises.nombre as pais',
                'clientes.nombre as cliente',
                'tipos_contratos.descripcion as tipo_contrato',
                'cargos_genericos.descripcion as cargo_generico',
                'cargos_especificos.descripcion as cargo_cliente',
                'requerimientos.num_vacantes as vacantes_solicitadas',
                'requerimientos.preperfilados as preperfilados',
                'requerimientos.fecha_recepcion as fecha_recepcion',
                'requerimientos.salario as salario',
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
                DB::raw('(select count(DISTINCT(candidato_id)) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id and apto is null) as cant_enviados_contratacion'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_APROBAR_CLIENTE\') and requerimiento_id=requerimientos.id ) as cant_enviados_aprobar_cliente'),
                DB::raw('(select count(*) from requerimiento_cantidato where requerimiento_id=requerimientos.id ) as candidatos_asociados'),
                 DB::raw('(select count(*) from ofertas_users where requerimiento_id=requerimientos.id ) as candidatos_aplicados'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA\') and requerimiento_id=requerimientos.id ) as cant_enviados_entrevista'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_REFERENCIACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_referenciacion'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id ) as cant_enviados_pruebas'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA_VIRTUAL\') and requerimiento_id=requerimientos.id ) as cant_enviados_entrevista_virtual'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXCEL_BASICO\') and requerimiento_id=requerimientos.id ) as cant_enviados_excel_basico'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXCEL_INTERMEDIO\') and requerimiento_id=requerimientos.id ) as cant_enviados_excel_intermedio'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_PRUEBA_ETHICAL_VALUES\') and requerimiento_id=requerimientos.id ) as cant_enviados_ethical_values'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_PRUEBA_COMPETENCIA\') and requerimiento_id=requerimientos.id ) as cant_enviados_prueba_competencias'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_PRUEBA_DIGITACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_prueba_digitacion'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_PRUEBA_BRYG\') and requerimiento_id=requerimientos.id ) as cant_enviados_prueba_bryg'),
                DB::raw('(select count(*) from llamada_mensaje where req_id=requerimientos.id) as cant_citados'),
                 DB::raw('(select sum(contador) from consulta_seguridad where  req_id=requerimientos.id ) as cant_consultas_seguridad'),
                //DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                 DB::raw('(select count(*) from firma_contratos where terminado in(1,2) and estado not in(0) and req_id=requerimientos.id ) as cant_contratados'),
                DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),

                //metodo para dias_vencidos
                DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,19,3,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1) IS NULL
                       THEN datediff(now(),requerimientos.fecha_ingreso)
                        ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
//-------------------------------------------------------------------------------------
                DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                //DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,19,3,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). '  )
                 order by created_at desc limit 1) as fecha_cierre_req'),

                DB::raw('upper(users.name) as usuario_cargo_req'),
                DB::raw('((select upper(p.name)  
                    from role_users o 
                    left join users p on o.user_id=p.id 
                    left join users_x_clientes ux on p.id=ux.user_id
                    left join clientes cli on ux.cliente_id=cli.id
                    left join negocio neg on cli.id=neg.cliente_id
                    left join requerimientos req on neg.id=req.negocio_id
                    left join estados_requerimiento er on er.req_id=req.id
                    where req.id=requerimiento_id and
                    o.role_id=17 and
                    er.user_gestion=p.id
                    order by o.created_at desc limit 1)) as usuario_gestiono_req'),
                DB::raw('case estados_requerimiento.estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),
                DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                 DB::raw('requerimientos.num_vacantes - (select count(*) from firma_contratos where terminado in(1,2) and estado not in(0) and req_id=requerimientos.id ) as vacantes_reales_asistente'),
                'requerimientos.fecha_presentacion_oport_cand',
                'requerimientos.cand_presentados_puntual',
                'requerimientos.cand_presentados_no_puntual',
                'requerimientos.cand_contratados_puntual',
                'requerimientos.cand_contratados_no_puntual',
                DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                DB::raw(' round(((select count(*) from procesos_candidato_req
                where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
                group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion'))
                ->groupBy('requerimientos.id')
                ->orderBy('requerimiento_id','desc');
//dd($data->toSql());
        /*if ($request->has('formato') and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
        } else {
            $data = $data->paginate(5);
        }*/

    }elseif(route('home') == "http://soluciones.t3rsc.co" || route('home') == "https://soluciones.t3rsc.co" ){

       $area=$request->area_id;
       $num_req=$request->num_req;
       $date = Carbon::now();
       $mes =  $date->subMonth(1);
      
         $data=Requerimiento::join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
         ->join('estados', 'estados.id', '=', 'estados_requerimiento.estado')
            ->join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                   ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                  ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->join('tipos_contratos', 'requerimientos.tipo_contrato_id', '=', 'tipos_contratos.id')
            //->join('departamentos', function ($join2) {
              //  $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                //    ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
            //})
            //->join('paises', 'requerimientos.pais_id', '=', 'paises.cod_pais')
            ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')

            //->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
            ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
            ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$mes) {
                
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }else{
                    
                    $sql->whereDate("requerimientos.created_at",'>',$mes);
                }

                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("clientes.id", $cliente_id);
                }


            })
            ->where(function ($query) use ($cliente_id) {
                if($cliente_id == '' || $cliente_id == null) {
                    $ids_clientes_prueba = [];
                    if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                        $query->whereNotIn("clientes.id", $ids_clientes_prueba);
                    }
                }
            })
            ->select(
                'requerimientos.id as requerimiento_id',
                'requerimientos.id',
                'requerimientos.tipo_proceso_id',
                'requerimientos.ciudad_id',
                 'requerimientos.pais_id',
                  'requerimientos.departamento_id',
                   'requerimientos.cargo_especifico_id',
                    'requerimientos.cargo_generico_id',
                    'requerimientos.negocio_id',
                    'ciudad.agencia as agencia ',
                    'estados.descripcion as estado_req',
                //DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                //'clientes.nombre as cliente',
                'tipos_contratos.descripcion as tipo_contrato',
                ////'cargos_genericos.descripcion as cargo_generico',
                'cargos_especificos.descripcion as cargo_cliente',
                //'requerimientos.num_vacantes as vacantes_solicitadas',
                //DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
                //DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                //DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),
                //metodo para dias_vencidos
                DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1) IS NULL
                       THEN datediff(now(),requerimientos.fecha_ingreso)
                        ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
//-------------------------------------------------------------------------------------
                DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                //DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                //DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). '  )
                 order by created_at desc limit 1) as fecha_cierre_req'),
                'requerimientos.cand_presentados_puntual',
                'requerimientos.cuantos_candidatos_presentar',
                'requerimientos.cand_contratados_puntual',
                'requerimientos.num_vacantes',
                DB::raw('upper(users.name) as usuario_cargo_req'),
                DB::raw('((select upper(p.name)  
                    from role_users o 
                    left join users p on o.user_id=p.id 
                    left join users_x_clientes ux on p.id=ux.user_id
                    left join clientes cli on ux.cliente_id=cli.id
                    left join negocio neg on cli.id=neg.cliente_id
                    left join requerimientos req on neg.id=req.negocio_id
                    left join estados_requerimiento er on er.req_id=req.id
                    where req.id=requerimiento_id and
                    o.role_id=17 and
                    er.user_gestion=p.id 
                    order by o.created_at desc limit 1)) as usuario_gestiono_req'),
                /*DB::raw('case estados_requerimiento.estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),*/
                DB::raw('requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales ')
                //'requerimientos.fecha_presentacion_oport_cand',
                //'requerimientos.cand_presentados_puntual',
                //'requerimientos.cand_presentados_no_puntual',
                //'requerimientos.cand_contratados_puntual',
                //'requerimientos.cand_contratados_no_puntual',
                //DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                //DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                //DB::raw(' round(((select count(*) from procesos_candidato_req
//where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
//group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')
            )->groupBy('requerimientos.id')->orderBy('requerimiento_id','desc');

    }else{
            $area=$request->area_id;
            $num_req=$request->num_req;

             $data=Requerimiento::join(
            'tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')

            ->join('solicitudes', 'requerimientos.solicitud_id', '=', 'solicitudes.id')
            ->join('solicitud_sedes', 'solicitudes.ciudad_id', '=', 'solicitud_sedes.id')
            ->join('solicitud_area_funciones', 'solicitudes.area_id', '=', 'solicitud_area_funciones.id')
            ->join('solicitud_sub_area', 'solicitudes.subarea_id', '=', 'solicitud_sub_area.id')
            ->join('solicitud_user_paso', 'solicitudes.user_id', '=', 'solicitud_user_paso.user_solicitante')

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
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$area,$num_req) {
                 if ($num_req!= "") {
                            $sql->where("requerimientos.id", $num_req);
                    }
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
                if ($area!= "") {
                   $sql->where("solicitudes.area_id", $area);
               }
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                }
                switch ($criterio) {
                    
                    case 1: //Req abiertas
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),

                        ]);
                    break;
                    
                    case 2: //CERRADAS OPORTUNAMENTE
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->whereRaw("requerimientos_estados.fecha_ultimo_estado<=requerimientos.fecha_terminacion");
                    break;
                    case 3: //requi contratadas
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->Orwhere("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'));
                    break;
                    
                    case 4: //requi canceladas
                       $sql->whereIn("requerimientos_estados.max_estado",[2,1,19,22]);
                    break ;   
                    
                    default:
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            22,
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                            config('conf_aplicacion.C_CLIENTE'),
                            2,
                        ]);
                }
            })
            ->where(function ($query) use ($cliente_id) {
                if($cliente_id == '' || $cliente_id == null) {
                    $ids_clientes_prueba = [];
                    if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                        $query->whereNotIn("requerimientos_estados.cliente_id", $ids_clientes_prueba);
                    }
                }
            })
            ->select(
                'requerimientos.id',
                'requerimientos.id as requerimiento_id',
                'requerimientos.fecha_tentativa_cierre_req as fecha_cierre',
                DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                'solicitud_sedes.descripcion as sede',
                'solicitud_area_funciones.descripcion as area',
                'solicitud_sub_area.descripcion as subarea',
                'solicitudes.created_at as fecha_solicitud',
                'solicitudes.responsable_hr as responsable',
                'ciudad.agencia as agencia ',
                'ciudad.nombre as ciudad_req',
                'departamentos.nombre as departamento',
                'paises.nombre as pais',
                 'solicitudes.funciones_realizar as justificacion',
                'clientes.nombre as cliente',
                'tipos_contratos.descripcion as tipo_contrato',
                'cargos_genericos.descripcion as cargo_generico',
                'cargos_especificos.descripcion as cargo_cliente',
                'cargos_especificos.plazo_req as ans',
                'requerimientos.num_vacantes as vacantes_solicitadas',
                DB::raw('(select name from users where id=solicitudes.user_id) as solicitante'),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Valorado') as fecha_valoracion"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Aprobacion 1') as fecha_jefe_ok"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Aprobacion 2') as fecha_gte_ok"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Aprobacion 3') as fecha_rrhh_ok"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Aprobacion 4') as fecha_gte_gneral"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Liberado') as fecha_liberacion"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Valorado') as fecha_valoracion"),
                 DB::raw('(select name from users y inner join solicitud_user_paso x on y.id=x.user_gerente_area where x.user_solicitante=solicitudes.user_id) as gerente_area'),
                 DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado='.config('conf_aplicacion.C_TERMINADO').') as fecha_terminacion'),

                 DB::raw('(select count(*) from requerimiento_cantidato,datos_basicos where requerimiento_cantidato.candidato_id=datos_basicos.user_id and requerimiento_cantidato.requerimiento_id=requerimientos.id and datos_basicos.trabaja=1) as postulantes_proceso_internos'),
                 DB::raw('(select count(*) from candidatos_otras_fuentes,datos_basicos where candidatos_otras_fuentes.cedula=datos_basicos.numero_id and candidatos_otras_fuentes.requerimiento_id=requerimientos.id and candidatos_otras_fuentes.status=1 and datos_basicos.trabaja=1) as postulantes_internos'),
                 DB::raw('(select count(*) from candidatos_otras_fuentes,datos_basicos where candidatos_otras_fuentes.cedula=datos_basicos.numero_id and candidatos_otras_fuentes.requerimiento_id=requerimientos.id and
                    candidatos_otras_fuentes.status=1 and datos_basicos.trabaja=0) as postulantes_externos'),
                 DB::raw('(select count(*) from requerimiento_cantidato,datos_basicos where requerimiento_cantidato.candidato_id=datos_basicos.user_id and requerimiento_cantidato.requerimiento_id=requerimientos.id and datos_basicos.trabaja=0) as postulantes_proceso_externos'),
                 DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id limit 1) as fecha_primero_pruebas'),
                  DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id and apto=1 order by id DESC limit 1) as fecha_ultimo_entrega_pruebas'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
               
                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id limit 1) as fecha_primero_examenes'),
                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id and apto=1 order by id DESC limit 1) as fecha_ultimo_entrega_examenes'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA\') and requerimiento_id=requerimientos.id ) as cant_enviados_entrevista'),
                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA\') and requerimiento_id=requerimientos.id limit 1) as fecha_entrevista'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA_TECNICA\') and requerimiento_id=requerimientos.id ) as cant_enviados_entrevista_tecnica'),
                 DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA_TECNICA\') and requerimiento_id=requerimientos.id limit 1) as fecha_entrevista_tecnica'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id ) as cant_enviados_estudioSeg'),
                 DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id limit 1) as fecha_primero_estudio'),
                  DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id and apto=1 order by id DESC limit 1) as fecha_ultimo_entrega_estudio'),
                 DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id ) as cant_enviados_pruebas'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                 DB::raw('(select fecha_inicio_contrato from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ORDER BY procesos_candidato_req.id DESC limit 1) as fecha_ultima_contratacion'),
                 DB::raw('(select nombres from datos_basicos,procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and procesos_candidato_req.candidato_id=datos_basicos.user_id and procesos_candidato_req.requerimiento_id=requerimientos.id order by procesos_candidato_req.id DESC limit 1) as ultimo_contratado'),

                  DB::raw('(select trabaja from datos_basicos,procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and procesos_candidato_req.candidato_id=datos_basicos.user_id and procesos_candidato_req.requerimiento_id=requerimientos.id order by procesos_candidato_req.id DESC limit 1) as novedad'),

                DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),

                //metodo para dias_vencidos
                DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1) IS NULL
                       THEN datediff(now(),requerimientos.fecha_ingreso)
                        ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
//-------------------------------------------------------------------------------------
                DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). '  )
                 order by created_at desc limit 1) as fecha_cierre_req'),

                DB::raw('upper(users.name) as usuario_cargo_req'),
                DB::raw('(select upper(p.name)  
                    from role_users o 
                    left join users p on o.user_id=p.id 
                    left join users_x_clientes ux on p.id=ux.user_id
                    left join clientes cli on ux.cliente_id=cli.id
                    left join negocio neg on cli.id=neg.cliente_id
                    left join requerimientos req on neg.id=req.negocio_id

                    where req.id=requerimiento_id and
                    o.role_id = 17  
                    order by o.created_at desc limit 1) as usuario_gestiono_req'),
                DB::raw('case requerimientos_estados.max_estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),
                DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                'requerimientos.fecha_presentacion_oport_cand',
                'requerimientos.cand_presentados_puntual',
                'requerimientos.cand_presentados_no_puntual',
                'requerimientos.cand_contratados_puntual',
                'requerimientos.cand_contratados_no_puntual',
                DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                DB::raw(' round(((select count(*) from procesos_candidato_req
where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')

            )
->groupBy('requerimientos.id')
->orderBy('requerimiento_id','desc');
}
//dd($data->toSql());
    if ($request['formato'] and ($formato == "xlsx" || $formato == "pdf")) {

            $data = $data->get();
    }else{
        $data = $data->paginate(5);
    }
}        
      return $data;

    }


    private function getDataDetalleDiario($request)
    {

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_final  = $request['fecha_final'];
        $cliente_id   = $request['cliente_id'];
        $criterio     = $request['criterio'];
        $num_req      = '';
        $formato      = ($request['formato'])? $request['formato'] : 'html';

        $area1='';
        if(isset($request['area_id'])){
            $area1=$request['area_id'];
        }
         if(isset($request['num_req'])){
            $num_req=$request['num_req'];
        }
        //dd($formato);
        // Data

        if ($fecha_inicio != '' || $fecha_final != '' || $cliente_id != '' || $criterio!= '' || $area1!='' || $num_req!=''){
        //$data = DB::table('requerimientos')
            if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co"){
            $data=Requerimiento::join(
            'tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
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
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio) {

                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }

                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                }
                switch ($criterio) {
                    case 1: //Req abiertas
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),

                        ]);
                        break;
                    case 2: //CERRADAS OPORTUNAMENTE
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->whereRaw("requerimientos_estados.fecha_ultimo_estado<=requerimientos.fecha_terminacion");
                        break;
                    case 3: //requi contratadas
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->Orwhere("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'));
                        break;
                    case 4: //requi canceladas
                       $sql->whereIn("requerimientos_estados.max_estado",[2,1,19,22]);
                    break ;   
                    default:
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            22,
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                            config('conf_aplicacion.C_CLIENTE'),
                            2,
                        ]);
                }
            })
            ->select(
                'requerimientos.id as requerimiento_id',
                DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                'ciudad.agencia as agencia ',
                'ciudad.nombre as ciudad_req',
                'departamentos.nombre as departamento',
                'paises.nombre as pais',
                'clientes.nombre as cliente',
                'tipos_contratos.descripcion as tipo_contrato',
                'cargos_genericos.descripcion as cargo_generico',
                'cargos_especificos.descripcion as cargo_cliente',
                'requerimientos.num_vacantes as vacantes_solicitadas',
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),

                //metodo para dias_vencidos
                DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1) IS NULL
                       THEN datediff(now(),requerimientos.fecha_ingreso)
                        ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
//-------------------------------------------------------------------------------------
                DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                
                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').')
                 order by created_at desc limit 1) as fecha_cierre_req'),

                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in (2,22,'.config('conf_aplicacion.C_CLIENTE'). ')
                 order by created_at desc limit 1) as fecha_cancelacion_req'),

                DB::raw('upper(users.name) as usuario_cargo_req'),
                DB::raw('(select upper(p.name)  
                    from role_users o 
                    left join users p on o.user_id=p.id 
                    left join users_x_clientes ux on p.id=ux.user_id
                    left join clientes cli on ux.cliente_id=cli.id
                    left join negocio neg on cli.id=neg.cliente_id
                    left join requerimientos req on neg.id=req.negocio_id
                    left join estados_requerimiento er on er.req_id=req.id

                    where req.id=requerimiento_id and
                    o.role_id = 17 and
                    er.user_gestion=p.id 

                    order by o.created_at desc limit 1) as usuario_gestiono_req'),
                DB::raw('case requerimientos_estados.max_estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),
                DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                'requerimientos.fecha_presentacion_oport_cand',
                'requerimientos.cand_presentados_puntual',
                'requerimientos.cand_presentados_no_puntual',
                'requerimientos.cand_contratados_puntual',
                'requerimientos.cand_contratados_no_puntual',
                DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                DB::raw(' round(((select count(*) from procesos_candidato_req
where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')

            )
->groupBy('requerimientos.id')
->orderBy('requerimiento_id','desc');

//dd($data->toSql());
        if ($request['formato'] and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
        } else {
            $data = $data->paginate(5);
        }
    }
    // SOLO PARA KOMATSU
    else{
            $area=$request->area_id;
            $num_req=$request->num_req;
            $data=Requerimiento::join(
            'tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
            ->join('solicitudes', 'requerimientos.solicitud_id', '=', 'solicitudes.id')
            ->join('solicitud_sedes', 'solicitudes.ciudad_id', '=', 'solicitud_sedes.id')
            ->join('solicitud_area_funciones', 'solicitudes.area_id', '=', 'solicitud_area_funciones.id')
            ->join('solicitud_sub_area', 'solicitudes.subarea_id', '=', 'solicitud_sub_area.id')
            ->join('solicitud_user_paso', 'solicitudes.user_id', '=', 'solicitud_user_paso.user_solicitante')
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
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$area,$num_req) {
                
                if($num_req!= "") {
                    $sql->where("requerimientos.id", $num_req);
                }

                if($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
                if($area!= "") {
                   $sql->where("solicitudes.area_id", $area);
               }
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                }
                switch ($criterio) {
                    case 1: //Req abiertas
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),

                        ]);
                        break;
                    case 2: //CERRADAS OPORTUNAMENTE
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->whereRaw("requerimientos_estados.fecha_ultimo_estado<=requerimientos.fecha_terminacion");
                        break;
                    case 3: //requi contratadas
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->Orwhere("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'));
                        break;
                    case 4: //requi canceladas
                       $sql->whereIn("requerimientos_estados.max_estado",[2,1,19,22]);
                    break ;   
                    default:
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            22,
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                            config('conf_aplicacion.C_CLIENTE'),
                            2,
                        ]);
                }
            })
            ->select(
                'requerimientos.id as requerimiento_id',
                'requerimientos.fecha_tentativa_cierre_req as fecha_cierre',
                'cargos_especificos.plazo_req as ans',
                DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                'solicitud_sedes.descripcion as sede',
                'solicitud_area_funciones.descripcion as area',
                'solicitud_sub_area.descripcion as subarea',
                'solicitudes.created_at as fecha_solicitud',
                'solicitudes.responsable_hr as responsable',
                'ciudad.agencia as agencia ',
                'ciudad.nombre as ciudad_req',
                'departamentos.nombre as departamento',
                'paises.nombre as pais',
                 'solicitudes.funciones_realizar as justificacion',
                'clientes.nombre as cliente',
                'tipos_contratos.descripcion as tipo_contrato',
                'cargos_genericos.descripcion as cargo_generico',
                'cargos_especificos.descripcion as cargo_cliente',
                'requerimientos.num_vacantes as vacantes_solicitadas',
                DB::raw('(select name from users where id=solicitudes.user_id) as solicitante'),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Valorado') as fecha_valoracion"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Aprobacion 1') as fecha_jefe_ok"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Aprobacion 2') as fecha_gte_ok"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Aprobacion 3') as fecha_rrhh_ok"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Liberado') as fecha_liberacion"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Valorado') as fecha_valoracion"),
                 DB::raw('(select name from users y inner join solicitud_user_paso x on y.id=x.user_gerente_area where x.user_solicitante=solicitudes.user_id) as gerente_area'),
                 DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado='.config('conf_aplicacion.C_TERMINADO').') as fecha_terminacion'),
                 DB::raw('(select count(*) from requerimiento_cantidato,datos_basicos where requerimiento_cantidato.candidato_id=datos_basicos.user_id and requerimiento_cantidato.requerimiento_id=requerimientos.id and datos_basicos.trabaja=1) as postulantes_proceso_internos'),
                 DB::raw('(select count(*) from candidatos_otras_fuentes,datos_basicos where candidatos_otras_fuentes.cedula=datos_basicos.numero_id and candidatos_otras_fuentes.requerimiento_id=requerimientos.id and candidatos_otras_fuentes.status=1 and datos_basicos.trabaja=1) as postulantes_internos'),
                 DB::raw('(select count(*) from candidatos_otras_fuentes,datos_basicos where candidatos_otras_fuentes.cedula=datos_basicos.numero_id and candidatos_otras_fuentes.requerimiento_id=requerimientos.id and
                    candidatos_otras_fuentes.status=1 and datos_basicos.trabaja=0) as postulantes_externos'),
                 DB::raw('(select count(*) from requerimiento_cantidato,datos_basicos where requerimiento_cantidato.candidato_id=datos_basicos.user_id and requerimiento_cantidato.requerimiento_id=requerimientos.id and datos_basicos.trabaja=0) as postulantes_proceso_externos'),
                 DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id limit 1) as fecha_primero_pruebas'),
                  DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id and apto=1 order by id DESC limit 1) as fecha_ultimo_entrega_pruebas'),
                DB::raw('((select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id)-(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id and apto=1)) as cant_enviados_examenes'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id and apto=1) as cant_procesados_examenes'),
               
                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id limit 1) as fecha_primero_examenes'),
                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id and apto=1 order by id DESC limit 1) as fecha_ultimo_entrega_examenes'),
               
                DB::raw('((select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA\') and requerimiento_id=requerimientos.id )-(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA\') and requerimiento_id=requerimientos.id and apto=1)) as cant_enviados_entrevista'),
                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA\') and requerimiento_id=requerimientos.id limit 1) as fecha_entrevista'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA_TECNICA\') and requerimiento_id=requerimientos.id and apto=0) as cantidad_enviados_entrevista_tecnica'),
                DB::raw('((select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA_TECNICA\') and requerimiento_id=requerimientos.id)-(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA_TECNICA\') and requerimiento_id=requerimientos.id and apto=1)) as cant_enviados_entrevista_tecnica'),
                 DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA_TECNICA\') and requerimiento_id=requerimientos.id limit 1) as fecha_entrevista_tecnica'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id and apto=0) as cantidad_enviados_estudioSeg'),
                 DB::raw('((select count(*) from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id)- (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id and apto=1)) as cant_enviados_estudioSeg'),
                 DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id limit 1) as fecha_primero_estudio'),
                  DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id and apto=1 order by id DESC limit 1) as fecha_ultimo_entrega_estudio'),
                 DB::raw('((select count(*) from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id)-(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id and apto=1)) as cant_enviados_pruebas'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                 DB::raw('(select fecha_inicio_contrato from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ORDER BY procesos_candidato_req.id DESC limit 1) as fecha_ultima_contratacion'),
                  DB::raw('(select nombres from datos_basicos,procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and procesos_candidato_req.candidato_id=datos_basicos.user_id and procesos_candidato_req.requerimiento_id=requerimientos.id order by procesos_candidato_req.id DESC limit 1) as ultimo_contratado'),

                DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),
                //metodo para dias_vencidos
                DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1) IS NULL
                       THEN datediff(now(),requerimientos.fecha_ingreso)
                        ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
//-------------------------------------------------------------------------------------
                DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),

                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').')
                 order by created_at desc limit 1) as fecha_cierre_req'),

                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in (2,22,'.config('conf_aplicacion.C_CLIENTE'). ')
                 order by created_at desc limit 1) as fecha_cancelacion_req'),

                DB::raw('upper(users.name) as usuario_cargo_req'),
                DB::raw('(select upper(p.name)  
                    from role_users o 
                    left join users p on o.user_id=p.id 
                    left join users_x_clientes ux on p.id=ux.user_id
                    left join clientes cli on ux.cliente_id=cli.id
                    left join negocio neg on cli.id=neg.cliente_id
                    left join requerimientos req on neg.id=req.negocio_id

                    where req.id=requerimiento_id and
                    o.role_id = 17  
                    order by o.created_at desc limit 1) as usuario_gestiono_req'),
                DB::raw('case requerimientos_estados.max_estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),
                DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                'requerimientos.fecha_presentacion_oport_cand',
                'requerimientos.cand_presentados_puntual',
                'requerimientos.cand_presentados_no_puntual',
                'requerimientos.cand_contratados_puntual',
                'requerimientos.cand_contratados_no_puntual',
                DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                DB::raw(' round(((select count(*) from procesos_candidato_req
where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')

            )
->groupBy('requerimientos.id')
->orderBy('requerimiento_id','desc');

//dd($data->toSql());
    if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
    }else{
            $data = $data->paginate(5);
    }
    
    }
        return $data;

     }

    }

    private function getDataDetalleAnalistas($request)
    {

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_final  = $request['fecha_final'];
        $cliente_id   = $request['cliente_id'];
        $criterio     = $request['criterio'];
        $num_req      ='';
        $formato      = ($request->has('formato')) ? $request->formato : 'html';
        $area1='';
        if(isset($request['area_id'])){
            $area1=$request['area_id'];
        }
         if(isset($request['num_req'])){
            $num_req=$request['num_req'];
        }
        //dd($formato);
        // Data

        if ($fecha_inicio != '' || $fecha_final != '' || $cliente_id != '' || $criterio!= '' || $area1!='' || $num_req!=''){
        //$data = DB::table('requerimientos')
            if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co"){
            $data=Requerimiento::join(
            'tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
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
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio) {
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                }
                switch ($criterio) {
                    case 1: //Req abiertas
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),

                        ]);
                        break;
                    case 2: //CERRADAS OPORTUNAMENTE
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->whereRaw("requerimientos_estados.fecha_ultimo_estado<=requerimientos.fecha_terminacion");
                        break;
                    case 3: //requi contratadas
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->Orwhere("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'));
                        break;
                    case 4: //requi canceladas
                       $sql->whereIn("requerimientos_estados.max_estado",[2,1,19,22]);
                    break ;   
                    default:
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            22,
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                            config('conf_aplicacion.C_CLIENTE'),
                            2,
                        ]);
                }
            })
            ->select(
                'requerimientos.id as requerimiento_id',
                DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                'ciudad.agencia as agencia ',
                'ciudad.nombre as ciudad_req',
                'departamentos.nombre as departamento',
                'paises.nombre as pais',
                'clientes.nombre as cliente',
                'tipos_contratos.descripcion as tipo_contrato',
                'cargos_genericos.descripcion as cargo_generico',
                'cargos_especificos.descripcion as cargo_cliente',
                'requerimientos.num_vacantes as vacantes_solicitadas',
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),

                //metodo para dias_vencidos
                DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1) IS NULL
                       THEN datediff(now(),requerimientos.fecha_ingreso)
                        ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
//-------------------------------------------------------------------------------------
                DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). '  )
                 order by created_at desc limit 1) as fecha_cierre_req'),

                DB::raw('upper(users.name) as usuario_cargo_req'),
                DB::raw('(select upper(p.name)  
                    from role_users o 
                    left join users p on o.user_id=p.id 
                    left join users_x_clientes ux on p.id=ux.user_id
                    left join clientes cli on ux.cliente_id=cli.id
                    left join negocio neg on cli.id=neg.cliente_id
                    left join requerimientos req on neg.id=req.negocio_id
                    left join estados_requerimiento er on er.req_id=req.id

                    where req.id=requerimiento_id and
                    o.role_id = 17 and
                    er.user_gestion=p.id 

                    order by o.created_at desc limit 1) as usuario_gestiono_req'),
                DB::raw('case requerimientos_estados.max_estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),
                DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                'requerimientos.fecha_presentacion_oport_cand',
                'requerimientos.cand_presentados_puntual',
                'requerimientos.cand_presentados_no_puntual',
                'requerimientos.cand_contratados_puntual',
                'requerimientos.cand_contratados_no_puntual',
                DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                DB::raw(' round(((select count(*) from procesos_candidato_req
where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')

            )
->groupBy('requerimientos.id')
->orderBy('requerimiento_id','desc');

//dd($data->toSql());
        if ($request['formato'] and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
        } else {
            $data = $data->paginate(5);
        }
    }
    // SOLO PARA KOMATSU
    else{
              $area=$request->area_id;
              $num_req=$request->num_req;
            $data=Requerimiento::join(
            'tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimiento_cantidato', 'requerimientos.id', '=', 'requerimiento_cantidato.requerimiento_id')
             ->join('datos_basicos', 'requerimiento_cantidato.candidato_id', '=', 'datos_basicos.user_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
            ->join('solicitudes', 'requerimientos.solicitud_id', '=', 'solicitudes.id')
            ->join('solicitud_sedes', 'solicitudes.ciudad_id', '=', 'solicitud_sedes.id')
            ->join('solicitud_area_funciones', 'solicitudes.area_id', '=', 'solicitud_area_funciones.id')
            ->join('solicitud_sub_area', 'solicitudes.subarea_id', '=', 'solicitud_sub_area.id')
            ->join('solicitud_user_paso', 'solicitudes.user_id', '=', 'solicitud_user_paso.user_solicitante')

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
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$area,$num_req) {
                if ($num_req!= "") {
                            $sql->where("requerimientos.id", $num_req);
                    }
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
                if ($area!= "") {
                   $sql->where("solicitudes.area_id", $area);
               }
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                }
                switch ($criterio) {
                    case 1: //Req abiertas
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),

                        ]);
                        break;
                    case 2: //CERRADAS OPORTUNAMENTE
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->whereRaw("requerimientos_estados.fecha_ultimo_estado<=requerimientos.fecha_terminacion");
                        break;
                    case 3: //requi contratadas
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->Orwhere("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'));
                        break;
                    case 4: //requi canceladas
                       $sql->whereIn("requerimientos_estados.max_estado",[2,1,19,22]);
                    break ;   
                    default:
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            22,
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                            config('conf_aplicacion.C_CLIENTE'),
                            2,
                        ]);
                }
            })
            ->select(
                'requerimientos.id as requerimiento_id',
                'requerimientos.fecha_tentativa_cierre_req as fecha_cierre',
                'requerimiento_cantidato.id as req_cand',
                'datos_basicos.nombres as candidato',

                DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                'solicitud_sedes.descripcion as sede',
                'solicitud_area_funciones.descripcion as area',
                'solicitud_sub_area.descripcion as subarea',
                'solicitudes.created_at as fecha_solicitud',
                'solicitudes.responsable_hr as responsable',
                'ciudad.agencia as agencia ',
                'ciudad.nombre as ciudad_req',
                'departamentos.nombre as departamento',
                'paises.nombre as pais',
                 'solicitudes.funciones_realizar as justificacion',
                'clientes.nombre as cliente',
                'tipos_contratos.descripcion as tipo_contrato',
                'cargos_genericos.descripcion as cargo_generico',
                'cargos_especificos.descripcion as cargo_cliente',
                'requerimientos.num_vacantes as vacantes_solicitadas',
                DB::raw('(select name from users where users.id=datos_basicos.user_id) as nombre_candidato'),
                DB::raw('(select name from users where id=solicitudes.user_id) as solicitante'),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Valorado') as fecha_valoracion"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Aprobacion 1') as fecha_jefe_ok"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Aprobacion 2') as fecha_gte_ok"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Aprobacion 3') as fecha_rrhh_ok"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Liberado') as fecha_liberacion"),
                DB::raw("(select created_at from solicitudes_trazabilidad where solicitud_id=solicitudes.id and accion='Valorado') as fecha_valoracion"),
                 DB::raw('(select name from users y inner join solicitud_user_paso x on y.id=x.user_gerente_area where x.user_solicitante=solicitudes.user_id) as gerente_area'),
                 DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado='.config('conf_aplicacion.C_TERMINADO').') as fecha_terminacion'),
                 DB::raw('(select count(*) from requerimiento_cantidato,datos_basicos where requerimiento_cantidato.candidato_id=datos_basicos.user_id and requerimiento_cantidato.requerimiento_id=requerimientos.id and datos_basicos.trabaja=1) as postulantes_proceso_internos'),
                 DB::raw('(select count(*) from candidatos_otras_fuentes,datos_basicos where candidatos_otras_fuentes.cedula=datos_basicos.numero_id and candidatos_otras_fuentes.requerimiento_id=requerimientos.id and candidatos_otras_fuentes.status=1 and datos_basicos.trabaja=1) as postulantes_internos'),
                 DB::raw('(select count(*) from candidatos_otras_fuentes,datos_basicos where candidatos_otras_fuentes.cedula=datos_basicos.numero_id and candidatos_otras_fuentes.requerimiento_id=requerimientos.id and
                    candidatos_otras_fuentes.status=1 and datos_basicos.trabaja=0) as postulantes_externos'),
                 DB::raw('(select count(*) from requerimiento_cantidato,datos_basicos where requerimiento_cantidato.candidato_id=datos_basicos.user_id and requerimiento_cantidato.requerimiento_id=requerimientos.id and datos_basicos.trabaja=0) as postulantes_proceso_externos'),
                 DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id and procesos_candidato_req.candidato_id=datos_basicos.user_id limit 1) as fecha_primero_pruebas'),
                  DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id and apto=1 order by id DESC limit 1) as fecha_ultimo_entrega_pruebas'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id and apto=0) as cant_enviados_examenes'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id and apto=1 and procesos_candidato_req.candidato_id=datos_basicos.user_id) as listo_examenes'),
               
                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id limit 1) as fecha_primero_examenes'),
                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id and apto=1 order by id DESC limit 1) as fecha_ultimo_entrega_examenes'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA\') and requerimiento_id=requerimientos.id ) as cant_enviados_entrevista'),
                 DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA\') and requerimiento_id=requerimientos.id and apto=1 and procesos_candidato_req.candidato_id=datos_basicos.user_id) as listo_entrevista'),
                DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA\') and requerimiento_id=requerimientos.id limit 1) as fecha_entrevista'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA_TECNICA\') and requerimiento_id=requerimientos.id and apto=0) as cant_enviados_entrevista_tecnica'),
                 DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA_TECNICA\') and requerimiento_id=requerimientos.id and apto=1 and procesos_candidato_req.candidato_id=datos_basicos.user_id) as listo_entrevista_tecnica'),
                 DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_ENTREVISTA_TECNICA\') and requerimiento_id=requerimientos.id limit 1) as fecha_entrevista_tecnica'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id and apto=0) as cant_enviados_estudioSeg'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id and apto=1 and procesos_candidato_req.candidato_id=datos_basicos.user_id) as listo_documentos'),
                 DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id and apto=1) as cant_enviados_estudioSeg'),
                 DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id limit 1) as fecha_primero_estudio'),
                  DB::raw('(select created_at from procesos_candidato_req where proceso in(\'ENVIO_DOCUMENTOS\') and requerimiento_id=requerimientos.id and apto=1 order by id DESC limit 1) as fecha_ultimo_entrega_estudio'),
                 DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id and apto=0) as cant_enviados_pruebas'),
                 DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_PRUEBAS\') and requerimiento_id=requerimientos.id and apto=1 and procesos_candidato_req.candidato_id=datos_basicos.user_id) as listo_pruebas'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                 DB::raw('(select fecha_inicio_contrato from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ORDER BY procesos_candidato_req.id DESC limit 1) as fecha_ultima_contratacion'),
                  DB::raw('(select nombres from datos_basicos,procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and procesos_candidato_req.candidato_id=datos_basicos.user_id and procesos_candidato_req.requerimiento_id=requerimientos.id order by procesos_candidato_req.id DESC limit 1) as ultimo_contratado'),

                DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),

                //metodo para dias_vencidos
                DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1) IS NULL
                       THEN datediff(now(),requerimientos.fecha_ingreso)
                        ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
//-------------------------------------------------------------------------------------
                DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). '  )
                 order by created_at desc limit 1) as fecha_cierre_req'),

                DB::raw('upper(users.name) as usuario_cargo_req'),
                DB::raw('(select upper(p.name)  
                    from role_users o 
                    left join users p on o.user_id=p.id 
                    left join users_x_clientes ux on p.id=ux.user_id
                    left join clientes cli on ux.cliente_id=cli.id
                    left join negocio neg on cli.id=neg.cliente_id
                    left join requerimientos req on neg.id=req.negocio_id

                    where req.id=requerimiento_id and
                    o.role_id = 17  
                    order by o.created_at desc limit 1) as usuario_gestiono_req'),
                DB::raw('case requerimientos_estados.max_estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),
                DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                'requerimientos.fecha_presentacion_oport_cand',
                'requerimientos.cand_presentados_puntual',
                'requerimientos.cand_presentados_no_puntual',
                'requerimientos.cand_contratados_puntual',
                'requerimientos.cand_contratados_no_puntual',
                DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                DB::raw(' round(((select count(*) from procesos_candidato_req
where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')

            )
->groupBy('requerimiento_cantidato.id')
->orderBy('requerimiento_id','desc');

//dd($data->toSql());
        if ($request['formato'] and ($formato == "xlsx" || $formato == "pdf")) {
            $data = $data->get();
        } else {
            $data = $data->paginate(5);
        }
    }
        return $data;

     }

    }

    public function indicadores()
    {

        return view("admin.reportes.indicadores");
    }

    public function cierre_mensual(){
        return view("admin.reportes.indicadores_cierre_mensual");
    }

    public function distribucion_perfilamiento(Request $request){
        $fecha_inicio = $request->fecha_inicio;
        $fecha_final  = $request->fecha_final;


        $cargos=CargoGenerico::join("perfilamiento","cargos_genericos.id","=","perfilamiento.cargo_generico_id")
        ->where(function ($sql) use ($fecha_inicio, $fecha_final) {
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("perfilamiento.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }})
        ->whereRaw("perfilamiento.cargo_generico_id is not null")
        ->select("cargos_genericos.id","cargos_genericos.id as id_cargo","cargos_genericos.descripcion as cargo",DB::raw('(select count(perfilamiento.user_id) from perfilamiento where perfilamiento.cargo_generico_id=cargos_genericos.id) as cantidad'))
        ->groupBy("cargos_genericos.id")
        ->orderBy('cantidad','DESC')
        ->get();
        
        /*$cargos=Perfilamiento::join("cargos_genericos","cargos_genericos.id","=","perfilamiento.cargo_generico_id")
        ->where(function ($sql) use ($fecha_inicio, $fecha_final) {
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("perfilamiento.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }})
        ->whereRaw("perfilamiento.cargo_generico_id is not null")
        ->select("cargos_genericos.descripcion as cargo",DB::raw('(select count(perfilamiento.user_id) from perfilamiento where perfilamiento.cargo_generico_id=cargos_genericos.id) as cantidad'))
        ->groupBy("perfilamiento.cargo_generico_id")
        ->orderBy('cantidad','DESC')
        ->get();*/
        $total=$cargos->sum("cantidad");
        $otros=abs($total-$users=User::all()->count());

        return view("admin.reportes.distribucion_perfilamiento",compact("cargos","total","otros"));
    }

     public function distribucion_perfilamiento_excel(Request $request)
    {
        $user_sesion = $this->user;

        //dd($request->all());
        $headers = $this->getHeaderDetalleMine();
        //$data    = $this->getDataDetalleMine($request);
        $data    = $this->getDataDetalleDistribucionPerfilamiento($request);
        
       $sitio = Sitio::first();

        $funcionesGlobales = new FuncionesGlobales();

        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }


        Excel::create('reporte-excel-distribucion-perfilamiento', function ($excel) use ($data, $headers,$user_sesion,$sitio) {
            $excel->setTitle('Reporte distribucion perfilamiento');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte distribucion perfilamiento');
            $excel->sheet('Reporte Detalle Indicadores', function ($sheet) use ($data, $headers,$user_sesion,$sitio) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_mine', [
                    'data'    => $data,
                    'headerss' => $headers,
                    'user_sesion'=>$user_sesion,
                    'sitio'=>$sitio                    
                ]);
            });
        })->export("xlsx");
    }

    private function getDataDetalleDistribucionPerfilamiento($request)
    {
       //$formato = ($request['formato'])? $request['formato'] : 'html';
        //dd($request->all());

        if($request['fecha_inicio'] != '' || $request['fecha_final'] != '' || $request['cargo_id']!=''){
            

            /*$fecha_min = Carbon::now();
            $fecha_min->subMonths(2)->toDateString();

            $fecha_max = Carbon::now();
            $fecha_max->subMonths(5)->toDateString();*/
             $data=Perfilamiento::
                leftjoin("datos_basicos","datos_basicos.user_id","=","perfilamiento.user_id")
                
            ->leftjoin('paises', 'datos_basicos.pais_residencia', '=', 'paises.cod_pais')    
                ->leftjoin('ciudad',function($join){
                   $join->on('datos_basicos.ciudad_residencia', '=', 'ciudad.cod_ciudad')
                        ->on('datos_basicos.departamento_residencia', '=', 'ciudad.cod_departamento')
                        ->on('datos_basicos.pais_residencia', '=', 'ciudad.cod_pais');
                })
            ->leftjoin('departamentos', function ($join2){
                 $join2->on('datos_basicos.departamento_residencia', '=', 'departamentos.cod_departamento')
                       ->on('datos_basicos.pais_residencia', '=', 'departamentos.cod_pais'); 
                })
                ->leftjoin('generos','datos_basicos.genero','=','generos.id')
                ->leftjoin('entidades_eps','datos_basicos.entidad_eps','=','entidades_eps.id')
                ->leftjoin('aspiracion_salarial','datos_basicos.aspiracion_salarial','=','aspiracion_salarial.id')
                ->leftjoin('experiencias','datos_basicos.numero_id','=','experiencias.numero_id')
                ->leftjoin('estados','datos_basicos.estado_reclutamiento','=','estados.id')
                //->leftjoin('ciudad','ciudad.cod_ciudad','=','datos_basicos.ciudad_residencia')
                ->leftjoin('agencias','agencias.id','=','ciudad.agencia')
                //->leftjoin("perfilamiento","datos_basicos.user_id","=","perfilamiento.user_id")
                //->leftjoin("cargos_genericos","cargos_genericos.id","=","perfilamiento.cargo_generico_id")
                //->where("departamentos.cod_pais",170)
                ->where(function ($where) use ($request) {
                     
                   


                    if ($request['fecha_inicio'] != "" && $request['fecha_final'] != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(datos_basicos.created_at, \'%Y-%m-%d\')'),[$request['fecha_inicio'],$request['fecha_final']]);
                    }
                
                    
                    if($request["cargo_id"] != ""){

                     $where->where("perfilamiento.cargo_generico_id", $request["cargo_id"]);
                    }

                })
                //->where("datos_basicos.updated_at",'>',$fecha_min)
                //->where("ciudad.cod_pais",170)
                //->where('datos_basicos.created_at','>=',$fecha_max)
                ->select(
                    'ciudad.nombre as ciudad',
                    'datos_basicos.user_id as user_id',
                    'datos_basicos.fecha_nacimiento as fecha_nacimiento',
                    'datos_basicos.numero_id as cedula', 
                    'datos_basicos.nombres as nombres',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido',
                    'experiencias.cargo_especifico as cargo',
                    'experiencias.funciones_logros as funciones',
                    'datos_basicos.telefono_movil as celular',
                    'datos_basicos.telefono_fijo as fijo',
                    'datos_basicos.descrip_profesional as descripcion',
                    'datos_basicos.email as email',
                    'datos_basicos.contacto_externo as fuente_reclu',
                    'entidades_eps.descripcion as eps_cand',
                    'estados.descripcion as estado_candidato',
                    //DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                    DB::raw('( count(experiencias.numero_id)) as experiencias'),
                    DB::raw('(select count(estudios.numero_id)
                        from estudios
                        where estudios.numero_id = datos_basicos.numero_id       
                    )    as estudios'),
                    DB::raw('(select count(grupos_familiares.user_id)
                        from grupos_familiares
                        where grupos_familiares.numero_id = datos_basicos.numero_id       
                    )    as grupos_familiares'),
                    DB::raw('(select count(referencias_personales.numero_id)
                        from referencias_personales
                        where referencias_personales.numero_id = datos_basicos.numero_id      
                    )    as referencias_personales'),
                    DB::raw('(select (datos_basicos.datos_basicos_count *0.3)+(datos_basicos.perfilamiento_count * 0.1)) as hv_count')
                    //DB::raw('DATE_FORMAT(datos_basicos.updated_at, \'%Y-%m-%d\') as fecha_actualizacion')
                )
                ->groupBy("perfilamiento.id");

           
                $data = $data->get();
             
              
            return $data;
        }
    }


    public function reportesSeguimiento(Request $request){
        $areas=array();
        $sitio = Sitio::first();
        $clientes  =Clientes::orderby('nombre')->pluck("clientes.nombre", "clientes.id")
        ->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }

        $agencias=Agencia::pluck("agencias.descripcion", "agencias.id")->toArray();

        if(route("home")=="http://vym.t3rsc.co" || route("home")=="https://vym.t3rsc.co" || route("home")=="http://listos.t3rsc.co" || route("home")=="https://listos.t3rsc.co"){
             $agencias=Agencia::pluck("agencias.descripcion","agencias.id")->toArray();
        }

        if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co"){
           $areas=["" => "Seleccionar"] + SolicitudAreaFuncional::where("estado", 1)->pluck("descripcion", "id")->toArray();
        }

        if(route("home")=="https://gpc.t3rsc.co"){
              $usuarios=User::join('estados_requerimiento','estados_requerimiento.user_gestion','=','users.id')
            ->pluck("users.name", "users.id")->toArray();
        }
        else{
              $usuarios=User::join("role_users","users.id","=","role_users.user_id")
              ->join("roles", "roles.id", "=", "role_users.role_id")
        ->whereIn("roles.codigo", "SEL")
        ->pluck("users.name", "users.id")->toArray();
        }

        $empresas = null;
        if($sitio->multiple_empresa_contrato) {
            $empresas = Collect(DB::table('empresa_logos')->select("nombre_empresa", "id")->get())->pluck("nombre_empresa", "id")->toArray();
        }
    
        $headers   = $this->getHeaderSeguimiento($sitio);
        $data      = $this->getDataSeguimiento($request);

          //reportes de requerimientos
        return view('admin.reportes.reporteseguimiento')->with([
            'areas'     => $areas,
            "agencias"  => $agencias,
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headers'   => $headers,
            'usuarios'  => $usuarios,
            'agencias'  => $agencias,
            'sitio'     => $sitio,
            'empresas'  => $empresas
        ]);
    }

    public function indicador_oportunidad_2(Request $request){

        $fecha_inicio = $request->fecha_inicio;
        $fecha_final  = $request->fecha_final;
      
       $requerimiento=null;
       $promedio=null;

        $mostrar=false;
        $report_cierre_temp=null;
        $report_cierre=null;

        if($fecha_inicio != '' || $fecha_final != ''){
            $mostrar=true;

            $data = Requerimiento::join(
                        'tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
                        ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
                        ->join('tipos_contratos', 'requerimientos.tipo_contrato_id', '=', 'tipos_contratos.id')
                        ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                        ->join("departamentos", function ($join) {
                          $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                          ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                        })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                        ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                        ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                        })
                        ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
                        ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
                        ->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
                        ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
                        ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
                        ->join("estados_requerimiento","estados_requerimiento.req_id","=","requerimientos.id")
                         ->where("estados_requerimiento.estado",config('conf_aplicacion.C_TERMINADO'))
                        ->where(function ($sql) use ($fecha_inicio, $fecha_final, $request) {

                            if($fecha_inicio != "" && $fecha_final != ""){

                             $sql->whereBetween("estados_requerimiento.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                            }

                        })
                        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')

                        ->select(
                            'requerimientos.id as requerimiento_id',
                            DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                            'ciudad.agencia as agencia ',
                            'ciudad.nombre as ciudad_req',
                            'departamentos.nombre as departamento',
                            'paises.nombre as pais',
                            'clientes.nombre as cliente',
                            'tipos_contratos.descripcion as tipo_contrato',
                            'cargos_genericos.descripcion as cargo_generico',
                            'cargos_especificos.descripcion as cargo_cliente',
                            'cargos_especificos.plazo_req as tipo_cargo',
                            'requerimientos.num_vacantes as vacantes_solicitadas',
                           
                            'requerimientos.created_at as fecha_creacion',
                             'requerimientos.tipo_contrato_id as contrato',
                             'requerimientos.fecha_plazo_req as fecha_plazo',
                             DB::raw('(select count(*) from requerimientos) as num_reque'),
                            
                            /*DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
                            DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),*/
                            DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                            DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                            DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),

                            //metodo para dias_vencidos
                            DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                                order by created_at desc limit 1) IS NULL
                                   THEN datediff(now(),requerimientos.fecha_ingreso)
                                    ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                                order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
            //-------------------------------------------------------------------------------------
                            DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                            DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                            DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                            DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). '  )
                             order by created_at desc limit 1) as fecha_cierre_req'),

                            DB::raw('upper(users.name) as usuario_cargo_req'),
                            /*DB::raw('((select upper(p.name)  
                                from role_users o 
                                left join users p on o.user_id=p.id 
                                left join users_x_clientes ux on p.id=ux.user_id
                                left join clientes cli on ux.cliente_id=cli.id
                                left join negocio neg on cli.id=neg.cliente_id
                                left join requerimientos req on neg.id=req.negocio_id
                                left join estados_requerimiento er on er.req_id=req.id

                                where req.id=requerimiento_id and
                                o.role_id=17 and
                                er.user_gestion=p.id 

                                order by o.created_at desc limit 1)) as usuario_gestiono_req'),*/
                            DB::raw('case requerimientos_estados.max_estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),
                            DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                            'requerimientos.fecha_presentacion_oport_cand',
                            'requerimientos.cand_presentados_puntual',
                            'requerimientos.cand_presentados_no_puntual',
                            'requerimientos.cand_contratados_puntual',
                            'requerimientos.cand_contratados_no_puntual',
                             DB::raw('(select estado from estados_requerimiento where req_id=requerimientos.id order by estados_requerimiento.id desc limit 1) as estado_requerimiento'),
                             DB::raw('(select DATE_FORMAT(created_at, \'%Y-%m-%d\') from estados_requerimiento where req_id=requerimientos.id order by estados_requerimiento.id desc limit 1) as fecha_estado'))
            ->groupBy('requerimientos.id')
            ->orderBy('requerimientos.id','desc')
            ->get();

            //dd($data);
            $requerimiento_temp=array("DIRECTIVOS"=>["TOTAL"=>0,"TARDIOS"=>0,"DIAS"=>0],"OPERARIOS"=>["TOTAL"=>0,"TARDIOS"=>0,"DIAS"=>0],"ADMINISTRATIVOS"=>["TOTAL"=>0,"TARDIOS"=>0,"DIAS"=>0],"MANDOS MEDIOS"=>["TOTAL"=>0,"TARDIOS"=>0,"DIAS"=>0]);

            $requerimiento_fijos=array("DIRECTIVOS"=>["TOTAL"=>0,"TARDIOS"=>0,"DIAS"=>0],"OPERARIOS"=>["TOTAL"=>0,"TARDIOS"=>0,"DIAS"=>0],"ADMINISTRATIVOS"=>["TOTAL"=>0,"TARDIOS"=>0,"DIAS"=>0],"MANDOS MEDIOS"=>["TOTAL"=>0,"TARDIOS"=>0,"DIAS"=>0]);


            foreach($data as $req){
//dd($req->contrato);
               if($req->tipo_cargo==62){
                 if($req->contrato==7){
                //     report_cierre_temp
                    if($req->estado_requerimiento==16){
                            $requerimiento_temp["DIRECTIVOS"]["TOTAL"]++;

                        $total_req++;
                        
                        $fecha1=new DateTime($req->fecha_creacion);
                           $fecha2=new DateTime($req->fecha_estado);
                           $diff = $fecha1->diff($fecha2);
                           $requerimiento_temp["DIRECTIVOS"]["DIAS"]+= $diff->days;
                           $intervalo="P".$req->tipo_cargo."D";
                          
                          $fecha1->add(new DateInterval($intervalo));
                          $fecha1=strtotime($req->fecha_estado);
                            $fecha2=strtotime($req->fecha_plazo);
                        if($fecha2<$fecha1){
                            $requerimiento_temp["DIRECTIVOS"]["TARDIOS"]++;
                        }
                    }
                 }
                 else{
                   
                  if($req->estado_requerimiento==16){

                   $requerimiento_fijos["DIRECTIVOS"]["TOTAL"]++;
                   
                    $fecha1=new DateTime($req->fecha_creacion);
                    $fecha2=new DateTime($req->fecha_estado);
                    
                    $diff = $fecha1->diff($fecha2);
                    $requerimiento_fijos["DIRECTIVOS"]["DIAS"]+= $diff->days;
                    $intervalo="P".$req->tipo_cargo."D";
                          
                    $fecha1->add(new DateInterval($intervalo));
                    $fecha1=strtotime($req->fecha_estado);
                    
                    $fecha2=strtotime($req->fecha_plazo);
                     if($fecha2<$fecha1){
                      $requerimiento_fijos["DIRECTIVOS"]["TARDIOS"]++;
                      }
                  }                     
 
                 }
                    
                }
                elseif($req->tipo_cargo==36 ){

                    if($req->contrato==7){
                      if($req->estado_requerimiento==16){
                       
                        $requerimiento_temp["OPERARIOS"]["TOTAL"]++;
                       
                        $fecha1=new DateTime($req->fecha_creacion);
                           $fecha2=new DateTime($req->fecha_estado);
                           $diff = $fecha1->diff($fecha2);
                           $intervalo="P".$req->tipo_cargo."D";
                          
                        $fecha1->add(new DateInterval($intervalo));
                           $requerimiento_temp["OPERARIOS"]["DIAS"]+= $diff->days;
                           $fecha1=strtotime($req->fecha_estado);
                            $fecha2=strtotime($req->fecha_plazo);

                        if($fecha2<$fecha1){
                         $requerimiento_temp["OPERARIOS"]["TARDIOS"]++;
                        }
                       }
//dd($requerimiento_temp["OPERARIOS"]["TARDIOS"]);
                    }

                    else{
                       
                      if($req->estado_requerimiento==16){
                         $requerimiento_fijos["OPERARIOS"]["TOTAL"]++;
                         $fecha1=new DateTime($req->fecha_creacion);
                           $fecha2=new DateTime($req->fecha_estado);
                           $diff = $fecha1->diff($fecha2);
                           $requerimiento_fijos["OPERARIOS"]["DIAS"]+= $diff->days;
                           $intervalo="P".$req->tipo_cargo."D";
                          
                            $fecha1->add(new DateInterval($intervalo));
                            $fecha1=strtotime($req->fecha_estado);
                            $fecha2=strtotime($req->fecha_plazo);
                        if($fecha2<$fecha1){
                            $requerimiento_fijos["OPERARIOS"]["TARDIOS"]++;
                        }
                        }
                    }
                      
                }
                elseif($req->tipo_cargo==43){
                    if($req->contrato==7){
                    if($req->estado_requerimiento==16){
                        
                         $requerimiento_temp["ADMINISTRATIVOS"]["TOTAL"]++;
                        
                         $fecha1=new DateTime($req->fecha_creacion);
                           $fecha2=new DateTime($req->fecha_estado);
                           $diff = $fecha1->diff($fecha2);
                           $requerimiento_temp["ADMINISTRATIVOS"]["DIAS"]+= $diff->days;
                           $intervalo="P".$req->tipo_cargo."D";
                          
                            $fecha1->add(new DateInterval($intervalo));
                            $fecha1=strtotime($req->fecha_estado);
                            $fecha2=strtotime($req->fecha_plazo);
                        if($fecha2<$fecha1){
                            $requerimiento_temp["ADMINISTRATIVOS"]["TARDIOS"]++;
                        }
                    }
                    }
                    else{
                        
                    if($req->estado_requerimiento==16){
                         $requerimiento_fijos["ADMINISTRATIVOS"]["TOTAL"]++;
                         $fecha1=new DateTime($req->fecha_creacion);
                           $fecha2=new DateTime($req->fecha_estado);
                           $diff = $fecha1->diff($fecha2);
                           $requerimiento_fijos["ADMINISTRATIVOS"]["DIAS"]+= $diff->days;
                            $intervalo="P".$req->tipo_cargo."D";
                          
                            $fecha1->add(new DateInterval($intervalo));
                            $fecha1=strtotime($req->fecha_estado);
                            $fecha2=strtotime($req->fecha_plazo);
                        if($fecha2<$fecha1){
                            $requerimiento_fijos["ADMINISTRATIVOS"]["TARDIOS"]++;
                        }
                    }
                    }
                   
                }
                elseif($req->tipo_cargo==59){

                  if($req->contrato==7){

                    if($req->estado_requerimiento==16){

                        $requerimiento_temp["MANDOS MEDIOS"]["TOTAL"]++;

                         $fecha1=new DateTime($req->fecha_creacion);
                           $fecha2=new DateTime($req->fecha_estado);
                           $diff = $fecha1->diff($fecha2);
                           $requerimiento_temp["MANDOS MEDIOS"]["DIAS"]+= $diff->days;
                           $intervalo="P".$req->tipo_cargo."D";
                          
                            $fecha1->add(new DateInterval($intervalo));
                            $fecha1=strtotime($req->fecha_estado);
                            $fecha2=strtotime($req->fecha_plazo);
                            
                        if($fecha2<$fecha1){
                            $requerimiento_temp["MANDOS MEDIOS"]["TARDIOS"]++;
                        }
                     } 
                    }
                    else{
                        
                    if($req->estado_requerimiento==16){
                         $requerimiento_fijos["MANDOS MEDIOS"]["TOTAL"]++;
                         $fecha1=new DateTime($req->fecha_creacion);
                           $fecha2=new DateTime($req->fecha_estado);
                           $diff = $fecha1->diff($fecha2);
                           $requerimiento_fijos["MANDOS MEDIOS"]["DIAS"]+= $diff->days;
                           $intervalo="P".$req->tipo_cargo."D";
                          
                            $fecha1->add(new DateInterval($intervalo));
                            $fecha1=strtotime($req->fecha_estado);
                            $fecha2=strtotime($req->fecha_plazo);
                        if($fecha2<$fecha1){
                            $requerimiento_fijos["MANDOS MEDIOS"]["TARDIOS"]++;
                        }
                    } 
                    }
                }

        }

        //dd($requerimiento_fijos);

        //promedio para temporales

        $promedio=array("DIRECTIVOS"=>100,"OPERARIOS"=>100,"ADMINISTRATIVOS"=>100,"MANDOS MEDIOS"=>100);
        $prometios_totales_temp=array("DIRECTIVOS"=>0,"OPERARIOS"=>0,"ADMINISTRATIVOS"=>0,"MANDOS MEDIOS"=>0);
        if($requerimiento_temp["DIRECTIVOS"]["TOTAL"]!=0){
            $promedio["DIRECTIVOS"]=100-($requerimiento_temp["DIRECTIVOS"]["TARDIOS"]*100/$requerimiento_temp["DIRECTIVOS"]["TOTAL"]);
            $requerimiento_temp["DIRECTIVOS"]["DIAS"]=round($requerimiento_temp["DIRECTIVOS"]["DIAS"]/$requerimiento_temp["DIRECTIVOS"]["TOTAL"],2);
        }
         if($requerimiento_temp["OPERARIOS"]["TOTAL"]!=0){
            $promedio["OPERARIOS"]=100-($requerimiento_temp["OPERARIOS"]["TARDIOS"]*100/$requerimiento_temp["OPERARIOS"]["TOTAL"]);
            $requerimiento_temp["OPERARIOS"]["DIAS"]=round($requerimiento_temp["OPERARIOS"]["DIAS"]/$requerimiento_temp["OPERARIOS"]["TOTAL"],2);
        }
         if($requerimiento_temp["ADMINISTRATIVOS"]["TOTAL"]!=0){
            $promedio["ADMINISTRATIVOS"]=100-($requerimiento_temp["ADMINISTRATIVOS"]["TARDIOS"]*100/$requerimiento_temp["ADMINISTRATIVOS"]["TOTAL"]);
            $requerimiento_temp["ADMINISTRATIVOS"]["DIAS"]=round($requerimiento_temp["ADMINISTRATIVOS"]["DIAS"]/$requerimiento_temp["ADMINISTRATIVOS"]["TOTAL"],2);
        }
         if($requerimiento_temp["MANDOS MEDIOS"]["TOTAL"]!=0){
            $promedio["MANDOS MEDIOS"]=100-($requerimiento_temp["MANDOS MEDIOS"]["TARDIOS"]*100/$requerimiento_temp["MANDOS MEDIOS"]["TOTAL"]);
            $requerimiento_temp["MANDOS MEDIOS"]["DIAS"]=round($requerimiento_temp["MANDOS MEDIOS"]["DIAS"]/$requerimiento_temp["MANDOS MEDIOS"]["TOTAL"],2);
        }

         $suma=$requerimiento_temp["DIRECTIVOS"]["TOTAL"]+$requerimiento_temp["OPERARIOS"]["TOTAL"]+$requerimiento_temp["MANDOS MEDIOS"]["TOTAL"]+$requerimiento_temp["ADMINISTRATIVOS"]["TOTAL"];

         if($suma>0){

            $prometios_totales_temp["DIRECTIVOS"]=100-($requerimiento_temp["DIRECTIVOS"]["TARDIOS"]*100/$suma);
            //dd($prometios_totales_temp["DIRECTIVOS"]);
            $prometios_totales_temp["OPERARIOS"]=100-($requerimiento_temp["OPERARIOS"]["TARDIOS"]*100/$suma);
            $prometios_totales_temp["ADMINISTRATIVOS"]=100-($requerimiento_temp["ADMINISTRATIVOS"]["TARDIOS"]*100/$suma);
            $prometios_totales_temp["MANDOS MEDIOS"]=100-($requerimiento_temp["MANDOS MEDIOS"]["TARDIOS"]*100/$suma);

         }

         //promedio para fijos

         $promedio_fijos=array("DIRECTIVOS"=>100,"OPERARIOS"=>100,"ADMINISTRATIVOS"=>100,"MANDOS MEDIOS"=>100);

         $prometios_totales_fijos=array("DIRECTIVOS"=>0,"OPERARIOS"=>0,"ADMINISTRATIVOS"=>0,"MANDOS MEDIOS"=>0);
         
         if($requerimiento_fijos["DIRECTIVOS"]["TOTAL"]!=0){
            $promedio_fijos["DIRECTIVOS"]=100-($requerimiento_fijos["DIRECTIVOS"]["TARDIOS"]*100/$requerimiento_fijos["DIRECTIVOS"]["TOTAL"]);
            $requerimiento_fijos["DIRECTIVOS"]["DIAS"]=round($requerimiento_fijos["DIRECTIVOS"]["DIAS"]/$requerimiento_fijos["DIRECTIVOS"]["TOTAL"],2);
         }
        
         if($requerimiento_fijos["OPERARIOS"]["TOTAL"]!=0){
            $promedio_fijos["OPERARIOS"]=100-($requerimiento_fijos["OPERARIOS"]["TARDIOS"]*100/$requerimiento_fijos["OPERARIOS"]["TOTAL"]);
            $requerimiento_fijos["OPERARIOS"]["DIAS"]=round($requerimiento_fijos["OPERARIOS"]["DIAS"]/$requerimiento_fijos["OPERARIOS"]["TOTAL"],2);
         }

         if($requerimiento_fijos["ADMINISTRATIVOS"]["TOTAL"]!=0){
            $promedio_fijos["ADMINISTRATIVOS"]=100-($requerimiento_fijos["ADMINISTRATIVOS"]["TARDIOS"]*100/$requerimiento_fijos["ADMINISTRATIVOS"]["TOTAL"]);
            $requerimiento_fijos["ADMINISTRATIVOS"]["DIAS"]=round($requerimiento_fijos["ADMINISTRATIVOS"]["DIAS"]/$requerimiento_fijos["ADMINISTRATIVOS"]["TOTAL"],2);
        }
         if($requerimiento_fijos["MANDOS MEDIOS"]["TOTAL"]!=0){
            $promedio_fijos["MANDOS MEDIOS"]=100-($requerimiento_fijos["MANDOS MEDIOS"]["TARDIOS"]*100/$requerimiento_fijos["MANDOS MEDIOS"]["TOTAL"]);
            $requerimiento_fijos["MANDOS MEDIOS"]["DIAS"]=round($requerimiento_fijos["MANDOS MEDIOS"]["DIAS"]/$requerimiento_fijos["MANDOS MEDIOS"]["TOTAL"],2);
        }
//dd($promedio_fijos);

         $suma2=$requerimiento_fijos["DIRECTIVOS"]["TOTAL"]+$requerimiento_fijos["OPERARIOS"]["TOTAL"]+$requerimiento_fijos["MANDOS MEDIOS"]["TOTAL"]+$requerimiento_fijos["ADMINISTRATIVOS"]["TOTAL"];
    
        if($suma2>0){

          $prometios_totales_fijos["DIRECTIVOS"]=round(100-($requerimiento_fijos["DIRECTIVOS"]["TARDIOS"]*100/$suma2));
            //dd($prometios_totales_fijos["DIRECTIVOS"]);
          $prometios_totales_fijos["OPERARIOS"]=round(100-($requerimiento_fijos["OPERARIOS"]["TARDIOS"]*100/$suma2));
            
          $prometios_totales_fijos["ADMINISTRATIVOS"]=round(100-($requerimiento_fijos["ADMINISTRATIVOS"]["TARDIOS"]*100/$suma2));
          
          $prometios_totales_fijos["MANDOS MEDIOS"]=round(100-($requerimiento_fijos["MANDOS MEDIOS"]["TARDIOS"]*100/$suma2));
        }

        //TARDIOS TARDIOS TARDIOS TEMP
        $tardios_temp= $requerimiento_temp["DIRECTIVOS"]["TARDIOS"] + $requerimiento_temp["OPERARIOS"]["TARDIOS"] + $requerimiento_temp["ADMINISTRATIVOS"]["TARDIOS"] + $requerimiento_temp["MANDOS MEDIOS"]["TARDIOS"];

       // dd($tardios_temp);
        //TARDIOS TARDIOS TARDIOS
        $resto_temp= $suma - $tardios_temp;
//dd($tardios_temp);
        if($suma > 0){

         //$resto_temp= round(($resto_temp * 100)/$suma);
         //$tardios_temp = round(($tardios_temp * 100)/$suma);

        }else{

         $tardios_temp = 0;
         $resto_temp = 100;
        }
       // dd($resto_temp.'______'.$tardios_temp);

        $report_cierre = 'reporte_cierre';
        $indi5 = \Lava::DataTable();
        $indi5->addStringColumn('Cierre')
              ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
       // $indi5->addRow(["Directivos",  $prometios_totales_fijos["DIRECTIVOS"]]);
       // $indi5->addRow(["Operarios",  $prometios_totales_fijos["OPERARIOS"]]);
       //  $indi5->addRow(["Admin", $prometios_totales_fijos["ADMINISTRATIVOS"]]);
       //   $indi5->addRow(["Mandos Med", $prometios_totales_fijos["MANDOS MEDIOS"]]);
       
       $indi5->addRow(["Total Oportunos",(int)$resto_temp]);
       $indi5->addRow(["Total No Oportunos",(int)$tardios_temp]);

       //dd($tardios_temp.'____'.$resto_temp);

        \Lava::PieChart($report_cierre, $indi5, [
            'title' => 'Indicador oportunidad Temporales',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '100%',
                'height' => '350'
            ],
            
        ]);


        $report_barras = 'reporte_barras';
        $indi7 = \Lava::DataTable();
        $indi7->addStringColumn('Barras')
                ->addNumberColumn('Promedio Dias')
                ->addNumberColumn('ANS');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
        $indi7->addRow(["Directivos",(int)$requerimiento_fijos["DIRECTIVOS"]["DIAS"],62]);
        $indi7->addRow(["Operarios",(int)$requerimiento_fijos["OPERARIOS"]["DIAS"],36]);
        $indi7->addRow(["Admin",(int)$requerimiento_fijos["ADMINISTRATIVOS"]["DIAS"],43]);
        $indi7->addRow(["Mandos Med",(int)$requerimiento_fijos["MANDOS MEDIOS"]["DIAS"],59]);

        \Lava::ColumnChart($report_barras, $indi7, [
            'title' => 'Indicador oportunidad Directos',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
              'left' => 80,
              'top' => 40,
              'width' => '40%',
              'height' => '150'
            ],
            
        ]);

       // dd($requerimiento_fijos["DIRECTIVOS"]["TARDIOS"].'__'. $requerimiento_fijos["OPERARIOS"]["TARDIOS"].'___'. $requerimiento_fijos["ADMINISTRATIVOS"]["TARDIOS"] .'__'. $requerimiento_fijos["MANDOS MEDIOS"]["TARDIOS"]);

        //TARDIOS TARDIOS TARDIOS DIRECTOS
        $tardios_fijos= $requerimiento_fijos["DIRECTIVOS"]["TARDIOS"] + $requerimiento_fijos["OPERARIOS"]["TARDIOS"] + $requerimiento_fijos["ADMINISTRATIVOS"]["TARDIOS"] + $requerimiento_fijos["MANDOS MEDIOS"]["TARDIOS"];


        $resto_fijos= $suma2 - $tardios_fijos;
         //dd($tardios_fijos);
       //dd($resto_fijos.'__'.$suma);
        if($suma2 >0){
        //TARDIOS TARDIOS TARDIOS
        // $resto_fijos = ($resto_fijos * 100)/$suma2;
        // $tardios_fijos = ($tardios_fijos * 100)/$suma2;

        }else{
          
          $tardios_fijos= 0;
          $resto_fijos = 100;
        }

         //dd($resto_fijos);
        $report_cierre_temp = 'reporte_cierre_temp';
        $indi6 = \Lava::DataTable();
        $indi6->addStringColumn('Cierre')
                ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];     
       
        //$indi6->addRow(["Directivos",  $prometios_totales_temp["DIRECTIVOS"]]);
        //$indi6->addRow(["Operarios",  $prometios_totales_temp["OPERARIOS"]]);
        // $indi6->addRow(["Admin", $prometios_totales_temp["ADMINISTRATIVOS"]]);
        //  $indi6->addRow(["Mandos Med", $prometios_totales_temp["MANDOS MEDIOS"]]);
        $indi6->addRow(["Total Oportunos", (int)$resto_fijos]);
        $indi6->addRow(["Total no Oportunos",(int) $tardios_fijos]);
        
        \Lava::PieChart($report_cierre_temp,$indi6, [
            'title' => 'Indicador Oportunidad Directos',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '100%',
                'height' => '350'
            ],
            
        ]);


        $reporte_barras_temp = 'reporte_barras_temp';
        $indi8 = \Lava::DataTable();
        $indi8->addStringColumn('Barras')
                ->addNumberColumn('Promedio Dias')
                ->addNumberColumn('ANS');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
        $indi8->addRow(["Directivos",(int)$requerimiento_temp["DIRECTIVOS"]["DIAS"],62]);
        $indi8->addRow(["Operarios",(int)$requerimiento_temp["OPERARIOS"]["DIAS"],36]);
        $indi8->addRow(["Admin",(int)$requerimiento_temp["ADMINISTRATIVOS"]["DIAS"],43]);
        $indi8->addRow(["Mandos Med",(int)$requerimiento_temp["MANDOS MEDIOS"]["DIAS"],59]);

        \Lava::ColumnChart($reporte_barras_temp, $indi8, [
            'title' => 'Indicador oportunidad Temporales',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
              'left' => 80,
              'top' => 40,
              'width' => '40%',
              'height' => '150'
            ],
            
        ]);

        }
       
        $tipo_chart  ='PieChart';
        
      return view("admin.reportes.indicadores_oportunidad_2",compact("data","requerimiento_temp",'requerimiento_fijos','promedio','promedio_fijos','mostrar',"report_cierre","tipo_chart","report_cierre_temp","report_barras","reporte_barras_temp"));
        
    }

    public function indicador_estado_req(Request $request)
    {

        $clientes = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

       // $cargos_especificos = ["" => "Seleccionar"] + CargoEspecifico::pluck("cargos_especificos.descripcion", "cargos_especificos.id")->toArray();

        $estados_requerimiento = ["" => "Seleccionar"] + Estados::whereNotIn('id',[1,2,13,14,16,17])
            ->pluck("estados.descripcion", "estados.id")->toArray();

        $tipo_chart  ='';
        $report_cierre_temp = '';
        $indicador = '';

        $fecha_inicio = $request->fecha_inicio;
        $fecha_final  = $request->fecha_final;
        $cliente_id  =  $request->cliente_id;
        $cargo_especifico_id  =  $request->cargo_especifico_id;
        $estado_id  =  $request->estado_id;
        //.......por ciudad.....................
        $ciudad_id  =  $request->ciudad_id;
        $pais_id  =  $request->pais_id;
        $departamento_id  =  $request->departamento_id;

        $mostrar  =  false;

        //indicador de estados de requerimientos
     if ($fecha_inicio != '' || $fecha_final != '' || $cliente_id != '' || $cargo_especifico_id!='' || $estado_id || $ciudad_id != ''){
     
        $indicador = EstadosRequerimientos::select('estados_requerimiento.estado')
                ->join('requerimientos', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->where(function($where)use($request){

                    if($request->fecha_inicio != "" && $request->fecha_final != ""){

                      $where->whereBetween("requerimientos.created_at", [$request->fecha_inicio . ' 00:00:00', $request->fecha_final . ' 23:59:59']);
                    }

                    if($request->cargo_especifico_id != ""){

                       $where->where("requerimientos.cargo_especifico_id", $request->cargo_especifico_id);
                    }

                    if($request->cliente_id != ""){

                       $where->where("negocio.cliente_id", $request->cliente_id);
                    }

                    if($request->estado_id != ""){

                       $where->where("estados_requerimiento.estado", $request->estado_id);
                    }

                    if($request->ciudad_id != ""){
                    $where->where("requerimientos.ciudad_id", $request->ciudad_id);
                    }

                    if($request->pais_id != ""){
                    $where->where("requerimientos.pais_id",$request->pais_id);
                    }
                            
                    if($request->departamento_id != ""){
                                //dd($request->departamento_id);
                    $where->where("requerimientos.departamento_id", $request->departamento_id);
                    }
                })
                ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
                ->whereNotIn("estados_requerimiento.estado", [1,2,13,14,17])
                ->selectRaw('count(*) as filas')
  //              ->selectRaw('sum(requerimientos.num_vacantes) AS vacantes')
                ->orderBy("estados_requerimiento.id", "desc")
                ->groupBy('estados_requerimiento.estado')->get();
                // ->where('requerimientos.solicitado_por',$this->user->id)
     //definir la variable
//dd($indicador->sum('vacantes'));
        $report_cierre_temp = 'reporte_estado_req';
        
        $indi7 = \Lava::DataTable();
        $indi7->addStringColumn('Cierre')
                ->addNumberColumn('Porcentaje');

        foreach($indicador as $value){
      // var_dump($value->filas);
         $nombre = $value->estadoRequerimiento_req();
         $fila = (int) $value->filas; //transformar en entero

          $indi7->addRow([$nombre,$fila]);
        }

       //$indi7->addRow(['uno',50]);
       //$indi7->addRow(['dos',30]);
       //$indi7->addRow(['tres',40]);

     //dd($indi7);
        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
       
        \Lava::PieChart($report_cierre_temp,$indi7, [
            'title' => 'Indicador Estados Requerimientos',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '100%',
                'height' => '350'
            ],
            
        ]);

//indicador de procesos de candidatos
       $indicador_c = RegistroProceso::select('procesos_candidato_req.proceso')
            ->selectRaw('count(*) as filas')
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos', 'requerimientos.id', '=', 'requerimiento_cantidato.requerimiento_id')
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->where(function($where)use($request){

                if($request->fecha_inicio != "" && $request->fecha_final != ""){

                  $where->whereBetween("procesos_candidato_req.created_at", [$request->fecha_inicio . ' 00:00:00', $request->fecha_final . ' 23:59:59']);
                }

                if($request->cargo_especifico_id != ""){

                    $where->where("requerimientos.cargo_especifico_id", $request->cargo_especifico_id);
                }

                if($request->cliente_id != "") {

                    $where->where("negocio.cliente_id", $request->cliente_id);
                }

                if($request->estado_id != "") {

                    $where->where("requerimiento_cantidato.estado_candidato", $request->estado_id);
                }
                })
            ->groupBy('procesos_candidato_req.proceso')->orderBy('procesos_candidato_req.id','ASC')->get();

    //dd($indicador_c);
    /*
        $indicador_c = ReqCandidato::select('requerimiento_cantidato.estado_candidato')
                 ->selectRaw('count(*) as filas')
                 ->join('requerimientos', 'requerimientos.id', '=', 'requerimiento_cantidato.requerimiento_id')
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                //->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
              //  ->where("requerimientos.solicitado_por", $this->user->id)
                ->where(function($where)use($request){

                    if($request->fecha_inicio != "" && $request->fecha_final != "") {

                      $where->whereBetween("requerimientos.created_at", [$request->fecha_inicio . ' 00:00:00', $request->fecha_final . ' 23:59:59']);
                    }

                    if($request->cargo_especifico_id != "") {

                       $where->where("requerimientos.cargo_especifico_id", $request->cargo_especifico_id);
                    }

                    if($request->cliente_id != "") {

                       $where->where("negocio.cliente_id", $request->cliente_id);
                    }

                    if($request->estado_id != "") {

                       $where->where("requerimiento_cantidato.estado_candidato", $request->estado_id);
                    }
                })
                ->selectRaw('requerimientos.num_vacantes AS vacantes')
                ->whereRaw('requerimiento_cantidato.id=(select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.requerimiento_id=requerimientos.id)')
                ->whereNotIn('requerimiento_cantidato.estado_candidato',[1,2,5,13,14,17])->groupBy('requerimiento_cantidato.estado_candidato')->orderBy('requerimiento_cantidato.estado_candidato')->get();
*/
            $indicador_activos = 0;
            $suma = 0;
//indicador de candidatos activo
    /*
          if($cliente_id == ''){

            $indicador_activos = DatosBasicos::select('datos_basicos.estado_reclutamiento')
                ->selectRaw('count(*) as suma')
                ->join('estados', 'estados.id', '=', 'datos_basicos.estado_reclutamiento')
                ->where(function($where)use($request){

                    if($request->fecha_inicio != "" && $request->fecha_final != ""){

                      $where->whereBetween("datos_basicos.created_at", [$request->fecha_inicio . ' 00:00:00', $request->fecha_final . ' 23:59:59']);
                    }
                })
                ->where('datos_basicos.estado_reclutamiento',5)
                ->selectRaw('estados.descripcion AS estado')
                ->groupBy('datos_basicos.estado_reclutamiento')->orderBy('datos_basicos.estado_reclutamiento')->first();
                
                $suma = (int)$indicador_activos->suma;
            
            }

            $vacntes_rest = Requerimiento::select('requerimientos.num_vacantes')
              ->join('estados_requerimiento','estados_requerimiento.req_id','=','requerimientos.id')
              ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
              ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
              ->where(function($where)use($request){

                    if($request->fecha_inicio != "" && $request->fecha_final != "") {

                      $where->whereBetween("requerimientos.created_at", [$request->fecha_inicio . ' 00:00:00', $request->fecha_final . ' 23:59:59']);
                    }

                    if($request->cargo_especifico_id != "") {

                       $where->where("requerimientos.cargo_especifico_id", $request->cargo_especifico_id);
                    }

                    if($request->cliente_id != "") {

                       $where->where("negocio.cliente_id", $request->cliente_id);
                    }

                    if($request->estado_id != "") {

                       $where->where("estados_requerimiento.estado", $request->estado_id);
                    }
                })
               //->selectRaw('sum(requerimientos.num_vacantes) AS vacantes')
               ->whereNotIn('estados_requerimiento.estado',[1,2,13,14,17])
                ->orderBy("requerimientos.id", "desc")
                ->groupBy('requerimientos.id')->get();

            $vc= $vacntes_rest->sum('num_vacantes');

            $vc = $vc - $indicador_c->count();
*/
           // dd($vc);

        $reporte_estado_cand = 'reporte_estado_cand';
        
        $indi8 = \Lava::DataTable();
        $indi8->addStringColumn('Cierre')
                ->addNumberColumn('Porcentaje');

        foreach($indicador_c as $value2) {
         if(!is_null($value2->proceso) && $value2->proceso !='ASIGNADO_REQUERIMIENTO'){
      // var_dump($value->filas);
          $nombre = $value2->proceso;
          $fila = (int) $value2->filas; //transformar en entero
          $indi8->addRow([$nombre,$fila]);
         }
        }
          //$indi8->addRow(['ACTIVOS',$suma]);
          //$indi8->addRow(['SIN PROCESAR',$vc]);

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];


        \Lava::PieChart($reporte_estado_cand,$indi8, [
            'title' => 'Indicador Estados Candidatos',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '100%',
                'height' => '350'
            ],
            
        ]);

        $tipo_chart  ='PieChart';

        $mostrar  =  true;
     }

      return view('admin.reportes.indicadores_estado_req',compact('indicador',"tipo_chart","mostrar","indicador_c","report_cierre_temp","reporte_estado_cand","clientes","estados_requerimiento",'suma'));
    }

    public function indicador_estado_candidato()
    {
        //indicador de estados de requerimientos

      $indicador = RegistroProceso::select('estado')
                 ->selectRaw('count(*) as filas')
                 ->where('user_gestion',$this->user->id)->whereNotIn('estado',[1,2,17])->groupBy('estado')->orderBy('estado')->get();

      return view('admin.reportes.indicadores_estado_req',compact('indicador'));
    }


    public function cargo_especifico_cliente(Request $request)
    {
        //indicador de estados de requerimientos
       $cargo_especifico = CargoEspecifico::where('clt_codigo',$request->clt_codigo)->pluck('descripcion','id')->toArray();
       
     //dd($cargo_especifico);
      return response()->json($cargo_especifico);

    }


    //METODOS PARA CIERRES MENSUALES

    public function cierre_mensual_eficacia(){

    $hoy=date("Y-m-d");
    $mes=date("Y-m");
    $y=date("Y");
    $inicio=$mes."-01";
    $mes_limpio=$mes=date("n");

      $estados=[
        config('conf_aplicacion.C_TERMINADO'),
        config('conf_aplicacion.C_RECLUTAMIENTO'),
        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
        config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
        config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
        config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),];
            
            
            $eficacia = DB::table('requerimientos')
            ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
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
            ->where("requerimientos.tipo_proceso_id",2)
            ->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[date("Y-m-d",strtotime($inicio."- 6 month")),$inicio])

            ->whereIn("estados_requerimiento.estado", $estados)
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            //->where('estados_requerimiento.user_gestion',$user_sesions->id)
            
            ->select(
                'requerimientos.id as requerimiento_id',
                DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                'ciudad.agencia as agencia ',
                'ciudad.nombre as ciudad_req',
                'departamentos.nombre as departamento',
                'paises.nombre as pais',
                'clientes.nombre as cliente',
                'cargos_genericos.descripcion as cargo_generico',
                'cargos_especificos.descripcion as cargo_cliente',
                'requerimientos.num_vacantes as vacantes_solicitadas',
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_EXAMENES\') and requerimiento_id=requerimientos.id ) as cant_enviados_examenes'),
                DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),

                //metodo para dias_vencidos
                DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_SOLUCIONES').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1) IS NULL
                       THEN datediff(now(),requerimientos.fecha_ingreso)
                        ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_SOLUCIONES').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                    order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
//-------------------------------------------------------------------------------------
                DB::raw('datediff(requerimientos.fecha_ingreso,requerimientos.created_at) as dias_gestion'),
                DB::raw('(select upper(x.descripcion) as estado from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id and estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id) limit 1 ) as estado_req'),
                DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                DB::raw('(select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ','.config('conf_aplicacion.C_SOLUCIONES').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). '  )
                 order by created_at desc limit 1) as fecha_cierre_req'),

                DB::raw('upper(users.name) as usuario_cargo_req'),
                DB::raw('(select upper(p.name)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id and o.estado = ' . config('conf_aplicacion.C_EN_PROCESO_SELECCION') . ' order by o.created_at desc limit 1) as usuario_gestiono_req'),
                /*DB::raw('case requerimientos_estados.max_estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),
                DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),*/
                'requerimientos.fecha_presentacion_oport_cand',
                'requerimientos.cand_presentados_puntual',
                'requerimientos.cand_presentados_no_puntual',
                'requerimientos.cand_contratados_puntual',
                'requerimientos.cand_contratados_no_puntual',
                DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                DB::raw(' round(((select count(*) from procesos_candidato_req
where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')

            )
/*->whereIn("requerimientos_estados.max_estado", [
                            22,
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                            config('conf_aplicacion.C_CLIENTE'),
                            config('conf_aplicacion.C_SOLUCIONES'),

                        ])*/
            ->groupBy('requerimientos.id')
            ->get();

            //dd($eficacia);
            if($eficacia==null){
                $datos=false;
            }
            
      $eficacia1 = [];

             $numero_contratados = 0;
             $numero_vacantes = 0;
                           
            foreach ($eficacia  as $key => $efi) {
              $numero_contratados +=(int)$efi->cant_enviados_contratacion;
              $numero_vacantes +=(int)$efi->vacantes_solicitadas;
            }

              if($numero_vacantes <= 0){
            $numero_vacantes = 1;
        }
          
          $avg_eficacia  = round(($numero_contratados/$numero_vacantes)*100); 
          
          $avg_eficacia_no = 100-$avg_eficacia;
          $eficacia1=[
            "total_contratados"=>$numero_contratados,
            "total_vacantes"=>$numero_vacantes,
            "avg_eficacia"=>$avg_eficacia];

        DB::table('cierres_mensuales')->insert(
            ['mes' => $mes_limpio, 'tipo_indicador' => 1,"total_contratados"=>$eficacia1['total_contratados'],"total_vacante"=>$eficacia1['total_vacantes'],"avg_eficacia"=>$eficacia1['avg_eficacia'],'ano'=>$y]);

        // Reporte eficacia
       /* $report_efi = 'reporte_eficacia';
        $indi5 = \Lava::DataTable();
        $indi5->addStringColumn('Eficacia')
                ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
         $indi5->addRow(["Eficacia", (int)$avg_eficacia]);
        $indi5->addRow(["Ineficacia", (int)($avg_eficacia_no)]);
        \Lava::PieChart($report_efi, $indi5, [
            'title' => 'Indicadores Eficacia',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '100%'
            ],
            'height' => '350'
        ]);

    
 
       return view("admin.reportes.indicadores_eficacia")->with([
                    'report_efi' => $report_efi,
                    'tipo_solicitud' =>    $tipo_solicitud,
                    'usuarios_gestionan' => $usuarios_gestionan,
                    "estados_requerimiento"=>$estados_requerimiento,
                    'tipo_chart'  => 'PieChart',
                    'eficacia1'   => $eficacia1,
                    'datos'=>$datos
                    
        ]);*/
         
    }

  public function cierre_mensual_cancelaciones(){

    $hoy=date("Y-m-d");
    $mes=date("Y-m");
    $y=date("Y");
    $inicio=$mes."-01";
    $mes_limpio=$mes=date("n");

            
            $reporte_candelados = DB::table('requerimientos')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            
            ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
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
           ->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[date("Y-m-d",strtotime($inicio."- 6 month")),$inicio])
            
            ->select(
                'requerimientos.id',
                    DB::raw('(select sum(requerimientos.num_vacantes) as cantidad from requerimientos where requerimientos_estados.max_estado = 2 and requerimientos_estados.req_id=requerimientos.id ) as cant_cancelados_temporizar'),
                     DB::raw('(select sum(requerimientos.num_vacantes) as cantidad from requerimientos where requerimientos_estados.max_estado = 1 and requerimientos_estados.req_id=requerimientos.id ) as cant_cancelados_cliente'),
                     //***************************** req3 ******
                      DB::raw('(select sum(requerimientos.num_vacantes) as cantidad from requerimientos where requerimientos_estados.max_estado = 22 and requerimientos_estados.req_id=requerimientos.id ) as cant_cancelados_no_efectiva') 
                )
            ->groupBy('requerimientos.id')
            ->get();
      $cancelados = [];

             $numero_cancelados_cliente = 0;
             $numero_cancelados_temporizar = 0;
             $numero_cancelados_no_efectiva = 0;
             $numero_req = count($reporte_candelados);
             
                           
                           foreach ($reporte_candelados  as $key => $cance) {
                               $numero_cancelados_cliente +=(int)$cance->cant_cancelados_cliente;
                               $numero_cancelados_temporizar +=(int)$cance->cant_cancelados_temporizar;
                               $numero_cancelados_no_efectiva +=(int)$cance->cant_cancelados_no_efectiva;
                           }
           
           if ($numero_req ==0) {
               $numero_req = 1;
           }
          $avg_cancelados_cliente  =    round(($numero_cancelados_cliente/$numero_req)*100);
          $avg_cancelados_temporizar  = round(($numero_cancelados_temporizar/$numero_req)*100);
          $avg_cancelados_no_efectiva  = round(($numero_cancelados_no_efectiva/$numero_req)*100);

          //dd($avg_cancelados_no_efectiva);

          
          $avg_restante = 100-($avg_cancelados_cliente+$avg_cancelados_temporizar+$avg_cancelados_no_efectiva);
          $cancelados=[
            "avg_cancelados_cliente"=>$avg_cancelados_cliente,
            "avg_cancelados_temporizar"=>$avg_cancelados_temporizar,
            "avg_cancelados_no_efectiva"=>$avg_cancelados_no_efectiva,
            "numero_cancelados_cliente"=>$numero_cancelados_cliente,
            "numero_cancelados_temporizar"=>$numero_cancelados_temporizar,
            "numero_cancelados_no_efectiva"=>$numero_cancelados_no_efectiva,
            "otros_estados"=>$numero_req];

        DB::table('cierres_mensuales')->insert(
            ['mes' => $mes_limpio, 'tipo_indicador' => 2,"numero_cancelados_cliente"=>$numero_cancelados_cliente,"numero_cancelados_temporizar"=>$numero_cancelados_temporizar,"numero_cancelados_no_efectivo"=>$numero_cancelados_no_efectiva,"avg_cancelados_cliente"=>$avg_cancelados_cliente,"avg_cancelados_temporizar"=>$avg_cancelados_temporizar,"avg_cancelados_no_efectivo"=>$avg_cancelados_no_efectiva,'ano'=>$y]);

        // Reporte eficacia
       /* $report_efi = 'reporte_eficacia';
        $indi5 = \Lava::DataTable();
        $indi5->addStringColumn('Eficacia')
                ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
         $indi5->addRow(["Eficacia", (int)$avg_eficacia]);
        $indi5->addRow(["Ineficacia", (int)($avg_eficacia_no)]);
        \Lava::PieChart($report_efi, $indi5, [
            'title' => 'Indicadores Eficacia',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '100%'
            ],
            'height' => '350'
        ]);

    
 
       return view("admin.reportes.indicadores_eficacia")->with([
                    'report_efi' => $report_efi,
                    'tipo_solicitud' =>    $tipo_solicitud,
                    'usuarios_gestionan' => $usuarios_gestionan,
                    "estados_requerimiento"=>$estados_requerimiento,
                    'tipo_chart'  => 'PieChart',
                    'eficacia1'   => $eficacia1,
                    'datos'=>$datos
                    
        ]);*/
         
    }

  public function cierre_mensual_eficacia_llamada(){

    $hoy=date("Y-m-d");
    $mes=date("Y-m");
    $y=date("Y");
    $inicio=$mes."-01";
    $mes_limpio=$mes=date("n");

      
      $eficacia = DB::table('requerimientos')
            ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
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
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            //->whereRaw('requerimientos.id not in (select req_id  from requerimientos_estados where max_estado in (2,1,16)) ')
            
            //->where('estados_requerimiento.user_gestion',$user_sesion->id)
            ->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[date("Y-m-d",strtotime($inicio."- 6 month")),$inicio])
            ->select(
                'requerimientos.id',
                DB::raw('(select count(c.id) as cantidad from carga_scanner c 
                    left join datos_basicos r on c.user_carga=r.user_id
                    left join requerimiento_cantidato re on r.user_id=re.candidato_id
                    where    
                    re.requerimiento_id=requerimientos.id and re.estado_candidato <> 14  ) as cant_asistieron'),
                 
                 DB::raw('(select count(*) as cantidad from procesos_candidato_req rec 
                            inner join requerimientos req on rec.requerimiento_id=req.id
                            inner join negocio n on req.negocio_id=n.id
                            inner join clientes cli on n.cliente_id=cli.id 
                            where rec.requerimiento_id = requerimientos.id
                            and 
                            proceso in("ENVIO_APROBAR_CLIENTE","ENVIO_CONTRATACION") 

                             and
                             rec.estado in(8,11)
                             and cli.id in (129,140)
                             )as cantidad_mon'),
                   
                    DB::raw('(select count(*) as cantidad from requerimiento_cantidato where requerimiento_id=requerimientos.id) as cant_reclu'))
            ->groupBy('requerimientos.id')
            ->get();
            //dd($eficacia);
      $eficacia_llamada = [];

             $numero_asistieron = 0;
             $numero_reclu = 0;
                           
                  foreach ($eficacia  as $key => $efi) {
                    
                    $numero_asistieron +=(int)$efi->cant_asistieron;
                    $numero_asistieron +=(int)$efi->cantidad_mon;
                    $numero_reclu +=(int)$efi->cant_reclu;
                 }

              if($numero_reclu <= 0){
            $numero_reclu = 1;
        }
          
          $avg_eficacia  = round((($numero_asistieron/$numero_reclu))*100); 
          //dd($avg_eficacia);
          $avg_eficacia_no = 100-$avg_eficacia;
          $eficacia1=[
            "total_asistieron"=>$numero_asistieron,
            "total_reclu"=>$numero_reclu,
            "avg_eficacia"=>$avg_eficacia];

        DB::table('cierres_mensuales')->insert(
            ['mes' => $mes_limpio, 'tipo_indicador' => 3,"numero_asistieron"=>$numero_asistieron,"numero_reclutamiento"=>$numero_reclu,"avg_eficacia_llamada"=>$avg_eficacia,"ano"=>$y]);

        // Reporte eficacia
       /* $report_efi = 'reporte_eficacia';
        $indi5 = \Lava::DataTable();
        $indi5->addStringColumn('Eficacia')
                ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
         $indi5->addRow(["Eficacia", (int)$avg_eficacia]);
        $indi5->addRow(["Ineficacia", (int)($avg_eficacia_no)]);
        \Lava::PieChart($report_efi, $indi5, [
            'title' => 'Indicadores Eficacia',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '100%'
            ],
            'height' => '350'
        ]);

    
 
       return view("admin.reportes.indicadores_eficacia")->with([
                    'report_efi' => $report_efi,
                    'tipo_solicitud' =>    $tipo_solicitud,
                    'usuarios_gestionan' => $usuarios_gestionan,
                    "estados_requerimiento"=>$estados_requerimiento,
                    'tipo_chart'  => 'PieChart',
                    'eficacia1'   => $eficacia1,
                    'datos'=>$datos
                    
        ]);*/
         
    }

    public function cierres_mensuales(Request $request){

        $ano_actual=date('Y');
        $mes_actual=date('n');
       
        $tipo_chart  ='PieChart';
        $meses=["Seleccione","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        $meses=array_slice($meses,0,$mes_actual+1);
         
         if($request->mes!=0){
          $mes=$request->mes;
         }else{
          $mes=1;
         }

        //INDICADOR EFICACIA

        $eficacia = DB::table('cierres_mensuales')->where('tipo_indicador',1)
        ->where('mes',$mes)
        ->where('ano',$ano_actual)
        ->first();

          $report_efi = 'reporte_eficacia';
        $indi5 = \Lava::DataTable();
        $indi5->addStringColumn('Eficacia')
                ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        

        $indi5->addRow(["Eficacia", (int)$eficacia->avg_eficacia]);
        $indi5->addRow(["Ineficacia", (int)(100-$eficacia->avg_eficacia)]);
        \Lava::PieChart($report_efi, $indi5, [
            'title' => 'Indicadores Eficacia',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '100%'
            ],
            'height' => '350'
        ]);
         //FIN INDICADOR EFICACIA


         //INDICADOR CANCELACION


         $cancelacion=DB::table('cierres_mensuales')->where('tipo_indicador',2)
        ->where('mes',$mes)
        ->where('ano',$ano_actual)
        ->first();

        $report_cance = 'reporte_cancelaciones';
        $indi6 = \Lava::DataTable();
        $indi6->addStringColumn('Cancelados')
                ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
        $indi6->addRow(["Cancelados por el cliente", (int)$cancelacion->avg_cancelados_cliente]);
        $indi6->addRow(["Cancelados por temporizar", (int)$cancelacion->avg_cancelados_temporizar]);
        $indi6->addRow(["Cancelados no efectivas", (int)$cancelacion->avg_cancelados_no_efectivo]);
        \Lava::PieChart($report_cance, $indi6, [
            'title' => 'Indicadores Requerimientos Cancelados',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 60,
                'width' => '110%'
            ],
            'width' => '500',
            'height' => '300'
        ]);

         //FIN INDICADOR CANCELACION


        //INDICADOR EFICACIA LLAMADA

         $eficacia_llamada = DB::table('cierres_mensuales')->where('tipo_indicador',3)
        ->where('mes',$mes)
        ->where('ano',$ano_actual)
        ->first();

        $report_eficacia_llamada = 'reporte_eficacia_llamada';
        $indi7 = \Lava::DataTable();
        $indi7->addStringColumn('Eficacia')
                ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        
        $indi7->addRow(["Eficacia", (int) $eficacia_llamada->avg_eficacia_llamada]);
        $indi7->addRow(["Ineficacia", (int)(100-$eficacia_llamada->avg_eficacia_llamada)]);
        \Lava::PieChart($report_eficacia_llamada, $indi7, [
            'title' => 'Indicadores Eficacia Llamadas',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 40,
                'width' => '100%'
            ],
            'height' => '350'
        ]);


        //FIN INDICADOR EFICACIA LLAMADA

        return view("admin.reportes.indicador_cierres_mensuales", compact("tipo_chart","eficacia","report_efi","report_cance","cancelacion","eficacia_llamada","report_eficacia_llamada","meses","mes","ano_actual"));
    }

    public function reporteDemanda(Request $request){
         $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }

        $headersr   = $this->getHeaderDemanda();
        $data      = $this->getDataDetalleReclu($request);

          
        return view('admin.reportes.reporte_demanda')->with([
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headersr'   => $headersr,
        ]);
       
    }

    public function reporteOferta(Request $request){
         $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }

        $headersr   = $this->getHeaderOferta();
        $data      = $this->getDataDetalleReclu($request);

          
        return view('admin.reportes.reporte_oferta')->with([
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headersr'   => $headersr,
        ]);
    }

    public function reporteCarga(Request $request){
         $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        if(route("home")=="https://gpc.t3rsc.co"){
          
          $criterios = ["" => "Seleccionar"] + ["1" => "PROCESOS ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "PROCESOS CONTRATADAS"];

        }else{
        
          $criterios = ["" => "Seleccionar"] + ["1" => "REQUISICIONES ABIERTAS"] + ["2" => "CERRADAS OPORTUNAMENTE"] + ["3" => "REQUISICIONES CONTRATADAS"];

        }
        
        $headersr   = $this->getHeaderCarga();
        $data      = $this->getDataDetalleReclu($request);

          
        return view('admin.reportes.reporte_carga')->with([
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headersr'   => $headersr,
        ]);
    }

    
    private function getHeaderDemanda()
    {

        $headersr = [
            'ID',
            'TIPO IDENTIFICACIÓN',
            'No. IDENTIFICACIÓN',
            'RAZON SOCIAL',
            'DEPARTAMENTO',
            'MUNICIPIO',
            'TAMAÑO',
            'ACTIVIDAD ECONOMICA (C.I.I.U)',
            'FECHA DE REQUISICION',
            'CARGO REQUERIDO (C.I.U.O)',
            'NO. DE REQUISICIONES REGISTRADAS',
            'SALARIO OFRECIDO',
            'SEXO',
            'NIVEL EDUCATIVO',
            'NO. DE REQUISICIONES CUBIERTAS'
            
        ];
        return $headersr;
    }

    private function getHeaderOferta()
    {

        $headersr = [
            'ID',
            'TIPO DOCUMENTO',
            'NÚMERO DOCUMENTO',
            'PRIMER APELLIDO',
            'SEGUNDO APELLIDO',
            'PRIMER NOMBRE',
            'SEGUNDO NOMBRE',
            'FECHA DE NACIMIENTO',
            'SEXO',
            'NIVEL EDUCATIVO',
            'NÚCLEO DE FORMACIÓN',
            'CARGO A CUBRIR(C.I.U.O)',
            'ESTADO  CONTRATO',
            'FECHA INICIAL DEL  CONTRATO',
            'FECHA FINAL DEL  CONTRATO',
            'SALARIO',
            'NIT DE LA EMPRESA USUARIA',
            'TIEMPO',
            'UNIDAD DE MEDIDA',
            'OBJETO DEL CONTRATO'
            
        ];
        return $headersr;
    }

    private function getHeaderDescargaContratacion()
    {

        $headersr = [
            'cod_empr',
            'tip_docu',
            'cod_empl',
            'dto_expe',
            'pai_expe',
            'mpi_expe',
            'cod_inte',
            'ape_empl',
            'nom_empl',
            'nac_iona',
            'pai_extr',
            'sex_empl',
            'cla_lmil',
            'num_lmil',
            'dis_lmil',
            'pai_naci',
            'dto_naci',
            'mpi_naci',
            'fec_naci',
            'pai_resi',
            'dto_resi',
            'mpi_resi',
            'dir_resi',
            'bar_resi',
            'rut_resi',
            'tel_resi',
            'est_civi',
            'per_carg',
            'gra_educ',
            'tit_obte',
            'pro_titu',
            'mat_prof',
            'ano_serp',
            'mes_serp',
            'dia_serp',
            'vin_serp',
            'ano_spri',
            'mes_spri',
            'dia_spri',
            'vin_spri',
            'ano_trai',
            'mes_trai',
            'dia_trai',
            'vin_trai',
            'ult_enti',
            'pub_real',
            'tie_inha',
            'obs_inha',
            'obs_erva',
            'box_mail',
            'eee_mail',
            'tel_trab',
            'tel_movi',
            'tel_faxi',
            'dir_part',
            'rel_empl',
            'rmt_imag',
            'for_acad',
            'ind_rest',
            'obs_rest',
            'fec_desr',
            'fec_hasr',
            'fec_reso',
            'num_reso',
            'PRO_ESPE',
            'ADI_USUA',
            'FEC_FALL',
            'PAG_EXTE',
            'IND_DISC',
            'POR_DISC',
            'NUM_CASA',
            'LOC_EXPE',
            'LOC_NACI',
            'LOC_RESI',
            'PRE_CONA',
            'NUM_CONA',
            'COD_ZONA',
            'COD_VIAS',
            'NOM_VIAS',
            'SUS_PATR',
            'FAM_EMPR',
            'NOM_FAMI',
            'NOM_RECO',
            'FEC_EXPE',
            'CAS_CONT',
            'PER_FILE',
            'RAD_OCIU'
            
        ];
        return $headersr;
    }

    private function getHeaderReporteContratados()
    {

        $headersr = [
            'Empresa contratante',
            'Nit empresa contratante',
            'Cliente',
            'N° Requerimiento',
            'Tipo de proceso',
            'Agencia',
            'Fecha de creación del requerimiento',
            'Fecha de envío a contratación',
            'Fecha de firma de contrato',
            'Estado de contrato',
            'Tipo de identificación',
            'N° de cédula',
            'Nombres',
            'Apellidos',
            'Cargo',
            'Cargo genérico',
            'Ciudad de trabajo',
            'Centro de costos',
            'Nivel de riesgo',
            'Tipo de salario',
            'Salario',
            'Salario en letras',
            'Auxilios adicionales',
            'Auxilio de transporte',
            'Fecha de Ingreso',
            'Dirección',
            'Barrio',
            'Ciudad de residencia',
            'N° de teléfono',
            'Correo electrónico',
            'Estado civil',
            'Género',
            'Tipo de sangre',
            'Fecha de nacimiento',
            'Ciudad de nacimiento',
            'Fecha de expedición del documento',
            'Nivel educativo',
            'Número de hijos',
            'Talla zapatos',
            'Talla camisa',
            'Talla pantalón',
            'EPS',
            'AFP',
            'Fondo de cesantías',
            'Caja de compensación',
            'Banco',
            'Tipo de cuenta bancaria',
            'N° de cuenta bancaria',
            'Usuario envió a contratar',
            'Fuente de Reclutamiento',
            'Observaciones del candidato',
            'Usuario que aprueba la contratación',
            'Estado del requerimiento'
           
        ];
        return $headersr;
    }

     private function getHeaderEnviadosPruebas()
    {

        $headersr = [
            'nombre',
            'fecha_nacimiento',
            'correo',
            'telefono',
            'genero',
            'puesto',
            'escolaridad'
            
            
        ];
        return $headersr;
    }

    private function getHeaderCarga()
    {

        $headersr = [
            'cod_emp',
            'ap1_emp',
            'ap2_emp',
            'nom_emp',
            'tip_ide',
            'pai_exp',
            'ciu_exp',
            'fec_nac',
            'cod_pai',
            'cod_dep',
            'cod_ciu',
            'sex_emp',
            'num_lib',
            'cla_lib',
            'dim_lib',
            'gru_san',
            'fac_rhh',
            'est_civ',
            'nac_emp',
            'dir_res',
            'tel_res',
            'pai_res',
            'dpt_res',
            'ciu_res',
            'per_car',
            'fec_ing',
            'fec_egr',
            'cod_cia',
            'cod_suc',
            'cod_cco',
            'cod_cl1',
            'cod_cl2',
            'cod_cl3',
            'cod_cl4',
            'cod_cl5',
            'cod_cl6',
            'cod_cl7',
            'cod_car',
            'tip_con',
            'tip_pag',
            'met_ret',
            'por_ret',
            'tip_ded',
            'mto_dto',
            'cod_ban',
            'cta_ban',
            'reg_sal',
            'cod_tlq',
            'cla_sal',
            'est_lab',
            'pen_emp',
            'emp_pen',
            'cau_pen',
            'fdo_ate',
            'por_ate',
            'fdo_pen',
            'fdo_sal',
            'fdo_ces',
            'fec_aum',
            'sal_bas',
            'sal_ant',
            'niv_ocu',
            'tam_emp',
            'pes_emp',
            'est_soc',
            'gas_men',
            'per_beb',
            'pro_fum',
            'ind_vac',
            'dia_vac',
            'pje_sue',
            'avi_emp',
            'ind_pva',
            'ind_sab',
            'ind_m31',
            'cat_car',
            'fec_car',
            'fec_bon',
            'ccf_emp',
            'cal_ser',
            'met_tpt',
            'cal_sv2',
            'cal_sv3',
            'cal_sv4',
            'nom_rem',
            'car_enc',
            'cta_gas',
            'ind_pdias',
            'sue_var',
            'ind_svar',
            'tip_nom',
            'ded_horas',
            'val_hora',
            'clasif_cat',
            'horas_mes',
            'apo_pen',
            'apo_sal',
            'apo_rie',
            'ind_discco',
            'ind_evalua',
            'reg_pres',
            'e_mail',
            'tel_cel',
            'cod_reloj',
            'mod_liq',
            'suc_ban',
            'tot_hor',
            'tip_cot',
            'ind_extjero',
            'ind_resi_extjero',
            'SubTip_Cot',
            'prm_sal',
            'dpt_exp',
            'asp_sal',
            'disp_asp',
            'pto_gas',
            'deudas',
            'Cpto_Deudas',
            'Niv_aca',
            'num_ide',
            'barrio',
            'fto_emp',
            'ID_Uniq',
            'cod_ranvac',
            'Tip_sindclzdo',
            'ind_Embz',
            'ind_IncPm',
            'mto_dtoNA',
            'nom1_emp',
            'nom2_emp',
            'tip_pen',
            'ind_pencomp',
            'ind_penpagext',
            'ind_EmpleapenEmp',
            'ind_DecRenta',
            'fec_priming',
            'cod_est',
            'e_mail_alt',
            'login_portal',
            'fec_ult_act',
            'num_req',
            'Aut_Dat',
            'Fec_Aut',
            'Tip_VincDian',
            'Concepto_DIAN2280',
            'Dia_Tra_Ant_ec',
            'tip_viv_ec',

            'sal_trab_ant_ec',
            'ret_trab_ant_ec',
            'Nro_Calle_ec',
            'region_ec',
            'ded_trab_ant_ec',
            'reb_trab_ant_ec',
            'dedrenta_ec',
            'Exo_teredad_ec',
            'ind_exodisc_ec',
            'ind_pag_fdr_ec',
            'ind_incl_util_ec',
            'ind_mesdecter_ec',
            'ind_mesdecua_ec',
            'ind_discconif',
            'cta_gasnif',
            'ind_estlabref',
            'cod_pagelec'
            
        ];
        return $headersr;
    }
   
    public function reportesDemandaExcel(Request $request)
    {
        $headers = $this->getHeaderDemanda();
        $data    = $this->getDataDetalleDemanda($request->all());
        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-fdf-detalle-demanda', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Detalle Indicadores');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Indicadores');
            $excel->sheet('Reporte Detalle Indicadores', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_demanda', [
                    'data'    => $data,
                    'headersr' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    public function reportesOfertaExcel(Request $request)
    {
        $headers = $this->getHeaderOferta();
        $data    = $this->getDataDetalleOferta($request->all());

        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();

        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-fdf-detalle-indicadores', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Detalle Indicadores');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Indicadores');
            $excel->sheet('Reporte Detalle Indicadores', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_oferta', [
                    'data'    => $data,
                    'headersr' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    public function reportesDescargaContratacionExcel(Request $request)
    {
        //dd($request->all());
        $headers = $this->getHeaderDescargaContratacion();
        $data    = $this->getDataDetalleDescargaContratacion($request->all());

        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }
//dd($data);
        Excel::create('reporte-excel-fdf-detalle-contratacion', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Detalle Indicadores');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Indicadores');
            $excel->sheet('Reporte Detalle Indicadores', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_descarga_contratacion', [
                    'data'    => $data,
                    'headersr' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }
    public function reportesContratadosExcel(Request $request)
    {
        //dd($request->all());

        $headers = $this->getHeaderReporteContratados();
        $data    = $this->getDataDetalleReporteContratados($request->all());

        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }
//dd($data);
        Excel::create('reporte-excel-fdf-detalle-contratados', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Contratados');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Contratados');
            $excel->sheet('Reporte Contratados', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_reportes_contratados', [
                    'data'    => $data,
                    'headersr' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    public function reportesEnviadosPruebasExcel(Request $request)
    {
        //dd($request->all());
        $headers = $this->getHeaderEnviadosPruebas();
        $data    = $this->getDataDetalleEnviadosPruebas($request->all());
         $busqueda=false;
        if($request->req_id!=""){
            $busqueda=true;
        }
        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }
//dd($data);
        Excel::create('reporte-excel-fdf-detalle-indicadores', function ($excel) use ($data, $headers, $formato,$busqueda) {
            $excel->setTitle('Reporte Detalle Indicadores');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Indicadores');
            $excel->sheet('Reporte Detalle Indicadores', function ($sheet) use ($data, $headers, $formato,$busqueda) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_enviados_pruebas', [
                    'data'    => $data,
                    'headersr' => $headers,
                    'formato' => $formato,
                    'busqueda'=> $busqueda
                ]);
            });
        })->export($formato);
    }

    public function reportesCargaExcel(Request $request)
    {
        //dd($request->all());
        $headers = $this->getHeaderCarga();
        $data    = $this->getDataDetalleCarga($request->all());
        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }
//dd($data);
        Excel::create('reporte-excel-fdf-detalle-indicadores', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Detalle Indicadores');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Detalles Indicadores');
            $excel->sheet('Reporte Detalle Indicadores', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.includes.grilla_detalle_carga', [
                    'data'    => $data,
                    'headersr' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    //Reporte detalle requerimientos
    public function datos(Request $request)
    {
        $areas=array();
        $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();


        if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co"){
           $areas=["" => "Seleccionar"] + SolicitudAreaFuncional::where("estado", 1)->pluck("descripcion", "id")->toArray();
        }
    
        $headers   = $this->getHeaderDetalle();
        $data      = $this->getDataDetalle($request);

          //reportesaquiiii de requerimientos
        return view('admin.reportes.reportedetalles')->with([
            'areas'     => $areas,
            'clientes'  => $clientes,
            'criterios' => $criterios,
            'data'      => $data,
            'headers'   => $headers,
            'ciudad'   => $ciudad,
            'cargos'   => $cargos,
        ]);
    }

    public function indicadorcumplimientoANS(Request $request){

     // dd($request);
        $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        $fecha_inicio = $request['fecha_inicio'];
        $fecha_final  = $request['fecha_final'];
        $cliente_id   = $request['cliente_id'];
        
        $data="";
    
        //dd($formato);
        // Data
        $indicador_cumplimiento = 'indicador_cumplimiento';
        $indicador_calidad = 'indicador_calidad';
        $mostrar= false;
        
      if($fecha_inicio != '' || $fecha_final != '' || $cliente_id != '' ){ //si no estan vacios
        //$data = DB::table('requerimientos')
             //dd($request->ciudad_id);
           $data = Requerimiento::join(
                        'tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
                        ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
                        ->join('tipos_contratos', 'requerimientos.tipo_contrato_id', '=', 'tipos_contratos.id')
                        ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
                        ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
                        ->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
                        ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
                        ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
                        ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id) {

                            if($fecha_inicio != ""  &&     $fecha_final != "") {
                                $sql->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                            }

                            if ($cliente_id != "") {
                                $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                            }

                        })
                        ->select('requerimientos.negocio_id',
                            'requerimientos.id as requerimiento_id',
                            DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
                            
                            'clientes.nombre as cliente',
                            'tipos_contratos.descripcion as tipo_contrato',
                            'cargos_genericos.descripcion as cargo_generico',
                            'cargos_especificos.descripcion as cargo_cliente',
                            'requerimientos.num_vacantes as vacantes_solicitadas',
                            
                            DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'),
                            DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as cant_contratados'),
                            DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\') as fecha_inicio_vacante'),
                            DB::raw('DATE_FORMAT(requerimientos.fecha_ingreso, \'%Y-%m-%d\') as fecha_tentativa'),

                            //metodo para dias_vencidos
                            DB::raw('CASE WHEN (select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                                order by created_at desc limit 1) IS NULL
                                   THEN datediff(now(),requerimientos.fecha_ingreso)
                                    ELSE datediff((select created_at from estados_requerimiento where req_id=requerimientos.id and estado in ('.config('conf_aplicacion.C_TERMINADO'). ',2,22,'.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').','.config('conf_aplicacion.C_CLIENTE'). ')  
                                order by created_at desc limit 1),requerimientos.fecha_ingreso) END  as dias_vencidos'),
            //-------------------------------------------------------------------------------------
                            DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                            DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),

                            DB::raw('upper(users.name) as usuario_cargo_req'),
                            DB::raw('((select upper(p.name)  
                                from role_users o 
                                left join users p on o.user_id=p.id 
                                left join users_x_clientes ux on p.id=ux.user_id
                                left join clientes cli on ux.cliente_id=cli.id
                                left join negocio neg on cli.id=neg.cliente_id
                                left join requerimientos req on neg.id=req.negocio_id
                                left join estados_requerimiento er on er.req_id=req.id

                                where req.id=requerimiento_id and
                                o.role_id=17 and
                                er.user_gestion=p.id 

                                order by o.created_at desc limit 1)) as usuario_gestiono_req'),
                            DB::raw('case requerimientos_estados.max_estado when ' . config('conf_aplicacion.C_RECLUTAMIENTO') . ' then "semaforo-red" when ' . config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') . ' then "semaforo-yellow" when ' . config('conf_aplicacion.C_TERMINADO') . ' then "semaforo-green" when ' . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . ' then "semaforo-orange" else "semaforo-yellow" end as semaforo'),
                            DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                            'requerimientos.fecha_presentacion_oport_cand',
                            'requerimientos.cand_presentados_puntual',
                            'requerimientos.cand_presentados_no_puntual',
                            'requerimientos.cand_contratados_puntual',
                            'requerimientos.cand_contratados_no_puntual',
                            DB::raw(' round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion '),
                            DB::raw(' round((requerimientos.cand_contratados_puntual/requerimientos.num_vacantes)*100) as ind_oport_contratacion'),
                            DB::raw(' round(((select count(*) from procesos_candidato_req
            where ( estado in('.config('conf_aplicacion.C_EN_PROCESO_CONTRATACION').') and requerimiento_id=requerimientos.id) and ( cand_presentado_puntual=1 and cand_contratado=1 )
            group by requerimiento_id)/requerimientos.num_vacantes)*100) as ind_calidad_presentacion')

                        )
            ->groupBy('requerimientos.id')
            ->orderBy('requerimiento_id','desc')->get();

         //}

         $calidad = 0;
         $suma = 0;

       //cumplimiento ans 

         foreach ($data as $field) {
            //comprobar los q han cumplido
            if($field->ind_calidad_presentac() != 0){
              $calidad++; //calidad en la presentacion
            }

            if($field->ind_cumplimiento_ans() != 0){
              $suma++; //cumplimiento ans
            }
         }
//dd($calidad.'/'.$suma);
       
       $indicador_cumplimiento = 'indicador_cumplimiento';
            $indi9 = \Lava::DataTable();
            $indi9->addStringColumn('CUMPLIMIENTO DE ANS')
                    ->addNumberColumn('CUMPLIMIENTO ANS');

            $slices =[
              ['offset' => 0.2],
              ['offset' => 0.10]
            ];
        
         $incumplimiento = $data->count() - $suma;

        $indi9->addRow(["OPORTUNOS",$suma]);
        $indi9->addRow(["NO OPORTUNOS",$incumplimiento]);

        \Lava::PieChart($indicador_cumplimiento, $indi9, [
            'title' => 'Indicador Cumplimiento ANS',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
              'left' => 80,
              'top' => 40,
              'width' => '100%',
              'height' => '150'
            ],
            
        ]);


        $indicador_calidad = 'indicador_calidad';
            $indi10 = \Lava::DataTable();
            $indi10->addStringColumn('CALIDAD PRESENTACION')
                    ->addNumberColumn('DE CALIDAD');

            $slices =[
              ['offset' => 0.2],
              ['offset' => 0.10]
            ];
        
         $no_calidad = $data->count() - $calidad;

        $indi10->addRow(["OPORTUNOS",$calidad]);
        $indi10->addRow(["NO OPORTUNOS",$no_calidad]);

        \Lava::PieChart($indicador_calidad, $indi10, [
            'title' => 'Indicador Calidad Presentacion',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
              'left' => 80,
              'top' => 40,
              'width' => '100%',
              'height' => '150'
            ],
            
        ]);
        $mostrar=true;
       }
        return view('admin.reportes.indicador_cumplimiento_ans')->with([
            'clientes'     => $clientes,
            'indicador_calidad'     => $indicador_calidad,
            'indicador_cumplimiento'  => $indicador_cumplimiento,
            'mostrar'  => $mostrar
        ]);
     }//fin del if

     public function indicador_dashboard(){




        return view("admin.reportes.indicador_dashboard");
     }


/*
    Indicador de cancelaciones que agrupa por motivo y agencia

    By Vilfer Alvarez

*/
      public function indicador_indice_cancelaciones(Request $request){


      $user_sesion = $this->user;
      
      
      if(isset($request->busqueda)){


            $requerimientos=Requerimiento::where(function ($where) use ($request) {

                if ($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                }
            })
            ->select("requerimientos.num_vacantes as num_vacantes")
            ->get();
            $vacantes_totales=$requerimientos->sum("num_vacantes");
          
            
            $reporte_candelados = Requerimiento::
            join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            
           
            ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
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
            ->whereIn('estados_requerimiento.estado',
            [1,2])

            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where(function ($where) use ($request) {

                  //dd($request->get('cliente_id'));
               
                    
               
                     
                  
                if ($request->get('fecha_carga_ini') != "" && $request->get('fecha_carga_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$request->get('fecha_carga_ini'),$request->get('fecha_carga_fin')]);
                }

                 if ($request->get('fecha_tenta_ini') != "" && $request->get('fecha_tenta_fin') != "") {
                        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$request->get('fecha_tenta_ini'),$request->get('fecha_tenta_fin')]);
                    }

                if ($request->get('tipo_cancelacion')!= "") {
                                $where->where("estados_requerimiento.estado", $request->get('tipo_cancelacion'));
                            }
                 })
            
            ->select(
                'requerimientos.id',
                'requerimientos.num_vacantes as num_vacantes',
                'estados_requerimiento.motivo as motivo',
                'estados_requerimiento.estado as estado',
                'ciudad.agencia as agencia'
                )
                   
            ->groupBy('requerimientos.id')
            ->get();

      $cancelados = [];

             $numero_cancelados_cliente = 0;
             $numero_cancelados_temporizar = 0;
             //$numero_cancelados_no_efectiva = 0;
             $numero_req = $reporte_candelados->count();
             $vacantes_canceladas=$reporte_candelados->sum("num_vacantes");
             
             
            $numero_cancelados_cliente=1; 
            $numero_cancelados_temporizar=1;
            $numero_cancelados_no_efectiva=1;

            $detalle_motivo=array();
            $agencias=Agencia::all();
            $motivos=MotivoEstadoRequerimiento::all();
            foreach($motivos as $m){
                $datos=$reporte_candelados->filter(function ($value) use ($m){
                    return  $value->motivo==$m->id;
                });

                $detalle_motivo[$m->descripcion]["total"]=$datos->sum("num_vacantes");

                //guardamos totales por agencia 
                foreach($agencias as $agencia){
                        $detalle_motivo[$m->descripcion]["agencias"][$agencia->descripcion]=$datos->filter(function ($value) use ($agencia){
                        return  $value->agencia==$agencia->id;
                    })->count();
                }
                
                if($vacantes_canceladas>0){
                 $detalle_motivo[$m->descripcion]["porcentaje"]=round(($detalle_motivo[$m->descripcion]["total"]/$vacantes_canceladas)*100);
                 }
                 else{
                    $detalle_motivo[$m->descripcion]["porcentaje"]=0;
                 }        
             }
            
                    
          
           if ($numero_req ==0) {
               $numero_req = 1;
           }
        

          //dd($avg_cancelados_no_efectiva);

        // Reporte cancelados
        $report_cance = 'reporte_cancelaciones';
        $indi5 = \Lava::DataTable();
        $indi5->addStringColumn('Cancelados')
                ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];
        foreach($detalle_motivo as $clave=>$valor){
            $indi5->addRow([$clave, (int)$valor['porcentaje']]);
        }
        
        
        \Lava::PieChart($report_cance, $indi5, [
            'title' => 'Indicadores indice Cancelaciones',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            'slices' => $slices,
            'chartArea' => [
                'left' => 80,
                'top' => 60,
                'width' => '110%'
            ],
            'width' => '500',
            'height' => '300'
        ]);

        return view("admin.reportes.indicador_indice_cancelaciones")->with([
                    'report_cance' => $report_cance,
                    
                   
                    'tipo_chart'  => 'PieChart',
                    
                    'vacantes_canceladas'     => $vacantes_canceladas,
                    "busqueda"       =>true,
                    'vacantes_totales'  => $vacantes_totales,
                    'detalle_motivo'   =>$detalle_motivo,
                    'agencias'      =>$agencias
                     
        ]);
    }
    else{
      
        return view("admin.reportes.indicador_indice_cancelaciones");

    }

        return view("admin.reportes.indicador_indice_cancelaciones");
     }



     public function reportesDiarioSeleccion(){

         $clientes  = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();


        return view('admin.reportes.reportes_diarios',compact("clientes"));
     }

     public function reportesDiarioSeleccionExcel(Request $request){


        $headerss = $this->getHeaderDiarios($request->param);
        $data    = $this->getDataDiarios($request);
        $formato = 'xlsx';
        $param=$request->param;
        $report=$request->report;

        $sitio = Sitio::first();

        Excel::create($report, function ($excel) use ($sitio,$data, $headerss, $formato,$param,$report) {
            $excel->setTitle($report);
            $excel->setCreator('$nombre')
            ->setCompany('$nombre');

            $excel->setDescription($report);

            $excel->sheet($report, function ($sheet) use ($sitio,$data, $headerss, $formato,$param) {
                $sheet->setOrientation("landscape");

                $sheet->loadView('admin.reportes.includes.grilla_diarios', [
                    'data'     => $data,
                    'sitio'    => $sitio,
                    'headerss' => $headerss,
                    'formato'  => $formato,
                    'param'    => $param
                ]);
            });
        })->export($formato);
     }

    private function getHeaderDiarios($param){

        switch ($param) {
            case 1:

                    $headers = [
                       'cliente',
                       '#Vacantes Inicio del mes',
                       '#Vacantes solicitadas en el mes',
                       '#Total Vacantes',
                       '#Vacantes cerradas',
                       '#Vacantes canceladas por COVID 19',
                       '#Vacantes canceladas por otros motivos',
                       '#Vacantes Canceladas',
                       '#Total Vacantes abiertas',
                       '#Vacantes Abiertas Cierre mes siguiente',
                       '#Vacantes para cierre dentro del mes'


                 ];
                break;
            case 2:

                $headers = [
                       'cliente',
                       '#Contrataciones Puras Inicio del mes',
                       '#Contrataciones Puras solicitadas en el mes',
                       '#Total Contrataciones Puras',
                       '#Contrataciones Puras cerradas',
                       '#Contrataciones Puras canceladas por COVID 19',
                       '#Contrataciones puras canceladas por otros motivos',
                       '#Contrataciones Puras Canceladas',
                       '#Total Contrataciones Puras abiertas',
                       '#Contrataciones Puras Abiertas Cierre mes siguiente',
                       '#Contrataciones Puras para cierre dentro del mes'


                 ];

                break;
            
            default:
                # code...
                break;
        }

         return $headers;

    }

    private function getDataDiarios($request){

       $hoy=date("Y-m-d");
        $mes=date("Y-m");
        $mes_actual=date("n");
        $y=date("Y");

        //otra fech    
        
        //fin
        $inicio=$mes."-01 00:00:00";
         $mes_limpio=$mes=date("n");
        $cliente   = $request->cliente_id;
        $agencia     = $request->agencia_id;
        $data="vacio";
        $nueva_fecha = strtotime ( '+1 month' , strtotime($inicio )) ;
        $mesSiguiente= date ( 'Y-m-d' , $nueva_fecha );
        
        // GTH-paramcontratados
        if($request->param==1){
            
            $data=Clientes::where(function ($sql) use ($cliente, $agencia){
               
                if ($cliente != "") {
                    $sql->where("clientes.id",$cliente);

                }
                if ($agencia != "") {
                   
                }
                
            })
           
            ->select(
                //'requerimientos.id as numero_requerimiento',
                'clientes.nombre as cliente',
                 DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_mes_actual from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id where requerimientos.created_at>="'.$inicio.'" and negocio.cliente_id=clientes.id) as vacantes_mes_actual'),
                 DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_mes_siguiente from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id where requerimientos.fecha_ingreso>="'.$mesSiguiente.'" and negocio.cliente_id=clientes.id) as vacantes_mes_siguiente'),
                 DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_cierre_dentro_mes from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id where requerimientos.fecha_ingreso between "'.$inicio.'" and "'.$mesSiguiente.'" and negocio.cliente_id=clientes.id) as vacantes_cierre_dentro_mes'),
                 DB::raw('(select count(*) from firma_contratos inner join requerimientos on requerimientos.id=firma_contratos.req_id inner join negocio on requerimientos.negocio_id=negocio.id where firma_contratos.terminado in(1,2) and firma_contratos.estado not in(0) and negocio.cliente_id=clientes.id and firma_contratos.updated_at>="'.$inicio.'") as vacantes_cerradas'),
                   DB::raw('(select seleccion from inicio_mes where cliente_id=clientes.id and mes='.$mes_actual.' and ano='.$y.') as vacantes_mes_pasado'),
                   /*DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_cerradas from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id inner join estados_requerimiento on estados_requerimiento.req_id=requerimientos.id where select sum(requerimientos.num_vacantes) as vacantes_mes_actual from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id inner join estados_requerimiento on estados_requerimiento.req_id=requerimientos.id where requerimientos.created_at<"'.$inicio.'" and negocio.cliente_id=clientes.id and estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id) and estados_requerimiento.estado not in(16,'.config('conf_aplicacion.C_CLIENTE').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').',2)) as vacantes_mes_pasado'),
                   /*DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_cerradas from requerimientos inner join negocio on requerimientos.negocio_id=negoestados_requerimiento.created_at>="'.$inicio.'" and negocio.cliente_id=clientes.id and estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id) and estados_requerimiento.estado=16) as vacantes_cerradas'),*/
                    DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_cerradas from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id inner join estados_requerimiento on estados_requerimiento.req_id=requerimientos.id where estados_requerimiento.created_at>="'.$inicio.'" and negocio.cliente_id=clientes.id and estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id) and estados_requerimiento.estado in('.config('conf_aplicacion.C_CLIENTE').',2)) as vacantes_canceladas')
                
            )
            ->groupBy("clientes.id")
            ->get();

        }
        elseif($request->param==2){

            
            $data=Clientes::where(function ($sql) use ($cliente, $agencia){
               

                if ($cliente != "") {
                    $sql->where("clientes.id",$cliente);

                }
                if ($agencia != "") {
                   
                }
                
            })
           
            ->select(
                //'requerimientos.id as numero_requerimiento',
                'clientes.nombre as cliente',
                 DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_mes_actual from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id where requerimientos.created_at>="'.$inicio.'" and negocio.cliente_id=clientes.id and requerimientos.tipo_proceso_id=6) as vacantes_mes_actual'),
                 DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_mes_siguiente from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id where requerimientos.fecha_ingreso>="'.$mesSiguiente.'" and negocio.cliente_id=clientes.id) as vacantes_mes_siguiente'),

                  DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_cierre_dentro_mes from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id where requerimientos.fecha_ingreso between "'.$inicio.'" and "'.$mesSiguiente.'" and negocio.cliente_id=clientes.id) as vacantes_cierre_dentro_mes'),
                 DB::raw('(select count(*) from firma_contratos inner join requerimientos on requerimientos.id=firma_contratos.req_id inner join negocio on requerimientos.negocio_id=negocio.id where firma_contratos.terminado in(1,2) and firma_contratos.estado not in(0) and negocio.cliente_id=clientes.id and firma_contratos.updated_at>="'.$inicio.'") as vacantes_cerradas'),
                  DB::raw('(select contratacion from inicio_mes where cliente_id=clientes.id and mes='.$mes_actual.' and ano='.$y.') as vacantes_mes_pasado'),
                  /* DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_cerradas from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id inner join estados_requerimiento on estados_requerimiento.req_id=requerimientos.id where estados_requerimiento.created_at>="'.$inicio.'" and requerimientos.tipo_proceso_id=6 and negocio.cliente_id=clientes.id and estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id) and estados_requerimiento.estado=16) as vacantes_cerradas'),*/
                    DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_cerradas from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id inner join estados_requerimiento on estados_requerimiento.req_id=requerimientos.id where estados_requerimiento.created_at>="'.$inicio.'" and requerimientos.tipo_proceso_id=6 and negocio.cliente_id=clientes.id and estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id) and estados_requerimiento.estado in('.config('conf_aplicacion.C_CLIENTE').',2)) as vacantes_canceladas')
                
            )
            ->groupBy("clientes.id")
            ->get();
    
        }


        

        /*$data = DB::table('requerimientos')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
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
            
            ->join('requerimiento_cantidato','requerimientos.id','=','requerimiento_cantidato.requerimiento_id')
            ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
            ->join('users','users.id','=','requerimiento_cantidato.candidato_id')
            ->join('datos_basicos','datos_basicos.user_id','=','users.id') 
            ->where("requerimiento_cantidato.estado_candidato", "!=", config('conf_aplicacion.C_INACTIVO'))
            ->where("requerimiento_cantidato.estado_candidato", "!=", config('conf_aplicacion.C_QUITAR'))
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $criterio,$usuario,$agencia) {
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("requerimientos_estados.fecha_creacion_req", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                }
                if ((int) $agencia > 0 && $agencia != "") {
                    $sql->where("ciudad.agencia", $agencia);
                }
                 if ($usuario != "") {
                    $sql->where("estados_requerimiento.user_gestion", $usuario);
                }
                switch ($criterio) {
                    case 1: //Req abiertas
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                        ]);
                        break;
                    case 2: //CERRADAS OPORTUNAMENTE
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        $sql->whereRaw("requerimientos_estados.fecha_ultimo_estado<=requerimientos.fecha_terminacion");
                        break;
                    case 3: //requi contratadas
                        $sql->where("requerimientos_estados.max_estado", "=", config('conf_aplicacion.C_TERMINADO'));
                        break;
                    default:
                        $sql->whereIn("requerimientos_estados.max_estado", [
                            config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_RECLUTAMIENTO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                        ]);
                }
            })
            ->select(
                'requerimientos.id as numero_requerimiento',
                'datos_basicos.numero_id',
                 'datos_basicos.nombres',
                 'datos_basicos.primer_apellido',
                 'estados.descripcion as estado_candidato',

                DB::raw('DATE_FORMAT(requerimiento_cantidato.created_at, \'%Y-%m-%d\') as fecha_asociacion'),
                
                DB::raw('(select upper(p.name)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id and o.estado = ' . config('conf_aplicacion.C_EN_PROCESO_SELECCION') . ' order by o.created_at desc limit 1) as usuario_gestiono_req'),
                
                
                DB::raw('(select upper(x.descripcion) as estado from requerimiento_cantidato y inner join tipo_fuente x on y.otra_fuente=x.id where y.requerimiento_id=requerimientos.id limit 1 ) as fuentes'),
                
                DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req')

            )->orderBy('requerimientos.id') ;

            if ($request->has('formato') and ($formato == "xlsx" || $formato == "pdf")) {
                $data = $data->get();
            } else {
                $data = $data->paginate(5);
            }
        }
        return $data;*/
     return $data;

    }

    public function inicio_mes(){

        $dia=date("d");
       $hoy=date("Y-m-d");
        $mes=date("Y-m");
        $mes_actual=date("n");
        $y=date("Y");

        //otra fecha
            
            
        
        //fin
        $inicio=$mes."-01 00:00:00";
         $mes_limpio=$mes=date("n");
        $data="vacio";
        $nueva_fecha = strtotime ( '+1 month' , strtotime($inicio )) ;
        $mesSiguiente= date ( 'Y-m-d' , $nueva_fecha);
           
       
        
        // GTH-paramcontratados

       /* DB::table('inicio_mes')->insert([
                         ['mes' => $mes_actual,'ano' => $y,'seleccion'=>1,'contratacion'=>3,'cliente_id'=>15]
                
                    ]);*/

        if($dia==01){


            $data1=Clientes::select(
                //'requerimientos.id as numero_requerimiento',
                'clientes.id as cliente_id',
                
                DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_mes_actual from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id inner join estados_requerimiento on estados_requerimiento.req_id=requerimientos.id where requerimientos.created_at<"'.$hoy.'" and negocio.cliente_id=clientes.id and estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id) and estados_requerimiento.estado not in(16,'.config('conf_aplicacion.C_CLIENTE').','.config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').',2)) as vacantes_mes_pasado'),
                /*DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_cerradas from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id inner join estados_requerimiento on estados_requerimiento.req_id=requerimientos.id where estados_requerimiento.created_at>="'.$inicio.'" and negocio.cliente_id=clientes.id and estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id) and estados_requerimiento.estado=16) as vacantes_cerradas'),*/
                DB::raw('(select sum(requerimientos.num_vacantes) as vacantes_mes_actual from requerimientos inner join negocio on requerimientos.negocio_id=negocio.id inner join estados_requerimiento on estados_requerimiento.req_id=requerimientos.id where requerimientos.created_at<"'.$hoy.'" and negocio.cliente_id=clientes.id and estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id) and requerimientos.tipo_proceso_id=6 and estados_requerimiento.estado not in(16,'.config('conf_aplicacion.C_CLIENTE').')) as vacantes_mes_pasado_contratacion')
                
            )
            ->groupBy("clientes.id")
            ->get();


            
            //GUARDAR EN TABLA INICIO_MES

            foreach ($data1 as $cliente) {
                    DB::table('inicio_mes')->insert([
                         ['mes' => $mes_actual,'ano' => $y,'seleccion'=>(int)$cliente->vacantes_mes_pasado,'contratacion'=>(int)$cliente->vacantes_mes_pasado_contratacion,'cliente_id'=>$cliente->cliente_id]
                
                    ]);
            }


        }
           


    
    }

    public function cron(){
        $fecha=date("Y-m-d H:i:s");
        $affected = DB::table('cron')
              ->where('id', 1)
              ->update(['fecha' => $fecha]);


    }


}