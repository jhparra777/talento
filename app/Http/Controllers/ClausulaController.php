<?php

namespace App\Http\Controllers;

use App\Models\Sitio;

use App\Http\Requests;
use App\Models\Clientes;
use App\Models\Auditoria;
use App\Models\SitioModulo;
use App\Models\DatosBasicos;
use Illuminate\Http\Request;
use App\Models\CargoEspecifico;
use App\Models\ClausulaValorCargo;
use App\Models\DocumentoAdicional;
use App\Http\Controllers\Controller;
use App\Models\CargoDocumentoAdicional;
use Illuminate\Support\Facades\Storage;
use App\Models\ClausulaValorRequerimiento;

class ClausulaController extends Controller
{
    private $search = [
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
        '{valor_variable}',
        '{empresa_contrata}',
        '{salario_asignado}'
    ];

    private $meses = [
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

    public function index(Request $request)
    {
        $lista_cargos = DocumentoAdicional::where('documentos_adicionales_contrato.creada', 1)
        ->where(function ($sql) use ($request) {
            if($request->nombre_clausula != ""){
                $sql->where("documentos_adicionales_contrato.descripcion", "LIKE", "%".$request->nombre_clausula."%");
            }
        })
        ->select(
            'documentos_adicionales_contrato.descripcion as nombre_clausula',
            'documentos_adicionales_contrato.id as adicional_id',
            'documentos_adicionales_contrato.active as estado_clausula'
        )
        ->orderBy('documentos_adicionales_contrato.descripcion', 'ASC')
        ->paginate(10);

        return view('admin.clausulas.index', compact('lista_cargos', 'clientes'));
    }

    public function create(Request $request)
    {
        $sitio_modulo = SitioModulo::first();

        return view('admin.clausulas.crear', compact('sitio_modulo'));
    }

    public function save(Request $request)
    {
        $nuevo_documento_adicional = new DocumentoAdicional();

        $nuevo_documento_adicional->fill([
            "descripcion" => $request->nombre_clausula,
            "contenido_clausula" => $request->contenido_clausula,
            "creada" => 1,
            "opcion_firma" => $request->opcion_firma ? $request->opcion_firma : 'firma_c',
            "gestion_id" => $this->user->id,
            "active" => $request->estado_clausula
        ]);
        $nuevo_documento_adicional->save();

        $nuevo_cuerpo = '';
        $adicional_id = $nuevo_documento_adicional->id;

        return response()->json([
            "success" => true,
            "nuevo_cuerpo" => $nuevo_cuerpo,
            "adicional_id" => $adicional_id
        ]);
    }

    public function edit($adicional_id)
    {
        $clausula_informacion = DocumentoAdicional::where('documentos_adicionales_contrato.creada', 1)
        ->where('documentos_adicionales_contrato.id', $adicional_id)
        ->select(
            'documentos_adicionales_contrato.id as adicional_id',
            'documentos_adicionales_contrato.descripcion as nombre_clausula',
            'documentos_adicionales_contrato.contenido_clausula as contenido_clausula',
            'documentos_adicionales_contrato.opcion_firma',
            'documentos_adicionales_contrato.active as estado_clausula'
        )
        ->first();

        $sitio_modulo = SitioModulo::first();

        return view('admin.clausulas.editar', compact('clausula_informacion', 'clientes', 'cargos', 'clausulas_asociadas', 'sitio_modulo'));
    }

    public function update(Request $request)
    {
        $nuevo_documento_adicional = DocumentoAdicional::where('id', $request->adicional_id)->first();

        $nuevo_documento_adicional->descripcion = $request->nombre_clausula;
        $nuevo_documento_adicional->contenido_clausula = $request->contenido_clausula;
        $nuevo_documento_adicional->opcion_firma = $request->opcion_firma ? $request->opcion_firma : 'firma_c';
        $nuevo_documento_adicional->active = $request->estado_clausula;
        $nuevo_documento_adicional->save();

        $nuevo_cuerpo = '';

        return response()->json([
            "success" => true,
            "nuevo_cuerpo" => $nuevo_cuerpo
        ]);
    }

    public function asociar_view($adicional_id)
    {
        $clientes = ["" => "Seleccionar"] + Clientes::orderBy("clientes.nombre", "ASC")->pluck("clientes.nombre", "clientes.id")->toArray();

        $clausulas_asociadas = DocumentoAdicional::join("cargos_documentos_adicionales", "cargos_documentos_adicionales.adicional_id", "=", "documentos_adicionales_contrato.id")
        ->join("cargos_especificos", "cargos_especificos.id", "=", "cargos_documentos_adicionales.cargo_id")
        ->join("clientes", "clientes.id", "=", "cargos_especificos.clt_codigo")
        ->where("documentos_adicionales_contrato.creada", 1)
        ->where("documentos_adicionales_contrato.id", $adicional_id)
        ->select(
            "clientes.nombre as nombre_cliente",
            "cargos_especificos.descripcion as nombre_cargo",
            "cargos_documentos_adicionales.active as estado_clausula",
            "cargos_documentos_adicionales.id as cargo_adicional_id"
        )
        ->get();

        $nombre_clausula = DocumentoAdicional::find($adicional_id);

        return view('admin.clausulas.asociar', compact('clientes', 'clausulas_asociadas', 'adicional_id', 'nombre_clausula'));
    }

    public function asociar(Request $request)
    {
        $cargos_a_asociar = $request->cargo_especifico_asociar;

        foreach ($cargos_a_asociar as $cargo) {
            $cargos_clausulas_asociadas = CargoDocumentoAdicional::where('cargo_id', $cargo)
            ->where('adicional_id', $request->adicional_id)
            ->first();

            if(count($cargos_clausulas_asociadas) <= 0){
                $registro=CargoEspecifico::find($cargo);
                $clon_old = ["datos_cargo" => collect($registro)->except(["created_at","updated_at"])->toArray(),"clausulas"=>$registro->clausulas->where("active_pivot","1")->pluck("id")->toArray()];

                $asignar_a_cargo = new CargoDocumentoAdicional();
                $asignar_a_cargo->fill([
                    "cargo_id" => $cargo,
                    "adicional_id" => $request->adicional_id,
                    "active" => $request->estado_clausula
                ]);
                $asignar_a_cargo->save();

                //Generar auditoria
                $registro_new=CargoEspecifico::find($cargo);
                $clon_new = ["datos_cargo" => collect($registro_new)->except(["created_at","updated_at"])->toArray(),"clausulas"=>$registro_new->clausulas->where("active_pivot","1")->pluck("id")->toArray()];

                $clon_old = json_encode($clon_old);
                $clon_new = json_encode($clon_new);

                if($clon_old != $clon_new) {
                    $auditoria = new Auditoria();
                    $auditoria->observaciones = "Editar cargo";
                    $auditoria->valor_antes   = $clon_old;
                    $auditoria->valor_despues = $clon_new;
                    $auditoria->user_id       = $this->user->id;
                    $auditoria->tabla         = "cargos_especificos";
                    $auditoria->tabla_id      = $registro->id;
                    $auditoria->tipo          = "ACTUALIZAR-CLAUSULAS";

                    event(new \App\Events\AuditoriaEvent($auditoria));
                }
                
            }
        }

        return response()->json([
            "success" => true
        ]);
    }

    public function asociarTodos(Request $request){
        $cargos_a_asociar = CargoEspecifico::select('id')->get();

        foreach ($cargos_a_asociar as $cargo) {
            $cargos_clausulas_asociadas = CargoDocumentoAdicional::where('cargo_id', $cargo->id)
            ->where('adicional_id', $request->adicional_id)
            ->first();

            if(count($cargos_clausulas_asociadas) <= 0){
                $asignar_a_cargo = new CargoDocumentoAdicional();

                $asignar_a_cargo->fill([
                    "cargo_id" => $cargo->id,
                    "adicional_id" => $request->adicional_id,
                    "active" => $request->estado_clausula
                ]);
                $asignar_a_cargo->save();
            }
        }

        return response()->json([
            "success" => true
        ]);
    }

    public function asociar_borrar(Request $request)
    {
        $cargo_clausula = CargoDocumentoAdicional::where('id', $request->cargo_adicional)->first();
        $cargo_clausula->delete();

        return response()->json([
            "success" => true,
        ]);
    }

    public function asociar_estado(Request $request)
    {
        $cargo_clausula = CargoDocumentoAdicional::where('id', $request->cargo_adicional)->first();

        if($request->adicional_estado == 1){
            $cargo_clausula->active = 0;
        }else{
            $cargo_clausula->active = 1;
        }

        $cargo_clausula->save();

        return response()->json([
            "success" => true,
            "estado" => $cargo_clausula->active
        ]);
    }

    public function getClausulaView($adicional_id)
    {
        $clausula_informacion = DocumentoAdicional::where('documentos_adicionales_contrato.creada', 1)
        ->where('documentos_adicionales_contrato.id', $adicional_id)
        ->select(
            'documentos_adicionales_contrato.id as adicional_id',
            'documentos_adicionales_contrato.descripcion as nombre_clausula',
            'documentos_adicionales_contrato.contenido_clausula as contenido_clausula',
            'documentos_adicionales_contrato.opcion_firma'
        )
        ->first();

        $firma_default = asset('contratos/default.jpg');

        $opcion_firma = $clausula_informacion->opcion_firma;

        //Preview de los datos
        $subject = $clausula_informacion->contenido_clausula;

        $datos = DatosBasicos::where('user_id', $this->user->id)->first();

        $dia = date('d');
        $mes = date('n');
        $ano = date('Y');
        $fecha = "$dia de ".$this->meses[$mes]." de $ano";

        $cargo = $cargo = 'DESARROLLADOR (Cargo de ejemplo)';
        $empresa_usuaria = Sitio::select('nombre')->first();

        $tipo_documento = mb_strtolower($datos->getTipoIdentificacion->descripcion);

        $ciudad_oferta = 'Bogotá';
        $ciudad_contrato = 'Bogotá';

        $valor_variable = '90.000';

        $empresa_contrata = 'T3RS (Empresa de ejemplo)';

        $salario_asignado = "2.000.000";

        $replace = [
            $datos->fullname(),
            $datos->nombres,
            $datos->primer_apellido,
            $datos->segundo_apellido,
            $datos->numero_id,
            $datos->direccion,
            $datos->telefono_movil,
            $fecha,
            $fecha,
            $cargo,
            $empresa_usuaria->nombre,
            $tipo_documento,
            $ciudad_oferta,
            $ciudad_contrato,
            $valor_variable,
            $empresa_contrata,
            $salario_asignado
        ];

        $nuevo_cuerpo = $this->search_and_replace($replace, $subject);

        $view = \View::make('admin.clausulas.template.layout', compact('nuevo_cuerpo', 'firma_default', 'opcion_firma', 'datos'))->render();
        $pdf =  app('dompdf.wrapper');
        $pdf->loadHTML($view);

        return $pdf->stream('invoice');

        //return view('admin.clausulas.template.layout', compact('nuevo_cuerpo', 'firma_default', 'datos'));
    }

    /**
     * Mini servicio para guardar imagenes del generador
     */
    public function imagen_generador(Request $request)
    {
        $imagen = $request->file('imagen');
        $nombre = mb_strtolower(str_replace(' ', '-', $request->alt))."_".strtotime('now').".".$request->imagen->extension();

        $path_imagen = Storage::disk('public')->put("recursos_generador_clausulas/", $imagen);

        $url = route('home')."/$path_imagen";

        return response()->json(['success' => true, 'file' => $url]);
    }

    public function getCargosEspecificos(Request $request)
    {
        $cargos_especificos = CargoEspecifico::where("clt_codigo", $request->cliente_id)
        //->orderBy('descripcion', 'ASC')
        ->orderByRaw('descripcion ASC')
        ->pluck("descripcion", "id")
        ->toArray();

        return response()->json([
            "success" => true, "cargos_especificos" => $cargos_especificos
        ]);
    }

    public function listar_clausulas_cargo(Request $request)
    {
        $sitio = Sitio::first();
        $sitioModulo = SitioModulo::first();
        $adicionales = [];

        if($sitio->asistente_contratacion == 1 && $sitioModulo->generador_variable == 'enabled') {
            $adicionales = CargoDocumentoAdicional::where('cargo_id', $request->cargo_id)
            ->where('active', 1)
            ->get();
        }

        return view('admin.requerimientos.includes._section_configurar_adicionales', compact('adicionales'));
    }

    private function search_and_replace(array $replace, string $subject){
        $nuevo_texto = null;

        for ($i=0; $i < count($this->search); $i++) {
            if($i == 0){
                $nuevo_texto = str_replace($this->search[$i], $replace[$i], $subject);
            }

            $nuevo_texto = str_replace($this->search[$i], $replace[$i], $nuevo_texto);
        }

        return $nuevo_texto;
    }
}
