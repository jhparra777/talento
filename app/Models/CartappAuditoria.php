<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartappAuditoria extends Model
{
    protected $table      = 'cartapp_auditoria';
    protected $fillable   = [
        'observaciones',
        'valor_antes',
        'valor_despues',
        'gestiona',
        'numero_id',
        'permiso_id',
        'tipo'
    ];
}
