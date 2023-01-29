<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\TipoDocumento;

class AdminDocumentoNuevoRequest extends Request {

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
        return [
            "tipo_documento_id" => "required",
            "archivo_documento" => "required|mimes:jpg,jpeg,png,pdf,gif",
            "resultado" => "required",
            "observacion" => "required"
            //"fecha_vencimiento" => "required_if:documento_vence,1" 
        ];
    }
    public function messages() {
        return[
            "tipo_documento_id.required" => "El campo tipo documento es obligatorio",
            "observacion.required" => "El campo observación es obligatorio",
            "archivo_documento.mimes"=>"Tipo de archivo incorrecto",
            "fecha_vencimiento.required_if"=>"Debe seleccionar la fecha vencimiento."
        ];
    }
    public function response(array $errors) {
        $campos = $this->all();
        $orden = $this->ref_id;
        
        $tipoDocumento = ["" => "Seleccionar"] + TipoDocumento::where("active", "1")
            ->where("estado",1)
            ->where("categoria",1)
            ->pluck("descripcion", "id")
            ->toArray();

        return response()->json(["success" => false, "view" => view("admin.reclutamiento.modal.nuevo_documento", compact("campos", "tipoDocumento", "orden"))->withErrors($errors)->render()]);
    }

}