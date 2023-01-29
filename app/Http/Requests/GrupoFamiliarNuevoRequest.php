<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\TipoDocumento;
use App\Models\Escolaridad;
use App\Models\Genero;
USE App\Models\Profesiones;
use App\Models\Parentesco;
use Illuminate\Support\Facades\Auth;
use App\Models\GrupoFamilia;

class GrupoFamiliarNuevoRequest extends Request {

    public $tipoDocumento = ["" => "Seleccionar"];
    public $escolaridad = ["" => "Seleccionar"];
    public $parentesco = ["" => "Seleccionar"];
    public $genero = ["" => "Seleccionar"];
    public $profesion = ["" => "Seleccionar"];

    public function __construct() {

       $this->tipoDocumento += TipoDocumento::where("active", 1)->pluck("descripcion", "id")->toArray();
       $this->escolaridad += Escolaridad::where("active", 1)->pluck("descripcion", "id")->toArray();
       $this->parentesco += Parentesco::where("active", 1)->pluck("descripcion", "id")->toArray();
       $this->genero += Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
       $this->profesion += Profesiones::where("active", 1)->pluck("descripcion", "id")->toArray();

    }

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

      if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co" || route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co" || route('home') == "https://vym.t3rsc.co" || route('home') == "https://listos.t3rsc.co" ){

         return [
          //"ciudad_autocomplete2" => "required",
           "nombres" => "required",
           "primer_apellido" => "required",
                // "escolaridad_id" => "required",
           "parentesco_id" => "required",
                //"genero" => "required",
                //"fecha_nacimiento" => "required",
                //"profesion_id" => "required"
         ];  
      }

        if(route('home') == "https://gpc.t3rsc.co"){

            return [
              "nombres"           => "required",
              "primer_apellido"   => "required",
              "parentesco_id"     => "required",
              "ocupacion"         => "required",
              "rango_edad"        => "required"
            ];
        }

        return [
          // "tipo_documento" => "required",
           "documento_identidad" => "unique:grupos_familiares,documento_identidad|required|numeric", 
            //|unique:grupos_familiares,documento_identidad
          // "ciudad_autocomplete2" => "required",
           "nombres" => "required",
           "primer_apellido" => "required",
          // "escolaridad_id" => "required",
           "parentesco_id" => "required",
           "genero" => "required",
          // "fecha_nacimiento" => "required",
           "profesion_id" => "required"
           //"codigo_ciudad_expedicion" => "required"
        ];
    }

    public function messages()
    {
        return [
           "ciudad_autocomplete2.required"              => "Este campo es obligatorio",
           "escolaridad_id.required"                    => "El campo nivel de estudio es obligatorio",
           "parentesco_id.required"                     => "El campo parentesco de estudio es obligatorio",
           "cargo_desempenado_autocomplete.required"    => "El campo profesion  es obligatorio",
        ];
    }

}
