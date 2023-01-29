<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DatosBasicos;
use App\Models\GestionPrueba;
use App\Models\ProcesoRequerimiento;
use App\Models\RegistroProceso;
use App\Models\TipoPrueba;
use Carbon\Carbon;
use Illuminate\Http\Request;
//Componente Caron para fechas
use Illuminate\Support\Facades\Validator;

class PruebasController extends Controller
{
    public function nueva_gestion_pruebas(Request $data)
    {
        $tipo_pruebas = ["" => "Seleccionar"] + TipoPrueba::orderBy("descripcion")->pluck("descripcion", "id")->toArray();

        return view("admin.reclutamiento.modal.form_pruebas", compact("tipo_pruebas"));
    }

    public function guardar_prueba(Request $data)
    {
        $rules = [
            "tipo_prueba_id" => "required",
            //"puntaje"        => "required|numeric",
            "resultado"      => "required",
            "estado"         => "required",
            "nombre_archivo" => "required",
            //  "fecha_vencimiento" => "required"
        ];


        /*$proceso = RegistroProceso::
            join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->where("procesos_candidato_req.id", $data->get("ref_id"))->first();*/

        $proceso = RegistroProceso::find($data->get("ref_id"));

        $valida       = Validator::make($data->all(), $rules);
        
        $tipo_pruebas = ["" => "Seleccionar"] + TipoPrueba::pluck("descripcion", "id")->toArray();

        if ($valida->fails()) {
            return response()->json(["success" => false, "view" => view("admin.reclutamiento.modal.form_pruebas", compact("tipo_pruebas"))->withErrors($valida)->render()]);
        }

        //Consulta para sumarle los meses de vencimiento de la prueba
        $mese_prueba = TipoPrueba::where("id", $data->tipo_prueba_id)->first();

        $date              = Carbon::now();
        $fecha_vencimiento = $date->addMonths($mese_prueba->vigencia);

        $pruebas = new GestionPrueba();
        $pruebas->fill($data->all() + ["user_id" => $this->user->id, "candidato_id" => $proceso->candidato_id, "fecha_vencimiento" => $fecha_vencimiento]);
        $pruebas->save();

        if ($data->hasFile("nombre_archivo") != "") {
            //GUARDAR DOCUMENTO
            $extencionsFile = $data->file("nombre_archivo")->getClientOriginalExtension();
            $imageName      = "archivo_prueba" . $pruebas->id . "." . $extencionsFile;
            $data->file('nombre_archivo')->move("recursos_pruebas/", $imageName);
            $pruebas->nombre_archivo = $imageName;
            $pruebas->save();
        }

        $final = 0;
        if($data->definitiva != null){
            $final = 1;

            $apto = $data->get("estado");

            if($apto == 2){
                $apto = 0;
            }elseif($apto == 3){
                $apto = 1;
            }

            $proceso->apto = $data->get("estado");
            $proceso->usuario_terminacion = $this->user->id;
            $proceso->save();

            //SI SELECCIONAN EL ESTADO PENDIENTE SE CREA UN NUEVO REGISTRO
            //SI EL ESTADO ES NO APTO SE RECHAZA EL CANDIDATO
        }

        $this->procesoRequerimiento($pruebas->id, $data->get("ref_id"), "MODULO_PRUEBAS");

        return response()->json(["success" => true,"final"=>$final]);
    }

    public function gestionar_prueba($id)
    {
        $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
        ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
        ->whereRaw("(procesos_candidato_req.apto is null or procesos_candidato_req.apto = '' or procesos_candidato_req.apto = 3 )")
        ->where("procesos_candidato_req.id", $id)
        ->select(
            "procesos_candidato_req.requerimiento_candidato_id",
            "procesos_candidato_req.id as ref_id",
            "datos_basicos.*",
            'requerimiento_cantidato.requerimiento_id',
            'requerimiento_cantidato.candidato_id',
            'requerimiento_cantidato.estado_candidato',
            'requerimiento_cantidato.otra_fuente'
        )
        ->first();

        $estados_procesos_referenciacion = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
        ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
        ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
        ->whereIn("proceso", ["ENVIO_PRUEBAS", "ENVIO_PRUEBAS_PENDIENTE"])
        ->get();

        $pruebas = GestionPrueba::join("users", "users.id", "=", "gestion_pruebas.user_id")
        ->join("tipos_pruebas", "tipos_pruebas.id", "=", "gestion_pruebas.tipo_prueba_id")
        ->where("gestion_pruebas.candidato_id", $candidato->user_id)
        ->select("gestion_pruebas.*", "tipos_pruebas.descripcion as prueba_desc", "users.name")
        ->orderBy("gestion_pruebas.created_at","desc")
        ->get();

        $req_prueba_gestionado = [];
        $req_gestion = GestionPrueba::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "gestion_pruebas.id")
        ->select("gestion_pruebas.id")
        ->where("proceso_requerimiento.requerimiento_id", $candidato->requerimiento_id)
        ->where("proceso_requerimiento.tipo_entidad", "MODULO_PRUEBAS")
        ->get();

        foreach ($req_gestion as $key => $value) {
            array_push($req_prueba_gestionado, $value->id);
        }

        return view("admin.reclutamiento.gestionar_prueba", compact("candidato", "pruebas", "estados_procesos_referenciacion", "req_prueba_gestionado"));
    }

    public function registra_proceso_entidad(Request $data)
    {   
        //$ae = GestionPrueba::find($data->prueba_id);
        //$ae->activo = 0;

        $proceso_req=ProcesoRequerimiento::where("entidad_id",$data->get("prueba_id"))
        ->where("tipo_entidad","MODULO_PRUEBAS")
        ->where("requerimiento_id",$data->get("req_id"))
        ->first();

        if(count($proceso_req)>0){
            $proceso_req->activo=0;
            $proceso_req->save();
        }

        //$this->procesoRequerimiento($pruebas->id, $data->get("ref_id"), "MODULO_PRUEBAS");
        //$ae->save();
    }

    public function registra_proceso_entidad2(Request $data)
    {
        $proceso_req=ProcesoRequerimiento::where("entidad_id",$data->get("prueba_id"))
        ->where("tipo_entidad","MODULO_PRUEBAS")
        ->where("requerimiento_id",$data->get("req_id"))
        ->first();

        if(count($proceso_req) > 0){
            $proceso_req->activo = 1;
            $proceso_req->save();
        }else{
            $relacionProceso = new ProcesoRequerimiento();
            $relacionProceso->fill([
                "tipo_entidad" => "MODULO_PRUEBAS",
                "entidad_id" => $data->get("prueba_id"),
                "requerimiento_id" => $data->get("req_id"),
                "user_id" => $this->user->id
            ]);
            $relacionProceso->save();
        }
        
        //$ae = GestionPrueba::find($data->prueba_id);
        //$ae->activo = 1;
        //$ae->save();
    }

    //Pruebas de tendencias

    //Modal de prueba de tendencia
    public function modal_prueba(Request $data)
    {
        $numero_id = $data->hv_id;
        $candidato = DatosBasicos::where("numero_id", $numero_id)->first();

        $tipo_pruebas = TipoPrueba::where("id", config('conf_aplicacion.ID_PRUEBA_TENDENCIA'))
        ->where("estado", 1)
        ->pluck("descripcion", "id")
        ->toArray();

        return view("admin.pruebas.tendencia.modal.realizar_prueba", compact("candidato", "tipo_pruebas"));
    }

    public function lista_prueba_tendencia(Request $data)
    {
        $identificacion = $data->codigo;

        if ($identificacion !== null) {
            //Consultar los candidatos que realizaron pruebas
            $candidatos = DatosBasicos::join("gestion_pruebas", "gestion_pruebas.candidato_id", "=", "datos_basicos.user_id")
                ->where("gestion_pruebas.tipo_prueba_id", config('conf_aplicacion.ID_PRUEBA_TENDENCIA'))
                ->where("datos_basicos.numero_id", $identificacion)
                ->where("gestion_pruebas.fecha_vencimiento", ">=", date('Y-m-d'))
                ->get();

            $presento = "SI";

            //Si la consulta de $candidatos no trae registro es por que la persona no tiene pruebas
            if ($candidatos->count() === 0) {
                $candidatos = DatosBasicos::where("numero_id", $identificacion)
                    ->get();
                $presento = "NO";
                //dd($candidatos);
            }
        } else {
            //Cuando no tingresan número de identificación no muestra nada
            $candidatos = DatosBasicos::join("gestion_pruebas", "gestion_pruebas.candidato_id", "=", "datos_basicos.user_id")
                ->where("gestion_pruebas.tipo_prueba_id", config('conf_aplicacion.ID_PRUEBA_TENDENCIA'))
                ->where("datos_basicos.numero_id", $identificacion)
                ->where("gestion_pruebas.fecha_vencimiento", ">=", date('Y-m-d'))
                ->get();

        }

        return view("admin.pruebas.tendencia.index", compact("candidatos", "presento"));
    }

    public function guardar_prueba_tendencia(Request $data)
    {
        $rules = [
            "tipo_prueba_id" => "required",
            "puntaje"        => "required|numeric",
            "resultado"      => "required",
            "estado"         => "required",
            //"nombre_archivo" => "required",
        ];

        $valida = Validator::make($data->all(), $rules);

        $candidato_id = $data->candidato_id;
        $candidato    = DatosBasicos::where("user_id", $candidato_id)->first();

        $tipo_pruebas = TipoPrueba::where("id", config('conf_aplicacion.ID_PRUEBA_TENDENCIA'))
        ->where("estado", 1)
        ->pluck("descripcion", "id")
        ->toArray();

        if ($valida->fails()) {
            return response()->json([
                "success" => false,
                "view" => view("admin.pruebas.tendencia.modal.realizar_prueba",
                compact("tipo_pruebas", "candidato"))->withErrors($valida)->render()
            ]);
        }

        //Consulta para sumarle los meses de vencimiento de la prueba
        $mese_prueba = TipoPrueba::where("id", $data->tipo_prueba_id)->first();

        $date              = Carbon::now();
        $fecha_vencimiento = $date->addMonths($mese_prueba->vigencia);

        $pruebas = new GestionPrueba();
        $pruebas->fill($data->all() + [
            "user_id" => $this->user->id,
            "candidato_id" => $candidato_id,
            "fecha_vencimiento" => $fecha_vencimiento
        ]);
        $pruebas->save();

        $fecha = date('Y-m-d'); //Fecha actual para guardar el archivo con numero_id y fecha

        if ($data->hasFile("nombre_archivo")) {
            $extencionsFile = $data->file("nombre_archivo")->getClientOriginalExtension();

            if ($extencionsFile == "doc" || $extencionsFile == "docx" || $extencionsFile == "pdf") {
                //GUARDAR DOCUMENTO
                $imageName      = "prueba_tendencia_" . $candidato->numero_id . "_" . $fecha . "." . $extencionsFile;
                $data->file('nombre_archivo')->move("recursos_pruebas/", $imageName);
                $pruebas->nombre_archivo = $imageName;
                $pruebas->save();
            }else{
                return response()->json(["error" => true]);
            }
        }

        $this->procesoRequerimiento($pruebas->id, $data->get("ref_id"), "MODULO_PRUEBAS");
        return response()->json(["success" => true]);
    }
}
