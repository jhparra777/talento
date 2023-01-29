<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\DatosBasicos;
use App\Models\RegistroProceso;
use App\Models\ReqCandidato;
use App\Models\Requerimiento;
use App\Models\RetroalimentacionVideo;
use DB;
//Helper
use triPostmaster;

class RetroalimentacionVideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->req_id != null || $request->cedula != null) {
            $candidatos = DatosBasicos::join('procesos_candidato_req', 'datos_basicos.user_id', '=', 'procesos_candidato_req.candidato_id')
                ->where('proceso', 'RETROALIMENTACION')
                ->whereRaw("(procesos_candidato_req.apto is null or procesos_candidato_req.apto = 3 )")
                ->where(function ($sql) use ($request) {
                    if ($request->req_id != "" && $request->req_id != null) {
                        $sql->where("procesos_candidato_req.requerimiento_id", $request->req_id);
                    }

                    if ($request->cedula != "" && $request->cedula != null) {
                        $sql->where('datos_basicos.numero_id', $request->cedula);
                    }
                })
                ->select(
                    'datos_basicos.numero_id',
                    'datos_basicos.nombres',
                    'datos_basicos.primer_apellido',
                    'datos_basicos.segundo_apellido',
                    'procesos_candidato_req.requerimiento_id',
                    'procesos_candidato_req.requerimiento_candidato_id as ref_id',
                    'procesos_candidato_req.proceso')
                ->orderBy('procesos_candidato_req.id', 'desc')
                ->groupBy('procesos_candidato_req.requerimiento_candidato_id')
            ->paginate(10);
        } else {
            $candidatos = DatosBasicos::join('procesos_candidato_req', 'datos_basicos.user_id', '=', 'procesos_candidato_req.candidato_id')
                ->where('proceso', 'RETROALIMENTACION')
                ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = 3 )")
                ->select(
                    'datos_basicos.numero_id',
                    'datos_basicos.nombres',
                    'datos_basicos.primer_apellido',
                    'datos_basicos.segundo_apellido',
                    'procesos_candidato_req.requerimiento_id',
                    'procesos_candidato_req.requerimiento_candidato_id as ref_id',
                    'procesos_candidato_req.proceso')
                ->orderBy('procesos_candidato_req.id', 'desc')
                ->groupBy('procesos_candidato_req.requerimiento_candidato_id')
            ->paginate(10);
        }
        return view("admin.reclutamiento.retroalimentacion_videos", compact("candidatos"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function enviar_retroalimentacion_view(Request $request)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $request->candidato_req)
        ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
        ->first();

        return view("admin.reclutamiento.modal.enviar_retroalimentacion_video", compact("candidato"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmar_retroalimentacion_video(Request $request)
    {
        $estado = config('conf_aplicacion.C_EN_PROCESO_SELECCION');

        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $request->candidato_req)
        ->select("requerimiento_cantidato.*","datos_basicos.email")
        ->first();

        $campos_data = [
            'requerimiento_candidato_id' => $request->candidato_req,
            'usuario_envio'              => $this->user->id,
            "fecha_inicio"               => date("Y-m-d H:i:s"),
            'proceso'                    => "RETROALIMENTACION",
            'requerimiento_id'           => $candidato->requerimiento_id,
            'candidato_id'               => $candidato->candidato_id,
            'estado'                     => $estado
        ];

        //ACTUALIZA REGISTRO A ESTADO SEGUN EL PROCESO
        $reqCandidato = ReqCandidato::where('id', $candidato->id)->update(['estado_candidato' => $estado]);

        //REGISTRA PROCESO
        $nuevo_proceso = new RegistroProceso();
        $nuevo_proceso->fill($campos_data);
        $nuevo_proceso->save();

        $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();
        
        return response()->json([
            "success" => true,
            "text_estado" => $estado->descripcion,
            "candidato_req" => $request->candidato_req,
            "id_proceso" => $id_proceso
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gestionar_retroalimentacion_video($id)
    {
        $user_sesion = $this->user;
        
        $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
        ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
        ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = 3 )")
        ->where("procesos_candidato_req.proceso", 'RETROALIMENTACION')
        ->where("procesos_candidato_req.requerimiento_candidato_id", $id)
        ->select("procesos_candidato_req.requerimiento_candidato_id", "procesos_candidato_req.id as ref_id", "datos_basicos.*", 'requerimiento_cantidato.requerimiento_id',
            'requerimiento_cantidato.candidato_id',
            'requerimiento_cantidato.id as req_cand_id',
            'requerimiento_cantidato.estado_candidato',
            'requerimiento_cantidato.otra_fuente')
        ->first();

        if ($candidato == null) {
            return redirect()->route('admin.retroalimentacion_videos')->with("mensaje_warning", "No se puede gestionar el registro. Debe reabrir el proceso.");
        }

        $retroalimentacion_videos = RetroalimentacionVideo::where("cand_req_id", $candidato->requerimiento_candidato_id)
        ->get();

        return view("admin.reclutamiento.gestionar_retroalimentacion_video", compact(
            "candidato",
            "retroalimentacion_videos",
            "user_sesion"
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function guardar_retroalimentacion_video(Request $request)
    {
        //logger('llego');
        //logger(json_encode($request->all()));
        $id_ult = 1;
        $retro = RetroalimentacionVideo::select('id')->orderBy('id', 'desc')->first();
        if ($retro != null) {
            $id_ult = $retro->id + 1;
        }
        //logger($id_ult . json_encode($request->all()));
        //return response()->json(["success" => true, "mail_enviado" => true]);
        $datos_basicos = DatosBasicos::where("user_id", $request->candidato_id)->first();
        
        //GUARDANDO VIDEO
        $archivo   = $request->file('video-blob');
        $extension = $archivo->getClientOriginalExtension();
        $fileName  = "Retroalimentacion_" . $request->candidato_id . "_" . $request->cand_req_id . "_" . $id_ult . ".$extension";
        
        $retroalimentacion_video = new RetroalimentacionVideo();

        $retroalimentacion_video->fill([
            'candidato_id'          => $request->candidato_id,
            'req_id'                => $request->req_id,
            'cand_req_id'           => $request->cand_req_id,
            'gestiona'              => $this->user->id,
            'nombre_archivo'        => $fileName,
            'observacion'           => $request->observacion
        ]);
        $retroalimentacion_video->save();
        $request->file('video-blob')->move("recursos_retroalimentacion", $fileName);

        $url = url("recursos_retroalimentacion/" . $fileName);

        $requerimiento = Requerimiento::join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->where("requerimientos.id", $request->req_id)
            ->select(
                "requerimientos.id as requerimiento",
                "cargos_especificos.descripcion as cargo"
            )
        ->first();

        $mail = false;
        try {
            $observacion = $request->observacion;
            $observacion_texto = "";

            if ($observacion != null && $observacion != ''){
                $observacion_texto = "<br><br>
                <b>Observación:</b> {$observacion}";
            }

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = ""; //Titulo o tema del correo

            //Cuerpo con html y comillas dobles para las variables
            $mailBody = "
                Hola {$datos_basicos->nombres} {$datos_basicos->primer_apellido}, teniendo en cuenta el proceso de selección que estás adelantando para el cargo {$requerimiento->cargo}, tenemos preparada la retroalimentación de tu proceso. A continuación te invitamos a que hagas clic en el botón <b>Retroalimentación</b> para que visualices el vídeo que tu analista de selección ha preparado para ti.
                {$observacion_texto}
                                                
            ";

            //Arreglo para el botón
            $mailButton = ['buttonText' => 'RETROALIMENTACIÓN', 'buttonRoute' => $url];

            $mailUser = $datos_basicos->user_id; //Id del usuario al que se le envía el correo

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            //Envio de email
            $mail = Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $requerimiento) {

                    $message->to($datos_basicos->email, $datos_basicos->nombres)
                            ->subject("Retroalimentación proceso de selección No. {$requerimiento->requerimiento} - {$requerimiento->cargo}")
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

            
            if ($mail) {
                $retroalimentacion_video->quien_envia = $this->user->id;
                $retroalimentacion_video->fecha_enviado = date("Y-m-d H:i:s");
                $retroalimentacion_video->save();
            }
        } catch (\Exception $e) {
            logger('Error en el envio del video de Retroalimentación. Correo candidato "' . $datos_basicos->email . '"');
        }
            

        return response()->json(["success" => true, "mail_enviado" => $mail]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
