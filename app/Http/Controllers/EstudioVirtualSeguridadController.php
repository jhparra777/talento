<?php

namespace App\Http\Controllers;

use triPostmaster;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\AspectoRelevanteEstudioVirtualSeguridad;
use App\Models\DatosBasicos;
use App\Models\EstudioVirtualSeguridadSolicitudes;
use App\Models\Experiencias;
use App\Models\ExperienciaVerificada;
use App\Models\ReferenciaEstudio;
use App\Models\ReferenciaPersonalVerificada;
use App\Models\RegistroProceso;
use App\Models\ReqCandidato;
use App\Models\Requerimiento;
use App\Models\Sitio;
use App\Models\TipoAspectoRelevanteEstudioVirtualSeguridad;
use App\Models\TipoEstudioVirtualSeguridad;
use App\Models\TusDatosEvs;
use App\Models\User;
use App\Models\VisitaCandidato;
use App\Models\VisitaAdmin;

class EstudioVirtualSeguridadController extends Controller
{
	public function lista_evs(Request $data)
	{
		$apto = null;
		$candidatos = EstudioVirtualSeguridadSolicitudes::join("datos_basicos","datos_basicos.user_id","=","evs_solicitudes.candidato_id")
			->leftjoin("tipos_evs","tipos_evs.id","=","evs_solicitudes.tipo_evs_id")
			->where(function ($sql) use ($data, &$apto) {
				//Filtro por num requerimiento
				if ($data->num_req != "") {
					$sql->where("evs_solicitudes.requerimiento_id", $data->get("num_req"));
					$apto=[0,1];
				}

				//Filtro por cedula de candidato
				if ($data->cedula != "") {
					$sql->where("datos_basicos.numero_id", $data->get("cedula"));
					$apto=[0,1];
				}
			})
			->where(function ($sql) use ($apto) {
				if (is_null($apto)) {
					$sql->whereNull('apto');
				} else {
					$sql->whereIn('apto', $apto)
						->orWhereNull('apto');
				}
			})
			->select(
				"datos_basicos.*",
				"evs_solicitudes.created_at as fecha_creacion",
				"evs_solicitudes.requerimiento_id",
				"evs_solicitudes.id as id_evs",
				"evs_solicitudes.apto",
				"tipos_evs.descripcion as evs_descripcion"
			)
		->paginate(10);



		return view("admin.estudio_virtual_seguridad.lista_evs", compact("candidatos"));
	}

	public function gestionar_evs(Request $request, $id_evs)
	{
		$candidato = EstudioVirtualSeguridadSolicitudes::join("datos_basicos","datos_basicos.user_id","=","evs_solicitudes.candidato_id")
			->join("tipos_evs","tipos_evs.id","=","evs_solicitudes.tipo_evs_id")
			->leftjoin("tipo_identificacion","tipo_identificacion.id","=","datos_basicos.tipo_id")
			->leftjoin("requerimientos","requerimientos.id","=","evs_solicitudes.requerimiento_id")
			->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
			->leftjoin('clientes', 'negocio.cliente_id', '=', 'clientes.id')
			->select(
				"clientes.id as cliente_id",
				"datos_basicos.*",
				"evs_solicitudes.*",
				"evs_solicitudes.id as id_evs",
				"evs_solicitudes.created_at as fecha_creacion",
				"tipo_identificacion.descripcion as tipo_id_desc",
				"tipos_evs.descripcion as tipo_evs_descripcion"
			)
		->findOrFail($id_evs);

		$tusdatosData = null;
		$visita_dom = null;

		if ($candidato->tipo_evs->analisis_financiero == 'enabled') {
			$procesos_evs[] = 'ANALISIS_FINANCIERO_EVS';
		}
		if ($candidato->tipo_evs->consulta_antecedentes == 'enabled') {
			$procesos_evs[] = 'CONSULTA_ANTECEDENTES_EVS';
			$tusdatosData = TusDatosEvs::where('req_id', $candidato->requerimiento_id)
				->where('user_id', $candidato->candidato_id)
				->orderBy('id', 'DESC')
			->first();
		}
		if ($candidato->tipo_evs->referenciacion_academica == 'enabled') {
			$procesos_evs[] = 'REFERENCIACION_ACADEMICA_EVS';
		}
		if ($candidato->tipo_evs->referenciacion_laboral == 'enabled') {
			$procesos_evs[] = 'REFERENCIACION_LABORAL_EVS';
		}
		if ($candidato->tipo_evs->visita_domiciliaria == 'enabled') {
			$procesos_evs[] = 'VISITA_DOMICILIARIA_EVS';
			$visita_dom = VisitaCandidato::where('candidato_id', $request->candidato_id)
				->where('requerimiento_id',	$request->requerimiento_id)
				->orderBy('id', 'desc')
			->first();
		}

		$procesos = RegistroProceso::where('requerimiento_candidato_id', $candidato->req_cand_id)
			->whereIn('proceso', $procesos_evs)
		->get();

		$user_sesion = $this->user;

		$evs_configuracion = DB::table("evs_configuracion")->first();

		$ids_usuarios_gestionan = explode(',', $evs_configuracion->id_usuario_gestiona);

		return view("admin.estudio_virtual_seguridad.gestionar_estudio_virtual_seguridad", compact(
			"candidato",
			"procesos",
			"user_sesion",
			"ids_usuarios_gestionan",
			"tusdatosData",
			"visita_dom"
			)
		);
	}

	public function enviarEVSView(Request $request)
	{
		$candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
			->leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
			->where("requerimiento_cantidato.id", $request->get("candidato_req"))
			->select(
				"datos_basicos.*",
				"tipo_identificacion.cod_tipo",
				"requerimiento_cantidato.id as req_candidato",
				"requerimiento_cantidato.requerimiento_id",
				"requerimiento_cantidato.candidato_id"
			)
			->with('procesos')
		->first();

		$requerimiento = Requerimiento::find($candidato->requerimiento_id);

		$tipos_evs = TipoEstudioVirtualSeguridad::where("active",1)->get();

		$clases_visita = [""=>"Seleccionar"]+DB::table("clase_visita")->pluck("descripcion","id")->toArray();

		return view("admin.estudio_virtual_seguridad._modal_envio_evs", compact("candidato", "tipos_evs", "requerimiento", "clases_visita"));
	}

	public function confirmarEVS(Request $request)
	{
		$evs_solicitud = new EstudioVirtualSeguridadSolicitudes();
		$evs_solicitud->fill($request->except('_token'));
		$evs_solicitud->user_envio_id = $this->user->id;
		$evs_solicitud->save();

		$candidato->tipo_evs = TipoEstudioVirtualSeguridad::find($request->tipo_evs_id);

		$datos_basicos = DatosBasicos::where('user_id', $request->candidato_id)->first();

		$procesos_evs = [];
		//Se coloca sleep de 1 segundo para que se muestre correctamente en el boton estatus en la pestaña trazabilidad
		if ($candidato->tipo_evs->analisis_financiero == 'enabled') {
			$procesos_evs[] = 'ANALISIS_FINANCIERO_EVS';
			$this->guardarDatosProceso('ANALISIS_FINANCIERO_EVS', $request->req_cand_id, $request->requerimiento_id, $request->candidato_id, $this->user->id, 'Análisis financiero estudio virtual seguridad');
			sleep(1);
		}
		if ($candidato->tipo_evs->consulta_antecedentes == 'enabled') {
			$procesos_evs[] = 'CONSULTA_ANTECEDENTES_EVS';
			$this->guardarDatosProceso('CONSULTA_ANTECEDENTES_EVS', $request->req_cand_id, $request->requerimiento_id, $request->candidato_id, $this->user->id, 'Consulta antecedentes  estudio virtual seguridad');
			sleep(1);
		}
		if ($candidato->tipo_evs->referenciacion_academica == 'enabled') {
			$procesos_evs[] = 'REFERENCIACION_ACADEMICA_EVS';
			$this->guardarDatosProceso('REFERENCIACION_ACADEMICA_EVS', $request->req_cand_id, $request->requerimiento_id, $request->candidato_id, $this->user->id, 'Referenciación académica estudio virtual seguridad');
			sleep(1);
		}
		if ($candidato->tipo_evs->referenciacion_laboral == 'enabled') {
			$procesos_evs[] = 'REFERENCIACION_LABORAL_EVS';
			$this->guardarDatosProceso('REFERENCIACION_LABORAL_EVS', $request->req_cand_id, $request->requerimiento_id, $request->candidato_id, $this->user->id, 'Referenciación laboral estudio virtual seguridad');
			sleep(1);
		}
		if ($candidato->tipo_evs->visita_domiciliaria == 'enabled') {
			$procesos_evs[] = 'VISITA_DOMICILIARIA_EVS';
			$nuevo_proceso = $this->guardarDatosProceso('VISITA_DOMICILIARIA_EVS', $request->req_cand_id, $request->requerimiento_id, $request->candidato_id, $this->user->id, 'Visita domiciliaria estudio virtual seguridad');

			$nueva_visita	= new VisitaCandidato();
			$nueva_visita->candidato_id 	= $request->candidato_id;
			$nueva_visita->requerimiento_id = $request->requerimiento_id;
			$nueva_visita->clase_visita_id	= $request->clase_visita_id;
			$nueva_visita->save();

			$nueva_visita_admin= new VisitaAdmin();
			$nueva_visita_admin->visita_candidato_id	= $nueva_visita->id;
			$nueva_visita_admin->requerimiento_id		= $request->requerimiento_id;
			$nueva_visita_admin->candidato_id			= $request->candidato_id;
			$nueva_visita_admin->clase_visita_id		= $request->clase_visita_id;
			$nueva_visita_admin->save();

			$nuevo_proceso->visita_candidato_id=$nueva_visita->id;
			$nuevo_proceso->save();

			sleep(1);

			try {
				//ENVIAR CORREO
				$asunto = "Notificación de visita domiciliaria";

				$emails = $datos_basicos->email;

				$urls=route("realizar_form_visita_domiciliaria",["visita_id"=>$nueva_visita->id]);

				$mailTemplate = 2; //Plantilla con botón e imagen de fondo
				$mailConfiguration = 1; //Id de la configuración
				$mailTitle = ""; //Titulo o tema del correo

				//Cuerpo con html y comillas dobles para las variables
				$mailBody = "Buen día ".$datos_basicos->nombres." ".$datos_basicos->primer_apellido.", le informamos que se ha programado una visita domiciliaria a realizarse en los próximos días. Debe ingresar haciendo clic en el siguiente botón para gestionar un formulario con algunas preguntas previas a la visita. 
				<br/><br/>";

				//Arreglo para el botón
				$mailButton = ['buttonText' => 'Formulario', 'buttonRoute' => $urls];

				$mailUser = $request->candidato_id; //Id del usuario al que se le envía el correo

				$triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

				Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($emails, $asunto) {

					$message->to($emails)
					->subject($asunto)
					->getHeaders()
					->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
				});
			} catch (\Exception $e) {
				logger('Excepción capturada EstudioVirtualSeguridadController@confirmarEVS envio de correo de nueva visita domiciliaria: '.  $e->getMessage(). "\n");
			}
		}

		$observaciones = 'Tipo estudio virtual seguridad: ' . $candidato->tipo_evs->descripcion;

		$this->guardarDatosProceso('ESTUDIO_VIRTUAL_SEGURIDAD', $request->req_cand_id, $request->requerimiento_id, $request->candidato_id, $this->user->id, $observaciones);

		$sitio = Sitio::first();
		$evs_configuracion = DB::table("evs_configuracion")->first();

		$usuario_gestiona = DatosBasicos::where('user_id', $evs_configuracion->id_usuario_gestiona)->first();

		$nombre_completo = $usuario_gestiona->nombres.' '. $usuario_gestiona->primer_apellido.' '.$usuario_gestiona->segundo_apellido;

		//se le envia correo al usuario que gestiona EVS
		$mailTemplate = 2; //Plantilla con botón e imagen de fondo
		$mailConfiguration = 1; //Id de la configuración
		$mailTitle = $evs_configuracion->titulo_correo; //Titulo o tema del correo
		$asunto = $evs_configuracion->asunto_correo;

		$texto_correo = str_replace('{$candidato_nombres}', "$datos_basicos->nombres $datos_basicos->primer_apellido", $evs_configuracion->texto_correo);
		$texto_correo = str_replace('{$requerimiento_id}', $request->requerimiento_id, $texto_correo);
		$texto_correo = str_replace('{$tipo_evs_id}', $request->tipo_evs_id, $texto_correo);
		$texto_correo = str_replace('{$tipo_evs_descripcion}', $candidato->tipo_evs->descripcion, $texto_correo);

		$procesos_vinetas = '<ul>';
		foreach ($procesos_evs as $key => $value) {
			$procesos_vinetas .= '<li>'.$value.'</li>';
		}
		$procesos_vinetas .= '</ul>';

		//Cuerpo con html y comillas dobles para las variables
		$mailBody = 'Hola '.$nombre_completo.', '.$texto_correo.'<br>'.$procesos_vinetas;

		//Arreglo para el botón
		$mailButton = [];

		$mailUser = $usuario_gestiona->user_id; //Id del usuario al que se le envía el correo

		$triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

		Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($usuario_gestiona, $evs_configuracion, $sitio, $asunto) {
			$message->to($usuario_gestiona->email)
			->subject($asunto)
			->cc($evs_configuracion->email_jorge)
			->bcc($sitio->email_replica)
			->getHeaders()
			->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
		});

		return response()->json(["success" => true]);
	}

	public function pdf_estudio_virtual_seguridad($id_evs)
	{
		$evs_solicitud = EstudioVirtualSeguridadSolicitudes::where('id', $id_evs)
			->select(
				"evs_solicitudes.*",
				"evs_solicitudes.id as id_evs",
				"evs_solicitudes.created_at as fecha_creacion"
			)
			->with('aspectos_relevantes', 'tipo_evs')
		->first();

		$datos_basicos = DatosBasicos::join("evs_solicitudes","evs_solicitudes.candidato_id","=","datos_basicos.user_id")
			->leftjoin("tipo_identificacion","tipo_identificacion.id","=","datos_basicos.tipo_id")
			->select(
				"datos_basicos.*",
				"tipo_identificacion.descripcion as tipo_id_desc"
			)
			->where("datos_basicos.user_id", $evs_solicitud->candidato_id)
		->first();

		$edad = ($datos_basicos->fecha_nacimiento != 0 && $datos_basicos->fecha_nacimiento != "")?\Carbon\Carbon::parse($datos_basicos->fecha_nacimiento)->age:"";

		$user = User::find($datos_basicos->user_id);

		$reqcandidato = ReqCandidato::join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
			->leftjoin("cargos_especificos", "requerimientos.cargo_especifico_id", "=", "cargos_especificos.id")
			->join("users", "users.id", "=", "requerimiento_cantidato.candidato_id")
			->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
			->leftjoin("negocio", "negocio.id", "=", "requerimientos.negocio_id")
			->leftjoin("clientes", "clientes.id", "=", "negocio.cliente_id")
			->leftjoin("empresa_logos","empresa_logos.id","=","requerimientos.empresa_contrata")
			->select(
				"cargos_especificos.descripcion as cargo_descripcion",
				"requerimiento_cantidato.candidato_id",
				"requerimientos.sitio_trabajo as sitio_trabajo",
				"requerimiento_cantidato.candidato_id",
				"users.name as nombre_user",
				"datos_basicos.numero_id",
				"requerimiento_cantidato.created_at",
				"requerimiento_cantidato.requerimiento_id",
				"requerimiento_cantidato.id as requerimiento_cantidato_id",
				"clientes.nombre as cliente_nombre",
				"empresa_logos.logo as logo_empresa"
			)
			->where("requerimiento_cantidato.id", $evs_solicitud->req_cand_id)
			->orderBy("requerimiento_cantidato.requerimiento_id", "asc")
		->first();

		$experienciaMayorDuracion = Experiencias::leftjoin('aspiracion_salarial', 'aspiracion_salarial.id', '=', 'experiencias.salario_devengado')->select(\DB::raw("*,(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) AS dias,(user_id) AS usuario"),"aspiracion_salarial.descripcion AS salario")
			->selectRaw("experiencias.salario_devengado")
			->where("user_id", $evs_solicitud->candidato_id)
			->havingRaw("dias >= (SELECT MAX(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) FROM experiencias as e WHERE e.user_id = experiencias.user_id)")
		->first();

		$referenciaPersonalVerificada = ReferenciaPersonalVerificada::join("referencias_personales", "referencias_personales.id", "=", "ref_personales_verificada.referencia_personal_id")
			->leftjoin("tipo_relaciones", "tipo_relaciones.id", "=", "referencias_personales.tipo_relacion_id")
			->where("ref_personales_verificada.candidato_id", $evs_solicitud->candidato_id)
			->where("ref_personales_verificada.req_id", $evs_solicitud->requerimiento_id)
			->select(
				"referencias_personales.*",
				"ref_personales_verificada.*",
				"tipo_relaciones.descripcion as relacion_referencia"
			)
		->get();

		$referencias_estudios_verificados = ReferenciaEstudio::join("estudios", "estudios.id", "=", "referencias_estudios.estudio_id")
			->leftJoin("niveles_estudios", "niveles_estudios.id", "=", "referencias_estudios.nivel_estudio_id")
			->where("estudios.user_id", $evs_solicitud->candidato_id)
			->where("referencias_estudios.req_id", $evs_solicitud->requerimiento_id)
			->select(
				"referencias_estudios.*",
				"estudios.user_id", 
				"estudios.institucion",
				"estudios.titulo_obtenido",
				"niveles_estudios.descripcion as nivel"
			)
			->orderBy("referencias_estudios.estudio_id", "DESC")
			->groupBy("referencias_estudios.estudio_id")
		->get();

		//EXPERIENCIAS VERIFICADAS
		$experiencias_verificadas = ExperienciaVerificada::join("experiencias", "experiencias.id", "=", "experiencia_verificada.experiencia_id")
			->leftjoin("motivos_retiros", "motivos_retiros.id", "=", "experiencia_verificada.motivo_retiro_id")
			->join("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
			->where("experiencias.user_id", $evs_solicitud->candidato_id)
			->where("experiencia_verificada.req_id", $evs_solicitud->requerimiento_id)
			->select(
				"experiencias.*",
				"motivos_retiros.*",
				"cargos_genericos.*",
				"experiencia_verificada.*",
				"experiencia_verificada.meses_laborados as meses",
				"experiencia_verificada.anios_laborados as años",
				"cargos_genericos.descripcion as name_cargo",
				"motivos_retiros.descripcion as name_motivo",
				"experiencias.fecha_inicio as exp_fecha_inicio",
				"experiencias.fecha_final as exp_fechafin"
			)
		->get();

		//Tusdatos
		$tusdatosData = TusDatosEvs::where('req_id', $evs_solicitud->requerimiento_id)
			->where('user_id', $evs_solicitud->candidato_id)
			->orderBy('id', 'DESC')
		->first();

		$consulta_seguridad_proceso = RegistroProceso::where('candidato_id', $evs_solicitud->candidato_id)
			->where('requerimiento_id', $evs_solicitud->requerimiento_id)
			->where('proceso', 'CONSULTA_ANTECEDENTES_EVS')
		->first();

		$visita_domiciliaria = VisitaCandidato::join("procesos_candidato_req","procesos_candidato_req.visita_candidato_id","=","visitas_candidatos.id")
            ->where("visitas_candidatos.gestionado_candidato",1)
            ->where("visitas_candidatos.gestionado_admin", 1)
            ->where("procesos_candidato_req.requerimiento_candidato_id", $evs_solicitud->req_cand_id)
            ->select(
            	"visitas_candidatos.id as id_visita",
            	"visitas_candidatos.created_at as fecha_creacion"
            )
		->first();

		$sitio = Sitio::first();
		$logo = $sitio->logo;

		return view("admin.estudio_virtual_seguridad.informe_evs", compact(
			'evs_solicitud',
			'datos_basicos',
			'edad',
			'reqcandidato',
			'user',
			'experienciaMayorDuracion',
			'referenciaPersonalVerificada',
			'referencias_estudios_verificados',
			'experiencias_verificadas',
			'tusdatosData',
			'visita_domiciliaria',
			'logo'
		));
	}

	public function view_aspectos_relevantes_evs(Request $request)
	{
		$candidato = EstudioVirtualSeguridadSolicitudes::join("datos_basicos", "datos_basicos.user_id", "=", "evs_solicitudes.candidato_id")
			->leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
			->where("evs_solicitudes.id", $request->get("id_evs"))
			->select(
				"datos_basicos.*",
				"tipo_identificacion.cod_tipo",
				"evs_solicitudes.*",
				"evs_solicitudes.id as id_evs"
			)
			->with('aspectos_relevantes')
		->first();

		$requerimiento = Requerimiento::find($candidato->requerimiento_id);

		$tipos_aspectos_relevantes = ["" => "Seleccione"] + TipoAspectoRelevanteEstudioVirtualSeguridad::where("active",1)->pluck("descripcion","id")->toArray();

		return view("admin.estudio_virtual_seguridad._modal_aspectos_relevantes_evs", compact("candidato", "tipos_aspectos_relevantes", "requerimiento"));
	}

	public function save_aspectos_relevantes_evs(Request $request)
	{
		$solicitud_evs = EstudioVirtualSeguridadSolicitudes::findOrFail($request->id_evs);

		$solicitud_evs->fill(
			$request->only(
				'aspecto_rel_analisis_financiero',
				'aspecto_rel_consulta_antecedentes',
				'aspecto_rel_referencia_academica',
				'aspecto_rel_referencia_laboral',
				'aspecto_rel_visita_domiciliaria'
			)
		);
		$solicitud_evs->save();

		if (count($solicitud_evs->aspectos_relevantes) > 0) {
			foreach ($solicitud_evs->aspectos_relevantes as $asp_rel) {
				if ($request->get('add_otros_aspectos') == 0) {
					$asp_rel->delete();
				} else {
					$aux_resultado = "resultado_$asp_rel->id";
					$aux_tipo = "tipo_aspecto_relevante_id_$asp_rel->id";
					if (!empty($request->$aux_tipo) && !empty($request->$aux_resultado)) {
						$asp_rel->tipo_aspecto_relevante_id = $request->$aux_tipo;
						$asp_rel->resultado = $request->$aux_resultado;
						$asp_rel->save();
					} else {
						$asp_rel->delete();
					}
				}
			}
		}

		if($request->get('add_otros_aspectos') != '' && $request->get('add_otros_aspectos') == 1){
			$tipo_aspecto_relevante_id   = $request->get('tipo_aspecto_relevante_id');
			$resultado  = $request->get('resultado');

			for ($i = 0; $i < count($tipo_aspecto_relevante_id); $i++) {
				$nuevo_asp_rel = new AspectoRelevanteEstudioVirtualSeguridad();
				$nuevo_asp_rel->evs_solicitud_id = $solicitud_evs->id;
				$nuevo_asp_rel->tipo_aspecto_relevante_id = $tipo_aspecto_relevante_id[$i];
				$nuevo_asp_rel->resultado = $resultado[$i];
				$nuevo_asp_rel->save();
			}
		}

		return response()->json(["success" => true]);
	}

	public function save_concepto_evs(Request $request)
	{
		$evs_solicitud = EstudioVirtualSeguridadSolicitudes::find($request->id_evs);

		if (is_null($evs_solicitud)) {
			return response()->json(["success" => false]);
		}
		$evs_solicitud->apto = $request->apto;
		$evs_solicitud->concepto = $request->concepto;
		$evs_solicitud->user_gestion_id = $this->user->id;
		$evs_solicitud->save();

		$proceso = RegistroProceso::where('requerimiento_candidato_id', $evs_solicitud->req_cand_id)
			->where('proceso', 'ESTUDIO_VIRTUAL_SEGURIDAD')
		->first();

		$proceso->apto = 1;
		$proceso->save();

		return response()->json(["success" => true]);
	}

	public function enviar_evs_masivo(Request $request)
	{
		$datos_basicos =[];
		$req_can_id = [];

		foreach($request->req_candidato as $key => $req_candi_id) {
			$candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
				->where("requerimiento_cantidato.id", $req_candi_id)
				->select("datos_basicos.nombres", "datos_basicos.primer_apellido", "datos_basicos.numero_id", "requerimiento_cantidato.id as req_candidato")
			->first();

			$candi = ['nombres' => $candidato->nombres, 'primer_apellido' => $candidato->primer_apellido, 'numero_id' => $candidato->numero_id];

			array_push($datos_basicos, $candi);
			array_push($req_can_id, $candidato->req_candidato);
		}

		$req_can_id_j = json_encode($req_can_id);

		$requerimiento = Requerimiento::join('requerimiento_cantidato', 'requerimiento_cantidato.requerimiento_id', '=', 'requerimientos.id')
			->where('requerimiento_cantidato.id', $req_can_id[0])
			->select('requerimientos.*')
		->first();

		$tipos_evs = TipoEstudioVirtualSeguridad::where("active",1)->get();

		$clases_visita = [""=>"Seleccionar"]+DB::table("clase_visita")->pluck("descripcion","id")->toArray();

		return view("admin.estudio_virtual_seguridad._modal_envio_evs_masivo", compact("datos_basicos", "req_can_id_j", "requerimiento", "tipos_evs", "clases_visita"));
	}

	public function guardar_evs_masivo(Request $request)
	{
		$requerimientos_cand_id = json_decode($request->req_can_id);
		$candidatoNoEnviado = [];

		foreach ($requerimientos_cand_id as $key => $id_req_cand) {
			$existeEstudio = EstudioVirtualSeguridadSolicitudes::where("req_cand_id", $id_req_cand)->first();
			$cand = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
				->where("requerimiento_cantidato.id", $id_req_cand)
				->select(
					"datos_basicos.nombres",
					"datos_basicos.numero_id",
					"datos_basicos.primer_apellido",
					"datos_basicos.email",
					"requerimiento_cantidato.candidato_id",
					"requerimiento_cantidato.requerimiento_id"
				)
			->first();

			if ($existeEstudio != null) {
				array_push($candidatoNoEnviado, "$cand->numero_id $cand->nombres $cand->primer_apellido");
			} else {
				$proceso_contratacion = RegistroProceso::where('requerimiento_candidato_id', $id_req_cand)
					->where('proceso', 'ENVIO_CONTRATACION')
				->first();

				if ($proceso_contratacion != null) {
					array_push($candidatoNoEnviado, "$cand->numero_id $cand->nombres $cand->primer_apellido");
					break;
				}

				//Datos para creación del proceso
				$evs_solicitud = new EstudioVirtualSeguridadSolicitudes();
				$evs_solicitud->req_cand_id			= $id_req_cand;
				$evs_solicitud->candidato_id		= $cand->candidato_id;
				$evs_solicitud->requerimiento_id	= $cand->requerimiento_id;
				$evs_solicitud->tipo_evs_id			= $request->tipo_evs_id;
				$evs_solicitud->user_envio_id		= $this->user->id;
				$evs_solicitud->save();

				$candidato_id		= $cand->candidato_id;
				$requerimiento_id	= $cand->requerimiento_id;

				$tipo_evstipo_evs = TipoEstudioVirtualSeguridad::find($request->tipo_evs_id);

				$procesos_evs = [];
				//Se coloca sleep de 1 segundo para que se muestre correctamente en el boton estatus en la pestaña trazabilidad
				if ($tipo_evstipo_evs->analisis_financiero == 'enabled') {
					$procesos_evs[] = 'ANALISIS_FINANCIERO_EVS';
					$this->guardarDatosProceso('ANALISIS_FINANCIERO_EVS', $id_req_cand, $requerimiento_id, $candidato_id, $this->user->id, 'Análisis financiero estudio virtual seguridad');
					sleep(1);
				}
				if ($tipo_evstipo_evs->consulta_antecedentes == 'enabled') {
					$procesos_evs[] = 'CONSULTA_ANTECEDENTES_EVS';
					$this->guardarDatosProceso('CONSULTA_ANTECEDENTES_EVS', $id_req_cand, $requerimiento_id, $candidato_id, $this->user->id, 'Consulta antecedentes  estudio virtual seguridad');
					sleep(1);
				}
				if ($tipo_evstipo_evs->referenciacion_academica == 'enabled') {
					$procesos_evs[] = 'REFERENCIACION_ACADEMICA_EVS';
					$this->guardarDatosProceso('REFERENCIACION_ACADEMICA_EVS', $id_req_cand, $requerimiento_id, $candidato_id, $this->user->id, 'Referenciación académica estudio virtual seguridad');
					sleep(1);
				}
				if ($tipo_evstipo_evs->referenciacion_laboral == 'enabled') {
					$procesos_evs[] = 'REFERENCIACION_LABORAL_EVS';
					$this->guardarDatosProceso('REFERENCIACION_LABORAL_EVS', $id_req_cand, $requerimiento_id, $candidato_id, $this->user->id, 'Referenciación laboral estudio virtual seguridad');
					sleep(1);
				}
				if ($tipo_evstipo_evs->visita_domiciliaria == 'enabled') {
					$procesos_evs[] = 'VISITA_DOMICILIARIA_EVS';
					$nuevo_proceso = $this->guardarDatosProceso('VISITA_DOMICILIARIA_EVS', $id_req_cand, $requerimiento_id, $candidato_id, $this->user->id, 'Visita domiciliaria estudio virtual seguridad');

					$nueva_visita	= new VisitaCandidato();
					$nueva_visita->candidato_id 	= $candidato_id;
					$nueva_visita->requerimiento_id = $requerimiento_id;
					$nueva_visita->clase_visita_id	= $request->clase_visita_id;
					$nueva_visita->save();

					$nueva_visita_admin= new VisitaAdmin();
					$nueva_visita_admin->visita_candidato_id	= $nueva_visita->id;
					$nueva_visita_admin->requerimiento_id		= $requerimiento_id;
					$nueva_visita_admin->candidato_id			= $candidato_id;
					$nueva_visita_admin->clase_visita_id		= $request->clase_visita_id;
					$nueva_visita_admin->save();

					$nuevo_proceso->visita_candidato_id=$nueva_visita->id;
					$nuevo_proceso->save();

					try {
						//ENVIAR CORREO
						$asunto = "Notificación de visita domiciliaria";

						$emails = $cand->email;

						$urls=route("realizar_form_visita_domiciliaria",["visita_id"=>$nueva_visita->id]);

						$mailTemplate = 2; //Plantilla con botón e imagen de fondo
						$mailConfiguration = 1; //Id de la configuración
						$mailTitle = ""; //Titulo o tema del correo

						//Cuerpo con html y comillas dobles para las variables
						$mailBody = "Buen día ".$cand->nombres." ".$cand->primer_apellido.", le informamos que se ha programado una visita domiciliaria a realizarse en los próximos días. Debe ingresar haciendo clic en el siguiente botón para gestionar un formulario con algunas preguntas previas a la visita. 
						<br/><br/>";

						//Arreglo para el botón
						$mailButton = ['buttonText' => 'Formulario', 'buttonRoute' => $urls];

						$mailUser = $candidato_id; //Id del usuario al que se le envía el correo

						$triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

						Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($emails, $asunto) {

							$message->to($emails)
							->subject($asunto)
							->getHeaders()
							->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
						});
					} catch (\Exception $e) {
						logger('Excepción capturada EstudioVirtualSeguridadController@guardar_evs_masivo envio de correo de nueva visita domiciliaria: '.  $e->getMessage(). "\n");
					}

					sleep(1);
				}

				$observaciones = 'Tipo estudio virtual seguridad: ' . $tipo_evstipo_evs->descripcion;

				$this->guardarDatosProceso('ESTUDIO_VIRTUAL_SEGURIDAD', $id_req_cand, $requerimiento_id, $candidato_id, $this->user->id, $observaciones);

				$sitio = Sitio::first();
				$evs_configuracion = DB::table("evs_configuracion")->first();

				$usuario_gestiona = DatosBasicos::where('user_id', $evs_configuracion->id_usuario_gestiona)->first();
				$datos_basicos = DatosBasicos::where('user_id', $candidato_id)->first();

				$nombre_completo = $usuario_gestiona->nombres.' '. $usuario_gestiona->primer_apellido.' '.$usuario_gestiona->segundo_apellido;

				//se le envia correo al usuario que gestiona EVS
				$mailTemplate = 2; //Plantilla con botón e imagen de fondo
				$mailConfiguration = 1; //Id de la configuración
				$mailTitle = $evs_configuracion->titulo_correo; //Titulo o tema del correo
				$asunto = $evs_configuracion->asunto_correo;

				$texto_correo = str_replace('{$candidato_nombres}', "$datos_basicos->nombres $datos_basicos->primer_apellido", $evs_configuracion->texto_correo);
				$texto_correo = str_replace('{$requerimiento_id}', $requerimiento_id, $texto_correo);
				$texto_correo = str_replace('{$tipo_evs_id}', $request->tipo_evs_id, $texto_correo);
				$texto_correo = str_replace('{$tipo_evs_descripcion}', $tipo_evstipo_evs->descripcion, $texto_correo);

				$procesos_vinetas = '<ul>';
				foreach ($procesos_evs as $key => $value) {
					$procesos_vinetas .= '<li>'.$value.'</li>';
				}
				$procesos_vinetas .= '</ul>';

				//Cuerpo con html y comillas dobles para las variables
				$mailBody = 'Hola '.$nombre_completo.', '.$texto_correo.'<br>'.$procesos_vinetas;

				//Arreglo para el botón
				$mailButton = [];

				$mailUser = $usuario_gestiona->user_id; //Id del usuario al que se le envía el correo

				$triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

				Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($usuario_gestiona, $evs_configuracion, $sitio, $asunto) {
					$message->to($usuario_gestiona->email)
					->subject($asunto)
					->cc($evs_configuracion->email_jorge)
					->bcc($sitio->email_replica)
					->getHeaders()
					->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
				});
			}
		}//fin foreach

		return response()->json(["success" => true, "candidatos_no_enviados" => $candidatoNoEnviado]);
	}

	private function guardarDatosProceso($proceso, $req_cand_id, $requerimiento_id, $candidato_id, $usuario_envio_id, $observaciones = null)
	{
		$nuevo_proceso = new RegistroProceso();

		$nuevo_proceso->fill([
			'proceso'						=> $proceso,
			'requerimiento_candidato_id'	=> $req_cand_id,
			'estado'						=> config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
			'fecha_inicio'					=> date("Y-m-d H:i:s"),
			'usuario_envio'					=> $usuario_envio_id,
			'requerimiento_id'				=> $requerimiento_id,
			'candidato_id'					=> $candidato_id,
			'observaciones'					=> $observaciones
		]);

		$nuevo_proceso->save();

		return $nuevo_proceso;
	}
}
