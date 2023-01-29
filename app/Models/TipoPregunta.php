<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPregunta extends Model
{
    protected $table    = "tipo_pregunta";
    
    protected $fillable = [
    	"id",
    	"descripcion",
    	"created_at",
    	"updated_at"
    ];
}
