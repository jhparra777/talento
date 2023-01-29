<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\TipoJornada as ModeloTabla;
use Illuminate\Http\Request;

class TiposJornadasController extends Controller
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
            if ($data->get("hora_inicio") != "") {
                $where->where("hora_inicio", "like", "%" . $data->get("hora_inicio") . "%");
            }
            if ($data->get("hora_fin") != "") {
                $where->where("hora_fin", "like", "%" . $data->get("hora_fin") . "%");
            }
            if ($data->get("procentaje_horas") != "") {
                $where->where("procentaje_horas", "like", "%" . $data->get("procentaje_horas") . "%");
            }

        })->paginate(10);
        return view("admin.tipos_jornadas.index", compact("listas"));
    }

    public function editar($id, Request $data)
    {
        $registro = ModeloTabla::find($id);
        return view("admin.tipos_jornadas.editar", compact("registro"));
    }

    public function actualizar(Request $datos, Requests\TiposJornadasEditarRequest $valida)
    {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        $registro->save();
        return redirect()->route("admin.tipos_jornadas.index")->with("mensaje_success", "Registro actualizado con exito");
    }

    public function nuevo(Request $data)
    {

        return view("admin.tipos_jornadas.nuevo");
    }

    public function guardar(Request $data, Requests\TiposJornadasNuevoRequest $valida)
    {
        $registro = new ModeloTabla();
        $registro->fill($data->all());
        $registro->save();
        return redirect()->route("admin.tipos_jornadas.index")->with("mensaje_success", "Registro creado con exito");
    }

}
