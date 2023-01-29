<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\AspiracionSalarial;
use App\Models\CategoriaLicencias;
use App\Models\ClaseLibreta;
use App\Models\DatosBasicos;
use App\Models\EntidadesAfp;
use App\Models\EntidadesEps;
use App\Models\EstadoCivil;
use App\Models\Genero;
use App\Models\Pais;
use App\Models\TipoIdentificacion;
use App\Models\TipoVehiculo;

class AdminDatosBasicosRequest extends Request
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
            "tipo_id"             => "required",
            "numero_id"           => "required|numeric",
            "fecha_expedicion"    => "required|date",
            "nombres"             => "required",
            "primer_apellido"     => "required",
            // "segundo_apellido"=>"required",
            "fecha_nacimiento"    => "required|date",
            "ciudad_nacimiento"   => "required",
            "genero"              => "required",
            "estado_civil"        => "required",
            "password"        => "required",
            // "telefono_fijo"=>"required|numeric",
            "telefono_movil"      => "numeric",
            "aspiracion_salarial" => "required",
            "ciudad_id"           => "required",
            "telefono_movil"      => "numeric",
            //"tipo_vehiculo"       => "required_if:tiene_vehiculo,1",
           // "numero_licencia"     => "required_if:tiene_vehiculo,1",
           // "categoria_licencia"  => "required_if:tiene_vehiculo,1",
            "ciudad_residencia"   => "required",
            "email"               => "required|email",
        ];
    }

    public function messages()
    {
        return [

            "fecha_expedicion.required"      => "Debe seleccionar una fecha de expedicion",
            "nombre.required"                => "Debe digitar el nombre",
            "primer_apellido.required"       => "Debe digitar el primer apellido",
            "segundo_apellido.required"      => "Debe digitar el segundo apellido",
            "fecha_nacimiento.required"      => "Debe seleccionar una fecha de nacimiento",
            "ciudad_nacimiento.required"     => "Debe seleccionar un lugar de nacimiento",
            "genero.required"                => "Debe seleccionar un genero",
            "estado_civil.required"          => "Debe seleccionar un estado civil",
            "telefono_fijo.required"         => "Debe digitar un teléfono",
            "aspiracion_salarial.required"   => "Debe seleccionar una aspiracion salarial",
            "ciudad_id.required"             => "Debe seleccionar la ciudad de expedicion de la cédula",
            "ciudad_residencia.required"     => "Debe seleccionar la ciudad de residencia",
            //"tipo_vehiculo.required_if"      => "Debe seleccionar tipo de vehiculo",
            //"numero_licencia.required_if"    => "Campo obligatorio.",
            //"categoria_licencia.required_if" => "Debe seleccionar una categoria.",
        ];
    }

    public function response(array $errors)
    {
        $datos_basicos      = DatosBasicos::where("user_id", $this->user_id)->first();
        $tipos_documentos   = ["" => "Seleccionar"] + TipoIdentificacion::where("active", 1)->pluck("descripcion", "id")->toArray();
        $estadoCivil        = ["" => "Seleccionar"] + EstadoCivil::where("active", 1)->pluck("descripcion", "id")->toArray();
        $genero             = ["" => "Seleccionar"] + Genero::where("active", 1)->pluck("descripcion", "id")->toArray();
        $aspiracionSalarial = ["" => "Seleccionar"] + AspiracionSalarial::where("active", 1)->pluck("descripcion", "id")->toArray();
        $claseLibreta       = ["" => "Seleccionar"] + ClaseLibreta::where("active", 1)->pluck("descripcion", "id")->toArray();
        $tipoVehiculo       = ["" => "Seleccionar"] + TipoVehiculo::where("active", 1)->pluck("descripcion", "id")->toArray();
        $categoriaLicencias = ["" => "Seleccionar"] + CategoriaLicencias::where("active", 1)->select(\DB::raw("CONCAT(codigo,' ',descripcion) as descripcion_categoria"), "id")->pluck("descripcion_categoria", "id")->toArray();
        $entidadesEps       = ["" => "Seleccionar"] + EntidadesEps::where("active", 1)->pluck("descripcion", "id")->toArray();
        $entidadesAfp       = ["" => "Seleccionar"] + EntidadesAfp::where("active", 1)->pluck("descripcion", "id")->toArray();

        $datosDireccion = json_decode($datos_basicos->direccion_formato, true);
        //dd($datosDireccion);
        if (is_array($datosDireccion)) {
            foreach ($datosDireccion as $key => $value) {
                $datos_basicos->$key = $value;
            }
        }

        $letras = [
            ""  => "Seleccionar",
            "A" => "A",
            "B" => "B",
            "C" => "C",
            "D" => "D",
            "E" => "E",
            "F" => "F",
            "G" => "G",
            "H" => "H",
            "I" => "I",
            "J" => "J",
        ];
        $prefijo = [
            ""      => "Seleccionar",
            "ESTE"  => "ESTE",
            "NORTE" => "NORTE",
            "OESTE" => "OESTE",
            "SUR"   => "SUR",
        ];
        $tipo_via = ["" => "Seleccionar",
            "AU"            => "Autopista ",
            "AV"            => "Avenida ",
            "AC"            => "Avenida Calle ",
            "AK"            => "Avenida Carrera ",
            "BL"            => "Bulevar ",
            "CL"            => "Calle ",
            "KR"            => "Carrera ",
            "CT"            => "Carretera ",
            "CQ"            => "Circular ",
            "CV"            => "Circunvalar ",
            "CC"            => "Cuentas Corridas ",
            "DG"            => "Diagonal ",
            "PJ"            => "Pasaje ",
            "PS"            => "Paseo ",
            "PT"            => "Peatonal ",
            "TV"            => "Transversal ",
            "TC"            => "Troncal ",
            "VT"            => "Variante ",
            "VI"            => "Vía "];
        $lugarnacimiento = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS value")
            ->where("ciudad.cod_pais", $datos_basicos->pais_nacimiento)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_nacimiento)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_nacimiento)->first();
        $lugarexpedicion = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_id)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_id)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_id)->first();
        $lugarresidencia = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $datos_basicos->pais_residencia)
            ->where("ciudad.cod_departamento", $datos_basicos->departamento_residencia)
            ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_residencia)->first();

        $txtLugarNacimiento = "";
        $txtLugarExpedicion = "";
        $txtLugarResidencia = "";
        if ($lugarnacimiento != null) {
            $txtLugarNacimiento = $lugarnacimiento->value;
        }
        if ($lugarexpedicion != null) {
            $txtLugarExpedicion = $lugarexpedicion->value;
        }
        if ($lugarresidencia != null) {
            $txtLugarResidencia = $lugarresidencia->value;
        }

        $datos_basicos->fill(Request::all());

        return response()->json(["view" => view("admin.hv.edit_datos_basicos", compact("datos_basicos", "txtLugarNacimiento", "txtLugarExpedicion", "txtLugarResidencia", "data", "letras", "tipos_documentos", "estadoCivil", "genero", "aspiracionSalarial", "claseLibreta", "tipoVehiculo", "categoriaLicencias", "entidadesEps", "entidadesAfp", "prefijo", "tipo_via"))->withErrors($errors)->render()]);
    }
}
