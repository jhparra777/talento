<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ofertas extends Model
{

    protected $table    = 'ofertas';
    protected $fillable = ['id',
        'cargo_generico_id',
        'nivel_estudio_id',
        'fecha_vencimiento',
        'fecha_publicacion',
        'salario',
        'mostrar_salario',
        'anios_experiencia',
        'cod_oferta',
        'cantidad_vacantes',
        'tipo_contrato_id',
        'pais_id',
        'departamento_id',
        'ciudad_id',
        'jornada_id',
        'requerimiento_id',
        'descripcion_oferta',
        'activo',
        'created_at',
        'updated_at',
        'cliente_id'];

    public function empresa()
    {
        return $this->hasOne("App\Models\Clientes", "id", "cliente_id")->FIRST();
    }
    public function cargo()
    {
        return $this->hasOne("App\Models\CargoGenerico", "id", "cargo_generico_id")->FIRST();
    }
    public function estudio()
    {
        return $this->hasOne("App\Models\NivelEstudios", "id", "nivel_estudio_id")->FIRST();
    }
    public function jornada()
    {
        return $this->hasOne("App\Models\TipoJornada", "id", "nivel_estudio_id")->first();
    }

    public function getUbicacion()
    {
        return $this->join("paises", "paises.cod_pais", "=", "ofertas.pais_id")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "ofertas.pais_id")->on("departamentos.cod_departamento", "=", "ofertas.departamento_id");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "ofertas.pais_id")
                ->on("ciudad.cod_departamento", "=", "ofertas.departamento_id")
                ->on("ciudad.cod_ciudad", "=", "ofertas.ciudad_id");
        })->where("ciudad.cod_pais", $this->pais_id)
            ->where("ciudad.cod_departamento", $this->departamento_id)
            ->where("ciudad.cod_ciudad", $this->ciudad_id)
            ->select(DB::raw("CONCAT(paises.nombre,' / ',departamentos.nombre,' / ',ciudad.nombre) AS ciudad"))
            ->first();
    }

}
