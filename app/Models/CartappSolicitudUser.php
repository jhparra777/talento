<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CartappSolicitudUser extends Model
{
    protected $table = 'cartapp_solicitudes_user';

    protected $guarded = ['id'];

    public function requerimiento() {
        return $this->belongsTo('App\Models\Requerimiento', 'requerimiento_id', 'id');
    }

    public function getFotosArray() {
        if ($this->fotos != '') {
            return explode(',', $this->fotos);
        }
        return [];
    }

    public function banco_nomina() {
        return $this->belongsTo('App\Models\BancoNomina', 'banco_nomina_id', 'id');
    }

    public function tipo_cuenta_banco(){
        $tipo = DB::table("tipos_cuentas_banco")
            ->where("tipos_cuentas_banco.id", $this->tipo_cuenta)
        ->first();

        return $tipo;
    }

    public function firma_contrato() {
        return DB::table("firma_contratos")
            ->where('user_id', $this->user_id)
            ->where('req_id', $this->requerimiento_id)
            ->where('estado', 1)
            ->orderBy('created_at', 'DESC')
        ->first();
    }
}
