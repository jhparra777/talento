<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NegocioANS extends Model
{

    protected $table    = 'negocio_ans';
    protected $fillable = [
    	'id', 
    	"vacantes_inicio", 
    	"vacante_fin", 
    	"negocio_id", 
    	"cantidad_dias",
    	"regla",
    	"num_cand_presentar_vac",
    	"dias_presentar_candidatos_antes","cargo_especifico_id"
    ];

    public function negocio(){
        return $this->belongsTo("App\Models\Negocio");
    }

}
