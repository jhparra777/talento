<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NuevoUserEmpresaRequest extends Request {

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
            "primer_nombre" => "required",
            "username"=> "required_without_all:numero_id,email",
            "numero_id"=> "required_without_all:username,email|unique:users,numero_id",
            'email' => "email|max:255|required_without_all:username,numero_id|unique:users,email",
            'password' => "required|min:6",
            'pais_id' => "required"
        ];
    }

    public function messages() {
        return [
            "name.required" => "Campo obligatorio",
            "pais_id.required" => "Debe digitar una ciudad de trabajo.",
            "email.unique" => "Este email ya se encuentra registrado.",
            "numero_id.unique" => "Este numero ya se encuentra registrado."
        ];
    }

}
