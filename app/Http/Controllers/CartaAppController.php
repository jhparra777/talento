<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\CartappConfigFecha;
use App\Models\CartappPermisoSolicitud;
use App\Models\CartappSolicitudUser;
use App\Models\DatosBasicos;
use App\Models\Documentos;
use App\Models\Requerimiento;
use App\Models\RequerimientoContratoCandidato;
use App\Models\Sitio;
use App\Models\SitioModulo;

use Carbon\Carbon;
use Storage;
use triPostmaster;

class CartaAppController extends Controller
{
    public function adelanto_nomina()
    {
        if(empty($this->user->id)){
            session(["url_deseada_redireccion_candidato" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login');
        }
        $sitio_modulo = SitioModulo::first();
        if($sitio_modulo->carta_app != 'enabled') {
            return redirect("pagenotfound");
        }
        $mensaje = '';

        $menu = DB::table("menu_candidato")->where("estado", 1)->orderBy("orden")
            ->select("menu_candidato.*")
        ->get();

        setlocale(LC_TIME, 'Spanish');
        $fecha_hoy_carbon = Carbon::now();
        $mes_actual = $fecha_hoy_carbon->formatLocalized('%B');
        $dia_actual = (int)date('d');

        $periodo_permitido = false;
        $periodo_solicitud = '';
        $periodo_evaluar = CartappConfigFecha::where('mes', $mes_actual)->first();

        if (($dia_actual >= $periodo_evaluar->primer_periodo_dia_inferior) && ($dia_actual <= $periodo_evaluar->primer_periodo_dia_superior)) {
            $periodo_permitido = true;
            $periodo_solicitud = 'primer_periodo';

            $dia_inicio = $periodo_evaluar->primer_periodo_dia_inferior;
            $dia_cierre = $periodo_evaluar->primer_periodo_dia_superior;
        } elseif (($dia_actual >= $periodo_evaluar->segundo_periodo_dia_inferior) && ($dia_actual <= $periodo_evaluar->segundo_periodo_dia_superior)) {
            $periodo_permitido = true;
            $periodo_solicitud = 'segundo_periodo';

            $dia_inicio = $periodo_evaluar->segundo_periodo_dia_inferior;
            $dia_cierre = $periodo_evaluar->segundo_periodo_dia_superior;
        }

        if (!$periodo_permitido) {
            $mensaje = 'Periodo de solicitud de anticipos de nómina cerrado.';
            return view("cv.adelanto_nomina", compact(
                "candidato",
                "menu",
                "mensaje"
            ));
        }

        $candidato = RequerimientoContratoCandidato::where('candidato_id', $this->user->id)
            ->join('datos_basicos', 'datos_basicos.user_id', '=', 'requerimiento_contrato_candidato.candidato_id')
            ->orderBy('requerimiento_contrato_candidato.id', 'desc')
        ->first();

        if (is_null($candidato)) {
            $mensaje = 'Actualmente no tienes ningún contrato activo para realizar esta solicitud, por favor contacta a tu ejecutivo de cuenta.';
            return view("cv.adelanto_nomina", compact(
                "candidato",
                "menu",
                "mensaje"
            ));
        }

        $requerimiento = Requerimiento::where('id', $candidato->requerimiento_id)->first();
        if (is_null($requerimiento)) {
            $candidato = null;
            $mensaje = 'Actualmente no tienes ningún contrato activo para realizar esta solicitud, por favor contacta a tu ejecutivo de cuenta.';
            return view("cv.adelanto_nomina", compact(
                "candidato",
                "menu",
                "mensaje"
            ));
        }

        if ($requerimiento->tipo_jornadas_id != 1 && $requerimiento->tipo_jornadas_id != 2) {
            $candidato = null;
            $mensaje = 'Lo sentimos, pero no cumples con los requisitos para acceder a este beneficio.';
            return view("cv.adelanto_nomina", compact(
                "candidato",
                "menu",
                "mensaje"
            ));
        } elseif ($requerimiento->tipo_jornadas_id == 1) {
            //Tiempo completo, pueden solicitar maximo 200000 pesos por periodo (quincena)
            $monto_limite = 200000;
        } else {
            //Medio tiempo, pueden solicitar maximo 100000 pesos por periodo (quincena)
            $monto_limite = 100000;
        }
        $monto_maximo_a_solicitar = $monto_limite;

        $fecha_inicio = date('Y-m').'-'.$dia_inicio;
        $fecha_cierre = date('Y-m').'-'.$dia_cierre;

        $solicitudes = CartappSolicitudUser::where('user_id', $this->user->id)
            ->where('requerimiento_id', $candidato->requerimiento_id)
            ->whereRaw('(solicitud_aprobada is null or solicitud_aprobada = "SI")')
            ->whereBetween("created_at", [$fecha_inicio . ' 00:00:00', $fecha_cierre . ' 23:59:59'])
            ->orderBy('id', 'desc')
        ->get();

        if (count($solicitudes) > 0) {
            $monto_solicitado = $solicitudes->sum('valor');

            if ($monto_solicitado >= $monto_limite || is_null($solicitudes->last()->solicitud_aprobada)) {
                //Realizo solicitudes por el monto maximo o tiene una solicitud pendiente por gestionar
                $candidato = null;
                if (is_null($solicitudes->last()->solicitud_aprobada)) {
                    $mensaje = 'En este momento tienes una solicitud pendiente por gestionar. En breve, te daremos respuesta.';
                } elseif ($periodo_solicitud == 'primer_periodo') {
                    $mensaje = 'Ya has completado el monto máximo de anticipo de nómina de este periodo. Podrás volver a pedir anticipos a partir del <b>día ' . $periodo_evaluar->segundo_periodo_dia_inferior . '</b> de <b>' . $mes_actual . '</b>.';
                } elseif ($periodo_solicitud == 'segundo_periodo') {
                    $fecha_hoy_carbon->addMonth();
                    $mensaje = 'Ya has completado el monto máximo de anticipo de nómina de este periodo. Podrás volver a pedir anticipos a partir del <b>día ' . $periodo_evaluar->primer_periodo_dia_inferior . '</b> de <b>' . $fecha_hoy_carbon->formatLocalized('%B') . '</b>.';
                    
                }

                return view("cv.adelanto_nomina", compact(
                    "candidato",
                    "menu",
                    "mensaje"
                ));
            } else {
                $monto_maximo_a_solicitar = $monto_limite - $monto_solicitado;
            }

            /*$mes_solicitud = $solicitud->created_at->addDays(30)->toDateString();
            if ($mes_solicitud > $carbon_hoy) {
                $tiempo_faltante = Carbon::now()->diffInDays($mes_solicitud) + 1;

                $candidato = null;
                $mensaje = 'Ya has solicitado un adelanto de nómina recientemente. Debes esperar <b>' . $tiempo_faltante . '</b> días para solicitar otro adelanto de nómina';
                return view("cv.adelanto_nomina", compact(
                    "candidato",
                    "menu",
                    "mensaje"
                ));
            }*/
        }

        $bancos_nomina = DB::table("bancos_nomina")->where("active", 1)->get();

        $tipos_cuentas = DB::table("tipos_cuentas_banco")->where("active", 1)->get();

        $fecha_inicio_permitida = Carbon::createFromFormat('Y-m-d', $candidato->fecha_ingreso)->addDays(10)->toDateString();

        $permiso_solicitud = CartappPermisoSolicitud::join('datos_basicos', 'datos_basicos.numero_id', '=', 'cartapp_permiso_solicitud.numero_id')
            ->where('datos_basicos.user_id', $this->user->id)
        ->first();

        if (is_null($permiso_solicitud)) {
            $candidato = null;
            $mensaje = 'Próximamente podrás realizar anticipos de nómina.';
        } elseif ($permiso_solicitud->permiso_solicitud == '0' || $permiso_solicitud->permiso_solicitud == null) {
            $candidato = null;
            $mensaje = 'Próximamente podrás realizar anticipos de nómina.';
        }

        /*if ($fecha_inicio_permitida >= $carbon_hoy) {
            $candidato = null;
            $mensaje = 'Debes tener al menos 10 dias laborando para poder solicitar un adelanto de nómina.';
        } else if ($fecha_fin_contrato > $carbon_hoy) {
            $candidato = null;
            $mensaje = 'Su contrato ha finalizado, por lo que no puede solicitar adelanto de nómina.';
        }*/

        $valores = DB::table("cartapp_montos_solicitar")->where("active", 1)->orderBy("orden")
            ->select("cartapp_montos_solicitar.*")
            ->where(function ($query) use ($monto_maximo_a_solicitar) {
                if($monto_maximo_a_solicitar != null) {
                    $query->where("cartapp_montos_solicitar.valor", '<=', $monto_maximo_a_solicitar);
                }
            })
        ->get();

        return view("cv.adelanto_nomina", compact(
            "candidato",
            "menu",
            "mensaje",
            "bancos_nomina",
            "tipos_cuentas",
            "valores",
            "monto_maximo_a_solicitar",
            "monto_limite"
        ));
    }

    public function codigo_adelanto_nomina()
    {
        $codigo = rand(10000, 99999);
        $envio = false;

        $datos_basicos = DatosBasicos::where("user_id", $this->user->id)->first();
        $datos_basicos->codigo_adelanto_nomina = $codigo;
        $datos_basicos->save();

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Código de Verificación"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = 'El código de validación para solicitar el adelanto de nómina es el siguiente:
                            <br/><br/>
                        <b style="font-size: 18px; font-weight:300; letter-spacing:-.014em; line-height:1.3em; text-align: center;">'.$codigo.'</b>';

        //Arreglo para el botón
        $mailButton = [];

        $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        $email = $datos_basicos->email;
        $asunto = "Código validación para adelanto de nómina";

        if($email != null && $email != ""){
            $envio = Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $asunto) {

                $message->to([$email], 'T3RS')
                ->subject($asunto)
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }

        try {
            $destino = '57'.$datos_basicos->telefono_movil;

            $url = 'https://cloud.go4clients.com:8580/api/campaigns/sms/v1.0/'.env('GO4CLIENTS_TEXTO', '5d72b724d9fc690007777d19');

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

            $message_wp="Hola $datos_basicos->primer_nombre, *".$codigo."* ✍️ es tu código de verificación para la solicitud de adelanto de nómina, por favor ingresa este número en la casilla código. ";
            event(new \App\Events\NotificationWhatsappEvent("message",[
                "phone"=> $destino,
                "body"=> $message_wp
            ]));
        } catch (\Exception $e) {
            logger('Excepción capturada en CartaAppController @codigo_adelanto_nomina: '.  $e->getMessage(). "\n");
        }

        return response()->json(["success" => true]);
    }

    public function verificar_codigo_adelanto_nomina_async(Request $request)
    {
        $candidato = DatosBasicos::join('tipo_identificacion', 'tipo_identificacion.id', '=', 'datos_basicos.tipo_id')
            ->where("user_id", $this->user->id)
            ->select(
                'datos_basicos.*',
                'tipo_identificacion.descripcion as tipo_id_desc'
            )
        ->first();

        if ($candidato->codigo_adelanto_nomina == $request->code) {
            $sitio = Sitio::first();
            $correo_responsable = 'johan.rey@t3rsc.co';
            /*if ($sitio->id_user_gestiona_cartapp != null) {
                $usuario_gestiona_cartapp = DatosBasicos::select('email')->where('user_id', $sitio->id_user_gestiona_cartapp)->first();
                if (!is_null($usuario_gestiona_cartapp)) {
                    $correo_responsable = $usuario_gestiona_cartapp->email;
                }
            }*/

            $solicitud = new CartappSolicitudUser();
            $solicitud->fill([
                'user_id'           => $this->user->id,
                'requerimiento_id'  => $request->requerimiento_id,
                'banco_nomina_id'   => $request->banco_nomina_id,
                'cuenta'            => $request->cuenta,
                'valor'             => $request->valor
            ]);

            if ($request->cuenta == 'terceros') {
                $solicitud->nombre_tercero = $request->nombre_tercero;
                $solicitud->nro_documento_tercero = $request->numero_documento_tercero;
            }

            $banco_nomina = DB::table("bancos_nomina")->where('id', $request->banco_nomina_id)->where("active", 1)->first();
            if ($banco_nomina->tipo_manejo == 'cuenta') {
                $solicitud->numero_cuenta = $request->numero_cuenta;
                $solicitud->tipo_cuenta = $request->tipo_cuenta;
            } else if ($banco_nomina->tipo_manejo == 'telefono') {
                $solicitud->telefono = $request->telefono;
            }

            $monto_maximo_quincena = $request->monto_maximo_quincena;

            return response()->json(["success" => true, "view" => view("cv.includes.adelanto_nomina.condiciones_adelanto_nomina", compact("candidato", "sitio", "solicitud", "correo_responsable", "monto_maximo_quincena"))->render()]);
        }

        return response()->json(["error" => true]);
    }

    public function save_solicitud_adelanto_nomina(Request $request) {
        $solicitud = new CartappSolicitudUser();
        $solicitud->fill([
            'user_id'           => $this->user->id,
            'requerimiento_id'  => $request->requerimiento_id,
            'banco_nomina_id'   => $request->banco_nomina_id,
            'cuenta'            => $request->cuenta,
            'valor'             => $request->valor,
            'firma'             => $request->firma,
            'ip'                => $request->ip()
        ]);

        if ($request->cuenta == 'terceros') {
            $solicitud->nombre_tercero = $request->nombre_tercero;
            $solicitud->nro_documento_tercero = $request->numero_documento_tercero;
        }

        $banco_nomina = DB::table("bancos_nomina")->where('id', $request->banco_nomina_id)->where("active", 1)->first();
        if ($banco_nomina->tipo_manejo == 'cuenta') {
            $solicitud->numero_cuenta = $request->numero_cuenta;
            $solicitud->tipo_cuenta = $request->tipo_cuenta;
        } else if ($banco_nomina->tipo_manejo == 'telefono') {
            $solicitud->telefono = $request->telefono;
            $solicitud->tipo_cuenta = 1; //Para estas cuentas siempre agregar tipo de cuenta Ahorro
        }

        $solicitud->save();

        return response()->json(['success' => true, 'solicitud_id' => $solicitud->id]);
    }

    public function completar_solicitud_adelanto_nomina(Request $request) {
        $solicitud = CartappSolicitudUser::find($request->solicitud_id);

        $imagenes = json_decode($request->nominaImagenes, true);

        $nombres_fotos = '';

        $total_imagenes = count($imagenes);

        $user = $solicitud->user_id;
        $req = $solicitud->requerimiento_id;

        for($i = 0; $i < $total_imagenes; $i++) {
            //Se verifica que la imagen tenga datos
            if ($imagenes[$i]['picture'] != null && $imagenes[$i]['picture'] != '') {
                //Convertir base64 a PNG
                $image_parts = explode(";base64,", $imagenes[$i]['picture']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fotoNombre = "candidato-foto-$i-$user-$req.png";

                if ($i == $total_imagenes-1) {
                    $nombres_fotos = $nombres_fotos . $fotoNombre;
                } else {
                    $nombres_fotos = $nombres_fotos . "$fotoNombre,";
                }

                Storage::disk('public')->put("recursos_adelanto_nomina_fotos/solicitud_".$user.'_'.$req.'/solicitud_'.$solicitud->id."/$fotoNombre", $image_base64);
            }
        }

        $solicitud->fotos = $nombres_fotos;
        $solicitud->save();

        $candidato = DatosBasicos::join('tipo_identificacion', 'tipo_identificacion.id', '=', 'datos_basicos.tipo_id')
            ->where("user_id", $this->user->id)
            ->select(
                'datos_basicos.*',
                'tipo_identificacion.descripcion as tipo_id_desc'
            )
        ->first();

        $logo = '';

        $sitio = Sitio::first();

        if ($sitio->multiple_empresa_contrato) {
            $empresa_logo = Requerimiento::join('empresa_logos', 'empresa_logos.id', '=', 'requerimientos.empresa_contrata')
                ->select('empresa_logos.logo', 'empresa_logos.id')
            ->find($req);

            if ($empresa_logo != null && $empresa_logo->logo != null && $empresa_logo->logo != '') {
                $logo = $empresa_logo->logo;
            }
        }

        $correo_responsable = 'johan.rey@t3rsc.co';
        /*if ($sitio->id_user_gestiona_cartapp != null) {
            $usuario_gestiona_cartapp = DatosBasicos::select('email')->where('user_id', $sitio->id_user_gestiona_cartapp)->first();
            if (!is_null($usuario_gestiona_cartapp)) {
                $correo_responsable = $usuario_gestiona_cartapp->email;
            }
        }*/
        $monto_maximo_quincena = $request->monto_maximo_quincena;

        $view = \View::make("cv.includes.adelanto_nomina.pdf_condiciones_adelanto_nomina", compact(
            'solicitud',
            'logo',
            'candidato',
            'sitio',
            'correo_responsable',
            'monto_maximo_quincena'
        ))
        ->render();

        $pdf  = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        //Guarda contrato
        $output = $pdf->output();
        $nombre_documento = 'solicitud_adelanto_nomina_'.$user.'_'.$req.'_'.$solicitud->id.'.pdf';

        //file_put_contents('contratos_anulados/'.$nombre_documento, $output);
        Storage::disk('public')->put("recursos_adelanto_nomina/solicitud_".$user.'_'.$req."/$nombre_documento", $output);

        $solicitud->hash = hash_file('sha256',"recursos_adelanto_nomina/solicitud_".$user.'_'.$req.'/'.$nombre_documento);
        $solicitud->codigo_verificacion = $candidato->codigo_adelanto_nomina;
        $solicitud->save();

        if ($sitio->id_user_gestiona_cartapp != null) {
            $usuario_gestiona_cartapp = DatosBasicos::where('user_id', $sitio->id_user_gestiona_cartapp)->first();

            $nombre_empresa_contrata = $solicitud->requerimiento->empresa_logo()->nombre_empresa;

            $monto_pesos = number_format($solicitud->valor, 0, ',', '.');

            $donde_enviar = $solicitud->banco_nomina->descripcion . ' ';
            if ($solicitud->banco_nomina->tipo_manejo == 'cuenta') {
                $donde_enviar .= 'Cuenta de ' . $solicitud->tipo_cuenta_banco()->descripcion . ' No. ' . $solicitud->numero_cuenta;
            } else {
                $donde_enviar .= 'No. ' . $solicitud->telefono;
            }

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Notificación solicitud adelanto de nómina – req $req"; //Titulo o tema del correo

            //Cuerpo con html y comillas dobles para las variables
            $mailBody = 'Hola ' . $usuario_gestiona_cartapp->nombres . ' ' . $usuario_gestiona_cartapp->primer_apellido . ', te informamos que el candidato ' . $candidato->nombres . ' ' . $candidato->primer_apellido . ' con ' . $candidato->tipo_id_desc . ' Nro. ' . $candidato->numero_id . ' realizó la solicitud de adelanto de nómina por valor de $ ' . $monto_pesos . '. Para ser consignado en ' . $donde_enviar;

            //Arreglo para el botón
            $mailButton = [];

            $mailUser = $usuario_gestiona_cartapp->user_id; //Id del usuario al que se le envía el correo

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            $email = $usuario_gestiona_cartapp->email;
            $asunto = "AN - $nombre_empresa_contrata";

            if($email != null && $email != ""){
                $envio = Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $asunto, $sitio, $output, $candidato) {

                    $message->to([$email], 'T3RS')
                    ->cc(['jandres8585@gmail.com', $sitio->email_instancia_cartapp])
                    ->subject($asunto)
                    ->attachData($output, $candidato->numero_id . '.pdf')
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            }
        }

        if ($sitio->id_documento_cartapp != null) {
            //Se guarda como archivo post contratacion
            Storage::disk('public')->put("recursos_documentos_verificados/$nombre_documento", $output);

            $documento = new Documentos();
            $documento->fill([
                "numero_id"             => $candidato->numero_id,
                "user_id"               => $user,
                "tipo_documento_id"     => $sitio->id_documento_cartapp,
                "nombre_archivo"        => $nombre_documento,
                "gestiono"              => $user,
                "requerimiento"         => $req,
                "descripcion_archivo"   => 'Solicitud de adelanto de nómina.'
            ]);
            $documento->save();
        }

        return response()->json(['success' => true]);
    }
}
