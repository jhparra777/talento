<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Proveedor;
use App\Models\TipoProveedor;
use App\Models\ProveedorTipoProveedor;
use App\Models\ExamenMedico;
class ExamenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $data)
    {
       
        $examenes=ExamenMedico::all();
        
        return view("admin.contratacion.examenes.index",compact("examenes"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view("admin.contratacion.examenes.modal.nuevo");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $examen=new ExamenMedico();
        $examen->fill([
            "nombre"=> $request->nombre,
            "descripcion"=>$request->descripcion,
           
        ]);
        $examen->save();
        
        
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
        
        $examen=ExamenMedico::find($request->id);
          return view("admin.contratacion.examenes.modal.editar",compact("examen"));
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
        $examen=ExamenMedico::find($request->id);
        $examen->fill($request->all());

        if($request->activo!=null){
            $examen->status=1;
        }
        else{
            $examen->status=0;
        }
        $examen->save();
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
