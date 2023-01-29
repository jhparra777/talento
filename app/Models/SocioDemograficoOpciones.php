<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocioDemograficoOpciones extends Model
{
    protected $table      = 'sociodemografico_opciones';
    protected $fillable   = [
        'id_pregunta',
        'descripcion',
        'active'
    ];

    public function pregunta() {
        return $this->belongsTo('App\Models\SocioDemograficoPreguntas', 'id_pregunta', 'id');
    }
}
