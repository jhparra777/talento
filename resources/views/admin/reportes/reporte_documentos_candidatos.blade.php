@extends("admin.layout.master")
@section('contenedor')
    <h3>
        <i aria-hidden="true" class="fa fa-file-text-o"></i>
        Reportes Documentos Cargados por Candidatos
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

    {!! Form::model(Request::all(),["route" => "admin.reportes_documentos_candidatos","method" => "GET","accept-charset" => "UTF-8"]) !!}
        <input type="hidden" id="generar_datos" name="generar_datos" value="generar">
        <div class="col-md-6 form-group">
            <label class="col-sm-3 control-label" for="req_id">
                Requerimiento:
            </label>
            <div class="col-sm-9">
                {!! Form::text("req_id", null, ["class" => "form-control", "placeholder" => "Nro de Requerimiento", "id" => "req_id" ]); !!}
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
            @include('admin.reportes.includes.grilla_detalle_doc_cand')
        @endif
    @endif

    <script>
        $(function () {
            $('#export_excel_btn').click(function(e){
                var data_form = $('#filter_form').serialize();
                var req_id = $("#req_id").val();

                $(this).prop(
                    "href", "{{ route('admin.reportes_documentos_candidatos_excel') }}?"+data_form+
                    "&formato=xlsx&req_id="+req_id
                );
            });
        })
    </script>
@stop
