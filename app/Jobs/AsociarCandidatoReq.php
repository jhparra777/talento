<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Jobs\FuncionesGlobales;
use App\Models\User;
use App\Models\DatosBasicos;
use App\Models\Requerimiento;
use App\Models\ReqCandidato;
use App\Models\RegistroProceso;
use App\Models\CandidatosFuentes;
use App\Models\Sitio;
use App\Models\DocumentosCargo;
use App\Models\TipoDocumento;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use triPostmaster;

class AsociarCandidatoReq extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $usuarios;
    protected $requerimientos;
    protected $data;
    protected $who;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data,$who)
    {
        $this->data = $data;
        $this->who = $who;
       
    }

    /**
     * Created by: Vilfer Alvarez
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $sitio = Sitio::first();

        $nombre = "Desarrollo";
        if($sitio->nombre != "") {
            $nombre = $sitio->nombre;
        }

        $data1=$this->data;
        $who=$this->who;
        $asociar = collect($data1)->filter(function ($value){
            return $value["req_id"];
        });

        $req_unicos=array_unique($asociar->pluck("req_id")->toArray());
        $candidatos=array_unique($asociar->pluck("candi_id")->toArray());
        
        //$errores=[];
        //$req_unicos=array_unique($this->requerimientos);
        //Verificar requerimientos
        $req_no = Requerimiento::join("estados_requerimiento","estados_requerimiento.req_id","=","requerimientos.id")
            ->join("estados","estados.id","=","estados_requerimiento.estado")
            ->whereIn("estados_requerimiento.estado",[ 
                config('conf_aplicacion.C_INACTIVO'),
                config('conf_aplicacion.C_TERMINADO'),
                config('conf_aplicacion.C_CLIENTE'),
                config('conf_aplicacion.C_SOLUCIONES'),])
            ->whereIn("requerimientos.id",$req_unicos)
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            //->select("requerimientos.id as req")
            ->pluck("requerimientos.id")
        ->toArray();

            
        //Verificar candidatos asociados
        
        $exis_req = ReqCandidato::whereNotIn("requerimiento_cantidato.estado_candidato", [config('conf_aplicacion.C_QUITAR'), config('conf_aplicacion.C_INACTIVO'),23])
            ->whereIn("candidato_id",$candidatos)
            //->select("candidato_id")
            ->groupBy("candidato_id")
            ->pluck("candidato_id")
        ->toArray();
            //->select("candidato_id")

        //$combinado=array_combine($this->usuarios,$this->requerimientos);

        foreach($data1 as &$value) {

            if ($value["error"]==null) {

                //ENVIAR EMAIL REGISTRO
                if($value["envio_email_registro"]){
                    $datos=$value["datos_basicos"];
                    try{

                        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                        $mailConfiguration = 1; //Id de la configuración
                        $mailTitle = "Bienvenido a {$nombre} - T3RS"; //Titulo o tema del correo

                        //Cuerpo con html y comillas dobles para las variables
                        $mailBody = "
                                ¡Hola $datos->nombres $datos->primer_apellido $datos->segundo_apellido!<br>
                                Se ha creado exitosamente tu cuenta en T3RS, te invitamos a ingresar usando tu número de documento como usuario y contraseña para completar tu hoja de vida y cargar tus documentos.
                                ";
                        //Arreglo para el botón
                        $mailButton = ['buttonText' => '¡COMPLETA TU HOJA DE VIDA!', 'buttonRoute' => route('login')];

                        $mailUser = $datos->user_id; //Id del usuario al que se le envía el correo

                        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                        Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datos, $nombre) {

                            $message->to($datos->email, $datos->nombres)
                                ->subject("Bienvenido a $nombre - T3RS")
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                        });

                    } catch(\Exception $e) {
                        logger('Excepción capturada en AsociarCandidatoReq al enviar correo de Bienvenida: '.  $e->getMessage(). "\n");
                    }
                }

                if (in_array($value["req_id"],$req_no)) {
                   $value["asociacion"]="No, requerimiento no está abierto.";
                } elseif (in_array($value["candi_id"],$exis_req)) {

                    $candidatos_fuentes = CandidatosFuentes::firstOrCreate(
                        ["cedula"           => $value["cedula"],
                        "requerimiento_id" => $value["req_id"]],
                        [
                        "nombres"          => $value["nombres"]. " ".$value["primer_apellido"],
                        
                        "telefono"         => $value["telefono"],
                        "celular"          => $value["telefono"],
                        "email"            => $value["email"],
                        "tipo_fuente_id"   => 11
                        
                    ]);
                    $value["asociacion"]="Otras fuentes";

                } else {
                    $req_can = new ReqCandidato();

                    $req_can ->fill([
                        'requerimiento_id'    =>$value["req_id"],
                        'candidato_id'        =>$value["candi_id"],
                        'estado_candidato'    =>config('conf_aplicacion.C_EN_PROCESO_SELECCION')
                    ]);

                    $req_can->save();

                    /*$datos_basicos_2=DatosBasicos::where('numero_id',$value->identificacion)->first();
                    $candidato  = DatosBasicos::where("user_id", $datos_basicos_2->user_id)->first();*/

                    DatosBasicos::where('numero_id', $value["cedula"])
                        ->update(['estado_reclutamiento' => config('conf_aplicacion.C_EN_PROCESO_SELECCION')]);


                    $req_can_id = $req_can->id;

                    $nuevo_proceso = new RegistroProceso();

                    $nuevo_proceso->fill([
                        'requerimiento_candidato_id' => $req_can_id,
                        'estado'        => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        'fecha_inicio'               => date("Y-m-d H:i:s"),
                        'usuario_envio'              => $who->id,
                        'proceso'                    => 'ASIGNADO_REQUERIMIENTO',
                        'requerimiento_id'           => $value["req_id"],
                        'candidato_id'               => $value["candi_id"],
                        'observaciones'              => "Ingreso al requerimiento",
                    ]);

                    $nuevo_proceso->save();

                    $obj                   = new \stdClass();
                    $obj->requerimiento_id = $value["req_id"];
                    $obj->user_id          = $who->id;
                    $obj->estado           = config('conf_aplicacion.C_EN_PROCESO_SELECCION');

                    $value["asociacion"]="Asociado correctamente";

                    Event::dispatch(new \App\Events\EstadosRequerimientoEvent($obj));

                    try {

                        $cargo_esp = DB::table("cargos_especificos")->join("requerimientos", "requerimientos.cargo_especifico_id","=", "cargos_especificos.id")
                            ->leftjoin("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
                            ->where("requerimientos.id", $value["req_id"])
                            ->select(
                                "cargos_especificos.id as cargo",
                                "cargos_especificos.firma_digital as firma",
                                "tipo_proceso.cod_tipo_proceso"
                            )
                        ->first();

                        if (!empty($cargo_esp) && $cargo_esp->cod_tipo_proceso != 'PB') {
                            //Si el codigo de tipo de proceso es distinto de Proceso Backup (PB)
                            $cargo_documentos = null;
                            if ($sitio->asistente_contratacion == 1 && $cargo_esp->firma == 1){
                                //Si el sitio tiene asistente y el cargo tiene firma digital, se buscan los documentos asociados al cargo categoria 1 y que pueda cargar el candidato
                                $cargo_documentos = DocumentosCargo::join('tipos_documentos','tipos_documentos.id','=','cargo_documento.tipo_documento_id')
                                    ->where('cargo_documento.cargo_especifico_id', $cargo_esp->cargo)
                                    ->where('tipos_documentos.categoria', 1)
                                    ->where('tipos_documentos.carga_candidato', 1)
                                    ->select(
                                        'tipos_documentos.id',
                                        'tipos_documentos.descripcion'
                                    )
                                ->get();

                                if (count($cargo_documentos) == 0) {
                                    //En caso que el cargo no tenga asociados tipos de documento mostrar listados los tipos de documento con cod_tipo_doc=CC
                                    $cargo_documentos = TipoDocumento::where('cod_tipo_doc', 'CC')
                                        ->where('tipos_documentos.categoria', 1)
                                        ->where('tipos_documentos.carga_candidato', 1)
                                        ->select(
                                            'tipos_documentos.id',
                                            'tipos_documentos.descripcion'
                                        )
                                    ->get();
                                }
                            }

                            $nombre_empresa = "Desarrollo";
                            if (isset($sitio->nombre) && $sitio->nombre != "") {
                                $nombre_empresa = $sitio->nombre;
                            }

                            //**************correo de asocian candidato a requerimiento***********************
                            $home = route('home');
                            $urls = route('home.detalle_oferta', ['oferta_id' => $value["req_id"]]);

                            $nombre = ucwords(strtolower($value["nombres"]." ".$value["primer_apellido"]));

                            $asunto = "Notificación de proceso de selección";

                            $emails = $value["email"];

                            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                            $mailConfiguration = 1; //Id de la configuración
                            $mailTitle = "Notificación de Proceso de Selección"; //Titulo o tema del correo

                            //Cuerpo con html y comillas dobles para las variables
                            $mailBody = '¡Hola, '.$nombre.'!
                                <br/><br/>
                                Es un gusto para nosotros que seas parte de este proceso de selección, haz clic en el siguiente botón, donde podrás encontrar la información de la vacante.
                                <br/><br/>
                                <b>¡Éxitos!</b>';

                            //Arreglo para el botón
                            $mailButton = ['buttonText' => 'OFERTA LABORAL', 'buttonRoute' => $urls];

                            $mailUser = $value["candi_id"]; //Id del usuario al que se le envía el correo

                            if (is_null($cargo_documentos)) {

                                $mailAditionalTemplate = [];

                            }else{

                                $mailAditionalTemplate = ['nameTemplate' => 'proceso_seleccion', 'dataTemplate' => ["cargo_documentos" => $cargo_documentos]];
                            }

                            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser, $mailAditionalTemplate);

                            if (route('home') == 'https://listos.t3rsc.co') {
                                Mail::send('admin.enviar_email_candidatos_otras_fuentes_listos', [
                                    "home" => $home,
                                    "cargo_documentos" => $cargo_documentos,
                                    "url" => $urls,
                                    "req_can_id" => $req_can_id,
                                    "nombre" => $nombre
                                ], function($message) use ($data, $emails, $asunto, $sitio) {
                                    $message->to($emails, '$nombre - T3RS');
                                    $message->subject($asunto)
                                    ->bcc($sitio->email_replica)
                                    ->getHeaders()
                                    ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                                });
                            }else{
                                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use ($emails, $asunto, $nombre_empresa, $sitio) {

                                    $message->to($emails, "$nombre_empresa - T3RS");
                                    $message->subject($asunto)
                                        ->bcc($sitio->email_replica)
                                        ->getHeaders()
                                        ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                                });
                            }
                        }

                    } catch (\Exception $e) {
                        logger('Excepción capturada en AsociarCandidatoReq al enviar correo de notificacion de asociacion al requerimiento: '.  $e->getMessage(). "\n");
                    }
                }
            }
        }


        $headers=[
            "Cedula",
            "Registro",
            "Asociacion",
            "Req",
            "Errores"
        ];


        $archivo=Excel::create('reporte-carga-masiva', function ($excel) use ($data1, $headers) {
            $excel->setTitle('Reporte carga masiva');
            $excel->setCreator('T3RS')
                ->setCompany('T3RS');
            $excel->setDescription('Reporte carga masiva');
            $excel->sheet('ReporteGestion', function ($sheet) use ($data1, $headers) {
                //$sheet->setOrientation("landscape");
                $sheet->loadView('admin.citacion.proceso_recluta.carga_masiva.reporte_carga_masiva', [
                    'data'    => $data1,
                    'headers' => $headers
                ]);
            });
        });

        Mail::send('admin.citacion.proceso_recluta.carga_masiva.emails.email_carga_masiva',[], function ($message) use($archivo,$who){
            
            $message->attach($archivo->store('xlsx', false, true)['full'])->to($who->email,"T3RS")->subject("Resultados de carga masiva");
            
            //->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });


    }
}
