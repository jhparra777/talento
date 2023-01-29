<?php

namespace App\Listeners;

use App\Events\NotificationWhatsappEvent;
use App\Models\Requerimiento;
use App\Models\Preperfilados;
use App\Models\CargoGenerico;
use App\Models\DatosBasicos;
use App\Models\NivelEstudios;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Log;
use App\Models\Sitio;


class NotificationWhatsappListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  NotificationWhatsappEvent  $event
     * @return void
     */
    public function handle(NotificationWhatsappEvent $event)
    {    
        if( $event->message == 'whatsapp' ) {
         
            try {

                $sitio = Sitio::first();
                $newClients = new Client();

                $instancia = config('conf_aplicacion.VARIABLES_ENTORNO.INSTANCIA_API_ID');
                $indicativo = config('conf_aplicacion.VARIABLES_ENTORNO.INDICATIVO');
                
                $params = [
                    'instancia' => $instancia,
                    'to'        => "{$indicativo}{$event->destino}",
                    'type'      => $event->type
                ];

                if( $event->nameTemplate != null ) {

                    $params["template"] = $event->nameTemplate;
                    $params["components"] = tri_components_message_whatsapp($instancia, $event->nameTemplate, $event->data);
                }

                $response = $newClients->post('https://api.t3rsc.co/api/whatsapp/send', [
                    "headers" => [
                        'Authorization' => ['Bearer '.$sitio->token_api]
                    ],
                    'form_params' => $params
                ]);

                $data2 = json_decode($response->getBody()->getContents(),true);

                //Log::info($data2);

            } catch (\Exception $e) {
                Log::alert("Whatsapp no enviado({$event->destino}): ".$e->getMessage());
            }
        }
        
    }
}
