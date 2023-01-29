<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Models\RegistroProceso;
use App\Models\ProcesoRequerimiento;
use App\Models\UserClientes;
use App\Models\ReqCandidato;
use GuzzleHttp\Client;
use App\Models\Sitio;

abstract class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected $user = null;
    protected $clientes_user = [];
    protected $file_conf = null;

    public function __construct() {
        $this->file_conf = config('conf_aplicacion');
        if (Sentinel::check()) {
            $this->user = Sentinel::getUser();
            $clientes = UserClientes::where("user_id", $this->user->id)->get();
            foreach ($clientes as $key => $value) {
                array_push($this->clientes_user, $value->cliente_id);
            }
        }
    }

    public function procesoRequerimiento($entidad_id, $ref_id, $modulo, $proceso_adicional = "", $resultado = null, $observacion = '') {

        $proceso = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->where("procesos_candidato_req.id", $ref_id)->first();
            
        $relacionProceso = new ProcesoRequerimiento();
        $relacionProceso->fill([
            "tipo_entidad" => $modulo,
            "proceso_adicional" => $proceso_adicional,
            "entidad_id" => $entidad_id,
            "requerimiento_id" => $proceso->requerimiento_id,
            "user_id" => $this->user->id,
            "resultado" => $resultado,
            "observacion" => $observacion
        ]);

        $relacionProceso->save();
    }

    public function validaAsistenciaCandidato($req_id,$candidato_req_id) {
        $nombres = [];
        $req_candi_id = [];

        foreach ($candidato_req_id as $key => $value) {
         
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->leftjoin('entrevistas_candidatos','entrevistas_candidatos.candidato_id','=','datos_basicos.user_id')
            ->where("requerimiento_cantidato.id", $value)
                ->select("requerimiento_cantidato.id","datos_basicos.nombres","datos_basicos.primer_apellido")
                ->first();
            //dd($candidato);
                         array_push($req_candi_id, $candidato->id);   
         
            }
                  foreach ($req_candi_id as $key => $value) {
            
                            $candidatoo = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                                ->join('entrevistas_candidatos','entrevistas_candidatos.candidato_id','=','datos_basicos.user_id')
                                ->where("requerimiento_cantidato.id", $value)
                                ->where('entrevistas_candidatos.req_id',$req_id)
                                ->where('entrevistas_candidatos.asistio',1)
                                    ->select("requerimiento_cantidato.id","datos_basicos.nombres","datos_basicos.primer_apellido")
                                    ->first();

                                    if ($candidatoo!= null) {
             
             array_push($nombres, $candidatoo->nombres);
        }                 

                }
              
         //dd($nombres);
           
             if (count($nombres) > 0) {
                return array("success"=>true,"view"=>view("admin.reclutamiento.modal.proceso_repetido",  compact("","nombres"))->render());
             }
        
        return array("success"=>false);
        
    }

    public function validaEstadoProcesoCandidato($proceso, $candidato_req_id) {
        $nombres = [];
        $req_candi_id = [];

        
        foreach ($candidato_req_id as $key => $value) {
            
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
            ->where("requerimiento_cantidato.id", $value)
                ->select("requerimiento_cantidato.id","datos_basicos.nombres","datos_basicos.primer_apellido")
                ->first();

                array_push($req_candi_id, $candidato->id);

        }
         
           
        foreach($req_candi_id as $key => $id) {
          $tblProceso = RegistroProceso::join('datos_basicos','datos_basicos.user_id','=','procesos_candidato_req.candidato_id')
            ->select('datos_basicos.nombres')
            ->where("requerimiento_candidato_id", $id)
            ->where("proceso", $proceso)
            ->first();

           if ($tblProceso!= null) {
             
             array_push($nombres,$tblProceso->nombres);
            }
        }
             if (count($nombres) > 0) {
                return array("success"=>true,"view"=>view("admin.reclutamiento.modal.proceso_repetido",  compact("","nombres"))->render());
             }
            
        
        
        return array("success"=>false);
        
    }

    public function verificar_email($email)
    {
        try{
            $sitio = Sitio::first();
            if (config('conf_aplicacion.VARIABLES_ENTORNO.SITIO') === 'test' || $sitio->verificar_email === '0') {
                //Si en el env el Sitio es test o en la tabla sitio es 0 no se verifica el email
                return json_encode(["status" => 500, "data" => '',"valid"=>true,"mensaje"=>'email']);
            }

            $mensaje=null;

            $verification = new Client();

            $response = $verification->get('https://api.emailverifyapi.com/v3/lookups/json?key=95C3583F67D7659C&email='.$email);

            $status = $response->getStatusCode();
            $data = json_decode($response->getBody()->getContents(), true);

            $valid=false;

            if(array_key_exists('validFormat', $data)){

                if ($data["validFormat"] && $data["deliverable"] && $data["hostExists"]) {
                    $valid=true;
                } else {
                    $mensaje="Correo ".$email." no válido. Verifique que exista la cuenta o el  proveedor de correos.";
                }
            } else{
                $mensaje=$data["Message"];
            }

            return json_encode(["status" => $status, "data" => $data,"valid"=>$valid,"mensaje"=>$mensaje]);
        }
        catch (\Exception $e) {
        }
    }
}
