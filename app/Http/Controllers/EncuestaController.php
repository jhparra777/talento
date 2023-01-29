<?php

namespace App\Http\Controllers;

use App\Models\Encuesta;
use App\Models\DatosBasicos;
use App\Models\SitioModulo;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Carbon\Carbon;

use Illuminate\Http\Request;

class EncuestaController extends Controller
{
    public function guardar(Request $data)
    {
        try {
            $datos_basicos = DatosBasicos::where('user_id', Sentinel::getUser()->id)->select('nombres','primer_apellido')->first();
            //se guarda encuesta
            $encuesta = new Encuesta();
            $encuesta->user_id              = $this->user->id;
            $encuesta->nombre_admin         = $datos_basicos->nombres ." ". $datos_basicos->primer_apellido;
            $encuesta->satisfecho           = $data->satisfecho;
            $encuesta->ideas                = $data->ideas;
            $encuesta->recomienda           = $data->recomendar;
            $encuesta->nombre_recomendado   = $data->nombre;
            $encuesta->telefono_recomendado = $data->telefono;
            
            $encuesta->save();
            session()->put('encuesta_realizada','true');
            return response()->json(['success' => true, 'mensaje' => 'Se ha guardado correctamente la información']);

        } catch (\Exception $e) {
			logger('Excepción capturada EncuestaController@guardar: '.  $e->getMessage(). "\n");
			return response()->json(['success' => false, 'mensaje' => 'Ha ocurrido un error procesando la información']);
		}
    }

    public function presenta_encuesta(Request $data)
    {
        try {

            $esta_habilitada = $sitio_modulo = SitioModulo::first();
            if($esta_habilitada->encuesta_comercial == 'disabled') {
                session()->put('encuesta_realizada','true');
                return response()->json(['success' => true, 'lleno' => true]);
            }
            
            $datos_admin = Encuesta::where('user_id', '=', $this->user->id)->first();
            
            if ($datos_admin == null) {
                session()->put('encuesta_realizada','false');
                return response()->json(['success' => true, 'lleno' => false]);
            }else{
                session()->put('encuesta_realizada','true');
                return response()->json(['success' => true, 'lleno' => true]);
            }

        } catch (\Exception $e) {
			logger('Excepción capturada EncuestaController@presenta_encuesta: '.  $e->getMessage(). "\n");
			return response()->json(['success' => false, 'mensaje' => 'Ha ocurrido un error procesando la información']);
		} 
    }

    public function presenta_encuesta_timer(Request $data)
    {
        try {
            //verificamos si esta deshabilitada
            $esta_habilitada = $sitio_modulo = SitioModulo::first();
            if($esta_habilitada->encuesta_comercial == 'disabled') {
                session()->put('encuesta_realizada','true');
                return response()->json(['success' => true, 'lleno' => true]);
            }

            //si tiene session se venció se cancela busqueda
            if(empty($this->user->id)) {
                return response()->json(['success' => true, 'lleno' => true]);
            }
            
            $fecha_hora_actual = Carbon::now();
            $fecha_timer = session('fecha_timer_encuesta');
            $realizo = session('encuesta_realizada');

            $tiempo_solicitud = 10;
            
            if (session('encuesta_realizada') == 'true') {
                return response()->json(['success' => true, 'lleno' => true]);
            }
            //si paso el tiempo estipulado 
            if ($fecha_hora_actual >= $fecha_timer) {
                if ($realizo == "false") {
                    session()->put('fecha_timer_encuesta',Carbon::now()->addMinutes($tiempo_solicitud));
                    return response()->json(['success' => true, 'lleno' => false]);                    
                }else{
                    return response()->json(['success' => true, 'lleno' => true]);
                }
            }else{
                return response()->json(['success' => true, 'lleno' => "sigan"]);
            }

        } catch (\Exception $e) {
			logger('Excepción capturada EncuestaController@presenta_encuesta_timer: '.  $e->getMessage(). "\n");
			return response()->json(['success' => false, 'mensaje' => 'Ha ocurrido un error procesando la información']);
		} 
    }
}
