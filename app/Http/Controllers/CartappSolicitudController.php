<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests;

use App\Models\CartappSolicitudUser;
use App\Models\DatosBasicos;
use App\Models\Documentos;
use App\Models\Requerimiento;
use App\Models\RequerimientoContratoCandidato;
use App\Models\Sitio;

use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Storage;
use triPostmaster;

class CartappSolicitudController extends Controller
{
	protected function sinClientesPruebas(&$ids_clientes_prueba) {
		$sitio = Sitio::first();
		if ($sitio->filtro_cliente == 'enabled' && $sitio->clientes_prueba_id != null && $sitio->clientes_prueba_id != '') {
			$ids_clientes_prueba = explode(",", $sitio->clientes_prueba_id);
			return true;
		}
		return false;
	}

	public function solicitudes_cartapp(Request $request) {
		return view("admin.solicitudes_cartapp");
	}

    public function listado_solicitudes_cartapp(Request $request) {
    	$user_sesion = $this->user;
        $sitio = Sitio::first();

        $fecha_inicio = "";
        $fecha_final  = "";

        if($request->rango_fecha != ""){
            $rango = explode(" | ", $request->rango_fecha);
            $fecha_inicio = $rango[0];
            $fecha_final  = $rango[1];
        }

        $all_solicitudes = CartappSolicitudUser::join('datos_basicos', 'datos_basicos.user_id', '=', 'cartapp_solicitudes_user.user_id')
	        ->select(
	            'cartapp_solicitudes_user.created_at as fecha_solicitud',
	            'cartapp_solicitudes_user.codigo_transferencia',
	            'cartapp_solicitudes_user.documento_soporte',
	            'cartapp_solicitudes_user.fecha_transferencia',
	            'cartapp_solicitudes_user.hora_transferencia',
	        	'cartapp_solicitudes_user.id as solicitud_id',
	        	'cartapp_solicitudes_user.ip as ip_solicitud',
	        	'cartapp_solicitudes_user.requerimiento_id',
	        	'cartapp_solicitudes_user.solicitud_aprobada',
	        	'cartapp_solicitudes_user.user_id',
	        	'cartapp_solicitudes_user.valor as valor_solicitud',
	            'datos_basicos.email',
	            'datos_basicos.estado_reclutamiento',
	            'datos_basicos.nombres',
	            'datos_basicos.numero_id',
	            'datos_basicos.primer_apellido',
	            'datos_basicos.segundo_apellido',
	            'datos_basicos.telefono_movil',
	            'datos_basicos.user_id'
	        )
	        ->orderBy('cartapp_solicitudes_user.created_at', 'DESC')
        ->get();

        $solicitudes = CartappSolicitudUser::join('datos_basicos', 'datos_basicos.user_id', '=', 'cartapp_solicitudes_user.user_id')
        ->join('users', 'users.id', '=', 'datos_basicos.user_id')
        ->leftjoin('cartapp_motivo_rechazo', 'cartapp_motivo_rechazo.id', '=', 'cartapp_solicitudes_user.motivo_rechazo_id')
        ->where(function ($where) use ($request, $fecha_inicio, $fecha_final) {
            if($request->palabra_clave != "") {
                $where->whereRaw("( LOWER(CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido)) like '%" . (strtolower($request->palabra_clave)) . "%' COLLATE utf8_general_ci or LOWER(datos_basicos.email) like '%" . (strtolower($request->palabra_clave)) . "%' or LOWER(datos_basicos.primer_apellido) like '%".(strtolower($request->palabra_clave))."%' COLLATE utf8_general_ci or LOWER(datos_basicos.segundo_apellido) like '%".(strtolower($request->palabra_clave)). "%' COLLATE utf8_general_ci or LOWER(CONCAT(datos_basicos.primer_nombre,' ',datos_basicos.primer_apellido)) like '%".(strtolower($request->palabra_clave)). "%' COLLATE utf8_general_ci or LOWER(CONCAT(datos_basicos.primer_nombre,' ',datos_basicos.segundo_apellido)) like '%".(strtolower($request->palabra_clave)). "%' COLLATE utf8_general_ci or LOWER(CONCAT(datos_basicos.segundo_nombre,' ',datos_basicos.segundo_apellido)) like '%".(strtolower($request->palabra_clave)). "%' COLLATE utf8_general_ci) ");
            }

            if ($request->cedula != "") {
                $where->where("datos_basicos.numero_id", $request->cedula);
            }

            if ($fecha_inicio != "" && $fecha_final != "") {
                $where->whereBetween("cartapp_solicitudes_user.created_at",[$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
            }
        })->select(
        	'cartapp_motivo_rechazo.descripcion as motivo_rechazo_desc',
            'cartapp_solicitudes_user.created_at as fecha_solicitud',
            'cartapp_solicitudes_user.codigo_transferencia',
            'cartapp_solicitudes_user.documento_soporte',
            'cartapp_solicitudes_user.fecha_transferencia',
            'cartapp_solicitudes_user.hora_transferencia',
        	'cartapp_solicitudes_user.id as solicitud_id',
        	'cartapp_solicitudes_user.ip as ip_solicitud',
        	'cartapp_solicitudes_user.requerimiento_id',
        	'cartapp_solicitudes_user.solicitud_aprobada',
        	'cartapp_solicitudes_user.user_id',
        	'cartapp_solicitudes_user.valor as valor_solicitud',
            'datos_basicos.email',
            'datos_basicos.estado_reclutamiento',
            'datos_basicos.nombres',
            'datos_basicos.numero_id',
            'datos_basicos.primer_apellido',
            'datos_basicos.segundo_apellido',
            'datos_basicos.telefono_movil',
            'datos_basicos.user_id',
            'users.video_perfil as video'
        )
        ->orderBy('cartapp_solicitudes_user.created_at', 'DESC')
        ->paginate(15);

        return view("admin.cartapp.solicitudes_cartapp", compact("solicitudes", "sitio", "user_sesion", "all_solicitudes"));
    }

    public function gestion_solicitud_cartapp_view(Request $request) {
    	$solicitud = CartappSolicitudUser::join('datos_basicos', 'datos_basicos.user_id', '=', 'cartapp_solicitudes_user.user_id')
    		->leftjoin('tipo_identificacion', 'tipo_identificacion.id', '=', 'datos_basicos.tipo_id')
    		->select(
    			'cartapp_solicitudes_user.*',
	            'datos_basicos.nombres',
	            'datos_basicos.numero_id',
	            'datos_basicos.primer_apellido',
	            'datos_basicos.segundo_apellido',
	            'tipo_identificacion.descripcion as cod_tipo_identificacion'
    		)
    	->find($request->solicitud_id);

    	$motivos_rechazo = ['' => 'Seleccionar'] + DB::table("cartapp_motivo_rechazo")->where("active", 1)->pluck('descripcion', 'id')->toArray();

    	return view("admin.cartapp._modal_gestion_adelanto_nomina", compact(
            "solicitud",
            "motivos_rechazo"
        ));
    }

	public function gestionar_solicitud_cartapp(Request $request) {
		try {
			$solicitud = CartappSolicitudUser::join('datos_basicos', 'datos_basicos.user_id', '=', 'cartapp_solicitudes_user.user_id')
				->select(
					'cartapp_solicitudes_user.*',
					'datos_basicos.email',
					'datos_basicos.nombres',
					'datos_basicos.numero_id',
					'datos_basicos.primer_apellido',
					'datos_basicos.segundo_apellido'
				)
			->find($request->solicitud_id);
			$sitio = Sitio::first();

			$usuario_gestiona_cartapp = DatosBasicos::where('user_id', $this->user->id)->first();

			$solicitud->solicitud_aprobada = $request->solicitud_aprobada;
			$solicitud->gestiona_solicitud = $this->user->id;

			if ($request->solicitud_aprobada == 'SI') {
				$solicitud->fecha_transferencia = $request->fecha_transferencia;
				$solicitud->hora_transferencia = $request->hora_transferencia;
				$solicitud->codigo_transferencia = $request->codigo_transferencia;

				if ($sitio->id_soporte_pago_cartapp != null) {
					//Se guarda como archivo post contratacion
					if($request->hasFile('documento_soporte')){

						$archivo = $request->file('documento_soporte');
						$extension = strtolower($archivo->getClientOriginalExtension());

						$documento = new Documentos();
						$documento->fill([
							"numero_id"             => $solicitud->numero_id,
							"user_id"               => $solicitud->user_id,
							"tipo_documento_id"     => $sitio->id_soporte_pago_cartapp,
							"nombre_archivo_real"	=> $archivo->getClientOriginalName(),
							"gestiono"              => $this->user->id,
							"requerimiento"         => $solicitud->requerimiento_id,
							"descripcion_archivo"   => 'Soporte de pago de adelanto de nómina.'
						]);
						$documento->save();

						$nombre_documento = "documento_postcontratacion_" . $documento->id . "." . $extension;
						$archivo->move("recursos_documentos_verificados", $nombre_documento);

						$solicitud->documento_soporte = $nombre_documento;

						$documento->nombre_archivo = $nombre_documento;
						$documento->save();
					}
				}
				$solicitud->save();

				$nombre_empresa_contrata = $solicitud->requerimiento->empresa_logo()->nombre_empresa;

				$monto_pesos = number_format($solicitud->valor, 0, ',', '.');

				$donde_enviar = $solicitud->banco_nomina->descripcion . ' ';
				if ($solicitud->banco_nomina->tipo_manejo == 'cuenta') {
					$donde_enviar .= $solicitud->tipo_cuenta_banco()->descripcion . ' No. ' . $solicitud->numero_cuenta;
				} else {
					$donde_enviar .= 'No. ' . $solicitud->telefono;
				}

				$mailTemplate = 2; //Plantilla con botón e imagen de fondo
				$mailConfiguration = 1; //Id de la configuración
				$mailTitle = "Notificación adelanto de nómina"; //Titulo o tema del correo

	            //Cuerpo con html y comillas dobles para las variables
				$mailBody = 'Hola <b>' . $solicitud->nombres . ' ' . $solicitud->primer_apellido . '</b>,<br><br>¡Felicitaciones! Hemos revisado tu solicitud y nos complace informarte que ha sido aprobada. Por lo tanto, procedimos a transferir a tu Cuenta <b>' . $donde_enviar . '</b>, de acuerdo con tus instrucciones, el anticipo de <b>$ ' . $monto_pesos . '</b>.<br><br>Esperamos que los disfrutes y nos encanta que aproveches los beneficios exclusivos que ' . $nombre_empresa_contrata .', en alianza con TRI han desarrollado para ti.<br><br>Te adjunto el soporte de la transacción.<br><br>Código de la transferencia: ' . $solicitud->numero_id . '_' . $request->codigo_transferencia . '<br><br>Si tienes alguna duda acerca de tu anticipo, puedes contactarnos al correo: <b>johan.rey@t3rsc.co</b>';

				//Arreglo para el botón
				$mailButton = [];

				$mailUser = $solicitud->user_id; //Id del usuario al que se le envía el correo

				$triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

				$email = $solicitud->email;
				$asunto = "CONFIRMACIÓN ADELANTO DE NÓMINA_" . $request->codigo_transferencia;

				$nombre_soporte_pago = 'soporte_pago_'.$request->codigo_transferencia.'.'.$extension;

				$archivo_solicitud = 'recursos_adelanto_nomina/solicitud_'.$solicitud->user_id.'_'.$solicitud->requerimiento_id.'/solicitud_adelanto_nomina_'.$solicitud->user_id.'_'.$solicitud->requerimiento_id.'_'.$solicitud->id.'.pdf';

				if($sitio->email_instancia_cartapp != null && $sitio->email_instancia_cartapp != ""){
					$envio = Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $asunto, $sitio, $nombre_soporte_pago, $nombre_documento, $usuario_gestiona_cartapp, $archivo_solicitud) {

						$message->to([$email], 'T3RS')
							->from('johan.rey@t3rsc.co')
							->cc('johan.rey@t3rsc.co')
							->bcc(['jandres8585@gmail.com', $sitio->email_instancia_cartapp, $usuario_gestiona_cartapp->email])
							->subject($asunto)
							->attach(public_path('recursos_documentos_verificados/'.$nombre_documento), [
								'as' => $nombre_soporte_pago
							])
							->attach(public_path($archivo_solicitud), [
								'as' => 'solicitud_adelanto_nomina.pdf'
							])
							->getHeaders()
							->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
					});
				} else {
					$envio = Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $asunto, $nombre_soporte_pago, $nombre_documento, $usuario_gestiona_cartapp, $archivo_solicitud) {

					$message->to([$email], 'T3RS')
						->from('johan.rey@t3rsc.co')
						->cc('johan.rey@t3rsc.co')
						->bcc(['jandres8585@gmail.com', $usuario_gestiona_cartapp->email])
						->subject($asunto)
						->attach(public_path('recursos_documentos_verificados/'.$nombre_documento), [
							'as' => $nombre_soporte_pago
						])
						->attach(public_path($archivo_solicitud), [
							'as' => 'solicitud_adelanto_nomina.pdf'
						])
						->getHeaders()
						->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
					});
				}
		    } else {
				$solicitud->motivo_rechazo_id = $request->motivo_rechazo;
				$solicitud->save();

				$motivo_rechazo = DB::table("cartapp_motivo_rechazo")->find($request->motivo_rechazo);

				$motivo_rechazo_desc = 'un error en los datos que nos has indicado';
				if (!is_null($motivo_rechazo)) {
					$motivo_rechazo_desc = strtolower($motivo_rechazo->descripcion);
				}

				$nombre_empresa_contrata = $solicitud->requerimiento->empresa_logo()->nombre_empresa;

				$mailTemplate = 2; //Plantilla con botón e imagen de fondo
				$mailConfiguration = 1; //Id de la configuración
				$mailTitle = "Notificación adelanto de nómina"; //Titulo o tema del correo

				//Cuerpo con html y comillas dobles para las variables
				$mailBody = 'Hola <b>' . $solicitud->nombres . ' ' . $solicitud->primer_apellido . '</b>,<br><br>Hemos recibido tu solicitud de adelanto de nómina, pero no podemos darle trámite, <b>debido a ' . $motivo_rechazo_desc . '</b>. Te invitamos a que soluciones esta novedad y vuelvas a realizar tu solicitud.<br><br>Esperamos atentos a que vuelvas a realizar la solicitud y así aproveches los beneficios exclusivos que ' . $nombre_empresa_contrata .', en alianza con TRI han desarrollado para ti.<br><br>Si tienes alguna duda acerca de tu anticipo, puedes contactarnos al correo: <b>johan.rey@t3rsc.co</b>';

				//Arreglo para el botón
				$mailButton = [];

				$mailUser = $solicitud->user_id; //Id del usuario al que se le envía el correo

				$triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

				$email = $solicitud->email;
				$asunto = "CONFIRMACIÓN ADELANTO DE NÓMINA_NEGADA";

				if($sitio->email_instancia_cartapp != null && $sitio->email_instancia_cartapp != ""){
					$envio = Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $asunto, $sitio, $usuario_gestiona_cartapp) {

					$message->to([$email], 'T3RS')
						->from('johan.rey@t3rsc.co')
						->cc('johan.rey@t3rsc.co')
						->bcc(['jandres8585@gmail.com', $sitio->email_instancia_cartapp, $usuario_gestiona_cartapp->email])
						->subject($asunto)
						->getHeaders()
						->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
					});
				} else {
					$envio = Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $asunto, $usuario_gestiona_cartapp) {

					$message->to([$email], 'T3RS')
						->from('johan.rey@t3rsc.co')
						->cc('johan.rey@t3rsc.co')
						->bcc(['jandres8585@gmail.com', $usuario_gestiona_cartapp->email])
						->subject($asunto)
						->getHeaders()
						->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
					});
				}
			}

			return response()->json(['success' => true, 'mensaje' => 'Se ha procesado correctamente la información']);
		} catch (\Exception $e) {
			logger('Excepción capturada CartappSolicitudController@gestionar_solicitud_cartapp: '.  $e->getMessage(). "\n");
			return response()->json(['success' => false, 'mensaje' => 'Ha ocurrido un error procesando la información']);
		}
	}

	public function reporte_solicitudes_adelanto_excel(Request $request) {
		$user_sesion = $this->user;
		$sitio = Sitio::first();

		$nombre_sitio = $sitio->nombre;

		$fecha_inicio = "";
		$fecha_final  = "";

		$formato = $request->formato;

		if($request->rango_fecha != ""){
			$rango = explode(" | ", $request->rango_fecha);
			$fecha_inicio = $rango[0];
			$fecha_final  = $rango[1];
		}

		$solicitudes = CartappSolicitudUser::join('datos_basicos', 'datos_basicos.user_id', '=', 'cartapp_solicitudes_user.user_id')
			->leftjoin('cartapp_motivo_rechazo', 'cartapp_motivo_rechazo.id', '=', 'cartapp_solicitudes_user.motivo_rechazo_id')
			->join('requerimientos', 'requerimientos.id', '=', 'cartapp_solicitudes_user.requerimiento_id')
			->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
			->where(function ($where) use ($request, $fecha_inicio, $fecha_final) {
				if($request->palabra_clave != "") {
					$where->whereRaw("( LOWER(CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido)) like '%" . (strtolower($request->palabra_clave)) . "%' COLLATE utf8_general_ci or LOWER(datos_basicos.email) like '%" . (strtolower($request->palabra_clave)) . "%' or LOWER(datos_basicos.primer_apellido) like '%".(strtolower($request->palabra_clave))."%' COLLATE utf8_general_ci or LOWER(datos_basicos.segundo_apellido) like '%".(strtolower($request->palabra_clave)). "%' COLLATE utf8_general_ci or LOWER(CONCAT(datos_basicos.primer_nombre,' ',datos_basicos.primer_apellido)) like '%".(strtolower($request->palabra_clave)). "%' COLLATE utf8_general_ci or LOWER(CONCAT(datos_basicos.primer_nombre,' ',datos_basicos.segundo_apellido)) like '%".(strtolower($request->palabra_clave)). "%' COLLATE utf8_general_ci or LOWER(CONCAT(datos_basicos.segundo_nombre,' ',datos_basicos.segundo_apellido)) like '%".(strtolower($request->palabra_clave)). "%' COLLATE utf8_general_ci) ");
				}

				if ($request->cedula != "") {
	                $where->where("datos_basicos.numero_id", $request->cedula);
	            }

	            if ($fecha_inicio != "" && $fecha_final != "") {
	                $where->whereBetween("cartapp_solicitudes_user.created_at",[$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
	            }
        	})
			->where(function ($query) {
				$ids_clientes_prueba = [];
				if ($this->sinClientesPruebas($ids_clientes_prueba)) {
					$query->whereNotIn("negocio.cliente_id", $ids_clientes_prueba);
				}
			})
			->select(
				'cartapp_motivo_rechazo.descripcion as motivo_rechazo_desc',
				'cartapp_solicitudes_user.banco_nomina_id',
				'cartapp_solicitudes_user.created_at as fecha_solicitud',
				'cartapp_solicitudes_user.codigo_transferencia',
				'cartapp_solicitudes_user.documento_soporte',
				'cartapp_solicitudes_user.fecha_transferencia',
				'cartapp_solicitudes_user.hora_transferencia',
				'cartapp_solicitudes_user.id as solicitud_id',
				'cartapp_solicitudes_user.requerimiento_id',
				'cartapp_solicitudes_user.solicitud_aprobada',
				'cartapp_solicitudes_user.tipo_cuenta',
				'cartapp_solicitudes_user.user_id',
        		'cartapp_solicitudes_user.valor as valor_solicitud',
				'datos_basicos.email',
				'datos_basicos.estado_reclutamiento',
				'datos_basicos.nombres',
				'datos_basicos.numero_id',
				'datos_basicos.primer_apellido',
				'datos_basicos.segundo_apellido',
				'datos_basicos.telefono_movil',
				'datos_basicos.user_id'
			)
			->orderBy('cartapp_solicitudes_user.created_at', 'DESC')
		->get();

		Excel::create('reporte-solicitudes-adelanto-nomina', function ($excel) use ($solicitudes, $formato, $nombre_sitio) {
			$excel->setTitle('Solicitudes adelanto nómina');
			$excel->setCreator($nombre_sitio);
			$excel->setCompany($nombre_sitio);
			$excel->setDescription('Solicitudes adelanto nómina');
			$excel->sheet('Solicitudes adelanto nómina', function ($sheet) use ($solicitudes, $formato) {
				$sheet->setOrientation("landscape");
				$sheet->loadView('admin.cartapp._grilla_adelanto_nomina', [
					'solicitudes'	=> $solicitudes,
					'formato'		=> $formato,
				]);
			});
		})->export($formato);
	}
}
