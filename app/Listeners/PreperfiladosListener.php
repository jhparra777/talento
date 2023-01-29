<?php

namespace App\Listeners;

use App\Events\PreperfiladosEvent;
use App\Models\Requerimiento;
use App\Models\Preperfilados;
use App\Models\CargoGenerico;
use App\Models\DatosBasicos;
use App\Models\NivelEstudios;
use Illuminate\Support\Facades\DB;


class PreperfiladosListener
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PreperfiladosEvent  $event
     * @return void
     */
    public function handle(PreperfiladosEvent $event)
    {

        
        $cargo=CargoGenerico::find($event->requerimiento->cargo_generico_id);
        $palabras=explode(",",$cargo->palabras_claves);
        $palabras=DB::table("palabras_claves")->select("descripcion")->whereIn("id",$palabras)->pluck("descripcion");

        $nivel_estudio=NivelEstudios::find($event->requerimiento->nivel_estudio);

        $candidatos_cargo_general = DatosBasicos::where(function ($sql) use ($event,$arreglo,$palabras) {

                $sql->whereRaw("(select count(*) from perfilamiento where perfilamiento.user_id=datos_basicos.user_id and perfilamiento.cargo_generico_id=".$event->requerimiento->cargo_generico_id.")>0");
                if(is_array($palabras) && count($palabras)>0){
                    foreach($palabras as $item){
                        $sql->orWhereRaw("( LOWER(datos_basicos.descrip_profesional) like '%" . (strtolower($item)) . "%' COLLATE utf8_general_ci OR (SELECT GROUP_CONCAT(estudios.titulo_obtenido) FROM estudios where estudios.user_id=datos_basicos.user_id) like '%" . (strtolower($item)) . "%' COLLATE utf8_general_ci OR (SELECT GROUP_CONCAT(experiencias.funciones_logros) FROM experiencias where experiencias.user_id=datos_basicos.user_id) like '%" . (strtolower($item)) . "%' COLLATE utf8_general_ci)");
                    }
                }
                $sql->orWhereRaw("((SELECT count(requerimiento_cantidato.candidato_id) FROM requerimiento_cantidato INNER JOIN requerimientos ON requerimientos.id=requerimiento_cantidato.requerimiento_id where requerimientos.cargo_generico_id=".$event->requerimiento->cargo_generico_id." and requerimiento_cantidato.candidato_id=datos_basicos.user_id and requerimiento_cantidato.estado_candidato<>".config('conf_aplicacion.C_CONTRATADO').")>0)");


        })
        ->where(function($sql2) use ($event){
            if($event->requerimiento->genero_id!=3 && !is_null($event->requerimiento->genero_id)){
                $sql2->where("datos_basicos.genero",$event->requerimiento->genero_id);
            }
        })
        ->where("datos_basicos.pais_residencia", $event->requerimiento->pais_id)
        ->where("datos_basicos.departamento_residencia", $event->requerimiento->departamento_id)
        ->where("datos_basicos.ciudad_residencia", $event->requerimiento->ciudad_id)
        ->whereNotIn('datos_basicos.estado_reclutamiento', [config('conf_aplicacion.C_BAJA_VOLUNTARIA')])
        ->whereRaw("datos_basicos.user_id not in (select candidato_id from requerimiento_cantidato where requerimiento_id=" . $event->requerimiento->id . " and estado_candidato not in (" . config('conf_aplicacion.C_QUITAR').",".
            config('conf_aplicacion.C_INACTIVO'). "))")

        ->select(
            'datos_basicos.user_id as usuario',
            DB::raw("(IF(YEAR(CURDATE())-YEAR(datos_basicos.fecha_nacimiento) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(datos_basicos.fecha_nacimiento,'%m-%d'), 0 , -1 ) between '".($event->requerimiento->edad_minima>0)? $event->requerimiento->edad_minima : '18'."' and '".($event->requerimiento->edad_maxima>0)? $event->requerimiento->edad_maxima : '80'."',12.5,0))as edad"),
            //DB::raw("(IF(".$event->requerimiento->salario." between aspiracion_salarial.limite_inferior and aspiracion_salarial.limite_superior,12.5,0)) as salario"),
            DB::raw("(IF(".$event->requerimiento->salario." between (select aspiracion_salarial.limite_inferior from aspiracion_salarial where aspiracion_salarial.id=datos_basicos.aspiracion_salarial) and (select aspiracion_salarial.limite_superior from aspiracion_salarial where aspiracion_salarial.id=datos_basicos.aspiracion_salarial),12.5,0)) as salario"),

            
            DB::raw("(IF((select max(niveles_estudios.jerarquia)  from estudios inner join niveles_estudios on niveles_estudios.id=estudios.nivel_estudio_id where estudios.user_id=datos_basicos.user_id)=".($nivel_estudio->jerarquia)? $nivel_estudio->jerarquia: '0'.",25,0)) as estudios")
            
            
            )

            
        ->get();


        $merge=[];

        

        if(count($candidatos_cargo_general)>0){

            foreach($candidatos_cargo_general as $candidato){
                $porcentaje=50+$candidato->edad+$candidato->salario+$candidato->estudios;
                $merge[$candidato->usuario]=["ajuste"=>$porcentaje];

            }

            $event->requerimiento->preperfilados()->sync($merge);

        }
        else{
            $event->requerimiento->preperfilados()->sync($merge);
        }



        $event->requerimiento->preperfilados= $candidatos_cargo_general->count();
        $event->requerimiento->save();
        


    }

}
