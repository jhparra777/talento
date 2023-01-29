<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\CargoGenerico as ModeloTabla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CargosGenericosController extends Controller
{

    public function index(Request $data)
    {
        $listas = ModeloTabla::
            orderBy('id','DESC')
            ->get();

        $tiposCargos = ["" => "Seleccionar"]+\App\Models\TipoCargo::pluck("descripcion", "id")->toArray();
        return view("admin.cargos_genericos.index", compact("listas", "tiposCargos"));
    }

    public function editar(Request $request)
    {
        $registro    = ModeloTabla::find($request->id);
        $tiposCargos = ["" => "Seleccionar"]+\App\Models\TipoCargo::pluck("descripcion", "id")->toArray();

        return view("admin.cargos_genericos.modal.editar", compact("registro", "tiposCargos"));
    }

    public function actualizar(Request $datos, Requests\CargosGenericosEditarRequest $valida)
    {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        $registro->save();
        return response()->json(["success" => true]);
    }

    public function nuevo(Request $data)
    {
        $tiposCargos = ["" => "Seleccionar"]+\App\Models\TipoCargo::pluck("descripcion", "id")->toArray();
        return view("admin.cargos_genericos.nuevo", compact("tiposCargos"));
    }

    public function guardar(Request $data, Requests\CargosGenericosNuevoRequest $valida)
    {
        $registro = new ModeloTabla();
        $registro->fill($data->all());
        $registro->save();
        return redirect()->route("admin.cargos_genericos.index")->with("mensaje_success", "Registro creado con exito");
    }

}
