<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaExcelOpciones extends Model
{
    protected $table      = 'prueba_excel_opciones';
    protected $fillable   = [
        'id_pregunta',
        'descripcion',
        'correcta',
        'active'
    ];

    public function pregunta() {
        return $this->belongsTo('App\Models\PreguntaExcelPreguntas', 'id_pregunta', 'id');
    }
}
