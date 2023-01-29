<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartappConfigFecha extends Model
{
    protected $table      = 'cartapp_config_fechas_solicitud';
    protected $fillable   = [
        'mes',
        'primer_periodo_dia_inferior',
        'primer_periodo_dia_superior',
        'segundo_periodo_dia_inferior',
        'segundo_periodo_dia_superior'
    ];
}
