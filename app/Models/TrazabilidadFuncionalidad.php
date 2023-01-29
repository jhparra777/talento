<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrazabilidadFuncionalidad extends Model
{
    //
    protected $table    = 'trazabilidad_funcionalidades';
    protected $fillable = [
    	'id',
    	'control_id',
    	'tipo_funcionalidad',
    	'user_gestion',
        'req_id',
    	'empresa',
    	'descripcion'
    ];

    public function usuarioRegistro()
    {
        $user     = new User();
        $registro = $this->hasOne("App\Models\User", "id", "user_gestion")->first();
        if ($registro != null) {
            $user = $registro;
        }
        return $user;
    }
}
