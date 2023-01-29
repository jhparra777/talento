<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargaReclutadores extends Model
{

    protected $table    = 'carga_reclutadores';
    protected $fillable = [
        'id',
        'cedula',
        'nombre',
        'apellidos',
        'celular',
        'tel_fijo',
        'reclutador_id',
        'lote',
        'gestionado',
        'created_at',
        'updated_at'];

}
