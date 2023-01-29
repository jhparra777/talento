<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PruebaExcelRespuestaUser extends Model
{
    protected $table    = 'prueba_excel_respuestas_user';
    protected $fillable = [
        'req_id',
        'user_id',
        'tipo',
        'respuestas_correctas',
        'total_preguntas',
        'concepto_final',
        'gestiono_concepto',
        'fecha_respuesta',
        'fotos'
    ];

    public function requerimiento() {
        return $this->belongsTo('App\Models\Requerimiento', 'req_id', 'id');
    }

    public function getRespuestasExcel(){
        if ($this->tipo == 'basico') {
            return $this->hasMany('App\Models\PruebaExcelRespuestaBasico', 'respuesta_user_id', 'id');
        } else if ($this->tipo == 'intermedio') {
            return $this->hasMany('App\Models\PruebaExcelRespuestaIntermedio', 'respuesta_user_id', 'id');
        }
        return null;
    }

    public function datosBasicosUsuarioConcepto() {
        return $this->belongsTo('App\Models\DatosBasicos', 'gestiono_concepto', 'user_id');
    }

    public function configuracionReq() {
        return $this->hasOne('App\Models\PruebaExcelConfiguracion', 'req_id', 'req_id');
    }

    public function calcularCalificacion() {
        $calificacion = 0;
        if ($this->total_preguntas > 0) {
            $calificacion = $this->respuestas_correctas * 100 / $this->total_preguntas;
        }
        return $calificacion;
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
