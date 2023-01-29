<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\AspiracionSalarial as ModeloTabla;
use Illuminate\Http\Request;

class AspiracionSalarialController extends Controller
{
    public function index(Request $data)
    {
        //ModeloTabla es AspiracionSalarial ._. por razones desconocidas
        $listas = ModeloTabla::where(function ($where) use ($data) {
            if ($data->get("descripcion") != "") {
                $where->where("descripcion", "like", "%" . $data->get("descripcion") . "%");
            }
            if ($data->get("active") != "") {
                $where->where("active", "like", "%" . $data->get("active") . "%");
            }
        })->paginate(10);

        return view("admin.aspiracion_salarial.index", compact("listas"));
    }

    public function editar($id, Request $data)
    {
        $registro = ModeloTabla::find($id);
        return view("admin.aspiracion_salarial.editar", compact("registro"));
    }

    public function actualizar(Request $datos, Requests\AspiracionSalarialEditarRequest $valida)
    {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        $registro->save();

        return redirect()->route("admin.aspiracion_salarial.index")->with("mensaje_success", "Registro actualizado con éxito");
    }

    public function nuevo(Request $data)
    {
        return view("admin.aspiracion_salarial.nuevo");
    }

    public function guardar(Request $data, Requests\AspiracionSalarialNuevoRequest $valida)
    {
        $registro = new ModeloTabla();
        $registro->fill($data->all() + ["active" => 1]);
        $registro->save();

        return redirect()->route("admin.aspiracion_salarial.index")->with("mensaje_success", "Registro creado con éxito");
    }

}
