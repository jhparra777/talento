<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Requests;

use App\Models\Ciudad;
use GuzzleHttp\Client;

use App\Models\EmpresaLogo;
use App\Models\ReqCandidato;
use Illuminate\Http\Request;

use App\Models\OmnisaludRegistro;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\OmnisaludTipoAdmision;
use App\Models\OmnisaludExamenesMedicos;
use App\Models\OmnisaludCiudadesAtencion;
use App\Models\OmnisaludCliente;
use App\Models\OmnisaludIntegracionConf;

class OmnisaludIntegrationController extends Controller
{
    /**
     * It receives a request and returns an array.
     * 
     * @param Request request The request object.
     * 
     * @return array An array with the key error and the value false.
     */
    public function omnisalud(Request $request):array
    {
        try {
            $candidatoReq = $request->candidato_req;

            $datosPeticion = $this->validarInformacion($candidatoReq);

            if ($datosPeticion['error']) {
                return $datosPeticion;
            }

            $tipoAdmision = $request->has('tipo_admision_omnisalud') ? $request->tipo_admision_omnisalud : null;

            $examenes = $request->has('examenes_omnisalud') ? $request->examenes_omnisalud : null;

            $ciudad = $request->has('ciudad_omnisalud') ? $request->ciudad_omnisalud : null;

            $observacion = $request->has('observacion_omnisalud') ? $request->observacion_omnisalud : null;

            // Make request
            $registrarExamen = $this->addOmnisaludExams($datosPeticion['datos'], $tipoAdmision, $examenes, $ciudad, $observacion);

            Log::channel('omnisalud')->info('Call ADD return');
            Log::channel('omnisalud')->debug($registrarExamen);

            if ($registrarExamen['statusCode'] != 200) {
                // Loop error array
                $message = null;
                for ($i=0; $i < count($registrarExamen['convertResponse']['requeridos']); $i++) {
                    empty($message) ? $message = $message . ucfirst($registrarExamen['convertResponse']['requeridos'][$i]) 
                                    : $message = $message .', '. ucfirst($registrarExamen['convertResponse']['requeridos'][$i]);
                }

                return ['error' => true, 'message' => $message];
            }

            $this->registerOmnisaludRequest(
                $datosPeticion['datos']->req_id,
                $this->user->id,
                $datosPeticion['datos']->user_id,
                $registrarExamen['convertResponse']['id_asignacion']
            );

            return ['error' => false, 'message' => 'Ok'];
        } catch (\Throwable $th) {
            //throw $th;
            Log::channel('omnisalud')->error('Omnisalud error capturado');
            Log::channel('omnisalud')->error($th);

            return ['error' => true];
        }
    }

    /**
     * It sends a POST request to an API endpoint with a form_params array
     * 
     * @param informacionCandidato This is the information of the candidate
     * @param int $tipoAdmision
     * @param array $examenes
     * @param string $observacion
     * @param int $ciudad
     */
    public function addOmnisaludExams($informacionCandidato, $tipoAdmision, $examenes, $ciudad, $observacion)
    {
        $addExams = new Client();

        $formParams = [
            'identificacion' => $informacionCandidato->identificacion,
            'tipoDocumento'  => $informacionCandidato->tipo_documento_codigo,
            'papellido'      => mb_strtoupper($informacionCandidato->primer_apellido),
            'sapellido'      => mb_strtoupper($informacionCandidato->segundo_apellido),
            'pnombre'        => mb_strtoupper($informacionCandidato->primer_nombre),
            'snombre'        => $informacionCandidato->segundo_nombre ? mb_strtoupper($informacionCandidato->segundo_nombre) : null,
            'sexo'           => $this->validateGenre($informacionCandidato->sexo),
            'Fnacimiento'    => $this->changeDateFormat($informacionCandidato->fecha_nacimiento),
            'telefono'       => $informacionCandidato->telefono,
            'email'          => $informacionCandidato->email,
            'direccion'      => mb_strtoupper($informacionCandidato->direccion),
            'cliente'        => $this->validateClient($informacionCandidato->cliente),
            'patencion'      => $this->removeAccents($ciudad),
            'cargo'          => mb_strtoupper($informacionCandidato->cargo),
            'emp_mision'     => mb_strtoupper($informacionCandidato->empresa_mision),
            'centro_costos'  => $informacionCandidato->centro_costo,
            'tadmision'      => $tipoAdmision,
            'elementos'      => $this->convertExams($examenes),
            'observacion'    => mb_strtoupper($observacion)
        ];

        $config = $this->omnisaludConfig();

        $response = $addExams->post($config['endpoint'].'add', [
            'http_errors' => false,
            'auth' => [
                $config['config']->auth_user,
                $config['config']->auth_pass
            ],
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => $formParams
        ]);

        $convertResponse = json_decode($response->getBody()->getContents(), true);

        // Log::channel('omnisalud')->info($response->getStatusCode());
        Log::channel('omnisalud')->info('Request ADD send data');
        Log::channel('omnisalud')->info(json_encode($formParams));

        Log::channel('omnisalud')->info('Request ADD response');
        Log::channel('omnisalud')->debug($convertResponse);

        return ['convertResponse' => $convertResponse, 'statusCode' => $response->getStatusCode()];
    }

    public function consultOmnisaludExams($reqId, $userId)
    {
        //Buscar registro de la asignación
        $omnisaludAsignacion = OmnisaludRegistro::where('req_id', $reqId)->where('user_id', $userId)->orderBy('id', 'DESC')->first();

        $omnisaludAsignacionId = $omnisaludAsignacion->omnisalud_asignacion_id;

        $consultExams = new Client();

        $config = $this->omnisaludConfig();

        $response = $consultExams->get($config['endpoint']."estado?asignacion=$omnisaludAsignacionId", [
            'http_errors' => false,
            'auth' => [
                $config['config']->auth_user,
                $config['config']->auth_pass
            ],
            'headers' => [
                'Content-Type' => 'application/json'
            ]
        ]);

        $convertResponse = json_decode($response->getBody()->getContents(), true);

        if ($response->getStatusCode() != 200) {
            return ['fecha_solicitud' => '-', 'estado_solicitud' => '-'];
        }

        Log::channel('omnisalud')->debug($convertResponse);

        //Validar estado y devolver el equivalente en string
        $estadoExamenes = null;

        switch ($convertResponse['respuesta']['estado']) {
            case 0:
                //Solicitado
                $estadoExamenes = 'Solicitado';
                break;

            case 1:
                //Procesando
                $estadoExamenes = 'Procesando';
                break;

            case 2:
                //Terminado
                $estadoExamenes = 'Terminado';
                break;

            case 3:
                //Con error
                $estadoExamenes = 'Con error';
                break;
            
            default:
                //Con error
                $estadoExamenes = 'Con error';
                break;
        }

        return ['fecha_solicitud' => $omnisaludAsignacion->created_at, 'estado_solicitud' => $estadoExamenes];
    }

    public function consultOmnisaludResult($userDocument)
    {
        //Hacer petición a la API
        $consultResult = new Client();

        $config = $this->omnisaludConfig();

        $response = $consultResult->post($config['endpoint'].'report', [
            'auth' => [
                $config['config']->auth_user,
                $config['config']->auth_pass
            ],
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'form_params' => [
                'identificacion' => $userDocument
            ]
        ]);

        $convertResponse = json_decode($response->getBody()->getContents(), true);

        return $convertResponse;
    }

    /**
     * It creates a new OmnisaludRegistro record with the given parameters
     * 
     * @param reqId
     * @param gestionId
     * @param userId
     * @param omnisaludAsignacion
     * @return void
     */
    public function registerOmnisaludRequest($reqId, $gestionId, $userId, $omnisaludAsignacion):void
    {
        $crearRegistro = new OmnisaludRegistro();

        $crearRegistro->fill([
            'req_id' => $reqId,
            'gestion_id' => $gestionId,
            'user_id' => $userId,
            'omnisalud_asignacion_id' => $omnisaludAsignacion
        ]);
        $crearRegistro->save();
    }

    /**
     *
     * Funciones privadas para modificar y validar datos
     *
    */

    /**
     * @param string $candidatoGenero
     * @return string
     */
    private static function validateGenre($candidatoGenero)
    {
        $genero = null;

        switch ($candidatoGenero) {
            case 'MASCULINO':
                $genero = 'M';
                break;

            case 'FEMENINO':
                $genero = 'F';
                break;

            default:
                $genero = null;
                break;
        }

        return $genero;
    }

    /**
     * It takes a date in the format YYYY-MM-DD and converts it to DD-MM-YYYY
     * 
     * @param candidatoFechaNacimiento The date that I want to convert.
     * 
     * @return the date in a different format.
     */
    private static function changeDateFormat($candidatoFechaNacimiento)
    {
        $fechaConvertida = date("d-m-Y", strtotime($candidatoFechaNacimiento));

        return $fechaConvertida;
    }

    /**
     * It takes an array of strings and returns a string of the array elements separated by commas
     * 
     * @param examenes array of exams
     * 
     * @return the examenesConvertidos variable.
     */
    private static function convertExams($examenes)
    {
        $examenesConvertidos = null;

        for ($i = 0; $i < count($examenes); $i++) {
            $examenesConvertidos .= "$examenes[$i],";
        }

        $examenesConvertidos = substr($examenesConvertidos, 0, -1);

        return $examenesConvertidos;
    }

    /**
     * It takes a client ID, finds the client's name, and returns the name of the client
     * 
     * @param clienteId The client id
     */
    private static function validateClient($clienteId)
    {
        $empresaContrata = EmpresaLogo::leftJoin('omnisalud_clientes', 'omnisalud_clientes.empresa_logo_id', '=', 'empresa_logos.id')
        ->where('empresa_logos.id', $clienteId)
        ->select('omnisalud_clientes.descripcion as cliente')
        ->first();

        if (!empty($empresaContrata)) {
            $clienteOmnisalud = $empresaContrata->cliente;
        }else {
            $empresaContrata = OmnisaludCliente::first();

            $clienteOmnisalud = $empresaContrata->descripcion;
        }

        return $clienteOmnisalud;
    }

    //Buscar ciudad para el plan de atención
    public static function searchCity($paisCodigo, $departamentoCodigo, $ciudadCodigo)
    {
        $ciudad = Ciudad::where('cod_pais', $paisCodigo)
            ->where('cod_departamento', $departamentoCodigo)
            ->where('cod_ciudad', $ciudadCodigo)
            ->first();

        $ciudadNombre = $ciudad->nombre;

        //Quitar el D.C de BOGOTA
        if ($ciudadNombre === 'BOGOTA D.C.') {
            $ciudadNombre = str_replace(' D.C.', '', $ciudadNombre);
        }

        if ($ciudadNombre === 'SOACHA') {
            $ciudadNombre = 'BOGOTA';
        }

        return mb_strtoupper($ciudadNombre);
    }

    /**
     * It replaces all the accented characters in a string with their non-accented counterparts
     * 
     * @param ciudadCadena The string to be converted.
     * 
     * @return the string without accents.
     */
    private static function removeAccents($ciudadCadena)
    {
        //Reemplazamos la A y a
        $ciudadCadena = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
            $ciudadCadena
        );
 
        //Reemplazamos la E y e
        $ciudadCadena = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $ciudadCadena
        );
 
        //Reemplazamos la I y i
        $ciudadCadena = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $ciudadCadena
        );
 
        //Reemplazamos la O y o
        $ciudadCadena = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $ciudadCadena
        );
 
        //Reemplazamos la U y u
        $ciudadCadena = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $ciudadCadena
        );
 
        //Reemplazamos la N, n, C y c
        $ciudadCadena = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç'),
            array('N', 'n', 'C', 'c'),
            $ciudadCadena
        );
        
        return $ciudadCadena;
    }

    /**
     * @param int $candidatoReq
     * @return array
     */
    private function validarInformacion(int $candidatoReq)
    {
        $informacionCandidato = ReqCandidato::leftJoin('datos_basicos', 'datos_basicos.user_id', '=', 'requerimiento_cantidato.candidato_id')
        ->leftJoin('tipo_identificacion', 'tipo_identificacion.id', '=', 'datos_basicos.tipo_id')
        ->leftJoin('generos', 'generos.id', '=', 'datos_basicos.genero')
        ->leftJoin('requerimientos', 'requerimientos.id', '=', 'requerimiento_cantidato.requerimiento_id')
        ->leftJoin('centros_costos_produccion', 'centros_costos_produccion.id', '=', 'requerimientos.centro_costo_id')
        ->leftJoin('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
        ->leftJoin('negocio', 'negocio.id', '=', 'requerimientos.negocio_id')
        ->leftJoin('clientes', 'clientes.id', '=', 'negocio.cliente_id')
        ->where('requerimiento_cantidato.id', $candidatoReq)
        ->select(
            'datos_basicos.user_id',
            'datos_basicos.numero_id as identificacion',
            'datos_basicos.primer_apellido',
            'datos_basicos.segundo_apellido',
            'datos_basicos.nombres',
            'datos_basicos.primer_nombre',
            'datos_basicos.segundo_nombre',
            'datos_basicos.fecha_nacimiento',
            'datos_basicos.telefono_movil as telefono',
            'datos_basicos.email',
            'datos_basicos.direccion',
            'datos_basicos.tipo_id',
            'datos_basicos.genero',

            'requerimientos.id as req_id',
            'requerimientos.empresa_contrata as cliente',
            'requerimientos.pais_id as pais',
            'requerimientos.departamento_id as departamento',
            'requerimientos.ciudad_id as ciudad',

            'tipo_identificacion.descripcion as tipo_documento',
            'tipo_identificacion.cod_tipo as tipo_documento_codigo',
            'generos.descripcion as sexo',
            'clientes.nombre as empresa_mision',
            'centros_costos_produccion.codigo as centro_costo',
            'cargos_especificos.descripcion as cargo'
        )
        ->first();

        if (empty($informacionCandidato->telefono) || empty($informacionCandidato->fecha_nacimiento) || empty($informacionCandidato->direccion) || empty($informacionCandidato->tipo_id) || empty($informacionCandidato->genero)) {
            return ['error' => true];
        }

        return ['error' => false, 'datos' => $informacionCandidato];
    }

    // Helpers

    /**
     * @return array
     */
    public static function tipoAdmision()
    {
        return OmnisaludTipoAdmision::where('active', 1)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'codigo')->toArray();
    }

    /**
     * @return collection
     */
    public static function examenesMedicos()
    {
        return OmnisaludExamenesMedicos::where('active', 1)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'codigo')->toArray();
    }

    /**
     * @return array
     */
    public static function ciudadesAtencion()
    {
        return OmnisaludCiudadesAtencion::where('active', 1)->orderBy('descripcion', 'ASC')->pluck('descripcion', 'codigo')->toArray();
    }

    /**
     * @return array
     */
    private function omnisaludConfig():array
    {
        $config = OmnisaludIntegracionConf::first();

        if ($config->sandbox == 'enabled') {
            return ['sandbox' => true, 'config' => $config, 'endpoint' => $config->endpoint_qa];
        }

        return ['sandbox' => false, 'config' => $config, 'endpoint' => $config->endpoint_prod];
    }
}
