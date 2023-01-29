<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\CargoEspecifico as ModeloTabla;
use App\Models\CargoGenerico;
use App\Models\CargosExamenes;
use App\Models\Clientes;
use App\Models\DocumentosCargo;
use App\Models\ExamenMedico;
use App\Models\TipoPregunta;
use App\Models\Negocio;
use App\Models\NegocioANS;
use App\Models\Pregunta;
use App\Models\TipoDocumento;
use App\Models\DocumentoAdicional;
use App\Models\CargoDocumentoAdicional;
use App\Models\CargoEspecificoConfigPruebas;
use App\Models\PruebaBrigConfigCargo;
use App\Models\PruebaDigitacionCargo;
use App\Models\PruebaCompetenciaCargo;
use App\Models\ClausulaValorCargo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sitio;
use App\Models\SitioModulo;
use App\Models\Auditoria;
use Illuminate\Support\Facades\Event;


class CargosEspecificosController extends Controller
{
    public function index(Request $data)
    {
        $user_sesion = $this->user;

        $cargosGenericos = ["" => "Seleccionar"] + CargoGenerico::pluck("descripcion", "id")->toArray();

        //Modelo tabla es cargo especifico .-. por alguna razón
        $listas = ModeloTabla::join('clientes', 'clientes.id', '=', 'cargos_especificos.clt_codigo')
        ->whereIn("clientes.id", $this->clientes_user)
        ->where(function ($sql) use ($data) {
            if($data->cliente != ""){
            	$sql->where("cargo_especifico.clt_codigo", $data->cliente);
            }
        })
        ->select(
            'cargos_especificos.*',
            'clientes.nombre as cliente'
        )
        ->orderBy('cargos_especificos.id', 'DESC');

        if($data->cliente_id != "") {
            $listas = $listas->get();
        } else {
            $listas = $listas->take(50)->get();
        }

        $sitioModulo = SitioModulo::first();

        $view = view("admin.cargos_especificos.include._lista_cargos", compact("listas", "sitioModulo"))->render();

        $clientes = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "clientes.id", "=", "users_x_clientes.cliente_id")
        ->where("users_x_clientes.user_id", $user_sesion->id)
        ->orderBy('clientes.nombre', 'asc')
        ->pluck("clientes.nombre", "clientes.id")
        ->toArray();

        //Para configuración BRYG
        $cargoModulo = true;

        return view("admin.cargos_especificos.index", compact("listas", "cargosGenericos", 'clientes', 'cargoModulo', 'sitioModulo', 'view'));
    }

    public function editar(Request $request)
    {
        $user_sesion = $this->user;
        $negocio_ans = "";

        $tipos_documento = "";
        $tipos_examenes = "";

        $sitio = Sitio::first();
        $sitioModulo = SitioModulo::first();

        $registro = ModeloTabla::with("tipos_documentos")->with("examenes")->find($request->id);

        if($sitio->asistente_contratacion == 1) {
            $tipos_documento = TipoDocumento::where('active', 1)->get();
            $tipos_examenes = ExamenMedico::where('status', 1)->get();
            // $adicionales = DocumentoAdicional::where('active', 1)->get();

            $adicionales_cliente = DocumentoAdicional::join('cargos_documentos_adicionales', 'cargos_documentos_adicionales.adicional_id', '=', 'documentos_adicionales_contrato.id')
            ->join('cargos_especificos', 'cargos_especificos.id', '=', 'cargos_documentos_adicionales.cargo_id')
            ->join('clientes', 'clientes.id', '=', 'cargos_especificos.clt_codigo')
            ->where('documentos_adicionales_contrato.active', 1)
            ->where('clientes.id', $registro->clt_codigo)
            ->select('documentos_adicionales_contrato.*')
            ->groupBy('documentos_adicionales_contrato.id')
            ->get();

            $adicionales = DocumentoAdicional::where('active', 1)->whereNotIn('id', $adicionales_cliente->modelKeys())->get();
        }
        
        $clientes = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "clientes.id", "=", "users_x_clientes.cliente_id")
        ->where("users_x_clientes.user_id", $user_sesion->id)
        ->orderBy('clientes.nombre', 'asc')
        ->pluck("clientes.nombre", "clientes.id")
        ->toArray();
         
        $preguntas_cargo = Pregunta::where('cargo_especifico_id', $request->id)
        ->join('tipo_pregunta', 'tipo_pregunta.id', '=', 'preguntas.tipo_id')
        ->select('preguntas.id as req_preg_id', 'preguntas.*', 'tipo_pregunta.descripcion as descr_tipo_p')
        ->get();

        $archivo = ($registro->archivo_perfil != "" && file_exists("recursos_Perfiles/".$registro->archivo_perfil))?$registro->archivo_perfil : '';

		$cargosGenericos = ["" => "Seleccionar"] + CargoGenerico::pluck("descripcion", "id")
		->toArray();
        
        $cargo_id = $request->id;
       
        $negocio_ans = NegocioANS::where("cargo_especifico_id", $cargo_id)->orderBy("vacantes_inicio", "asc")->get();

        //Si tiene configuración prueba digitación
        $digitacionCargo = PruebaDigitacionCargo::where('cargo_id', $cargo_id)->first();

        $tipos_nivel_cargo = DB::table("tipos_nivel_cargo")->where("active", 1)->orderBy("descripcion")->get();

        $tipos_cargos_perfil = DB::table("tipos_cargos_perfil")->where("active", 1)->orderBy("descripcion")->get();

        $tipo_contrato = DB::table("tipos_contratos")->where("active", 1)->orderBy("descripcion")->get();

        $tipo_liquidacion = DB::table("tipos_liquidaciones")->where("estado", 1)->orderBy("descripcion")->get();

        $tipo_jornada = DB::table("tipos_jornadas")->where("active", 1)->orderBy("descripcion")->get();

        $centros_trabajo = DB::table("centros_trabajo")->orderBy("nombre_ctra")->get();

        $tipo_nomina = DB::table("tipos_nominas")->orderBy("descripcion")->get();

        $conceptos_pago = DB::table("conceptos_pagos")->orderBy("descripcion")->get();

        $tipo_salario = DB::table("tipos_salarios")->orderBy("descripcion")->get();

        $niveles_estudio = DB::table("niveles_estudios")->orderBy('descripcion', 'asc')->get();

        $estados_civiles = DB::table("estados_civiles")->where("active", 1)->orderBy('descripcion', 'asc')->get();

        $tiempo_experiencia = DB::table("tipos_experiencias")->where("active", 1)->get();

        $generos = DB::table("generos")->where("active", 1)->orderBy('descripcion', 'asc')->get();

        return view("admin.cargos_especificos.modal.editar", compact(
			"cargo_id",
			"user_sesion",
			"preguntas_cargo",
			"registro",
			"cargosGenericos",
			"tipos_documento",
			"tipos_examenes",
            "adicionales_cliente",
            "adicionales",
			"clientes",
			"negocio_ans",
            "sitio",
            "sitioModulo",
            'archivo',
            'digitacionCargo',
            'tipos_nivel_cargo',
            'tipos_cargos_perfil',
            'tipo_contrato',
            'tipo_liquidacion',
            'tipo_jornada',
            'centros_trabajo',
            'tipo_nomina',
            'conceptos_pago',
            'tipo_salario',
            'niveles_estudio',
            'estados_civiles',
            'tiempo_experiencia',
            'generos'
		));
    }

    public function actualizar(Request $datos)
    {
        $descripcion = mb_strtolower($datos->descripcion, 'UTF-8');
        $registro = ModeloTabla::find($datos->id);


        //Se verifica si se edito la descripcion, para comprobar posteriormente si existe un cargo con ese nombre
        if (mb_strtolower($registro->descripcion, 'UTF-8') != $descripcion) {
            $cargos_cliente = ModeloTabla::where('clt_codigo', $datos->clt_codigo)
                ->whereNotIn('id', [$datos->id])
            ->get();

            //Para Verificar si existe un cargo para ese cliente con la misma descripcion ingresada
            foreach ($cargos_cliente as $cargo) {
                if (mb_strtolower($cargo->descripcion, 'UTF-8') == $descripcion) {
                    $msg_error = "Para este cliente ya existe un cargo con la descripción <b>$datos->descripcion</b>.";

                    if($datos->ajax()){
                        return response()->json(["success" => false, 'mensaje_success' => $msg_error, 'nuevo_cargo' => $cargo]);
                    }

                    return redirect()->back()
                            ->withInput($datos->input())
                            ->with(['msg_error' => $msg_error]);
                }
            }
        }

        $this->validate($datos, [
            'descripcion' => 'required',
            'cargo_generico_id' => 'required',
        ]);
       
        //$registro = ModeloTabla::find($datos->get("id"));
        $clon_old = ["datos_cargo" => collect($registro)->except(["created_at","updated_at"])->toArray(),"examenes" => $registro->examenes->pluck("id")->toArray(),"documentos" => $registro->tipos_documentos->pluck("id")->toArray(),"clausulas"=>$registro->clausulas->where("active_pivot","1")->pluck("id")->toArray()];
        //$clon_new = ["datos_cargo" => $registro->except(["created_at","updated_at"])->toArray(),"examenes" => $registro->examenes->pluck("id")->toArray(),"documentos" => $registro->tipos_documentos->pluck("id")->toArray()];

        $registro->fill($datos->all() + [
            "active" => $datos->active ? 1 : 0
        ]);

		if(route("home") == "https://demo.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co") {
        	//Guarda nivel cargo
          	$registro->nivel_cargo = $datos->nivel_cargo;
        }

        if($datos->has("asume")) {    
            $registro->asume_examenes = 1;
        }else{
            $registro->asume_examenes = 0;
        }

        $registro->save();

        if ($datos->hasFile("perfil")) {
            $archivo   = $datos->file('perfil');
            $extencion = $archivo->getClientOriginalExtension();
            $fileName  = "perfil_" . $registro->id . ".$extencion";
            $cargo_especifico = ModeloTabla::find($registro->id);
            
            //ELIMINAR PDF
            if($cargo_especifico->archivo_perfil != "" && file_exists("recursos_Perfiles/" . $cargo_especifico->archivo_perfil)) {
              unlink("recursos_Perfiles/" . $cargo_especifico->archivo_perfil);
            }

            $cargo_especifico->archivo_perfil = $fileName;

            $cargo_especifico->save();
            $datos->file('perfil')->move("recursos_Perfiles", $fileName);
        }

        //cambiar a tiempos
        if ($datos->get("regla_de") != "" && is_array($datos->get("regla_de")) && $datos->get("regla_a") != "" && is_array($datos->get("regla_a"))) {
            $regla                           = $datos->get("regla_de");
            $reglad                          = $datos->get("regla_a");
            $cantidad_dias                   = $datos->get("cantidad_dias");
            $num_cand_presentar_vac          = $datos->get("num_cand_presentar_vac");
            $dias_presentar_candidatos_antes = $datos->get("dias_presentar_candidatos_antes");

            $negocio = Negocio::where('cliente_id', $registro->clt_codigo)->first();

            for($i = 0; $i < count($regla); $i++) {
            	$reglas = $regla[$i].'A'.$reglad[$i];
              
                if($regla[$i] != "") {
                	if(count($negocio) > 0) {
                 		$consulta_ans = NegocioANS::where("negocio_id", $negocio->id)->where("cargo_especifico_id", $registro->id)->get();
                  	}else{
						$consulta_ans = "";
					}
					
					if (count($consulta_ans) == 0) {
                     	$negocio_ans = new NegocioANS();
						
						//Unir ambas reglas
                        $negocio_ans->fill([
                            "vacantes_inicio" => $regla[$i], 
                            "regla" => $reglas,
                            "num_cand_presentar_vac" => $num_cand_presentar_vac[$i],
                            "dias_presentar_candidatos_antes" => $dias_presentar_candidatos_antes[$i],
                            "cantidad_dias" => $cantidad_dias[$i], 
                            "negocio_id" => $negocio->id
                        ]);

                        $negocio_ans->cargo_especifico_id = $registro->id;

                        $negocio_ans->save();
                    }else{
						$consulta_ans->regla=$reglas;
						$consulta_ans->num_cand_presentar_vac=$num_cand_presentar_vac[$i];
						$consulta_ans->dias_presentar_candidatos_antes=$dias_presentar_candidatos_antes[$i];
						$consulta_ans->cantidad_dias = $cantidad_dias[$i];
						$consulta_ans->negocio_id = $negocio->id;
						$consulta_ans->save();
                    }
                }
            }
        }
          
        if($datos->has("examen") && is_array($datos->get("examen"))){
            $proces_exam = $registro->examenes()->sync($datos->get("examen"));
            //$clon_new["examenes"]=$datos->get("examen");  
        }

        if($datos->has("documento") && is_array($datos->get("documento"))){
            $ids_documentos = $datos->get("documento");
            $ids_confi_benefi = TipoDocumento::join('cargo_documento', 'cargo_documento.tipo_documento_id', '=', 'tipos_documentos.id')
                ->where('cargo_documento.cargo_especifico_id', $registro->id)
                ->where('tipos_documentos.active', 1)
                ->whereIn('tipos_documentos.categoria', [3,5])
                ->select('tipos_documentos.id')
            ->get();

            foreach ($ids_confi_benefi as $id_tip) {
                //Se agregan los Ids de los tipos de documentos que son categoria 3,5 que estaban asociados con el cargo especifico, para que cuando se sincronicen se queden en la tabla cargo_documento y no se eliminen
                $ids_documentos[] = $id_tip->id;
            }

            $proces_doc = $registro->tipos_documentos()->sync($ids_documentos);
            //$clon_new["documentos"] = $datos->get("documento");
        }

        //Comienzo guardar adicionales
            if($datos->has("clausulas") && is_array($datos->get("clausulas"))) {
                $clausulas = $datos->clausulas;

                $adicionales = DocumentoAdicional::whereIn('id', $clausulas)->get();
                $adicionalesInactivos = CargoDocumentoAdicional::whereNotIn('adicional_id', $clausulas)->where('cargo_id', $registro->id)->get();

                foreach($adicionalesInactivos as $adicional) {
                    $adicional->active = 0;
                    $adicional->save();

                    ClausulaValorCargo::where('cargo_id', $registro->id)->where('adicional_id', $adicional->adicional_id)->delete();
                }

                //
                foreach($adicionales as $adicional) {
                    $asociado = CargoDocumentoAdicional::where('adicional_id', $adicional->id)->where('cargo_id', $registro->id)->first();

                    if (empty($asociado)) {
                        $asociado = new CargoDocumentoAdicional();

                        $asociado->cargo_id = $registro->id;
                        $asociado->adicional_id = $adicional->id;
                    }else {
                        $asociado->active = 1;
                    }

                    $asociado->save();

                    //Si hay un valor adicional configurado se crea la asociación en la tabla
                    if($datos->has("valor_adicional") && is_array($datos->get("valor_adicional"))) {
                        if (!empty($datos->get("valor_adicional")[$adicional->id])) {
                            $documento_adicional_valor = ClausulaValorCargo::where('cargo_id', $registro->id)->where('adicional_id', $adicional->id)->first();

                            if (empty($documento_adicional_valor)) {
                                $documento_adicional_valor = new ClausulaValorCargo();

                                $documento_adicional_valor->fill([
                                    'cargo_id' => $registro->id,
                                    'adicional_id' => $adicional->id,
                                    'valor' => $datos->get("valor_adicional")[$adicional->id],
                                ]);
                            }else {
                                $documento_adicional_valor->valor = $datos->get("valor_adicional")[$adicional->id];
                            }

                            $documento_adicional_valor->save();
                        }
                    }
                }
            }
            else{
                //$adicionales = DocumentoAdicional::whereIn('id', $clausulas)->get();
                $adicionalesInactivos = CargoDocumentoAdicional::where('cargo_id', $registro->id)->get();


                foreach($adicionalesInactivos as $adicional) {
                    $adicional->active = 0;
                    $adicional->save();

                    ClausulaValorCargo::where('cargo_id', $registro->id)->where('adicional_id', $adicional->adicional_id)->delete();
                }
            }
        //Fin guardar adicionales

        $registro_new = ModeloTabla::find($registro->id);
        $clon_new=[];
        $clon_new["datos_cargo"] = collect($registro_new)->except(["created_at","updated_at"])->toArray();
        $clon_new["examenes"]=$registro_new->examenes->pluck("id")->toArray();
        $clon_new["documentos"]=$registro_new->tipos_documentos->pluck("id")->toArray();
        $clon_new["clausulas"]=$registro_new->clausulas->where("active_pivot","1")->pluck("id")->toArray();
        
        $clon_old = json_encode($clon_old);
        $clon_new = json_encode($clon_new);

        if($clon_old != $clon_new) {
            $auditoria = new Auditoria();
            $auditoria->observaciones = "Editar cargo";
            $auditoria->valor_antes   = $clon_old;
            $auditoria->valor_despues = $clon_new;
            $auditoria->user_id       = $this->user->id;
            $auditoria->tabla         = "cargos_especificos";
            $auditoria->tabla_id      = $registro->id;
            $auditoria->tipo          = "ACTUALIZAR";

            event(new \App\Events\AuditoriaEvent($auditoria));
        }

        if($datos->ajax()){
            return response()->json(["success" => true, 'mensaje_success' => "Se ha actualizado el cargo correctamente."]);
        }

        return redirect()->route("admin.cargos_especificos.index")->with("mensaje_success", "Registro actualizado con éxito.");
    }

    public function nuevo(Request $data)
    {
        $user_sesion = $this->user;
        $tipos_documento = "";
        $tipos_examenes = "";
        $tipo_pregunta = ["" => "Seleccionar"] + TipoPregunta::pluck("descripcion", "id")->toArray();

        $clientes = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "clientes.id", "=", "users_x_clientes.cliente_id")
		->where("users_x_clientes.user_id", $user_sesion->id)
		->orderBy('clientes.nombre', 'asc')
		->pluck("clientes.nombre", "clientes.id")
		->toArray();

        $cargosGenericos = \Cache::remember('cargosgenericos','300', function(){
            return ["" => "Seleccionar"] + CargoGenerico::pluck("descripcion", "id")->toArray();
        });

        //$cargosGenericos = ["" => "Seleccionar"] + CargoGenerico::pluck("descripcion", "id")->toArray();

        $sitio = Sitio::first();
        $sitioModulo = SitioModulo::first();

        $tipos_documento = null;
        $tipos_examenes = null;

        if($sitio->asistente_contratacion == 1) {
            $tipos_documento = TipoDocumento::where('active', 1)->get();
            $tipos_examenes = ExamenMedico::where('status', 1)->get();
            $adicionales = DocumentoAdicional::where('active', 1)->get();
        }

        //Para configuración BRYG
        $cargoModulo = true;

        $registro = new ModeloTabla();

        $tipos_nivel_cargo = DB::table("tipos_nivel_cargo")->where("active", 1)->orderBy("descripcion")->get();

        $tipos_cargos_perfil = DB::table("tipos_cargos_perfil")->where("active", 1)->orderBy("descripcion")->get();

        $tipo_contrato = DB::table("tipos_contratos")->where("active", 1)->orderBy("descripcion")->get();

        $tipo_liquidacion = DB::table("tipos_liquidaciones")->where("estado", 1)->orderBy("descripcion")->get();

        $tipo_jornada = DB::table("tipos_jornadas")->where("active", 1)->orderBy("descripcion")->get();

        $centros_trabajo = DB::table("centros_trabajo")->orderBy("nombre_ctra")->get();

        $tipo_nomina = DB::table("tipos_nominas")->orderBy("descripcion")->get();

        $conceptos_pago = DB::table("conceptos_pagos")->orderBy("descripcion")->get();

        $tipo_salario = DB::table("tipos_salarios")->orderBy("descripcion")->get();

        $niveles_estudio = DB::table("niveles_estudios")->orderBy('descripcion', 'asc')->get();

        $estados_civiles = DB::table("estados_civiles")->where("active", 1)->orderBy('descripcion', 'asc')->get();

        $tiempo_experiencia = DB::table("tipos_experiencias")->where("active", 1)->get();

        $generos = DB::table("generos")->where("active", 1)->orderBy('descripcion', 'asc')->get();

        return view("admin.cargos_especificos.nuevo", compact(
			"tipo_pregunta",
			"preguntas_reqs",
			"user_sesion",
			"cargosGenericos",
			'clientes',
			'tipos_documento',
			'tipos_examenes',
            'adicionales',
            'sitioModulo',
            'sitio',
            'sitioModulo',
            'cargoModulo',
            'tipos_nivel_cargo',
            'tipos_cargos_perfil',
            'tipo_contrato',
            'tipo_liquidacion',
            'tipo_jornada',
            'centros_trabajo',
            'tipo_nomina',
            'conceptos_pago',
            'tipo_salario',
            'niveles_estudio',
            'estados_civiles',
            'tiempo_experiencia',
            'generos',
            'registro'
		));
    }

    public function crear_cargo_cliente(Request $data)
    {
        $user_sesion = $this->user;
        $tipos_documento = "";
        $tipos_examenes = "";
        $tipo_pregunta = ["" => "Seleccionar"] + TipoPregunta::pluck("descripcion", "id")->toArray();

        $clientes = Clientes::where("id", $data->cliente_id)
        ->pluck("clientes.nombre", "clientes.id")
        ->toArray();

        $cargosGenericos = ["" => "Seleccionar"] + CargoGenerico::pluck("descripcion", "id")->toArray();

        $sitio = Sitio::first();

        $tipos_documento = null;
        $tipos_examenes = null;

        if($sitio->asistente_contratacion == 1){
            $tipos_documento = TipoDocumento::where('active', 1)->get();
            $tipos_examenes = ExamenMedico::where('status', 1)->get();
            // $adicionales = DocumentoAdicional::where('creada', 0)->get();

            $adicionales_cliente = DocumentoAdicional::join('cargos_documentos_adicionales', 'cargos_documentos_adicionales.adicional_id', '=', 'documentos_adicionales_contrato.id')
            ->join('cargos_especificos', 'cargos_especificos.id', '=', 'cargos_documentos_adicionales.cargo_id')
            ->join('clientes', 'clientes.id', '=', 'cargos_especificos.clt_codigo')
            ->where('documentos_adicionales_contrato.active', 1)
            ->where('clientes.id', $data->cliente_id)
            ->select('documentos_adicionales_contrato.*')
            ->groupBy('documentos_adicionales_contrato.id')
            ->get();

            $adicionales = DocumentoAdicional::where('active', 1)->whereNotIn('id', $adicionales_cliente->modelKeys())->get();
        }

        $tipos_nivel_cargo = DB::table("tipos_nivel_cargo")->where("active", 1)->orderBy("descripcion")->get();

        $tipos_cargos_perfil = DB::table("tipos_cargos_perfil")->where("active", 1)->orderBy("descripcion")->get();

        $tipo_contrato = DB::table("tipos_contratos")->where("active", 1)->orderBy("descripcion")->get();

        $tipo_liquidacion = DB::table("tipos_liquidaciones")->where("estado", 1)->orderBy("descripcion")->get();

        $tipo_jornada = DB::table("tipos_jornadas")->where("active", 1)->orderBy("descripcion")->get();

        $centros_trabajo = DB::table("centros_trabajo")->orderBy("nombre_ctra")->get();

        $tipo_nomina = DB::table("tipos_nominas")->orderBy("descripcion")->get();

        $conceptos_pago = DB::table("conceptos_pagos")->orderBy("descripcion")->get();

        $tipo_salario = DB::table("tipos_salarios")->orderBy("descripcion")->get();

        $niveles_estudio = DB::table("niveles_estudios")->orderBy('descripcion', 'asc')->get();

        $estados_civiles = DB::table("estados_civiles")->where("active", 1)->orderBy('descripcion', 'asc')->get();

        $tiempo_experiencia = DB::table("tipos_experiencias")->where("active", 1)->orderBy('descripcion', 'asc')->get();

        $generos = DB::table("generos")->where("active", 1)->orderBy('descripcion', 'asc')->get();

        return view("admin.cargos_especificos.modal.nuevo_cargo_modal", compact(
            "tipo_pregunta",
            "preguntas_reqs",
            "user_sesion",
            "cargosGenericos",
            'clientes',
            'tipos_documento',
            'tipos_examenes',
            "adicionales_cliente",
            "adicionales",
            'sitio',
            'tipos_nivel_cargo',
            'tipos_cargos_perfil',
            'tipo_contrato',
            'tipo_liquidacion',
            'tipo_jornada',
            'centros_trabajo',
            'tipo_nomina',
            'conceptos_pago',
            'tipo_salario',
            'niveles_estudio',
            'estados_civiles',
            'tiempo_experiencia',
            'generos'
        ));
    }

	public function guardar(Request $data, Requests\CargosEspecificosNuevoRequest $valida)
	{
        $existe = ModeloTabla::where('clt_codigo', $data->clt_codigo)->whereRaw("(LOWER(descripcion) = '$descripcion')")->first();

        $descripcion = mb_strtolower($data->descripcion, 'UTF-8');
        $cargos_cliente = ModeloTabla::where('clt_codigo', $data->clt_codigo)->get();

        //Para Verificar si existe un cargo para ese cliente con la misma descripcion ingresada
        foreach ($cargos_cliente as $cargo) {
            if (mb_strtolower($cargo->descripcion, 'UTF-8') == $descripcion) {
                $msg_error = "Para este cliente ya existe un cargo con la descripción <b>$data->descripcion</b>.";

                if($data->ajax()){
                    return response()->json(["success" => false, 'mensaje_success' => $msg_error, 'nuevo_cargo' => $cargo]);
                }

                return redirect()->back()
                        ->withInput($data->input())
                        ->with(['msg_error' => $msg_error]);
            }
        }

        //ModeloTabla es CargoEspecifico
        $registro = new ModeloTabla();
        $registro->fill($data->all() + [
        	"plazo_req" => $data->plazo_req,
            "active"    => 1
        ]);

        $registro->creado_por = $this->user->id;

        if($data->has("asume")) {
            $registro->asume_examenes = 1;
        }

        if($data->has("excel_basico")) {
            $registro->excel_basico = 1;
            $registro->tiempo_excel_basico      = $data->tiempo_excel_basico;
            $registro->aprobacion_excel_basico  = $data->aprobacion_excel_basico;
        }

        if($data->has("excel_intermedio")) {
            $registro->excel_intermedio = 1;
            $registro->tiempo_excel_intermedio      = $data->tiempo_excel_intermedio;
            $registro->aprobacion_excel_intermedio  = $data->aprobacion_excel_intermedio;
        }

        $registro->save();

        if($data->hasFile("perfil")) {
            $archivo   = $data->file('perfil');
            $extencion = $archivo->getClientOriginalExtension();
            $fileName  = "perfil_" . $registro->id . ".$extencion";
            
            $cargo_especifico = ModeloTabla::find($registro->id);

			//ELIMINAR PDF
            if($cargo_especifico->archivo_perfil != "" && file_exists("recursos_Perfiles/" . $cargo_especifico->archivo_perfil)) {
                unlink("recursos_Perfiles/" . $cargo_especifico->archivo_perfil);
            }

            $cargo_especifico->archivo_perfil = $fileName;
            $cargo_especifico->save();

            $data->file('perfil')->move("recursos_Perfiles", $fileName);
        }

        $pregunta = Pregunta::where('cargo_especifico_id', 0)->get();

		if($pregunta) {
          	foreach($pregunta as $key => $value) {
            	$pre = Pregunta::find($value->id);

                $pre->cargo_especifico_id = $registro->id;
            	$pre->save();
          	}
        }

    	//Cambiar a tiempos
        if ($data->get("regla_de") != "" && is_array($data->get("regla_de")) && $data->get("regla_a") != "" && is_array($data->get("regla_a"))) {
            $regla                           = $data->get("regla_de");
            $reglad                          = $data->get("regla_a");
            $cantidad_dias                   = $data->get("cantidad_dias");
            $num_cand_presentar_vac          = $data->get("num_cand_presentar_vac");
            $dias_presentar_candidatos_antes = $data->get("dias_presentar_candidatos_antes");

            $negocio = Negocio::where('cliente_id',$registro->clt_codigo)->first();

          	if(count($negocio)>0){
            	for ($i = 0; $i < count($regla); $i++) {
                	if($regla[$i] != "") {
						$consulta_ans = NegocioANS::where("vacantes_inicio", $regla[$i])
						->where("negocio_id", $negocio->id)
						->where("cargo_especifico_id", $registro->id)
						->get();

                    	if ($consulta_ans->count() == 0) {
                        	$negocio_ans = new NegocioANS();
							
							//Unir ambas reglas
                     		$reglas = $regla[$i].'A'.$reglad[$i];

                        	$negocio_ans->fill([
								"vacantes_inicio" => 0, 
								"regla" => $reglas,
								"num_cand_presentar_vac" => $num_cand_presentar_vac[$i],
								"dias_presentar_candidatos_antes" => $dias_presentar_candidatos_antes[$i],
								"cantidad_dias" => $cantidad_dias[$i], 
								"negocio_id" => $negocio->id
                        	]);
							$negocio_ans->cargo_especifico_id = $registro->id;
							$negocio_ans->save();
                    	}
                	}
            	}
          	}
        }
        if($data->has("documento") && is_array($data->get("documento"))){
            $ids_documentos = $data->get("documento");
            $ids_confi_benefi = TipoDocumento::join('cargo_documento', 'cargo_documento.tipo_documento_id', '=', 'tipos_documentos.id')
                ->where('cargo_documento.cargo_especifico_id', $registro->id)
                ->where('tipos_documentos.active', 1)
                ->whereIn('tipos_documentos.categoria', [3,5])
                ->select('tipos_documentos.id')
            ->get();

            foreach ($ids_confi_benefi as $id_tip) {
                //Se agregan los Ids de los tipos de documentos que son categoria 3,5 que estaban asociados con el cargo especifico, para que cuando se sincronicen se queden en la tabla cargo_documento y no se eliminen
                $ids_documentos[] = $id_tip->id;
            }

            $proces_doc = $registro->tipos_documentos()->sync($ids_documentos);
            //$clon_new["documentos"] = $datos->get("documento");
        }

    	//tipos de documentos por cargo        
        /*if($data->has("documento") && is_array($data->get("documento"))) {
            foreach ($data->get("documento") as $documento) {    
            	if(!$registro->hasDocumento($registro->id, $documento)) {
                   	$usuario_agencia = new DocumentosCargo();

					$usuario_agencia->cargo_especifico_id = $registro->id;
					$usuario_agencia->tipo_documento_id = $documento;
					$usuario_agencia->save();
                }
            }

            $documento_cargo = DocumentosCargo::where("cargo_especifico_id",$registro->id)
			->pluck("cargo_documento.tipo_documento_id")
			->toArray();

            $result = array_intersect($documento_cargo, $data->get("documento"));

            foreach($documento_cargo as $value){
              	if(!in_array($value,$result)){
                	DB::table('cargo_documento')->where('cargo_especifico_id', $registro->id)->where("tipo_documento_id", $value)->delete();
              	}
            }
        }*/

     	//tipos de examenes por cargo
        if($data->has("examen") && is_array($data->get("examen"))) {
            foreach($data->get("examen") as $examen) {
                if(!$registro->hasExamen($registro->id, $examen)) {
					$usuario_agencia = new CargosExamenes();
					$usuario_agencia->cargo_id = $registro->id;
					$usuario_agencia->examen_id = $examen;

                    if($data->has("asume")) {    
                        $usuario_agencia->asume = 1;
                    }

					$usuario_agencia->save();
                }
            }
        }

        //Asociar todos los documentos Post-Contratacion al cargo
        /*$tipos_documentos_post = TipoDocumento::where('categoria', config('conf_aplicacion.CATEGORIA_POST_CONTRATACION'))->get();
        foreach ($tipos_documentos_post as $documento_post) {    
            $cargo_documento = new DocumentosCargo();

            $cargo_documento->cargo_especifico_id = $registro->id;
            $cargo_documento->tipo_documento_id   = $documento_post->id;
            $cargo_documento->save();
        }*/

        //comienzo guardar adicionales
        if($data->has("clausulas") && is_array($data->get("clausulas"))) {
            foreach($data->get("clausulas") as $key => $clausula) {
                $cargo_documento_adicional = new CargoDocumentoAdicional();

                $cargo_documento_adicional->cargo_id = $registro->id;
                $cargo_documento_adicional->adicional_id = $clausula;
                $cargo_documento_adicional->save();     

                //Si hay un valor adicional configurado se crea la asociación en la tabla
                if($data->has("valor_adicional") && is_array($data->get("valor_adicional"))) {
                    if (!empty($data->get("valor_adicional")[$clausula])) {
                        $documento_adicional_valor = new ClausulaValorCargo();

                        $documento_adicional_valor->fill([
                            'cargo_id' => $registro->id,
                            'adicional_id' => $clausula,
                            'valor' => $data->get("valor_adicional")[$clausula],
                        ]);
                        $documento_adicional_valor->save();
                    }
                }
            }
        }
        //Fin guardar adicionales

        $documento_cargo = DocumentosCargo::where("cargo_especifico_id", $registro->id)
		->pluck("cargo_documento.tipo_documento_id")
		->toArray();

        /*
         *
         * Para configuración BRYG
         *
        */
        if ($data->has('bryg_configuracion')) {
            $buscarConfiguracion = PruebaBrigConfigCargo::find($data->bryg_configuracion);

            if (!empty($buscarConfiguracion)) {
                $buscarConfiguracion->cargo_id = $registro->id;
                $buscarConfiguracion->save();
            }
        }


        if ($data->has('prueba_valores_1')) {
            $configuracionPruebas = CargoEspecificoConfigPruebas::find($data->prueba_valores_1);

            if (!empty($configuracionPruebas)) {
                $configuracionPruebas->cargo_especifico_id = $registro->id;
                $configuracionPruebas->save();
            }
        }

        /*
         *
         * Para configuración prueba digitación
         *
        */

        if ($data->has('ppm_esperada') && $data->has('precision_esperada')) {
            $digitacionCargo = new PruebaDigitacionCargo();

            $digitacionCargo->fill([
                'cargo_id' => $registro->id,
                'ppm_esperada' => $data->ppm_esperada,
                'precision_esperada' => $data->precision_esperada
            ]);
            $digitacionCargo->save();
        }

        /*
         *
         * Para configuración Competencias
         *
        */

        if ($data->has('competencias_configuracion')) {
            $configuracionIds = explode(",", $data->competencias_configuracion);

            for($i = 0; $i < count($configuracionIds); $i++) {
                $buscarConfiguracion = PruebaCompetenciaCargo::find($configuracionIds[$i]);

                if (!empty($buscarConfiguracion)) {
                    $buscarConfiguracion->cargo_id = $registro->id;
                    $buscarConfiguracion->save();
                }
            }
        }

        if($data->ajax()){
            return response()->json(["success" => true, 'mensaje_success' => 'Cargo creado con éxito.', 'nuevo_cargo' => $registro]);
        }

        return redirect()->route("admin.cargos_especificos.index")->with("mensaje_success", "Cargo creado con éxito");
    }

    public function getCargosAjax(Request $request)
    {
        $listas = ModeloTabla::join('clientes', 'clientes.id', '=', 'cargos_especificos.clt_codigo')
        ->where(function ($sql) use ($request) {
            if($request->cliente_id != ""){
                $sql->where("cargos_especificos.clt_codigo", $request->cliente_id);
            }
        })
        ->select(
            'cargos_especificos.*',
            'clientes.nombre as cliente'
        )
        ->orderBy('cargos_especificos.id', 'DESC')
        ->get();

        $sitioModulo = SitioModulo::first();

        return response()->json(["view" => view("admin.cargos_especificos.include._lista_cargos", compact("listas", "sitioModulo"))->render()]);
    }

    public function get_adicionales_cliente(Request $data)
    {
        if (!isset($data->editar)) {
            $adicionales_cliente = Clientes::join('cargos_especificos', 'cargos_especificos.clt_codigo', '=', 'clientes.id')
            ->join('cargos_documentos_adicionales', 'cargos_documentos_adicionales.cargo_id', '=', 'cargos_especificos.id')
            ->join('documentos_adicionales_contrato', 'documentos_adicionales_contrato.id', '=', 'cargos_documentos_adicionales.adicional_id')
            ->where('documentos_adicionales_contrato.active', 1)
            ->where('clientes.id', $data->cliente_id)
            ->select('documentos_adicionales_contrato.*')
            ->groupBy('documentos_adicionales_contrato.id')
            ->get();

            if ($adicionales_cliente->count() > 0) {
                $adicionales = DocumentoAdicional::where('active', 1)->whereNotIn('id', $adicionales_cliente->modelKeys())->get();
            }else {
                $adicionales = DocumentoAdicional::where('active', 1)->get();
            }

            return response()->json(['adicionales_tabla' => view('admin.cargos_especificos.include._table_lista_adicionales', compact('adicionales_cliente', 'adicionales'))->render()]);
        }else {
            $adicionales_cliente = DocumentoAdicional::join('cargos_documentos_adicionales', 'cargos_documentos_adicionales.adicional_id', '=', 'documentos_adicionales_contrato.id')
            ->join('cargos_especificos', 'cargos_especificos.id', '=', 'cargos_documentos_adicionales.cargo_id')
            ->join('clientes', 'clientes.id', '=', 'cargos_especificos.clt_codigo')
            ->where('documentos_adicionales_contrato.active', 1)
            ->where('clientes.id', $data->cliente_id)
            ->select('documentos_adicionales_contrato.*')
            ->groupBy('documentos_adicionales_contrato.id')
            ->get();

            if ($adicionales_cliente->count() > 0) {
                $adicionales = DocumentoAdicional::where('active', 1)->whereNotIn('id', $adicionales_cliente->modelKeys())->get();
            }else {
                $adicionales = DocumentoAdicional::where('active', 1)->get();
            }

            $registro = ModeloTabla::with("tipos_documentos")->with("examenes")->find($data->cargo_id);

            return response()->json(['adicionales_tabla' => view('admin.cargos_especificos.include._table_lista_adicionales_editar', compact('adicionales_cliente', 'adicionales', 'registro'))->render()]);
        }
    }
}