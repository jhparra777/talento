<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\DatosBasicos;
use App\Models\Escolaridad;
use App\Models\Genero;
use App\Models\GrupoFamilia;
use App\Models\Parentesco;
use App\Models\TipoDocumento;
use App\Models\TipoIdentificacion;
use App\Models\DocumentoFamiliar;
use App\Jobs\FuncionesGlobales;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrupoFamiliarController extends Controller
{   
    protected $user       = null;
    public $tipoDocumento = ["" => "Seleccionar"];
    public $escolaridad   = ["" => "Seleccionar"];
    public $parentesco    = ["" => "Seleccionar"];
    public $genero        = ["" => "Seleccionar"];
    public $profesion     = ["" => "Seleccionar"];

    public function __construct()
    {
        parent::__construct();

        $this->tipoDocumento += TipoIdentificacion::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();
        $this->escolaridad += Escolaridad::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();
        $this->parentesco += Parentesco::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();
        $this->genero += Genero::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();
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
        $selectores = $this;

        if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co" || route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co" || route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co" || route('home') == "http://localhost:8000"){

            $familiares = GrupoFamilia::leftjoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftjoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftjoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select("grupos_familiares.*", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "grupos_familiares.profesion_id as profesion")
            ->where("grupos_familiares.user_id", $this->user->id)
            ->get();

        }else{

          $familiares = GrupoFamilia::leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "grupos_familiares.tipo_documento")
            ->leftjoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftjoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftjoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select("grupos_familiares.*", "tipo_identificacion.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "grupos_familiares.profesion_id as profesion")
            ->where("grupos_familiares.user_id", $this->user->id)
            ->get();
        }

      return view("cv.grupo_familiar", compact("selectores", "familiares","menu"));
    }

    public function guardar_familia(Request $data, Requests\GrupoFamiliarNuevoRequest $valida)
    {

       $datos_basicos = DatosBasicos::where("user_id", $this->user->id)->first();
       $datos_basicos->grupo_familiar_count = 100;
       $datos_basicos->save();

       $nuevo_familia = new GrupoFamilia();
        
       $nuevo_familia->fill($data->all() + ["user_id" => $this->user->id, "numero_id" => $this->user->getCedula()->numero_id]);
        
        if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
          $nuevo_familia->fecha_nacimiento = "01-".$data["fecha_nacimiento"];
        }

        if(route('home') == "https://gpc.t3rsc.co" || route('home') == "http://gpc.t3rsc.co"){
         $nuevo_familia->ocupacion = $data->ocupacion;
        }

        $nuevo_familia->save();
        $selectores = $this;

        if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co" || route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co" || route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co"|| route('home') == "https://gpc.t3rsc.co" || route('home') == "http://localhost:8000"){
            
            $registro = GrupoFamilia:://join("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            join("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftjoin("generos", "generos.id", "=", "grupos_familiares.genero")
            // ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.id",
                'grupos_familiares.numero_id',
                'grupos_familiares.user_id',
                'grupos_familiares.documento_identidad',
                'grupos_familiares.codigo_departamento_expedicion',
                'grupos_familiares.codigo_ciudad_expedicion',
                'grupos_familiares.nombres',
                'grupos_familiares.primer_apellido',
                'grupos_familiares.segundo_apellido',
                'grupos_familiares.escolaridad_id',
                'grupos_familiares.parentesco_id',
                'grupos_familiares.fecha_nacimiento',
                'grupos_familiares.codigo_departamento_nacimiento',
                'grupos_familiares.codigo_ciudad_nacimiento',
                'grupos_familiares.profesion_id',
                'grupos_familiares.active',
                'grupos_familiares.created_at',
                'grupos_familiares.updated_at',
                'grupos_familiares.codigo_pais_expedicion',
                'grupos_familiares.codigo_pais_nacimiento',
               // "escolaridades.descripcion as escolaridad",
                "parentescos.descripcion as parentesco",
                "generos.descripcion as genero")
                //"profesiones.descripcion as profesion")
            ->where("grupos_familiares.id", $nuevo_familia->id)
            ->first();

        }else{

            $registro = GrupoFamilia::leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "grupos_familiares.tipo_documento")
            ->leftjoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->join("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.id",'grupos_familiares.numero_id',
                'grupos_familiares.user_id','grupos_familiares.documento_identidad',
                'grupos_familiares.codigo_departamento_expedicion',
                'grupos_familiares.codigo_ciudad_expedicion',
                'grupos_familiares.nombres',
                'grupos_familiares.primer_apellido',
                'grupos_familiares.segundo_apellido',
                'grupos_familiares.escolaridad_id',
                'grupos_familiares.parentesco_id',
                'grupos_familiares.fecha_nacimiento',
                'grupos_familiares.codigo_departamento_nacimiento',
                'grupos_familiares.codigo_ciudad_nacimiento',
                'grupos_familiares.profesion_id',
                'grupos_familiares.active',
                'grupos_familiares.created_at',
                'grupos_familiares.updated_at',
                'grupos_familiares.codigo_pais_expedicion',
                'grupos_familiares.codigo_pais_nacimiento',
                "tipo_identificacion.descripcion as tipo_documento",
                "escolaridades.descripcion as escolaridad",
                "parentescos.descripcion as parentesco",
                "generos.descripcion as genero",
                "profesiones.descripcion as profesion")
            ->where("grupos_familiares.id", $nuevo_familia->id)
            ->first();
        }

        $lugarNacimiento = $nuevo_familia->getLugarNacimiento();
        $campos          = [];
        $mensaje         = "Se ha ingresado la información del familiar sin  errores.";

        //para cambiar el procesado en los candidatos************************
        if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
            FuncionesGlobales::cambio_procesado($this->user->id);
        }

        return response()->json(["mensaje_success" => $mensaje, "lugarNacimiento" => $lugarNacimiento, "registro" => $registro, "nuevo_familia" => $nuevo_familia, "success" => true]);
    }

    public function editar_familiar(Request $data)
    {
        $campos = GrupoFamilia::find($data->get("id"));

        //$campos["ciudad_autocomplete"] = $campos->getLugarExpedicion()->ciudad;
        if(route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co" && route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co" ){
            $campos["ciudad_autocomplete2"] = $campos->getLugarNacimiento()->ciudad;
            $campos["profesion_id"] = $campos->profesion_id;
        }

        $selectores = $this;
        $editar = true;

        return response()->json(["data" => $campos, "success" => true]);
    }

    public function actualizar_familiar(Request $data)
    {
        //dd($data->all());
        $familiar = GrupoFamilia::find($data->get("id"));
        $familiar->fill($data->except('id'));

        if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
          $familiar->fecha_nacimiento = "01-".$data["fecha_nacimiento"];
        }

        if(route('home') == "https://gpc.t3rsc.co" || route('home') == "http://gpc.t3rsc.co"){
         $familiar->ocupacion = $data->ocupacion;
        }
        
        $familiar->save();
        $campos     = [];
        $selectores = $this;
        $lugarNacimiento = "";
        $mensaje    = "Se ha actualizado la información del familiar sin  errores.";

        if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co" || route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co" ||route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co" || route('home') == "http://localhost:8000"){
         
            $registro   = GrupoFamilia::
            //join("tipo_identificacion", "tipo_identificacion.id", "=", "grupos_familiares.tipo_documento")
            // ->join("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            leftjoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftjoin("generos", "generos.id", "=", "grupos_familiares.genero")
            //->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select('grupos_familiares.id',
                'grupos_familiares.numero_id',
                'grupos_familiares.user_id',
                'grupos_familiares.documento_identidad',
                'grupos_familiares.codigo_departamento_expedicion',
                'grupos_familiares.codigo_ciudad_expedicion',
                'grupos_familiares.nombres',
                'grupos_familiares.primer_apellido',
                'grupos_familiares.segundo_apellido',
                'grupos_familiares.escolaridad_id',
                'grupos_familiares.parentesco_id',
                'grupos_familiares.fecha_nacimiento',
                'grupos_familiares.codigo_departamento_nacimiento',
                'grupos_familiares.codigo_ciudad_nacimiento',
                'grupos_familiares.profesion_id',
                'grupos_familiares.active',
                'grupos_familiares.created_at',
                'grupos_familiares.updated_at',
                //'grupos_familiares.codigo_pais_expedicion',
                //'grupos_familiares.codigo_pais_nacimiento',
               // "tipo_identificacion.descripcion as tipo_documento",
                //"escolaridades.descripcion as escolaridad",
                "parentescos.descripcion as parentesco",
                "generos.descripcion as genero")
                //"profesiones.descripcion as profesion")
            ->where("grupos_familiares.id", $familiar->id)->first();

        }else{

            $registro   = GrupoFamilia::leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "grupos_familiares.tipo_documento")
            ->leftjoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftjoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftjoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select('grupos_familiares.id',
                'grupos_familiares.numero_id',
                'grupos_familiares.user_id',
                'grupos_familiares.documento_identidad',
                'grupos_familiares.codigo_departamento_expedicion',
                'grupos_familiares.codigo_ciudad_expedicion',
                'grupos_familiares.nombres',
                'grupos_familiares.primer_apellido',
                'grupos_familiares.segundo_apellido',
                'grupos_familiares.escolaridad_id',
                'grupos_familiares.parentesco_id',
                'grupos_familiares.fecha_nacimiento',
                'grupos_familiares.codigo_departamento_nacimiento',
                'grupos_familiares.codigo_ciudad_nacimiento',
                'grupos_familiares.profesion_id',
                'grupos_familiares.active',
                'grupos_familiares.created_at',
                'grupos_familiares.updated_at',
                'grupos_familiares.codigo_pais_expedicion',
                'grupos_familiares.codigo_pais_nacimiento',
                "tipo_identificacion.descripcion as tipo_documento",
                "escolaridades.descripcion as escolaridad",
                "parentescos.descripcion as parentesco",
                "generos.descripcion as genero",
                "profesiones.descripcion as profesion")
            ->where("grupos_familiares.id", $familiar->id)->first();
          $lugarNacimiento = $registro->getLugarNacimiento()->ciudad;
        }
        
        return response()->json(["mensaje_success" => $mensaje, "lugarNacimiento" => $lugarNacimiento, "registro" => $registro, "success" => true]);
    }

    public function eliminar_familiar(Request $data)
    {
        $familiar = GrupoFamilia::find($data->get("id"));
        $familiar->delete();

        $count_familiar = GrupoFamilia::
            where("user_id", $this->user->id)
            ->count();

        if ($count_familiar < 1) {
            $datos_basicos = DatosBasicos::
                where("user_id", $this->user->id)
                ->first();

            $datos_basicos->grupo_familiar_count = 0;
            $datos_basicos->save();
        }

         //para cambiar el procesado en los candidatos************************
         if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
          FuncionesGlobales::cambio_procesado($this->user->id);

         }

        return response()->json(["id" => $data->get("id")]);
    }

    public function cancelar_familiar(Request $data)
    {
        $campos     = [];
        $selectores = $this;
        return response()->json(["success" => true, "view" => view("cv.modal.fr_grupo_familiar", compact("selectores", "campos"))->render()]);
    }

    public function ValidaEdad(Request $data)
    {
        $fechahijo= $data->get("fecha");
        $datos_basicos = DatosBasicos::select('fecha_nacimiento')->
                where("user_id", $this->user->id)
                ->first();

        $fechahijo = Carbon::parse($fechahijo.'00:00:00');
        $actual = Carbon::parse($datos_basicos->fecha_nacimiento.'00:00:00');

        //$edadhijo = $actual->diffForHumans($fechahijo,$actual);
        $edadhijo = Carbon::parse($fechahijo)->diff($actual)->format('%y');
        //$edadhijo = $edadhijo->format('y');
        //dd($actual.'//'.$fechahijo.'//'.$edadhijo);
        if($edadhijo > 13){
          $mensaje = 'success';
        }else{
          $mensaje = 'Edad de hijo Invalida';
        }

        //$campos = DatosBasicos::find();
        //$campos["ciudad_autocomplete"] = $campos->getLugarExpedicion()->ciudad;

       return response()->json(["data" => $edadhijo, "mensaje"=>$mensaje]);
    }

    public function cargarDocumentoGrupoFamiliar(Request $request){
        //Consultar los archivos del usuario autenticado.
        $tiposDocumentos = ["" => "Seleccionar"] + TipoDocumento::where("categoria",FuncionesGlobales::CATEGORIA_DOCUMENTOS_BENEFICIARIOS)->pluck("descripcion", "id")->toArray();

        $documentos = DocumentoFamiliar::with('tipoDocumento')->where('active', 1)->where('grupo_familiar_id', $request->grupo_familiar_id)->get();

        $grupo_familiar_id = $request->grupo_familiar_id;

        return view("cv.modal.cargar_documento_grupo_familiar", compact("tiposDocumentos", "documentos", "grupo_familiar_id"));
    }


}
