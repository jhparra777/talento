<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
class FacturacionRequest extends Request {

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
            "req_id"                        => "required",
            "factura_entrega_terna"         => "required_if:recaudo_centrega_terna,0,1|required_if:factura_cierre_proceso,0,1",
            "recaudo_centrega_terna"        => "required_if:factura_cierre_proceso,0,1",
        ];
    }

    public function messages() {
        return [
            "recaudo_centrega_terna.required_if"=>"Debes seleccionar Recaudo entrega terna.",
            "factura_entrega_terna.required_if"=>"Debes seleccionar Factura entrega terna."
        ];
    }

}
