<?php

namespace App\Http\Controllers;

use Storage;
use triPostmaster;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\ConsentimientosPermisosAdicionales;
use App\Models\ConsentimientosPermisosConfiguracion;
use App\Models\DatosBasicos;
use App\Models\EmpresaLogo;
use App\Models\RegistroProceso;
use App\Models\ReqCandidato;
use App\Models\Requerimiento;
use App\Models\Sitio;

class ConsentimientosPermisosAdicionalesController extends Controller
{
	public function enviar_consentimiento_permisos_adicionales(Request $data) {
		$consentimientos_config = ConsentimientosPermisosConfiguracion::first();

		$candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
		->leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
		->where("requerimiento_cantidato.id", $data->candidato_req)
		->select(
			"datos_basicos.*",
			"requerimiento_cantidato.id as req_candidato",
			"tipo_identificacion.descripcion as cod_tipo_identificacion"
		)
		->first();

		return view("home.consentimiento_permisos_adic.modal.consentimiento_permisos_adicionales_view", compact('candidato', 'consentimientos_config'));
	}

	public function confirmar_envio_consentimiento_permisos_adicionales(Request $data) {
		$consentimientos_config = ConsentimientosPermisosConfiguracion::first();

		$candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
		->where("requerimiento_cantidato.id", $data->candidato_req)
		->select(
			"datos_basicos.*",
			"requerimiento_cantidato.id as req_candidato",
			"requerimiento_cantidato.requerimiento_id"
		)
		->first();

		$nuevo_proceso_consentimientos = new RegistroProceso();

		$nuevo_proceso_consentimientos->fill([
			'proceso'						=> 'CONSENTIMIENTO_PERMISO',
			'requerimiento_candidato_id'	=> $data->candidato_req,
			'estado'						=> config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
			'fecha_inicio'					=> date("Y-m-d H:i:s"),
			'usuario_envio'					=> $this->user->id,
			'requerimiento_id'				=> $candidato->requerimiento_id,
			'candidato_id'					=> $candidato->user_id,
		]);

		$nuevo_proceso_consentimientos->save();

		$sitio = Sitio::first();

		$nombre_completo = $candidato->nombres.' '. $candidato->primer_apellido.' '.$candidato->segundo_apellido;

		//se le envia correo a candidato con el folleto a leer
		//correo con enlace
		$mailTemplate = 2; //Plantilla con botón e imagen de fondo
		$mailConfiguration = 1; //Id de la configuración
		$mailTitle = $consentimientos_config->titulo_correo; //Titulo o tema del correo
		$asunto = $consentimientos_config->asunto_correo;

		//Cuerpo con html y comillas dobles para las variables
		$mailBody = 'Hola '.$nombre_completo.', '.$consentimientos_config->texto_correo;

		//Arreglo para el botón
		$mailButton = ['buttonText' => 'Aceptar y Firmar Documentos', 'buttonRoute' => route('completar_consentimiento_permisos_adic', ['req_id' => $candidato->requerimiento_id])];

		$mailUser = $candidato->user_id; //Id del usuario al que se le envía el correo

		$triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

		Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($candidato, $sitio, $asunto) {
			$message->to($candidato->email)
			->subject($asunto)
			->bcc($sitio->email_replica)
			->getHeaders()
			->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
		});

		return response()->json([
			"success" => true,
			"text_estado" => 'En proceso de selección',
			'candidato_req' => $data->candidato_req,
			"id_proceso" => $nuevo_proceso_consentimientos->id,
			"view" => 'Enviado...'
		]);
	}

	public function completar_consentimiento_permisos_adic($req_id) {
		if(empty($this->user->id)) {
			session(["url_deseada_redireccion_candidato" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login');
		}

		$candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
			->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
			->leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
			->where("procesos_candidato_req.requerimiento_id", $req_id)
			->where("procesos_candidato_req.candidato_id", $this->user->id)
			->whereIn("procesos_candidato_req.estado", [7, 8])
			->whereIn("procesos_candidato_req.proceso", ["CONSENTIMIENTO_PERMISO"])
			->whereRaw("(procesos_candidato_req.apto is null or  procesos_candidato_req.apto = '')")
			->orderBy('requerimiento_cantidato.requerimiento_id','desc')
			->select(
				"datos_basicos.*",
				"procesos_candidato_req.proceso",
				"procesos_candidato_req.id as ref_id",
				"requerimiento_cantidato.*",
				"requerimiento_cantidato.id as req_can_id",
				"tipo_identificacion.descripcion as tipo_id_desc"
			)
		->first();

		if($candidato == null) {
			return redirect()->route('dashboard');
		}

		$registro = RegistroProceso::where('proceso', "CONSENTIMIENTO_PERMISO")
			->where('requerimiento_candidato_id', $candidato->req_can_id)
			->whereNotNull('apto')
		->first();

		if ($registro != null) {
			return redirect()->route('dashboard')->with('no_prueba', 'Ya has firmado el documento.');;
		}

		$logo = '';
		$consentimientos_config = ConsentimientosPermisosConfiguracion::first();

		$sitio = Sitio::first();
		$empresa_logo = Requerimiento::join('empresa_logos', 'empresa_logos.id', '=', 'requerimientos.empresa_contrata')
			->select('empresa_logos.*')
		->find($req_id);

		if (is_null($empresa_logo)) {
			$empresa_logo = EmpresaLogo::first();
		}

		if ($empresa_logo != null && $empresa_logo->logo != null && $empresa_logo->logo != '') {
			$logo = $empresa_logo->logo;
		}

		return view("home.consentimiento_permisos_adic.documento_consentimiento_permisos_adic", compact('candidato', 'logo', 'empresa_logo', 'sitio', 'consentimientos_config'));
	}

	public function guardar_consentimiento_permisos_adic(Request $data) {
		$datos = new ConsentimientosPermisosAdicionales();

		$datos->fill($data->except(["_token"]));

		$datos->save();

		$proceso = RegistroProceso::where('proceso', "CONSENTIMIENTO_PERMISO")
			->where('requerimiento_candidato_id', $data->candidato_req)
			->whereNull('apto')
		->first();

		$proceso->apto = 1;
		$proceso->save();

		return redirect()->route('pdf_consentimiento_permisos_adic', ["id_consentimiento" => encrypt($datos->id)]);
	}

	public function pdf_consentimiento_permisos_adic($id_consentimiento, Request $data) {
		$id_consentimiento = decrypt($id_consentimiento);

		$candidato = ConsentimientosPermisosAdicionales::join('datos_basicos', 'datos_basicos.user_id', '=', 'consentimiento_permisos_adicionales.candidato_id')
			->leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
			->select(
				"consentimiento_permisos_adicionales.*",
				"datos_basicos.*",
				"tipo_identificacion.descripcion as tipo_id_desc"
			)
			->where('consentimiento_permisos_adicionales.id', $id_consentimiento)
		->first();

		$logo = '';
		$consentimientos_config = ConsentimientosPermisosConfiguracion::first();

		$sitio = Sitio::first();
		$empresa_logo = Requerimiento::join('empresa_logos', 'empresa_logos.id', '=', 'requerimientos.empresa_contrata')
			->select('empresa_logos.*')
		->find($candidato->requerimiento_id);

		if (is_null($empresa_logo)) {
			$empresa_logo = EmpresaLogo::first();
		}

		if ($empresa_logo != null && $empresa_logo->logo != null && $empresa_logo->logo != '') {
			$logo = $empresa_logo->logo;
		}

		$view = \View::make('home.consentimiento_permisos_adic.pdf-documento-consentimiento-permisos-adic', compact('candidato', 'logo', 'empresa_logo', 'sitio', 'consentimientos_config'))->render();

		$pdf = app('dompdf.wrapper');
		$pdf->loadHTML($view);

		$nombre_documento = 'consentimiento_permiso_'.$candidato->candidato_id.'_'.$candidato->requerimiento_id.'.pdf';
		Storage::disk('public')->put('recursos_consentimiento_permiso_adicional/'.$nombre_documento, $pdf->output());

		return $pdf->stream("consentimiento_permiso_adicional.pdf");
	}
}