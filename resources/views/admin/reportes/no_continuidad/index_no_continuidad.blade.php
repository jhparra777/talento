@extends("admin.layout.master")
@section('contenedor')
    <h3>
        <i aria-hidden="true" class="fa fa-file-text-o"></i>
        Reporte no continuidad de candidatos
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
    {!! Form::model(Request::all(),["route" => "admin.reporte_no_continuidad","method" => "GET", "id" =>"form-reporte", "accept-charset" => "UTF-8"]) !!}
        <input type="hidden" id="generar_datos" name="generar_datos" value="generar">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="rango_fecha">
                        Rango de fecha de creación del requerimiento:
                    </label>
                    {!! Form::text("rango_fecha", null, ["class" => "form-control range", "id" => "rango_fecha", "autocomplete" => "off"]); !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="cliente_id">
                        Cliente:
                    </label>
                    {!! Form::select("cliente_id", ['' => 'Seleccionar'] + $clientes->pluck('nombre', 'id')->toArray(), null, ["class" => "form-control", "id" => "cliente_id", "autocomplete" => "off"]); !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="requerimiento_id">
                        Requerimiento:
                    </label>
                    {!! Form::text("requerimiento_id", null, ["class" => "form-control", "id" => "requerimiento_id"]); !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="proceso">
                        Proceso:
                    </label>
                    {!! Form::select("proceso", ['' => 'Seleccionar'] + $columnas_procesos_all->pluck('nombre_visible', 'nombre_trazabilidad')->toArray(), null, ["class" => "form-control", "id" => "proceso", "autocomplete" => "off"]); !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="estado_proceso">
                        Estado proceso:
                    </label>
                    {!! Form::select("estado_proceso", ['' => 'Seleccionar', '1' => 'Apto', '0' => 'No apto', '3' => 'Pendiente'], null, ["class" => "form-control", "id" => "estado_proceso", "autocomplete" => "off"]); !!}
                </div>
            </div>
        </div>
    
        <div class="clearfix"></div>
        
        <input id="formato" name="formato" type="hidden" value="html"/>
        <button class="btn btn-success" id="btn_submit" type="submit" style="margin-right: 0.5rem;">
            Generar
        </button>
        
        <a class="btn btn-success" href="#" id="export_excel_btn" role="button" style="margin-right: 0.5rem;">
            <i aria-hidden="true" class="fa fa-file-excel-o"></i>
            Excel
        </a>
        
        <a class="btn btn-warning" href="{{ route('admin.reporte_no_continuidad') }}">
            Limpiar
        </a>
    {!! Form::close() !!}

    @if(isset($data))
        @if($data!="vacio")
            @include('admin.reportes.no_continuidad.include.grilla_no_continuidad')
        @endif
    @endif

    <script>
        $(function () {
            $('#btn_submit').click(function(e) {
                e.preventDefault();
                if ($('#form-reporte').smkValidate()) {
                    $('#form-reporte').submit();
                }
            });

            $('#export_excel_btn').click(function(e){
                var cliente_id = $("#cliente_id").val();
                var requerimiento_id = $("#requerimiento_id").val();
                var proceso = $("#proceso").val();
                var estado_proceso = $("#estado_proceso").val();
                var rango_fecha = $("#rango_fecha").val();

                $(this).prop(
                    "href", "{{ route('admin.reporte_no_continuidad_excel') }}?generar_datos=generar"+
                    "&formato=xlsx"+
                    "&cliente_id="+cliente_id+
                    "&requerimiento_id="+requerimiento_id+
                    "&proceso="+proceso+
                    "&estado_proceso="+estado_proceso+
                    "&rango_fecha="+rango_fecha
                );
            });
        })
    </script>
@stop
