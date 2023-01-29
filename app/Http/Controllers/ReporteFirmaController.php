<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Jobs\FuncionesGlobales;
use App\Models\Agencia;
use App\Models\CargoGenerico;
use App\Models\DataEmailEnviados;
use App\Models\Ciudad;
use App\Models\Clientes;
use App\Models\FirmaContratos;
use App\Models\User;
use App\Models\Sitio;

class ReporteFirmaController extends Controller
{
    protected function sinClientesPruebas(&$ids_clientes_prueba) {
        $sitio = Sitio::first();
        if ($sitio->filtro_cliente == 'enabled' && $sitio->clientes_prueba_id != null && $sitio->clientes_prueba_id != '') {
            $ids_clientes_prueba = explode(",", $sitio->clientes_prueba_id);
            return true;
        }
        return false;
    }

    /*
    *   Retorna la vista para consultar reporte
    */
    public function index(Request $request)
    {
        $areas = array();

        $clientes  = ["" => "Seleccionar"] + Clientes::where('firma_digital', 1)->orderBy('nombre', 'ASC')->pluck("clientes.nombre", "clientes.id")->toArray();
        $cargos    = ["" => "Seleccionar"] + CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();
        $ciudad    = ["" => "Seleccionar"] + Ciudad::pluck("nombre", "id")->toArray();

        $usuarios = ["" => "Seleccionar"] + User::join("role_users", "users.id", "=", "role_users.user_id")
        ->whereIn("role_users.role_id", [4, 7])
        ->pluck("users.name", "users.id")
        ->toArray();

        $agencias = ["" => "Seleccionar"] + Agencia::pluck("agencias.descripcion", "agencias.id")->toArray();
    
        $headers   = $this->getHeaderDetalle();
        $data      = $this->getDataDetalle($request);

        return view('admin.reportes.reporte_firma.index')->with([
            'areas'     => $areas,
            'clientes'  => $clientes,
            'cargos'    => $cargos,
            'ciudad'    => $ciudad,
            'usuarios'  => $usuarios,
            'agencias'  => $agencias,
            'headers'   => $headers,
            'data'      => $data
        ]);
    }

    /*
    *   Genera exportación de archivo excel
    */
    public function firmaDigitalExcel(Request $request)
    {
        $headers = $this->getHeaderDetalle();
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

        Excel::create('reporte-firma-digital', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Firma Digital');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Firma Digital');
            $excel->sheet('Reporte Firma Digital', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.reporte_firma.include.grilla_detalle_firmas', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    /*
    *   Define cabeceras para tabla o archivo excel
    */
    private function getHeaderDetalle()
    {
        $headers = [
            'Número req',
            'Fecha de creación del req',
            'Tipo de proceso',
            'Agencia',
            'Ciudad de trabajo',
            'Cliente',
            'Cargo',
            'Cargo genérico',
            'Tipo identificación',
            'N° Identificación contratado',
            'Nombre contratado',
            'Celular contratado',
            //'¿Solicitud de confirmación en video?',
            'Fecha de ingreso',
            'Fecha de envío a contratación',
            'Fecha de firma de contrato',
            'Estado de contrato',
            'Motivo anulación',
            '¿Grabó video?',
            'Fecha que grabó video',
            'Usuario que solicitó contratación',
            'Confirmación de contratación',
            //'Confirmación a otros destinatarios',
            'Estado del requerimiento'
        ];
        

        return $headers;
    }

    /*
    *   Contenido de tabla o archivo excel
    */
    private function getDataDetalle($request)
    {
        $num_req      = '';
        $negocio_id    = '';
        $formato      = ($request['formato']) ? $request['formato'] : 'html';
        $area1 = '';

        $fecha_inicio_firma = $request['fecha_inicio_firma'];
        $num_req      = $request['num_req'];
        $cliente_id   = $request['cliente_id'];
        $usuario      = $request['usuario_gestion'];
        $agencia      = $request['agencia'];
        $video_confirmacion = $request['video_confirmacion'];
        $estado_contrato = $request['estado_contrato'];
        $generar_datos = $request['generar_datos'];

        $rango = "";
        if($request['rango_fecha'] != ""){
            $rango = explode(" | ", $request['rango_fecha']);
            $fecha_inicio = $rango[0];
            $fecha_final  = $rango[1];
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

        if (!isset($request['ciudad_id'])){
            $ciudad = "";
        }else{
            $ciudad = $request['ciudad_id'];
        }

        if (!isset($request['pais_id'])){
            $pais = "";
        }else{
            $pais = $request['pais_id'];
        }

        if (!isset($request['departamento_id'])){
            $departamento = "";
        }else{
            $departamento = $request['departamento_id'];
        }

        if (!isset($request['cargo_id'])) {
            $cargo = "";
        }else{
            $cargo = $request['cargo_id'];
        }

        if(isset($request['area_id'])){
            $area1 = $request['area_id'];
        }

        if(isset($request['num_req'])){
           $num_req = $request['num_req'];
        }

        if(isset($request['negocio_id'])){
            $negocio_id=$request['negocio_id'];
        }

        $data = "";

        if($fecha_inicio != '' || $fecha_final != '' || $cliente_id != '' || $area1 != '' ||
            $num_req != '' || $ciudad  != ''|| $cargo  != '' || $negocio_id  != '' || $usuario != '' ||
            $agencia != '' || $video_confirmacion != '' || $estado_contrato != '' || $num_req != '' || $fecha_inicio_firma != '' || $fecha_final_firma != '' || $fecha_inicio_ingreso != '' || $fecha_final_ingreso != ''){

            $data = FirmaContratos::join('requerimientos', 'requerimientos.id', '=', 'firma_contratos.req_id')
            ->join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
            ->leftJoin('cargos_genericos', 'cargos_genericos.id', '=', 'cargos_especificos.cargo_generico_id')
            ->join('datos_basicos', 'datos_basicos.user_id', '=', 'firma_contratos.user_id')
            //->join('procesos_candidato_req', 'procesos_candidato_req.requerimiento_id', '=', 'requerimientos.id')
            ->join('tipo_proceso', 'tipo_proceso.id', '=', 'requerimientos.tipo_proceso_id')
            ->join('negocio', 'negocio.id', '=', 'requerimientos.negocio_id')
            ->join('clientes', 'clientes.id', '=', 'negocio.cliente_id')
            ->join('estados_requerimiento', 'estados_requerimiento.req_id', '=', 'requerimientos.id')
            ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
            })->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
            })
            ->leftjoin('agencias', 'ciudad.agencia', '=', 'agencias.id')
            ->leftjoin('estados', 'estados.id', '=', 'estados_requerimiento.estado')
            ->leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            //->leftjoin('confirmacion_preguntas_contrato', 'confirmacion_preguntas_contrato.contrato_id', '=', 'firma_contratos.id')
            //->where('confirmacion_preguntas_contrato.pregunta_id', 4)
            //->where('procesos_candidato_req.estado', 12)
            //->whereIn('procesos_candidato_req.proceso', ['FIN_CONTRATACION_VIRTUAL', 'FIRMA_VIRTUAL_SIN_VIDEOS'])
            ->where('cargos_especificos.firma_digital', 1)
            ->whereRaw('estados_requerimiento.id = (SELECT MAX(estados_requerimiento.id) FROM estados_requerimiento where estados_requerimiento.req_id = requerimientos.id)')
            ->where(function ($query) use ($fecha_inicio, $fecha_final,$fecha_inicio_firma, $fecha_final_firma, $cliente_id, $agencia, $video_confirmacion, $estado_contrato, $num_req, $usuario, $fecha_inicio_ingreso, $fecha_final_ingreso) {
                if ($fecha_inicio != '' && $fecha_final != '') {
                    $query->whereBetween("firma_contratos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
                if ($fecha_inicio_firma != '' && $fecha_final_firma != '') {
                    $query->whereBetween("firma_contratos.fecha_firma", [$fecha_inicio_firma . ' 00:00:00', $fecha_final_firma . ' 23:59:59']);
                }

                if ($fecha_inicio_ingreso != '' && $fecha_final_ingreso != '') {
                    $query->whereBetween(DB::raw('(SELECT requerimiento_contrato_candidato.fecha_ingreso FROM requerimiento_contrato_candidato WHERE requerimiento_contrato_candidato.id = firma_contratos.req_contrato_cand_id ORDER BY requerimiento_contrato_candidato.id DESC LIMIT 1)'), [$fecha_inicio_ingreso, $fecha_final_ingreso]);
                }

                if ($cliente_id != '') {
                    $query->where("clientes.id", $cliente_id);
                }

                if ($num_req != '') {
                    $query->where("requerimientos.id", $num_req);
                }

                if ($agencia != '') {
                    $query->where("agencias.id", $agencia);
                }

                if ($video_confirmacion != '') {
                   $query->where("cargos_especificos.videos_contratacion", $video_confirmacion); 
                }

                if ($estado_contrato != '') {
                    if($estado_contrato == 5){
                        $query->where("firma_contratos.estado", 0);
                    }else{
                        $query->where("firma_contratos.terminado", $estado_contrato);
                    }
                }

                if ($usuario != '') {
                    $query->where("firma_contratos.gestion", $usuario); 
                }
            })
            ->where(function ($query) use ($cliente_id) {
                if($cliente_id == '' || $cliente_id == null) {
                    $ids_clientes_prueba = [];
                    if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                        $query->whereNotIn("clientes.id", $ids_clientes_prueba);
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
                'datos_basicos.aceptacion_firma_digital as confirmacion_video',
                DB::raw('(SELECT CONCAT(datos_basicos.nombres, " ", datos_basicos.primer_apellido, " ", datos_basicos.segundo_apellido) FROM datos_basicos WHERE datos_basicos.user_id = firma_contratos.gestion) as nombre_completo_gestion'),
                //DB::raw('(SELECT documentos.nombre_archivo  FROM documentos WHERE documentos.tipo_documento_id=47 and documentos.user_id=datos_basicos.user_id limit 1) as certificacion_bancaria'),
                'cargos_especificos.descripcion as cargo',
                'cargos_especificos.videos_contratacion as cargo_videos',
                'cargos_genericos.descripcion as cargo_generico',
                'firma_contratos.fecha_firma as fecha_firma_contrato',
                'firma_contratos.terminado as estado_contrato',
                'firma_contratos.created_at as fecha_envio_contrato',
                'firma_contratos.estado as estado_global',
                'clientes.nombre as cliente',
                'tipo_proceso.descripcion as tipo_proceso',
                'estados.descripcion as estado_requerimiento',
                DB::raw('(SELECT confirmacion_preguntas_contrato.updated_at FROM confirmacion_preguntas_contrato WHERE confirmacion_preguntas_contrato.contrato_id = firma_contratos.id AND confirmacion_preguntas_contrato.req_id = firma_contratos.req_id AND confirmacion_preguntas_contrato.user_id = firma_contratos.user_id AND confirmacion_preguntas_contrato.pregunta_id = 4 AND confirmacion_preguntas_contrato.estado=1  LIMIT 1) as fecha_grabacion_videos'),
                DB::raw('(SELECT requerimiento_contrato_candidato.fecha_ingreso FROM requerimiento_contrato_candidato WHERE requerimiento_contrato_candidato.id = firma_contratos.req_contrato_cand_id ORDER BY requerimiento_contrato_candidato.id DESC LIMIT 1) as fecha_ingreso'),
                DB::raw("(select GROUP_CONCAT(created_at,' ',IF(enviado_candidato=1,'<strong>Candidato</strong>',''),' ',IF(enviado_cliente=1,'<strong>Cliente</strong>',''),' ',IF(otros_emails!='',CONCAT('<strong>Otros:</strong>',otros_emails),''),' Enviado por:',(select CONCAT(nombres,' ',primer_apellido,' ',IF(segundo_apellido is null,'',segundo_apellido)) from datos_basicos where datos_basicos.user_id=emails_confirmacion_contratacion.quien_confirma_id) SEPARATOR ', ') from emails_confirmacion_contratacion where candidato_id=datos_basicos.user_id and requerimiento_id=requerimientos.id) as bloque_confirmacion"),
                DB::raw('( SELECT motivos_anulacion.descripcion FROM contratos_cancelados 
                    JOIN motivos_anulacion ON motivos_anulacion.id = contratos_cancelados.motivo_anulado 
                    WHERE contratos_cancelados.contrato_id = firma_contratos.id
                    AND contratos_cancelados.contrato_anulado = 1 LIMIT 1 ) as motivo_anulacion'),
                /*DB::raw('(select motivos_anulacion.descripcion from procesos_candidato_req JOIN 
                    motivos_anulacion ON motivos_anulacion.id = procesos_candidato_req.motivo_rechazo_id
                where proceso in(\'CONTRATO_ANULADO\') 
                and requerimiento_id=requerimientos.id 
                and candidato_id = firma_contratos.user_id limit 1 ) as motivo_anulacion'),*/
                //'confirmacion_preguntas_contrato.created_at as fecha_grabacion_videos',
                'agencias.descripcion as agencia',
                'tipo_identificacion.descripcion as tipo_identificacion'
            );
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

        //$data->numero_req
        /*foreach ($data as &$candidato) {

            $data_email_enviados = DataEmailEnviados::where('candidato_id', $candidato->candidato_id)
                ->where('requerimiento_id', $candidato->numero_req)
                ->select(
                    'emails_confirmacion_contratacion.*',
                    DB::raw('(SELECT CONCAT(datos_basicos.nombres, " ", datos_basicos.primer_apellido) FROM datos_basicos WHERE datos_basicos.user_id = emails_confirmacion_contratacion.quien_confirma_id) as nombre_gestion')
                    )
                ->orderBy('created_at', 'desc')
            ->get();
            $candidato["conf_contra"] = collect([]);
            foreach ($data_email_enviados as $email_enviado) {
                //dump($email_enviado->created_at->toDateTimeString());
                $confirmacion_contratacion = [
                    'candidato' => $email_enviado->enviado_candidato,
                    'cliente' => $email_enviado->enviado_cliente,
                    'fecha_hora' => $email_enviado->created_at->toDateTimeString(),
                    'otros_emails' => $email_enviado->otros_emails,
                    'gestionado' => $email_enviado->nombre_gestion
                ];
                $candidato["conf_contra"]->push($confirmacion_contratacion);
            }
        }
        unset($candidato);*/

        //dd($data);

        return $data;
    
    }
}