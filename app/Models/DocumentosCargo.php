<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentosCargo extends Model
{
    //
    protected $table    = 'cargo_documento';
    protected $fillable = [
        'cargo_especifico_id',
        'tipo_documento_id',
    ];
}
