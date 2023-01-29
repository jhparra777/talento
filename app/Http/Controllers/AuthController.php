<?php

namespace App\Http\Controllers;

use Event;
use triPostmaster;
use App\Models\Sitio;
use App\Http\Requests;
use App\Models\Auditoria;
use App\Models\Archivo_hv;
use App\Models\ListaNegra;
use App\Models\DatosBasicos;
use Illuminate\Http\Request;
use App\Models\NivelEstudios;
use App\Jobs\FuncionesGlobales;
use App\Events\PorcentajeHvEvent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\User as UsersSentile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\PoliticaPrivacidadCandidato;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function postRegister(Request $request, Requests\ValidaRegistroHVRequest $valida)
    {
        //REGISTRAR USUARIO  KOMATSU
        $ip = $request->ip();
        
        if(route('home') == "https://komatsu.t3rsc.co" || route('home') == "http://komatsu.t3rsc.co") {
            $datos_registro = [
                "ip_registro" => $ip,
                "numero_id" => $request->get("identificacion"),
                "name" => $request->get("name") . " " . $request->get("primer_apellido") . " " . $request->get("segundo_apellido")
            ] + $request->only("email", "password");
    
            $user  = Sentinel::registerAndActivate($datos_registro);
          
            //CREAR ACTIVACION
            $activation = Activation::create($user);

            //CREA HV
            $datos_basicos = new DatosBasicos();
            
            $datos_basicos->fill($request->all() + [
                "numero_id" => $request->get("identificacion"),
                "user_id" => $user->id,
                "nombres" => $request->get("name"),
                "datos_basicos_count" => "20",
                "estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')
            ]);

            //Se verifica si a la persona que se registra esta en la lista negra, se coloca en estado_reclutamiento, que tiene problema de seguridad
            $cand_lista_negra = ListaNegra::where('cedula', $data->get("identificacion"))->first();
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
                $auditoria->observaciones = 'Se registro personalmente y se encuentra en listado especial con la restricción ' . $restriccion->descripcion;
                $auditoria->valor_antes   = json_encode(["estado" => config('conf_aplicacion.C_ACTIVO')]);
                $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.PROBLEMA_SEGURIDAD')]);
                $auditoria->user_id       = $gestiono;
                $auditoria->tabla         = "datos_basicos";
                $auditoria->tabla_id      = $datos_basicos->id;
                $auditoria->tipo          = 'ACTUALIZAR';
                event(new \App\Events\AuditoriaEvent($auditoria));
            }

            $datos_basicos->save();

            //AGREGAR ROL USUARIO
            $role = Sentinel::findRoleBySlug('hv');        
            $role->users()->attach($user);

            Event::dispatch(new PorcentajeHvEvent($datos_basicos));
         
            $home =  route('home');
            $urls = route('login');
            $email = $datos_basicos->email;
            $asunto = "Pre-Registro Komatsu";

            $mensaje = 'Bienvenido '.$datos_basicos->nombres.', a la comunidad komatsu! esperamos encuentres tu trabajo deseado con nosotros'.PHP_EOL.' 
            te invitamos a que apliques a nuestras ofertas y las refieras a tus amigos!!'.PHP_EOL.'
            haz clic en el siguiente botón';

            Mail::send('admin.enviar_email_registros_koma', ["home"=>$home,"url"=>$urls,"mensaje" => $mensaje], function($message) use ($email, $asunto) {
                $message->to($email, '$nombre - T3RS')->subject($asunto)
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }else{
            //REGISTRAR USUARIO  
            $datos_registro = [
                "metodo_carga"=>1,
                "ip_registro" => $ip,
                "numero_id" => $request->get("identificacion"),
                "name" => $request->get("primer_nombre") . " " .$request->get("segundo_nombre")." ". $request->get("primer_apellido") . " " . $request->get("segundo_apellido")
            ] + $request->only("email", "password");

            $validar_email=json_decode($this->verificar_email($request->get("email")));
            if($validar_email->status==200 && !$validar_email->valid){

                $request->session()->flash('email_verificacion', $validar_email->mensaje);
                return redirect()->route("registrarse");
            }

            $user = Sentinel::registerAndActivate($datos_registro);
          
            //CREAR ACTIVACION
            $activation = Activation::create($user);


            
            //CREA HV
            $datos_basicos = new DatosBasicos();
            $datos_basicos->fill($request->all() + [
                "numero_id" => $request->get("identificacion"),
                "user_id" => $user->id,
                "nombres" => $request->get("primer_nombre") . " " .$request->get("segundo_nombre"),
                "datos_basicos_count" => "20",
                "estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO'),
                "acepto_politicas_privacidad" => $request->get("acepto_politicas_privacidad"),
                /*"politicas_privacidad_id"   => $request->get("politicas_privacidad_id"),
                "fecha_acepto_politica"     => date('Y-m-d'),
                "hora_acepto_politica"      => date('H:i:s'),
                "ip_acepto_politica"        => $ip,
                "acepto_politicas_privacidad_2021" => 1,
                "fecha_acepto_politica_2021" => date('Y-m-d'),
                "ip_acepto_politica_2021" => $ip*/
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
                $auditoria->observaciones = 'Se registro personalmente y se encuentra en listado especial con la restricción ' . $restriccion->descripcion;
                $auditoria->valor_antes   = json_encode(["estado" => config('conf_aplicacion.C_ACTIVO')]);
                $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.PROBLEMA_SEGURIDAD')]);
                $auditoria->user_id       = $gestiono;
                $auditoria->tabla         = "datos_basicos";
                $auditoria->tabla_id      = $datos_basicos->id;
                $auditoria->tipo          = 'ACTUALIZAR';
                event(new \App\Events\AuditoriaEvent($auditoria));
            }

            $datos_basicos->save();
            
            foreach( $request->get("politicas_privacidad_id") as $politica_id )
            {
                //guardamos info de politica
                $aceptacion_politica = new PoliticaPrivacidadCandidato();

                $aceptacion_politica->fill([
                    'politica_privacidad_id' => $politica_id,
                    'candidato_id'            => $datos_basicos->user_id,
                    'fecha_acepto_politica' => date('Y-m-d'),
                    'hora_acepto_politica'  => date('H:i:s'),
                    'ip_acepto_politica' => $ip
                    
                ]);

                $aceptacion_politica->save();
            }

            //documento guardar
            if ($request->hasFile('archivo_documento')) {
                $archivo_hv     = $request->file("archivo_documento");
                $extencion      = $archivo_hv->getClientOriginalExtension();

                if ($extencion == 'jpg' || $extencion == 'png' || $extencion == 'jpeg' || $extencion == 'pdf' || $extencion == 'doc' || $extencion == 'docx') {

                    $archivo = new Archivo_hv();
                    $archivo->fill($request->all() + [
                        "user_id" => $user->id,
                        "archivo" => $request->get("archivo_documento")
                    ]);
                    $archivo->save();

                    $name_documento = "documento_hv_" . $archivo->id . "." . $extencion;
                    $archivo_hv->move("archivo_hv", $name_documento);
                    $archivo->archivo = $name_documento;
                    $archivo->save();

                }
            }

            //AGREGAR ROL USUARIO
            $role = Sentinel::findRoleBySlug('hv');
            $role->users()->attach($user);

            Event::dispatch(new PorcentajeHvEvent($datos_basicos));

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
                ¡Hola $datos_basicos->nombres $datos_basicos->primer_apellido $datos_basicos->segundo_apellido!
                <br/><br/>
                Se ha creado exitosamente tu cuenta en T3RS, te invitamos a ingresar usando tu número de documento como usuario y contraseña para completar tu hoja de vida y cargar tus documentos.
                ";
            //Arreglo para el botón
            $mailButton = ['buttonText' => '¡COMPLETA TU HOJA DE VIDA!', 'buttonRoute' => route('login')];

            $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $nombre, $sitio) {

                    $message->to($datos_basicos->email, $datos_basicos->nombres)
                            ->bcc($sitio->email_replica)
                            ->subject("Bienvenido a $nombre - T3RS")
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }

        $this->postLogin($request);

        return redirect()->route("datos_basicos");
    }

    public function getRegister()
    {
        $menu = DB::table("menu_home")->where("estado",1)->orderBy("orden")
        ->select("menu_home.*")
        ->get();

        if(route('home') == "https://expertos.t3rsc.co"){
            $como = [
                ""          => "Seleccionar",
                "facebook"  => "Facebook",
                "instagram" => 'Instagram',
                "twitter"   => 'Twitter',
            ];
        }elseif(route("home")=="https://gpc.t3rsc.co"){
            $como = [
                ""              => "Seleccionar",
                //"trabaje_con_nosotros"=>"Trabaje con nosotros",
                "referidos"     => "Referidos",
                "facebook"      => "Facebook",
                "Linkedin"      => "Linkedin",
                "clasificados"  => "Clasificados",
                "Universidades" => "Universidad",
                "Multitrabajos" => "Multitrabajos",
                "ferias_empresariales" => "Ferias empresariales",
                "compu_trabajo" => "Computrabajo",
                "Otros"         => "Otros",
                "Invitación"    => "Invitación a un proceso"
            ];
        }else{
            $como = [
                ""                  => "Seleccionar",
                "trabaje_con_nosotros" => "Trabaje con nosotros",
                "referidos"         => "Referidos",
                "facebook"          => "Facebook",
                "clasificados"      => "Clasificados",
                "alcaldias"         => "Alcaldias",
                "emisoras"          => "Emisoras",
                "ferias_empresariales" => "Ferias empresariales",
                "agencias_empleo"   => "Agencias de empleo",
                "compu_trabajo"     => "Computrabajo"
            ];
        }
       
        $nivelEstudios = ["" => "Seleccionar"] + NivelEstudios::pluck("descripcion", "id")->toArray();
        return view('cv.registro', compact("nivelEstudios", "como", "menu"));
    }

    public function getRegister_poder()
    {
        return view('cv.registro_poder');
    }

    public function getLogin(Request $request)
    {
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }

        $menu = DB::table("menu_home")->where("estado", 1)->orderBy("orden")
        ->select("menu_home.*")
        ->get();

        if($request->has('email')){
            $flag = $request->email;
            return view('cv.login', compact("menu", "flag"));
        }

        if($request->has('brig')){
            $brig = $request->brig;
            return view('cv.login', compact("menu", "brig"));
        }

        if($request->has('excel_basico')){
            $excel_basico = $request->excel_basico;
            $req_id = $request->req_id;
            return view('cv.login', compact("menu", "excel_basico", "req_id"));
        }

        if($request->has('excel_intermedio')){
            $excel_intermedio = $request->excel_intermedio;
            $req_id = $request->req_id;
            return view('cv.login', compact("menu", "excel_intermedio", "req_id"));
        }

        if($request->has('prueba_ethical_values')){
            $prueba_ethical_values = $request->prueba_ethical_values;
            $req_id = $request->req_id;
            return view('cv.login', compact("menu", "prueba_ethical_values", "req_id"));
        }

        if($request->has('evaluacion_sst')){
            $evaluacion_sst = $request->evaluacion_sst;
            $req_id = $request->req_id;
            return view('cv.login', compact("menu", "evaluacion_sst", "req_id"));
        }

        if($request->has('visita_domiciliaria')){
            $visita_domiciliaria = $request->visita_domiciliaria;
            $visita_id = $request->visita_id;
            return view('cv.login', compact("menu", "visita_domiciliaria", "visita_id"));
        }

        if ($request->has('record')) {
            $record = $request->record;
            $sr = $request->sr;
            $ct = $request->ct;

            return view('cv.login', compact("menu", "record", "sr", "ct"));
        }

        if($request->has('scheduling')){
            $scheduling = $request->scheduling;
            return view('cv.login', compact("menu", "scheduling"));
        }

        if($request->has('digitacion')){
            $digitacion = $request->digitacion;
            return view('cv.login', compact("menu", "digitacion"));
        }

        if($request->has('competencias')){
            $competencias = $request->competencias;
            return view('cv.login', compact("menu", "competencias"));
        }

        return view('cv.login', compact("menu"));
    }

    public function getLogin_poder()
    {
        if (view()->exists('auth.authenticate')) {
            return view('auth.authenticate');
        }

        return view('cv.login_poder');
    }

    public function postLogin(Request $request)
    {
        $validate = Validator::make($request->all(), ["email" => "required", "password" => "required"]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        try {
            $credenciales = ['password' => $request->get("password")];

            if (is_numeric($request->get("email"))) {
                $credenciales += ["numero_id" => $request->get("email")];
            } else {
                $valida = Validator::make($request->all(), ["email" => "email"]);

                if ($valida->fails()) {
                    $credenciales += ["username" => $request->get("email")];
                } else {
                    $credenciales += ["email" => $request->get("email")];
                }
            }

            if (!Sentinel::authenticate($credenciales)) {
                return redirect()->back()->withErrors(["email" => "Credenciales Incorrectas"]);
            }

            $datos_basicos = DatosBasicos::where('user_id', Sentinel::getUser()->id)->select('estado_reclutamiento')->first();
            if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_BAJA_VOLUNTARIA')) {
                Sentinel::logout();
                return redirect()->back()->withErrors(["email" => "Usuario no encontrado"]);
            }
            if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO') || $datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD')) {
                Sentinel::logout();
                return redirect()->back()->withErrors(["email" => "Usuario con estado actual inactivo"]);
            }

            if ($request->has('flag')) {
                return redirect()->route("admin.carga_archivos_contratacion");
            }

            if ($request->has('brig')) {
                return redirect()->route("cv.prueba_inicio");
            }

            if ($request->has('record')) {
                return redirect()->route("home.confirmar-contratacion-video", [$request->sr, $request->ct]);
            }

            //Redireccionar al agendamiento
            if ($request->has('scheduling')) {
                return redirect()->route("mis_ofertas");
            
            }

            if ($request->has('excel_basico')) {
                return redirect()->route("cv.prueba_excel_basico", [$request->req_id]);
            }

            if ($request->has('excel_intermedio')) {
                return redirect()->route("cv.prueba_excel_intermedio", [$request->req_id]);
            }

            if ($request->has('prueba_ethical_values')) {
                return redirect()->route("cv.prueba_valores_1", [$request->req_id]);
            }

            if ($request->has('evaluacion_sst')) {
                return redirect()->route("realizar_evaluacion_induccion_sst", [$request->req_id]);
            }

            //Redireccionar a prueba digitación
            if ($request->has('digitacion')) {
                return redirect()->route("cv.digitacion_inicio");
            }

            //Redireccionar a prueba digitación
            if ($request->has('competencias')) {
                return redirect()->route("cv.competencias_inicio");
            }

            if ($request->has('visita_domiciliaria')) {
                return redirect()->route("realizar_form_visita_domiciliaria",["visita_id"=>$request->visita_id]);
            }

            if (session('url_deseada_redireccion_candidato') != null) {
                //Si se guardo una URL a donde queria ir el usuario, se va a redirigir a esta.
                $ruta = session('url_deseada_redireccion_candidato');
                session(["url_deseada_redireccion_candidato" => null]);
                
                return redirect($ruta);
            }
            
            return redirect()->route("datos_basicos");
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $exc) {
            return redirect()->back()->withErrors(["email" => "Cuenta inactiva, por favor solicite la activación a su gestor de proceso"]);
        } catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $exc) {
            return redirect()->back()->withErrors(["email" => "Actividad sospechosa se ha producido en su dirección IP y se le ha negado el acceso por 15 minutos "]);
        }

        return redirect()->route("login");
    }


    public function postLogin_respu(Request $request)
    {
        $validate = Validator::make($request->all(), ["email" => "required", "password" => "required"]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        try {
            $credenciales = ['password' => $request->get("password")];

            if (is_numeric($request->get("email"))) {
                $credenciales += ["numero_id" => $request->get("email")];
            } else {
                $valida = Validator::make($request->all(), ["email" => "email"]);

                if ($valida->fails()) {
                    $credenciales += ["username" => $request->get("email")];
                } else {
                    $credenciales += ["email" => $request->get("email")];
                }
            }

            if (!Sentinel::authenticate($credenciales)) {
                return redirect()->back()->withErrors(["email" => "Credenciales Incorrectas"]);
            }

            $datos_basicos = DatosBasicos::where('user_id', Sentinel::getUser()->id)->select('estado_reclutamiento')->first();
            if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_BAJA_VOLUNTARIA')) {
                Sentinel::logout();
                return redirect()->back()->withErrors(["email" => "Usuario no encontrado"]);
            }
            if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO') || $datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD')) {
                Sentinel::logout();
                return redirect()->back()->withErrors(["email" => "Usuario con estado actual inactivo"]);
            }

            return redirect()->route("datos_basicos");
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $exc) {
            return redirect()->back()->withErrors(["email" => "Cuenta inactiva, por favor solicite la activación a su gestor de proceso"]);
        } catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $exc) {
            return redirect()->back()->withErrors(["email" => "Actividad sospechosa se ha producido en su dirección IP y se le ha negado el acceso por unos minuto "]);
        }

        return redirect()->route("login");
    }

    public function getEmail(Request $data)
    {
        return view("cv.resetemail");
    }

    public function getEmail_poder(Request $data)
    {
        return view("cv.resetemail_poder");
    }

    public function postEmail(Request $data)
    {
       $messages = [
         'email.required' => 'El Email es requerido',
         'email.exists'   => 'El Email no esta registrado',
         //'password.required' => 'La COntraseña es requerida'
        ];

        $validate = Validator::make($data->all(), ["email" => "required|exists:users,email"],$messages);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $user = UsersSentile::where("email", $data->get("email"))->first();

        $datos_basicos = $user->getDatosBasicos();

        $has = Reminder::create($user);

        $user->hash_verificacion=$has->code;
        $user->save();
        
        $funcionesGlobales = new FuncionesGlobales();
        if (isset($funcionesGlobales->sitio()->nombre)) {
            if ($funcionesGlobales->sitio()->nombre != "") {
                $nombre = $funcionesGlobales->sitio()->nombre;
            } else {
                $nombre = "Desarrollo";
            }
        }

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Recuperación de Contraseña"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "Da clic en el siguiente botón para iniciar la recuperación de tu contraseña";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'NUEVA CONTRASEÑA', 'buttonRoute' => route('recuperar_contrasena_cv',['hash'=>$has->code])];

        $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($data, $nombre) {

                $message->to($data->get("email"), $nombre.' - T3RS')
                ->subject('Recuperar Contraseña')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

        

        return redirect()->route("recordar_email")->with("status", "Se ha enviado los pasos para recuperar tu contraseña a tu correo.");
    }

    public function postEmail_poder(Request $data)
    {
        $validate = Validator::make($data->all(), ["email" => "required|exists:users,email"]);
        //mensajes de validacion
        
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        $user = UsersSentile::where("email", $data->get("email"))->first();

        $datos_basicos = $user->getDatosBasicos();
        $has           = Reminder::create($user);

        Mail::send('cv.email_pasos_recuperacion_poder', ["hash" => $has->code, "user" => $user, 'datos_basicos' => $datos_basicos], function ($message) use ($data) {
            $message->to($data->get("email"), 'Poder Humano')->subject('Recuperar Contraseña')
            ->getHeaders()
            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        return redirect()->route("recordar_email_poder")->with("status", "Se ha enviado los pasos para recuperar tu contraseña a tu correo.");
    }

    public function getReset($token, Request $data)
    {
        $token = $token;
        return view("cv.formresetpassword", compact("token"));
    }

    public function getReset_poder($token, Request $data)
    {
        $token = $token;
        return view("cv.formresetpassword_poder", compact("token"));
    }

    public function postReset(Request $data)
    {
        
        $messages = [
         'email.required' => 'El Email es requerido',
         'email.exists'   => 'El Email no esta registrado',
         'password.required' => 'La COntraseña es requerida'
        ];

        $validar = Validator::make($data->all(), [
            'token'    => 'required',
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
        ],$messages);

        if ($validar->fails()) {
            return redirect()->back()->withErrors($validar);
        }

        $user = UsersSentile::where("email", $data->get("email"))->first();

        if(!Reminder::exists($user)) {

          return redirect()->back()->withErrors(["email" => "No se ha solicitado recuperación de contraseña."]);
        }

        if ($reminder = Reminder::complete($user, $data->get("token"), $data->get("password"))) {
            Sentinel::login($user);

            return redirect()->route("dashboard");
        } else {

            return redirect()->back()->withErrors(["email" => "No se puedo terminar la actualización de la contraseña, Vuelva a intentarlo."]);
        }
    }

    public function login_admin(Request $data)
    {
        if (Sentinel::check()) {
            return redirect()->route("admin.index");
        } else {
            $menu = DB::table("menu_home")->where("estado",1)->orderBy("orden")
            ->select("menu_home.*")
            ->get();

            return view("admin.login",compact("menu"));
        }
    }

    public function login_admin_post(Request $data)
    {

        $validate = Validator::make($data->all(), ["email" => "required", "password" => "required"]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }
        //BUSCAR USER
        $user = UsersSentile::where(function ($sql) use ($data) {
            $sql->where("email", $data->get("email"));
                //->orWhere("username", $data->get("email"));
                if ($data->get("email")) {
                    if (is_numeric($data->get("email"))) {
                        $sql->orWhere("numero_id", $data->get("email"));
                    }
                }
        })->first();
        
        //CONSULTAR CLIENTES
        if ($user == null) {
            
            /*$menu=DB::table("menu_home")->where("estado",1)->orderBy("orden")
            ->select("menu_home.*")
            ->get();*/
            
            return redirect()->route("admin.login")->with("mensaje_error", "Usuario no encontrado.");
        }

        if (!$user->inRole("admin")) {
            return redirect()->route("admin.login")->with("mensaje_error", "No tiene permisos para ingresar a este módulo.");
        }

        try {
            $credenciales = ['password' => $data->get("password")];

            if (is_numeric($data->get("email"))) {
                $credenciales += ["numero_id" => $data->get("email")];
            }else{
                $valida = Validator::make($data->all(), ["email" => "email"]);

                if ($valida->fails()) {
                    $credenciales += ["username" => $data->get("email")];
                } else {
                    $credenciales += ["email" => $data->get("email")];
                }
            }

            if(Sentinel::authenticate($credenciales)) {
                $datos_basicos = DatosBasicos::where('user_id', Sentinel::getUser()->id)->select('estado_reclutamiento')->first();
                if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO') || $datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD')) {
                    Sentinel::logout();
                    return redirect()->back()->withErrors(["email" => "Usuario con estado actual inactivo"]);
                }
                $ruta ='admin.index';

                if (session('url_deseada_redireccion') != null) {
                    //Si se guardo una URL a donde queria ir el usuario, se va a redirigir a esta.
                    $ruta = session('url_deseada_redireccion');
                    session(["url_deseada_redireccion" => null]);
                    return redirect($ruta);
                }

                //komatsu redirigir usuarios a lista de solicitud no index
                if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
                    if($user->pagina_inicio != 1){
                        $ruta = 'admin.solicitud';
                    }
                }

                $funcionesGlobales = new FuncionesGlobales();
                $menu=$funcionesGlobales->menu_admin();
                $session=session()->put('menu_admin', $menu);

                $tiempo_solicitud = 10;
                $encuesta = session()->put('fecha_timer_encuesta',Carbon::now()->addMinutes($tiempo_solicitud));
                $encuesta_realizada = session()->put('encuesta_realizada','sigan');
                // dd(session('fecha_timer_encuesta'));
                return redirect()->route($ruta);
            }

            return redirect()->back()->with("mensaje_error", "Credenciales incorrectas.");
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $exc) {
            return redirect()->route("admin.login")->with("mensaje_error", "Cuenta inactiva, por favor solicite la activación a su gestor de proceso.");
        }
        catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $exc) {
            return redirect()->back()->withErrors(["email" => "Actividad sospechosa se ha producido en su dirección IP y se le ha negado el acceso por 15 minutos "]);
        }

        return redirect()->route("admin.login")->with("mensaje_error", "Credenciales incorrectas.");
    }

    public function validar_sesion(Request $request){
        return response()->json(["session"=>true]);
    }

    public function loginReclutamientoExterno(Request $data)
    {
        if (Sentinel::check()) {
            return redirect()->route("reclutamiento_externo.index");
        } else {
            $menu = DB::table("menu_home")->where("estado",1)->orderBy("orden")
            ->select("menu_home.*")
            ->get();

            return view("reclutamiento_externo.login.login",compact("menu"));
        }
    }

    public function loginReclutamientoExternoPost(Request $data)
    {
        //BUSCAR USER
        $user = UsersSentile::where(function ($sql) use ($data) {
            $sql->where("email", $data->get("email"))
                ->orWhere("username", $data->get("email"));
                if ($data->get("email")) {
                    if (is_numeric($data->get("email"))) {
                        $sql->orWhere("numero_id", $data->get("email"));
                    }
                }
        })->first();
        
        //CONSULTAR CLIENTES
        if ($user == null) {
            $menu=DB::table("menu_home")->where("estado",1)->orderBy("orden")
            ->select("menu_home.*")
            ->get();
            
            return redirect()->route("reclutamiento_externo.login",compact("menu"))->with("mensaje_error", "Usuario no encontrado.");
        }

        if (!$user->inRole("reclutamiento_externo")) {
            return redirect()->route("reclutamiento_externo.login")->with("mensaje_error", "No tiene permisos para ingresar a este módulo.");
        }

        try {
            $credenciales = ['password' => $data->get("password")];

            if (is_numeric($data->get("email"))) {
                $credenciales += ["numero_id" => $data->get("email")];
            }else{
                $valida = Validator::make($data->all(), ["email" => "email"]);

                if ($valida->fails()) {
                    $credenciales += ["username" => $data->get("email")];
                } else {
                    $credenciales += ["email" => $data->get("email")];
                }
            }

            if(Sentinel::authenticate($credenciales)) {
                $datos_basicos = DatosBasicos::where('user_id', Sentinel::getUser()->id)->select('estado_reclutamiento')->first();
                if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO') || $datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD')) {
                    Sentinel::logout();
                    return redirect()->back()->withErrors(["email" => "Usuario con estado actual inactivo"]);
                }
                $ruta ='reclutamiento_externo.index';
                //komatsu redirigir usuarios a lista de solicitud no index
                if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
                    if($user->pagina_inicio != 1){
                        $ruta = 'admin.solicitud';
                    }
                }
                
                return redirect()->route($ruta);
            }

            return redirect()->back()->with("mensaje_error", "Credenciales incorrectas.");
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $exc) {
            return redirect()->route("reclutamiento_externo.login")->with("mensaje_error", "Cuenta inactiva, por favor solicite la activación a su gestor de proceso.");
        }
        catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $exc) {
            return redirect()->back()->withErrors(["email" => "Actividad sospechosa se ha producido en su dirección IP y se le ha negado el acceso por 15 minutos "]);
        }

        return redirect()->route("reclutamiento_externo.login")->with("mensaje_error", "Credenciales incorrectas.");
    }
}
