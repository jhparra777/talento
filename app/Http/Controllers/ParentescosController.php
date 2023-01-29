<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Parentesco as ModeloTabla;
use Illuminate\Http\Request;

class ParentescosController extends Controller
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
        return view("admin.parentescos.index", compact("listas"));
    }

    public function editar($id, Request $data)
    {
        $registro = ModeloTabla::find($id);
        return view("admin.parentescos.editar", compact("registro"));
    }

    public function actualizar(Request $datos, Requests\ParentescosEditarRequest $valida)
    {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        $registro->save();
        return redirect()->route("admin.parentescos.index")->with("mensaje_success", "Registro actualizado con exito");
    }

    public function nuevo(Request $data)
    {

        return view("admin.parentescos.nuevo");
    }

    public function guardar(Request $data, Requests\ParentescosNuevoRequest $valida)
    {
        $registro = new ModeloTabla();
        $registro->fill($data->all());
        $registro->save();
        return redirect()->route("admin.parentescos.index")->with("mensaje_success", "Registro creado con exito");
    }

}
