@extends("admin.layout.master")
@section('contenedor')
  <h3>
    <i aria-hidden="true" class="fa fa-file-text-o"></i>
        Reporte Candidatos
  </h3>
<hr/>
@if(session()->has('mensaje'))
  <div class="alert alert-success">
    {{ session()->get('mensaje') }}
  </div>
@endif
{!! Form::model(Request::all(),["route"=>"admin.reportes_candidatos","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
 <div class="col-xs-12 alert alert-warning">

  <p style="text-align: center;"> Seleccione un requerimiento y dele click en generar para poder ver el reporte.</p>
 </div>
  
<br><br><br><br><br><br>
 <div class="col-md-6 form-group">
  <label for="inputEmail3" class="col-sm-3 control-label">Requerimiento:</label>
    <div class="col-sm-8">
    {!! Form::select("req_id",$requerimientos,null,["class"=>"form-control chosen1","id"=>"req_id" ]); !!}
    <p class="text-danger">{!! FuncionesGlobales::getErrorData("req_id",$errors) !!}</p>
    </div>
 </div>

      <div class="col-md-6 form-group">
        <label class="col-sm-2 control-label" for="inputEmail3">
          Usuario Gestión:
        </label>
        <div class="col-sm-10">
          {!! Form::select("usuario_gestion",$usuarios,null,["class"=>"form-control","id"=>"usuario_gestion"]); !!}
        </div>
      </div>

<input id="formato" name="formato" type="hidden" value="html"/>
<button class="btn btn-success" type="submit">
    Generar
</button>
<a class="btn btn-success" href="#" id="export_excel_btn" role="button">
  <i aria-hidden="true" class="fa fa-file-excel-o"></i>Excel </a>
<!--
<a class="btn btn-danger" href="#" id="export_pdf_btn" role="button">
    <i aria-hidden="true" class="fa fa-file-pdf-o">
    </i>
    PDF
</a>
-->
{!! Form::close() !!}
<br><br>
@if(isset($data))
   @include('admin.reportes.includes.grilla_detalle_candi')
@endif

<style >
  
#req{
    width: 300px !important;
}
.chosen-container .chosen-container-single{
    width: 300px !important;
}

</style>

<script>
  $(".chosen1").chosen();
   $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });

    $(function () {
      $("#fecha_actualizacion_fin").datepicker(confDatepicker);
      $("#fecha_actualizacion_ini").datepicker(confDatepicker);

      $('#export_excel_btn').click(function(e){
        
        $data_form = $('#filter_form').serialize();
        $requerimiento = $('#req_id').val();

        
        $(this).prop("href","{{ route('admin.reportes.reportes_detalles_candi_excel')}}?"+$data_form+"&formato=xlsx&req_id="+$requerimiento);
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
