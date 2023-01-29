@extends("admin.layout.master")
@section('contenedor')


{!! Form::model($rol,["route"=>"admin.actualizar_rol","id"=>"frm_usuarios","method"=>"POST","autocomplete"=>"off"]) !!}

{!! Form::hidden("id") !!}



<div class="clearfix"></div>
<div class="">
    <br>
    @if(Session::has("mensaje_success"))
    <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get("mensaje_success")}}
        </div>
    </div>
    @endif
    <div class="col-md-6">
        <h3>Editar   Rol</h3>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Nombre:</label>
            <div class="col-sm-10">
                {!! Form::text("name",null,["class"=>"form-control","placeholder"=>"Nombre" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("name",$errors) !!}</p>
        </div>
        <a href="{{route("admin.lista_roles")}}" class="btn btn-warning">Volver</a>
        <button class="btn btn-success">Actualizar</button>
    </div>

    <div class="col-md-6">
        <h3>Permisos </h3>
        <div class="checkbox">
            <label>
                {!! Form::checkbox("seleccionar_todos_admin",null,false,["id"=>"seleccionar_todos_admin"]) !!} Seleccionar todos
            </label>
        </div>
        
        {!! FuncionesGlobales::getPermisosAdmin(0,$rol->permissions) !!}
    </div>

    <div class="clearfix"></div>




</div>
{!! Form::close()    !!}


<script>
    $(function () {
        $("#seleccionar_todos").on("change", function () {
            var obj = $(this);
            $("input[name='permiso[]']").prop("checked", obj.prop("checked"));
        });
        $("#seleccionar_todos_admin").on("change", function () {
            var obj = $(this);
            console.log($(".valor_true"));
            $("input[type='radio']").prop("checked", false);

        });
        $(".padre, .padre0").on("change", function () {
            var obj = $(this);
            console.log(obj.data("id"));
            $(".padre" + obj.data("id") + "").prop("checked", obj.prop("checked"));
        });


    });
</script>

@stop