<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Agencia;
use App\Models\AgenciaUsuario;
use App\Models\Auditoria;
use App\Models\CargoEspecifico;
use App\Models\Clientes;
use App\Models\DatosBasicos;
use App\Models\Menu;
use App\Models\Negocio;
use App\Models\Pais;
use App\Models\UnidadTrabajo;
use App\Models\User;
use App\Models\UserClientes;
use Bican\Roles\Models\Permission;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ClientesController extends Controller
{

    public function editar_cliente($cliente_id, Request $data)
    {
        $cliente = Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
        ->where("users_x_clientes.cliente_id", $cliente_id)
        ->select("clientes.*")->first();

        $txtUbicacion   = "";

        $lugarUbicacion = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $cliente->pais_id)
        ->where("ciudad.cod_departamento", $cliente->departamento_id)
        ->where("ciudad.cod_ciudad", $cliente->ciudad_id)->first();

        if ($lugarUbicacion != null) {
            $txtUbicacion = $lugarUbicacion->value;
        }

        return view("req.datos_empresa", compact("cliente", "txtUbicacion"));
    }

    public function actualizar_datos(Request $data)
    {
        $cliente = Clientes::find($data->get("id"));
        $cliente->fill($data->all());
        $cliente->save();

       return redirect()->route("req.mostrar_clientes")->with("mensaje_success", "Se han actualizado los datos.");
    }

    public function nuevo_user_cliente()
    {
        $permisos = Menu::where("modulo", "req")->where("padre_id", 0)->get();
        $usuario  = $this->user;
        $clientes = Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
        ->where("users_x_clientes.user_id", $this->user->id)
        ->select("clientes.*")
        ->get();

        return view("req.nuevo_usuario", compact("permisos", "usuario", "clientes"));
    }

    public function editar_user_cliente($id)
    {
        $permisos = Menu::where("modulo", "req")->where("padre_id", 0)
        ->select("menu.*")->get();

        $usuario  = Sentinel::getUser();

        $clientes = Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
        ->where("users_x_clientes.user_id", $id)
        ->select("clientes.*")
        ->get();

        return view("req.editar_usuario", compact("permisos", "usuario", "clientes"));
    }

    public function guardar_user_cliente(Request $data, Requests\NuevoUserEmpresaRequest $validate)
    {
        $usuario                    = new User();
        $campos_usuario             = $data->all();
        $campos_usuario["password"] = bcrypt($data->get('password'));
        $campos_usuario["name"] = $data->get('primer_nombre')." ".$data->get('segundo_nombre')." ".$data->get('primer_apellido')." ".$data->get('segundo_apellido');
        $campos_usuario["estado"]   = 1;
        $campos_usuario["padre_id"] = $this->user->id;
        $usuario->fill($campos_usuario);
        $usuario->save();

        //AGREGANDO USUARIO AL CLIENTE
        if ($data->has("clientes")) {

            //eliminar clientes
            foreach ($data->get("clientes") as $key => $value) {
                
                $cliente = new UserClientes();
                $cliente->fill(["user_id" => $usuario->id, "cliente_id" => $value, "id" => null]);
                $cliente->save();

            }
        }

         //AGREGA ROL REQ PARA INGRESAR AL MODULO DE REQUERMIENTO
         //$rol = Role::where("slug", "req")->first();
         $rol = Sentinel::findRoleBySlug('req');

        //  $usuario->attachRole($rol);
        $rol->users()->attach($usuario);
        
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

        $usuario->permissions = $menuArray;
        $usuario->save();

        return redirect()->route("req.usuarios")->with("mensaje_success", "Usuario creado");
    }

    public function actualizar_user_cliente(Request $data, Requests\EditarUserEmpresaRequest $validate)
    {   
        $usuario        = Sentinel::getUser();
    
        $campos_usuario = $data->all();
        unset($campos_usuario["password2"]);

        if ($data->get('password2') != "") {
            $campos_usuario["password"] = bcrypt($data->get('password2'));
        }

        $usuario->fill($campos_usuario);
        $usuario->save();

        //AGREGANDO USUARIO AL CLIENTE
        if ($data->has("clientes")) {

            $deleteClientes = UserClientes::where("user_id", $usuario->id)->delete();
            foreach ($data->get("clientes") as $key => $value) {

                $cliente = new UserClientes();
                $cliente->fill(["user_id" => $usuario->id, "cliente_id" => $value, "id" => null]);
                $cliente->save();
            }

        }

        //AGREGANDO PERMISOS
        if ($data->has("permiso") && is_array($data->get("permiso"))) {

            $permisoSeleccionados = $data->get("permiso");
            $menuArray            = [];
            $menu                 = Menu::where("modulo", "req")->where("padre_id", 0)->select("menu.*")->get();

            foreach ($menu as $key => $value) {

                if (in_array($value->slug, $permisoSeleccionados)) {
                    $menuArray[$value->slug] = true;
                } else {
                    $menuArray[$value->slug] = false;
                }

                foreach ($value->menu_hijo1() as $key2 => $value2) {

                    if(in_array($value2->slug, $permisoSeleccionados)) {
                        $menuArray[$value2->slug] = true;
                    }else{
                        $menuArray[$value2->slug] = false;
                    }
                }
            }

            $usuario->permissions = $menuArray;
            $usuario->save();
        }

        return redirect()->route("req.usuarios")->with("mensaje_success", "Usuario Actualizado");
    }

    public function clientes(Request $data)
    {
        $clientesCmb = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
            ->where("users_x_clientes.user_id", $this->user->id)
            ->orderBy("clientes.nombre", "ASC")
            ->pluck("clientes.nombre", "clientes.id")
            ->toArray();

        $clientes = Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
        ->where("users_x_clientes.user_id", $this->user->id)
        ->where(function ($sql) use ($data) {
            if ($data->get("cliente_id") != "") {
                $sql->where("clientes.id", $data->get("cliente_id"));
            }
            if ($data->get("nit") != "") {
                $sql->where("clientes.nit", $data->get("nit"));
            }
        })
        ->orderBy("clientes.nombre", "ASC")
        ->select("clientes.*")
        ->get();


      return view("req.mostrar_clientes_new", compact("clientes","clientesCmb"));
    }

    public function crear_cliente(Request $data)
    {
        $permisos = Menu::where("modulo", "req")->where("padre_id", 0)->get();
        $usuarios = ["" => "Seleccionar"] + User::pluck("name", "id")->toArray();

        $roles = Sentinel::getRoleRepository()->whereNotIn("slug", ["req", "admin", "hv","God"])->whereRaw('(codigo is null or codigo not in ("EAFL", "AFL"))')->pluck("name", "id")->toArray();

        return view("admin.clientes.nuevo_cliente", compact("permisos","usuarios", "roles"));
    }

    public function lista_cliente(Request $data)
    {  
        $eliminar = false;

        if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co") {

          if($this->user->inRole("Super Administrador")){

               $eliminar = true;
          }
        }

        $clientes = Clientes::whereIn("id", $this->clientes_user)->where(function ($where) use ($data) {
            if ($data->get("nit") != "") {
                $where->where("nit", $data->get("nit"));
            }

            if ($data->get("nombre") != "") {
                $where->where(DB::raw(" lower(clientes.nombre) "), "like", "%" . strtolower($data->get("nombre")) . "%");
            }
        })->orderBy("clientes.nombre")->paginate(10);

        return view("admin.clientes.lista_clientes", compact("clientes","eliminar"));
    }

    public function guardar_cliente(Request $data, Requests\NuevoClienteRequest $validator)
    {
        //GUARDAR CLIENTE
      
        $nuevo_cliente = new Clientes();
        $nuevo_cliente->fill($data->all());
        $nuevo_cliente->creado_por=$this->user->id;
        $nuevo_cliente->save();

        $nuevo_cliente->cliente_id = $nuevo_cliente->id;
        $nuevo_cliente->save();

        $contacto_cliente = User::select('id', 'name', 'email', 'numero_id')->where('numero_id', $data->nit)->orWhere('email', $data->correo)->first();

        //Se verifica si el contacto que estan colocando para el cliente tiene usuario en el sistema (se busca por numero_id y por correo)
        if ($contacto_cliente == null) {
            //Sino tiene usuario, se procede a crear el usuario modulo Req
            $campos_usuario = [
                'name'      => $data->get("contacto"),
                'email'     => $data->get("correo"),
                'password'  => $data->get("nit"),
                'numero_id' => $data->get("nit"),
                'cedula'    => $data->get("nit"),
                'usuario_carga' =>$this->user->id
            ];

            /* Se quita validacion de verificacion de correo cuando se va a registrar un usuario
            $validar_email = json_decode($this->verificar_email($data->get("correo")));

            if($validar_email->status==200 && !$validar_email->valid){
                return redirect()->back()->withInput()->with("mensaje_danger", $validar_email->mensaje);
            }
            */

            $contacto_cliente = Sentinel::registerAndActivate($campos_usuario);

            //CREAR ACTIVACION
            $activation = Activation::create($contacto_cliente);

            $contacto = explode(' ', $data->get("contacto"));

            $nombres = '';
            $primer_apellido = ' ';
            $segundo_apellido = null;
            switch (count($contacto)) {
                case 4:
                    $nombres = $contacto[0] . ' ' . $contacto[1];
                    $primer_apellido = $contacto[2];
                    $segundo_apellido = $contacto[3];
                    break;
                case 3:
                    $nombres = $contacto[0];
                    $primer_apellido = $contacto[1];
                    $segundo_apellido = $contacto[2];
                    break;
                case 2:
                    $nombres = $contacto[0];
                    $primer_apellido = $contacto[1];
                    break;
                
                default:
                    $nombres = $data->get("contacto");
                    break;
            }

            //CREA Datos Basicos
            $datos_basicos = new DatosBasicos();
            $datos_basicos->fill($campos_usuario + [
                "numero_id" => $data->get("nit"),
                "user_id"   => $contacto_cliente->id,
                "nombres"   => $nombres,
                "primer_apellido"   => $primer_apellido,
                "segundo_apellido"  => $segundo_apellido,
                "datos_basicos_count"   => "20",
                "estado_reclutamiento"  => config('conf_aplicacion.C_ACTIVO')
            ]);
            $datos_basicos->save();

            //AGREGAR ROL REQ
            $role = Sentinel::findRoleBySlug('req');

            $role->users()->attach($contacto_cliente);

            //AGREGANDO PERMISOS PARA REQUISICION
            $menuArray = [];

            $menu = Menu::where("modulo", "req")->whereRaw("(padre_id = 3 or id = 3)")->select("menu.*")->get();

            foreach ($menu as $key => $value) {
                $menuArray[$value->slug] = true;
            }

            $contacto_cliente->permissions = $menuArray;
            $contacto_cliente->notificacion_requisicion = 1;
            $contacto_cliente->save();
        }

        //Asignar el nuevo cliente al contacto que se ingreso
        $nuevo_cliente_user             = new UserClientes();

        $nuevo_cliente_user->user_id    = $contacto_cliente->id;
        $nuevo_cliente_user->cliente_id = $nuevo_cliente->id;
        $nuevo_cliente_user->save();

        if($data->hasFile('archivo_logo_cliente')) {
            $imagen         = $data->file("archivo_logo_cliente");
            $extencion      = $imagen->getClientOriginalExtension();

            $name_documento = "cliente_logo_" . $nuevo_cliente->cliente_id . "." . $extencion;

            $imagen->move("recursos_clientes_logos", $name_documento);
                
            $nuevo_cliente->logo = $name_documento;
            $nuevo_cliente->save();
        }

        if($data->get("seleccion_user") == 1) {
            $cliente             = new UserClientes();

            $cliente->user_id    = $data->get("user_exits");
            $cliente->cliente_id = $nuevo_cliente->id;
            $cliente->save();
        }elseif($data->get("seleccion_user") == 2) {
            $reglas = [
                "name"       => "required",
                "email"      => "required|email|unique:users,email",
                "ciudad_id"  => "required",
                "pais_id_u"  => "required",
                "password"   => "required|min:2"
            ];

            unset($data["seleccion_user"]);

            $validar = Validator::make($data->all(), $reglas);

            if($validar->fails()) {
                return redirect()->back()->withErrors($validar);
            }

            //GUARDAR USUARIO
            $campos_usuario                             = $data->all();
            $campos_usuario["password"]                 = $data->get('password');
            $campos_usuario["estado"]                   = 1;
            $campos_usuario["pais_id"]                  = $data->get("pais_id_u");
            $campos_usuario["ciudad_id"]                = $data->get("ciudad_id_u");
            $campos_usuario["departamento_id"]          = $data->get("departamento_id_u");
            $campos_usuario["notificacion_requisicion"] = $data->get("notificacion_requisicion");

            $usuario        = Sentinel::registerAndActivate($campos_usuario);
            $usuario->save();

            //AGREGANDO USUARIO AL CLIENTE
            $cliente             = new UserClientes();
            $cliente->user_id    = $usuario->id;
            $cliente->cliente_id = $nuevo_cliente->id;
            $cliente->save();

            //AGREGA ROL REQ PARA INGRESAR AL MODULO DE REQUERMIENTO
            $rol = Sentinel::findRoleBySlug('req');
            $rol->users()->attach($usuario);

            //AGREGANDO PERMISOS
            if($data->has("permiso") && is_array($data->get("permiso"))){
                $permisoSeleccionados = $data->get("permiso");
                $menuArray            = [];
                $menu                 = Menu::where("modulo", "req")->where("padre_id", 0)->select("menu.*")->get();

                foreach ($menu as $key => $value) {
                    if (in_array($value->slug, $permisoSeleccionados)) {
                        $menuArray[$value->slug] = true;
                    } else {
                        $menuArray[$value->slug] = false;
                    }

                    foreach($value->menu_hijo1() as $key2 => $value2) {
                        if(in_array($value2->slug, $permisoSeleccionados)) {
                            $menuArray[$value2->slug] = true;
                        }else{
                            $menuArray[$value2->slug] = false;
                        }
                    }
                }

                $usuario->permissions = $menuArray;
                $usuario->save();
            }
        }

        //Se les asignara siempre a los que tengan rol AFL o EAFL
        //Buscar todos los que son de seleccion para agregarle el cliente
        if(route("home") == "https://gpc.t3rsc.co") {
            $usuarios=User::join("role_users", "role_users.user_id", "=", "users.id")
                ->join('roles', 'roles.id', '=', 'role_users.role_id')
                ->orWhereIn('roles.codigo', ['AFL', 'EAFL'])
                ->whereIn("role_users.role_id", [5, 11])
                ->select("users.id as user_id", "users.name as nombre", "role_users.role_id as role")
                ->groupBy("users.id")
            ->get();
        }else {
            if($data->has("roles") && is_array($data->get("roles"))){
                $usuarios=User::join("role_users", "role_users.user_id", "=", "users.id")
                    ->join('roles', 'roles.id', '=', 'role_users.role_id')
                    ->whereIn("role_users.role_id", $data->roles)
                    ->orWhereIn('roles.codigo', ['AFL', 'EAFL'])
                    ->select("users.id as user_id", "users.name as nombre", "role_users.role_id as role")
                    ->groupBy("users.id")
                ->get();
            } else {
                $usuarios=User::join("role_users", "role_users.user_id", "=", "users.id")
                    ->join('roles', 'roles.id', '=', 'role_users.role_id')
                    ->orWhereIn('roles.codigo', ['AFL', 'EAFL'])
                    ->select("users.id as user_id", "users.name as nombre", "role_users.role_id as role")
                    ->groupBy("users.id")
                ->get();
            }
        }

        foreach($usuarios as $u){
            $user_cliente             = new UserClientes();
            
            $user_cliente->user_id    = $u->user_id;
            $user_cliente->cliente_id = $nuevo_cliente->id;
            $user_cliente->save();
        }
        
        return redirect()->route("admin.crear_cliente")
        ->with("mensaje_success", "El cliente se ha creado con éxito. Recuerda crear un negocio nuevo para este.");
    }

    public function editar_cliente_admin($id, Request $data)
    {
        $cliente      = Clientes::find($id);
        $txtUbicacion = $cliente->getUbicacion()->value;

        return view("admin.clientes.editar_cliente", compact("cliente", "txtUbicacion"));
    }

    public function actualizar_datos_cliente(Request $data)
    {
        $cliente = Clientes::find($data->get("id"));
        $cliente_old=json_encode($cliente);
        
        $cliente->fill($data->all());
        $cliente->save();

        if($data->hasFile('archivo_logo_cliente')) {

          $imagen         = $data->file("archivo_logo_cliente");
          $extencion      = $imagen->getClientOriginalExtension();

           $name_documento = "cliente_logo_" . $cliente->cliente_id . "." . $extencion;

           $imagen->move("recursos_clientes_logos", $name_documento);
                
            $cliente->logo = $name_documento;
            $cliente->save();
        }

        $cliente_new=json_encode($cliente);

            if($cliente_old!=$cliente_new){

                $auditoria= new Auditoria();
                $auditoria->observaciones = "Editar cliente";
                $auditoria->valor_antes   = $cliente_old;
                $auditoria->valor_despues = $cliente_new;
                $auditoria->user_id       = $this->user->id;
                $auditoria->tabla         = "clientes";
                $auditoria->tabla_id      = $cliente->id;
                $auditoria->tipo          = "ACTUALIZAR";
                event(new \App\Events\AuditoriaEvent($auditoria));
            }

                



        return redirect()->route("admin.lista_clientes")->with("mensaje_success", "Los datos del cliente han sido actualizados.");
    }

    public function lista_user_cliente(Request $data)
    {

        $usuarios = User::leftJoin("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
        ->leftJoin("clientes", "clientes.id", "=", "users_x_clientes.cliente_id")
        ->where(function ($where) use ($data) {
            if($data->get("email") != "") {

              $where->where(DB::raw(" lower(users.email) "), "like", "%" . strtolower($data->get("email")) . "%");
              $where->orWhere(DB::raw(" lower(users.name) "), "like", "%" . strtolower($data->get("email")) . "%");

               if(is_numeric($data->get("email"))) {
                 $where->orWhere("users.numero_id", "=", $data->get("email"));
               }
            }
            
            if ($data->get("cliente_id") != "") {
                $where->where("clientes.id", $data->get("cliente_id"));
            }

        })
        ->select(DB::raw(" ' '  as clientes_nombre"),
            "users.id",
            "users.email",
            "users.name"
        )
        ->groupBy("users.id",
            "users.email",
            "users.name"
        )
        ->take(10)
        ->get();

        $clientes = ["" => "Seleccionar"] + Clientes::orderBy(DB::raw("UPPER(clientes.nombre)"),"ASC")->pluck("nombre", "id")->toArray();

        return view("admin.clientes.lista_usuarios_clientes", compact("usuarios", "clientes"));
    }

    public function editar_user_cliente_admin($user_id, Request $data)
    {

        $permisos = Menu::where("modulo", "req")->where("padre_id", 0)->select("menu.*")->get();

        $usuario = User::find($user_id);

        $activado = "";

        if (Activation::completed($usuario)) {
            $activado = 1;
        } else {
            $activado = 0;
        }

        $clientes_user = [];

        foreach (Clientes::leftJoin("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
                ->where("users_x_clientes.user_id", $user_id)
                ->select("clientes.id")
                ->get() as $key => $value)
        {
            array_push($clientes_user, $value->id);
        }

        $clientes  = Clientes::where("estado", config('conf_aplicacion.ESTADO_CLIENTE'))
        ->orderBy('clientes.nombre', 'asc')
        ->where(function ($query) use ($data) {
            if ($data->has("cliente_id") && $data->get("cliente_id")) {
                $query->where("clientes.id", $data->get("cliente_id"));
            }
        })
        ->paginate(500);

        $ubicacion = User::join("paises", "paises.cod_pais", "=", "users.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "users.pais_id")->on("departamentos.cod_departamento", "=", "users.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "users.pais_id")
                ->on("ciudad.cod_departamento", "=", "users.departamento_id")
                ->on("ciudad.cod_ciudad", "=", "users.ciudad_id");
        })->where("ciudad.cod_pais", $usuario->pais_id)
        ->where("ciudad.cod_departamento", $usuario->departamento_id)
        ->where("ciudad.cod_ciudad", $usuario->ciudad_id)
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad"))
        ->first();

        //SELECT DE CIUDAD DE SEDES
        $ciudad_trabajo = ["" => "Seleccionar"] + config('conf_aplicacion.SEDES_MUNICIPIO');

        //UNIDADES DE TRABAJO
        $unidad_trabajo = ["" => "Seleccionar"] + UnidadTrabajo::where("estado", 1)->orderBy("descripcion", "ASC")->pluck("descripcion", "id")->toArray();

        return view("admin.clientes.editar_user", compact("ubicacion", "permisos", "usuario", "clientes", "clientes_user", "activado", "ciudad_trabajo", "unidad_trabajo"));
    }

    public function actualizar_usuario_cliente(Request $data)
    {
        $usuario = User::where("id", $data->get("id"))->first();
        $campos_usuario = $data->all();
        unset($campos_usuario["pass"]);

        if ($data->get('pass') != "") {
            $campos_usuario["password"] = bcrypt($data->get('pass'));
        }

        if (!$data->has("notificacion_requisicion")) {
            $campos_usuario["notificacion_requisicion"] = 0;
        }

        $usuario->fill($campos_usuario);
        $usuario->save();

        //INACTIVAR USER
        if ($data->get("estado") == 0) {
            Activation::remove($usuario);
        }

        if ($data->get("estado") == 1 && !Activation::completed($usuario)) {
            $activation = Activation::create($usuario);
            Activation::complete($usuario, $activation->code);
        }

        //AGREGANDO USUARIO AL CLIENTE
        if ($data->has("clientes")) {
            UserClientes::where("user_id", $usuario->id)->delete();

            foreach ($data->get("clientes") as $key => $value) {
                $cliente             = new UserClientes();
                $cliente->user_id    = $usuario->id;
                $cliente->cliente_id = $value;
                $cliente->save();
            }
        }else {
            UserClientes::where("user_id", $usuario->id)->delete();
        }

        //AGREGANDO PERMISOS
        if ($data->has("permiso") && is_array($data->get("permiso"))) {
            $permisoSeleccionados = $data->get("permiso");
            $menuArray            = [];
            $menu                 = Menu::where("modulo", "req")->where("padre_id", 0)->select("menu.*")->get();

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
            $usuario->permissions = $menuArray;
            $usuario->save();
        }

        return redirect()->route("admin.usuarios_clientes")->with("mensaje_success", "Usuario Actualizado");
    }

    public function autocomplete_usuarios(Request $data)
    {
        $q = $data->get("query");

        $res = User::select("users.id", "users.name as value")
        ->where(function ($sql) use ($q) {
            if ($q != "") {
                $sql->whereRaw("LOWER(name) like '%" . strtolower($q) . "%'");
            }
        })
        ->orderBy("name", "asc")
        ->take(5)
        ->get()
        ->toArray();

        return response()->json(["suggestions" => $res]);
    }

    public function autocomplete_cliente(Request $data)
    {
        $q   = $data->get("query");
        $res = Clientes::select("id", "nombre as value")
        ->where(function ($sql) use ($q) {
            if ($q != "") {
                $sql->whereRaw("LOWER(nombre) like '%" . strtolower($q) . "%'");
            }
        })->where("estado", config("conf_aplicacion.ESTADO_CLIENTE"))
        ->orderBy("nombre", "asc")
        ->take(10)
        ->get()
        ->toArray();

        return response()->json(["suggestions" => $res]);{
        }

    }

    public function lista_user_agencia(Request $data)
    {
        $usuarios = User::leftJoin("agencia_usuario", "agencia_usuario.id_usuario", "=", "users.id")
        ->leftJoin("agencias", "agencias.id", "=", "agencia_usuario.id_agencia")
        ->where(function ($where) use ($data) {
            if ($data->get("email") != "") {
                $where->where(DB::raw(" lower(users.email) "), "like", "%" . strtolower($data->get("email")) . "%");
                $where->orWhere(DB::raw(" lower(users.name) "), "like", "%" . strtolower($data->get("email")) . "%");
                if (is_numeric($data->get("email"))) {
                    $where->orWhere("users.numero_id", "=", $data->get("email"));
                }
            }
            
            if ($data->get("cliente_id") != "") {
                $where->where("clientes.id", $data->get("cliente_id"));
            }

        })
        ->select(DB::raw(" ' '  as clientes_nombre"),
            "users.id",
            "users.email",
            "users.name"
        )
        ->groupBy("users.id",
            "users.email",
            "users.name"
        )
        ->take(10)
        ->get();

        $agencias = ["" => "Seleccionar"] + Agencia::pluck("descripcion", "id")->toArray();

        return view("admin.clientes.lista_usuarios_agencias", compact("usuarios", "agencias"));
    }

    public function editar_user_agencia($user_id, Request $data)
    {

        $permisos = Menu::where("modulo", "req")->where("padre_id", 0)->select("menu.*")->get();

        $usuario = User::find($user_id);

        $agencias_user = [];

        foreach (Agencia::leftJoin("agencia_usuario", "agencia_usuario.id_agencia", "=", "agencias.id")
            ->where("agencia_usuario.id_usuario", $user_id)
            ->select("agencias.id")
            ->get() as $key => $value){
            array_push($agencias_user, $value->id);
        }

        $agencias  = Agencia::orderBy('descripcion', 'asc')->paginate(50);

        return view("admin.clientes.user_agencia", compact("permisos", "usuario", "agencias", "agencias_user"));
    }

    public function actualizar_usuario_agencia(Request $data)
    {
        $usuario = User::where("id", $data->get("id"))->first();

        //AGREGANDO USUARIO A AGENCIAS
        if($data->has("agencias")) {
            AgenciaUsuario::where("id_usuario", $usuario->id)->delete();

            foreach ($data->get("agencias") as $key => $value) {
                $agencia             = new AgenciaUsuario();
                $agencia->id_usuario    = $usuario->id;
                $agencia->id_agencia = $value;
                $agencia->save();
            }
        }

        return redirect()->route("admin.usuarios_clientes")->with("mensaje_success", "Usuario Actualizado");
    }

    public function eliminar_cliente($id)
    {

        $clientes = Clientes::where("clientes.id", $id)->first();

        $negocio = Negocio::where('cliente_id',$id)->delete();
        $cargos = CargoEspecifico::where('clt_codigo',$id)->delete();

        $clientes->delete();

        //dd($clientes);

        return response()->json('success');
    }

    public function cargo_cliente(Request $request)
    {
        $cargos = CargoEspecifico::where("clt_codigo", $request->id)
            ->select("descripcion", "id")
            ->orderBy("descripcion")
            ->get()
            ->toArray();

        return response()->json(["success" => true, "cargos" => $cargos]);
    }

}
