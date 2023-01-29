<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class ObservacionesHv extends Model
{
    protected $table    = 'observaciones_hoja_vida';
    
    protected $fillable = ['candidato_id','observacion', 'motivo_descarte_id', "user_gestion", "created_at", "updated_at"];

    /*public function UltimaVista()
    {
	    $user = User::select('name')->where('id',$this->ultima_vista)->first();
                //dd($proceso);//funcion q retorna el nombre de la ciudad
        return $user['name'];//retornar arreglo con campo
    }*/

    public function motivo_descarte() {
    	$motivo = null;
    	if ($this->motivo_descarte_id != null) {
    		$motivo = $this->belongsTo('App\Models\MotivoDescarteCandidato', 'motivo_descarte_id', 'id');
    	}
    	return $motivo;
    }
}
