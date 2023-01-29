<?php

namespace App\Models;
use App\Models\RespuestasEntre;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Eloquent\Model;

class PreguntasEntre extends Model
{
    protected $table    = 'preguntas_entre';

    protected $fillable = [
        "id", "descripcion","entre_vir_id" ,"created_at", "updated_at","activo",
    ];

    public static function respuestas_candidato_static($user_id, $pregunta_id){
        $result = 0;
        
        $respuestas = RespuestasEntre::join('preguntas_entre', 'preguntas_entre.id', '=', 'respuestas_entre.preg_entre_id')
        ->where('preguntas_entre.id', $pregunta_id)
        ->where('respuestas_entre.candidato_id', $user_id)
        ->count();

        $result = $respuestas;

        if ($result <= 0) {
            return 0;
        } else {
            return $result;
        }
    }

    public function respuestas_candidato(){

    	      $user = Sentinel::getUser();
       

         $respuestas = RespuestasEntre::
         join('preguntas_entre','preguntas_entre.id','=','respuestas_entre.preg_entre_id')
         ->where('preguntas_entre.id',$this->id)
         ->where('respuestas_entre.candidato_id',$user->id)
         ->count();
             //dd($respuestas);
           if($respuestas <= 0){
            return "0";
        }
        else{
            return $respuestas;
        }
    }


    public function preguntas_respuestas(){

    	      $user = Sentinel::getUser();
       

         $respuestas = RespuestasEntre::
         join('preguntas_entre','preguntas_entre.id','=','respuestas_entre.preg_entre_id')
         ->where('preguntas_entre.id',$this->id)
         //->where('respuestas_entre.candidato_id',$user->id)
         ->count();
             //dd($respuestas);
           if($respuestas <= 0){
            return "0";
        }
        else{
            return $respuestas;
        }
    }
    
}
