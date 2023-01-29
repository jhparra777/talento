<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\TipoPrueba as ModeloTabla;
use Illuminate\Http\Request;

class TiposPruebasController extends Controller
{

    public function index(Request $data)
    {
        $listas = ModeloTabla::where(function ($where) use ($data) {
            if ($data->get("descripcion") != "") {
                $where->where("descripcion", "like", "%" . $data->get("descripcion") . "%");
            }
        })
        ->orderBy("estado","DESC")
        ->paginate(10);
        return view("admin.tipos_pruebas.index", compact("listas"));
    }

    public function editar($id, Request $data)
    {
        $registro = ModeloTabla::find($id);
        return view("admin.tipos_pruebas.editar", compact("registro"));
    }

    public function actualizar(Request $datos, Requests\TiposPruebasEditarRequest $valida)
    {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        $registro->save();
        return redirect()->route("admin.tipos_pruebas.index")->with("mensaje_success", "Registro actualizado con exito");
    }

    public function nuevo(Request $data)
    {

        return view("admin.tipos_pruebas.nuevo");
    }

    public function guardar(Request $data, Requests\TiposPruebasNuevoRequest $valida)
    {
        $registro = new ModeloTabla();
        $registro->fill($data->all());
        $registro->save();
        return redirect()->route("admin.tipos_pruebas.index")->with("mensaje_success", "Registro creado con exito");
    }

}
