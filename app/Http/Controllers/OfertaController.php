<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Clientes;
use App\Models\Negocio;
use App\Models\Ofertas;
use App\Models\OfertaUser;
use App\Models\Perfilamiento;
use App\Models\ReqPreg;
use App\Models\Respuesta;
use App\Models\Pregunta;
use App\Models\PregReqResp;
use App\Models\Requerimiento;
use App\Models\AsistenteCita;
use App\Models\AsistenteCitaAgendamientoCandidato;
use App\Models\TipoReclutamiento;
use App\Models\MotivoPago;
use App\Models\Cluster;
use App\Models\TipoProceso;
use App\Models\Sitio;
use App\Models\ReqCandidato;
use App\Models\DatosBasicos;

use App\Jobs\FuncionesGlobales;
use GuzzleHttp\Client;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use triPostmaster;

class OfertaController extends Controller
{

    public function detalle_oferta_modal(Request $data)
    {

        $detalle_oferta = Requerimiento::find($data->get("id"));

        $ofertaAplicada = OfertaUser::where("user_id", $this->user->id)
            ->where("requerimiento_id", $data->get("id"))
            ->get();

        return view("cv.modal.detalle_oferta", compact("detalle_oferta", "ofertaAplicada"));
    }

    public function aplicar_oferta(Request $data)
    {   
        $aplicar = new OfertaUser();
        $aplicar->fill(
            [
                "user_id"          => $this->user->id,
                "requerimiento_id" => $data->get("id"),
                "fecha_aplicacion" => date("Y-m-d H:i:s"),
                "cedula"           => $this->user->getDatosBasicos()->numero_id,
            ]);

        $aplicar->save();

        //envio de email sobre aplicacion de la oferta
        event(new \App\Events\NotificacionAplicacionVacanteEvent($data->get("id"), $this->user->id));
    }

    public function verificar_oferta(Request $data)
    {

        $id             = $data->get("id");
        $ofertaAplicada = OfertaUser::where("user_id", $this->user->id)
            ->where("requerimiento_id", $data->get("id"))
            ->get();

        return view("cv.modal.verficar_oferta", compact("ofertaAplicada", "id"));
    }

    public function mis_ofertas(Request $data)
    {
        if(empty($this->user->id)){
            return redirect()->route('login', ['scheduling' => 'true']);
        }

        //Configuración instancia
        $instanciaConfiguracion = Sitio::first();

        $menu = DB::table("menu_candidato")->where("estado", 1)
        ->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();

        $user_id = $this->user->id;
        $datosBasicos = Sentinel::getUser()->getDatosBasicos();

        /*$getOfertas = OfertaUser::leftJoin('requerimientos', 'requerimientos.id', '=', 'ofertas_users.requerimiento_id')
        ->join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
        ->where('ofertas_users.user_id', $this->user->id)
        ->select(
            'ofertas_users.*',
            'requerimientos.sitio_trabajo',
            'cargos_especificos.descripcion as nombreCargo'
        )
        ->orderBy('ofertas_users.fecha_aplicacion', 'desc')
        ->get();*/

        $ofertasCandidato = ReqCandidato::join('requerimientos', 'requerimientos.id', '=', 'requerimiento_cantidato.requerimiento_id')
        ->join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
        ->where('requerimiento_cantidato.candidato_id', $this->user->id)
        ->select(
            'requerimientos.id as req_id',
            'requerimientos.sitio_trabajo',
            'requerimientos.created_at as fecha_publicacion',
            'requerimientos.estado_publico',
            'requerimiento_cantidato.candidato_id as user_id',
            'cargos_especificos.descripcion as oferta_cargo'
        )
        ->orderBy('requerimiento_cantidato.created_at', 'DESC')
        ->paginate(6);

        $requerimiento_ofertas = [];

        foreach ($ofertasCandidato as $oferta) {
            array_push($requerimiento_ofertas, $oferta->req_id);
        }

        $ofertas_aplicadas = OfertaUser::join('requerimientos', 'requerimientos.id', '=', 'ofertas_users.requerimiento_id')
        ->join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
        ->whereNotIn('requerimientos.id', $requerimiento_ofertas)
        ->where('ofertas_users.aplica', 1)
        ->where('ofertas_users.user_id', $this->user->id)
        ->select(
            'requerimientos.id as req_id',
            'requerimientos.sitio_trabajo',
            'requerimientos.created_at as fecha_publicacion',
            'requerimientos.estado_publico',
            'cargos_especificos.descripcion as oferta_cargo'
        )
        ->orderBy('ofertas_users.fecha_aplicacion', 'DESC')
        ->paginate(6);

        //Lista de citas para el candidato
        $getCitas = AsistenteCita::join('asistente_citas_agendamiento_candidato', 'asistente_citas_agendamiento_candidato.cita_id', '=', 'asistente_citas.id')
        ->join('requerimientos', 'requerimientos.id', '=', 'asistente_citas.req_id')
        ->join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
        ->where('asistente_citas_agendamiento_candidato.user_id', $this->user->id)
        ->select(
            'asistente_citas.fecha_cita',
            'asistente_citas.id as cita_id',
            'asistente_citas.req_id',
            'asistente_citas_agendamiento_candidato.hora_inicio_cita',
            'asistente_citas_agendamiento_candidato.hora_fin_cita',
            'asistente_citas_agendamiento_candidato.agendada',
            'asistente_citas_agendamiento_candidato.asistio',
            'asistente_citas_agendamiento_candidato.user_id',
            'cargos_especificos.descripcion as cargo'
        )
        ->orderBy('asistente_citas_agendamiento_candidato.created_at', 'DESC')
        ->get();

        return view("cv.ofertas", compact("getCitas", "menu"));
    }

    public function ofertas(Request $data)
    {
        $funcionesGlobales = new FuncionesGlobales();
        $usuariosHijos     = $funcionesGlobales->usuariosHijos($this->user->id);

        $clientes = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
        ->whereIn("users_x_clientes.user_id", $usuariosHijos)
        ->orderBy("clientes.nombre", "ASC")
        ->pluck("clientes.nombre", "clientes.id")
        ->toArray();

        $tipoProcesos = ["" => Seleccionar] + TipoProceso::where('active', 1)
        ->pluck("descripcion", "id")
        ->toArray();

        //$clientes = ["" => "Seleccionar"] + Clientes::pluck("nombre", "id")->toArray();

        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){


            $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->join("users", "users.id", "=", "requerimientos.solicitado_por")
            //->whereIn("users.id", $usuariosHijos)
            ->where(function ($sql) use ($data) {
                if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }
                if ($data->has("numero_req") && $data->get("numero_req") != "") {
                    $sql->where("requerimientos.id", $data->get("numero_req"));
                }
                if ($data->has("fecha_inicio") && $data->get("fecha_inicio") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.created_at,'dd/mm/yyyy')) = '" . $data->get("fecha_inicio") . "'");
                }
                if ($data->has("fecha_fin") && $data->get("fecha_fin") != "") {
                    $sql->whereRaw("to_date(to_char(requerimientos.fecha_ingreso,'dd/mm/yyyy')) ='" . $data->get("fecha_fin") . "'");
                }
            })
            ->select(
                "cargos_especificos.descripcion as cargo",
                "cargos_especificos.id as cargo_id",
                "requerimientos.id",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_terminacion",
                "requerimientos.fecha_ingreso",
                "requerimientos.dias_gestion",
                "requerimientos.estado_publico",
                "tipo_proceso.descripcion as tipo_proceso_desc",
                "negocio.num_negocio",
                "clientes.nombre as nombre_cliente",
                "users.name as nombre_usuario",
                "requerimientos.id as req_id",
                "requerimientos.solicitud_id"
            )
            ->orderBy("requerimientos.id", "desc")
            ->paginate(10);
        }else{
            $requerimientos = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->join("users", "users.id", "=", "requerimientos.solicitado_por")
            ->join('estados_requerimiento', 'estados_requerimiento.req_id', '=', 'requerimientos.id')
            ->whereIn("clientes.id", $this->clientes_user)
            ->tipoProceso($data)
            ->where(function ($sql) use ($data) {
                if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }

                if ($data->has("codigo") && $data->get("codigo") != "") {
                    $sql->where("requerimientos.id", $data->get("codigo"));
                }

                if ($data->has("publicada") && $data->get("publicada") != "") {
                    if ($data->get("publicada") == 1) {
                        //SI
                        $sql->whereRaw("requerimientos.descripcion_oferta IS NOT NULL ");
                    }
                    if ($data->get("publicada") == 2) {
                        //NO
                        $sql->whereRaw("requerimientos.descripcion_oferta IS NULL ");
                    }
                }
            })
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->select(
                "cargos_especificos.descripcion as cargo",
                "cargos_especificos.id as cargo_id",
                "estados_requerimiento.estado as estado_requerimiento",
                "requerimientos.id",
                "requerimientos.num_vacantes",
                "requerimientos.created_at",
                "requerimientos.fecha_terminacion",
                "requerimientos.dias_gestion",
                "requerimientos.descripcion_oferta",
                "requerimientos.estado_publico",
                "tipo_proceso.descripcion as tipo_proceso_desc",
                "negocio.num_negocio",
                "clientes.nombre as nombre_cliente",
                "users.name as nombre_usuario", "requerimientos.id as req_id"
            )
            ->orderBy("requerimientos.id", "desc")
            ->take(10)
            ->get();
            //->paginate(10);
        }

        return view("admin.ofertas.index", compact("clientes", "requerimientos", "tipoProcesos"));
    }

    public function editar_oferta($oferta_id, $cargo_id)
    {
        $user_sesion = $this->user;

        $preguntas_oferta = Pregunta::join('tipo_pregunta','tipo_pregunta.id','=','preguntas.tipo_id')
        ->select(
            'preguntas.id as pregunta_id',
            'preguntas.*',

            'tipo_pregunta.descripcion as tipo_pregunta_descripcion'
        )
        ->where('preguntas.requerimiento_id', $oferta_id)
        ->orWhere('preguntas.cargo_especifico_id', $cargo_id)
        ->groupBy('preguntas.descripcion')
        ->get();

        $preguntas_req = PregReqResp::join('preguntas', 'preguntas.id', '=', 'preg_req_resp.preg_id')
        ->join('users', 'users.id', '=', 'preg_req_resp.user_id')
        ->where('preg_req_resp.req_id', $oferta_id)
        //->where('preg_req_resp.cargo_especifico_id', $cargo_id)
        ->orderBy('punt_can', 'desc')
        ->groupBy('preg_req_resp.user_id')
        ->select(
            'preg_req_resp.*',
            'users.name as nombre_usuario',
            'users.id as id',
            DB::raw('SUM(preg_req_resp.puntuacion) as punt_can')
        )
        ->get();

        $mensaje_koma = "Si no cumples con el perfil, te invitamos a compartir la oferta con tus conocidos.";
        $mensaje = "En esta oferta de empleo buscamos personas que se perfilen en el cargo de “CARGO DEL REQUERIMIENTO”,
        *
        *

 

        Nos gustaría acompañarte en tu camino laboral, por lo cual te invitamos a que:

        *

        *

        - Completes tu hoja de vida.

        - Grabes un video perfil para que mejores las probabilidades de ser seleccionado en el cargo.

        - Apliques a las vacantes y contestes las preguntas de preselección que nuestro equipo de selección ha preparado para ti !

        Éxitos en tu aplicación y esperamos que este cargo aporte en tu crecimiento profesional!  

        ";

        $mensaje_listos = "Atención! Buscamos personas con mucha actitud y ganas de trabajar para desempeñarse en el cargo de ________, nuestro futuro talento debe contar con ___ de experiencia en el cargo de _______.

        Requisitos:

        *

        *

        *

        *

        *

        Competencias requeridas para el cargo:

        *

        *

        *

         

        Si tu reacción fue ¡WOOWW! Y cumples con el perfil, esta vacante es para ti, ¿Qué esperas para postularte?. ";        
        
        $requerimiento = Requerimiento::join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
        ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
        ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
        ->select(
            "cargos_especificos.id as cargo_id",
            "requerimientos.*",
            "motivo_requerimiento.descripcion as motivo_req",
            "cargos_genericos.descripcion as nombre_cargo",
            "cargos_especificos.descripcion as cargo",
            "requerimientos.descripcion_oferta",
            "tipo_proceso.descripcion as tipo_proceso",
            "tipo_proceso.reclutamiento_puro"
        )
        ->find($oferta_id);

        $negocio = Negocio::find($requerimiento->negocio_id);
        $cliente = Clientes::find($negocio->cliente_id);

        $tipo_reclutamiento = ["" => "- Seleccionar -"] + TipoReclutamiento::pluck("descripcion", "id")->toArray();
        $motivo_pago = ["" => "- Seleccionar -"] + MotivoPago::pluck("descripcion", "id")->toArray();
        $clusters = ["" => "- Seleccionar -"] + Cluster::pluck("descripcion", "id")->toArray();

        $imagenes_cargo=DB::table('cargos_genericos_imagenes')->where("cargo_generico_id",$requerimiento->cargo_generico_id)->get();

        return view("admin.ofertas.editar_oferta", compact(
            "mensaje_koma",
            "mensaje_listos",
            "preguntas_req",
            "preguntas_oferta",
            "user_sesion",
            "requerimiento",
            "cliente",
            "negocio",
            "mensaje",
            "tipo_reclutamiento",
            "motivo_pago",
            "clusters",
            "imagenes_cargo"
        ));
    }

    public function actualizar_oferta(Request $data)
    {

        //Validar si se creo el número de preguntas definido para la oferta
        $count_preguntas_definidas = Requerimiento::where('id', $data->req_id)->pluck('preguntas_oferta');


        if($count_preguntas_definidas != "" || $count_preguntas_definidas != null){
            $count_preguntas = Pregunta::where('filtro', null)->orWhere('filtro', 0)->whereNotIn('tipo_id', [3, 4])->count();

            if($count_preguntas < $count_preguntas_definidas[0]){
                return redirect()->back()->with("preguntas_oferta", "No has creado la cantidad de preguntas definidas para esta oferta.");
            }

            //return redirect()->back()->with("preguntas_oferta", "Debes definir la cantidad de preguntas para esta oferta.");
        }

        //Valida si hicieron uso del checkbox
        if ($data->get('estado_publico')) {
            $estado_publico = 1;
        } else {
            $estado_publico = 0;
        }

        $req = Requerimiento::find($data->get("req_id"));
        if($data->has('imagen')){
            $req->imagen_oferta=$data->get('imagen');
        }
        

        if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co"){

            $ofertaReq = [
                "descripcion_oferta"        => $data->descripcion_oferta,
                "estado_publico"            => $estado_publico,
                "funciones"                 => $data->funciones,
                "formacion_academica"       => $data->formacion_academica,
                "experiencia_laboral"       => $data->experiencia_laboral,
                "conocimientos_especificos" => $data->conocimientos_especificos,
                "fecha_tope_publicacion"=>($data->get("fecha_tope_publicacion")!="")? $data->get("fecha_tope_publicacion"):null
            ];

            if ($data->get("fecha_publicacion") == "") {
                $ofertaReq["fecha_publicacion"] = date("Y-m-d H:i:s");
            }

            $req->fill($ofertaReq);
            $req->save();
        }else{

            $ofertaReq = [
                "descripcion_oferta" => $data->descripcion_oferta,
                "estado_publico"     => $estado_publico,
                "fecha_tope_publicacion"=>($data->get("fecha_tope_publicacion")!="")? $data->get("fecha_tope_publicacion"):null
            ];

            if ($data->get("fecha_publicacion") == "") {
                $ofertaReq["fecha_publicacion"] = date("Y-m-d H:i:s");
            }
            $requerimiento = Requerimiento::join("tipo_proceso","requerimientos.tipo_proceso_id","=","tipo_proceso.id")
                            ->select("tipo_proceso.reclutamiento_puro")
                            ->find($data->get("req_id"));
            if ($requerimiento->reclutamiento_puro) {
                
                $ofertaReq["tipo_reclutamiento"] = $data->get("tipo_reclutamiento");
                $ofertaReq["pago_por"] = $data->get("pago_por");
                $ofertaReq["precio_hv"] = $data->get("precio_hv");
                $ofertaReq["cantidad_hv"] = $data->get("cantidad_hv");
                $ofertaReq["fecha_cierre_externo"] =date("Y-m-d",strtotime($data->get("fecha_cierre_externo")));
                $ofertaReq["hora_cierre_externo"] = $data->get("hora_cierre_externo");
                $ofertaReq["cluster"] = $data->get("cluster");

            }

            $req->fill($ofertaReq);
            $req->save();
        }

        try {
            //Despublicar - Actualizar en TCN Oferta
            if (route("home") == "http://talentum.t3rsc.co" || route("home") == "https://talentum.t3rsc.co" ||
                route("home") == "http://pta.t3rsc.co" || route("home") == "https://pta.t3rsc.co" ||
                route("home") == "http://temporizar.t3rsc.co" || route("home") == "https://temporizar.t3rsc.co" ||
                route("home") == "http://soluciones.t3rsc.co" || route("home") == "https://soluciones.t3rsc.co" ||
                route("home") == "http://nases.t3rsc.co" || route("home") == "https://nases.t3rsc.co" ||
                route("home") == "http://listos.t3rsc.co" || route("home") == "https://listos.t3rsc.co" ||
                route("home") == "http://vym.t3rsc.co" || route("home") == "https://vym.t3rsc.co" ||
                route("home") == "http://gigha.t3rsc.co" || route("home") == "https://gigha.t3rsc.co") {
                
                //Login en TCN
                $tcn = new Client([
                    'base_uri' => "https://www.trabajaconnosotros.com.co/api/login_empresas",
                    'headers' => [
                        'Accept' => 'application/json'
                    ],
                    'form_params' => [
                        'email'    => env('EMAIL_TCN'),
                        'password' => env('PASS_TCN')
                    ]
                ]);

                $companyLogged = $tcn->request('POST');
                $convert =  json_decode( $companyLogged->getBody()->getContents() );

                $tokenTcn = $convert->token;

                //Actualizar descripción
                $tcnUpdateDescription = new Client([
                    'base_uri' => "https://www.trabajaconnosotros.com.co/api/actualizar_ofertas_desde_instancias",
                    'headers' => [
                        'Authorization' => 'Bearer '.$tokenTcn,
                        'Accept'        => 'application/json'
                    ],
                    'form_params' => [
                        'oferta_id_instancia' => $data->get("req_id"),
                        'descripcion_oferta'  => $data->descripcion_oferta
                    ]
                ]);

                $companyUdateDescription = $tcnUpdateDescription->request('POST');
                $responseOfferUpdate =  json_decode( $companyUdateDescription->getBody()->getContents() );

                //Despublicar
                if ($estado_publico == 0) {
                    $tcnUnpublish = new Client([
                        'base_uri' => "https://www.trabajaconnosotros.com.co/api/despublicar_oferta_desde_instancias",
                        'headers' => [
                            'Authorization' => 'Bearer '.$tokenTcn,
                            'Accept'        => 'application/json'
                        ],
                        'form_params' => [
                            'oferta_id_instancia' => $data->get("req_id"),
                        ]
                    ]);

                    $companyUnpublished = $tcnUnpublish->request('POST');
                    $responseOffer =  json_decode( $companyUnpublished->getBody()->getContents() );
                }

            }
        } catch (\Throwable $t) {
            return redirect()->route("admin.ofertas")->with("mensaje_success", "Se ha actualizado la oferta");
        }

        return redirect()->route("admin.ofertas")->with("mensaje_success", "Se ha actualizado la oferta");
    }

    public function enviar_nuevas_ofertas_candidatos()
    {

        /* BUSCA OFERTAS NUEVAS DIARIAS Y SE ENVIA A LOS USUARIOS SEGUN SU CARGO  */
        $requerimiento_nuevos = Perfilamiento::join("datos_basicos", "datos_basicos.user_id", "=", "perfilamiento.user_id")
            ->join("requerimientos", "requerimientos.cargo_generico_id", "=", "perfilamiento.cargo_generico_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "perfilamiento.cargo_generico_id")
            ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.id")
            ->join("clientes", "negocio.cliente_id", "=", "clientes.id")
            ->join("users", "users.id", "=", "datos_basicos.user_id")
            ->select("users.email as email_oferta", "clientes.nombre as nombre_cliente", "requerimientos.id as req_id", "datos_basicos.id as candidato_id", "datos_basicos.nombres", "datos_basicos.primer_apellido", "datos_basicos.segundo_apellido", "cargos_genericos.descripcion", "cargos_especificos.descripcion as cargo_especifico")
            ->where("requerimientos.descripcion_oferta", "!=", "''")
            ->whereRaw("requerimientos.id not in (select req_id from estados_requerimiento where estado = " . config("conf_aplicacion.C_TERMINADO") . ")")
            ->groupBy("datos_basicos.id", "cargos_genericos.id")->get();

        $req_candidatos = [];

        foreach ($requerimiento_nuevos as $req) {
            if (array_key_exists($req->candidato_id, $req_candidatos)) {
                array_push($req_candidatos[$req->candidato_id]["ofertas"], $req);
            } else {
                $req_candidatos[$req->candidato_id]["nombre"]  = $req->nombres . " " . $req->primer_apellido . " " . $req->segundo_apellido;
                $req_candidatos[$req->candidato_id]["email"]   = $req->email_oferta;
                $req_candidatos[$req->candidato_id]["ofertas"] = [];
                array_push($req_candidatos[$req->candidato_id]["ofertas"], $req);
            }
        }

        foreach($req_candidatos as $key => $value) {
            Mail::send("admin.email_ofertas", ['data' => $value], function ($message) use ($value) {
                $message->to($value["email"], $value["nombre"])->subject('Nuevas Ofertas de Trabajo!')
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }
    }

    public function guardar_cantidad_preguntas(Request $request)
    {
        $requerimiento = Requerimiento::find($request->req_id);

        $requerimiento->preguntas_oferta = $request->cantidad;
        $requerimiento->save();

        return response()->json([
            "success" => true
        ]);
    }

    public function guardar_porcentaje_preguntas(Request $request)
    {
        $preguntas_id = $request->pregunta_id;
        $porcentajes = $request->peso_porcentual_pregunta;

        foreach ($preguntas_id as $index => $pregunta_id) {
            $pregunta = Pregunta::where('id', $pregunta_id)->first();

            $pregunta->peso_porcentual = $porcentajes[$index];
            $pregunta->save();
        }

        return response()->json([
            "success" => true
        ]);
    }

    public function addImgView(Request $request){
        $cargo_id=$request->get("cargo_id");
        return view("admin.ofertas.modal.add-img",compact("cargo_id"));
    }
    public function addImgSave(Request $request){
        //aqui va el guardado de la imagen

        
            //Guardamos el archivo en un directorio
            if ($request->hasFile('imagen_oferta')) {
                $imagen_oferta     = $request->file("imagen_oferta");
                $extencion      = $imagen_oferta->getClientOriginalExtension();

                if ($extencion == 'png' || $extencion == 'jpg' || $extencion == 'jpeg') {


                    $imagen_id = DB::table('cargos_genericos_imagenes')->insertGetId([
                        "cargo_generico_id"=>$request->get("cargo_id")

                    ]);
                    

                    $name_documento = $imagen_id.".". $extencion;
                    DB::table('cargos_genericos_imagenes')->where("id",$imagen_id)->update(["nombre"=>$name_documento]);
                    Storage::disk('public')->put('imagenes_cargos/'.$name_documento,\File::get($imagen_oferta));

                    
                    
                
                    $mensaje = "Se cargo correctamente la imagen.";

                    return response()->json(["success" => true, "mensaje"=>$mensaje,"nombre_imagen"=>$name_documento,"id_imagen"=>$imagen_id]);
                }else{

                    /*$archivos = Archivo_hv::where("user_id", $this->user->id)->get();

                    $mensaje = "Problemas al momento de guardar, intentar nuevamente.";
                    return response()->json(["success" => false, "view" => view("cv.modal.cargar_hv", compact("mensaje", "archivos"))->render()]);*/
                }



            }
            
       
    
    }
}
