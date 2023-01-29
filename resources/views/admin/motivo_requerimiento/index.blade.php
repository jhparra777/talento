@extends("admin.layout.master")
@section("contenedor")

<h3>Lista de Motivo Requerimiento</h3>
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
{!! Form::model(Request::all(),["id"=>"admin.motivo_requerimiento.index","method"=>"GET"]) !!}
{!! Form::hidden('buscar', 'true') !!}
<div clas="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Descripción:</label>
        <div class="col-sm-10">
            {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"descripción" ]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>    
    </div>
    <div class="col-md-6 form-group">
        <div class="col-sm-10">
            <label for="active" class="control-label">
                {!! Form::checkbox("active",1,null,["id" => "active"]); !!}
                    Activo
            </label>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("active",$errors) !!}</p>    
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <button class="btn btn-warning" >Buscar</button>
        <a class="btn btn-warning" href="{{route("admin.motivo_requerimiento.index")}}" >Limpiar</a>
        
        {!! FuncionesGlobales::valida_boton_req("admin.motivo_requerimiento.editar","Editar ","link","btn btn-warning",'onclick="return conf_registro(\'id[]\', this)"') !!}
        
        {!! FuncionesGlobales::valida_boton_req("admin.motivo_requerimiento.nuevo","Nuevo","link","btn btn-info") !!}
    </div>
</div>
{!! Form::close() !!}


<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>Descripción</th>
            <th>Estado</th>

        </tr>
    </thead>
    <tbody>
        @if($listas->count() == 0)
        <tr>
            <td colspan="3" class="text-center">No se encontraron registros</td>
        </tr>
        @endif
        @foreach($listas as $lista)
        <tr>
            <td>
                {!! Form::checkbox("id[]",$lista->id,null,["data-url"=>route('admin.motivo_requerimiento.editar',["id"=>$lista->id])]) !!}
            </td>
            
            <td>
                {{$lista->descripcion}}
            </td>

            <td>
                @if($lista->active == 1)
                <span class="label label-success">Activo</span>
                @else
                <span class="label label-danger">Inactivo</span>
                @endif
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
{!! $listas->appends(Request::all())->render() !!}
@stop