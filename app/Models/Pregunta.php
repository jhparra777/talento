<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table    = 'preguntas';
    protected $fillable = [
        'id',
        "cargo_especifico_id",
        "requerimiento_id",
        "tipo_id",
        "descripcion",
        "peso_porcentual",
        "filtro",
        "activo",
        "created_at",
        "updated_at",
    ];

    //Retorna las respuestas de cada pregunta asociado al requerimiento
    public function respuestas_pregunta()
    {
        $respuestas = Respuesta::join('preguntas', 'preguntas.id', '=', 'respuestas.preg_id')
        ->where('respuestas.preg_id', $this->id)
        ->select(
            'respuestas.id as id',
            'respuestas.descripcion_resp as descripcion'
        )
        ->get();

        return $respuestas;
    }

    //  FUNCION PARA HACER EL CALCULO DE LAS RESPUESTAS DE LOS CANDIDATOS
    public function respuestas()
    {
	   $respuestas_user = PregReqResp::join('users', 'users.id', '=', 'preg_req_resp.user_id')
        ->where('preg_req_resp.preg_req_id', $this->req_pregu_id)
        ->select(
        	'preg_req_resp.*',
        	'users.name as nombre_usuario',
        	'users.id as id',
        	DB::raw('SUM(preg_req_resp.puntuacion) as punt_can')
        )
        ->groupBy('preg_req_resp.user_id')
        ->orderBy('punt_can', 'DESC')
        ->get();

        return $respuestas_user;
    }

    public static function respuestas_candidato_static($user_id, $pregunta_id)
    {
        $result = 0;

        $respuestas = PregReqResp::join('preguntas', 'preguntas.id', '=', 'preg_req_resp.preg_id')
        ->where('preguntas.id', $pregunta_id)
        ->where('preg_req_resp.user_id', $user_id)
        ->count();

        $result = $respuestas;

        if($result <= 0){
            return 0;
        }else{
            return $result;
        }
    }

    public static function respuestas_candidato_lista($user_id, $pregunta_id)
    {
        $respuestas = PregReqResp::join('preguntas', 'preguntas.id', '=', 'preg_req_resp.preg_id')
        ->where('preguntas.id', $pregunta_id)
        ->where('preg_req_resp.user_id', $user_id)
        ->select(
            'preg_req_resp.*'
        )
        ->get();

        if(count($respuestas) <= 0){
            return null;
        }

        return $respuestas;
    }
}
