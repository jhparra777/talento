<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AdminNuevoSoporteAprobacionRequest extends Request {

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
            "resultado" => "required",
            "observacion" => "required",
            "archivo_soporte" => "required|mimes:jpg,jpeg,png,pdf,gif"
        ];
    }
    public function messages() {
        return[
            "archivo_soporte.mimes"=>"Tipo de archivo incorrecto"
        ];
    }
    public function response(array $errors) {
        $campos = $this->all();
        $tipo = config('conf_aplicacion.C_SOPORTE_APROBACION_CLIENTE');
        $orden = $campos->ref_id;

        return response()->json(["success" => false, "view" => view("admin.reclutamiento.modal.nuevo_soporte_aprobacion", compact("tipo", "orden"))->withErrors($errors)->render()]);
    }

}