<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Clientes;
use App\Models\DatosBasicos;
use App\Models\Sitio;
use App\Models\SocioDemograficoConfiguracion;
use App\Models\SocioDemograficoPreguntas;
use App\Models\SocioDemograficoRespuestasUser;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReporteEncuestaFirmaContratoController extends Controller
{
    protected function sinClientesPruebas(&$ids_clientes_prueba) {
        $sitio = Sitio::first();
        if ($sitio->filtro_cliente == 'enabled' && $sitio->clientes_prueba_id != null && $sitio->clientes_prueba_id != '') {
            $ids_clientes_prueba = explode(",", $sitio->clientes_prueba_id);
            return true;
        }
        return false;
    }

    public function lista_encuesta_firma_contrato(Request $request)
    {
        $columnas_datos = [];
        $config_encuesta = SocioDemograficoConfiguracion::first();
        $clientes  = ["" => "Seleccionar"] + Clientes::whereNotNull('nombre')->orderBy('nombre')->get()->pluck("nombre", "id")->toArray();

        $headers   = $this->getHeaderEncuestaFirmaContrato($request, $columnas_datos);
        $data      = $this->getDataEncuestaFirmaContrato($request, $columnas_datos);

        return view('admin.reportes.encuesta_firma_contrato.index_encuesta_firma_contrato')->with([
            'headers'           => $headers,
            'columnas_datos'    => $columnas_datos,
            'config_encuesta'   => $config_encuesta,
            'data'              => $data,
            'clientes'          => $clientes
        ]);
    }

    public function encuesta_firma_contrato_excel(Request $request)
    {
        $columnas_datos = [];
        $headers  = $this->getHeaderEncuestaFirmaContrato($request, $columnas_datos);
        $data     = $this->getDataEncuestaFirmaContrato($request, $columnas_datos);
        $formato  = $request->formato;
        $config_encuesta = SocioDemograficoConfiguracion::first();

        if ($data == 'vacio') {
            $clientes  = ["" => "Seleccionar"] + Clientes::whereNotNull('nombre')->orderBy('nombre')->get()->pluck("nombre", "id")->toArray();

            return view('admin.reportes.encuesta_firma_contrato.index_encuesta_firma_contrato')->with([
                'data'              => $data,
                'columnas_datos'    => $columnas_datos,
                'config_encuesta'   => $config_encuesta,
                'headers'           => $headers,
                'clientes'          => $clientes
            ]);
        }

        $sitio = Sitio::first();
        $nombre = "Desarrollo";
        if(isset($sitio->nombre)){
            if($sitio->nombre != ""){
                $nombre = $sitio->nombre;
            }
        }

        Excel::create('reporte-excel-encuesta-firma-contrato', function ($excel) use ($data, $headers, $formato, $columnas_datos, $config_encuesta) {
            $excel->setTitle($config_encuesta->titulo_encuesta);
            $excel->setCreator("$nombre")
                ->setCompany("$nombre");
            $excel->setDescription('Encuesta Firma Contrato');
            $excel->sheet('Encuesta Firma Contrato', function ($sheet) use ($data, $headers, $formato, $columnas_datos) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.encuesta_firma_contrato.include.grilla_encuesta_firma_contrato', [
                    'data'              => $data,
                    'columnas_datos'    => $columnas_datos,
                    'headers'           => $headers,
                    'formato'           => $formato
                ]);
            });
        })->export($formato);
    }

    

    private function getHeaderEncuestaFirmaContrato($request, &$columnas_datos)
    {
        $headersr = [];
        $columnas_datos = SocioDemograficoPreguntas::where('active', 1)->orderBy('id')->get();

        $headersr[] = 'NOMBRES';
        $headersr[] = 'APELLIDOS';
        $headersr[] = 'NRO. IDENTIFICACIÓN';
        $headersr[] = 'CARGO';
        $headersr[] = 'CLIENTE';
        $headersr[] = 'FECHA FIRMA CONTRATO';
        $headersr[] = 'FECHA RESPUESTA ENCUESTA';
        foreach ($columnas_datos as $columna) {
            $headersr[] = $columna->descripcion;
        }
        return $headersr;
    }

    /*
    *   Contenido de tabla o archivo excel
    */
    private function getDataEncuestaFirmaContrato($request, $columnas_datos)
    {
        $numero_id = $request['numero_id'];
        $rango_fecha = $request->rango_fecha;
        $cliente = $request->cliente_id;
        $generar_datos = $request['generar_datos'];
        $formato      = ($request->has('formato') ? $request->formato : 'html');

        $data = "vacio";

        if(($numero_id != '' || $rango_fecha != "" || $cliente != "") && count($columnas_datos) > 0){
            if($rango_fecha != ""){
                $rango = explode(" | ", $rango_fecha);
                $fecha_inicio = $rango[0];
                $fecha_final  = $rango[1];
            }

            $data = DatosBasicos::join("firma_contratos", "firma_contratos.user_id", "=", "datos_basicos.user_id")
                ->join("requerimientos", "requerimientos.id", "=", "firma_contratos.req_id")
                ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
                ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
                ->leftjoin("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
                ->join('sociodemografico_respuestas_user', function ($join) {
                    $join->on('sociodemografico_respuestas_user.candidato_id', '=', 'firma_contratos.user_id');
                    $join->on('sociodemografico_respuestas_user.req_id', '=', 'firma_contratos.req_id');
                })
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
                    "cargos_especificos.descripcion as cargo",
                    "firma_contratos.updated_at as fecha_firma_contrato",
                    "sociodemografico_respuestas_user.respuestas",
                    "sociodemografico_respuestas_user.fecha_respuesta"
                )
                ->orderBy("firma_contratos.updated_at", "DESC");
        } else if (count($columnas_datos) === 0 && isset($generar_datos) && ($numero_id != '' || $fecha_inicio != "" && $fecha_final != "")) {
            session()->flash('mensaje_warning', 'No hay preguntas de la Encuesta Firma Contrato guardadas.');
        } else if (isset($generar_datos)) {
            session()->flash('mensaje_warning', 'Debe ingresar algún filtro');
        }

        if($data != "vacio"){
            $data = $data->get()->unique('user_id');

            if($formato == 'html') {
                $data = $data->paginate(6);
            }
        }

        return $data;
    }
}
