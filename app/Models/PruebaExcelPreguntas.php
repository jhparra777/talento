<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaExcelPreguntas extends Model
{
    protected $table      = 'prueba_excel_preguntas';
    protected $fillable   = [
        'descripcion',
        'tipo',
        'active'
    ];

    public function getOpciones(){
        return $this->hasMany('App\Models\PruebaExcelOpciones', 'id_pregunta', 'id')->where('active', 1)->orderByRaw('RAND()');
    }

    public function allOpciones(){
        return $this->hasMany('App\Models\PruebaExcelOpciones', 'id_pregunta', 'id');
    }
}
