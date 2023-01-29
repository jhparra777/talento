<?php

namespace App\Http\Controllers\Integrations;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\DatosBasicos;
use App\Models\TruoraKey;
use App\Models\Documentos;

use GuzzleHttp\Client;

class TruoraIntegrationController extends Controller
{
    //Consultar en Truora
    public function generate_check_truora(Request $request)
    {
        //Busca cédula
        $datosCandidato = DatosBasicos::where('user_id', $request->get("user_id"))->select('user_id', 'numero_id')->first();
        $cedula = $datosCandidato->numero_id;

        //Para crear petición del check ID
        $create_check = new Client();

        $response_check = $create_check->post('https://api.truora.com/v1/checks', [
            'headers' =>  [
                'Truora-API-Key' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhZGRpdGlvbmFsX2RhdGEiOiJ7fSIsImNsaWVudF9pZCI6IjRvYXZuc3BpNXJwcHUwaGRncHFwZzlmcTg5IiwiY2xpZW50X3VzZXJfaWQiOiIiLCJleHAiOjMxODA1NTM1MjYsImdyYW50IjoiIiwiaWF0IjoxNjAzNzUzNTI2LCJpc3MiOiJodHRwczovL2NvZ25pdG8taWRwLnVzLWVhc3QtMS5hbWF6b25hd3MuY29tL3VzLWVhc3QtMV9rVXQ4VkFZc2UiLCJqdGkiOiJiNjNkZjg3Mi1lMmZjLTRhZTgtYjk2NC1hZTc2Zjg0ZTkxYTUiLCJrZXlfbmFtZSI6ImFwaS1rZXktdHJpLWxpc3RvcyIsImtleV90eXBlIjoiYmFja2VuZCIsInVzZXJuYW1lIjoibGlzdG9zLWFwaS1rZXktdHJpLWxpc3RvcyJ9.cdIYRPpKc6kQFDHGREak6ffHci_aXBzV5m73Ta-HRTU',
                'content-type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => [
                'country' => 'CO',
                'type' => 'person',
                'user_authorized' => true,
                'national_id' => $cedula
            ]
        ]);

        $convert_check = json_decode( $response_check->getBody()->getContents(), true);
        $generated_check = $convert_check['check']['check_id'];

        //Crea documento confidencial
        $verificar_consultado = TruoraKey::where('req_id', $request->get("req_id"))
        ->where('user_id', $datosCandidato->user_id)
        ->first();

        if (empty($verificar_consultado)) {
            $documentos = new Documentos();

            $documentos->fill([
                "numero_id" => $cedula,
                "user_id" => $datosCandidato->user_id,
                "tipo_documento_id" => 5,
                "nombre_archivo" => "Truora",
                "gestiono" => $this->user->id,
                "requerimiento" => $request->get("req_id"),
                "descripcion_archivo" => 'Consulta de antecedentes a tráves de Truora.',
            ]);
            $documentos->save();
        }

        //Guarda el check_id devuelto
        $saveCheck = TruoraKey::create([
            'check_id' => $generated_check,
            'user_id'  => $this->user->id,
            'cand_id'  => $datosCandidato->user_id,
            'req_id'   => $request->get("req_id")
        ]);

        $instancia = 1;

        return response()->json([
            "success"          => true,
            "instancia"        => $instancia
        ]);
    }

    //Visualizar pdf de truora
    public function ver_pdf_truora(Request $request)
    {
        $create_pdf = new Client();

        $response_pdf = $create_pdf->get('https://api.truora.com/v1/checks/'.$request->truora_generated.'/pdf', [
            'headers' =>  [
                'Truora-API-Key' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhZGRpdGlvbmFsX2RhdGEiOiJ7fSIsImNsaWVudF9pZCI6IjRvYXZuc3BpNXJwcHUwaGRncHFwZzlmcTg5IiwiY2xpZW50X3VzZXJfaWQiOiIiLCJleHAiOjMxODA1NTM1MjYsImdyYW50IjoiIiwiaWF0IjoxNjAzNzUzNTI2LCJpc3MiOiJodHRwczovL2NvZ25pdG8taWRwLnVzLWVhc3QtMS5hbWF6b25hd3MuY29tL3VzLWVhc3QtMV9rVXQ4VkFZc2UiLCJqdGkiOiJiNjNkZjg3Mi1lMmZjLTRhZTgtYjk2NC1hZTc2Zjg0ZTkxYTUiLCJrZXlfbmFtZSI6ImFwaS1rZXktdHJpLWxpc3RvcyIsImtleV90eXBlIjoiYmFja2VuZCIsInVzZXJuYW1lIjoibGlzdG9zLWFwaS1rZXktdHJpLWxpc3RvcyJ9.cdIYRPpKc6kQFDHGREak6ffHci_aXBzV5m73Ta-HRTU',
                'content-type' => 'application/json'
            ]
        ]);

        $generated_pdf = $response_pdf->getBody();
        header('Cache-Control: public');
        header('Content-type: application/pdf');
        header('Content-Length: '.strlen($generated_pdf));
        echo $generated_pdf;
    }

    //Buscar detalle de consulta truora
    public static function getCheckDetails(int $user_id, int $req_id)
    {
        $convert_check = null;

        //Busca registro del check id consultado
        $getChecked = TruoraKey::where('cand_id', $user_id)
        ->where('req_id', $req_id)
        ->first();

        if (!empty($getChecked) || $getChecked !== null) {
            //Consulta Detalle
            $create_check = new Client();

            $response_check = $create_check->get('https://api.truora.com/v1/checks/'.$getChecked->check_id, [
                'headers' =>  [
                    'Truora-API-Key' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhZGRpdGlvbmFsX2RhdGEiOiJ7fSIsImNsaWVudF9pZCI6IjRvYXZuc3BpNXJwcHUwaGRncHFwZzlmcTg5IiwiY2xpZW50X3VzZXJfaWQiOiIiLCJleHAiOjMxODA1NTM1MjYsImdyYW50IjoiIiwiaWF0IjoxNjAzNzUzNTI2LCJpc3MiOiJodHRwczovL2NvZ25pdG8taWRwLnVzLWVhc3QtMS5hbWF6b25hd3MuY29tL3VzLWVhc3QtMV9rVXQ4VkFZc2UiLCJqdGkiOiJiNjNkZjg3Mi1lMmZjLTRhZTgtYjk2NC1hZTc2Zjg0ZTkxYTUiLCJrZXlfbmFtZSI6ImFwaS1rZXktdHJpLWxpc3RvcyIsImtleV90eXBlIjoiYmFja2VuZCIsInVzZXJuYW1lIjoibGlzdG9zLWFwaS1rZXktdHJpLWxpc3RvcyJ9.cdIYRPpKc6kQFDHGREak6ffHci_aXBzV5m73Ta-HRTU',
                    'content-type' => 'application/json'
                ]
            ]);

            $convert_check = json_decode($response_check->getBody()->getContents(), true);
        }

        return $convert_check;
    }

    /*
        * TODO: Hacer función para validar el check generado y guardado en la tablas truora_keys
    */
}
