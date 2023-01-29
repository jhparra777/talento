<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\PruebaDigitacionCargo;
use App\Models\PruebaDigitacionResultado;
use App\Models\ReqCandidato;
use App\Models\Requerimiento;
use App\Models\Sitio;
use App\Models\SitioModulo;

//Helper
use triPostmaster;

//Controller
use App\Http\Controllers\ReclutamientoController;

class PruebasTecnicasController extends Controller
{
    public function enviar_pruebas_tecnicas(Request $request)
    {
        $sitioModulo = SitioModulo::first();

        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
        ->where("requerimiento_cantidato.id", $request->get("candidato_req"))
        ->select(
            "datos_basicos.nombres",
            "datos_basicos.primer_apellido",
            "datos_basicos.segundo_apellido",
            "requerimiento_cantidato.id as req_candidato"
        )
        ->first();

        return view("admin.reclutamiento.modal.pruebas_tecnicas._modal_enviar_prueba_tecnica", compact("candidato", "sitioModulo"));
    }

    public function confirmar_pruebas_tecnicas(Request $request)
    {
        $pruebas = $request->pruebas_tecnicas;
        $sitio = Sitio::first();

        for ($i = 0; $i < count($pruebas); $i++) { 
            /*
             * Prueba sigitación
            */

            if($pruebas[$i] == 1) {
                $datos_candidato = ReqCandidato::join('datos_basicos', 'datos_basicos.user_id', '=', 'requerimiento_cantidato.candidato_id')
                ->where('requerimiento_cantidato.id', $request->get("candidato_req"))
                ->select(
                    'requerimiento_cantidato.requerimiento_id as req_id',
                    'datos_basicos.email',
                    'datos_basicos.user_id as user_id',
                    DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo")
                )
                ->first();

                //Validar si hay configuración en cargo
                $cargo = Requerimiento::find($datos_candidato->req_id);
                $configuracion = PruebaDigitacionCargo::where('cargo_id', $cargo->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();

                if (empty($configuracion)) {
                    return response()->json(['configuracion' => true]);
                }

                //Crea registro para guardar los resultados
                $result_test = new PruebaDigitacionResultado();
                $result_test->fill([
                    'req_id'         => $datos_candidato->req_id,
                    'user_id'        => $datos_candidato->user_id,
                    'gestion_id'     => $this->user->id
                ]);
                $result_test->save();

                //Datos para el proceso
                $procesoInformacion = [
                    'requerimiento_candidato_id' => $request->get("candidato_req"),
                    'usuario_envio'              => $this->user->id,
                    "fecha_inicio"               => date("Y-m-d H:i:s"),
                    'proceso'                    => "ENVIO_PRUEBA_DIGITACION",
                ];

                $reclutamientoController = new ReclutamientoController();
                $reclutamientoController->RegistroProceso($procesoInformacion, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $request->get("candidato_req"));

                /**
                 *
                 * Usar administrador de correos
                 *
                */
                    $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                    $mailConfiguration = 1; //Id de la configuración
                    $mailTitle = "Prueba Digitación"; //Titulo o tema del correo

                    //Cuerpo con html y comillas dobles para las variables
                    $mailBody = "
                        Hola $datos_candidato->nombre_completo, has sido enviad@ en tu proceso de selección a realizar nuestra prueba de digitación. <br>
                        Por favor haz clic en botón <b>Realizar prueba</b> y sigue las instrucciones que te brindará la plataforma. <br><br>
                        <i>¡Muchos éxitos!</i>
                    ";

                    //Arreglo para el botón
                    $mailButton = ['buttonText' => 'Realizar prueba', 'buttonRoute' => route('cv.digitacion_inicio')];

                    $mailUser = $datos_candidato->user_id; //Id del usuario al que se le envía el correo

                    $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                    //Enviar correo generado
                    Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($datos_candidato, $sitio) {
                        $message->to([$datos_candidato->email], 'T3RS')
                        ->bcc($sitio->email_replica)
                        ->subject("Prueba Digitación")
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                    });
                /**
                 * Fin administrador correos
                */
            }
        }

        return response()->json(["success" => true]);
    }
}
