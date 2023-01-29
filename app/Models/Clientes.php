<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Clientes extends Model
{
    protected $table    = 'clientes';
    protected $fillable = [
        'id',
        'nit',
        'nombre',
        'created_at',
        'updated_at',
        'direccion',
        'telefono',
        'pag_web',
        'fax',
        'pais_id',
        'departamento_id',
        'ciudad_id',
        'estado',
        'logo',
        "contacto",
        "correo",
        "cargo",
        'cliente_id',
        "cargo_generico_id",
        "firma_digital"
    ];

    public function getUbicacion()
    {
        $dato = $this->join("paises", "paises.cod_pais", "=", "pais_id")
            ->join("departamentos", function ($join) {
                $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
            ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $this->pais_id)
            ->where("ciudad.cod_departamento", $this->departamento_id)
            ->where("ciudad.cod_ciudad", $this->ciudad_id)->first();

        if ($dato != null) {
            return $dato;
        }

        $datos        = new \stdClass();
        $datos->value = "";
        return $datos;
    }

    public function cargosGenericos()
    {
        return $this->belongsTo("App\Models\CargoGenerico", "cargo_generico_id");
    }

    public function users()
    {
       return $this->belongsToMany('App\Models\User', 'users_x_clientes', 'cliente_id', 'user_id');
    }

}
