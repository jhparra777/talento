<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotivoDescarteCandidato extends Model
{
    protected $table = 'motivo_descarte_candidatos';

    protected $fillable = ['descripcion', 'active'];
}
