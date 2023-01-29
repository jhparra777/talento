<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Jobs\FuncionesGlobales;
use App\Models\ConsultaSeguridadRegistro;
use App\Http\Controllers\ListaVinculanteController;
use App\Http\Controllers\ConsultaSeguridadController;

class ConsultaValidacionDocumentoCore extends Controller
{
    public function validar_limite(Request $request)
    {
        $opcion = $request->opcion;

        $consulta_seguridad = new ConsultaSeguridadController();
        $listas_vinculantes = new ListaVinculanteController();

        if ($opcion == 'consulta_seguridad') {
            return $consulta_seguridad->ConsultaVerifica($request);
        }else {
            return $listas_vinculantes->verificarLimite($request);
        }
    }

    public function validar_documento(Request $request)
    {
        $opcion = $request->opcion;
        
        $consulta_seguridad = new ConsultaSeguridadController();
        $listas_vinculantes = new ListaVinculanteController();

        $json = $this->peticion_api($request->a);

        if ($opcion == 'consulta_seguridad') {
            $acceso = $this->validar_acceso($request->d);

            if ($acceso) {
                $listas_vinculantes->consultarDocumento($request, $json);
            }

            $url_pdf = $consulta_seguridad->QueryPerson($request, $json, true);
        }else {
            $consulta_seguridad->QueryPerson($request, $json);
            $url_pdf = $listas_vinculantes->consultarDocumento($request, $json, true);
        }

        return $url_pdf;
    }

    private function validar_acceso($cliente_id)
    {
        /**
        * Lista vinculante acceso
        */

        $lista_vinculante_acceso = FuncionesGlobales::getListaVinculanteAcceso($cliente_id);

        return $lista_vinculante_acceso;
    }

    private function peticion_api($cc)
    {
        $type = 1;

        $url = "AnalyzerOnLine?IdentificationType=".$type."&SearchParam=".$cc."&Token=J33TRWJI";

        $client = new Client([
            'base_uri' => "http://18.233.198.218:8080/api/",
            'headers' => [
                'Authorization' => 'J33TRWJI',
                'Accept'        => 'application/json'
            ]
        ]);

        $response = $client->request('GET', $url);

        $convert =  json_decode( $response->getBody()->getContents() );
        $convert =  json_decode( $convert, true );

        return $convert;
    }
}
