<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Requerimiento;
use App\Models\Clientes;
use App\Models\Negocio;
use App\Models\PreliminarTranversalesCandidato;
use App\Models\PreliminarTranversales;
use App\Models\ReqInfPreImagenes;
use App\Models\DatosBasicos;
use Illuminate\Support\Facades\DB;
use App\Models\Experiencias;
use Khill\Lavacharts\Lavacharts;
use App\Models\CriterioCompetencia;
use App\Models\RequerimientoCompetencia;

class InformePreliminarController extends Controller
{
    /**
     * Actualizar el informe preliminar del modal
     **/
    public function actualizar_informe_preliminar(Request $data){
        foreach($data->id_preliminar as $key => $item){

            //Consultar el ideal por preliminar
            $ideal = PreliminarTranversales::
                where("id", $key)
                ->where("estado", 1)
                ->first();
            $calificacion = 0;
            $calificacion = $ideal->puntuacion;
            //Calular operacion
            $resultado = 0;
            $resultado = $data->criterio[$key] - $calificacion;

            //Actualizar Calificacion
            $actualizar = PreliminarTranversalesCandidato::find($item);
            $actualizar->puntuacion = $data->criterio[$key];
            $actualizar->resultado = $resultado;
            //$actualizar->descripcion_candidato = $data->descripcion_candidato;  
            $actualizar->save();
        } 
        $actualizar->descripcion_candidato = $data->descripcion_candidato;  
        $actualizar->save();

        return response()->json(["success" => true]);
    }

    /**
     * Guardar el informe preliminar del modal
     **/
    public function guardar_informe_preliminar(Request $data){
        $candidato = DatosBasicos::where("user_id", $data->get("user_id"))
            ->first();
        //dd($candidato);

        foreach($data->criterio as $key => $criterio){
            //Consultar el ideal por preliminar
            /*$ideal = PreliminarTranversales::
                where("id", $key)
                ->where("estado", 1)
                ->first();*/

            $ideal=RequerimientoCompetencia::join("criterios_competencias","criterios_competencias.descripcion","=","requerimiento_competencia.ideal")
            ->where("requerimiento_competencia.req_id",$data->requerimiento)
            ->where("requerimiento_competencia.competencia_id",$key)
            ->orderBy("requerimiento_competencia.id","desc")
            ->select("criterios_competencias.valor as puntuacion")
            ->first();
            $calificacion = 0;
            $calificacion = $ideal->puntuacion;
            //Calular operacion
            $resultado = 0;

            $resultado = $criterio - $calificacion;

            //Guardar Citacion
            $guardar = new PreliminarTranversalesCandidato();
            $guardar->fill([
                "candidato_id"          => $candidato->user_id,
                "realizo_id"            => $this->user->id,
                "transversal_id"        => $key,
                "req_id"                => $data->requerimiento,
                "puntuacion"            => $criterio,
                "estado"                => 1,
                "resultado"             => $resultado,
                "descripcion_candidato" => $data->descripcion_candidato,
            ]);
            $guardar->save();
        } 

        return response()->json(["success" => true]);
    }

    public function guardar_informe_individual(Request $data){


        $usuario=$data->get("user_id");
        $requerimiento=$data->get("requerimiento");
        $listado=$data->get("listado");
        $observaciones=$data->get("observaciones");


        foreach($listado as $key=>$value){

            $preliminar_candidato=PreliminarTranversalesCandidato::where("candidato_id",$usuario)
            ->where("req_id",$requerimiento)
            ->where("transversal_id",$key)
            ->first();
            $preliminar_candidato->assessment_center=$value["assessment_center"];
            $preliminar_candidato->evaluacion_psico=$value["evaluacion"];
            $preliminar_candidato->referencias=$value["referencias"];
            $preliminar_candidato->observaciones=$observaciones;
            $preliminar_candidato->save();
           
        }

      
        //dd($candidato);

       

        return response()->json(["success" => true]);
    }

    public function gestion_informe_individual(Request$data){

        $req=$data->get("id_req");
        $candidato=$data->get("candidato_user");
        $datos_basicos=DatosBasicos::where("user_id",$candidato)->first();


        $requerimientoCompetencias=RequerimientoCompetencia::join("preliminar_transversales","preliminar_transversales.id","=","requerimiento_competencia.competencia_id")
        ->leftjoin("preliminar_transversales_candidato","preliminar_transversales_candidato.transversal_id","=","requerimiento_competencia.competencia_id")
        ->select("preliminar_transversales.descripcion as competencia","requerimiento_competencia.ideal as ideal","preliminar_transversales.id as id_competencia","preliminar_transversales_candidato.entrevista_bei as entrevista_bei","preliminar_transversales_candidato.evaluacion_psico","preliminar_transversales_candidato.assessment_center","preliminar_transversales_candidato.referencias","preliminar_transversales_candidato.observaciones")
        ->where("requerimiento_competencia.req_id",$req)
        ->where("preliminar_transversales_candidato.candidato_id",$candidato)
        ->groupBy("preliminar_transversales.id")

        
        ->get();

        $entrevista_bei=PreliminarTranversalesCandidato::join("preliminar_transversales","preliminar_transversales.id","=","preliminar_transversales_candidato.transversal_id")
        ->join("requerimiento_competencia","requerimiento_competencia.competencia_id","=","preliminar_transversales.id")
        ->where("preliminar_transversales_candidato.req_id",$req)
        ->where("preliminar_transversales_candidato.candidato_id",$candidato)
        ->select("preliminar_transversales.descripcion as competencia","preliminar_transversales_candidato.puntuacion as puntuacion","requerimiento_competencia.ideal as ideal")
        ->get();

       

        return response()->json(["success" => true, "data" => $data, "view" => view("admin.informe_preliminar.informe_individual", compact("requerimientoCompetencias","candidato","cliente","req","transversal","valida_boton","descripcion","RequerimientoCompetencias","entrevista_bei","datos_basicos"))->render()]);

    }

    /**
     * Mostrar la vista formulario del informe preliminar
     **/
    public function get_informe_preliminar(Request $data){
        $usuario        = $data->get("candidato_user");
        $cliente        = $data->get("cliente_id");
        $requerimiento  = $data->get("candidato_req");
        $valida_boton   = $data->get("valida_boton");

        //Se realiza la consulta para cargar los datos a actualizar
        if($valida_boton == "true"){
            $data = PreliminarTranversalesCandidato::
                where("candidato_id", $usuario)
                ->where("req_id", $requerimiento)
                ->get();
        }else{
            $data = "";
        }    

        //Validar si ya tiene descripción por parte del psicologo si no mostrar la de defaul
        $descripcion = "";
        $valida_descripcion = PreliminarTranversalesCandidato::
            where("candidato_id", $usuario)
            ->where("req_id", $requerimiento)
            ->where("descripcion_candidato","<>","")
            ->first();


        if($valida_descripcion != null){
            $descripcion = $valida_descripcion->descripcion_candidato;
        }else{
            $datos_candidato = DatosBasicos::
                leftjoin("generos", "generos.id", "=", "datos_basicos.genero")
                ->leftjoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
                ->leftjoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
                ->leftjoin("tipo_identificacion","tipo_identificacion.id","=","datos_basicos.tipo_id")
                ->where("datos_basicos.user_id", $usuario)
                ->select('datos_basicos.numero_id as numero_id','generos.descripcion as genero',
                    \DB::raw("datos_basicos.*, estados_civiles.descripcion as estado_civil, tipo_identificacion.descripcion as identificacion, generos.descripcion as genero, aspiracion_salarial.descripcion as salario")
                    )
                ->first();


            $descripcion = "Se identifica con la ".$datos_candidato->identificacion." número ".$datos_candidato->numero_id." de la ciudad de ".$datos_candidato->ciudad_expedicion_id.", cuyo género es ".$datos_candidato->genero.", su estado civil es ".$datos_candidato->estado_civil." y tiene una aspiración salarial de ".$datos_candidato->salario.". Reside actualmente en la ciudad de ".$datos_candidato->ciudad_residencia.", en la dirección ".$datos_candidato->direccion." de ".$datos_candidato->barrio.".";
        }

        //Validar si el requerimiento tiene configurado el informe preliminar
        $validar_req_informe_preliminar = Requerimiento::
            where("id", $requerimiento)
            ->select("informe_preliminar_id")
            ->first();

        if($validar_req_informe_preliminar->informe_preliminar_id == NULL){
            //Listado de tranversales para seleccionar
            $transversal = PreliminarTranversales::
                where("estado", 1)
                ->get();
        }else{
            $transversal = PreliminarTranversales::
                where("estado", 1)
                ->whereIN("id", explode(",",$validar_req_informe_preliminar->informe_preliminar_id))
                ->get();
        }

        $RequerimientoCompetencias=RequerimientoCompetencia::join("preliminar_transversales","preliminar_transversales.id","=","requerimiento_competencia.competencia_id")
        ->where("requerimiento_competencia.req_id",$requerimiento)
        ->select("requerimiento_competencia.ideal as ideal","preliminar_transversales.descripcion as competencia_nombre","preliminar_transversales.id as competencia_id")
        ->groupBy("preliminar_transversales.id")
        ->get();


        //Criterio de calificación
        
       

            $criterio=[""=>"Seleccionar"]+CriterioCompetencia::pluck("descripcion", "valor")->toArray();
        

            return response()->json(["success" => true, "data" => $data, "view" => view("admin.informe_preliminar.informe_preliminar", compact("criterio","usuario","cliente","requerimiento","transversal","valida_boton","descripcion","RequerimientoCompetencias"))->render()]);

    }

    /**
     * Generar Informe Preliminar en Formato PDF
     *
     * @return \Illuminate\Http\Response
     */
    public function pdf_informe_preliminar(Request $data)
    {
        //dd($data->all());
        $req_id = $data->get("req_id");

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            //Obtenemos el metodo de acceso al pdf por GET, para ubicar si tiene imagen generada de Informe Preliminar
            $reqInfPreImg = ReqInfPreImagenes::where("req_id", $req_id)->first();
            if ($reqInfPreImg != null) {
                $tipoData = $reqInfPreImg->tipo;
                $grafica = $reqInfPreImg->image;
            }
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Obtenemos el metodo de acceso al pdf por POST, se obtiene la imagen de la vista 'curva_de_ajuste_al_perfil'
            if ($data->get("curva_de_ajuste_al_perfil") !== null) {
                //Si hay imagen, se transforma a BLOB y se guarda en BD
                $pos = strpos($data->get("curva_de_ajuste_al_perfil"), 'base64,');
                $blobData= base64_decode(substr($data->get("curva_de_ajuste_al_perfil"), $pos + 7));

                $tipo = explode(";", substr($data->get("curva_de_ajuste_al_perfil"), 11, 5));
                $tipoData = $tipo[0];

                //Se consulta si habia registro para el req_id y se guarda o actualiza segun corresponda
                $guardarImg = ReqInfPreImagenes::where("req_id", $req_id)->first();
                if ($guardarImg == null) {
                    $guardarImg = new ReqInfPreImagenes();
                }
                $guardarImg->fill([
                    "req_id"          => $req_id,
                    "tipo"            => $tipoData,
                    "image"           => $blobData,
                ]);
                $guardarImg->save();

                $grafica = $blobData;
            }
        }

        $requerimiento = Requerimiento::join("motivo_requerimiento", "motivo_requerimiento.id", "=", "requerimientos.motivo_requerimiento_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->select("requerimientos.*",
                "requerimientos.ciudad_id as ciudad",
                "requerimientos.pais_id as pais",
                "requerimientos.departamento_id as departamento",
                "motivo_requerimiento.descripcion as motivo_req",
                "cargos_genericos.descripcion as nombre_cargo",
                "cargos_especificos.descripcion as nombre_cargo_especifico")
            ->find($req_id);
        //dd($requerimiento);
        if(route("home")=="http://demo.t3rsc.co" || route("home")=="https://demo.t3rsc.co" || route("home")=="http://localhost:8000" || route("home")=="http://desarrollo.t3rsc.co" || route("home")=="https://desarrollo.t3rsc.co"){

         $empresa_logo = DB::table("empresa_logos")->where('id',$requerimiento->empresa_contrata)->first();

         $logo = (isset($empresa_logo->logo))?$empresa_logo->logo:'';
        }
        
        $negocio = Negocio::find($requerimiento->negocio_id);

        $cliente = Clientes::find($negocio->cliente_id);
 
        $candidatos = DatosBasicos::
            join("preliminar_transversales_candidato","preliminar_transversales_candidato.candidato_id","=","datos_basicos.user_id")
            ->join("requerimiento_cantidato","requerimiento_cantidato.candidato_id","=","preliminar_transversales_candidato.candidato_id")
            ->join("preliminar_transversales","preliminar_transversales.id","=","preliminar_transversales_candidato.transversal_id")
            ->leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
            ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
            ->where("preliminar_transversales_candidato.req_id", $req_id)
            ->where("requerimiento_cantidato.requerimiento_id", $req_id)
            ->whereNotIn("requerimiento_cantidato.estado_candidato", [config('conf_aplicacion.C_QUITAR'), config('conf_aplicacion.C_INACTIVO')])
            ->select(
                "preliminar_transversales.*","datos_basicos.*", 
                "preliminar_transversales_candidato.*", 
                "tipo_identificacion.descripcion as dec_tipo_doc", 
                "generos.descripcion as genero_desc",
                "estados_civiles.descripcion as estado_civil_des",
                "aspiracion_salarial.descripcion as aspiracion_salarial_des",
                db::raw("SUM(resultado) as rankig")
            )
            ->groupBy("preliminar_transversales_candidato.candidato_id")
            ->orderBy("rankig","DESC")
            ->get();
           //dd($candidatos);

        //Validamos si el requerimiento cuenta con configuración de informe preliminar
        if($requerimiento->informe_preliminar_id != NULL){
            //Listado de tranversales para seleccionar
             $ideal_req=RequerimientoCompetencia::join("criterios_competencias","criterios_competencias.descripcion","=","requerimiento_competencia.ideal")
            ->where("requerimiento_competencia.req_id",$requerimiento->id)
            ->orderBy("requerimiento_competencia.id")
            ->select("criterios_competencias.valor as puntuacion","requerimiento_competencia.ideal as ideal")
            ->get();
            $transversales = PreliminarTranversales::
                where("estado", 1)
                ->whereIn("id", explode(",", $requerimiento->informe_preliminar_id))
                ->get();
        }else{
            //Listado de tranversales para seleccionar
            $transversales = PreliminarTranversales::
                where("estado", 1)
                ->get();
        }



        $experienciaMayorDuracion = Experiencias::
            join("preliminar_transversales_candidato","preliminar_transversales_candidato.candidato_id","=","experiencias.user_id")
            ->select(\DB::raw(" *, (TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) AS dias, (user_id) AS usuario"))
            ->where("preliminar_transversales_candidato.req_id", $req_id)
            ->havingRaw("dias >= (SELECT MAX(TO_DAYS(fecha_final) - TO_DAYS(fecha_inicio)) FROM experiencias as e WHERE e.user_id = experiencias.user_id)")
            ->get();

        //Calcular
        $ideal = PreliminarTranversalesCandidato::
            select(\DB::raw("COUNT(*) AS a_ideal, candidato_id"))
            ->where("req_id", $req_id)
            ->where("resultado","==", 0)
            ->groupBy("candidato_id")
            ->get();
        // dd($ideal);

        $datas = [];
        foreach ($ideal as $value) {
            $datas['ideal'][$value->candidato_id] = round(($value->a_ideal / count($transversales)),2) * 100;
        }
        if(!isset($datas['ideal'])){
            $datas['ideal'][] = 0;
        }

        $positivo = PreliminarTranversalesCandidato::
            select(\DB::raw("COUNT(*) AS a_ideal, candidato_id"))
            ->where("req_id", $req_id)
            ->where("resultado",">", 0)
            ->groupBy("candidato_id")
            ->get();
        // dd($positivo);

        foreach ($positivo as $value) {
            $datas['positivo'][$value->candidato_id] = round(($value->a_ideal / count($transversales)),2) * 100;
        }
        if(!isset($datas['positivo'])){
            $datas['positivo'][] = 0;
        }

        $negativo = PreliminarTranversalesCandidato::
            select(\DB::raw("COUNT(*) AS a_ideal, candidato_id"))
            ->where("req_id", $req_id)
            ->where("resultado","<", 0)
            ->groupBy("candidato_id")
            ->get();
        // dd($positivo);

        foreach ($negativo as $value) {
          
          $datas['negativo'][$value->candidato_id] = round(($value->a_ideal / count($transversales)),2) * 100;
        }
        if(!isset($datas['negativo'])){
            $datas['negativo'][] = 0;
        }
        //dd($datas['negativo']);

        //Codigo de la imagen en BASE64
        //$grafica = $data->get("curva_de_ajuste_al_perfil");

        $ultima_transversal_realizada = PreliminarTranversalesCandidato::
            select("realizo_id","updated_at")
            ->where("req_id", $req_id)
            ->orderBy("updated_at", "asc")
            ->first();
            // dd($ultima_transversal_realizada);
        
        $view = \View::make('admin.reportes.informe_preliminar', compact('requerimiento','negocio','cliente','candidatos','transversales','experienciaMayorDuracion','datas','grafica','ultima_transversal_realizada','logo',"ideal_req", "tipoData"))->render();
        $pdf  = \App::make('dompdf.wrapper');
        if(route("home")=="https://gpc.t3rsc.co" || route("home")=="https://asuservicio.t3rsc.co"){
            $pdf->loadHTML($view)->setPaper('a4', 'landscape');
        }
        else{
            $pdf->loadHTML($view);
        }
        

      return $pdf->stream('Informe_Preliminar.pdf');
    }   

    /**
     *  Configurar el informe preliminar a reqerimientos, donde solo los configurados se le realizara a los candidatos
     **/
    public function configurar_informe_preliminar_por_requerimiento(Request $data){
        $requerimiento_id = $data->requerimiento_id;

        //Validar si ya realizaron configuración de informe preliminar
        /*$validar_configuracion = Requerimiento::
            join("preliminar_transversales_candidato","preliminar_transversales_candidato.req_id","=","requerimientos.id")
            ->where("requerimientos.id",$requerimiento_id)
            ->select("requerimientos.informe_preliminar_id")
            ->first();*/

            $validar_configuracion = RequerimientoCompetencia::where("req_id",$requerimiento_id)
            ->get();

        $valida = "";
        if($validar_configuracion->count()>0){
            $valida = true;
        }else{
            $valida = false;
        }

        //Consultar todos los informe preliminares que hay en la actualidad
        $transversal = PreliminarTranversales::
            where("estado", 1)
            ->get();



        $criterios=[""=>"Seleccionar"]+CriterioCompetencia::pluck("descripcion", "descripcion")->toArray();
         

        return response()->json(["success" => true, "view" => view("admin.informe_preliminar.modal.configurar_informe_preliminar_por_requerimiento", compact("requerimiento_id","transversal","valida","criterios"))->render()]);
    }

    /**
     *  Guardar configuración informe preliminar por requerimiento
     **/
    public function guardar_configuracion_informe_preliminar_requerimiento(Request $data){
        
        //dd($data->all());
        $criterios=$data->get("criterios");
        //gregar los ID de las preguntas del informe preliminar a requerimientos
        $configuracionArray = [];
        if ($data->has("configuracion")) {
            foreach ($data->get("configuracion") as $key => $value) {
                $configuracionArray[$key] = $value;
            }
        }

       

        //Requerimiento que se le agregaran la configuracion del informe preliminar
        $requerimiento = Requerimiento::find($data->get("requerimiento_id"));
        $requerimiento->informe_preliminar_id = implode(",", $configuracionArray);
        $requerimiento->save();

         
            foreach($configuracionArray as $comp){
                $req_comp=new RequerimientoCompetencia();
                $req_comp->req_id= $requerimiento->id;
                $req_comp->competencia_id=$comp;
                $req_comp->ideal=$criterios[$comp];
                $req_comp->save();
            }

    }

    /**
     * Eliminar todos los registros de informe preliminar de los candidatos en el requerimiento actual
     */
    public function eliminar_informe_preliminar_candidato_requerimiento(Request $data){

        $eliminar = PreliminarTranversalesCandidato::
            where("req_id",$data->get("requerimiento_id"))
            ->delete();
        $eliminar_req=RequerimientoCompetencia::where("req_id",$data->get("requerimiento_id"))
        ->delete();

        return response()->json(["success" => true]);
    }

}
