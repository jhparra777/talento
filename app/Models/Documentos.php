<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentos extends Model
{

    protected $table    = 'documentos';
    protected $fillable = ['id',
        'numero_id',
        'user_id',
        'tipo_documento_id',
        'nombre_archivo',
        'nombre_archivo_real',
        'descripcion_archivo',
        'fecha_afiliacion',
        'fecha_realizacion',
        'fecha_vencimiento',
        'observacion',
        'resultado',
        'active',
        'created_at',
        'updated_at',
        'requerimiento',
        'gestiono'];

    public function getDocumento()
    {
        return $this->hasOne("App\Models\TipoDocumento", "tipo_documento_id", "id")->first();
    }

    public function certificado()
    {
        return $this->hasOne("App\Models\Certificado", "documento_id");
    }

    public function usuarioGestiono()
    {
        return $this->belongsTo("App\Models\User", "gestiono", "id");
    }
}
