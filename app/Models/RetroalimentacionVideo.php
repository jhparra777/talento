<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class RetroalimentacionVideo extends Model
{
    protected $table = 'retroalimentacion_video';
    protected $fillable = [
    	'candidato_id',
    	'req_id',
    	'cand_req_id',
    	'gestiona',
    	'nombre_archivo',
    	'quien_envia',
    	'fecha_enviado',
        'observacion',
    ];

    public function usuario_gestiono() {
    	$usuario_gestiona = DB::table("users")->select('name')->find($this->gestiona);

    	return $usuario_gestiona->name;
    }

    public function nombre_usuario_envio() {
    	$usuario_envio = DB::table("users")->select('name')->find($this->quien_envia);
    	if($usuario_envio != null) {
    		return $usuario_envio->name;
    	}
    	return null;
    }

    public function fecha_grabado() {
    	return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function ultima_fecha_envio() {
    	if ($this->fecha_enviado != null) {
    		return Carbon::parse($this->fecha_enviado)->format('Y-m-d');
    	}
    	return null;
    }
}
