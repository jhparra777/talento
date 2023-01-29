@extends("admin.layout.master")
@section('contenedor')
<h3>Lista de Perfiles de candidatos</h3>
<br>
{!! Form::model(Request::all(),["route"=>"admin.lista_perfil_bd","method"=>"GET"]) !!}
 @if(Session::has("errores_global") && count(Session::get("errores_global")) > 0)
        <div class="col-md-12" id="mensaje-resultado">
            <div class="divScroll">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                @foreach(Session::get("errores_global") as $key => $value)
                <p>EL registro de la fila numero {{++$key}} tiene los siguientes errores</p>
                <ul>
                    @foreach($value as $key2 => $value2)
                    <li>{{$value2}}</li>
                    @endforeach
                </ul>
                @endforeach
            </div>
            </div>
        </div>
    @endif

@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Perfiles:</label>
    <div class="col-sm-10">
        {!! Form::select("perfil_id",$perfil_candidato,null,["class"=>"form-control" ]); !!}
    </div>
</div>
	

	<div class="col-md-6 form-group">
    <label class="col-sm-2 control-label" for="inputEmail3">
        Ciudad Nacimiento
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

<div class="clearfix"></div>
{!! Form::submit("Buscar",["class"=>"btn btn-success"]) !!}
<a class="btn btn-danger" href="{{route("admin.lista_perfil_bd")}}">Limpiar</a>
{!! Form::close() !!}
<br><br><br>
{!! Form::model(Request::all(),["route"=>"admin.enviar_requerimiento","method"=>"POST"]) !!}
<div class="clearfix"></div>

{!! Form::submit("Enviar a requerimiento",["style"=>"position:relative; left:-30px; top:-5px;","class"=>"btn btn-primary"]) !!}

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Requerimiento:</label>
    <div class="col-sm-8">
        {!! Form::select("req_id",$requerimientos,null,["class"=>"form-control chosen1" ]); !!}
        <p class="text-danger">{!! FuncionesGlobales::getErrorData("req_id",$errors) !!}</p>
    </div>
</div>

<br>

<div class="clearfix"></div>
<div class="tabla table-responsive">
    <table class="table table-bordered table-hover ">
        <thead>
            <tr>
            	<th></th>
            	<th><div class="checkbox" style="top:10px;">
				{!! Form::checkbox("seleccionar_todos",null,false,["id"=>"seleccionar_todos"]) !!} Seleccionar
				</div></th>
                <th>Perfil</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Ciudad Nacimiento</th>
                <th>Telefono Móvil</th>
                <th>Cédula</th>
                <th>Edad</th>
                <th>Email</th>
                <th>Fecha Carga</th>
                <th>Direccion</th>
                <!--<th>Usuario Carga</th>-->
            </tr>
        </thead>
        <tbody>
            @if($perfiles->count() == 0)
            <tr>
                <td colspan="5">No se encontraron registros</td>
            </tr>
            @endif

            @foreach($perfiles as $key => $perfil)
            <tr>
            	 <td>{{++$key }}</td>
                
            	<td>
                {!! Form::checkbox("user_id[]",$perfil->user_id,null,["data-url"=>route('admin.editar_cliente'),"style"=>'text-align: center;']) !!}
                 <p class="text-danger">{!! FuncionesGlobales::getErrorData("user_id",$errors) !!}</p>
               </td>
                <td>{{ $perfil->descripcion }}</td>
                <td>{{ strtoupper($perfil->nombres) }}</td>
                <td>{{ strtoupper($perfil->primer_apellido." ".$perfil->segundo_apellido) }}</td>
                <td>{{ $perfil->ciudad }}</td>
                <td>{{ $perfil->telefono_movil }}</td>
                <td>{{ $perfil->numero_id }}</td>
                <td>{{ $perfil->edad }}</td>
                <td>{{ $perfil->email }}</td>
                <td>{{ $perfil->fecha }}</td>
                <td>{{ $perfil->direccion }}</td>
               <!-- <td>{ $perfil->usuario_gestiono }}</td>-->
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
<div>
    {!!$perfiles->appends(Request::all())->render() !!}
</div>
{!! Form::close() !!}
<script>

     $(".chosen1").chosen();

    $("#seleccionar_todos").on("change", function () {
            var obj = $(this);
            $("input[name='user_id[]']").prop("checked", obj.prop("checked"));
        });


	$("#fecha_actualizacion_fin").datepicker(confDatepicker);
      $("#fecha_actualizacion_ini").datepicker(confDatepicker);

       $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });
</script>

<style >
	




.chosen-container-multi .chosen-choices li.search-field input[type="text"]{
  height: 30px !important;
}

</style>

@stop