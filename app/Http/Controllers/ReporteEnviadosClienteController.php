<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Requerimiento;
use App\Jobs\FuncionesGlobales;
use App\Jobs\Sitio;
use Maatwebsite\Excel\Facades\Excel;
use \DB;

class ReporteEnviadosClienteController extends Controller
{
    /*
    *   Retorna la vista para consultar reporte
    */
    public function enviadosCliente(Request $request)
    {
        $headers   = $this->getHeaderEnviadosCliente();
        $data      = $this->getDataEnviadosCliente($request);

        return view('admin.reportes.reporte_enviados_cliente.index_enviados_cliente')->with([
            'headers'   => $headers,
            'data'      => $data
        ]);
    }

    /*
    *   Genera exportación de archivo excel
    */
    public function enviadosClienteExcel(Request $request)
    {
        $headers = $this->getHeaderEnviadosCliente();
        $data    = $this->getDataEnviadosCliente($request);
        $formato = $request->formato;

        if ($data == 'vacio') {
            return redirect()->route('admin.reporte_enviados_cliente')->with([
                'headers'   => $headers,
                'data'      => $data
            ]);
        } elseif (count($data) == 0) {
            session()->flash('mensaje_warning', 'No hay resultados para esta consulta.');
            return redirect()->route('admin.reporte_enviados_cliente', $request->all());
        }

        $funcionesGlobales = new FuncionesGlobales;

        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-enviados-cliente', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Enviados al Cliente');
            $excel->setCreator($nombre)
                ->setCompany($nombre);
            $excel->setDescription('Reporte Candidatos Enviados al Cliente');
            $excel->sheet('Candidatos Enviados al Cliente', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.reporte_enviados_cliente.include.grilla_enviados_cliente', [
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
    private function getHeaderEnviadosCliente()
    {
        $headers = [
            'Requerimiento',
            'N° identificación',
            'Nombre candidato',
            'Fecha de creación requerimiento',
            'Cliente requerimiento',
            'Tipo Proceso',
            'Fecha de envío cliente',
            'Usuario que envió'
        ];

        return $headers;
    }

    /*
    *   Contenido de tabla o archivo excel
    */
    private function getDataEnviadosCliente($request)
    {
        $formato    = ($request['formato']) ? $request['formato'] : 'html';
        $cliente_id = '';

        $fecha_inicio_req   = '';
        $fecha_final_req    = '';
        $fecha_inicio_envio = '';
        $fecha_final_envio  = '';

        $rango_requerimiento = $request->rango_requerimiento;
        if ($rango_requerimiento != null && $rango_requerimiento != '') {
            $rango_req = explode(" | ", $rango_requerimiento);
            $fecha_inicio_req = $rango_req[0];
            $fecha_final_req  = $rango_req[1];
        }

        $rango_enviados = $request->rango_enviados;
        if ($rango_enviados != null && $rango_enviados != '') {
            $rango_env = explode(" | ", $rango_enviados);
            $fecha_inicio_envio = $rango_env[0];
            $fecha_final_envio  = $rango_env[1];
        }

        $generar_datos = $request['generar_datos'];

        $data = "vacio";

        if (($fecha_inicio_req != '' && $fecha_final_req != '') || ($fecha_inicio_envio != '' && $fecha_final_envio != '')) {

            $data = Requerimiento::join('negocio', 'negocio.id', '=', 'requerimientos.negocio_id')
            ->join('clientes', 'clientes.id', '=', 'negocio.cliente_id')
            ->join('procesos_candidato_req', 'procesos_candidato_req.requerimiento_id', '=', 'requerimientos.id')
            ->join('datos_basicos', 'datos_basicos.user_id', '=', 'procesos_candidato_req.candidato_id')
            ->join('tipo_proceso', 'tipo_proceso.id', '=', 'requerimientos.tipo_proceso_id')
            ->where('procesos_candidato_req.proceso', 'ENVIO_APROBAR_CLIENTE')
            ->where(function ($query) use ($fecha_inicio_req, $fecha_final_req, $fecha_inicio_envio, $fecha_final_envio, $cliente_id){
                if ($fecha_inicio_req != '' && $fecha_final_req != '') {
                    $query->whereBetween("requerimientos.created_at", [$fecha_inicio_req . ' 00:00:00', $fecha_final_req . ' 23:59:59']);
                }

                if ($fecha_inicio_envio != '' && $fecha_final_envio != '') {
                    $query->whereBetween("procesos_candidato_req.created_at", [$fecha_inicio_envio . ' 00:00:00', $fecha_final_envio . ' 23:59:59']);
                }

                /*if ($cliente_id != '') {
                    $query->where("clientes.id", $cliente_id);
                }*/
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
                'clientes.nombre as cliente',
                'datos_basicos.numero_id as cedula',
                DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido) AS nombre_completo"),
                'procesos_candidato_req.created_at as fecha_envio',
                DB::raw('(SELECT CONCAT(datos_basicos.nombres, " ", datos_basicos.primer_apellido, " ", datos_basicos.segundo_apellido) FROM datos_basicos WHERE datos_basicos.user_id = procesos_candidato_req.usuario_envio) as nombre_usuario_envio'),
                'requerimientos.created_at as fecha_requerimiento',
                'requerimientos.id as numero_req',
                'tipo_proceso.descripcion as tipo_proceso'
            )
            ->orderBy('requerimientos.id', 'desc');
        } else if (isset($generar_datos)) {
            session()->flash('mensaje_warning', 'Debe ingresar por lo menos 1 filtro');
        }

        if($data != "vacio"){
            if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
                $data = $data->get();
            }else{
                $data = $data->paginate(6);
            }
        }

        //dd($data);
        return $data;
    
    }

    protected function sinClientesPruebas(&$ids_clientes_prueba) {
        $sitio = Sitio::first();
        if ($sitio->filtro_cliente == 'enabled' && $sitio->clientes_prueba_id != null && $sitio->clientes_prueba_id != '') {
            $ids_clientes_prueba = explode(",", $sitio->clientes_prueba_id);
            return true;
        }
        return false;
    }
}
