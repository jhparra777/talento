<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\TipoDocumento;
use App\Models\SitioModulo;
use Illuminate\Support\Facades\DB;

class DocumentoMedicoNuevoRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $sitio_modulo = SitioModulo::first();

        $rules = [
            "tipo" => "required",
            "archivo_documento" => "required",
            "archivo_documento.*" => "mimes:jpg,jpeg,png,pdf,gif",
            "fecha_realizacion" => "required",
            "observacion" => "required",
            "resultado" => "required",
        ];

        if($sitio_modulo->salud_ocupacional == 'si') {
            $rules += [
                "motivo" => "required_if:resultado,9",
            ];
        }

        return $rules;
    }

    public function messages() {
        $sitio_modulo = SitioModulo::first();

        $messages = [
            "tipo.required" => "Debe seleccionar el tipo de documento",
            "archivo_documento.required"=>"Debe seleccionar un archivo",
            "archivo_documento.mimes"=>"Tipo de archivo incorrecto",
            "fecha_realizacion.required" => "Debe seleccionar la fecha de realización",
            "observacion.required" => "Debe ingresar una observación",
            "resultado.required" => "Debe seleccionar el resultado"
        ];

        if($sitio_modulo->salud_ocupacional == 'si') {
            $messages += [
                "motivo.required_if" => "Debe seleccionar un motivo"
            ];
        }

        return $messages;
    }

    public function response(array $errors) {
        $orden = $this->ref_id;

        $sitio_modulo = SitioModulo::first();

        if($sitio_modulo->salud_ocupacional != 'si') {
            $tipo = "";

            $resultados = [""=>"seleccione"]+DB::table("tipo_resultado_examen_medico")->pluck("descripcion","id");

            $tipoDocumento = ["" => "Seleccionar"] + TipoDocumento::where("active", "1")
            ->where("categoria", "3")
            ->whereRaw("codigo REGEXP '^[0-9]+$'")
            ->pluck("descripcion", "id")
            ->toArray();

            return response()->json(["success" => false, "view" => view("admin.reclutamiento.modal.nuevo_examen_medico", compact("tipoDocumento", "tipo", "orden", "resultados", "sitio_modulo"))->withErrors($errors)->render()]);
        } else {
            $tipo = "";
            $tipoDocumento = ["" => "Seleccionar", "9" => "EXAMEN MÉDICO"];
            //$tipo = "EXAMEN MEDICOS";
            $f = TipoDocumento::where("active", "1")->where("descripcion", "EXAMENES MÉDICOS")->first();
            $motivos_no_continua =[""=>"Seleccionar"]+DB::table('motivo_rechazo_examen_medico')->pluck("descripcion","id");

            $tipo = $f->id;     
            $edit = $this->edit;
            $resultados = [""=>"seleccione"]+DB::table("tipo_resultado_examen_medico")->pluck("descripcion","id");

            return response()->json(["success" => false,"view" => view("admin.reclutamiento.modal.nuevo_examen_medico", compact("tipoDocumento", "tipo", "orden","motivos_no_continua","edit","resultados", "sitio_modulo"))->withErrors($errors)->render()]);
        }
    }

}
