@extends("admin.layout.master")
@section('contenedor')
    <h3>
        <i aria-hidden="true" class="fa fa-file-text-o"></i>
        Reporte de candidatos descartados
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
    {!! Form::model(Request::all(),["route" => "admin.reporte_candidatos_descartados","method" => "GET", "id" =>"form-reporte", "accept-charset" => "UTF-8"]) !!}
        <input type="hidden" id="generar_datos" name="generar_datos" value="generar">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="rango_fecha">
                        Rango de fechas de creación del requerimiento:
                    </label>
                    {!! Form::text("rango_fecha", null, ["class" => "form-control range", "id" => "rango_fecha", "autocomplete" => "off", "required" => "required"]); !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label" for="motivo_descarte_id">
                        Motivo descarte:
                    </label>
                    {!! Form::select("motivo_descarte_id", $motivos_descarte, null, ["class" => "form-control", "id" => "motivo_descarte_id", "autocomplete" => "off"]); !!}
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
        
        <a class="btn btn-warning" href="{{ route('admin.reporte_candidatos_descartados') }}">
            Limpiar
        </a>
    {!! Form::close() !!}

    @if(isset($data))
        @if($data!="vacio")
            @include('admin.reportes.candidatos_descartados.include.grilla_candidatos_descartados')
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
                if ($("#rango_fecha").smkValidate()){
                    var motivo_descarte_id = $("#motivo_descarte_id").val();
                    var rango_fecha = $("#rango_fecha").val();

                    $(this).prop(
                        "href", "{{ route('admin.reporte_candidatos_descartados_excel') }}?generar_datos=generar"+
                        "&formato=xlsx"+
                        "&motivo_descarte_id="+motivo_descarte_id+
                        "&rango_fecha="+rango_fecha
                    );
                }
            });
        })
    </script>
@stop
