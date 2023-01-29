<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class EntrevistaMultipleDetalles extends Model
{
    protected $table    = 'entrevista_multiple_detalles';
    
    protected $fillable = [
    	"calificacion", "req_id", "req_candi_id", "candidato_id", "concepto", "apto", "gestiono", "entrevista_multiple_id"
    ];

    public function entrevista_multiple() {
    	return $this->belongsTo('App\Models\EntrevistaMultiple', 'entrevista_multiple_id', 'id');
    }

    public function datos_basicos() {
    	return $this->belongsTo('App\Models\DatosBasicos', 'candidato_id', 'user_id');
    }

    public function user() {
    	return $this->belongsTo('App\Models\User', 'candidato_id', 'id');
    }

    public function nombre_usuario_gestiono() {
        $usuario_gestiono = DB::table("users")->select('name')->find($this->gestiono);

        return $usuario_gestiono->name;
    }

    public function getProcesos() {
        $procesos = DB::table("procesos_candidato_req")->where("requerimiento_id", $this->req_id)
        ->where('candidato_id', $this->candidato_id)
        ->orderBy("procesos_candidato_req.id", "asc")
        ->groupBy("procesos_candidato_req.id")
        ->get();

        if ($procesos == null) {
            $procesos=array();
        }

        return $procesos;
    }
}
