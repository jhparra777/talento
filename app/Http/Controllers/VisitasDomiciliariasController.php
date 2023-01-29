<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CalificaCompetencia;
use App\Models\CompetenciaCliente;
use App\Models\DatosBasicos;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
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
use App\Models\VisitaCandidato;
use App\Models\VisitaAdmin;
use App\Models\Experiencias;
use App\Models\Requerimiento;
use \DB;
use App\Models\Sitio;
use App\Models\Bancos;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\TipoVisita;
use App\Models\ReferenciasPersonales;
use App\Models\ExperienciaVerificada;
use App\Models\EstudioVerificado;
use App\Models\ConsultaSeguridad;
use App\Models\Vetting;
use App\Models\EmpresaLogo;
use App\Models\ListaNegra;
use Illuminate\Support\Facades\Event;
use App\Events\PorcentajeHvEvent;
use App\Http\Requests;
use triPostmaster;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class VisitasDomiciliariasController extends Controller
{
    private $datos_basicos = [
        'tipo_id',
        'fecha_expedicion',
        'ciudad_exp_autocomplete',
        'fecha_nacimiento',
        'ciudad_nac_autocomplete',
        'ciudad_res_autocomplete',
        'estado_civil',
        'telefono_movil',
        'email',
        'numero_libreta',
        'clase_libreta',
        'direccion',
        'barrio',
        'datos_estrato',
        'pasaporte',
        'visa',
        'grupo_sanguineo',
        'rh',
        'categoria_licencia',
        'nro_licencia',
        'entidad_afp',
        'entidad_eps',
        'hijos',
    ];
    
    private $datos_basicos_verificables = [
        'tipo_id',
        'estado_civil',
        'clase_libreta',
        'categoria_licencia',
        'entidad_afp',
        'entidad_eps'
    ];

    //faltan los dinamicos
    private $estructura_familiar = [
        'fam_relacion',
        'fam_enfermedades',
        'fam_act_tmp_lbre',
        'fam_situaciones_dificiles',
        'metas_corto_plazo'
    ];

    private $apecto_vivienda = [
        'tipo_vivienda',
        'propiedad',
        'viv_serv_pub',
        'sector',
        'estrato',
        'viv_hipoteca',
        'viv_valor_hipoteca',
        'viv_tmp_resd',
        'viv_via_acc',
        'viv_alcantarillado',
        'viv_prs_externa',
        'viv_prs_interna',
        'viv_aseo_orden',
        'viv_amb_sector',
    ];

    private $apecto_vivienda_verificables = [
        'tipo_vivienda',
        'propiedad',
        'sector'
    ];

    private $egresos = [
        'ing_egr_servicios',
        'ing_egr_alimentacion',
        'ing_egr_jardin',
        'ing_egr_universidad',
        'ing_egr_otros',
        'total_egresos'
    ];

    private $salud = [
        'salud_lesiones_permanente',
        'salud_prob_psiquiatricos',
        'salud_tratamiento_perma',
        'salud_hospitalizado'
    ];

    private $info_adicional = [
        'info_demandas',
        'info_antecedentes',
        'info_sustancias',
        'info_ilicitas'
    ];
    
    private $visita_periodica = [
        'vp_trabaja',
        'vp_desempeño',
        'vp_fraude',
        'vp_llamado'
    ];

    private $formacion_academica = [
        'estudio_actual',
        'institucion',
        'titulo_obtenido',
        'ciudad_estudio',
        'nivel_estudio_id',
        'semestres_cursados',
        'periodicidad',
        'fecha_finalizacion',
        'telefono'
    ];
    
    public function index(Request $data)
    {

        /*$candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
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
            ->whereIn("procesos_candidato_req.proceso", ["VISITA_DOMICILIARIA"])
            ->select("procesos_candidato_req.proceso", "procesos_candidato_req.id as ref_id", "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente')
            ->paginate(8);
            */
        $estados=[1];
        $gestionado_admin=[0];
        $candidatos=VisitaCandidato::join("datos_basicos","datos_basicos.user_id","=","visitas_candidatos.candidato_id")
        ->leftjoin("clase_visita","clase_visita.id","=","visitas_candidatos.clase_visita_id")
        ->leftjoin("procesos_candidato_req", "procesos_candidato_req.visita_candidato_id", "=", "visitas_candidatos.id")
        //->whereNotIn("procesos_candidato_req.proceso", ["VISITA_DOMICILIARIA_EVS"])
        //->where("gestionado_admin",0)
        //->where("estado",1)
        ->where(function ($sql) use ($data,&$estados,&$gestionado_admin) {
            //Filtro por codigo requerimiento
            if ($data->codigo != "") {
                $sql->where("visitas_candidatos.requerimiento_id", $data->get("codigo"));
                $estados=[0,1];
                $gestionado_admin=[0,1];
            }

            //Filtro por cedula de candidato
            if ($data->cedula != "") {
                $sql->where("datos_basicos.numero_id", $data->get("cedula"));
                $estados=[0,1];
                $gestionado_admin=[0,1];
            }
        })
        ->whereIn("visitas_candidatos.estado",$estados)
        ->whereIn("visitas_candidatos.gestionado_admin",$gestionado_admin)
        ->select(
            "datos_basicos.*",
            "procesos_candidato_req.proceso",
            "visitas_candidatos.created_at as fecha_creacion",
            "visitas_candidatos.requerimiento_id",
            "visitas_candidatos.id as id_visita",
            "visitas_candidatos.gestionado_candidato",
            "clase_visita.descripcion as clase"
        )
        ->get();

        $filter = $candidatos->filter(function ($value){
            //Se excluyen las visitas domiciliarias de EVS
            return $value->proceso!='VISITA_DOMICILIARIA_EVS';
        });

        $candidatos = $filter->paginate(10);

        return view("admin.visita_domiciliaria.index", compact("candidatos"));
    }

    public function gestionarVisita($id, $tipo = null)
    {
        
        $candidato=VisitaCandidato::join("datos_basicos","datos_basicos.user_id","=","visitas_candidatos.candidato_id")
        ->leftjoin("tipos_visitas","tipos_visitas.id","=","visitas_candidatos.tipo_visita_id")
        ->join("clase_visita","clase_visita.id","=","visitas_candidatos.clase_visita_id")
        ->leftjoin("requerimientos","requerimientos.id","=","visitas_candidatos.requerimiento_id")
        ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->leftjoin('clientes', 'negocio.cliente_id', '=', 'clientes.id')
        //->where("gestionado_admin",0)
        //->where("estado",1)
        ->select("datos_basicos.*","visitas_candidatos.created_at as fecha_creacion","visitas_candidatos.requerimiento_id","visitas_candidatos.id as id_visita","tipos_visitas.descripcion as tipo_visita","clase_visita.descripcion as clase_visita","visitas_candidatos.gestionado_admin","visitas_candidatos.tipo_visita_id","visitas_candidatos.clase_visita_id","clientes.id as cliente_id","visitas_candidatos.vetting")
        ->find($id);

        $consulta=null;
        $proceso=null;
        if(!is_null($candidato->requerimiento_id)){
            $consulta = ConsultaSeguridad::where('user_id', $candidato->user_id)->where('req_id', $candidato->requerimiento_id)->first();
            if (is_null($tipo)) {
                $proceso=RegistroProceso::where("requerimiento_id",$candidato->requerimiento_id)
                    ->where("proceso","VISITA_DOMICILIARIA")
                    ->where("candidato_id",$candidato->user_id)
                ->first();
            } else {
                $proceso=RegistroProceso::where("requerimiento_id",$candidato->requerimiento_id)
                    ->where("proceso","VISITA_DOMICILIARIA_EVS")
                    ->where("candidato_id",$candidato->user_id)
                ->first();
            }

        }

        
        $vetting=DB::table("vetting")->where("visita_candidato_id",$candidato->id_visita)->first();

        $experiencias_verificadas = ExperienciaVerificada::
            join("experiencias", "experiencias.id", "=", "experiencia_verificada.experiencia_id")
            ->leftjoin("motivos_retiros", "motivos_retiros.id", "=", "experiencia_verificada.motivo_retiro_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
        //->where("experiencias.activo", "1")
            ->where("experiencias.user_id", $candidato->user_id)
            ->where("experiencia_verificada.visita_candidato_id", $candidato->id_visita)
            ->select("experiencias.*", "motivos_retiros.*", "cargos_genericos.*", "experiencia_verificada.*",
                "experiencia_verificada.meses_laborados as meses",
                "experiencia_verificada.anios_laborados as años",
                "cargos_genericos.descripcion as name_cargo",
                "motivos_retiros.descripcion as name_motivo",
                "experiencias.fecha_inicio as exp_fecha_inicio",
                "experiencias.fecha_final as exp_fechafin")
            ->get();

        $estudios_verificados = EstudioVerificado::join("estudios","estudios.id","=","estudios_verificados.estudios_id")
            ->join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->leftjoin("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "estudios.pais_estudio")
                ->on("ciudad.cod_ciudad", "=", "estudios.ciudad_estudio")
                ->on("ciudad.cod_departamento", "=", "estudios.departamento_estudio");
            })
            ->select("estudios.*","estudios_verificados.*","niveles_estudios.descripcion as desc_nivel","ciudad.nombre as ciudad")
            ->where("estudios.user_id", $candidato->user_id)
            ->where("estudios_verificados.visita_candidato_id", $candidato->id_visita)
            ->get();

        /*$estados_procesos_referenciacion = RegistroProceso::
            join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_ENTREVISTA", "ENVIO_ENTREVISTA_PENDIENTE"])->get();*/

        $visitas = VisitaCandidato::join("users", "users.id", "=", "visitas_candidatos.id_admin_gestion")
            //->join("tipo_fuente", "tipo_fuente.id", "=", "entrevistas_candidatos.fuentes_publicidad_id")
            ->where("visitas_candidatos.candidato_id", $candidato->user_id)
            ->where("visitas_candidatos.estado",1)
            ->where("gestionado_admin",1)
            ->where("visitas_candidatos.id","<>",$id)

            ->select("visitas_candidatos.*", "users.name as user_gestion")

            ->orderBy("visitas_candidatos.created_at", "desc")
            ->get();

         /*$entrevistas_semi = EntrevistaSemi::join("users", "users.id", "=", "entrevistas_candidatos.user_gestion_id")
            ->where("entrevista_semi.candidato_id", $candidato->user_id)
            ->select("entrevista_semi.*", "users.name")
            ->orderBy("entrevista_semi.created_at", "desc")
            ->get();*/

        /*$req_prueba_gestionado = [];
        $req_gestion           = EntrevistaCandidatos::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "entrevistas_candidatos.id")
            ->select("entrevistas_candidatos.id")
            ->where("proceso_requerimiento.requerimiento_id", $candidato->requerimiento_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_ENTREVISTA")->get();*/

        /*foreach ($req_gestion as $key => $value) {
            array_push($req_prueba_gestionado, $value->id);
        }*/

        $experiencias_laborales = Experiencias::leftjoin("paises", "paises.cod_pais", "=", "experiencias.pais_id")
        ->leftJoin("motivos_retiros", "motivos_retiros.id", "=", "experiencias.motivo_retiro")
        ->leftJoin("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
        ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "experiencias.salario_devengado")
        ->leftjoin("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "experiencias.pais_id")
            ->on("departamentos.cod_departamento", "=", "experiencias.departamento_id");
        })->leftjoin("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "experiencias.pais_id")
            ->on("ciudad.cod_ciudad", "=", "experiencias.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "experiencias.departamento_id");
        })->select(
            "aspiracion_salarial.descripcion as salario",
            "cargos_genericos.descripcion as desc_cargo",
            "motivos_retiros.descripcion as desc_motivo",
            \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudades"), "experiencias.*"
        )
        ->orderBy("experiencias.fecha_inicio", "desc")
        ->where("experiencias.user_id", $candidato->user_id)
        ->get();

        

        $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        ->where("estudios.user_id", $candidato->user_id)
        ->select("estudios.*", "niveles_estudios.descripcion as nivel_estudio")
        ->get();

        $grados=[""=>"Seleccionar"]+DB::table("grado_confiabilidad_evaluado")->pluck("descripcion","id")->toArray();

        return view("admin.visita_domiciliaria.gestionar_visita_domiciliaria", compact("candidato", "visitas","experiencias_laborales","referencias_personales","estudios","consulta","grados","vetting","experiencias_verificadas","estudios_verificados","proceso"));
    }

    public  function guardarVetting(Request $data){
        
        
        $newVetting= new Vetting();
        $newVetting->fill($data->all());
        $newVetting->user_gestiona=$this->user->id;
        $newVetting->save();

        $visita=VisitaCandidato::find($data->get("visita_candidato_id"));
        $visita->vetting=1;
        $visita->save();

        if ($data->hasFile('img_resumen')) {

                $archivo=$data->file('img_resumen');
                $extencion = $archivo->getClientOriginalExtension();
                $name_documento = 'resumen-'.$visita->id.'.'.$extencion;
                Storage::disk('public')->put('recursos_visita_domiciliaria/'.$visita->id.'/vetting/'.$name_documento,\File::get($archivo));
                $newVetting->resumen=$name_documento;
        }

        $newVetting->save();


        return response()->json(["success"=>true]);

    }

    public function agregarSoporteView(Request $data){

        $tipo=$data->get("tipo_soporte");
        $referencia=$data->get("referencia_id");
        $id_visita=$data->get("id_visita");
    
        return view("admin.visita_domiciliaria.modal.agregar_soporte", compact("tipo","referencia","id_visita"));
    }

    public function guardarSoporte(Request $data){
        
        $referencia=$data->get("ref_id");
        $tipo=$data->get("tipo_soporte");
        $id_visita=$data->get("id_visita");
        $array=[];

        if($data->hasFile('archivo_documento')){
            foreach ($data->file('archivo_documento') as $clave=>$imagen) {

                
                $extencion = $imagen->getClientOriginalExtension();
                $name_documento = $tipo.'-'.$clave."." .$extencion;
                Storage::disk('public')->put('recursos_visita_domiciliaria/'.$id_visita.'/soportes/'.$tipo.'/'.$name_documento,\File::get($imagen));

                $array[]=$name_documento;
            }
        }

        
        if($tipo=="experiencia"){
            $experiencia_verificada=ExperienciaVerificada::where("experiencia_id",$referencia)->where("visita_candidato_id",$id_visita)->first();
            $experiencia_verificada->soportes=implode(',',$array);
            $experiencia_verificada->save();

        }   
        else{
            $estudio_verificado=EstudioVerificado::where("visita_candidato_id",$id_visita)->where("estudios_id",$referencia)->first();
            $estudio_verificado->soportes=implode(',',$array);
            $estudio_verificado->save();
        }

        return response()->json(["success"=>true,"num_soportes"=>count($array)]);

    }

    public function gestionarInforme($id_visita){
        $visita=VisitaAdmin::where("visita_candidato_id",$id_visita)
        ->leftjoin("frecuencia","frecuencia.id","=","visitas_candidatos_admin.frecuencia_asistencia_medico")
        ->leftjoin("estados_civiles","estados_civiles.id","=","visitas_candidatos_admin.estado_civil")
        ->leftjoin("niveles_estudios","niveles_estudios.id","=","visitas_candidatos_admin.nivel_escolaridad")
        ->leftjoin("clases_libretas","clases_libretas.id","=","visitas_candidatos_admin.clase_libreta")
        ->leftjoin("tipo_vivienda","tipo_vivienda.id","=","visitas_candidatos_admin.tipo_vivienda")
        ->leftjoin("tipo_propiedad","tipo_propiedad.id","=","visitas_candidatos_admin.propiedad")
        ->leftjoin("medio_transporte","medio_transporte.id","=","visitas_candidatos_admin.medio_utilizado")
        ->leftjoin('requerimientos','requerimientos.id','=','visitas_candidatos_admin.requerimiento_id')
        ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->leftjoin("sector","sector.id","=","visitas_candidatos_admin.sector")
        //->leftjoin("localidad","localidad.id","=","visitas_candidatos_admin.localidad_id")
        ->leftjoin('clientes', 'negocio.cliente_id', '=', 'clientes.id')
        ->leftjoin('cargos_especificos','cargos_especificos.id',"=","requerimientos.cargo_especifico_id")
        
        ->select('visitas_candidatos_admin.*',"frecuencia.descripcion as frecuencia","estados_civiles.descripcion as estado_civil_persona","niveles_estudios.descripcion as nivel","clases_libretas.descripcion as clase_libreta","tipo_vivienda.descripcion as tipo_vivienda_descripcion","tipo_propiedad.descripcion as tipo_propiedad_descripcion","medio_transporte.descripcion as medio_transporte","sector.descripcion as sector_vivienda","clientes.nombre as cliente","cargos_especificos.descripcion as cargo")
        ->first();

        if($visita->requerimiento_id!=null){
            $logo=Requerimiento::join("empresa_logos","empresa_logos.id","=","requerimientos.empresa_contrata")
            ->select("empresa_logos.logo as logo_empresa")
            ->where("requerimientos.id",$visita->requerimiento_id)
            ->first();
        }
        else{
            $logo=EmpresaLogo::select("logo as logo_empresa")->find($visita->empresa_logo_id);
        }

        
        $distribucion_espacial=(array)json_decode($visita->distribucion_espacial);
        $mobiliario=(array)json_decode($visita->mobiliario);
        $enfermedades=(array)json_decode($visita->enfermedades_familia);
        $imagenes=(array)json_decode($visita->imagenes);


        $experiencias_verificadas=ExperienciaVerificada::where("visita_candidato_id",$id_visita)->get();

        $estudios_verificados=EstudioVerificado::where("visita_candidato_id",$id_visita)->get();

        


        $tipo_vivienda=DB::table("tipo_vivienda")->get();
        $tipo_propiedad=DB::table("tipo_propiedad")->get();

        $bancos       = Bancos::pluck("nombre_banco", "id")->toArray();
        $tipoVivienda       =DB::table("tipo_vivienda")->pluck("descripcion", "id");
        $tipoPropiedad       = DB::table("tipo_propiedad")->pluck("descripcion", "id");
        $tipos_credito       = DB::table("tipo_credito")->pluck("descripcion", "id");

        $tipos_inmuebles       = DB::table("tipo_inmueble")->pluck("descripcion", "id");

        $tipos_vehiculos      = DB::table("tipos_vehiculos")->pluck("descripcion", "id");

        $material_techo       = DB::table("material_vivienda")->where("tipo_material_id",1)->pluck("descripcion", "id");

        $material_paredes       = DB::table("material_vivienda")->where("tipo_material_id",2)->pluck("descripcion", "id");

        $material_piso       = DB::table("material_vivienda")->where("tipo_material_id",3)->pluck("descripcion", "id");

        $parentescos=Parentesco::pluck("descripcion","id")->toArray();

        $estadoCivil        = ["" => "Seleccionar"] + EstadoCivil::where("active", 1)->pluck("descripcion", "id")->toArray();

        $vetting=DB::table("vetting")->join("grado_confiabilidad_evaluado","grado_confiabilidad_evaluado.id","=","vetting.grado_confiabilidad")
        ->where("visita_candidato_id",$id_visita)
        ->select("vetting.*","grado_confiabilidad_evaluado.descripcion as grado","grado_confiabilidad_evaluado.oservacion as descripcion_grado")
        ->first();

        $consulta=null;

        if(!is_null($visita->requerimiento_id)){
            $consulta = ConsultaSeguridad::where('user_id', $visita->candidato_id)->where('req_id', $visita->requerimiento_id)->first();
        }
        else{
            $consulta=$visita->visita_candidato->consulta_sin_proceso;
        }


        
        $familiares=(array)json_decode($visita->familiares);

        $experiencias_verificadas = ExperienciaVerificada::
            join("experiencias", "experiencias.id", "=", "experiencia_verificada.experiencia_id")
            ->leftjoin("motivos_retiros", "motivos_retiros.id", "=", "experiencia_verificada.motivo_retiro_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
        //->where("experiencias.activo", "1")
            ->where("experiencias.user_id", $visita->candidato_id)
            ->where("experiencia_verificada.visita_candidato_id", $visita->visita_candidato_id)
            ->select("experiencias.*", "motivos_retiros.*", "cargos_genericos.*", "experiencia_verificada.*",
                "experiencia_verificada.meses_laborados as meses",
                "experiencia_verificada.anios_laborados as años",
                "cargos_genericos.descripcion as name_cargo",
                "motivos_retiros.descripcion as name_motivo",
                "experiencias.fecha_inicio as exp_fecha_inicio",
                "experiencias.fecha_final as exp_fechafin")
            ->get();

        $estudios_verificados = EstudioVerificado::join("estudios","estudios.id","=","estudios_verificados.estudios_id")
            ->join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
            ->leftjoin("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "estudios.pais_estudio")
                ->on("ciudad.cod_ciudad", "=", "estudios.ciudad_estudio")
                ->on("ciudad.cod_departamento", "=", "estudios.departamento_estudio");
            })
            ->select("estudios.*","estudios_verificados.*","niveles_estudios.descripcion as desc_nivel","ciudad.nombre as ciudad")
            ->where("estudios.user_id", $visita->candidato_id)
            ->where("estudios_verificados.visita_candidato_id", $visita->visita_candidato_id)
            ->get();


            $user=User::find($visita->candidato_id);


            /*return view('admin.visita_domiciliaria.informe.index',compact('visita','tipo_vivienda','tipo_propiedad','experiencias_verificadas','estudios_verificados','distribucion_espacial','mobiliario','bancos','tipos_credito','material_techo','material_piso','material_paredes','parentescos','tipos_inmuebles','tipos_vehiculos','vetting','familiares','enfermedades',"consulta","imagenes","user","logo","estadoCivil"));*/
        $view = \View::make('admin.visita_domiciliaria.informe.index',compact('visita','tipo_vivienda','tipo_propiedad','experiencias_verificadas','estudios_verificados','distribucion_espacial','mobiliario','bancos','tipos_credito','material_techo','material_piso','material_paredes','parentescos','tipos_inmuebles','tipos_vehiculos','vetting','familiares','enfermedades',"consulta","imagenes","user","logo","estadoCivil"))->render();
        $pdf =  app('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream('informe.pdf');

    }


    public function gestionarInforme_new($id_visita){

        $visita=VisitaAdmin::where("visita_candidato_id",$id_visita)
        ->leftjoin("datos_basicos","datos_basicos.user_id","=","visitas_candidatos_admin.candidato_id")
        ->leftjoin("entidades_afp","entidades_afp.id","=","visitas_candidatos_admin.entidad_afp")
        ->leftjoin("entidades_eps","entidades_eps.id","=","visitas_candidatos_admin.entidad_eps")
        ->leftjoin("tipo_identificacion","tipo_identificacion.id","=","visitas_candidatos_admin.tipo_id")
        ->leftjoin("frecuencia","frecuencia.id","=","visitas_candidatos_admin.frecuencia_asistencia_medico")
        ->leftjoin("estados_civiles","estados_civiles.id","=","visitas_candidatos_admin.estado_civil")
        ->leftjoin("niveles_estudios","niveles_estudios.id","=","visitas_candidatos_admin.nivel_escolaridad")
        ->leftjoin("clases_libretas","clases_libretas.id","=","visitas_candidatos_admin.clase_libreta")
        ->leftjoin("categorias_licencias","categorias_licencias.id","=","visitas_candidatos_admin.categoria_licencia")
        ->leftjoin("tipo_vivienda","tipo_vivienda.id","=","visitas_candidatos_admin.tipo_vivienda")
        ->leftjoin("tipo_propiedad","tipo_propiedad.id","=","visitas_candidatos_admin.propiedad")
        ->leftjoin("medio_transporte","medio_transporte.id","=","visitas_candidatos_admin.medio_utilizado")
        ->leftjoin('requerimientos','requerimientos.id','=','visitas_candidatos_admin.requerimiento_id')
        ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->leftjoin("sector","sector.id","=","visitas_candidatos_admin.sector")
        //->leftjoin("localidad","localidad.id","=","visitas_candidatos_admin.localidad_id")
        ->leftjoin('clientes', 'negocio.cliente_id', '=', 'clientes.id')
        ->leftjoin('cargos_especificos','cargos_especificos.id',"=","requerimientos.cargo_especifico_id")
        ->leftjoin("empresa_logos","empresa_logos.id","=","visitas_candidatos_admin.empresa_logo_id")
        ->leftjoin("users","users.id","=","datos_basicos.user_id")
        ->select('visitas_candidatos_admin.*',
        "frecuencia.descripcion as frecuencia",
        "estados_civiles.descripcion as estado_civil_persona",
        "niveles_estudios.descripcion as nivel",
        "clases_libretas.descripcion as clase_libreta_desc",
        "categorias_licencias.descripcion as cat_licencia",
        "tipo_vivienda.descripcion as tipo_vivienda_descripcion",
        "tipo_propiedad.descripcion as tipo_propiedad_descripcion",
        "medio_transporte.descripcion as medio_transporte",
        "sector.descripcion as sector_vivienda",
        "clientes.nombre as cliente",
        "cargos_especificos.descripcion as cargo",
        "entidades_afp.descripcion as afp",
        "entidades_eps.descripcion as eps",
        "tipo_identificacion.descripcion as tipo_documento",
        "empresa_logos.nombre_empresa as nombre_empresa",
        "empresa_logos.ciudad as ciudad_empresa",
        "users.foto_perfil as foto_perfil",
        "datos_basicos.pais_residencia as pais_residencia",
        "datos_basicos.departamento_residencia as departamento_residencia",
        "datos_basicos.ciudad_residencia as ciudad_residencia")
        ->first();

        $visita_candidato = VisitaCandidato::where("visitas_candidatos.id",$id_visita)
        ->leftjoin("datos_basicos","datos_basicos.user_id","=","visitas_candidatos.candidato_id")
        ->leftjoin("entidades_afp","entidades_afp.id","=","visitas_candidatos.entidad_afp")
        ->leftjoin("entidades_eps","entidades_eps.id","=","visitas_candidatos.entidad_eps")
        ->leftjoin("tipo_identificacion","tipo_identificacion.id","=","visitas_candidatos.tipo_id")
        ->leftjoin("frecuencia","frecuencia.id","=","visitas_candidatos.frecuencia_asistencia_medico")
        ->leftjoin("estados_civiles","estados_civiles.id","=","visitas_candidatos.estado_civil")
        ->leftjoin("niveles_estudios","niveles_estudios.id","=","visitas_candidatos.nivel_escolaridad")
        ->leftjoin("clases_libretas","clases_libretas.id","=","visitas_candidatos.clase_libreta")
        ->leftjoin("categorias_licencias","categorias_licencias.id","=","visitas_candidatos.categoria_licencia")
        ->leftjoin("tipo_vivienda","tipo_vivienda.id","=","visitas_candidatos.tipo_vivienda")
        ->leftjoin("tipo_propiedad","tipo_propiedad.id","=","visitas_candidatos.propiedad")
        ->leftjoin("medio_transporte","medio_transporte.id","=","visitas_candidatos.medio_utilizado")
        ->leftjoin('requerimientos','requerimientos.id','=','visitas_candidatos.requerimiento_id')
        ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->leftjoin("sector","sector.id","=","visitas_candidatos.sector")
        //->leftjoin("localidad","localidad.id","=","visita_candidato.localidad_id")
        ->leftjoin('clientes', 'negocio.cliente_id', '=', 'clientes.id')
        ->leftjoin('cargos_especificos','cargos_especificos.id',"=","requerimientos.cargo_especifico_id")
        ->select('visitas_candidatos.*',
        "frecuencia.descripcion as frecuencia",
        "estados_civiles.descripcion as estado_civil_persona",
        "niveles_estudios.descripcion as nivel",
        "clases_libretas.descripcion as clase_libreta_desc",
        "categorias_licencias.descripcion as cat_licencia",
        "tipo_vivienda.descripcion as tipo_vivienda_descripcion",
        "tipo_propiedad.descripcion as tipo_propiedad_descripcion",
        "medio_transporte.descripcion as medio_transporte",
        "sector.descripcion as sector_vivienda",
        "clientes.nombre as cliente",
        "cargos_especificos.descripcion as cargo",
        "entidades_afp.descripcion as afp",
        "entidades_eps.descripcion as eps",
        "tipo_identificacion.descripcion as tipo_documento")
        ->first();

        //Nombre de quien realizo la visita id_admin_gestion
        $visitador = VisitaAdmin::where("id_admin_gestion",$visita->id_admin_gestion)
        ->leftjoin("datos_basicos","datos_basicos.user_id","=","visitas_candidatos_admin.id_admin_gestion")
        ->select( "datos_basicos.nombres as nombres_admin",
        "datos_basicos.primer_apellido as primer_apellido_admin",
        "datos_basicos.segundo_apellido as segundo_apellido_admin")
        ->first();
        
        //Seccion familiares
        $parentescos = Parentesco::pluck("descripcion","id")->toArray();
        $estadoCivil = EstadoCivil::where("active", 1)->pluck("descripcion", "id")->toArray();
        $familiares=(array)json_decode($visita->familiares);

        //Seccion ingresos
        $ingresos=(array)json_decode($visita->ing_egr_familiar);

        //Seccion reportes central
        $bancos = Bancos::pluck("nombre_banco", "id")->toArray();
        $reportes=(array)json_decode($visita->reportes_central);
        
        //Seccion creditos
        $creditos=(array)json_decode($visita->creditos_bancarios);

        //Seccion inmuebles
        $ciudades_general = Ciudad::pluck("nombre", "id");
        $tipoPropiedad = DB::table("tipo_propiedad")->pluck("descripcion", "id");
        $inmuebles=(array)json_decode($visita->inmuebles);

        //Seccion vehiculos
        $vehiculos=(array)json_decode($visita->vehiculos);

        //Seccion formacion academica
        $periodicidad = DB::table("periodicidad")->pluck("descripcion", "id");
        $nivelEstudio = DB::table("niveles_estudios")->where("active", 1)->pluck("descripcion", "id");
        $estudios=(array)json_decode($visita->formacion_academica);

        //Seccion informacion laboral
        $motivoRetiro = DB::table("motivos_retiros")->where("active", 1)->pluck("descripcion", "id");
        $experiencias=(array)json_decode($visita->experiencia_laboral);

        //Seccion registro fotografico
        $imagenes=(array)json_decode($visita->imagenes);

        //Diferencia frm statico datos basicos
        $db_diferentes = $this->diferencias(
            $visita->toArray(),
            $visita_candidato->toArray(),
            $this->datos_basicos,
            $this->datos_basicos_verificables
        );

        //Diferencia frm statico familiares
        $fam_diferentes = $this->diferencias(
            $visita->toArray(),
            $visita_candidato->toArray(),
            $this->estructura_familiar,
            null
        );
        //Diferencia frm dinamicos familiares
        $fam_adm = (array)json_decode($visita->familiares);
        $fam_cand = (array)json_decode($visita_candidato->familiares);
        $familiares_diferentes = $this->diferencias_dinamicas(
            $fam_adm,
            $fam_cand
        );

        //Diferencia frm statico vivienda
        $viv_diferentes = $this->diferencias(
            $visita->toArray(),
            $visita_candidato->toArray(),
            $this->apecto_vivienda,
            $this->apecto_vivienda_verificables
        );

        //Diferencia frm dinamicos ingresos
        $ing_adm = (array)json_decode($visita->ing_egr_familiar);
        $ing_cand = (array)json_decode($visita_candidato->ing_egr_familiar);
        $ingresos_diferentes = $this->diferencias_dinamicas(
            $ing_adm,
            $ing_cand
        );

        //Diferencia frm statico egresos
        $egresos_diferentes = $this->diferencias(
            $visita->toArray(),
            $visita_candidato->toArray(),
            $this->egresos,
            null
        );

        //Diferencia frm dinamicos reporte central
        $rpt_adm = (array)json_decode($visita->reportes_central);
        $rpt_cand = (array)json_decode($visita_candidato->reportes_central);
        $reporte_central_diferentes = $this->diferencias_dinamicas(
            $rpt_adm,
            $rpt_cand
        );

        //Diferencia frm dinamicos creditos bancarios
        $cred_adm = (array)json_decode($visita->creditos_bancarios);
        $cred_cand = (array)json_decode($visita_candidato->creditos_bancarios);
        $creditos_bancarios_diferentes = $this->diferencias_dinamicas(
            $cred_adm,
            $cred_cand
        );

        //Diferencia frm statico salud 
        $salud_diferentes = $this->diferencias(
            $visita->toArray(),
            $visita_candidato->toArray(),
            $this->salud,
            null
        );

        //Diferencia frm statico info_adicional 
        $info_adic_diferentes = $this->diferencias(
            $visita->toArray(),
            $visita_candidato->toArray(),
            $this->info_adicional,
            null
        );

        //Diferencia frm statico visita periodica
        $visita_periodica_diferentes = $this->diferencias(
            $visita->toArray(),
            $visita_candidato->toArray(),
            $this->visita_periodica,
            null
        );

        // Diferencia frm dinamico formacion academica
        $fa_adm = (array)json_decode($visita->formacion_academica);
        $fa_cand = (array)json_decode($visita_candidato->formacion_academica);
        $formacion_academica_diferentes = $this->diferencias_dinamicas(
            $fa_adm,
            $fa_cand
        );

        // Diferencia frm dinamico formacion laboral
        $lab_adm = (array)json_decode($visita->experiencia_laboral);
        $lab_cand = (array)json_decode($visita_candidato->experiencia_laboral);
        $formacion_laboral_diferentes = $this->diferencias_dinamicas(
            $lab_adm,
            $lab_cand
        );

        // Diferencia frm dinamico inmuebles
        $inm_adm = (array)json_decode($visita->inmuebles);
        $inm_cand = (array)json_decode($visita_candidato->inmuebles);
        $inmuebles_diferentes = $this->diferencias_dinamicas(
            $inm_adm,
            $inm_cand
        );

        // Diferencia frm dinamico inmuebles
        $veh_adm = (array)json_decode($visita->vehiculos);
        $veh_cand = (array)json_decode($visita_candidato->vehiculos);
        $vehiculos_diferentes = $this->diferencias_dinamicas(
            $veh_adm,
            $veh_cand
        );

        return view("admin.visita_domiciliaria.informe.index_new", 
        compact(
            'visita',
            'visitador',
            // 'ciudad_exp_autocomplete',
            // 'ciudad_nac_autocomplete',
            'familiares',
            'parentescos',
            'estadoCivil',
            'bancos',
            'ingresos',
            'reportes',
            'creditos',
            'tipoPropiedad',
            'ciudades_general',
            'inmuebles',
            'vehiculos',
            'periodicidad',
            'nivelEstudio',
            'estudios',
            'motivoRetiro',
            'experiencias',
            'imagenes',
            'db_diferentes',
            'fam_diferentes',
            'viv_diferentes',
            'egresos_diferentes',
            'salud_diferentes',
            'info_adic_diferentes',
            'visita_periodica_diferentes',
            'formacion_academica_diferentes',
            'formacion_laboral_diferentes',
            'familiares_diferentes',
            'ingresos_diferentes',
            'reporte_central_diferentes',
            'creditos_bancarios_diferentes',
            'inmuebles_diferentes',
            'vehiculos_diferentes'
        ));
    }

    public function realizarVisitaAdmin($visita_id,$edit=false){

        if($edit){
             $candidatos=VisitaAdmin::select("visitas_candidatos_admin.*","visitas_candidatos_admin.visita_candidato_id as id_visita")->where("visita_candidato_id",$visita_id)->first();

             $owner_pic="admin";
        }
        else{
         
            $candidatos=VisitaCandidato::leftjoin("requerimientos","requerimientos.id","=","visitas_candidatos.requerimiento_id")
                ->leftjoin('negocio','negocio.id',"=","requerimientos.negocio_id")
                ->leftjoin('clientes','clientes.id',"=","negocio.cliente_id")
                ->leftjoin('cargos_especificos','cargos_especificos.id','=','requerimientos.cargo_especifico_id')
                ->select("visitas_candidatos.*","visitas_candidatos.id as id_visita","clientes.nombre as cliente","cargos_especificos.descripcion as cargo")->find($visita_id);

            if(!$candidatos->gestionado_candidato){
                $candidatos=VisitaCandidato::join("datos_basicos","datos_basicos.user_id","=","visitas_candidatos.candidato_id")
                ->leftjoin("requerimientos","requerimientos.id","=","visitas_candidatos.requerimiento_id")
                ->leftjoin('negocio','negocio.id',"=","requerimientos.negocio_id")
                ->leftjoin('clientes','clientes.id',"=","negocio.cliente_id")
                ->leftjoin('cargos_especificos','cargos_especificos.id','=','requerimientos.cargo_especifico_id')
                ->where("visitas_candidatos.gestionado_candidato",0)
                ->where("visitas_candidatos.estado",1)
                ->where("visitas_candidatos.id",$visita_id)
                ->select("visitas_candidatos.*","datos_basicos.*","visitas_candidatos.created_at as fecha_creacion","visitas_candidatos.requerimiento_id","visitas_candidatos.id as id_visita","clientes.nombre as cliente","cargos_especificos.descripcion as cargo")
                ->first();
            }


            $owner_pic="evaluado";
        }
        
        $current_user=$this->user;
        $paises = ["" => "Seleccionar"] + Pais::orderBy('nombre')->pluck("nombre", "cod_pais")->toArray();

        $dptos_expedicion = ["" => "Seleccionar"] + Departamento::orderBy('nombre')->where("cod_pais", $candidatos->pais_id)
        ->pluck("nombre", "cod_departamento")
        ->toArray();

        $ciudades_expedicion = ["" => "Seleccionar"] + Ciudad::orderBy('nombre')->where("cod_pais", $candidatos->pais_id)
        ->where("cod_departamento", $candidatos->departamento_expedicion_id)
        ->pluck("nombre", "cod_ciudad")
        ->toArray();

        $dptos_residencia = ["" => "Seleccionar"] + Departamento::orderBy('nombre')->where("cod_pais", $candidatos->pais_residencia)
        ->pluck("nombre", "cod_departamento")
        ->toArray();

        $ciudades_residencia = ["" => "Seleccionar"] + Ciudad::orderBy('nombre')->where("cod_pais", $candidatos->pais_residencia)
        ->where("cod_departamento", $candidatos->departamento_residencia)
        ->pluck("nombre", "cod_ciudad")
        ->toArray();

        $estadoCivil        = ["" => "Seleccionar"] + EstadoCivil::where("active", 1)->pluck("descripcion", "id")->toArray();

        $claseLibreta       = ["" => "Seleccionar"] + ClaseLibreta::where("active", 1)->pluck("descripcion", "id")->toArray();

         $bancos       = ["" => "Seleccionar"] + Bancos::pluck("nombre_banco", "id")->toArray();

         $nivelEstudios= ["" => "Seleccionar"] + NivelEstudios::where("active", 1)->pluck("descripcion","id")->toArray();

        $tipoVivienda       = ["" => "Seleccionar"] + DB::table("tipo_vivienda")->where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoPropiedad       = ["" => "Seleccionar"] + DB::table("tipo_propiedad")->where("active", 1)->pluck("descripcion", "id")->toArray();
        $medioTransporte       = ["" => "Seleccionar"] + DB::table("medio_transporte")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $sector       = ["" => "Seleccionar"] + DB::table("sector")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $material_techo       = ["" => "Seleccionar"] + DB::table("material_vivienda")->where("tipo_material_id",1)->where("active", 1)->pluck("descripcion", "id")->toArray();

        $material_paredes       = ["" => "Seleccionar"] + DB::table("material_vivienda")->where("tipo_material_id",2)->where("active", 1)->pluck("descripcion", "id")->toArray();

        $material_piso       = ["" => "Seleccionar"] + DB::table("material_vivienda")->where("tipo_material_id",3)->where("active", 1)->pluck("descripcion", "id")->toArray();

        $tipos_credito       = ["" => "Seleccionar"] + DB::table("tipo_credito")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $tipos_inmuebles       = ["" => "Seleccionar"] + DB::table("tipo_inmueble")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $tipos_vehiculos      = ["" => "Seleccionar"] + DB::table("tipos_vehiculos")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $frecuencia      = ["" => "Seleccionar"] + DB::table("frecuencia")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $localidades      = ["" => "Seleccionar"] + DB::table("localidad")->where("active", 1)->pluck("descripcion", "id")->toArray();

        //$familiares=GrupoFamilia::where("user_id", $this->user->id)->get();
        $parentescos=[""=>"Seleccionar"]+Parentesco::where("active",1)->pluck("descripcion","id")->toArray();
        $tipo_familia= ["" => "Seleccionar"] + DB::table("tipo_familia")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $tipos_tarjeta      = ["" => "Seleccionar"] + DB::table("tipo_tarjeta_credito")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $distribucion_espacial=(array)json_decode($candidatos->distribucion_espacial);
        $mobiliario=(array)json_decode($candidatos->mobiliario);
        $enfermedades_familia=(array)json_decode($candidatos->enfermedades_familia);
        $familiares=(array)json_decode($candidatos->familiares);
        $imagenes=(array)json_decode($candidatos->imagenes);

        //Codigo nueva interfaz
        //Se busca ciudades expedicion con autocomplete
        $ciudad_exp = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $candidatos->pais_id)
        ->where("ciudad.cod_departamento", $candidatos->departamento_expedicion_id)
        ->where("ciudad.cod_ciudad", $candidatos->ciudad_expedicion_id)
        ->first();

        $txt_ciudad_expedicion = "";
        if ($ciudad_exp != null) {
            $txt_ciudad_expedicion = $ciudad_exp->value;
        }

        //Se busca ciudad de nac con autocomplete
        $ciudad_nac = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $candidatos->pais_nacimiento)
        ->where("ciudad.cod_departamento", $candidatos->departamento_nacimiento)
        ->where("ciudad.cod_ciudad", $candidatos->ciudad_nacimiento)
        ->first();

        $txt_ciudad_nac = "";
        if ($ciudad_nac != null) {
            $txt_ciudad_nac = $ciudad_nac->value;
        }

         //Se busca ciudad de residencia con autocomplete
         $ciudad_res = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $candidatos->pais_residencia)
        ->where("ciudad.cod_departamento", $candidatos->departamento_residencia)
        ->where("ciudad.cod_ciudad", $candidatos->ciudad_residencia)
        ->first();
        // dd($ciudad_res);
        $txt_ciudad_resd = "";
        if ($ciudad_res != null) {
            $txt_ciudad_resd = $ciudad_res->value;
        }

        $entidadesEps       = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();

        $entidadesAfp       = ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();
        
        $categoriaLicencias = ["" => "Seleccionar"] + CategoriaLicencias::where("active", 1)
        ->select(\DB::raw("CONCAT(codigo,' ',descripcion) as descripcion_categoria"), "id")
        ->pluck("descripcion_categoria", "id")
        ->toArray();

        //se busca ciudades para bienes
        $ciudades_nacimiento = ["" => "Seleccionar"] + Ciudad::orderBy(DB::raw("UPPER(nombre)"))->where("cod_pais", $candidatos->pais_nacimiento)
        ->where("cod_departamento", $candidatos->departamento_nacimiento)
        ->pluck("nombre", "cod_ciudad")
        ->toArray();

        //para formacion academica
        $estudios=(array)json_decode($candidatos->formacion_academica);
        $periodicidad=[""=>"Seleccionar"] + DB::table("periodicidad")->pluck("descripcion","id")->toArray();

        //para experiencia laboral
        $experiencias=(array)json_decode($candidatos->experiencia_laboral);
        $motivos = ["" => "Seleccionar"] + MotivoRetiro::where("active", "1")->orderBy("id")->pluck("descripcion", "id")->toArray();
        $tipos_documentos   = ["" => "Seleccionar"] + TipoIdentificacion::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();
        $ciudades_general = ["" => "Seleccionar"] + Ciudad::pluck("nombre", "id")->toArray() ;

        return view("admin.visita_domiciliaria.realizar_visita_admin_new", compact("candidatos","current_user",'candidatos','logo',"estadoCivil","claseLibreta","tipoVivienda","sector","material_techo","material_paredes","material_piso","tipo_familia","current_user","familiares","parentescos","tipoPropiedad","medioTransporte","bancos","tipos_credito","tipos_inmuebles","tipos_vehiculos","frecuencia","paises","dptos_expedicion","ciudades_expedicion","dptos_residencia","ciudades_residencia","nivelEstudios","distribucion_espacial","mobiliario","tipos_tarjeta","localidades","enfermedades_familia","imagenes","owner_pic","edit","txt_ciudad_expedicion","txt_ciudad_nac","ciudades_nacimiento","estudios","periodicidad","experiencias","motivos","tipos_documentos","entidadesEps","entidadesAfp","categoriaLicencias","ciudades_general","txt_ciudad_resd"));
    }

    //Nueva entrevista
    public function nuevaVisita(Request $data)
    {
      
            $tipos_visitas=[""=>"Seleccionar"]+TipoVisita::where("active",1)->whereIn("id",[2,3])->pluck("descripcion","id")->toArray();
            $clase_visita=[""=>"Seleccionar"]+DB::table("clase_visita")->where("active",1)->pluck("descripcion","id")->toArray();
            $empresa_logo = ["" => "Seleccionar"] + EmpresaLogo::pluck("nombre_empresa", "id")->toArray();

            return view("admin.visita_domiciliaria.modal.create", compact("tipos_visitas","clase_visita","empresa_logo"));

        
    }
    public function cancelarVisita(Request $data){
        $visita=VisitaCandidato::find($data->get("id_visita"));
        $visita->estado=0;
        $visita->save();

        return response()->json(["success"=>true]);
    }

    public function saveVisitaAdmin(Request $data){

        
        
        $visita=VisitaAdmin::where("visita_candidato_id",$data->get("id_visita"))->first();
        $visita->fill($data->all());
        //$visita->gestionado_candidato=1;
        //$visita->fecha_gestion_candidato=date("Y-m-d");
        //$visita->ip_candidato=$data->ip();

        $visita->save();

            if($data->has('parentesco')){
            $parentesco=$data->parentesco;
            $nombre_familiar=$data->nombre_familiar;
            $primer_apellido_familiar=$data->primer_apellido_familiar;
            $segundo_apellido_familiar=$data->segundo_apellido_familiar;
            $edad_familiar=$data->edad_familiar;
            $ocupacion_familiar=$data->ocupacion_familiar;
            $estado_civil_familiar=$data->estado_civil_familiar;
            $convive_con_el=$data->convive_con_el;
            $depend_econ_familiar=$data->depend_econ_familiar;
            $num_contacto_familiar=$data->num_contacto_familiar;
            $profesion_id=$data->profesion_id;

        //INICIO de lógica para guardar JSON

            $familiares=array();
            for($i=0;$i<count($parentesco);$i++){

                
                        $familiar=array("parentesco_id"=>$parentesco[$i],"nombres"=>$nombre_familiar[$i],"edad_fam"=>$edad_familiar[$i],"ocupacion_fam"=>$ocupacion_familiar[$i],"profesion_id"=>$profesion_id[$i],"primer_apellido_fam"=>$primer_apellido_familiar[$i],"segundo_apellido_fam"=>$segundo_apellido_familiar[$i],"convive_con_el"=>$convive_con_el[$i],"depend_econ_fam"=>$depend_econ_familiar[$i],"numero_contacto_familiar"=>$num_contacto_familiar[$i],"estado_civil_id"=>$estado_civil_familiar[$i]);

                        array_push($familiares,$familiar);
                

            $visita->familiares=json_encode($familiares);


            }
        }//fin familiares

        //DISTRIBUCION ESPACIAL

        $distribucion_espacial=[
            "habitaciones"=>$data->get("habitaciones"),
            "banos"=>$data->get("banos"),
            "cocina"=>$data->get("cocina"),
            "sala"=>$data->get("sala"),
            "patio"=>$data->get("patio"),
            "comedor"=>$data->get("comedor"),
            "garage"=>$data->get("garage"),
            "estudio"=>$data->get("estudio")

        ];

        //MOBILIARIO

        $mobiliario=[
            "televisor"=>$data->get("televisor"),
            "lavadora"=>$data->get("lavadora"),
            "estereo"=>$data->get("estereo"),
            "nevera"=>$data->get("nevera"),
            "dvd"=>$data->get("dvd"),
            "video_juegos"=>$data->get("video_juegos"),
            "estufa"=>$data->get("estufa"),
            "microondas"=>$data->get("microondas"),
            "pc"=>$data->get("pc"),
            "portatil"=>$data->get("portatil"),


        ];

        $enfermedades_familia=[
            "alergias"=>$data->get("alergias"),
            "alzheimer"=>$data->get("alzheimer"),
            "cancer"=>$data->get("cancer"),
            "diabetes"=>$data->get("diabetes"),
            "epilepsia"=>$data->get("epilepsia"),
            "hipertension"=>$data->get("hipertension"),
            "asma"=>$data->get("asma"),
            "epoc"=>$data->get("epoc")
        
        ];

        $visita->distribucion_espacial=json_encode($distribucion_espacial);
        $visita->mobiliario=json_encode($mobiliario);
        $visita->enfermedades_familia=json_encode($enfermedades_familia);


        //INGRESOS Y EGRESOS
            //CREDITOS
            $creditos=null;
            if($data->has('tiene_creditos_bancarios')){
                $banco_credito=$data->get("banco_credito");
                $tipo_credito=$data->get("tipo_credito");
                $total_credito=$data->get("total_credito");
                $cuota_credito=$data->get("cuota_credito");
                $creditos=array();
                for($i=0;$i<count($banco_credito);$i++){

                    if($banco_credito[$i]!='' && $tipo_credito[$i]!='' && $total_credito[$i]!='' && $cuota_credito[$i]!=''){
                            $credito=array("banco"=>$banco_credito[$i],"tipo_credito"=>$tipo_credito[$i],"cuota"=>$cuota_credito[$i],"total"=>$total_credito[$i]);

                            array_push($creditos,$credito);
                    }

            
                }
            }
            //TARJETAS CREDITO
            $tarjetas=null;
            if($data->has('tiene_tarjetas_credito')){
                $banco_tarjeta=$data->get("banco_tarjeta");
                $tipo_tarjeta=$data->get("tipo_tarjeta");
                $total_tarjeta=$data->get("total_tarjeta");
                $cuota_tarjeta=$data->get("cuota_tarjeta");
                $tarjetas=array();
                for($i=0;$i<count($banco_tarjeta);$i++){

                    if($banco_tarjeta[$i]!='' && $tipo_tarjeta[$i]!='' && $total_tarjeta[$i]!='' && $cuota_tarjeta[$i]!=''){
                            $tarjeta=array("banco"=>$banco_tarjeta[$i],"tipo_tarjeta"=>$tipo_tarjeta[$i],"total"=>$total_tarjeta[$i],"cuota"=>$cuota_tarjeta[$i]);

                            array_push($tarjetas,$tarjeta);
                    }

            
                }
            }

            //REPORTES CENREALES RIESGO
            $reportes=null;
            if($data->has('tiene_reportes_centrales')){
                $banco_central=$data->get("banco_central");
                $tipo_credito_central=$data->get("tipo_credito_central");
                $dias_mora_central=$data->get("dias_mora_central");
                $acuerdo_pago_central=$data->get("acuerdo_pago_central");
                $reportes=array();
                for($i=0;$i<count($banco_central);$i++){

                    if($banco_central[$i]!='' && $tipo_credito_central[$i]!='' && $dias_mora_central[$i]!='' && $acuerdo_pago_central[$i]!=''){
                            $reporte=array("banco"=>$banco_central[$i],"tipo_credito"=>$tipo_credito_central[$i],"dias_mora"=>$dias_mora_central[$i],"acuerdo_pago"=>$acuerdo_pago_central[$i]);

                            array_push($reportes,$reporte);
                    }

            
                }
            }

        //BIENES INMUEBLES
            //INMUEBLES
            $inmuebles=null;
            if($data->has('tiene_bienes_inmuebles')){
                $tipo_inmueble=$data->get("tipo_inmueble");
                $valor_inmueble_bienes=$data->get("valor_inmueble_bienes");
                $participacion_inmueble_bienes=$data->get("participacion_inmueble_bienes");
                $porcentaje_inmueble=$data->get("porcentaje_inmueble");
                $observaciones_inmuebles=$data->get("observaciones_inmuebles");
                $inmuebles=array();
                for($i=0;$i<count($tipo_inmueble);$i++){

                    if($tipo_inmueble[$i]!='' && $participacion_inmueble_bienes[$i]!='' && $valor_inmueble_bienes[$i]!=''){
                            $inmueble=array("tipo"=>$tipo_inmueble[$i],"valor"=>$valor_inmueble_bienes[$i],"participacion"=>$participacion_inmueble_bienes[$i],"porcentaje"=>$porcentaje_inmueble[$i],"observaciones"=>$observaciones_inmuebles[$i]);

                            array_push($inmuebles,$inmueble);
                    }

            
                }
            }

            //VEHICULOS
            $vehiculos=null;
            if($data->has('tiene_vehiculos')){
                $tipo_vehiculo_bienes=$data->get("tipo_vehiculo_bienes");
                $valor_vehiculo_bienes=$data->get("valor_vehiculo_bienes");
                $modelo_vehiculo_bienes=$data->get("modelo_vehiculo_bienes");
                $placas_vehiculos_bienes=$data->get("placas_vehiculos_bienes");
                $participacion_vehiculo_bienes=$data->get("participacion_vehiculo_bienes");
                $porcentaje_vehiculo=$data->get("porcentaje_vehiculo");
                $observaciones_vehiculos=$data->get("observaciones_vehiculos");
                $vehiculos=array();
                for($i=0;$i<count($tipo_vehiculo_bienes);$i++){

                    if($tipo_vehiculo_bienes[$i]!='' && $participacion_vehiculo_bienes[$i]!='' && $valor_vehiculo_bienes[$i]!=''){
                            $vehiculo=array("tipo"=>$tipo_vehiculo_bienes[$i],"modelo"=>$modelo_vehiculo_bienes[$i],"valor"=>$valor_vehiculo_bienes[$i],"placas"=>$placas_vehiculos_bienes[$i],"participacion"=>$participacion_vehiculo_bienes[$i],"porcentaje"=>$porcentaje_vehiculo[$i],"observaciones"=>$observaciones_vehiculos[$i]);

                            array_push($vehiculos,$vehiculo);
                    }

            
                }
            }

            //***Inicio de interfaz nueva***

            //INGRESOS NUEVOS
            if ($data->has('ing_egr_nombre')) {
                $ing_egr_nombre = $data->ing_egr_nombre;
                $ing_egr_ingreso = $data->ing_egr_ingreso;
                $ing_egr_aporte = $data->ing_egr_aporte;
            }

            $ingresos = array();

            for($i=0; $i<count($ing_egr_nombre); $i++){ 
                $ingreso=array("ing_egr_nombre"=>$ing_egr_nombre[$i],"ing_egr_ingreso"=>$ing_egr_ingreso[$i],"ing_egr_aporte"=>$ing_egr_aporte[$i]);

                array_push($ingresos,$ingreso);
            }

            //REPORTES CENTRALES RIESGO NUEVO
            if($data->has('tiene_reportes_centrales_')){
                $banco_central=$data->get("banco_central");
                $hace_cuanto_reportado=$data->get("hace_cuanto_reportado");
                $valor_reportado=$data->get("valor_reportado");
                $reportes=array();
                for($i=0; $i<count($banco_central); $i++){
                    $reporte=array("banco"=>$banco_central[$i],"hace_cuanto_reportado"=>$hace_cuanto_reportado[$i],"valor_reportado"=>$valor_reportado[$i]);

                    array_push($reportes,$reporte);
                }
            }

            //CREDITOS NUEVO
            $creditos=null;
            if($data->has('tiene_creditos_bancarios_')){
                $banco_credito=$data->get("banco_credito");
                $hace_cuanto_reportado_credito=$data->get("hace_cuanto_reportado_credito");
                $valor_reportado_credito=$data->get("valor_reportado_credito");
                $creditos=array();
                for($i=0;$i<count($banco_credito);$i++){

                    $credito=array("banco"=>$banco_credito[$i],"hace_cuanto_reportado_credito"=>$hace_cuanto_reportado_credito[$i],"valor_reportado_credito"=>$valor_reportado_credito[$i]);
                    array_push($creditos,$credito);
                }
            }

            //INMUEBLES NUEVO
            if($data->has('tiene_bienes_inmuebles_')){
                $tipo_inmueble=$data->get("tipo_inmueble");
                $direccion_inmueble=$data->get("direccion_inmueble");
                $ciudad_inmueble=$data->get("ciudad_inmueble");
                $valor_inmueble_bienes=$data->get("valor_inmueble_bienes");
                $inmuebles=array();

                for($i=0;$i<count($tipo_inmueble);$i++){

                    $inmueble=array("tipo_inmueble"=>$tipo_inmueble[$i],"direccion_inmueble"=>$direccion_inmueble[$i],"ciudad_inmueble"=>$ciudad_inmueble[$i],"valor_inmueble_bienes"=>$valor_inmueble_bienes[$i]);
                    array_push($inmuebles,$inmueble);
                }
            }

             //VEHICULOS NUEVO
             if($data->has('tiene_vehiculos_')){
                $Marca=$data->get("Marca");
                $modelo_vehiculo_bienes=$data->get("modelo_vehiculo_bienes");
                $placas_vehiculos_bienes=$data->get("placas_vehiculos_bienes");
                $valor_vehiculo_bienes=$data->get("valor_vehiculo_bienes");
                $vehiculos=array();
                for($i=0;$i<count($Marca);$i++){

                    $vehiculo=array("Marca"=>$Marca[$i],"modelo_vehiculo_bienes"=>$modelo_vehiculo_bienes[$i],"valor_vehiculo_bienes"=>$valor_vehiculo_bienes[$i],"placas_vehiculos_bienes"=>$placas_vehiculos_bienes[$i]);
                    array_push($vehiculos,$vehiculo);
                }
            }

            //FORMACION ACADEMICA
            $formaciones=null;
            if($data->has('fa_institucion')){
                $fa_estudio_actual=$data->get("fa_estudio_actual");
                $fa_institucion=$data->get("fa_institucion");
                $fa_titulo_obtenido=$data->get("fa_titulo_obtenido");
                $fa_ciudad=$data->get("fa_ciudad");
                $fa_nivel_estudio=$data->get("fa_nivel_estudio");
                $fa_semestres_cursados=$data->get("fa_semestres_cursados");
                $fa_periodicidad=$data->get("fa_periodicidad");
                $fa_fecha_finalizacion=$data->get("fa_fecha_finalizacion");
                $fa_telefono=$data->get("fa_telefono");
                $fa_concepto=$data->get("fa_concepto");
                $formaciones=array();
                for($i=0; $i<count($fa_institucion) ;$i++){
                        
                    $formacion=array(
                        "estudio_actual"=>$fa_estudio_actual[$i],
                        "institucion"=>$fa_institucion[$i],
                        "titulo_obtenido"=>$fa_titulo_obtenido[$i],
                        "ciudad_estudio"=>$fa_ciudad[$i],
                        "nivel_estudio_id"=>$fa_nivel_estudio[$i],
                        "semestres_cursados"=>$fa_semestres_cursados[$i],
                        "periodicidad"=>$fa_periodicidad[$i],
                        "fecha_finalizacion"=>$fa_fecha_finalizacion[$i],
                        "telefono"=>$fa_telefono[$i],
                        "concepto"=>$fa_concepto[$i]
                    );
                    array_push($formaciones,$formacion);
                       
                }
            }

            //EXPERIENCIA LABORAL
            $experiencias=null;
            if($data->has('tiene_experiencia_')){
                $exp_trabajo_actual=$data->get("exp_trabajo_actual");
                $exp_empresa=$data->get("exp_empresa");
                $exp_cargo=$data->get("exp_cargo");
                $exp_fecha_ingreso=$data->get("exp_fecha_ingreso");
                $exp_fecha_retiro=$data->get("exp_fecha_retiro");
                $exp_motivo_retiro=$data->get("exp_motivo_retiro");
                $exp_telefono_contacto=$data->get("exp_telefono_contacto");
                $exp_concepto=$data->get("exp_concepto");
                $experiencias=array();
                for($i=0;$i<count($exp_empresa);$i++){

                    if($exp_empresa[$i]!='' && $exp_cargo[$i]!=''){
                        
                        $experiencia=array("empleo_actual"=>$exp_trabajo_actual[$i], "nombre_empresa"=>$exp_empresa[$i],"cargo_especifico"=>$exp_cargo[$i],"fecha_inicio"=>$exp_fecha_ingreso[$i],"fecha_final"=>$exp_fecha_retiro[$i],"motivo_retiro"=>$exp_motivo_retiro[$i],"movil_jefe"=>$exp_telefono_contacto[$i],"concepto"=>$exp_concepto[$i]);
                        array_push($experiencias,$experiencia);
                    }    
                }
            }

            if(!is_null($creditos))
                $visita->creditos_bancarios=json_encode($creditos);
            if(!is_null($tarjetas))
                $visita->tarjetas_credito=json_encode($tarjetas);
            if(!is_null($reportes))
                $visita->reportes_central=json_encode($reportes);
            if(!is_null($inmuebles))
                $visita->inmuebles=json_encode($inmuebles);
            if(!is_null($vehiculos))
                $visita->vehiculos=json_encode($vehiculos);
            if(!is_null($ingresos))
                $visita->ing_egr_familiar=json_encode($ingresos);
            if(!is_null($formaciones))
                $visita->formacion_academica=json_encode($formaciones);
            if(!is_null($experiencias))
                $visita->experiencia_laboral=json_encode($experiencias);

            $visita->gestionado_admin=1;
            $visita->id_admin_gestion=$this->user->id;
            $visita->save();

            $visita2=VisitaCandidato::find($data->get("id_visita"));
            $visita2->gestionado_admin=1;
            $visita2->id_admin_gestion=$this->user->id;
            $visita2->fecha_gestion_admin=date("Y-m-d");

            $visita2->save();//Guardado de la visita


        return response()->json(["success"=>true,"visita_id"=>$visita->id]);
    


    
    }


    public function store(Request $data){
        

            
            //NUEVO (CREAR USUARIO)
            $datos = $data->all();
            $usuario_cargo = $this->user->id;

            //  $validator = $this->validate($data->all(),[
            //  "tipo_fuente_id" => "required",
            //  "nombres" => "required",
            //  "primer_apellido" => "required",
            //  "celular" => "required",
            //  "email" => "required"
            //  ]);

            $fuentes = ["" => "Seleccionar"] + TipoFuentes::pluck("descripcion", "id")->toArray();

            // $valida  = Validator::make($data->all(), $rules);
            // if($validator->fails()) {
            //  return response()->json(["success" => false,"view" => view("admin.reclutamiento.modal.nuevo_candidato", compact("fuentes", "datos"))->withInput($data->all())->withErrors($valida)->render()]);
            // }
            
            $datos_basicos = DatosBasicos::where('numero_id', $data->get("cedula"))->first();

            if(is_null($datos_basicos)){
                $existe_registro_email = DatosBasicos::where('email',$data->get("email"))->first();
                if(count($existe_registro_email) > 0){
                    //Este correo ya esta registrado
                    return response()->json([
                        "success" => false,
                        "mensaje" => "Este correo ya se encuentra registrado"
                    ]);
                }

                //Creamos el usuario
                $campos_usuario = [
                    'name' => $data->get("primer_nombre").' '.$data->get("segundo_nombre")." ".$data->get("primer_apellido").' '.$data->get("segundo_apellido"),
                    'email'     => $data->get("email"),
                    'password'  => $data->get("cedula"),
                    'numero_id' => $data->get("cedula"),
                    'cedula'    => $data->get("cedula"),
                    'metodo_carga' =>3,
                    'usuario_carga' =>$this->user->id,
                    'tipo_fuente_id' => $data->get("tipo_fuente_id")
                ];
                
                $validar_email=json_decode($this->verificar_email($data->get("email")));

                if($validar_email->status==200 && !$validar_email->valid){


                    return response()->json([
                        "success" => false,
                        "mensaje" => $validar_email->mensaje
                    ]);
                }

                $user = Sentinel::registerAndActivate($campos_usuario);

                $usuario_id = $user->id;

                //Creamos sus datos basicos
                $datos_basicos = new DatosBasicos();

                $datos_basicos->fill([
                    'numero_id'       => $data->get("cedula"),
                    'user_id'         => $usuario_id,
                    'nombres'         => $data->get("primer_nombre").' '.$data->get("segundo_nombre"),
                    'primer_nombre'   => $data->get("primer_nombre"),
                    'segundo_nombre'   => $data->get("segundo_nombre"),
                    'primer_apellido' => $data->get("primer_apellido"),
                    'segundo_apellido'=> $data->get("segundo_apellido"),
                    'telefono_movil'  => $data->get("celular"),
                    'estado_reclutamiento' => config('conf_aplicacion.C_ACTIVO'),
                    'email'             => $data->get("email")
                ]);

                //Se verifica si a la persona que se registra esta en la lista negra, se coloca en estado_reclutamiento, que tiene problema de seguridad
                $cand_lista_negra = ListaNegra::where('cedula', $datos_basicos->numero_id)->first();
                if ($cand_lista_negra != null) {
                    $datos_basicos->estado_reclutamiento = config('conf_aplicacion.PROBLEMA_SEGURIDAD');

                    $datos_basicos->save();

                    if ($cand_lista_negra->restriccion_id != '' && $cand_lista_negra->restriccion_id != null) {
                        $restriccion = DB::table('tipos_restricciones')->select('descripcion', 'id')->find($cand_lista_negra->restriccion_id);
                    } else {
                        $restriccion = collect(['descripcion' => 'no hay una restricción guardada.']);
                    }

                    if ($cand_lista_negra->gestiono != '' && $cand_lista_negra->gestiono != null) {
                        $gestiono = $cand_lista_negra->gestiono;
                    } else {
                        $gestiono = $this->user->id;
                    }

                    //ACTIVAR USUARIO Evento
                    $auditoria                = new Auditoria();
                    $auditoria->observaciones = 'Se registro desde visita domiciliaria y se encuentra en listado especial con la restricción ' . $restriccion->descripcion;
                    $auditoria->valor_antes   = json_encode(["estado" => config('conf_aplicacion.C_ACTIVO')]);
                    $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.PROBLEMA_SEGURIDAD')]);
                    $auditoria->user_id       = $gestiono;
                    $auditoria->tabla         = "datos_basicos";
                    $auditoria->tabla_id      = $datos_basicos->id;
                    $auditoria->tipo          = 'ACTUALIZAR';
                    event(new \App\Events\AuditoriaEvent($auditoria));
                }

                $datos_basicos->save();

                Event::dispatch(new PorcentajeHvEvent($datos_basicos));
                
                //Creamos el rol
                $role = Sentinel::findRoleBySlug('hv');
                $role->users()->attach($user);

                $sitio = Sitio::first();

                if(isset($sitio->nombre)){
                  
                  if($sitio->nombre != "") {
                    $nombre = $sitio->nombre;
                  }else{
                    $nombre = "Desarrollo";
                  }
                }
            
                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                $mailTitle = "Bienvenido a {$nombre} - T3RS"; //Titulo o tema del correo

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "
                    ¡Hola $datos_basicos->nombres $datos_basicos->primer_apellido $datos_basicos->segundo_apellido!<br>
                    Se ha creado exitosamente tu cuenta en T3RS, te invitamos a ingresar usando tu número de documento como usuario y contraseña para completar tu hoja de vida y cargar tus documentos.
                    ";
                //Arreglo para el botón
                $mailButton = ['buttonText' => '¡COMPLETA TU HOJA DE VIDA!', 'buttonRoute' => route('login')];

                $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                /*Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $nombre, $sitio) {

                        $message->to($datos_basicos->email, $datos_basicos->nombres)
                                ->subject("Bienvenido a $nombre - T3RS")
                                ->bcc($sitio->email_replica)
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });*/

                //si no esxite el usuario crearlo
            }else{
                $datos_basicos->fill([
                    // 'numero_id'       => $data->get("cedula"),
                    // 'user_id'         => $usuario_id,
                    'nombres'         => $data->get("primer_nombre").' '.$data->get("segundo_nombre"),
                    'primer_nombre'   => $data->get("primer_nombre"),
                    'segundo_nombre'  => $data->get("segundo_nombre"),
                    'primer_apellido' => $data->get("primer_apellido"),
                    'segundo_apellido'=> $data->get("segundo_apellido"),
                    'telefono_movil'  => $data->get("celular"),
                    // 'estado_reclutamiento' => config('conf_aplicacion.C_ACTIVO'),
                    // 'datos_basicos_count'  => "100",
                    // 'email'             => $data->get("email")
                ]);

                $datos_basicos->save();
            }   

            //Crear visita

            $nueva_visita= new VisitaCandidato();
            $nueva_visita->candidato_id=$datos_basicos->user_id;
            $nueva_visita->tipo_visita_id=$data->get("tipo_visita_id");
            $nueva_visita->clase_visita_id=$data->get("clase_visita_id");
            $nueva_visita->empresa_logo_id=$data->get("empresa_logo_id");
            $nueva_visita->save();

            $nueva_visita_admin= new VisitaAdmin();
            $nueva_visita_admin->visita_candidato_id=$nueva_visita->id;
            $nueva_visita_admin->candidato_id=$datos_basicos->user_id;
            $nueva_visita_admin->tipo_visita_id=$data->get("tipo_visita_id");
            $nueva_visita_admin->clase_visita_id=$data->get("clase_visita_id");
            $nueva_visita_admin->empresa_logo_id=$data->get("empresa_logo_id");
            $nueva_visita_admin->save();

            //CORREO PARA VISITA
             $asunto = "Notificación de visita domiciliaria";
                        
                        $emails = $datos_basicos->email;
                        $email_sin_espacio = trim($emails);
                        $urls=route("realizar_form_visita_domiciliaria",["visita_id"=>$nueva_visita->id]);

                        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                        $mailConfiguration = 1; //Id de la configuración
                        $mailTitle = ""; //Titulo o tema del correo

                        //Cuerpo con html y comillas dobles para las variables
                        $mailBody = "Buen día ".$datos_basicos->nombres." ".$datos_basicos->primer_apellido.", le informamos que se ha programado una visita domiciliaria a realizarse en los próximos días. Debe ingresar haciendo clic en el siguiente botón para gestionar un formulario con algunas preguntas previas a la visita. 
                            <br/><br/>";

                        //Arreglo para el botón
                        $mailButton = ['buttonText' => 'Formulario', 'buttonRoute' => $urls];

                        $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

                        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($data, $emails, $asunto, $nombre) {

                                $message->to($emails, "$nombre - T3RS")->subject($asunto)
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                        });


            return response()->json(["success"=>true,"visita"=>$nueva_visita->id]);





    
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

    public function realizarPreFormVisita($visita_id,Request $request){

        if(empty($this->user->id)) {
            session(["url_deseada_redireccion_candidato" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login');
        }

        $current_user=$this->user;

        /*$candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
            ->join('negocio','negocio.id',"=","requerimientos.negocio_id")
            ->join('clientes','clientes.id',"=","negocio.cliente_id")
            ->join('cargos_especificos','cargos_especificos.id','=','requerimientos.cargo_especifico_id')
            ->where("procesos_candidato_req.requerimiento_id", $req_id)
            ->where("procesos_candidato_req.candidato_id", $this->user->id)
            ->whereIn("procesos_candidato_req.estado", [7, 8])
            ->whereIn("procesos_candidato_req.proceso", ["VISITA_DOMICILIARIA"])
            ->whereRaw("(procesos_candidato_req.apto is null or  procesos_candidato_req.apto = '')")
            ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            ->select(
                "datos_basicos.*",
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "requerimiento_cantidato.*",
                "requerimiento_cantidato.id as req_can_id",
                "clientes.nombre as cliente",
                "cargos_especificos.descripcion as cargo"
            )
        ->first();*/

         $candidatos=VisitaCandidato::join("datos_basicos","datos_basicos.user_id","=","visitas_candidatos.candidato_id")
            ->leftjoin("requerimientos","requerimientos.id","=","visitas_candidatos.requerimiento_id")
            ->leftjoin('negocio','negocio.id',"=","requerimientos.negocio_id")
            ->leftjoin('clientes','clientes.id',"=","negocio.cliente_id")
            ->leftjoin('cargos_especificos','cargos_especificos.id','=','requerimientos.cargo_especifico_id')
            ->where("visitas_candidatos.gestionado_candidato",0)
            ->where("visitas_candidatos.estado",1)
            ->where("visitas_candidatos.id",$visita_id)
            ->where("visitas_candidatos.candidato_id",$this->user->id)
            ->select("visitas_candidatos.*","datos_basicos.*","visitas_candidatos.created_at as fecha_creacion","visitas_candidatos.requerimiento_id","visitas_candidatos.id as id_visita","clientes.nombre as cliente","cargos_especificos.descripcion as cargo","datos_basicos.numero_licencia as nro_licencia"
                //DB::raw("DATE_FORMAT(datos_basicos.fecha_nacimiento, \'%Y-%m-%d\') as fecha_nacimiento"),
                //DB::raw("DATE_FORMAT(datos_basicos.fecha_expedicion, \'%Y-%m-%d\') as fecha_expedicion")
            )
            ->first();
           
        if (is_null($candidatos)) {
            return redirect()->route('dashboard')->with('no_visita', 'No tienes formularios de visitas domiciliarias pendientes por realizar');
        }

        //Se busca ciudade expedicion con autocomplete
        $ciudad_exp = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $candidatos->pais_id)
        ->where("ciudad.cod_departamento", $candidatos->departamento_expedicion_id)
        ->where("ciudad.cod_ciudad", $candidatos->ciudad_expedicion_id)
        ->first();

        $txt_ciudad_expedicion = "";
        if ($ciudad_exp != null) {
            $txt_ciudad_expedicion = $ciudad_exp->value;
        }

        //Se busca ciudad de nac con autocomplete
        $ciudad_nac = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $candidatos->pais_nacimiento)
        ->where("ciudad.cod_departamento", $candidatos->departamento_nacimiento)
        ->where("ciudad.cod_ciudad", $candidatos->ciudad_nacimiento)
        ->first();

        $txt_ciudad_nac = "";
        if ($ciudad_nac != null) {
            $txt_ciudad_nac = $ciudad_nac->value;
        }

        //Se busca ciudad de residencia con autocomplete
        $ciudad_res = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $candidatos->pais_residencia)
        ->where("ciudad.cod_departamento", $candidatos->departamento_residencia)
        ->where("ciudad.cod_ciudad", $candidatos->ciudad_residencia)
        ->first();
        // dd($ciudad_res);
        $txt_ciudad_resd = "";
        if ($ciudad_res != null) {
            $txt_ciudad_resd = $ciudad_res->value;
        }

        $paises = ["" => "Seleccionar"] + Pais::orderBy('nombre')->pluck("nombre", "cod_pais")->toArray();

        $dptos_expedicion = ["" => "Seleccionar"] + Departamento::orderBy('nombre')->where("cod_pais", $candidatos->pais_id)
        ->pluck("nombre", "cod_departamento")
        ->toArray();

        $ciudades_expedicion = ["" => "Seleccionar"] + Ciudad::orderBy('nombre')->where("cod_pais", $candidatos->pais_id)
        ->where("cod_departamento", $candidatos->departamento_expedicion_id)
        ->pluck("nombre", "cod_ciudad")
        ->toArray();

        $dptos_residencia = ["" => "Seleccionar"] + Departamento::orderBy('nombre')->where("cod_pais", $candidatos->pais_residencia)
        ->pluck("nombre", "cod_departamento")
        ->toArray();

        $ciudades_residencia = ["" => "Seleccionar"] + Ciudad::orderBy('nombre')->where("cod_pais", $candidatos->pais_residencia)
        ->where("cod_departamento", $candidatos->departamento_residencia)
        ->pluck("nombre", "cod_ciudad")
        ->toArray();

        $ciudades_nacimiento = ["" => "Seleccionar"] + Ciudad::orderBy(DB::raw("UPPER(nombre)"))->where("cod_pais", $candidatos->pais_nacimiento)
        ->where("cod_departamento", $candidatos->departamento_nacimiento)
        ->pluck("nombre", "cod_ciudad")
        ->toArray();

        $estadoCivil        = ["" => "Seleccionar"] + EstadoCivil::where("active", 1)->pluck("descripcion", "id")->toArray();

        $claseLibreta       = ["" => "Seleccionar"] + ClaseLibreta::where("active", 1)->pluck("descripcion", "id")->toArray();

        $categoriaLicencias = ["" => "Seleccionar"] + CategoriaLicencias::where("active", 1)
        ->select(\DB::raw("CONCAT(codigo,' ',descripcion) as descripcion_categoria"), "id")
        ->pluck("descripcion_categoria", "id")
        ->toArray();

         $bancos       = ["" => "Seleccionar"] + Bancos::pluck("nombre_banco", "id")->toArray();

         $nivelEstudios = ["" => "Seleccionar"] + NivelEstudios::where("active", 1)->pluck("descripcion","id")->toArray();

        $tipoVivienda       = ["" => "Seleccionar"] + DB::table("tipo_vivienda")->where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoPropiedad       = ["" => "Seleccionar"] + DB::table("tipo_propiedad")->where("active", 1)->pluck("descripcion", "id")->toArray();
        $medioTransporte       = ["" => "Seleccionar"] + DB::table("medio_transporte")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $sector       = ["" => "Seleccionar"] + DB::table("sector")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $material_techo       = ["" => "Seleccionar"] + DB::table("material_vivienda")->where("tipo_material_id",1)->where("active", 1)->pluck("descripcion", "id")->toArray();

        $material_paredes       = ["" => "Seleccionar"] + DB::table("material_vivienda")->where("tipo_material_id",2)->where("active", 1)->pluck("descripcion", "id")->toArray();

        $material_piso       = ["" => "Seleccionar"] + DB::table("material_vivienda")->where("tipo_material_id",3)->where("active", 1)->pluck("descripcion", "id")->toArray();

        $tipos_credito       = ["" => "Seleccionar"] + DB::table("tipo_credito")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $tipos_inmuebles       = ["" => "Seleccionar"] + DB::table("tipo_inmueble")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $tipos_vehiculos      = ["" => "Seleccionar"] + DB::table("tipos_vehiculos")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $tipos_tarjeta      = ["" => "Seleccionar"] + DB::table("tipo_tarjeta_credito")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $frecuencia      = ["" => "Seleccionar"] + DB::table("frecuencia")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $localidades      = ["" => "Seleccionar"] + DB::table("localidad")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $entidadesEps       = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();

        $entidadesAfp       = ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();

        if($candidatos == null) {
            return redirect()->route('dashboard');
        }



        

        /*$configuracion_sst = EvaluacionSstConfiguracion::first();

        //$sst_questions = EvaluacionSstPreguntas::where('active', 1)->orderByRaw('RAND()')->get();
        $sst_questions = EvaluacionSstPreguntas::where('active', 1)->orderBy('id')->get();

        $letras = $this->letras;*/

        $logo = '';

        $sitio = Sitio::first();
        if ($sitio->multiple_empresa_contrato) {
            $empresa_logo = Requerimiento::join('empresa_logos', 'empresa_logos.id', '=', 'requerimientos.empresa_contrata')
                ->select('empresa_logos.logo', 'empresa_logos.id')
            ->find($req_id);

            if ($empresa_logo != null && $empresa_logo->logo != null && $empresa_logo->logo != '') {
                $logo = $empresa_logo->logo;
            }
        }

        $familiares=GrupoFamilia::where("user_id", $this->user->id)
        ->select("grupos_familiares.*","grupos_familiares.primer_apellido as primer_apellido_fam","grupos_familiares.segundo_apellido as segundo_apellido_fam")
        ->get();
        $parentescos=[""=>"Seleccionar"]+Parentesco::where("active",1)->pluck("descripcion","id")->toArray();
        $tipo_familia= ["" => "Seleccionar"] + DB::table("tipo_familia")->where("active", 1)->pluck("descripcion", "id")->toArray();

        $imagenes=(array)json_decode($candidatos->imagenes);

        // $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        // ->leftjoin("ciudades")
        // ->where("estudios.user_id", $this->user->id)
        // ->select("estudios.*", "niveles_estudios.descripcion as nivel_estudio")
        // ->get();

        $estudios = Estudios::join("niveles_estudios", "niveles_estudios.id", "=", "estudios.nivel_estudio_id")
        ->join("paises", "paises.cod_pais", "=", "estudios.pais_estudio")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "estudios.pais_estudio")
                ->on("departamentos.cod_departamento", "=", "estudios.departamento_estudio");
        })->join("ciudad", function ($join2) {
        $join2->on("ciudad.cod_pais", "=", "estudios.pais_estudio")
            ->on("ciudad.cod_ciudad", "=", "estudios.ciudad_estudio")
            ->on("ciudad.cod_departamento", "=", "estudios.departamento_estudio");
        })->where("estudios.user_id", $this->user->id)
        ->select("estudios.*", "niveles_estudios.descripcion as nivel_estudio", "ciudad.id as ciudad_estudio")
        ->get();

        $periodicidad=[""=>"Seleccionar"] + DB::table("periodicidad")->pluck("descripcion","id")->toArray();

        //Experiencia
        $experiencias = Experiencias::where("user_id", $this->user->id)->orderBy('created_at', 'DESC')->get();

        $motivos = ["" => "Seleccionar"] + MotivoRetiro::where("active", "1")->orderBy("id")->pluck("descripcion", "id")->toArray();

        $tipos_documentos   = ["" => "Seleccionar"] + TipoIdentificacion::where("active", 1)->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();

        $ciudades_general = ["" => "Seleccionar"] + Ciudad::pluck("nombre", "id")->toArray() ;

        return view("cv.visita.realizar_pre_form_visita_new", compact('candidatos','logo',"estadoCivil","claseLibreta","tipoVivienda","sector","material_techo","material_paredes","material_piso","tipo_familia","current_user","familiares","parentescos","tipoPropiedad","medioTransporte","bancos","tipos_credito","tipos_inmuebles","tipos_vehiculos","frecuencia","paises","dptos_expedicion","ciudades_expedicion","dptos_residencia","ciudades_residencia","nivelEstudios","tipos_tarjeta","localidades","imagenes","ciudades_nacimiento","categoriaLicencias","entidadesAfp","entidadesEps","estudios","periodicidad","experiencias","motivos","txt_ciudad_expedicion","txt_ciudad_nac","tipos_documentos","ciudades_general","txt_ciudad_resd"));

    }

    public function guardarPreVisita(Request $data){
        
        $visita=VisitaCandidato::find($data->get("id_visita"));
        $visita->fill($data->all());
        $visita->gestionado_candidato=1;
        $visita->fecha_gestion_candidato=date("Y-m-d");
        $visita->ip_candidato=$data->ip();

        $visita->save();

            if($data->has('parentesco')){
            $parentesco=$data->parentesco;
            $nombre_familiar=$data->nombre_familiar;
            $primer_apellido_familiar=$data->primer_apellido_familiar;
            $segundo_apellido_familiar=$data->segundo_apellido_familiar;
            $edad_familiar=$data->edad_familiar;
            $ocupacion_familiar=$data->ocupacion_familiar;
            $estado_civil_familiar=$data->estado_civil_familiar;
            $convive_con_el=$data->convive_con_el;
            $depend_econ_familiar=$data->depend_econ_familiar;
            $num_contacto_familiar=$data->num_contacto_familiar;
            $profesion_id=$data->profesion_id;

        //INICIO de lógica para guardar JSON

            $familiares=array();
            for($i=0;$i<count($parentesco);$i++){

                
                        $familiar=array("parentesco_id"=>$parentesco[$i],"nombres"=>$nombre_familiar[$i],"edad_fam"=>$edad_familiar[$i],"ocupacion_fam"=>$ocupacion_familiar[$i],"profesion_id"=>$profesion_id[$i],"primer_apellido_fam"=>$primer_apellido_familiar[$i],"segundo_apellido_fam"=>$segundo_apellido_familiar[$i],"convive_con_el"=>$convive_con_el[$i],"depend_econ_fam"=>$depend_econ_familiar[$i],"numero_contacto_familiar"=>$num_contacto_familiar[$i],"estado_civil_id"=>$estado_civil_familiar[$i]);

                        array_push($familiares,$familiar);
                

            $visita->familiares=json_encode($familiares);


            }
        }//fin familiares

        //INGRESOS Y EGRESOS
        if ($data->has('ing_egr_nombre')) {
            $ing_egr_nombre = $data->ing_egr_nombre;
            $ing_egr_ingreso = $data->ing_egr_ingreso;
            $ing_egr_aporte = $data->ing_egr_aporte;
        }

        $ingresos = array();

        for($i=0; $i<count($ing_egr_nombre); $i++){ 
            $ingreso=array("ing_egr_nombre"=>$ing_egr_nombre[$i],"ing_egr_ingreso"=>$ing_egr_ingreso[$i],"ing_egr_aporte"=>$ing_egr_aporte[$i]);

            array_push($ingresos,$ingreso);
        }

        //DISTRIBUCION ESPACIAL

        $distribucion_espacial=[
            "habitaciones"=>$data->get("habitaciones"),
            "banos"=>$data->get("banos"),
            "cocina"=>$data->get("cocina"),
            "sala"=>$data->get("sala"),
            "patio"=>$data->get("patio"),
            "comedor"=>$data->get("comedor"),
            "garage"=>$data->get("garage"),
            "estudio"=>$data->get("estudio")

        ];

        //MOBILIARIO

        $mobiliario=[
            "televisor"=>$data->get("televisor"),
            "lavadora"=>$data->get("lavadora"),
            "estereo"=>$data->get("estereo"),
            "nevera"=>$data->get("nevera"),
            "dvd"=>$data->get("dvd"),
            "video_juegos"=>$data->get("video_juegos"),
            "estufa"=>$data->get("estufa"),
            "microondas"=>$data->get("microondas"),
            "pc"=>$data->get("pc"),
            "portatil"=>$data->get("portatil"),


        ];

        $enfermedades_familia=[
            "alergias"=>$data->get("alergias"),
            "alzheimer"=>$data->get("alzheimer"),
            "cancer"=>$data->get("cancer"),
            "diabetes"=>$data->get("diabetes"),
            "epilepsia"=>$data->get("epilepsia"),
            "hipertension"=>$data->get("hipertension"),
            "asma"=>$data->get("asma"),
            "epoc"=>$data->get("epoc")
        
        ];

        $visita->distribucion_espacial=json_encode($distribucion_espacial);
        $visita->mobiliario=json_encode($mobiliario);
        $visita->enfermedades_familia=json_encode($enfermedades_familia);


        //INGRESOS Y EGRESOS
            //CREDITOS
            $creditos=null;
            if($data->has('tiene_creditos_bancarios')){
                $banco_credito=$data->get("banco_credito");
                $tipo_credito=$data->get("tipo_credito");
                $total_credito=$data->get("total_credito");
                $cuota_credito=$data->get("cuota_credito");
                $creditos=array();
                for($i=0;$i<count($banco_credito);$i++){

                    if($banco_credito[$i]!='' && $tipo_credito[$i]!='' && $total_credito[$i]!='' && $cuota_credito[$i]!=''){
                            $credito=array("banco"=>$banco_credito[$i],"tipo_credito"=>$tipo_credito[$i],"cuota"=>$cuota_credito[$i],"total"=>$total_credito[$i]);

                            array_push($creditos,$credito);
                    }

            
                }
            }
            //TARJETAS CREDITO
            $tarjetas=null;
            if($data->has('tiene_tarjetas_credito')){
                $banco_tarjeta=$data->get("banco_tarjeta");
                $tipo_tarjeta=$data->get("tipo_tarjeta");
                $total_tarjeta=$data->get("total_tarjeta");
                $cuota_tarjeta=$data->get("cuota_tarjeta");
                $tarjetas=array();
                for($i=0;$i<count($banco_tarjeta);$i++){

                    if($banco_tarjeta[$i]!='' && $tipo_tarjeta[$i]!='' && $total_tarjeta[$i]!='' && $cuota_tarjeta[$i]!=''){
                            $tarjeta=array("banco"=>$banco_tarjeta[$i],"tipo_tarjeta"=>$tipo_tarjeta[$i],"total"=>$total_tarjeta[$i],"cuota"=>$cuota_tarjeta[$i]);

                            array_push($tarjetas,$tarjeta);
                    }

            
                }
            }

            //REPORTES CENREALES RIESGO
            $reportes=null;
            if($data->has('tiene_reportes_centrales')){
                $banco_central=$data->get("banco_central");
                $tipo_credito_central=$data->get("tipo_credito_central");
                $dias_mora_central=$data->get("dias_mora_central");
                $acuerdo_pago_central=$data->get("acuerdo_pago_central");
                $reportes=array();
                for($i=0;$i<count($banco_central);$i++){

                    if($banco_central[$i]!='' && $tipo_credito_central[$i]!='' && $dias_mora_central[$i]!='' && $acuerdo_pago_central[$i]!=''){
                            $reporte=array("banco"=>$banco_central[$i],"tipo_credito"=>$tipo_credito_central[$i],"dias_mora"=>$dias_mora_central[$i],"acuerdo_pago"=>$acuerdo_pago_central[$i]);

                            array_push($reportes,$reporte);
                    }

            
                }
            }

        //REPORTES CENTRALES RIESGO NUEVO
        if($data->has('tiene_reportes_centrales_')){
            $banco_central=$data->get("banco_central");
            $hace_cuanto_reportado=$data->get("hace_cuanto_reportado");
            $valor_reportado=$data->get("valor_reportado");
            $reportes=array();
            for($i=0; $i<count($banco_central); $i++){
                $reporte=array("banco"=>$banco_central[$i],"hace_cuanto_reportado"=>$hace_cuanto_reportado[$i],"valor_reportado"=>$valor_reportado[$i]);

                array_push($reportes,$reporte);
            }
        }

        //CREDITOS
        $creditos=null;
        if($data->has('tiene_creditos_bancarios_')){
            $banco_credito=$data->get("banco_credito");
            $hace_cuanto_reportado_credito=$data->get("hace_cuanto_reportado_credito");
            $valor_reportado_credito=$data->get("valor_reportado_credito");
            $creditos=array();
            for($i=0;$i<count($banco_credito);$i++){

                $credito=array("banco"=>$banco_credito[$i],"hace_cuanto_reportado_credito"=>$hace_cuanto_reportado_credito[$i],"valor_reportado_credito"=>$valor_reportado_credito[$i]);
                array_push($creditos,$credito);
            }
        }

        //BIENES INMUEBLES
            //INMUEBLES
            $inmuebles=null;
            if($data->has('tiene_bienes_inmuebles')){
                $tipo_inmueble=$data->get("tipo_inmueble");
                $valor_inmueble_bienes=$data->get("valor_inmueble_bienes");
                $participacion_inmueble_bienes=$data->get("participacion_inmueble_bienes");
                $porcentaje_inmueble=$data->get("porcentaje_inmueble");
                $observaciones_inmuebles=$data->get("observaciones_inmuebles");
                $inmuebles=array();
                for($i=0;$i<count($tipo_inmueble);$i++){

                    if($tipo_inmueble[$i]!='' && $participacion_inmueble_bienes[$i]!='' && $valor_inmueble_bienes[$i]!=''){
                            $inmueble=array("tipo"=>$tipo_inmueble[$i],"valor"=>$valor_inmueble_bienes[$i],"participacion"=>$participacion_inmueble_bienes[$i],"porcentaje"=>$porcentaje_inmueble[$i],"observaciones"=>$observaciones_inmuebles[$i]);

                            array_push($inmuebles,$inmueble);
                    }

            
                }
            }

            //INMUEBLES NUEVO
            if($data->has('tiene_bienes_inmuebles_')){
                $tipo_inmueble=$data->get("tipo_inmueble");
                $direccion_inmueble=$data->get("direccion_inmueble");
                $ciudad_inmueble=$data->get("ciudad_inmueble");
                $valor_inmueble_bienes=$data->get("valor_inmueble_bienes");
                $inmuebles=array();

                for($i=0;$i<count($tipo_inmueble);$i++){

                    $inmueble=array("tipo_inmueble"=>$tipo_inmueble[$i],
                    "direccion_inmueble"=>$direccion_inmueble[$i],
                    "ciudad_inmueble"=>$ciudad_inmueble[$i],
                    "valor_inmueble_bienes"=>$valor_inmueble_bienes[$i],
                    );
                    array_push($inmuebles,$inmueble);
                }
            }

            //VEHICULOS
            $vehiculos=null;
            if($data->has('tiene_vehiculos')){
                $tipo_vehiculo_bienes=$data->get("tipo_vehiculo_bienes");
                $valor_vehiculo_bienes=$data->get("valor_vehiculo_bienes");
                $modelo_vehiculo_bienes=$data->get("modelo_vehiculo_bienes");
                $placas_vehiculos_bienes=$data->get("placas_vehiculos_bienes");
                $participacion_vehiculo_bienes=$data->get("participacion_vehiculo_bienes");
                $porcentaje_vehiculo=$data->get("porcentaje_vehiculo");
                $observaciones_vehiculos=$data->get("observaciones_vehiculos");
                $vehiculos=array();
                for($i=0;$i<count($tipo_vehiculo_bienes);$i++){

                    if($tipo_vehiculo_bienes[$i]!='' && $participacion_vehiculo_bienes[$i]!='' && $valor_vehiculo_bienes[$i]!=''){
                            $vehiculo=array("tipo"=>$tipo_vehiculo_bienes[$i],"modelo"=>$modelo_vehiculo_bienes[$i],"valor"=>$valor_vehiculo_bienes[$i],"placas"=>$placas_vehiculos_bienes[$i],"participacion"=>$participacion_vehiculo_bienes[$i],"porcentaje"=>$porcentaje_vehiculo[$i],"observaciones"=>$observaciones_vehiculos[$i]);

                            array_push($vehiculos,$vehiculo);
                    }

            
                }
            }

            //VEHICULOS NUEVO
            if($data->has('tiene_vehiculos_')){
                $Marca=$data->get("Marca");
                $modelo_vehiculo_bienes=$data->get("modelo_vehiculo_bienes");
                $placas_vehiculos_bienes=$data->get("placas_vehiculos_bienes");
                $valor_vehiculo_bienes=$data->get("valor_vehiculo_bienes");
                $vehiculos=array();
                for($i=0;$i<count($Marca);$i++){

                    $vehiculo=array("Marca"=>$Marca[$i],"modelo_vehiculo_bienes"=>$modelo_vehiculo_bienes[$i],"valor_vehiculo_bienes"=>$valor_vehiculo_bienes[$i],"placas_vehiculos_bienes"=>$placas_vehiculos_bienes[$i]);
                    array_push($vehiculos,$vehiculo);
                }
            }

            //FORMACION ACADEMICA
            $formaciones=null;
            if($data->has('fa_institucion')){
                $fa_estudio_actual=$data->get("fa_estudio_actual");
                $fa_institucion=$data->get("fa_institucion");
                $fa_titulo_obtenido=$data->get("fa_titulo_obtenido");
                $fa_ciudad=$data->get("fa_ciudad");
                $fa_nivel_estudio=$data->get("fa_nivel_estudio");
                $fa_semestres_cursados=$data->get("fa_semestres_cursados");
                $fa_periodicidad=$data->get("fa_periodicidad");
                $fa_fecha_finalizacion=$data->get("fa_fecha_finalizacion");
                $fa_telefono=$data->get("fa_telefono");
                $fa_concepto=$data->get("fa_concepto");
                $formaciones=array();
                for($i=0; $i<count($fa_institucion) ;$i++){
                        
                    $formacion=array(
                        "estudio_actual"=>$fa_estudio_actual[$i],
                        "institucion"=>$fa_institucion[$i],
                        "titulo_obtenido"=>$fa_titulo_obtenido[$i],
                        "ciudad_estudio"=>$fa_ciudad[$i],
                        "nivel_estudio_id"=>$fa_nivel_estudio[$i],
                        "semestres_cursados"=>$fa_semestres_cursados[$i],
                        "periodicidad"=>$fa_periodicidad[$i],
                        "fecha_finalizacion"=>$fa_fecha_finalizacion[$i],
                        "telefono"=>$fa_telefono[$i],
                        "concepto"=>$fa_concepto[$i]);
                    array_push($formaciones,$formacion);
                       
                }
            }

            //EXPERIENCIA LABORAL
            $experiencias=null;
            if($data->has('tiene_experiencia_')){
                $exp_trabajo_actual=$data->get("exp_trabajo_actual");
                $exp_empresa=$data->get("exp_empresa");
                $exp_cargo=$data->get("exp_cargo");
                $exp_fecha_ingreso=$data->get("exp_fecha_ingreso");
                $exp_fecha_retiro=$data->get("exp_fecha_retiro");
                $exp_motivo_retiro=$data->get("exp_motivo_retiro");
                $exp_telefono_contacto=$data->get("exp_telefono_contacto");
                $exp_concepto=$data->get("exp_concepto");
                $experiencias=array();
                for($i=0;$i<count($exp_empresa);$i++){

                    if($exp_empresa[$i]!='' && $exp_cargo[$i]!=''){
                        
                        $experiencia=array("empleo_actual"=>$exp_trabajo_actual[$i], "nombre_empresa"=>$exp_empresa[$i],"cargo_especifico"=>$exp_cargo[$i],"fecha_inicio"=>$exp_fecha_ingreso[$i],"fecha_final"=>$exp_fecha_retiro[$i],"motivo_retiro"=>$exp_motivo_retiro[$i],"movil_jefe"=>$exp_telefono_contacto[$i],"concepto"=>$exp_concepto[$i]);
                        array_push($experiencias,$experiencia);
                    }    
                }
            }

            if(!is_null($creditos))
                $visita->creditos_bancarios=json_encode($creditos);
            if(!is_null($tarjetas))
                $visita->tarjetas_credito=json_encode($tarjetas);
            if(!is_null($reportes))
                $visita->reportes_central=json_encode($reportes);
            if(!is_null($inmuebles))
                $visita->inmuebles=json_encode($inmuebles);
            if(!is_null($vehiculos))
                $visita->vehiculos=json_encode($vehiculos);
            if(!is_null($ingresos))
                $visita->ing_egr_familiar=json_encode($ingresos);
            if(!is_null($formaciones))
                $visita->formacion_academica=json_encode($formaciones);
            if(!is_null($experiencias))
                $visita->experiencia_laboral=json_encode($experiencias);
    $visita->save();


    return response()->json(["success"=>true,"visita_id"=>$visita->id]);
    


    }

     public function guardarImagesPreVisita(Request $data){

        $this->validate($data, [
            "foto_evaluado" => "mimes:jpg,jpeg,png,pdf,gif",
            "archivo_documento"=>   "max:100"
        ]);

        


        $imagenes=[
            "foto_evaluado"=>null,
            "foto_evaluado_nucleo"=>null,
            "foto_sala"=>null,
            "foto_comedor"=>null,
            "foto_cocina"=>null,
            "foto_habitacion"=>null,
            "foto_nro_apto"=>null,
            "foto_direccion"=>null,
            "foto_direccion"=>null,
            "foto_fachada"=>null,
            "foto_alrededores"=>null,
            "foto_ubicacion_wp"=>null,
            "foto_ubicacion_maps"=>null

        ];

        $is_admin=$this->user->inRole("admin");

        if(!$is_admin){
            $visita=VisitaCandidato::find($data->get("id-visita-imagenes"));
           foreach($imagenes as $clave=>&$valor){
                if ($data->hasFile($clave)) {

                        $archivo=$data->file($clave);
                        $extencion = $archivo->getClientOriginalExtension();
                        $name_documento = 'visita-'.$clave."." .$extencion;
                        Storage::disk('public')->put('recursos_visita_domiciliaria/'.$visita->id.'/img/evaluado/'.$name_documento,\File::get($archivo));
                        $valor=$name_documento;
                }
            } 

            
        }
        else{
            //BLOQUE PARA ADMIN
            $visita=VisitaAdmin::where("visita_candidato_id",$data->get("id-visita-imagenes"))->first();
            $imagenes_candidato=(array)json_decode($visita->visita_candidato->imagenes);
            
            foreach($imagenes as $clave=>&$valor){
                if ($data->hasFile($clave)) {

                        $archivo=$data->file($clave);
                        $extencion = $archivo->getClientOriginalExtension();
                        $name_documento = 'visita-'.$clave."." .$extencion;

                        //validamos si existe el archivo en la carpeta
                        $exists = Storage::disk('public')->exists('recursos_visita_domiciliaria/'.$visita->visita_candidato_id.'/img/admin/'.$name_documento);
                        if ($exists) {
                            Storage::disk('public')->delete('recursos_visita_domiciliaria/'.$visita->visita_candidato_id.'/img/admin/'.$name_documento);
                        }
                        Storage::disk('public')->put('recursos_visita_domiciliaria/'.$visita->visita_candidato_id.'/img/admin/'.$name_documento,\File::get($archivo));
                        $valor=$name_documento;
                }
                else{

                    
                    if($imagenes_candidato[$clave]!=null){
                        //validamos si existe el archivo en la carpeta
                        $exists = Storage::disk('public')->exists('recursos_visita_domiciliaria/'.$visita->visita_candidato_id.'/img/admin/'.$imagenes_candidato[$clave]);
                        if ($exists) {
                            Storage::disk('public')->delete('recursos_visita_domiciliaria/'.$visita->visita_candidato_id.'/img/admin/'.$imagenes_candidato[$clave]);
                        }
                        Storage::disk('public')->copy('recursos_visita_domiciliaria/'.$visita->visita_candidato_id.'/img/evaluado/'.$imagenes_candidato[$clave],'recursos_visita_domiciliaria/'.$visita->visita_candidato_id.'/img/admin/'.$imagenes_candidato[$clave]);
                        $valor=$imagenes_candidato[$clave];
                    }
                    
                }
            } 
        }//fin de admin

        $visita->imagenes=json_encode($imagenes);
        $visita->save();


        

        return response()->json(["success"=>true,"visita_id"=>$data->get("id-visita-imagenes")]);

     }

    public function guardarFirmaPreForm(Request $data){
        $ip = $data->ip();
        $visita = VisitaCandidato::findOrFail($data->visita_id);
        $visita->firma_candidato = $data->firma;
        $visita->ip_candidato=$ip;
        $visita->save();

        /*$candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_can_id", "requerimiento_cantidato.requerimiento_id")
        ->find($visita->requerimiento_candidato_id);*/

        /*$ref_id = RegistroProceso::where("candidato_id",$visita->candidato_id)
            ->where("requerimiento_id",$visita->requerimiento_id)
            ->where('proceso', "VISITA_DOMICILIARIA")
            ->orderBy('id', "DESC")
        ->first();
        if($ref_id!=null){
            $ref_id->apto
        }*/

        return response()->json(['success'=>true]);

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

    public function diferencias(array $visita, array $visita_candidato, array $seccion, $verificables){      

        //encuentramos los valores iguales entre las tab visita cand y visita admin
        $find_duplicates = array_intersect_assoc($visita, $visita_candidato);

        //generamos un arr asoc de solo los campos diferentes
        $dif = array_diff_assoc($visita_candidato, $find_duplicates);

        //Tomamos los campos correspondientes a la seccion pasada como parametro (datos basicos, informacion laboral, etc..)
        $final = array_intersect_key($dif, array_flip($seccion));
        //dd($final);

        //Si final tiene algo, hay diferencias para la seccion enviada
        if (count($final) > 0) {
            $diferentes = array();
            foreach($final as $key => $val) {
                //Si tiene campos a verificar para tomar su descripcion(estado_civil, clase_libreta, categoria_licencia, entidad_afp y entidad_eps)
                if (array_key_exists($key, array_flip($verificables))) {
                    $campos_verificados = $this->valores_verificados($key);
                    $array_diferente= array("campo"=> $key,"valor_cand"=> $visita_candidato[$campos_verificados] , "valor_adm"=> $visita[$campos_verificados]);
                    array_push($diferentes,$array_diferente);
                    } 
                else {
                    $array_diferente= array("campo"=> $key,"valor_cand"=> $visita_candidato[$key] , "valor_adm"=> $visita[$key]);
                    array_push($diferentes,$array_diferente);
                }
            }
        }
        //dd($db_diferentes); 
        return $diferentes;
    }

    public function diferencias_dinamicas(array $campos_admin, array $campos_candidato){

        // se elimina concepto para campos_admin
        $campos_adm = array();
        $campo_adm =array();
        foreach ($campos_admin as $key => $value) {
            foreach ($value as $k => $val) {
                if ($k != "concepto") {
                    $campo_adm[$k] = $val;
                }
            }
            array_push($campos_adm,$campo_adm);
            $campos_adm_txt = json_encode($campos_adm);
        }

        // se elimina concepto para campos_cand
        $campos_cand = array();
        $campo_can =array();
        foreach ($campos_candidato as $key => $value) {
            foreach ($value as $k => $val) {
                if ($k != "concepto") {
                    $campo_can[$k] = $val;
                }
            }
            array_push($campos_cand,$campo_can);
            $campos_cand_txt = json_encode($campos_cand);
        }

        if (strcmp($campos_adm_txt, $campos_cand_txt) === 0){
            return true;
        }
        return false;
    }

    public function valores_verificados(string $key){
        if ($key == 'tipo_id') {
            return "tipo_documento";
        }
        if ($key == 'estado_civil') {
            return "estado_civil_persona";
        }
        if ($key == 'clase_libreta') {
            return "clase_libreta_desc";
        }
        if ($key == 'categoria_licencia') {
            return "cat_licencia";
        }
        if ($key == 'entidad_afp') {
            return "afp";
        }
        if ($key == 'entidad_eps') {
            return "eps";
        }
        if ($key == 'tipo_vivienda') {
            return "tipo_vivienda_descripcion";
        }
        if ($key == 'propiedad') {
            return "tipo_propiedad_descripcion";
        }
        if ($key == 'sector') {
            return "sector_vivienda";
        }
    }

    // Modal
    public function registrarLink(Request $request)
    {
        // $visita=null;

        // if($data->has("id_visita"))
        //     $visita=$data->get("id_visita");

        try {
            //$ae = EntrevistaSemi::find($data->prueba_id);
            $id_visita = $request->get("visita");
            $visita = VisitaAdmin::find($id_visita);
            //se guarda encuesta
            $visita->link_visita_virtual =  $request->get("link_visita_virtual");
            $visita->save();

            return response()->json(['success' => true, 'mensaje' => 'Se ha guardado correctamente.']);

        } catch (\Exception $e) {
            logger('Excepción capturada VisitasDomiciliariaController@registrarLink: '.  $e->getMessage(). "\n");
            return response()->json(['success' => false, 'mensaje' => 'Ha ocurrido un error procesando la información']);
        }
    }

    public function agregarLink(Request $data){

        $visita=$data->get("visita");

        return view("admin.visita_domiciliaria.modal.registra_link_visita", compact("visita"));
    }
}
