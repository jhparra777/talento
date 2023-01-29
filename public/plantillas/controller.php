<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AspiracionSalarial as ModeloTabla;

class {{nombre_controller}}Controller extends Controller {

    public function index(Request $data) {
        $listas = ModeloTabla::where(function($where)use($data) {
        {{where}}
                })->paginate(10);
        return view("admin.{{tabla}}.index", compact("listas"));
    }

    public function editar($id, Request $data) {
        $registro = ModeloTabla::find($id);
        return view("admin.{{tabla}}.editar", compact("registro"));
    }

    public function actualizar(Request $datos,Requests\{{requet_editar}}Request $valida) {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        $registro->save();
        return redirect()->route("admin.{{tabla}}.index")->with("mensaje_success", "Registro actualizado con exito");
    }

    public function nuevo(Request $data) {

        return view("admin.{{tabla}}.nuevo");
    }

    public function guardar(Request $data,Requests\{{requet_nuevo}}Request $valida) {
        $registro = new ModeloTabla();
        $registro->fill($data->all());
        $registro->save();
        return redirect()->route("admin.{{tabla}}.index")->with("mensaje_success", "Registro creado con exito");
    }

}
