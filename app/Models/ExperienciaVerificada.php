<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExperienciaVerificada extends Model
{

    protected $table    = 'experiencia_verificada';
    protected $fillable = ['candidato_id', 'usuario_gestion',
        'nombre_referenciante',
        'cargo_referenciante',
        'telefono_oficina',
        'ext',
        'celular',
        'observaciones_empresa',
        'observaciones_candidato',
        'meses_laborados',
        'anios_laborados',
        'motivo_retiro_id',
        'observaciones',
        'personas_cargo',
        'cuantas_personas',
        'volver_contratarlo',
        'porque_obj',
        'aspectos_mejorar',
        'direccion_empresa',
        'tipo_contrato',
        'cargo2',
        'fecha_inicio',
        'fecha_retiro',
        'anotacion_hv',
        'cuales_anotacion',
        'vinculo_familiar',
        'vinculo_familiar_cual',
        'adecuado',
        'estado_referencia',
        'observaciones_referencias',
        'experiencia_id',
        'ref_verificada',
        'req_id',
        'empleo_actual',
        'visita_candidato_id'
    ];


    public function experiencia(){
        return $this->belongsTo("App\Models\Experiencias","experiencia_id");
    }

}
