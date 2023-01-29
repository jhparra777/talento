@extends("admin.layout.master")
@section('contenedor')
    <h3>
        <i aria-hidden="true" class="fa fa-file-text-o"></i>
        Reporte de Entidades
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
    {!! Form::model(Request::all(),["route" => "admin.reportes_entidades","method" => "GET","accept-charset" => "UTF-8"]) !!}
        <input type="hidden" id="generar_datos" name="generar_datos" value="generar">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-6 control-label" for="rango_fecha">
                    Rango de fechas de firma de contrato:
                </label>
                <div class="col-sm-6">
                    {!! Form::text("rango_fecha", null, ["class" => "form-control range", "id" => "rango_fecha", "autocomplete" => "off"]); !!}
                </div>
            </div>

            
            <div class="col-md-6 form-group">
                <label class="col-sm-6 control-label" for="req_id">
                    Requerimiento:
                </label>
                <div class="col-sm-6">
                    {!! Form::text("req_id", null, ["class" => "form-control", "placeholder" => "Nro de Requerimiento", "id" => "req_id" ]); !!}
                </div>
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
        
    {!! Form::close() !!}

    @if(isset($data))
        @if($data!="vacio")
            @include('admin.reportes.includes.grilla_detalle_entidades')
        @endif
    @endif

    <script>
        $(function () {
            $('#export_excel_btn').click(function(e){
                var req_id = $("#req_id").val();
                var rango_fecha = $("#rango_fecha").val();

                $(this).prop(
                    "href", "{{ route('admin.reportes_entidades_excel') }}?generar_datos=generar"+
                    "&formato=xlsx&req_id="+req_id+
                    "&rango_fecha="+rango_fecha
                );
            });
        })
    </script>
@stop
