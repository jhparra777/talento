<?php

namespace App\Models;

use App\Models\ClausulaValorCargo;
use App\Models\ClausulaValorRequerimiento;

use Illuminate\Database\Eloquent\Model;

class CargoDocumentoAdicional extends Model
{
    //
    protected $table    = 'cargos_documentos_adicionales';
    protected $fillable = [
        "id",
        "cargo_id",
        "adicional_id",
        "active"
    ];

    public function adicional()
    {
        return $this->belongsTo('App\Models\DocumentoAdicional', 'adicional_id', 'id');
    }

    public function variableCargo()
    {
    	return ClausulaValorCargo::where('cargo_id', $this->cargo_id)->where('adicional_id', $this->adicional_id)->select('valor')->first();
    }

    public function variableReq($req_id)
    {
        return ClausulaValorRequerimiento::where('req_id', $req_id)->where('adicional_id', $this->adicional_id)->select('valor')->first();
    }
}
