<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CitacionCandidato extends Model
{

    protected $table    = 'citacion_candidato';
    protected $fillable = [
        'id', 'user_id', 'user_recepcion', 'id_motivo', 'direccion_cita', 'fecha_cita',
        'hora_cita', 'observaciones', 'estado', 'tipificacion',
    ];

    //Sacar el nombre del motivo por el que se guardo para citacion
    public function getCitacionMotivo()
    {
        $motivo = DB::table("motivo_recepcion")->where("id", $this->id_motivo)
            ->first();

        if ($motivo == null) {
            return "";
        }
        return $motivo->descripcion;
    }

    public function HoraCita()
    {
        $hora = DB::table("franja_horaria")->where("id", $this->hora_cita)->first();
        if ($hora == null) {
            return "";
        }
        return $hora->descripcion;
    }

}
