<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use DB;

class EntrevistaMultiple extends Model
{
    protected $table    = 'entrevista_multiple';
    
    protected $fillable = [
    	"titulo", "descripcion", "req_id", "concepto_general", "usuario_envio",
    ];

    public function entrevista_multiple_detalles() {
        return $this->hasMany('App\Models\EntrevistaMultipleDetalles', 'entrevista_multiple_id', 'id');
    }

    public function requerimiento() {
        return $this->belongsTo('App\Models\Requerimiento', 'req_id', 'id');
    }

    public function fecha() {
    	return Carbon::parse($this->created_at)->format('Y-m-d');
    }

    public function nombre_usuario_envio() {
    	$usuario_envio = DB::table("users")->select('name')->find($this->usuario_envio);

    	return $usuario_envio->name;
    }
}
