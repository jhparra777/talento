@extends("admin.layout.master")
@section("contenedor")
{!! Form::model($ficha,["id"=>"form_ficha_editar","route"=>"admin.guardar_ficha_editar","method"=>"POST"]) !!}
<div class="row">
    <div class="col-md-12 col-xs-6">
        <h3 class="page-header"><i class="fa fa-cube" aria-hidden="true"></i> Modificar Ficha Perfil</h3>
        <p class="text-danger">Campos con asterisco * son obligatorios/requeridos.</p>
        <div class="clearfix"></div>
        @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get("mensaje_success")}}
            </div>
        </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-8  form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Empresas/Clientes:<span class="text-danger">*</span></label>
        <div class="col-sm-8">
            {!! Form::hidden('id'); !!}
            {!! Form::hidden('sociedad_id',0,['id'=>'sociedad_id']); !!}
            {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control","id"=>"cliente_id"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cliente_id",$errors) !!}</p>    
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xs-6">
        <h3 class="page-header">Datos Generales de la Empresa</h3>
        <div class="clearfix"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xs-6">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Razón Social</th>
                    <td id="dge_nombre">{{ $datos_clientes->nombre }}</td>
                    <th>NIT</th>
                    <td id="dge_nit">{{ $datos_clientes->nit }}</td>
                </tr>
                <tr>
                    <th>Ciudad</th>
                    <td id="dge_ciudad">{{ $datos_clientes->getUbicacion()->value }}</td>
                    <th>Dirección</th>
                    <td id="dge_direccion">{{ $datos_clientes->direccion }}</td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td id="dge_telefono">{{ $datos_clientes->telefono }}</td>
                    <th></th>
                    <td></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6  form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Cargo Cliente:<span class="text-danger">*</span></label>
        <div class="col-sm-8 cargo_cliente_container">
            {!! Form::select("cargo_cliente",$cargo_cliente,null,["class"=>"form-control"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_cliente",$errors) !!}</p>    
    </div>


</div>
<div class='row'>
    <div class="col-md-12 col-xs-6">
        <h3 class="page-header">Requerimientos de Selección</h3>
        <div class="clearfix"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-8  form-group">
        <label for="inputEmail3" class="col-sm-6 control-label">Número de Candidatos a presentar por vacantes:<span class="text-danger">*</span></label>
        <div class="col-sm-4">
            {!! Form::text("cantidad_candidatos_vac",null,["class"=>"form-control","placeholder"=>""]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cantidad_candidatos_vac",$errors) !!}</p>    

    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xs-6">
        <div class="table-responsive">
            <table class="table table-striped">
                <tr>
                    <th>Número de Vacantes</th>
                    <th>Tiempo de Respuesta envío Candidatos</th>
                </tr>
                <tr>
                    <td>1 - 5</td>
                    <td>
                        <div class="col-sm-8">
                            {!! Form::text("tiempo_respuesta[t15]",null,["class"=>"form-control","placeholder"=>"","id"=>"tiempo_respuesta15"]); !!}
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tiempo_respuesta.t15",$errors) !!}</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>6 - 10</td>
                    <td>
                        <div class="col-sm-8">
                            {!! Form::text("tiempo_respuesta[t610]",null,["class"=>"form-control","placeholder"=>"","id"=>"tiempo_respuesta610"]); !!}
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tiempo_respuesta.t610",$errors) !!}</p>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Más de 10</td>
                    <td>
                        <div class="col-sm-8">
                            {!! Form::text("tiempo_respuesta[tmas10]",null,["class"=>"form-control","placeholder"=>"","id"=>"tiempo_respuestamas10"]); !!}
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tiempo_respuesta.tmas10",$errors) !!}</p>
                        </div> 
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="col-md-6 col-sm-6  form-group">
    <label class="col-sm-4 control-label">Procedimientos Realizar:<span class="text-danger">*</span></label>
    <div class="col-sm-8">
        <div class="checkbox">
            <label for="entrevista">
                {!! Form::checkbox('procesos[]', 'entrevista', null,['id'=>'entrevista']); !!}
                Entrevista
            </label>
        </div>
        <div class="checkbox">
            <label for="entrevista_cliente">
                {!! Form::checkbox('procesos[]', 'entrevista_cliente', null,['id'=>'entrevista_cliente']); !!}
                Entrevista con el Cliente
            </label>
        </div>
        <div class="checkbox">
            <label for="validacion">
                {!! Form::checkbox('procesos[]', 'validacion', null,['id'=>'validacion']); !!}
                Validación/Revisión
            </label>
        </div>

        <div class="table-responsive  table-docs">
            <table class="table table-bordered">
                <tbody>
                    @foreach( $documentos as $documento )
                    <tr>
                        <td>
                            {!! Form::checkbox('docs[]', $documento->id, null); !!}
                        </td>
                        <td>{{ $documento->descripcion }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="checkbox">
            <label for="referenciacion">
                {!! Form::checkbox('procesos[]', 'referenciacion', null,['id'=>'referenciacion']); !!}
                Referenciación
            </label>
        </div>
        <div class="checkbox">
            <label for="pro_pruebas_psicotecnicas">
                {!! Form::checkbox('procesos[]','pruebas_psicotecnicas', null,['id'=>'pro_pruebas_psicotecnicas']); !!}
                Pruebas Psicotécnicas
            </label>
        </div>
    </div>

</div>
<div class="col-md-6 col-sm-6  form-group">
    <label class="col-sm-8 control-label">Requiere informe selección</label>
    <div class="col-sm-4">
        <label class="radio-inline">
            {!! Form::radio('req_informe_seleccion', 'si',null,['id'=>'req_informe_seleccion_si']); !!}
            SI
        </label>
        <label class="radio-inline">
            {!! Form::radio('req_informe_seleccion', 'no',null,['id'=>'req_informe_seleccion_no']); !!}
            NO
        </label>

    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("req_informe_seleccion",$errors) !!}</p>    
</div>
<div class="col-md-6 col-sm-6  form-group">
    <label class="col-sm-8 control-label">Estudio de Seguridad</label>
    <div class="col-sm-4">
        <label class="radio-inline">
            {!! Form::radio('req_estudio_seguridad', 'si',false,['id'=>'req_estudio_seguridad_si']); !!}
            SI
        </label>
        <label class="radio-inline">
            {!! Form::radio('req_estudio_seguridad', 'no',true,['id'=>'req_estudio_seguridad_no']); !!}
            NO
        </label>

    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("req_estudio_seguridad",$errors) !!}</p>    
</div>
<div class="col-md-6 col-sm-6  form-group">
    <label class="col-sm-8 control-label">Visita Domiciliaria</label>
    <div class="col-sm-4">
        <label class="radio-inline">
            {!! Form::radio('req_visita_domiciliaria', 'si',false,['id'=>'req_visita_domiciliaria_si']); !!}
            SI
        </label>
        <label class="radio-inline">
            {!! Form::radio('req_visita_domiciliaria', 'no',true,['id'=>'req_visita_domiciliaria_no']); !!}
            NO
        </label>

    </div>

</div>
<div class="row">
    <div class="col-md-12 col-xs-6">
        <h3 class="page-header">Condiciones del Perfil</h3>
        <div class="clearfix"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 form-group">
        <label class="col-sm-4 control-label">Documentación Adicional Requerida</label>
        <div class="col-md-8 containers_docs">
            @if(count($ficha->doc_adicio)>0)
            @foreach($ficha->doc_adicio as $doc_adicio_value )
            {!! Form::text("docs_adicio[]",$doc_adicio_value,["class"=>"form-control"]); !!}
            @endforeach
            @else
            {!! Form::text("docs_adicio[]",null,["class"=>"form-control","placeholder"=>"Documento 1"]); !!}
            @endif
        </div>
    </div>
    <div class="col-md-6 col-sm-6 form-group">
        <label class="col-md-4 control-label">Criticidad del Cargo</label>
        <div class="col-sm-8">
            <label class="radio-inline">
                {!! Form::radio('criticidad_cargo', 'alta',false,['id'=>'criticidad_cargo_alta']); !!}
                ALTA
            </label>
            <label class="radio-inline">
                {!! Form::radio('criticidad_cargo', 'media',false,['id'=>'criticidad_cargo_media']); !!}
                MEDIA
            </label>
            <label class="radio-inline">
                {!! Form::radio('criticidad_cargo', 'baja',false,['id'=>'criticidad_cargo_baja']); !!}
                BAJA
            </label>
        </div>
    </div>
</div>
<div class='row'>
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-sm-2'>Edad :<span class="text-danger">*</span></label>
        <div class="col-md-5 col-sm-5">
            {!! Form::text("edad_minima",null,["id"=>"edad_minima","class"=>"form-control","placeholder"=>"Edad Minima"]); !!}
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("edad_minima",$errors) !!}</p>    
        </div>

        <div class="col-md-5 col-sm-5">
            {!! Form::text("edad_maxima",null,["id"=>"edad_maxima","class"=>"form-control","placeholder"=>"Edad Maxima"]); !!}
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("edad_maxima",$errors) !!}</p>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-sm-4'>Género :<span class="text-danger">*</span></label>
        <div class="col-md-8">
            {!! Form::select("genero",$genero,null,["class"=>"form-control"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
    </div>
</div>
<div class='row'>
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-sm-3'>Escolaridad :<span class="text-danger">*</span></label>
        <div class="col-md-6 col-sm-6">
            {!! Form::select("escolaridad",$escolaridades,null,["class"=>"form-control"]); !!}
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("escolaridad",$errors) !!}</p>
        </div>
        <div class="col-md-3 col-sm-3">
            {!! Form::text("otro_estudio",null,["class"=>"form-control","placeholder"=>"Otro Estudio"]); !!}
        </div>
    </div>
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-sm-4'>Experiencia: <span class="text-danger">*</span></label>
        <div class="col-md-8">
            {!! Form::select("experiencia",$experiencia,null,["class"=>"form-control"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("experiencia",$errors) !!}</p>
    </div>
</div>
<div class='row'>
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-sm-4'>Area de Desempeño</label>
        <div class="col-md-8 col-sm-8">
            {!! Form::textarea("area_desempeno",null,["class"=>"form-control","rows"=>3,"id"=>"area_desempeno"]); !!}
        </div>
    </div>
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-sm-4'>Conocimientos Especificos</label>
        <div class="col-md-8 col-sm-8">
            {!! Form::textarea("conocimientos_especificos",null,["class"=>"form-control","rows"=>3,"id"=>"conocimientos_especificos"]); !!}
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-6 col-sm-6 form-group">
        <label class="col-sm-4 control-label">Pruebas Psicotécnicas</label>
        <div class="col-sm-8" id="coleccion_pruebas">
            @if(count($ficha->pruebas_psicotecnicas)>0)
                @foreach($ficha->pruebas_psicotecnicas as $key => $prueba)
                {!! Form::select("pruebas_psicotecnicas[$key]",$pruebas,null,["class"=>"form-control"]); !!}
                @endforeach
               {!! Form::select("pruebas_psicotecnicas[]",$pruebas,"",["class"=>"form-control"]); !!}  
            @else
            {!! Form::select("pruebas_psicotecnicas[]",$pruebas,null,["class"=>"form-control"]); !!}
            @endif
        </div>
    </div>
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-sm-4'>Competencias Requeridas</label>
        <div class="col-md-8 col-sm-8">
            {!! Form::textarea("competencias_requeridas",null,["class"=>"form-control","rows"=>3]); !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xs-6">
        <h3 class="page-header">Condiciones del Cargo</h3>
        <div class="clearfix"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 form-group">
        <label class="col-sm-4 control-label">Horario<span class="text-danger">*</span></label>
        <div class="col-sm-8" id="coleccion_pruebas">
            {!! Form::select("horario",$jornadas,null,["class"=>"form-control"]); !!}

        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("horario",$errors) !!}</p>
    </div>
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-sm-4'>Observaciones Horarios</label>
        <div class="col-md-8 col-sm-8">
            {!! Form::textarea("observaciones_horario",null,["class"=>"form-control","rows"=>3,"id"=>"observaciones_horario"]); !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-6 form-group">
        <table class="table table-striped">
            <tbody>
                <tr>
                    <th>Variable</th>
                    <td>
                        <label class="radio-inline">
                            {!! Form::radio('variable', 'si',false,['id'=>'variable_si']); !!}
                            Si
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('variable', 'no',true,['id'=>'variable_no']); !!}
                            No
                        </label>
                    </td>
                    <td class="col-sm-8">
                        {!! Form::text("valor_variable",null,["class"=>"form-control","placeholder"=>"Valor"]); !!}
                    </td>
                </tr>
                <tr>
                    <th>Comisión</th>
                    <td>
                        <label class="radio-inline">
                            {!! Form::radio('comision', 'si',false,['id'=>'comision_si']); !!}
                            Si
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('comision', 'no',true,['id'=>'comision_no']); !!}
                            No
                        </label>
                    </td>
                    <td class="col-sm-8">
                        {!! Form::text("valor_comision",null,["class"=>"form-control","placeholder"=>"Valor"]); !!}
                    </td>
                </tr>
                <tr>
                    <th>Rodamiento</th>
                    <td>
                        <label class="radio-inline">
                            {!! Form::radio('rodamiento', 'si',false,['id'=>'rodamiento_si']); !!}
                            Si
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('rodamiento', 'no',true,['id'=>'rodamiento_no']); !!}
                            No
                        </label>
                    </td>
                    <td class="col-sm-8">
                        {!! Form::text("valor_rodamiento",null,["class"=>"form-control","placeholder"=>"Valor"]); !!}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 form-group">
        <label class="col-sm-4 control-label">Rango Salarial<span class="text-danger">*</span></label>
        <div class="col-sm-8">
            {!! Form::select("rango_salarial",$aspiracion,null,["class"=>"form-control","id"=>"rango_salarial"]); !!}

        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("rango_salarial",$errors) !!}</p>
    </div>
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-sm-4'>Tipo Contrato<span class="text-danger">*</span></label>
        <div class="col-md-8 col-sm-8">
            {!! Form::select("tipo_contrato",$tipos_contratos,null,["class"=>"form-control","id"=>"tipo_contrato"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_contrato",$errors) !!}</p>
    </div>
</div>
<div class="row">
    {!! Form::hidden('personal_cargo','0'); !!}
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-sm-4'>Canal al que pertenece</label>
        <div class="col-md-8 col-sm-8">
            {!! Form::text("canal_pertenece",null,["id"=>"canal_pertenece","class"=>"form-control","placeholder"=>""]); !!}
        </div>
    </div>
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-md-4'>Funciones Básicas</label>
        <div class="col-md-8">
            {!! Form::textarea("funciones_realizar",null,["id"=>"funciones_realizar","class"=>"form-control","rows"=>4]); !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xs-6">
        <h3 class="page-header">Condiciones Físicas</h3>
        <div class="clearfix"></div>
    </div>
</div>
<div class='row'>
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-sm-2'>Estatura</label>
        <div class="col-md-5 col-sm-5">
            {!! Form::hidden("estatura",0); !!}
            {!! Form::text("estatura_minima",null,["class"=>"form-control","placeholder"=>"Estatura Minima","id"=>"estatura_minima"]); !!}
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estatura_minima",$errors) !!}</p>
        </div>

        <div class="col-md-5 col-sm-5">
            {!! Form::text("estatura_maxima",null,["class"=>"form-control","placeholder"=>"Estatura Maxima","id"=>"estatura_maxima"]); !!}
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estatura_maxima",$errors) !!}</p>
        </div>

    </div>
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-sm-4'>Talla Camisa</label>
        <div class="col-md-8">

            {!! Form::select("talla_camisa",$tallas,null,["class"=>"form-control","id"=>"talla_camisa"]); !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 form-group">
        <label class="col-sm-4 control-label">Talla Pantalón</label>
        <div class="col-sm-8">
            {!! Form::select("talla_pantalon",$tallas_pantalon,null,["class"=>"form-control","id"=>"talla_pantalon"]); !!}

        </div>
    </div>
    <div class="col-md-6 col-sm-6 form-group">
        <label class='col-sm-4'>Calzado</label>
        <div class="col-md-8 col-sm-8">
            {!! Form::select("calzado",$calzado,null,["class"=>"form-control","id"=>"calzado"]); !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 form-group">
        <label class="col-sm-4 control-label">Otros</label>
        <div class="col-sm-8">
            {!! Form::textarea("otros_fisicas",null,["id"=>"otros_fisicas","class"=>"form-control","rows"=>3]); !!}
        </div>
    </div>
    <div class="col-md-6 col-sm-6 form-group">
        <label class="col-sm-4 control-label">Restricciones</label>
        <div class="col-sm-8">
            {!! Form::textarea("restricciones",null,["class"=>"form-control","id"=>"restricciones","rows"=>3]); !!}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-xs-6">
        <h3 class="page-header">Observaciones Generales</h3>
        <div class="clearfix"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-sm-6 form-group">
        <label class='col-md-4'>Observaciones</label>
        <div class="col-md-8">
            {!! Form::textarea("observaciones_generales",null,["class"=>"form-control","id"=>"observaciones_generales","rows"=>4]); !!}
        </div>
    </div>
</div>
<div class="row">
    <p>
        <a class="btn btn-danger" href="{{ route('admin.listar_fichas') }}" role="button"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</a>
        {!! Form::button('Guardar',["type"=>"submit","class"=>"btn btn-primary","id"=>"form_guardar"]); !!}
    </p>
</div>
{!! Form::close(); !!}
<script>
    $(function () {
        //Desactivar el boton de guardar mientras guarda
        $('#form_guardar').click(function (e) {
            $('#form_guardar').text('Por favor espere..procesando').prop('disabled', true);
            $('#form_ficha_editar').submit();
        });

        $('.table-docs').show();
        $validation_chk = $('#validacion');
        $validation_chk.change(function () {
            if (this.checked) {
                $('.table-docs').show();
            } else {
                $('.table-docs').hide();
            }
        });
        $('#req_estudio_seguridad_si').change(function (e) {
            if ($('#req_estudio_seguridad_si').is(':checked')) {
                $('#req_visita_domiciliaria_si').prop('checked', 'checked');
            }
        })
        //Traer datos de la empresa
        $(document).on('change', '#cliente_id', function (e) {
            $valor = $(this).val();
            if ($valor != "") {
                $.ajax({
                    url: "{{ route('admin.fichas_tecnicas.traer_info_cliente') }}",
                    type: "GET",
                    dataType: "json",
                    data: {"cliente_id": $valor},
                }).done(function (response) {
                    //console.log(response.html);
                    $('#dge_nombre').text(response.clientes.nombre);
                    $('#dge_nit').text(response.clientes.nit);
                    $('#dge_direccion').text(response.clientes.direccion);
                    $('#dge_telefono').text(response.clientes.telefono);
                    $('#dge_ciudad').text(response.clientes.ciudad);
                    $('.cargo_cliente_container').html(response.html);
                });
            }
        });
        // Traer cargo generico
        $(document).on('change', '#cargo_cliente', function (e) {
            $valor = $(this).val();
            if ($valor != "") {
                $.ajax({
                    url: "{{ route('admin.fichas_tecnicas.traer_cargo_generico') }}",
                    type: "GET",
                    dataType: "json",
                    data: {"cargo_cliente": $valor}
                }).done(function (response) {
                    console.log(response);
                    $('.cargo_generico_container').html(response);
                });
            }
        });
        //Documentos adicionales
        $(document).on('blur', '.containers_docs > input:last', function (e) {
            $num_childs = $('.containers_docs').children().length;
            $obj_cloned = $(this).clone();
            $obj_cloned.prop('placeholder', "Documento " + ($num_childs + 1)).val("");
            $obj_cloned.appendTo('.containers_docs');
        });
        //Pruebas
        $(document).on('change', '#coleccion_pruebas > select:last', function (e) {
            $select = $(this).clone().appendTo('#coleccion_pruebas');
        });
        //Fin jQuery
    });
</script>
@stop
