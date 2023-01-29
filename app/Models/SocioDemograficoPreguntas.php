<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocioDemograficoPreguntas extends Model
{
    protected $table      = 'sociodemografico_preguntas';
    protected $fillable   = [
        'descripcion',
        'tipo',
        'pregunta_obligatoria',
        'active'
    ];

    public function getOptionActive(){
        return $this->hasMany('App\Models\SocioDemograficoOpciones', 'id_pregunta', 'id')->where('active', 1)->orderBy('id');
    }

    public function getOptionActiveRand(){
        return $this->hasMany('App\Models\SocioDemograficoOpciones', 'id_pregunta', 'id')->where('active', 1)->orderByRaw('RAND()');
    }

    public function allOptions(){
        return $this->hasMany('App\Models\SocioDemograficoOpciones', 'id_pregunta', 'id');
    }
}
