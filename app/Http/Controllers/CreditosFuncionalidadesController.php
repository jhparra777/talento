<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TipoFuncionalidadAvanzada;
use App\Models\ControlFuncionalidad;
use App\Models\TrazabilidadFuncionalidad;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CreditosFuncionalidadesController extends Controller
{
    public function index()
    {
        //
        $empresaFuncionalidades = ControlFuncionalidad::join('tipo_funcionalidad_avanzada', 'tipo_funcionalidad_avanzada.id', '=', 'control_funcionalidad.tipo_funcionalidad')
        ->where('tipo_funcionalidad_avanzada.activo', 1)
        ->select('control_funcionalidad.*','tipo_funcionalidad_avanzada.descripcion as descripcionFuncion')
        ->get();

        return view("admin.creditos_funcionalidades.index", compact('empresaFuncionalidades'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request, $tipo_id, $control_id, $limite)
    {
        //Obtiene el mes actual.
        $mes = date("n");

        $datosCount = TrazabilidadFuncionalidad::join('control_funcionalidad', 'control_funcionalidad.id', '=', 'trazabilidad_funcionalidades.control_id')
        ->where('control_funcionalidad.tipo_funcionalidad', $tipo_id)
        ->whereMonth('trazabilidad_funcionalidades.created_at', '=', $mes)
        ->select('trazabilidad_funcionalidades.*', 'control_funcionalidad.limite as limite')
        ->count();

        $restantes = $limite - $datosCount;        

        return view("admin.creditos_funcionalidades.show", compact('datosCount','limite','restantes'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
