<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\MotivoRequerimiento as ModeloTabla;
use Illuminate\Http\Request;

class MotivoRequerimientoController extends Controller
{

    public function index(Request $data)
    {   

        $listas = ModeloTabla::descripcion($data)
                            ->active($data)
                            ->paginate(10);

        return view("admin.motivo_requerimiento.index", compact("listas"));
    }

    public function editar($id, Request $data)
    {
        $registro = ModeloTabla::find($id);
        return view("admin.motivo_requerimiento.editar", compact("registro"));
    }

    public function actualizar(Request $datos, Requests\MotivoRequerimientoEditarRequest $valida)
    {   
        $registro = ModeloTabla::find($datos->get("id"));

        $registro->update([
            'descripcion' => $datos->descripcion,
            'active'      => isset($datos->active) ? 1 : 0
        ]);

        return redirect()->route("admin.motivo_requerimiento.index")->with("mensaje_success", "Registro actualizado con exito");
    }

    public function nuevo(Request $data)
    {

        return view("admin.motivo_requerimiento.nuevo");
    }

    public function guardar(Request $data, Requests\MotivoRequerimientoNuevoRequest $valida)
    {

        $registro = new ModeloTabla();
        $registro->create([
            'descripcion'   => $data->descripcion,
            'active'        => isset($data->active) ? 1 : 0
        ]);

        return redirect()->route("admin.motivo_requerimiento.index")->with("mensaje_success", "Registro creado con exito");
    }

}
