<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use \DB;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Clientes;
use App\Models\Requerimiento;
use App\Models\TipoProcesoManejado;
use App\Models\Sitio;

class ReporteNoContinuidadController extends Controller
{
    protected function sinClientesPruebas(&$ids_clientes_prueba) {
        $sitio = Sitio::first();
        if ($sitio->filtro_cliente == 'enabled' && $sitio->clientes_prueba_id != null && $sitio->clientes_prueba_id != '') {
            $ids_clientes_prueba = explode(",", $sitio->clientes_prueba_id);
            return true;
        }
        return false;
    }

    public function noContinuidadIndex(Request $request)
    {
        $clientes = Clientes::where('estado', 'ACT')->orderBy('id', 'desc')->select("nombre", "id")->get();
        $columnas_procesos_all = TipoProcesoManejado::where('active', 1)->orderBy('orden_reporte')->get();

        if ($request->proceso != '') {
            $columnas_procesos = TipoProcesoManejado::where('nombre_trazabilidad', $request->proceso)->where('active', 1)->orderBy('orden_reporte')->get();
        } else {
            $columnas_procesos = TipoProcesoManejado::where('active', 1)->orderBy('orden_reporte')->get();
        }

        $headers   = $this->getHeaderNoContinuidad($columnas_procesos);
        $data      = $this->getDataNoContinuidad($request, $columnas_procesos);

        return view('admin.reportes.no_continuidad.index_no_continuidad')->with([
            'columnas_procesos'     => $columnas_procesos,
            'columnas_procesos_all' => $columnas_procesos_all,
            'formato'   => 'html',
            'clientes'  => $clientes,
            'headers'   => $headers,
            'data'      => $data
        ]);
    }

    public function noContinuidadExcel(Request $request)
    {
        if ($request->proceso != '') {
            $columnas_procesos = TipoProcesoManejado::where('nombre_trazabilidad', $request->proceso)->where('active', 1)->orderBy('orden_reporte')->get();
        } else {
            $columnas_procesos = TipoProcesoManejado::where('active', 1)->orderBy('orden_reporte')->get();
        }

        $headers    = $this->getHeaderNoContinuidad($columnas_procesos);
        $data       = $this->getDataNoContinuidad($request, $columnas_procesos);
        $formato    = $request->formato;
        $columnas_procesos_all = TipoProcesoManejado::where('active', 1)->orderBy('orden_reporte')->get();

        if ($data == 'vacio') {
            $clientes = Clientes::where('estado', 'ACT')->orderBy('id', 'desc')->select("nombre", "id")->get();

            return redirect()->route('admin.reportes.no_continuidad.index_no_continuidad')->with([
                'headers'   => $headers,
                'data'      => $data,
                'clientes'  => $clientes,
                'format'    => 'html',
                'columnas_procesos'     => $columnas_procesos,
                'columnas_procesos_all' => $columnas_procesos_all,
            ]);
        } elseif (count($data) == 0) {
            session()->flash('mensaje_warning', 'No hay resultados para esta consulta.');
            return redirect()->route('admin.reportes.no_continuidad.index_no_continuidad', $request->all());
        }

        $sitio = Sitio::first();
        $nombre_sitio = "Desarrollo";

        if($sitio->nombre != "") {
            $nombre_sitio = $sitio->nombre;
        }

        Excel::create('reporte-no-continuidad', function ($excel) use ($data, $headers, $formato, $columnas_procesos) {
            $excel->setTitle('Reporte No Continuidad');
            $excel->setCreator($nombre_sitio)
                ->setCompany($nombre_sitio);
            $excel->setDescription('Reporte No Continuidad');
            $excel->sheet('No Continuidad', function ($sheet) use ($data, $headers, $formato, $columnas_procesos) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.no_continuidad.include.grilla_no_continuidad', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                    'columnas_procesos' => $columnas_procesos,
                ]);
            });
        })->export($formato);
    }

    private function getHeaderNoContinuidad($columnas_procesos)
    {
        $headers[] = 'Fecha de creación del requerimiento';
        $headers[] = 'Fecha tentativa de ingreso';
        $headers[] = 'Número de requerimiento';
        $headers[] = 'Cliente';
        $headers[] = 'Ciudad de labor';
        $headers[] = 'Cargo';
        $headers[] = 'Nombres y apellidos';
        $headers[] = 'Documento de Identidad';
        $headers[] = 'Número de teléfono móvil';
        $headers[] = 'Correo';
        foreach ($columnas_procesos as $columna) {
            $headers[] = $columna->nombre_visible;
        }

        return $headers;
    }

    private function getDataNoContinuidad($request, $columnas_procesos) {
        $formato    = ($request['formato']) ? $request['formato'] : 'html';
        $cliente_id = $request->cliente_id;
        $requerimiento_id = $request->requerimiento_id;
        $estado_proceso = $request->estado_proceso;
        $proceso = $request->proceso;

        $fecha_inicio = '';
        $fecha_final  = '';

        $rango_fecha = $request->rango_fecha;
        if ($rango_fecha != null && $rango_fecha != '') {
            $rango = explode(" | ", $rango_fecha);
            $fecha_inicio   = $rango[0];
            $fecha_final    = $rango[1];
        }

        $procesos_activos = $columnas_procesos->pluck('nombre_trazabilidad');
        $procesos_activos_string = "('".implode("','", $procesos_activos->all())."')";

        $generar_datos = $request['generar_datos'];

        $data = "vacio";

        if($cliente_id != '' && $fecha_inicio == '' && $fecha_final == '') {
            $mensaje_warning = 'Debe seleccionar un rango de fecha.';
        } else if (($estado_proceso != '' || $proceso != '') && $fecha_inicio == '' && $fecha_final == '') {
            $fecha_inicio = '';
            $fecha_final = '';
            $mensaje_warning = 'Debe seleccionar proceso, estado proceso y un rango de fecha.';
        } else if ($requerimiento_id == '') {
            $mensaje_warning = 'Debe seleccionar filtro(s) adicionales';
        }

        if (($cliente_id != '' && $fecha_inicio != '' && $fecha_final != '') || $requerimiento_id != '' || ($estado_proceso != '' && $proceso != '' && $fecha_inicio != '' && $fecha_final != '') || ($fecha_inicio != '' && $fecha_final != '')) {
            $data = Requerimiento::join('procesos_candidato_req', 'procesos_candidato_req.requerimiento_id', '=', 'requerimientos.id')
                ->join('negocio', 'negocio.id', '=', 'requerimientos.negocio_id')
                ->join('clientes', 'clientes.id', '=', 'negocio.cliente_id')
                ->join('datos_basicos', 'datos_basicos.user_id', '=', 'procesos_candidato_req.candidato_id')
                ->where(function ($query) use ($fecha_inicio, $fecha_final, $cliente_id, $requerimiento_id, $estado_proceso, $proceso, $columnas_procesos){
                    if ($fecha_inicio != '' && $fecha_final != '') {
                        $query->whereBetween("requerimientos.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                    }

                    if ($cliente_id != '') {
                        $query->where("clientes.id", $cliente_id);
                    }

                    if ($requerimiento_id != '') {
                        $query->where("requerimientos.id", $requerimiento_id);
                    }

                    if ($estado_proceso != '' && $proceso != '') {
                        if ($estado_proceso == 0) {
                            $query->whereIn("procesos_candidato_req.apto", [0, 2]);
                        } else {
                            $query->where("procesos_candidato_req.apto", $estado_proceso);
                        }
                        $query->where("procesos_candidato_req.proceso", $proceso);
                    } else {
                        $query->whereIn("procesos_candidato_req.proceso", $columnas_procesos->pluck('nombre_trazabilidad'));
                    }
                })
                ->where(function ($query) use ($request) {
                    if($request->cliente_id == '' || $request->cliente_id == null) {
                        $ids_clientes_prueba = [];
                        if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                            $query->whereNotIn("clientes.id", $ids_clientes_prueba);
                        }
                    }
                })
                ->select(
                    'datos_basicos.numero_id as cedula',
                    'datos_basicos.nombres',
                    'datos_basicos.primer_apellido',
                    'datos_basicos.segundo_apellido',
                    'datos_basicos.user_id',
                    'datos_basicos.telefono_movil',
                    'datos_basicos.email',
                    'clientes.nombre as nombre_cliente',
                    'procesos_candidato_req.requerimiento_candidato_id',
                    'requerimientos.ciudad_id',
                    'requerimientos.departamento_id',
                    'requerimientos.pais_id',
                    'requerimientos.fecha_ingreso',
                    'requerimientos.cargo_especifico_id',
                    'requerimientos.created_at as fecha_creacion_req',
                    'requerimientos.id as req_id',

                    DB::raw("(select GROUP_CONCAT(IF(apto is null,4,apto),' | ',proceso,' | ',updated_at,' | ',IF(observaciones is null,'',observaciones) SEPARATOR ', ') from procesos_candidato_req where procesos_candidato_req.requerimiento_id=requerimientos.id and datos_basicos.user_id=procesos_candidato_req.candidato_id and procesos_candidato_req.proceso in $procesos_activos_string) as bloque_proceso")
                )
            ->groupBy('procesos_candidato_req.requerimiento_candidato_id')
            ->orderBy('requerimientos.created_at', 'desc');
        } else if (isset($generar_datos)) {
            session()->flash('mensaje_warning', $mensaje_warning);
        }

        if($data != "vacio"){
            if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
                $data = $data->get();
            }else{
                $data = $data->paginate(6);
            }
        }

        return $data;
    }
}
