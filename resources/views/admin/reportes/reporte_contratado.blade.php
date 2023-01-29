@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i>Reporte Contratados</h3>
<hr/>
{!! Form::model(Request::all(),["id"=>"filter_form","method"=>"GET"]) !!}

<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Contratación:</label>
    <div class="col-sm-4">
        {!! Form::text("fecha_inicio_con",null,["class"=>"form-control","id"=>"fecha_inicio_con"]); !!}
    </div>
    <div class="col-sm-4">
        {!! Form::text("fecha_fin_con",null,["class"=>"form-control","id"=>"fecha_fin_con"]); !!}
    </div>   
</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Ciudad Requerimiento:</label>
    <div class="col-sm-9">
        <select name="ciudad_requerimiento" class="form-control">
            <option value="">Seleccionar</option>
            @foreach( $ciudad_req as $ciudad )
            <option value="{{$ciudad->ciudad_req}}">{{$ciudad->ciudad_req}}</option>
            @endforeach;
        </select>
    </div>   
</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Cliente:</label>
    <div class="col-sm-9">
        <select name="cliente" class="form-control">
         <option value="">Seleccionar</option>
        @foreach( $clientes as $cliente )
          <option value="{{$cliente->cliente_id}}">{{$cliente->cliente}}</option>
        @endforeach;
        </select>
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
<a class="btn btn-warning" href="{{route("admin.reporte_contratado")}}" >Limpiar</a>
<a class="btn btn-success" href="#" role="button" target="_blank" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>

{!! Form::close() !!}
@include('admin.reportes.includes.grilla_general')
<script>
    $(function () {
        $("#fecha_inicio_con, #fecha_fin_con").datepicker(confDatepicker);

        $('#export_excel_btn').click(function (e) {
            $data_form = $('#filter_form').serialize();
            $(this).prop("href", "{{ route('admin.reporte_contratado_excel') }}?" + $data_form + "&formato=xlsx");
        });
    });
</script>
@stop