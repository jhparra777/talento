<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\DatosBasicos;
use App\Models\RegistroProceso;
use App\Models\Requerimiento;
use App\Models\Sitio;
use App\Models\User;

use App\Models\PruebaCompetenciaCargo;
use App\Models\PruebaCompetenciaConcepto;
use App\Models\PruebaCompetenciaDirecta;
use App\Models\PruebaCompetenciaFamilia;
use App\Models\PruebaCompetenciaFamiliaNivel;
use App\Models\PruebaCompetenciaInversa;
use App\Models\PruebaCompetenciaNivelCompetencia;
use App\Models\PruebaCompetenciaResultado;
use App\Models\PruebaCompetenciaReq;
use App\Models\PruebaCompetenciaTotal;
use App\Models\PruebaCompetenciaFoto;
use App\Models\PruebaCompetenciaCandidatoHistorico;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use triPostmaster;
use Carbon\Carbon;
use PDF;

use Storage;
use File;

use SnappyPDF;

class PruebaCompetenciasController extends Controller
{
    public function __construct(){
        parent::__construct();

        $this->meses = [
            1  => "Enero",
            2  => "Febrero",
            3  => "Marzo",
            4  => "Abril",
            5  => "Mayo",
            6  => "Junio",
            7  => "Julio",
            8  => "Agosto",
            9  => "Septiembre",
            10 => "Octubre",
            11 => "Noviembre",
            12 => "Diciembre"
        ];
    }

    public function index(Request $data)
    {
        if(empty($this->user->id)){
            session(["url_deseada_redireccion_candidato" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login');
        }

        $check_test = PruebaCompetenciaResultado::where('user_id', $this->user->id)->where('estado', 0)->orderBy('created_at', 'DESC')->first();

        if(empty($check_test)){
            return redirect()->route('dashboard')->with('no_prueba', 'Actualmente no tienes pruebas a realizar.');
        }

        $name_user = DatosBasicos::where('user_id', $this->user->id)
        ->select('datos_basicos.nombres', DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido) AS nombre_candidato"))
        ->first();

        $sitio = Sitio::first();
        $user = User::find($this->user->id);

        return view('cv.pruebas.competencias.prueba_competencias_index', compact('sitio', 'user', 'name_user'));
    }

    public function start(Request $data)
    {
        if(empty($this->user->id)){
            session(["url_deseada_redireccion_candidato" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login');
        }

        $check_test = PruebaCompetenciaResultado::where('user_id', $this->user->id)->where('estado', 0)->orderBy('created_at', 'DESC')->first();

        if(empty($check_test)){
            return redirect()->route('dashboard')->with('no_prueba', 'Actualmente no tienes pruebas a realizar.');
        }

        $sitio = Sitio::first();
        $user = User::find($this->user->id);
        $requerimientoId = $check_test->req_id;

        //Buscar configuración
        $configuracionPrueba = PruebaCompetenciaReq::where('req_id', $requerimientoId)->get();

        if (count($configuracionPrueba) <= 0) {
            $requerimiento = Requerimiento::where('id', $requerimientoId)->select('cargo_especifico_id')->first();
            $configuracionPrueba = PruebaCompetenciaCargo::where('cargo_id', $requerimiento->cargo_especifico_id)->get();
        }

        $directasCompetencia = [];
        $directasNivel = [];

        foreach ($configuracionPrueba as $configuracion) {
            array_push($directasCompetencia, $configuracion->competencia_id);
            array_push($directasNivel, $configuracion->nivel_cargo);
        }

        $directas = PruebaCompetenciaDirecta::whereIn('nivel_cargo', array_unique($directasNivel))->whereIn('competencia_id', $directasCompetencia)->orderByRaw("RAND()")->get();

        $directasIds = [];

        foreach ($directas as $directa) {
            array_push($directasIds, $directa->id);
        }

        $inversas = PruebaCompetenciaInversa::whereIn('directa_id', $directasIds)->orderByRaw("RAND()")->get();

        $totalPreguntas = collect();

        foreach ($directas as $key => $directa) {
            $totalPreguntas->push($directa);
            $totalPreguntas->push($inversas[$key]);
        }

        //dd($totalPreguntas);

        return view('cv.pruebas.competencias.prueba_competencias', compact('sitio', 'user', 'requerimientoId', 'totalPreguntas'));
    }

    public function store(Request $data)
    {
        $userId = $data->userId;
        $requerimientoId = $data->requerimientoId;
        $sitio = Sitio::first();

        $inversas = $data->inversas;
        $preguntas_id = $data->preguntas_id;
        $competencias_id = $data->competencias_id;
        $codigos = $data->codigos;

        //Buscar prueba
        $pruebaCompetencias = PruebaCompetenciaResultado::where('req_id', $requerimientoId)->where('user_id', $userId)->orderBy('created_at', 'DESC')->first();

        //Buscar configuración
        $configuracionPrueba = PruebaCompetenciaReq::where('req_id', $requerimientoId)->get();

        if (!count($configuracionPrueba) > 0) {
            $requerimiento = Requerimiento::where('id', $requerimientoId)->select('cargo_especifico_id')->first();
            $configuracionPrueba = PruebaCompetenciaCargo::where('cargo_id', $requerimiento->cargo_especifico_id)->get();
        }

        //Sumar totales de las competencias
        $resultadoTotalCompetencias = [];

        for($i = 0; $i < count($inversas); $i++) {
            if($inversas[$i] != 1) {
                $resultadoTotalCompetencias[$competencias_id[$i]] = $data["pregunta_$codigos[$i]"] + $resultadoTotalCompetencias[$competencias_id[$i]];
            }
        }

        //Calcular desfases de los totales
        $resultadosTotalDesfases = [];

        foreach ($configuracionPrueba as $key => $configuracion) {
            //$desfase = ($resultadoTotalCompetencias[$configuracion->competencia_id] / $configuracion->nivel_esperado)-1;
            $desfase = $resultadoTotalCompetencias[$configuracion->competencia_id] - $configuracion->nivel_esperado;

            //$resultadosTotalDesfases[$configuracion->competencia_id] = number_format($desfase * 100, 1);
            $resultadosTotalDesfases[$configuracion->competencia_id] = number_format($desfase, 1);
        }

        //Calcular desfases de los totales y convirtiendo a abs
        $resultadosTotalDesfasesAbsolutos = [];

        foreach ($configuracionPrueba as $key => $configuracion) {
            //$desfaseAbs = abs(1-($resultadoTotalCompetencias[$configuracion->competencia_id] / $configuracion->nivel_esperado));
            $desfaseAbs = abs($resultadoTotalCompetencias[$configuracion->competencia_id] - $configuracion->nivel_esperado);

            //$resultadosTotalDesfasesAbsolutos[$configuracion->competencia_id] = number_format($desfaseAbs * 100, 1);
            $resultadosTotalDesfasesAbsolutos[$configuracion->competencia_id] = number_format($desfaseAbs, 1);
        }

        //Calcular ajuste al perfil por cada competencia
        $resultadosAjustesPerfiles = [];

        foreach ($configuracionPrueba as $key => $configuracion) {
            $ajustePerfil = 100 - $resultadosTotalDesfasesAbsolutos[$configuracion->competencia_id].'%';

            $resultadosAjustesPerfiles[$configuracion->competencia_id] = $ajustePerfil;
        }

        //Calcular factor y ajuste perfil global
        $ajustePerfilGlobal = number_format(array_sum($resultadosAjustesPerfiles) / count($resultadosAjustesPerfiles), 1);
        $factorGlobalDesfase = number_format(array_sum($resultadosTotalDesfases) / count($resultadosTotalDesfases), 1);

        //\Log::debug(json_encode($resultadoTotalCompetencias));
        //\Log::debug(json_encode($resultadosTotalDesfases));
        //\Log::debug(json_encode($resultadosTotalDesfasesAbsolutos));
        //\Log::debug(json_encode($resultadosAjustesPerfiles));
        //\Log::debug(json_encode($ajustePerfilGlobal));
        //\Log::debug(json_encode($factorGlobalDesfase));

        //Guardar resultados totales de todas las competencias
        ksort($resultadoTotalCompetencias);

        foreach($resultadoTotalCompetencias as $key => $total) {
            $competenciaTotal = new PruebaCompetenciaTotal();

            $competenciaTotal->fill([
                'prueba_id' => $pruebaCompetencias->id,
                'req_id' => $requerimientoId,
                'user_id' => $userId,
                'competencia_id' => $key,
                'calificacion_obtenida' => $total,
                'desfase' => $resultadosTotalDesfases[$key],
                'desfase_absoluto' => $resultadosTotalDesfasesAbsolutos[$key],
                'ajuste_perfil' => $resultadosAjustesPerfiles[$key]
            ]);
            $competenciaTotal->save();
        }

        //Actualizar prueba resultado
        $pruebaCompetencias->ajuste_global = $ajustePerfilGlobal;
        $pruebaCompetencias->factor_desfase_global = $factorGlobalDesfase;
        $pruebaCompetencias->estado = 1;
        $pruebaCompetencias->fecha_realizacion = date('Y-m-d');
        $pruebaCompetencias->save();

        /**
         * Guardar historial
         */

        $respuestas = $data->except(['userId', 'requerimientoId', 'inversas', 'preguntas_id', 'competencias_id', 'codigos']);

        foreach ($respuestas as $key => $value) {
            switch ($value) {
                case 15:
                    $opcion = 'Siempre';
                    break;
                case 12:
                    $opcion = 'Casi siempre';
                    break;
                case 9:
                    $opcion = 'Algunas veces';
                    break;
                case 6:
                    $opcion = 'Casi nunca';
                    break;
                case 3:
                    $opcion = 'Nunca';
                    break;
            }

            $codigo_pregunta = strstr($key, 'C');

            $pregunta_prueba = PruebaCompetenciaDirecta::where('codigo', 'like', "%$codigo_pregunta%")->pluck('descripcion');

            if (empty($pregunta_prueba)) {
                $pregunta_prueba = PruebaCompetenciaInversa::where('codigo', 'like', "%$codigo_pregunta%")->pluck('descripcion');
            }

            //Log::debug($pregunta_prueba);

            $historico = new PruebaCompetenciaCandidatoHistorico();

            $historico->fill([
                'user_id' => $userId,
                'req_id' => $requerimientoId,
                'prueba_id' => $pruebaCompetencias->id,
                'codigo_pregunta' => $codigo_pregunta,
                'pregunta' => $pregunta_prueba,
                'opcion' => $opcion
            ]);

            $historico->save();
        }

        //Colocar la prueba en pendiente
        RegistroProceso::where('candidato_id', $userId)
            ->where('requerimiento_id', $requerimientoId)
            ->where('proceso', 'ENVIO_PRUEBA_COMPETENCIA')
        ->update(['apto' => 3]);

        /**
         *
         * Usar administrador de correos
        */
        
            $informacionUsuarioGestion = DatosBasicos::where('user_id', $pruebaCompetencias->gestion_id)->select('nombres', 'email')->first();
            $informacionUsuarioPrueba = DatosBasicos::where('user_id', $userId)->first();

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Notificación PS (Personal Skills)"; //Titulo o tema del correo

            //Cuerpo con html y comillas dobles para las variables
            $mailBody = "
                Hola $informacionUsuarioGestion->nombres, te informamos que el(la) candidato(a) $informacionUsuarioPrueba->nombres $informacionUsuarioPrueba->primer_apellido asociado(a) al requerimiento <b>$data->requerimientoId</b> ha terminado con éxito la realización de la prueba PS (Personal Skills). <br>
                Para ver sus resultados puedes ingresar al menú lateral en la plataforma <i>Proceso de Selección > Pruebas PS (Personal Skills)</i> y buscar por su número de documento. <br>
                También puedes dar clic en <b>Ver resultados</b> e ir directamente a la página.
            ";

            //Arreglo para el botón
            $mailButton = ['buttonText' => 'Ver resultados', 'buttonRoute' => route('admin.pruebas_competencias_gestion', ['prueba_id' => $pruebaCompetencias->id])];

            $mailUser = $userId; //Id del usuario al que se le envía el correo

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            //Enviar correo generado
            Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($informacionUsuarioGestion, $sitio) {
                $message->to([$informacionUsuarioGestion->email], 'T3RS')
                ->bcc($sitio->email_replica)
                ->subject("Notificación PS (Personal Skills)")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        /**
         * Fin administrador correos
        */

        //Crear variables en la sesión para marcar el final de la prueba
        $data->session()->put('finalDigitacion', true);

        return response()->json([
            'success' => true
        ]);
    }

    public function guardar_fotos(Request $data)
    {
        //Buscar prueba
        $pruebaCompetencias = PruebaCompetenciaResultado::where('req_id', $data->requerimientoId)
        ->where('user_id', $data->userId)
        ->select('id', 'created_at')
        ->orderBy('created_at', 'DESC')
        ->first();

        $user_id = $data->userId;
        $req_id = $data->requerimientoId;

        //Fotos
        $psImagenes = json_decode($data->psImagenes, true);

        //Borrar primera foto del arreglo, porque no tiene información
        unset($psImagenes[0]);

        for($i = 1; $i <= count($psImagenes); $i++) {
            //Se verifica que la imagen tenga datos
            if ($psImagenes[$i]['picture'] != null && $psImagenes[$i]['picture'] != '' && $psImagenes[$i]['picture'] != 'data:,') {
                //Convertir base64 a PNG
                $image_parts = explode(";base64,", $psImagenes[$i]['picture']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fotoNombre = "candidato-foto-$i-$user_id-$req_id-$pruebaCompetencias->id.png";

                Storage::disk('public')
                    ->put("recursos_prueba_ps/prueba_ps_$user_id"."_"."$req_id"."_"."$pruebaCompetencias->id/$fotoNombre", $image_base64);

                //Guardar referencia foto en la tabla
                $psFoto = new PruebaCompetenciaFoto();

                $psFoto->fill([
                    'prueba_id' => $pruebaCompetencias->id,
                    'user_id' => $user_id,
                    'req_id' => $req_id,
                    'descripcion' => $fotoNombre
                ]);
                $psFoto->save();
            }
        }
    }

    /*
     * ADMIN
    */
    public function lista_pruebas_competencias(Request $data)
    {
        $estado_competencias = 0;

        $lista_competencias = PruebaCompetenciaResultado::join('datos_basicos', 'datos_basicos.user_id', '=', 'prueba_competencias_resultados.user_id')
        ->where(function ($sql) use ($data, &$estado_competencias) {
            //Filtro por requerimiento
            if ($data->requerimiento != "") {
                $estado_competencias = 1;
                $sql->where("prueba_competencias_resultados.req_id", $data->requerimiento);
            }

            //Filtro por cédula de candidato
            if ($data->cedula != "") {
                $estado_competencias = 1;
                $sql->where("datos_basicos.numero_id", $data->cedula);
            }
        })
        ->whereIn('prueba_competencias_resultados.estado', [0, $estado_competencias])
        //->whereRaw("(prueba_competencias_resultados.estado IS NULL OR  prueba_competencias_resultados.estado = $estado_competencias)")
        ->select(
            'datos_basicos.numero_id as cedula',
            DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo"),

            'prueba_competencias_resultados.req_id',
            'prueba_competencias_resultados.id as prueba_id',
            'prueba_competencias_resultados.fecha_realizacion'
        )
        ->orderBy('prueba_competencias_resultados.created_at', 'DESC')
        ->orderBy('prueba_competencias_resultados.id', 'DESC')
        ->paginate(6);

        return view('admin.reclutamiento.pruebas.competencias.lista_competencias', compact('lista_competencias'));
    }

    public function gestion_prueba_competencias($prueba_id)
    {
        $candidato_competencia = PruebaCompetenciaResultado::join('datos_basicos', 'datos_basicos.user_id', '=', 'prueba_competencias_resultados.user_id')
        ->where('prueba_competencias_resultados.id', $prueba_id)
        ->select(
            'prueba_competencias_resultados.*',

            'datos_basicos.nombres',
            DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo")
        )
        ->first();

        $concepto_prueba = PruebaCompetenciaConcepto::where('prueba_id', $prueba_id)->first();

        $competencia_fotos = PruebaCompetenciaFoto::where('prueba_id', $prueba_id)
        ->where('user_id', $candidato_competencia->user_id)
        ->where('req_id', $candidato_competencia->req_id)
        ->orderBy('id', 'DESC')
        ->get();

        //
            $totales_prueba = PruebaCompetenciaTotal::join('prueba_competencias_competencia', 'prueba_competencias_competencia.id', '=', 'prueba_competencias_totales.competencia_id')
            ->where('prueba_id', $prueba_id)
            ->where('user_id', $candidato_competencia->user_id)
            ->orderBy('prueba_competencias_totales.competencia_id', 'ASC')
            ->get();

            //Competencias ajustes
            $sobresalientes = [];
            $sobresalientesDesc = [];

            foreach ($totales_prueba as $key => $total) {
                $sobresalientes[$total->ajuste_perfil."_".$key] = $total->ajuste_perfil;
                $sobresalientesDesc[$total->ajuste_perfil."_".$key] = $total->descripcion;
                $sobresalientesDefinicion[$total->ajuste_perfil."_".$key] = $total->definicion;
            }

            //Más altos
                $sobresalienteA = array_keys($sobresalientes, max($sobresalientes));
                unset($sobresalientes[$sobresalienteA[0]]);

                $sobresalienteB = array_keys($sobresalientes, max($sobresalientes));
                unset($sobresalientes[$sobresalienteB[0]]);
            //

            //Más bajos
                $desarrollarA = array_keys($sobresalientes, min($sobresalientes));
                unset($sobresalientes[$desarrollarA[0]]);

                $desarrollarB = array_keys($sobresalientes, min($sobresalientes));
                unset($sobresalientes[$desarrollarB[0]]);
            //

            //Buscar configuración
            $configuracionPrueba = PruebaCompetenciaReq::where('req_id', $candidato_competencia->req_id)->orderBy('competencia_id', 'ASC')->get();

            if (!count($configuracionPrueba) > 0) {
                $requerimiento = Requerimiento::where('id', $candidato_competencia->req_id)->select('cargo_especifico_id')->first();
                $configuracionPrueba = PruebaCompetenciaCargo::where('cargo_id', $requerimiento->cargo_especifico_id)->orderBy('competencia_id', 'ASC')->get();
            }
        //

        $requerimiento_detalle = Requerimiento::where('requerimientos.id', $candidato_competencia->req_id)->first();

        return view('admin.reclutamiento.pruebas.competencias.gestionar_competencias', compact(
            'candidato_competencia',
            'concepto_prueba',
            'competencia_fotos',
            'totales_prueba',
            'sobresalientesDesc',
            'sobresalientesDefinicion',
            'sobresalienteA',
            'sobresalienteB',
            'desarrollarA',
            'desarrollarB',
            'configuracionPrueba',
            'requerimiento_detalle'
        ));
    }

    public function concepto_prueba_competencias(Request $data)
    {
        $prueba_id = $data->prueba_id;
        $candidato_id = $data->candidato_competencia;
        $concepto_prueba = $data->concepto_prueba;
        $estadoConcepto = $data->estadoPrueba;

        //Buscar si existe concepto
        $concepto = PruebaCompetenciaConcepto::where('prueba_id', $prueba_id)->first();
        $resultado=PruebaCompetenciaResultado::find($prueba_id);
        $candi=DatosBasicos::where("user_id",$resultado->user_id)->select("numero_id as cedula")->first();

        if(empty($concepto)) {
            $concepto = new PruebaCompetenciaConcepto();
            $concepto->fill([
                'prueba_id' => $prueba_id,
                'gestion_id' => $this->user->id,
                'concepto' => $concepto_prueba
            ]);
        }else {
            $concepto->fill([
                'gestion_id' => $this->user->id,
                'concepto' => $concepto_prueba
            ]);
        }

        $concepto->save();

        //Marca como terminado el proceso
        $proceso = RegistroProceso::where('candidato_id', $candidato_id)
        ->where('proceso', 'ENVIO_PRUEBA_COMPETENCIA')
        ->where('estado', 7)
        ->orderBy('created_at', 'DESC')
        ->first();

        $proceso->apto = (int) $estadoConcepto;
        $proceso->observaciones = $concepto_prueba;
        $proceso->usuario_terminacion = $this->user->id;
        $proceso->save();

        

        $pdf=$this->informe_prueba_competencias($prueba_id,1);

        if(file_exists('documentos_candidatos/'.$candi->cedula.'/'.$resultado->req_id.'/seleccion/prueba_competencias_'.$candi->cedula.'_'.$resultado->req_id.'.pdf')){

            Storage::disk('public')->delete('documentos_candidatos/'.$candi->cedula.'/'.$resultado->req_id.'/seleccion/prueba_competencias_'.$candi->cedula.'_'.$resultado->req_id.'.pdf');
        }
        Storage::disk('public')->put('documentos_candidatos/'.$candi->cedula.'/'.$resultado->req_id.'/seleccion/prueba_competencias_'.$candi->cedula.'_'.$resultado->req_id.'.pdf',$pdf);


        return response()->json(['success' => true]);
    }

    public function informe_prueba_competencias($prueba_id,$download=0)
    {
        $candidato_prueba = PruebaCompetenciaResultado::join('datos_basicos', 'datos_basicos.user_id', '=', 'prueba_competencias_resultados.user_id')
        ->join('users', 'users.id', '=', 'datos_basicos.user_id')
        ->where('prueba_competencias_resultados.id', $prueba_id)
        ->select(
            'prueba_competencias_resultados.*',

            'datos_basicos.nombres',
            'datos_basicos.primer_apellido',
            'datos_basicos.numero_id as cedula',
            'datos_basicos.fecha_nacimiento',
            'datos_basicos.telefono_movil as celular',
            'datos_basicos.email as correo',
            DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo"),

            'users.foto_perfil'
        )
        ->first();

        $totales_prueba = PruebaCompetenciaTotal::join('prueba_competencias_competencia', 'prueba_competencias_competencia.id', '=', 'prueba_competencias_totales.competencia_id')
        ->where('prueba_id', $candidato_prueba->id)
        ->where('user_id', $candidato_prueba->user_id)
        ->orderBy('prueba_competencias_totales.competencia_id', 'ASC')
        ->get();

        $pskills_fotos = PruebaCompetenciaFoto::where('prueba_id', $prueba_id)
        ->where('user_id', $candidato_prueba->user_id)
        ->where('req_id', $candidato_prueba->req_id)
        ->orderBy('id', 'DESC')
        ->get();

        //Competencias ajustes
        $sobresalientes = [];
        $sobresalientesDesc = [];

        // Se concatena key adicional para conservar los resultados duplicados

        foreach ($totales_prueba as $key => $total) {
            $sobresalientes[$total->ajuste_perfil."_".$key] = $total->ajuste_perfil;
            $sobresalientesDesc[$total->ajuste_perfil."_".$key] = $total->descripcion;
            $sobresalientesDefinicion[$total->ajuste_perfil."_".$key] = $total->definicion;
        }

        // $sobresalienteA = array_keys($sobresalientes, max($sobresalientes));
        // unset($sobresalientes[$sobresalienteA[0]]);

        //Más altos
            $sobresalienteA = array_keys($sobresalientes, max($sobresalientes));
            unset($sobresalientes[$sobresalienteA[0]]);

            // $sobresalienteA = array_values($sobresalientes);
            // $sobresalienteA = max($sobresalienteA);
            // unset($sobresalientes[$sobresaliente_a_key[0]]);

            $sobresalienteB = array_keys($sobresalientes, max($sobresalientes));
            unset($sobresalientes[$sobresalienteB[0]]);

            // $sobresalienteB = array_values($sobresalientes);
            // $sobresalienteB = max($sobresalienteB);
            // unset($sobresalientes[$sobresaliente_b_key[0]]);
        //

        //Más bajos
            $desarrollarA = array_keys($sobresalientes, min($sobresalientes));
            unset($sobresalientes[$desarrollarA[0]]);

            // $desarrollarA = array_values($sobresalientes);
            // $desarrollarA = max($desarrollarA);
            // unset($sobresalientes[$desarrollar_a_key[0]]);

            $desarrollarB = array_keys($sobresalientes, min($sobresalientes));
            unset($sobresalientes[$desarrollarB[0]]);

            // $desarrollarB = array_values($sobresalientes);
            // $desarrollarB = max($desarrollarB);
            // unset($sobresalientes[$desarrollar_b_key[0]]);
        //

        //Buscar configuración
        $configuracionPrueba = PruebaCompetenciaReq::where('req_id', $candidato_prueba->req_id)->orderBy('competencia_id', 'ASC')->get();

        if (!count($configuracionPrueba) > 0) {
            $requerimiento = Requerimiento::where('id', $candidato_prueba->req_id)->select('cargo_especifico_id')->first();
            $configuracionPrueba = PruebaCompetenciaCargo::where('cargo_id', $requerimiento->cargo_especifico_id)->orderBy('competencia_id', 'ASC')->get();
        }

        $sitio_informacion = Sitio::first();

        $concepto = PruebaCompetenciaConcepto::where('prueba_id', $prueba_id)->first();

        //Convertir fecha de solicitud a letras
        $fecha_evaluacion = explode('-', date('Y-m-d', strtotime($candidato_prueba->created_at)));
        $fecha_evaluacion_letra = "$fecha_evaluacion[2] de ".$this->meses[(int) $fecha_evaluacion[1]]." del $fecha_evaluacion[0]";

        //Convertir fecha de realización a letras
        $fecha_realizacion = explode('-', date('Y-m-d', strtotime($candidato_prueba->fecha_realizacion)));
        $fecha_realizacion_letra = "$fecha_realizacion[2] de ".$this->meses[(int) $fecha_realizacion[1]]." del $fecha_realizacion[0]";

        $candidato_edad = Carbon::parse($candidato_prueba->fecha_nacimiento)->age;

        $requerimiento_detalle = Requerimiento::where('requerimientos.id', $candidato_prueba->req_id)->first();

        /*Validar ruta para local*/
        if (route('home') == 'http://localhost:8000') {
            //$url = 'https://desarrollo.t3rsc.co/assets/admin/tests/ps-skills/';
        }else {
            //$url = asset('assets/admin/tests/ps-skills').'/';
        }

        $url = asset('assets/admin/tests/ps-skills').'/';

        if(!$download) {
            return view('cv.pruebas.competencias.pdf.informe_resultado_competencias_new', [
                "candidato_prueba" => $candidato_prueba,
                "totales_prueba" => $totales_prueba,
                "pskills_fotos" => $pskills_fotos,
                "sobresalientesDesc" => $sobresalientesDesc,
                "sobresalientesDefinicion" => $sobresalientesDefinicion,
                "sobresalienteA" => $sobresalienteA,
                "sobresalienteB" => $sobresalienteB,
                "desarrollarA" => $desarrollarA,
                "desarrollarB" => $desarrollarB,
                "configuracionPrueba" => $configuracionPrueba,
                "sitio_informacion" => $sitio_informacion,
                "concepto" => $concepto,
                "candidato_edad" => $candidato_edad,
                "fecha_evaluacion_letra" => $fecha_evaluacion_letra,
                "fecha_realizacion_letra" => $fecha_realizacion_letra,
                "requerimiento_detalle" => $requerimiento_detalle,
                "url" => $url
            ]);
        }
        else {
            $img_base64_referencia_puntaje = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-referencia-puntaje-crop.txt');
            $img_base64_t3rs_without_bg = file_get_contents('assets/admin/tests/ps-skills/text_base64/t3rs-without-bg.txt');

            /**
             * Validando resultados para devolver base64 correspondiente
             */

            if ($candidato_prueba->factor_desfase_global < 0) {
                $img_base64_negativo_positivo = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-negativo.txt');
            } else {
                $img_base64_negativo_positivo = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-positivo.txt');
            }

            /**
             * Gráfico circular
             */

            if($candidato_prueba->ajuste_global < 25) {
                $img_base64_barra_circular = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-barra-circular-01.txt');

            } elseif($candidato_prueba->ajuste_global >= 25 && $candidato_prueba->ajuste_global <= 50) {
                $img_base64_barra_circular = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-barra-circular-00.txt');

            } elseif($candidato_prueba->ajuste_global >= 50 && $candidato_prueba->ajuste_global <= 75) {

                if($candidato_prueba->ajuste_global > 50 && $candidato_prueba->ajuste_global <= 55) {
                    $img_base64_barra_circular = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-barra-circular-02.txt');

                } elseif($candidato_prueba->ajuste_global > 55 && $candidato_prueba->ajuste_global <= 58) {
                    $img_base64_barra_circular = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-barra-circular-03.txt');

                } elseif($candidato_prueba->ajuste_global > 58 && $candidato_prueba->ajuste_global <= 64) {
                    $img_base64_barra_circular = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-barra-circular-04.txt');

                } elseif($candidato_prueba->ajuste_global > 64 && $candidato_prueba->ajuste_global <= 68) {
                    $img_base64_barra_circular = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-barra-circular-05.txt');

                } elseif($candidato_prueba->ajuste_global > 68 && $candidato_prueba->ajuste_global <= 72) {
                    $img_base64_barra_circular = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-barra-circular-06.txt');

                } elseif($candidato_prueba->ajuste_global > 72 && $candidato_prueba->ajuste_global <= 75) {
                    $img_base64_barra_circular = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-barra-circular-07.txt');
                }

            } elseif($candidato_prueba->ajuste_global >= 75 && $candidato_prueba->ajuste_global <= 100) {

                if($candidato_prueba->ajuste_global > 75 && $candidato_prueba->ajuste_global <= 78) {
                    $img_base64_barra_circular = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-barra-circular-08.txt');

                } elseif($candidato_prueba->ajuste_global > 78 && $candidato_prueba->ajuste_global <= 80) {
                    $img_base64_barra_circular = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-barra-circular-09.txt');

                } elseif($candidato_prueba->ajuste_global > 80 && $candidato_prueba->ajuste_global <= 84) {
                    $img_base64_barra_circular = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-barra-circular-10.txt');

                } elseif($candidato_prueba->ajuste_global > 84 && $candidato_prueba->ajuste_global <= 94) {
                    $img_base64_barra_circular = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-barra-circular-11.txt');

                } elseif($candidato_prueba->ajuste_global > 94 && $candidato_prueba->ajuste_global <= 100) {
                    $img_base64_barra_circular = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencia-barra-circular-12.txt');
                }
            }

            /**
             * Competencias sobresalientes
             */

            if($sobresalienteA[0] > 0 && $sobresalienteA[0] <= 24) {
                $img_base64_barra_turned_sobresalienteA = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-1.txt');

            } elseif($sobresalienteA[0] >= 25 && $sobresalienteA[0] <= 50) {
                $img_base64_barra_turned_sobresalienteA = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-2.txt');

            } elseif($sobresalienteA[0] > 50 && $sobresalienteA[0] <= 75) {
                $img_base64_barra_turned_sobresalienteA = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-3.txt');

            } elseif($sobresalienteA[0] > 75 && $sobresalienteA[0] <= 100) {
                $img_base64_barra_turned_sobresalienteA = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-4.txt');
            }

            /**
             * 
             */
            
            if($desarrollarA[0] > 0 && $desarrollarA[0] <= 24) {
                $img_base64_barra_turned_desarrollarA = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-1.txt');

            } elseif($desarrollarA[0] >= 25 && $desarrollarA[0] <= 50) {
                $img_base64_barra_turned_desarrollarA = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-2.txt');

            } elseif($desarrollarA[0] > 50 && $desarrollarA[0] <= 75) {
                $img_base64_barra_turned_desarrollarA = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-3.txt');

            } elseif($desarrollarA[0] > 75 && $desarrollarA[0] <= 100) {
                $img_base64_barra_turned_desarrollarA = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-4.txt');
            }

            /**
             * 
             */

            if($sobresalienteB[0] > 0 && $sobresalienteB[0] <= 24) {
                $img_base64_barra_turned_sobresalienteB = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-1.txt');

            } elseif($sobresalienteB[0] >= 25 && $sobresalienteB[0] <= 50) {
                $img_base64_barra_turned_sobresalienteB = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-2.txt');

            } elseif($sobresalienteB[0] > 50 && $sobresalienteB[0] <= 75) {
                $img_base64_barra_turned_sobresalienteB = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-3.txt');

            } elseif($sobresalienteB[0] > 75 && $sobresalienteB[0] <= 100) {
                $img_base64_barra_turned_sobresalienteB = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-4.txt');
            }

            /**
             * 
             */

            if($desarrollarB[0] > 0 && $desarrollarB[0] <= 24) {
                $img_base64_barra_turned_desarrollarB = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-1.txt');

            } elseif($desarrollarB[0] >= 25 && $desarrollarB[0] <= 50) {
                $img_base64_barra_turned_desarrollarB = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-2.txt');

            } elseif($desarrollarB[0] > 50 && $desarrollarB[0] <= 75) {
                $img_base64_barra_turned_desarrollarB = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-3.txt');

            } elseif($desarrollarB[0] > 75 && $desarrollarB[0] <= 100) {
                $img_base64_barra_turned_desarrollarB = file_get_contents('assets/admin/tests/ps-skills/text_base64/competencias-graf-turned-4.txt');
            }

            return SnappyPDF::loadView('cv.pruebas.competencias.pdf.informe_resultado_competencias', [
                "candidato_prueba" => $candidato_prueba,
                "totales_prueba" => $totales_prueba,
                "pskills_fotos" => $pskills_fotos,
                "sobresalientesDesc" => $sobresalientesDesc,
                "sobresalientesDefinicion" => $sobresalientesDefinicion,
                "sobresalienteA" => $sobresalienteA,
                "sobresalienteB" => $sobresalienteB,
                "desarrollarA" => $desarrollarA,
                "desarrollarB" => $desarrollarB,
                "configuracionPrueba" => $configuracionPrueba,
                "sitio_informacion" => $sitio_informacion,
                "concepto" => $concepto,
                "candidato_edad" => $candidato_edad,
                "fecha_evaluacion_letra" => $fecha_evaluacion_letra,
                "fecha_realizacion_letra" => $fecha_realizacion_letra,
                "requerimiento_detalle" => $requerimiento_detalle,
                "url" => $url,
                "img_base64_referencia_puntaje" => $img_base64_referencia_puntaje,
                "img_base64_t3rs_without_bg" => $img_base64_t3rs_without_bg,
                "img_base64_negativo_positivo" => $img_base64_negativo_positivo,
                "img_base64_barra_circular" => $img_base64_barra_circular,
                "img_base64_barra_turned_sobresalienteA" => $img_base64_barra_turned_sobresalienteA,
                "img_base64_barra_turned_desarrollarA" => $img_base64_barra_turned_desarrollarA,
                "img_base64_barra_turned_sobresalienteB" => $img_base64_barra_turned_sobresalienteB,
                "img_base64_barra_turned_desarrollarB" => $img_base64_barra_turned_desarrollarB
            ])
            ->output();
            //->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            //->stream("informe-personal-skills-".$candidato_prueba->req_id."-".explode(" ", $candidato_prueba->nombres)[0]."-".$candidato_prueba->primer_apellido.".pdf");
        }
    }

    /*
     * Devuelve las competencias en el evento del radio button del modal
    */
    public function cargar_configuracion(Request $data)
    {
        $nivelCompetencias = PruebaCompetenciaNivelCompetencia::where('nivel_id', $data->nivel_id)->groupBy('competencia_id')->get();

        return view("admin.pruebas.competencias.includes._section_lista_competencias", compact('nivelCompetencias'));
    }

    public function configuracion_cargo(Request $data)
    {
        //Busca si hay configuración para cargarla al modal
        $configuracion = [];
        $configuracionCargo = (isset($data->configuracion_cargo)) ? true : null;

        $cargoId = null;

        if(isset($data->configuracion_cargo)) {
            $cargoGenericoId = $data->cargo_generico_id;
            $cargoId = $data->cargo_id;

            //Buscar cascada de prueba
            $genericoFamilia = PruebaCompetenciaFamilia::where('generico_id', $cargoGenericoId)->first();

            $familiaNiveles = PruebaCompetenciaFamiliaNivel::where('familia_id', $genericoFamilia->id)->get();

            $nivelesId = [];

            foreach ($familiaNiveles as $nivel) {
                array_push($nivelesId, $nivel->nivel_id);
            }

            $nivelCompetencias = PruebaCompetenciaNivelCompetencia::where('nivel_id', $nivelesId[0])->groupBy('competencia_id')->get();

            $configuracionPrueba = PruebaCompetenciaCargo::where('cargo_id', $cargoId)->get();

            foreach ($configuracionPrueba as $prueba) {
                $configuracion[$prueba->competencia_id] = (object) [
                    "id" => $prueba->id,
                    "cargo_id" => $prueba->cargo_id,
                    "nivel_cargo" => $prueba->nivel_cargo,
                    "competencia_id" => $prueba->competencia_id,
                    "nivel_esperado" => $prueba->nivel_esperado,
                    "margen_acertividad" => $prueba->margen_acertividad,
                    "created_at" => $kactus->created_at,
                    "updated_at" => $kactus->updated_at
                ];
            }
        }else {
            $cargoGenericoId = $data->cargo_generico_id;

            //Buscar cascada de prueba
            $genericoFamilia = PruebaCompetenciaFamilia::where('generico_id', $cargoGenericoId)->first();

            $familiaNiveles = PruebaCompetenciaFamiliaNivel::where('familia_id', $genericoFamilia->id)->get();

            $nivelesId = [];

            foreach ($familiaNiveles as $nivel) {
                array_push($nivelesId, $nivel->nivel_id);
            }

            $nivelCompetencias = PruebaCompetenciaNivelCompetencia::where('nivel_id', $nivelesId[0])->groupBy('competencia_id')->get();
        }

        return view("admin.pruebas.competencias.includes._modal_configurar_prueba_competencias", compact(
            'cargoGenericoId',
            'cargoId',
            'familiaNiveles',
            'nivelCompetencias',
            'configuracionCargo',
            'configuracion'
        ));
    }

    public function guardar_configuracion_cargo(Request $data)
    {
        $cargoGenericoId = $data->cargo_generico_id;
        $competencias = $data->competencias;
        $nivelEsperado = $data->nivel_esperado;
        $margenAcertividad = $data->margen_acertividad;

        $configuracionIds = [];

        for($i = 0; $i < count($competencias); $i++) {
            $configuracionCargo = new PruebaCompetenciaCargo();

            $configuracionCargo->cargo_id = 0;
            $configuracionCargo->competencia_id = $competencias[$i];
            $configuracionCargo->nivel_cargo = $data->nivel_id;
            $configuracionCargo->nivel_esperado = $nivelEsperado[$i];
            $configuracionCargo->margen_acertividad = $margenAcertividad[$i];
            $configuracionCargo->save();

            array_push($configuracionIds, $configuracionCargo->id);
        }

        return response()->json(['success' => true, 'ids' => $configuracionIds]);
    }

    public function actualizar_configuracion_cargo(Request $data)
    {
        $cargoId = $data->cargo_id;
        $competencias = $data->competencias;
        $nivelEsperado = $data->nivel_esperado;
        $margenAcertividad = $data->margen_acertividad;

        $configuracionCargo = PruebaCompetenciaCargo::where('cargo_id', $cargoId)->delete();

        for($i = 0; $i < count($competencias); $i++) {
            $configuracionCargo = new PruebaCompetenciaCargo();

            $configuracionCargo->cargo_id = $cargoId;
            $configuracionCargo->competencia_id = $competencias[$i];
            $configuracionCargo->nivel_cargo = $data->nivel_id;
            $configuracionCargo->nivel_esperado = $nivelEsperado[$i];
            $configuracionCargo->margen_acertividad = $margenAcertividad[$i];
            $configuracionCargo->save();
        }

        return response()->json(['success' => true]);
    }

    //
    public function configuracion_requerimiento(Request $data)
    {
        $requerimientoId = $data->req_id;

        $requerimiento = Requerimiento::join('cargos_especificos', 'cargos_especificos.id', '=', 'requerimientos.cargo_especifico_id')
        ->select('cargos_especificos.cargo_generico_id', 'cargo_especifico_id')
        ->where('requerimientos.id', $data->req_id)
        ->first();

        $cargoGenericoId = $requerimiento->cargo_generico_id;

        //Buscar cascada de prueba
        $genericoFamilia = PruebaCompetenciaFamilia::where('generico_id', $cargoGenericoId)->first();

        $familiaNiveles = PruebaCompetenciaFamiliaNivel::where('familia_id', $genericoFamilia->id)->get();

        $nivelesId = [];

        foreach ($familiaNiveles as $nivel) {
            array_push($nivelesId, $nivel->nivel_id);
        }

        $nivelCompetencias = PruebaCompetenciaNivelCompetencia::where('nivel_id', $nivelesId[0])->groupBy('competencia_id')->get();

        $configuracionReq = true;

        //Busca si hay configuración para cargarla al modal
        $configuracionPrueba = PruebaCompetenciaReq::where('req_id', $requerimientoId)->get();

        if (count($configuracionPrueba) === 0) {
            $configuracionPrueba = PruebaCompetenciaCargo::where('cargo_id', $requerimiento->cargo_especifico_id)->get();
        }

        $configuracion = [];

        foreach ($configuracionPrueba as $prueba) {
            $configuracion[$prueba->competencia_id] = (object) [
                "id" => $prueba->id,
                "req_id" => $prueba->req_id,
                "nivel_cargo" => $prueba->nivel_cargo,
                "competencia_id" => $prueba->competencia_id,
                "nivel_esperado" => $prueba->nivel_esperado,
                "margen_acertividad" => $prueba->margen_acertividad,
                "created_at" => $kactus->created_at,
                "updated_at" => $kactus->updated_at
            ];
        }

        return view("admin.pruebas.competencias.includes._modal_configurar_prueba_competencias", compact(
            'requerimientoId',
            'familiaNiveles',
            'nivelCompetencias',
            'configuracionReq',
            'configuracion'
        ));
    }

    public function guardar_configuracion_requerimiento(Request $data)
    {
        $requerimientoId = $data->req_id;
        $competencias = $data->competencias;
        $nivelEsperado = $data->nivel_esperado;
        $margenAcertividad = $data->margen_acertividad;

        //
        $configuracionReq = PruebaCompetenciaReq::where('req_id', $requerimientoId)->delete();

        for($i = 0; $i < count($competencias); $i++) {
            $configuracionReq = new PruebaCompetenciaReq();

            $configuracionReq->req_id = $requerimientoId;
            $configuracionReq->competencia_id = $competencias[$i];
            $configuracionReq->nivel_cargo = $data->nivel_id;
            $configuracionReq->nivel_esperado = $nivelEsperado[$i];
            $configuracionReq->margen_acertividad = $margenAcertividad[$i];
            $configuracionReq->save();
        }

        return response()->json(['success' => true]);
    }
}
