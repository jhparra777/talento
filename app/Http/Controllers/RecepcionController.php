<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CitacionCandidato;
use App\Models\DatosBasicos;
use App\Models\PerfilamientoCandidato;
use App\Models\Recepcion;
use App\Models\RecepcionMotivo;
use App\Models\ReqCandidato;
use App\Models\TipoIdentificacion;
use App\Models\UnidadTrabajo;
use App\Models\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecepcionController extends Controller
{

    protected $estados_no_muestra = [];

    public function __construct()
    {
        parent::__construct();
        $this->estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
        ]; //SON LOS ESTADOS PARA NO MOSTRAR EL CANDIDATO EN EL  REQUERIMIENTO
    }

    public function index(Request $data)
    {
        //usar el user_id de la tabla users
        $candidato       = null;
        $v_perfilamiento = null;
        $procesoIniciado = null;
        $v_pruebas       = null;
        if ($data->get("cedula") != "") {

            $candidato = DatosBasicos::where("numero_id", $data->get("cedula"))->first();
            if ($candidato == null) {
                $candidato                       = new \stdClass();
                $candidato->numero_id            = $data->get("cedula");
                $candidato->user_id              = 0;
                $candidato->estado_reclutamiento = "";
            }

            $v_perfilamiento = PerfilamientoCandidato::where("candidato_id", "!=", 0)
                ->where("candidato_id", $candidato->user_id)
                ->first();
            /*
            $response = Curl::to(config("conf_aplicacion.URL_PRUEBAS_CURL"))
            ->withData(array("cedulas" => [$data->get("cedula")], "tipo" => 1))
            ->post();
            $responseCurl = json_decode($response,true);
            $v_pruebas = (($responseCurl["cedulas"][$data->get("cedula")]) ? 1 : 0);
             */
            //TODO hay que sacar la prueba entre las del candidato
            $prueba = DatosBasicos::join("gestion_pruebas", "gestion_pruebas.candidato_id", "=", "datos_basicos.user_id")
                ->where("gestion_pruebas.tipo_prueba_id", config('conf_aplicacion.ID_PRUEBA_TENDENCIA'))
                ->where("datos_basicos.numero_id", $data->get("cedula"))
                ->where("gestion_pruebas.fecha_vencimiento", ">=", date('Y-m-d'))
                ->get();
            //dd($prueba->count());

            $v_pruebas = $prueba->count();
            //dd($v_pruebas);
            $procesoIniciado = Recepcion::where("candidato_id", "!=", 0)
                ->where("candidato_id", $candidato->user_id)
                ->get();
            //VERIFICA SI EL USUARIO YA LO ENVIARON A PERFILAR O PRUEBAS
            //dd($procesoIniciado);

            //Tipo documento que dejan en recepcion (SELECCION)
            $tipos_documentos = ["" => "Seleccionar"] + TipoIdentificacion::where("active", 1)->pluck("descripcion", "id")->toArray();

            //Tipo motivo de la asistencia del personal
            $tipos_motivos = ["" => "Seleccionar"] + RecepcionMotivo::where("active", 1)->pluck("descripcion", "id")->toArray();

            $registro = Recepcion::where("candidato_id", $candidato->user_id)
                ->where("proceso", "OTROS")
                ->where("estado", 0)
                ->first();
            //dd($registro);

            if ($registro == null) {
                $control = 3;
            } else {
                $control    = $registro->estado;
                $id_control = $registro->id;
            }

            $registro_b = Recepcion::where("candidato_id", $candidato->user_id)
                ->where("proceso", "TURNO")
                ->where("estado", 3)
                ->first();

            //dd($registro);

            if ($registro_b == null) {
                $control_b = 1;
            } else {
                $control_b    = $registro_b->estado;
                $id_control_b = $registro_b->id;
            }

            //Verificar si el usuario tiene citaciones
            $citacion = CitacionCandidato::where("user_id", $candidato->user_id)
                ->orderBy("created_at", "ASC")
                ->get();
            //dd($citacion);

            //SELECT DE CIUDAD DE SEDES
            $ciudad_trabajo = ["" => "Seleccionar"] + config('conf_aplicacion.SEDES_MUNICIPIO');
            //dd($ciudad_trabajo);

            $unidad_trabajo = ["" => "Seleccionar"] + UnidadTrabajo::where("estado", 1)->orderBy("descripcion", "ASC")->pluck("descripcion", "id")->toArray();

            //Usuario Psicologo
            $psicologos = ["" => "Seleccionar"] + User::join("role_users", "role_users.user_id", "=", "users.id")
                ->whereIn("role_users.role_id", [
                    config('conf_aplicacion.SELECCION_REGIONAL'),
                    config('conf_aplicacion.LIDER_SELECCION'),
                    config('conf_aplicacion.COORDINADOR_SELECCION'),
                    config('conf_aplicacion.SELECCION'),
                ])
                ->pluck("users.name", "users.id")
                ->toArray();
            //dd($psicologos);

        }

        return view("admin.recepcion.index", compact("candidato", "v_pruebas", "v_perfilamiento", "procesoIniciado", "tipos_documentos", "tipos_motivos", "control", "id_control", "control_b", "id_control_b", "citacion", "ciudad_trabajo", "unidad_trabajo", "psicologos"));
    }

    public function iniciar_proceso_recepcion(Request $data)
    {

        //usar el user_id de la tabla users
        $rules = [
            'nombres'           => 'required|max:255',
            'primer_apellido'   => 'required|max:255',
            'telefono_fijo'     => 'required|numeric',
            'telefono_movil'    => 'required|numeric',
            'email'             => 'required|email',
            'numero_id'         => 'required|numeric',
            'motivo'            => 'required|numeric',
            'documento_deja'    => 'required|numeric',
            'numero_ficha'      => 'required|numeric|min:1',
            'ciudad_trabajo'    => 'required',
            //'unidad' => 'required',
            'usuario_seleccion' => 'required',
        ];

        $valida = Validator::make($data->all(), $rules);
        if ($valida->fails()) {
            return redirect()->back()->withErrors($valida)->withInput();
        }

        //Registrar el pais departamento ciudad de trabajo y unidad
        $ciudad_trabajo = list($pais_id, $departamento_id, $ciudad_id) = explode("~", $data->get("ciudad_trabajo"));

        if ($data->get("id") == "") {
            //VALIDA DATOS ANTES DE INICIAR PROCESO
            $rules = ['nombres' => 'required|max:255',
                'primer_apellido'   => 'required|max:255',
                'telefono_fijo'     => 'required|numeric',
                'telefono_movil'    => 'required|numeric',
                'email'             => 'required|email|max:255|unique:users,email',
                'numero_id'         => 'required|numeric|unique:datos_basicos,numero_id',
                'motivo'            => 'required|numeric',
                'documento_deja'    => 'required|numeric',
                'numero_ficha'      => 'required|numeric|min(1)',
            ];

            $valida = Validator::make($data->all(), $rules);
            if ($valida->fails()) {
                return redirect()->back()->withErrors($valida)->withInput();
            }

            //SI EL USUARIO NO EXISTE CREAMOS UN NUEVO REGISTRO EN USERS Y DATOS BASICOS
            //REGISTRAR USUARIO
            $campos             = $data->all();
            $campos["password"] = $data->get("numero_id");
            $campos["name"]     = $data->get("nombres") . " " . $data->get("primer_apellido") . " " . $data->get("segundo_apellido");
            $user               = Sentinel::registerAndActivate($campos);
            //CREA HV
            $datos_basicos = new DatosBasicos();
            $datos_basicos->fill($data->except(["user_id"]) + ["user_id" => $user->id, "estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')]);
            $datos_basicos->save();

            //AGREGAR ROL USUARIO
            $role = Sentinel::findRoleBySlug('hv');
            $role->users()->attach($user);

            //VALIDA SI EXISTE UN PROCESO INICIADO.
            $proceso = Recepcion::where("candidato_id", $user->id)->get();

            if ($proceso->count() >= 0) {
                //REGISTRAR PROCESO DE PRUEBAS
                $nuevoProceso = new Recepcion();
                $nuevoProceso->fill([
                    "candidato_id" => $user->id,
                    "estado"       => $data->get("pruebas"),
                    "proceso"      => "PRUEBAS",
                    "USER_ENVIO"   => $this->user->id,
                ]);
                $nuevoProceso->save();

                //REGISTRAR PROCESO DE PERFILAMIENTO
                $nuevoProceso = new Recepcion();
                $nuevoProceso->fill([
                    "candidato_id" => $user->id,
                    "estado"       => $data->get("perfilamiento"),
                    "proceso"      => "PERFILAMIENTO",
                    "USER_ENVIO"   => $this->user->id,
                ]);
                $nuevoProceso->save();

                //GENERAR DIGITURNO SI PERFILAMIENTO Y PRUEBAS YA ESTAN LISTO
                if ($data->get("pruebas") == 1 && $data->get("perfilamiento") == 1) {
                    //REGISTRAR PROCESO DE PERFILAMIENTO
                    $ultimoTurno  = Recepcion::orderBy("turno")->first();
                    $ultimoTurno  = $ultimoTurno->turno + 1;
                    $nuevoProceso = new Recepcion();
                    $nuevoProceso->fill([
                        "candidato_id"         => $user->id,
                        "turno"                => $ultimoTurno,
                        "estado"               => 0,
                        "proceso"              => "TURNO",
                        "USER_ENVIO"           => $this->user->id,
                        "motivo"               => $data->get("motivo"),
                        "numero_ficha"         => $data->get("numero_ficha"),
                        "documento_deja"       => $data->get("documento_deja"),
                        "pais_trabajo"         => $ciudad_trabajo[0],
                        "departamento_trabajo" => $ciudad_trabajo[1],
                        "ciudad_trabajo"       => $ciudad_trabajo[2],
                        "unidad"               => $data->get("unidad"),
                        "user_seleccion"       => $data->get("usuario_seleccion"),
                    ]);
                    //dd($nuevoProceso);
                    $nuevoProceso->save();
                }
            }

            return redirect()->route("admin.recepcion")->with("mensaje_success", "El usuario se ha creado con exito y ha iniciado un proceso.");
        } else {
            $datos = ReqCandidato::
                join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->whereRaw(" requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
                ->where("requerimiento_cantidato.candidato_id", $data->get("user_id"))
                ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_ACTIVO'));

            if ($datos->count() > 0) {

                $req           = $datos->first();
                $datos_basicos = DatosBasicos::where("user_id", $data->get("user_id"))->first();

                return redirect()->back()->with("mensaje_error", "EL candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> ya fue ingresado al requerimiento <strong>" . $req->requerimiento_id . "</strong>.");
            }

            //SI EL USUARIO ESTA REGISTRADO
            //VALIDA SI EXISTE UN PROCESO INICIADO.
            $proceso = Recepcion::where("candidato_id", $data->get("user_id"))->get();

            if ($proceso->count() >= 0) {
                //REGISTRAR PROCESO DE PRUEBAS
                $nuevoProceso = new Recepcion();
                $nuevoProceso->fill([
                    "candidato_id" => $data->get("user_id"),
                    "estado"       => $data->get("pruebas"),
                    "proceso"      => "PRUEBAS",
                    "USER_ENVIO"   => $this->user->id,
                ]);
                $nuevoProceso->save();
                //REGISTRAR PROCESO DE PERFILAMIENTO
                $nuevoProceso = new Recepcion();
                $nuevoProceso->fill([
                    "candidato_id" => $data->get("user_id"),
                    "estado"       => $data->get("perfilamiento"),
                    "proceso"      => "PERFILAMIENTO",
                    "USER_ENVIO"   => $this->user->id,
                ]);
                $nuevoProceso->save();
                //GENERAR DIGITURNO SI PERFILAMIENTO Y PRUEBAS YA ESTAN LISTO
                if ($data->get("pruebas") == 1 && $data->get("perfilamiento") == 1) {
                    //REGISTRAR PROCESO DE PERFILAMIENTO
                    $ultimoTurno  = Recepcion::orderBy("turno")->first();
                    $ultimoTurno  = $ultimoTurno->turno + 1;
                    $nuevoProceso = new Recepcion();
                    $nuevoProceso->fill([
                        "candidato_id"         => $data->get("user_id"),
                        "turno"                => $ultimoTurno,
                        "estado"               => 0,
                        "proceso"              => "TURNO",
                        "USER_ENVIO"           => $this->user->id,
                        "motivo"               => $data->get("motivo"),
                        "numero_ficha"         => $data->get("numero_ficha"),
                        "documento_deja"       => $data->get("documento_deja"),
                        "pais_trabajo"         => $ciudad_trabajo[0],
                        "departamento_trabajo" => $ciudad_trabajo[1],
                        "ciudad_trabajo"       => $ciudad_trabajo[2],
                        "unidad"               => $data->get("unidad"),
                        "user_seleccion"       => $data->get("usuario_seleccion"),
                    ]);
                    $nuevoProceso->save();
                }
            }
            return redirect()->route("admin.recepcion")->with("mensaje_success", "El usuario ha iniciado un proceso.");
        }
    }

    public function registro_ingreso(Request $data)
    {

        if ($data->get("cd_recepcion") == 0) {

            if ($data->get("pruebas") == 1 && $data->get("perfilamiento") == 1) {
                //REGISTRAR CONTROL DE INGRESO
                $nuevoProceso = new Recepcion();
                $nuevoProceso->fill([
                    "candidato_id"   => $data->get("user_id"),
                    "estado"         => 0,
                    "proceso"        => "OTROS",
                    "USER_ENVIO"     => $this->user->id,
                    "motivo"         => $data->get("motivo"),
                    "numero_ficha"   => $data->get("numero_ficha"),
                    "documento_deja" => $data->get("documento_deja"),
                ]);
                $nuevoProceso->save();
                return response()->json(["success" => true, "mensaje" => "Se registro el control de ingreso correctamente."]);
            }
        } else {

            $turnoAsoc                   = Recepcion::find($data->get("id_control"));
            $turnoAsoc->estado           = 1;
            $turnoAsoc->user_terminacion = $this->user->id;
            $turnoAsoc->save();

            return response()->json(["success" => true, "mensaje" => "Se registro el control de salida correctamente."]);
        }

    }

    public function salida_proceso_recepcion(Request $data)
    {

        $turnoAsoc                   = Recepcion::find($data->get("id_control_b"));
        $turnoAsoc->estado           = 1;
        $turnoAsoc->user_terminacion = $this->user->id;
        $turnoAsoc->save();

        return response()->json(["success" => true, "mensaje" => "Se registro el control de salida del proceso correctamente."]);
    }

}
