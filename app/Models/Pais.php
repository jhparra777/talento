<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{

    protected $table = 'paises';
    protected $fillable = ['id', "nombre", "cod_pais"];

    public function departamentos()
    {
    	return $this->hasMany('App\Models\Departamento',"cod_departamento","cod_departamento");
    	//return $this->hasMany(Departamento::class);
    }

    public function ciudades()
    {
    	 return $this->hasManyThrough(
            'App\Models\Ciudad',
            'App\Models\Departamento',
            'cod_pais', 
            'cod_departamento', 
            'cod_departamento', 
            'id_ciudad' 
        );
        //return $this->hasManyThrough('App\Models\Ciudad',"cod_pais","cod_pais");
        //return $this->hasManyThrough(Ciudad::class, Departamento::class);
        //return $this->hasManyThrough('App\Models\Ciudad',"cod_departamento","cod_departamento", 'App\Models\Departamentos',"cod_pais","cod_pais");

    }

}
