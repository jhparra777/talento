<?php

namespace App\Http\Controllers;

use App\Models\DatosBasicos;
use App\Models\ReqCandidato;
use Illuminate\Http\Request;
use App\Models\ControlFuncionalidad;
use App\Models\ConsultaListaVinculante;
use App\Traits\ConsultaSeguridadCommon;
use Illuminate\Support\Facades\Storage;
use App\Models\ConsultaSeguridadRegistro;
use App\Models\TipoFuncionalidadAvanzada;
use App\Models\TrazabilidadFuncionalidad;
use App\Models\ConsultaSeguridadConfiguracion;
use App\Http\Controllers\ReclutamientoController;

class ListaVinculanteController extends Controller
{
    use ConsultaSeguridadCommon;

    public function __construct()
    {
        parent::__construct();        
    }

    public function verificarLimite(Request $request)
    {
        $user_id = $request->b;
        $req_id = $request->c;

        $limite = ControlFuncionalidad::join('tipo_funcionalidad_avanzada', 'tipo_funcionalidad_avanzada.id', '=', 'control_funcionalidad.tipo_funcionalidad')
        ->where('tipo_funcionalidad_avanzada.descripcion', 'LISTAS VINCULANTES')
        ->select('control_funcionalidad.limite')
        ->first();

        $mes = date("n");
        $anio = date("Y");

        $consultas_realizadas = TrazabilidadFuncionalidad::join('tipo_funcionalidad_avanzada', 'tipo_funcionalidad_avanzada.id', '=', 'trazabilidad_funcionalidades.tipo_funcionalidad')
        ->where('tipo_funcionalidad_avanzada.descripcion', 'LISTAS VINCULANTES')
        ->whereMonth('trazabilidad_funcionalidades.created_at', '=', $mes)
        ->whereYear('trazabilidad_funcionalidades.created_at', '=', $anio)
        ->count();

        if($consultas_realizadas >= $limite->limite) {
            return response()->json(["limite" => true]);
        }

        $consulta_candidato = ConsultaListaVinculante::where('user_id', $user_id)
        ->where('req_id', $req_id)
        ->first();

        return response()->json(["success" => empty($consulta_candidato) ? false : true, "limite" => false]);
    }

    public function consultarDocumento(Request $request, $convert, bool $ver_resultado = false)
    {
        if ($this->estado_modulo()) {
            $user_id = $request->b;
            $req_id = $request->c;
            $user_gestion = $this->user->id;
            $cliente_id = $request->d;

            // $json_test = ConsultaSeguridadRegistro::find(1); // solo test

            // $convert =  json_decode($json_test->json, true);

            /**
             * Guardar JSON retornado
             */

            $this->guardar_registro_json($convert, $user_id, $req_id, $this->user->id);

            /**
             * Listas
             */

            $todas_listas = [];

            /**
             * Listas que se usan para calcular factor
             */

            $listas_consulta = [
                'BOLETIN POLICIA',
                'BOLETIN PROCURADURIA',
                'RAMA JUDICIAL DEL PODER PUBLICO',
                'OFAC',
                'ONU_RESOLUCION_2023',
                'ONU_RESOLUCION_1988',
                'ONU_RESOLUCION_1975',
                'ONU_RESOLUCION_1973',
                'ONU_RESOLUCION_1970',
                'ONU_RESOLUCION_1929',
                'FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO',
                'NACIONES UNIDAS',
                'MOST WANTED FBI',
                'INTERPOL',
                'DESMOVILIZADOS'
            ];

            /**
             * Listas del PDF
             */

            $listas_consulta_general = [
                'BOLETIN POLICIA',
                'BOLETIN PROCURADURIA',
                'RAMA JUDICIAL DEL PODER PUBLICO',
                'OFAC',
                'ONU_RESOLUCION_2023',
                'ONU_RESOLUCION_1988',
                'ONU_RESOLUCION_1975',
                'ONU_RESOLUCION_1973',
                'ONU_RESOLUCION_1970',
                'ONU_RESOLUCION_1929',
                'FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO',
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
                        'BOLETIN POLICIA',
                        'FOREIGN_TERRORIST_ORGANIZATIONS_EEUU_FTO',
                        'NACIONES UNIDAS',
                        'MOST WANTED FBI',
                        'INTERPOL'
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
                $factor_seguridad = array_sum($listas_puntaje) / 16;
            }else {
                $factor_seguridad = array_sum($listas_puntaje);
            }

            $consulta_anterior = ConsultaListaVinculante::where('user_id', $user_id)->where('req_id', $req_id)->first();

            $tipo_funcionalidad = TipoFuncionalidadAvanzada::join('control_funcionalidad', 'control_funcionalidad.tipo_funcionalidad', '=', 'tipo_funcionalidad_avanzada.id')
            ->where('descripcion', 'LISTAS VINCULANTES')
            ->select('tipo_funcionalidad_avanzada.id as tipo_funcionalidad', 'control_funcionalidad.id as control_id')
            ->first();

            if (empty($consulta_anterior)) {
                ConsultaListaVinculante::create([
                    'user_id'           => $user_id,
                    'user_gestion'      => $this->user->id,
                    'req_id'            => $req_id,
                    'cliente_id'        => $cliente_id,
                    'factor_seguridad'  => $factor_seguridad,
                    'contador'          => 1,
                ]);

                TrazabilidadFuncionalidad::create([
                    'control_id'         => $tipo_funcionalidad->control_id,
                    'tipo_funcionalidad' => $tipo_funcionalidad->tipo_funcionalidad,
                    'user_gestion'       => $this->user->id,
                    'req_id'             => $req_id,
                    'empresa'            => '',
                    'descripcion'        => 'LISTAS VINCULANTES',
                ]);
            }else {
                TrazabilidadFuncionalidad::create([
                    'control_id'         => $tipo_funcionalidad->control_id,
                    'tipo_funcionalidad' => $tipo_funcionalidad->tipo_funcionalidad,
                    'user_gestion'       => $this->user->id,
                    'req_id'             => $req_id,
                    'empresa'            => '',
                    'descripcion'        => 'LISTAS VINCULANTES',
                ]);

                /**
                 * Aumentar veces consultadas el candidato
                 */

                $cont = $consulta_anterior->contador;

                $consulta_anterior->user_gestion = $this->user->id;
                $consulta_anterior->factor_seguridad = $factor_seguridad;
                $consulta_anterior->contador = $cont + 1;
                $consulta_anterior->save();
            }

            $informacion_consulta = ConsultaListaVinculante::where('user_id', $user_id)->where('req_id', $req_id)->first();

            $fecha_consulta = date('Y-m-d H:s');
            $solicito_consulta = $informacion_consulta->usuarioRegistro()->name;

            /**
             * PDF
             */

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

            $img_base64 = file_get_contents('assets/admin/imgs/base64/t3rs-new.txt');

            $view = \View::make('admin.consulta_seguridad.pdf.pdf-listas-vinculantes', compact('user', 'datos_basicos', 'convert', 'factor_seguridad', 'req_id', 'fecha_consulta', 'solicito_consulta', 'todas_listas', 'img_base64'))->render();
            $pdf  = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);

            // PDF
            $output = $pdf->output();
            
            /**
             * Guardar PDF
             */

            $nombre_archivo = empty($consulta_anterior) ? "lista-vinculante-$datos_basicos->numero_id-req-$req_id.pdf" : "lista-vinculante-$datos_basicos->numero_id-req-$req_id-$informacion_consulta->contador.pdf";

            Storage::disk('public')
                ->put("recursos_listas_vinculantes/$nombre_archivo", $output);

            $informacion_consulta->pdf_consulta_file = $nombre_archivo;
            $informacion_consulta->save();

            if ($ver_resultado) {
                //Proceso
                $this->proceso_gestion($consulta_anterior, $req_id, $user_id);

                // return $pdf->stream("listas-vinculantes-$datos_basicos->numero_id-$datos_basicos->nombres-$datos_basicos->primer_apellido.pdf");
            }

            return response()->json(['url' => route("view_document_url", encrypt("recursos_listas_vinculantes/"."|".$nombre_archivo))]);
        }
    }

    public function proceso_gestion($consulta_anterior, $req_id, $user_id)
    {
        if(empty($consulta_anterior)) {
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
                'proceso'                    => "LISTAS_VINCULANTES",
            ];

            $registrar_proceso = new ReclutamientoController();

            $registrar_proceso->RegistroProceso(
                $campos_proceso,
                config('conf_aplicacion.C_EN_PROCESO_SELECCION'),
                $candidato_req->req_candidato_id
            );
        }
    }

    //Validar factor seguridad
    public static function validarFactorConsulta($user_id, $req_id)
    {
        $configuracion = ConsultaSeguridadConfiguracion::first();
        $factorCandidato = ConsultaListaVinculante::where('user_id', $user_id)->where('req_id', $req_id)->orderBy('created_at', 'DESC')->first();

        if($factorCandidato->factor_seguridad >= $configuracion->factor_alto) {
            return 'alto';
        }elseif($factorCandidato->factor_seguridad > $configuracion->factor_bajo && $factorCandidato->factor_seguridad <= $configuracion->factor_alto) {
            return 'medio';
        }elseif($factorCandidato->factor_seguridad <= $configuracion->factor_bajo) {
            return 'bajo';
        }
    }
}
