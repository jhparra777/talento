<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestionPrueba extends Model
{

    protected $table    = 'gestion_pruebas';
    protected $fillable = [
        'id',
        'tipo_prueba_id',
        'puntaje',
        'resultado',
        'nombre_archivo',
        'fecha_vencimiento',
        'created_at',
        'updated_at',
        'user_id',
        'estado',
        "candidato_id",
    ];

    public function getRequerimientos()
    {
        return $this->hasMany("App\Models\ProcesoRequerimiento", "entidad_id", "id")->where("tipo_entidad", "MODULO_PRUEBAS")->get();
    }

    public function getRequerimientosActivos($req)
    {
        return $this->hasMany("App\Models\ProcesoRequerimiento", "entidad_id", "id")->where("tipo_entidad", "MODULO_PRUEBAS")->where("requerimiento_id",$req)->where("activo",1)->first();
    }

}
