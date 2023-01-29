<?php

namespace App\Models;

use App\Models\Ciudad;
use App\Models\Departamento;
use App\Models\Clientes;
use App\Models\CargoEspecifico;
use App\Models\CargoGenerico;
use App\Models\EstadosRequerimientos;
use App\Models\Estados;
use App\Models\MotivoRequerimiento;
use App\Models\Negocio;
use App\Models\NegocioANS;
use App\Models\NivelEstudios;
use App\Models\TipoContrato;
use App\Models\TipoExperiencia;
use App\Models\TipoJornada;
use App\Models\TipoLiquidacion;
use App\Models\TipoProceso;
use App\Models\TipoSalario;
use App\Models\Pregunta;
use App\Models\Pais;
use App\Models\UnidadNegocio;
use App\Models\Solicitudes;
use Illuminate\Support\Facades\Auth;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\ReqCandidato;
use App\Models\PregReqResp;
use App\Models\Ficha;
use App\Models\AuxiliarFicha;
use App\Models\NivelIdioma;
use App\Models\Idiomas;
use App\Models\OfertaUser;

class Requerimiento extends Model
{
    protected $table    = 'requerimientos';
    protected $fillable = [
        'justificacion',
        'negocio_id',
        'num_vacantes',
        'cargo_generico_id',
        'tipo_proceso_id',
        'tipo_contrato_id',
        'genero_id',
        'motivo_requerimiento_id',
        'tipo_jornadas_id',
        'salario',
        'adicionales_salariales',
        'centro_costo_id',
        'sitio_trabajo',
        'funciones',
        'formacion_academica',
        'experiencia_laboral',
        'conocimientos_especificos',
        'observaciones',
        'solicitado_por',
        "cargo_especifico_id",
        "pais_id",
        "departamento_id",
        "ciudad_id",
        "fecha_terminacion",
        "descripcion_oferta",
        "fecha_publicacion",
        "edad_minima",
        "edad_maxima",
        "telefono_solicitante",
        "ctra_x_clt_codigo",
        "centro_costo_contables",
        "centro_costo_produccion",
        "tipo_liquidacion",
        "tipo_salario",
        "tipo_nomina",
        "concepto_pago_id",
        "nivel_estudio",
        "estado_civil",
        "fecha_ingreso",
        "fecha_retiro",
        "fecha_recepcion",
        "contenido_email_soporte",
        "cargo_codigo",
        "grado_codigo",
        "dias_gestion",
        "num_req_cliente",
        "req_prioritario",
        "tipo_experiencia_id",
        "estado_publico",
        "cuantos_candidatos_presentar",
        "cuantos_dias_presentar_antes",
        "fecha_presentacion_candidatos",
        "fecha_tentativa_cierre_req",
        "cand_presentados_puntual",
        "cand_presentados_no_puntual",
        "cand_contratados_puntual",
        "cand_contratados_no_puntual",
        "fecha_contratacion_candidato",
        "fecha_presentacion_oport_cand",
        'esquemas',
        'informe_preliminar_id',
        'created_at',
        'updated_at',
        'solicitud_id',
        'fecha_plazo_req',
        'procesado',
        'notas_adicionales',
        'enterprise',
        'jefe_inmediato',
        'empresa_contrata',
        'conocimientos_especificos',
        'id_idioma',
        'nivel_idioma',
        'centro_costo_cliente',
        'unidad_negocio',
        'tipo_turno',
        'IdJobOfferEE',
        'consultaEE',
        'preguntas_oferta',
        'tipo_reclutamiento',
        'pago_por',
        'precio_hv',
        'cantidad_hv',
        'fecha_cierre_externo',
        'hora_cierre_externo',
        'cluster',
        'visita_domiciliaria',
        'tipo_visita_id',
        'tipo_evs_id',
        'fecha_tope_publicacion'
    ];

    public function descripcion_idioma(){
        $idioma = Idiomas::where('id', $this->id_idioma)->first();

        return $idioma['descripcion'];
    }

    public function tipo_evs() {
        return $this->belongsTo('App\Models\TipoEstudioVirtualSeguridad', 'tipo_evs_id', 'id');
    }

    public function descripcion_nivel_idioma(){
        $nivel_idioma = NivelIdioma::where('id', $this->nivel_idioma)->first();

        return $nivel_idioma['descripcion'];
    }

    public function solicitud(){
        return $this->belongsTo('App\Models\Solicitudes',"solicitud_id","id");
    }

    public function observaciones_gestion(){
        return $this->hasMany('App\Models\RequerimientoObservaciones',"req_id","id");
    }

    public function estados(){
        return $this->hasMany('App\Models\EstadosRequerimientos',"req_id","id")->with("estado_tipo");
    }

    public function obtenerTipoProceso(){
        return $this->belongsTo('App\Models\TipoProceso', "tipo_proceso_id", "id");
    }

    public  function numeroCandidatosEnviadoscontratar(){
        $asistieron = RegistroProceso::where("procesos_candidato_req.requerimiento_id", $this->requerimiento_id)
        ->where("procesos_candidato_req.proceso", "ENVIO_CONTRATACION")
        ->count();

        if($asistieron <= 0){
            return "0";
        }else{
            return $asistieron;
        }
    }

    public function nombre_cliente_req(){
        $cliente = Negocio::select('clientes.nombre')
        ->leftjoin("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->where('negocio.id',$this->negocio_id)
        ->first();

        return $cliente['nombre'];
    }

    //Esta función reemplaza a la funcion getciudad para retornar el nombre del cliente
    public function cliente(){
        $cliente = Negocio::select('clientes.id')
        ->leftjoin("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->where('negocio.id',$this->negocio_id)
        ->first();

        return $cliente['id'];
    }

    public function solicitado_nombre(){
        $silicitado = User::select('name')
        ->where('id', $this->solicitado_por)
        ->first();

        return $silicitado['name'];
    }

    public function ciudad(){
        return $this->belongsTo('App\Models\Ciudad',"ciudad_id","id");
    }

    public function ciudad_req(){
        $ciudad = Ciudad::select('nombre')->where('cod_pais', $this->pais_id)
        ->where('cod_ciudad', $this->ciudad_id)
        ->where('cod_departamento', $this->departamento_id)
        ->first();

        return $ciudad['nombre'];
    }

    public function agencia_req(){
        $ciudad = Ciudad::leftjoin("agencias", "ciudad.agencia", "=", "agencias.id")
        ->select('nombre', 'agencia', 'agencias.descripcion as agencia_nombre')
        ->where('cod_pais', $this->pais_id)
        ->where('cod_ciudad', $this->ciudad_id)
        ->where('cod_departamento', $this->departamento_id)
        ->first();

        return $ciudad['agencia_nombre'];
    }

    public function departamento_req(){
        $ciudad = Departamento::select('nombre')
        ->where('cod_pais', $this->pais_id)
        ->where('cod_departamento', $this->departamento_id)
        ->first();

        return $ciudad['nombre'];
    }

    public function pais_req(){
        $ciudad = Pais::select('nombre')
        ->where('cod_pais', $this->pais_id)
        // ->where('cod_ciudad',$this->ciudad_id)
        // ->where('cod_departamento',$this->departamento_id)
        ->first();

        return $ciudad['nombre'];
    }

    public function tipo_proceso_req(){
        $proceso = TipoProceso::select('descripcion')
        ->where('id',$this->tipo_proceso_id)
        ->first();

        if($proceso != null){
            return $proceso['descripcion'];
        }else{
            return null;
        }
    }
    
    public function cargo_req(){
        $cargo = CargoEspecifico::select('descripcion')
        ->where('id', $this->cargo_especifico_id)
        ->first();

        return $cargo['descripcion'];
    }

    public function pcargo_req(){
        $cargo = CargoGenerico::select('descripcion')
        ->where('id', $this->cargo_generico_id)
        ->first();

        return $cargo['descripcion'];
    }

    public function a_contratar(){
        $cargo = Cargo::select('descripcion')
        ->where('id', $this->cargo_generico_id)
        ->first();

        return $cargo['descripcion'];
    }

    public function jornada_req(){
        $jornada = TipoJornada::select('descripcion')
        ->where('id', $this->tipo_jornadas_id)
        ->first();

        return $jornada['descripcion'];
    }

    public function experiencia_req(){
        $cargo = TipoExperiencia::select('descripcion')
        ->where('id', $this->tipo_experiencia_id)
        ->first();

        return $cargo['descripcion'];
    }

    public function ind_cumplimiento_ans(){
        //enviados a contratar en el requerimiento fechas****
        $indicador = 0;
        
        //indicador de personas por requerimiento
        //al cliente no a contratacion  
        $ind_cump_ans = RegistroProceso::where("requerimiento_id", $this->requerimiento_id)
        ->where("proceso", "ENVIO_APROBAR_CLIENTE")
        ->where("cand_presentado_puntual", 1)
        ->count();

        $cantidad_enviados = $ind_cump_ans;
        
        //buscando el negocio.. para buscar el ans
        //$negocio = Negocio::find($this->negocio_id);

        $ans = NegocioANS::where("negocio_id",$this->negocio_id)->get();

        // buscar las reglas del ans..
        
        //$fecha_inicio = new Carbon($value->fecha_inicio);
        
        if(count($ans)>0){
            foreach($ans as $key){
                $regla = explode('A', $key->regla);
                
                //el nombre de num_vacantes ahora es vacantes solicitadas
                if($this->vacantes_solicitadas >= $regla[0] && $this->vacantes_solicitadas <= $regla[1]){
                    // $dias_antes = $key->cantidad_dias;
                    $vacantes = $this->vacantes_solicitadas * $key->num_cand_presentar_vac;
                }else{
                    $vacantes = $this->vacantes_solicitadas * 1;
                }
            }
        }else{
            if($this->vacantes_solicitadas >= 1 && $this->vacantes_solicitadas <= 5){
                $vacantes = $this->vacantes_solicitadas * 3;
            }else{
                $vacantes = $this->vacantes_solicitadas * 1;
            }
        }// si existe el ans

        if($cantidad_enviados >= $vacantes){
            $indicador = 100;
        }else{
            $indicador = 0;
        }
        
        return $indicador;
    }

    public function ind_contratacion_oportuna(){
        //enviados a contratar en el requerimiento fechas****
        $indicador = 0;

        //candidatos contratados por vacante oportunamente
        $contratados = $this->cand_contratados_puntual;
        $vacantes = $this->vacantes_solicitadas; //cambio de num_vacantes a vacantes solicitadas

        //fecha limite de envio a contratacion
        $fecha_contratar = $this->fecha_tentativa;
        //fecha de contratacion candidato

        $ind_cump_ans = RegistroProceso::where("requerimiento_id", $this->requerimiento_id)
        ->where("proceso", "ENVIO_CONTRATACION")
        ->where("cand_contratado", 1)
        ->count();
        
        //->whereDate("fecha_inicio_contrato","<=",$fecha_contratar)
        //candidatos enviados a contratar antes de la fecha
        // $ind = count($ind_cump_ans); 
        //cambiar es mayor igual
        
        if($ind_cump_ans >= $vacantes ){
            //entonces cumple con enviar los candidatos a tiempo
            $indicador = 100;
        }else{ 
            $indicador = 0;
        }

        return $indicador;
    }

    public function ind_calidad_presentac(){
        //enviados a contratar en el requerimiento fechas****
        $indicador = 0;
        $coun = 0;
        
        //fecha limite de envio a contratacion
        //$fecha_contratar = $this->fecha_ingreso;

        $ind_cump_ans = RegistroProceso::where("requerimiento_id", $this->requerimiento_id)
        ->where("proceso", "ENVIO_APROBAR_CLIENTE")
        ->where("cand_presentado_puntual", 1)
        ->get(); //candidatos enviado a aprobar al cliente oportunamente

        foreach($ind_cump_ans as $key){
            # candidatos contratados de los q fueron enviados oportunamente.
            $ind_contratados = RegistroProceso::where("requerimiento_id", $this->requerimiento_id)
            ->where("proceso", "ENVIO_CONTRATACION")
            ->where("candidato_id", $key->candidato_id)
            ->where("cand_contratado", 1)
            ->first();
            
            //->whereDate("fecha_inicio_contrato","<=",$fecha_contratar)
            if(count($ind_contratados) > 0){
                $coun++;
            }
        }

        if($coun < 0){
            //entonces cumple con enviar los candidatos a tiempo
            $indicador = 100;
        }else{
            $indicador = 0;
        }

        return $indicador;
    }

    public function estadoRequerimiento_req()
    {
        $req = EstadosRequerimientos::select('estado')
        ->where('req_id', $this->id)
        ->orderBy('id', 'DESC')
        ->first();

        $estado = Estados::where('id', $req['estado'])
        ->select('descripcion as estado_nombre', 'id as estado_id')
        ->first();

        if ($estado == null) {
            $estado = "";
        }

        return $estado;
    }

    public function getNivelEstudio()
    {
        $nivel_estudio = NivelEstudios::select("*")
        ->where("id", $this->nivel_estudio)
        ->where("active", 1)
        ->first();

        return $nivel_estudio;
    }

    public function getMotivoRequerimiento()
    {
        $motivo_requerimiento = MotivoRequerimiento::select("*")
        ->where("id", $this->motivo_requerimiento_id)
        ->where("active", 1)
        ->first();

        return $motivo_requerimiento;
    }

    public function getTipoContrato()
    {
        $tipo_contrato = TipoContrato::select("*")
        ->where("id", $this->tipo_contrato_id)
        ->where("active", 1)
        ->first();

        return $tipo_contrato;
    }

    public function getConceptoPagos()
    {
        $concepto_pagos = ConceptoPago::select("*")
        ->where("id", $this->concepto_pago_id)
        ->first();
        
        return $concepto_pagos;
    }

    public function getSolicitud()
    {
        $solicitud = Solicitudes::where("id", $this->solicitud_id)->first();

        return $solicitud;
    }

    public function getTipoNomina()
    {
        $tipo_nomina = TipoNomina::select("*")
        ->where("id", $this->tipo_nomina)
        ->first();

        return $tipo_nomina;
    }

    public function getTipoSalario()
    {
        $tipo_salario = TipoSalario::select("*")
        ->where("id", $this->tipo_salario)
        ->first();

        return $tipo_salario;
    }

    public function getTipoLiquidacion()
    {
        if ($this->tipo_liquidacion === 'q') {
            $tipo_liquidacion = TipoLiquidacion::select("*")
            ->where("cod_tipo_liquidacion", $this->tipo_liquidacion)
            ->first();

            return $tipo_liquidacion;
        }

        $tipo_liquidacion = TipoLiquidacion::select("*")
        ->where("id", $this->tipo_liquidacion)
        ->first();

        return $tipo_liquidacion;
    }

    public function getCentroTrabajo()
    {
        $centro_trabajo = CentroTrabajo::select("*")
        ->where("id", $this->ctra_x_clt_codigo)
        ->first();

        return $centro_trabajo;
    }

    public function getCargoEspecifico()
    {
        $cargo_especifico = CargoEspecifico::select("*",DB::raw('CONCAT(descripcion,"-",codigo_1) as descripcion'))
        ->where("id", $this->cargo_especifico_id)
        ->first();

        if($cargo_especifico != null){
            return $cargo_especifico;
        }else{
            return null;
        }
    }
    
    public function getCiudad()
    {
        $ciudad = Ciudad::select("nombre")
        ->where("cod_ciudad", $this->ciudad)
        ->where("cod_departamento", $this->departamento)
        ->where("cod_pais", $this->pais)
        ->first();

        if($ciudad!=null){
            return $ciudad->nombre;
        }else{
            return null;
        }
    }

    public function getUnidadNegocio()
    {
        $negocio = Negocio::select("*")
        ->where("id", $this->negocio_id)
        ->first();

        $unidad_negocio = UnidadNegocio::select(DB::raw(" upper(nombre) as unidad_negocio "))
        ->where("codigo", $negocio->unidad_negocio)
        ->first();

        return $unidad_negocio->unidad_negocio;
    }

    public function getTipoProceso()
    {
        $tipo_proceso = TipoProceso::select(DB::raw(" upper(descripcion) as tipo_proceso "))
        ->where("id", $this->tipo_proceso_id)
        ->where("active", 1)
        ->first();

        if($tipo_proceso){
            return $tipo_proceso->tipo_proceso;
        }else{
            return '';
        }
    }

    public function empresa()
    {
        return $this->hasOne("App\Models\Negocio", "id", "negocio_id")->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->select("clientes.*")
        ->FIRST();
    }

    public function cargo()
    {
        return $this->hasOne("App\Models\CargoGenerico", "id", "cargo_generico_id")->FIRST();
    }

    public function cargo_especifico()
    {
        return $this->hasOne("App\Models\CargoEspecifico", "id", "cargo_especifico_id")->FIRST();
    }
    
    public function estudio()
    {
        return $this->hasOne("App\Models\NivelEstudios", "id", "nivel_estudio_id")->FIRST();
    }

    public function tipo_experiencia()
    {
        return $this->hasOne("App\Models\TipoExperiencia", "id", "tipo_experiencia_id")->first();
    }

    public function jornada()
    {
        return $this->hasOne("App\Models\TipoJornada", "id", "tipo_jornadas_id")->first();
    }

    public function getUbicacion()
    {
        $ubicacion = $this->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
            ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id");
        })
        ->where("ciudad.cod_pais", $this->pais_id)
        ->where("ciudad.cod_departamento", $this->departamento_id)
        ->where("ciudad.cod_ciudad", $this->ciudad_id)
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad"))
        ->first();

        if($ubicacion == null){
            return "";
        }

        return $ubicacion['ciudad'];
    }

    public function getNombreCiudad()
    {
        $ubicacion = $this->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
            ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id");
        })
        ->where("requerimientos.id", $this->id)
        ->select("ciudad.nombre as ciudad")
        ->first();

        if($ubicacion == null){
            $obj = new \stdClass();
            $obj->ciudad = "";
            return $obj;
        }

        return $ubicacion;
    }

    public function getDescripcionTipoProceso()
    {
        $tipoProceso = $this->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->where("requerimientos.id", $this->id)
        ->select("tipo_proceso.descripcion")
        ->first();

        if($tipoProceso == null){
            $obj = new \stdClass();
            $obj->descripcion = "";
            return $obj->descripcion;
        }

        return $tipoProceso->descripcion;
    }

    public function candidatosAprobar()
    {
        $estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_CONTRATADO'),
            config('conf_aplicacion.C_APROBADO_CLIENTE'),
            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
            config('conf_aplicacion.C_TERMINADO')
        ];

        $candidatos_req = $this->hasMany("App\Models\ReqCandidato", "requerimiento_id", "id")
        ->whereNotIn("estado_candidato", $estados_no_muestra)
        ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
        ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->where("procesos_candidato_req.proceso", "ENVIO_APROBAR_CLIENTE")
        ->where("procesos_candidato_req.apto", null)
        ->get();

        return $candidatos_req;
    }

    public function numeroAplicados()
    {
        $candidatos_aplicados = User::join("ofertas_users", "ofertas_users.user_id", "=", "users.id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->leftjoin('preg_req_resp', 'preg_req_resp.user_id', '=', 'datos_basicos.user_id')
        ->leftjoin('req_preguntas', 'req_preguntas.id', '=', 'preg_req_resp.preg_req_id')
        ->where("datos_basicos.estado_reclutamiento", "<>", config('conf_aplicacion.C_INACTIVO'))
        ->where("ofertas_users.requerimiento_id", $this->id)
        //->where('req_preguntas.req_id',$req_id)
        //->havingRaw("(SUM(preg_req_resp.puntuacion) <> 0) ")
        ->groupBy('preg_req_resp.user_id')
        //->whereNotIn("datos_basicos.user_id", $req_candidato)
        ->select(
            DB::raw("(select SUM(x.puntuacion)  from req_preguntas y inner join preg_req_resp x on y.id=x.preg_req_id where y.req_id =".$this->id." and users.id = x.user_id )as punt_can"),
            /* DB::raw('(select upper(x.descripcion) as estado from requerimiento_cantidato y inner join tipo_fuente x on y.otra_fuente=x.id where y.requerimiento_id=requerimientos.id limit 1 ) as fuentes'),       
            */
            "users.video_perfil as video",
            "datos_basicos.*"
        )
        ->count();

        return $candidatos_aplicados;
    }

    public function candidatosContratar()
    {
        $estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
        ];
        
        $candidatos_req = $this->hasMany("App\Models\ReqCandidato", "requerimiento_id", "requerimiento_id")
        ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
        ->groupBy('procesos_candidato_req.candidato_id')
        ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
         ->where("procesos_candidato_req.proceso", "ENVIO_CONTRATACION")
        ->select('users.name as nombre')
        ->get();

        return $candidatos_req;
    }

    public function estadoRequerimiento()
    {
        $select = $this->hasMany("App\Models\EstadosRequerimientos", "req_id")
        ->join("estados", "estados.id", "=", "estados_requerimiento.estado")
        ->select("estados.id as estado_id", "estados.descripcion as estado_nombre")
        ->orderBy("estados_requerimiento.id", "DESC")
        ->first();

        if ($select == null) {
            return "0";
        }

        return $select;
    }

    public function ultimoEstadoRequerimiento()
    {
        $select = $this->hasMany("App\Models\EstadosRequerimientos", "req_id")
        ->join("estados", "estados.id", "=", "estados_requerimiento.estado")
        ->select("estados.descripcion as estado_nombre", "estados.id as id", "estados_requerimiento.observaciones as observaciones")
        ->orderBy("estados_requerimiento.id", "desc")
        ->first();
        
        if ($select == null) {
            $obj                = new \stdClass();
            $obj->estado_nombre = "";
            $obj->id            = 0;
            $obj->observaciones = "";
            
            return $obj;
        }

        return $select;
    }

    static function ultimoEstadoRequerimiento2()
    {
        $select = $this->hasMany("App\Models\EstadosRequerimientos", "req_id")
        ->join("estados", "estados.id", "=", "estados_requerimiento.estado")
        ->select("estados.descripcion as estado_nombre", "estados.id as id", "estados_requerimiento.observaciones as observaciones")
        ->orderBy("estados_requerimiento.id", "desc")
        ->first();

        if ($select == null) {
            $obj                = new \stdClass();
            $obj->estado_nombre = "";
            $obj->id            = 0;
            $obj->observaciones = "";
            return $obj;
        }

        return $select;
    }

    //Buscar la cantidad de candidatos que asociaron al requerimientos
    public function cantidadAsociados()
    {
        $cantidad_asociados = User::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
        ->where("requerimiento_cantidato.requerimiento_id", $this->req_id)
        ->where("datos_basicos.estado_reclutamiento", "!=", "46")
        ->whereNotIn("requerimiento_cantidato.estado_candidato", ["47", "46"])
        ->select("COUNT(*) as cantidadasociados")
        ->first();

        if ($cantidad_asociados == null) {
            return "";
        }

        return $cantidad_asociados->cantidadasociados;
    }

    //Mostrar el nombre correspondiente de genero en la ruta ("/public/admin/gestion-requerimiento/{}") en informacion general de las solicitud
    public function getDescripcionGenero()
    {
        $genero = Genero::select("descripcion")
        ->where("id", $this->genero_id)
        ->first();

        return $genero;
    }

    //Mostrar el nombre correspondiente de estado civil en la ruta
    //("/public/admin/gestion-requerimiento/{}") en informacion general de las solicitud
    public function getDescripcionEstadoCivil()
    {
        $estado_civil = EstadoCivil::select("*")
        ->where("id", $this->estado_civil)
        ->first();

        $estado = EstadoCivil::select("descripcion")
        ->where("codigo",$estado_civil->codigo)
        ->first();

        return $estado;
    }

    /**
        * Contar el número de vacantes asociados al requerimiento
    **/
    public static function countVacantesAsociados($req_id = null){
        $asociados = Requerimiento::join("requerimiento_cantidato", "requerimiento_cantidato.requerimiento_id", "=", "requerimientos.id")
        ->where("requerimientos.id", $req_id)
        ->count();

        return $asociados;
    }

    /**
        * Contar el número de contratados al requerimiento
    **/
    public static function countVacantesContratados($req_id = null){
        $contratados = DB::table("siete_contratados")
        ->where("requerimiento_id", $req_id)
        ->count();

        return $contratados;
    }

    /**
        * Contar los candidato que se encuentren es estado apto de la entrevista
    **/
    public function entrevistaReqApto(){
        $entrevistaApto = EntrevistaCandidatos::where("entrevistas_candidatos.req_id", $this->requerimiento_id)
        ->where("entrevistas_candidatos.apto", 1)
        ->count();

        if($entrevistaApto <= 0){
            return "0";
        }else{
            return $entrevistaApto;
        }
    }

    public function tiempoEnvioCliente(){
        $tiempo = RegistroProceso::where("procesos_candidato_req.requerimiento_id", $this->requerimiento_id)
        ->where("procesos_candidato_req.proceso", "ENVIO_CONTRATACION_CLIENTE")
        ->select(
            'procesos_candidato_req.id as id',
            DB::raw('datediff(procesos_candidato_req.updated_at,procesos_candidato_req.created_at) as tiempo_respuesta_cliente')
        )
        ->orderBy('procesos_candidato_req.id', 'ASC')
        ->first();

        if($tiempo === null){
            return null;
        }else{
            if ($tiempo->procesos_candidato_req === 0) {
                return "0";
            }
            
            return $tiempo->tiempo_respuesta_cliente;
        }
    }

    /**
        Calcula el tiempo desde cuando se creo el requerimiento hasta que se cierra por que se cerro efectivamente
    **/
    public function tiempoEntregaEfectiva(){
        $tiempoEfec = EstadosRequerimientos::where("estados_requerimiento.req_id", $this->requerimiento_id)
        ->whereIn("estados_requerimiento.estado", [16, 2])
        ->select( 'estados_requerimiento.created_at as fecha_fin')
        ->first();

        if($tiempoEfec === null){
            return null;
        }else{
            if ($tiempoEfec->fecha_fin === 0) {
                return "0";
            }

            $fecha_fin = Carbon::parse($tiempoEfec->fecha_fin);

            $dias = $fecha_fin->diffInDays($this->fecha_creacion);
            
            return $dias;
        }
    }

    /**
        Contar candidatos que fueron a la entrevista
    **/
    public  function numeroCandidatosAsistieron(){
        $asistieron = EntrevistaCandidatos::where("entrevistas_candidatos.req_id", $this->requerimiento_id)
        ->where("entrevistas_candidatos.asistio", 1)
        ->count();

        if($asistieron <= 0){
            return "0";
        }else{
            return $asistieron;
        }
    }

    public  function numeroCandidatosEnviados(){
        $asistieron =  $tiempo = RegistroProceso::where("procesos_candidato_req.requerimiento_id", $this->requerimiento_id)
        ->where("procesos_candidato_req.proceso", "ENVIO_ENTREVISTA")
        ->count();

        if($asistieron <= 0){
            return "0";
        }else{
            return $asistieron;
        }
    }

    public function numeroCandidatosNoAsistieron(){
        $Noasistieron = EntrevistaCandidatos::where("entrevistas_candidatos.req_id", $this->requerimiento_id)
        ->where("entrevistas_candidatos.asistio", null)
        ->count();
     
        if($Noasistieron <= 0){
            return "0";
        }else{
            return $Noasistieron;
        }
    }

    //Preguntas que tiene el requerimiento o cargo
    public function preguntas_aplica_requerimiento()
    {
        $preguntas_aplica_requerimiento = Pregunta::where('preguntas.requerimiento_id', $this->id)
        ->where('preguntas.activo', 1)
        ->whereNotIn('preguntas.tipo_id', [4])
        ->count();

        $preguntas_aplica_cargo = Pregunta::where('preguntas.cargo_especifico_id', $this->cargo_especifico_id)
        ->where('preguntas.activo', 1)
        ->whereNotIn('preguntas.tipo_id', [4])
        ->count();

        $total_preguntas = $preguntas_aplica_requerimiento + $preguntas_aplica_cargo;

        if($total_preguntas <= 0){
            return 0;
        }

        return $total_preguntas;
    }

    //Preguntas filtro que tiene el requerimiento o cargo
    public function preguntas_filtro_aplica_requerimiento()
    {
        $preguntas_filtro_requerimiento = Pregunta::where('preguntas.requerimiento_id', $this->id)
        ->where('preguntas.activo', 1)
        ->where('preguntas.filtro', 1)
        ->whereNotIn('preguntas.tipo_id', [4])
        ->count();

        $preguntas_filtro_cargo = Pregunta::where('preguntas.cargo_especifico_id', $this->cargo_especifico_id)
        ->where('preguntas.activo', 1)
        ->where('preguntas.filtro', 1)
        ->whereNotIn('preguntas.tipo_id', [4])
        ->count();

        $total_preguntas = $preguntas_filtro_requerimiento + $preguntas_filtro_cargo;

        if($total_preguntas <= 0){
            return 0;
        }

        return $total_preguntas;
    }

    //Cuenta las preguntas filtro que tiene el requerimiento
    public function pregunta_aplica_idioma()
    {
        $preguntas_req = Pregunta::join('tipo_pregunta', 'tipo_pregunta.id', '=', 'preguntas.tipo_id')
        ->select('preguntas.id as req_preg_id', 'preguntas.*', 'tipo_pregunta.descripcion as descr_tipo_p')
        ->where('preguntas.cargo_especifico_id', $this->cargo_especifico_id)
        ->where('preguntas.activo', 1)
        ->where('preguntas.tipo_id', 4)
        ->orderBy('preguntas.id', 'ASC')
        ->count();

        if($preguntas_req <= 0){
            return "0";
        }else{
            return $preguntas_req;
        }
    }

    //Cuenta si el candidato ya ha respondido las preguntas del requerimiento
    public function pregunta_candidato_respuesta()
    {
        $user = Sentinel::getUser();

        if (isset($user)) {
            $respuestas_preguntas = PregReqResp::join('preguntas', 'preguntas.id', '=', 'preg_req_resp.preg_id')
            ->where('preg_req_resp.user_id', $user->id)
            ->where('preg_req_resp.req_id', $this->id)
            ->where('preguntas.filtro', 0)
            ->orWhere('preguntas.filtro', null)
            ->whereNotIn('preguntas.tipo_id', [4])
            ->orderBy('preguntas.id', 'ASC')
            ->count();

            if($respuestas_preguntas <= 0 || $respuestas_preguntas == null){
                return 0;
            }

            return $respuestas_preguntas;
        }

        return 0;
    }

    //Cuenta si el candidato ya ha respondido las preguntas del requerimiento filtro
    public function pregunta_candidato_respuesta_filtro()
    {
        $user = Sentinel::getUser();

        if (isset($user)) {
            $respuestas_preguntas_filtro = PregReqResp::join('preguntas', 'preguntas.id', '=', 'preg_req_resp.preg_id')
            ->where('preg_req_resp.user_id', $user->id)
            ->where('preg_req_resp.req_id', $this->id)
            ->where('preguntas.filtro', 1)
            ->whereNotIn('preguntas.tipo_id', [4])
            ->orderBy('preguntas.id', 'ASC')
            ->count();

            if($respuestas_preguntas_filtro <= 0 || $respuestas_preguntas_filtro == null){
                return 0;
            }

            return $respuestas_preguntas_filtro;
        }

        return 0;
    }

    //Cuenta si el candidato ya ha respondido filtro y no paso
    public function aplicacion_candidato_oferta()
    {
        $user = Sentinel::getUser();

        if (isset($user)) {
            $aplicacion = OfertaUser::where("user_id", $user->id)
            ->where("requerimiento_id", $this->id)
            ->where("aplica", 0)
            ->count();

            if($aplicacion <= 0 || $aplicacion == null){
                return 0;
            }

            return $aplicacion;
        }

        return 0;
    }

    public function empresa_logo() {
        //dd($this->hasOne("App\Models\EmpresaLogo", "id", "empresa_contrata")->first());
        //return $this->hasOne("App\Models\EmpresaLogo", "id", "empresa_contrata")->first();
        $empresa_logo = EmpresaLogo::where('id', $this->empresa_contrata)->first();

        return $empresa_logo;
    }

    public function visibilidad_aplicar(){
    }

    public function cantidadPreperfilados(){
        $datos_ficha = Ficha::where("cargo_cliente", $this->cargo_especifico_id)
        ->where("cliente_id", $this->cliente_id)
        ->select("*")
        ->first();

        if ($datos_ficha !== null) {
            //Busca las opciones de auxiliar de fichas para validar botones
            $valida_botones = AuxiliarFicha::where("ficha_id", $datos_ficha->id)
            ->select("*")
            ->get();
        } else {
            $valida_botones = null;
        }

        if ($datos_ficha !== null) {
            //Cuando la ficha esta creada se buscar los datos de la ficha
            $genero = $datos_ficha->genero;

            if ($genero == 1) {
                $genero = ['1'];
            } elseif ($genero == 2) {
                $genero = ['2'];
            } else {
                $genero = ['1', '2'];
            }

            $candidatos_cargo_general = DatosBasicos::join("perfilamiento", "perfilamiento.user_id", "=", "datos_basicos.user_id")
            ->join("requerimientos", "requerimientos.cargo_generico_id", "=", "perfilamiento.cargo_generico_id")
            ->join("estudios", "estudios.user_id", "=", "datos_basicos.user_id")
            ->join('users', 'users.id', '=', 'datos_basicos.user_id')
            ->where("requerimientos.id", $this->id)
            ->where("datos_basicos.aspiracion_salarial", $datos_ficha->rango_salarial)
            ->where("estudios.nivel_estudio_id", $datos_ficha->escolaridad)
            ->where("datos_basicos.pais_residencia", $this->pais_id)
            ->where("datos_basicos.departamento_residencia", $this->departamento_id)
            ->where("datos_basicos.ciudad_residencia", $this->ciudad_id)
            ->whereIn("datos_basicos.genero", $genero)
            ->whereIn("datos_basicos.estado_reclutamiento", [config('conf_aplicacion.C_ACTIVO'), config('conf_aplicacion.C_QUITAR')])
            ->whereRaw("datos_basicos.user_id not in (select candidato_id from requerimiento_cantidato where requerimiento_id=" . $this->id . " and estado_candidato not in (" . config('conf_aplicacion.C_QUITAR').",".
            config('conf_aplicacion.C_INACTIVO'). ")) and TIMESTAMPDIFF(DAY, fecha_nacimiento, CURDATE())/(365.25) between " . $datos_ficha->edad_minima . " and " . $datos_ficha->edad_maxima . " ")
            ->groupBy("datos_basicos.user_id","users.video_perfil")
            ->count();
        } else {
            //Cuando no hay fichas creadar al cargo generico se traen los datos del requerimiento
            $genero = $this->genero_id;

            if ($genero == 1) {
                $genero = ['1'];
            } elseif ($genero == 2) {
                $genero = ['2'];
            } else {
                $genero = ['1', '2'];
            }
 
            $candidatos_cargo_general = DatosBasicos::join("perfilamiento", "perfilamiento.user_id", "=", "datos_basicos.user_id")
            ->join("requerimientos", "requerimientos.cargo_generico_id", "=", "perfilamiento.cargo_generico_id")
            ->join('users', 'users.id', '=', 'datos_basicos.user_id')
            ->join("estudios", "estudios.user_id", "=", "datos_basicos.user_id")
            ->where("requerimientos.id", $this->id)
            ->where("estudios.nivel_estudio_id", $this->nivel_estudio)
            ->where("datos_basicos.pais_residencia", $this->pais_id)
            ->where("datos_basicos.departamento_residencia", $this->departamento_id)
            ->where("datos_basicos.ciudad_residencia", $this->ciudad_id)
            ->whereIn("datos_basicos.genero", $genero)
            ->whereIn("datos_basicos.estado_reclutamiento", [config('conf_aplicacion.C_ACTIVO'), config('conf_aplicacion.C_QUITAR')])
            ->whereRaw("datos_basicos.user_id not in (select candidato_id from requerimiento_cantidato where requerimiento_id=" . $this->id . " and estado_candidato not in (" . config('conf_aplicacion.C_QUITAR').",".
            config('conf_aplicacion.C_INACTIVO'). ")) and TIMESTAMPDIFF(DAY, fecha_nacimiento, CURDATE())/(365.25) between " . $this->edad_minima . " and " . $this->edad_maxima . "  ")
            ->select('datos_basicos.*','users.video_perfil as video')
            ->groupBy("datos_basicos.user_id")
            ->count();
        }

        return $candidatos_cargo_general;
    }

    // query scopes

    public function scopeTipoProceso($query, $data)
    {
        return ($data->has("tipo_proceso_id") && $data->get("tipo_proceso_id") != "") ? $query->where('requerimientos.tipo_proceso_id', $data->get("tipo_proceso_id")) : $query;
    }

    public function preperfilados(){
       return $this->belongsToMany('App\Models\User', 'candidatos_preperfilados','req_id','candidato_id');
    }
}
