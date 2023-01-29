<?php

namespace App\Models;

use App\Models\RespuestaPruebaIdioma;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Model;

class PreguntasPruebaIdioma extends Model
{
    //
    protected $table    = 'preguntas_pruebas_idiomas';
    protected $fillable = [
        'id',
        'descripcion',
        'prueba_idio_id',
        'activo',
        'tiempo',
        'created_at',
        'updated_at',
    ];

    public function preguntas_respuestas(){
        $user = Sentinel::getUser();
        $respuestas = RespuestaPruebaIdioma::join('preguntas_pruebas_idiomas','preguntas_pruebas_idiomas.id','=','respuestas_pruebas_idiomas.preg_prueba_id')
        ->where('preguntas_pruebas_idiomas.id',$this->id)
        ->count();

        if($respuestas <= 0){
            return "0";
        }
        else{
            return $respuestas;
        }
    }

    public static function respuestas_candidato_static($user_id, $pregunta_id){
        $result = 0;

        $respuestas = RespuestaPruebaIdioma::join('preguntas_pruebas_idiomas','preguntas_pruebas_idiomas.id','=','respuestas_pruebas_idiomas.preg_prueba_id')
        ->where('preguntas_pruebas_idiomas.id',$pregunta_id)
        ->where('respuestas_pruebas_idiomas.candidato_id',$user_id)
        ->count();

        $result = $respuestas;

        if($result <= 0){
            return 0;
        }else{
            return $result;
        }
    }

}
