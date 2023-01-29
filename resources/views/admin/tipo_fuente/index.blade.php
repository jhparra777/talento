@extends("admin.layout.master")
@section("contenedor")

<h3>Lista de Tipo Fuente</h3>
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
{!! Form::model(Request::all(),["id"=>"admin.tipo_fuente.index","method"=>"GET"]) !!}

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Descripcion:</label>
    <div class="col-sm-10">
        {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>    
</div>


<div class="clearfix"></div>
<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.tipo_fuente.index")}}" >Limpiar</a>
{!! FuncionesGlobales::valida_boton_req("admin.tipo_fuente.editar","Editar Tipo Fuente","link","btn btn-warning",'onclick="return conf_registro(\'id[]\', this)"') !!}
{!! FuncionesGlobales::valida_boton_req("admin.tipo_fuente.nuevo","Nuevo Tipo Fuente","link","btn btn-info") !!}

{!! Form::close() !!}


<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
           <th>descripcion</th>
           
        </tr>
    </thead>
    <tbody>
        @if($listas->count() == 0)
        <tr>
            <td colspan="1">No se encontraron registros</td>
        </tr>
        @endif
        @foreach($listas as $lista)
        <tr>
            <td>{!! Form::checkbox("id[]",$lista->id,null,["data-url"=>route('admin.tipo_fuente.editar',["id"=>$lista->id])]) !!}</td>
             <td>{{$lista->descripcion}}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>
{!! $listas->appends(Request::all())->render() !!}
@stop