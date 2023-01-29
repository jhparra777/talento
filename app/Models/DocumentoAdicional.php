<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\CargoDocumentoAdicional;
use App\Models\ClausulaValorCargo;

class DocumentoAdicional extends Model
{
    //
    protected $table    = 'documentos_adicionales_contrato';
    protected $fillable = [
        "id",
        "descripcion",
        "contenido_clausula",
        "creada",
        "default",
        "opcion_firma",
        "gestion_id",
        "active"
    ];

    public function adicional_cargo($cargo_id)
    {
        return CargoDocumentoAdicional::where('cargo_id', $cargo_id)->where('adicional_id', $this->id)->first();
    }

    public function variableCargo($cargo_id)
    {
    	return ClausulaValorCargo::where('cargo_id', $cargo_id)->where('adicional_id', $this->id)->select('valor')->first();
    }
}
