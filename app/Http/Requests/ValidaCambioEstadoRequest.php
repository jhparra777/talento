<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\MotivosRechazos;

class ValidaCambioEstadoRequest extends Request {

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
            "estado_ref" => "required",
            "motivo_rechazo_id" => "required_if:estado_ref,2",
            "observaciones" => "required_if:estado_ref,3",
        ];
    }

    public function response(array $errors) {
        $motivos = ["" => "Seleccionar"] + MotivosRechazos::pluck("descripcion", "id")->toArray();
        $campos = $this->all();
        $datos = $this;
        return response()->json(["success" => false, "view" => view("admin.reclutamiento.modal.cambiar_estado", compact("campos","motivos","datos"))->withErrors($errors)->render()]);
    }
    public function messages() {
        return [
            "motivo_rechazo_id.required_if"=>"Debe seleccionar un motivo de rechazo.",
            "observaciones.required_if"=>"Debe digitar una observaciones."
        ];
    }

}
