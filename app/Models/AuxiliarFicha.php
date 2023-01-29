<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuxiliarFicha extends Model
{
    protected $table    = 'auxiliar_ficha';
    protected $fillable = ['id', 'ficha_id', 'identificador_entidad', 'valor', 'id_entidad'];
    public $timestamps  = false;
}
