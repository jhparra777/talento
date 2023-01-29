@extends("admin.layout.master")
@section('contenedor')
    <style >
        #req{ width: 300px !important; }
        .chosen-container .chosen-container-single{ width: 300px !important; }
    </style>

    <h3>
        <i aria-hidden="true" class="fa fa-file-text-o"></i>
        Reportes Detalle Llamadas
    </h3>
    
    <hr/>

    {!! Form::model(Request::all(), ["route" => "admin.reportes_llamadas_hechas", "method" => "GET", "accept-charset" => "UTF-8", "id" => "filter_form"]) !!}
        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                N° Req:
            </label>
        
            <div class="col-sm-10">
                {!! Form::select("req_id", $requerimientos, null, ["class" => "form-control chosen1", "id" => "req_id" ]); !!}
            </div>
        </div>

        @if(route("home") != "https://gpc.t3rsc.co")
            <div class="col-md-6 form-group">
                <label class="col-sm-2 control-label" for="inputEmail3">
                    Estado Candidato:
                </label>
                
                <div class="col-sm-10">
                    {!! Form::select("estado_candidato", array('' => 'Seleccionar ', 'EN PROCESO CONTRATACION' => 'EN PROCESO CONTRATACION','ACTIVO' => 'ACTIVO','RECLUTAMIENTO' => 'RECLUTAMIENTO', 'EN PROCESO SELECCION' => 'EN PROCESO SELECCION'), null, ["class" => "form-control","id" => "estado_candidato"]); !!}
                </div>
            </div>
        @endif

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Estado Req:
            </label>
        
            <div class="col-sm-10">
                {!! Form::select("estado_requerimiento",array('' => 'Seleccionar  ', 'EN PROCESO CONTRATACION' => 'EN PROCESO CONTRATACION','ACTIVO' => 'ACTIVO','RECLUTAMIENTO'=>'RECLUTAMIENTO','EN PROCESO SELECCION '=>'EN PROCESO SELECCION '),null,["class"=>"form-control","id"=>"estado_requerimiento"]); !!}
            </div>
        </div>
  
        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Usuario Gestión:
            </label>
        
            <div class="col-sm-10">
                {!! Form::select("usuario_gestion", $usuarios, null, ["class"=>"form-control","id"=>"usuario_gestion"]); !!}
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Ciudad Residencia
            </label>
        
            <div class="col-sm-10">
                {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                
                {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control","id"=>"ciudad_autocomplete","placheholder"=>"Digita cuidad"]) !!}
            </div>
        </div>

        <input id="formato" name="formato" type="hidden" value="html">
    
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
    
    <br><br>

    @if(isset($data))
        @include('admin.reportes.includes.grilla_detalle_llamada')
    @endif

    <script>
        $(".chosen1").chosen();

        $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });

        $(function () {
            $("#fecha_actualizacion_fin").datepicker(confDatepicker);
            $("#fecha_actualizacion_ini").datepicker(confDatepicker);

            $('#export_excel_btn').click(function(e){
                @if(route("home") == "https://gpc.t3rsc.co")
                    $data_form = $('#filter_form').serialize();
                
                    //$estado_candidato = $("#estado_candidato").val();
                    $req_id = $("#req_id").val();
                    $departamento_id = $("#departamento_id").val();
                    $ciudad_id = $("#ciudad_id").val();

                    $(this).prop("href","{{ route('admin.reportes.reportes_llamada_excel') }}?"+$data_form+"&formato=xlsx&departamento_id="+$departamento_id+"&ciudad_id="+$ciudad_id+"&estado_candidato=&req_id="+$req_id);
                @else
                    $data_form = $('#filter_form').serialize();
                
                    $estado_candidato = $("#estado_candidato").val();
                    $req_id = $("#req_id").val();
                    $departamento_id = $("#departamento_id").val();
                    $ciudad_id = $("#ciudad_id").val();

                    $(this).prop("href","{{ route('admin.reportes.reportes_llamada_excel') }}?"+$data_form+"&formato=xlsx&departamento_id="+$departamento_id+"&ciudad_id="+$ciudad_id+"&estado_candidato="+$estado_candidato+"&req_id="+$req_id);
                @endif
            });

            $('#export_pdf_btn').click(function(e){
                $data_form = $('#filter_form').serialize();
                $fecha_inicio = $("#fecha_inicio").val();
                $fecha_final = $("#fecha_final").val();
                $cliente_id = $("#cliente_id").val();
                $criterio = $("#criterio").val();

                $(this).prop("href","{{ route('admin.reportes.reportes_detalles_excel') }}?"+$data_form+"&formato=pdf&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
            });
        })
    </script>
@stop
