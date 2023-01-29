<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentosContratacion extends Model
{

    protected $table    = 'documentos_contratacion';
    protected $fillable = [
        'id',
        'tipo_documento',
        'nombre_archivo',
       
        
        'created_at',
        'updated_at',
        
        "candidato_id",
    ];

    
}
