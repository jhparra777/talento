<?php

namespace App\Http\Requests;
use Carbon\Carbon;
use App\Http\Requests\Request;
use App\Models\CargoEspecifico;
use App\Models\CentroTrabajo;
use App\Models\Negocio;
use App\Models\CentroCostoProduccion;
use App\Models\TipoJornada;
use App\Models\TipoLiquidacion;
use App\Models\TipoSalario;
use App\Models\TipoNomina;
use App\Models\ConceptoPago;
use App\Models\TipoContrato;
use App\Models\MotivoRequerimiento;
use App\Models\NivelEstudios;
use App\Models\Genero;
use App\Models\EstadoCivil;
use Illuminate\Support\Facades\DB;

class NuevoRequerimientoRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        
      //  dd($fechaRe);
    if(route('home') != "http://vym.t3rsc.co" && route('home') != "https://vym.t3rsc.co") {
        
        return [
            'tipo_proceso_id' => "required",
            'sitio_trabajo' => "required",
            'ciudad_id' => "required",
            'solicitado_por_txt' => "required",
            'cargo_especifico_id' => "required",
            'centro_costo_produccion' => "required",
            'salario' => "required|numeric",
            "tipo_contrato_id" => "required",
            'motivo_requerimiento_id' => 'required',
            'num_vacantes' => 'required|numeric',
            'nivel_estudio' => 'required',
            'genero_id' => 'required',
            'estado_civil' =>'required',
            'fecha_recepcion' => 'required|date_format:Y-m-d',
            'fecha_ingreso'=>'required|date|date_format:Y-m-d|after:fecha_recepcion',
            'fecha_retiro'=>'required|date_format:Y-m-d',
            'contenido_email_soporte' => 'required',
        ];
      }
    }

    public function messages() {
        return [
            'tipo_proceso_id.required'=>'Debe seleccionar el tipo de proceso',
            'sitio_trabajo.required'=>'Debes seleccionar el sitio de trabajo',
            'solicitado_por_txt.required'=>'Debe digitar el nombre persona que solicita el requerimiento',
            'cargo_especifico_id.required'=>'Debe seleccionar el cargo',
            'centro_costo_produccion.required'=>'Selecciona el centro de costos de producción',
            'salario.required'=>'El salario es obligatorio',
            'salario.numeric'=>'El salario debe ser un número sin puntos',
            'tipo_contrato_id.required'=>'Debe seleccionar el tipo de contrato',
            'motivo_requerimiento_id.required'=>'Debe seleccionar el motivo del requerimiento',
            'num_vacantes.required'=>'Digite el número de vacantes',
            'num_vacantes.numeric'=>'El número de vacantes debe ser un número',
            'nivel_estudio.required'=>'Selecciona el nivel de estudio',
            'genero_id.required'=>'Selecciona el género solicitado',
            'estado_civil.required'=>'Selecciona el estado civil solicitado',
            'fecha_ingreso.date'=>'Selecciona la fecha tentativa no menor a la fecha actual',
            'fecha_ingreso.date_format'=>'Fecha ingreso : formato inválido',
            'fecha_retiro.required'=>'Selecciona la fecha de retiro',
            'fecha_retiro.date_format'=>'Fecha retiro : formato inválido',
            'fecha_recepcion.required'=>'Selecciona la fecha de recepción del email de la solicitud',
            'fecha_recepcion.date_format'=>'Fecha recepción : formato inválido',
            'contenido_email_soporte.required' => 'Contenido emial soporte requerido',
        ];
    }

    public function response(array $errors) {
        //dd($errors);
        if($this->has('cargo_especifico_id')){
            //dd($this->centro_costo_produccion);
            //$cargo_especifico = ["" => "Seleccionar"] + \App\Models\CargoEspecifico::where("cargo_generico_id", $this->get("cargo_generico_id"))->pluck("descripcion", "id")->toArray();
            $cargo_especifico_id = $this->cargo_especifico_id;
            $negocio_id = $this->negocio_id;
            $cargo_especifico = CargoEspecifico::find($cargo_especifico_id);
            $centro_trabajo = CentroTrabajo::where('id', $cargo_especifico->ctra_x_clt_codigo)
                    ->select('nombre_ctra')
                    ->first();
            $ctra_x_clt_codigo = $cargo_especifico->ctra_x_clt_codigo;
            //Get depto Negocio
            $negocio = Negocio::find($negocio_id);
            //Get centros de costos de produccion
            $centro_costos = ["" => 'Seleccionar'] + CentroCostoProduccion::where('cod_division', $cargo_especifico->clt_codigo)
                            ->where('cod_depto_negocio', $negocio->depto_codigo)
                            ->where('estado', '=', 'ACT')
                            ->pluck('descripcion', 'codigo')
                            ->toArray();
            $centro_costo = $this->centro_costo_produccion;
            $jornada_laboral = TipoJornada::where('id', $cargo_especifico->cxclt_jorn_lab)
                    ->where('active', 1)
                    ->first();
            $tipo_liquidacion = TipoLiquidacion::where('cod_tipo_liquidacion', $cargo_especifico->cxclt_tliq)->first();
            $tipo_salario = TipoSalario::where('id', $cargo_especifico->tsal_codigo)->first();
            $tipo_nomina = TipoNomina::where('id', $cargo_especifico->cxclt_tnom)->first();
            $concepto_pago = ConceptoPago::where('id', $tipo_nomina->cod_concepto_pago)->first();
            $salario = $this->salario;
            $salario_min = $cargo_especifico->cxclt_sueldo_minimo;
            $salario_max = $cargo_especifico->cxclt_sueldo_maximo;
            $tipo_contrato = [" " => "Seleccionar"] + TipoContrato::pluck("descripcion", "id")->toArray();
            $tco_codigo = $cargo_especifico->tco_codigo;

            $motivo_requerimiento = [" " => "Seleccionar"] + MotivoRequerimiento::whereIn('id', [2, 4, 1])
                            ->orderBy('id', 'asc')->orderBy('descripcion', 'asc')
                            ->pluck("descripcion", "id")
                            ->toArray();
            $motivo_requerimiento_id = $this->motivo_requerimiento_id;
            $num_vacantes = $this->num_vacantes;
            $observaciones = $this->observaciones;
            $nivel_estudio = [" " => "Seleccionar"] + NivelEstudios::orderBy('descripcion', 'asc')
                            ->select(DB::raw("upper(descripcion) as descripcion"), 'id')
                            ->pluck("descripcion", "id")
                            ->toArray();
            $nivel_estudio_id = $this->nivel_estudio;
            $funciones = $this->funciones;
            $edad_minima = ["16" => "Menor de Edad"];
            for ($i = 18; $i <= 50; $i++) {
                $edad_minima[$i] = $i;
            }
            $edad_minima_selected = $cargo_especifico->cxclt_edad_min;

            $edad_maxima = [];
            for ($i = 18; $i <= 50; $i++) {
                $edad_maxima[$i] = $i;
            }
            $edad_maxima += ["51" => "Mayor de 50 años"];
            $edad_maxima_selected = $cargo_especifico->cxclt_edad_max;
            $generos = [" " => "Seleccionar"] + Genero::orderBy('id', 'asc')->pluck("descripcion", "codigo")->toArray();
            $genero_selected = $cargo_especifico->cxclt_genero;
            $estados_civiles = [" " => "Seleccionar"] + EstadoCivil::orderBy('id', 'asc')
                            ->select(DB::raw("upper(descripcion) as descripcion"), 'codigo')
                            ->pluck('descripcion', "codigo")
                            ->toArray();
            $estado_civil_selected = $cargo_especifico->cxclt_est_civil;
            

            $partial_html = view('req.nuevo_requerimiento_dependientes_cargos_especificos', compact(
                            'centro_trabajo','funciones', 'num_vacantes', 'ctra_x_clt_codigo', 'centro_costos','centro_costo', 'negocio','jornada_laboral', 'tipo_liquidacion', 'salario','tipo_salario', 'tipo_nomina','observaciones', 'concepto_pago', 'salario_min', 'salario_max', 'tipo_contrato', 'tco_codigo', 'motivo_requerimiento','motivo_requerimiento_id', 'nivel_estudio','nivel_estudio_id', 'edad_minima', 'edad_minima_selected', 'edad_maxima', 'edad_maxima_selected', 'generos', 'genero_selected', 'estados_civiles', 'estado_civil_selected'
            ))->render();
            //dd($partial_html);
            return redirect()->back()
                             ->with("partial_html", $partial_html)
                             ->with('return_from_post_req', true)
                             ->withInput()
                             ->withErrors($errors);
        }else{
            return redirect()->back()->withErrors($errors);
        }
    }

}
