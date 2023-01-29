<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Archivo_hv;
use App\Models\Autoentrevist;
use App\Models\AspiracionSalarial;
use App\Models\Auditoria;
use App\Models\CargoGenerico;
use App\Models\CategoriaLicencias;
use App\Models\ClaseLibreta;
use App\Models\DatosBasicos;
use App\Models\Documentos;
use App\Models\EntidadesAfp;
use App\Models\EntidadesEps;
use App\Models\EstadoCivil;
use App\Models\Estados;
use App\Models\Estudios;
use App\Models\Experiencias;
use App\Models\Genero;
use App\Models\GrupoFamilia;
use App\Models\IdiomaUsuario;
use App\Models\MotivosRechazos;
use App\Models\OfertaUser;
use App\Models\Pais;
use App\Models\RegistroProceso;
use App\Models\ReferenciasPersonales;
use App\Models\Requerimiento;
use App\Models\Sitio;
use App\Models\TipoIdentificacion;
use App\Models\TipoVehiculo;
use App\Models\ObservacionesHv;
use APp\Models\PoliticasPrivacidad;
use Carbon\Carbon;
use App\Models\User;
use App\Models\CandidatoReclutamientoExterno;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReclutamientoExternoController extends Controller
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

    public function index(Request $request)
    {

        $user         = Sentinel::getUser();
        $datosBasicos = Sentinel::getUser()->getDatosBasicos();
        $sitio        = Sitio::first();

        $menu = DB::table("menu_reclutamiento_externo")->where("estado", 1)->orderBy("orden")
        ->select("menu_reclutamiento_externo.*")
        ->get();

        $total_aplicados = OfertaUser::where("user_id", $user->id)->count();

        $hv_count = ($datosBasicos->datos_basicos_count * 0.3) + ($datosBasicos->perfilamiento_count * 0.1) + ((($datosBasicos->experiencias_count + $datosBasicos->estudios_count + $datosBasicos->referencias_count + $datosBasicos->grupo_familiar_count) / 4) * 0.6);

        $experiencias  = 0;
        $estudios      = 0;
        $personal      = 0;
        $familia       = 0;

        if(route('home') == "http://soluciones.t3rsc.co" || route('home') == "https://soluciones.t3rsc.co" ){
            $experiencias_count = Experiencias::where("user_id", $this->user->id)->count();
            $estudio_count      = Estudios::where("user_id", $this->user->id)->count();
            $personal_count     = ReferenciasPersonales::where("user_id", $this->user->id)->count();
            $familiar_count     = GrupoFamilia::where("user_id", $this->user->id)->count();

            if ($experiencias_count >= 1) {
                $experiencias = 100;
            }

            if ($estudio_count >= 1) {
                $estudios = 100;
            }

            if ($personal_count >= 1) {
                $personal = 100;
            }

            if ($familiar_count >= 1) {
                $familia = 100;
            }

            //OFERTAS ACTUALES
            $date = Carbon::now();
            $mes =  $date->subDay(8);

            $ofertas = Requerimiento::join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->leftJoin("ofertas_users", function ($join3) {
                $join3->on("ofertas_users.requerimiento_id", "=", DB::raw("requerimientos.id"))
                ->on("ofertas_users.user_id", "=", DB::raw($this->user->id));
            })
            ->whereDate('requerimientos.created_at','>=',$mes)
            ->whereRaw("requerimientos.cargo_generico_id in (select cargo_generico_id from perfilamiento where user_id = " . $this->user->id . ") ")
            ->whereRaw("requerimientos.estado_publico is not false")
            ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ") "))
            ->whereRaw("ofertas_users.fecha_aplicacion is null ")
            ->select(
                "requerimientos.*",
                "DATE_FORMAT(requerimientos.fecha_cierre_externo, \'%Y-%m-%d\')",
                "ofertas_users.fecha_aplicacion as f_aplicacion",
                "clientes.logo",
                "requerimientos.id as cod_req"
            )
            ->orderBy("requerimientos.created_at", "desc")
            ->take(5);

            $cargo = CargoGenerico::join("perfilamiento", "perfilamiento.cargo_generico_id", "=", "cargos_genericos.id")
            ->where("perfilamiento.user_id", $this->user->id)
            ->first();

            $procesos_activos = RegistroProceso::join('users', 'users.id', '=', 'procesos_candidato_req.candidato_id')
            ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
            ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            //->join('requerimientos_estados','requerimientos_estados.req_id','=','requerimientos.id')
            ->whereIn("estados_requerimiento.estado",[
                config('conf_aplicacion.C_RECLUTAMIENTO'),
                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            ])
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where('procesos_candidato_req.candidato_id',$this->user->id)
            ->select('procesos_candidato_req.candidato_id','procesos_candidato_req.requerimiento_id')
            ->count();

            $showModal = false;

            if ($request->session()->has('proceso_contratacion')) {
                $showModal = true;
                $request->session()->forget('proceso_contratacion');
            }

            return view("reclutamiento_externo.index", compact(
                "user",
                "procesos_activos",
                "datosBasicos",
                "experiencias",
                "estudios",
                "personal",
                "familia",
                "ofertas",
                "cargo",
                "hv_count",
                "total_aplicados",
                "menu",
                "showModal",
                "sitio"
            ));
        }else{
            $experiencias_count = Experiencias::where("user_id", $this->user->id)->get()->count();
            $estudio_count    = Estudios::where("user_id", $this->user->id)->get()->count();
            $personal_count   = ReferenciasPersonales::where("user_id", $this->user->id)->get()->count();

            $familiar_count = GrupoFamilia::where("user_id", $this->user->id)->get()->count();

            if($experiencias_count >= 1){
                $experiencias = 100;
            }

            if($estudio_count >= 1){
                $estudios = 100;
            }

            if($personal_count >= 1){
                $personal = 100;
            }

            if($familiar_count >= 1){
                $familia = 100;
            }

            $procesos_activos = RegistroProceso::join('users', 'users.id', '=', 'procesos_candidato_req.candidato_id')
            ->join('requerimiento_cantidato', 'requerimiento_cantidato.id', '=', 'procesos_candidato_req.requerimiento_candidato_id')
            ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
            ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            ->whereIn("estados_requerimiento.estado", [
                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            ])
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where('procesos_candidato_req.candidato_id', $this->user->id)
            ->whereRaw("requerimiento_cantidato.estado_candidato not in (" .config('conf_aplicacion.C_QUITAR') .",".config('conf_aplicacion.C_TRANSFERIDO').")")
            ->select('procesos_candidato_req.candidato_id', 'procesos_candidato_req.requerimiento_id')
            ->get()
            ->count();

            //OFERTAS ACTUALES
            $ofertas = Requerimiento::join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
            })
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            /*->leftJoin("ofertas_users", function ($join3) {
                $join3->on("ofertas_users.requerimiento_id", "=", DB::raw("requerimientos.id"))
                ->on("ofertas_users.user_id", "=", DB::raw($this->user->id));
            })*/
            ->select(
                "requerimientos.*",
                DB::raw('(DATE_FORMAT(requerimientos.fecha_cierre_externo, \'%Y-%m-%d\')) as fecha_cierre_externo' ),
                //"ofertas_users.fecha_aplicacion as f_aplicacion",
                \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"),
                "clientes.nombre as nombre_cliente",
                "clientes.logo",
                "cargos_genericos.descripcion as nombre_cargo",
                "requerimientos.id as cod_req"
            )
            ->where("requerimientos.tipo_reclutamiento",2)
            //->whereRaw("requerimientos.cargo_generico_id in (select cargo_generico_id from perfilamiento where user_id = " . $this->user->id . ") ")
            ->whereRaw("requerimientos.estado_publico is not false")
            //->where("requerimientos.pais_id", $datosBasicos->pais_residencia)
            //->where("requerimientos.departamento_id", $datosBasicos->departamento_residencia)
            //->where("requerimientos.ciudad_id", $datosBasicos->ciudad_residencia)
            ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado in (".config('conf_aplicacion.C_TERMINADO').",".config('conf_aplicacion.C_CLIENTE').")) "))
            //->whereRaw("ofertas_users.fecha_aplicacion is null ")
            ->orderBy("requerimientos.created_at", "desc")
            ->take(5)
            ->get();
            
            $cargo = CargoGenerico::join("perfilamiento", "perfilamiento.cargo_generico_id", "=", "cargos_genericos.id")
            ->where("perfilamiento.user_id", $this->user->id)
            ->first();
        }

        $showModal = false;

        if ($request->session()->has('proceso_contratacion')) {
            $showModal = true;
            $request->session()->forget('proceso_contratacion');
        }

        return view("reclutamiento_externo.index", compact(
            "procesos_activos",
            "user",
            "datosBasicos",
            "experiencias",
            "estudios",
            "personal",
            "familia",
            "ofertas",
            "cargo",
            "hv_count",
            "total_aplicados",
            "showModal",
            "menu",
            "sitio"
        ));
    
    }

     public function agregarCandidatoNuevo(Request $data)
    {
        $requerimiento_id=$data->id;
        return response()->json([
            "success" => true,

            "view" => view("reclutamiento_externo.modal.asociar_candidato",compact("requerimiento_id"))->render()
        ]);
    }

    public function buscarCandidato(Request $data)
    {

        $asociado_req_actual=false;

        $candidato = DatosBasicos::where("numero_id",$data->cedula)->first();
        //$estado_civil = ["" => "Seleccionar"] + EstadoCivil::pluck("descripcion","id")->toArray();

        /*if($candidato!=null){
            $asociacion = DB::table("requerimiento_cantidato")
                    ->whereRaw(" estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
                    ->where("candidato_id", $candidato->user_id)
                    ->where("requerimiento_id",$data->get("req_id"))
                    ->orderBy("id","DESC")
                    ->first();
            if($asociacion!=null){
                $asociado_req_actual=true;
            }
        }*/

        $cedula=$data->cedula;

        if($candidato == null){
            $candidato_id = "";
            $find = false;
            $atributo = " ";
        }else{
            $find = true;
            $atributo = "readonly";
            $candidato_id = $candidato->numero_id;
        }
       
        return response()->json([
            "cedula"=>$cedula,
            "success" => true,
            "find" => $find,
            "candidato" => $candidato_id,
            //"asociado"  =>$asociado_req_actual,
            "view" => view("reclutamiento_externo.ajaxgetcandidato", compact("candidato", "atributo"))->render()
        ]);
    }

    public function asociarCandidato(Request $data)
    {
        $datos = $data->all();
        $requerimiento_id=$data->req_id;
        $usuario_cargo = $this->user->id;
        
        $validator = Validator::make($datos,[
            //"tipo_fuente_id" => "required",
            "primer_nombre" => "required",
            "primer_apellido" => "required",
            "celular" => "required",
            "email" => "required|unique:users,email|email"
        ]);

        //$fuentes = ["" => "Seleccionar"] + TipoFuentes::pluck("descripcion", "id")->toArray();
        // $valida  = Validator::make($data->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                "success" => false,
                "errors" => $validator->errors()
            ]);
        }

        //VALIDANDO EMAIL
        
        $validar_email=json_decode($this->verificar_email($data->get("email")));

        if($validar_email->status==200 && !$validar_email->valid){
                     
                    //$error_email="Correo ".$data->get("email")." no válido. Verifique que exista la cuenta o el  proveedor de correos.";
                    return response()->json([
                    "success" => false,
                    "errors"=>[$validar_email->mensaje]
                    
            ]);
                    
        }
        //FIN VALIDACIÓN

        //NUEVO (CREAR USUARIO)

            $datos_basicos = DatosBasicos::where('numero_id',$data->get("cedula"))->first();

               if(is_null($datos_basicos)){
                //Creamos el usuario
                 $campos_usuario = [
                   'name' => $data->get("primer_nombre").' '.$data->get("segundo_nombre").' '.$data->get("primer_apellido").' '.$data->get("segundo_apellido"),
                   'email'  => $data->get("email"),
                   'password' => $data->get("cedula"),
                   'numero_id' => $data->get("cedula"),
                   'cedula'     => $data->get("cedula"),
                   'metodo_carga' =>6,
                   'usuario_carga' =>$this->user->id
                 ];

                
            $user = Sentinel::registerAndActivate($campos_usuario);  
            $usuario_id = $user->id;
            
            //Creamos sus datos basicos
            $datos_basicos = new DatosBasicos();     
            $datos_basicos->fill([
                'numero_id'       => $data->get("cedula"),
                'user_id'         => $usuario_id,
                'nombres'         => $data->get("primer_nombre").' '.$data->get("segundo_nombre"),
                'primer_nombre'   => $data->get("primer_nombre"),
                'segundo_nombre'  => $data->get("segundo_nombre"),
                'primer_apellido' => $data->get("primer_apellido"),
                'segundo_apellido'=> $data->get("segundo_apellido"),
                'telefono_movil'  => $data->get("celular"),
                'estado_reclutamiento' => config('conf_aplicacion.C_ACTIVO'),
                'datos_basicos_count'  => "100",
                'email'             => $data->get("email")
            ]);

            $datos_basicos->usuario_cargo = $usuario_cargo;
            $datos_basicos->save();

        
                    
            //Creamos el rol
            $role = Sentinel::findRoleBySlug('hv');
            $role->users()->attach($user);
            //si no esxite el usuario crearlo
        }
        //FIN DE LO NUEVO

        /*$candidato_fuente = CandidatosFuentes::where("requerimiento_id", $data->get("requerimiento_id"))
        ->where("cedula", $data->get("cedula"))->get();

        if($candidato_fuente->count() > 0){
            return response()->json([
                "success" => false,
                "view" => view("admin.reclutamiento.modal.nuevo_candidato", compact("fuentes", "datos"))->withErrors(["error" => "Este candidato ya fue ingresado a este requerimiento"])->render()
            ]);
        }*/

        //INGRESAR CANDIDATO
        $candidato_reclutamiento_externo = new CandidatoReclutamientoExterno();
        $candidato_reclutamiento_externo->fill([
            'req_id'=>$data->req_id,
            'candidato_id'=>$datos_basicos->user_id,
            'usuario_carga'=> $this->user->id
        ]);
        $candidato_reclutamiento_externo->save();

      

        return response()->json([
            "success" => true,

        ]);
    }

    public function detalleOfertaModal(Request $data)
    {

        $detalle_oferta = Requerimiento::select("requerimientos.*",DB::raw('(DATE_FORMAT(requerimientos.fecha_cierre_externo, \'%Y-%m-%d\')) as fecha_cierre_externo' ))->find($data->get("id"));

        $ofertaRespondida = CandidatoReclutamientoExterno::where("usuario_carga", $this->user->id)
            ->where("req_id", $data->get("id"))
            ->get();

        return view("reclutamiento_externo.modal.detalle_oferta", compact("detalle_oferta", "ofertaAplicada"));
    }

    public function miReclutamiento(Request $request){
        $menu = DB::table("menu_reclutamiento_externo")->where("estado", 1)->orderBy("orden")
        ->select("menu_reclutamiento_externo.*")
        ->get();


        $reclutamiento=CandidatoReclutamientoExterno::join("datos_basicos","datos_basicos.user_id","=","candidatos_reclutamiento_externo.candidato_id")
        ->where("usuario_carga",$this->user->id)
        ->where(function ($sql) use ($request) {
                    if ($request->has("oferta") && $request->get("oferta") != "") {
                        $sql->where("candidatos_reclutamiento_externo.req_id", $request->get("oferta"));
                    }
                    if ($request->has("cedula") && $request->get("cedula") != "") {
                        $sql->where("datos_basicos.numero_id", $request->get("cedula"));
                    }
        })
        ->select("datos_basicos.numero_id as cedula","datos_basicos.user_id","datos_basicos.primer_nombre","datos_basicos.segundo_nombre","datos_basicos.primer_apellido","datos_basicos.segundo_apellido","candidatos_reclutamiento_externo.req_id as requerimiento","candidatos_reclutamiento_externo.created_at as fecha_reclutamiento")
        ->orderBy("candidatos_reclutamiento_externo.created_at","DESC")
        ->paginate(10);


        return view("reclutamiento_externo.mi_reclutamiento",compact("menu","reclutamiento"));
    }

   
}