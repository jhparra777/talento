@extends("admin.layout.master")
@section("contenedor")

<h3>Lista de Estados</h3>
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
{!! Form::model(Request::all(),["id"=>"admin.estados.index","method"=>"GET"]) !!}

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">descripcion:</label>
    <div class="col-sm-10">
        {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>    
</div><div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">tipo:</label>
    <div class="col-sm-10">
        {!! Form::text("tipo",null,["class"=>"form-control","placeholder"=>"tipo" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo",$errors) !!}</p>    
</div><div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">cod_estado:</label>
    <div class="col-sm-10">
        {!! Form::text("cod_estado",null,["class"=>"form-control","placeholder"=>"cod_estado" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cod_estado",$errors) !!}</p>    
</div><div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">observaciones:</label>
    <div class="col-sm-10">
        {!! Form::text("observaciones",null,["class"=>"form-control","placeholder"=>"observaciones" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>    
</div>



<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.estados.index")}}" >Limpiar</a>
{!! FuncionesGlobales::valida_boton_req("admin.estados.editar","Editar","link","btn btn-warning",'onclick="return conf_registro(\'id[]\', this)"') !!}
{!! FuncionesGlobales::valida_boton_req("admin.estados.nuevo","Nuevo","link","btn btn-info") !!}

{!! Form::close() !!}


<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
           <th>descripcion</th><th>tipo</th><th>cod_estado</th><th>observaciones</th>
           
        </tr>
    </thead>
    <tbody>
        @if($listas->count() == 0)
        <tr>
            <td colspan="4">No se encontraron registros</td>
        </tr>
        @endif
        @foreach($listas as $lista)
        <tr>
            <td>{!! Form::checkbox("id[]",$lista->id,null,["data-url"=>route('admin.estados.editar',["id"=>$lista->id])]) !!}</td>
             <td>{{$lista->descripcion}}</td><td>{{$lista->tipo}}</td><td>{{$lista->cod_estado}}</td><td>{{$lista->observaciones}}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>
{!! $listas->appends(Request::all())->render() !!}
@stop