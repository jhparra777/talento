<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgenciaUsuario extends Model
{
    //
      protected $table    = 'agencia_usuario';
    protected $fillable = ["id_usuario",'id_agencia'];
}
