@extends("admin.layout.master")
@section("contenedor")

<h3>Lista de Aspiración Salarial</h3>
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
{!! Form::model(Request::all(),["id"=>"admin.aspiracion_salarial.index","method"=>"GET"]) !!}

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Descripción:</label>
    <div class="col-sm-9">
        {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>    
</div>
<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Estado:</label>
    <div class="col-sm-10">
        
        {!! Form::select("active",[""=>"Seleccionar","1"=>"Activo","0"=>"Inactivo"],null,["class"=>"form-control" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("active",$errors) !!}</p>    
</div>



<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.aspiracion_salarial.index")}}" >Limpiar</a>
{!! FuncionesGlobales::valida_boton_req("admin.aspiracion_salarial.editar","Editar","link","btn btn-warning",'onclick="return conf_registro(\'id[]\', this)"') !!}
{!! FuncionesGlobales::valida_boton_req("admin.aspiracion_salarial.nuevo","Nuevo","link","btn btn-info") !!}

{!! Form::close() !!}


<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
           <th>Descripción</th><th>active</th>
           
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
            <td>{!! Form::checkbox("id[]",$lista->id,null,["data-url"=>route('admin.aspiracion_salarial.editar',["id"=>$lista->id])]) !!}</td>
             <td>{{$lista->descripcion}}</td>
             <td>{{$lista->fullEstado()}}</td>
            
        </tr>
        @endforeach
    </tbody>
</table>
{!!  $listas->appends(Request::all())->render() !!}
@stop