<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\Models\CargoEspecificoConfigPruebas;
use App\Models\DatosBasicos;
use App\Models\RegistroProceso;
use App\Models\Sitio;
use App\Models\User;
use App\Models\Requerimiento;
use App\Models\PruebaValoresConfigRequerimiento;
use App\Models\PruebaValoresPreguntas;
use App\Models\PruebaValoresRespuestas;
use App\Models\PruebaValoresNormasNacionales;
use App\Models\PruebaValoresAreaImportante;
use App\Models\PruebaValoresInterpretacion;

use DB;
use triPostmaster;

use Storage;
use File;
use Carbon\Carbon;
use PDF;

class PruebaValoresController extends Controller
{
    public function index_prueba(Request $data)
    {
        if(empty($this->user->id)){
            session(["url_deseada_redireccion_candidato" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login');
        }

        //Verificar si fue enviado a prueba y que no hayan modificado su estatus
        $check_test = RegistroProceso::where('candidato_id', $this->user->id)
            ->where('proceso', ['ENVIO_PRUEBA_ETHICAL_VALUES'])
            ->where('requerimiento_id', $data->req_id)
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
        $nombre_prueba = 'Prueba de Ethical Values';
        $req_id = $data->req_id;

        $configuracion = PruebaValoresConfigRequerimiento::where('req_id', $data->req_id)->orderBy('id', 'desc')->first();

        //dd($configuracion);
        
        $prueba_questions = PruebaValoresPreguntas::where('active', 1)->orderByRaw('RAND()')->get();

        $total_preguntas = count($prueba_questions);

        $ids = array();
        foreach($prueba_questions as $question){ $ids[] = (int)$question->id; }

        //Reload
        $reloadPage = $data->session()->get('reloadPage');

        $ruta_save = route('cv.prueba_valores_1_save');

        if ($reloadPage === 'yes') {
            $data->session()->forget('reloadPage');
        }else {
            session(['reloadPage' => 'not']);
        }

        return view('cv.pruebas.valores_1.prueba_valores_1', compact('sitio', 'user', 'name_user', 'nombre_prueba', 'total_preguntas', 'ids', 'prueba_questions', 'reloadPage', 'req_id', 'configuracion', 'ruta_save'));
    }

    public function save_result_valores(Request $request)
    {
        $req_id = $request->req_id;
        $user_id = $this->user->id;

        $proceso = RegistroProceso::where('candidato_id', $this->user->id)
            ->where('proceso', ['ENVIO_PRUEBA_ETHICAL_VALUES'])
            ->where('requerimiento_id', $req_id)
            ->whereNull('apto')
            ->orderBy('created_at', 'DESC')
        ->first();

        if(empty($proceso)){
            $ruta = route('dashboard');
            return response()->json(['success' => false, 'mensaje' => 'Ya has respondido esta prueba.', 'ruta' => $ruta]);
        }

        $proceso->apto = 3; //Se coloca en pendiente para que el psicologo termine de verificar
        $proceso->save();

        $imagenes = json_decode($request->fotosPrueba, true);

        $nombres_fotos = '';

        $total_imagenes = count($imagenes);

        for($i = 0; $i < $total_imagenes; $i++) {
            //Se verifica que la imagen tenga datos
            if ($imagenes[$i]['picture'] != null && $imagenes[$i]['picture'] != '') {
                //Convertir base64 a PNG
                $image_parts = explode(";base64,", $imagenes[$i]['picture']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fotoNombre = "candidato-foto-$i-$user_id-$req_id.png";

                if ($i == $total_imagenes-1) {
                    $nombres_fotos = $nombres_fotos . $fotoNombre;
                } else {
                    $nombres_fotos = $nombres_fotos . "$fotoNombre,";
                }

                Storage::disk('public')->put("recursos_prueba_valores_1/prueba_valores_1_".$user_id.'_'.$req_id."/$fotoNombre", $image_base64);
            }
        }

        $preguntas = PruebaValoresPreguntas::where('active', 1)->get();

        $valor_amor = 0;
        $valor_no_violencia = 0;
        $valor_paz = 0;
        $valor_rectitud = 0;
        $valor_verdad = 0;

        $item_amor = 0;
        $item_no_violencia = 0;
        $item_paz = 0;
        $item_rectitud = 0;
        $item_verdad = 0;

        $preg_resp = $request->except('req_id', 'userId', '_token', 'fotosPrueba');
        $respuestas_json = json_encode($preg_resp);
        foreach ($preg_resp as $preg_id_text => $estrellas) {
            //preg_id-24-premisa_1
            $pregunta_id_premisa = str_replace('preg_id-', '', $preg_id_text);

            $pregunta_id = str_replace('-premisa_1', '', str_replace('-premisa_2', '', $pregunta_id_premisa));

            $tipo_premisa_txt = 'tipo_' . str_replace('preg_id-'.$pregunta_id.'-', '', $preg_id_text);

            $preg = $preguntas->find($pregunta_id);

            $id_tipo_premisa = $preg->$tipo_premisa_txt;

            switch ($id_tipo_premisa) {
                case '1':
                    $valor_amor += $estrellas;
                    $item_amor++;
                    break;
                case '2':
                    $valor_no_violencia += $estrellas;
                    $item_no_violencia++;
                    break;
                case '3':
                    $valor_paz += $estrellas;
                    $item_paz++;
                    break;
                case '4':
                    $valor_rectitud += $estrellas;
                    $item_rectitud++;
                    break;
                case '5':
                    $valor_verdad += $estrellas;
                    $item_verdad++;
                    break;
                
                default:
                    break;
            }
        }

        $configuracion = PruebaValoresConfigRequerimiento::where('req_id', $req_id)->select('id')->orderBy('id', 'desc')->first();

        $respuestasPrueba = new PruebaValoresRespuestas();

        $respuestasPrueba->user_id          = $this->user->id;
        $respuestasPrueba->req_id           = $req_id;
        $respuestasPrueba->config_req_id    = $configuracion->id;
        $respuestasPrueba->fecha_respuesta  = date('Y-m-d');
        $respuestasPrueba->respuestas       = $respuestas_json;
        $respuestasPrueba->fotos            = $nombres_fotos;
        $respuestasPrueba->valor_amor       = $valor_amor;
        $respuestasPrueba->valor_paz        = $valor_paz;
        $respuestasPrueba->valor_rectitud   = $valor_rectitud;
        $respuestasPrueba->valor_verdad     = $valor_verdad;
        $respuestasPrueba->valor_no_violencia   = $valor_no_violencia;
        $respuestasPrueba->item_amor       = $item_amor;
        $respuestasPrueba->item_paz        = $item_paz;
        $respuestasPrueba->item_rectitud   = $item_rectitud;
        $respuestasPrueba->item_verdad     = $item_verdad;
        $respuestasPrueba->item_no_violencia   = $item_no_violencia;

        $respuestasPrueba->save();

        $informacionUsuarioGestion = $proceso->datosBasicosUsuarioEnvio;
        $candidato = $proceso->datosBasicosCandidato;
        $sitio = Sitio::first();

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Notificación prueba Ethical Values"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "
            Hola $informacionUsuarioGestion->nombres, te informamos que el/la candidato/a $candidato->nombres $candidato->primer_apellido asociado/a al requerimiento <b>$data->req_id</b> ha terminado con éxito la prueba de Ethical Values. <br>
            Para ver sus resultados puedes ingresar al menú lateral en la plataforma <i>Proceso de Selección > Ethical Values</i> y buscar por su número de documento. <br>
            También puedes dar clic en <b>Ver resultados</b> e ir directamente a la página.
        ";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'Ver resultados', 'buttonRoute' => route('admin.gestionar_valores_1', ['id' => $proceso->id])];

        $mailUser = $informacionUsuarioGestion->user_id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        //Enviar correo generado
        Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($informacionUsuarioGestion, $sitio) {
            $message->to([$informacionUsuarioGestion->email], 'T3RS')
            ->bcc($sitio->email_replica)
            ->subject("Notificación prueba Ethical Values")
            ->getHeaders()
            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        return response()->json(['success' => true]);
    }

    //Visualizar configuración
    public function configuracionEthicalValuesModal(Request $request)
    {
        $req_id = null;
        $cargo_id = null;
        if (isset($request->req_id)) {
            $req_id = $request->req_id;
            $configuracion = PruebaValoresConfigRequerimiento::where('req_id', $req_id)->orderBy('created_at', 'DESC')->first();

            if (empty($configuracion)) {
                $requerimiento = Requerimiento::select('cargo_especifico_id')->find($req_id);

                $configuracion = CargoEspecificoConfigPruebas::where('cargo_especifico_id', $requerimiento->cargo_especifico_id)->orderBy('created_at', 'DESC')->first();
            }
        } else {
            $cargo_id = $request->cargo_id;
            $configuracion = CargoEspecificoConfigPruebas::where('cargo_especifico_id', $cargo_id)->orderBy('created_at', 'DESC')->first();

        }

        if (empty($configuracion)) {
            if ($req_id != null) {
                $configuracion = new PruebaValoresConfigRequerimiento();
            } else {
                $configuracion = new CargoEspecificoConfigPruebas();
            }
        }

        return view("admin.reclutamiento.modal.configurar_prueba_ethical_values", compact("configuracion", "req_id", "cargo_id"));
    }

    public function guardarConfiguracionPruebaValores(Request $request)
    {
        if ($request->has('req_id') && $request->req_id != '') {
            $req_id = $request->req_id;

            //Nueva
            $nuevaConfiguracion = new PruebaValoresConfigRequerimiento();

            $nuevaConfiguracion->fill([
                'req_id'                => $req_id,
                'prueba_valores_1'      => 'enabled',
                'valor_verdad'          => $request->valor_verdad,
                'valor_rectitud'        => $request->valor_rectitud,
                'valor_paz'             => $request->valor_paz,
                'valor_amor'            => $request->valor_amor,
                'valor_no_violencia'    => $request->valor_no_violencia,
                'gestiono'              => $this->user->id
            ]);
            $nuevaConfiguracion->save();

            $cargo_especifico_id = $nuevaConfiguracion->requerimiento->cargo_especifico_id;
            $configuracionCargo = CargoEspecificoConfigPruebas::where('cargo_especifico_id', $cargo_especifico_id)->first();

            if ($configuracionCargo == null) {
                //Nueva
                $configuracionCargo = new CargoEspecificoConfigPruebas();

                $configuracionCargo->fill([
                    'prueba_valores_1' => 'enabled',
                    'valor_verdad' => $request->valor_verdad,
                    'valor_rectitud' => $request->valor_rectitud,
                    'valor_paz' => $request->valor_paz,
                    'valor_amor' => $request->valor_amor,
                    'valor_no_violencia' => $request->valor_no_violencia,
                    'gestiono' => $this->user->id,
                    'cargo_especifico_id' => $cargo_especifico_id
                ]);

                $configuracionCargo->save();
            }
        }else {
            $cargo_id = $request->cargo_id;

            if (empty($cargo_id)) {
                $configuracion = null;
            }else {
                //Buscar configuración
                $configuracion = CargoEspecificoConfigPruebas::where('cargo_especifico_id', $cargo_id)->orderBy('created_at', 'DESC')->first();
            }

            if (empty($configuracion)) {
                //Nueva
                $nuevaConfiguracion = new CargoEspecificoConfigPruebas();

                $nuevaConfiguracion->fill([
                    'prueba_valores_1' => 'enabled',
                    'valor_verdad' => $request->valor_verdad,
                    'valor_rectitud' => $request->valor_rectitud,
                    'valor_paz' => $request->valor_paz,
                    'valor_amor' => $request->valor_amor,
                    'valor_no_violencia' => $request->valor_no_violencia,
                    'gestiono' => $this->user->id
                ]);

                //Para cargos creados pero sin configuración
                if (!empty($cargo_id)) {
                    $nuevaConfiguracion->cargo_especifico_id = $cargo_id;
                }

                $nuevaConfiguracion->save();
            }else {
                //Actualiza
                $configuracion->valor_verdad = $request->valor_verdad;
                $configuracion->valor_rectitud = $request->valor_rectitud;
                $configuracion->valor_paz = $request->valor_paz;
                $configuracion->valor_amor = $request->valor_amor;
                $configuracion->valor_no_violencia = $request->valor_no_violencia;
                $configuracion->save();
            }
        }

        return response()->json(['success' => true, 'configuracionId' => $nuevaConfiguracion->id]);
    }

    public function lista_valores_1(Request $data) {
        $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
            ->leftjoin('prueba_valores_1_respuestas', function($join){
                $join->on('prueba_valores_1_respuestas.user_id', '=', 'datos_basicos.user_id')
                    ->on('prueba_valores_1_respuestas.req_id', '=', 'procesos_candidato_req.requerimiento_id');
            })
            ->whereIn("requerimiento_cantidato.estado_candidato",[7, 8, 25])
            ->whereIn("procesos_candidato_req.estado", [7, 8, 25])
            ->whereRaw('estados_requerimiento.id=(select max(estados_requerimiento.id) from estados_requerimiento where estados_requerimiento.req_id=requerimientos.id)')
            ->whereIn("estados_requerimiento.estado", [
                config('conf_aplicacion.C_RECLUTAMIENTO'),
                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                config('conf_aplicacion.C_EVALUACION_DEL_CLIENTE'),
                //config('conf_aplicacion.C_NO_EFECTIVO')
                //config('conf_aplicacion.C_CLIENTE')
            ])
            ->where(function ($sql) use ($data) {
                if ($data->req_id != "" || $data->cedula != "") {
                    //Filtro por código requerimiento
                    if ($data->req_id != "") {
                        $sql->where("requerimiento_cantidato.requerimiento_id", $data->req_id);
                    }

                    //Filtro por cédula de candidato
                    if ($data->cedula != "") {
                        $sql->where("datos_basicos.numero_id", $data->cedula);
                    }
                } else {
                    $sql->whereRaw("(procesos_candidato_req.apto is null or procesos_candidato_req.apto = '' or procesos_candidato_req.apto = 3)");
                }
            })
            ->where("procesos_candidato_req.proceso", "ENVIO_PRUEBA_ETHICAL_VALUES")
            ->orderBy('requerimiento_cantidato.requerimiento_id', 'desc')
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.numero_id",
                "datos_basicos.nombres",
                "datos_basicos.primer_apellido",
                "datos_basicos.segundo_apellido",
                "prueba_valores_1_respuestas.fecha_respuesta",
                "requerimiento_cantidato.requerimiento_id"
            )
        ->paginate(10);

        $ruta_gestion = 'admin.gestionar_valores_1';

        $ruta_listado = 'admin.pruebas_valores_1';

        $tipo = 'Ethical Values';

        return view("admin.prueba_valores_1.lista_candidatos", compact("candidatos", "ruta_gestion", "tipo"));
    }

    public function gestion_prueba_ethical_values($proc_can_req_id) {
        $proceso = RegistroProceso::where('proceso', 'ENVIO_PRUEBA_ETHICAL_VALUES')->where('id', $proc_can_req_id)->first();

        if ($proceso == null) {
            return redirect()->route('admin.pruebas_valores_1')->with('mensaje_danger', 'No se ha encontrado la prueba. Intente de nuevo por favor, si persiste el problema contacte con soporte.');
        }

        //if ($proceso->apto != null && $proceso->apto != 3) {
            //return redirect()->route('admin.pruebas_valores_1')->with('mensaje_danger', 'Esta prueba ya ha sido gestionada.');
        //}

        $nombre_prueba = 'Prueba EV (Ethical Values)';

        $ruta_volver = 'admin.pruebas_valores_1';

        //$tipo = 'basico';

        $candidato = $proceso->datosBasicosCandidato;

        $configuracion = PruebaValoresConfigRequerimiento::where('req_id', $proceso->requerimiento_id)->orderBy('id', 'desc')->first();

        $respuesta_user = PruebaValoresRespuestas::where('user_id', $proceso->candidato_id)->where('req_id', $proceso->requerimiento_id)->first();

        $valores_ideal_grafico = [];
        $porcentaje_valores_obtenidos = [];

        if ($respuesta_user != null) {
            $valores_ideal_grafico = [
                "amor"          => intval($configuracion->valor_amor),
                "no_violencia"  => intval($configuracion->valor_no_violencia),
                "paz"           => intval($configuracion->valor_paz),
                "rectitud"      => intval($configuracion->valor_rectitud),
                "verdad"        => intval($configuracion->valor_verdad)
            ];

            $normas_nacionales = PruebaValoresNormasNacionales::first();

            $valores_obtenidos_normalizados = [
                "amor"          => $this->normalizacionDatos($respuesta_user->valor_amor, $normas_nacionales->promedio_amor, $normas_nacionales->desviacion_amor, 2),
                "no_violencia"  => $this->normalizacionDatos($respuesta_user->valor_no_violencia, $normas_nacionales->promedio_no_violencia, $normas_nacionales->desviacion_no_violencia, 2),
                "paz"           => $this->normalizacionDatos($respuesta_user->valor_paz, $normas_nacionales->promedio_paz, $normas_nacionales->desviacion_paz, 2),
                "rectitud"      => $this->normalizacionDatos($respuesta_user->valor_rectitud, $normas_nacionales->promedio_rectitud, $normas_nacionales->desviacion_rectitud, 2),
                "verdad"        => $this->normalizacionDatos($respuesta_user->valor_verdad, $normas_nacionales->promedio_verdad, $normas_nacionales->desviacion_verdad, 2)
            ];

            $maximos_normalizados = [
                "amor"          => $this->normalizacionDatos($respuesta_user->item_amor * 3, $normas_nacionales->promedio_amor, $normas_nacionales->desviacion_amor),
                "no_violencia"  => $this->normalizacionDatos($respuesta_user->item_no_violencia * 3, $normas_nacionales->promedio_no_violencia, $normas_nacionales->desviacion_no_violencia),
                "paz"           => $this->normalizacionDatos($respuesta_user->item_paz * 3, $normas_nacionales->promedio_paz, $normas_nacionales->desviacion_paz),
                "rectitud"      => $this->normalizacionDatos($respuesta_user->item_rectitud * 3, $normas_nacionales->promedio_rectitud, $normas_nacionales->desviacion_rectitud),
                "verdad"        => $this->normalizacionDatos($respuesta_user->item_verdad * 3, $normas_nacionales->promedio_verdad, $normas_nacionales->desviacion_verdad)
            ];

            $porcentaje_valores_obtenidos = [
                "amor"          => $this->obtenerPorcentaje($maximos_normalizados['amor'], $valores_obtenidos_normalizados['amor']),
                "no_violencia"  => $this->obtenerPorcentaje($maximos_normalizados['no_violencia'], $valores_obtenidos_normalizados['no_violencia']),
                "paz"           => $this->obtenerPorcentaje($maximos_normalizados['paz'], $valores_obtenidos_normalizados['paz']),
                "rectitud"      => $this->obtenerPorcentaje($maximos_normalizados['rectitud'], $valores_obtenidos_normalizados['rectitud']),
                "verdad"        => $this->obtenerPorcentaje($maximos_normalizados['verdad'], $valores_obtenidos_normalizados['verdad'])
            ];
        }

        return view("admin.prueba_valores_1.gestionar_prueba_valores_1", compact("candidato", "proceso", "respuesta_user", "configuracion", "nombre_prueba", "ruta_volver", "valores_ideal_grafico", "porcentaje_valores_obtenidos"));
    }

    public function ethical_values_concepto_final(Request $request) {
        //$tipo = $request->tipo;
        $req_id = $request->req_id;
        $user_id = $request->user_id;
        $proceso_id = $request->proceso_id;
        $estado_prueba = $request->estado_prueba;
        $concepto_prueba = $request->concepto_prueba;
        $respuesta_user_id = $request->respuesta_user_id;

        //logger($respuesta_user_id);
        $candidato=DatosBasicos::where("user_id",$user_id)->select("numero_id as cedula")->first();
        if (!empty($respuesta_user_id)) {
            $respuesta_user = PruebaValoresRespuestas::find($respuesta_user_id);
        } else {
            $respuesta_user = new PruebaValoresRespuestas();

            $respuesta_user->fill([
                'user_id'       => $user_id,
                'req_id'        => $req_id,
                'respuestas'    => '',
                'usuario_respuesta'     => $this->user->id,
                'fecha_respuesta'       => date('Y-m-d')
            ]);
        }
        //logger(json_encode($respuesta_user));
        $respuesta_user->fill([
            'gestiono_concepto' => $this->user->id,
            'concepto_final' => $concepto_prueba
        ]);

        $respuesta_user->save();

        $proceso = RegistroProceso::find($proceso_id);

        $proceso->apto = $estado_prueba;
        $proceso->usuario_terminacion = $this->user->id;
        $proceso->save();

        //Generando archivo

        $pdf=$this->pdf_prueba_valores($respuesta_user->id,1);

        if(file_exists('documentos_candidatos/'.$candidato->cedula.'/'.$proceso->requerimiento_id.'/seleccion/prueba_valores_'.$candidato->cedula.'_'.$proceso->requerimiento_id.'.pdf')){

            Storage::disk('public')->delete('documentos_candidatos/'.$candidato->cedula.'/'.$proceso->requerimiento_id.'/seleccion/prueba_valores_'.$candidato->cedula.'_'.$$proceso->requerimiento_id.'.pdf');
        }
        Storage::disk('public')->put('documentos_candidatos/'.$candidato->cedula.'/'.$proceso->requerimiento_id.'/seleccion/prueba_valores_'.$candidato->cedula.'_'.$proceso->requerimiento_id.'.pdf',$pdf);
        

        return response()->json(["success" => true]);
    }



    //Generar informe de la prueba
    public function pdf_prueba_valores($respuesta_id,$download=0)
    {
        $candidato_valores = PruebaValoresRespuestas::join('datos_basicos', 'datos_basicos.user_id', '=', 'prueba_valores_1_respuestas.user_id')
        ->join('users', 'users.id', '=', 'datos_basicos.user_id')
        ->leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
        ->where('prueba_valores_1_respuestas.id', $respuesta_id)
        ->select(
            'prueba_valores_1_respuestas.*',

            'datos_basicos.nombres',
            'datos_basicos.numero_id as cedula',
            'datos_basicos.fecha_nacimiento',
            'datos_basicos.telefono_movil as celular',
            'datos_basicos.email as correo',
            'datos_basicos.primer_apellido',
            'datos_basicos.segundo_apellido',

            'tipo_identificacion.descripcion as tipo_id_desc',

            'users.foto_perfil'
        )
        ->first();

        if ($candidato_valores == null) {
            return redirect()->back();
        }

        $candidato_valores->nombre_completo = $candidato_valores->nombres . ' ' . $candidato_valores->primer_apellido . ($candidato_valores->segundo_apellido != null && $candidato_valores->segundo_apellido != '' ? " $candidato_valores->segundo_apellido" : '');

        $proceso = RegistroProceso::where('candidato_id', $candidato_valores->user_id)
            ->where('proceso', ['ENVIO_PRUEBA_ETHICAL_VALUES'])
            ->where('requerimiento_id', $candidato_valores->req_id)
            ->whereNotNull('apto')
            ->orderBy('created_at', 'DESC')
        ->first();

        $sitio_informacion = Sitio::first();

        //$concepto = PruebaBrigConcepto::where('bryg_id', $bryg_id)->first();

        $normas_nacionales = PruebaValoresNormasNacionales::first();

        $valores_obtenidos_normalizados = [
            "amor"          => $this->normalizacionDatos($candidato_valores->valor_amor, $normas_nacionales->promedio_amor, $normas_nacionales->desviacion_amor, 2),
            "no_violencia"  => $this->normalizacionDatos($candidato_valores->valor_no_violencia, $normas_nacionales->promedio_no_violencia, $normas_nacionales->desviacion_no_violencia, 2),
            "paz"           => $this->normalizacionDatos($candidato_valores->valor_paz, $normas_nacionales->promedio_paz, $normas_nacionales->desviacion_paz, 2),
            "rectitud"      => $this->normalizacionDatos($candidato_valores->valor_rectitud, $normas_nacionales->promedio_rectitud, $normas_nacionales->desviacion_rectitud, 2),
            "verdad"        => $this->normalizacionDatos($candidato_valores->valor_verdad, $normas_nacionales->promedio_verdad, $normas_nacionales->desviacion_verdad, 2)
        ];

        $maximos_normalizados = [
            "amor"          => $this->normalizacionDatos($candidato_valores->item_amor * 3, $normas_nacionales->promedio_amor, $normas_nacionales->desviacion_amor),
            "no_violencia"  => $this->normalizacionDatos($candidato_valores->item_no_violencia * 3, $normas_nacionales->promedio_no_violencia, $normas_nacionales->desviacion_no_violencia),
            "paz"           => $this->normalizacionDatos($candidato_valores->item_paz * 3, $normas_nacionales->promedio_paz, $normas_nacionales->desviacion_paz),
            "rectitud"      => $this->normalizacionDatos($candidato_valores->item_rectitud * 3, $normas_nacionales->promedio_rectitud, $normas_nacionales->desviacion_rectitud),
            "verdad"        => $this->normalizacionDatos($candidato_valores->item_verdad * 3, $normas_nacionales->promedio_verdad, $normas_nacionales->desviacion_verdad)
        ];

        //(Buscar el valor más alto)
        $valores_mayor = array_keys($valores_obtenidos_normalizados, max($valores_obtenidos_normalizados));

        $valores_menor = array_keys($valores_obtenidos_normalizados, min($valores_obtenidos_normalizados));

        $configuracion = PruebaValoresConfigRequerimiento::where('req_id', $candidato_valores->req_id)->orderBy('id', 'desc')->first();

        $valores_ideal_grafico = [
            "amor"          => intval($configuracion->valor_amor),
            "no_violencia"  => intval($configuracion->valor_no_violencia),
            "paz"           => intval($configuracion->valor_paz),
            "rectitud"      => intval($configuracion->valor_rectitud),
            "verdad"        => intval($configuracion->valor_verdad)
        ];

        $valores_ideales_normalizados = [
            "amor"          => round($maximos_normalizados['amor'] * $configuracion->valor_amor / 100),
            "no_violencia"  => round($maximos_normalizados['no_violencia'] * $configuracion->valor_no_violencia / 100),
            "paz"           => round($maximos_normalizados['paz'] * $configuracion->valor_paz / 100),
            "rectitud"      => round($maximos_normalizados['rectitud'] * $configuracion->valor_rectitud / 100),
            "verdad"        => round($maximos_normalizados['verdad'] * $configuracion->valor_verdad / 100)
        ];

        $valores_cruzados = [
            "amor"          => $valores_obtenidos_normalizados['amor'] - $valores_ideales_normalizados['amor'],
            "no_violencia"  => $valores_obtenidos_normalizados['no_violencia'] - $valores_ideales_normalizados['no_violencia'],
            "paz"           => $valores_obtenidos_normalizados['paz'] - $valores_ideales_normalizados['paz'],
            "rectitud"      => $valores_obtenidos_normalizados['rectitud'] - $valores_ideales_normalizados['rectitud'],
            "verdad"        => $valores_obtenidos_normalizados['verdad'] - $valores_ideales_normalizados['verdad']
        ];

        $porcentaje_valores_obtenidos = [
            "amor"          => $this->obtenerPorcentaje($maximos_normalizados['amor'], $valores_obtenidos_normalizados['amor']),
            "no_violencia"  => $this->obtenerPorcentaje($maximos_normalizados['no_violencia'], $valores_obtenidos_normalizados['no_violencia']),
            "paz"           => $this->obtenerPorcentaje($maximos_normalizados['paz'], $valores_obtenidos_normalizados['paz']),
            "rectitud"      => $this->obtenerPorcentaje($maximos_normalizados['rectitud'], $valores_obtenidos_normalizados['rectitud']),
            "verdad"        => $this->obtenerPorcentaje($maximos_normalizados['verdad'], $valores_obtenidos_normalizados['verdad'])
        ];

        $porcentajes_cruzados = [
            "amor"          => $porcentaje_valores_obtenidos['amor'] - $valores_ideal_grafico['amor'],
            "no_violencia"  => $porcentaje_valores_obtenidos['no_violencia'] - $valores_ideal_grafico['no_violencia'],
            "paz"           => $porcentaje_valores_obtenidos['paz'] - $valores_ideal_grafico['paz'],
            "rectitud"      => $porcentaje_valores_obtenidos['rectitud'] - $valores_ideal_grafico['rectitud'],
            "verdad"        => $porcentaje_valores_obtenidos['verdad'] - $valores_ideal_grafico['verdad']
        ];

        $interpretacion = PruebaValoresInterpretacion::get();

        $textosCuantitativos = [
            'amor'          => $this->obtenerInterpretacion($interpretacion, $valores_obtenidos_normalizados['amor']),
            'no_violencia'  => $this->obtenerInterpretacion($interpretacion, $valores_obtenidos_normalizados['no_violencia']),
            'paz'           => $this->obtenerInterpretacion($interpretacion, $valores_obtenidos_normalizados['paz']),
            'rectitud'      => $this->obtenerInterpretacion($interpretacion, $valores_obtenidos_normalizados['rectitud']),
            'verdad'        => $this->obtenerInterpretacion($interpretacion, $valores_obtenidos_normalizados['verdad'])
        ];


        $area = PruebaValoresAreaImportante::first();

        $columna_mayor = $valores_mayor[0].'_mayor';
        $columna_menor = $valores_menor[0].'_menor';

        $area_mayor = $area->$columna_mayor;
        $area_menor = $area->$columna_menor;

        $area_mayor = str_replace('$nombre_candidato', $candidato_valores->nombre_completo, $area_mayor);
        $area_menor = str_replace('$nombre_candidato', $candidato_valores->nombre_completo, $area_menor);

        //dd($valores_ideal_grafico, $valores_ideales_normalizados, $valores_obtenidos_normalizados, $valores_cruzados, $area_mayor, $area_menor, $porcentaje_valores_obtenidos);
        //dd($porcentajes_cruzados);

        //Convertir fecha de solicitud a letras
        $fecha_evaluacion_letra = $candidato_valores->formatoFecha($proceso->created_at);

        //Convertir fecha de realización a letras
        $fecha_realizacion_letra = $candidato_valores->formatoFecha($candidato_valores->fecha_respuesta);

        $candidato_edad = Carbon::parse($candidato_valores->fecha_nacimiento)->age;

        $requerimiento_detalle = Requerimiento::where('requerimientos.id', $candidato_valores->req_id)->first();

        //Generar gráfico radar BRYG
        $grafico_radar_valores = [
            'type' => 'radar',
            'data' => [
                'labels' => ['AMOR', 'NO VIOLENCIA', 'PAZ', 'RECTITUD', 'VERDAD'],
                'datasets' => [
                    [
                        'backgroundColor' => [
                            'rgb(58, 181, 74)'
                        ],
                        'label' => 'Perfil Ideal',
                        'borderColor' => [
                            "rgb(58, 181, 74)"
                        ],
                        'data' => [
                            $valores_ideal_grafico['amor'],
                            $valores_ideal_grafico['no_violencia'],
                            $valores_ideal_grafico['paz'],
                            $valores_ideal_grafico['rectitud'],
                            $valores_ideal_grafico['verdad']
                        ],
                        'borderWidth' => 2,
                        'fill' => false
                    ],
                    [
                        'backgroundColor' => [
                            'rgb(114, 46, 135)'
                        ],
                        'label' => 'Perfil del Candidato',
                        'borderColor' => [
                            "rgb(114, 46, 135)"
                        ],
                        'data' => [
                            $porcentaje_valores_obtenidos['amor'],
                            $porcentaje_valores_obtenidos['no_violencia'],
                            $porcentaje_valores_obtenidos['paz'],
                            $porcentaje_valores_obtenidos['rectitud'],
                            $porcentaje_valores_obtenidos['verdad']
                        ],
                        'borderWidth' => 2,
                        'fill' => false
                    ]
                ]
            ],
            'options' => [
                //'legend' => ['display' => false],
                'title' => [
                    'display' => true,
                    'text' => 'Comparativa Perfil Ideal vs. Perfil del Candidato'
                ],
                'scale' => [
                    'ticks' => [
                        'suggestedMin' => 30,
                        'suggestedMax' => 100
                    ]
                ]
            ]
        ];

        if(!$download){
            return view('admin.prueba_valores_1.informe_resultado', [
                "candidato_valores" => $candidato_valores,
                "sitio_informacion" => $sitio_informacion,

                //"concepto" => $concepto,
                "area_mayor" => $area_mayor,
                "area_menor" => $area_menor,
                "textos_cuantitativos" => $textosCuantitativos,
                "proceso" => $proceso,

                "valores_ideal_grafico" => $valores_ideal_grafico, 
                "valores_ideales_normalizados" => $valores_ideales_normalizados,
                "valores_obtenidos_normalizados" => $valores_obtenidos_normalizados, 

                "valores_cruzados" => $valores_cruzados,
                "porcentajes_cruzados" => $porcentajes_cruzados,

                "porcentaje_valores_obtenidos" => $porcentaje_valores_obtenidos,

                "candidato_edad" => $candidato_edad,
                "fecha_evaluacion_letra" => $fecha_evaluacion_letra,
                "fecha_realizacion_letra" => $fecha_realizacion_letra,
                "requerimiento_detalle" => $requerimiento_detalle,
                "grafico_radar_valores" => $grafico_radar_valores
            ]);
        }
        else{
            return \SnappyPDF::loadView('admin.prueba_valores_1.informe_resultado', [
                "candidato_valores" => $candidato_valores,
                "sitio_informacion" => $sitio_informacion,

                //"concepto" => $concepto,
                "area_mayor" => $area_mayor,
                "area_menor" => $area_menor,
                "textos_cuantitativos" => $textosCuantitativos,
                "proceso" => $proceso,

                "valores_ideal_grafico" => $valores_ideal_grafico, 
                "valores_ideales_normalizados" => $valores_ideales_normalizados,
                "valores_obtenidos_normalizados" => $valores_obtenidos_normalizados, 

                "valores_cruzados" => $valores_cruzados,
                "porcentajes_cruzados" => $porcentajes_cruzados,

                "porcentaje_valores_obtenidos" => $porcentaje_valores_obtenidos,

                "candidato_edad" => $candidato_edad,
                "fecha_evaluacion_letra" => $fecha_evaluacion_letra,
                "fecha_realizacion_letra" => $fecha_realizacion_letra,
                "requerimiento_detalle" => $requerimiento_detalle,
                "grafico_radar_valores" => $grafico_radar_valores
            ])
            ->output();

            //->setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
            //->stream('informe-resultado-ethical-values.pdf');
        }
        

        
    }

    protected function normalizacionDatos($obtenido, $promedio, $desviacion, $division = 1) {
        $total = 0;
        if ($desviacion != 0 && $division != 0) {
            //logger("ob $obtenido; prom $promedio; desv $desviacion");
            //Se divide entre 2 porque la formula esta en base de 3 puntos y nosotros en 6 estrellas
            $total = round((50 + (((($obtenido / $division) - $promedio) / $desviacion) * 10)), 0);
        }
        //logger("t $total");
        return $total;
    }

    protected function obtenerInterpretacion($interpretaciones, $valor) {
        $interpretacionValor = null;
        foreach ($interpretaciones as $key => $interpretacion) {
            $interpretacionValor = $interpretacion->where('rango_inferior', '<=', $valor)->where('rango_superior', '>', $valor)->first();
            if ($interpretacionValor != null) {
                return $interpretacionValor;
            }
        }
        return '';
    }

    protected function obtenerPorcentaje($maximo, $buscar, $base = 100) {
        $porc = 0;
        if ($maximo != 0) {
            $porc = round($buscar * $base / $maximo);
        }
        return $porc;
    }
}
