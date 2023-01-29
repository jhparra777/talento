<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    protected $table = 'certificados';

    protected $guarded = ["id"];

    //relationships
    public function certificable()
    {
        return $this->morphTo();
    }

    public function documento()
    {
        return $this->belongsTo('App\Models\Documentos');
    }
}
