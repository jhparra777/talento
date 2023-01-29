@extends("admin.layout.master")
@section("contenedor")

<h3>Usuarios Clientes</h3>
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
{!! Form::model(Request::all(),["id"=>"admin.lista_agencias","method"=>"GET"]) !!}
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Criterio de Búsqueda</label>
    <div class="col-sm-9">
        {!! Form::text("email",null,["class"=>"form-control","placeholder"=>"ej. cedula, email, nombre"]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    

</div>
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Cliente</label>
    <div class="col-sm-9">
        {!! Form::select("agencia_id",$agencias,null,["class"=>"form-control"]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    

</div>
<div class="clearfix"></div>
<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.usuarios_clientes")}}" >Limpiar</a>
<a class="btn btn-info" id="edit_agencia" href="#" >Editar Usuario Agencia</a>

{!! Form::close() !!}
<div class="clearfix"></div>
<div class="table-responsive">
    <table class="table table-bordered">

        <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Clientes</th>
            </tr>
        </thead>
        <tbody>
            @if($usuarios->count()==0)
            <tr>
                <td colspan="4">No se encontraron resultados</td>
            </tr>
            @endif
            @foreach($usuarios as $usuario)
            <tr>
             <td>
                {!! Form::checkbox("user_id[]",$usuario->id,null,["data-url"=>route('admin.editar_user',["user_id"=>$usuario->id,]),"class"=>"id_user"]) !!}

            </td>
                <td>{{$usuario->name}}</td>
                <td>{{$usuario->email}}</td>
                <td><span class="badge"> {!! str_replace(",", '</span><span class="badge">', $usuario->clientes_nombre) !!}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- $usuarios->appends(Request::all())->render() !!} -->
@stop

<script>
    
    $("#edit_agencia").on("click", function () {
        alert();
        if($(".id_user").prop("checked", obj.prop("checked"))){
         
         var url = $('.id_user').data('url');
        }

        alert(url);
    });
  

</script>