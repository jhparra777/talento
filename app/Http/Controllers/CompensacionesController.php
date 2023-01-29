<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use App\Facade\QueryAuditoria;
        use App\Http\Controllers\Controller;
        use App\Http\Requests\NuevoRequerimientoRequest;
        use App\Jobs\FuncionesGlobales;
        use DateTime;
        use App\Jobs\SendPostCreateReqEmail;
        use App\Models\User as EloquentUser;
        use App\Models\Atributo;
        use Illuminate\Support\Facades\Mail;
        use App\Models\AtributoSelect;
        use App\Models\Auditoria;
        use App\Models\CandidatosFuentes;
        use App\Models\CargoEspecifico;
        use App\Models\CargoGenerico;
        use App\Models\CentroCostoProduccion;
        use App\Models\CentroTrabajo;
        use App\Models\Ciudad;
        use App\Models\Clientes;
        use App\Models\ConceptoPago;
        use App\Models\EstadoCivil;
        use App\Models\Respuesta;
        use App\Models\EstadosRequerimientos;
        use App\Models\Ficha;
        use App\Models\Genero;
        use App\Models\LineaServicio;
        use App\Models\Localidad;
        use App\Models\Menu;
        use App\Models\MotivoRequerimiento;
        use App\Models\Negocio;
        use App\Models\NivelEstudios;
        use App\Models\Requerimiento;
        use App\Models\Sociedad;
        use App\Models\TipoContrato;
        use App\Models\TipoExperiencia;
        use App\Models\TipoJornada;
        use App\Models\TipoLiquidacion;
        use App\Models\TipoNegocio;
        use App\Models\TipoNomina;
        use App\Models\TipoProceso;
        use App\Models\TipoSalario;
        use App\Models\UnidadNegocio;
        use App\Models\ReqPreg;
        use App\Models\ReqCandidato;
        use App\Models\ UserClientes;
        use App\Models\User;
        use Carbon\Carbon;
        use Illuminate\Http\Request;
        use Illuminate\Support\Facades\DB;
        use App\Models\NegocioANS;
        use App\Models\Facturacion;

class CompensacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $data)
    {
        $user_sesion    = $this->user;
        $requerimientos = Requerimiento::
            join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("tipo_proceso", "tipo_proceso.id", "=", "requerimientos.tipo_proceso_id")
            ->join("users", "users.id", "=", "requerimientos.solicitado_por")
            ->join("estados_requerimiento", "estados_requerimiento.req_id", "=", "requerimientos.id")
            ->leftJoin("requerimiento_cantidato","requerimiento_cantidato.requerimiento_id","=","requerimientos.id")
            ->whereIn("clientes.id", $this->clientes_user)
            ->where(function ($sql) use ($data) {
                if ($data->has("cliente_id") && $data->get("cliente_id") != "") {
                    $sql->where("clientes.id", $data->get("cliente_id"));
                }
                if ($data->has("num_req") && $data->get("num_req") != "") {
                    $sql->where("requerimientos.id", $data->get("num_req"));
                }
            })
            ->select("requerimientos.*", 
                "tipo_proceso.descripcion as tipo_proceso_desc",
                 DB::raw('(select count(requerimiento_cantidato.candidato_id)  
                            from requerimiento_cantidato
                            where requerimientos.id = requerimiento_cantidato.requerimiento_id)  as num_asociados '),
                 DB::raw('(select count(*) from siete_contratados where requerimiento_id=requerimientos.id) as num_contratados'),
                 "negocio.num_negocio",
                 "clientes.nombre as nombre_cliente", "users.name as nombre_usuario", 
                 "requerimientos.id as req_id")
            ->groupBy("requerimientos.id")
            ->orderBy("requerimientos.id", "desc")
            ->paginate(10);

            $clientes = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "clientes.id", "=", "users_x_clientes.cliente_id")
            ->where("users_x_clientes.user_id", $user_sesion->id)
            ->orderBy('nombre', 'asc')
            ->pluck("clientes.nombre", "clientes.id")
            ->toArray();

        $usuarios = ["" => "Seleccionar"] + User::pluck("name", "id")->toArray();

        /* $estado_req = EstadosRequerimientos::join("estados", "estados.id", "=", "estados_requerimiento.estado")
        ->where(function($sql) use ($data){
        if($data->get('num_req')!=""){
        $sql->where("req_id", $data->get("num_req"));
        }
        })
        ->select("estados.descripcion as estado_nombre", "estados.id as estados_req")
        ->orderBy("estados_requerimiento.estado", "desc")->first(); */
        $agencias = Ciudad::select(DB::raw("trim(agencia) agencia"))
            ->distinct()
            ->orderBy("agencia", "asc")
            ->pluck("agencia", "agencia")
            ->toArray();

        return view("admin.compensaciones.index", compact(
            "requerimientos",
            "clientes",
            "usuarios",
            "user_sesion",
            "agencias"
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function no_asignar(Request $data)
    {

        $email_creador = Requerimiento::join('users','users.id','=','requerimientos.solicitado_ṕor')
        ->where('requerimientos.id',$data->req_id)
        ->select('users.email')
        ->first();




                $funcionesGlobales = new FuncionesGlobales();
            if (isset($funcionesGlobales->sitio()->nombre)) {
                if ($funcionesGlobales->sitio()->nombre != "") {
                    $nombre = $funcionesGlobales->sitio()->nombre;
                } else {
                    $nombre = "Desarrollo";
                }
            }
        
        $asunto = "Rechazo de compensación de la requisición  ".$data->req_id;
        $emails = $email_creador->email;
        $mensaje = "Su solicitud no ha sido avalada, por favor comuniquese con el encargado de compensaciones.";
        
        //Envio de email
        Mail::send('admin.email_compensacion', ["mensaje" => $mensaje], function($message) use ($data, $emails, $asunto) {
            $message->to($emails, '$nombre - T3RS')->subject($asunto)
            ->getHeaders()
            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });


        $email_karen = User::where('id',33703)
        ->first();




                $funcionesGlobales = new FuncionesGlobales();
            if (isset($funcionesGlobales->sitio()->nombre)) {
                if ($funcionesGlobales->sitio()->nombre != "") {
                    $nombre = $funcionesGlobales->sitio()->nombre;
                } else {
                    $nombre = "Desarrollo";
                }
            }
        
        $asunto = "Rechazo de compensación de la requisición  ".$data->req_id;
        $emails = $email_karen->email;
        $mensaje = "Su solicitud no ha sido avalada, por favor comuniquese con el encargado de compensaciones.";
        
        //Envio de email
        Mail::send('admin.email_compensacion', ["mensaje" => $mensaje], function($message) use ($data, $emails, $asunto) {
            $message->to($emails, '$nombre - T3RS')->subject($asunto)
            ->getHeaders()
            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

     
        return response()->json(["success" => true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editar_compensacion($requerimiento_id, Request $data)
    {
         $requermiento = Requerimiento::find($requerimiento_id);
        $negocio      = Negocio::find($requermiento->negocio_id);
        $cliente      = Clientes::find($negocio->cliente_id);

        $cargos = CargoGenerico::where("estado", "1")->pluck("descripcion", "id")->toArray();

        $cargo_especifico =  CargoEspecifico::where('cxclt_estado', 'act')

            ->where('clt_codigo', $cliente->cliente_id)

            ->orderBy('descripcion', 'asc')
            ->pluck('descripcion', 'id')
            ->toArray();
        
        $concepto_pago_id    =   ConceptoPago::pluck("descripcion", "id")->toArray();
        $tipoProceso         =   TipoProceso::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipo_nomina         =   TipoNomina::pluck("descripcion", "id")->toArray();
        $tipoContrato        = TipoContrato::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoExperiencia     =  TipoExperiencia::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoGenero          =  Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
        $motivoRequerimiento =  MotivoRequerimiento::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoJornadas        =  TipoJornada::where("active", 1)->pluck("descripcion", "id")->toArray();

        $centro_trabajo      =   CentroTrabajo::
            pluck("nombre_ctra", "id")
            ->toArray();

        $tipo_salario         =  TipoSalario::pluck("descripcion", "id")->toArray();

        $tipoContrato        =  TipoContrato::where("active", 1)->pluck("descripcion", "id")->toArray();
        

        $user                = $this->user;

        //Consultar las personas postuladas segun el requerimiento.
        $candidatos_postulados = CandidatosFuentes::where(
            'requerimiento_id', $requerimiento_id)
            ->select('*')
            ->get();
        
        $tipo_liquidacion =  TipoLiquidacion::pluck("descripcion", "id")->toArray();

        return view("admin.compensaciones.editar_compensacion", compact('concepto_pago_id','tipo_nomina',"cliente",'tipo_salario' ,'tipo_liquidacion','centro_trabajo', "cargos", "tipoProceso", "tipoContrato", "tipoExperiencia", "tipoGenero", "motivoRequerimiento", "tipoJornadas", "user", "negocio", "requermiento", "candidatos_postulados", "cargo_especifico"));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function actualizar_compensacion(Request $data)
    {
        $requerimiento                  = Requerimiento::find($data->get("id"));
        $registro_antiguo               = $requerimiento;
        $requerimiento->num_vacantes    = (int) $data->get("num_vacantes");
        $requerimiento->tipo_proceso_id = (int) $data->get("tipo_proceso_id");
        $requerimiento->cargo_especifico_id = $data->get('cargo_especifico_id');
        $requerimiento->salario         = (int) $data->get('salario');
        $requerimiento->fecha_ingreso   = $data->get('fecha_ingreso');
        $requerimiento->fecha_retiro    = $data->get('fecha_retiro');
        $requerimiento->pais_id         = $data->get('pais_id');
        $requerimiento->ctra_x_clt_codigo = $data->ctra_x_clt_codigo;
        $requerimiento->tipo_jornadas_id = $data->tipo_jornadas_id;
        $requerimiento->tipo_liquidacion = $data->tipo_liquidacion;
        $requerimiento->tipo_salario     = $data->tipo_salario;
        $requerimiento->tipo_nomina      = $data->tipo_nomina;
        $requerimiento->concepto_pago_id = $data->concepto_pago_id;
        $requerimiento->tipo_contrato_id = $data->tipo_contrato_id;
        $requerimiento->ciudad_id       = $data->get('ciudad_id');
        $requerimiento->departamento_id = $data->get('departamento_id');
        $requerimiento->esquemas        = $data->get('esquemas');
        $requerimiento->save();

        $auditoria                = new Auditoria();
        $auditoria->observaciones = "Editar requerimiento";
        $auditoria->valor_antes   = json_encode($registro_antiguo);
        $auditoria->valor_despues = json_encode($requerimiento);
        $auditoria->user_id       = $this->user->id;
        $auditoria->tabla         = "requerimientos";
        $auditoria->tabla_id      = $requerimiento->id;
        $auditoria->tipo          = "ACTUALIZAR";
        event(new \App\Events\AuditoriaEvent($auditoria));

        return redirect()->route("admin.compensaciones")->with("mensaje_success", "Se ha actualizado la compensación con exito.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
