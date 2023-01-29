<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Ciudad as ModeloTabla;
use App\Models\Departamento;
use App\Models\Pais;
use App\Models\Ciudad;
use App\Models\Agencia;
use Illuminate\Http\Request;
use App\Models\Sitio;

class CiudadController extends Controller
{

    public function index(Request $data)
    {   
        $paises = ["" => "Seleccionar"] + Pais::
            orderBy('nombre', "asc")
            ->pluck('nombre','cod_pais')
            ->toArray();

        $dptos = null;
        $ciudades = null;

        if ( $data->has('cod_pais') ) {
            $dptos = ["" => "Seleccionar"] + Departamento::orderBy('nombre')->where("cod_pais", $data->get('cod_pais'))
            ->pluck("nombre", "cod_departamento")
            ->toArray();
        }

        if ( $data->has('cod_pais') && $data->has('cod_departamento') ) {
            $ciudades = ["" => "Seleccionar"] + Ciudad::orderBy('nombre')->where("cod_departamento", $data->get('cod_departamento'))
            ->where("cod_pais",$data->get('cod_pais'))
            ->pluck("nombre", "cod_ciudad")
            ->toArray();
        }

        $listas = ModeloTabla::join('paises', 'paises.cod_pais', '=', 'ciudad.cod_pais')
                ->join('departamentos', function ($join) {
                    $join->on('departamentos.cod_departamento', '=', 'ciudad.cod_departamento')
                    ->on('departamentos.cod_pais', '=', 'ciudad.cod_pais');
                })
                ->where(function ($where) use ($data) {
                    
                    if ($data->get("nombre") != "") {
                        $where->where("ciudad.nombre", "like", "%" . $data->get("nombre") . "%");
                    }

                    if($data->get("cod_pais") != "") {
                        $where->where("paises.cod_pais", $data->get("cod_pais"));
                    }

                    if ($data->get("cod_departamento") != "") {
                        $where->where("ciudad.cod_departamento", $data->get("cod_departamento"));
                    }

                    if ($data->get("cod_ciudad") != "") {
                        $where->where("ciudad.cod_ciudad", $data->get("cod_ciudad"));
                    }

        })
        ->select('ciudad.*', 'paises.nombre as pais', 'departamentos.nombre as departamento')
        ->paginate(10);

        return view("admin.ciudad.index", compact("listas", "paises", "dptos", "ciudades"));
    }

    public function editar($id, Request $data)
    {
        $registro     = ModeloTabla::find($id);

        $paises       = ["" => "Seleccionar"] + Pais::orderBy("nombre", "asc")->pluck("nombre", "cod_pais")->toArray();

        $departamento = ["" => "Seleccionar"] + Departamento::orderBy("nombre", "asc")->where("cod_pais", $registro->cod_pais)->pluck("nombre", "cod_departamento")->toArray();

        $sitio = Sitio::first();
        $agencias=null;

        if($sitio->agencias){
            $agencias = ["" => "Seleccionar"] + Agencia::pluck("agencias.descripcion","agencias.id")->toArray();
        }

        return view("admin.ciudad.editar", compact("registro", "paises", "departamento", "agencias"));
    }

    public function actualizar(Request $datos, Requests\CiudadEditarRequest $valida)
    {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        $registro->save();
        return redirect()->route("admin.ciudad.index")->with("mensaje_success", "Registro actualizado con exito");
    }

    public function nuevo(Request $data)
    {
        
        $paises = ["" => "Seleccionar"] + Pais::
            orderBy('nombre', "asc")
            ->pluck('nombre','cod_pais')
            ->toArray();

        $sitio = Sitio::first();
        $agencias=null;

        if($sitio->agencias){
            $agencias = ["" => "Seleccionar"] + Agencia::pluck("agencias.descripcion","agencias.id")->toArray();
        }
        
        return view("admin.ciudad.nuevo",compact('paises', 'agencias'));
    }

    public function guardar(Request $data, Requests\CiudadNuevoRequest $valida)
    {
        $registro = new ModeloTabla();
        $registro->fill($data->all());
        $registro->save();

        $registro->cod_ciudad = $registro->id;
        $registro->save();
        
        return redirect()->route("admin.ciudad.index")->with("mensaje_success", "Registro creado con exito");
    }

    public function pruebame()
    {
        $ciudad = Ciudad::find(10);
        $ciudad->agencia = 'cambio a agencia';
        $ciudad->save();
    }

}
