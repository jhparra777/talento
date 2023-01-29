@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Reporte Aplicación de Ofertas</h3>
<hr/>
{!! Form::model(Request::all(),["id"=>"filter_form","method"=>"GET"]) !!}

<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Requerimiento:</label>
    <div class="col-sm-4">
        {!! Form::text("fecha_inicio_req",null,["class"=>"form-control","id"=>"fecha_a_inicio_req"]); !!}
    </div>
    <div class="col-sm-4">
        {!! Form::text("fecha_fin_req",null,["class"=>"form-control","id"=>"fecha_a_fin_req"]); !!}
    </div>   
</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Estado Requerimiento:</label>
    <div class="col-sm-9">
        <select name="estado_requerimiento" class="form-control">
         <option value="">Seleccionar</option>
            @foreach( $estado_req as $estado )
            <option value="{{$estado->estado_requerimiento}}">{{$estado->estado_requerimiento}}</option>
            @endforeach;
        </select>
    </div>   
</div>

<div class="clearfix"></div>
<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.reporte_aplica_oferta")}}" >Limpiar</a>
<a class="btn btn-success" href="#" role="button" target="_blank" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>

{!! Form::close() !!}
@include('admin.reportes.includes.grilla_general')
<script>
    $(function () {
        $("#fecha_a_inicio_req, #fecha_a_fin_req").datepicker(confDatepicker);

        $('#export_excel_btn').click(function (e) {
            $data_form = $('#filter_form').serialize();
            $(this).prop("href", "{{ route('admin.reporte_aplica_oferta_excel') }}?" + $data_form + "&formato=xlsx");
        });
    });
</script>
@stop