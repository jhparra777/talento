<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\ObservacionesHv;
use App\Models\MotivoDescarteCandidato;
use App\Models\Sitio;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReporteCandidatosDescartadosController extends Controller
{
    protected function sinClientesPruebas(&$ids_clientes_prueba) {
        $sitio = Sitio::first();
        if ($sitio->filtro_cliente == 'enabled' && $sitio->clientes_prueba_id != null && $sitio->clientes_prueba_id != '') {
            $ids_clientes_prueba = explode(",", $sitio->clientes_prueba_id);
            return true;
        }
        return false;
    }

    public function lista_descartados(Request $request)
    {
        $motivos_descarte = ["" => "Seleccionar"] + MotivoDescarteCandidato::where('active', 1)->pluck("descripcion", "id")->toArray();
    
        $headers   = $this->getHeaderCandidatosDescartados();
        $data      = $this->getDataCandidatosDescartados($request);

        return view('admin.reportes.candidatos_descartados.index_candidatos_descartados')->with([
            'motivos_descarte'  => $motivos_descarte,
            'headers'           => $headers,
            'data'              => $data
        ]);
    }

    public function lista_descartados_excel(Request $request)
    {
        $headers = $this->getHeaderCandidatosDescartados();
        $data    = $this->getDataCandidatosDescartados($request);
        $formato = $request->formato;

        if ($data == 'vacio') {
            return redirect()->route('admin.reporte_candidatos_descartados')->with([
                'headers'   => $headers,
                'data'      => $data
            ]);
        } elseif (count($data) == 0) {
            session()->flash('mensaje_warning', 'No hay resultados para esta consulta.');
            return redirect()->route('admin.reporte_candidatos_descartados', $request->all());
        }

        $sitio = Sitio::first();
        $nombre_sitio = "Desarrollo";

        if($sitio->nombre != "") {
            $nombre_sitio = $sitio->nombre;
        }

        Excel::create('reporte-candidatos-descartados', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Candidatos Descartados');
            $excel->setCreator($nombre_sitio)
                ->setCompany($nombre_sitio);
            $excel->setDescription('Reporte Candidatos Descartados');
            $excel->sheet('Candidatos Descartados', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.reportes.candidatos_descartados.include.grilla_candidatos_descartados', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }

    private function getHeaderCandidatosDescartados()
    {
        $headers = [
            'Fuente',
            'Motivo descarte',
            'Documento candidato',
            'Nombre candidato',
            'Observación de descarte',
            'Fecha descarte',
            'Req',
            'Usuario descartó'
        ];

        return $headers;
    }

    private function getDataCandidatosDescartados($request) {
        $formato    = ($request['formato']) ? $request['formato'] : 'html';
        $motivo_descarte_id = $request->motivo_descarte_id;

        $fecha_inicio = '';
        $fecha_final  = '';

        $rango_fecha = $request->rango_fecha;
        if ($rango_fecha != null && $rango_fecha != '') {
            $rango = explode(" | ", $rango_fecha);
            $fecha_inicio   = $rango[0];
            $fecha_final    = $rango[1];
        }

        $generar_datos = $request['generar_datos'];

        $data = "vacio";

        if ($fecha_inicio != '' && $fecha_final != '') {
            $data = ObservacionesHv::join('requerimientos', 'requerimientos.id', '=', 'observaciones_hoja_vida.req_id')
                ->join('negocio', 'negocio.id', '=', 'requerimientos.negocio_id')
                ->join('clientes', 'clientes.id', '=', 'negocio.cliente_id')
                ->join('datos_basicos', 'datos_basicos.user_id', '=', 'observaciones_hoja_vida.candidato_id')
                ->leftjoin('motivo_descarte_candidatos', 'motivo_descarte_candidatos.id', '=', 'observaciones_hoja_vida.motivo_descarte_id')
                ->where(function ($query) use ($fecha_inicio, $fecha_final, $motivo_descarte_id){
                    if ($fecha_inicio != '' && $fecha_final != '') {
                        $query->whereBetween("observaciones_hoja_vida.created_at", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                    }

                    if ($motivo_descarte_id != '') {
                        $query->where("observaciones_hoja_vida.motivo_descarte_id", $motivo_descarte_id);
                    }
                })
                ->where(function ($query){
                    $ids_clientes_prueba = [];
                    if ($this->sinClientesPruebas($ids_clientes_prueba)) {
                        $query->whereNotIn("clientes.id", $ids_clientes_prueba);
                    }
                })
                ->select(
                    'observaciones_hoja_vida.*',
                    'datos_basicos.numero_id as cedula',
                    'datos_basicos.nombres',
                    'datos_basicos.primer_apellido',
                    'datos_basicos.segundo_apellido',
                    'motivo_descarte_candidatos.descripcion as motivo_descarte_descripcion',
                    DB::raw('(SELECT CONCAT(datos_basicos.nombres, " ", datos_basicos.primer_apellido) FROM datos_basicos WHERE datos_basicos.user_id = observaciones_hoja_vida.user_gestion) as nombre_usuario_gestion')
                )
            ->orderBy('observaciones_hoja_vida.created_at', 'desc');
        } else if (isset($generar_datos)) {
            session()->flash('mensaje_warning', 'Debe seleccionar un rango de fecha.');
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
}
