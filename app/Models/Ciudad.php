<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{

    protected $table    = 'ciudad';
    protected $fillable = ['id', "nombre", "cod_pais", "cod_departamento", "cod_ciudad","agencia", "homologa_id"];


    public function requerimientos(){
        return $this->hasMany('App\Models\Requerimiento',"ciudad_id");
    }

    public function departamento(){
        return $this->belongsTo('App\Models\Departamento',"cod_departamento","cod_departamento");
        //return $this->belongsTo(Departamento::class);
    }
    

    /**
     * Funcion estatica para consultar la descripción de la Ciudad, segun el pais y el departamento.
     **/
    public static function GetCiudad($id_pais = null, $id_departamento = null, $id_ciudad = null)
    {
        $ciudad = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })
            ->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")
                    ->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select(\DB::raw("CONCAT(ciudad.nombre) AS ciudad"))
            ->where("ciudad.cod_pais", $id_pais)
            ->where("ciudad.cod_departamento", $id_departamento)
            ->where("ciudad.cod_ciudad", $id_ciudad)
            ->first();
        if ($ciudad == null) {
            return "";
        } else {
            return ucwords(mb_strtolower($ciudad->ciudad), ' \.');
        }
    }

    public function agencia_d(){
      return $this->belongsTo('App\Models\Agencia','agencia','id');
    }

    public function getSitioTrabajo($id_pais = null, $id_departamento = null, $id_ciudad = null){

        $ciudad = Pais::join("departamentos", function ($join) {
            $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
        })
        ->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")
                ->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
        })
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS value"))
        ->where("ciudad.cod_pais", $id_pais)
        ->where("ciudad.cod_departamento", $id_departamento)
        ->where("ciudad.cod_ciudad", $id_ciudad)
        ->first();

        if ($ciudad == null) {
            return "";

        } else {

            return ucwords(mb_strtolower($ciudad->value));

        }

    }

}
