@extends("admin.layout.master")
@section("contenedor")

<h3>Lista de Tipos Jornadas</h3>
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
{!! Form::model(Request::all(),["id"=>"admin.tipos_jornadas.index","method"=>"GET"]) !!}

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">descripcion:</label>
    <div class="col-sm-10">
        {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>    
</div><div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Estado:</label>
    <div class="col-sm-10">
        {!! Form::select("active",[""=>"Seleccionar","1"=>"Activo","0"=>"Inactivo"],null,["class"=>"form-control" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("active",$errors) !!}</p>    
</div>



<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.tipos_jornadas.index")}}" >Limpiar</a>
{!! FuncionesGlobales::valida_boton_req("admin.tipos_jornadas.editar","Editar Tipo Jornada","link","btn btn-warning",'onclick="return conf_registro(\'id[]\', this)"') !!}
{!! FuncionesGlobales::valida_boton_req("admin.tipos_jornadas.nuevo","Nuevo Tipo Jornada","link","btn btn-info") !!}

{!! Form::close() !!}


<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
           <th>descripcion</th><th>active</th><th>hora_inicio</th><th>hora_fin</th><th>procentaje_horas</th>
           
        </tr>
    </thead>
    <tbody>
        @if($listas->count() == 0)
        <tr>
            <td colspan="5">No se encontraron registros</td>
        </tr>
        @endif
        @foreach($listas as $lista)
        <tr>
            <td>{!! Form::checkbox("id[]",$lista->id,null,["data-url"=>route('admin.tipos_jornadas.editar',["id"=>$lista->id])]) !!}</td>
             <td>{{$lista->descripcion}}</td>
             <td>{{$lista->fullEstado()}}</td>
             <td>{{$lista->hora_inicio}}</td><td>{{$lista->hora_fin}}</td><td>{{$lista->procentaje_horas}}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>
{!! $listas->appends(Request::all())->render() !!}
@stop