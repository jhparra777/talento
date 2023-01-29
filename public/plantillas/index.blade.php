@extends("admin.layout.master")
@section("contenedor")

<h3>Lista de {{titulo}}</h3>
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
{!! Form::model(Request::all(),["id"=>"{{route_index}}","method"=>"GET"]) !!}

{{campos}}



<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("{{route_index}}")}}" >Limpiar</a>
{!! FuncionesGlobales::valida_boton_req("{{ruta_editar}}","Editar Salario","link","btn btn-warning",'onclick="return conf_registro(\'id[]\', this)"') !!}
{!! FuncionesGlobales::valida_boton_req("{{route_nuevo}}","Nuevo Salario","link","btn btn-info") !!}

{!! Form::close() !!}


<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
           {{campos_tabla}}
           
        </tr>
    </thead>
    <tbody>
        @if($listas->count() == 0)
        <tr>
            <td colspan="{{numero_columnas}}">No se encontraron registros</td>
        </tr>
        @endif
        @foreach($listas as $lista)
        <tr>
            <td>{!! Form::checkbox("id[]",$lista->id,null,["data-url"=>route('{{ruta_editar}}',["id"=>$lista->id])]) !!}</td>
             {{campos_tabla2}}
            
        </tr>
        @endforeach
    </tbody>
</table>
{{ $listas->appends(Request::all())->render() }}
@stop