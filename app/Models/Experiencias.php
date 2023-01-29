<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
//use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;
use Carbon\Carbon;
use DateTime;
use Eloquent;

class Experiencias extends Eloquent
{

    protected $table    = 'experiencias';
    protected $fillable = [
        'id',
        'numero_id',
        'user_id',
        'trabajo_temporal',
        'nombre_temporal',
        'telefono_temporal',
        'nombre_empresa',
        'ciudad_id',
        'cargo_desempenado',
        'nombres_jefe',
        'cargo_jefe',
        'movil_jefe',
        'fijo_jefe',
        'ext_jefe',
        'empleo_actual',
        'fecha_inicio',
        'fecha_final',
        'salario_devengado',
        'motivo_retiro',
        'funciones_logros',
        'autoriza_solicitar_referencias',
        'active',
        'created_at',
        'updated_at',
        'pais_id',
        'departamento_id',
        'cargo_especifico',
        'cantidad_empleados',
        'dedicacion_empresa',
        'personas_a_cargo',
        'cant_a_cargo',
        'motivo_retiro_txt',
        'observacion_experiencia',
        'cargo_otro',
        'sueldo_fijo_bruto',
        'ingreso_varial_mensual',
        'otros_bonos',
        'total_ingreso_anual',
        'total_ingreso_mensual',
        'utilidades',
        'valor_actual_fondos',
        'beneficios_monetario',
        'le_reportan'
    ];


    public function getPais()
    {
      
      return Pais::join("departamentos", function ($join) {
              $join->on("paises.cod_pais", "=", "departamentos.cod_pais");
            })->join("ciudad", function ($join2) {
              $join2->on("ciudad.cod_pais", "=", "departamentos.cod_pais")->on("ciudad.cod_departamento", "=", "departamentos.cod_departamento");
            })
            ->select(DB::raw("CONCAT(paises.nombre,' / ',departamentos.nombre,' / ',ciudad.nombre) AS value"))
            ->where("ciudad.cod_pais", $this->pais_id)
            ->where("ciudad.cod_departamento", $this->departamento_id)
            ->where("ciudad.cod_ciudad", $this->ciudad_id)->first();
    }

    public function motivo_retiro_des()
    {
      return $this->hasOne("App\Models\MotivoRetiro", "id", "motivo_retiro");
    }

    public function getmotivo_retiro_des()
    {
        //para traerse la descripcion del motivo de retiro mas rapido para el excell del longlist
        $estado = DB::table("motivos_retiros")->where("id", $this->motivo_retiro)->first();
        
        if ($estado == null) {
            return "";
        }

        return ucwords(mb_strtolower($estado->descripcion));
    }

    public function getRequerimientos()
    {
        return $this->hasMany("App\Models\ExperienciaVerificada", "experiencia_id", "id")
            ->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "experiencia_verificada.id")
            ->where("tipo_entidad", "MODULO_REFERENCIACION")
            ->where("proceso_requerimiento.proceso_adicional", "EXPERIENCIA_LABORAL")
            ->groupBy('proceso_requerimiento.requerimiento_id')
            ->get();
    }

    public function getFechaInicia()
    {
        $date = $this->where('user_id', $this->user_id)
            ->where('id', $this->id)
            ->select('fecha_inicio')
            ->first();

        if ($date == null) {
            return "";
        } else {
            setlocale(LC_ALL, 'es_MX', 'es', 'ES');
            $data = new Carbon($date->fecha_inicio);
            //$fi = Carbon::parse($date->fecha_inicio);
            $fecha_inicio = $data->formatLocalized('%d %B %Y');

            return $fecha_inicio;
        }
    }

    /**
     * Saber la fecha y pasarla en formato (6 abril del 2018) para la hv
     **/
    public function getFechaFinal()
    {
        $date = $this->where('user_id', $this->user_id)
            ->where('id', $this->id)
            ->select('fecha_final')
            ->first();

        if ($date == null) {
            return "";
        } else {
            
            setlocale(LC_ALL, 'es_MX', 'es', 'ES');
            $ff = Carbon::parse($date->fecha_final);
            Carbon::setUtf8(true);
            $fecha_final = $ff->formatLocalized('%d %B %Y');
            return $fecha_final;
        }
    }

    /**
     *
     **/
    public static function mesesEntreFechas($fecha1 = null, $fecha2 = null)
    {   
        $fecha_inicio = Carbon::parse($fecha1);
        $fecha_fin    = Carbon::parse($fecha2);
        $meses        = $fecha_fin->diffInMonths($fecha_inicio);

        return $meses.' m';
    }

    /**
     * Funcion para calcular el tiempo de años y meses entre dos fechas
     **/
    public static function añosMeses($fechainicio = null, $fechafin = null){

        //Convertimos la fecha a formato DatTime
        $fecha_i = Carbon::parse($fechainicio);
        if($fechafin <= 0){
            $fecha_f = Carbon::parse(date("Y-m-d"));
        }else{
            $fecha_f = Carbon::parse($fechafin);
        }
        //Se calcula la diferencia entre las dos fechas
        $fecha_hoy = $fecha_i->diff($fecha_f);

        if($fecha_hoy->y > 0 && $fecha_hoy->m < 1){
            return $fecha_hoy->y." años";
        }
        elseif ($fecha_hoy->y == 1 && $fecha_hoy->m < 1) {
            return $fecha_hoy->y." año";
        }
        elseif($fecha_hoy->y < 1 && $fecha_hoy->m > 0){   
            return $fecha_hoy->m." meses";
        }
        elseif ($fecha_hoy->y < 1 && $fecha_hoy->m == 1) {
            return $fecha_hoy->m." mes";
        }     
        else{
            if ($fecha_hoy->y < 1 && $fecha_hoy->m == 1) {
                return $fecha_hoy->y ." año y ". $fecha_hoy->m ." mes";
            }
            elseif ($fecha_hoy->y > 1 && $fecha_hoy->m == 1) {
                return $fecha_hoy->y ." años y ". $fecha_hoy->m ." mes";
            }
            elseif($fecha_hoy->y > 1 && $fecha_hoy->m > 1){
                return $fecha_hoy->y." años y ". $fecha_hoy->m ." meses";
            }
            elseif($fecha_hoy->y == 1 && $fecha_hoy->m == 1){
                return $fecha_hoy->y ." año y ". $fecha_hoy->m ." mes";
            }else{
             return (($fecha_hoy->y != 0 && $fecha_hoy->y != "")?$fecha_hoy->y.' año(s) y '.$fecha_hoy->m.' meses':$fecha_hoy->m.' meses');
            }
         //   return $fecha_hoy; 
        }

    }

    public function experiencia_verificada(){
       return $this->hasOne('App\Models\ExperienciaVerificada','experiencia_id','id');
    }

    public function certificados()
    {
        return $this->morphMany('App\Models\Certificado', 'certificable');
    }

}
