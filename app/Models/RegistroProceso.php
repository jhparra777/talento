<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\PruebaExcelRespuestaUser;
use App\Models\PruebaValoresRespuestas;

class RegistroProceso extends Model
{

    protected $table    = 'procesos_candidato_req';
    protected $fillable = [
        'id',
        'requerimiento_candidato_id',
        'created_at',
        'updated_at',
        'centro_costos',
        'estado',
        'proceso',
        'fecha_inicio',
        'fecha_fin',
        'usuario_envio',
        'requerimiento_id',
        'candidato_id',
        'usuario_terminacion',
        'apto',
        'numero_contrato',
        'fecha_contrato',
        'fecha_inicio_contrato',
        'fecha_fin_contrato',
        'observaciones',
        'motivo_rechazo_id',
        'user_autorizacion',
        'fecha_solicitud_ingreso',
        'fecha_real_ingreso',
        'hora_entrada',
        'lugar_contacto',
        'otros_devengos',
        'fecha_ingreso_contra',
        'salario',
        'fecha_ultimo_contrato'
    ];


    public function setMotivoRechazoIdAttribute($value)
    {
        if ($value !='') {
            $this->attributes['motivo_rechazo_id'] = $value;
        }else{
            $this->attributes['motivo_rechazo_id'] = null;
        }
    }

    public function usuarioRegistro()
    {
        $user     = new User();
        $registro = $this->hasOne("App\Models\User", "id", "usuario_envio")->first();
        if ($registro != null) {
            $user = $registro;
        }
        return $user;
    }
    public function usuarioTerminacion()
    {
        $user     = new User();
        $registro = $this->hasOne("App\Models\User", "id", "usuario_terminacion")->first();
        if ($registro != null) {
            $user = $registro;
        }
        return $user;
    }

    public function datosBasicosCandidato() {
        return $this->belongsTo('App\Models\DatosBasicos', 'candidato_id', 'user_id');
    }

    public function datosBasicosUsuarioEnvio() {
        return $this->belongsTo('App\Models\DatosBasicos', 'usuario_envio', 'user_id');
    }

    public function respuestaPruebaExcelUser($tipo) {
        $respuesta_user = PruebaExcelRespuestaUser::where('tipo', $tipo)->where('user_id', $this->candidato_id)->where('req_id', $this->requerimiento_id)->first();

        return $respuesta_user;
    }

    public function respuestaPruebaEthicalValue() {
        $respuesta_user = PruebaValoresRespuestas::where('user_id', $this->candidato_id)->where('req_id', $this->requerimiento_id)->first();

        return $respuesta_user;
    }
}
