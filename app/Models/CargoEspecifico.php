<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class CargoEspecifico extends Model
{
    public $timestamps = false;
    protected $table   = 'cargos_especificos';

    protected $fillable = [
        'id',
        'descripcion',
        'CODIGO_1',
        'CODIGO_2',
        'CODIGO_3',
        'CODIGO_4',
        'cargo_generico_id',
        'CREATED_AT',
        'UPDATE_AT',
        'clt_codigo',
        'CARGO_CODIGO',
        'GRADO_CODIGO',
        'CTRA_X_CLT_CODIGO',
        'CXCLT_JORN_LAB',
        'CXCLT_TNOM',
        'CXCLT_TLIQ',
        'CXCLT_ESTADO',
        'NEST_CODIGO',
        'CXCLT_GENERO',
        'CXCLT_EST_CIVIL',
        'CXCLT_EDAD_MIN',
        'CXCLT_EDAD_MAX',
        'TCO_CODIGO',
        'TSAL_CODIGO',
        'CXCLT_SUELDO_MENSUAL',
        'CXCLT_SUELDO_MINIMO',
        'CXCLT_SUELDO_MAXIMO',
        'MON_CODIGO',
        'FP_PORC',
        'CXCLT_CODIGO',
        'plazo_req',
        'menor5',
        'menor10',
        'menor20',
        'menor30',
        'menor40',
        'menor50',
        'menor80',
        'examesMedicos',
        'estudioSeguridad',
        'tiempoEvaluacionCliente',
        'examenMedicoDias',
        'estudioSeguridadDias',
        'firma_digital',
        'videos_contratacion',
        'active',
        'prfl_tipo_cargo',
        'prfl_nivel_cargo',
        'prfl_clase_riesgo',
        'prfl_jornada_laboral',
        'prfl_tipo_liquidacion',
        'prfl_salario',
        'prfl_tipo_nomina',
        'prfl_tipo_contrato',
        'prfl_concepto_pago',
        'prfl_nivel_estudio',
        'prfl_tiempo_experiencia',
        'prfl_edad_minima',
        'prfl_edad_maxima',
        'prfl_genero',
        'prfl_estado_civil',
        'prfl_adicionales_salariales',
        'prfl_funciones',
        'prfl_perfil_oculto',
        'prfl_tipo_salario'
    ];

    public function solicitudes(){
        return $this->hasMany('App\Models\Solicitudes');
    }
  
    public function hasDocumento($cargo,$documento)
    {
        $agencia = DB::table("cargo_documento")->where("cargo_especifico_id", $cargo)
        ->where("tipo_documento_id", $documento)
        ->get();

        if ($agencia == null) {
            return false;
        }else {
            return true;
        }
    }

    public function hasExamen($cargo, $examen)
    {
        $agencia = DB::table("cargos_examenes")->where("cargo_id", $cargo)
        ->where("examen_id", $examen)
        ->get();

        if ($agencia == null) {
            return false;
        }else {
            return true;
        }
    }

    public function hasDocumentoAdicional($cargo, $adicional)
    {
        $agencia = DB::table("cargos_documentos_adicionales")->where("cargo_id", $cargo)->where('adicional_id', $adicional)->where("active", 1)->first();

        if ($agencia == null) {
            return false;
        }else {
            return true;
        }
    }

    public function examenes(){
       return $this->belongsToMany('App\Models\ExamenMedico', 'cargos_examenes','cargo_id','examen_id');
    }

    public function tipos_documentos(){
       return $this->belongsToMany('App\Models\TipoDocumento', 'cargo_documento','cargo_especifico_id','tipo_documento_id');
    }

    public function clausulas(){
       return $this->belongsToMany('App\Models\DocumentoAdicional', 'cargos_documentos_adicionales','cargo_id','adicional_id')->withPivot("active as active_pivot");
    }
}
