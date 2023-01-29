<?php

namespace App\Http\Controllers;

use App\Facade\QueryAuditoria;
use App\Http\Controllers\Controller;
use App\Models\CargoGenerico;
use App\Models\DatosBasicos;
use App\Models\Perfilamiento;
use App\Models\PerfilamientoCandidato;
use App\Models\Requerimiento;
use App\Models\TipoCargo;
use App\Jobs\FuncionesGlobales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerfilamientoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu=DB::table("menu_candidato")->where("estado",1)->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();

        $tipo_cargos              = TipoCargo::where("active", 1)->get();
        $sql_cargos_seleccionados = Perfilamiento::join("cargos_genericos", "cargos_genericos.id", "=", "perfilamiento.cargo_generico_id")
            ->join("tipos_cargos", "tipos_cargos.id", "=", "cargos_genericos.tipo_cargo_id")
            ->where("perfilamiento.user_id", $this->user->id)
            ->select("tipos_cargos.descripcion as tipo_cargo_name", "tipos_cargos.id as cargo_id", "cargos_genericos.*")->get();
        $cargos_seleccionados = [];
        $items_cargos         = [];
        foreach ($sql_cargos_seleccionados as $key => $value) {
            if (!array_key_exists($value->cargo_id, $cargos_seleccionados)) {
                $cargos_seleccionados[$value->cargo_id]         = [];
                $cargos_seleccionados[$value->cargo_id]["name"] = $value->tipo_cargo_name;

                $cargos_seleccionados[$value->cargo_id]["item"] = [];
            }
            array_push($items_cargos, $value->id);

            $cargos_seleccionados[$value->cargo_id]["item"][$value->id] = $value->descripcion;
        }
        //dd($cargos_seleccionados);
        return view("cv.perfilamiento", compact("tipo_cargos", "cargos_seleccionados", "items_cargos","menu"));
    }

    public function guardar_perfilamiento(Request $data)
    {
        $items                              = Perfilamiento::where("user_id", $this->user->id)->delete();
        $datos_basicos                      = DatosBasicos::where("user_id", $this->user->id)->first();
        $datos_basicos->perfilamiento_count = 0;
        $datos_basicos->save();
        if ($data->has("cargo_generico_id")) {
            //actualizando categorias
            foreach ($data->get("cargo_generico_id") as $key => $value) {
                $new                    = new Perfilamiento();
                $new->user_id           = $this->user->id;
                $new->cargo_generico_id = $value;
                $new->save();
            }
            $datos_basicos->perfilamiento_count = 100;
            $datos_basicos->save();
        }

        if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
         FuncionesGlobales::cambio_procesado($this->user->id);

        }

        return redirect()->route("perfilamiento")->with("mesaje_success", "Tu perfil se ha ajustado correctamente.");
    }

    public function busqueda_pefilamiento(Request $data)
    {

        $sqlCargos = TipoCargo::join("cargos_genericos", "cargos_genericos.tipo_cargo_id", "=", "tipos_cargos.id")
            ->select("cargos_genericos.*", "tipos_cargos.id as tipo_id", "tipos_cargos.descripcion as tipo_name")
            ->whereRaw("lower(cargos_genericos.descripcion) like '%" . strtolower($data->get("txt-buscador-cargos")) . "%'")
            ->get();

        $arrayEncontrados = [];
        foreach($sqlCargos as $key => $value) {
          
          if(!array_key_exists($value->tipo_id, $arrayEncontrados)){
            $arrayEncontrados[$value->tipo_id]["name"]  = $value->tipo_name;
            $arrayEncontrados[$value->tipo_id]["items"] = [];
          }
          
          array_push($arrayEncontrados[$value->tipo_id]["items"], $value);
        }

        $sql_cargos_seleccionados = Perfilamiento::join("cargos_genericos", "cargos_genericos.id", "=", "perfilamiento.cargo_generico_id")
            ->join("tipos_cargos", "tipos_cargos.id", "=", "cargos_genericos.tipo_cargo_id")
            ->where("perfilamiento.user_id", $this->user->id)
            ->select("tipos_cargos.descripcion as tipo_cargo_name", "tipos_cargos.id as cargo_id", "cargos_genericos.*")->get();

        $items_cargos = [];
        foreach ($sql_cargos_seleccionados as $key => $value) {

            array_push($items_cargos, $value->id);
        }
        return view("cv.modal.fr_cargos_perfilamiento", compact("arrayEncontrados", "items_cargos"));
    }

    public function perfilar_candidato(Request $data)
    {
        $candidato = null;
        if ($data->get("numero_id") != "") {

            $candidato = DatosBasicos::where("numero_id", $data->get("numero_id"))->first();
            if ($candidato == null) {
                $candidato                       = new \stdClass();
                $candidato->numero_id            = $data->get("numero_id");
                $candidato->user_id              = 0;
                $candidato->estado_reclutamiento = "";
            }
            //dd($candidato);

            $cargos = ["" => "Seleccionar"] + CargoGenerico::orderBy("descripcion", "ASC")->pluck("descripcion", "id")->toArray();

            $cargos_seleccionados         = PerfilamientoCandidato::where("candidato_id", $candidato->user_id)->where("tipo", "CARGO_GENERICO")->get();
            $requerimientos_seleccionados = PerfilamientoCandidato::where("candidato_id", $candidato->user_id)->where("tipo", "REQUERIMIENTO")->get();

            $requerimientos_seleccionados_a = [];
            $cargos_seleccionados_a         = [];
            foreach ($requerimientos_seleccionados as $key => $value) {
                array_push($requerimientos_seleccionados_a, $value->tabla_id);
            }
            foreach ($cargos_seleccionados as $key => $value) {
                array_push($cargos_seleccionados_a, $value->tabla_id);
            }

            $cargos_genericos = CargoGenerico::where("estado", 1)->select("*")->get();
            //dd($cargos_genericos);

            $requerimientos = Requerimiento::whereIn("cargo_generico_id", $cargos_seleccionados_a)
                ->whereNotIn("id", $requerimientos_seleccionados_a)->paginate(10);

            $requerimientos_priorizados = Requerimiento::where("req_prioritario", 1)->get();
            //dd($requerimientos_priorizados);
        }

        return view("admin.perfilamiento.index", compact("candidato", "cargos", "cargos_seleccionados", "requerimientos_seleccionados", "requerimientos", "cargos_genericos", "requerimientos_priorizados"));
    }

    public function cargar_requerimientos_perfil(Request $data)
    {
        //dd($data->get("cargos_genericos"));
        //dd($data->all());
        $requerimientos = Requerimiento::where(function ($sql) use ($data) {
            if ($data->get("cargos_genericos") != "") {
                $sql->whereIn("cargo_generico_id", $data->get("cargos_genericos"));
            }
            if ($data->get("requerimiento_id") != "") {
                $sql->where("id", $data->get("requerimiento_id"));
            }
        })->whereNotIn("id", $data->get("requerimientos_sugeridos", []))->paginate(10);
        return view("admin.perfilamiento.modal.tabla_requerimientos", compact("requerimientos"));
    }

    public function guardar_perfilamiento_reclutamiento(Request $data)
    {
        //dd($data->all());
        $datos_user        = DatosBasicos::where("numero_id", $data->get("numero_id"))->first();
        $cargos_genericos  = $data->get("cargos_genericos");
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

        return redirect()->route("admin.perfilamiento")->with("mensaje_success", "El candidato se ha perfilado.");
    }

    public function autocomplete_cargos(Request $data)
    {
        $q   = $data->get("query");
        $res = CargoGenerico::select("id", "descripcion as value")
            ->where(function ($sql) use ($q) {
                if ($q != "") {
                    $sql->whereRaw("LOWER(descripcion) like '" . strtolower($q) . "%'");
                }
            })
            //->where("estado", 1)
            ->orderBy("descripcion", "asc")
            ->take(5)
            ->get()
            ->toArray();
        return response()->json(["suggestions" => $res]);
    }

    public function select_pefilamiento(Request $data)
    {
       // dd($data->get("txt-buscador-cargos"));
        $sqlCargos = TipoCargo::join("cargos_genericos", "cargos_genericos.tipo_cargo_id", "=", "tipos_cargos.id")
            ->select("cargos_genericos.*", "tipos_cargos.id as tipo_id", "tipos_cargos.descripcion as tipo_name")
            ->where("cargos_genericos.tipo_cargo_id",$data->get("txt-buscador-cargos"))
            ->orderBy('cargos_genericos.descripcion')
            //->whereRaw("lower(tipos_cargos.descripcion) like '" .trim(strtolower($data->get("txt-buscador-cargos"))). "'")
            ->get();

        $arrayEncontrados = [];
        foreach($sqlCargos as $key => $value) {
          
          if(!array_key_exists($value->tipo_id, $arrayEncontrados)){
            $arrayEncontrados[$value->tipo_id]["name"]  = $value->tipo_name;
            $arrayEncontrados[$value->tipo_id]["items"] = [];
          }
          
          array_push($arrayEncontrados[$value->tipo_id]["items"], $value);
        }

        $sql_cargos_seleccionados = Perfilamiento::join("cargos_genericos", "cargos_genericos.id", "=", "perfilamiento.cargo_generico_id")
            ->join("tipos_cargos", "tipos_cargos.id", "=", "cargos_genericos.tipo_cargo_id")
            ->where("perfilamiento.user_id", $this->user->id)
            ->select("tipos_cargos.descripcion as tipo_cargo_name", "tipos_cargos.id as cargo_id", "cargos_genericos.*")->get();

        $items_cargos = [];
        foreach($sql_cargos_seleccionados as $key => $value){
          array_push($items_cargos, $value->id);
        }

        return view("cv.modal.selec_cargos_perfilamiento", compact("arrayEncontrados", "items_cargos"));
    }
     

}
