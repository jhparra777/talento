<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\DatosBasicos;

class PruebaBrigResultado extends Model
{
    protected $table      = 'prueba_brig_candidato_resultado';
    protected $fillable   = [
        'req_id',
        'user_id',
        'gestion_id',
        'estilo_radical',
        'estilo_genuino',
        'estilo_garante',
        'estilo_basico',
        'aumented_a',
        'aumented_p',
        'aumented_d',
        'aumented_r',
        'ajuste_perfil',
        'estado',
        'fecha_realizacion'
    ];

    public function solicitadaPor()
    {
        return DatosBasicos::where('user_id', $this->gestion_id)->select('nombres', 'primer_apellido', 'segundo_apellido')->first();
    }
}
