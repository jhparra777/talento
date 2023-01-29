<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Archivo_hv;
use App\Models\Autoentrevist;
use App\Models\AspiracionSalarial;
use App\Models\CategoriaLicencias;
use App\Models\Ciudad;
use App\Models\ClaseLibreta;
use App\Models\DatosBasicos;
use App\Models\DireccionDian;
use App\Models\Documentos;
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
use App\Models\NivelAcademico;
use App\Models\NomenclaturaDian;
use App\Models\Pais;
use App\Models\NivelIdioma;
use App\Models\IdiomaUsuario;
use App\Models\Parentesco;
use App\Models\Perfilamiento;
use App\Models\Profesiones;
use App\Models\ReferenciasPersonales;
use App\Models\Sitio;
use App\Models\TipoCargo;
use App\Models\TipoDocumento;
use App\Models\TipoIdentificacion;
use App\Models\TipoRelacion;
use App\Models\TipoVehiculo;
use App\Models\User;
use App\Models\DocumentoFamiliar;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\CajaCompensacion;
use App\Jobs\FuncionesGlobales;
use Event;
use App\Events\PorcentajeHvEvent;
use Illuminate\Support\Facades\Mail;
use triPostmaster;
use App\Models\Bancos;

class NuevaHvAdminController extends Controller
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

        $this->tipoDocumento += TipoIdentificacion::where("active", 1)->pluck("descripcion", "id")->toArray();
        $this->escolaridad += Escolaridad::where("active", 1)->pluck("descripcion", "id")->toArray();
        $this->parentesco += Parentesco::where("active", 1)->pluck("descripcion", "id")->toArray();
        $this->genero += Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
        $this->profesion += Profesiones::where("active", 1)->pluck("descripcion", "id")->toArray();
    }

    #//Nueva Hoja de Vida
    public function datos_basicos(Request $data)
    {
        #//Datos Basicos
        $tipos_documentos   = ["" => "Seleccionar"] + TipoIdentificacion::where("active", 1)->pluck("descripcion", "id")->toArray();
        $estadoCivil        = ["" => "Seleccionar"] + EstadoCivil::where("active", 1)->pluck("descripcion", "id")->toArray();
        $genero             = ["" => "Seleccionar"] + Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();
        $claseLibreta       = ["" => "Seleccionar"] + ClaseLibreta::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoVehiculo       = ["" => "Seleccionar"] + TipoVehiculo::where("active", 1)->pluck("descripcion", "id")->toArray();
        $categoriaLicencias = ["" => "Seleccionar"] + CategoriaLicencias::where("active", 1)->select(\DB::raw("CONCAT(codigo,' ',descripcion) as descripcion_categoria"), "id")->pluck("descripcion_categoria", "id")->toArray();
        $entidadesEps       = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->pluck("descripcion", "id")->toArray();
        $entidadesAfp       = ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->pluck("descripcion", "id")->toArray();

        $nivel_academico = ["" => "Seleccionar"];

        if(route("home") == "https://humannet.t3rsc.co"){
        //para humannet nivel estudio
         $nivel_academico = ["" => "Seleccionar"] + NivelAcademico::orderBy('descripcion')->pluck("descripcion", "id")->toArray();
        }

        $talla_zapatos = [
            "" => "Seleccionar",
            "32" => "32",
            "35" => "35",
            "36" => "36",
            "37" => "37",
            "38" => "38",
            "39" => "39",
            "40" => "40",
            "41" => "41",
            "42" => "42",
            "43" => "43",
            "44" => "44",
            "45" => "45",
        ];

        $talla_camisa = [
            "" => "Seleccionar",
            "XS" => "XS",
            "S" => "S",
            "M" => "M",
            "L" => "L",
            "XL" => "XL",
        ];

        $talla_pantalon = [
            "" => "Seleccionar",
            "4-5" => "4-5", 
            "6-7" => "6-7",
            "8-9" => "8-9",
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

        $letras = [
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
        
        $tipo_via = [
            "" => "Seleccionar",
            "AU" => "Autopista ",
            "AV" => "Avenida ",
            "AC" => "Avenida Calle ",
            "AK" => "Avenida Carrera ",
            "BL" => "Bulevar ",
            "CL" => "Calle ",
            "KR" => "Carrera ",
            "CT" => "Carretera ",
            "CQ" => "Circular ",
            "CV" => "Circunvalar ",
            "CC" => "Cuentas Corridas ",
            "DG" => "Diagonal ",
            "PJ" => "Pasaje ",
            "PS" => "Paseo ",
            "PT" => "Peatonal ",
            "TV" => "Transversal ",
            "TC" => "Troncal ",
            "VT" => "Variante ",
            "VI" => "Vía"
        ];

        $txtLugarNacimiento = "";
        $txtLugarExpedicion = "";
        $txtLugarResidencia = "";

        #//Estudios
        $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        ->select("estudios.*", "niveles_estudios.descripcion as descripcion_nivel")
        ->where("user_id", $this->user->id)
        ->get();

        $nivelEstudios = ["" => "Seleccionar"] + NivelEstudios::pluck("descripcion", "id")->toArray();

        #//Experiencia
        $experiencias       = Experiencias::where("user_id", $this->user->id)->get();
        $motivos            = ["" => "Seleccionar"] + MotivoRetiro::where("active", "1")->pluck("descripcion", "id")->toArray();
        $cargoGenerico      = ["" => "Seleccionar"] + Profesiones::where("active", 1)->pluck("descripcion", "id")->toArray();
        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();

        #//Referencia Personal
        $referencias = ReferenciasPersonales::join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
        ->join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
        ->join("departamentos", function ($join) {
        $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
            ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
            ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
            ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })
        ->select(
            "referencias_personales.*", 
            "tipo_relaciones.descripcion as relacion", 
            \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada")
        )
        ->where("referencias_personales.user_id", $this->user->id)
        ->get();

        $tipoRelaciones = ["" => "Seleccionar"] + TipoRelacion::pluck("descripcion", "id")->toArray();

        #//Grupo Familiar
        $selectores = $this;

        if(route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co") {
            $familiares = GrupoFamilia::join("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
            ->join("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
            ->join("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->join("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select(
                "grupos_familiares.*", 
                "tipos_documentos.descripcion as tipo_documento", 
                "escolaridades.descripcion as escolaridad", 
                "parentescos.descripcion as parentesco", 
                "generos.descripcion as genero"
            )->where("grupos_familiares.user_id", $this->user->id)
            ->get();
        }else {
            $familiares = GrupoFamilia::join("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
            ->join("generos", "generos.id", "=", "grupos_familiares.genero")
            ->select("grupos_familiares.*", "parentescos.descripcion as parentesco", "generos.descripcion as genero")
            ->where("grupos_familiares.user_id", $this->user->id)
            ->get();
        }

        #//Perfilamiento
        $tipo_cargos = TipoCargo::where("active", 1)->get();
        $sql_cargos_seleccionados = Perfilamiento::join("cargos_genericos", "cargos_genericos.id", "=", "perfilamiento.cargo_generico_id")
        ->join("tipos_cargos", "tipos_cargos.id", "=", "cargos_genericos.tipo_cargo_id")
        ->where("perfilamiento.user_id", $this->user->id)
        ->select("tipos_cargos.descripcion as tipo_cargo_name", "tipos_cargos.id as cargo_id", "cargos_genericos.*")
        ->get();

        $cargos_seleccionados = [];
        $items_cargos = [];

        foreach ($sql_cargos_seleccionados as $key => $value) {
            if(!array_key_exists($value->cargo_id, $cargos_seleccionados)) {
                $cargos_seleccionados[$value->cargo_id]         = [];
                $cargos_seleccionados[$value->cargo_id]["name"] = $value->tipo_cargo_name;
                $cargos_seleccionados[$value->cargo_id]["item"] = [];
            }

            array_push($items_cargos, $value->id);

            $cargos_seleccionados[$value->cargo_id]["item"][$value->id] = $value->descripcion;
          }

        return view("admin.hv.nueva_hoja_de_vida", compact(
            "txtLugarNacimiento",
            "txtLugarExpedicion",
            "txtLugarResidencia",
            "data",
            "letras",
            "tipos_documentos",
            "estadoCivil",
            "genero",
            "aspiracionSalarial",
            "claseLibreta",
            "tipoVehiculo",
            "categoriaLicencias",
            "entidadesEps",
            "entidadesAfp",
            "prefijo",
            "tipo_via",
            "nivelEstudios",
            "estudios",
            "experiencias",
            "motivos",
            "cargoGenerico",
            "aspiracionSalarial",
            "tipoRelaciones",
            "referencias",
            "familiares",
            "selectores",
            "tipo_cargos",
            "cargos_seleccionados",
            "items_cargos",
            "talla_zapatos",
            "talla_camisa",
            "talla_pantalon",
            "nivel_academico"
        ));
    }

    /*
     * Guardar datos básicos admin
    */
    public function nuevo_datos_basicos(Request $data)
    {
        $this->validate($data, [
            "numero_id"      => "unique:users,numero_id|required", 
            "email"          => "unique:users,email|email|required",
            //"password"       => "required",
            "primer_nombre"  => "required",
            "primer_apellido"  => "required",
            "telefono_movil" => "required|numeric",
            //"ciudad_expedicion_id" => "required",
            //"tipo_id"  => "required"
        ]);

        //Rregistro usuario
        $datos_registro = [
            "password"  => $data->get("numero_id"),
            "numero_id" => $data->get("numero_id"),
            "name" => $data->get("primer_nombre")." ".$data->get("segundo_nombre")." ".$data->get("primer_apellido")." ".$data->get("segundo_apellido")
        ] + $data->only("email");

        $user = Sentinel::register($datos_registro);

        //Crear activacion
        $activation = Activation::create($user);
        Activation::complete($user, $activation->code);

        //Agregar rol
        $role = Sentinel::findRoleBySlug('hv');
        $role->users()->attach($user);

        //Guardar datos basicos
        $datos_basicos = new DatosBasicos();

        $datos_basicos->fill($data->all() + [
            "user_id" => $user->id, 
            "usuario_cargo" => $this->user->id, 
            "estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO'), 
            "datos_basicos_count"  => "20"
        ]);
        $datos_basicos->nombres=$data->get("primer_nombre")." ".$data->get("segundo_nombre");
        //$datos_basicos->departamento_id = $data->departamento_expedicion_id;
        //$datos_basicos->ciudad_id = $data->ciudad_expedicion_id;

        if(route('home') == "https://gpc.t3rsc.co") {
            $datos_basicos->numero_hijos = $data->numero_hijos;
            $datos_basicos->edad_hijos = $data->edad_hijos;
            $datos_basicos->tipo_vivienda = $data->tipo_vivienda;
            $datos_basicos->tipo_vehiculo_t = $data->tipo_vehiculo_t;
            $datos_basicos->direccion_skype = $data->direccion_skype;
            $datos_basicos->otro_telefono = $data->otro_telefono;
            $datos_basicos->obj_personales = $data->obj_personales;
            $datos_basicos->obj_profesionales = $data->obj_profesionales;
            $datos_basicos->obj_academicos = $data->obj_academicos;
            $datos_basicos->horario_flexible = $data->horario_flexible;
            $datos_basicos->viaje_regional = $data->viaje_regional;
            $datos_basicos->viaje_internacional = $data->viaje_internacional;
            $datos_basicos->cambio_ciudad = $data->cambio_ciudad;
            $datos_basicos->cambio_pais = $data->cambio_pais;
            $datos_basicos->estado_salud = $data->estado_salud;
            $datos_basicos->conadis = $data->conadis;
            $datos_basicos->grado_disca = $data->grado_disca;
            $datos_basicos->sueldo_bruto = $data->sueldo_bruto;
            $datos_basicos->comision_bonos = $data->comision_bonos;
            $datos_basicos->otros_bonos = $data->otros_bonos;
            $datos_basicos->ingreso_anual = $data->ingreso_anual;
            $datos_basicos->otros_beneficios = $data->otros_beneficios;
        }

        if(route('home') == "https://humannet.t3rsc.co") {
            $datos_basicos->nivel_estudio = $data->nivel_estudio;
        }

        if(route('home') == "https://asuservicio.t3rsc.co") {
            $datos_basicos->estado_salud = $data->estado_salud;
        }

        $datos_basicos->save();

        $sitio = Sitio::first();
        $nombre = "Desarrollo";

        if(isset($sitio->nombre)){
              
            if($sitio->nombre != "") {
                $nombre = $sitio->nombre;
            }
        }

        //correo de bienvenida
        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Bienvenido a {$nombre} - T3RS"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "
                ¡Hola $datos_basicos->nombres $datos_basicos->primer_apellido $datos_basicos->segundo_apellido!
                <br/><br/>
                Se ha creado exitosamente tu cuenta en T3RS, te invitamos a ingresar usando tu número de documento como usuario y contraseña para completar tu hoja de vida y cargar tus documentos.
                ";

        //Arreglo para el botón
        $mailButton = ['buttonText' => '¡COMPLETA TU HOJA DE VIDA!', 'buttonRoute' => route('login')];

        $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $nombre, $sitio) {

                    $message->to($datos_basicos->email, $datos_basicos->nombres)
                            ->bcc($sitio->email_replica)
                            ->subject("Bienvenido a $nombre - T3RS")
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

        return redirect()->route("admin.actualizar_hv_admin", ["user_id" => $user->id])->with(["mensaje_success" => "Información guardada correctamente."]);
    }

    public function guardar_estudios(Request $data)
    {
        //Validar campos reqeuridos
        $validador = Validator::make($data->all(), [
            "nivel_estudio_id"   => "required_without_all:tiene_estudio",
            "titulo_obtenido"    => "required_without_all:tiene_estudio",
            "institucion"        => "required_without_all:tiene_estudio",
            "ciudad_estudio"     => "required_without_all:tiene_estudio",
            "fecha_inicio"       => "required_without_all:tiene_estudio"
        ]);

        $validador->sometimes('fecha_finalizacion', 'required_without_all:tiene_estudio', function($input) {
            return $input->estudio_actual != 1;
        });

        /**if ($validador->fails()) {
            $mensaje = "Información no guardada, Error. Campos con asterisco(*) son obligatorios.";

            return response()->json(["mensaje_success" => $mensaje, "success" => false, "errors" => $validador->messages()]);
        } */

        $tiene_estudio = 0;
        $estudio = null;

        //Guardar los datos
        if(!isset($data->tiene_estudio)){
            
            $tiene_estudio = 1;
            $estudios = new Estudios();
            $estudios->fill($data->except('id') + ["user_id" => $data->user_id, "numero_id" => $data->numero_id]);
            $estudios->save();

            //$estudio = Estudios::find($estudios->nivel_estudios_id);
        }else{
            /*borramos los estudios registrados por si tiene*/
            Estudios::where('user_id', $data->user_id)->delete();
        }

        /*$nivel = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        ->select("estudios.*", "niveles_estudios.descripcion as descripcion_nivel")
        ->where("user_id", $data->user_id)->orderBy('created_at', 'DESC')
        ->first();*/

        //$nivelEstudios = ["" => "Seleccionar"] + NivelEstudios::pluck("descripcion", "id")->toArray();

        $datos_basicos = DatosBasicos::where("user_id",$data->user_id)->first();
        $datos_basicos->estudios_count = 100;
        $datos_basicos->tiene_estudio = $tiene_estudio;
        $datos_basicos->save();

        return response()->json(["success" => true, "estudio" => $estudio, "rs" => $estudios, "tiene_estudio" => $tiene_estudio]);
    }

    public function guardar_experiencia(Request $data)
    {
        $datos_basicos = DatosBasicos::where("user_id", $data->user_id)->first();
            
        if(isset($data->tiene_experiencia)) {
            Experiencias::where('user_id', $data->user_id)->delete();

            $datos_basicos->tiene_experiencia = 0;
            $datos_basicos->experiencias_count = 100;
            $datos_basicos->save();

            $mensaje ="Se ha guardado correctamente sin experiencia!";

            return response()->json(["mensaje_success" => $mensaje, "success" => true, "rs" => '', "tiene_experiencia" => 0]);
        }else {
            if(route("home") != "https://gpc.t3rsc.co"){
                //Validar campos requerimientos
                $validador = Validator::make($data->all(),[
                    "nombre_empresa" => "required",
                    "cargo_desempenado" => "required",
                    "cargo_especifico" => "required",
                    "nombres_jefe" => "required",
                    "cargo_jefe" => "required",
                    //"movil_jefe"                => "numeric",
                    //"fijo_jefe"                 => "numeric",
                    "fecha_inicio" => "required|date",
                    "fecha_final" => "date|required_unless:empleo_actual,1|after:fecha_inicio",
                    "salario_devengado" => "required|numeric",
                    "motivo_retiro" => "required_unless:empleo_actual,1",
                    "ciudad_id" => "required",
                    //"telefono_temporal" => "numeric",
                ]);
            }else {
                $validador = Validator::make($data->all(), [
                    "nombre_empresa"            => "required",
                    //"autocompletado_residencia" => "required",
                    "cargo_desempenado"  =>  "required",
                    // "cargo_especifico"          => "required",
                    //"nombres_jefe"              => "required",
                    //"cargo_jefe"                => "required",
                    //"movil_jefe"                => "numeric",
                    //"fijo_jefe"                 => "numeric",
                    "fecha_inicio"              => "required|date",
                    "fecha_final"               => "date|required_unless:empleo_actual,1|after:fecha_inicio",
                    "salario_devengado"         => "required|numeric",
                    "motivo_retiro"             => "required_unless:empleo_actual,1",
                    "funciones_logros" => "required",
                    "logros" => "required"
                    //"ciudad_id"                 => "required",
                    //"telefono_temporal"         => "numeric",
                ]);
            }

            if($validador->fails()) {
                $mensaje = "Información no guardada, Error. Campos con asterisco(*) son obligatorios.";
                return response()->json(["mensaje_success" => $mensaje, "success" => false, "errors" => $validador->messages()]);
            }

            $nuevaExperiencia = new Experiencias();
            $campos           = $data->all();

            if (!$data->has("empleo_actual")) {
                $campos["empleo_actual"] = "0";
            }

            if (!$data->has("trabajo_temporal")) {
                $campos["trabajo_temporal"] = "0";
            }

            if (!$data->has("autoriza_solicitar_referencias")) {
                $campos["autoriza_solicitar_referencias"] = "0";
            }

            $nuevaExperiencia->fill($campos + ["user_id" => $data->user_id, "numero_id" => $data->numero_id]);

            if(route("home") == "https://gpc.t3rsc.co") {
                $nuevaExperiencia->linea_negocio = $data->linea_negocio; 
                $nuevaExperiencia->tipo_compania = $data->tipo_compania; 
                $nuevaExperiencia->ventas_empresa = $data->ventas_empresa; 
                $nuevaExperiencia->num_colaboradores = $data->num_colaboradores; 
                $nuevaExperiencia->otro_cargo = $data->otro_cargo; 
                $nuevaExperiencia->logros = $data->logros;
                $nuevaExperiencia->tiempo_cargo = $data->tiempo_cargo;
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
                    $nuevaExperiencia->fecha_final            = $data->fecha_inicio;
                }
            }

            $nuevaExperiencia->save();

            $datos_basicos = DatosBasicos::where("user_id",$data->user_id)->first();
            $datos_basicos->experiencias_count = 100;
            $datos_basicos->tiene_experiencia = 1;
            $datos_basicos->save();

            return response()->json(["success" => true, "rs" => $nuevaExperiencia, "tiene_experiencia" => 1]);
        }
    }

    public function guardar_referencia(Request $data)
    {
        //Validar campos reqeuridos
        $validador = Validator::make($data->all(), ["nombres" => "required"]);

        if($validador->fails()){
            $mensaje = "Información no guardada, Error. Campos con asterisco(*) son obligatorios.";

            return response()->json(["mensaje_danger" => $mensaje, "success" => false, "error" => $validador->messages()]);
        }

        $referencia = new ReferenciasPersonales();

        $campos = $data->all();
        $campos["user_id"] = $data->user_id;
        $campos["numero_id"] = $data->numero_id;
        $referencia->fill($campos);

        if(route('home') == "https://gpc.t3rsc.co") {
            $referencia->empresa = $data->empresa;
            $referencia->correo  = $data->correo;
            $referencia->cargo   = $data->cargo;
        }

        $referencia->save();

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
        ->where("ciudad.cod_ciudad", $referencia->codigo_ciudad)
        ->first();

        $datos_basicos = DatosBasicos::where("user_id",$data->user_id)->first();
        $datos_basicos->referencias_count = 100;
        $datos_basicos->save();

        return response()->json(["ciudad" => $ciudad, "referencia" => $referencia, "relacionTipo" => $relacionTipo, "success" => true]);
    }

    public function guardar_familia(Request $data)
    {
        if(route("home") == "https://gpc.t3rsc.co") {
            $validador = Validator::make($data->all(), [
                "nombres" => "required",
                "primer_apellido" => "required",
                "parentesco_id" => "required",
            ]);
        }else {
            $validador = Validator::make($data->all(), [
                "nombres" => "required",
                "primer_apellido" => "required",
                "parentesco_id" => "required",
                "genero" => "required"
            ]);
        }

        if($validador->fails()) {
            $mensaje = "Información no guardada, Error. Campos con asterisco(*) son obligatorios.";
            return response()->json(["mensaje_success" => $mensaje, "success" => false, "errors" => $validador->messages()]);
        }

        $nuevo_familia = new GrupoFamilia();
        $nuevo_familia->fill($data->all() + ["user_id" => $data->user_id, "numero_id" => $data->numero_id]);
        $nuevo_familia->save();

        $registro = GrupoFamilia::leftjoin("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
        ->leftjoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
        ->leftjoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
        ->leftjoin("generos", "generos.id", "=", "grupos_familiares.genero")
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
            'grupos_familiares.active',
            'grupos_familiares.created_at',
            'grupos_familiares.updated_at',
            'grupos_familiares.codigo_pais_expedicion',
            'grupos_familiares.codigo_pais_nacimiento',
            "tipos_documentos.descripcion as tipo_documento",
            "escolaridades.descripcion as escolaridad",
            "parentescos.descripcion as parentesco",
            "generos.descripcion as genero")
        ->where("grupos_familiares.id", $nuevo_familia->id)
        ->first();

        $lugarNacimiento = $nuevo_familia->getLugarNacimiento();

        $datos_basicos = DatosBasicos::where("user_id",$data->user_id)->first();
        $datos_basicos->grupo_familiar_count = 100;
        $datos_basicos->save();

        return response()->json(["lugarNacimiento" => $lugarNacimiento, "registro" => $registro, "success" => true]);
    }

    public function guardar_perfil(Request $data)
    {

        //Elimina Perfil
        $items = Perfilamiento::where("user_id", $data->user_id)->delete();

        $datos_basicos                      = DatosBasicos::where("user_id", $data->user_id)->first();
        $datos_basicos->perfilamiento_count = 0;
        $datos_basicos->save();
        if ($data->has("cargo_generico_id")) {
            //actualizando categorias
            foreach ($data->get("cargo_generico_id") as $key => $value) {
                $new                    = new Perfilamiento();
                $new->user_id           = $data->user_id;
                $new->cargo_generico_id = $value;
                $new->save();
            }

            $datos_basicos->perfilamiento_count = 100;
            $datos_basicos->save();
        }

        return redirect()->route("perfilamiento")->with("mesaje_success", "Se ha guardado correctamente el perfil!");
    }

    public function guardar_idioma(Request $data)
    {
        //Validar campos reqeuridos
        $validador = Validator::make($data->all(),["id_idioma" => "required", "nivel" => "required"]);

        if($validador->fails()) {
            $mensaje = "Información no guardada, Error. Campos con asterisco(*) son obligatorios.";

            return response()->json(["mensaje_danger" => $mensaje, "success" => false, "error" => $validador->messages()]);
        }

        $idiomacliente = new IdiomaUsuario();

        $idiomacliente->fill($data->all() + ["id_usuario" => $data->user_id]);
        $idiomacliente->save();

        return response()->json(["success" => true]);
    }
    
    //EDITAR-----------------------EDITAR------------------------EDITAR--------------------EDITAR-----
    public function editar_estudio(Request $data)
    {
        $estudio = Estudios::where("id", $data->get("id"))->first();

        $ciudad_estudio = $estudio->getCiudad();

        return response()->json(["data" => $estudio, 'ciudad_estudio' => $ciudad_estudio]);
    }

    public function editar_experiencia(Request $data)
    {
        $experiencia = Experiencias::find($data->get("id"));

        $ciudad = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $experiencia->pais_id)
        ->where("ciudad.cod_departamento", $experiencia->departamento_id)
        ->where("ciudad.cod_ciudad", $experiencia->ciudad_id)
        ->first();

        //Consulta para mostrar el nombre del cargo
        $cargo = Experiencias::join("profesiones", function ($join3) {
            $join3->on("experiencias.cargo_desempenado", "=", "profesiones.id");
        })
        ->select("profesiones.descripcion AS nombre_cargo")
        ->where("profesiones.id", $experiencia->cargo_desempenado)
        ->first();

        $txtCargo = "";
        if ($cargo != null) {
            $txtCargo = $cargo->nombre_cargo;
        }

        $txtCiudad = "";
        if ($ciudad != null) {
            $txtCiudad = $ciudad->value;
        }

        return response()->json(["data" => $experiencia, "ciudad" => $txtCiudad, "cargo" => $txtCargo]);
    }

    public function editar_referencia(Request $data)
    {

        $campos = ReferenciasPersonales::join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })
            ->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
                    ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
                    ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
            })
            ->select("referencias_personales.*", \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_autocomplete"))
            ->where("referencias_personales.id", $data->get("id"))
            ->first();

        $tipoRelaciones = ["" => "Seleccionar"] + TipoRelacion::pluck("descripcion", "id")->toArray();

        return response()->json(["data" => $campos]);
    }

    public function editar_familiar(Request $data)
    {
        $campos = GrupoFamilia::find($data->get("id"));
        $campos["ciudad_autocomplete2"] = $campos->getLugarNacimiento()->ciudad;

        return response()->json(["data" => $campos]);
    }

    //ELIMINAR------------------ELIMINAR----------------------ELIMINAR---------------------ELIMINAR-----
    public function eliminar_estudio(Request $data)
    {
        $eliminar = Estudios::find($data->get("id"));
        $user_id=$eliminar->user_id;
        $eliminar->delete();

        $count_est = Estudios::
            where("user_id",$user_id)
            ->count();

        if ($count_est< 1) {
            $datos_basicos = DatosBasicos::
                where("user_id", $user_id)
                ->first();

            $datos_basicos->estudios_count = 0;
            $datos_basicos->save();
        }
        return response()->json(["id" => $data->get("id")]);
    }

    public function eliminar_experiencia(Request $data)
    {
        $experiencia = Experiencias::find($data->get("id"));
        $user_id=$experiencia->user_id;
        $experiencia->delete();


        $count_exp = Experiencias::
            where("user_id",$user_id)
            ->count();

        if ($count_exp < 1) {
            $datos_basicos = DatosBasicos::
                where("user_id", $user_id)
                ->first();

            $datos_basicos->experiencias_count = 0;
            $datos_basicos->save();
        }
        return response()->json(["id" => $data->get("id")]);
    }

    public function eliminar_referencia(Request $data)
    {
        $referencia = ReferenciasPersonales::find($data->get("id"));
        $user_id=$referencia->user_id;
        $referencia->delete();

        $count_ref = ReferenciasPersonales::
            where("user_id",$user_id)
            ->count();

        if ($count_ref < 1) {
            $datos_basicos = DatosBasicos::
                where("user_id", $user_id)
                ->first();

            $datos_basicos->referencias_count = 0;
            $datos_basicos->save();
        }
        return response()->json(["id" => $data->get("id")]);
    }

    public function eliminar_familiar(Request $data)
    {
        $familiar = GrupoFamilia::find($data->get("id"));
        $user_id = $familiar->user_id;
        $familiar->delete();

        $count_fam = GrupoFamilia::where("user_id",$user_id)->count();

        if ($count_fam < 1) {
            $datos_basicos = DatosBasicos::where("user_id", $user_id)->first();

            $datos_basicos->grupo_familiar_count = 0;
            $datos_basicos->save();
        }

        return response()->json(["id" => $data->get("id")]);
    }

    #//ACTUALIZAR------------------------ACTUALIZAR--------------------ACTUALIZAR-----------------------
    public function actualizar_estudio(Request $data )
    {
        $estudios = Estudios::find($data->get("id"));
        $campos   = $data->except('id');
        if (!$data->has("termino_estudios")) {
            $campos["termino_estudios"] = "No";
        }
        if (!$data->has("estudio_actual")) {
            $campos["estudio_actual"] = "0";
        }
        $estudios->fill($campos);
        $estudios->save();

        $nivelEstudios = ["" => "Seleccionar"] + NivelEstudios::pluck("descripcion", "id")->toArray();
        $campos        = [];
        $estudio       = Estudios::find($data->get("id"));
        $nivel1        = NivelEstudios::find($estudio->nivel_estudio_id);
        $mensaje       = "Se ha actualizado el registro sin errores.";
        return response()->json(["mensaje_success" => $mensaje, "nivelEstudios" => $nivel1, "estudios" => $estudio, "success" => true]);
    }

    public function actualizar_experiencia(Request $data)
    {
        $experiencia = Experiencias::find($data->get("id"));
        $campos      = $data->except('id');
        
        if (!$data->has("empleo_actual")){
            $campos["empleo_actual"] = "0";
        }
        if(!$data->has("trabajo_temporal")){
            $campos["trabajo_temporal"] = "0";
        }
        if(!$data->has("autoriza_solicitar_referencias")) {
            $campos["autoriza_solicitar_referencias"] = "0";
        }

        $experiencia->fill($campos + ["numero_id" => $data->get("numero_id")]);

        $experiencia->save();
        $experiencia2 = $experiencia;
        $experiencia  = new Experiencias();

        $txtCiudad          = "";
        $mesaje_success     = "Se han actualizado los datos correctamente.";
        $motivos            = $data->motivos;
        $cargoGenerico      = $data->cargoGenerico;
        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();
        return response()->json(["mensaje_success" => $mesaje_success, "success" => true, "rs" => $experiencia2]);
    }

    public function actualizar_referencia(Request $data)
    {
        $referencia = ReferenciasPersonales::find($data->get("id"));
        $referencia->fill($data->except('id'));
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
        return response()->json(["mensaje_success" => $mensaje, "ciudad" => $ciudad, "referencia" => $referencia, "relacionTipo" => $relacionTipo, "success" => true]);
    }

    public function actualizar_familiar(Request $data)
    {
        $familiar = GrupoFamilia::find($data->get("id"));

        $familiar->fill($data->except('id'));
        $familiar->save();

        $registro   = GrupoFamilia::leftjoin("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
        ->leftjoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
        ->leftjoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
        ->leftjoin("generos", "generos.id", "=", "grupos_familiares.genero")
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
            'grupos_familiares.active',
            'grupos_familiares.created_at',
            'grupos_familiares.updated_at',
            'grupos_familiares.codigo_pais_expedicion',
            'grupos_familiares.codigo_pais_nacimiento',
            "tipos_documentos.descripcion as tipo_documento",
            "escolaridades.descripcion as escolaridad",
            "parentescos.descripcion as parentesco",
            "generos.descripcion as genero")
        ->where("grupos_familiares.id", $familiar->id)->first();

        $lugarNacimiento = $registro->getLugarNacimiento()->ciudad;

        return response()->json(["lugarNacimiento" => $lugarNacimiento, "registro" => $registro, "success" => true]);
    }

    #//Todos los Datos de Hoja de Vida
    public function datos_hv(Request $data, $user_id)
    {
        if(route('home') == "https://gpc.t3rsc.co"){
            $datos_basicos = DatosBasicos::leftJoin("autoentrevista_cand", "autoentrevista_cand.id_usuario", "=", "datos_basicos.user_id")
            ->where("datos_basicos.user_id", $user_id)
            ->first();
        }else{
            $datos_basicos = DatosBasicos::where("user_id", $user_id)->first();
        }

        $user = User::find($user_id);
        $hoja_vida = Documentos::where("descripcion_archivo","HOJA DE VIDA")->where("numero_id",$datos_basicos->numero_id)->orderBy("id", "desc")->first();
        $req = (isset($data->req)) ? $data->req:"";

        //Datos Basicos
        $tipos_documentos   = ["" => "Seleccionar"] + TipoIdentificacion::where("active", 1)->pluck("descripcion", "id")->toArray();
        $estadoCivil        = ["" => "Seleccionar"] + EstadoCivil::where("active", 1)->pluck("descripcion", "id")->toArray();
        $genero             = ["" => "Seleccionar"] + Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();
        $claseLibreta       = ["" => "Seleccionar"] + ClaseLibreta::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoVehiculo       = ["" => "Seleccionar"] + TipoVehiculo::where("active", 1)->pluck("descripcion", "id")->toArray();
        $categoriaLicencias = ["" => "Seleccionar"] + CategoriaLicencias::where("active", 1)->select(\DB::raw("CONCAT(codigo,' ',descripcion) as descripcion_categoria"), "id")->pluck("descripcion_categoria", "id")->toArray();
        $entidadesEps       = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->pluck("descripcion", "id")->toArray();
        $entidadesAfp       = ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->pluck("descripcion", "id")->toArray();

        $bancos = ["" => "Seleccionar"] + Bancos::orderBy('nombre_banco')->pluck("nombre_banco", "id")->toArray();

        $nivel_academico = ["" => "Seleccionar"];

        if(route("home") == "https://humannet.t3rsc.co"){
            //para humannet nivel estudio
            $nivel_academico = ["" => "Seleccionar"] + NivelAcademico::orderBy('descripcion')->pluck("descripcion", "id")->toArray();
        }
        
        if(route('home') == "https://listos.t3rsc.co"){
            $caja_compensaciones = ["" => "Seleccionar"] + CajaCompensacion::pluck("descripcion", "id")->toArray();
        }else{
            $caja_compensaciones = ["" => "Seleccionar"];
        }

        $talla_zapatos = [
            "" => "Seleccionar",
            "35" => "35",
            "36" => "36",
            "37" => "37",
            "38" => "38",
            "39" => "39",
            "40" => "40",
            "41" => "41",
            "42" => "42",
            "43" => "43",
            "44" => "44",
            "45" => "45",
        ];

        $talla_camisa = [
            "" => "Seleccionar",
            "XS" => "XS",
            "S" => "S",
            "M" => "M",
            "L" => "L",
            "XL" => "XL",
        ];

        $talla_pantalon = [
            "" => "Seleccionar",
            "4-5" => "4-5", 
            "6-7" => "6-7",
            "8-9" => "8-9",
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

        $letras = [
            "" => "Seleccionar",
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
            "" => "Seleccionar",
            "ESTE"  => "ESTE",
            "NORTE" => "NORTE",
            "OESTE" => "OESTE",
            "SUR"   => "SUR",
        ];

        $tipo_via = [
            "" => "Seleccionar",
            "AU" => "Autopista ",
            "AV" => "Avenida ",
            "AC" => "Avenida Calle ",
            "AK" => "Avenida Carrera ",
            "BL" => "Bulevar ",
            "CL" => "Calle ",
            "KR" => "Carrera ",
            "CT" => "Carretera ",
            "CQ" => "Circular ",
            "CV" => "Circunvalar ",
            "CC" => "Cuentas Corridas ",
            "DG" => "Diagonal ",
            "PJ" => "Pasaje ",
            "PS" => "Paseo ",
            "PT" => "Peatonal ",
            "TV" => "Transversal ",
            "TC" => "Troncal ",
            "VT" => "Variante ",
            "VI" => "Vía "
        ];

        $lugarnacimiento = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais"); //OK
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")
            ->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
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
        ->where("ciudad.cod_departamento", $datos_basicos->departamento_expedicion_id)
        ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_expedicion_id)
        ->first();

        $lugarresidencia = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $datos_basicos->pais_residencia)
        ->where("ciudad.cod_departamento", $datos_basicos->departamento_residencia)
        ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_residencia)
        ->first();

        $txtLugarNacimiento = "";
        $txtLugarExpedicion = "";
        $txtLugarResidencia = "";

        if ($lugarnacimiento != null) {
            $txtLugarNacimiento = $lugarnacimiento->value;
        }
        if ($lugarexpedicion != null) {
            $txtLugarExpedicion = $lugarexpedicion->value;
        }
        if ($lugarresidencia != null) {
            $txtLugarResidencia = $lugarresidencia->value;
        }

        //Estudios
        $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        ->select("estudios.*", "niveles_estudios.descripcion as descripcion_nivel")
        ->where("user_id", $user_id)
        ->orderBy('created_at', 'DESC')
        ->get();

        $nivelEstudios = ["" => "Seleccionar"] + NivelEstudios::pluck("descripcion", "id")->toArray();
        $periodicidad=[""=>"Seleccionar"] + DB::table("periodicidad")->pluck("descripcion","id")->toArray();

        //Experiencia
        $experiencias       = Experiencias::where("user_id", $user_id)->orderBy('created_at', 'DESC')->get();
        $motivos            = ["" => "Seleccionar"] + MotivoRetiro::where("active", "1")->pluck("descripcion", "id")->toArray();
        $cargoGenerico      = ["" => "Seleccionar"] + Profesiones::where("active", 1)->pluck("descripcion", "id")->toArray();
        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();

        //Referencia Personal
        $referencias = ReferenciasPersonales::join("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
        ->join("paises", "paises.cod_pais", "=", "referencias_personales.codigo_pais")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "referencias_personales.codigo_pais")
            ->on("departamentos.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "referencias_personales.codigo_pais")
            ->on("ciudad.cod_ciudad", "=", "referencias_personales.codigo_ciudad")
            ->on("ciudad.cod_departamento", "=", "referencias_personales.codigo_departamento");
        })
        ->select("referencias_personales.*", "tipo_relaciones.descripcion as relacion", \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"))
        ->where("referencias_personales.user_id", $user_id)
        ->orderBy('referencias_personales.created_at', 'DESC')
        ->get();

        $tipoRelaciones = ["" => "Seleccionar"] + TipoRelacion::pluck("descripcion", "id")->toArray();

        //Grupo Familiar
        $selectores = $this;

        $familiares = GrupoFamilia::leftjoin("tipos_documentos", "tipos_documentos.id", "=", "grupos_familiares.tipo_documento")
        ->leftjoin("escolaridades", "escolaridades.id", "=", "grupos_familiares.escolaridad_id")
        ->leftjoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
        ->leftjoin("generos", "generos.id", "=", "grupos_familiares.genero")
        ->select("grupos_familiares.*", "tipos_documentos.descripcion as tipo_documento", "escolaridades.descripcion as escolaridad", "parentescos.descripcion as parentesco", "generos.descripcion as genero")
        ->where("grupos_familiares.user_id", $user_id)
        ->orderBy('grupos_familiares.created_at', 'DESC')
        ->get();
        
        //Perfilamiento
        $tipo_cargos = TipoCargo::where("active", 1)->get();

        $sql_cargos_seleccionados = Perfilamiento::join("cargos_genericos", "cargos_genericos.id", "=", "perfilamiento.cargo_generico_id")
        ->join("tipos_cargos", "tipos_cargos.id", "=", "cargos_genericos.tipo_cargo_id")
        ->where("perfilamiento.user_id", $user_id)
        ->select("tipos_cargos.descripcion as tipo_cargo_name", "tipos_cargos.id as cargo_id", "cargos_genericos.*")
        ->get();

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

        $niveles = ["" => "Seleccionar"] + NivelIdioma::pluck("descripcion", "id")->toArray();
        $idiomas = IdiomaUsuario::where('id_usuario',$user_id)->get();

        $letras_direccion = [
            ""  => "",
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
            "K" => "K",
            "L" => "L",
            "M" => "M",
            "N" => "N",
            "O" => "O",
            "P" => "P",
            "Q" => "Q",
            "R" => "R",
            "S" => "S",
            "T" => "T",
            "U" => "U",
            "V" => "V",
            "W" => "W",
            "X" => "X",
            "Y" => "Y",
            "Z" => "Z",
        ];

        $sitio = Sitio::first();
        $clase_via_principal = [];
        $clase_complementaria = [];

        if ($sitio->direccion_dian) {
            $clase_via_principal = ["" => ""] + NomenclaturaDian::orderBy('descripcion')->where("categoria", "principal")
            ->pluck("descripcion", "codigo")
            ->toArray();

            $clase_complementaria = ["" => "Selecciona (opcional)"] + NomenclaturaDian::orderBy('descripcion')->where("categoria", "!=", "otro")
            ->pluck("descripcion", "codigo")
            ->toArray();
        }

        return view("admin.hv.actualizar-hv-new", compact(
            "letras_direccion",
            "clase_via_principal",
            "clase_complementaria",
            "caja_compensaciones",
            "talla_camisa",
            "talla_zapatos",
            "talla_pantalon",
            "datos_basicos",
            "txtLugarNacimiento",
            "txtLugarExpedicion",
            "txtLugarResidencia",
            "data",
            "letras",
            "tipos_documentos",
            "estadoCivil",
            "genero",
            "aspiracionSalarial",
            "claseLibreta",
            "tipoVehiculo",
            "categoriaLicencias",
            "entidadesEps",
            "entidadesAfp",
            "prefijo",
            "tipo_via",
            "nivelEstudios",
            "estudios",
            "periodicidad",
            "experiencias",
            "motivos",
            "cargoGenerico",
            "aspiracionSalarial",
            "tipoRelaciones",
            "referencias",
            "familiares",
            "selectores",
            "tipo_cargos",
            "cargos_seleccionados",
            "items_cargos",
            "grupo",
            "user_id",
            "req",
            "user",
            "hoja_vida",
            "nivel_academico",
            "niveles",
            "idiomas",
            "bancos"
        ));
    }

    #//AJAX ACTUALIZART DATOS BASICOS
    public function actualizar_datos_basicos(Request $data)
    {
        $this->validate($data,[
            "tipo_id"              => "required",
            "aspiracion_salarial"  =>"required",
            "numero_id"            => "required|numeric",
            "primer_nombre"        => "required",
            "primer_apellido"      => "required",
            "fecha_nacimiento"     => "required|date",
            "ciudad_nacimiento"    => "required",
            "grupo_sanguineo"      => "required",
            "rh"                   => "required",
            "ciudad_autocomplete"  => "required",
            "fecha_expedicion"     => "required",
            "estado_civil"         =>"required",
            "telefono_movil"       => "required|numeric",
            "direccion"            => "required",
            "ciudad_expedicion_id" => "required",
            "ciudad_residencia"    => "required",
            "email"                => "required|email",
            "genero"               => "required",
            "nombre_banco"         => "required_if:tiene_cuenta_bancaria,1",
            "tipo_cuenta"          => "required_if:tiene_cuenta_bancaria,1",
            "numero_cuenta"        => "required_if:tiene_cuenta_bancaria,1|confirmed",
            "telefono_emergencia"  => "numeric",
            "correo_emergencia"    => "email",
            "parentesco_contacto_emergencia"    => "",
        ]);
        
        //editar datos basicos desde admin
        $datos_basicos = DatosBasicos::where("user_id", $data->user_id)->first();

        //AJUSTE DIRECCION
        $direccion_array = [];
        for($i = 1; $i <= 12; $i++) {
            $direccion_array["direccion_$i"] = $data->get("direccion_$i");
        }        
         
        $datos_basicos->fill($data->all() + ["estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO'), "direccion_formato" => json_encode($direccion_array), "datos_basicos_count" => "100"]);

        $user = User::find($datos_basicos->user_id);
        $user->email = $data->email;
        $user->name = $data->get("primer_nombre")." ".$data->get("segundo_nombre");
        $user->numero_id = $data->numero_id;
        $user->save();

        $datos_basicos->nombres = $user->name;
        $datos_basicos->ciudad_expedicion_id = $data->ciudad_expedicion_id;
        $datos_basicos->departamento_expedicion_id = $data->departamento_expedicion_id;
        $datos_basicos->entidad_eps = $data->entidad_eps;

        if(route('home') == "https://gpc.t3rsc.co") {
            $datos_basicos->numero_hijos = $data->numero_hijos;
            $datos_basicos->edad_hijos = $data->edad_hijos;
            $datos_basicos->tipo_vivienda = $data->tipo_vivienda;
            $datos_basicos->tipo_vehiculo_t = $data->tipo_vehiculo_t;
            $datos_basicos->direccion_skype = $data->direccion_skype;
            $datos_basicos->otro_telefono = $data->otro_telefono;
            $datos_basicos->obj_personales = $data->obj_personales;
            $datos_basicos->obj_profesionales = $data->obj_profesionales;
            $datos_basicos->obj_academicos = $data->obj_academicos;
            $datos_basicos->horario_flexible = $data->horario_flexible;
            $datos_basicos->viaje_regional = $data->viaje_regional;
            $datos_basicos->viaje_internacional = $data->viaje_internacional;
            $datos_basicos->cambio_ciudad = $data->cambio_ciudad;
            $datos_basicos->cambio_pais = $data->cambio_pais;
            $datos_basicos->estado_salud = $data->estado_salud;
            $datos_basicos->conadis = $data->conadis;
            $datos_basicos->grado_disca = $data->grado_disca;
            $datos_basicos->sueldo_bruto = $data->sueldo_bruto;
            $datos_basicos->comision_bonos = $data->comision_bonos;
            $datos_basicos->otros_bonos = $data->otros_bonos;
            $datos_basicos->ingreso_anual = $data->ingreso_anual;
            $datos_basicos->ingreso_mensual = $data->ingreso_mensual;
            $datos_basicos->otros_beneficios = $data->otros_beneficios;
        }

        if(route('home') == "https://humannet.t3rsc.co"){
            $datos_basicos->nivel_estudio = $data->nivel_estudio;
        }

        if(route('home') == "https://asuservicio.t3rsc.co"){
            $datos_basicos->estado_salud = $data->estado_salud;
        }

        $datos_basicos->save();

        Event::dispatch(new PorcentajeHvEvent($datos_basicos));

        //Editar autoentrevista
        if(route('home') == "https://gpc.t3rsc.co"){
            $autoentrevista = Autoentrevist::where('id_usuario',$data->user_id)->first();

            if($autoentrevista == null){ $autoentrevista = new Autoentrevist(); }

            $autoentrevista->fill($data->all());
            $autoentrevista->save();
        }

        //GUARDANDO IMAGEN
        if ($data->hasFile("foto")) {
            $archivo   = $data->file('foto');
            $extension = $archivo->getClientOriginalExtension();

            if($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                $fileName  = "FotoPerfil_" . $datos_basicos->id . ".$extension";
                $user      = User::find($datos_basicos->user_id);
                
                //ELIMINAR FOTO PERFIL
                if ($user->foto_perfil != "" && file_exists("recursos_datosbasicos/". $user->foto_perfil)) {
                    unlink("recursos_datosbasicos/" . $user->foto_perfil);
                }

                $user->foto_perfil = $fileName;
            }else {
                $user->foto_perfil = null;
            }

            $user->email = $data->email;
            if($data->password != "") {
                $user->password = bcrypt($data->password);
            }

            $user->save();
            $data->file('foto')->move("recursos_datosbasicos", $fileName);
        }

        $sitio = Sitio::first();
        if ($sitio->direccion_dian) {
            $dir_dian = DireccionDian::where('datos_basicos_id', $datos_basicos->id)->first();

            if ($dir_dian == null) {
                $dir_dian = new DireccionDian();
                $dir_dian->user_id = $this->user->id;
                $dir_dian->datos_basicos_id = $datos_basicos->id;
            }

            $dir_dian->clase_via_principal  = $data->clase_via_principal;
            $dir_dian->nro_via_principal    = ($data->nro_via_principal == '' ? null : $data->nro_via_principal);
            $dir_dian->letra_via_principal  = $data->letra_via_principal;
            $dir_dian->sufijo_via_principal = $data->sufijo_via_principal;
            $dir_dian->letra_complementaria = $data->letra_complementaria;
            $dir_dian->nro_via_generadora   = ($data->nro_via_generadora == '' ? null : $data->nro_via_generadora);
            $dir_dian->letra_via_generadora = $data->letra_via_generadora;
            $dir_dian->direccion_complementaria = $data->direccion_complementaria;
            $dir_dian->sector           = $data->sector;
            $dir_dian->nro_predio       = ($data->nro_predio == '' ? null : $data->nro_predio);
            $dir_dian->sector_predio    = $data->sector_predio;

            $dir_dian->save();
        }

        //cargar documento de hoja de vida
        if($data->hasFile("archivo_documento")){
            $archivo_hv     = $data->file("archivo_documento");
            $extencion      = $archivo_hv->getClientOriginalExtension();
            if ($extencion == 'jpg' || $extencion == 'png' || $extencion == 'jpeg' || $extencion == 'pdf' || $extencion == 'doc' || $extencion == 'docx') {
                $archivo = new Archivo_hv();
                $archivo->fill($data->all() + [
                    "user_id" => $this->user->id,
                    "archivo" => $data->get("archivo_documento")
                ]);
                $archivo->save();

                $name_documento = "documento_hv_" . $archivo->id . "." . $extencion;
                $archivo_hv->move("archivo_hv", $name_documento);
                $archivo->archivo = $name_documento;
                $archivo->save();
            }
        }

        return redirect()->route("datos_basicos_admin")->with(["view_mesaje_success" => view("cv.modal.mensaje_datos_basicos")->render()]);
    }

    public function actualizar_datos_contacto(Request $data)
    {
        //editar datos de contacto desde admin
        $actualiza_email = false;
        $se_actualizo_email = false;
        $actualiza_cedula = false;
        $se_actualizo_cedula = false;
        $email = $data->email;
        $numero_id = $data->numero_id;
        $datos_basicos = DatosBasicos::where("user_id", $data->user_id)->first();
        $user = User::find($data->user_id);

        if ($datos_basicos->email != $data->email) {
            $actualiza_email = true;
            $existe_email = DatosBasicos::where('email', $data->email)->where("user_id", '!=', $data->user_id)->first();

            if (is_null($existe_email)) {
                $se_actualizo_email = true;
                $datos_basicos->email   = $data->email;
                $user->email            = $data->email;
            }
        }

        if ($datos_basicos->numero_id != $data->numero_id) {
            $actualiza_cedula = true;
            $existe_cedula = DatosBasicos::where('numero_id', $data->numero_id)->where("user_id", '!=', $data->user_id)->first();

            if (is_null($existe_cedula)) {
                $se_actualizo_cedula = true;
                $datos_basicos->numero_id   = $data->numero_id;
                $user->numero_id            = $data->numero_id;
            }
        }

        $nombres = $data->primer_nombre;
        if($data->segundo_nombre != null && $data->segundo_nombre != '') {
            $nombres = $data->primer_nombre . ' ' . $data->segundo_nombre;
        }

        $datos_basicos->primer_nombre       = $data->primer_nombre;
        $datos_basicos->segundo_nombre      = $data->segundo_nombre;
        $datos_basicos->primer_apellido     = $data->primer_apellido;
        $datos_basicos->segundo_apellido    = $data->segundo_apellido;
        $datos_basicos->telefono_movil      = $data->telefono_movil;
        $datos_basicos->nombres             = $nombres;


        $user->name = $nombres . ' ' . $data->primer_apellido;
        if($data->segundo_apellido != null && $data->segundo_apellido != '') {
            $user->name = $user->name . ' ' . $data->segundo_apellido;
        }

        $datos_basicos->save();
        $user->save();

        $mensaje_success = 'Datos de contacto guardados correctamente';

        if ($actualiza_email) {
            if (!$se_actualizo_email) {
                $mensaje_success .= ', excepto el email <b>' . $data->email . '</b> porque ya se encuentra en uso en la plataforma';
                $email = $datos_basicos->email;
            }
        }

        if ($actualiza_cedula) {
            if (!$se_actualizo_cedula) {
                $mensaje_success .= ', excepto el número de identificación <b>' . $data->numero_id . '</b> porque ya se encuentra en uso en la plataforma.';
                $numero_id = $datos_basicos->numero_id;
            } else {
                $mensaje_success .= '.';
            }
        } else {
            $mensaje_success .= '.';
        }

        return response()->json(["success" => true, "mensaje_success" => $mensaje_success, "email" => $email, "numero_id" => $numero_id]);
    }

    public function ver_documentos($user_id,Request $data)
    {
        $tipoDocumento = TipoDocumento::where("estado", 1)->where("categoria", 1)->orderBy("descripcion")->pluck("descripcion", "id")->toArray();

        $tipoDocumentoFamiliar = TipoDocumento::where("active", "1")->where('categoria', FuncionesGlobales::CATEGORIA_DOCUMENTOS_BENEFICIARIOS)->pluck("descripcion", "id")->toArray();

        $usuario = DatosBasicos::where("user_id", $data->user_id)->first();

        $documentos = Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
        ->select("documentos.*", "tipos_documentos.descripcion as tipo_doc")
        ->where("documentos.user_id", $data->user_id)
        ->where("tipos_documentos.categoria", 1)
        ->where("documentos.active",1)
        ->get();

        $documentosFamiliares = DocumentoFamiliar::leftjoin("grupos_familiares", "grupos_familiares.id", "=", "documentos_familiares.grupo_familiar_id")
        ->leftjoin("tipos_documentos", "tipos_documentos.id", "=", "documentos_familiares.tipo_documento_id")
        ->leftjoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
        ->select(
            "documentos_familiares.id",
            "documentos_familiares.created_at",
            "documentos_familiares.descripcion as descripcion",
            "documentos_familiares.nombre as nombre_archivo",
            "grupos_familiares.nombres as grupo_familiar",
            "tipos_documentos.descripcion as tipo_documento",
            "parentescos.descripcion as parentesco"
        )
        ->where("grupos_familiares.user_id", $data->user_id)
        ->where("documentos_familiares.active",1)
        ->orderBy("documentos_familiares.id")
        ->get();

        $archivos = Archivo_hv::where("user_id", $data->user_id)->get();

        $gruposFamiliares = GrupoFamilia::leftjoin("parentescos", "parentescos.id", "=", "grupos_familiares.parentesco_id")
        ->select(
            "grupos_familiares.id",
            "grupos_familiares.nombres",
            "grupos_familiares.primer_apellido",
            "grupos_familiares.segundo_apellido",
            "parentescos.descripcion as parentesco"
        )
        ->where('grupos_familiares.user_id', $data->user_id)
        ->get();

        // admin.hv.documentos.documentos
        return view("admin.hv.documentos.documentos", compact("tipoDocumento", "documentos", "documentosFamiliares", "tipoDocumentoFamiliar", "gruposFamiliares", "usuario", "archivos"));
    }

    public function guardar_documento_candidato(Request $data, Requests\DocumentoNuevoAdminRequest $validate)
    {

        if($data->hasFile('archivo_documento')) {
            $cant_archivos = 0;
            $cant_no_procesados = 0;
            $Documentos = collect([]);

            foreach ($data->file('archivo_documento') as $key => $imagen) {
                $extension = $imagen->getClientOriginalExtension();

                if($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "pdf" || $extension == "PDF") {
                    $documento = new Documentos();

                    $documento->fill($data->except('fecha_vencimiento') + ["user_id" => $data->user_id, "numero_id" => $data->numero_id, "gestiono" => $this->user->id]);

                    if ($data->fecha_vencimiento != null && $data->fecha_vencimiento != '') {
                        $documento->fecha_vencimiento = $data->fecha_vencimiento;

                    }
                    $documento->save();
                    
                    $name_documento = "documento_" . $documento->id . "." . $extension;
                    $imagen->move("recursos_documentos", $name_documento);
                    $documento->nombre_archivo = $name_documento;
                    $documento->nombre_archivo_real = $imagen->getClientOriginalName();
                    $documento->save();

                    $tipoDoc = TipoDocumento::where('id', $documento->tipo_documento_id)->first();
                    $documento->descripcion_archivo = $tipoDoc->descripcion;
                    $documentos[] = $documento;
                }else {
                    $cant_no_procesados++;
                }

                $cant_archivos++;
            }

            if ($cant_no_procesados == $cant_archivos) {
                //No se proceso ningun archivo
                $mensaje = "Documentos no soportados.";
                return response()->json([
                    "mensaje" => $mensaje, "success" => false
                ]);
            } elseif ($cant_no_procesados > 0) {
                //Se procesaron algunos archivos
                $mensaje = "Se guardaron $cant_archivos documentos exitosamente y $cant_no_procesados documentos no soportados.";
                $success = false;
            } else {
                //Se procesaron todos los archivos
                $mensaje = "Documento(s) guardado(s).";
                $success = true;
            }

            return response()->json([
                "mensaje" => $mensaje,
                "documentos" => $documentos,
                "success" => $success
            ]);
        }
    }

    public function editar_documento_candidato(Request $data)
    {
        $documento = Documentos::find($data->id);

        return response()->json(["success" => true, "documento" => $documento]);
    }

    public function actualizar_documento(Request $data, Requests\DocumentoEditarRequest $validate)
    {
        $documentos = Documentos::find($data->id);
        $documentos->fill($data->all());
        $documentos->save();

        if ($data->hasFile('archivo_documento')) {
            $imagen = $data->file("archivo_documento")[0];
            $extension = $imagen->getClientOriginalExtension();

            if ($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "pdf" || $extension == "PDF") {
                // Eliminar archivo
                if (file_exists("recursos_documentos/" . $documentos->nombre_archivo) && $documentos->nombre_archivo != "") {
                    unlink("recursos_documentos/" . $documentos->nombre_archivo);
                }

                $name_documento = "documento_" . $documentos->id . "." . $extension;
                $imagen->move("recursos_documentos", $name_documento);

                $documentos->nombre_archivo = $name_documento; // Actualizar nombre del archivo al registro
                $documentos->save();

                $documento = Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
                ->where("documentos.id", $documentos->id)
                ->select("documentos.*", "tipos_documentos.descripcion as tipo_doc")
                ->first();

                return response()->json(["success" => true, "documento" => $documento, 'mensaje' => 'Documento actualizado.']);
            }else {
                $mensaje = "Documento no soportado.";

                return response()->json(["mensaje" => $mensaje, "success" => false]);
            }
        }else {
            return response()->json(["success" => true, 'mensaje' => 'Documento actualizado.']);
        }
    }

    public function cancelar_documento(Request $data)
    {
        $campos        = [];
        $tipoDocumento = ["" => "Seleccionar"] + TipoDocumento::where("active", "1")->pluck("descripcion", "id")->toArray();

        return response()->json(["success" => true, "view" => view("cv.modal.fr_documentos", compact("campos", "tipoDocumento"))->render()]);
    }

    public function eliminar_documento(Request $data)
    {
        $documento = Documentos::find($data->id);
        $documento->active=0;
        $documento->eliminado=$this->user->id;
        $documento->fecha_eliminacion=date("Y-m-d H:i:s");
        $documento->save();

        return response()->json(["success" => true, "id" => $data->id]);
    }
}
