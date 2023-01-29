<?php

namespace App\Listeners;

use App\Events\CloseSelectionFolderEvent;
use App\Models\ReqCandidato;
use App\Models\Requerimiento;
use App\Models\CarpetaContratacion;
use App\Models\DocumentoCarpetaContratacion;
use App\Models\TipoDocumento;
use App\Models\Sitio;
use DB;

class CloseSelectionFolderListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AuditoriaEvent  $event
     * @return void
     */
    public function handle(CloseSelectionFolderEvent $event)
    {
        $req_can=$event->req_can;
        $candidato=$event->req_can->candidato_id;
        $requerimiento = Requerimiento::find($req_can->requerimiento_id);

        switch ($event->folder) {
            case '1':

                 $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
                    ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
                    ->leftjoin("users", "users.id", "=", "documentos.user_id")
                    ->where("categoria", 1)
                    ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
                    ->select(
                        "tipos_documentos.id as id",
                        "tipos_documentos.descripcion as descripcion",
                        DB::raw("(select documentos.nombre_archivo from documentos where user_id=$req_can->candidato_id and documentos.tipo_documento_id=tipos_documentos.id order by documentos.id desc limit 1) as nombre")
                    )
                    ->orderBy("id")
                    ->groupBy("id")
                    ->get();

                    foreach ($tipo_documento as $key => &$tipo_doc) {
                        $tipo_doc->documentos = DB::table('documentos')->select('nombre_archivo as nombre', 'id as id_documento')->where('user_id', $candidato)->where('tipo_documento_id', $tipo_doc->id)->latest('id')->limit(5)->get();
                    }
                    unset($tipo_doc);

                    $req_can->cerrar_carpetas_asistente(1);
                break;
            case '2':

                $tipo_documento = TipoDocumento::join("cargo_documento", "cargo_documento.tipo_documento_id", "=", "tipos_documentos.id")
                    ->leftjoin("documentos", "documentos.tipo_documento_id", "=", "tipos_documentos.id")
                    ->where("categoria", 2)
                    ->where("tipos_documentos.estado", 1)
                    ->where("cargo_documento.cargo_especifico_id", $requerimiento->cargo_especifico_id)
                    ->select("tipos_documentos.id as id","tipos_documentos.descripcion as descripcion",
                        DB::raw("(select documentos.gestiono from documentos where user_id=$candidato and documentos.tipo_documento_id=tipos_documentos.id and documentos.requerimiento=$req_can->requerimiento_id order by documentos.id desc limit 1) as gestiono"),
                        DB::raw("(select d.created_at from documentos as d where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req_can->requerimiento_id order by d.id desc limit 1) as fecha_carga"),
                        DB::raw("(select u.name from documentos d left join users u on d.gestiono=u.id where d.user_id=$candidato and d.tipo_documento_id=tipos_documentos.id and d.requerimiento=$req_can->requerimiento_id order by d.id desc limit 1) as usuario_gestiono")
                                    )
                    ->orderBy("id")
                    ->groupBy("id")
                    ->get();

                    foreach ($tipo_documento as $key => &$tipo_doc) {
                        $tipo_doc->documentos = DB::table('documentos')->select('nombre_archivo as nombre', 'id as id_documento')->where('user_id', $candidato)->where('tipo_documento_id', $tipo_doc->id)->where('requerimiento', $requerimiento->id)->latest('id')->limit(5)->get();
                    }
                    unset($tipo_doc);


                    $req_can->cerrar_carpetas_asistente(2);
                break;
            default:
                # code...
                break;
        }

       

        //crear carpeta

        $carpeta=new CarpetaContratacion();
        $carpeta->categoria_id=$event->folder;
        $carpeta->user_gestion=$req_can->candidato_id;
        $carpeta->req_can_id=$req_can->id;
        $carpeta->save();

        //agregar documentos en carpeta

        foreach($tipo_documento as $tipo){
            
            if(count($tipo->documentos)>0){
               
                foreach($tipo->documentos as $doc){
                    $documento = new DocumentoCarpetaContratacion();
                    $documento->tipo_documento_id = $tipo->id;
                    $documento->carpeta_id = $carpeta->id;
                    $documento->nombre_documento = $doc->nombre;
                    $documento->save();
                }
            }
        }
        

       
        
    }

}
