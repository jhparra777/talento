@extends("req.layout.master")
@section('contenedor')
<style>
    .pagination{ margin: 0 !important; }

    .mb-1{ margin-bottom: 1rem; }
    .mb-2{ margin-bottom: 2rem; }
    .mb-3{ margin-bottom: 3rem; }
    .mb-4{ margin-bottom: 4rem; }
</style>

    <div class="row">
        {{-- Header --}}
        @include('req.layout.includes._section_header_breadcrumb', ['page_header' => "Reporte detalle requerimiento"])
        @if(Session::has("mensaje_success"))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alerta!</h4>
                {{Session::get("mensaje_success")}}
            </div>
        @endif


        {!! Form::model(Request::all(),["route"=>"req.reporte","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
        
            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">Rango de Fecha:</label>
           
                {!! Form::text("rango_fecha",null,
                [
                    "class"=>"form-control range | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                    "id"=>"rango_fecha"
                ]); !!}
          
            </div>
            {{-- <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">Fecha Inicio:</label>
                {!! Form::text("fecha_inicio",null,["class"=>"form-control  | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Fecha Inicio","id"=>"fecha_inicio" ]); !!}             
            </div>
            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">Fecha Final:</label>               
                {!! Form::text("fecha_final",null,["class"=>"form-control  | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Fecha Final","id"=>"fecha_final" ]); !!}               
            </div> --}}
            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">Cliente:</label>
                {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control js-example-basic-single | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"cliente_id"]); !!}
            </div>
            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">Criterio:</label>
                {!! Form::select("criterio",$criterios,null,["class"=>"form-control js-example-basic-single | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300l","id"=>"criterio" ]); !!}
                <input id="formato" name="formato" type="hidden" value="html"/>
            </div>
            <div class="col-md-12 text-right mb-2">
                <button class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" type="submit">Generar</button>
                <a class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" href="#" id="export_excel_btn" role="button">
                    <i aria-hidden="true" class="fa fa-file-excel-o"></i>Excel</a>
                <a class="btn btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-300" href="{{route("req_index")}}">Volver</a>
            </div>
            {!! Form::close() !!}
            
            @if(isset($data))
                @include('req.grilla')
            @endif
    </div>
<!--
<a class="btn btn-danger" href="#" id="export_pdf_btn" role="button">
    <i aria-hidden="true" class="fa fa-file-pdf-o">
    </i>
    PDF
</a>
-->


<script>
    $(function () {
      var confDatepicker = {
    altFormat: "yy-mm-dd",
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    buttonImage: "img/gifs/018.gif",
    buttonImageOnly: true,
    autoSize: true,
    dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
    monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
    yearRange: "1930:2050"
};
      $("#fecha_inicio, #fecha_final").datepicker(confDatepicker);

      $('#export_excel_btn').click(function(e){
          $data_form = $('#filter_form').serialize();
          $fecha_inicio = $("#fecha_inicio").val();
          $fecha_final = $("#fecha_final").val();
          $cliente_id = $("#cliente_id").val();
          $criterio = $("#criterio").val();

          $(this).prop("href","{{ route('req.reportes.reportes_detalles_excel_req') }}?"+$data_form+"&formato=xlsx&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
      });
      $('#export_pdf_btn').click(function(e){
          $data_form = $('#filter_form').serialize();
          $fecha_inicio = $("#fecha_inicio").val();
          $fecha_final = $("#fecha_final").val();
          $cliente_id = $("#cliente_id").val();
          $criterio = $("#criterio").val();

          $(this).prop("href","{{ route('admin.reportes.reportes_detalles_excel') }}?"+$data_form+"&formato=pdf&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
      });
    })
</script>
@stop
