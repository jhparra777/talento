<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\TipoPregunta;
use App\Models\ReqPreg;
use App\Models\PregReqResp;
use App\Models\PreguntaPrecargada;
use App\Models\Requerimiento;
use App\Models\OfertaUser;
use App\Models\DatosBasicos;
use App\Http\Controllers\Controller;

class PreguntaController extends Controller
{
    public function definir_cantidad_preguntas(Request $data)
    {
        $cargo_id = $data->cargo_id;
        $req_id = $data->req_id;

        $cantidad_preguntas = Requerimiento::where('id', $req_id)->pluck('preguntas_oferta');

        $preguntas_porcentaje = Pregunta::whereNotIn('tipo_id', [3, 4])
        ->where('requerimiento_id', $req_id)
        ->where('filtro', 0)
        ->get();

        $definir_preguntas = true;

        return view("admin.ofertas.crear_pregunta", compact(
            "cargo_id",
            "req_id",
            "cantidad_preguntas",
            "preguntas_porcentaje",
            "definir_preguntas"
        ));
    }

    public function crearPreg(Request $data)
    {
        $cargo_id = $data->cargo_id;
        $req_id = $data->req_id;

        $count_preguntas_definidas = Requerimiento::where('id', $req_id)->pluck('preguntas_oferta');
        if($count_preguntas_definidas == "" || $count_preguntas_definidas == null){
            return response()->json(["no_definidas" => true]);
        }

        $tipo_pregunta = ["" => "Seleccionar"] + TipoPregunta::pluck("descripcion", "id")
        //->except([1, 2, 4])
        ->except([4])
        ->toArray();

        return view("admin.ofertas.crear_pregunta", compact("cargo_id", "req_id", "tipo_pregunta"));
    }

    public function editarPreg(Request $data)
    {
        $pregunta_id = $data->pregunta_id;

        $tipo_pregunta = ["" => "Seleccionar"] + TipoPregunta::pluck("descripcion", "id")
        //->except([1, 2, 4])
        ->except([4])
        ->toArray();

        $pregunta = Pregunta::where('id', $pregunta_id)->first();

        $opciones_pregunta = Respuesta::where('preg_id', $pregunta_id)->get();

        return view("admin.ofertas.editar_pregunta_oferta", compact(
            'pregunta_id',
            'tipo_pregunta',
            'pregunta',
            'opciones_pregunta'
        ));
    }

    public function actualizarPreg(Request $data)
    {
        $this->validate($data, [
            'descripcion' => 'required'
        ]);

        $pregunta_id = $data->pregunta_id;
        $pregunta = Pregunta::find($pregunta_id);

        $pregunta->fill([
            "descripcion" => $data->get('descripcion')
        ]);
        $pregunta->save();

        //Valida si es pregunta con opciones de respuesta
        if ($pregunta->tipo_id == 1 || $pregunta->tipo_id == 2) {
            $ids_opciones = $data->opcion_id;
            $campos_opciones = $data->nueva_opcion;
            $campos_porcentajes = $data->nuevo_porcentaje;

            if(!empty($campos_opciones) || !empty($campos_porcentajes)) {
                foreach ($campos_opciones as $index => $opcion) {
                    //Multiple única respuesta
                    if($pregunta->tipo_id == 2){
                        $pregunta_respuesta = Respuesta::where('id', $ids_opciones[$index])->first();

                        //Si la pregunta es filtro, entonces guarda la/s opciones correctas
                        if($pregunta->filtro == 1) {
                            $pregunta_respuesta->fill([
                                "descripcion_resp" => $opcion,
                                "puntuacion"       => $campos_porcentajes[$index],
                                "minimo"           => @$data->nuevo_filtro[$index] //El @ es para que no de warning de undefined offset con el array
                            ]);
                        }else {
                            $pregunta_respuesta->fill([
                                "descripcion_resp" => $opcion,
                                "puntuacion"       => $campos_porcentajes[$index],
                                "minimo"           => 1
                            ]);
                        }

                        $pregunta_respuesta->save();
                    }else{
                        $pregunta_respuesta = Respuesta::where('id', $ids_opciones[$index])->first();

                        $pregunta_respuesta->fill([
                            "descripcion_resp" => $opcion,
                            "puntuacion"       => $campos_porcentajes[$index],
                        ]);
                        $pregunta_respuesta->save();
                    }
                }
            }
        }

        /*if($data->peso_porcentual_pregunta != "" || $data->peso_porcentual_pregunta != null){
            $pregunta->peso_porcentual = $data->peso_porcentual_pregunta;
            $pregunta->save();
        }*/

        return response()->json(["success" => true]);
    }

    public function eliminarRespuestaPreg(Request $data)
    {
        $respuesta_eliminada = Respuesta::find($data->resp_id);
        $respuesta_eliminada->delete();

        return response()->json(["success" => true]);
    }

    public function guardar_pregunta_cargo(Request $data)
    {
        $this->validate($data, [
            'descripcion'       => 'required',
            'tipo_id'           => 'required'
        ]);

        $req_id = $data->req_id;

        //Si es pregunta abierta no valida, si es filtro no valida
        if($data->tipo_id == 3 || $data->has('filtro')) {
        }else{
            //Validar porcentaje de preguntas
            $preguntas_porcentaje = Pregunta::whereNotIn('tipo_id', [3, 4])
            ->where('requerimiento_id', $req_id)
            ->where('filtro', 0)
            ->get();

            $total_porcentaje = 0;
            foreach ($preguntas_porcentaje as $pregunta) {
                $total_porcentaje = $total_porcentaje + $pregunta->peso_porcentual;
            }

            if($total_porcentaje >= 100){
                return response()->json(["limite_porcentaje" => true]);
            }

            $count_preguntas_definidas = Requerimiento::where('id', $data->req_id)->pluck('preguntas_oferta');

            if($count_preguntas_definidas == "" || $count_preguntas_definidas == null){
                return response()->json(["no_definidas" => true]);
            }

            $count_preguntas = Pregunta::whereNotIn('tipo_id', [3, 4])
            ->where('requerimiento_id', $data->req_id)
            ->where('filtro', 0)
            ->count();

            if($count_preguntas == $count_preguntas_definidas || $count_preguntas >= $count_preguntas_definidas){
                return response()->json(["limite" => true]);
            }
        }

        $nueva_pregunta = new Pregunta();

        $nueva_pregunta->fill([
            "descripcion"         => $data->get('descripcion'),
            //"cargo_especifico_id" => $data->cargo_id,
            "requerimiento_id"    => $data->req_id,
            "tipo_id"             => $data->tipo_id,
            "filtro"              => (isset($data->filtro)) ? 1 : 0,
            "activo"              => 1,
        ]);
        $nueva_pregunta->save();

        if($data->peso_porcentual_pregunta != "" || $data->peso_porcentual_pregunta != null){
            $nueva_pregunta->peso_porcentual = $data->peso_porcentual_pregunta;
            $nueva_pregunta->save();
        }

        $cantidad_opciones = $data->cantidad_opciones;
        
        $nuevas_opciones = $data->nueva_opcion;
        $nuevos_porcentajes = $data->nuevo_porcentaje;

        if($nuevas_opciones != null || $nuevas_opciones != '' || $nuevos_porcentajes != null || $nuevos_porcentajes != '') {
            foreach ($nuevas_opciones as $index => $opcion) {
                //Multiple única respuesta
                if($data->tipo_id == 2){
                    $nueva_respuesta = new Respuesta();

                    if(isset($data->filtro)) {
                        $nueva_respuesta->fill([
                            "descripcion_resp" => $opcion,
                            "preg_id"          => $nueva_pregunta->id,
                            "puntuacion"       => $nuevos_porcentajes[$index],
                            "minimo"           => @$data->nuevo_filtro[$index] //El @ es para que no de warning de undefined offset con el array
                        ]);
                    }else {
                        $nueva_respuesta->fill([
                            "descripcion_resp" => $opcion,
                            "preg_id"          => $nueva_pregunta->id,
                            "puntuacion"       => $nuevos_porcentajes[$index],
                            "minimo"           => 1
                        ]);
                    }

                    $nueva_respuesta->save();
                }else{
                    $nueva_respuesta = new Respuesta();

                    $nueva_respuesta->fill([
                        "descripcion_resp" => $opcion,
                        "preg_id"          => $nueva_pregunta->id,
                        "puntuacion"       => $nuevos_porcentajes[$index],
                    ]);
                    $nueva_respuesta->save();
                }
            }
        }

        return response()->json(["success" => true]);
    }

    //
    public function guardar_pregunta(Request $data)
    {
        $this->validate($data, [
            'descripcion'       => 'required',
            'tipo_id'           => 'required',
            //'descripcion_resp[]'  => 'required',
        ]);

        $nueva_pregunta = new Pregunta();
        
        $nueva_pregunta->fill([
            "descripcion"       => $data->get('descripcion'),
            "tipo_id"           => $data->get('tipo_id'),
            "filtro"            => $data->get('filtro'),
        ]);
        $nueva_pregunta->save();

        $numero_respuestas = 0;

        foreach ($data->descripcion_resp as $key => $respu) {               
            $numero_respuestas =++ $key;
        }
        
        $puntaje = 100/$numero_respuestas;

        foreach ($data->descripcion_resp as $key => $respu) {
            if ($respu != "") {
                if ($key == $data->minimo ) {
                    $nueva_respuesta = new Respuesta();
                    
                    $nueva_respuesta->fill([
                        "descripcion_resp"      => $respu,
                        "preg_id"               => $nueva_pregunta->id,
                        "minimo"                => 1,
                        "puntuacion"            => $puntaje *(++$key),
                    ]);
                    $nueva_respuesta->save();
                }else {
                    $nueva_respuesta = new Respuesta();
                    
                    $nueva_respuesta->fill([
                        "descripcion_resp"      => $respu,
                        "preg_id"               => $nueva_pregunta->id,
                        "minimo"                => '',
                        "puntuacion"            => $puntaje *(++$key),
                    ]);
                    $nueva_respuesta->save();
                }
            }
        }

        $preguntas_reqs = Pregunta::join('tipo_pregunta','tipo_pregunta.id','=','preguntas.tipo_id')
        ->select('preguntas.id as req_preg_id','preguntas.*','tipo_pregunta.descripcion as descr_tipo_p')
        ->where('preguntas.id',$nueva_pregunta->id)
        ->orderBy('preguntas.id','asc')
        ->first();

        $respuestas = Respuesta::where('respuestas.req_preg_id',$nueva_pregunta->id)
        ->select('respuestas.descripcion_resp as des')
        ->get();

        return response()->json(["success" => true,"rs" => $preguntas_reqs,"respuestas"=>$respuestas]);
    }

    public function verRanking(Request $data)
    {
        $req_id = $data->req_id;
        $cargo_id = $data->cargo_id;

        $resultados_candidatos = PregReqResp::join('preguntas', 'preguntas.id', '=', 'preg_req_resp.preg_id')
        ->join('datos_basicos', 'datos_basicos.user_id', '=', 'preg_req_resp.user_id')
        ->leftjoin('resultados_generales_aplica', 'resultados_generales_aplica.user_id', '=', 'datos_basicos.user_id')
        ->where('preg_req_resp.req_id', $req_id)
        ->where('preg_req_resp.cargo_especifico_id', $cargo_id)
        
        ->where('resultados_generales_aplica.req_id', $req_id)
        ->where('resultados_generales_aplica.cargo_id', $cargo_id)

        ->whereNotIn('preguntas.tipo_id', [3, 4])
        ->select(
            'preg_req_resp.*',

            'datos_basicos.user_id as user_id',
            \DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo"),

            'resultados_generales_aplica.total_global',

            'resultados_generales_aplica.cargo_id as cargo_id'
        )
        ->orderBy('resultados_generales_aplica.total_global', 'DESC')
        ->groupBy('preg_req_resp.user_id')
        ->get();

        $preguntas = Pregunta::whereNotIn('tipo_id', [3, 4])
        ->where('requerimiento_id', $req_id)
        ->where('filtro', 0)
        ->orderBy('id', 'ASC')
        ->get();

        return view("admin.ofertas.ver_ranking", compact("resultados_candidatos", "preguntas", "req_id"));
    }

    public function verRespuestas(Request $data)
    {
        $req_id = $data->req_id;
        $cargo_id = $data->cargo_id;

        $respuestas_x_candidato = OfertaUser::join('datos_basicos', 'datos_basicos.user_id', '=', 'ofertas_users.user_id')
        ->join('requerimientos', 'requerimientos.id', '=', 'ofertas_users.requerimiento_id')
        ->where('ofertas_users.requerimiento_id', $req_id)
        ->where('ofertas_users.aplica', 1)
        ->select(
            'datos_basicos.*',
            \DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo"),

            'ofertas_users.created_at as fecha_aplicacion',

            'requerimientos.cargo_especifico_id as cargo_id'
        )
        ->orderBy('nombre_completo', 'ASC')
        ->get();

        return view("admin.ofertas.ver_respuestas", compact("preguntas_req", "respuestas_x_candidato", "req_id"));
    }

    public function resultados_x_candidato(Request $data)
    {
        $preguntas = Pregunta::where('requerimiento_id', $data->req_id)
        ->orWhere('cargo_especifico_id', $data->cargo_id)
        ->orderBy('filtro', 'DESC')
        ->get();

        $informacion_candidato = DatosBasicos::join('resultados_generales_aplica', 'resultados_generales_aplica.user_id', '=', 'datos_basicos.user_id')
        ->where('datos_basicos.user_id', $data->user_id)
        ->where('resultados_generales_aplica.req_id', $data->req_id)
        ->select(
            \DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo"),

            'resultados_generales_aplica.total_global'
        )
        ->first();

        $req_id = $data->req_id;
        $user_id = $data->user_id;
        $cargo_id = $data->cargo_id;

        return view("admin.ofertas.respuestas_x_candidato", compact('preguntas', 'informacion_candidato', 'req_id', 'user_id', 'cargo_id'));
    }

    public function inactivar_pregunta(Request $data)
    {
        $ae = Pregunta::find($data->preg_id);
        $ae->activo = 0;

        $ae->save();
    }

    public function activar_pregunta(Request $data)
    {
        $ae = Pregunta::find($data->preg_id);
        $ae->activo = 1;

        $ae->save();
    }
    
    public function crearPregPruebaIdioma(Request $data){
        $cargo_id = $data->cargo_id;
        $req_id = $data->req_id;

        $preguntasPre = PreguntaPrecargada::get();

        $preguntaRand = rand(0, count($preguntasPre) - 1);

        return view("admin.ofertas.crear_prueba_idioma", compact(
            "cargo_id",
            "req_id",
            "cliente",
            "negocio",
            "preguntaRand",
            "preguntasPre"
        ));
    }

    public function guardarPregPruebaIdioma(Request $data)
    {
        $this->validate($data, [
            'descripcion'   => 'required',
            'tipo_id'       => 'required',
        ]);

        $nueva_pregunta = new Pregunta();

        $nueva_pregunta->fill([
            "descripcion"         => $data->descripcion,
            "cargo_especifico_id" => $data->cargo_id,
            "tipo_id"             => $data->get('tipo_id'),
            "activo"              => 1,
        ]);

        $nueva_pregunta->save();

        $preguntas_reqs = Pregunta::join('tipo_pregunta','tipo_pregunta.id','=','preguntas.tipo_id')
        ->select(
            'preguntas.id as req_preg_id',
            'preguntas.*',
            'tipo_pregunta.descripcion as descr_tipo_p'
        )
        ->where('preguntas.id', $nueva_pregunta->id)
        ->orderBy('preguntas.id','asc')
        ->first();
    
        return response()->json(["success" => true,"preguntas" => $preguntas_reqs]);
    }
}
