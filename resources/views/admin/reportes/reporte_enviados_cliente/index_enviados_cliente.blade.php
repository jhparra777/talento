@extends("admin.layout.master")
@section('contenedor')
    <h3>
        <i aria-hidden="true" class="fa fa-file-text-o"></i>
        Reporte de Candidatos enviados a Clientes
    </h3>
    @if(Session::has("mensaje_warning"))
    <div class="row">
    <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get("mensaje_warning")}}
        </div>
    </div>
    </div>
    @endif
    <br>
    {!! Form::model(Request::all(),["route" => "admin.reporte_enviados_cliente","method" => "GET","accept-charset" => "UTF-8"]) !!}
        <input type="hidden" id="generar_datos" name="generar_datos" value="generar">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="control-label" for="rango_requerimiento">
                    Rango de fechas de creación del requerimiento:
                </label>
                {!! Form::text("rango_requerimiento", null, ["class" => "form-control range", "id" => "rango_requerimiento", "autocomplete" => "off"]); !!}
            </div>

            <div class="col-md-6 form-group">
                <label class="control-label" for="rango_enviados">
                    Rango de fechas de envío al cliente:
                </label>
                {!! Form::text("rango_enviados", null, ["class" => "form-control range", "id" => "rango_enviados", "autocomplete" => "off"]); !!}
            </div>
        </div>
    
        <div class="clearfix"></div>
        
        <input id="formato" name="formato" type="hidden" value="html"/>
        <button class="btn btn-success" type="submit" style="margin-right: 0.5rem;">
            Generar
        </button>
        
        <a class="btn btn-success" href="#" id="export_excel_btn" role="button" style="margin-right: 0.5rem;">
            <i aria-hidden="true" class="fa fa-file-excel-o"></i>
            Excel
        </a>
        
        <a class="btn btn-warning" href="{{ route('admin.reporte_enviados_cliente') }}">
            Limpiar
        </a>
    {!! Form::close() !!}

    @if(isset($data))
        @if($data!="vacio")
            @include('admin.reportes.reporte_enviados_cliente.include.grilla_enviados_cliente')
        @endif
    @endif

    <script>
        $(function () {
            $('#export_excel_btn').click(function(e){
                var rango_enviados = $("#rango_enviados").val();
                var rango_requerimiento = $("#rango_requerimiento").val();

                $(this).prop(
                    "href", "{{ route('admin.reporte_enviados_cliente_excel') }}?generar_datos=generar"+
                    "&formato=xlsx"+
                    "&rango_enviados="+rango_enviados+
                    "&rango_requerimiento="+rango_requerimiento
                );
            });
        })
    </script>
@stop
