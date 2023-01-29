<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Jobs\FuncionesGlobales;
use App\Models\User;
use App\Models\DatosBasicos;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class SendWhatsappNotificacion extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($num,$message)
    {
        $this->num = $num;
        $this->message = $message;
    }

    /**
     * Created by: Vilfer Alvarez
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
          $newClients = new Client();
                $response2 = $newClients->post('https://api.chat-api.com/instance'.env("CHAT_API_INSTANCIA").'/sendMessage?token='.env("CHAT_API_TOKEN"), [
                "headers" => [
                    //'Authorization' => ['Bearer '.$token],
                    "form_params" => [
                        "phone" => $this->num,
                        "body" => $this->body
                    ]
                ]
            ]);
    }
}
