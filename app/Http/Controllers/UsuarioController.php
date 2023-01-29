<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\User as EloquentUser;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Menu;
use App\Models\DatosBasicos;
use App\Models\Agencia;
use App\Models\AgenciaUsuario;
use App\Models\UserClientes;
use App\Models\Clientes;
use App\Models\ListaNegra;
use App\Models\Auditoria;
use App\Models\Sitio;
use Illuminate\Support\Facades\Event;
use App\Events\PorcentajeHvEvent;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

use Bican\Roles\Models\Role;
use App\Http\Requests\NuevoUserEmpresaRequest;

class UsuarioController extends Controller
{
    public function lista_usuario(Request $data)
    {
        $in    = [];
        $notIn = [];
        $na    = [];

        /*foreach($data->all() as $key => $value) {
            if (in_array($key, ["mod_admin", "mod_req", "mod_hv"])) {
                if ($value == 1) {
                    switch ($key) {
                        case "mod_admin":
                            array_push($in, "admin");
                            break;
                        case "mod_hv":
                            array_push($in, "hv");
                            break;
                        case "mod_req":
                            array_push($in, "req");
                            break;
                    }
                }

                if ($value == 2) {
                    switch ($key) {
                        case "mod_admin":
                            array_push($na, "admin");
                            break;
                        case "mod_hv":
                            array_push($na, "hv");
                            break;
                        case "mod_req":
                            array_push($na, "req");
                            break;
                    }
                }

                if ($value == 3) {
                    switch ($key) {
                        case "mod_admin":
                            array_push($notIn, "admin");
                            break;
                        case "mod_hv":
                            array_push($notIn, "hv");
                            break;
                        case "mod_req":
                            array_push($notIn, "req");
                            break;
                    }
                }
            }
        }*/

        $roles_filter = ["req", "admin"];

        if ($data->has('admin') || $data->has('req') || $data->has('hv')) {
            $roles_filter = [];

            array_push($roles_filter, $data->get('admin'));
            array_push($roles_filter, $data->get('req'));
            array_push($roles_filter, $data->get('hv'));
        }

        // EloquenUser es User (por alguna razón)
        $usuarios = EloquentUser::leftJoin("role_users", "role_users.user_id", "=", "users.id")
        ->leftJoin('datos_basicos', 'datos_basicos.user_id', '=', 'users.id')
        ->leftJoin('estados', 'estados.id', '=', 'datos_basicos.estado_reclutamiento')
        ->leftJoin("roles", "roles.id", "=", "role_users.role_id")
        ->join('activations', 'activations.user_id', '=', 'users.id')
        ->where(function ($sql) use ($data, $notIn, $in, $roles_filter) {
            /*if ($data->get("todos") == 1) {
            } else {
                if (count($in) != 0 && count($notIn) == 0) {
                    //$sql->whereIn("roles.slug", $in);
                } else {
                    $sql->whereIn("roles.slug", ["hv", "req", "admin"]);
                }
            }*/

            if ($data->get("email") != "") {
                $sql->where(DB::raw(" lower(users.email) "), "like", "%" . strtolower($data->get("email")) . "%");
                $sql->orWhere("users.name", "like", "%" . strtolower($data->get("email")) . "%");
                
                if (is_numeric($data->get("email"))) {
                    $sql->orWhere("users.numero_id", "=", $data->get("email"));
                }

                array_push($roles_filter, 'hv');
            }

            if ($data->get('estado') != "") {
                $sql->where('activations.completed', $data->get('estado'));
            }

            $sql->whereIn("roles.slug", $roles_filter);
        });

        /*if (count($in) != 0 && count($notIn) == 0 && count($na) == 0) {
            $usuarios = $usuarios->havingRaw(DB::raw("GROUP_CONCAT(roles.slug , ',' ORDER BY roles.id) like '%hv%' and LISTAGG(roles.slug , ',') WITHIN GROUP (ORDER BY roles.id) like '%req%' and LISTAGG(roles.slug , ',') WITHIN GROUP (ORDER BY roles.id) like '%admin%'"));
        }

        if (count($in) != 0 && count($notIn) != 0 && count($na) == 0) {
            $usuarios = $usuarios->havingRaw(DB::raw("GROUP_CONCAT(roles.slug , ',' ORDER BY users.id) = '" . implode(",", $in) . "'"));
        }

        if (count($in) != 0 && count($notIn) != 0 && count($na) != 0) {
            $usuarios = $usuarios->havingRaw(DB::raw("GROUP_CONCAT(roles.slug  , ',') NOT  like '%" . implode(",", $notIn) . "%' and GROUP_CONCAT(roles.slug  ORDER BY roles.slug DESC SEPARATOR ',') = '%" . implode(",", $in) . "%'"));
        }*/

        $usuarios = $usuarios->select(
            "users.id",
            "users.name",
            "users.email",
            DB::raw("GROUP_CONCAT(role_users.role_id  , ',' ORDER BY role_users.user_id) as roles_text"),
            "activations.completed as activo",
            "estados.descripcion as estado"
        )
        ->groupBy("users.id", "users.name", "users.email")
        ->paginate(20);

        return view("admin.usuarios_sistema.lista-usuarios-new")->with("usuarios", $usuarios);
    }

    public function nuevo_usuario_sistema(Request $data)
    {
        $agencias = [];

        $permisos = Menu::where("modulo", "req")->where("padre_id", 0)->select("menu.*")->get();

        $roles = Role::whereNotIn("slug", ["hv", "admin", "req","God"])->get();

        if(route("home") == "http://vym.t3rsc.co" || route("home") == "https://vym.t3rsc.co" ||
           route("home") == "http://listos.t3rsc.co" || route("home") == "https://listos.t3rsc.co" ||
           route("home") == "http://soluciones.t3rsc.co" || route("home") == "https://soluciones.t3rsc.co" ||
           route("home") == "http://localhost:8000"){
            $agencias = Agencia::all();
        }

        return view("admin.usuarios_sistema.nuevo_user_sistema", compact("permisos", "roles","agencias"));
    }

    public function editar_user_sistema($user_id, Request $data)
    {
        $agencias = [];

        $usuario = EloquentUser::with("agencias2")->findOrFail($user_id);

        $ubicacion = EloquentUser::join("paises", "paises.cod_pais", "=", "users.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "users.pais_id")->on("departamentos.cod_departamento", "=", "users.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "users.pais_id")
            ->on("ciudad.cod_departamento", "=", "users.departamento_id")
            ->on("ciudad.cod_ciudad", "=", "users.ciudad_id");
        })
        ->where("ciudad.cod_pais", $usuario->pais_id)
        ->where("ciudad.cod_departamento", $usuario->departamento_id)
        ->where("ciudad.cod_ciudad", $usuario->ciudad_id)
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad"))
        ->first();

        $activado = "";

        if (Activation::completed($usuario)) {
            $activado = 1;
        } else {
            $activado = 0;
        }

        $permisos = Menu::where("modulo", "req")->where("padre_id", 0)->select("menu.*")->get();

        $roles = Role::whereNotIn("slug", ["hv", "admin", "req","God"])->get();

        $agencias = Agencia::all();

        $sitio = Sitio::first();

        return view("admin.usuarios_sistema.editar-user-sistema-new", compact(
            "ubicacion",
            "usuario",
            "activado",
            "permisos",
            "roles",
            "agencias",
            "sitio"
        ));
    }

    public function actualizar_usuario_sistema(Request $data)
    {
       
        $validator = Validator::make(
            $data->all(),
            [
                "primer_nombre" => "required",
                "primer_apellido" => "required",
                "username"=> "required_without_all:numero_id,email",
                "numero_id"=> "required_without_all:username,email|unique:users,numero_id,".$data->get("id"),
                'email' => "email|max:255|required_without_all:username,numero_id|unique:users,email,".$data->get("id"),
                'pais_id' => "required",
                'ciudad_autocomplete' => "required"
            ],
            [
                "primer_nombre.required" => "Campo obligatorio",
                "primer_apellido.required" => "Campo obligatorio",
                "pais_id.required" => "Debe digitar una ciudad de trabajo.",
                "email.unique" => "Este email ya se encuentra registrado.",
                "numero_id.unique" => "Este numero ya se encuentra registrado.",
                "ciudad_autocomplete"=> "Campo obligatorio"
            ]
        )->validate();

        $obs = null;
        $usuario = EloquentUser::where("id", $data->get("id"))->first();

        $usuario_old = json_encode($usuario);

        $campos_usuario = $data->all();
        unset($campos_usuario["pass"]);

        $campos_usuario["name"] = $data->get('primer_nombre')." ".$data->get('segundo_nombre')." ".$data->get('primer_apellido')." ".$data->get('segundo_apellido');

        if ($data->get('pass') != "") {
            $campos_usuario["password"] = bcrypt($data->get('pass'));
        }

        if ($data->get('email') != "") {
            $campos_usuario["email"] = $data->get('email');
        }

        if ($data->get('numero_id') != "") {
            $campos_usuario["numero_id"] = $data->get('numero_id');
        }

        if (!$data->has("notificacion_requisicion")) {
            $campos_usuario["notificacion_requisicion"] = 0;
        }

        $usuario->fill($campos_usuario);
        $usuario->save();

        $datos_basicos  = DatosBasicos::where("user_id", $usuario->id)->first();

        if(!is_null($datos_basicos)) {
            unset($campos_usuario["estado"], $campos_usuario["pass"], $campos_usuario["id"]);
            $datos_basicos->fill($campos_usuario);
            $datos_basicos->nombres = $data->get('primer_nombre')." ".$data->get('segundo_nombre');
            $datos_basicos->save();
        }

        //INACTIVAR USER
        if ($data->get("estado") == 0) {
            Activation::remove($usuario);
        }

        if ($data->get("estado") == 1 && !Activation::completed($usuario)) {
            $activation = Activation::create($usuario);
            Activation::complete($usuario, $activation->code);
        }

        //VALIDADON ROLES PARA INGRESAR A LOS MODULOS DE ADMINISTRACION,REQUISICION ,HOJA DE VIDA
        $roleHv    = Sentinel::findRoleBySlug('hv');
        $roleReq   = Sentinel::findRoleBySlug('req');
        $roleAdmin = Sentinel::findRoleBySlug('admin');

        if ($data->has("habilitar_hv")) {
            if (!$usuario->inRole("hv")) {
                $roleHv->users()->attach($usuario);
            }
        } else {
            $roleHv->users()->detach($usuario);
        }

        if ($data->has("habilitar_req")) {
            if (!$usuario->inRole("req")) {
                $roleReq->users()->attach($usuario);
            }
        } else {
            $roleReq->users()->detach($usuario);
        }

        if ($data->has("habilitar_admin")) {
            if (!$usuario->inRole("admin")) {
                $roleAdmin->users()->attach($usuario);
            }
        } else {
            $roleAdmin->users()->detach($usuario);
        }

        //AGREGANDO PERMISOS PARA REQUISICION
        $menuArray = [];

        if ($data->has("permiso") && is_array($data->get("permiso"))) {
            $permisoSeleccionados = $data->get("permiso");

            $menu = Menu::where("modulo", "req")->where("padre_id", 0)->select("menu.*")->get();

            foreach ($menu as $key => $value) {
                if (in_array($value->slug, $permisoSeleccionados)) {
                    $menuArray[$value->slug] = true;
                } else {
                    $menuArray[$value->slug] = false;
                }

                foreach ($value->menu_hijo1() as $key2 => $value2) {
                    if (in_array($value2->slug, $permisoSeleccionados)) {
                        $menuArray[$value2->slug] = true;
                    } else {
                        $menuArray[$value2->slug] = false;
                    }
                }
            }
        }

        //AGREGANDO PERMISOS PARA ADMINISTRADORES
        if ($data->has("permiso_admin") && is_array($data->get("permiso_admin"))) {
            foreach ($data->get("permiso_admin") as $key => $value) {
                //if ($value != "no") {
                $menuArray[$key] = (($value == "on") ? true : false);
                //}
            }
        }

        $usuario->permissions = $menuArray;
        $usuario->save();

        $usuario_new = json_encode($usuario);

        if($usuario_old != $usuario_new) {
            $obs = "Editar datos usuario";
        }

        //AGREGANDO ROLES
        $roles               = Role::whereNotIn("slug", ["hv", "admin", "req"])->get();
        $roles_seleccionados = $data->get("roles", []);

        foreach ($roles as $key => $value) {
            $rol = Sentinel::findRoleById($value->id);
            if (in_array($value->id, $roles_seleccionados)) {
                if (!$usuario->inRole($rol->slug)) {
                    $rol->users()->attach($usuario);
                }
            } else {
                $rol->users()->detach($usuario);
            }
        }

        if($data->has("agencia") && is_array($data->get("agencia"))) {
            $usuario->agencias2()->sync($data->get("agencia")); //actualizar agencias
        }

        if($usuario_old != $usuario_new) {
            $auditoria= new Auditoria();
            $auditoria->observaciones = "Editar datos usuario";
            $auditoria->valor_antes   = $usuario_old;
            $auditoria->valor_despues = $usuario_new;
            $auditoria->user_id       = $this->user->id;
            $auditoria->tabla         = "users";
            $auditoria->tabla_id      = $usuario->id;
            $auditoria->tipo          = "ACTUALIZAR";
            event(new \App\Events\AuditoriaEvent($auditoria));
        }

        return redirect()->route("admin.editar_user_sistema", [$usuario->id])->with("mensaje_success", "Usuario actualizado");
    }

    public function guardar_usuario_sistema(NuevoUserEmpresaRequest $data)
    {
        $campos_usuario = $data->all();

        $campos_usuario["password"] = $data->get('password');
        $campos_usuario["name"] = $data->get('primer_nombre')." ".$data->get('segundo_nombre')." ".$data->get('primer_apellido')." ".$data->get('segundo_apellido');
        $usuario = Sentinel::registerAndActivate($campos_usuario);

        //CREAR ACTIVACION
        $activation = Activation::create($usuario);

        //CREA HV
        $datos_basicos = new DatosBasicos();
        $datos_basicos->fill($campos_usuario + [
            "numero_id" => $data->get("identificacion"),
            "user_id" => $usuario->id,
            "nombres" => $data->get('primer_nombre')." ".$data->get('segundo_nombre'),
            "datos_basicos_count" => "20",
            "estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')
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
            $auditoria->observaciones = 'Se registro en la creación de nuevo usuario del sistema y se encuentra en listado especial con la restricción ' . $restriccion->descripcion;
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
        
        //AGREGAR ROL USUARIO
        $role = Sentinel::findRoleBySlug('hv');

        $role->users()->attach($usuario);

        //VALIDADON ROLES PARA INGRESAR A LOS MODULOS DE ADMINISTRACION,REQUISICION ,HOJA DE VIDA
        $roleHv    = Sentinel::findRoleBySlug('hv');
        $roleReq   = Sentinel::findRoleBySlug('req');
        $roleAdmin = Sentinel::findRoleBySlug('admin');

        if ($data->has("habilitar_hv")) {
            if (!$usuario->inRole("hv")) {
                $roleHv->users()->attach($usuario);
            }
        } else {
            $roleHv->users()->detach($usuario);
        }

        if ($data->has("habilitar_req")) {
            if (!$usuario->inRole("req")) {
                $roleReq->users()->attach($usuario);
            }
        } else {
            $roleReq->users()->detach($usuario);
        }

        if ($data->has("habilitar_admin")) {
            if (!$usuario->inRole("admin")) {
                $roleAdmin->users()->attach($usuario);
            }
        } else {
            $roleAdmin->users()->detach($usuario);
        }

        //AGREGANDO PERMISOS PARA REQUISICION
        $menuArray = [];

        if ($data->has("permiso") && is_array($data->get("permiso"))) {
            $permisoSeleccionados = $data->get("permiso");

            $menu = Menu::where("modulo", "req")->where("padre_id", 0)->select("menu.*")->get();
            
            foreach ($menu as $key => $value) {
                if (in_array($value->slug, $permisoSeleccionados)) {
                    $menuArray[$value->slug] = true;
                } else {
                    $menuArray[$value->slug] = false;
                }

                foreach ($value->menu_hijo1() as $key2 => $value2) {
                    if (in_array($value2->slug, $permisoSeleccionados)) {
                        $menuArray[$value2->slug] = true;
                    } else {
                        $menuArray[$value2->slug] = false;
                    }
                }
            }
        }

        //AGREGANDO PERMISOS PARA ADMINISTRADORS
        if ($data->has("permiso_admin") && is_array($data->get("permiso_admin"))) {
            foreach ($data->get("permiso_admin") as $key => $value) {
                if ($value != "no") {
                    $menuArray[$key] = $value;
                }
            }
        }
         
        $usuario->permissions = $menuArray;
        $usuario->save();

        //AGREGANDO ROLES
        $roles = Role::whereNotIn("slug", ["hv", "admin", "req"])->get();
        $roles_seleccionados = $data->get("roles", []);
        
        foreach ($roles as $key => $value) {
            $rol = Sentinel::findRoleById($value->id);

            if (in_array($value->id, $roles_seleccionados)) {
                if (!$usuario->inRole($rol->slug)) {
                    $rol->users()->attach($usuario);
                }
            } else {
                $rol->users()->detach($usuario);
            }
        }

        if ($data->has("agencia") && is_array($data->get("agencia"))) {
            foreach ($data->get("agencia") as $agencia_id) {
                $usuario_agencia=new AgenciaUsuario();
                $usuario_agencia->id_agencia=$agencia_id;
                $usuario_agencia->id_usuario=$usuario->id;
                $usuario_agencia->save();
            }
        }

        //Asignar todos los clientes si es Consultor GPC
        if (route('home') == "https://gpc.t3rsc.co") {
            if ($data->has('roles')) {
                if (in_array(5, $data->get('roles')) || in_array(11, $data->get('roles'))) {
                    $clientesGPC = Clientes::all();                    

                    foreach ($clientesGPC as $clienteGPC) {
                        $usuario_clientes = new UserClientes();
                        $usuario_clientes->user_id = $usuario->id;
                        $usuario_clientes->cliente_id = $clienteGPC->id;
                        $usuario_clientes->save();
                    }
                }
            }
        }

        return redirect()->route("admin.usuarios_sistema")->with("mensaje_success", "EL usuario se ha creado con exito.");
    }

    public function cambiar_contrasena()
    {
        return view("admin.cambiar_contrasena");
    }

    public function actualizar_contrasena_admin(Request $data)
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
            return redirect()->back()->withErrors(["contrasena_ant" => "La contraseña invalida"]);
        }

        $user           = EloquentUser::find($this->user->id);
        $user->password = Hash::make($data->get("contrasena"));
        $user->save();

        return redirect()->back()->with("mensaje", "Se ha actualizado la contraseña sin errores");
    }

    public function modificar_clave_candidato() {
        return view("admin.usuarios_sistema.modificar_clave_candidato");
    }

    public function buscar_datos_usuario(Request $request) {
        $usuario = $request->usuario;

        $no_candidato = EloquentUser::join('role_users', 'role_users.user_id', '=', 'users.id')
            ->where('role_users.role_id', '!=', 2)
            ->where(function ($sql) use ($usuario) {
                $sql->where(DB::raw("lower(users.email) "), "like", "%$usuario%");
                
                if (is_numeric($usuario)) {
                    $sql->orWhere("users.numero_id", "=", $usuario);
                }
            })
            ->select(
                'users.id'
            )
        ->first();
        if ($no_candidato != null) {
            return response()->json(['success' => false, 'mensaje' => 'No es posible realizar cambio de contraseña, este no es un usuario de candidato.']);
        }

        $candidato = EloquentUser::join('role_users', 'role_users.user_id', '=', 'users.id')
            ->join('datos_basicos', 'datos_basicos.user_id', '=', 'users.id')
            ->where('role_users.role_id', 2)
            ->where(function ($sql) use ($usuario) {
                $sql->where(DB::raw("lower(users.email) "), "like", "%$usuario%");
                
                if (is_numeric($usuario)) {
                    $sql->orWhere("users.numero_id", "=", $usuario);
                }
            })
            ->select(
                'datos_basicos.nombres',
                'datos_basicos.primer_apellido',
                'datos_basicos.segundo_apellido',
                'users.email',
                'users.numero_id',
                'users.id as user_id'
            )
        ->first();

        if ($candidato == null) {
            return response()->json(['success' => false, 'mensaje' => 'Usuario no encontrado.']);
        }

        return response()->json([
            'success' => true,
            'view' => view("admin.usuarios_sistema.modal.clave_candidato", ['candidato' => $candidato])
            ->render()
        ]);
    }

    public function guardar_nueva_clave_usuario(Request $request) {
        $usuario = EloquentUser::where("id", $request->user_id)->first();

        if ($usuario != null) {
            if ($request->clave != "") {
                $usuario->password = bcrypt($request->clave);
                $response = $usuario->save();

                $mensaje = '';
                if (!$response) {
                    $mensaje = 'Ocurrio un error al guardar la nueva contraseña.';
                }
                return response()->json(['success' => $response, 'mensaje' => $mensaje]);
            }
        }

        return response()->json(['success' => false, 'mensaje' => 'Ocurrio un error al guardar la nueva contraseña.']);
    }

    public function cargaMasivaUsuarios(Request $data){

        
       
       
        $data1=[];


        $rules = [
            'archivo' => 'required',
        ];

        $valida = Validator::make($data->all(), $rules);
                
        if($valida->fails()){
            return redirect()->back()->withErrors($valida)->withInput();
        }

        $errores_global      = [];
        $registrosInsertados = 0;
        $funcionesGlobales = "";

       
        $reader = Excel::selectSheetsByIndex(0)->filter('chunk')->load($data->file("archivo"))->chunk(250, function($results) use($data, &$registrosInsertados, &$errores_global,&$data1)
        {
            foreach($results as $key=>$value)
            {
                
                 
                $errores = [];
                $datos   = [
                    "identificacion"   => $value->identificacion,
                    "primer_nombre"    => $value->primer_nombre,
                    "segundo_nombre"   => $value->segundo_nombre,
                    "primer_apellido"  => $value->primer_apellido,
                    "segundo_apellido" => $value->segundo_apellido,
                    /* "telefono_fijo"    => $value->telefono_fijo,*/
                    "email"            => $value->email,
                    "agencias"         => $value->agencias,
                    "clientes"         => $value->clientes,
                    "roles"            => $value->roles
                     //"archivo_carga"    => $nombre_archivo_carga,
                ];

        
                $usuario_exi = EloquentUser::where("numero_id", $value->identificacion)->first();
                if($usuario_exi){
                     $validator= Validator::make($datos,[
                        "identificacion" => "required|min:1|numeric",
                        "email" => "required|email",
                        "primer_apellido" => "required",
                        "primer_nombre" => "required"
                    ]);

                }
                else{
                    $validator= Validator::make($datos,[
                        "identificacion" => "required|min:1|numeric|unique:users,numero_id",
                        "email" => "required|email|unique:datos_basicos,email",
                        "primer_apellido" => "required",
                        "primer_nombre" => "required"
                    ]);

                }

                

     
                if($validator->fails()){
                    $errores_global[$key] = ["errores"=>$validator->errors()->all(),"tipo"=>"error"];
                    
                    //dd($errores_global);
                    continue;
                    

                }
                else{
                    
                    //$usuario_exi = DatosBasicos::where("numero_id", $value->identificacion)->first();
                    if($usuario_exi== null){
                        
                            

                            

                            //Creamos el usuario
                            if ($value->segundo_apellido != null && $value->segundo_apellido != '') {
                                $name = $value->primer_nombre. " ".$value->segundo_nombre." ".$value->primer_apellido." ".$value->segundo_apellido;
                            } else {
                                $name = $value->primer_nombre. " ".$value->segundo_nombre. " ".$value->primer_apellido;
                            }

                            $campos_usuario = [
                                'name'          =>$name,
                                'email'         =>$value->email,
                                'password'      =>$value->identificacion,
                                'numero_id'     =>$value->identificacion,
                                'cedula'        =>$value->identificacion,
                            ];
                        
                            $user = Sentinel::registerAndActivate($campos_usuario);
                            
                            $usuario_id = $user->id;

                            //Creamos sus datos basicos
                            $datos_basicos = new DatosBasicos();

                            $datos_basicos->fill([
                                'numero_id'             => $value->identificacion,
                                'user_id'               => $usuario_id,
                                'nombres'               => $value->primer_nombre. " ".$value->segundo_nombre,
                                'primer_nombre'         => $value->primer_nombre,
                                'segundo_nombre'        => $value->segundo_nombre,
                                'primer_apellido'       => $value->primer_apellido,
                                'segundo_apellido'      => $value->segundo_apellido,
                                'estado_reclutamiento'  => config('conf_aplicacion.C_ACTIVO'),
                                'datos_basicos_count'   => "100",
                                'email'                 => $value->email
                            ]);

                            //Se verifica si a la persona que se registra esta en la lista negra, se coloca en estado_reclutamiento, que tiene problema de seguridad
                            

                            $datos_basicos->save();

                            Event::dispatch(new PorcentajeHvEvent($datos_basicos));

                            //Creamos el rol
                            $role = Sentinel::findRoleBySlug('admin');
                            $role->users()->attach($user);

                            //$job = (new SendEmailCargaMasiva($user));
                
                            //$this->dispatch($job);

                        $registrosInsertados++;

                        if($value->agencias!=null || $value->agencias!=''){//agregar agencias
                            $array_agencias=explode("-",$value->agencias);
                            $user->agencias2()->attach($array_agencias);
                        }

                        if($value->clientes!=null || $value->clientes!=''){//agregar agencias
                            $array_clientes=explode("-",$value->clientes);
                            $user->clientes()->attach($array_clientes);
                        }
                        if($value->roles!=null || $value->roles!=''){//agregar agencias
                            $array_roles=explode("-",$value->roles);
                            $user->roles2()->attach($array_roles);
                        }
                           

                        
                    }
                    else{
                        array_push($errores, "La cédula ".$usuario_exi->numero_id." ya existe en el sistema.");
                        $errores_global[$key] = ["errores"=>$errores,"tipo"=>"info"];
                    }

                }

          
            

                
            }//Foreach
        },false);//reader
    
    
        

        return redirect()->route("usuarios_masivos")->with("mensaje_success", "Se han cargado <b>$registrosInsertados</b> con éxito.")->with("errores_global", $errores_global);
    
    }

    public function cargaMasivausuariosView(Request $request){
        $user            = $this->user;

        return view("admin.usuarios_sistema.carga_masiva_usuarios", compact("user"));
    }

    public function enviarMensajeMasivoWhatsapp(Request $data) {
        $rules = [
            'archivo_msj' => 'required',
            'contenido_mensaje' => 'required',
        ];

        $valida = Validator::make($data->all(), $rules);

        if($valida->fails()){
            return redirect()->back()->withErrors($valida)->withInput();
        }

        $errores_global    = [];
        $mensajes_enviados = 0;

        $reader = Excel::selectSheetsByIndex(0)->filter('chunk')->load($data->file("archivo_msj"))->chunk(250, function($results) use($data, &$mensajes_enviados, &$errores_global)
        {
            foreach($results as $key=>$value)
            {
                $errores = [];
                $datos   = [
                    "nombres"   => $value->nombres,
                    "apellidos" => $value->apellidos,
                    "telefono"  => $value->telefono
                ];

                $validator= Validator::make($datos,[
                    "telefono"  => "required|min:1|numeric",
                    "nombres"   => "required",
                    "apellidos" => "required"
                ]);

                if($validator->fails()){
                    $errores_global[$key] = ["errores"=>$validator->errors()->all(),"tipo"=>"error"];
                    continue;
                } else {
                    $mensaje = str_replace("{nombres}", $value->nombres, $data->contenido_mensaje);
                    $mensaje = str_replace("{apellidos}", $value->apellidos, $mensaje);

                    try {
                         event(new \App\Events\NotificationWhatsappEvent("message",[
                            "phone"=>$value->telefono,
                            "body"=> $mensaje
                        ]));
                        logger("Mensaje para: $value->telefono, $mensaje");
                        $mensajes_enviados++;
                    } catch (\Exception $e) {
                        logger("Mensaje para: $value->telefono, no enviado.");
                    }
                }
            }//Foreach
        },false);//reader

        return redirect()->route("usuarios_masivos")->with("mensaje_success", "Se han enviado <b>$mensajes_enviados</b> con éxito.")->with("errores_global", $errores_global);
    }
}
