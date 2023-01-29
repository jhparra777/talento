@extends("admin.layout.master")
@section('contenedor')
<h3><i class="fa fa-line-chart" aria-hidden="true"></i> Reporte BD Cargos</h3>
<hr/>
{!! Form::model(Request::all(),["id"=>"filter_form","method"=>"GET"]) !!}

<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Registro:</label>
    <div class="col-sm-4">
    <small>Desde</small>
        {!! Form::text("fecha_a_inicio_req",null,["class"=>"form-control","id"=>"fecha_a_inicio_req"]); !!}
    </div>
    <div class="col-sm-4">
      <small>Hasta</small>
        {!! Form::text("fecha_a_fin_req",null,["class"=>"form-control","id"=>"fecha_a_fin_req"]); !!}
    </div>   
</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Ciudad Residencia:</label>
    <div class="col-sm-9">
        <select name="ciudad" class="form-control">
         <option value="">Seleccionar</option>
        @foreach( $ciudad_req as $ciudad )
          <option value="{{$ciudad->ciudad}}">{{$ciudad->ciudad}}</option>
        @endforeach;
        </select>
    </div>   
</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Género:</label>
    <div class="col-sm-9">
        <select name="genero" class="form-control">
         <option value="">Seleccionar</option>
        @foreach( $generos as $genero )
          <option value="{{$genero->t_genero}}">{{$genero->t_genero}}</option>
        @endforeach;
        </select>
    </div>   
</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Edad Mínima:</label>
    <div class="col-sm-9">
        <select name="edad_min" class="form-control">
            <option value="">Seleccionar</option>
            @foreach( $edad_minima as $edad_min )
            <option value="{{$edad_min}}">{{$edad_min}}</option>
            @endforeach;
        </select>
    </div>   
</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Edad Máxima:</label>
    <div class="col-sm-9">
        <select name="edad_max" class="form-control">
            <option value="">Seleccionar</option>
            @foreach( $edad_maxima as $edad_max )
            <option value="{{$edad_max}}">{{$edad_max}}</option>
            @endforeach;
        </select>
    </div>   
</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Tiene Experiencia:</label>
    <div class="col-sm-9">
        <select name="tiene_exp" class="form-control">
        <option value="">Seleccionar</option>
            @foreach( $tiene_experiencia as $tiene_exp )
            <option value="{{$tiene_exp}}">{{$tiene_exp}}</option>
            @endforeach;
        </select>
    </div>   
</div>

<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Cargo Desempeñado:</label>
    <div class="col-sm-6">
        {!! Form::text("cargo_desempenado",null,["class"=>"form-control","id"=>"cargo_desempenado"]); !!}
    </div> 
</div>
<div class="clearfix"></div>
<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.reporte_bd_cargos")}}">Limpiar</a>
<a class="btn btn-success" href="#" role="button" target="_blank" id="export_excel_btn"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>

{!! Form::close() !!}
@include('admin.reportes.includes.grilla_general')
<script>
    $(function () {
        $("#fecha_a_inicio_req, #fecha_a_fin_req, #fecha_c_inicio_req, #fecha_c_fin_req").datepicker(confDatepicker);
        
        $('#export_excel_btn').click(function (e) {
            $data_form = $('#filter_form').serialize();
            $(this).prop("href", "{{ route('admin.reporte_bd_cargos_excel') }}?" + $data_form + "&formato=xlsx");
        });
    });
</script>
@stop