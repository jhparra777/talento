<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaDocumento extends Model
{
    protected $table    = 'categoria_documentos';
    protected $fillable = ["descripcion"];
}
