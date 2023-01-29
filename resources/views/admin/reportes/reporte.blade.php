@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Indicadores</h3>
<hr/>
<form id="filter_form" method="GET" action="{{ route('admin.reportes_indicadores') }}" accept-charset="UTF-8">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Inicio:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" placeholder="Fecha Inicio" name="fecha_inicio" id="fecha_inicio">
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fecha Final:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" placeholder="Fecha Final" name="fecha_final" id="fecha_final">
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Cliente:</label>
        <div class="col-sm-10">
           {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control" ]); !!}
        </div>
    </div>
    <div class="clearfix"></div>
    <button type="submit" class="btn btn-success">Generar</button>
    <a class="btn btn-success" href="#" role="button" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
    <a class="btn btn-danger" href="#" role="button" id="export_pdf_btn"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
</form>
</br>
@if(isset($report_name))
<div class="container">
    <div class="row">
        <div class="col-md-12 col-xs-6">
            <div class="" id="pos_graph">
                
            </div>
            {!! \Lava::render($tipo_chart, $report_name, 'pos_graph') !!}
        </div>
    </div>
</div>
@endif
@if(isset($data))
 @include('admin.reportes.includes.grilla')
@endif

<script>


    $(function () {

    
      $("#fecha_inicio, #fecha_final").datepicker(confDatepicker);
      
      $('#export_excel_btn').click(function(e){
          $data_form = $('#filter_form').serialize();
          $(this).prop("href","{{ route('admin.reportes.reporte-excel-indicadores') }}?"+$data_form+"&formato=xlsx" );
      });
      $('#export_pdf_btn').click(function(e){
          $data_form = $('#filter_form').serialize();
          $(this).prop("href","{{ route('admin.reportes.reporte-excel-indicadores') }}?"+$data_form+"&formato=pdf" );
      });
    });
    
 </script>
 @stop