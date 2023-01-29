<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequerimientoContratoCandidato extends Model
{
    protected $table      = 'requerimiento_contrato_candidato';
    protected $fillable   = [
    	'requerimiento_id',
    	'candidato_id',
        'requerimiento_candidato_id',
    	'centro_costo_id',
    	'arl_id',
    	'eps_id',
    	'fondo_pensiones_id',
    	'caja_compensacion_id',
    	'fondo_cesantia_id',
    	'user_gestiono_id',
    	'fecha_ultimo_contrato',
    	'fecha_ingreso',
    	'observaciones',
    	'hora_ingreso',
    	'auxilio_transporte',
    	'nombre_banco',
    	'tipo_cuenta',
    	'numero_cuenta',
    	'fecha_fin_contrato',
    	'created_at',
    	'updated_at'
    ];
}
