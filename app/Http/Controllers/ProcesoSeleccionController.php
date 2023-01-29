<?php

namespace App\Http\Controllers;

use App\Facade\QueryAuditoria;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\CalificaCompetencia;
use App\Models\DatosBasicos;
use App\Models\EntrevistaCandidatos;
use App\Models\EntrevistaSeleccion;
use App\Models\GestionPrueba;
use App\Models\PerfilamientoCandidato;
use App\Models\Recepcion;
use App\Models\RegistroProceso;
use App\Models\ReqCandidato;
use App\Models\Requerimiento;
use App\Models\TipoFuentes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class ProcesoSeleccionController extends Controller
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

    public function detalle_pruebas(Request $data)
    {

        $pruebas = GestionPrueba::join("users", "users.id", "=", "gestion_pruebas.user_id")
            ->join("tipos_pruebas", "tipos_pruebas.id", "=", "gestion_pruebas.tipo_prueba_id")
            ->where("gestion_pruebas.candidato_id", $data->user_id)
        //->where("gestion_pruebas.user_id", $data->user_id)
            ->select("gestion_pruebas.*", "tipos_pruebas.descripcion as prueba_desc", "users.name")
            ->get();
        $fecha = date('Y-m-d');

        return view("admin.proceso_seleccion.modal.detalle_prueba", compact("pruebas", "fecha"));
    }

    public function turno(Request $data)
    {
        $turnos = Recepcion::where("proceso", "TURNO")->where("estado", 0)->select("id")->orderBy("turno", "asc")->get();

        return view("admin.proceso_seleccion.index", compact("turnos"));
    }

    public function refrescar_turno()
    {
        $turnos = Recepcion::where("proceso", "TURNO")->where("estado", 0)->select("id")->orderBy("turno", "asc")->get();

        return view("admin.proceso_seleccion.modal.turno", compact("turnos"));
    }

    public function gestionar_turno($turno = null)
    {

        if ($turno == null) {
            return redirect()->route("admin.proceso_seleccion")->with("mensaje_error", "No hay candidatos para gestionar.");
        }
        //ASOCIAR PSICOLOGO AL CANDIDATO DEL TURNO
        $turno_r = Recepcion::find($turno);
        if ($turno_r == null) {
            return redirect()->route("admin.proceso_seleccion")->with("mensaje_error", "No hay candidatos para gestionar.");
        }
        if ($turno_r->estado == 1 && $turno_r->user_terminacion != $this->user->id) {
            $turnos = Recepcion::where("proceso", "TURNO")->where("estado", 0)->select("id")->orderBy("turno", "asc")->get();
            if ($turno_r->count() <= 0) {
                return redirect()->route("admin.proceso_seleccion")->with("mensaje_error", "No hay candidatos para gestionar.");
            }
            $turno = $turnos->get(0)->id;
        }
        //ASOCIAR TURNO A PSICOLOGO

        $turnoAsoc                   = Recepcion::find($turno);
        $turnoAsoc->estado           = 3;
        $turnoAsoc->user_terminacion = $this->user->id;
        $turnoAsoc->save();

        $datos_basicos = DatosBasicos::where("user_id", $turnoAsoc->candidato_id)->first();

        //REQUERIMIENTOS SUGERENCIA CANDIDATOS
        $req_reclutadores_ids = PerfilamientoCandidato::where("tipo", "REQUERIMIENTO")->where("candidato_id", $turnoAsoc->candidato_id)->pluck("tabla_id")->toArray();

        //CARGOS PERFILADOS PARA EL CANDIDATO
        $cargos_candidato = PerfilamientoCandidato::where("tipo", "CARGO_GENERICO")->where("candidato_id", $turnoAsoc->candidato_id)->pluck("tabla_id")->toArray();

        //dd($req_reclutadores_ids);
        $req_reclutadores = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->whereIn("requerimientos.id", $req_reclutadores_ids)
            ->whereIn("cargos_genericos.id", $cargos_candidato)
            ->whereRaw(" ( requerimientos.req_prioritario != 1 or requerimientos.req_prioritario is null)")
            ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
            ->select("requerimientos.pais_id", "requerimientos.departamento_id", "requerimientos.ciudad_id", "requerimientos.id", "requerimientos.id as req_id", "clientes.nombre as nombre_cliente", "cargos_genericos.descripcion as desc_cargo")
            ->get();

        $req_prioritarios = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
            ->where("req_prioritario", 1)
            ->whereIn("cargos_genericos.id", $cargos_candidato)
            ->select("requerimientos.pais_id", "requerimientos.departamento_id", "requerimientos.ciudad_id", "requerimientos.id", "requerimientos.id as req_id", "clientes.nombre as nombre_cliente", "cargos_genericos.descripcion as desc_cargo")
            ->get();

        $req_sueridos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
            ->whereNotIn("requerimientos.id", $req_reclutadores_ids)
            ->whereIn("cargos_genericos.id", $cargos_candidato)
            ->whereRaw(" (requerimientos.req_prioritario is null or requerimientos.req_prioritario  = 0) ")
            ->select("requerimientos.pais_id", "requerimientos.departamento_id", "requerimientos.ciudad_id", "requerimientos.id", "requerimientos.id as req_id", "clientes.nombre as nombre_cliente", "cargos_genericos.descripcion as desc_cargo")
            ->get();

        $fuentes = ["" => "Seleccionar"] + TipoFuentes::orderBy("descripcion", "asc")->pluck("descripcion", "id")->toArray();

        return view("admin.proceso_seleccion.gestion_candidato", compact("datos_basicos", "req_reclutadores", "req_prioritarios", "req_sueridos", "turnoAsoc", "fuentes"));
    }

    public function liberar_turnos()
    {
        $recepcion = Recepcion::where();
    }

    public function guardar_entrevista_seleccion(Request $data, Requests\EntrevistaSeleccionRequest $validate)
    {
        //GUARDAR ENTREVISTA

        $nueva_entrevista = new EntrevistaCandidatos();
        $nueva_entrevista->fill($data->all() + ["user_gestion_id" => $this->user->id]);
        $nueva_entrevista->save();

        //GUARDAR VALORES D CALIFICACION DE COMPETENCIAS
        if ($data->has("competencia")) {
            $descripciones = $data->get("descripcion");
            foreach ($data->get("competencia") as $key => $value) {
                $calificacion = new CalificaCompetencia();
                $calificacion->fill([
                    "entidad_id"                => $nueva_entrevista->id,
                    "competencia_entrevista_id" => $key,
                    "valor"                     => $value,
                    "descripcion"               => $descripciones[$key],
                    "tipo_entidad"              => "MODULO_ENTREVISTA",
                ]);
                $calificacion->save();
            }
        }

        QueryAuditoria::observaciones("Se gestiona la entrevista y se agrega a un requerimiento.")
            ->guardar(new EntrevistaSeleccion(), ["usuario_id" => $this->user->id, "entrevista_id" => $nueva_entrevista->id] + $data->all());

        //AGREGAR EL CANDIDATO AL PROCESO
        $errores_array = [];
        $success       = true;
        $value         = $data->get("candidato_id");

        $datos = ReqCandidato::
            join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->whereRaw(" requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
            ->where("requerimiento_cantidato.candidato_id", $value)
            ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_ACTIVO'));

        if ($datos->count() > 0) {

            $req           = $datos->first();
            $datos_basicos = DatosBasicos::where("user_id", $value)->first();

            return redirect()->back()->with("mensaje_error", "EL candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> ya fue ingresado al requerimiento <strong>" . $req->requerimiento_id . "</strong>.");
        } else {

            //CAMBIA ESTADO AL CANDIDATO

            $candidato                       = DatosBasicos::where("user_id", $value)->first();
            $candidato->estado_reclutamiento = config('conf_aplicacion.C_RECLUTAMIENTO');
            $candidato->save();

            //ASOCIO EL CANDIDATO AL REQUERIMIENTO
            $nuevo_candidato_req = QueryAuditoria::observaciones("Se asocia el candidato a un requerimiento desde el modulo seleccion.")->guardar(new ReqCandidato(), ["estado_candidato" => 39, 'requerimiento_id' => $data->get("req_id"), 'candidato_id' => $value]);

            //CREO EL ESTADO DE INGRESO A REQUERIMIENTO
            $nuevo_proceso = new RegistroProceso();

            $nuevo_proceso->fill(
                [

                    'requerimiento_candidato_id' => $nuevo_candidato_req->id,
                    'estado'                     => 39,
                    'fecha_inicio'               => date("Y-m-d H:i:s"),
                    'usuario_envio'              => $this->user->id,
                    'requerimiento_id'           => $data->get("req_id"),
                    'candidato_id'               => $value,
                    'observaciones'              => "Ingreso al requerimiento",
                    'proceso'                    => "ASIGNADO_REQUERIMIENTO",
                ]
            );
            $nuevo_proceso->save();

            //EVENTO CAMBIA ESTADO REQUERIMIENTO
            $obj                   = new \stdClass();
            $obj->requerimiento_id = $data->get("requerimiento_id");
            $obj->user_id          = $this->user->id;
            $obj->estado           = 39;
            if (!in_array("<li>Se han agregado los candidatos con exito.</li>", $errores_array)) {
                array_push($errores_array, "<li>Se han agregado los candidatos con exito.</li>");
            }

            Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));
        }
        return redirect()->route("admin.proceso_seleccion")->with("mensaje_success", "El candidato fue asignado con exito.");
    }

    public function lista_req_proceso_seleccion(Request $data)
    {
        $turnoAsoc                   = Recepcion::find($data->get("turno_id"));
        $turnoAsoc->estado           = 1;
        $turnoAsoc->user_terminacion = $this->user->id;
        $turnoAsoc->save();

        $datos_basicos = DatosBasicos::where("user_id", $turnoAsoc->candidato_id)->first();

        //REQUERIMIENTOS SUGERENCIA CANDIDATOS
        $req_reclutadores_ids = PerfilamientoCandidato::where("tipo", "REQUERIMIENTO")->where("candidato_id", $turnoAsoc->candidato_id)->pluck("tabla_id")->toArray();

        //CARGOS PERFILADOS PARA EL CANDIDATO
        $cargos_candidato = PerfilamientoCandidato::where("tipo", "CARGO_GENERICO")->where("candidato_id", $turnoAsoc->candidato_id)->pluck("tabla_id")->toArray();

        //dd($req_reclutadores_ids);
        $req_reclutadores = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->whereIn("requerimientos.id", $req_reclutadores_ids)
            ->whereIn("cargos_genericos.id", $cargos_candidato)
            ->whereRaw(" ( requerimientos.req_prioritario != 1 or requerimientos.req_prioritario is null)")
            ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
            ->where(function ($where) use ($data) {
                if ($data->get("req") != "") {
                    $where->where("requerimientos.id", $data->get("req"));
                }
            })
            ->select("requerimientos.pais_id", "requerimientos.departamento_id", "requerimientos.ciudad_id", "requerimientos.id", "requerimientos.id as req_id", "clientes.nombre as nombre_cliente", "cargos_genericos.descripcion as desc_cargo")
            ->get();

        $req_prioritarios = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
            ->where("req_prioritario", 1)
            ->whereIn("cargos_genericos.id", $cargos_candidato)
            ->where(function ($where) use ($data) {
                if ($data->get("req") != "") {
                    $where->where("requerimientos.id", $data->get("req"));
                }
            })
            ->select("requerimientos.pais_id", "requerimientos.departamento_id", "requerimientos.ciudad_id", "requerimientos.id", "requerimientos.id as req_id", "clientes.nombre as nombre_cliente", "cargos_genericos.descripcion as desc_cargo")
            ->get();

        $req_sueridos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
            ->whereNotIn("requerimientos.id", $req_reclutadores_ids)
            ->whereIn("cargos_genericos.id", $cargos_candidato)
            ->whereRaw(" (requerimientos.req_prioritario is null or requerimientos.req_prioritario  = 0) ")
            ->where(function ($where) use ($data) {
                if ($data->get("req") != "") {
                    $where->where("requerimientos.id", $data->get("req"));
                }
            })
            ->select("requerimientos.pais_id", "requerimientos.departamento_id", "requerimientos.ciudad_id", "requerimientos.id", "requerimientos.id as req_id", "clientes.nombre as nombre_cliente", "cargos_genericos.descripcion as desc_cargo")
            ->get();

        return view("admin.proceso_seleccion.modal.requerimientos_proceso_seleccion", compact("req_reclutadores", "req_sueridos", "req_prioritarios"));
    }

}
