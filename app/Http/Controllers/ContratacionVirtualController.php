<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use \DB;

use App\Models\CargoDocumentoAdicional;
use App\Models\ConfirmacionDocumentosAdicionales;
use App\Models\ConfirmacionPreguntaContrato;
use App\Models\ContratoCancelado;
use App\Models\DatosBasicos;
use App\Models\Documentos;
use App\Models\EmpresaLogo;
use App\Models\EstadosRequerimientos;
use App\Models\FirmaContratos;
use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\PreguntasContrato;
use App\Models\RegistroProceso;
use App\Models\ReqCandidato;
use App\Models\Requerimiento;
use App\Models\RequerimientoContratoCandidato;
use App\Models\User;
use App\Models\Sitio;
use App\Models\TipoContrato;
use App\Models\ClausulaValorCargo;
use App\Models\ClausulaValorRequerimiento;
use App\Models\ClausulaValorCandidato;
use App\Models\SitioModulo;
use App\Models\FirmaContratoFoto;
use App\Models\DocumentoAdicional;
use App\Models\OrdenMedica;
use Illuminate\Support\Facades\Event;
use App\Http\Controllers\ReclutamientoController;

use Carbon\Carbon;
use Webpatser\Uuid\Uuid;

//Helper
use triPostmaster;
use File;

class ContratacionVirtualController extends Controller {

    private $search = [
        '{nombre_completo}',
        '{nombres}',
        '{primer_apellido}',
        '{segundo_apellido}',
        '{cedula}',
        '{direccion}',
        '{celular}',
        '{fecha_firma}',
        '{fecha_ingreso}',
        '{cargo_ejerce}',
        '{empresa_usuaria}',
        '{tipo_documento}',
        '{ciudad_oferta}',
        '{ciudad_contrato}',
        '{valor_variable}',
        '{empresa_contrata}',
        '{salario_asignado}'
    ];

    public function __construct()
    {
        parent::__construct();

        $this->meses = [
            1  => "Enero",
            2  => "Febrero",
            3  => "Marzo",
            4  => "Abril",
            5  => "Mayo",
            6  => "Junio",
            7  => "Julio",
            8  => "Agosto",
            9  => "Septiembre",
            10 => "Octubre",
            11 => "Noviembre",
            12 => "Diciembre"
        ];

         $this->dias = [
            1  => "lunes",
            2  => "martes",
            3  => "miércoles",
            4  => "jueves",
            5  => "viernes",
            6  => "sábado",
            7  => "domingo"
        ];

        $this->dias_semana = [
            1 => "Lunes",
            2 => "Martes",
            3 => "Miércoles",
            4 => "Jueves",
            5 => "Viernes",
            6 => "Sábado",
            7 => "Domingo"
        ];
    }
    
    /*
    *   Firma contrato candidato (Vista)
    */
    public function firmaContratoCandidato($user_id, $req_id, $modulo = 'modulo_cv')
    {
        //Decrypt URL data
        $userId = Crypt::decrypt($user_id);
        $ReqId = Crypt::decrypt($req_id);
        $sitio = Sitio::first();
        $sitio_modulo = SitioModulo::first();

        $checkContrato = FirmaContratos::where('user_id', $userId)
        ->where('req_id', $ReqId)
        ->where('estado', 1)
        ->whereIn('terminado', [1, 2])
        ->orderBy('created_at', 'DESC')
        ->first();

        if ($modulo == 'modulo_cv') {
            if($userId != $this->user->id){
                return redirect()->route('home');
            }else if(count($checkContrato) > 0){
                return redirect()->route('dashboard');
            }
        } else {
            //modulo_admin
            if(count($checkContrato)){
                return redirect()->route('notfound');
            }

            try {
                $modulo = Crypt::decrypt($modulo);
            } catch (\Exception $e) {
                $modulo = 'modulo_admin';
            }
        }
        
        $firmaContrato = FirmaContratos::where('user_id', $userId)
        ->where('req_id', $ReqId)
        ->orderBy('created_at', 'DESC')
        ->first();

        $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes","clientes.id", "=", "negocio.cliente_id")
        ->join("users_x_clientes","users_x_clientes.cliente_id", "=", "clientes.id")
        ->join("estados_requerimiento","estados_requerimiento.req_id","=","requerimientos.id")
        ->select(
            'requerimientos.*',
            'clientes.direccion as direccion_cliente',
            'clientes.telefono as telefono_cliente'
        )
        ->find($ReqId);

        $candidato = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
        ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
        ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
        ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
        ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
        ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
        ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
        ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
        ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
        ->where("datos_basicos.user_id", $userId)
        ->select(
            "datos_basicos.*",
            "tipo_identificacion.descripcion as dec_tipo_doc",
            "generos.descripcion as genero_desc",
            "estados_civiles.descripcion as estado_civil_des",
            "aspiracion_salarial.descripcion as aspiracion_salarial_des",
            "clases_libretas.descripcion as clases_libretas_des",
            "tipos_vehiculos.descripcion as tipos_vehiculos_des",
            "categorias_licencias.descripcion as categorias_licencias_des",
            "entidades_afp.descripcion as entidades_afp_des",
            "entidades_eps.descripcion as entidades_eps_des"
        )
        ->first();

        $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("tipos_salarios", "tipos_salarios.id", "=", "requerimientos.tipo_salario")
        ->join("tipos_liquidaciones", "tipos_liquidaciones.id", "=", "requerimientos.tipo_liquidacion")
        ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
        ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
        ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join("tipos_nominas", "tipos_nominas.id", "=", "requerimientos.tipo_nomina")
        ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
            ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
        ->select(
            "cargos_especificos.descripcion",
            "requerimientos.sitio_trabajo as sitio_trabajo",
            "requerimiento_cantidato.created_at",
            "requerimiento_cantidato.requerimiento_id",
            "requerimiento_cantidato.id as requerimiento_cantidato_id",
            "clientes.nombre as cliente_nombre",
            "requerimientos.salario as salario",
            "requerimientos.adicionales_salariales as adicionales_salariales",
            "requerimientos.termino_inicial_contrato",
            "tipos_salarios.descripcion as descripcion_tipo_salario",
            "tipos_liquidaciones.descripcion as descripcion_tipo_liquidacion",
            "requerimientos.funciones as funciones",
            "cargos_genericos.descripcion as nombre_cargo",
            "cargos_especificos.descripcion as nombre_cargo_especifico",
            "requerimientos.empresa_contrata as empresa_contrata",
            "tipos_nominas.descripcion as nomina_contrato",
            "agencias.descripcion as agencia",
            "agencias.direccion as agencia_direccion",
            "ciudad.nombre as nombre_ciudad",
            "motivo_requerimiento.descripcion as motivo_requerimiento",
            "requerimientos.cargo_especifico_id"
        )
        ->where("requerimiento_cantidato.candidato_id", $userId)
        ->where("requerimiento_cantidato.requerimiento_id",$ReqId)
        ->where("procesos_candidato_req.proceso","ENVIO_CONTRATACION")
        ->groupBy('procesos_candidato_req.candidato_id')
        ->orderBy("requerimiento_cantidato.id", "DESC")
        ->first();

        $fechasContrato = RequerimientoContratoCandidato::leftJoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
        ->leftJoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
        ->where('requerimiento_id', $ReqId)
        ->where('candidato_id', $userId)
        ->select(
            'fecha_ingreso',
            'fecha_fin_contrato',
            'entidades_afp.descripcion as entidad_afp',
            'entidades_eps.descripcion as entidad_eps'
            )
        ->orderBy('requerimiento_contrato_candidato.created_at', 'DESC')
        ->first();

        $empresa_contrata = EmpresaLogo::where('id', $reqcandidato->empresa_contrata)->first();

        //Calcular edad de candidatos.
        $edad = ($candidato->fecha_nacimiento != 0 && $candidato->fecha_nacimiento != "") ? Carbon::parse($candidato->fecha_nacimiento)->age : "";

        $lugarnacimiento = null;
        $lugarexpedicion = null;
        $lugarresidencia = null;

        if($candidato != null) {
            $lugarnacimiento = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais",$candidato->pais_nacimiento)
            ->where("ciudad.cod_departamento",$candidato->departamento_nacimiento)
            ->where("ciudad.cod_ciudad", $candidato->ciudad_nacimiento)
            ->first();

            $lugarexpedicion = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais",$candidato->pais_id)
            ->where("ciudad.cod_departamento",$candidato->departamento_id)
            ->where("ciudad.cod_ciudad",$candidato->ciudad_id)
            ->first();

            $lugarresidencia = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select(\DB::raw("CONCAT(ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais",$candidato->pais_residencia)
            ->where("ciudad.cod_departamento",$candidato->departamento_residencia)
            ->where("ciudad.cod_ciudad", $candidato->ciudad_residencia)
            ->first();
        }

        //Hash data
        $moduloHash = Crypt::encrypt($modulo);

        //Hash data
        $userIdHash = Crypt::encrypt($userId);

        if ($firmaContrato !== null) {
            $firmaContratoHash = Crypt::encrypt($firmaContrato->id);   
        }

        $fecha = date("d/m/Y");

        $adicional_medico = false;  //Para controlar si lleva clausula medica
        $especificaciones = null;   //En caso que lleve la clausula medica: si es null es porque ya firmo la clausula - si es distinto de null es porque no ha firmado la clausula
        if ($sitio_modulo->clausula_medica == 'enabled') {
            if ($sitio_modulo->salud_ocupacional == 'si') {
                //Validar si el candidato tiene examenes médicos con observaciones
                $requerimiento_candidato = ReqCandidato::where('requerimiento_id', $ReqId)
                ->where('candidato_id', $userId)
                ->orderBy('created_at', 'DESC')
                ->first();

                $requerimiento_candidato_orden = OrdenMedica::where('req_can_id', $requerimiento_candidato->id)
                ->orderBy('created_at', 'DESC')
                ->first();

                if($requerimiento_candidato_orden != null){
                    if($requerimiento_candidato_orden->especificacion != null && $requerimiento_candidato_orden->especificacion != ''){
                        //El campo especificacion en la Orden Medica, se llena exclusivamente cuando el candidato le cargaron examenes medicos con recomendaciones o restricciones
                        $adicional_medico = true;
                        if($requerimiento_candidato_orden->aceptada !== 1 && $requerimiento_candidato_orden->aceptada != 1) {
                            //Si no ha firmado la clausula medica, se llena la variable especificaciones
                            $especificaciones = $requerimiento_candidato_orden->especificacion;
                        }
                    }
                }
            } else {
                $documentos_medicos = Documentos::where('user_id', $userId)
                    ->where('requerimiento', $ReqId)
                    ->where('tipo_documento_id', 8)
                    ->whereIn('resultado', [3,4])
                ->get();

                if (count($documentos_medicos) > 0) {
                    //Si tiene documentos medicos con recomendaciones o restricciones
                    $adicional_medico = true;

                    $documentos_medicos_clausula = Documentos::where('user_id', $userId)
                        ->where('requerimiento', $ReqId)
                        ->where('tipo_documento_id', 8)
                        ->whereIn('resultado', [3,4])
                        ->whereNull('aceptada')
                    ->get();

                    if (count($documentos_medicos_clausula) > 0) {
                        //No ha firmado la clausula, por lo que se llena la variable especificaciones
                        $especificaciones = '<ul>';
                        foreach ($documentos_medicos as $doc) {
                            $especificaciones .= "<li>$doc->observacion</li>";
                        }
                        $especificaciones .= '</ul>';
                    }
                }
            }
        }

        /*
         * Buscas los documentos adicionales asociados al cargo
        */

        $documentoAsociados = CargoDocumentoAdicional::where("active", 1)
        ->where('cargo_id', $reqcandidato->cargo_especifico_id)
        ->select('active')
        ->orderBy('id', 'ASC')
        ->get();

        if($sitio->multiple_empresa_contrato) {
            $cuerpo_contrato = DB::table('empresa_tipo_contrato')
            ->where("empresa_id", $empresa_contrata->id)
            ->where('tipo_contrato_id', $requerimientos->tipo_contrato_id)
            ->first();

            $tipo_contrato = TipoContrato::find($requerimientos->tipo_contrato_id);

            /* el id 5 es el de prestacion de servicios */
            if ($candidato != null && $tipo_contrato != null && $tipo_contrato->id == 5) {
                $req_contrato_candidato = RequerimientoContratoCandidato::join("bancos", "bancos.id", "=", "requerimiento_contrato_candidato.nombre_banco")
                ->select('requerimiento_contrato_candidato.tipo_cuenta',
                'requerimiento_contrato_candidato.numero_cuenta',
                'bancos.nombre_banco as banco')
                ->where("candidato_id", $userId)
                ->where("requerimiento_id", $requerimientos->id)
                ->first();
            }else{
                $req_contrato_candidato = null;
            }

            $meses = $this->meses;
            $dias_semana = $this->dias_semana;

            $importarContrato = "contratos.$tipo_contrato->modelo_contrato"; //el tipo de contrato que va a mostrar

            return view("contratos.contrato_view.contrato_default", compact(
                'documentoAsociados',
                'importarContrato',
                'user_id',
                'req_id',
                'userId',
                'ReqId',
                'candidato',
                'firmaContrato',
                'lugarnacimiento',
                'lugarexpedicion',
                'lugarresidencia',
                'reqcandidato',
                'userIdHash',
                'firmaContratoHash',
                'fecha',
                'empresa_contrata',
                'fechasContrato',
                'sitio',
                'moduloHash',
                'cuerpo_contrato',
                'adicional_medico',
                'especificaciones',
                'req_contrato_candidato',
                'meses',
                'dias_semana',
                'edad'
            ));
        }else {
            $importarContrato = 'home.firma-contrato-candidato'; //el tipo de contrato que va a mostrar

            return view("contratos.contrato_view.contrato_default", compact(
                'documentoAsociados',
                'importarContrato',
                'user_id',
                'req_id',
                'userId',
                'ReqId',
                'candidato',
                'firmaContrato',
                'lugarnacimiento',
                'lugarexpedicion',
                'lugarresidencia',
                'reqcandidato',
                'userIdHash',
                'firmaContratoHash',
                'adicional_medico',
                'especificaciones',
                'fecha',
                'moduloHash',
                'empresa_contrata',
                'fechasContrato',
                'sitio'
            ));
        }
    }

    /*
    *   Firma documentos adicionales - Guardado de contrato (Vista)
    */
    public function confirmar_documentos_adicionales($user_id, $contrato_id, $moduloHash)
    {
        $userId = Crypt::decrypt($user_id);
        $contratoId = Crypt::decrypt($contrato_id);
        $sitio = Sitio::first();
        $sitio_modulo = SitioModulo::first();

        try {
            $modulo = Crypt::decrypt($moduloHash);
        } catch (\Exception $e) {
            $modulo = 'modulo_cv';
        }
        //$fecha = date("d/m/Y");

        $dia = date('d');
        $mes = date('n');
        $ano = date('Y');
        $fecha = "$dia de ".$this->meses[$mes]." de $ano";

        //Crear bandera fin de los documentos adicionales
        $finAdicionales = false;

        $checkContrato = FirmaContratos::where('id', $contratoId)
        ->where('user_id', $userId)
        ->where('estado', 1)
        ->whereIn('terminado', [1, 2])
        ->orderBy('created_at', 'DESC')
        ->first();

        if ($modulo == 'modulo_cv') {
            if($userId != $this->user->id){
                return redirect()->route('home');
            }else if(count($checkContrato)){
                return redirect()->route('dashboard');
            }
        } else {
            //modulo_admin
            if(count($checkContrato)){
                return redirect()->route('notfound');
            }
        }

        $contrato = FirmaContratos::where('id', $contratoId)
        ->where('user_id', $userId)
        ->orderBy('created_at', 'DESC')
        ->first();

        //Buscar el requerimiento
        $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=","requerimientos.cargo_especifico_id")
        ->leftjoin("empresa_logos", "empresa_logos.id", "=", "requerimientos.empresa_contrata")
        ->where("requerimientos.id", $contrato->req_id)
        ->select(
            "requerimientos.id as req_id",
            "cargos_especificos.descripcion as cargo",
            "clientes.nombre as nombre_cliente",
            "clientes.nit as nit_cliente",
            "requerimientos.id",
            "requerimientos.negocio_id",
            "requerimientos.empresa_contrata",
            "requerimientos.salario",
            "requerimientos.pais_id",
            "requerimientos.departamento_id",
            "requerimientos.ciudad_id",
            "requerimientos.cargo_especifico_id as cargo_especifico_id",
            "empresa_logos.*"
        )
        ->first();

        $req_id = $requerimiento->req_id;

        $user = User::find($userId);
        $candidato = DatosBasicos::where("user_id", $user->id)->first();

        /*
         * Busca las clásusulas que no esten firmadas y que sean creadas manualmente en el sistema
        */

        $documento = ConfirmacionDocumentosAdicionales::join('documentos_adicionales_contrato', 'documentos_adicionales_contrato.id', '=', 'confirmacion_documentos_adicionales.documento_id')
        ->where("confirmacion_documentos_adicionales.externo", 0)
        ->where('confirmacion_documentos_adicionales.user_id', $userId)
        ->where('confirmacion_documentos_adicionales.contrato_id', $contratoId)
        ->where('confirmacion_documentos_adicionales.estado', 0)
        ->where("documentos_adicionales_contrato.creada", 0)
        ->select(
            'confirmacion_documentos_adicionales.*',
            'documentos_adicionales_contrato.*',
            'documentos_adicionales_contrato.id as idDocumento'
        )
        ->orderBy('documentos_adicionales_contrato.id', 'ASC')
        ->first();

        $lugarexpedicion = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais",$candidato->pais_id)
        ->where("ciudad.cod_departamento",$candidato->departamento_id)
        ->where("ciudad.cod_ciudad",$candidato->ciudad_id)
        ->first();

        /*
         * Buscar las cláusulas asociadas al cargo del requerimiento
        */

        $documentos_parametrizados = CargoDocumentoAdicional::where("cargo_id", $requerimiento->cargo_especifico_id)->get();

        $moduloHash = Crypt::encrypt($modulo);

        $userIdHash = Crypt::encrypt($userId);

        if ($contrato !== null) {
            $firmaContratoHash = Crypt::encrypt($contrato->id);   
        }

        $adicional_medico = false;  //Para controlar si lleva clausula medica
        $especificaciones = null;   //En caso que lleve la clausula medica: si es null es porque ya firmo la clausula - si es distinto de null es porque no ha firmado la clausula

        if ($sitio_modulo->clausula_medica == 'enabled') {
            if ($sitio_modulo->salud_ocupacional == 'si') {
                //Validar si el candidato tiene examenes médicos con observaciones
                $requerimiento_candidato = ReqCandidato::where('requerimiento_id', $req_id)
                ->where('candidato_id', $userId)
                ->orderBy('created_at', 'DESC')
                ->first();

                $requerimiento_candidato_orden = OrdenMedica::where('req_can_id', $requerimiento_candidato->id)
                ->orderBy('created_at', 'DESC')
                ->first();

                if($requerimiento_candidato_orden != null){
                    if($requerimiento_candidato_orden->especificacion != null && $requerimiento_candidato_orden->especificacion != ''){
                        //El campo especificacion en la Orden Medica, se llena exclusivamente cuando el candidato le cargaron examenes medicos con recomendaciones o restricciones
                        $adicional_medico = true;
                        if($requerimiento_candidato_orden->aceptada !== 1 && $requerimiento_candidato_orden->aceptada != 1) {
                            //Si no ha firmado la clausula medica, se llena la variable especificaciones
                            $especificaciones = $requerimiento_candidato_orden->especificacion;
                        }
                    }
                }
            } else {
                $documentos_medicos = Documentos::where('user_id', $userId)
                    ->where('requerimiento', $req_id)
                    ->where('tipo_documento_id', 8)
                    ->whereIn('resultado', [3,4])
                ->get();

                if (count($documentos_medicos) > 0) {
                    //Si tiene documentos medicos con recomendaciones o restricciones
                    $adicional_medico = true;

                    $documentos_medicos_clausula = Documentos::where('user_id', $userId)
                        ->where('requerimiento', $req_id)
                        ->where('tipo_documento_id', 8)
                        ->whereIn('resultado', [3,4])
                        ->whereNull('aceptada')
                    ->get();

                    if (count($documentos_medicos_clausula) > 0) {
                        //No ha firmado la clausula, por lo que se llena la variable especificaciones
                        $especificaciones = '<ul>';
                        foreach ($documentos_medicos as $doc) {
                            $especificaciones .= "<li>$doc->observacion</li>";
                        }
                        $especificaciones .= '</ul>';
                    }
                }
            }
        }

        //Busca documentos creados por la instancia
        $documentos_parametrizados_creado = CargoDocumentoAdicional::join("documentos_adicionales_contrato", "documentos_adicionales_contrato.id", "=", "cargos_documentos_adicionales.adicional_id")
        ->where("cargos_documentos_adicionales.cargo_id", $requerimiento->cargo_especifico_id)
        ->where("cargos_documentos_adicionales.active", 1)
        ->where("documentos_adicionales_contrato.active", 1)
        ->where("documentos_adicionales_contrato.creada", 1)
        ->get();

        /*
         * Busca los documentos creados en el generador y que no esten firmados
        */

        $documentoCreado = ConfirmacionDocumentosAdicionales::join('documentos_adicionales_contrato', 'documentos_adicionales_contrato.id', '=', 'confirmacion_documentos_adicionales.documento_id')
        ->where("documentos_adicionales_contrato.creada", 1)
        ->where("documentos_adicionales_contrato.active", 1)
        ->where("confirmacion_documentos_adicionales.externo", 1)
        ->where('confirmacion_documentos_adicionales.user_id', $userId)
        ->where('confirmacion_documentos_adicionales.contrato_id', $contratoId)
        ->where('confirmacion_documentos_adicionales.estado', 0)
        ->select(
            'confirmacion_documentos_adicionales.*',
            'documentos_adicionales_contrato.*',
            'documentos_adicionales_contrato.id as idDocumento'
        )
        ->orderBy('documentos_adicionales_contrato.id', 'ASC')
        ->first();

        /*
         * Buscas las confirmaciones
        */

        $documentoAsociados = ConfirmacionDocumentosAdicionales::join('documentos_adicionales_contrato', 'documentos_adicionales_contrato.id', '=', 'confirmacion_documentos_adicionales.documento_id')
        ->where("documentos_adicionales_contrato.active", 1)
        ->where('confirmacion_documentos_adicionales.user_id', $userId)
        ->where('confirmacion_documentos_adicionales.contrato_id', $contratoId)
        ->select('estado')
        ->orderBy('documentos_adicionales_contrato.id', 'ASC')
        ->get();

        //Valida documentos creados por la instancia
        if (count($documentos_parametrizados_creado) > 0) {
            if ($documentoCreado != null) {
                $dia = date('d');
                $mes = date('n');
                $ano = date('Y');
                $fecha_firma_replace = "$dia de ".$this->meses[$mes]." de $ano";

                //Cambio de banderas por información candidato
                $subject = $documentoCreado->contenido_clausula;

                $datos = DatosBasicos::where('user_id', $userId)->first();

                $fecha_ingreso_replace = RequerimientoContratoCandidato::where('requerimiento_id', $req_id)
                ->where('candidato_id', $userId)
                ->select('fecha_ingreso', 'fecha_fin_contrato')
                ->orderBy('created_at', 'DESC')
                ->first();

                $fecha_ingreso_replace = explode("-", $fecha_ingreso_replace->fecha_ingreso);

                $dia_ingreso = $fecha_ingreso_replace[2];
                $mes_ingreso = (int)$fecha_ingreso_replace[1];
                $año_ingreso = $fecha_ingreso_replace[0];

                $fecha_ingreso_replace = "$dia_ingreso de ".$this->meses[$mes_ingreso]." de $año_ingreso";

                $replace_datos_clausula = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->select(
                    "cargos_especificos.descripcion as cargo_ejerce",
                    "clientes.nombre as empresa_usuaria"
                )
                ->where("requerimiento_cantidato.candidato_id", $userId)
                ->where("requerimiento_cantidato.requerimiento_id", $req_id)
                ->where("procesos_candidato_req.proceso", "ENVIO_CONTRATACION")
                ->groupBy('procesos_candidato_req.candidato_id')
                ->orderBy("requerimiento_cantidato.id", "DESC")
                ->first();

                $tipo_documento = mb_strtolower($datos->getTipoIdentificacion->descripcion);

                //Para reemplazar las banderas de ciudades del generador
                $ciudades_clausula = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                ->join("departamentos", function ($join) {
                    $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                    ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                    ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                })
                ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
                ->select(
                    "ciudad.nombre as sitio_trabajo",
                    //"requerimientos.sitio_trabajo as sitio_trabajo",
                    "agencias.descripcion as agencia"
                )
                ->where("requerimiento_cantidato.candidato_id", $userId)
                ->where("requerimiento_cantidato.requerimiento_id", $req_id)
                ->where("procesos_candidato_req.proceso", "ENVIO_CONTRATACION")
                ->groupBy('procesos_candidato_req.candidato_id')
                ->orderBy("requerimiento_cantidato.id", "DESC")
                ->first();

                $ciudad_oferta = $ciudades_clausula->sitio_trabajo;
                $ciudad_contrato = $ciudades_clausula->agencia;

                $sitioModulo = SitioModulo::first();
                if ($sitioModulo->generador_variable == 'enabled') {
                    $clausula_valor = ClausulaValorCandidato::where('user_id', $userId)
                    ->where('req_id', $req_id)
                    ->where('adicional_id', $documentoCreado->idDocumento)
                    ->first();

                    //Si no tiene en candidato para al req
                    if (empty($clausula_valor)) {
                        $clausula_valor = ClausulaValorRequerimiento::where('req_id', $req_id)
                        ->where('adicional_id', $documentoCreado->idDocumento)
                        ->first();
                    }
                }else {
                    $clausula_valor = ClausulaValorRequerimiento::where('req_id', $req_id)
                    ->where('adicional_id', $documentoCreado->idDocumento)
                    ->first();

                    if (empty($clausula_valor)) {
                        $clausula_valor = ClausulaValorCargo::where('cargo_id', $requerimiento->cargo_especifico_id)
                        ->where('adicional_id', $documentoCreado->idDocumento)
                        ->first();
                    }
                }

                $valor_variable = (empty($clausula_valor->valor)) ? '' : $clausula_valor->valor;

                $empresa_contrata_generador = EmpresaLogo::where('id', $requerimiento->empresa_contrata)->first();

                $salario_asignado_generador = "$".number_format($requerimiento->salario);

                $replace = [
                    $datos->fullname(),
                    $datos->nombres,
                    $datos->primer_apellido,
                    $datos->segundo_apellido,
                    $datos->numero_id,
                    $datos->direccion,
                    $datos->telefono_movil,
                    $fecha_firma_replace,
                    $fecha_ingreso_replace,
                    $replace_datos_clausula->cargo_ejerce,
                    $replace_datos_clausula->empresa_usuaria,
                    $tipo_documento,
                    $ciudad_oferta,
                    $ciudad_contrato,
                    $valor_variable,
                    $empresa_contrata_generador->nombre_empresa,
                    $salario_asignado_generador
                ];

                $nuevo_cuerpo = $this->search_and_replace($replace, $subject);

                return view("contratos.contrato_view.clausula_default", compact(
                    'documentoAsociados',
                    'user',
                    'candidato',
                    'contratoId',
                    'documentoCreado',
                    'documento',
                    'user_id',
                    'req_id',
                    'userId',
                    'userIdHash',
                    'firmaContratoHash',
                    'documentos_parametrizados_creado',
                    'documentos_parametrizados',
                    'adicional_medico',
                    'especificaciones',
                    'fecha',
                    'moduloHash',
                    'lugarexpedicion',
                    "requerimiento",
                    "nuevo_cuerpo",
                    "finAdicionales"
                ));
            }
        }

        //Si no hay documentos adicionales se guarda el contrato
        if ($documento == null || count($documentos_parametrizados) <= 0) {
            error_reporting(E_ALL ^ E_DEPRECATED);
            
            //Cambiar valor de bandera fin de los documentos adicionales
            $finAdicionales = true;

            if ($adicional_medico) {
                //Si tiene clausula medica
                if ($especificaciones != null) {
                    //Hay especificaciones, es decir, no ha firmado la clausula medica
                    $candidato = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
                    ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
                    ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
                    ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
                    ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
                    ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
                    ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
                    ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
                    ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
                    ->where("datos_basicos.user_id", $userId)
                    ->select(
                        "datos_basicos.*",
                        "tipo_identificacion.descripcion as dec_tipo_doc",
                        "generos.descripcion as genero_desc",
                        "estados_civiles.descripcion as estado_civil_des",
                        "aspiracion_salarial.descripcion as aspiracion_salarial_des",
                        "clases_libretas.descripcion as clases_libretas_des",
                        "tipos_vehiculos.descripcion as tipos_vehiculos_des",
                        "categorias_licencias.descripcion as categorias_licencias_des",
                        "entidades_afp.descripcion as entidades_afp_des",
                        "entidades_eps.descripcion as entidades_eps_des"
                    )
                    ->first();

                    $lugarexpedicion = Pais::join("departamentos", function ($join) {
                        $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                    })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                    })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais",$candidato->pais_id)
                    ->where("ciudad.cod_departamento",$candidato->departamento_expedicion_id)
                    ->where("ciudad.cod_ciudad",$candidato->ciudad_expedicion_id)
                    ->first();

                    /**
                     * Desactivar bandera para cláusula médica
                     */
                    $finAdicionales = false;

                    return view("contratos.contrato_view.clausula_default", compact(
                        'documentoAsociados',
                        'user',
                        'candidato',
                        'contratoId',
                        'documento',
                        'user_id',
                        'req_id',
                        'userId',
                        'userIdHash',
                        'firmaContratoHash',
                        'documentos_parametrizados',
                        'documentos_parametrizados_creado',
                        'documentoCreado',
                        'fecha',
                        'lugarexpedicion',
                        "requerimiento",
                        "adicional_medico",
                        "especificaciones",
                        "sitio",
                        "finAdicionales"
                    ));
                }
            }

            //Da por terminado el contrato pero sin videos, tipo 3
            $firmaContratoFin = FirmaContratos::where('id', $contratoId)->first();

            //Validar estado del contrato, para no recrear trazabilidad
            if ($firmaContratoFin->terminado != 3) {
                //Cambia estado del proceso del candidato
                $aptoProceso = RegistroProceso::where('requerimiento_id', $req_id)
                ->where('candidato_id', $userId)
                ->where('proceso', 'ENVIO_CONTRATACION')
                ->orderby('created_at', 'DESC')
                ->first();

                $aptoProceso->apto = 1;
                $aptoProceso->save();

                //Información para correo
                $usuario_envio = User::where('id', $aptoProceso->usuario_envio)->first();

                //Busca información para construir PDF
                $firmaContrato =  FirmaContratos::where('id', $contratoId)
                ->where('user_id', $userId)
                ->where('req_id', $req_id)
                ->first();

                $candidato = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
                ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
                ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
                ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
                ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
                ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
                ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
                ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
                ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
                ->where("datos_basicos.user_id", $userId)
                ->select(
                    "datos_basicos.*",
                    "tipo_identificacion.descripcion as dec_tipo_doc",
                    "generos.descripcion as genero_desc",
                    "estados_civiles.descripcion as estado_civil_des",
                    "aspiracion_salarial.descripcion as aspiracion_salarial_des",
                    "clases_libretas.descripcion as clases_libretas_des",
                    "tipos_vehiculos.descripcion as tipos_vehiculos_des",
                    "categorias_licencias.descripcion as categorias_licencias_des",
                    "entidades_afp.descripcion as entidades_afp_des",
                    "entidades_eps.descripcion as entidades_eps_des"
                )
                ->first();

                $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("tipos_salarios", "tipos_salarios.id", "=", "requerimientos.tipo_salario")
                ->join("tipos_liquidaciones", "tipos_liquidaciones.id", "=", "requerimientos.tipo_liquidacion")
                ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
                ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
                ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
                ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("tipos_nominas", "tipos_nominas.id", "=", "requerimientos.tipo_nomina")
                ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                ->join("departamentos", function ($join) {
                    $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                    ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                    ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                })
                ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
                ->select(
                    "cargos_especificos.descripcion",
                    "requerimientos.sitio_trabajo as sitio_trabajo",
                    "requerimiento_cantidato.created_at",
                    "requerimiento_cantidato.requerimiento_id",
                    "requerimiento_cantidato.id as requerimiento_cantidato_id",
                    "clientes.nombre as cliente_nombre",
                    "clientes.id as cliente_id",
                    "procesos_candidato_req.fecha_inicio_contrato",
                    "procesos_candidato_req.fecha_fin_contrato",
                    "procesos_candidato_req.codigo_validacion as token_acceso",
                    "requerimientos.salario as salario",
                    "requerimientos.funciones as funciones",
                    "requerimientos.empresa_contrata as empresa_contrata",
                    "cargos_genericos.descripcion as nombre_cargo",
                    "cargos_especificos.descripcion as nombre_cargo_especifico",
                    "requerimientos.cargo_especifico_id as cargo_req",
                    "tipos_nominas.descripcion as nomina_contrato",
                    "requerimientos.pais_id as cod_pais",
                    "requerimientos.departamento_id as cod_departamento",
                    "requerimientos.ciudad_id as cod_ciudad",
                    "requerimientos.num_vacantes as numero_vacantes",
                    "requerimientos.adicionales_salariales as adicionales_salariales",
                    "requerimientos.termino_inicial_contrato",
                    "tipos_salarios.descripcion as descripcion_tipo_salario",
                    "tipos_liquidaciones.descripcion as descripcion_tipo_liquidacion",
                    "agencias.descripcion as agencia",
                    "agencias.direccion as agencia_direccion",
                    "agencias.id as agencia_id",
                    "ciudad.nombre as nombre_ciudad",
                    "motivo_requerimiento.descripcion as motivo_requerimiento"
                )
                ->where("requerimiento_cantidato.candidato_id", $userId)
                ->where("requerimiento_cantidato.requerimiento_id", $req_id)
                ->where("procesos_candidato_req.proceso","ENVIO_CONTRATACION")
                ->groupBy('procesos_candidato_req.candidato_id')
                ->orderBy("requerimiento_cantidato.id", "DESC")
                ->first();

                $fechasContrato = RequerimientoContratoCandidato::leftJoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
                ->leftJoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
                ->where('requerimiento_id', $req_id)
                ->where('candidato_id', $userId)
                ->select(
                    'fecha_ingreso',
                    'fecha_fin_contrato',
                    'entidades_afp.descripcion as entidad_afp',
                    'entidades_eps.descripcion as entidad_eps'
                    )
                ->orderBy('requerimiento_contrato_candidato.created_at', 'DESC')
                ->first();

                if($reqcandidato->empresa_contrata) {
                    $empresa_contrata = EmpresaLogo::where('id', $reqcandidato->empresa_contrata)->first();
                }else {
                    $empresa_contrata = EmpresaLogo::where('id', 1)->first();
                }

                //Calcular edad de candidatos.
                $edad = ($candidato->fecha_nacimiento != 0 && $candidato->fecha_nacimiento != "") ? Carbon::parse($candidato->fecha_nacimiento)->age : "";

                $lugarnacimiento = null;
                $lugarexpedicion = null;
                $lugarresidencia = null;

                if($candidato != null) {
                    $lugarnacimiento = Pais::join("departamentos", function ($join) {
                        $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                    })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                    })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
                    ->where("ciudad.cod_pais",$candidato->pais_nacimiento)
                    ->where("ciudad.cod_departamento",$candidato->departamento_nacimiento)
                    ->where("ciudad.cod_ciudad", $candidato->ciudad_nacimiento)
                    ->first();

                    $lugarexpedicion = Pais::join("departamentos", function ($join) {
                        $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                    })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                    })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais",$candidato->pais_id)
                    ->where("ciudad.cod_departamento",$candidato->departamento_id)
                    ->where("ciudad.cod_ciudad",$candidato->ciudad_id)
                    ->first();

                    $lugarresidencia = Pais::join("departamentos", function ($join) {
                        $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                    })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                    })
                    ->select(\DB::raw("CONCAT(ciudad.nombre) AS value"))
                    ->where("ciudad.cod_pais",$candidato->pais_residencia)
                    ->where("ciudad.cod_departamento",$candidato->departamento_residencia)
                    ->where("ciudad.cod_ciudad", $candidato->ciudad_residencia)
                    ->first();
                }

                //Hash data
                $userIdHash = Crypt::encrypt($userId);
                if ($firmaContrato !== null) {
                    $firmaContratoHash = Crypt::encrypt($firmaContrato->id);   
                }

                $foto = null;
                if (Sentinel::check()) {
                    $registro = Sentinel::getUser();
                    if ($registro->foto_perfil == null) {
                        $foto = null;
                    } else {
                        $foto = $registro->foto_perfil;
                    }
                }

                //Agregar clausulas adicionales
                $adicionales = CargoDocumentoAdicional::join("confirmacion_documentos_adicionales", "confirmacion_documentos_adicionales.documento_id", "=", "cargos_documentos_adicionales.adicional_id")
                ->where("confirmacion_documentos_adicionales.externo", 0)
                ->where("cargo_id", $reqcandidato->cargo_req)
                ->where("contrato_id", $contratoId)
                ->select(
                    "confirmacion_documentos_adicionales.*",
                    "cargos_documentos_adicionales.*"
                )
                ->get();

                //Agregar clausulas creadas en la instancia
                $adicionales_creadas = CargoDocumentoAdicional::join("documentos_adicionales_contrato", "documentos_adicionales_contrato.id", "=", "cargos_documentos_adicionales.adicional_id")
                ->join("confirmacion_documentos_adicionales", "confirmacion_documentos_adicionales.documento_id", "=", "cargos_documentos_adicionales.adicional_id")
                ->where("documentos_adicionales_contrato.creada", 1)
                ->where("documentos_adicionales_contrato.active", 1)
                ->where("cargos_documentos_adicionales.active", 1)
                ->where("cargos_documentos_adicionales.cargo_id", $reqcandidato->cargo_req)
                ->where("confirmacion_documentos_adicionales.externo", 1)
                ->where("confirmacion_documentos_adicionales.contrato_id", $contratoId)
                ->select(
                    "confirmacion_documentos_adicionales.*",
                    "cargos_documentos_adicionales.*",
                    "documentos_adicionales_contrato.contenido_clausula as contenido_clausula",
                    "documentos_adicionales_contrato.opcion_firma"
                )
                ->get();

                $adicional_externo = null;
                $lugarexpedicion_medica = null;
                $requerimiento_candidato_orden_pdf = null;

                if ($sitio_modulo->clausula_medica == 'enabled') {
                    if ($sitio_modulo->salud_ocupacional == 'si') {
                        //Agregar documento medico
                        $requerimiento_candidato_orden_pdf = OrdenMedica::where('req_can_id', $reqcandidato->requerimiento_cantidato_id)
                        ->orderBy('created_at', 'DESC')
                        ->first();

                        //Cláusula medica
                        $adicional_externo = ConfirmacionDocumentosAdicionales::where("user_id", $userId)
                        ->where("contrato_id", $contratoId)
                        ->where("externo", 2)
                        ->orderBy('created_at', 'DESC')
                        ->first();

                        $lugarexpedicion_medica = Pais::join("departamentos", function ($join) {
                            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                        })->join("ciudad", function ($join2) {
                            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                        })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais",$candidato->pais_id)
                        ->where("ciudad.cod_departamento",$candidato->departamento_expedicion_id)
                        ->where("ciudad.cod_ciudad",$candidato->ciudad_expedicion_id)
                        ->first();
                    } else {
                        $documentos_medicos = Documentos::where('user_id', $userId)
                            ->where('requerimiento', $req_id)
                            ->where('tipo_documento_id', 8)
                            ->whereIn('resultado', [3,4])
                        ->get();

                        if (count($documentos_medicos) > 0) {
                            $adicional_externo = ConfirmacionDocumentosAdicionales::where("user_id", $userId)
                                ->where("contrato_id", $contratoId)
                                ->where("externo", 2)
                                ->orderBy('created_at', 'DESC')
                            ->first();
                            //Solo se instancia el objeto, no se guarda..
                            $requerimiento_candidato_orden_pdf = new OrdenMedica();
                            $requerimiento_candidato_orden_pdf->especificacion = '<ul>';
                            foreach ($documentos_medicos as $doc) {
                                $requerimiento_candidato_orden_pdf->especificacion .= "<li>$doc->observacion</li>";
                            }
                            $requerimiento_candidato_orden_pdf->especificacion .= '</ul>';

                            $lugarexpedicion_medica = Pais::join("departamentos", function ($join) {
                                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                            })->join("ciudad", function ($join2) {
                                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                            })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais",$candidato->pais_id)
                            ->where("ciudad.cod_departamento",$candidato->departamento_expedicion_id)
                            ->where("ciudad.cod_ciudad",$candidato->ciudad_expedicion_id)
                            ->first();
                        }
                    }
                }

                $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("cargos_especificos","cargos_especificos.clt_codigo","=","clientes.id")
                ->leftjoin("empresa_logos", "empresa_logos.id", "=", "requerimientos.empresa_contrata")
                ->where("requerimientos.id", $req_id)
                ->select(
                    "requerimientos.id as req_id",
                    "requerimientos.id",
                    "cargos_especificos.descripcion as cargo",
                    "clientes.nombre as nombre_cliente",
                    "clientes.nit as nit_cliente",
                    "requerimientos.negocio_id",
                    "requerimientos.empresa_contrata",
                    "requerimientos.salario",
                    "requerimientos.pais_id",
                    "requerimientos.departamento_id",
                    "requerimientos.ciudad_id",
                    "requerimientos.cargo_especifico_id as cargo_especifico_id",
                    "requerimientos.tipo_contrato_id as tipo_contrato_id",
                    "empresa_logos.*"
                )
                ->first();

                //Genera código unico universal para el contrato
                $codigo_unico = Uuid::generate();

                $user = User::find($userId);

                //Covertir a datos del candidado la cláusula
                    $dia = date('d');
                    $mes = date('n');
                    $ano = date('Y');
                    $fecha_firma_replace = "$dia de ".$this->meses[$mes]." de $ano";


                    $datos = DatosBasicos::where('user_id', $userId)->first();

                    $fecha_ingreso_replace = RequerimientoContratoCandidato::where('requerimiento_id', $req_id)
                    ->where('candidato_id', $userId)
                    ->select('fecha_ingreso', 'fecha_fin_contrato')
                    ->orderBy('created_at', 'DESC')
                    ->first();

                    $fecha_ingreso_replace = explode("-", $fecha_ingreso_replace->fecha_ingreso);

                    $dia_ingreso = $fecha_ingreso_replace[2];
                    $mes_ingreso = (int)$fecha_ingreso_replace[1];
                    $año_ingreso = $fecha_ingreso_replace[0];

                    $fecha_ingreso_replace = "$dia_ingreso de ".$this->meses[$mes_ingreso]." de $año_ingreso";

                    $replace_datos_clausula = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                    ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
                    ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                    ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                    ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                    ->select(
                        "cargos_especificos.descripcion as cargo_ejerce",
                        "clientes.nombre as empresa_usuaria"
                    )
                    ->where("requerimiento_cantidato.candidato_id", $userId)
                    ->where("requerimiento_cantidato.requerimiento_id", $req_id)
                    ->where("procesos_candidato_req.proceso", "ENVIO_CONTRATACION")
                    ->groupBy('procesos_candidato_req.candidato_id')
                    ->orderBy("requerimiento_cantidato.id", "DESC")
                    ->first();

                    $tipo_documento = mb_strtolower($datos->getTipoIdentificacion->descripcion);

                    //Para reemplazar las banderas de ciudades del generador
                    $ciudades_clausula = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                    ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
                    ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                    ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                    ->join("departamentos", function ($join) {
                        $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                        ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                    })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                        ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                        ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                    })
                    ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
                    ->select(
                        "ciudad.nombre as sitio_trabajo",
                        //"requerimientos.sitio_trabajo as sitio_trabajo",
                        "agencias.descripcion as agencia"
                    )
                    ->where("requerimiento_cantidato.candidato_id", $userId)
                    ->where("requerimiento_cantidato.requerimiento_id", $req_id)
                    ->where("procesos_candidato_req.proceso", "ENVIO_CONTRATACION")
                    ->groupBy('procesos_candidato_req.candidato_id')
                    ->orderBy("requerimiento_cantidato.id", "DESC")
                    ->first();

                    $ciudad_oferta = $ciudades_clausula->sitio_trabajo;
                    $ciudad_contrato = $ciudades_clausula->agencia;

                    $empresa_contrata_generador = EmpresaLogo::where('id', $requerimiento->empresa_contrata)->first();

                    $salario_asignado_generador = "$".number_format($requerimiento->salario);

                    $replace = [
                        $datos->fullname(),
                        $datos->nombres,
                        $datos->primer_apellido,
                        $datos->segundo_apellido,
                        $datos->numero_id,
                        $datos->direccion,
                        $datos->telefono_movil,
                        $fecha_firma_replace,
                        $fecha_ingreso_replace,
                        $replace_datos_clausula->cargo_ejerce,
                        $replace_datos_clausula->empresa_usuaria,
                        $tipo_documento,
                        $ciudad_oferta,
                        $ciudad_contrato,
                        $empresa_contrata_generador->nombre_empresa,
                        $salario_asignado_generador
                    ];
                //Fin

                // Agregar fotos al contrato
                    $contrato_fotos = FirmaContratoFoto::where('contrato_id', $firmaContrato->id)->orderBy('id', 'DESC')->get();
                    // \Log::debug(json_encode($contrato_fotos));

                    $validate_pictures = true;
                //

                if (count($contrato_fotos) > 0) {
                    //Da por terminado el contrato pero sin videos, tipo 3
                    $firmaContratoFin->terminado = 3;
                    $firmaContratoFin->save();

                    if($sitio->multiple_empresa_contrato) {
                        $cuerpo_contrato=DB::table('empresa_tipo_contrato')
                        ->where("empresa_id", $empresa_contrata->id)
                        ->where('tipo_contrato_id', $requerimiento->tipo_contrato_id)
                        ->first();

                        $tipo_contrato = TipoContrato::find($requerimiento->tipo_contrato_id);

                        if ($candidato != null && $tipo_contrato != null && $tipo_contrato->id == 5) {
                            $req_contrato_candidato = RequerimientoContratoCandidato::join("bancos", "bancos.id", "=", "requerimiento_contrato_candidato.nombre_banco")
                            ->select('requerimiento_contrato_candidato.tipo_cuenta',
                            'requerimiento_contrato_candidato.numero_cuenta',
                            'bancos.nombre_banco as banco')
                            ->where("candidato_id", $userId)
                            ->where("requerimiento_id", $requerimiento->id)
                            ->first();
                        }else {
                            $req_contrato_candidato = null;
                        }

                        $meses = $this->meses;
                        $dias_semana = $this->dias_semana;

                        $view = \SnappyPDF::loadView("contratos.pdf.".$tipo_contrato->modelo_contrato,[
                            'userId'=>$userId,
                            'req_id'=>$req_id,
                            'candidato'=>$candidato,
                            'firmaContrato'=>$firmaContrato,
                            'lugarnacimiento'=>$lugarnacimiento,
                            'lugarexpedicion'=>$lugarexpedicion,
                            'lugarresidencia'=>$lugarresidencia,
                            'reqcandidato'=>$reqcandidato,
                            'userIdHash'=>$userIdHash,
                            'firmaContratoHash'=>$firmaContratoHash,
                            'fecha'=>$fecha,
                            'empresa_contrata'=>$empresa_contrata,
                            'user'=>$user,
                            'requerimiento'=>$requerimiento,
                            'adicionales'=>$adicionales,
                            'foto'=>$foto,
                            'fechasContrato'=>$fechasContrato,
                            'codigo_unico'=>$codigo_unico,
                            'adicionales_creadas'=>$adicionales_creadas,
                            'replace'=>$replace,
                            'sitio'=>$sitio,
                            'datos'=>$datos,
                            'cuerpo_contrato'=>$cuerpo_contrato,
                            'req_contrato_candidato'=>$req_contrato_candidato,
                            'requerimiento_candidato_orden_pdf'=>$requerimiento_candidato_orden_pdf,
                            'adicional_externo'=>$adicional_externo,
                            'lugarexpedicion_medica'=>$lugarexpedicion_medica,
                            'meses'=>$meses,
                            'dias_semana'=>$dias_semana,
                            'edad'=>$edad,
                            'contrato_fotos'=>$contrato_fotos
                        ])
                        ->output();
                    }else {
                        $view = \SnappyPDF::loadView("home.pdf-contrato-firmar",[
                            'userId'=>$userId,
                            'req_id'=>$req_id,
                            'candidato'=>$candidato,
                            'firmaContrato'=>$firmaContrato,
                            'lugarnacimiento'=>$lugarnacimiento,
                            'lugarexpedicion'=>$lugarexpedicion,
                            'lugarresidencia'=>$lugarresidencia,
                            'reqcandidato'=>$reqcandidato,
                            'userIdHash'=>$userIdHash,
                            'firmaContratoHash'=>$firmaContratoHash,
                            'fecha'=>$fecha,
                            'empresa_contrata'=>$empresa_contrata,
                            'user'=>$user,
                            'requerimiento'=>$requerimiento,
                            'adicionales'=>$adicionales,
                            'foto'=>$foto,
                            'fechasContrato'=>$fechasContrato,
                            'codigo_unico'=>$codigo_unico,
                            'adicionales_creadas'=>$adicionales_creadas,
                            'requerimiento_candidato_orden_pdf'=>$requerimiento_candidato_orden_pdf,
                            'adicional_externo'=>$adicional_externo,
                            'lugarexpedicion_medica'=>$lugarexpedicion_medica,
                            'replace'=>$replace,
                            'sitio'=>$sitio,
                            'datos'=>$datos,
                            'contrato_fotos'=>$contrato_fotos
                        ])
                        ->output();
                    }

                    //Guarda contrato
                    $nombre_documento = 'contrato_'.$req_id.'_'.$userId.'.pdf';

                    //Actualiza registro de firma
                    $firmaContrato->contrato = $nombre_documento;
                    $firmaContrato->base_64 = base64_encode($view);
                    $firmaContrato->uuid = $codigo_unico;

                    Storage::disk('public')->put('contratos/'.$nombre_documento,$view);

                    //file_put_contents('contratos/'.$nombre_documento, $output);
                    $firmaContrato->hash = hash_file('sha256','contratos/'.$nombre_documento);
                    $firmaContrato->save();

                    //Crea el documento
                    $documentos = new Documentos();
                    $documentos->fill([
                        "numero_id" => $candidato->numero_id,
                        "user_id" => $userId,
                        "tipo_documento_id" => 16,
                        "nombre_archivo" => $nombre_documento,
                        "gestiono" => $userId,
                        "requerimiento" => $req_id,
                        "descripcion_archivo" => 'Contrato firmado virtualmente, sin vídeos.',
                    ]);
                    $documentos->save();

                    //SE CREA TRAZABILIDAD
                    $nuevo_estado = ReqCandidato::where("requerimiento_id",$req_id)
                    ->where("candidato_id",$userId)
                    ->orderBy("id","DESC")
                    ->first();

                    $nuevo_estado->estado_candidato = 12;
                    $nuevo_estado->estado_contratacion = 0;
                    $date = Carbon::now();
                    $nuevo_estado->fecha_tentativa_cierre_contratacion=$date->addWeekdays(15)->toDateString();
                    $nuevo_estado->save();

                    //Crea proceso de firma sin videos
                    $nuevo_proceso = new RegistroProceso();
                    $nuevo_proceso->fill([
                        'requerimiento_candidato_id' => $nuevo_estado->id,
                        'estado'                     => config('conf_aplicacion.C_CONTRATADO'),
                        'fecha_inicio'               => date("Y-m-d H:i:s"),
                        'usuario_envio'              => $userId,
                        'requerimiento_id'           => $req_id,
                        'candidato_id'               => $userId,
                        'observaciones'              => "Contrato firmado virtualmente, sin vídeos.",
                        'proceso'                    => "FIRMA_VIRTUAL_SIN_VIDEOS",
                        'apto'                       => 1
                    ]);
                    $nuevo_proceso->save();

                    //Event::dispatch(new \App\Events\CloseSelectionFolderEvent($nuevo_estado));

                    //Termina requerimiento si se completan las vacantes
                    $numero_vacantes = $reqcandidato->numero_vacantes;

                    $cuenta_contratos_firmados = FirmaContratos::where('req_id', $req_id)
                    ->whereIn('terminado', [1, 2, 3])
                    ->count();

                    //No volver a guardar fotos
                    $validate_pictures = false;
                }else{

                }
            }else {
                //Para validación en vista
                $validate_pictures = false;
            }
        }

        return view("contratos.contrato_view.clausula_default", compact(
            'documentoAsociados',
            'user',
            'candidato',
            'contratoId',
            'documento',
            'user_id',
            'req_id',
            'userId',
            'userIdHash',
            'firmaContratoHash',
            'documentos_parametrizados',
            'documentos_parametrizados_creado',
            'moduloHash',
            'documentoCreado',
            'adicional_medico',
            'especificaciones',
            'fecha',
            'lugarexpedicion',
            "requerimiento",
            "sitio",
            "finAdicionales",
            "validate_pictures"
        ));
    }

    /*
    *   Guardar firma del contrato realizado por el candidato
    */
    public function guardarFirma(Request $data)
    {
        //Decrypt URL data
        $userId = Crypt::decrypt($data->user_id);
        $ReqId = Crypt::decrypt($data->req_id);

        $ip = $data->ip();
        $firmaText = $data->firma;

        $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
        ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
        ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->select(
            "cargos_especificos.descripcion",
            "requerimientos.sitio_trabajo as sitio_trabajo",
            "requerimientos.tipo_proceso_id",
            "requerimiento_cantidato.created_at",
            "requerimiento_cantidato.requerimiento_id",
            "requerimiento_cantidato.id as requerimiento_cantidato_id",
            "clientes.nombre as cliente_nombre",
            "procesos_candidato_req.fecha_inicio_contrato",
            "procesos_candidato_req.fecha_fin_contrato",
            "requerimientos.salario as salario",
            "cargos_genericos.descripcion as nombre_cargo",
            "cargos_especificos.descripcion as nombre_cargo_especifico",
            "cargos_especificos.id as cargo_id",
            "motivo_requerimiento.descripcion as motivo_requerimiento"
        )
        ->where("requerimiento_cantidato.candidato_id", $userId)
        ->where('requerimientos.id',$ReqId)
        ->orderBy("requerimiento_cantidato.id", "DESC")
        ->first();

        //Busca registro de firma
        $firma = FirmaContratos::where('user_id', $userId)
        ->where('req_id', $ReqId)
        ->orderBy('created_at', 'DESC')
        ->first();

        $sitio = Sitio::first();

        if ($reqcandidato->tipo_proceso_id == $sitio->id_proceso_sitio) {
            $usuario_id = $userId;
            $grupo_preguntas = 2;
        } else {
            $usuario_id = $this->user->id;
            $grupo_preguntas = 1;
        }

        if($firma != null || $firma != ''){
            //Valida si el contrato ya esta terminado, cancelado o anulado
            if($firma->terminado === 0 || $firma->terminado === 1 || $firma->terminado === 2 || $firma->terminado === 3){
                return response()->json(["success" => false]);
            }else{
                //Actualiza firma de contrato
                $firma->firma = $firmaText;
                $firma->ip = $ip;
                $firma->save();
            }
        }else{
            $requerimiento_contrato_candidato = RequerimientoContratoCandidato::where('requerimiento_candidato_id', $reqcandidato->requerimiento_cantidato_id)
                ->orderBy("id","DESC")
                ->select('id')
            ->first();

            //Crea registro de firma de contrato
            $firma = new FirmaContratos();

            $firma->fill([
                'user_id' => $usuario_id,
                'req_id'  => $ReqId,
                'firma'   => $firmaText,
                'estado'  => 1,
                'ip'      => $ip,
                'gestion' => $usuario_id,
                'req_contrato_cand_id'  => $requerimiento_contrato_candidato->id
            ]);
            $firma->save();
        }
        //Crear confirmación de preguntas
        $getQuestions = PreguntasContrato::where('grupo', $grupo_preguntas)->orderBy('orden', 'ASC')->get();

        foreach ($getQuestions as $asignQuestion) {
            ConfirmacionPreguntaContrato::create([
                'user_id'     => $usuario_id,
                'req_id'      => $ReqId,
                'contrato_id' => $firma->id,
                'pregunta_id' => $asignQuestion->id,
                'video'       => null,
                'estado'      => 0,
            ]);
        }

        //Crear confirmación de documentos
        $getDocumentos = CargoDocumentoAdicional::join("documentos_adicionales_contrato","documentos_adicionales_contrato.id", "=", "cargos_documentos_adicionales.adicional_id")
        ->where("cargo_id", $reqcandidato->cargo_id)
        ->where("documentos_adicionales_contrato.creada", 0)
        ->orderBy('documentos_adicionales_contrato.id', 'ASC')
        ->get();

        if($getDocumentos->count() > 0){
            foreach ($getDocumentos as $asignDocumentos) {
                ConfirmacionDocumentosAdicionales::create([
                    'user_id' => $usuario_id,
                    'requerimiento_id'  => $ReqId,
                    'contrato_id' => $firma->id,
                    'documento_id' => $asignDocumentos->id,
                    'firma' => null
                ]);
            }
        }

        //Crear confirmación de documentos creados
        $getDocumentosCreados = CargoDocumentoAdicional::join("documentos_adicionales_contrato", "documentos_adicionales_contrato.id", "=", "cargos_documentos_adicionales.adicional_id")
        ->where("cargos_documentos_adicionales.cargo_id", $reqcandidato->cargo_id)
        ->where("cargos_documentos_adicionales.active", 1)
        ->where("documentos_adicionales_contrato.active", 1)
        ->where("documentos_adicionales_contrato.creada", 1)
        ->orderBy("documentos_adicionales_contrato.id", "ASC")
        ->get();

        if($getDocumentosCreados->count() > 0){
            foreach ($getDocumentosCreados as $asignDocumentosCreados) {
                ConfirmacionDocumentosAdicionales::create([
                    'user_id' => $usuario_id,
                    'requerimiento_id'  => $ReqId,
                    'contrato_id' => $firma->id,
                    'documento_id' => $asignDocumentosCreados->id,
                    'firma' => null,
                    'externo' => 1
                ]);
            }
        }

        return response()->json(["success" => true]);
    }

    /*
    *   Guardar firma adicional de cláusulas
    */
    public function guardarFirmaAdicional(Request $data)
    {
        error_reporting(E_ALL ^ E_DEPRECATED);

        try {
            $userId = Crypt::decrypt($data->user_id);
            $usuario_id = $userId;
        } catch (\Exception $e) {
            logger('Error ContratacionVirtualController@guardarFirmaAdicional no se pudo desencriptar el user_id ' . $data->user_id);
            $usuario_id = $this->user->id;
        }

        if($data->has('recomendaciones')){
            $sitio_modulo = SitioModulo::first();

            $contrato_id = $data->contrato_id;
            $firma_contrato = FirmaContratos::find($contrato_id);

            //Validar si el candidato tiene examenes médicos con observaciones
            $requerimiento_candidato = ReqCandidato::where('requerimiento_id', $firma_contrato->req_id)
            ->where('candidato_id', $usuario_id)
            ->where('estado_candidato', 11)
            ->orderBy('created_at', 'DESC')
            ->first();

            if ($sitio_modulo->salud_ocupacional == 'si') {
                $requerimiento_candidato_orden = OrdenMedica::where('req_can_id', $requerimiento_candidato->id)
                ->orderBy('created_at', 'DESC')
                ->first();

                //Actualiza el estado de la firma en la orden
                $requerimiento_candidato_orden->aceptada = 1;
                $requerimiento_candidato_orden->save();
            } else {
                $documentos_medicos = Documentos::where('user_id', $usuario_id)
                    ->where('requerimiento', $firma_contrato->req_id)
                    ->where('tipo_documento_id', 8)
                    ->whereIn('resultado', [3,4])
                    ->whereNull('aceptada')
                ->get();

                foreach ($documentos_medicos as $doc) {
                    $doc->aceptada = 1;
                    $doc->save();
                }
            }

            $dia = date('d');
            $mes = date('n');
            $ano = date('Y');
            $fecha = "$dia de ".$this->meses[$mes]." de $ano";

            $recomendaciones = $data->get('recomendaciones');
            $user = User::where('id', $usuario_id)->first();

            $firma = $data->firma;

            $candidato = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
            ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
            ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
            ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
            ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->where("datos_basicos.user_id", $usuario_id)
            ->select(
                "datos_basicos.*",
                "tipo_identificacion.descripcion as dec_tipo_doc",
                "generos.descripcion as genero_desc",
                "estados_civiles.descripcion as estado_civil_des",
                "aspiracion_salarial.descripcion as aspiracion_salarial_des",
                "clases_libretas.descripcion as clases_libretas_des",
                "tipos_vehiculos.descripcion as tipos_vehiculos_des",
                "categorias_licencias.descripcion as categorias_licencias_des",
                "entidades_afp.descripcion as entidades_afp_des",
                "entidades_eps.descripcion as entidades_eps_des"
            )
            ->first();

            $lugarexpedicion = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")
                ->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $candidato->pais_id)
            ->where("ciudad.cod_departamento", $candidato->departamento_expedicion_id)
            ->where("ciudad.cod_ciudad", $candidato->ciudad_expedicion_id)
            ->first();

            $vista = "home.include.adicionales.documento_medico_recomendaciones";

            $datos = DatosBasicos::where('user_id', $usuario_id)->first();

            $requerimiento = Requerimiento::where('id', $firma_contrato->req_id)->first();

            //para habilitar el logo en el PDF
            $isPDF = true;

            $view = \SnappyPDF::loadView($vista, compact(
                "firma",
                "fecha",
                "user",
                "requerimiento",
                "lugarexpedicion",
                "recomendaciones",
                "candidato",
                "isPDF"
            ))->output();

            //file_put_contents('contratos/'.$nombre_documento, $output);
            $nombre_documento = $data->req_id.'_'.$usuario_id.'_adicional_recomendaciones.pdf';

            Storage::disk('public')->put('contratos/'.$nombre_documento,$view);

            $documentos = new Documentos();
            $documentos->fill([
                'numero_id' => $candidato->numero_id,
                'user_id' => $usuario_id,
                'tipo_documento_id' => 1,
                'nombre_archivo' => $nombre_documento,
                'descripcion_archivo' => 'Documento de aceptación de recomendaciones médicas.',
                'active' => 1,
                'requerimiento' => $firma_contrato->req_id,
                'gestiono' => $this->user->id
            ]);
            $documentos->save();

            $documento_adicional = new ConfirmacionDocumentosAdicionales();
            $documento_adicional->fill([
                'user_id' => $usuario_id,
                'requerimiento_id'  => $firma_contrato->req_id,
                'contrato_id' => $firma_contrato->id,
                'firma' => $data->firma,
                'documento_firmado' => $nombre_documento,
                'externo' => 2,
                'ip' => $data->ip(),
                'estado' => 1
            ]);
            $documento_adicional->save();

            return response()->json(["success" => true]);
        }else{
            $contrato_id = $data->contrato_id;
            $documento_id = $data->documento_id;
            $firma = $data->firma;
            $ip = $data->ip();

            $documento = ConfirmacionDocumentosAdicionales::where('user_id', $usuario_id)
            ->where('documento_id', $documento_id)
            ->where('contrato_id', $contrato_id)
            ->where('estado', 0)
            ->first();

            $user = User::where('id', $usuario_id)->first();

            $firma_contrato = FirmaContratos::find($contrato_id);

            $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("cargos_especificos", "cargos_especificos.clt_codigo", "=", "clientes.id")
            ->leftjoin("empresa_logos", "empresa_logos.id", "=", "requerimientos.empresa_contrata")
            ->where("requerimientos.id", $firma_contrato->req_id)
            ->select(
                "requerimientos.id as req_id",
                "cargos_especificos.descripcion as cargo",
                "clientes.nombre as nombre_cliente",
                "clientes.nit as nit_cliente",
                "requerimientos.id",
                "requerimientos.negocio_id",
                "requerimientos.empresa_contrata",
                "requerimientos.salario",
                "requerimientos.cargo_especifico_id as cargo_especifico_id",
                "empresa_logos.*",
                "empresa_logos.id as empresa_contrata"
            )
            ->first();

            $candidato = DatosBasicos::where("user_id", $firma_contrato->user_id)->first();

            $lugarexpedicion = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais",$candidato->pais_id)
            ->where("ciudad.cod_departamento",$candidato->departamento_id)
            ->where("ciudad.cod_ciudad",$candidato->ciudad_id)
            ->first();

            $dia = date('d');
            $mes = date('n');
            $ano = date('Y');
            $fecha = "$dia de ".$this->meses[$mes]." de $ano";

            $datos = DatosBasicos::where('user_id', $usuario_id)->first();

            //Valida si la cláusula es generada
            if($data->has('creada')) {
                //Cambio de banderas por información candidato
                $fecha_firma_replace = "$dia de ".$this->meses[$mes]." de $ano";

                $subject = $data->nuevo_cuerpo;

                //
                $documento_adicional_creada = DocumentoAdicional::where('id', $documento_id)->first();
                $opcion_firma = $documento_adicional_creada->opcion_firma;

                $fecha_ingreso_replace = RequerimientoContratoCandidato::where('requerimiento_id', $firma_contrato->req_id)
                ->where('candidato_id', $usuario_id)
                ->select('fecha_ingreso', 'fecha_fin_contrato')
                ->orderBy('created_at', 'DESC')
                ->first();

                $fecha_ingreso_replace = explode("-", $fecha_ingreso_replace->fecha_ingreso);

                $dia_ingreso = $fecha_ingreso_replace[2];
                $mes_ingreso = (int)$fecha_ingreso_replace[1];
                $año_ingreso = $fecha_ingreso_replace[0];

                $fecha_ingreso_replace = "$dia_ingreso de ".$this->meses[$mes_ingreso]." de $año_ingreso";

                $replace_datos_clausula = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->select(
                    "cargos_especificos.descripcion as cargo_ejerce",
                    "clientes.nombre as empresa_usuaria"
                )
                ->where("requerimiento_cantidato.candidato_id", $usuario_id)
                ->where("requerimiento_cantidato.requerimiento_id", $firma_contrato->req_id)
                ->where("procesos_candidato_req.proceso", "ENVIO_CONTRATACION")
                ->groupBy('procesos_candidato_req.candidato_id')
                ->orderBy("requerimiento_cantidato.id", "DESC")
                ->first();

                $tipo_documento = mb_strtolower($datos->getTipoIdentificacion->descripcion);

                //Para reemplazar las banderas de ciudades del generador
                $ciudades_clausula = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                ->join("departamentos", function ($join) {
                    $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                    ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                    ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                })
                ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
                ->select(
                    "ciudad.nombre as sitio_trabajo",
                    //"requerimientos.sitio_trabajo as sitio_trabajo",
                    "agencias.descripcion as agencia"
                )
                ->where("requerimiento_cantidato.candidato_id", $usuario_id)
                ->where("requerimiento_cantidato.requerimiento_id", $firma_contrato->req_id)
                ->where("procesos_candidato_req.proceso", "ENVIO_CONTRATACION")
                ->groupBy('procesos_candidato_req.candidato_id')
                ->orderBy("requerimiento_cantidato.id", "DESC")
                ->first();

                $ciudad_oferta = $ciudades_clausula->sitio_trabajo;
                $ciudad_contrato = $ciudades_clausula->agencia;

                $sitioModulo = SitioModulo::first();
                if ($sitioModulo->generador_variable == 'enabled') {
                    $clausula_valor = ClausulaValorCandidato::where('user_id', $usuario_id)
                    ->where('req_id', $firma_contrato->req_id)
                    ->where('adicional_id', $documento_id)
                    ->first();

                    //Si no tiene en candidato pasa al req
                    if (empty($clausula_valor)) {
                        $clausula_valor = ClausulaValorRequerimiento::where('req_id', $firma_contrato->req_id)
                        ->where('adicional_id', $documento_id)
                        ->first();
                    }
                }else {
                    $clausula_valor = ClausulaValorRequerimiento::where('req_id', $firma_contrato->req_id)
                    ->where('adicional_id', $documento_id)
                    ->first();

                    if (empty($clausula_valor)) {
                        $clausula_valor = ClausulaValorCargo::where('cargo_id', $requerimiento->cargo_especifico_id)
                        ->where('adicional_id', $documento_id)
                        ->first();
                    }
                }

                $valor_variable = (empty($clausula_valor->valor)) ? '' : $clausula_valor->valor;

                $empresa_contrata_generador = EmpresaLogo::where('id', $requerimiento->empresa_contrata)->first();

                $salario_asignado_generador = "$".number_format($requerimiento->salario);

                $replace = [
                    $datos->fullname(),
                    $datos->nombres,
                    $datos->primer_apellido,
                    $datos->segundo_apellido,
                    $datos->numero_id,
                    $datos->direccion,
                    $datos->telefono_movil,
                    $fecha_firma_replace,
                    $fecha_ingreso_replace,
                    $replace_datos_clausula->cargo_ejerce,
                    $replace_datos_clausula->empresa_usuaria,
                    $tipo_documento,
                    $ciudad_oferta,
                    $ciudad_contrato,
                    $valor_variable,
                    $empresa_contrata_generador->nombre_empresa,
                    $salario_asignado_generador
                ];

                $nuevo_cuerpo = $this->search_and_replace($replace, $subject);

                $vista = "admin.clausulas.template.layout";

                $logo_empresa_contrata = EmpresaLogo::where('id', $requerimiento->empresa_contrata)->first();

                $empresa_contrata = $logo_empresa_contrata;

                $view = \SnappyPDF::loadView($vista, ["firma" => $firma, "fecha" => $fecha, "user" => $user, "requerimiento" => $requerimiento, "lugarexpedicion" => $lugarexpedicion, "nuevo_cuerpo" => $nuevo_cuerpo, "candidato" => $candidato, "empresa_contrata" => $empresa_contrata, "datos" => $datos, "opcion_firma" => $opcion_firma])->output();
            }else {
                $vista = "home.include.adicionales.documento_".$documento->documento_id;

                //$view = \View::make($vista, compact("firma", "fecha", "user", "requerimiento", "lugarexpedicion"))->render();
                $view = \SnappyPDF::loadView($vista, ["firma" => $firma, "fecha" => $fecha, "user" => $user, "requerimiento" => $requerimiento, "lugarexpedicion" => $lugarexpedicion])->output();
            }

            $nombre_documento = $data->req_id.'_'.$usuario_id.'_adicional'.$documento->documento_id.'.pdf';

            Storage::disk('public')->put('contratos/'.$nombre_documento,$view);

            //Guarda nombre en campo
            $documento->firma = $firma;
            $documento->estado = 1;
            $documento->ip = $ip;
            $documento->documento_firmado = $nombre_documento;
            $documento->save();

            return response()->json(["success" => true]);
        }
    }

    /*
    *   Confirmación de video preguntas (Vista)
    */
    public function confirmar_contratacion_video($user_id, $contrato_id, $modulo = 'modulo_cv')
    {
        if(empty($this->user->id)){
            return redirect()->route('login', ['record' => 'true', 'sr' => $user_id, 'ct' => $contrato_id]);
        }

        $userId = Crypt::decrypt($user_id);
        $contratoId = Crypt::decrypt($contrato_id);
        $sitio = Sitio::first();

        $checkContrato = FirmaContratos::where('id', $contratoId)
        ->where('user_id', $userId)
        ->where('estado', 1)
        ->whereIn('terminado', [1, 2])
        ->orderBy('created_at', 'DESC')
        ->first();

        if ($modulo == 'modulo_cv') {
            if($userId != $this->user->id){
                return redirect()->route('home');
            }else if(count($checkContrato) > 0){
                return redirect()->route('dashboard');
            }
        } else {
            //modulo_admin
            if(count($checkContrato)){
                return redirect()->route('notfound');
            }

            try {
                $modulo = Crypt::decrypt($modulo);
            } catch (\Exception $e) {
                $modulo = 'modulo_admin';
            }
        }

        $getContrato = FirmaContratos::where('id', $contratoId)
        ->where('user_id', $userId)
        ->orderBy('created_at', 'DESC')
        ->first();

        $reqId = $getContrato->req_id;

        $user = User::where('id', $userId)->first();
        $candidato = DatosBasicos::where("user_id", $user->id)->first();

        $question = ConfirmacionPreguntaContrato::join('preguntas_contrato', 'preguntas_contrato.id', '=', 'confirmacion_preguntas_contrato.pregunta_id')
        ->where('confirmacion_preguntas_contrato.user_id', $userId)
        ->where('confirmacion_preguntas_contrato.contrato_id', $contratoId)
        ->where('confirmacion_preguntas_contrato.estado', 0)
        ->select(
            'confirmacion_preguntas_contrato.*',
            'preguntas_contrato.*',
            'preguntas_contrato.id as idPregunta'
        )
        ->orderBy('preguntas_contrato.orden', 'ASC')
        ->first();

        $cantidad_preguntas = ConfirmacionPreguntaContrato::where('confirmacion_preguntas_contrato.user_id', $userId)
            ->where('confirmacion_preguntas_contrato.contrato_id', $contratoId)
            ->select('confirmacion_preguntas_contrato.*')
        ->count();

        return view("home.contratacion_video", compact(
            'user',
            'candidato',
            'contratoId',
            'cantidad_preguntas',
            'reqId',
            'userId',
            'user_id',
            'contrato_id',
            'question',
            'sitio',
            'modulo'
        ));
    }

    //confirmacion sin video de contratación
    public function confirmar_sin_video($user_id,$contrato_id)
    {
        if(empty($this->user->id)){
            return redirect()->route('login', ['record' => 'true', 'sr' => $user_id, 'ct' => $contrato_id]);
        }

        $userId = Crypt::decrypt($user_id);
        $contratoId = Crypt::decrypt($contrato_id);

        $checkContrato = FirmaContratos::where('id', $contratoId)
        ->where('user_id', $userId)
        ->where('estado', 1)
        ->whereIn('terminado', [1, 2])
        ->orderBy('created_at', 'DESC')
        ->first();

        if($userId != $this->user->id){
            return redirect()->route('home');
        }else if(count($checkContrato)){
            return redirect()->route('dashboard');
        }

        $getContrato = FirmaContratos::where('id', $contratoId)
        ->where('user_id', $userId)
        ->orderBy('created_at', 'DESC')
        ->first();

        $user = User::where('id', $this->user->id)->first();
        $candidato = DatosBasicos::where("user_id", $user->id)->first();

        $question = ConfirmacionPreguntaContrato::join('preguntas_contrato', 'preguntas_contrato.id', '=', 'confirmacion_preguntas_contrato.pregunta_id')
        ->where('confirmacion_preguntas_contrato.user_id', $userId)
        ->where('confirmacion_preguntas_contrato.contrato_id', $contratoId)
        ->where('confirmacion_preguntas_contrato.estado', 0)
        ->select(
            'confirmacion_preguntas_contrato.*',
            'preguntas_contrato.*',
            'preguntas_contrato.id as idPregunta'
        )
        ->orderBy('preguntas_contrato.orden', 'ASC')
        ->first();

        $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join("cargos_especificos", "cargos_especificos.clt_codigo", "=", "clientes.id")
        ->leftjoin("empresa_logos", "empresa_logos.id", "=", "requerimientos.empresa_contrata")
        ->where("requerimientos.id",$question->req_id)
        ->select(
            "requerimientos.id as req_id",
            "cargos_especificos.descripcion as cargo",
            "clientes.nombre as nombre_cliente",
            "clientes.nit as nit_cliente",
            "requerimientos.id",
            "requerimientos.negocio_id",
            "requerimientos.cargo_especifico_id as cargo_especifico_id",
            "empresa_logos.*"
        )
        ->first();

        $empresa_contrata = '';

        $reqId = $question->req_id;

        return view("home.confirmacion_manual", compact(
            'user',
            'candidato',
            'contratoId',
            'reqId',
            'empresa_contrata',
            'requerimiento',
            'userId',
            'question'
        ));
    }

    /*
    *   Guarda el contrato con videos en ultima pregunta
    */
    public function guardar_confirmacion_contratacion(Request $data)
    {
        $contrato_id = $data->contrato_id;
        $pregunta_id = $data->pregunta_id;
        $user_id = $data->user_id;

        $nro_pregunta = $data->nro_pregunta;
        $cantidad_preguntas = $data->cantidad_preguntas;
        $sitio = Sitio::first();
        $sitioModulo = SitioModulo::first();

        $question = ConfirmacionPreguntaContrato::where('user_id', $user_id)
        ->where('pregunta_id', $pregunta_id)
        ->where('contrato_id', $contrato_id)
        ->where('estado', 0)
        ->first();

        //Guarda video
        $archivo = $data->file('video');
        $fileName = "video_contrato_" .$contrato_id. "_pregunta_" .$pregunta_id. ".webm"; //mp4

        //Si existe lo elimina y crea uno nuevo
        if ($question->video != null) {
            if(file_exists("video_contratos/".$question->video)){
                unlink("video_contratos/".$question->video);
            }
        }

        //Guarda nombre en campo
        $question->video = $fileName;
        $question->estado = 1;
        $question->save();

        //Lo mueve a la carpeta
        $data->file('video')->move("video_contratos", $fileName);

        //Si es la ultima pregunta, actualiza registro de firma
        if ($nro_pregunta == $cantidad_preguntas) {
            //Para versiones más recientes de PHP > 7.2
            error_reporting(E_ALL ^ E_DEPRECATED);

            $ReqId = $question->req_id;

            //Crea bandera para mostrar modal
            session(['proceso_contratacion' => true]);

            $terminadoAnterior = null;

            //Da por terminado el contrato
            $firmaContratoFin = FirmaContratos::where('id', $contrato_id)->first();

            $firmaContrato = $firmaContratoFin;

            $terminadoAnterior = $firmaContratoFin->terminado;

            //Contrato terminado con videos -> 1
            $firmaContratoFin->terminado = 1;
            $firmaContratoFin->fecha_firma = date("Y-m-d H:i:s");
            $firmaContratoFin->save();

            //Cambia estado del proceso del candidato
            $aptoProceso = RegistroProceso::where('requerimiento_id', $ReqId)
            ->where('candidato_id', $user_id)
            ->where('proceso', 'ENVIO_CONTRATACION')
            ->orderby('created_at', 'DESC')
            ->first();

            $aptoProceso->apto = 1;
            $aptoProceso->save();

            //Crea el estado de contratado
            $nuevo_estado = ReqCandidato::where("requerimiento_id",$ReqId)
            ->where("candidato_id",$user_id)
            ->orderBy("id","DESC")
            ->first();

            $nuevo_estado->estado_candidato = 12;
            $nuevo_estado->estado_contratacion = 0;
            $date = Carbon::now();
            $nuevo_estado->fecha_tentativa_cierre_contratacion=$date->addWeekdays(15)->toDateString();
            $nuevo_estado->save();

            //Crea el proceso de firma virtual con videos
            $nuevo_proceso = new RegistroProceso();
            $nuevo_proceso->fill([
                'requerimiento_candidato_id' => $nuevo_estado->id,
                'estado'                     => config('conf_aplicacion.C_CONTRATADO'),
                'fecha_inicio'               => date("Y-m-d H:i:s"),
                'usuario_envio'              => $user_id,
                'requerimiento_id'           => $ReqId,
                'candidato_id'               => $user_id,
                'observaciones'              => "Contrato firmado virtualmente.",
                'proceso'                    => "FIN_CONTRATACION_VIRTUAL",
                'apto'                       => 1
            ]);
            $nuevo_proceso->save();

            //Event::dispatch(new \App\Events\CloseSelectionFolderEvent($nuevo_estado));

            //Información para correo
            $usuario_envio = User::where('id', $aptoProceso->usuario_envio)->first();

            //Valida terminadoAnterior si es null aún no se ha firmado, si no pasa a else
            if ($terminadoAnterior == null) {
                //Busca información para construir PDF
                $firmaContrato =  FirmaContratos::where('id', $contrato_id)
                ->where('user_id', $user_id)
                ->where('req_id', $ReqId)
                ->first();

                $candidato = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
                ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
                ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
                ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
                ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
                ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
                ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
                ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
                ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
                ->where("datos_basicos.user_id", $user_id)
                ->select(
                    "datos_basicos.*",
                    "tipo_identificacion.descripcion as dec_tipo_doc",
                    "generos.descripcion as genero_desc",
                    "estados_civiles.descripcion as estado_civil_des",
                    "aspiracion_salarial.descripcion as aspiracion_salarial_des",
                    "clases_libretas.descripcion as clases_libretas_des",
                    "tipos_vehiculos.descripcion as tipos_vehiculos_des",
                    "categorias_licencias.descripcion as categorias_licencias_des",
                    "entidades_afp.descripcion as entidades_afp_des",
                    "entidades_eps.descripcion as entidades_eps_des"
                )
                ->first();

                $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("tipos_salarios", "tipos_salarios.id", "=", "requerimientos.tipo_salario")
                ->join("tipos_liquidaciones", "tipos_liquidaciones.id", "=", "requerimientos.tipo_liquidacion")
                ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
                ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
                ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
                ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("tipos_nominas", "tipos_nominas.id", "=", "requerimientos.tipo_nomina")
                ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                ->join("departamentos", function ($join) {
                    $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                    ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                    ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                })
                ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
                ->select(
                    "cargos_especificos.descripcion",
                    "requerimientos.sitio_trabajo as sitio_trabajo",
                    "requerimiento_cantidato.created_at",
                    "requerimiento_cantidato.requerimiento_id",
                    "requerimiento_cantidato.id as requerimiento_cantidato_id",
                    "clientes.nombre as cliente_nombre",
                    "procesos_candidato_req.fecha_inicio_contrato",
                    "procesos_candidato_req.fecha_fin_contrato",
                    "procesos_candidato_req.codigo_validacion as token_acceso",
                    "requerimientos.salario as salario",
                    "requerimientos.funciones as funciones",
                    "requerimientos.empresa_contrata as empresa_contrata",
                    "cargos_genericos.descripcion as nombre_cargo",
                    "cargos_especificos.descripcion as nombre_cargo_especifico",
                    "requerimientos.cargo_especifico_id as cargo_req",
                    "tipos_nominas.descripcion as nomina_contrato",
                    "requerimientos.pais_id as cod_pais",
                    "requerimientos.departamento_id as cod_departamento",
                    "requerimientos.ciudad_id as cod_ciudad",
                    "requerimientos.num_vacantes as numero_vacantes",
                    "tipos_salarios.descripcion as tipo_salarios",
                    "tipos_liquidaciones.descripcion as descripcion_tipo_liquidacion",
                    "agencias.descripcion as agencia",
                    "agencias.direccion as agencia_direccion",
                    "agencias.id as agencia_id",
                    "ciudad.nombre as nombre_ciudad",
                    "motivo_requerimiento.descripcion as motivo_requerimiento"
                )
                ->where("requerimiento_cantidato.candidato_id", $user_id)
                ->where("requerimiento_cantidato.requerimiento_id", $ReqId)
                ->where("procesos_candidato_req.proceso","ENVIO_CONTRATACION")
                ->groupBy('procesos_candidato_req.candidato_id')
                ->orderBy("requerimiento_cantidato.id", "DESC")
                ->first();

                $fechasContrato = RequerimientoContratoCandidato::leftJoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
                ->leftJoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
                ->where('requerimiento_id', $ReqId)
                ->where('candidato_id', $user_id)
                ->select(
                    'fecha_ingreso',
                    'fecha_fin_contrato',
                    'entidades_afp.descripcion as entidad_afp',
                    'entidades_eps.descripcion as entidad_eps'
                    )
                ->orderBy('requerimiento_contrato_candidato.created_at', 'DESC')
                ->first();

                $empresa_contrata = EmpresaLogo::where('id', $reqcandidato->empresa_contrata)->first();

                //Calcular edad de candidatos.
                $edad = ($candidato->fecha_nacimiento != 0 && $candidato->fecha_nacimiento != "") ? Carbon::parse($candidato->fecha_nacimiento)->age : "";

                $lugarnacimiento = null;
                $lugarexpedicion = null;
                $lugarresidencia = null;

                if($candidato != null) {
                    $lugarnacimiento = Pais::join("departamentos", function ($join) {
                        $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                    })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                    })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
                    ->where("ciudad.cod_pais",$candidato->pais_nacimiento)
                    ->where("ciudad.cod_departamento",$candidato->departamento_nacimiento)
                    ->where("ciudad.cod_ciudad", $candidato->ciudad_nacimiento)
                    ->first();

                    $lugarexpedicion = Pais::join("departamentos", function ($join) {
                        $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                    })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                    })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais",$candidato->pais_id)
                    ->where("ciudad.cod_departamento",$candidato->departamento_id)
                    ->where("ciudad.cod_ciudad",$candidato->ciudad_id)
                    ->first();

                    $lugarresidencia = Pais::join("departamentos", function ($join) {
                        $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                    })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                    })
                    ->select(\DB::raw("CONCAT(ciudad.nombre) AS value"))
                    ->where("ciudad.cod_pais",$candidato->pais_residencia)
                    ->where("ciudad.cod_departamento",$candidato->departamento_residencia)
                    ->where("ciudad.cod_ciudad", $candidato->ciudad_residencia)
                    ->first();
                }

                //Hash data
                $userIdHash = Crypt::encrypt($user_id);
                if ($firmaContrato !== null) {
                    $firmaContratoHash = Crypt::encrypt($firmaContrato->id);   
                }

                $foto = null;
                if (Sentinel::check()) {
                    $registro = Sentinel::getUser();
                    if ($registro->foto_perfil == null) {
                        $foto = null;
                    } else {
                        $foto = $registro->foto_perfil;
                    }
                }

                $fecha = date("d/m/Y");

                //Agregar clausulas adicionales
                $adicionales = CargoDocumentoAdicional::join("confirmacion_documentos_adicionales","confirmacion_documentos_adicionales.documento_id","=","cargos_documentos_adicionales.adicional_id")
                ->where("cargo_id", $reqcandidato->cargo_req)
                ->where("contrato_id", $contrato_id)
                ->select("confirmacion_documentos_adicionales.*","cargos_documentos_adicionales.*")
                ->get();

                $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("cargos_especificos","cargos_especificos.clt_codigo","=","clientes.id")
                ->leftjoin("empresa_logos", "empresa_logos.id", "=", "requerimientos.empresa_contrata")
                ->where("requerimientos.id", $ReqId)
                ->select(
                    "requerimientos.id as req_id",
                    "requerimientos.tipo_contrato_id",
                    "cargos_especificos.descripcion as cargo",
                    "clientes.nombre as nombre_cliente",
                    "clientes.nit as nit_cliente",
                    "clientes.id as cliente_id",
                    "requerimientos.id",
                    "requerimientos.negocio_id",
                    "requerimientos.cargo_especifico_id as cargo_especifico_id",
                    "empresa_logos.*"
                )
                ->first();

                $user = User::find($user_id);

                //AQUI
                if($sitio->multiple_empresa_contrato){
                    $cuerpo_contrato = DB::table('empresa_tipo_contrato')
                    ->where("empresa_id", $empresa_contrata->id)
                    ->where('tipo_contrato_id', $requerimiento->tipo_contrato_id)
                    ->first();

                    $tipo_contrato = TipoContrato::find($requerimiento->tipo_contrato_id);

                    if ($candidato != null && $tipo_contrato != null && $tipo_contrato->id == 5) {
                        $req_contrato_candidato = RequerimientoContratoCandidato::join("bancos", "bancos.id", "=", "requerimiento_contrato_candidato.nombre_banco")
                        ->select('requerimiento_contrato_candidato.tipo_cuenta',
                        'requerimiento_contrato_candidato.numero_cuenta',
                        'bancos.nombre_banco as banco')
                        ->where("candidato_id", $user_id)
                        ->where("requerimiento_id", $requerimiento->id)
                        ->first();
                    }else{
                        $req_contrato_candidato = null;
                    }

                    $meses = $this->meses;
                    $dias_semana = $this->dias_semana;

                    $view = \SnappyPDF::loadView("contratos.pdf.".$tipo_contrato->modelo_contrato,[                        'userId',
                        'ReqId'=>$ReqId,
                        'candidato'=>$candidato,
                        'firmaContrato'=>$firmaContrato,
                        'lugarnacimiento'=>$lugarnacimiento,
                        'lugarexpedicion'=>$lugarexpedicion,
                        'lugarresidencia'=>$lugarresidencia,
                        'reqcandidato'=>$reqcandidato,
                        'userIdHash'=>$userIdHash,
                        'firmaContratoHash'=>$firmaContratoHash,
                        'fecha'=>$fecha,
                        'empresa_contrata'=>$empresa_contrata,
                        'user'=>$user,
                        'requerimiento'=>$requerimiento,
                        'adicionales'=>$adicionales,
                        'foto'=>$foto,
                        'fechasContrato'=>$fechasContrato,
                        'cuerpo_contrato'=>$cuerpo_contrato,
                        'req_contrato_candidato'=>$req_contrato_candidato,
                        'meses'=>$meses,
                        'dias_semana'=>$dias_semana,
                        'edad'=>$edad
                    ])
                    ->output();
                }else {
                    $view = \SnappyPDF::loadView("home.pdf-contrato-firmar",[
                        'userId'=>$userId,
                        'ReqId'=>$ReqId,
                        'candidato'=>$candidato,
                        'firmaContrato'=>$firmaContrato,
                        'lugarnacimiento'=>$lugarnacimiento,
                        'lugarexpedicion'=>$lugarexpedicion,
                        'lugarresidencia'=>$lugarresidencia,
                        'reqcandidato'=>$reqcandidato,
                        'userIdHash'=>$userIdHash,
                        'firmaContratoHash'=>$firmaContratoHash,
                        'fecha'=>$fecha,
                        'empresa_contrata'=>$empresa_contrata,
                        'user'=>$user,
                        'requerimiento'=>$requerimiento,
                        'adicionales'=>$adicionales,
                        'foto'=>$foto,
                        'fechasContrato'=>$fechasContrato,
                        'cuerpo_contrato'=>$cuerpo_contrato,
                        'req_contrato_candidato'=>$req_contrato_candidato,
                        'meses'=>$meses,
                        'dias_semana'=>$dias_semana
                    ])
                    ->output();
                }

                //$pdf = \App::make('dompdf.wrapper');
                //$pdf->loadHTML($view);

                //Guarda contrato
                //$output = $pdf->output();
                $nombre_documento = 'contrato_'.$ReqId.'_'.$user_id.'.pdf';

                $firmaContrato->contrato = $nombre_documento;
                $firmaContrato->save();

                //file_put_contents('contratos/'.$nombre_documento, $output);
                Storage::disk('public')->put('contratos/'.$nombre_documento,$view);

                //Termina requerimiento si se completan las vacantes
                $numero_vacantes = $reqcandidato->numero_vacantes;
                
                $cuenta_contratos_firmados = FirmaContratos::where('req_id', $ReqId)
                ->whereIn('terminado', [1, 2])
                ->whereNotIn("estado",[0])
                ->count();

                if ($cuenta_contratos_firmados != null || $cuenta_contratos_firmados != '') {
                    if($cuenta_contratos_firmados >= $numero_vacantes){
                        $buscar_estado_req = EstadosRequerimientos::where('req_id', $ReqId)
                        ->where('estado', 16)
                        ->first();
                        
                        //Valida si ya esta cerrado el req
                        if($buscar_estado_req == null || $buscar_estado_req == ''){
                            $terminar_req = new EstadosRequerimientos();
                            $terminar_req->fill([
                                "estado"        => config('conf_aplicacion.C_TERMINADO'),
                                "user_gestion"  => $this->user->id,
                                "observaciones" => "Se ha cumplido con todos los candidatos solicitados.",
                                "req_id"        => $ReqId,
                            ]);
                            $terminar_req->save();

                            //Se cambia el estado público del requerimiento
                            $req  = Requerimiento::find($ReqId);
                            $req->estado_publico = 0;
                            $req->save();

                            $candidatos_no_contratados = [];

                            //Consultar candidatos enviados
                            $no_seleccionados = User::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
                            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                            ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
                            ->where("requerimiento_cantidato.requerimiento_id", $ReqId)
                            ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
                            ->select(
                                "datos_basicos.*",
                                "estados.id as estado_id",
                                "estados.descripcion as estado_candidatos",
                                "requerimiento_cantidato.estado_candidato",
                                "requerimiento_cantidato.id as req_candidato_id"
                            )
                            ->get();

                            foreach ($no_seleccionados as $key => $candidato) {
                                //Valida la contratación cancelada
                                if($candidato->estado_candidato != 24){
                                    if (!in_array($candidato->estado_candidato, [config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'), config('conf_aplicacion.C_CONTRATADO')]) ) {
                                        array_push($candidatos_no_contratados, $candidato->user_id);
                                    }
                                }
                            }

                            //ACTIVAR CANDIDATOS NO SELECCIONADOS
                            foreach ($candidatos_no_contratados as $key => $user) {
                                $update_user = DatosBasicos::where("user_id", $user)->first();
                                $update_user->fill(["estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')]);
                                $update_user->save();

                                //ENVIAR MAIL A CANDIDATOS NO CONTRATADOS

                                $nombres = $update_user->nombres .' '. $update_user->primer_apellido;
                                $asunto = "¡Gracias por tu aplicación a la vacante!";
                                $emails = $update_user->email;
                                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                                $mailConfiguration = 1; //Id de la configuración
                            
                                $mailTitle = "¡Gracias por tu aplicación a la vacante!"; //Titulo o tema del correo

                                //Cuerpo con html y comillas dobles para las variables
                                $mailBody = "Estimado(a) $nombres.<br><br>

                                    Te informamos que después del análisis de tu hoja de vida, hemos decidido dar por culminado tu proceso de selección para esta propuesta laboral.<br><br>

                                    Te agradecemos haber dispuesto del tiempo que requerimos, tu compromiso e interés constante. Toda tu información quedará registrada en nuestra base de datos, bajo las directrices de completa confidencialidad. <br><br>

                                    Cordialmente, <br><br>

                                    <i>Equipo de Selección</i>";

                                //Arreglo para el botón
                                $mailButton = ['buttonText' => 'ACCEDER', 'buttonRoute' => route('login')];

                                $mailUser = $update_user->user_id; //Id del usuario al que se le envía el correo

                                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($emails, $asunto) {
                                    $message->to([$emails]);
                                    $message->subject($asunto)
                                    ->getHeaders()
                                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                                });
                            }
                        }
                    }
                }
            }else{
                $candidato = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
                ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
                ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
                ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
                ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
                ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
                ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
                ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
                ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
                ->where("datos_basicos.user_id", $user_id)
                ->select(
                    "datos_basicos.*",
                    "tipo_identificacion.descripcion as dec_tipo_doc",
                    "generos.descripcion as genero_desc",
                    "estados_civiles.descripcion as estado_civil_des",
                    "aspiracion_salarial.descripcion as aspiracion_salarial_des",
                    "clases_libretas.descripcion as clases_libretas_des",
                    "tipos_vehiculos.descripcion as tipos_vehiculos_des",
                    "categorias_licencias.descripcion as categorias_licencias_des",
                    "entidades_afp.descripcion as entidades_afp_des",
                    "entidades_eps.descripcion as entidades_eps_des"
                )
                ->first();

                $fechasContrato = RequerimientoContratoCandidato::where('requerimiento_id', $ReqId)
                ->where('candidato_id', $user_id)
                ->select('fecha_ingreso', 'fecha_fin_contrato', 'hora_ingreso', 'atte_carta_presentacion', 'direccion_carta_presentacion')
                ->orderBy('created_at', 'DESC')
                ->first();

                $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("cargos_especificos","cargos_especificos.clt_codigo","=","clientes.id")
                ->leftjoin("empresa_logos", "empresa_logos.id", "=", "requerimientos.empresa_contrata")
                ->where("requerimientos.id", $ReqId)
                ->select(
                    "requerimientos.id as req_id",
                    "requerimientos.tipo_contrato_id",
                    "cargos_especificos.descripcion as cargo",
                    "clientes.nombre as nombre_cliente",
                    "clientes.nit as nit_cliente",
                    "clientes.id as cliente_id",
                    "requerimientos.id",
                    "requerimientos.negocio_id",
                    "requerimientos.cargo_especifico_id as cargo_especifico_id",
                    "empresa_logos.*"
                )
                ->first();

                $ciudadexpedicion = null;

                if($candidato != null) {             
                    $ciudadexpedicion = Ciudad::select('nombre')->where("ciudad.cod_pais",$candidato->pais_id)
                        ->where("ciudad.cod_departamento",$candidato->departamento_id)
                        ->where("ciudad.cod_ciudad",$candidato->ciudad_id)
                        ->first();

                    if ($ciudadexpedicion == null) {
                        $ciudadexpedicion = Ciudad::select('nombre')->where("ciudad.cod_pais",$candidato->pais_id)
                            ->where("ciudad.cod_departamento",$candidato->departamento_expedicion_id)
                            ->where("ciudad.cod_ciudad",$candidato->ciudad_expedicion_id)
                            ->first();
                    }
                }

                $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
                ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
                ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
                ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                ->join("departamentos", function ($join) {
                    $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                    ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                    ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                })
                ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
                ->select(
                    "cargos_especificos.descripcion",
                    "requerimientos.sitio_trabajo as sitio_trabajo",
                    "requerimiento_cantidato.created_at",
                    "requerimiento_cantidato.requerimiento_id",
                    "requerimiento_cantidato.id as requerimiento_cantidato_id",
                    "clientes.nombre as cliente_nombre",
                    "clientes.id as cliente_id",
                    "procesos_candidato_req.fecha_inicio_contrato",
                    "procesos_candidato_req.fecha_fin_contrato",
                    "procesos_candidato_req.codigo_validacion as token_acceso",
                    "requerimientos.salario as salario",
                    "requerimientos.funciones as funciones",
                    "requerimientos.empresa_contrata as empresa_contrata",
                    "cargos_genericos.descripcion as nombre_cargo",
                    "cargos_especificos.descripcion as nombre_cargo_especifico",
                    "requerimientos.cargo_especifico_id as cargo_req",
                    "requerimientos.pais_id as cod_pais",
                    "requerimientos.departamento_id as cod_departamento",
                    "requerimientos.ciudad_id as cod_ciudad",
                    "requerimientos.num_vacantes as numero_vacantes",
                    "agencias.id as agencia_id",
                    "motivo_requerimiento.descripcion as motivo_requerimiento"
                )
                ->where("requerimiento_cantidato.candidato_id", $user_id)
                ->where("requerimiento_cantidato.requerimiento_id", $ReqId)
                ->where("procesos_candidato_req.proceso","ENVIO_CONTRATACION")
                ->groupBy('procesos_candidato_req.candidato_id')
                ->orderBy("requerimiento_cantidato.id", "DESC")
                ->first();

                //Termina requerimiento si se completan las vacantes
                $numero_vacantes = $reqcandidato->numero_vacantes;
                
                $cuenta_contratos_firmados = FirmaContratos::where('req_id', $ReqId)
                ->whereIn('terminado', [1, 2])
                ->whereNotIn("estado",[0])
                ->count();

                if ($cuenta_contratos_firmados != null || $cuenta_contratos_firmados != '') {
                    if($cuenta_contratos_firmados >= $numero_vacantes){
                        $buscar_estado_req = EstadosRequerimientos::where('req_id', $ReqId)
                        ->where('estado', 16)
                        ->first();
                        
                        //Validar si ya esta cerrado el req
                        if($buscar_estado_req == null || $buscar_estado_req == ''){
                            $terminar_req = new EstadosRequerimientos();
                            $terminar_req->fill([
                                "estado"        => config('conf_aplicacion.C_TERMINADO'),
                                "user_gestion"  => $this->user->id,
                                "observaciones" => "Se ha cumplido con todos los candidatos solicitados.",
                                "req_id"        => $ReqId,
                            ]);
                            $terminar_req->save();

                            //Se cambia el estado público del requerimiento
                            $req  = Requerimiento::find($ReqId);
                            $req->estado_publico = 0;
                            $req->save();

                            $candidatos_no_contratados = [];

                            //Consultar candidatos enviados
                            $no_seleccionados = User::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
                            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                            ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
                            ->where("requerimiento_cantidato.requerimiento_id", $ReqId)
                            ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
                            ->select(
                                "datos_basicos.*",
                                "estados.id as estado_id",
                                "estados.descripcion as estado_candidatos",
                                "requerimiento_cantidato.estado_candidato",
                                "requerimiento_cantidato.id as req_candidato_id"
                            )
                            ->get();

                            foreach ($no_seleccionados as $key => $candidato_no) {
                                //Valida la contratación cancelada
                                if($candidato_no->estado_candidato != 24){
                                    if ( !in_array($candidato_no->estado_candidato, [config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'), config('conf_aplicacion.C_CONTRATADO')])  ) {
                                        array_push($candidatos_no_contratados, $candidato_no->user_id);
                                    }
                                }
                            }

                            //ACTIVAR CANDIDATOS NO SELECCIONADOS
                            foreach ($candidatos_no_contratados as $key => $user) {
                                $update_user = DatosBasicos::where("user_id", $user)->first();
                                $update_user->fill(["estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')]);
                                $update_user->save();

                                //ENVIAR MAIL A CANDIDATOS NO CONTRATADOS

                                $nombres = $update_user->nombres .' '. $update_user->primer_apellido;
                                $asunto = "¡Gracias por tu aplicación a la vacante!";
                                $emails = $update_user->email;
                                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                                $mailConfiguration = 1; //Id de la configuración
                            
                                $mailTitle = "¡Gracias por tu aplicación a la vacante!"; //Titulo o tema del correo

                                //Cuerpo con html y comillas dobles para las variables
                                $mailBody = "Estimado(a) $nombres.<br><br>

                                    Te informamos que después del análisis de tu hoja de vida, hemos decidido dar por culminado tu proceso de selección para esta propuesta laboral.<br><br>

                                    Te agradecemos haber dispuesto del tiempo que requerimos, tu compromiso e interés constante. Toda tu información quedará registrada en nuestra base de datos, bajo las directrices de completa confidencialidad. <br><br>

                                    Cordialmente, <br><br>

                                    <i>Equipo de Selección</i>";

                                //Arreglo para el botón
                                $mailButton = ['buttonText' => 'ACCEDER', 'buttonRoute' => route('login')];

                                $mailUser = $update_user->user_id; //Id del usuario al que se le envía el correo

                                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($emails, $asunto) {
                                    $message->to([$emails]);
                                    $message->subject($asunto)
                                    ->getHeaders()
                                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                                });
                            }
                        }
                    }
                }
            }

            //Busca el documento
            $documentos = Documentos::where('numero_id', $candidato->numero_id)
            ->where('user_id', $user_id)
            ->where('tipo_documento_id', 16)
            ->where('requerimiento', $ReqId)
            ->first();

            $documentos->descripcion_archivo = 'Contrato firmado virtualmente';
            $documentos->save();

            //Carta de presentación para todas las instancias
            $empresa_logo = $requerimiento->logo;

            if ($requerimiento->nombre_empresa == 'Listos' || $requerimiento->nombre_empresa == 'Nodos' || $requerimiento->nombre_empresa == 'Tercerizar') {
                $logo = (isset($requerimiento->logo))?$requerimiento->logo:'';
            } else {
                $logo = '';
            }

            $ciudad_req = null;
            $ciudad_req = Ciudad::select('nombre')->where("ciudad.cod_pais",$requerimiento->pais_id)
                ->where("ciudad.cod_departamento",$requerimiento->departamento_id)
                ->where("ciudad.cod_ciudad",$requerimiento->ciudad_id)
                ->first();

            $dia = date('d', strtotime($fechasContrato->fecha_ingreso));
            $mes = date('n', strtotime($fechasContrato->fecha_ingreso));
            $ano = date('Y', strtotime($fechasContrato->fecha_ingreso));
            $diaSemana = date('N', strtotime($fechasContrato->fecha_ingreso));
            $fecha_firma_replace = $this->dias[$diaSemana].", $dia de ".$this->meses[$mes]." de $ano";

            $qrcode = base64_encode(\QrCode::format('png')->size(200)->errorCorrection('H')->generate(route('informacionTrabajador', ['id' => $user_id])));

            $view3 = \SnappyPDF::loadView("home.pdf-carta-presentacion-general",[
                    'candidato'=>$candidato,
                    'ciudad_req'=>$ciudad_req,
                    'ciudadexpedicion'=>$ciudadexpedicion,
                    'reqcandidato'=>$reqcandidato,
                    'requerimiento'=>$requerimiento,
                    'fechasContrato'=>$fechasContrato,
                    'fecha_firma_replace'=>$fecha_firma_replace,
                    'empresa_logo'=>$empresa_logo,
                    'logo'=>$logo,
                    'qrcode'=>$qrcode
            ])
            ->output();

            //$pdf3  = \App::make('dompdf.wrapper');

            //$pdf3->loadHTML($view3);

            //Guarda carta
            //$output = $pdf3->output();
            $nombre_documento = 'carta_presentacion_'.$ReqId.'_'.$user_id.'.pdf';

            //file_put_contents('recursos_carta_presentacion/'.$nombre_documento, $output);

            Storage::disk('public')->put('recursos_carta_presentacion/'.$nombre_documento,$view3);

            //Crea el documento
            $documentos2 = new Documentos();
            $documentos2->fill([
                "numero_id" => $candidato->numero_id,
                "user_id" => $user_id,
                "tipo_documento_id" => 30,
                "nombre_archivo" => $nombre_documento,
                "gestiono" => $this->user->id,
                "requerimiento" => $ReqId,
                "descripcion_archivo" => 'Carta de Presentación.',
            ]);
            $documentos2->save();

            //Fin carta presentacion

            //Notificacion ejecutivo de Cuentas
            $this->notificacionEjecutivoCuentas($user_id, $ReqId, $contrato_id);

            //Envío de correo
            if ( $sitioModulo->afiliaciones == 'enabled' ) {
                $es_cliente_prueba = false;

                if ($sitio->filtro_cliente == 'enabled' && $sitio->clientes_prueba_id != null && $sitio->clientes_prueba_id != '') {
                    $ids_clientes_prueba = explode(",", $sitio->clientes_prueba_id);

                    if (in_array($requerimiento->cliente_id, $ids_clientes_prueba)) {
                        $es_cliente_prueba = true;
                    }
                }

                if (!$es_cliente_prueba) {
                    //Sino es cliente de prueba se envia la notificacion de Afiliaciones
                    $this->notificaContratacionRolAfiliaciones(
                        $ReqId,
                        $candidato,
                        $reqcandidato->requerimiento_cantidato_id,
                        $reqcandidato->nombre_cargo_especifico,
                        $reqcandidato->cliente_nombre,
                        $reqcandidato->sitio_trabajo,
                        $firmaContrato->fecha_firma
                    );
                }
            }
            

            //GENERAR DOCUMENTOS

            //CARNET
            $controll= new ReclutamientoController();
            $carnet=$controll->generar_carnet_general($user_id,1);
            Storage::disk('public')->put('documentos_candidatos/'.$candidato->numero_id.'/'.$ReqId.'/contratacion/CARNET_CONTRATADO.pdf',$carnet);
        }

        return response()->json(["success" => true]);
    }

    public function guardar_confirmacion_manual(Request $data)
    {
        $contrato_id = $data->contrato_id;
        $contratoId = $contrato_id;
        $sitioModulo = SitioModulo::first();
        $sitio = Sitio::first();

        //Si es la ultima pregunta, actualiza registro de firma
            //Para versiones más recientes de PHP > 7.2
            error_reporting(E_ALL ^ E_DEPRECATED);

            $ReqId = $data->req_id;

            //Crea bandera para mostrar modal
            session(['proceso_contratacion' => true]);

            $terminadoAnterior = null;

            //Da por terminado el contrato
            $firmaContratoFin = FirmaContratos::where('id', $contrato_id)->first();

            $terminadoAnterior = $firmaContratoFin->terminado;

            //Contrato terminado con videos -> 1
            $firmaContratoFin->terminado = 1;
            $firmaContratoFin->fecha_firma = date("Y-m-d H:i:s");
            $firmaContratoFin->save();

            $fecha_firma=date("Y-m-d H:i:s");
            //Cambia estado del proceso del candidato
            $aptoProceso = RegistroProceso::where('requerimiento_id', $ReqId)
            ->where('candidato_id', $this->user->id)
            ->where('proceso', 'ENVIO_CONTRATACION')
            ->orderby('created_at', 'DESC')
            ->first();

            $aptoProceso->apto = 1;
            $aptoProceso->save();

            //Crea el estado de contratado
            $nuevo_estado = ReqCandidato::where("requerimiento_id", $ReqId)
            ->where("candidato_id", $this->user->id)
            ->orderBy("id", "DESC")
            ->first();

            $nuevo_estado->estado_candidato = 12;
            $nuevo_estado->estado_contratacion = 0;
            $date = Carbon::now();
            $nuevo_estado->fecha_tentativa_cierre_contratacion=$date->addWeekdays(15)->toDateString();
            $nuevo_estado->save();

            //Crea el proceso de firma virtual con videos
            $nuevo_proceso = new RegistroProceso();
            $nuevo_proceso->fill([
                'requerimiento_candidato_id' => $nuevo_estado->id,
                'estado'                     => config('conf_aplicacion.C_CONTRATADO'),
                'fecha_inicio'               => date("Y-m-d H:i:s"),
                'usuario_envio'              => $this->user->id,
                'requerimiento_id'           => $ReqId,
                'candidato_id'               => $this->user->id,
                'observaciones'              => "Contrato firmado virtualmente.",
                'proceso'                    => "FIRMA_CONF_MAN",
                'apto'                       => 1
            ]);
            $nuevo_proceso->save();

            //Event::dispatch(new \App\Events\CloseSelectionFolderEvent($nuevo_estado));

            //Información para correo
            $usuario_envio = User::where('id', $aptoProceso->usuario_envio)->first();

            //Valida terminadoAnterior si es null aún no se ha firmado, si no pasa a else
            if ($terminadoAnterior == null) {
                //Busca información para construir PDF

                $firmaContrato=$firmaContratoFin;

                $candidato = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
                ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
                ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
                ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
                ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
                ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
                ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
                ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
                ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
                ->where("datos_basicos.user_id", $this->user->id)
                ->select(
                    "datos_basicos.*",
                    "tipo_identificacion.descripcion as dec_tipo_doc",
                    "generos.descripcion as genero_desc",
                    "estados_civiles.descripcion as estado_civil_des",
                    "aspiracion_salarial.descripcion as aspiracion_salarial_des",
                    "clases_libretas.descripcion as clases_libretas_des",
                    "tipos_vehiculos.descripcion as tipos_vehiculos_des",
                    "categorias_licencias.descripcion as categorias_licencias_des",
                    "entidades_afp.descripcion as entidades_afp_des",
                    "entidades_eps.descripcion as entidades_eps_des"
                )
                ->first();

                $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("tipos_salarios", "tipos_salarios.id", "=", "requerimientos.tipo_salario")
                ->join("tipos_liquidaciones", "tipos_liquidaciones.id", "=", "requerimientos.tipo_liquidacion")
                ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
                ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
                ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
                ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("tipos_nominas", "tipos_nominas.id", "=", "requerimientos.tipo_nomina")
                ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                ->join("departamentos", function ($join) {
                    $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                    ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                    ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                })
                ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
                ->select(
                    "cargos_especificos.descripcion",
                    "requerimientos.sitio_trabajo as sitio_trabajo",
                    "requerimiento_cantidato.created_at",
                    "requerimiento_cantidato.requerimiento_id",
                    "requerimiento_cantidato.id as requerimiento_cantidato_id",
                    "clientes.nombre as cliente_nombre",
                    "procesos_candidato_req.fecha_inicio_contrato",
                    "procesos_candidato_req.fecha_fin_contrato",
                    "procesos_candidato_req.codigo_validacion as token_acceso",
                    "requerimientos.salario as salario",
                    "requerimientos.funciones as funciones",
                    "requerimientos.empresa_contrata as empresa_contrata",
                    "cargos_genericos.descripcion as nombre_cargo",
                    "cargos_especificos.descripcion as nombre_cargo_especifico",
                    "requerimientos.cargo_especifico_id as cargo_req",
                    "tipos_nominas.descripcion as nomina_contrato",
                    "requerimientos.pais_id as cod_pais",
                    "requerimientos.departamento_id as cod_departamento",
                    "requerimientos.ciudad_id as cod_ciudad",
                    "requerimientos.num_vacantes as numero_vacantes",
                    "tipos_salarios.descripcion as tipo_salarios",
                    "tipos_liquidaciones.descripcion as descripcion_tipo_liquidacion",
                    "agencias.descripcion as agencia",
                    "agencias.direccion as agencia_direccion",
                    "ciudad.nombre as nombre_ciudad",
                    "agencias.id as agencia_id",
                    "motivo_requerimiento.descripcion as motivo_requerimiento"
                )
                ->where("requerimiento_cantidato.candidato_id", $this->user->id)
                ->where("requerimiento_cantidato.requerimiento_id", $ReqId)
                ->where("procesos_candidato_req.proceso","ENVIO_CONTRATACION")
                ->groupBy('procesos_candidato_req.candidato_id')
                ->orderBy("requerimiento_cantidato.id", "DESC")
                ->first();

                $fechasContrato = RequerimientoContratoCandidato::leftJoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
                ->leftJoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
                ->where('requerimiento_id', $ReqId)
                ->where('candidato_id', $this->user->id)
                ->select(
                    'fecha_ingreso',
                    'fecha_fin_contrato',
                    'entidades_afp.descripcion as entidad_afp',
                    'entidades_eps.descripcion as entidad_eps'
                    )
                ->orderBy('requerimiento_contrato_candidato.created_at', 'DESC')
                ->first();

                $empresa_contrata = EmpresaLogo::where('id', $reqcandidato->empresa_contrata)->first();

                //Calcular edad de candidatos.
                $edad = ($candidato->fecha_nacimiento != 0 && $candidato->fecha_nacimiento != "") ? Carbon::parse($candidato->fecha_nacimiento)->age : "";

                $lugarnacimiento = null;
                $lugarexpedicion = null;
                $lugarresidencia = null;

                if($candidato != null) {
                    $lugarnacimiento = Pais::join("departamentos", function ($join) {
                        $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                    })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                    })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
                    ->where("ciudad.cod_pais",$candidato->pais_nacimiento)
                    ->where("ciudad.cod_departamento",$candidato->departamento_nacimiento)
                    ->where("ciudad.cod_ciudad", $candidato->ciudad_nacimiento)
                    ->first();

                    $lugarexpedicion = Pais::join("departamentos", function ($join) {
                        $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                    })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                    })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais",$candidato->pais_id)
                    ->where("ciudad.cod_departamento",$candidato->departamento_id)
                    ->where("ciudad.cod_ciudad",$candidato->ciudad_id)
                    ->first();

                    $lugarresidencia = Pais::join("departamentos", function ($join) {
                        $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                    })->join("ciudad", function ($join2) {
                        $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                    })
                    ->select(\DB::raw("CONCAT(ciudad.nombre) AS value"))
                    ->where("ciudad.cod_pais",$candidato->pais_residencia)
                    ->where("ciudad.cod_departamento",$candidato->departamento_residencia)
                    ->where("ciudad.cod_ciudad", $candidato->ciudad_residencia)
                    ->first();
                }

                //Hash data
                $userIdHash = Crypt::encrypt($this->user->id);
                if ($firmaContrato !== null) {
                    $firmaContratoHash = Crypt::encrypt($firmaContrato->id);   
                }

                $foto = null;
                if (Sentinel::check()) {
                    $registro = Sentinel::getUser();
                    if ($registro->foto_perfil == null) {
                        $foto = null;
                    } else {
                        $foto = $registro->foto_perfil;
                    }
                }

                $fecha = date("d/m/Y");

                //Agregar clausulas adicionales
                $adicionales = CargoDocumentoAdicional::join("confirmacion_documentos_adicionales","confirmacion_documentos_adicionales.documento_id","=","cargos_documentos_adicionales.adicional_id")
                ->where("cargo_id", $reqcandidato->cargo_req)
                ->where("contrato_id", $contrato_id)
                ->select("confirmacion_documentos_adicionales.*","cargos_documentos_adicionales.*")
                ->get();

                $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("cargos_especificos","cargos_especificos.clt_codigo","=","clientes.id")
                ->leftjoin("empresa_logos", "empresa_logos.id", "=", "requerimientos.empresa_contrata")
                ->where("requerimientos.id", $ReqId)
                ->select(
                    "requerimientos.id as req_id",
                    "cargos_especificos.descripcion as cargo",
                    "clientes.nombre as nombre_cliente",
                    "clientes.nit as nit_cliente",
                    "requerimientos.id",
                    "requerimientos.negocio_id",
                    "requerimientos.cargo_especifico_id as cargo_especifico_id",
                    "empresa_logos.*"
                )
                ->first();

                $user = User::find($this->user->id);

                $view = \SnappyPDF::loadView("home.pdf-contrato-firmar",[
                    //'userId',
                    'ReqId'=>$ReqId,
                    'candidato'=>$candidato,
                    'firmaContrato'=>$firmaContrato,
                    'lugarnacimiento'=>$lugarnacimiento,
                    'lugarexpedicion'=>$lugarexpedicion,
                    'lugarresidencia'=>$lugarresidencia,
                    'reqcandidato'=>$reqcandidato,
                    'userIdHash'=>$userIdHash,
                    'firmaContratoHash'=>$firmaContratoHash,
                    'fecha'=>$fecha,
                    'empresa_contrata'=>$empresa_contrata,
                    'user'=>$user,
                    'requerimiento'=>$requerimiento,
                    'adicionales'=>$adicionales,
                    'foto'=>$foto,
                    'fechasContrato'=>$fechasContrato,
                    'fecha_firma'=>$fecha_firma
                ])
                ->output();

                //Guarda contrato
                $nombre_documento = 'contrato_'.$contrato_id.'_'.$this->user->id.'.pdf';

                $firmaContrato->contrato = $nombre_documento;
                $firmaContrato->save();

                //file_put_contents('contratos/'.$nombre_documento, $output);
                Storage::disk('public')->put('contratos/'.$nombre_documento,$view);

                //Termina requerimiento si se completan las vacantes
                $numero_vacantes = $reqcandidato->numero_vacantes;
                
                $cuenta_contratos_firmados = FirmaContratos::where('req_id', $ReqId)
                ->whereIn('terminado', [1, 2])
                ->whereNotIn("estado",[0])
                ->count();

                if ($cuenta_contratos_firmados != null || $cuenta_contratos_firmados != '') {
                    if($cuenta_contratos_firmados >= $numero_vacantes){
                        $buscar_estado_req = EstadosRequerimientos::where('req_id', $ReqId)
                        ->where('estado', 16)
                        ->first();
                        
                        //Valida si ya esta cerrado el req
                        if($buscar_estado_req == null || $buscar_estado_req == ''){
                            $terminar_req = new EstadosRequerimientos();
                            $terminar_req->fill([
                                "estado"        => config('conf_aplicacion.C_TERMINADO'),
                                "user_gestion"  => $this->user->id,
                                "observaciones" => "Se ha cumplido con todos los candidatos solicitados.",
                                "req_id"        => $ReqId,
                            ]);
                            $terminar_req->save();

                            //Se cambia el estado público del requerimiento
                            $req  = Requerimiento::find($ReqId);
                            $req->estado_publico = 0;
                            $req->save();

                            $candidatos_no_contratados = [];

                            //Consultar candidatos enviados
                            $no_seleccionados = User::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
                            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                            ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
                            ->where("requerimiento_cantidato.requerimiento_id", $ReqId)
                            ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
                            ->select(
                                "datos_basicos.*",
                                "estados.id as estado_id",
                                "estados.descripcion as estado_candidatos",
                                "requerimiento_cantidato.estado_candidato",
                                "requerimiento_cantidato.id as req_candidato_id"
                            )
                            ->get();

                            foreach ($no_seleccionados as $key => $candidato) {
                                //Valida la contratación cancelada
                                if($candidato->estado_candidato != 24){
                                    if ( !in_array($candidato->estado_candidato, [config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'), config('conf_aplicacion.C_CONTRATADO')])  ) {
                                        array_push($candidatos_no_contratados, $candidato->user_id);
                                    }
                                }
                            }

                            //ACTIVAR CANDIDATOS NO SELECCIONADOS
                            foreach ($candidatos_no_contratados as $key => $user) {
                                $update_user = DatosBasicos::where("user_id", $user)->first();
                                $update_user->fill(["estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')]);
                                $update_user->save();

                                //ENVIAR MAIL A CANDIDATOS NO CONTRATADOS

                                $nombres = $update_user->nombres .' '. $update_user->primer_apellido;
                                $asunto = "¡Gracias por tu aplicación a la vacante!";
                                $emails = $update_user->email;
                                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                                $mailConfiguration = 1; //Id de la configuración
                            
                                $mailTitle = "¡Gracias por tu aplicación a la vacante!"; //Titulo o tema del correo

                                //Cuerpo con html y comillas dobles para las variables
                                $mailBody = "Estimado(a) $nombres.<br><br>

                                    Te informamos que después del análisis de tu hoja de vida, hemos decidido dar por culminado tu proceso de selección para esta propuesta laboral.<br><br>

                                    Te agradecemos haber dispuesto del tiempo que requerimos, tu compromiso e interés constante. Toda tu información quedará registrada en nuestra base de datos, bajo las directrices de completa confidencialidad. <br><br>

                                    Cordialmente, <br><br>

                                    <i>Equipo de Selección</i>";

                                //Arreglo para el botón
                                $mailButton = ['buttonText' => 'ACCEDER', 'buttonRoute' => route('login')];

                                $mailUser = $update_user->user_id; //Id del usuario al que se le envía el correo

                                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($emails, $asunto) {
                                    $message->to([$emails]);
                                    $message->subject($asunto)
                                    ->getHeaders()
                                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                                });
                            }
                        }
                    }
                }
            }else{
                $candidato = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
                ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
                ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
                ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
                ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
                ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
                ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
                ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
                ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
                ->where("datos_basicos.user_id", $this->user->id)
                ->select(
                    "datos_basicos.*",
                    "tipo_identificacion.descripcion as dec_tipo_doc",
                    "generos.descripcion as genero_desc",
                    "estados_civiles.descripcion as estado_civil_des",
                    "aspiracion_salarial.descripcion as aspiracion_salarial_des",
                    "clases_libretas.descripcion as clases_libretas_des",
                    "tipos_vehiculos.descripcion as tipos_vehiculos_des",
                    "categorias_licencias.descripcion as categorias_licencias_des",
                    "entidades_afp.descripcion as entidades_afp_des",
                    "entidades_eps.descripcion as entidades_eps_des"
                )
                ->first();

                $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
                ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
                ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
                ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
                ->join("departamentos", function ($join) {
                    $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                    ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                    ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                })
                ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
                ->select(
                    "cargos_especificos.descripcion",
                    "requerimientos.sitio_trabajo as sitio_trabajo",
                    "requerimiento_cantidato.created_at",
                    "requerimiento_cantidato.requerimiento_id",
                    "requerimiento_cantidato.id as requerimiento_cantidato_id",
                    "clientes.nombre as cliente_nombre",
                    "clientes.id as cliente_id",
                    "procesos_candidato_req.fecha_inicio_contrato",
                    "procesos_candidato_req.fecha_fin_contrato",
                    "procesos_candidato_req.codigo_validacion as token_acceso",
                    "requerimientos.salario as salario",
                    "requerimientos.funciones as funciones",
                    "requerimientos.empresa_contrata as empresa_contrata",
                    "cargos_genericos.descripcion as nombre_cargo",
                    "cargos_especificos.descripcion as nombre_cargo_especifico",
                    "requerimientos.cargo_especifico_id as cargo_req",
                    "requerimientos.pais_id as cod_pais",
                    "requerimientos.departamento_id as cod_departamento",
                    "requerimientos.ciudad_id as cod_ciudad",
                    "requerimientos.num_vacantes as numero_vacantes",
                    "agencias.id as agencia_id",
                    "motivo_requerimiento.descripcion as motivo_requerimiento"
                )
                ->where("requerimiento_cantidato.candidato_id", $this->user->id)
                ->where("requerimiento_cantidato.requerimiento_id", $ReqId)
                ->where("procesos_candidato_req.proceso","ENVIO_CONTRATACION")
                ->groupBy('procesos_candidato_req.candidato_id')
                ->orderBy("requerimiento_cantidato.id", "DESC")
                ->first();

                //Termina requerimiento si se completan las vacantes
                $numero_vacantes = $reqcandidato->numero_vacantes;
                
                $cuenta_contratos_firmados = FirmaContratos::where('req_id', $ReqId)
                ->whereIn('terminado', [1, 2])
                ->whereNotIn("estado",[0])
                ->count();

                if ($cuenta_contratos_firmados != null || $cuenta_contratos_firmados != '') {
                    if($cuenta_contratos_firmados >= $numero_vacantes){
                        $buscar_estado_req = EstadosRequerimientos::where('req_id', $ReqId)
                        ->where('estado', 16)
                        ->first();
                        
                        //Validar si ya esta cerrado el req
                        if($buscar_estado_req == null || $buscar_estado_req == ''){
                            $terminar_req = new EstadosRequerimientos();
                            $terminar_req->fill([
                                "estado"        => config('conf_aplicacion.C_TERMINADO'),
                                "user_gestion"  => $this->user->id,
                                "observaciones" => "Se ha cumplido con todos los candidatos solicitados.",
                                "req_id"        => $ReqId,
                            ]);
                            $terminar_req->save();

                            //Se cambia el estado público del requerimiento
                            $req  = Requerimiento::find($ReqId);
                            $req->estado_publico = 0;
                            $req->save();

                            $candidatos_no_contratados = [];

                            //Consultar candidatos enviados
                            $no_seleccionados = User::join("requerimiento_cantidato", "requerimiento_cantidato.candidato_id", "=", "users.id")
                            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                            ->join("estados", "estados.id", "=", "requerimiento_cantidato.estado_candidato")
                            ->where("requerimiento_cantidato.requerimiento_id", $ReqId)
                            ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
                            ->select(
                                "datos_basicos.*",
                                "estados.id as estado_id",
                                "estados.descripcion as estado_candidatos",
                                "requerimiento_cantidato.estado_candidato",
                                "requerimiento_cantidato.id as req_candidato_id"
                            )
                            ->get();

                            foreach ($no_seleccionados as $key => $candidato_no) {
                                //Valida la contratación cancelada
                                if($candidato_no->estado_candidato != 24){
                                    if ( !in_array($candidato_no->estado_candidato, [config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'), config('conf_aplicacion.C_CONTRATADO')])  ) {
                                        array_push($candidatos_no_contratados, $candidato_no->user_id);
                                    }
                                }
                            }

                            //ACTIVAR CANDIDATOS NO SELECCIONADOS
                            foreach ($candidatos_no_contratados as $key => $user) {
                                $update_user = DatosBasicos::where("user_id", $user)->first();
                                $update_user->fill(["estado_reclutamiento" => config('conf_aplicacion.C_ACTIVO')]);
                                $update_user->save();

                                //ENVIAR MAIL A CANDIDATOS NO CONTRATADOS

                                $nombres = $update_user->nombres .' '. $update_user->primer_apellido;
                                $asunto = "¡Gracias por tu aplicación a la vacante!";
                                $emails = $update_user->email;
                                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                                $mailConfiguration = 1; //Id de la configuración
                            
                                $mailTitle = "¡Gracias por tu aplicación a la vacante!"; //Titulo o tema del correo

                                //Cuerpo con html y comillas dobles para las variables
                                $mailBody = "Estimado(a) $nombres.<br><br>

                                    Te informamos que después del análisis de tu hoja de vida, hemos decidido dar por culminado tu proceso de selección para esta propuesta laboral.<br><br>

                                    Te agradecemos haber dispuesto del tiempo que requerimos, tu compromiso e interés constante. Toda tu información quedará registrada en nuestra base de datos, bajo las directrices de completa confidencialidad. <br><br>

                                    Cordialmente, <br><br>

                                    <i>Equipo de Selección</i>";

                                //Arreglo para el botón
                                $mailButton = ['buttonText' => 'ACCEDER', 'buttonRoute' => route('login')];

                                $mailUser = $update_user->user_id; //Id del usuario al que se le envía el correo

                                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($emails, $asunto) {
                                    $message->to([$emails]);
                                    $message->subject($asunto)
                                    ->getHeaders()
                                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                                });
                            }
                        }
                    }
                }
            }

            //Busca el documento
            $documentos = Documentos::where('numero_id', $candidato->numero_id)
            ->where('user_id', $this->user->id)
            ->where('tipo_documento_id', 16)
            ->where('requerimiento', $ReqId)
            ->first();

            $documentos->descripcion_archivo = 'Contrato firmado virtualmente';
            $documentos->save();

            //firma sin video generar pdf
            $firmaContrato =  FirmaContratos::where('id', $contrato_id)
            ->where('user_id', $this->user->id)
            ->where('req_id', $ReqId)
            ->first();

            $candidato = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
            ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
            ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
            ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
            ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->where("datos_basicos.user_id", $this->user->id)
            ->select(
                "datos_basicos.*",
                "tipo_identificacion.descripcion as dec_tipo_doc",
                "generos.descripcion as genero_desc",
                "estados_civiles.descripcion as estado_civil_des",
                "aspiracion_salarial.descripcion as aspiracion_salarial_des",
                "clases_libretas.descripcion as clases_libretas_des",
                "tipos_vehiculos.descripcion as tipos_vehiculos_des",
                "categorias_licencias.descripcion as categorias_licencias_des",
                "entidades_afp.descripcion as entidades_afp_des",
                "entidades_eps.descripcion as entidades_eps_des"
            )
            ->first();
            
             $fechasContrato = RequerimientoContratoCandidato::where('requerimiento_id', $ReqId)
                ->where('candidato_id', $this->user->id)
                ->select('fecha_ingreso', 'fecha_fin_contrato', 'hora_ingreso', 'atte_carta_presentacion', 'direccion_carta_presentacion')
                ->orderBy('created_at', 'DESC')
                ->first();

             $ciudadexpedicion = null;

                if($candidato != null) {             
                    $ciudadexpedicion = Ciudad::select('nombre')->where("ciudad.cod_pais",$candidato->pais_id)
                        ->where("ciudad.cod_departamento",$candidato->departamento_id)
                        ->where("ciudad.cod_ciudad",$candidato->ciudad_id)
                        ->first();

                    if ($ciudadexpedicion == null) {
                        $ciudadexpedicion = Ciudad::select('nombre')->where("ciudad.cod_pais",$candidato->pais_id)
                            ->where("ciudad.cod_departamento",$candidato->departamento_expedicion_id)
                            ->where("ciudad.cod_ciudad",$candidato->ciudad_expedicion_id)
                            ->first();
                    }
                }


            $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            ->join("tipos_salarios", "tipos_salarios.id", "=", "requerimientos.tipo_salario")
            ->join("tipos_liquidaciones", "tipos_liquidaciones.id", "=", "requerimientos.tipo_liquidacion")
            ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
            ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("tipos_nominas", "tipos_nominas.id", "=", "requerimientos.tipo_nomina")
            ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
            })
            ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
            ->select(
                "cargos_especificos.descripcion",
                "requerimientos.sitio_trabajo as sitio_trabajo",
                "requerimiento_cantidato.created_at",
                "requerimiento_cantidato.requerimiento_id",
                "requerimiento_cantidato.id as requerimiento_cantidato_id",
                "clientes.nombre as cliente_nombre",
                "procesos_candidato_req.fecha_inicio_contrato",
                "procesos_candidato_req.fecha_fin_contrato",
                "procesos_candidato_req.codigo_validacion as token_acceso",
                "requerimientos.salario as salario",
                "requerimientos.funciones as funciones",
                "requerimientos.empresa_contrata as empresa_contrata",
                "cargos_genericos.descripcion as nombre_cargo",
                "cargos_especificos.descripcion as nombre_cargo_especifico",
                "requerimientos.cargo_especifico_id as cargo_req",
                "tipos_nominas.descripcion as nomina_contrato",
                "requerimientos.pais_id as cod_pais",
                "requerimientos.departamento_id as cod_departamento",
                "requerimientos.ciudad_id as cod_ciudad",
                "requerimientos.num_vacantes as numero_vacantes",
                "tipos_salarios.descripcion as tipo_salarios",
                "agencias.descripcion as agencia",
                "agencias.direccion as agencia_direccion",
                "ciudad.nombre as nombre_ciudad",
                "agencias.id as agencia_id",
                "motivo_requerimiento.descripcion as motivo_requerimiento"
            )
            ->where("requerimiento_cantidato.candidato_id", $this->user->id)
            ->where("requerimiento_cantidato.requerimiento_id", $ReqId)
            ->where("procesos_candidato_req.proceso","ENVIO_CONTRATACION")
            ->groupBy('procesos_candidato_req.candidato_id')
            ->orderBy("requerimiento_cantidato.id", "DESC")
            ->first();

            $fechasContrato = RequerimientoContratoCandidato::leftJoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
            ->where('requerimiento_id', $ReqId)
            ->where('candidato_id', $this->user->id)
            ->select(
                'fecha_ingreso',
                'fecha_fin_contrato',
                'entidades_afp.descripcion as entidad_afp',
                'entidades_eps.descripcion as entidad_eps'
                )
            ->orderBy('requerimiento_contrato_candidato.created_at', 'DESC')
            ->first();

            $empresa_contrata = EmpresaLogo::where('id', $reqcandidato->empresa_contrata)->first();

            //Calcular edad de candidatos.
            $edad = ($candidato->fecha_nacimiento != 0 && $candidato->fecha_nacimiento != "") ? Carbon::parse($candidato->fecha_nacimiento)->age : "";

            $lugarnacimiento = null;
            $lugarexpedicion = null;
            $lugarresidencia = null;

            if($candidato != null) {
                $lugarnacimiento = Pais::join("departamentos", function ($join) {
                    $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
                ->where("ciudad.cod_pais",$candidato->pais_nacimiento)
                ->where("ciudad.cod_departamento",$candidato->departamento_nacimiento)
                ->where("ciudad.cod_ciudad", $candidato->ciudad_nacimiento)
                ->first();

                $lugarexpedicion = Pais::join("departamentos", function ($join) {
                    $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                })->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais",$candidato->pais_id)
                ->where("ciudad.cod_departamento",$candidato->departamento_id)
                ->where("ciudad.cod_ciudad",$candidato->ciudad_id)
                ->first();

                $lugarresidencia = Pais::join("departamentos", function ($join) {
                   $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                })->join("ciudad", function ($join2) {
                   $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                })
                ->select(\DB::raw("CONCAT(ciudad.nombre) AS value"))
                ->where("ciudad.cod_pais",$candidato->pais_residencia)
                ->where("ciudad.cod_departamento",$candidato->departamento_residencia)
                ->where("ciudad.cod_ciudad", $candidato->ciudad_residencia)
                ->first();
            }

            //Hash data
            $userIdHash = Crypt::encrypt($this->user->id);
            if ($firmaContrato !== null) {
                $firmaContratoHash = Crypt::encrypt($firmaContrato->id);   
            }

            $foto = null;
            if (Sentinel::check()) {
                $registro = Sentinel::getUser();
                if ($registro->foto_perfil == null) {
                    $foto = null;
                } else {
                    $foto = $registro->foto_perfil;
                }
            }

            $fecha = date("d/m/Y");

            //Agregar clausulas adicionales
            $adicionales = CargoDocumentoAdicional::join("confirmacion_documentos_adicionales","confirmacion_documentos_adicionales.documento_id","=","cargos_documentos_adicionales.adicional_id")
            ->where("cargo_id", $reqcandidato->cargo_req)
            ->where("contrato_id", $contrato_id)
            ->select("confirmacion_documentos_adicionales.*","cargos_documentos_adicionales.*")
            ->get();

            $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("cargos_especificos","cargos_especificos.clt_codigo","=","clientes.id")
            ->leftjoin("empresa_logos", "empresa_logos.id", "=", "requerimientos.empresa_contrata")
            ->where("requerimientos.id", $ReqId)
            ->select(
                "requerimientos.id as req_id",
                "cargos_especificos.descripcion as cargo",
                "clientes.nombre as nombre_cliente",
                "clientes.nit as nit_cliente",
                "clientes.id as cliente_id",
                "requerimientos.id",
                "requerimientos.negocio_id",
                "requerimientos.cargo_especifico_id as cargo_especifico_id",
                "empresa_logos.*"
            )
            ->first();

            $user = User::find($this->user->id);
            $empresa_contrata = '';

            //para firma sin video 
            $firma = $data->firma;

            $view2 = \View::make("home.confirmacion_manual", compact(
                //'userId',
                'ReqId',
                'candidato',
                'firmaContrato',
                'reqcandidato',
                'userIdHash',
                'empresa_contrata',
                'firma',
                'fecha',
                'contratoId',
                'user',
                'requerimiento',
                'fechasContrato'
            ))->render();

            $pdf2 = \App::make('dompdf.wrapper');
            $pdf2->loadHTML($view2);

            //Guarda contrato
            $output2 = $pdf2->output();
            $nombre_documento2 = 'contrato_sin_video_'.$contrato_id.'.pdf';

            file_put_contents('contratos/'.$nombre_documento2, $output2);

             /* para carta de presentacion*/

            $empresa_logo = $requerimiento->logo;

            if ($requerimiento->nombre_empresa == 'Listos' || $requerimiento->nombre_empresa == 'Nodos' || $requerimiento->nombre_empresa == 'Tercerizar') {
                $logo = (isset($requerimiento->logo))?$requerimiento->logo:'';
            } else {
                $logo = '';
            }

            $ciudad_req = null;
            $ciudad_req = Ciudad::select('nombre')->where("ciudad.cod_pais",$requerimiento->pais_id)
                ->where("ciudad.cod_departamento",$requerimiento->departamento_id)
                ->where("ciudad.cod_ciudad",$requerimiento->ciudad_id)
                ->first();

            $dia = date('d', strtotime($fechasContrato->fecha_ingreso));
            $mes = date('n', strtotime($fechasContrato->fecha_ingreso));
            $ano = date('Y', strtotime($fechasContrato->fecha_ingreso));
            $diaSemana = date('N', strtotime($fechasContrato->fecha_ingreso));
            $fecha_firma_replace = $this->dias[$diaSemana].", $dia de ".$this->meses[$mes]." de $ano";

            $qrcode = base64_encode(\QrCode::format('png')->size(200)->errorCorrection('H')->generate(route('informacionTrabajador', ['id' => $this->user->id])));

            $view3 = \SnappyPDF::loadView("home.pdf-carta-presentacion-general",[
                'candidato'=>$candidato,
                'ciudad_req'=>$ciudad_req,
                'ciudadexpedicion'=>$ciudadexpedicion,
                'reqcandidato'=>$reqcandidato,
                'requerimiento'=>$requerimiento,
                'fechasContrato'=>$fechasContrato,
                'fecha_firma_replace'=>$fecha_firma_replace,
                'empresa_logo'=>$empresa_logo,
                'logo'=>$logo,
                'qrcode'=>$qrcode
            ])
            ->output();

            //Guarda carta
            $nombre_documento = 'carta_presentacion_'.$ReqId.'_'.$this->user->id.'.pdf';

            Storage::disk('public')->put('recursos_carta_presentacion/'.$nombre_documento,$view3);

            //Crea el documento
            $documentos = new Documentos();
            $documentos->fill([
                "numero_id" => $candidato->numero_id,
                "user_id" => $this->user->id,
                "tipo_documento_id" => 30,
                "nombre_archivo" => $nombre_documento,
                "gestiono" => $this->user->id,
                "requerimiento" => $ReqId,
                "descripcion_archivo" => 'Carta de Presentación.',
            ]);
            $documentos->save();
            //fin de la carta de presentación


            //Notificacion ejecutivo de Cuentas
            $this->notificacionEjecutivoCuentas($this->user->id, $ReqId, $contrato_id);

            //Envío de correo
            $this->notificaContratacion(
                $ReqId,
                $usuario_envio,
                $candidato,
                $reqcandidato->nombre_cargo_especifico,
                $reqcandidato->cliente_nombre,
                $reqcandidato->sitio_trabajo,
                $reqcandidato->cliente_id,
                $reqcandidato->cod_pais,
                $reqcandidato->cod_departamento,
                $reqcandidato->cod_ciudad,
                $reqcandidato->agencia_id
            );

            if ( $sitioModulo->afiliaciones == 'enabled' ) {
                $es_cliente_prueba = false;

                if ($sitio->filtro_cliente == 'enabled' && $sitio->clientes_prueba_id != null && $sitio->clientes_prueba_id != '') {
                    $ids_clientes_prueba = explode(",", $sitio->clientes_prueba_id);

                    if (in_array($requerimiento->cliente_id, $ids_clientes_prueba)) {
                        $es_cliente_prueba = true;
                    }
                }

                if (!$es_cliente_prueba) {
                    //Sino es cliente de prueba se envia la notificacion de Afiliaciones
                    $this->notificaContratacionRolAfiliaciones(
                        $ReqId,
                        $candidato,
                        $reqcandidato->requerimiento_cantidato_id,
                        $reqcandidato->nombre_cargo_especifico,
                        $reqcandidato->cliente_nombre,
                        $reqcandidato->sitio_trabajo,
                        $firmaContrato->fecha_firma
                    );
                }
            }


            $controll= new ReclutamientoController();
            $carnet=$controll->generar_carnet_general($this->user->id,1);
            Storage::disk('public')->put('documentos_candidatos/'.$candidato->numero_id.'/'.$ReqId.'/contratacion/CARNET_CONTRATADO.pdf',$carnet);

        return response()->json(["success" => true]);
    }

    /*
    *   Cancela el contrato con observación del usuario
    */
    public function cancelar_contratacion_candidato(Request $data)
    {
        $contrato_id = $data->contrato_id;
        $user_id = $data->user_id;
        $req_id = $data->req_id;

        //Crear registro de cancelación
        $contrato_cancelado = new ContratoCancelado();
        $contrato_cancelado->fill([
            'user_id' => $user_id,
            'req_id' => $req_id,
            'contrato_id' => $contrato_id,
            'observacion' => $data->observacion,
            'ip' => $data->ip(),
        ]);
        $contrato_cancelado->save();

        //Actualiza firma de contrato
        $firma_contrato = FirmaContratos::where('id', $contrato_id)
        ->where('user_id', $user_id)
        ->where('req_id', $req_id)
        ->first();

        $firma_contrato->terminado = 0;
        $firma_contrato->gestion = $this->user->id;
        $firma_contrato->save();

        //Cambia estado del proceso del candidato
        $aptoProceso = RegistroProceso::where('requerimiento_id', $req_id)
        ->where('candidato_id', $this->user->id)
        ->where('proceso', 'ENVIO_CONTRATACION')
        ->orderby('created_at', 'DESC')
        ->first();

        $aptoProceso->apto = 0;
        $aptoProceso->save();

        //Crea nuevo estado
        $nuevo_estado = ReqCandidato::where("requerimiento_id", $req_id)
        ->where("candidato_id", $this->user->id)
        ->orderBy("id", "DESC")
        ->first();

        $nuevo_estado->estado_candidato = 24;
        $nuevo_estado->save();

        //Crea nuevo proceso
        $nuevo_proceso = new RegistroProceso();
        $nuevo_proceso->fill([
            'requerimiento_candidato_id' => $nuevo_estado->id,
            'estado'                     => config('conf_aplicacion.C_CONTRATACION_CANCELADA'),
            'fecha_inicio'               => date("Y-m-d H:i:s"),
            'usuario_envio'              => $this->user->id,
            'requerimiento_id'           => $req_id,
            'candidato_id'               => $this->user->id,
            'observaciones'              => $data->observacion,
            'proceso'                    => "CANCELA_CONTRATACION",
            'apto'                       => 1
        ]);
        $nuevo_proceso->save();

        $usuario_envio = User::where('id', $aptoProceso->usuario_envio)->first();

        $candidato = DatosBasicos::where('user_id', $user_id)->first();

        //Envío de correo
        $this->notificaContratacionCancelada(
            $req_id,
            $usuario_envio,
            $candidato
        );

        return response()->json([
            'success' => true
        ]);
    }

    /*
    *   Anular el contrato
    */
    public function anular_contratacion_candidato(Request $data)
    {
        $user_id = $data->user_id;
        $req_id = $data->req_id;
        $sitio_modulo = SitioModulo::first();

        //Actualiza firma de contrato, lo anula
        $firma_contrato = FirmaContratos::where('user_id', $user_id)
        ->where('req_id', $req_id)
        ->orderBy('created_at', 'DESC')
        ->first();

        $firma_contrato->estado = 0;
        $firma_contrato->gestion = $this->user->id;
        $firma_contrato->save();

        //Cambia estado del proceso del candidato
        $aptoProceso = RegistroProceso::where('requerimiento_id', $req_id)
        ->where('candidato_id', $user_id)
        ->whereIn('proceso', ['ENVIO_CONTRATACION', 'FIRMA_VIRTUAL_SIN_VIDEOS', 'FIN_CONTRATACION_VIRTUAL', 'FIRMA_CONF_MAN', 'FIN_CONTRATACION_MANUAL'])
        ->orderby('created_at', 'DESC')
        ->get();

        //No apto en los procesos de firma
        foreach ($aptoProceso as $proceso) {
            $proceso->apto = 0;
            $proceso->save();
        }


        //Actualiza estado - CANCELACIÓN
        $nuevo_estado = ReqCandidato::where("requerimiento_id", $req_id)
        ->where("candidato_id", $user_id)
        ->orderBy("id", "DESC")
        ->first();

        $nuevo_estado->estado_candidato = 24;
        $nuevo_estado->save();

        //Crea nuevo proceso de anulación
        $nuevo_proceso = new RegistroProceso();
        $nuevo_proceso->fill([
            'requerimiento_candidato_id' => $nuevo_estado->id,
            'estado'                     => config('conf_aplicacion.C_CONTRATACION_CANCELADA'),
            'fecha_inicio'               => date("Y-m-d H:i:s"),
            'usuario_envio'              => $this->user->id,
            'requerimiento_id'           => $req_id,
            'candidato_id'               => $user_id,
            'observaciones'              => $data->observacion,
            'proceso'                    => "CONTRATO_ANULADO",
            'motivo_rechazo_id'          => $data->motivo_anulacion,
            'apto'                       => 1
        ]);
        $nuevo_proceso->save();

        //buscamos documentos medicos para resetear para que vuelva a aparecer la clausula si vuelve
        //a contratar en el mismo req
        if ($sitio_modulo->clausula_medica == 'enabled') {
            if ($sitio_modulo->salud_ocupacional == 'si') {
                
                $requerimiento_candidato_orden = OrdenMedica::where('req_can_id', $nuevo_estado->id)
                ->orderBy('created_at', 'DESC')
                ->first();

                //Actualiza el estado de la firma en la orden
                if( $requerimiento_candidato_orden != null ){

                    $requerimiento_candidato_orden->aceptada = null;
                    $requerimiento_candidato_orden->save();
                }

            }else{

                $documentos_medicos_clausula = Documentos::where('user_id', $user_id)
                            ->where('requerimiento', $req_id)
                            ->where('tipo_documento_id', 8)
                            ->whereIn('resultado', [3,4])
                        ->get();

                foreach ($documentos_medicos_clausula as $doc) {
                    $doc->aceptada = null;
                    $doc->save();
                }
            }
        }

        error_reporting(E_ALL ^ E_DEPRECATED); //para versiones de php anteriores o posteriores

        //Busca información para construir PDF
        $firmaContrato =  FirmaContratos::where('id', $firma_contrato->id)
        ->where('user_id', $user_id)
        ->where('req_id', $req_id)
        ->first();

        $candidato = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
        ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
        ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
        ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
        ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
        ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
        ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
        ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
        ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
        ->where("datos_basicos.user_id", $user_id)
        ->select(
            "datos_basicos.*",
            "tipo_identificacion.descripcion as dec_tipo_doc",
            "generos.descripcion as genero_desc",
            "estados_civiles.descripcion as estado_civil_des",
            "aspiracion_salarial.descripcion as aspiracion_salarial_des",
            "clases_libretas.descripcion as clases_libretas_des",
            "tipos_vehiculos.descripcion as tipos_vehiculos_des",
            "categorias_licencias.descripcion as categorias_licencias_des",
            "entidades_afp.descripcion as entidades_afp_des",
            "entidades_eps.descripcion as entidades_eps_des"
        )
        ->first();

        $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("tipos_salarios", "tipos_salarios.id", "=", "requerimientos.tipo_salario")
        ->join("tipos_liquidaciones", "tipos_liquidaciones.id", "=", "requerimientos.tipo_liquidacion")
        ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
        ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
        ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join("tipos_nominas", "tipos_nominas.id", "=", "requerimientos.tipo_nomina")
        ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
            ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
        ->select(
            "cargos_especificos.descripcion",
            "requerimientos.sitio_trabajo as sitio_trabajo",
            "requerimiento_cantidato.created_at",
            "requerimiento_cantidato.requerimiento_id",
            "requerimiento_cantidato.id as requerimiento_cantidato_id",
            "clientes.nombre as cliente_nombre",
            "clientes.id as cliente_id",
            "procesos_candidato_req.fecha_inicio_contrato",
            "procesos_candidato_req.fecha_fin_contrato",
            "procesos_candidato_req.codigo_validacion as token_acceso",
            "requerimientos.salario as salario",
            "requerimientos.funciones as funciones",
            "requerimientos.empresa_contrata as empresa_contrata",
            "cargos_genericos.descripcion as nombre_cargo",
            "cargos_especificos.descripcion as nombre_cargo_especifico",
            "requerimientos.cargo_especifico_id as cargo_req",
            "tipos_nominas.descripcion as nomina_contrato",
            "requerimientos.pais_id as cod_pais",
            "requerimientos.departamento_id as cod_departamento",
            "requerimientos.ciudad_id as cod_ciudad",
            "requerimientos.num_vacantes as numero_vacantes",
            "tipos_salarios.descripcion as tipo_salarios",
            "agencias.descripcion as agencia",
            "agencias.direccion as agencia_direccion",
            "ciudad.nombre as nombre_ciudad",
            "agencias.id as agencia_id",
            "motivo_requerimiento.descripcion as motivo_requerimiento"
        )
        ->where("requerimiento_cantidato.candidato_id", $user_id)
        ->where("requerimiento_cantidato.requerimiento_id", $req_id)
        ->where("procesos_candidato_req.proceso","ENVIO_CONTRATACION")
        ->groupBy('procesos_candidato_req.candidato_id')
        ->orderBy("requerimiento_cantidato.id", "DESC")
        ->first();

        $fechasContrato = RequerimientoContratoCandidato::leftJoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
        ->leftJoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
        ->where('requerimiento_id', $req_id)
        ->where('candidato_id', $user_id)
        ->select(
            'fecha_ingreso',
            'fecha_fin_contrato',
            'entidades_afp.descripcion as entidad_afp',
            'entidades_eps.descripcion as entidad_eps'
            )
        ->orderBy('requerimiento_contrato_candidato.created_at', 'DESC')
        ->first();

        $empresa_contrata = EmpresaLogo::where('id', $reqcandidato->empresa_contrata)->first();

        //Calcular edad de candidatos.
        $edad = ($candidato->fecha_nacimiento != 0 && $candidato->fecha_nacimiento != "") ? Carbon::parse($candidato->fecha_nacimiento)->age : "";

        $lugarnacimiento = null;
        $lugarexpedicion = null;
        $lugarresidencia = null;

        if($candidato != null) {
            $lugarnacimiento = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais",$candidato->pais_nacimiento)
            ->where("ciudad.cod_departamento",$candidato->departamento_nacimiento)
            ->where("ciudad.cod_ciudad", $candidato->ciudad_nacimiento)
            ->first();

            $lugarexpedicion = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais",$candidato->pais_id)
            ->where("ciudad.cod_departamento",$candidato->departamento_id)
            ->where("ciudad.cod_ciudad",$candidato->ciudad_id)
            ->first();

            $lugarresidencia = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select(\DB::raw("CONCAT(ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais",$candidato->pais_residencia)
            ->where("ciudad.cod_departamento",$candidato->departamento_residencia)
            ->where("ciudad.cod_ciudad", $candidato->ciudad_residencia)
            ->first();
        }

        //Hash data
        $userIdHash = Crypt::encrypt($this->user->id);

        if ($firmaContrato !== null) {
            $firmaContratoHash = Crypt::encrypt($firmaContrato->id);   
        }

        $foto = null;

        if (Sentinel::check()) {
            $registro = Sentinel::getUser();

            if ($registro->foto_perfil == null) {
                $foto = null;
            } else {
                $foto = $registro->foto_perfil;
            }
        }

        $fecha = date("d/m/Y");

        //Agregar clausulas adicionales
        $adicionales = CargoDocumentoAdicional::join("confirmacion_documentos_adicionales", "confirmacion_documentos_adicionales.documento_id", "=", "cargos_documentos_adicionales.adicional_id")
        ->where("cargo_id", $reqcandidato->cargo_req)
        ->where("contrato_id", $firma_contrato->id)
        ->select(
            "confirmacion_documentos_adicionales.*",
            "cargos_documentos_adicionales.*"
        )
        ->get();

        $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join("cargos_especificos", "cargos_especificos.clt_codigo", "=", "clientes.id")
        ->leftjoin("empresa_logos", "empresa_logos.id", "=", "requerimientos.empresa_contrata")
        ->where("requerimientos.id", $req_id)
        ->select(
            "requerimientos.id as req_id",
            "cargos_especificos.descripcion as cargo",
            "clientes.nombre as nombre_cliente",
            "clientes.nit as nit_cliente",
            "requerimientos.id",
            "requerimientos.negocio_id",
            "requerimientos.cargo_especifico_id as cargo_especifico_id",
            "empresa_logos.*"
        )
        ->first();

        //Genera código unico universal para el contrato
        $codigo_unico = Uuid::generate();

        $user = User::find($user_id);

        $anulado = true;

        $userId = $user_id;

        $view = \SnappyPDF::loadView("home.pdf-contrato-firmar",[
            'userId'=>$userId,
            'req_id'=>$req_id,
            'candidato'=>$candidato,
            'firmaContrato'=>$firmaContrato,
            'lugarnacimiento'=>$lugarnacimiento,
            'lugarexpedicion'=>$lugarexpedicion,
            'lugarresidencia'=>$lugarresidencia,
            'reqcandidato'=>$reqcandidato,
            'userIdHash'=>$userIdHash,
            'firmaContratoHash'=>$firmaContratoHash,
            'fecha'=>$fecha,
            'empresa_contrata'=>$empresa_contrata,
            'user'=>$user,
            'requerimiento'=>$requerimiento,
            'adicionales'=>$adicionales,
            'foto'=>$foto,
            'fechasContrato'=>$fechasContrato,
            'codigo_unico'=>$codigo_unico,
            'anulado'=>$anulado
        ])
        ->output();

        //$pdf  = \App::make('dompdf.wrapper');
        //$pdf->loadHTML($view);

        //Guarda contrato
        //$output = $pdf->output();
        $nombre_documento = 'contrato_anulado'. $req_id . '_' . $user_id .'.pdf';

        //Crear registro de anulación
        $contrato_anulado = new ContratoCancelado();
        $contrato_anulado->fill([
            'user_id' => $user_id,
            'req_id' => $req_id,
            'contrato_id' => $firmaContrato->id,
            'observacion' => 'Contrato anulado',
            'ip' => $data->ip(),
            'documento' => $nombre_documento,
            'uuid' => $codigo_unico,
            'base_64' => base64_encode($view),
            'motivo_anulado'    => $data->motivo_anulacion,
            'contrato_anulado'  => 1
        ]);
        

        //file_put_contents('contratos_anulados/'.$nombre_documento, $output);
        Storage::disk('public')->put('contratos_anulados/'.$nombre_documento,$view);
        $contrato_anulado->hash = hash_file('sha256','contratos_anulados/'.$nombre_documento);
        $contrato_anulado->save();

        //Validar estado requerimiento
        $estadoReq = EstadosRequerimientos::where("req_id", $req_id)
        ->where('estado', config('conf_aplicacion.C_TERMINADO'))
        ->get();

        if($estadoReq->count() > 0){
            foreach($estadoReq as $er){
                $er->delete();
            }

            //Reabre requerimiento
            $abrir_req = new EstadosRequerimientos();
            $abrir_req->fill([
                "estado"        => config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                "user_gestion"  => $this->user->id,
                "observaciones" => "Se reabre requerimiento para reenvío a contratar.",
                "req_id"        => $req_id,
            ]);
            $abrir_req->save();
        }

        //Notifica afiliaciones el contrato anulado
        if ( $sitio_modulo->afiliaciones == 'enabled' ) {
            $this->notificaContratoAnuladoRolAfiliaciones(
                $req_id,
                $candidato,
                $reqcandidato->requerimiento_cantidato_id,
                $reqcandidato->nombre_cargo_especifico,
                $reqcandidato->cliente_nombre,
                $reqcandidato->sitio_trabajo,
                $nuevo_proceso->fecha_inicio
            );
        }

        if($data->motivo_anulacion == 1){
            return response()->json([
                'success' => true,
                'reenviar' => true
            ]);
        }

        return response()->json([
            'success' => true,
            'reenviar' => true
        ]);
    }

    /*
    *   Generar contrato en PDF para descarga o envío por correo electrónico
    */
    public function generateContract(Request $data, $user_id, $req_id, $email = null)
    {
        error_reporting(E_ALL ^ E_DEPRECATED);

        $sitio = Sitio::first();
        $sitio_modulo = SitioModulo::first();
        $user = User::find($user_id);
        $fecha = date("d/m/Y");
        $foto = null;
        $firmaContrato = null;
        $empresa_contrata = null;
        $adicionales = null;

        $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
        ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
        ->select(
            'requerimientos.*',
            'clientes.direccion as direccion_cliente',
            'clientes.telefono as telefono_cliente'
        )
        ->find($req_id);

        $candidato = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
        ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
        ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
        ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
        ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
        ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
        ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
        ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
        ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
        ->where("datos_basicos.user_id", $user_id)
        ->select(
            "datos_basicos.*",
            "tipo_identificacion.descripcion as dec_tipo_doc",
            "generos.descripcion as genero_desc",
            "estados_civiles.descripcion as estado_civil_des",
            "aspiracion_salarial.descripcion as aspiracion_salarial_des",
            "clases_libretas.descripcion as clases_libretas_des",
            "tipos_vehiculos.descripcion as tipos_vehiculos_des",
            "categorias_licencias.descripcion as categorias_licencias_des",
            "entidades_afp.descripcion as entidades_afp_des",
            "entidades_eps.descripcion as entidades_eps_des"
        )
        ->first();

        $reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
        ->join("tipos_salarios", "tipos_salarios.id", "=", "requerimientos.tipo_salario")
        ->join("tipos_liquidaciones", "tipos_liquidaciones.id", "=", "requerimientos.tipo_liquidacion")
        ->join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
        ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
        ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join("tipos_nominas", "tipos_nominas.id", "=", "requerimientos.tipo_nomina")
        ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
            ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
        ->select(
            "cargos_especificos.descripcion",
            "requerimientos.sitio_trabajo as sitio_trabajo",
            "requerimiento_cantidato.created_at",
            "requerimiento_cantidato.requerimiento_id",
            "requerimiento_cantidato.id as requerimiento_cantidato_id",
            "clientes.nombre as cliente_nombre",
            "procesos_candidato_req.fecha_inicio_contrato",
            "procesos_candidato_req.fecha_fin_contrato",
            "procesos_candidato_req.codigo_validacion as token_acceso",
            "requerimientos.salario as salario",
            "requerimientos.adicionales_salariales as adicionales_salariales",
            "requerimientos.termino_inicial_contrato",
            "tipos_salarios.descripcion as descripcion_tipo_salario",
            "tipos_liquidaciones.descripcion as descripcion_tipo_liquidacion",
            "requerimientos.funciones as funciones",
            "cargos_genericos.descripcion as nombre_cargo",
            "cargos_especificos.descripcion as nombre_cargo_especifico",
            "requerimientos.empresa_contrata as empresa_contrata",
            "requerimientos.cargo_especifico_id as cargo_req",
            "tipos_nominas.descripcion as nomina_contrato",
            "agencias.descripcion as agencia",
            "agencias.direccion as agencia_direccion",
            "ciudad.nombre as nombre_ciudad",
            "motivo_requerimiento.descripcion as motivo_requerimiento"
        )
        ->where("requerimiento_cantidato.candidato_id", $user_id)
        ->where("requerimiento_cantidato.requerimiento_id", $req_id)
        ->whereIn("procesos_candidato_req.proceso", ["ENVIO_CONTRATACION", "PRE_CONTRATAR"])
        ->groupBy('procesos_candidato_req.candidato_id')
        ->orderBy("requerimiento_cantidato.id", "DESC")
        ->first();

        $fechasContrato = RequerimientoContratoCandidato::leftJoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
        ->leftJoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
        ->where('requerimiento_id', $req_id)
        ->where('candidato_id', $user_id)
        ->select(
            'fecha_ingreso',
            'fecha_fin_contrato',
            'entidades_afp.descripcion as entidad_afp',
            'entidades_eps.descripcion as entidad_eps'
        )
        ->orderBy('requerimiento_contrato_candidato.created_at', 'DESC')
        ->first();

        //Calcular edad de candidatos.
        $edad = ($candidato->fecha_nacimiento != 0 && $candidato->fecha_nacimiento != "") ? Carbon::parse($candidato->fecha_nacimiento)->age : "";

        $lugarnacimiento = null;
        $lugarexpedicion = null;
        $lugarresidencia = null;

        if($candidato != null) {
            $lugarnacimiento = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")
                ->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $candidato->pais_nacimiento)
            ->where("ciudad.cod_departamento", $candidato->departamento_nacimiento)
            ->where("ciudad.cod_ciudad", $candidato->ciudad_nacimiento)
            ->first();

            $lugarexpedicion = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")
                ->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $candidato->pais_id)
            ->where("ciudad.cod_departamento", $candidato->departamento_id)
            ->where("ciudad.cod_ciudad", $candidato->ciudad_id)
            ->first();

            $lugarresidencia = Pais::join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")
                ->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select(\DB::raw("CONCAT(ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $candidato->pais_residencia)
            ->where("ciudad.cod_departamento", $candidato->departamento_residencia)
            ->where("ciudad.cod_ciudad", $candidato->ciudad_residencia)
            ->first();
        }

        $mostrar_firma = 'SI';
        $mostrar_adicionales = 'SI';
        $adicionales_creadas = null;
        $replace = null;
        $datos = null;
        $contrato_fotos = [];
        $requerimiento_candidato_orden_pdf = null;
        $lugarexpedicion_medica = null;
        $adicional_externo = null;

        if (!empty($reqcandidato)) {
            $reqcandidato_clausulas = $reqcandidato;
        } else {
            $reqcandidato_clausulas = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
                ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
                ->join("ciudad", function ($join2) {
                    $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                    ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                    ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
                })
                ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
                ->select(
                    "agencias.descripcion as agencia",
                    "cargos_especificos.descripcion as nombre_cargo_especifico",
                    "ciudad.nombre as nombre_ciudad",
                    "clientes.nombre as cliente_nombre",
                    "requerimiento_cantidato.requerimiento_id",
                    "requerimiento_cantidato.id as requerimiento_cantidato_id",
                    "requerimientos.empresa_contrata as empresa_contrata",
                    "requerimientos.cargo_especifico_id as cargo_req"
                )
                ->where("requerimiento_cantidato.candidato_id", $user_id)
                ->where("requerimiento_cantidato.requerimiento_id", $req_id)
                ->orderBy("requerimiento_cantidato.id", "DESC")
            ->first();

            $reqcandidato = $reqcandidato_clausulas;
        }

        //Agregar clausulas
        if (!empty($reqcandidato_clausulas) && $mostrar_adicionales === 'SI') {
            $adicionales = CargoDocumentoAdicional::join("documentos_adicionales_contrato", "documentos_adicionales_contrato.id", "=", "cargos_documentos_adicionales.adicional_id")
                ->where("cargo_id", $reqcandidato_clausulas->cargo_req)
                ->where("cargos_documentos_adicionales.active", 1)
                ->where("documentos_adicionales_contrato.creada", 0)
                ->where("documentos_adicionales_contrato.active", 1)
            ->get();

            if ($sitio_modulo->clausula_medica == 'enabled') {
                if ($sitio_modulo->salud_ocupacional == 'si') {
                    $requerimiento_candidato_orden_pdf = OrdenMedica::where('req_can_id', $reqcandidato_clausulas->requerimiento_cantidato_id)
                        ->orderBy('created_at', 'DESC')
                    ->first();

                    if($requerimiento_candidato_orden_pdf != null && $requerimiento_candidato_orden_pdf != ''){
                        if($requerimiento_candidato_orden_pdf->especificacion != null && $requerimiento_candidato_orden_pdf->especificacion != ''){
                            $adicional_externo = collect(array('firma' => null));
                            $adicional_externo->firma = null;
                            $estados_ordenes = $requerimiento_candidato_orden_pdf->estados;
                            $restricciones_recomendaciones = $estados_ordenes->where('estado_id', '2')->first();
                            if ($restricciones_recomendaciones == null) {
                                $requerimiento_candidato_orden_pdf = null;
                                $adicional_externo = null;
                            }

                            $lugarexpedicion_medica = Pais::join("departamentos", function ($join) {
                                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                            })->join("ciudad", function ($join2) {
                                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                            })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais",$candidato->pais_id)
                            ->where("ciudad.cod_departamento",$candidato->departamento_expedicion_id)
                            ->where("ciudad.cod_ciudad",$candidato->ciudad_expedicion_id)
                            ->first();
                        }
                    }
                } else {
                    $documentos_medicos = Documentos::where('user_id', $user_id)
                        ->where('requerimiento', $req_id)
                        ->where('tipo_documento_id', 8)
                        ->whereIn('resultado', [3,4])
                    ->get();

                    if (count($documentos_medicos) > 0) {
                        $adicional_externo = $documentos_medicos;
                        $adicional_externo->firma = null;
                        //Solo se instancia el objeto, no se guarda..
                        $requerimiento_candidato_orden_pdf = new OrdenMedica();
                        $requerimiento_candidato_orden_pdf->especificacion = '<ul>';
                        foreach ($documentos_medicos as $doc) {
                            $requerimiento_candidato_orden_pdf->especificacion .= "<li>$doc->observacion</li>";
                        }
                        $requerimiento_candidato_orden_pdf->especificacion .= '</ul>';

                        $lugarexpedicion_medica = Pais::join("departamentos", function ($join) {
                            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
                        })->join("ciudad", function ($join2) {
                            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
                        })->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))->where("ciudad.cod_pais",$candidato->pais_id)
                        ->where("ciudad.cod_departamento",$candidato->departamento_expedicion_id)
                        ->where("ciudad.cod_ciudad",$candidato->ciudad_expedicion_id)
                        ->first();
                    }
                }
            }

            //Agregar clausulas creadas en la instancia
            $adicionales_creadas = CargoDocumentoAdicional::join("documentos_adicionales_contrato", "documentos_adicionales_contrato.id", "=", "cargos_documentos_adicionales.adicional_id")
            ->where("cargo_id", $reqcandidato_clausulas->cargo_req)
            ->where("cargos_documentos_adicionales.active", 1)
            ->where("documentos_adicionales_contrato.creada", 1)
            ->where("documentos_adicionales_contrato.active", 1)
            ->orderBy('documentos_adicionales_contrato.id', 'ASC')
            ->get();

            if (count($adicionales_creadas) > 0) {
                $dia = date('d');
                $mes = date('n');
                $ano = date('Y');
                $fecha_firma_replace = "$dia de ".$this->meses[$mes]." de $ano";

                $datos = $candidato;

                if (isset($fechasContrato) && isset($fechasContrato->fecha_ingreso)) {
                    $fecha_ingreso_replace = explode("-", $fechasContrato->fecha_ingreso);

                    $dia_ingreso = $fecha_ingreso_replace[2];
                    $mes_ingreso = (int)$fecha_ingreso_replace[1];
                    $año_ingreso = $fecha_ingreso_replace[0];

                    $fecha_ingreso_replace = "$dia_ingreso de ".$this->meses[$mes_ingreso]." de $año_ingreso";
                } else {
                    $fecha_ingreso_replace = "$dia de ".$this->meses[$mes]." de $ano";
                }

                $tipo_documento = 'Nro. documento';
                $identificacion = $candidato->getTipoIdentificacion;
                if (!empty($identificacion)) {
                    $tipo_documento = mb_strtolower($identificacion->descripcion);
                }

                $ciudad_oferta = $reqcandidato_clausulas->nombre_ciudad;
                $ciudad_contrato = $reqcandidato_clausulas->agencia;

                // $valor_variable = 0;

                $empresa_contrata_generador = EmpresaLogo::where('id', $reqcandidato->empresa_contrata)->first();

                $salario_asignado_generador = "$".number_format($reqcandidato->salario);

                $replace = [
                    $candidato->fullname(),
                    $candidato->nombres,
                    $candidato->primer_apellido,
                    $candidato->segundo_apellido,
                    $candidato->numero_id,
                    $datos->direccion,
                    $candidato->telefono_movil,
                    $fecha_firma_replace,
                    $fecha_ingreso_replace,
                    $reqcandidato_clausulas->nombre_cargo_especifico,
                    $reqcandidato_clausulas->cliente_nombre,
                    $tipo_documento,
                    $ciudad_oferta,
                    $ciudad_contrato,
                    // $valor_variable,
                    $empresa_contrata_generador->nombre_empresa,
                    $salario_asignado_generador
                ];
            }
        }

        $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join("cargos_especificos","cargos_especificos.clt_codigo","=","clientes.id")
        ->where("requerimientos.id", $req_id)
        ->select(
            "requerimientos.id as req_id",
            "cargos_especificos.descripcion as cargo",
            "clientes.nombre as nombre_cliente",
            "clientes.nit as nit_cliente",
            "requerimientos.id",
            "requerimientos.negocio_id",
            "requerimientos.cargo_especifico_id as cargo_especifico_id"
        )
        ->first();

        //Buscar información del requerimiento, sin información del candidato
        $requerimiento_informacion = Requerimiento::join("tipos_salarios", "tipos_salarios.id", "=", "requerimientos.tipo_salario")
        ->join("tipos_liquidaciones", "tipos_liquidaciones.id", "=", "requerimientos.tipo_liquidacion")
        ->join("tipos_nominas", "tipos_nominas.id", "=", "requerimientos.tipo_nomina")
        ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
            ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
        ->select(
            "cargos_especificos.descripcion as nombre_cargo_especifico",
            "cargos_genericos.descripcion as nombre_cargo",

            "clientes.nombre as cliente_nombre",

            "requerimientos.sitio_trabajo as sitio_trabajo",
            "requerimientos.salario as salario",
            "requerimientos.adicionales_salariales as adicionales_salariales",
            "requerimientos.termino_inicial_contrato",
            "requerimientos.funciones as funciones",
            "requerimientos.empresa_contrata as empresa_contrata",
            "requerimientos.cargo_especifico_id as cargo_req",

            "tipos_salarios.descripcion as descripcion_tipo_salario",
            "tipos_liquidaciones.descripcion as descripcion_tipo_liquidacion",
            "tipos_nominas.descripcion as nomina_contrato",

            "agencias.descripcion as agencia",
            "agencias.direccion as agencia_direccion",

            "ciudad.nombre as nombre_ciudad",
            "motivo_requerimiento.descripcion as motivo_requerimiento"
        )
        ->where("requerimientos.id", $req_id)
        ->first();

        //Empresa contrata
        
            if (!empty($reqcandidato)) {
                $empresa_contrata = EmpresaLogo::where('id', $reqcandidato->empresa_contrata)->first();
            } elseif(!empty($requerimiento_informacion)) {
                $empresa_contrata = EmpresaLogo::where('id', $requerimiento_informacion->empresa_contrata)->first();
            }
    
        $userId = $user_id;
        $requerimiento = $requerimiento_informacion;

        if($sitio->multiple_empresa_contrato){
            $cuerpo_contrato = DB::table('empresa_tipo_contrato')
            ->where("empresa_id", $empresa_contrata->id)
            ->where('tipo_contrato_id', $requerimientos->tipo_contrato_id)
            ->first();

            $tipo_contrato = TipoContrato::find($requerimientos->tipo_contrato_id);

            if ($candidato != null && $tipo_contrato != null && $tipo_contrato->id == 5) {
                $req_contrato_candidato = RequerimientoContratoCandidato::join("bancos", "bancos.id", "=", "requerimiento_contrato_candidato.nombre_banco")
                ->select(
                    'requerimiento_contrato_candidato.tipo_cuenta',
                    'requerimiento_contrato_candidato.numero_cuenta',
                    'bancos.nombre_banco as banco'
                )
                ->where("candidato_id", $user_id)
                ->where("requerimiento_id", $requerimientos->id)
                ->first();
            }else{
                $req_contrato_candidato = null;
            }

            $meses = $this->meses;
            $dias_semana = $this->dias_semana;

            $view = view("contratos.pdf.".$tipo_contrato->modelo_contrato, compact(
                'mostrar_firma',
                'mostrar_adicionales',
                'adicionales',
                'adicionales_creadas',
                'user',
                'requerimiento',
                'replace',
                'datos',
                'contrato_fotos',
                'user_id',
                'req_id',
                'userId',
                'candidato',
                'firmaContrato',
                'lugarnacimiento',
                'lugarexpedicion',
                'lugarresidencia',
                'reqcandidato',
                'fecha',
                'foto',
                'empresa_contrata',
                'fechasContrato',
                'sitio',
                'cuerpo_contrato',
                'req_contrato_candidato',
                'meses',
                'dias_semana',
                'requerimiento_informacion',
                'requerimiento_candidato_orden_pdf',
                'adicional_externo',
                'lugarexpedicion_medica',
                'edad'
            ));
        }else {
            $view = view("home.pdf-contrato-firmar", compact(
                'mostrar_firma',
                'mostrar_adicionales',
                'adicionales',
                'adicionales_creadas',
                'user',
                'requerimiento',
                'replace',
                'datos',
                'contrato_fotos',
                'userId',
                'user_id',
                'req_id',
                'candidato',
                'firmaContrato',
                'lugarnacimiento',
                'lugarexpedicion',
                'lugarresidencia',
                'reqcandidato',
                'fecha',
                'empresa_contrata',
                'requerimiento_informacion',
                'requerimiento_candidato_orden_pdf',
                'adicional_externo',
                'lugarexpedicion_medica',
                'foto',
                'fechasContrato'
            ));
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($view);

        if($email != null) {
            //Enviar contrato por email al candidato
            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Contrato por firmar"; //Titulo o tema del correo

            //Cuerpo con html y comillas dobles para las variables
            $mailBody = "
                     Hola {$candidato->nombres} {$candidato->primer_apellido} {$candidato->segundo_apellido}, te hemos enviado el contrato adjunto a este correo correspondiente al proceso de selección en el que estás participando, por favor imprímelo y sigue las instrucciones del analista de selección que está llevando tu proceso.";

            //Arreglo para el botón
            $mailButton = [];

            $mailUser = $candidato->user_id; //Id del usuario al que se le envía el correo

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            
            if($candidato->email != null && $candidato->email != "") {
                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($candidato, $pdf) {

                        $message->to([$candidato->email], 'T3RS');
                        $message->subject("Contrato por firmar")
                        ->attachData($pdf->output(), 'contrato.pdf')
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

                return redirect()->back()->with('success', 'Contrato enviado correctamente.')->with("errores_array", ['Contrato enviado al candidato con éxito.']);
            }else {
                return redirect()->back()->with('mensaje_error', 'Correo no enviado, problema con dirección de correo del candidato.');
            }
        }else if($data->has('preview')){
            //Previsualizar el contrato
            return $pdf->stream('preview-contrato.pdf');
        }else {
            //Descargar el contrato
            return $pdf->download('contrato.pdf');
        }
    }

    /*
    *   Guardar fotos tomadas en el proceso
    */
    public function guardar_fotos(Request $data)
    {
        $contrato_id = $data->contratoId;
        $user_id = $data->userId;
        $req_id = $data->reqId;

        //Fotos
        $firmaImagenes = json_decode($data->firmaImagenes, true);

        for($i = 0; $i < count($firmaImagenes); $i++) {
            //Convertir base64 a PNG
            $image_parts = explode(";base64,", $firmaImagenes[$i]['picture']);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fotoNombre = "candidato-foto-$i-$user_id-$req_id-$contrato_id.png";

            Storage::disk('public')
                ->put("recursos_firma_contrato_fotos/contrato_foto_$user_id"."_"."$req_id"."_"."$contrato_id/$fotoNombre", $image_base64);

            //Guardar referencia foto en la tabla
            $firmaFoto = new FirmaContratoFoto();

            $firmaFoto->fill([
                'contrato_id' => $contrato_id,
                'user_id' => $user_id,
                'req_id' => $req_id,
                'descripcion' => $fotoNombre
            ]);
            $firmaFoto->save();
        }

        return response()->json(['success' => true]);
    }

    /*
    *   Envío de correo electrónico (Notificación de contrato terminado)
    */
    private function notificaContratacion($req_id, $usuario_envio, $candidato, $cargo_especifico, $cliente, $ciudad_trabajo, $cliente_id, $pais, $dep, $ciudad, $agencia_id){
        $ciudad_convert = explode(' ', $ciudad_trabajo);
        $ciudad = $ciudad_convert[2];

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Notificación de contratación en Req No. $req_id"; //Titulo o tema del correo

        $ruta = route('admin.documentos_contratacion', ['candidato' => $candidato->user_id, 'req' => $req_id]);

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = 'Hola,<br/><br/>
            Te informamos que el candidato '.$candidato->nombres.' '.$candidato->primer_apellido.' '.$candidato->segundo_apellido.' con número de identificación '.$candidato->numero_id.', el cual fue enviado a contratar en el requerimiento '.$req_id.' para el cargo '.$cargo_especifico.' de tu cliente '.$cliente.'  en la ciudad de trabajo '.$ciudad.', realizó con éxito la firma del contrato, puedes consultar la documentación digital en el asistente de contratación a través del siguiente botón.';

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'Documentos de contratación', 'buttonRoute' => $ruta];

        $mailUser = $candidato->user_id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($req_id, $usuario_envio) {

                $message->to([$usuario_envio->email], "T3RS")
                ->subject("Notificación de Contratación en Req No. $req_id")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        //Bogotá
        if (route('home') == "https://listos.t3rsc.co") {
            if($agencia_id == 2){
                Mail::send('admin.email_notificacion_contrato_firmado', [
                    'req_id' => $req_id,
                    'usuario_envio' => $usuario_envio,
                    'candidato' => $candidato,
                    'cargo_especifico' => $cargo_especifico,
                    'cliente' => $cliente,
                    'ciudad' => $ciudad,
                    'email_solo' => true,
                ],function ($message) use ($req_id, $usuario_envio) {
                    $message->to([
                        "matilde.montoya@listos.com.co",
                        "elkin.bustos@listos.com.co ",
                        "digitacionpersonal.bogota@listos.com.co",
                        "darcy.aparicio@listos.com.co",
                        "claudia.vasquez@visionymarketing.com.co",
                        "saray.ruiz@listos.com.co",
                        "lida.peraza@listos.com.co"
                    ], "T3RS")
                    ->subject("Notificación de Contratación en REQ #$req_id")
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            }
        }

        if (route('home') == "https://listos.t3rsc.co" || route('home') == "https://vym.t3rsc.co") {
            Mail::send('admin.email_notificacion_contrato_firmado', [
                'req_id' => $req_id,
                'usuario_envio' => $usuario_envio,
                'candidato' => $candidato,
                'cargo_especifico' => $cargo_especifico,
                'cliente' => $cliente,
                'ciudad' => $ciudad,
                'email_solo' => true,
            ],function ($message) use ($req_id, $usuario_envio) {
                $message->to([
                    "sandra.lozano@visionymarketing.com.co",
                    "ingrid.diaz@listos.com.co",
                    "juanmanuel.munoz@listos.com.co",
                    "liliana.marin@listos.com.co",
                    "brayan.quintero@listos.com.co",
                    "auxiliarlistos2.villavicencio@listos.com.co",
                    "contratacion.bqa2@listos.com.co",
                    "contratacionbucar@listos.com.co",
                    "sandramilena.marulanda@listos.com.co",
                    "johanna.gomez@listos.com.co",
                    "george.lopez@listos.com.co"
                ], "T3RS")
                ->subject("Notificación de Contratación en REQ #$req_id")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }
    }

    public function notificaContratacionRolAfiliaciones($req_id, $candidato, $req_can, $cargo_especifico, $cliente, $ciudad_trabajo, $fecha_firma){

        $ciudad_convert = explode(' ', $ciudad_trabajo);
        $ciudad = $ciudad_convert[2];

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Notificación de contratación en REQ No. $req_id"; //Titulo o tema del correo

        $ruta = route('admin.documentos_seleccion', ['candidato' => $candidato->user_id, 'req' => $req_id, 'req_can' => $req_can]);

        $emails = emails_codigo_rol_cliente_agencia($req_id, ["AFL"]);

        setlocale(LC_TIME, 'es_ES.UTF-8'); 

        $fecha_firma_contrato = strftime("%d de %B del %Y %H:%M", strtotime($fecha_firma));

        foreach ($emails as $user) {
            //Cuerpo con html y comillas dobles para las variables
            $mailBody = "Hola, {$user->name} te informamos que el siguiente colaborador realizó con éxito la firma del contrato el día {$fecha_firma_contrato}:

                <br/><br/>

                <b>Nombre:</b> {$candidato->nombres} {$candidato->primer_apellido} {$candidato->segundo_apellido} 
                <br/>
                <b>Identificación:</b> {$candidato->dec_tipo_doc} {$candidato->numero_id}
                <br/>
                <b>Requerimiento:</b> {$req_id} 
                <br/>
                <b>Cargo:</b> {$cargo_especifico} 
                <br/>
                <b>Cliente:</b> {$cliente} 
                <br/>
                <b>Ciudad de trabajo:</b> {$ciudad}

                <br/><br/>
                Puedes consultar la documentación digital en la opción “Ver documentación” o haciendo clic en el siguiente botón: “Documentación”
                ";

            //Arreglo para el botón
            $mailButton = ['buttonText' => 'Documentación', 'buttonRoute' => $ruta];

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton);

            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($req_id, $user) {

                    $message->to($user->email, "T3RS")
                    ->subject("Notificación de contratación en REQ No. $req_id")
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }
        
    }

    private function notificaContratoAnuladoRolAfiliaciones($req_id, $candidato, $req_can, $cargo_especifico, $cliente, $ciudad_trabajo, $fecha_anulacion) {

        $ciudad_convert = explode(' ', $ciudad_trabajo);
        $ciudad = $ciudad_convert[2];

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Notificación de anulación en REQ No. $req_id"; //Titulo o tema del correo

        $ruta = route('admin.documentos_seleccion', ['candidato' => $candidato->user_id, 'req' => $req_id, 'req_can' => $req_can]);

        $emails = emails_codigo_rol_cliente_agencia($req_id, ["AFL"]);

        setlocale(LC_TIME, 'es_ES.UTF-8'); 

        $fecha_firma_contrato = strftime("%d de %B del %Y %H:%M", strtotime($fecha_anulacion));

        foreach ($emails as $user) {
            try {
                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "Hola, {$user->name} te informamos que el día {$fecha_firma_contrato} se realizó la anulación del contrato del siguiente colaborador:

                    <br/><br/>

                    <b>Nombre:</b> {$candidato->nombres} {$candidato->primer_apellido} {$candidato->segundo_apellido} 
                    <br/>
                    <b>Identificación:</b> {$candidato->dec_tipo_doc} {$candidato->numero_id}
                    <br/>
                    <b>Requerimiento:</b> {$req_id} 
                    <br/>
                    <b>Cargo:</b> {$cargo_especifico} 
                    <br/>
                    <b>Cliente:</b> {$cliente} 
                    <br/>
                    <b>Ciudad de trabajo:</b> {$ciudad}

                    <br/><br/>
                    Puedes consultar la documentación digital en la opción “Ver documentación” o haciendo clic en el siguiente botón: “Documentación”
                    ";

                //Arreglo para el botón
                $mailButton = ['buttonText' => 'Documentación', 'buttonRoute' => $ruta];

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton);

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($req_id, $user) {

                        $message->to($user->email, "T3RS")
                        ->subject("Notificación de anulación en REQ No. $req_id")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            } catch (\Exception $e) {
                logger('Error ContratacionVirtualController@notificaContratoAnuladoRolAfiliaciones no se pudo enviar correo. ' . "Parametros: $req_id, $candidato, $req_can, $cargo_especifico, $cliente, $ciudad_trabajo, $fecha_anulacion. Error: " .  $e->getMessage() . "\n");
            }
        }
    }

    /*
    *   Envío de correo electrónico (Notificación de contrato cancelado)
    */
    private function notificaContratacionCancelada($req_id, $usuario_envio, $candidato){
        Mail::send('admin.email_notificacion_contrato_cancelado', [
            'req_id' => $req_id,
            'usuario_envio' => $usuario_envio,
            'candidato' => $candidato,
        ],function ($message) use ($req_id, $usuario_envio) {
            $message->to([$usuario_envio->email], "T3RS")
            ->subject("Cancelación de contrato en REQ #$req_id")
            ->getHeaders()
            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });
    }

    private function search_and_replace(array $replace, string $subject){
        $nuevo_texto = null;

        for ($i=0; $i < count($this->search); $i++) {
            if($i == 0){
                $nuevo_texto = str_replace($this->search[$i], $replace[$i], $subject);
            }

            $nuevo_texto = str_replace($this->search[$i], $replace[$i], $nuevo_texto);
        }

        return $nuevo_texto;
    }

    private function notificacionEjecutivoCuentas($candidato_id, $requerimiento_id, $contrato_id) {
        $sitio = Sitio::first();

        $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes",  "clientes.id", "=", "negocio.cliente_id")
            ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->where("requerimientos.id", $requerimiento_id)
            ->select(
                "clientes.nombre as nombre_cliente",
                "clientes.direccion as direccion_cliente",
                "clientes.contacto as contacto_cliente",
                "clientes.correo as correo",
                "clientes.id as idcliente",
                "cargos_especificos.descripcion as cargo",
                "requerimientos.id as requerimiento",
                "requerimientos.salario",
                "requerimientos.ctra_x_clt_codigo",
                "requerimientos.solicitado_por as solicitado_por",
                "requerimientos.empresa_contrata"
            )
            ->orderBy('requerimientos.created_at', 'DESC')
        ->first();

        $usuarios_clientes = User::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
            ->join("role_users", "role_users.user_id", "=", "users.id")
            ->where("role_users.role_id", $sitio->id_ejecutivo_cuenta)
            ->where("users.estado", 1)
            ->where("users_x_clientes.cliente_id", $requerimiento->idcliente)
            ->select(
                "users.name",
                "users.email"
            )
        ->get();

        if(count($usuarios_clientes) > 0) {
            try {
                $datos_basicos = RequerimientoContratoCandidato::join("users", "users.id", "=", "requerimiento_contrato_candidato.candidato_id")
                    ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
                    ->join("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
                    ->leftJoin("entidades_afp", "entidades_afp.id", "=", "requerimiento_contrato_candidato.fondo_pensiones_id")
                    ->leftJoin("entidades_eps", "entidades_eps.id", "=", "requerimiento_contrato_candidato.eps_id")
                    ->leftJoin("fondo_cesantias", "fondo_cesantias.id", "=", "requerimiento_contrato_candidato.fondo_cesantia_id")
                    ->leftJoin("caja_compensacion", "caja_compensacion.id", "=", "requerimiento_contrato_candidato.caja_compensacion_id")
                    //->leftJoin("centros_trabajo", "centros_trabajo.id", "=", "requerimiento_contrato_candidato.centro_trabajo_id")

                    ->leftJoin("bancos", "bancos.id", "=", "requerimiento_contrato_candidato.nombre_banco")
                    ->where("requerimiento_contrato_candidato.requerimiento_id", $requerimiento_id)
                    ->where("requerimiento_contrato_candidato.candidato_id", $candidato_id)
                    ->select(
                        "datos_basicos.*",
                        "tipo_identificacion.descripcion as dec_tipo_doc",
                        "entidades_afp.descripcion as entidades_afp_des",
                        "entidades_eps.descripcion as entidades_eps_des",
                        "fondo_cesantias.descripcion as fondo_cesantia_des",
                        "caja_compensacion.descripcion as caja_compensacion_des",
                        "bancos.nombre_banco as nombre_banco_des",
                        "requerimiento_contrato_candidato.fecha_ingreso as fecha_inicio_contrato",
                        "requerimiento_contrato_candidato.fecha_ultimo_contrato",
                        "requerimiento_contrato_candidato.hora_ingreso as hora_entrada",
                        "requerimiento_contrato_candidato.fecha_ingreso as fecha_ingreso_contra",
                        "requerimiento_contrato_candidato.fecha_fin_contrato",
                        'requerimiento_contrato_candidato.auxilio_transporte',
                        'requerimiento_contrato_candidato.tipo_ingreso',
                        'requerimiento_contrato_candidato.requerimiento_candidato_id',
                        //'centros_trabajo.nombre_ctra as riesgo',
                        'requerimiento_contrato_candidato.user_gestiono_id'
                    )
                    ->orderBy("requerimiento_contrato_candidato.id", "desc")
                    ->groupBy('users.id')
                ->first();

                $user = User::find($candidato_id);
                $solicitado_por = User::find($requerimiento->solicitado_por);
                $firmaContrato = FirmaContratos::find($contrato_id);

                $quien_confirma = $solicitado_por;
                $cand_req = $datos_basicos->requerimiento_candidato_id;
                $archivos = collect([]);
                $archivos_generador = [];
                $observacion = '';
                $tipo_correo = 'cliente';

                foreach ($usuarios_clientes  as $clientes) {
                    Mail::send('admin.contratacion.mail.email-documentos-contratacion-cliente', [
                        "requerimiento"  => $requerimiento,
                        "archivos_generados"   => $archivos_generador,
                        "archivos"       => $archivos,
                        "candidato"      => $datos_basicos,
                        "user"           => $user,
                        "tipo_correo"    => $tipo_correo,
                        "observacion"    => $observacion,
                        "quien_confirma" => $quien_confirma,
                        "contrato"       => $firmaContrato,
                        "cand_req"       => $cand_req,
                        "solicitado_por" => $solicitado_por
                    ], function ($message) use($clientes, $requerimiento){
                        $message->to($clientes->email,"T3RS")->subject("Confirmación documentos contratación REQ #$requerimiento->requerimiento")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                }   
            } catch (\Exception $e) {
                logger('Error ContratacionVirtualController@notificacionEjecutivoCuentas no se pudo enviar correo. ' . "Parametros: $candidato_id, $requerimiento_id, $contrato_id. Error: " .  $e->getMessage() . "\n");
            }
        }
    }
}
