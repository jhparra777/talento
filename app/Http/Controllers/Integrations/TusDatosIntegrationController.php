<?php

namespace App\Http\Controllers\Integrations;

use DateTime;

use GuzzleHttp\Client;
use App\Models\TusDatosKey;
use App\Models\DatosBasicos;
use App\Models\ReqCandidato;
use Illuminate\Http\Request;
use App\Models\RegistroProceso;
use App\Models\TipoIdentificacion;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\ControlFuncionalidad;

class TusDatosIntegrationController extends Controller
{
    /**
     * 
     */

    const BASE_QA_URL = 'http://docs.tusdatos.co/';
    const BASE_PROD_URL = 'https://dash-board.tusdatos.co/';

    /**
     * user:
     * jorge.ortiz@t3rsc.co
     * 
     * pass:
     * Nit:901175640
     */

    public function consultarPersona(Request $request)
    {
        //
        /*$numeroDocumento = DatosBasicos::join('tipo_identificacion', 'tipo_identificacion.id', '=', 'datos_basicos.tipo_id')
        ->where('datos_basicos.user_id', $request->user_id)
        ->select('datos_basicos.numero_id', 'datos_basicos.fecha_expedicion', 'datos_basicos.tipo_id', 'tipo_identificacion.cod_tipo')
        ->first();*/

        $tipo_documento = TipoIdentificacion::where('id', $request->tipo_documento)->first();
        $datos_basicos = DatosBasicos::where('user_id', $request->user_id)->first();

        // Actualizar datos básicos
        $datos_basicos->tipo_id = $request->tipo_documento;
        $datos_basicos->fecha_expedicion = $request->fecha_expedicion;
        $datos_basicos->save();

        if (route('home') == 'http://localhost:1000') {
            $data = [
                'doc' => 123,
                'typedoc' => 'CC',
                'fechaE' => '01/12/2017'
            ];

            $auth = ['pruebas', 'password'];
        }else {
            if ($tipo_documento->cod_tipo == 'CC') {
                //CC
                $tipo_doc = 'CC';
            }elseif ($tipo_documento->cod_tipo == 'CE') {
                //CE
                $tipo_doc = 'CE';
            }elseif ($tipo_documento->cod_tipo == 'PE') {
                //PEP
                $tipo_doc = 'PEP';
            }elseif ($tipo_documento->cod_tipo == 'PPT') {
                //PPT
                $tipo_doc = 'PPT';
            }else {
                $tipo_doc = 'CC';
            }

            //
            $fecha_expedicion_replace = str_replace('-', '/', $datos_basicos->fecha_expedicion);
            $fecha_expedicion = DateTime::createFromFormat('Y/m/d', $fecha_expedicion_replace);

            if ($tipo_documento->cod_tipo == 'PE' || $tipo_documento->cod_tipo == 'PPT') {
                $data = [
                    'doc' => $datos_basicos->numero_id,
                    'typedoc' => $tipo_doc
                ];
            }else {
                $data = [
                    'doc' => $datos_basicos->numero_id,
                    'typedoc' => $tipo_doc,
                    'fechaE' => (empty($datos_basicos->fecha_expedicion)) ? null : $fecha_expedicion->format('d/m/Y')
                ];
            }

            //Plan
            /*if ($request->plan == 'protegido') {
                $auth = ['lida.peraza@listos.com.co', 'Lidaperaza2022*'];
            }elseif($request->plan == 'blindado') {
                $auth = ['liliana.marin@listos.com.co', 'Dima19891127'];
            } */

            $auth = ['jorge.ortiz@t3rsc.co', 'Nit:901175640'];
        }

        $consultarPersona = new Client();
        $serviceResponse = $consultarPersona->post(self::BASE_PROD_URL.'api/launch', [
            'http_errors' => false,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'auth' => $auth,
            'json' => $data
        ]);

        $convertResponse = json_decode($serviceResponse->getBody()->getContents());

        Log::debug(json_encode($convertResponse));

        //Relación candidato con el req
        $reqCandidato = ReqCandidato::where("requerimiento_id", $request->req_id)
        ->where("candidato_id", $request->user_id)
        ->select("id")
        ->orderBy("id", 'DESC')
        ->first();

        //Busca el proceso de consulta tusdatos
        $procesoTusdatos = RegistroProceso::where('requerimiento_candidato_id', $reqCandidato->id)
        ->where('proceso', 'CONSULTA_TUSDATOS')
        ->orderBy("id")
        ->first();

        if ($convertResponse->error == 'Documento consultado previamente') {
            Log::info('tusdatos.co, Documento consultado previamente');
            //Log::info($data);

            $tusdatos = TusDatosKey::where('req_id', $request->req_id)->where('user_id', $request->user_id)->orderBy('id', 'DESC')->first();

            if (empty($tusdatos)) {
                TusDatosKey::create([
                    'req_id' => $request->req_id,
                    'user_id' => $request->user_id,
                    'gestion_id' => $this->user->id,
                    'report_id' => $convertResponse->id,
                    'factor' => $convertResponse->hallazgos,
                    'plan' => 'protegido',
                    'status' => 'finalizado',
                ]);
            }else {
                $tusdatos->report_id = $convertResponse->id;
                $tusdatos->factor = $convertResponse->hallazgos;
                $tusdatos->status = 'finalizado';
                $tusdatos->save();
            }

            if (empty($procesoTusdatos)) {
                $procesoTusdatos = new RegistroProceso();
                $procesoTusdatos->fill([
                    'requerimiento_candidato_id' => $reqCandidato->id,
                    'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                    'usuario_envio'              => $this->user->id,
                    'requerimiento_id'           => $request->req_id,
                    'candidato_id'               => $request->user_id,
                    'observaciones'              => 'Consulta de candidata/o en tusdatos.co',
                    'proceso'                    => "CONSULTA_TUSDATOS",
                    'apto' => 1,
                ]);
            }else {
                $procesoTusdatos->apto = 1;
            }

            $procesoTusdatos->save();

        } elseif (isset($convertResponse->error)) {
            //Registrar en tabla
            TusDatosKey::create([
                'req_id' => $request->req_id,
                'user_id' => $request->user_id,
                'gestion_id' => $this->user->id,
                'job_id' => $convertResponse->jobid,
                'plan' => 'protegido',
                'status' => 'invalido',
                'error' => $convertResponse->error
            ]);

            return response()->json(['success' => false, 'error' => true, 'msg' => $convertResponse->error, 'response' => $convertResponse]);
        } else {
            //Registrar en tabla
            TusDatosKey::create([
                'req_id' => $request->req_id,
                'user_id' => $request->user_id,
                'gestion_id' => $this->user->id,
                'job_id' => $convertResponse->jobid,
                'plan' => 'protegido',
                'error' => $convertResponse->error
            ]);
        }

        //Busca el proceso de consulta tusdatos
        $procesoTusdatos = RegistroProceso::where('requerimiento_candidato_id', $reqCandidato->id)
        ->where('proceso', 'CONSULTA_TUSDATOS')
        ->orderBy("id")
        ->first();

        if (empty($procesoTusdatos)) {
            $procesoTusdatos = new RegistroProceso();
            $procesoTusdatos->fill([
                'requerimiento_candidato_id' => $reqCandidato->id,
                'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                'usuario_envio'              => $this->user->id,
                'requerimiento_id'           => $request->req_id,
                'candidato_id'               => $request->user_id,
                'observaciones'              => 'Consulta de candidata/o en tusdatos.co',
                'proceso'                    => "CONSULTA_TUSDATOS"
            ]);
            $procesoTusdatos->save();
        }

        return response()->json(['success' => true, 'response' => $convertResponse]);
    }

    public function consultarPersonaEVS(Request $request)
    {
        $tipo_documento = TipoIdentificacion::where('id', $request->tipo_documento)->first();
        $datos_basicos = DatosBasicos::where('user_id', $request->user_id)->first();

        // Actualizar datos básicos
        $datos_basicos->tipo_id = $request->tipo_documento;
        $datos_basicos->fecha_expedicion = $request->fecha_expedicion;
        $datos_basicos->save();

        if (route('home') == 'http://localhost:1000') {
            $data = [
                'doc' => 123,
                'typedoc' => 'CC',
                'fechaE' => '01/12/2017'
            ];

            $auth = ['pruebas', 'password'];
        }else {
            if ($tipo_documento->cod_tipo == 'CC') {
                //CC
                $tipo_doc = 'CC';
            }elseif ($tipo_documento->cod_tipo == 'CE') {
                //CE
                $tipo_doc = 'CE';
            }elseif ($tipo_documento->cod_tipo == 'PE') {
                //PEP
                $tipo_doc = 'PEP';
            }elseif ($tipo_documento->cod_tipo == 'PPT') {
                //PPT
                $tipo_doc = 'PPT';
            }else {
                $tipo_doc = 'CC';
            }

            //
            $fecha_expedicion_replace = str_replace('-', '/', $datos_basicos->fecha_expedicion);
            $fecha_expedicion = DateTime::createFromFormat('Y/m/d', $fecha_expedicion_replace);

            if ($tipo_documento->cod_tipo == 'PE' || $tipo_documento->cod_tipo == 'PPT') {
                $data = [
                    'doc' => $datos_basicos->numero_id,
                    'typedoc' => $tipo_doc
                ];
            }else {
                $data = [
                    'doc' => $datos_basicos->numero_id,
                    'typedoc' => $tipo_doc,
                    'fechaE' => (empty($datos_basicos->fecha_expedicion)) ? null : $fecha_expedicion->format('d/m/Y')
                ];
            }

            $auth = ['jorge.ortiz@t3rsc.co', 'Nit:901175640'];
        }

        $consultarPersona = new Client();
        $serviceResponse = $consultarPersona->post(self::BASE_PROD_URL.'api/launch', [
            'http_errors' => false,
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'auth' => $auth,
            'json' => $data
        ]);

        $convertResponse = json_decode($serviceResponse->getBody()->getContents());

        Log::debug(json_encode($convertResponse));

        //Relación candidato con el req
        $reqCandidato = ReqCandidato::where("requerimiento_id", $request->req_id)
        ->where("candidato_id", $request->user_id)
        ->select("id")
        ->orderBy("id", 'DESC')
        ->first();

        //Busca el proceso de consulta tusdatos
        $procesoTusdatos = RegistroProceso::where('requerimiento_candidato_id', $reqCandidato->id)
        ->where('proceso', 'CONSULTA_ANTECEDENTES_EVS')
        ->orderBy("id")
        ->first();

        if ($convertResponse->error == 'Documento consultado previamente') {
            //Log::info('tusdatos.co, Documento consultado previamente');
            //Log::info($data);

            $tusdatos = TusDatosKey::where('req_id', $request->req_id)->where('user_id', $request->user_id)->orderBy('id', 'DESC')->first();

            if (empty($tusdatos)) {
                TusDatosKey::create([
                    'req_id' => $request->req_id,
                    'user_id' => $request->user_id,
                    'gestion_id' => $this->user->id,
                    'report_id' => $convertResponse->id,
                    'factor' => $convertResponse->hallazgos,
                    'plan' => 'protegido',
                    'status' => 'finalizado',
                ]);
            }else {
                $tusdatos->report_id = $convertResponse->id;
                $tusdatos->factor = $convertResponse->hallazgos;
                $tusdatos->status = 'finalizado';
                $tusdatos->save();
            }

            if (empty($procesoTusdatos)) {
                $procesoTusdatos = new RegistroProceso();
                $procesoTusdatos->fill([
                    'requerimiento_candidato_id' => $reqCandidato->id,
                    'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                    'usuario_envio'              => $this->user->id,
                    'requerimiento_id'           => $request->req_id,
                    'candidato_id'               => $request->user_id,
                    'observaciones'              => 'Consulta de candidata/o en tusdatos.co',
                    'proceso'                    => "CONSULTA_ANTECEDENTES_EVS",
                    'apto' => 1,
                ]);
            }else {
                $procesoTusdatos->apto = 1;
            }

            $procesoTusdatos->save();

        } elseif (isset($convertResponse->error)) {
            //Registrar en tabla
            TusDatosKey::create([
                'req_id' => $request->req_id,
                'user_id' => $request->user_id,
                'gestion_id' => $this->user->id,
                'job_id' => $convertResponse->jobid,
                'plan' => 'protegido',
                'status' => 'invalido',
                'error' => $convertResponse->error
            ]);

            return response()->json(['success' => false, 'error' => true, 'msg' => $convertResponse->error, 'response' => $convertResponse]);
        } else {
            //Registrar en tabla
            TusDatosKey::create([
                'req_id' => $request->req_id,
                'user_id' => $request->user_id,
                'gestion_id' => $this->user->id,
                'job_id' => $convertResponse->jobid,
                'plan' => 'protegido',
                'error' => $convertResponse->error
            ]);
        }

        //Busca el proceso de consulta tusdatos
        $procesoTusdatos = RegistroProceso::where('requerimiento_candidato_id', $reqCandidato->id)
        ->where('proceso', 'CONSULTA_ANTECEDENTES_EVS')
        ->orderBy("id")
        ->first();

        if (empty($procesoTusdatos)) {
            $procesoTusdatos = new RegistroProceso();
            $procesoTusdatos->fill([
                'requerimiento_candidato_id' => $reqCandidato->id,
                'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                'usuario_envio'              => $this->user->id,
                'requerimiento_id'           => $request->req_id,
                'candidato_id'               => $request->user_id,
                'observaciones'              => 'Consulta de candidata/o en tusdatos.co',
                'proceso'                    => "CONSULTA_ANTECEDENTES_EVS"
            ]);
            $procesoTusdatos->save();
        }

        return response()->json(['success' => true, 'response' => $convertResponse]);
    }

    //CRON
    public function consultarResultado()
    {
        /**
         * PRUEBA
         * 
         * Proceso
         * 6769d210-3476-4c82-a044-045e9d5bc157
         * 
         * Fin
         * 6460fc34-4154-43db-9438-8c5a059304c0
         */

        $registrosConsultas = TusDatosKey::where('status', 'procesando')->get();

        $consultarResultado = new Client();

        foreach ($registrosConsultas as $registro) {
            //Usar el usuario de acuerdo al plan seleccionado
            // if ($registro->plan == 'protegido') {
            //     $auth = ['jorge.ortiz@t3rsc.co', 'Nit:901175640'];
            // }elseif($registro->plan == 'blindado') {
            //     $auth = ['jessica.guzman@t3rsc.co', 'Cc:809188377'];
            // }

            $auth = ['jorge.ortiz@t3rsc.co', 'Nit:901175640'];

            $serviceResponse = $consultarResultado->get(self::BASE_PROD_URL.'api/results/'.$registro['job_id'], [
                'http_errors' => false,
                'auth' => $auth
            ]);

            $convertResponse = json_decode($serviceResponse->getBody()->getContents());

            //Relación candidato con el req
            $reqCandidato = ReqCandidato::where("requerimiento_id", $registro->req_id)
            ->where("candidato_id", $registro->user_id)
            ->select("id")
            ->orderBy("id", 'DESC')
            ->first();

            //Busca el proceso de consulta tusdatos
            $procesoTusdatos = RegistroProceso::where('requerimiento_candidato_id', $reqCandidato->id)
            ->where('proceso', 'CONSULTA_TUSDATOS')
            ->orderBy("id", "DESC")
            ->first();

            if (empty($procesoTusdatos)) {
                $procesoTusdatos = new RegistroProceso();
                $procesoTusdatos->fill([
                    'requerimiento_candidato_id' => $reqCandidato->id,
                    'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                    'usuario_envio'              => $registro->gestion_id,
                    'requerimiento_id'           => $registro->req_id,
                    'candidato_id'               => $registro->user_id,
                    'observaciones'              => 'Consulta de antecedentes',
                    'proceso'                    => "CONSULTA_TUSDATOS"
                ]);
            }

            switch ($convertResponse->estado) {
                case 'finalizado':
                    $tusdatos = TusDatosKey::where('req_id', $registro->req_id)->where('user_id', $registro->user_id)->orderBy('id', 'DESC')->first();

                    $tusdatos->report_id = $convertResponse->id;
                    $tusdatos->factor = $convertResponse->hallazgos;
                    $tusdatos->status = 'finalizado';
                    //$tusdatos->error = (isset($convertResponse->error)) ? $tusdatos->error.' - '.$convertResponse->error : null;
                    $tusdatos->save();

                    if (!empty($procesoTusdatos)) {
                        $procesoTusdatos->observaciones = 'Consulta de antecedentes';
                        $procesoTusdatos->apto = 1;
                    }

                    //hallazgos
                    break;

                case 'error, tarea no valida':

                    $tusdatos = TusDatosKey::where('req_id', $registro->req_id)->where('user_id', $registro->user_id)->orderBy('id', 'DESC')->first();

                    $tusdatos->status = 'invalido';
                    $tusdatos->save();

                    // Re ejecutar la consulta
                    // $datos_basicos = DatosBasicos::where('user_id', $registro->user_id)->first();

                    // $request_send = new \Illuminate\Http\Request([
                    //     'user_id' => $registro->user_id,
                    //     'req_id' => $registro->req_id,
                    //     'plan' => $registro->plan,
                    //     'tipo_documento' => $datos_basicos->tipo_id,
                    //     'fecha_expedicion' => $datos_basicos->fecha_expedicion
                    // ]);

                    // $this->consultarPersona($request_send);

                    //Log::useFiles(storage_path().'/logs/tusdatos-log.log');
                    Log::debug(json_encode(['message' => 'Cron tarea invalida. Reenvio', 'response' => $convertResponse]));

                    break;

                default:
                    if (!empty($procesoTusdatos)) {
                        $procesoTusdatos->observaciones = 'Consulta de antecedentes';
                        $procesoTusdatos->apto = null;
                    }

                    Log::debug(json_encode(['message' => 'Cron estado default', 'response' => $convertResponse]));
                    break;
            }

            $procesoTusdatos->save();
        }
    }

    public function reintentarConsulta()
    {
        /**
         * Genera un nuevo job id y con ese job id se usa el consultarReporte para generar otro id de reporte
         */
    }

    //
    public function consultarReporte()
    {
        /**
         * Id
         * 5d9e00483800a5071688a101
         */

        $consultarReporte = new Client();

        $serviceResponse = $consultarReporte->get(self::BASE_QA_URL.'api/report/5d9e00483800a5071688a101', [
            'auth' => ['pruebas', 'password']
        ]);

        $convertResponse = $serviceResponse->getBody()->getContents();
    }

    public function consultarReportePdf(Request $request)
    {
        /**
         * Id
         * 5d9e00483800a5071688a101
         */

        $tusdatosRegistro = TusDatosKey::find($request->check);

        // if ($tusdatosRegistro->plan == 'protegido') {
        //     $auth = ['jorge.ortiz@t3rsc.co', 'Nit:901175640'];
        // }elseif($tusdatosRegistro->plan == 'blindado') {
        //     $auth = ['jessica.guzman@t3rsc.co', 'Cc:809188377'];
        // }

        $auth = ['jorge.ortiz@t3rsc.co', 'Nit:901175640'];

        $consultarReportePdf = new Client();

        $serviceResponse = $consultarReportePdf->get(self::BASE_PROD_URL.'api/report_pdf/'.$tusdatosRegistro->report_id, [
            'auth' => $auth
        ]);

        $response = $serviceResponse->getBody();

        header('Cache-Control: public');
        header('Content-type: application/pdf');
        header('Content-Length: '.strlen($response));
        echo $response;
    }

    public function consultarReporteJson()
    {
        /**
         * Id
         * 5d9e00483800a5071688a101
         */

        $consultarReporteJson = new Client();

        $serviceResponse = $consultarReporteJson->get(self::BASE_QA_URL.'api/report_json/5d9e00483800a5071688a101', [
            'auth' => ['pruebas', 'password']
        ]);

        $convertResponse = json_decode($serviceResponse->getBody()->getContents());

        dd($convertResponse);
    }

    // Modal
    public function enviarConsulta(Request $request)
    {
        $req_id = $request->req_id;
        $user_id = $request->user_id;

        /**
         * Validar límite
         */

        $limite = ControlFuncionalidad::join('tipo_funcionalidad_avanzada', 'tipo_funcionalidad_avanzada.id', '=', 'control_funcionalidad.tipo_funcionalidad')
        ->where('tipo_funcionalidad_avanzada.descripcion', 'CONSULTA TUSDATOS')
        ->select('control_funcionalidad.limite')
        ->first();

        //Obtiene el mes actual.
        $mes = date("n");
        $anio = date("Y");

        $consultas_realizadas = TusDatosKey::where('status', 'finalizado')
        ->whereMonth('created_at', '=', $mes)
        ->whereYear('created_at', '=', $anio)
        ->count();

        if ($consultas_realizadas >= (int) $limite->limite) {
            $limite = true;
        }else {
            $limite = false;

            /**
             * Validar datos
             */

            $datos_basicos = DatosBasicos::leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
                ->where('user_id', $user_id)
                ->select(
                    "tipo_identificacion.cod_tipo",
                    'nombres',
                    'primer_apellido',
                    'segundo_apellido',
                    'numero_id',
                    'tipo_id',
                    'fecha_expedicion'
                )
            ->first();

            /*
            if (empty($datos_basicos->tipo_id) || empty($datos_basicos->fecha_expedicion)) {
                $success = false;
            }else {
                $success = true;
            }*/

            $tipos_documentos = TipoIdentificacion::where("active", 1)->pluck("descripcion", "id")->toArray();

            $success = true;
        }

        return response()->json([
            'view' => view('admin.reclutamiento.modal._modal_consultar_tusdatos_new', compact('req_id', 'user_id', 'datos_basicos', 'tipos_documentos'))->render(),
            'success' => $success,
            'limite' => $limite
        ]);
    }
}
