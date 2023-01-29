@extends("admin.layout.master")
@section('contenedor')
    <h3>
        <i aria-hidden="true" class="fa fa-file-text-o"></i>
        Reporte Validación Documental
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

    {!! Form::model(Request::all(),["route" => "admin.validacion_documental_vencimiento", "id" => "filter_form", "method" => "GET", "accept-charset" => "UTF-8"]) !!}
        <input type="hidden" id="generar_datos" name="generar_datos" value="generar">
        <input id="formato" name="formato" type="hidden" value="html"/>
        
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-5 control-label" for="rango_fecha">
                    Rango de Fecha de firma de contrato:
                </label>
                <div class="col-sm-7">
                    {!! Form::text("rango_fecha", null, ["class" => "form-control range", "id" => "rango_fecha", "autocomplete" => "off"]); !!}
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label class="col-sm-5 control-label" for="numero_id">
                    #Nro de Identificación:
                </label>
                <div class="col-sm-7">
                    {!! Form::text("numero_id", null, ["class" => "form-control", "placeholder" => "Nro de Identificación", "id" => "numero_id" ]); !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-5 control-label" for="cliente_id">
                    Cliente:
                </label>
                <div class="col-sm-7">
                    {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control","id"=>"cliente_id"]); !!}
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label class="col-sm-5 control-label" for="rango_fecha_vencimiento">
                    Rango de Fecha de vencimiento:
                </label>
                <div class="col-sm-7">
                    {!! Form::text("rango_fecha_vencimiento", null, ["class" => "form-control range", "id" => "rango_fecha_vencimiento", "autocomplete" => "off"]); !!}
                </div>
            </div>
        </div>
    
        <div class="clearfix"></div>
        
        <button class="btn btn-success" type="submit">
            Generar
        </button>
        
        <a class="btn btn-success" href="#" id="export_excel_btn" role="button">
            <i aria-hidden="true" class="fa fa-file-excel-o"></i>
            Excel
        </a>
        <a class="btn btn-danger" href="{{ route('admin.validacion_documental_vencimiento') }}">Limpiar</a>
        
    {!! Form::close() !!}

    @if(isset($data))
        @if($data!="vacio")
            @include('admin.reportes.validacion_documental.include.grilla_validacion_documental')
        @endif
    @endif

    <script>
        $(function () {
            $('#export_excel_btn').click(function(e){
                var rango_fecha = $("#rango_fecha").val();
                var rango_fecha_vencimiento = $("#rango_fecha_vencimiento").val();
                var numero_id = $("#numero_id").val();
                var cliente_id = $("#cliente_id").val();

                $(this).prop(
                    "href", "{{ route('admin.validacion_documental_vencimiento_excel') }}?generar_datos=generar"+
                    "&formato=xlsx&numero_id="+numero_id+
                    "&rango_fecha_vencimiento="+rango_fecha_vencimiento+
                    "&rango_fecha="+rango_fecha+
                    "&cliente_id="+cliente_id
                );
            });
        })
    </script>
@stop
