<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\AspiracionSalarial;
use App\Models\CargoGenerico;
use App\Models\DatosBasicos;
use App\Models\Experiencias;
use App\Models\MotivoRetiro;
use App\Models\Pais;
use App\Models\Profesiones;
use App\Jobs\FuncionesGlobales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExperienciasController extends Controller
{
    protected $user          = null;
    protected $motivos       = ["" => "Seleccionar"];
    protected $cargoGenerico = ["" => "Seleccionar"];
    protected $profesion     = ["" => "Seleccionar"];

    public function __construct()
    {
        parent::__construct();

        if (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") {
            $this->motivos = ["" => "Seleccionar"] + MotivoRetiro::where("active", "1")->orderBy(DB::raw("UPPER(descripcion)"))->pluck("descripcion", "id")->except("id", 5)->toArray();            
            $this->cargoGenerico = ["" => "Seleccionar"] + CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();
            $this->profesion += Profesiones::where("active", 1)->pluck("descripcion", "id")->toArray();
        }else{
            $this->motivos = ["" => "Seleccionar"] + MotivoRetiro::where("active", "1")->orderBy(DB::raw("UPPER(descripcion)"))->pluck("descripcion", "id")->toArray();
            $this->cargoGenerico = ["" => "Seleccionar"] + CargoGenerico::where("estado", "1")->orderBy(DB::raw("UPPER(descripcion)"))->pluck("descripcion", "id")->toArray();
            $this->profesion += Profesiones::where("active", 1)->pluck("descripcion", "id")->toArray();
        }

    }

    public function index()
    {
         $menu=DB::table("menu_candidato")->where("estado",1)->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();

        $experiencias = Experiencias::where("user_id", $this->user->id)->get();
        $motivos      = $this->motivos;

        $datos_basicos = DatosBasicos::where('user_id', $this->user->id)->first();

        if (route("home") == "http://gpc.t3rsc.co" || route("home") == "http://localhost:8000") {
            $cargoGenerico  = ["" => "Seleccionar"] + CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();
        }else{
            $cargoGenerico  = $this->cargoGenerico;
        }

        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();

        return view("cv.experiencias", compact("datos_basicos", "experiencias", "motivos", "cargoGenerico", "aspiracionSalarial","menu"));
    }

    public function guardar_experiencia(Request $data, Requests\ExperienciaNuevoRequest $valida)
    {
        $datos_basicos = DatosBasicos::where("user_id", $this->user->id)->first();
  
        if(isset($data->tiene_experiencia)){
            /*borramos la experiencia registradas por si tiene*/
            Experiencias::where('user_id', $this->user->id)->delete();
            $datos_basicos->tiene_experiencia = 0;
            $datos_basicos->experiencias_count = 100;
            $datos_basicos->save();

            return response()->json(["success" => true, "rs" => false]);
        }else{
            $datos_basicos->tiene_experiencia = 1;
            $datos_basicos->experiencias_count = 100;
            $datos_basicos->save();

            $nuevaExperiencia = new Experiencias();
            $campos           = $data->all();

            if(!$data->has("empleo_actual")){
                $campos["empleo_actual"] = "2";
            }
            
            if(!$data->has("trabajo_temporal")) {
                $campos["trabajo_temporal"] = "0";
            }
            
            if(!$data->has("autoriza_solicitar_referencias")) {
                $campos["autoriza_solicitar_referencias"] = "0";
            }

            if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
                unset($campos["fecha_inicio"],$campos["fecha_final"]);

                $nuevaExperiencia->fecha_inicio = "01-".$data["fecha_inicio"];
                $nuevaExperiencia->fecha_final = "01-".$data["fecha_final"];
            }

            $nuevaExperiencia->fill($campos + ["user_id" => $this->user->id, "numero_id" => $this->user->getCedula()->numero_id]);
        
            if(route("home") == "https://gpc.t3rsc.co"){
                $nuevaExperiencia->linea_negocio = $data->linea_negocio;
                $nuevaExperiencia->tipo_compania = $data->tipo_compania;
                $nuevaExperiencia->ventas_empresa = $data->ventas_empresa;
                $nuevaExperiencia->num_colaboradores = $data->num_colaboradores;
               // $nuevaExperiencia->otro_cargo = $data->otro_cargo;
                $nuevaExperiencia->logros = $data->logros;
                //$nuevaExperiencia->tiempo_cargo = $data->tiempo_cargo;
                $nuevaExperiencia->le_reportan = $data->le_reportan;

                if($campos["empleo_actual"] == "1") {
                  
                  $nuevaExperiencia->sueldo_fijo_bruto      = $data->sueldo_fijo_bruto;
                  $nuevaExperiencia->ingreso_varial_mensual = $data->ingreso_varial_mensual;
                  $nuevaExperiencia->otros_bonos            = $data->otros_bonos;
                  $nuevaExperiencia->total_ingreso_anual    = $data->total_ingreso_anual;
                  $nuevaExperiencia->total_ingreso_mensual  = $data->total_ingreso_mensual;
                  $nuevaExperiencia->utilidades             = $data->utilidades;
                  $nuevaExperiencia->valor_actual_fondos    = $data->valor_actual_fondos;
                  $nuevaExperiencia->beneficios_monetario   = $data->beneficios_monetario;
                  $nuevaExperiencia->fecha_final = $data->fecha_inicio;
                }
            }
        
            $nuevaExperiencia->save();

            $experiencia2 = $nuevaExperiencia;
            $txtCiudad      = "";
            $mesaje_success = "OK! sin errores.";
            $motivos        = $this->motivos;

            $cargoGenerico      = $this->cargoGenerico;
            $txtProfesion       = "";
            $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();

            if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
              FuncionesGlobales::cambio_procesado($this->user->id);
            }

            return response()->json(["mensaje_success" => $mesaje_success, "success" => true, "rs" => $experiencia2]);
        }
    }

    public function editar_experiencia(Request $data)
    {
        $experiencia = Experiencias::find($data->get("id"));

        $ciudad      = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $experiencia->pais_id)
            ->where("ciudad.cod_departamento", $experiencia->departamento_id)
            ->where("ciudad.cod_ciudad", $experiencia->ciudad_id)->first();

        $txtCiudad = "";

        if ($ciudad != null) {
            $txtCiudad = $ciudad->value;
        }

        //Consulta para mostrar el nombre del cargo
        $cargo = Experiencias::join("profesiones", function ($join3) {
            $join3->on("experiencias.cargo_desempenado", "=", "profesiones.id");
        })
        ->select("profesiones.descripcion AS nombre_cargo")
        ->where("profesiones.id", $experiencia->cargo_desempenado)->first();

        $txtCargo = "";
        if($cargo != null) {
          $txtCargo = $cargo->nombre_cargo;
        }

        $editar             = true;
        $motivos            = $this->motivos;
        $cargoGenerico      = $this->cargoGenerico;

        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();

        return response()->json(["data" => $experiencia, "ciudad" => $txtCiudad, "cargo" => $txtCargo]);
    }

    public function actualizar_experiencia(Request $data, Requests\ExperienciaRequest $valida)
    {
        $experiencia = Experiencias::find($data->get("id"));
        $campos      = $data->except('id');

        if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
            unset($campos["fecha_inicio"],$campos["fecha_final"]);

            $experiencia->fecha_inicio = "01-".$data["fecha_inicio"];
            $experiencia->fecha_final = "01-".$data["fecha_final"];
        }

        if (!$data->has("empleo_actual")) {
            $campos["empleo_actual"] = "0";
        }

        if (!$data->has("trabajo_temporal")) {
            $campos["trabajo_temporal"] = "0";
        }

        if (!$data->has("autoriza_solicitar_referencias")) {
            $campos["autoriza_solicitar_referencias"] = "0";
        }

        $experiencia->fill($campos + ["numero_id" => $this->user->getCedula()->numero_id]);

        if(route("home") == "https://gpc.t3rsc.co"){
            $experiencia->linea_negocio = $data->linea_negocio; 
            $experiencia->tipo_compania = $data->tipo_compania; 
            $experiencia->ventas_empresa = $data->ventas_empresa; 
            $experiencia->num_colaboradores = $data->num_colaboradores; 
            $experiencia->otro_cargo = $data->otro_cargo; 
            $experiencia->logros = $data->logros;
            $experiencia->le_reportan = $data->le_reportan;
        }

        $experiencia->save();
        $experiencia2 = $experiencia;

        //$experiencia  = new Experiencias();

        $txtCiudad          = "";
        $mesaje_success     = "Se han actualizado los datos correctamente.";
        $motivos            = $this->motivos;
        $cargoGenerico      = $this->cargoGenerico;
        $txtProfesion       = "";
        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();

        if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
            FuncionesGlobales::cambio_procesado($this->user->id);
        }

        return response()->json(["mensaje_success" => $mesaje_success, "success" => true, "rs" => $experiencia2]);
    }

    public function eliminar_experiencia(Request $data)
    {
        $experiencia = Experiencias::find($data->get("id"));
        $experiencia->delete();

        $count_estudios = Experiencias::
            where("user_id", $this->user->id)
            ->count();

        if ($count_estudios < 1) {
            $datos_basicos = DatosBasicos::
                where("user_id", $this->user->id)
                ->first();

            $datos_basicos->experiencias_count = 0;
            $datos_basicos->save();
        }

        if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
         FuncionesGlobales::cambio_procesado($this->user->id);
        }
        
       return response()->json(["id" => $data->get("id")]);
    }

    public function cancelar_experiencia()
    {
        $txtCiudad          = "";
        $experiencia        = new Experiencias();
        $motivos            = $this->motivos;
        $cargoGenerico      = $this->cargoGenerico;
        $txtProfesion       = "";
        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();

        return view("cv.modal.fr_experiencias", compact(
            "experiencia",
            "txtCiudad",
            "motivos",
            "cargoGenerico",
            "aspiracionSalarial",
            "txtProfesion"
        ));
    }

    public function autocomplete_cargo_desempenado(Request $data)
    {
        $q = $data->get("query");
        $res = Profesiones::select("id", DB::raw("trim(descripcion) as value"))
            ->where(function ($sql) use ($q) {
                if($q != "") {
                  $sql->whereRaw("LOWER(trim(descripcion)) like '%" . strtolower($q) . "%'");
                }
            })->where("active", 1)
            ->orderBy("descripcion", "asc")
            ->take(5)
            ->get()
            ->toArray();

        return response()->json(["suggestions" => $res]);
    }

}
