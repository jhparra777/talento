<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class EvaluacionSstRespuestaUser extends Model
{
    protected $table    = 'evaluacion_sst_respuestas_user';
    protected $fillable = [
        'requerimiento_candidato_id',
        'req_id',
        'candidato_id',
        'respuestas_correctas',
        'total_preguntas',
        'puntuacion',
        'fecha_respuesta',
        'respuestas',
        'fotos',
        'firma',
        'attemps'
    ];

    public function requerimiento() {
        return $this->belongsTo('App\Models\Requerimiento', 'req_id', 'id');
    }

    public function getFotosArray() {
        if ($this->fotos != '') {
            return explode(',', $this->fotos);
        }
        return [];
    }

    public function formatoFecha($fecha) {
        setlocale(LC_TIME, 'Spanish');

        $data         = new Carbon($fecha);
        $convertFecha = $data->formatLocalized('%d de %B de %Y');

        return $convertFecha;
    }
}
