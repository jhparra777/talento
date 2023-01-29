<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\CargoEspecifico;
use App\Models\Clientes;
use App\Models\DocumentosCargo;
use App\Models\TipoDocumento as ModeloTabla;
use Illuminate\Http\Request;
use DB;

class TiposDocumentosController extends Controller
{
    public function index(Request $data)
    {
        $listas = ModeloTabla::where(function ($where) use ($data) {
            if ($data->get("descripcion") != "") {
                $where->where("descripcion", "like", "%" . $data->get("descripcion") . "%");
            }
            if ($data->get("categoria") != "") {
                $where->where("categoria", $data->get("categoria"));
            }
            if ($data->get("active") != "") {
                $where->where("active", $data->get("active"));
            }

        })->paginate(10);
        $categorias = ["" => "- Seleccionar -"] + DB::table('categoria_documentos')->orderBy(DB::raw("UPPER(descripcion)"),"ASC")->pluck("descripcion", "id")->toArray();

        return view("admin.tipos_documentos.index", compact("listas", "categorias"));
    }

    public function editar($id, Request $data)
    {
        $registro = ModeloTabla::find($id);
        $categorias = ["" => "- Seleccionar -"] + DB::table('categoria_documentos')->pluck("descripcion", "id")->toArray();
        return view("admin.tipos_documentos.editar", compact("registro", "categorias"));
    }

    public function actualizar(Request $datos, Requests\TiposDocumentosEditarRequest $valida)
    {
        $registro = ModeloTabla::find($datos->get("id"));
        $registro->fill($datos->all());
        $registro->save();
        return redirect()->route("admin.tipos_documentos.index")->with("mensaje_success", "Tipo documento actualizado con éxito");
    }

    public function nuevo(Request $data)
    {
        $categorias = ["" => "- Seleccionar -"] + DB::table('categoria_documentos')->pluck("descripcion", "id")->toArray();
        return view("admin.tipos_documentos.nuevo", ['categorias' => $categorias]);
    }

    public function guardar(Request $data, Requests\TiposDocumentosNuevoRequest $valida)
    {
        $registro = new ModeloTabla();
        $registro->fill($data->all());
        $registro->save();

        if ($data->categoria == config('conf_aplicacion.CATEGORIA_POST_CONTRATACION') || $data->categoria == config('conf_aplicacion.CATEGORIA_CONFIDENCIALES')) {
            $cargos_a_asociar = CargoEspecifico::select('id')->get();

            foreach ($cargos_a_asociar as $cargo) {
                $cargo_documento = new DocumentosCargo();

                $cargo_documento->cargo_especifico_id = $cargo->id;
                $cargo_documento->tipo_documento_id   = $registro->id;
                $cargo_documento->save();
            }
            return redirect()->route("admin.tipos_documentos.index")->with("mensaje_success", "Tipo documento creado con éxito y asociado a todos los cargos");
        }
        if ($data->categoria == 5) {
            return redirect()->route("admin.tipos_documentos.index")->with("mensaje_success", "Tipo documento creado con éxito");
        }
        if ($this->user->hasAccess("admin.tipos_documentos.asociar_cargos")) {
            return redirect()->route("admin.tipos_documentos.asociar_cargos", ['tipo_documento_id' => $registro->id])->with("mensaje_success", "Tipo documento creado con éxito");
        }
        return redirect()->route("admin.tipos_documentos.index")->with("mensaje_success", "Tipo documento creado con éxito");
    }

    public function asociar_cargos_tipos_documentos_view($tipo_documento_id)
    {
        $clientes = ["" => "Seleccionar"] + Clientes::orderBy("clientes.nombre", "ASC")->pluck("clientes.nombre", "clientes.id")->toArray();

        $cargos_asociados = DocumentosCargo::join("tipos_documentos", "tipos_documentos.id", "=", "cargo_documento.tipo_documento_id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "cargo_documento.cargo_especifico_id")
        ->join("clientes", "clientes.id", "=", "cargos_especificos.clt_codigo")
        ->where("cargo_documento.tipo_documento_id", $tipo_documento_id)
        ->select(
            "cargo_documento.id as cargo_documento_id",
            "cargos_especificos.descripcion as nombre_cargo",
            "cargos_especificos.id as cargo_adicional_id",
            "clientes.nombre as nombre_cliente"
        )
        ->get();

        //dd($cargos_asociados);

        $nombre_tipo_doc = ModeloTabla::find($tipo_documento_id);

        return view('admin.tipos_documentos.asociar_cargos', compact('clientes', 'cargos_asociados', 'tipo_documento_id', 'nombre_tipo_doc'));
    }

    public function asociar_cargos_guardar(Request $request) {
        if ($request->has('cargo_especifico_asociar')) {
            $cargos_especifico_asociar = $request->cargo_especifico_asociar;
        } else {
            $todos_cargos = CargoEspecifico::select('id')->get();
            $cargos_especifico_asociar = $todos_cargos->pluck('id');
        }

        $tipo_documento_id = $request->tipo_documento_id;

        $cargos_documentos_asociados = DocumentosCargo::whereIn('cargo_especifico_id', $cargos_especifico_asociar)
            ->where('tipo_documento_id', $tipo_documento_id)
            ->select('cargo_especifico_id as cargos_a_asociar')
        ->get();

        foreach ($cargos_especifico_asociar as $cargo_esp) {
            $existe = $cargos_documentos_asociados->where('cargos_a_asociar', $cargo_esp)->first();
            if ($existe == null) {
                $asignar_a_cargo = new DocumentosCargo();
                $asignar_a_cargo->fill([
                    "cargo_especifico_id"   => $cargo_esp,
                    "tipo_documento_id"     => $tipo_documento_id
                ]);
                $asignar_a_cargo->save();
            }
        }

        return response()->json([
            "success" => true
        ]);
    }

    public function eliminar_cargo_documento(Request $request) {
        $cargo_documento_id = $request->cargo_documento_id;

        $response = DB::table('cargo_documento')->where('id', $cargo_documento_id)->delete();

        return response()->json(['response' => $response]);
    }
}
