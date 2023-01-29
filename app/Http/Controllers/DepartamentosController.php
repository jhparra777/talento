<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Departamento as ModeloTabla;
use Illuminate\Http\Request;
use App\Models\Pais;
use App\Models\Departamento;

class DepartamentosController extends Controller
{

    public function index(Request $data)
    {   
        $paises = ["" => "Seleccionar"] + Pais::
            orderBy('nombre', "asc")
            ->pluck('nombre','cod_pais')
            ->toArray();


        $dptos = null;

        if ( $data->has('cod_pais') ) {
            $dptos = ["" => "Seleccionar"] + Departamento::orderBy('nombre')->where("cod_pais", $data->get('cod_pais'))
            ->pluck("nombre", "cod_departamento")
            ->toArray();
        }

        $listas = ModeloTabla::join('paises', 'paises.cod_pais', '=', 'departamentos.cod_pais')
                ->where(function ($where) use ($data) {
                    if ($data->get("nombre") != "") {
                        $where->where("departamentos.nombre", "like", "%" . $data->get("nombre") . "%");
                    }

                    if($data->get("cod_pais") != "") {
                        $where->where("departamentos.cod_pais", $data->get("cod_pais"));
                    }

                    if ($data->get("cod_departamento") != "") {
                        $where->where("departamentos.cod_departamento", $data->get("cod_departamento"));
                    }

        })
        ->select('paises.nombre as pais', 'departamentos.*')
        ->paginate(10);

        return view("admin.departamentos.index", compact("listas", "paises", "dptos"));
    }

    public function editar($id, Request $data)
    {
        $registro = ModeloTabla::find($id);

        $paises = ["" => "Seleccionar"] + Pais::
            orderBy('nombre', "asc")
            ->pluck('nombre','cod_pais')
            ->toArray();

        return view("admin.departamentos.editar", compact("registro", "paises"));
    }

    public function actualizar(Request $datos, Requests\DepartamentosEditarRequest $valida)
    {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        $registro->save();
        
        return redirect()->route("admin.departamentos.index")->with("mensaje_success", "Registro actualizado con exito");
    }

    public function nuevo(Request $data)
    {
        $paises = ["" => "Seleccionar"] + Pais::
            orderBy('nombre', "asc")
            ->pluck('nombre','cod_pais')
            ->toArray();

        return view("admin.departamentos.nuevo", compact('paises'));
    }

    public function guardar(Request $data, Requests\DepartamentosNuevoRequest $valida)
    {
        $registro = new ModeloTabla();
        $registro->fill($data->all());
        $registro->save();

        $registro->cod_departamento = $registro->id;
        $registro->save();

        return redirect()->route("admin.departamentos.index")->with("mensaje_success", "Registro creado con exito");
    }

}
