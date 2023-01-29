<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PregReqResp extends Model
{
    protected $table    = 'preg_req_resp';
    protected $fillable = [
    	'id',
    	"preg_id",
    	"req_id",
        "user_id",
        "cargo_especifico_id",
    	"descripcion",
    	"puntuacion",
        "created_at",
        "updated_at"
    ];
}
