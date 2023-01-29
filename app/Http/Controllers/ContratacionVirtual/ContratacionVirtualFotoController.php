<?php

namespace App\Http\Controllers\ContratacionVirtual;

use Illuminate\Http\Request;
use App\Models\FirmaContratos;
use App\Models\FirmaContratoFoto;
use App\Models\DocumentoAdicional;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use App\Models\ConfirmacionDocumentosAdicionales;

class ContratacionVirtualFotoController extends Controller
{
    //
    public function store(Request $request)
    {
        Log::channel('firma_fotos')->debug($request->except(['foto']));

        if ($request->has('firma_proceso')) {
            //Decrypt URL data
            $user_id = Crypt::decrypt($request->user_id);
            $user_id = Crypt::decrypt($request->req_id);
        }else {
            $user_id = $request->user_id;
            $req_id = $request->req_id;
        }

        $firma_contrato = FirmaContratos::where('user_id', $user_id)->where('req_id', $req_id)->select('id', 'user_id', 'req_id')->orderBy('id', 'DESC')->first();

        $estado = $request->camara;

        if (empty($firma_contrato)) {
            $firma_contrato = FirmaContratos::where('user_id', $this->user->id)->select('id', 'user_id', 'req_id')->orderBy('id', 'DESC')->first();
        }

        $adicionales_fotos_count = $this->adicionales_asociados($user_id, $req_id, $firma_contrato->id);

        if (!empty($adicionales_fotos_count) && ($adicionales_fotos_count['fotos_contrato'] <= $adicionales_fotos_count['adicionales'])) {
            $foto = $request->foto;

            $time_stamp = strtotime("now");

            //Convertir base64 a PNG
            $image_parts = explode(";base64,", $foto);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $fotoNombre = "candidato-foto-$user_id-$req_id-$firma_contrato->id-$time_stamp.png";

            Storage::disk('public')->put("recursos_firma_contrato_fotos/contrato_foto_$user_id"."_"."$req_id"."_"."$firma_contrato->id/$fotoNombre", $image_base64);

            //Guardar referencia foto en la tabla
            $firmaFoto = new FirmaContratoFoto();

            $firmaFoto->fill([
                'contrato_id' => $firma_contrato->id,
                'user_id' => $user_id,
                'req_id' => $req_id,
                'descripcion' => $fotoNombre,
                'estado' => $estado == 'true' ? null : 'El usuario no permitió el uso de la cámara del dispositivo'
            ]);
            $firmaFoto->save();

            return response()->json(['success' => true]);
        }
    }

    private function adicionales_asociados($user_id, $req_id, $contrato_id)
    {
        $adicionales = ConfirmacionDocumentosAdicionales::where('user_id', $user_id)->where('contrato_id', $contrato_id)->groupBy('documento_id')->get();

        $adicionales = count($adicionales);

        $fotos_contrato = FirmaContratoFoto::where('contrato_id', $contrato_id)->count();

        return ['adicionales' => $adicionales + 2, 'fotos_contrato' => $fotos_contrato];
    }
}
