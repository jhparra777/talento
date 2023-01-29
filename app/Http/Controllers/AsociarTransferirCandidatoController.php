<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use triPostmaster;

use App\Http\Controllers\ReclutamientoController;

use App\Models\Auditoria;
use App\Models\CandidatoReclutamientoExterno;
use App\Models\CandidatosFuentes;
use App\Models\DatosBasicos;
use App\Models\DocumentosCargo;
use App\Models\DocumentosVerificados;
use App\Models\EntrevistaCandidatos;
use App\Models\EstadosRequerimientos;
use App\Models\ExperienciaVerificada;
use App\Models\GestionPrueba;
use App\Models\ListaNegra;
use App\Models\OfertaUser;
use App\Models\Preperfilados;
use App\Models\ProcesoRequerimiento;
use App\Models\ReferenciaPersonalVerificada;
use App\Models\RegistroProceso;
use App\Models\ReqCandidato;
use App\Models\Requerimiento;
use App\Models\Sitio;
use App\Models\TipoFuentes;
use App\Models\TipoDocumento;

use App\Events\PorcentajeHvEvent;

class AsociarTransferirCandidatoController extends Controller
{
    protected $estados_no_muestra = [];

    public function __construct()
    {
        parent::__construct();

        //SON LOS ESTADOS PARA NO MOSTRAR EL CANDIDATO EN EL  REQUERIMIENTO
        $this->estados_no_muestra = [
            config('conf_aplicacion.C_QUITAR'),
            config('conf_aplicacion.C_INACTIVO'),
            config('conf_aplicacion.C_TRANSFERIDO'),
        ];
    }

    public function agregar_candidato_fuentes(Request $data)
    {
        $errores_array     = [];
        $success           = false;
        $guardar           = true;
        $errores_array_req = [];
        $nuevo_registro    = false;

        //agregar al req desde otras fuentes
        if($data->has("cedula") && $data->get("cedula") != '') {
            //NUEVO (CREAR USUARIO)
            $datos = $data->all();
            $usuario_cargo = $this->user->id;

            $fuentes = ["" => "Seleccionar"] + TipoFuentes::pluck("descripcion", "id")->toArray();

            $datos_basicos = DatosBasicos::where('numero_id', $data->get("cedula"))->first();

            if(is_null($datos_basicos)){
                $existe_registro_email = DatosBasicos::where('email',$data->get("email"))->first();

                if(count($existe_registro_email) > 0){
                    //Este correo ya esta registrado
                    return response()->json([
                        "success" => false,
                        "mensaje" => "Este correo ya se encuentra registrado"
                    ]);
                }

                //Creamos el usuario
                $campos_usuario = [
                    'name' 			=> $data->get("primer_nombre").' '.$data->get("segundo_nombre")." ".$data->get("primer_apellido").' '.$data->get("segundo_apellido"),
                    'email'     	=> $data->get("email"),
                    'password'  	=> $data->get("cedula"),
                    'numero_id' 	=> $data->get("cedula"),
                    'cedula'    	=> $data->get("cedula"),
                    'metodo_carga' 	=> 3,
                    'usuario_carga' => $this->user->id,
                    'tipo_fuente_id'=> $data->get("tipo_fuente_id")
                ];

                $validar_email = json_decode($this->verificar_email($data->get("email")));

                if($validar_email->status == 200 && !$validar_email->valid) {
                    return response()->json([
                        "success" => false,
                        "mensaje" => $validar_email->mensaje
                    ]);
                }

                $user = Sentinel::registerAndActivate($campos_usuario);

                $usuario_id = $user->id;

                //Creamos sus datos basicos
                $datos_basicos = new DatosBasicos();

                $datos_basicos->fill([
                    'numero_id'       		=> $data->get("cedula"),
                    'user_id'         		=> $usuario_id,
                    'nombres'         		=> $data->get("primer_nombre").' '.$data->get("segundo_nombre"),
                    'primer_nombre'   		=> $data->get("primer_nombre"),
                    'segundo_nombre'   		=> $data->get("segundo_nombre"),
                    'primer_apellido' 		=> $data->get("primer_apellido"),
                    'segundo_apellido'		=> $data->get("segundo_apellido"),
                    'telefono_movil'  		=> $data->get("celular"),
                    'estado_reclutamiento' 	=> config('conf_aplicacion.C_ACTIVO'),
                    'email'             	=> $data->get("email")
                ]);

                //Se verifica si a la persona que se registra esta en la lista negra, se coloca en estado_reclutamiento, que tiene problema de seguridad
                $cand_lista_negra = ListaNegra::where('cedula', $datos_basicos->numero_id)->first();
                if ($cand_lista_negra != null) {
                    $datos_basicos->estado_reclutamiento = config('conf_aplicacion.PROBLEMA_SEGURIDAD');

                    $datos_basicos->save();

                    if ($cand_lista_negra->restriccion_id != '' && $cand_lista_negra->restriccion_id != null) {
                        $restriccion = DB::table('tipos_restricciones')->select('descripcion', 'id')->find($cand_lista_negra->restriccion_id);
                    } else {
                        $restriccion = collect(['descripcion' => 'no hay una restricción guardada.']);
                    }

                    if ($cand_lista_negra->gestiono != '' && $cand_lista_negra->gestiono != null) {
                        $gestiono = $cand_lista_negra->gestiono;
                    } else {
                        $gestiono = $this->user->id;
                    }

                    //ACTIVAR USUARIO Evento
                    $auditoria                = new Auditoria();
                    $auditoria->observaciones = 'Se registro por agregar a otras fuentes y se encuentra en listado especial con la restricción ' . $restriccion->descripcion;
                    $auditoria->valor_antes   = json_encode(["estado" => config('conf_aplicacion.C_ACTIVO')]);
                    $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.PROBLEMA_SEGURIDAD')]);
                    $auditoria->user_id       = $gestiono;
                    $auditoria->tabla         = "datos_basicos";
                    $auditoria->tabla_id      = $datos_basicos->id;
                    $auditoria->tipo          = 'ACTUALIZAR';
                    event(new \App\Events\AuditoriaEvent($auditoria));
                }

                $datos_basicos->save();

                $nuevo_registro = true;

                Event::dispatch(new PorcentajeHvEvent($datos_basicos));

                //Creamos el rol
                $role = Sentinel::findRoleBySlug('hv');
                $role->users()->attach($user);

                $sitio = Sitio::first();

                if(isset($sitio->nombre)) {
                    if($sitio->nombre != "") {
                        $nombre = $sitio->nombre;
                    }else {
                        $nombre = "Desarrollo";
                    }
                }

                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                $mailTitle = "Bienvenido a {$nombre} - T3RS"; //Titulo o tema del correo

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "
                    ¡Hola $datos_basicos->nombres $datos_basicos->primer_apellido $datos_basicos->segundo_apellido!<br>
                    Se ha creado exitosamente tu cuenta en T3RS, te invitamos a ingresar usando tu número de documento como usuario y contraseña para completar tu hoja de vida y cargar tus documentos.
                    ";
                //Arreglo para el botón
                $mailButton = ['buttonText' => '¡COMPLETA TU HOJA DE VIDA!', 'buttonRoute' => route('login')];

                $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $nombre, $sitio) {
                    $message->to($datos_basicos->email, $datos_basicos->nombres)
                    ->subject("Bienvenido a $nombre - T3RS")
                    ->bcc($sitio->email_replica)
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

                //si no existe el usuario crearlo
            }else {
                $datos_basicos->fill([
                    'nombres'         => $data->get("primer_nombre").' '.$data->get("segundo_nombre"),
                    'primer_nombre'   => $data->get("primer_nombre"),
                    'segundo_nombre'  => $data->get("segundo_nombre"),
                    'primer_apellido' => $data->get("primer_apellido"),
                    'segundo_apellido'=> $data->get("segundo_apellido"),
                    'telefono_movil'  => $data->get("celular")
                ]);

                $datos_basicos->save();
            }   //AGREGAR A OTRAS FUENTES
            $desc = $datos_basicos->getTipoIdentificacion()->descripcion;
            $tipo_doc_desc = ($desc != '' ? $desc : 'Nro. identificación');

            $candidato_fuente = CandidatosFuentes::where("requerimiento_id", $data->get("requerimiento_id"))->where("cedula", $data->get("cedula"))->get();

            if($candidato_fuente->count() > 0){
                array_push($errores_array, "<li>El candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . "</strong> $tipo_doc_desc <b>" . $datos_basicos->numero_id . "</b> ya se encuentra asociado al requerimiento.</li>");
            }

            if($data->ajax() && !$data->has('asociar_directo')){
                if ($datos_basicos->estado_reclutamiento != config('conf_aplicacion.PROBLEMA_SEGURIDAD') && $datos_basicos->estado_reclutamiento != config('conf_aplicacion.C_BAJA_VOLUNTARIA')) {
                    //INGRESAR CANDIDATO
                    $candidato = new CandidatosFuentes();
                    $candidato->fill($data->all());
                    $candidato->nombres =$data->get("primer_nombre").' '.$data->get("segundo_nombre");
                    $candidato->save();
                    //FIN AGREGAR OTRAS FUENTES
                } else {
                    $mensaje = "<li>El candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> no se puede agregar porque solicitó baja voluntaria en la plataforma.</li>";

                    if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD')) {
                        $lista_negra = ListaNegra::leftjoin('tipos_restricciones', 'tipos_restricciones.id', '=', 'lista_negra.restriccion_id')
                                ->select('tipos_restricciones.descripcion as restriccion')
                                ->where('cedula', $datos_basicos->numero_id)
                                ->orderBy('lista_negra.id', 'desc')
                            ->first();

                        $mensaje = '<li>El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> ' . $tipo_doc_desc .' <b>' . $datos_basicos->numero_id . '</b> no se puede asociar al requerimiento porque presenta problemas de seguridad.</li>';

                        if($lista_negra != null && $lista_negra->restriccion != null) {
                            $mensaje = '<li>El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> ' . $tipo_doc_desc . ' <b>' . $datos_basicos->numero_id . '</b> no se puede asociar al requerimiento porque presenta problemas de seguridad.<br>Se encuentra '. $lista_negra->restriccion .'</li>';

                            if ($nuevo_registro) {
                                $mensaje = '<li>Se ha creado con éxito la cuenta. El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> ' . $tipo_doc_desc . ' <b>' . $datos_basicos->numero_id . '</b> no se puede asociar al requerimiento porque presenta problemas de seguridad.<br>Se encuentra '. $lista_negra->restriccion .'</li>';
                            }
                        } else {
                            if ($nuevo_registro) {
                                $mensaje = '<li>Se ha creado con éxito la cuenta. El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> ' . $tipo_doc_desc . ' <b>' . $datos_basicos->numero_id . '</b> no se puede asociar al requerimiento porque presenta problemas de seguridad.</li>';
                            }
                        }
                    }

                    return response()->json([
                        "success" => false,
                        "es_success" => true,
                        "mensaje" => $mensaje
                    ]);
                }
            }
            //FIN DE LO NUEVO
        }

        $transferir_candidato = [];
    	$columna_where = 'user_id';
    	$otra_fuente_id = 2;
    	$aplicar_candidatos = [];

        //Valida si viene un arreglo para procesar
    	if (is_array($data->get("aplicar_candidatos_fuentes")) && $data->get("aplicar_candidatos_fuentes") != "") {
    		$aplicar_candidatos = $data->get("aplicar_candidatos_fuentes");
    		$tabla_aplicar = 'fuentes';
    		$columna_where = 'numero_id';
    		$observacion_ingreso = 'Ingreso al requerimiento desde otras fuentes';
    	} elseif (is_array($data->get("aplicar_candidatos_preperfilado")) && $data->get("aplicar_candidatos_preperfilado")) {
    		$aplicar_candidatos = $data->get("aplicar_candidatos_preperfilado");
    		$tabla_aplicar = 'preperfilados';
    		$observacion_ingreso = 'Ingreso al requerimiento desde preperfilados';
    		$otra_fuente_id = 3;
    	} elseif (is_array($data->get("aplicar_candidatos")) && $data->get("aplicar_candidatos") != "") {
    		$aplicar_candidatos = $data->get("aplicar_candidatos");
    		$tabla_aplicar = 'postulados';
    		$observacion_ingreso = 'Ingreso al requerimiento desde candidatos que aplicaron';
    		$otra_fuente_id = 4;
    		if ($data->has('reclutamiento_externo')) {
    			$tabla_aplicar = 'reclutamiento_externo';
        		$observacion_ingreso = 'Ingreso al requerimiento desde reclutamiento externo';
        		$otra_fuente_id = 5;
    		}
    	} elseif (is_array($data->get("apply_candidates_ee")) && $data->get("apply_candidates_ee") != "") {
    		$aplicar_candidatos = $data->get("apply_candidates_ee");
    		$tabla_aplicar = 'reclutamiento_ee';
    		$observacion_ingreso = 'Ingreso al requerimiento desde el empleo';
    		$otra_fuente_id = 6;
    	}

        if (count($aplicar_candidatos) > 0) {
        	$asocio_candidato = false; //Variable de control para saber si se asocio algun candidato al requerimiento

            foreach($aplicar_candidatos as $value){
                $datos_basicos = DatosBasicos::where($columna_where, $value)->first();
	            $desc = $datos_basicos->getTipoIdentificacion()->descripcion;
	            $tipo_doc_desc = ($desc != '' ? $desc : 'Nro. identificación');

                if ($datos_basicos != null) {
                    //Si tiene problemas de seguridad
                    if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.PROBLEMA_SEGURIDAD')) {
                        $lista_negra = ListaNegra::leftjoin('tipos_restricciones', 'tipos_restricciones.id', '=', 'lista_negra.restriccion_id')
                            ->select('tipos_restricciones.descripcion as restriccion')
                            ->where('cedula', $datos_basicos->numero_id)
                            ->orderBy('lista_negra.id', 'desc')
                        ->first();

                        if($lista_negra != null && $lista_negra->restriccion != null) {
                            $mensaje_error = '<li>El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> ' . $tipo_doc_desc . ' <b>' . $datos_basicos->numero_id . '</b> no se puede asociar al requerimiento porque presenta problemas de seguridad.<br>Se encuentra '. $lista_negra->restriccion .'</li>';
                        } else {
                            $mensaje_error = '<li>El candidato <strong>' . $datos_basicos->nombres . ' ' . $datos_basicos->primer_apellido . ' ' . $datos_basicos->segundo_apellido . '</strong> ' . $tipo_doc_desc . ' <b>' . $datos_basicos->numero_id . '</b> no se puede asociar al requerimiento porque presenta problemas de seguridad.</li>';
                        }

                        array_push($errores_array, $mensaje_error);
                    } else {
                        if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO') || $datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_BAJA_VOLUNTARIA')){
                            //Si esta inactivo
                            if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_INACTIVO')) {
                                $auditoria = Auditoria::where('tabla', 'datos_basicos')
                                    ->where('tabla_id', $datos_basicos->id)
                                    ->whereIn('tipo', ['ACTUALIZAR', 'RECHAZAR_CANDIDATO_INACTIVAR'])
                                    ->orderBy('id', 'desc')
                                ->first();

                                if (is_null($auditoria)) {
                                    $auditoria = new Auditoria();
                                    $auditoria->observaciones = '';
                                } else {
                                    if ($auditoria->tipo == 'RECHAZAR_CANDIDATO_INACTIVAR') {
                                        //Si se rechazo el candidato desde un Requerimiento, se busca la observacion
                                        $proceso = RegistroProceso::where('candidato_id', $datos_basicos->user_id)
                                            ->where('proceso', 'RECHAZAR_CANDIDATO')
                                            ->orderBy('id', 'desc')
                                        ->first();

                                        if (!is_null($proceso)) {
                                            $auditoria->observaciones = $proceso->observaciones;
                                        }
                                    }
                                }

                                array_push($errores_array, "<li>El candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> $tipo_doc_desc <b>" . $datos_basicos->numero_id . "</b> no se puede agregar porque tiene un estado inactivo.<br>Observación: $auditoria->observaciones</li>");
                            } else {
                                array_push($errores_array, "<li>El candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . " </strong> se puede agregar porque solicitó baja voluntaria en la plataforma.</li>");
                            }
                        } else {
                            if ($datos_basicos->estado_reclutamiento == config('conf_aplicacion.C_ACTIVO')) {
                                /*Si el estado de reclutamiento del candidato esta:
                                * 5-Activo
                                * No es transferencia y se puede asociar directamente
                                */
                                $this->completar_asociacion_candidato($data, $datos_basicos, $errores_array, $observacion_ingreso, $otra_fuente_id, $tabla_aplicar);
                                $asocio_candidato = true;
                            }else{
                                $asociacion_completa = false;
                                $proceso_req_cand = RegistroProceso::where("candidato_id", $datos_basicos->user_id)->orderBy('id', 'desc')->first();
                                if ($proceso_req_cand != null) {
                                    if ($proceso_req_cand->estado == config('conf_aplicacion.C_QUITAR')) {
                                        /*Si el estado del candidato en el requerimiento anterior esta:
                                        * 14-Quitado
                                        * No es transferencia y se puede asociar directamente
                                        */
                                        $asociacion_completa = $this->completar_asociacion_candidato($data, $datos_basicos, $errores_array, $observacion_ingreso, $otra_fuente_id, $tabla_aplicar);
                                        $asocio_candidato = true;
                                    }
                                }

                                if (!$asociacion_completa) {
                                    $datos = DB::table("requerimiento_cantidato")
                                    ->whereRaw(" estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
                                    ->where("candidato_id", $datos_basicos->user_id);

                                    if($datos->count() > 0){
                                        $req = $datos->select("requerimiento_cantidato.requerimiento_id", "requerimiento_cantidato.id as candidato_req")->orderBy('id', 'DESC')->first();

                                        if ($req->requerimiento_id == $data->get("requerimiento_id")) {
                                        	array_push($errores_array, "<li>El candidato <strong>" . $datos_basicos->nombres . " " . $datos_basicos->primer_apellido . " " . $datos_basicos->segundo_apellido . "</strong> $tipo_doc_desc <b>" . $datos_basicos->numero_id . "</b> ya se encuentra asociado al requerimiento.</li>");
                                        	continue;
                                        }

                                        $transferir_candidato[] = $req->candidato_req;
                                    } else {
                                        $this->completar_asociacion_candidato($data, $datos_basicos, $errores_array, $observacion_ingreso, $otra_fuente_id, $tabla_aplicar);
                                        $asocio_candidato = true;
                                    }
                                }
                            }
                        }
                    }
                } else {
                    array_push($errores_array, '<li>No se agrego el candidato. No tiene actualizada la hoja de vida</li>');
                }
            }
        } else {
            $errores_array = ["<li>No se seleccionaron candidatos.</li>"];
        }

        if($data->ajax() && !$data->has('asociar_directo')){
            return response()->json(["success" => true, "mensaje" => "Se han agregado exitosamente los candidatos."]);
        }

        if (count($transferir_candidato) > 0) {
        	$procesos_transferibles = DB::table('tipos_procesos_manejados')->where('active', 1)->where('transferible', 1)->pluck('nombre_trazabilidad');

        	$procesos_transferibles_string = "('".implode("','", $procesos_transferibles->all())."')";

        	$otros_procesos = DB::table('tipos_procesos_manejados')->where('active', 1)->where('transferible', 0)->pluck('nombre_trazabilidad');

        	$otros_procesos_string = "('".implode("','", $otros_procesos->all())."')";

        	$req_candidato_string = "('".implode("','", $transferir_candidato)."')";

        	$candidatos_transferir = RegistroProceso::join('datos_basicos', 'datos_basicos.user_id', '=', 'procesos_candidato_req.candidato_id')
        		->leftjoin('tipo_identificacion', 'tipo_identificacion.id', '=', 'datos_basicos.tipo_id')
        		->whereIn('procesos_candidato_req.requerimiento_candidato_id', $transferir_candidato)
	        	->select(
	        		'datos_basicos.nombres',
	        		'datos_basicos.numero_id',
	        		'datos_basicos.primer_nombre',
	        		'datos_basicos.primer_apellido',
	        		'procesos_candidato_req.requerimiento_id as requerimiento',
	        		'procesos_candidato_req.requerimiento_candidato_id as req_cand',
	        		'tipo_identificacion.descripcion as tipo_doc_desc',

                    DB::raw('(select estados.descripcion from requerimiento_cantidato inner join estados on estados.id = requerimiento_cantidato.estado_candidato where requerimiento_cantidato.id = req_cand limit 1) as estado_actual'),

	        		DB::raw('(select users.name from procesos_candidato_req inner join users on users.id = procesos_candidato_req.usuario_envio where procesos_candidato_req.requerimiento_candidato_id = req_cand order by procesos_candidato_req.id asc limit 1) as usuario_asocio'),

	        		DB::raw('(select procesos_candidato_req.created_at from procesos_candidato_req where procesos_candidato_req.requerimiento_candidato_id = req_cand order by procesos_candidato_req.id asc limit 1) as fecha_asocio'),

	        		DB::raw("(select GROUP_CONCAT(proceso,' | ',nombre_visible SEPARATOR ', ') from procesos_candidato_req left join tipos_procesos_manejados on tipos_procesos_manejados.nombre_trazabilidad = procesos_candidato_req.proceso where procesos_candidato_req.requerimiento_candidato_id = req_cand and procesos_candidato_req.proceso in $procesos_transferibles_string) as procesos_transferibles"),

	        		DB::raw("(select GROUP_CONCAT(proceso,' | ',IF(nombre_visible is null,proceso,nombre_visible) SEPARATOR ', ') from procesos_candidato_req left join tipos_procesos_manejados on tipos_procesos_manejados.nombre_trazabilidad = procesos_candidato_req.proceso where procesos_candidato_req.requerimiento_candidato_id = req_cand and procesos_candidato_req.proceso in $otros_procesos_string and procesos_candidato_req.proceso != 'ASIGNADO_REQUERIMIENTO') as procesos")
	        	)
	        	->groupBy('procesos_candidato_req.requerimiento_candidato_id')
        	->get();

        	$req_id = $data->requerimiento_id;

        	return response()->json([
        		"success" => true,
        		"transferir_directo" => false,
        		"candidatos_transferir" => $candidatos_transferir,
        		"view" => view("admin.reclutamiento.modal._modal_candidatos_a_transferir",
        			compact(
        				"req_id",
        				"candidatos_transferir",
        				"asocio_candidato",
        				"tabla_aplicar",
        				"otra_fuente_id",
        				"observacion_ingreso",
        				"errores_array"
        			)
        		)->render()
        	]);
        }

        if (count($errores_array) > 0 && !in_array("<li>No se agrego el candidato. No tiene actualizada la hoja de vida</li>", $errores_array) && !in_array("<li>No se seleccionaron candidatos.</li>", $errores_array) && !in_array("<li>Se han agregado los candidatos con éxito.</li>", $errores_array) && !in_array('', $errores_array)) {
        	return response()->json([
        		"success" => true,
        		"transferir_directo" => false,
        		"candidatos_transferir" => [],
        		"view" => view("admin.reclutamiento.modal._modal_candidatos_a_transferir",
        			compact(
        				"req_id",
        				"candidatos_transferir",
        				"asocio_candidato",
        				"tabla_aplicar",
        				"otra_fuente_id",
        				"observacion_ingreso",
        				"errores_array"
        			)
        		)->render()
        	]);
        }

        return response()->json(["success" => true, "transferir_directo" => true]);
    }

    protected function completar_asociacion_candidato(Request $data, $datos_basicos, &$errores_array, $observacion_ingreso = 'Ingreso al requerimiento', $otra_fuente_id = 1, $tabla_aplicar = 'fuentes') {
        //VERIFICAR SI TIENE EL 100% DE LA HV
        $datos_basicos->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_SELECCION');

        $datos_basicos->save();

        //ASOCIO EL CANDIDATO AL REQUERIMIENTO
        $nuevo_candidato_req = new ReqCandidato();

        $nuevo_candidato_req->fill([
            "estado_candidato"	=> config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            "requerimiento_id"	=> $data->get("requerimiento_id"),
            "candidato_id"		=> $datos_basicos->user_id,
            "otra_fuente"		=> $otra_fuente_id
        ]);

        $nuevo_candidato_req->save();

        //CREO EL ESTADO DE INGRESO A REQUERIMIENTO
        $nuevo_proceso = new RegistroProceso();

        $nuevo_proceso->fill([
            'proceso'                    => 'ASIGNADO_REQUERIMIENTO',
            'requerimiento_candidato_id' => $nuevo_candidato_req->id,
            'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            'fecha_inicio'               => date("Y-m-d H:i:s"),
            'usuario_envio'              => $this->user->id,
            'requerimiento_id'           => $data->get("requerimiento_id"),
            'candidato_id'               => $datos_basicos->user_id,
            'observaciones'              => $observacion_ingreso,
        ]);

        $nuevo_proceso->save();


        //Se elimina de la tabla donde venga
        if ($tabla_aplicar == 'fuentes') {
        	$desde = 'otras fuentes';
        	CandidatosFuentes::where("cedula", $datos_basicos->numero_id)
        		->where("requerimiento_id", $data->get("requerimiento_id"))
        	->delete();
        } elseif ($tabla_aplicar == 'postulados') {
        	$desde = 'candidatos postulados';
        	$oferta_user = OfertaUser::where("user_id", $datos_basicos->user_id)
	        	->where("requerimiento_id", $data->get("requerimiento_id"))
	        ->first();

	        if(!is_null($oferta_user)){
	            $oferta_user->estado = 0;
	            $oferta_user->save();
	        }
        } elseif ($tabla_aplicar == 'preperfilados') {
        	$desde = 'candidatos preperfilados';
        	Preperfilados::where('candidato_id', $datos_basicos->user_id)
				->where('req_id', $data->get("requerimiento_id"))
			->delete();
        } elseif ('reclutamiento_externo') {
        	$desde = 'reclutamiento externo';
        	CandidatoReclutamientoExterno::where('candidato_id', $datos_basicos->user_id)
				->where('req_id', $data->get("requerimiento_id"))
			->delete();
        } elseif ('reclutamiento_ee') {
			$desde = 'reclutamiento el empleo';
        	# code...
        }

        if(!in_array("<li>Se han agregado los candidatos con éxito.</li>", $errores_array)){
            array_push($errores_array, "<li>Se han agregado los candidatos con éxito.</li>");
        }

        //Se cambia el estado del requerimiento al enlazarlo con un candidato
        $requerimiento_obj=Requerimiento::find($data->get("requerimiento_id"));
        $cuenta_candidatos=ReqCandidato::where("requerimiento_id",$data->get("requerimiento_id"))
        ->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")->count();

        if($requerimiento_obj->num_vacantes == $cuenta_candidatos){
            //Cambiar el estado cuando ya se asocian tantos candidatos como vacantes se solicitan
            $nuevoEstado = new EstadosRequerimientos();

            $nuevoEstado->req_id = $requerimiento_obj->id;

            $nuevoEstado->user_gestion = $this->user->id;

            $nuevoEstado->estado = config('conf_aplicacion.C_EN_PROCESO_SELECCION');

            $nuevoEstado->save();
        }

        $user_sesion = $this->user;
        $sitio = Sitio::first();

        if ($sitio->esProcesoEnSitio($data->get("requerimiento_id"))) {
            $campos_data = [
                'requerimiento_candidato_id'	=> $nuevo_candidato_req->id,
                'usuario_envio'                 => $this->user->id,
                "fecha_inicio"                  => date("Y-m-d H:i:s"),
                'proceso'                       => "ENVIO_APROBAR_CLIENTE",
            	'requerimiento_id'				=> $data->get("requerimiento_id"),
            	'candidato_id'               	=> $datos_basicos->user_id,
	            'estado'           				=> config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                'observaciones'                 => "Se ha enviado a aprobar por el cliente desde $desde"
            ];

	        //ACTUALIZA REGISTRO A ESTADO SEGUN EL PROCESO
	        $nuevo_candidato_req->update(['estado_candidato' => config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE')]);

	        //REGISTRA PROCESO
	        $nuevo_proceso = new RegistroProceso();
	        $nuevo_proceso->fill($campos_data);
	        $nuevo_proceso->save();

            $fecha_presentacion_candidatos = Carbon::now('America/Bogota');
            $fecha_presentacion_oport_cand = Carbon::parse($requerimiento_obj->fecha_presentacion_oport_cand);

            if ($fecha_presentacion_candidatos->lte($fecha_presentacion_oport_cand)) {
                // entonces es oportuna la presentacion del candidato
                $cand_presentados_puntual                    = $requerimiento_obj->cand_presentados_puntual + 1;
                $requerimiento_obj->cand_presentados_puntual = $cand_presentados_puntual;
                $nuevo_proceso->cand_presentado_puntual   = 1;
            }

            if ($fecha_presentacion_candidatos->gt($fecha_presentacion_oport_cand)) {
                $cand_presentados_no_puntual                    = $requerimiento_obj->cand_presentados_no_puntual + 1;
                $requerimiento_obj->cand_presentados_no_puntual = $cand_presentados_no_puntual;
            }

            //Actualizamos el requerimiento
            $requerimiento_obj->fecha_presentacion_candidatos = $fecha_presentacion_candidatos;
            $requerimiento_obj->save();
            $nuevo_proceso->save();
            $cant_enviar = 0;

            $cuentas = NegocioANS::where("negocio_id",$requerimiento_obj->negocio_id)
            	->where('cargo_especifico_id',$requerimiento_obj->cargo_especifico_id)
            ->get();

            //cuentas
            $cant_enviar = $requerimiento_obj->num_vacantes * 1;
            
            if(!is_null($cuentas)){
                foreach($cuentas as $value){
                    if($value->num_cand_presentar_vac){
                        //$regla =  explode('A',$value->regla);
                        $cant_enviar = $requerimiento_obj->num_vacantes*$value->num_cand_presentar_vac;
                    }else{
                        if($requerimiento_obj->num_vacantes >= 1 && $requerimiento_obj->num_vacantes <= 3){
                            $cant_enviar = $requerimiento_obj->num_vacantes * 2;
                        }else{
                            $cant_enviar = $requerimiento_obj->num_vacantes * 1;
                        }
                    }
                }
            }else{   
                if($requerimiento_obj->num_vacantes >= 1 && $requerimiento_obj->num_vacantes <= 3){
                    $cant_enviar = $requerimiento_obj->num_vacantes * 2;
                }else{
                    $cant_enviar = $requerimiento_obj->num_vacantes * 1;
                }
            }

            $enviados_al_cliente = RegistroProceso::join("requerimiento_cantidato","requerimiento_cantidato.id","=","procesos_candidato_req.requerimiento_candidato_id")
            	->where("procesos_candidato_req.requerimiento_id", $requerimiento_obj->id)
            	->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
            	->where("proceso","ENVIO_APROBAR_CLIENTE")
            ->count();

            if($enviados_al_cliente >= $cant_enviar){
            	$ult_estado_req = $requerimiento_obj->ultimoEstadoRequerimiento()->id;
                if($ult_estado_req != config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE') && $ult_estado_req != config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')) {
                    $nuevoEstado = new EstadosRequerimientos();

                    $nuevoEstado->req_id 		= $requerimiento_obj->id;
                    $nuevoEstado->user_gestion 	= $this->user->id;

                    $nuevoEstado->estado  = config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE');
                    $nuevoEstado->save();
                }
            }
        }

        $tipo_proceso = $requerimiento_obj->obtenerTipoProceso;
        if($user_sesion->hasAccess("email_candidato_req") && !empty($tipo_proceso) && $tipo_proceso->cod_tipo_proceso != 'PB') {
            //Sino es Proceso Backup se enviara el correo

            $nombre_empresa = "Desarrollo";
            if(isset($sitio->nombre) && $sitio->nombre != "") {
                $nombre_empresa = $sitio->nombre;
            }

            $home = route('home');

            $urls = route('home.detalle_oferta', ['oferta_id' => $data->get("requerimiento_id")]);

            $req_can_id = $nuevo_candidato_req->id;

            $nombres = $datos_basicos->nombres;

            $nombre = ucwords(strtolower($nombres));

            $asunto = "Notificación de proceso de selección";

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Notificación de Proceso de Selección"; //Titulo o tema del correo

            $mailBody = "
                        ¡Hola $nombre!
                        <br/><br/>
                        Es un gusto para nosotros que seas parte de este proceso de selección, haz clic en el siguiente botón, donde podrás encontrar la información de la vacante. 
                        <br/><br/>
                        <b>¡Éxitos!</b>
                        ";

            //Arreglo para el botón
            $mailButton = ['buttonText' => 'OFERTA LABORAL', 'buttonRoute' => route('home.detalle_oferta', ['oferta_id' => $data->get("requerimiento_id")])];

            $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

            //$triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            if($datos_basicos->email){
                $emails = $datos_basicos->email;
            }else{
                $emails = false;
            }

            $mensaje = "Es un gusto para nosotros que seas parte de este proceso de selección, haz clic en el siguiente botón, donde podrás encontrar la información de la vacante.";

            if($emails){
                $cargo_esp = DB::table("cargos_especificos")->join("requerimientos", "requerimientos.cargo_especifico_id","=", "cargos_especificos.id")
                    ->where("requerimientos.id", $value["req_id"])
                    ->select(
                        "cargos_especificos.id as cargo",
                        "cargos_especificos.firma_digital as firma"
                    )
                ->first();

                $cargo_documentos = null;
                if ($sitio->asistente_contratacion == 1 && !empty($cargo_esp) && $cargo_esp->firma == 1){
                    //Si el sitio tiene asistente y el cargo tiene firma digital, se buscan los documentos asociados al cargo categoria 1 y que pueda cargar el candidato
                    $cargo_documentos = DocumentosCargo::join('tipos_documentos','tipos_documentos.id','=','cargo_documento.tipo_documento_id')
                        ->where('cargo_documento.cargo_especifico_id', $cargo_esp->cargo)
                        ->where('tipos_documentos.categoria', 1)
                        ->where('tipos_documentos.carga_candidato', 1)
                        ->select(
                            'tipos_documentos.id',
                            'tipos_documentos.descripcion'
                        )
                    ->get();

                    if (count($cargo_documentos) == 0) {
                        //En caso que el cargo no tenga asociados tipos de documento mostrar listados los tipos de documento con cod_tipo_doc=CC
                        $cargo_documentos = TipoDocumento::where('cod_tipo_doc', 'CC')
                            ->where('tipos_documentos.categoria', 1)
                            ->where('tipos_documentos.carga_candidato', 1)
                            ->select(
                                'tipos_documentos.id',
                                'tipos_documentos.descripcion'
                            )
                        ->get();
                    }
                }

                if (is_null($cargo_documentos)) {

                    $mailAditionalTemplate = [];

                }else{

                    $mailAditionalTemplate = ['nameTemplate' => 'proceso_seleccion', 'dataTemplate' => ["cargo_documentos" => $cargo_documentos]];
                }

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser, $mailAditionalTemplate);

                if (route('home') == 'https://listos.t3rsc.co') {
                    Mail::send('admin.enviar_email_candidatos_otras_fuentes_listos', [
                        "home" => $home,
                        "url" => $urls,
                        "req_can_id" => $req_can_id,
                        "nombre" => $nombre
                    ], function($message) use ($data, $emails, $asunto, $nombre_empresa, $sitio) {
                        $message->to($emails, "$nombre_empresa - T3RS");
                        $message->subject($asunto)
                        ->bcc($sitio->email_replica)
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                }else{
                    $saludo = 'Hola '.$nombre;

	                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($emails, $asunto, $nombre_empresa, $sitio) {

	                        $message->to($emails, "$nombre_empresa - T3RS");
	                        $message->subject($asunto)
                            ->bcc($sitio->email_replica)
	                        ->getHeaders()
	                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
	                });
                }
            }
        }
        return true;
    }

    public function transferir_candidato(Request $request)
    { 
      	//funcion para transferir candidatos de un req a otro.. aqui pasa cuando se debe transferir
        $success           		= false;
        $errores_array     		= [];
        $errores_array_req 		= [];
        $user_sesion 			= $this->user;
        $tabla_aplicar			= $request->tabla_aplicar;
        $otra_fuente_id			= $request->otra_fuente_id;
        $observacion_ingreso	= $request->observacion_ingreso;

		$sitio = Sitio::first();
	    $es_proceso_sitio = $sitio->esProcesoEnSitio($request->req_id);

        foreach($request["req_cand_id"] as $req_cand_id) {
            $candidato_contratado = RegistroProceso::where('requerimiento_candidato_id', $req_cand_id)
            	->where('estado', config('conf_aplicacion.C_CONTRATADO'))
            ->first();

            $req_can = ReqCandidato::find($req_cand_id);

            if (is_null($candidato_contratado)) {
            	//Si el candidato no fue contratado se quita del Requerimiento y se agrega lo referente a la transferencia
	            $req_can->estado_candidato 	= config('conf_aplicacion.C_TRANSFERIDO');
	            $req_can->transferido_a_req = $request->req_id;
	            $req_can->save();

	            $campos = [
		            'requerimiento_candidato_id' => $req_cand_id,
		            'usuario_envio'				=> $this->user->id,
		            'proceso'					=> "QUITAR",
		            'esTransferido'				=> true,
		            'observaciones'				=> "El candidato fue retirado del requerimiento " . $req_can->requerimiento_id . " y transferido al requerimiento " . $request->req_id . "."
		        ];

		        //Validar si en el requerimiento hay más usuario para dejar el requerimiento en el mismo estado
				$this->cambiar_estados_quitar($campos, $req_can->requerimiento_id, $req_can->candidato_id);
	        }

			$req_anterior = $req_can->requerimiento_id;
			$arr_proc = "proceso_req_cand_$req_cand_id";
			$procesos_replica = $request->$arr_proc;

			$this->completar_transferencia($req_can->candidato_id, $request->req_id, $req_anterior, $sitio, $es_proceso_sitio, $procesos_replica, $observacion_ingreso, $otra_fuente_id, $tabla_aplicar);
        }

		$success = true;
		array_push($errores_array, "<li>Se han agregado los candidatos con éxito.</li>");

        if ($request->modulo_gestion == 'mineria_datos') {
    		return redirect()->route("admin.gestion_requerimiento", [
    			"req_id" => $request->req_id
    		])
    		->with("success", $success)
    		->with("errores_array", $errores_array)
    		->with("errores_array_req", $errores_array_req);
        }

        return redirect()->route("admin.gestion_requerimiento", [
            "req_id" => $request->req_id
        ])
        ->with("success", $success)
        ->with("errores_array", $errores_array)
        ->with("errores_array_req", $errores_array_req);
	}

    protected function completar_transferencia($user_id, $requerimiento_id, $req_anterior, $sitio, $es_proceso_sitio, $procesos_replica, $observacion_ingreso = 'Ingreso al requerimiento', $otra_fuente_id = 1, $tabla_aplicar = 'fuentes')
    {
        $candidato = DatosBasicos::where("user_id", $user_id)->first();

		$candidato->estado_reclutamiento = config('conf_aplicacion.C_EN_PROCESO_SELECCION');
		$candidato->save();

        //ASOCIA EL CANDIDATO AL REQUERIMIENTO
        $nuevo_candidato_req = new ReqCandidato();

        $nuevo_candidato_req->fill([
            "estado_candidato"	=> config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            "otra_fuente"		=> $otra_fuente_id,
            "requerimiento_id"	=> $requerimiento_id,
            "candidato_id"		=> $user_id
        ]);

		$nuevo_candidato_req->save();

        //CREA EL ESTADO DE INGRESO A REQUERIMIENTO
        $nuevo_proceso = new RegistroProceso();

        $nuevo_proceso->fill([
            'requerimiento_candidato_id' => $nuevo_candidato_req->id,
            'estado'					=> config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            'fecha_inicio'				=> date("Y-m-d H:i:s"),
            'usuario_envio'				=> $this->user->id,
            'requerimiento_id'			=> $requerimiento_id,
            'candidato_id'				=> $user_id,
            'observaciones'				=> $observacion_ingreso,
            'proceso'					=> "ASIGNADO_REQUERIMIENTO",
        ]);

        $nuevo_proceso->save();

		$requerimiento_obj = Requerimiento::find($requerimiento_id);

        //Se elimina de la tabla donde venga
        if ($tabla_aplicar == 'fuentes') {
        	$desde = 'otras fuentes';
        	CandidatosFuentes::where("cedula", $candidato->numero_id)
        		->where("requerimiento_id", $requerimiento_id)
        	->delete();
        } elseif ($tabla_aplicar == 'postulados') {
        	$desde = 'candidatos postulados';
        	$oferta_user = OfertaUser::where("user_id", $candidato->user_id)
	        	->where("requerimiento_id", $requerimiento_id)
	        ->first();

	        if(!is_null($oferta_user)){
	            $oferta_user->estado = 0;
	            $oferta_user->save();
	        }
        } elseif ($tabla_aplicar == 'preperfilados') {
        	$desde = 'candidatos preperfilados';
        	Preperfilados::where('candidato_id', $candidato->user_id)
				->where('req_id', $requerimiento_id)
			->delete();
        } elseif ('reclutamiento_externo') {
        	$desde = 'reclutamiento externo';
        	CandidatoReclutamientoExterno::where('candidato_id', $candidato->user_id)
				->where('req_id', $requerimiento_id)
			->delete();
        } elseif ('reclutamiento_ee') {
			$desde = 'reclutamiento el empleo';
        	# code...
        } elseif ('reclutamiento_ee') {
            $desde = 'mineria de datos';
            # code...
        }

        if ($es_proceso_sitio) {
            $campos_data = [
                'requerimiento_candidato_id'	=> $nuevo_candidato_req->id,
                'usuario_envio'					=> $this->user->id,
                "fecha_inicio"					=> date("Y-m-d H:i:s"),
                'proceso'						=> "ENVIO_APROBAR_CLIENTE",
	            'requerimiento_id'				=> $requerimiento_id,
	            'candidato_id'					=> $user_id,
	            'estado'						=> config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                'observaciones'					=> "Se ha enviado a aprobar por el cliente desde $desde"
            ];

	        //ACTUALIZA REGISTRO A ESTADO SEGUN EL PROCESO
	        $nuevo_candidato_req->update(['estado_candidato' => config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE')]);

	        //REGISTRA PROCESO
	        $nuevo_proceso = new RegistroProceso();
	        $nuevo_proceso->fill($campos_data);
	        $nuevo_proceso->save();

            $fecha_presentacion_candidatos = Carbon::now('America/Bogota');
            $fecha_presentacion_oport_cand = Carbon::parse($requerimiento_obj->fecha_presentacion_oport_cand);

            if ($fecha_presentacion_candidatos->lte($fecha_presentacion_oport_cand)) {
                // entonces es oportuna la presentacion del candidato
                $cand_presentados_puntual                    = $requerimiento_obj->cand_presentados_puntual + 1;
                $requerimiento_obj->cand_presentados_puntual = $cand_presentados_puntual;
                $nuevo_proceso->cand_presentado_puntual   = 1;
            }

            if ($fecha_presentacion_candidatos->gt($fecha_presentacion_oport_cand)) {
                $cand_presentados_no_puntual                    = $requerimiento_obj->cand_presentados_no_puntual + 1;
                $requerimiento_obj->cand_presentados_no_puntual = $cand_presentados_no_puntual;
            }

            //Actualizamos el requerimiento
            $requerimiento_obj->fecha_presentacion_candidatos = $fecha_presentacion_candidatos;
            $requerimiento_obj->save();
            $nuevo_proceso->save();
            $cant_enviar = 0;

            $cuentas = NegocioANS::where("negocio_id",$requerimiento_obj->negocio_id)
            	->where('cargo_especifico_id',$requerimiento_obj->cargo_especifico_id)
            ->get();

            //cuentas
            $cant_enviar = $requerimiento_obj->num_vacantes * 1;
            
            if(!is_null($cuentas)){
                foreach($cuentas as $value){
                    if($value->num_cand_presentar_vac){
                        //$regla =  explode('A',$value->regla);
                        $cant_enviar = $requerimiento_obj->num_vacantes*$value->num_cand_presentar_vac;
                    }else{
                        if($requerimiento_obj->num_vacantes >= 1 && $requerimiento_obj->num_vacantes <= 3){
                            $cant_enviar = $requerimiento_obj->num_vacantes * 2;
                        }else{
                            $cant_enviar = $requerimiento_obj->num_vacantes * 1;
                        }
                    }
                }
            }else{   
                if($requerimiento_obj->num_vacantes >= 1 && $requerimiento_obj->num_vacantes <= 3){
                    $cant_enviar = $requerimiento_obj->num_vacantes * 2;
                }else{
                    $cant_enviar = $requerimiento_obj->num_vacantes * 1;
                }
            }

            $enviados_al_cliente = RegistroProceso::join("requerimiento_cantidato","requerimiento_cantidato.id","=","procesos_candidato_req.requerimiento_candidato_id")
            	->where("procesos_candidato_req.requerimiento_id", $requerimiento_obj->id)
            	->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
            	->where("proceso","ENVIO_APROBAR_CLIENTE")
            ->count();

            if($enviados_al_cliente >= $cant_enviar){
            	$ult_estado_req = $requerimiento_obj->ultimoEstadoRequerimiento()->id;
                if($ult_estado_req != config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE') && $ult_estado_req != config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')) {
                    $nuevoEstado = new EstadosRequerimientos();

                    $nuevoEstado->req_id 		= $requerimiento_obj->id;
                    $nuevoEstado->user_gestion 	= $this->user->id;

                    $nuevoEstado->estado  = config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE');
                    $nuevoEstado->save();
                }
            }
        }

        $req = DB::table("requerimiento_cantidato")->join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        	->join("requerimientos", "requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
        	->join("cargos_especificos", "cargos_especificos.id","=","requerimientos.cargo_especifico_id")
        	->whereRaw(" requerimiento_cantidato.estado_candidato not in ( " . implode(",", $this->estados_no_muestra) . " )  ")
        	->where("requerimiento_cantidato.id", $nuevo_candidato_req->id)
        	->where("datos_basicos.estado_reclutamiento", "!=", config('conf_aplicacion.C_ACTIVO'))
        	->select(
                "requerimiento_cantidato.requerimiento_id",
                "requerimiento_cantidato.id as candidato_req",
                "datos_basicos.*",
                "cargos_especificos.id as cargo",
                "cargos_especificos.firma_digital as firma"
            )
        ->first();

        $cargo_documentos = null;
        if ($sitio->asistente_contratacion == 1 && $req->firma == 1){
            //Si el sitio tiene asistente y el cargo tiene firma digital, se buscan los documentos asociados al cargo categoria 1 y que pueda cargar el candidato
			$cargo_documentos = DocumentosCargo::join('tipos_documentos','tipos_documentos.id','=','cargo_documento.tipo_documento_id')
				->where('cargo_documento.cargo_especifico_id', $req->cargo)
				->where('tipos_documentos.categoria', 1)
                ->where('tipos_documentos.carga_candidato', 1)
				->select(
                    'tipos_documentos.id',
                    'tipos_documentos.descripcion'
                )
			->get();

            if (count($cargo_documentos) == 0) {
                //En caso que el cargo no tenga asociados tipos de documento mostrar listados los tipos de documento con cod_tipo_doc=CC
                $cargo_documentos = TipoDocumento::where('cod_tipo_doc', 'CC')
                    ->where('tipos_documentos.categoria', 1)
                    ->where('tipos_documentos.carga_candidato', 1)
                    ->select(
                        'tipos_documentos.id',
                        'tipos_documentos.descripcion'
                    )
                ->get();
            }
        }

		if(count($procesos_replica) > 0) {
            //Si hay procesos a replicar
            //obtener los procesos viejos del candidato
            $traer_taza = RegistroProceso::where('requerimiento_id', $req_anterior)
            	->where('candidato_id', $user_id)
            	->whereIn('proceso', $procesos_replica)
            ->get();

            if(count($traer_taza) > 0){
            	foreach($traer_taza as $item){
                    if($item->proceso=="ENVIO_PRUEBAS"){
                    	$pruebas = GestionPrueba::join("users", "users.id", "=", "gestion_pruebas.user_id")
                    		->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "gestion_pruebas.id")
                    		->leftjoin("tipos_pruebas", "tipos_pruebas.id", "=", "gestion_pruebas.tipo_prueba_id")
                    		->where("gestion_pruebas.candidato_id", $user_id)
                    		->where("proceso_requerimiento.requerimiento_id", $req_anterior)
                    		->where("proceso_requerimiento.activo", "1")
                    		->select("proceso_requerimiento.*")
                    	->get();

                    	foreach($pruebas as $prueba){
                            $n_p_r= new ProcesoRequerimiento();
                            $n_p_r->tipo_entidad=$prueba->tipo_entidad;
                            $n_p_r->entidad_id=$prueba->entidad_id;
                            $n_p_r->requerimiento_id= $requerimiento_id;
                            $n_p_r->user_id=$prueba->user_id;
                            $n_p_r->save();
                        }

                    } elseif($item->proceso=="ENVIO_ENTREVISTA") {
                    	$entrevistas = EntrevistaCandidatos::join("users", "users.id", "=", "entrevistas_candidatos.user_gestion_id")
                            ->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "entrevistas_candidatos.id")
                            ->join("tipo_fuente", "tipo_fuente.id", "=", "entrevistas_candidatos.fuentes_publicidad_id")
                            ->where("entrevistas_candidatos.candidato_id",$user_id)
                             ->where("proceso_requerimiento.requerimiento_id",$req_anterior)
                            ->where("proceso_requerimiento.activo", "1")
                            ->select("proceso_requerimiento.*")
                        ->get();

                        foreach( $entrevistas as $entrevista){
                            $n_p_r= new ProcesoRequerimiento();
                            $n_p_r->tipo_entidad=$entrevista->tipo_entidad;
                            $n_p_r->entidad_id=$entrevista->entidad_id;
                            $n_p_r->requerimiento_id= $requerimiento_id;
                            $n_p_r->user_id=$entrevista->user_id;
                            $n_p_r->save();
                        }

                    } elseif($item->proceso == "ENVIO_REFERENCIACION") {
                        //EXPERIENCIAS VERIFICADAS
                        $experiencias_verificadas = ExperienciaVerificada::join("experiencias", "experiencias.id", "=", "experiencia_verificada.experiencia_id")
	                        ->leftjoin("motivos_retiros", "motivos_retiros.id", "=", "experiencia_verificada.motivo_retiro_id")
	                        ->join("cargos_genericos", "cargos_genericos.id", "=", "experiencias.cargo_desempenado")
	                        ->where("experiencias.user_id", $user_id)
	                        ->where("experiencia_verificada.req_id", $req_anterior)
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
                        	->get()
                        ->toArray();

                        foreach($experiencias_verificadas as $exp){
                            $n_exp_ver = new ExperienciaVerificada();
                            $n_exp_ver->fill($exp);
                            $n_exp_ver->req_id = $requerimiento_id;
                            $n_exp_ver->save();
                        }

                        //REFERENCIAS PERSONALES VERIFICADAS
                        $ref_per_ver = ReferenciaPersonalVerificada::join("referencias_personales", "referencias_personales.id", "=", "ref_personales_verificada.referencia_personal_id")
                        	->where("ref_personales_verificada.candidato_id", $user_id)
                        	->where("ref_personales_verificada.req_id", $req_anterior)
                        	->get()
                        ->toArray();

                        foreach($ref_per_ver as $ref_per){
                            $n_ref_per = new ReferenciaPersonalVerificada();
                            $n_ref_per->fill($ref_per);
                            $n_ref_per->req_id = $requerimiento_id;
                            $n_ref_per->save();
                        }
                    }elseif($item->proceso == 'ENVIO_REFERENCIA_ESTUDIOS'){
                        //En este caso no se requiere mas nada especial
                    }elseif($item->proceso == 'ENVIO_DOCUMENTOS'){
                        //VALIDA SI EL DOCUMENTOS YA FUE VERIFICADO EN ESTE REQUERIMIENTO
                        $req_gestion = DocumentosVerificados::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "documentos_verificados.id")
                            ->select("proceso_requerimiento.*")
                            ->where("documentos_verificados.candidato_id", $user_id)
                            ->where("documentos_verificados.requerimiento_id", $req_anterior)
                            ->where("proceso_requerimiento.tipo_entidad", "MODULO_DOCUMENTO")
                        ->get();

                        if (count($req_gestion) > 0) {
                            foreach ($req_gestion as $doc) {
                                $relacionProceso = new ProcesoRequerimiento();
                                $relacionProceso->fill([
                                    "tipo_entidad"      => "MODULO_DOCUMENTO",
                                    "entidad_id"        => $doc->entidad_id,
                                    "requerimiento_id"  => $requerimiento_id,
                                    "user_id"           => $doc->user_id,
                                    "resultado"         => $doc->resultado,
                                    "observacion"       => $doc->observacion
                                ]);
                                $relacionProceso->save();
                            }
                        }
                    }

                    //Se coloca en pausa 1 segundo para que la trazabilidad entre procesos quede con la diferencia de 1 segundo (necesario para el modal de estatus)
                    sleep(1);

                    $nuevo_proceso = new RegistroProceso();

                    $nuevo_proceso->fill([
                        'requerimiento_candidato_id' => $nuevo_candidato_req->id,
                        'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        'fecha_inicio'               => date("Y-m-d H:i:s"),
                        'usuario_envio'              => $this->user->id,
                        'requerimiento_id'           => $requerimiento_id,
                        'candidato_id'               => $item->candidato_id,
                        'observaciones'              => $item->observaciones,
                        'proceso'                    => $item->proceso,
                        'apto'                       => $item->apto
                    ]);

                    $nuevo_proceso->save();
                }
            }
        }

        $est_req = EstadosRequerimientos::join("estados", "estados.id", "=", "estados_requerimiento.estado")
        	->where('estados_requerimiento.req_id', $requerimiento_id)
        	->select("estados.id as id")
        	->orderBy("estados_requerimiento.id", "desc")
        ->first();

        if ($est_req->id != config('C_EN_PROCESO_SELECCION') && $est_req->id != config('C_EVALUACION_DEL_CLIENTE') && $est_req->id != config('C_EN_PROCESO_CONTRATACION')) {
	        //EVENTO CAMBIA ESTADO REQUERIMIENTO
	        $obj                   	= new \stdClass();
	        $obj->requerimiento_id 	= $requerimiento_id;
	        $obj->user_id      		= $this->user->id;
	        $obj->estado  			= config('conf_aplicacion.C_EN_PROCESO_SELECCION');

	        Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));
	    }

        //EMAIL A LOS CANDIDATOS ENLAZADOS AL REQUERIMIENTO
        $user_sesion = $this->user;

        $tipo_proceso = $requerimiento_obj->obtenerTipoProceso;
        if($user_sesion->hasAccess("email_candidato_req") && !empty($tipo_proceso) && $tipo_proceso->cod_tipo_proceso != 'PB') {
            //Sino es Proceso Backup se enviara el correo

        	$nombre_empresa = "Desarrollo";
            if (isset($sitio->nombre) && $sitio->nombre != "") {
            	$nombre_empresa = $sitio->nombre;
            }

        	//**************correo de asocian candidato a requerimiento***********************
            $home = route('home');
            $urls = route('home.detalle_oferta', ['oferta_id' => $requerimiento_id]);
            $req_can_id = $nuevo_candidato_req->id;
            $nombres = $candidato->nombres;
            $nombre = ucwords(strtolower($nombres));
                                
            $asunto = "Notificación de proceso de selección";
            
            $emails = $candidato->email;

            $mensaje = "Es un gusto para nosotros que seas parte de este proceso de selección, haz clic en el siguiente botón, donde podrás encontrar la información de la vacante.";
            
            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Notificación de Proceso de Selección"; //Titulo o tema del correo
            
            //Cuerpo con html y comillas dobles para las variables
            $mailBody = '¡Hola, '.$nombre.'!
                <br/><br/>
                Es un gusto para nosotros que seas parte de este proceso de selección, haz clic en el siguiente botón, donde podrás encontrar la información de la vacante.
                <br/><br/>
                <b>¡Éxitos!</b>';

            //Arreglo para el botón
            $mailButton = ['buttonText' => 'OFERTA LABORAL', 'buttonRoute' => $urls];

            $mailUser = $candidato->user_id; //Id del usuario al que se le envía el correo

            if (is_null($cargo_documentos)) {

                $mailAditionalTemplate = [];

            }else{

                $mailAditionalTemplate = ['nameTemplate' => 'proceso_seleccion', 'dataTemplate' => ["cargo_documentos" => $cargo_documentos]];
            }

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser, $mailAditionalTemplate);

            if (route('home') == 'https://listos.t3rsc.co') {
                Mail::send('admin.enviar_email_candidatos_otras_fuentes_listos', [
                    "home" => $home,
                    "cargo_documentos" => $cargo_documentos,
                    "url" => $urls,
                    "req_can_id" => $req_can_id,
                    "nombre" => $nombre
                ], function($message) use ($data, $emails, $asunto, $sitio) {
                    $message->to($emails, '$nombre - T3RS');
                    $message->subject($asunto)

                    ->bcc($sitio->email_replica)
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            }else{
                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($emails, $asunto, $nombre_empresa, $sitio) {

                    $message->to($emails, "$nombre_empresa - T3RS");
                    $message->subject($asunto)
                    ->bcc($sitio->email_replica)
                    ->getHeaders()
                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            }
        }
        return true;
    }

    protected function cambiar_estados_quitar($campos = array(), $requerimiento_id, $candidato_id)
    {
        $campos_data = $campos + [
            'requerimiento_id' => $requerimiento_id,
            'candidato_id'     => $candidato_id,
            'estado'           => config('conf_aplicacion.C_QUITAR'),
            'fecha_inicio'     => date("Y-m-d H:i:s")
        ];

        //REGISTRA PROCESO
        $nuevo_proceso = new RegistroProceso();
        $nuevo_proceso->fill($campos_data);
        $nuevo_proceso->save();

        $candi = ReqCandidato::where("requerimiento_id", $requerimiento_id)
        	->whereRaw("requerimiento_cantidato.estado_candidato not in (" . implode(",", $this->estados_no_muestra) . ")  ")
        ->count();

        $est_req = EstadosRequerimientos::join("estados", "estados.id", "=", "estados_requerimiento.estado")
        	->where('estados_requerimiento.req_id', $requerimiento_id)
        	->select("estados.id as id")
        	->orderBy("estados_requerimiento.id", "desc")
        ->first();

        if($candi == 0 && ($est_req->id == config('C_EN_PROCESO_SELECCION') || $est_req->id == config('C_EVALUACION_DEL_CLIENTE') || $est_req->id == config('C_EN_PROCESO_CONTRATACION'))){

            $nuevoEstado = new EstadosRequerimientos();

            $nuevoEstado->req_id 		= $requerimiento_id;
            $nuevoEstado->user_gestion  = $this->user->id;
            $nuevoEstado->estado  		= config('conf_aplicacion.C_RECLUTAMIENTO');
            $nuevoEstado->save();
        }
    }
}
