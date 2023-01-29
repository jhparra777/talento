<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataEmailEnviados extends Model
{
    protected $table    = 'emails_confirmacion_contratacion';
    protected $fillable = [
    	'id',
    	'enviado_cliente',
    	'enviado_candidato',
    	'candidato_id',
    	'requerimiento_id',
    	'quien_confirma_id',
    	'candidato_requerimiento_id',
    	'email_candidato',
    	'emails_clientes',
    	'otros_emails'
    ];
}
