<?php

namespace App\Models;

use App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ObservacionesCandidato extends Model
{
    protected $table    = 'observaciones_candidato';
    
    protected $fillable = ['observacion', "user_gestion", "created_at", "updated_at","req_can_id","ultima_vista"];

    public function UltimaVista()
    {
	    $user = User::select('name')->where('id',$this->ultima_vista)->first();
                //dd($proceso);//funcion q retorna el nombre de la ciudad
        return $user['name'];//retornar arreglo con campo
    }

}
