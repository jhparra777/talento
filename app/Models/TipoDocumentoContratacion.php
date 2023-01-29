<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumentoContratacion extends Model
{
    protected $table    = 'tipo_documento_contratacion';
    protected $fillable = ['id', "descripcion"];
    public $timestamps  = false;

}
