<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferenciaEstudio extends Model
{
    protected $table = 'referencias_estudios';

    protected $guarded = ['id'];

    public function estudio(){
        return $this->belongsTo("App\Models\Estudios","estudio_id");
    }
}
