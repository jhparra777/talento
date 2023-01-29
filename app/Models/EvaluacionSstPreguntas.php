<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluacionSstPreguntas extends Model
{
    protected $table      = 'evaluacion_sst_preguntas';
    protected $fillable   = [
        'descripcion',
        'tipo',
        'active'
    ];

    public function getOptionActive(){
        return $this->hasMany('App\Models\EvaluacionSstOpciones', 'id_pregunta', 'id')->where('active', 1)->orderBy('id');
    }

    public function getOptionActiveRand(){
        return $this->hasMany('App\Models\EvaluacionSstOpciones', 'id_pregunta', 'id')->where('active', 1)->orderByRaw('RAND()');
    }

    public function allOptions(){
        return $this->hasMany('App\Models\EvaluacionSstOpciones', 'id_pregunta', 'id');
    }
}
