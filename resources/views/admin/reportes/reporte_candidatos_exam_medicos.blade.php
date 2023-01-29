@extends("admin.layout.master")
@section('contenedor')
    <h3>
        <i aria-hidden="true" class="fa fa-file-text-o"></i>
        Reporte Candidatos Enviados a Exámenes Médicos
    </h3>
    @if(Session::has("mensaje_warning"))
    <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get("mensaje_warning")}}
        </div>
    </div>
    @endif
    
    <hr/>

    {!! Form::model(Request::all(),["route" => "admin.reportes_enviados_exam_medicos", "method" => "GET", "id" => "filter_form", "accept-charset" => "UTF-8"]) !!}
        <input type="hidden" id="generar_datos" name="generar_datos" value="generar">
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-6 control-label" for="rango_fecha">
                    Rango de fecha envío a exámenes:
                </label>
                <div class="col-sm-6">
                    {!! Form::text("rango_fecha", null, ["class" => "form-control range", "id" => "rango_fecha", "autocomplete" => "off"]); !!}
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label class="col-sm-6 control-label" for="candidatos_archivos">
                    Candidatos con exámenes realizados:
                </label>
                <div class="col-sm-6">
                    {!!Form::checkbox("candidatos_archivos",1,null,["id"=>"candidatos_archivos"])!!}
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
            @include('admin.reportes.includes.grilla_detalle_cand_exam_med')
        @endif
    @endif

    <script>
        $(function () {
            $('#export_excel_btn').click(function(e){
                var rango_fecha = $("#rango_fecha").val();
                var candidatos_archivos = ($('#candidatos_archivos').prop('checked') ? $('#candidatos_archivos').val() : '');

                $(this).prop(
                    "href", "{{ route('admin.reportes_enviados_exam_medicos_excel') }}?generar_datos=generar"+
                    "&candidatos_archivos="+candidatos_archivos+"&formato=xlsx&rango_fecha="+rango_fecha
                );
            });
        })
    </script>
@stop
