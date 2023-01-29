<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\EnlaceProcesoCandidato;
use App\Models\OfertaUser;
use App\Models\RegistroProceso;
use App\Models\ReqCandidato;
use App\Models\Sitio;

class MisProcesosController extends Controller
{
    public function lista_procesos()
    {
        if(empty($this->user->id)){
            session(["url_deseada_redireccion_candidato" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login');
        }

        //Configuración instancia
        $instanciaConfiguracion = Sitio::first();

        $menu = DB::table("menu_candidato")->where("estado", 1)
        ->orderBy("orden")
        ->select("menu_candidato.*")
        ->get();

        $user_id = $this->user->id;
        $datosBasicos = Sentinel::getUser()->getDatosBasicos();

        //Buscas las ofertas en las ha que estado en proceso en algún momento
        $ofertasCandidato = ReqCandidato::join('requerimientos', 'requerimientos.id', '=', 'requerimiento_cantidato.requerimiento_id')
        ->join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
        ->where('requerimiento_cantidato.candidato_id', $this->user->id)
        ->select(
            'requerimientos.id as req_id',
            'requerimientos.sitio_trabajo',
            'requerimientos.created_at as fecha_publicacion',
            'requerimientos.estado_publico',
            'requerimiento_cantidato.candidato_id as user_id',
            'cargos_especificos.descripcion as oferta_cargo'
        )
        ->orderBy('requerimiento_cantidato.created_at', 'DESC')
        ->paginate(6);

        $requerimiento_ofertas = [];

        foreach ($ofertasCandidato as $oferta) {
            array_push($requerimiento_ofertas, $oferta->req_id);
        }

        $ofertas_aplicadas = OfertaUser::join('requerimientos', 'requerimientos.id', '=', 'ofertas_users.requerimiento_id')
        ->join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
        ->whereNotIn('requerimientos.id', $requerimiento_ofertas)
        ->where('ofertas_users.aplica', 1)
        ->where('ofertas_users.user_id', $this->user->id)
        ->select(
            'requerimientos.id as req_id',
            'requerimientos.sitio_trabajo',
            'requerimientos.created_at as fecha_publicacion',
            'requerimientos.estado_publico',
            'cargos_especificos.descripcion as oferta_cargo'
        )
        ->orderBy('ofertas_users.fecha_aplicacion', 'DESC')
        ->paginate(6);

        //Busca la oferta en la que se encuentra actualmente en proceso
        $oferta_candidato = ReqCandidato::join('requerimientos', 'requerimientos.id', '=', 'requerimiento_cantidato.requerimiento_id')
        ->join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
        ->where('requerimiento_cantidato.candidato_id', $this->user->id)
        ->select(
            'requerimiento_cantidato.id as req_cand_id',
            'requerimientos.id as req_id',
            'requerimientos.sitio_trabajo',
            'requerimientos.created_at as fecha_publicacion',
            'requerimiento_cantidato.created_at as fecha_aplicacion',
            'requerimientos.estado_publico',
            'requerimiento_cantidato.candidato_id as user_id',
            'cargos_especificos.descripcion as oferta_cargo'
        )
        ->orderBy('requerimiento_cantidato.created_at', 'DESC')
        ->first();

        $procesos_url = EnlaceProcesoCandidato::where('active', 1)->orderBy('orden')->get();

        $procesos_candidato = EnlaceProcesoCandidato::join('procesos_candidato_req', 'procesos_candidato_req.proceso', '=', 'enlaces_procesos_candidato.nombre_trazabilidad')
        ->where('requerimiento_candidato_id', $oferta_candidato->req_cand_id)
        ->whereIn('proceso', $procesos_url->pluck('nombre_trazabilidad'))
        ->select(
            'procesos_candidato_req.apto',
            'procesos_candidato_req.id as ref_id',
            'procesos_candidato_req.created_at as fecha_solicitud',
            'enlaces_procesos_candidato.*'
        )
        ->orderBy('apto')
        ->orderBy('fecha_solicitud')
        ->get();

        return view("cv.mis_procesos", compact("instanciaConfiguracion", "getOfertas", "ofertasCandidato", "menu", "user_id", "ofertas_aplicadas", "oferta_candidato", "procesos_candidato"));
    }
}
