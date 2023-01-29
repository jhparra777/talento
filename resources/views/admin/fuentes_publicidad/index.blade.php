@extends("admin.layout.master")
@section("contenedor")

<h3>Lista de Fuentes Publicidad</h3>
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {!!Session::get("mensaje_success")!!}
    </div>
</div>
@endif
{!! Form::model(Request::all(),["id"=>"admin.fuentes_publicidad.index","method"=>"GET"]) !!}

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">descripcion:</label>
    <div class="col-sm-10">
        {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>    
</div><div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">active:</label>
    <div class="col-sm-10">
        {!! Form::text("active",null,["class"=>"form-control","placeholder"=>"active" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("active",$errors) !!}</p>    
</div>



<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.fuentes_publicidad.index")}}" >Limpiar</a>
{!! FuncionesGlobales::valida_boton_req("admin.fuentes_publicidad.editar","Editar ","link","btn btn-warning",'onclick="return conf_registro(\'id[]\', this)"') !!}
{!! FuncionesGlobales::valida_boton_req("admin.fuentes_publicidad.nuevo","Nuevo ","link","btn btn-info") !!}

{!! Form::close() !!}


<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
           <th>descripcion</th><th>active</th>
           
        </tr>
    </thead>
    <tbody>
        @if($listas->count() == 0)
        <tr>
            <td colspan="2">No se encontraron registros</td>
        </tr>
        @endif
        @foreach($listas as $lista)
        <tr>
            <td>{!! Form::checkbox("id[]",$lista->id,null,["data-url"=>route('admin.fuentes_publicidad.editar',["id"=>$lista->id])]) !!}</td>
             <td>{{$lista->descripcion}}</td><td>{{$lista->active}}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>
{{ $listas->appends(Request::all())->render() }}
@stop