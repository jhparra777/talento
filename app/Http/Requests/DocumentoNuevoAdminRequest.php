<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\TipoDocumento;

class DocumentoNuevoAdminRequest extends Request {

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
            "archivo_documento" => "required",
            "archivo_documento.*" => "mimes:jpg,jpeg,png,pdf,gif",
            "descripcion_archivo" => "required",];
    }
    public function messages() {
        return[
            "archivo_documento.required"=>"Debe seleccionar al menos 1 archivo",
            "archivo_documento.mimes"=>"Tipo de archivo incorrecto"
        ];
    }
    public function response(array $errors) {
        return response()->json(["success" => false]);
    }

}
