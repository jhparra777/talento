<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntrevistaVirtual extends Model
{

    protected $table    = 'entrevista_virtual';
    protected $fillable = [
        "id","user_gestion","activo" ,"req_id","created_at", "updated_at",
    ];
}
