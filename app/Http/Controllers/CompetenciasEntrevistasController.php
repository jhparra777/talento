<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\CompetenciaEntrevista as ModeloTabla;
use Illuminate\Http\Request;

class CompetenciasEntrevistasController extends Controller
{

    public function index(Request $data)
    {
        $listas = ModeloTabla::where(function ($where) use ($data) {
            if ($data->get("nombre") != "") {
                $where->where("nombre", "like", "%" . $data->get("nombre") . "%");
            }

        })->paginate(10);
        
        return view("admin.competencias_entrevistas.index", compact("listas"));
    }

    public function editar($id, Request $data)
    {
        $registro = ModeloTabla::find($id);
        return view("admin.competencias_entrevistas.editar", compact("registro"));
    }

    public function actualizar(Request $datos, Requests\CompetenciasEntrevistasEditarRequest $valida)
    {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        $registro->save();
        return redirect()->route("admin.competencias_entrevistas.index")->with("mensaje_success", "Registro actualizado con exito");
    }

    public function nuevo(Request $data)
    {

        return view("admin.competencias_entrevistas.nuevo");
    }

    public function guardar(Request $data, Requests\CompetenciasEntrevistasNuevoRequest $valida)
    {
        $registro = new ModeloTabla();
        $registro->fill($data->all());
        $registro->save();
        return redirect()->route("admin.competencias_entrevistas.index")->with("mensaje_success", "Registro creado con exito");
    }

}
