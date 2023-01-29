<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntrevistaCandidatos extends Model
{

    protected $table    = 'entrevistas_candidatos';
    protected $fillable = ['id',
        'candidato_id',
        'fuentes_publicidad_id',
        'aspecto_familiar',
        'aspecto_academico',
        'aspectos_experiencia',
        'aspectos_personalidad',
        'fortalezas_cargo',
        'oportunidad_cargo',
        'concepto_general',
        'created_at',
        'updated_at',
        'apto',
        'asistio',
        'req_id',
        'user_gestion_id',
        'evaluacion_competencias'
    ];
    
    public function getRequerimientos()
    {
        return $this->hasMany("App\Models\ProcesoRequerimiento", "entidad_id", "id")->where("tipo_entidad", "MODULO_ENTREVISTA")->get();
    }

    public function getRequerimientosActivos($req)
    {
        return $this->hasMany("App\Models\ProcesoRequerimiento", "entidad_id", "id")->where("tipo_entidad", "MODULO_ENTREVISTA")->where("requerimiento_id",$req)->where("activo",1)->first();
    }

    //Funcion para asignar las competencias en el reporte de informe seleccion
    public function getCompetencias()
    {

        $competenciasEvaluadas = CalificaCompetencia::where("entidad_id", $this->id)->where("tipo_entidad", "MODULO_ENTREVISTA")->get();

        $arrayValores     = [];
        $arrayDescripcion = [];
        foreach ($competenciasEvaluadas as $key => $value) {
            $arrayValores[$value->competencia_entrevista_id]     = $value->valor;
            $arrayDescripcion[$value->competencia_entrevista_id] = $value->descripcion;
        }
        //$califica->competencia = $arrayValores;
        //$califica->descripcion = $arrayDescripcion;

        return $arrayValores;
    }

    //Funcion para asignar la descripcion en el reporte de informe seleccion
    public function getDescripcion()
    {

        $competenciasEvaluadas = CalificaCompetencia::where("entidad_id", $this->id)->where("tipo_entidad", "MODULO_ENTREVISTA")->get();

        $arrayValores     = [];
        $arrayDescripcion = [];
        foreach ($competenciasEvaluadas as $key => $value) {
            $arrayValores[$value->competencia_entrevista_id]     = $value->valor;
            $arrayDescripcion[$value->competencia_entrevista_id] = $value->descripcion;
        }
        //$califica->competencia = $arrayValores;
        //$califica->descripcion = $arrayDescripcion;

        return $arrayDescripcion;
    }

    //Nombre quien realiza la entrevista para el informe de seleccion
    public function getNamePsicologo()
    {

        $name = User::select("name")
            ->where("id", $this->user_gestion_id)
            ->first();

        return $name["name"];
    }

      
       public function usuarioAsistio()
    {
        //dd($this->req_id);
         $asistencia = EntrevistaCandidatos::

            first();

        if($asistencia === null){
            return null;
        }
        else{
           // dd($asistencia);
            if ($asistencia->asistio === null) {
                return "No ha asistido a la entrevista";
            }
                
            return "Si";
        }
    }

}
