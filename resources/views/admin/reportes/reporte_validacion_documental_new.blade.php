@extends("admin.layout.master")
@section('contenedor')
<style>
    .pagination{ margin: 0 !important; }

    .mb-1{ margin-bottom: 1rem; }
    .mb-2{ margin-bottom: 2rem; }
    .mb-3{ margin-bottom: 3rem; }
    .mb-4{ margin-bottom: 4rem; }
</style>

    {{-- Header --}}
    @include('req.layout.includes._section_header_breadcrumb', ['page_header' => "Reporte Validación Documental"])

    <div class="row">
        @if(Session::has("mensaje_success"))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alerta!</h4>
                {{Session::get("mensaje_success")}}
            </div>
        @endif

        {!! Form::model(Request::all(),["route" => "admin.reportes_validacion_documental", "id" => "filter_form", "method" => "GET", "accept-charset" => "UTF-8"]) !!}
        
            <input type="hidden" id="generar_datos" name="generar_datos" value="generar">
            <input id="formato" name="formato" type="hidden" value="html"/>

            <div class="col-md-6 form-group">
                <label class="control-label" for="rango_fecha">
                    Rango de Fecha de firma de contrato:
                </label>
                {!! Form::text("rango_fecha", null, ["class" => "form-control range | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "rango_fecha", "autocomplete" => "off"]); !!}
            </div>

            <div class="col-md-6 form-group">
                <label class="control-label" for="numero_id">
                    #Nro de Identificación:
                </label>
                    {!! Form::text("numero_id", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Nro de Identificación", "id" => "numero_id" ]); !!}
            </div>

            <div class="col-md-6 form-group">
                <label class="control-label" for="cliente_id">
                    Cliente:
                </label>
                {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"cliente_id"]); !!}
            </div>

            {{-- Botones --}}
            <div class="col-md-12 text-right mb-2">
                <button class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" type="submit">
                    Generar
                </button>
                <a class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" href="#" id="export_excel_btn" role="button">
                    <i aria-hidden="true" class="fa fa-file-excel-o"></i>
                    Excel
                </a>
                <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 " href="{{ route("admin.reportes_validacion_documental") }}" type="reset">Limpiar</a>
            </div>

        {!! Form::close() !!}
        @if(isset($data))
            @if($data!="vacio")
                @include('admin.reportes.includes.grilla_detalle_validacion_documental_new')
            @endif
        @endif
    </div>

    <script>
        $(function () {
            $('#export_excel_btn').click(function(e){
                var rango_fecha = $("#rango_fecha").val();
                var numero_id = $("#numero_id").val();
                var cliente_id = $("#cliente_id").val();

                $(this).prop(
                    "href", "{{ route('admin.reportes_validacion_documental_excel') }}?generar_datos=generar"+
                    "&formato=xlsx&numero_id="+numero_id+
                    "&rango_fecha="+rango_fecha+
                    "&cliente_id="+cliente_id
                );
            });
        })
    </script>
    
@stop