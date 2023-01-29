<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\DatosBasicos;
use App\Models\EvaluacionSstConfiguracion;
use App\Models\EvaluacionSstOpciones;
use App\Models\EvaluacionSstPreguntas;
use App\Models\EvaluacionSstRespuestaUser;
use App\Models\RegistroProceso;
use App\Models\ReqCandidato;
use App\Models\Requerimiento;
use App\Models\Sitio;
use App\Models\User;

use Storage;

//Helper
use triPostmaster;

class EvaluacionSstController extends Controller
{
    protected $letras = [];

    public function __construct() {
        parent::__construct();

        $this->letras = [
            0 => "a.",
            1 => "b.",
            2 => "c.",
            3 => "d.",
            4 => "e.",
            5 => "f.",
            6 => "g.",
            7 => "h.",
            8 => "i.",
            9 => "j.",
            10 => "k.",
            11 => "l.",
            12 => "m.",
            13 => "n.",
            14 => "o.",
            15 => "p.",
            16 => "q.",
            17 => "r.",
            18 => "s.",
            19 => "t."
        ];
    }

    public function realizar_evaluacion_sst($req_id) {
        if(empty($this->user->id)) {
            session(["url_deseada_redireccion_candidato" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login');
        }

        $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
            ->where("procesos_candidato_req.requerimiento_id", $req_id)
            ->where("procesos_candidato_req.candidato_id", $this->user->id)
            ->whereIn("procesos_candidato_req.estado", [7, 8])
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_SST"])
            ->whereRaw("(procesos_candidato_req.apto is null or  procesos_candidato_req.apto = '')")
            ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            ->select(
                "datos_basicos.*",
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "requerimiento_cantidato.*",
                "requerimiento_cantidato.id as req_can_id"
            )
        ->first();

        if($candidatos == null) {
            return redirect()->route('dashboard');
        }

        $registro = RegistroProceso::where('proceso', "ENVIO_SST")
            ->where('requerimiento_candidato_id', $candidatos->req_can_id)
            ->whereNotNull('apto')
        ->first();

        if ($registro != null) {
            return redirect()->route('dashboard')->with('no_prueba', 'Ya has respondido la evaluación.');;
        }

        $configuracion_sst = EvaluacionSstConfiguracion::first();

        $material_consulta = DB::table("evaluacion_sst_material_consulta")->where('active', 1)->get();

        //$sst_questions = EvaluacionSstPreguntas::where('active', 1)->orderByRaw('RAND()')->get();
        $sst_questions = EvaluacionSstPreguntas::where('active', 1)->orderBy('id')->get();

        $letras = $this->letras;

        $logo = '';

        $sitio = Sitio::first();
        if ($sitio->multiple_empresa_contrato) {
            $empresa_logo = Requerimiento::join('empresa_logos', 'empresa_logos.id', '=', 'requerimientos.empresa_contrata')
                ->select('empresa_logos.logo', 'empresa_logos.id')
            ->find($req_id);

            if ($empresa_logo != null && $empresa_logo->logo != null && $empresa_logo->logo != '') {
                $logo = $empresa_logo->logo;
            }
        }

        return view("home.evaluacion_sst.realizar_evaluacion_sst", compact('candidatos', 'configuracion_sst', 'sst_questions', 'letras', 'logo', 'material_consulta'));
    }

    public function guardar_evaluacion_sst(Request $data) {
        $candidato_req_id = $data->candidato_req;

        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $candidato_req_id)
        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato","requerimiento_cantidato.requerimiento_id")
        ->first();

        $configuracion_sst = EvaluacionSstConfiguracion::first();

        $preguntasIds = EvaluacionSstPreguntas::where('active', 1)->select('id')->get()->pluck('id')->toArray();
        //Se obtienen todas las opciones de todas las preguntas, que servira para verificar si respondio correctamente.
        $opcionesPrueba = EvaluacionSstOpciones::whereIn('id_pregunta', $preguntasIds)->get();
        $preguntasActivas = EvaluacionSstPreguntas::where('active', 1)->get();
        //$preguntasSinPuntuacion = $preguntasActivas->where('lleva_puntuacion', 'NO');
        $correctas = 0;

        $preg_resp = $data->except('req_id', 'userId', '_token', 'candidato_req');
        foreach ($preg_resp as $preg_id_text => $opcion) {
            $pregunta_id = str_replace('preg_id_', '', $preg_id_text);

            $pregunta = $preguntasActivas->find($pregunta_id);
            if ($pregunta != null && $pregunta->lleva_puntuacion == 'NO') {
                //Las preguntas sin puntuacion se contaran siempre como correctas, para poder hacer el calculo del porcentaje total de respuestas correctas sobre el total de preguntas.
                $correctas++;
                continue;
            }
            if ($pregunta != null && $pregunta->tipo == 'seleccion_simple') {
                $verificar = $opcionesPrueba->find($opcion);
                //Se verifica si la seleccion del usuario era la respuesta correcta
                if ($verificar->correcta) {
                    $correctas++;
                }
            } else if ($pregunta != null && $pregunta->tipo == 'seleccion_multiple') {
                $es_correcta = 0;
                $cant_op_correctas = $opcionesPrueba->where('id_pregunta', $pregunta_id)->where('correcta', '1')->count();

                foreach ($opcion as $op) {
                    $verificar = $opcionesPrueba->find($op);

                    //Se verifica si la seleccion del usuario era la respuesta correcta
                    if ($verificar->correcta) {
                        $es_correcta++;
                    }
                }
                if ($es_correcta === $cant_op_correctas) {
                    $correctas++;
                }
            }
        }

        $attemps = 0;
        $total_preguntas_activas = count($preguntasActivas);
        $respuesta_user = EvaluacionSstRespuestaUser::where('requerimiento_candidato_id', $candidato_req_id)->first();

        if ($respuesta_user == null) {
            $respuesta_user = new EvaluacionSstRespuestaUser();
            $respuesta_user->requerimiento_candidato_id = $candidato_req_id;
        } else {
            $attemps = $respuesta_user->attemps;
        }

        $attemps++;
        $puntuacion = 0;
        if ($total_preguntas_activas > 0) {
            $puntuacion = round($correctas * 100 / $total_preguntas_activas);
        }

        $campos = [
            'req_id'                => $candidato->requerimiento_id,
            'candidato_id'          => $candidato->user_id,
            'respuestas_correctas'  => $correctas,
            'total_preguntas'       => count($preguntasActivas),
            'puntuacion'            => $puntuacion,
            'fecha_respuesta'       => date('Y-m-d'),
            'respuestas'            => json_encode($preg_resp),
            'attemps'               => $attemps
        ];

        $respuesta_user->fill($campos);
        $respuesta_user->save();

        if($puntuacion < $configuracion_sst->minimo_aprobacion) {
            $mensaje = "Desafortunadamente obtuviste una calificación del (".$puntuacion."%) y no pasaste la evaluación, pues la calificación mínima es del ". $configuracion_sst->minimo_aprobacion ."%! \n Por favor haz clic en “Reintentar Evaluación” para realizarla de nuevo. Muchos éxitos!";
            $paso = 0;
        }else {
            $ref_id = RegistroProceso::where("requerimiento_candidato_id", $candidato_req_id)
                ->where('proceso',"ENVIO_SST")
                ->orderBy('id',"DESC")
            ->first();

            $mensaje = "Has obtenido una puntuación de $puntuacion%, a continuación por favor realiza la firma de tu evaluación.";
            $paso = 1;
        }

        return response()->json(["success" => true, "paso" => $paso, 'mensaje' => $mensaje, "id" => $respuesta_user->id]);
    }

    public function guardar_firma_sst(Request $data) {
        $resultados = EvaluacionSstRespuestaUser::findOrFail($data->id_evaluacion);
        $resultados->firma = $data->firma;
        $resultados->save();

        $ruta = route('pdf_evaluacion_sst', $resultados->requerimiento_candidato_id);

        return response()->json(["success" => true, "ruta" => $ruta]);
    }

    public function guardar_fotos_sst(Request $data) {
        $evaluacion_id = $data->evaluacionId;
        $respuesta_user = EvaluacionSstRespuestaUser::join('datos_basicos', 'datos_basicos.user_id', '=', 'evaluacion_sst_respuestas_user.candidato_id')
            ->leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            ->select(
                'datos_basicos.*', 
                'evaluacion_sst_respuestas_user.*', 
                'evaluacion_sst_respuestas_user.id as id_eva', 
                "tipo_identificacion.descripcion as tipo_id_desc"
            )
        ->find($evaluacion_id);

        $induccionImagenes = json_decode($data->induccionImagenes, true);

        $nombres_fotos = '';

        //Borrar primera foto del arreglo, porque no tiene información
        //unset($induccionImagenes[0]);

        $total_imagenes = count($induccionImagenes);

        $user_id = $respuesta_user->candidato_id;
        $req_id = $respuesta_user->req_id;

        $ruta_fotos = 'recursos_evaluacion_induccion/evaluacion_induccion_'.$user_id.'_'.$req_id.'_'.$evaluacion_id;

        for($i = 0; $i < $total_imagenes; $i++) {
            //Se verifica que la imagen tenga datos
            if ($induccionImagenes[$i]['picture'] != null && $induccionImagenes[$i]['picture'] != '') {
                //Convertir base64 a PNG
                $image_parts = explode(";base64,", $induccionImagenes[$i]['picture']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fotoNombre = "candidato-foto-$i-$user_id-$req_id-$evaluacion_id.png";

                if ($i == $total_imagenes-1) {
                    $nombres_fotos = $nombres_fotos . $fotoNombre;
                } else {
                    $nombres_fotos = $nombres_fotos . "$fotoNombre,";
                }

                Storage::disk('public')
                    ->put("$ruta_fotos/$fotoNombre", $image_base64);
            }
        }

        $respuesta_user->fotos = $nombres_fotos;
        $respuesta_user->save();

        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_can_id", "requerimiento_cantidato.requerimiento_id")
        ->find($respuesta_user->requerimiento_candidato_id);

        $ref_id = RegistroProceso::where("requerimiento_candidato_id", $respuesta_user->requerimiento_candidato_id)
            ->where('proceso', "ENVIO_SST")
            ->orderBy('id', "DESC")
        ->first();

        $sitio = Sitio::first();
        $nombre_sitio = '';
        if ($sitio->nombre != null && $sitio->nombre != '') {
            $nombre_sitio = $sitio->nombre;
        }

        $preguntasAll = EvaluacionSstPreguntas::get();

        $configuracion_sst = EvaluacionSstConfiguracion::first();

        $letras = $this->letras;

        $logo = '';

        if ($sitio->multiple_empresa_contrato) {
            $empresa_logo = Requerimiento::join('empresa_logos', 'empresa_logos.id', '=', 'requerimientos.empresa_contrata')
                ->select('empresa_logos.logo', 'empresa_logos.id')
            ->find($respuesta_user->req_id);

            if ($empresa_logo != null && $empresa_logo->logo != null && $empresa_logo->logo != '') {
                $logo = $empresa_logo->logo;
            }
        }

        $view = \View::make("home.evaluacion_sst.pdf_evaluacion_sst", compact('respuesta_user', 'preguntasAll', 'configuracion_sst', 'letras', 'logo'))->render();
        $pdf  = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper("A4");

        $output = $pdf->output();
        $nombre_documento = 'evaluacion_sst_'.$this->user->id.'_'.$respuesta_user->req_id.'.pdf';

        Storage::disk('public')->put('recursos_evaluacion_sst/'.$nombre_documento, $output);

        $ref_id->apto = 1;
        $ref_id->fecha_fin = date('Y-m-d');
        $ref_id->usuario_terminacion = $this->user->id;
        $ref_id->save();

        $envio = User::find($ref_id->usuario_envio);

        $emails = User::join('users_x_clientes', 'users_x_clientes.user_id', '=', 'users.id')
            ->join('role_users', 'role_users.user_id', '=', 'users.id')
            ->join('clientes', 'clientes.id', '=', 'users_x_clientes.cliente_id')
            ->join('negocio', 'negocio.cliente_id', '=', 'clientes.id')
            ->join('requerimientos', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->where('requerimientos.id', $respuesta_user->req_id)
            ->whereIn("role_users.role_id", [7, 19, 21])
            ->whereNotIn('users.id', [$ref_id->usuario_envio])
            ->select("users.email")
            ->groupBy("users.id")
        ->get();

        if ($candidato->primer_nombre != null) {
            $nombres = $candidato->primer_nombre . ($candidato->segundo_nombre != null && $candidato->segundo_nombre != '' ? " $candidato->segundo_nombre" : '');
        } else {
            $nombres = $candidato->nombres;
        }

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Notificación de finalización de evaluación inducción en REQ No. {$respuesta_user->req_id}"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "
            Buen dia,
            <br/>
            El candidato <b>{$nombres} {$candidato->primer_apellido} {$candidato->segundo_apellido}</b> en el req <b>No. {$respuesta_user->req_id}</b>, ha finalizado su evaluación inducción.";

        //Arreglo para el botón
        $mailButton = [];

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($envio, $nombre_sitio) {
            $message->to([$envio->email], $nombre_sitio)
            ->subject("Finalización Evaluación Inducción")
            ->getHeaders()
            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        foreach($emails as $key => $value) {
            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($value, $nombre_sitio) {
                $message->to([$value->email], $nombre_sitio)
                ->subject("Finalización Evaluación Inducción")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        }

        return response()->json(["success" => true]);
    }

    //pdf evaluacionsst
    public function pdf_evaluacion_sst($req_cand_id)
    {  
        $respuesta_user = EvaluacionSstRespuestaUser::join('datos_basicos', 'datos_basicos.user_id', '=', 'evaluacion_sst_respuestas_user.candidato_id')
            ->leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            ->where('evaluacion_sst_respuestas_user.requerimiento_candidato_id', $req_cand_id)
            ->select(
                'datos_basicos.*', 
                'evaluacion_sst_respuestas_user.*', 
                'evaluacion_sst_respuestas_user.id as id_eva', 
                "tipo_identificacion.descripcion as tipo_id_desc"
            )
        ->first();

        if (is_null($respuesta_user)) {
            return redirect()->route('notfound');
        }

        if ($this->user->id != $respuesta_user->candidato_id) {
            return redirect()->route('notfound');
        }

        $preguntasAll = EvaluacionSstPreguntas::get();

        $configuracion_sst = EvaluacionSstConfiguracion::first();

        $letras = $this->letras;

        $logo = '';

        $sitio = Sitio::first();
        if ($sitio->multiple_empresa_contrato) {
            $empresa_logo = Requerimiento::join('empresa_logos', 'empresa_logos.id', '=', 'requerimientos.empresa_contrata')
                ->select('empresa_logos.logo', 'empresa_logos.id')
            ->find($respuesta_user->req_id);

            if ($empresa_logo != null && $empresa_logo->logo != null && $empresa_logo->logo != '') {
                $logo = $empresa_logo->logo;
            }
        }

        //return view("home.evaluacion_sst.pdf_evaluacion_sst", compact('respuesta_user', 'preguntasAll', 'configuracion_sst', 'letras', 'logo'));
        $view = \View::make("home.evaluacion_sst.pdf_evaluacion_sst", compact('respuesta_user', 'preguntasAll', 'configuracion_sst', 'letras', 'logo'))->render();
        $pdf  = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        $pdf->setPaper("A4");

        return $pdf->stream('evaluacion_sst.pdf');
    }
}
