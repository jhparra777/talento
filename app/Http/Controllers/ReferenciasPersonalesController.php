<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\DatosBasicos;
use App\Models\Pais;
use App\Models\ReferenciasPersonales;
use App\Models\TipoRelacion;
use App\Jobs\FuncionesGlobales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReferenciasPersonalesController extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = DB::table("menu_candidato")->where("estado", 1)->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();

        $tipoRelaciones = ["" => "Seleccionar"] + TipoRelacion::orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();

        $referencias = ReferenciasPersonales::join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
            ->join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->select("referencias_personales.*", "tipo_relaciones.descripcion as relacion",
            \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"))
        ->where("referencias_personales.user_id", $this->user->id)
        ->get();

        return view("cv.referencias_personales", compact("tipoRelaciones", "referencias","menu"));
    }

    public function guardar_referencia(Request $data, Requests\ReferenciasNuevoRequest $validator)
    {
        // dd($data->all());
        $datos_basicos                    = DatosBasicos::where("user_id", $this->user->id)->first();
        $datos_basicos->referencias_count = 100;
        $datos_basicos->save();

        $referencia          = new ReferenciasPersonales();
        $campos              = $data->all();
        $campos["user_id"]   = $this->user->id;
        $campos["numero_id"] = $this->user->getCedula()->numero_id;
        $referencia->fill($campos);
        
        if(route('home') == "https://gpc.t3rsc.co"){
         $referencia->empresa = $data->empresa;
         $referencia->correo = $data->correo;
         $referencia->cargo = $data->cargo;
        }
        
        $referencia->save();
        $tipoRelaciones = ["" => "Seleccionar"] + TipoRelacion::pluck("descripcion", "id")->toArray();
        $campos         = [];
        $relacionTipo   = TipoRelacion::find($data->get("tipo_relacion_id"));
        $ciudad         = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"))
            ->where("ciudad.cod_pais", $referencia->codigo_pais)
            ->where("ciudad.cod_departamento", $referencia->codigo_departamento)
            ->where("ciudad.cod_ciudad", $referencia->codigo_ciudad)->first();
        $mensaje = "Se ha guardado la referencia sin errores";

         //para cambiar el procesado en los candidatos************************
         FuncionesGlobales::cambio_procesado($this->user->id);

        return response()->json(["mensaje_success" => $mensaje, "ciudad" => $ciudad, "referencia" => $referencia, "relacionTipo" => $relacionTipo, "success" => true]);
    }

    public function editar_referencia(Request $data)
    {

        $campos = ReferenciasPersonales::join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->select("referencias_personales.*", \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_autocomplete"))
            ->where("referencias_personales.id", $data->get("id"))->first();
        //dd($campos);
        $tipoRelaciones = ["" => "Seleccionar"] + TipoRelacion::pluck("descripcion", "id")->toArray();
        $editar         = true;

        $ciudad = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $campos->codigo_pais)
            ->where("ciudad.cod_departamento", $campos->codigo_departamento)
            ->where("ciudad.cod_ciudad", $campos->codigo_ciudad)->first();
        //dd($ciudad)
        // $id_pais
        //$id_depar
        $txtCiudad = "";
        if($ciudad != null) {
          $txtCiudad = $ciudad->value;
        }

        return response()->json(["data" => $campos, "ciudad" => $txtCiudad]);
    }

    public function cancelar_referencia(Request $data)
    {
        $tipoRelaciones = ["" => "Seleccionar"] + TipoRelacion::pluck("descripcion", "id")->toArray();
        $campos         = [];
        return response()->json(["success" => true, "view" => view("cv.fr_referencias_personales", compact("tipoRelaciones", "campos"))->render()]);
    }

    public function actualizar_referencia(Request $data)
    {
        //dd($data->all());
        $referencia = ReferenciasPersonales::find($data->get("id"));
        $referencia->fill($data->except('id'));
        if(route('home') == "https://gpc.t3rsc.co"){
         $referencia->empresa = $data->empresa;
         $referencia->correo = $data->correo;
        }
        $referencia->save();
        $relacionTipo = TipoRelacion::find($data->get("tipo_relacion_id"));
        $ciudad       = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"))
            ->where("ciudad.cod_pais", $referencia->codigo_pais)
            ->where("ciudad.cod_departamento", $referencia->codigo_departamento)
            ->where("ciudad.cod_ciudad", $referencia->codigo_ciudad)->first();
        $mensaje        = "Se ha actualizado la referencia sin errores";
        $tipoRelaciones = ["" => "Seleccionar"] + TipoRelacion::pluck("descripcion", "id")->toArray();
        $campos         = [];

         //para cambiar el procesado en los candidatos************************
         FuncionesGlobales::cambio_procesado($this->user->id);

        return response()->json(["referencia" => $referencia, "ciudad" => $ciudad, "relacionTipo" => $relacionTipo, "tipoRelaciones" => $tipoRelaciones, "campos" => $campos]);

    }

    public function eliminar_referencia(Request $data)
    {
        $referencia = ReferenciasPersonales::find($data->get("id"));
        $referencia->delete();

        $count_referencia = ReferenciasPersonales::
            where("user_id", $this->user->id)
            ->count();

        if ($count_referencia < 1) {
            $datos_basicos                    = DatosBasicos::where("user_id", $this->user->id)->first();
            $datos_basicos->referencias_count = 0;
            $datos_basicos->save();
        }

         //para cambiar el procesado en los candidatos************************
         FuncionesGlobales::cambio_procesado($this->user->id);

        return response()->json(["id" => $data->get("id")]);
    }

}
