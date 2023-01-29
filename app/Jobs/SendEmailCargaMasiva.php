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
use triPostmaster;

class SendEmailCargaMasiva extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Created by: Vilfer Alvarez
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
            $funcionesGlobales = new FuncionesGlobales();

                    if(isset($funcionesGlobales->sitio()->nombre)){
                      
                      if($funcionesGlobales->sitio()->nombre != "") {
                        $nombre = $funcionesGlobales->sitio()->nombre;
                      }else{
                        $nombre = "Desarrollo";
                      }
                    }

            $datos_basicos=DatosBasicos::where("user_id",$this->user->id)->first();

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


            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos_basicos, $nombre) {

                        $message->to($datos_basicos->email, $datos_basicos->nombres)
                                ->subject("Bienvenido a $nombre - T3RS")
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
           
    }
}
