<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluacionSstOpciones extends Model
{
    protected $table      = 'evaluacion_sst_opciones';
    protected $fillable   = [
        'id_pregunta',
        'descripcion',
        'correcta',
        'active'
    ];

    public function pregunta() {
        return $this->belongsTo('App\Models\EvaluacionSstPreguntas', 'id_pregunta', 'id');
    }
}
