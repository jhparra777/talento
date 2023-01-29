@extends("admin.layout.master")
@section('contenedor')
    <h3>
        <i aria-hidden="true" class="fa fa-file-text-o"></i>
        Reporte contratos a término fijo
    </h3>
    @if(Session::has("mensaje_warning"))
    <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get("mensaje_warning")}}
        </div>
    </div>
    @endif

    {!! Form::model(Request::all(), ["route" => "admin.reporte_contratos_termino_fijo", "method" => "GET", "accept-charset" => "UTF-8", "id" => "reportes"]) !!}
        <input type="hidden" id="generar_datos" name="generar_datos" value="generar">
        <div class="row">
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

        <div class="row">

            <div class="col-md-6 form-group">
                <label class="col-sm-5 control-label" for="rango_fecha_fin_contrato">Rango de fechas fin contrato:</label>
                <div class="col-sm-7">
                    {!! Form::text("rango_fecha_fin_contrato", null, ["class" => "form-control range","id" => "rango_fecha_fin_contrato" , "autocomplete" => "off"]); !!}
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label class="col-sm-5 control-label" for="notificacion_enviada">
                    ¿Notificación enviada?
                </label>
                <div class="col-sm-7">
                    {!! Form::select("notificacion_enviada", ["" => "Seleccionar", "0" => "No", "1" => "Si"],null,["class"=>"selectpicker form-control","id"=>"notificacion_enviada"]); !!}
                </div>
            </div>
        </div>
    <br>

        <input id="formato" name="formato" type="hidden" value="html"/>

        <button class="btn btn-success" type="submit">Generar</button>

        <a class="btn btn-success" href="#" id="export_excel_btn" role="button">
            <i aria-hidden="true" class="fa fa-file-excel-o"></i>
            Excel
        </a>

        <a class="btn btn-warning" href="{{ route('admin.reporte_contratos_termino_fijo') }}">
            Limpiar
        </a>
    {!! Form::close() !!}

    @if(!empty($data))
        @include('admin.reportes.contratos_termino_fijo.grilla_detalle')
    @endif

    <script>
        $(function () {
            $('#export_excel_btn').click(function(e){
                $rango_fecha_fin_contrato = $("#rango_fecha_fin_contrato").val();
                $rango_fecha_ingreso = $("#rango_fecha_ingreso").val();
                $rango_fecha_firma = $("#rango_fecha_firma").val();
                var notificacion_enviada = $("#notificacion_enviada").val();

                $(this).prop(
                    "href",
                    "{{ route('admin.reporte_contratos_termino_fijo_excel') }}?generar_datos=generar_excel"+
                    "&formato=xlsx&rango_fecha_fin_contrato="+$rango_fecha_fin_contrato+
                    "&rango_fecha_ingreso="+$rango_fecha_ingreso+
                    "&rango_fecha_firma="+$rango_fecha_firma+
                    "&notificacion_enviada="+notificacion_enviada);
            });
        })
    </script>
@stop
