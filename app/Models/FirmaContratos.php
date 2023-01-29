<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirmaContratos extends Model
{
    protected $table      = 'firma_contratos';
    protected $fillable   = [
    	'user_id',
    	'req_id',
        'req_contrato_cand_id',
    	'firma',
    	'estado',
        'ip',
        'contrato',
        'terminado',
        'fecha_firma',
        'gestion',
        'stand_by',
        'uuid',
        'base_64'
    ];

    /**
     * Consultar si el candidato tiene firmas en contratos
     **/
    public static function firmaContrato($user_id, $req_id)
    {
    	$informacion = Self::where("user_id", $user_id)
        ->where("req_id", $req_id)
        ->first();

        if ($informacion == null) {
            return "";
        }else{
        	return $informacion->firma;
        }
    }
}
