<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\DatosBasicos;
use App\Models\Documentos;
use App\Models\DocumentosVerificados;
use App\Models\ProcesoRequerimiento;
use App\Models\RegistroProceso;
use App\Models\ReqCandidato;
use App\Models\TipoDocumento;
use App\Models\SitioModulo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use App\Models\ExamenesMedicos;
use App\Models\OrdenMedica;
use App\Jobs\FuncionesGlobales;

use App\Models\EstudiosSeguridad;
use App\Models\OrdenEstudioSeguridad;
use App\Models\OrdenMedicaResultado;
use App\Models\CargosEstudiosSeguridad;

use App\Models\EstadosOrdenes;
use App\Models\DocumentoCliente;
use App\Models\CategoriaDocumentoCliente;
use Log;
use App\Http\Requests\DocumentoNuevoRequest;
use App\Http\Requests\DocumentoEditarRequest;

class DocumentosController extends Controller
{
    public function index()
    {
        $menu = DB::table("menu_candidato")->where("estado",1)
        ->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();

        $tipoDocumento = ["" => "Seleccionar"] + TipoDocumento::where("categoria", 1)->where("active", "1")->where("carga_candidato", 1)->orderBy("descripcion")->pluck("descripcion", "id")->toArray();

        $documentos = Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
        ->select("documentos.*", "tipos_documentos.descripcion as tipo_doc")
        ->where("carga_candidato",1)
        ->where("documentos.active",1)
        ->where("documentos.user_id", $this->user->id)
        ->get();

        return view("cv.documentos", compact("tipoDocumento", "documentos","menu"));
    }

    public function guardar_documento(DocumentoNuevoRequest $data)
    {
        if ($data->hasFile('archivo_documento') || $data->hasFile('foto-documento')) {
            if (!$data->hasFile('archivo_documento')) {
                $imagen = $data->file("foto-documento");
            }else {
                $imagen = $data->file("archivo_documento");
            }

            $extension = $imagen->getClientOriginalExtension();

            $documentos = new Documentos();

            $documentos->fill($data->except('fecha_vencimiento') + [
                "user_id" => $this->user->id,
                "numero_id" => $this->user->getCedula()->numero_id
            ]);

            if ($data->fecha_vencimiento != null && $data->fecha_vencimiento != '') {
                $documentos->fecha_vencimiento = $data->fecha_vencimiento;
            }

            $documentos->save();

            $name_documento = "documento_" . $documentos->id . "." . $extension;
            $imagen->move("recursos_documentos", $name_documento);

            $documentos->nombre_archivo = $name_documento;
            $documentos->nombre_archivo_real = $imagen->getClientOriginalName();
            $documentos->gestiono = $this->user->id;
            $documentos->save();

            $mensaje = "Se ha cargado el documento sin errores";
        }

        $campos = [];

        $tipoDocumento = ["" => "Seleccionar"] + TipoDocumento::where("active", "1")
        ->where("categoria", 1)
        ->where("carga_candidato", 1)
        ->pluck("descripcion", "id")
        ->toArray();

        $documento = Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
        ->where("documentos.id", $documentos->id)
        ->select("documentos.*", "tipos_documentos.descripcion as tipo_doc")
        ->first();

        return response()->json([
            "mensaje_success" => $mensaje,
            "documento" => $documento,
            "success" => true,
            "view" => view("cv.modal.fr_documentos", compact("campos", "tipoDocumento", "mensaje"))->render()
        ]);
    }

    public function editar_documento(Request $data)
    {
        $campos = Documentos::find($data->get("id"));

        return response()->json(["data" => $campos]);
    }

    public function actualizar_documento(DocumentoEditarRequest $data)
    {
        $documentos = Documentos::find($data->get("id"));
        $documentos->fill($data->all());
        $documentos->save();

        if ($data->hasFile('archivo_documento') || $data->hasFile('foto-documento')) {
            if (!$data->hasFile('archivo_documento')) {
                $imagen = $data->file("foto-documento");
            }else {
                $imagen = $data->file("archivo_documento");
            }

            if (file_exists("recursos_documentos/" . $documentos->nombre_archivo) && $documentos->nombre_archivo != "") {
                unlink("recursos_documentos/" . $documentos->nombre_archivo);
            }

            $extension = $imagen->getClientOriginalExtension();

            $name_documento = "documento_" . $documentos->id . "." . $extension;
            $imagen->move("recursos_documentos", $name_documento);

            $documentos->nombre_archivo = $name_documento;
            $documentos->nombre_archivo_real = $imagen->getClientOriginalName();
            $documentos->save();
        }

        return response()->json(['success' => true]);
    }

    public function cancelar_documento(Request $data)
    {
        $campos        = [];
        $tipoDocumento = ["" => "Seleccionar"] + TipoDocumento::where("active", "1")->pluck("descripcion", "id")->toArray();

        return response()->json(["success" => true, "view" => view("cv.modal.fr_documentos", compact("campos", "tipoDocumento"))->render()]);
    }

    public function eliminar_documento(Request $data)
    {
        $documento = Documentos::find($data->get("id"));
        $documento->active=0;
        $documento->eliminado=$this->user->id;
        $documento->fecha_eliminacion=date("Y-m-d H:i:s");
        $documento->save();
        
        if ( $documento->certificado != null ) {
            $documento->certificado->delete();
        }
        
        return response()->json(["id" => $data->get("id")]);
    }

    public function ver_file_documento(Request $data)
    {
        $documento = Documentos::find($data->get("id"));
        return response()->json(["documento" => $documento]);
    }

    public function lista_documentos(Request $data)
    {
        if (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") {
            $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
            ->leftjoin('solicitudes', 'solicitudes.id', '=', 'requerimientos.solicitud_id')
            ->leftjoin('solicitud_sedes', 'solicitud_sedes.id', '=', 'solicitudes.ciudad_id')
            ->whereRaw(" (procesos_candidato_req.apto is null )  ")
            ->whereIn("requerimiento_cantidato.estado_candidato", [7,8])
            ->whereIn("procesos_candidato_req.estado", [7,8])
            ->where(function ($sql) use ($data) {
                //Filtro por codigo requerimiento
                if ($data->codigo != "") {
                    $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                }

                //Filtro por cedula de candidato
                if ($data->cedula != "") {
                    $sql->where("datos_basicos.numero_id", $data->cedula);
                }
            })
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_DOCUMENTOS", "ENVIO_DOCUMENTOS_PENDIENTE"])
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente',
                'solicitud_sedes.descripcion'
            )
            ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            
            ->paginate(5); 

        }elseif(route("home") == "http://localhost:8000" || route("home") == "https://demo.t3rsc.co"){

            $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
            ->whereRaw(" (procesos_candidato_req.apto is null )  ")
            ->whereIn("requerimiento_cantidato.estado_candidato", [7,8])
            ->whereIn("procesos_candidato_req.estado", [7,8])
            ->where(function ($sql) use ($data) {
                //Filtro por codigo requerimiento
                if ($data->codigo != "") {
                    $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                }

                //Filtro por cedula de candidato
                if ($data->cedula != "") {
                    $sql->where("datos_basicos.numero_id", $data->cedula);
                }
            })
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_DOCUMENTOS", "ENVIO_DOCUMENTOS_PENDIENTE"])
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente'
            )
            ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            ->paginate(5);

        }else{

            $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->whereRaw(" (procesos_candidato_req.apto is null )  ")
            ->whereIn("requerimiento_cantidato.estado_candidato", [7,8,11])
            ->whereIn("procesos_candidato_req.estado", [7,8,11])
            ->where(function ($sql) use ($data) {
                //Filtro por codigo requerimiento
                if ($data->codigo != "") {
                    $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                }

                //Filtro por cedula de candidato
                if ($data->cedula != "") {
                    $sql->where("datos_basicos.numero_id", $data->cedula);
                }
            })
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_DOCUMENTOS", "ENVIO_DOCUMENTOS_PENDIENTE"])
            ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente'
            )
            ->paginate(5);         

        }

        return view("admin.reclutamiento.documentos", compact("candidatos"));
    }

    public function lista_documentos_medicos(Request $data)
    {
        $sitio_modulo = SitioModulo::first();
        if (!is_null($data->dsd)) {
            session(["url_a_redireccionar" => url()->previous()]);
        }

        if (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") {    

            $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
            ->leftjoin('solicitudes', 'solicitudes.id', '=', 'requerimientos.solicitud_id')
            ->leftjoin('solicitud_sedes', 'solicitud_sedes.id', '=', 'solicitudes.ciudad_id')
            ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = 3 )")
            ->whereNotIn("requerimiento_cantidato.estado_candidato", [12, 13, 14, 23])
            ->whereNotIn("procesos_candidato_req.estado", [12, 13, 14, 23])
            ->where(function ($sql) use ($data) {
                //Filtro por codigo requerimiento
                if ($data->codigo != "") {
                    $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                }

                //Filtro por cedula de candidato
                if ($data->cedula != "") {
                    $sql->where("datos_basicos.numero_id", $data->cedula);
                }
            })
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_EXAMENES"])
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente',
                'solicitud_sedes.descripcion'
            )
            ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            ->get();

        }elseif($sitio_modulo->salud_ocupacional != 'si'){

            $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
            ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = 3 )")
            ->whereNotIn("requerimiento_cantidato.estado_candidato", [config('conf_aplicacion.C_CONTRATADO'), config('conf_aplicacion.C_INACTIVO'), config('conf_aplicacion.C_QUITAR'), config('conf_aplicacion.C_TRANSFERIDO')])
            ->whereNotIn("procesos_candidato_req.estado", [config('conf_aplicacion.C_CONTRATADO'), config('conf_aplicacion.C_INACTIVO'), config('conf_aplicacion.C_QUITAR'), config('conf_aplicacion.C_TRANSFERIDO')])
            ->where(function ($sql) use ($data) {
                //Filtro por codigo requerimiento
                if ($data->codigo != "") {
                    $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                }

                //Filtro por cedula de candidato
                if ($data->cedula != "") {
                    $sql->where("datos_basicos.numero_id", $data->cedula);
                }
            })
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_EXAMENES"])
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato'
                //'requerimiento_cantidato.otra_fuente'
            )
            ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            ->get();

        }else{

            $estados=[1];
            $search=false;
            $candidatos = OrdenMedica::join("requerimiento_cantidato","requerimiento_cantidato.id","=","orden_medica.req_can_id")
            ->join("datos_basicos","datos_basicos.user_id","=","requerimiento_cantidato.candidato_id")
            ->join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join("ordenes_estados","ordenes_estados.orden_id","=","orden_medica.id")
            ->join('ciudad', function ($join) {
                $join->on('requerimientos.ciudad_id', '=', 'ciudad.cod_ciudad')
                    ->on('requerimientos.departamento_id', '=', 'ciudad.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'ciudad.cod_pais');
            })
            ->join('departamentos', function ($join2) {
                $join2->on('requerimientos.departamento_id', '=', 'departamentos.cod_departamento')
                    ->on('requerimientos.pais_id', '=', 'departamentos.cod_pais');
            })
            ->join('paises', 'requerimientos.pais_id', '=', 'paises.cod_pais')
             ->join("estados_requerimiento","estados_requerimiento.req_id","=","requerimiento_cantidato.requerimiento_id")
            ->whereRaw('ordenes_estados.id = (select max(ordenes_estados.id) from ordenes_estados where ordenes_estados.orden_id = orden_medica.id)')
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')

            ->where(function ($sql) use ($data,&$estados,&$search) {
                //Filtro por codigo requerimiento
                if ($data->codigo != "") {
                    $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                    $estados=[1,2,3,4,6];
                    $search=true;
                    //$estados=[1,2,3,4];
                }

                if ($data->orden_id != "") {
                    $sql->where("orden_medica.id", $data->orden_id);
                    $estados=[1,2,3,4,6];
                    $search=true;
                    //$estados=[1,2,3,4];
                }

                 if ($data->ciudad_id != "" && $data->ciudad_id!=null) {
                    $sql->where("requerimientos.ciudad_id", $data->ciudad_id);
                    $sql->where("requerimientos.departamento_id", $data->departamento_id);
                    $sql->where("requerimientos.pais_id", $data->pais_id);
                    $estados=[1,2,3,4,6];
                    $search=true;
                }

                //Filtro por cedula de candidato
                if ($data->cedula != "") {
                    $sql->where("datos_basicos.numero_id", $data->cedula);
                    $estados=[1,2,3,4,6];
                    $search=true;
                }

                if($data->fecha_orden!="" && $data->fecha_orden!=null){
                   $rango=explode(" | ", $data->fecha_orden);
                   $sql->whereBetween(DB::raw('DATE_FORMAT(orden_medica.created_at, \'%Y-%m-%d\')'),[$rango[0],$rango[1]]);
                   $estados=[1,2,3,4,6];
                   $search=true;
               }
            })
            ->whereIn("ordenes_estados.estado_id", $estados)
            ->where("orden_medica.active",1)
            ->whereNotIn("estados_requerimiento.id",[config('conf_aplicacion.C_TERMINADO'),
                            config('conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL'),
                            config('conf_aplicacion.C_CLIENTE')
            ])
            ->whereNotIn("requerimiento_cantidato.estado_candidato",[12])
            ->select(
                "orden_medica.*",
                "orden_medica.id as orden",
                "cargos_especificos.descripcion as cargo",
                "datos_basicos.nombres as candidato",
                "datos_basicos.primer_apellido",
                "datos_basicos.segundo_apellido",
                "requerimiento_cantidato.requerimiento_id as requerimiento",
                "datos_basicos.numero_id as numero_id",
                "ciudad.nombre as ciudad",
                "ordenes_estados.estado_id as estado",
                DB::raw("(select name from users where id=orden_medica.user_envio) as user_envio_orden")
            )
            ->orderBy("orden_medica.created_at","ASC")
            ->get();

        }

        return view("admin.reclutamiento.documentos_medicos-new", compact("candidatos"));
    }

    //--
    public function lista_documentos_estudio_seguridad(Request $data){

        if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co"){
            
            $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
            ->leftjoin('solicitudes', 'solicitudes.id', '=', 'requerimientos.solicitud_id')
            ->leftjoin('solicitud_sedes', 'solicitud_sedes.id', '=', 'solicitudes.ciudad_id')
            ->whereRaw(" (procesos_candidato_req.apto is null )  ")
            ->where("requerimiento_cantidato.estado_candidato", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
            ->where("procesos_candidato_req.estado", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
            ->where(function ($sql) use ($data) {
                //Filtro por codigo requerimiento
                if ($data->codigo != "") {
                    $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                }

                //Filtro por cedula de candidato
                if ($data->cedula != "") {
                    $sql->where("datos_basicos.numero_id", $data->cedula);
                }
            })
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_EXAMENES"])
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente',
                'solicitud_sedes.descripcion'
            )
            ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            ->get();

        }elseif(route("home") == "http://localhost:8000" || route("home") == "https://demo.t3rsc.co" || route("home") == "https://listos.t3rsc.co" || route("home") == "https://desarrollo.t3rsc.co"){

           $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
            ->whereRaw(" (procesos_candidato_req.apto is null )  ")
            ->where("requerimiento_cantidato.estado_candidato", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
            ->where("procesos_candidato_req.estado", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))
            ->where(function ($sql) use ($data) {
                //Filtro por codigo requerimiento
                if ($data->codigo != "") {
                    $sql->where("requerimiento_cantidato.requerimiento_id", $data->codigo);
                }
                //Filtro por cedula de candidato
                if ($data->cedula != "") {
                    $sql->where("datos_basicos.numero_id", $data->cedula);
                }
            })
            ->whereIn("procesos_candidato_req.proceso", ["ENVIO_ESTUDIO_SEGURIDAD"])
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente'
            )
            ->orderBy('requerimiento_cantidato.requerimiento_id','desc')
            ->get();

           // dd($candidatos);
        }else{

            $candidatos = OrdenEstudioSeguridad::join("requerimiento_cantidato","requerimiento_cantidato.id","=","orden_estudio_seguridad.req_can_id")
            ->join("datos_basicos","datos_basicos.user_id","=","requerimiento_cantidato.candidato_id")
            ->join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->where("orden_estudio_seguridad.resultado", null)
            ->select("orden_estudio_seguridad.*","orden_estudio_seguridad.id as orden","cargos_especificos.descripcion as cargo","datos_basicos.nombres as candidato","requerimiento_cantidato.requerimiento_id as requerimiento","datos_basicos.numero_id as numero_id")
            ->orderBy("orden_estudio_seguridad.created_at","DESC")
            ->get();

        }

        return view("admin.reclutamiento.documentos_estudio_seguridad", compact("candidatos"));
    }

    public function gestionar_documentos_estudio_seguridad($id)
    {

        if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co"){

            $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = '' )")
            ->where("procesos_candidato_req.id", $id)
            ->select("procesos_candidato_req.requerimiento_candidato_id",
                "procesos_candidato_req.id as ref_id", "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente')
            ->first();

            if ($candidato == null){
                return redirect()->route("admin.valida_documentos");
            }

            $estados_procesos_referenciacion = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_EXAMENES"])->get();

            $req_prueba_gestionado = [];

            //DOCUMENTOS CARGADOS POR EL CANDIDATO
            $documentos = Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
            ->where("documentos.user_id", $candidato->candidato_id)
            ->where("tipos_documentos.id", 9)
            ->selectRaw("(documentos.fecha_vencimiento - CURDATE()) AS diferencia_dias ,documentos.* , tipos_documentos.descripcion as tipo_doc")
            ->orderBy("documentos.created_at","desc")
            ->get();

            //DOCUMENTOS CARGADOS POR EL ADMINISTRADOR(PSICOLOGO)
            $documento_verificados = DocumentosVerificados::join("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")
            ->where("documentos_verificados.candidato_id", $candidato->candidato_id)
            ->where("tipos_documentos.id",9)
            ->selectRaw(" (documentos_verificados.fecha_vencimiento - CURDATE()) AS diferencia_dias , documentos_verificados.* , tipos_documentos.descripcion as tipo_doc")
            ->orderBy("documentos_verificados.created_at","desc")
            ->get();

            //VALIDA SI EL DOCUMENTOS YA FUE VERIFICADO EN ESTE REQUERIMIENTO
            $req_gestion = DocumentosVerificados::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "documentos_verificados.id")
            ->select("documentos_verificados.id")
            ->where("proceso_requerimiento.requerimiento_id", $candidato->requerimiento_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_DOCUMENTO")
            ->get();

            foreach ($req_gestion as $key => $value) {
                array_push($req_prueba_gestionado, $value->id);
            }

            return view("admin.reclutamiento.gestionar_documentos_medicos", compact("candidato", "pruebas", "estados_procesos_referenciacion", "req_prueba_gestionado", "documentos", "documento_verificados"));

        }elseif(1==1){

          $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
             ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
             ->whereRaw("(procesos_candidato_req.apto is null or procesos_candidato_req.apto = '')")
             ->where("procesos_candidato_req.id", $id)
             ->select("procesos_candidato_req.requerimiento_candidato_id",
                "procesos_candidato_req.id as ref_id", "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente')
            ->first();

            if ($candidato == null){
                return redirect()->route("admin.valida_documentos");
            }

            $estados_procesos_referenciacion = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_EXAMENES"])->get();

            $req_prueba_gestionado = [];

            //DOCUMENTOS CARGADOS POR EL CANDIDATO
            $documentos = Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
            ->where("documentos.user_id", $candidato->candidato_id)
            ->where("tipos_documentos.id", 48)
            ->selectRaw("(documentos.fecha_vencimiento - CURDATE()) AS diferencia_dias ,documentos.* , tipos_documentos.descripcion as tipo_doc")
            ->orderBy("documentos.created_at","desc")
            ->get();

            //DOCUMENTOS CARGADOS POR EL ADMINISTRADOR(PSICOLOGO)
            $documento_verificados = DocumentosVerificados::join("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")
             ->where("documentos_verificados.candidato_id", $candidato->candidato_id)
             ->where("tipos_documentos.id",48)
             ->selectRaw("(documentos_verificados.fecha_vencimiento - CURDATE()) AS diferencia_dias, documentos_verificados.* , tipos_documentos.descripcion as tipo_doc")
             ->orderBy("documentos_verificados.created_at","desc")
             ->get();

            //VALIDA SI EL DOCUMENTOS YA FUE VERIFICADO EN ESTE REQUERIMIENTO
            $req_gestion = DocumentosVerificados::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "documentos_verificados.id")
            ->select("documentos_verificados.id")
            ->where("proceso_requerimiento.requerimiento_id", $candidato->requerimiento_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_DOCUMENTO")
            ->get();

            foreach ($req_gestion as $key => $value) {
             array_push($req_prueba_gestionado, $value->id);
            }

         return view("admin.reclutamiento.gestionar_documentos_estudio_seguridad", compact("candidato","estados_procesos_referenciacion","req_prueba_gestionado","documentos","documento_verificados"));
        }
        else{

            $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->join("orden_estudio_seguridad", "orden_estudio_seguridad.req_can_id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = '' )")
            ->where("orden_estudio_seguridad.id", $id)
            ->select("procesos_candidato_req.requerimiento_candidato_id",
                "procesos_candidato_req.id as ref_id", "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.id as req_can_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente',
                'orden_estudio_seguridad.id as orden',
                'cargos_especificos.descripcion as cargo'
            )
            ->first();

            $ordenes = OrdenEstudioSeguridad::find($id);
            
            $estudiosSeg = EstudiosSeguridad::join('estudios_seguridad_list',"estudios_seguridad_list.id","=","estudio_seguridad.estudio_seg_id")
            ->join("orden_estudio_seguridad","orden_estudio_seguridad.id","=","estudio_seguridad.orden_seg_id")
            ->where("orden_estudio_seguridad.id", $id)
            ->select("orden_estudio_seguridad.id as orden","estudios_seguridad_list.nombre as nombre")
            //->groupBy("orden_estudio_seguridad.id")
            ->get();

            if ($candidato == null){
                return redirect()->route("admin.valida_documentos");
            }

            $estados_procesos_referenciacion = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_ESTUDIO_SEGURIDAD"])->get();

            $req_prueba_gestionado = [];

            //DOCUMENTOS CARGADOS POR EL CANDIDATO
            $documentos = Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
            ->where("documentos.user_id", $candidato->candidato_id)
            ->where("tipos_documentos.id", 9)
            ->selectRaw("(documentos.fecha_vencimiento - CURDATE()) AS diferencia_dias ,documentos.* , tipos_documentos.descripcion as tipo_doc")
            ->orderBy("documentos.created_at","desc")
            ->get();

            //DOCUMENTOS CARGADOS POR EL ADMINISTRADOR(PSICOLOGO)
            $documento_verificados = DocumentosVerificados::join("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")
            ->where("documentos_verificados.candidato_id", $candidato->candidato_id)
            ->where("tipos_documentos.id",9)
            ->selectRaw(" (documentos_verificados.fecha_vencimiento - CURDATE()) AS diferencia_dias , documentos_verificados.* , tipos_documentos.descripcion as tipo_doc")
            ->orderBy("documentos_verificados.created_at","desc")
            ->get();

            //VALIDA SI EL DOCUMENTOS YA FUE VERIFICADO EN ESTE REQUERIMIENTO
            $req_gestion = DocumentosVerificados::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "documentos_verificados.id")
            ->select("documentos_verificados.id")
            ->where("proceso_requerimiento.requerimiento_id", $candidato->requerimiento_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_DOCUMENTO")
            ->get();

            foreach ($req_gestion as $key => $value) {
                array_push($req_prueba_gestionado, $value->id);
            }

            return view("admin.reclutamiento.gestionar_documentos_estudio_seguridad", compact("candidato", "pruebas", "estados_procesos_referenciacion", "req_prueba_gestionado", "documentos", "documento_verificados","estudiosSeg","ordenes"));
        }
        
    }
    //--

    public function gestionar_documentos($id)
    {

       $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = '' )")
            ->where("procesos_candidato_req.id", $id)
            ->select("procesos_candidato_req.requerimiento_candidato_id",
                "procesos_candidato_req.id as ref_id", "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente')
            ->first();

        if ($candidato == null) {
            return redirect()->route("admin.valida_documentos");
        }

        $estados_procesos_referenciacion = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_DOCUMENTOS", "ENVIO_DOCUMENTOS_PENDIENTE"])->get();

        $req_prueba_gestionado = [];

        //DOCUMENTOS CARGADOS POR EL CANDIDATO
        $documentos = Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
            ->where("documentos.user_id", $candidato->candidato_id)
            ->where("tipos_documentos.categoria",1)
            ->selectRaw("(documentos.fecha_vencimiento - CURDATE()) AS diferencia_dias ,documentos.* , tipos_documentos.descripcion as tipo_doc")
            ->orderBy("documentos.created_at","desc")
            ->get();

        //DOCUMENTOS CARGADOS POR EL ADMINISTRADOR(PSICOLOGO)
        $documento_verificados = DocumentosVerificados::join("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")
            ->where("documentos_verificados.candidato_id", $candidato->candidato_id)
            ->where("tipos_documentos.categoria",1)
            ->selectRaw(" (documentos_verificados.fecha_vencimiento - CURDATE()) AS diferencia_dias , documentos_verificados.* , tipos_documentos.descripcion as tipo_doc")
            ->orderBy("documentos_verificados.created_at","desc")
            ->get();

            //dd($documento_verificados);
        //VALIDA SI EL DOCUMENTOS YA FUE VERIFICADO EN ESTE REQUERIMIENTO
        $req_gestion = DocumentosVerificados::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "documentos_verificados.id")
            ->select("documentos_verificados.id")
            ->where("proceso_requerimiento.requerimiento_id", $candidato->requerimiento_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_DOCUMENTO")
            ->get();

          foreach ($req_gestion as $key => $value) {
            array_push($req_prueba_gestionado, $value->id);
          }

        return view("admin.reclutamiento.gestionar_documentos", compact("candidato", "pruebas", "estados_procesos_referenciacion", "req_prueba_gestionado", "documentos", "documento_verificados"));
    }

    public function gestionar_documentos_medicos($id)
    {
        if (session('url_a_redireccionar') !== null) {
            $ruta = session('url_a_redireccionar');
            session(["url_a_redireccionar" => null]);
        } else {
            $ruta = url()->previous();
        }
        session(["url_previa" => $ruta]);
        $sitio_modulo = SitioModulo::first();

        if($sitio_modulo->salud_ocupacional != "si"){

            $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = '' or procesos_candidato_req.apto = 3)")
            ->where("procesos_candidato_req.id", $id)
            ->select("procesos_candidato_req.requerimiento_candidato_id",
                "procesos_candidato_req.id as ref_id", "datos_basicos.*",
                'cargos_especificos.descripcion as cargo',
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente')
            ->first();

            if ($candidato == null) {
                return redirect()->route("admin.examenes_medicos");
            }

            $estados_procesos_referenciacion = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_EXAMENES"])
            ->get();

            $tipos_doc_ids = TipoDocumento::where("active", "1")
            ->where("categoria", "3")
            ->whereRaw("codigo REGEXP '^[0-9]+$'")
            ->pluck("id")
            ->toArray();

            $req_prueba_gestionado = [];

            //DOCUMENTOS CARGADOS POR EL CANDIDATO
            $documentos = Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
            ->where("documentos.user_id", $candidato->candidato_id)
            ->where("documentos.requerimiento", $candidato->requerimiento_id)
            ->whereIn("tipos_documentos.id", $tipos_doc_ids)
            ->selectRaw("(documentos.fecha_vencimiento - CURDATE()) AS diferencia_dias ,documentos.* , tipos_documentos.descripcion as tipo_doc")
            ->orderBy("documentos.created_at","desc")
            ->get();

            //DOCUMENTOS CARGADOS POR EL ADMINISTRADOR(PSICOLOGO)
            $documento_verificados = DocumentosVerificados::join("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")
            ->where("documentos_verificados.candidato_id", $candidato->candidato_id)
            ->whereIn("tipos_documentos.id", $tipos_doc_ids)
            ->selectRaw(" (documentos_verificados.fecha_vencimiento - CURDATE()) AS diferencia_dias , documentos_verificados.* , tipos_documentos.descripcion as tipo_doc")
            ->orderBy("documentos_verificados.created_at","desc")
            ->get();

            //dd($documento_verificados);

            //VALIDA SI EL DOCUMENTOS YA FUE VERIFICADO EN ESTE REQUERIMIENTO
            $req_gestion = DocumentosVerificados::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "documentos_verificados.id")
            ->select("documentos_verificados.id")
            ->where("proceso_requerimiento.requerimiento_id", $candidato->requerimiento_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_DOCUMENTO")
            ->get();

            foreach ($req_gestion as $key => $value) {
                array_push($req_prueba_gestionado, $value->id);
            }

            return view("admin.reclutamiento.gestionar_documentos_medicos", compact(
                "candidato",
                "pruebas",
                "estados_procesos_referenciacion",
                "req_prueba_gestionado",
                "documentos",
                "documento_verificados"
            ));
        }else{
            $candidato = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
            ->join("cargos_especificos", "cargos_especificos.id", "=", "requerimientos.cargo_especifico_id")
            ->join("orden_medica", "orden_medica.req_can_id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->whereRaw(" (procesos_candidato_req.apto is null or procesos_candidato_req.apto = '' )")
            ->where("orden_medica.id", $id)
            ->select(
                "procesos_candidato_req.requerimiento_candidato_id",
                "procesos_candidato_req.id as ref_id", "datos_basicos.*",
                'requerimiento_cantidato.requerimiento_id',
                'requerimiento_cantidato.id as req_can_id',
                'requerimiento_cantidato.candidato_id',
                'requerimiento_cantidato.estado_candidato',
                'requerimiento_cantidato.otra_fuente',
                'orden_medica.id as orden',
                'cargos_especificos.descripcion as cargo'
            )
            ->first();

            $ordenes = OrdenMedica::find($id);
            
            $examenes = ExamenesMedicos::join('examen_medico',"examen_medico.id","=","examenes_medicos.examen")
            ->join("orden_medica","orden_medica.id","=","examenes_medicos.orden_id")
            ->where("orden_medica.id",$id)
            ->select("orden_medica.id as orden","examen_medico.nombre as nombre")
            ->get();

            if ($candidato == null) {
                return redirect()->route("admin.examenes_medicos");
            }

            $estados_procesos_referenciacion = RegistroProceso::join("users", "users.id", "=", "procesos_candidato_req.usuario_envio")
            ->leftJoin("motivos_rechazos", "motivos_rechazos.id", "=", "procesos_candidato_req.motivo_rechazo_id")
            ->where("requerimiento_candidato_id", $candidato->requerimiento_candidato_id)
            ->whereIn("proceso", ["ENVIO_EXAMENES"])
            ->get();

            $req_prueba_gestionado = [];

            //DOCUMENTOS CARGADOS POR EL CANDIDATO
            $documentos = Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
            ->where("documentos.user_id", $candidato->candidato_id)
            ->where("tipos_documentos.id", 9)
            ->selectRaw("(documentos.fecha_vencimiento - CURDATE()) AS diferencia_dias ,documentos.* , tipos_documentos.descripcion as tipo_doc")
            ->orderBy("documentos.created_at","desc")
            ->get();

            //DOCUMENTOS CARGADOS POR EL ADMINISTRADOR(PSICOLOGO)
            $documento_verificados = DocumentosVerificados::join("tipos_documentos", "tipos_documentos.id", "=", "documentos_verificados.tipo_documento_id")
            ->where("documentos_verificados.candidato_id", $candidato->candidato_id)
            ->where("tipos_documentos.id",9)
            ->selectRaw(" (documentos_verificados.fecha_vencimiento - CURDATE()) AS diferencia_dias , documentos_verificados.* , tipos_documentos.descripcion as tipo_doc")
            ->orderBy("documentos_verificados.created_at","desc")
            ->get();

            //VALIDA SI EL DOCUMENTOS YA FUE VERIFICADO EN ESTE REQUERIMIENTO
            $req_gestion = DocumentosVerificados::join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "documentos_verificados.id")
            ->select("documentos_verificados.id")
            ->where("proceso_requerimiento.requerimiento_id", $candidato->requerimiento_id)
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_DOCUMENTO")
            ->get();

            foreach ($req_gestion as $key => $value) {
                array_push($req_prueba_gestionado, $value->id);
            }
            
            return view("admin.reclutamiento.gestionar_documentos_medicos", compact(
                "candidato",
                "pruebas",
                "estados_procesos_referenciacion",
                "req_prueba_gestionado",
                "documentos",
                "documento_verificados",
                "examenes",
                "ordenes"
            ));
        }
    }

    public function enviar_documento_view(Request $data)
    {
        $candidato = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")->where("requerimiento_cantidato.id", $data->get("candidato_req"))
            ->select("datos_basicos.*", "requerimiento_cantidato.id as req_candidato")
            ->first();
        return view("admin.reclutamiento.modal.enviar_documento", compact("candidato"));
    }

    public function confirmar_documento(Request $data)
    {
        $controlleReclutamiento = new ReclutamientoController();
        $campos                 = [
            'requerimiento_candidato_id' => $data->get("candidato_req"),
            'usuario_envio'              => $this->user->id,
            "fecha_inicio"               => date("Y-m-d H:i:s"),
            'proceso'                    => "ENVIO_DOCUMENTOS",
        ];

        $id_proceso = $controlleReclutamiento->RegistroProceso($campos, config('conf_aplicacion.C_EN_PROCESO_SELECCION'), $data->get("candidato_req"));
        $estado = DB::table("estados")->where("id", config('conf_aplicacion.C_EN_PROCESO_SELECCION'))->first();
        return response()->json(["success" => true, "text_estado" => $estado->descripcion, 'candidato_req' => $data->get("candidato_req"),'id_proceso'=>$id_proceso]);
    }

    public function agrega_doc_gestion(Request $data)
    {

        $documento = Documentos::find($data->documento_id);
        $campos   = $documento->toArray();
        unset($campos["id"]);
        unset($campos["created_at"]);
        unset($campos["updated_at"]);
        if ($campos["fecha_vencimiento"] == '0000-00-00') {
            unset($campos["fecha_vencimiento"]);
        }

        $verificar_documento = new DocumentosVerificados();
        $verificar_documento->fill($campos + ["gestion_hv" => "hv", "candidato_id" => $documento->user_id]);
        $verificar_documento->documento_id_asociado = $data->documento_id;
        $verificar_documento->requerimiento_id = $data->req_id;
        $verificar_documento->save();

        $fileExtension = \File::extension("recursos_documentos/" . $documento->nombre_archivo);
        $nuevo_archivo = "documentos_verificados_" . $verificar_documento->id . ".$fileExtension";

        if (\File::copy("recursos_documentos/" . $documento->nombre_archivo, "recursos_documentos_verificados/$nuevo_archivo")) {
            $verificar_documento->nombre_archivo = $nuevo_archivo;
            $verificar_documento->save();
        }

        //GUARDAR_ RELACION DOCUMENTO REQUERIMIENTO
        $this->procesoRequerimiento($verificar_documento->id, $data->ref_id, "MODULO_DOCUMENTO", '', $data->resultado, $data->observacion);

        //File::copy("recursos_documentos/" . $documento["nombre_archivo"], "recursos_documentos_verificados/" . $documento["nombre_archivo"]);
    }

    public function nuevo_documento_verificado(Request $data)
    {
        $tipo="";
        $tipoDocumento = ["" => "Seleccionar"] + TipoDocumento::where("active", "1")
            ->where("estado",1)
            ->where("categoria",1)
            ->pluck("descripcion", "id")
            ->toArray();

        $orden = $data->ref_id;
            
            if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co"){
             $tipoDocumento = ["" => "Seleccionar","8"=>"ESTUDIO SEGURIDAD"];
             $tipo="ESTUDIO SEGURIDAD";
            }
        return view("admin.reclutamiento.modal.nuevo_documento", compact("tipoDocumento","tipo","orden"));
    }
    
    public function nuevo_documento_medico_verificado(Request $data)
    {
        $sitio_modulo = SitioModulo::first();
        if($sitio_modulo->salud_ocupacional != 'si') {
            $tipo = "";         
            $orden = $data->ref_id;

            $resultados = [""=>"seleccione"]+DB::table("tipo_resultado_examen_medico")->pluck("descripcion","id")->toArray();

            $tipoDocumento = ["" => "Seleccionar"] + TipoDocumento::where("active", "1")
            ->where("categoria", "3")
            ->whereRaw("codigo REGEXP '^[0-9]+$'")
            ->pluck("descripcion", "id")
            ->toArray();
                
            return view("admin.reclutamiento.modal.nuevo_examen_medico", compact("tipoDocumento", "orden", "sitio_modulo", "resultados"));
        } else {
            $tipo = "";
            $orden = $data->ref_id;
            $tipoDocumento = ["" => "Seleccionar", "9" => "EXAMEN MÉDICO"];
            //$tipo = "EXAMEN MEDICOS";
            $f = TipoDocumento::where("active", "1")->where("descripcion", "EXAMENES MÉDICOS")->first();
            $motivos_no_continua =[""=>"Seleccionar"]+DB::table('motivo_rechazo_examen_medico')->pluck("descripcion","id")->toArray();
            
            $tipo = $f->id;     
            $edit = $data->get("edit");
            $resultados = [""=>"seleccione"]+DB::table("tipo_resultado_examen_medico")->pluck("descripcion","id")->toArray();

            return view("admin.reclutamiento.modal.nuevo_examen_medico", compact("tipoDocumento", "tipo", "orden","motivos_no_continua","edit","resultados", "sitio_modulo"));
        }
    }

    //--
    public function nuevo_documento_estudio_seguridad_verificado(Request $data)
    {
        $f = TipoDocumento::where("active", "1")->where("descripcion", "ESTUDIO SEGURIDAD")->first();
        
        $tipo = $f->id;
        
        $tipoDocumento = ["" => "Seleccionar","48"=>"ESTUDIO SEGURIDAD"];
        //dd($data->all());

        if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co" || route("home")=="http://vym.t3rsc.co" || route("home")=="https://vym.t3rsc.co"){
            
            $tipoDocumento = ["" => "Seleccionar","9"=>"EXAMEN MËDICO"];
            $tipo = "EXAMEN MEDICOS";

          return view("admin.reclutamiento.modal.nuevo_documento", compact("tipoDocumento","tipo"));
        }

        $orden = $data->ref_id;
        
        return view("admin.reclutamiento.modal.nuevo_documento_estudio_seguridad", compact("tipoDocumento","tipo","orden"));        
    }

    public function guardar_estudio_seguridad(Request $data)
    {
       //dd($data->all());
       if(route("home")=="http://localhost:8000" || route("home")=="https://demo.t3rsc.co" || route("home")=="https://listos.t3rsc.co" || route("home")=="https://desarrollo.t3rsc.co"){
     //dd($data->resultado);
         $tipoDocumento = ["" => "Seleccionar"] + TipoDocumento::where("active", "1")->pluck("descripcion", "id")->toArray();

         $proceso = RegistroProceso::find($data->get("ref_id"));
         $proceso->apto = ($data->resultado == 1)?1:0;
         $proceso->observaciones = $data->observacion;
         $proceso->usuario_terminacion = $this->user->id;
        // dd($proceso->apto);
         $proceso->save();

         if($proceso->apto == 1){
           $ruta = route('admin.gestion_requerimiento',$proceso->requerimiento_id);
         }else{
           $ruta = route("admin.gestionar_documentos",[$data->get("ref_id")]);
         }
           //dd($ruta);

         $tipo = TipoDocumento::find($data->get("tipo"));
         $candidato=DatosBasicos::where("user_id",$proceso->candidato_id)->first();
//dd($tipo);
         $documentos = new Documentos();
         $documentos->fill($data->all() + ["tipo_documento_id"=>$tipo->id,"user_id" =>$candidato->user_id ,"requerimiento"=>$proceso->requerimiento_id,"numero_id"=>$candidato->numero_id]);
         $documentos->save();

        if(is_null($tipo)){
         $tipo= $data['tipo'];
        }else{
         $tipo = $tipo->descripcion; 
        }

        if($data->hasFile('archivo_documento')){

          $imagen         = $data->file("archivo_documento");
          $extencion      = $imagen->getClientOriginalExtension();
          $name_documento = "documento_estudio_seguridad_" . $documentos->id . "." . $extencion;

          $imagen->move("recursos_documentos_verificados", $name_documento);
            $documentos->nombre_archivo = $name_documento;
            $documentos->descripcion_archivo= "ESTUDIO DE SEGURIDAD";
            $documentos->save();
        }
        //GUARDAR_ RELACION DOCUMENTO REQUERIMIENTO
         $this->procesoRequerimiento($documentos->id, $data->get("ref_id"), "MODULO_DOCUMENTO");

        return response()->json(["success" => true, "ruta"=>$ruta]);

       }else{ 

        $orden = OrdenEstudioSeguridad::find($data->get("orden"));
        $req_can=ReqCandidato::where("requerimiento_cantidato.id",$orden->req_can_id);
        $orden->fill([
            "resultado"   => $data->get("resultado"),
            "observacion" => $data->get("observacion")
        ]);
        $orden->save();

        //Mientras ... después se puede cambiar para evitar tantas consultas
        $datosOthers = OrdenEstudioSeguridad::join("requerimiento_cantidato","requerimiento_cantidato.id","=","orden_estudio_seguridad.req_can_id")
        ->join("datos_basicos","datos_basicos.user_id","=","requerimiento_cantidato.candidato_id")
        ->where("orden_estudio_seguridad.id", $data->get("orden"))
        ->select("datos_basicos.*")
        ->first();

        $proceso = ReqCandidato::join("orden_estudio_seguridad","orden_estudio_seguridad.req_can_id","=","requerimiento_cantidato.id")
        ->where("orden_estudio_seguridad.id", $data->get("orden"))
        ->select("requerimiento_cantidato.candidato_id")
        ->first();

        $documentos = new Documentos();

        $documentos->fill($data->all() + [
            "numero_id"           => $datosOthers->numero_id,
            "user_id"             => $this->user->id,
            "tipo_documento_id"   => $data->get('tipo'),
            "descripcion_archivo" => "ESTUDIO DE SEGURIDAD",
        ]);
        $documentos->save();

        if ($data->hasFile('archivo_documento')) {

            $archivoDoc     = $data->file("archivo_documento");
            $extencion      = $archivoDoc->getClientOriginalExtension();

            $name_documento = "documento_estudio_seguridad_" . $documentos->id . "." . $extencion;

            $archivoDoc->move("recursos_documentos_verificados", $name_documento);

            $documentos->nombre_archivo = $name_documento;
            
            $orden->documento = $name_documento;

            $documentos->descripcion_archivo = $data->get("tipo");
            $documentos->requerimiento=$req_can->requerimiento_id;
            $documentos->save();

            $orden->save();
        }

       }//fin else
        //GUARDAR_ RELACION DOCUMENTO REQUERIMIENTO
       $this->procesoRequerimiento($documentos->id, $data->get("ref_id"), "MODULO_DOCUMENTO");
       
       return response()->json(["success" => true,"ruta"=>$ruta]);
    }
    //--

    public function guardar_documento_verificado(Request $data, Requests\AdminDocumentoNuevoRequest $valida)
    {
        $tipoDocumento = ["" => "Seleccionar"] + TipoDocumento::where("active", "1")
            ->where("estado",1)
            ->where("categoria",1)->pluck("descripcion", "id")->toArray();

        $proceso = RegistroProceso::join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
        ->where("procesos_candidato_req.id", $data->get("ref_id"))
        ->first();

        $documentos = new DocumentosVerificados();
        $documentos->fill($data->except('fecha_vencimiento', 'req_id') + [
            "user_id" => $this->user->id,
            "requerimiento_id" => $data->req_id,
            "gestion_hv" => "administrador",
            "candidato_id" => $proceso->candidato_id
        ]);
        if ($data->fecha_vencimiento != null && $data->fecha_vencimiento != '') {
            $documentos->fecha_vencimiento = $data->fecha_vencimiento;
        } else {
            $documentos->fecha_vencimiento = null;
        }
        $documentos->save();

        $tipo = TipoDocumento::find($data->get("tipo_documento_id"));

        if(is_null($tipo)){
            $tipo= $data['tipo'];
        }else{
           $tipo = $tipo->descripcion; 
        }

        if ($data->hasFile('archivo_documento')) {
            $imagen         = $data->file("archivo_documento");
            $extencion      = $imagen->getClientOriginalExtension();
            $name_documento = "documento_verificados_" . $documentos->id . "." . $extencion;

            $imagen->move("recursos_documentos_verificados", $name_documento);
            $documentos->nombre_archivo = $name_documento;
            $documentos->descripcion_archivo= $tipo;
            $documentos->save();
        }

        //GUARDAR_ RELACION DOCUMENTO REQUERIMIENTO
        $this->procesoRequerimiento($documentos->id, $data->get("ref_id"), "MODULO_DOCUMENTO", '', $data->resultado, $data->observacion);

        return response()->json(["success" => true]);
    }

    public function guardar_examen_medico(Request $data, Requests\DocumentoMedicoNuevoRequest $valida)
    {
        //Para Soluciones se puede dejar como esta en la instancia
        $sitio_modulo = SitioModulo::first();
        if($sitio_modulo->salud_ocupacional != "si") {
            
            $proceso = RegistroProceso::find($data->get("ref_id"));
            //$proceso->apto = ($data->resultado == 1)?1:0;
            //$proceso->observaciones = $data->observacion;
            //$proceso->usuario_terminacion = $this->user->id;
            //dd($proceso->apto);
            //$proceso->save();
            
            $ruta = route("admin.gestionar_documentos_medicos",[$data->get("ref_id")]);

            $tipo = TipoDocumento::find($data->get("tipo"));
            $candidato=DatosBasicos::where("user_id",$proceso->candidato_id)->first();

            $documentos = new Documentos();
            $documentos->fill($data->all() + ["tipo_documento_id"=>$tipo->id,"user_id" =>$candidato->user_id ,"requerimiento"=>$proceso->requerimiento_id,"numero_id"=>$candidato->numero_id,"gestiono"=>$this->user->id]);
            $documentos->save();

            if(is_null($tipo)){
                $tipo= $data['tipo'];
            }else{
                $tipo = $tipo->descripcion; 
            }

            if($data->hasFile('archivo_documento')){

                $imagen         = $data->file("archivo_documento");
                $extencion      = $imagen->getClientOriginalExtension();
                $name_documento = "documento_examenes_medicos_" . $documentos->id . "." . $extencion;

                $imagen->move("recursos_documentos_verificados", $name_documento);
                $documentos->nombre_archivo = $name_documento;
                $documentos->descripcion_archivo= $tipo;//"EXAMENES MÉDICOS";
                
                $documentos->save();
            }
            //GUARDAR_ RELACION DOCUMENTO REQUERIMIENTO
            $this->procesoRequerimiento($documentos->id, $data->get("ref_id"), "MODULO_DOCUMENTO");

            return response()->json(["success" => true,"ruta"=>$ruta]);

        } else {
            $orden = OrdenMedica::find($data->get("orden"));

            $tipo = TipoDocumento::find($data->get("tipo"));

            if($data->get("edit")){
                $orden->especificacion=null;
                $orden->save();

                $estado = new EstadosOrdenes();
                $estado->fill([
                    "orden_id" => $orden->id,
                    "estado_id" => 5,
                    "user_gestion"=>$this->user->id
                ]);

                $estado->save();
            }

            $req_can = ReqCandidato::find($orden->req_can_id);
            $candidato = DatosBasicos::where("user_id", $req_can->candidato_id)->first();

            $orden->fill([
                "resultado" => $data->get("resultado"),
                "observacion" => $data->get("observacion"),
                "seguimiento"=> $data->get("seguimiento")
            ]);
            $orden->tried+=1;
            $orden->save();

            $NuevoResultado = new OrdenMedicaResultado();
            $NuevoResultado->fill([
                "orden_id" => $orden->id,
                "resultado" => $data->get("resultado"),
                "fecha_realizacion"=>$data->get("fecha_realizacion"),
                "observacion" => $data->get("observacion"),
                "user_gestion" => $this->user->id
            ]);
            $NuevoResultado->save();
        
            $aptoproceso = RegistroProceso::where('requerimiento_candidato_id', $orden->req_can_id)
            ->where('proceso', 'ENVIO_EXAMENES')
            ->orderBy('created_at', 'DESC')
            ->first();

            //Apto con restricciones
            if($data->get("resultado") == 3 || $data->get("resultado") == 4){
                $estado = new EstadosOrdenes();
                $estado->fill([
                    "orden_id" => $orden->id,
                    "estado_id" => 2,
                    "user_gestion"=>$this->user->id
                ]);
                $estado->save();

                $aptoproceso->apto = null;
                $aptoproceso->observaciones = "Apto con restricciones";
                $aptoproceso->usuario_terminacion = $this->user->id;
                $aptoproceso->save();
            //No apto
            }elseif($data->get("resultado") == 9){
                $orden = OrdenMedica::find($orden->id);
                //$orden->resultado = 0;
                $orden->motivo_rechazo=$data->get("motivo");
                $orden->save();

                $estado = new EstadosOrdenes();
                $estado->fill([
                    "orden_id" => $orden->id,
                    "estado_id" => 4,
                    "user_gestion"=>$this->user->id
                ]);
                $estado->save();

                //Actualiza proceso
                $aptoproceso->apto = 0;
                $aptoproceso->observaciones = "No apto examenes médicos";
                $aptoproceso->usuario_terminacion = $this->user->id;
                $aptoproceso->motivo_rechazo_id = $data->get("motivo");

                $aptoproceso->save();
                //aplazado
            }elseif($data->get("resultado") == 2){
                $orden = OrdenMedica::find($orden->id);
                //$orden->resultado = 1;
                $orden->save();

                //Actualiza proceso
                $aptoproceso->apto = 3;
                $aptoproceso->observaciones = "Aplazado examenes médicos";
                $aptoproceso->usuario_terminacion = $this->user->id;
                $aptoproceso->save();

                $estado = new EstadosOrdenes();
                $estado->fill([
                    "orden_id" => $orden->id,
                    "estado_id" => 6,
                    "user_gestion"=>$this->user->id
                ]);
                $estado->save();
            //Apto
            }else{
                $orden = OrdenMedica::find($orden->id);
                //$orden->resultado = 1;
                $orden->save();

                //Actualiza proceso
                $aptoproceso->apto = 1;
                $aptoproceso->observaciones = "Apto examenes médicos";
                $aptoproceso->usuario_terminacion = $this->user->id;
                $aptoproceso->save();

                $estado = new EstadosOrdenes();
                $estado->fill([
                    "orden_id" => $orden->id,
                    "estado_id" => 3,
                    "user_gestion"=>$this->user->id
                ]);
                $estado->save();
            }

            $proceso = ReqCandidato::join("orden_medica", "orden_medica.req_can_id", "=", "requerimiento_cantidato.id")
            ->join("requerimientos","requerimientos.id","=","requerimiento_cantidato.requerimiento_id")
            ->join("cargos_especificos","cargos_especificos.id","=","requerimientos.cargo_especifico_id")
            ->join('negocio', 'requerimientos.negocio_id', '=', 'negocio.id')
            ->join('clientes', 'negocio.cliente_id', '=', 'clientes.id')
            ->where("orden_medica.id", $data->get("orden"))
            ->select("requerimiento_cantidato.candidato_id","cargos_especificos.descripcion as cargo","clientes.nombre as cliente")
            ->first();

            $documentos = new Documentos();
            $documentos->fill($data->all() + ["user_id" => $candidato->user_id, "numero_id" => $candidato->numero_id,"gestiono"=>$this->user->id]);
            $documentos->save();

            if ($data->hasFile('archivo_documento')) {
                $imagen         = $data->file("archivo_documento");
                $extencion      = $imagen->getClientOriginalExtension();

                $name_documento = "documento_verificados_" . $documentos->id . "." . $extencion;
                $imagen->move("recursos_documentos_verificados", $name_documento);

                $documentos->nombre_archivo = $name_documento;
                $orden->documento = $name_documento;

                $documentos->descripcion_archivo = "Resultado de examen medico";
                $documentos->requerimiento = $req_can->requerimiento_id;
                $documentos->tipo_documento_id = $tipo->id;

                $documentos->save();
                $orden->save();

                $NuevoResultado->documento=$name_documento;
                $NuevoResultado->save();

            }

            $this->procesoRequerimiento($documentos->id, $data->get("ref_id"), "MODULO_DOCUMENTO");

            if (session('url_previa') !== null) {
                $ruta = session('url_previa');
                session(["url_previa" => null]);
            } else {
                $ruta = route('admin.gestion_requerimiento',$req_can->requerimiento_id);
            }

            return response()->json(["success" => true,"ruta"=>$ruta]);
        }
        //GUARDAR_ RELACION DOCUMENTO REQUERIMIENTO
    }

    public function registra_proceso_entidad(Request $data)
    {
        $relacionProceso = new ProcesoRequerimiento();
        $relacionProceso->fill([
            "tipo_entidad"     => "MODULO_DOCUMENTO",
            "entidad_id"       => $data->doc_id,
            "requerimiento_id" => $data->req_id,
            "user_id"          => $this->user->id,
        ]);
        if ($data->has('resultado')) {
            $relacionProceso->resultado = $data->resultado;
        }
        if ($data->has('observacion')) {
            $relacionProceso->observacion = $data->observacion;
        }
        $relacionProceso->save();

        return response()->json(["rs" => $relacionProceso]);
    }

    public function eliminar_documento_admin(Request $data)
    {
        $eliminar = false;
        $carpeta = $data->carpeta;
        if($carpeta=="clientes"){
            $documento = DocumentoCliente::find($data->id_doc);
            $categoria=CategoriaDocumentoCliente::find($data->categoria);
            $cliente=$data->cliente;
            $ruta='documentos_clientes/'.$cliente.'/'.$categoria->descripcion.'/'.$documento->nombre_archivo;
        }
        else{
          $documento = Documentos::find($data->id_doc);  
        }
        
        if ($documento != null) {
            $documento->active=0;
            $documento->eliminado=$this->user->id;
            $documento->fecha_eliminacion=date("Y-m-d H:i:s");
            $documento->save();
            /*if ($carpeta == 'seleccion' && file_exists('recursos_documentos/'.$documento->nombre_archivo)) {
                //unlink("recursos_documentos/" . $documento->nombre_archivo);
                $eliminar = $documento->delete();
            } elseif ($carpeta == 'contratacion' && file_exists('recursos_documentos_verificados/'.$documento->nombre_archivo)) {
                unlink("recursos_documentos_verificados/" . $documento->nombre_archivo);
                $eliminar = $documento->delete();
            }
             elseif ($carpeta == 'clientes' && file_exists($ruta)) {
                
                unlink($ruta);
                $eliminar = $documento->delete();
            }*/

        }

        return response()->json(["id" => $data->id_doc, "eliminar" => $documento->id]);
    }

    public function viewDocument($slug)
    {
        $resource = decrypt($slug);
        $param = explode("|",$resource);

        if(is_null($param[2]) || $param[2]==''){
            $descripcion="DOCUMENTO";
        }
        else{
            $tipo = TipoDocumento::find($param[2]);
            $descripcion=$tipo->descripcion;
        }
        
        $name_extention = explode(".",$param[1]);
        
        if(file_exists($param[0].$param[1])) {
            switch ($name_extention[1]) {
                case 'jpg':
                case 'jpeg':
                case 'png':
                    $content_type='image/'.$name_extention[1];
                    break;
                case 'doc':
                case 'docx':
                    $content_type='application/'.$name_extention[1];
                    break;
                case 'webm':
                case 'mp4':
                    $content_type='video/'.$name_extention[1];
                    $descripcion="VIDEO";
                    break;
                default:
                    $content_type='application/pdf';
                    break;
            }
            //return response()->download(public_path($param[0].$param[1]),$tipo->descripcion.".".$name_extention[1]);
            return response()->make(file_get_contents(public_path($param[0].$param[1]),$descripcion.".".$name_extention[1]), 200, [
            'Content-Type' => $content_type,
            'Content-Disposition' => 'inline; filename="'.$descripcion.".".$name_extention[1].'"'
        ]);
        }else {
            Log::alert("Recurso no disponible:".$param[0].$param[1]);
            abort(404);
        }
    }
}
