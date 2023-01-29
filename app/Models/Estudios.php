<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Estudios extends Model
{

    protected $table    = 'estudios';
    protected $fillable = [
        'id',
        'numero_id',
        'user_id',
        'nivel_estudio_id',
        'institucion',
        'termino_estudios',
        'titulo_obtenido',
        'estudio_actual',
        'semestres_cursados',
        'periodicidad',
        'fecha_inicio',
        'fecha_finalizacion',
        'active',
        'created_at',
        'updated_at',
        'pais_estudio',
        'departamento_estudio',
        'ciudad_estudio',
        'estatus_academico',
        'acta',
        'folio'
    ];

    public function estudio_verificado(){
        return $this->hasOne("App\Models\EstudioVerificado");
    }

    public function referencia_estudio(){
        return $this->hasOne("App\Models\ReferenciaEstudio","estudio_id");
    }

    public function certificados()
    {
        return $this->morphMany('App\Models\Certificado', 'certificable');
    }

    /**
     * Fecha finalizo estudio en formato (01 de marzo 2019)
     **/
    public function getFechaFinalizo()
    {
         $date = $this->where('user_id',$this->user_id)
            ->where('id', $this->id)
            ->select('fecha_finalizacion')
            ->first();

        if($date == null) {
         return "";
        }else{
         
         setlocale(LC_TIME, 'es');
         
          $data = new Carbon($date->fecha_finalizacion);
            //$ff = Carbon::parse($date->fecha_finalizacion);
           $fecha_final = $data->formatLocalized('%d %B %Y');

            return $fecha_final;
        }
    }

    public function getCiudad()
    {
        $ciudad = $this->join("paises", "paises.cod_pais", "=", "estudios.pais_estudio")
        ->join("departamentos", function ($join) {
            $join->on("departamentos.cod_pais", "=", "estudios.pais_estudio")->on("departamentos.cod_departamento", "=", "estudios.departamento_estudio");
        })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "estudios.pais_estudio")
            ->on("ciudad.cod_departamento", "=", "estudios.departamento_estudio")
            ->on("ciudad.cod_ciudad", "=", "estudios.ciudad_estudio");
        })
        ->where("ciudad.cod_pais", $this->pais_estudio)
        ->where("ciudad.cod_departamento", $this->departamento_estudio)
        ->where("ciudad.cod_ciudad", $this->ciudad_estudio)
        ->select(\DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad"))
        ->first();

        if($ciudad == null){
            return "";
        }

        return $ciudad->ciudad;
    }

}
