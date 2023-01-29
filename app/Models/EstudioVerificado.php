<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EstudioVerificado extends Model
{

    protected $table    = 'estudios_verificados';
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
        'estudios_id',
        'nombre_referenciante',
        'cargo_referenciante',
        'programa',
        'numero_acta',
        'numero_folio',
        'numero_registro',
        'usuario_gestion',
        'visita_candidato_id'
    ];

    public function estudio(){
        return $this->belongsTo("App\Models\Estudios","estudios_id");
    }

    /**
     * Fecha finalizo estudio en formato (01 de marzo 2019)
     **/
    

}
