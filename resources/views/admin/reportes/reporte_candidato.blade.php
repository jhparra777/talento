@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Reporte Candidatos</h3>
<hr/>
{!! Form::model(Request::all(),["id"=>"filter_form","method"=>"GET"]) !!}

<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Empresa:</label>
    <div class="col-sm-9">
        <select name="empresa" class="form-control">
            <option value="">Seleccionar</option>
            @foreach( $empresas as $emp )
            <option value="{{$emp->sociedad}}">{{$emp->nombre}}</option>
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
          <option value="{{$cliente->cliente_id}}">{{$cliente->nombre_cliente}}</option>
        @endforeach;
        </select>
    </div>   
</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Requerimiento:</label>
    <div class="col-sm-4">
    <small>Desde</small>
        {!! Form::text("fecha_inicio_req",null,["class"=>"form-control","id"=>"fecha_a_inicio_req"]); !!}
    </div>
    <div class="col-sm-4">
      <small>Hasta</small>
        {!! Form::text("fecha_fin_req",null,["class"=>"form-control","id"=>"fecha_a_fin_req"]); !!}
    </div>   
</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Motivo Requerimiento:</label>
    <div class="col-sm-9">
        <select name="motivo_requerimiento" class="form-control">
         <option value="">Seleccionar</option>
        @foreach( $motivo_req as $motivo )
          <option value="{{$motivo->id}}">{{$motivo->nombre}}</option>
        @endforeach;
        </select>
    </div>   
</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Ciudad Requerimiento:</label>
    <div class="col-sm-9">
        <select name="ciudad_requerimiento" class="form-control">
         <option value="">Seleccionar</option>
        @foreach( $ciudad_req as $ciudad )
          <option value="{{$ciudad->ciudad_requerimiento}}">{{$ciudad->ciudad_requerimiento}}</option>
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
            <option value="{{$estado->estado_id}}">{{$estado->estado}}</option>
            @endforeach;
        </select>
    </div>   
</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Fecha Cierre Requerimiento:</label>
    <div class="col-sm-4">
    <small>Desde</small>
        {!! Form::text("fecha_i_cierre_req",null,["class"=>"form-control","id"=>"fecha_c_inicio_req"]); !!}
    </div>
    <div class="col-sm-4">
    <small>Hasta</small>
        {!! Form::text("fecha_f_cierre_req",null,["class"=>"form-control","id"=>"fecha_c_fin_req"]); !!}
    </div> 
</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Quien Gestionó:</label>
    <div class="col-sm-9">
        <select name="gestiono" class="form-control">
         <option value="">Seleccionar</option>
            @foreach( $gestiono as $user )
            <option value="{{$user->id}}">{{$user->nombre}}</option>
            @endforeach;
        </select>
    </div>   
</div>
<div class="clearfix"></div>
<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.reporte_candidato")}}" >Limpiar</a>
<a class="btn btn-success" href="#" role="button" target="_blank" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>

{!! Form::close() !!}
@include('admin.reportes.includes.grilla_general')
<script>
    $(function () {
        $("#fecha_a_inicio_req, #fecha_a_fin_req, #fecha_c_inicio_req, #fecha_c_fin_req").datepicker(confDatepicker);
        
        $('#export_excel_btn').click(function (e) {
            $data_form = $('#filter_form').serialize();
            $(this).prop("href", "{{ route('admin.reporte_candidato_excel') }}?" + $data_form + "&formato=xlsx");
        });
    });
</script>
@stop