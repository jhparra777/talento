<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Clientes;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\FuncionesGlobales;
use \DB;
use App\Models\DatosBasicos;
use App\Models\Facturacion;
use App\Models\Requerimiento;
use App\Models\User as EloquentUser;
use App\Models\Negocio;
use App\Models\User;

class FacturacionController extends Controller
{
   
    //SON LOS ESTADOS PARA NO MOSTRAR EL CANDIDATO EN EL  REQUERIMIENTO
    public function index(Request $request)
    {   
        $funcionesGlobales = new FuncionesGlobales();
        $usuariosHijos     = $funcionesGlobales->usuariosHijos($this->user->id);
        $clientes          = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
            ->whereIn("users_x_clientes.user_id", $usuariosHijos)
            ->pluck("clientes.nombre", "clientes.id")->toArray();
        $estado = ["" => "Seleccionar", "facturado" => "FACTURADO", "pendiente_facturacion" => "PENDIENTE FACTURACIÓN"];
        $headers   = $this->getHeaderReporte();
        $data    = $this->getDataReporte($request);

        return view("admin.facturacion.anexo.index", compact('clientes','estado','data','headers','nombres'));
    }

    /**
     * Facturar requerimiento
     **/
    public function facturaRequerimiento(Request $data)
    {   
        $req_id = $data->get("req_id");
        $facturacion = Facturacion::
            where("req_id", $req_id)
            ->first();
        if(isset($facturacion->id)){
            $facturacion_id = $facturacion->id;
        }else{
            $facturacion_id = 0;
        }
        return view("admin.facturacion.modal.facturar_requerimiento", compact("req_id","facturacion_id","facturacion"));
    }

    /**
     * Facturación anexo
     **/
    public function facturacionAnexo(Request $data){
        
        $id_user = DatosBasicos::where("numero_id", $data->get("cedula"))->first();

        $requerimientos = Requerimiento::
            join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->join("users", "users.id", "=", "requerimientos.solicitado_por")
            //->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            ->leftJoin("requerimiento_cantidato", "requerimiento_cantidato.requerimiento_id", "=", "requerimientos.id")
            ->whereIn("clientes.id", $this->clientes_user)
        //->where("estados_requerimiento.estado", ["39","40","44"])
            ->where(function ($sql) use ($data, $id_user) {
                if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }
                if ($data->has("num_req") && $data->get("num_req") != "") {
                    $sql->where("requerimientos.id", $data->get("num_req"));
                }
            })
            ->select("requerimientos.num_vacantes", "requerimientos.created_at", "requerimientos.fecha_ingreso", "requerimientos.dias_gestion",
                "requerimientos.id", "tipo_proceso.descripcion as tipo_proceso_desc", "negocio.num_negocio", "clientes.nombre as nombre_cliente", "users.name as nombre_usuario", "requerimientos.id as req_id")
            ->groupBy("requerimientos.id",
                "tipo_proceso.descripcion",
                "negocio.num_negocio",

                "clientes.nombre",
                "users.name", "requerimientos.num_vacantes", "requerimientos.created_at", "requerimientos.fecha_ingreso", "requerimientos.dias_gestion")
            ->orderBy("requerimientos.id", "desc")
            ->paginate(5);

        $clientes = ["" => "Seleccionar"] + Clientes::orderBy("clientes.nombre", "ASC")
            ->pluck("clientes.nombre", "clientes.id")->toArray();

        $usuarios = ["" => "Seleccionar"] + EloquentUser::pluck("name", "id")->toArray();

        return view("admin.facturacion.anexo.lista_facturacion", compact("requerimientos", "clientes", "usuarios"));
    }

    /**
     * Guardar la facturación
     **/
    public function guardarFacturacionRequerimiento(Request $data, Requests\FacturacionRequest $valida){
        
        //Definir el estado
        $estado = "";
        if($data->factura_entrega_terna == 1){
            $estado = "Envío Factura Terna";
        }
        if($data->recaudo_centrega_terna == 1){
            $estado = "Recaudo Primera Terna";
        }
        if($data->factura_cierre_proceso == 1){
            $estado = "Envío Factura Cierre Proceso";
        }
        if($data->recaudo_cierre_proceso == 1){
            $estado = "Terminado";
        }
        if($estado == ""){
            $estado = "Facturar";
        }

        //Guardar Facturación
        $guardar = new Facturacion();
        $guardar->fill([
            "req_id"                    => $data->req_id,
            "user_id"                   => $this->user->id,
            "factura_entrega_terna"     => $data->factura_entrega_terna,
            "recaudo_centrega_terna"    => $data->recaudo_centrega_terna,
            "factura_cierre_proceso"    => $data->factura_cierre_proceso,
            "recaudo_cierre_proceso"    => $data->recaudo_cierre_proceso,
            "observaciones"             => $data->observaciones,
            "estado"                    => $estado,
        ]);
        $guardar->save();

        
        $mensaje = "Se guardo correctamente la facturación del requerimiento ".$data->req_id;
        return response()->json(["success" => true, "mensaje" => $mensaje]);
    }

    /**
     * Actualizar la facturación
     **/
    public function actualizar_factura_requerimiento(Request $data, Requests\FacturacionRequest $valida){

        //Definir el estado
        $estado = "";
        if($data->factura_entrega_terna == 1){
            $estado = "Envío Factura Terna";
            if($data->recaudo_centrega_terna == 1){
                $estado = "Recaudo Primera Terna";
                if($data->factura_cierre_proceso == 1){
                    $estado = "Envío Factura Cierre Proceso";
                }
            }
        }

        if($data->recaudo_cierre_proceso == 1){
            $estado = "Terminado";
        }

        if($estado == ""){
            $estado = "Proceso";
        }

        //Actualizar Facturación
        $guardar             = Facturacion::find($data->get("facturacion_id"));
        $guardar->fill($data->all() + [
            "user_id" => $this->user->id,
            "estado"  => $estado,
        ]);
        $guardar->save();

        $mensaje = "Se actualizo correctamente la facturación del requerimiento ".$data->req_id;
        return response()->json(["success" => true, "mensaje" => $mensaje]);
    }

    /**
     * Generar el excel d facturación de nexo
     **/
    private function getHeaderReporte()
    {
        $headerss = [
            'Proceso',
            'Fecha solicitud',
            'Nombre  cliente',
            'Cargo',
            'N° Vacantes',
            'Salario cargo',
            'Tipo de servicio',
            'Consultor',
            'Comercial',
            'Fecha entrega terna',
            'Terna 1',
            'Terna 2',
            'Terna 3',
            'Terna 4',
            'Terna 5',
            'Terna 6',
            'Total candidatos entregados',
            'Estado proceso',
            'Observaciones al proceso',
            'Candidatos seleccionados',
            'Tarifa comercial',
            'Valor del proceso',
            '30%',
            '70%',
            '50%',
            '50%',
            'Éxito(100%)',
            'Factura entrega terna',
            'Factura cierre proceso',
            'Saldo Facturación',
            '--',
        ];
        return $headerss;
    }

    private function getDataReporte($request)
    {
        $formato      = ($request->has('formato')) ? $request->formato : 'html';
         $fecha_inicio = $request->fecha_inicio;
        $fecha_final  = $request->fecha_final;
        $cliente_id   = $request->cliente_id;
        $estado     = $request->estado;
       
           
             $data = Facturacion::join('requerimientos','requerimientos.id','=','facturacion.req_id')
            ->leftjoin('requerimiento_cantidato','requerimiento_cantidato.requerimiento_id','=','requerimientos.id')
            ->join('tipo_proceso','tipo_proceso.id','=','requerimientos.tipo_proceso_id')
            ->join('requerimientos_estados', 'requerimientos.id', '=', 'requerimientos_estados.req_id')
            ->join('tipos_contratos', 'requerimientos.tipo_contrato_id', '=', 'tipos_contratos.id')
            ->join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                    ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->join('departamentos', function ($join2) {
                $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
            })
            ->join('paises', 'requerimientos.pais_id', '=', 'paises.cod_pais')
            ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->join('cargos_genericos', 'requerimientos.cargo_generico_id', '=', 'cargos_genericos.id')
            ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
            ->join('users', 'requerimientos.solicitado_por', '=', 'users.id')
            ->where(function ($sql) use ($fecha_inicio, $fecha_final, $cliente_id, $estado) {
                if ($fecha_inicio != "" && $fecha_final != "") {
                    $sql->whereBetween("requerimientos.fecha_tentativa_cierre_req", [$fecha_inicio . ' 00:00:00', $fecha_final . ' 23:59:59']);
                }
                if ((int) $cliente_id > 0 && $cliente_id != "") {
                    $sql->where("requerimientos_estados.cliente_id", $cliente_id);
                }
                if ($estado && $estado != "") {
                    $sql->where("facturacion.estado",$estado);
                }
            })
            ->select(
                'requerimientos.id as requerimiento_id',
                'requerimientos.created_at as fecha_solicitud',
                'requerimientos.esquemas as esquemas',
                'clientes.nombre as nombre ',
                'cargos_genericos.descripcion as cargo',
                'requerimientos.num_vacantes as vacantes',
                'requerimientos.salario as salario',
                'facturacion.*',
                'tipo_proceso.descripcion as tipo_servicios',
                 DB::raw('(select upper(p.name)  from estados_requerimiento o left join users p on o.user_gestion=p.id where o.req_id=requerimientos.id and o.estado = ' . config('conf_aplicacion.C_EN_PROCESO_SELECCION') . ' order by o.created_at desc limit 1) as consultor'),
                  DB::raw('upper(users.name) as comercial'),
                  'requerimientos.fecha_tentativa_cierre_req as fecha_entrega',
                  
                    DB::raw('(select upper(p.name)  from facturacion o left join users p on o.user_id=p.id  order by o.created_at desc limit 1) as user_obser'),

                   DB::raw('(select upper(x.descripcion) as estado from requerimientos_estados y inner join estados x on y.max_estado=x.id where y.req_id=requerimientos.id limit 1 ) as estado_req'),

                 'facturacion.observaciones as observaciones',
                  DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_APROBAR_CLIENTE\') and requerimiento_id=requerimientos.id ) as cand_env_cli')
            )
         ->groupBy('requerimientos.id')
         ->orderBy('requerimientos.id','desc');

            if ($request->has('formato') and ($formato == "xlsx" || $formato == "pdf")) {
                $data = $data->get();
            } else {
                $data = $data->paginate(5);
            }

        return $data;
    }

    public function reporteAnexo(Request $request)
    {
        $headers = $this->getHeaderReporte();
        $data    = $this->getDataReporte($request);
        $formato = $request->formato;

        $funcionesGlobales = new FuncionesGlobales();
        if(isset($funcionesGlobales->sitio()->nombre)){
            if($funcionesGlobales->sitio()->nombre != ""){
                $nombre = $funcionesGlobales->sitio()->nombre;
            }else{
                $nombre = "Desarrollo";
            }
        }

        Excel::create('reporte-facturacion-anexo', function ($excel) use ($data, $headers, $formato) {
            $excel->setTitle('Reporte Facturacion de Anexos');
            $excel->setCreator('$nombre')
                ->setCompany('$nombre');
            $excel->setDescription('Reporte Facturacion de Anexos');
            $excel->sheet('Reporte Facturacion de Anexos', function ($sheet) use ($data, $headers, $formato) {
                $sheet->setOrientation("landscape");
                $sheet->loadView('admin.facturacion.anexo.grilla_detalle_fact', [
                    'data'    => $data,
                    'headers' => $headers,
                    'formato' => $formato,
                ]);
            });
        })->export($formato);
    }
}
