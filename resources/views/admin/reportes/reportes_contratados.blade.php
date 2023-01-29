@extends("admin.layout.master")
@section('contenedor')
<h3>
    <i aria-hidden="true" class="fa fa-file-text-o">
    </i>
    Reportes Contratados
</h3>
<hr/>
{!! Form::model(Request::all(),["route"=>"admin.reportes_contratados","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
<div class="col-md-6 form-group">
        <label class="col-sm-4 control-label" for="rango_fecha">Rango de fechas de envío a contratación:</label>
        <div class="col-sm-8">
            {!! Form::text("rango_fecha", null, ["class" => "form-control range","id" => "rango_fecha" , "autocomplete" => "off"]); !!}
        </div>
</div>

<div class="col-md-6 form-group">
        <label class="col-sm-4 control-label" for="rango_fecha">Rango de fechas de firma de contrato:</label>
        <div class="col-sm-8">
            {!! Form::text("rango_fecha_firma", null, ["class" => "form-control range","id" => "rango_fecha_firma" , "autocomplete" => "off"]); !!}
        </div>
</div>

<div class="col-md-6 form-group">
    <label class="col-sm-4 control-label" for="inputEmail3">
        Cliente:
    </label>
    <div class="col-sm-8">
        {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control","id"=>"cliente_id"]); !!}
    </div>
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-4 control-label" for="inputEmail3">
        Usuario contrata:
    </label>
    <div class="col-sm-8">
        {!! Form::select("usuario_envio",$usuarios_envio,null,["class"=>"form-control","id"=>"usuario_envio"]); !!}
    </div>
</div>
<div class="col-md-6 form-group">
    <label class="col-sm-4 control-label" for="inputEmail3">
        Usuario que aprueba:
    </label>
    <div class="col-sm-8">
        {!! Form::select("usuario_aprueba",$usuarios_aprueba,null,["class"=>"form-control","id"=>"usuario_aprueba"]); !!}
    </div>
</div>
<div class="col-md-6 form-group">
      <label class="col-sm-4 control-label" for="inputEmail3">
          #Req:
      </label>
      <div class="col-sm-8">
          {!! Form::text("req_id",null,["class"=>"form-control","placeholder"=>"Número de requerimiento","id"=>"req_id" ]); !!}
      </div>
  </div>

<div class="clearfix">
</div>
<input id="formato" name="formato" type="hidden" value="html"/>
<button class="btn btn-success" type="submit">
    Generar
</button>
<a class="btn btn-success" href="#" id="export_excel_btn" role="button">
    <i aria-hidden="true" class="fa fa-file-excel-o">
    </i>
    Excel
</a>

<a class="btn btn-warning" href="{{ route('admin.reportes_contratados') }}">
    Limpiar
</a>
<!--
<a class="btn btn-danger" href="#" id="export_pdf_btn" role="button">
    <i aria-hidden="true" class="fa fa-file-pdf-o">
    </i>
    PDF
</a>
-->
{!! Form::close() !!}

  
    @if(isset($data))
        @if($data!="vacio")
           @include('admin.reportes.includes.grilla_detalle_reportes_contratados')
       @endif
    @endif

<script>
    $(function () {

      $('#export_excel_btn').click(function(e){
          $data_form = $('#filter_form').serialize();
          $rango_fecha = $("#rango_fecha").val();
          $rango_fecha_firma = $("#rango_fecha_firma").val();
          $cliente_id = $("#cliente_id").val();
          $usuario_envio = $("#usuario_envio").val();
          $usuario_aprueba = $("#usuario_aprueba").val();
          $req_id = $("#req_id").val();

          $(this).prop("href","{{ route('admin.reportes_detalles_reportes_contratados_excel') }}?"+$data_form+"&formato=xlsx&rango_fecha="+$rango_fecha+"&rango_fecha_firma="+$rango_fecha_firma+"&cliente_id="+$cliente_id+"&usuario_envio="+$usuario_envio+"&usuario_aprueba="+$usuario_aprueba+"&req_id="+$req_id)
      });
      /*$('#export_pdf_btn').click(function(e){
          $data_form = $('#filter_form').serialize();
          $fecha_inicio = $("#fecha_inicio").val();
          $fecha_final = $("#fecha_final").val();
          $cliente_id = $("#cliente_id").val();
          $criterio = $("#criterio").val();

          $(this).prop("href","{{ route('admin.reportes_detalles_descarga_contratacion_excel') }}?"+$data_form+"&formato=pdf&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
      });*/
    })
</script>
@stop
