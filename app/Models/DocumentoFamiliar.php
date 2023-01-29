<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoFamiliar extends Model
{
    protected $table = "documentos_familiares";

    protected $guarded = ['id'];

    public function tipoDocumento()
    {
        return $this->belongsTo('App\Models\TipoDocumento');
    }
}
