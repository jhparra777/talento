<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{

    protected $table    = 'departamentos';
    protected $fillable = ['id', "nombre", "cod_pais", "cod_departamento", "homologa_id"];


    public function ciudades(){
        return $this->hasMany('App\Models\Ciudad',"cod_departamento","cod_departamento");
        //return $this->hasMany(Ciudad::class);
    }

    public function pais()
    {
    	return $this->belongsTo('App\Models\Pais',"cod_pais","cod_pais");
    	//return $this->belongsTo(Pais::class);
    }

}
