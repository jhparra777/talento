<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \DB;

class ReqPreg extends Model
{
    protected $table    = 'req_preguntas';
    protected $fillable = [
    	'id',
    	"cargo_especifico_id",
    	"req_id",
    	"descripcion",
    	"filtro",
    	"tipo_id",
        "activo",
    	"created_at",
        "updated_at"
    ];
}
