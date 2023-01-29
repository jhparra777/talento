<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GrupoFamilia extends Model
{

    protected $table    = 'grupos_familiares';
    protected $fillable = [
        'numero_id',
        'user_id',
        'tipo_documento',
        'documento_identidad',
        'codigo_departamento_expedicion',
        'codigo_ciudad_expedicion',
        'nombres',
        'primer_apellido',
        'segundo_apellido',
        'escolaridad_id',
        'parentesco_id',
        'genero',
        'fecha_nacimiento',
        'codigo_departamento_nacimiento',
        'codigo_ciudad_nacimiento',
        'profesion_id',
        'active',
        'created_at',
        'updated_at',
        'codigo_pais_expedicion',
        'codigo_pais_nacimiento',
        'convive',
        'celular_contacto'
    ];

    public function getLugarExpedicion()
    {
        return $this->join("paises", "paises.cod_pais", "=", "grupos_familiares.codigo_pais_expedicion")
            ->join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "grupos_familiares.codigo_pais_expedicion");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "grupos_familiares.codigo_pais_expedicion")
                ->on("ciudad.cod_departamento", "=", "grupos_familiares.codigo_departamento_expedicion")
                ->on("ciudad.cod_ciudad", "=", "grupos_familiares.codigo_ciudad_expedicion");
        })->where("ciudad.cod_pais", $this->codigo_pais_expedicion)
            ->where("ciudad.cod_departamento", $this->codigo_departamento_expedicion)
            ->where("ciudad.cod_ciudad", $this->codigo_ciudad_expedicion)
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad"))
            ->first();
    }
    public function getLugarNacimiento()
    {
        return $this->join("paises", "paises.cod_pais", "=", "grupos_familiares.codigo_pais_nacimiento")
            ->join("departamentos", function ($join) {
                //$join->on("paises.cod_pais", "=", "grupos_familiares.codigo_pais_nacimiento");
                $join->on("departamentos.cod_pais", "=", "grupos_familiares.codigo_pais_nacimiento");
                $join->on("departamentos.cod_departamento", "=", "grupos_familiares.codigo_departamento_nacimiento");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "grupos_familiares.codigo_pais_nacimiento")
                ->on("ciudad.cod_departamento", "=", "grupos_familiares.codigo_departamento_nacimiento")
                ->on("ciudad.cod_ciudad", "=", "grupos_familiares.codigo_ciudad_nacimiento");
        })->where("ciudad.cod_pais", $this->codigo_pais_nacimiento)
            ->where("ciudad.cod_departamento", $this->codigo_departamento_nacimiento)
            ->where("ciudad.cod_ciudad", $this->codigo_ciudad_nacimiento)
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad"))
            ->first();
    }

    public function getParentesco()
    {
      
      return $this->join("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("profesiones.descripcion as profesion")
            ->where("profesiones.id", $this->profesion_id)
            ->first();
    }

    public function getParent()
    {
      
      return $this->join("profesiones", "profesiones.id", "=", "grupos_familiares.profesion_id")
            ->select("profesiones.descripcion as profesion")
            ->where("profesiones.id", $this->profesion_id)
            ->first();
    }

    public function getEdad()
    {
        $familiar = GrupoFamilia::where('id', $this->id)->first();
        $edad = ($familiar->fecha_nacimiento != '0000-00-00')?Carbon::parse($familiar->fecha_nacimiento)->age:'';

      return $edad;
    }

}
