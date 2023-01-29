<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Contracts\Mail\Mailer;
use App\Models\CargoEspecifico;
use App\Models\Requerimiento;
use App\Models\Sitio;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
//Helper
use triPostmaster;



class SendPostCreateReqEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
            
    private $data;
    private $pais_id;
    private $departamento_id;
    private $ciudad_id;
    private $notificacion_requisicion=1;
    private $cargo_especifico;
    private $requerimiento;
    private $roles_id;
    

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CargoEspecifico $cargo_especifico, Requerimiento $requerimiento, $dataView, $roles_id = [3, 5, 17])
    {
      //dd($dataView);
        $this->data = $dataView;
        $this->pais_id = $this->data['pais_id'];
        $this->departamento_id = $this->data['departamento_id'];
        $this->ciudad_id = $this->data['ciudad_id'];
        $this->cargo_especifico = $cargo_especifico;
        $this->requerimiento = $requerimiento;
        $this->roles_id = $roles_id;
        
    }

    /**
     * Execute the job.
     * 
     * @return void
     */
    public function handle(Mailer $mail)
    {
        $sitio = Sitio::first();
        $emails = [];

        if($sitio->agencias){
            $agencia = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
                ->join("ciudad", function($sql){
                    $sql->on("ciudad.cod_ciudad","=", "requerimientos.ciudad_id")
                        ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id")
                        ->on("ciudad.cod_pais","=","requerimientos.pais_id");
                })
                ->where("requerimientos.id", $this->requerimiento->id)
                ->select(
                    "ciudad.agencia as agencia",
                    "negocio.cliente_id"
                )
            ->first();

            $emails = User::join("agencia_usuario", "agencia_usuario.id_usuario", "=", "users.id")
                ->join('users_x_clientes','users_x_clientes.user_id','=','users.id')
                ->join("role_users", "role_users.user_id", "=", "users.id")
                ->whereIn("role_users.role_id", $this->roles_id)
                ->where("users_x_clientes.cliente_id", $agencia->cliente_id)
                ->where("agencia_usuario.id_agencia", $agencia->agencia)
                ->where("users.notificacion_requisicion", 1)
                ->select(
                    "role_users.role_id as rol_id",
                    "users.email as email",
                    "users.name as nombres",
                    "users.id as user_id"
                )
                ->groupBy("users.id")
            ->get();
        } else {
            $emails = User::join('users_x_clientes','users_x_clientes.user_id','=','users.id')
                ->join("role_users", "role_users.user_id", "=", "users.id")
                ->whereIn("role_users.role_id", $this->roles_id)
                ->where("users_x_clientes.cliente_id", $this->requerimiento->cliente())
                ->where("users.notificacion_requisicion", 1)
                ->select(
                    "role_users.role_id as rol_id",
                    "users.email as email",
                    "users.name as nombres",
                    "users.id as user_id"
                )
                ->groupBy("users.id")
            ->get();
        }

        $nombre = "Desarrollo";
        if (isset($sitio->nombre) && $sitio->nombre != "") {
            $nombre = $sitio->nombre;
        }

        $requerimiento_id = $this->requerimiento->id;

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Notificación Nuevo Requerimiento"; //Titulo o tema del correo

        $ciudad = $this->requerimiento->getNombreCiudad()->ciudad;
        $solicitud = $this->requerimiento->getDescripcionTipoProceso();

        foreach ($emails as $key => $value) {
            try{
                //Cuerpo con html y comillas dobles para las variables
                $mailBody = "
                    Hola $value->nombres: <br/><br/>
                    Te informamos que {$this->data['solicitado_por']} a cargo de tu cliente {$this->requerimiento->empresa()->nombre}, ha creado un nuevo requerimiento:
                    <br/><br/>

                    <ul>
                        <li>Requerimiento: <b>{$this->requerimiento->id}</b></li>
                        <li>Cargo: <b>{$this->cargo_especifico->descripcion}</b></li>
                        <li>Ciudad: <b>{$ciudad}</b></li>
                        <li>Tipo Solicitud: <b>{$solicitud}</b></li>
                    </ul>

                    Para visualizar los detalles del requerimiento haz clic en el botón " . ($value->rol_id == 3 ? "“Detalle”" : "“Gestionar”");

                //Arreglo para el botón
                if ($value->rol_id == 3) {
                    $mailButton = ['buttonText' => 'DETALLE', 'buttonRoute' => route("req.detalle_requerimiento", ['req_id' => $requerimiento_id])];
                } else {
                    $mailButton = ['buttonText' => 'GESTIONAR', 'buttonRoute' => route("admin.gestion_requerimiento", ['req_id' => $requerimiento_id])];
                }

                $mailUser = $value->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($value, $requerimiento_id, $nombre) {

                    $message->to($value->email,"$nombre - T3RS")
                        ->subject('Nueva requisición No. '.$requerimiento_id )
                        ->getHeaders()
                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            } catch (\Exception $e) {
                logger('Excepción capturada en SendPostCreateReqEmail al enviar correo de creacion de Requerimiento: '.  $e->getMessage(). "\n");
            }
        }
    }
}
