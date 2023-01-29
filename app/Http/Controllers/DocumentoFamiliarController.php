<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\DocumentoFamiliar;
use App\Models\ReqCandidato;
use App\Models\TipoDocumento;
use App\Models\User;
use App\Models\DatosBasicos;
use Illuminate\Support\Facades\Mail;
//Helper
use triPostmaster;

class DocumentoFamiliarController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $success = false;
        $mensaje = "";
        $usuario_id = $this->user->id;

        DB::transaction(function () use($request, &$success, &$mensaje, $usuario_id) {
            //Guardamos el archivo en un directorio
            if ($request->hasFile('documento') && $request->tipo_documento_id != "" && $request->grupo_familiar_id != "") {
                $documento = $request->file("documento");
                $extencion = $documento->getClientOriginalExtension();

                if ($extencion == 'jpg' || $extencion == 'png' || $extencion == 'jpeg' || $extencion == 'pdf' || $extencion == 'doc' || $extencion == 'docx') {
                    $documentoFamiliar = new DocumentoFamiliar();

                    $documentoFamiliar->usuario_gestiono = $usuario_id;
                    $documentoFamiliar->tipo_documento_id = $request->tipo_documento_id;
                    $documentoFamiliar->grupo_familiar_id = $request->grupo_familiar_id;
                    $documentoFamiliar->descripcion = $request->descripcion;
                    $documentoFamiliar->nombre = $request->get("documento");
                    $documentoFamiliar->save();

                    $name_documento = "documento_familiar_" . $documentoFamiliar->id . "." . $extencion;
                    $documento->move("documentos_grupo_familiar", $name_documento);
                    $documentoFamiliar->nombre = $name_documento;
                    $documentoFamiliar->save();

                    $mensaje = "Documento guardado.";

                    $success = true;
                }else{
                    $mensaje = "Documento no soportado.";
                }

                if ($success) {
                    // Notificar de documento cargado
                    // asi porque si lo carga desde admin viene el cand_id y si no entonces es el cand_id logueado
                    $cand_id = $request->has("cand_id") ? $request->cand_id : $usuario_id;

                    if($request->has("req_id")) {
                        $req_id = $request->req_id;
                    }else{
                        $req_cand = ReqCandidato::join("procesos_candidato_req", "procesos_candidato_req.requerimiento_candidato_id", "=", "requerimiento_cantidato.id")
                        ->where("requerimiento_cantidato.id", DB::raw("(select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.candidato_id={$cand_id})"))
                        ->whereNotIn("requerimiento_cantidato.estado_candidato", [23, 14])
                        ->where("procesos_candidato_req.proceso", "PRE_CONTRATAR")
                        ->select("requerimiento_cantidato.requerimiento_id as req_id")
                        ->first();

                        $req_id = isset($req_cand) ? $req_cand->req_id : null;
                    }

                    if (!empty($req_id)) {
                        $datosU = DatosBasicos::where('user_id', $cand_id )->first();

                        $desc = TipoDocumento::where("id", $request->tipo_documento_id)->pluck('descripcion')->first();

                        $users = emails_codigo_rol_cliente_agencia($req_id, ['CONT', 'AFL']);

                        foreach ($users as $usuario) {
                            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
                            $mailConfiguration = 1; //Id de la configuración
                            $mailTitle = "Notificación Nuevo Documento Cargado"; //Titulo o tema del correo

                            $nombre_completo = $datosU->nombres." ".$datosU->primer_apellido." ".$datosU->segundo_apellido;

                            //Cuerpo con html y comillas dobles para las variables
                            $mailBody = "
                                Hola {$usuario->name}: 
                                <br/><br/>
                                Te informamos que se ha cargado el documento {$desc} a la carpeta de Beneficiarios del candidato {$nombre_completo} en el requerimiento {$req_id} del cliente {$usuario->cliente_nombre}.

                                <br/><br/>

                                Para visualizar el documento haz clic en el botón “Visualizar documento”.
                            ";
                            
                            //Arreglo para el botón
                            $mailButton = ['buttonText' => 'Visualizar documento', 'buttonRoute' => route("admin.documentos_beneficiarios", ["candidato" => $datosU->user_id, "req" => $req_id])];

                            $mailUser = $usuario->id; // Id del usuario al que se le envía el correo

                            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

                            Mail::send($triEmail->view, ['data' => $triEmail->data], function($message) use($datosU, $usuario) {
                                $message->to([$usuario->email], "T3RS")
                                ->subject("Nuevo documento cargado al candidato ".$datosU->nombres)
                                ->getHeaders()
                                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
                            });
                        }
                    }
                }
            }
        });

        return response()->json(["success" => $success, "mensaje" => $mensaje]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $documento = DocumentoFamiliar::find($request->id);

        return response()->json(["documento" => $documento]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $documento = DocumentoFamiliar::find($request->id);

        return response()->json(["success" => true, "documento" => $documento]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $documentoFamiliar = DocumentoFamiliar::find($request->id);
        $documentoFamiliar->usuario_gestiono = $this->user->id;
        $documentoFamiliar->tipo_documento_id = $request->tipo_documento_id;
        $documentoFamiliar->grupo_familiar_id = $request->grupo_familiar_id;
        $documentoFamiliar->descripcion = $request->descripcion;
        $documentoFamiliar->save();

        if ($request->hasFile('documento')) {
            $archivo_documento = $request->file("documento");
            $extension = $archivo_documento->getClientOriginalExtension();

            if ($extension == "jpg" || $extension == "png" || $extension == "jpeg" || $extension == "pdf" || $extension == "PDF") {
                // Eliminar archivo
                if (file_exists("documentos_grupo_familiar/" . $documentoFamiliar->nombre) && $documentoFamiliar->nombre != "") {
                    unlink("documentos_grupo_familiar/" . $documentoFamiliar->nombre);
                }

                $name_documento = "documento_familiar_" . $documentoFamiliar->id . "." . $extension;
                $archivo_documento->move("documentos_grupo_familiar", $name_documento);

                $documentoFamiliar->nombre = $name_documento; // Actualizar nombre del archivo al registro
                $documentoFamiliar->save();

                // $documento = DocumentoFamiliar::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
                // ->where("documentos.id", $documentoFamiliar->id)
                // ->select("documentos.*", "tipos_documentos.descripcion as tipo_doc")
                // ->first();

                return response()->json(["success" => true, 'mensaje' => 'Documento actualizado.']);
            }else {
                $mensaje = "Documento no soportado.";

                return response()->json(["mensaje" => $mensaje, "success" => false]);
            }
        }else {
            return response()->json(["success" => true, 'mensaje' => 'Documento actualizado.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //Consultamos el nombre del archivo para delete.
        $documento = DocumentoFamiliar::find($request->id);
        $success = false;

        $documento->active=0;
        $documento->eliminado=$this->user->id;
        $documento->fecha_eliminacion=date("Y-m-d H:i:s");
        $documento->save();

        $success = true;
        //Eliminar el archivo en el directorio
        /*if (!is_null($documento)) {
            unlink("documentos_grupo_familiar/" . $documento->nombre);

            //Eliminar el registro
            $documento->delete();

            $success = true;
        }*/

        return response()->json(["success" => $success, "id" => $request->id]);
    }
}
