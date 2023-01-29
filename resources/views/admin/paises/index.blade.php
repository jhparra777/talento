@extends("admin.layout.master")
@section("contenedor")

<h3>Lista de Paises</h3>
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
{!! Form::model(Request::all(),["id"=>"admin.paises.index","method"=>"GET"]) !!}

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Nombre:</label>
    <div class="col-sm-10">
        {!! Form::text("nombre",null,["class"=>"form-control","placeholder"=>"nombre" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    
</div><div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Codigo DANE:</label>
    <div class="col-sm-10">
        {!! Form::text("cod_pais",null,["class"=>"form-control","placeholder"=>"cod_pais" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cod_pais",$errors) !!}</p>    
</div>



<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.paises.index")}}" >Limpiar</a>
{!! FuncionesGlobales::valida_boton_req("admin.paises.editar","Editar","link","btn btn-warning",'onclick="return conf_registro(\'id[]\', this)"') !!}
{!! FuncionesGlobales::valida_boton_req("admin.paises.nuevo","Nuevo","link","btn btn-info") !!}

{!! Form::close() !!}


<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
           <th>Nombre</th><th>Codigo DANE</th>
           
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
            <td>{!! Form::checkbox("id[]",$lista->id,null,["data-url"=>route('admin.paises.editar',["id"=>$lista->id])]) !!}</td>
             <td>{{$lista->nombre}}</td><td>{{$lista->cod_pais}}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>
{!! $listas->appends(Request::all())->render() !!}
@stop