<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LlamadaMensaje extends Model
{
    protected $table    = "llamada_mensaje";
    protected $fillable = [
    	"id",
    	"user_llamada",
    	"req_id",
    	"nombre_candidato",
    	"telefono_movil",
    	"numero_id",
        "num_msg",
        "content_msg",
    	"created_at",
    	"updated_at"
    ];
}
