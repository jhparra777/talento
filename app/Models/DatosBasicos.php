<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\DB;
use App\Models\AsignacionPsicologo;
use Illuminate\Database\Eloquent\Model;
use App\Models\PoliticaPrivacidadCandidato;
use App\Models\PreliminarTranversalesCandidato;
use App\Models\TipoPolitica;

class DatosBasicos extends Model
{

    protected $table      = 'datos_basicos';
    //protected $attributes = ['entidad_eps' => null];
    protected $fillable   = [
        'user_id',
        'updated_at',
        'tipo_vehiculo',
        'descrip_profesional',
        'tipo_id',
        'tiene_vehiculo',
        'telefono_movil',
        'telefono_fijo',
        'hijos',
        'conflicto',
        'descripcion_conflicto',
        'numero_hijos',
        'viaje',
        'conocenos',
        'talla_camisa',
        'talla_pantalon',
        'talla_zapatos',
        'situacion_militar_definida',
        'segundo_apellido',
        'referencias_count',
        'primer_apellido',
        'perfilamiento_count',
        'pais_nacimiento',
        'numero_licencia',
        'numero_libreta',
        'numero_id',
        'nombres',
        'primer_nombre',
        'segundo_nombre',
        'grupo_familiar_count',
        'genero',
        'fuente_publicidad',
        'fecha_nacimiento',
        'fecha_expedicion',
        'tiene_experiencia',
        'experiencias_count',
        'estudios_count',
        'estado_civil',
        'estado',
        'asistencia',
        'entidad_eps',
        'entidad_afp',
        'distrito_militar',
        'direccion_formato',
        'direccion',
        'departamento_residencia',
        'departamento_nacimiento',
        'departamento_expedicion_id',
        'datos_basicos_count',
        "video_perfil_count",
        'created_at',
        'clase_libreta',
        'ciudad_residencia',
        'pais_residencia',
        'ciudad_nacimiento',
        'ciudad_expedicion_id',
        'categoria_licencia',
        'aspiracion_salarial',
        'acepto_politicas_privacidad',
        'acepto_politicas_privacidad_2021',
        'ciudad_id',
        'departamento_id',
        'pais_id',
        "email",
        "empresa_registro",
        "barrio",
        "contacto_externo",
        "rh",
        "grupo_sanguineo",
        "estado_reclutamiento",
        "motivo_rechazo",
        "video_perfil",
        "datos_basicos_activo",
        "trabaja",
        "entidad_cesantias",
        "disp_viajar",
        "conoce_komatsu",
        "conflicto_interes",
        "trabaja_act_komatsu",
        "localidad",
        'caja_compensaciones',
        "fondo_pensiones",
        "fondo_cesantias",
        "tiene_cuenta_bancaria",
        "nombre_banco",
        "tipo_cuenta",
        "numero_cuenta",
        "usuario_cargo",
        "registroEE",
        "ofertaEE",
        "politicas_content",
        "aceptacion_firma_digital",
        "aceptacion_ip",
        "aceptacion_date",
        "politicas_privacidad_id",
        "fecha_acepto_politica",
        "fecha_acepto_politica_2021",
        "hora_acepto_politica",
        "ip_acepto_politica",
        "ip_acepto_politica_2021",
        "tipo_sangre_id",
        "grupo_poblacional",
        "otro_grupo_poblacional",
        "estrato",
        "tiene_estudio",
        "contacto_emergencia",
        "telefono_emergencia",
        "correo_emergencia",
        "parentesco_contacto_emergencia"
    ];

    // public function setEntidadEpsAttribute($value)
    // {
    //     if ($value != '') {
    //         $this->attributes['entidad_eps'] = $value;
    //     }
    //     $this->attributes['entidad_eps'] = null;
    // }

    // public function setEntidadAfpAttribute($value)
    // {
    //     if ($value != '') {
    //         $this->attributes['entidad_afp'] = $value;
    //     }
    //     $this->attributes['entidad_afp'] = null;
    // }

    // public function setCategoriaLicenciaAttribute($value)
    // {
    //     if ($value != '') {
    //         $this->attributes['categoria_licencia'] = $value;
    //     }
    //     $this->attributes['categoria_licencia'] = null;
    // }

    // public function setTipoVehiculoAttribute($value)
    // {
    //     if ($value != '') {
    //         $this->attributes['tipo_vehiculo'] = $value;
    //     }
    //     $this->attributes['tipo_vehiculo'] = null;
    // }

    public function getLugarExpedicion(){
        $lugar_expedicion = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")
            ->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS lugar_expedicion"))
        ->where("ciudad.cod_pais", $this->pais_id)
        ->where("ciudad.cod_departamento", $this->departamento_expedicion_id)
        ->where("ciudad.cod_ciudad", $this->ciudad_expedicion_id)
        ->first();

        if(count($lugar_expedicion) > 0){
            return $lugar_expedicion->lugar_expedicion;
        }

        return 'No registra datos suficientes.';
    }

    public function getCiudadExpedicion(){
        $lugar_expedicion = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")
                ->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select("ciudad.nombre")
            ->where("ciudad.cod_pais", $this->pais_id)
            ->where("ciudad.cod_departamento", $this->departamento_expedicion_id)
            ->where("ciudad.cod_ciudad", $this->ciudad_expedicion_id)
        ->first();

        if($lugar_expedicion == null){
            return '';
        }

        return $lugar_expedicion->nombre;
    }

    public function getCiudadDomicilio(){
        $domicilio = $this->join("paises", "paises.cod_pais", "=", "datos_basicos.pais_residencia")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "datos_basicos.pais_residencia")
                ->on("departamentos.cod_departamento", "=", "datos_basicos.departamento_residencia");
            })
            ->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "datos_basicos.pais_residencia")
                ->on("ciudad.cod_departamento", "=", "datos_basicos.departamento_residencia")
                ->on("ciudad.cod_ciudad", "=", "datos_basicos.ciudad_residencia");
            })
            ->where("ciudad.cod_pais", $this->pais_residencia)
            ->where("ciudad.cod_departamento", $this->departamento_residencia)
            ->where("ciudad.cod_ciudad", $this->ciudad_residencia)
            ->select("ciudad.nombre")
        ->first();

        if($domicilio == null){
            return '';
        }

        return $domicilio->nombre;
    }

    public function estudios_c(){
        return $this->hasMany('App\Models\Estudios',"user_id", "user_id");
    }
    
    public function experiencias_c(){
        return $this->hasMany('App\Models\Experiencias',"user_id","user_id")->orderBy('fecha_final', 'desc');
    }

    public function experiencias_cc(){
        return $this->hasMany('App\Models\Experiencias',"user_id","user_id")->where('empleo_actual',1)->take(1);
    }

    public function idiomas_c(){
        return $this->hasMany('App\Models\IdiomaUsuario', "id_usuario", "user_id");
    }

    public function getClaseLibreta(){
        if($this->clase_libreta == 1){
            return 'PRIMERA CLASE';
        }elseif($this->clase_libreta == 2){
            return 'SEGUNDA CLASE';
        }
    }

    public function getUbicacionReq()
    {
        $req = Requerimiento::find($this->requerimiento_id);

        if ($req == null) {
            return "";
        }

        $ciudad = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })
        ->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")
            ->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        /*->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad"))*/
        ->select(\DB::raw("CONCAT(ciudad.nombre) AS ciudad"))
        ->where("ciudad.cod_pais", $req->pais_id)
        ->where("ciudad.cod_departamento", $req->departamento_id)
        ->where("ciudad.cod_ciudad", $req->ciudad_id)
        ->first();

        if ($ciudad == null) {
            return "";
        }

        return $ciudad->ciudad;
    }

    public function getUbicacion()
    {
        $ciudad = $this->join("paises", "paises.cod_pais", "=", "datos_basicos.pais_residencia")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "datos_basicos.pais_residencia")
            ->on("departamentos.cod_departamento", "=", "datos_basicos.departamento_residencia");
        })
        ->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "datos_basicos.pais_residencia")
            ->on("ciudad.cod_departamento", "=", "datos_basicos.departamento_residencia")
            ->on("ciudad.cod_ciudad", "=", "datos_basicos.ciudad_residencia");
        })
        ->where("ciudad.cod_pais", $this->pais_residencia)
        ->where("ciudad.cod_departamento", $this->departamento_residencia)
        ->where("ciudad.cod_ciudad", $this->ciudad_residencia)
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad"))
        ->first();

        if ($ciudad == null) {
            return "";
        }

        return $ciudad->ciudad;
    }

    public function getEstado()
    {
        $estado = DB::table("estados")->where("id", $this->estado_reclutamiento)->first();

        if ($estado == null) {
            return "";
        }

        return $estado->descripcion;
    }

    //para mostrar los nombres completos
    public function fullname()
    {
        return $this->nombres.' '.$this->primer_apellido.' '.$this->segundo_apellido;
    }

    /**
     * Maximo nivel de estudio por candidato
     **/
    public function maximoEstudio()
    {
        $estudio = DB::table("estudios")
        ->leftjoin('niveles_estudios', 'niveles_estudios.id', '=', 'estudios.nivel_estudio_id')
        ->where('user_id', $this->user_id)
        ->orderBy('estudios.nivel_estudio_id', 'DESC')
        ->first();
            
        return $estudio;
    }

    public function pregradoEstudio()
    {
        $estudio = DB::table("estudios")
        ->leftjoin('niveles_estudios', 'niveles_estudios.id', '=', 'estudios.nivel_estudio_id')
        ->where('user_id', $this->user_id)
        ->where('nivel_estudio_id', 2)
        ->first();

        return $estudio;
    }

    /**
     *  Convertir todas las fechas en el formato -> (01 abril 2018)
     **/
    public static function convertirFecha($fecha = null)
    {
        setlocale(LC_TIME, 'Spanish');

        $data         = new Carbon($fecha);
        $convertFecha = $data->formatLocalized('%d %B %Y');

        return $convertFecha;
    }

    public static function FechaHoy()
    {
        setlocale(LC_TIME, 'Spanish');
        $data         = new Carbon();

        return $data;
    }

    /**
     * Consultar información basica de un user_id
     **/
    public static function nombreUsuario($user_id = null)
    {
        $informacion = DatosBasicos::select(\DB::raw("CONCAT(nombres) AS nombreUsuario"))
        ->where("user_id", $user_id)
        ->first();

        if ($informacion == null) {
            return "";
        }

        return ucwords(mb_strtolower($informacion->nombreUsuario));
    }

    //para el psicologo
    public static function nombrePsicologo($user_id = null,$req = null)
    {
        $informacion = AsignacionPsicologo::select('psicologo_id')
        ->where("psicologo_id", $user_id)
        ->where("req_id", $req)
        ->orderby('id', 'DESC')
        ->first();

        if ($informacion == null) {
            return "";
        }else{
            $usuarionombre = DatosBasicos::select(\DB::raw("CONCAT(nombres) AS nombreUsuario"))
            ->where("user_id", $informacion->psicologo_id)
            ->first();
        }

        return ucwords(mb_strtolower($usuarionombre->nombreUsuario));
    }

    /**
     * Saber si le hicieron descripción al candidato para mostrar la descripción si no se 
     * muestra la descripción personalizada.
     **/
    public function descripcionCandidato(){
        $descripcion = PreliminarTranversalesCandidato::where("candidato_id", $this->candidato_id)
        ->where("req_id", $this->req_id)
        ->where("descripcion_candidato", "<>", "")
        ->first();

        if ($descripcion == null) {
            return "";
        } else {
            return $descripcion->descripcion_candidato;
        }
    }

    public function requerimientoActual(){
        $requerimiento = Requerimiento::join('requerimiento_cantidato','requerimiento_cantidato.requerimiento_id','=','requerimientos.id')
        ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
        ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
        ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
        ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
        ->where("requerimiento_cantidato.candidato_id", $this->user_asistencia_id)
        ->select( 
            DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),
            DB::raw('upper(users.name) as usuario_cargo_req'),
            "cargos_especificos.descripcion as cargo",
            "clientes.nombre as nombre_cliente",
            "requerimientos.id as req_id"
        )
        ->orderBy("requerimiento_cantidato.id", "desc")
        ->first();

        if ($requerimiento == null) {
            return "";
        } else {
            return $requerimiento;
        }
    }

    public function getTipoIdentificacion()
    {
        return $this->hasOne('App\Models\TipoIdentificacion', "id", "tipo_id");
    }


    public function politicasPrivacidad()
    {
        //return $this->belongsToMany('App\Models\PoliticasPrivacidad')->using('App\Models\PoliticaPrivacidadCandidato');
        return PoliticaPrivacidadCandidato::where('candidato_id', $this->user_id)->get();
    }

    public function getDireccionDian() {
        return $this->hasOne('App\Models\DireccionDian', "datos_basicos_id", "id");
    }

    public function politicaActual()
    {   
        //codigo original
        /*$acepto_politica = DatosBasicos::join("politicas_privacidad_candidatos", "politicas_privacidad_candidatos.candidato_id", "=", "datos_basicos.user_id"
        )
        ->where("datos_basicos.user_id", $this->user_id)
        ->whereRaw("politicas_privacidad_candidatos.politica_privacidad_id = (SELECT MAX(politicas_privacidad.id) FROM politicas_privacidad)")
        ->first();
        
        return ($acepto_politica != null ? true : false);
        */
        $tipos_politicas = TipoPolitica::where('active', 1)->get();

        //iniciamos variables para caso que no entre en for las devuelva con estos valores
        $acepto = true;
        $ultima_politica = null;

        foreach ($tipos_politicas as $tipo_politica) {
            
            //obtenemos la ultima politca por cada tipo de politica
            $ultima_politica = $tipo_politica->politicasPrivacidad->last();

            //si es null es porque esa politica solo esta creada en la tabla tipos_politicas
            // y no tiene aun politica_privacidad
            if ( $ultima_politica == null ) 
                continue;

            //si existe registro aqui es porque ya la acepto
            $acepto_politica = PoliticaPrivacidadCandidato::where("politicas_privacidad_candidatos.candidato_id", $this->user_id)
            ->where('politicas_privacidad_candidatos.politica_privacidad_id', $ultima_politica->id)
            ->first(); 

            //si no existe registro no la aceptado entonces terminamos de recorrer 
            if( $acepto_politica == null ){
                
                $acepto = false;
                break;
            }       
        }

        return collect(["acepto" => $acepto, "politica_id" => $ultima_politica->id])->all();

    }

    public function datosBajaVoluntaria()
    {
        return $this->hasOne('App\Models\DatosBajaVoluntaria', 'user_id', 'user_id');
    }
}