<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContratoCancelado extends Model
{
    //
    protected $table    = 'contratos_cancelados';
    protected $fillable = [
        'id',
        'user_id',
        'req_id',
        'contrato_id',
        'observacion',
        'ip',
        'documento',
        'uuid',
        'base_64',
        'motivo_anulado',
        'contrato_anulado'
    ];
}
