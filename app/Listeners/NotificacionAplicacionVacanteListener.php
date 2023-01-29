<?php

namespace App\Listeners;

use App\Events\NotificacionAplicacionVacanteEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\{DatosBasicos, Requerimiento, Sitio};
use triPostmaster;
use Illuminate\Support\Facades\Mail;

class NotificacionAplicacionVacanteListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NotificacionAplicacionVacanteEvent  $event
     * @return void
     */
    public function handle(NotificacionAplicacionVacanteEvent $event)
    {
        //envio de email sobre aplicacion de la oferta
        $sitio = Sitio::first();

        $requerimiento = Requerimiento::join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
        ->where('requerimientos.id', $event->req_id)
        ->select(
            "requerimientos.*", 
            "cargos_especificos.descripcion as cargo")
        ->first();

        $user = DatosBasicos::where('user_id', $event->user_id)->first();

        $email = $user->email;
        $asunto = "Postulación a la vacante";

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = $asunto; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "
                ¡Hola {$user->nombres} {$user->primer_apellido} {$user->segundo_apellido}! Te confirmamos que has aplicado exitosamente a la oferta para el cargo {$requerimiento->cargo} en la plataforma {$sitio->nombre}. Te invitamos a completar tu hoja de vida y cargar tus documentos para que puedas agilizar el proceso. 
                
                <br/><br/>

                ¡Éxitos!
                ";
        //Arreglo para el botón
        $mailButton = ['buttonText' => '¡COMPLETA TU HOJA DE VIDA!', 'buttonRoute' => route('login')];

        $mailUser = $user->id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email, $asunto, $sitio) {

            $message->to($email)
            ->bcc($sitio->email_replica)
            ->subject($asunto)
            ->getHeaders()
            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        //envio de notificacion por whatsApp
        if ( $user->telefono_movil != null && 
             $user->telefono_movil != '') {
            
            $destino = env("INDICATIVO", "57").$user->telefono_movil;

            $message = "¡Hola {$user->nombres} {$user->primer_apellido} {$user->segundo_apellido}! Te confirmamos que has aplicado exitosamente a la oferta para el cargo {$requerimiento->cargo} en la plataforma {$sitio->nombre}. Te invitamos a completar tu hoja de vida ".route('datos_basicos')." 📝 y cargar tus documentos para que puedas agilizar el proceso. 
                
                ¡Éxitos!";
                
            event(new \App\Events\NotificationWhatsappEvent("message",[
                "phone"=>$destino,
                "body"=> $message
            ]));
        }
    }
}
