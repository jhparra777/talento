<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NuevoClienteRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
          "nombre"    => "required",
          "nit"       => "required|unique:clientes,nit",
          "direccion" => "required",
          "telefono"  => "required|numeric",
          "correo"    => "required|email",
          //"correo"     => "required|email|unique:clientes,correo",
            //"pag_web"=>"url",
          "fax"       => "",
          "contacto"  => "required",
        ];
    }

    public function messages()
    {
      
       if(route("home") == "https://gpc.t3rsc.co"){

        return[
         "ciudad_id.required" => "Debe seleccionar una ciudad",
         "pais_id_u.required" => "Debe seleccionar una ciudad",
         "nit.required" => "El RUC es obligatorio",
        ];

       }

        return[
          "ciudad_id.required" => "Debe seleccionar una ciudad",
          "pais_id_u.required" => "Debe seleccionar una ciudad",
        ];
    }
}
