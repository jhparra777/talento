<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CargosGenericosNuevoRequest extends Request {

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
            'descripcion' => 'required',
            'estado' => 'required',
            'tipo_cargo_id' => 'required',
        ];
    }

}
