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

use App\Models\PruebaDigitacionCargo;
use App\Models\PruebaDigitacionConcepto;
use App\Models\PruebaDigitacionFotos;
use App\Models\PruebaDigitacionReq;
use App\Models\PruebaDigitacionResultado;
use App\Models\PruebaDigitacionTexto;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use triPostmaster;
use Carbon\Carbon;
use PDF;

use Storage;
use File;

class PruebaDigitacionController extends Controller
{
    public function __construct()
    {
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

    public function index()
    {
        if(empty($this->user->id)){
            session(["url_deseada_redireccion_candidato" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login');
        }

        //Verificar si fue enviado a prueba
        $check_test = RegistroProceso::where('candidato_id', $this->user->id)
        ->where('proceso', 'ENVIO_PRUEBA_DIGITACION')
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

        return view('cv.pruebas.digitacion.prueba_digitacion_index', compact('sitio', 'user', 'name_user'));
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
        ->where('proceso', 'ENVIO_PRUEBA_DIGITACION')
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

        //Buscar texto para la prueba
        $digitacionTexto = PruebaDigitacionTexto::all()->random();

        $text = $digitacionTexto->contenido;

        $newText = str_replace(" ", "-", $text);
        $textArray = explode("-", $newText);
        $textJson = json_encode($textArray);

        return view('cv.pruebas.digitacion.prueba_digitacion', compact('sitio', 'user', 'requerimientoId', 'textArray', 'textJson'));
    }

    //Guardar resultados candidato
    public function store(Request $data)
    {
        $userId = $data->userId;
        $requerimientoId = $data->requerimientoId;
        $sitio = Sitio::first();

        $digitacionResultados = PruebaDigitacionResultado::where('user_id', $userId)
        ->where('req_id', $requerimientoId)
        ->orderBy('created_at', 'DESC')
        ->first();

        $digitacionPrecision = 1-($data->digitacionIncorrectas/$data->digitacionPpm);
        $digitacionPrecision = $digitacionPrecision * 100;

        $digitacionResultados->ppm = $data->digitacionPpm;
        $digitacionResultados->pulsaciones = $data->digitacionPulsaciones;
        $digitacionResultados->precision_user = number_format($digitacionPrecision, 1);
        $digitacionResultados->correctas = $data->digitacionCorrectas;
        $digitacionResultados->incorrectas = $data->digitacionIncorrectas;
        $digitacionResultados->estado = 1;
        $digitacionResultados->fecha_realizacion = date('Y-m-d');
        $digitacionResultados->save();

        $digitacionImagenes = json_decode($data->digitacionImagenes, true);

        //Borrar primera foto del arreglo, porque no tiene información
        //unset($digitacionImagenes[0]);

        $user_id = $data->userId;
        $req_id = $requerimientoId;

        for($i = 0; $i < count($digitacionImagenes); $i++) {
            //Se verifica que la imagen tenga datos
            if ($digitacionImagenes[$i]['picture'] != null && $digitacionImagenes[$i]['picture'] != '' && $digitacionImagenes[$i]['picture'] != 'data:,') {
                //Convertir base64 a PNG
                $image_parts = explode(";base64,", $digitacionImagenes[$i]['picture']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fotoNombre = "candidato-foto-$i-$user_id-$req_id-$digitacionResultados->id.png";

                Storage::disk('public')
                    ->put("recursos_prueba_digitacion/prueba_digitacion_$user_id_$req_id_$digitacionResultados->id/$fotoNombre", $image_base64);

                //Guardar referencia foto en la tabla
                $digitacionFoto = new PruebaDigitacionFotos();

                $digitacionFoto->fill([
                    'digitacion_id' => $digitacionResultados->id,
                    'user_id' => $userId,
                    'req_id' => $requerimientoId,
                    'descripcion' => $fotoNombre
                ]);
                $digitacionFoto->save();
            }
        }

        //Colocar la prueba en pendiente
        RegistroProceso::where('candidato_id', $userId)
            ->where('requerimiento_id', $requerimientoId)
            ->where('proceso', 'ENVIO_PRUEBA_DIGITACION')
        ->update(['apto' => 3]);

        /**
         *
         * Usar administrador de correos
         *
        */
            $informacionUsuarioGestion = DatosBasicos::where('user_id', $digitacionResultados->gestion_id)->select('nombres', 'email')->first();
            $informacionUsuarioPrueba = DatosBasicos::where('user_id', $userId)->first();

            $mailTemplate = 2; //Plantilla con botón e imagen de fondo
            $mailConfiguration = 1; //Id de la configuración
            $mailTitle = "Notificación Prueba Digitación"; //Titulo o tema del correo

            //Cuerpo con html y comillas dobles para las variables
            $mailBody = "
                Hola $informacionUsuarioGestion->nombres, te informamos que el(la) candidato(a) $informacionUsuarioPrueba->nombres $informacionUsuarioPrueba->primer_apellido asociado(a) al requerimiento <b>$data->requerimientoId</b> ha terminado con éxito la realización de la prueba de digitación. <br>
                Para ver sus resultados puedes ingresar al menú lateral en la plataforma <i>Proceso de Selección > Pruebas Digitación</i> y buscar por su número de documento. <br>
                También puedes dar clic en <b>Ver resultados</b> e ir directamente a la página.
            ";

            //Arreglo para el botón
            $mailButton = ['buttonText' => 'Ver resultados', 'buttonRoute' => route('admin.pruebas_digitacion_gestion', ['digitacion_id' => $digitacionResultados->id])];

            $mailUser = $userId; //Id del usuario al que se le envía el correo

            $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

            //Enviar correo generado
            Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($informacionUsuarioGestion, $sitio) {
                $message->to([$informacionUsuarioGestion->email], 'T3RS')
                ->bcc($sitio->email_replica)
                ->subject("Notificación Prueba Digitación")
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

    /*
     * ADMIN
    */
    public function lista_pruebas_digitacion(Request $data)
    {
        $estado_digitacion = 0;

        $lista_digitacion = PruebaDigitacionResultado::join('datos_basicos', 'datos_basicos.user_id', '=', 'prueba_digitacion_candidato_resultados.user_id')
        ->where(function ($sql) use ($data, &$estado_digitacion) {
            //Filtro por requerimiento
            if ($data->requerimiento != "") {
                $estado_digitacion = 1;
                $sql->where("prueba_digitacion_candidato_resultados.req_id", $data->requerimiento);
            }

            //Filtro por cédula de candidato
            if ($data->cedula != "") {
                $estado_digitacion = 1;
                $sql->where("datos_basicos.numero_id", $data->cedula);
            }
        })
        ->whereIn('prueba_digitacion_candidato_resultados.estado', [0, $estado_digitacion])
        //->whereRaw("(prueba_digitacion_candidato_resultados.estado IS NULL OR  prueba_digitacion_candidato_resultados.estado = $estado_digitacion)")
        ->select(
            'datos_basicos.numero_id as cedula',
            DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo"),

            'prueba_digitacion_candidato_resultados.req_id',
            'prueba_digitacion_candidato_resultados.id as prueba_id',
            'prueba_digitacion_candidato_resultados.fecha_realizacion'
        )
        ->orderBy('prueba_digitacion_candidato_resultados.created_at', 'DESC')
        ->orderBy('prueba_digitacion_candidato_resultados.id', 'DESC')
        ->paginate(6);

        return view('admin.reclutamiento.pruebas.digitacion.lista_digitacion', compact('lista_digitacion'));
    }

    public function gestion_prueba_digitacion($digitacion_id)
    {
        $candidato_digitacion = PruebaDigitacionResultado::join('datos_basicos', 'datos_basicos.user_id', '=', 'prueba_digitacion_candidato_resultados.user_id')
        ->where('prueba_digitacion_candidato_resultados.id', $digitacion_id)
        ->select(
            'prueba_digitacion_candidato_resultados.*',

            'datos_basicos.nombres',
            DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo")
        )
        ->first();

        $concepto_prueba = PruebaDigitacionConcepto::where('digitacion_id', $digitacion_id)->first();

        $digitacion_fotos = PruebaDigitacionFotos::where('digitacion_id', $digitacion_id)
        ->where('user_id', $candidato_digitacion->user_id)
        ->where('req_id', $candidato_digitacion->req_id)
        ->get();

        //Buscar configuración del cargo
        $configuracion = PruebaDigitacionReq::where('req_id', $candidato_digitacion->req_id)->first();

        if (empty($configuracion)) {
            $cargo = Requerimiento::find($candidato_digitacion->req_id);
            $configuracion = PruebaDigitacionCargo::where('cargo_id', $cargo->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();
        }

        if (empty($configuracion)) {
            $configuracion = (object) ['vacio' => 1];
        }

        $requerimiento_detalle = Requerimiento::where('requerimientos.id', $candidato_digitacion->req_id)->first();

        return view('admin.reclutamiento.pruebas.digitacion.gestionar_digitacion', compact(
            'candidato_digitacion',
            'concepto_prueba',
            'digitacion_fotos',
            'configuracion',
            'requerimiento_detalle'
        ));
    }

    public function concepto_prueba_digitacion(Request $data)
    {
        $digitacion_id = $data->digitacion_id;
        $candidato_id = $data->candidato_digitacion;
        $concepto_prueba = $data->concepto_prueba;
        $estadoConcepto = $data->estadoPrueba;

        //Buscar si existe concepto
        $concepto = PruebaDigitacionConcepto::where('digitacion_id', $digitacion_id)->first();

        if(empty($concepto)) {
            $concepto = new PruebaDigitacionConcepto();
            $concepto->fill([
                'digitacion_id' => $digitacion_id,
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
        ->where('proceso', 'ENVIO_PRUEBA_DIGITACION')
        ->where('estado', 7)
        ->orderBy('created_at', 'DESC')
        ->first();

        $proceso->apto = (int) $estadoConcepto;
        $proceso->observaciones = $concepto_prueba;
        $proceso->usuario_terminacion = $this->user->id;
        $proceso->save();

        $candidato=DatosBasicos::where("user_id",$candidato_id)->select("numero_id as cedula")->first();


        $pdf=$this->informe_prueba_digitacion($digitacion_id,1);

        if(file_exists('documentos_candidatos/'.$candidato->cedula.'/'.$proceso->requerimiento_id.'/seleccion/prueba_digitacion_'.$candidato->cedula.'_'.$proceso->requerimiento_id.'.pdf')){

            Storage::disk('public')->delete('documentos_candidatos/'.$candidato->cedula.'/'.$proceso->requerimiento_id.'/seleccion/prueba_digitacion_'.$candidato->cedula.'_'.$proceso->requerimiento_id.'.pdf');
        }
        Storage::disk('public')->put('documentos_candidatos/'.$candidato->cedula.'/'.$proceso->requerimiento_id.'/seleccion/prueba_digitacion_'.$candidato->cedula.'_'.$proceso->requerimiento_id.'.pdf',$pdf);


        return response()->json(['success' => true]);
    }

    //Generar informe de la prueba
    public function informe_prueba_digitacion($digitacion_id,$download=0)
    {
        $candidato_digitacion = PruebaDigitacionResultado::join('datos_basicos', 'datos_basicos.user_id', '=', 'prueba_digitacion_candidato_resultados.user_id')
        ->join('users', 'users.id', '=', 'datos_basicos.user_id')
        ->where('prueba_digitacion_candidato_resultados.id', $digitacion_id)
        ->select(
            'prueba_digitacion_candidato_resultados.*',

            'datos_basicos.nombres',
            'datos_basicos.numero_id as cedula',
            'datos_basicos.fecha_nacimiento',
            'datos_basicos.telefono_movil as celular',
            'datos_basicos.email as correo',
            DB::raw("CONCAT(datos_basicos.nombres,' ',datos_basicos.primer_apellido,' ',datos_basicos.segundo_apellido) AS nombre_completo"),

            'users.foto_perfil'
        )
        ->first();

        $digitacion_fotos = PruebaDigitacionFotos::where('digitacion_id', $digitacion_id)
        ->where('user_id', $candidato_digitacion->user_id)
        ->where('req_id', $candidato_digitacion->req_id)
        ->get();

        $sitio_informacion = Sitio::first();

        $concepto = PruebaDigitacionConcepto::where('digitacion_id', $digitacion_id)->first();

        //Configuración
        $configuracion = PruebaDigitacionReq::where('req_id', $candidato_digitacion->req_id)->first();

        if (empty($configuracion)) {
            $requerimiento = Requerimiento::find($candidato_digitacion->req_id)->first();
            $configuracion = PruebaDigitacionCargo::where('cargo_id', $requerimiento->cargo_especifico_id)->first();
        }

        //Convertir fecha de solicitud a letras
        $fecha_evaluacion = explode('-', date('Y-m-d', strtotime($candidato_digitacion->created_at)));

        $fecha_evaluacion_letra = "$fecha_evaluacion[2] de ".$this->meses[(int)$fecha_evaluacion[1]]." del $fecha_evaluacion[0]";

        //Convertir fecha de realización a letras
        $fecha_realizacion = explode('-', date('Y-m-d', strtotime($candidato_digitacion->fecha_realizacion)));
        $fecha_realizacion_letra = "$fecha_realizacion[2] de ".$this->meses[(int) $fecha_realizacion[1]]." del $fecha_realizacion[0]";

        $candidato_edad = Carbon::parse($candidato_digitacion->fecha_nacimiento)->age;

        $requerimiento_detalle = Requerimiento::where('requerimientos.id', $candidato_digitacion->req_id)->first();


        if(!$download){
            return view('cv.pruebas.digitacion.pdf.informe_resultado_digitacion_new', [
                "candidato_digitacion" => $candidato_digitacion,
                "digitacion_fotos" => $digitacion_fotos,
                "sitio_informacion" => $sitio_informacion,
                "concepto" => $concepto,
                "configuracion" => $configuracion,
                "candidato_edad" => $candidato_edad,
                "fecha_evaluacion_letra" => $fecha_evaluacion_letra,
                "fecha_realizacion_letra" => $fecha_realizacion_letra,
                "requerimiento_detalle" => $requerimiento_detalle
            ]);
        }
        else{
            return \SnappyPDF::loadView('cv.pruebas.digitacion.pdf.informe_resultado_digitacion_new', [
                "candidato_digitacion" => $candidato_digitacion,
                "digitacion_fotos" => $digitacion_fotos,
                "sitio_informacion" => $sitio_informacion,
                "concepto" => $concepto,
                "configuracion" => $configuracion,
                "candidato_edad" => $candidato_edad,
                "fecha_evaluacion_letra" => $fecha_evaluacion_letra,
                "fecha_realizacion_letra" => $fecha_realizacion_letra,
                "requerimiento_detalle" => $requerimiento_detalle
            ])
            //->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            ->output();
        }
        

        /**/
    }

    //
    public function configuracion_cargo(Request $data)
    {
        $cargoId = $data->cargo_id;
        $digitacionRequerimiento = PruebaDigitacionCargo::where('cargo_id', $cargoId)->first();

        return view("admin.reclutamiento.pruebas.digitacion.includes._modal_configurar_requerimiento", compact('cargoId', 'digitacionRequerimiento'));
    }

    public function guardar_configuracion_digitacion_cargo(Request $data)
    {
        $digitacionCargo = PruebaDigitacionCargo::where('cargo_id', $data->cargo_id)->first();

        if (empty($digitacionCargo)) {
            $digitacionCargo = new PruebaDigitacionCargo();

            $digitacionCargo->fill([
                'cargo_id' => $data->cargo_id,
                'ppm_esperada' => $data->ppm_esperada,
                'precision_esperada' => $data->precision_esperada
            ]);
        }else {
            $digitacionCargo->ppm_esperada = $data->ppm_esperada;
            $digitacionCargo->precision_esperada = $data->precision_esperada;
        }

        $digitacionCargo->save();

        return response()->json(['success' => true]);
    }

    public function configuracion_digitacion_req(Request $data)
    {
        $reqId = $data->req_id;
        $digitacionRequerimiento = PruebaDigitacionReq::where('req_id', $data->req_id)->first();
        if (empty($digitacionRequerimiento)) {
            $requerimiento = Requerimiento::select('cargo_especifico_id')->find($data->req_id);
            $digitacionRequerimiento = PruebaDigitacionCargo::where('cargo_id', $requerimiento->cargo_especifico_id)->first();
        }

        return view("admin.reclutamiento.pruebas.digitacion.includes._modal_configurar_requerimiento", compact('reqId', 'digitacionRequerimiento'));
    }

    public function guardar_configuracion_digitacion_req(Request $data)
    {
        $digitacionRequerimiento = PruebaDigitacionReq::where('req_id', $data->req_id)->first();

        if (empty($digitacionRequerimiento)) {
            $digitacionRequerimiento = new PruebaDigitacionReq();

            $digitacionRequerimiento->fill([
                'req_id' => $data->req_id,
                'ppm_esperada' => $data->ppm_esperada,
                'precision_esperada' => $data->precision_esperada
            ]);
        }else {
            $digitacionRequerimiento->ppm_esperada = $data->ppm_esperada;
            $digitacionRequerimiento->precision_esperada = $data->precision_esperada;
        }

        $digitacionRequerimiento->save();

        return response()->json(['success' => true]);
    }

    //Buscar si el candidato tiene prueba digitación contestada
    public static function digitacionCandidato($user_id, $req_id)
    {
        $candidato_digitacion = PruebaDigitacionResultado::where('prueba_digitacion_candidato_resultados.user_id', $user_id)
        ->where('prueba_digitacion_candidato_resultados.req_id', $req_id)
        ->where('estado', 1)
        ->orderBy('created_at', 'DESC')
        ->first();

        if (!empty($candidato_digitacion)) {
            return $candidato_digitacion;
        }

        return null;
    }

    //Buscar si el candidato tiene prueba bryg contestada
    public static function digitacionCandidatoConcepto($digitacion_id)
    {
        $candidato_digitacion_concepto = PruebaDigitacionConcepto::where('digitacion_id', $digitacion_id)->first();

        if (!empty($candidato_digitacion_concepto)) {
            return $candidato_digitacion_concepto;
        }

        return null;
    }
}
