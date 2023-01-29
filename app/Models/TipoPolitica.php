<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPolitica extends Model
{   
    protected $table = 'tipos_politicas';

    protected $guarded = ['id'];

    //relationship

    public function politicasPrivacidad()
    {
        return $this->hasMany('App\Models\PoliticasPrivacidad','tipo_politica_id');
    }
}
