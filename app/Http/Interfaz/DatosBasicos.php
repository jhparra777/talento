<?php

namespace App\Http\Interfaz\DatosBasicosTrai;

trait datos_basicos_trai
{

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
        
    $lugarnacimiento = \Pais::join("departamentos", function ($join) {
        $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
    })->join("ciudad", function ($join2) {
        $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
    })
        ->select("paises.nombre||'/'||departamentos.nombre||'/'||ciudad.nombre  AS value")
        ->where("ciudad.cod_pais", $datos_basicos->pais_nacimiento)
        ->where("ciudad.cod_departamento", $datos_basicos->departamento_nacimiento)
        ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_nacimiento)->first();
    $lugarexpedicion = \Pais::join("departamentos", function ($join) {
        $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
    })->join("ciudad", function ($join2) {
        $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
    })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $datos_basicos->pais_id)
        ->where("ciudad.cod_departamento", $datos_basicos->departamento_id)
        ->where("ciudad.cod_ciudad", $datos_basicos->ciudad_id)->first();
    $lugarresidencia = \Pais::join("departamentos", function ($join) {
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
}
