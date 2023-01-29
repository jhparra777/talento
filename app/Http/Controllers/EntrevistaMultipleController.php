<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\EntrevistaMultiple;
use App\Models\EntrevistaMultipleDetalles;
use App\Models\RegistroProceso;

class EntrevistaMultipleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->requerimiento_id != null) {
            $entrevistas = EntrevistaMultiple::where('req_id', $request->requerimiento_id)->paginate(10);
        } else {
            $entrevistas = EntrevistaMultiple::orderBy('id', 'desc')->paginate(10);
        }
        return view("admin.reclutamiento.entrevistas_multiples", compact("entrevistas"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar_detalles_entre_multiple(Request $request)
    {
        if (isset($request->entrevista_detalles_id)) {
            $entrevista_detalles = EntrevistaMultipleDetalles::find($request->entrevista_detalles_id);

            if ($entrevista_detalles != null) {
                $entrevista_detalles->concepto = $request->concepto;
                $entrevista_detalles->calificacion = $request->calificacion;
                $entrevista_detalles->gestiono = $this->user->id;
                $entrevista_detalles->apto = $request->apto;

                $entrevista_detalles->save();

                $proceso = RegistroProceso::where('requerimiento_id', $entrevista_detalles->req_id)
                    ->where('candidato_id', $entrevista_detalles->candidato_id)
                    ->where('proceso', 'ENTREVISTA_MULTIPLE')
                    ->orderBy('id', 'desc')
                ->first();

                $proceso->apto = $request->apto;
                $proceso->save();

                return response()->json(["success" => true]);
            }
        }
        return response()->json(["success" => false]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar_varios_detalles_entre_multiple(Request $request)
    {
        $concepto_general_modificado = $request->concepto_general_modificado;
        if ($concepto_general_modificado) {
            $entrevista_multiple = EntrevistaMultiple::find($request->idEntrevistaMultiple);
            if ($entrevista_multiple != null) {
                $entrevista_multiple->concepto_general = $request->concepto_general;

                $entrevista_multiple->save();
            }
        }
        $detalles = $request->detalles;
        $total_candidatos = count($detalles);
        $guardado = 0;
        foreach ($detalles as $key => $detalle) {
            if (isset($detalle['idEntrevistaDetalles'])) {
                $entrevista_detalles = EntrevistaMultipleDetalles::find($detalle['idEntrevistaDetalles']);

                if ($entrevista_detalles != null) {
                    $entrevista_detalles->concepto = $detalle['concepto'];
                    if ($detalle['calificacion'] > 0) {
                        $entrevista_detalles->calificacion = $detalle['calificacion'];
                    }
                    $entrevista_detalles->gestiono = $this->user->id;
                    $entrevista_detalles->apto = ($detalle['apto'] != '' ? $detalle['apto'] : null);

                    $entrevista_detalles->save();

                    if ($detalle['apto'] != null && $detalle['apto'] != '') {
                        $proceso = RegistroProceso::where('requerimiento_id', $entrevista_detalles->req_id)
                            ->where('candidato_id', $entrevista_detalles->candidato_id)
                            ->where('proceso', 'ENTREVISTA_MULTIPLE')
                            ->orderBy('id', 'desc')
                        ->first();

                        $proceso->apto = $detalle['apto'];
                        $proceso->save();
                    }

                    $guardado++;
                }
            }
        }
        if ($guardado > 0 || $concepto_general_modificado) {
            return response()->json(["success" => true, "candidatos_faltantes" => $total_candidatos - $guardado]);
        }
        return response()->json(["success" => false]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function gestionar_entrevista_multiple($id)
    {
        $user_sesion = $this->user;
        $entrevista = EntrevistaMultiple::find($id);
        if ($entrevista == null) {
            return redirect("pagenotfound");
        }
        return view("admin.reclutamiento.gestionar_entrevista_multiple", compact("entrevista", "user_sesion"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function guardar_concepto_entrevista_multiple(Request $request)
    {
        $entrevista_multiple = EntrevistaMultiple::find($request->entrevista_multiple_id);
        if ($entrevista_multiple != null) {
            $entrevista_multiple->concepto_general = $request->concepto;

            $entrevista_multiple->save();
            return response()->json(["success" => true]);
        }
        return response()->json(["success" => false]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ver_entrevista_multiple($entrevista_id)
    {
        $entrevista = EntrevistaMultiple::find($entrevista_id);
        if ($entrevista == null) {
            return redirect("pagenotfound");
        }

        $view = \View::make('admin.reclutamiento.pdf.entrevista-multiple', compact('entrevista'))->render();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream('entrevista_multiple.pdf');

        //return view("admin.reclutamiento.pdf.entrevista-multiple", compact("entrevista")); //Para vista de prueba local html
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
