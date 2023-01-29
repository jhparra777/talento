@extends("admin.layout.master")
@section('contenedor')
<h3>Lista Usuarios</h3>

@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif


{!! Form::model(Request::all(),["id"=>"admin.usuarios_sistema","method"=>"GET"]) !!}
<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Usuario:</label>
    <div class="col-sm-9">
        {!! Form::text("email",null,["class"=>"form-control","placeholder"=>"Usuario"]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    

</div>
{{--<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Nombre:</label>
    <div class="col-sm-9">
        {!! Form::text("name",null,["class"=>"form-control","placeholder"=>"Nombre"]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    

</div>--}}
<div class="col-md-3  form-group">
    <label for="inputEmail3" class="col-sm-6 control-label">Modulo Administrador:</label>
    <div class="col-sm-6">
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary btn-xs {{ ((Request::get("mod_admin")==1)?"active":"") }}">

                {!! Form::radio("mod_admin",1,null,["autocomplete"=>"off"]) !!} SI
            </label>
            <label class="btn btn-primary btn-xs {{ ((Request::get("mod_admin")==2)?"active":"") }} ">
                {!! Form::radio("mod_admin",2,true,["autocomplete"=>"off"]) !!}  N/A
            </label>
            <label class="btn btn-primary btn-xs {{ ((Request::get("mod_admin")==3)?"active":"") }}">
                {!! Form::radio("mod_admin",3,null,["autocomplete"=>"off"]) !!} NO
            </label>
        </div>
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    

</div>
<div class="col-md-3  form-group">
    <label for="inputEmail3" class="col-sm-6 control-label">Modulo Requisiciones:</label>
    <div class="col-sm-6">

        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary btn-xs {{ ((Request::get("mod_req")==1)?"active":"") }} ">

                {!! Form::radio("mod_req",1,null,["autocomplete"=>"off"]) !!} SI
            </label>
            <label class="btn btn-primary btn-xs {{ ((Request::get("mod_req")==2)?"active":"") }} ">
                {!! Form::radio("mod_req",2,true,["autocomplete"=>"off"]) !!}  N/A
            </label>
            <label class="btn btn-primary btn-xs {{ ((Request::get("mod_req")==3)?"active":"") }}">
                {!! Form::radio("mod_req",3,null,["autocomplete"=>"off"]) !!} NO
            </label>
        </div>

    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    

</div>
<div class="col-md-3  form-group">
    <label for="inputEmail3" class="col-sm-6 control-label">Modulo Hoja de vida:</label>
    <div class="col-sm-6">
        <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary btn-xs {{((Request::get("mod_hv")==1)?"active":"")}}" >

                {!! Form::radio("mod_hv",1,null,["autocomplete"=>"off"]) !!} SI
            </label>
            <label class="btn btn-primary btn-xs {{ ((Request::get("mod_hv")==2)?"active":"") }} ">
                {!! Form::radio("mod_hv",2,true,["autocomplete"=>"off"]) !!}  N/A
            </label>
            <label class="btn btn-primary btn-xs {{ ((Request::get("mod_hv")==3)?"active":"") }} ">
                {!! Form::radio("mod_hv",3,null,["autocomplete"=>"off"]) !!} NO
            </label>
        </div>
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    

</div>

<div class="col-md-3  form-group">
    <label for="inputEmail3" class="col-sm-6 control-label">Todos Los Usuarios:</label>
    <div class="col-sm-6">
        {!! Form::checkbox("todos",1,null,["class"=>"form-control checkbox-preferencias","placeholder"=>"Nombre"]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    

</div>

<div class="clearfix"></div>
<button class="btn btn-warning" >Buscar</button>
<a class="btn btn-warning" href="{{route("admin.usuarios_sistema")}}" >Limpiar</a>
<a class="btn btn-info" href="Javascript:;" onclick="return conf_registro('user_id[]', this)">Editar Usuario</a>
{!! Form::close() !!}
<div class="table-responsive ">


    <table class="table table-bordered">
        <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Modulos</th>

            </tr>
        </thead>
        <tbody>

            @foreach($usuarios as $usuario)
            <tr>
                <td>
                    {!! Form::checkbox("user_id[]",$usuario->id,null,["data-url"=>route('admin.editar_user_sistema',["user_id"=>$usuario->id])]) !!}

                </td>
                <td>{{$usuario->name}}</td>
                <td>{{$usuario->email}}</td>
                <td>
                    
                    @if($usuario->inRole("admin"))
                    <span class="badge"> Administración</span>
                    @endif
                    @if($usuario->inRole("req"))
                    <span class="badge">Requisición</span>
                    @endif
                    @if($usuario->inRole("hv"))
                    <span class="badge">Hoja de vida</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- $usuarios->appends(Request::all())->render() !!}-->
@stop