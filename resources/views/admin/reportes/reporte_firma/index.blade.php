@extends("admin.layout.master")
@section('contenedor')
    <h3>
        <i aria-hidden="true" class="fa fa-file-text-o"></i>
        Reporte contratación virtual
    </h3>
    @if(Session::has("mensaje_warning"))
    <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get("mensaje_warning")}}
        </div>
    </div>
    @endif

    {!! Form::model(Request::all(), ["route" => "admin.reporte_firma_digital", "method" => "GET", "accept-charset" => "UTF-8", "id" => "reportes"]) !!}
        <input type="hidden" id="generar_datos" name="generar_datos" value="generar">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-5 control-label" for="rango_fecha">Rango de fechas de envío a contratación:</label>
                <div class="col-sm-7">
                    {!! Form::text("rango_fecha", null, ["class" => "form-control range","id" => "rango_fecha" , "autocomplete" => "off"]); !!}
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label class="col-sm-5 control-label" for="rango_fecha_firma">Rango de fechas de firma de contrato:</label>
                <div class="col-sm-7">
                    {!! Form::text("rango_fecha_firma", null, ["class" => "form-control range","id" => "rango_fecha_firma" , "autocomplete" => "off"]); !!}
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label class="col-sm-5 control-label" for="rango_fecha">Rango de fechas de ingreso:</label>
                <div class="col-sm-7">
                    {!! Form::text("rango_fecha_ingreso", null, ["class" => "form-control range","id" => "rango_fecha_ingreso" , "autocomplete" => "off"]); !!}
                </div>
            </div>
        </div>
    <br>

        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-2 control-label" for="num_req">Num req:</label>
    
                <div class="col-sm-10">
                    {!! Form::number("num_req", null, ["class" => "form-control", "id" => "num_req", "placeholder" => "Número requerimiento"]); !!}
                </div>
            </div>
    
            <div class="col-md-6 form-group">
                <label class="col-sm-2 control-label" for="cliente_id">Cliente:</label>
    
                <div class="col-sm-10">
                    {!! Form::select("cliente_id", $clientes, null, ["class" => "form-control", "id" => "cliente_id"]); !!}
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-2 control-label" for="usuario_gestion">Usuario gestión:</label>
                
                <div class="col-sm-10">
                    {!! Form::select("usuario_gestion", $usuarios, null, ["class" => "form-control", "id" => "usuario_gestion"]); !!}
                </div>
            </div>
    
            <div class="col-md-6 form-group">
                <label class="col-sm-2 control-label" for="agencia">Agencia:</label>
    
                <div class="col-sm-10">
                    {!! Form::select("agencia", $agencias, null, ["class" => "form-control", "id" => "agencia"]); !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-2 control-label" for="video_confirmacion">Video confirmación:</label>
    
                <div class="col-sm-10">
                    {!! Form::select("video_confirmacion", ["" => "Seleccionar", "1" => "Si", "0" => "No"], null, ["class" => "form-control", "id" => "video_confirmacion"]); !!}
                </div>
            </div>
    
            <div class="col-md-6 form-group">
                <label class="col-sm-2 control-label" for="estado_contrato">Estado contrato:</label>
    
                <div class="col-sm-10">
                    {!! Form::select("estado_contrato", [
                            "" => "Seleccionar",
                            "1" => "Firmado",
                            "2" => "Firmado manualmente",
                            "3" => "Firmado sin videos",
                            "0" => "Cancelado por candidato",
                            "5" => "Anulado",
                        ], null, ["class" => "form-control", "id" => "estado_contrato"]);
                    !!}
                </div>
            </div>
        </div>

        <input id="formato" name="formato" type="hidden" value="html"/>

        <button class="btn btn-success" type="submit">Generar</button>

        <a class="btn btn-success" href="#" id="export_excel_btn" role="button">
            <i aria-hidden="true" class="fa fa-file-excel-o"></i>
            Excel
        </a>

        <a class="btn btn-warning" href="{{ route('admin.reporte_firma_digital') }}">
            Limpiar
        </a>
    {!! Form::close() !!}

    @if(!empty($data))
        @include('admin.reportes.reporte_firma.include.grilla_detalle_firmas')
    @endif

    <script>
        $(function () {
            $('#cliente_id').on("change", function (e) {
                var id = $(this).val();

                $.ajax({
                    url: "{{ route('admin.cargos_dependiendo_cliente') }}",
                    type: 'GET',
                    data: {clt_codigo: id}
                })
                .done(function (response) {
                    $('#cargos_esp').html('');

                    $('#cargos_esp').append("<option value=''>....Seleccione </option>");

                    $.each(response,function(index, el) {

                        $('#cargos_esp').append("<option value='"+index+"'>"+el+" </option>")
                        
                    });
                });
            });

            $('#ciudad_autocomplete').autocomplete({
                serviceUrl: '{{route("autocomplete_cuidades")}}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#pais_id").val(suggestion.cod_pais);
                    $("#departamento_id").val(suggestion.cod_departamento);
                    $("#ciudad_id").val(suggestion.cod_ciudad);
                }
            });

            $('#export_excel_btn').click(function(e){
                $rango_fecha = $("#rango_fecha").val();
                $rango_fecha_ingreso = $("#rango_fecha_ingreso").val();
                $rango_fecha_firma = $("#rango_fecha_firma").val();
                $num_req = $('#num_req').val();
                $cliente_id = $('#cliente_id').val();
                $usuario_gestion = $('#usuario_gestion').val();
                $agencia = $('#agencia').val();
                $video_confirmacion = $('#video_confirmacion').val();
                $estado_contrato = $('#estado_contrato').val();

                $(this).prop(
                    "href",
                    "{{ route('admin.reportes.reportes_fima_digital_excel') }}?generar_datos=generar_excel"+
                    "&formato=xlsx&rango_fecha="+$rango_fecha+
                    "&rango_fecha_ingreso="+$rango_fecha_ingreso+
                    "&rango_fecha_firma="+$rango_fecha_firma+
                    "&num_req="+$num_req+
                    "&cliente_id="+$cliente_id+
                    "&usuario_gestion="+$usuario_gestion+
                    "&agencia="+$agencia+
                    "&video_confirmacion="+$video_confirmacion+
                    "&estado_contrato="+$estado_contrato);
            });
        })
    </script>
@stop
