<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Negocio extends Model
{

    protected $table    = 'negocio';
    protected $fillable = ['id', "cliente_id", "tipo_contrato_id", "tipo_proceso_id", "num_negocio", "tipo_jornada_id","tipo_liquidacion_id", "tipo_salario_id","pais_id", "departamento_id", "ciudad_id", "nombre_negocio"];

    public function ans(){
        return $this->hasMany('App\Models\NegocioANS');
    }

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
    public function getSociedades()
    {
        return $this->belongsTo("App\Models\Sociedad", "sociedad", "division_codigo")
            ->where("sociedades.division_geren_codigo", config("conf_aplicacion.DIVISION_GEREN_CODIGO"));
    }
    public function getLocalidades()
    {
        return $this->belongsTo("App\Models\Localidad", "localidad", "codigo");
    }
    public function getTipoNegocios()
    {
        return $this->belongsTo("App\Models\TipoNegocio", "tipo_negocio", "codigo");
    }
    public function getUserClientes()
    {
        return $this->belongsTo("App\Models\UserClientes", "cliente_id", "cliente_id");
    }

    public function cliente()
    {
        return $this->belongsTo("App\Models\Clientes", "id", "cliente_id");
    }
    public function getUnidadesNegocio()
    {
        return $this->belongsTo("App\Models\UnidadNegocio", "unidad_negocio", "codigo");
    }
    public function getGerencia()
    {
        return $this->belongsTo("App\Models\Gerencia", "depto_geren_codigo", "id")
            ->where("gerencia.gerencia_emp_codigo", config("conf_aplicacion.EMP_DIVISION_GERENCIA"));
    }
    public function getTipoJornada()
    {

        $jornada = DB::table("tipos_jornadas")->where("id", $this->tipo_jornada_id)->first();

        if ($jornada == null) {
            return "";
        }

        return $jornada->descripcion;
    }
    public function getCliente()
    {

        $nombre = DB::table("clientes")->where("id", $this->cliente_id)->first();

        if ($nombre == null) {
            return "";
        }

        return $nombre;
    }

}
