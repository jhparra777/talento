<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\PruebaBrigConfigCargo;
use App\Models\PruebaBrigConfigRequerimiento;
use App\Models\Requerimiento;

class PruebaBrygConfiguracionController extends Controller
{
    //Visualizar configuración
    public function configuracionBrygModal(Request $request)
    {
        //Buscar configuración
        if ($request->has('cargo_id')) {
            $cargo_id = $request->cargo_id;
            $configuracion = PruebaBrigConfigCargo::where('cargo_id', $cargo_id)->orderBy('created_at', 'DESC')->first();
        }else {
            $req_id = $request->req_id;
            $configuracion = PruebaBrigConfigRequerimiento::where('req_id', $req_id)->orderBy('created_at', 'DESC')->first();
            if (empty($configuracion)) {
                $requerimiento = Requerimiento::select('cargo_especifico_id')->find($req_id);
                $configuracion = PruebaBrigConfigCargo::where('cargo_id', $requerimiento->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();
            }
        }

        if (empty($configuracion)) {
            return response()->json(['configuracion' => null]);
        }

        return response()->json(['configuracion' => $configuracion]);
    }

    public function guardarConfiguracionBryg(Request $request) {
        if (!$request->has('cargo_modulo')) {
            $req_id = $request->req_id;

            //Buscar configuración
            $configuracion = PruebaBrigConfigRequerimiento::where('req_id', $req_id)->orderBy('created_at', 'DESC')->first();

            if (empty($configuracion)) {
                //Nueva
                $nuevaConfiguración = new PruebaBrigConfigRequerimiento();

                $nuevaConfiguración->fill([
                    'req_id' => $req_id,
                    'radical' => $request->radical,
                    'genuino' => $request->genuino,
                    'garante' => $request->garante,
                    'basico' => $request->basico,
                    'perfil' => $request->perfil
                ]);
                $nuevaConfiguración->save();
            }else {
                //Actualiza
                $configuracion->radical = $request->radical;
                $configuracion->genuino = $request->genuino;
                $configuracion->garante = $request->garante;
                $configuracion->basico = $request->basico;
                $configuracion->perfil = $request->perfil;
                $configuracion->save();
            }
        }else {
            $cargo_id = $request->cargo_id;

            if (empty($cargo_id)) {
                $configuracion = null;
            }else {
                //Buscar configuración
                $configuracion = PruebaBrigConfigCargo::where('cargo_id', $cargo_id)->orderBy('created_at', 'DESC')->first();
            }

            if (empty($configuracion)) {
                //Nueva
                $nuevaConfiguración = new PruebaBrigConfigCargo();

                $nuevaConfiguración->fill([
                    'radical' => $request->radical,
                    'genuino' => $request->genuino,
                    'garante' => $request->garante,
                    'basico' => $request->basico,
                    'perfil' => $request->perfil
                ]);
                $nuevaConfiguración->save();

                //Para cargos creados pero sin configuración
                if (!empty($cargo_id)) {
                    $nuevaConfiguración->cargo_id = $cargo_id;
                    $nuevaConfiguración->save();
                }
            }else {
                //Actualiza
                $configuracion->radical = $request->radical;
                $configuracion->genuino = $request->genuino;
                $configuracion->garante = $request->garante;
                $configuracion->basico = $request->basico;
                $configuracion->perfil = $request->perfil;
                $configuracion->save();
            }
        }

        return response()->json(['success' => true, 'configuracionId' => $nuevaConfiguración->id]);
    }
}
