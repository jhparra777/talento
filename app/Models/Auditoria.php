<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auditoria extends Model
{

    protected $table    = 'auditoria';
    protected $fillable = ['id', "tabla_id", "tabla", "valor_antes", "valor_despues", "user_id", "tipo", "observaciones", "motivo_rechazo_id"];

    public function gestiono() {
    	return $this->hasOne("App\Models\DatosBasicos", "id", "user_id")->first();
    }

}
