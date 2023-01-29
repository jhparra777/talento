<?php

namespace App\Http\Controllers;

use App\Facade\QueryAuditoria;
use App\Http\Controllers\Controller;
/**************   ***************/
use App\Models\Auditoria;
use App\Models\CargoGenerico;
use App\Models\CargoEspecifico;
use Bitly;    
use App\Models\PerfilCandidato;
use App\Models\Perfilamiento;
use App\Models\CitacionCandidato;
use App\Models\CitacionCargaBd;
use App\Models\CitacionTipificaciones;
use App\Models\CandidatosFuentes;
use App\Models\DatosBasicos;
use App\Models\DocumentosCargo;
use App\Models\TipoDocumento;
use App\Models\FranjaHoraria;
use App\Models\PerfilamientoCandidato;
use App\Models\RecepcionMotivo;
use App\Models\Requerimiento;
use App\Models\Perfil;
use App\Models\ListaNegra;
use App\Models\User;
use App\Models\Sitio;
use \DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Models\ReqCandidato;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\RegistroProceso;
use Illuminate\Support\Facades\Event;
use App\Jobs\FuncionesGlobales;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Support\Facades\Crypt;
use App\Events\PorcentajeHvEvent;
use App\Jobs\SendEmailCargaMasiva;
use App\Jobs\AsociarCandidatoReq;
use triPostmaster;

class CitacionController extends Controller
{

    protected $estados_no_muestra = [];

    public function __construct()
    {
        parent::__construct();
        $this->estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
        ]; //SON LOS ESTADOS PARA NO MOSTRAR EL CANDIDATO EN EL  REQUERIMIENTO
        //dd('genner test');
    }

    public function index(){
        return view("admin.index");
    }

    public function lista_reclutadores(Request $data)
    {

        $user = $this->user;
        //BASES DE DATOS CARGADAS
        $datos_cargados = CitacionCargaBd::where("user_carga", $this->user->id)
            ->where(function ($where) use ($data){
              if($data->get("numero_id") != "") {
               $where->where("identificacion", $data->get("numero_id"));
              }
            })
            ->where("estado", 0)
            ->where("motivo", 8)
            ->where("remitido_call", null)
            ->orderBy('created_at', 'ASC')
        //->whereRaw("estado is null") //Remplace por la line de arriba
            ->take(100)
            ->get();

        return view("admin.citacion.proceso_recluta.reclutamiento", compact("datos_cargados"));
    }

    public function lista_call_center(Request $data)
    {

        //BASES DE DATOS CARGADAS
        $datos_cargados = CitacionCargaBd::where(function ($where) use ($data) {
            if ($data->get("numero_id") != "") {
                $where->where("identificacion", $data->get("numero_id"));
            }
            if ($data->get("motivo") != "") {
                $where->where("motivo", $data->get("motivo"));
            } else {
                $where->whereRaw("(motivo != 8 or remitido_call = 1)");
            }
            if ($data->get("enviado_por") != "") {
                $where->where("user_carga", $data->get("enviado_por"));
            }
        })
            ->where("estado", 0)
            ->orderBy('created_at', 'DESC')
            ->take(100)
            ->get();

        $motivos = ["" => "Seleccionar"] + RecepcionMotivo::pluck("descripcion", "id")->toArray();

        //Sacar los nombres de los usuarios quienes enviaron a citacion o subieron BD
        $usuario_envio = DatosBasicos::join("citacion_carga_db", "citacion_carga_db.user_carga", "=", "datos_basicos.user_id")
            ->select("citacion_carga_db.user_carga, datos_basicos.nombres, datos_basicos.primer_apellido, datos_basicos.segundo_apellido")
            ->groupBy("citacion_carga_db.user_carga,datos_basicos.nombres, datos_basicos.primer_apellido, datos_basicos.segundo_apellido")
            ->get()
            ->pluck("nombres", "user_carga");
        //dd($usuario_envio);

        //Select de la consulta
        $enviado_por = ["" => "Seleccionar"] + $usuario_envio->toArray();
        //dd($enviado_por);

        //Select de las sedes registradas
        $ciudad_trabajo = ["" => "Seleccionar"] + config('conf_aplicacion.SEDES_MUNICIPIO');
        //dd($ciudad_trabajo);

        return view("admin.citacion.proceso_recluta.call_center", compact("datos_cargados", "motivos", "enviado_por", "ciudad_trabajo"));

    }

    public function citacion_reclutamiento(Request $data)
    {
        $user            = $this->user;
        $motivo_carga_db =RecepcionMotivo::where("id", 8)->pluck("descripcion", "id")->toArray();

        return view("admin.citacion.proceso_recluta.index", compact("user", "motivo_carga_db"));
    }

    public function gestionar_candidato_reclutamiento(Request $data)
    {

        //dd($data->all());
        //Valida_Candidato_Citado Si el candidato ya tiene sita para msotrar un mensaje
        /*
        $vcc =  DatosBasicos::join("CITACION_CANDIDATO","CITACION_CANDIDATO.USER_ID","=","DATOS_BASICOS.USER_ID")
        ->join("CITACION_CARGA_DB","CITACION_CARGA_DB.IDENTIFICACION","=","DATOS_BASICOS.NUMERO_ID")
        ->where("CITACION_CARGA_DB.IDENTIFICACION",$data->get("numero_id"))
        ->where("CITACION_CANDIDATO.FECHA_CITA",">=",date("Y-m-d"))
        ->where("CITACION_CANDIDATO.ESTADO",0)
        ->select("count(*) as total")
        ->first();

        if ($vcc->total >= 1){
        //Redirecciono a la pagina para msotrar el mensaje
        return redirect()->back()->with("mensaje_success", "El usuario tiene una citación pendiente. <br/>Motivo: motivo <br/> Fecha: fecha <br/>Hora:hora");
        }
         */

        $candidato = null;
        if ($data->get("numero_id") != "") {
            $candidato = CitacionCargaBd::where("identificacion", $data->get("numero_id"))
                ->first();
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

        $franja_hora = ["" => "Seleccionar"] + FranjaHoraria::where("estado", 1)->pluck("descripcion", "id")->toArray();

        $requerimientos_priorizados = Requerimiento::where("req_prioritario", 1)->get();

        return view("admin.citacion.proceso_recluta.citacion", compact("candidato", "cargos", "cargos_seleccionados", "requerimientos_seleccionados", "requerimientos", "tipos_motivos", "franja_hora", "tipificacion", "requerimientos_priorizados"));
    }

    public function gestionar_candidato_call_center(Request $data)
    {
        //dd($data->all());
        $candidato = null;
        if ($data->get("numero_id") != "") {
            $candidato = CitacionCargaBd::where("identificacion", $data->get("numero_id"))
                ->first();

            $candidatodatos = DatosBasicos::where("numero_id", $data->get("numero_id"))
                ->first();

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

        if ($candidatodatos == null) {
            $candidatodatos          = new \stdClass();
            $candidatodatos->user_id = null;

        }

        $tipos_motivos = ["" => "Seleccionar"] + RecepcionMotivo::where("active", 1)->pluck("descripcion", "id")->toArray();

        $tipificacion = ["" => "Seleccionar"] + CitacionTipificaciones::where("estado", 1)->pluck("descripcion", "tipificacion")->toArray();

        $cargos_seleccionados = PerfilamientoCandidato::join("cargos_genericos", "cargos_genericos.id", "=", "perfilamiento_candidato.tabla_id")
            ->where("candidato_id", $candidatodatos->user_id)->where("tipo", "CARGO_GENERICO")
            ->get();

        //dd($cargos_seleccionados);

        $requerimientos_seleccionados = PerfilamientoCandidato::where("candidato_id", $candidatodatos->user_id)->where("tipo", "REQUERIMIENTO")->get();

        $requerimientos_seleccionados_a = [];
        foreach ($requerimientos_seleccionados as $key => $value) {
            array_push($requerimientos_seleccionados_a, $value->tabla_id);
        }

        $codigo_user = $data->user_id;

        //Franja Hora de cita
        $franja_hora = ["" => "Seleccionar"] + FranjaHoraria::where("estado", 1)->pluck("descripcion", "id")->toArray();

        return view("admin.citacion.proceso_recluta.citacion_call_center", compact("candidato", "cargos_seleccionados", "requerimientos_seleccionados", "tipos_motivos", "codigo_user", "franja_hora", "tipificacion"));
    }
         
    public function citacion_perfil(Request $data){

        $user            = $this->user;
        $perfil_candidato = ["" => "Seleccionar"] + CargoGenerico::groupBy('descripcion')
        ->orderBy('descripcion','asc')
        ->pluck("descripcion", "id")->toArray();

         $motivo_carga_db =  RecepcionMotivo::where("id", 8)
          ->select('motivo_recepcion.id as id')
         ->first();

        return view("admin.citacion.proceso_recluta.perfil", compact("user", "perfil_candidato","motivo_carga_db"));
    }

    public function citacion_otras_fuentes(Request $data){

        $user = $this->user;

        $perfil_candidato = CargoGenerico::orderBy("descripcion", "ASC")->pluck("descripcion", "id")->toArray();

         $motivo_carga_db =  RecepcionMotivo::where("id", 8)
          ->select('motivo_recepcion.id as id')
         ->first();

        return view("admin.citacion.proceso_recluta.cargas_db_otros", compact("user", "perfil_candidato","motivo_carga_db"));
    }

    public function carga_otras_fuentes(Request $request){
        //para cargar desde csv
        $rules = [
            'motivo'  => 'required|min:1',
            'archivo' => 'required',
            'nombre_carga' => 'required',
            'claves' => 'required'
        ];

        $valida = Validator::make($request->all(), $rules);
        if($valida->fails()) {
            return redirect()->back()->withErrors($valida);
        }
        $reader = Excel::selectSheetsByIndex(0)->noHeading(true)->load($request->file("archivo"))->skipRows(2)->get();

        //Se sacan los titulos de la posicion 0; se intercambia el id por el valor
        $heading = array_flip($reader[0]->toArray());

        $guardar = true;

        $errores_global;
        $registrosInsertados = 0;
        $lote_unico          = true;
        $errores = array();
        $i = 0;
        $identificacion="";
        $limit = count($reader);

        $sitio = Sitio::first();

        if(isset($sitio->nombre)){
            if($sitio->nombre != "") {
                $nombre_sitio = $sitio->nombre;
            }else{
                $nombre_sitio = "Desarrollo";
            }
        }

        //Comienza en 1 porque en la posicion 0 estan los titulos
        for($i = 1; $i < $limit; $i++) {

            $guardar = true;

            if($reader[$i][$heading['Identificación']] != "" && $reader[$i][$heading['Identificación']] != " "){

                $identificacion = strval($reader[$i][$heading['Identificación']]);

                if(!ctype_digit($identificacion)){ $errores[] = "El usuario ".$identificacion. " no es válido en linea: $i";}

                $usuario_exi=DatosBasicos::where("numero_id", $identificacion)->first();

                if($usuario_exi !== null) {
                    $guardar = false;
                    $errores[] = "El usuario ".$identificacion. " ya existe, en linea: $i";
                }
            }else{
                $guardar = false;
                $errores[] =  "El campo identificación es obligatorio en linea: ".$i." ";
            }

            if($reader[$i][$heading['Teléfono']] != "" && $array[$i][$heading['Teléfono']] != " "){

                $telefono = strval($reader[$i][$heading['Teléfono']]);
                if(ctype_alpha($telefono)){ $errores[] = "El teléfono no es válido en linea: ".$i." ";}//verificar si no son numeros
                @list($num1,$num2) = explode('-', $telefono); //falla con caracteres de letras
                if(strlen($num1) <= 2){$telefono = $num2;}// es un 57 u otro
                if(strlen($num1) == 3){$telefono = $num1.$num2;}//es el cod de la linea
                if(strlen($num1) >= 7){$telefono = $num1;}//son dos numeros tomar solo 1

            }else{

                $guardar = false;
                $errores[] = "El teléfono es obligatorio en linea: ".$i." ";

            }

            if($reader[$i][$heading['Email']] != "" && $reader[$i][$heading['Email']] != " "){

                $correo = $reader[$i][$heading['Email']];
                $correo = strtolower($correo);

                $correo_exi = DatosBasicos::whereRaw("(LOWER(email) = '$correo')")->first();

                if($correo_exi !== null) {
                    $guardar = false;
                    $errores[] = "El email ".$correo." ya se encuentra registrado en linea: $i";
                } else {
                    $correo_exi = User::whereRaw("(LOWER(email) = '$correo')")->first();

                    if($correo_exi !== null) {
                        $guardar = false;
                        $errores[] = "El email ".$correo." ya se encuentra registrado en linea: $i";
                    } else {
                        $validar_email = json_decode($this->verificar_email($correo));

                        if($validar_email->status==200 && !$validar_email->valid){

                            $errores[] = "Email ".$correo." no válido en linea: $i. Verifique que exista la cuenta o el proveedor de correos.";
                            $guardar = false;

                        }
                    }
                }

            }else{

                $guardar = false;
                $errores[] = "El campo email es obligatorio en linea: ".$i." ";

            }

            if($reader[$i][$heading['Nombre']] != "" && $reader[$i][$heading['Nombre']] != " "){

                $nombres = $reader[$i][$heading['Nombre']];

            }else{

                $guardar = false;
                $errores[] = "El campo nombre es obligatorio en linea: ".$i." ";
            }

            if($reader[$i][$heading['Apellidos']] != "" && $reader[$i][$heading['Apellidos']] != " "){

                $apellidos = $reader[$i][$heading['Apellidos']];
                //$apellido = utf8_encode($apellido);
            }else{

                $guardar = false;
                $errores[]= "El campo apellidos es obligatorio en linea: ".$i." ";
            }
            //dd($nombres, $apellidos, $errores);

            if($guardar){
                $nom = explode(' ', $nombres);
                $segundo_nombre = '';
                switch (count($nom)) {
                    case 2:
                        $primer_nombre = $nom[0];
                        $segundo_nombre = $nom[1];
                        break;

                    default:
                        $primer_nombre = $nombres;
                        break;
                }

                $ape = explode(' ', $apellidos);
                $segundo_apellido = '';
                switch (count($ape)) {
                    case 2:
                        $primer_apellido = $ape[0];
                        $segundo_apellido = $ape[1];
                        break;

                    default:
                        $primer_apellido = $apellidos;
                        break;
                }

                $datos = [
                    "identificacion"    => $identificacion,
                    "nombres"           => $nombres,
                    "primer_apellido"   => $primer_apellido,
                    "segundo_apellido"  => $segundo_apellido,
                    "telefono_movil"    => $telefono,
                    "email"             => $correo,
                    "user_carga"        => $this->user->id,
                ];            

                if($lote_unico == true) {

                    $lote = CitacionCargaBd::get()->max("lote");
                    $ultimo_lote = $lote + 1;
                    $lote_unico  = false;
                }

                //Creamos el usuario
                $campos_usuario = ['name' =>$nombres. " ".$apellidos,
                    'email'         =>$correo,
                    'password'      =>$identificacion,
                    'numero_id'     =>$identificacion,
                    'cedula'        =>$identificacion,
                    'metodo_carga'  =>5,
                    'usuario_carga' =>$this->user->id
                ];

                $user = Sentinel::registerAndActivate($campos_usuario);
                $usuario_id = $user->id;

                //Creamos sus datos basicos
                $datos_basicos = new DatosBasicos();

                $datos_basicos->fill([
                    'numero_id'         => $identificacion,
                    'user_id'           => $usuario_id,
                    "nombres"           => $nombres,
                    "primer_nombre"     => $primer_nombre,
                    "segundo_nombre"    => $segundo_nombre,
                    "primer_apellido"   => $primer_apellido,
                    "segundo_apellido"  => $segundo_apellido,
                    'telefono_movil'    => $telefono,
                    'email'             => $correo,
                    'estado_reclutamiento' => config('conf_aplicacion.C_ACTIVO'),
                    'datos_basicos_count'  =>"20"
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
                    $auditoria->observaciones = 'Se registro por otras fuentes y se encuentra en listado especial con la restricción ' . $restriccion->descripcion;
                    $auditoria->valor_antes   = json_encode(["estado" => config('conf_aplicacion.C_ACTIVO')]);
                    $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.PROBLEMA_SEGURIDAD')]);
                    $auditoria->user_id       = $gestiono;
                    $auditoria->tabla         = "datos_basicos";
                    $auditoria->tabla_id      = $datos_basicos->id;
                    $auditoria->tipo          = 'ACTUALIZAR';
                    event(new \App\Events\AuditoriaEvent($auditoria));
                }

                $datos_basicos->save();

                Event::dispatch(new PorcentajeHvEvent($datos_basicos));

                //Creamos el rol
                $role = Sentinel::findRoleBySlug('hv');
                $role->users()->attach($user);

                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                $mailTitle = "Bienvenido a {$nombre_sitio} - T3RS"; //Titulo o tema del correo

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "
                    ¡Hola $datos_basicos->nombres $datos_basicos->primer_apellido $datos_basicos->segundo_apellido!<br>
                    Se ha creado exitosamente tu cuenta en T3RS, te invitamos a ingresar usando tu número de documento como usuario y contraseña para completar tu hoja de vida y cargar tus documentos.
                    ";
                //Arreglo para el botón
                $mailButton = ['buttonText' => '¡COMPLETA TU HOJA DE VIDA!', 'buttonRoute' => route('login')];

                $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $nombre_sitio, $sitio) {

                        $message->to($datos_basicos->email, $datos_basicos->nombres)
                                ->subject("Bienvenido a $nombre_sitio - T3RS")
                                ->bcc($sitio->email_replica)
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

                //dd($request["claves"]);
                $cargaReclutadores = new CitacionCargaBd();

                $cargaReclutadores->fill($datos + [
                    "user_id"        => $usuario_id,
                    "lote"           => $ultimo_lote,
                    "estado"         => 0,
                    "motivo"         => $request["motivo"],
                    "tipo_fuente"    => 2,
                    "nombre_carga"   => $request["nombre_carga"],
                    "user_carga"     => $this->user->id,
                    "cargo_id"       => $request["cargos"],
                    "palabras_clave" => strtolower($request["claves"])
                ]);

                $cargaReclutadores->save();

                //perfilando al candidato
                $perfilamiento_db = new Perfilamiento();
                $perfilamiento_db ->fill([
                    'cargo_generico_id'      =>$request->get('cargos'),
                    'user_id'        =>$usuario_id
                    //'user_gestion_id'=>$this->user->id

                ]);
                $perfilamiento_db->save();

                $registrosInsertados++;
            }else{
                $errores;
            }

        }//for

        //    dd($errores);
        //fin de comptrabajo
        return redirect()->route("admin.carga_candidatos_fuentes")->with("mensaje_success", "Se han cargado <b>$registrosInsertados</b> con éxito.")->with("errores_global", $errores);
    }

    public function lista_carga_otras_fuentes(Request $data){

       $perfil_candidato = ["" => "Seleccionar"] + CargoGenerico::orderBy("descripcion", "ASC")->pluck("descripcion", "id")->toArray();

           $requerimientos = ["" =>"seleccionar"] + Requerimiento::whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado in(" . config('conf_aplicacion.C_TERMINADO') . ",3,".config('conf_aplicacion.C_SOLUCIONES') .  ",".config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL').  ",".config('conf_aplicacion.C_INACTIVO').config('conf_aplicacion.C_QUITAR').config('conf_aplicacion.C_ELIMINADO'). "))"))->orderBy('id','DESC')->pluck("id","id")->toArray();
       //dd($perfiles);

      return view("admin.citacion.proceso_recluta.lista_carga_fuentes", compact( "perfil_candidato","requerimientos"));
    }

    public function ajax_carga_otras_fuentes(Request $data){
      //tabla de otras fuentes
      //dd($data->all());
        $claves = explode(',',$data['claves']);
        $i=0;
        //dd($claves);
       //dd($perfiles);
      if($data['claves'] !="" || $data['fecha_actualizacion_ini'] !="" || $data['cargo_id'] !=""){

        $carga = CitacionCargaBd::join('datos_basicos','datos_basicos.numero_id','=','citacion_carga_db.identificacion')
          //->leftJoin('cargos_genericos','cargos_genericos.id','=','citacion_carga_db.cargo_id')
          ->where('citacion_carga_db.tipo_fuente',2)
          ->where(function($sql) use ($data,$claves,$i){

            if($data['claves'] != ""){
             foreach($claves as $clave){
             $sql->orWhere('citacion_carga_db.palabras_clave','LIKE','%'.strtolower($clave).'%');
             //$sql->whereRaw("(citacion_carga_db.palabras_clave like ".$clave.")");
             }
            }

            if($data['fecha_actualizacion_ini'] != "" && $data['fecha_actualizacion_fin'] != ""){

              $sql->whereBetween(DB::raw('DATE_FORMAT(citacion_carga_db.created_at, \'%Y-%m-%d\')'),[$data['fecha_actualizacion_ini'],$data['fecha_actualizacion_fin']]);
            }

            if($data['cargo_id'] != ""){

              $sql->where('citacion_carga_db.cargo_id',$data['cargo_id']);
            }

            })->get();
      }

        return response()->json(["success" => true,"view" => view("admin.citacion.proceso_recluta.tabla_carga_otras_fuentes",compact('carga'))->render()]);
    }


    public function perfil_carga_db(Request $data){

           $rules = [
            'motivo'    => 'required|min:1',
            'perfil_id'  => 'required',
            'archivo' => 'required',
        ];

        $valida = Validator::make($data->all(), $rules);
        if ($valida->fails()) {
            return redirect()->back()->withErrors($valida)->withInput();
        }

        //dd($data->all());
        $errores_global      = [];
        $registrosInsertados = 0;
        $lote_unico          = true;

        $perfil = $data->get('perfil_id');
        //dd($this->user->id);

        $reader = Excel::selectSheetsByIndex(0)->load($data->file("archivo"))->get();

        foreach ($reader as $key => $value) {
           //dd($perfil);

                $errores = [];
                //dd($value);
                $datos   = [
                    //'req_id'                         =>$value->req_id,
                    //'direccion'                      =>$value->direccion,
                    //'fecha_nacimiento'               =>$value->fecha_nacimiento,
                    //'ciudad_expedicion_id'           =>$value->ciudad_expedicion_id,
                    //'departamento_expedicion_id'     =>$value->departamento_expedicion_id,
                    //'pais_residencia'                =>$value->pais_residencia,
                    //'ciudad_residencia'              =>$value->ciudad_residencia_residencia,
                    //'departamento_residencia'        =>$value->departamento_residencia,
                    //'pais_nacimiento'                =>$value->pais_nacimiento,
                    //'departamento_nacimiento'        =>$value->departamento_nacimiento,
                    //'aspiracion_salarial'            =>$value->aspiracion_salarial,
                    //'ciudad_nacimiento'              =>$value->ciudad_nacimiento,
                    //'pais_expedicion_id'              =>$value->pais_expedicion_id,
                    //'genero'                         =>$value->genero,
                    //'estado_civil'                   =>$value->estado_civil,
                    "identificacion"   => $value->identificacion,
                    "nombres"          => $value->nombres,
                    "primer_apellido"  => $value->primer_apellido,
                    "segundo_apellido" => $value->segundo_apellido,
                    "telefono_movil"   => $value->telefono_movil,
                    //"telefono_fijo"    => $value->telefono_fijo,
                    "email"            => $value->email,
                    "nombre_carga"     => "CARGA POR PERFIL",
                    "user_carga"       => $this->user->id

                ];
                //dd($value->nombres);

                //VALIDA LOS CAMPOS PARA EL REGISTRO EN LA BD
                $guardar = true;

                $cedula = Validator::make($datos, ["identificacion" => "required"]);
                if ($cedula->fails()) {
                    $guardar = false;
                    array_push($errores, "El campo identificacion es obligatorio");
                }
                $cedula = Validator::make($datos, ["identificacion" => "unique:citacion_carga_db,identificacion"]);
                if ($cedula->fails()) {
                    $guardar = false;
                    array_push($errores, "Este numero de identificacion ya ha sido cargado");
                }

                $cedula = Validator::make($datos, ["identificacion" => "numeric"]);
                if ($cedula->fails()) {
                    $guardar = false;
                    array_push($errores, "La identificacion debe ser numérico");
                }
                $movil = Validator::make($datos, ["telefono_movil" => "numeric"]);
                if ($movil->fails()) {
                    $guardar = false;
                    array_push($errores, "El telefono movil debe ser numérico");
                }
                /*$fijo = Validator::make($datos, ["telefono_fijo" => "numeric"]);
                if ($fijo->fails()) {
                    $guardar = false;
                    array_push($errores, "El telefono fijo no tiene el formato correcto");
                }*/

                $email = Validator::make($datos, ["email" => "required | email"]);
                if ($email->fails()) {
                    $guardar = false;
                    array_push($errores, "El campo email es obligatorio y con formato correcto");
                }

                /*$pais_nacimiento = Validator::make($datos, ["pais_nacimiento" => "required|numeric"]);
                if ($pais_nacimiento->fails()) {
                    $guardar = false;
                    array_push($errores, "el pais de nacimiento tiene que ser numérico");
                }*/

                /*$departamento_nacimiento = Validator::make($datos, ["departamento_nacimiento" => "required|numeric"]);
                if ($departamento_nacimiento->fails()) {
                    $guardar = false;
                    array_push($errores, "El  departamento de nacimiento tiene que ser numérico");
                }*/

                /*$ciudad_nacimiento = Validator::make($datos, ["ciudad_nacimiento" => "required|numeric"]);
                if ($ciudad_nacimiento->fails()) {
                    $guardar = false;
                    array_push($errores, "La  ciudad de nacimiento tiene que ser numérico");
                }*/

               /* $departamento_expedicion = Validator::make($datos, ["departamento_expedicion_id" => "required|numeric"]);
                if ($departamento_expedicion->fails()) {
                    $guardar = false;
                    array_push($errores, "El departamento de expedicion tiene que ser numérico");
                }*/

                /*$ciudad_expedicion = Validator::make($datos, ["ciudad_expedicion_id" => "required|numeric"]);
                if ($ciudad_expedicion->fails()) {
                    $guardar = false;
                    array_push($errores, "El departamento de expedicion tiene que ser numérico");
                }*/
                 
                $primer_apellido= Validator::make($datos, ["primer_apellido" => "required"]);
                
                if ($primer_apellido->fails()) {
                    $guardar = false;
                    array_push($errores, "El primer apellido es un campo obligatorio");
                }

                $segundo_apellido= Validator::make($datos, ["segundo_apellido" => "required"]);
                
                if ($primer_apellido->fails()) {
                    $guardar = false;
                    array_push($errores, "El segundo apellido es un campo obligatorio");
                }

                $nombres= Validator::make($datos, ["nombres" => "required"]);
                
                if ($nombres->fails()) {
                    $guardar = false;
                    array_push($errores, "Los nombres son campos obligatorios");
                }

                /*$fecha_nacimiento= Validator::make($datos, ["fecha_nacimiento" => "required|date"]);
                
                if ($fecha_nacimiento->fails()) {
                    $guardar = false;
                    array_push($errores, "Los nombres son campos obligatorios");
                }*/
                 
                 /*$genero= Validator::make($datos, ["genero" => "required|numeric"]);
                
                if ($genero->fails()) {
                    $guardar = false;
                    array_push($errores, "Tiene que escribir el codigo del genero en numeros");
                }*/

                 /*$estado_civil= Validator::make($datos, ["estado_civil" => "required|numeric"]);
                
                if ($estado_civil->fails()) {
                    $guardar = false;
                    array_push($errores, "Tiene que escribir el codigo del estado civil en numeros");
                }*/

                 /*$direccion= Validator::make($datos, ["direccion" => "required"]);
                
                if ($direccion->fails()) {
                    $guardar = false;
                    array_push($errores, "El campo direccion es obligatorio");
                }  */

                /*$departamento_residencia= Validator::make($datos, ["departamento_residencia" => "required|numeric"]);
                
                if ($departamento_residencia->fails()) {
                    $guardar = false;
                    array_push($errores, "Tiene que escribir el codigo del departamento de residencia en numeros");
                }*/

            
            /*$aspiracion_salarial= Validator::make($datos, ["aspiracion_salarial" => "required|numeric"]);
                
                if ($aspiracion_salarial->fails()) {
                    $guardar = false;
                    array_push($errores, "Tiene que escribir el codigo de la aspiracion salarial en numeros");
                }*/

                //Validar si el candidato se encuentra en un proceso ("seleccion","Contratacion","seguridad")

                $cedula = DatosBasicos::where("numero_id", $value->identificacion)
                     ->whereIn("estado_reclutamiento", [
                        config('conf_aplicacion.C_CONTRATADO'),
                        config('conf_aplicacion.PROBLEMA_SEGURIDAD'),
                        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                    ])
                    ->first();

                    //dd($usuario_activo);

                if ($cedula !== null) {
                    $guardar = false;
                    array_push($errores, "El usuario se encuentra en un proceso actualmente.");
                }

                //Número de lote
                if ($lote_unico == true) {
                    $lote        = CitacionCargaBd::get()->max("lote");
                    $ultimo_lote = $lote + 1;
                    $lote_unico  = false;
                }

                //dd($ultimo_lote);

                if ($guardar) {
                    $cargaReclutadores = new CitacionCargaBd();
                    $cargaReclutadores->fill($datos + ["lote" => $ultimo_lote, "estado" => 0, "motivo" => $data->get("motivo")]);
                    $cargaReclutadores->save();

                if($cedula == null){

                     $campos_usuario = [
                               'name'                     =>$value->nombres. " ".$value->primer_apellido." ".$value->segundo_apellido,
                                'email'                    =>$value->email,
                                'password'                 =>$value->identificacion,
                                'numero_id'                 =>$value->identificacion,
                                'metodo_carga'              =>2,
                                'usuario_carga'             =>$this->user->id
            ];
               
               $user                    = Sentinel::registerAndActivate($campos_usuario);
               $usuario_id = $user->id;
                   
                   //Creamos sus datos basicos
                $datos_basicos = new DatosBasicos();
                $datos_basicos->fill([
                    'numero_id'                      =>$value->identificacion,
                                //'ciudad_expedicion_id'           =>$value->ciudad_expedicion_id,
                                //'departamento_expedicion_id'     =>$value->departamento_expedicion_id,
                                //'pais_residencia'                =>$value->pais_residencia,
                                //'ciudad_residencia'              =>$value->ciudad_residencia,
                                //'departamento_residencia'        =>$value->departamento_residencia,
                                //'pais_nacimiento'                =>$value->pais_nacimiento,
                                //'pais_id'                        =>$value->pais_expedicion_id,
                                //'departamento_nacimiento'        =>$value->departamento_nacimiento,
                                //'aspiracion_salarial'            =>$value->aspiracion_salarial,
                                //'ciudad_nacimiento'              =>$value->ciudad_nacimiento,
                                //'genero'                         =>$value->genero,
                               // 'estado_civil'                   =>$value->estado_civil,
                                    'user_id'                    =>$usuario_id,
                                    'nombres'                    =>$value->nombres,
                                    //'direccion'                  =>$value->direccion,
                                    //'fecha_nacimiento'           =>$value->fecha_nacimiento,
                                    'primer_apellido'            =>$value->primer_apellido,
                                    'segundo_apellido'           =>$value->segundo_apellido,
                                    //'telefono_fijo'              =>$value->telefono_fijo,
                                    'telefono_movil'             =>$value->telefono_movil,
                                    'estado_reclutamiento'       =>config('conf_aplicacion.C_ACTIVO'),
                                    'datos_basicos_count'        =>"100",
                                    'email'                      =>$value->email
                            ]);
                    $datos_basicos->save();
                    //Creamos el rol
                    $role = Sentinel::findRoleBySlug('hv');
                    $role->users()->attach($user);

                     $perfilamiento = new PerfilCandidato();
                    $perfilamiento ->fill([
                        'perfil_id'      =>$perfil,
                        'user_id'        =>$usuario_id,
                        'user_gestion_id'=>$this->user->id

                    ]);
                    $perfilamiento->save();

                    $perfilamiento_db = new Perfilamiento();
                    $perfilamiento_db ->fill([
                        'cargo_generico_id'      =>$perfil,
                        'user_id'        =>$usuario_id
                        //'user_gestion_id'=>$this->user->id

                    ]);
                    $perfilamiento_db->save();

                }
                else{

                    $usuario_activo = DatosBasicos::where("numero_id", $value->identificacion)
                    ->first();
                    //dd($usuario_activo);
                    $perfilamiento = new PerfilCandidato();
                    $perfilamiento ->fill([
                        'perfil_id'      =>$perfil,
                        'user_id'        =>$usuario_activo->user_id,
                        'user_gestion_id'=>$this->user->id

                    ]);
                    $perfilamiento->save();

                    $perfilamiento_db = new Perfilamiento();
                    $perfilamiento_db ->fill([
                        'cargo_generico_id'      =>$perfil,
                        'user_id'        =>$usuario_activo->user_id
                        //'user_gestion_id'=>$this->user->id

                    ]);
                    $perfilamiento_db->save();

                }   
                     //Creamos el registro del usuario con su perfil

                    $registrosInsertados++;
                } 
                else {
                    $errores_global[$key] = $errores;
                }

        }

     return redirect()->route("admin.cargar_perfil_bd")->with("mensaje_success", "Se han cargado <b>$registrosInsertados</b> con exito.")->with("errores_global", $errores_global);

    }

    public function enviar_requerimiento(Request $data)
    {
        $rules = [
            'req_id'    => 'required',
            'user_id'   => 'required|min:1',
        ];

        $valida = Validator::make($data->all(), $rules);

        if($valida->fails()){
            return redirect()->route("admin.reportes_mineria")->withErrors($valida)->withInput();
        }
        
        $requerimiento = $data->get('req_id');
        $users_id =$data->get('user_id');
        $success = true;
        $transferir_candidato = [];
        $asocio_candidato = false;

        $errores_global      = [];
        $registrosInsertados = 0;
        $sitio = Sitio::first();

        foreach($users_id as $key => $user_id){
            $errores = [];
            $transferir = false;
            
            $guardar = true;
            
            $candidato = ReqCandidato::where("candidato_id", $user_id)->whereIn("estado_candidato", [
                config('conf_aplicacion.C_CONTRATADO'),
                config('conf_aplicacion.PROBLEMA_SEGURIDAD'),
                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                config('conf_aplicacion.C_EN_EXAMENES_MEDICOS'),
            ])
            ->where('requerimiento_id',$requerimiento)
            ->first();
            
            //consultar si el candidato esta en un proceso activo
            $datos_basicos = DatosBasicos::where("user_id", $user_id)->first();
            $desc = $datos_basicos->getTipoIdentificacion()->descripcion;
            $tipo_doc_desc = ($desc != '' ? $desc : 'Nro. identificación');

            if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD')) {
                $guardar = false;
                $success = false;
                $lista_negra = ListaNegra::leftjoin('tipos_restricciones', 'tipos_restricciones.id', '=', 'lista_negra.restriccion_id')
                    ->select('tipos_restricciones.descripcion as restriccion')
                    ->where('cedula', $datos_basicos->numero_id)
                    ->orderBy('lista_negra.id', 'desc')
                ->first();

                if($lista_negra != null && $lista_negra->restriccion != null) {
                    $mensaje_error = '<li>El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> ' . $tipo_doc_desc . ' <b>' . $datos_basicos->numero_id . '</b> no se puede asociar al requerimiento porque presenta problemas de seguridad.<br>Se encuentra '. $lista_negra->restriccion .'</li>';
                } else {
                    $mensaje_error = '<li>El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> ' . $tipo_doc_desc . ' <b>' . $datos_basicos->numero_id . '</b> no se puede asociar al requerimiento porque presenta problemas de seguridad.</li>';
                }

                array_push($errores, $mensaje_error);
            } else if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO') || $datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_BAJA_VOLUNTARIA')){
                $guardar = false;
                $success = false;

                //Si esta inactivo
                if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO')) {
                    $auditoria = Auditoria::where('tabla', 'datos_basicos')
                        ->where('tabla_id', $datos_basicos->id)
                        ->whereIn('tipo', ['ACTUALIZAR', 'RECHAZAR_CANDIDATO_INACTIVAR'])
                        ->orderBy('id', 'desc')
                    ->first();

                    if (is_null($auditoria)) {
                        $auditoria = new Auditoria();
                        $auditoria->observaciones = '';
                    } else if ($auditoria->tipo == 'RECHAZAR_CANDIDATO_INACTIVAR') {
                        //Si se rechazo el candidato desde un Requerimiento, se busca la observacion
                        $proceso = RegistroProceso::where('candidato_id', $datos_basicos->user_id)
                            ->where('proceso', 'RECHAZAR_CANDIDATO')
                            ->orderBy('id', 'desc')
                        ->first();

                        if (!is_null($proceso)) {
                            $auditoria->observaciones = $proceso->observaciones;
                        }
                    }

                    array_push($errores, "<li>El candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> $tipo_doc_desc <b>" . $datos_basicos->numero_id . "</b> no se puede agregar porque tiene un estado inactivo.<br>Observación: $auditoria->observaciones</li>");
                } else {
                    array_push($errores, "<li>El candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> no se puede agregar porque solicitó baja voluntaria en la plataforma.</li>");
                }
            } elseif(!is_null($candidato)) {
                //si el requerimiento es el mismo al que se intenta asociar
                $guardar = false;
                $success = false;
                array_push($errores, "<li>El candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> $tipo_doc_desc <b>" . $datos_basicos->numero_id . "</b> se encuentra en ese requerimiento.</li>");
            } else {
                //buscar el requerimiento del candidato
                $req_candidato = ReqCandidato::where("candidato_id", $user_id)->orderBy('id','DESC')->first();

                if($req_candidato !== null) {
                    $guardar = false;
                    $success = false;
                    $transferir = true;

                    $transferir_candidato[] = $req_candidato->id;
                }
            }//fin de si no se encuentra en ese req pero si en otro

            if($guardar){
                $asocio_candidato = true;
                $req_candi = new ReqCandidato();

                $req_candi ->fill([
                    'requerimiento_id'    =>$requerimiento,
                    'candidato_id'        =>$user_id,
                    'estado_candidato'    =>config('conf_aplicacion.C_EN_PROCESO_SELECCION')
                ]);
                  
                $req_candi->save();                   

                $candidato  = DatosBasicos::where("user_id", $user_id)
                    ->select(
                        'datos_basicos.numero_id as cedula',
                        'datos_basicos.nombres',
                        'datos_basicos.email',
                        'datos_basicos.primer_apellido',
                        'datos_basicos.segundo_apellido',
                        'datos_basicos.user_id'
                    )
                ->first();

                $candidato->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                $candidato->save();

                $req_can_id = $req_candi->id;
                   
                $nuevo_proceso = new RegistroProceso();

                $nuevo_proceso->fill([
                    'requerimiento_candidato_id' => $req_can_id,
                    'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                    'fecha_inicio'               => date("Y-m-d H:i:s"),
                    'usuario_envio'              => $this->user->id,
                    'requerimiento_id'           => $req_candi->requerimiento_id,
                    'candidato_id'               => $user_id,
                    'observaciones'              => "Ingreso al requerimiento desde mineria de datos sin transferir",
                ]);

                $nuevo_proceso->save();
            
                $obj  = new \stdClass();
                $obj->requerimiento_id = $req_candi->requerimiento_id;
                $obj->user_id          = $this->user->id;
                $obj->estado           = config('conf_aplicacion.C_EN_PROCESO_SELECCION');

                Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));
                $registrosInsertados++;

                try {

                    $cargo_esp = DB::table("cargos_especificos")->join("requerimientos", "requerimientos.cargo_especifico_id","=", "cargos_especificos.id")
                        ->leftjoin("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
                        ->where("requerimientos.id", $requerimiento)
                        ->select(
                            "cargos_especificos.id as cargo",
                            "cargos_especificos.firma_digital as firma",
                            "tipo_proceso.cod_tipo_proceso"
                        )
                    ->first();

                    if (!empty($cargo_esp) && $cargo_esp->cod_tipo_proceso != 'PB') {
                        //Si el codigo de tipo de proceso es distinto de Proceso Backup (PB)

                        $cargo_documentos = null;
                        if ($sitio->asistente_contratacion == 1 && $cargo_esp->firma == 1){
                            //Si el sitio tiene asistente y el cargo tiene firma digital, se buscan los documentos asociados al cargo categoria 1 y que pueda cargar el candidato
                            $cargo_documentos = DocumentosCargo::join('tipos_documentos','tipos_documentos.id','=','cargo_documento.tipo_documento_id')
                                ->where('cargo_documento.cargo_especifico_id', $cargo_esp->cargo)
                                ->where('tipos_documentos.categoria', 1)
                                ->where('tipos_documentos.carga_candidato', 1)
                                ->select(
                                    'tipos_documentos.id',
                                    'tipos_documentos.descripcion'
                                )
                            ->get();

                            if (count($cargo_documentos) == 0) {
                                //En caso que el cargo no tenga asociados tipos de documento mostrar listados los tipos de documento con cod_tipo_doc=CC
                                $cargo_documentos = TipoDocumento::where('cod_tipo_doc', "CC")
                                    ->where('tipos_documentos.categoria', 1)
                                    ->where('tipos_documentos.carga_candidato', 1)
                                    ->select(
                                        'tipos_documentos.id',
                                        'tipos_documentos.descripcion'
                                    )
                                ->get();
                            }
                        }

                        $nombre_empresa = "Desarrollo";
                        if (isset($sitio->nombre) && $sitio->nombre != "") {
                            $nombre_empresa = $sitio->nombre;
                        }

                        //**************correo de asocian candidato a requerimiento***********************
                        $home = route('home');
                        $urls = route('home.detalle_oferta', ['oferta_id' => $requerimiento]);

                        $nombre = ucwords(strtolower($candidato->nombres." ".$candidato->primer_apellido));

                        $asunto = "Notificación de proceso de selección";

                        $emails = $candidato->email;

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

                        if (is_null($cargo_documentos)) {

                            $mailAditionalTemplate = [];

                        }else{

                            $mailAditionalTemplate = ['nameTemplate' => 'proceso_seleccion', 'dataTemplate' => ["cargo_documentos" => $cargo_documentos]];
                        }

                        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser, $mailAditionalTemplate);

                        if (route('home') == 'https://listos.t3rsc.co') {
                            Mail::send('admin.enviar_email_candidatos_otras_fuentes_listos', [
                                "home" => $home,
                                "cargo_documentos" => $cargo_documentos,
                                "url" => $urls,
                                "req_can_id" => $req_can_id,
                                "nombre" => $nombre
                            ], function($message) use ($data, $emails, $asunto, $sitio) {
                                $message->to($emails, '$nombre - T3RS');
                                $message->subject($asunto)
                                ->bcc($sitio->email_replica)
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                            });
                        }else{
                            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($emails, $asunto, $nombre_empresa, $sitio) {

                                $message->to($emails, "$nombre_empresa - T3RS");
                                $message->subject($asunto)
                                    ->bcc($sitio->email_replica)
                                    ->getHeaders()
                                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                            });
                        }
                    }

                } catch (\Exception $e) {
                    logger('Excepción capturada en CitacionController @enviar_requerimiento al enviar correo de notificacion de asociacion al requerimiento: '.  $e->getMessage(). "\n");
                }

                $success = true;
            } elseif (!$transferir) {
                $errores_global[$key] = $errores;
            }
        }

        if (count($transferir_candidato) > 0) {
            $procesos_transferibles = DB::table('tipos_procesos_manejados')->where('active', 1)->where('transferible', 1)->pluck('nombre_trazabilidad');

            $procesos_transferibles_string = "('".implode("','", $procesos_transferibles->all())."')";

            $otros_procesos = DB::table('tipos_procesos_manejados')->where('active', 1)->where('transferible', 0)->pluck('nombre_trazabilidad');

            $otros_procesos_string = "('".implode("','", $otros_procesos->all())."')";

            $req_candidato_string = "('".implode("','", $transferir_candidato)."')";

            $candidatos_transferir = RegistroProceso::join('datos_basicos', 'datos_basicos.user_id', '=', 'procesos_candidato_req.candidato_id')
                ->leftjoin('tipo_identificacion', 'tipo_identificacion.id', '=', 'datos_basicos.tipo_id')
                ->whereIn('procesos_candidato_req.requerimiento_candidato_id', $transferir_candidato)
                ->select(
                    'datos_basicos.nombres',
                    'datos_basicos.numero_id',
                    'datos_basicos.primer_nombre',
                    'datos_basicos.primer_apellido',
                    'procesos_candidato_req.requerimiento_id as requerimiento',
                    'procesos_candidato_req.requerimiento_candidato_id as req_cand',
                    'tipo_identificacion.descripcion as tipo_doc_desc',

                    DB::raw('(select estados.descripcion from requerimiento_cantidato inner join estados on estados.id = requerimiento_cantidato.estado_candidato where requerimiento_cantidato.id = req_cand limit 1) as estado_actual'),

                    DB::raw('(select users.name from procesos_candidato_req inner join users on users.id = procesos_candidato_req.usuario_envio where procesos_candidato_req.requerimiento_candidato_id = req_cand order by procesos_candidato_req.id asc limit 1) as usuario_asocio'),

                    DB::raw('(select procesos_candidato_req.created_at from procesos_candidato_req where procesos_candidato_req.requerimiento_candidato_id = req_cand order by procesos_candidato_req.id asc limit 1) as fecha_asocio'),

                    DB::raw("(select GROUP_CONCAT(proceso,' | ',nombre_visible SEPARATOR ', ') from procesos_candidato_req left join tipos_procesos_manejados on tipos_procesos_manejados.nombre_trazabilidad = procesos_candidato_req.proceso where procesos_candidato_req.requerimiento_candidato_id = req_cand and procesos_candidato_req.proceso in $procesos_transferibles_string) as procesos_transferibles"),

                    DB::raw("(select GROUP_CONCAT(proceso,' | ',IF(nombre_visible is null,proceso,nombre_visible) SEPARATOR ', ') from procesos_candidato_req left join tipos_procesos_manejados on tipos_procesos_manejados.nombre_trazabilidad = procesos_candidato_req.proceso where procesos_candidato_req.requerimiento_candidato_id = req_cand and procesos_candidato_req.proceso in $otros_procesos_string and procesos_candidato_req.proceso != 'ASIGNADO_REQUERIMIENTO') as procesos")
                )
                ->groupBy('procesos_candidato_req.requerimiento_candidato_id')
            ->get();

            $req_id = $requerimiento;
            $tabla_aplicar = 'mineria_datos';
            $otra_fuente_id = 1;
            $observacion_ingreso = 'Ingreso al requerimiento desde mineria de datos';
            $modulo_gestion = 'mineria_datos';
            $errores_array = [];
            foreach ($errores_global as  $value) {
                $errores_array[] = $value[0];
            }

            return response()->json([
                "success" => true,
                "transferir_directo" => false,
                "candidatos_transferir" => $candidatos_transferir,
                "view" => view("admin.reclutamiento.modal._modal_candidatos_a_transferir",
                    compact(
                        "req_id",
                        "candidatos_transferir",
                        "asocio_candidato",
                        "tabla_aplicar",
                        "otra_fuente_id",
                        "observacion_ingreso",
                        "errores_array",
                        "modulo_gestion"
                    )
                )->render()
            ]);
        }

        if($data->ajax()){
            return response()->json(["success" => $success,"errores"=>$errores_global,"transferir"=>$transferir]);
        }

        return redirect()->back()->with("mensaje_success", "Se han enviado los candidatos al requerimiento $requerimiento , Se han cargado $registrosInsertados con exito. ")->with("errores_global", $errores_global);
    }


    public function lista_perfil(Request $data){

        $perfil_candidato = ["" => "Seleccionar"] + CargoEspecifico::groupBy('descripcion')
                        ->orderBy('descripcion','asc')
                        ->pluck("descripcion", "id")
                        ->toArray();
            //dd($perfil_candidato);

        $requerimientos = ["" =>"seleccionar"] + Requerimiento::whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado in( " . config('conf_aplicacion.C_TERMINADO') . ",".config('conf_aplicacion.C_SOLUCIONES') .  ",".config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') .  "))"))->pluck("id","id")->toArray();

        $perfiles = PerfilCandidato::join('users','users.id','=','perfilacion_candidato.user_id')
          ->join('datos_basicos','datos_basicos.user_id','=','users.id')
          ->join('ciudad', function ($join) {
                $join->on('datos_basicos.ciudad_nacimiento', '=', 'ciudad.cod_ciudad')
                    ->on('datos_basicos.departamento_nacimiento', '=', 'ciudad.cod_departamento')
                    ->on('datos_basicos.pais_nacimiento', '=', 'ciudad.cod_pais');
            })
          ->join('departamentos', function ($join2) {
                $join2->on('datos_basicos.departamento_nacimiento', '=', 'departamentos.cod_departamento')
                    ->on('datos_basicos.pais_nacimiento', '=', 'departamentos.cod_pais');
            })
          ->join('paises', 'datos_basicos.pais_nacimiento', '=', 'paises.cod_pais')
          ->leftJoin('cargos_especificos','cargos_especificos.id','=','perfilacion_candidato.perfil_id')

          ->where(function($sql) use ($data){

            if($data->get('nombre')!=""){

             $sql->whereRaw("( LOWER(datos_basicos.nombres) like '%" . $data->get("nombre") . "%'or LOWER(datos_basicos.primer_apellido) like '%" . $data->get("nombre") . "%'or LOWER(datos_basicos.segundo_apellido) like '%" . $data->get("nombre") . "%') ");
            }
            
            if($data->get('perfil_id') != ""){
              $sql->where("perfil_id", $data->get('perfil_id'));
            }

            if($data->get("ciudad_id") != ""){
              $sql->where("datos_basicos.ciudad_nacimiento", $data->get("ciudad_id"));
            }

            if($data->get('edad_inicial') != "" && $data->get('edad_final') != ""){
              
              $sql->whereBetween(DB::raw('round(datediff(now(),fecha_nacimiento)/365)'),[$data->get('edad_inicial'),$data->get('edad_final')]);
            }

            if($data->get('fecha_actualizacion_ini') != "" && $data->get('fecha_actualizacion_fin') != ""){

              $sql->whereBetween(DB::raw('DATE_FORMAT(perfilacion_candidato.created_at, \'%Y-%m-%d\')'),[$data->get('fecha_actualizacion_ini'),$data->get('fecha_actualizacion_fin')]);
            }
            
            if($data->get('cedu') != ""){
              $sql->where("datos_basicos.numero_id", $data->get('cedu'));
            }
                 
            })
        ->select(
                'cargos_especificos.descripcion',
                'perfilacion_candidato.user_gestion_id',
                 'perfilacion_candidato.user_id',
                'datos_basicos.*',
                'ciudad.nombre as ciudad',
               // DB::raw('(select upper(p.name)  from perfilacion_candidato o inner join users p on o.user_gestion_id=p.id ) as usuario_gestiono'),
                DB::raw('date_format(perfilacion_candidato.created_at,"%Y/%m/%d")as fecha'),
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'))
       ->paginate(10);
       //dd($perfiles);

         return view("admin.citacion.proceso_recluta.lista_perfil", compact( "perfil_candidato","perfiles","requerimientos"));

    }

    public function citacion_masiva(Request $data)
    {
           $user            = $this->user;
        $motivo_carga_db =RecepcionMotivo::where("id", 8)->pluck("descripcion", "id")->toArray();

        return view("admin.citacion.proceso_recluta.citacion_masiva", compact("requerimientos","user", "motivo_carga_db"));
    }

    public function carga_citacion_masiva(Request $data)
    {

        $rules = [
            'motivo'  => 'required|min:1',
            'archivo' => 'required',
             'nombre_carga' => 'required',
             'mensaje' => 'required',
        ];

        $valida = Validator::make($data->all(), $rules);
        if ($valida->fails()) {
            return redirect()->back()->withErrors($valida)->withInput();
        }

        $errores_global      = [];
        $registrosInsertados = 0;
        $lote_unico          = true;

        $reader = Excel::selectSheetsByIndex(0)->load($data->file("archivo"))->get();
        //dd($reader);
        foreach ($reader as $key => $value) {
           
                $errores = [];
                //dd($value);
                $datos  = [
                    'req_id'=>$value->req_id,
                    "identificacion"   => $value->identificacion,
                    "nombres"          => $value->nombres,
                    "primer_apellido"  => $value->primer_apellido,
                    "segundo_apellido" => $value->segundo_apellido,
                    "telefono_movil"   => $value->telefono_movil,
                   /* "telefono_fijo"    => $value->telefono_fijo,*/
                    "email"            => $value->email,
                    "user_carga"       => $this->user->id,
                ];
                //dd($value->nombres);

                //VALIDA LOS CAMPOS PARA EL REGISTRO EN LA BD
                $guardar = true;

                $cedula = Validator::make($datos, ["identificacion" => "required"]);
                if ($cedula->fails()) {
                    $guardar = false;
                    array_push($errores, "El campo identificacion es obligatorio");
                }
                $cedula = Validator::make($datos, ["identificacion" => "unique:citacion_carga_db,identificacion"]);
                if ($cedula->fails()) {
                    $guardar = false;
                    array_push($errores, "Este numero de identificacion ya ha sido cargado");
                }

                $cedula = Validator::make($datos, ["identificacion" => "numeric"]);
                if ($cedula->fails()) {
                    $guardar = false;
                    array_push($errores, "La identificacion no tiene el formato correcto");
                }


                $movil = Validator::make($datos, ["telefono_movil" => "numeric"]);
                if ($movil->fails()) {
                    $guardar = false;
                    array_push($errores, "El telefono movil no tiene el formato correcto");
                }
              

                $email = Validator::make($datos, ["email" => "required"]);
                if ($email->fails()) {
                    $guardar = false;
                    array_push($errores, "El campo email es obligatorio");
                }

                 
                $primer_apellido= Validator::make($datos, ["primer_apellido" => "required"]);
                
                if ($primer_apellido->fails()) {
                    $guardar = false;
                    array_push($errores, "El primer apellido es un campo obligatorio");
                }

                $segundo_apellido= Validator::make($datos, ["segundo_apellido" => "required"]);
                
                if ($primer_apellido->fails()) {
                    $guardar = false;
                    array_push($errores, "El segundo apellido es un campo obligatorio");
                }
                $nombres= Validator::make($datos, ["nombres" => "required"]);
                
                if ($nombres->fails()) {
               //dd($datos['nombres']);
                    $guardar = false;
                    array_push($errores, "Los nombres son campos obligatorios");
                }


                $cedula = DatosBasicos::where("numero_id", $value->identificacion)
                    ->whereIn("estado_reclutamiento", [
                        config('conf_aplicacion.C_CONTRATADO'),
                        config('conf_aplicacion.PROBLEMA_SEGURIDAD'),
                        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                    ])
                    ->first();


                if ($cedula !== null) {
                    $guardar = false;
                    array_push($errores, "El usuario se encuentra en un proceso.");
                }

                //Número de lote
                if ($lote_unico == true) {
                    $lote        = CitacionCargaBd::get()->max("lote");
                    $ultimo_lote = $lote + 1;
                    $lote_unico  = false;
                }

                //dd($ultimo_lote);

                if ($guardar) {
    
                       //Creamos el usuario
                      $campos_usuario = [
                               'name'  =>$value->nombres. " ".$value->primer_apellido." ".$value->segundo_apellido,
                                'email' =>$value->email,
                                'password' =>$value->identificacion,
                                'numero_id'=>$value->identificacion,
                                'cedula'  =>$value->identificacion
                      ];
                     
                     $user = Sentinel::registerAndActivate($campos_usuario);
                     $usuario_id = $user->id;
                   
                     //Creamos sus datos basicos
                    $datos_basicos = new DatosBasicos();
                    $datos_basicos->fill([
                                'numero_id'                      =>$value->identificacion,
                                /*'ciudad_expedicion_id'           =>$value->ciudad_expedicion_id,
                                'departamento_expedicion_id'     =>$value->departamento_expedicion_id,
                                'pais_residencia'                =>$value->pais_residencia,
                                'ciudad_residencia'              =>$value->ciudad_residencia,
                                'departamento_residencia'        =>$value->departamento_residencia,
                                'pais_nacimiento'                =>$value->pais_nacimiento,
                                'pais_id'                        =>$value->pais_id,
                                'ciudad_id'                      =>$value->ciudad_id,
                                'departamento_id'                =>$value->departamento_id,
                                'departamento_nacimiento'        =>$value->departamento_nacimiento,
                                'aspiracion_salarial'            =>$value->aspiracion_salarial,
                                'ciudad_nacimiento'              =>$value->ciudad_nacimiento,
                                'genero'                         =>$value->genero,
                                'estado_civil'                   =>$value->estado_civil,*/
                                    'user_id'                    =>$usuario_id,
                                    'nombres'                    =>$value->nombres,
                                    
                                   /* 'direccion'                  =>$value->direccion,*/
                                   /* 'fecha_nacimiento'           =>$value->fecha_nacimiento,*/
                                    'primer_apellido'            =>$value->primer_apellido,
                                    'segundo_apellido'           =>$value->segundo_apellido,
                                    /*'telefono_fijo'              =>$value->telefono_fijo,*/
                                    'telefono_movil'             =>$value->telefono_movil,
                                    'estado_reclutamiento'       =>config('conf_aplicacion.C_ACTIVO'),
                                    'datos_basicos_count'        =>"100",
                                    'email'                      =>$value->email
                            ]);
                    $datos_basicos->save();

                //dd($datos_basicos);
                    //Creamos el rol
                    $role = Sentinel::findRoleBySlug('hv');
                    $role->users()->attach($user);

                     $cargaReclutadores = new CitacionCargaBd();
                    $cargaReclutadores->fill($datos + ["user_id" => $usuario_id,"lote" => $ultimo_lote, "estado" => 0, "motivo" => $data->get("motivo"),"nombre_carga" => $data->get("nombre_carga")]);
                    $cargaReclutadores->save();

                     //Lo asociamos a un requerimiento

                    $req_estado = Requerimiento::join("estados_requerimiento","estados_requerimiento.req_id","=","requerimientos.id")
                    ->where("id", $value->req_id)
                    //***************** req2 *************
                    ->whereIn("estados_requerimiento.estado",
                     [ config('conf_aplicacion.C_INACTIVO'),
                         config('conf_aplicacion.C_TERMINADO'),
                        config('conf_aplicacion.C_CLIENTE'),
                        config('conf_aplicacion.C_SOLUCIONES'),])
                    ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')

                    ->first();

            
                if ($req_estado !== null) {
                    $guardar = false;
                    array_push($errores, "El requerimiento  ".$value->req_id." no esta activo");
                }



                     $req = Requerimiento::where("id", $value->req_id)
                    ->first();
                
                 if ($req == null) {
                    $guardar = false;
                    array_push($errores, "El requerimiento ".$value->req_id." no existe");
                }
                   
       if($value->req_id > 1){

            $req_can = new ReqCandidato();
            
            $req_can ->fill([
                   'requerimiento_id'    =>$value->req_id,
                   'candidato_id'        =>$usuario_id,
                   'estado_candidato'    =>config('conf_aplicacion.C_EN_PROCESO_SELECCION')
                ]);
                                          
            $req_can->save();


                    $urls = route('home.detalle_oferta', ['oferta_id' => $value->req_id]);
                    $url_oferta = Bitly::getUrl($urls);

                    //Envio de mensaje
            $urlapi = 'https://go4clients.com/TelintelSms/api/sms/send';

             $destino = "57" . $value->telefono_movil;
             $mensaje = $data->mensaje;

            $dataa = array(
                'to'      => $destino,
                'message' => "Buen dia " . $value->nombres . ",  ". $mensaje.",".   $url_oferta ,
            );

            $options = array(
                'http' => array(
                    'method'  => 'POST',
                    'content' => json_encode($dataa),
                    'header'  => array("Host: go4clients.com", "Content-Type: application/json", "Apikey: ca16b4d3626346f39c5fd33f69cb46dc", "Apisecret: 25184841718344"),
                ),
            );

            $lol      = json_encode($dataa);
            $context  = stream_context_create($options);
            $result   = file_get_contents($urlapi, false, $context);
            $response = json_decode($result);

                    //Envio de llamada
       
          $this->ValidarLlamada($destino,$mensaje);


                     $candidato  = DatosBasicos::where("user_id", $datos_basicos->user_id)->first();
                     $candidato->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                    $candidato->save();
                    $req_can_id = $req_can->id;
                   
                    $nuevo_proceso = new RegistroProceso();

                                        $nuevo_proceso->fill(
                                            [
                                                'requerimiento_candidato_id' => $req_can_id,
                                                'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                                                'fecha_inicio'               => date("Y-m-d H:i:s"),
                                                'usuario_envio'              => $this->user->id,
                                                'requerimiento_id'           =>$value->req_id,
                                                'candidato_id'               =>$usuario_id,
                                                'observaciones'              => "Ingreso al requerimiento",
                                            ]
                                        );
                                        $nuevo_proceso->save();
                                   $obj                   = new \stdClass();
                                   $obj->requerimiento_id = $value->req_id;
                                   $obj->user_id          = $this->user->id;
                                   $obj->estado           = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                                   Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));


  } 
                    $registrosInsertados++;
                } 

                else {
                    $errores_global[$key] = $errores;
                }

        }
        return redirect()->route("admin.citacion_virtual")->with("mensaje_success", "Se han cargado <b>$registrosInsertados</b> con exito.")->with("errores_global", $errores_global);

    }

    public function ValidarLlamada($destino,$mensaje)
    {

        $url_audio  = route('home') . "/configuracion_sitio/audio.wav";


        //$quitar_seguridad_url = str_replace("https://", "http://", $url_audio);

        $url = 'https://cloud.go4clients.com:8580/api/campaigns/voice/v1.0/'.env('GO4CLIENTS_LLAMADA', '5c939f6ecd51a70007786dad');

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

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data,JSON_UNESCAPED_SLASHES),
                'header'  => array("Content-Type: application/json", "apiKey: fbfc74edc94c4377a6be329924b65e20", "apiSecret: 5331739984726387"),
            ),
        );

        $context  = stream_context_create($options);
        $result   = file_get_contents($url, false, $context);
        $response = json_decode($result);
        // dd($response);
    }

    /*
    *   Guardar carga masiva db
    */
    public function reclutamiento_carga_db(Request $data){
        $rules = [
            'motivo'  => 'required|min:1',
            'archivo' => 'required',
            'nombre_carga' => 'required',
        ];

        $valida = Validator::make($data->all(), $rules);
                
        if($valida->fails()){
            return redirect()->back()->withErrors($valida)->withInput();
        }

        $errores_global      = [];
        $registrosInsertados = 0;
        $lote_unico          = true;
        $funcionesGlobales = "";

        //if(route("home") == "https://desarrollo.t3rsc.co"){
            //dd($data->file("archivo"));
        // }

        //Obtiene archivo de firmas
        /*$archivo_carga   = $data->file('archivo_carga');
        $extencion_archivo_carga = $archivo_carga->getClientOriginalExtension();
        $nombre_archivo_carga  = "recursos_adjuntos_masiva_" . $data->get("nombre_carga") . ".$extencion_archivo_carga";

        $data->file('archivo_carga')->move("recursos_adjuntos_masiva", $nombre_archivo_carga);*/

        //
        $reader = Excel::selectSheetsByIndex(0)->load($data->file("archivo"))->get();

        if(count($reader)>500){
            $data->session()->flash('limite_maximo', "El archivo debe tener un maximo de 500 registros para efectuar la carga.");
             return redirect()->back()->withInput();
        }

        foreach($reader as $key => $value){
            $errores = [];

            $datos   = [
                'req_id'           => $value->req_id,
                "identificacion"   => $value->identificacion,
                "nombres"          => $value->nombres,
                "primer_apellido"  => $value->primer_apellido,
                "segundo_apellido" => $value->segundo_apellido,
                "telefono_movil"   => $value->telefono_movil,
                /* "telefono_fijo"    => $value->telefono_fijo,*/
                "email"            => $value->email,
                "user_carga"       => $this->user->id,
                //"archivo_carga"    => $nombre_archivo_carga,
            ];

            //VALIDA LOS CAMPOS PARA EL REGISTRO EN LA BD
            $guardar = true;
            $validacion_email=true;

            $cedula = Validator::make($datos, ["identificacion" => "required|min:1"]);

            if($cedula->fails()){
                $guardar = false;
                array_push($errores, "El campo identificacion es obligatorio");
            }

            $cedula = Validator::make($datos, ["identificacion" => "unique:citacion_carga_db,identificacion"]);

            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "Este numero de identificacion ya ha sido cargado");
            }

            $cedula = Validator::make($datos, ["identificacion" => "numeric"]);

            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "La identificacion no tiene el formato correcto");
            }

            if($datos['identificacion'] == '0'){
                $guardar = false;
                array_push($errores, "La identificacion no tiene el formato correcto no 0");
            }

            $movil = Validator::make($datos, ["telefono_movil" => "numeric"]);

            if ($movil->fails()) {
                $guardar = false;
                array_push($errores, "El telefono movil no tiene el formato correcto");
            }

            $email = Validator::make($datos, ["email" => "required|email"]);

            if ($email->fails()) {
                $guardar = false;
                array_push($errores, "El campo correo con formato de email correcto es obligatorio.");
            }

            $email = Validator::make($datos, ["email" =>"email"]);

            if ($email->fails()) {
                $guardar = false;
                array_push($errores, "Escribir correctamente el correo");
            }
                     
            $primer_apellido= Validator::make($datos, ["primer_apellido" => "required"]);

            if ($primer_apellido->fails()) {
                $guardar = false;
                array_push($errores, "El primer apellido es un campo obligatorio");
            }

            $segundo_apellido= Validator::make($datos, ["segundo_apellido" => "required"]);
                
            if($primer_apellido->fails()){
                $guardar = false;
                array_push($errores, "El segundo apellido es un campo obligatorio");
            }

            $nombres= Validator::make($datos, ["nombres" => "required"]);                    
                
            if($nombres->fails()){
                $guardar = false;
                array_push($errores, "Los nombres son campos obligatorios");
            }

            /*$archivo_carga_firmas= Validator::make($datos, ["archivo_carga" => "required"]);                    
                
            if($archivo_carga_firmas->fails()){
                $guardar = false;
                array_push($errores, "El archivo de firmas obligatorio");
            }*/

            //Validar si el candidato se encuentra en un proceso ("seleccion","Contratacion","seguridad")
            if($value->req_id){
                $req_estado = Requerimiento::join("estados_requerimiento","estados_requerimiento.req_id","=","requerimientos.id")
                ->where("requerimientos.id", $value->req_id)
                ->whereIn("estados_requerimiento.estado",[ 
                    config('conf_aplicacion.C_INACTIVO'),
                    config('conf_aplicacion.C_TERMINADO'),
                    config('conf_aplicacion.C_CLIENTE'),
                    config('conf_aplicacion.C_SOLUCIONES'),])
                 ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
                ->first();
                
                if($req_estado !== null) {
                    $guardar = false;
                    array_push($errores, "El requerimiento  ".$value->req_id." no esta activo");
                }

                $req = Requerimiento::where("id",$value->req_id)->first();

                if($req == null){
                    $guardar = false;
                    array_push($errores, "El requerimiento ".$value->req_id." no existe");
                }
            }

            $usuario_exi = DatosBasicos::where("numero_id", $value->identificacion)->first();

            if($usuario_exi !== null){
                //Si esta inactivo
                $exis_req = DB::table("requerimiento_cantidato")
                ->whereNotIn("requerimiento_cantidato.estado_candidato", [config('conf_aplicacion.C_QUITAR'), config('conf_aplicacion.C_INACTIVO')])
                ->where("candidato_id", $usuario_exi->user_id);

                if($exis_req->count() > 0){
                    array_push($errores, "El Candidato ". $usuario_exi->numero_id." ya se encontraba en un requerimiento");

                    $var = "Telefono no Ingresado";

                    $candidatos_fuentes = CandidatosFuentes::create([
                        "nombres"          => $value->nombres. " ".$value->primer_apellido." ".$value->segundo_apellido,
                        "cedula"           => $value->identificacion,
                        "telefono"         => $var,
                        "celular"          => $value->telefono_movil,
                        "email"            => $value->email,
                        "tipo_fuente_id"   => 11,
                        "requerimiento_id" => $value->req_id,
                    ]);

                    //$guardar = false;
                    // $req = $exis_req->select("requerimiento_cantidato.requerimiento_id", "requerimiento_cantidato.id as candidato_req")
                    //   ->first();

                    //BUSCAR QUIEN LO INGRESO
                    // $usuario_regitro = RegistroProceso::where("requerimiento_candidato_id", $req->candidato_req)->where("estado", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->orderBy("procesos_candidato_req.id","DESC")->first();

                    /*  
                        if($usuario_regitro !== null){
                        array_push($errores, "<li>  <input type='hidden' name='req_" . $req->candidato_req . "' value='" . $req->requerimiento_id . "'> <input type='hidden' id='nuevo_req' name='req_id_" . $req->candidato_req."' value='" .$value->req_id. "'> <input type='checkbox' name='candidato_req[]' value='" . $req->candidato_req . "'>   EL candidato <strong>" . $usuario_exi->nombres . " " . $usuario_exi->primer_apellido . " " . $usuario_exi->segundo_apellido . " </strong> actualmente se encuentra asignado al requerimiento <strong>" . $req->requerimiento_id . "</strong> el cual fue asociado por <strong>" . $usuario_regitro->usuarioRegistro()->name . "</strong> el pasado " . $usuario_regitro->created_at . " .</li>");
                        
                        $guardar = false;
                        }
                    */

                    $guardar = false;
                }else{
                    $guardar = true;
                }

                if(in_array($usuario_exi->estado_reclutamiento,[config('conf_aplicacion.C_INACTIVO'),])){
                    array_push($errores, "El Candidato ". $usuario_exi->numero_id." se encuentra inactivo");
                    $guardar = false;
                }

                $lote  = CitacionCargaBd::get()->max("lote");
                $ultimo_lote = $lote + 1;
                $lote_unico  = true;
                
                // array_push($errores, "El usuario ya existe");
                //dd($datos.'_____'.$data->all());

                $cargaReclutadores = new CitacionCargaBd();

                $cargaReclutadores->fill($datos + [
                    "user_id"        => $usuario_exi->user_id,
                    "lote"           => $ultimo_lote,
                    "estado"         => 0,
                    "motivo"         => $data->get("motivo"),
                    "nombre_carga"   => $data->get("nombre_carga"),
                    "req_id"         => $value->req_id
                ]);
                    
                $cargaReclutadores->save();
            }

            //verificar si ya existe en un req
            //  $can_req = ReqCandidato::join('estados_requerimiento','estados_requerimiento.req_id','=','requerimiento_cantidato.requerimiento_id')
            //  ->where('requerimiento_cantidato.candidato_id',$usuario_exi->user_id)->first();
                 
            //dd($can_req);

            //  if(!is_null($can_req)){
            //funcion para tranasferir el candidat
            //   array_push($errores, "El Candidato ". $usuario_exi->numero_id." ya se encuentra en un requerimiento");
                  
            /*
                $var = "Telefono no Ingresado";

                $candidatos_fuentes = CandidatosFuentes::create([
                  "nombres"          => $value->nombres. " ".$value->primer_apellido." ".$value->segundo_apellido,
                  "cedula"           => $value->identificacion,
                  "telefono"         => NULL,
                  "celular"          => $value->telefono_movil,
                  "email"            => $value->email,
                  "tipo_fuente_id"   => 16,
                  "requerimiento_id" => $value->req_id,
                ]);
            */
                    
            //      $guardar = false;
            //    }
                 
            //$guardar = true;                
            //Número de lote

            if($lote_unico == true){
                $lote        = CitacionCargaBd::get()->max("lote");
                $ultimo_lote = $lote + 1;
                $lote_unico  = false;
            }



            if($guardar){
                if(is_null($usuario_exi)){
                    
                    $validar_email=json_decode($this->verificar_email($value->email));

                    if($validar_email->status==200 && !$validar_email->valid){

                         array_push($errores, "Correo ".$value->email." no válido. Verifique que exista la cuenta o el  proveedor de correos.");
                        $errores_global[$key] = $errores;

                        $validacion_email=false;

                    }
                    else{
                       $telefono_movil= substr($value->telefono_movil,0,2);

                    if($telefono_movil == '57'){
                        $telefono_movil= substr($value->telefono_movil,2);
                    }else{
                        $telefono_movil= substr($value->telefono_movil,10);  
                    }

                    //Creamos el usuario
                    $campos_usuario = [
                        'name'         =>$value->nombres. " ".$value->primer_apellido." ".$value->segundo_apellido,
                        'email'        =>$value->email,
                        'password'     =>$value->identificacion,
                        'numero_id'    =>$value->identificacion,
                        'cedula'       =>$value->identificacion,
                        'metodo_carga' =>2,
                        'usuario_carga' =>$this->user->id,
                    ];
                
                    $user = Sentinel::registerAndActivate($campos_usuario);
                    
                    $usuario_id = $user->id;

                    //Creamos sus datos basicos
                    $datos_basicos = new DatosBasicos();

                    $datos_basicos->fill([
                        'numero_id'             => $value->identificacion,
                        'user_id'               => $usuario_id,
                        'nombres'               => $value->nombres,
                        'primer_apellido'       => $value->primer_apellido,
                        'segundo_apellido'      => $value->segundo_apellido,
                        'telefono_movil'        => $value->telefono_movil,
                        'estado_reclutamiento'  => config('conf_aplicacion.C_ACTIVO'),
                        'datos_basicos_count'   => "100",
                        'email'                 => $value->email
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
                        $auditoria->observaciones = 'Se registro por carga masiva y se encuentra en listado especial con la restricción ' . $restriccion->descripcion;
                        $auditoria->valor_antes   = json_encode(["estado" => config('conf_aplicacion.C_ACTIVO')]);
                        $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.PROBLEMA_SEGURIDAD')]);
                        $auditoria->user_id       = $gestiono;
                        $auditoria->tabla         = "datos_basicos";
                        $auditoria->tabla_id      = $datos_basicos->id;
                        $auditoria->tipo          = 'ACTUALIZAR';
                        event(new \App\Events\AuditoriaEvent($auditoria));
                    }

                    $datos_basicos->save();

                    Event::dispatch(new PorcentajeHvEvent($datos_basicos));

                    //Creamos el rol
                    $role = Sentinel::findRoleBySlug('hv');
                    $role->users()->attach($user);

                    $job = (new SendEmailCargaMasiva($user));
        
                    $this->dispatch($job);

                    /*$funcionesGlobales = new FuncionesGlobales();

                    if(isset($sitio->nombre)){
                      
                      if($sitio->nombre != "") {
                        $nombre = $sitio->nombre;
                      }else{
                        $nombre = "Desarrollo";
                      }
                    }

                    Mail::queue('emails.notificacion_preregistro', ["datos_basicos" => $datos_basicos], function($message) use($datos_basicos, $nombre) {

                            $message->to($datos_basicos->email, $datos_basicos->nombres)->subject("Bienvenido a $nombre - T3RS");
                        });*/
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

                    $cargaReclutadores = new CitacionCargaBd();

                    $cargaReclutadores->fill($datos + [
                        "user_id"        => $usuario_id,
                        "lote"           => $ultimo_lote,
                        "estado"         => 0,
                        "motivo"         => $data->get("motivo"),
                        "nombre_carga"   => $data->get("nombre_carga"),
                        "req_id"         => $value->req_id
                    ]);
                    
                    $cargaReclutadores->save();


                    }
                    }else{
                        $usuario_id = $usuario_exi->user_id;

                    }
                   
                    //Lo asociamos a un requerimiento
                    if($value->req_id){
                        $req_can = ReqCandidato::where('requerimiento_id',$value->req_id)->where('candidato_id',$usuario_id)->first();
                      
                        if(is_null($req_can)){
                            $req_can = new ReqCandidato();
                            
                            $req_can ->fill([
                                'requerimiento_id'    =>$value->req_id,
                                'candidato_id'        =>$usuario_id,
                                'estado_candidato'    =>config('conf_aplicacion.C_EN_PROCESO_SELECCION')
                            ]);

                            $req_can->save();
                        
                            $datos_basicos_2=DatosBasicos::where('numero_id',$value->identificacion)->first();
                            $candidato  = DatosBasicos::where("user_id", $datos_basicos_2->user_id)->first();
                        
                            $candidato->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                        
                            $candidato->save();
                        
                            $req_can_id = $req_can->id;

                            $nuevo_proceso = new RegistroProceso();

                            $nuevo_proceso->fill([
                                'requerimiento_candidato_id' => $req_can_id,
                                'estado'        => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                                'fecha_inicio'               => date("Y-m-d H:i:s"),
                                'usuario_envio'              => $this->user->id,
                                'proceso'                    => 'ASIGNADO_REQUERIMIENTO',
                                'requerimiento_id'           => $value->req_id,
                                'candidato_id'               => $usuario_id,
                                'observaciones'              => "Ingreso al requerimiento",
                            ]);

                            $nuevo_proceso->save();
                          
                            $obj                   = new \stdClass();
                            $obj->requerimiento_id = $value->req_id;
                            $obj->user_id          = $this->user->id;
                            $obj->estado           = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
                            
                            Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));

                            $nombres = $candidato->nombres;
                            $asunto = "Invitación al proceso de selección de personal";
                            $emails = trim($candidato->email);

                            //Se encripta el id del usuario
                            $encrypt_user_id = Crypt::encrypt($candidato->user_id);

                            $mensaje = "Buen día ".$nombres.",
                               te informamos que estás participando en uno de nuestros procesos de selección, por lo cual te invitamos a que completes los datos de tu hoja de vida haciendo clic en el boton \"Acceder\". Emplea como usuario tu correo electrónico (al que te enviamos esta invitación) y en el campo contraseña usa tu número de cédula,¡Bienvenido!";
                                                      
                            Mail::send('admin.enviar_email_candidatos_recha', ["mensaje" => $mensaje, "encrypt_user_id" => $encrypt_user_id], function($message) use ($emails, $asunto, $nombres) {
                                $message->to($emails, $nombres)->subject($asunto)
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                            });

                        }else{
                            array_push($errores, "El Candidato ".$datos_basicos->numero_id." ya se encuentra en el requerimiento");
                        }
                    }

                    if($guardar && $validacion_email){
                        $registrosInsertados++;
                    }
                }else{
                    $errores_global[$key] = $errores;
                }

                
            }//fin del foreach

            /*$funcionesGlobales = new FuncionesGlobales();

            if (isset($funcionesGlobales->sitio()->nombre)) {
                if ($funcionesGlobales->sitio()->nombre != "") {
                    $nombre = $funcionesGlobales->sitio()->nombre;
                }else{
                    $nombre = "Desarrollo";
                }
            }*/

            return redirect()->route("admin.cargar_archivo_bd")->with("mensaje_success", "Se han cargado <b>$registrosInsertados</b> con exito.")->with("errores_global", $errores_global);
        }

    public function mensajeTexto($numero,$nombre){

        $numero_sin_espacios = trim($numero);
        $url = 'https://cloud.go4clients.com:8580/api/campaigns/sms/v1.0/5c92a562d54feb0007c4d0d2';

     if (route('home')== "http://listos.t3rsc.co") {
         # code...
     $mensaje = "vym te invita a participar en proceso de selección, completa tus datos aquí éxitos!!";

     }else{
        $mensaje = "estás en un proceso de selección, completa tus datos aquí ,¡éxitos!";
     }

     
     $urls = route('login');
     //dd($urls);

       $url_oferta = Bitly::getUrl($urls);
        $destino="57".$numero_sin_espacios;
        $data = array(
            'destinationsList'      =>[$destino],
            "priority"=>"HIGH",

            'message' => "Hola " . $nombre . ", " . $mensaje . " " . $url_oferta ,
        );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data),

                'header'  => array("Content-Type: application/json", "apiKey: fbfc74edc94c4377a6be329924b65e20", "apiSecret: 5331739984726387"),
            ),
        );

        //$lol      = json_encode($data);
        $context  = stream_context_create($options);
        $result   = file_get_contents($url, false, $context);
        $response = json_decode($result);
        //dd($response);
    }
    //Validar ", Requests\ValidaProcesoReclutador $valida"
    public function guardar_proceso_candidato(Request $data)
    {
        //dd($data->all());
        //Variable valida
        $return = $data->get("return");

        //Validar los compos requeridos
        $valida = Validator::make($data->all(), ['email' => 'required|email|max:255']);

        if ($valida->fails()) {
            return redirect()->back()->withErrors($valida);
        }

        if ($data->get("user_id") == "") {
            //CREAR USUARIO
            $valida = Validator::make($data->all(), ['email' => 'required|email|max:255|unique:users,email']);

            if ($valida->fails()) {
                return redirect()->back()->withErrors($valida);
            }

            $campos_usuario = [
                "name"      => $data->get("nombres") . " " . $data->get("primer_apellido") . " " . $data->get("segundo_apellido"),
                "email"     => $data->get("email"),
                "password"  => $data->get("numero_id"),
                "numero_id" => $data->get("numero_id"),
            ];

            $usuario    = Sentinel::registerAndActivate($campos_usuario);
            $usuario_id = $usuario->id;
            //Crear HV
            $datos_basicos = new DatosBasicos();
            $datos_basicos->fill($data->all() + ["user_id" => $usuario->id, "datos_basicos_count" => "20", "estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')]);
            $datos_basicos->user_id = $usuario->id;
            $datos_basicos->save();

            //Agregar Rol Usuario
            $role = Sentinel::findRoleBySlug('hv');
            $role->users()->attach($usuario);
        }

        //perfilando candidato
        $datos_user = DatosBasicos::where("numero_id", $data->get("numero_id"))->first();
        //Crear perfilamiento

        $cargos_genericos = $data->get("cargos_genericos");

        $cargos_insertados = [];
        if (is_array($cargos_genericos)) {
            foreach ($cargos_genericos as $key => $value) {
                //BUSCA SI EL CARGO YA FUE REGISTRADO
                $cargo = PerfilamientoCandidato::where("CANDIDATO_ID", $datos_user->user_id)->where("TABLA", "CARGOS_GENERICOS")->where("TABLA_ID", $value)->first();
                if ($cargo == null) {
                    if ($value != "") {
                        //CONSULTAR SI YA EXITE EL PERFIL
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

        //Crear citación
        $citacion = new CitacionCandidato();
        $citacion->fill([
            "user_id"        => $datos_user->user_id,
            "user_recepcion" => $this->user->id,
            "id_motivo"      => $data->get("id_motivo"),
            "direccion_cita" => $data->get("direccion_cita"),
            "fecha_cita"     => $data->get("fecha_cita"),
            "hora_cita"      => $data->get("hora_cita"),
            "observaciones"  => $data->get("observaciones"),
            "estado"         => 0,
            "tipificacion"   => $data->get("tipificacion"),
        ]);
        $citacion->save();

        //ACTUALIZAR EL REGISTRO DE CARGA BD DEL RECLUTADOR
        if ($data->get("db_carga_id") != "") {
            $carga         = CitacionCargaBd::find($data->get("db_carga_id"));
            $carga->estado = 1;
            $carga->save();
        }

        $franja_hora = FranjaHoraria::where("estado", 1)
            ->where("id", $data->get("hora_cita"))
            ->first();

        $direccion     = $data->get("direccion_cita");
        $fecha         = $data->get("fecha_cita");
        $hora          = $franja_hora->descripcion;
        $observaciones = $data->get("observaciones");

        //Enviar Notificación Segun Motivo
        //::Si motivo es ENTREGA HV::
        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        if ($data->get("id_motivo") == 1) {
            Mail::send('emails.citacion.entrega_hv', ["direccion" => $direccion, "fecha" => $fecha, "hora" => $hora, 'datos_user' => $datos_user, 'observaciones' => $observaciones], function ($message) use ($data) {
                $message->to($data->get("email"), '$nombre -T3RS')->subject('Notificación (Entrega Hoja de Vida)!')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }
        //::Si motivo es ENTREVISTA::
        if ($data->get("id_motivo") == 2) {
            Mail::send('emails.citacion.entrevista', ["direccion" => $direccion, "fecha" => $fecha, "hora" => $hora, 'datos_user' => $datos_user], function ($message) use ($data) {
                $message->to($data->get("email"), '$nombre -T3RS')->subject('Notificación (Entrevista)!')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }
        //::Si motivo es EXAMEN MEDICO::
        if ($data->get("id_motivo") == 3) {
            Mail::send('emails.citacion.examenes_medicos', ["direccion" => $direccion, "fecha" => $fecha, "hora" => $hora, 'datos_user' => $datos_user], function ($message) use ($data) {
                $message->to($data->get("email"), '$nombre -T3RS')->subject('Notificación (Exámenes Medicos)!')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }
        //::Si motivo es PRUEBAS::
        if ($data->get("id_motivo") == 4) {
            Mail::send('emails.citacion.prueba', ["direccion" => $direccion, "fecha" => $fecha, "hora" => $hora, 'datos_user' => $datos_user], function ($message) use ($data) {
                $message->to($data->get("email"), '$nombre -T3RS')->subject('Notificación (Realizar Prueba)!')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }
        //::Si motivo es VISITA DOMICILIARIA::
        if ($data->get("id_motivo") == 5) {
            Mail::send('emails.citacion.visita_domiciliaria', ["direccion" => $direccion, "fecha" => $fecha, "hora" => $hora, 'datos_user' => $datos_user, 'observaciones' => $observaciones], function ($message) use ($data) {
                $message->to($data->get("email"), '$nombre -T3RS')->subject('Notificación (Visita Domiciliaria)!')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }
        //::Si motivo es ENTREGA DE DOCUMENTOS::
        if ($data->get("id_motivo") == 6) {
            Mail::send('emails.citacion.entrega_documentos', ["direccion" => $direccion, "fecha" => $fecha, "hora" => $hora, 'datos_user' => $datos_user, 'observaciones' => $observaciones], function ($message) use ($data) {
                $message->to($data->get("email"), '$nombre -T3RS')->subject('Notificación (Entrega de Documentos)!')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }
        //::Si motivo es CONTRATACION::
        if ($data->get("id_motivo") == 7) {
            Mail::send('emails.citacion.contratacion', ["direccion" => $direccion, "fecha" => $fecha, "hora" => $hora, 'datos_user' => $datos_user, 'observaciones' => $observaciones], function ($message) use ($data) {
                $message->to($data->get("email"), '$nombre -T3RS')->subject('Notificación (Contratación)!')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }
        //::Si motivo es OTRO::
        if ($data->get("id_motivo") == 10) {
            Mail::send('emails.citacion.otro', ["direccion" => $direccion, "fecha" => $fecha, "hora" => $hora, 'datos_user' => $datos_user, 'observaciones' => $observaciones], function ($message) use ($data) {
                $message->to($data->get("email"), '$nombre -T3RS')->subject('Notificación (Otro)!')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }
        //Enviar Notificación Segun Tipificacion
        //::Si tipificacion es Examenes Medicos::
        if ($data->get("tipificacion") == "NE") {
            Mail::send('emails.citacion.llamada_fallida', ["direccion" => $direccion, "fecha" => $fecha, "hora" => $hora, 'datos_user' => $datos_user, 'observaciones' => $observaciones], function ($message) use ($data) {
                $message->to($data->get("email"), '$nombre -T3RS')->subject('Notificación (Llamada Fallida)!')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }

        if($return == true) {
          return redirect()->route("admin.call_center")->with("mensaje_success", "El candidato se ha citado.");
        }else{
            //admin.citacion_reclutamiento
          return redirect()->route("admin.proceso_reclutadores")->with("mensaje_success", "El candidato se ha citado.");
        }
    }

    public function citar_candidato_proceso(Request $data)
    {
        //dd($data->all());
        $motivos = ["" => "Seleccionar"] + RecepcionMotivo::where("active", 1)->pluck("descripcion", "id")->toArray();

        $usuario       = $data->get("candidato_user");
        $cliente       = $data->get("cliente_id");
        $requerimiento = $data->get("candidato_req");

        return view("admin.citacion.modal.citar_candidato", compact("motivos", "usuario", "cliente", "requerimiento"));
    }

    public function guardar_citacion(Request $data)
    {
        $candidato = DatosBasicos::where("user_id", $data->get("user_id"))
            ->first();
        //dd($candidato);

        //Guardar Citacion
        $new_cita = new CitacionCargaBd();
        $new_cita->fill([
            "user_carga"       => $this->user->id,
            "identificacion"   => $candidato->numero_id,
            "nombres"          => $candidato->nombres,
            "primer_apellido"  => $candidato->primer_apellido,
            "segundo_apellido" => $candidato->segundo_apellido,
            "telefono_fijo"    => $candidato->telefono_fijo,
            "telefono_movil"   => $candidato->telefono_movil,
            "email"            => $candidato->email,
            "motivo"           => $data->get("motivos"),
            "observaciones"    => $data->get("descripcion"),
            "estado"           => 0,
        ]);
        $new_cita->save();

        return response()->json(["success" => true]);
    }

    //Reclutador envia candidato para que sea gestionado en el modulo call center
    public function enviar_call_center(Request $data)
    {

        //dd($data->all());
        if ($data->get("id_carga") != "") {
            $carga                = CitacionCargaBd::find($data->get("id_carga"));
            $carga->remitido_call = 1;
            $carga->save();

            return redirect()->route("admin.citacion_reclutamiento")->with("mensaje_success", "El candidato se ha remitido al modulo de call center.");
        } else {
            return redirect()->back()->with("mensaje_success", "Problemas con el ID del candidato");
        }
    }

    //Reclutador envia candidato para que sea gestionado en el modulo call center
    public function enviar_call_center_nuevo(Request $data)
    {

        //dd($data->all());
        $rules = [
            'numero_id'        => 'required|min:1|numeric',
            'nombres'          => 'required|min:3',
            'primer_apellido'  => 'required|min:3',
            'segundo_apellido' => 'required|min:3',
            'telefono_movil'   => 'required|min:3|numeric',
            'telefono_fijo'    => 'required|min:3|numeric',
            'email'            => 'required|min:3|email',
        ];

        $valida = Validator::make($data->all(), $rules);
        if ($valida->fails()) {
            $mensaje = "Información no guardada, Error. Información candidato requerida.";

            return response()->json(["mensaje_danger" => $mensaje, "success" => false, "errors" => $valida->messages()]);
        }

        /*
        $rules = [
        'numero_id' => 'unique:citacion_carga_db,identificacion|unique:datos_basicos,numero_id',
        'email' => 'unique:citacion_carga_db,email|unique:datos_basicos,email'
        ];

        $valida = Validator::make($data->all(), $rules);
        if ($valida->fails()) {
        $mensaje="Información no guardada, Error. El número de identificacion o email ya estan registrados.";

        return response()->json(["mensaje_danger" => $mensaje, "success" => false, "errors" => $valida->messages()]);
        }
         */

        $cargaReclutadores = new CitacionCargaBd();
        $cargaReclutadores->fill($data->all() + ["identificacion" => $data->numero_id, "estado" => 0, "motivo" => 8, "remitido_call" => 1, "user_carga" => $this->user->id]);
        $cargaReclutadores->save();

        $mensaje = "Información guardada. El candidato se envio a call center.";

        return response()->json(["mensaje_success" => $mensaje, "success" => true]);
    }

    public function cargaMasiva(Request $data){
        
        if(\triRoute::validateOR('local')){
            set_time_limit(400);
        }

        $candidatos=[];
        $requerimientos=[];
       
        $data1=[];


        $rules = [
            'motivo'  => 'required|min:1',
            'archivo' => 'required',
            'nombre_carga' => 'required',
        ];

        $valida = Validator::make($data->all(), $rules);
                
        if($valida->fails()){
            return redirect()->back()->withErrors($valida)->withInput();
        }

        $errores_global      = [];
        $registrosInsertados = 0;
        $lote_unico          = true;
        $funcionesGlobales = "";

       
        $reader = Excel::selectSheetsByIndex(0)->filter('chunk')->load($data->file("archivo"))->chunk(250, function($results) use($data, &$registrosInsertados, &$errores_global, &$lote_unico,&$data1)
        {
            foreach($results as $key=>$value)
            {
                 $info=["cedula"=>null, "nombres"=>null,"primer_nombre"=>null,"segundo_nombre"=>null,"primer_apellido"=>null,"telefono"=>null,"email"=>null,"error"=>null,"registro"=>null,"asociacion"=>null,"req_id"=>null,"candi_id"=>null,"envio_email_registro"=>false,"datos_basicos"=>null];
                 $info["cedula"]=(string)$value->identificacion;
                $errores = [];
                $segundo_nombre = ($value->segundo_nombre != null && $value->segundo_nombre != '' ? ' ' . $value->segundo_nombre : '');
                $datos   = [
                    'req_id'           => $value->req_id,
                    "identificacion"   => $value->identificacion,
                    "nombres"          => $value->primer_nombre . $segundo_nombre,
                    "primer_nombre"    => $value->primer_nombre,
                    "segundo_nombre"   => $value->segundo_nombre,
                    "primer_apellido"  => $value->primer_apellido,
                    "segundo_apellido" => $value->segundo_apellido,
                    "telefono_movil"   => $value->telefono_movil,
                    "email"            => $value->email,
                    "user_carga"       => $this->user->id
                ];

                $usuario_exi = DatosBasicos::where("numero_id", $value->identificacion)->first();
                if($usuario_exi){
                     $validator= Validator::make($datos,[
                        "identificacion"    => "required|min:1|numeric",
                        "telefono_movil"    => "numeric",
                        "email"             => "required|email",
                        "primer_apellido"   => "required",
                        "primer_nombre"     => "required"
                    ]);

                }
                else{
                    $validator= Validator::make($datos,[
                        "identificacion"    => "required|min:1|numeric|unique:datos_basicos,numero_id",
                        "telefono_movil"    => "numeric",
                        "email"             => "required|email|unique:datos_basicos,email",
                        "primer_apellido"   => "required",
                        "primer_nombre"     => "required"
                    ]);

                }

                if($validator->fails()){
                    $errores_global[$key] = ["errores"=>$validator->errors()->all(),"tipo"=>"error"];
                    $info["error"]=$errores_global[$key]["errores"];
                    $data1[$key]=$info;
                    //dd($errores_global);
                    continue;

                }
                else{
                    
                    //$usuario_exi = DatosBasicos::where("numero_id", $value->identificacion)->first();
                    if($usuario_exi== null){
                        $validar_email=json_decode($this->verificar_email($value->email));
                        if($validar_email->status==200 && !$validar_email->valid){

                            array_push($errores, "Correo ".$value->email." no válido. Verifique que exista la cuenta o el proveedor de correos.");
                            $errores_global[$key] = ["errores"=>$errores,"tipo"=>"error"];
                            $info["error"] = $errores;
                            $data1[$key]=$info;


                            $validator->errors()->add('field', 'Something is wrong with this field!');

                            $validacion_email=false;

                            $errores_global[$key] = ["errores"=>$validator->errors()->all(),"tipo"=>"error"];

                            continue;

                        }
                        else{
                            $telefono_movil= substr($value->telefono_movil,0,2);

                            if($telefono_movil == '57'){
                                $telefono_movil= substr($value->telefono_movil,2);
                            } else {
                                $telefono_movil= substr($value->telefono_movil,10);  
                            }

                            //Creamos el usuario
                            if ($value->segundo_apellido != null && $value->segundo_apellido != '') {
                                $name = $value->primer_nombre.$segundo_nombre." ".$value->primer_apellido." ".$value->segundo_apellido;
                            } else {
                                $name = $value->primer_nombre.$segundo_nombre." ".$value->primer_apellido;
                            }

                            $campos_usuario = [
                                'name'          =>$name,
                                'email'         =>$value->email,
                                'password'      =>$value->identificacion,
                                'numero_id'     =>$value->identificacion,
                                'cedula'        =>$value->identificacion,
                                'metodo_carga'  =>2,
                                'usuario_carga' =>$this->user->id,
                            ];
                        
                            $user = Sentinel::registerAndActivate($campos_usuario);
                            
                            $usuario_id = $user->id;

                            //Creamos sus datos basicos
                            $datos_basicos = new DatosBasicos();

                            $datos_basicos->fill([
                                'numero_id'             => $value->identificacion,
                                'user_id'               => $usuario_id,
                                "nombres"               => $value->primer_nombre . $segundo_nombre,
                                'primer_nombre'         => $value->primer_nombre,
                                'segundo_nombre'        => $value->segundo_nombre,
                                'primer_apellido'       => $value->primer_apellido,
                                'segundo_apellido'      => $value->segundo_apellido,
                                'telefono_movil'        => $value->telefono_movil,
                                'estado_reclutamiento'  => config('conf_aplicacion.C_ACTIVO'),
                                'datos_basicos_count'   => "100",
                                'email'                 => $value->email
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
                                $auditoria->observaciones = 'Se registro por carga masiva y se encuentra en listado especial con la restricción ' . $restriccion->descripcion;
                                $auditoria->valor_antes   = json_encode(["estado" => config('conf_aplicacion.C_ACTIVO')]);
                                $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.PROBLEMA_SEGURIDAD')]);
                                $auditoria->user_id       = $gestiono;
                                $auditoria->tabla         = "datos_basicos";
                                $auditoria->tabla_id      = $datos_basicos->id;
                                $auditoria->tipo          = 'ACTUALIZAR';
                                event(new \App\Events\AuditoriaEvent($auditoria));
                            }

                            $datos_basicos->save();

                            Event::dispatch(new PorcentajeHvEvent($datos_basicos));

                            //Creamos el rol
                            $role = Sentinel::findRoleBySlug('hv');
                            $role->users()->attach($user);

                            //$job = (new SendEmailCargaMasiva($user));
                
                            //$this->dispatch($job);

                            $lote  = CitacionCargaBd::get()->max("lote");
                            $ultimo_lote = $lote + 1;

                            $cargaReclutadores = new CitacionCargaBd();

                            $cargaReclutadores->fill($datos + [
                                "user_id"        => $usuario_id,
                                "lote"           => $ultimo_lote,
                                "estado"         => 0,
                                "motivo"         => $data->get("motivo"),
                                "nombre_carga"   => $data->get("nombre_carga"),
                                "req_id"         => $value->req_id
                            ]);
                            
                            $cargaReclutadores->save();

                            $registrosInsertados++;
                            $info["registro"]="Si, candidato registrado";
                            $info["envio_email_registro"]=true;
                            $info["datos_basicos"]=$datos_basicos;
                            $info["candi_id"]=$usuario_id;
                            $info["nombres"]=$datos_basicos->primer_nombre." ". $datos_basicos->segundo_nombre;
                            $info["primer_apellido"]=$datos_basicos->primer_apellido;
                            $info["telefono"]=$datos_basicos->telefono_movil;
                            $info["email"]=$datos_basicos->email;
                            if($value->req_id!=null and $value->req_id!=""){

                                //array_push($candidatos,$datos_basicos->user_id);
                                //array_push($requerimientos,$value->req_id);
                                $info["req_id"]=$value->req_id;
                            }

                        }
                    }
                    else{//El usuario ya existe y se envia la notificación
                        if ($usuario_exi->estado_reclutamiento === config('conf_aplicacion.C_BAJA_VOLUNTARIA')) {
                            $errores_global[$key] = ["errores"=> "La cédula ".$usuario_exi->numero_id." ya existe en el sistema. Pero solicitó la baja voluntaria en la plataforma.","tipo"=>"error"];
                            $info["error"]=$errores_global[$key]["errores"];
                            $data1[$key]=$info;
                            continue;
                        } elseif ($usuario_exi->estado_reclutamiento === config('conf_aplicacion.PROBLEMA_SEGURIDAD')) {
                            $errores_global[$key] = ["errores"=> "La cédula ".$usuario_exi->numero_id." ya existe en el sistema. Pero no se puede asociar porque presenta problema de seguridad.","tipo"=>"error"];
                            $info["error"]=$errores_global[$key]["errores"];
                            $data1[$key]=$info;
                            continue;
                        } elseif ($usuario_exi->estado_reclutamiento === config('conf_aplicacion.C_INACTIVO')) {
                            $errores_global[$key] = ["errores"=> "La cédula ".$usuario_exi->numero_id." ya existe en el sistema. Pero no se puede asociar porque se encuentra inactivo.","tipo"=>"error"];
                            $info["error"]=$errores_global[$key]["errores"];
                            $data1[$key]=$info;
                            continue;
                        }
                        $info["registro"]="No, candidato existente";
                        $info["candi_id"]=$usuario_exi->user_id;
                        $info["nombres"]=$usuario_exi->nombres;
                        $info["primer_apellido"]=$usuario_exi->primer_apellido;
                        $info["telefono"]=$usuario_exi->telefono_movil;
                        $info["email"]=$usuario_exi->email;

                        //Se evalua si se quiere asociar a un req
                        if($value->req_id!=null and $value->req_id!=""){
                            //array_push($candidatos,$usuario_exi->user_id);
                            //array_push($requerimientos,$value->req_id);

                            $info["req_id"]=$value->req_id;
                            array_push($errores, "La cédula ".$usuario_exi->numero_id." ya existe en el sistema. Se intentará asociar al Req #".$value->req_id);
                        }
                        else{
                            array_push($errores, "La cédula ".$usuario_exi->numero_id." ya existe en el sistema.");
                        }
                        $errores_global[$key] = ["errores"=>$errores,"tipo"=>"info"];
                    }

                }

            $data1[$key]=$info;


            }//Foreach
        },false);//reader


        //Programando Jobs para hacer las asociaciones
        $job2 = (new AsociarCandidatoReq($data1,$this->user));

        $this->dispatch($job2);


        return redirect()->route("admin.cargar_archivo_bd")->with("mensaje_success", "Se han cargado <b>$registrosInsertados</b> con éxito.")->with("errores_global", $errores_global);
    }

}
