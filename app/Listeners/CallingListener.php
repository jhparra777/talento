<?php

namespace App\Listeners;

use App\Events\CallingEvent;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use Log;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\Sitio;


class CallingListener
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
    public function handle(CallingEvent $event)
    {
        
            try {
                $sitio = Sitio::first();
                $newClients = new Client(); // Guzzle

                $instancia = config('conf_aplicacion.VARIABLES_ENTORNO.INSTANCIA_API_ID');
                $indicativo = config('conf_aplicacion.VARIABLES_ENTORNO.INDICATIVO');
            
                $response = $newClients->post('https://api.t3rsc.co/api/calls/calling', [
                    "headers" => [
                        'Authorization' => ['Bearer '.$sitio->token_api]
                    ],
                    'form_params' => [
                        'instancia' => $instancia,
                        'mensaje' => $event->message,
                        'destino' => explode(",", $event->destino)
                    ]
                ]);

                $data2 = json_decode($response->getBody()->getContents(),true);

                //Log::info($data2);

            } catch (\Exception $e) {
                Log::alert("Llamada no realizada({$event->destino}): ".$e->getMessage());
            }
        
        
    }
}
