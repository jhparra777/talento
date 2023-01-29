<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\EntidadesEps as ModeloTabla;
use App\Models\Agencia;
use App\Models\AgenciaUsuario;
use Illuminate\Http\Request;

class EntidadesEpsController extends Controller
{

    public function index(Request $data)
    {
        $listas = ModeloTabla::where(function ($where) use ($data) {
            if ($data->get("descripcion") != "") {
                $where->where("descripcion", "like", "%" . $data->get("descripcion") . "%");
            }
            if ($data->get("active") != "") {
                $where->where("active", "like", "%" . $data->get("active") . "%");
            }

        })->paginate(10);
        return view("admin.entidades_eps.index", compact("listas"));
    }

    public function editar($id, Request $data)
    {
        $registro = ModeloTabla::find($id);
        $agencias=[];

        if(route("home")=="http://vym.t3rsc.co" || route("home")=="https://vym.t3rsc.co" || route("home")=="http://listos.t3rsc.co"  || route("home")=="https://listos.t3rsc.co" || route("home")=="http://localhost:8000"){

             $agencias=Agencia::all();
        }

       return view("admin.entidades_eps.editar", compact("registro",'agencias'));
    }

    public function actualizar(Request $datos, Requests\EntidadesEpsEditarRequest $valida)
    {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        
        if($datos->has("agencia") && is_array($datos["agencia"])){
         
         $registro->agencias_si = implode(",", $datos['agencia']); //guardar realcion agencia eps
        }

        $registro->save();
        return redirect()->route("admin.entidades_eps.index")->with("mensaje_success", "Registro actualizado con exito");
    }

    public function nuevo(Request $data)
    {
        $agencias=[];

        if(route("home")=="http://vym.t3rsc.co" || route("home")=="https://vym.t3rsc.co" || route("home")=="http://listos.t3rsc.co"  || route("home")=="https://listos.t3rsc.co" || route("home")=="http://localhost:8000"){

             $agencias=Agencia::all();
        }

        return view("admin.entidades_eps.nuevo",compact('agencias'));
    }

    public function guardar(Request $data, Requests\EntidadesEpsNuevoRequest $valida)
    {
        $registro = new ModeloTabla();
        $registro->fill($data->all());
        
        if($data->has("agencia") && is_array($data["agencia"])){
         
         $registro->agencias_si = implode(",", $data['agencia']); //guardar realcion agencia eps
        }

        $registro->save();

        return redirect()->route("admin.entidades_eps.index")->with("mensaje_success", "Registro creado con exito");
    }

}
