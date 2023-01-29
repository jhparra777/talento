<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumentoCliente extends Model
{
    //
    protected $table    = 'tipos_documentos_clientes';
    protected $fillable = ["descripcion","categoria","active"];

   public function tipo_categoria()
    {
        return $this->belongsTo('App\Models\CategoriaDocumentoCliente', 'categoria');
    }

}
