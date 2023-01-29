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

class IndicadorController extends Controller
{
    protected $estados_no_muestra = [];
    
    public function __construct()
    {
        $this->estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
        ]; //SON LOS ESTADOS PARA NO MOSTRAR EL CANDIDATO EN EL  REQUERIMIENTO

        $this->meses = [
            1  => "Enero",
            2  => "Febrero",
            3  => "Marzo",
            4  => "Abril",
            5  => "Mayo",
            6  => "Junio",
            7  => "Julio",
            8  => "Agosto",
            9  => "Septiembre",
            10 => "Octubre",
            11 => "Noviembre",
            12 => "Diciembre"
        ];

        parent::__construct();
    }

    public function indicador_eficacia(Request $request){

        $sitio=Sitio::first();
        $user_sesion = $this->user;
        $datos=true;

        $clientes =Clientes::orderBy("clientes.nombre", "ASC")->pluck("clientes.nombre", "clientes.id")
        ->toArray();


        $estados=[
            config('conf_aplicacion.C_TERMINADO'),
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),

        ];




        if(isset($request->fecha_carga_ini)){



            if(!empty($request->cierre)){

                $request->proceso_id="";
                $request->user_id="";
                $request->fecha_carga_ini="";
                $request->fecha_carga_fin="";
                $request->fecha_tenta_ini="";
                $request->fecha_tenta_fin="";
            }

            $estados_requerimiento = ["" => "Seleccionar"] + Estados::
            whereIn("id",$estados)
            ->pluck("estados.descripcion", "estados.id")->toArray();

            if($request->get('estado_id') != ""){
                $estados=array();
                $estados[]=$request->get('estado_id');
            }



            if(route("home")=="https://gpc.t3rsc.co"){
               $usuarios_gestionan=["" => "Seleccionar"] + User::join('estados_requerimiento','estados_requerimiento.user_gestion','=','users.id')
               ->pluck("users.name", "users.id")->toArray();

           }
           else{
            $usuarios_gestionan=["" => "Seleccionar"] + User::join('requerimientos','requerimientos.solicitado_por','=','users.id')
            ->pluck("users.name", "users.id")->toArray();

        }
        if(route("home")=="https://gpc.t3rsc.co"){
           $tipo_solicitud =  ["" => "Seleccionar"] + TipoProceso::where("active",1)
           ->pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();

       }
       else{
           $tipo_solicitud =TipoProceso::join('requerimientos','requerimientos.tipo_proceso_id','=','tipo_proceso.id')
           ->pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();
       }


       $eficacia = DB::table('requerimientos')
       ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
       ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
       ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
       ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
       ->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
       ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
       ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')

       ->where(function ($where) use ($request) {

                  //dd($request->get('cliente_id'));
         if ( count($request->cliente_id)>0) {

            $where->whereIn("clientes.id",$request->get('cliente_id'));
        }

        if ( count($request->proceso_id)> 0) {
            $where->whereIn("tipo_proceso.id",$request->get('proceso_id'));
        }

        if ( $request->user_id != "") {
            $where->whereRaw('(select upper(p.id)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id  order by o.created_at desc limit 1)= '.$request->get("user_id"));
        }


        if ($request->fecha_carga_ini != "") {
            $rango=explode(" | ", $request->fecha_carga_ini);
            $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$rango[0],$rango[1]]);
        }

        if ($request->fecha_tenta_ini != "") {
           $rango=explode(" | ",$request->fecha_tenta_ini);
           $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$rango[0],$rango[1]]);
       }
       if ($request->cierre != "") {
        $hoy=date("Y-m-d");
        $mes=date("Y-m");
        $inicio=$mes."-01";


        $where->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[date("Y-m-d",strtotime($inicio."- 6 month")),$inicio]);
    }

})

       ->whereIn("estados_requerimiento.estado", $estados)
       ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
       ->select(
        'requerimientos.id as requerimiento_id',
        DB::raw(' upper(tipo_proceso.descripcion) as tipo_requerimiento '),
        'requerimientos.num_vacantes as vacantes_solicitadas',
        'cargos_especificos.firma_digital as cargo_firma',
        DB::raw('(select count(*) from firma_contratos where terminado in(1,2) and estado not in(0) and req_id=requerimientos.id ) as cantidad_firmas'),
        DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion')
        
    )

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
        if($efi->cargo_firma && $sitio->asistente_contratacion){
            $numero_contratados +=(int)$efi->cantidad_firmas;
        }
        else{
            $numero_contratados +=(int)$efi->cant_enviados_contratacion;
        }
        $numero_contratados +=(int)$efi->cant_enviados_contratacion;
        $numero_vacantes +=(int)$efi->vacantes_solicitadas;
    }

    if($numero_vacantes <= 0)
    {
        $numero_vacantes = 1;
    }

    $avg_eficacia  = round(($numero_contratados/$numero_vacantes)*100); 
    if($avg_eficacia>100){
        $avg_eficacia=100;
        $avg_eficacia_no=0;
    }
    else{
        $avg_eficacia_no = 100-$avg_eficacia;
    }
    

    $eficacia1=[
        "total_contratados"=>$numero_contratados,
        "total_vacantes"=>$numero_vacantes,
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
    'tipo_solicitud' => $tipo_solicitud,
    'clientes'   =>$clientes,
    'usuarios_gestionan' => $usuarios_gestionan,
    "estados_requerimiento" => $estados_requerimiento,
    'tipo_chart' => 'PieChart',
    'eficacia1'  => $eficacia1,
    'datos'=>$datos        
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
 $usuarios_gestionan=["" => "Seleccionar"] + User::join('requerimientos','requerimientos.solicitado_por','=','users.id')
 ->pluck("users.name", "users.id")->toArray();
 $tipo_solicitud =TipoProceso::join('requerimientos','requerimientos.tipo_proceso_id','=','tipo_proceso.id')
 ->pluck("tipo_proceso.descripcion", "tipo_proceso.id")->toArray();

}



$estados_requerimiento = ["" => "Seleccionar"] + Estados::
whereIn("id",$estados)
->pluck("estados.descripcion", "estados.id")->toArray();

return view("admin.reportes.indicadores_eficacia")->with([
    'tipo_solicitud' =>    $tipo_solicitud,
    'usuarios_gestionan' => $usuarios_gestionan,
    "estados_requerimiento"=>$estados_requerimiento,
    'datos'=>$datos,
    'clientes'=>$clientes
]);
}

}

public function indicador_oportunidad(Request $request){

    $clientes =Clientes::pluck("clientes.nombre", "clientes.id")->toArray();


    if(route("home")=="https://gpc.t3rsc.co"){
       $usuarios_gestionan=["" => "Seleccionar"] + User::join('estados_requerimiento','estados_requerimiento.user_gestion','=','users.id')
       ->pluck("users.name", "users.id")->toArray();

   }
   else{
    $usuarios_gestionan=User::join('requerimientos','requerimientos.solicitado_por','=','users.id')
    ->pluck("users.name", "users.id")->toArray();

    }

$dt = Carbon::now();

if($request->has('fecha_inicio')){
    $fecha_inicio = $request->get('fecha_inicio');
}else{
            $fecha_inicio = "";//Carbon::create($dt->year, $dt->month, 1);
        }

        if($request->has('fecha_final')){
            $fecha_final = $request->get('fecha_final');
            //$fecha_final = '2017-11-30';
        }else{
            $fecha_final = $dt;
            //$fecha_final = '2017-11-30';
        }

        if($request->has('user_id')){

            $user_id = $request->get('user_id');
            //$fecha_final = '2017-11-30';
        }else{
            $user_id = [];
            //$fecha_final = '2017-11-30';
        }


        if($request->has('fecha_inicio_tentativa')){
            $fecha_inicio_tentativa = $request->get('fecha_inicio_tentativa');
        }else{
            $fecha_inicio_tentativa = "";//Carbon::create($dt->year, $dt->month, 1);
        }

        if($request->has('fecha_final_tentativa')){
            $fecha_final_tentativa = $request->get('fecha_final_tentativa');
            //$fecha_final = '2017-11-30';
        }else{
            $fecha_final_tentativa = $dt;
            //$fecha_final = '2017-11-30';
        }

        $cliente_id = $request->get('cliente_id');
        
       
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


           

            /* EFICACIA INDIVIDUAL Psicologo*/
            $user_sesion = $this->user;

            $ano_actual=date("Y");
            
        if(!isset($request->fecha_inicio)){

           return view("admin.reportes.indicadores_oportunidad")->with([
            'clientes'    => $clientes,
            'no_search'  =>true,

            'usuarios_gestionan' => $usuarios_gestionan

        ]);

       }
       $data = Requerimiento::join("negocio","requerimientos.negocio_id","=","negocio.id")
       //->join("requerimientos_estados","requerimientos.id","=","requerimientos_estados.req_id")
       ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
       ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
       ->where(function($sql)use($fecha_final_tentativa,$fecha_inicio_tentativa,$fecha_inicio, $fecha_final, $cliente_id,$user_id){
        if($fecha_inicio!=""){
           $rango=explode(" | ", $fecha_inicio);
           $sql->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$rango[0],$rango[1]]);
       }

       if($fecha_inicio_tentativa!=""){
        $rango=explode(" | ", $fecha_inicio_tentativa);
        $sql->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$rango[0],$rango[1]]);
    }

    if(count($user_id)>0){

        $sql->whereIn("requerimientos.solicitado_por",$user_id);
    }


    if(count($cliente_id)>0){
     $sql->whereIn("clientes.id",$cliente_id);
 }
})
       /*->whereIn("requerimientos_estados.max_estado",[
        config('conf_aplicacion.C_TERMINADO'),
        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
        config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
        config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
        config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL')])*/
    ->select(
        'requerimientos.cand_presentados_puntual',
        'requerimientos.cand_presentados_no_puntual',
        'requerimientos.cand_contratados_puntual',
        'requerimientos.cand_contratados_no_puntual',
        'requerimientos.cuantos_candidatos_presentar',
        'cargos_especificos.firma_digital',
        'requerimientos.num_vacantes',
        DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_APROBAR_CLIENTE\') and requerimiento_id=requerimientos.id and procesos_candidato_req.created_at<=requerimientos.fecha_presentacion_oport_cand) as cant_enviados_cliente_oportuno'),
        DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_APROBAR_CLIENTE\') and requerimiento_id=requerimientos.id and procesos_candidato_req.created_at>requerimientos.fecha_presentacion_oport_cand) as cant_enviados_cliente_inoportuno'),
        DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_APROBAR_CLIENTE\') and requerimiento_id=requerimientos.id) as cant_enviados_cliente'),

        DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id and procesos_candidato_req.created_at<=requerimientos.fecha_tentativa_cierre_req) as cant_enviados_contratar_oportuno'),
        DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id and procesos_candidato_req.created_at>requerimientos.fecha_tentativa_cierre_req) as cant_enviados_contratar_inoportuno'),
        DB::raw('round((requerimientos.cand_presentados_puntual/requerimientos.cuantos_candidatos_presentar)*100) as ind_oport_presentacion'),
        DB::raw('(select count(*) from firma_contratos where terminado in(1,2) and estado not in(0) and req_id=requerimientos.id and fecha_firma<=requerimientos.fecha_tentativa_cierre_req) as cantidad_firmas_oportunas'),
        DB::raw('(select count(*) from firma_contratos where terminado in(1,2) and estado not in(0) and req_id=requerimientos.id and fecha_firma>requerimientos.fecha_tentativa_cierre_req) as cantidad_firmas_inoportunas')

    )
    ->get();

    $data01 = [];
    $data02 = [];
    $data03 = [];

    
    $sum_presentados_op  = 0;
    $sum_presentados_ino = 0;
    $sum_iop = 0;
    $avg_iop = 0;
    $avg_iop_ino = 0;
    
    $sum_contratados_op  = 0;
    $sum_contratados_ino = 0;
    $sum_ioc = 0;
    $avg_ioc = 0;
    $avg_ioc_ino = 0;
    $vacantes_presentar=0;
    $vacantes=0;
    $contador=0;

        //dd($num_registros);
    foreach( $data as $d ){
        $contador++;
        if($d->cuantos_candidatos_presentar==0){
            $d->cuantos_candidatos_presentar=$d->num_vacantes;
        }
        $vacantes_presentar+=$d->cuantos_candidatos_presentar;
        $vacantes+=$d->num_vacantes;
        
        $sum_presentados_op +=(int)$d->cant_enviados_cliente_oportuno;
        $sum_presentados_ino+=(int)$d->cant_enviados_cliente_inoportuno;
            //dd((int)$d->ind_oport_presentacion);
        $sum_iop += round($d->cant_enviados_cliente_oportuno/$d->cuantos_candidatos_presentar*100);
            // Oportunidad contratación
        if($d->firma_digital){
            $sum_contratados_op+=(int)$d->cantidad_firmas_oportunas;
            $sum_contratados_ino+=(int)$d->cantidad_firmas_inoportunas;
            $sum_ioc += round($d->cantidad_firmas_oportunas/$d->num_vacantes*100);
        }
        else{
            $sum_contratados_op+=(int)$d->cant_enviados_contratar_oportuno;
            $sum_contratados_ino+=(int)$d->cant_enviados_contratar_inoportuno;
            $sum_ioc += round($d->cant_enviados_contratar_oportuno/$d->num_vacantes*100);
        }

            // Oportunidad calidad presentacion

    }

    
        if($vacantes_presentar==0){
            $vacantes_presentar=$vacantes;
        }
        //$avg_iop  = round($sum_presentados_op/$vacantes_presentar*100);
        ($vacantes_presentar)?$avg_iop  = round($sum_presentados_op/$vacantes_presentar*100):$avg_iop=0;
        ($vacantes)?$avg_ioc  = round($sum_contratados_op/$vacantes*100):$avg_ioc=0;
        
        //
        ($vacantes_presentar)?$avg_iop_ino  = round($sum_presentados_ino/$vacantes_presentar*100):$avg_iop_ino=0;
      
        ($vacantes)?$avg_ioc_ino  = round($sum_contratados_ino/$vacantes*100):$avg_ioc_ino=0;
        
        $total_presentados_iop = $sum_presentados_ino;//round(($avg_iop_ino*$sum_presentados_op)/$avg_iop);
         $total_contratados_iop = $sum_contratados_ino; //round(($avg_ioc_ino*$sum_contratados_op)/$avg_ioc_ino);
        //
         $total_no_presentados=abs($vacantes_presentar-($sum_presentados_op+$sum_presentados_ino));
         $total_no_contratados=abs($vacantes-($sum_contratados_op+$sum_contratados_ino));
         $data01=[
            "total_presentados_op"=>$sum_presentados_op,
            "total_presentados_iop"=>$sum_presentados_ino,
            "avg_iop"=>$avg_iop,
            "avg_iop_ino"=>$avg_iop_ino,
            "total_no_presentados"=>$total_no_presentados,
            "avg_no_presentados"  =>abs(100-($avg_iop+$avg_iop_ino))
        ];
        $data02=[
            "total_contratados_op"=>$sum_contratados_op,
            "total_contratados_iop"=>$sum_contratados_ino,
            "avg_ioc"=>$avg_ioc,
            "avg_ioc_ino"=>$avg_ioc_ino,
            "total_no_contratados"=>$total_no_contratados,
            "avg_no_contratados"  =>abs(100-($avg_ioc+$avg_ioc_ino))
        ];
        
        // Reporte 1
        $report_name = 'reporte_indicadores_oportunidad';
        $indi = \Lava::DataTable();
        $indi->addStringColumn('Oportunamente')
        ->addNumberColumn('Porcentaje');

        $slices =[
          ['offset' => 0.2],
          ['offset' => 0.3]
      ];
      $indi->addRow(["Oportunamente", (int)$avg_iop]);
      $indi->addRow(["Inoportunamente", (int)$avg_iop_ino]);
      $indi->addRow(["No presentados", (int)(100-($avg_iop+$avg_iop_ino))]);
      \Lava::PieChart($report_name, $indi, [
        'title' => 'Indicadores Oportunidad en la Presentación',
        'is3D' => true,
        'pieSliceText' => 'Porcentaje',
        'slices' => $slices,
        'chartArea' => [
            'left' => 80,
            'top' => 40,
            'width' => '100%'
        ],
        'height' => '300'
    ]);

        //Reporte 2
      $report_name2 = 'reporte_indicadores_oportunidad2';
      $indi2 = \Lava::DataTable();
      $indi2->addStringColumn('Oportunamente')
      ->addNumberColumn('Porcentaje');

      $slices2 =[
          ['offset' => 0.1],
          ['offset' => 0.1]
      ];
      $indi2->addRow(["Oportunamente", (int)$avg_ioc]);
      $indi2->addRow(["Inoportunamente", (int)$avg_ioc_ino]);
      $indi2->addRow(["No Contratados", (int)(100-($avg_ioc+$avg_ioc_ino))]);
      \Lava::PieChart($report_name2, $indi2, [
        'title' => 'Indicadores Oportunidad en la Contratación',
        'is3D' => true,
        'pieSliceText' => 'Porcentaje',
        'slices' => $slices2,
        'chartArea' => [
            'left' => 80,
            'top' => 40,
            'width' => '100%'
        ],
        'height' => '300'
    ]);

        //Reporte 3

           //Reporte 4
      $report_name4 = 'reporte_indicadores_oportunidad4';

      $titulo1='Solicitadas';
      $titulo2='Contratadas';

      if(route("home")=="https://gpc.t3rsc.co"){
        $titulo2='Aprobadas';
    }
    $indi4 = \Lava::DataTable();

    $indi4  
    ->addDateColumn('Year')
    ->addNumberColumn('Solicitadas')
    ->addNumberColumn($titulo2)

    ->addRow([ $ano_actual.'-1-1', $candidatos_solicitados_ene,$candidatos_contratados_ene])
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

    return view("admin.reportes.indicadores_oportunidad")->with([
        'report_name' => $report_name,
                    //'report_efi' => $report_efi,
        'clientes'    => $clientes,
        'tipo_chart'  => 'PieChart',
                        'usuarios_gestionan' => $usuarios_gestionan,
                        'report_name2'=> $report_name2,
                        'report_name4'=> $report_name4,
                        'fecha_inicio'=> $fecha_inicio,
                        'fecha_final' => $fecha_final,
                    //'eficacia1'   => $eficacia1,
                        'data01'      => $data01,
                        'data02'      => $data02,
                        'data03'      => $data03,
                        'contador'    => $contador,
                        'vacantes'    => $vacantes
                    ]);
    }

   public function indicadores_reclutamiento(Request $request){

         $ano_actual=date("Y");


        $candidatos =  DB::table('datos_basicos')
        ->join("users","users.id","=","datos_basicos.user_id")
        ->where(function ($where) use ($request) {

        })

        ->whereRaw('(DATE_FORMAT(datos_basicos.created_at, \'%Y\')='.$ano_actual.')')
        ->select(
            'datos_basicos.id','datos_basicos.nombres as nombre' ,
            DB::raw('DATE_FORMAT(datos_basicos.created_at, \'%m\') as mes_creacion')
        )
        ->get();

        $candidatos_asociados =  DB::table('requerimiento_cantidato')
       
        ->whereNotIn("requerimiento_cantidato.estado_candidato",$this->estados_no_muestra)

        ->whereRaw('(DATE_FORMAT(requerimiento_cantidato.created_at, \'%Y\')='.$ano_actual.')')
        ->select(
            DB::raw('DATE_FORMAT(requerimiento_cantidato.created_at, \'%m\') as mes_creacion')
        )
        ->groupBy("candidato_id","requerimiento_id")
        ->get();

        $candidatos_contar=[
            "cargados"=>["01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,"12"=>0],
            "asociados"=>["01"=>0,"02"=>0,"03"=>0,"04"=>0,"05"=>0,"06"=>0,"07"=>0,"08"=>0,"09"=>0,"10"=>0,"11"=>0,"12"=>0]
        ];
         for($i=0;$i<count($candidatos);$i++){
            $candidatos_contar["cargados"][$candidatos[$i]->mes_creacion]+=1;

        }

        for($i=0;$i<count($candidatos_asociados);$i++){
            $candidatos_contar["asociados"][$candidatos_asociados[$i]->mes_creacion]+=1;

        }

         $indi4 = \Lava::DataTable();
        
        $indi4  
            ->addStringColumn()
         //->addDateColumn('Year')
         ->addNumberColumn('Hojas de vida')
         ->addNumberColumn('Candidatos gestionados');
         for($i=1;$i<13;$i++){
            if($i<10){
                $item="0".$i;
            }
            else{
                $item=$i;
            }
            $indi4->addRow([$this->meses[$i]/*$ano_actual.'-'.$i.'-1'*/, $candidatos_contar["cargados"][$item],$candidatos_contar["asociados"][$item]]);
         }
  $report_name4 = 'indicador_reclutamiento';

        \Lava::ComboChart($report_name4, $indi4, [
            'title' => 'Indicador de reclutamiento ('.$ano_actual.')',
            'is3D'   => true,
            'chartArea' => [
                'left' => 60,
                'top' => 100,
                'height' => '70%',
                'width' => '100%'
            ],
            'height' => '450',
            'width' => '900',
            //BackgroundColor Options
            'titleTextStyle' => [
                'color'    => 'rgb(123, 65, 89)',
                'fontSize' => 14
            ],
            'legend' => [
                'position' => 'in'
            ]
        ]);


        $report_reclu=null;
        $search=false;
        $datos=false;
        $array_metodos=[];
            if($request->get('fecha_tenta_ini') != ""){
                $search=true;
                //BUSQUEDA
                 $candidatos_metodos =  DatosBasicos::join("users","users.id","=","datos_basicos.user_id")
                    ->where(function ($where) use ($request) {

                        if($request->get('fecha_tenta_ini') != "") {
                            $rango=explode(" | ", $request->fecha_tenta_ini);
                            $where->whereBetween(DB::raw('DATE_FORMAT(datos_basicos.created_at, \'%Y-%m-%d\')'),[$rango[0],$rango[1]]);
                                }
                            
                    })
                    ->whereNotNull("users.metodo_carga")
                    ->whereRaw('(DATE_FORMAT(datos_basicos.created_at, \'%Y\')='.$ano_actual.')')
                    ->select(
                        'datos_basicos.id','datos_basicos.nombres as nombre' ,'users.metodo_carga',
                        DB::raw('DATE_FORMAT(datos_basicos.created_at, \'%m\') as mes_creacion')
                    )
                    ->get();

        
                $report_reclu = 'indicador_pie';
                $indi5 = \Lava::DataTable();
                $indi5->addStringColumn('Reclutamiento')
                ->addNumberColumn('Porcentaje');

                $slices =[
                  ['offset' => 0.2],
                  ['offset' => 0.10]
                ];


                $metodos=MetodoCarga::get();
                $cantidad_usuarios_metodo=count($candidatos_metodos);
                if($cantidad_usuarios_metodo>0)
                    $datos=true;
                
                
                $array_metodos=[];
                foreach($metodos as $me){
                    $array_metodos[$me->id]=["nombre"=>$me->descripcion,"cantidad"=>0,"avg"=>0];
                    $array_metodos[$me->id]["cantidad"]= $candidatos_metodos->filter(function ($value) use ($me) {
                        return $value->metodo_carga == $me->id;
                    })->count();
                    if($cantidad_usuarios_metodo>0){
                     $array_metodos[$me->id]["avg"]=round($array_metodos[$me->id]["cantidad"]*100/$cantidad_usuarios_metodo,1);
                    }
                }

                for($i=1;$i<=count($array_metodos);$i++){
                     $indi5->addRow([$array_metodos[$i]["nombre"], (int)$array_metodos[$i]["avg"]]);
                }

           
              \Lava::PieChart($report_reclu, $indi5, [
                    'title' => 'Carga reclutamiento',
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


            }


        return view("admin.reportes.indicadores_reclutamiento")->with([
            'report_name4' => $report_name4,
            'search'       =>$search,
            'datos'        =>$datos,
            'array_metodos'=>$array_metodos,
            "report_reclu" =>$report_reclu
        ]);
    }

    public function indicadorTipoProceso(Request $request){

        $clientes=Clientes::pluck("nombre","id")->toArray();
         $usuarios_gestionan=User::join('requerimientos','requerimientos.solicitado_por','=','users.id')->pluck("users.name", "users.id")->toArray();

        if(!isset($request->fecha_inicio)){

           return view("admin.reportes.indicador_tipo_proceso")->with([
            'clientes'    => $clientes,
            'no_search'  =>true,

            'usuarios_gestionan' => $usuarios_gestionan

        ]);

       }

       $data= Requerimiento::join("negocio","requerimientos.negocio_id","=","negocio.id")
       ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
       ->where(function ($sql) use ($request){

            if($request->get("fecha_inicio")!=""){
                $rango=explode(" | ", $request->get("fecha_inicio"));
                $sql->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$rango[0],$rango[1]]);
            }


            if(count($request->get("user_id"))>0){

                $sql->whereIn("requerimientos.solicitado_por",$request->get("user_id"));
            }


            if(count($request->get("cliente_id"))>0){
                $sql->whereIn("clientes.id",$request->get("cliente_id"));
            }
       })
       ->select(
            'requerimientos.id',
            'requerimientos.tipo_proceso_id'

        )

       ->get();


        $tipos_procesos=TipoProceso::where('active',1)->get();

        $report_reclu = 'indicador_pie';
                $indi5 = \Lava::DataTable();
                $indi5->addStringColumn('Vacantes');
                $indi5->addStringColumn('Porcentaje');
                $slices =[
                  ['offset' => 0.2],
                  ['offset' => 0.10]
                ];

                $cantidad_requerimientos=count($data);
          
                
                $array_procesos=[];
                foreach($tipos_procesos as $me){
                    $array_procesos[$me->id]=["nombre"=>$me->descripcion,"cantidad"=>0,"avg"=>0];
                    $array_procesos[$me->id]["cantidad"]= $data->filter(function ($value) use ($me) {
                        return $value->tipo_proceso_id == $me->id;
                    })->count();
                    if(count($data)>0){
                     $array_procesos[$me->id]["avg"]=round($array_procesos[$me->id]["cantidad"]*100/$cantidad_requerimientos,1);
                    }
                }

                for($i=1;$i<=count($array_procesos);$i++){
                     $indi5->addRow([$array_procesos[$i]["nombre"], (int)$array_procesos[$i]["avg"]]);
                }

           
              \Lava::PieChart($report_reclu, $indi5, [
                    'title' => 'Vacantes tipo proceso',
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


        return view("admin.reportes.indicador_tipo_proceso",compact('data','tipos_procesos','report_reclu','clientes','usuarios_gestionan','array_procesos'));

    }

    public function indicadorVencido(Request $request){

        
        if(!isset($request->fecha_inicio)){

           return view("admin.reportes.indicador_vencido_estado")->with([
            'no_search'  =>true,

        ]);

       }

       $data= Requerimiento::join("negocio","requerimientos.negocio_id","=","negocio.id")
       //->join("clientes", "clientes.id", "=", "negocio.cliente_id")
       ->where(function ($sql) use ($request){

            if($request->get("fecha_inicio")!=""){
                $rango=explode(" | ", $request->get("fecha_inicio"));
                $sql->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$rango[0],$rango[1]]);
            }

            if($request->get("fecha_inicio_tentativa")!=""){
                $rango=explode(" | ", $request->get("fecha_inicio_tentativa"));
                $sql->whereBetween(DB::raw('DATE_FORMAT(requerimientos.fecha_tentativa_cierre_req, \'%Y-%m-%d\')'),[$rango[0],$rango[1]]);
            }


            /*if(count($request->get("user_id"))>0){

                $sql->whereIn("requerimientos.solicitado_por",$request->get("user_id"));
            }


            if(count($request->get("cliente_id"))>0){
                $sql->whereIn("clientes.id",$request->get("cliente_id"));
            }*/
       })
       ->select(
            'requerimientos.id',
            'requerimientos.tipo_proceso_id',
            DB::raw('IF(fecha_tentativa_cierre_req<now(),1,0) as vencido')

        )
       ->with('estados')
       ->get();

        $estados_requerimientos=Estados::whereIn('id',['6','7','8','11'])->get();

        $report_reclu = 'indicador_pie';
                $indi5 = \Lava::DataTable();
                $indi5->addStringColumn('Vacantes');
                $indi5->addStringColumn('Porcentaje');
                $slices =[
                  ['offset' => 0.2],
                  ['offset' => 0.10]
                ];

                $cantidad_requerimientos=count($data);
          
                
                $array_estados=[];
                foreach($estados_requerimientos as $me){
                    $array_estados[$me->id]=["nombre"=>$me->descripcion,"cantidad"=>0,"vencidos"=>0,"avg"=>0];

                    $filtrados=$data->filter(function ($value) use ($me) {
                        return $value->estados->last()->estado_tipo->id == $me->id;
                    });

                    $array_estados[$me->id]["cantidad"]=$filtrados->count();
                    /*$array_estados[$me->id]["cantidad"]= $data->filter(function ($value) use ($me) {
                        return $value->estados->last()->estado_tipo->id == $me->id;
                    })->count();*/

                    $array_estados[$me->id]["vencidos"]= $filtrados->filter(function ($value) use ($me) {
                        return $value->vencido;
                    })->count();
                    if(count($data)>0){
                     $array_estados[$me->id]["avg"]=round($array_estados[$me->id]["cantidad"]*100/$cantidad_requerimientos,1);
                    }
                }

                /*for($i=1;$i<=count($array_estados);$i++){
                     $indi5->addRow([$array_estados[$i]["nombre"], (int)$array_estados[$i]["avg"]]);
                }*/
                $vencidos=0;
                $porcentaje_vencidos=0;
                $porcentaje_no=0;
                if($cantidad_requerimientos){
                    $vencidos=$data->filter(function($value){
                    return $value->vencido;
                    })->count();

                    $porcentaje_vencidos=$vencidos*100/$cantidad_requerimientos;
                    $porcentaje_no=100-$porcentaje_vencidos;
                }
                

                
                $indi5->addRow(['No vencidos',$porcentaje_no]);
                $indi5->addRow(['Vencidos', $porcentaje_vencidos]);
           
              \Lava::PieChart($report_reclu, $indi5, [
                    'title' => 'Vencimiento de requerimientos',
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


        return view("admin.reportes.indicador_vencido_estado",compact('data','estados_requerimientos','report_reclu','array_estados'));

    }

    public function indicadorSeguimiento(Request $request){
        if(!isset($request->fecha_inicio)){

           return view("admin.reportes.indicador_seguimiento")->with([
            'no_search'  =>true,

            ]);

        }

  


        $data=Requerimiento::where(function ($sql) use ($request){

            if($request->get("fecha_inicio")!=""){
                $rango=explode(" | ", $request->get("fecha_inicio"));
                $sql->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$rango[0],$rango[1]]);
            }
            else{
                $sql->where('requerimientos.id',-1);
            }

      
       })
        ->select(
                'requerimientos.id',
                'requerimientos.num_vacantes',
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
                //metodo para dias_vencidos
                
//-------------------------------------------------------------------------------------
                //DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
                DB::raw('(select y.estado as estado_id from estados_requerimiento y inner join estados x on y.estado=x.id where y.req_id=requerimientos.id order by y.created_at desc limit 1) as estado_req_id'),
                
                
                DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as vacantes_reales '),
                 DB::raw('requerimientos.num_vacantes - (select count(*) from firma_contratos where terminado in(1,2) and estado not in(0) and req_id=requerimientos.id ) as vacantes_reales_asistente'),
                 DB::raw('(select count(*) from firma_contratos where terminado in(1,2) and estado not in(0) and req_id=requerimientos.id ) as contratados')
                
                
                )
                ->get();



        $report_barras = 'reporte_barras';
        $indi7 = \Lava::DataTable();
        $indi7->addStringColumn('Barras')
                ->addNumberColumn('Cantidad');
                //->addNumberColumn('ANS');

        /*$slices =[
          ['offset' => 0.2],
          ['offset' => 0.10]
        ];*/
        
        $indi7->addRow(["Vacantes",$data->sum('num_vacantes')]);
        $indi7->addRow(["Env. Entrevistas",$data->sum('cant_enviados_entrevista')]);
        $indi7->addRow(["Env. cliente",$data->sum('cant_enviados_aprobar_cliente')]);
        $indi7->addRow(["Referenciación",$data->sum('cant_enviados_referenciacion')]);
        $indi7->addRow(["Env. exámenes",$data->sum('cant_enviados_examenes')]);
        $indi7->addRow(["Env. pruebas",$data->sum('cant_enviados_pruebas')]);
        $indi7->addRow(["Citados",$data->sum('cant_citados')]);
        $indi7->addRow(["Cand. aplicaron",$data->sum('candidatos_aplicados')]);
        $indi7->addRow(["Contratados",$data->sum('contratados')]);
        



        \Lava::BarChart($report_barras, $indi7, [
            'title' => 'Cantidades acumuladas del resultado',
            'is3D' => true,
            'pieSliceText' => 'Porcentaje',
            //'slices' => $slices,
            'fontSize'=> 11,
            'colors'=> ['purple'],
            'chartArea' => [
              //'left' => '20%',
              //'top' => 40,
              //'width' => '80%',
              //'height' => '300'
            ],
            
        ]);

        return view("admin.reportes.indicador_seguimiento",compact('data','report_barras'));

  

    }

    public function indicadorSeleccion(Request $request){

        



        return view('admin.indicadores.indicador_seleccion');
    }

    public function indicadorSeleccionSearch(Request $request){
        $found=false;
        $fecha_rango=$request->fecha_rango;
        $rango=explode(" | ", $fecha_rango);
        if($fecha_rango!=""){
        $requerimientos_rango=Requerimiento::join('ciudad', function ($join) {
            $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                    ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->leftjoin("agencias","agencias.id","=","ciudad.agencia")
            ->where(function($sql)use($rango){
                if($rango!=""){

                   
                   $sql->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[$rango[0],$rango[1]]);
                }
            
            })
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->whereNotIn('estados_requerimiento.estado',[1,2,17])
            ->select(
                'agencias.descripcion as agencia',
                DB::raw('(select sum(requerimientos.num_vacantes)) as cantidad'),
                DB::raw('(select sum((select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id))) as cant_enviados_contratacion'),
                DB::raw('(select sum((select count(*) from requerimiento_cantidato where requerimiento_cantidato.estado_candidato=12 and requerimiento_id=requerimientos.id))) as cant_contratados')
            )
            ->groupBy('ciudad.agencia')
            ->get();
   
        }
        else{
            $requerimientos_rango=null;
        }

        //Meses anteriores
        $requerimientos_anteriores=Requerimiento::join('ciudad', function ($join) {
            $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                    ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->leftjoin("agencias","agencias.id","=","ciudad.agencia")
            ->whereBetween(DB::raw('DATE_FORMAT(requerimientos.created_at, \'%Y-%m-%d\')'),[date("Y-m-d",strtotime($rango[0]."- 6 month")),$rango[0]])
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->whereNotIn('estados_requerimiento.estado',[1,2,17])
            ->select(
                'agencias.descripcion as agencia',
                DB::raw('(select sum(requerimientos.num_vacantes)) as cantidad'),
                DB::raw('(select sum((select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id))) as cant_enviados_contratacion'),
                DB::raw('(select sum((select count(*) from requerimiento_cantidato where requerimiento_cantidato.estado_candidato=12 and requerimiento_id=requerimientos.id))) as cant_contratados')
            )
            ->groupBy('ciudad.agencia')
            ->get();
           


        $porcentaje_contratadas=0;
        if(count($requerimientos_anteriores) || count($requerimientos_rango)){
            $porcentaje_contratadas=($requerimientos_anteriores->sum('cant_contratados')+$requerimientos_rango->sum('cant_contratados'))*100/($requerimientos_anteriores->sum('cantidad')+ $requerimientos_rango->sum('cantidad'));
            $found=true;
        }
        
        return response()->json(["success"=>true,'labels'=>['pie'=>['Contratadas','Vencidas'],'bar'=>$requerimientos_rango->pluck('agencia')],'colors'=>['pie'=>["rgba(114, 46, 135,.5)","rgba(182, 61, 95,.5)"],'bar'=>["rgba(114, 46, 135,.5)","rgba(182, 61, 95,.5)"]],'data'=>['pie'=>[round($porcentaje_contratadas,2),round(100-$porcentaje_contratadas,2)],'bar'=>json_encode([[label=> 'Solicitadas',"data"=>$requerimientos_rango->pluck('cantidad'),"borderColor"=>'#FF6384',"backgroundColor"=> 'rgba(114, 46, 135,.5'],["label"=> 'Envios a contratación',"data"=> $requerimientos_rango->pluck('cant_enviados_contratacion'),"borderColor"=>'#63FF84',"backgroundColor"=> 'rgba(182, 61, 95,.5)']])],'view' => view('admin.indicadores.include._search_results_seleccion', compact("requerimientos_rango","mes_anterior","requerimientos_anteriores","found"))->render()
        ]);
    }

}