@extends("admin.layout.master")
@section('contenedor')
    <h3>
        <i aria-hidden="true" class="fa fa-file-text-o"></i>
        Reportes Detalle Reclutamiento
    </h3>
    
    <hr/>

    {!! Form::model(Request::all(),["route" => "admin.reportes_reclutamientos","method" => "GET","accept-charset" => "UTF-8"]) !!}
        <fieldset style="background: #f5f5f5;">
            <legend style="font-size: 1em;">Rango de fechas de carga</legend>
                <div class="col-md-6 form-group">
                    <label class="col-sm-2 control-label" for="inputEmail3">
                        Fecha Inicial:
                    </label>
                    
                    <div class="col-sm-10">
                        {!! Form::text("fecha_inicio", null, ["class" => "form-control", "placeholder" => "Fecha Inicial", "id" => "fecha_inicio" ]); !!}
                    </div>
                </div>
                
                <div class="col-md-6 form-group">
                    <label class="col-sm-2 control-label" for="inputEmail3">
                        Fecha Final:
                    </label>
                    
                    <div class="col-sm-10">
                        {!! Form::text("fecha_final", null, ["class" => "form-control", "placeholder" => "Fecha Final", "id" => "fecha_final" ]); !!}
                    </div>
                </div>
        </fieldset>
        
        <hr>

        {{--<div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Cliente:
            </label>
            <div class="col-sm-10">
                {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control","id"=>"cliente_id"]); !!}
            </div>
        </div>--}}

        {{--<div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Criterio:
            </label>
            <div class="col-sm-10">
                {!! Form::select("criterio",$criterios,null,["class"=>"form-control","id"=>"criterio" ]); !!}
            </div>
        </div>--}}

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Metodo carga:
            </label>
            
            <div class="col-sm-10">
                {!! Form::select("metodo", $metodos, null, ["class" => "form-control", "id" => "metodo" ]); !!}
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Usuario Carga:
            </label>
            
            <div class="col-sm-10">
                {!! Form::select("usuario_gestion", $usuarios, null, ["class" => "form-control", "id" => "usuario_gestion"]); !!}
            </div>
        </div>

        @if(route("home")!="https://gpc.t3rsc.co")
            <div class="col-md-6 form-group">
                <label class="col-sm-2 control-label" for="inputEmail3">
                    Agencia:
                </label>
                
                <div class="col-sm-10">
                    {!! Form::select("agencia",$agencias,null,["class"=>"form-control","id"=>"agencia"]); !!}
                </div>
            </div>
        @endif

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Ciudad residencia: </label>
            <span style="color:red;display: none;" id="error_ciudad_expedicion">Debe seleccionar de la lista</span>
            <div class="col-sm-10">
                {!! Form::hidden("pais_id", null, ["class" => "form-control", "id" => "pais_id"]) !!}
                {!! Form::hidden("departamento_id", null, ["class" => "form-control", "id" => "departamento_id"]) !!}
                {!! Form::text("ciudad_id", null, ["style" => "display: none;", "class" => "form-control", "id" => "ciudad_id"]) !!}
                {!! Form::text("sitio_trabajo", null, ["placeholder" => "Seleccionar una opción de la lista desplegable", "class" => "form-control", "id" => "sitio_trabajo_autocomplete"]); !!}
            </div>
        </div>
    
        <div class="clearfix"></div>
        
        <input id="formato" name="formato" type="hidden" value="html"/>
        <button class="btn btn-success" type="submit">
            Generar
        </button>
        
        <a class="btn btn-success" href="#" id="export_excel_btn" role="button">
            <i aria-hidden="true" class="fa fa-file-excel-o"></i>
            Excel
        </a>
        
        <!--
        <a class="btn btn-danger" href="#" id="export_pdf_btn" role="button">
            <i aria-hidden="true" class="fa fa-file-pdf-o">
            </i>
            PDF
        </a>
        -->
    {!! Form::close() !!}

    @if(isset($data))
        @if($data!="vacio")
            @include('admin.reportes.includes.grilla_detalle_reclu')
        @endif
    @endif

    <script>
        $(function () {
            $("#fecha_inicio, #fecha_final").datepicker(confDatepicker);

            $('#export_excel_btn').click(function(e){
                var data_form = $('#filter_form').serialize();
                var fecha_inicio = $("#fecha_inicio").val();
                var fecha_final = $("#fecha_final").val();
                //var cliente_id = $("#cliente_id").val();
                //var criterio = $("#criterio").val();
                var ciudad_id = $("#ciudad_id").val();
                var departamento_id = $("#departamento_id").val();
                var pais_id = $("#pais_id").val();
                var agencia = $("#agencia").val();
                var metodo = $("#metodo").val();
                var usuario_gestion = $("#usuario_gestion").val();

                $(this).prop(
                    "href", "{{ route('admin.reportes.reportes_detalles_reclu_excel') }}?"+data_form+
                    "&formato=xlsx&fecha_inicio="+fecha_inicio+
                    "&fecha_final="+fecha_final+
                    "&ciudad_id="+ciudad_id+
                    "&departamento_id="+departamento_id+
                    "&pais_id="+pais_id+
                    "&usuario_gestion="+usuario_gestion+
                    "&metodo="+metodo
                );
            });

            /*$('#export_pdf_btn').click(function(e){
                var data_form = $('#filter_form').serialize();
                var fecha_inicio = $("#fecha_inicio").val();
                var fecha_final = $("#fecha_final").val();
                //var cliente_id = $("#cliente_id").val();
                //var criterio = $("#criterio").val();
                var ciudad_id=$("#ciudad_id").val();
                var departamento_id=$("#departamento_id").val();
                var pais_id=$("#pais_id").val();
                var agencia=$("#agencia").val();
                var metodo=$("#metodo").val();
                var usuario_gestion=$("#usuario_gestion").val();

                $(this).prop("href","{{ route('admin.reportes.reportes_detalles_excel') }}?"+$data_form+"&formato=pdf&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
            });*/

            $('#sitio_trabajo_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $(this).css("border-color","rgb(210,210,210)");
                    $("#error_ciudad_expedicion").hide();
                    $(this).css("border-color","rgb(210,210,210)");
                    $("#pais_id").val(suggestion.cod_pais);
                    $("#departamento_id").val(suggestion.cod_departamento);
                    $("#ciudad_id").val(suggestion.cod_ciudad);
                }
            });
        })
    </script>
@stop
