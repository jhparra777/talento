<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ContratacionVirtual\ContratacionVirtualFotoController;
use App\Models\User as UsersSentile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use App\Models\CargoEspecifico;
use App\Models\Requerimiento;
use App\Models\RequerimientoContratoCandidato;
use App\Models\Respuesta;
use App\Models\Departamento;
use App\Models\ReqCandidato;
use App\Models\DatosBasicos;
use App\Models\Ciudad;
use App\Models\Pregunta;
use App\Models\Asistencia;
use App\Models\PregReqResp;
use App\Models\RespuestasEntre;
use App\Models\PreguntasEntre;
use App\Models\DatosTemporales;
use App\Models\Clientes;
use App\Models\FirmaContratos;
use App\Models\User;
use App\Models\RegistroProceso;
use App\Models\Sitio;
use App\Models\TipoExperiencia;
use App\Models\NivelEstudios;
use App\Models\PreguntasPruebaIdioma;
use App\Models\RespuestaPruebaIdioma;

use App\Models\ResultadoPreguntaCandidatoAplica;
use App\Models\ResultadoCandidatoAplica;
use App\Models\ResultadoGeneralAplica;
use App\Models\ConfirmacionPreguntaContrato;

use App\Models\OfertaUser;

use PDF;
use Carbon\Carbon;

//Helper
use triPostmaster;
use Illuminate\Support\Facades\Event;
use GuzzleHttp\Client;


class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
         
        $this->meses = [
            1 => "Enero",
            2 => "Febrero",
            3 => "Marzo",
            4 => "Abril",
            5 => "Mayo",
            6 => "Junio",
            7 => "Julio",
            8 => "Agosto",
            9 => "Septiembre",
            10 => "Octubre",
            11 => "Noviembre",
            12 => "Diciembre"
        ];
    }

    public function index(Request $data)
    {
        //Contar el total de clientes en el sistema
        $menu = DB::table("menu_home")->where("estado",1)->orderBy("orden")
        ->select("menu_home.*")
        ->get();

        $clientes = \Cache::remember('clientes','5', function(){
            return Clientes::count();
        });

        //Cuenta la cantidad total de usuarios en el sistema
        $candidatos = \Cache::remember('candidatos','8', function(){
            return UsersSentile::count();
        });

        //Cuenta la candidad total de vacantes
        $count_vacantes = \Cache::remember('count_vacantes','5', function(){
            return Requerimiento::whereRaw("requerimientos.estado_publico is not false")
            ->select(\DB::raw("SUM(num_vacantes) AS vacantes"))->first();
        });

        $vacantes = $count_vacantes->vacantes;

        //Cuenta la cantidad total de ofertas
        $ofertas= Requerimiento::whereRaw("requerimientos.estado_publico is not false")->count();

        $requerimientos = Requerimiento::join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
            ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->join("cargos_especificos","cargos_especificos.id", "=","requerimientos.cargo_especifico_id")
        ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
        ->select(
            "requerimientos.cargo_especifico_id as cargo_id",
            "requerimientos.*",
            \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"),
            "clientes.nombre as nombre_cliente",
            "cargos_genericos.descripcion as nombre_cargo",
            "cargos_especificos.descripcion as nombre_subcargo",
            "clientes.logo as logo"
        )
        //->where(function ($where) {
        //    $where->where("requerimientos.fecha_tope_publicacion",">=",DATE_FORMAT(now(),'Y-m-d'));
        //    $where->orWhereNull("requerimientos.fecha_tope_publicacion");
        //})
        ->where(function ($where) use ($data) {
            if ($data->get("ciudad_id") != "") {
                $where->where("requerimientos.ciudad_id", $data->get("ciudad_id"));
                $where->where("requerimientos.pais_id", $data->get("pais_id"));
                $where->where("requerimientos.departamento_id", $data->get("departamento_id"));
            }

            if ($data->get("estado_oferta") != "") {
                switch ($data->get("estado_oferta")) {
                    case "no":
                        $where->whereRaw("ofertas_users.fecha_aplicacion = '' or ofertas_users.fecha_aplicacion IS NULL");

                        break;
                    case "si":
                        $where->whereRaw("ofertas_users.fecha_aplicacion is not null ");
                        break;
                }
            }

            if ($data->get("cargo_generico") != "") {
                $where->where("cargos_genericos.id", $data->get("cargo_generico"));
            }
            if ($data->get("departamento") != "") {
                $where->where("departamentos.id", $data->get("departamento"));
            }
            if ($data->get("ciudad") != "") {
                $where->where("ciudad.id", $data->get("ciudad"));
            }
            if ($data->get("palabra_clave") != "") {
                $where->whereRaw("LOWER(cargos_genericos.descripcion) COLLATE SQL_Latin1_General_Cp1_CI_AI like '%" . $data->get("palabra_clave") . "%' or LOWER(cargos_especificos.descripcion) collate SQL_Latin1_General_Cp1_CI_AI like '%" . $data->get("palabra_clave") . "%' ");
            }
            if ($data->get("fecha_inicio") != "" && $data->get("fecha_fin") != "") {
                $where->whereBetween("requerimientos.fecha_publicacion", [$data->get("fecha_inicio") . " 00:00:00", $data->get("fecha_fin") . " 23:59:59"]);
            }
        })
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
        ->whereNotIn('estados_requerimiento.estado',
                  [config('conf_aplicacion.C_TERMINADO')])
        ->whereRaw("requerimientos.estado_publico is not false")
        ->orderBy("requerimientos.created_at", "desc")
        ->paginate(6);

        if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'http://listos.t3rsc.co' ||
            route('home') == 'https://vym.t3rsc.co' || route('home') == 'http://vym.t3rsc.co') {
            return view("home.listos_index", compact([
                "ofertas",
                "vacantes",
                "candidatos",
                "preguntas_requ",
                "requerimientos",
                "num_req_a",
                "vacantes_abi",
                "num_can_con",
                "clientes",
                "menu"
            ]));
        }else{
            return view("home.index", compact([
                "ofertas",
                "vacantes",
                "candidatos",
                "preguntas_requ",
                "requerimientos",
                "num_req_a",
                "vacantes_abi",
                "num_can_con",
                "clientes",
                "menu"
            ]));
        }
    }

    public function testFunction(Request $request)
    {   
        /*$destino = "4245511809";
        $candidato = "Darwist";
        $titulo = "Prueba de whatsApp";

        $ruta = "cv+prueba-excel-basico+675";


        event(new \App\Events\NotificationWhatsappEvent(
            "whatsapp", 
            $destino,
            "template", 
            "proceso_pruebas_botones", 
            [$candidato, $titulo, $ruta]
        ));
        */
    }

    /*
    *   Despliega modal y envía código de verificación
    */

    public function codigo_firma_contrato_view(Request $data)
    {
        $codigo = rand(10000, 99999);

        $proceso = RegistroProceso::find($data->proceso);
        $datos_basicos = DatosBasicos::where("user_id", $proceso->candidato_id)->first();

        $checkContrato = FirmaContratos::where('user_id', $proceso->candidato_id)
        ->where('req_id', $proceso->requerimiento_id)
        ->where('estado', 1)
        ->orderBy('created_at', 'DESC')
        ->first();

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Código de Verificación"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = 'El código de validación para el proceso de firma de contrato es el siguiente:
            <br/><br/>
            <b style="font-size: 18px; font-weight:300; letter-spacing:-.014em; line-height:1.3em; text-align: center;">'.$codigo.'</b>';

        //Arreglo para el botón
        $mailButton = [];

        $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        if($checkContrato == null || empty($checkContrato)){
            $telefono = "57".$datos_basicos->telefono_movil;

            $email = $datos_basicos->email;

            $proceso->codigo_validacion = $codigo;

            $proceso->save();
            $asunto = "Código validación para firma de contrato";

            if($email != null && $email != "") {
                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $asunto) {

                $message->to([$email], 'T3RS')->subject($asunto)
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            }

            $this->validarSmsCodigo($telefono,$codigo,$datos_basicos);

            return response()->json(['success' => true]);
        }else {
            if($checkContrato->estado === 1 || $checkContrato->estado == 1) {
                if($checkContrato->terminado == null && $checkContrato->stand_by == 0) {
                    $telefono = "57".$datos_basicos->telefono_movil;

                    $email = $datos_basicos->email;

                    $proceso->codigo_validacion = $codigo;

                    $proceso->save();
                    $asunto = "Código validación para firma de contrato";

                    if($email != null && $email != "") {
                        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $asunto) {

                        $message->to([$email], 'T3RS')->subject($asunto)
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                        });
                    }

                    $this->validarSmsCodigo($telefono, $codigo, $datos_basicos);

                    return response()->json(['success' => true]);

                }elseif($checkContrato->terminado === 0 || $checkContrato->terminado === 1 || $checkContrato->terminado === 2 ||
                        $checkContrato->terminado == 0 || $checkContrato->terminado == 1 || $checkContrato->terminado == 2) {

                    return response()->json(['terminado' => true]);

                }elseif($checkContrato->terminado === 3 || $checkContrato->terminado == 3) {
                    $telefono = "57".$datos_basicos->telefono_movil;

                    $email = $datos_basicos->email;

                    $proceso->codigo_validacion = $codigo;
                    $proceso->save();

                    $asunto = "Código validación para firma de contrato";

                    if($email != null && $email != "") {
                        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $asunto) {

                        $message->to([$email], 'T3RS')->subject($asunto)
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                        });
                    }

                    $this->validarSmsCodigo($telefono, $codigo, $datos_basicos);

                    return response()->json(['success' => true, 'contrato' => $checkContrato->id]);
                }elseif($checkContrato->stand_by == 1 || $checkContrato->stand_by === 1) {
                    return response()->json(['stand_by' => true]);
                }
            }else {
                return response()->json(['anulado' => true]);
            }
        }
    }

    /*
    *   Verifica el código enviado
    */
    public function verificar_codigo_contrato(Request $data)
    {
        $proceso = RegistroProceso::find($data->proceso);

        if($proceso->codigo_validacion == $data->codigo){
            //Hash data
            $CandidatoId = Crypt::encrypt($proceso->candidato_id);
            $RequerimientoId = Crypt::encrypt($proceso->requerimiento_id);
            $modulo = Crypt::encrypt('modulo_cv');

            if($data->has('contrato')){
                if($data->contrato != null || $data->contrato != ''){
                    $Contrato = Crypt::encrypt($data->contrato);

                    return redirect()->route('home.confirmar-contratacion-video', [$CandidatoId, $Contrato, $modulo]);
                }
            }
            return redirect()->route('home.firma-contrato-laboral', [$CandidatoId, $RequerimientoId, $modulo]);
        }
        else{
            return redirect()->back()->with("mensaje_error", "Código equivocado. Se generará un nuevo código la próxima vez.");
        }
    }

    /*
    *   Verifica código por ajax y acepta modo de firma
    */
    public function verificar_codigo_contrato_async(Request $data)
    {
        $proceso = RegistroProceso::find($data->proceso);

        if($proceso->codigo_validacion == $data->code) {
            $aceptacion = DatosBasicos::where('user_id', $proceso->candidato_id)->first();

            if ($aceptacion->aceptacion_firma_digital == 0) {
                $aceptacion->aceptacion_firma_digital = 1;
                $aceptacion->aceptacion_ip = $data->ip();
                $aceptacion->aceptacion_date = date("Y-m-d H:i:s");
                $aceptacion->save();
            }

            return response()->json([
                'success' => true
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }

    //Realizar prueba idioma virtual candidato sin necesidad de auth
    public function video_prueba_idioma_candidato($user_id, $req_id )
    {
        $preguntas_prueba = PreguntasPruebaIdioma::join('pruebas_idiomas','pruebas_idiomas.id','=','preguntas_pruebas_idiomas.prueba_idio_id')
        ->join('requerimientos','requerimientos.id','=','pruebas_idiomas.req_id')
        ->where('pruebas_idiomas.req_id', $req_id)
        ->where('preguntas_pruebas_idiomas.activo', 1)
        ->select('preguntas_pruebas_idiomas.id as id','preguntas_pruebas_idiomas.descripcion as descripcion')
        ->get();

        $sitio = Sitio::first();

        $respuesta_pregu = RespuestaPruebaIdioma::where('respuestas_pruebas_idiomas.candidato_id',$user_id)->get();
        
        $req_id = $req_id;
        $user_id = $user_id;

        return view("home.respuesta-video-prueba-idioma",compact('respuesta_pregu','user_id','req_id','preguntas_prueba', 'sitio'));
    }

    //Realizar video entrevista virtual candidato sin necesidad de auth
    public function video_entrevista_virtual_candidato($user_id, $req_id )
    {
        //$datos_temporales = DatosTemporales::where('datos_temporales.numero_id',$user_id)->first();
        $sitio = Sitio::first();

        $preguntas_entre = PreguntasEntre::join('entrevista_virtual', 'entrevista_virtual.id', '=', 'preguntas_entre.entre_vir_id')
        ->join('requerimientos', 'requerimientos.id', '=', 'entrevista_virtual.req_id')
        ->where('entrevista_virtual.req_id', $req_id)
        ->where('preguntas_entre.activo', 1)
        ->select('preguntas_entre.id as id', 'preguntas_entre.descripcion as descripcion')
        ->get();

        $respuesta_pregu = RespuestasEntre::where('respuestas_entre.candidato_id',$user_id)
        //->where('respuestas_entre.preg_entre_id',12)
        ->get();

        //return view("cv.video_entrevista", compact('preguntas_entre'));

        $req_id = $req_id;
        $user_id = $user_id;

        return view("home.respuesta-video-entrevista", compact('respuesta_pregu', 'user_id', 'req_id', 'preguntas_entre', 'sitio'));
    }

    public function video_entrevista_candidato($numero_id, $req_id)
    {
        $datos_temporales = DatosTemporales::where('datos_temporales.numero_id',$numero_id)->first();
        $numero_id = $numero_id;

        return view("home.video_entrevista_prueba", compact('datos_temporales', 'numero_id', 'preguntas_entre'));
    }

    public function responder_entre_pregu(Request $data)
    {
        $pregu_id = $data->pregu_id;
        $numero_id = $data->numero_id;

        return view("cv.modal.responder_preguntas_entre_prueba", compact('numero_id', 'pregu_id', 'preguntas_entre'));
    }

    public function guardar_respu_pregu(Request $data)
    {
        $datos_temporales = DatosTemporales::where('datos_temporales.numero_id', $data->numero_id)->first();

        //GUARDANDO VIDEO
        $archivo   = $data->file('video-blob');
        $extencion = $archivo->getClientOriginalExtension();
        $fileName  = "VideoRespuesta_"."$datos_temporales->numero_id". ".$extencion";

        //ELIMINAR FOTO PERFIL
        if ($datos_temporales->video_entrevista_prueba != "" && file_exists("recursos_videoPrueba/" . $datos_temporales->video_entrevista_prueba)) {
            unlink("recursos_videoPrueba/" . $datos_temporales->video_entrevista_prueba);
        }
        
        $datos_temporales->video_entrevista_prueba = $fileName;
        $datos_temporales->save();
        $data->file('video-blob')->move("recursos_videoPrueba", $fileName);

        return response()->json(["success" => true]);
    }

    public function detalle($oferta_id, Request $data)
    {
        $anterior=URL::previous();
        $json_google = null;

        $menu = DB::table("menu_home")->where("estado",1)->orderBy("orden")
        ->select("menu_home.*")
        ->get();

        /**
            Komatsu dejar como esta en la instancia
            Soluciones dejar lo nuevo que va a pasar desde desarrollo
        **/

        $requerimientos = Requerimiento::join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->leftjoin("tipos_experiencias", "tipos_experiencias.id", "=", "requerimientos.tipo_experiencia_id")
        ->leftjoin("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
            ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->leftjoin("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->leftjoin("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->leftjoin("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->leftjoin("tipos_jornadas", "tipos_jornadas.id", "=", "requerimientos.tipo_jornadas_id")
        ->leftjoin("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->leftjoin('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
        ->leftJoin("ofertas_users", function ($join3) {
            $join3->on("ofertas_users.requerimiento_id", "=", DB::raw("requerimientos.id"));
        })
        ->select(
            "cargos_especificos.id as cargo_espe_id",
            "estados_requerimiento.estado as estado_requerimiento",
            "tipos_jornadas.descripcion as tipo_jornada",
            "tipos_experiencias.descripcion as tipo_experiencia",
            "requerimientos.*",
            "estados_requerimiento.estado as estado_requerimiento",
            "ofertas_users.fecha_aplicacion as f_aplicacion",
            DB::raw(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada")),
            "clientes.nombre as nombre_cliente",
            "cargos_genericos.id as cargo_id",
            "cargos_genericos.descripcion as nombre_cargo",
            "cargos_especificos.descripcion as nombre_subcargo",
            "clientes.logo as logo"
        )
        /*->where(function ($where) {
            $where->where("requerimientos.fecha_tope_publicacion",">=",DATE_FORMAT(now(),'Y-m-d'));
            $where->orWhereNull("requerimientos.fecha_tope_publicacion");
        })*/
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
        //->whereNotIn('estados_requerimiento.estado',
              //[config('conf_aplicacion.C_TERMINADO')])

        //->whereRaw("requerimientos.estado_publico is not false")
        ->where("requerimientos.id", $oferta_id)
        ->first();

        //Otros empleos
        $requerimientos1 = Requerimiento::join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
            ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->join("cargos_especificos","cargos_especificos.id", "=","requerimientos.cargo_especifico_id")
        ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->select("requerimientos.*",
            \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"), "clientes.nombre as nombre_cliente",
            "cargos_genericos.descripcion as nombre_cargo",
            "cargos_especificos.descripcion as nombre_subcargo",
            "clientes.logo as logo"
        )
        ->where("requerimientos.fecha_tope_publicacion",">=",DATE_FORMAT(now(),'Y-m-d'))
        ->orWhereNull("requerimientos.fecha_tope_publicacion")
        ->where(function ($where) use ($data) {
            if ($data->get("ciudad_id") != "") {
                $where->where("requerimientos.ciudad_id", $data->get("ciudad_id"));
                $where->where("requerimientos.pais_id", $data->get("pais_id"));
                $where->where("requerimientos.departamento_id", $data->get("departamento_id"));
            }

            if ($data->get("estado_oferta") != "") {
                switch ($data->get("estado_oferta")) {
                    case "no":
                        $where->whereRaw("ofertas_users.fecha_aplicacion = '' or ofertas_users.fecha_aplicacion IS NULL");
                    break;

                    case "si":
                        $where->whereRaw("ofertas_users.fecha_aplicacion is not null ");
                    break;
                }
            }

            if ($data->get("cargo_generico") != "") {
                $where->where("cargos_genericos.id", $data->get("cargo_generico"));
            }

            if ($data->get("departamento") != "") {
                $where->where("departamentos.id", $data->get("departamento"));
            }

            if ($data->get("ciudad") != "") {
                $where->where("ciudad.id", $data->get("ciudad"));
            }

            if ($data->get("palabra_clave") != "") {
                $where->whereRaw("LOWER(cargos_genericos.descripcion) like '%" . $data->get("palabra_clave") . "%' or LOWER(cargos_especificos.descripcion) like '%" . $data->get("palabra_clave") . "%' ");
            }

            if ($data->get("fecha_inicio") != "" && $data->get("fecha_fin") != "") {
                $where->whereBetween("requerimientos.fecha_publicacion", [
                    $data->get("fecha_inicio") . " 00:00:00",
                    $data->get("fecha_fin") . " 23:59:59"
                ]);
            }
        })
        ->whereRaw("requerimientos.estado_publico is not false")
        ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
        ->orderBy("requerimientos.created_at", "desc")
        ->paginate(2);
        
        //Empleos relacionados
        $requerimientos2 = Requerimiento::join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
            ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->join("cargos_especificos","cargos_especificos.id", "=","requerimientos.cargo_especifico_id")
        ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->select(
            "requerimientos.*",
            \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"),
            "clientes.nombre as nombre_cliente",
            "cargos_genericos.descripcion as nombre_cargo",
            "cargos_especificos.descripcion as nombre_subcargo",
            "clientes.logo as logo"
        )
        ->where("requerimientos.fecha_tope_publicacion",">=",DATE_FORMAT(now(),'Y-m-d'))
        ->orWhereNull("requerimientos.fecha_tope_publicacion")
        ->where(function ($where) use ($data) {
            if ($data->get("ciudad_id") != "") {
                $where->where("requerimientos.ciudad_id", $data->get("ciudad_id"));
                $where->where("requerimientos.pais_id", $data->get("pais_id"));
                $where->where("requerimientos.departamento_id", $data->get("departamento_id"));
            }
                
            if ($data->get("estado_oferta") != "") {
                switch ($data->get("estado_oferta")) {
                    case "no":
                        $where->whereRaw("ofertas_users.fecha_aplicacion = '' or ofertas_users.fecha_aplicacion IS NULL");
                    break;
                    case "si":
                        $where->whereRaw("ofertas_users.fecha_aplicacion is not null ");
                    break;
                }
            }

            if ($data->get("cargo_generico") != "") {
                $where->where("cargos_genericos.id", $data->get("cargo_generico"));
            }

            if ($data->get("departamento") != "") {
                $where->where("departamentos.id", $data->get("departamento"));
            }

            if ($data->get("ciudad") != "") {
                $where->where("ciudad.id", $data->get("ciudad"));
            }

            if ($data->get("palabra_clave") != "") {
                $where->whereRaw("LOWER(cargos_genericos.descripcion) like '%" . $data->get("palabra_clave") . "%' or LOWER(cargos_especificos.descripcion) like '%" . $data->get("palabra_clave") . "%' ");
            }

            if ($data->get("fecha_inicio") != "" && $data->get("fecha_fin") != "") {
                $where->whereBetween("requerimientos.fecha_publicacion", [
                    $data->get("fecha_inicio") . " 00:00:00",
                    $data->get("fecha_fin") . " 23:59:59"
                ]);
            }
        })
        ->whereRaw("requerimientos.estado_publico is not false")
        ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
        ->where("requerimientos.cargo_generico_id", $requerimientos->cargo_id)
        ->where('requerimientos.id','!=',$oferta_id)
        ->orderBy("requerimientos.created_at", "desc")
        ->paginate(8);

        $clientes = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->select( DB::raw('(select count(clientes.id)  from clientes )  as num_clientes '))
        ->get();

        $candidatos_contratar = ReqCandidato::join("users", "requerimiento_cantidato.candidato_id", "=", "users.id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join("requerimientos","requerimiento_cantidato.requerimiento_id","=","requerimientos.id")
        ->join("estados_requerimiento","requerimientos.id","=","estados_requerimiento.req_id")
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
        ->whereIn("requerimiento_cantidato.estado_candidato",[
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_ACTIVO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION')
        ])
        ->whereIn('estados_requerimiento.estado',[ 
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE')
        ]);

        $num_can_con = $candidatos_contratar->count();

        $vacantes_abi = DB::table('requerimientos')
        ->join("estados_requerimiento","requerimientos.id","=","estados_requerimiento.req_id")
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
        ->whereIn('estados_requerimiento.estado',[ 
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
        ])
        ->select( DB::raw('(select count(requerimientos.num_vacantes)  from requerimientos )  as numero_vac '))
        ->get();

        $requerimientos_abiertos= Requerimiento::join("estados_requerimiento", "requerimientos.id", "=", "estados_requerimiento.req_id")
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
        ->whereIn('estados_requerimiento.estado',[
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE')
        ]);

        $num_req_a = $requerimientos_abiertos->count();

        //Indexing in Google
        if (route("home") == "http://talentum.t3rsc.co" || route("home") == "https://talentum.t3rsc.co" ||
            route("home") == "http://pta.t3rsc.co" || route("home") == "https://pta.t3rsc.co" ||
            route("home") == "http://temporizar.t3rsc.co" || route("home") == "https://temporizar.t3rsc.co" ||
            route("home") == "http://soluciones.t3rsc.co" || route("home") == "https://soluciones.t3rsc.co" ||
            route("home") == "http://nases.t3rsc.co" || route("home") == "https://nases.t3rsc.co" ||
            route("home") == "http://listos.t3rsc.co" || route("home") == "https://listos.t3rsc.co" ||
            route("home") == "http://vym.t3rsc.co" || route("home") == "https://vym.t3rsc.co") {
            
            $ofertaPub = Requerimiento::where('id', $oferta_id)->first();            

            $nombre_empresa_que_publica = config('conf_aplicacion.VARIABLES_ENTORNO.COMPANY_NAME');

            $oferta_id_google = $oferta_id; // Al crear la oferta le pasamos este dato

            $datePosted = $ofertaPub->created_at; // este es el campo created_at

            $date_pub = Carbon::parse($datePosted);

            $validThrough = $date_pub->addWeekdays(12)->toDateString()."T00:00";

            $employmentType = ["CONTRACTOR", "FULL_TIME"];

            $nombre_empresa_del_empleo = config('conf_aplicacion.VARIABLES_ENTORNO.COMPANY_NAME');

            $website = "https://www.trabajaconnosotros.com.co";

            //----
            $sitioCliente = Sitio::first();

            $logo_empresa_del_empleo = route('home') . '/configuracion_sitio/' . $sitioCliente->logo;

            $direccion_empresa_del_empleo = "Cra 22 81 80";

            $descripcion_empresa_del_empleo = $sitioCliente->quienes_somos;

            $nameCity = Ciudad::where('id', $ofertaPub->ciudad_id)->first();
            $nameDep = Departamento::where('id', $ofertaPub->departamento_id)->first();

            $title = CargoEspecifico::where('id', $ofertaPub->cargo_especifico_id)->first();

            $exp = TipoExperiencia::select('descripcion')->where('id', $ofertaPub->tipo_experiencia_id)->first();
            $estudioLevel = NivelEstudios::select('descripcion')->where('id', $ofertaPub->nivel_estudio)->first();

            $description = $ofertaPub->descripcion_oferta;
            $description.="<br/><p>Requisitos</p><br/><ul>";
            $description.="<li>Nivel de estudio : ".ucfirst(mb_strtolower($estudioLevel['descripcion']))."</li>";
            $description.="<li>Experiencia : ".$exp['descripcion']."</li>";
            $description.="</ul>";

            // Lugar del empleo
            $lugar_del_empleo = [
                "@type"           => "PostalAddress",
                "addressCountry"  => "CO",
                "streetAddress"   => $direccion_empresa_del_empleo,
                "addressLocality" => $nameCity->nombre,
                "addressRegion"   => $nameDep->nombre,
                "postalCode"      => "000000"
            ];

            $identifier = [
                "@type" => "PropertyValue",
                "name"  => $nombre_empresa_que_publica,
                "value" => $oferta_id,
            ];

            $hiringOrganization = [
                "@type"   => "Organization",
                "name"    => $nombre_empresa_del_empleo,
                "sameAs"  => $website,
                "logo"    => $logo_empresa_del_empleo,
                "address" => $direccion_empresa_del_empleo
            ];

            $jobLocation = [
                "@type"       => "Place",
                "address"     => $lugar_del_empleo,
                "description" => $descripcion_empresa_del_empleo
            ];

            $baseSalary = [
                "@type" => "MonetaryAmount",
                "currency" => "COP",
                "value" => [
                    "@type" => "QuantitativeValue",
                    "value" => $ofertaPub->salario,
                    "unitText" => "MONTH"
                ]
            ];

            $objJsonLdTeletrabajo = [];

            $objJsonLd = [
                "@context" => "https://schema.org/",
                "@type"    => "JobPosting",
                "title" => $title->descripcion,
                "description" => $description,
                "identifier" => $identifier,
                "datePosted" => $datePosted,
                "validThrough" => $validThrough,
                "employmentType" => $employmentType,
                "hiringOrganization" => $hiringOrganization,
                "jobLocation" => $jobLocation,
                "baseSalary" => $baseSalary
            ] + $objJsonLdTeletrabajo;

            $json_google = json_encode($objJsonLd);
        }

        $imagen_oferta=DB::table("cargos_genericos_imagenes")->where("id",$requerimientos->imagen_oferta)->first();
        return view("home.detalle_oferta", compact([
            "requerimientos",
            "requerimientos1",
            "requerimientos2",
            "num_req_a",
            "vacantes_abi",
            "num_can_con ",
            "clientes",
            "oferta_id",
            "json_google",
            "menu",
            "anterior",
            "imagen_oferta"
        ]));
    }

    public function guardar_asistencia_candidato(Request $data)
    {
        $candidato = DatosBasicos::where('datos_basicos.numero_id',$data->numero_id)->first();
        $candidato->asistencia = 1;
        $candidato->save();

        $nueva_asistencia = new Asistencia();
        $nueva_asistencia->llamada_id = $data->llamada_id;
        $nueva_asistencia->numero_id = $data->numero_id;
        $nueva_asistencia->asistencia =1;
        $nueva_asistencia->save();

        return response()->json(["success" => true]);
    }

    public function guardar_inasistencia_candidato(Request $data)
    {
        $candidato = DatosBasicos::where('datos_basicos.numero_id',$data->numero_id)->first();
        $candidato->asistencia = 0;
        $candidato->save();

        $nueva_asistencia = new Asistencia();
        $nueva_asistencia->llamada_id = $data->llamada_id;
        $nueva_asistencia->numero_id = $data->numero_id;
        $nueva_asistencia->asistencia =0;
        $nueva_asistencia->save();

        return response()->json(["success" => true]);
    }  

    public function detalle_oferta_mensaje($oferta_id, $numero_id, $llamada_id, Request $data)
    {
        $menu = DB::table("menu_home")->where("estado",1)->orderBy("orden")
        ->select("menu_home.*")
        ->get();

        $candidato_numero_id = $numero_id;

        $candidato = Asistencia::where('asistencia.numero_id',$candidato_numero_id)
        ->where('asistencia.llamada_id',$llamada_id)
        ->first();

        // Consulta del detalle de la oferta
        $requerimientos = Requerimiento::join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->join("tipos_experiencias", "tipos_experiencias.id", "=", "requerimientos.tipo_experiencia_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
            })
        ->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
            })
        ->join("cargos_especificos","cargos_especificos.id", "=","requerimientos.cargo_especifico_id")
        ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("tipos_jornadas", "tipos_jornadas.id", "=", "requerimientos.tipo_jornadas_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->leftJoin("ofertas_users", function ($join3) {
            $join3->on("ofertas_users.requerimiento_id", "=", DB::raw("requerimientos.id"));
        })
        ->select("tipos_jornadas.descripcion as tipo_jornada ","tipos_experiencias.descripcion as tipo_experiencia","requerimientos.*", "ofertas_users.fecha_aplicacion as f_aplicacion", DB::raw(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada")), "clientes.nombre as nombre_cliente","cargos_genericos.id as cargo_id", "cargos_genericos.descripcion as nombre_cargo","cargos_especificos.descripcion as nombre_subcargo", "clientes.logo as logo")
        ->where("requerimientos.id", $oferta_id)
        ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
        ->first();

        return view("home.detalle_oferta_mensaje", compact(["llamada_id","candidato","candidato_numero_id","requerimientos","menu"]));
    }

    public function empleos(Request $data)
    {
        $menu = DB::table("menu_home")->where("estado",1)->orderBy("orden")
        ->select("menu_home.*")
        ->get();

        $departamentos = Requerimiento::join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
            ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->select("departamentos.*", "departamentos.nombre")
        ->whereRaw("requerimientos.estado_publico is not false")
        ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
        ->groupBy("departamentos.cod_departamento","requerimientos.departamento_id")
        ->orderBy("requerimientos.created_at", "desc")
        ->get();
        
        $jornadas  = Requerimiento::join("tipos_jornadas","tipos_jornadas.id","=","requerimientos.tipo_jornadas_id")
        ->select("tipos_jornadas.*", "tipos_jornadas.descripcion")
        ->whereRaw("requerimientos.estado_publico is not false")
        ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
        ->groupBy("tipos_jornadas.id","requerimientos.tipo_jornadas_id")
        ->orderBy("requerimientos.created_at", "desc")
        ->get();
        
        $contratos  = Requerimiento::join("tipos_contratos","tipos_contratos.id","=","requerimientos.tipo_contrato_id")
        ->select("tipos_contratos.*", "tipos_contratos.descripcion")
        ->whereRaw("requerimientos.estado_publico is not false")
        ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
        ->groupBy("tipos_contratos.id","requerimientos.tipo_contrato_id")
        ->orderBy("requerimientos.created_at", "desc")
        ->get();

        $cargos  = Requerimiento::join("cargos_genericos","cargos_genericos.id","=","requerimientos.cargo_generico_id")
        ->select("cargos_genericos.*","cargos_genericos.descripcion")
        ->whereRaw("requerimientos.estado_publico is not false")
        ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
        ->groupBy("cargos_genericos.id","requerimientos.cargo_generico_id")
        ->orderBy("requerimientos.created_at", "desc")
        ->get();

        $ciudades = Requerimiento::join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->select("ciudad.*", "ciudad.nombre")
        ->whereRaw("requerimientos.estado_publico is not false")
        ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
        ->groupBy("departamentos.cod_departamento","requerimientos.departamento_id")
        ->orderBy("requerimientos.created_at", "desc")
        ->get();

        $requerimientos = Requerimiento::join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
            ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
            ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
            ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
        })
        ->join("cargos_especificos","cargos_especificos.id", "=","requerimientos.cargo_especifico_id")
        ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->join("tipos_jornadas","tipos_jornadas.id","=","requerimientos.tipo_jornadas_id")
        ->join("tipos_contratos","tipos_contratos.id","=","requerimientos.tipo_contrato_id")
        ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->where("requerimientos.fecha_tope_publicacion",">=",DATE_FORMAT(now(),'Y-m-d'))
        ->orWhereNull("requerimientos.fecha_tope_publicacion")
        ->where(function ($where) use ($data) {
            if ($data->get("estado_oferta") != "") {
                switch ($data->get("estado_oferta")) {
                    case "no":
                        $where->whereRaw("ofertas_users.fecha_aplicacion = '' or ofertas_users.fecha_aplicacion IS NULL");
                        break;
                    case "si":
                        $where->whereRaw("ofertas_users.fecha_aplicacion is not null ");
                        break;
                }
            }

            if($data->get("departamento_id") != ""){
                $where->whereIn("requerimientos.departamento_id", $data->get("departamento_id"));
            }

            if($data->get("jornada_id") != ""){
                $where->whereIn("tipos_jornadas.id", $data->get("jornada_id"));
            }

            if($data->get("contrato_id") != ""){
                $where->whereIn("tipos_contratos.id", $data->get("contrato_id"));
            }

            if($data->get("cargo_id") != ""){
                $where->whereIn("cargos_genericos.id", $data->get("cargo_id"));
            }

            if ($data->get("ciudad_id") != "") {
                $where->whereIn("ciudad.cod_ciudad", $data->get("ciudad_id"));
            }

            if ($data->get("salario") != "") {
                $where->whereRaw("requerimientos.salario >=700000 or requerimientos.salario < 1000000 =".implode("-",$data->get('salario')));
            }
                
            if ($data->get("palabra_clave") != "") {
                $where->whereRaw("LOWER(cargos_genericos.descripcion) like '%" . strtolower($data->get("palabra_clave")) . "%' or LOWER(cargos_especificos.descripcion) like '%" . strtolower($data->get("palabra_clave")) . "%' ");
            }
        })
        ->select(
            "requerimientos.*",
            \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"),
            "clientes.nombre as nombre_cliente",
            "cargos_genericos.descripcion as nombre_cargo",
            "cargos_especificos.descripcion as nombre_subcargo",
            "clientes.logo as logo"
        )
        ->whereRaw("requerimientos.estado_publico is not false")
        ->whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config('conf_aplicacion.C_TERMINADO') . ")"))
        ->orderBy("requerimientos.created_at", "desc")
        ->paginate(5);

        $candidatos_contratar = ReqCandidato::join("users", "requerimiento_cantidato.candidato_id", "=", "users.id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join("requerimientos","requerimiento_cantidato.requerimiento_id","=","requerimientos.id")
        ->join("estados_requerimiento","estados_requerimiento.req_id","=","requerimientos.id")
        ->whereIn("requerimiento_cantidato.estado_candidato",[
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_ACTIVO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION')] )
        ->whereIn("estados_requerimiento.estado",
        [
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
        ])
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)');

        //Contar el total de clientes en el sistema
        $clientes = Clientes::count();

        //Cuenta la cantidad total de usuarios en el sistema
        $candidatos =  UsersSentile::count();

        //Cuenta la candidad total de vacantes
        $count_vacantes = Requerimiento::select(\DB::raw("SUM(num_vacantes) AS vacantes"))->first();
        $vacantes = $count_vacantes->vacantes;

        //Cuenta la cantidad total de ofertas
        $ofertas= Requerimiento::count();

        return view("home.buscar_empleo", compact([
            "requerimientos",
            "departamentos",
            "jornadas",
            "contratos",
            "cargos",
            "ciudades",
            "candidatos",
            "vacantes",
            "ofertas",
            "clientes",
            "menu"
        ]));
    }

    public function getEmail($id, Request $data)
    {
        $menu = DB::table("menu_home")->where("estado",1)->orderBy("orden")
        ->select("menu_home.*")
        ->get();

        $requerimientos = Requerimiento::where("requerimientos.id", $id)->first();        

        return view("home.enviar_email",compact("menu"))->with("requerimientos",$requerimientos);
    }

    public function postEmail( Request $data)
    {
        $nombre_destino = $data->get("nombre_destino");
        $nombre = $data->get("nombre");
        
        //enviar correos a varios destinarios
        $req_id = $data->get("req_id");

        $reqi = Requerimiento::where('id',$req_id)->first();
        $imagen = DB::table('cargos_genericos_imagenes')->where("id",$reqi->imagen_oferta)->first();

        $email = $data->get("email");

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Oferta de empleo"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        if (!is_null($imagen)) {
            $img = '<img src="'.asset('imagenes_cargos/'.$imagen->nombre).'" width="190" height="190" align="middle">';
            $mailBody = $img . "<br><br><br>
                 Hola {$nombre_destino}, {$nombre} te ha compartido la siguiente oferta laboral. Si cumples con el perfil y estás interesad@, te invitamos a postularte y si no, compártela con tus conocidos.";
        } else {
            $mailBody = "
                 Hola {$nombre_destino}, {$nombre} te ha compartido la siguiente oferta laboral. Si cumples con el perfil y estás interesad@, te invitamos a postularte y si no, compártela con tus conocidos.";
        }

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'VER OFERTA LABORAL', 'buttonRoute' => route('home.detalle_oferta', ['oferta_id' => $req_id])];

        $mailUser = null; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($email) {

                $message->to($email);
                $message->subject('Oferta de Empleo')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });
        //Para Komatsu, dejar como esta en la instancia

        return redirect()->route("home.detalle_oferta",['oferta_id' =>$req_id])->with("status", "Se ha enviado el correo a su destinatario.");
    }

    public function aplicar_oferta($req, Request $data)
    {
        session(["req_aplica_oferta" => $req]);
        
        if (Sentinel::check()) {
            return redirect()->route("dashboard");
        } else {
            return redirect()->route("login");
        }
    }

    //Responder pregunta filtro
    public function responder_preguntas_filtro($req_id, $cargo_id)
    {
        if(Sentinel::check()){
            $requerimiento = Requerimiento::find($req_id);

            $pregunta = Pregunta::leftjoin("preg_req_resp", function ($join) {
                $join->on("preg_req_resp.preg_id", "=", "preguntas.id")
                ->on("preg_req_resp.user_id", "=", DB::raw($this->user->id));
            })
            ->join('tipo_pregunta', 'tipo_pregunta.id', '=', 'preguntas.tipo_id')
            ->where('preguntas.cargo_especifico_id', $requerimiento->cargo_especifico_id)
            ->orWhere('preguntas.requerimiento_id', $requerimiento->id)
            ->where('preguntas.activo', 1)
            ->where('preguntas.filtro', 1)
            ->select(
                'preguntas.*',
                'preguntas.id as req_preg_id',

                'tipo_pregunta.descripcion as descr_tipo_p'
            )
            ->first();

            $cargo_id = $requerimiento->cargo_especifico_id;

            return view("home.responder_preguntas", compact(
                "cargo_id",
                "pregunta",
                "tipo_pregunta",
                "req_id"
            ));
        }else{
            return redirect()->route("login");
        }
    }

    //Guardar respuesta pregunta filtro
    public function guardar_respuestas(Request $data)
    {
        $cargo_id = $data->cargo_id;
        $req_id = $data->req_id;

        //Crea variable de session para ejecutar aplicar a oferta en layout master
        session(["req_preg_resp" => $data->req_id]);

        foreach($data->respuesta_filtro as $key => $respuesta_id) {
            //Busca respuesta contestada
            $respuestas = Respuesta::join('preguntas', 'preguntas.id', '=', 'respuestas.preg_id')
            ->where('respuestas.id', $respuesta_id)
            ->select('respuestas.*', 'respuestas.descripcion_resp as descripcion')
            ->first();

            if($respuestas->minimo == 1){
                //Guarda respuesta
                $nueva_resp_preg = new PregReqResp();

                $nueva_resp_preg->fill([
                    "cargo_especifico_id" => $data->cargo_id, 
                    "req_id"              => $data->req_id,
                    "preg_id"             => $respuestas->preg_id,
                    "descripcion"         => $respuestas->descripcion,
                    "user_id"             => $this->user->id,
                    "puntuacion"          => 0
                ]);
                $nueva_resp_preg->save();

                //Buscar si hay más preguntas filtro
                $preguntas_filtro_requerimiento = Pregunta::where('preguntas.requerimiento_id', $req_id)
                ->where('preguntas.activo', 1)
                ->where('preguntas.filtro', 1)
                ->whereNotIn('preguntas.tipo_id', [4])
                ->count();

                $preguntas_filtro_cargo = Pregunta::where('preguntas.cargo_especifico_id', $cargo_id)
                ->where('preguntas.activo', 1)
                ->where('preguntas.filtro', 1)
                ->whereNotIn('preguntas.tipo_id', [4])
                ->count();

                $total_preguntas_filtro = $preguntas_filtro_requerimiento + $preguntas_filtro_cargo;

                if ($total_preguntas_filtro > 0) {
                    $respuestas_preguntas = PregReqResp::join('preguntas', 'preguntas.id', '=', 'preg_req_resp.preg_id')
                    ->where('preg_req_resp.user_id', $this->user->id)
                    ->where('preg_req_resp.req_id', $req_id)
                    ->whereNotIn('preguntas.tipo_id', [4])
                    ->orderBy('preguntas.id', 'ASC')
                    ->count();

                    if($respuestas_preguntas <= 0) {
                        return redirect()->route("home.responder_preguntas", [
                            "req_id" => $req_id,
                            "cargo_id" => $cargo_id
                        ]);
                    }
                }

                //Buscar si hay más preguntas de puntaje o abiertas
                $preguntas_aplica_requerimiento = Pregunta::where('preguntas.requerimiento_id', $req_id)
                ->where('preguntas.activo', 1)
                ->where('preguntas.filtro', 0)
                ->orWhere('preguntas.filtro', null)
                ->whereNotIn('preguntas.tipo_id', [4])
                ->count();

                $preguntas_aplica_cargo = Pregunta::where('preguntas.cargo_especifico_id', $cargo_id)
                ->where('preguntas.activo', 1)
                ->where('preguntas.filtro', 0)
                ->orWhere('preguntas.filtro', null)
                ->whereNotIn('preguntas.tipo_id', [4])
                ->count();

                $total_preguntas = $preguntas_aplica_requerimiento + $preguntas_aplica_cargo;

                if ($total_preguntas > 0) {
                    $respuestas_preguntas = PregReqResp::join('preguntas', 'preguntas.id', '=', 'preg_req_resp.preg_id')
                    ->where('preg_req_resp.user_id', $this->user->id)
                    ->where('preg_req_resp.req_id', $req_id)
                    ->whereNotIn('preguntas.tipo_id', [4, 2])
                    ->orderBy('preguntas.id', 'ASC')
                    ->count();

                    //Si no hay respuestas
                    if($respuestas_preguntas <= 0) {
                        return redirect()->route("home.responder_preguntas_oferta", [
                            "req_id" => $req_id,
                            "cargo_id" => $cargo_id
                        ]);
                    }
                }

                //Busca si hay preguntas de idioma
                $preguntas_idioma = Pregunta::join('tipo_pregunta', 'tipo_pregunta.id', '=', 'preguntas.tipo_id')
                ->select('preguntas.id as req_preg_id', 'preguntas.*', 'tipo_pregunta.descripcion as descr_tipo_p')
                ->where('preguntas.cargo_especifico_id', $cargo_id)
                ->where('preguntas.activo', 1)
                ->where('preguntas.tipo_id', 4)
                ->orderBy('preguntas.id', 'ASC')
                ->count();

                if ($preguntas_idioma > 0) {
                    return redirect()->route("home.responder_preguntas_prueba_idioma", [$data->req_id, $data->cargo_id]);
                }

                //Si no, al dashboard
                session(["req_preg_resp" => $data->req_id]);

                return redirect()->route("dashboard");
            }else{
                //Sigue intentando
                Session::forget('req_preg_resp');

                //Guarda respuesta
                $nueva_resp_preg = new PregReqResp();

                $nueva_resp_preg->fill([
                    "cargo_especifico_id" => $data->cargo_id, 
                    "req_id"              => $data->req_id,
                    "preg_id"             => $respuestas->preg_id,
                    "descripcion"         => $respuestas->descripcion,
                    "user_id"             => $this->user->id,
                    "puntuacion"          => 0
                ]);
                $nueva_resp_preg->save();

                $oferta_no_aplica = OfertaUser::where("user_id", $this->user->id)
                ->where("requerimiento_id", $data->req_id)
                ->get();

                if (count($oferta_no_aplica) == 0) {
                    $user = Sentinel::getUser();

                    $aplicar = new OfertaUser();
                    
                    $aplicar->fill([
                        "user_id"          => $this->user->id,
                        "requerimiento_id" => $data->req_id,
                        "fecha_aplicacion" => date("Y-m-d H:i:s"),
                        "cedula"           => $user->getDatosBasicos()->numero_id,
                        "aplica"           => 0
                    ]);
                    $aplicar->save();
                }

                return redirect()->route("dashboard")->with("no_aplica", true);
            }
        }
    }

    //Responder pregunta abierta
    public function responder_preguntas_puntaje($req_id, Request $data)
    { 
        if(Sentinel::check()) {
            $requerimiento = Requerimiento::find($req_id);

            $preguntas_oferta = Pregunta::join('tipo_pregunta', 'tipo_pregunta.id', '=', 'preguntas.tipo_id')
            ->where('preguntas.cargo_especifico_id', $requerimiento->cargo_especifico_id)
            ->orWhere('preguntas.requerimiento_id', $requerimiento->id)
            ->where('preguntas.activo', 1)
            ->where(function ($where) {
                $where->where('preguntas.filtro', 0)
                ->orWhere("preguntas.filtro", null);
            })
            ->select(
                'preguntas.id as req_preg_id',
                'preguntas.*',

                'tipo_pregunta.descripcion as descr_tipo_p'
            )
            ->orderBy('preguntas.id', 'DESC')
            ->get();

            $cargo_id = $requerimiento->cargo_especifico_id;

            return view("home.responder_preguntas_puntaje", compact(
                "preguntas_oferta",
                "cargo_id",
                "req_id"
            ));
        }else{
            return redirect()->route("login");
        }
    }   

    //Guardar respuesta pregunta
    public function guardar_respuestas_puntaje(Request $data)
    {
        //Crea variable de session para ejecutar aplicar a oferta en layout master
        session(["req_preg_resp" => $data->req_id]);

        $total_global_unica = 0;
        $total_global_multiple = 0;

        //Selección múltiple con única respuesta
        if($data->has('pregunta_unica_id')){
            $preguntas_ids = array();

            foreach($data->respuesta_unica as $key => $respuesta){
                $opcionesPregunta = Respuesta::where('respuestas.id', $respuesta)
                ->select(
                    'respuestas.puntuacion as puntuacion',
                    'respuestas.preg_id as preg_id',
                    'respuestas.id as id',
                    'respuestas.descripcion_resp as des'
                )
                ->first();

                $nueva_resp_preg = new PregReqResp();

                $nueva_resp_preg->fill([
                    "cargo_especifico_id" => $data->cargo_id, 
                    "req_id"              => $data->req_id,
                    "preg_id"             => $opcionesPregunta->preg_id,
                    "descripcion"         => $opcionesPregunta->des,
                    "user_id"             => $this->user->id,
                    "puntuacion"          => $opcionesPregunta->puntuacion,
                ]);
                $nueva_resp_preg->save();

                //Busca registros de resultado
                $resultado_pregunta = ResultadoPreguntaCandidatoAplica::where('preg_id', $opcionesPregunta->preg_id)
                ->where('req_id', $data->req_id)
                ->where('user_id', $this->user->id)
                ->first();

                if(count($resultado_pregunta) == 0 || count($resultado_pregunta) == null) {
                    $nuevo_resultado = new ResultadoPreguntaCandidatoAplica();

                    $nuevo_resultado->fill([
                        'req_id'            => $data->req_id,
                        'cargo_id'          => $data->cargo_id,
                        'preg_id'           => $opcionesPregunta->preg_id,
                        'user_id'           => $this->user->id,
                        'total_resultado'   => $opcionesPregunta->puntuacion,
                    ]);
                    $nuevo_resultado->save();
                }else {
                    $resultado_pregunta->total_resultado = $resultado_pregunta->total_resultado + $opcionesPregunta->puntuacion;
                    $resultado_pregunta->save();
                }

                array_push($preguntas_ids, $opcionesPregunta->preg_id);
            }

            foreach ($preguntas_ids as $id) {
                $pregunta_peso_porcentual = Pregunta::where('id', $id)->select('peso_porcentual')->first();

                $resultado_pregunta_2 = ResultadoPreguntaCandidatoAplica::where('preg_id', $id)
                ->where('req_id', $data->req_id)
                ->where('user_id', $this->user->id)
                ->select('total_resultado')
                ->first();

                $porcentaje_pregunta = number_format(($resultado_pregunta_2->total_resultado * $pregunta_peso_porcentual->peso_porcentual)/100, 1);

                // \Log::info("porcentaje_pregunta $porcentaje_pregunta");

                $resultado_candidato = new ResultadoCandidatoAplica();

                $resultado_candidato->fill([
                    'req_id'                    => $data->req_id,
                    'cargo_id'                  => $data->cargo_id,
                    'preg_id'                   => $id,
                    'user_id'                   => $this->user->id,
                    'total_resultado_pregunta'  => $porcentaje_pregunta
                ]);
                $resultado_candidato->save();

                $total_global_unica = $total_global_unica + $porcentaje_pregunta;
            }
        }

        //Selección múltiple con múltiple respuesta
        if($data->has('pregunta_multiple_id')){
            $preguntas_multiple_ids = array();

            foreach ($data->respuestas_multiple as $index => $respuesta) {
                $opcionesPregunta = Respuesta::where('respuestas.id', $respuesta)
                ->select(
                    'respuestas.puntuacion as puntuacion',
                    'respuestas.preg_id as preg_id',
                    'respuestas.id as id',
                    'respuestas.descripcion_resp as descripcion'
                )
                ->first();

                $nueva_resp_preg = new PregReqResp();

                $nueva_resp_preg->fill([
                    "cargo_especifico_id" => $data->cargo_id,
                    "req_id"              => $data->req_id,
                    "preg_id"             => $opcionesPregunta->preg_id,
                    "descripcion"         => $opcionesPregunta->descripcion,
                    "user_id"             => $this->user->id,
                    "puntuacion"          => $opcionesPregunta->puntuacion,
                ]);

                $nueva_resp_preg->save();

                //Busca registros de resultado
                $resultado_pregunta = ResultadoPreguntaCandidatoAplica::where('preg_id', $opcionesPregunta->preg_id)
                ->where('req_id', $data->req_id)
                ->where('user_id', $this->user->id)
                ->first();

                if(count($resultado_pregunta) == 0 || count($resultado_pregunta) == null) {
                    $nuevo_resultado = new ResultadoPreguntaCandidatoAplica();

                    $nuevo_resultado->fill([
                        'req_id'            => $data->req_id,
                        'cargo_id'          => $data->cargo_id,
                        'preg_id'           => $opcionesPregunta->preg_id,
                        'user_id'           => $this->user->id,
                        'total_resultado'   => $opcionesPregunta->puntuacion,
                    ]);
                    $nuevo_resultado->save();
                }else {
                    $resultado_pregunta->total_resultado = $resultado_pregunta->total_resultado + $opcionesPregunta->puntuacion;
                    $resultado_pregunta->save();
                }

                array_push($preguntas_multiple_ids, $opcionesPregunta->preg_id);
            }

            //\Log::info("preguntas_multiple_ids $preguntas_multiple_ids");

            $preguntas_multiple_nuevos = array_unique($preguntas_multiple_ids); //Quita ids duplicados

            //\Log::info("preguntas_multiple_nuevos $preguntas_multiple_nuevos");

            foreach ($preguntas_multiple_nuevos as $id) {
                $pregunta_peso_porcentual = Pregunta::where('id', $id)->select('peso_porcentual')->first();

                $resultado_pregunta_2 = ResultadoPreguntaCandidatoAplica::where('preg_id', $id)
                ->where('req_id', $data->req_id)
                ->where('user_id', $this->user->id)
                ->select('total_resultado')
                ->first();

                $porcentaje_pregunta = number_format(($resultado_pregunta_2->total_resultado * $pregunta_peso_porcentual->peso_porcentual)/100, 1);

                $resultado_candidato = new ResultadoCandidatoAplica();

                $resultado_candidato->fill([
                    'req_id'                    => $data->req_id,
                    'cargo_id'                  => $data->cargo_id,
                    'preg_id'                   => $id,
                    'user_id'                   => $this->user->id,
                    'total_resultado_pregunta'  => $porcentaje_pregunta
                ]);
                $resultado_candidato->save();

                $total_global_multiple = $total_global_multiple + $porcentaje_pregunta;
            }
        }

        //Abierta
        if($data->has('pregunta_abierta_id')) {
            foreach($data->pregunta_abierta_id as $index => $pregunta){
                $respuesta_pregunta_oferta = new PregReqResp();

                $respuesta_pregunta_oferta->fill([
                    "cargo_especifico_id" => $data->cargo_id, 
                    "req_id"              => $data->req_id,
                    "preg_id"             => $pregunta,
                    "descripcion"         => $data->respuesta_pregunta_abierta[$index],
                    "user_id"             => $this->user->id,
                    "puntuacion"          => '',
                ]);

                $respuesta_pregunta_oferta->save();
            }
        }

        $total_global = $total_global_unica + $total_global_multiple;

        $resultado_general = new ResultadoGeneralAplica();

        $resultado_general->fill([
            'req_id'        => $data->req_id,
            'cargo_id'      => $data->cargo_id,
            'user_id'       => $this->user->id,
            'total_global'  => $total_global
        ]);
        $resultado_general->save();

        //Verifica si existen pregunta de idiomas
        $checkPregIdioma = Pregunta::where('cargo_especifico_id', $data->cargo_id)
        ->where('tipo_id', 4)
        ->get();

        if(count($checkPregIdioma) === 0){
            return redirect()->route("dashboard");
        }else{
            return redirect()->route("home.responder_preguntas_prueba_idioma", [$data->req_id, $data->cargo_id]);
        }
    }

    //--
    public function responder_preguntas_prueba_idioma($req_id,Request $data)
    {
        session(["req_preg_resp" => $req_id]);

        if( Sentinel::check() ) {
            $req = Requerimiento::where('id', $req_id)->select('requerimientos.*')->first();

            $pregunta = Pregunta::leftjoin("preg_req_resp", function ($join) {
                $join->on("preg_req_resp.preg_id", "=", "preguntas.id")
                ->on("preg_req_resp.user_id", "=",DB::raw($this->user->id));
            })
            ->join('tipo_pregunta','tipo_pregunta.id','=','preguntas.tipo_id')
            ->select('preguntas.id as req_preg_id','preguntas.*','tipo_pregunta.descripcion as descr_tipo_p')
            ->where('preguntas.cargo_especifico_id',$req->cargo_especifico_id)
            ->where('preguntas.activo',1)
            ->where('preguntas.tipo_id',4)
            ->get();

            $preguntaCount = count($pregunta);

            $preguntaRespCount = Pregunta::join('preg_req_resp', 'preg_req_resp.preg_id', '=', 'preguntas.id')
            ->where('preg_req_resp.user_id', $this->user->id)
            ->count();

            if($preguntaRespCount === $preguntaCount){
                return redirect()->route('home');
            }else{
                $cargo_id = $req->cargo_especifico_id;

                $user_id = $this->user->id;

                return view("home.responder_preguntas_prueba_idioma", compact(
                    "cargo_id",
                    "pregunta",
                    "tipo_pregunta",
                    "req_id",
                    "cliente",
                    "negocio",
                    "user_id",
                    "preguntaRespCount",
                    "preguntaCount"
                ));
            }
        }else{
            return redirect()->route("login");
        }
    }

    public function responder_pregunta_idioma_oferta_view(Request $data)
    {
        if( Sentinel::check() ) {
            $req_id   = $data->req_id;
            $preg_id  = $data->preg_id;
            $cargo_id = $data->cargo_id;
            $preguntaRespCount = $data->preguntaRespCount;
            $preguntaCount = $data->preguntaCount;

            $req = Requerimiento::where('id', $req_id)->select('requerimientos.*')->first();

            $pregunta = Pregunta::leftjoin("preg_req_resp", function ($join) {
                $join->on("preg_req_resp.preg_id", "=", "preguntas.id")
                ->on("preg_req_resp.user_id", "=",DB::raw($this->user->id));
            })
            ->join('tipo_pregunta','tipo_pregunta.id','=','preguntas.tipo_id')
            ->select('preguntas.id as req_preg_id','preguntas.*','tipo_pregunta.descripcion as descr_tipo_p')
            ->where('preguntas.cargo_especifico_id',$req->cargo_especifico_id)
            ->where('preguntas.id', $preg_id)
            ->where('preguntas.activo',1)
            ->where('preguntas.tipo_id',4)   
            ->first();            

            return view("home.modal.responder_pregunta_idioma_oferta", compact('pregunta','cargo_id','req_id','preguntaRespCount','preguntaCount'));
        }else{
            return redirect()->route("login");
        }
    }

    public function guardar_respuestas_prueba_idioma(Request $data)
    {
        $nueva_resp_preg = new PregReqResp();

        $nueva_resp_preg->fill([
            "req_id"              => $data->req_id,
            "puntuacion"          => 0,
            "user_id"             => $this->user->id,
            "cargo_especifico_id" => $data->cargo_id,
            "preg_id"             => $data->preg_app_id,
        ]);
        
        $nueva_resp_preg->save();

        //GUARDANDO VIDEO
        $archivo   = $data->file('video-blob');
        $extencion = $archivo->getClientOriginalExtension();
        $fileName  = "VideoRespuestaOfertaIdioma". $this->user->id ."_". $data->preg_app_id  . ".$extencion";
        
        if (file_exists("recursos_VideoOfertaIdioma/" . $fileName)) {
            unlink("recursos_VideoOfertaIdioma/" . $fileName);
        }
        
        $nueva_resp_preg->descripcion = $fileName;
        $nueva_resp_preg->save();

        $data->file('video-blob')->move("recursos_VideoOfertaIdioma", $fileName);
        
        //return redirect()->route("dashboard");
        return response()->json(["success" => true]);
    }
    
    //--
    public function pagenotfound()
    {
        return view("errors.404");
    }

    public function ver_videoperfil($candidato)
    {
        $user = User::where("id", $candidato)->select("*")->first();
        return view("home.ver_videoperfil",compact("user"));
    }

    /*
    *   Construye y envía sms
    */
    /*private function ValidarSMSCodigo($destino, $codigo,$datos)
    {
        $url = 'https://cloud.go4clients.com:8580/api/campaigns/sms/v1.0/'.config('conf_aplicacion.VARIABLES_ENTORNO.GO4CLIENTS.sms');

        $data = array(
            'destinationsList' => [$destino],
            "priority" => "HIGH",
            'message' => "El código de validación es: ".$codigo,
        );


        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data),
                'header'  => array("Content-Type: application/json", "apiKey: fbfc74edc94c4377a6be329924b65e20", "apiSecret: 5331739984726387"),
            ),
            "ssl" => array(
		        "verify_peer" => false,
		        "verify_peer_name" => false,
		    ),
        );

        $context  = stream_context_create($options);
        $result   = file_get_contents($url, false, $context);

        $response = json_decode($result);

        $message_wp="Hola $datos->primer_nombre, *".$codigo."* ✍️ es tu código de verificación para la firma de contrato, por favor ingresa este número en la casilla código. ";

        event(new \App\Events\NotificationWhatsappEvent($destino,$message_wp));
    
    }*/

    private function validarSmsCodigo($destino, $codigo, $datos) 
    {
        //$sitio = Sitio::first();
        //$instancia = config('conf_aplicacion.VARIABLES_ENTORNO.INSTANCIA_API_ID');

        //$message_wp = "Hola $datos->primer_nombre, *".$codigo."* ✍️ es tu código de verificación para la firma de contrato, por favor ingresa este número en la casilla código. ";

        /*$sms = new Client();

        $response = $sms->post('https://api.t3rsc.co/api/calls/sms',
            [
                "headers" => [
                    'Authorization'     => ['Bearer '.$sitio->token_api]
                ],
                'form_params' => [
                    'instancia' => $instancia,
                    'mensaje' => "El código de validación es: ".$codigo,
                    'destino' => $destino
                ]
            ]
        );*/

        event(new \App\Events\SmsEvent("El código de validación es: ".$codigo,$destino));

        $motivo_codigo = "la firma de contrato";
        event(new \App\Events\NotificationWhatsappEvent(
            "whatsapp", 
            substr($destino, 2),
            "template", 
            "envio_codigo_validaciones", 
            [$datos->primer_nombre, $codigo, $motivo_codigo]
        ));


    }

    public function informacionTrabajador($id)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->join("users", "users.id", "=", "datos_basicos.user_id")
        ->leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
        ->join('procesos_candidato_req', 'procesos_candidato_req.requerimiento_candidato_id', '=', 'requerimiento_cantidato.id')
        ->where("datos_basicos.user_id", $id)
        ->select(
            "datos_basicos.*",
            "tipo_identificacion.descripcion as dec_tipo_doc",
            "requerimiento_cantidato.id as req_candidato",
            "requerimiento_cantidato.requerimiento_id as req",
            "users.foto_perfil",
            "users.avatar"
        )
        ->orderBy("requerimiento_cantidato.id", "DESC")
        ->first();

        $contrato = "";

        $req = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->leftjoin("tipos_contratos", "tipos_contratos.id", "=", "requerimientos.tipo_contrato_id")
        ->leftjoin("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
        ->select(
            "cargos_especificos.descripcion as cargo",
            "requerimientos.id",
            "tipo_proceso.descripcion as tipo_proceso_desc",
            "tipos_contratos.descripcion as tipo_contrato",
            "negocio.num_negocio",
            "requerimientos.cargo_especifico_id",
            "requerimientos.empresa_contrata",
            "clientes.nit",
            "clientes.nombre as nombre_cliente",
            "requerimientos.id as req_id"
        )
        ->groupBy('requerimientos.id')
        ->find($candidato->req);

        $requerimientoContratoCandidato = RequerimientoContratoCandidato::where('requerimiento_id', $candidato->req)->where('candidato_id', $id)
        ->select('fecha_ingreso')
        ->orderBy('requerimiento_contrato_candidato.created_at', 'DESC')
        ->first();

        //empresa contrata aqui
        if($req->empresa_contrata){
            $empresa = DB::table("empresa_logos")->where('id', $req->empresa_contrata)->first();
        }


        return view('home.datos-trabajador', compact('candidato', 'req', 'requerimientoContratoCandidato'));
    }

    public function temas_ayuda_admin() {
        $ayudas = DB::table("ayuda")->where('active', 'enabled')->where('modulo', 'admin')->get();

        return view("home.ayuda_admin", compact("ayudas"));
    }
}
