<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preperfilados extends Model
{
    //
    protected $table = 'candidatos_preperfilados';
    protected $fillable = ["candidato_id", "req_id"];

    
    public function datos_basicos() {
        return $this->belongsTo('App\Models\DatosBasicos', 'candidato_id', 'user_id');
    }

}
