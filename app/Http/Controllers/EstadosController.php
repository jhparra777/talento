<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\AspiracionSalarial as ModeloTabla;
use Illuminate\Http\Request;

class EstadosController extends Controller
{

    public function index(Request $data)
    {
        $listas = ModeloTabla::where(function ($where) use ($data) {
            if ($data->get("descripcion") != "") {
                $where->where("descripcion", "like", "%" . $data->get("descripcion") . "%");
            }
            if ($data->get("tipo") != "") {
                $where->where("tipo", "like", "%" . $data->get("tipo") . "%");
            }
            if ($data->get("cod_estado") != "") {
                $where->where("cod_estado", "like", "%" . $data->get("cod_estado") . "%");
            }
            if ($data->get("observaciones") != "") {
                $where->where("observaciones", "like", "%" . $data->get("observaciones") . "%");
            }

        })->paginate(10);
        return view("admin.estados.index", compact("listas"));
    }

    public function editar($id, Request $data)
    {
        $registro = ModeloTabla::find($id);
        return view("admin.estados.editar", compact("registro"));
    }

    public function actualizar(Request $datos, Requests\EstadosEditarRequest $valida)
    {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        $registro->save();
        return redirect()->route("admin.estados.index")->with("mensaje_success", "Registro actualizado con exito");
    }

    public function nuevo(Request $data)
    {

        return view("admin.estados.nuevo");
    }

    public function guardar(Request $data, Requests\EstadosNuevoRequest $valida)
    {
        $registro = new ModeloTabla();
        $registro->fill($data->all());
        $registro->save();
        return redirect()->route("admin.estados.index")->with("mensaje_success", "Registro creado con exito");
    }

}
