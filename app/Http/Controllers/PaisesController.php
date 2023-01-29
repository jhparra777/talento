<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Pais as ModeloTabla;
use Illuminate\Http\Request;

class PaisesController extends Controller
{

    public function index(Request $data)
    {
        $listas = ModeloTabla::where(function ($where) use ($data) {
            if ($data->get("nombre") != "") {
                $where->where("lower(nombre)", "like", "%" . strtolower($data->get("nombre")) . "%");
            }
            if ($data->get("cod_pais") != "") {
                $where->where("cod_pais", "like", "%" . $data->get("cod_pais") . "%");
            }

        })->paginate(10);
        return view("admin.paises.index", compact("listas"));
    }

    public function editar($id, Request $data)
    {
        $registro = ModeloTabla::find($id);
        return view("admin.paises.editar", compact("registro"));
    }

    public function actualizar(Request $datos, Requests\PaisesEditarRequest $valida)
    {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        $registro->save();
        return redirect()->route("admin.paises.index")->with("mensaje_success", "Registro actualizado con exito");
    }

    public function nuevo(Request $data)
    {

        return view("admin.paises.nuevo");
    }

    public function guardar(Request $data, Requests\PaisesNuevoRequest $valida)
    {
        $registro = new ModeloTabla();
        $registro->fill($data->all());
        $registro->save();
        return redirect()->route("admin.paises.index")->with("mensaje_success", "Registro creado con exito");
    }

}
