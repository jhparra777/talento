<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluacionSstConfiguracion extends Model
{
    protected $table    = 'evaluacion_sst_configuracion';
    protected $fillable = [
        'minimo_aprobacion',
        'titulo_modal',
        'titulo_pdf',
        'titulo_prueba',
        'instrucciones_prueba',
        'titulo_cargar_documento'
    ];
}
