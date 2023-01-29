<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\TipoDocumento;

class DocumentoNuevoContratacion extends Request {

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
            "archivo_documento" => "required|mimes:jpg,jpeg,png,pdf,PDF,gif",
            "descripcion_archivo" => "required",];
    }
    public function messages() {
        return[
            "archivo_documento.mimes"=>"Tipo de archivo no soportado"
        ];
    }
    /*public function response(array $errors) {
        $campos = $this->all();

        //$tipoDocumento = ["" => "Seleccionar"] + TipoDocumento::where("active", "1")->pluck("descripcion", "id")->toArray();

        return response()->json(["success" => false, "view" => view("admin.contratacion.candidato.modal.nuevo_documento", compact("campos"))->withErrors($errors)->render()]);
    }
    */

}
