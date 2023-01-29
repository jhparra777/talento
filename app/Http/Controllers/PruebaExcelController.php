<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\CargoEspecifico;
use App\Models\DatosBasicos;
use App\Models\PruebaExcelConfiguracion;
use App\Models\PruebaExcelOpciones;
use App\Models\PruebaExcelPreguntas;
use App\Models\PruebaExcelRespuestaBasico;
use App\Models\PruebaExcelRespuestaIntermedio;
use App\Models\PruebaExcelRespuestaUser;
use App\Models\RegistroProceso;
use App\Models\Requerimiento;
use App\Models\Sitio;
use App\Models\User;
use DB;
use triPostmaster;

use Storage;
use File;


class PruebaExcelController extends Controller
{
    public function index_basico(Request $data)
    {
        if(empty($this->user->id)){
            session(["url_deseada_redireccion_candidato" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login');
        }

        //Verificar si fue enviado a prueba y que no hayan modificado su estatus
        $check_test = RegistroProceso::where('candidato_id', $this->user->id)
            ->where('proceso', ['ENVIO_EXCEL_BASICO'])
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
        $nombre_prueba = 'Excel Básico';
        $req_id = $data->req_id;

        $configuracion = PruebaExcelConfiguracion::where('req_id', $data->req_id)->select('tiempo_excel_basico as tiempo_maximo', 'aprobacion_excel_basico as minimo_aprobacion')->first();

        $excel_questions = PruebaExcelPreguntas::where('tipo', 'basico')->where('active', 1)->orderByRaw('RAND()')->get();

        $total_preguntas = count($excel_questions);

        $ids = array();
        foreach($excel_questions as $question){ $ids[] = (int)$question->id; }

        //Reload
        $reloadPage = $data->session()->get('reloadPage');

        $ruta_save = route('cv.prueba_excel_basico_save');

        if ($reloadPage === 'yes') {
            $data->session()->forget('reloadPage');
        }else {
            session(['reloadPage' => 'not']);
        }

        return view('cv.pruebas.excel.prueba_excel', compact('sitio', 'user', 'name_user', 'nombre_prueba', 'total_preguntas', 'excel_questions', 'ids', 'reloadPage', 'req_id', 'configuracion', 'ruta_save'));
    }

    public function save_result_basico(Request $request)
    {
        $req_id = $request->req_id;
        $user_id = $this->user->id;

        $proceso = RegistroProceso::where('candidato_id', $this->user->id)
            ->where('proceso', ['ENVIO_EXCEL_BASICO'])
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

        $excelImagenes = json_decode($request->fotosExcel, true);

        $nombres_fotos = '';

        $total_imagenes = count($excelImagenes);

        for($i = 0; $i < $total_imagenes; $i++) {
            //Se verifica que la imagen tenga datos
            if ($excelImagenes[$i]['picture'] != null && $excelImagenes[$i]['picture'] != '') {
                //Convertir base64 a PNG
                $image_parts = explode(";base64,", $excelImagenes[$i]['picture']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fotoNombre = "candidato-foto-$i-$user_id-$req_id.png";

                if ($i == $total_imagenes-1) {
                    $nombres_fotos = $nombres_fotos . $fotoNombre;
                } else {
                    $nombres_fotos = $nombres_fotos . "$fotoNombre,";
                }

                Storage::disk('public')->put("recursos_prueba_excel/prueba_excel_basico_".$user_id.'_'.$req_id."/$fotoNombre", $image_base64);
            }
        }

        $preguntas = PruebaExcelPreguntas::where('tipo', 'basico')->where('active', 1)->select('id')->get()->pluck('id')->toArray();
        //Se obtienen todas las opciones de todas las preguntas, que servira para verificar si respondio correctamente.
        $opcionesPrueba = PruebaExcelOpciones::whereIn('id_pregunta', $preguntas)->get();
        $correctas = 0;

        $respuesta_user = PruebaExcelRespuestaUser::where('user_id', $this->user->id)->where('req_id', $req_id)->where('tipo', 'basico')->first();
        if ($respuesta_user == null) {
            $respuesta_user = new PruebaExcelRespuestaUser();
        }
        $respuesta_user->user_id    = $this->user->id;
        $respuesta_user->req_id     = $req_id;
        $respuesta_user->tipo       = 'basico';
        $respuesta_user->fotos      = $nombres_fotos;
        $respuesta_user->fecha_respuesta = date('Y-m-d');
        $respuesta_user->total_preguntas = count($preguntas);

        $respuesta_user->save();

        $preg_resp = $request->except('req_id', 'userId', '_token', 'fotosExcel');
        foreach ($preg_resp as $preg_id_text => $opcion) {
            $pregunta_id = str_replace('preg_id_', '', $preg_id_text);

            $respuestas_basico = new PruebaExcelRespuestaBasico();

            $respuestas_basico->user_id     = $this->user->id;
            $respuestas_basico->opcion_id   = $opcion;
            $respuestas_basico->pregunta_id = $pregunta_id;
            $respuestas_basico->respuesta_user_id = $respuesta_user->id;

            $verificar = $opcionesPrueba->find($opcion);
            //Se verifica si la seleccion del usuario era la respuesta correcta
            if ($verificar->correcta) {
                $correctas++;
            }

            $respuestas_basico->save();
        }

        $respuesta_user->respuestas_correctas = $correctas;
        $respuesta_user->save();

        $informacionUsuarioGestion = $proceso->datosBasicosUsuarioEnvio;
        $candidato = $proceso->datosBasicosCandidato;
        $sitio = Sitio::first();

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Notificación prueba Excel Básico"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "
            Hola $informacionUsuarioGestion->nombres, te informamos que el/la candidat@ $candidato->nombres $candidato->primer_apellido asociad@ al requerimiento <b>$data->req_id</b> ha terminado con éxito la prueba de Excel Básico. <br>
            Para ver sus resultados puedes ingresar al menú lateral en la plataforma <i>Proceso de Selección > Prueba Excel Básico</i> y buscar por su número de documento. <br>
            También puedes dar clic en <b>Ver resultados</b> e ir directamente a la página.
        ";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'Ver resultados', 'buttonRoute' => route('admin.gestionar_excel_basico', ['id' => $proceso->id])];

        $mailUser = $informacionUsuarioGestion->user_id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        //Enviar correo generado
        Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($informacionUsuarioGestion, $sitio) {
            $message->to([$informacionUsuarioGestion->email], 'T3RS')
            ->bcc($sitio->email_replica)
            ->subject("Notificación prueba Excel Básico")
            ->getHeaders()
            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        return response()->json(['success' => true]);
    }

    public function lista_excel_basico(Request $data) {
        $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
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
            ->where("procesos_candidato_req.proceso", "ENVIO_EXCEL_BASICO")
            ->orderBy('requerimiento_cantidato.requerimiento_id', 'desc')
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                "requerimiento_cantidato.*",
                DB::raw('(select prueba_excel_respuestas_user.fecha_respuesta from prueba_excel_respuestas_user where prueba_excel_respuestas_user.req_id = procesos_candidato_req.requerimiento_id and prueba_excel_respuestas_user.user_id=datos_basicos.user_id and prueba_excel_respuestas_user.tipo = \'intermedio\') as fecha_respuesta')
            )
        ->paginate(10);

        $ruta_gestion = 'admin.gestionar_excel_basico';

        $ruta_listado = 'admin.pruebas_excel_basico';

        $tipo = 'Básico';

        return view("admin.excel.lista_candidatos", compact("candidatos", "ruta_gestion", "tipo"));
    }

    public function gestion_prueba_excel_basico($proc_can_req_id) {
        $proceso = RegistroProceso::where('id', $proc_can_req_id)->where('proceso', ['ENVIO_EXCEL_BASICO'])->first();

        if ($proceso == null) {
            return redirect()->route('admin.pruebas_excel_basico')->with('mensaje_danger', 'No se ha encontrado la prueba. Intente de nuevo por favor, si persiste el problema contacte con soporte.');
        }

        /*if ($proceso->apto != null && $proceso->apto != 3) {
            return redirect()->route('admin.pruebas_excel_basico')->with('mensaje_danger', 'Esta prueba ya ha sido gestionada.');
        }*/

        $nombre_prueba = 'Prueba Excel Básico';

        $ruta_volver = 'admin.pruebas_excel_basico';

        $tipo = 'basico';

        $candidato = $proceso->datosBasicosCandidato;

        $configuracion = PruebaExcelConfiguracion::where('req_id', $proceso->requerimiento_id)->select('tiempo_excel_basico as tiempo_maximo', 'aprobacion_excel_basico as minimo_aprobacion')->first();

        $respuesta_user = PruebaExcelRespuestaUser::where('user_id', $proceso->candidato_id)->where('req_id', $proceso->requerimiento_id)->where('tipo', 'basico')->first();

        return view("admin.excel.gestionar_prueba_excel", compact("candidato", "proceso", "respuesta_user", "configuracion", "nombre_prueba", "ruta_volver", "tipo"));
    }

    public function index_intermedio(Request $data)
    {
        if(empty($this->user->id)){
            session(["url_deseada_redireccion_candidato" => url($_SERVER['REQUEST_URI'])]);
            return redirect()->route('login');
        }

        //Verificar si fue enviado a prueba y que no hayan modificado su estatus
        $check_test = RegistroProceso::where('candidato_id', $this->user->id)
            ->where('proceso', ['ENVIO_EXCEL_INTERMEDIO'])
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
        $nombre_prueba = 'Excel Intermedio';
        $req_id = $data->req_id;

        $configuracion = PruebaExcelConfiguracion::where('req_id', $data->req_id)->select('tiempo_excel_intermedio as tiempo_maximo', 'aprobacion_excel_intermedio as minimo_aprobacion')->first();

        $excel_questions = PruebaExcelPreguntas::where('tipo', 'intermedio')->where('active', 1)->orderByRaw('RAND()')->get();

        $total_preguntas = count($excel_questions);

        $ids = array();
        foreach($excel_questions as $question){ $ids[] = (int)$question->id; }

        //Reload
        $reloadPage = $data->session()->get('reloadPage');

        if ($reloadPage === 'yes') {
            $data->session()->forget('reloadPage');
        }else {
            session(['reloadPage' => 'not']);
        }

        $ruta_save = route('cv.prueba_excel_intermedio_save');

        return view('cv.pruebas.excel.prueba_excel', compact('sitio', 'user', 'name_user', 'nombre_prueba', 'total_preguntas', 'excel_questions', 'ids', 'reloadPage', 'req_id', 'configuracion', 'ruta_save'));
    }

    public function save_result_intermedio(Request $request)
    {
        $req_id = $request->req_id;
        $user_id = $this->user->id;

        $proceso = RegistroProceso::where('candidato_id', $this->user->id)
            ->where('proceso', ['ENVIO_EXCEL_INTERMEDIO'])
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

        $excelImagenes = json_decode($request->fotosExcel, true);

        $nombres_fotos = '';

        $total_imagenes = count($excelImagenes);

        for($i = 0; $i < $total_imagenes; $i++) {
            //Se verifica que la imagen tenga datos
            if ($excelImagenes[$i]['picture'] != null && $excelImagenes[$i]['picture'] != '') {
                //Convertir base64 a PNG
                $image_parts = explode(";base64,", $excelImagenes[$i]['picture']);
                $image_type_aux = explode("image/", $image_parts[0]);
                $image_type = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $fotoNombre = "candidato-foto-$i-$user_id-$req_id.png";

                if ($i == $total_imagenes-1) {
                    $nombres_fotos = $nombres_fotos . $fotoNombre;
                } else {
                    $nombres_fotos = $nombres_fotos . "$fotoNombre,";
                }

                Storage::disk('public')->put("recursos_prueba_excel/prueba_excel_intermedio_".$user_id.'_'.$req_id."/$fotoNombre", $image_base64);
            }
        }

        $preguntas = PruebaExcelPreguntas::where('tipo', 'intermedio')->where('active', 1)->select('id')->get()->pluck('id')->toArray();
        //Se obtienen todas las opciones de todas las preguntas, que servira para verificar si respondio correctamente.
        $opcionesPrueba = PruebaExcelOpciones::whereIn('id_pregunta', $preguntas)->get();
        $correctas = 0;

        $respuesta_user = PruebaExcelRespuestaUser::where('user_id', $this->user->id)->where('req_id', $req_id)->where('tipo', 'intermedio')->first();
        if ($respuesta_user == null) {
            $respuesta_user = new PruebaExcelRespuestaUser();
        }
        $respuesta_user->user_id    = $this->user->id;
        $respuesta_user->req_id     = $req_id;
        $respuesta_user->tipo       = 'intermedio';
        $respuesta_user->fotos      = $nombres_fotos;
        $respuesta_user->fecha_respuesta = date('Y-m-d');
        $respuesta_user->total_preguntas = count($preguntas);

        $respuesta_user->save();

        $preg_resp = $request->except('req_id', 'userId', '_token', 'fotosExcel');
        foreach ($preg_resp as $preg_id_text => $opcion) {
            $pregunta_id = str_replace('preg_id_', '', $preg_id_text);

            $respuestas_intermedio = new PruebaExcelRespuestaIntermedio();

            $respuestas_intermedio->user_id     = $this->user->id;
            $respuestas_intermedio->opcion_id   = $opcion;
            $respuestas_intermedio->pregunta_id = $pregunta_id;
            $respuestas_intermedio->respuesta_user_id = $respuesta_user->id;

            $verificar = $opcionesPrueba->find($opcion);
            //Se verifica si la seleccion del usuario era la respuesta correcta
            if ($verificar->correcta) {
                $correctas++;
            }

            $respuestas_intermedio->save();
        }

        $respuesta_user->respuestas_correctas = $correctas;
        $respuesta_user->save();

        $sitio = Sitio::first();
        $informacionUsuarioGestion = $proceso->datosBasicosUsuarioEnvio;
        $candidato = $proceso->datosBasicosCandidato;

        $mailTemplate = 2; //Plantilla con botón e imagen de fondo
        $mailConfiguration = 1; //Id de la configuración
        $mailTitle = "Notificación prueba Excel Intermedio"; //Titulo o tema del correo

        //Cuerpo con html y comillas dobles para las variables
        $mailBody = "
            Hola $informacionUsuarioGestion->nombres, te informamos que el/la candidat@ $candidato->nombres $candidato->primer_apellido asociad@ al requerimiento <b>$data->req_id</b> ha terminado con éxito la prueba de Excel Intermedio. <br>
            Para ver sus resultados puedes ingresar al menú lateral en la plataforma <i>Proceso de Selección > Prueba Excel Intermedio</i> y buscar por su número de documento. <br>
            También puedes dar clic en <b>Ver resultados</b> e ir directamente a la página.
        ";

        //Arreglo para el botón
        $mailButton = ['buttonText' => 'Ver resultados', 'buttonRoute' => route('admin.gestionar_excel_intermedio', ['id' => $proceso->id])];

        $mailUser = $informacionUsuarioGestion->user_id; //Id del usuario al que se le envía el correo

        $triEmail = triPostmaster::makeEmail($mailTemplate, $mailConfiguration, $mailTitle, $mailBody, $mailButton, $mailUser);

        //Enviar correo generado
        Mail::send($triEmail->view, ['data' => $triEmail->data], function ($message) use ($informacionUsuarioGestion, $sitio) {
            $message->to([$informacionUsuarioGestion->email], 'T3RS')
            ->bcc($sitio->email_replica)
            ->subject("Notificación prueba Excel Intermedio")
            ->getHeaders()
            ->addTextHeader('X-SES-CONFIGURATION-SET', 'watch_emails_t3rs');
        });

        return response()->json(['success' => true]);
    }

    public function lista_excel_intermedio(Request $data) {
        $candidatos = DatosBasicos::join("procesos_candidato_req", "procesos_candidato_req.candidato_id", "=", "datos_basicos.user_id")
            ->join("requerimiento_cantidato", "requerimiento_cantidato.id", "=", "procesos_candidato_req.requerimiento_candidato_id")
            ->join('requerimientos', 'requerimientos.id', '=', 'procesos_candidato_req.requerimiento_id')
            ->join('estados_requerimiento', 'requerimientos.id', '=', 'estados_requerimiento.req_id')
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
            ->where("procesos_candidato_req.proceso", "ENVIO_EXCEL_INTERMEDIO")
            ->orderBy('requerimiento_cantidato.requerimiento_id', 'desc')
            ->select(
                "procesos_candidato_req.proceso",
                "procesos_candidato_req.id as ref_id",
                "datos_basicos.*",
                "requerimiento_cantidato.*",
                DB::raw('(select prueba_excel_respuestas_user.fecha_respuesta from prueba_excel_respuestas_user where prueba_excel_respuestas_user.req_id = procesos_candidato_req.requerimiento_id and prueba_excel_respuestas_user.user_id=datos_basicos.user_id and prueba_excel_respuestas_user.tipo = \'intermedio\') as fecha_respuesta')
            )
        ->paginate(10);

        $ruta_gestion = 'admin.gestionar_excel_intermedio';

        $ruta_listado = 'admin.pruebas_excel_intermedio';

        $tipo = 'Intermedio';

        return view("admin.excel.lista_candidatos", compact("candidatos", "ruta_gestion", "tipo"));
    }

    public function gestion_prueba_excel_intermedio($proc_can_req_id) {
        $proceso = RegistroProceso::where('id', $proc_can_req_id)->where('proceso', ['ENVIO_EXCEL_INTERMEDIO'])->first();

        if ($proceso == null) {
            return redirect()->route('admin.pruebas_excel_intermedio')->with('mensaje_danger', 'No se ha encontrado la prueba. Intente de nuevo por favor, si persiste el problema contacte con soporte.');
        }

        /*if ($proceso->apto != null && $proceso->apto != 3) {
            return redirect()->route('admin.pruebas_excel_intermedio')->with('mensaje_danger', 'Esta prueba ya ha sido gestionada.');
        }*/

        $nombre_prueba = 'Prueba Excel Intermedio';

        $ruta_volver = 'admin.pruebas_excel_intermedio';

        $tipo = 'intermedio';

        $candidato = $proceso->datosBasicosCandidato;

        $configuracion = PruebaExcelConfiguracion::where('req_id', $proceso->requerimiento_id)->select('tiempo_excel_intermedio as tiempo_maximo', 'aprobacion_excel_intermedio as minimo_aprobacion')->first();

        $respuesta_user = PruebaExcelRespuestaUser::where('user_id', $proceso->candidato_id)->where('req_id', $proceso->requerimiento_id)->where('tipo', 'intermedio')->first();

        return view("admin.excel.gestionar_prueba_excel", compact("candidato", "proceso", "respuesta_user", "configuracion", "nombre_prueba", "ruta_volver", "tipo"));
    }

    //Visualizar configuración
    public function configuracionExcelModal(Request $request)
    {
        $req_id = $request->req_id;
        $configuracion = PruebaExcelConfiguracion::where('req_id', $req_id)->orderBy('created_at', 'DESC')->first();

        if (empty($configuracion)) {
            $configuracion = new PruebaExcelConfiguracion();

            $requerimiento = Requerimiento::select('cargo_especifico_id')->find($req_id);

            $cargo_especifico = CargoEspecifico::where('id', $requerimiento->cargo_especifico_id)->first();

            if ($cargo_especifico->excel_basico || $cargo_especifico->excel_intermedio) {
                $configuracion->gestiono     = $this->user->id;
                $configuracion->req_id       = $candidato->req_id;
                $configuracion->excel_basico                 = $cargo_especifico->excel_basico;
                $configuracion->excel_intermedio             = $cargo_especifico->excel_intermedio;
                $configuracion->tiempo_excel_basico          = $cargo_especifico->tiempo_excel_basico;
                $configuracion->tiempo_excel_intermedio      = $cargo_especifico->tiempo_excel_intermedio;
                $configuracion->aprobacion_excel_basico      = $cargo_especifico->aprobacion_excel_basico;
                $configuracion->aprobacion_excel_intermedio  = $cargo_especifico->aprobacion_excel_intermedio;
            }
        }

        return view("admin.reclutamiento.modal.configurar_prueba_excel", compact("configuracion", "req_id"));
    }

    public function guardarConfiguracionExcelModal(Request $request) {
        if (!empty($request->req_id)) {
            $configuracion = PruebaExcelConfiguracion::where('req_id', $request->req_id)->first();
            if (empty($configuracion)) {
                $configuracion = new PruebaExcelConfiguracion();
            }

            $configuracion->req_id = $request->req_id;
            $configuracion->gestiono = $this->user->id;
        } else {
            $configuracion = CargoEspecifico::find($request->cargo_id);
        }

        if($request->has("excel_basico")) {    
            $configuracion->excel_basico = 1;
            $configuracion->aprobacion_excel_basico = $request->aprobacion_excel_basico;
            $configuracion->tiempo_excel_basico = $request->tiempo_excel_basico;
        } else {
            $configuracion->excel_basico = 0;
            $configuracion->aprobacion_excel_basico = null;
            $configuracion->tiempo_excel_basico = null;
        }

        if($request->has("excel_intermedio")) {    
            $configuracion->excel_intermedio = 1;
            $configuracion->aprobacion_excel_intermedio = $request->aprobacion_excel_intermedio;
            $configuracion->tiempo_excel_intermedio = $request->tiempo_excel_intermedio;
        } else {
            $configuracion->excel_intermedio = 0;
            $configuracion->aprobacion_excel_intermedio = null;
            $configuracion->tiempo_excel_intermedio = null;
        }

        $respuesta = $configuracion->save();

        return response()->json(["success" => $respuesta]);
    }

    //Visualizar configuración Cargo
    public function configuracionExcelModalCargo(Request $request)
    {
        $req_id = null;
        $cargo_id = $request->cargo_id;
        $configuracion = CargoEspecifico::find($cargo_id);

        return view("admin.reclutamiento.modal.configurar_prueba_excel", compact("configuracion", "req_id", "cargo_id"));
    }

    public function pdf_prueba_excel($id_respuesta_user,$download=0) {
        $respuesta_user = PruebaExcelRespuestaUser::join('datos_basicos','datos_basicos.user_id','=','prueba_excel_respuestas_user.user_id')
            ->join('users', 'users.id', '=', 'datos_basicos.user_id')
            ->leftjoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            ->select(
                'datos_basicos.*',
                'prueba_excel_respuestas_user.*',
                'prueba_excel_respuestas_user.id as id_resp_user',
                'tipo_identificacion.descripcion as tipo_id_desc',
                'users.foto_perfil'
            )
        ->find($id_respuesta_user);

        if ($respuesta_user->tipo == 'basico') {
            $titulo_prueba = 'Prueba Excel Básico';
            $proceso = RegistroProceso::where('candidato_id', $respuesta_user->user_id)
                ->where('proceso', ['ENVIO_EXCEL_BASICO'])
                ->where('requerimiento_id', $respuesta_user->req_id)
                ->whereNotNull('apto')
                ->orderBy('created_at', 'DESC')
            ->first();
        } else if ($respuesta_user->tipo == 'intermedio') {
            $titulo_prueba = 'Prueba Excel Intermedio';
            $proceso = RegistroProceso::where('candidato_id', $respuesta_user->user_id)
                ->where('proceso', ['ENVIO_EXCEL_INTERMEDIO'])
                ->where('requerimiento_id', $respuesta_user->req_id)
                ->whereNotNull('apto')
                ->orderBy('created_at', 'DESC')
            ->first();
        }

        if ($respuesta_user == null) {
            return redirect()->back();
        }

        $sitio_informacion = Sitio::first();

        //vista para pruebas
        

        if(!$download){
            return view("admin.excel.pdf_prueba_excel", compact('respuesta_user', 'titulo_prueba', 'proceso', 'sitio_informacion'));
        }
        else{

            return \SnappyPDF::loadView("admin.excel.pdf_prueba_excel",[
                'respuesta_user'=>$respuesta_user,
                'titulo_prueba'=>$titulo_prueba,
                'proceso'=>$proceso,
                'sitio_informacion'=>$sitio_informacion
            ])->setPaper("A4")->output();
            
        }
        

        
    }

    public function prueba_excel_concepto_final(Request $request) {
        $tipo = $request->tipo;
        $req_id = $request->req_id;
        $user_id = $request->user_id;
        $proceso_id = $request->proceso_id;
        $estado_prueba = $request->estado_prueba;
        $concepto_prueba = $request->concepto_prueba;
        $respuesta_user_id = $request->respuesta_user_id;



        if ($tipo == 'basico') {
            $tipo_envio = 'ENVIO_EXCEL_BASICO';
        } else if ($tipo == 'intermedio') {
            $tipo_envio = 'ENVIO_EXCEL_INTERMEDIO';
        }

        if (!empty($respuesta_user_id)) {
            $respuesta_user = PruebaExcelRespuestaUser::find($respuesta_user_id);
        } else {
            $total_preguntas_count = PruebaExcelPreguntas::where('tipo', "$tipo")->where('active', 1)->count();

            $respuesta_user = new PruebaExcelRespuestaUser();

            $respuesta_user->fill([
                'user_id' => $user_id,
                'req_id'  => $req_id,
                'tipo'    => $tipo,
                'respuestas_correctas' => 0,
                'total_preguntas'      => $total_preguntas_count,
                'fecha_respuesta'      => date('Y-m-d')
            ]);
        }
        $respuesta_user->fill([
            'gestiono_concepto' => $this->user->id,
            'concepto_final' => $concepto_prueba
        ]);

        $respuesta_user->save();

        $proceso = RegistroProceso::find($proceso_id);

        $proceso->apto = $estado_prueba;
        $proceso->usuario_terminacion = $this->user->id;
        $proceso->save();

        $candidato=DatosBasicos::where("user_id",$respuesta_user->user_id)->select("numero_id as cedula")->first();

        //Generar pdf
        $pdf=$this->pdf_prueba_excel($respuesta_user->id,1);

        if($tipo=="basico"){
            if(file_exists('documentos_candidatos/'.$candidato->cedula.'/'.$respuesta_user->req_id.'/seleccion/prueba_excel_'.$candidato->cedula.'_'.$respuesta_user->req_id.'.pdf')){

            Storage::disk('public')->delete('documentos_candidatos/'.$candidato->cedula.'/'.$respuesta_user->req_id.'/seleccion/prueba_excel_'.$candidato->cedula.'_'.$respuesta_user->req_id.'.pdf');
            }
        }
        else{
            if(file_exists('documentos_candidatos/'.$candidato->cedula.'/'.$respuesta_user->req_id.'/seleccion/prueba_excel_intermedio_'.$candidato->cedula.'_'.$respuesta_user->req_id.'.pdf')){

            Storage::disk('public')->delete('documentos_candidatos/'.$candidato->cedula.'/'.$respuesta_user->req_id.'/seleccion/prueba_excel_intermedio_'.$candidato->cedula.'_'.$respuesta_user->req_id.'.pdf');
            }
        }
        
        

        return response()->json(["success" => true]);
    }
}
