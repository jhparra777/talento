<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;

use App\Models\Sitio;

use triMailGenerator;

class triPostmaster
{
    //Helper administrador de correos para tri
    public static function exampleFunction()
    {
    	//Esta función es un ejemplo de como se deben crear los nuevos correos para tri

    	/*
    	 * @string $mailTitle
    	 * El mailTitle es el titulo o encabezado que va a aparecer en el correo (el tema del correo)
    	*/
    	$mailTitle = "Example generator";

    	/*
    	 * @string $mailBody
    	 * El mailBody es el cuerpo del correo en sí, lo ideal y la forma en como la plantilla leerá es enviando el string.
    	 * Si es necesario usar variables o código PHP dentro del cuerpo, se recomienda usar comillas dobles " " ya que estas interpretan las -
    	 * variables concatenadas en el string.
    	*/
        $mailBody = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

        /*
         * @array $mailButton
         * Si el correo debe tener un llamado a la acción como lo es un botón entonces se debe enviar el siguiente arreglo.
         * Se compone de una propiedad buttonText, la cual mostrará el contenido del botón en sí
         * Su otra propiedad es la acción, buttonRoute, que es en si la ruta o url a la que dirigirá el botón.
         * IMPORTANTE:
         * - Se deben respetar los nombres de cada propiedad tal cual estan escritos
        */
        $mailButton = [
            'buttonText' => 'Example button',
            'buttonRoute' => route('home')
        ];

        /*
         * @int $mailTemplate
         * Esta variables hace referencia a la plantilla que se va a usar para el correo.
         * 1 => Correo sencillo
         * 2 => Correo con fondo y botón #1
         * 3 => Correo con fondo y botón #2
        */
        $mailTemplate = $mailTemplate;

        /*
         * @int $mailConfiguration
         * Es el id de la configuración a usar, la configuración debe ser creada previamente a tráves del gestor de configuraciones.
         * Este id puede ser tomado de la tabla plantillas_correos_configuracion
         * Usar 1 por defecto
        */
        $mailConfiguration = $mailConfiguration;

        /*
         * @int $mailUser
         * Es el id del usuario en la plataforma (siempre se debe enviar)
         *
        */
        $mailUser = $mailUser;

        /*
         * triMailGenerator es el helper que recibe todos los argumentos para generar el correo
         * Este Helper retorna un arreglo con la vista de la plantilla y los argumentos procesados como data para el correo.
        */
        $triMailGenerator = triMailGenerator::generateMail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        /*
         * Si se desea ver la vista para pruebas o simplemente para mostrar se debe usar como indica el siguiente código.
         * $triMailGenerator->view (Es la vista del template seleccionado para el correo)
         * $triMailGenerator->data (Son los datos que espera el template para su correcto funcionamiento)
         * IMPORTANTE:
         * - Al pasar $triMailGenerator->data como data de la vista o en el Mail::send se debe respetar el nombre del arreglo que es -
         * data
         * Se debe escribir tal cual 'data' => $triMailGenerator->data
        */
        return view($triMailGenerator->view, ['data' => $triMailGenerator->data]);


        /*
         * Si dentro de este Helper se desea enviar el correo directamente es igual que en cualquier controlador
        */
        
        /*
	        try {
	            Mail::send($triMailGenerator->view, ['data' => $triMailGenerator->data], function($message) {
	                $message->to(['example@example.com'], 'T3RS Developer')->subject('Example generator');
	            });

	            dd('Enviado');
	        } catch (Exception $e) {
	            dd($e);
	        }
		*/
    }

    public static function makeEmail(int $mailTemplate, int $mailConfiguration, string $mailTitle, string $mailBody, array $mailButton = [], int $mailUser = null, array $mailAditionalTemplate = [])
    {
        $triMailGenerator = triMailGenerator::generateMail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser, $mailAditionalTemplate);

        return $triMailGenerator;
    }

    public static function sendEmail(string $bladeEmailView, $emailData,$toEmail, string $subjectEmail)
    {
        
        $sitio=Sitio::first();
        try {
            Mail::send($bladeEmailView, ['data' => $emailData], function ($message) use ($toEmail,$subjectEmail,$sitio) {
                $message->to($toEmail, 'T3RS');
                if(!is_null($sitio->email_replica) && $sitio->email_replica!=""){
                    $message->bcc($sitio->email_replica);
                }
                $message->subject($subjectEmail)
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
