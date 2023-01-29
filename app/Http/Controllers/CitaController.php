<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citacion;
use App\Models\ReqCandidato;
use App\Models\User;
use App\Models\CitacionCargaBd;
use App\Models\EstadosRequerimientos;
use App\Models\Requerimiento;
use App\Models\MotivoRecepcion;
use App\Models\RegistroProceso;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CitaController extends Controller
{

    public function index(Request $data)
    {

        $user_sesion = $this->user;

        $citaciones = ReqCandidato::join('citaciones','citaciones.req_candi_id','=','requerimiento_cantidato.id')
        ->join('requerimientos','requerimientos.id','=','requerimiento_cantidato.requerimiento_id')
        ->join('cargos_especificos', 'requerimientos.cargo_especifico_id', '=', 'cargos_especificos.id')
        ->join('users','users.id','=','citaciones.psicologo_id')
        ->join('datos_basicos','datos_basicos.user_id','=','users.id')
        ->join('motivo_recepcion','motivo_recepcion.id','=','citaciones.motivo_id')
        ->where(function ($where) use ($data) {
            if ( $data->get('cedula_psico') != "") {
                $where->where("datos_basicos.numero_id",$data->get('cedula_psico'));
            }

            if ( $data->get('req_id') != "") {
                $where->where("requerimientos.id",$data->get('req_id'));
            }

        })
        ->select(
            'citaciones.psicologo_id',
            'motivo_recepcion.id as motivo_id',
            'citaciones.id',
            'motivo_recepcion.descripcion as motivo_cita',
            'citaciones.observaciones',
            'citaciones.fecha_cita',
            'requerimientos.id as req_id',
            'citaciones.estado as estado_cita',
            'citaciones.req_candi_id as req_cann_id',
            'cargos_especificos.descripcion as cargo',
            'users.name as nombres_psicologo',
            'users.numero_id',
            DB::raw('(select upper(p.id)  from requerimiento_cantidato o inner join users p on o.candidato_id=p.id where o.id=req_cann_id  order by o.created_at desc limit 1) as candidato_id'),
             
            DB::raw('(select upper(p.name)  from requerimiento_cantidato o inner join users p on o.candidato_id=p.id where o.id=req_cann_id  order by o.created_at desc limit 1) as nombre_candidato')
            )
        ->orderBy('citaciones.created_at','desc')
        ->paginate(10);

        return view("admin.citacion.citaciones", compact("user_sesion","citaciones"));

    }

    public function lista_candidatos(Request $data)
    {

        $user_carga = $this->user;
        $usuarios_reclutadores=[""=>"Seleccionar"]+User::join("role_users","role_users.user_id","=","users.id")
        ->where("role_users.role_id",5)
        ->pluck("users.name","users.id")
        ->toArray();
        
        $candidatos = CitacionCargaBd::/*leftjoin('requerimiento_cantidato','requerimiento_cantidato.candidato_id','=','citacion_carga_db.user_id')*/
        /*leftjoin('citaciones','citaciones.req_candi_id','=','requerimiento_cantidato.id')*/
        where(function ($where) use ($data,$user_carga) {
            if ( $data->get('cedula_candidato') != "") {
                $where->where("citacion_carga_db.identificacion",$data->get('cedula_candidato'));
            }

            if($data->get('nombre_carga') != "")
            {
                $where->where(DB::raw("  LOWER(citacion_carga_db.nombre_carga) "), "like", "%" . strtolower($data->get("nombre_carga")) . "%"); 
            }

            if ($data->get('fecha_carga_ini') != "" && $data->get('fecha_carga_fin') != "") {
                $where->whereBetween(DB::raw('DATE_FORMAT(citacion_carga_db.created_at, \'%Y-%m-%d\')'),[$data->get('fecha_carga_ini'),$data->get('fecha_carga_fin')]);
            }
            if($data->get('usuario_carga') != ""){
                $where->where("citacion_carga_db.user_carga",$data->get('usuario_carga'));
            }

            if($this->user->inRole("super administrador")){

            }
            else{
                $where->where('citacion_carga_db.user_carga', $user_carga->id);
            }
        })
       
        ->select(/*'citaciones.id as cita_id',*/'citacion_carga_db.*',(DB::raw('(select(DATE_FORMAT(citacion_carga_db.created_at, \'%Y-%m-%d\'))) as fecha_creacion')))
                 
        ->paginate(10);

        return view("admin.citacion.lista_candidatos", compact("candidatos","usuarios_reclutadores"));
    
    }

    public function crear_cita(Request $data)
    {

        if(route("home") == "http://temporizar.t3rsc.co" || route("home") == "https://temporizar.t3rsc.co" || route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" || route("home")=="http://localhost:8000"){

            /*$req_can_id = $data->req_can_id;*/
            $psicologos = ["" => "Seleccion"] + User::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")->pluck("users.name", "users.id")->toArray();

            $motivo = ["" => "Seleccion"] + MotivoRecepcion::pluck("motivo_recepcion.descripcion", "motivo_recepcion.id")->toArray();

            if($data->get('req_id') != '' && $data->get('single') != ''){

                $single = $data->get('single');

                $candidatoId = $data->user_id;
                $candidatoReq = $data->req_id;

                $candidato = User::where('users.id', $candidatoId)
                ->select('users.id','users.name')
                ->first();

                return view("admin.citacion.modal.crear_cita", compact(/*"requerimientos",*/"candidato","psicologos","motivo", "candidatoId", "candidatoReq","single"));

            }else{

                $candidatoId = $data->users_ids;
                $candidatoReq = $data->reques_ids;

                return view("admin.citacion.modal.crear_cita", compact(/*"requerimientos","candidato",*/"psicologos","motivo", "candidatoId", "candidatoReq"));

            }

        }else{

            //dd($data->all());
            /*$req_can_id = $data->req_can_id;*/
            $psicologos = ["" => "Seleccion"] + User::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
            ->pluck("users.name", "users.id")
            ->toArray();

            $motivo = ["" => "Seleccion"] + MotivoRecepcion::where('active', 1)->pluck("motivo_recepcion.descripcion", "motivo_recepcion.id")->toArray();

            $requerimientos = ["" => "seleccionar"] + Requerimiento::whereRaw(DB::raw("requerimientos.id not in (select req_id from estados_requerimiento where estado in( 
            " . config('conf_aplicacion.C_TERMINADO') . "," 
            . config('conf_aplicacion.C_CLIENTE') . ","
            . config('conf_aplicacion.C_SOLUCIONES') . "," 
            . config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL') . 
             "))"))->pluck("id", "id")->toArray();
            
            $candidato = User::where('users.id',$data->user_id)
            ->select('users.id','users.name')
            ->first();             

            return view("admin.citacion.modal.crear_cita", compact("requerimientos","candidato","psicologos","motivo","req_can_id"));

        }
    
    }

    public function guardar_cita(Request $data)
    {

        if(route("home") == "http://temporizar.t3rsc.co" || route("home") == "https://temporizar.t3rsc.co" || route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" || route("home")=="http://localhost:8000"){

            $this->validate($data, [
                'psicologo' => 'required',
                'fecha_cita' => 'required',
                'motivo' => 'required',
                //'req_id' => 'required',
            ]);

            if($data->get('single') && $data->get('single') != ''){

                $cand_id = $data->get('candidatoId');
                $req_id = $data->get('candidatoReq');

                $req_can = ReqCandidato::where('requerimiento_cantidato.candidato_id', $cand_id)
                ->orderBy('requerimiento_cantidato.created_at','desc')
                ->first();

                if ($req_can == true) {
                    
                    $mensaje = "Este candidato esta en proceso de seleccion en el requerimiento" .$req_can->requerimiento_id.", cita creada.";

                    $nueva_cita = new Citacion();
                    
                    $nueva_cita->psicologo_id     = $data->psicologo;
                    $nueva_cita->req_candi_id     = $req_can->id;
                    $nueva_cita->motivo_id        = $data->motivo;
                    $nueva_cita->observaciones    = $data->observaciones;
                    $nueva_cita->fecha_cita       = $data->fecha_cita;
                    $nueva_cita->estado           = 1;
                    $nueva_cita->save();

                    return response()->json(["success" => false,"mensaje"=>$mensaje]);

                }else{

                    $nuevo_req_candi = new ReqCandidato();
                    
                    $nuevo_req_candi->requerimiento_id = $req_id;
                    $nuevo_req_candi->candidato_id = $cand_id;
                    $nuevo_req_candi->estado_candidato = 7;
                    $nuevo_req_candi->otra_fuente = 11;
                    
                    $nuevo_req_candi->save();

                    $nuevo_proceso = new RegistroProceso();
                    $nuevo_proceso->fill([
                        'requerimiento_candidato_id' => $nuevo_req_candi->id,
                        'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        'fecha_inicio'               => date("Y-m-d H:i:s"),
                        'usuario_envio'              => $this->user->id,
                        'requerimiento_id'           => $nuevo_req_candi->requerimiento_id,
                        'candidato_id'               => $cand_id,
                        'observaciones'              => "Ingreso al requerimiento por citaciones",
                    ]);

                    $nuevo_proceso->save();

                    $estado_req = new EstadosRequerimientos();
                    $estado_req->estado = 7;
                    $estado_req->user_gestion = $this->user->id;
                    $estado_req->req_id = $req_id;
                    $estado_req->save();

                    $nueva_cita = new Citacion();
                    $nueva_cita->psicologo_id     = $data->psicologo;
                    $nueva_cita->req_candi_id     = $nuevo_req_candi->id;
                    $nueva_cita->motivo_id        = $data->motivo;
                    $nueva_cita->observaciones    = $data->observaciones;
                    $nueva_cita->fecha_cita       = $data->fecha_cita;
                    $nueva_cita->estado           = 1;
                    
                    $nueva_cita->save();
                }

                return response()->json(["success" => true]);

            }else{

                parse_str($data->get('candidatoId'), $candidatoIdA);
                parse_str($data->get('candidatoReq'), $candidatoReqB);

                $candidatoId = $candidatoIdA;
                $candidatoReq = $candidatoReqB;

                $count1 = 0;
                foreach ($candidatoId as $type) {
                    $count1+= count($type);
                }

                for ($i = 0; $i <  $count1; $i++) {
                    
                    $req_can = ReqCandidato::where('requerimiento_cantidato.candidato_id',$candidatoId['candidato_cita'][$i])
                    ->orderBy('requerimiento_cantidato.created_at','desc')
                    ->first();

                    if ($req_can == true) {
                        
                        $mensaje = "Este candidato esta en proceso de seleccion en el requerimiento" .$req_can->requerimiento_id.", cita creada .";

                        $nueva_cita = new Citacion();
                        
                        $nueva_cita->psicologo_id     = $data->psicologo;
                        $nueva_cita->req_candi_id     = $req_can->id;
                        $nueva_cita->motivo_id        = $data->motivo;
                        $nueva_cita->observaciones    = $data->observaciones;
                        $nueva_cita->fecha_cita       = $data->fecha_cita;
                        $nueva_cita->estado           = 1;
                        $nueva_cita->save();

                        //return response()->json(["success" => false,"mensaje"=>$mensaje]);

                    }else{

                        $nuevo_req_candi = new ReqCandidato();
                        
                        $nuevo_req_candi->requerimiento_id = $candidatoReq['candidato_cita_req'][$i];
                        $nuevo_req_candi->candidato_id = $candidatoId['candidato_cita'][$i];
                        $nuevo_req_candi->estado_candidato = 7;
                        $nuevo_req_candi->otra_fuente = 11;
                        
                        $nuevo_req_candi->save();

                        $nuevo_proceso = new RegistroProceso();
                        $nuevo_proceso->fill([
                            'requerimiento_candidato_id' => $nuevo_req_candi->id,
                            'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            'fecha_inicio'               => date("Y-m-d H:i:s"),
                            'usuario_envio'              => $this->user->id,
                            'requerimiento_id'           => $nuevo_req_candi->requerimiento_id,
                            'candidato_id'               => $candidatoId['candidato_cita'][$i],
                            'observaciones'              => "Ingreso al requerimiento por citaciones",
                        ]);

                        $nuevo_proceso->save();

                        $estado_req = new EstadosRequerimientos();
                        $estado_req->estado = 7;
                        $estado_req->user_gestion = $this->user->id;
                        $estado_req->req_id = $candidatoReq['candidato_cita_req'][$i];
                        $estado_req->save();

                        $nueva_cita = new Citacion();
                        $nueva_cita->psicologo_id     = $data->psicologo;
                        $nueva_cita->req_candi_id     = $nuevo_req_candi->id;
                        $nueva_cita->motivo_id        = $data->motivo;
                        $nueva_cita->observaciones    = $data->observaciones;
                        $nueva_cita->fecha_cita       = $data->fecha_cita;
                        $nueva_cita->estado           = 1;
                        
                        $nueva_cita->save();
                    }

                }

                return response()->json(["success" => true]);

            }

        }else{

            //dd($data->all());
            $this->validate($data, [
                'psicologo' => 'required',
                'fecha_cita' => 'required',
                'motivo' => 'required',
                'req_id' => 'required',
            ]);
           
           
           $req_can = ReqCandidato::where('requerimiento_cantidato.candidato_id',$data->user_id)
           ->orderBy('requerimiento_cantidato.created_at','desc')
           ->first();

           if ($req_can == true) {
            $mensaje = "Este candidato esta en proceso de seleccion en el requerimiento" .$req_can->requerimiento_id.", cita creada .";

            $nueva_cita = new Citacion();
            $nueva_cita->psicologo_id     = $data->psicologo;
            $nueva_cita->req_candi_id     = $req_can->id;
            $nueva_cita->motivo_id        = $data->motivo;
            $nueva_cita->observaciones    = $data->observaciones;
            $nueva_cita->fecha_cita       = $data->fecha_cita;
            $nueva_cita->estado           = 1;
            $nueva_cita->save();
               return response()->json(["success" => false,"mensaje"=>$mensaje]);
           }else{

            $nuevo_req_candi = new ReqCandidato();
            $nuevo_req_candi->requerimiento_id = $data->req_id;
            $nuevo_req_candi->candidato_id = $data->user_id;
            $nuevo_req_candi->estado_candidato = 7;
            $nuevo_req_candi->otra_fuente = 11;
            $nuevo_req_candi->save();

              $nuevo_proceso = new RegistroProceso();

                    $nuevo_proceso->fill(
                        [
                            'requerimiento_candidato_id' => $nuevo_req_candi->id,
                            'estado'                     => config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                            'fecha_inicio'               => date("Y-m-d H:i:s"),
                            'usuario_envio'              => $this->user->id,
                            'requerimiento_id'           => $nuevo_req_candi->requerimiento_id,
                            'candidato_id'               => $data->user_id,
                            'observaciones'              => "Ingreso al requerimiento por citaciones",
                        ]
                    );
                    $nuevo_proceso->save();


            $estado_req = new EstadosRequerimientos();
            $estado_req->estado = 7;
            $estado_req->user_gestion = $this->user->id;
            $estado_req->req_id = $data->req_id;
            $estado_req->save();
                    

            $nueva_cita = new Citacion();
            $nueva_cita->psicologo_id     = $data->psicologo;
            $nueva_cita->req_candi_id     = $nuevo_req_candi->id;
            $nueva_cita->motivo_id        = $data->motivo;
            $nueva_cita->observaciones    = $data->observaciones;
            $nueva_cita->fecha_cita       = $data->fecha_cita;
            $nueva_cita->estado           = 1;
            $nueva_cita->save();


           }

            return response()->json(["success" => true]);

        }

    }

    public function editar_cita(Request $data)
    {
        $psicologo_id = $data->psicologo_id;
        $motivo_id = $data->motivo_id;

        $psicologos = ["" => "Seleccion"] + User::join("users_x_clientes", "users_x_clientes.user_id", "=", "users.id")
        ->pluck("users.name", "users.id")
        ->toArray();

        $motivo = ["" => "Seleccion"] + MotivoRecepcion::pluck("motivo_recepcion.descripcion", "motivo_recepcion.id")
        ->toArray();

        $cita= Citacion::where('citaciones.id',$data->cita_id)
        ->select('citaciones.*')
        ->first();
 
        $candidato = User::where('users.id',$data->candidato_id)
        ->select('users.name')
        ->first();

        return view("admin.citacion.modal.editar_cita", compact("cita","motivo_id","candidato","psicologo_id","psicologos","motivo","req_can_id"));
    
    }

    public function actualizar_cita(Request $data)
    {
        $this->validate($data, [
            'psicologo' => 'required',
            'fecha_cita' => 'required',
            'motivo' => 'required',
        ]);

        $act_cita = Citacion::find($data->cita_id);

        $act_cita->psicologo_id     = $data->psicologo;
        $act_cita->motivo_id        = $data->motivo;
        $act_cita->observaciones    = $data->observaciones;
        $act_cita->fecha_cita       = $data->fecha_cita;
        $act_cita->estado           = 1;
        $act_cita->save();

        return response()->json(["success" => true]);
    
    }

    public function inactivar_cita(Request $data)
    {
        $ae = Citacion::find($data->cita_id);
        $ae->estado = 0;

        $ae->save();
    
    }

    public function activar_cita(Request $data)
    {
        $ae = Citacion::find($data->cita_id);
        $ae->estado = 1;

        $ae->save();
    
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
