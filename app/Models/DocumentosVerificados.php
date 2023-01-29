<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentosVerificados extends Model
{

    protected $table    = 'documentos_verificados';
    protected $fillable = [
        'tipo_documento_id',
        'nombre_archivo',
        'descripcion_archivo',
        'fecha_vencimiento',
        'user_id',
        'gestion_hv',
        "candidato_id",
        'req_id',
        'documento_id_asociado'
    ];

    public function getRequerimientos()
    {
        return $this->hasMany("App\Models\ProcesoRequerimiento", "entidad_id", "id")->where("tipo_entidad", "MODULO_DOCUMENTO")->get();
    }

}
