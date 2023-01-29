<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificaCompetencia extends Model
{

    protected $table    = 'califica_competencia';
    protected $fillable = [
        'id',
        'entidad_id',
        'competencia_entrevista_id',
        'valor',
        'descripcion',
        'created_at',
        'tipo_entidad',
        'updated_at',
    ];

}
