<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\MotivosRechazos as ModeloTabla;
use Illuminate\Http\Request;

class MotivosRechazosController extends Controller
{

    public function index(Request $data)
    {
        $listas = ModeloTabla::where(function ($where) use ($data) {
            if ($data->get("descripcion") != "") {
                $where->where("descripcion", "like", "%" . $data->get("descripcion") . "%");
            }

        })->paginate(10);
        return view("admin.motivos_rechazos.index", compact("listas"));
    }

    public function editar($id, Request $data)
    {
        $registro = ModeloTabla::find($id);
        return view("admin.motivos_rechazos.editar", compact("registro"));
    }

    public function actualizar(Request $datos, Requests\MotivosRechazosEditarRequest $valida)
    {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        $registro->save();
        return redirect()->route("admin.motivos_rechazos.index")->with("mensaje_success", "Registro actualizado con exito");
    }

    public function nuevo(Request $data)
    {

        return view("admin.motivos_rechazos.nuevo");
    }

    public function guardar(Request $data, Requests\MotivosRechazosNuevoRequest $valida)
    {
        $registro = new ModeloTabla();
        $registro->fill($data->all());
        $registro->save();
        return redirect()->route("admin.motivos_rechazos.index")->with("mensaje_success", "Registro creado con exito");
    }

}
