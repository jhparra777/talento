
@extends("admin.layout.master")
@section('contenedor')
<hr/>
{!! Form::model(Request::all(),["route"=>"admin.anexo_facturacion","method"=>"GET","accept-charset"=>"UTF-8"]) !!}
<h3>
   
   <div class="box-header with-border">
            <h3 class="box-title"> 
              <i aria-hidden="true" class="fa fa-file-text-o">
              </i> 
              FACTURACIÓN DE ANEXO
            </h3>
        </div>
</h3>

  <h4 class="box-header with-border">FILTROS</h4>
 <div class="col-md-6 form-group">
              <label class="col-sm-12 control-label" for="fecha_inicio">
                  Fecha Inicio:
              </label>
              <div class="col-sm-12">
                  {!! Form::text("fecha_inicio",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_inicio" ]); !!}
              </div>
          </div>
          <div class="col-md-6 form-group">
              <label class="col-sm-12 control-label" for="fecha_final">
                  Fecha Final:
              </label>
              <div class="col-sm-12">
                  {!! Form::text("fecha_final",null,["class"=>"form-control","placeholder"=>"Fecha Final","id"=>"fecha_final" ]); !!}
              </div>
          </div>
          <div class="col-md-6 form-group">
              <label class="col-sm-12 control-label" for="cliente">
                  Nombre Cliente:
              </label>
              <div class="col-sm-12">
                  {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control","id"=>"cliente" ]); !!}
              </div>
          </div>
          <div class="col-md-6 form-group">
              <label class="col-sm-12 control-label" for="estado">
                  Estado Facturación:
              </label>
              <div class="col-sm-12">
                  {!! Form::select("estado",$estado,null,["class"=>"form-control","id"=>"estado" ]); !!}
              </div>
          </div>
<div class="clearfix">
</div>
<input id="formato" name="formato" type="hidden" value="html"/>
<button class="btn btn-success" type="submit">
    Generar
</button>
<a class="btn btn-success" href="#" id="generar_excel" role="button">
    <i aria-hidden="true" class="fa fa-file-excel-o">
    </i>
    Excel
</a>
<a class="btn btn-danger" href="{{ route("admin.anexo_facturacion") }}" id="limpiar" role="button">
    <i aria-hidden="true" class="fa fa-reply-all">
    </i>
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
<br><br>
@if(isset($data))
   @include('admin.facturacion.anexo.grilla_detalle_fact')
@endif
<script type="text/javascript">
  $(function () {
    $("#fecha_inicio").datepicker(confDatepicker);
    $("#fecha_final").datepicker(confDatepicker);

    $('#generar_excel').click(function(e){
      $data_form = $('#filter_form').serialize();
      $fecha_inicio = $('#fecha_inicio').val();
      $fecha_final = $("#fecha_final").val();
      $cliente = $("#cliente").val();
      $estado = $("#estado").val();
      $(this).prop("href","{{ route('admin.anexo_facturacion_excel')}}?"+$data_form+"&formato=xlsx&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente="+$cliente+"&estado="+$estado);
    });
  })
  
  
</script>
@stop
