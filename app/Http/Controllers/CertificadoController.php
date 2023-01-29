<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudios;
use App\Models\Experiencias;
use App\Models\Documentos;
use App\Models\TipoDocumento;
use App\Models\Certificado;
use App\Models\NivelEstudios;
use DB;

class CertificadoController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function certificados_estudios(Request $request)
    {   
        $estudio = Estudios::find($request->id);
        
        $certificados = $estudio->certificados;
        $estudio_id = $estudio->id;

        return view("cv.modal.certificados_estudios", compact("certificados", "estudio_id"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function certificados_experiencias(Request $request)
    {

        $experiencia = Experiencias::find($request->id);

        $certificados = $experiencia->certificados;

        $experiencia_id = $experiencia->id;

        return view("cv.modal.certificados_experiencias", compact("certificados", "experiencia_id"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar_certificado_estudio(Request $request)
    {
        if ($request->hasFile("certificado")) {

            $certificado = $request->file("certificado");

            $extencion = $certificado->getClientOriginalExtension();

            if ($extencion == 'jpg' || $extencion == 'png' || $extencion == 'jpeg' || $extencion == 'pdf') {

                DB::transaction(function () use ($request, $certificado, $extencion) {

                    //buscamos el tipo de documento
                    //CL hace referencia al tipo de documento CERTIFICADO DE ESTUDIO
                    $tipo_documento = TipoDocumento::where('cod_tipo_doc', 'CE')->first();

                    $estudio = Estudios::find($request->estudio_id);

                    //buscamos el nivel de estudio para guardar la descripcion en la descripcion 
                    //del registro de documentos
                    $nivel_estudio = NivelEstudios::where('id', $estudio->nivel_estudio_id)->first();
                    //guardamos la info en la base de datos
                    $documento = new Documentos();

                    $documento->fill([
                        "user_id" => $this->user->id,
                        "numero_id" => $this->user->getCedula()->numero_id,
                        "tipo_documento_id" => $tipo_documento->id,
                        "descripcion_archivo" => $nivel_estudio->descripcion
                    ]);

                    $documento->save();

                    //guardamos el documento en fisico
                    $name_documento = "documento_" . $documento->id . "." . $extencion;
                    $certificado->move("recursos_documentos", $name_documento);
                    $documento->nombre_archivo = $name_documento;
                    $documento->nombre_archivo_real = $certificado->getClientOriginalName();
                    
                    $documento->gestiono = $this->user->id;
                    $documento->save();

                    //creamos el registro en la tabla relacional entre estudios y documentos
                    //guardamos el certificado con su relacion
                    $certificado_est = new Certificado(["documento_id" => $documento->id]);
                    $estudio->certificados()->save($certificado_est);
                });

                /*$fileName  = "certificado_estudio_" . $certificado_estudio->id . ".$extencion";
                    
                //ELIMINAR Certificado
                if($certificado_estudio->nombre_archivo != "" && file_exists("recursos_datosbasicos/" . $certificado_estudio->nombre_archivo)) {
                    unlink("recursos_datosbasicos/" . $certificado_estudio->nombre_archivo);
                }
                    
                $certificado->move("recursos_datosbasicos", $fileName);
                $certificado_estudio->nombre_archivo = $fileName;
                $certificado_estudio->save();
                */
            }
            

            return response()->json(["success" => true]);
        }else{

            return response()->json(["success" => false]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar_certificado_experiencia(Request $request)
    {
        if ($request->hasFile("certificado")) {

            $certificado = $request->file("certificado");

            $extencion = $certificado->getClientOriginalExtension();

            if ($extencion == 'jpg' || $extencion == 'png' || $extencion == 'jpeg' || $extencion == 'pdf') {

                DB::transaction(function () use ($request, $certificado, $extencion) {

                    //buscamos el tipo de documento
                    //CL hace referencia al tipo de documento CERTIFICADO LABORAL
                    $tipo_documento = TipoDocumento::where('cod_tipo_doc', 'CL')->first();

                    $experiencia = Experiencias::find($request->experiencia_id);

                    //guardamos la info en la base de datos
                    $documento = new Documentos();

                    $documento->fill([
                        "user_id" => $this->user->id,
                        "numero_id" => $this->user->getCedula()->numero_id,
                        "tipo_documento_id" => $tipo_documento->id,
                        "descripcion_archivo" => $experiencia->nombre_empresa
                    ]);

                    $documento->save();

                    //guardamos el documento en fisico
                    $name_documento = "documento_" . $documento->id . "." . $extencion;
                    $certificado->move("recursos_documentos", $name_documento);
                    $documento->nombre_archivo = $name_documento;
                    $documento->nombre_archivo_real = $certificado->getClientOriginalName();
                    
                    $documento->gestiono = $this->user->id;
                    $documento->save();

                    //creamos el registro en la tabla relacional entre experiencia y documentos
                    
                    //guardamos el certificado con su relacion
                    $certificado_exp = new Certificado(["documento_id" => $documento->id]);
                    $experiencia->certificados()->save($certificado_exp);
                });

                /*$fileName  = "certificado_experiencia_" . $certificado_experiencia->id . ".$extencion";
                    
                //ELIMINAR Certificado
                if($certificado_experiencia->nombre_archivo != "" && file_exists("recursos_datosbasicos/" . $certificado_experiencia->nombre_archivo)) {
                    unlink("recursos_datosbasicos/" . $certificado_experiencia->nombre_archivo);
                }
                    
                $certificado->move("recursos_datosbasicos", $fileName);
                $certificado_experiencia->nombre_archivo = $fileName;
                $certificado_experiencia->save();
                */
            }
            

            return response()->json(["success" => true]);
        }else{

            return response()->json(["success" => false]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {   
        $certificado = Certificado::findOrFail($request->id);

        //$ruta = route('view_document_url', encrypt('recursos_datosbasicos/'.'|'.$certificado->nombre_archivo));
        $ruta = route('view_document_url', encrypt('recursos_documentos/'.'|'.$certificado->documento->nombre_archivo.'|'.$certificado->documento->tipo_documento_id));

        return response()->json(["ruta" => $ruta]);
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
        $certificado = Certificado::findOrFail($request->get("id"));

        //Eliminar el archivo en el directorio
        //unlink("recursos_datosbasicos/" . $certificado->nombre_archivo);

        //Eliminar el archivo en el directorio
        unlink("recursos_documentos/" . $certificado->documento->nombre_archivo);

        //Eliminar el registro
        $certificado->documento->delete();
        $certificado->delete();

        return response()->json(["success" => true, "id" => $request->get("id")]);
    }
}
