<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ConsultaListaVinculante extends Model
{
    //
    protected $table    = 'consulta_listas_vinculantes';
    protected $fillable = [
        'id',
        'user_id',
        'user_gestion',
        'req_id',
        'cliente_id',
        'factor_seguridad',
        'contador',
        'pdf_consulta_file',
    ];

    public function usuarioRegistro()
    {
        $user = new User();
        $registro = $this->hasOne("App\Models\User", "id", "user_gestion")->first();
        if ($registro != null) {
            $user = $registro;
        }
        return $user;
    }
}
