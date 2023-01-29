<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\AspiracionSalarial;
use App\Models\CategoriaLicencias;
use App\Models\ClaseLibreta;
use App\Models\DatosBasicos;
use App\Models\EntidadesAfp;
use App\Models\EntidadesEps;
use App\Models\Escolaridad;
use App\Models\EstadoCivil;
use App\Models\Estudios;
use App\Models\Experiencias;
use App\Models\Genero;
use App\Models\GrupoFamilia;
use App\Models\MotivoRetiro;
use App\Models\NivelEstudios;
use App\Models\Pais;
use App\Models\Parentesco;
use App\Models\Perfilamiento;
use App\Models\Profesiones;
use App\Models\ReferenciasPersonales;
use App\Models\TipoCargo;
use App\Models\TipoDocumento;
use App\Models\TipoIdentificacion;
use App\Models\TipoRelacion;
use App\Models\TipoVehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Cache;

class HojaDeVidaController extends Controller
{

    public $tipoDocumento = ["" => "Seleccionar"];
    public $escolaridad   = ["" => "Seleccionar"];
    public $parentesco    = ["" => "Seleccionar"];
    public $genero        = ["" => "Seleccionar"];
    public $profesion     = ["" => "Seleccionar"];

    public function __construct()
    {
        parent::__construct();

        $this->tipoDocumento += \Cache::remember('tipoDocumento','100', function(){
            
            return TipoIdentificacion::where("active", 1)->pluck("descripcion", "id")->toArray();
        
        });

        $this->escolaridad += \Cache::remember('escolaridad','100', function(){
            
            return //TipoIdentificacion::where("active", 1)->pluck("descripcion", "id")->toArray();
            Escolaridad::where("active", 1)->pluck("descripcion", "id")->toArray();
        
        });

        $this->parentesco += \Cache::remember('parentesco','100', function(){
            
            return //TipoIdentificacion::where("active", 1)->pluck("descripcion", "id")->toArray();
            Parentesco::where("active", 1)->pluck("descripcion", "id")->toArray();
        
        });

        $this->genero += \Cache::remember('genero','100', function(){

         return Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
        });

        $this->profesion += \Cache::remember('profesion','100', function(){
          return Profesiones::where("active", 1)->pluck("descripcion", "id")->toArray();
        });
            
    }

    public function datos_basicos_view(Request $data)
    {
        $datos_basicos      = DatosBasicos::where("user_id", $data->user_id)->first();
        $tipos_documentos   = ["" => "Seleccionar"] + TipoIdentificacion::where("active", 1)->pluck("descripcion", "id")->toArray();
        $estadoCivil        = 
        \Cache::remember('estadocivil','100', function(){
           return ["" => "Seleccionar"] + EstadoCivil::where("active", 1)->pluck("descripcion", "id")->toArray();
        });

        
        $genero             = 
        \Cache::remember('genero','1000', function(){
           ["" => "Seleccionar"] + Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
        });

        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();

        $claseLibreta       = \Cache::remember('claseLibreta','100', function(){
        ["" => "Seleccionar"] + ClaseLibreta::where("active", 1)->pluck("descripcion", "id")->toArray();
        });

        $tipoVehiculo  = \Cache::remember('tipoVehiculo','100', function(){
            ["" => "Seleccionar"] + TipoVehiculo::where("active", 1)->pluck("descripcion", "id")->toArray();
        });

        $categoriaLicencias = \Cache::remember('categoriaLicencias','100', function(){
          ["" => "Seleccionar"] + CategoriaLicencias::where("active", 1)->select(\DB::raw("CONCAT(codigo,' ',descripcion) as descripcion_categoria"), "id")->pluck("descripcion_categoria", "id")->toArray();
        });

        $entidadesEps = \Cache::remember('entidadesEps','100', function(){
            ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->pluck("descripcion", "id")->toArray();
        });

        $entidadesAfp = \Cache::remember('entidadesAfp','100', function(){
            ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->pluck("descripcion", "id")->toArray();
        });

        $datosDireccion = json_decode($datos_basicos->direccion_formato, true);
        //dd($datosDireccion);
        if (is_array($datosDireccion)) {
            foreach ($datosDireccion as $key => $value) {
                $datos_basicos->$key = $value;
            }
        }

        $letras = \Cache::rememberForever('letras', function(){ 
            [
            ""  => "Seleccionar",
            "A" => "A",
            "B" => "B",
            "C" => "C",
            "D" => "D",
            "E" => "E",
            "F" => "F",
            "G" => "G",
            "H" => "H",
            "I" => "I",
            "J" => "J",
        ];
        });

        $prefijo = \Cache::rememberForever('prefijo','100', function(){
            [
            ""      => "Seleccionar",
            "ESTE"  => "ESTE",
            "NORTE" => "NORTE",
            "OESTE" => "OESTE",
            "SUR"   => "SUR",
        ];});

        $tipo_via = \Cache::rememberForever('tipo_via','100', function(){

            ["" => "Seleccionar",
            "AU"            => "Autopista ",
            "AV"            => "Avenida ",
            "AC"            => "Avenida Calle ",
            "AK"            => "Avenida Carrera ",
            "BL"            => "Bulevar ",
            "CL"            => "Calle ",
            "KR"            => "Carrera ",
            "CT"            => "Carretera ",
            "CQ"            => "Circular ",
            "CV"            => "Circunvalar ",
            "CC"            => "Cuentas Corridas ",
            "DG"            => "Diagonal ",
            "PJ"            => "Pasaje ",
            "PS"            => "Paseo ",
            "PT"            => "Peatonal ",
            "TV"            => "Transversal ",
            "TC"            => "Troncal ",
            "VT"            => "Variante ",
            "VI"            => "Vía "];
        });

        $lugarnacimiento = \Cache::remember('lugarnacimiento','100', function(){

            Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS value")
            ->where("ciudad.cod_pais", $datos_basicos->pais_nacimiento)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_nacimiento)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_nacimiento)->first();
        }); 

        $lugarexpedicion = \Cache::remember('lugarexpedicion','100', function(){
            Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_id)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_id)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_id)->first();
        $lugarresidencia = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_residencia)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_residencia)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_residencia)->first();
        });

        $txtLugarNacimiento = "";
        $txtLugarExpedicion = "";
        $txtLugarResidencia = "";
        
        if($lugarnacimiento != null) {
            $txtLugarNacimiento = $lugarnacimiento->value;
        }

        if($lugarexpedicion != null) {
            $txtLugarExpedicion = $lugarexpedicion->value;
        }

        if($lugarresidencia != null) {
            $txtLugarResidencia = $lugarresidencia->value;
        }

        return view("admin.hv.edit_datos_basicos", compact("datos_basicos", "txtLugarNacimiento", "txtLugarExpedicion", "txtLugarResidencia", "data", "letras", "tipos_documentos", "estadoCivil", "genero", "aspiracionSalarial", "claseLibreta", "tipoVehiculo", "categoriaLicencias", "entidadesEps", "entidadesAfp", "prefijo", "tipo_via"));
    }

    public function actualizar_datos_basicos(Request $data, Requests\AdminDatosBasicosRequest $request)
    {
        //VALIDA LIBRETA MILITAR
        $datos_basicos = DatosBasicos::where("user_id", $this->user->id)->first();
        $datos_basicos->fill(Request::all());

        if ($datos_basicos == null) {
            $datos_basicos = new DatosBasicos();
        }
        //AJUSTE DIRECCION
        $direccion_array = [];
        for ($i = 1; $i <= 12; $i++) {
            $direccion_array["direccion_$i"] = $data->get("direccion_$i");
        }

        $datos_basicos->fill($data->all() + ["user_id" => $this->user->id, "direccion_formato" => json_encode($direccion_array), "datos_basicos_count" => "100"]);
        $datos_basicos->save();

        //GUARDANDO IMAGEN
        if ($data->hasFile("foto")) {
            $archivo   = $data->file('foto');
            $extencion = $archivo->getClientOriginalExtension();
            $fileName  = "FotoPerfil_" . $datos_basicos->id . ".$extencion";
            $user      = \App\User::find($datos_basicos->user_id);
            //ELIMINAR FOT PERFIL
            if ($user->foto_perfil != "" && file_exists("recursos_datosbasicos/" . $user->foto_perfil)) {
                unlink("recursos_datosbasicos/" . $user->foto_perfil);
            }
            $user->foto_perfil = $fileName;

            $user->save();
            $data->file('foto')->move("recursos_datosbasicos", $fileName);
        }
        return redirect()->route("datos_basicos")->with(["view_mesaje_success" => view("cv.modal.mensaje_datos_basicos")->render()]);
    }

    public function edit_estudios(Request $data)
    {
        $estudios = \Cache::remember('estudios','100', function(){

            Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.*", "niveles_estudios.descripcion as descripcion_nivel")->
            where("user_id", $this->user->id)->get();
        });

        $nivelEstudios = \Cache::remember('nivelEstudios','100', function(){
            ["" => "Seleccionar"] + NivelEstudios::pluck("descripcion", "id")->toArray();
        });

        return view("admin.hv.edit_estudios", compact("nivelEstudios", "estudios"));
    }

    public function edit_experiencias(Request $data)
    {
        $experiencias = Experiencias::where("user_id", $this->user->id)->get();
        
        $motivos = \Cache::remember('motivos','100', function(){
            
            ["" => "Seleccionar"] + MotivoRetiro::where("active", "1")->pluck("descripcion", "id")->toArray();
        });

        $cargoGenerico = \Cache::remember('cargoGenerico','100', function(){
        
         ["" => "Seleccionar"] + Profesiones::where("active", 1)->pluck("descripcion", "id")->toArray();
        });

        $aspiracionSalarial = \Cache::remember('aspiracionSalarial','100', function(){
            ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();
        });

        return view("admin.hv.edit_experiencias", compact("experiencias", "motivos", "cargoGenerico", "aspiracionSalarial"));
    }

    public function edit_perfilamiento(Request $data)
    {
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
        return view("admin.hv.edit_perfilamiento", compact("tipo_cargos", "cargos_seleccionados", "items_cargos"));
    }

    public function edit_grupo_familiar(Request $data)
    {
        $selectores = $this;

        $familiares = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->join("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->join("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->join("generos", "generos.id", "=", "grupos_familiares.genero")
            ->join("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "profesiones.descripcion as profesion")->
            where("grupos_familiares.user_id", $this->user->id)->get();
        return view("admin.hv.edit_grupo_familiar", compact("selectores", "familiares"));
    }

    public function edit_ref_personales(Request $data)
    {
        $tipoRelaciones = \Cache::remember('tipoRelaciones','100', function(){
            ["" => "Seleccionar"] + TipoRelacion::pluck("descripcion", "id")->toArray();
         });

        $referencias = ReferenciasPersonales::join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
            ->join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->select("referencias_personales.*", "tipo_relaciones.descripcion as relacion", \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"))
            ->where("referencias_personales.user_id", $this->user->id)->get();
        return view("admin.hv.edit_referencias_personales", compact("tipoRelaciones", "referencias"));
    }

}
