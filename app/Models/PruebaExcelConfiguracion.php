<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PruebaExcelConfiguracion extends Model
{
    protected $table    = 'prueba_excel_configuracion';
    protected $fillable = [
        'req_id',
        'excel_basico',
        'excel_intermedio',
        'tiempo_excel_basico',
        'tiempo_excel_intermedio',
        'aprobacion_excel_basico',
        'aprobacion_excel_intermedio',
        'gestiono'
    ];
}
