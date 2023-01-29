<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Maatwebsite\Excel\Facades\Excel;

use \DB;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Auditoria;
use App\Models\DatosBasicos;
use App\Models\ListaNegra;


class ListaNegraController extends Controller
{
    public function index() {
        $tipos_restricciones = ['' => 'Seleccionar'] + DB::table('tipos_restricciones')->select('descripcion', 'id')->where('active', 1)->pluck("descripcion", "id")->toArray();

        //dd($tipos_restricciones);

        $datos_lista_especial = ListaNegra::leftjoin('tipos_restricciones', 'tipos_restricciones.id', '=', 'lista_negra.restriccion_id')
            ->select('cedula', 'descripcion')
        ->get();

        return view('admin.lista_negra.lista_negra')->with(
            [
            'tipos_restricciones' => $tipos_restricciones,
            'datos_lista_especial' => $datos_lista_especial
            ]);
    }

    public function agregar_cedula_lista_negra(Request $data)
    {
        $response = false;
        $lista_negra = ListaNegra::where('cedula', $data->cedula)->first();

        if ($lista_negra == null) {
            $lista_negra = new ListaNegra();
            $lista_negra->cedula = $data->cedula;
            $lista_negra->restriccion_id = $data->restriccion_id;
            $lista_negra->gestiono = $this->user->id;
            $response = $lista_negra->save();
        }

        if ($response) {
            $candi = DatosBasicos::where('numero_id', $data->cedula)->first();

            if ($candi != null) {
                $restriccion = DB::table('tipos_restricciones')->select('descripcion', 'id')->find($data->restriccion_id);

                //ACTIVAR USUARIO Evento
                $auditoria                = new Auditoria();
                $auditoria->observaciones = 'Se agrego al listado especial con la restricción ' . $restriccion->descripcion;
                $auditoria->valor_antes   = json_encode(["estado" => $candi->estado_reclutamiento]);
                $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.PROBLEMA_SEGURIDAD')]);
                $auditoria->user_id       = $this->user->id;
                $auditoria->tabla         = "datos_basicos";
                $auditoria->tabla_id      = $candi->id;
                $auditoria->tipo          = 'ACTUALIZAR';
                event(new \App\Events\AuditoriaEvent($auditoria));

                $candi->estado_reclutamiento = config('conf_aplicacion.PROBLEMA_SEGURIDAD');
                $candi->save();
            }
        }

        return response()->json(['rs' => $response]);
    }

    public function agregar_cedula_lista_negra_masivo(Request $data) {
        $rules = [
            'archivo' => 'required'
        ];

        $valida = Validator::make($data->all(), $rules);
        if ($valida->fails()) {
            return redirect()->back()->withErrors($valida)->withInput();
        }

        $reader = Excel::selectSheetsByIndex(0)->load($data->file("archivo"))->get();

        $errores_global      = [];
        $registrosInsertados = 0;

        foreach ($reader as $key => $value) {
            $errores = [];
            $datos   = [
                'cedula'        => $value->cedula,
                'restriccion'   => $value->restriccion
            ];

            $guardar = true;

            $cedula = Validator::make($datos, ["cedula" => "required"]);
            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "El campo cédula es obligatorio.");
            }

            $cedula = Validator::make($datos, ["cedula" => "numeric"]);
            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "La cédula debe ser numérico.");
            }

            $cedula = Validator::make($datos, ["cedula" => "unique:lista_negra,cedula"]);
            if ($cedula->fails()) {
                $guardar = false;
                array_push($errores, "Este número de cédula $value->cedula ya ha sido cargado.");
            }

            $restriccion = Validator::make($datos, ["restriccion" => "required"]);
            if ($restriccion->fails()) {
                $guardar = false;
                array_push($errores, "El campo restricción es obligatorio.");
            }

            if ($guardar) {
                $lista_negra = new ListaNegra();
                $lista_negra->cedula = $value->cedula;
                $lista_negra->restriccion_id = $value->restriccion;
                $lista_negra->gestiono = $this->user->id;
                $response = $lista_negra->save();

                if ($response) {
                    /*$cedula = DatosBasicos::where("numero_id", $value->cedula)
                        ->whereIn("estado_reclutamiento", [
                            config('conf_aplicacion.C_CONTRATADO'),
                            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        ])
                    ->first();

                    if ($cedula !== null) {
                        array_push($errores, "Este número de cédula $value->cedula se encuentra en un proceso actualmente.");
                    }*/

                    $candi = DatosBasicos::where('numero_id', $value->cedula)->first();

                    if ($candi != null) {
                        $restriccion = DB::table('tipos_restricciones')->select('descripcion', 'id')->find($value->restriccion);

                        //ACTIVAR USUARIO Evento
                        $auditoria                = new Auditoria();
                        $auditoria->observaciones = 'Se agrego al listado especial con la restricción ' . $restriccion->descripcion;
                        $auditoria->valor_antes   = json_encode(["estado" => $candi->estado_reclutamiento]);
                        $auditoria->valor_despues = json_encode(["estado" => config('conf_aplicacion.PROBLEMA_SEGURIDAD')]);
                        $auditoria->user_id       = $this->user->id;
                        $auditoria->tabla         = "datos_basicos";
                        $auditoria->tabla_id      = $candi->id;
                        $auditoria->tipo          = 'ACTUALIZAR';
                        event(new \App\Events\AuditoriaEvent($auditoria));

                        $candi->estado_reclutamiento = config('conf_aplicacion.PROBLEMA_SEGURIDAD');
                        $candi->save();
                    }
                }

                $registrosInsertados++;
            } else {
                $errores_global[$key] = $errores;
            }
        }

        return redirect()->route("admin.lista_negra")->with("mensaje_success", "Se han cargado <b>$registrosInsertados</b> con éxito.")->with("errores_global", $errores_global);
    }
}
