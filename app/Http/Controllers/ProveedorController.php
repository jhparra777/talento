<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use App\Models\TipoProveedor;
use App\Models\ProveedorTipoProveedor;
class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $data)
    {
        $tipo_proveedores=[""=>"Seleccionar"]+TipoProveedor::pluck("tipo","id")->toArray();
        $proveedores=Proveedor::join("proveedor_tipo_proveedor","proveedor_tipo_proveedor.proveedor","=","proveedor.id")
        
         ->where(function ($sql) use ($data) {
                        if ($data->has("id_proveedor") && $data->get("id_proveedor") != "") {
                            $sql->where("proveedor.id", $data->get("id_proveedor"));
                        }

                        if ($data->has("tipo_proveedor") && $data->get("tipo_proveedor") != "") {
                            $sql->where("proveedor_tipo_proveedor.tipo", $data->get("tipo_proveedor"));
                        }

                       
        })
        ->groupBy("proveedor.id")
        ->select("proveedor.id as id","proveedor.*")
        ->get();
        return view("admin.contratacion.proveedores.index",compact("proveedores","tipo_proveedores"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipos=TipoProveedor::all();
        return view("admin.contratacion.proveedores.modal.nuevo",compact("tipos"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $proveedor=new Proveedor();
        $proveedor->fill([
            "nombre"=> $request->nombre,
            "email"=>$request->email,
            "direccion"=>$request->direccion,
            "telefono"=>$request->telefono
        ]);
        $proveedor->save();
        if(isset($request->tipo)){
                foreach($request->tipo as $tipo){
                    $p_t_p=new ProveedorTipoProveedor();
                    $p_t_p->proveedor=$proveedor->id;
                    $p_t_p->tipo=$tipo;
                    $p_t_p->save();
            }
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $tipos=TipoProveedor::all();
        $proveedor=Proveedor::find($request->id);
          return view("admin.contratacion.proveedores.modal.editar",compact("proveedor","tipos"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $proveedor=Proveedor::find($request->id);
        $proveedor->fill($request->all());
        $proveedor->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
