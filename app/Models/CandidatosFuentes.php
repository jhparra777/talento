<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DatosBasicos;

class CandidatosFuentes extends Model
{

    protected $table    = 'candidatos_otras_fuentes';
    protected $fillable = [
        'id',
        "nombres",
        "cedula",
        "telefono",
        "celular",
        "email",
        "tipo_fuente_id",
        "requerimiento_id",
        "idiomas",
        "estudios",
        "observaciones",
        "empresa",
        "cargo",
        "trayectoria",
        "motivo",
        "reporta",
        "reportan",
        "salario",
        "beneficios",
        "aspiracion",
        "fecha_nacimiento"
    ];

    public function verificaHv()
    {
        $hv = DatosBasicos::where("numero_id", $this->cedula)->first();
        if ($hv == null) {
            return "No";
        }

        return "Si";
    }

    /**
     * Consultar información basica de con la cedula de identificacion
     **/
    public function nombreIdentificacion(){
        $nombre = DatosBasicos::
            select(\DB::raw("CONCAT(nombres,' ',primer_apellido,' ',segundo_apellido) AS nombreUsuario"))
            ->where("numero_id", $this->cedula)
            ->first();

        if ($nombre == null) {
            return "";
        }

        return ucwords(mb_strtolower($nombre->nombreUsuario));
    }

    public function datos_basicos() {
        return $this->belongsTo('App\Models\DatosBasicos', 'cedula', 'numero_id');
    }
}
