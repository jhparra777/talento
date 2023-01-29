@extends("req.layout.master")
@section('contenedor')

<style>
    .pagination{ margin: 0 !important; }

    .mb-1{ margin-bottom: 1rem; }
    .mb-2{ margin-bottom: 2rem; }
    .mb-3{ margin-bottom: 3rem; }
    .mb-4{ margin-bottom: 4rem; }
</style>

    {{-- Header --}}
    @include('req.layout.includes._section_header_breadcrumb', ['page_header' => "Reporte Aprobación"])

    <div class="row">
        @if(Session::has("mensaje_success"))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alerta!</h4>
                {{Session::get("mensaje_success")}}
            </div>
        @endif

        {!! Form::model(Request::all(),["route"=>"req.reporte_contratados_cliente","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
            
            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">Rango Fecha contratación:</label>
        
                {!! Form::text("rango_fecha",null,
                [
                    "class"=>"form-control range | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                    "id"=>"rango_fecha"
                ]); !!}
        
            </div>
            {{-- <div class="col-md-6 form-group">
                <label for="inputEmail3" class="control-label">Fecha de contratación:</label>
                {!! Form::text("fecha_inicio",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Desde","id"=>"fecha_inicio" ]); !!}
            </div>

            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="control-label">Fecha de fin de contratación:</label>
                {!! Form::text("fecha_final",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Hasta","id"=>"fecha_final" ]); !!}
            </div> --}}

            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="control-label">Usuario contrata:</label>
                {!! Form::select("usuario_envio",$usuarios_envio,null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"usuario_envio"]); !!}
            </div>

            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="control-label">Usuario que aprueba:</label>
                {!! Form::select("usuario_aprueba",$usuarios_aprueba,null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"usuario_aprueba"]); !!}
            </div>

            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="control-label">#Req:</label>
                {!! Form::text("req_id",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Número de requerimiento","id"=>"req_id" ]); !!}
            </div>

            {{-- Botones --}}
            <div class="col-md-12 text-right mb-2">
                <input id="formato" name="formato" type="hidden" value="html"/>
                <button class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" type="submit">
                    Generar
                </button>
                <a class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" href="#" id="export_excel_btn" role="button">
                    <i aria-hidden="true" class="fa fa-file-excel-o"></i>
                    Excel
                </a>
                {{-- <button class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" type="submit">Buscar <i class='fa fa-search' aria-hidden='true'></i></button>
                <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 " href="{{route("req.usuarios")}}" type="reset">Limpiar</a> --}}
            </div>

        {!! Form::close() !!}

        @if(isset($data))
        @if($data!="vacio")
            @include('admin.reportes.includes.grilla_detalle_reportes_contratados')
        @endif
    </div>

@endif







{{-- <h3>
    <i aria-hidden="true" class="fa fa-file-text-o">
    </i>
    Reporte Aprobación
</h3>
<hr/>
{!! Form::model(Request::all(),["route"=>"req.reporte_contratados_cliente","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
  <fieldset style="background: #f5f5f5;">
  
  <div class="col-md-6 form-group">
      <label class="col-sm-2 control-label" for="inputEmail3">
          Fecha de contratación
      </label>
      <div class="col-sm-10">
          {!! Form::text("fecha_inicio",null,["class"=>"form-control","placeholder"=>"Desde","id"=>"fecha_inicio" ]); !!}
      </div>
  </div>
  <div class="col-md-6 form-group">
      <label class="col-sm-2 control-label" for="inputEmail3">
         
      </label>
      <div class="col-sm-10">
          {!! Form::text("fecha_final",null,["class"=>"form-control","placeholder"=>"Hasta","id"=>"fecha_final" ]); !!}
      </div>
  </div>
</fieldset>

<div class="col-md-6 form-group">
    <label class="col-sm-2 control-label" for="inputEmail3">
        Usuario contrata:
    </label>
    <div class="col-sm-10">
        {!! Form::select("usuario_envio",$usuarios_envio,null,["class"=>"form-control","id"=>"usuario_envio"]); !!}
    </div>
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-2 control-label" for="inputEmail3">
        Usuario que aprueba:
    </label>
    <div class="col-sm-10">
        {!! Form::select("usuario_aprueba",$usuarios_aprueba,null,["class"=>"form-control","id"=>"usuario_aprueba"]); !!}
    </div>
</div>
<div class="col-md-6 form-group">
      <label class="col-sm-2 control-label" for="inputEmail3">
          #Req:
      </label>
      <div class="col-sm-10">
          {!! Form::text("req_id",null,["class"=>"form-control","placeholder"=>"Número de requerimiento","id"=>"req_id" ]); !!}
      </div>
  </div> --}}

  {{--<div class="col-md-6 form-group">
    <label class="col-sm-2 control-label" for="inputEmail3">
        Fuente de Reclutamiento
    </label>
    <div class="col-sm-10">
        {!! Form::select("tipo_fuente_id",$fuentes,null,["class"=>"form-control","id"=>"tipo_fuente_id"]); !!}
    </div>
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-2 control-label" for="inputEmail3">
        Ciudad Residencia
    </label>
     <div class="col-sm-10">
     
                    {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                    {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                    {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                    {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control","id"=>"ciudad_autocomplete","placheholder"=>"Digita cuidad"]) !!}
    </div>
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-2 control-label" for="inputEmail3">

        Edad Inicial :
    </label>
     <div class="col-sm-10">
        {!! Form::number("edad_inicial",null,[ "id"=>"edad_inicial", "class"=>"form-control","placeholder"=>"Escriba la edad inical" ]); !!}

    </div>
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-2 control-label" for="inputEmail3">

        Edad Final :
    </label>
     <div class="col-sm-10">
        {!! Form::number("edad_final",null,[ "id"=>"edad_final", "class"=>"form-control","placeholder"=>"Escriba la edad final" ]); !!}
    </div>
</div>

 
<div class="col-md-6 form-group">
    <label class="col-sm-2 control-label" for="inputEmail3">
        Género:
    </label>
    <div class="col-sm-10">
        {!! Form::select("genero_id",$generos,null,["class"=>"form-control","id"=>"genero_id"]); !!}
    </div>
</div>



<div class="col-md-6 form-group">
    <label class="col-sm-2 control-label" for="inputEmail3">
       Fecha inicial
    </label>
    <div class="col-sm-10">
        {!! Form::text("fecha_actualizacion_ini",null,["class"=>"form-control","placeholder"=>"Fecha inicial","id"=>"fecha_actualizacion_ini" ]); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_actualizacion_ini",$errors) !!}</p>
    </div>
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-2 control-label" for="inputEmail3">
       Fecha Final
    </label>
    <div class="col-sm-10">
        {!! Form::text("fecha_actualizacion_fin",null,["class"=>"form-control","placeholder"=>"Fecha final","id"=>"fecha_actualizacion_fin" ]); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_actualizacion_fin",$errors) !!}</p>
    </div>
</div>
--}}
{{-- <input id="formato" name="formato" type="hidden" value="html"/>
<button class="btn btn-success" type="submit">
    Generar
</button>
<a class="btn btn-success" href="#" id="export_excel_btn" role="button">
    <i aria-hidden="true" class="fa fa-file-excel-o">
    </i>
    Excel
</a> --}}
<!--
<a class="btn btn-danger" href="#" id="export_pdf_btn" role="button">
    <i aria-hidden="true" class="fa fa-file-pdf-o">
    </i>
    PDF
</a>
-->
{{-- {!! Form::close() !!}
<br><br>
@if(isset($data))
  @if($data!="vacio")
   @include('admin.reportes.includes.grilla_detalle_reportes_contratados')
  @endif
@endif --}}

<script>
//    $('#ciudad_autocomplete').autocomplete({
//             serviceUrl: '{{ route("autocomplete_cuidades") }}',
//             autoSelectFirst: true,
//             onSelect: function (suggestion) {
//                 $("#pais_id").val(suggestion.cod_pais);
//                 $("#departamento_id").val(suggestion.cod_departamento);
//                 $("#ciudad_id").val(suggestion.cod_ciudad);
//             }
//         });

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
      $("#fecha_inicio").datepicker(confDatepicker);
      $("#fecha_final").datepicker(confDatepicker);

      jQuery(document).on('change', '#fecha_inicio', (event) => {
                const element = event.target;
            
                jQuery('#fecha_final').datepicker('option', 'minDate', element.value);
            });

      /*$('#export_excel_btn').click(function(e){
          $data_form = $('#filter_form').serialize();
          $palabra_clave = $('#palabra_clave').val();
          $fecha_actualizacion_ini = $("#fecha_actualizacion_ini").val();
          $fecha_actualizacion_fin = $("#fecha_actualizacion_fin").val();
          $genero_id = $("#genero_id").val();
          $tipo_fuente_id = $("#tipo_fuente_id").val();
          $edad_inicial = $("#edad_inicial").val();
          $edad_final = $("#edad_final").val();
          $departamento_id = $("#departamento_id").val();
          $ciudad_id = $("#ciudad_id").val();


          $(this).prop("href","{{ route('admin.reportes_contratados_cliente_excel')}}?"+$data_form+"&formato=xlsx&palabra_clave="+$palabra_clave+"&tipo_fuente_id="+$tipo_fuente_id+"&genero_id="+$genero_id+"&fecha_actualizacion_ini="+$fecha_actualizacion_ini+"&fecha_actualizacion_fin="+$fecha_actualizacion_fin+"&edad_inicial"+$edad_inicial+"&edad_final="+$edad_final+"&departamento_id="+$departamento_id+"&ciudad_id="+$ciudad_id);
      });*/
      $('#export_excel_btn').click(function(e){
          var data_form = $('#filter_form').serialize();
          var rango_fecha = $("#rango_fecha").val();
        //   $fecha_final = $("#fecha_final").val();
         
          //$usuario_envio = $("#usuario_envio").val();
          //$usuario_aprueba = $("#usuario_aprueba").val();
          var req_id = $("#req_id").val();


          //$(this).prop("href","{{ route('admin.reportes_contratados_cliente_excel')}}?"+$data_form+"&formato=xlsx&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&usuario_envio="+$usuario_envio+"&usuario_aprueba="+$usuario_aprueba+"&req_id="+$req_id);
          $(this).prop("href","{{ route('admin.reportes_contratados_cliente_excel')}}?"+data_form+
          "&formato=xlsx&rango_fecha="+rango_fecha+
          "&req_id="+req_id);
      });

      /*$('#export_pdf_btn').click(function(e){
          $data_form = $('#filter_form').serialize();
          $fecha_inicio = $("#fecha_inicio").val();
          $fecha_final = $("#fecha_final").val();
          $cliente_id = $("#cliente_id").val();
          $criterio = $("#criterio").val();

          $(this).prop("href","{{ route('admin.reportes.reportes_detalles_excel') }}?"+$data_form+"&formato=pdf&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
      });*/
    })
</script>
@stop
