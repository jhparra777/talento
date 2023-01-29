<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\FuncionesGlobales;
use App\Models\CargoEspecifico;
use App\Models\CargoGenerico;
use App\Models\CentroTrabajo;
use App\Models\Ciudad;
use App\Models\EstadoCivil;
use App\Models\EstadosRequerimientos;
use App\Models\Genero;
use App\Models\MotivoRequerimiento;
use App\Models\NivelEstudios;
use App\Models\Requerimiento;
use App\Models\SolicitudAreaFuncional;
use App\Models\SolicitudCentroBeneficio;
use App\Models\SolicitudCentroCosto;
use App\Models\Solicitudes;
use App\Models\SolicitudRecursos;
use App\Models\SolicitudSedes;
use App\Models\SolicitudSubArea;
use App\Models\SolicitudTrazabilidad;
use App\Models\SolicitudEstado;
use App\Models\SolicitudUserPasos;
use App\Models\TipoContrato;
use App\Models\TipoExperiencia;
use App\Models\TipoJornada;
use App\Models\TipoProceso;
use App\Models\User;
use App\Models\JefeInmediato;
use App\Models\Indicadores;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use \Cache;


class SolicitudController extends Controller
{
    /**
     * Display a listing of the resource.
     * autor: apolorubiano@gmail.com
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id=NULL)
    {
      //  dd($id);
       
        $estado=$request->estado_id;

        $user = $this->user; //Usuario autenticado

        $estados=[""=>"Seleccion"]+SolicitudEstado::where("id","!=",2)->pluck("descripcion", "id")->toArray();

        //EL SUPER ADMINISTTADOR puede ver todas las solicitudes
        if($user->inRole("SUPER ADMINISTRADOR")){
            $solicitudes = Solicitudes::where(function ($query) use ($estado,$id) {
               
                if ((int) $estado > 0 && $estado != "") {
                    $query->where("solicitudes.estado", $estado);
                }

                if (!is_null($id)) {
                    $query->where("solicitudes.id", $id);
                }

            })
            ->get()
            ->sortByDesc('id');
        }
        else{
            //Consultamos lista de solicitudes que puede ver el usuario autenticado
            $solicitudes = Solicitudes::
            join('solicitudes_trazabilidad', 'solicitudes_trazabilidad.solicitud_id', '=', 'solicitudes.id')
            ->where('solicitudes_trazabilidad.user_id', $user->id)
            ->where(function ($query) use ($estado,$id) {
               
                if ((int) $estado > 0 && $estado != "") {
                    $query->where("solicitudes.estado", $estado);
                }

                if (!is_null($id)) {
                    $query->where("solicitudes.id", $id);
                }
            })
            ->select('solicitudes.*')
            ->orderBy('solicitudes.id', 'desc')
            ->groupBy('solicitudes_trazabilidad.solicitud_id')
            ->get();
        }
       
        //Validamos si el ususario tiene permiso de crear solicitudes
        $userSolicitudes = SolicitudUserPasos::
            where('user_solicitante', $user->id)
            ->get();

        return view('admin.aprobaciones.solicitud.index', compact('solicitudes', 'user', 'userSolicitudes','estados'));
    }


    //Enviar email de aviso de proximo vencimiento de solicitudes
    public function email_proximo_vencimiento(){
            $solicitudes = Solicitudes::all()->sortByDesc('id');
            foreach($solicitudes as $solicitud){
                 $fechaHoy = date("Y-m-d H:i:s");
                 $fechaHoy=Carbon::parse($fechaHoy);
                 $diferencia=$fechaHoy->diffInDays($solicitud->created_at);
               
                if($diferencia==6){
                   
                    $solicitudTrazabilidad = SolicitudTrazabilidad::
                    where('solicitud_id', $solicitud->id)
                    ->orderBy('id','desc')
                    ->first();          
                    $user_enviar=User::find($solicitudTrazabilidad->user_id);//email para enviar a aprobador

                    $email=$user_enviar->email;
                    Mail::send('admin.email-proximo-vencimiento', [
                        'email'=>$email,
                        'solicitud' => $solicitud,
                    ], function ($message) use ($solicitud,$email) {
                        $message->to([$email,"jorge.ortiz@t3rsc.co","javier.chiquito@t3rsc.co"], '$nombre - T3RS')
                            ->subject("Aprobación solicitud # $solicitud->id proxima a vencer")
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });

                }
            }
            

    }
/**
    *Verificar que solicitudes deben ser vencidas
*/
    public function verificar_vencimiento(){
      $solicitudes = Solicitudes::all()->sortByDesc('id');
      
        foreach($solicitudes as $solicitud){
        $fechaHoy = date("Y-m-d H:i:s");
          $fechaHoy=Carbon::parse($fechaHoy);
          $diferencia=$fechaHoy->diffInDays($solicitud->created_at);
               
            if($diferencia>15){
             $solicitud->estado=10;
             $solicitud->save();
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function nuevaSolicitud()
    {
        $cargo_especifico = ["" => "Seleccionar"] + CargoEspecifico::orderBy('descripcion', 'asc')
            ->pluck('descripcion', 'id')
            ->toArray();
       
        $sede = ["" => "Seleccionar"] + SolicitudSedes::where("estado", 1)->pluck("descripcion", "id")->toArray();

        $areaFunciones = ["" => "Seleccionar"] + SolicitudAreaFuncional::where("estado", 1)->pluck("descripcion", "id")->toArray();
       //$subArea       = ["" => "Seleccionar"]+ SolicitudSubArea::where("estado", 1)->pluck("descripcion", "id")->toArray();
        $subArea=array();

        $centro_beneficio = ["" => "Seleccionar"]+ SolicitudCentroBeneficio::where("estado", 1)
            ->pluck("descripcion", "id")
            ->toArray();

        $centro_costo = ["" => "Seleccionar"]+SolicitudCentroCosto::where("estado", 1)
            ->pluck("descripcion", "id")
            ->toArray();

        $user = $this->user;

        return view('admin.aprobaciones.solicitud.modal.nueva-solicitud', compact('cargo_especifico','subArea','user', 'sede', 'areaFunciones','centro_beneficio','centro_costo'));
    }

    /**
     * Mostrar el resto de campos al momento d crear una nueva solicitud
     **/
    public function ajaxSolicitudNueva(Request $request)
    {
        $motivo = [""=>"Seleccionar"]+MotivoRequerimiento::where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();
             $jefes_inmediatos=[""=>"Seleccionar"]+JefeInmediato::where("active",1)->pluck("nombre","id")->toArray();
        $cargos = CargoGenerico::where("estado", 1)
            ->pluck("descripcion", "id")
            ->toArray();

        $tipoProceso = TipoProceso::
            where("active", 1)
            ->orderBy("descripcion", "asc")
            ->pluck("descripcion", "id")
            ->toArray();

        $tipo_contrato = \Cache::remember('tipo_contrato','100', function(){
            return TipoContrato::
            where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();
        });

        $tipo_experiencia = TipoExperiencia::
            where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();

        $tipoGenero = \Cache::remember('tipoDocumento','1000', function(){ 
            return Genero::
            where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();
        });

        $motivo_requerimiento = MotivoRequerimiento::
            where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();

        $tipo_jornada = TipoJornada::
            where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();

        $cargo_especifico = CargoEspecifico::find($request->cargo_especifico_id);

        $ctra_x_clt_codigo = $cargo_especifico->ctra_x_clt_codigo;
        $cargo_generico_id = $cargo_especifico->cargo_generico_id;
        $centro_trabajo    = CentroTrabajo::
            pluck("nombre_ctra", "id")
            ->toArray();

        $nivel_estudio = \Cache::remember('nivel_estudio','100', function(){
          return NivelEstudios::
            orderBy('descripcion', 'asc')
            ->select(DB::raw("upper(descripcion) as descripcion"), 'id')
            ->pluck("descripcion", "id")
            ->toArray();
        });

        $edad_minima = \Cache::rememberForever('edad_minima', function(){
           return ["16" => "Menor de Edad"];
        });

        for ($i = 18; $i <= 50; $i++) {
            $edad_minima[$i] = $i;
        }
        $edad_minima_selected = $cargo_especifico->cxclt_edad_min;

        $edad_maxima = [];
        for ($i = 18; $i <= 50; $i++) {
            $edad_maxima[$i] = $i;
        }
        $edad_maxima += ["51" => "Mayor de 50 años"];
        $edad_maxima_selected = $cargo_especifico->cxclt_edad_max;

        $generos = \Cache::remember('generos','1000', function(){
            return Genero::
            orderBy('id', 'desc')
            ->pluck("descripcion", "id")
            ->toArray();
        });

        $genero_selected = $cargo_especifico->cxclt_genero;
        $estados_civiles = \Cache::remember('estados_civiles','100', function(){
           return EstadoCivil::
            orderBy('codigo', 'asc')
            ->select(DB::raw("upper(descripcion) as descripcion"), 'id')
            ->pluck('descripcion', "id")
            ->toArray();
        });

        return view('admin.aprobaciones.solicitud.modal.ajax-solicitud-nueva', compact('cargo_generico_id', 'ctra_x_clt_codigo', 'centro_trabajo', 'tipoProceso', 'tipo_contrato', 'tipo_experiencia', 'tipoGenero', 'motivo_requerimiento', 'tipo_jornada', 'motivo_requerimiento_id', 'nivel_estudio', 'edad_minima', 'edad_maxima', 'generos', 'estados_civiles','motivo','jefes_inmediatos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardarSolicitud(Request $request)
    {
        //Guardar datos de la solicitud
      if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co"){

        $validator = $this->validate($request,[
         'archivo_documento'=>'required',
         'funciones_realizar'=>'required',
         'motivo_requerimiento_id'=>'required',
            'ciudad_id'=>'required',
            'area_id' => 'required',
            'subarea_id'=>'required',
            'solicitado_por_txt'=>'required',
            'centro_beneficio_id'=>'required',
            'centro_costo_id'=> 'required',
            'cargo_especifico_id'=>'required',
            'jefe_inmediato' =>'required',
            'tipo_contrato_id'=>'required',
            'motivo_requerimiento_id'=>'required',
            'observaciones' => 'required',
            'recurso' => 'required',
            'tiempo_contrato' => 'required_if:tipo_contrato_id,==,7',

        ]);

        }else{
         
         $validator = $this->validate($request,[
         'archivo_documento'=>'required',
         'funciones_realizar'=>'required',
         'motivo_requerimiento_id'=>'required']);
        
        }


        $solicitud = new Solicitudes;
        $solicitud->fill($request->all() + ["user_id" => $this->user->id, "estado" => 1]);
        $solicitud->save();
       
        if(count($request->recurso) > 0){
          foreach($request->recurso as $key => $value) {
           
           if($value != ""){
            $recurso= new SolicitudRecursos();
            $recurso->id_solicitud = $solicitud->id;
            $recurso->recurso_necesario= $value;
            $recurso->save();
           }

         }
        }

        //Validar si llego archivo y si es asi guardarlo
        if ($request->hasFile('archivo_documento')) {
            $imagen         = $request->file("archivo_documento");
            $extencion      = $imagen->getClientOriginalExtension();
            $name_documento = "documento_" . $solicitud->id . "." . $extencion;
            $imagen->move("documentos_solicitud", $name_documento);
            $solicitud->documento = $name_documento;
            $solicitud->save();
        }

        //Guardar trazabilidad de la solicitud
        SolicitudTrazabilidad::create([
            "solicitud_id" => $solicitud->id,
            "user_id"      => $this->user->id,
            "accion"       => "Solicitud",
            "observacion"  => "",
        ]);

        //Asignar al usuario compensar
        $asignarA = SolicitudUserPasos::
            where('user_solicitante', $solicitud->user_id)
            ->first();

        //Guardar trazabilidad de la solicitud
        SolicitudTrazabilidad::create([
            "solicitud_id" => $solicitud->id,
            "user_id"      => $asignarA->user_valora,
        ]);

        $user = $this->user; //Usuario autenticado

        $funcionesGlobales = new FuncionesGlobales();
        if (isset($funcionesGlobales->sitio()->nombre)) {
            if ($funcionesGlobales->sitio()->nombre != "") {
                $nombre = $funcionesGlobales->sitio()->nombre;
            } else {
                $nombre = "Desarrollo";
            }
        }
        //Email Notificacion para los

        Mail::send('admin.email-nueva-solicitud', [
            'user'      => $user,
            'solicitud' => $solicitud,
        ], function ($message) use ($user, $solicitud, $nombre) {
           $message->to(['yair.gutierrez@komatsu.com.co', "karen.amador@komatsu.com.co", "javier.chiquito@t3rsc.co","maribel.martinez@komatsu.com.co",$user->email], "$nombre - T3RS")
           // $message->to('javier5chiquito@gmail.com', "$nombre - T3RS")
                ->subject("Valoración solicitud # $solicitud->id")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        return response()->json(["success" => true]);
    }

    /**
     * Compensar solicitud
     **/
    public function compensarSolicitud(Request $request)
    {
        $solicitudes = Solicitudes::
            where('id', $request->get("id"))
            ->first();

        return view('admin.aprobaciones.solicitud.modal.compensar-solicitud', compact('solicitudes'));
    }

    /**
     * Compensar se le asigna salario
     */
    public function actualizarSolicitud(Request $request)
    {

        $salario = str_replace(',', '', $request->salario); //Quitar formato

        $solicitud = Solicitudes::find($request->get("id"));

        $solicitud->salario = $salario; //Guardar valoración

        //Validamos que no este más alante de compensado
        if ($solicitud->estado == 1) {
            $solicitud->estado = 2; //estado 2 compensado
        }

        $solicitud->save(); //Guardar estado y salario

        $user = $this->user; //Usuario autenticado
 //if(route('home')== "http://demo.t3rsc.co"){dd($request->all());}
        //Guardar trazabilidad de valoracion
        $solicitudTrazabilidad = SolicitudTrazabilidad::
            where('solicitud_id', $request->get("id"))
            //->where('user_id', $this->user->id)
            ->orderBy('id','desc')
            ->first();


        $solicitudTrazabilidad->fill([
            "accion"      => "Valorado",
            "observacion" => "Se realiza la valoración por " . $request->salario,
            "user_id"     =>$this->user->id
        ]);
         $solicitudTrazabilidad->save();
        //Asignar al usuario jefe de solicitud
        $asignarA = SolicitudUserPasos::
            where('user_solicitante', $solicitud->user_id)
            ->first();

        //Validamos si el usuario que sigue es igual de rango mayor a menor
        switch ($asignarA->user_jefe_solicitante) {
            case $asignarA->user_gg: //Gerente general
                SolicitudTrazabilidad::create([
                    "solicitud_id" => $solicitud->id,
                    "user_id"      => $asignarA->user_gg,
                ]);
                $solicitud->estado = 8;
                
                break;
            case $asignarA->user_rhh: //Recursos humano
                SolicitudTrazabilidad::create([
                    "solicitud_id" => $solicitud->id,
                    "user_id"      => $asignarA->user_rhh,
                ]);
                $solicitud->estado = 7;
               
                break;
            case $asignarA->user_gerente_area: //Segunda aprobacion
                SolicitudTrazabilidad::create([
                    "solicitud_id" => $solicitud->id,
                    "user_id"      => $asignarA->user_gerente_area,
                ]);
                $solicitud->estado = 4;
                
                break;
            default: //Default es primera aprobacion
                SolicitudTrazabilidad::create([
                    "solicitud_id" => $solicitud->id,
                    "user_id"      => $asignarA->user_jefe_solicitante,
                ]);
                $solicitud->estado = 3;
        }

        $solicitud->save(); //guardar estados

       
        $funcionesGlobales = new FuncionesGlobales();
        if (isset($funcionesGlobales->sitio()->nombre)) {
            if ($funcionesGlobales->sitio()->nombre != "") {
                $nombre = $funcionesGlobales->sitio()->nombre;
            } else {
                $nombre = "Desarrollo";
            }
        }

        //Email Notificacion para los

        Mail::send('admin.email-valorar-solicitud', [
            'user'      => $user,
            'solicitud' => $solicitud,
        ], function ($message) use ($user, $solicitud) {
            $message->to([$solicitud->user()->email, "javier.chiquito@t3rsc.co","karen.amador@komatsu.com.co"], '$nombre - T3RS')
            //$message->to('javier5chiquito@gmail.com', ' - T3RS')
                ->subject("Información solicitud # $solicitud->id")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });
         $user_enviar=User::find($asignarA->user_jefe_solicitante);//email para enviar a aprobador
                $email=$user_enviar->email;
        Mail::send('admin.email-aprobar-solicitud', [
            'email'=>$email,
            'user'      => $user,
            'solicitud' => $solicitud,
        ], function ($message) use ($user, $solicitud,$email) {
            $message->to([$email,"javier.chiquito@t3rsc.co"], '$nombre - T3RS')
            //$message->to('javier5chiquito@gmail.com', '$nombre - T3RS')
                ->subject("Aprobación solicitud # $solicitud->id")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        return response()->json(["success" => true]);
    }

    /**
     * Modal aprobaciones, liberaciones y detalle
     */

    public function modalDetalleSolicitud(Request $request)
    {
         $solicitudes = Solicitudes::
            where('id', $request->get("id"))
            ->first();

        $flujo=SolicitudUserPasos::where("user_solicitante",$solicitudes->user_id)->first();

         $trazabilidad = SolicitudTrazabilidad::
            where('solicitud_id', $request->id)
            ->orderBy('id','desc')
            ->get();
        return view('admin.aprobaciones.solicitud.modal.detalle-solicitud', compact('solicitudes','trazabilidad','flujo'));
    }
    
    public function modalAprobarSolicitud(Request $request)
    {
        
        $vector="";

        $solicitud = Solicitudes::find($request->id);
         $motivo = [""=>"Seleccionar"]+MotivoRequerimiento::where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();
        $jefes_inmediatos=[""=>"Seleccionar"]+JefeInmediato::where("active",1)->pluck("nombre","id")->toArray();
        $cargos = CargoGenerico::where("estado", 1)
            ->pluck("descripcion", "id")
            ->toArray();

        $tipoProceso = TipoProceso::
            where("active", 1)
            ->orderBy("descripcion", "asc")
            ->pluck("descripcion", "id")
            ->toArray();

        $tipo_contrato = TipoContrato::
            where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();

        $tipo_experiencia = TipoExperiencia::
            where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();

        $tipoGenero = \Cache::remember('tipoGenero','1000', function(){
           return Genero::
            where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();
        });

        $motivo_requerimiento = \Cache::remember('motivo_requerimiento','100', function(){
         
         return MotivoRequerimiento::
            where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();
        });

        $tipo_jornada = TipoJornada::
            where("active", 1)
            ->pluck("descripcion", "id")
            ->toArray();
        $cargos_especificos = CargoEspecifico::orderBy('descripcion', 'asc')
            ->pluck('descripcion', 'id')
            ->toArray();
        $cargo_especifico  = CargoEspecifico::find($solicitud->cargo_especifico_id);
        $ctra_x_clt_codigo = $cargo_especifico->ctra_x_clt_codigo;
        $cargo_generico_id = $cargo_especifico->cargo_especifico_id;

        $centro_trabajo = CentroTrabajo::
            pluck("nombre_ctra", "id")
            ->toArray();

        $nivel_estudio = \Cache::remember('nivel_estudio','100', function(){
            return NivelEstudios::
            orderBy('descripcion', 'asc')
            ->select(DB::raw("upper(descripcion) as descripcion"), 'id')
            ->pluck("descripcion", "id")
            ->toArray();
        });

        $edad_minima = ["16" => "Menor de Edad"];
        for ($i = 18; $i <= 50; $i++) {
            $edad_minima[$i] = $i;
        }
        $edad_minima_selected = $cargo_especifico->cxclt_edad_min;

        $edad_maxima = [];
        for ($i = 18; $i <= 50; $i++) {
            $edad_maxima[$i] = $i;
        }
        $edad_maxima += ["51" => "Mayor de 50 años"];
        $edad_maxima_selected = $cargo_especifico->cxclt_edad_max;
        $generos              = Genero::
            orderBy('id', 'desc')
            ->pluck("descripcion", "id")
            ->toArray();

        $genero_selected = $cargo_especifico->cxclt_genero;

        $estados_civiles = \Cache::remember('estados_civiles','1000', function(){
           return EstadoCivil::
            orderBy('codigo', 'asc')
            ->select(DB::raw("upper(descripcion) as descripcion"), 'id')
            ->pluck('descripcion', "id")
            ->toArray();
        });

        $trazabilidad = SolicitudTrazabilidad::
            where('solicitud_id', $request->id)
            ->orderBy('id', 'desc')
            ->get();

        $sede = SolicitudSedes::
            where("estado", 1)
            ->pluck("descripcion", "id")
            ->toArray();

        $areaFunciones = SolicitudAreaFuncional::
            where("estado", 1)
            ->pluck("descripcion", "id")
            ->toArray();

        $subArea = SolicitudSubArea::
            where("estado", 1)
            ->pluck("descripcion", "id")
            ->toArray();


        $recursos_solicitud = SolicitudRecursos::
               where('id_solicitud',$solicitud->id)
            ->orderBy('recurso_necesario', 'asc')
            ->pluck("recurso_necesario", "id")
            ->toArray(); //array de recursos necesarios para la solicitud

        $recursos = \Cache::rememberForever('recursos', function(){
              return array('Computador de mesa','Computador portatil','Celular','Licencia SAP','Modem','Puesto de Trabajo'); //arrays de recursos que estan
        });
        //dd($recursos);
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
     //  dd($vector);
        return view('admin.aprobaciones.solicitud.modal.aprobar-solicitud', compact('solicitud', 'cargo_generico_id', 'ctra_x_clt_codigo', 'centro_trabajo', 'tipoProceso', 'tipo_contrato', 'tipo_experiencia', 'tipoGenero', 'motivo_requerimiento', 'tipo_jornada', 'motivo_requerimiento_id', 'nivel_estudio', 'edad_minima', 'edad_maxima', 'generos', 'estados_civiles', 'trazabilidad', 'sede', 'areaFunciones', 'subArea', 'cargos','cargos_especificos','motivo','jefes_inmediatos','vector'));
    }

    /**
     *  apolorubiano@gmail.com
     *  Aprobar solicitud paso 2 - 3
     **/
    public function aprobarSolicitud(Request $request)
    {
        //corregir trazabilidad
        $solicitud = Solicitudes::find($request->get("id"));
        $solicitud2=$solicitud;
        $solicitud->fill($request->all()); //Actualizar solicitud
        $solicitud->save();
        $solicitud = Solicitudes::find($request->get("id"));
        $respuesta=array_diff($solicitud->toArray(),$solicitud2->toArray());
        if(count($respuesta)){
                dd("hubo modificacion");
        }else{

         $solicitudTrazabilidad = SolicitudTrazabilidad::
            where('solicitud_id', $request->get("id"))
            ->where('user_id', $this->user->id)
            ->first();

         if ($solicitud->estado == 7) {
            //Asignar al usuario jefe de solicitud
            $asignarA = SolicitudUserPasos::
                where('user_solicitante', $solicitud->user_id)
                ->first();

            //Guardar trazabilidad de solicitud
            $solicitudTrazabilidad->fill([
             "id_solicitud" => $solicitud->id,
             "id_user"      => $asignarA->user_gg,
             "accion"       => "Aprobacion 3",
             "observacion"  => $request->observacion_aprobacion]);

            SolicitudTrazabilidad::create([
                "solicitud_id" => $solicitud->id,
                "user_id"      => $asignarA->user_gg,
            ]);
            $solicitud->estado = 8;
            $user_envio        = User::find($asignarA->user_gg);

            $solicitud->save();
        } elseif ($solicitud->estado == 4) {
            //Asignar al usuario jefe de solicitud
            $asignarA = SolicitudUserPasos::
                where('user_solicitante', $solicitud->user_id)
                ->first();
            //Guardar trazabilidad de solicitud
            $solicitudTrazabilidad->fill([
              "id_solicitud" => $solicitud->id,
              "id_user"      => $this->user->id,
              "accion"       => "Aprobacion 2",
              "observacion"  => $request->observacion_aprobacion]);

            switch ($asignarA->user_gerente_area) {
                case $asignarA->user_gg:
                    SolicitudTrazabilidad::create([
                        "solicitud_id" => $solicitud->id,
                        "user_id"      => $asignarA->user_gg,
                    ]);
                    $solicitud->estado = 8;
                    $user_envio        = User::find($asignarA->user_gg);
                    //dd("Jefe solicitante es igual al gerente general");
                    break;
                default:
                    SolicitudTrazabilidad::create([
                        "solicitud_id" => $solicitud->id,
                        "user_id"      => $asignarA->user_rhh,
                    ]);
                    $solicitud->estado = 7; //EStado 3 aprobado 1
                    $user_envio        = User::find($asignarA->user_rhh);
            }

            $solicitud->save();
        } elseif ($solicitud->estado == 3) {
           // Guardar trazabilidad de solicitud
            $solicitudTrazabilidad->fill([
              "accion"      => "Aprobacion 1",
             "observacion" => $request->observacion_aprobacion]);

            //Asignar al usuario gerente de area
            $asignarA = SolicitudUserPasos::
                where('user_solicitante', $solicitud->user_id)
                ->first();

            switch ($asignarA->user_jefe_solicitante) {
                case $asignarA->user_gg:
                    SolicitudTrazabilidad::create([
                        "solicitud_id" => $solicitud->id,
                        "user_id"      => $asignarA->user_gg,
                    ]);
                    $solicitud->estado = 8;
                    $user_envio        = User::find($asignarA->user_gg);
                    //dd("Jefe solicitante es igual al gerente general");
                    break;
                case $asignarA->user_rhh:
                case $asignarA->user_gerente_area:
                    SolicitudTrazabilidad::create([
                        "solicitud_id" => $solicitud->id,
                        "user_id"      => $asignarA->user_rhh,
                    ]);
                    $solicitud->estado = 7; //EStado 3 aprobado 1
                    $user_envio        = User::find($asignarA->user_rhh);
                    break;
                default:
                    if($asignarA->user_rhh==$asignarA->user_gerente_area){
                            SolicitudTrazabilidad::create([
                            "solicitud_id" => $solicitud->id,
                            "user_id"      => $asignarA->user_rhh,
                        ]);
                        $solicitud->estado = 7; //EStado 3 aprobado 1
                        $user_envio        = User::find($asignarA->user_rhh);
                    }
                    else{
                        SolicitudTrazabilidad::create([
                            "solicitud_id" => $solicitud->id,
                            "user_id"      => $asignarA->user_gerente_area,
                        ]);
                        $solicitud->estado = 4; //estado 2 compensado
                        $user_envio        = User::find($asignarA->user_gerente_area);
                     }
            }
        } else {
            $mensaje = "La solicitud tiene que estar en estado valorado para realizar aprobación";
            return response()->json(["success" => false, "mensaje" => $mensaje]);
        }

        $solicitudTrazabilidad->save();
        $solicitud->save();

        $user    = $this->user;
        $mensaje = "La solicitud se aprobó correctamente.";
      
   
        Mail::send('admin.email-aprobar-solicitud', [
            'user'      => $user,
            'solicitud' => $solicitud,
        ], function ($message) use ($user_envio, $solicitud) {
           $message->to([$user_envio->email, "javier.chiquito@t3rsc.co"], '$nombre - T3RS')
          //$message->to('javier5chiquito@gmail.com', '$nombre - T3RS')
                ->subject("Aprobación solicitud # $solicitud->id")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        return response()->json(["success" => true, "mensaje" => $mensaje]);

        }
    }
    /**
     * apolorubiano@gmail.com
     *  Pendiente solicitud
     **/
    public function pendienteSolicitud(Request $request)
    {
        $dias         = 20;
        $solicitud    = Solicitudes::find($request->get("id"));
        $fecha        = Carbon::now();
        $fechaAddDay  = $fecha->addDay($dias);
        $fechaSumados = $fechaAddDay->format('Y-m-d');
        $solicitud->fill(["estado" => 6, "fecha_pendiente" => $fechaSumados]);
        $solicitud->save();

        //Guardar trazabilidad de solicitud
        SolicitudTrazabilidad::create([
            "solicitud_id" => $solicitud->id,
            "user_id"      => $this->user->id,
            "accion"       => "Pendiente",
            "observacion"  => $request->observacion,
        ]);
         $user    = $this->user;

        Mail::send('admin.email-pendiente-solicitud', [
            'user'      => $user,
            'solicitud' => $solicitud,
        ], function ($message) use ($user, $solicitud) {
            $message->to([$solicitud->user()->email, "javier.chiquito@t3rsc.co","karen.amador@komatsu.com.co"], '$nombre - T3RS')
            //$message->to('javier5chiquito@gmail.com', '$nombre - T3RS')
                ->subject("Informacion solicitud # $solicitud->id")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        return response()->json(["success" => true, "fecha" => $fechaSumados]);
    }

    /**
     * apolorubiano@gmail.com
     * Rechazar solicitud
     **/
    public function rechazarSolicitud(Request $request)
    {
        $solicitud = Solicitudes::find($request->get("id"));
        $solicitud->fill($request->all() + ["estado" => 5]);
        $solicitud->save();

        //Guardar trazabilidad de solicitud
        SolicitudTrazabilidad::create([
            "solicitud_id" => $solicitud->id,
            "user_id"      => $this->user->id,
            "accion"       => "Rechazado",
            "observacion"  => $request->observacion_aprobacion,
        ]);
        $user = $this->user;


        Mail::send('admin.email-rechazar-solicitud', [
            'user'      => $user,
            'solicitud' => $solicitud,
            'motivo'    => $request->observacion_aprobacion,
        ], function ($message) use ($user, $solicitud) {
            
            $message->to([$solicitud->user()->email,"javier.chiquito@t3rsc.co","karen.amador@komatsu.com.co"], '$nombre - T3RS')
            //$message->to('javier5chiquito@gmail.com', '$nombre - T3RS')
                ->subject("Informacion solicitud # $solicitud->id")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        return response()->json(["success" => true, "mensaje" => "Se rechazo la solicitud."]);
    }

    /**
     * apolorubiano@gmail.com
     *  Liberar solicitud
     **/
    public function liberarSolicitud(Request $request)
    {
        $solicitud = Solicitudes::find($request->get("id"));

        $pasoSolicitud = SolicitudTrazabilidad::
            where('solicitud_id', $solicitud->id)
            ->where('user_id', $this->user->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($solicitud->estado == 7 || $solicitud->estado == 8) {
            $solicitud->fill(["estado" => 9]);
            $solicitud->save();

            //Guardar trazabilidad de solicitud
            SolicitudTrazabilidad::create([
                "solicitud_id" => $solicitud->id,
                "user_id"      => $this->user->id,
                "accion"       => "Liberado",
                "observacion"  => $request->observacion_aprobacion,
            ]);

            $solicitudTrazabilidad = SolicitudTrazabilidad::find($pasoSolicitud->id);
            $solicitudTrazabilidad->fill([
                "solicitud_id" => $solicitud->id,
                "user_id"      => $this->user->id,
                "accion"       => "Liberado",
                "observacion"  => $request->observacion_aprobacion]);

            $mensaje = "Se libero la solicitud correctamente.";

            //Scar el cargo generico 
            $cargo_generico = CargoEspecifico::
                where('id', $solicitud->cargo_especifico_id)
                ->select('cargo_generico_id','plazo_req')
                ->first();
//para registrar ciudad en solicitud
            $ciudad = Ciudad::find($solicitud->ciudad_id);

            $date = Carbon::now();
            $fechaAddDay  = $date->addWeekdays($cargo_generico->plazo_req);
            $fechaSumados = $fechaAddDay->format('Y-m-d');
            $endDate = $fechaSumados;

            //Registrar data liberado en requerimientos
            $requerimiento                          = new Requerimiento();
            $requerimiento->id                      =  $solicitud->id;
            $requerimiento->num_vacantes            = $solicitud->numero_vacante;
            $requerimiento->cargo_generico_id       = $cargo_generico->cargo_generico_id;
            $requerimiento->salario                 = $solicitud->salario;
            $requerimiento->funciones               = $solicitud->observaciones;
            $requerimiento->pais_id                 = $ciudad->cod_pais; //aqui esta el peo
            $requerimiento->departamento_id         = $ciudad->cod_departamento; // que ciudad se le agrega
            $requerimiento->ciudad_id               = $ciudad->cod_ciudad; //? quien sabe
            $requerimiento->solicitado_por          = $this->user->id;
            $requerimiento->negocio_id              = 1;
            $requerimiento->centro_costo_id         = $solicitud->centro_costo_id;
            $requerimiento->tipo_contrato_id        = $solicitud->tipo_contrato_id;
            $requerimiento->tipo_jornadas_id        = $solicitud->jornada_laboral_id;
            $requerimiento->motivo_requerimiento_id = $solicitud->motivo_requerimiento_id;
            $requerimiento->centro_costo_id         = $solicitud->centro_costo_id;
            $requerimiento->cargo_especifico_id     = $solicitud->cargo_especifico_id;
            $requerimiento->tipo_proceso_id         = 2;
            $requerimiento->genero_id               = 3;
            $requerimiento->estado_publico          = 0;
            $requerimiento->edad_maxima             = 55;
            $requerimiento->edad_minima             = 18;
            $requerimiento->ctra_x_clt_codigo       = 1;
            $requerimiento->centro_costo_produccion = 1;
            $requerimiento->tipo_liquidacion        = "q";
            $requerimiento->tipo_nomina             = 6;
            $requerimiento->tipo_salario            = 1;
            $requerimiento->concepto_pago_id        = 1;
            $requerimiento->nivel_estudio           = 1;
            $requerimiento->estado_civil            = "AMB";
            $requerimiento->fecha_plazo_req         = $endDate;
            $requerimiento->solicitud_id            = $solicitud->id;

            $requerimiento->save();

            $estado_req               = new EstadosRequerimientos();
            $estado_req->estado       = config('conf_aplicacion.C_RECLUTAMIENTO');
            $estado_req->user_gestion = $this->user->id;
            $estado_req->req_id       = $solicitud->id;
            $estado_req->save();

            $user = $this->user;
        
        Mail::send('admin.email-liberar-solicitud', [
            'user'      => $user,
            'solicitud' => $solicitud,
        ], function ($message) use ($user, $solicitud) {
            $message->to([$solicitud->user()->email,"javier.chiquito@t3rsc.co","karen.amador@komatsu.com.co"], '$nombre - T3RS')
            
          //  $message->to('javier5chiquito@gmail.com', '$nombre - T3RS')
                ->subject("Informacion solicitud # $solicitud->id")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

            return response()->json(["success" => true, "mensaje" => $mensaje]);
        }

        $mensaje = "Para liberar la solicitud tiene que estar en estado (Aprobado 2 o Aprobado 3) ";
        return response()->json(["success" => true, "mensaje" => $mensaje]);

    }

    /**
     * ID del area de trabajo para mostrar el subarea relacionado
     **/
    public function selectSubArea(Request $request)
    {
        $subarea = SolicitudSubArea::
            where("estado", 1)
            ->where("area_funciones_id", $request->id)
            ->pluck("descripcion", "id")
            ->toArray();

        return response()->json(["success" => true, "subarea" => $subarea]);
    }

    public function selectEmailJefe(Request $request)
    {
        $jefe = JefeInmediato::find($request->id);
        $email=$jefe->email;


        return response()->json(["success" => true, "email" => $email]);
    }

    /**
     * ID del area de trabajo para mostrar el subarea relacionado
     **/
    public function selctbenficio(Request $request)
    {
        $selctbenficio = SolicitudCentroBeneficio::
            where("estado", 1)
            ->where("sub_area_id", $request->id)
            ->pluck("descripcion", "id")
            ->toArray();

        return response()->json(["success" => true, "subarea" => $selctbenficio]);
    }

    /**
     * ID del area de trabajo para mostrar el subarea relacionado
     **/
    public function selctCosto(Request $request)
    {
        $selctcosto = SolicitudCentroCosto::
            where("estado", 1)
            ->where("centro_beneficios_id", $request->id)
            ->pluck("descripcion", "id")
            ->toArray();

        return response()->json(["success" => true, "subarea" => $selctcosto]);
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

    
}
