<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CalificaCompetencia;
use App\Models\CompetenciaCliente;
use App\Models\DatosBasicos;

use App\Models\EntrevistaSemi;
use App\Models\EntrevistaCandidatos;
use App\Models\ProcesoRequerimiento;
use App\Models\RegistroProceso;
use App\Models\TipoFuentes;
use App\Models\Estudios;
use App\Models\GrupoFamilia;
use App\Models\User;
use App\Models\Ciudad;
use App\Models\EstadoCivil;
use App\Models\CategoriaLicencias;
use App\Models\EntidadesEps;
use App\Models\EntidadesAfp;
use App\Models\AspiracionSalarial;
use App\Models\NivelEstudios;
use App\Models\TipoVehiculo;
use App\Models\TipoIdentificacion;
use App\Models\Parentesco;
use App\Models\Genero;
use App\Models\MotivoRetiro;
use App\Models\CargoGenerico;
use App\Models\ClaseLibreta;
use App\Models\PreguntaValidacion;
use DateTime;
use App\Models\Experiencias;
use \DB;
use App\Http\Requests;

class EntrevistaSemiController extends Controller
{
    public function index(Request $data)
    {

        $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->whereRaw(" (procesos_candidato_req.apto is null )  ")
            ->where("requerimiento_cantidato.estado_candidato", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
            ->where("procesos_candidato_req.estado", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
            ->where(function ($sql) use ($data) {
                //Filtro por codigo requerimiento
                if ($data->codigo != "") {
                    $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                }

                //Filtro por cedula de candidato
                if ($data->cedula != "") {
                    $sql->where("datos_basicos.numero_id", $data->cedula);
                }
            })
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_ENTREVISTA", "ENVIO_ENTREVISTA_PENDIENTE"])
            ->select("procesos_candidato_req.proceso", "procesos_candidato_req.id as ref_id", "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente')
            ->paginate(8);
        return view("admin.reclutamiento.entrevistas", compact("candidatos"));
    }

    public function gestionar_entrevista($id)
    {
        $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = '' )")
            ->where("procesos_candidato_req.id", $id)
            ->select("procesos_candidato_req.requerimiento_candidato_id", "procesos_candidato_req.id as ref_id", "datos_basicos.*", 'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente')
            ->first();

        $estados_procesos_referenciacion = RegistroProceso::
            join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_ENTREVISTA", "ENVIO_ENTREVISTA_PENDIENTE"])->get();

        $entrevistas = EntrevistaCandidatos::join("users", "users.id", "=", "entrevistas_candidatos.user_gestion_id")
            ->join("tipo_fuente", "tipo_fuente.id", "=", "entrevistas_candidatos.fuentes_publicidad_id")
            ->where("entrevistas_candidatos.candidato_id", $candidato->user_id)
            ->select("entrevistas_candidatos.*", "users.name", "tipo_fuente.descripcion as desc_fuente")
            ->orderBy("entrevistas_candidatos.created_at", "desc")
            ->get();

         $entrevistas_semi = EntrevistaSemi::join("users", "users.id", "=", "entrevistas_candidatos.user_gestion_id")
            ->where("entrevista_semi.candidato_id", $candidato->user_id)
            ->select("entrevista_semi.*", "users.name")
            ->orderBy("entrevista_semi.created_at", "desc")
            ->get();

        $req_prueba_gestionado = [];
        $req_gestion           = EntrevistaCandidatos::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "entrevistas_candidatos.id")
            ->select("entrevistas_candidatos.id")
            ->where("proceso_requerimiento.requerimiento_id", $candidato->requerimiento_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_ENTREVISTA")->get();

        foreach ($req_gestion as $key => $value) {
            array_push($req_prueba_gestionado, $value->id);
        }

        return view("admin.reclutamiento.gestionar_entrevista", compact("candidato", "entrevistas", "estados_procesos_referenciacion", "req_prueba_gestionado","entrevistas_semi"));
    }

    //Nueva entrevista
    public function nueva_entrevista(Request $data)
    {
        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){

            $req_id = $data->req_id;
        
            $proceso = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("users","users.id","=","requerimiento_cantidato.candidato_id")
            ->join("datos_basicos","datos_basicos.user_id","=","users.id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes","clientes.id","=","negocio.cliente_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))
            ->select("requerimiento_cantidato.requerimiento_id",
                "clientes.nombre",
                "cargos_especificos.descripcion as cargo_aspirado",
                "cargos_especificos.descripcion",
                "datos_basicos.user_id as user_id",
                "datos_basicos.numero_id",
                "datos_basicos.nombres as nombres",
                "datos_basicos.primer_apellido",
                "datos_basicos.segundo_apellido",
                "datos_basicos.fecha_nacimiento",
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                "datos_basicos.direccion",
                "datos_basicos.telefono_movil")
            ->first();

            $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.*", "niveles_estudios.descripcion as desc_nivel")
            ->where("estudios.user_id", $proceso->user_id)
            ->get();

            $experiencias = Experiencias::join("paises", "paises.cod_pais", "=", "experiencias.pais_id")
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
            })->where("experiencias.user_id", $proceso->user_id)
            ->select("aspiracion_salarial.descripcion as salario",
                "experiencias.id as id",
                "experiencias.personas_a_cargo",
                "experiencias.cant_a_cargo",
                "experiencias.dedicacion_empresa",
                "experiencias.fecha_inicio as fecha_inicio",
                "experiencias.fecha_final as fecha_final",
                "experiencias.nombre_empresa",
                "experiencias.duracion",
                "experiencias.nombres_jefe as jefe",
                "experiencias.cargo_jefe as cargo_jefe",
                "cargos_genericos.descripcion as desc_cargo", 
                "motivos_retiros.descripcion as desc_motivo",
                DB::raw('round(datediff(fecha_final,fecha_inicio)/12) as meses'),
                DB::raw('round(datediff(fecha_final,fecha_inicio)) as años'))
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->get();

            $familiares = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "profesiones.descripcion as profesion")
            ->where("grupos_familiares.user_id", $proceso->user_id)
            ->where('parentescos.id','11')
            ->get();

            $hijos = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.*",
             "tipos_documentos.descripcion as tipo_documento", 
             "escolaridades.descripcion as escolaridad", 
             "parentescos.descripcion as parentesco",
              "generos.descripcion as genero",
              DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'), 
              "profesiones.descripcion as profesion")
            ->where("grupos_familiares.user_id", $proceso->user_id)
            ->where('parentescos.id','10')
            ->get();
             
            $trabajo = "TRABAJO ACTUAL";
            
            $entrevistador=$this->user->name;
            $cargo_entrevistador=$this->user->cargo;

            //$cargo_entrevistador=$this->user->getDatosBasicos()->cargo_desempenado;
            
            $competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")
            ->where("competencias_cliente.cliente_id", $proceso->cliente_id)
            ->get();
           
            return view("admin.reclutamiento.modal.nueva_entrevista_semi", compact("trabajo","req_id","fuentes","proceso","estudios","experiencias","familiares","hijos","competencias","entrevistador","cargo_entrevistador"));

        }
        elseif(route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" ||
            route('home') == "https://nases.t3rsc.co" || route('home') == "http://nases.t3rsc.co" ||
            route("home") == "http://localhost:8000"){

            $req_id = $data->req_id;
            $ref_id = $data->ref_id;

            $proceso = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("users","users.id","=","requerimiento_cantidato.candidato_id")
            ->join("datos_basicos","datos_basicos.user_id","=","users.id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes","clientes.id","=","negocio.cliente_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))
            ->select(
                "requerimiento_cantidato.requerimiento_id",
                "clientes.nombre",
                "cargos_especificos.descripcion as cargo_aspirado",
                "cargos_especificos.descripcion",                
                "datos_basicos.user_id as user_id",
                "datos_basicos.numero_id",
                "datos_basicos.nombres as nombres",
                "datos_basicos.primer_apellido",
                "datos_basicos.segundo_apellido",
                "datos_basicos.fecha_nacimiento",
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                "datos_basicos.direccion",
                "datos_basicos.telefono_movil",
                "datos_basicos.telefono_fijo",
                "datos_basicos.email",
                "datos_basicos.barrio",
                "datos_basicos.pais_nacimiento",
                "datos_basicos.departamento_nacimiento",
                "datos_basicos.ciudad_nacimiento",
                "datos_basicos.pais_residencia",
                "datos_basicos.departamento_residencia",
                "datos_basicos.ciudad_residencia",
                "datos_basicos.estado_civil",
                "datos_basicos.clase_libreta",
                "datos_basicos.tiene_vehiculo",
                "datos_basicos.tipo_vehiculo",
                "datos_basicos.numero_licencia",
                "datos_basicos.categoria_licencia",
                "datos_basicos.talla_camisa",
                "datos_basicos.talla_pantalon",
                "datos_basicos.talla_zapatos",
                "datos_basicos.entidad_eps",
                "datos_basicos.entidad_afp",
                "datos_basicos.aspiracion_salarial",
                "datos_basicos.numero_hijos",
                "datos_basicos.numero_libreta",
                "datos_basicos.localidad"
            )
            ->first();

            $ciudadNacimiento = Ciudad::GetCiudad($proceso->pais_nacimiento,$proceso->departamento_nacimiento,$proceso->ciudad_nacimiento);
            $ciudadResidencia = Ciudad::GetCiudad($proceso->pais_residencia,$proceso->departamento_residencia,$proceso->ciudad_residencia);

            $estadoCivilSelect  = ["" => "Seleccionar"] + EstadoCivil::where("active", 1)->pluck("descripcion", "id")->toArray();
            $tipoVehiculo       = ["" => "Seleccionar"] + TipoVehiculo::where("active", 1)->pluck("descripcion", "id")->toArray();
            $categoriaLicencias = ["" => "Seleccionar"] + CategoriaLicencias::where("active", 1)->select(\DB::raw("CONCAT(codigo,' ',descripcion) as descripcion_categoria"), "id")->pluck("descripcion_categoria", "id")->toArray();
            $entidadesEps       = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->pluck("descripcion", "id")->toArray();
            $entidadesAfp       = ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->pluck("descripcion", "id")->toArray();
            $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();
            $tipos_documentos   = ["" => "Seleccionar"] + TipoIdentificacion::where("active", 1)->pluck("descripcion", "id")->toArray();
            $parentesco = ["" => "Seleccionar"] + Parentesco::where("active", 1)->pluck("descripcion", "id")->toArray();

            $motivoRetiro = ["" => "Seleccionar"] + MotivoRetiro::where("active", "1")->pluck("descripcion", "id")->except("id", 5)->toArray();
            $cargoGenerico = ["" => "Seleccionar"] + CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();

            $genero = ["" => "Seleccionar"] + Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
            $claseLibreta       = ["" => "Seleccionar"] + ClaseLibreta::where("active", 1)->pluck("descripcion", "id")->toArray();

            $talla_zapatos = [
                ""=>"Seleccionar",
                "32"=>"32",
                "35"=>"35",
                "36"=>"36",
                "37"=>"37",
                "38"=>"38",
                "39"=>"39",
                "40"=>"40",
                "41"=>"41",
                "42"=>"42",
                "43"=>"43",
                "44"=>"44",
                "45"=>"45",
            ];

            $talla_camisa = [
                ""=>"Seleccionar",
                "XS"=>"XS",
                "S"=>"S",
                "M"=>"M",
                "L"=>"L",
                "XL"=>"XL",
            ];

            $talla_pantalon = [
                ""      => "Seleccionar",
                "4-5"   => "4-5", 
                "6-7"   => "6-7",
                "8-9"   => "8-9",
                "10-11" => "10-11",
                "12-13" => "12-13",
                "14-15" => "14-15",
                "16-17" => "16-17",
                "18-19" => "18-19",
                "28-29" => "28-29",
                "29-30" => "29-30",
                "30-31" => "30-31",
                "31-32" => "31-32",
                "32-33" => "32-33",
                "33-34" => "33-34",
                "34-35" => "34-35",
                "35-36" => "35-36",
                "36-37" => "36-37",
            ];

            $familiares = GrupoFamilia::leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.*", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "profesiones.descripcion as profesion")
            ->where("grupos_familiares.user_id", $proceso->user_id)
            ->get();

            $hijos = GrupoFamilia::where("grupos_familiares.parentesco_id", 2)->where('user_id', $proceso->user_id)->count();

            $estudioReciente = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select(
                "estudios.titulo_obtenido",
                "niveles_estudios.descripcion as desc_nivel"
            )
            ->orderBy("estudios.fecha_finalizacion", "desc")
            ->where("estudios.user_id", $proceso->user_id)
            ->first();

            $nivelesEstudios = NivelEstudios::all()->except([6,7,8,9,10,11]);

            $primaria = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.fecha_finalizacion")
            ->where("estudios.user_id", $proceso->user_id)
            ->where("estudios.nivel_estudio_id", 2)
            ->first();

            $secundaria = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.fecha_finalizacion")
            ->where("estudios.user_id", $proceso->user_id)
            ->where("estudios.nivel_estudio_id", 1)
            ->first();

            $tecnico = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.fecha_finalizacion")
            ->where("estudios.user_id", $proceso->user_id)
            ->where("estudios.nivel_estudio_id", 3)
            ->first();

            $tecnologo = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.fecha_finalizacion")
            ->where("estudios.user_id", $proceso->user_id)
            ->where("estudios.nivel_estudio_id", 4)
            ->first();

            $universidad = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.fecha_finalizacion")
            ->where("estudios.user_id", $proceso->user_id)
            ->where("estudios.nivel_estudio_id", 5)
            ->first();

            $experiencias = Experiencias::join('aspiracion_salarial', 'aspiracion_salarial.id', '=', 'experiencias.salario_devengado')
            ->join('motivos_retiros', 'motivos_retiros.id', '=', 'experiencias.motivo_retiro')
            ->where("experiencias.user_id", $proceso->user_id)
            ->select('experiencias.*','aspiracion_salarial.descripcion as salario_cand','motivos_retiros.descripcion as motivo_retiro_cand')
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->get();

            $trabajo = "TRABAJO ACTUAL";
            
            $entrevistador=$this->user->name;
            $cargo_entrevistador=$this->user->cargo;
            
            $competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")
            ->where("competencias_cliente.cliente_id", $proceso->cliente_id)
            ->get();

            //Buscar respuestas del usuario
            $preg_val = PreguntaValidacion::where('user_id', $proceso->user_id)->first();
           
            return view("admin.reclutamiento.modal.nueva_entrevista_semi", compact("trabajo","req_id","ref_id","proceso","estudios","experiencias","familiares","competencias","entrevistador","cargo_entrevistador","ciudadNacimiento","ciudadResidencia","entidadesEps","entidadesAfp","aspiracionSalarial","estudioReciente","nivelesEstudios","estudios","estadoCivilSelect","tipoVehiculo","categoriaLicencias","talla_camisa","talla_pantalon","talla_zapatos","tipos_documentos","parentesco","genero","motivoRetiro","cargoGenerico","claseLibreta",'primaria','secundaria','tecnico','tecnologo','universidad','hijos','preg_val'));

        }
        else{
            
            $req_id = $data->req_id;

            $proceso = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("users","users.id","=","requerimiento_cantidato.candidato_id")
            ->join("datos_basicos","datos_basicos.user_id","=","users.id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes","clientes.id","=","negocio.cliente_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))
            ->select("requerimiento_cantidato.requerimiento_id",
                "clientes.nombre",
                "cargos_especificos.descripcion as cargo_aspirado",
                "cargos_especificos.descripcion",
                "datos_basicos.user_id as user_id",
                "datos_basicos.numero_id",
                "datos_basicos.nombres as nombres",
                "datos_basicos.primer_apellido",
                "datos_basicos.segundo_apellido",
                "datos_basicos.fecha_nacimiento",
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                "datos_basicos.direccion",
                "datos_basicos.telefono_movil")
            ->first();

            $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.*", "niveles_estudios.descripcion as desc_nivel")
            ->where("estudios.user_id", $proceso->user_id)
            ->get();

            $experiencias = Experiencias::join("paises", "paises.cod_pais", "=", "experiencias.pais_id")
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
            })->where("experiencias.user_id", $proceso->user_id)
            ->select("aspiracion_salarial.descripcion as salario",
                "experiencias.id as id",
                "cargos_genericos.descripcion as desc_cargo", 
                "motivos_retiros.descripcion as desc_motivo",
                DB::raw("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS ciudades"), 
                DB::raw('round(datediff(fecha_final,fecha_inicio)/12) as meses'),
                DB::raw('round(datediff(fecha_final,fecha_inicio)) as años'))
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->get();

            $familiares = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "profesiones.descripcion as profesion")
            ->where("grupos_familiares.user_id", $proceso->user_id)
            ->where('parentescos.id','11')
            ->get();

            $hijos = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.*",
                "tipos_documentos.descripcion as tipo_documento", 
                "escolaridades.descripcion as escolaridad", 
                "parentescos.descripcion as parentesco",
                "generos.descripcion as genero",
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'), 
                "profesiones.descripcion as profesion")
            ->where("grupos_familiares.user_id", $proceso->user_id)
            ->where('parentescos.id','10')
            ->get();
             
            $trabajo = "TRABAJO ACTUAL";
            
            //$entrevistador=$this->user->name;
            //$cargo_entrevistador=$this->user->cargo;

            //$cargo_entrevistador=$this->user->getDatosBasicos()->cargo_desempenado;
            
            $competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")
            ->where("competencias_cliente.cliente_id", $proceso->cliente_id)
            ->get();
           
            return view("admin.reclutamiento.modal.nueva_entrevista_semi", compact("trabajo","req_id","fuentes","proceso","estudios","experiencias","familiares","hijos","competencias"));

        }
    }

    //Guardar entrevista
    public function guardar_entrevista(Request $data)
    {
        $proceso = RegistroProceso::where("procesos_candidato_req.id", $data->get("ref_id"))->first();
        
        $nueva_entrevista = new EntrevistaSemi();

        if(route('home') == "https://komatsu.t3rsc.co" || route('home') == "http://komatsu.t3rsc.co") {

            $this->validate($data, [
                'info_general'      =>  'required',
                'fortalezas'        =>  'required',
                'opor_mejora'       =>  'required',
                'motivacion'        =>  'required',
                'expectativas'      =>  'required',
                'conflicto'         =>  'required',
                'expectativas'      =>  'required',
                'apto'              =>  'required',
                'continua'          =>  'required',
                'tentativo'         =>  'required',
            ]);

            $nueva_entrevista->fill([
                'info_general'       =>  $data->info_general,
                'fortalezas'         =>  $data->fortalezas,
                'opor_mejora'        =>  $data->opor_mejora,
                'idioma_1'           =>  $data->idioma_1,
                'nivel_1'            =>  $data->nivel_1,
                'idioma_2'           =>  $data->idioma_2,
                'nivel_2'            =>  $data->nivel_2,
                'herramientas'       =>  $data->herramientas,
                'otras_herramientas' =>  $data->otras_herramientas,
                'motivacion'         =>  $data->motivacion,
                'expectativas'       =>  $data->expectativas,
                'conflicto'          =>  $data->conflicto,
                'conflicto_entrevistador'          =>  $data->conflicto_entrevistador,
                'comentarios_entrevistado'  => $data->comentarios_entrevistado,
                'comentarios_entrevistador' => $data->comentarios_entrevistador,
                'apto'               =>  $data->apto,
                'continua'           =>  $data->continua,
                'tentativo'          =>  $data->tentativo,
                'justificacion'      =>  $data->justificacion,
            ]
            + ["candidato_id" => $proceso->candidato_id, "user_gestion_id" => $this->user->id]);

            $nueva_entrevista->save();
                
        }elseif(route('home') == "https://demo.t3rsc.co" || route('home') == "http://demo.t3rsc.co" || 
            route('home') == "https://nases.t3rsc.co" || route('home') == "http://nases.t3rsc.co" ||
            route('home') == "http://localhost:8000"){

            $this->validate($data, [
                'fecha_diligenciamiento'   => 'required',
                /*'pregunta_validacion_1'    => 'required',
                'pregunta_validacion_2'    => 'required',
                'pregunta_validacion_3'    => 'required',
                'pregunta_validacion_4'    => 'required',
                'pregunta_validacion_5'    => 'required',
                'pregunta_validacion_6'    => 'required',
                'pregunta_validacion_7'    => 'required',
                'pregunta_validacion_8'    => 'required',
                'pregunta_validacion_9'    => 'required',
                'pregunta_validacion_10'   => 'required',*/
                'autorizacion'             => 'required',
                'concepto_final_preg_1'    => 'required',
                'concepto_final_preg_2'    => 'required',
                'concepto_final_preg_3'    => 'required',
                'concepto_final'           => 'required',
                'apto'                     =>  'required'
            ]);

            $datos_basicos = DatosBasicos::where('user_id', $data->user_id)->first();

            //Guarda entrevista semi datos
            $nueva_entrevista->fill([
                'fecha_diligenciamiento'   => $data->fecha_diligenciamiento,
                'observacion_experiencia'  => $data->observacion_experiencia,
                'observacion_familiar'     => $data->observacion_familiar,
                'observacion_libreta'      => $data->observacion_libreta,
                'observacion_hijos'        => $data->observacion_hijos,
                'observacion_estudios'     => $data->observacion_estudios,
                'pregunta_validacion_1'    => $data->pregunta_validacion_1,
                'pregunta_validacion_2'    => $data->pregunta_validacion_2,
                'pregunta_validacion_3'    => $data->pregunta_validacion_3,
                'pregunta_validacion_4'    => $data->pregunta_validacion_4,
                'pregunta_validacion_5'    => $data->pregunta_validacion_5,
                'pregunta_validacion_6'    => $data->pregunta_validacion_6,
                'pregunta_validacion_7'    => $data->pregunta_validacion_7,
                'pregunta_validacion_8'    => $data->pregunta_validacion_8,
                'pregunta_validacion_9'    => $data->pregunta_validacion_9,
                'pregunta_validacion_10'   => $data->pregunta_validacion_10,
                'autorizacion'             => $data->autorizacion,
                'observacion_preguntas'    => $data->observacion_preguntas,
                'concepto_final_preg_1'    => $data->concepto_final_preg_1,
                'concepto_final_preg_2'    => $data->concepto_final_preg_2,
                'concepto_final_preg_3'    => $data->concepto_final_preg_3,
                'concepto_final'           => $data->concepto_final,
                'nombre_entrevistador'     => $data->nombre_entrevistador,
                'apto'                     => $data->apto,
                'req_id'                   => $data->req_id,
            ]
            + ["candidato_id" => $proceso->candidato_id, "user_gestion_id" => $this->user->id]);

            $nueva_entrevista->save();

            if($data->has('valor_multa') && $data->pregunta_validacion_8 == 1){
                $nueva_entrevista->valor_multa = $data->valor_multa;
                $nueva_entrevista->save();
            }

            if($data->has('valor_reporte') && $data->pregunta_validacion_9 == 1){
                $nueva_entrevista->valor_reporte = $data->valor_reporte;
                $nueva_entrevista->save();
            }

            if($data->has('empresa_trabajo') && $data->pregunta_validacion_10 == 1){
                $nueva_entrevista->empresa_trabajo = $data->empresa_trabajo;
                $nueva_entrevista->save();
            }

            //Actualiza datos basicos usuario
            $datos_basicos->numero_id                = $data->numero_id;
            $datos_basicos->fecha_nacimiento         = $data->fecha_nacimiento;
            $datos_basicos->pais_nacimiento          = $data->pais_nacimiento;
            $datos_basicos->departamento_nacimiento  = $data->departamento_nacimiento;
            $datos_basicos->ciudad_nacimiento        = $data->ciudad_nacimiento;
            $datos_basicos->pais_residencia          = $data->pais_residencia;
            $datos_basicos->departamento_residencia  = $data->departamento_residencia;
            $datos_basicos->ciudad_residencia        = $data->ciudad_residencia;
            $datos_basicos->direccion                = $data->direccion;
            $datos_basicos->barrio                   = $data->barrio;
            $datos_basicos->telefono_movil           = $data->telefono_movil;
            $datos_basicos->telefono_fijo            = $data->telefono_fijo;
            $datos_basicos->email                    = $data->email;
            $datos_basicos->estado_civil             = $data->estado_civil;
            $datos_basicos->tiene_vehiculo           = $data->tiene_vehiculo;
            $datos_basicos->tipo_vehiculo            = $data->tipo_vehiculo;
            $datos_basicos->categoria_licencia       = $data->categoria_licencia;
            $datos_basicos->talla_camisa             = $data->talla_camisa;
            $datos_basicos->talla_pantalon           = $data->talla_pantalon;
            $datos_basicos->talla_zapatos            = $data->talla_zapatos;
            $datos_basicos->entidad_eps              = $data->entidad_eps;
            $datos_basicos->entidad_afp              = $data->entidad_afp;
            $datos_basicos->aspiracion_salarial      = $data->aspiracion_salarial;
            $datos_basicos->numero_hijos             = $data->numero_hijos;
            $datos_basicos->localidad                = $data->localidad;
            $datos_basicos->save();

            if($data->tiene_licencia == 1){
                $datos_basicos->numero_licencia      = $data->numero_licencia;
            }elseif($data->tiene_licencia == 0 || $data->tiene_licencia == ""){
                $datos_basicos->numero_licencia      = null;
            }

            if($data->militar_situacion == 1){
                $datos_basicos->numero_libreta       = $data->numero_libreta;
                $datos_basicos->clase_libreta        = $data->clase_libreta;
            }elseif($data->militar_situacion == 0 || $data->militar_situacion == ""){
                $datos_basicos->numero_libreta       = null;
                $datos_basicos->clase_libreta        = null;
            }

            $datos_basicos->save();

            $empty_array = array("");

            if($data->nombres_familiar != $empty_array){
                //Nuevo grupo familiar
                for ($i = 0; $i < count($data->nombres_familiar); $i++) {

                    $grupoFamiliar = new GrupoFamilia();

                    $grupoFamiliar->fill([
                        'numero_id'            => $data->numero_id,
                        'user_id'              => $data->user_id,
                        //'tipo_documento'       => null,
                        //'documento_identidad'  => null,
                        'nombres'              => $data->nombres_familiar[$i],
                        'primer_apellido'      => $data->primer_apellido_familiar[$i],
                        'segundo_apellido'     => $data->segundo_apellido_familiar[$i],
                        'parentesco_id'        => $data->parentesco_id[$i],
                        'fecha_nacimiento'     => $data->fecha_nacimiento_familiar[$i],
                        'genero'               => $data->genero[$i],
                        'convive'              => $data->convive[$i],
                        'celular_contacto'     => $data->telefono_familiar[$i]
                    ]);

                    $grupoFamiliar->save();

                }
            }

            if($data->nombre_empresa != $empty_array){
                //Nueva experiencia
                for ($i = 0; $i < count($data->nombre_empresa); $i++) {

                    $experienciaCand = new Experiencias();

                    $experienciaCand->fill([
                        'numero_id'            => $data->numero_id,
                        'user_id'              => $data->user_id,
                        'telefono_temporal'    => $data->telefono_temporal[$i],
                        'nombre_empresa'       => $data->nombre_empresa[$i],
                        'cargo_desempenado'    => $data->cargo_desempenado[$i],
                        'nombres_jefe'         => $data->nombres_jefe[$i],
                        'cargo_jefe'           => $data->cargo_jefe[$i],
                        'movil_jefe'           => $data->movil_jefe[$i],
                        'empleo_actual'        => $data->empleo_actual[$i],
                        'fecha_inicio'         => $data->fecha_inicio_exp[$i],
                        'salario_devengado'    => $data->salario_devengado[$i],
                        'cargo_especifico'     => $data->cargo_especifico[$i],
                        'pais_id'              => $data->pais_experiencia[$i],
                        'departamento_id'      => $data->departamento_experiencia[$i],
                        'ciudad_id'            => $data->ciudad_experiencia[$i],
                        'autoriza_solicitar_referencias' => 1,
                        'trabajo_temporal' => 0
                    ]);

                    $experienciaCand->save();

                    if($data->empleo_actual[$i] == 1){
                        $experienciaCand->fecha_final = $data->fecha_final_exp[$i];
                        $experienciaCand->motivo_retiro = $data->motivo_retiro[$i];

                        $experienciaCand->save();

                    }elseif($data->empleo_actual[$i] == 0){
                        $experienciaCand->fecha_final = null;
                        $experienciaCand->motivo_retiro = null;

                        $experienciaCand->save();
                    }

                }
            }

            //Estudios
            if($data->primaria_culminado != ''){
                
                $primaria = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
                ->select("estudios.fecha_finalizacion")
                ->where("estudios.user_id", $data->user_id)
                ->where("estudios.nivel_estudio_id", 2)
                ->first();

                if(count($primaria) <= 0){

                    $newEstudio = new Estudios();

                    $newEstudio->fill([
                        'numero_id'          => $data->numero_id,
                        'user_id'            => $data->user_id,
                        'nivel_estudio_id'   => 2,
                        'fecha_finalizacion' => $data->fecha_culminacion_primaria
                    ]);

                    $newEstudio->save();

                }else{
                    if($data->primaria_culminado == 1){
                        $primaria->fecha_finalizacion  = $data->fecha_culminacion_primaria;
                        $primaria->save();
                    }elseif($data->primaria_culminado == 0){
                        $primaria->fecha_finalizacion  = null;
                        $primaria->save();
                    }
                }
            }

            if($data->secundaria_culminado != ''){
                
                $secundaria = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
                ->select("estudios.fecha_finalizacion")
                ->where("estudios.user_id", $data->user_id)
                ->where("estudios.nivel_estudio_id", 1)
                ->first();

                if(count($secundaria) <= 0){

                    $newEstudio = new Estudios();

                    $newEstudio->fill([
                        'numero_id'          => $data->numero_id,
                        'user_id'            => $data->user_id,
                        'nivel_estudio_id'   => 1,
                        'fecha_finalizacion' => $data->fecha_culminacion_secundaria
                    ]);

                    $newEstudio->save();

                }else{
                    if($data->secundaria_culminado == 1){
                        $secundaria->fecha_finalizacion  = $data->fecha_culminacion_secundaria;
                        $secundaria->save();
                    }else{
                        $secundaria->fecha_finalizacion  = null;
                        $secundaria->save();
                    }
                }
            }

            if($data->tecnico_culminado != ''){
                
                $tecnico = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
                ->select("estudios.fecha_finalizacion")
                ->where("estudios.user_id", $data->user_id)
                ->where("estudios.nivel_estudio_id", 3)
                ->first();

                if(count($tecnico) <= 0){

                    $newEstudio = new Estudios();

                    $newEstudio->fill([
                        'numero_id'          => $data->numero_id,
                        'user_id'            => $data->user_id,
                        'nivel_estudio_id'   => 3,
                        'fecha_finalizacion' => $data->fecha_culminacion_tecnico
                    ]);

                    $newEstudio->save();

                }else{
                    if($data->tecnico_culminado == 1){
                        $tecnico->fecha_finalizacion  = $data->fecha_culminacion_tecnico;
                        $tecnico->save();
                    }else{
                        $tecnico->fecha_finalizacion  = null;
                        $tecnico->save();
                    }
                }
            }

            if($data->tecnol_culminado != ''){
                
                $tecnologo = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
                ->select("estudios.fecha_finalizacion")
                ->where("estudios.user_id", $data->user_id)
                ->where("estudios.nivel_estudio_id", 4)
                ->first();

                if(count($tecnologo) <= 0){

                    $newEstudio = new Estudios();

                    $newEstudio->fill([
                        'numero_id'          => $data->numero_id,
                        'user_id'            => $data->user_id,
                        'nivel_estudio_id'   => 4,
                        'fecha_finalizacion' => $data->fecha_culminacion_tecnol
                    ]);

                    $newEstudio->save();

                }else{
                    if($data->tecnol_culminado == 1){
                        $tecnologo->fecha_finalizacion  = $data->fecha_culminacion_tecnol;
                        $tecnologo->save();
                    }else{
                        $tecnologo->fecha_finalizacion  = null;
                        $tecnologo->save();
                    }
                }
            }

            if($data->univ_culminado != ''){
                
                $universidad = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
                ->select("estudios.fecha_finalizacion")
                ->where("estudios.user_id", $data->user_id)
                ->where("estudios.nivel_estudio_id", 5)
                ->first();

                if(count($universidad) <= 0){

                    $newEstudio = new Estudios();

                    $newEstudio->fill([
                        'numero_id'          => $data->numero_id,
                        'user_id'            => $data->user_id,
                        'nivel_estudio_id'   => 5,
                        'fecha_finalizacion' => $data->fecha_culminacion_univ
                    ]);

                    $newEstudio->save();

                }else{
                    if($data->univ_culminado == 1){
                        $universidad->fecha_finalizacion  = $data->fecha_culminacion_univ;
                        $universidad->save();
                    }else{
                        $universidad->fecha_finalizacion  = null;
                        $universidad->save();
                    }
                }
            }

            //Actualizar observación de experiencia
            if(count($data->id_experiencia) > 0){
                for ($i = 0; $i < count($data->id_experiencia); $i++) {
                    $update_exp = Experiencias::where('id', $data->id_experiencia[$i])->first();
                    if($data->observacion_experiencia_one[$i] != ''){
                        $update_exp->observacion_experiencia = $data->observacion_experiencia_one[$i];
                        $update_exp->save();
                    }
                }
            }

        }else{

            $this->validate($data, [
                'enfermedades' => 'required',
                'cirugias' => 'required',
                'alergias' => 'required',
                //'grupo_social' => 'required',
                'fortalezas' => 'required',
                'opor_mejora' => 'required',
                'proyectos' => 'required',
                'valores' => 'required',
                'candidato_idoneo' => 'required',
                'concepto_entre' => 'required',
            ]);

            $nueva_entrevista->fill([
                'enfermedades'             =>$data->enfermedades,
                'cirugias'   =>$data->cirugias,
                'alergias'   =>$data->alergias,
                'grupo_social'   =>$data->grupo_social,
                'descrip_social'   =>$data->descrip_social,
                'fortalezas'   =>$data->fortalezas,
                'opor_mejora'   =>$data->opor_mejora,
                'proyectos'   =>$data->proyectos,
                'aplazado'   =>$data->aplazado,
                'otros_trabajos'   =>$data->otros_trabajos,
                'pendiente'   =>$data->pendiente,
                'valores'   =>$data->valores,
                'req_id'   =>$data->req_id,
                'candidato_idoneo'   =>$data->candidato_idoneo,
                'concepto_entre'   =>$data->concepto_entre,
                'apto'                     => $data->apto
            ]

            + ["candidato_id" => $proceso->candidato_id, "user_gestion_id" => $this->user->id]);
            $nueva_entrevista->save();

        }

        if(isset($data->exp_id)){

            for($i = 0; $i < count($data->exp_id); $i++){

                $exp=Experiencias::find($data->exp_id[$i]);

                $exp->fill([
                    'cantidad_empleados'=>$data->num_empleados[$i],
                    'dedicacion_empresa'=>$data->dedicacion_empresa[$i],
                    'motivo_retiro_txt'=>$data->motivo_retiro[$i],
                    //'personas_a_cargo'=>$data->personas_a_cargo[$i],
                    'cant_a_cargo'=>$data->cant_a_cargo[$i],
                    'duracion'=>$data->duracion[$i]
                ]);

                $exp->save();
            }

        }

        //NUEVAS EXPERIENCIAS
        if(isset($data->n_empresa)){
         
            for($i = 0; $i < 5; $i++){
           
                if(!empty($data->n_empresa[$i])){
         
                    $exp = new Experiencias();

                    $exp->fill([
                        'nombre_empresa'=>$data->n_empresa[$i],
                        'cantidad_empleados'=>$data->num_empleados[$i],
                        'user_id'=>$proceso->candidato_id,
                        'empleo_actual'=>0,
                        'salario_devengado'=>1,
                        'autoriza_solicitar_referencias'=>1,
                        'cargo_desempenado'=>$data->n_cargo_desem[$i],
                        'nombres_jefe'=>$data->n_jefe[$i],
                        //'cargo_jefe'=>$data->n_cargo_jefe[$i],
                        'motivo_retiro_txt'=>$data->n_motivo_retiro[$i],
                        //'motivo_retiro'=>$data->n_motivo_retiro[$i],
                        'funciones_logros'=>$data->n_logros[$i],
                        'cantidad_empleados'=>$data->n_num_empleados[$i],
                        'dedicacion_empresa'=> $data->n_dedicacion_empresa[$i],
                        'personas_a_cargo'=> $data->n_personas_a_cargo[$i],
                        'cant_a_cargo'=> $data->n_cant_a_cargo[$i],
                        'numero_id'=> $data->numero_id,
                        'duracion'=> $data->n_duracion[$i],
                    ]);
                
                    $exp->save();
            
                }

            }

        }

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
                    "tipo_entidad"              => "MODULO_ENTREVISTA_SEMIESTRUCTURDA",
                ]);
                $calificacion->save();

            }

        }

        $final = 0;

        if($data->definitiva != null){

            $final = 1;

            $apto = $data->get("apto");

            if($apto == null){
                $apto = 0;
            }

            $proceso->fill([
                "apto"                => $apto,
                "usuario_terminacion" => $this->user->id,
                "observaciones"       => $data->get("concepto_general"),
            ]);

            $proceso->save();

            //SI SELECCIONAN EL ESTADO PENDIENTE SE CREA UN NUEVO REGISTRO
            //SI EL ESTADO ES NO APTO SE RECHAZA EL CANDIDATO
        }

        //GUARDAR_ RELACION PRUEBA REQUERIMIENTO
        $this->procesoRequerimiento($nueva_entrevista->id, $data->get("ref_id"), "MODULO_ENTREVISTA_SEMIESTRUCTURDA");

        return response()->json(["success" => true,"final"=>$final]);
    }

    public function detalle_entrevista_modal_semi(Request $data)
    {
        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
            
            $entrevista = EntrevistaSemi::find($data->get("entre_id"));
            $entrevistador=User::find($entrevista->user_gestion_id);

            $competenciasEvaluadas = CalificaCompetencia::where("entidad_id", $entrevista->id)->where("tipo_entidad", "MODULO_ENTREVISTA_SEMIESTRUCTURDA")->get();
            
            $arrayValores          = [];
            $arrayDescripcion      = [];
            
            foreach ($competenciasEvaluadas as $key => $value) {
                $arrayValores[$value->competencia_entrevista_id]     = $value->valor;
                $arrayDescripcion[$value->competencia_entrevista_id] = $value->descripcion;
            }

            $entrevista->competencia = $arrayValores;
            $entrevista->descripcion = $arrayDescripcion;

            $proceso = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))
            ->first();

            $proceso = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("users","users.id","=","requerimiento_cantidato.candidato_id")
            ->join("datos_basicos","datos_basicos.user_id","=","users.id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes","clientes.id","=","negocio.cliente_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))
            ->select("requerimiento_cantidato.requerimiento_id",
                "clientes.nombre",
                "cargos_especificos.descripcion as cargo_aspirado",
                "datos_basicos.user_id as user_id",

                "datos_basicos.numero_id",
                "datos_basicos.nombres",
                "datos_basicos.primer_apellido",
                "datos_basicos.segundo_apellido",
                "datos_basicos.fecha_nacimiento",
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                "datos_basicos.direccion",
                "datos_basicos.telefono_movil")
            ->first();

            $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.*", "niveles_estudios.descripcion as desc_nivel")
            ->where("estudios.user_id", $proceso->user_id)
            ->get();

            $experiencias = Experiencias::leftjoin("paises", "paises.cod_pais", "=", "experiencias.pais_id")
            ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
            ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
            //->join("departamentos", function ($join) {
            //  $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
            //    ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
            //})->join("ciudad", function ($join2) {
            //$join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
            //.cod_ciudad", "=", "experiencias.ciudad_id")
            //->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
            // })
            ->where("experiencias.user_id", $proceso->user_id)
            ->select("aspiracion_salarial.descripcion as salario",
                "experiencias.fecha_inicio as fecha_inicio",
                "experiencias.fecha_final as fecha_final",
                "experiencias.nombre_empresa",
                "experiencias.personas_a_cargo",
                "experiencias.cant_a_cargo",
                "experiencias.cantidad_empleados",
                "experiencias.dedicacion_empresa",
                "cargos_genericos.descripcion as desc_cargo", 
                "motivos_retiros.descripcion as desc_motivo",
                // DB::raw("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS ciudades"), 
                DB::raw('round(datediff(fecha_final,fecha_inicio)/12) as meses'),
                DB::raw('round(datediff(fecha_final,fecha_inicio)) as años'))
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->get();

            $familiares = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "profesiones.descripcion as profesion")
            ->where("grupos_familiares.user_id", $proceso->user_id)
            ->where('parentescos.id','11')
            ->get();

            $hijos = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.*",
             "tipos_documentos.descripcion as tipo_documento", 
             "escolaridades.descripcion as escolaridad", 
             "parentescos.descripcion as parentesco",
              "generos.descripcion as genero",
              DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'), 
              "profesiones.descripcion as profesion")
            ->where("grupos_familiares.user_id", $proceso->user_id)
            ->where('parentescos.id','10')
            ->get();

            $competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")->
            where("competencias_cliente.cliente_id", $proceso->cliente_id)
            ->get();

            $trabajo = "TRABAJO ACTUAL";

            return view("admin.reclutamiento.modal.detalle_entrevista_semi", compact("trabajo","entrevista","proceso","estudios","experiencias","familiares","hijos","competencias","entrevistador"));

        }elseif(route('home') == "https://demo.t3rsc.co" || route('home') == "http://demo.t3rsc.co" ||
            route('home') == "https://nases.t3rsc.co" || route('home') == "http://nases.t3rsc.co" ||
            route('home') == "http://localhost:8000"){

            $entrevista = EntrevistaSemi::find($data->get("entre_id"));

            $entrevistador = User::find($entrevista->user_gestion_id);

            $proceso = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("users","users.id","=","requerimiento_cantidato.candidato_id")
            ->join("datos_basicos","datos_basicos.user_id","=","users.id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes","clientes.id","=","negocio.cliente_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))
            ->select(
                "requerimiento_cantidato.requerimiento_id",
                "clientes.nombre",
                "cargos_especificos.descripcion as cargo_aspirado",
                "cargos_especificos.descripcion",                
                "datos_basicos.user_id as user_id",
                "datos_basicos.numero_id",
                "datos_basicos.nombres as nombres",
                "datos_basicos.primer_apellido",
                "datos_basicos.segundo_apellido",
                "datos_basicos.fecha_nacimiento",
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                "datos_basicos.direccion",
                "datos_basicos.telefono_movil",
                "datos_basicos.telefono_fijo",
                "datos_basicos.email",
                "datos_basicos.barrio",
                "datos_basicos.pais_nacimiento",
                "datos_basicos.departamento_nacimiento",
                "datos_basicos.ciudad_nacimiento",
                "datos_basicos.pais_residencia",
                "datos_basicos.departamento_residencia",
                "datos_basicos.ciudad_residencia",
                "datos_basicos.estado_civil",
                "datos_basicos.clase_libreta",
                "datos_basicos.tiene_vehiculo",
                "datos_basicos.tipo_vehiculo",
                "datos_basicos.numero_licencia",
                "datos_basicos.categoria_licencia",
                "datos_basicos.talla_camisa",
                "datos_basicos.talla_pantalon",
                "datos_basicos.talla_zapatos",
                "datos_basicos.entidad_eps",
                "datos_basicos.entidad_afp",
                "datos_basicos.aspiracion_salarial",
                "datos_basicos.numero_hijos",
                "datos_basicos.numero_libreta",
                "datos_basicos.localidad"
            )
            ->first();

            $todo = array();
            $todo[] = $entrevista;
            $todo[] = $proceso;

            $ciudadNacimiento = Ciudad::GetCiudad($proceso->pais_nacimiento,$proceso->departamento_nacimiento,$proceso->ciudad_nacimiento);
            $ciudadResidencia = Ciudad::GetCiudad($proceso->pais_residencia,$proceso->departamento_residencia,$proceso->ciudad_residencia);

            $estadoCivilSelect  = ["" => "Seleccionar"] + EstadoCivil::where("active", 1)->pluck("descripcion", "id")->toArray();
            $tipoVehiculo       = ["" => "Seleccionar"] + TipoVehiculo::where("active", 1)->pluck("descripcion", "id")->toArray();
            $categoriaLicencias = ["" => "Seleccionar"] + CategoriaLicencias::where("active", 1)->select(\DB::raw("CONCAT(codigo,' ',descripcion) as descripcion_categoria"), "id")->pluck("descripcion_categoria", "id")->toArray();
            $entidadesEps       = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->pluck("descripcion", "id")->toArray();
            $entidadesAfp       = ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->pluck("descripcion", "id")->toArray();
            $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();
            $tipos_documentos   = ["" => "Seleccionar"] + TipoIdentificacion::where("active", 1)->pluck("descripcion", "id")->toArray();
            $parentesco = ["" => "Seleccionar"] + Parentesco::where("active", 1)->pluck("descripcion", "id")->toArray();

            $motivoRetiro = ["" => "Seleccionar"] + MotivoRetiro::where("active", "1")->pluck("descripcion", "id")->except("id", 5)->toArray();
            $cargoGenerico = ["" => "Seleccionar"] + CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();

            $genero = ["" => "Seleccionar"] + Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
            $claseLibreta       = ["" => "Seleccionar"] + ClaseLibreta::where("active", 1)->pluck("descripcion", "id")->toArray();

            $talla_zapatos = [
                ""=>"Seleccionar",
                "32"=>"32",
                "35"=>"35",
                "36"=>"36",
                "37"=>"37",
                "38"=>"38",
                "39"=>"39",
                "40"=>"40",
                "41"=>"41",
                "42"=>"42",
                "43"=>"43",
                "44"=>"44",
                "45"=>"45",
            ];

            $talla_camisa = [
                ""=>"Seleccionar",
                "XS"=>"XS",
                "S"=>"S",
                "M"=>"M",
                "L"=>"L",
                "XL"=>"XL",
            ];

            $talla_pantalon = [
                ""=>"Seleccionar",
                "28-29"=>"28-29",
                "29-30"=>"29-30",
                "30-31"=>"30-31",
                "31-32"=>"31-32",
                "32-33"=>"32-33",
                "33-34"=>"33-34",
                "34-35"=>"34-35",
                "35-36"=>"35-36",
                "36-37"=>"36-37",
            ];

            $familiares = GrupoFamilia::leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.*", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "profesiones.descripcion as profesion")
            ->where("grupos_familiares.user_id", $proceso->user_id)
            ->get();

            $estudioReciente = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select(
                "estudios.titulo_obtenido",
                "niveles_estudios.descripcion as desc_nivel"
            )
            ->orderBy("estudios.fecha_finalizacion", "desc")
            ->where("estudios.user_id", $proceso->user_id)
            ->first();

            $nivelesEstudios = NivelEstudios::all()->except([6,7,8,9,10,11]);

            $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select(
                "estudios.nivel_estudio_id",
                "estudios.titulo_obtenido",
                "estudios.estudio_actual",
                "estudios.fecha_finalizacion",
                "niveles_estudios.*"
            )
            ->orderBy("estudios.fecha_finalizacion", "desc")
            ->where("estudios.user_id", $proceso->user_id)
            ->get();

            $experiencias = Experiencias::join('aspiracion_salarial', 'aspiracion_salarial.id', '=', 'experiencias.salario_devengado')
            ->join('motivos_retiros', 'motivos_retiros.id', '=', 'experiencias.motivo_retiro')
            ->where("experiencias.user_id", $proceso->user_id)
            ->select('experiencias.*','aspiracion_salarial.descripcion as salario_cand','motivos_retiros.descripcion as motivo_retiro_cand')
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->get();

            $trabajo = "TRABAJO ACTUAL";
            
            $entrevistador=$this->user->name;
            $cargo_entrevistador=$this->user->cargo;
            
            $competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")
            ->where("competencias_cliente.cliente_id", $proceso->cliente_id)
            ->get();

            $primaria = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.fecha_finalizacion")
            ->where("estudios.user_id", $proceso->user_id)
            ->where("estudios.nivel_estudio_id", 2)
            ->first();

            $secundaria = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.fecha_finalizacion")
            ->where("estudios.user_id", $proceso->user_id)
            ->where("estudios.nivel_estudio_id", 1)
            ->first();

            $tecnico = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.fecha_finalizacion")
            ->where("estudios.user_id", $proceso->user_id)
            ->where("estudios.nivel_estudio_id", 3)
            ->first();

            $tecnologo = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.fecha_finalizacion")
            ->where("estudios.user_id", $proceso->user_id)
            ->where("estudios.nivel_estudio_id", 4)
            ->first();

            $universidad = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.fecha_finalizacion")
            ->where("estudios.user_id", $proceso->user_id)
            ->where("estudios.nivel_estudio_id", 5)
            ->first();

            return view("admin.reclutamiento.modal.detalle_entrevista_semi", compact("trabajo","req_id","estudios","experiencias","familiares","competencias","entrevistador","cargo_entrevistador","ciudadNacimiento","ciudadResidencia","entidadesEps","entidadesAfp","aspiracionSalarial","estudioReciente","nivelesEstudios","estadoCivilSelect","tipoVehiculo","categoriaLicencias","talla_camisa","talla_pantalon","talla_zapatos","tipos_documentos","parentesco","genero","motivoRetiro","cargoGenerico","claseLibreta","todo",'primaria','secundaria','tecnico','tecnologo','universidad'));

        }else{

            $entrevista = EntrevistaSemi::find($data->get("entre_id"));
            //$entrevistador=User::find($entrevista->user_gestion_id);

            $competenciasEvaluadas = CalificaCompetencia::where("entidad_id", $entrevista->id)->where("tipo_entidad", "MODULO_ENTREVISTA_SEMIESTRUCTURDA")->get();
            
            $arrayValores          = [];
            $arrayDescripcion      = [];

            foreach ($competenciasEvaluadas as $key => $value) {
                $arrayValores[$value->competencia_entrevista_id]     = $value->valor;
                $arrayDescripcion[$value->competencia_entrevista_id] = $value->descripcion;
            }

            $entrevista->competencia = $arrayValores;
            $entrevista->descripcion = $arrayDescripcion;

            $proceso = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))
            ->first();

            $proceso = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("users","users.id","=","requerimiento_cantidato.candidato_id")
            ->join("datos_basicos","datos_basicos.user_id","=","users.id")
            ->join("requerimientos", "requerimientos.id", "=", "procesos_candidato_req.requerimiento_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes","clientes.id","=","negocio.cliente_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))
            ->select("requerimiento_cantidato.requerimiento_id",
                "clientes.nombre",
                "cargos_especificos.descripcion as cargo_aspirado",
                "datos_basicos.user_id as user_id",

                "datos_basicos.numero_id",
                "datos_basicos.nombres",
                "datos_basicos.primer_apellido",
                "datos_basicos.segundo_apellido",
                "datos_basicos.fecha_nacimiento",
                DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'),
                "datos_basicos.direccion",
                "datos_basicos.telefono_movil")
            ->first();

            $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->select("estudios.*", "niveles_estudios.descripcion as desc_nivel")
            ->where("estudios.user_id", $proceso->user_id)
            ->get();

            $experiencias = Experiencias::join("paises", "paises.cod_pais", "=", "experiencias.pais_id")
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

            })->where("experiencias.user_id", $proceso->user_id)
            ->select("aspiracion_salarial.descripcion as salario",
                "experiencias.fecha_inicio as fecha_inicio",
                "experiencias.fecha_final as fecha_final",
                "experiencias.nombre_empresa",
                "cargos_genericos.descripcion as desc_cargo", 
                "motivos_retiros.descripcion as desc_motivo",
                DB::raw("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS ciudades"), 
                DB::raw('round(datediff(fecha_final,fecha_inicio)/12) as meses'),
                DB::raw('round(datediff(fecha_final,fecha_inicio)) as años'))
            ->orderBy("experiencias.fecha_inicio", "desc")
            ->get();

            $familiares = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero", "profesiones.descripcion as profesion")
            ->where("grupos_familiares.user_id", $proceso->user_id)
            ->where('parentescos.id','11')
            ->get();

            $hijos = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->leftJoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->leftJoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->leftJoin("generos", "generos.id", "=", "grupos_familiares.genero")
            ->leftJoin("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("grupos_familiares.*",
             "tipos_documentos.descripcion as tipo_documento", 
             "escolaridades.descripcion as escolaridad", 
             "parentescos.descripcion as parentesco",
              "generos.descripcion as genero",
              DB::raw('round(datediff(now(),fecha_nacimiento)/365) as edad'), 
              "profesiones.descripcion as profesion")
            ->where("grupos_familiares.user_id", $proceso->user_id)
            ->where('parentescos.id','10')
            ->get();

            $competencias = CompetenciaCliente::join("competencias_entrevistas", "competencias_entrevistas.id", "=", "competencias_cliente.competencia_entrevista_id")
            ->where("competencias_cliente.cliente_id", $proceso->cliente_id)
            ->get();

            $trabajo = "TRABAJO ACTUAL";

            return view("admin.reclutamiento.modal.detalle_entrevista_semi", compact("trabajo","entrevista","proceso","estudios","experiencias","familiares","hijos","competencias","entrevistador"));

        }
    }

    public function actualizar_entrevista_semi(Request $data)
    {
        $ae = EntrevistaSemi::find($data->get("id"));

        if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="http://komatsu.t3rsc.co"){
             
            $ae->fill([
                'info_general'  => $data->info_general,
                'conflicto'             =>$data->conflicto,
                'conflicto_entrevistador'             =>$data->conflicto_entrevistador,
                'motivacion'   =>$data->motivacion,
                'expectativas'   =>$data->expectativas,
                'comentarios_entrevistado'   =>$data->comentarios_entrevistado,
                'comentarios_entrevistador'   =>$data->comentarios_entrevistador,
                'fortalezas'   =>$data->fortalezas,
                'opor_mejora'   =>$data->opor_mejora,
                'justificacion'   =>$data->justificacion,
                'tentativo'   =>$data->tentativo,
                'apto'        => $data->apto,
                'idioma_1'  => $data->idioma_1,
                'nivel_1'  => $data->nivel_1,
                'idioma_2'  => $data->idioma_2,
                'nivel_2'  => $data->nivel_2,
                'herramientas'  => $data->herramientas,
                'otras_herramientas' =>$data->otras_herramientas,
                'duracion'=> $data->duracion[$i],
                'continua' => $data->continua
            ]);

            $ae->save();

            if(isset($data->exp_id)){

                for($i=0;$i<count($data->exp_id);$i++){
                    $exp=Experiencias::find($data->exp_id[$i]);
                    $exp->fill([
                        'cantidad_empleados'=>$data->num_empleados[$i],
                        'dedicacion_empresa'=>$data->dedicacion_empresa[$i],
                        'motivo_retiro_txt'=>$data->motivo_retiro[$i],
                        //'personas_a_cargo'=>$data->personas_a_cargo[$i],
                        'cant_a_cargo'=>$data->cant_a_cargo[$i]
                    ]);
                    $exp->save();
                }

            }
        
        }elseif(route('home') == "https://demo.t3rsc.co" || route('home') == "http://demo.t3rsc.co" ||
            route('home') == "https://nases.t3rsc.co" || route('home') == "http://nases.t3rsc.co" ||
            route('home') == "http://localhost:8000"){

            $datos_basicos = DatosBasicos::where('user_id', $data->candidato_id)->first();

            $ae->fill([
                'observacion_experiencia'  => $data->observacion_experiencia,
                'observacion_familiar'     => $data->observacion_familiar,
                'observacion_libreta'      => $data->observacion_libreta,
                'observacion_hijos'        => $data->observacion_hijos,
                'observacion_estudios'     => $data->observacion_estudios,
                'pregunta_validacion_1'    => $data->pregunta_validacion_1,
                'pregunta_validacion_2'    => $data->pregunta_validacion_2,
                'pregunta_validacion_3'    => $data->pregunta_validacion_3,
                'pregunta_validacion_4'    => $data->pregunta_validacion_4,
                'pregunta_validacion_5'    => $data->pregunta_validacion_5,
                'pregunta_validacion_6'    => $data->pregunta_validacion_6,
                'pregunta_validacion_7'    => $data->pregunta_validacion_7,
                'pregunta_validacion_8'    => $data->pregunta_validacion_8,
                'pregunta_validacion_9'    => $data->pregunta_validacion_9,
                'pregunta_validacion_10'   => $data->pregunta_validacion_10,
                'autorizacion'             => $data->autorizacion,
                'observacion_preguntas'    => $data->observacion_preguntas,
                'concepto_final_preg_1'    => $data->concepto_final_preg_1,
                'concepto_final_preg_2'    => $data->concepto_final_preg_2,
                'concepto_final_preg_3'    => $data->concepto_final_preg_3,
                'concepto_final'           => $data->concepto_final,
                'nombre_entrevistador'     => $data->nombre_entrevistador,
                'apto'                     =>  $data->apto
            ]);

            $ae->save();

            if($data->has('valor_multa') && $data->pregunta_validacion_8 == 1){
                $ae->valor_multa = $data->valor_multa;
                $ae->save();
            }else{
                $ae->valor_multa = null;
                $ae->save();
            }

            if($data->has('valor_reporte') && $data->pregunta_validacion_9 == 1){
                $ae->valor_reporte = $data->valor_reporte;
                $ae->save();
            }else{
                $ae->valor_reporte = null;
                $ae->save();
            }

            if($data->has('empresa_trabajo') && $data->pregunta_validacion_10 == 1){
                $ae->empresa_trabajo = $data->empresa_trabajo;
                $ae->save();
            }else{
                $ae->empresa_trabajo = null;
                $ae->save();
            }

            //Actualiza datos basicos usuario
            $datos_basicos->numero_id                = $data->numero_id;
            $datos_basicos->fecha_nacimiento         = $data->fecha_nacimiento;
            $datos_basicos->pais_nacimiento          = $data->pais_nacimiento;
            $datos_basicos->departamento_nacimiento  = $data->departamento_nacimiento;
            $datos_basicos->ciudad_nacimiento        = $data->ciudad_nacimiento;
            $datos_basicos->pais_residencia          = $data->pais_residencia;
            $datos_basicos->departamento_residencia  = $data->departamento_residencia;
            $datos_basicos->ciudad_residencia        = $data->ciudad_residencia;
            $datos_basicos->direccion                = $data->direccion;
            $datos_basicos->barrio                   = $data->barrio;
            $datos_basicos->telefono_movil           = $data->telefono_movil;
            $datos_basicos->telefono_fijo            = $data->telefono_fijo;
            $datos_basicos->email                    = $data->email;
            $datos_basicos->estado_civil             = $data->estado_civil;
            $datos_basicos->tiene_vehiculo           = $data->tiene_vehiculo;
            $datos_basicos->tipo_vehiculo            = $data->tipo_vehiculo;
            $datos_basicos->categoria_licencia       = $data->categoria_licencia;
            $datos_basicos->talla_camisa             = $data->talla_camisa;
            $datos_basicos->talla_pantalon           = $data->talla_pantalon;
            $datos_basicos->talla_zapatos            = $data->talla_zapatos;
            $datos_basicos->entidad_eps              = $data->entidad_eps;
            $datos_basicos->entidad_afp              = $data->entidad_afp;
            $datos_basicos->aspiracion_salarial      = $data->aspiracion_salarial;
            $datos_basicos->numero_hijos             = $data->numero_hijos;
            $datos_basicos->localidad                = $data->localidad;
            $datos_basicos->save();

            if($data->tiene_licencia == 1){
                $datos_basicos->numero_licencia      = $data->numero_licencia;
            }elseif($data->tiene_licencia == 0 || $data->tiene_licencia == ""){
                $datos_basicos->numero_licencia      = null;
            }

            if($data->militar_situacion == 1){
                $datos_basicos->numero_libreta       = $data->numero_libreta;
                $datos_basicos->clase_libreta        = $data->clase_libreta;
            }elseif($data->militar_situacion == 0 || $data->militar_situacion == ""){
                $datos_basicos->numero_libreta       = null;
                $datos_basicos->clase_libreta        = null;
            }

            $datos_basicos->save();

            $empty_array = array("");

            if($data->nombres_familiar != $empty_array){
                //Nuevo grupo familiar
                for ($i = 0; $i < count($data->nombres_familiar); $i++) {

                    $grupoFamiliar = new GrupoFamilia();

                    $grupoFamiliar->fill([
                        'numero_id'            => $data->numero_id,
                        'user_id'              => $data->candidato_id,
                        //'tipo_documento'       => null,
                        //'documento_identidad'  => null,
                        'nombres'              => $data->nombres_familiar[$i],
                        'primer_apellido'      => $data->primer_apellido_familiar[$i],
                        'segundo_apellido'     => $data->segundo_apellido_familiar[$i],
                        'parentesco_id'        => $data->parentesco_id[$i],
                        'fecha_nacimiento'     => $data->fecha_nacimiento_familiar[$i],
                        'genero'               => $data->genero[$i],
                        'convive'              => $data->convive[$i],
                        'celular_contacto'     => $data->telefono_familiar[$i]
                    ]);

                    $grupoFamiliar->save();

                }
            }

            if($data->nombre_empresa != $empty_array){

                for ($i = 0; $i < count($data->nombre_empresa); $i++) {

                    $experienciaCand = new Experiencias();

                    $experienciaCand->fill([
                        'numero_id'            => $data->numero_id,
                        'user_id'              => $data->candidato_id,
                        'telefono_temporal'    => $data->telefono_temporal[$i],
                        'nombre_empresa'       => $data->nombre_empresa[$i],
                        'cargo_desempenado'    => $data->cargo_desempenado[$i],
                        'nombres_jefe'         => $data->nombres_jefe[$i],
                        'cargo_jefe'           => $data->cargo_jefe[$i],
                        'movil_jefe'           => $data->movil_jefe[$i],
                        'empleo_actual'        => $data->empleo_actual[$i],
                        'fecha_inicio'         => $data->fecha_inicio_exp[$i],
                        'salario_devengado'    => $data->salario_devengado[$i],
                        'cargo_especifico'     => $data->cargo_especifico[$i],
                        'pais_id'              => $data->pais_experiencia[$i],
                        'departamento_id'      => $data->departamento_experiencia[$i],
                        'ciudad_id'            => $data->ciudad_experiencia[$i],
                        'autoriza_solicitar_referencias' => 1,
                        'trabajo_temporal' => 0
                    ]);

                    $experienciaCand->save();

                    if($data->empleo_actual[$i] == 1){
                        $experienciaCand->fecha_final = $data->fecha_final_exp[$i];
                        $experienciaCand->motivo_retiro = $data->motivo_retiro[$i];

                        $experienciaCand->save();

                    }elseif($data->empleo_actual[$i] == 0){
                        $experienciaCand->fecha_final = null;
                        $experienciaCand->motivo_retiro = null;

                        $experienciaCand->save();
                    }

                }

            }

            //Estudios
            if($data->primaria_culminado != ''){
                
                $primaria = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
                ->select("estudios.fecha_finalizacion")
                ->where("estudios.user_id", $data->user_id)
                ->where("estudios.nivel_estudio_id", 2)
                ->first();

                if(count($primaria) <= 0){

                    $newEstudio = new Estudios();

                    $newEstudio->fill([
                        'numero_id'          => $data->numero_id,
                        'user_id'            => $data->user_id,
                        'nivel_estudio_id'   => 2,
                        'fecha_finalizacion' => $data->fecha_culminacion_primaria
                    ]);

                    $newEstudio->save();

                }else{
                    if($data->primaria_culminado == 1){
                        $primaria->fecha_finalizacion  = $data->fecha_culminacion_primaria;
                        $primaria->save();
                    }else{
                        $primaria->fecha_finalizacion  = null;
                        $primaria->save();
                    }
                }
            }

            if($data->secundaria_culminado != ''){
                
                $secundaria = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
                ->select("estudios.fecha_finalizacion")
                ->where("estudios.user_id", $data->user_id)
                ->where("estudios.nivel_estudio_id", 1)
                ->first();

                if(count($secundaria) <= 0){

                    $newEstudio = new Estudios();

                    $newEstudio->fill([
                        'numero_id'          => $data->numero_id,
                        'user_id'            => $data->user_id,
                        'nivel_estudio_id'   => 1,
                        'fecha_finalizacion' => $data->fecha_culminacion_secundaria
                    ]);

                    $newEstudio->save();

                }else{
                    if($data->secundaria_culminado == 1){
                        $secundaria->fecha_finalizacion  = $data->fecha_culminacion_secundaria;
                        $secundaria->save();
                    }else{
                        $secundaria->fecha_finalizacion  = null;
                        $secundaria->save();
                    }
                }
            }

            if($data->tecnico_culminado != ''){
                
                $tecnico = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
                ->select("estudios.fecha_finalizacion")
                ->where("estudios.user_id", $data->user_id)
                ->where("estudios.nivel_estudio_id", 3)
                ->first();

                if(count($tecnico) <= 0){

                    $newEstudio = new Estudios();

                    $newEstudio->fill([
                        'numero_id'          => $data->numero_id,
                        'user_id'            => $data->user_id,
                        'nivel_estudio_id'   => 3,
                        'fecha_finalizacion' => $data->fecha_culminacion_tecnico
                    ]);

                    $newEstudio->save();

                }else{
                    if($data->tecnico_culminado == 1){
                        $tecnico->fecha_finalizacion  = $data->fecha_culminacion_tecnico;
                        $tecnico->save();
                    }else{
                        $tecnico->fecha_finalizacion  = null;
                        $tecnico->save();
                    }
                }
            }

            if($data->tecnol_culminado != ''){
                
                $tecnologo = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
                ->select("estudios.fecha_finalizacion")
                ->where("estudios.user_id", $data->user_id)
                ->where("estudios.nivel_estudio_id", 4)
                ->first();

                if(count($tecnologo) <= 0){

                    $newEstudio = new Estudios();

                    $newEstudio->fill([
                        'numero_id'          => $data->numero_id,
                        'user_id'            => $data->user_id,
                        'nivel_estudio_id'   => 4,
                        'fecha_finalizacion' => $data->fecha_culminacion_tecnol
                    ]);

                    $newEstudio->save();

                }else{
                    if($data->tecnol_culminado == 1){
                        $tecnologo->fecha_finalizacion  = $data->fecha_culminacion_tecnol;
                        $tecnologo->save();
                    }else{
                        $tecnologo->fecha_finalizacion  = null;
                        $tecnologo->save();
                    }
                }
            }

            if($data->univ_culminado != ''){
                
                $universidad = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
                ->select("estudios.fecha_finalizacion")
                ->where("estudios.user_id", $data->user_id)
                ->where("estudios.nivel_estudio_id", 5)
                ->first();

                if(count($universidad) <= 0){

                    $newEstudio = new Estudios();

                    $newEstudio->fill([
                        'numero_id'          => $data->numero_id,
                        'user_id'            => $data->user_id,
                        'nivel_estudio_id'   => 5,
                        'fecha_finalizacion' => $data->fecha_culminacion_univ
                    ]);

                    $newEstudio->save();

                }else{
                    if($data->univ_culminado == 1){
                        $universidad->fecha_finalizacion  = $data->fecha_culminacion_univ;
                        $universidad->save();
                    }else{
                        $universidad->fecha_finalizacion  = null;
                        $universidad->save();
                    }
                }
            }

            //Actualizar observación de experiencia
            if(count($data->id_experiencia) > 0){
                for ($i = 0; $i < count($data->id_experiencia); $i++) {
                    $update_exp = Experiencias::where('id', $data->id_experiencia[$i])->first();
                    if($data->observacion_experiencia_one[$i] != ''){
                        $update_exp->observacion_experiencia = $data->observacion_experiencia_one[$i];
                        $update_exp->save();
                    }
                }
            }

        }else{

            $ae->fill([
                'enfermedades'             =>$data->enfermedades,
                'cirugias'   =>$data->cirugias,
                'alergias'   =>$data->alergias,
                'grupo_social'   =>$data->grupo_social,
                'descrip_social'   =>$data->descrip_social,
                'fortalezas'   =>$data->fortalezas,
                'opor_mejora'   =>$data->opor_mejora,
                'proyectos'   =>$data->proyectos,
                'aplazado'   =>$data->aplazado,
                'otros_trabajos'   =>$data->otros_trabajos,
                'pendiente'   =>$data->pendiente,
                'valores'   =>$data->valores,
                'candidato_idoneo'   =>$data->candidato_idoneo,
                'concepto_entre'   =>$data->concepto_entre,
                'apto'                     => $data->apto
            ]);
        
            $ae->save(); 
        
            // Actualizar Competencias Candidato
            if ($data->has("competencia")) {

                $descripciones = $data->get("descripcion");
                
                foreach ($data->get("competencia") as $key => $value) {
                    $ac = CalificaCompetencia::where("entidad_id", $data->get("id"))
                    ->where("competencia_entrevista_id", $key)
                    ->first();
                    
                    $ac->fill([
                        "competencia_entrevista_id" => $key,
                        "valor"                     => $value,
                        "descripcion"               => $descripciones[$key],
                    ]);

                    $ac->save();
                }
            }
        
        }

       return back()->withInput();
    }

    public function registra_proceso_entidad(Request $data)
    {
        $ae = EntrevistaSemi::find($data->prueba_id);

        $ae->fill(["activo"  => "0"]);
        $ae->save();
    }

    public function registra_proceso_entidad2(Request $data)
    {
        $ae = EntrevistaSemi::find($data->prueba_id);

        $ae->fill(["activo"  => "1"]);
        $ae->save();        
    }


}
