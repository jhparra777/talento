<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FichaNuevaRequest;
use App\Models\AspiracionSalarial;
use App\Models\AuxiliarFicha;
use App\Models\CargoEspecifico;
use App\Models\Clientes;
use App\Models\Escolaridad;
use App\Models\Ficha;
use App\Models\Genero;
use App\Models\Requerimiento;
use App\Models\TipoContrato;
use App\Models\TipoDocumento;
use App\Models\TipoJornada;
use App\Models\TipoPrueba;
use Illuminate\Http\Request;

class FichasController extends Controller
{

    public function index(Request $request)
    {

        $fichas = Ficha::join("clientes", "clientes.id", "=", "ficha.cliente_id")
            ->join("cargos_especificos", "ficha.cargo_cliente", "=", "cargos_especificos.id")
            ->join("generos", "ficha.genero", "=", "generos.id")
            ->join("escolaridades", "escolaridades.id", "=", "ficha.escolaridad")
            ->where("ficha.active", "=", 1)
            ->where(function ($query) use ($request) {
                if ($request->get('cliente_id') != "") {
                    $query->where("ficha.cliente_id", "=", $request->get('cliente_id'));
                }
                if ($request->get('active') != "") {
                    $query->where("ficha.active", "=", $request->get('active'));
                }
            })
            ->select("ficha.id", "clientes.nombre", "cargos_especificos.descripcion as cargo_especifico", "ficha.criticidad_cargo", "generos.descripcion as descripcion_genero", "escolaridades.descripcion as descripcion_escolaridad", "ficha.active")
            ->paginate(10);
        //dd($fichas);
        $clientes = ["" => "- Seleccionar -"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();

        return view('admin.fichas.index', compact("fichas", "clientes"));
    }
    public function exportarFichaPdf(Request $request, $id)
    {

        //Recibir en id del requerimiento para sacar la relacion con la tabla ficha
        $requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->where("requerimientos.id", $id)
            ->select("negocio.cliente_id", "requerimientos.cargo_especifico_id")
            ->first();
        //dd($requerimiento);

        //Del resultado de la contulta $requerimiento salen las variables para hallar la ficha
        $ficha_requerimiento = Requerimiento::join("negocio", "negocio.id", "=", "requerimientos.negocio_id")
            ->join("ficha", function ($join) {
                $join->on("negocio.cliente_id", "=", "ficha.cliente_id")
                    ->on("requerimientos.cargo_especifico_id", "=", "ficha.cargo_cliente");
            })
            ->where("ficha.cliente_id", $requerimiento->cliente_id)
            ->where("ficha.cargo_cliente", $requerimiento->cargo_especifico_id)
            ->where("requerimientos.id", $id)
            ->select("ficha.id")
            ->first();
        //dd($ficha_requerimiento);

        //Validar si el requerimiento no tiene ficha
        if ($ficha_requerimiento !== null) {
            //Del resultado de $ficha_requerimiento sale el id de la ficha que se necesita para la consulta
            $ficha = Ficha::where("active", "=", 1)
                ->where("id", $ficha_requerimiento->id)
                ->first();
            //dd($ficha);

            $cliente = Clientes::find($ficha->cliente_id);
            //dd($cliente);

            $cargo_cliente    = CargoEspecifico::find($ficha->cargo_cliente);
            $tiempo_respuesta = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
                ->whereIn("identificador_entidad", ['t15', 't610', 'tmas10'])
                ->select("identificador_entidad", "valor", "id_entidad")
                ->get();

            $arr_respuesta = [];
            foreach ($tiempo_respuesta as $t) {
                $arr_respuesta[$t->identificador_entidad] = $t->valor;
            }
            $ficha->tiempo_respuesta = $arr_respuesta;
            //Procesos
            $procesos = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
                ->where("identificador_entidad", "=", 'PROCESOS_SELECCION')
                ->select("valor", "id_entidad")
                ->get();
            //dd($procesos);
            $arr_procesos = [];
            foreach ($procesos as $proceso) {
                if ($proceso->valor != "" && strlen($proceso->valor) > 0) {
                    $arr_procesos[$proceso->valor] = 'x';
                } else {
                    $arr_procesos[$proceso->valor] = "";
                }
            }
            $ficha->procesos = $arr_procesos;
            //dd($ficha->procesos);
            //Documentos validar
            $docs_validar = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
                ->where("identificador_entidad", "=", 'DOCUMENTOS_VALIDAR')
                ->select("valor", "id_entidad")
                ->get();
            //dd($docs_validar);
            $arr_validar = [];
            foreach ($docs_validar as $docs) {
                $arr_validar[] = $docs->valor;
            }
            $ficha->docs = $arr_validar;
            //dd($ficha->docs);
            $documentos = TipoDocumento::where("tipos_documentos.active", "=", 1)
                ->select("tipos_documentos.id", "tipos_documentos.descripcion")
                ->get();
            //Documentos adicionales
            $docs_adicionales = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
                ->where("identificador_entidad", "=", "DOCUMENTOS_ADICIONALES")
                ->select("valor", "id_entidad")
                ->get();

            $pruebas_psico = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
                ->where("identificador_entidad", "=", "PRUEBAS_PSICO")
                ->pluck("id_entidad")
                ->toArray();

            $pruebas_ficha = TipoPrueba::whereIn("id", $pruebas_psico)
                ->where("estado",1)
                ->pluck("descripcion")
                ->toArray();
            //dd($pruebas_ficha);

            $view = \View::make('admin.fichas.pdf_ficha', compact(
                "cliente",
                "ficha",
                "cargo_cliente",
                "documentos",
                "docs_adicionales",
                "pruebas_ficha"
            )
            )->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('Perfil_Ficha');

        } else {
            //agregar variables y ponerlar en el pdf_ficha.blade.php
            $view = \View::make('admin.fichas.pdf_no_ficha')->render();
            $pdf  = \App::make('dompdf.wrapper');
            $pdf->loadHTML($view);
            return $pdf->stream('Perfil_Ficha');
        }
    }

    public function exportarFichaPdfp(Request $request, $id)
    {

        $ficha = Ficha::where("active", "=", 1)
            ->where("id", $id)
            ->first();
        //dd($id);
        $cliente = Clientes::find($ficha->cliente_id);

        $cargo_cliente    = CargoEspecifico::find($ficha->cargo_cliente);
        $tiempo_respuesta = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
            ->whereIn("identificador_entidad", ['t15', 't610', 'tmas10'])
            ->select("identificador_entidad", "valor", "id_entidad")
            ->get();

        $arr_respuesta = [];
        foreach ($tiempo_respuesta as $t) {
            $arr_respuesta[$t->identificador_entidad] = $t->valor;
        }
        $ficha->tiempo_respuesta = $arr_respuesta;
        //Procesos
        $procesos = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
            ->where("identificador_entidad", "=", 'PROCESOS_SELECCION')
            ->select("valor", "id_entidad")
            ->get();
        //dd($procesos);
        $arr_procesos = [];
        foreach ($procesos as $proceso) {
            if ($proceso->valor != "" && strlen($proceso->valor) > 0) {
                $arr_procesos[$proceso->valor] = 'x';
            } else {
                $arr_procesos[$proceso->valor] = "";
            }
        }
        $ficha->procesos = $arr_procesos;
        //dd($ficha->procesos);
        //Documentos validar
        $docs_validar = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
            ->where("identificador_entidad", "=", 'DOCUMENTOS_VALIDAR')
            ->select("valor", "id_entidad")
            ->get();
        //dd($docs_validar);
        $arr_validar = [];
        foreach ($docs_validar as $docs) {
            $arr_validar[] = $docs->valor;
        }
        $ficha->docs = $arr_validar;
        //dd($ficha->docs);
        $documentos = TipoDocumento::where("tipos_documentos.active", "=", 1)
            ->select("tipos_documentos.id", "tipos_documentos.descripcion")
            ->get();
        //Documentos adicionales
        $docs_adicionales = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
            ->where("identificador_entidad", "=", "DOCUMENTOS_ADICIONALES")
            ->select("valor", "id_entidad")
            ->get();

        $pruebas_psico = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
            ->where("identificador_entidad", "=", "PRUEBAS_PSICO")
            ->pluck("id_entidad")
            ->toArray();

        $pruebas_ficha = TipoPrueba::whereIn("id", $pruebas_psico)
            ->where("estado",1)
            ->pluck("descripcion")
            ->toArray();
        //dd($pruebas_ficha);

        $view = \View::make('admin.fichas.pdf_ficha', compact(
            "cliente",
            "ficha",
            "cargo_cliente",
            "documentos",
            "docs_adicionales",
            "pruebas_ficha"
        )
        )->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream('Perfil_Ficha');
    }

    public function editarFicha(Request $request, $id)
    {
        $ficha = Ficha::find($id);

        $datos_clientes = Clientes::find($ficha->cliente_id);
        $clientes       = ["" => "Seleccionar"] + Clientes::pluck("clientes.nombre", "clientes.id")->toArray();
        $cargo_cliente  = ["" => "- Seleccionar -"] + CargoEspecifico::pluck("descripcion", "id")->toArray();
        $documentos     = TipoDocumento::where("tipos_documentos.active", "=", 1)
            ->select("tipos_documentos.id", "tipos_documentos.descripcion")
            ->get();
        $genero        = ["" => "Seleccionar"] + Genero::pluck("generos.descripcion", "generos.id")->toArray();
        $escolaridades = ["" => "- Seleccionar -"];
        $escolaridades += Escolaridad::where("escolaridades.active", "=", 1)
            ->pluck("escolaridades.descripcion", "escolaridades.id")
            ->toArray();
        $experiencia = [
            ""   => "- Seleccionar -",
            "no" => "NO REQUIERE",
            "1"  => "1 - 6 MESES",
            "2"  => "6 - 12 MESES",
            "3"  => "1 - 2 AÑOS",
            "4"  => "MAS DE 2 AÑOS",
        ];
        //Pruebas
        $pruebas = ["" => "- Seleccionar -"] + TipoPrueba::pluck("tipos_pruebas.descripcion", "tipos_pruebas.id")->where("estado",1)->toArray();
        //dd($pruebas);
        $jornadas        = ["" => "- Seleccionar -"] + TipoJornada::pluck("tipos_jornadas.descripcion", "tipos_jornadas.id")->toArray();
        $aspiracion      = ["" => "- Seleccionar -"] + AspiracionSalarial::pluck("aspiracion_salarial.descripcion", "aspiracion_salarial.id")->toArray();
        $tipos_contratos = ["" => "- Seleccionar -"] + TipoContrato::pluck("tipos_contratos.descripcion", "tipos_contratos.id")->toArray();
        $tallas          = [
            ""    => '- Seleccionar -',
            "XS"  => "XS",
            "S"   => "S",
            "M"   => "M",
            "L"   => "L",
            "XL"  => "XL",
            "XXL" => "XXL",
        ];
        $tallas_pantalon = ["" => "- Seleccionar -",
            'Mujeres'              => [
                '6'  => '6',
                '8'  => '8',
                '10' => '10',
                '12' => '12',
                '14' => '14',
                '16' => '16',
                '18' => '18',
            ],
            'Hombres'              => [
                '28' => '28',
                '30' => '30',
                '32' => '32',
                '34' => '34',
                '36' => '36',
                '38' => '38',
                '40' => '40',
            ],
        ];

        $calzado = ["" => "- Seleccionar -"];
        for ($i = 32; $i <= 45; $i++) {
            $calzado += [$i => $i];
        }
        //Tabla auxiliar
        $procesos = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
            ->where("identificador_entidad", "=", 'PROCESOS_SELECCION')
            ->select("valor", "id_entidad")
            ->get();
        //dd($procesos);
        $arr_procesos = [];
        foreach ($procesos as $proceso) {
            $arr_procesos[] = $proceso->valor;
        }
        $ficha->procesos = $arr_procesos;
        //Documentos validar
        $docs_validar = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
            ->where("identificador_entidad", "=", 'DOCUMENTOS_VALIDAR')
            ->select("valor", "id_entidad")
            ->get();
        //dd($docs_validar);
        $arr_validar = [];
        foreach ($docs_validar as $docs) {
            $arr_validar[] = $docs->valor;
        }
        $ficha->docs = $arr_validar;
        //Tiempo Respuesta
        $tiempo_respuesta = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
            ->whereIn("identificador_entidad", ['t15', 't610', 'tmas10'])
            ->select("identificador_entidad", "valor", "id_entidad")
            ->get();

        $arr_respuesta = [];
        foreach ($tiempo_respuesta as $t) {
            $arr_respuesta[$t->identificador_entidad] = $t->valor;
        }
        $ficha->tiempo_respuesta = $arr_respuesta;
        //xattr_get(filename, name)dd($ficha);
        //Docs adicionales
        $docs_adicionales = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
            ->where("identificador_entidad", "=", "DOCUMENTOS_ADICIONALES")
            ->select("valor", "id_entidad")
            ->get();

        $arr_docs_adicionales = [];
        foreach ($docs_adicionales as $d) {
            $arr_docs_adicionales[] = $d->valor;
        }
        $ficha->doc_adicio = $arr_docs_adicionales;
        //Pruebas psicotecnicas
        $pruebas_psico = AuxiliarFicha::where("ficha_id", "=", $ficha->id)
            ->where("identificador_entidad", "=", "PRUEBAS_PSICO")
            ->select("valor", "id_entidad")
            ->get();

        $arr_pruebas_psico = [];
        $i                 = 0;
        foreach ($pruebas_psico as $p) {
            $arr_pruebas_psico[] = $p->valor;
            $i++;
        }
        $ficha->pruebas_psicotecnicas = $arr_pruebas_psico;
        //dd($ficha);
        return view('admin.fichas.editar_ficha', compact("ficha", "clientes", "cargo_cliente", "documentos", "genero", "escolaridades", "experiencia", "pruebas", "jornadas", "aspiracion", "tipos_contratos", "tallas", "tallas_pantalon", "calzado", "datos_clientes"));
    }
    public function guardarFichaEditar(Request $request, FichaNuevaRequest $valida)
    {
        $procesos              = $request->procesos;
        $docs                  = $request->docs;
        $doc_adicionales       = $request->docs_adicio;
        $pruebas_psicotecnicas = $request->pruebas_psicotecnicas;
        $tiempo_respuesta      = $request->tiempo_respuesta;
        //dd($doc_adicionales);
        $ficha = Ficha::find($request->get('id'));
        $ficha->fill($request->all() + ['user_id' => $this->user->id]);
        $ficha->save();

        //Borramos los datos actuales de la tabla auxiliar
        $tabla_auxiliar_actual = AuxiliarFicha::where("ficha_id", "=", $ficha->id)->delete();
        //Ahora la tabla auxiliar
        // Tiempos Respuestas
        if (is_array($tiempo_respuesta)) {
            foreach ($tiempo_respuesta as $key => $value) {
                $auxiliar_ficha                        = new AuxiliarFicha();
                $auxiliar_ficha->ficha_id              = $ficha->id;
                $auxiliar_ficha->identificador_entidad = $key;
                $auxiliar_ficha->valor                 = $value;
                $auxiliar_ficha->id_entidad            = 0;
                $auxiliar_ficha->save();
            }
        }
        //Procesos validar
        if (is_array($procesos)) {
            foreach ($procesos as $proceso) {
                $auxiliar_ficha                        = new AuxiliarFicha();
                $auxiliar_ficha->ficha_id              = $ficha->id;
                $auxiliar_ficha->identificador_entidad = 'PROCESOS_SELECCION';
                $auxiliar_ficha->valor                 = $proceso;
                $auxiliar_ficha->id_entidad            = 0;
                $auxiliar_ficha->save();
            }
        }
        // Documentos a validar
        if (is_array($docs)) {
            foreach ($docs as $doc) {
                $auxiliar_ficha                        = new AuxiliarFicha();
                $auxiliar_ficha->ficha_id              = $ficha->id;
                $auxiliar_ficha->identificador_entidad = 'DOCUMENTOS_VALIDAR';
                $auxiliar_ficha->valor                 = $doc;
                $auxiliar_ficha->id_entidad            = $doc;
                $auxiliar_ficha->save();
            }
        }
        //Documentos adicionales a validar
        if (is_array($doc_adicionales)) {
            foreach ($doc_adicionales as $doc_adicional) {
                $auxiliar_ficha = new AuxiliarFicha();
                if ($doc_adicional != "" and strlen($doc_adicional) > 0) {
                    $auxiliar_ficha->ficha_id              = $ficha->id;
                    $auxiliar_ficha->identificador_entidad = 'DOCUMENTOS_ADICIONALES';
                    $auxiliar_ficha->valor                 = $doc_adicional;
                    $auxiliar_ficha->id_entidad            = 0;
                    $auxiliar_ficha->save();
                }
            }
        }
        // Pruebas psicotecnicas
        if (is_array($pruebas_psicotecnicas)) {
            foreach ($pruebas_psicotecnicas as $prueba) {
                $auxiliar_ficha = new AuxiliarFicha();
                if ($prueba != "") {
                    $auxiliar_ficha->ficha_id              = $ficha->id;
                    $auxiliar_ficha->identificador_entidad = 'PRUEBAS_PSICO';
                    $auxiliar_ficha->valor                 = $prueba;
                    $auxiliar_ficha->id_entidad            = $prueba;
                    $auxiliar_ficha->save();
                }
            }
        }
        return redirect()->route('admin.listar_fichas')->with("mensaje_success", "Ficha modificada con éxito.");
    }
    public function nuevaFicha(Request $request)
    {

        $clientes       = ["" => "Seleccionar"] + Clientes::orderBy("nombre", "ASC")->pluck("clientes.nombre", "clientes.id")->toArray();
        $cargo_cliente  = ["" => "Seleccionar"];
        $cargo_generico = ["" => "Seleccionar"];
        //El listado de documentos
        $lista_documentos = TipoDocumento::where("tipos_documentos.active", "=", 1)
            ->select("tipos_documentos.id", "tipos_documentos.descripcion")
            ->get();
        $escolaridades = ["" => "- Seleccionar -"];
        $escolaridades += Escolaridad::where("escolaridades.active", "=", 1)
            ->pluck("escolaridades.descripcion", "escolaridades.id")
            ->toArray();
        //$genero = [""=>'- Seleccionar -',"MAS"=>"MASCULINO","FEM"=>"FEMENINO","ND"=>"INDIFERENTE"];
        $genero      = ["" => '- Seleccionar -'] + Genero::where('active', '=', 1)->pluck("descripcion", "id")->toArray();
        $experiencia = [
            ""   => "- Seleccionar -",
            "no" => "NO REQUIERE",
            "1"  => "1 - 6 MESES",
            "2"  => "6 - 12 MESES",
            "3"  => "1 - 2 AÑOS",
            "4"  => "MAS DE 2 AÑOS",
        ];

        //Pruebas
        $pruebas = ["" => "- Seleccionar -"] + TipoPrueba::pluck("tipos_pruebas.descripcion", "tipos_pruebas.id")->where("estado",1)->toArray();
        //dd($pruebas);
        $jornadas        = ["" => "- Seleccionar -"] + TipoJornada::pluck("tipos_jornadas.descripcion", "tipos_jornadas.id")->toArray();
        $aspiracion      = ["" => "- Seleccionar -"] + AspiracionSalarial::pluck("aspiracion_salarial.descripcion", "aspiracion_salarial.id")->toArray();
        $tipos_contratos = ["" => "- Seleccionar -"] + TipoContrato::pluck("tipos_contratos.descripcion", "tipos_contratos.id")->toArray();
        $tallas          = [
            ""    => '- Seleccionar -',
            "XS"  => "XS",
            "S"   => "S",
            "M"   => "M",
            "L"   => "L",
            "XL"  => "XL",
            "XXL" => "XXL",
        ];
        $tallas_pantalon = ["" => "- Seleccionar -",
            'Mujeres'              => [
                '6'  => '6',
                '8'  => '8',
                '10' => '10',
                '12' => '12',
                '14' => '14',
                '16' => '16',
                '18' => '18',
            ],
            'Hombres'              => [
                '28' => '28',
                '30' => '30',
                '32' => '32',
                '34' => '34',
                '36' => '36',
                '38' => '38',
                '40' => '40',
            ],
        ];

        $calzado = ["" => "- Seleccionar -"];
        for ($i = 32; $i <= 45; $i++) {
            $calzado += [$i => $i];
        }
        return view('admin.fichas.nueva_ficha')->with([
            'clientes'        => $clientes,
            'cargo_cliente'   => $cargo_cliente,
            'cargo_generico'  => $cargo_generico,
            'documentos'      => $lista_documentos,
            'escolaridades'   => $escolaridades,
            'genero'          => $genero,
            'experiencia'     => $experiencia,
            'pruebas'         => $pruebas,
            'jornadas'        => $jornadas,
            'aspiracion'      => $aspiracion,
            'tipos_contratos' => $tipos_contratos,
            'tallas'          => $tallas,
            'tallas_pantalon' => $tallas_pantalon,
            'calzado'         => $calzado,
        ]);
    }

    public function guardarFicha(Request $request, FichaNuevaRequest $valida)
    {

        $procesos              = $request->procesos;
        $docs                  = $request->docs;
        $doc_adicionales       = $request->docs_adicio;
        $pruebas_psicotecnicas = $request->pruebas_psicotecnicas;
        $tiempo_respuesta      = $request->tiempo_respuesta;
        //dd($doc_adicionales);
        $ficha = new Ficha();
        $ficha->fill($request->all() + ['user_id' => $this->user->id]);
        $ficha->save();
        //Ahora la tabla auxiliar
        // Tiempos Respuestas
        if (is_array($tiempo_respuesta)) {
            foreach ($tiempo_respuesta as $key => $value) {
                $auxiliar_ficha                        = new AuxiliarFicha();
                $auxiliar_ficha->ficha_id              = $ficha->id;
                $auxiliar_ficha->identificador_entidad = $key;
                $auxiliar_ficha->valor                 = $value;
                $auxiliar_ficha->id_entidad            = 0;
                $auxiliar_ficha->save();
            }
        }
        //Procesos validar
        if (is_array($procesos)) {
            foreach ($procesos as $proceso) {
                $auxiliar_ficha                        = new AuxiliarFicha();
                $auxiliar_ficha->ficha_id              = $ficha->id;
                $auxiliar_ficha->identificador_entidad = 'PROCESOS_SELECCION';
                $auxiliar_ficha->valor                 = $proceso;
                $auxiliar_ficha->id_entidad            = 0;
                $auxiliar_ficha->save();
            }
        }
        // Documentos a validar
        if (is_array($docs)) {
            foreach ($docs as $doc) {
                $auxiliar_ficha                        = new AuxiliarFicha();
                $auxiliar_ficha->ficha_id              = $ficha->id;
                $auxiliar_ficha->identificador_entidad = 'DOCUMENTOS_VALIDAR';
                $auxiliar_ficha->valor                 = $doc;
                $auxiliar_ficha->id_entidad            = $doc;
                $auxiliar_ficha->save();
            }
        }
        //Documentos adicionales a validar
        if (is_array($doc_adicionales)) {
            foreach ($doc_adicionales as $doc_adicional) {
                $auxiliar_ficha = new AuxiliarFicha();
                if ($doc_adicional != "" and strlen($doc_adicional) > 0) {
                    $auxiliar_ficha->ficha_id              = $ficha->id;
                    $auxiliar_ficha->identificador_entidad = 'DOCUMENTOS_ADICIONALES';
                    $auxiliar_ficha->valor                 = $doc_adicional;
                    $auxiliar_ficha->id_entidad            = 0;
                    $auxiliar_ficha->save();
                }
            }
        }
        // Pruebas psicotecnicas
        if (is_array($pruebas_psicotecnicas)) {
            foreach ($pruebas_psicotecnicas as $prueba) {
                $auxiliar_ficha = new AuxiliarFicha();
                if ($prueba != "") {
                    $auxiliar_ficha->ficha_id              = $ficha->id;
                    $auxiliar_ficha->identificador_entidad = 'PRUEBAS_PSICO';
                    $auxiliar_ficha->valor                 = $prueba;
                    $auxiliar_ficha->id_entidad            = $prueba;
                    $auxiliar_ficha->save();
                }
            }
        }
        return redirect()->route('admin.listar_fichas')->with("mensaje_success", "Ficha creada con éxito.");
    }

    public function getInfoCliente(Request $request)
    {

        $id_cliente         = Clientes::find($request->get('cliente_id'));
        $cargos_especificos = ["" => "Seleccionar"] + CargoEspecifico::where('clt_codigo', $id_cliente->cliente_id)->pluck("cargos_especificos.descripcion", "cargos_especificos.id")->toArray();
        $cargo_generico     = CargoEspecifico::
            select("cargo_generico_id")->
            where("clt_codigo", $id_cliente->cliente_id)->first();

        $html       = \Form::select('cargo_cliente', $cargos_especificos, null, ["class" => "form-control", "id" => "cargo_cliente"]);
        $cliente_id = $request->get('cliente_id');
        $cliente    = Clientes::find($cliente_id)->toArray();
        return response()->json(['clientes' => $cliente, "html" => $html, "cargo" => $cargo_generico]);
    }

    public function getInfoCargoGenerico(Request $request)
    {
        $cargo_cliente               = $request->get('cargo_cliente');
        $cargo_especifico            = CargoEspecifico::find($cargo_cliente);
        $obj_cargo_generico          = $cargo_especifico->tipoCargoGenerico();
        $cargo_generico_seleccionado = [$obj_cargo_generico->id => $obj_cargo_generico->descripcion];
        $html                        = \Form::select('cargo_generico', $cargo_generico_seleccionado, $obj_cargo_generico->id, ["class" => "form-control", "id" => "cargo_generico"]);
        return response()->json($html);
    }

}
