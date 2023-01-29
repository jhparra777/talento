<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaListaVinculanteAccess extends Model
{
    //
    protected $table    = 'consulta_listas_vinculantes_access';
    protected $fillable = [
        'id',
        'cliente_id'
    ];
}
