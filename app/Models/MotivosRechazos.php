<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotivosRechazos extends Model
{

    protected $table    = 'motivos_rechazos';
    protected $fillable = ["id", "descripcion", "updated_at", "created_at",
    ];

}
