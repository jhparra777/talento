<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\DatosBasicos;
use App\Models\GestionPrueba;
use App\Models\PruebaBrigPregunta;
use App\Models\PruebaBrigResultado;
use App\Models\PruebaBrigConcepto;
use App\Models\PruebaBrigConfigCargo;
use App\Models\PruebaBrigConfigRequerimiento;
use App\Models\PruebaBrygFoto;
use App\Models\RegistroProceso;
use App\Models\Requerimiento;
use App\Models\Sitio;
use App\Models\User;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use triPostmaster;
use Carbon\Carbon;
use PDF;

use Storage;
use File;

class PruebaPerfilController extends Controller
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

    //Inicio de la prueba CV
    public function index()
    {
        if(empty($this->user->id)){
            session(["url_deseada_redireccion_candidato" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login');
        }

        //Verificar si fue enviado a prueba
        $check_test = RegistroProceso::where('candidato_id', $this->user->id)
        ->where('proceso', 'ENVIO_PRUEBA_BRYG')
        ->where('estado', 7)
        ->whereNull('apto')
        ->orderBy('created_at', 'DESC')
        ->first();

        if(empty($check_test)){
            return redirect()->route('dashboard')->with('no_prueba', 'Actualmente no tienes pruebas a realizar.');
        }

        $name_user = DatosBasicos::where('user_id', $this->user->id)
        ->select(DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido) AS nombre_candidato"))
        ->first();

        $sitio = Sitio::first();
        $user = User::find($this->user->id);

        return view('cv.pruebas.bryg.prueba_perfil_index', compact('sitio', 'user', 'name_user'));
    }

    //Muestra la vista con preguntas CV
    public function start(Request $data)
    {
        if(empty($this->user->id)){
            session(["url_deseada_redireccion_candidato" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login');
        }

        //Verificar si fue enviado a prueba
        $check_test = RegistroProceso::where('candidato_id', $this->user->id)
        ->where('proceso', 'ENVIO_PRUEBA_BRYG')
        ->where('estado', 7)
        ->whereNull('apto')
        ->orderBy('created_at', 'DESC')
        ->first();

        if(empty($check_test)){
            return redirect()->route('dashboard')->with('no_prueba', 'Actualmente no tienes pruebas a realizar.');
        }

        $sitio = Sitio::first();
        $user = User::find($this->user->id);
        $requerimientoId = $check_test->requerimiento_id;

        $brig_questions = PruebaBrigPregunta::orderByRaw('RAND()')->get();

        //orderByRaw('RAND()')->
        $ids = array();
        foreach($brig_questions as $question){ $ids[] = (int)$question->id; }

        //Reload
        $reloadPage = $data->session()->get('reloadPage');

        if ($reloadPage === 'yes') {
            $data->session()->forget('reloadPage');
        }else {
            session(['reloadPage' => 'not']);
        }

        return view('cv.pruebas.bryg.prueba_brig', compact('brig_questions', 'sitio', 'user', 'requerimientoId', 'ids'));
    }

    //Devuelve las preguntas siguientes CV
    public function set_content(Request $data)
    {
        $ids = array_map('intval', explode(',', $data->ids));

        //$brig_questions = PruebaBrigPregunta::whereNotIn('id', $ids)->orderBy('id', 'RAND')->paginate(4);
        $brig_questions = PruebaBrigPregunta::orderByRaw('RAND()')->paginate(10);

        foreach($brig_questions as $question){ $ids[] = (int)$question->id; }

        $ids = json_encode($ids);

        return response()->json([
            'view' => view('cv.pruebas.bryg.paginacion_contenido', compact('brig_questions', 'ids'))->render(),
            'ids' => $ids
        ]);
    }

    //Guarda resultados prueba CV
    public function save_result(Request $data)
    {
        $userId = $data->userId;
        $requerimientoId = $data->requerimientoId;
        $sitio = Sitio::first();

        $result_test = PruebaBrigResultado::where('user_id', $userId)
        ->where('req_id', $requerimientoId)
        ->orderBy('created_at', 'DESC')
        ->first();

        $result_test->estilo_radical = $data->estilo_radical;
        $result_test->estilo_genuino = $data->estilo_genuino;
        $result_test->estilo_garante = $data->estilo_garante;
        $result_test->estilo_basico  = $data->estilo_basico;
        $result_test->aumented_a     = $data->aumented_a;
        $result_test->aumented_p     = $data->aumented_p;
        $result_test->aumented_d     = $data->aumented_d;
        $result_test->aumented_r     = $data->aumented_r;
        $result_test->estado         = 1;
        $result_test->fecha_realizacion = date('Y-m-d');
        $result_test->save();

        //Calcular ajuste al perfil
        $respuestasBryg = [
            'radical' => $result_test->estilo_radical,
            'genuino' => $result_test->estilo_genuino,
            'garante' => $result_test->estilo_garante,
            'basico' => $result_test->estilo_basico
        ];

        $ajustePerfil = $this->calcularAjustePerfil($respuestasBryg, $requerimientoId);

        if(!empty($ajustePerfil) || !$ajustePerfil == 0) {
            $result_test->ajuste_perfil = $ajustePerfil;
            $result_test->save();
        }

        //Colocar la prueba en pendiente
        RegistroProceso::where('candidato_id', $userId)
            ->where('requerimiento_id', $requerimientoId)
            ->where('proceso', 'ENVIO_PRUEBA_BRYG')
        ->update(['apto' => 3]);

        /**
         *
         * Usar administrador de correos
         *
        */
            $informacionUsuarioGestion = DatosBasicos::where('user_id', $result_test->gestion_id)->select('nombres', 'email')->first();
            $informacionUsuarioPrueba = DatosBasicos::where('user_id', $userId)->first();

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Notificación prueba BRYG-A"; //Titulo o tema del correo

            //Cuerpo con html y comillas dobles para las variables
            $mailBody = "
                Hola $informacionUsuarioGestion->nombres, te informamos que el/la candidat@ $informacionUsuarioPrueba->nombres $informacionUsuarioPrueba->primer_apellido asociad@ al requerimiento <b>$data->requerimientoId</b> ha terminado con éxito la realización de la prueba BRYG-A. <br>
                Para ver sus resultados puedes ingresar al menú lateral en la plataforma <i>Proceso de Selección > Pruebas BRYG-A</i> y buscar por su número de documento. <br>
                También puedes dar clic en <b>Ver resultados</b> e ir directamente a la página.
            ";

            //Arreglo para el botón
            $mailButton = ['buttonText' => 'Ver resultados', 'buttonRoute' => route('admin.pruebas_bryg_gestion', ['bryg_id' => $result_test->id])];

            $mailUser = $userId; //Id del usuario al que se le envía el correo

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            //Enviar correo generado
            Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($informacionUsuarioGestion, $sitio) {
                $message->to([$informacionUsuarioGestion->email], 'T3RS')
                ->bcc($sitio->email_replica)
                ->subject("Notificación BRYG-A")
                ->getHeaders()
                ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
            });
        /**
         * Fin administrador correos
        */

        //Crear variables en la sesión para marcar el final de la prueba
        $data->session()->put('finalBryg', true);

        return response()->json([
            'success' => true
        ]);
    }

    public function guardar_fotos(Request $data)
    {
        //Buscar prueba
        $pruebaBryg = PruebaBrigResultado::where('req_id', $data->requerimientoId)
        ->where('user_id', $data->userId)
        ->select('id', 'created_at')
        ->orderBy('created_at', 'DESC')
        ->first();

        $user_id = $data->userId;
        $req_id = $data->requerimientoId;

        //Fotos
        $brygImagenes = json_decode($data->brygImagenes, true);

        //Borrar primera foto del arreglo, porque no tiene información
        unset($brygImagenes[0]);

        for($i = 1; $i <= count($brygImagenes); $i++) {
            //Se verifica que la imagen tenga datos
            if ($brygImagenes[$i]['picture'] != null && $brygImagenes[$i]['picture'] != '' && $brygImagenes[$i]['picture'] != 'data:,') {
                //Convertir base64 a PNG
                $image_parts = explode(";base64,", $brygImagenes[$i]['picture']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fotoNombre = "candidato-foto-$i-$user_id-$req_id-$pruebaBryg->id.png";

                Storage::disk('public')
                    ->put("recursos_prueba_bryg/prueba_bryg_$user_id"."_"."$req_id"."_"."$pruebaBryg->id/$fotoNombre", $image_base64);

                //Guardar referencia foto en la tabla
                $brygFoto = new PruebaBrygFoto();

                $brygFoto->fill([
                    'prueba_id' => $pruebaBryg->id,
                    'user_id' => $user_id,
                    'req_id' => $req_id,
                    'descripcion' => $fotoNombre
                ]);
                $brygFoto->save();
            }
        }
    }

    //Lista de pruebas ADMIN
    public function lista_pruebas_bryg(Request $data)
    {
        $estado_bryg = 0;

        $lista_bryg = PruebaBrigResultado::join('datos_basicos', 'datos_basicos.user_id', '=', 'prueba_brig_candidato_resultado.user_id')
        ->where(function ($sql) use ($data, &$estado_bryg) {
            //Filtro por requerimiento
            if ($data->requerimiento != "") {
                $estado_bryg = 1;
                $sql->where("prueba_brig_candidato_resultado.req_id", $data->requerimiento);
            }

            //Filtro por cédula de candidato
            if ($data->cedula != "") {
                $estado_bryg = 1;
                $sql->where("datos_basicos.numero_id", $data->cedula);
            }
        })
        ->whereIn('prueba_brig_candidato_resultado.estado', [0, $estado_bryg])
        //->whereRaw("(prueba_brig_candidato_resultado.estado IS NULL OR  prueba_brig_candidato_resultado.estado = $estado_bryg)")
        ->select(
            'datos_basicos.numero_id as cedula',
            DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo"),

            'prueba_brig_candidato_resultado.req_id',
            'prueba_brig_candidato_resultado.id as prueba_id',
            'prueba_brig_candidato_resultado.fecha_realizacion'
        )
        ->orderBy('prueba_brig_candidato_resultado.created_at', 'DESC')
        ->orderBy('prueba_brig_candidato_resultado.id', 'DESC')
        ->paginate(6);

        /*$lista_bryg = RegistroProceso::join('prueba_brig_candidato_resultado', 'prueba_brig_candidato_resultado.user_id', '=', 'procesos_candidato_req.candidato_id')
        ->join('datos_basicos', 'datos_basicos.user_id', '=', 'prueba_brig_candidato_resultado.user_id')
        ->where(function ($sql) use ($data, &$estado_proceso) {
            //Filtro por requerimiento
            if ($data->requerimiento != "") {
                $estado_proceso = 1;
                $sql->where("prueba_brig_candidato_resultado.req_id", $data->requerimiento);
            }

            //Filtro por cédula de candidato
            if ($data->cedula != "") {
                $estado_proceso = 1;
                $sql->where("datos_basicos.numero_id", $data->cedula);
            }
        })
        ->whereRaw("(procesos_candidato_req.apto IS NULL OR  procesos_candidato_req.apto = $estado_proceso)")
        ->whereIn('procesos_candidato_req.proceso', ['ENVIO_PRUEBA_BRYG'])
        ->select(
            'procesos_candidato_req.proceso',
            'procesos_candidato_req.requerimiento_id as req_id',

            'datos_basicos.user_id',
            'datos_basicos.numero_id as cedula',
            DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo"),

            'prueba_brig_candidato_resultado.id as prueba_id',
            'prueba_brig_candidato_resultado.fecha_realizacion'
        )
        ->groupBy('prueba_brig_candidato_resultado.id')
        ->orderBy('prueba_brig_candidato_resultado.created_at', 'DESC')
        ->paginate(10);*/

        return view('admin.reclutamiento.pruebas.bryg.lista_bryg', compact('lista_bryg'));
    }

    //Mostrar resultados de la prueba
    public function gestion_prueba_bryg($bryg_id)
    {
        $candidato_bryg = PruebaBrigResultado::join('datos_basicos', 'datos_basicos.user_id', '=', 'prueba_brig_candidato_resultado.user_id')
        ->where('prueba_brig_candidato_resultado.id', $bryg_id)
        ->select(
            'prueba_brig_candidato_resultado.*',

            'datos_basicos.nombres',
            DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo")
        )
        ->first();

        //Ajuste al perfil
        $ajustePerfil = ltrim($candidato_bryg->ajuste_perfil, 0);
        $ajustePerfil = substr(ceil(ltrim($ajustePerfil, '.')), 0, 2);

        $concepto_prueba = PruebaBrigConcepto::where('bryg_id', $bryg_id)->first();

        //Buscar configuración de requerimientos o del cargo
        $configuracion = PruebaBrigConfigRequerimiento::where('req_id', $candidato_bryg->req_id)->orderBy('created_at', 'DESC')->first();

        if (empty($configuracion)) {
            //Si no hay configuración del req, busca la del cargo
            $cargo = Requerimiento::find($candidato_bryg->req_id);
            $configuracion = PruebaBrigConfigCargo::where('cargo_id', $cargo->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();

            if (empty($configuracion)) {
                $configuracion = (object) [
                    'radical' => 0,
                    'genuino' => 0,
                    'garante' => 0,
                    'basico' => 0,
                    'vacio' => 1
                ];
            }
        }

        //Arreglos para validar el valor más alto
        $aumented_array = [
            "analizador" => $candidato_bryg->aumented_a,
            "prospectivo" => $candidato_bryg->aumented_p,
            "defensivo" => $candidato_bryg->aumented_d,
            "reactivo" => $candidato_bryg->aumented_r
        ];

        $bryg_array = [
            "radical" => $candidato_bryg->estilo_radical,
            "genuino" => $candidato_bryg->estilo_genuino,
            "garante" => $candidato_bryg->estilo_garante,
            "basico" => $candidato_bryg->estilo_basico
        ];

        //Buscar la llave más alta
        $bryg_index = array_keys($bryg_array, max($bryg_array));
        $aumented_index = array_keys($aumented_array, max($aumented_array));

        $requerimiento_detalle = Requerimiento::where('requerimientos.id', $candidato_bryg->req_id)->first();

        return view('admin.reclutamiento.pruebas.bryg.gestionar_bryg', compact('candidato_bryg', 'ajustePerfil', 'configuracion', 'concepto_prueba', 'bryg_index', 'aumented_index', 'requerimiento_detalle'));
    }

    //Generar informe de la prueba
    public function informe_prueba_bryg($bryg_id,$download=0)
    {
        $candidato_bryg = PruebaBrigResultado::join('datos_basicos', 'datos_basicos.user_id', '=', 'prueba_brig_candidato_resultado.user_id')
        ->join('users', 'users.id', '=', 'datos_basicos.user_id')
        ->where('prueba_brig_candidato_resultado.id', $bryg_id)
        ->select(
            'prueba_brig_candidato_resultado.*',

            'datos_basicos.nombres',
            'datos_basicos.numero_id as cedula',
            'datos_basicos.fecha_nacimiento',
            'datos_basicos.telefono_movil as celular',
            'datos_basicos.email as correo',
            DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo"),

            'users.foto_perfil'
        )
        ->first();

        $bryg_fotos = PruebaBrygFoto::where('prueba_id', $bryg_id)
        ->where('user_id', $candidato_bryg->user_id)
        ->where('req_id', $candidato_bryg->req_id)
        ->get();

        $sitio_informacion = Sitio::first();

        $concepto = PruebaBrigConcepto::where('bryg_id', $bryg_id)->first();

        $aumented_array = [
            "analizador" => $candidato_bryg->aumented_a,
            "prospectivo" => $candidato_bryg->aumented_p,
            "defensivo" => $candidato_bryg->aumented_d,
            "reactivo" => $candidato_bryg->aumented_r
        ];

        $bryg_array = [
            "radical" => $candidato_bryg->estilo_radical,
            "genuino" => $candidato_bryg->estilo_genuino,
            "garante" => $candidato_bryg->estilo_garante,
            "basico" => $candidato_bryg->estilo_basico
        ];

        //Valor definitivo para aumented (Buscar el valor más alto)
        $aumented_definitive = array_keys($aumented_array, max($aumented_array));

        //Primer valor definitivo para bryg
        $bryg_definitive_first = array_keys($bryg_array, max($bryg_array));
        unset($bryg_array[$bryg_definitive_first[0]]); //Quita del arreglo primer item encontrado

        //Segundo valor definitivo para bryg
        $bryg_definitive_second = array_keys($bryg_array, max($bryg_array));
        unset($bryg_array[$bryg_definitive_second[0]]); //Quita del arreglo el segundo item encontrado

        /**
         * @todo la validación de los cuadrantes más altos deberían ser funciones independientes
         */

        //Validar cuadrante más alto BRYG para asignar color
        $radarBrygColor = '0, 169, 84';
        switch ($bryg_definitive_first[0]) {
            case 'radical':
                $radarBrygColor = '46, 45, 102';
                break;
            case 'genuino':
                $radarBrygColor = '217, 36, 40';
                break;
            case 'garante':
                $radarBrygColor = '228, 228, 42';
                break;
            case 'basico':
                $radarBrygColor = '0, 169, 84';
                break;
            default:
                $radarBrygColor = '0, 169, 84';
                break;
        }

        //Validar cuadrante más alto AUMENTED para asignar color
        $radarAumentedColor = '0, 169, 84';
        switch ($aumented_definitive[0]) {
            case 'analizador':
                $radarAumentedColor = '2, 136, 209';
                break;
            case 'prospectivo':
                $radarAumentedColor = '253, 216, 53';
                break;
            case 'defensivo':
                $radarAumentedColor = '244, 67, 54';
                break;
            case 'reactivo':
                $radarAumentedColor = '124, 179, 66';
                break;
            default:
                $radarAumentedColor = '124, 179, 66';
                break;
        }

        //Convertir fecha de solicitud a letras
        $fecha_evaluacion = explode('-', date('Y-m-d', strtotime($candidato_bryg->created_at)));
        $fecha_evaluacion_letra = "$fecha_evaluacion[2] de ".$this->meses[(int) $fecha_evaluacion[1]]." del $fecha_evaluacion[0]";

        //Convertir fecha de realización a letras
        $fecha_realizacion = explode('-', date('Y-m-d', strtotime($candidato_bryg->fecha_realizacion)));
        $fecha_realizacion_letra = "$fecha_realizacion[2] de ".$this->meses[(int) $fecha_realizacion[1]]." del $fecha_realizacion[0]";

        $candidato_edad = Carbon::parse($candidato_bryg->fecha_nacimiento)->age;

        $requerimiento_detalle = Requerimiento::where('requerimientos.id', $candidato_bryg->req_id)->first();

        //Generar gráfico radar BRYG
        $grafico_radar_bryg = $this->generarGraficoRadar(
            ['RADICAL', 'GENUINO', 'GARANTE', 'BÁSICO'],
            [$candidato_bryg->estilo_radical, $candidato_bryg->estilo_genuino, $candidato_bryg->estilo_garante, $candidato_bryg->estilo_basico],
            ['background' => "rgba($radarBrygColor, 0.7)", 'border' => "rgba($radarBrygColor, 1)"],
            'BRYG Gráfico de radar'
        );

        //Generar gráfico barra BRYG
        $grafico_barra_bryg = $this->generarGraficoBarra(
            ['RADICAL', 'GENUINO', 'GARANTE', 'BÁSICO'],
            [$candidato_bryg->estilo_radical, $candidato_bryg->estilo_genuino, $candidato_bryg->estilo_garante, $candidato_bryg->estilo_basico],
            [
                'background' => [
                    'rgba(46, 45, 102, 0.7)',
                    'rgba(217, 36, 40, 0.7)',
                    'rgba(228, 228, 42, 0.7)',
                    'rgba(0, 169, 84, 0.7)'
                ],
                'border' => [
                    'rgba(46, 45, 102, 1)',
                    'rgba(217, 36, 40, 1)',
                    'rgba(228, 228, 42, 1)',
                    'rgba(0, 169, 84, 1)'
                ]
            ],
            'BRYG Gráfico de barra'
        );

        //Generar gráfico radar AUMENTED
        $grafico_radar_aumented = $this->generarGraficoRadar(
            ['ANALIZADOR', 'PROSPECTIVO', 'DEFENSIVO', 'REACTIVO'],
            [$candidato_bryg->aumented_a, $candidato_bryg->aumented_p, $candidato_bryg->aumented_d, $candidato_bryg->aumented_r],
            ['background' => "rgba($radarAumentedColor, 0.7)", 'border' => "rgba($radarAumentedColor, 1)"],
            'BRYG-A Gráfico de radar'
        );

        //Generar gráfico barra AUMENTED
        $grafico_barra_aumented = $this->generarGraficoBarra(
            ['ANALIZADOR', 'PROSPECTIVO', 'DEFENSIVO', 'REACTIVO'],
            [$candidato_bryg->aumented_a, $candidato_bryg->aumented_p, $candidato_bryg->aumented_d, $candidato_bryg->aumented_r],
            [
                'background' => [
                    'rgba(2, 136, 209, 0.7)',
                    'rgba(253, 216, 53, 0.7)',
                    'rgba(244, 67, 54, 0.7)',
                    'rgba(124, 179, 66, 0.7)'
                ],
                'border' => [
                    'rgba(2, 136, 209, 1)',
                    'rgba(253, 216, 53, 1)',
                    'rgba(244, 67, 54, 1)',
                    'rgba(124, 179, 66, 1)'
                ]
            ],
            'BRYG Gráfico de barra'
        );

        if(!$download){
            return view('cv.pruebas.bryg.pdf.informe_resultado_bryg_new', [
            "candidato_bryg" => $candidato_bryg,
            "bryg_fotos" => $bryg_fotos,
            "sitio_informacion" => $sitio_informacion,
            "concepto" => $concepto,
            "aumented_definitive" => $aumented_definitive,
            "bryg_definitive_first" => $bryg_definitive_first,
            "bryg_definitive_second" => $bryg_definitive_second,
            "candidato_edad" => $candidato_edad,
            "fecha_evaluacion_letra" => $fecha_evaluacion_letra,
            "fecha_realizacion_letra" => $fecha_realizacion_letra,
            "requerimiento_detalle" => $requerimiento_detalle,
            "grafico_radar_bryg" => $grafico_radar_bryg,
            "grafico_radar_aumented" => $grafico_radar_aumented,
            "grafico_barra_bryg" => $grafico_barra_bryg,
            "grafico_barra_aumented" => $grafico_barra_aumented
            ]);
        }
        else{
            return \SnappyPDF::loadView('cv.pruebas.bryg.pdf.informe_resultado_bryg', [
                "candidato_bryg" => $candidato_bryg,
                "bryg_fotos" => $bryg_fotos,
                "sitio_informacion" => $sitio_informacion,
                "concepto" => $concepto,
                "aumented_definitive" => $aumented_definitive,
                "bryg_definitive_first" => $bryg_definitive_first,
                "bryg_definitive_second" => $bryg_definitive_second,
                "candidato_edad" => $candidato_edad,
                "fecha_evaluacion_letra" => $fecha_evaluacion_letra,
                "fecha_realizacion_letra" => $fecha_realizacion_letra,
                "requerimiento_detalle" => $requerimiento_detalle,
                "grafico_radar_bryg" => $grafico_radar_bryg,
                "grafico_radar_aumented" => $grafico_radar_aumented,
                "grafico_barra_bryg" => $grafico_barra_bryg,
                "grafico_barra_aumented" => $grafico_barra_aumented
            ])->output();
            //->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            //->stream('informe-resultado-bryg.pdf');
        }

        

        
    }

    //Crear arreglo para generar gráfico de radar (BRYG - AUMENTED)
    public function generarGraficoRadar(array $arrayLabels, array $arrayData, array $arrayColors, string $titleText):array
    {
        //Arreglo para generar gráfico
        $grafico_radar = [
            'type' => 'radar',
            'data' => [
                'labels' => [$arrayLabels[0], $arrayLabels[1], $arrayLabels[2], $arrayLabels[3]],
                'datasets' => [
                    [
                        'label' => 'Resultados',
                        'backgroundColor' => [
                            $arrayColors['background']
                        ],
                        'borderColor' => [
                            $arrayColors['border']
                        ],
                        'data' => [
                            $arrayData[0],
                            $arrayData[1],
                            $arrayData[2],
                            $arrayData[3]
                        ],
                        'borderWidth' => 1
                    ]
                ]
            ],
            'options' => [
                'legend' => ['display' => false],
                'title' => [
                    'display' => true,
                    'text' => $titleText
                ]
            ]
        ];

        return $grafico_radar;
    }

    //Crear arreglo para generar gráfico de barra (BRYG - AUMENTED)
    public function generarGraficoBarra(array $arrayLabels, array $arrayData, array $arrayColors, string $titleText):array
    {
        $grafico_barra = [
            'type' => 'bar',
            'data' => [
                'labels' => $arrayLabels,
                'datasets' => [
                    [
                        'label' => 'Resultados',
                        'backgroundColor' => [
                            $arrayColors['background'][0],
                            $arrayColors['background'][1],
                            $arrayColors['background'][2],
                            $arrayColors['background'][3],
                        ],
                        'borderColor' => [
                            $arrayColors['border'][0],
                            $arrayColors['border'][1],
                            $arrayColors['border'][2],
                            $arrayColors['border'][3],
                        ],
                        'data' => [
                            $arrayData[0],
                            $arrayData[1],
                            $arrayData[2],
                            $arrayData[3]
                        ],
                        'borderWidth' => 1
                    ]
                ]
            ],
            'options' => [
                'legend' => ['display' => false ],
                'title' => [
                    'display' => true,
                    'text' => $titleText
                ]
            ]
        ];

        return $grafico_barra;
    }

    //Guardar concepto de la prueba
    public function concepto_prueba_bryg(Request $data)
    {
        $bryg_id = $data->bryg_id;
        $candidato_id = $data->candidato_bryg;
        $concepto_prueba = $data->concepto_prueba;

        //Buscar si existe concepto
        $concepto = PruebaBrigConcepto::where('bryg_id', $bryg_id)->first();
        $resultado=PruebaBrigResultado::find($bryg_id);
        $candidato=DatosBasicos::where("user_id",$resultado->user_id)->select("numero_id as cedula")->first();

        if(empty($concepto)) {
            $concepto = new PruebaBrigConcepto();
            $concepto->fill([
                'bryg_id' => $bryg_id,
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
        ->where('proceso', 'ENVIO_PRUEBA_BRYG')
        ->where('estado', 7)
        ->orderBy('created_at', 'DESC')
        ->first();

        $proceso->apto = $data->estadoPrueba;
        $proceso->usuario_terminacion = $this->user->id;
        $proceso->save();

        //Generar PDF
        $pdf=$this->informe_prueba_bryg($bryg_id,1);

        if(file_exists('documentos_candidatos/'.$candidato->cedula.'/'.$proceso->requerimiento_id.'/seleccion/prueba_bryg_'.$candidato->cedula.'_'.$proceso->requerimiento_id.'.pdf')){

            Storage::disk('public')->delete('documentos_candidatos/'.$candidato->cedula.'/'.$proceso->requerimiento_id.'/seleccion/prueba_bryg_'.$candidato->cedula.'_'.$$proceso->requerimiento_id.'.pdf');
        }
        Storage::disk('public')->put('documentos_candidatos/'.$candidato->cedula.'/'.$proceso->requerimiento_id.'/seleccion/prueba_bryg_'.$candidato->cedula.'_'.$proceso->requerimiento_id.'.pdf',$pdf);


        return response()->json(['success' => true]);
    }

    /*
     *
     * Calcular ajuste al perfil
     *
    */
    private function calcularAjustePerfil(array $respuestasBryg, int $requerimientoId)
    {
        //Primero busca si el requerimiento tiene configuración BRYG
        $configuracion = PruebaBrigConfigRequerimiento::where('req_id', $requerimientoId)->orderBy('created_at', 'DESC')->first();

        if (empty($configuracion)) {
            $cargo = Requerimiento::find($requerimientoId);
            $configuracion = PruebaBrigConfigCargo::where('cargo_id', $cargo->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();
        }

        $cuadranteRadical = 0;
        $cuadranteGenuino = 0;
        $cuadranteGarante = 0;
        $cuadranteBasico = 0;

        $ajustePerfil = 0;

        if ($configuracion->radical > $respuestasBryg['radical']) {
            $cuadranteRadical = $respuestasBryg['radical'] / $configuracion->radical;
        }else {
            $cuadranteRadical = $configuracion->radical / $respuestasBryg['radical'];
        }

        if ($configuracion->genuino > $respuestasBryg['genuino']) {
            $cuadranteGenuino = $respuestasBryg['genuino'] / $configuracion->genuino;
        }else {
            $cuadranteGenuino = $configuracion->genuino / $respuestasBryg['genuino'];
        }

        if ($configuracion->garante > $respuestasBryg['garante']) {
            $cuadranteGarante = $respuestasBryg['garante'] / $configuracion->garante;
        }else {
            $cuadranteGarante = $configuracion->garante / $respuestasBryg['garante'];
        }

        if ($configuracion->basico > $respuestasBryg['basico']) {
            $cuadranteBasico = $respuestasBryg['basico'] / $configuracion->basico;
        }else {
            $cuadranteBasico = $configuracion->basico / $respuestasBryg['basico'];
        }

        \Log::info($cuadranteRadical);
        \Log::info($cuadranteGenuino);
        \Log::info($cuadranteGarante);
        \Log::info($cuadranteBasico);

        $ajustePerfil = ($cuadranteRadical + $cuadranteGenuino + $cuadranteGarante + $cuadranteBasico) / 4;

        return $ajustePerfil;
    }
}
