<?php

namespace App\Http\Controllers;

use App\Models\Pais;
use App\Http\Requests;
use App\Models\Estudios;
use App\Models\DatosBasicos;
use Illuminate\Http\Request;
use App\Models\NivelEstudios;
use App\Jobs\FuncionesGlobales;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EstudiosController extends Controller
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
        $menu=DB::table("menu_candidato")->where("estado",1)->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();

       $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.*", "niveles_estudios.descripcion as descripcion_nivel")->
            where("user_id", $this->user->id)->get();

       $nivelEstudios = ["" => "Seleccionar"] + NivelEstudios::where("active",1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();

       $periodicidad=[""=>"Seleccionar"]+DB::table("periodicidad")->orderBy(DB::raw("UPPER(descripcion)"),"ASC")
        ->pluck("descripcion","id")->toArray();
        

       $datos_basicos = DatosBasicos::where('user_id', $this->user->id)->first();

       $ciudad_estudio = "";

      return view("cv.estudios", compact("datos_basicos", "nivelEstudios", "estudios", "ciudad_estudio","menu","periodicidad"));
    }

    public function guardar_estudios(Request $data, Requests\EstudiosNuevoRequest $valida)
    {

        $datos_basicos  = DatosBasicos::where("user_id", $this->user->id)->first();
        //tiene estudio en realidad es no tiene
        if(isset($data->tiene_estudio)){
            /*borramos los estudios registrados por si tiene*/
            Estudios::where('user_id', $this->user->id)->delete();

            $datos_basicos->tiene_estudio = 0;
            $datos_basicos->estudios_count = 100;
            $datos_basicos->save();

            return response()->json(["success" => true, "rs" => false]);

        }else{

            $estudios = new Estudios();

            $estudios->fill($data->except('id') + [
              "user_id" => $this->user->id, "numero_id" => $this->user->getCedula()->numero_id
            ]);
            
            //$estudios->fecha_finalizacion=$data->get("fecha_finalizacion");
            $estudios->save();

            $datos_basicos->tiene_estudio = 1;
            $datos_basicos->estudios_count = 100;
            $datos_basicos->save();

            $campos        = [];
            $nivelEstudios = ["" => "Seleccionar"] + NivelEstudios::pluck("descripcion", "id")->toArray();

            $estudio  = Estudios::leftjoin("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
                                    ->where('estudios.id',$estudios->id)
                                    ->select('estudios.*','niveles_estudios.descripcion as descripcion_nivel')
                                    ->first();

            $campos   = Estudios::where("id", $estudios->id)->first();
            
            $lugar_estudio = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
                ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
                ->where("ciudad.cod_pais", $campos->pais_estudio)
                ->where("ciudad.cod_departamento", $campos->departamento_estudio)
                ->where("ciudad.cod_ciudad", $campos->ciudad_estudio)
                ->first();
            //dd($lugarexpedicion);
            $ciudad_estudio = "";

            if($lugar_estudio != null) {
              $ciudad_estudio = $lugar_estudio->value;
            }
            $mensaje = "Se guardo el registro sin errores.";


            return response()->json(["mensaje_success" => $mensaje, "success" => true, "estudio" => $estudio, "rs" => $estudio]);
        }
    }

    public function editar_estudio(Request $data)
    {

        $nivelEstudios = ["" => "Seleccionar"] + NivelEstudios::pluck("descripcion", "id")->toArray();

        $campos = Estudios::where("id", $data->get("id"))->first();
        //dd($campos);

        $lugar_estudio = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $campos->pais_estudio)
            ->where("ciudad.cod_departamento", $campos->departamento_estudio)
            ->where("ciudad.cod_ciudad", $campos->ciudad_estudio)->first();
        //dd($lugarexpedicion);

        $ciudad_estudios = "";

         if($lugar_estudio != null){
          $ciudad_estudios = $lugar_estudio->value;
         }

        $editar = true;
        return response()->json(["success" => true, "nivelEstudios" => $nivelEstudios, "data" => $campos, "ciudad_estudios" => $ciudad_estudios]);
    }

    public function actualizar_estudios(Request $data)
    {
        $estudios = Estudios::find($data->get("id"));
        $campos   = $data->except('id');

        $estudios->fill($campos);

         if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){

          $estudios->fecha_finalizacion = "01-".$data["fecha_finalizacion"];
         }

        if(route("home") == "https://gpc.t3rsc.co"){

         $estudios->institucion = $data["universidades_autocomplete"];
        }
        
        $estudios->save();

        $nivelEstudios  = ["" => "Seleccionar"] + NivelEstudios::pluck("descripcion", "id")->toArray();
        $campos         = [];
        $estudio        = Estudios::find($data->get("id"));
        $nivel1         = NivelEstudios::find($estudio->nivel_estudio_id);
        $ciudad_estudio = "";
        $mensaje        = "Se ha actualizado el registro sin errores.";

         //para cambiar el procesado en los candidatos************************
        if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
         FuncionesGlobales::cambio_procesado($this->user->id);

        }

        return response()->json(["mensaje_success" => $mensaje, "nivelEstudios" => $nivel1, "estudios" => $estudio, "success" => true]);
    }

    public function eliminar_estudio(Request $data)
    {

        $eliminar = Estudios::find($data->get("id"));
        $eliminar->delete();

        $count_estudios = Estudios::
            where("user_id", $this->user->id)
            ->count();

        if ($count_estudios < 1) {
            $datos_basicos = DatosBasicos::
                where("user_id", $this->user->id)
                ->first();

            $datos_basicos->estudios_count = 0;
            $datos_basicos->save();
        }

         //para cambiar el procesado en los candidatos************************
         if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
          FuncionesGlobales::cambio_procesado($this->user->id);
         }

        return response()->json(["id" => $data->get("id")]);
    }

    public function cancelar_estudio()
    {
        $campos        = [];
        $nivelEstudios = ["" => "Seleccionar"] + NivelEstudios::pluck("descripcion", "id")->toArray();

        $ciudad_estudio = "";

        $mensaje = "Se guardo el registro sin errores.";
        return view("cv.modal.fr_estudios", compact("campos", "nivelEstudios", "ciudad_estudio"));
    }

}
