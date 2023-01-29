<?php

namespace App\Http\Controllers;

use Event;
use Storage;
use App\Models\Pais;
use App\Models\User;
use App\Models\Sitio;
use App\Http\Requests;
use App\Models\Ciudad;
use App\Models\Genero;
use App\Models\Idiomas;
use App\Models\Documentos;
use App\Models\EstadoCivil;
use App\Models\NivelIdioma;
use App\Models\Universidad;
use App\Models\ClaseLibreta;
use App\Models\DatosBasicos;
use App\Models\Departamento;
use App\Models\EntidadesAfp;
use App\Models\EntidadesEps;
use App\Models\TipoVehiculo;
use Illuminate\Http\Request;
use App\Models\Autoentrevist;
use App\Models\DireccionDian;
use App\Models\IdiomaUsuario;
use App\Models\Requerimiento;
use App\Models\TipoDocumento;
use App\Models\NivelAcademico;
use App\Jobs\FuncionesGlobales;
use App\Models\NomenclaturaDian;
use App\Events\PorcentajeHvEvent;
use App\Models\AspiracionSalarial;
use App\Models\CategoriaLicencias;
use App\Models\PreguntaValidacion;
use App\Models\TipoIdentificacion;
use Illuminate\Support\Facades\DB;
use App\Models\PoliticasPrivacidad;
use App\Models\Bancos;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DatosBasicosController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function datos_basicos(Request $data)
    {
        $grupo = "";
        $nivel_academico = "";

        $menu=DB::table("menu_candidato")->where("estado",1)->orderBy("orden")
                                         ->select("menu_candidato.*")->get();

        if(route("home") == "https://humannet.t3rsc.co"){
        //para humannet nivel estudio
         $nivel_academico = ["" => "Seleccionar"] + NivelAcademico::orderBy('descripcion')->pluck("descripcion", "id")->toArray();
        }
        $cantidad_politicas = PoliticasPrivacidad::count();
         $datos_basicos = DatosBasicos::where("user_id", $this->user->id)->first();
         $user=User::find($this->user->id);
         $hoja_vida=Documentos::where("descripcion_archivo","HOJA DE VIDA")->where("numero_id",$datos_basicos->numero_id)->orderBy("id","desc")->first();
        
        $paises = ["" => "Seleccionar"] + Pais::orderBy(DB::raw("UPPER(nombre)"))->pluck("nombre", "cod_pais")->toArray();

        $dptos_expedicion = ["" => "Seleccionar"] + Departamento::orderBy(DB::raw("UPPER(nombre)"))->where("cod_pais", $datos_basicos->pais_id)
        ->pluck("nombre", "cod_departamento")
        ->toArray();

        $ciudades_expedicion = ["" => "Seleccionar"] + Ciudad::orderBy(DB::raw("UPPER(nombre)"))->where("cod_pais", $datos_basicos->pais_id)
        ->where("cod_departamento", $datos_basicos->departamento_expedicion_id)
        ->pluck("nombre", "cod_ciudad")
        ->toArray();

        $dptos_residencia = ["" => "Seleccionar"] + Departamento::orderBy(DB::raw("UPPER(nombre)"))->where("cod_pais", $datos_basicos->pais_residencia)
        ->pluck("nombre", "cod_departamento")
        ->toArray();

        $ciudades_residencia = ["" => "Seleccionar"] + Ciudad::orderBy(DB::raw("UPPER(nombre)"))->where("cod_pais", $datos_basicos->pais_residencia)
        ->where("cod_departamento", $datos_basicos->departamento_residencia)
        ->pluck("nombre", "cod_ciudad")
        ->toArray();

        $dptos_nacimiento = ["" => "Seleccionar"] + Departamento::orderBy(DB::raw("UPPER(nombre)"))->where("cod_pais", $datos_basicos->pais_residencia)
        ->pluck("nombre", "cod_departamento")
        ->toArray();

        $ciudades_nacimiento = ["" => "Seleccionar"] + Ciudad::orderBy(DB::raw("UPPER(nombre)"))->where("cod_pais", $datos_basicos->pais_nacimiento)
        ->where("cod_departamento", $datos_basicos->departamento_nacimiento)
        ->pluck("nombre", "cod_ciudad")
        ->toArray();

        $tipos_documentos   = ["" => "Seleccionar"] + TipoIdentificacion::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();
        $estadoCivil        = ["" => "Seleccionar"] + EstadoCivil::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();
        $genero             = ["" => "Seleccionar"] + Genero::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();
        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();
        $claseLibreta       = ["" => "Seleccionar"] + ClaseLibreta::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoVehiculo       = ["" => "Seleccionar"] + TipoVehiculo::where("active", 1)->pluck("descripcion", "id")->toArray();

        $categoriaLicencias = ["" => "Seleccionar"] + CategoriaLicencias::where("active", 1)
        ->select(\DB::raw("CONCAT(codigo,' ',descripcion) as descripcion_categoria"), "id")
        ->pluck("descripcion_categoria", "id")
        ->toArray();

        $entidadesEps       = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();
        $entidadesAfp       = ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();

        $bancos = ["" => "Seleccionar"] + Bancos::orderBy('nombre_banco')->pluck("nombre_banco", "id")->toArray();

        $datosDireccion = json_decode($datos_basicos->direccion_formato, true);
        
        if (is_array($datosDireccion)) {
            foreach ($datosDireccion as $key => $value) {
                $datos_basicos->$key = $value;
            }
        }

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
            "4-5"=>"4-5", 
            "6-7"=>"6-7",
            "8-9"=>"8-9",
            "10-11"=>"10-11",
            "12-13"=>"12-13",
            "14-15"=>"14-15",
            "16-17"=>"16-17",
            "18-19"=>"18-19",
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

        $tipo_via = ["" => "Seleccionar",
            "AU"        => "Autopista ",
            "AV"        => "Avenida ",
            "AC"        => "Avenida Calle ",
            "AK"        => "Avenida Carrera ",
            "BL"        => "Bulevar ",
            "CL"        => "Calle ",
            "KR"        => "Carrera ",
            "CT"        => "Carretera ",
            "CQ"        => "Circular ",
            "CV"        => "Circunvalar ",
            "CC"        => "Cuentas Corridas ",
            "DG"        => "Diagonal ",
            "PJ"        => "Pasaje ",
            "PS"        => "Paseo ",
            "PT"        => "Peatonal ",
            "TV"        => "Transversal ",
            "TC"        => "Troncal ",
            "VT"        => "Variante ",
            "VI"        => "Vía "
        ];

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

        $ciudadSel = Ciudad::orderBy('nombre')->where('cod_pais', 170)->pluck("nombre", "cod_ciudad")->toArray();

        $pregs = null;
        $preg_val = null;

        if(route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co"){
            //Preguntas completas
            $preg_val = PreguntaValidacion::where('user_id', $this->user->id)->first();

            if ($preg_val == null) {
                $pregs = 0;
            }else{
                if ($preg_val->respuesta_1 == '' || $preg_val->respuesta_2 == '' || $preg_val->respuesta_3 == '' || $preg_val->respuesta_4 == '') {
                    $pregs = 0;
                }else{
                    $pregs = 1;
                }
            }
        }

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
        
        return view("cv.datos_basicos", compact("letras_direccion", "clase_via_principal", "clase_complementaria",
            "grupo", "talla_camisa", "talla_zapatos", "talla_pantalon",
            "datos_basicos", "txtLugarNacimiento", "txtLugarExpedicion", "txtLugarResidencia",
            "data","letras","tipos_documentos", "estadoCivil", "genero", "aspiracionSalarial",
            "claseLibreta", "tipoVehiculo","categoriaLicencias", "entidadesEps", "entidadesAfp",
            "prefijo", "tipo_via", "ciudadSel", "pregs", "preg_val", "paises", "dptos_expedicion",
            "ciudades_expedicion", "dptos_residencia", "ciudades_residencia", "dptos_nacimiento", 
            "ciudades_nacimiento","menu","user","hoja_vida","nivel_academico", "cantidad_politicas", "bancos"
        ));
    }

    public function guardar_datos_basicos(Request $data, Requests\DatosBasicosRequest $valida)
    {
        //VALIDA LIBRETA MILITAR
        $ruta = 'datos_basicos';
        
        $datos_basicos = DatosBasicos::where("user_id", $this->user->id)->first();

        if($datos_basicos == null){ $datos_basicos = new DatosBasicos(); }
        
        //AJUSTE DIRECCION
        $direccion_array = [];

        for($i = 1; $i <= 12; $i++) {
            $direccion_array["direccion_$i"] = $data->get("direccion_$i");
        }

        if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co"){
            //Grupo sanguineo
            $g = explode('-', $data->grupo_s);

            $grupo = $g[0];
            $rh = $g[1];

            $datos_basicos->fill($data->all() + [
                "grupo_sanguineo" => $grupo,
                "rh" => $rh,
                "user_id" => $this->user->id,
                "direccion_formato" => json_encode($direccion_array),
                "datos_basicos_count" => "100"
            ]);
            $ruta = 'experiencia';
        }else{
            $union_nombre=$data->get("primer_nombre")." ".$data->get("segundo_nombre");
            $datos_basicos->fill($data->all() + [
                "user_id" => $this->user->id,
                "direccion_formato" => json_encode($direccion_array),
                "nombres"=>$union_nombre,
                "datos_basicos_count" => "100"
            ]);
        }

        $datos_basicos->entidad_eps = $data->entidad_eps;

        if(route('home') == "https://gpc.t3rsc.co"){
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

        //Validar para guardar nuevo id de grupo sanguíneo
        if ($data->grupo_sanguineo == 'A' && $data->rh == 'positivo') {
            $datos_basicos->tipo_sangre_id = 3; //A+
        } else if($data->grupo_sanguineo == 'A' && $data->rh == 'negativo') {
            $datos_basicos->tipo_sangre_id = 4; //A-
        } else if($data->grupo_sanguineo == 'B' && $data->rh == 'positivo') {
            $datos_basicos->tipo_sangre_id = 5; //B+
        } else if($data->grupo_sanguineo == 'B' && $data->rh == 'negativo') {
            $datos_basicos->tipo_sangre_id = 6; //B-
        } else if($data->grupo_sanguineo == 'O' && $data->rh == 'positivo') {
            $datos_basicos->tipo_sangre_id = 1; //O+
        } else if($data->grupo_sanguineo == 'O' && $data->rh == 'negativo') {
            $datos_basicos->tipo_sangre_id = 2; //O-
        } else if($data->grupo_sanguineo == 'AB' && $data->rh == 'positivo') {
            $datos_basicos->tipo_sangre_id = 7; //AB+
        } else if($data->grupo_sanguineo == 'AB' && $data->rh == 'negativo') {
            $datos_basicos->tipo_sangre_id = 8; //AB-
        }

        $datos_basicos->save();

       Event::dispatch(new PorcentajeHvEvent($datos_basicos));

        if (route("home") == "http://vym.t3rsc.co" || route("home") == "https://vym.t3rsc.co") {
            $user = User::where("id", $this->user->id)->first();

            if ($data->get('entidad_eps') == 28 || $data->get('entidad_eps') == 14) {
                $user->estado = 0;
                $user->save();
            }else{
                $user->estado = 1;
                $user->save();
            }
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

        //GUARDANDO CEDULA
        if ($data->hasFile("cedula")) {
            $archivo   = $data->file('cedula');

            $extencion = $archivo->getClientOriginalExtension();
            $fileName  = "cedula_" . $datos_basicos->id . ".$extencion";
            $user      = User::find($datos_basicos->user_id);
            
            //ELIMINAR CEDULA
            if($user->cedula != "" && file_exists("recursos_datosbasicos/" . $user->cedula)) {
             unlink("recursos_datosbasicos/" . $user->cedula);
            }

            $user->cedula = $fileName;
            $user->save();
            $data->file('cedula')->move("recursos_datosbasicos", $fileName);
        }

        //GUARDANDO IMAGEN
        if ($data->hasFile("foto")) {
            $user = User::find($datos_basicos->user_id);

            $picExtension = $data->file('foto')->getClientOriginalExtension();

            if ($picExtension == 'jpg' || $picExtension == 'png' || $picExtension == 'jpeg') {
                $archivo   = $data->file('foto');
                $extencion = $archivo->getClientOriginalExtension();
                $fileName  = "FotoPerfil_" . $datos_basicos->id . ".$extencion";

                //ELIMINAR FOTO PERFIL
                if ($user->foto_perfil != "" && file_exists("recursos_datosbasicos/" . $user->foto_perfil)) {
                    unlink("recursos_datosbasicos/" . $user->foto_perfil);
                }

                $user->foto_perfil = $fileName;
                $user->save();
                $data->file('foto')->move("recursos_datosbasicos", $fileName);
            }else{
                $user->foto_perfil = null;
                $user->save();
            }
        }
        
        $pregs = null;
        
        //Guardar HV GPC
        if(route('home') == "https://gpc.t3rsc.co"){

            $tipo_doc   =  TipoDocumento::where("descripcion", 'HOJA DE VIDA')->select('id')->first(); //tipo de documento q es hoja de vida
            $documentos = Documentos::where('user_id',$this->user->id)->where('tipo_documento_id',$tipo_doc->id)->first();
            if(is_null($documentos)){
             $documentos = new Documentos();
              $documentos->fill([
                "user_id" => $this->user->id,
                "numero_id" => $this->user->getCedula()->numero_id,
                "descripcion_archivo" => "HOJA DE VIDA",
                "tipo_documento_id"   => $tipo_doc->id
              ]);
            }

            $documentos->save(); //documento guardar

            if($data->hasFile('archivo_documento')){
                $imagen        = $data->file("archivo_documento");
                $extencion     = $imagen->getClientOriginalExtension();

                if($extencion == 'pdf' || $extencion == 'doc' || $extencion == 'docx' ){
                  $name_documento = "documento_" . $documentos->id . "." . $extencion;
                  $imagen->move("recursos_documentos", $name_documento);
                  $documentos->nombre_archivo = $name_documento;
                  $documentos->save();
                }else{
                   $documentos->nombre_archivo = 'NOname';
                   $documentos->save();
                }
            }
        }

        if(route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co"){
            //Preguntas completas
            $preg_val = PreguntaValidacion::where('user_id', $this->user->id)->first();
            
            if ($preg_val == null) {
                $pregs = 0;
            }else{
                if($preg_val->respuesta_1 == '' || $preg_val->respuesta_2 == '' || $preg_val->respuesta_3 == '' || $preg_val->respuesta_4 == '') {
                    $pregs = 0;
                }else{
                    $pregs = 1;
                }
            }
        }

        return response()->json(["success" => true, "pregs" => $pregs]);
    }

    public function video_perfil(Request $data)
    {
        $menu = DB::table("menu_candidato")->where("estado",1)->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();

        $user = User::where('id',$this->user->id)->first();
        
        return view("cv.video_descripcion",compact('user','menu'));
    }

    public function video_perfil_modal(Request $data)
    {
        $user = User::where('id',$data->user_id)->first();
        return view("cv.modal.video_perfil_modal",compact('user'));
    }
    
    public function guardar_video_descripcion(Request $data)
    {
        $sitio = Sitio::first();

        $user_id = $this->user->id;

        //Validar si el video viene del módulo admin
        if ($data->has('admin_video')) {
            $user_id = $data->user_id;
        }

        $success = true;
        $mensaje = "Se ha cargado el video correctamente";
        $codeState = 200; //OK

        $archivo   = $data->file('video-blob');
        $extencion = $archivo->getClientOriginalExtension();

        if ( $extencion == 'mp4' || $extencion == 'webm' ) {

            $datos_basicos = DatosBasicos::where("user_id", $user_id)->first();
            $datos_basicos->video_perfil_count = 100;
            $datos_basicos->save();

            //GUARDANDO VIDEO
            $fileName  = "VideoPerfil_" . $datos_basicos->id . ".$extencion";
            $user      = User::find($datos_basicos->user_id);

        
            //ELIMINAR VIDEO PERFIL
            if ($user->video_perfil != "" && file_exists("recursos_videoperfil/" . $user->video_perfil)) {
                unlink("recursos_videoperfil/" . $user->video_perfil);
            }

            /*Upload to S3
                $folder_site = str_replace(' ', '-', mb_strtolower($sitio->nombre));

                Storage::disk('s3')->put("$folder_site/$datos_basicos->numero_id/$fileName", $data->file('video-blob'));

                //$video_url = Storage::disk('s3')->url("$folder_site/$datos_basicos->numero_id/$fileName");

                $aws_path = "https://docs-t3rsc.s3.amazonaws.com/$folder_site/$datos_basicos->numero_id/$fileName";
            */

            $user->video_perfil = $fileName;
            $user->save();

            $data->file('video-blob')->move("recursos_videoperfil", $fileName);
            
        }else{
            $codeState = 415; //Unsupported Media Type
            $mensaje  = "Formato no soportado";
            $success = false;
        }

        return response()->json(["success" => $success, "mensaje_success" => $mensaje], $codeState);
    }
   
    public function nuevo_datos_basicos(Request $data, Requests\NuevoDatosBasicosRequest $valida)
    {
        $usuario_cargo = $this->user->id;

        $datos_basicos = new DatosBasicos();
        
        //AJUSTE DIRECCION
        $direccion_array = [];
        
        for($i = 1; $i <= 12; $i++){
            $direccion_array["direccion_$i"] = $data->get("direccion_$i");
        }

        $datos_basicos->fill($data->all() + [
            "user_id" => $this->user->id,
            "direccion_formato" => json_encode($direccion_array),
            "datos_basicos_count" => "100",
            "estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')
        ]);

        //$datos_basicos->usuario_cargo = $usuario_cargo;
        $datos_basicos->save();
        
        $user       = User::find($datos_basicos->user_id);
        $user->name = $data->get("nombres") . " " . $data->get("primer_apellido") . " " . $data->get("segundo_apellido");
        $user->save();
        
        //GUARDANDO IMAGEN
        if ($data->hasFile("foto")) {
            $archivo   = $data->file('foto');
            $extencion = $archivo->getClientOriginalExtension();
            $fileName  = "FotoPerfil_" . $datos_basicos->id . ".$extencion";
            $user      = User::find($datos_basicos->user_id);

            //ELIMINAR FOT PERFIL
            if ($user->foto_perfil != "" && file_exists("recursos_datosbasicos/" . $user->foto_perfil)) {
                unlink("recursos_datosbasicos/" . $user->foto_perfil);
            }

            $user->foto_perfil = $fileName;
            $user->save();
            $data->file('foto')->move("recursos_datosbasicos", $fileName);
        }
        
        return redirect()->route("datos_basicos")->with(["mesaje_success" => "Se han actualizado los datos correctamente."]);
    }

    public function autocomplete_cuidades(Request $data)
    {
        $campo = $data->get("query");

        if(route('home') == 'https://capillasdelafe.t3rsc.co' || route('home') == 'https://humannet.t3rsc.co' || route('home') == 'https://asuservicio.t3rsc.co'){
            
          /*  $pais = Pais::
                join('departamentos','departamentos.cod_pais','=','paises.cod_pais')
                ->join('ciudad','ciudad.cod_departamento','=','departamentos.cod_departamento')
                ->whereRaw("LOWER(ciudad.nombre) like '".strtolower($campo)."%'")
                ->select("ciudad.cod_pais", "ciudad.cod_departamento", "ciudad.cod_ciudad", \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
                ->orderBy("paises.nombre", "asc")
                ->limit(10)
                ->get()
                ->toArray();*/

         $pais = Pais::join("departamentos", function ($join) {
                    $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                })
                ->select("ciudad.cod_pais", "ciudad.cod_departamento", "ciudad.cod_ciudad", \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
                ->where(function ($sql) use ($campo){
                    if($campo != ""){
                      $sql->whereRaw("LOWER(ciudad.nombre) like'%" . strtolower($campo) . "%'");
                    }
                })
                //->where('ciudad.cod_pais',47)
                ->orderBy("paises.nombre", "asc")
                ->limit(6)
                ->get()
                ->toArray();

        }else{

            $pais = Pais::join("departamentos", function ($join) {
                    $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                })
                ->select("ciudad.cod_pais", "ciudad.cod_departamento", "ciudad.cod_ciudad", \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
                ->where(function ($sql) use ($campo) {
                    if($campo != ""){
                      $sql->whereRaw("LOWER(ciudad.nombre) like'%" . strtolower($campo) . "%'");
                    }
                    
                    if(route('home') == "https://gpc.t3rsc.co"){
                     //$sql->where('paises.cod_pais',218);
                    }
                })
                ->orderBy("paises.nombre", "asc")
                ->limit(6)
                ->get()
                ->toArray();
        }

        return response()->json(["suggestions" => $pais]);
    }
    
    public function autocomplete_cuidades_all(Request $data)
    {
        $campo = $data->get("query");

        $pais = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select("ciudad.cod_pais", "ciudad.cod_departamento", "ciudad.cod_ciudad", \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where(function ($sql) use ($campo) {
            if($campo != ""){
              $sql->whereRaw("LOWER(ciudad.nombre) like '%".strtolower($campo)."%'");
            }
        })
        ->orderBy("paises.nombre", "asc")
        ->limit(6)
        ->get()
        ->toArray();

        return response()->json(["suggestions" => $pais]);
    }

     public function autocomplete_universidades(Request $data)
    {
        $campo = $data->get("query");

        $pais = Universidad::select("nombre as value")
        ->where(function ($sql) use ($campo) {
           if ($campo != "") {
            $sql->whereRaw("LOWER(universidades.nombre) like'%".strtolower($campo)."%'");
           }
        })
        ->orderBy("universidades.nombre", "asc")
        ->limit(6)
        ->get()
        ->toArray();

        return response()->json(["suggestions" => $pais]);
    }

    public function buscar_dptos(Request $request)
    {
        $dptos = Departamento::orderBy(DB::raw('UPPER(nombre)'))->where("cod_pais", $request->id)
        ->select("nombre", "cod_departamento")
        ->get()
        ->toArray();

        return response()->json(["success" => true, "dptos" => $dptos]);
    }

    public function buscar_ciudades(Request $request)
    {
        $ciudades = Ciudad::orderBy(DB::raw('UPPER(nombre)'))->where("cod_departamento", $request->id)
        ->where("cod_pais",$request->pais)
        ->select("nombre", "cod_ciudad")
        ->get()
        ->toArray();

      return response()->json(["success" => true, "ciudades" => $ciudades]);
    }

    public function autocomplete_requerimientos(Request $data)
    {
        $campo = $data->get("query");
        $req   = Requerimiento::whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado in( " . config('conf_aplicacion.C_TERMINADO') . "," . config('conf_aplicacion.C_SOLUCIONES') . "," . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . "))"))
            ->select("requerimientos.id as value")
            ->where(function ($sql) use ($campo) {
                if ($campo != "") {
                    $sql->whereRaw("(requerimientos.id) like '" . $campo . "%'");
                }
            })
            ->orderBy('requerimientos.id', 'asc')
            ->take(5)
            ->get()
            ->toArray();

        return response()->json(["suggestions" => $req]);
    }

    public function Idiomas()
    {
        $menu=DB::table("menu_candidato")->where("estado",1)->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();
        
        $niveles = ["" => "Seleccionar"] + NivelIdioma::pluck("descripcion", "id")->toArray();
        $idiomas = IdiomaUsuario::where('id_usuario',$this->user->id)->get();
       
        return view("cv.idiomas_cliente", compact('niveles','idiomas',"menu"));
    }

    public function autoentrevista()
    {        
        $menu=DB::table("menu_candidato")->where("estado",1)->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();
        
        $autoentrevista = Autoentrevist::where('id_usuario',$this->user->id)->first();
       
        return view("cv.autoentrevista",compact('autoentrevista','menu'));
    }
    
    public function guardar_autoentrevista(Request $data)
    {
        $validatedData = Validator::make($data->all(), [
            'motivo_cambio'     => 'required',
            'areas_interes'     => 'required',
            'conoc_tecnico'     => 'required',
            'herr_tecnologicas' => 'required'
        ]);

        if ($validatedData->fails()) {
            return redirect()->route('cv.autoentrevista')->withErrors($validatedData)->withInput();
        }

        $usuario_cargo = $this->user->id;

        $datos_basicos = Autoentrevist::where('id_usuario',$this->user->id)->first();

        if($datos_basicos == null){ $datos_basicos = new Autoentrevist(); }
        
        $datos_basicos->fill($data->all() + [
            "id_usuario" => $this->user->id
        ]);

        $datos_basicos->save();
        
       return redirect()->route("datos_basicos")->with(["mesaje_success" => "Se han actualizado los datos correctamente."]);
    }

    public function AutocompleteIdioma(Request $request)
    {
        $campo = $request->get("query");

        $idioma = Idiomas::where(function ($sql) use ($campo) {
            if ($campo != "") {
               $sql->whereRaw("(idiomas.descripcion) like '" . $campo . "%'");
            }
        })->select('idiomas.id','idiomas.descripcion as value')->get();

        return response()->json(["suggestions" => $idioma]);
    }

    public function GuardarIdioma(Request $request)
    {
        $buscaidioma = Idiomas::find($request->id_idioma);

        $idiomacliente = new IdiomaUsuario();
        $idiomacliente->fill($request->all() + ["id_usuario" => $this->user->id]);

        if(route('home') == "https://gpc.t3rsc.co"){
            $idiomacliente->lugar_formacion = $request->lugar_formacion;
        }

        $idiomacliente->save();

        return response()->json(["mensaje" => 'success']);
    }

    public function EditIdioma(Request $request)
    {
        $idiomausuario = IdiomaUsuario::where("id",$request->id)
        ->where("id_usuario", $this->user->id)->first();

        $idiomaname = Idiomas::select('descripcion')->where('id',$idiomausuario->id_idioma)->first();
        $idiomausuario->nombre_idioma = $idiomaname->descripcion;
        
        return response()->json(["datos" => $idiomausuario]);
    }

    public function EditarIdioma(Request $request)
    {
        $idioma = IdiomaUsuario::find($request->get("id"));
        $campos = $request->all();

        $idioma->fill($campos);
        if(route('home') == "https://gpc.t3rsc.co"){
            $idioma->lugar_formacion = $request->lugar_formacion;
        }
        $idioma->save();

        return response()->json(["mensaje" => "success"]);
    }

    public function EliminarIdioma(Request $request)
    {
        $idiomausuario = IdiomaUsuario::where("id", $request->id)->delete();

        return response()->json(["mensaje" => 'eliminado']);
    }

    public function guardar_preguntas_val(Request $request)
    {
        if($request->has('act') && $request->act == 1){
            $preg_val = PreguntaValidacion::where('user_id', $this->user->id)->first();

            $preg_val->respuesta_1 = $request->respuesta_1;
            $preg_val->respuesta_2 = $request->respuesta_2;
            $preg_val->respuesta_3 = $request->respuesta_3;
            $preg_val->respuesta_4 = $request->respuesta_4;

            $preg_val->save();
        }else{
            $nuevasPregs = new PreguntaValidacion();

            $nuevasPregs->fill([
                "user_id"       => $this->user->id,
                "respuesta_1"   => $request->respuesta_1,
                "respuesta_2"   => $request->respuesta_2,
                "respuesta_3"   => $request->respuesta_3,
                "respuesta_4"   => $request->respuesta_4
            ]);

            $nuevasPregs->save();
        }

        return response()->json(["success" => true]);
    }

    public function ver_video_perfil(Request $data)
    {
        //dd($data);
        $ruta = $data->ruta;
        return view("cv.ver_video_perfil", compact('ruta'));
    }

}
