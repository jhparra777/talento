<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User as EloquentUser;
use App\Models\Requerimiento;
use App\Models\Experiencias;
use App\Models\DatosBasicos;
use App\Models\Sitio;

use Illuminate\Support\Facades\DB;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use App\Models\EstadosRequerimientos;

use SoapClient;

class ElEmpleoController extends Controller
{
    public function getApplyCandidatesEE(Request $request) {
        $user_sesion = $this->user;

        $sitio = Sitio::first();

        $req_id = $request->reqId;

        $candidatos_aplicados_ee = DatosBasicos::join("requerimientos", "requerimientos.IdJobOfferEE", "=", "datos_basicos.ofertaEE")
        ->where("datos_basicos.estado_reclutamiento", "<>", config('conf_aplicacion.C_INACTIVO'))
        ->where("requerimientos.id", $request->reqId)
        ->where("requerimientos.IdJobOfferEE", $request->idOffer)
        ->get();

        $estado_req = EstadosRequerimientos::join("estados", "estados.id", "=", "estados_requerimiento.estado")->where("req_id", $req_id)
        ->select("estados.descripcion as estado_nombre", "estados.id as estados_req")
        ->orderBy("estados_requerimiento.id", "desc")
        ->first();

        return response()->json([
            'success'   => true,
            'view'      => view('admin.elempleo_aplicantes_layout', compact('req_id', 'user_sesion', 'estado_req', 'sitio', 'candidatos_aplicados_ee'))->render()
        ]);
    }

    public function getInfoApplyCandidatesEE(Requerimiento $request) {
        //\Log::info('REQ', array('req' => $reqId));

        $client = new SoapClient("https://www.elempleo.com/colombia/WebServices/CompanyServices.asmx?WSDL");

        # Sandbox ElEmpleo
        // https://uat.elempleo.com/colombia/WebServices/CompanyServices.asmx?WSDL
        // https://uat.elempleo.com/colombia/WebServices/JobOfferServices.asmx?WSDL

        # Productivo ElEmpleo
        // https://www.elempleo.com/colombia/WebServices/CompanyServices.asmx?WSDL
        // https://www.elempleo.com/colombia/WebServices/JobOfferServices.asmx?WSDL

        #Credenciales Test
        // listospruebaws1@listos.com
        // Listows123*

        #Credenciales Productivo
        // liliana.marin@listos.com.co
        // Dima8911

        $requerimientosOfertasEE = Requerimiento::select('id' ,'IdJobOfferEE')->get();

        foreach ($requerimientosOfertasEE as $oferta_ee) {
            
            if ($oferta_ee->IdJobOfferEE != null || $oferta_ee->IdJobOfferEE != '' || !is_null($oferta_ee->IdJobOfferEE)) {
                //Objeto token
                $paramsJobOffer = array(
                    "token" => array(
                        "UserName" => "liliana.marin@listos.com.co",
                        "Password" => "Dima8911"
                    ),
                    "jobOfferId" => $oferta_ee->IdJobOfferEE
                );

                # Consultar candidatos registrados y aplicantes en la oferta
                $response = $client->GetResumeesByJobOffer($paramsJobOffer);

                foreach ($response as $dataUserEE) {
                    foreach ($dataUserEE as $perro) {
                        for ($i = 0; $i < count($perro); $i++) {

                            //Creación de candidatos
                            $datos_basicos = DatosBasicos::where('numero_id', $perro[$i]->Identification)->first();

                            $usuario_id = null;

                            if(is_null($datos_basicos) || empty($datos_basicos) || $datos_basicos === null){

                                $client_2 = new SoapClient("https://www.elempleo.com/colombia/WebServices/CompanyServices.asmx?WSDL");

                                $paramsGetResumee = array(
                                    "token" => array(
                                        "UserName" => "liliana.marin@listos.com.co",
                                        "Password" => "Dima8911"
                                    ),
                                    "id" => $perro[$i]->ResumeeId
                                );

                                # Consultar información de la HV del candidato
                                $response_2 = $client_2->GetResumee($paramsGetResumee);

                                if (!is_null($response_2) || !empty($response_2)) {
                                    //Creamos el usuario
                                    $campos_usuario = [
                                        'name' => $response_2->GetResumeeResult->Person->Name.' '.$response_2->GetResumeeResult->Person->FirstSurname,
                                        'email'     => $response_2->GetResumeeResult->Person->Email,
                                        'password'  => $response_2->GetResumeeResult->Person->Identification,
                                        'numero_id' => $response_2->GetResumeeResult->Person->Identification,
                                        'cedula'    => $response_2->GetResumeeResult->Person->Identification
                                    ];

                                    $user = Sentinel::registerAndActivate($campos_usuario);
                                        
                                    $usuario_id = $user->id;

                                    //Creamos sus datos basicos
                                    $datos_basicos = new DatosBasicos();

                                    $datos_basicos->fill([
                                        'numero_id'       => $response_2->GetResumeeResult->Person->Identification,
                                        'user_id'         => $usuario_id,
                                        'nombres'         => $response_2->GetResumeeResult->Person->Name,
                                        'primer_apellido' => $response_2->GetResumeeResult->Person->FirstSurname,
                                        'segundo_apellido'=> null,
                                        'telefono_movil'  => $response_2->GetResumeeResult->Person->Phone,
                                        'estado_reclutamiento' => config('conf_aplicacion.C_ACTIVO'),
                                        'datos_basicos_count'  => "100",
                                        'email'           => $response_2->GetResumeeResult->Person->Email,
                                        'registroEE'      => 1,
                                        'ofertaEE'        => $oferta_ee->IdJobOfferEE
                                    ]);

                                    $datos_basicos->save();

                                    foreach ($response_2->GetResumeeResult->Experiences->DtoExperience as $experiencia) {
                                        $experiencias = new Experiencias();

                                        if (isset($experiencia->Boss) && !is_null($experiencia->Boss) && $experiencia->Boss != '') {
                                            $nombres_jefe = $experiencia->Boss;   
                                        }else{
                                            $nombres_jefe = 'N/A';
                                        }

                                        $experiencias->fill([
                                            'numero_id'         => $response_2->GetResumeeResult->Person->Identification,
                                            'user_id'           => $usuario_id,
                                            'nombre_empresa'    => $experiencia->CompanyName,
                                            'telefono_temporal' => $experiencia->CompanyPhone,
                                            'ciudad_id'         => 1,
                                            'departamento_id'   => 11,
                                            'pais_id'           => 170,
                                            'cargo_especifico'  => $experiencia->PosissionName,
                                            'cargo_desempenado' => 32,
                                            'nombres_jefe'      => $nombres_jefe,
                                            'cargo_jefe'        => 'N/A',
                                            'fecha_inicio'      => $experiencia->DateFrom,
                                            'fecha_final'       => $experiencia->DateTo,
                                            'empleo_actual'     => 2,
                                            'salario_devengado' => 1,
                                            'motivo_retiro'     => 5,
                                            'funciones_logros'  => $experiencia->Functions,
                                        ]);

                                        $experiencias->save();
                                    }

                                    //Creamos el rol
                                    $role = Sentinel::findRoleBySlug('hv');
                                    $role->users()->attach($user);
                                }
                            }
                        }
                    }
                }

                //Actualizar REQ consulta EE
                DB::table('requerimientos')->where('id', $oferta_ee->id)->update(['consultaEE' => 1]);
            }

        }
    }
}
