<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotivoRequerimiento extends Model
{

    protected $table    = 'motivo_requerimiento';
    protected $fillable = ['id', 'descripcion', 'active'];

    /* Query Scopes */
    public function scopeDescripcion($query, $data)
    {	
    	if( $data->get("descripcion") != "" ){

    		return $query->where("descripcion", "like", "%" . $data->get("descripcion") . "%");

    	}else{

    		return $query;
    	}
    }

    public function scopeActive($query, $data)
    {	
    	if( $data->get("buscar") ){

    		if($data->get("active")){
    			return $query->where('active', 1);
    		}else{
    			return $query->where('active', 0);
    		}
    	}else{

        	return $query->where("active", 1);
    	}
    }

}
