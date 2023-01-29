<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{

    protected $table    = 'tipos_documentos';
    protected $fillable = ['id', "cod_tipo_doc", "descripcion", "codigo", "active", "categoria", "estado", "carga_candidato"];
    public $timestamps  = false;

    public function fullEstado()
    {
        $estado = "";

        switch ($this->active) {
            case 1:
                $estado = "Activo";
                break;
            case 0:
                $estado = "Inactivo";
                break;
        }
        return $estado;
    }

    public function documentoFamiliar()
    {
        return $this->hasMany('App\Models\DocumentoFamiliar');
    }

    public function categorias() {
        return $this->belongsTo('App\Models\CategoriaDocumento', 'categoria', 'id');
    }

    public function cargos(){
       return $this->belongsToMany('App\Models\CargoEspecifico', 'cargo_documento','tipo_documento_id','cargo_especifico_id');
    }
}
