<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaBrigPregunta extends Model
{
    protected $table      = 'prueba_brig_preguntas';
    protected $fillable   = [
        'descripcion',
        'active'
    ];

    public function getAnswerOptions(){
        return $this->hasMany('App\Models\PruebaBrigOpcion', 'brig_preg_id', 'id')->orderByRaw('RAND()');
    }
}
