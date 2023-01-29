<?php

namespace App\Jobs;

use App\Models\CargoEspecifico;
use App\Models\Clientes;
use App\Models\Menu;
use App\Models\OfertaUser;
use App\Models\RegistroProceso;
use App\Models\User;
use App\Models\DatosBasicos;
use App\Models\Documentos;
use App\Models\EntrevistaCandidatos;
use App\Models\FirmaContratos;
use App\Models\Requerimiento;
use App\Models\PregReqResp;
use App\Models\ReqPreg;
use App\Models\ReqCandidato;
use App\Models\TruoraKey;
use App\Models\ResultadoPreguntaCandidatoAplica;
use App\Models\PruebaBrigResultado;
use App\Models\AsistenteCita;
use App\Models\PruebaBrigConfigCargo;
use App\Models\PruebaDigitacionResultado;
use App\Models\PruebaCompetenciaResultado;
use App\Models\ClausulaValorCargo;
use App\Models\ClausulaValorRequerimiento;
use App\Models\ClausulaValorCandidato;
use App\Models\ConsultaListaVinculanteAccess;
use App\Models\TusDatosKey;
use App\Models\TusDatosEvs;

use App\Models\User as SentinelUser;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Html\FormFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Models\Sitio;
use App\Models\SitioModulo;
use Carbon\Carbon;
use \Cache;

class FuncionesGlobales
{   /*constantes que representan la categoria  DOCUMENTOS BENEFICIARIOS*/
    const CATEGORIA_DOCUMENTOS_BENEFICIARIOS = 5;

    public static function search_and_replace(array $replace, string $subject, array $dato_variable)
    {
        //
            $sitioModulo = SitioModulo::first();
            if ($sitioModulo->generador_variable == 'enabled') {
                $clausula_valor = ClausulaValorCandidato::where('user_id', $dato_variable['user_id'])
                ->where('req_id', $dato_variable['req_id'])
                ->where('adicional_id', $dato_variable['adicional_id'])
                ->first();

                //Si no tiene en candidato pasa al req
                if (empty($clausula_valor)) {
                    $clausula_valor = ClausulaValorRequerimiento::where('req_id', $dato_variable['req_id'])
                    ->where('adicional_id', $dato_variable['adicional_id'])
                    ->first();
                }
            }else {
                $clausula_valor = ClausulaValorRequerimiento::where('req_id', $dato_variable['req_id'])
                ->where('adicional_id', $dato_variable['adicional_id'])
                ->first();

                if (empty($clausula_valor)) {
                    $clausula_valor = ClausulaValorCargo::where('cargo_id', $dato_variable['cargo_id'])
                    ->where('adicional_id', $dato_variable['adicional_id'])
                    ->first();
                }
            }

            $valor_variable = (empty($clausula_valor->valor)) ? '' : $clausula_valor->valor;

            array_push($replace, $valor_variable);
        //

        $search = [
            '{nombre_completo}',
            '{nombres}',
            '{primer_apellido}',
            '{segundo_apellido}',
            '{cedula}',
            '{direccion}',
            '{celular}',
            '{fecha_firma}',
            '{fecha_ingreso}',
            '{cargo_ejerce}',
            '{empresa_usuaria}',
            '{tipo_documento}',
            '{ciudad_oferta}',
            '{ciudad_contrato}',
            '{empresa_contrata}',
            '{salario_asignado}',
            '{valor_variable}',
        ];

        $nuevo_texto = null;

        for ($i = 0; $i < count($search); $i++) {
            if($i == 0){
                $nuevo_texto = str_replace($search[$i], $replace[$i], $subject);
            }

            $nuevo_texto = str_replace($search[$i], $replace[$i], $nuevo_texto);
        }

        return $nuevo_texto;
    }

    //estado de los botones
    public static function estado_boton($estado)
    {
        if($estado == 22 || $estado == 1 || $estado == 16 || $estado == 17 || $estado == 19 || $estado == 2 ){
            return true;
        }

        return false;
    }

    public static function tiene_experiencia($id)
    {
        $dato = DatosBasicos::select('tiene_experiencia')->where('user_id',$id)->first();

        if($dato->tiene_experiencia == 0){
            return true;
        }

        return false;
    }
    
    //para candidatos a contratar
    public function AContratar()
    {   
        $candidatos_contratar = ReqCandidato::join("users", "requerimiento_cantidato.candidato_id", "=", "users.id")
        ->join("datos_basicos", "datos_basicos.user_id", "=", "users.id")
        ->join("requerimientos","requerimiento_cantidato.requerimiento_id","=","requerimientos.id")
        ->join("requerimientos_estados","requerimientos.id","=","requerimientos_estados.req_id")
        ->whereIn("requerimiento_cantidato.estado_candidato",[
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_ACTIVO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION')] )
        ->whereIn('requerimientos_estados.max_estado',[ 
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),]);
        
        $num_can_con = $candidatos_contratar->count();

        return $num_can_con;
    }

    public static function cambio_procesado($user)
    {
        if (route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co") {
            $datos_basicos = DatosBasicos::where("user_id", $user)->first();
            $datos_basicos->procesado = 0;
            $datos_basicos->save();
        }
    }

    public static function cambio_noprocesado($user)
    {
        if (route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co") {
            $datos_basicos = DatosBasicos::where("user_id", $user)->first();
            $datos_basicos->procesado = 1;
            $datos_basicos->save();
        }
    }

    //esta funcion reemplaza a la funcion getciudad para retornar el nombre de la ciudad ya ubicada con pais y departamento
    public function oport_porcent($v1,$v2)
    {
        $sum = ($v1 / $v2)*100;
        return round($sum);
        //retornar arreglo con campo
    }

    public function Vacantes_req()
    {
        $date = Carbon::now();
        $mes =  $date->subDay(15);
        
        $vacantes_abi = DB::table('requerimientos')->join("requerimientos_estados","requerimientos.id","=","requerimientos_estados.req_id")
        ->whereIn('requerimientos_estados.max_estado',[ 
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),])
        ->select( DB::raw('(select count(requerimientos.num_vacantes)  from requerimientos )  as numero_vac '))
        ->whereDate('requerimientos.created_at','>',$mes)
        ->first();

        return $vacantes_abi->numero_vac;
    }

    public function vacantes_vencidas()
    {
        $fecha_hoy = Carbon::now();
        $fecha_hoy = $fecha_hoy->format('Y-m-d');

        $date = Carbon::now();
        $mes =  $date->subDay(15);
        
        $vacantes_ven = DB::table('requerimientos')
        ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
        ->whereIn("estados_requerimiento.estado", [
           config('conf_aplicacion.C_RECLUTAMIENTO'),
           config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
           config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
           config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
        ])
        ->where('requerimientos.fecha_ingreso','<',$fecha_hoy)
        ->whereDate('requerimientos.created_at','>',$mes)
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
        ->select("requerimientos.fecha_ingreso","requerimientos.id",\DB::raw(' requerimientos.num_vacantes - (select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as numero_vac '))
        ->get();
                
        $suma = 0;

        $gruposDe4 = $vacantes_ven->chunk(4);
 
        foreach ($vacantes_ven as $key => $value) {
            $suma +=(int)$value->numero_vac;
        }

        return $suma;
    }

    public function candidatos_contratar()
    {
        $date = Carbon::now();
        $mes =  $date->subDay(15);

        $candidatos_contratar = DB::table('requerimientos')
        ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
        ->select(DB::raw('(select count(*) from procesos_candidato_req where proceso in(\'ENVIO_CONTRATACION\') and requerimiento_id=requerimientos.id ) as cant_enviados_contratacion'))
        ->whereIn("estados_requerimiento.estado", [
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
        ])
        ->whereDate('requerimientos.created_at','>',$mes)
        ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
        ->get();

        $suma=0;

        $gruposDe4 = $candidatos_contratar->chunk(4);
 
        foreach ($candidatos_contratar as $key => $value) {
            $suma +=(int)$value->numero_vac;
        }

        foreach ($candidatos_contratar as $key => $value) {
            $suma +=(int)$value->cant_enviados_contratacion;
        }

        return $suma;
    }

    public function req_abiertos()
    {
        $date = Carbon::now();
        $mes =  $date->subMonth(1);

        $requerimientos_abiertos= DB::table('requerimientos')
        ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
        ->whereIn('estados_requerimiento.estado',[ 
            config('conf_aplicacion.C_RECLUTAMIENTO'),
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),])
        ->whereDate('requerimientos.created_at','>',$mes)->count();
        
        $num_req_a = $requerimientos_abiertos;
        
        return $requerimientos_abiertos;
    }
    
    public function procesos_activos()
    {
        $date = Carbon::now();
        $mes =  $date->subDay(15);

        $procesos_activos = RegistroProceso::join('users','users.id','=','procesos_candidato_req.candidato_id')
        ->join('requerimientos','requerimientos.id','=','procesos_candidato_req.requerimiento_id')
        ->join('requerimientos_estados','requerimientos_estados.req_id','=','requerimientos.id')
        ->whereIn("requerimientos_estados.max_estado", [
            config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
            config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
            config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),  ])
        ->where('procesos_candidato_req.candidato_id',$this->user->id)
        ->whereDate('requerimientos.created_at','>',$mes)
        ->select('procesos_candidato_req.candidato_id','procesos_candidato_req.requerimiento_id')->count();

        return $procesos_activos;
    }

    public function getErrorData($name, $data)
    {
        if ($data == "") {
            return false;
        }
        
        $error = "";
        //dd($data);
        if ($data->has($name)) {
            $error = $data->first($name);
        }

        if (Session::has("errors") && $name == "mensaje_error") {
            $error = Session::get("errors")->first("mensaje_error");
        }

        return $error;
    }

    public function rolVisitante($user)
    {
        if ($user == null) {
            return false;
        }

        if ($user->is("admin")) {
            return $user->is("admin");
        } else {
            Auth::logout();
            return false;
        }
    }

    public function activeLink($ruta)
    {
        $data = Route::getCurrentRoute()->getName();

        if ($ruta == $data) {
            return "active";
        }

        return "";
    }



    public function valida_boton_req($permiso, $nombre, $type = null, $class = null, $tag = [], $id = null, $opciones = [])
    {
        $usuario   = Sentinel::getUser();
        $tagsButon = "";

        if (is_array($tag)) {
            foreach ($tag as $key => $value) {
                $tagsButon .= " $key = '$value' ";
            }
        } else {
            $tagsButon = $tag;
        }

        switch ($type) {
            case "boton":
                if ($usuario->hasAccess($permiso)) {
                    return "<button class='$class' type='button' id='$id' $tagsButon >$nombre</button>";
                }
                break;
            case "submit":
                if ($usuario->hasAccess($permiso)) {
                    return "<button class='$class' type='submit' id='$id' $tagsButon >$nombre</button>";
                }
                break;
            case "link":
                if ($usuario->hasAccess($permiso)) {
                    $url = route($permiso);

                    if (isset($opciones['id'])) {
                        $url = route($permiso, $opciones['id']);
                    }
                    return "<a class='$class' href='" . $url . "' id='$id' $tagsButon  >$nombre</a>";
                }
                break;
        }

        return "";
    }

    public function usuariosHijos($idpadre)
    {
        $ids = array();
        array_push($ids, $idpadre);
        $usuario = SentinelUser::where("padre_id", $idpadre)->get();

        if ($usuario->count() > 0) {
            foreach ($usuario as $key => $value) {
                $ids = array_merge($this->usuariosHijos($value->id), $ids);
            }
        }
        
        return $ids;
    }

    public function submenuHTML($value, $key, $nivel = 1)
    {
        $usuario        = Sentinel::getUser();
        $submenu        = "";
        $siguienteNivel = "";
        $menuSubCache   = $value;

        if (array_key_exists("submenu", $value) && is_array($menuSubCache["submenu"])) {

            foreach ($menuSubCache["submenu"] as $key3 => $value3) {

                $siguienteNivel .= $this->submenuHTML($value3, $key3, $nivel);
            }
        }
        unset($menuSubCache["submenu"]);

        $submenu .= "<div class='submenu menu_2 menu_hijo $nivel'  id='submenu_" . $key . "' ><ul>";

        foreach ($menuSubCache as $key2 => $value2) {

            $value2 = $value2["obj"];

            array_push($this->menuPadres, $value2->padre_id);
            if ($usuario->hasAccess($value2->slug)) {
                if (in_array($key2, $this->menuPadres)) {
                    $submenu .= "<li><a href='#' data-submenu='submenu_" . $value2->id . "'   data-id='" . $value2->id . "' data-padre_id='" . $value2->padre_id . "' >" . $value2->icono . $value2->nombre_menu . "</a></li>";
                } else {
                    $submenu .= "<li><a href='" . route($value2->slug) . "' data-id='" . $value2->id . "' data-padre_id='" . $value2->padre_id . "' >" . $value2->icono . $value2->nombre_menu . "</a></li>";
                }
            }
        }

        $submenu .= "</ul></div>";
        return $submenu . $siguienteNivel;
    }

    public function pintarMenu()
    {
        $usuario = Sentinel::getUser();
        $menu    = $this->menu_admin();

        $menuhtml = "";
        $submenu  = "";

        $i = 2;
        if (is_array($menu["submenu"])) {
            foreach ($menu["submenu"] as $key => $value) {

                $submenu .= $this->submenuHTML($value, $key);
            }
        }

        unset($menu["submenu"]);

        $menuhtml .= "<div><ul>";
        foreach ($menu as $key => $value) {
            $value2 = $value["obj"];
            if ($usuario->hasAccess($value2->slug)) {
                if (in_array($value2->id, $this->menuPadres)) {
                    $menuhtml .= "<li><a href='#' data-submenu='submenu_" . $value2->id . "' >" . $value2->icono . $value2->nombre_menu . "</a></li>";
                } else {
                    $menuhtml .= "<li><a href='" . route($value2->slug) . "' >" . $value2->icono . $value2->nombre_menu . "</a></li>";
                }
            }
        }
        $menuhtml .= "</ul></div>";

        return $menuhtml . $submenu;
    }

    public function menu_home(){
        $menu = DB::table("menu_home")->where("estado", 1)->orderBy("orden")
        ->select("menu_home.*")
        ->get();

        return $menu;
    }

    public function menu_admin($padre_id = 0)
    {
        $usuario     = Sentinel::getUser();
        $menu_padres = [];
        $conteo      = 1;
        $html        = "";
        $menuFinal   = [];

        $menu = Menu::where("modulo", "admin")->where("padre_id", $padre_id)
        ->where("tipo", "view")
        ->where("active", 1)
        ->orderBy("orden")
        ->with("menu_hijo2")
        ->get();

        foreach($menu as $key => $value){

            if(\Route::has($value->slug)){
                if ($usuario->hasAccess($value->slug)){

                    if(count($value->menu_hijo2)>0){

                        $hijos2=$value->menu_hijo2->filter(function ($value){
                            if(($value->tipo == "view" || $value->tipo == "submit") && $value->active==1){
                                return 1;
                            }else{
                                return 0;
                            }
                        });

                        $count=0;
                        foreach($hijos2 as $item){
                            if(\Route::has($item->slug) && $usuario->hasAccess($item->slug)){
                                $count++;
                            }
                        }
                        if($count){
                            $html .= "<li class='treeview'>";
                             $html .= "<a href='#'>" . $value->icono . "<span class='text'>" . $value->nombre_menu . "</span></a><ul class='treeview-menu'>";
                            foreach($hijos2 as $hijo){
                                if (\Route::has($hijo->slug) && $usuario->hasAccess($hijo->slug)){
                                    $html .= "<li><a href='" . route($hijo->slug) . "'>" . $hijo->icono . "<span class='text'>" . $hijo->nombre_menu . "</span></a></li>";
                                }
                              
                               
                               
                            }

                            $html .="</ul>";

                        }
                    }
                    else{
                         $html .= "<li><a href='" . route($value->slug) . "'>" . $value->icono . "<span class='text'>" . $value->nombre_menu . "</span></a></li>";
                    }
                }
            }//fin if inicial

        }

        /*foreach ($menu as $key => $value) {
            $hijos = Menu::where("padre_id", $value->id)
                ->where("tipo", "view")
                ->where("submenu", "=", 1)
                ->where("active",1)
                
                ->get();


                
            if ($usuario->hasAccess($value->slug)) {
                if ($hijos->count() > 0) {
                    $html .= "<li class='treeview'>";
                    $html .= "<a href='#'>" . $value->icono . "<span class='text'>" . $value->nombre_menu . "</span></a><ul class='treeview-menu'>";
                    $html .= $this->menu_admin($value->id);
                    $html .= "</ul></li>";
                } else {
                    $html .= "<li><a href='" . route($value->slug) . "'>" . $value->icono . "<span class='text'>" . $value->nombre_menu . "</span></a></li>";
                }
            }
        }*/

        return $html;
    }

    public function menu_requerimiento($padre_id = 0)
    {
        $usuario     = Sentinel::getUser();
        $menu_padres = [];
        $conteo      = 1;
        $html        = "";
        $menuFinal   = [];

        $menu = Menu::where("modulo", "req")->where("padre_id", $padre_id)
        ->where("tipo", "view")
        ->where("active", 1)
        ->orderBy("orden")
        ->with("menu_hijo2")
        ->get();

        foreach($menu as $key => $value)
        {
            if(\Route::has($value->slug))
            {
                if ($usuario->hasAccess($value->slug))
                {
                    if(count($value->menu_hijo2) > 0)
                    {
                        $hijos2=$value->menu_hijo2->filter(function ($value)
                        {
                            if(($value->tipo == "view" || $value->tipo == "submit") && $value->active==1 && $value->submenu == 1)
                            {
                                return 1;
                            }
                            else
                            {
                                return 0;
                            }
                        });
                        
                        if(count($hijos2) == 0)
                        {
                            $html .= "<li><a href='" . route($value->slug) . "'>" . $value->icono . "<span class='text'>" . $value->nombre_menu . "</span></a></li>";
                        }
                        
                        $count=0;
                            foreach($hijos2 as $item){
                                if(\Route::has($item->slug) && $usuario->hasAccess($item->slug)){
                                    $count++;
                                }
                            }
                        if($count)
                        {
                            $html .= "<li class='treeview'>";
                            $html .= "<a href='#'>" . $value->icono . "<span class='text'>" . $value->nombre_menu . "</span></a><ul class='treeview-menu'>";
                            foreach($hijos2 as $hijo)
                            {
                                if (\Route::has($hijo->slug) && $usuario->hasAccess($hijo->slug))
                                {
                                    $html .= "<li><a href='" . route($hijo->slug) . "'>" . $hijo->icono . "<span class='text'>" . $hijo->nombre_menu . "</span></a></li>";
                                }  
                            }
                            $html .="</ul>";
                        }
                    }
                    else
                    {
                        $html .= "<li><a href='" . route($value->slug) . "'>" . $value->icono . "<span class='text'>" . $value->nombre_menu . "</span></a></li>";
                    }   
                }
            }
        }
        return $html;




        // $request = \Request::route()->getName();
        // $html    = "";
        // $usuario = Sentinel::getUser();

        // $req = Menu::where("modulo", "req")
        // ->where("padre_id", $padre_id)
        // ->where("tipo", "view")
        // ->orderBy("orden")
        // ->get();

        // $clientes = Clientes::join("users_x_clientes", "users_x_clientes.cliente_id", "=", "clientes.id")
        // ->where("users_x_clientes.user_id", $usuario->id)
        // ->get();

        // foreach ($req as $key => $value) {
        //     if (\Route::has($value->slug) && $usuario->hasAccess($value->slug)) {
        //         $hijos = Menu::where("padre_id", $value->id)
        //         ->where("tipo", "view")
        //         ->where("submenu", "=", 1)
        //         ->where("active", 1)
        //         ->get();

        //         if ($hijos->count() > 0) {
        //             $html .= "<li class='treeview'>";
        //             $html .= "<a href='#'>".$value->icono." <span class='text'>".$value->nombre_menu."</span></a>";
        //                 $html .= "<ul class='treeview-menu'>";
        //                     $html .= $this->menu_requerimiento($value->id);
        //                 $html .= "</ul>";
        //             $html .= "</li>";
        //         } else {
        //             $html .= "<li><a href='".route($value->slug)."'>".$value->icono." <span class='text'>".$value->nombre_menu."</span></a></li>";
        //         }
        //     }
        // }

        //  return $html;
    }

    protected $menuPadres = [];

    public function validaBotonProcesos($candidato_req, $proceso)
    {
        if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co"){
            $proceso2 = RegistroProceso::where("requerimiento_candidato_id", $candidato_req)->whereIn("proceso", $proceso)->get();

            if ($proceso2->count() > 0) {
                return true;
            }

            return false;
        }else{
            return false;
        }
    }

    public static function validaBotonProcesosAsistente($req_id, $user_id, $proceso)
    {
        if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co"){
            $proceso2 = RegistroProceso::where("requerimiento_id", $req_id)
            ->where("candidato_id", $user_id)
            ->whereIn("proceso", $proceso)
            ->orderBy("created_at", "DESC")
            ->get();

            if ($proceso2->count() > 0) {
                return true;
            }

            return false;
        }else{
            return false;
        }
    }

    public static function validaBotonProcesosUltimo($req_id, $user_id, $proceso)
    {
        if(route('home') != "http://komatsu.t3rsc.co" && route('home') != "https://komatsu.t3rsc.co"){
            $proceso = RegistroProceso::where("requerimiento_id", $req_id)
            ->where("candidato_id", $user_id)
            //->whereIn("proceso", $proceso)
            ->orderBy("created_at", "DESC")
            ->first();

            if($proceso->proceso == "FIRMA_VIRTUAL_SIN_VIDEOS" || $proceso->proceso == "FIN_CONTRATACION_VIRTUAL") {
                return true;
            }

            return false;
        }else{
            return false;
        }
    }

    /*
        public function validaBotonAsistencia($candidato_req, $asiste)
        {
              //dd($candidato_req->entre->id);
            if($candidato_req === null){
                return null;
            }
            else{
                
                 $proceso2 = EntrevistaCandidatos::where("id", $candidato_req)->whereIn("asiste", $asiste)->get();

          
            if ($proceso2->count() > 0) {

                return true;
            }
            return false;
            }

           
        }
    */

    public function validaBotonEstado($candidato_req, $estado)
    {
        $proceso = RegistroProceso::where("requerimiento_candidato_id", $candidato_req)->where("estado", $estado)->get();
        if ($proceso->count() > 0) {
            //Buscar si tiene proceso anulado
            $proceso_anulado = RegistroProceso::where("requerimiento_candidato_id", $candidato_req)->where("estado", 24)->get();
            if($proceso_anulado->count() > 0){
                return false;
            }

            return true;
        }
        return false;
    }

    public static function validaBotonEstados($candidato_req, $estados)
    {
        $proceso = ReqCandidato::where("id", $candidato_req)->whereIn("estado_candidato", $estados)->get();
        if ($proceso->count() > 0) {
            //Buscar si tiene proceso anulado

            return true;
        }
        return false;
    }

    public static function validaBotonContratar($candidato_req, $estados)
    {
        $proceso = RegistroProceso::where("requerimiento_candidato_id", $candidato_req)->whereIn("estado", $estados)->get();
        if ($proceso->count() > 0) {
            //Buscar si tiene proceso anulado
            $proceso_anulado = RegistroProceso::where("requerimiento_candidato_id", $candidato_req)->where("estado", 24)->get();
            if($proceso_anulado->count() > 0){
                return false;
            }

            return true;
        }
        return false;
    }

    public function getPermisosAdmin($padre = 0, $permisos, $modal = false)
    {
        $menu = Menu::where("modulo", "admin")->where("padre_id", $padre)->where("active",1)->get();
        $html = "";

        foreach ($menu as $key => $value) {
            $hijos = Menu::where("padre_id", $value->id)->get()->count();

            $permiso_valida = "";

            //Para marcar el check si ya tiene asignado el permiso
            if (array_key_exists($value->slug, $permisos)) {
                $permiso_valida = $permisos["$value->slug"];
            } else {
                $permiso_valida = "";
            }

            $html .= '<tr>';
                $html .= '<td>';
                    if ($modal) {
                        $html .= \Collective\Html\FormFacade::checkbox("permiso_admin[" . $value->slug . "]", "true", (($permiso_valida === true) ? true : false), ["class" => "check_func_modal valor_true padre" . $value->padre_id, "data-id" => $value->id]);
                    }else {
                        $html .= \Collective\Html\FormFacade::checkbox("permiso_admin[" . $value->slug . "]", "true", (($permiso_valida === true) ? true : false), ["class" => "check_func valor_true padre" . $value->padre_id, "data-id" => $value->id]);
                    }
                $html .= '</td>';

                $html .= '<td>';
                    $html .= $value->nombre_menu;
                $html .= '</td>';
            $html .= '</tr>';

            /*
            $html .= '<div class="fila">';
                $html .= '<div class="btn-group botones_acciones" data-toggle="buttons">';
                    $permiso_valida = "";

                    //Para marcar el check si ya tiene asignado el permiso
                    if (array_key_exists($value->slug, $permisos)) {
                        $permiso_valida = $permisos["$value->slug"];
                    } else {
                        $permiso_valida = "";
                    }

                    //Checkbox
                    $html .= \Collective\Html\FormFacade::checkbox("permiso_admin[" . $value->slug . "]", "true", (($permiso_valida === true) ? true : false), ["class" => "check_func valor_true padre" . $value->padre_id, "data-id" => $value->id]);
                $html .= "</div>";

                $html .= "<div class='texto_permiso'>" . $value->nombre_menu . "</div>";

                $html .= "<div class='permisos_asociados 'id='roles_" . $value->id . "'>";
                $html .= "</div>";

            $html .= "</div>";
            */

            if ($hijos > 0) {
                $html .= "<div class='tabla_hijos'>" . $this->getPermisosAdmin($value->id, $permisos) . "</div>";
            }
        }

        return $html;
    }

    //Modal aplicación candidato
    public function aplica_oferta_pregunta($req_id)
    {
        $user = Sentinel::getUser();

        $requerimiento = Requerimiento::where('id', $req_id)
        ->select(
            'requerimientos.id',
            'requerimientos.cargo_especifico_id as cargo_id'
        )
        ->first();

        //Busca si hay respuestas del candidato
        $respuesta_pregunta_candidato = PregReqResp::where("user_id", $user->id)
        ->join('preguntas', 'preguntas.id', '=', 'preg_req_resp.preg_id')
        ->where('preg_req_resp.req_id', $req_id)
        ->where('preg_req_resp.cargo_especifico_id', $requerimiento->cargo_id)
        ->where('preguntas.activo', 1)
        ->get();

        $oferta = OfertaUser::where("user_id", $user->id)->where("requerimiento_id", $req_id)->get();

        if (count($oferta) == 0) {
            $aplicar = new OfertaUser();
            
            $aplicar->fill([
                "user_id"          => $user->id,
                "requerimiento_id" => $req_id,
                "fecha_aplicacion" => date("Y-m-d H:i:s"),
                "cedula"           => $user->getDatosBasicos()->numero_id
            ]);
            $aplicar->save();

            if(Session::has("no_aplica")){
                $aplicar->aplica = 0;
                $aplicar->save();
            }
        }

        if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co"){
            $detalle_oferta = Requerimiento::join("cargos_especificos","cargos_especificos.id", "=","requerimientos.cargo_especifico_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->leftJoin("ofertas_users", function ($join3) {
                $join3->on("ofertas_users.requerimiento_id", "=", DB::raw("requerimientos.id"));
            })
            ->where("requerimientos.id", $req_id)
            ->select(
                "cargos_especificos.id as cargo_espe_id",
                "cargos_genericos.id as cargo_id",
                "cargos_genericos.descripcion as nombre_cargo",
                "cargos_especificos.descripcion as nombre_subcargo",
                "funciones",
                "formacion_academica",
                "experiencia_laboral",
                "conocimientos_especificos",
                "descripcion_oferta",
                "salario"
            )
            ->first();
        }else{
            $detalle_oferta = Requerimiento::join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
            ->join("tipos_experiencias", "tipos_experiencias.id", "=", "requerimientos.tipo_experiencia_id")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
            })->join("ciudad", function ($join2) {
            $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
            })
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->leftJoin("ofertas_users", function ($join3) {
                $join3->on("ofertas_users.requerimiento_id", "=", DB::raw("requerimientos.id"));
            })
            ->select(
                "tipos_experiencias.descripcion as tipo_experiencia",
                "requerimientos.*",
                "ofertas_users.fecha_aplicacion as f_aplicacion",
                \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"), "clientes.nombre as nombre_cliente", "cargos_genericos.descripcion as nombre_cargo"
            )
            ->where("requerimientos.id", $req_id)
            ->orderBy("requerimientos.created_at", "DESC")
            ->first();
        }

        Session::forget('req_preg_resp');

        return view("cv.modal.responder_preguntas_log", compact(
            "detalle_oferta",
            "req_id",
            "respuesta_pregunta_candidato"
        ));
    }

    //Modal aplicación candidato
    public function aplica_oferta_externa($req_id)
    {
        $req_id = $req_id;

        $user = Sentinel::getUser();

        //Busa si ya aplico a la oferta
        $oferta = OfertaUser::where("user_id", $user->id)->where("requerimiento_id", $req_id)->get();

        if ($oferta->count() == 0) {
            $aplicar = new OfertaUser();
            
            $aplicar->fill([
                "user_id"          => $user->id,
                "requerimiento_id" => $req_id,
                "fecha_aplicacion" => date("Y-m-d H:i:s"),
                "cedula"           => $user->getDatosBasicos()->numero_id,
            ]);
            $aplicar->save();

            event(new \App\Events\NotificacionAplicacionVacanteEvent($req_id, $user->id));
        }

        if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co"){
            $requerimientos = Requerimiento::where("requerimientos.id", $req_id)
            ->join("cargos_especificos", "cargos_especificos.id",  "=", "requerimientos.cargo_especifico_id")
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->leftJoin("ofertas_users", function ($join3) {
                $join3->on("ofertas_users.requerimiento_id", "=", DB::raw("requerimientos.id"));
            })
            ->select(
                "cargos_especificos.id as cargo_espe_id",
                "cargos_genericos.id as cargo_id",
                "cargos_genericos.descripcion as nombre_cargo",
                "cargos_especificos.descripcion as nombre_subcargo",
                "funciones",
                "formacion_academica",
                "experiencia_laboral",
                "conocimientos_especificos",
                "descripcion_oferta",
                "salario"
                )
            ->first();
        }else{
            $requerimientos = Requerimiento::where("requerimientos.id", $req_id)
            ->join("paises", "paises.cod_pais", "=", "requerimientos.pais_id")
            ->join("departamentos", function ($join) {
                $join->on("departamentos.cod_pais", "=", "requerimientos.pais_id")
                ->on("departamentos.cod_departamento", "=", "requerimientos.departamento_id");
            })
            ->join("ciudad", function ($join2) {
                $join2->on("ciudad.cod_pais", "=", "requerimientos.pais_id")
                ->on("ciudad.cod_ciudad", "=", "requerimientos.ciudad_id")
                ->on("ciudad.cod_departamento", "=", "requerimientos.departamento_id");
            })
            ->leftJoin("ofertas_users", function ($join3) {
                $join3->on("ofertas_users.requerimiento_id", "=", DB::raw("requerimientos.id"));
            })
            ->join("cargos_genericos", "cargos_genericos.id", "=", "requerimientos.cargo_generico_id")
            ->join("cargos_especificos","cargos_especificos.id", "=","requerimientos.cargo_especifico_id")
            ->join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("clientes", "clientes.id", "=", "negocio.cliente_id")
            ->join("tipos_experiencias", "tipos_experiencias.id", "=", "requerimientos.tipo_experiencia_id")
            ->select(
                "tipos_experiencias.descripcion as tipo_experiencia",
                "cargos_especificos.descripcion as nombre_subcargo",
                "requerimientos.*",
                "ofertas_users.fecha_aplicacion as f_aplicacion",
                \DB::raw("CONCAT(paises.nombre,' ',departamentos.nombre,' ',ciudad.nombre) AS ciudad_seleccionada"),
                "clientes.nombre as nombre_cliente",
                "cargos_genericos.descripcion as nombre_cargo"
            )
            ->orderBy("requerimientos.created_at", "DESC")
            ->first();
        }

        Session::forget('req_aplica_oferta');

        return view("cv.modal.aplica_oferta_externa", compact("requerimientos", "oferta","req_id"));
    }

    public function restarDiasFecha($fecha, $dias)
    {
        $nuevafecha = strtotime("-$dias day", strtotime($fecha));

        return date("Y-m-d", $nuevafecha);
    }

    public function migaPan($id = null)
    {
        $data = Route::getCurrentRoute()->getName();
        $segment = \Request::segment(3);
        $segment2 = \Request::segment(4);
        $numero  = 0;

        $sql = Menu::where("slug", $data)->first();

        if ($id != null) {
            $sql = Menu::where("id", $id)->first();
        }

        $html = "";

        if ($sql != null && $sql->padre_id > 0) {
            $html = $this->migaPan($sql->padre_id);
        }

        if ($segment > 0 && $id == null) {
            $numero = $segment;
        }

        if ($sql == null) {
            return $html;
        }

        if ($segment2 == null) {
            $html .= "<li><a href='" . (($sql != null && $sql->padre_id == 0) ? "#" : route($sql->slug, [$sql->padre_id])) . "'>" . $sql->nombre_menu . (($numero == 0) ? "" : " # $numero") . "</a></li>";
        }
        else{
            $html .= "<li><a href='" . (($sql != null && $sql->padre_id == 0) ? "#" : route($sql->slug, [$segment, $segment2])) . "'>" . $sql->nombre_menu . (($numero == 0) ? "" : " # $numero") . "</a></li>";
        }
       
        return $html;
    }

    public function sitio()
    {
        $sitio = Sitio::first();

        return $sitio;
    }

    public function sitioModulo()
    {
        $sitioModulo = SitioModulo::first();

        return $sitioModulo;
    }

    public static function sitioModuloStatic()
    {
        $sitioModulo = SitioModulo::first();

        return $sitioModulo;
    }

    public function datosUser($id){
        $user = SentinelUser::find($id);
        
        return $user;
    }

    //Consulta si ya se ha consultado en truora el candidato
    public static function getTruora($req_id, $cand_id)
    {
        $getTruora = TruoraKey::where('req_id', $req_id)
        ->where('cand_id', $cand_id)
        ->first();

        $query = 0;

        if ($getTruora != null || !empty($getTruora)) {
            $query = 1;
        }

        return $query;
    }

    //Estado proceso consulta tusdatos.co
    public static function getTusDatos($req_id, $user_id)
    {
        $tusdatosData = TusDatosKey::where('req_id', $req_id)
        ->where('user_id', $user_id)
        ->orderBy('id', 'DESC')
        ->first();

        return $tusdatosData;
    }

    //Estado proceso consulta tusdatos.co para EVS
    public static function getTusDatosEvs($req_id, $user_id)
    {
        $tusdatosDataEvs = TusDatosEvs::where('req_id', $req_id)
        ->where('user_id', $user_id)
        ->orderBy('id', 'DESC')
        ->first();

        return $tusdatosDataEvs;
    }

    //Funciones para ElEmpleo
    public static function getSalaryIdEE($value)
    {
        if ($value < 1000000) {
            return 2;
        }else if($value >= 1000000 && $value <= 1500000){
            return 3;
        }else if($value >= 1500000 && $value <= 2000000){
            return 4;
        }else if($value >= 2000000 && $value <= 2500000){
            return 5;
        }else if($value >= 2500000 && $value <= 3000000){
            return 6;
        }else if($value >= 3000000 && $value <= 3500000){
            return 7;
        }else if($value >= 3500000 && $value <= 4000000){
            return 8;
        }else if($value >= 4000000 && $value <= 4500000){
            return 9;
        }else if($value >= 4500000 && $value <= 5500000){
            return 10;
        }else if($value >= 5500000 && $value <= 6000000){
            return 23;
        }else if($value >= 6000000 && $value <= 8000000){
            return 27;
        }else if($value >= 8000000 && $value <= 10000000){
            return 28;
        }else if($value >= 10000000 && $value <= 12500000){
            return 29;
        }else if($value >= 12500000 && $value <= 15000000){
            return 30;
        }else if($value >= 15000000 && $value <= 18000000){
            return 31;
        }else if($value >= 18000000 && $value <= 21000000){
            return 32;
        }else if($value > 21000000){
            return 32;
        }
    }

    public static function getContractIdEE($value)
    {
        if ($value == 1) {
            return 1;
        }else if($value == 2){
            return 2;
        }else if($value == 3){
            return 5;
        }else if($value == 4){
            return 4;
        }else if($value == 5){
            return 3;
        }else if($value == 6){
            return 6;
        }
    }

    public static function getExperienceIdEE($value)
    {
        if ($value == 1) {
            return 1;
        }else if($value == 2){
            return 2;
        }else if($value == 3){
            return 2;
        }else if($value == 4){
            return 4;
        }else if($value == 4){
            return 5;
        }else{
            return 6;
        }
    }

    public static function getExperienceDescriptionEE($value)
    {
        if($value == 4){
            return '2 años';
        }else if($value == 4){
            return '3 años';
        }
    }

    public static function getGenderIdEE($value)
    {
        if ($value == 1) {
            return 'M';
        }else if($value == 2){
            return 'F';
        }else if($value == 3){
            return null;
        }
    }

    public static function getLastProcess($cand_req_id, $user_id, $req_id){
        $last_process = RegistroProceso::where('requerimiento_candidato_id', $cand_req_id)
        ->where('candidato_id', $user_id)
        ->where('requerimiento_id', $req_id)
        ->orderBy('created_at', 'DESC')
        ->first();

        if($last_process != null || $last_process != ''){
            if($last_process->proceso == 'FIRMA_VIRTUAL_SIN_VIDEOS'){
                return true;
            }

            return false;
        }

        return false;
    }

    public static function getFirmState($user_id, $req_id){
        $firma = FirmaContratos::where('user_id', $user_id)
        ->where('req_id', $req_id)
        ->orderBy('created_at', 'DESC')
        ->first();

        if($firma != null || $firma != ''){
            if($firma->estado == 0 || $firma->estado === 0){
                return false;
            }

            if ($firma->terminado == null || $firma->terminado === null || $firma->terminado == '') {
                return false;
            }

            return true;
        }

        return false;
    }

    public static function getCargoVideo($cargo_id){
        $get_cargo = CargoEspecifico::where('id', $cargo_id)->first();

        if($get_cargo->videos_contratacion == 1){
            return true;
        }

        return false;
    }

    public static function getStateContract($user_id, $req_id){
        $get_state = FirmaContratos::where('user_id', $user_id)
        ->where('req_id', $req_id)
        ->orderBy('created_at', 'DESC')
        ->first();

        $state = null;

        if($get_state != null || $get_state != ''){
            if($get_state->stand_by == 1){
                $state = true;
                return $state;
            }
    
            if($get_state->stand_by == 0){
                $state = false;
                return $state;
            }
        }

        return false;
    }

    public static function usuariodos($id){
        
        $user = User::find($id);
        
        return $user;
    }

    public static function resultados_x_pregunta($req_id, $cargo_id, $user_id)
    {
        $preguntas_resultado = ResultadoPreguntaCandidatoAplica::where('req_id', $req_id)
        ->where('cargo_id', $cargo_id)
        ->where('user_id', $user_id)
        ->get();

        if($preguntas_resultado == '' || $preguntas_resultado == null){
            return null;
        }

        return $preguntas_resultado;
    }

    //Obtener id de la prueba bryg del candidato, la más reciente
    public static function getBrygId(int $req_id, int $user_id)
    {
        $candidato_bryg = PruebaBrigResultado::where('prueba_brig_candidato_resultado.req_id', $req_id)
        ->where('prueba_brig_candidato_resultado.user_id', $user_id)
        ->select(
            'prueba_brig_candidato_resultado.id'
        )
        ->orderBy('created_at', 'DESC')
        ->first();

        if(!empty($candidato_bryg)) {
            return $candidato_bryg->id;
        }else {
            return 0;
        }
    }

    //Obtener id de la prueba digitación del candidato, la más reciente
    public static function getDigitacionId(int $req_id, int $user_id)
    {
        $candidato_digitacion = PruebaDigitacionResultado::where('prueba_digitacion_candidato_resultados.req_id', $req_id)
        ->where('prueba_digitacion_candidato_resultados.user_id', $user_id)
        ->select(
            'prueba_digitacion_candidato_resultados.id'
        )
        ->orderBy('created_at', 'DESC')
        ->first();

        if(!empty($candidato_digitacion)) {
            return $candidato_digitacion->id;
        }else {
            return 0;
        }
    }

    //Obtener id de la prueba digitación del candidato, la más reciente
    public static function getCompetenciasId(int $req_id, int $user_id)
    {
        $candidato_digitacion = PruebaCompetenciaResultado::where('prueba_competencias_resultados.req_id', $req_id)
        ->where('prueba_competencias_resultados.user_id', $user_id)
        ->select(
            'prueba_competencias_resultados.id'
        )
        ->orderBy('created_at', 'DESC')
        ->first();

        if(!empty($candidato_digitacion)) {
            return $candidato_digitacion->id;
        }else {
            return 0;
        }
    }

    public static function porcentaje_hv($candidato)
    {
        $datosBasicos = DatosBasicos::where("user_id", $candidato)->first();
        $datosBasicos["documentos_count"]=0;
        $datosBasicos["idiomas_count"]=0;

        $idiomas = count($datosBasicos->idiomas_c);

        $hv_count=0;

        $documentos_seleccion = Documentos::join("tipos_documentos", "tipos_documentos.id", "=", "documentos.tipo_documento_id")
        ->where("user_id", $datosBasicos->user_id)
        ->where("tipos_documentos.categoria", 1)
        ->count();

        if($documentos_seleccion > 0) {
            $datosBasicos["documentos_count"] = 100;
        }

        if($idiomas > 0) {
            $datosBasicos["idiomas_count"] = 100;
        }

        $vals = [
            "total" => $hv_count
            //"datos_basicos" => $datosBasicos->datos_basicos_count,
            //"perfilamiento" => $datosBasicos->perfilamiento_count,
            //"experiencia" => $datosBasicos->experiencias_count,
            //"estudios" => $datosBasicos->estudios_count,
            //"grupo_familiar" => $datosBasicos->grupo_familiar_count,
            //"cv.idiomas" => $datosBasicos->idiomas_count,
            //"documentos" => $datosBasicos->documentos_count
        ];
        
        $modulos_cuenta=DB::table("menu_candidato")->where("check",1)->whereNotNull("relacion_hv")->select("ponderacion","ruta","relacion_hv")->get();
        foreach($modulos_cuenta as $modulo){
            $relacion=$modulo->relacion_hv;
            $ruta=$modulo->ruta;
            $vals[$ruta]=$datosBasicos[$relacion];
            //dd((float)$modulo->ponderacion);
            
            $hv_count+=((float)$datosBasicos[$relacion]*(float)$modulo->ponderacion);
        }

        if($hv_count < 1) {
            $hv_count = 5;
        }
        $vals["total"]=$hv_count;
        
        return $vals;
    }

    //Verificar si el requerimiento tiene agendamiento
    public static function agendamientoRequerimiento(int $req_id)
    {
        $cita = AsistenteCita::where('req_id', $req_id)->get();

        if(!empty($cita)) {
            return false;
        }

        return true;
    }

    //Buscar si el cargo tiene configuración BRYG
    public static function buscarConfiguracionCargoBryg(int $cargo_id)
    {
        $configuracion = PruebaBrigConfigCargo::where('cargo_id', $cargo_id)->orderBy('created_at', 'DESC')->first();

        if (!empty($configuracion)) {
            return true;
        }

        return false;
    }

    /*
     * Mis ofertas steps
    */

    public static function stepAplicacion($req_id, $user_id)
    {
        $meses = [1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Ago", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic"];

        $proceso = OfertaUser::where('requerimiento_id', $req_id)
        ->where('user_id', $user_id)
        ->orderBy('created_at', 'DESC')
        ->first();

        $procesoFecha = date('d-m', strtotime($proceso->created_at));
        $procesoFecha = explode("-", $procesoFecha);

        $dia = $procesoFecha[0];
        $mes = (int)$procesoFecha[1];

        $procesoFecha = "$dia $meses[$mes]";

        return ['proceso' => $proceso, 'procesoFecha' => $procesoFecha];
    }

    public static function stepProcesoSeleccion($req_id, $user_id)
    {
        $meses = [1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Ago", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic"];

        $procesosSeleccion = RegistroProceso::where('requerimiento_id', $req_id)
        ->where('candidato_id', $user_id)
        ->whereNotIn('proceso', ['ENVIO_CONTRATACION', 'ENVIO_APROBAR_CLIENTE', 'PRE_CONTRATAR', 'ENVIO_PRUEBA_BRYG', 'FIN_CONTRATACION_VIRTUAL', 'FIRMA_CONF_MAN'])
        ->orderBy('created_at', 'DESC')
        ->get();

        if ($procesosSeleccion->count() > 0) {
            $apto = 1;

            foreach ($procesosSeleccion as $proceso) {
                if ($proceso->proceso != 'ASIGNADO_REQUERIMIENTO') {
                    if ($proceso->apto == 2) {
                        $apto = 0;
                    }
                }
            }

            $procesoFecha = date('d-m', strtotime($proceso->created_at));
            $procesoFecha = explode("-", $procesoFecha);

            $dia = $procesoFecha[0];
            $mes = (int)$procesoFecha[1];

            $procesoFecha = "$dia $meses[$mes]";

            return ['apto' => $apto, 'procesoFecha' => $procesoFecha];
        }

        return null;
    }

    public static function stepEvaluacionCliente($req_id, $user_id)
    {
        $meses = [1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Ago", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic"];

        $proceso = RegistroProceso::where('requerimiento_id', $req_id)
        ->where('candidato_id', $user_id)
        ->whereIn('proceso', ['ENVIO_APROBAR_CLIENTE'])
        ->orderBy('created_at', 'DESC')
        ->first();

        $procesoFecha = date('d-m', strtotime($proceso->created_at));
        $procesoFecha = explode("-", $procesoFecha);

        $dia = $procesoFecha[0];
        $mes = (int)$procesoFecha[1];

        $procesoFecha = "$dia $meses[$mes]";

        return ['proceso' => $proceso, 'procesoFecha' => $procesoFecha];
    }

    public static function stepFinalista($req_id, $user_id)
    {
        $meses = [1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Ago", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic"];

        $proceso = RegistroProceso::where('requerimiento_id', $req_id)
        ->where('candidato_id', $user_id)
        ->whereIn('proceso', ['PRE_CONTRATAR'])
        ->orderBy('created_at', 'DESC')
        ->first();

        $procesoFecha = date('d-m', strtotime($proceso->created_at));
        $procesoFecha = explode("-", $procesoFecha);

        $dia = $procesoFecha[0];
        $mes = (int)$procesoFecha[1];

        $procesoFecha = "$dia $meses[$mes]";

        return ['proceso' => $proceso, 'procesoFecha' => $procesoFecha];
    }

    public static function stepContratado($req_id, $user_id)
    {
        $meses = [1 => "Ene", 2 => "Feb", 3 => "Mar", 4 => "Abr", 5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Ago", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dic"];

        $procesosContratacion = RegistroProceso::where('requerimiento_id', $req_id)
        ->where('candidato_id', $user_id)
        ->whereIn('proceso', ['FIN_CONTRATACION_VIRTUAL', 'FIRMA_CONF_MAN'])
        ->orderBy('created_at', 'DESC')
        ->get();

        if ($procesosContratacion->count() > 0) {
            $apto = 1;

            foreach ($procesosContratacion as $proceso) {
                if ($proceso->apto == 2) {
                    $apto = 0;
                }
            }

            $procesoFecha = date('d-m', strtotime($proceso->created_at));
            $procesoFecha = explode("-", $procesoFecha);

            $dia = $procesoFecha[0];
            $mes = (int)$procesoFecha[1];

            $procesoFecha = "$dia $meses[$mes]";

            return ['apto' => $apto, 'procesoFecha' => $procesoFecha];
        }

        return null;
    }

    /**
     * 
     */

    //Permisos en collapse
    public function getPermisosAdminCollapse($padre = 0, $permisos, $modal = false)
    {
        $componente = "";

        $padresMenu = Menu::where('modulo', 'admin')->where('padre_id', 0)->where('active', 1)->get();

        foreach ($padresMenu as $padre) {
            $permiso_valida = "";

            //Para marcar el check si ya tiene asignado el permiso
            if (array_key_exists($padre->slug, $permisos)) {
                $permiso_valida = $permisos["$padre->slug"];
            } else {
                $permiso_valida = "";
            }

            $componente .= '<div class="col-md-12">';
                $componente .= '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
                    $componente .= '<div class="panel panel-default" id="collapsePermiso_container">';
                        $componente .= '<div class="panel-heading | tri-gray text-white" role="tab" id="headingOne">';
                            $componente .= '<h5 class="panel-title | tri-fs-13">';
                                $componente .= "<input type='checkbox' class='check_func valor_true padre$padre->padre_id' data-id='$padre->id' name='permiso_admin[$padre->slug]' ". (($permiso_valida === true) ? 'checked' : '') .">";

                                $componente .= "<a class='ancla-permisos-usuario ml-1' role='button' data-toggle='collapse' data-parent='#accordion' href='#collapsePermiso$padre->id' aria-expanded='true' aria-controls='collapsePermiso$padre->id'>";
                                    $componente .= $padre->nombre_menu;
                                $componente .= '</a>';
                            $componente .= '</h5>';
                        $componente .= '</div>';

                        $componente .= "<div id='collapsePermiso$padre->id' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingOne'>";
                            $componente .= '<div class="panel-body">';
                                $hijosMenu = Menu::where("padre_id", $padre->id)->get();

                                foreach ($hijosMenu as $hijo) {
                                    $permiso_valida = "";

                                    //Para marcar el check si ya tiene asignado el permiso
                                    if (array_key_exists($hijo->slug, $permisos)) {
                                        $permiso_valida = $permisos["$hijo->slug"];
                                    } else {
                                        $permiso_valida = "";
                                    }

                                    $componente .= '<div class="checkbox">';
                                        $componente .= '<label>';
                                            $componente .= \Collective\Html\FormFacade::checkbox("permiso_admin[" . $hijo->slug . "]", "true", (($permiso_valida === true) ? true : false), ["class" => "check_func valor_true padre" . $hijo->padre_id, "data-id" => $hijo->id, $modal ? 'disabled' : '']);
                                            $componente .= $hijo->nombre_menu;
                                        $componente .= '</label>';
                                    $componente .= '</div>';
                                }
                            $componente .= '</div>';
                        $componente .= '</div>';
                    $componente .= '</div>';
                $componente .= '</div>';
            $componente .= '</div>';
        }

        return $componente;
    }

    /**/
    public function getPermisosAdminModal($padre = 0, $permisos, $modal = false)
    {
        $menu = Menu::where("modulo", "admin")->where("padre_id", $padre)->where("active",1)->get();
        $html = "";

        if ($modal) {
            $disabled_hijo = 'disabled';
        }else {
            $disabled_hijo = '';
        }

        $componente = "";

        foreach ($menu as $key => $value) {
            $permiso_valida = "";

            //Para marcar el check si ya tiene asignado el permiso
            if (array_key_exists($value->slug, $permisos)) {
                $permiso_valida = $permisos["$value->slug"];
            } else {
                $permiso_valida = "";
            }

            $componente .= '<div class="col-md-12">';
                $componente .= '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
                    $componente .= '<div class="panel panel-default" id="collapsePermisoRol_container">';
                        $componente .= '<div class="panel-heading | tri-gray text-white" role="tab" id="headingOne">';
                            $componente .= '<h5 class="panel-title | tri-fs-13">';
                                $componente .= "<input type='checkbox' class='check_func valor_true padre$value->padre_id' data-id='$value->id' name='permiso_admin[$value->slug]' $disabled_hijo ". (($permiso_valida === true) ? 'checked' : '') .">";

                                $componente .= "<a class='ancla-permisos-usuario ml-1' role='button' data-toggle='collapse' data-parent='#accordion' href='#collapsePermisoRol$value->id' aria-expanded='true' aria-controls='collapsePermisoRol$value->id'>";
                                    $componente .= $value->nombre_menu;
                                $componente .= '</a>';
                            $componente .= '</h5>';
                        $componente .= '</div>';

                        $componente .= "<div id='collapsePermisoRol$value->id' class='panel-collapse collapse in' role='tabpanel' aria-labelledby='headingOne'>";
                            $componente .= '<div class="panel-body">';
                                //Body
                                $hijos = Menu::where("padre_id", $value->id)->get();

                                foreach ($hijos as $hijo) {
                                    $permiso_valida = "";

                                    //Para marcar el check si ya tiene asignado el permiso
                                    if (array_key_exists($hijo->slug, $permisos)) {
                                        $permiso_valida = $permisos["$hijo->slug"];
                                    } else {
                                        $permiso_valida = "";
                                    }

                                    $componente .= '<div class="checkbox">';
                                        $componente .= '<label>';
                                            $componente .= "<input type='checkbox' class='check_func valor_true padre$hijo->padre_id' data-id='$hijo->id' name='permiso_admin[$hijo->slug]' $disabled_hijo ". (($permiso_valida === true) ? 'checked' : '') ." >";
                                            $componente .= $hijo->nombre_menu;
                                        $componente .= '</label>';
                                    $componente .= '</div>';
                                }

                            $componente .= '</div>';
                        $componente .= '</div>';
                    $componente .= '</div>';
                $componente .= '</div>';
            $componente .= '</div>';
        }
        
        return $componente;
    }

    // Verificar si el cliente tiene acceso
    public static function getListaVinculanteAcceso($cliente_id)
    {
        $acceso = ConsultaListaVinculanteAccess::where('cliente_id', $cliente_id)->first();

        return $acceso;
    }

    /**
     * If the string is less than or equal to the limit, return the string. Otherwise, return the
     * string up to the limit, with the end string appended
     * 
     * @param value The string to be truncated
     * @param limit The maximum number of characters to limit the string to.
     * @param end The string to append to the trimmed string.
     * 
     * @return the value of the string.
     */
    public static function str_limit($value, $limit = 30, $end = '...'){
        if (mb_strwidth($value, 'UTF-8') <= $limit) {
            return $value;
        }
        return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')).$end;
    }
}
