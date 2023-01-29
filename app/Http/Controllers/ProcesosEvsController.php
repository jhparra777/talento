<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\DatosBasicos;
use App\Models\VisitaCandidato;

class ProcesosEvsController extends Controller
{
	public function procesos_evs() {
		return true;
	}

	public function lista_analisis_financiero_evs(Request $request) {
		return back();
	}

	public function lista_consulta_antecedentes_evs(Request $request) {
		$ciudad = explode('~',$request->get("ciudad_trabajo"));

		$candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
			->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
			->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
			->join('cargos_especificos','cargos_especificos.id','=','requerimientos.cargo_especifico_id')
			->whereRaw(" (procesos_candidato_req.apto is null or  procesos_candidato_req.apto = '')  ")
			->whereIn("requerimiento_cantidato.estado_candidato", [config('conf_aplicacion.C_EN_PROCESO_SELECCION'), config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), config('conf_aplicacion.C_EN_EXAMENES_MEDICOS')])
			->whereIn("procesos_candidato_req.estado", [config('conf_aplicacion.C_EN_PROCESO_SELECCION'), config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), config('conf_aplicacion.C_EN_EXAMENES_MEDICOS')])
			->where(function ($sql) use ($request,$ciudad) {
				//Filtro por codigo requerimiento
				if ($request->codigo != "") {
					$sql->where("requerimiento_cantidato.requerimiento_id", $request->codigo);
				}
				//Filtro por cedula de candidato
				if ($request->cedula != "") {
					$sql->where("datos_basicos.numero_id", $request->cedula);
				}
				//Ciudad Trabajo
				if ($request->get("ciudad_trabajo") != "") {
					$sql->where("requerimientos.pais_id", $ciudad[0]);
					$sql->where("requerimientos.departamento_id", $ciudad[1]);
					$sql->where("requerimientos.ciudad_id", $ciudad[2]);
				}
			})
			->whereIn("procesos_candidato_req.proceso", ["REFERENCIACION_LABORAL_EVS"])
			->orderBy('requerimiento_cantidato.requerimiento_id','desc')
			->select(
				"cargos_especificos.descripcion as desc_cargo",
				"procesos_candidato_req.proceso",
				"procesos_candidato_req.id as ref_id",
				"datos_basicos.*",
				"requerimiento_cantidato.*"
			)
		->paginate(10);

		//SELECT DE CIUDAD DE SEDES
		$ciudad_trabajo = ["" => "Seleccionar"] + config('conf_aplicacion.SEDES_MUNICIPIO');

		$user_sesion = $this->user;

		$evs_configuracion = DB::table("evs_configuracion")->first();

		$ids_usuarios_gestionan = explode(',', $evs_configuracion->id_usuario_gestiona);

		return view("admin.reclutamiento.lista_consulta_antecedentes", compact(
			"candidatos",
			"ciudad_trabajo",
			"user_sesion",
			"ids_usuarios_gestionan"
			)
		);
	}

	public function lista_referenciacion_academica_evs(Request $request) {
		$ciudad = explode('~',$request->get("ciudad_trabajo"));

		$candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
			->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
			->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
			->whereRaw(" (procesos_candidato_req.apto is null or  procesos_candidato_req.apto = '')  ")
			->whereIn("requerimiento_cantidato.estado_candidato", [config('conf_aplicacion.C_EN_PROCESO_SELECCION'), config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), config('conf_aplicacion.C_EN_EXAMENES_MEDICOS')])
			->whereIn("procesos_candidato_req.estado", [config('conf_aplicacion.C_EN_PROCESO_SELECCION'), config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), config('conf_aplicacion.C_EN_EXAMENES_MEDICOS')])
			->where(function ($sql) use ($request,$ciudad) {
				//Filtro por codigo requerimiento
				if ($request->codigo != "") {
					$sql->where("requerimiento_cantidato.requerimiento_id", $request->codigo);
				}
				//Filtro por cedula de candidato
				if ($request->cedula != "") {
					$sql->where("datos_basicos.numero_id", $request->cedula);
				}
				//Ciudad Trabajo
				if ($request->get("ciudad_trabajo") != "") {
					$sql->where("requerimientos.pais_id", $ciudad[0]);
					$sql->where("requerimientos.departamento_id", $ciudad[1]);
					$sql->where("requerimientos.ciudad_id", $ciudad[2]);
				}
			})
			->whereIn("procesos_candidato_req.proceso", ["REFERENCIACION_ACADEMICA_EVS"])
			->orderBy('requerimiento_cantidato.requerimiento_id','desc')
			->select(
				"procesos_candidato_req.proceso",
				"procesos_candidato_req.id as ref_id",
				"datos_basicos.*",
				"requerimiento_cantidato.*"
			)
		->paginate(10);

		//SELECT DE CIUDAD DE SEDES
		$ciudad_trabajo = ["" => "Seleccionar"] + config('conf_aplicacion.SEDES_MUNICIPIO');

		return view("admin.reclutamiento.referenciacion_academica", compact("candidatos", "ciudad_trabajo"));
	}

	public function lista_referenciacion_laboral_evs(Request $request) {
		$ciudad = explode('~',$request->get("ciudad_trabajo"));

		$candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
			->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
			->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
			->whereRaw(" (procesos_candidato_req.apto is null or  procesos_candidato_req.apto = '')  ")
			->whereIn("requerimiento_cantidato.estado_candidato", [config('conf_aplicacion.C_EN_PROCESO_SELECCION'), config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), config('conf_aplicacion.C_EN_EXAMENES_MEDICOS')])
			->whereIn("procesos_candidato_req.estado", [config('conf_aplicacion.C_EN_PROCESO_SELECCION'), config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'), config('conf_aplicacion.C_EN_EXAMENES_MEDICOS')])
			->where(function ($sql) use ($request,$ciudad) {
				//Filtro por codigo requerimiento
				if ($request->codigo != "") {
					$sql->where("requerimiento_cantidato.requerimiento_id", $request->codigo);
				}
				//Filtro por cedula de candidato
				if ($request->cedula != "") {
					$sql->where("datos_basicos.numero_id", $request->cedula);
				}
				//Ciudad Trabajo
				if ($request->get("ciudad_trabajo") != "") {
					$sql->where("requerimientos.pais_id", $ciudad[0]);
					$sql->where("requerimientos.departamento_id", $ciudad[1]);
					$sql->where("requerimientos.ciudad_id", $ciudad[2]);
				}
			})
			->whereIn("procesos_candidato_req.proceso", ["REFERENCIACION_LABORAL_EVS"])
			->orderBy('requerimiento_cantidato.requerimiento_id','desc')
			->select(
				"procesos_candidato_req.proceso",
				"procesos_candidato_req.id as ref_id",
				"datos_basicos.*",
				"requerimiento_cantidato.*"
			)
		->paginate(10);

		//SELECT DE CIUDAD DE SEDES
		$ciudad_trabajo = ["" => "Seleccionar"] + config('conf_aplicacion.SEDES_MUNICIPIO');

		return view("admin.reclutamiento.referenciacion", compact("candidatos", "ciudad_trabajo"));
	}

	public function lista_visita_domiciliaria_evs(Request $request) {
		$estados=[1];
		$gestionado_admin=[0];
		$candidatos=VisitaCandidato::join("datos_basicos","datos_basicos.user_id","=","visitas_candidatos.candidato_id")
			->leftjoin("clase_visita","clase_visita.id","=","visitas_candidatos.clase_visita_id")
			->join("procesos_candidato_req", "procesos_candidato_req.visita_candidato_id", "=", "visitas_candidatos.id")
			->whereIn("procesos_candidato_req.proceso", ["VISITA_DOMICILIARIA_EVS"])
			->where(function ($sql) use ($request,&$estados,&$gestionado_admin) {
				//Filtro por codigo requerimiento
				if ($request->codigo != "") {
					$sql->where("visitas_candidatos.requerimiento_id", $request->get("codigo"));
					$estados=[0,1];
					$gestionado_admin=[0,1];
				}

				//Filtro por cedula de candidato
				if ($request->cedula != "") {
					$sql->where("datos_basicos.numero_id", $request->get("cedula"));
					$estados=[0,1];
					$gestionado_admin=[0,1];
				}
			})
			->whereIn("visitas_candidatos.estado",$estados)
			->whereIn("visitas_candidatos.gestionado_admin",$gestionado_admin)
			->select(
				"datos_basicos.*",
				"visitas_candidatos.created_at as fecha_creacion",
				"visitas_candidatos.requerimiento_id",
				"visitas_candidatos.id as id_visita",
				"visitas_candidatos.gestionado_candidato",
				"clase_visita.descripcion as clase"
			)
		->paginate(10);

		$slug = 'admin.lista_visita_domiciliaria_evs';

		$proceso = 'VISITA_DOMICILIARIA_EVS';

		return view("admin.visita_domiciliaria.index", compact("candidatos", "slug", "proceso"));
	}
}
