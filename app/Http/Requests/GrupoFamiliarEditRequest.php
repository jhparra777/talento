<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Escolaridad;
use App\Models\Genero;
use App\Models\Parentesco;
use App\Models\Profesiones;
use App\Models\TipoDocumento;
use Illuminate\Support\Facades\Auth;

class GrupoFamiliarEditRequest extends Request
{

    public $tipoDocumento = ["" => "Seleccionar"];
    public $escolaridad   = ["" => "Seleccionar"];
    public $parentesco    = ["" => "Seleccionar"];
    public $genero        = ["" => "Seleccionar"];
    public $profesion     = ["" => "Seleccionar"];

    public function __construct()
    {

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
            "tipo_documento"           => "required",
            "documento_identidad"      => "required|numeric",
            "ciudad_autocomplete"      => "required",
            "nombres"                  => "required",
            "primer_apellido"          => "required",
            // "segundo_apellido" => "required",

            "parentesco_id"            => "required",
            "genero"                   => "required",
            "fecha_nacimiento"         => "required",
            "codigo_ciudad_nacimiento" => "required",

            "codigo_ciudad_expedicion" => "required",
        ];
    }

}
