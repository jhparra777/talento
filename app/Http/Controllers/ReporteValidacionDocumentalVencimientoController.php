<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Clientes;
use App\Models\DatosBasicos;
use App\Models\DocumentosVerificados;
use App\Models\TipoDocumento;
use App\Models\Sitio;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReporteValidacionDocumentalVencimientoController extends Controller
{
    protected function sinClientesPruebas(&$ids_clientes_prueba) {
        $sitio = Sitio::first();
        if ($sitio->filtro_cliente == 'enabled' && $sitio->clientes_prueba_id != null && $sitio->clientes_prueba_id != '') {
            $ids_clientes_prueba = explode(",", $sitio->clientes_prueba_id);
            return true;
        }
        return false;
    }

    public function documentos_validacion_vencimiento(Request $request)
    {
        $columnas_datos = [];
        $clientes  = ["" => "Seleccionar"] + Clientes::orderBy('nombre')->pluck("clientes.nombre", "clientes.id")->toArray();
        //dd($clientes);
        $headers   = $this->getHeaderValidacionDocumentalVencimiento($request, $columnas_datos);
        $data      = $this->getDataValidacionDocumentalVencimiento($request, $columnas_datos);

        return view('admin.reportes.validacion_documental.index_validacion_documental')->with([
            'headers'           => $headers,
            'data'              => $data,
            'clientes'          => $clientes
        ]);
    }

    public function documentos_validacion_vencimiento_excel(Request $request)
    {
        $columnas_datos = [];
        $headers  = $this->getHeaderValidacionDocumentalVencimiento($request, $columnas_datos);
        $data     = $this->getDataValidacionDocumentalVencimiento($request, $columnas_datos);
        $formato  = $request->formato;

        if ($data == 'vacio') {
            $clientes  = ["" => "Seleccionar"] + Clientes::orderBy('nombre')->pluck("clientes.nombre", "clientes.id")->toArray();
            return view('admin.reportes.reporte_validacion_documental')->with([
                'data'       => $data,
                'headers'    => $headers,
                'clientes'   => $clientes
            ]);
        }

        $sitio = Sitio::first();
        if(isset($sitio->nombre)){
            if($sitio->nombre != ""){
                $nombre = $sitio->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-excel-validacion-documental-vence', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Validacion Documental Vence');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Validacion Documental Vence');
            $excel->sheet('Validacion Documental Vence', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.validacion_documental.include.grilla_validacion_documental', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    

    private function getHeaderValidacionDocumentalVencimiento($request, &$columnas_datos)
    {
        $headersr = [];
        $columnas_datos = TipoDocumento::where('estado', 1)->where('categoria', 1)->select('id', 'descripcion', 'categoria')->orderBy('descripcion')->get();

        $headersr[] = 'NOMBRES';
        $headersr[] = 'APELLIDOS';
        $headersr[] = 'NRO. IDENTIFICACIÓN';
        $headersr[] = 'CARGO';
        $headersr[] = 'CLIENTE';
        foreach ($columnas_datos as $columna) {
            $headersr[] = $columna->descripcion;
        }
        $headersr[] = 'ACCIÓN';
        return $headersr;
    }

    /*
    *   Contenido de tabla o archivo excel
    */
    private function getDataValidacionDocumentalVencimiento($request, $columnas_datos)
    {
        $numero_id = $request['numero_id'];
        $rango_fecha = $request->rango_fecha;
        $cliente = $request->cliente_id;
        $generar_datos = $request['generar_datos'];
        $formato      = ($request->has('formato')) ? $request->formato : 'html';

        $data = "vacio";

        if(($numero_id != '' || $rango_fecha != "" || $cliente != "") && count($columnas_datos) > 0){
            if($rango_fecha != ""){
                $rango = explode(" | ", $rango_fecha);
                $fecha_inicio = $rango[0];
                $fecha_final  = $rango[1];
            }

            $data = DatosBasicos::leftjoin("firma_contratos", "firma_contratos.user_id", "=", "datos_basicos.user_id")
                ->join("requerimientos", "requerimientos.id", "=", "firma_contratos.req_id")
                ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
                ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
                ->leftjoin("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->where(function($sql) use ($fecha_inicio, $fecha_final, $numero_id, $cliente)
                {
                    if ($fecha_inicio != "" && $fecha_final != "") {
                        $sql->whereBetween("firma_contratos.updated_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                    }
                    if ($numero_id != "") {
                        $sql->where("datos_basicos.numero_id", $numero_id);
                    }
                    if ($cliente != "" && $cliente != "null") {
                        $sql->where("clientes.id", $cliente);
                    }
                })
                ->whereNotNull("firma_contratos.terminado")
                ->where("firma_contratos.estado", 1)
                ->where(function ($query) use ($cliente) {
                    if($cliente == '' || $cliente == null) {
                        $ids_clientes_prueba = [];
                        if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                            $query->whereNotIn("clientes.id", $ids_clientes_prueba);
                        }
                    }
                })
                ->select(
                    "datos_basicos.user_id",
                    "datos_basicos.nombres",
                    "datos_basicos.primer_apellido",
                    "datos_basicos.segundo_apellido",
                    "datos_basicos.numero_id",
                    "datos_basicos.telefono_movil",
                    "clientes.nombre as cliente",
                    "cargos_especificos.id as cargo_id",
                    "cargos_especificos.descripcion as cargo"
                )
                ->orderBy("firma_contratos.updated_at", "desc");
        } else if (count($columnas_datos) === 0 && isset($generar_datos) && ($numero_id != '' || $fecha_inicio != "" && $fecha_final != "")) {
            session()->flash('mensaje_warning', 'El cargo de este requerimiento no tiene documentos asociados.');
        } else if (isset($generar_datos)) {
            if($request->rango_fecha_vencimiento != "") {
                session()->flash('mensaje_warning', 'Por favor ingrese un criterio de filtro adicional al rango de fecha de vencimiento');
            } else {
                session()->flash('mensaje_warning', 'Debe ingresar algún filtro');
            }
        }

        if($data != "vacio"){
            if($request['formato'] and ($formato == "xlsx" || $formato == "pdf")){
                $data = $data->get();
            }else{
                $data = $data->get();//paginate(6);
            }

            $fecha_vencimiento_inicio = $fecha_vencimiento_final = '';
            $rango_fecha_vencimiento = $request->rango_fecha_vencimiento;
            if($rango_fecha_vencimiento != ""){
                $rango = explode(" | ", $rango_fecha_vencimiento);
                $fecha_vencimiento_inicio = $rango[0];
                $fecha_vencimiento_final  = $rango[1];
            }

            $tipos_doc_ids = array_pluck($columnas_datos, 'id');
            foreach ($data as $key => &$candidato) {
                $doc_candidato = DocumentosVerificados::where('user_id', $candidato->user_id)
                    ->whereIn('tipo_documento_id', $tipos_doc_ids)
                    ->where(function($sql) use ($fecha_vencimiento_inicio, $fecha_vencimiento_final)
                    {
                        if ($fecha_vencimiento_inicio != "" && $fecha_vencimiento_final != "") {
                            $sql->whereBetween("fecha_vencimiento", [$fecha_vencimiento_inicio . ' 00:00:00', $fecha_vencimiento_final . ' 23:59:59']);
                        }
                    })
                    ->select("nombre_archivo", "tipo_documento_id", "descripcion_archivo", "fecha_vencimiento")
                    ->orderBy('created_at', 'desc')
                ->get();

                if (count($doc_candidato) <= 0) {
                    unset($data[$key]);
                    continue;
                }
                $candidato["documentos"] = collect([]);
                foreach ($columnas_datos as $tipo_doc) {
                    $documentos = [
                        'id' => $tipo_doc->id,
                        'descripcion' => $tipo_doc->descripcion,
                        'documentos' => $doc_candidato->where('tipo_documento_id', $tipo_doc->id)->take(3)
                    ];
                    $candidato["documentos"]->push($documentos);
                }
            }
            unset($candidato);
            if($formato != "xlsx" && $formato != "pdf") {
                $data = $data->paginate(6);
            }
        }


        return $data;
    }
}
