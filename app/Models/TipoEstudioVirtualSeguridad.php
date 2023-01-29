<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoEstudioVirtualSeguridad extends Model
{
    protected $table    = 'tipos_evs';
    protected $fillable = [
    	'descripcion',
    	'analisis_financiero',
    	'consulta_antecedentes',
    	'referenciacion_academica',
    	'referenciacion_laboral',
    	'visita_domiciliaria',
    	'active'
];
}
