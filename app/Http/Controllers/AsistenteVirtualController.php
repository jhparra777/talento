<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sitio;
use App\Models\ReqCandidato;
use Illuminate\Http\Request;
use App\Models\AsistenteCita;
use App\Models\Requerimiento;
use App\Helpers\triPostmaster;
use App\Models\LlamadaMensaje;
use Illuminate\Support\Facades\DB;
use App\Models\ControlFuncionalidad;
use Illuminate\Support\Facades\Mail;
use App\Models\EstadosRequerimientos;
use App\Models\TrazabilidadFuncionalidad;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Controllers\ReclutamientoController;
use App\Models\AsistenteCitaAgendamientoCandidato;
use GuzzleHttp\Client;
use Bitly;
use Illuminate\Support\Facades\Event;

class AsistenteVirtualController extends Controller
{
    protected $estados_no_muestra = [];

    public function __construct()
    {
        parent::__construct();

        $this->estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
            config('conf_aplicacion.C_TRANSFERIDO'),
        ];
    }

    public function asistente(Request $request)
    {
        $this->validate($request, [
            'candidatos_llamar' => 'required',
        ]);

        $modulo = $request->get("modulo");

        $req_cand = $request->get("candidatos_llamar");
        $req_id = $request->get("req_id");

        $explo = explode(' ', $this->user->name);
        $name = $explo[0];

        //para tiempos
        $gestiona  = str_replace(array("á","é","í","ó","ú","ñ"), array("a","e","i","o","u","n"), $name);

        $nombres = [];
        $numeros = [];
        $req_ids = [];

        $todos = "";

        if(isset($request->seleccionar_todos_candidatos_vinculados)) {
            $nombres_candidatos = DB::table("requerimiento_cantidato")
            ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.requerimiento_id", $req_id)
            ->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_INACTIVO'))
            ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
            ->select('datos_basicos.nombres', 'datos_basicos.telefono_movil')
            ->get();

            foreach($nombres_candidatos as $candidato) {
                array_push($nombres, $candidato->nombres);
                array_push($numeros, env("INDICATIVO", "57").$candidato->telefono_movil);
            }
        }else {
            foreach ($req_cand as $key => $value) {
                //$num                = substr($value, 2);
                $nombres_candidatos = DB::table("requerimiento_cantidato")
                ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->where("requerimiento_cantidato.id", $value)
                ->select('datos_basicos.nombres', 'datos_basicos.telefono_movil', 'requerimiento_cantidato.requerimiento_id')
                ->first();

                $index = env("INDICATIVO","57").$nombres_candidatos->telefono_movil;
                $req_ids["$index"] = $nombres_candidatos->requerimiento_id;
                array_push($nombres, $nombres_candidatos->nombres);
                array_push($numeros, env("INDICATIVO","57").$nombres_candidatos->telefono_movil);
            }
        }

        //para tiempos
        $cliente = Requerimiento::join("negocio","negocio_id", "=", "requerimientos.negocio_id")
        ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
        ->where("requerimientos.id", $req_id)
        ->select(
            "clientes.nombre as nombre_cliente",
            "clientes.direccion as direccion_cliente",
            "clientes.contacto as contacto_cliente"
        )
        ->first();

        $nombres = implode(",", $nombres);
        $numeros = implode(",", $numeros);
        $req_ids = json_encode($req_ids);

        $cliente->contacto_cliente = str_replace(array("á", "é", "í", "ó", "ú", "ñ"), array("a", "e", "i", "o", "u", "n"), $cliente->contacto_cliente);

        $valor = null;

        if($modulo == "contratacion"){
            $valor = "Buen día. Bienvenid@ a nuestro proceso de contratación. Para dar inicio solicitamos se presente en la dirección y horario especificado:";
        }

        /**
         * Revisar si hay citas
         */

        $horario_ocupado = $this->validar_agendamiento_horario();

        return view("admin.reclutamiento.asistente_virtual.asistente", compact(
            'numeros',
            'req_id',
            'nombres',
            'cliente',
            'req_ids',
            'gestiona',
            "modulo",
            "valor",
            "horario_ocupado"
        ))->with("mensaje_success", "Se ha enviado la llamada con éxito.");
    }

    public function asistente_post(Request $request)
    {
        $reclutamiento_funciones = new ReclutamientoController();
        $sitio = Sitio::first();

        //Para el agendamiento
        $tipo_cita = $request->tipo_cita;

        //Validar tipo cita
        if ($tipo_cita == 'with') {
            $this->validate($request, [
                'asunto_cita' => 'required',
                'fecha_cita' => 'required',
                'hora_inicio' => 'required',
                'hora_fin' => 'required',
                'duracion_cita' => 'required',
                'mensaje' => 'required|max:1024',
                'numeros' => 'required',
                'asunto' => 'required',
            ]);
        }else {
            $this->validate($request, [
                'mensaje' => 'required|max:1024',
                'asunto' => 'required',
                'numeros' => 'required',   
            ]);
        }

        $modulo = $request->get("modulo");

        if($modulo == "seleccion") {
            $modulo_id = 1;
        }else {
            $modulo_id = 2;
        }
        $asunto_titulo = $request->get("asunto");
        if(!$request->has("solo_correo")) {
            //La funcionalidad es Llamada mensaje - Obtiene el tipo de funcionalidad y su limite.
            $ControlLimite = ControlFuncionalidad::join('tipo_funcionalidad_avanzada', 'tipo_funcionalidad_avanzada.id', '=', 'control_funcionalidad.tipo_funcionalidad')
            ->where('control_funcionalidad.tipo_funcionalidad', 4)
            ->select(
                'control_funcionalidad.*',
                'control_funcionalidad.id as id_control',
                'tipo_funcionalidad_avanzada.*'
            )
            ->first();

            //Obtiene el mes actual.
            $mes = date("n");

            //Obtiene el número de registros de acuerdo a la funcionalidad y el mes.
            $TrazabilidadConteo = TrazabilidadFuncionalidad::join('control_funcionalidad', 'control_funcionalidad.id', '=', 'trazabilidad_funcionalidades.control_id')
            ->where('control_funcionalidad.tipo_funcionalidad', 4)
            ->whereMonth('trazabilidad_funcionalidades.created_at', '=', $mes)
            ->count();

            if($TrazabilidadConteo == $ControlLimite->limite){
                return redirect()->back()->with('mensaje_limite', 'Has llegado a tu límite mensual de esta funcionalidad.');
            }elseif($TrazabilidadConteo >= $ControlLimite->limite){
                return redirect()->back()->with('mensaje_limite', 'Has llegado a tu límite mensual de esta funcionalidad.');
            }else{
                $destino = $request->get('numeros');
                $req_id  = $request->get('req_id');
                $mensaje = $request->get('mensaje');
                $req_ids = json_decode($request->req_ids, true);

                if($modulo == "contratacion") {
                    $reclutamiento_funciones->ValidarLlamadaContratacion($destino, $mensaje);
                }else {
                    $this->ValidarLlamada($destino, $mensaje);
                }

                $destino = explode(",", $destino);

                //Valida el tipo de cita
                switch($tipo_cita) {
                    case 'with':
                        if (isset($request->req_id) && $request->req_id != '') {
                            //Crea el registro de cita
                            $nuevo_asistente_cita = new AsistenteCita();

                            $nuevo_asistente_cita->fill([
                                'req_id'        => $request->req_id,
                                'gestion_id'    => $this->user->id,
                                'asunto_cita'   => $request->asunto_cita,
                                'fecha_cita'    => $request->fecha_cita,
                                'hora_inicio'   => $request->hora_inicio,
                                'hora_fin'      => $request->hora_fin,
                                'duracion_cita' => $request->duracion_cita
                            ]);
                            $nuevo_asistente_cita->save();
                        } elseif (count($req_ids) > 0) {
                            $req_agregado = [];
                            foreach ($req_ids as $id_req) {
                                if (in_array($id_req, $req_agregado)) {
                                    $req_agregado[] = $id_req;
                                    //Crea el registro de cita
                                    $nuevo_asistente_cita = new AsistenteCita();

                                    $nuevo_asistente_cita->fill([
                                        'req_id'        => $id_req,
                                        'gestion_id'    => $this->user->id,
                                        'asunto_cita'   => $request->asunto_cita,
                                        'fecha_cita'    => $request->fecha_cita,
                                        'hora_inicio'   => $request->hora_inicio,
                                        'hora_fin'      => $request->hora_fin,
                                        'duracion_cita' => $request->duracion_cita
                                    ]);
                                    $nuevo_asistente_cita->save();
                                }
                            }
                        }
                        break;
                    default:
                        // nothing
                        break;
                }

                //Recorrer los números de celular para gestionar proceso
                foreach($destino as $des) {
                    if($modulo != "seleccion") {
                        $req_id = $req_ids[$des];
                    }

                    if(env("INDICATIVO") != null) {
                        $num = substr($des, strlen(env("INDICATIVO")));
                    }else {
                        $num = substr($des, 2);
                    }

                    $nombres_candidatos = DB::table("requerimiento_cantidato")
                    ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                    ->select(
                        'datos_basicos.user_id as user_id',
                        'datos_basicos.telefono_movil',
                        'datos_basicos.nombres',
                        'datos_basicos.numero_id',
                        'datos_basicos.email as email_candidato',
                        'datos_basicos.primer_apellido as primer_apellido',
                        'datos_basicos.segundo_apellido as segundo_apellido'
                    )
                    ->where("datos_basicos.telefono_movil", $num)
                    ->first();

                    //Guarda mensajes
                    for ($i = 0; $i < $request->get('mensaje_enviar'); $i++) {
                        TrazabilidadFuncionalidad::create([
                            'control_id'         => $ControlLimite->id_control,
                            'tipo_funcionalidad' => 4,
                            'user_gestion'       => Sentinel::getUser()->id,
                            'req_id'             => $req_id,
                            'empresa'            => '',
                            'descripcion'        => 'LLAMADA Y MENSAJE VIRTUAL',
                        ]);
                    }

                    //Guarda las llamadas
                    $nueva_llamada_mensaje                   = new LlamadaMensaje();

                    $nueva_llamada_mensaje->req_id           = $req_id;
                    $nueva_llamada_mensaje->nombre_candidato = $nombres_candidatos->nombres;
                    $nueva_llamada_mensaje->telefono_movil   = $nombres_candidatos->telefono_movil;
                    $nueva_llamada_mensaje->numero_id        = $nombres_candidatos->numero_id;
                    $nueva_llamada_mensaje->num_msg          = $request->get('mensaje_enviar');
                    $nueva_llamada_mensaje->content_msg      = $mensaje;
                    $nueva_llamada_mensaje->user_llamada     = $this->user->id;
                    $nueva_llamada_mensaje->modulo           = $modulo_id;
                    $nueva_llamada_mensaje->save();

                    //Valida el tipo de cita
                    switch ($tipo_cita) {
                        case 'with':
                            //Crea el agendamiento de candidato
                            $nuevo_agendamiento_candidato = new AsistenteCitaAgendamientoCandidato();

                            $nuevo_agendamiento_candidato->fill([
                                'req_id'            => $req_id,
                                'cita_id'           => $nuevo_asistente_cita->id,
                                'user_id'           => $nombres_candidatos->user_id
                            ]);
                            $nuevo_agendamiento_candidato->save();

                            //Crea proceso de entrevista
                            $proceso = "ENVIO_ENTREVISTA";

                            $candidato_req = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                            ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                            ->where("requerimiento_cantidato.requerimiento_id", $req_id)
                            ->where("requerimiento_cantidato.candidato_id", $nombres_candidatos->user_id)
                            ->whereNotIn('requerimiento_cantidato.estado_candidato', [
                                config('conf_aplicacion.C_QUITAR'),
                                config('conf_aplicacion.C_INACTIVO')
                            ])
                            ->whereRaw('requerimiento_cantidato.id=(select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.requerimiento_id=requerimientos.id and requerimiento_cantidato.candidato_id=datos_basicos.user_id)')
                            ->select(
                                "requerimiento_cantidato.id as req_candidato_id"
                            )
                            ->orderBy("requerimiento_cantidato.id")
                            ->groupBy('datos_basicos.numero_id')
                            ->first();

                            $campos_proceso = [
                                'requerimiento_candidato_id' => $candidato_req->req_candidato_id,
                                'usuario_envio'              => $this->user->id,
                                "fecha_inicio"               => date("Y-m-d H:i:s"),
                                'proceso'                    => $proceso,
                            ];

                            $reclutamiento_funciones->RegistroProceso(
                                $campos_proceso,
                                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                                $candidato_req->req_candidato_id
                            );
                            break;
                        default:
                            // nothing
                            break;
                    }

                    //$url_email = route('home.detalle_oferta', ['oferta_id' => $req_id]);

                    $url_email = route('home.detalle_oferta_mensaje', [
                        'oferta_id' => $req_id, 'numero_id' => $nombres_candidatos->numero_id, 'llamada_id' => $nueva_llamada_mensaje->id
                    ]);

                    $analista = User::find($this->user->id);

                    // Usar administrador de correos

                        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                        $mailConfiguration = 1; //Id de la configuración
                        $mailTitle = $asunto_titulo; //Titulo o tema del correo
                        
                        //Cuerpo con html y comillas dobles
                        $mailBody = "
                            Hola $nombres_candidatos->nombres, te informamos que nuestro analista de selección <b>$analista->name</b> te ha enviado un mensaje: <br>
                            <i>$mensaje</i>
                        ";

                        //Validar el tipo de cita para asignar bóton
                        switch ($tipo_cita) {
                            case 'with':
                                $mailButton = ['buttonText' => 'Aceptar y reservar horario', 'buttonRoute' => route('login', ['scheduling' => 'true']) ];
                                break;
                            case 'without';
                                $mailButton = ['buttonText' => 'Detalle oferta', 'buttonRoute' => $url_email];
                                break;
                            default:
                                $mailButton = ['buttonText' => 'Detalle oferta', 'buttonRoute' => $url_email];
                                break;
                        }

                        $mailUser = $nombres_candidatos->user_id; //Id del usuario al que se le envía el correo

                        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                        //Enviar correo generado
                        Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($nombres_candidatos, $sitio, $asunto_titulo) {
                            $message->to([$nombres_candidatos->email_candidato], 'T3RS')
                            ->bcc($sitio->email_replica)
                            ->subject($asunto_titulo)
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                            
                        });
                    // Fin administrador correos

                    //Recortar nombre
                    $nombre = explode(" ", $nombres_candidatos->nombres);

                    //Llama función envío de mensaje
                    $this->ValidarSms(
                        $des,
                        $mensaje,
                        $req_id,
                        $nombre[0],
                        $nombres_candidatos->numero_id,
                        $nueva_llamada_mensaje->id,
                        $modulo,
                        $tipo_cita
                    );
                }

                if($modulo == "seleccion") {
                    $ruta = "admin/gestion-requerimiento/".$req_id;
                }else {
                    $ruta = "admin/asistente-contratacion";
                }

                //redirige a la gestion de ese requerimiento
                return redirect($ruta)->with("mensaje_success", "Se ha enviado la llamada con éxito.");
            }
        }else {

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = $asunto_titulo; //Titulo o tema del correo

            $destino = $request->get('numeros');
            $req_id  = $request->get('req_id');
            $mensaje = $request->get('mensaje');

            $destino = explode(",", $destino);

            //Para el agendamiento
            $tipo_cita = $request->tipo_cita;

            foreach($destino as $des) {
                if(env("INDICATIVO") != null) {
                    $num = substr($des, strlen(env("INDICATIVO")));
                }else {
                    $num = substr($des, 2);
                }

                $nombres_candidatos = DB::table("requerimiento_cantidato")
                ->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                ->select(
                    'datos_basicos.user_id as user_id',
                    'datos_basicos.telefono_movil',
                    'datos_basicos.nombres',
                    'datos_basicos.numero_id',
                    'datos_basicos.email as email_candidato',
                    'datos_basicos.primer_apellido as primer_apellido',
                    'datos_basicos.segundo_apellido as segundo_apellido'
                )
                ->where("datos_basicos.telefono_movil", $num)
                ->first();

                $url_email = route('home.detalle_oferta', ['oferta_id' => $req_id]);

                $analista = User::find($this->user->id);

                // Usar administrador de correos

                    $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                    $mailConfiguration = 1; //Id de la configuración
                    $mailTitle = $asunto_titulo; //Titulo o tema del correo
                    
                    //Cuerpo con html y comillas dobles
                    $mailBody = "
                        Hola $nombres_candidatos->nombres, te informamos que nuestro analista de selección <b>$analista->name</b> te ha enviado un mensaje: <br>
                        <i>$mensaje</i>
                    ";

                    //Validar el tipo de cita para asignar bóton
                    switch ($tipo_cita) {
                        case 'with':
                            $mailButton = ['buttonText' => 'Aceptar y reservar horario', 'buttonRoute' => route('login', ['scheduling' => 'true']) ];
                            break;
                        case 'without';
                            $mailButton = ['buttonText' => 'Detalle oferta', 'buttonRoute' => $url_email];
                            break;
                        default:
                            $mailButton = ['buttonText' => 'Detalle oferta', 'buttonRoute' => $url_email];
                            break;
                    }

                    $mailUser = $nombres_candidatos->user_id; //Id del usuario al que se le envía el correo

                    $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                    //Enviar correo generado
                    Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($nombres_candidatos,$asunto_titulo) {
                        $message->to([$nombres_candidatos->email_candidato], 'T3RS')
                        ->subject($asunto_titulo)
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                        
                        
                        
                    });
                // Fin administrador correos
            }

            if($modulo == "seleccion") {
                $ruta = "admin/gestion-requerimiento/".$req_id;
            }else {
                $ruta = "admin/asistente-contratacion";
            }

            //redirige a la gestion de ese requerimiento
            return redirect($ruta)->with("mensaje_success", "Se ha enviado el correo con éxito");
        }
    }

    /**
     * Revisar si hay citas
     */

    private function validar_agendamiento_horario(): array
    {
        $asistente_cita = AsistenteCita::where('gestion_id', $this->user->id)->orderBy('id', 'DESC')->first();

        $horario_ocupado = [];

        if(!empty($asistente_cita)) {
            $estado_req = EstadosRequerimientos::where('req_id', $asistente_cita->req_id)->orderBy('id', 'DESC')->first();

            $estados_terminados = array(3, 16, 19);

            // Validar si el req anterior esta terminado para no validar las horas
            if (!in_array($estado_req->estado, $estados_terminados)) {
                $hora_inicio = explode(":", $asistente_cita->hora_inicio);
                $hora_fin = explode(":", $asistente_cita->hora_fin);

                for ($i= $hora_inicio[0]; $i <= $hora_fin[0]; $i++) { 
                    array_push($horario_ocupado, (int) $i);
                }
            }
        }

        return $horario_ocupado;
    }

    private function validarLlamada($destino, $mensaje)
    {
        /*$sitio = Sitio::first();
        $instancia = config('conf_aplicacion.VARIABLES_ENTORNO.INSTANCIA_API_ID');

        $call = new Client();
        $response = $call->post('https://api.t3rsc.co/api/calls/calling', [
            "headers" => [
                'Authorization' => ['Bearer '.$sitio->token_api]
            ],
            'form_params' => [
                'instancia' => $instancia,
                'mensaje' => $mensaje,
                'destino' => explode(",", $destino)
            ]
        ]);
        */

        event(new \App\Events\CallingEvent($mensaje,$destino));
    }

    private function validarSms($destino, $mensaje, $req_id, $nombres, $numero_id, $llamada_id, $modulo = "seleccion", string $tipoCita = 'without') 
    {
        $sitio = Sitio::first();
        $instancia = config('conf_aplicacion.VARIABLES_ENTORNO.INSTANCIA_API_ID');

        if($modulo == "contratacion") {
            $urls = route('admin.carga_archivos_contratacion');
        }else {
            //Valida el tipo de cita
            switch ($tipoCita) {
                case 'with':
                    //Con agendamiento
                    //$urls = route('mis_ofertas');
                    $urls = route('login', ['scheduling' => 'true']);
                    //$urls = 'https://desarrollo.t3rsc.co/cv/login?scheduling=true';
                    break;
                case 'without':
                    //Sin agendamiento
                    $urls = route('home.detalle_oferta_mensaje', ['oferta_id' => $req_id, 'numero_id' => $numero_id, 'llamada_id' => $llamada_id]);
                    break;
                default:
                    $urls = route('home.detalle_oferta_mensaje', ['oferta_id' => $req_id, 'numero_id' => $numero_id, 'llamada_id' => $llamada_id]);
                    break;
            }
        }

        $url_oferta = Bitly::getUrl($urls);

        $texto="Hola " . $nombres . ", " . $mensaje . " " . $url_oferta;
        
        $sms = new Client();

        /*$response=$sms->post('https://api.t3rsc.co/api/calls/sms',
            [
                "headers"    =>[
                    'Authorization'     => ['Bearer '.$sitio->token_api]
                    ],
                    'form_params' =>[
                        'instancia'=>$instancia,
                        'mensaje'=>$texto,
                        'destino'=>$destino

                    ]
            ]


        );*/

        event(new \App\Events\SmsEvent($texto,$destino));

        event(new \App\Events\NotificationWhatsappEvent("message",[
            "phone"=>$destino,
            "body"=> $texto
        ]));

        event(new \App\Events\SmsEvent($texto,$destino));

    }
}
