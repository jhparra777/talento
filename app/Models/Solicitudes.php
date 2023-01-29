<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SolicitudRecursos;

class Solicitudes extends Model
{
    protected $table    = 'solicitudes';
    protected $fillable = [
        'user_id',
        'ciudad_id',
        'cargo_especifico_id',
        'riesgo_id',
        'jornada_laboral_id',
        'tipo_contrato_id',
        'motivo_requerimiento_id',
        'numero_vacante',
        'nivel_estudio_id',
        'tiempo_experiencia_id',
        'edad_minima',
        'edad_maxima',
        'genero_id',
        'estado_civil_id',
        'funciones_realizar',
        'observaciones',
        'estado',
        'documento',
        'fecha_tentativa',
        'recursos',
        'salario',
        'fecha_pendiente',
        'centro_costo_id',
        'centro_beneficio_id',
        'area_id',
        'subarea_id',
        'email_jefe_inmediato',
        'jefe_inmediato',
        'estado_compensado',
        'tiempo_contrato',
        'motivo_contrato',
        'plazo_req',
        'desc_motivo'
    ];

    /**
     * apolorubiano@gmail.com
     * Información de la jornada
     **/
   public function user()
    {
        return $this->hasOne("App\Models\User", "id", "user_id")->first();
    }
    public function cargoespecifico()
    {
        return $this->belongsTo('App\Models\CargoEspecifico', 'cargo_especifico_id');
    }
    public function centrobeneficio()
    {
        return $this->belongsTo('App\Models\SolicitudCentroBeneficio', 'centro_beneficio_id');
    }
    public function centrocosto()
    {
        return $this->belongsTo('App\Models\SolicitudCentroCosto', 'centro_costo_id');
    }
    public function area()
    {
        return $this->belongsTo('App\Models\SolicitudAreaFuncional', 'area_id');
    }
    public function subarea()
    {
        return $this->belongsTo('App\Models\SolicitudSubArea', 'subarea_id');
    }
    public function sede()
    {
        return $this->belongsTo('App\Models\SolicitudSedes', 'ciudad_id');
    }
    public function jornada()
    {
        return $this->hasOne("App\Models\TipoJornada", "id", "jornada_laboral_id")->first();
    }
    public function requerimiento()
    {
        return $this->hasOne("App\Models\Requerimiento", "solicitud_id");
    }

    /**
     * apolorubiano@gmail.com
     * Información de tipo contrato
     **/
    public function tipoContrato()
    {
        return $this->hasOne("App\Models\TipoContrato", "id", "tipo_contrato_id")->first();
    }

    public function motivoContrato()
    {
        return $this->hasOne("App\Models\TipoContrato", "id", "tipo_contrato_id")->first();
    }
    
    public function jefeInmediato()
    {
        return $this->hasOne('App\Models\JefeInmediato',"id","jefe_inmediato")->first();
    }

    /**
     * apolorubiano@gmail.com
     * Información de tipo contrato
     **/
    public function motivoRequerimiento()
    {
        return $this->hasOne("App\Models\MotivoRequerimiento", "id", "motivo_requerimiento_id")->first();
    }

    /**
     * apolorubiano@gmail.com
     * Información de nivel estudio
     **/
    public function nivelEstudios()
    {
        return $this->hasOne("App\Models\NivelEstudios", "id", "nivel_estudio_id")->first();
    }

    /**
     * apolorubiano@gmail.com
     * Información de tipo experiencia
     **/
    public function tipoExperiencia()
    {
        return $this->hasOne("App\Models\TipoExperiencia", "id", "tiempo_experiencia_id")->first();
    }

    /**
     * apolorubiano@gmail.com
     * Información de genero
     **/
    public function genero()
    {
        return $this->hasOne("App\Models\Genero", "id", "genero_id")->first();
    }

    /**
     * apolorubiano@gmail.com
     * Información de estado civil
     **/
    public function estadoCivil()
    {
        return $this->hasOne("App\Models\EstadoCivil", "id", "estado_civil_id")->first();
    }

    /**
     * apolorubiano@gmail.com
     * Información de cargo generico
     **/
    public function cargoGenerico()
    {
        return $this->hasOne("App\Models\CargoEspecifico", "id", "cargo_especifico_id")->first();
    }

    /**
     * apolorubiano@gmail.com
     * Estado de la solicitud
     **/
    public function solicitudEstado()
    {
        return $this->hasOne("App\Models\SolicitudEstado", "id", "estado")->first();
    }

    public function recursosNecesarios()
    {
        return $this->hasMany("App\Models\SolicitudRecursos", "id_solicitud");
    }
    
    public function misrecursosNecesarios($rec=null , $id_sol=null)
    {
        
        $recurso = SolicitudRecursos::select('recurso_necesario')
                        ->where("id_solicitud", $id_sol)
                        ->where("recurso_necesario", $rec)
                        ->first();
        if($recurso){
            return true;
        }

        return false;
    }

}
