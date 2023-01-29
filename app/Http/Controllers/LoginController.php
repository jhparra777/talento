<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\FuncionesGlobales;
use App\Models\Clientes;
use App\Models\DatosBasicos;
use App\Models\User as UserSentinel;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
//Helper
use triPostmaster;

class LoginController extends Controller
{

    //
    public function showLogin()
    {

        return view('login', ['title' => 'Login']);
    }

    public function processLogin(Request $request)
    {
        //dd($request->input('email'));
        return redirect('/')->withInput($request->except('contrasena'));
    }

    public function showRegistro()
    {

    }

    public function redireccionaRedSocial($redsocial, $pagina)
    {
        $this->red = $redsocial;
        session(['redirectCallBacK' => $pagina]);
        return Socialite::driver($redsocial)->redirect();
    }

    public function cambiar_clave()
    {
        return view("cv.cambiar_contrasena");
    }

    public function actualizar_contrasena(Request $data)
    {
        $rules = [
            "contrasena_ant"          => "required",
            "contrasena"              => "required|confirmed|min:6",
            "contrasena_confirmation" => "required",
        ];
        $mensaje = ["contrasena.confirmed" => "Las contraseñas no coinciden"];

        $valida = Validator::make($data->all(), $rules, $mensaje);
        if ($valida->fails()) {
            return redirect()->back()->withErrors($valida);
        }
        if (!Hash::check($data->get("contrasena_ant"), $this->user->password)) {
            return redirect()->back()->withErrors(["contrasena_ant" => "La contraseña es inválida"]);
        }
        $user = UserSentinel::find($this->user->id);
        //dd($user);
        $user->password = Hash::make($data->get("contrasena"));
        $user->save();

        return redirect()->back()->with("mensaje", "Se ha actualizado la contraseña sin errores");
    }

    public function logout()
    {
        Sentinel::logout();
        return redirect()->route("home");
    }

    public function req_logout()
    {
        try {
            Sentinel::logout();
            session()->flush();
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $exc) {
            echo $exc->getTraceAsString();
        }

        return redirect()->route("login_req_view");
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver("facebook")->user();
            $this->loginPlataforma($user);
            if ($this->loginPlataforma($user)) {

                try {

                    $userLogin = UserSentinel::where("email", $user->getEmail())->first();
                    Sentinel::login($userLogin);

//             if (!$usuario->is("hv")) {
                    //            return redirect()->route("login")->with("mensaje_error", "No tiene permisos para ingresar a este módulo.");
                    //        }
                    return redirect()->route("dashboard");
                } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $exc) {
                    return redirect()->back()->withErrors(["email" => "Cuenta inactiva, por favor solicite la activación a su gestor de proceso."]);
                } catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $exc) {
                    return redirect()->back()->withErrors(["email" => "Actividad sospechosa se ha producido en su dirección IP y se le ha negado el acceso a un segundo "]);
                }
            } else {
                $campos = ["name" => $user->getName(), "facebook_key" => $user->getId(), "email" => $user->getEmail()];
                $page   = Session::get("redirectCallBacK");
                Session::forget("redirectCallBacK");
                return redirect()->route($page)->withInput($campos)->with("termina_registro", "true");
            }
        } catch (\GuzzleHttp\Exception\ClientException $exc) {
            $page = "login";

            if (Session::get("redirectCallBacK") == "registrarse_poder") {
                $page = "login";
            }
            Session::forget("redirectCallBacK");
            return redirect()->route($page, ["error_modal" => "No se pudo realizar la autenticacion"]);
        }
    }

    public function handleGoogleCallback()
    {

        try {
            $user = Socialite::driver("google")->user();

            if ($this->loginPlataforma($user)) {
                try {

                    $userLogin = UserSentinel::where("email", $user->getEmail())->first();
                    Sentinel::login($userLogin);
//             if (!$usuario->is("hv")) {
                    //            return redirect()->route("login")->with("mensaje_error", "No tiene permisos para ingresar a este módulo.");
                    //        }
                    return redirect()->route("dashboard");
                } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $exc) {
                    return redirect()->back()->withErrors(["email" => "Cuenta inactiva, por favor solicite la activación a su gestor de proceso."]);
                } catch (\Cartalyst\Sentinel\Checkpoints\ThrottlingException $exc) {
                    return redirect()->back()->withErrors(["email" => "Actividad sospechosa se ha producido en su dirección IP y se le ha negado el acceso a un segundo "]);
                }
            } else {

                $page = Session::get("redirectCallBacK");
                Session::forget("redirectCallBacK");

                $campos = ["name" => $user->getName(), "google_key" => $user->getId(), "email" => $user->getEmail()];
                return redirect()->route($page)->withInput($campos)->with("termina_registro", "true");
            }
        } catch (\GuzzleHttp\Exception\ClientException $exc) {

            $page = "login";

            if (Session::get("redirectCallBacK") == "registrarse_poder") {
                $page = "login";
            }
            Session::forget("redirectCallBacK");
            return redirect()->route($page, ["error_modal" => "No se pudo realizar la autenticacion"]);
        }
    }

    public function loginPlataforma($obj)
    {
        //BUSCAR USUARIO EN LA BASE DE DATOS
        $usuario = UserSentinel::where("email", $obj->getEmail())->first();
        if ($usuario) {
            //INICIA SESSION EN LA PLATAFORMA LISTAS LISTAS

            return true;
        }
        return false;
    }
//hereee
    public function verificar_cuenta(Request $data)
    {

        $user       = Sentinel::findById($data->get("id"));
        $activation = Activation::exists($user);
        if (!$activation) {
            return redirect()->route("login")->with("mensaje_error", "Este usuario ya se encuentra activado.");
        }
        //ACTIVAR USUARIO
        if (Activation::complete($user, $data->get("hash"))) {
            Sentinel::login($user);
            return redirect()->route("dashboard");
        } else {
            return redirect()->route("login")->with("mensaje_error", "El codigo de verificación es incorrecto.");
        }
    }

    public function view_login_req()
    {
        $menu=DB::table("menu_home")->where("estado",1)->orderBy("orden")
        ->select("menu_home.*")
        ->get();
        return view("req.login",compact("menu"));
    }

    public function login_req(Request $data)
    {
        //BUSCAR USER

        $user = UserSentinel::where("email", strtolower($data->get("email")))->first();
        //CONSULTAR CLIENTES
        $menu=DB::table("menu_home")->where("estado",1)->orderBy("orden")
        ->select("menu_home.*")
        ->get();
        if ($user == null) {
            return redirect()->route("login_req_view",compact("menu"))->with("mensaje_error", "Usuario no encontrado.");
        }

        if (!$user->inRole("req")) {
            return redirect()->route("login_req_view",compact("menu"))->with("mensaje_error", "No tiene permisos para ingresar a este módulo.");
        }

        try {
            if (Sentinel::authenticate(['email' => strtolower($data->get("email")), 'password' => $data->get("password")])) {
                $datos_basicos = DatosBasicos::where('user_id', Sentinel::getUser()->id)->select('estado_reclutamiento')->first();
                if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO') || $datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD')) {
                    Sentinel::logout();
                    return redirect()->back()->withErrors(["email" => "Usuario con estado actual inactivo"]);
                }

                $clientes = Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
                    ->where("users_x_clientes.user_id", $user->id)
                    ->get();
                if ($clientes->count() == 1) {
                    session(['cliente_id' => $clientes[0]->cliente_id]);
                }

                if (session('url_deseada_redireccion') != null) {
                    //Si se guardo una URL a donde queria ir el usuario, se va a redirigir a esta.
                    $ruta = session('url_deseada_redireccion');
                    session(["url_deseada_redireccion" => null]);
                    return redirect($ruta);
                }

                return redirect()->route("req_index");
            }
        } catch (\Cartalyst\Sentinel\Checkpoints\NotActivatedException $exc) {
            return redirect()->route("login_req_view",compact("menu"))->with("mensaje_error", "Cuenta inactiva, por favor solicite la activación a su gestor de proceso.");
        }

        return redirect()->route("login_req_view")->with("mensaje_error", "Credenciales incorrectas.");
    }

    public function req_cambiar_pass()
    {
        return view("req.cambiar_contrasena");
    }

    public function admin_cambiar_pass()
    {
        return view("admin.cambiar_contrasena");
    }

    public function olvido_contrasena_req()
    {

        return view("req.resetemail");
    }

    public function olvido_contrasena_admin()
    {

        return view("admin.resetemail");
    }

    public function enviar_email_admin_contrasena(Request $data)
    {

        $validate = Validator::make($data->all(), ["email" => "required|exists:users,email"]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }
        

        $user = UserSentinel::where("email", $data->get("email"))->first();

        $datos_basicos = $user->getDatosBasicos();
        $has           = Reminder::create($user);
        $user->hash_verificacion=$has->code;

        $funcionesGlobales = new FuncionesGlobales();
        if (isset($funcionesGlobales->sitio()->nombre)) {
            if ($funcionesGlobales->sitio()->nombre != "") {
                $nombre = $funcionesGlobales->sitio()->nombre;
            } else {
                $nombre = "Desarrollo";
            }
        }
        $modulo="admin";

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Recuperación de Contraseña"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "Da clic en el siguiente botón para iniciar la recuperación de tu contraseña";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'NUEVA CONTRASEÑA', 'buttonRoute' => route('admin.recuperar_contrasena',["hash"=>$user->hash_verificacion])];

        $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($data, $nombre) {

                $message->to($data->get("email"), $nombre.' - T3RS')
                ->subject('Notificación (Recuperar Contraseña)!')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

        return redirect()->route("admin.olvido_contrasena")->with("status", "Se ha enviado los pasos para recuperar tu contraseña a tu correo.");
    }

    public function enviar_email_req_contrasena(Request $request)
    {

        $rules = [
            "email" => "required|exists:users,email",
        ];
        $mensajes = [
            "email.required" => "Debe digitar un correo electronico.",
            "email.exists"   => "El correo no existe en la base de datos.",
        ];
        
        $validar = Validator::make($request->all(), $rules, $mensajes);
        if ($validar->fails()) {
            return redirect()->back()->withErrors($validar->errors());
        }

        $registro = DB::table('users')->where("email", $request->get("email"))->first();
        $token    = (Hash::make(date("YmdHis")));
        if ($registro == null) {
            //CREA NUEVO REGISTRO
            $user = DB::table('users')->insert(['email' => $request->get("email"), 'hash_verificacion' => $token, "created_at" => date("Y-m-d H:i:s")]);
        } else {
            $user = DB::table('users')->where("email", $request->get("email"))->update(["hash_verificacion" => $token]);
        }

        $user = DB::table('users')->where("email", $request->get("email"))->first();

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Recuperación de Contraseña"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "Da clic en el siguiente botón para iniciar la recuperación de tu contraseña";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'NUEVA CONTRASEÑA', 'buttonRoute' => route('req.recuperar_contrasena',["hash"=>$user->hash_verificacion])];

        $mailUser = $user->id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($user) {

                $message->to($user->email)
                ->subject('Recuperar Contraseña')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

        return redirect()->route("req.olvido_contrasena")->with("status", "Hemos enviado un email con las instrucciones para cambiar la contraseña.");
    }

    public function recuperar_contrasena(Request $data)
    {
        $datos = $data;
        return view("req.form_recuperar", compact("datos"));
    }

    public function recuperar_contrasena_admin(Request $data)
    {
        $datos = $data;
        return view("admin.form_recuperar", compact("datos"));
    }

    public function recuperar_contrasena_cv(Request $data)
    {
        $datos = $data;
        return view("cv.form_recuperar", compact("datos"));
    }

    public function recordar_contrasena2(Request $data)
    {
        //VALIDAR HASH
        $user = DB::table('users')->where("hash_verificacion", $data->get("token"))->first();
        if ($user == null) {
            return redirect()->back()->withErrors(["email" => "No se ha generado ninguna recuperación de contraseña para este correo. No existe!"]);
        }
        //VALIDAR SI ES EL CORREO CORRECTO
        if ($data->get("email") != $user->email) {
            return redirect()->back()->withErrors(["email" => "El email es inválido."]);
        }

        $validate = Validator::make($data->all(), [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate);
        }

        //MODIFICANDO CONTRASEÑA
        $userM           = UserSentinel::where("email", $data->get("email"))->first();
        $userM->password = Hash::make($data->get("password"));
        $userM->save();
        //ELMINIAR REGISTRO DE PASSWORD RESET
        DB::table('users')->where("hash_verificacion", $data->get("token"))->update(["hash_verificacion" => ""]);
        //LOGEO AUTOMATICO
        Sentinel::login($userM);

        return redirect()->route("req_index");
    }

    public function cambia_contrasena_recuperacion(Request $data)
    {
        $validar = Validator::make($data->all(), [
            'token'    => 'required',
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        if ($validar->fails()) {
            return redirect()->back()->withErrors($validar);
        }
        $user = UserSentinel::where("email", $data->get("email"))->first();
        if (!Reminder::exists($user)) {
            return redirect()->back()->withErrors(["email" => "No se ha solicitado recuperacion de contraseña."]);
        }
        if ($reminder = Reminder::complete($user, $data->get("token"), $data->get("password"))) {
            Sentinel::login($user);
            return redirect()->route("admin.index");
        } else {

            return redirect()->back()->withErrors(["email" => "No se puedo terminar la actualizacion de la contraseña, Vuelva a intentintentarlo."]);
        }
    }

}