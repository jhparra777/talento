@extends("admin.layout.master")
@section("contenedor")

<h3 class="page-header"><i class="fa fa-cubes" aria-hidden="true"></i> Fichas</h3>
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
{!! Form::model(Request::all(),["id"=>"admin.fichas_index","method"=>"GET"]) !!}

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Clientes:</label>
    <div class="col-sm-9">
        {!! Form::select("cliente_id",$clientes,null,["class"=>"form-control"]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cliente_id",$errors) !!}</p>    
</div>
<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Estado:</label>
    <div class="col-sm-10">

        {!! Form::select("active",[""=>"Seleccionar","1"=>"Activo","0"=>"Inactivo"],null,["class"=>"form-control" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("active",$errors) !!}</p>    
</div>
<button class="btn btn-warning">Buscar <i class="fa fa-search" aria-hidden="true"></i></button>

<a class="btn btn-warning" href="{{route("admin.listar_fichas")}}" >Limpiar</a>
{!! FuncionesGlobales::valida_boton_req("admin.editar_ficha",'<i class="fa fa-pen" aria-hidden="true"></i> Editar Ficha',"link","btn btn-warning",'onclick="return conf_registro(\'id[]\', this)"') !!}
{!! FuncionesGlobales::valida_boton_req("admin.ficha_export_pdf",'<i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF Ficha',"link","btn btn-info",["target"=>"_blank",'onclick'=>'return redireccionar_registro("id[]", this,"url-pdf")']) !!}
{!! FuncionesGlobales::valida_boton_req("admin.nueva_ficha",'<i class="fa fa-plus-circle" aria-hidden="true"></i> Nueva Ficha',"link","btn btn-info") !!}

{!! Form::close() !!}


<table class="table table-bordered">
    <thead>
        <tr>
            <th></th>
            <th>Código</th>
            <th>Cliente</th>
            <th>Cargo Cliente</th>
            <th>Criticidad</th>
            <th>Género</th>
            <th>Escolaridad</th>
            <th>Activa/Inactiva</th>
        </tr>
    </thead>
    <tbody>
        @if($fichas->count() == 0)
        <tr>
            <td colspan="2">No se encontraron registros</td>
        </tr>
        @endif
         
        @foreach($fichas as $ficha)
        <tr>
            <td>{!! Form::checkbox("id[]",$ficha->id,null,["data-url"=>route('admin.editar_ficha',["id"=>$ficha->id]),"data-url-pdf"=>route('admin.ficha_export_pdf',["id"=>$ficha->id])]) !!}</td>
            <td>{{$ficha->id}}</td>
            <td>{{$ficha->nombre}}</td>
            <td>{{$ficha->cargo_especifico}}</td>
            <td>{{$ficha->criticidad_cargo}}</td>
            <td>{{$ficha->descripcion_genero}}</td>
            <td>{{$ficha->descripcion_escolaridad}}</td>
            <td>{{$ficha->getEstadoDescr()}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{!!  $fichas->appends(Request::all())->render() !!}
@stop