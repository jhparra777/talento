<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\FuncionesGlobales;
use App\Models\DatosBasicos;
use App\Models\User as UsersSentile;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CargaMasivaUsuariosController extends Controller
{
    /**
     * Vista para realizar la carga masiva de archivos en con estención (.xml, .opt)
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.carga_masiva.usuarios.index");
    }

    /**
     * Se carga el archivo plano a la bd
     */
    public function cargar_usuarios_masivos(Request $data)
    {
        ini_set('max_execution_time', 999999);
        ini_set('memory_limit', '-1');
        $rules = [
            //'archivo' => 'required',
        ];

        $valida = Validator::make($data->all(), $rules);
        if ($valida->fails()) {
            return redirect()->back()->withErrors($valida)->withInput();
        }

        $errores_global      = [];
        $registrosInsertados = 0;

        $reader = Excel::selectSheetsByIndex(0)->load($data->file("archivo"))->get();
        foreach ($reader as $key => $value) {
            $errores = [];
            $datos   = [
                'numero_id'               => $value->nro_identificacion,
                'fecha_expedicion'        => $value->fexpedicion_doc_identifica,
                'pais_expedicion'         => $value->pais_expedicion,
                'departamento_expedicion' => $value->departamento_expedicion,
                'ciudad_expedicion'       => $value->ciudad_expedicion,
                'primer_apellido'         => $value->papellido,
                'segundo_apellido'        => $value->sapellido,
                'primer_nombre'           => $value->pnombre,
                'segundo_nombre'          => $value->snombre,
                'genero'                  => $value->sexo,
                'fecha_nacimiento'        => $value->fnacimiento,
                'pais_nacimiento'         => $value->pais_nacimiento,
                'departamento_nacimiento' => $value->departamento_nacimiento,
                'ciudad_nacimiento'       => $value->ciudad_nacimiento,
                'estado_civil'            => $value->estado_civil,
                'grupo_sangineo'          => $value->grupo_sanguineo,
                'rh'                      => $value->RH,
                'telefono_movil'          => $value->telefono_residencia,
                'direccion_residencia'    => $value->direccion_residencia,
                'pais_residencia'         => $value->pais_residencia,
                'departamento_residencia' => $value->departamento_residencia,
                'ciudad_residencia'       => $value->ciudad_residencia,
                'email'                   => $value->correo_electronico,
                'cargo_desempeno'         => $value->idcargo,
                'eps'                     => $value->estado_civil,
                'afp'                     => $value->estado_civil,
                "user_carga"              => $this->user->id,
            ];
            //VALIDA LOS CAMPOS PARA EL REGISTRO EN LA BD
            $guardar = true;

            $cedula = Validator::make($datos, ["numero_id" => "required"]);
            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "La columna nro_identificacion es obligatorio");
            }
            $cedula = Validator::make($datos, ["numero_id" => "unique:users,numero_id"]);
            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "La columna nro_identificacion ya ha sido cargado");
            }

            $cedula = Validator::make($datos, ["numero_id" => "numeric"]);
            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "La columna nro_identificacion no tiene el formato correcto");
            }
            $movil = Validator::make($datos, ["telefono" => "numeric"]);
            if ($movil->fails()) {
                $guardar = false;
                array_push($errores, "La columna telefono_residencia no tiene el formato correcto");
            }
            $fijo = Validator::make($datos, ["telefono_fijo" => "numeric"]);
            if ($fijo->fails()) {
                $guardar = false;
                array_push($errores, "El telefono fijo no tiene el formato correcto");
            }

            $email = Validator::make($datos, ["email" => "required | email"]);
            if ($email->fails()) {
                $guardar = false;
                array_push($errores, "La columna correo_electronico es obligatorio");
            }

            $email = Validator::make($datos, ["email" => "unique:users,email"]);
            if ($email->fails()) {
                $guardar = false;
                array_push($errores, "La columna correo_electronico ya se encuentra en el sistema");
            }

            $pais_nacimiento = Validator::make($datos, ["pais_nacimiento" => "required|numeric"]);
            if ($pais_nacimiento->fails()) {
                $guardar = false;
                array_push($errores, "La columna pais nacimiento tiene que ser numérico");
            }

            $departamento_nacimiento = Validator::make($datos, ["departamento_nacimiento" => "required|numeric"]);
            if ($departamento_nacimiento->fails()) {
                $guardar = false;
                array_push($errores, "El departamento de nacimiento tiene que ser numérico");
            }

            $ciudad_nacimiento = Validator::make($datos, ["ciudad_nacimiento" => "required|numeric"]);
            if ($ciudad_nacimiento->fails()) {
                $guardar = false;
                array_push($errores, "La  ciudad de nacimiento tiene que ser numérico");
            }

            $departamento_expedicion = Validator::make($datos, ["departamento_expedicion" => "required|numeric"]);
            if ($departamento_expedicion->fails()) {
                $guardar = false;
                array_push($errores, "El departamento de expedicion tiene que ser numérico");
            }

            $ciudad_expedicion = Validator::make($datos, ["ciudad_expedicion" => "required|numeric"]);
            if ($ciudad_expedicion->fails()) {
                $guardar = false;
                array_push($errores, "La ciudad de expedicion tiene que ser numérico");
            }

            $primer_apellido = Validator::make($datos, ["primer_apellido" => "required"]);
            if ($primer_apellido->fails()) {
                $guardar = false;
                array_push($errores, "El primer apellido es un campo obligatorio");
            }

            $segundo_apellido = Validator::make($datos, ["segundo_apellido" => "required"]);
            if ($primer_apellido->fails()) {
                $guardar = false;
                array_push($errores, "El segundo apellido es un campo obligatorio");
            }

            $primer_nombre = Validator::make($datos, ["primer_nombre" => "required"]);
            if ($primer_nombre->fails()) {
                $guardar = false;
                array_push($errores, "El campo primer_nombre son obligatorios");
            }

            /*$segundo_nombre = Validator::make($datos, ["segundo_nombre" => "required"]);
            if ($segundo_nombre->fails()) {
                $guardar = false;
                array_push($errores, "El campo segundo_nombre son obligatorios");
            }*/

            $primer_apellido = Validator::make($datos, ["primer_apellido" => "required"]);
            if ($primer_apellido->fails()) {
                $guardar = false;
                array_push($errores, "El campo primer_apellido son obligatorios");
            }

            /*$segundo_apellido = Validator::make($datos, ["segundo_apellido" => "required"]);
            if ($segundo_apellido->fails()) {
                $guardar = false;
                array_push($errores, "El campo segundo_apellido son obligatorios");
            }*/

            $fecha_nacimiento = Validator::make($datos, ["fecha_nacimiento" => "required|date"]);
            if ($fecha_nacimiento->fails()) {
                $guardar = false;
                array_push($errores, "El campo fecha_nacimiento es obligatorio");
            }

            $genero = Validator::make($datos, ["genero" => "required|numeric"]);
            if ($genero->fails()) {
                $guardar = false;
                array_push($errores, "Tiene que escribir el codigo del genero en numeros");
            }

            $estado_civil = Validator::make($datos, ["estado_civil" => "required|numeric"]);
            if ($estado_civil->fails()) {
                $guardar = false;
                array_push($errores, "Tiene que escribir el codigo del estado civil en numeros");
            }

            $direccion = Validator::make($datos, ["direccion_residencia" => "required"]);
            if ($direccion->fails()) {
                $guardar = false;
                array_push($errores, "El campo dirección es obligatorio");
            }

            $departamento_residencia = Validator::make($datos, ["departamento_residencia" => "required|numeric"]);
            if ($departamento_residencia->fails()) {
                $guardar = false;
                array_push($errores, "Tiene que escribir el codigo del departamento de residencia en numeros");
            }

            //Validar si el candidato se encuentra en un proceso ("seleccion","Contratacion","seguridad")
            $usuario_existe = DatosBasicos::
                where("numero_id", $datos["numero_id"])
                ->first();

            if ($usuario_existe !== null) {
                $guardar = false;
                array_push($errores, "El usuario se encuentra registrado.");
            }

            if ($guardar == true) {
                if ($usuario_existe == null) {
                    $campos_usuario = [
                        'name'      => $datos["primer_nombre"] . " " . $datos["segundo_nombre"] . " " . $datos["primer_apellido"] . " " . $datos["segundo_apellido"],
                        'email'     => $datos["email"],
                        'password'  => $datos["numero_id"],
                        'numero_id' => $datos["numero_id"],
                    ];
                    $user       = Sentinel::registerAndActivate($campos_usuario);
                    $usuario_id = $user->id;
                    //Creamos sus datos basicos
                    $datos_basicos = new DatosBasicos();
                    $datos_basicos->fill([
                        'numero_id'                  => $datos["numero_id"],
                        'ciudad_expedicion_id'       => $datos["ciudad_expedicion"],
                        'departamento_expedicion_id' => $datos["departamento_expedicion"],
                        'pais_residencia'            => $datos["pais_residencia"],
                        'ciudad_residencia'          => $datos["ciudad_residencia"],
                        'departamento_residencia'    => $datos["departamento_residencia"],
                        'pais_nacimiento'            => $datos["pais_nacimiento"],
                        'pais_id'                    => $datos["pais_expedicion"],
                        'departamento_nacimiento'    => $datos["departamento_nacimiento"],
                        'ciudad_nacimiento'          => $datos["ciudad_nacimiento"],
                        'genero'                     => $datos["genero"],
                        'estado_civil'               => $datos["estado_civil"],
                        'user_id'                    => $usuario_id,
                        'nombres'                    => $datos["primer_nombre"] . " " . $datos["segundo_nombre"],
                        'direccion'                  => $datos["direccion_residencia"],
                        'fecha_nacimiento'           => $datos["fecha_nacimiento"],
                        'primer_apellido'            => $datos["primer_apellido"],
                        'segundo_apellido'           => $datos["segundo_apellido"],
                        'telefono_movil'             => $datos["telefono_movil"],
                        'estado_reclutamiento'       => config('conf_aplicacion.C_ACTIVO'),
                        'datos_basicos_count'        => "100",
                        'email'                      => $datos["email"],
                    ]);
                    $datos_basicos->save();

                    //Creamos el rol
                    $role = Sentinel::findRoleBySlug('hv');
                    $role->users()->attach($user);

                    //Enviar correo de recuperación de contraseña
                    $user = UsersSentile::
                        where("email", $datos["email"])
                        ->first();

                    $datos_basicos = $user->getDatosBasicos();

                    $has = Reminder::create($user);

                    $funcionesGlobales = new FuncionesGlobales();
                    if (isset($funcionesGlobales->sitio()->nombre)) {
                        if ($funcionesGlobales->sitio()->nombre != "") {
                            $nombre = $funcionesGlobales->sitio()->nombre;
                        } else {
                            $nombre = "Desarrollo";
                        }
                    }

                    /*$emails = $datos["email"];
                    Mail::send('emails.restablecer_password_usuario_masivo', ["hash" => $has->code, "user" => $user, 'datos_basicos' => $datos_basicos], function ($message) use ($emails) {
                        $message->to('apolorubiano@gmail.com', '$nombre -T3RS')->cc($emails)->subject('Notificación (Actualizar Contraseña)!');
                    });*/
                } else {
                    $usuario_activo = DatosBasicos::where("numero_id", $datos["numero_id"])
                        ->first();
                }
                //Creamos el registro del usuario con su perfil
                $registrosInsertados++;
            } else {
                $errores_global[$key] = $errores;
            }
        }

        $mensaje_success = "Se han cargado <b>$registrosInsertados</b> con exito.";

        return response()->json(["success" => true, "mensaje_success" => $mensaje_success, 'errores_global' => $errores_global]);

    }
}
