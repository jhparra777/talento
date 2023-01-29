<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentoCliente extends Model
{

    protected $table    = 'documentos_clientes';
    protected $fillable = [
        'cliente_id',
        'tipo_documento_id',
        'nombre_archivo',
        'gestiono'];

    

}
