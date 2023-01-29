<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CargoGenerico;
use App\Models\Clientes;
use App\Models\Negocio;
use App\Models\NegocioANS;
use App\Models\Requerimiento;
use App\Models\TipoContrato;
use App\Models\TipoJornada;
use App\Models\TipoLiquidacion;
use App\Models\TipoSalario;
use App\Models\TipoProceso;
use App\Models\CentrosCostos;
use App\Models\CentroCostoProduccion;
use Illuminate\Http\Request;
use App\Http\Requests\NuevoNegocioRequest;

class NegocioController extends Controller
{

    public function negocio_clientes(Request $data)
    {

        $user=$this->user;
        $negocios = Negocio::join("clientes", "clientes.id", "=", "negocio.cliente_id")
            //->whereIn("clientes.id", $this->clientes_user)
            ->where(function ($where) use ($data) {
                if ($data->get("nit") != "") {
                    $where->where("clientes.nit", "'" . $data->get("nit") . "'");
                }
                /*if ($data->get("nombre") != "") {
                    $where->whereRaw("LOWER(clientes.nombre) like  '%" . strtolower($data->get("nombre")) . "%'");
                }*/
                if ($data->get("cliente_id") != "") {
                    $where->where("negocio.cliente_id", $data->get("cliente_id"));
                }
                if ($data->get("negocio_id") != "") {
                    $where->where("negocio.num_negocio", $data->get("negocio_id"));
                }
            })
            ->select(
                'negocio.cliente_id',
                'negocio.tipo_contrato_id',
                'negocio.tipo_proceso_id',
                'negocio.tipo_jornada_id',
                'negocio.pais_id',
                'negocio.departamento_id',
                'negocio.ciudad_id', 
                "negocio.id as negocio_id", 
                "negocio.num_negocio", 
                "clientes.nit", 
                "clientes.nombre", 
                "clientes.direccion", 
                "clientes.telefono"
            )->paginate(10);

            $clientes = ["" => "Seleccionar"] + Clientes::join("users_x_clientes", "clientes.id", "=", "users_x_clientes.cliente_id")
            ->where("users_x_clientes.user_id", $user->id)
            ->orderBy('clientes.nombre', 'asc')
            ->pluck("clientes.nombre", "clientes.id")
            ->toArray();

        return view("admin.clientes.negocio_clientes", compact("negocios","user","clientes"));
    }

    public function editar_negocio($negocio_id, Request $data)
    {
        $negocio = Negocio::join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->where("negocio.id", $negocio_id)
            ->select("clientes.nombre", "clientes.nit", "negocio.id as negocio_id", "negocio.*")
            ->first();
        $cargo_generico = CargoGenerico::orderBy("descripcion")->pluck("descripcion", "id")->toArray();
        $tipo_proceso   = ["" => "Seleccionar"] + TipoProceso::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipo_contrato  = ["" => "Seleccionar"] + TipoContrato::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipo_jornada   = ["" => "Seleccionar"] + TipoJornada::where("active", 1)->pluck("descripcion", "id")->toArray();

        $tipo_liquidacion   = ["" => "Seleccionar"] + TipoLiquidacion::pluck("descripcion", "id")->toArray();

        $tipo_salario   = ["" => "Seleccionar"] + TipoSalario::pluck("descripcion", "id")->toArray();
        
        $negocio_ans    = NegocioANS::where("negocio_id", $negocio_id)->orderBy("vacantes_inicio", "asc")->get();

        return view("admin.clientes.editar_negocio", compact(
            "negocio",
            "tipo_proceso",
            "tipo_contrato",
            "tipo_jornada",
            "tipo_liquidacion",
            "tipo_salario",
            "cargo_generico",
            "negocio_ans")
        );
    }

    //, Requests\ValidaNegocioRequest $data
    public function actualizar_negocio(Request $data)
    {
        //dd($data->all());
        //VALIDA SI TIENE REQUISICIONES AGREGADAS
        $requerimiento = Requerimiento::where("negocio_id", $data->get("id"))->get();

        /*if ($requerimiento->count() > 0) {
            return redirect()->route("admin.negocio_cliente")->with("mensaje_error", "Este negocio no se puede modificar puesto que tiene requerimientos asociados.");
        }*/
        //$negocio = new Negocio();
        //$negocio->fill($data->all());

        $menuArray = [];

        if ($data->has("cargo_generico_id") && is_array($data->get("cargo_generico_id"))) {

            foreach ($data->get("cargo_generico_id") as $key => $value) {
                if ($value != "no") {
                    $menuArray[$key] = $value;
                }
            }
        }

        $negocio = Negocio::find($data->get("id"));
        $negocio->fill($data->all());
        $cadena_cargos              = implode(",", $menuArray);
        $negocio->cargo_generico_id = $cadena_cargos;
        //dd($negocio);
        $negocio->save();

      if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co" && route('home') != "https://demo.t3rsc.co"){
        //GUARDAR ANS

        // Primero eliminamos los ans existentes 

        //dd($negocio->ans);

        $e_negocios_ans = NegocioANS::where("negocio_id", $negocio->id)->get();
            foreach($e_negocios_ans as $ne){
                $ne->delete();
            }
        

        if ($data->get("regla_de") != "" && is_array($data->get("regla_de"))) {
            
            $regla_de                           = $data->get("regla_de");
            $regla_a                            = $data->get("regla_a");
            $cantidad_dias                      = $data->get("cantidad_dias");
            $num_cand_presentar_vac             = $data->get("num_cand_presentar_vac");
            $dias_presentar_candidatos_antes    = $data->get("dias_presentar_candidatos_antes");

            //$cantidad_vacantes = $params->get("cantidad_inicio");
            //dd($data->get("cantidad_dias"));

            for ($i = 0; $i < count($regla_de); $i++) {

                if ($regla_de[$i] != "" && $regla_a[$i]!="") {
                    //$consulta_ans = NegocioANS::where("vacantes_inicio", $regla[$i])->where("negocio_id", $negocio->id)->get();
                        $ans=$negocio->ans()->create([
                            "vacantes_inicio" => 0, 
                            "regla"=>$regla_de[$i]."A".$regla_a[$i],
                            "num_cand_presentar_vac"=>$num_cand_presentar_vac[$i],
                            "dias_presentar_candidatos_antes"=>$dias_presentar_candidatos_antes[$i],
                            "cantidad_dias" => $cantidad_dias[$i], 
                            //"negocio_id" => $negocio->id

                        ]);
                       
                
                }
              }
            }
        }//fin ocultar para tiempos

        return redirect()->route("admin.negocio_cliente")->with("mensaje_success", "Se ha actualizado el negocio correctamente");
    }

    public function eliminar_ans(Request $data)
    {
        $eliminar      = NegocioANS::find($data->get("ans_id"));
        $requerimiento = Requerimiento::where("negocio_id", $eliminar->negocio_id)->get();
        if ($requerimiento->count() > 0) {
            return response()->json(["susccess" => true, "mensaje" => "Este negocio no se puede modificar puesto que tiene requerimientos asociados."]);
        }

        $eliminar->delete();
        return response()->json(["susccess" => true]);
    }

    public function nuevo_negocio(Request $data)
    {
        $tipo_proceso   = ["" => "Seleccionar"] + TipoProceso::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipo_contrato  = ["" => "Seleccionar"] + TipoContrato::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipo_jornada   = ["" => "Seleccionar"] + TipoJornada::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipo_liquidacion   = ["" => "Seleccionar"] + TipoLiquidacion::pluck("descripcion", "id")->toArray();
        $cliente        = ["" => "Seleccionar"] + Clientes::orderBy(\DB::raw("UPPER(nombre)"))->pluck("nombre", "id")->toArray();
        $tipo_salario   = ["" => "Seleccionar"] + TipoSalario::pluck("descripcion", "id")->toArray();
        return view("admin.clientes.nuevo_negocio", compact(
            "tipo_proceso",
            "tipo_contrato",
            "tipo_jornada",
            "tipo_liquidacion",
            "tipo_salario",
            "cliente",
            "cargo_generico")
        );
    }

    //, Requests\NuevoNegocioRequest $data
    public function guardar_negocio(Request $params, NuevoNegocioRequest $data) {

        $nuevo = new Negocio();
        $nuevo->fill($params->all());
        $nuevo->save();

        if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co"){

        if ($params->get("regla_de") != "" && is_array($params->get("regla_de")) && $params->get("regla_a") != "" && is_array($params->get("regla_a"))) {
            
            $regla                           = $params->get("regla_de");
            $reglad                           = $params->get("regla_a");
            $cantidad_dias                   = $params->get("cantidad_dias");
            $num_cand_presentar_vac          = $params->get("num_cand_presentar_vac");
            $dias_presentar_candidatos_antes = $params->get("dias_presentar_candidatos_antes");

            //$cantidad_vacantes = $params->get("cantidad_inicio");
            //dd($data->get("cantidad_dias"));

            for ($i = 0; $i < count($regla); $i++) {

                if($regla[$i] != "") {
                    
                    $consulta_ans = NegocioANS::where("vacantes_inicio", $regla[$i])->where("negocio_id", $nuevo->id)->get();
                    if ($consulta_ans->count() == 0) {
                        $negocio_ans = new NegocioANS();
                    //uniar ambas reglas
                     $reglas = $regla[$i].'A'.$reglad[$i];

                        $negocio_ans->fill([
                            "vacantes_inicio" => 0, 
                            "regla"=>$reglas,
                            "num_cand_presentar_vac"=>$num_cand_presentar_vac[$i],
                            "dias_presentar_candidatos_antes"=>$dias_presentar_candidatos_antes[$i],
                            "cantidad_dias" => $cantidad_dias[$i], 
                            "negocio_id" => $nuevo->id

                        ]);

                        $negocio_ans->save();
                    }
                }
            }
          }//fin de condicion ocultar para tiempos
        }
        return redirect()->route("admin.negocio_cliente")->with("mensaje_success", "Se ha creado un nuevo negocio");
    }

    public function nuevo_centro_costo($negocio_id)
    {

        $negocio=Negocio::leftjoin("clientes","clientes.id","negocio.cliente_id")
        ->select("negocio.*","clientes.nombre as nombre_cliente")
        ->findOrFail($negocio_id);
        //$cliente    = ["" => "Seleccionar"] + Clientes::orderBy("nombre", "desc")->pluck("nombre", "id")->toArray();
        //$negocio    = ["" => "Seleccionar"] + Negocio::orderBy("nombre_negocio")->pluck("nombre_negocio", "id")->toArray();
        
        return view("admin.clientes.nuevo_centro_costos", compact("negocio"));

    }

    public function guardar_centro_costo(Request $data) {

        $nuevo_centro = new CentroCostoProduccion();

        $nuevo_centro->fill([
            'cod_division'  => $data->get('cliente_id'),
            'cod_depto_negocio'  => $data->get('negocio_id'),
            'codigo'      => $data->get('codigo_centro'),
            'descripcion' => $data->get('desc_negocio'),
            'estado'      => 'ACT'
        ]);

        $nuevo_centro->save();

        return redirect()->route("admin.negocio_cliente")->with("mensaje_success", "Se ha creado un nuevo centro de costos");
    }

    public function actualizar_centro_costo(Request $data)
    {
        return redirect()->route("admin.negocio_cliente")->with("mensaje_success", "Se ha actualizado el negocio correctamente");
    }

    public function cargar_negocio_selec(Request $data){

        $negocio = Negocio::where('cliente_id', $data->get('cliente_id'))->orderBy("num_negocio")->pluck("num_negocio", "id")->toArray();

        return response()->json($negocio);
    }

}
