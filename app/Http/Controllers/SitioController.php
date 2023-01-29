<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\FuncionesGlobales;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Sitio;
use App\Models\DatosTemporales;
use Illuminate\Support\Facades\Mail;

class SitioController extends Controller
{
    /**
     * Andrés Polo Rubiano
     *
     * @return \Illuminate\Http\Response
     * Formulario para registrar la información solicitada
     */
    public function index()
    {
        $sitio = Sitio::first();
        return view("admin.sitio.index", compact('sitio'));
    }

     public function demostraciones()
    {
        $sitio = Sitio::first();
        return view("admin.sitio.demostraciones", compact('sitio'));
    }
     
    

      public function demostracion_video_entrevista()
    {
        $sitio = Sitio::first();
        $mensaje = "Buen día, hemos revisado tu perfil y nos gustaría conocerte un poco más, te invitamos a que realices la siguiente video entrevista que un especialista de selección ha preparado para tí, éxitos!
                    ";
        return view("admin.sitio.demostracion_video_entrevista", compact('mensaje','sitio'));
    }


     public function demostracion_video_entrevista_respuestas(Request $data)
    {
       $datos_temporales = DatosTemporales::where('datos_temporales.modulo','PRUEBA_ENTREVISTA_VIRTUAL')
       ->where('video_entrevista_prueba','<>',"")
        ->where(function ($sql) use ($data) {
                //Filtro por codigo requerimiento
                

                //Filtro por cedula de candidato
                if ($data->cedula != "") {
                    $sql->where("datos_temporales.numero_id", $data->cedula);
                }
            })
       ->select('datos_temporales.*')
       ->paginate(8);
       //dd($datos_temporales);
        return view("admin.sitio.demostracion_video_entrevista_respuestas", compact('datos_temporales','sitio'));
    }

     public function envio_video_entrevista(Request $data ,Requests\DemoEntrevistaLlamadaRequest $valida)
    {
         

         $nuevo_dato_temporal = new DatosTemporales();
         $nuevo_dato_temporal->correo = $data->correo;
         $nuevo_dato_temporal->nombres = $data->nombres;
         $nuevo_dato_temporal->numero_id = $data->numero_id;
         $nuevo_dato_temporal->modulo = "PRUEBA_ENTREVISTA_VIRTUAL";
         $nuevo_dato_temporal->save();


     $funcionesGlobales = new FuncionesGlobales();
        if (isset($funcionesGlobales->sitio()->nombre)) {
            if ($funcionesGlobales->sitio()->nombre != "") {
                $nombre = $funcionesGlobales->sitio()->nombre;
            } else {
                $nombre = "Desarrollo";
            }
        }

         $url = route('home.video_entrevista',['numero_id'=>$nuevo_dato_temporal->numero_id,'req_id'=>'252']);

         $quitar_seguridad_url = str_replace("http://", "https://", $url);
         //dd($quitar_seguridad_url);
        $nombres = $data->nombres;
        $asunto = "Invitación a video entrevista de oferta de empleo Data Solutions";
        $emails = $data->correo;
        $mensaje = "Buen día ".$nombres.",
                    hemos revisado tu perfil y nos gustaría conocerte un poco más, te invitamos a que realices la siguiente video entrevista que un especialista de selección ha preparado para tí, éxitos!
                    ";
          /* return view("admin.enviar_email_candidato_gestion_req", compact("url","nombres", "asunto", "mensaje"));*/
          //dd($nombre);
       Mail::send('admin.enviar_email_candidato_gestion_req', ["url"=>$quitar_seguridad_url,"mensaje" => $mensaje], function($message) use ($data, $emails, $asunto) {
            $message->to($emails, '$nombre - T3RS')->subject($asunto)
            ->getHeaders()
            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });


       return response()->json(["success" => true]);
    }


public function video_respuesta_demostracion(Request $data)
    {
        //dd($data->all());
        $respuesta = DatosTemporales::where('datos_temporales.numero_id',$data->numero_id)
        ->first();
  
        
        return view("admin.sitio.respuesta_demo", compact("respuesta","entrevista_virtual","preguntas_entre"));
    }
   
   


    public function demostracion_llamada_mensaje()
    {
        $sitio = Sitio::first();
        $numero = "57";
        return view("admin.sitio.demostracion_llamada_mensaje", compact('numero','sitio'));
    }
    


    public function envio_llamada_mensaje(Request $data)
    {
         
   //dd($data->all());

         $nuevo_dato_temporal = new DatosTemporales();
         $nuevo_dato_temporal->celular = $data->celular;
         $nuevo_dato_temporal->nombres = $data->nombres;
         $nuevo_dato_temporal->numero_id = $data->numero_id;
         $nuevo_dato_temporal->modulo = "PRUEBA_LLAMADA_VIRTUAL";
         $nuevo_dato_temporal->save();


       $destino = $data->celular;
        $mensaje = $data->mensaje;
        $nombres = $data->nombres;
      
          $this->ValidarSMS($destino,$mensaje,$nombres);
          $this->ValidarLlamada($destino,$mensaje);

       return response()->json(["success" => true]);
    }


    public function ValidarLlamada($destino,$mensaje)
    {
        $url_audio            = route('home') . "/configuracion_sitio/audio.wav";
        $quitar_seguridad_url = str_replace("https://", "http://", $url_audio);

        $url = 'https://go4clients.com:8443/TelintelSms/api/voice/outcall';

        $data = array(
            "from"      => "3195214910",
             "toList" => array(
                    $destino
                    
                  ),

            "callSteps" => array(
                [
                    "type"       => "PLAY",
                    "sourceType" => "URL",
                    "source"     => $quitar_seguridad_url,
                ],
                [
                    "type"    => "DETECT",
                    "options" => array(
                        [
                            "type"        => "OPTION",
                            "dtfmCommand" => "1",
                            "optionId"    => "aceptacion",
                            "steps"       => array(
                                [
                                    "type"         => "SAY",
                                    "text"         => "<Speed=80/> hola. " . $mensaje . " enviaremos la información de la vacante a través de un mensaje de texto. Gracias!  <Speed=END_80/><Speed=80/> hola. " . $mensaje . " enviaremos la información de la vacante a través de un mensaje de texto. Gracias!  <Speed=END_80/>",
                                    "convertVoice" => "CLAUDIA",
                                    "sourceType"   => "STANDARD",
                                ],
                                [
                                    "destination" => "1",
                                    "type"        => "DIAL",
                                ],
                            ),
                        ],

                        [
                            "type"        => "OPTION",
                            "dtfmCommand" => "2",
                            "optionId"    => "rechazo",
                            "steps"       => array(
                                [
                                    "type"         => "SAY",
                                    "text"         => "Muchas gracias por haber atendido nuestra llamada, que pase un buen dia.",
                                    "convertVoice" => "CLAUDIA",
                                    "sourceType"   => "STANDARD",
                                ],
                                [
                                    "destination" => "1",
                                    "type"        => "DIAL",
                                ],
                            ),
                        ],
                    ),
                ],
            ),
        );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data),
                'header'  => array("Host: go4clients.com", "Content-Type: application/json", "Apikey: ca16b4d3626346f39c5fd33f69cb46dc", "Apisecret: 25184841718344"),

            ),
        );

        $context  = stream_context_create($options);
        $result   = file_get_contents($url, false, $context, 0, 40000);
        $response = json_decode($result);
        // dd($response);
    }

    

    public function ValidarSMS($destino,$mensaje,$nombres)
    {
        $url = 'https://go4clients.com/TelintelSms/api/sms/send';

        $data = array(
            'to' => 
                    "57".$destino,

            'message' => "Hola " . $nombres . ", " . $mensaje ,
        );

        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode($data),
                'header'  => array("Host: go4clients.com", "Content-Type: application/json", "Apikey: ca16b4d3626346f39c5fd33f69cb46dc", "Apisecret: 25184841718344"),

            ),
        );

        $lol      = json_encode($data);
        $context  = stream_context_create($options);
        $result   = file_get_contents($url, false, $context);
        $response = json_decode($result);
    }



    /**
     * Guardar o actualizar la información del sitio
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $data, Requests\SitioRequest $valida)
    {

        if ($data->audio) {
              if ($data->id != "")
        {
            $guardar = Sitio::find($data->id);
            $guardar->nombre            = $data->nombre;
            $guardar->celular           = $data->celular;
            $guardar->telefono          = $data->telefono;
            $guardar->email             = $data->email;
            $guardar->web_corporativa   = $data->web_corporativa;
            $guardar->quienes_somos     = $data->quienes_somos;
            $guardar->audio             = $data->audio;
            $guardar->vision            = $data->vision;
            $guardar->mision            = $data->mision;
            $guardar->social_facebook   = $data->social_facebook;
            $guardar->social_twitter    = $data->social_twitter;
            $guardar->social_youtube    = $data->social_youtube;
            $guardar->social_whatsapp   = $data->social_whatsapp;
            $guardar->social_instagram  = $data->social_instagram;
            $guardar->social_linkedin   = $data->social_linkedin;
            $guardar->color             = $data->color;
            $guardar->user_id_creo      =  $this->user->id;
            $guardar->save();
         }  
         else
        {
            $guardar = Sitio::first();
            if ($guardar == null) {
                $guardar = new Sitio();
            }
            $guardar->fill($data->all() + ["user_id_creo" => $this->user->id]);
            $guardar->save();
        }
     }else{

               if ($data->id != "")
        {
            $guardar = Sitio::find($data->id);
            $guardar->nombre            = $data->nombre;
            $guardar->celular           = $data->celular;
            $guardar->telefono          = $data->telefono;
            $guardar->email             = $data->email;
            $guardar->web_corporativa   = $data->web_corporativa;
            $guardar->quienes_somos     = $data->quienes_somos;
            $guardar->vision            = $data->vision;
            $guardar->mision            = $data->mision;
            $guardar->social_facebook   = $data->social_facebook;
            $guardar->social_twitter    = $data->social_twitter;
            $guardar->social_youtube    = $data->social_youtube;
            $guardar->social_whatsapp   = $data->social_whatsapp;
            $guardar->social_instagram  = $data->social_instagram;
            $guardar->social_linkedin   = $data->social_linkedin;
            $guardar->color             = $data->color;
            $guardar->user_id_creo      =  $this->user->id;
            $guardar->save();
         }  
         else
        {
            $guardar = Sitio::first();
            if ($guardar == null) {
                $guardar = new Sitio();
            }
            $guardar->fill($data->all() + ["user_id_creo" => $this->user->id]);
            $guardar->save();
        }
     }
      
      

        if ($data->hasFile("logo")) {
            $archivo   = $data->file('logo');
            $extencion = $archivo->getClientOriginalExtension();
            $fileName  = "logo_cargado.$extencion";
            //ELIMINAR IMAGEN
            if (file_exists("configuracion_sitio/".$fileName)) {
                unlink("configuracion_sitio/".$fileName);
            }
            $logo = Sitio::find($guardar->id);
            $logo->logo = $fileName;
            $logo->save();
            $data->file('logo')->move("configuracion_sitio", $fileName);
        }

         if ($data->hasFile("audio")) {
            $archivo   = $data->file('audio');
            $extencion = $archivo->getClientOriginalExtension();
            $fileName  = "audio.$extencion";
            //ELIMINAR IMAGEN
            if (file_exists("configuracion_sitio/".$fileName)) {
                unlink("configuracion_sitio/".$fileName);
            }
            $logo = Sitio::find($guardar->id);
            $logo->audio = $fileName;
            $logo->save();
            $data->file('audio')->move("configuracion_sitio", $fileName);
        }

         if ($data->hasFile("favicon")) {
            $archivo   = $data->file('favicon');
            $extencion = $archivo->getClientOriginalExtension();
            $fileNameFavicon  = "favicon_cargado.$extencion";
            //ELIMINAR imageantialias(image, enabled)
            if (file_exists("configuracion_sitio/".$fileNameFavicon)) {
                unlink("configuracion_sitio/".$fileNameFavicon);
            }
            $favicon = Sitio::find($guardar->id);
            $favicon->favicon = $fileNameFavicon;
            $favicon->save();
            $data->file('favicon')->move("configuracion_sitio", $fileNameFavicon);
        }

        $mensaje = "Se cargo la información del sitio correctamente.";
        return response()->json(["mensaje_success" => $mensaje, "success" => true]);
    }

}
