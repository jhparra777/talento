<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\SitioModulo;
use App\Models\DatosBasicos;
use App\Models\ReqCandidato;
use Illuminate\Http\Request;
use App\Models\VisitaCandidato;

use App\Models\ConsultaSeguridad;
use App\Http\Controllers\Controller;
use App\Models\ControlFuncionalidad;
use App\Traits\ConsultaSeguridadCommon;
use Illuminate\Support\Facades\Storage;

use App\Models\ConsultaSeguridadRegistro;

use App\Models\TrazabilidadFuncionalidad;
use App\Models\ConsultaSeguridadConfiguracion;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use App\Http\Controllers\ReclutamientoController;

class ConsultaSeguridadController extends Controller
{
    use ConsultaSeguridadCommon;

    public function ConsultaVerifica(Request $request)
    {
        //La funcionalidad es Consulta de Seguridad - Obtiene el tipo de funcionalidad y su limite.
        $ControlLimite = ControlFuncionalidad::join('tipo_funcionalidad_avanzada', 'tipo_funcionalidad_avanzada.id', '=', 'control_funcionalidad.tipo_funcionalidad')
        ->where('control_funcionalidad.tipo_funcionalidad', 1)
        ->select('control_funcionalidad.*', 'control_funcionalidad.id as id_control', 'tipo_funcionalidad_avanzada.*')
        ->first();

        //Obtiene el mes actual.
        $mes = date("n");
        $ano = date("Y");

        //Obtiene el número de registros de acuerdo a la funcionalidad y el mes.
        $TrazabilidadConteo = TrazabilidadFuncionalidad::join('control_funcionalidad', 'control_funcionalidad.id', '=', 'trazabilidad_funcionalidades.control_id')
        ->where('control_funcionalidad.tipo_funcionalidad', 1)
        ->whereMonth('trazabilidad_funcionalidades.created_at', '=', $mes)
        ->whereYear('trazabilidad_funcionalidades.created_at', '=', $ano)
        ->count();

        if($TrazabilidadConteo == $ControlLimite->limite){
            return response()->json(["limite" => true]);
        }elseif($TrazabilidadConteo >= $ControlLimite->limite){
            return response()->json(["limite" => true]);
        }else{
            $query = ConsultaSeguridad::where('user_id', $request->b)
            ->where('req_id', $request->c)
            ->first();

            if($query !== null){
                return response()->json(["success" => true, "limite" => false]);
            }else{
                return response()->json(["success" => false, "limite" => false]);
            }
        }
    }

    public function QueryPerson (Request $request, $convert, bool $ver_resultado = false)
    {
        $sitio_modulo = SitioModulo::first();

        if($sitio_modulo->consulta_seguridad == 'enabled') {
            $user_id = $request->b;
            $user_gestion = Sentinel::getUser()->id;
            $req_id = $request->c;
            $cliente_id = $request->d;

            $datos_basicos = DatosBasicos::leftJoin("tipo_identificacion", "tipo_identificacion.id", "=", "datos_basicos.tipo_id")
            ->leftJoin("generos", "generos.id", "=", "datos_basicos.genero")
            ->leftJoin("estados_civiles", "estados_civiles.id", "=", "datos_basicos.estado_civil")
            ->leftJoin("aspiracion_salarial", "aspiracion_salarial.id", "=", "datos_basicos.aspiracion_salarial")
            ->leftJoin("clases_libretas", "clases_libretas.id", "=", "datos_basicos.clase_libreta")
            ->leftJoin("tipos_vehiculos", "tipos_vehiculos.id", "=", "datos_basicos.tipo_vehiculo")
            ->leftJoin("categorias_licencias", "categorias_licencias.id", "=", "datos_basicos.categoria_licencia")
            ->leftJoin("entidades_afp", "entidades_afp.id", "=", "datos_basicos.entidad_afp")
            ->leftJoin("entidades_eps", "entidades_eps.id", "=", "datos_basicos.entidad_eps")
            ->where("user_id", $user_id)
            ->select(
                "datos_basicos.*",
                "tipo_identificacion.descripcion as dec_tipo_doc", 
                "generos.descripcion as genero_desc",
                "estados_civiles.descripcion as estado_civil_des",
                "aspiracion_salarial.descripcion as aspiracion_salarial_des",
                "clases_libretas.descripcion as clases_libretas_des",
                "tipos_vehiculos.descripcion as tipos_vehiculos_des",
                "categorias_licencias.descripcion as categorias_licencias_des",
                "entidades_afp.descripcion as entidades_afp_des",
                "entidades_eps.descripcion as entidades_eps_des"
            )
            ->first();

            // $cc = $request->a;
            // $type = 1;

            // $url = "AnalyzerOnLine?IdentificationType=".$type."&SearchParam=".$cc."&Token=J33TRWJI";

            // $client = new Client([
            //     'base_uri' => "http://18.233.198.218:8080/api/",
            //     'headers' => [
            //         'Authorization' => 'J33TRWJI',
            //         'Accept'        => 'application/json'
            //     ]
            // ]);

            // $response = $client->request('GET', $url);

            // $convert =  json_decode( $response->getBody()->getContents() );
            // $convert =  json_decode( $convert, true );

            /**
             * Guardar JSON retornado
             */

            ConsultaSeguridadRegistro::create([
                'user_id' => $user_id,
                'req_id' => $req_id,
                'gestion_id' => Sentinel::getUser()->id,
                'json' => json_encode($convert)
            ]);

            /**
             * Listas
             */

            $todas_listas = [];

            /**
             * Listas que se usan para calcular factor
             */

            $listas_consulta = [
                'FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO',
                'INTERPOL',
                'DESMOVILIZADOS',
                'CONSEJO SUPERIOR DE LA JUDICATURA',
                'BOLETIN PROCURADURIA',
                'BOLETIN PRESIDENCIA',
                'BOLETIN POLICIA',
                'BOLETIN FISCALIA',
                'BOLETIN DEA',
                'RAMA JUDICIAL DEL PODER PUBLICO'
            ];

            /**
             * Listas del PDF
             */

            $listas_consulta_general = [
                'FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO',
                'INTERPOL',
                'DESMOVILIZADOS',
                'CONSEJO SUPERIOR DE LA JUDICATURA',
                'BOLETIN PROCURADURIA',
                'BOLETIN PRESIDENCIA',
                'BOLETIN POLICIA',
                'BOLETIN FISCALIA',
                'BOLETIN DEA',
                'RAMA JUDICIAL DEL PODER PUBLICO',
                'MEDIOS DE COMUNICACIÓN'
            ];

            /**
             * Para factor
             */

            $factor_seguridad = 0;

            /**
             * Almacena puntajes
             */

            $listas_puntaje = [];

            /**
             * Buscar frases clave
             */

            $frase_clave = null;

            /**
             * Este string se toma de la primer lista (Procuraduría General de la Nación) y se compara con otros para determinar si hay relación con antecedentes
             */

            $frase_obtenida = $convert[1]["SearchList"][0]["QueryDetail"]["MoreInfo"];

            $frase_clave = "/ANTECEDENTES PENALES/";

            if(preg_match($frase_clave, $frase_obtenida)) {
                //Si tiene antecedentes, queda en factor 25
                array_push($listas_puntaje, 25);
            }else{
                $frase_clave = "/ANTECEDENTES DISCIPLINARIOS/";

                if(preg_match($frase_clave, $frase_obtenida)) {
                    //Si tiene antecedentes, queda en factor 25
                    array_push($listas_puntaje, 25);
                }else {
                    /**
                     *  Validar si hay en las siguientes listas. Si hay automaticamente queda en 25.
                     */

                    $listas_reportar = [
                        'RAMA JUDICIAL DEL PODER PUBLICO',
                        'INTERPOL',
                        'BOLETIN POLICIA',
                        'BOLETIN FISCALIA',
                        'BOLETIN DEA',
                        'FOREIGN CORRUPT PRACTICES ACT EEUU'
                    ];

                    $contar_listas = [];

                    /**
                     * Recorrer resultados para buscar en listas
                     */

                    for ($i=0; $i < count($convert[1]["SearchList"]); $i++) {
                        if (in_array($convert[1]["SearchList"][$i]["ListName"], $listas_reportar)) {
                            //Validar si es true
                            if ($convert[1]["SearchList"][$i]["InRisk"]) {
                                //Agrega lista al arreglo
                                array_push($contar_listas, $convert[1]["SearchList"][$i]["ListName"]);
                            }
                        }
                    }

                    /**
                     * Validar longitud del conteo de listas
                     */

                    if (count($contar_listas) > 0) {
                        //Si tiene resultado en alguna de las listas, queda en factor 25
                        array_push($listas_puntaje, 25);
                    }else {
                        //Procuradoria Nacional
                        $frase_clave = "/El ciudadano no presenta antecedentes/";

                        if(preg_match($frase_clave, $frase_obtenida)) {
                            array_push($listas_puntaje, 100);
                        }else {
                            array_push($listas_puntaje, 0);
                        }

                        /**
                         * Recorrer resultados para buscar en listas que afectan factor
                         */

                        //Bandera para, RAMA JUDICIAL DEL PODER PUBLICO duplicada
                        $rama_judicial_lista = false;

                        for ($i=0; $i < count($convert[1]["SearchList"]); $i++) {
                            if (in_array($convert[1]["SearchList"][$i]["ListName"], $listas_consulta)) {
                                if ($convert[1]["SearchList"][$i]["ListName"] == 'RAMA JUDICIAL DEL PODER PUBLICO' && $rama_judicial_lista) {
                                    //Nothing
                                }else {
                                    //Validar si es false
                                    if (!$convert[1]["SearchList"][$i]["InRisk"]) {
                                        array_push($listas_puntaje, 100);
                                    }else {
                                        array_push($listas_puntaje, 0);
                                    }
                                }

                                //Cambiar valor de bandera
                                if ($convert[1]["SearchList"][$i]["ListName"] ==  'RAMA JUDICIAL DEL PODER PUBLICO') {
                                    $rama_judicial_lista = true;
                                }
                            }
                        }
                    }
                }
            } //Fin validaciones

            /**
             * Agregar al arreglo general las listas
             */

            $rama_judicial_lista_todas = false;

            for ($i=0; $i < count($convert[1]["SearchList"]); $i++) {
                if (in_array($convert[1]["SearchList"][$i]["ListName"], $listas_consulta_general)) {
                    if ($convert[1]["SearchList"][$i]["ListName"] == 'RAMA JUDICIAL DEL PODER PUBLICO' && $rama_judicial_lista_todas) {
                        //Nothing
                    }else {
                        $todas_listas[str_replace(' ', '_', $convert[1]["SearchList"][$i]["ListName"])] = $convert[1]["SearchList"][$i];
                    }

                    //Cambiar valor de bandera
                    if ($convert[1]["SearchList"][$i]["ListName"] ==  'RAMA JUDICIAL DEL PODER PUBLICO') {
                        $rama_judicial_lista_todas = true;
                    }
                }
            }

            /**
             * Calcular factor
             */

            if (count($listas_puntaje) > 1) {
                $factor_seguridad = array_sum($listas_puntaje) / 11;
            }else {
                $factor_seguridad = array_sum($listas_puntaje);
            }

            /**
             * 
             */

            $query_buscar = ConsultaSeguridad::where('user_id', $user_id)->where('req_id', $req_id)->first();

            $control_limite = ControlFuncionalidad::join('tipo_funcionalidad_avanzada', 'tipo_funcionalidad_avanzada.id', '=', 'control_funcionalidad.tipo_funcionalidad')
            ->where('control_funcionalidad.tipo_funcionalidad', 1)
            ->select('control_funcionalidad.*', 'control_funcionalidad.id as id_control', 'tipo_funcionalidad_avanzada.*')
            ->first();

            if(empty($query_buscar)) {
                ConsultaSeguridad::create([
                    'user_id'           => $user_id,
                    'user_gestion'      => Sentinel::getUser()->id,
                    'req_id'            => $req_id,
                    'cliente_id'        => $cliente_id,
                    'factor_seguridad'  => $factor_seguridad,
                    'contador'          => 1,
                ]);

                TrazabilidadFuncionalidad::create([
                    'control_id'         => $control_limite->id_control,
                    'tipo_funcionalidad' => 1,
                    'user_gestion'       => Sentinel::getUser()->id,
                    'req_id'             => $req_id,
                    'empresa'            => '',
                    'descripcion'        => 'CONSULTA DE SEGURIDAD',
                ]);
            }else {
                TrazabilidadFuncionalidad::create([
                    'control_id'         => $control_limite->id_control,
                    'tipo_funcionalidad' => 1,
                    'user_gestion'       => Sentinel::getUser()->id,
                    'req_id'             => $req_id,
                    'empresa'            => '',
                    'descripcion'        => 'CONSULTA DE SEGURIDAD',
                ]);

                /**
                 * Aumentar veces consultadas el candidato
                 */
                // $query = ConsultaSeguridad::where('user_id', $user_id)->where('req_id', $req_id)->first();

                $cont = $query_buscar->contador;

                $query_buscar->user_gestion = Sentinel::getUser()->id;
                $query_buscar->factor_seguridad = $factor_seguridad;
                $query_buscar->contador = $cont + 1;
                $query_buscar->save();
            }

            $informacion_consulta = ConsultaSeguridad::where('user_id', $user_id)->where('req_id', $req_id)->first();

            $fecha_consulta = date('Y-m-d H:s');
            $solicito_consulta = $informacion_consulta->usuarioRegistro()->name;

            /**
             * PDF
             */

            $img_base64 = file_get_contents('assets/admin/imgs/base64/t3rs-new.txt');

            $view = \View::make('cv.pdf_consulta', compact('user', 'datos_basicos', 'convert', 'factor_seguridad', 'req_id', 'fecha_consulta', 'solicito_consulta', 'todas_listas', 'img_base64'))->render();
            $pdf  = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);

            // PDF
            $output = $pdf->output();

            /**
             * Guardar PDF
             */

            $nombre_archivo = empty($query_buscar) ? "PDFConsultaSeguridad-CAND-$datos_basicos->numero_id-REQ-$req_id.pdf" : "PDFConsultaSeguridad-CAND-$datos_basicos->numero_id-REQ-$req_id-$informacion_consulta->contador.pdf";

            Storage::disk('public')
                ->put("recursos_pdf_consulta/$nombre_archivo", $output);

            $informacion_consulta->pdf_consulta_file = $nombre_archivo;
            $informacion_consulta->save();

            if ($ver_resultado) {
                //Proceso
                if(empty($query_buscar)) {
                    $candidato_req = ReqCandidato::join("datos_basicos", "datos_basicos.user_id", "=", "requerimiento_cantidato.candidato_id")
                    ->join("requerimientos", "requerimientos.id", "=", "requerimiento_cantidato.requerimiento_id")
                    ->where("requerimiento_cantidato.requerimiento_id", $req_id)
                    ->where("requerimiento_cantidato.candidato_id", $user_id)
                    ->whereNotIn('requerimiento_cantidato.estado_candidato', [
                        config('conf_aplicacion.C_QUITAR'),
                        config('conf_aplicacion.C_INACTIVO')
                    ])
                    ->whereRaw('requerimiento_cantidato.id=(select max(requerimiento_cantidato.id) from requerimiento_cantidato where requerimiento_cantidato.requerimiento_id=requerimientos.id and requerimiento_cantidato.candidato_id=datos_basicos.user_id)')
                    ->select(
                        "requerimiento_cantidato.id as req_candidato_id"
                    )
                    ->orderBy("requerimiento_cantidato.id")
                    ->groupBy('datos_basicos.numero_id')
                    ->first();

                    $campos_proceso = [
                        'requerimiento_candidato_id' => $candidato_req->req_candidato_id,
                        'usuario_envio'              => $this->user->id,
                        "fecha_inicio"               => date("Y-m-d H:i:s"),
                        'proceso'                    => "CONSULTA_SEGURIDAD",
                    ];

                    $registrar_proceso = new ReclutamientoController();

                    $registrar_proceso->RegistroProceso(
                        $campos_proceso,
                        config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                        $candidato_req->req_candidato_id
                    );
                }

                //return $pdf->stream("Consulta-Seguridad-$cc-$datos_basicos->nombres-$datos_basicos->primer_apellido.pdf");
            }

            return response()->json(['url' => route("view_document_url", encrypt("recursos_pdf_consulta/"."|".$nombre_archivo))]);
        }
    }

    public function ConsultaSeguridadVista (Request $request)
    {
        return view("admin.consulta_seguridad.consulta_seguridad");
    }

    public function ConsultaVerificaView(Request $request)
    {
        //La funcionalidad es Consulta de Seguridad - Obtiene el tipo de funcionalidad y su limite.
        $ControlLimite = ControlFuncionalidad::join('tipo_funcionalidad_avanzada', 'tipo_funcionalidad_avanzada.id', '=', 'control_funcionalidad.tipo_funcionalidad')
        ->where('control_funcionalidad.tipo_funcionalidad', 1)
        ->select('control_funcionalidad.*', 'control_funcionalidad.id as id_control', 'tipo_funcionalidad_avanzada.*')
        ->first();

        //Obtiene el mes actual.
        $mes = date("n");

        //Obtiene el número de registros de acuerdo a la funcionalidad y el mes.
        $TrazabilidadConteo = TrazabilidadFuncionalidad::join('control_funcionalidad', 'control_funcionalidad.id', '=', 'trazabilidad_funcionalidades.control_id')
        ->where('control_funcionalidad.tipo_funcionalidad', 1)
        ->whereMonth('trazabilidad_funcionalidades.created_at', '=', $mes)
        ->count();

        //Compara el limte asignado con el número de registros
        if($TrazabilidadConteo == $ControlLimite->limite){
            return response()->json(["limite" => true]);
        }elseif($TrazabilidadConteo >= $ControlLimite->limite){
            return response()->json(["limite" => true]);
        }
    }

    public function QueryPersonView (Request $request)
    {
        $sitioModulo = SitioModulo::first();

        if($sitioModulo->consulta_seguridad == 'enabled') {
            $user_gestion = Sentinel::getUser()->id;

            // $cc = $request->a;
            // $type = 1;

            // $url = "AnalyzerOnLine?IdentificationType=".$type."&SearchParam=".$cc."&Token=J33TRWJI";

            // 34.227.197.159  / 107.21.69.76

            // $client = new Client([
                
            //     'base_uri' => "http://18.233.198.218:8080/api/",
                
            //     'headers' => [
            //         'Authorization' => 'J33TRWJI',
            //         'Accept'        => 'application/json'
            //     ]
            // ]);

            // $response = $client->request('GET', $url);

            // $convert =  json_decode( $response->getBody()->getContents() );
            // $convert =  json_decode( $convert, true );

            // dd($convert);

            $factor_seguridad = 0;

            $match1 = 0; $match2 = 0;
            $match3 = 0; $match4 = 0;
            $match5 = 0; $match6 = 0;
            $match7 = 0; $match8 = 0;
            $match9 = 0; $match10 = 0;

            $StringSearch = null;
            $StringGet = $convert[1]["SearchList"][0]["QueryDetail"]["MoreInfo"];

            $StringSearch = "/ANTECEDENTES PENALES/";

            if(preg_match($StringSearch, $StringGet)){

                $match1 = 250;

            }else{

                $StringSearch = "/ANTECEDENTES DISCIPLINARIOS/";

                if(preg_match($StringSearch, $StringGet)){

                    $match1 = 250;

                }else{

                    if($convert[1]["SearchList"][16]["QueryDetail"]["FoundName"] != null || $convert[1]["SearchList"][24]["QueryDetail"]["FoundName"] != null ||
                       $convert[1]["SearchList"][27]["QueryDetail"]["FoundName"] != null || $convert[1]["SearchList"][29]["QueryDetail"]["FoundName"] != null ||
                       $convert[2]["SearchList"][14]["QueryDetail"]["FoundName"] != null){

                        $match1 = 250;

                    }else{

                        $StringSearch = "/El ciudadano no presenta antecedentes/";

                        //Procuradoria Nacional PRIMERA
                        if(preg_match($StringSearch, $StringGet)){
                            $match10 = $match10 + 100;
                        }else{
                            $match10 = 0;
                        }

                        //FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO
                        if($convert[1]["SearchList"][12]["InRisk"] === false){
                            $match1 = $match1 + 100;
                        }else{
                            $match1 = 0;
                        }

                        //INTERPOL
                        if($convert[1]["SearchList"][16]["InRisk"] === false){
                            $match2 = $match2 + 100;
                        }else{
                            $match2 = 0;
                        }

                        //DESMOVILIZADOS
                        if($convert[1]["SearchList"][18]["InRisk"] === false){
                            $match3 = $match3 + 100;
                        }else{
                            $match3 = 0;
                        }

                        //CONSEJO SUPERIOR DE LA JUDICATURA
                        if($convert[1]["SearchList"][20]["InRisk"] === false){
                            $match4 = $match4 + 100;
                        }else{
                            $match4 = 0;
                        }

                        //BOLETIN PROCURADURIA
                        if($convert[1]["SearchList"][22]["InRisk"] === false){
                            $match5 = $match5 + 100;
                        }else{
                            $match5 = 0;
                        }

                        //BOLETIN PRESIDENCIA
                        if($convert[1]["SearchList"][23]["InRisk"] === false){
                            $match6 = $match6 + 100;
                        }else{
                            $match6 = 0;
                        }

                        //BOLETIN POLICIA
                        if($convert[1]["SearchList"][24]["InRisk"] === false){
                            $match7 = $match7 + 100;
                        }else{
                            $match7 = 0;
                        }

                        //BOLETIN FISCALIA
                        if($convert[1]["SearchList"][27]["InRisk"] === false){
                            $match8 = $match8 + 100;
                        }else{
                            $match8 = 0;
                        }

                        //BOLETIN DEA
                        if($convert[1]["SearchList"][29]["InRisk"] === false){
                            $match9 = $match9 + 100;
                        }else{
                            $match9 = 0;
                        }

                        /*
                        Consulta en medios
                        if($convert[1]{"SearchList"}[34]{"InRisk"} === false){
                            $match10 = $match10 + 100;
                        }else{
                            $match10 = 0;
                        }
                        */

                    }
                    
                }

            }

            $factor_seguridad = ($match1 + $match2 + $match3 + $match4 + $match5 + $match6 + $match7 + $match8 + $match9 + $match10)/10;

            $ControlLimite = ControlFuncionalidad::join('tipo_funcionalidad_avanzada', 'tipo_funcionalidad_avanzada.id', '=', 'control_funcionalidad.tipo_funcionalidad')
            ->where('control_funcionalidad.tipo_funcionalidad', 1)
            ->select('control_funcionalidad.*', 'control_funcionalidad.id as id_control', 'tipo_funcionalidad_avanzada.*')
            ->first();

            TrazabilidadFuncionalidad::create([
                'control_id'         => $ControlLimite->id_control,
                'tipo_funcionalidad' => 1,
                'user_gestion'       => Sentinel::getUser()->id,
                'req_id'             => '',
                'empresa'            => $factor_seguridad,
                'descripcion'        => 'CONSULTA DE SEGURIDAD',
            ]);

            $pdfName = "PDFConsultaSeguridad_CAND_".$request->a."_SIN_PROCESO_.pdf";

            //return view('cv.pdf_consulta', compact('user', 'datos_basicos', 'convert', 'factor_seguridad'));

            $querySaved = TrazabilidadFuncionalidad::where('user_gestion', Sentinel::getUser()->id)
            ->where('descripcion', 'CONSULTA DE SEGURIDAD')
            ->orderBy('created_at', 'DESC')
            ->first();

            $dateConsulta = $querySaved->created_at;
            $solicitoConsulta = $querySaved->usuarioRegistro()->name;

            $view = \View::make('cv.pdf_consulta', compact('convert', 'factor_seguridad','dateConsulta','solicitoConsulta'))->render();
            $pdf  = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);

            //Guardado de PDF en server
            $output = $pdf->output();

            $carpeta = 'recursos_pdf_consulta_sin_proceso/'.$pdfName;

            if($request->has("id_visita")){
                $visita=VisitaCandidato::find($request->get("id_visita"));
                $visita->consulta_sin_proceso=$carpeta;
                $visita->save();
            }

            if (file_exists($carpeta)) {                

                $numeroVeces = TrazabilidadFuncionalidad::where('user_gestion', Sentinel::getUser()->id)->count();

                $pdfName = "PDFConsultaSeguridad_CAND_".$request->a."_SIN_PROCESO_".$numeroVeces.".pdf";

                //file_put_contents('recursos_pdf_consulta_sin_proceso/'.$pdfName, $output);

            }else {
                //file_put_contents('recursos_pdf_consulta_sin_proceso/'.$pdfName, $output);
            }

            //return $pdf->stream('consulta_seguridad_consulta');
        }
    }

    //Validar factor seguridad
    public static function validarFactorConsulta($user_id, $req_id)
    {
        $configuracion = ConsultaSeguridadConfiguracion::first();
        $factorCandidato = ConsultaSeguridad::where('user_id', $user_id)->where('req_id', $req_id)->orderBy('created_at', 'DESC')->first();

        if($factorCandidato->factor_seguridad >= $configuracion->factor_alto) {
            return 'alto';
        }elseif($factorCandidato->factor_seguridad > $configuracion->factor_bajo && $factorCandidato->factor_seguridad <= $configuracion->factor_alto) {
            return 'medio';
        }elseif($factorCandidato->factor_seguridad <= $configuracion->factor_bajo) {
            return 'bajo';
        }
    }
}
