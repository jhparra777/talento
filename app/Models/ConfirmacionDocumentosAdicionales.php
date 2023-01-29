<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfirmacionDocumentosAdicionales extends Model
{
    //
    protected $table    = 'confirmacion_documentos_adicionales';
    protected $fillable = [
    	'user_id',
    	'req_id',
    	'contrato_id',
    	'documento_id',
    	'firma',
        'documento_firmado',
    	'estado',
        'externo'
    ];
}
