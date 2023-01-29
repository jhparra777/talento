<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferenciasPersonales extends Model
{

    protected $table    = 'referencias_personales';
    protected $fillable = ['id',
        'numero_id',
        'user_id',
        'nombres',
        'primer_apellido',
        'segundo_apellido',
        'tipo_relacion_id',
        'telefono_movil',
        'telefono_fijo',
        'codigo_pais',
        'codigo_departamento',
        'codigo_ciudad',
        'ocupacion',
        'active',
        'created_at',
        'updated_at'];

    public function getRequerimientos()
    {

        return $this->hasMany("App\Models\ReferenciaPersonalVerificada", "referencia_personal_id", "id")->join("proceso_requerimiento", "proceso_requerimiento.entidad_id", "=", "ref_personales_verificada.id")
            ->where("proceso_requerimiento.tipo_entidad", "MODULO_REFERENCIACION")
            ->where("proceso_requerimiento.proceso_adicional", "REFERENCIA_PERSONAL")
            ->groupBy("proceso_requerimiento.requerimiento_id")
            ->get();
    }

    public function tipo_relacion()
    {
      return $this->belongsTo("App\Models\TipoRelacion", "tipo_relacion_id", "id");
    }

}
