<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreliminarTranversalesCandidato extends Model
{
    protected $table    = 'preliminar_transversales_candidato';
    protected $fillable = [
    	'id', 'candidato_id', 'realizo_id', 'transversal_id', 'req_id', 'puntuacion', 'estado', 'resultado', 'descripcion_candidato'
    ];

    /**
     * Verificar si el candidato ya se le realizo el informe preliminar, para validar boton y enviar información si se realizo
     **/
     public static function realizoInformePreliminar($user_id = null, $req_id = null)
     {
     	//Validar si el candidato se le realizo informe preliminar en el requerimiento actual
     	$informepreliminar = PreliminarTranversalesCandidato::
     		where("candidato_id", $user_id)
     		->where("req_id", $req_id)
     		->get();

     	//Si el candidato cuenta con informe preliminar se almacena la data para realizar un UPDATE
     	if($informepreliminar->count() >= 1){
     		return $informepreliminar;
     	}else{
     		return "";
     	}
     }

     /**
      * Mostrar calificación que se le realizo al candidato de las transversales
      **/
     public static function nombreTransversales($candidato_id = null, $req_id = null, $transversal_id = null)
     {
        $calificacion = PreliminarTranversalesCandidato::join("criterios_competencias","criterios_competencias.valor","=","preliminar_transversales_candidato.puntuacion")
            //select("puntuacion")
            ->where("candidato_id", $candidato_id)
            ->where("req_id", $req_id)
            ->where("transversal_id", $transversal_id)
            ->select("criterios_competencias.descripcion as puntuacion")
            ->first();
            //dd($calificacion);

        if($calificacion === null){
            return "";
        }else{
            return $calificacion->puntuacion;
        }

     }

     /**
      * Calcular si la persona se ajusta a lo IDEAL o sobrepasa lo IDEAL
      **/
     public static function ideal($candidato_id = null, $req_id = null, $transversal_id = null, $idealCalifiacion = null)
     {
        $ideal = PreliminarTranversalesCandidato::
            where("candidato_id", $candidato_id)
            ->where("req_id", $req_id)
            ->where("transversal_id", $transversal_id)
            ->first();

        $calificacionCandidato = $ideal->puntuacion - $idealCalifiacion;

        return $calificacionCandidato;
     }

     /**
      * Calcular el ajuste del perfil con la puntuacion ideal
      **/
     public static function calcularIdeal($candidato_id = null, $req_id = null, $transversal_id = null, $idealCalifiacion = null)
     {
         $cantidadCalificaciones = collect(DB::table('informe_preliminar')
            ->where('req_id', $req_id)
            ->where('id', $transversal_id)
            ->where('candidato_id', $candidato_id)
            ->groupBy('candidato_id')
            ->groupBy('ideal')
            ->select(\DB::raw('COUNT(ideal) as cantidad, CONCAT(candidato_id, "|",ideal) as candidato'),'req_id','ideal')
            ->get());
        //dd($cantidadCalificaciones);
     }

}
