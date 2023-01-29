<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class DocumentoNuevoRequest extends Request {

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
            "archivo_documento" => "required|mimes:jpg,jpeg,png,pdf|max:5120",
            "descripcion_archivo" => "required"
        ];
    }

    public function messages() {
        return[
            "tipo_documento_id.required" => "El tipo de documento es requerido",
            "archivo_documento.required" => "Debe seleccionar al menos 1 archivo",
            "archivo_documento.max" => "El archivo no debe exceder un peso límite de 5MB",
            "archivo_documento.mimes" => "El formato del archivo no es válido",
            "descripcion_archivo.required" => "La descripción del archivo es requerida"
        ];
    }
}
