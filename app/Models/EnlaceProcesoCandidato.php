<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnlaceProcesoCandidato extends Model
{
    protected $table    = 'enlaces_procesos_candidato';
    protected $guarded 	= ['id'];

    public function ruta($candidato_id = null, $req_id = null, $proceso_id = null)
    {
    	if ($this->parametros_url == 'SI') {
    		$parametros_url = [];
    		if ($this->candidato_id_url == 'SI') {
    			$parametros_url = $parametros_url + ['user_id' => $candidato_id];
    		}
    		if ($this->req_id_url == 'SI') {
    			$parametros_url = $parametros_url + ['req_id' => $req_id];
    		}
    		if ($this->proceso_id_url == 'SI') {
    			$parametros_url = $parametros_url + ['ref_id' => $proceso_id];
    		}
    		return route($this->url, $parametros_url);
    	}
    	return route($this->url);
    }
}
