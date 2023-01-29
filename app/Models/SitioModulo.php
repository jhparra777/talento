<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ConsentimientosPermisosConfiguracion;
use App\Models\EvaluacionSstConfiguracion;
use App\Models\RequerimientoContratoCandidato;

class SitioModulo extends Model
{
    //
    protected $table    = 'sitio_modulos';
    protected $fillable = [
    	'id', 
    	'consulta_seguridad',
        'listas_vinculantes',
        'prueba_digitacion',
        'prueba_competencias',
        'generador_variable',
        'generador_firma_opcion',
    	'prueba_valores1',
        'clausula_medica',
        'usa_ordenes_medicas',
        'salud_ocupacional',
        'evaluacion_sst',
        'visita_domiciliaria',
        'consulta_tusdatos',
        'notifica_terminacion_contrato',
        'omnisalud'
    ];

    public function configuracionEvaluacionSst() {
        return EvaluacionSstConfiguracion::first();
    }

    public function configuracionConsentimientoPermiso() {
        return ConsentimientosPermisosConfiguracion::first();
    }

    public function tieneContrato() {
        $contrato = RequerimientoContratoCandidato::where('candidato_id', $this->user->id)
            ->orderBy('id', 'desc')
        ->first();

        if (!is_null($contrato)) {
            return 1;
        }
        return 0;
    }
}
