<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Pais;
use App\Models\User;
use App\Models\Sitio;
use App\Models\Genero;
use App\Models\Estados;
use App\Models\Estudios;
use App\Models\Auditoria;
use App\Models\Archivo_hv;
use App\Models\Documentos;
use App\Models\OfertaUser;
use App\Models\EstadoCivil;
use App\Models\ClaseLibreta;
use App\Models\DatosBasicos;
use App\Models\EntidadesAfp;
use App\Models\EntidadesEps;
use App\Models\Experiencias;
use App\Models\GrupoFamilia;
use App\Models\ReqCandidato;
use App\Models\TipoVehiculo;
use Illuminate\Http\Request;
use App\Models\Autoentrevist;
use App\Models\CargoGenerico;
use App\Models\IdiomaUsuario;
use App\Models\Requerimiento;
use App\Models\MotivosRechazos;
use App\Models\ObservacionesHv;
use App\Models\RegistroProceso;
use App\Models\FirmaContratos;
use App\Models\DatosBajaVoluntaria;
use App\Models\AspiracionSalarial;
use App\Models\CategoriaLicencias;
use App\Models\TipoIdentificacion;
use Illuminate\Support\Facades\DB;
use App\Models\PoliticasPrivacidad;
use App\Http\Controllers\Controller;
use App\Models\ReferenciasPersonales;
use Illuminate\Support\Facades\Validator;
use App\Models\PoliticaPrivacidadCandidato;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class CvController extends Controller
{
    public function index(Request $request)
    {
        $user         = Sentinel::getUser();
        $datosBasicos = Sentinel::getUser()->getDatosBasicos();
        $sitio        = Sitio::first();
        $cantidad_politicas = PoliticasPrivacidad::count();
        
        $menu = DB::table("menu_candidato")->where("estado", 1)->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();

        $total_aplicados = OfertaUser::where("user_id", $user->id)->count();
        $idiomas = $datosBasicos->idiomas_c->count();

        $documentos_seleccion=Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
        ->where("user_id", $datosBasicos->user_id)
        ->where("tipos_documentos.categoria", 1)
        ->count();

        if($documentos_seleccion > 0) {
            $datosBasicos["documentos_count"] = 100;
        }

        if($idiomas>0){
            $datosBasicos["idiomas_count"]=100;
        }

        $hv_count = ($datosBasicos->datos_basicos_count * 0.3) + ($datosBasicos->perfilamiento_count * 0.08) + ($datosBasicos->experiencias_count*0.15)  + ($datosBasicos->estudios_count*0.1)  + ($datosBasicos->grupo_familiar_count * 0.13)+($datosBasicos->idiomas_count*0.07) + ($datosBasicos->documentos_count*0.17);
        
        if($hv_count<1){
            $hv_count = 5;
        }

        $experiencias  = 0;
        $estudios      = 0;
        $personal      = 0;
        $familia       = 0;

        if(route('home') == "http://soluciones.t3rsc.co" || route('home') == "https://soluciones.t3rsc.co" ){
            $experiencias_count = Experiencias::where("user_id", $this->user->id)->count();
            $estudio_count      = Estudios::where("user_id", $this->user->id)->count();
            $personal_count     = ReferenciasPersonales::where("user_id", $this->user->id)->count();
            $familiar_count     = GrupoFamilia::where("user_id", $this->user->id)->count();

            if ($experiencias_count >= 1) {
                $experiencias = 100;
            }

            if ($estudio_count >= 1) {
                $estudios = 100;
            }

            if ($personal_count >= 1) {
                $personal = 100;
            }

            if ($familiar_count >= 1) {
                $familia = 100;
            }

            //OFERTAS ACTUALES
            $date = Carbon::now();
            $mes =  $date->subDay(8);

            $ofertas = Requerimiento::join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->leftJoin("ofertas_users", function ($join3) {
                $join3->on("ofertas_users.requerimiento_id", "=", DB::raw("requerimientos.id"))
                ->on("ofertas_users.user_id", "=", DB::raw($this->user->id));
            })
            ->whereDate('requerimientos.created_at','>=',$mes)
            ->whereRaw("requerimientos.cargo_generico_id in (select cargo_generico_id from perfilamiento where user_id = " . $this->user->id . ") ")
            ->whereRaw("requerimientos.estado_publico is not false")
            ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ") "))
            ->whereRaw("ofertas_users.fecha_aplicacion is null ")
            ->select(
                "requerimientos.*",
                "ofertas_users.fecha_aplicacion as f_aplicacion",
                "clientes.logo",
                "requerimientos.id as cod_req"
            )
            ->orderBy("requerimientos.created_at", "desc")
            ->take(5);

            $ultimo_proceso_activo=ReqCandidato::join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
            ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
            })
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->leftjoin("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->where("requerimiento_cantidato.candidato_id",$this->user->id)
            ->whereNotIn("requerimiento_cantidato.estado_candidato",[14,23])
            ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ") "))
            ->select(
                "requerimientos.*",
                "requerimiento_cantidato.id",
                \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"),
                "clientes.nombre as nombre_cliente",
                "clientes.logo",
                "cargos_genericos.descripcion as nombre_cargo",
                "requerimientos.id as cod_req",
                "cargos_especificos.descripcion as cargo_especifico"
            )
            ->orderBy("requerimiento_cantidato.id","DESC")
            ->first();

            $cargo = CargoGenerico::join("perfilamiento", "perfilamiento.cargo_generico_id", "=", "cargos_genericos.id")
            ->where("perfilamiento.user_id", $this->user->id)
            ->first();

            $procesos_activos = RegistroProceso::join('users', 'users.id', '=', 'procesos_candidato_req.candidato_id')
            ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
            ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            //->join('requerimientos_estados','requerimientos_estados.req_id','=','requerimientos.id')
            ->whereIn("estados_requerimiento.estado",[
                config('conf_aplicacion.C_RECLUTAMIENTO'),
                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            ])
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where('procesos_candidato_req.candidato_id', $this->user->id)
            ->select('procesos_candidato_req.candidato_id', 'procesos_candidato_req.requerimiento_id')
            ->count();

            $showModal = false;

            if ($request->session()->has('proceso_contratacion')) {
                $showModal = true;
                $request->session()->forget('proceso_contratacion');
            }

            return view("cv.dashboard", compact(
                "user",
                "procesos_activos",
                "ultimo_proceso_activo",
                "datosBasicos",
                "experiencias",
                "estudios",
                "personal",
                "familia",
                "ofertas",
                "cargo",
                "hv_count",
                "total_aplicados",
                "menu",
                "showModal",
                "sitio"
            ));
        }else{
            $experiencias_count = Experiencias::where("user_id", $this->user->id)->get()->count();
            $estudio_count    = Estudios::where("user_id", $this->user->id)->get()->count();
            $personal_count   = ReferenciasPersonales::where("user_id", $this->user->id)->get()->count();

            $familiar_count = GrupoFamilia::where("user_id", $this->user->id)->get()->count();

            if($experiencias_count >= 1){
                $experiencias = 100;
            }

            if($estudio_count >= 1){
                $estudios = 100;
            }

            if($personal_count >= 1){
                $personal = 100;
            }

            if($familiar_count >= 1){
                $familia = 100;
            }

            $procesos_activos = RegistroProceso::join('users', 'users.id', '=', 'procesos_candidato_req.candidato_id')
            ->join('requerimiento_cantidato', 'requerimiento_cantidato.id', '=', 'procesos_candidato_req.requerimiento_candidato_id')
            ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
            ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            ->whereIn("estados_requerimiento.estado", [
                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
            ])
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->where('procesos_candidato_req.candidato_id', $this->user->id)
            ->whereRaw("requerimiento_cantidato.estado_candidato not in (" .config('conf_aplicacion.C_QUITAR') .",".config('conf_aplicacion.C_TRANSFERIDO').")")
            ->select('procesos_candidato_req.candidato_id', 'procesos_candidato_req.requerimiento_id')
            ->get()
            ->count();

            //OFERTAS ACTUALES
            $ofertas = Requerimiento::join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
            })
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->leftjoin("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->leftJoin("ofertas_users", function ($join3) {
                $join3->on("ofertas_users.requerimiento_id", "=", DB::raw("requerimientos.id"))
                ->on("ofertas_users.user_id", "=", DB::raw($this->user->id));
            })
            ->select(
                "requerimientos.*",
                "ofertas_users.fecha_aplicacion as f_aplicacion",
                \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"),
                "clientes.nombre as nombre_cliente",
                "clientes.logo",
                "cargos_genericos.descripcion as nombre_cargo",
                "requerimientos.id as cod_req",
                "cargos_especificos.descripcion as cargo_especifico"
            )
            ->whereRaw("requerimientos.cargo_generico_id in (select cargo_generico_id from perfilamiento where user_id = " . $this->user->id . ") ")
            ->whereRaw("requerimientos.estado_publico is not false")
            //->where("requerimientos.pais_id", $datosBasicos->pais_residencia)
            //->where("requerimientos.departamento_id", $datosBasicos->departamento_residencia)
            //->where("requerimientos.ciudad_id", $datosBasicos->ciudad_residencia)
            ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ") "))
            ->whereRaw("ofertas_users.fecha_aplicacion is null ")
            ->orderBy("requerimientos.created_at", "desc")
            ->take(5)
            ->get();

            //PROCESOS ACTIVOS
            
            $ultimo_proceso_activo=ReqCandidato::join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
            ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
            })
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->leftjoin("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->where("requerimiento_cantidato.candidato_id",$this->user->id)
            ->whereNotIn("requerimiento_cantidato.estado_candidato",[14,23])
            ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ") "))
            ->select(
                "requerimientos.*",
                "requerimiento_cantidato.id",
                \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"),
                "clientes.nombre as nombre_cliente",
                "clientes.logo",
                "cargos_genericos.descripcion as nombre_cargo",
                "requerimientos.id as cod_req",
                "cargos_especificos.descripcion as cargo_especifico"
            )
            ->orderBy("requerimiento_cantidato.id","DESC")
            ->first();
            
            $cargo = CargoGenerico::join("perfilamiento", "perfilamiento.cargo_generico_id", "=", "cargos_genericos.id")
            ->where("perfilamiento.user_id", $this->user->id)
            ->first();


        }

        $showModal = false;

        if ($request->session()->has('proceso_contratacion')) {
            $showModal = true;
            $request->session()->forget('proceso_contratacion');
        }

        return view("cv.dashboard", compact(
            "procesos_activos",
            "ultimo_proceso_activo",
            "user",
            "datosBasicos",
            "cantidad_politicas",
            "experiencias",
            "estudios",
            "personal",
            "familia",
            "ofertas",
            "cargo",
            "hv_count",
            "total_aplicados",
            "showModal",
            "menu",
            "sitio"
        ));
    }

    public function pdf_hv(Request $data)
    {
        $menu = DB::table("menu_candidato")->where("estado",1)->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();

        $user = $this->user;
        $logo = "";

        $datos_basicos = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
            ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
            ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
            ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
            ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->where("user_id", $this->user->id)
            ->select("datos_basicos.datos_basicos_activo as datos_contacto", "datos_basicos.*", "tipo_identificacion.descripcion as dec_tipo_doc", "generos.descripcion as genero_desc", "estados_civiles.descripcion as estado_civil_des"
            , "aspiracion_salarial.descripcion as aspiracion_salarial_des", "clases_libretas.descripcion as clases_libretas_des", "tipos_vehiculos.descripcion as tipos_vehiculos_des", "categorias_licencias.descripcion as categorias_licencias_des", "entidades_afp.descripcion as entidades_afp_des", "entidades_eps.descripcion as entidades_eps_des"
            )->first();

        //Calcular edad de candidatos.
        //$edad = Carbon::parse($datos_basicos->fecha_nacimiento)->age;
        //Calcular edad de candidatos.
        $edad = ($datos_basicos->fecha_nacimiento != 0 && $datos_basicos->fecha_nacimiento != "")?Carbon::parse($datos_basicos->fecha_nacimiento)->age:"";

        $lugarnacimiento = null;
        $lugarexpedicion = null;
        $lugarresidencia = null;

        if($datos_basicos != null) {
          $lugarnacimiento = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_nacimiento)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_nacimiento)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_nacimiento)
            ->first();

            $lugarexpedicion = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_id)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_id)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_id)
            ->first();

            $lugarresidencia = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select(\DB::raw("CONCAT(ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_residencia)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_residencia)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_residencia)
            ->first();
        }

        $experiencias = Experiencias::leftJoin("paises", "paises.cod_pais", "=", "experiencias.pais_id")
        ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
        ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
        ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
                ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
                ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
        })
        ->where("experiencias.user_id", $this->user->id)
        ->select("aspiracion_salarial.descripcion as salario", "cargos_genericos.descripcion as desc_cargo", "motivos_retiros.descripcion as desc_motivo", \DB::raw("CONCAT(ciudad.nombre) AS ciudades"), "experiencias.*")
        ->orderBy("experiencias.fecha_inicio", "desc")
        ->get();

        $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.*", "niveles_estudios.descripcion as desc_nivel")
            ->where("estudios.user_id", $this->user->id)
            ->get();

        $referencias = ReferenciasPersonales::join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
            ->where("referencias_personales.user_id", $this->user->id)
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudades"), "tipo_relaciones.descripcion as desc_tipo", "referencias_personales.*")
            ->get();

        if(route('home') == "https://nases.t3rsc.co" || route('home') == "http://nases.t3rsc.co" || route('home') == "https://demo.t3rsc.co" || route('home') == "http://demo.t3rsc.co" || route('home') == "http://localhost:8000") {

            $familiares = GrupoFamilia::join("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->join("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->join("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select("grupos_familiares.*", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", \DB::raw("CONCAT(grupos_familiares.nombres,' ',grupos_familiares.primer_apellido,' ',grupos_familiares.segundo_apellido) AS nombres_familiar"))
            ->where("grupos_familiares.user_id", $this->user->id)
            ->orderBy("parentescos.id", "ASC")
            ->get();

        }else{
          
            $familiares = GrupoFamilia::leftjoin("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftjoin("escolaridades", "escolaridades.id","=","grupos_familiares.escolaridad_id")
            ->join("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftjoin("generos","generos.id","=","grupos_familiares.genero")
            ->select("grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", \DB::raw("CONCAT(grupos_familiares.nombres,' ',grupos_familiares.primer_apellido,' ',grupos_familiares.segundo_apellido) AS nombres_familiar"))
            ->where("grupos_familiares.user_id", $this->user->id)
            ->orderBy("parentescos.id", "ASC")
            ->get();
        }

        /*$experienciaMayorDuracion = Experiencias::
            select(\DB::raw(" *, (TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) AS dias, (user_id) AS usuario"))
            ->where("user_id", $this->user->id)
            ->havingRaw("dias >= (SELECT MAX(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) FROM experiencias as e WHERE e.user_id = experiencias.user_id)")
            ->first();*/
        $experienciaMayorDuracion = Experiencias::leftjoin('aspiracion_salarial', 'aspiracion_salarial.id', '=', 'experiencias.salario_devengado')
            ->select(\DB::raw("*,(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) AS dias,(user_id) AS usuario"),"aspiracion_salarial.descripcion AS salario","experiencias.empleo_actual")
            ->selectRaw("experiencias.salario_devengado")
            ->where("user_id", $this->user->id)
            //->max('dias')
            ->havingRaw("dias >= (SELECT MAX(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) FROM experiencias as e WHERE e.user_id = experiencias.user_id)")
            ->first();

        $experienciaActual = Experiencias::leftjoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            ->where("experiencias.user_id", $this->user->id)
            ->select("aspiracion_salarial.descripcion as salario", "experiencias.*")
            ->orderBy("experiencias.fecha_inicio", "DESC")
            ->first();

        $documentos=Documentos::where("numero_id",$datos_basicos->numero_id)->orderBy("id","desc")->groupBy("tipo_documento_id")->get();

        //idiomas por ahora solo colpatria
        $idiomas = IdiomaUsuario::where("id_usuario", $this->user->id)->get();

        $autoentrevista = '';

        $hv=Archivo_hv::where("user_id",$this->user->id)->orderBy("archivo_hv.id","desc")->first();

        if(route("home") == "https://gpc.t3rsc.co") {
         $autoentrevista = Autoentrevist::where('id_usuario',$user->id)->first();
        }

        /*return view("cv.pdf_hv", compact('idiomas','experienciaActual', 'experienciaMayorDuracion', 'datos_basicos', 'edad', 'user', "lugarresidencia", 'lugarnacimiento', "lugarexpedicion", "experiencias", "estudios", "referencias", "familiares"));*/

        if(route('home') == "https://gpc.t3rsc.co" || route('home') == "http://localhost:80001"){
            
            $experiencias_gpc = Experiencias::leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
            ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            ->where("experiencias.user_id", $this->user->id)
            ->select(
                "aspiracion_salarial.descripcion as salario",
                "cargos_genericos.descripcion as desc_cargo",
                "motivos_retiros.descripcion as desc_motivo",
                "experiencias.*"
            )
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->orderBy("experiencias.empleo_actual", "asc")
            ->get();

            $anios = $edad;
            
            $conyuge = GrupoFamilia::join("tipo_relaciones", "tipo_relaciones.id", "=", "grupos_familiares.parentesco_id")
            ->select("grupos_familiares.*","tipo_relaciones.descripcion as parentesco",\DB::raw("CONCAT(grupos_familiares.nombres,' ',grupos_familiares.primer_apellido,' ',grupos_familiares.segundo_apellido) AS nombres_familiar"))
            ->where("grupos_familiares.user_id", $this->user->id)
            ->where("grupos_familiares.parentesco_id",1)
            ->first();

            $padres = GrupoFamilia::join("tipo_relaciones", "tipo_relaciones.id", "=", "grupos_familiares.parentesco_id")
            ->select("grupos_familiares.*","tipo_relaciones.descripcion as parentesco",\DB::raw("CONCAT(grupos_familiares.nombres,' ',grupos_familiares.primer_apellido,' ',grupos_familiares.segundo_apellido) AS nombres_familiar"))
            ->where("grupos_familiares.user_id", $this->user->id)
            ->whereIn("grupos_familiares.parentesco_id",[3,4])
            ->groupBy("grupos_familiares.parentesco_id")
            ->orderBy("tipo_relaciones.id", "ASC")
            ->get();

            /*return view('admin.hoja_vida_pdf', compact(
                'idiomas',
                'experienciaActual',
                'experienciaMayorDuracion',
                'datos_basicos',
                'anios',
                'user',
                "lugarresidencia",
                'lugarnacimiento',
                "lugarexpedicion",
                "experiencias_gpc",
                "estudios",
                "referencias",
                "familiares",
                "logo",
                "anios",
                "conyuge",
                "padres",
                "autoentrevista"
            ));*/

            $view = \View::make('admin.hoja_vida_pdf', compact(
                'idiomas',
                'experienciaActual',
                'experienciaMayorDuracion',
                'datos_basicos',
                'anios',
                'user',
                "lugarresidencia",
                'lugarnacimiento',
                "lugarexpedicion",
                "experiencias_gpc",
                "estudios",
                "referencias",
                "familiares",
                "logo",
                "anios",
                "conyuge",
                "padres",
                "autoentrevista"
            ))->render();
        }else{
            return view('cv.pdf_hv_new', compact(
                'idiomas',
                'hv',
                'experienciaActual',
                'experienciaMayorDuracion',
                'datos_basicos',
                'edad',
                'user',
                "lugarresidencia",
                'lugarnacimiento',
                "lugarexpedicion",
                "experiencias",
                "estudios",
                "referencias",
                "familiares",
                "logo",
                "documentos"
                
            ));
        }

        $pdf  = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream('Hoja_de_Vida');
    }

    public function termina_registro(Request $data)
    {
        $menu = DB::table("menu_candidato")->where("estado", 1)->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();
        $tipos_documentos   = ["" => "Seleccionar"] + TipoIdentificacion::where("active", 1)->pluck("descripcion", "id")->toArray();
        $estadoCivil        = ["" => "Seleccionar"] + EstadoCivil::where("active", 1)->pluck("descripcion", "id")->toArray();
        $genero             = ["" => "Seleccionar"] + Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();
        $claseLibreta       = ["" => "Seleccionar"] + ClaseLibreta::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoVehiculo       = ["" => "Seleccionar"] + TipoVehiculo::where("active", 1)->pluck("descripcion", "id")->toArray();
        $categoriaLicencias = ["" => "Seleccionar"] + CategoriaLicencias::where("active", 1)->pluck("descripcion", "id")->toArray();
        $entidadesEps       = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->pluck("descripcion", "id")->toArray();
        $entidadesAfp       = ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->pluck("descripcion", "id")->toArray();
        $letras             = [
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
        $prefijo = [
            ""      => "Seleccionar",
            "ESTE"  => "ESTE",
            "NORTE" => "NORTE",
            "OESTE" => "OESTE",
            "SUR"   => "SUR",
        ];
        $tipo_via = ["" => "Seleccionar",
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
        return view("cv.terminar_registro", compact("letras", "tipo_via", "prefijo", "tipos_documentos", "estadoCivil", "genero", "aspiracionSalarial", "claseLibreta", "tipoVehiculo", "categoriaLicencias", "entidadesEps", "entidadesAfp","menu"));
    }

    public function lista_hv_admin(Request $data)
    {
        $user_sesion = $this->user;
        $campos = $data;
        $sitio = Sitio::first();

        $hojas_de_vida = DatosBasicos::join('users', 'users.id', '=', 'datos_basicos.user_id')
        ->leftjoin('estados', 'datos_basicos.estado_reclutamiento', '=', 'estados.id')
        ->where(function ($where) use ($campos) {
            if($campos->get("palabra_clave") != "") {
                $where->whereRaw("( LOWER(CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido)) like '%" . (strtolower($campos->get("palabra_clave"))) . "%' COLLATE utf8_general_ci or LOWER(datos_basicos.email) like '%" . (strtolower($campos->get("palabra_clave"))) . "%' or LOWER(datos_basicos.primer_apellido) like '%".(strtolower($campos->get("palabra_clave")))."%' COLLATE utf8_general_ci or LOWER(datos_basicos.segundo_apellido) like '%".(strtolower($campos->get("palabra_clave"))). "%' COLLATE utf8_general_ci or LOWER(CONCAT(datos_basicos.primer_nombre,' ',datos_basicos.primer_apellido)) like '%".(strtolower($campos->get("palabra_clave"))). "%' COLLATE utf8_general_ci or LOWER(CONCAT(datos_basicos.primer_nombre,' ',datos_basicos.segundo_apellido)) like '%".(strtolower($campos->get("palabra_clave"))). "%' COLLATE utf8_general_ci or LOWER(CONCAT(datos_basicos.segundo_nombre,' ',datos_basicos.segundo_apellido)) like '%".(strtolower($campos->get("palabra_clave"))). "%' COLLATE utf8_general_ci) ");
            }

            if ($campos->get("pais_residencia") != "") {
                $where->where("datos_basicos.pais_residencia", $campos->get("pais_residencia"));
            }

            if ($campos->get("departamento_residencia") != "") {
                $where->where("datos_basicos.departamento_residencia", $campos->get("departamento_residencia"));
            }

            if ($campos->get("ciudad_residencia") != "") {
                $where->where("datos_basicos.ciudad_residencia", $campos->get("ciudad_residencia"));
            }

            if ($campos->get("cedula") != "") {
                $where->where("datos_basicos.numero_id", $campos->get("cedula"));
            }

            if($campos->get("estado") != ""){
              $where->where("estados.descripcion" , $campos->get("estado"));
            }

            if(count($campos->all()) == 0) {
                $where->whereBetween(DB::raw('DATE_FORMAT(datos_basicos.created_at, \'%Y-%m-%d\')'), [date("Y-m-d",strtotime(date("Y-n-d")."- 1 month")), date("Y-m-d")]);
            }
        })->select(
            'users.video_perfil as video',
            'datos_basicos.numero_id',
            'datos_basicos.user_id',
            'datos_basicos.nombres',
            'datos_basicos.telefono_movil',
            'datos_basicos.telefono_fijo',
            'datos_basicos.segundo_apellido',
            'datos_basicos.email',
            'datos_basicos.primer_apellido',
            'datos_basicos.ciudad_residencia',
            'datos_basicos.departamento_residencia',
            'datos_basicos.pais_residencia',
            'datos_basicos.id',
            'datos_basicos.estado_reclutamiento',
            'datos_basicos.created_at'
        )
        ->groupBy(
            'datos_basicos.numero_id',
            'datos_basicos.user_id',
            'datos_basicos.nombres',
            'datos_basicos.telefono_movil',
            'datos_basicos.telefono_fijo',
            'datos_basicos.segundo_apellido',
            'datos_basicos.email',
            'datos_basicos.primer_apellido',
            'datos_basicos.ciudad_residencia',
            'datos_basicos.departamento_residencia',
            'datos_basicos.estado_reclutamiento',
            'datos_basicos.id',
            'datos_basicos.pais_residencia',
            'datos_basicos.created_at'
        )
        ->orderBy('datos_basicos.created_at', 'DESC')
        ->take(10)
        ->with('datosBajaVoluntaria')
        ->get();

        return view("admin.hv.lista-hv-new", compact("hojas_de_vida", "sitio", "user_sesion"));
    }

    public function modal_trazabilidad(Request $data)
    {
        $date = Carbon::now();
        $date->subMonth(2);
        $fecha = $date->toDateString();

        $reqCandidato = Requerimiento::join('requerimiento_cantidato', 'requerimiento_cantidato.requerimiento_id', '=', 'requerimientos.id')
        ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
        ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
        ->where('requerimiento_cantidato.candidato_id', $data->get('candidato_id'))
        //->whereDate('requerimiento_cantidato.created_at','>=', $fecha)
        ->select(
            'requerimientos.id as req_id',
            //'estados.descripcion as estado_candidato',
            'requerimiento_cantidato.created_at as fecha_asociacion',
            DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req_id'),
            DB::raw('(select upper(x.descripcion) from requerimiento_cantidato y
                inner join estados x on y.estado_candidato=x.id
                where y.requerimiento_id =requerimientos.id
                and y.candidato_id = ' . $data->get('candidato_id') . '
                order by y.created_at desc limit 1  ) as estado_candidato'),
            DB::raw('(select upper(p.name)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id and o.estado = ' . config('conf_aplicacion.C_EN_PROCESO_SELECCION') . ' order by o.created_at desc limit 1) as usuario_gestiono_req')
        )
        ->groupBy('requerimientos.id')
        ->orderBy('requerimientos.id', 'desc')
        ->get();

        return view("admin.hv.modals.trazabilidad_candidato", compact("reqCandidato"));
    }

    public function view_estado_candidato(Request $data)
    {
        $candidato = DatosBasicos::find($data->get("hv_id"));
        return view("admin.hv.modals.activar_candidato", compact("candidato"));
    }

    public function activar_candidato(Request $data)
    {
        $rules = [
            "observaciones" => "required",
        ];
        $validator = \Illuminate\Support\Facades\Validator::make($data->all(), $rules);
        $candidato = DatosBasicos::find($data->get("hv_id"));

        if ($validator->fails()) {
            return response()->json(["success" => false, "view" => view("admin.hv.modals.activar_candidato", compact("candidato"))->withErrors($validator)->render()]);
        }

        //ACTIVAR USUARIO Evento

        $auditoria                = new Auditoria();
        $auditoria->observaciones = $data->get("observaciones");
        $auditoria->valor_antes   = json_encode(["estado" => $candidato->estado_reclutamiento]);
        $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.C_ACTIVO')]);
        $auditoria->user_id       = $this->user->id;
        $auditoria->tabla         = "datos_basicos";
        $auditoria->tabla_id      = $candidato->id;
        $auditoria->tipo          = "ACTIVAR";
        event(new \App\Events\AuditoriaEvent($auditoria));

        $candidato->estado_reclutamiento = config('conf_aplicacion.C_ACTIVO');
        $candidato->save();
        return response()->json(["success" => true, "view" => ""]);
    }

    //Cambiar Estado actual
    public function cambiar_estado(Request $data)
    {

        $candidato = DatosBasicos::find($data->get("hv_id"));
        $estado    = ["" => "Seleccionar"] + Estados::orderBy("descripcion", "ASC")
            ->where("tipo", "C")
            ->whereIn("id", [config('conf_aplicacion.C_ACTIVO'), config('conf_aplicacion.C_INACTIVO'), config('conf_aplicacion.C_BAJA_VOLUNTARIA')])
            ->pluck(strtoupper("descripcion"), "id")
            ->toArray();

        $estados = Estados::select('id', 'descripcion')->get();

        $motivos = ["" => "Seleccionar"] + MotivosRechazos::pluck("descripcion", "id")->toArray();

        $observacion = Auditoria::join("datos_basicos", "datos_basicos.id", "=", "auditoria.tabla_id")
            ->select("auditoria.observaciones as observaciones", "datos_basicos.id as basicos_id", "auditoria.tabla_id as tabla_id", "datos_basicos.nombres as nombres")
            ->where("auditoria.tabla_id", $data->get("hv_id"))
        //->orWhere("auditoria.tabla","datos_basicos")
            ->orderBy("auditoria.created_at", "desc")
            ->first();
        //dd($observacion);

        $auditorias = Auditoria::join("datos_basicos", "datos_basicos.id", "=", "auditoria.tabla_id")
            ->leftjoin('motivos_rechazos', 'motivos_rechazos.id', '=', 'auditoria.motivo_rechazo_id')
            ->select(
                "auditoria.observaciones as observacion",
                "auditoria.created_at as fecha",
                "auditoria.user_id",
                "auditoria.valor_despues as estado",
                "datos_basicos.motivo_rechazo",
                "motivos_rechazos.descripcion as motivo_rechazo_desc"
            )
            ->where('tabla', 'datos_basicos')
            ->where('tabla_id', $candidato->id)
        ->get();

        return view("admin.hv.modals.cambiar_estado-new", compact("observacion", "candidato", "estado", "motivos", "auditorias", "estados"));
    }

    public function guardar_estado(Request $data)
    {

        //dd($data->get("MOTIVO_RECHAZO_ID"));
        $rules = [
            "observaciones" => "required",
        ];
        $validator   = \Illuminate\Support\Facades\Validator::make($data->all(), $rules);
        $candidato   = DatosBasicos::find($data->get("hv_id"));
        $descripcion = Estados::find($data->get("ESTADO_ID"));

        if ($validator->fails()) {
            $estado    = ["" => "Seleccionar"] + Estados::orderBy("descripcion", "ASC")
            ->where("tipo", "C")
            ->whereIn("id", [config('conf_aplicacion.C_ACTIVO'), config('conf_aplicacion.C_INACTIVO'), config('conf_aplicacion.C_BAJA_VOLUNTARIA')])
            ->pluck("descripcion", "id")
            ->toArray();

            $motivos = ["" => "Seleccionar"] + MotivosRechazos::pluck("descripcion", "id")->toArray();

            return response()->json(["success" => false, "view" => view("admin.hv.modals.cambiar_estado", compact("candidato", "estado", "motivos"))->withErrors($validator)->render()]);
        }

        //Auditoria Usuario Evento
        $auditoria                = new Auditoria();
        $auditoria->observaciones = $data->get("observaciones");
        $auditoria->valor_antes   = json_encode(["estado" => $candidato->estado_reclutamiento]);
        $auditoria->valor_despues = json_encode(["estado" => $data->get("ESTADO_ID")]);
        $auditoria->user_id       = $this->user->id;
        $auditoria->tabla         = "datos_basicos";
        $auditoria->tabla_id      = $candidato->id;
        $auditoria->tipo          = $descripcion->descripcion;
        $auditoria->motivo_rechazo_id = $data->get("motivo_rechazo_id");
        event(new \App\Events\AuditoriaEvent($auditoria));

        $candidato->estado_reclutamiento = $data->get("ESTADO_ID");
        $candidato->motivo_rechazo       = $data->get("motivo_rechazo_id");
        $candidato->save();

        if ($data->get("ESTADO_ID") === config('conf_aplicacion.C_BAJA_VOLUNTARIA')) {
            $sitio = Sitio::first();
            $fue_contratado = false;

            $proceso_contratacion = RegistroProceso::where('candidato_id', $candidato->user_id)->where('proceso', 'ENVIO_CONTRATACION')->get();
            if ($sitio->asistente_contratacion && count($proceso_contratacion) > 0) {
                $array_req_id = $proceso_contratacion->pluck('requerimiento_id')->all();
                $firma_contrato = FirmaContratos::where('user_id', $candidato->user_id)
                    ->whereIn('req_id', $array_req_id)
                    ->where('estado', 1)
                    ->whereIn('terminado', [1,2,3])
                ->first();

                if (!is_null($firma_contrato)) {
                    $fue_contratado = true;
                }
            } else {
                if (count($proceso_contratacion) > 0) {
                    $fue_contratado = true;
                }
            }

            if ($fue_contratado) {
                $datos_baja = new DatosBajaVoluntaria();
                $datos_baja->fill([
                    'primer_nombre'     => $candidato->primer_nombre,
                    'segundo_nombre'    => $candidato->segundo_nombre,
                    'primer_apellido'   => $candidato->primer_apellido,
                    'segundo_apellido'  => $candidato->segundo_apellido,
                    'telefono_movil'    => $candidato->telefono_movil,
                    'email'             => $candidato->email,
                    'numero_id'         => $candidato->numero_id,
                    'user_id'           => $candidato->user_id,
                    'usuario_gestion'   => $this->user->id
                ]);
                $datos_baja->save();
            }

            $requerimientos_cand = ReqCandidato::where('candidato_id', $candidato->user_id)
                ->whereIn('estado_candidato', [config('conf_aplicacion.C_EN_PROCESO_SELECCION'), config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'), config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), config('conf_aplicacion.C_EN_EXAMENES_MEDICOS')])
            ->get();

            foreach ($requerimientos_cand as $req_cand) {
                $req_cand->estado_candidato = config('conf_aplicacion.C_BAJA_VOLUNTARIA');
                $req_cand->save();

                $nuevo_proceso_baja_voluntaria = new RegistroProceso();
                $nuevo_proceso_baja_voluntaria->fill(
                    [
                        'requerimiento_candidato_id' => $req_cand->id,
                        'estado'                     => config('conf_aplicacion.C_BAJA_VOLUNTARIA'),
                        'fecha_inicio'               => date("Y-m-d H:i:s"),
                        'usuario_envio'              => $this->user->id,
                        'requerimiento_id'           => $req_cand->requerimiento_id,
                        'candidato_id'               => $req_cand->candidato_id,
                        'proceso'                    => 'BAJA_VOLUNTARIA',
                        'observaciones'              => "El candidato solicitó la baja voluntaria de la plataforma.",
                    ]
                );
                $nuevo_proceso_baja_voluntaria->save();
            }

            $candidato->email = $sitio->email_replica;
            $candidato->telefono_movil = $candidato->telefono_movil.'0';
            $candidato->save();

            $user = User::find($candidato->user_id);
            $user->email = $sitio->email_replica;
            $user->telefono = $candidato->telefono_movil.'0';
            $user->save();
        }

        return response()->json(["success" => true, "view" => ""]);
    }

    public function cargar_hv(Request $data)
    {
        //Consultar los archivos del usuario autenticado.
        $archivos = Archivo_hv::where("user_id", $this->user->id)->get();

        return view("cv.modal.cargar_hv", compact("archivos"));
    }

    //Guardar archivos (pdf) hojas de vida del usuario.
    public function guardar_hv(Request $data)
    {
        try {
            //Guardamos el archivo en un directorio
            if ($data->hasFile('archivo_hv')) {
                $archivo_hv     = $data->file("archivo_hv");
                $extencion      = $archivo_hv->getClientOriginalExtension();

                if ($extencion == 'jpg' || $extencion == 'png' || $extencion == 'jpeg' || $extencion == 'pdf' || $extencion == 'doc' || $extencion == 'docx') {

                    $archivo = new Archivo_hv();
                    $archivo->fill($data->all() + [
                        "user_id" => $this->user->id,
                        "archivo" => $data->get("archivo_hv")
                    ]);
                    $archivo->save();

                    $name_documento = "documento_hv_" . $archivo->id . "." . $extencion;
                    $archivo_hv->move("archivo_hv", $name_documento);
                    $archivo->archivo = $name_documento;
                    $archivo->save();

                    $archivos = Archivo_hv::where("user_id", $this->user->id)->get();
                    $mensaje = "Se cargo correctamente la hoja de vida.";

                    return response()->json(["success" => true, "view" => view("cv.modal.cargar_hv", compact("mensaje", "archivos"))->render()]);
                }else{

                    $archivos = Archivo_hv::where("user_id", $this->user->id)->get();

                    $mensaje = "Problemas al momento de guardar, intentar nuevamente.";
                    return response()->json(["success" => false, "view" => view("cv.modal.cargar_hv", compact("mensaje", "archivos"))->render()]);
                }
            }
        } catch (\Exception $e) {
            $archivos = Archivo_hv::where("user_id", $this->user->id)->get();

            $mensaje = "Problemas al momento de guardar, intentar nuevamente.";
            return response()->json(["success" => false, "view" => view("cv.modal.cargar_hvv", compact("mensaje", "archivos"))->render()]);
        }
    }

    public function eliminar_hv(Request $data)
    {
        //Consultamos el nombre del archivo para delete.
        $datos = Archivo_hv::where("id", $data->get("id"))->first();

        //Eliminar el archivo en el directorio
        unlink("archivo_hv/" . $datos->archivo);

        //Eliminar el registro
        $archivo = Archivo_hv::find($data->get("id"));
        $archivo->delete();

        return response()->json(["id" => $data->get("id")]);
    }

    public function ver_hv(Request $data)
    {
        $archivo = Archivo_hv::find($data->get("id"));

        return response()->json(["archivo" => $archivo]);
    }

    public function privacyAccept(Request $data)
    {
        $infoPolities = DatosBasicos::where('user_id', Sentinel::getUser()->id)
        //->select('id', 'user_id', 'acepto_politicas_privacidad', 'politicas_privacidad_id', 'fecha_acepto_politica', 'hora_acepto_politica', 'ip_acepto_politica')
        ->first();
        
        $politica = PoliticasPrivacidad::orderBy('id', 'DESC')->first();

        if ($data->has('accept')) {
            $infoPolities->acepto_politicas_privacidad = 0;
            $infoPolities->save();

            return response()->json(['success' => false]);
        }

        $aceptacion_politica = new PoliticaPrivacidadCandidato();

        $aceptacion_politica->fill([
            'politica_privacidad_id' => $data->politica_id,
            'candidato_id'            => Sentinel::getUser()->id,
            'fecha_acepto_politica' => date('Y-m-d'),
            'hora_acepto_politica'  => date('H:i:s'),
            'ip_acepto_politica' => $data->ip()
            
        ]);

        $aceptacion_politica->save();

        return response()->json(['success' => true]);
    }

    public function crear_observacion_hv(Request $data)
    {    
        $user_id=$this->user->id;
        $candidato_id = $data->get('candidato_id');
        $candidato=User::find($candidato_id);
        $observacion = ObservacionesHv::join('users','users.id','=','observaciones_hoja_vida.user_gestion')
         ->select('observaciones_hoja_vida.*','users.name as nombre')
        ->where('candidato_id',$candidato_id)
        ->get();



        /*if(!is_null($observacion)){
            if(!$data->has("modulo")){
                 foreach($observacion as $obs){
                    $obs->visto=1;
                    $obs->save();
                }
            }
           
        }*/
        //dd($observacion);
        //USUARIOS CLIENTES
        return view("admin.hv.modals.crear_observacion", compact("observacion","candidato"));
    }

    public function guardar_observacion_hv(Request $data)
    {
        $rules = [];

        $rules += [ "observacion" => "required",];

        $validar = Validator::make($data->all(), $rules);

        $fecha_hoy = Carbon::now();
        $fecha_hoy = $fecha_hoy->format('Y-m-d');
        // dd($estado);
        $estado = new ObservacionesHv();
        $estado->observacion           = $data->observacion;
        $estado->user_gestion          =$this->user->id;
        $estado->candidato_id            = $data->get('candidato_id');
        $estado->save();

        /*$proceso=RegistroProceso::join("users","users.id","=","procesos_candidato_req.usuario_envio")
        ->where("requerimiento_candidato_id",$data->candidato_req)
        ->where("proceso","ENVIO_APROBAR_CLIENTE")
        ->select("users.email as email_envio","requerimiento_id as req_id","candidato_id as candidato_id")
        ->first();*/

        /*$candidato=User::find($proceso->candidato_id);

            Mail::send('admin.email_observacion_candidato', [
                    'candidato' => $candidato,
                    'req'      => $proceso->req_id,
                    'observacion' => $data->observacion
                ], function ($message) use ($proceso) {
                    $message->to([$proceso->email_envio,'javier.chiquito@t3rsc.co'], "T3RS")
                    //$message->to(['juli.gzulu@gmail.com','javier5chiquito@gmail.com'], "T3RS")
                    ->subject("Observación sobre candidato Req# $proceso->req_id")
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });*/

       return response()->json(["success" => true, 'candidato_id' => $data->get("candidato_id")]);
    }

    public function politicaTratamientoDatosPersonalesPDF() {
        
        $view = \View::make('cv.pdf_tratamiento_datos_personales')->render();


        $pdf  = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream('politica_de_tratamientos_de_datos_personales');
    }

}
