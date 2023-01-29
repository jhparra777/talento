<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{FirmaContratos, Sitio, NotificacionTerminacionContrato, DatosBasicos, RequerimientoContratoCandidato, RegistroProceso};
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use triPostmaster;
use Storage;
use App\Jobs\FuncionesGlobales;

class NotificacionTerminacionContratoController extends Controller
{   
    public function enviar_cartas_terminacion_contrato_diarias()
    {   
        $sitio = Sitio::first();

        $dias_notificacion_fin_contrato = isset($sitio->dias_notificacion_fin_contrato) ? $sitio->dias_notificacion_fin_contrato : 30;

        //hacemos los calculos para encontrar la fecha de esa cantidad de dias atras
        $fecha_hoy = Carbon::parse(Carbon::now());

        $fecha_proxima_fin_contrato = $fecha_hoy->addDays($dias_notificacion_fin_contrato)->format('Y-m-d');


        $candidatos = FirmaContratos::join('requerimientos', 'requerimientos.id', '=', 'firma_contratos.req_id')
        ->leftjoin('tipos_contratos', 'tipos_contratos.id', '=', 'requerimientos.tipo_contrato_id')
        ->leftjoin('datos_basicos', 'datos_basicos.user_id', '=', 'firma_contratos.user_id')
        ->leftjoin('tipo_identificacion', 'tipo_identificacion.id', '=', 'datos_basicos.tipo_id')
        ->leftjoin("requerimiento_contrato_candidato", function ($join) {
                $join->on('firma_contratos.req_id', '=', 'requerimiento_contrato_candidato.requerimiento_id')
                    ->on('firma_contratos.user_id', '=', 'requerimiento_contrato_candidato.candidato_id');
                })
        ->where('tipos_contratos.cod_tipo_cont', 'TF') //buscamos que sean contratos de termino fijo
        ->where("firma_contratos.estado", 1)
        ->whereIn("firma_contratos.terminado", [1, 2, 3])
        ->whereRaw('requerimiento_contrato_candidato.id=(select max(requerimiento_contrato_candidato.id) from requerimiento_contrato_candidato where requerimiento_contrato_candidato.candidato_id=firma_contratos.user_id AND requerimiento_contrato_candidato.requerimiento_id=firma_contratos.req_id)')
        ->whereDate('requerimiento_contrato_candidato.fecha_fin_contrato', $fecha_proxima_fin_contrato)
        ->select(
                'datos_basicos.user_id',
                'datos_basicos.email',
                'datos_basicos.nombres',
                'datos_basicos.primer_apellido',
                'datos_basicos.segundo_apellido',
                'datos_basicos.numero_id',
                'datos_basicos.telefono_movil',
                'tipo_identificacion.cod_tipo',
                'requerimiento_contrato_candidato.fecha_fin_contrato',
                'requerimiento_contrato_candidato.requerimiento_candidato_id',
                'firma_contratos.req_id',
                'firma_contratos.id as contrato_id'
                )
        ->get();

        DB::transaction(function () use ($sitio, $candidatos, $fecha_proxima_fin_contrato) {


            $fecha_fin_contrato = $fecha_proxima_fin_contrato;

            foreach( $candidatos as $candidato ) {

                //creamos documento
                $view = \View::make('home.pdf_carta_terminacion_contrato',compact("candidato", "fecha_fin_contrato"))->render();

                $pdf = \App::make('dompdf.wrapper');
                $pdf->loadHTML($view);

                Storage::disk('public')->put('documentos_candidatos/carta_terminacion_contrato_'.$candidato->user_id.'_'.$candidato->req_id.'.pdf',$pdf->output());

                //creamos el registro en la tabla de notificacion
                $notificacion = new NotificacionTerminacionContrato();

                $notificacion->fill([
                            'candidato_id'      => $candidato->user_id,
                            'requerimiento_id'  => $candidato->req_id,
                            'contrato_id'       => $candidato->contrato_id,
                            'correo_candidato'  => $candidato->email,
                            'correos_clientes'  => $sitio->correos_clientes_notificacion_fin_contrato
                        ]);

                $notificacion->save();

                //creamos el proceso para la trazabilidad

                $proceso_carta_terminacion_contrato = new RegistroProceso();
                $proceso_carta_terminacion_contrato->fill([
                    'requerimiento_candidato_id' => $candidato->requerimiento_candidato_id,
                    'estado'                     => config('conf_aplicacion.C_CONTRATADO'),
                    'fecha_inicio'               => date("Y-m-d H:i:s"),
                    //'usuario_envio'              => null,
                    'requerimiento_id'           => $candidato->req_id,
                    'candidato_id'               => $candidato->user_id,
                    'observaciones'              => "Envío de carta de notificación de terminación de contrato",
                    'proceso'                    => "NOTIFICACION_TERMINACION_CONTRATO",
                    'apto'                       => 1
                ]);

                $proceso_carta_terminacion_contrato->save();

                $ruta = route("view_document_url", encrypt("documentos_candidatos/|carta_terminacion_contrato_{$candidato->user_id}_{$candidato->req_id}.pdf"));

                //Envío de whatsapp
                $destino = env("INDICATIVO", "57").$candidato->telefono_movil;

                $message = "Buen día apreciado colaborador, por la presente nos permitimos darle previo aviso a la terminación de su contrato a término fijo. En el documento adjunto encontrará toda la información relacionada.";

                event(new \App\Events\NotificationWhatsappEvent("message", [
                    "phone" =>$destino,
                    "body"  =>$message]));

                //enviamos el archivo carta de terminacion
                $nombre_archivo = "carta_terminacion_contrato.pdf";
                event(new \App\Events\NotificationWhatsappEvent("file", [
                    "phone"     => $destino, 
                    "body"      => $ruta, 
                    "filename"  => $nombre_archivo,
                    "caption"   => "Carta de terminación de contrato"]));

                //enviamos correo a candidato y correos cliente
                $otros_destinatarios = explode(",", $sitio->correos_clientes_notificacion_fin_contrato);

                $asunto = "Notificación terminación de contrato";

                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                $mailTitle = $asunto; //Titulo o tema del correo

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = 'Buen día apreciado colaborador, por la presente nos permitimos darle previo aviso a la terminación de su contrato a término fijo. Haga clic en el botón "Visualizar carta" donde encontrará toda la información relacionada.';
                
                //Arreglo para el botón
                $mailButton = ['buttonText' => 'Visualizar carta', 'buttonRoute' => $ruta];

                $mailUser = $candidato->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($candidato, $asunto, $sitio, $otros_destinatarios) {
                            
                            $message->to($candidato->email);
                            
                            if( is_array($otros_destinatarios) )
                                $message->cc($otros_destinatarios);

                            $message->subject($asunto)
                            ->bcc($sitio->email_replica)
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });
            }
        });


        
    }

    public function modal_enviar_carta_terminacion_contrato(Request $request)
    {
        $user_id = $this->user->id;
        $contrato_id = $request->contrato_id;

        $candidato = FirmaContratos::join('datos_basicos', 'datos_basicos.user_id', '=', 'firma_contratos.user_id')
                ->where('firma_contratos.id', $contrato_id)
                ->select('datos_basicos.nombres', 'datos_basicos.primer_apellido', 'datos_basicos.segundo_apellido')
                ->first();

        return view("admin.contratacion.modal.notificacion_terminacion_contrato", compact("contrato_id", "candidato"));
    }

    public function envio_carta_terminacion_contrato(Request $request)
    {
        $contrato = FirmaContratos::find($request->contrato_id);

        $usuario_gestiona = $this->user;

        DB::transaction(function () use ($contrato, $usuario_gestiona, $request) {

            $sitio = Sitio::first();

            $candidato = DatosBasicos::join('tipo_identificacion', 'tipo_identificacion.id', '=', 'datos_basicos.tipo_id')
            ->where('user_id', $contrato->user_id)
            ->select('datos_basicos.*', 'tipo_identificacion.cod_tipo')
            ->first();

            $req_contrato_candidato = RequerimientoContratoCandidato::where('candidato_id', $contrato->user_id)->where('requerimiento_id', $contrato->req_id)->orderBy('id', 'DESC')->first();

            $fecha_fin_contrato = '';

            if ( $req_contrato_candidato != null && $req_contrato_candidato->fecha_fin_contrato != null) {
                
                $fecha_fin_contrato =  $req_contrato_candidato->fecha_fin_contrato;
            }

            //creamos documento
            $view = \View::make('home.pdf_carta_terminacion_contrato',compact("candidato", "fecha_fin_contrato"))->render();

            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);

            Storage::disk('public')->put('documentos_candidatos/carta_terminacion_contrato_'.$contrato->user_id.'_'.$contrato->req_id.'.pdf',$pdf->output());

            //creamos el registro en la tabla de notificacion
            $notificacion = new NotificacionTerminacionContrato();

            $notificacion->fill([
                        'candidato_id'      => $contrato->user_id,
                        'requerimiento_id'  => $contrato->req_id,
                        'contrato_id'       => $contrato->id,
                        'usuario_envio'     => $usuario_gestiona->id,
                        'correo_candidato'  => $request->has('candidato') ? $candidato->email : null,
                        'correos_clientes'  => $request->otros_destinatarios
                    ]);

            $notificacion->save();

            //creamos el proceso para la trazabilidad

            $proceso_carta_terminacion_contrato = new RegistroProceso();
            $proceso_carta_terminacion_contrato->fill([
                'requerimiento_candidato_id' => $req_contrato_candidato->requerimiento_candidato_id,
                'estado'                     => config('conf_aplicacion.C_CONTRATADO'),
                'fecha_inicio'               => date("Y-m-d H:i:s"),
                'usuario_envio'              => $usuario_gestiona->id,
                'requerimiento_id'           => $contrato->req_id,
                'candidato_id'               => $contrato->user_id,
                'observaciones'              => "Envío de carta de notificación de terminación de contrato",
                'proceso'                    => "NOTIFICACION_TERMINACION_CONTRATO",
                'apto'                       => 1
            ]);

            $proceso_carta_terminacion_contrato->save();


            $email_candidato = null;

            $ruta = route("view_document_url", encrypt("documentos_candidatos/|carta_terminacion_contrato_{$contrato->user_id}_{$contrato->req_id}.pdf"));

            //enviamos notificacion por whatsApp y email
            if ( $request->has('candidato') ) {
               
               //Envío de whatsapp
                $destino = env("INDICATIVO", "57").$candidato->telefono_movil;

                $message = "Buen día apreciado colaborador, por la presente nos permitimos darle previo aviso a la terminación de su contrato a término fijo. En el documento adjunto encontrará toda la información relacionada.";

                event(new \App\Events\NotificationWhatsappEvent("message", [
                    "phone" =>$destino,
                    "body"  =>$message]));

                //enviamos el archivo
                $nombre_archivo = "carta_terminacion_contrato.pdf";
                event(new \App\Events\NotificationWhatsappEvent("file", [
                    "phone"     => $destino, 
                    "body"      => $ruta, 
                    "filename"  => $nombre_archivo,
                    "caption"   => "Carta de terminación de contrato"]));
                //para enviar correo
                $email_candidato = $candidato->email;
            }

            if ( $email_candidato != null || $request->otros_destinatarios != "" ) {
                
                if( $request->otros_destinatarios != "" ){

                    $otros_destinatarios = explode(",", $request->otros_destinatarios);
                }else{
                    $otros_destinatarios = null;
                }

                $asunto = "Notificación terminación de contrato";

                $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                $mailConfiguration = 1; //Id de la configuración
                $mailTitle = $asunto; //Titulo o tema del correo

                //Cuerpo con html y comillas dobles para las variables
                $mailBody = 'Buen día apreciado colaborador, por la presente nos permitimos darle previo aviso a la terminación de su contrato a término fijo. Haga clic en el botón "Visualizar carta" donde encontrará toda la información relacionada.';
                
                //Arreglo para el botón
                $mailButton = ['buttonText' => 'Visualizar carta', 'buttonRoute' => $ruta];

                $mailUser = $candidato->user_id; //Id del usuario al que se le envía el correo

                $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($email_candidato, $asunto, $sitio, $otros_destinatarios) {
                        if( $email_candidato != null ){
                            $message->to($email_candidato);
                            if( is_array($otros_destinatarios) )
                                $message->cc($otros_destinatarios);
                        }else{
                            if( is_array($otros_destinatarios) )
                                $message->to($otros_destinatarios);
                        }
                            $message->subject($asunto)
                            ->bcc($sitio->email_replica)
                            ->getHeaders()
                            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                });

            }

        });

        return response()->json(['success' => true]);
    }

    public function reporte(Request $request)
    {
        $headers   = $this->getHeaderDetalle();
        $data      = $this->getDataDetalle($request);

        return view('admin.reportes.contratos_termino_fijo.index')->with([
            'headers'   => $headers,
            'data'      => $data
        ]);
    }

    private function getHeaderDetalle($isExcel = false)
    {
        $headers = [
            'Número req',
            'Fecha de creación del req',
            'Tipo de proceso',
            'Agencia',
            'Ciudad de trabajo',
            'Cliente',
            'Cargo',
            'Tipo identificación',
            'N° Identificación contratado',
            'Nombre contratado',
            'Celular contratado',
            'Fecha de ingreso',
            'Fecha fin contrato',
            'Fecha de envío a contratación',
            'Fecha de firma de contrato',
            'Estado de contrato',
            'Usuario que solicitó contratación',
            'Notificación finalización contrato'
        ];

        if ( !$isExcel ) {
            $headers[] = 'Acción';
        }
        

        return $headers;
    }

    private function getDataDetalle($request)
    {
        $formato      = ($request['formato']) ? $request['formato'] : 'html';

        $generar_datos = $request['generar_datos'];

        $notificacion_enviada = $request['notificacion_enviada'];

        $rango = "";
        if($request['rango_fecha_fin_contrato'] != ""){
            $rango = explode(" | ", $request['rango_fecha_fin_contrato']);
            $fecha_inicio_fin_contrato = $rango[0];
            $fecha_final_fin_contrato  = $rango[1];
        }

        $rango_fecha_firma = "";
        if($request['rango_fecha_firma'] != ""){
            $rango_fecha_firma = explode(" | ", $request['rango_fecha_firma']);
            $fecha_inicio_firma = $rango_fecha_firma[0];
            $fecha_final_firma  = $rango_fecha_firma[1];
        }

        $rango_fecha_ingreso = "";
        if($request['rango_fecha_ingreso'] != ""){
            $rango_fecha_ingreso = explode(" | ", $request['rango_fecha_ingreso']);
            $fecha_inicio_ingreso = $rango_fecha_ingreso[0];
            $fecha_final_ingreso  = $rango_fecha_ingreso[1];
        }

        
        $data = "";

        if($fecha_inicio_fin_contrato != '' || $fecha_final_fin_contrato != '' || $fecha_inicio_firma != '' || $fecha_final_firma != '' || $fecha_inicio_ingreso != '' || $fecha_final_ingreso != '' || $notificacion_enviada != ''){

            $data = FirmaContratos::join('requerimientos', 'requerimientos.id', '=', 'firma_contratos.req_id')
            ->join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
            ->join('datos_basicos', 'datos_basicos.user_id', '=', 'firma_contratos.user_id')
            ->join('tipo_proceso', 'tipo_proceso.id', '=', 'requerimientos.tipo_proceso_id')
            ->join('negocio', 'negocio.id', '=', 'requerimientos.negocio_id')
            ->join('clientes', 'clientes.id', '=', 'negocio.cliente_id')
            ->join('estados_requerimiento', 'estados_requerimiento.req_id', '=', 'requerimientos.id')
            ->leftjoin('tipos_contratos', 'tipos_contratos.id', '=', 'requerimientos.tipo_contrato_id')
            ->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
            })
            ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
            ->leftjoin('estados', 'estados.id', '=', 'estados_requerimiento.estado')
            ->leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            ->leftjoin("requerimiento_contrato_candidato", function ($join) {
                $join->on('firma_contratos.req_id', '=', 'requerimiento_contrato_candidato.requerimiento_id')
                    ->on('firma_contratos.user_id', '=', 'requerimiento_contrato_candidato.candidato_id');
                })
            //->leftjoin('notificaciones_terminacion_contratos', 'notificaciones_terminacion_contratos.contrato_id', '=', 'firma_contratos.id')
            ->where('tipos_contratos.cod_tipo_cont', 'TF') //buscamos que sean contratos de termino fijo
            ->where("firma_contratos.estado", 1)
            ->whereIn("firma_contratos.terminado", [1, 2, 3])
            ->whereRaw('estados_requerimiento.id = (SELECT MAX(estados_requerimiento.id) FROM estados_requerimiento where estados_requerimiento.req_id = requerimientos.id)')
            ->whereRaw('requerimiento_contrato_candidato.id=(select max(requerimiento_contrato_candidato.id) from requerimiento_contrato_candidato where requerimiento_contrato_candidato.candidato_id=firma_contratos.user_id AND requerimiento_contrato_candidato.requerimiento_id=firma_contratos.req_id)')
            ->where(function ($query) use ($fecha_inicio_fin_contrato, $fecha_final_fin_contrato,$fecha_inicio_firma, $fecha_final_firma, $fecha_inicio_ingreso, $fecha_final_ingreso, $notificacion_enviada) {
                
                if ($fecha_inicio_firma != '' && $fecha_final_firma != '') {
                    $query->whereBetween("firma_contratos.fecha_firma", [$fecha_inicio_firma . ' 00:00:00', $fecha_final_firma . ' 23:59:59']);
                }

                if ($fecha_inicio_ingreso != '' && $fecha_final_ingreso != '') {
                    $query->whereBetween('requerimiento_contrato_candidato.fecha_ingreso', [$fecha_inicio_ingreso, $fecha_final_ingreso]);
                }

                if ($fecha_inicio_fin_contrato != '' && $fecha_final_fin_contrato != '') {
                    $query->whereBetween('requerimiento_contrato_candidato.fecha_fin_contrato', [$fecha_inicio_fin_contrato, $fecha_final_fin_contrato]);
                }

                if ( $notificacion_enviada != '' ) {
                    if ( $notificacion_enviada == 0 ) {
                        $query->whereNull(DB::raw('(SELECT notificaciones_terminacion_contratos.created_at FROM notificaciones_terminacion_contratos WHERE notificaciones_terminacion_contratos.contrato_id = firma_contratos.id LIMIT 1)'));
                    }else if( $notificacion_enviada == 1 ){
                        $query->whereNotNull(DB::raw('(SELECT notificaciones_terminacion_contratos.created_at FROM notificaciones_terminacion_contratos WHERE notificaciones_terminacion_contratos.contrato_id = firma_contratos.id LIMIT 1)'));
                    }
                }

            })
            ->select(
                'requerimientos.id as numero_req',
                'requerimientos.sitio_trabajo as ciudad_trabajo',
                'requerimientos.created_at as fecha_creacion_req',
                DB::raw('CONCAT(datos_basicos.nombres, " ", datos_basicos.primer_apellido, " ", datos_basicos.segundo_apellido) AS nombre_completo'),
                'datos_basicos.numero_id as cedula',
                'datos_basicos.user_id as candidato_id',
                'datos_basicos.telefono_movil as numero_celular',
                DB::raw('(SELECT CONCAT(datos_basicos.nombres, " ", datos_basicos.primer_apellido, " ", datos_basicos.segundo_apellido) FROM datos_basicos WHERE datos_basicos.user_id = firma_contratos.gestion) as nombre_completo_gestion'),
                'cargos_especificos.descripcion as cargo',
                'firma_contratos.fecha_firma as fecha_firma_contrato',
                'firma_contratos.terminado as estado_contrato',
                'firma_contratos.created_at as fecha_envio_contrato',
                'firma_contratos.estado as estado_global',
                'firma_contratos.id as contrato_id',
                'clientes.nombre as cliente',
                'tipo_proceso.descripcion as tipo_proceso',
                'estados.descripcion as estado_requerimiento',
                'requerimiento_contrato_candidato.fecha_ingreso',
                'requerimiento_contrato_candidato.fecha_fin_contrato',
                'agencias.descripcion as agencia',
                'tipo_identificacion.descripcion as tipo_identificacion',
                DB::raw("(SELECT GROUP_CONCAT('<strong>Fecha:</strong>',created_at,'<br>',IF(correo_candidato is not null,CONCAT('<strong>Candidato:</strong>', correo_candidato),''),' <br/>',IF(correos_clientes is not null or correos_clientes!='',CONCAT('<strong>Otros destinatarios:</strong>', correos_clientes),'') SEPARATOR '* ') FROM notificaciones_terminacion_contratos WHERE notificaciones_terminacion_contratos.contrato_id = firma_contratos.id ) as notificacion_finalizacion_contrato")
                //'notificaciones_terminacion_contratos.created_at as fecha_notificacion_fin_contrato'
            )
            ->groupBy('firma_contratos.id');
        } else if (isset($generar_datos)) {
            session()->flash('mensaje_warning', 'Debe ingresar por lo menos 1 filtro');
        }



        if($data != ""){
            if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
                $data = $data->get();
            }else{
                $data = $data->paginate(6);
            }
        }

        return $data;
    
    }

    public function reporteExcel(Request $request)
    {
        $headers = $this->getHeaderDetalle(true);
        $data    = $this->getDataDetalle($request->all());
        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales;

        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-contratos-a-termino-fijo', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Contratos A Término Fijo');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Contratos A Término Fijo');
            $excel->sheet('Contratos A Término Fijo', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.contratos_termino_fijo.grilla_detalle', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }
}
